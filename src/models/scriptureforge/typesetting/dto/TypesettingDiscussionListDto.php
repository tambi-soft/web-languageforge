<?php
namespace models\scriptureforge\typesetting\dto;

use models\scriptureforge\typesetting\commands\TypesettingDiscussionListCommands;
use models\scriptureforge\typesetting\TypesettingDiscussionPostListModel;
use models\scriptureforge\typesetting\TypesettingDiscussionThreadListModel;
use models\scriptureforge\typesetting\TypesettingDiscussionThreadModel;
use models\shared\dto\RightsHelper;
use models\ProjectModel;
use models\UserModel;

class TypesettingDiscussionListDto
{

    /**
     *
     * @param string $projectId
     * @return s array - the DTO array
     */
    public static function encode($projectId)
    {
        $data = array();
        $projectModel = new ProjectModel($projectId);

        $threadListModel = new TypesettingDiscussionThreadListModel($projectModel);
        $threadListModel->read();

        $data['threads'] = $threadListModel->entries;

        foreach ($data['threads'] as $index => $threadList) {
            $postListModel = new TypesettingDiscussionPostListModel($projectModel, $threadList['id']);
            $postListModel->read();
            $data['threads'][$index]['posts'] = $postListModel->entries;
            $threadModel = new TypesettingDiscussionThreadModel($projectModel, $threadList['id']);
            $data['threads'][$index]['dateModified'] = $threadModel->dateModified->format(\DateTime::RFC2822);
            $createdByUser = new UserModel($threadModel->authorInfo->createdByUserRef->id);
            $data['threads'][$index]['author'] = array();
            $data['threads'][$index]['author']['name'] = $createdByUser->name;
            unset($data['threads'][$index]['authorInfo']);

        }

        return $data;
    }
}
