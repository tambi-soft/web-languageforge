<?php
use models\scriptureforge\typesetting\commands\TypesettingUploadCommands;
use models\scriptureforge\typesetting\TypesettingAssetModel;

require_once (dirname(__FILE__) . '/../../../TestConfig.php');
require_once (SimpleTestPath . 'autorun.php');
require_once (TestPath . 'common/MongoTestEnvironment.php');

class TestTypesettingUploadCommands extends UnitTestCase
{

    public function __construct()
    {
        $this->environ = new TypesettingMongoTestEnvironment();
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
     * Cleanup test lift files
     */
    public function tearDown()
    {
        $this->environ->clean();
        $this->environ->cleanupTestFiles($this->environ->project->getAssetsFolderPath());
    }

    public function testInstalledPackages_UnzipAnd7zip_Installed() {
        $project = $this->environ->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $command = 'which unzip';
        $output = array();
        $returnCode = 0;

        exec($command, $output, $returnCode);

        $this->assertEqual(0, $returnCode, 'exec return code non-zero');
        $this->assertPattern('/unzip/', $output[0], 'run apt-get install unzip');

        $command = 'which 7z';
        $output = array();
        $returnCode = 0;

        exec($command, $output, $returnCode);

        $this->assertEqual(0, $returnCode, 'exec return code non-zero');
        $this->assertPattern('/7z/', $output[0], 'run apt-get install p7zip-full');
    }

    public function testExtractZip_ZipFile_FileListOk()
    {
        $project = $this->environ->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $zipFilePath = TestPath . 'scriptureforge/typesetting/commands/TestTypesettingProject.zip';
        $extractFolderPath = $project->getAssetsFolderPath();

        $extractedFilePaths = TypesettingUploadCommands::extractZip($zipFilePath, $extractFolderPath);

        $this->assertEqual($extractFolderPath . '/44JHNKJVT.SFM', $extractedFilePaths[0]);
    }

    public function testExtractZip_7zipFile_FileListOk()
    {
        $project = $this->environ->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $zipFilePath = TestPath . 'scriptureforge/typesetting/commands/TestTypesettingProject.7z';
        $extractFolderPath = $project->getAssetsFolderPath();

        $extractedFilePaths = TypesettingUploadCommands::extractZip($zipFilePath, $extractFolderPath);

        $this->assertEqual($extractFolderPath . '/44JHNKJVT.SFM', $extractedFilePaths[0]);
    }

    public function testUploadPngFile_PngFile_UploadAllowed()
    {
        $project = $this->environ->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $fileName = 'TestImage.png';
        $tmpFilePath = $this->environ->uploadFile(TestPath . "common/$fileName", $fileName);

        $response = TypesettingUploadCommands::uploadFile($projectId, 'png', $tmpFilePath);

        $projectSlug = $project->databaseName();
        $folderPath = $project->getAssetsFolderPath();
        $filePath = $folderPath . '/' . $response->data->fileName;

        $this->assertTrue($response->result, 'Import should succeed');
        $this->assertPattern("/$fileName/", $response->data->fileName, 'Imported PNG fileName should contain the original fileName');
        $this->assertTrue(file_exists($filePath), 'Imported PNG file should exist');

        $assetId = $response->data->assetId;
        $pngAsset = new TypesettingAssetModel($project, $assetId);
        $this->assertEqual($fileName, $pngAsset->name);
        $this->assertEqual('/' . $project->getAssetsRelativePath(), $pngAsset->path);
        $this->assertEqual('png', $pngAsset->type);
        $this->assertEqual(true, $pngAsset->uploaded);

        /*
         * TODO: Uncomment after we can reupload a file of the same name. Currently this is unsupported. - Justin Southworth 1/2015
         *
         * $response = TypesettingUploadCommands::uploadFile($projectId, 'png', $tmpFilePath);
         *
         * $this->assertTrue($response->result, 'Reimport should replace existing file');
         * $this->assertPattern("/$fileName/", $response->data->fileName, 'Reimported PNG fileName should contain the original fileName');
         * $this->assertTrue(file_exists($filePath), 'Imported PNG file should exist');
         */
    }

    public function testUploadPngFile_JpgFile_UploadDisallowed()
    {
        $project = $this->environ->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $fileName = 'TestImage.png';
        $tmpFilePath = $this->environ->uploadFile(TestPath . "common/$fileName", 'NotAJpg.jpg');

        $response = TypesettingUploadCommands::uploadFile($projectId, 'png', $tmpFilePath);

        $this->assertFalse($response->result, 'Import should fail');
        $this->assertEqual('UserMessage', $response->data->errorType, 'Error response should be a user message');
        $this->assertPattern('/not an allowed PNG file/', $response->data->errorMessage, 'Error message should match the error');

        $tmpFilePath = $this->environ->uploadFile(TestPath . 'common/TestImage.jpg', 'TestImage.png');

        $response = TypesettingUploadCommands::uploadFile($projectId, 'png', $tmpFilePath);

        $this->assertFalse($response->result, 'Import should fail');
        $this->assertEqual('UserMessage', $response->data->errorType, 'Error response should be a user message');
        $this->assertPattern('/not an allowed PNG file/', $response->data->errorMessage, 'Error message should match the error');
    }

    public function testImportProjectZip_ZipFile_UsfmExtracted()
    {
        $project = $this->environ->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $fileName = 'TestTypesettingProject.zip';
        $usfmFileName = '44JHNKJVT.SFM';
        $tmpFilePath = $this->environ->uploadFile(TestPath . "scriptureforge/typesetting/commands/$fileName", $fileName);

        $response = TypesettingUploadCommands::uploadFile($projectId, 'usfm-zip', $tmpFilePath);

        $folderPath = $project->getAssetsFolderPath();
        $filePath = $folderPath . '/' . $response->data->fileName;
        $usfmPath = $folderPath . '/' . $usfmFileName;
        $projectSlug = $project->databaseName();

        $this->assertTrue($response->result, 'Import should succeed');
        $this->assertPattern("/typesetting\/$projectSlug/", $response->data->path, 'Uploaded zip file path should be in the right location');
        $this->assertEqual($fileName, $response->data->fileName, 'Uploaded zip fileName should have the original fileName');
        $this->assertTrue(file_exists($filePath), 'Uploaded zip file should exist');
        $this->assertTrue(file_exists($usfmPath), 'USFM file should exist');

        $zipAssetId = $response->data->assetId;
        $zipAsset = new TypesettingAssetModel($project, $zipAssetId);
        $this->assertEqual($fileName, $zipAsset->name);
        $this->assertEqual('/' . $project->getAssetsRelativePath(), $zipAsset->path);
        $this->assertEqual('usfm-zip', $zipAsset->type);
        $this->assertEqual(true, $zipAsset->uploaded);

        $usfmAssetId = $response->data->extractedAssetIds[0];
        $usfmAsset = new TypesettingAssetModel($project, $usfmAssetId);
        $this->assertEqual($usfmFileName, $usfmAsset->name);
        $this->assertEqual('/' . $project->getAssetsRelativePath(), $usfmAsset->path);
        $this->assertEqual('usfm', $usfmAsset->type);
        $this->assertEqual(true, $usfmAsset->uploaded);
    }

    public function testImportProjectZip_JpgFile_UploadDisallowed()
    {
        $project = $this->environ->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $tmpFilePath = $this->environ->uploadFile(TestPath . 'common/TestImage.jpg', 'TestTypesettingProject.zip');

        $response = TypesettingUploadCommands::uploadFile($projectId, 'usfm-zip', $tmpFilePath);

        $this->assertFalse($response->result, 'Import should fail');
        $this->assertEqual('UserMessage', $response->data->errorType, 'Error response should be a user message');
        $this->assertPattern('/not an allowed compressed file/', $response->data->errorMessage, 'Error message should match the error');

        $tmpFilePath = $this->environ->uploadFile(TestPath . 'scriptureforge/typesetting/commands/TestTypesettingProject.zip', 'TestImage.jpg');

        $response = TypesettingUploadCommands::uploadFile($projectId, 'usfm-zip', $tmpFilePath);

        $this->assertFalse($response->result, 'Import should fail');
        $this->assertEqual('UserMessage', $response->data->errorType, 'Error response should be a user message');
        $this->assertPattern('/not an allowed compressed file/', $response->data->errorMessage, 'Error message should match the error');
    }

    public function testDeleteFile_pngFile_FileDeleted()
    {
        $project = $this->environ->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $fileName = 'TestImage.png';
        $filePath = $project->getAssetsFolderPath() . '/' . $fileName;
        $tmpFilePath = $this->environ->uploadFile(TestPath . "common/$fileName", $fileName);

        $response = TypesettingUploadCommands::uploadFile($projectId, 'png', $tmpFilePath);

        $this->assertTrue($response->result, 'Upload should succeed');
        $this->assertTrue(file_exists($filePath), 'Uploaded file should exist');

        $response = TypesettingUploadCommands::deleteFile($projectId, $fileName);

        $this->assertTrue($response->result, 'Delete should succeed');
        $this->assertFalse(file_exists($filePath), 'Uploaded file should be deleted');
    }

    public function testDeleteFile_zipFile_FileDeleted()
    {
        $project = $this->environ->createProject(SF_TESTPROJECT, SF_TESTPROJECTCODE);
        $projectId = $project->id->asString();
        $fileName = 'TestTypesettingProject.zip';
        $usfmFileName = '44JHNKJVT.SFM';
        $filePath = $project->getAssetsFolderPath() . '/' . $fileName;
        $tmpFilePath = $this->environ->uploadFile(TestPath . "scriptureforge/typesetting/commands/$fileName", $fileName);

        $response = TypesettingUploadCommands::uploadFile($projectId, 'usfm-zip', $tmpFilePath);

        $this->assertTrue($response->result, 'Upload should succeed');
        $this->assertTrue(file_exists($filePath), 'Uploaded file should exist');

        $response = TypesettingUploadCommands::deleteFile($projectId, $fileName);

        $this->assertTrue($response->result, 'Delete should succeed');
        $this->assertFalse(file_exists($filePath), 'Uploaded file should be deleted');
    }
}
