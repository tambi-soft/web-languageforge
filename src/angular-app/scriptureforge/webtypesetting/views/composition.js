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
					var paragraphChanged=false;
					var paragraphProperties = {
							//c1v1: {growthfactor:3},
							};
					var illustrationProperties = {};
					$scope.selectedPage =1;
					$scope.bookID = 1;
					$scope.selectedText="";
					$scope.properties = "test";
					$scope.bookHTML = "";
					$scope.verse="";
					$scope.renderedImageLeft = "";
					$scope.renderedImageRight = "";
					$scope.renderRapuma = function() {
						compositionService.renderBook($scope.bookID, function(result) {
							
						});
					};
					$scope.getBookHTML = function getBookHTML() {
						compositionService.getBookHTML($scope.bookID, function(result) {
							$scope.bookHTML = result.data;
						});
					};
					$scope.getParagraphProperties = function getParagraphProperties() {
						compositionService.getParagraphProperties($scope.bookID, function(result) {
							paragraphProperties = result.data;
						});
					};
					$scope.setParagraphProperties = function setParagraphProperties() {
						compositionService.setParagraphProperties($scope.bookID, paragraphProperties, function(result) {
							// nothing todo?
						});
					};
					$scope.getIllustrationProperties = function getIllustrationProperties() {
						compositionService.getIllustrationProperties($scope.bookID, function(result) {
							illustrationProperties = result.data;
						});
					};
					$scope.setIllustrationProperties = function setIllustrationProperties() {
						compositionService.setIllustrationProperties($scope.bookID, illustrationProperties, function(result) {
							// nothing todo?
						});
					};
					$scope.getRenderedPageForBook = function getRenderedPageForBook(pageNum) {
						compositionService.getRenderedPageForBook($scope.bookID, pageNum, function(result) {
							if(pageNum==0 || pageNum>$scope.numPages)result.data="";
							if(pageNum%2==0)$scope.renderedImageLeft=result.data;
							else $scope.renderedImageRight=result.data;
						});
					};
					
					$scope.decreasePage = function(){
						$scope.selectedPage = Math.max(1, $scope.selectedPage -1);
					};
					$scope.increasePage = function(){
						//$scope.selectedPage = Math.min($scope.numPages, $scope.selectedPage + 1);
						$scope.selectedPage = Math.min($scope.numPages, parseInt($scope.selectedPage) + 1);
					};
					
					$scope.pages = ["green"];
					for(var i=0; i<20; i++){
						$scope.pages.push("red");
					}
					$scope.numPages = $scope.pages.length;
					$scope.$watch('selectedPage', function(){
						if($scope.selectedPage <= 0)$scope.selectedPage = 1;
						if($scope.selectedPage > $scope.numPages)$scope.selectedPage=$scope.numPages;
						$scope.pageInput = $scope.selectedPage;
						if($scope.selectedPage%2==0){
							$scope.getRenderedPageForBook($scope.selectedPage);
							$scope.getRenderedPageForBook($scope.selectedPage+1);
						} else{
							$scope.getRenderedPageForBook($scope.selectedPage-1);
							$scope.getRenderedPageForBook($scope.selectedPage);
						}
					});
					$scope.update = function(){
						$scope.selectedPage = $scope.pageInput;
					};
					$scope.save = function save(){
						$scope.setParagraphProperties();
						$scope.pages[$scope.selectedPage]="green";
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
						paragraphChanged = true;
					});
					$scope.$watch('paragraphGrowthFactor', function() {
						if(!currentVerse)return;
						if(paragraphProperties[currentVerse]){
							paragraphProperties[currentVerse].growthfactor = $scope.paragraphGrowthFactor;
							
						} else {
							paragraphProperties[currentVerse] = {growthfactor:$scope.paragraphGrowthFactor};
						}
						if(paragraphChanged)paragraphChanged=false;
						else $scope.pages[$scope.selectedPage] = "orange";
					});
					
					$scope.$watch('paragraphProperties', function(){
//						if($scope.pages[0]=="green")
//						else $scope.pages[0] = "green";
					});

					$scope.getParagraphProperties();
					$scope.getIllustrationProperties();
				} ]);
