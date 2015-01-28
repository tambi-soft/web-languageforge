<?php
namespace models\scriptureforge\typesetting\commands;

use Palaso\Utilities\FileUtilities;
use models\scriptureforge\TypesettingProjectModel;
use models\shared\commands\ErrorResult;
use models\shared\commands\ImportResult;
use models\shared\commands\MediaResult;
use models\shared\commands\UploadResponse;
use models\ProjectModel;
use models\scriptureforge\typesetting\TypesettingAssetModel;

class TypesettingUploadCommands
{

    /**
     * Upload a file
     *
     * @param string $projectId
     * @param string $assetId
     * @param string $mediaType
     * @param string $tmpFilePath
     * @throws \Exception
     * @return \models\shared\commands\UploadResponse
     */
    public static function uploadFile($projectId, $assetId, $mediaType, $tmpFilePath)
    {
        if (! $tmpFilePath) {
            throw new \Exception("Upload controller did not move the uploaded file.");
        }

    	switch ($mediaType) {
    		case 'usfm':
    			$response = self::uploadUsfmFile($projectId, $mediaType, $tmpFilePath);
    			break;
    		case 'usfm-zip':
    			$response = self::importProjectZip($projectId, $mediaType, $tmpFilePath);
    			break;
    		case 'png':
    			$response = self::uploadPngFile($projectId, $mediaType, $tmpFilePath);
                break;
    		default:
    			throw new \Exception('Unknown media type in Typesetting file upload.');
    	}
	    if ($response->result){
	    	$project = new ProjectModel($projectId);
	    	$model = new TypesettingAssetModel($project, $assetId);
	    	$model->name = $response->data->fileName;
	    	$model->path = $response->data->path;
	    	$model->type = $mediaType;
	    	$model->uploaded = true;
	    	$model->write();
	    }
    	return $response;
    }

