<?php

use Api\Model\Scriptureforge\Typesetting\Command\TypesettingDiscussionListCommands;
use Api\Model\Scriptureforge\Typesetting\Dto\TypesettingDiscussionListDto;
use Api\Model\Scriptureforge\Typesetting\TypesettingDiscussionPostModel;
use Api\Model\Scriptureforge\Typesetting\TypesettingDiscussionThreadModel;

require_once __DIR__ . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';

class TestTypesettingDiscussionListDto extends UnitTestCase
{

    private static function indexesById($items)
    {
        $indexes = array();
        foreach ($items as $item) {
            $indexes[$item['id']] = $item;
        }
        return $indexes;
    }

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
        $postModelId2 = TypesettingDiscussionListCommands::createPost($projectId, $joeUserId, $threadModelId2, 'My second post');

        // add two repies to the second post on the second discussion
        TypesettingDiscussionListCommands::createReply($projectId, $joeUserId, $threadModelId2, $postModelId2, 'My first reply');
        TypesettingDiscussionListCommands::createReply($projectId, $bobUserId, $threadModelId2, $postModelId2, 'My second reply');
        $postModel2 = new TypesettingDiscussionPostModel($project, $threadModelId2, $postModelId2);

        $dto = TypesettingDiscussionListDto::encode($projectId);

        $this->assertEqual($dto['threads'][1]['title'], 'My first thread');
        $this->assertEqual($dto['threads'][1]['author']['name'], 'joe');
        $this->assertEqual($dto['threads'][0]['title'], 'My second thread');
        $this->assertEqual($dto['threads'][0]['author']['name'], 'bob');
        $this->assertEqual($dto['threads'][0]['posts'][0]['content'], 'My first post');
        $this->assertEqual($dto['threads'][0]['posts'][0]['author']['name'], 'bob');
        $this->assertEqual($dto['threads'][0]['posts'][1]['content'], 'My second post');
        $this->assertEqual($dto['threads'][0]['posts'][1]['author']['name'], 'joe');
        $this->assertEqual($dto['threads'][0]['posts'][1]['replies'][0]['content'], 'My first reply');
        $this->assertEqual($dto['threads'][0]['posts'][1]['replies'][0]['author']['name'], 'joe');
        $this->assertEqual($dto['threads'][0]['posts'][1]['replies'][1]['content'], 'My second reply');
        $this->assertEqual($dto['threads'][0]['posts'][1]['replies'][1]['author']['name'], 'bob');
        $this->assertEqual(count($dto['threads'][0]['posts'][1]['replies']), 2);

        // tests editing of threads, posts, and replies
        // updates threads
        TypesettingDiscussionListCommands::updateThread($projectId, $bobUserId, $threadModelId1, 'My updated first thread');
        TypesettingDiscussionListCommands::updateThread($projectId, $joeUserId, $threadModelId2, 'My updated second thread');

        // updates posts on thread 2
        TypesettingDiscussionListCommands::updatePost($projectId, $joeUserId, $threadModelId2, $postModelId1, 'My updated first post');
        TypesettingDiscussionListCommands::updatePost($projectId, $bobUserId, $threadModelId2, $postModelId2, 'My updated second post');

        $dto = TypesettingDiscussionListDto::encode($projectId);

        // tests that the titles have changed and that the posts are still associated with their threads
        $indexes = self::indexesById($dto['threads']);
        $threadList1 = $indexes[$threadModelId1];
        $threadList2 = $indexes[$threadModelId2];
        $indexes = self::indexesById($threadList2['posts']);
        $postList1 = $indexes[$postModelId1];
        $postList2 = $indexes[$postModelId2];
        $this->assertEqual($threadList1['title'], 'My updated first thread');
        $this->assertEqual($threadList2['title'], 'My updated second thread');
        $this->assertEqual($postList1['content'], 'My updated first post');
        $this->assertEqual($postList2['content'], 'My updated second post');

        // tests deleting of threads, posts, and replies
        $this->assertEqual(count($postList2['replies']), 2);
        TypesettingDiscussionListCommands::deleteReply($projectId, $threadModelId2, $postModelId2, $postModel2->replies[0]->id);

        $dto = TypesettingDiscussionListDto::encode($projectId);

        $indexes = self::indexesById($dto['threads']);
        $threadList2 = $indexes[$threadModelId2];
        $indexes = self::indexesById($threadList2['posts']);
        $postList2 = $indexes[$postModelId2];
        $this->assertEqual(count($postList2['replies']), 1);
        $this->assertEqual($postList2['replies'][0]['content'], 'My second reply');

        $this->assertEqual(count($threadList2['posts']), 2);
        TypesettingDiscussionListCommands::deletePost($projectId, $threadModelId2, $postModelId1);

        $dto = TypesettingDiscussionListDto::encode($projectId);

        $indexes = self::indexesById($dto['threads']);
        $threadList2 = $indexes[$threadModelId2];
        $indexes = self::indexesById($threadList2['posts']);
        $postList2 = $indexes[$postModelId2];
        $this->assertEqual(count($threadList2['posts']), 1);
        $this->assertEqual($postList2['content'], 'My updated second post');

        $this->assertEqual(count($dto['threads']), 2);
        TypesettingDiscussionListCommands::deleteThread($projectId, $threadModelId1);

        $dto = TypesettingDiscussionListDto::encode($projectId);

        $indexes = self::indexesById($dto['threads']);
        $threadList2 = $indexes[$threadModelId2];
        $this->assertEqual(count($dto['threads']), 1);
        $this->assertEqual($threadList2['title'], 'My updated second thread');

        TypesettingDiscussionListCommands::deleteThread($projectId, $threadModelId2);

        $dto = TypesettingDiscussionListDto::encode($projectId);

        $this->assertEqual(count($dto['threads']), 0);
    }
}
