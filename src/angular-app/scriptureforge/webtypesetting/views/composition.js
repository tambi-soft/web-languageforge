'use strict';

angular.module('webtypesetting.composition',
				[ 'jsonRpc', 'ui.bootstrap', 'bellows.services', 'ngAnimate',
						'webtypesetting.compositionServices',
						'composition.selection' ])

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
							var currentVerse = "";
							var paragraphProperties = {
							// c1v1: {growthfactor:3},
							};
							var illustrationProperties = {};
							var bookID = 1;
							$scope.selectedPage = 1;
							$scope.currentImage = "";
							$scope.bookHTML = "";
							$scope.verse = "";
							$scope.renderedImageLeft = "";
							$scope.renderedImageRight = "";
							$scope.pages = [ "green" ];
							for (var i = 0; i < 21; i++) {
								$scope.pages.push("red");
							}
							$scope.numPages = $scope.pages.length;
							
							
							$scope.renderRapuma = function() {
								compositionService.renderBook(bookID,
										function(result) {
											//nothing todo?
										});
							};
							var getBookHTML = function getBookHTML() {
								compositionService.getBookHTML(bookID,
										function(result) {
											$scope.bookHTML = result.data;
										});
							};
							var getParagraphProperties = function getParagraphProperties() {
								compositionService.getParagraphProperties(bookID, function(result) {
									paragraphProperties = result.data;
								});
							};
							var setParagraphProperties = function setParagraphProperties() {
								compositionService.setParagraphProperties(
										bookID, paragraphProperties,
										function(result) {
											// nothing todo?
										});
							};
							var getIllustrationProperties = function getIllustrationProperties() {
								compositionService.getIllustrationProperties(bookID,function(result) {
									illustrationProperties = result.data;
								});
							};
							var setIllustrationProperties = function setIllustrationProperties() {
								compositionService.setIllustrationProperties(
										bookID, illustrationProperties,
										function(result) {
											// nothing todo?
										});
							};
							var getRenderedPageForBook = function getRenderedPageForBook(
									pageNum) {
								compositionService.getRenderedPageForBook(
										bookID,
										pageNum,
										function(result) {
											if (pageNum == 0 || pageNum > $scope.numPages)
												result.data = "";
											if (pageNum % 2 == 0)
												$scope.renderedImageLeft = result.data;
											else
												$scope.renderedImageRight = result.data;
										});
							};

							$scope.decreasePage = function() {
								$scope.selectedPage = Math.max(1,
										$scope.selectedPage - 1);
							};
							$scope.increasePage = function() {
								$scope.selectedPage = Math.min($scope.numPages,
										parseInt($scope.selectedPage) + 1);
							};
							$scope.updatePage = function() {
								$scope.selectedPage = $scope.pageInput;
							};
							$scope.save = function save() {
								setParagraphProperties();
								setIllustrationProperties();
								$scope.pages[$scope.selectedPage] = "green";
							};
							$scope.illustrationSave = function illustrationChange() {
								illustrationProperties[$scope.currentImage].Location = $scope.location;
								illustrationProperties[$scope.currentImage].width = $scope.width;
								illustrationProperties[$scope.currentImage].scale = $scope.scale;
								illustrationProperties[$scope.currentImage].caption = $scope.caption;
								illustrationProperties[$scope.currentImage].useCaption = $scope.useCaption;
								illustrationProperties[$scope.currentImage].useIllustration = $scope.illustration;
							};
							var illustrationClicked = function() {
								$scope.verse = "";
								$scope.currentImage = $scope.paragraphNode.id.split("-")[1];
								$scope.location = illustrationProperties[$scope.currentImage].location;
								$scope.imageWidth = parseInt(illustrationProperties[$scope.currentImage].width);
								$scope.scale = illustrationProperties[$scope.currentImage].scale;
								$scope.caption = illustrationProperties[$scope.currentImage].caption;
								$scope.useCaption = illustrationProperties[$scope.currentImage].useCaption=="true";
								$scope.useIllustration = illustrationProperties[$scope.currentImage].useIllustration=="true";
							};
							$scope.changeGrowth = function changeGrowth(){
								$scope.pages[$scope.selectedPage] = "orange";
							};
							
							
							$scope.$watch('selectedPage', function() {
								$scope.selectedPage = parseInt($scope.selectedPage);
								if ($scope.selectedPage <= 0)
									$scope.selectedPage = 1;
								if ($scope.selectedPage > $scope.numPages)
									$scope.selectedPage = $scope.numPages;
								$scope.pageInput = $scope.selectedPage;
								if ($scope.selectedPage % 2 == 0) {
									getRenderedPageForBook($scope.selectedPage);
									getRenderedPageForBook($scope.selectedPage + 1);
								} else {
									getRenderedPageForBook($scope.selectedPage - 1);
									getRenderedPageForBook($scope.selectedPage);
								}
							});
							$scope.$watch('paragraphNode',function() {
								if (!$scope.paragraphNode)
									return;
								if ($scope.paragraphNode.className == "illustration-placeholder")
									illustrationClicked();
								else {
									$scope.currentImage='';
									currentVerse = $scope.paragraphNode.id;
									var temp = currentVerse.replace("c", "").split("v");
									$scope.verse = temp[1];
									$scope.chapter = temp[0];
									var currentParagraphProperties = paragraphProperties[currentVerse];
									$scope.paragraphGrowthFactor = (currentParagraphProperties) ? currentParagraphProperties.growthfactor
											: 0;
								}
							});
							$scope.$watch('paragraphGrowthFactor',function() {
								if (!currentVerse)
									return;
								if (paragraphProperties[currentVerse]) {
									paragraphProperties[currentVerse].growthfactor = $scope.paragraphGrowthFactor;
									
								} else {
									paragraphProperties[currentVerse] = {
											growthfactor : $scope.paragraphGrowthFactor
									};
								}
							});
							
							
							getBookHTML();
							getIllustrationProperties();
							getParagraphProperties();
						} ]);
