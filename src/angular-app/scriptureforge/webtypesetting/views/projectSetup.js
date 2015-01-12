'use strict';

angular.module(
		'webtypesetting.projectSetup',
		[ 'jsonRpc', 'ui.bootstrap', 'bellows.services', 'ngAnimate',
				'palaso.ui.notice', 'webtypesetting.services' ])

.controller(
		'projectSetupCtrl',
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

					$scope.selectedRange = 1;
					$scope.numPages = 170;
					$scope.pdfUrl = "test";
					$scope.renderRapuma = function() {
						webtypesettingEditService.render(function(result) {
							if (result.ok) {
								$scope.pdfUrl = result.data.pdfUrl;
							}
						});

					};
					$scope.decreasePage = function(){
						$scope.selectedRange = Math.max(1, $scope.selectedRange -1);
					};
					$scope.increasePage = function(){
						//$scope.selectedRange = Math.min($scope.numPages, $scope.selectedRange + 1);
						$scope.selectedRange = Math.min($scope.numPages, parseInt($scope.selectedRange) + 1);
					};
				} ]);
