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
		return array();
	}
	
	public static function setParagraphProperties($projectId, $bookId, $propertiesModel) {
		
	}
	
	public static function getIllustrationProperties($projectId, $bookId) {
		return array();
	}
	
	public static function setIllustrationProperties($projectId, $bookId, $illustrationModel) {
		
	}
	
	public static function renderBook($projectId, $bookId) {
		
	}
	
	public static function getRenderedPageForBook($projectId, $bookId, $pageNumber) {
		if($pageNumber%2==0)return "http://upload.wikimedia.org/wikipedia/commons/6/6a/Tricoloring.png";
		else return"http://www.online-image-editor.com//styles/2014/images/example_image.png";
	}
	
}
