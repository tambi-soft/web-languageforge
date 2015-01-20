<?php

namespace models\scriptureforge\webtypesetting\dto;

use models\scriptureforge\webtypesetting\commands\TypesettingSettingCommands;

use models\mapper\JsonEncoder;

use models\scriptureforge\webtypesetting\SettingModel;

use models\ProjectModel;

class TypesettingLayoutPageDto
{
    /**
     *
     * @param string $projectId
     * @returns array - the DTO array
     */
    public static function encode($projectId)
    {
    	$project = new ProjectModel($projectId);
		$setting = SettingModel::getCurrent($project);
    	$data = array();
    	
    	$data['layout'] = JsonEncoder::encode($setting->layout);
        return $data;
    }
}
