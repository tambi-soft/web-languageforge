<?php

namespace models\scriptureforge\typesetting;

use models\languageforge\lexicon\AuthorInfo;

use models\mapper\JsonDecoder;

use models\mapper\JsonEncoder;

use models\ProjectModel;

use models\mapper\MongoMapper;

use models\mapper\IdReference;

use models\mapper\Id;
use models\mapper\MapOf;
use models\mapper\ArrayOf;



class SettingModel extends \models\mapper\MapperModel
{
    public function __construct($projectModel, $id = '')
    {
        $this->id = new Id();
        $this->setReadOnlyProp('author');

        $this->layout = new SettingModelLayout();
        $this->assets = new ArrayOf(function ($data) {
			return new IdReference();
        });
        $this->author = new AuthorInfo();
        $this->renderedBy = new AuthorInfo();
        
        $this->workflowState = "open"; // default workflow state
        $this->description = '';
        $this->title = '';
        $this->isArchived = false;

        $databaseName = $projectModel->databaseName();
        parent::__construct(self::mapper($databaseName), $id);
    }

    public static function mapper($databaseName)
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new \models\mapper\MongoMapper($databaseName, 'settings');
        }

        return $instance;
    }

    /**
     * Removes this Setting from the collection
     * @param ProjectModel $projectModel
     * @param string $id
     */
    public static function remove($projectModel, $id)
    {
    	$databaseName = $projectModel->databaseName();
        $mapper = self::mapper($databaseName);
        $mapper->remove($id);
    }

    public static function getCurrent($projectModel) {
    	$settingsList = new SettingListModel($projectModel);
    	$settingsList->read();
    	if ($settingsList->count > 0) {

    		// get the latest setting by modification time
	    	$settingId = $settingsList->entries[0]['id'];
	    	$settingModel = new SettingModel($projectModel, $settingId);

    	}
    	else {
    		$settingModel = new SettingModel($projectModel);
	    	$settingModel->write();
    	}

    	return $settingModel;
    }

     /**
     * @var Id
     */
    public $id;

    /**
     * @var SettingModelLayout
     */
    public $layout;

    /**
     * @var ArrayOf
     */
    public $assets;

    /**
     * @var string
     */
    public $title;
    
    /**
     * @var string A content description/explanation of the Setting being asked
     */
    public $description;

    /**
     *
     * @var string
     */
    public $workflowState;

    /**
     * @var Boolean
     */
    public $isArchived;
    
    /**
     * 
     * @var AuthorInfo
     */
    public $author;
    
    /**
     * 
     * @var AuthorInfo
     */
    public $renderedBy;
    
}

