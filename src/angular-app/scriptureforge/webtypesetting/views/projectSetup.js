'use strict';

angular.module('webtypesetting.projectSetup', ['jsonRpc', 'ui.bootstrap', 'bellows.services',  'ngAnimate', 'palaso.ui.notice', 'webtypesetting.services', 'angularFileUpload'])
.controller('projectSetupCtrl', ['$scope', '$state', 'webtypesettingSetupService',  'sessionService', 'modalService', 'silNoticeService'/*, 'breadcrumbService'*/,
                                 function($scope, $state, webtypesettingSetupApi, sessionService, modal, notice/*, breadcrumbService*/) {

	/*
	// Breadcrumb
	breadcrumbService.set('top',
			[
			 {href: '/setup', label: 'Setup Project'},
			 //{href: sfchecksLinkService.project(), label: $scope.project.name},
			]
	);
	*/

	$scope.sectionTitles = ['ParaTExt Texts',
	                        'Front & Back Matter',
	                        'Illustrations',
	                        'Fonts',
	                        'Cover / Maps'
	                        ];

	// For the buttons.
	$scope.newTextCollapsed = true;

	$scope.onUsxFile = function($files) {
		if (!$files || $files.length == 0) {
			return;
		}
		var file = $files[0];  // Use only first file
		var reader = new FileReader();
		reader.addEventListener("loadend", function() {
			// Basic sanity check: make sure what was uploaded is USX
			// First few characters should be optional BOM, optional <?xml ..., then <usx ...
			var startOfText = reader.result.slice(0,1000);
			var usxIndex = startOfText.indexOf('<usx');
			if (usxIndex != -1) {
				$scope.$apply(function() {
					$scope.content = reader.result;
				});
			} else {
				notice.push(notice.ERROR, "Error loading USX file. The file doesn't appear to be valid USX.");
				$scope.$apply(function() {
					$scope.content = '';
				});
			}
		});
		reader.readAsText(file);
	};
	
}])
.controller('templateCtrl', ['$scope', '$state', 'webtypesettingSetupService',  'sessionService', 'modalService', 'silNoticeService',
function($scope, $state, webtypesettingSetupApi, sessionService, modal, notice) {
    $scope.loadTemplateCollapsed = true;
    $scope.saveTemplateCollapsed = true;
    $scope.disableAddButton = true;
    $scope.saveTemplateName = "";
    $scope.loadTemplateName = "";
    
    $scope.uncollapseDivs = function(div){
      if (div ==="load"){
        if (!$scope.loadTemplateCollapsed){
          $scope.loadTemplateCollapsed = true;
        }else{
          $scope.loadTemplateCollapsed = false;
          $scope.saveTemplateCollapsed = true;
        }
      }
      if (div==="save"){
        if (!$scope.saveTemplateCollapsed){
          $scope.saveTemplateCollapsed = true;
        }else{
          $scope.saveTemplateCollapsed = false;
          $scope.loadTemplateCollapsed = true;
        }
      }
    };
    
    $scope.handleSaveClick = function() {
    	templateSaveObject.prepForBroadcast($scope.saveTemplateName);
    };
    
    $scope.handleLoadClick = function() {
    	templateLoadObject.prepForBroadcast($scope.loadTemplateName);
    };
	
	/*$scope.$on('handleSaveBroadcast', function() {
		
        //Functionality for collecting other controller data using the sharedService variable
    }); 
	
	$scope.$on('handleLoadBroadcast', function() {
		
        //Functionality for collecting other controller data using the sharedService variable
    });*/
    
}])
/*
.controller('settingsLayout', ['$scope', '$state', 'webtypesettingSetupService',  'sessionService', 'modalService', 'silNoticeService', 'templateSaveService', 'templateLoadService',
function($scope, $state, webtypesettingSetupApi, sessionService, modal, notice, templateSaveObject, templateLoadObject) {
	$scope.$on('handleSaveBroadcast', function() {
		
    }); 
	$scope.$on('handleLoadBroadcast', function() {
		
    });
}])

.controller('settingsAssets', ['$scope', '$state', 'webtypesettingSetupService',  'sessionService', 'modalService', 'silNoticeService', 'templateSaveService', 'templateLoadService',
function($scope, $state, webtypesettingSetupApi, sessionService, modal, notice, templateSaveObject, templateLoadObject) {
	$scope.$on('handleSaveBroadcast', function() {
		
    }); 
	$scope.$on('handleLoadBroadcast', function() {
		
    }); 
}]);*/




