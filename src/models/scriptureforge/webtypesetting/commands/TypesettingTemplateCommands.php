<?php
namespace models\scriptureforge\webtypesetting\commands;

use models\ProjectModel;
use models\mapper\JsonEncoder;
use models\mapper\JsonDecoder;

class TypesettingTemplateCommands {
	
	/**
	 * Returns the list of templates available 
	 * @param string $projectId
	 * @return array
	 */
	public static function listTemplates() {
		// TODO Templates are system global, they need to be stored in the TypesettingProjectModel CP 2015-01
		
		throw new \Exception('NYI');
	}
	
	public static function updateTemplate($name, $settings)
	{
		throw new \Exception('NYI');
	}
	
	public static function applyTemplate($name)
	{
		throw new \Exception('NYI');
	}

}

?>