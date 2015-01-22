<?php
namespace models\scriptureforge\typesetting\commands;

use models\mapper\Id;

use models\ProjectModel;
use models\mapper\JsonEncoder;
use models\mapper\JsonDecoder;
use models\scriptureforge\typesetting\SettingModel;
use models\scriptureforge\typesetting\SettingListModel;

class TypesettingRenderCommands {
	
	public static function doRender($projectId, $userId) {
		$projectModel = new ProjectModel($projectId);
		
		$currentSettingModel = SettingModel::getCurrent($projectModel);
		
		$currentSettingModel->renderedBy->createdByUserRef->id = $userId;
		$newSettingsModel = new SettingModel($projectModel);
		
		// duplicate current settings
		JsonDecoder::decode($newSettingsModel, JsonEncoder::encode($currentSettingModel));
		$newSettingsModel->id = new Id();
		
		// TODO: kick off render here
		
		return $newSettingsModel->write();
	}
	
}

?>