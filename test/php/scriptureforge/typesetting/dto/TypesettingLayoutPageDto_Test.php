<?php

use models\scriptureforge\webtypesetting\dto\TypesettingLayoutPageDto;

use models\scriptureforge\webtypesetting\SettingModel;

use models\ProjectModel;

use models\scriptureforge\webtypesetting\RapumaAssetListModel;
use models\scriptureforge\webtypesetting\RapumaAssetModel;

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

    public function testEncode_existingSetting_dtoAsExpected()
    {
        $e = new MongoTestEnvironment();
        $e->clean();
        $projectModel = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        
        $settingModel = new SettingModel($projectModel);
        $settingModel->layout->outsideMargin = 2;
        $settingModel->layout->insideMargin = 50;
        
        $settingId = $settingModel->write();
        
        $result = TypesettingLayoutPageDto::encode($projectModel->id->asString(), $settingId);
        
        $this->assertEqual($result['layout']['outsideMargin'], 2);
        $this->assertEqual($result['layout']['insideMargin'], 50);

    }

    public function testEncode_latestKeyword_dtoDisplaysLatestSetting()
    {
        $e = new MongoTestEnvironment();
        $e->clean();
        $projectModel = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        
        $settingModel = new SettingModel($projectModel);
        $settingModel->layout->outsideMargin = 2;
        $settingModel->layout->insideMargin = 50;
        
        $settingId = $settingModel->write();

        $settingModel = new SettingModel($projectModel);
        $settingModel->layout->outsideMargin = 1;
        $settingModel->layout->insideMargin = 5;
        $settingModel->write();
        
        $settingModel = new SettingModel($projectModel);
        $settingModel->layout->outsideMargin = 3;
        $settingModel->layout->insideMargin = 40;
        $settingModel->write();

        $result = TypesettingLayoutPageDto::encode($projectModel->id->asString(), 'latest');
        
        $this->assertEqual($result['layout']['outsideMargin'], 3);
        $this->assertEqual($result['layout']['insideMargin'], 40);

    }
}