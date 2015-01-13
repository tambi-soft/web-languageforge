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
				'webtypesettingEditService',
				'sessionService',
				'modalService',
				'silNoticeService',
				function($scope, $state, webtypesettingSetupApi,
						webtypesettingEditService, sessionService, modal,
						notice) {

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
					
					$scope.pages = ["red", "green", "yellow"];
					for(var i=0; i<200; i++){
						$scope.pages.push((i%2==0)?'green':'red');
					}
					$scope.numPages = $scope.pages.length;
					$scope.$watch('selectedPage', function(){
						//if($scope.selectedPage == 0)$scope.selectedPage = 1;
					});
				} ]);
