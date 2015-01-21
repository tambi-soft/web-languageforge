<?php

use models\scriptureforge\webtypesetting\dto\TypesettingRenderPageDto;

use models\scriptureforge\webtypesetting\commands\TypesettingRenderCommands;

use models\scriptureforge\webtypesetting\SettingListModel;

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

class TestTypesettingRenderPageDto extends UnitTestCase
{
    public function __construct()
    {
        $e = new MongoTestEnvironment();
        $e->clean();
    }

    public function testEncode_twoExistingRuns_dtoReturnsThreeRuns()
    {
        $e = new MongoTestEnvironment();
        $e->clean();
        $projectModel = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $projectModel->id->asString();
        $userId = $e->createUser('chris', 'chris', 'chris@chris.me');
        
        TypesettingRenderCommands::doRender($projectId, $userId);
        TypesettingRenderCommands::doRender($projectId, $userId);
        
        
        $result = TypesettingRenderPageDto::encode($projectId);
        
        $this->assertEqual(count($result['runs']), 3);
    }

}