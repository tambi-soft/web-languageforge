<?php
namespace models\scriptureforge\typesetting\commands;

use models\mapper\ArrayOf;

class TypesettingImportResult extends TypesettingMediaResult
{

    public function __construct() {
        $this->extractedAssetIds = new ArrayOf();
    }

    /**
     *
     * @var ArrayOf <string>
     */
    public $extractedAssetIds;

}

?>
