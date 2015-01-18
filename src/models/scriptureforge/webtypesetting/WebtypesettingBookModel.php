<?php

namespace models\scriptureforge\webtypesetting;

use models\mapper\MapOf;

use models\mapper\ArrayOf;
use models\mapper\Id;
use models\mapper\IdReference;
use models\ProjectModel;

// TODO This doesn't need to be in a collection of its own.  It can be a member of the SettingsModel CP 2015-01
class WebtypesettingBookModel extends \models\mapper\MapperModel
{
    public static function mapper($databaseName)
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new \models\mapper\MongoMapper($databaseName, 'webtypesettingBooks');
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
        $this->paragraphProperties = new MapOf(
		            function ($data) {
		                return new ParagraphProperty();
		            }
        		);
        $this->_projectModel = $projectModel;
        $databaseName = $projectModel->databaseName();
        parent::__construct(self::mapper($databaseName), $id);
    }

    /**
     * @var Id
     */
    public $id;
    
    /**
     * 
     * @var string
     */
    public $name;
    
    /**
     * 
     * @var string
     */
    public $assetId;
    
    /**
     * 
     * @var MapOf
     */
    public $paragraphProperties;
    
    public function getPngTempFolderPath() {
    	
    }
 }
