//controller for renderList
'use strict';

angular.module('webtypesetting.renderList', ['jsonRpc', 'ui.bootstrap', 'bellows.services', 'ngAnimate', 'palaso.ui.notice', 'webtypesetting.renderServices'])

.controller('renderListCtrl', ['$scope', '$state', 'webtypesettingRenderService', 'sessionService', 'modalService', 'silNoticeService', 'templateSaveService', 'templateLoadService', '$interval', '$rootScope', function($scope, $state, renderService, sessionService, modal, notice, templateSaveObject, templateLoadObject, $interval, $rootScope) {
  $scope.search = "";
  $scope.pageSize = 10;
  $scope.pageNumber = 1;
  
  $scope.items = [];
  /*
  for (var i = 1; i <= 1000; i++) {
    $scope.items.push({
      dateCreated: new Date(i*1000).toString(),
      workflowState: "state " + i,
      id: i.toString(),
    });
  }
  */
  
  function match(obj, search) {
    for (var key in obj) {
      if (obj[key].indexOf(search) > -1) {
        return true;
      }
    }
    return false;
  };
  
  function updateItems() {
    $scope.items = [];
    for (var i in $scope.list) {
      var cur = $scope.list[i];
      $scope.items.push({
        dateCreated: new Date(cur.dateCreated.sec*1000).toString(),
        workflowState: cur.workflowState.toString(),
        id: cur.id.toString(),
      })
    }
  }
  
  $scope.getPage = function(items, page, size, search) {
    var list = [];
    for (var i in items) {
      if (match(items[i], search)) {
        list.push(items[i]);
      }
    }
    return list.slice((page-1)*size, page*size);
  };
  
  $scope.totalItems = function(items, search) {
    var list = [];
    for (var i in items) {
      if (match(items[i], search)) {
        list.push(items[i]);
      }
    }
    return list.length;
  };
  
  $scope.getPageDto = function getPageDto() {
    renderService.getPageDto(function(result) {
      $scope.list = result.data.runs;
      updateItems();
    });
  };
  
  $scope.doRender = function doRender() {
    renderService.doRender(function(result) {
        notice.push(notice.SUCCESS, 'Render Complete');
        $scope.getPageDto();
    });
  };
  
  $scope.getPageDto();
}]);
