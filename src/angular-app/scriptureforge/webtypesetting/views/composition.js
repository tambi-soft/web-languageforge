'use strict';

angular.module(
		'webtypesetting.composition',
		[ 'jsonRpc', 'ui.bootstrap', 'bellows.services', 'ngAnimate',
				'palaso.ui.notice', 'webtypesetting.services' ])

.controller(
		'compositionCtrl',
		[
				'$scope',
				'$state',
				'webtypesettingSetupService',
				'webtypesettingCompositionService',
				'sessionService',
				'modalService',
				'silNoticeService',
				function($scope, $state, webtypesettingSetupApi,
						compositionService, sessionService, modal,
						notice) {
					
					$scope.paragraphProperties = {
							c1v1: {growthfactor:0},
							c2v1: {growthfactor:1},
							c3v1: {growthfactor:0},
							c4v1: {growthfactor:3},
							};

					$scope.selectedPage = 1;
					//$scope.numPages = 170;
					$scope.pdfUrl = "test";
					$scope.renderRapuma = function() {
						webtypesettingEditService.render(function(result) {
							if (result.ok) {
								$scope.pdfUrl = result.data.pdfUrl;
							}
						});

					};
					$scope.decreasePage = function(){
						$scope.selectedPage = Math.max(1, $scope.selectedPage -1);
					};
					$scope.increasePage = function(){
						//$scope.selectedPage = Math.min($scope.numPages, $scope.selectedPage + 1);
						$scope.selectedPage = Math.min($scope.numPages, parseInt($scope.selectedPage) + 1);
					};
					
					$scope.pages = ["green", "green", "green"];
					for(var i=0; i<20; i++){
						if(i<10)$scope.pages.push("yellow");
						else $scope.pages.push("red");
					}
					$scope.numPages = $scope.pages.length;
					$scope.$watch('selectedPage', function(){
						if($scope.selectedPage <= 0)$scope.selectedPage = 1;
						if($scope.selectedPage > $scope.numPages)$scope.selectedPage=$scope.numPages;
						$scope.pageInput = $scope.selectedPage;
					});
					$scope.update = function(){
						$scope.selectedPage = $scope.pageInput;
					}
				} ]);
