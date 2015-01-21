<?php
namespace models\scriptureforge\webtypesetting;
use models\mapper\MongoMapper;
use models\mapper\IdReference;
use models\mapper\Id;
use models\mapper\MapOf;


class TypesettingAssetModel extends \models\mapper\MapperModel
{
	
	public function __construct($projectModel, $id = '')
	{
		$this->id = new Id();
		
		$databaseName = $projectModel->databaseName();
		parent::__construct(TypesettingAssetModelMongoMapper::connect($databaseName), $id);
		
	}
	
 	public $id;
 	
 	/**
 	 * @var string
 	 */
	public $name;
	
	/**
	 * @var string
	 */
	public $path;
	
	/**
	 * @var string
	 */
	public $type;
	
	/**
	 * @var boolean
	 */
	public $uploaded;
	
	
	public static function remove($databaseName, $id)
	{
		$mapper = TypesettingAssetModelMongoMapper::connect($databaseName);
		$mapper->remove($id);
	}
	
}
	

class TypesettingAssetFont extends \models\mapper\MapperModel
{

	public function __construct($projectModel, $id = '')
	{
		$this->id = new Id();
		
		$databaseName = $projectModel->databaseName();
		parent::__construct(TypesettingAssetModelMongoMapper::connect($databaseName), $id);
	}

	public $id;
	
	/**
	 * @var string
	 */
	public $name;
	
	/**
	 * @var string
	 */
	public $path;
	
	/**
	 * @var boolean
	 */
	public $active;
	
	/**
	 * @var boolean
	 */
	public $primary;
	
	public static function remove($databaseName, $id)
	{
		$mapper = TypesettingAssetModelMongoMapper::connect($databaseName);
		$mapper->remove($id);
	}

}