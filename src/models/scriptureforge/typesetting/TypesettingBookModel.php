<?php

namespace models\scriptureforge\typesetting;

use models\mapper\MapOf;
use models\mapper\ArrayOf;
use models\mapper\Id;
use models\mapper\IdReference;
use models\ProjectModel;

class TypesettingBookModel 
{
 
    /**
     */
    public function __construct()
    {
        $this->paragraphProperties = self::createParagraphProperty();
    }

    public static function create($bookId) {
    	$model = new TypesettingBookModel();
    	$model->bookId = $bookId;
    	return $model;
    }
    
    public static function createParagraphProperty()
    {
    	return new MapOf(function($data) {
			return new ParagraphProperty();
    	});
    }
    
    /**
     * @var Id
     */
    public $bookId;
    
    /**
     * @var string
     */
    public $name;
    
    /**
     * @var MapOf<ParagraphProperty>
     */
    public $paragraphProperties;
    
 }
