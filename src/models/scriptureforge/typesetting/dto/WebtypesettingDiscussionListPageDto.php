<?php

namespace models\scriptureforge\typesetting\dto;

use models\scriptureforge\typesetting\TypesettingDiscussionPostListModel;
use models\scriptureforge\typesetting\TypesettingDiscussionThreadListModel;
use models\shared\dto\RightsHelper;
use models\ProjectModel;
use models\scriptureforge\webtypesetting\commands\WebtypesettingDiscussionListCommands;
use models\scriptureforge\webtypesetting\WebtypesettingDiscussionThreadModel;

class WebtypesettingDiscussionListPageDto
{
    /**
     *
     * @param string $projectId
     * @returns array - the DTO array
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
    		$threadModel = new WebtypesettingDiscussionThreadModel($projectModel, $thread['id']);
    		$data['threads'][$key]['dateModified'] = $threadModel->dateModified->format(\DateTime::RFC2822);
    	}

        return $data;
    }
}
