<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/install/wizard_sol/wizard.php');

// Подключаем языковые файлы мастера
$wizardPath = str_replace("\\", "/", __DIR__);
$langFile = $wizardPath."/lang/".LANGUAGE_ID."/wizard.php";
if (file_exists($langFile))
{
	__IncludeLang($langFile);
}

class SelectSiteStep extends CSelectSiteWizardStep
{
	function InitStep()
	{
		parent::InitStep();
		
		$wizard = $this->GetWizard();
		$wizard->solutionName = "easy_site";
		
		$this->SetNextStep("select_template");
	}
}

class SelectTemplateStep extends CSelectTemplateWizardStep
{
	function InitStep()
	{
		$this->SetStepID("select_template");
		$this->SetTitle(GetMessage("SELECT_TEMPLATE_TITLE"));
		$this->SetSubTitle(GetMessage("SELECT_TEMPLATE_SUBTITLE"));
		$this->SetNextStep("select_theme");
		$this->SetNextCaption(GetMessage("NEXT_BUTTON"));
	}
	
	function OnPostForm()
	{
		$wizard = $this->GetWizard();
		
		if ($wizard->IsNextButtonClick())
		{
			$arTemplates = array("sporina_easy_site");
			
			$templateID = $wizard->GetVar("wizTemplateID");
			
			if (!in_array($templateID, $arTemplates))
				$this->SetError(GetMessage("wiz_template"));
			
			if (in_array($templateID, array("sporina_easy_site")))
				$wizard->SetVar("templateID", "sporina_easy_site");
		}
	}
	
	function ShowStep()
	{
		$wizard = $this->GetWizard();
		
		$templatesPath = WizardServices::GetTemplatesPath($wizard->GetPath()."/site");
		$arTemplates = WizardServices::GetTemplates($templatesPath);
		
		$arTemplateOrder = array();
		
		if (in_array("sporina_easy_site", array_keys($arTemplates)))
		{
			$arTemplateOrder[] = "sporina_easy_site";
		}
		
		$defaultTemplateID = COption::GetOptionString("main", "wizard_template_id", "sporina_easy_site", $wizard->GetVar("siteID"));
		if (!in_array($defaultTemplateID, array("sporina_easy_site"))) $defaultTemplateID = "sporina_easy_site";
		$wizard->SetDefaultVar("wizTemplateID", $defaultTemplateID);
		
		$arTemplateInfo = array(
			"sporina_easy_site" => array(
				"NAME" => GetMessage("WIZ_TEMPLATE_EASY_SITE"),
				"DESCRIPTION" => GetMessage("WIZ_TEMPLATE_EASY_SITE_DESC"),
				"PREVIEW" => $wizard->GetPath()."/images/".LANGUAGE_ID."/preview.gif",
				"SCREENSHOT" => $wizard->GetPath()."/images/".LANGUAGE_ID."/screen.gif",
			),
		);
		
		global $SHOWIMAGEFIRST;
		$SHOWIMAGEFIRST = true;
		
		$this->content .= '<div class="inst-template-list-block">';
		foreach ($arTemplateOrder as $templateID)
		{
			$arTemplate = $arTemplateInfo[$templateID];
			
			if (!$arTemplate)
				continue;
			
			$this->content .= '<div class="inst-template-description">';
			$this->content .= $this->ShowRadioField("wizTemplateID", $templateID, Array("id" => $templateID, "class" => "inst-template-list-inp"));
			
			global $SHOWIMAGEFIRST;
			$SHOWIMAGEFIRST = true;
			
			if ($arTemplate["SCREENSHOT"] && $arTemplate["PREVIEW"])
				$this->content .= CFile::Show2Images($arTemplate["PREVIEW"], $arTemplate["SCREENSHOT"], 150, 150, ' class="inst-template-list-img"');
			else
				$this->content .= CFile::ShowImage($arTemplate["SCREENSHOT"], 150, 150, ' class="inst-template-list-img"', "", true);
			
			$this->content .= '<label for="'.$templateID.'" class="inst-template-list-label">'.$arTemplate["NAME"]."</label>";
			if (!empty($arTemplate["DESCRIPTION"]))
				$this->content .= '<div class="inst-template-description-text">'.$arTemplate["DESCRIPTION"]."</div>";
			$this->content .= "</div>";
		}
		
		$this->content .= "</div>";
	}
}

