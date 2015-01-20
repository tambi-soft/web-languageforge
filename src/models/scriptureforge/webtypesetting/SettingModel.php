<?php

namespace models\scriptureforge\webtypesetting;

use models\mapper\MongoMapper;

use models\mapper\IdReference;

use models\mapper\Id;
use models\mapper\MapOf;
use models\mapper\ArrayOf;

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
     * @var boolean
     */
    public $bodyColumnsTwo;

    /**
     * @var boolean
     */
    public $titleColumnsTwo;

    /**
     * @var boolean
     */
    public $introColumnsTwo;

    /**
     * @var boolean
     */
    public $columnGutterRule;

    /**
     * @var integer
     */
    public $columnShift;

    /**
     * @var integer
     */
    public $columnGutterRuleSkip;

    /**
     * @var integer
     */
    public $columnGutterFactor;

    /**
     * @var integer
     */
    public $headerPosition;

    /**
     * @var boolean
     */
    public $useRunningHeader;

    /**
     * @var boolean
     */
    public $useRunningHeaderRule;

    /**
     * @var integer
     */
    public $runningHeaderRulePosition;

    /**
     * @var string
     */
    public $runningHeaderTitleLeft;

    /**
     * @var string
     */
    public $runningHeaderTitleCenter;

    /**
     * @var string
     */
    public $runningHeaderTitleRight;

    /**
     * @var string
     */
    public $runningHeaderEvenLeft;

    /**
     * @var string
     */
    public $runningHeaderEvenCenter;

    /**
     * @var string
     */
    public $runningHeaderEvenRight;

    /**
     * @var string
     */
    public $runningHeaderOddLeft;

    /**
     * @var string
     */
    public $runningHeaderOddCenter;

    /**
     * @var string
     */
    public $runningHeaderOddRight;

    /**
     * @var boolean
     */
    public $omitChapterNumberRH;

    /**
     * @var boolean
     */
    public $showVerseReferences;

    /**
     * @var boolean
     */
    public $omitBookReference;

    /**
     * @var integer
     */
    public $footerPosition;

    /**
     * @var boolean
     */
    public $useRunningFooter;

    /**
     * @var string
     */
    public $runningFooterEvenLeft;

    /**
     * @var string
     */
    public $runningFooterEvenCenter;

    /**
     * @var string
     */
    public $runningFooterEvenRight;

    /**
     * @var string
     */
    public $runningFooterOddLeft;

    /**
     * @var string
     */
    public $runningFooterOddCenter;

    /**
     * @var string
     */
    public $runningFooterOddRight;

    /**
     * @var string
     */
    public $runningFooterTitleLeft;

    /**
     * @var string
     */
    public $runningFooterTitleCenter;

    /**
     * @var string
     */
    public $runningFooterTitleRight;

    /**
     * @var boolean
     */
    public $useFootnoteRule;

    /**
     * @var boolean
     */
    public $pageResetCallersFootnotes;

    /**
     * @var boolean
     */
    public $omitCallerInFootnotes;

    /**
     * @var boolean
     */
    public $useSpecialCallerFootnotes;

    /**
     * @var boolean
     */
    public $paragraphedFootnotes;

    /**
     * @var boolean
     */
    public $useNumericCallersFootnotes;

    /**
     * @var boolean
     */
    public $useSpecialCallerCrossrefs;

    /**
     * @var string
     */
    public $specialCallerCrossrefs;

    /**
     * @var boolean
     */
    public $useAutoCallerCrossrefs;

    /**
     * @var boolean
     */
    public $omitCallerInCrossrefs;

    /**
     * @var boolean
     */
    public $paragraphedCrossrefs;

    /**
     * @var boolean
     */
    public $useNumericCallersCrossrefs;

    /**
     * @var boolean
     */
    public $useBackground;

    /**
     * @var string
     */
    public $backgroundComponents;

    /**
     * @var string
     */
    public $watermarkText;

    /**
     * @var boolean
     */
    public $useDiagnostic;

    /**
     * @var string
     */
    public $diagnosticComponents;

    /**
     * @var string
     */
    public $pageSizeCode;

    /**
     * @var integer
     */
    public $pageWidth;

    /**
     * @var integer
     */
    public $pageHeight;

    /**
     * @var string
     */
    public $printerPageSizeCode;

    /**
     * @var boolean
     */
    public $useDocInfo;

    /**
     * @var string
     */
    public $docInfoText;

    /**
     * @var integer
     */
    public $bodyTextLeading;

    /**
     * @var integer
     */
    public $bodyFontSize;

    /**
     * @var boolean
     */
    public $rightToLeft;

    /**
     * @var boolean
     */
    public $justifyParagraphs;

    /**
     * @var integer
     */
    public $extraRightMargin;

    /**
     * @var string
     */
    public $chapterVerseSeperator;

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
        $this->dateCreated = new \DateTime();
        $this->dateEdited = new \DateTime();

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
     * @var \DateTime
     */
    public $dateCreated;

    /**
     * @var \DateTime
     */
    public $dateEdited;

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

