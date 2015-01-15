<?php


use models\AnswerModel;
use models\CommentModel;
use models\QuestionModel;
use models\TextModel;
use models\scriptureforge\webtypesetting\WebtypesettingSettingsCommands;

require_once dirname(__FILE__) . '/../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';

class TestWebtypesettingsSettingsCommands extends UnitTestCase
{
    public function testDeleteQuestions_NoThrow()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        
        // setup preconditions
        $settings = array(
        	'fontSize' => 14,
        	'illustrations' => array('one'),
        	'name' => 'my first template',
        );
        
        // method under test
        $templateId = WebtypesettingSettingsCommands::createTemplate($projectId, $settings);
        
        // assertions to make sure things are working
        $templateModel = new SettingsTemplateModel($project, $projectId);
        
        $templateModel->read(
        
        $this->assertEqual($templateModel->fontSize, $settings['fontSize']);
        $this->assertEqual($templateModel->illustrations->getArrayCopy(), $settings['illustrations']);
        $this->assertEqual($templateModel->name, $settings['name']);
    }
}