class SelectThemeStep extends CSelectThemeWizardStep
{
	function InitStep()
	{
		$this->SetStepID("select_theme");
		$this->SetTitle(GetMessage("SELECT_THEME_TITLE"));
		$this->SetSubTitle(GetMessage("SELECT_THEME_SUBTITLE"));
		$this->SetNextStep("site_settings");
		$this->SetNextCaption(GetMessage("NEXT_BUTTON"));

		$wizard = $this->GetWizard();
		$templateID = $wizard->GetVar("templateID");
		if (!$templateID)
		{
			$templateID = $wizard->GetDefaultVar("wizTemplateID");
		}
		if (!$templateID)
		{
			$templateID = "sporina_easy_site";
		}
		$wizard->SetDefaultVar($templateID . "_themeID", "blue");
	}
}

class SiteSettingsStep extends CSiteSettingsWizardStep
{
	function InitStep()
	{
		$wizard = $this->GetWizard();
		$wizard->solutionName = "easy_site";
		parent::InitStep();
		
		$this->SetNextStep("data_install");
		$this->SetPrevStep("select_theme");
		$this->SetNextCaption(GetMessage("NEXT_BUTTON"));
		$this->SetTitle(GetMessage("WIZ_STEP_SITE_SET"));
		
		$siteID = $wizard->GetVar("siteID");
		$templateID = $wizard->GetVar("templateID");
		
		$wizard->SetDefaultVars(Array(
			//"siteName" => $this->GetFileContent(WIZARD_SITE_PATH."include/company_name.php", GetMessage("WIZ_COMPANY_NAME_DEF")),
			"siteTelephone" => $this->GetFileContent(WIZARD_SITE_PATH."include/telephone.php", GetMessage("WIZ_COMPANY_TELEPHONE_DEF")),
			"siteAdress" => $this->GetFileContent(WIZARD_SITE_PATH."include/adress.php", GetMessage("WIZ_COMPANY_ADRESS_DEF")),
			"siteEmail" => $this->GetFileContent(WIZARD_SITE_PATH."include/email.php", GetMessage("WIZ_COMPANY_EMAIL_DEF")),
			"siteCopy" => $this->GetFileContent(WIZARD_SITE_PATH."include/copyright.php", GetMessage("WIZ_COMPANY_COPY_DEF")),
			"siteMetaDescription" => GetMessage("wiz_site_desc"),
			"siteMetaKeywords" => GetMessage("wiz_keywords"),
			"installDemoData" => "Y",
		));
	}
	