    /**
     * Upload an USFM file
     *
     * @param string $projectId
     * @param string $mediaType
     * @param string $tmpFilePath
     * @throws \Exception
     * @return \models\shared\commands\UploadResponse
     */
    public static function uploadUsfmFile($projectId, $mediaType, $tmpFilePath)
    {
    	$file = $_FILES['file'];
        $fileName = $file['name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($finfo, $tmpFilePath);
        finfo_close($finfo);

        $fileName = FileUtilities::replaceSpecialCharacters($fileName);

        $fileExt = (false === $pos = strrpos($fileName, '.')) ? '' : substr($fileName, $pos);

        $allowedTypes = array(
            "text/plain"
        );
        $allowedExtensions = array(
            ".sfm"
        );

        $response = new UploadResponse();
        if (in_array(strtolower($fileType), $allowedTypes) && in_array(strtolower($fileExt), $allowedExtensions)) {

            // make the folders if they don't exist
            $project = new ProjectModel($projectId);
            $projectSlug = $project->databaseName();
            $folderPath = $project->getAssetsFolderPath();;
            FileUtilities::createAllFolders($folderPath);

            // cleanup previous files of any allowed extension
            self::cleanupFiles($folderPath, '', $allowedExtensions);

            // move uploaded file from tmp location to assets
            $filePath = self::mediaFilePath($folderPath, '', $fileName);
            $moveOk = copy($tmpFilePath, $filePath);
            @unlink($tmpFilePath);

            // construct server response
            if ($moveOk && $tmpFilePath) {
            	$data = new MediaResult();
                $data->path = $folderPath;
                $data->fileName = $fileName;
                $response->result = true;
            } else {
                $data = new ErrorResult();
                $data->errorType = 'UserMessage';
                $data->errorMessage = "$fileName could not be saved to the right location. Contact your Site Administrator.";
                $response->result = false;
            }
        } else {
            $allowedExtensionsStr = implode(", ", $allowedExtensions);
            $data = new ErrorResult();
            $data->errorType = 'UserMessage';
            if (count($allowedExtensions) < 1) {
                $data->errorMessage = "$fileName is not an allowed USFM file. No USFM file formats are currently enabled, contact your Site Administrator.";
            } elseif (count($allowedExtensions) == 1) {
                $data->errorMessage = "$fileName is not an allowed USFM file. Ensure the file is a $allowedExtensionsStr.";
            } else {
                $data->errorMessage = "$fileName is not an allowed USFM file. Ensure the file is one of the following types: $allowedExtensionsStr.";
            }
            $response->result = false;
        }

        $response->data = $data;
        return $response;
    }

    /**
     * Upload a png file
     *
     * @param string $projectId
     * @param string $mediaType
     * @param string $tmpFilePath
     * @throws \Exception
     * @return \models\shared\commands\UploadResponse
     */
    public static function uploadPngFile($projectId, $mediaType, $tmpFilePath)
    {
    	$file = $_FILES['file'];
        $fileName = $file['name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($finfo, $tmpFilePath);
        finfo_close($finfo);

        $fileName = FileUtilities::replaceSpecialCharacters($fileName);

        $fileExt = (false === $pos = strrpos($fileName, '.')) ? '' : substr($fileName, $pos);

        $allowedTypes = array(
            "image/png"
        );
        $allowedExtensions = array(
            ".png"
        );

        $response = new UploadResponse();
        if (in_array(strtolower($fileType), $allowedTypes) && in_array(strtolower($fileExt), $allowedExtensions)) {

            // make the folders if they don't exist
            $project = new ProjectModel($projectId);
            $projectSlug = $project->databaseName();
            $folderPath = $project->getAssetsFolderPath();
            FileUtilities::createAllFolders($folderPath);

            // cleanup previous files of any allowed extension
            self::cleanupFiles($folderPath, '', $allowedExtensions);

            // move uploaded file from tmp location to assets
            $filePath = self::mediaFilePath($folderPath, '', $fileName);
            $moveOk = copy($tmpFilePath, $filePath);
            @unlink($tmpFilePath);

            // construct server response
            if ($moveOk && $tmpFilePath) {
            	$data = new MediaResult();
                $data->path = '/' . $project->getAssetsPath();
                $data->fileName = $fileName;
                $response->result = true;
            } else {
                $data = new ErrorResult();
                $data->errorType = 'UserMessage';
                $data->errorMessage = "$fileName could not be saved to the right location. Contact your Site Administrator.";
                $response->result = false;
            }
        } else {
            $allowedExtensionsStr = implode(", ", $allowedExtensions);
            $data = new ErrorResult();
            $data->errorType = 'UserMessage';
            if (count($allowedExtensions) < 1) {
                $data->errorMessage = "$fileName is not an allowed PNG file. No PNG file formats are currently enabled, contact your Site Administrator.";
            } elseif (count($allowedExtensions) == 1) {
                $data->errorMessage = "$fileName is not an allowed PNG file. Ensure the file is a $allowedExtensionsStr.";
            } else {
                $data->errorMessage = "$fileName is not an allowed PNG file. Ensure the file is one of the following types: $allowedExtensionsStr.";
            }
            $response->result = false;
        }

        $response->data = $data;
        return $response;
    }

    /**
     *
     * @param string $folderPath
     * @param string $fileNamePrefix
     * @param string $originalFileName
     * @return string
     */
    public static function mediaFilePath($folderPath, $fileNamePrefix, $originalFileName)
    {
        if (! $fileNamePrefix) {
            return $folderPath . '/' . $originalFileName;
        }
        return $folderPath . '/' . $fileNamePrefix . '_' . $originalFileName;
    }

    /**
     * cleanup (remove) previous files of any allowed extension for files with the given filename prefix in the given folder path
     *
     * @param string $folderPath
     * @param string $fileNamePrefix
     * @param array $allowedExtensions
     */
    public static function cleanupFiles($folderPath, $fileNamePrefix, $allowedExtensions)
    {
        $cleanupFiles = glob($folderPath . '/' . $fileNamePrefix . '*[' . implode(', ', $allowedExtensions) . ']');
        foreach ($cleanupFiles as $cleanupFile) {
            @unlink($cleanupFile);
        }
    }

    /**
     * Import a project zip file
     *
     * @param string $projectId
     * @param string $mediaType
     * @param string $tmpFilePath
     * @throws \Exception
     * @return \models\shared\commands\UploadResponse
     */
    public static function importProjectZip($projectId, $mediaType, $tmpFilePath)
    {
    	if ($mediaType != 'usfm-zip') {
    		throw new \Exception("Unsupported upload type.");
    	}
    	if (! $tmpFilePath) {
    		throw new \Exception("Upload controller did not move the uploaded file.");
    	}

    	$file = $_FILES['file'];
    	$fileName = $file['name'];

    	$finfo = finfo_open(FILEINFO_MIME_TYPE);
    	$fileType = finfo_file($finfo, $tmpFilePath);
    	finfo_close($finfo);

    	$fileName = FileUtilities::replaceSpecialCharacters($fileName);

    	$fileExt = (false === $pos = strrpos($fileName, '.')) ? '' : substr($fileName, $pos);

    	$allowedTypes = array(
    			"application/zip",
    			"application/octet-stream",
    			"application/x-7z-compressed"
    	);
    	$allowedExtensions = array(
    			".zip",
    			".zipx",
    			".7z"
    	);

    	$response = new UploadResponse();
    	if (in_array(strtolower($fileType), $allowedTypes) && in_array(strtolower($fileExt), $allowedExtensions)) {

    		// make the folders if they don't exist
    		$project = new TypesettingProjectModel($projectId);
    		$folderPath = $project->getAssetsFolderPath();
    		FileUtilities::createAllFolders($folderPath);

    		// move uploaded file from tmp location to assets
    		$filePath =  $folderPath . '/' . $fileName;
    		$moveOk = copy($tmpFilePath, $filePath);
    		@unlink($tmpFilePath);

    		// import zip
    		if ($moveOk) {
    			self::extractZip($filePath, $folderPath);

    			// TODO: import extracted USFM files into RaPuMa project


    			// construct server response
    			if ($moveOk) {
    				$data = new ImportResult();
    				$data->path = '/' . $project->getAssetsPath();
    				$data->fileName = $fileName;
    				$response->result = true;
    			} else {
    				$data = new ErrorResult();
    				$data->errorType = 'UserMessage';
    				$data->errorMessage = "$filename could not be saved to the right location. Contact your Site Administrator.";
    				$response->result = false;
    			}
    		} else {
    			$data = new ErrorResult();
    			$data->errorType = 'UserMessage';
    			$data->errorMessage = "$fileName could not be saved to the right location. Contact your Site Administrator.";
    			$response->result = false;
    		}
    	} else {
    		$allowedExtensionsStr = implode(", ", $allowedExtensions);
    		$data = new ErrorResult();
    		$data->errorType = 'UserMessage';
    		if (count($allowedExtensions) < 1) {
    			$data->errorMessage = "$fileName is not an allowed compressed file. No compressed file formats are currently enabled, contact your Site Administrator.";
    		} elseif (count($allowedExtensions) == 1) {
    			$data->errorMessage = "$fileName is not an allowed compressed file. Ensure the file is a $allowedExtensionsStr.";
    		} else {
    			$data->errorMessage = "$fileName is not an allowed compressed file. Ensure the file is one of the following types: $allowedExtensionsStr.";
    		}
    		$response->result = false;
    	}

    	$response->data = $data;
    	return $response;
    }

    /**
     * TODO: This is duplicated from models\languageforge\lexicon\LiftImport; move both into Palaso\Utilities\FileUtilities. IJH 2015-01
     *
     * @param string $zipFilePath
     * @param string $destDir
     * @throws \Exception
     */
    public static function extractZip($zipFilePath, $destDir) {
    	// Use absolute path for archive file
    	$realpathResult = realpath($zipFilePath);
    	if ($realpathResult) {
    		$zipFilePath = $realpathResult;
    	} else {
    		throw new \Exception("Error receiving uploaded file");
    	}
    	if (!file_exists($realpathResult)) {
    		throw new \Exception("Error file '$zipFilePath' does not exist.");
    	}

    	$basename = basename($zipFilePath);
    	$pathinfo = pathinfo($basename);
    	$extension_1 = isset($pathinfo['extension']) ? $pathinfo['extension'] : 'NOEXT';
    	// Handle .tar.gz, .tar.bz2, etc. by checking if there's another extension "inside" the first one
    	$basename_without_ext = $pathinfo['filename'];
    	$pathinfo = pathinfo($basename_without_ext);
    	$extension_2 = isset($pathinfo['extension']) ? $pathinfo['extension'] : 'NOEXT';
    	// $extension_2 will be 'tar' if the file was a .tar.gz, .tar.bz2, etc.
    	if ($extension_2 == "tar") {
    		// We don't handle tarball formats... yet.
    		throw new \Exception("Sorry, the ." . $extension_2 . "." . $extension_1 . " format isn't allowed");
    	}
    	switch ($extension_1) {
    		case "zip":
    			$cmd = 'unzip -o ' . escapeshellarg($zipFilePath) . " -d " . escapeshellarg($destDir);
    			break;
    		case "zipx":
    		case "7z":
    			$cmd = '7z x -y ' . escapeshellarg($zipFilePath) . " -o" . escapeshellarg($destDir);
    			break;
    		default:
    			throw new \Exception("Sorry, the ." . $extension_1 . " format isn't allowed");
    			break;
    	}

    	FileUtilities::createAllFolders($destDir);
    	$destFilesBeforeUnpacking = scandir($destDir);

    	// ensure non-roman filesnames are returned
    	$cmd = 'LANG="en_US.UTF-8" ' . $cmd;
    	$output = array();
    	$retcode = 0;
    	exec($cmd, $output, $retcode);
    	if ($retcode) {
    		if (($retcode != 1) || ($retcode == 1 && strstr(end($output), 'failed setting times/attribs') == false)) {
    			throw new \Exception("Uncompressing archive file failed: " . print_r($output, true));
    		}
    	}
    }

    public static function deleteFile($projectId, $fileName) {
    	$response = new UploadResponse();
    	$response->result = false;
    	$project = new TypesettingProjectModel($projectId);
    	$folderPath = $project->getAssetsFolderPath();
    	$filePath = $folderPath . '/' . $fileName;
    	if (file_exists($filePath) and ! is_dir($filePath)) {
    		if (@unlink($filePath)) {
    			$data = new MediaResult();
    			$data->path = '/' . $project->getAssetsPath();
    			$data->fileName = $fileName;
    			$response->data = $data;
    			$response->result = true;
    		} else {
    			$data = new ErrorResult();
    			$data->errorType = 'UserMessage';
    			$data->errorMessage = "$fileName could not be deleted. Contact your Site Administrator.";
    		}
    		$response->data = $data;
    		return $response;
    	}
    	$data = new ErrorResult();
    	$data->errorType = 'UserMessage';
    	$data->errorMessage = "$fileName does not exist in this project. Contact your Site Administrator.";
    	$response->data = $data;
    	return $response;
    }

}
