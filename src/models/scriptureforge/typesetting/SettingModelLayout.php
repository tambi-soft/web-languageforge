<?php
namespace models\scriptureforge\typesetting;

class SettingModelLayout
{
    public function __construct() {
        // margins
        $this->insideMargin = 10;
        $this->outsideMargin = 10;
        $this->topMargin = 15;
        $this->bottomMargin = 10;

        // columns
        $this->bodyColumnsTwo = true;
        $this->titleColumnsTwo = false;
        $this->introColumnsTwo = false;
        $this->columnGutterRule = false;
        $this->columnShift = 5;
        $this->columnGutterRuleSkip = 0;
        $this->columnGutterFactor = 15;

        // header
        $this->headerPosition = 5;
        $this->useRunningHeader = true;
        $this->useRunningHeaderRule = false;
        $this->runningHeaderRulePosition = 4;

        $this->runningHeaderTitleLeft = "empty";
        $this->runningHeaderTitleCenter = "empty";
        $this->runningHeaderTitleRight = "empty";

        $this->runningHeaderEvenLeft = "firstref";
        $this->runningHeaderEvenCenter = "pagenumber";
        $this->runningHeaderEvenRight = "empty";

        $this->runningHeaderOddLeft = "empty";
        $this->runningHeaderOddCenter = "pagenumber";
        $this->runningHeaderOddRight = "lastref";

        $this->omitChapterNumberRH = false;
        $this->showVerseReferences = true;
        $this->omitBookReference = false;



        // footer
        $this->footerPosition = 5;
        $this->useRunningFooter = false;

        $this->runningFooterEvenLeft = "empty";
        $this->runningFooterEvenCenter = "empty";
        $this->runningFooterEvenRight = "empty";

        $this->runningFooterOddLeft = "empty";
        $this->runningFooterOddCenter = "empty";
        $this->runningFooterOddRight = "empty";

        $this->runningFooterTitleLeft = "empty";
        $this->runningFooterTitleCenter = "empty";
        $this->runningFooterTitleRight = "empty";


        //footnotes
        $this->useFootnoteRule = true;
        $this->pageResetCallersFootnotes = false;

        $this->omitCallerInFootnotes = false;
        //  omitCallerInFootnotes (string ‘f’)

        $this->useSpecialCallerFootnotes = false;
        $this->paragraphedFootnotes = true;
        $this->useNumericCallersFootnotes = false;
        $this->specialCallerFootnotes = "\\krn0.2em *\\kern0.4em";


        // cross references
        $this->useSpecialCallerCrossrefs = false;
        $this->specialCallerCrossrefs = "\\kern0.2em *\\kern0.4em";
        $this->useAutoCallerCrossrefs = true;
        $this->omitCallerInCrossrefs = false;
        $this->paragraphedCrossrefs = true;
        $this->useNumericCallersCrossrefs = false;

        //'editing' features
        $this->useBackground = false;
        $this->backgroundComponents = "watermark";
        $this->watermarkText = "DRAFT";
        $this->useDiagnostic = false;
        $this->diagnosticComponents = "leading";

        // print options
        $this->pageSizeCode = "custom"; // this shouldn't be visible
        $this->pageHeight = 210;
        $this->pageWidth = 148;
        $this->printerPageSizeCode = "A4";

        $this->useDocInfo = false;
        $this->docInfoText = "";

        // body text
        $this->bodyTextLeading = 12;
        $this->bodyFontSize = 10;
        $this->rightToLeft = false;
        $this->justifyParagraphs = true;


        //Misc

        //advanced
        $this->extraRightMargin = 0;
        $this->chapterVerseSeperator = ":";

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
?>