	function ShowStep()
	{
		$wizard = $this->GetWizard();
		
		$this->content .= '<div class="wizard-input-form">';
		/*
		$this->content .= '
		<div class="wizard-input-form-block">
			<label for="siteName" class="wizard-input-title">'.GetMessage("WIZ_COMPANY_NAME").'</label>
			'.$this->ShowInputField('text', 'siteName', array("id" => "siteName", "class" => "wizard-field")).'
		</div>';
		*/
		$this->content .= '
		<div class="wizard-input-form-block">
			<label for="siteTelephone" class="wizard-input-title">'.GetMessage("WIZ_COMPANY_TELEPHONE").'</label>
			'.$this->ShowInputField('text', 'siteTelephone', array("id" => "siteTelephone", "class" => "wizard-field")).'
		</div>';

		$this->content .= '
		<div class="wizard-input-form-block">
			<label for="siteAdress" class="wizard-input-title">'.GetMessage("WIZ_COMPANY_ADRESS").'</label>
			'.$this->ShowInputField('text', 'siteAdress', array("id" => "siteAdress", "class" => "wizard-field")).'
		</div>';

		$this->content .= '
		<div class="wizard-input-form-block">
			<label for="siteEmail" class="wizard-input-title">'.GetMessage("WIZ_COMPANY_EMAIL").'</label>
			'.$this->ShowInputField('text', 'siteEmail', array("id" => "siteEmail", "class" => "wizard-field")).'
		</div>';
		
		$this->content .= '
		<div class="wizard-input-form-block">
			<label for="siteCopy" class="wizard-input-title">'.GetMessage("WIZ_COMPANY_COPY").'</label>
			'.$this->ShowInputField('textarea', 'siteCopy', array("rows"=>"3", "id" => "siteCopy", "class" => "wizard-field")).'
		</div>';
		
		$firstStep = COption::GetOptionString("main", "wizard_first".mb_substr($wizard->GetID(), 7)  . "_" . $wizard->GetVar("siteID"), false, $wizard->GetVar("siteID"));
		$styleMeta = 'style="display:block"';
		if($firstStep == "Y") $styleMeta = 'style="display:none"';
		
		$this->content .= '
		<div id="bx_metadata" '.$styleMeta.'>
			<div class="wizard-input-form-block">
				<div class="wizard-metadata-title">'.GetMessage("wiz_meta_data").'</div>
				<label for="siteMetaDescription" class="wizard-input-title">'.GetMessage("wiz_meta_description").'</label>
				'.$this->ShowInputField("textarea", "siteMetaDescription", Array("id" => "siteMetaDescription", "rows"=>"3", "class" => "wizard-field")).'
			</div>';
		$this->content .= '
			<div class="wizard-input-form-block">
				<label for="siteMetaKeywords" class="wizard-input-title">'.GetMessage("wiz_meta_keywords").'</label><br>
				'.$this->ShowInputField('text', 'siteMetaKeywords', array("id" => "siteMetaKeywords", "class" => "wizard-field")).'
			</div>
		</div>';
		
		// Установка демо-данных
		if($firstStep == "Y")
		{
			$this->content .= '
			<div class="wizard-input-form-block">
				'.$this->ShowCheckboxField(
							"installDemoData",
							"Y",
							(array("id" => "installDemoData", "onClick" => "if(this.checked == true){document.getElementById('bx_metadata').style.display='block';}else{document.getElementById('bx_metadata').style.display='none';}"))
						).'
				<label for="installDemoData">'.GetMessage("wiz_structure_data").'</label>
			</div>';
		}
		else
		{
			$this->content .= $this->ShowHiddenField("installDemoData","Y");
		}
		
		$this->content .= '</div>';
	}
}

class DataInstallStep extends CDataInstallWizardStep
{
	function CorrectServices(&$arServices)
	{
		$wizard = $this->GetWizard();
		$installDemoData = $wizard->GetVar("installDemoData");
		
		if ($installDemoData != "Y")
		{
			// Если демо-данные не установлены, пропускаем импорт инфоблоков
			if (isset($arServices["iblock"]))
			{
				unset($arServices["iblock"]["STAGES"]["import.php"]);
			}
		}
		
		$arServices = $this->prepareServices($arServices);
	}
	
	public function prepareServices($arServices)
	{
		
		return $arServices;
	}

	function InitStep()
	{
		parent::InitStep();
		$this->SetPrevStep("site_settings");
	}
}

class FinishStep extends CFinishWizardStep
{
	function InitStep()
	{
		$this->SetStepID("finish");
		$this->SetNextStep("finish");
		$this->SetTitle(GetMessage("FINISH_STEP_TITLE"));
		$this->SetNextCaption(GetMessage("wiz_go"));
	}
	
	function ShowStep()
	{
		$wizard = $this->GetWizard();
		
		$siteID = WizardServices::GetCurrentSiteID($wizard->GetVar("siteID"));
		$rsSites = CSite::GetByID($siteID);
		$siteDir = "/";
		if ($arSite = $rsSites->Fetch())
			$siteDir = $arSite["DIR"];
		
		$wizard->SetFormActionScript(str_replace("//", "/", $siteDir."/?finish"));
		
		$this->CreateNewIndex();
		
		COption::SetOptionString("main", "wizard_solution", $wizard->solutionName, false, $siteID);
		
		$this->content .=
			'<table class="wizard-completion-table">
				<tr>
					<td class="wizard-completion-cell">'
						.GetMessage("FINISH_STEP_CONTENT").
					'</td>
				</tr>
			</table>';
		
		if ($wizard->GetVar("installDemoData") == "Y")
			$this->content .= GetMessage("FINISH_STEP_REINDEX");
	}
}
?>
