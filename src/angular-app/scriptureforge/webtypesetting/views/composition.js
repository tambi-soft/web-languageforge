'use strict';

angular.module(
		'webtypesetting.composition',
		[ 'jsonRpc', 'ui.bootstrap', 'bellows.services', 'ngAnimate',
				'palaso.ui.notice', 'webtypesetting.compositionServices' ])

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
					$scope.bookID = 1;
					$scope.bookHTML = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean imperdiet semper luctus. Fusce feugiat urna orci, ut finibus metus eleifend a. Sed nibh quam, efficitur vitae lacus in, maximus malesuada elit. Nulla vulputate eget tellus nec tristique. Nulla blandit vitae arcu eu mollis. Integer ut mauris ut sem elementum fringilla ac ac diam. In non placerat arcu. Pellentesque eu mollis velit."+
						"Sed sed vestibulum felis, id posuere purus. Sed eget sodales ex, porta blandit ante. Cras vel velit nec nisl placerat eleifend a vel urna. Praesent in elementum neque, eget gravida enim. Donec eget quam sed eros ullamcorper pellentesque. Praesent tellus turpis, maximus et mi non, tristique condimentum enim. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Fusce feugiat sit amet felis eu ultrices."+
						"Mauris tincidunt purus augue, sit amet faucibus nisi aliquet et. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse tempus volutpat dictum. Maecenas ut consectetur lacus. Vivamus pharetra ante vel lorem hendrerit, a consectetur nisl interdum. Phasellus interdum nulla magna. Nulla sem elit, gravida quis lobortis quis, rhoncus ac enim.";
					$scope.renderRapuma = function() {
						compositionService.renderBook(function(result) {
							if (result.ok) {
								$scope.pdfUrl = result.data.pdfUrl;
							}
						});
					};
					$scope.getBookHTML = function getBookHTML() {
						compositionService.getBookHTML($scope.bookID, function(result) {
							$scope.bookHTML = result.data;
							
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
					};
					$scope.getBookHTML();
				} ]);
