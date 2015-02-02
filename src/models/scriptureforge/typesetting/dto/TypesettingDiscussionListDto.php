<?php
namespace models\scriptureforge\typesetting\dto;

use models\scriptureforge\typesetting\commands\TypesettingDiscussionListCommands;
use models\scriptureforge\typesetting\TypesettingDiscussionPostListModel;
use models\scriptureforge\typesetting\TypesettingDiscussionThreadListModel;
use models\scriptureforge\typesetting\TypesettingDiscussionThreadModel;
use models\shared\dto\RightsHelper;
use models\ProjectModel;
use models\UserModel;
use models\scriptureforge\typesetting\TypesettingDiscussionPostModel;

class TypesettingDiscussionListDto
{

    /**
     *
     * @param string $projectId
     * @return array - the DTO array
     */
    public static function encode($projectId)
    {
        $data = array();
        $project = new ProjectModel($projectId);

        $threadListModel = new TypesettingDiscussionThreadListModel($project);
        $threadListModel->read();

        $data['threads'] = $threadListModel->entries;

        foreach ($data['threads'] as $threadIndex => $threadList) {
            $threadModel = new TypesettingDiscussionThreadModel($project, $threadList['id']);
            $data['threads'][$threadIndex]['dateCreated'] = $threadModel->dateCreated->format(\DateTime::RFC2822);
            $data['threads'][$threadIndex]['dateModified'] = $threadModel->dateModified->format(\DateTime::RFC2822);
            $createdByUser = new UserModel($threadModel->authorInfo->createdByUserRef->id);
            $data['threads'][$threadIndex]['author'] = array();
            $data['threads'][$threadIndex]['author']['name'] = $createdByUser->name;
            unset($data['threads'][$threadIndex]['authorInfo']);

            $postListModel = new TypesettingDiscussionPostListModel($project, $threadList['id']);
            $postListModel->read();
            $data['threads'][$threadIndex]['posts'] = $postListModel->entries;
            foreach ($data['threads'][$threadIndex]['posts'] as $postIndex => $postList) {
                $postModel = new TypesettingDiscussionPostModel($project, $threadList['id'], $data['threads'][$threadIndex]['posts'][$postIndex]['id']);
                $data['threads'][$threadIndex]['posts'][$postIndex]['dateCreated'] = $postModel->dateCreated->format(\DateTime::RFC2822);
                $data['threads'][$threadIndex]['posts'][$postIndex]['dateModified'] = $postModel->dateModified->format(\DateTime::RFC2822);
                $createdByUser = new UserModel($postModel->authorInfo->createdByUserRef->id);
                $data['threads'][$threadIndex]['posts'][$postIndex]['author'] = array();
                $data['threads'][$threadIndex]['posts'][$postIndex]['author']['name'] = $createdByUser->name;
                $data['threads'][$threadIndex]['posts'][$postIndex]['author']['avatar'] = $createdByUser->avatar_ref;
                unset($data['threads'][$threadIndex]['posts'][$postIndex]['authorInfo']);
                unset($data['threads'][$threadIndex]['posts'][$postIndex]['threadRef']);
            }

        }

        return $data;
    }
}
