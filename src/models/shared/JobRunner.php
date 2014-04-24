<?php
namespace models\shared;

use libraries\shared\Website;

use libraries\shared\palaso\CodeGuard;

class JobRunner {
	
	//protected $_runnerPath;
	
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
	
	public function isRunning() {
		return file_exists($this->_lockFilePath);
	}
	
	public function processQueue() {
		if (!$this->isRunning()) {
			
			$jobsList = $this->listQueuedJobs();
			
			$runningJobId = $jobsList['runningJobId'];
			
			$queue = $this->listQueuedJobs();
			CodeGuard::checkTypeAndThrow($queue, 'array');
			$jobId = $queue[0]['id'];
			
			$job = new RunnableJob($this->_projectModel, $jobId);
			$job->run($this->_lockFilePath);
			$this->_log("Started Job " . $job->id->asString());
			$this->_log("Running Command: " . $job->command);
		}
	}
	
	private function _ProcessFinishedJobsInQueue() {
		
		if (is_dir($this->pr) && ($handle = opendir($dir))) {
			while ($file = readdir($handle)) {
				$filepath = $dir . '/' . $file;
				foreach ($exclude as $ex) {
					if (strpos($filepath, $ex)) {
						continue 2;
					}
				}
				if (is_file($filepath)) {
					if ($ext == 'js') {
						/* For Javascript, check that file is not minified */
						$base = self::basename($file);
						//$isMin = (strpos($base, '-min') !== false) || (strpos($base, '.min') !== false);
						$isMin = FALSE;
						if (!$isMin && self::ext($file) == $ext) {
							$result[] = $filepath;
						}
					} else {
						if (self::ext($file) == $ext) {
							$result[] = $filepath;
						}
					}
				} elseif ($file != '..' && $file != '.') {
					self::addFiles($ext, $filepath, $result, $exclude);
				}
			}
			closedir($handle);
		}
		
			
		
	}
	
	private function _log($message) { }
	
	public function getOutputForJob($jobId) {
		
	}
	
	public function getErrorForJob($jobId) {
		
	}
	
	public function jobHasError($jobId) {
		
	}
	
	public function jobHasOutput($jobId) {
		
	}
	
	public function listAllJobs() {
		// this function will be overridden in the child classes
	}
	
	public function listQueuedJobs() {
		// this function will be overridden in the child classes
	}
	
}