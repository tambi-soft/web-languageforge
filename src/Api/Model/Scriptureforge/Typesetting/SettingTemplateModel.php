<?php

namespace Api\Model\Scriptureforge\Typesetting;

use Api\Model\Mapper\Id;
use Api\Model\Mapper\MapperModel;

class SettingTemplateModel extends MapperModel
{
    public function __construct($id = "")
    {
        $this->id = new Id();
        $this->appName = "typesettingTemplate";
        $this->templateName = "";
        $this->layout = new SettingModelLayout();
        parent::__construct(SettingTemplateModelMongoMapper::connect(), $id);
    }
    
    public static function remove($id)
    {
        $mapper = SettingTemplateModelMongoMapper::connect();
        $mapper->remove($id);
    }
    
    /**
     * Finds the template with the matching name, otherwise returns a new SettingTemplateModel
     * @param string $name - the template name
     * @return SettingTemplateModel
     */
    public static function findTemplateByName($name)
    {
        $mapper = SettingTemplateModelMongoMapper::connect();
        $model = new SettingTemplateModel();
        $mapper->findOneByQuery($model, array('templateName' => $name));
        return $model;
    }
    
    /**
     * 
     * @var Id
     */
    public $id;
    
    /**
     *
     * @var string
     */
    public $templateName;
    
    /**
     *
     * @var string
     */
    public $appName;
}
