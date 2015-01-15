<?php

namespace libraries\scriptureforge\webtypesetting;

use models\ProjectModel;
use Imagick;

class WebtypesettingPdfConverter {
	
	private $_path;
	private $_pdfName;
	private $_fullPathName;
	
	
	/**
	 * 
	 * @param ProjectModel $projectModel
	 * @param string $pdfId
	 */
	public function __construct($projectModel, $pdfId) {
		$_path = $projectModel->getAssetsFolderPath();
		$_pdfName = $pdfId;
		
		//combines the assets folder path name and the pdf name to build the name to access the pdf.
		$_fullPathName = $_path . '/' . $_pdfName . ".pdf";
	}
	
	/**
	 * getPng takes an integer page number and creates a png object of that page.
	 * 
	 * 
	 */
	public function getPng($pages = 0) {
		
		
		//open a file location, read write access
		$file = fopen($_fullPathName ,"a+");
		
		
		//declare a new imagick container to stick our image in and modify.
		$im = new imagick();
		//set the resolution, if we want to conserve space/time.
			//$im->setResolution(300,300);
			
		
		//read the pdf page, 0 indexed.
		$im->readimagefile($file);
		
		//flattenImages can be used if transparancy layer is showing up as black.
		//$imagick = $imagick->flattenImages();
		
		//setImageFormat changes the local im model format to png.
		$im->setImageFormat('png');
		//writeImage then takes the local png stored in im and writes it out to file, ready to be sent on 
		$im->writeImage($_pdfName . '.png');
		
		//clean up after ourselves.
		$im->clear(); 
		$im->destroy();
		
	}
}
?>