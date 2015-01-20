<?php

require_once dirname(__FILE__) . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';

class AllTypesettingCommandTests extends TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->addFile(TestPath . 'scriptureforge/typesetting/commands/CompositionCommands_Test.php');
        $this->addFile(TestPath . 'scriptureforge/typesetting/commands/SettingsCommands_Test.php');
    }

}
