<?php
namespace models\scriptureforge\webtypesetting;

use models\ProjectModel;

class WebtypesettingSettingsCommands {
	
	/**
	 * 
	 * @param ProjectModel $project
	 */
	public static function readSettings($projectId) {
		$project = new ProjectModel($projectId);
		$webtypesettingProject = new WebtypesettingProject($project);
		$config = $webtypesettingProject->readProjectConfig();

		// provide filtering of properties
		$generalSettingsAllowed = array('box', 'lines', 'cropmarks');
		$projectInfoAllowed = array('languageCode', 'projectDescription', 'isbnNumber', 'projectName', 'typesetters', 'translators', 'projectTitle', 'finishDate', 'startDate');

		$settings = array('GeneralSettings' => array(), 'ProjectInfo' => array());
		foreach ($generalSettingsAllowed as $prop) {
			$settings['GeneralSettings'][$prop] = $config['GeneralSettings'][$prop];
		}
		foreach ($projectInfoAllowed as $prop) {
			$settings['ProjectInfo'][$prop] = $config['ProjectInfo'][$prop];
		}
		return $settings;
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