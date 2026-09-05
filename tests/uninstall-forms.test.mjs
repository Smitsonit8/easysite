import assert from 'node:assert/strict';
import {readFileSync} from 'node:fs';
import {join} from 'node:path';
import test from 'node:test';

const root = join(import.meta.dirname, '..');
const source = readFileSync(join(root, 'install', 'index.php'), 'utf8');

test('деинсталлятор удаляет все веб-формы, созданные мастером', () => {
  const uninstallForms = source.match(/function UnInstallForms\(\)[\s\S]*?\r?\n\t}\r?\n\r?\n\tfunction DoInstall/);

  assert.ok(uninstallForms, 'метод UnInstallForms должен быть объявлен');

  for (const formSid of ['ORDER_FORM', 'BUY_FORM', 'FEEDBACK_FORM']) {
    assert.match(uninstallForms[0], new RegExp(String.raw`SID"\s*=>\s*"${formSid}"`));
  }
});
