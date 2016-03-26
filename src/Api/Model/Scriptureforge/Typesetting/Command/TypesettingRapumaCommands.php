<?php

namespace Api\Model\Scriptureforge\Typesetting\Command;

use Api\Model\Mapper\Id;
use Api\Model\Mapper\JsonDecoder;
use Api\Model\Mapper\JsonEncoder;
use Api\Model\ProjectModel;
use Api\Model\Scriptureforge\Typesetting\SettingModel;
use Api\Model\Scriptureforge\TypesettingProjectModel;
use Palaso\Utilities\FileUtilities;

class TypesettingRapumaCommands
{
    /**
     * @param $projectId
     * @param $userId
     * @return string
     */
    public static function doRender($projectId, $userId)
    {
        $projectModel = new ProjectModel($projectId);

        $currentSettingModel = SettingModel::getCurrent($projectModel);
        
        $currentSettingModel->renderedBy->createdByUserRef->id = $userId;
        $newSettingsModel = new SettingModel($projectModel);
        
        // duplicate current settings
        JsonDecoder::decode($newSettingsModel, JsonEncoder::encode($currentSettingModel));
        $newSettingsModel->id = new Id();
        
        // TODO: kick off render here
        
        return $newSettingsModel->write();
    }

    /**
     * @param $ProjectName
     * @return mixed
     */
    public static function createProject($ProjectName){

        
        //Create project
        $cmd = "rapuma publication " . $ProjectName . " project create";
        $error = shell_exec($cmd);

        //Create group
        $cmd = "rapuma content " . $ProjectName . " group add --group NT --comp_type usfm";
        $error = shell_exec($cmd);

        return $error;
    }

    /**
     * @param $ProjectName
     * @param string $groupName
     * @param string $type
     * @return mixed
     */
    public function createGroup($ProjectName, $groupName = "NT", $type = "usfm"){
        $cmd = "rapuma content " . $ProjectName . " group add --group " . $groupName . " --comp_type " . $type;
        $error = shell_exec($cmd);

        return $error;
    }


    /**
     * @param $projectId
     * @param $ProjectName
     * @param string $type
     * @return mixed
     */
    public static function addFont($projectId, $ProjectName, $type= "usfm"){
        $project = new TypesettingProjectModel($projectId);
        $path = $project->getAssetsFolderPath();

        $cmd = "rapuma asset " . $ProjectName . " font add --component_type " . $type . " --path " . $path;
        $error = shell_exec($cmd);

        return $error;
    }
    public static function removeFont($projectId, $ProjectName, $type= "usfm"){
        $project = new TypesettingProjectModel($projectId);
        $path = $project->getAssetsFolderPath();

        $cmd = "rapuma asset " . $ProjectName . " font update --component_type " . $type . " --path " . $path;
        $error = shell_exec($cmd);

        return $error;
    }

    /**
     * @param $projectId
     * @param $ProjectName
     * @param string $type
     * @return mixed
     */
    public static function addMacro($projectId, $ProjectName, $type= "usfm"){
        $project = new TypesettingProjectModel($projectId);
        $path = $project->getAssetsFolderPath();

        $cmd = "rapuma asset " . $ProjectName . " macro add --component_type " . $type . " --path " . $path;
        $error = shell_exec($cmd);

        return $error;
    }

    /**
     * @param $projectId
     * @param $ProjectName
     * @param string $type
     * @return mixed
     */
    public static function updateMacro($projectId, $ProjectName, $type= "usfm"){
        $project = new TypesettingProjectModel($projectId);
        $path = $project->getAssetsFolderPath();

        $cmd = "rapuma asset " . $ProjectName . " macro update --component_type " . $type . " --path " . $path;
        $error = shell_exec($cmd);

        return $error;
    }

    /**
     * @param $projectId
     * @param $ProjectName
     * @param string $group
     * @param string $cidList
     * @return mixed
     */
    public static function addComponent($projectId, $path ,$group= "NT", $cidList = "mat" ){
        $project = new TypesettingProjectModel($projectId);
        $projectName = $project->projectName;

        $cmd = "rapuma content " . $projectName . " component add --group " . $group . " --cid_list " . $cidList . " --path  "  . $path;
        $error = shell_exec($cmd);

        return $error;
    }

    /**
     * @param $projectId
     * @param $ProjectName
     * @param string $group
     * @param string $cidList
     * @return mixed
     */
    public static function updateComponent($projectId, $group= "NT", $cidList = "mat", $path ){
        $project = new TypesettingProjectModel($projectId);
        $projectName= $project->projectName;

        $cmd = "rapuma content " . $projectName . " component update --group " . $group . " --cid_list " . $cidList . "--path" . $path;
        $error = shell_exec($cmd);

        return $error;
    }

    /**
     * @param $ProjectName
     * @return mixed
     */
    public static function turnOnIllustrations($ProjectName){

        $cmd = "rapuma setting " . $ProjectName . " layout --section DocumentFeatures --key useFigurePlaceHolders --value False";
        $error = shell_exec($cmd);

        return $error;
    }

    public static function addIllustrations($ProjectName,$path){
        $group = 'NT';

        $cmd = "rapuma asset " . $ProjectName . " illustration add --group " . $group . " --path " . $path;
        $error = shell_exec($cmd);

        return $error;
    }




    /**
     * @param $ProjectName
     * @param string $group
     * @return mixed
     */
    public static function renderProject($projectId, $projectName, $group= "NT"){
        $project = new TypesettingProjectModel($projectId);
        $path = $project->getAssetsFolderPath()."/renders";
        $projectName = $project ->projectName;
        FileUtilities::createAllFolders($path);
        $cmd = "rapuma process " . $projectName . " component render --group " . $group . " --cid_list mat --save --background --doc_info --override  ". $path . "/Matthew.pdf "  . "2>&1";
        $command = shell_exec($cmd);
        $path = "../../" . $project->getAssetsRelativePath()."/renders/Matthew.pdf";
        $outputFile = "../../web/viewer.html?file=%2F" . $path;
       // $cmd = "rapuma process " . $ProjectName . " group render --group " . $group;
        //shell_exec($cmd);
        return $outputFile;
    }

    public static function addRapumaTestProject($projectId) {
        $project = new TypesettingProjectModel($projectId);
        $ProjectName  = $project->projectName;
        $group = 'NT';
        $type = 'usfm';

        //Fonts
        $path = '/home/superman/Publishing/my_source/assets/fonts/Padauk_2.701.zip';
        $cmd = "rapuma asset " . $ProjectName . " font add --component_type " . $type . " --path " . $path;
        $error = shell_exec($cmd);

        //Macros
        $path = '/home/superman/Publishing/my_source/KYUM/updates/usfmTex_20150504.zip';
        $cmd = "rapuma asset " . $ProjectName . " macro add --component_type " . $type . " --path " . $path;
        $error = shell_exec($cmd);

        //Components
        $path = '/home/superman/Publishing/my_source/KYUM/PT-source';
        $cmd = "rapuma content " . $ProjectName . " component add --group " . $group . " --cid_list mat --path  "  . $path;
        $error = shell_exec($cmd);

        //Illustrations
        $path = '/home/superman/Publishing/my_source/assets/illustrations';
        $cmd = "rapuma setting " . $ProjectName . " layout --section DocumentFeatures --key useFigurePlaceHolders --value False";
        $error = shell_exec($cmd);
        $cmd = "rapuma asset " . $ProjectName . " illustration add --group " . $group . " --path " . $path;
        $error = shell_exec($cmd);

        return $error;
    }
}
