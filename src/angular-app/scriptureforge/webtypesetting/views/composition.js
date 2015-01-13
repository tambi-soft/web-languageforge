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
					$scope.sliderRanges = [{
						'length':10,
						'color':'red'
					},{
						'length':20,
						'color':'green'
					},{
						'length':40,
						'color':'yellow'
					},{
						'length': 100,
						'color':'red'
					}
					               
					];
					
					$scope.pages = ["red", "green", "yellow"];
//					for(var i=0; i<1; i++){
//						$scope.pages.push((i%2==0)?'green':'red');
//					}
//					$scope.pages.push("green");
//					$scope.$apply();
					$scope.numPages = $scope.pages.length; 
				} ]);
