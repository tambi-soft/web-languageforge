<?php
namespace models\scriptureforge\webtypesetting;

class SettingModelMongoMapper extends \models\mapper\MongoMapper
{
	/**
	 * @var SettingModelMongoMapper[]
	 */
	private static $_pool = array();

	/**
	 * @param string $databaseName
	 * @return SettingModelMongoMapper
	*/
	public static function connect($databaseName)
	{
		if (!isset(static::$_pool[$databaseName])) {
			static::$_pool[$databaseName] = new SettingModelMongoMapper($databaseName, 'Settings');
		}
		return static::$_pool[$databaseName];
	}

}
