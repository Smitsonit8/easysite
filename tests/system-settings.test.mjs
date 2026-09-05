import assert from 'node:assert/strict';
import {readFileSync, existsSync} from 'node:fs';
import {join} from 'node:path';
import test from 'node:test';

const root = join(import.meta.dirname, '..');
const component = join(root, 'install', 'components', 'sporina', 'system.settings');
const read = (...parts) => readFileSync(join(root, ...parts), 'utf8');

const keys = [
  'template-color-theme',
  'template-background-use',
  'template-background-color',
  'template-width',
  'template-font',
  'template-headings-size',
  'template-images-lazyload-use',
  'header-template',
  'footer-template',
  'pages-main-banner-use',
  'pages-main-banner-template',
  'pages-main-infocards-use',
  'pages-main-infocards-template',
  'pages-main-subscribe-use',
  'pages-main-columns-use',
  'pages-main-columns-layout',
  'pages-main-articles-template',
  'pages-main-news-template',
  'pages-main-advertising-use',
  'pages-main-current-news-use',
  'pages-main-current-news-template',
];

test('component has runtime, metadata, parameters, and Russian localization files', () => {
  for (const relative of [
    'class.php',
    '.description.php',
    '.parameters.php',
    'lang/ru/.description.php',
    'lang/ru/.parameters.php',
  ]) {
    assert.ok(existsSync(join(component, relative)), `missing ${relative}`);
  }
});

