<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вакансии");
?>
<!-- слайдер с текстом на нем отличается от главной страници-->
<?$APPLICATION->IncludeComponent("bitrix:main.include","sporina-slider-pages", array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => SITE_DIR."include/slider-pages.php",
	),
	false
);?>

<!--меню, контент-->
<section class="container content_flex">
  <div class="content_nav">
    <div class="content_nav-bg">
      <input type="checkbox" id="content_nav-head">
      <!--<label class="content_nav-head" for="content_nav-head"> О компании</label>-->
      <?$APPLICATION->IncludeComponent("bitrix:menu", "sporina-left-menu", Array(
            "ALLOW_MULTI_SELECT" => "N",
              "CHILD_MENU_TYPE" => "left",
              "DELAY" => "N",
              "MAX_LEVEL" => "1",
              "MENU_CACHE_GET_VARS" => array(
                0 => "",
              ),
              "MENU_CACHE_TIME" => "3600",
              "MENU_CACHE_TYPE" => "N",
              "MENU_CACHE_USE_GROUPS" => "Y",
              "ROOT_MENU_TYPE" => "left",
              "USE_EXT" => "N",
            ),
            false
          );
      ?>

    </div>
  </div>
  <div class="content">
    <h2><?$APPLICATION->ShowTitle()?></h2>
    <?$APPLICATION->IncludeComponent("bitrix:main.include", "", Array(
      "AREA_FILE_RECURSIVE" => "Y",
        "AREA_FILE_SHOW" => "sect",
        "AREA_FILE_SUFFIX" => "inc jobs",
        "EDIT_TEMPLATE" => "",
      ),
      false
    );?>

  </div>

</section>
<!-- подписаться на телеграм-->
<!-- подписаться на телеграм-->
<?$APPLICATION->IncludeComponent("bitrix:main.include","sporina-subscribe-t", array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => SITE_DIR."include/subscribe.php",
	),
	false
	);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>