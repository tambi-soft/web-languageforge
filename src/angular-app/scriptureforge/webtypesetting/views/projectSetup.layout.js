// controller for setupProjectLayout
'use strict';

angular.module('webtypesetting.projectSetup', ['jsonRpc', 'ui.bootstrap', 'bellows.services', 'ngAnimate', 'palaso.ui.notice', 'webtypesetting.services'])

.controller('projectSetupCtrl', ['$scope', '$state', 'webtypesettingSetupService', 'sessionService', 'modalService', 'silNoticeService', function($scope, $state, webtypesettingSetupApi, sessionService, modal, notice) {

}])
.controller('projectSetupLayoutCtrl', ['$scope', '$state', 'webtypesettingSetupService', 'sessionService', 'modalService', 'silNoticeService', function($scope, $state, webtypesettingSetupApi, sessionService, modal, notice) {
  var vm = this;
  vm.width = 400;
  vm.height = 500;
  vm.insideMargin = 60;
  vm.outsideMargin = 50;
  vm.topMargin = 35;
  vm.bottomMargin = 40;
  vm.lockHorizontalMargins = false;
  vm.lockVerticalMargins = false;
  // vm.units = "pixels";
  // two way binding?
}]);