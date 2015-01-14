<?php
namespace models\scriptureforge\webtypesetting;

class RapumaSettingListModel extends \models\mapper\MapperListModel
{

	public function __construct($projectModel)
	{
		parent::__construct(
				RapumaSettingModelMongoMapper::connect($projectModel->databaseName()),
				array('description' => array('$regex' => '')),
				array('description')
		);
	}

}
