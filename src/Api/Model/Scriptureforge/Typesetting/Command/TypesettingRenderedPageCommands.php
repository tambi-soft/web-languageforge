<?php

namespace Api\Model\Scriptureforge\Typesetting\Command;

use Api\Model\Mapper\JsonDecoder;
use Api\Model\Mapper\JsonEncoder;
use Api\Model\ProjectModel;
use Api\Model\Scriptureforge\Typesetting\Dto\TypesettingRenderPageDto;
use Api\Model\Scriptureforge\Typesetting\RenderedPageCommentModel;
use Api\Model\Scriptureforge\Typesetting\SettingModel;

class TypesettingRenderedPageCommands
{


    public static function getPageStatus()
    {
        return array("green", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red", "red");
    }

    public static function renderBook($projectId, $bookId)
    {

    }
    public static function setRenderedPageComments($projectId, $commentModel)
    {
        $projectModel = new ProjectModel($projectId);
        $RenderedPageCommentModel = RenderedPageCommentModel::createPageComments($projectModel);
        $model = RenderedPageCommentModel::create();
        JsonDecoder::decode($model, $commentModel);
        $RenderedPageCommentModel->pageComments = $model;
        $RenderedPageCommentModel->write();
    }

    public static function getRenderedPageComments($projectId)
    {
        //  $projectModel = new ProjectModel($projectId);
        //  $RenderedPageCommentModel = RenderedPageCommentModel::getCurrent($projectModel);
        //  return JsonEncoder::encode($RenderedPageCommentModel->pageComments);
        return array("5:10 needs more spacing", "8:5 needs less spacing", "23:2 is missing an illustration");
    }

    public static function getRenderedPage($projectId,$projectName)
    {
        return "../../web/viewer.html?file=%2F../../../assets/typesetting/renders/Matthew.pdf";

    }

    public static function getRenderedPageDto($projectId, $projectName)
    {
        $bookID = 'id1';
        return ['bookID' => $bookID,
            'renderedPage' => TypesettingRenderedPageCommands::getRenderedPage($projectId,$projectName),
            'pages' => TypesettingRenderedPageCommands::getPageStatus(),
            'comments' => TypesettingRenderedPageCommands::getRenderedPageComments(($projectId))];
    }
}
