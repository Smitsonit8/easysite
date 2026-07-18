<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>
<footer class="sporina-footer-compact container">
	<div class="sporina-footer-compact__wrap">
		<div class="sporina-footer-compact__grid">
			<div>
				<div class="sporina-footer-compact__section-title"><?=htmlspecialcharsbx(Loc::getMessage("SPORINA_FOOTER_COMPACT_CONTACTS"))?></div>
				<div class="sporina-footer-compact__contact">
					<?php if ($arResult["PHONE_1"]["TITLE"] !== ""): ?>
						<a class="contacts__value" href="<?=htmlspecialcharsbx($arResult["PHONE_1"]["HREF"])?>"><?=htmlspecialcharsbx($arResult["PHONE_1"]["TITLE"])?></a>
					<?php endif; ?>
					<?php if ($arResult["PHONE_1"]["LABEL"] !== ""): ?>
						<p><?=htmlspecialcharsbx($arResult["PHONE_1"]["LABEL"])?></p>
					<?php endif; ?>
					<?php if ($arResult["PHONE_2"]["TITLE"] !== ""): ?>
						<a class="contacts__value" href="<?=htmlspecialcharsbx($arResult["PHONE_2"]["HREF"])?>"><?=htmlspecialcharsbx($arResult["PHONE_2"]["TITLE"])?></a>
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
						<a class="contacts__value" href="<?=htmlspecialcharsbx($arResult["EMAIL"]["HREF"])?>"><?=htmlspecialcharsbx($arResult["EMAIL"]["TITLE"])?></a>
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
				<?php if ($arResult["SOCIAL"]["SHOW"]): foreach (array("VK", "MAX", "OK", "RUTUBE", "DZEN") as $social): if ($arResult["SOCIAL"][$social] === "") continue; ?>
					<a href="<?=htmlspecialcharsbx($arResult["SOCIAL"][$social])?>" class="footer-svg" target="_blank" rel="noopener noreferrer"><?=file_get_contents(__DIR__."/../../svg/social.".strtolower($social).".svg")?></a>
				<?php endforeach; endif; ?>
			</div>
		</div>
	</div>
</footer>
