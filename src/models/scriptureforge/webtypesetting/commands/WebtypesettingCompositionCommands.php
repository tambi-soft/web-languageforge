<?php
namespace models\scriptureforge\webtypesetting\commands;

use models\scriptureforge\dto\UsfmHelper;
class WebtypesettingCompositionCommands {
	
	public static function getBookHTML($projectId, $bookId) {
		// Return a test HTML file
		//return file_get_contents(dirname(__FILE__) . '/../../../../../docs/samples/JohnHTMLSample2.html');
		
		// Convert the entire book of John from USFM to HTML and return it
		$workingTextUsfm = file_get_contents(dirname(__FILE__) . '/../../../../../docs/usfm/KJV/44JHNKJVT.SFM');
		
		$usfmHelper = new UsfmHelper($workingTextUsfm);
		$workingTextHtml = $usfmHelper->toHtml();
		
		return $workingTextHtml;
	}
	
	public static function getListOfBooks($projectId) {
		
	}
	
	public static function getParagraphProperties($projectId, $bookId) {
		
	}
	
	public static function setParagraphProperties($projectId, $bookId, $propertiesModel) {
		
	}
	
	public static function renderBook($projectId, $bookId) {
		
	}
	
	public static function getRenderedPageForBook($projectId, $bookId, $pageNumber) {
		
	}
	
}
