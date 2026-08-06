import assert from 'node:assert/strict';
import {readFileSync} from 'node:fs';
import {join} from 'node:path';
import test from 'node:test';

const root = join(import.meta.dirname, '..');
const template = readFileSync(join(
  root,
  'install', 'wizards', 'sporina', 'easy_site', 'site', 'templates',
  'sporina_easy_site', 'components', 'bitrix', 'news', 'sporina-news',
  'bitrix', 'news.list', 'list.1', 'template.php',
), 'utf8');

test('list.1 pagination wrappers use the shared pager class', () => {
  assert.match(template, /class="sporina-news-company__pager sporina-news-company-stand__pager sporina-news-company-stand__pager--top"/);
  assert.match(template, /class="sporina-news-company__pager sporina-news-company-stand__pager sporina-news-company-stand__pager--bottom"/);
});
