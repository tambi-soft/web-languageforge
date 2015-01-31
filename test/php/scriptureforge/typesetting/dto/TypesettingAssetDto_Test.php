<?php

use models\shared\rights\ProjectRoles;
use models\scriptureforge\typesetting\dto\TypesettingAssetDto;
use models\scriptureforge\typesetting\TypesettingAssetModel;
use models\scriptureforge\typesetting\commands\TypesettingUploadCommands;

require_once dirname(__FILE__) . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';
require_once TestPath . 'common/MongoTestEnvironment.php';

class TestTypesettingAssetDto extends UnitTestCase
{

    public function __construct() {
        $this->environ = new MongoTestEnvironment();
        $this->environ->clean();
        parent::__construct();
    }

    /**
     * Local store of mock test environment
     *
     * @var MongoTestEnvironment
     */
    private $environ;

    /**
     * Cleanup test environment
     */
    public function tearDown()
    {
        $this->environ->clean();
    }

    public function testEncode_AssetFile_DtoReturnsExpectedData()
    {
        $project = $this->environ->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();

        // Two questions, with different numbers of answers and different create dates
        $asset1 = new TypesettingAssetModel($project);
        $asset1->name = 'asset-name-1';
        $asset1->path = 'asset-path-1';
        $asset1->type = 'usfm-zip';
        $asset1->uploaded = true;
        $asset1Id = $asset1->write();

        $asset2 = new TypesettingAssetModel($project);
        $asset2->name = 'asset-name-2';
        $asset2->path = 'asset-path-2';
        $asset2->type = 'png';
        $asset2->uploaded = true;
        $asset2Id = $asset2->write();

        $dto = TypesettingAssetDto::encode($projectId);

        // Now check that it all looks right
        $this->assertIsa($dto['entries'], 'array');

        //Checking all the zip file attributes
        $this->assertEqual($dto['entries'][0]['id'], $asset1Id);
        $this->assertEqual($dto['entries'][0]['name'], $asset1->name);
        $this->assertEqual($dto['entries'][0]['path'], $asset1->path);
        $this->assertEqual($dto['entries'][0]['type'], $asset1->type);
        $this->assertEqual($dto['entries'][0]['uploaded'], $asset1->uploaded);

        //Checking all the png file attributes
        $this->assertEqual($dto['entries'][1]['id'], $asset2Id);
        $this->assertEqual($dto['entries'][1]['name'], $asset2->name);
        $this->assertEqual($dto['entries'][1]['path'], $asset2->path);
        $this->assertEqual($dto['entries'][1]['type'], $asset2->type);
        $this->assertEqual($dto['entries'][1]['uploaded'], $asset2->uploaded);

    }
    public function testEncode_UploadedAssetFile_DtoReturnsExpectedData()
    {
    	$project = $this->environ->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
    	$projectId = $project->id->asString();

    	$fileName = 'TestImage.png';
    	$tmpFilePath = $this->environ->uploadFile(TestPath . "common/$fileName", $fileName);
    	$response = TypesettingUploadCommands::uploadFile($projectId, 'png', $tmpFilePath);

    	$dto = TypesettingAssetDto::encode($projectId);
    	$this->assertEqual($dto['count'], 1);

    	$fileName = 'pngTest.png';
    	$tmpFilePath = $this->environ->uploadFile(TestPath . "common/$fileName", $fileName);
    	$response = TypesettingUploadCommands::uploadFile($projectId, 'png', $tmpFilePath);

    	$dto = TypesettingAssetDto::encode($projectId);
    	$this->assertEqual($dto['count'], 2);
    }
/*
    public function testEncode_ArchivedText_ManagerCanViewContributorCannot()
    {
        $project = $this->environ->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();

        // archived Text
        $text = new TextModel($project);
        $text->title = "Chapter 3";
        $text->isArchived = true;
        $textId = $text->write();

        // Answers are tied to specific users, so let's create some sample users
        $managerId = $this->environ->createUser("jcarter", "John Carter", "johncarter@example.com");
        $contributorId = $this->environ->createUser("dthoris", "Dejah Thoris", "princess@example.com");
        $project->addUser($managerId, ProjectRoles::MANAGER);
        $project->addUser($contributorId, ProjectRoles::CONTRIBUTOR);
        $project->write();

        $dto = TypesettingAssetDto::encode($projectId, $textId, $managerId);

        // Manager can view archived Text
        $this->assertEqual($dto['text']['title'], "Chapter 3");

        // Contributor cannot view archived Text, throw Exception
        $this->environ->inhibitErrorDisplay();
        $this->expectException();
        $dto = TypesettingAssetDto::encode($projectId, $textId, $contributorId);

        // nothing runs in the current test function after an exception. IJH 2014-11
    }
    // this test was designed to finish testEncode_ArchivedText_ManagerCanViewContributorCannot
    public function testEncode_ArchivedText_ManagerCanViewContributorCannot_RestoreErrorDisplay()
    {
        // restore error display after last test
        $this->environ->restoreErrorDisplay();
    }
    */
}
