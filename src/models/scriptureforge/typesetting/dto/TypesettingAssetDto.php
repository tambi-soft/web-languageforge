<?php
namespace models\scriptureforge\typesetting\dto;

use libraries\shared\palaso\exceptions\ResourceNotAvailableException;
use models\shared\dto\RightsHelper;
use models\shared\rights\ProjectRoles;
use models\scriptureforge\WebtypesettingProjectModel;
use models\mapper\JsonEncoder;
use models\scriptureforge\typesetting\TypesettingAssetModel;
use models\scriptureforge\typesetting\TypesettingAssetListModel;

class TypesettingAssetDto
{

    /**
     *
     * @param string $projectId
     * @param string $textId
     * @param string $userId
     * @return array - the DTO array
     */
    public static function encode($projectId)
    {
        $project = new WebtypesettingProjectModel($projectId);
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
