<?php

use models\scriptureforge\typesetting\commands\WebtypesettingCompositionCommands;

require_once dirname(__FILE__) . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';

//require_once dirname(__FILE__) . '/../../../../../src/models/scriptureforge/typesetting/commands/WebtypesettingCompositionCommands.php';

class TestWebtypesettingsCompositionCommands extends UnitTestCase
{
    public function testGetBookHTML_NotEmpty()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        
        // setup preconditions
        
        
        // method under test
        $html = WebtypesettingCompositionCommands::getBookHTML(6, 44);
        
        // assertions to make sure things are working
        $this->assertNotEqual($html, '');
    }
}
