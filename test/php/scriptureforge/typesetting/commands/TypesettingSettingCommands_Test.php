<?php

use Api\Model\Scriptureforge\Typesetting\SettingModel;
use Api\Model\Scriptureforge\Typesetting\Command\TypesettingSettingsCommands;
use Api\Model\Scriptureforge\Typesetting\RapumaSettingModel;
use Api\Model\Scriptureforge\Typesetting\Command\TypesettingSettingCommands;
use Api\Model\Mapper\JsonDecoder;
use Api\Model\Mapper\JsonEncoder;

require_once __DIR__ . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';

class TypesettingSettingCommands_Test extends UnitTestCase
{
    public function testUpdateLayoutSetting_currentSetting_layoutUpdated() {
        $e = new MongoTestEnvironment();
        $e->clean();

        $projectModel = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $projectModel->id->asString();
        
        $userId = $e->createUser('me', 'me', 'me@me.com');
        
        $layoutSetting = array();
        $layoutSetting['docInfoText'] = 'my text';

        $currentSetting = SettingModel::getCurrent($projectModel);
        $this->assertEqual($currentSetting->layout->docInfoText, "");
        
        TypesettingSettingsCommands::updateLayoutSettings($projectId, $userId, $layoutSetting);
        
        $currentSetting = SettingModel::getCurrent($projectModel);
        $this->assertEqual($currentSetting->layout->docInfoText, "my text");
    }

    /* cjh disabled since it's using the wrong models (should use SettingsModel)
    public function testCRUD_Works() {
        $e = new MongoTestEnvironment();
        $projectModel = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $projectModel->id->asString();

        $testSetting = new RapumaSettingModel($projectModel);
        $testSettingData = JsonEncoder::encode($testSetting);
        //var_dump($testSettingData);

        // List
        $list = TypesettingSettingCommands::listTypesettingSetting($projectId);
        $list->read();
        $this->assertEqual(0, $list->count);

        // Create
        $settingId = TypesettingSettingCommands::updateLayoutSettings($projectId, $testSettingData);
        $setting = new RapumaSettingModel($projectModel, $settingId);
        $this->assertNotNull($setting->layout);
        foreach(get_object_vars($setting->layout) as $attribute){
            $this->assertEqual('',$attribute);
        }

        // Read back
        $differentSetting = TypesettingSettingCommands::readTypesettingSetting($projectId, $settingId);
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
        $settingId = TypesettingSettingCommands::updateLayoutSettings($projectId, $newTestSettingData);

        // Read back
        $differentSetting = TypesettingSettingCommands::readTypesettingSetting($projectId, $settingId);
        $newSetting = JsonDecoder::decode($setting, $differentSetting);
        $this->assertEqual(50,$differentSetting['layout']['insideMargin']);
        $this->assertEqual(50,$differentSetting['layout']['outsideMargin']);
        $newSetting = new RapumaSettingModel($projectModel,$differentSetting['id']);
        //test if differentSetting is read properly from database
        //testing if contents of RapumaSettingModels are the same
        $this->assertTrue($setting == $newSetting);

        // List
        $list = TypesettingSettingCommands::listTypesettingSetting($projectId);
        $list->read();
        $this->assertEqual(1, $list->count);

        // Delete
        $totalDeleted = TypesettingSettingCommands::deleteTypesettingSetting($projectId, $settingId);
        $this->assertEqual(1,$totalDeleted);

        // List
        $list->read();
        $this->assertEqual(0, $list->count);

    }
    */
}