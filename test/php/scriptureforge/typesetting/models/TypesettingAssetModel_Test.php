<?php



use models\ProjectModel;

use models\scriptureforge\typesetting\TypesettingAssetListModel;
use models\scriptureforge\typesetting\TypesettingAssetModel;
use models\scriptureforge\typesetting\TypesettingAssetFile;
use models\scriptureforge\typesetting\TypesettingAssetChild;
use models\scriptureforge\typesetting\TypesettingAssetGroupList;
use models\scriptureforge\typesetting\TypesettingAssetFont;



require_once dirname(__FILE__) . '/../../../TestConfig.php';
require_once SimpleTestPath . 'autorun.php';

require_once TestPath . 'common/MongoTestEnvironment.php';

require_once SourcePath . "models/ProjectModel.php";
require_once SourcePath . "models/scriptureforge/typesetting/TypesettingAssetModel.php";

class TestTypesettingAssetModel extends UnitTestCase
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
        $list = new TypesettingAssetListModel($projectModel);
        $list->read();
        $this->assertEqual(0, $list->count);
        
        // Create asset
        $asset = new TypesettingAssetModel($projectModel);
        $asset->name = 'asset-name-1';
        $asset->path = 'asset-path-1';
        $asset->type = 'usfm-zip';
        $asset->uploaded = true;
        
        
        $id = $asset->write();
        $this->assertNotNull($id);
        $this->assertIsA($id, 'string');
        $this->assertEqual($id, $asset->id->asString());
        
        // Create font
        $font = new TypesettingAssetFont($projectModel);
        $font->name = 'font-name-1';
        $font->path = 'font-path-1';
        $font->active = true;
        $font->primary = true;
        
        $font_id = $font->write();
        $this->assertNotNull($font_id);
        $this->assertIsA($font_id, 'string');
        $this->assertEqual($font_id, $font->id->asString());

        // Read back asset
        $otherAsset = new TypesettingAssetModel($projectModel, $id);
        $this->assertEqual($id, $otherAsset->id->asString());
        $this->assertEqual('asset-name-1', $otherAsset->name);
        $this->assertEqual('asset-path-1', $otherAsset->path);
        $this->assertEqual('usfm-zip', $otherAsset->type);
        $this->assertEqual(true, $otherAsset->uploaded);
        
        // Read back font
        $otherFont = new TypesettingAssetFont($projectModel, $font_id);
        $this->assertEqual($font_id, $otherFont->id->asString());
        $this->assertEqual('font-name-1', $otherFont->name);
        $this->assertEqual('font-path-1', $otherFont->path);
        $this->assertEqual(true, $otherFont->active);
        $this->assertEqual(true, $otherFont->primary);

        // Update asset
        $otherAsset->name = 'asset-name-2';
        $otherAsset->path = 'asset-path-2';
        $otherAsset->type = 'png';
        $otherAsset->uploaded = false;
        $otherAsset->write();
        
        // Update font
        $otherFont->name = 'font-name-2';
        $otherFont->path = 'font-path-2';
        $otherFont->active = false;
        $otherFont->primary = false;
        $otherFont->write();

        // Read back asset
        $otherAsset = new TypesettingAssetModel($projectModel, $id);
        $this->assertEqual('asset-name-2', $otherAsset->name);
        $this->assertEqual('asset-path-2', $otherAsset->path);
        $this->assertEqual('png', $otherAsset->type);
        $this->assertEqual(false, $otherAsset->uploaded);
        
        // Read back font
        $otherFont = new TypesettingAssetFont($projectModel, $font_id);
        $this->assertEqual($font_id, $otherFont->id->asString());
        $this->assertEqual('font-name-2', $otherFont->name);
        $this->assertEqual('font-path-2', $otherFont->path);
        $this->assertEqual(false, $otherFont->active);
        $this->assertEqual(false, $otherFont->primary);

        // List
        $list->read();
        $this->assertEqual(2, $list->count);

        // Delete
        TypesettingAssetModel::remove($projectModel->databaseName(), $id);
        TypesettingAssetModel::remove($projectModel->databaseName(), $font_id);

        // List
        $list->read();
        $this->assertEqual(0, $list->count);

    }
}