<?php
use models\ProjectModel;

use models\scriptureforge\webtypesetting\RapumaSettingListModel;
use models\scriptureforge\webtypesetting\RapumaSettingModel;
use models\scriptureforge\webtypesetting\commands\TypesettingSettingCommand;
use models\mapper\JsonDecoder;
use models\mapper\JsonEncoder;

require_once dirname(__FILE__) . '/../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';

require_once TestPath . 'common/MongoTestEnvironment.php';

require_once SourcePath . "models/ProjectModel.php";
// require_once SourcePath . "models/RapumaSettingModel.php";

class TypesettingSettingCommand_Test extends UnitTestCase
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
        $projectId = $projectModel->id->asString();

        $testSetting = new RapumaSettingModel($projectModel);
        $testSettingData = JsonEncoder::encode($testSetting);
        //var_dump($testSettingData);

        // List
        $list = TypesettingSettingCommand::listTypesettingSetting($projectId);
        $list->read();
        $this->assertEqual(0, $list->count);

        // Create
        $settingId = TypesettingSettingCommand::updateTypesettingSetting($projectId, $testSettingData);
        $setting = new RapumaSettingModel($projectModel, $settingId);
        $this->assertNotNull($setting->layout);
        foreach(get_object_vars($setting->layout) as $attribute){
            $this->assertEqual('',$attribute);
        }

        // Read back
        $differentSetting = TypesettingSettingCommand::readTypesettingSetting($projectId, $settingId);
        $newSetting = JsonDecoder::decode($setting, $differentSetting);
        $this->assertNotEqual('',$differentSetting['id']);
        $newSetting = new RapumaSettingModel($projectModel,$differentSetting['id']);
        //test if differentSetting is read properly from database
        //testing if contents of RapumaSettingModels are the same
        $this->assertTrue($setting == $newSetting);


        // Update
        $newTestSettingData = $testSettingData;
        //make sure newTestSettingData reffers to previous setting created earlier
        $newTestSettingData['id'] = $settingId;
        $newTestSettingData['layout']['insideMargin'] = 50;
        $newTestSettingData['layout']['outsideMargin'] = 50;
        $settingId = TypesettingSettingCommand::updateTypesettingSetting($projectId, $newTestSettingData);

        // Read back
        $differentSetting = TypesettingSettingCommand::readTypesettingSetting($projectId, $settingId);
        $newSetting = JsonDecoder::decode($setting, $differentSetting);
        $this->assertEqual(50,$differentSetting['layout']['insideMargin']);
        $this->assertEqual(50,$differentSetting['layout']['outsideMargin']);
        $newSetting = new RapumaSettingModel($projectModel,$differentSetting['id']);
        //test if differentSetting is read properly from database
        //testing if contents of RapumaSettingModels are the same
        $this->assertTrue($setting == $newSetting);

        // List
        $list = TypesettingSettingCommand::listTypesettingSetting($projectId);
        $list->read();
        $this->assertEqual(1, $list->count);

        // Delete
        $totalDeleted = TypesettingSettingCommand::deleteTypesettingSetting($projectId, $settingId);
        $this->assertEqual(1,$totalDeleted);

        // List
        $list->read();
        $this->assertEqual(0, $list->count);

    }
}