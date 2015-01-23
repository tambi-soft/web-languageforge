<?php

require_once dirname(__FILE__) . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';

class AllTypesettingDtoTests extends TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->addFile(TestPath . 'scriptureforge/typesetting/dto/TypesettingAssetDto_Test.php');
        $this->addFile(TestPath . 'scriptureforge/typesetting/dto/TypesettingDiscussionListDto_Test.php');
        $this->addFile(TestPath . 'scriptureforge/typesetting/dto/TypesettingLayoutPageDto_Test.php');
        $this->addFile(TestPath . 'scriptureforge/typesetting/dto/TypesettingRenderPageDto_Test.php');
    }

}
