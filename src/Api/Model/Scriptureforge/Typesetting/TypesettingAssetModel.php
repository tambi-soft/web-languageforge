<?php

namespace Api\Model\Scriptureforge\Typesetting;

use Api\Model\Mapper\Id;
use Api\Model\Mapper\MapperModel;
use Api\Model\ProjectModel;

class TypesettingAssetModel extends MapperModel
{
    /**
     * @param ProjectModel $projectModel
     * @param string $id
     */
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

class TypesettingAssetFont extends MapperModel
{
    /**
     * @param ProjectModel $projectModel
     * @param string $id
     */
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
