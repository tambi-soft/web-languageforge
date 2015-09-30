<?php

use models\scriptureforge\typesetting\SettingListModel;

use models\scriptureforge\typesetting\dto\TypesettingLayoutPageDto;

use models\scriptureforge\typesetting\SettingModel;

use models\ProjectModel;

use models\scriptureforge\typesetting\RapumaAssetListModel;
use models\scriptureforge\typesetting\RapumaAssetModel;

require_once dirname(__FILE__) . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';

require_once TestPath . 'common/MongoTestEnvironment.php';

require_once SourcePath . "models/ProjectModel.php";
// require_once SourcePath . "models/RapumaAssetModel.php";

class TestTypesettingLayoutPageDto extends UnitTestCase
{
    public function __construct()
    {
        $e = new MongoTestEnvironment();
        $e->clean();
    }

    public function testEncode_oneExistingSetting_dtoReturnsExistingSetting()
    {
        $e = new MongoTestEnvironment();
        $e->clean();
        $projectModel = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        
        $settingModel = new SettingModel($projectModel);
        $settingModel->layout->outsideMargin = 2;
        $settingModel->layout->insideMargin = 50;
        
        $settingId = $settingModel->write();
        
        $result = TypesettingLayoutPageDto::encode($projectModel->id->asString());
        
        $this->assertEqual($result['layout']['outsideMargin'], 2);
        $this->assertEqual($result['layout']['insideMargin'], 50);
    }

    public function testEncode_twoExistingSettings_dtoDisplaysLatestSetting()
    {
        $e = new MongoTestEnvironment();
        $e->clean();
        $projectModel = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        
        $settingModel = new SettingModel($projectModel);
        $settingModel->layout->outsideMargin = 2;
        $settingModel->layout->insideMargin = 50;
        $settingModel->write();
        
        //sleep(1);

        $settingModel = new SettingModel($projectModel);
        $settingModel->layout->outsideMargin = 3;
        $settingModel->layout->insideMargin = 40;
        $settingModel->write();
        
        $result = TypesettingLayoutPageDto::encode($projectModel->id->asString());
        
        $this->assertEqual($result['layout']['outsideMargin'], 3);
        $this->assertEqual($result['layout']['insideMargin'], 40);

    }
}