<?php

namespace Api\Library\Shared\Palaso;

use Api\Model\ProjectModel;
use Palaso\Utilities\CodeGuard;

class JobRunner
{
    protected $_lockFilePath;
    
    private $_projectFolderPath;
    
    protected  $_projectModel;
    
    /**
     * 
     * @param ProjectModel $projectModel
     */
    public function __construct($projectModel)
    {
        $this->_projectModel = $projectModel;
        $this->_projectFolderPath = $projectModel->getAssetsFolderPath();
    }
    
    /*
    public function listAllJobs() {
    }
    */
    
    public function listQueuedJobs()
    {
        $list = new RunnableJobListModel_Queue($this->_projectModel);
        $list->read();
        $queue = array();
        $queue['queue'] = $list->entries;
        $runningJobId = $this->_getRunningJobIdInList($list->entries);
        if ($runningJobId) {
            $queue['runningJobId'] = $runningJobId;
        }
        return $queue;
    }
    
    private function _getRunningJobIdInList($jobList)
    {
        foreach ($jobList as $job) {
            if ($job['startTime'] != 0) {
                return $job['id'];
            }
        }
        return false;
    }
    
    public function isRunning()
    {
        return file_exists($this->_lockFilePath);
    }
    
    public function processQueue()
    {
        if (!$this->isRunning()) {
            
            $jobsList = $this->listQueuedJobs();
            
            if (array_key_exists('runningJobId', $jobsList)) {
                // finish processing a finished job
                $job = new RunnableJob($this->_projectModel, $jobsList['runningJobId']);
                $job->processFinishedJob();
            }
            
            $jobsList = $this->listQueuedJobs();
            CodeGuard::checkTypeAndThrow($jobsList, 'array');
            $jobId = $jobsList['queue'][0]['id'];
            
            $job = new RunnableJob($this->_projectModel, $jobId);
            $job->run($this->_lockFilePath);
            $this->_log("Running Command: " . $job->command);
        }
    }
    
    private function _log($message)
    {
        $logfile = $this->_projectFolderPath . "/jobRunner.log";
        $message = date(\DateTime::W3C) . "\t$message\n";
        file_put_contents($logfile, $message, FILE_APPEND);
    }
}
