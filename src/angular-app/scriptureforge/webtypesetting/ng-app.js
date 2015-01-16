'use strict';

angular.module('webtypesetting', 
		[
		 'ui.router',
		 'webtypesetting.projectSetup',
		 'bellows.filters',
		 'webtypesetting.composition',
		 'webtypesetting.discussionList',
		 'webtypesetting.services',
		 'webtypesetting.projectSetupLayout',
		 'webtypesetting.projectSetupAssets'
		])
	.run(['$rootScope', '$state', '$stateParams', function ($rootScope,   $state,   $stateParams) {
	    // Add $state and $stateParams to the $rootScope so that we can access them from any scope.
	    // <li ng-class="{ active: $state.includes('contacts.list') }"> will set the <li>
	    // to active whenever 'contacts.list' or one of its decendents is active.
	    $rootScope.$state = $state;
	    $rootScope.$stateParams = $stateParams;
	    }
	  ]
	)
	.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
		
		$urlRouterProvider.otherwise('/');
		
	    $stateProvider
	    	.state('home', {
	    		url: '/',
	    		templateUrl: '/angular-app/scriptureforge/webtypesetting/views/home.html'
	    	})
//		    .state('projectSetup', {
//		        url: '/setup',
//		        templateUrl: '/angular-app/scriptureforge/webtypesetting/views/projectSetup.html'
//		    })
	    	.state('projectSetupAssets', {
	    		url: '/assets',
	    		templateUrl: '/angular-app/scriptureforge/webtypesetting/views/projectSetup.assets.html'
	    	})
	    	.state('projectSetupLayout', {
	    		url: '/layout',
	    		templateUrl: '/angular-app/scriptureforge/webtypesetting/views/projectSetup.layout.html'
	    	})
//	    	.state('composition', {
//		        url: '/composition',
//		        views: {
//		        	'': {templateUrl: '/angular-app/scriptureforge/webtypesetting/views/composition.html',
//		        		controller: 'compositionCtrl'}
//		        }
//		    })
	    	.state('composition', {
		        url: '/composition',
		        templateUrl: '/angular-app/scriptureforge/webtypesetting/views/composition.html'
		    })
	    	.state('discussion', {
	    		url: '/discussion',
	    		templateUrl: '/angular-app/scriptureforge/webtypesetting/views/discussionList.html'
	    	})
	    	.state('discussionThreadView', {
	    		url: '/discussion/:threadId',
	    		templateUrl: '/angular-app/scriptureforge/webtypesetting/views/discussionThread.html'
	    	})
	    	.state('render', {
	    		url: '/render',
	    		templateUrl: '/angular-app/scriptureforge/webtypesetting/views/renderList.html'
	    	})
		    ;
	    	
		    
	    
	}])
	.controller('MainCtrl', ['$scope', function($scope) {
		$scope.selectedBtn = 0;
		
        $scope.settingsButton = {
            isopen: false
        };

	}])
	;
