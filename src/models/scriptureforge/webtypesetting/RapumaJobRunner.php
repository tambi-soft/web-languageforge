<?php
namespace models\scriptureforge\webtypesetting;

use libraries\shared\JobRunner;

class RapumaJobRunner extends JobRunner {
	public function __construct($projectModel) {
		$this->_lockFilePath = '/var/webtypesettingRunnerLockFile';  // not sure where the lock file should actually be
		parent::__construct($projectModel);
	}
}