<?php
namespace models\scriptureforge\typesetting\commands;

use models\ProjectModel;
use models\mapper\JsonEncoder;
use models\mapper\JsonDecoder;
use models\scriptureforge\typesetting\SettingModel;
use models\scriptureforge\typesetting\SettingListModel;

class TypesettingSettingsCommands {
	
	/**
	 * Return a single Settings instance for the given $settingsId 
	 * @param string $projectId
	 * @param string $settingsId
	 */
	/*
	public static function readSettings($projectId, $settingsId) {
		$projectModel = ProjectModel::getById($projectId);
		$model = new SettingModel($projectModel, $settingsId);
		return JsonEncoder::encode($model);
	}
	*/
	
	/**
	 * Return a single Settings instance for the latest set of settings available
	 * @param string $projectId
	 */
	/*
	public static function readSettingsLatest($projectId) {
		$projectModel = ProjectModel::getById($projectId);
		$model = new SettingModel($projectModel, $settingsId);
		return JsonEncoder::encode($model);
	}
	*/
	
	/**
	 * Writes the Setting object from the (possibly partial) $settings json object.
	 * @param string $projectId
	 * @param array $settings A json like array of settings
	 * @return array
	 */

	public static function updateLayoutSettings($projectId, $userId, $settings) {
		$projectModel = new ProjectModel($projectId);
		$currentSettingModel = SettingModel::getCurrent($projectModel);
		if ($currentSettingModel->author->createdByUserRef->asString() == "") {
			$currentSettingModel->author->createdByUserRef->id = $userId;
		}

		$currentSettingModel->author->modifiedByUserRef->id = $userId;
		$currentSettingModel->author->modifiedDate = new \DateTime();

		JsonDecoder::decode($currentSettingModel->layout, $settings);
		return $currentSettingModel->write();
	}
	
}

?>