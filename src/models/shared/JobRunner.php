<?php
namespace libraries\shared;

use libraries\shared\Website;

use libraries\shared\palaso\CodeGuard;

use models\shared\RunnableJob;

class JobRunner {
	
	protected $_lockFilePath;
	
	private $_projectFolderPath;
	
	private $_projectModel;
	
	/**
	 * 
	 * @param ProjectModel $projectModel
	 */
	public function __construct($projectModel) {
		$this->_projectModel = $projectModel;
		$this->_projectFolderPath = $projectModel->getAssetsFolderPath(); 
	}
	
	public function queueJob($command) {
		// this function will be overridden in the child classes
	}
	
	public function listAllJobs() {
		// this function will be overridden in the child classes
	}
	
	public function listQueuedJobs() {
		// this function will be overridden in the child classes
	}
	
	public function isRunning() {
		return file_exists($this->_lockFilePath);
	}
	
	public function processQueue() {
		if (!$this->isRunning()) {
			
			$jobsList = $this->listQueuedJobs();
			
			if (key_exists('runningJobId', $jobsList)) {
				// finish processing a finished job
				$job = new RunnableJob($this->_projectModel, $jobsList['runningJobId']);
				$job->processFinishedJob();
			}
			
			$jobsList = $this->listQueuedJobs();
			CodeGuard::checkTypeAndThrow($queue, 'array');
			$jobId = $jobsList['queue'][0]['id'];
			
			$job = new RunnableJob($this->_projectModel, $jobId);
			$job->run($this->_lockFilePath);
			$this->_log("Started Job " . $job->id->asString());
			$this->_log("Running Command: " . $job->command);
		}
	}
	
	private function _log($message) { }
	
	// I'm not sure if the following methods are useful or not
	public function getOutputForJob($jobId) { }
	
	public function getErrorForJob($jobId) { }
	
	public function jobHasError($jobId) { }
	
	public function jobHasOutput($jobId) { }
	
}
?>