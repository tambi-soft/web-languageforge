<?php

namespace models\scriptureforge\webtypesetting;

use models\ProjectModel;

use models\mapper\MongoMapper;

use models\mapper\IdReference;

use models\mapper\Id;
use models\mapper\MapOf;
use models\mapper\ArrayOf;

class SettingModelLayout
{
	
	public function __construct() {
		// default settings here
	}
	
	/**
	 * @var integer
	 */
	public $insideMargin;

	/**
	 * @var integer
	 */
	public $outsideMargin;

	/**
	 * @var integer
	 */
	public $topMargin;

	/**
	 * @var integer
	 */
	public $bottomMargin;

	/**
	 * @var integer
	 */
	public $pageWidth;

	/**
	 * @var integer
	 */
	public $pageHeight;

	/**
	 * @var Boolean
	 */
	public $hasGutter;

	/**
	 * @var integer
	 */
	public $gutterSize;

	/**
	 * @var Boolean
	 */
	public $introColumnsTwo;

	/**
	 * @var Boolean
	 */
	public $titleColumnsTwo;

	/**
	 * @var Boolean
	 */
	public $bodyColumnsTwo;

	/**
	 * @var integer
	 */
	public $columnSpacingSize;

	/**
	 * @var Boolean
	 */
	public $showColumnSeparatorLine;

	/**
	 * @var integer
	 */
	public $headerPosition;

	/**
	 * @var integer
	 */
	public $footerPosition;

}

class SettingModel extends \models\mapper\MapperModel
{
    public function __construct($projectModel, $id = '')
    {
        $this->id = new Id();

        $this->layout = new SettingModelLayout();
        $this->assets = new ArrayOf(function ($data) {
			return new IdReference();
        });

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

}

