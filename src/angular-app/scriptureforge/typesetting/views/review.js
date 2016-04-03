'use strict';

angular.module('typesetting.review',
    [ 'jsonRpc', 'ui.bootstrap', 'bellows.services', 'ngAnimate',
        'typesetting.compositionServices',
        'typesetting.renderedPageServices',
        'composition.selection' ])

    .controller(
    'reviewCtrl',
    [
        '$scope',
        '$state',
        'typesettingSetupService',
        'typesettingCompositionService',
        'typesettingRenderedPageService',
        'sessionService',
        'modalService',
        'silNoticeService',
        function($scope, $state, typesettingSetupApi,compositionService, renderedPageService) {

            $scope.listOfBooks = [];
            var currentVerse;
//              for (var i = 0; i < 31; i++) {
//                $scope.pages.push("red");
//              }
            var initializeBook = function(){
                $scope.LoadingImg = "../../web/images/loading-icon.gif";
                $scope.LoadingText = "Loading";
                $scope.currentImage = "";
                $scope.currentImage = "";
                currentVerse = "";
                $scope.pages = [];
                $scope.selectedPage = 1;
            };

            var getPageStatus = function getPageStatus(){
                renderedPageService.getPageStatus($scope.bookID, function(result){
                    $scope.pages = result.data;
                });
            };
            var setPageStatus = function setPageStatus(){
                renderedPageService.setPageStatus($scope.bookID, $scope.pages, function(result){
                    //nothing todo?
                });
            };
            var getRenderedPageDto = function getRenderedPageDto(){
                initializeBook();
                compositionService.getPageDto(function getBookDto(result){
                   $scope.renderedBook= result.data.renderedBook;
                    $scope.comments = result.data.comments;
                    $scope.LoadingImg = null;
                    $scope.LoadingText = null;
                   if (!$scope.renderedBook ){
                        $scope.NoRender = true;
                   }
                });
            };

            $scope.decreasePage = function() {
                $scope.selectedPage = Math.max(1,
                    $scope.selectedPage - 1);
            };
            $scope.increasePage = function() {
                $scope.selectedPage = Math.min($scope.pages.length,
                    parseInt($scope.selectedPage) + 1);
            };


            $scope.updatePage = function() {
                $scope.selectedPage = $scope.pageInput;
            };
            $scope.save = function save() {
                setParagraphProperties();
                setIllustrationProperties();
                $scope.pages[$scope.selectedPage] = "orange";
                setPageStatus();
            };

            $scope.$watch('selectedPage', function() {
                $scope.selectedPage = parseInt($scope.selectedPage);
                if ($scope.selectedPage <= 0)
                    $scope.selectedPage = 1;
                if(!$scope.pages)return;
                if ($scope.selectedPage > $scope.pages.length)
                    $scope.selectedPage = $scope.pages.length;
                $scope.pageInput = $scope.selectedPage;

                    //getRenderedPage($scope.selectedPage);

            });

            getRenderedPageDto();

        }]);

