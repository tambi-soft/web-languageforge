'use strict';

angular.module('typesetting',
    [
          'ui.router',
          'bellows.filters',
          'typesetting.composition',
          'typesetting.discussionList',
          'typesetting.discussionThread',
          'typesetting.services',
          'typesetting.projectSetupLayout',
          'typesetting.projectSetupAssets',
          'typesetting.renderList',
    ])
  .run(['$rootScope', '$state', '$stateParams', function($rootScope,   $state,   $stateParams) {
    // Add $state and $stateParams to the $rootScope so that we can access them from any scope.
    // <li ng-class="{ active: $state.includes('contacts.list') }"> will set the <li>
    // to active whenever 'contacts.list' or one of its decendents is active.
    $rootScope.$state = $state;
    $rootScope.$stateParams = $stateParams;
  },])
  .config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise('/');

    $stateProvider
        .state('home', {
          url: '/',
          templateUrl: '/angular-app/scriptureforge/typesetting/views/home.html',
        })
        .state('projectSetupAssets', {
          url: '/assets',
          templateUrl: '/angular-app/scriptureforge/typesetting/views/projectSetup.assets.html',
        })
        .state('projectSetupLayout', {
          url: '/layout',
          templateUrl: '/angular-app/scriptureforge/typesetting/views/projectSetup.layout.html',
        })
        .state('composition', {
          url: '/composition',
          templateUrl: '/angular-app/scriptureforge/typesetting/views/composition.html',
        })
        .state('discussion', {
          url: '/discussion',
          templateUrl: '/angular-app/scriptureforge/typesetting/views/discussionList.html',
        })
        .state('render', {
          url: '/render',
          templateUrl: '/angular-app/scriptureforge/typesetting/views/renderList.html',
        })
        .state('discussionThreadView', {
          url: '/discussion/:threadId',
          templateUrl: '/angular-app/scriptureforge/typesetting/views/discussionThread.html',
        });

  },])
  .controller('MainCtrl', ['$scope', function($scope) {
    $scope.selectedBtn = 0;

    // accessed by discussionListCtrl and discussionThreadCtrl
    $scope.discussion = {
      currentThreadIndex: -1,
      threads: [],
    };

    $scope.settingsButton = {
      isopen: false,
    };

  },]);
