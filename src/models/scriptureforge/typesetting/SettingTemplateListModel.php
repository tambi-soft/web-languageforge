<?php
namespace models\scriptureforge\typesetting;

class SettingTemplateListModel extends \models\mapper\MapperListModel
{

	public function __construct()
	{
		parent::__construct(
				SettingTemplateModelMongoMapper::connect(),
				array('templateName' => array('$ne' => "")),
				array('description')
		);
	}

}
