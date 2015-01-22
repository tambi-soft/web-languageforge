<?php

use models\scriptureforge\typesetting\dto\TypesettingRenderPageDto;

use models\scriptureforge\typesetting\commands\TypesettingRenderCommands;

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