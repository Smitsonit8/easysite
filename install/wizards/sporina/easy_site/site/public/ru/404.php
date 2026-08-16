<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("404 — Страница не найдена");
?>

<div class="sporina-404 container">
  <div class="sporina-404__bg" aria-hidden="true">
    <span class="sporina-404__blob sporina-404__blob--one"></span>
    <span class="sporina-404__blob sporina-404__blob--two"></span>
    <span class="sporina-404__blob sporina-404__blob--three"></span>
    <span class="sporina-404__particle"></span>
    <span class="sporina-404__particle"></span>
    <span class="sporina-404__particle"></span>
    <span class="sporina-404__particle"></span>
    <span class="sporina-404__particle"></span>
  </div>

  <div class="sporina-404__content">
    <div class="sporina-404__code" aria-hidden="true">
      <span class="sporina-404__digit">4</span>
      <span class="sporina-404__zero"></span>
      <span class="sporina-404__digit">4</span>
    </div>

    <h1 class="sporina-404__title">
      Страница не <span>найдена</span>
    </h1>

    <p class="sporina-404__text">
      Возможно, она была перемещена, переименована или удалена.
      Вернитесь на главную или воспользуйтесь поиском по сайту.
    </p>

    <div class="sporina-404__actions">
      <a class="sporina-404__home sporina-button btn-effect-1" href="<?=SITE_DIR?>">
        На главную
      </a>
      <a class="sporina-404__link sporina-404__link--ghost" href="<?=SITE_DIR?>poisk/">
        Поиск по сайту
      </a>
    </div>
  </div>
</div>

<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>