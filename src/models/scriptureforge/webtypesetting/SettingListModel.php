<?php
namespace models\scriptureforge\webtypesetting;

class SettingListModel extends \models\mapper\MapperListModel
{

	public function __construct($projectModel, $templatesOnly = false)
	{
		
		if($templatesOnly){
			$query = array('templateName' => array('$ne' => ""));
		}else{
			$query = array('description' => array('$regex' => ''));
		}
		parent::__construct(
				SettingModelMongoMapper::connect($projectModel->databaseName()),
				$query,
				array('description')
		);
	}
	
	

}
