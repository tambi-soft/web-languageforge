<?php
namespace models\scriptureforge\typesetting\commands;

use models\scriptureforge\typesetting\TypesettingDiscussionPostModel;
use models\scriptureforge\typesetting\TypesettingDiscussionThreadModel;
use models\languageforge\lexicon\LexCommentReply;
use models\languageforge\lexicon\AuthorInfo;
use models\ProjectModel;

class TypesettingDiscussionListCommands {

	public static function createThread($projectId, $title, $itemId){
		$projectModel = new ProjectModel($projectId);
		$threadModel = new TypesettingDiscussionThreadModel($projectModel);
		$threadModel->title = $title;
		$threadModel->associatedItem = $itemId;
		return $threadModel->write();
	}

	public static function deleteThread($projectId, $threadId){
		$projectModel = new ProjectModel($projectId);
		$threadModel = new TypesettingDiscussionThreadModel($projectModel, $threadId);
		$threadModel->isDeleted = true;
		$threadModel->write();
	}


	public static function updateThread($projectId, $threadId, $title){
		$projectModel = new ProjectModel($projectId);
		$threadModel = new TypesettingDiscussionThreadModel($projectModel, $threadId);
		$threadModel->title = $title;
		$threadModel->write();
	}



	public static function getThread($projectId, $threadId) {
		$projectModel = new ProjectModel($projectId);
		$threadModel = new TypesettingDiscussionThreadModel($projectModel, $threadId);
		return $threadModel;
	}

	public static function createPost($projectId, $threadId, $content){
		$projectModel = new ProjectModel($projectId);
		$threadModel = new TypesettingDiscussionThreadModel($projectModel, $threadId);
		$postModel = new TypesettingDiscussionPostModel($projectModel, $threadId);
		$postModel->threadRef->id = $threadId;
		$postModel->content = $content;
		return $postModel->write();
	}

	public static function deletePost($projectId, $threadId, $postId){
		$projectModel = new ProjectModel($projectId);
		$threadModel = new TypesettingDiscussionThreadModel($projectModel, $threadId);
		$postModel = new TypesettingDiscussionPostModel($projectModel, $threadId, $postId);
		$postModel->isDeleted = true;
		$postModel->write();
	}

	public static function updatePost($projectId, $threadId, $postId, $content){
		$projectModel = new ProjectModel($projectId);
		$threadModel = new TypesettingDiscussionThreadModel($projectModel, $threadId);
		$postModel = new TypesettingDiscussionPostModel($projectModel, $threadId, $postId);
		$postModel->content = $content;
		$postModel->write();
	}

	public static function createReply($projectId, $threadId, $postId, $content){
		$projectModel = new ProjectModel($projectId);
		$threadModel = new TypesettingDiscussionThreadModel($projectModel, $threadId);
		$postModel = new TypesettingDiscussionPostModel($projectModel, $threadId, $postId);
		$replyModel = new LexCommentReply();
		$replyModel->content = $content;
		$postModel->setReply($replyModel->id, $replyModel);
		return $postModel->write();
	}

	public static function deleteReply($projectId, $threadId, $postId, $replyId){
		$projectModel = new ProjectModel($projectId);
		$threadModel = new TypesettingDiscussionThreadModel($projectModel, $threadId);
		$postModel = new TypesettingDiscussionPostModel($projectModel, $threadId, $postId);
		$postModel->deleteReply($replyId);
	}

//	NOTE: Customer said that updating replies is not necessary at the moment of release.
// 	public static function updateReply($projectId, $threadId, $postId, $replyId, $content){
// 		$projectModel = new ProjectModel($projectId);
// 		$threadModel = new TypesettingDiscussionThreadModel($projectModel, $threadId);
// 		$postModel = new TypesettingDiscussionPostModel($projectModel, $threadId, $postId);
// 		$replyModel = new LexCommentReply($replyId);
// 	}

	public static function updateStatus($projectId, $threadId, $status){
		$projectModel = new ProjectModel($projectId);
		$threadModel = new TypesettingDiscussionThreadModel($projectModel, $threadId);
		$threadModel->status = $status;
		$threadModel->write();
	}
}
