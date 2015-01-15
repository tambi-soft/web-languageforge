<?php
namespace models\scriptureforge\webtypesetting;

class RapumaAssetListModel extends \models\mapper\MapperListModel
{

	public function __construct($projectModel)
	{
		parent::__construct(
				RapumaAssetModelMongoMapper::connect($projectModel->databaseName()),
				array('description' => array('$regex' => '')),
				array('description')
		);
	}

}