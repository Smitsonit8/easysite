<?php
/**
 * Скрипт для создания типа инфоблока и инфоблока
 * 
 */

namespace Sporina\Easy_site;

define('DEBUG_FILE_NAME', 'debug.txt');

class Create_infoblocks
{
    /**
     * Возвращает ID сайта по умолчанию.
     */
    private function getDefaultSiteId(): string
    {
        $siteId = 's1';
        $rsSites = \CSite::GetList('', '', array('DEFAULT' => 'Y'));
        if ($arSite = $rsSites->Fetch()) {
            $siteId = $arSite['LID'];
        }

        return $siteId;
    }

    // Конфигурации инфоблоков
    private $iblocksConfig = array(
        array(
        'type' => array(
            'ID' => 'advertising_bannerss',
            'SECTIONS' => 'Y',
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'IN_RSS' => 'N',
            'SORT' => 100,
            'LANG' => array(
                'ru' => array(
                    'NAME' => 'Рекламные баннеры',
                    'SECTION_NAME' => 'Разделы',
                    'ELEMENT_NAME' => 'Баннеры',
                    'ELEMENT_ADD' => 'Добавить баннер',
                    'ELEMENT_EDIT' => 'Изменить баннер',
                    'ELEMENT_DELETE' => 'Удалить баннер',
                    'SECTION_ADD' => 'Добавить раздел',
                    'SECTION_EDIT' => 'Изменить раздел',
                    'SECTION_DELETE' => 'Удалить раздел',
                ),
                'en' => array(
                    'NAME' => 'Advertising Banners',
                    'SECTION_NAME' => 'Sections',
                    'ELEMENT_NAME' => 'Banners',
                    'ELEMENT_ADD' => 'Add banner',
                    'ELEMENT_EDIT' => 'Edit banner',
                    'ELEMENT_DELETE' => 'Delete banner',
                    'SECTION_ADD' => 'Add section',
                    'SECTION_EDIT' => 'Edit section',
                    'SECTION_DELETE' => 'Delete section',
                ),
            ),
        ),
        'iblock' => array(
            'ACTIVE' => 'Y',
            'NAME' => 'Рекламные баннеры',
            'CODE' => 'advertising_bannerss',
            'IBLOCK_TYPE_ID' => 'advertising_bannerss',
            'SORT' => 100,
            'LIST_PAGE_URL' => '',
            'SECTION_PAGE_URL' => '',
            'DETAIL_PAGE_URL' => '',
            'INDEX_ELEMENT' => 'Y',
            'INDEX_SECTION' => 'Y',
            'WORKFLOW' => 'N',
            'BIZPROC' => 'N',
            'GROUP_ID' => array(
                2 => 'R', // Для всех пользователей - чтение
            ),
            'ELEMENT_CODE' => array(
                'UNIQUE' => 'Y',
                'CHECK_UNIQUE' => 'Y',
                'TRANSLITERATION' => 'Y',
                'TRANS_LEN' => 100,
                'TRANS_CASE' => 'L',
                'TRANS_SPACE' => '-',
                'TRANS_OTHER' => '-',
                'TRANS_EAT' => 'Y',
                'USE_GOOGLE' => 'N',
            ),
            'FIELDS' => array(
                'CODE' => array(
                    'IS_REQUIRED' => 'Y',
                    'DEFAULT_VALUE' => array(
                        'TRANSLITERATION' => 'Y',
                        'TRANS_LEN' => 100,
                        'TRANS_CASE' => 'L',
                        'TRANS_SPACE' => '-',
                        'TRANS_OTHER' => '-',
                        'TRANS_EAT' => 'Y',
                    ),
                ),
            ),
        ),
        'properties' => array(
            array(
                'NAME' => 'Картинка для мобильного',
                'ACTIVE' => 'Y',
                'SORT' => '100',
                'CODE' => 'IMAGE_MOBILE',
                'PROPERTY_TYPE' => 'F',
                'FILE_TYPE' => 'jpg, gif, bmp, png, jpeg, webp',
                'LIST_TYPE' => 'L',
            ),
            array(
                'NAME' => 'Кнопка (название)',
                'ACTIVE' => 'Y',
                'SORT' => '200',
                'CODE' => 'NAME_BUTTON',
                'PROPERTY_TYPE' => 'S',
            ),
            array(
                'NAME' => 'Ссылка для перехода',
                'ACTIVE' => 'Y',
                'SORT' => '300',
                'CODE' => 'LINK_TO',
                'PROPERTY_TYPE' => 'S',
            ),
        ),
        'labels' => array(
            'ELEMENTS_NAME' => 'Баннеры',
            'ELEMENT_NAME' => 'Баннер',
            'ELEMENT_ADD' => 'Добавить баннер',
            'ELEMENT_EDIT' => 'Изменить баннер',
            'ELEMENT_DELETE' => 'Удалить баннер',
        ),
    ),
    array(
        'type' => array(
            'ID' => 'cards_info',
            'SECTIONS' => 'Y',
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'IN_RSS' => 'N',
            'SORT' => 110,
            'LANG' => array(
                'ru' => array(
                    'NAME' => 'Карточки информации',
                    'SECTION_NAME' => 'Разделы',
                    'ELEMENT_NAME' => 'Карточки',
                    'ELEMENT_ADD' => 'Добавить карточку',
                    'ELEMENT_EDIT' => 'Изменить карточку',
                    'ELEMENT_DELETE' => 'Удалить карточку',
                    'SECTION_ADD' => 'Добавить раздел',
                    'SECTION_EDIT' => 'Изменить раздел',
                    'SECTION_DELETE' => 'Удалить раздел',
                ),
                'en' => array(
                    'NAME' => 'Info Cards',
                    'SECTION_NAME' => 'Sections',
                    'ELEMENT_NAME' => 'Cards',
                    'ELEMENT_ADD' => 'Add card',
                    'ELEMENT_EDIT' => 'Edit card',
                    'ELEMENT_DELETE' => 'Delete card',
                    'SECTION_ADD' => 'Add section',
                    'SECTION_EDIT' => 'Edit section',
                    'SECTION_DELETE' => 'Delete section',
                ),
            ),
        ),
        'iblock' => array(
            'ACTIVE' => 'Y',
            'NAME' => 'Карточки информации',
            'CODE' => 'cards_info',
            'IBLOCK_TYPE_ID' => 'cards_info',
            'SORT' => 110,
            'LIST_PAGE_URL' => '#SITE_DIR#/cards/index.php?ID=#IBLOCK_ID#',
            'SECTION_PAGE_URL' => '#SITE_DIR#/cards/list.php?SECTION_ID=#SECTION_ID#',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/cards/detail.php?ID=#ELEMENT_ID#',
            'INDEX_ELEMENT' => 'Y',
            'INDEX_SECTION' => 'Y',
            'WORKFLOW' => 'N',
            'BIZPROC' => 'N',
            'GROUP_ID' => array(
                2 => 'R', // Для всех пользователей - чтение
            ),
            'FIELDS' => array(
                'CODE' => array(
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => array(
                        'TRANSLITERATION' => 'Y',
                        'TRANS_LEN' => 100,
                        'TRANS_CASE' => 'L',
                        'TRANS_SPACE' => '-',
                        'TRANS_OTHER' => '-',
                        'TRANS_EAT' => 'Y',
                        'CHECK_UNIQUE' => 'Y', // если код задан, проверять уникальность
                    ),
                ),
            ),
        ),
        'properties' => array(
            array(
                'NAME' => 'Ссылка для перехода',
                'ACTIVE' => 'Y',
                'SORT' => '100',
                'CODE' => 'LINK_CARD',
                'PROPERTY_TYPE' => 'S',
                'IS_REQUIRED' => 'Y',
                'SMART_FILTER' => 'Y',
                'FILTRABLE' => 'Y',
            ),
        ),
        'labels' => array(
            'ELEMENTS_NAME' => 'Карточки',
            'ELEMENT_NAME' => 'Карточка',
            'ELEMENT_ADD' => 'Добавить карточку',
            'ELEMENT_EDIT' => 'Изменить карточку',
            'ELEMENT_DELETE' => 'Удалить карточку',
        ),
    ),
    array(
        'type' => array(
            'ID' => 'news_and_changes',
            'SECTIONS' => 'Y',
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'IN_RSS' => 'N',
            'SORT' => 120,
            'LANG' => array(
                'ru' => array(
                    'NAME' => 'Новости и изменения',
                    'SECTION_NAME' => 'Разделы',
                    'ELEMENT_NAME' => 'Элементы',
                    'ELEMENT_ADD' => 'Добавить элемент',
                    'ELEMENT_EDIT' => 'Изменить элемент',
                    'ELEMENT_DELETE' => 'Удалить элемент',
                    'SECTION_ADD' => 'Добавить раздел',
                    'SECTION_EDIT' => 'Изменить раздел',
                    'SECTION_DELETE' => 'Удалить раздел',
                ),
                'en' => array(
                    'NAME' => 'News and Changes',
                    'SECTION_NAME' => 'Sections',
                    'ELEMENT_NAME' => 'Items',
                    'ELEMENT_ADD' => 'Add item',
                    'ELEMENT_EDIT' => 'Edit item',
                    'ELEMENT_DELETE' => 'Delete item',
                    'SECTION_ADD' => 'Add section',
                    'SECTION_EDIT' => 'Edit section',
                    'SECTION_DELETE' => 'Delete section',
                ),
            ),
        ),
        'iblock' => array(
            'ACTIVE' => 'Y',
            'NAME' => 'Новости компании',
            'CODE' => 'news',
            'IBLOCK_TYPE_ID' => 'news_and_changes',
            'SORT' => 120,
            'LIST_PAGE_URL' => '#SITE_DIR#/news_and_changes/index.php?ID=#IBLOCK_ID#',
            'SECTION_PAGE_URL' => '#SITE_DIR#/izmeneniya-v-raspisanii/',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/izmeneniya-v-raspisanii/#ELEMENT_CODE#/',
            'INDEX_ELEMENT' => 'Y',
            'INDEX_SECTION' => 'Y',
            'WORKFLOW' => 'N',
            'BIZPROC' => 'N',
            'GROUP_ID' => array(
                2 => 'R',
            ),
            'FIELDS' => array(
                'CODE' => array(
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => array(
                        'TRANSLITERATION' => 'Y',
                        'TRANS_LEN' => 100,
                        'TRANS_CASE' => 'L',
                        'TRANS_SPACE' => '-',
                        'TRANS_OTHER' => '-',
                        'TRANS_EAT' => 'Y',
                        'CHECK_UNIQUE' => 'Y',
                    ),
                ),
            ),
        ),
        'properties' => array(
            array(
                'NAME' => 'Отображать в блоке "Новости"',
                'ACTIVE' => 'Y',
                'SORT' => '100',
                'CODE' => 'DISPLAY_BLOCK_NEWS',
                'IS_REQUIRED' => 'Y',
                'SMART_FILTER' => 'Y',
                'FILTRABLE' => 'Y',
                'PROPERTY_TYPE' => 'L',
                'VALUES' => array('Да', 'Нет'),
            ),
        ),
        'labels' => array(
            'ELEMENTS_NAME' => 'Новости',
            'ELEMENT_NAME' => 'Новость',
            'ELEMENT_ADD' => 'Добавить новость',
            'ELEMENT_EDIT' => 'Изменить новость',
            'ELEMENT_DELETE' => 'Удалить новость',
        ),
    ),
    array(
        'type' => array(
            'ID' => 'news_and_changes',
            'SECTIONS' => 'Y',
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'IN_RSS' => 'N',
            'SORT' => 120,
            'LANG' => array(
                'ru' => array(
                    'NAME' => 'Новости и изменения',
                    'SECTION_NAME' => 'Разделы',
                    'ELEMENT_NAME' => 'Элементы',
                    'ELEMENT_ADD' => 'Добавить элемент',
                    'ELEMENT_EDIT' => 'Изменить элемент',
                    'ELEMENT_DELETE' => 'Удалить элемент',
                    'SECTION_ADD' => 'Добавить раздел',
                    'SECTION_EDIT' => 'Изменить раздел',
                    'SECTION_DELETE' => 'Удалить раздел',
                ),
                'en' => array(
                    'NAME' => 'News and Changes',
                    'SECTION_NAME' => 'Sections',
                    'ELEMENT_NAME' => 'Items',
                    'ELEMENT_ADD' => 'Add item',
                    'ELEMENT_EDIT' => 'Edit item',
                    'ELEMENT_DELETE' => 'Delete item',
                    'SECTION_ADD' => 'Add section',
                    'SECTION_EDIT' => 'Edit section',
                    'SECTION_DELETE' => 'Delete section',
                ),
            ),
        ),
        'iblock' => array(
            'ACTIVE' => 'Y',
            'NAME' => 'Изменения в расписании',
            'CODE' => 'schedule_changes',
            'IBLOCK_TYPE_ID' => 'news_and_changes',
            'SORT' => 121,
            'LIST_PAGE_URL' => '#SITE_DIR#/news_and_changes/index.php?ID=#IBLOCK_ID#',
            'SECTION_PAGE_URL' => '#SITE_DIR#/novosti-kompanii/',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/novosti-kompanii/#ELEMENT_CODE#/',
            'INDEX_ELEMENT' => 'Y',
            'INDEX_SECTION' => 'Y',
            'WORKFLOW' => 'N',
            'BIZPROC' => 'N',
            'GROUP_ID' => array(
                2 => 'R',
            ),
            'FIELDS' => array(
                'CODE' => array(
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => array(
                        'TRANSLITERATION' => 'Y',
                        'TRANS_LEN' => 100,
                        'TRANS_CASE' => 'L',
                        'TRANS_SPACE' => '-',
                        'TRANS_OTHER' => '-',
                        'TRANS_EAT' => 'Y',
                        'CHECK_UNIQUE' => 'Y',
                    ),
                ),
            ),
        ),
        'properties' => array(
            array(
                'NAME' => 'Отображать в блоке "Новости"',
                'ACTIVE' => 'Y',
                'SORT' => '100',
                'CODE' => 'DISPLAY_BLOCK_NEWS',
                'IS_REQUIRED' => 'Y',
                'SMART_FILTER' => 'Y',
                'FILTRABLE' => 'Y',
                'PROPERTY_TYPE' => 'L',
                'VALUES' => array('Да', 'Нет'),
            ),
        ),
        'labels' => array(
            'ELEMENTS_NAME' => 'Изменения',
            'ELEMENT_NAME' => 'Изменение',
            'ELEMENT_ADD' => 'Добавить изменение',
            'ELEMENT_EDIT' => 'Изменить изменение',
            'ELEMENT_DELETE' => 'Удалить изменение',
        ),
    ),
    array(
        'type' => array(
            'ID' => 'sevices',
            'SECTIONS' => 'Y',
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'IN_RSS' => 'N',
            'SORT' => 122,
            'LANG' => array(
                'ru' => array(
                    'NAME' => 'Услуги',
                    'SECTION_NAME' => 'Разделы',
                    'ELEMENT_NAME' => 'Услуги',
                    'ELEMENT_ADD' => 'Добавить услугу',
                    'ELEMENT_EDIT' => 'Изменить услугу',
                    'ELEMENT_DELETE' => 'Удалить услугу',
                    'SECTION_ADD' => 'Добавить раздел',
                    'SECTION_EDIT' => 'Изменить раздел',
                    'SECTION_DELETE' => 'Удалить раздел',
                ),
                'en' => array(
                    'NAME' => 'Sevices',
                    'SECTION_NAME' => 'Sections',
                    'ELEMENT_NAME' => 'Sevices',
                    'ELEMENT_ADD' => 'Add service',
                    'ELEMENT_EDIT' => 'Edit service',
                    'ELEMENT_DELETE' => 'Delete service',
                    'SECTION_ADD' => 'Add section',
                    'SECTION_EDIT' => 'Edit section',
                    'SECTION_DELETE' => 'Delete section',
                ),
            ),
        ),
        'iblock' => array(
            'ACTIVE' => 'Y',
            'NAME' => 'Услуги',
            'CODE' => 'sevices',
            'IBLOCK_TYPE_ID' => 'sevices',
            'SORT' => 121,
            'LIST_PAGE_URL' => '#SITE_DIR#/services/index.php?ID=#IBLOCK_ID#',
            'SECTION_PAGE_URL' => '#SITE_DIR#/services/',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/services/detail.php?ID=#ELEMENT_ID#',
            'INDEX_ELEMENT' => 'Y',
            'INDEX_SECTION' => 'Y',
            'WORKFLOW' => 'N',
            'BIZPROC' => 'N',
            'GROUP_ID' => array(
                2 => 'R',
            ),
            'FIELDS' => array(
                'CODE' => array(
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => array(
                        'TRANSLITERATION' => 'Y',
                        'TRANS_LEN' => 100,
                        'TRANS_CASE' => 'L',
                        'TRANS_SPACE' => '-',
                        'TRANS_OTHER' => '-',
                        'TRANS_EAT' => 'Y',
                        'CHECK_UNIQUE' => 'Y',
                    ),
                ),
            ),
        ),
        'properties' => array(),
        'labels' => array(
            'ELEMENTS_NAME' => 'Услуги',
            'ELEMENT_NAME' => 'Услуга',
            'ELEMENT_ADD' => 'Добавить услугу',
            'ELEMENT_EDIT' => 'Изменить услугу',
            'ELEMENT_DELETE' => 'Удалить услугу',
        ),
    ),
    array(
        'type' => array(
            'ID' => 'products',
            'SECTIONS' => 'Y',
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'IN_RSS' => 'N',
            'SORT' => 123,
            'LANG' => array(
                'ru' => array(
                    'NAME' => 'Товары',
                    'SECTION_NAME' => 'Разделы',
                    'ELEMENT_NAME' => 'Товары',
                    'ELEMENT_ADD' => 'Добавить товар',
                    'ELEMENT_EDIT' => 'Изменить товар',
                    'ELEMENT_DELETE' => 'Удалить товар',
                    'SECTION_ADD' => 'Добавить раздел',
                    'SECTION_EDIT' => 'Изменить раздел',
                    'SECTION_DELETE' => 'Удалить раздел',
                ),
                'en' => array(
                    'NAME' => 'Products',
                    'SECTION_NAME' => 'Sections',
                    'ELEMENT_NAME' => 'Products',
                    'ELEMENT_ADD' => 'Add product',
                    'ELEMENT_EDIT' => 'Edit product',
                    'ELEMENT_DELETE' => 'Delete product',
                    'SECTION_ADD' => 'Add section',
                    'SECTION_EDIT' => 'Edit section',
                    'SECTION_DELETE' => 'Delete section',
                ),
            ),
        ),
        'iblock' => array(
            'ACTIVE' => 'Y',
            'NAME' => 'Товары',
            'CODE' => 'products',
            'IBLOCK_TYPE_ID' => 'products',
            'SORT' => 121,
            'LIST_PAGE_URL' => '#SITE_DIR#/products/index.php?ID=#IBLOCK_ID#',
            'SECTION_PAGE_URL' => '#SITE_DIR#/products/',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/products/detail.php?ID=#ELEMENT_ID#',
            'INDEX_ELEMENT' => 'Y',
            'INDEX_SECTION' => 'Y',
            'WORKFLOW' => 'N',
            'BIZPROC' => 'N',
            'GROUP_ID' => array(
                2 => 'R',
            ),
            'FIELDS' => array(
                'CODE' => array(
                    'IS_REQUIRED' => 'N',
                    'DEFAULT_VALUE' => array(
                        'TRANSLITERATION' => 'Y',
                        'TRANS_LEN' => 100,
                        'TRANS_CASE' => 'L',
                        'TRANS_SPACE' => '-',
                        'TRANS_OTHER' => '-',
                        'TRANS_EAT' => 'Y',
                        'CHECK_UNIQUE' => 'Y',
                    ),
                ),
            ),
        ),
        'properties' => array(
            array(
                'NAME' => 'Цена',
                'ACTIVE' => 'Y',
                'SORT' => '100',
                'CODE' => 'PRICE',
                'PROPERTY_TYPE' => 'S',
                'IS_REQUIRED' => 'Y',
                'SMART_FILTER' => 'Y',
                'FILTRABLE' => 'Y',
                'LIST_TYPE' => 'L',
                'SEARCHABLE' => 'Y',
            ),
            array(
                'NAME' => 'Галерея товара',
                'ACTIVE' => 'Y',
                'SORT' => '200',
                'CODE' => 'GALLERY',
                'PROPERTY_TYPE' => 'F',
                'MULTIPLE' => 'Y',
                'FILE_TYPE' => 'jpg, jpeg, png, gif, webp',
                'LIST_TYPE' => 'L', // Показывать на странице списка элементов
                'SEARCHABLE' => 'Y', // Показывать на детальной странице элемента
            ),
        ),
        'labels' => array(
            'ELEMENTS_NAME' => 'Товары',
            'ELEMENT_NAME' => 'Товар',
            'ELEMENT_ADD' => 'Добавить товар',
            'ELEMENT_EDIT' => 'Изменить товар',
            'ELEMENT_DELETE' => 'Удалить товар',
        ),
    ),
    );

