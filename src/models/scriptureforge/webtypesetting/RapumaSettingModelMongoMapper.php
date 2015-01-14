<?php
namespace models\scriptureforge\webtypesetting;

class RapumaSettingModelMongoMapper extends \models\mapper\MongoMapper
{
	/**
	 * @var RapumaSettingModelMongoMapper[]
	 */
	private static $_pool = array();

	/**
	 * @param string $databaseName
	 * @return RapumaSettingModelMongoMapper
	*/
	public static function connect($databaseName)
	{
		if (!isset(static::$_pool[$databaseName])) {
			static::$_pool[$databaseName] = new RapumaSettingModelMongoMapper($databaseName, 'RapumaSettings');
		}
		return static::$_pool[$databaseName];
	}

}
