<?php

use Api\Library\Scriptureforge\Typesetting\TypesettingPdfConverter;

require_once __DIR__ . '/../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';

class TestTypesettingPdfConverter extends UnitTestCase
{
    public function testGetPng_Works()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        // copy the test PDF file to the assets folder
        $testFilepath = __DIR__ . '/../../../docs/samples';
        $testFilename = 'GospelTestPDF';
        
        $testSourceName = $testFilepath . '/' . $testFilename . '.pdf';
        $testDestName = $testFilepath . '/' . $testFilename . '.png';
            
        // assert that the file was copied successfully
        
        if (file_exists($testDestName)){
            unlink($testDestName);
        }
        
        $this->assertFalse(file_exists($testDestName));
        
        TypesettingPdfConverter::getPng($testSourceName,$testDestName,3);
         
        $this->assertTrue(file_exists($testDestName));
    }
}
