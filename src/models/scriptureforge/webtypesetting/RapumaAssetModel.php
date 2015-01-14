<?php
namespace models\scriptureforge\webtypesetting;
use models\mapper\MongoMapper;
use models\mapper\IdReference;
use models\mapper\Id;
use models\mapper\MapOf;


class RapumaAssetModel extends \models\mapper\MapperModel
{
	
	public function __construct($projectModel, $id = '')
	{
		$this->id = new Id();

		$this->title = '';
		$this->data = '';

		$databaseName = $projectModel->databaseName();
		parent::__construct(RapumaAssetModelMongoMapper::connect($databaseName), $id);
	}

	/**
	 * Removes this RapumaAsset from the collection
	 * @param string $databaseName
	 * @param string $id
	 */
	public static function remove($databaseName, $id)
	{
		$mapper = RapumaAssetModelMongoMapper::connect($databaseName);
		$mapper->remove($id);
	}

	/**
	 * @var Id
	 */
	public $id;

	/**
	 * @var string
	 */
	public $title;

	/**
	 * @var string
	 */
	public $data;

}
