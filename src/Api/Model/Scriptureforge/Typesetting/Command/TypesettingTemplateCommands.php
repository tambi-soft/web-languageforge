<?php

namespace Api\Model\Scriptureforge\Typesetting\Command;

use Api\Model\Scriptureforge\Typesetting\SettingTemplateListModel;
use Api\Model\Scriptureforge\Typesetting\SettingTemplateModel;

class TypesettingTemplateCommands
{
    /**
     * Returns the list of templates available 
     * @return array
     */
    public static function listTemplates()
    {
        return new SettingTemplateListModel();
    }
    
    public static function updateTemplate($name, $settings)
    {
        //finds template if it exists and update
        $template = SettingTemplateModel::findTemplateByName($name);
        $template->templateName = $name;
        foreach($template->layout as $key => $value){
            $template->layout->$key = $settings[$key];
        }
        $template->write();
        return $template->id;
    }
    
    public static function getTemplate($name)
    {
        $template = SettingTemplateModel::findTemplateByName($name);
        return $template->layout;
    }
}
