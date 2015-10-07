<?php

namespace Api\Model\Scriptureforge\Typesetting\Dto;

use Api\Model\Scriptureforge\Typesetting\TypesettingAssetListModel;
use Api\Model\Scriptureforge\TypesettingProjectModel;

class TypesettingAssetDto
{
    /**
     *
     * @param string $projectId
     * @return array - the DTO array
     */
    public static function encode($projectId)
    {
        $project = new TypesettingProjectModel($projectId);
        $assetList = new TypesettingAssetListModel($project);
        $assetList->read();

        $data = array();
        $data['project'] = array(
            'id' => $projectId,
            'name' => $project->projectName,
            'slug' => $project->databaseName()
        );
        $data['entries'] = $assetList->entries;
        
        $data['count'] = count($data['entries']);

        return $data;
    }
}