test('runtime declares render/configure modes and configurable AJAX actions', () => {
  const source = read('install', 'components', 'sporina', 'system.settings', 'class.php');
  const settings = read('lib', 'settings.php');
  assert.match(source, /MODE_RENDER\s*=\s*['"]render['"]/);
  assert.match(source, /MODE_CONFIGURE\s*=\s*['"]configure['"]/);
  assert.match(settings, /MODULE_ID\s*=\s*['"]sporina\.easysite['"]/);
  for (const action of ['apply', 'reset', 'remember-section']) {
    assert.ok(source.includes(`'${action}'`), `missing ${action} action`);
  }
  assert.match(source, /ACTION_VARIABLE/);
});

test('runtime protects configuration and AJAX writes', () => {
  const source = read('install', 'components', 'sporina', 'system.settings', 'class.php');
  assert.match(source, /\$USER->IsAdmin\(\)/);
  assert.match(source, /check_bitrix_sessid\(\)/);
  assert.match(source, /Application::getInstance\(\)->restartBuffer\(\)/);
  assert.match(source, /setStatus\(\$status\)/);
  assert.match(source, /sendJson\([^\n]+, 403\)/);
  assert.match(source, /sendJson\([^\n]+, 400\)/);
  assert.match(source, /json_encode/);
});

test('runtime uses site-scoped Bitrix options and session category state', () => {
  const runtime = read('install', 'components', 'sporina', 'system.settings', 'class.php');
  const settings = read('install', 'lib', 'settings.php');
  assert.match(runtime, /Settings::getAll\(\)/);
  assert.match(runtime, /Settings::apply\(\$settings\)/);
  assert.match(runtime, /Settings::reset\(\)/);
  assert.match(runtime, /Application::getInstance\(\)->getSession\(\)/);
  assert.match(settings, /Option::get\(self::MODULE_ID,[\s\S]*?SITE_ID/);
  assert.match(settings, /Option::set\(self::MODULE_ID,[\s\S]*?SITE_ID/);
  assert.match(settings, /Option::delete\(self::MODULE_ID,[\s\S]*?SITE_ID/);
});

test('settings support isolated template profiles without changing legacy option keys', () => {
  const runtime = read('install', 'components', 'sporina', 'system.settings', 'class.php');
  const settings = read('lib', 'settings.php');
  const primaryHeader = read('install', 'wizards', 'sporina', 'easy_site', 'site', 'templates', 'sporina_easy_site', 'header.php');
  const v2Header = read('install', 'wizards', 'sporina', 'easy_site', 'site', 'templates', 'sporina_easy_site_v2', 'header.php');

  assert.match(runtime, /PROFILE/);
  assert.match(settings, /DEFAULT_PROFILE/);
  assert.match(settings, /getOptionKey/);
  assert.match(primaryHeader, /["']PROFILE["']\s*=>\s*["']sporina_easy_site["']/);
  assert.match(v2Header, /["']PROFILE["']\s*=>\s*["']sporina_easy_site_v2["']/);
});

test('runtime defines the exact settings keys and required defaults', () => {
  const source = read('install', 'lib', 'settings.php');
  assert.match(source, /private const DEFINITIONS\s*=\s*\[/);
  const actual = [...source.matchAll(/'key'\s*=>\s*'([^']+)'/g)].map((match) => match[1]);
  assert.deepEqual(actual, keys, 'settings catalogue must have one declaration per key');

  const expectedDefaults = {
    'template-color-theme': 'blue',
    'template-background-use': 'Y',
    'template-background-color': '#f8fbff',
    'template-width': '1920',
    'template-font': 'ibm-plex-sans',
    'template-headings-size': 'normal',
    'template-images-lazyload-use': 'N',
    'header-template': 'overlay',
    'footer-template': 'big',
    'pages-main-banner-use': 'Y',
    'pages-main-banner-template': '.default',
    'pages-main-infocards-use': 'Y',
    'pages-main-infocards-template': 'sporina-cards-bayinfo-stack',
    'pages-main-subscribe-use': 'Y',
    'pages-main-columns-use': 'Y',
    'pages-main-columns-layout': 'two',
    'pages-main-articles-template': 'sporina-column-news-timeline',
    'pages-main-news-template': 'sporina-column-news-company',
    'pages-main-advertising-use': 'Y',
    'pages-main-current-news-use': 'Y',
    'pages-main-current-news-template': 'sporina-news-all-modern',
  };
  for (const [key, value] of Object.entries(expectedDefaults)) {
    assert.ok(
      new RegExp(`'key'\\s*=>\\s*'${key}'[\\s\\S]*?'default'\\s*=>\\s*'${value}'`).test(source),
      `wrong default for ${key}`,
    );
  }
});

test('runtime contains allowlist and color validation without intec dependency', () => {
  const source = read('lib', 'settings.php');
  const requiredValues = [
    'blue', 'green', 'orange', 'Y', 'N', '1200', '1440', '1920',
    'ibm-plex-sans', 'arial', 'georgia', 'compact', 'normal', 'large',
    'default', 'overlay', 'sticky', 'big', 'compact', '.default', 'centered',
    'sporina-cards-bayinfo', 'sporina-cards-bayinfo-stack',
    'sporina-cards-bayinfo-tiles', 'two', 'stacked',
    'sporina-column-news-cards', 'sporina-column-news-company',
    'sporina-column-news-timeline',
    'sporina-news-all', 'sporina-news-all-modern',
  ];
  for (const value of requiredValues) {
    assert.ok(source.includes(`'${value}'`), `missing allowlisted value ${value}`);
  }
  assert.match(source, /\/\^#\[0-9a-fA-F\]\{6\}\$\//);
  assert.match(source, /getAllowedValues/);
  assert.match(source, /isTemplateAvailable/);
  assert.doesNotMatch(source, /intec/i);
});

test('render returns settings while configure is admin-only and renders a template', () => {
  const source = read('install', 'components', 'sporina', 'system.settings', 'class.php');
  assert.match(source, /MODE_RENDER[\s\S]*?return Settings::getAll\(\)/);
  assert.match(source, /MODE_CONFIGURE[\s\S]*?\$USER->IsAdmin\(\)[\s\S]*?IncludeComponentTemplate\(\)/);
  assert.match(source, /'PANEL'\s*=>\s*Settings::getPanel\(\)/);
});

test('component metadata is localized and exposes MODE and action variable', () => {
  const description = read('install', 'components', 'sporina', 'system.settings', '.description.php');
  const parameters = read('install', 'components', 'sporina', 'system.settings', '.parameters.php');
  const ruDescription = read('install', 'components', 'sporina', 'system.settings', 'lang', 'ru', '.description.php');
  const ruParameters = read('install', 'components', 'sporina', 'system.settings', 'lang', 'ru', '.parameters.php');
  assert.match(description, /Loc::getMessage/);
  assert.match(parameters, /['"]MODE['"]/);
  assert.match(parameters, /['"]ACTION_VARIABLE['"]/);
  assert.match(ruDescription, /[А-Яа-яЁё]/);
  assert.match(ruParameters, /[А-Яа-яЁё]/);
});

test('installation lifecycle is narrow and wizard source path is corrected', () => {
  const source = read('install', 'index.php');
  assert.match(source, /install\/components/);
  assert.match(source, /\/bitrix\/components/);
  assert.match(source, /DeleteDirFilesEx\(["']\/bitrix\/components\/sporina\/system\.settings["']\)/);
  assert.doesNotMatch(source, /install\/wizards\/bitrix\/easy_site/);
  assert.match(source, /install\/wizards\/sporina\/easy_site/);
  assert.doesNotMatch(source, /DeleteDirFilesEx\(["']\/bitrix\/components["']\)/);
});

test('module version is 1.1.0 dated 2026-06-27', () => {
  const source = read('install', 'version.php');
  assert.match(source, /['"]VERSION['"]\s*=>\s*['"]1\.1\.0['"]/);
  assert.match(source, /['"]VERSION_DATE['"]\s*=>\s*['"]2026-06-27(?:\s+00:00:00)?['"]/);
});
