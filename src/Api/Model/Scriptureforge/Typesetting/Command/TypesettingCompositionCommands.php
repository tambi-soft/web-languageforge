<?php

namespace Api\Model\Scriptureforge\Typesetting\Command;

use Api\Model\Mapper\JsonDecoder;
use Api\Model\Mapper\JsonEncoder;
use Api\Model\ProjectModel;
use Api\Model\Scriptureforge\Dto\UsfmHelper;
use Api\Model\Scriptureforge\Typesetting\SettingModel;
use Api\Model\Scriptureforge\Typesetting\TypesettingBookModel;
use Api\Model\Scriptureforge\TypesettingProjectModel;

class TypesettingCompositionCommands
{
    public static function getBookHTML($projectId, $bookId)
    {
        $project = new TypesettingProjectModel($projectId);
        //$pathToFile = "resources/scriptureforge/typesetting/rapuma_example/my_source/KYUM/PT-source/41MATKYUM.SFM";
          $pathToFile = $project->getAssetsFolderPath() . "/41MATKYUM.SFM";
        if (file_exists($pathToFile)) {
            $workingTextUsfm = file_get_contents($pathToFile);
            $usfmHelper = new UsfmHelper($workingTextUsfm);
            $workingTextHtml = $usfmHelper->toHtml();
            return $workingTextHtml;
        } else {
            return null;
        }
    }

    public static function getListOfBooks($projectId)
    {
        return array(array('id'=>'id1', 'name'=>'john'),array('id'=>'id2', 'name'=>'mark'));
    }

    public static function getParagraphProperties($projectId, $bookId)
    {
        $projectModel = new ProjectModel($projectId);
        $settingModel = SettingModel::getCurrent($projectModel);

        return JsonEncoder::encode($settingModel->compositionBookAdjustments[$bookId]->paragraphProperties);
    }

    public static function setParagraphProperties($projectId, $bookId, $propertiesModel)
    {
        $projectModel = new ProjectModel($projectId);
        $settingModel = SettingModel::getCurrent($projectModel);
        $model = TypesettingBookModel::createParagraphProperty();
        JsonDecoder::decode($model, $propertiesModel);
        $settingModel->compositionBookAdjustments[$bookId]->paragraphProperties = $model;
        $settingModel->write();
        // TODO What do we return?
    }

    public static function setPageComment($projectId, $bookId, $page)
    {
        $projectModel = new ProjectModel($projectId);
        $settingModel = SettingModel::getCurrent($projectModel);
        $settingModel->write();
    }

    public static function getIllustrationProperties($projectId)
    {
        $projectModel = new ProjectModel($projectId);
        $settingModel = SettingModel::getCurrent($projectModel);
        return JsonEncoder::encode($settingModel->compositionIllustrationAdjustments);
    }

    public static function setIllustrationProperties($projectId, $illustrationModel)
    {
        $projectModel = new ProjectModel($projectId);
        $settingModel = SettingModel::getCurrent($projectModel);
        $model = SettingModel::createIllustrationProperty();
        JsonDecoder::decode($model, $illustrationModel);
        $settingModel->compositionIllustrationAdjustments = $model;
        $settingModel->write();
    }

    public static function getPageStatus($projectId, $bookId)
    {
        // TODO This array can be created at the correct size only after a render (count pngs)
        return array("green", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red" );
    }

    public static function setPageStatus($projectId, $bookId, $pages)
    {

    }

    public static function renderBook($projectName)
    {
        $cmd = "rapuma publication" . + $projectName . + "project create" ;
        $error = shell_exec($cmd);
        return $error;

    }
    public static function getComments($projectId, $bookId)
    {
       return array("commentOne", "CommentTwo","blah, blah, blah, blah, blah, blah, blah, blah");
    }
    public static function getRenderedPageForBook($projectId, $bookId, $pageNumber)
    {
        return "/../../../../../../Publishing/KYU-MYMR-KYUMTEST/Deliverable/KYU-MYMR-KYUMTEST_GOSPEL_044-jhn_20160124.pdf";

    }

    /**
     * @param $projectID
     */
    public static function  getProjectName($projectID)
    {
        $projectModel = new ProjectModel($projectID);
        $projectName = $projectModel->projectName;
        return $projectName;
    }

    /**
     * @param $projectId
     * @return string
     */
    public static function getRenderedBook($projectId)
    {
        $project = new TypesettingProjectModel($projectId);
        $pathToFile = "../../" . $project->getAssetsRelativePath()."/renders/Matthew.pdf";

        $path = "../../web/viewer.html?file=%2F" . $pathToFile;
        $pathToFile = $project->getAssetsFolderPath()."/renders/Matthew.pdf";
        $path = file_exists($pathToFile) ? $path: null;
        return $path;
    }

    /**
     * @param $projectId
     * @return array
     */
    public static function getPageDto($projectId)
    {
        $bookID = 'id1';
        return array('books' => self::getListOfBooks($projectId),
                    'bookID' => $bookID,
                    'projectName' => self::getProjectName($projectId),
                    'bookHTML' => self::getBookHTML($projectId, $bookID),
                    'paragraphProperties' => self::getParagraphProperties($projectId, $bookID),
                    'illustrationProperties' => self::getIllustrationProperties($projectId),
                    'renderedBook' => self::getRenderedBook($projectId));

    }

    /**
     * @param $projectId
     * @param $bookID
     * @return array
     */
    public static function getBookDto($projectId, $bookID)
    {
        return array('bookHTML' => self::getBookHTML($projectId, $bookID),
                    'paragraphProperties' => self::getParagraphProperties($projectId, $bookID),
                    'illustrationProperties' => self::getIllustrationProperties($projectId),
                    'pages' => self::getPageStatus($projectId, $bookID));
    }
}
