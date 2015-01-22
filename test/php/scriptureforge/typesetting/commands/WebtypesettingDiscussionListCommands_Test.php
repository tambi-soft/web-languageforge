<?php

use models\scriptureforge\typesetting\commands\WebtypesettingDiscussionListCommands;
use models\scriptureforge\typesetting\WebtypesettingDiscussionThreadModel;
use models\scriptureforge\typesetting\TypesettingAssetModel;
use models\scriptureforge\typesetting\TypesettingDiscussionThreadListModel;
use models\scriptureforge\typesetting\TypesettingDiscussionPostListModel;
use models\languageforge\lexicon\LexCommentReply;
use models\languageforge\lexicon\AuthorInfo;


require_once dirname(__FILE__) . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';

class TestWebtypesettingDiscussionListCommands extends UnitTestCase
{
	public function testCreateThread_NoExistingThreads_OneThreadExists() {
		$e = new MongoTestEnvironment();
		$e->clean();
		
		$project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
		$projectId = $project->id->asString();
		
		$asset = new TypesettingAssetModel($project);
		$assetId = $asset->write();
		
		$threadListModel = new TypesettingDiscussionThreadListModel($project);
		$threadListModel->read();
		$this->assertEqual($threadListModel->count, 0);
		
		WebtypesettingDiscussionListCommands::createThread($projectId, 'my thread', $assetId);
		$threadListModel->read();
		$this->assertEqual($threadListModel->count, 1);
		$this->assertEqual($threadListModel->entries[0]['title'], 'my thread');
	}
	
	public function testUpdateThread_OneThread_OneThreadUpdated(){
		$e = new MongoTestEnvironment();
		$e->clean();
		
		$project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
		$projectId = $project->id->asString();
		
		$asset = new TypesettingAssetModel($project);
		$assetId = $asset->write();
		
		$threadListModel = new TypesettingDiscussionThreadListModel($project);
		$threadListModel->read();
		$this->assertEqual($threadListModel->count, 0);
		
		WebtypesettingDiscussionListCommands::createThread($projectId, 'my thread', $assetId);
		$threadListModel->read();
		WebtypesettingDiscussionListCommands::updateThread($projectId, $threadListModel->entries[0]['id'], 'my updated thread');
		$threadListModel->read();
		$this->assertEqual($threadListModel->entries[0]['title'], 'my updated thread');
	}
	
	public function testDeleteThread_TwoThreads_OneDeletedThread(){
		$e = new MongoTestEnvironment();
		$e->clean();
		
		$project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
		$projectId = $project->id->asString();
		
		$asset = new TypesettingAssetModel($project);
		$assetId = $asset->write();
		
		$threadListModel = new TypesettingDiscussionThreadListModel($project);
		$threadListModel->read();
		$this->assertEqual($threadListModel->count, 0);
		
		WebtypesettingDiscussionListCommands::createThread($projectId, 'my first thread', $assetId);
		$threadListModel->read();
		WebtypesettingDiscussionListCommands::createThread($projectId, 'my second thread', $assetId);
		$threadListModel->read();
		$thread2Id = $threadListModel->entries[0]['id'];
		
		WebtypesettingDiscussionListCommands::deleteThread($projectId, $thread2Id);
		$threadListModel->read();
		$this->assertEqual($threadListModel->count, 1);
		$this->assertEqual($threadListModel->entries[0]['title'], 'my first thread');		
	}
	
	public function testGetThread_OneThreadExists_OneThreadReturned(){
		$e = new MongoTestEnvironment();
		$e->clean();
		
		$project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
		$projectId = $project->id->asString();
		
		$asset = new TypesettingAssetModel($project);
		$assetId = $asset->write();
		
		$threadListModel = new TypesettingDiscussionThreadListModel($project);
		$threadListModel->read();
		
		$threadId1 = WebtypesettingDiscussionListCommands::createThread($projectId, 'thread 1', $assetId);
		$threadModel1 = new WebtypesettingDiscussionThreadModel($project, $threadId1);
		$threadModel2 = WebtypesettingDiscussionListCommands::getThread($projectId, $threadId1);
		
		$this->assertIdentical($threadModel1, $threadModel2);
	}

