<?php
namespace models\scriptureforge\typesetting\dto;

use models\scriptureforge\typesetting\commands\TypesettingDiscussionListCommands;
use models\scriptureforge\typesetting\TypesettingDiscussionPostListModel;
use models\scriptureforge\typesetting\TypesettingDiscussionThreadListModel;
use models\scriptureforge\typesetting\TypesettingDiscussionThreadModel;
use models\shared\dto\RightsHelper;
use models\ProjectModel;

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

        foreach ($data['threads'] as $key => $thread) {
            $postListModel = new TypesettingDiscussionPostListModel($projectModel, $thread['id']);
            $postListModel->read();
            $data['threads'][$key]['posts'] = $postListModel->entries;
            $threadModel = new TypesettingDiscussionThreadModel($projectModel, $thread['id']);
            $data['threads'][$key]['dateModified'] = $threadModel->dateModified->format(\DateTime::RFC2822);
        }

        return $data;
    }
}
