<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>
<footer class="sporina-footer-compact">
	<div class="container sporina-footer-compact__wrap">
		<div class="sporina-footer-compact__grid">
			<div>
				<div class="sporina-footer-compact__section-title"><?=htmlspecialcharsbx(Loc::getMessage("SPORINA_FOOTER_COMPACT_CONTACTS"))?></div>
				<div class="sporina-footer-compact__contact">
					<?php if ($arResult["PHONE_1"]["TITLE"] !== ""): ?>
						<h3><?=htmlspecialcharsbx($arResult["PHONE_1"]["TITLE"])?></h3>
					<?php endif; ?>
					<?php if ($arResult["PHONE_1"]["LABEL"] !== ""): ?>
						<p><?=htmlspecialcharsbx($arResult["PHONE_1"]["LABEL"])?></p>
					<?php endif; ?>
					<?php if ($arResult["PHONE_2"]["TITLE"] !== ""): ?>
						<h3><?=htmlspecialcharsbx($arResult["PHONE_2"]["TITLE"])?></h3>
					<?php endif; ?>
					<?php if ($arResult["PHONE_2"]["LABEL"] !== ""): ?>
						<p><?=htmlspecialcharsbx($arResult["PHONE_2"]["LABEL"])?></p>
					<?php endif; ?>
				</div>
			</div>
			<div>
				<div class="sporina-footer-compact__section-title"><?=htmlspecialcharsbx($arResult["EMAIL"]["LABEL"] !== "" ? $arResult["EMAIL"]["LABEL"] : $arResult["ADDRESS"]["LABEL"])?></div>
				<div class="sporina-footer-compact__contact">
					<?php if ($arResult["EMAIL"]["TITLE"] !== ""): ?>
						<h3><?=htmlspecialcharsbx($arResult["EMAIL"]["TITLE"])?></h3>
					<?php endif; ?>
					<?php if ($arResult["ADDRESS"]["TITLE"] !== ""): ?>
						<p><?=htmlspecialcharsbx($arResult["ADDRESS"]["TITLE"])?></p>
					<?php endif; ?>
				</div>
			</div>
			<div>
				<div class="sporina-footer-compact__section-title"><?=htmlspecialcharsbx(Loc::getMessage("SPORINA_FOOTER_COMPACT_LINKS"))?></div>
				<div class="sporina-footer-compact__legal">
					<?php if ($arResult["LICENSE"]["SHOW"]): ?>
						<a href="<?=htmlspecialcharsbx($arResult["LICENSE"]["LINK"] !== "" ? $arResult["LICENSE"]["LINK"] : "#")?>">
							<p><?=htmlspecialcharsbx($arResult["LICENSE"]["TEXT"])?></p>
						</a>
					<?php endif; ?>
					<?php if ($arResult["POLICY"]["SHOW"]): ?>
						<a href="<?=htmlspecialcharsbx($arResult["POLICY"]["LINK"] !== "" ? $arResult["POLICY"]["LINK"] : "#")?>">
							<p><?=htmlspecialcharsbx($arResult["POLICY"]["TEXT"])?></p>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="sporina-footer-compact__bottom">
			<div>
				<?php if ($arResult["COPYRIGHT_PRIMARY"] !== ""): ?>
					<div><?=nl2br(htmlspecialcharsbx($arResult["COPYRIGHT_PRIMARY"]))?></div>
				<?php endif; ?>
				<?php if ($arResult["COPYRIGHT_SECONDARY"]["SHOW"]): ?>
					<div>
						<?=htmlspecialcharsbx($arResult["COPYRIGHT_SECONDARY"]["PREFIX"])?>
						<?php if ($arResult["COPYRIGHT_SECONDARY"]["LINK_TEXT"] !== ""): ?>
							<a href="<?=htmlspecialcharsbx($arResult["COPYRIGHT_SECONDARY"]["LINK"] !== "" ? $arResult["COPYRIGHT_SECONDARY"]["LINK"] : "#")?>">
								<?=htmlspecialcharsbx($arResult["COPYRIGHT_SECONDARY"]["LINK_TEXT"])?>
							</a>
						<?php endif; ?>
						<?=htmlspecialcharsbx($arResult["COPYRIGHT_SECONDARY"]["SUFFIX"])?>
					</div>
				<?php endif; ?>
			</div>
			<div class="sporina-footer-compact__apps">
				<?php if ($arResult["TELEGRAM_LINK"] !== ""): ?>
					<a href="<?=htmlspecialcharsbx($arResult["TELEGRAM_LINK"])?>" class="svg">
						<img src="<?=SITE_TEMPLATE_PATH?>/img/telegram.svg" class="svg_color" alt="<?=htmlspecialcharsbx(Loc::getMessage("SPORINA_FOOTER_TELEGRAM_ALT"))?>">
					</a>
				<?php endif; ?>
				<?php if ($arResult["GOOGLE_PLAY_LINK"] !== ""): ?>
					<a href="<?=htmlspecialcharsbx($arResult["GOOGLE_PLAY_LINK"])?>" class="svg">
						<img src="<?=SITE_TEMPLATE_PATH?>/img/googlePlay.svg" class="svg_color" alt="<?=htmlspecialcharsbx(Loc::getMessage("SPORINA_FOOTER_GOOGLE_PLAY_ALT"))?>">
					</a>
				<?php endif; ?>
				<?php if ($arResult["APP_STORE_LINK"] !== ""): ?>
					<a href="<?=htmlspecialcharsbx($arResult["APP_STORE_LINK"])?>" class="svg">
						<img src="<?=SITE_TEMPLATE_PATH?>/img/appStore.svg" class="svg_color" alt="<?=htmlspecialcharsbx(Loc::getMessage("SPORINA_FOOTER_APP_STORE_ALT"))?>">
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</footer>
