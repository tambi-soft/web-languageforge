'use strict';

angular.module('typesetting',
    [
          'ui.router',
          'bellows.filters',
          'typesetting.typeset',
          'typesetting.review',
          'typesetting.projectSetupAssets',
          'typesetting.projectSetupLayout'
    ])
  .run(['$rootScope', '$state', '$stateParams', function($rootScope,   $state,   $stateParams) {
    $rootScope.$state = $state;
    $rootScope.$stateParams = $stateParams;
  }])
  .config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise('/typeset');
    $stateProvider
        .state('typeset', {
          url: '/typeset',
          templateUrl: '/angular-app/scriptureforge/typesetting/views/typeset.html'
        })
        .state('review', {
          url: '/review',
          templateUrl: '/angular-app/scriptureforge/typesetting/views/review.html'
        })
        .state('render', {
          url: '/render',
          templateUrl: '/angular-app/scriptureforge/typesetting/views/renderList.html'
        })
        .state('layout', {
          url: '/layout',
          templateUrl: '/angular-app/scriptureforge/typesetting/views/projectSetup.layout.html'
        })
        .state('assets', {
          url: '/assets',
          templateUrl: '/angular-app/scriptureforge/typesetting/views/projectSetup.assets.html'
        });
  }])
  .controller('MainCtrl', ['$scope', function($scope) {
    $scope.selectedBtn = 0;
    $scope.settingsButton = {
      isopen: false
    };
  }]);