	public function testCreatePost_NoPostExists_OnePostExists(){
		$e = new MongoTestEnvironment();
		$e->clean();
		
		$project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
		$projectId = $project->id->asString();
		
		$asset = new TypesettingAssetModel($project);
		$assetId = $asset->write();
		
		$threadListModel = new TypesettingDiscussionThreadListModel($project);
		$threadListModel->read();
		$this->assertEqual($threadListModel->count, 0);
		
		WebtypesettingDiscussionListCommands::createThread($projectId, 'my thread', $assetId);
		$threadListModel->read();
		$threadId = $threadListModel->entries[0]['id'];
		
		$postListModel = new TypesettingDiscussionPostListModel($project, $threadId);
		$postListModel->read();
		
		WebtypesettingDiscussionListCommands::createPost($projectId, $threadId, 'my post');
		$postListModel->read();
		$this->assertEqual($postListModel->count, 1);
		$this->assertEqual($postListModel->entries[0]['content'], 'my post');
	}
	
	public function testUpdatePost_OnePost_OneUpdatedPost(){
		$e = new MongoTestEnvironment();
		$e->clean();
		
		$project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
		$projectId = $project->id->asString();
		
		$asset = new TypesettingAssetModel($project);
		$assetId = $asset->write();
		
		$threadListModel = new TypesettingDiscussionThreadListModel($project);
		$threadListModel->read();
		$this->assertEqual($threadListModel->count, 0);
		
		WebtypesettingDiscussionListCommands::createThread($projectId, 'my thread', $assetId);
		$threadListModel->read();
		$threadId = $threadListModel->entries[0]['id'];
		
		$postListModel = new TypesettingDiscussionPostListModel($project, $threadId);
		$postListModel->read();
		
		WebtypesettingDiscussionListCommands::createPost($projectId, $threadId, 'my post');
		$postListModel->read();
		$postId = $postListModel->entries[0]['id'];
		$this->assertEqual($postListModel->count, 1);
		$this->assertEqual($postListModel->entries[0]['content'], 'my post');
		
		WebtypesettingDiscussionListCommands::updatePost($projectId, $threadId, $postId, 'my updated post');
		$postListModel->read();
		$this->assertEqual($postListModel->count, 1);
		$this->assertEqual($postListModel->entries[0]['content'], 'my updated post');
	}
	
	public function testDeletePost_TwoPosts_OneDeletedPost(){
		$e = new MongoTestEnvironment();
		$e->clean();
		
		$project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
		$projectId = $project->id->asString();
		
		$asset = new TypesettingAssetModel($project);
		$assetId = $asset->write();
		
		$threadListModel = new TypesettingDiscussionThreadListModel($project);
		$threadListModel->read();
		$this->assertEqual($threadListModel->count, 0);
		
		WebtypesettingDiscussionListCommands::createThread($projectId, 'my thread', $assetId);
		$threadListModel->read();
		$threadId = $threadListModel->entries[0]['id'];
		
		$postListModel = new TypesettingDiscussionPostListModel($project, $threadId);
		$postListModel->read();
		
		WebtypesettingDiscussionListCommands::createPost($projectId, $threadId, 'my first post');
		$postListModel->read();
	    WebtypesettingDiscussionListCommands::createPost($projectId, $threadId, 'my second post');
		$postListModel->read();
		$post2Id = $postListModel->entries[1]['id'];
		
		WebtypesettingDiscussionListCommands::deletePost($projectId, $threadId, $post2Id);
		$postListModel->read();
		$this->assertEqual($postListModel->count, 1);
		$this->assertEqual($postListModel->entries[0]['content'], 'my first post');
	
	}
	
	public function testCreateReply_NoReplyExists_OneReplyExists(){
		$e = new MongoTestEnvironment();
		$e->clean();
		
		$project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
		$projectId = $project->id->asString();
		
		$asset = new TypesettingAssetModel($project);
		$assetId = $asset->write();
		
		$threadListModel = new TypesettingDiscussionThreadListModel($project);
		$threadListModel->read();
		$this->assertEqual($threadListModel->count, 0);
		
		WebtypesettingDiscussionListCommands::createThread($projectId, 'my thread', $assetId);
		$threadListModel->read();
		$threadId = $threadListModel->entries[0]['id'];
		
		$postListModel = new TypesettingDiscussionPostListModel($project, $threadId);
		$postListModel->read();
		
		WebtypesettingDiscussionListCommands::createPost($projectId, $threadId, 'my post');
		$postListModel->read();
		$postId = $postListModel->entries[0]['id'];
		
		WebtypesettingDiscussionListCommands::createReply($projectId, $threadId, $postId, "my reply");
		$postListModel->read();
		
		$this->assertEqual($postListModel->entries[0]['replies'][0]['content'], "my reply");
	}
	
