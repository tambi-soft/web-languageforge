<?php

use models\scriptureforge\dto\UsfmHelper;

require_once dirname(__FILE__) . '/../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';

class TestUsfmHelper extends UnitTestCase
{
    public function testAsHtml_works()
    {
        $usfm = MongoTestEnvironment::usfmSample();

        $usfmHelper = new usfmHelper($usfm);
        $result = $usfmHelper->toHtml();
        $this->assertPattern('/<sup>4<\\/sup> In him was life; and the life was the light of men\\./', $result);
        $this->assertPattern('/for he knew what was in man\\.<\\/p>(\s+)<div class="chapter-number">Chapter 3<\\/div>(\s+)<p id="c3v1" class="usfm-p"> <sup>1<\\/sup> There was a man/', $result);
    }

    public function testAsHtml_poetryMarkersWork()
    {
        $usfm = MongoTestEnvironment::usfmSampleWithPoetryMarkers();

        $usfmHelper = new usfmHelper($usfm);
        $result = $usfmHelper->toHtml();

        $this->assertPattern('/<sup>1<\\/sup> Blessed <span class="usfm-add">is<\\/span> the man that walketh not (.*)of the scornful.<br \\/>/', $result);
    }
}
