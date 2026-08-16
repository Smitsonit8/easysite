<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

$renderText = static function ($value)
{
	return nl2br(htmlspecialcharsbx($value));
};

$bannerStyle = "";
if ($arResult["BACKGROUND_IMAGE_SRC"] !== "")
{
	$backgroundImage = htmlspecialcharsbx($arResult["BACKGROUND_IMAGE_SRC"]);
	$bannerStyle = "background-image: radial-gradient(circle at top left, rgba(255, 255, 255, 0.22), transparent 34%), linear-gradient(135deg, rgba(18, 46, 89, 0.72), rgba(0, 0, 0, 0.64)), url('".$backgroundImage."'); background-position: center, center, center; background-repeat: no-repeat, no-repeat, no-repeat; background-size: auto, auto, cover;";
}
elseif ($arResult["BACKGROUND_COLOR"] !== "")
{
	$bannerStyle = "background: ".htmlspecialcharsbx($arResult["BACKGROUND_COLOR"]).";";
}
?>
<section class="sporina-banner sporina-banner--split"<?php if ($bannerStyle !== ""): ?> style="<?=$bannerStyle?>"<?php endif; ?>>
	<div class="container sporina-banner__container">
		<div class="sporina-banner__content">
			<?php if ($arResult["SLOGAN"] !== ""): ?>
				<div class="sporina-banner__slogan"><?=htmlspecialcharsbx($arResult["SLOGAN"])?></div>
			<?php endif; ?>
			<?php if ($arResult["TITLE"] !== ""): ?>
				<h1 class="sporina-banner__title"><?=$renderText($arResult["TITLE"])?></h1>
			<?php endif; ?>
			<?php if ($arResult["TEXT"] !== ""): ?>
				<div class="sporina-banner__text"><?=$renderText($arResult["TEXT"])?></div>
			<?php endif; ?>
			<?php if ($arResult["SHOW_BUTTON"]): ?>
				<a class="sporina-button sporina-banner__button" href="<?=htmlspecialcharsbx($arResult["BUTTON_LINK"])?>">
					<?=htmlspecialcharsbx($arResult["BUTTON_TEXT"])?>
				</a>
			<?php endif; ?>
		</div>
		<?php if ($arResult["SHOW_IMAGE"]): ?>
			<div class="sporina-banner__media">
				<?php if ($arResult["IMAGE_SRC"] !== ""): ?>
					<img class="sporina-banner__image sporina-banner__image--desktop" src="<?=htmlspecialcharsbx($arResult["IMAGE_SRC"])?>" alt="<?=htmlspecialcharsbx($arResult["TITLE"])?>">
				<?php endif; ?>
				<?php if ($arResult["MOBILE_IMAGE_SRC"] !== ""): ?>
					<img class="sporina-banner__image sporina-banner__image--mobile" src="<?=htmlspecialcharsbx($arResult["MOBILE_IMAGE_SRC"])?>" alt="<?=htmlspecialcharsbx($arResult["TITLE"])?>">
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
