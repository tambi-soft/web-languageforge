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
		
		$projectModel = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
		$projectId = $projectModel->id->asString();
		
		// make the assets path if it doesn't exist
		// (I'm not sure why it disappears)
		try {
			mkdir($projectModel->getAssetsFolderPath());
		} catch (Exception $e) { }
		
		// copy the test PDF file to the assets folder
		$testFilepath = dirname(__FILE__) . '/../../../docs/samples';
		$testFilename = 'GospelTestPDF.pdf';
		$targetFile = $projectModel->getAssetsFolderPath() . '/' . $testFilename;
		var_dump($testFilepath . '/' . $testFilename);
		copy($testFilepath . '/' . $testFilename, $targetFile);
	
		// assert that the file was copied successfully
		$this->assertTrue(file_exists($targetFile));
		
		
 		$converter = new WebtypesettingPdfConverter($projectModel, 'GospelTestPDF');
 		$converter->getPng(0);
 		
	}

}
