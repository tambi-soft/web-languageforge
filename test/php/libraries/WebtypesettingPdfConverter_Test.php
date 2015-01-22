<?php

use libraries\scriptureforge\typesetting\WebtypesettingPdfConverter;

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
		
		if(file_exists($testDestName)){
			unlink($testDestName);
		}
		
		$this->assertFalse(file_exists($testDestName));
		
 		WebtypesettingPdfConverter::getPng($testSourceName,$testDestName,3);
 		
 		$this->assertTrue(file_exists($testDestName));
 		
	}

}
