<?php
use models\scriptureforge\typesetting\commands\TypesettingDiscussionListCommands;
use models\scriptureforge\typesetting\TypesettingAssetModel;
use models\scriptureforge\typesetting\TypesettingDiscussionPostListModel;
use models\scriptureforge\typesetting\TypesettingDiscussionThreadListModel;
use models\scriptureforge\typesetting\TypesettingDiscussionThreadModel;
use models\languageforge\lexicon\AuthorInfo;
use models\languageforge\lexicon\LexCommentReply;

require_once dirname(__FILE__) . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';

class TestTypesettingDiscussionListCommands extends UnitTestCase
{

    public function testCreateThread_NoExistingThreads_OneThreadExists()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $userId = $e->createUser('joe', 'joe', 'joe');

        $asset = new TypesettingAssetModel($project);
        $assetId = $asset->write();

        $threadList = new TypesettingDiscussionThreadListModel($project);
        $threadList->read();
        $this->assertEqual($threadList->count, 0);

        TypesettingDiscussionListCommands::createThread($projectId, $userId, 'my thread', $assetId);

        $threadList->read();
        $thread = new TypesettingDiscussionThreadModel($project, $threadList->entries[0]['id']);
        $this->assertEqual($threadList->count, 1);
        $this->assertEqual($threadList->entries[0]['title'], 'my thread');
        $this->assertEqual($userId, $thread->authorInfo->createdByUserRef->asString());
    }

    public function testUpdateThread_OneThread_OneThreadUpdated()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $createUserId = $e->createUser('joe', 'joe', 'joe');
        $modifyUserId = $e->createUser('bob', 'bob', 'bob');

        $asset = new TypesettingAssetModel($project);
        $assetId = $asset->write();

        $threadList = new TypesettingDiscussionThreadListModel($project);
        $threadList->read();
        $this->assertEqual($threadList->count, 0);

        TypesettingDiscussionListCommands::createThread($projectId, $createUserId, 'my thread', $assetId);

        $threadList->read();
        $threadId = $threadList->entries[0]['id'];
        $thread = new TypesettingDiscussionThreadModel($project, $threadId);
        $this->assertEqual($createUserId, $thread->authorInfo->modifiedByUserRef->asString());

        TypesettingDiscussionListCommands::updateThread($projectId, $modifyUserId, $threadList->entries[0]['id'], 'my updated thread');

        $threadList->read();
        $thread->read($threadId);
        $this->assertEqual($threadList->entries[0]['title'], 'my updated thread');
        $this->assertEqual($modifyUserId, $thread->authorInfo->modifiedByUserRef->asString());
    }

    public function testDeleteThread_TwoThreads_OneDeletedThread()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $userId = $e->createUser('joe', 'joe', 'joe');

        $asset = new TypesettingAssetModel($project);
        $assetId = $asset->write();

        $threadList = new TypesettingDiscussionThreadListModel($project);
        $threadList->read();
        $this->assertEqual($threadList->count, 0);

        TypesettingDiscussionListCommands::createThread($projectId, $userId, 'my first thread', $assetId);
        $threadList->read();
        TypesettingDiscussionListCommands::createThread($projectId, $userId, 'my second thread', $assetId);
        $threadList->read();
        $threadId = $threadList->entries[0]['id'];

        TypesettingDiscussionListCommands::deleteThread($projectId, $threadId);

        $threadList = new TypesettingDiscussionThreadListModel($project);
        $threadList->read();
        $this->assertEqual($threadList->count, 1);
        $this->assertEqual($threadList->entries[0]['title'], 'my first thread');
    }

    public function testGetThread_OneThreadExists_OneThreadReturned()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $userId = $e->createUser('joe', 'joe', 'joe');

        $asset = new TypesettingAssetModel($project);
        $assetId = $asset->write();

        $threadList = new TypesettingDiscussionThreadListModel($project);
        $threadList->read();

        $threadId1 = TypesettingDiscussionListCommands::createThread($projectId, $userId, 'thread 1', $assetId);
        $threadModel1 = new TypesettingDiscussionThreadModel($project, $threadId1);
        $threadModel2 = TypesettingDiscussionListCommands::getThread($projectId, $threadId1);

        $this->assertIdentical($threadModel1, $threadModel2);
    }

    public function testCreatePost_NoPostExists_OnePostExists()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $userId = $e->createUser('joe', 'joe', 'joe');

        $asset = new TypesettingAssetModel($project);
        $assetId = $asset->write();

        $threadList = new TypesettingDiscussionThreadListModel($project);
        $threadList->read();
        $this->assertEqual($threadList->count, 0);

        TypesettingDiscussionListCommands::createThread($projectId, $userId, 'my thread', $assetId);
        $threadList->read();
        $threadId = $threadList->entries[0]['id'];

        $postList = new TypesettingDiscussionPostListModel($project, $threadId);
        $postList->read();

        TypesettingDiscussionListCommands::createPost($projectId, $userId, $threadId, 'my post');
        $postList->read();
        $this->assertEqual($postList->count, 1);
        $this->assertEqual($postList->entries[0]['content'], 'my post');
    }

    public function testUpdatePost_OnePost_OneUpdatedPost()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $userId = $e->createUser('joe', 'joe', 'joe');

        $asset = new TypesettingAssetModel($project);
        $assetId = $asset->write();

        $threadList = new TypesettingDiscussionThreadListModel($project);
        $threadList->read();
        $this->assertEqual($threadList->count, 0);

        TypesettingDiscussionListCommands::createThread($projectId, $userId, 'my thread', $assetId);
        $threadList->read();
        $threadId = $threadList->entries[0]['id'];

        $postList = new TypesettingDiscussionPostListModel($project, $threadId);
        $postList->read();

        TypesettingDiscussionListCommands::createPost($projectId, $userId, $threadId, 'my post');
        $postList->read();
        $postId = $postList->entries[0]['id'];
        $this->assertEqual($postList->count, 1);
        $this->assertEqual($postList->entries[0]['content'], 'my post');

        TypesettingDiscussionListCommands::updatePost($projectId, $userId, $threadId, $postId, 'my updated post');
        $postList->read();
        $this->assertEqual($postList->count, 1);
        $this->assertEqual($postList->entries[0]['content'], 'my updated post');
    }

    public function testDeletePost_TwoPosts_OneDeletedPost()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $userId = $e->createUser('joe', 'joe', 'joe');

        $asset = new TypesettingAssetModel($project);
        $assetId = $asset->write();

        $threadList = new TypesettingDiscussionThreadListModel($project);
        $threadList->read();
        $this->assertEqual($threadList->count, 0);

        TypesettingDiscussionListCommands::createThread($projectId, $userId, 'my thread', $assetId);
        $threadList->read();
        $threadId = $threadList->entries[0]['id'];

        $postList = new TypesettingDiscussionPostListModel($project, $threadId);
        $postList->read();

        TypesettingDiscussionListCommands::createPost($projectId, $userId, $threadId, 'my first post');
        $postList->read();
        TypesettingDiscussionListCommands::createPost($projectId, $userId, $threadId, 'my second post');
        $postList->read();
        $post2Id = $postList->entries[1]['id'];

        TypesettingDiscussionListCommands::deletePost($projectId, $threadId, $post2Id);
        $postList->read();
        $this->assertEqual($postList->count, 1);
        $this->assertEqual($postList->entries[0]['content'], 'my first post');
    }

    public function testCreateReply_NoReplyExists_OneReplyExists()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $userId = $e->createUser('joe', 'joe', 'joe');

        $asset = new TypesettingAssetModel($project);
        $assetId = $asset->write();

        $threadList = new TypesettingDiscussionThreadListModel($project);
        $threadList->read();
        $this->assertEqual($threadList->count, 0);

        TypesettingDiscussionListCommands::createThread($projectId, $userId, 'my thread', $assetId);
        $threadList->read();
        $threadId = $threadList->entries[0]['id'];

        $postList = new TypesettingDiscussionPostListModel($project, $threadId);
        $postList->read();

        TypesettingDiscussionListCommands::createPost($projectId, $userId, $threadId, 'my post');
        $postList->read();
        $postId = $postList->entries[0]['id'];

        TypesettingDiscussionListCommands::createReply($projectId, $userId, $threadId, $postId, "my reply");
        $postList->read();

        $this->assertEqual($postList->entries[0]['replies'][0]['content'], "my reply");
    }

    /* updating replies is a feature that is not supported in the first release
    public function testUpdateReply_OneReply_OneUpdatedReply()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $userId = $e->createUser('joe', 'joe', 'joe');

        $asset = new TypesettingAssetModel($project);
        $assetId = $asset->write();

        $threadList = new TypesettingDiscussionThreadListModel($project);
        $threadList->read();
        $this->assertEqual($threadList->count, 0);

        TypesettingDiscussionListCommands::createThread($projectId, $userId, 'my thread', $assetId);
        $threadList->read();
        $threadId = $threadList->entries[0]['id'];

        $postList = new TypesettingDiscussionPostListModel($project, $threadId);
        $postList->read();

        TypesettingDiscussionListCommands::createPost($projectId, $userId, $threadId, 'my post');
        $postList->read();
        $postId = $postList->entries[0]['id'];

        TypesettingDiscussionListCommands::createReply($projectId, $userId, $threadId, $postId, "my reply");
        $postList->read();

        $replyId = $postList->entries[0]['replies'][0]['id'];

        TypesettingDiscussionListCommands::updateReply($projectId, $threadId, $postId, $replyId, "my updated reply");
        $postList->read();
        $this->assertEqual($postList->entries[0]['replies'][0]['content'], 'my updated reply');
    }
*/

    public function testDeleteReply_TwoReplies_OneDeletedReply()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $userId = $e->createUser('joe', 'joe', 'joe');

        $asset = new TypesettingAssetModel($project);
        $assetId = $asset->write();

        $threadList = new TypesettingDiscussionThreadListModel($project);
        $threadList->read();
        $this->assertEqual($threadList->count, 0);

        TypesettingDiscussionListCommands::createThread($projectId, $userId, 'my thread', $assetId);
        $threadList->read();
        $threadId = $threadList->entries[0]['id'];

        $postList = new TypesettingDiscussionPostListModel($project, $threadId);
        $postList->read();

        TypesettingDiscussionListCommands::createPost($projectId, $userId, $threadId, 'my post');
        $postList->read();
        $postId = $postList->entries[0]['id'];

        TypesettingDiscussionListCommands::createReply($projectId, $userId, $threadId, $postId, "my first reply");
        TypesettingDiscussionListCommands::createReply($projectId, $userId, $threadId, $postId, "my second reply");
        $postList->read();
        $replyId = $postList->entries[0]['replies'][0]['id'];
        $this->assertEqual($postList->entries[0]['replies'][0]['content'], 'my first reply');

        TypesettingDiscussionListCommands::deleteReply($projectId, $threadId, $postId, $replyId);
        $postList->read();

        $this->assertEqual($postList->entries[0]['replies'][0]['content'], 'my second reply');
    }

    public function testUpdateStatus_OldStatus_NewStatus()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $userId = $e->createUser('joe', 'joe', 'joe');

        $asset = new TypesettingAssetModel($project);
        $assetId = $asset->write();

        $threadList = new TypesettingDiscussionThreadListModel($project);
        $threadList->read();
        $this->assertEqual($threadList->count, 0);

        TypesettingDiscussionListCommands::createThread($projectId, $userId, 'my thread', $assetId);
        $threadList->read();
        $threadId = $threadList->entries[0]['id'];

        TypesettingDiscussionListCommands::updateStatus($projectId, $threadId, "Closed");
        $threadList->read();
        $this->assertEqual($threadList->entries[0]['status'], "Closed");
    }
}
