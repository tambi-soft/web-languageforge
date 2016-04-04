'use strict';

angular.module('typesetting.review',
    [ 'jsonRpc', 'ui.bootstrap', 'bellows.services', 'ngAnimate',
        'typesetting.compositionServices',
        'typesetting.renderedPageServices',
        'typesetting.discussionServices',
        'composition.selection' ])

    .controller(
    'reviewCtrl',
    [
        '$scope',
        '$state',
        'typesettingSetupService',
        'typesettingCompositionService',
        'typesettingRenderedPageService',
        'typesettingDiscussionService',
        'sessionService',
        'modalService',
        'silNoticeService',
        function($scope, $state, typesettingSetupApi,compositionService, renderedPageService,discussionService) {

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
                $scope.discussion = [];
                $scope.thread = [];
                $scope.threadId = 0;
                $scope.discussion.currentThreadIndex = 0;
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


            //commenting stuff


            // path is "/discussion/:threadId"

           // is currentThreadIndex initialised?
            if ($scope.discussion == null) {
                $scope.discussion = [];
                 discussionService.getPageDto(function(result) {
                     if (result.data == null){
                         discussionService.createThread($scope.projectName, 1, function(result) {
                             $scope.threadId = result.data;
                         });
                     }
                     else {
                         $scope.discussion.threads = result.data.threads;
                         for (var i = 0; i < $scope.discussion.threads.length; i++) {
                             if ($scope.discussion.threads[i].id === $scope.threadId) {
                                 $scope.discussion.currentThreadIndex = i;
                                 break;
                             }
                         }

                         // thread not found in threads list?
                         if ($scope.discussion.currentThreadIndex < 0) {
                             $state.go('discussion');
                         } else {
                             $scope.thread = $scope.discussion.threads[$scope.discussion.currentThreadIndex];
                         }
                     }
                 });
             } else {
                 $scope.thread = $scope.discussion.threads[$scope.discussion.currentThreadIndex];
             }

            function getPageDto() {
                discussionService.getPageDto(function(result) {
                    if (result.data == null){
                        discussionService.createThread($scope.projectName, 1, function(result) {
                            $scope.threadId= result.data;
                        });
                    }
                    if (result.data.threads[0].id != null) {
                        $scope.threadId= result.data.threads[0].id;
                    }
                    $scope.discussion.threads = result.data.threads;

                    if ($scope.discussion.threads != null) {
                        $scope.thread = $scope.discussion.threads[0];
                    }
                });
            }

            $scope.currentPost = "";

            $scope.changeTitle = function changeTitle() {
                if ($scope.isManager()) {
                    var title = prompt("Please enter a new thread name.", $scope.thread.title);
                    if (title != null && title.trim() != "") {
                        discussionService.updateThread($scope.thread.id, title, function(result) {
                            getPageDto();
                            notice.push(notice.SUCCESS, "Title updated.");
                        });
                    }
                }
            };

            $scope.saveEdit = function saveEdit(post) {
                discussionService.updatePost($scope.thread.id, post.id, post.content, function(result) {
                    getPageDto();
                    notice.push(notice.SUCCESS, "Post updated.");
                });
            };

            $scope.deletePost = function deletePost(post) {
                var confirmBool = confirm("Are you sure you want to delete this post?");
                if (confirmBool) {
                    discussionService.deletePost($scope.thread.id, post.id, function(result) {
                        getPageDto();
                        notice.push(notice.SUCCESS, "Post deleted.");
                    });
                }
            };
            $scope.deleteReply = function deleteReply(post, reply) {
                var confirmBool = confirm("Are you sure you want to delete this reply?");
                if (confirmBool) {
                    discussionService.deleteReply($scope.thread.id, post.id, reply.id, function(result) {
                        getPageDto();
                        notice.push(notice.SUCCESS, "Reply deleted.");
                    });
                }
            };
            $scope.createReply = function createReply(post, newReplyContent) {
                discussionService.createReply($scope.thread.id, post.id, newReplyContent, function(result) {
                    newReplyContent = "";
                    getPageDto();
                    notice.push(notice.SUCCESS, "Reply successful.");
                });
            };

            $scope.createPost = function createPost() {
                discussionService.createPost($scope.thread.id, $scope.newPostContent, function(result) {
                    $scope.newPostContent = "";
                    getPageDto();
                    notice.push(notice.SUCCESS, "Post successful.");
                });
            };

            $scope.changeStatus = function changeStatus() {
                if ($scope.isManager()) {
                    alert("Change Status");
                }
                // TODO: Change status
            };

            $scope.isManager = function() {
                return true;
            };
            getRenderedPageDto();
            getPageDto();


        }]);

