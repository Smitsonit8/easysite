import assert from 'node:assert/strict';
import {readFileSync} from 'node:fs';
import {join} from 'node:path';
import test from 'node:test';

const root = join(import.meta.dirname, '..');
const read = (...parts) => readFileSync(join(root, ...parts), 'utf8');

test('settings separates panel visibility from demo editing permission', () => {
  const runtime = read('install', 'components', 'sporina', 'system.settings', 'class.php');
  const parameters = read('install', 'components', 'sporina', 'system.settings', '.parameters.php');
  const messages = read('install', 'components', 'sporina', 'system.settings', 'lang', 'ru', '.parameters.php');
  const demoHeader = read('install', 'wizards', 'sporina', 'easy_site', 'site', 'templates', 'sporina_easy_site', 'header.php');

  assert.match(parameters, /['"]DEMO_EDIT_MODE['"]/);
  assert.match(parameters, /['"]DEMO_EDIT_MODE['"][\s\S]*?['"]DEFAULT['"]\s*=>\s*['"]N['"]/);
  assert.match(messages, /SPORINA_SYSTEM_SETTINGS_DEMO_EDIT_MODE/);
  assert.match(runtime, /private function canDisplay\(\): bool/);
  assert.match(runtime, /private function canConfigure\(\): bool[\s\S]*?DEMO_EDIT_MODE[\s\S]*?IsAdmin\(\)/);
  assert.match(demoHeader, /['"]DISPLAY_FOR['"]\s*=>\s*['"]all['"]/);
  assert.match(demoHeader, /['"]DEMO_EDIT_MODE['"]\s*=>\s*['"]Y['"]/);
});
