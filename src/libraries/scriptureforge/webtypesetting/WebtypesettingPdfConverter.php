<?php

namespace libraries\scriptureforge\typesetting;

use models\ProjectModel;
use Imagick;

class WebtypesettingPdfConverter {
	
	
	/**
	 * getPng takes an integer page number and creates a png object of that page.
	 * 
	 * 
	 */
	static public function getPng($sourceName, $destName, $page=0) {
		
		
		//open a file location, read write access
// 		$file = fopen($this->_fullPathName ,"w+");
		
		
		//declare a new imagick container to stick our image in and modify.
		$im = new imagick();
		//set the resolution, if we want to conserve space/time.
			//$im->setResolution(300,300);
			
		
		$im->setresolution(150, 150);
		
		//read the pdf page, 0 indexed.
		$im->readimage("{$sourceName}[{$page}]");
		
		//flattenImages can be used if transparancy layer is showing up as black.
		//$imagick = $imagick->flattenImages();
		
		//setImageFormat changes the local im model format to png.
		$im->setImageFormat('png');
		//writeImage then takes the local png stored in im and writes it out to file, ready to be sent on 
		$im->writeImage($destName);
		
		//clean up after ourselves.
		$im->clear(); 
		$im->destroy();
		
	}
}
?>