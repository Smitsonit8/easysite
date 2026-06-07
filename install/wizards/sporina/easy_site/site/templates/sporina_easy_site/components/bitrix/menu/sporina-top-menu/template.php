<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
			<div class="sporina-header__menu">
                <div class="sporina-header__logo">
					<a href="<?=htmlspecialcharsbx($arParams["LOGO_LINK"] ?: SITE_DIR)?>">
						<img src="<?=htmlspecialcharsbx($arParams["LOGO_SRC"])?>" alt="<?=htmlspecialcharsbx($arParams["LOGO_ALT"])?>" class="sporina-header__logo-image">
					</a>
                </div>

                <input type="checkbox" id="sporina-header-burger" class="sporina-header__burger-toggle">
                <label for="sporina-header-burger" class="sporina-header__burger" aria-label="<?=htmlspecialcharsbx($arParams["BURGER_LABEL"])?>">
					<span class="sporina-header__burger-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
                </label>
                    <nav class="sporina-header__nav">
                        <ul class="sporina-header__nav-list">
							<?
							foreach($arResult as $arItem):
								if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
									continue;
							?>

								<?if($arItem["SELECTED"]):?>
									<li class="sporina-header__nav-item"><a href="<?=$arItem["LINK"]?>" class="selected sporina-header__nav-link sporina-header__nav-link--active"><p class="sporina-header__nav-text"><?=$arItem["TEXT"]?></p></a></li>
								<?else:?>
									<li class="sporina-header__nav-item"><a href="<?=$arItem["LINK"]?>" class="sporina-header__nav-link"><p class="sporina-header__nav-text"><?=$arItem["TEXT"]?></p></a></li>
								<?endif?>

							<?endforeach?>
                        </ul>
                    </nav>
			</div>
<?endif?>
