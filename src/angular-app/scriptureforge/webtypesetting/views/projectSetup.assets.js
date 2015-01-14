// controller for setupProjectAssets
'use strict';

angular.module('webtypesetting.projectSetupAssets', ['jsonRpc', 'ui.bootstrap', 'bellows.services', 'ngAnimate', 'palaso.ui.notice', 'webtypesetting.services', 'angularFileUpload'])
.controller('projectSetupAssetsCtrl', ['$scope', '$state', '$upload', 'webtypesettingSetupService', 'sessionService', 'modalService', 'silNoticeService'/*, 'breadcrumbService'*/,
                                       function($scope, $state, $upload, webtypesettingSetupApi, sessionService, modal, notice/*, breadcrumbService*/) {

      	$scope.sectionTitles = ['ParaTExt Texts'];/*,
      	                        'Front & Back Matter',
      	                        'Illustrations',
      	                        'Fonts',
      	                        'Cover / Maps'
      	                        ];
      	                        */

      	$scope.paratexts = [];
      	
      	$scope.deleteFile = function deleteFile(index){
      		$scope.paratexts.splice(index, 1);
      		$scope.uploadResult = "File deleted sucessfully.";
              notice.push(notice.SUCCESS, $scope.uploadResult);
      	};

      	// For the buttons.
      	$scope.newTextCollapsed = true;

          $scope.onPdfFile = function($files) {
              
              // take the first file only
              var file = $files[0];
              $scope.file = file;
              if (file['size'] <= sessionService.fileSizeMax()) {
                $upload.upload({
                  
                  // upload.php script
                  url: '/upload/sf-typesetting/pdf',
                  // headers: {'myHeaderKey': 'myHeaderVal'},
                  data: {
                    textId: ''
                  },
                  file: file
                }).progress(function(evt) {
                  $scope.progress = parseInt(100.0 * evt.loaded / evt.total);
                }).success(function(data, status, headers, config) {
              	  console.log(data);
                  if (data.result) {
                    $scope.progress = 100.0;
                    $scope.uploadResult = 'File uploaded successfully.';
                    notice.push(notice.SUCCESS, $scope.uploadResult);
                    $scope.paratexts.push(data.data);

                  } else {
                    $scope.progress = 0;
                    notice.push(notice.ERROR, data.data.errorMessage);
                    if (data.data.errorType == 'UserMessage') {
                      $scope.uploadResult = data.data.errorMessage;
                    }
                  }
                  $scope.file = null;
                });
              } else {
                $scope.progress = 0;
                $scope.file = null;
                $scope.uploadResult = file['name'] + " is too large.";
              }
            };	
      	// Add Text
      	$scope.addText = function() {
//      		console.log("addText()");
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
