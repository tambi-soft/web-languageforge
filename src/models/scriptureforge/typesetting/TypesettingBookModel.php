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
        $this->paragraphProperties = new ParagraphPropertiesMapOf();
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
     * @var ParagraphPropertiesMapOf
     */
    public $paragraphProperties;
    
    public static function create($bookId) {
    	$model = new TypesettingBookModel();
    	$model->bookId = $bookId;
    	return $model;
    }
    
 }
