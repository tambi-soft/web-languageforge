<?php

namespace Api\Model\Scriptureforge\Typesetting;

use Api\Model\Mapper\MongoMapper;

class TypesettingAssetModelMongoMapper extends MongoMapper
{
    /**
     * @var TypesettingAssetModelMongoMapper[]
     */
    private static $_pool = array();

    /**
     * @param string $databaseName
     * @return TypesettingAssetModelMongoMapper
    */
    public static function connect($databaseName)
    {
        if (!isset(static::$_pool[$databaseName])) {
            static::$_pool[$databaseName] = new TypesettingAssetModelMongoMapper($databaseName, 'TypesettingAssets');
        }
        return static::$_pool[$databaseName];
    }
}
