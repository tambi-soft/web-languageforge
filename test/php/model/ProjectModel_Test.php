<?php
use libraries\sf\MongoStore;

require_once(dirname(__FILE__) . '/../TestConfig.php');
require_once(SimpleTestPath . 'autorun.php');

require_once(TestPath . 'common/MongoTestEnvironment.php');

require_once(SourcePath . "models/UserModel.php");
require_once(SourcePath . "models/ProjectModel.php");

use models\UserModel;
use models\ProjectModel;

class TestProjectModel extends UnitTestCase {

	private $_someProjectId;
	
	function __construct()
	{
		$e = new MongoTestEnvironment();
		$e->clean();
	}
	
	function testWrite_ReadBackSame()
	{
		$model = new ProjectModel();
		$model->language = "SomeLanguage";
		$model->projectname = "SomeProject";
		$id = $model->write();
		$this->assertNotNull($id);
		$this->assertIsA($id, 'string');
		$this->assertEqual($id, $model->id);
		$otherModel = new ProjectModel($id);
		$this->assertEqual($id, $otherModel->id);
		$this->assertEqual('SomeLanguage', $otherModel->language);
		$this->assertEqual('SomeProject', $otherModel->projectname);
		
		$this->_someProjectId = $id;
	}

	function testProjectList_HasCountAndEntries()
	{
		$model = new models\ProjectListModel();
		$model->read();
		
		$this->assertNotEqual(0, $model->count);
		$this->assertNotNull($model->entries);
	}
	
	function testProjectAddUser_ExistingProject_ReadBackAdded() {
		$project = new ProjectModel($this->_someProjectId);
		
		$userId = 'BogusId'; // Note: The user doesn't really need to exist for this test.
		$project->_addUser($userId);
		$project->write();
		
		$this->assertTrue(in_array($userId, $project->users));
		$otherProject = new ProjectModel($this->_someProjectId);
		$this->assertTrue(in_array($userId, $otherProject->users), "'$userId' not found in project.");
	}
	
	function testProjectRemoveUser_ExistingProject_Removed() {
		$project = new ProjectModel($this->_someProjectId);
		
		$userId = 'BogusId'; // Note: The user doesn't really need to exist for this test.
		$project->_addUser($userId);
		$project->write();
		
		$this->assertTrue(in_array($userId, $project->users));
		$otherProject = new ProjectModel($this->_someProjectId);
		$this->assertTrue(in_array($userId, $otherProject->users), "'$userId' not found in project.");
		
		// Test really starts here.
		$project->_removeUser($userId);
		$project->write();

		$this->assertFalse(in_array($userId, $project->users));
		$otherProject = new ProjectModel($this->_someProjectId);
		$this->assertFalse(in_array($userId, $otherProject->users), "'$userId' should not be found in project.");
		
	}
	
	function testProjectAddUser_TwiceToSameProject_AddedOnce() {
		$project = new ProjectModel($this->_someProjectId);
		
		$userId = 'BogusId'; // Note: The user doesn't really need to exist for this test.
		$project->_addUser($userId);
		// Note: We intentionall don't write for this test. It is unnecessary for this test.
		
		$this->assertEqual(1, count($project->users));
		$project->_addUser($userId);
		$this->assertEqual(1, count($project->users));
	}
	
	function testProjectListUsers_TwoUsers_ListHasDetails() {
		$e = new MongoTestEnvironment();
		$userId1 = $e->createUser('user1', 'User One', 'user1@example.com');
		$userId2 = $e->createUser('user2', 'User Two', 'user2@example.com');
		
		$project = new ProjectModel($this->_someProjectId);
		
		// Check the list users is empty
		$result = $project->listUsers();
		$this->assertEqual(0, $result->count);
		$this->assertEqual(array(), $result->entries);
				
		// Add our two users
		$project->addUser($userId1);
		$project->addUser($userId2);
		$project->write();
		
		$otherProject = new ProjectModel($this->_someProjectId);
		$result = $otherProject->listUsers();
		$this->assertEqual(2, $result->count);
		$this->assertEqual(
			array(
				array(
		          'email' => 'user1@example.com',
		          'name' => 'User One',
		          'username' => 'user1',
		          'id' => $userId1
				), 
				array(
		          'email' => 'user2@example.com',
		          'name' => 'User Two',
		          'username' => 'user2',
		          'id' => $userId2
				)
			), $result->entries
		);
		
	}
	
	function testRemove_RemovesProject() {
		$e = new MongoTestEnvironment();
		$project = new ProjectModel($this->_someProjectId);
		$project->remove();
		
		$e->inhibitErrorDisplay();
		$this->expectException(new \Exception("Could not find id '$this->_someProjectId'"));
		$project = new ProjectModel($this->_someProjectId);
		$e->resotreErrorDisplay();
	}
	
	function testDatabaseName_Ok() {
		$project = new ProjectModel();
		$project->projectname = 'Some Project';
		$result = $project->databaseName();
		$this->assertEqual('sf_some_project', $result);
	}
		
}

?>