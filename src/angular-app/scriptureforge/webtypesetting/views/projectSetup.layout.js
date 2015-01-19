// controller for setupProjectLayout
'use strict';

angular.module('webtypesetting.projectSetupLayout', ['jsonRpc', 'ui.bootstrap', 'bellows.services', 'ngAnimate', 'palaso.ui.notice', 'webtypesetting.services'])

.controller('projectSetupLayoutCtrl', ['$scope', '$state', 'webtypesettingSetupService', 'sessionService', 'modalService', 'silNoticeService', 'templateSaveService', 'templateLoadService', '$interval', '$rootScope', 
function($scope, $state, webtypesettingSetupApi, sessionService, modal, notice, templateSaveObject, templateLoadObject, $interval, $rootScope) {
  var vm = this;
  
  vm.introColumnsTwo = false;
  vm.pageSizeCode = "A5";
  vm.pageWidth = 148;
  vm.topMargin = 15;
  vm.bodyColumnsTwo = true;
  vm.insideMargin = 10;
  vm.outsideMargin = 10;
  vm.headerPosition = 5;
  vm.printerPageSizeCode = "A4";
  vm.titleColumnsTwo = false;
  vm.footerPosition = 5;
  vm.bottomMargin = 10;
  vm.pageHeight = 210;

  vm.width = 300;
  vm.height = 400;
  vm.css = {
      leftPage: {
        height: vm.height,
        width: vm.width,
      },
      leftMargins: {
        height: vm.height - vm.topMargin - vm.bottomMargin + "px",
        width: vm.width - vm.insideMargin - vm.outsideMargin + "px",
        marginTop: vm.topMargin + "px",
        marginRight: vm.insideMargin + "px",
      },
      rightPage: {
        height: vm.height,
        width: vm.width,
      },
      rightMargins: {
        height: vm.height - vm.topMargin - vm.bottomMargin + "px",
        width: vm.width - vm.insideMargin - vm.outsideMargin + "px",
        marginTop: vm.topMargin + "px",
        marginLeft: vm.insideMargin + "px",
      },
  };
  
  
  function watchMaker(margin, max, size, outside, left, margin_right, right, margin_left) {
    $scope.$watch("layout." + margin, function() {
      vm[max] = vm[size] - vm[outside];
      vm.css[left][size] = vm[size] - vm[margin] - vm[outside] + "px";
      vm.css[left][margin_right] = vm[margin] + "px";
      vm.css[right][size] = vm.css[left][size];
      vm.css[right][margin_left] = vm[margin] + "px";
      if (vm[max] < vm[margin]) {
        vm[margin] = vm[max];
      }
      if (vm[margin] < 0) {
        vm[margin] = 0;
      }
    });
  }
  
  $scope.$watch('layout.bottomMargin', function() {
    vm.maxbottomMargin = vm.height - vm.topMargin;
    vm.css.leftMargins.height = vm.height - vm.bottomMargin - vm.topMargin + "px";
    vm.css.leftMargins.marginbottom = vm.bottomMargin + "px";
    vm.css.rightMargins.height = vm.css.leftMargins.height;
    vm.css.rightMargins.marginbottom = vm.bottomMargin + "px";
    
    if (vm.maxbottomMargin < vm.bottomMargin) {
      vm.bottomMargin = vm.maxbottomMargin;
    }
    if (vm.bottomMargin < 0) {
      vm.bottomMargin = 0;
    }
  });

  $scope.$watch('layout.topMargin', function() {
    vm.maxTopMargin = vm.height - vm.bottomMargin;
    vm.css.leftMargins.height = vm.height - vm.topMargin - vm.bottomMargin + "px";
    vm.css.leftMargins.marginTop = vm.topMargin + "px";
    vm.css.rightMargins.height = vm.css.leftMargins.height;
    vm.css.rightMargins.marginTop = vm.topMargin + "px";
    
    if (vm.maxTopMargin < vm.topMargin) {
      vm.topMargin = vm.maxTopMargin;
    }
    if (vm.topMargin < 0) {
      vm.topMargin = 0;
    }
  });
  
  watchMaker("insideMargin", "maxInsideMargin", "width", "outsideMargin", "leftMargins", "marginRight", "rightMargins", "marginLeft");
  watchMaker("outsideMargin", "maxOutsideMargin", "width", "insideMargin", "rightMargins", "marginRight", "leftMargins", "marginLeft");
  
  var saving = false;
  var saved = false;

  $scope.saveNotice = function saveNotice() {
    if (saving) return 'Saving';
    if (saved) return 'Saved';
    return '';
  };
  
  function saveLayoutSettings() {
    cancelAutoSaveTimer();
    saving = true;
    console.log('saveLayoutSettings');
    
    // TODO add code here to save layout settings. IJH 2015-01
    
      // TODO in successful save callback, set 'saved' to true and form to pristine IJH 2015-01 
//      saved = true;
      $scope.layoutForm.$setPristine();

    // TODO always clear 'saving' irrespective of succesful save. IJH 2015-01
//    saving = false;
  };

  var autoSaveTimer;
  function startAutoSaveTimer() {
    if (angular.isDefined(autoSaveTimer)) {
      return;
    }
    autoSaveTimer = $interval(function() {
      saveLayoutSettings();
    }, 5000, 1);
  };
  function cancelAutoSaveTimer() {
    if (angular.isDefined(autoSaveTimer)) {
      $interval.cancel(autoSaveTimer);
      autoSaveTimer = undefined;
    }
  };

  $scope.$on('$destroy', function() {
    cancelAutoSaveTimer();
    saveLayoutSettings();
  });

  $scope.$on('$locationChangeStart', function(event, next, current) {
    cancelAutoSaveTimer();
    saveLayoutSettings();
  });

  $scope.$watch('layoutForm.$dirty', function(newValue) {
    if (newValue != undefined && newValue) {
      cancelAutoSaveTimer();
      startAutoSaveTimer();
    }
  });

  $rootScope.$on('handleSaveBroadcast', function() {
		console.log("handledSaveBroadcast");
		templateSaveObject.vm = vm;
  });
  
}]);
