'use strict';

angular.module('webtypesetting', 
		[
		 'ui.router',
         'webtypesetting.projectSetup',
		 'webtypesetting.composition',
         'webtypesetting.projectSetupLayout',
		 'webtypesetting.services'
		])
	.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
		
		$urlRouterProvider.otherwise('/');
		
	    $stateProvider
	    	.state('home', {
	    		url: '/',
	    		templateUrl: '/angular-app/scriptureforge/webtypesetting/views/home.html'
	    	})
		    .state('projectSetup', {
		        url: '/setup',
		        templateUrl: '/angular-app/scriptureforge/webtypesetting/views/projectSetup.html'
		    })
	    	.state('projectSetup.assets', {
	    		url: '/assets',
	    		templateUrl: '/angular-app/scriptureforge/webtypesetting/views/projectSetup.assets.html'
	    	})
	    	.state('projectSetup.layout', {
	    		url: '/layout',
	    		templateUrl: '/angular-app/scriptureforge/webtypesetting/views/projectSetup.layout.html'
	    	})
	    	.state('composition', {
		        url: '/composition',
		        views: {
		        	'': {templateUrl: '/angular-app/scriptureforge/webtypesetting/views/composition.html',
		        		controller: 'compositionCtrl'}
		        }
		    });
	    	
		    
	    
	}])
	.controller('MainCtrl', ['$scope', function($scope) {
		$scope.selectedBtn = 0;
	}])
	;
