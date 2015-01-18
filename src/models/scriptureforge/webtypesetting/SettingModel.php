<?php

namespace models\scriptureforge\webtypesetting;

use models\mapper\MongoMapper;

use models\mapper\IdReference;

use models\mapper\Id;
use models\mapper\MapOf;

class SettingModelLayout
{
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

        $this->templateName = "";
        $this->workflowState = "open"; // default workflow state
        $this->description = '';
        $this->title = '';
        $this->dateCreated = new \DateTime();
        $this->dateEdited = new \DateTime();
        $this->textRef = new IdReference();
//         $this->answers = new MapOf(
//             function () {
//                 return new AnswerModel();
//             }
//         );

        $databaseName = $projectModel->databaseName();
        parent::__construct(SettingModelMongoMapper::connect($databaseName), $id);
    }

    /**
     * Removes this Setting from the collection
     * @param string $databaseName
     * @param string $id
     */
    public static function remove($databaseName, $id)
    {
        $mapper = SettingModelMongoMapper::connect($databaseName);
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
     *
     * @var string - optional name if settings are a template
     */
    public $templateName;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string A content description/explanation of the Setting being asked
     */
    public $description;

    /**
     * @var \DateTime
     */
    public $dateCreated;

    /**
     * @var \DateTime
     */
    public $dateEdited;

    /**
     * @var IdReference - Id of the referring text
     */
    public $textRef;

    /**
     * @var MapOf<AnswerModel>
     */
    public $answers;

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

