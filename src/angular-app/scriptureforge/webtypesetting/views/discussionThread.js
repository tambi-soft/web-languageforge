// controller for discussionThread
'use strict';

angular.module('webtypesetting.discussionThread', ['ui.bootstrap', 'bellows.services', 'ngAnimate', 'palaso.ui.notice', 'webtypesetting.discussionServices'])

.controller('discussionThreadCtrl', ['$scope', '$state', 'webtypesettingDiscussionService', 'sessionService', 'modalService', 'silNoticeService',
                                       function($scope, $state, discussionApi, sessionService, modal, notice) {

	
	// $scope.name = "Chris";
	
	/*$scope.isManager=function(){
		return true;
	};*/
	$scope.addReply = false;
	$scope.setVisibility = function() {
		$scope.addReply = !$scope.addReply;
	}
	
	var oneReply = {
		author: {
			name: "Nick",
			url: "url"
		},
		creationDate: "February 2, 2014",
		content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea wer commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
			
	};
	
	var twoReply = {
			author: {
				name: "David",
				url: "url"
			},
			creationDate: "February 3, 2014",
			content: "The second reply to this post!"
				
		};
		
	var onePost =  {
			author: {
				name: "Braker", 
				url: "http://profileUrl"
			},
			content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
			creationDate: "Thursday, January 2, 2014",
			status: "unresolved",
			tags: [],
			replies: [oneReply, twoReply],
			thumbnail: "http://www.petinfoclub.com/Images/Dark%20Med%20Spur-thighed%20tortoise%20shutterstock_81656770.jpg"
	};
	
	var twoPost = {
			author: {
				name: "Paige Brinks", 
				url: "http://profileUrl"
			},
			content: "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?",			
			creationDate: "Wednesday, January 19, 2014",
			status: "unresolved",
			tags: [],
			replies: [oneReply],
			thumbnail: "http://ecx.images-amazon.com/images/I/61ilzr59kbL.jpg"
	};

	// list of threads
	$scope.thread = 
	
	{
		title: "My first thread",
		status: {
			buttonText: "Closed",
			buttonColor:"warning",
		},
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
		id: "12345",
		posts: [onePost, twoPost]
	};
	
	
	
	
	var tag = {name: "important"};

	
	
}]);

