<?php
namespace models\scriptureforge\webtypesetting\commands;

class WebtypesettingCompositionCommands {
	
	public static function getBookHTML($projectId, $bookId) {
		// For now, return the sample HTML of the book of John.
		return file_get_contents(dirname(__FILE__) . '/../../../../../docs/JohnHTMLSample.html');
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
