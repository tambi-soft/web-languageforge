<?php

namespace Api\Model\Scriptureforge\Typesetting;

use Api\Library\Shared\Palaso\JobRunner;

class RapumaJobRunner extends JobRunner
{
    public function __construct($projectModel)
    {
        $this->_lockFilePath = '/var/typesettingRunnerLockFile';  // not sure where the lock file should actually be
        parent::__construct($projectModel);
    }
}
