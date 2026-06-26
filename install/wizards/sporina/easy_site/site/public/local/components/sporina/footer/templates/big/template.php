<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>
<footer>
	<div class="container">
		<div class="block_between footer_margin">
			<div class="footer_block">
				<div class="footer_block-grid">
					<div class="footer_contact">
						<?php if ($arResult["PHONE_1"]["TITLE"] !== ""): ?>
							<h3><?=htmlspecialcharsbx($arResult["PHONE_1"]["TITLE"])?></h3>
						<?php endif; ?>
						<?php if ($arResult["PHONE_1"]["LABEL"] !== ""): ?>
							<p><?=htmlspecialcharsbx($arResult["PHONE_1"]["LABEL"])?></p>
						<?php endif; ?>
					</div>
				</div>
				<div class="footer_block-grid">
					<div class="footer_contact">
						<?php if ($arResult["PHONE_2"]["TITLE"] !== ""): ?>
							<h3><?=htmlspecialcharsbx($arResult["PHONE_2"]["TITLE"])?></h3>
						<?php endif; ?>
						<?php if ($arResult["PHONE_2"]["LABEL"] !== ""): ?>
							<p><?=htmlspecialcharsbx($arResult["PHONE_2"]["LABEL"])?></p>
						<?php endif; ?>
					</div>
				</div>
				<div class="footer_block-grid">
					<div class="footer_contact">
						<?php if ($arResult["EMAIL"]["TITLE"] !== ""): ?>
							<h3><?=htmlspecialcharsbx($arResult["EMAIL"]["TITLE"])?></h3>
						<?php endif; ?>
						<?php if ($arResult["EMAIL"]["LABEL"] !== ""): ?>
							<p><?=htmlspecialcharsbx($arResult["EMAIL"]["LABEL"])?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="footer_block">
				<div class="footer_block-grid">
					<div class="footer_contact">
						<?php if ($arResult["ADDRESS"]["TITLE"] !== ""): ?>
							<h3><?=htmlspecialcharsbx($arResult["ADDRESS"]["TITLE"])?></h3>
						<?php endif; ?>
						<?php if ($arResult["ADDRESS"]["LABEL"] !== ""): ?>
							<p><?=htmlspecialcharsbx($arResult["ADDRESS"]["LABEL"])?></p>
						<?php endif; ?>
					</div>
				</div>
				<div class="footer_block-grid">
					<div class="footer_contact footer_license">
						<?php if ($arResult["LICENSE"]["SHOW"]): ?>
							<a href="<?=htmlspecialcharsbx($arResult["LICENSE"]["LINK"] !== "" ? $arResult["LICENSE"]["LINK"] : "#")?>">
								<p><?=htmlspecialcharsbx($arResult["LICENSE"]["TEXT"])?></p>
							</a>
						<?php endif; ?>
					</div>
				</div>
				<div class="footer_block-grid">
					<div class="footer_contact">
						<?php if ($arResult["POLICY"]["SHOW"]): ?>
							<a href="<?=htmlspecialcharsbx($arResult["POLICY"]["LINK"] !== "" ? $arResult["POLICY"]["LINK"] : "#")?>">
								<p><?=htmlspecialcharsbx($arResult["POLICY"]["TEXT"])?></p>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="block_between copyright_margin">
			<div class="copyright_block copyright_order1">
				<div class="copyright">
					<?=nl2br(htmlspecialcharsbx($arResult["COPYRIGHT_PRIMARY"]))?>
				</div>
			</div>
			<div class="copyright_block mobile_none copyright_order2"></div>
			<div class="copyright_block copyright_order3">
				<div class="copyright_flex">
					<?php if ($arResult["COPYRIGHT_SECONDARY"]["SHOW"]): ?>
						<div class="copyright">
							<p>
								<?=htmlspecialcharsbx($arResult["COPYRIGHT_SECONDARY"]["PREFIX"])?>
								<?php if ($arResult["COPYRIGHT_SECONDARY"]["LINK_TEXT"] !== ""): ?>
									<a href="<?=htmlspecialcharsbx($arResult["COPYRIGHT_SECONDARY"]["LINK"] !== "" ? $arResult["COPYRIGHT_SECONDARY"]["LINK"] : "#")?>">
										<?=htmlspecialcharsbx($arResult["COPYRIGHT_SECONDARY"]["LINK_TEXT"])?>
									</a>
								<?php endif; ?>
								<?=htmlspecialcharsbx($arResult["COPYRIGHT_SECONDARY"]["SUFFIX"])?>
							</p>
						</div>
					<?php endif; ?>
					<?php if ($arResult["TELEGRAM_LINK"] !== ""): ?>
						<div class="copyright_icon">
							<a href="<?=htmlspecialcharsbx($arResult["TELEGRAM_LINK"])?>" class="svg">
								<img src="<?=SITE_TEMPLATE_PATH?>/img/telegram.svg" class="svg_color" alt="<?=htmlspecialcharsbx(Loc::getMessage("SPORINA_FOOTER_TELEGRAM_ALT"))?>">
							</a>
						</div>
					<?php endif; ?>
					<?php if ($arResult["GOOGLE_PLAY_LINK"] !== ""): ?>
						<div class="copyright_icon">
							<a href="<?=htmlspecialcharsbx($arResult["GOOGLE_PLAY_LINK"])?>" class="svg">
								<img src="<?=SITE_TEMPLATE_PATH?>/img/googlePlay.svg" class="svg_color" alt="<?=htmlspecialcharsbx(Loc::getMessage("SPORINA_FOOTER_GOOGLE_PLAY_ALT"))?>">
							</a>
						</div>
					<?php endif; ?>
					<?php if ($arResult["APP_STORE_LINK"] !== ""): ?>
						<div class="copyright_icon">
							<a href="<?=htmlspecialcharsbx($arResult["APP_STORE_LINK"])?>" class="svg">
								<img src="<?=SITE_TEMPLATE_PATH?>/img/appStore.svg" class="svg_color" alt="<?=htmlspecialcharsbx(Loc::getMessage("SPORINA_FOOTER_APP_STORE_ALT"))?>">
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</footer>
