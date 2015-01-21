<?php

use models\scriptureforge\webtypesetting\TypesettingDiscussionPostModel;
use models\scriptureforge\webtypesetting\dto\WebtypesettingDiscussionListPageDto;
use models\scriptureforge\webtypesetting\WebtypesettingDiscussionThreadModel;

use models\languageforge\lexicon\LexCommentReply;
use models\languageforge\lexicon\AuthorInfo;

use models\mapper\ArrayOf;
use models\mapper\Id;
use models\mapper\IdReference;

use models\scriptureforge\webtypesetting\commands\WebtypesettingDiscussionListCommands;

require_once dirname(__FILE__) . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';

class TestWebtypesettingDiscussionListPageDto extends UnitTestCase
{
    public function testEncode_TwoThreads_DtoAsExpected()
    {
        $e = new MongoTestEnvironment();
        $e->clean();

        $project = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();

        
        // tests the creation and reading of threads, posts, and replies
        // add two discussion threads
        $threadModel1 = new WebtypesettingDiscussionThreadModel($project);
        $threadModel1->title = "My first thread";
        $threadModel1->associatedItem = "MAT";
        $threadModel1->write();
        
        $threadModel2 = new WebtypesettingDiscussionThreadModel($project);
        $threadModel2->title = "My second thread";
        $threadModel2->associatedItem = "MRK";
        $threadModel2->write();
        
        // add two posts to the second discussion
        $postModel1 = new TypesettingDiscussionPostModel($project, $threadModel2->id->asString());
        $postModel1->content = "My first post";
        $postModel1->write();
        
        $postModel2 = new TypesettingDiscussionPostModel($project, $threadModel2->id->asString());
        $postModel2->content = "My second post";
//         $postModel2->write();
        
        // add two repies to the second post on the second discussion
        $reply1 = new LexCommentReply();
        $reply1->content = "My first reply";
        $postModel2->replies->append($reply1);
//         $postModel2->write();
       
        $reply2 = new LexCommentReply();
        $reply2->content = "My second reply";
        $postModel2->replies->append($reply2);
        $postModel2->write();

    	$result = WebtypesettingDiscussionListPageDto::encode($projectId);
    	$this->assertEqual($result['threads'][0]['title'], 'My first thread');
    	$this->assertEqual($result['threads'][1]['title'], 'My second thread');
    	$this->assertEqual($result['threads'][1]['posts'][0]['content'], 'My first post');
    	$this->assertEqual($result['threads'][1]['posts'][1]['content'], 'My second post');
    	$this->assertEqual($result['threads'][1]['posts'][1]['replies'][0]['content'], 'My first reply');
    	$this->assertEqual($result['threads'][1]['posts'][1]['replies'][1]['content'], 'My second reply');
    	
    	
    	// tests editing of threads, posts, and replies 
    	// updates the thread titles - Use this pattern in an "edit" or "update" function in threadModel? Ask Chris.
    	$threadModel1->title = "My updated first thread";
    	$threadModel1->write();
    	$threadModel2->title = "My updated second thread";
    	$threadModel2->write();
    	
    	$postModel1->content = "My updated first post";
    	$postModel1->write();
    	$postModel2->content = "My updated second post";
    	$postModel2->write();
    	
    	// tests that the titles have changed and that the posts are still associated with their threads
    	$result = WebtypesettingDiscussionListPageDto::encode($projectId);
    	$this->assertEqual($result['threads'][0]['title'], 'My updated first thread');
    	$this->assertEqual($result['threads'][1]['title'], 'My updated second thread');
    	$this->assertEqual($result['threads'][1]['posts'][0]['content'], 'My updated first post');
    	$this->assertEqual($result['threads'][1]['posts'][1]['content'], 'My updated second post');
    	$this->assertEqual($result['threads'][1]['posts'][0]['threadRef'], $threadModel2->id->asString());
    	$this->assertEqual($result['threads'][1]['posts'][1]['threadRef'], $threadModel2->id->asString());
    	
     	// tests deleting of threads, posts, and replies
    	
    	
    	
    	
    	var_dump($result['threads'][1]['posts'][1]);

    }
}