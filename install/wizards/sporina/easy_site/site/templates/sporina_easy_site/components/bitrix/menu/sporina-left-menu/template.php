<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<!--<ul class="left-menu">-->

      <ul class="nav_company">
		<?
		foreach($arResult as $arItem):
			if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
				continue;
		?>
			<?if($arItem["SELECTED"]):?>
				<a href="<?=$arItem["LINK"]?>" class="selected">
					<li class="nav_company-active">
						<p class="nav_company-border"><?=$arItem["TEXT"]?></p>
					</li>
				</a>
			<?else:?>
				<a href="<?=$arItem["LINK"]?>"><li><p class="nav_company-border"><?=$arItem["TEXT"]?></p></li></a>
			<?endif?>
			
		<?endforeach?>

      </ul>

<!--</ul>-->
<?endif?>