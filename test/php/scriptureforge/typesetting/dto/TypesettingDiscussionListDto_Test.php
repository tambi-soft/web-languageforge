<?php
use models\scriptureforge\typesetting\commands\TypesettingDiscussionListCommands;
use models\scriptureforge\typesetting\dto\TypesettingDiscussionListDto;
use models\scriptureforge\typesetting\TypesettingDiscussionPostModel;
use models\scriptureforge\typesetting\TypesettingDiscussionThreadModel;
use models\languageforge\lexicon\LexCommentReply;
use models\languageforge\lexicon\AuthorInfo;
use models\mapper\ArrayOf;
use models\mapper\Id;
use models\mapper\IdReference;

require_once dirname(__FILE__) . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';

class TestTypesettingDiscussionListDto extends UnitTestCase
{

    public function testEncode_TwoThreads_DtoAsExpected()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $joeUserId = $e->createUser('joe', 'joe', 'joe');
        $bobUserId = $e->createUser('bob', 'bob', 'bob');

        // tests the creation and reading of threads, posts, and replies
        // add two discussion threads
        $threadModelId1 = TypesettingDiscussionListCommands::createThread($projectId, $joeUserId, 'My first thread', 'MAT');
        $threadModel1 = new TypesettingDiscussionThreadModel($project, $threadModelId1);
        $threadModelId2 = TypesettingDiscussionListCommands::createThread($projectId, $bobUserId, 'My second thread', 'MRK');
        $threadModel2 = new TypesettingDiscussionThreadModel($project, $threadModelId2);

        // add two posts to the second discussion
        $postModelId1 = TypesettingDiscussionListCommands::createPost($projectId, $bobUserId, $threadModelId2, 'My first post');
        $postModel1 = new TypesettingDiscussionPostModel($project, $threadModelId2, $postModelId1);
        $postModelId2 = TypesettingDiscussionListCommands::createPost($projectId, $bobUserId, $threadModelId2, 'My second post');
        $postModel2 = new TypesettingDiscussionPostModel($project, $threadModelId2, $postModelId2);

        // add two repies to the second post on the second discussion
        $reply1 = new LexCommentReply();
        $reply1->content = "My first reply";
        $postModel2->replies->append($reply1);
        $postModel2->write();

        $reply2 = new LexCommentReply();
        $reply2->content = "My second reply";
        $postModel2->replies->append($reply2);
        $postModel2->write();

        $result = TypesettingDiscussionListDto::encode($projectId);

        $this->assertEqual($result['threads'][1]['title'], 'My first thread');
        $this->assertEqual($result['threads'][1]['author']['name'], 'joe');
        $this->assertEqual($result['threads'][0]['title'], 'My second thread');
        $this->assertEqual($result['threads'][0]['posts'][0]['content'], 'My first post');
        $this->assertEqual($result['threads'][0]['posts'][1]['content'], 'My second post');
        $this->assertEqual($result['threads'][0]['posts'][1]['replies'][0]['content'], 'My first reply');
        $this->assertEqual($result['threads'][0]['posts'][1]['replies'][1]['content'], 'My second reply');

        // tests editing of threads, posts, and replies
        // updates threads
        $threadModel1->title = "My updated first thread";
        $threadModel1->write();

        $threadModel2->title = "My updated second thread";
        $threadModel2->write();

        // updates posts on thread 2
        $postModel1->content = "My updated first post";
        $postModel1->write();

        $postModel2->content = "My updated second post";
        $postModel2->write();

        // tests that the titles have changed and that the posts are still associated with their threads
        $result = TypesettingDiscussionListDto::encode($projectId);

        $this->assertEqual($result['threads'][1]['title'], 'My updated first thread');
        $this->assertEqual($result['threads'][0]['title'], 'My updated second thread');
        $this->assertEqual($result['threads'][0]['posts'][1]['content'], 'My updated first post');
        $this->assertEqual($result['threads'][0]['posts'][0]['content'], 'My updated second post');

        // tests deleting of threads, posts, and replies

        $threadModel1->isDeleted = true;
        $threadModel1->write();

        $postModel1->isDeleted = true;
        $postModel1->write();

        $postModel2->deleteReply($postModel2->replies[0]->id);
        $postModel2->deleteReply($postModel2->replies[1]->id);

        $postModel2->isDeleted = true;
        $postModel2->write();

        $threadModel2->isDeleted = true;
        $threadModel2->write();

        $this->assertTrue($threadModel1->isDeleted);
        $this->assertTrue($threadModel2->isDeleted);
        $this->assertTrue($postModel1->isDeleted);
        $this->assertTrue($postModel2->isDeleted);
    }
}