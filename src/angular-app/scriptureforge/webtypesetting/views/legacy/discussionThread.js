// controller for discussionThread
'use strict';

angular.module('webtypesetting.discussionThread', ['ui.bootstrap', 'bellows.services', 'ngAnimate', 'palaso.ui.notice', 'webtypesetting.discussionServices'])

.controller('discussionThreadCtrl', ['$scope', '$state', 'webtypesettingDiscussionService', 'sessionService', 'modalService', 'silNoticeService',
                                       function($scope, $state, discussionApi, sessionService, modal, notice) {

	
	$scope.threads = [];
	
	// $scope.name = "Chris";
	
	


	// list of threads
	$scope.threads = [
	
	{
		title: "My first thread",
		status: "unresolved",
		lastModified: "Monday, Dec 20th 2015",
		author: {
			name: "Chris Hirt", 
			url: "http://profileUrl"
		},
		item: {
				type: "Scripture Book",
				iconUrl: "url",
				url: "url",
				title: "The Book of Matthew"
		},
		id: "12345"
	},
	{
		title: "Why is the book of John Italicized?",
		status: "unresolved",
		lastModified: "Wednesday, Oct. 31 2013",
		author: {
			name: "Nick VanderKolk", 
			url: "http://profileUrl"
		},
		item: {
				type: "Scripture Book",
				iconUrl: "url",
				url: "url",
				title: "The Book of John"
		}, 
		id: "6789",
		posts: []
	}
	];
	
	var onePost = {
			author: {
				name: "chris", 
				url: "http://profileUrl"
			},
			content: "My first post!",
			creationDate: "when",
			status: "unresolved",
			tags: [],
			replies: []
	};
	
	var tag = {name: "important"};
	
	var reply = {
		author: {},
		creationDate: "",
		content: "my first reply to the post!"
			
	};
		
	
	
}]);

