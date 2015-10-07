<?php

use Api\Model\Scriptureforge\Typesetting\Dto\TypesettingRenderPageDto;
use Api\Model\Scriptureforge\Typesetting\Command\TypesettingRenderCommands;
use Api\Model\Scriptureforge\Typesetting\RapumaAssetListModel;
use Api\Model\Scriptureforge\Typesetting\RapumaAssetModel;

require_once __DIR__ . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';

class TestTypesettingRenderPageDto extends UnitTestCase
{
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
