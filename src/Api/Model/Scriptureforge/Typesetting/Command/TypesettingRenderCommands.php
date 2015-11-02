<?php

namespace Api\Model\Scriptureforge\Typesetting\Command;

use Api\Model\Mapper\Id;
use Api\Model\Mapper\JsonDecoder;
use Api\Model\Mapper\JsonEncoder;
use Api\Model\ProjectModel;
use Api\Model\Scriptureforge\Typesetting\SettingModel;

class TypesettingRenderCommands
{
    public static function doRender($projectId, $userId)
    {
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
