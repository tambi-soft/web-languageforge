<?php
namespace models\scriptureforge\rapuma;

use models\ProjectModel;

class RapumaSettingsCommands {
	
	/**
	 * 
	 * @param ProjectModel $project
	 */
	public static function readSettings($projectId) {
		$project = new ProjectModel($projectId);
		$rapumaProject = new RapumaProject($project);
		$config = $rapumaProject->readProjectConfig();

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
		$rapumaProject = new RapumaProject($project);
		$config = $rapumaProject->readProjectConfig();

		// provide filtering of properties
		$generalSettingsAllowed = array('box', 'lines', 'cropmarks');
		$projectInfoAllowed = array('languageCode', 'projectDescription', 'isbnNumber', 'projectName', 'typesetters', 'translators', 'projectTitle', 'finishDate', 'startDate');

		foreach ($generalSettingsAllowed as $prop) {
			$config['GeneralSettings'][$prop] = $settings['GeneralSettings'][$prop];
		}
		foreach ($projectInfoAllowed as $prop) {
			$config['ProjectInfo'][$prop] = $settings['ProjectInfo'][$prop];
		}
		$rapumaProject->updateProjectConfig($config);
	}
	
}

?>