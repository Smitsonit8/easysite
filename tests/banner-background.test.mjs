import assert from 'node:assert/strict';
import {readFileSync} from 'node:fs';
import {join} from 'node:path';
import test from 'node:test';

const root = join(import.meta.dirname, '..');
const read = (...parts) => readFileSync(join(root, ...parts), 'utf8');
const banner = (...parts) => read(
  'install', 'wizards', 'sporina', 'easy_site', 'site', 'templates',
  'sporina_easy_site', 'components', 'sporina', 'banner', ...parts,
);

test('banner background parameter has localized labels and image priority', () => {
  const component = banner('component.php');
  const parameters = banner('.parameters.php');
  const ruLanguage = banner('lang', 'ru', '.parameters.php');
  const enLanguage = banner('lang', 'en', '.parameters.php');

  assert.match(component, /\$backgroundColor\s*=\s*trim\(\(string\)\(\$arParams\["BACKGROUND_COLOR"\]/);
  assert.match(component, /"BACKGROUND_COLOR"\s*=>\s*\$backgroundColor/);
  assert.match(parameters, /Loc::getMessage\("BACKGROUND_COLOR"\)/);
  assert.match(ruLanguage, /Цвет фона/);
  assert.match(enLanguage, /Background color/);

  for (const template of ['.default', 'centered', 'compact']) {
    const source = banner('templates', template, 'template.php');
    const imageBranch = source.indexOf('if ($arResult["BACKGROUND_IMAGE_SRC"] !== "")');
    const colorBranch = source.indexOf('elseif ($arResult["BACKGROUND_COLOR"] !== "")');

    assert.ok(imageBranch >= 0, `${template} template should render an image background`);
    assert.ok(colorBranch > imageBranch, `${template} template should use custom color only after image check`);
    assert.match(source, /background:\s*"\.htmlspecialcharsbx\(\$arResult\["BACKGROUND_COLOR"\]\)/);
  }
});
