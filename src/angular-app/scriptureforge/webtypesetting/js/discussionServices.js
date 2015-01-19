'use strict';

angular.module('webtypesetting.discussionServices', ['jsonRpc'])
  .service('webtypesettingDiscussionService', ['jsonRpc',
  function(jsonRpc) {
    jsonRpc.connect('/api/sf');
    
    this.getPageDto = function getPageDto(callback) {
    	jsonRpc.call("webtypesetting_discussionList_getPageDto", [], callback);
    };
    
    this.createThread = function createThread(title, itemId, callback) {
    	jsonRpc.call("webtypesetting_discussionList_createThread", [title, itemId], callback);
    };
    
    this.deleteThread = function deleteThread(threadId, callback){
    	jsonRpc.call("webtypesetting_discussionList_deleteThread", [threadId], callback);
    };
    
    this.updateThread = function updateThread(threadId, title, callback){
    	jsonRpc.call("webtypesetting_discussionList_updateThread", [threadId, title], callback);
    };
    
    this.createPost = function createPost(threadId, post, callback){
    	jsonRpc.call("webtypesetting_discussionList_createPost", [threadId, post], callback);
    };
    
    this.deletePost = function deletePost(threadId, postId, callback){
    	jsonRpc.call("webtypesetting_discussionList_deletePost", [threadId, postId], callback);
    };
    
    this.updatePost = function updatePost(threadId, postId, content, callback){
    	jsonRpc.call("webtypesetting_discussionList_updatePost", [threadId, postId, content], callback);
    };
    
    this.createReply = function createReply(threadId, postId, reply, callback){
    	jsonRpc.call("webtypesetting_discussionList_createReply", [threadId, postId, reply], callback);
    };
    
    this.deleteReply = function deleteReply(threadId, postId, replyId, callback){
    	jsonRpc.call("webtypesetting_discussionList_deleteReply", [threadId, postId, replyId], callback);
    };
    
    this.updateReply = function updateReply(threadId, postId, replyId, content, callback){
    	jsonRpc.call("webtypesetting_discussionList_updateReply", [threadId, postId, replyId, content], callback);
    };
    
    this.updateStatus = function updateStatus(threadId, status, callback){
    	jsonRpc.call("webtypesetting_discussionList_updateStatus", [threadId, status], callback);
    };
  }])
  ;
  
