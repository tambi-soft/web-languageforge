<?php
namespace models\shared;


class RunnableJob extends \models\mapper\MapperModel {

	public static function mapper($databaseName) {
		static $instance = null;
		if (null === $instance) {
			$instance = new \models\mapper\MongoMapper($databaseName, 'jobs');
		}
		return $instance;
	}

	/**
	 * 
	 * @param ProjectModel $projectModel
	 * @param string $id
	 */
	public function __construct($projectModel, $id = '') {
		$this->_projectModel = $projectModel;
		$this->endTime = 0;
		$this->startTime = 0;
		parent::__construct(self::mapper($projectModel->databaseName()), $id);
	}
	
	public function run($runnerLockFile) {
		$this->startTime = time();
		$this->write();
		$stdout = $this->_getOutputFilePath();
		$stderr = $this->_getErrorFilePath();
		$cmd = escapeshellcmd($this->command);
		$jobLockFile = $this->_getLockFilePath();
		$endTimeFile = $this->_getEndTimeFilePath();
		$command = "(touch $runnerLockFile $jobLockFile; $cmd > $stdout 2> $stderr; rm $runnerLockFile $jobLockFile; date +%s > $endTimeFile ) &";
		exec($command);
	}
	
	public function getRunTime() {
		if ($this->isFinished()) {
			return $this->endTime - $this->startTime;
		}
	}

	public function isFinished() {
		return (!$this->_isRunning() && $this->startTime != 0 && $this->endTime != 0);
	}

	public function processFinishedJob() {
		if (!$this->_isRunning() && $this->endTime == 0) {
			$this->endTime = (int)file_get_contents($this->_getEndTimeFilePath());
			$this->output = file_get_contents($this->_getOutputFilePath());
			$this->errorOutput = file_get_contents($this->_getErrorFilePath());
			$this->write();
			unlink($this->_getEndTimeFilePath());
		}
	}
	
	
	
	// private methods
	
	
	private function _getFolderPath() {
		if ($this->id->asString() != '') {
			$path = $this->_projectModel->getAssetsFolderPath() . "/" . $this->id->asString();
			if (!file_exists($path)) {
				mkdir($path);
			}
			return $path;
		} else {
			throw new \Exception("should not call getFolderPath before job has an id!");
		}
	}
	
	
	private function _isRunning() {
		return (file_exists($this->_getLockFilePath()));
	}
	
	private function _getLockFilePath() {
		return $this->_getFolderPath() . "/jobIsRunning";
	}
	
	private function _getEndTimeFilePath() {
		return $this->_getFolderPath() . "/endTime";
	}
	
	private function _getOutputFilePath() {
		return $this->_getFolderPath() . "/stdout";
	}
	
	private function _getErrorFilePath() {
		return $this->_getFolderPath() . "/stderr";
		
	}
	
	
	private $_projectModel;

	/**
	 *
	 * @var models\mapper\IdReference
	 */
	public $id;

	/**
	 *
	 * @var string
	 */
	public $command;

	/**
	 *
	 * @var int
	 */
	public $startTime;
	
	/**
	 * 
	 * @var int
	 */
	public $endTime;


	/**
	 *
	 * @var string
	 */
	public $output;

	/**
	 *
	 * @var string
	 */
	public $errorOutput;
	
}