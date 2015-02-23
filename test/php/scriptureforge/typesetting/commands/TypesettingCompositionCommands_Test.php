<?php

use models\scriptureforge\typesetting\commands\TypesettingCompositionCommands;
use models\scriptureforge\typesetting\SettingModel;
use models\mapper\JsonEncoder;
use models\scriptureforge\typesetting\TypesettingBookModel;
use models\scriptureforge\typesetting\TypesettingIllustrationModel;

require_once dirname(__FILE__) . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';

//require_once dirname(__FILE__) . '/../../../../../src/models/scriptureforge/webtypesetting/commands/TypesettingCompositionCommands.php';

class TestTypesettingCompositionCommands extends UnitTestCase
{
    
    public function testGetBookHTML_NotEmpty()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();

        // setup preconditions


        // method under test
        $html = TypesettingCompositionCommands::getBookHTML(6, 44);

        // assertions to make sure things are working
        $this->assertNotEqual($html, '');
    }

    public function testGetAndSetParagraphProperties_works()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $projectModel = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $projectModel->id->asString();

        $settingModel = new SettingModel($projectModel);
        $bookModel = TypesettingBookModel::create('mat');
        $bookModel->paragraphProperties['c1v1']->growthFactor = 3;
        $settingModel->compositionBookAdjustments['mat'] = $bookModel;
        $encoded = JsonEncoder::encode($settingModel->compositionBookAdjustments['mat']->paragraphProperties);
        
        $bookId = 'mat';
        $result = TypesettingCompositionCommands::setParagraphProperties($projectId, $bookId, $encoded);
        
        $result = TypesettingCompositionCommands::getParagraphProperties($projectId, $bookId);
        
        $this->assertEqual(
                $bookModel->paragraphProperties['c1v1']->growthFactor,
                $result['c1v1']['growthFactor']
        );
        
    }
    
    public function testGetAndSetParagraphProperties_SetTwice_works()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        ini_set('xdebug.show_exception_trace', 'On');
        $projectModel = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $projectModel->id->asString();

        $settingModel = new SettingModel($projectModel);
        $bookModel = TypesettingBookModel::create('mat');
        $bookModel->paragraphProperties['c1v1']->growthFactor = 3;
        $settingModel->compositionBookAdjustments['mat'] = $bookModel;
        $encoded = JsonEncoder::encode($settingModel->compositionBookAdjustments['mat']->paragraphProperties);
        
        $bookId = 'mat';
        $result = TypesettingCompositionCommands::setParagraphProperties($projectId, $bookId, $encoded);

        $bookModel->paragraphProperties['c1v1']->growthFactor = 4;
        $settingModel->compositionBookAdjustments['mat'] = $bookModel;
        $encoded = JsonEncoder::encode($settingModel->compositionBookAdjustments['mat']->paragraphProperties);
        
        $result = TypesettingCompositionCommands::setParagraphProperties($projectId, $bookId, $encoded);
        
        
        $result = TypesettingCompositionCommands::getParagraphProperties($projectId, $bookId);
        
        $this->assertEqual(
                $bookModel->paragraphProperties['c1v1']->growthFactor,
                $result['c1v1']['growthFactor']
        );
        
    }
    
    public function testGetAndSetIllustrationProperties_works()
    {
        $e = new MongoTestEnvironment();
        $e->clean();
    
        $projectModel = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $projectModel->id->asString();
    
        $settingModel = new SettingModel($projectModel);
        $illustrationModel = TypesettingIllustrationModel::create('lb001');
        $illustrationModel->name = 'some name';
        $illustrationModel->caption = 'some caption';
        $settingModel->compositionIllustrationAdjustments['lb001'] = $illustrationModel;
        
        $encoded = JsonEncoder::encode($settingModel->compositionIllustrationAdjustments);
        
        $illustrationId = 'mat';
        $result = TypesettingCompositionCommands::setIllustrationProperties($projectId, $encoded);
    
        $result = TypesettingCompositionCommands::getIllustrationProperties($projectId);
    
        $this->assertEqual($encoded, $result);
    }
    
    
    public function testGetPageDto_existingSettings_dtoAsExpected() {
        $e = new MongoTestEnvironment();
        $e->clean();
        $projectModel = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $projectModel->id->asString();
        
        $settingModel = new SettingModel($projectModel);
        $illustrationModel = TypesettingIllustrationModel::create('lb001');
        $illustrationModel->name = 'some name';
        $illustrationModel->caption = 'some caption';
        $settingModel->compositionIllustrationAdjustments['lb001'] = $illustrationModel;
        $settingModel->write();
        
        $result = TypesettingCompositionCommands::getPageDto($projectId);
        $this->assertEqual($result['illustrationProperties']['lb001']['caption'], 'some caption');
        // TODO: checkother components of the Dto
        
    }
}
