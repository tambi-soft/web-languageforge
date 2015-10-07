<?php
require_once __DIR__ . '/../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';

class AllTypesettingTests extends TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->addFile(TestPath . 'scriptureforge/typesetting/commands/AllTests.php');
        $this->addFile(TestPath . 'scriptureforge/typesetting/dto/AllTests.php');
        $this->addFile(TestPath . 'scriptureforge/typesetting/models/AllTests.php');
    }

}
