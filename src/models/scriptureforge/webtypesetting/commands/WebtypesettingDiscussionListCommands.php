<?php
namespace models\scriptureforge\webtypesetting\commands;

use models\scriptureforge\webtypesetting\WebtypesettingDiscussionThreadModel;

use models\ProjectModel;

class WebtypesettingDiscussionListCommands {
	
	public static function createThread($projectId, $title, $itemId) {
		
		$projectModel = new ProjectModel($projectId);
		
		$threadModel = new WebtypesettingDiscussionThreadModel($projectModel);
		
		$threadModel->title = $title;
		$threadModel->associatedItem = $itemId;
		
		return $threadModel->write();
		
	}
	
}
