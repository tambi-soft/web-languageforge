<?php
namespace models\scriptureforge\webtypesetting;

class RapumaAssetModelMongoMapper extends \models\mapper\MongoMapper
{
	/**
	 * @var RapumaAssetModelMongoMapper[]
	 */
	private static $_pool = array();

	/**
	 * @param string $databaseName
	 * @return RapumaAssetModelMongoMapper
	*/
	public static function connect($databaseName)
	{
		if (!isset(static::$_pool[$databaseName])) {
			static::$_pool[$databaseName] = new RapumaAssetModelMongoMapper($databaseName, 'RapumaAssets');
		}
		return static::$_pool[$databaseName];
	}

}