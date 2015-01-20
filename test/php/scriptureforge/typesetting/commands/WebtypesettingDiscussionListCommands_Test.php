<?php

use models\scriptureforge\webtypesetting\commands\WebtypesettingDiscussionListCommands;
use models\scriptureforge\webtypesetting\WebtypesettingDiscussionThreadModel;

require_once dirname(__FILE__) . '/../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';

class TestWebtypesettingDiscussionListCommands extends UnitTestCase
{
    public function testFunctionName_Preconditions_ExpectedResults()
    {
        $this->assertTrue(false, "Tests not written yet.");
    }
}