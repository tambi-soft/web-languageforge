<?php



use models\ProjectModel;

use models\scriptureforge\webtypesetting\RapumaAssetListModel;
use models\scriptureforge\webtypesetting\RapumaAssetModel;



require_once dirname(__FILE__) . '/../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';

require_once TestPath . 'common/MongoTestEnvironment.php';

require_once SourcePath . "models/ProjectModel.php";
// require_once SourcePath . "models/RapumaAssetModel.php";

class TestRapumaAssetModel extends UnitTestCase
{
    public function __construct()
    {
        $e = new MongoTestEnvironment();
        $e->clean();
    }

    public function testCRUD_Works()
    {
        $e = new MongoTestEnvironment();
        $projectModel = $e->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);

        // List
        $list = new RapumaAssetListModel($projectModel);
        $list->read();
        $this->assertEqual(0, $list->count);

        // Create
        $asset = new RapumaAssetModel($projectModel);
        
        $asset->title = "Jim";
        $asset->data = "Not Really Data";
        $id = $asset->write();
        $this->assertNotNull($id);
        $this->assertIsA($id, 'string');
        $this->assertEqual($id, $asset->id->asString());

        // Read back
        $otherAsset = new RapumaAssetModel($projectModel, $id);
        $this->assertEqual($id, $otherAsset->id->asString());
        $this->assertEqual('Not Really Data', $otherAsset->data);
        $this->assertEqual('Jim', $otherAsset->title);

        // Update
        $otherAsset->data = 'Still Not Really Data';
        $otherAsset->write();

        // Read back
        $otherAsset = new RapumaAssetModel($projectModel, $id);
        $this->assertEqual('Still Not Really Data', $otherAsset->data);

        // List
        $list->read();
        $this->assertEqual(1, $list->count);

        // Delete
        RapumaAssetModel::remove($projectModel->databaseName(), $id);

        // List
        $list->read();
        $this->assertEqual(0, $list->count);

    }
/*
    public function testTextReference_NullRefValidRef_AllowsNullRef()
    {
        $projectModel = new MockProjectModel();
        $mockTextRef = (string) new \MongoId();

        // Test create with null textRef
        $asset = new RapumaAssetModel($projectModel);
        $id = $asset->write();

        $otherAsset = new RapumaAssetModel($projectModel, $id);
        $this->assertEqual('', $otherAsset->textRef->id);

        // Test update with textRef
        $asset->textRef->id = $mockTextRef;
        $asset->write();

        $otherAsset = new RapumaAssetModel($projectModel, $id);
        $this->assertEqual($mockTextRef, $otherAsset->textRef->id);

    }
*/
}