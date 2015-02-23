<?php

namespace models\scriptureforge\typesetting;

class TypesettingIllustrationModel {
    
    /**
     */
    public function __construct() {
    }
    
    /**
     *
     * @var string
     */
    public $id;
    
    /**
     *
     * @var string
     */
    public $name;
    
    /**
     *
     * @var string
     */
    public $location;
    
    /**
     *
     * @var float
     */
    public $scale;
    
    /**
     *
     * @var integer
     */
    public $width;
    
    /**
     *
     * @var string
     */
    public $caption;
    
    /**
     *
     * @var bool
     */
    public $useCaption;
    
    /**
     *
     * @var bool
     */
    public $useIllustration;
    
    public static function create($illlustrationId) {
        $model = new TypesettingIllustrationModel ();
        $model->id = $illlustrationId;
        return $model;
    }
}