    // Метод для создания инфоблоков, который будет вызываться по событию
    public function createInfoblocks()
    {
        try {
            $siteId = $this->getDefaultSiteId();
            
            // Подключаем WizardServices для импорта из XML
            if (!\Bitrix\Main\Loader::includeModule('iblock')) {
                throw new \Exception("Модуль iblock не установлен");
            }
            
            // Права доступа для создаваемых инфоблоков
            $permissions = [
                1 => "X",  // Администраторы - полный доступ
                2 => "R",  // Все пользователи - чтение
            ];
            
            // Импортируем каждый инфоблок из XML файла
            $xmlDir = __DIR__ . '/../public/xml/ru/';
            
            // Маппинг кодов инфоблоков на имена XML файлов
            $xmlMapping = array(
                'advertising_bannerss' => 'banners.xml',
                'cards_info' => 'cards_info.xml',
                'news' => 'news.xml',
                'schedule_changes' => 'schedule_changes.xml',
                'sevices' => 'sevices.xml',
                'products' => 'products.xml',
            );
            
            foreach ($this->iblocksConfig as $config) {
                if (!isset($config['iblock']['CODE'])) {
                    continue;
                }
                
                $iblockCode = $config['iblock']['CODE'];
                $iblockType = $config['iblock']['IBLOCK_TYPE_ID'];
                
                if (!isset($xmlMapping[$iblockCode])) {
                    continue;
                }
                
                $xmlFile = $xmlDir . $xmlMapping[$iblockCode];
                if (!file_exists($xmlFile)) {
                    $this->writeToLog("XML файл не найден: {$xmlFile}", "Ошибка импорта: ");
                    continue;
                }
                
                // Импортируем инфоблок из XML файла
                $iblockId = \CIBlock::ImportXML(
                    $xmlFile,
                    $iblockCode,
                    $iblockType,
                    $siteId,
                    $permissions
                );
                
                if ($iblockId <= 0) {
                    $this->writeToLog("Ошибка импорта инфоблока из файла: {$xmlFile}", "Ошибка импорта: ");
                    continue;
                }
                
                // Обновляем URL'ы инфоблока
                $ib = new \CIBlock;
                $ib->Update($iblockId, array(
                    'LIST_PAGE_URL' => $config['iblock']['LIST_PAGE_URL'] ?? '',
                    'SECTION_PAGE_URL' => $config['iblock']['SECTION_PAGE_URL'] ?? '',
                    'DETAIL_PAGE_URL' => $config['iblock']['DETAIL_PAGE_URL'] ?? ''
                ));
            }
            
            return true;
        } catch (\Exception $e) {
            $this->writeToLog($e->getMessage(), "ОШИБКА: ");
            return false;
        }
    }

