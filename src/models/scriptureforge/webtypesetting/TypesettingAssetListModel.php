<?php
namespace models\scriptureforge\webtypesetting;

class TypesettingAssetListModel extends \models\mapper\MapperListModel
{

        public function __construct($projectModel)
        {
                parent::__construct(
                                TypesettingAssetModelMongoMapper::connect($projectModel->databaseName()),
                                array('name' => array('$regex' => '')),
                                array('name')
                );
        }

}