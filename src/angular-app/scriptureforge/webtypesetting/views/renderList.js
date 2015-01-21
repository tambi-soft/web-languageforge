//controller for renderList
'use strict';

angular.module('webtypesetting.renderList', ['jsonRpc', 'ui.bootstrap', 'bellows.services', 'ngAnimate', 'palaso.ui.notice', 'webtypesetting.services'])

.controller('renderListCtrl', ['$scope', '$state', 'webtypesettingSetupService', 'sessionService', 'modalService', 'silNoticeService', 'templateSaveService', 'templateLoadService', '$interval', '$rootScope', function($scope, $state, webtypesettingSetupApi, sessionService, modal, notice, templateSaveObject, templateLoadObject, $interval, $rootScope) {
  $scope.search = "";
  $scope.pageSize = 10;
  
  $scope.list = [];
  for (var i = 1; i <= 100; i++) {
    $scope.list.push({
      component: "component " + i,
      renderer: "renderer " + i,
      renderedOn: Date() + i,
      comments: "this a comment. comment id is " + i,
      tags: "tag " + i,
    });
  }
  
  $scope.contains = function(obj, search) {
    var key;
    for (key in obj) {
      if (obj[key].indexOf(search) > -1) {
        return true;
      }
    }
    return false;
  }
}]);
