import assert from 'node:assert/strict';
import {readFileSync} from 'node:fs';
import {join} from 'node:path';
import test from 'node:test';

const root = join(import.meta.dirname, '..');
const source = readFileSync(join(
  root,
  'install', 'wizards', 'sporina', 'easy_site', 'site', 'templates',
  'sporina_easy_site', 'components', 'bitrix', 'news', 'staff',
  'bitrix', 'news.list', 'blocks.1', 'style.css',
), 'utf8');

test('staff card stays stationary while its body expands', () => {
  const cardHoverRule = source.match(/\.sporina-staff__card:hover,\s*\.sporina-staff__card:focus-within\s*\{([\s\S]*?)\}/)?.[1] ?? '';
  const bodyHoverRule = source.match(/\.sporina-staff__card:hover \.sporina-staff__body,[\s\S]*?\{([\s\S]*?)\}/)?.[1] ?? '';

  assert.doesNotMatch(cardHoverRule, /transform\s*:/);
  assert.match(bodyHoverRule, /transform:\s*translateY\(0\)/);
});
