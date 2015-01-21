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
	
	public static function deleteThread($threadId){
		$projectModel = new ProjectModel($projectId);
		
		$threadModel = new WebtypesettingDiscussionThreadModel($projectModel);
		
		$threadModel->threadId = $threadId;
		
		return $threadModel->write();
	}
	
	public static function updateThread($threadId, $title){
		$projectModel = new ProjectModel($projectId);
		
		$threadModel = new WebtypesettingDiscussionThreadModel($projectModel);
		
		$threadModel->threadId = $threadId;
		$threadModel->title = $title;
		
		return $threadModel->write();
	}
	
	public static function createPost($threadId, $post){
		$projectModel = new ProjectModel($projectId);
		
		$threadModel = new WebtypesettingDiscussionThreadModel($projectModel);
		
		$threadModel->threadId = $threadId;
		$threadModel->post = $post;
		
		return $threadModel->write();
	}
	
	public static function deletePost($threadId, $postId){
		$projectModel = new ProjectModel($projectId);
		
		$threadModel = new WebtypesettingDiscussionThreadModel($projectModel);
		
		$threadModel->threadId = $threadId;
		$threadModel->postId = $postId;
		
		return $threadModel->write();
	}
	
	public static function updatePost($threadId, $postId, $content){
		$projectModel = new ProjectModel($projectId);
		
		$threadModel = new WebtypesettingDiscussionThreadModel($projectModel);
		
		$threadModel->threadId = $threadId;
		$threadModel->postId = $postId;
		$threadModel->content = $content;
		
		return $threadModel->write();
	}
	
	// We were instructed to write these functions, but considering how replies are handled
	// in the database, it seems like they are unecessary. They are commented out for possible
	// future use. - Calvin B
	/*
	public static function createReply($threadId, $postId, $reply){
		$projectModel = new ProjectModel($projectId);
		
		$threadModel = new WebtypesettingDiscussionThreadModel($projectModel);
		
		$threadModel->threadId = $threadId;
		$threadModel->postId = $postId;
		$threadModel->reply = $reply;
		
		return $threadModel->write();
	}
	
	public static function deleteReply($threadId, $postId, $replyId){
		$projectModel = new ProjectModel($projectId);
		
		$threadModel = new WebtypesettingDiscussionThreadModel($projectModel);
		
		$threadModel->threadId = $threadId;
		$threadModel->postId = $postId;
		$threadModel->replyId = $replyId;
		
		return $threadModel->write();
	}
	
	public static function updateReply($threadId, $postId, $replyId, $content){
		$projectModel = new ProjectModel($projectId);
		
		$threadModel = new WebtypesettingDiscussionThreadModel($projectModel);
		
		$threadModel->threadId = $threadId;
		$threadModel->postId = $postId;
		$threadModel->replyId = $replyId;
		$threadModel->content = $content;
		
		return $threadModel->write();
	}
	*/
	
	public static function updateStatus($threadId, $status){
		$projectModel = new ProjectModel($projectId);
		
		$threadModel = new WebtypesettingDiscussionThreadModel($projectModel);
		
		$threadModel->threadId = $threadId;
		$threadModel->status = $status;
		
		return $threadModel->write();
	}
}
