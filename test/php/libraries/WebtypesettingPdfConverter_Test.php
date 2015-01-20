<?php

use libraries\scriptureforge\webtypesetting\WebtypesettingPdfConverter;

require_once dirname(__FILE__) . '/../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';

class TestWebtypesettingPdfConverter extends UnitTestCase
{
	
	public function testGetPng_Works()
	{
		$e = new MongoTestEnvironment();
		$e->clean();
		

		

		// copy the test PDF file to the assets folder
		$testFilepath = dirname(__FILE__) . '/../../../docs/samples';
		$testFilename = 'GospelTestPDF';
		
		$testSourceName = $testFilepath . '/' . $testFilename . '.pdf';
		$testDestName = $testFilepath . '/' . $testFilename . '.png';
			
		// assert that the file was copied successfully
		
 		WebtypesettingPdfConverter::getPng($testSourceName,$testDestName,0);
 		
	}

}
