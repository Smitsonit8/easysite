<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<section class="sporina-contacts">
	<div class="sporina-contacts__intro">
		<p class="sporina-contacts__eyebrow"><?=$arResult["INTRO"]["EYEBROW"]?></p>
		<h3 class="sporina-contacts__headline"><?=$arResult["INTRO"]["TITLE"]?></h3>
	</div>

	<div class="sporina-contacts__grid">
		<?if ($arResult["SHOW_COMPANY"]):?>
		<div class="sporina-contacts__card sporina-contacts__card--company sporina-contacts__area-company">
			<?foreach ($arResult["COMPANY_ITEMS"] as $item):?>
					<div class="sporina-contacts__row">
						<div class="sporina-contacts__label"><?=$item["LABEL"]?></div>
						<div class="sporina-contacts__value">
							<?if ($item["TYPE"] === "email"):?>
								<a href="mailto:<?=$item["VALUE"]?>" class="sporina-contacts__link"><?=$item["VALUE"]?></a>
							<?else:?>
								<?=$item["VALUE"]?>
							<?endif;?>
							<?if ($item["NOTE"] !== ""):?>
								<div class="sporina-contacts__note"><?=$item["NOTE"]?></div>
							<?endif;?>
						</div>
					</div>
			<?endforeach;?>
		</div>
		<?endif;?>

		<?if ($arResult["SHOW_PHONES"]):?>
		<div class="sporina-contacts__card sporina-contacts__area-phones">
			<?foreach ($arResult["PHONE_ITEMS"] as $item):?>
					<div class="sporina-contacts__row">
						<div class="sporina-contacts__label"><?=$item["LABEL"]?></div>
						<div class="sporina-contacts__value">
							<?if ($item["HREF"] !== ""):?>
								<a href="<?=$item["HREF"]?>" class="sporina-contacts__link"><?=$item["VALUE"]?></a>
							<?else:?>
								<?=$item["VALUE"]?>
							<?endif;?>
						</div>
					</div>
			<?endforeach;?>
		</div>
		<?endif;?>

		<?if ($arResult["SHOW_SCHEDULE"]):?>
		<div class="sporina-contacts__card sporina-contacts__area-schedule">
			<?foreach ($arResult["SCHEDULE_ITEMS"] as $item):?>
					<div class="sporina-contacts__row">
						<div class="sporina-contacts__label"><?=$item["LABEL"]?></div>
						<div class="sporina-contacts__value"><?=$item["VALUE"]?></div>
					</div>
			<?endforeach;?>
		</div>
		<?endif;?>

		<?if ($arResult["MAP"]["SHOW"]):?>
		<aside class="sporina-contacts__map-card sporina-contacts__area-map">
			<div class="sporina-contacts__map-head"><?=$arResult["MAP"]["TITLE"]?></div>
			<div class="sporina-contacts__map-frame" style="height: <?=$arResult["MAP"]["HEIGHT"]?>px;">
				<iframe
					src="https://yandex.ru/map-widget/v1/?ll=<?=urlencode($arResult["MAP"]["LON"] . "," . $arResult["MAP"]["LAT"])?>&pt=<?=urlencode($arResult["MAP"]["LON"] . "," . $arResult["MAP"]["LAT"])?>&z=16&l=map"
					width="100%"
					height="100%"
					frameborder="0"
					allowfullscreen="true"
					loading="lazy"
					title="<?=$arResult["MAP"]["TITLE"]?>"
				></iframe>
			</div>
		</aside>
		<?endif;?>
	</div>
</section>
