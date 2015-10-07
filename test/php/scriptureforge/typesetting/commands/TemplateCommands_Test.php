<?php

use Api\Model\Scriptureforge\Typesetting\Command\TypesettingTemplateCommands;
use Api\Model\Scriptureforge\Typesetting\SettingModel;
use Api\Model\Mapper\JsonEncoder;

require_once __DIR__ . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';

class TestTypesettingTemplateCommands extends UnitTestCase
{
    public function testUpdateTemplate_CreatesNewTemplate()
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
        
        $settings = JsonEncoder::encode($model->layout);
        
        $result1 = TypesettingTemplateCommands::updateTemplate("Template1", $settings);
        
        $templateId = $result1;
        $this->assertNotNull($templateId);
        
        $templates = TypesettingTemplateCommands::listTemplates();
        
        $this->assertEqual(count($templates), 1);
    }
    
    public function testUpdateTemplate_UpdatesTemplate()
    {
        $e = new MongoTestEnvironment();
        $e->clean();
    
        $projectModel = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $projectModel->id->asString();
    
        //create settings
        $model = new SettingModel($projectModel);
        $model->layout->bodyColumnsTwo = true;
        $model->layout->gutterSize = 2;
        $model->layout->insideMargin = 3;
        $model->layout->outsideMargin = 4;
        $settings = JsonEncoder::encode($model->layout);
        
        //create Template    
        $result1 = TypesettingTemplateCommands::updateTemplate("Template1", $settings);
        
        //ensure template exists
        $templates = TypesettingTemplateCommands::listTemplates();
        $this->assertEqual(count($templates), 1);
    
        //update model
        $model->layout->bodyColumnsTwo = false;
        $model->layout->gutterSize = 5;
        $model->layout->insideMargin = 6;
        $model->layout->outsideMargin = 7;
        $settings = JsonEncoder::encode($model->layout);
        
        //updateTemplate
        $result1 = TypesettingTemplateCommands::updateTemplate("Template1", $settings);
        
        //ensure only 1 template exists
        $templates = TypesettingTemplateCommands::listTemplates();
        $this->assertEqual(count($templates), 1);
        
    }
}
