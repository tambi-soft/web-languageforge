<?php

namespace models\scriptureforge\webtypesetting\commands;

use libraries\shared\Website;

use Palaso\Utilities\CodeGuard;
use libraries\scriptureforge\sfchecks\Email;
use models\UserModel;
use models\shared\dto\ManageUsersDto;
use models\mapper\Id;
use models\mapper\JsonDecoder;
use models\mapper\JsonEncoder;
use models\shared\rights\Domain;

use models\sms\SmsSettings;
use models\ProjectModel;
use models\scriptureforge\webtypesetting\RapumaSettingListModel;
use models\scriptureforge\webtypesetting\RapumaSettingModel;

class TypesettingSettingCommand
{
    /**
     * @param id $projectId
     * @param string $id TypesettingSetting id
     * @return count of successful delete of typesettingsetting
     */
    public static function deleteTypesettingSetting($projectId, $id)
    {
        CodeGuard::checkTypeAndThrow($id, 'string');
        $count = 0;
        $projectModel = new ProjectModel($projectId);
        CodeGuard::checkTypeAndThrow($id, 'string');
        $typesettingSetting = new RapumaSettingModel($projectModel, $id);
        $typesettingSetting->remove($projectModel->databaseName(),$id);
        return 1;
    }

    /**
     * @param id $projectId
     * @param array $params
     */
    public static function updateTypesettingSetting($projectId, $params)
    {
        $projectModel = new ProjectModel($projectId);
        $typesettingSetting = new RapumaSettingModel($projectModel);
        $isNewTypesettingSetting = ($params['id'] == '');
        if(!$isNewTypesettingSetting){
            $typesettingSetting->read($params['id']);
        }
        JsonDecoder::decode($typesettingSetting, $params);
        $typesettingSettingId = $typesettingSetting->write();

        return $typesettingSettingId;
    }

    /**
     * @param id $projectId
     * @param id RapumaSettingModel id
     * @return RapumaSetting
     */
    public static function readTypesettingSetting($projectId, $id)
    {
        $projectModel = new ProjectModel($projectId);
        $typesettingSetting = new RapumaSettingModel($projectModel, $id);

        return JsonEncoder::encode($typesettingSetting);
    }

    /**
     * @param id $projectId
     * @return array Total number of RapumaSettings for a project.
     */
    public static function listTypesettingSetting($projectId)
    {
        $projectModel = new ProjectModel($projectId);
        $list = new RapumaSettingListModel($projectModel);
        $list->read();

        return $list;
    }
}
