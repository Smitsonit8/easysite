import assert from 'node:assert/strict';
import {readFileSync} from 'node:fs';
import {join} from 'node:path';
import test from 'node:test';

const root = join(import.meta.dirname, '..');
const base = join(
  root,
  'install', 'wizards', 'sporina', 'easy_site', 'site', 'templates',
  'sporina_easy_site', 'components', 'bitrix', 'news', 'staff',
  'bitrix', 'news.list', 'blocks.1',
);
const template = readFileSync(join(base, 'template.php'), 'utf8');
const style = readFileSync(join(base, 'style.css'), 'utf8');

test('staff summary stays visible while details expand independently', () => {
  assert.match(template, /class="sporina-staff__summary"/);
  assert.match(template, /class="sporina-staff__details-content"/);
  assert.doesNotMatch(style, /translateY\(calc\(100% - 100px\)\)/);
  assert.match(style, /grid-template-rows:\s*0fr/);
  assert.match(style, /grid-template-rows:\s*1fr/);
});
