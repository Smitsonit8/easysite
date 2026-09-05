<?php

use Bitrix\Main\Application;
use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Sporina\EasySite\Settings;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

Loc::loadMessages(__FILE__);

/** HTTP adapter for the declarative Sporina Easy Site settings service. */
class SporinaSystemSettingsComponent extends CBitrixComponent
{
    public const MODE_RENDER = 'render';
    public const MODE_CONFIGURE = 'configure';
    public const ACTION_VARIABLE = 'sporina-system-settings-action';
    public const DISPLAY_FOR_ALL = 'all';
    public const DISPLAY_FOR_AUTHORIZED = 'authorized';

    private const SESSION_CATEGORY = 'sporina-system-settings-category';

    public function onPrepareComponentParams($params)
    {
        $params['MODE'] = isset($params['MODE']) ? (string) $params['MODE'] : self::MODE_RENDER;
        $params['ACTION_VARIABLE'] = !empty($params['ACTION_VARIABLE'])
            ? (string) $params['ACTION_VARIABLE']
            : self::ACTION_VARIABLE;
        $params['DISPLAY_FOR'] = isset($params['DISPLAY_FOR'])
            ? (string) $params['DISPLAY_FOR']
            : self::DISPLAY_FOR_AUTHORIZED;
        if (!in_array($params['DISPLAY_FOR'], [self::DISPLAY_FOR_ALL, self::DISPLAY_FOR_AUTHORIZED], true)) {
            $params['DISPLAY_FOR'] = self::DISPLAY_FOR_AUTHORIZED;
        }
        $params['PROFILE'] = isset($params['PROFILE']) && preg_match('/^[a-z0-9_]{1,64}$/', (string) $params['PROFILE'])
            ? (string) $params['PROFILE']
            : 'sporina_easy_site';

        return $params;
    }

    public function executeComponent()
    {
        if (!Loader::includeModule('sporina.easysite')) {
            return null;
        }

        $request = Context::getCurrent()->getRequest();
        $actionVariable = $this->arParams['ACTION_VARIABLE'];
        if (
            $this->arParams['MODE'] === self::MODE_CONFIGURE
            && $request->isPost()
            && $request->getPost($actionVariable) !== null
        ) {
            $this->processAction((string) $request->getPost($actionVariable));

            return null;
        }

        if ($this->arParams['MODE'] === self::MODE_RENDER) {
            return Settings::getAll($this->arParams['PROFILE']);
        }

        if ($this->arParams['MODE'] === self::MODE_CONFIGURE && $this->canConfigure()) {
            $this->arResult = [
                'SETTINGS' => Settings::getAll($this->arParams['PROFILE']),
                'PANEL' => Settings::getPanel($this->arParams['PROFILE']),
                'ACTIVE_CATEGORY' => $this->loadActiveCategory(),
                'ACTION_VARIABLE' => $actionVariable,
            ];
            $this->IncludeComponentTemplate();
        }

        return null;
    }

    private function processAction(string $action): void
    {
        if (!$this->canConfigure()) {
            $this->sendJson(['success' => false, 'error' => 'Forbidden'], 403);
        }
        if (!check_bitrix_sessid()) {
            $this->sendJson(['success' => false, 'error' => 'Bad request'], 400);
        }

        try {
            switch ($action) {
                case 'apply':
                    $settings = Context::getCurrent()->getRequest()->getPost('settings');
                    if ($settings === null) {
                        $settings = [];
                    }
                    if (!is_array($settings)) {
                        throw new InvalidArgumentException('Settings must be an array');
                    }
                    Settings::apply($settings, $this->arParams['PROFILE']);
                    $this->sendJson(['success' => true, 'settings' => Settings::getAll($this->arParams['PROFILE'])]);
                    break;

                case 'reset':
                    Settings::reset($this->arParams['PROFILE']);
                    $this->sendJson(['success' => true, 'settings' => Settings::getAll($this->arParams['PROFILE'])]);
                    break;

                case 'upload-logo':
                    $files = Context::getCurrent()->getRequest()->getFile('settings');
                    if (!is_array($files) || !isset($files['name']['template-logo'])) {
                        throw new InvalidArgumentException('Файл логотипа не передан.');
                    }
                    $file = [
                        'name' => $files['name']['template-logo'] ?? '',
                        'type' => $files['type']['template-logo'] ?? '',
                        'tmp_name' => $files['tmp_name']['template-logo'] ?? '',
                        'error' => $files['error']['template-logo'] ?? UPLOAD_ERR_NO_FILE,
                        'size' => $files['size']['template-logo'] ?? 0,
                    ];
                    Settings::saveLogo($file, $this->arParams['PROFILE']);
                    $this->sendJson(['success' => true, 'logoUrl' => Settings::getLogoUrl($this->arParams['PROFILE'])]);
                    break;

                case 'reset-logo':
                    Settings::resetLogo($this->arParams['PROFILE']);
                    $this->sendJson(['success' => true, 'logoUrl' => Settings::getLogoUrl($this->arParams['PROFILE'])]);
                    break;

                case 'remember-section':
                    $section = Context::getCurrent()->getRequest()->getPost('section');
                    if (!is_string($section) || !preg_match('/^[a-z0-9_-]{1,100}$/i', $section)) {
                        throw new InvalidArgumentException('Invalid section');
                    }
                    Application::getInstance()->getSession()->set(self::SESSION_CATEGORY, $section);
                    $this->sendJson(['success' => true, 'section' => $section]);
                    break;

                default:
                    throw new InvalidArgumentException('Unknown action');
            }
        } catch (InvalidArgumentException | RuntimeException $exception) {
            $this->sendJson(['success' => false, 'error' => $exception->getMessage()], 400);
        } catch (Throwable $exception) {
            $this->sendJson(['success' => false, 'error' => 'Internal server error'], 500);
        }
    }

    private function loadActiveCategory(): string
    {
        $value = Application::getInstance()->getSession()->get(self::SESSION_CATEGORY);

        return is_string($value) ? $value : '';
    }

    private function canConfigure(): bool
    {
        global $USER;

        if ($this->arParams['DISPLAY_FOR'] === self::DISPLAY_FOR_ALL) {
            return true;
        }

        return is_object($USER) && $USER->IsAuthorized();
    }

    private function sendJson(array $payload, int $status = 200): void
    {
        global $APPLICATION;

        $APPLICATION->RestartBuffer();
        Context::getCurrent()->getResponse()->setStatus($status);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        die();
    }
}
