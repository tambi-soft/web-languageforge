'use strict';

angular.module('webtypesetting', 
		[
		 'ui.router',
		 'webtypesetting.projectSetup',
		 'webtypesetting.services'
		])
	.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
		
		$urlRouterProvider.otherwise('/setup');
		
	    $stateProvider        
		    .state('setupProject', {
		        url: '/setup',
		        views: {
		        	'': {templateUrl: '/angular-app/scriptureforge/webtypesetting/views/projectSetup.html',
		        		controller: 'projectSetupCtrl'}
		        }
		    });
	    
	}])
	.controller('MainCtrl', ['$scope', function($scope) {
	}])
	;
