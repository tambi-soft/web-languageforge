<?php

use models\scriptureforge\webtypesetting\SettingModel;
use models\scriptureforge\webtypesetting\commands\TypesettingSettingsCommands;
use models\mapper\JsonDecoder;
use models\mapper\JsonEncoder;

require_once dirname(__FILE__) . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';

class TestTypesettingSettingsCommands extends UnitTestCase
{
    public function testUpdateReadBack_ReadsBack()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $projectModel = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $projectModel->id->asString();
        
        $model = new SettingModel($projectModel);
        $model->layout->bodyColumnsTwo = true;
        $model->layout->gutterSize = 2;
        $model->layout->insideMargin = 3;
        $model->layout->outsideMargin = 4;
        
        $settings = JsonEncoder::encode($model);
        
        $result1 = TypesettingSettingsCommands::updateSettings($projectId, $settings);
//         var_dump($result1);
        
        $settingsId = $result1['id'];
        $this->assertNotNull($settingsId);
        
        $result2 = TypesettingSettingsCommands::readSettings($projectId, $settingsId); 
//         var_dump($result2);
        
        $this->assertEqual($result1, $result2);
        
        
    }
}
