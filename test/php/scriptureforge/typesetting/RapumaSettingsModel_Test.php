<?php



use models\ProjectModel;

use models\scriptureforge\typesetting\RapumaSettingListModel;
use models\scriptureforge\typesetting\RapumaSettingModel;



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
        
        $this->assertEqual('SomeSetting', $otherSetting->title);

        // Update
        $otherSetting->description = 'OtherSetting';
        $otherSetting->write();

        // Read back
        $otherSetting = new RapumaSettingModel($projectModel, $id);
        $this->assertEqual('OtherSetting', $otherSetting->description);

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
