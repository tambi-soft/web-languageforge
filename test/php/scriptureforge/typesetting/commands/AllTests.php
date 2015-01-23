<?php

require_once dirname(__FILE__) . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';

class AllTypesettingCommandTests extends TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->addFile(TestPath . 'scriptureforge/typesetting/commands/TypesettingCompositionCommands_Test.php');
        $this->addFile(TestPath . 'scriptureforge/typesetting/commands/TypesettingDiscussionListCommands_Test.php');
        $this->addFile(TestPath . 'scriptureforge/typesetting/commands/TypesettingUploadCommands_Test.php');
        $this->addFile(TestPath . 'scriptureforge/typesetting/commands/TypesettingSettingCommands_Test.php');
    }

}
