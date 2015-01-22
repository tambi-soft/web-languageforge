<?php
namespace models\scriptureforge\typesetting\commands;

use models\scriptureforge\dto\UsfmHelper;
use models\ProjectModel;
use models\scriptureforge\typesetting\WebtypesettingBookModel;
use models\mapper\JsonEncoder;
use models\mapper\JsonDecoder;
use models\scriptureforge\typesetting\SettingModel;
use models\scriptureforge\typesetting\ParagraphProperty;
use models\scriptureforge\typesetting\TypesettingIllustrationModel;
use models\scriptureforge\typesetting\TypesettingBookModel;
use models\scriptureforge\typesetting\ParagraphPropertiesMapOf;
use models\scriptureforge\typesetting\TypesettingIllustrationMapOf;

class TypesettingCompositionCommands {
	
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
		return array(array('id'=>'id1', 'name'=>'john'),array('id'=>'id2', 'name'=>'mark'));
	}
	
	public static function getParagraphProperties($projectId, $bookId) {
		$projectModel = new ProjectModel($projectId);
		$settingModel = SettingModel::getCurrent($projectModel);
		return JsonEncoder::encode($settingModel->compositionBookAdjustments[$bookId]->paragraphProperties);
	}
	
	public static function setParagraphProperties($projectId, $bookId, $propertiesModel) {
		$projectModel = new ProjectModel($projectId);
		$settingModel = SettingModel::getCurrent($projectModel);
		$a = new ParagraphPropertiesMapOf();
		JsonDecoder::decode($a, $propertiesModel);
		$settingModel->compositionBookAdjustments[$bookId]->paragraphProperties = $a;
		$settingModel->write();
		// TODO What do we return?
	}
	
	public static function getIllustrationProperties($projectId) {
		$projectModel = new ProjectModel($projectId);
		$settingModel = SettingModel::getCurrent($projectModel);
		return JsonEncoder::encode($settingModel->compositionIllustrationAdjustments);
	}
	
	public static function setIllustrationProperties($projectId, $illustrationModel) {
		$projectModel = new ProjectModel($projectId);
		$settingModel = SettingModel::getCurrent($projectModel);
		$a = new TypesettingIllustrationMapOf();
		JsonDecoder::decode($a, $illustrationModel);
		$settingModel->compositionIllustrationAdjustments = $a;
		$settingModel->write();
	}
	
	public static function getPageStatus($projectId, $bookId) {
		// TODO This array can be created at the correct size only after a render (count pngs)
		return array("green", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red" );
	}

	public static function setPageStatus($projectId, $bookId, $pages) {

	}
	
	public static function renderBook($projectId, $bookId) {
		
	}
	

	public static function getRenderedPageForBook($projectId, $bookId, $pageNumber) {
		if($pageNumber%2==0)return "http://upload.wikimedia.org/wikipedia/commons/6/6a/Tricoloring.png";
		else return"http://www.online-image-editor.com//styles/2014/images/example_image.png";
	}
	
	public static function getPageDto($projectId){
		$bookID = 'id1';
		return array('books' => TypesettingCompositionCommands::getListOfBooks($projectId),
					'bookID' => $bookID,
					'bookHTML' => TypesettingCompositionCommands::getBookHTML($projectId, $bookID),
					'paragraphProperties' => TypesettingCompositionCommands::getParagraphProperties($projectId, $bookID),
					'illustrationProperties' => TypesettingCompositionCommands::getIllustrationProperties($projectId),
					'pages' => TypesettingCompositionCommands::getPageStatus($projectId, $bookID));
					
		
	}
	public static function getBookDto($projectId, $bookID){
		return array('bookHTML' => TypesettingCompositionCommands::getBookHTML($projectId, $bookID),
					'paragraphProperties' => TypesettingCompositionCommands::getParagraphProperties($projectId, $bookID),
					'illustrationProperties' => TypesettingCompositionCommands::getIllustrationProperties($projectId),
					'pages' => TypesettingCompositionCommands::getPageStatus($projectId, $bookID));
	}
	
}
