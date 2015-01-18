<?php
namespace models\scriptureforge\webtypesetting\commands;

use models\ProjectModel;
use models\scriptureforge\webtypesetting\SettingModel;
use models\mapper\JsonEncoder;

class TypesettingSettingsCommands {
	
	/**
	 * Return a single Settings instance for the given $settingsId 
	 * @param string $projectId
	 * @param string $settingsId
	 */
	public static function readSettings($projectId, $settingsId) {
		$project = new ProjectModel($projectId);
		$model = new SettingModel($projectModel, $settingsId);
		return JsonEncoder::encode($model);
	}
	
	/**
	 * Return a single Settings instance for the latest set of settings available
	 * @param string $projectId
	 * @param string $settingsId
	 */
	public static function readSettings($projectId, $settingsId) {
		$project = new ProjectModel($projectId);
		$model = new SettingModel($projectModel, $settingsId);
		return JsonEncoder::encode($model);
	}
	
	public static function updateSettings($projectId, $settings) {
		$project = new ProjectModel($projectId);
		$webtypesettingProject = new WebtypesettingProject($project);
		$config = $webtypesettingProject->readProjectConfig();

		// provide filtering of properties
		$generalSettingsAllowed = array('box', 'lines', 'cropmarks');
		$projectInfoAllowed = array('languageCode', 'projectDescription', 'isbnNumber', 'projectName', 'typesetters', 'translators', 'projectTitle', 'finishDate', 'startDate');

		foreach ($generalSettingsAllowed as $prop) {
			$config['GeneralSettings'][$prop] = $settings['GeneralSettings'][$prop];
		}
		foreach ($projectInfoAllowed as $prop) {
			$config['ProjectInfo'][$prop] = $settings['ProjectInfo'][$prop];
		}
		$webtypesettingProject->updateProjectConfig($config);
	}
	
	/**
	 * 
	 * @var string
	 */
	public $fontSize;
	
	/**
	 * 
	 * @var string
	 */
	public $illustrations;
	
	/**
	 * 
	 * @var string
	 */
	public $name;
	
}

?>