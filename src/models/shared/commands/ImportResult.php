<?php
namespace models\shared\commands;

class ImportResult extends MediaResult
{

    /**
     *
     * @var LiftImportStats
     */
    public $stats;

    /**
     *
     * @var string
     */
    public $importErrors;

}

?>