    // Метод для удаления инфоблоков при удалении модуля
    public function deleteInfoblocks()
    {
        try {
            // Сначала удаляем все инфоблоки
            foreach ($this->iblocksConfig as $config) {
                if (isset($config['iblock']['CODE']) && isset($config['iblock']['IBLOCK_TYPE_ID'])) {
                    $rsIBlock = \CIBlock::GetList(array(), array(
                        'CODE' => $config['iblock']['CODE'],
                        'IBLOCK_TYPE_ID' => $config['iblock']['IBLOCK_TYPE_ID']
                    ));
                    
                    if ($arIBlock = $rsIBlock->Fetch()) {
                        $iblockId = (int)$arIBlock['ID'];
                        if (!\CIBlock::Delete($iblockId)) {
                            $this->writeToLog("Ошибка удаления инфоблока '{$config['iblock']['NAME']}' (ID: {$iblockId})", "Ошибка удаления инфоблока: ");
                        }
                    }
                }
            }
            
            // Затем удаляем типы инфоблоков
            $iblockTypeIds = array();
            foreach ($this->iblocksConfig as $config) {
                if (isset($config['type']['ID'])) {
                    $iblockTypeIds[] = $config['type']['ID'];
                }
            }
            
            // Удаляем только уникальные типы
            $iblockTypeIds = array_unique($iblockTypeIds);
            
            // Удаляем все типы инфоблоков, созданные модулем
            foreach ($iblockTypeIds as $typeId) {
                $iblockType = new \CIBlockType;
                if (!$iblockType->Delete($typeId)) {
                    $this->writeToLog("Ошибка удаления типа инфоблока '{$typeId}': " . $iblockType->LAST_ERROR, "Ошибка удаления типа инфоблока: ");
                }
            }
            
            return true;
        } catch (\Exception $e) {
            $this->writeToLog($e->getMessage(), "ОШИБКА при удалении инфоблоков: ");
            return false;
        }
    }

    //Функция записи в файл
    private function writeToLog($data, $title = '')
    {
        if (!DEBUG_FILE_NAME)
            return false;
        
        if ($data == ""){
            $log = "\n------------------------\n";
            $log .= date("Y.m.d G:i:s")."\n";
            $log .= $title."\n";
            $log .= "Ничего'"."\n";
            $log .= "\n------------------------\n";
        }
        else{
            $log = "\n------------------------\n";
            $log .= date("Y.m.d G:i:s")."\n";
            $log .= $title."\n";
            $log .= print_r($data, 1);
            $log .= "\n------------------------\n";
        }
        file_put_contents(__DIR__."/".DEBUG_FILE_NAME, $log, FILE_APPEND);

        return true;
    }
}
