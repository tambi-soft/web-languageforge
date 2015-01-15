'use strict';

angular.module(
		'webtypesetting.composition',
		[ 'jsonRpc', 'ui.bootstrap', 'bellows.services', 'ngAnimate', 'webtypesetting.compositionServices', 'composition.selection' ])

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
					
					var currentVerse;
					var paragraphProperties = {
							//c1v1: {growthfactor:3},
							};
					$scope.selectedPage = 1;
					$scope.bookID = 1;
					$scope.selectedText="";
					$scope.properties = "test";
					$scope.bookHTML = "";
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
					$scope.textClick = function textClick(){
						//$scope.selectedText = "clicked";
					};
					$scope.getBookHTML();
					$scope.$watch('paragraphNode', function(){
						if(!$scope.paragraphNode)return;
						$scope.selectedText = $scope.paragraphNode.innerHTML;
						currentVerse = $scope.paragraphNode.id;
						var temp = currentVerse.replace("c","").split("v");
						$scope.verse = temp[1];
						$scope.chapter = temp[0];
						var currentParagraphProperties = paragraphProperties[currentVerse];
						$scope.paragraphGrowthFactor =  (currentParagraphProperties)? currentParagraphProperties.growthfactor : 0;
					});
					$scope.$watch('paragraphGrowthFactor', function() {
						if(!currentVerse)return;
						if(paragraphProperties[currentVerse]){
							paragraphProperties[currentVerse].growthfactor = $scope.paragraphGrowthFactor;
						} else {
							paragraphProperties[currentVerse] = {growthfactor:$scope.paragraphGrowthFactor};
						}
					});
				} ]);
