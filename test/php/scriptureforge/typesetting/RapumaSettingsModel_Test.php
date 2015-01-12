<?php
use models\ProjectModel;

use models\scriptureforge\webtypesetting\RapumaSettingListModel;
use models\scriptureforge\webtypesetting\RapumaSettingModel;

require_once dirname(__FILE__) . '/../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';

require_once TestPath . 'common/MongoTestEnvironment.php';

require_once SourcePath . "models/ProjectModel.php";
// require_once SourcePath . "models/RapumaSettingModel.php";

class TestRapumaSettingModel extends UnitTestCase
{
    public function __construct()
    {
        $e = new MongoTestEnvironment();
        $e->clean();
    }

    public function testCRUD_Works()
    {
        $e = new MongoTestEnvironment();
        $projectModel = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);

        // List
        $list = new RapumaSettingListModel($projectModel);
        $list->read();
        $this->assertEqual(0, $list->count);

        // Create
        $setting = new RapumaSettingModel($projectModel);
        $setting->layout->insideMargin = 1;
        $setting->layout->outsideMargin = 2;
        $setting->layout->topMargin = 3;
        $setting->layout->bottomMargin = 4;
        $setting->layout->pageWidth = 10;
        $setting->layout->pageHeight = 10;
        $setting->layout->hasGutter = false;
        $setting->layout->gutterSize = 0;
        $setting->layout->introColumnsTwo = false;
        $setting->layout->titleColumnsTwo = false;
        $setting->layout->bodyColumnsTwo = false;
        $setting->layout->columnSpacingSize =10;
        $setting->layout->showColumnSeparatorLine = false;
        $setting->layout->headerPosition = 10;
        $setting->layout->footerPosition = 10;


        $setting->title = "SomeSetting";
        $setting->description = "SomeSetting";
        $id = $setting->write();
        $this->assertNotNull($id);
        $this->assertIsA($id, 'string');
        $this->assertEqual($id, $setting->id->asString());

        // Read back
        $otherSetting = new RapumaSettingModel($projectModel, $id);
        $this->assertEqual($id, $otherSetting->id->asString());
        $this->assertEqual(1, $otherSetting->layout->insideMargin);
        $this->assertEqual(2, $otherSetting->layout->outsideMargin);
        $this->assertEqual(3, $otherSetting->layout->topMargin);
        $this->assertEqual(4, $otherSetting->layout->bottomMargin);
        $this->assertEqual(10, $otherSetting->layout->pageWidth);
        $this->assertEqual(10, $otherSetting->layout->pageHeight);
        $this->assertFalse($otherSetting->layout->hasGutter);
        $this->assertEqual(0, $otherSetting->layout->gutterSize);
        $this->assertFalse($otherSetting->layout->introColumnsTwo);
        $this->assertFalse($otherSetting->layout->titleColumnsTwo);
        $this->assertFalse($otherSetting->layout->bodyColumnsTwo);
        $this->assertEqual(10, $otherSetting->layout->columnSpacingSize);
        $this->assertFalse($otherSetting->layout->showColumnSeparatorLine);
        $this->assertEqual(10, $otherSetting->layout->headerPosition);
        $this->assertEqual(10, $otherSetting->layout->footerPosition);

        $this->assertEqual('SomeSetting', $otherSetting->title);

        // Update
        $otherSetting->description = 'OtherSetting';
        $otherSetting->layout->insideMargin = 100;
        $otherSetting->layout->outsideMargin = 100;
        $otherSetting->layout->topMargin = 10;
        $otherSetting->layout->bottomMargin = 10;
        $otherSetting->layout->pageWidth = 50;
        $otherSetting->layout->pageHeight = 50;
        $otherSetting->layout->hasGutter = true;
        $otherSetting->layout->gutterSize = 10;
        $otherSetting->layout->introColumnsTwo = true;
        $otherSetting->layout->titleColumnsTwo = true;
        $otherSetting->layout->bodyColumnsTwo = true;
        $otherSetting->layout->columnSpacingSize = 50;
        $otherSetting->layout->showColumnSeparatorLine = true;
        $otherSetting->layout->headerPosition = 50;
        $otherSetting->layout->footerPosition = 50;
        $otherSetting->write();

        // Read back
        $otherSetting = new RapumaSettingModel($projectModel, $id);
        $this->assertEqual('OtherSetting', $otherSetting->description);
        $this->assertEqual($id, $otherSetting->id->asString());
        $this->assertEqual(100, $otherSetting->layout->insideMargin);
        $this->assertEqual(100, $otherSetting->layout->outsideMargin);
        $this->assertEqual(10, $otherSetting->layout->topMargin);
        $this->assertEqual(10, $otherSetting->layout->bottomMargin);
        $this->assertEqual(50, $otherSetting->layout->pageWidth);
        $this->assertEqual(50, $otherSetting->layout->pageHeight);
        $this->assertTrue($otherSetting->layout->hasGutter);
        $this->assertEqual(10, $otherSetting->layout->gutterSize);
        $this->assertTrue($otherSetting->layout->introColumnsTwo);
        $this->assertTrue($otherSetting->layout->titleColumnsTwo);
        $this->assertTrue($otherSetting->layout->bodyColumnsTwo);
        $this->assertEqual(50, $otherSetting->layout->columnSpacingSize);
        $this->assertTrue($otherSetting->layout->showColumnSeparatorLine);
        $this->assertEqual(50, $otherSetting->layout->headerPosition);
        $this->assertEqual(50, $otherSetting->layout->footerPosition);


        // List
        $list->read();
        $this->assertEqual(1, $list->count);

        // Delete
        RapumaSettingModel::remove($projectModel->databaseName(), $id);

        // List
        $list->read();
        $this->assertEqual(0, $list->count);

    }
    
    public function testTemplate_Works(){
    	$e = new MongoTestEnvironment();
    	$projectModel = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
    	
    	// List
    	$list = new RapumaSettingListModel($projectModel, true);
    	$list->read();
    	$this->assertEqual(0, $list->count);
    	
    	// Create Template
    	$setting = new RapumaSettingModel($projectModel);
    	$setting->templateName = "Template 1";
    	
    	$id = $setting->write();
    	$this->assertNotNull($id);
    	$this->assertIsA($id, 'string');
    	$this->assertEqual($id, $setting->id->asString());
    	
    	// List
    	$list = new RapumaSettingListModel($projectModel, true);
    	$list->read();
    	$this->assertEqual(1, $list->count);
    	
    	// Create NonTemplate
    	$setting = new RapumaSettingModel($projectModel);
    	 
    	$id = $setting->write();
    	$this->assertNotNull($id);
    	$this->assertIsA($id, 'string');
    	$this->assertEqual($id, $setting->id->asString());
    	
    	// List
    	$list = new RapumaSettingListModel($projectModel, true);
    	$list->read();
    	$this->assertEqual(1, $list->count);
    	
    }
/*
    public function testTextReference_NullRefValidRef_AllowsNullRef()
    {
        $projectModel = new MockProjectModel();
        $mockTextRef = (string) new \MongoId();

        // Test create with null textRef
        $setting = new RapumaSettingModel($projectModel);
        $id = $setting->write();

        $otherSetting = new RapumaSettingModel($projectModel, $id);
        $this->assertEqual('', $otherSetting->textRef->id);

        // Test update with textRef
        $setting->textRef->id = $mockTextRef;
        $setting->write();

        $otherSetting = new RapumaSettingModel($projectModel, $id);
        $this->assertEqual($mockTextRef, $otherSetting->textRef->id);

    }
*/
}
