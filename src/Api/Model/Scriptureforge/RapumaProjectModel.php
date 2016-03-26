<?php

namespace Api\Model\Scriptureforge;

class RapumaProjectModel extends SfProjectModel
{
    public function __construct($id = '')
    {
        $this->rolesClass = 'Api\Model\Scriptureforge\Rapuma\RapumaRoles';
        $this->appName = SfProjectModel::RAPUMA_APP;

        // This must be last, the constructor reads data in from the database which must overwrite the defaults above.
        parent::__construct($id);
    }

  

    /**
     * @param mixed $macroFile
     * @return RapumaProjectModel
     */
    public function setMacroFile($macroFile)
    {
        $this->macroFile = $macroFile;
        return $this;
    }
    /**
     * @param mixed $componentFile
     * @return RapumaProjectModel
     */
    public function setComponentFile($componentFile)
    {
        $this->componentFile = $componentFile;
        return $this;
    }
    /**
     * @param mixed $fontFile
     * @return RapumaProjectModel
     */
    public function setFontFile($fontFile)
    {
        $this->fontFile = $fontFile;
        return $this;
    }
    
    /**
     * @param mixed $illustrationsFile
     * @return RapumaProjectModel
     */
    public function setIllustrationsFile($illustrationsFile)
    {
        $this->illustrationsFile = $illustrationsFile;
        return $this;
    }

    /**
     * Specifies which macro file to use
     * @var string
     */
    public $macroFile;

    /**
     * Specifies which component file to use
     * @var string
     */
    public $componentFile;

    /**
     * Specifies which font file to use
     * @var string
     */
    public $fontFile;

    /**
     * Specifies which illustration file to use
     * @var string
     */
    public $illustrationsFile;




}
