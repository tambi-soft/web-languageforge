<?php
namespace models\scriptureforge\typesetting;

class SettingTemplateModelMongoMapper extends \models\mapper\MongoMapper
{
    /**
     * @var SettingTemplateModelMongoMapper[]
     */
    private static $_pool = array();

    /**
     * @return SettingTemplateModelMongoMapper
    */
    public static function connect()
    {
        if (!isset(static::$_pool[SF_DATABASE])) {
            static::$_pool[SF_DATABASE] = new SettingTemplateModelMongoMapper(SF_DATABASE, 'Templates');
        }
        return static::$_pool[SF_DATABASE];
    }

}
