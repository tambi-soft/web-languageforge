<?php
require_once dirname(__FILE__) . '/../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';

class AllTypesettingTests extends TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->addFile(TestPath . 'scriptureforge/typesetting/commands/AllTests.php');
        $this->addFile(TestPath . 'scriptureforge/typesetting/models/AllTests.php');
    }

}
