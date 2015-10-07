<?php

namespace Api\Model\Scriptureforge\Typesetting;

use Api\Model\Mapper\MapperListModel;

class SettingTemplateListModel extends MapperListModel
{
    public function __construct()
    {
        parent::__construct(
                SettingTemplateModelMongoMapper::connect(),
                array('templateName' => array('$ne' => "")),
                array('description')
        );
    }
}
