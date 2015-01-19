<?php
namespace models\scriptureforge\webtypesetting;

class SettingListModel extends \models\mapper\MapperListModel
{

    public static function mapper($databaseName)
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new \models\mapper\MongoMapper($databaseName, 'settings');
        }

        return $instance;
    }

	protected function __construct($projectModel, $query, $fields)
	{
		parent::__construct(
				self::mapper($projectModel->databaseName()),
				$query,
				$fields
		);
	}
	
	public static function all($projectModel)
	{
		return new SettingListModel(
				$projectModel,
				$query = array('description' => array('$regex' => '')),
				array('description')
		);
	}
	
	public static function templates($projectModel)
	{
		return new SettingListModel(
			$projectModel,
			array('templateName' => array('$ne' => "")),
			array('description')
		);
	}
	

}
