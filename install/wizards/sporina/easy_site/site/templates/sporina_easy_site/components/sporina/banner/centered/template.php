<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

$renderText = static function ($value)
{
	return nl2br(htmlspecialcharsbx($value));
};

$formModalId = "sporina-banner-form-modal-" . randString(8);

$bannerStyle = "";
if ($arResult["BACKGROUND_IMAGE_SRC"] !== "")
{
	$backgroundImage = htmlspecialcharsbx($arResult["BACKGROUND_IMAGE_SRC"]);
	$bannerStyle = "background-image: linear-gradient(135deg, rgba(18, 84, 132, 0.74), rgba(0, 0, 0, 0.58)), url('".$backgroundImage."'); background-position: center, center; background-repeat: no-repeat, no-repeat; background-size: auto, cover;";
}
elseif ($arResult["BACKGROUND_COLOR"] !== "")
{
	$bannerStyle = "background: ".htmlspecialcharsbx($arResult["BACKGROUND_COLOR"]).";";
}
?>
<section class="sporina-banner-centered"<?php if ($bannerStyle !== ""): ?> style="<?=$bannerStyle?>"<?php endif; ?>>
	<div class="container sporina-banner-centered__container">
		<?php if ($arResult["SHOW_IMAGE"]): ?>
			<div class="sporina-banner-centered__backdrop">
			</div>
		<?php endif; ?>
		<div class="sporina-banner-centered__card">
			<?php if ($arResult["SLOGAN"] !== ""): ?>
				<div class="sporina-banner-centered__slogan"><?=htmlspecialcharsbx($arResult["SLOGAN"])?></div>
			<?php endif; ?>
			<?php if ($arResult["TITLE"] !== ""): ?>
				<h1 class="sporina-banner-centered__title"><?=$renderText($arResult["TITLE"])?></h1>
			<?php endif; ?>
			<?php if ($arResult["TEXT"] !== ""): ?>
				<div class="sporina-banner-centered__text"><?=$renderText($arResult["TEXT"])?></div>
			<?php endif; ?>
			<?php if ($arResult["SHOW_BUTTON"]): ?>
				<?php if ($arResult["BUTTON_ACTION"] === "form"): ?>
					<button class="sporina-button sporina-banner-centered__button" type="button" data-banner-form-open="<?=$formModalId?>" aria-controls="<?=$formModalId?>" aria-expanded="false" aria-haspopup="dialog"><?=htmlspecialcharsbx($arResult["BUTTON_TEXT"])?></button>
				<?php else: ?>
					<a class="sporina-button sporina-banner-centered__button" href="<?=htmlspecialcharsbx($arResult["BUTTON_LINK"])?>"><?=htmlspecialcharsbx($arResult["BUTTON_TEXT"])?></a>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php require dirname(__DIR__) . "/form-modal.php"; ?>
