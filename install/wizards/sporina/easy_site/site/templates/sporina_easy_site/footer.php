<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();
?>
<!-- футер для всех страниц одинаковый, на главной странице серый фон находится в блоке новости-->
    <footer>
        <div class="container">
            <div class="block_between footer_margin">
                <div class="footer_block">
                    <div class="footer_block-grid">
                        <div class="footer_contact">
							<h3>
                            <? $APPLICATION->IncludeComponent(
								"bitrix:main.include",
								"", array(
								    "AREA_FILE_SHOW" => "file",
								    "PATH" => SITE_DIR."include/telephone.php"
								),
								false
							);?>
							
							</h3>
							
								<? $APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"", array(
										"AREA_FILE_SHOW" => "file",
										"PATH" => SITE_DIR."include/telephone_label.php"
									),
									false
								);?>
							
                        </div>
                    </div>
                    <div class="footer_block-grid">
                        <div class="footer_contact">
							<h3>
								<? $APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"", array(
										"AREA_FILE_SHOW" => "file",
										"PATH" => SITE_DIR."include/telephone_2.php"
									),
									false
								);?>
							</h3>
							<? $APPLICATION->IncludeComponent(
								"bitrix:main.include",
									"", array(
										"AREA_FILE_SHOW" => "file",
										"PATH" => SITE_DIR."include/telephone_2_label.php"
									),
									false
							);?>                        
                            
                        </div>
                    </div>
                    <div class="footer_block-grid">
                        <div class="footer_contact">
							<h3>
								<? $APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"", array(
										"AREA_FILE_SHOW" => "file",
										"PATH" => SITE_DIR."include/email.php"
									),
									false
								);?>
							</h3>                 
                            <? $APPLICATION->IncludeComponent(
								"bitrix:main.include",
								"", array(
								    "AREA_FILE_SHOW" => "file",
								    "PATH" => SITE_DIR."include/email_label.php"
								),
								false
							);?>
                        </div>
                    </div>
                </div>
                <div class="footer_block">
                    <div class="footer_block-grid">
                        <div class="footer_contact">
							<h3>
								<? $APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"", array(
										"AREA_FILE_SHOW" => "file",
										"PATH" => SITE_DIR."include/adress.php"
									),
									false
								);?>
							</h3>
                            <? $APPLICATION->IncludeComponent(
								"bitrix:main.include",
								"", array(
								    "AREA_FILE_SHOW" => "file",
								    "PATH" => SITE_DIR."include/adress_label.php"
								),
								false
							);?>
                        </div>
                    </div>
                    <div class="footer_block-grid">
                        <div class="footer_contact footer_license">
                            <? $APPLICATION->IncludeComponent(
								"bitrix:main.include",
								"", array(
								    "AREA_FILE_SHOW" => "file",
								    "PATH" => SITE_DIR."include/doc.php"
								),
								false
							);?>
                        </div>
                    </div>
                    <div class="footer_block-grid">
                        <div class="footer_contact">
                            <? $APPLICATION->IncludeComponent(
								"bitrix:main.include",
								"", array(
								    "AREA_FILE_SHOW" => "file",
								    "PATH" => SITE_DIR."include/policy.php"
								),
								false
							);?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block_top-border  block_between copyright_margin">
                <div class="copyright_block copyright_order1">
                    <div class="copyright copyright_width">
                        <? $APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"", array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => SITE_DIR."include/copyright.php"
							),
							false
						);?>
                    </div>
                </div>
                <div class="copyright_block mobile_none copyright_order2"></div>
                <div class="copyright_block copyright_order3">
                    <div class="copyright_flex">
                        <div class="copyright">
                            <? $APPLICATION->IncludeComponent(
								"bitrix:main.include",
								"", array(
								    "AREA_FILE_SHOW" => "file",
								    "PATH" => SITE_DIR."include/copyright_2.php"
								),
								false
							);?>
                        </div>
                        <div class="copyright_icon">
                            <? $APPLICATION->IncludeComponent(
								"bitrix:main.include",
								"", array(
								    "AREA_FILE_SHOW" => "file",
								    "PATH" => SITE_DIR."include/teleg.php"
								),
								false
							);?>
                        </div>
                        <div class="copyright_icon">
                            <? $APPLICATION->IncludeComponent(
								"bitrix:main.include",
								"", array(
								    "AREA_FILE_SHOW" => "file",
								    "PATH" => SITE_DIR."include/google.php"
								),
								false
							);?>
                        </div>
                        <div class="copyright_icon">                            
                            <? $APPLICATION->IncludeComponent(
								"bitrix:main.include",
								"", array(
								    "AREA_FILE_SHOW" => "file",
								    "PATH" => SITE_DIR."include/apple.php"
								),
								false
							);?>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/dist/owl.carousel.min.js"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/my_js.js"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/slide.js"></script>
</body>
</html>