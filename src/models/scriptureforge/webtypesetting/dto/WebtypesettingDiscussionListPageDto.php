<?php

namespace models\scriptureforge\webtypesetting\dto;

use models\scriptureforge\webtypesetting\TypesettingDiscussionPostListModel;

use models\scriptureforge\webtypesetting\TypesettingDiscussionThreadListModel;

use models\ProjectModel;

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
    	}
    	
        return $data;
    }
}
