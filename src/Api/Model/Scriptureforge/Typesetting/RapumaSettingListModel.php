<?php

namespace Api\Model\Scriptureforge\Typesetting;

use Api\Model\Mapper\MapperListModel;

class RapumaSettingListModel extends MapperListModel
{
    public function __construct($projectModel, $templatesOnly = false)
    {
        if($templatesOnly) {
            $query = array('templateName' => array('$ne' => ""));
        } else {
            $query = array('description' => array('$regex' => ''));
        }

        parent::__construct(
            RapumaSettingModelMongoMapper::connect($projectModel->databaseName()),
            $query,
            array('description')
        );
   }
}
