<?php
namespace models\scriptureforge\webtypesetting;

class SettingListModel extends \models\mapper\MapperListModel
{

	protected function __construct($projectModel, $query, $fields)
	{
		parent::__construct(
				SettingModelMongoMapper::connect($projectModel->databaseName()),
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
