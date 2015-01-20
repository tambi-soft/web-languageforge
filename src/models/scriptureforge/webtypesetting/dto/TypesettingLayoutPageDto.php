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
    public static function encode($projectId, $settingId)
    {
    	// if a settingId is latest, we get the latest and set the "isCurrent" flag on the model if it is not already set
    	
    	// if a specific settingId is passed in, we copy those settings to a new model, and set the "isCurrent" flag, and then populate the dto from that new model
    	
    	$project = new ProjectModel($projectId);
    	
    	if ($settingId == 'latest') {
    		$setting = SettingModel::getCurrent($project);
    	} else {
	    	$setting = new SettingModel($project, $settingId);
    	}
    	$data = array();
    	
    	$data['layout'] = JsonEncoder::encode($setting->layout);
    	$data['templates'] = array();  // list of templates
        return $data;
    }
}
