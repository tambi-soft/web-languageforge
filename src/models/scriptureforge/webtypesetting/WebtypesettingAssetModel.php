<?php

namespace models\scriptureforge\webtypesetting;

use models\mapper\ArrayOf;
use models\mapper\Id;
use models\mapper\IdReference;
use models\ProjectModel;

/**
 * 
 * @author chris
 * This is just a stub of the asset model class that is being developed by another team... will probably be overwritten
 *
 */
class WebtypesettingAssetModel extends \models\mapper\MapperModel
{
    public static function mapper($databaseName)
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new \models\mapper\MongoMapper($databaseName, 'webtypesettingAssets');
        }

        return $instance;
    }

    /**
     * @param ProjectModel $projectModel
     * @param string       $id
     */
    public function __construct($projectModel, $id = '')
    {
        $this->id = new Id();
        $this->_projectModel = $projectModel;
        $databaseName = $projectModel->databaseName();
        parent::__construct(self::mapper($databaseName), $id);
    }

    /**
     * @var Id
     */
    public $id;
    
    public $filename;
    
    private $_projectModel;
    
    public function getPath() {
    	return $this->_projectModel->getAssetsFolderPath() . "/" . $this->filename;
    }
 }
