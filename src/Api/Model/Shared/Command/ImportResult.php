<?php

namespace Api\Model\Shared\Command;

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
