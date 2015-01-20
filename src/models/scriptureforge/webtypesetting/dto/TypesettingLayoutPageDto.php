<?php

namespace models\scriptureforge\webtypesetting\dto;

use models\scriptureforge\webtypesetting\commands\TypesettingSettingCommand;

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
    public static function encode($projectId, $settingId)
    {
    	$project = new ProjectModel($projectId);
    	
    	if ($settingId == 'latest') {
    		$setting = SettingModel::getLatest($project);
    	} else {
	    	$setting = new SettingModel($project, $settingId);
    	}
    	$data = array();
    	
    	$data['layout'] = JsonEncoder::encode($setting->layout);
    	$data['templates'] = array();  // list of templates
        return $data;
    }
}
