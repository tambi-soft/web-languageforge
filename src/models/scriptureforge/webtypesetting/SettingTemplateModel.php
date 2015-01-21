<?php

namespace models\scriptureforge\webtypesetting;

use models\mapper\Id;
use models\mapper\MapperModel;
require_once 'SettingModel.php';

class SettingTemplateModel extends \models\mapper\MapperModel{

	public function __construct($id = ""){
		
		$this->id = new Id();
		$this->appName = "typesettingTemplate";
		$this->templateName = "";
		$this->layout = new SettingModelLayout();
		parent::__construct(SettingTemplateModelMongoMapper::connect(), $id);
	}
	
	public static function remove($id)
	{
		$mapper = SettingTemplateModelMongoMapper::connect();
		$mapper->remove($id);
	}
	
	/**
	 * Finds the template with the matching name, otherwise returns a new SettingTemplateModel
	 * @param string $name - the template name
	 * @return \models\scriptureforge\webtypesetting\SettingTemplateModel
	 */
	public static function findTemplateByName($name){
		$mapper = SettingTemplateModelMongoMapper::connect();
		$model = new SettingTemplateModel();
		$mapper->findOneByQuery($model, array('templateName' => $name));
		return $model;
	}
	
	/**
	 * 
	 * @var \models\mapper\Id
	 */
	public $id;
	
	/**
	 *
	 * @var string
	 */
	public $templateName;
	
	/**
	 *
	 * @var string
	 */
	public $appName;

}

