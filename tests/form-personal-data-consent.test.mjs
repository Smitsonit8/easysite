import assert from 'node:assert/strict';
import {readFileSync} from 'node:fs';
import {join} from 'node:path';
import test from 'node:test';

const root = join(import.meta.dirname, '..');
const read = (...parts) => readFileSync(join(root, ...parts), 'utf8');

for (const [name, template] of [
  ['товаров', 'sporina-products'],
  ['услуг', 'sporina-services'],
]) {
  test(`форма ${name} включает согласие при переданной ссылке`, () => {
    const detail = read(
      'install', 'wizards', 'sporina', 'easy_site', 'site', 'templates', 'sporina_easy_site',
      'components', 'sporina', 'news', template, 'detail.php',
    );

    assert.match(
      detail,
      /"PERSONAL_DATA_URL"\s*=>\s*trim\(\(string\)\(\$arParams\["FORM_PERSONAL_DATA_URL"\]\s*\?\?\s*""\)\),\s*\n\s*"ENABLE_PERSONAL_DATA_CONSENT"\s*=>\s*"Y",/,
    );
  });
}
