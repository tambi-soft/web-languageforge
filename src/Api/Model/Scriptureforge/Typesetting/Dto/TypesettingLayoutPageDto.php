<?php

namespace Api\Model\Scriptureforge\Typesetting\Dto;

use Api\Model\Mapper\JsonEncoder;
use Api\Model\Scriptureforge\Typesetting\SettingModel;
use Api\Model\ProjectModel;

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
