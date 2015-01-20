//controller for setupProjectAssets
'use strict';

angular.module('webtypesetting.projectSetupAssets', ['jsonRpc', 'ui.bootstrap', 'bellows.services', 'ngAnimate', 'palaso.ui.notice', 'webtypesetting.services', 'angularFileUpload'])
.controller('projectSetupAssetsCtrl', ['$scope', '$state', '$upload', 'webtypesettingSetupService', 'sessionService', 'modalService', 'silNoticeService'/*, 'breadcrumbService'*/,
                                       function($scope, $state, $upload, webtypesettingSetupApi, sessionService, modal, notice/*, breadcrumbService*/) {

	$scope.sections = [{'title':'ParaTExt Texts',
				     	'fileType':'usfm-zip',
				     	'assets':[]},
				       {'title':'Illustrations',
				     	'fileType':'png',
				     	'assets':[]},
				     /*{'title':'Cover / Maps',
				     	'fileType':'png',
				     	'assets':[]},
				       {'title':'Fonts',
				     	'fileType':'ttf',
				     	'assets':[]},
				       {'title':'Front & Back Matter',
				     	'fileType':'pdf',
				     	'assets':[]},*/
                      ];

	$scope.deleteFile = function deleteFile(assets, index){
		assets.splice(index, 1);
		$scope.uploadResult = "File deleted sucessfully.";
		notice.push(notice.SUCCESS, $scope.uploadResult);
	};

	// For the buttons.
	$scope.newTextCollapsed = true;
	
	/* This is necessary to properly bind the uploaded file to the input element to submit it */
	$scope.callUploadClickEvent = function(elementId) {
		document.getElementById(elementId).click();
	};

	$scope.onFileSelect = function($files, section) {

		// take the first file only
		var file = $files[0];
		section.tempFile = file; // This is to display the name of the file temporarily during upload
		if (file.size <= sessionService.fileSizeMax()) {
			$upload.upload({

				// upload.php script
				url: '/upload/sf-typesetting/' + section.fileType,
				// headers: {'myHeaderKey': 'myHeaderVal'},
				data: {
					filename: file.name,
					textId: ''
				},
				file: file
			}).progress(function(evt) {
				$scope.progress = parseInt(100.0 * evt.loaded / evt.total);
			}).success(function(data, status, headers, config) {
				if (data.result) {
					$scope.progress = 100.0;
					$scope.uploadResult = 'File uploaded successfully.';
					notice.push(notice.SUCCESS, $scope.uploadResult);
					section.assets.push(file);
				} else {
					$scope.progress = 0;
					notice.push(notice.ERROR, data.data.errorMessage);
					if (data.data.errorType == 'UserMessage') {
						$scope.uploadResult = data.data.errorMessage;
					}
				}
				section.tempFile = null;
			});
		} else {
			$scope.progress = 0;
			section.tempFile = null;
			$scope.uploadResult = file.name + " is too large.";
		}
	};

	// Add Text
	$scope.addText = function() {
		var model = {};
		model.id = '';
		model.title = $scope.title;
		model.content = $scope.content;
		/*
      		textService.update(model, function(result) {
      			if (result.ok) {
      				notice.push(notice.SUCCESS, "The text '" + model.title + "' was added successfully");
      			}
      			$scope.getPageDto();
      		});
		 */
	};
}]);
