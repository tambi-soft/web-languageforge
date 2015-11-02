<?php

namespace Api\Model\Scriptureforge\Typesetting;

use Api\Model\Mapper\MapperListModel;
use Api\Model\ProjectModel;

class TypesettingAssetListModel extends MapperListModel
{
    /**
     * @param ProjectModel $projectModel
     */
    public function __construct($projectModel)
    {
        parent::__construct(
            TypesettingAssetModelMongoMapper::connect($projectModel->databaseName()),
            array('name' => array('$regex' => '')),
            array('name', 'type', 'path', 'uploaded')
        );
    }
}
