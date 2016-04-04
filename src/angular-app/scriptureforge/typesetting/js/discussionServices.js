'use strict';

angular.module('typesetting.discussionServices', ['jsonRpc']).service('typesettingDiscussionService', ['jsonRpc', function(jsonRpc) {
  jsonRpc.connect('/api/sf');

  this.getPageDto = function getPageDto(callback) {
    jsonRpc.call('typesetting_discussionList_getPageDto', [], callback);
  };

  this.createThread = function createThread(title, itemId, callback) {
    jsonRpc.call('typesetting_discussionList_createThread', [title, itemId], callback);
  };

  this.deleteThread = function deleteThread(threadId, callback) {
    jsonRpc.call('typesetting_discussionList_deleteThread', [threadId], callback);
  };

  this.updateThread = function updateThread(threadId, title, callback) {
    jsonRpc.call('typesetting_discussionList_updateThread', [threadId, title], callback);
  };

  this.createPost = function createPost(threadId, postContent, callback) {
    jsonRpc.call('typesetting_discussionList_createPost', [threadId, postContent], callback);
  };

  this.deletePost = function deletePost(threadId, postId, callback) {
    jsonRpc.call('typesetting_discussionList_deletePost', [threadId, postId], callback);
  };

  this.updatePost = function updatePost(threadId, postId, content, callback) {
    jsonRpc.call('typesetting_discussionList_updatePost', [threadId, postId, content], callback);
  };

  this.createReply = function createReply(threadId, postId, reply, callback) {
    jsonRpc.call('typesetting_discussionList_createReply', [threadId, postId, reply], callback);
  };

  this.deleteReply = function deleteReply(threadId, postId, replyId, callback) {
    jsonRpc.call('typesetting_discussionList_deleteReply', [threadId, postId, replyId], callback);
  };

  this.updateReply = function updateReply(threadId, postId, replyId, content, callback) {
    jsonRpc.call('typesetting_discussionList_updateReply', [threadId, postId, replyId, content], callback);
  };

  this.updateStatus = function updateStatus(threadId, status, callback) {
    jsonRpc.call('typesetting_discussionList_updateStatus', [threadId, status], callback);
  };

  this.getThread = function getThread(threadId, callback) {
    jsonRpc.call('typesetting_discussionList_getThread', [threadId], callback);
  };

}]);
