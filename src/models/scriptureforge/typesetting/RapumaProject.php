<?php

namespace models\scriptureforge\typesetting;

use models\shared\RunnableJobArtifact;

use models\shared\RunnableJob;

class RapumaProject {
    
    private $_projectModel;
    
    /**
     * 
     * @param ProjectModel $projectModel
     */
    public function __construct($projectModel) {
        $this->_projectModel = $projectModel;
    }
    
    public function createRapumaProject() {
        if (!$this->webtypesettingProjectExists()) {
            $job = new RapumaJob($this->_projectModel);
            $projectCode = $this->_projectModel->id->asString();
            $cmd = "rapuma project $projectCode project add --media_type book --target_path " . $this->_projectModel->getAssetsFolderPath();
            $job->command = $cmd;
            $job->write();
        } else {
            throw new Exception("Cannot create new webtypesetting project because one already exists with the same name: $projectCode");
        }
    }
    
    public function addComponent($group, $component, $sourceFilePath) {
        if ($this->webtypesettingProjectExists()) {
            $job = new RapumaJob($this->_projectModel);
            $projectCode = $this->_projectModel->id->asString();
            $cmd = "rapuma group $projectCode $group group add --component_type usfm --cid_list $component --source_id $group --source_path $sourceFilePath";
            $job->command = $cmd;
            $job->write();
        } else {
            throw new Exception("Cannot add component '$component' to non-existent project $projectCode");
        }
    }
    
    public function renderGroup($group) {
        if ($this->webtypesettingProjectExists()) {
            if ($this->groupExists($group)) {
                $job = new RapumaJob($this->_projectModel);
                $outputFolderPath = $this->_projectModel->getAssetsFolderPath() . "/Downloads"; 
                if (!file_exists($outputFolderPath)) {
                    mkdir($outputFolderPath);
                }
                $outputFilePath = "$outputFolderPath/" . uniqid() . '.pdf';
                $artifact = new RunnableJobArtifact();
                $artifact->type = RunnableJobArtifact::TYPE_PDF;
                $artifact->displayName = "output.pdf";
                $artifact->filePath = $outputFilePath;
                $job->artifacts[] = $artifact;
                $cmd = "rapuma group $projectCode $group group render --override $outputFilePath";
                $job->command = $cmd;
                $job->write();
            } else {
                throw new Exception("Cannot render group non-existent group '$group' for project $projectCode");
            }
        } else {
            throw new Exception("Cannot render group '$group' for non-existent project $projectCode");
        }
    }
    
    /**
     * @return boolean
     */
    public function webtypesettingProjectExists() {
        $configFile = $this->_projectModel->getAssetsFolderPath() . "/Config/project.json";
        return file_exists($configFile);
    }
    
    /**
     * @param string $component
     * @return boolean
     */
    public function componentExists($component) {
        return false;
    }
    
    /**
     * 
     * @param string $group
     * @return boolean
     */
    public function groupExists($group) {
        return false;
    }
    
    /**
     * @return array
     */
    public function readProjectConfig() {
        $configFile = $this->_projectModel->getAssetsFolderPath() . "/Config/project.json";
        return json_decode(file_get_contents($configFile), true);
    }
    
    /**
     * 
     * @param array $config
     */
    public function updateProjectConfig($config) {
        $configFile = $this->_projectModel->getAssetsFolderPath() . "/Config/project.json";
        return file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
    }
    
}

?>