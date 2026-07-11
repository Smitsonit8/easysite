<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<!--<ul class="left-menu">-->
            <div class="block">
                <div class="logo block_center">
					<a href="<?=SITE_DIR?>">
                    	<!--<img src="<//?=SITE_TEMPLATE_PATH?>/img/logo.svg">-->
						<? $APPLICATION->IncludeComponent(
								"bitrix:main.include",
								"", array(
								    "AREA_FILE_SHOW" => "file",
								    "PATH" => SITE_DIR."include/logo.php"
								),
								false
						);?>
					</a>
                </div>
				
                <input type="checkbox" id="burger">
                <label for="burger">

                </label>
                    <nav class="block nav_border">
                        <ul class="block nav">
							<?
							foreach($arResult as $arItem):
								if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
									continue;
							?>

								<?if($arItem["SELECTED"]):?>
									<li><a href="<?=$arItem["LINK"]?>" class="selected nav_active"><p><?=$arItem["TEXT"]?></p></a></li>
								<?else:?>
									<li><a href="<?=$arItem["LINK"]?>"><p><?=$arItem["TEXT"]?></p></a></li>
								<?endif?>
								
							<?endforeach?>
                        </ul>
                    </nav>
			</div>
<!--</ul>-->
<?endif?>