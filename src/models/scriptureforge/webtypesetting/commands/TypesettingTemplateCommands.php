<?php
namespace models\scriptureforge\webtypesetting\commands;

use models\ProjectModel;
use models\mapper\JsonEncoder;
use models\mapper\JsonDecoder;
use models\scriptureforge\webtypesetting\SettingTemplateModel;
use models\scriptureforge\webtypesetting\SettingTemplateListModel;

class TypesettingTemplateCommands {
	
	/**
	 * Returns the list of templates available 
	 * @param string $projectId
	 * @return array
	 */
	public static function listTemplates() {
		return new SettingTemplateListModel();
	}
	
	public static function updateTemplate($name, $settings)
	{
		//finds template if it exists and update
		$template = SettingTemplateModel::findTemplateByName($name);
		$template->templateName = $name;
		foreach($template->layout as $key => $value){
			$template->layout->$key = $settings[$key];
		}
		$template->write();
		return $template->id;
	}
	
	public static function getTemplate($name)
	{
		$template = SettingTemplateModel::findTemplateByName($name);
		return $template->layout;
	}

}

?>