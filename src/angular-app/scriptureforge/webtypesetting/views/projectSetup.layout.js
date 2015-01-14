// controller for setupProjectLayout
'use strict';

angular.module('webtypesetting.projectSetupLayout', ['jsonRpc', 'ui.bootstrap', 'bellows.services', 'ngAnimate', 'palaso.ui.notice', 'webtypesetting.services'])

.controller('projectSetupLayoutCtrl', ['$scope', '$state', 'webtypesettingSetupService', 'sessionService', 'modalService', 'silNoticeService', function($scope, $state, webtypesettingSetupApi, sessionService, modal, notice) {
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
//  vm.insideMargin = 60;
//  vm.outsideMargin = 50;
//  vm.topMargin = 35;
//  vm.bottomMargin = 40;
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
  
  // variable watchers
  /*
  $scope.$watch('[layout.insideMargin, layout.outsideMargin, layout.topMargin, layout.bottomMargin]', function() {
    vm.maxOutsideMargin = vm.width - vm.insideMargin;
    vm.maxTopMargin = vm.height - vm.bottomMargin;
    vm.maxBottomMargin = vm.height - vm.topMargin;
    vm.css.leftPage = {
    		width: vm.width + "px",
    		height: vm.height + "px",
    };
    vm.css.rightPage = {
        width: vm.width + "px",
        height: vm.height + "px",
    };
    vm.css.rightMargins = {
        height: vm.height - vm.topMargin - vm.bottomMargin + "px",
        width: vm.width - vm.insideMargin - vm.outsideMargin + "px",
        margin: vm.topMargin + "px " + vm.outsideMargin + "px " + vm.bottomMargin + "px " + vm.insideMargin + "px",
    };
  }, true);
  */
  
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
 
/*
  $scope.$watch('layout.insideMargin', function() {
    vm.maxInsideMargin = vm.width - vm.outsideMargin;

    vm.css.leftMargins.width = vm.width - vm.insideMargin - vm.outsideMargin + "px";
    vm.css.leftMargins["margin-right"] = vm.insideMargin + "px";
    vm.css.rightMargins.width = vm.width - vm.insideMargin - vm.outsideMargin + "px";
    vm.css.rightMargins["margin-left"] = vm.insideMargin + "px";
    
    if (vm.maxInsideMargin < vm.insideMargin) {
      vm.insideMargin = vm.maxInsideMargin;
    }
  });
  $scope.$watch('layout.outsideMargin', function() {
    vm.maxOutsideMargin = vm.width - vm.insideMargin;

    vm.css.rightMargins.width = vm.width - vm.insideMargin - vm.outsideMargin + "px";
    vm.css.rightMargins["margin-left"] = vm.outsideMargin + "px";
    vm.css.leftMargins.width = vm.width - vm.insideMargin - vm.outsideMargin + "px";
    vm.css.leftMargins["margin-right"] = vm.outsideMargin + "px";
    
    if (vm.maxOutsideMargin < vm.outsideMargin) {
      vm.outsideMargin = vm.maxOutsideMargin;
    }
  });
  $scope.$watch('layout.insideMargin', function() {
    vm.maxInsideMargin = vm.width - vm.outsideMargin;

    vm.css.leftMargins.width = vm.width - vm.insideMargin - vm.outsideMargin + "px";
    vm.css.leftMargins["margin-right"] = vm.insideMargin + "px";
    vm.css.rightMargins.width = vm.width - vm.insideMargin - vm.outsideMargin + "px";
    vm.css.rightMargins["margin-left"] = vm.insideMargin + "px";
    
    if (vm.maxInsideMargin < vm.insideMargin) {
      vm.insideMargin = vm.maxInsideMargin;
    }
  });
  $scope.$watch('layout.insideMargin', function() {
    vm.maxInsideMargin = vm.width - vm.outsideMargin;

    vm.css.leftMargins.width = vm.width - vm.insideMargin - vm.outsideMargin + "px";
    vm.css.leftMargins["margin-right"] = vm.insideMargin + "px";
    vm.css.rightMargins.width = vm.width - vm.insideMargin - vm.outsideMargin + "px";
    vm.css.rightMargins["margin-left"] = vm.insideMargin + "px";
    
    if (vm.maxInsideMargin < vm.insideMargin) {
      vm.insideMargin = vm.maxInsideMargin;
    }
  });
*/
  
}]);