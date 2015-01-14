'use strict';

angular.module('webtypesetting.projectSetup', ['jsonRpc', 'ui.bootstrap', 'bellows.services',  'ngAnimate', 'palaso.ui.notice', 'webtypesetting.services'])

.controller('projectSetupCtrl', ['$scope', '$state', 'webtypesettingSetupService',  'sessionService', 'modalService', 'silNoticeService',
function($scope, $state, webtypesettingSetupApi, sessionService, modal, notice) {
}])

.controller('templateCtrl', ['$scope', '$state', 'webtypesettingSetupService',  'sessionService', 'modalService', 'silNoticeService',
function($scope, $state, webtypesettingSetupApi, sessionService, modal, notice) {
    $scope.loadTemplateCollapsed = true;
    $scope.saveTemplateCollapsed = true;
    $scope.disableAddButton = true;
    $scope.saveTemplateName = "";
    $scope.loadTemplateName = "";
    
    $scope.uncollapseDivs = function(div){
      if (div ==="load"){
        if (!$scope.loadTemplateCollapsed){
          $scope.loadTemplateCollapsed = true;
        }else{
          $scope.loadTemplateCollapsed = false;
          $scope.saveTemplateCollapsed = true;
        }
      }
      if (div==="save"){
        if (!$scope.saveTemplateCollapsed){
          $scope.saveTemplateCollapsed = true;
        }else{
          $scope.saveTemplateCollapsed = false;
          $scope.loadTemplateCollapsed = true;
        }
      }
    };
    
    
}]);