	/* updating replies is a feature that is not supported in the first release
	public function testUpdateReply_OneReply_OneUpdatedReply(){
		$e = new MongoTestEnvironment();
		$e->clean();
		
		$project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
		$projectId = $project->id->asString();
		
		$asset = new TypesettingAssetModel($project);
		$assetId = $asset->write();
		
		$threadListModel = new TypesettingDiscussionThreadListModel($project);
		$threadListModel->read();
		$this->assertEqual($threadListModel->count, 0);
		
		WebtypesettingDiscussionListCommands::createThread($projectId, 'my thread', $assetId);
		$threadListModel->read();
		$threadId = $threadListModel->entries[0]['id'];
		
		$postListModel = new TypesettingDiscussionPostListModel($project, $threadId);
		$postListModel->read();
		
		WebtypesettingDiscussionListCommands::createPost($projectId, $threadId, 'my post');
		$postListModel->read();
		$postId = $postListModel->entries[0]['id'];
		
		WebtypesettingDiscussionListCommands::createReply($projectId, $threadId, $postId, "my reply");
		$postListModel->read();

		$replyId = $postListModel->entries[0]['replies'][0]['id'];
		
		WebtypesettingDiscussionListCommands::updateReply($projectId, $threadId, $postId, $replyId, "my updated reply");
		$postListModel->read();
		$this->assertEqual($postListModel->entries[0]['replies'][0]['content'], 'my updated reply');
		
	}
	*/
	
	public function testDeleteReply_TwoReplies_OneDeletedReply(){
		$e = new MongoTestEnvironment();
		$e->clean();
		
		$project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
		$projectId = $project->id->asString();
		
		$asset = new TypesettingAssetModel($project);
		$assetId = $asset->write();
		
		$threadListModel = new TypesettingDiscussionThreadListModel($project);
		$threadListModel->read();
		$this->assertEqual($threadListModel->count, 0);
		
		WebtypesettingDiscussionListCommands::createThread($projectId, 'my thread', $assetId);
		$threadListModel->read();
		$threadId = $threadListModel->entries[0]['id'];
		
		$postListModel = new TypesettingDiscussionPostListModel($project, $threadId);
		$postListModel->read();
		
		WebtypesettingDiscussionListCommands::createPost($projectId, $threadId, 'my post');
		$postListModel->read();
		$postId = $postListModel->entries[0]['id'];
		
		


		WebtypesettingDiscussionListCommands::createReply($projectId, $threadId, $postId, "my first reply");
		WebtypesettingDiscussionListCommands::createReply($projectId, $threadId, $postId, "my second reply");
		$postListModel->read();
		$replyId = $postListModel->entries[0]['replies'][0]['id'];
		
		WebtypesettingDiscussionListCommands::deleteReply($projectId, $threadId, $postId, $replyId);
		$postListModel->read();
		
		// we expect the only reply remaining after the delete to be "my first reply" because 
		// reply[0] represents the newest reply
		$this->assertEqual($postListModel->entries[0]['replies'][0]['content'], 'my first reply');
	}
	
	public function testUpdateStatus_OldStatus_NewStatus(){
		$e = new MongoTestEnvironment();
		$e->clean();
		
		$project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
		$projectId = $project->id->asString();
		
		$asset = new TypesettingAssetModel($project);
		$assetId = $asset->write();
		
		$threadListModel = new TypesettingDiscussionThreadListModel($project);
		$threadListModel->read();
		$this->assertEqual($threadListModel->count, 0);
		
		WebtypesettingDiscussionListCommands::createThread($projectId, 'my thread', $assetId);
		$threadListModel->read();
		$threadId = $threadListModel->entries[0]['id'];
		
		WebtypesettingDiscussionListCommands::updateStatus($projectId, $threadId, "Closed");
		$threadListModel->read();
		$this->assertEqual($threadListModel->entries[0]['status'], "Closed");
	}
}