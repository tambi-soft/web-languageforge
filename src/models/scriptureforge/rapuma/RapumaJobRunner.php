<?php
namespace models\scriptureforge\rapuma;

use libraries\shared\JobRunner;

class RapumaJobRunner extends JobRunner {
	public function __construct($projectModel) {
		$this->_lockFilePath = '/var/rapumaRunnerLockFile';  // not sure where the lock file should actually be
		parent::__construct($projectModel);
	}
}