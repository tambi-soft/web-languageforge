<?php
use models\scriptureforge\typesetting\SettingTemplateModel;
use models\scriptureforge\typesetting\SettingTemplateListModel;
use models\ProjectModel;

require_once dirname(__FILE__) . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';
require_once SourcePath . "models/ProjectModel.php";

class TestSettingTemplateModel extends UnitTestCase
{
    public function __construct()
    {
        $e = new MongoTestEnvironment();
        $e->clean();
    }

    public function testCRUD_Works()
    {
        $e = new MongoTestEnvironment();

        // List
        $list = new SettingTemplateListModel();
        $list->read();
        $this->assertEqual(0, $list->count);

        // Create
        $template = new SettingTemplateModel();
        $template->templateName = "Template 1";
        $template->layout->insideMargin = 1;
        $template->layout->outsideMargin = 2;
        $template->layout->topMargin = 3;
        $template->layout->bottomMargin = 4;
        $template->layout->pageWidth = 10;
        $template->layout->pageHeight = 10;
        $template->layout->introColumnsTwo = false;
        $template->layout->titleColumnsTwo = false;
        $template->layout->bodyColumnsTwo = false;
        $template->layout->columnSpacingSize =10;
        $template->layout->showColumnSeparatorLine = false;
        $template->layout->headerPosition = 10;
        $template->layout->footerPosition = 10;

        $id = $template->write();
        $this->assertNotNull($id);
        $this->assertIsA($id, 'string');
        $this->assertEqual($id, $template->id->asString());

        // Read back
        $otherTemplate = new SettingTemplateModel($id);
        $this->assertEqual($id, $otherTemplate->id->asString());
        $this->assertEqual(1, $otherTemplate->layout->insideMargin);
        $this->assertEqual(2, $otherTemplate->layout->outsideMargin);
        $this->assertEqual(3, $otherTemplate->layout->topMargin);
        $this->assertEqual(4, $otherTemplate->layout->bottomMargin);
        $this->assertEqual(10, $otherTemplate->layout->pageWidth);
        $this->assertEqual(10, $otherTemplate->layout->pageHeight);
        $this->assertFalse($otherTemplate->layout->introColumnsTwo);
        $this->assertFalse($otherTemplate->layout->titleColumnsTwo);
        $this->assertFalse($otherTemplate->layout->bodyColumnsTwo);
        $this->assertEqual(10, $otherTemplate->layout->headerPosition);
        $this->assertEqual(10, $otherTemplate->layout->footerPosition);

        $this->assertEqual("Template 1", $otherTemplate->templateName);

        // Update
        $otherTemplate->templateName = "OtherTemplate";
        $otherTemplate->layout->insideMargin = 100;
        $otherTemplate->layout->outsideMargin = 100;
        $otherTemplate->layout->topMargin = 10;
        $otherTemplate->layout->bottomMargin = 10;
        $otherTemplate->layout->pageWidth = 50;
        $otherTemplate->layout->pageHeight = 50;
        $otherTemplate->layout->introColumnsTwo = true;
        $otherTemplate->layout->titleColumnsTwo = true;
        $otherTemplate->layout->bodyColumnsTwo = true;
        $otherTemplate->layout->columnSpacingSize = 50;
        $otherTemplate->layout->showColumnSeparatorLine = true;
        $otherTemplate->layout->headerPosition = 50;
        $otherTemplate->layout->footerPosition = 50;
        $otherTemplate->write();

        // Read back
        $otherTemplate = new SettingTemplateModel($id);
        $this->assertEqual('OtherTemplate', $otherTemplate->templateName);
        $this->assertEqual($id, $otherTemplate->id->asString());
        $this->assertEqual(100, $otherTemplate->layout->insideMargin);
        $this->assertEqual(100, $otherTemplate->layout->outsideMargin);
        $this->assertEqual(10, $otherTemplate->layout->topMargin);
        $this->assertEqual(10, $otherTemplate->layout->bottomMargin);
        $this->assertEqual(50, $otherTemplate->layout->pageWidth);
        $this->assertEqual(50, $otherTemplate->layout->pageHeight);
        $this->assertTrue($otherTemplate->layout->introColumnsTwo);
        $this->assertTrue($otherTemplate->layout->titleColumnsTwo);
        $this->assertTrue($otherTemplate->layout->bodyColumnsTwo);
        $this->assertEqual(50, $otherTemplate->layout->headerPosition);
        $this->assertEqual(50, $otherTemplate->layout->footerPosition);

        // List
        $list->read();
        $this->assertEqual(1, $list->count);

        // Delete
        SettingTemplateModel::remove($id);

        // List
        $list->read();
        $this->assertEqual(0, $list->count);
    }

    public function testFindTemplateByName_Works(){
        $e = new MongoTestEnvironment();

        // Create template
        $name = "Template 1";
        $template = new SettingTemplateModel();
        $template->templateName = $name;
        $template->layout->insideMargin = 1;
        $template->layout->outsideMargin = 2;
        $template->layout->topMargin = 3;
        $template->layout->bottomMargin = 4;
        $template->layout->pageWidth = 10;
        $template->layout->pageHeight = 10;
        $template->layout->introColumnsTwo = false;
        $template->layout->titleColumnsTwo = false;
        $template->layout->bodyColumnsTwo = false;
        $template->layout->headerPosition = 10;
        $template->layout->footerPosition = 10;
        $id = $template->write();

        //get template
        $template2 = SettingTemplateModel::findTemplateByName($name);
        $this->assertEqual($template, $template2);

        //try to get nonexistant template
        $template3 = SettingTemplateModel::findTemplateByName("foo");
        $this->assertEqual($template3->id->asString(), '');
        $this->assertEqual(10, $template3->layout->insideMargin, "default insideMargin expected");
        $this->assertEqual(10, $template3->layout->outsideMargin, "default outsideMargin expected");
        $this->assertEqual(15, $template3->layout->topMargin, "default value expected");
        $this->assertEqual(10, $template3->layout->bottomMargin, "default topMargin expected");
        $this->assertEqual(148, $template3->layout->pageWidth, "default pageWidth expected");
        $this->assertEqual(210, $template3->layout->pageHeight, "default pageHeight expected");
        $this->assertEqual(false, $template3->layout->introColumnsTwo, "default introColumnsTwo expected");
        $this->assertEqual(false, $template3->layout->titleColumnsTwo, "default titleColumnsTwo expected");
        $this->assertEqual(true, $template3->layout->bodyColumnsTwo, "default bodyColumnsTwo expected");
        $this->assertEqual(5, $template3->layout->headerPosition, "default headerPosition expected");
        $this->assertEqual(5, $template3->layout->footerPosition, "default footerPosition expected");
    }
}