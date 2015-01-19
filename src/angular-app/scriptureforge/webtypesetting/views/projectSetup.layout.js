// controller for setupProjectLayout
'use strict';

angular.module('webtypesetting.projectSetupLayout', ['jsonRpc', 'ui.bootstrap', 'bellows.services', 'ngAnimate', 'palaso.ui.notice', 'webtypesetting.services'])

.controller('projectSetupLayoutCtrl', ['$scope', '$state', 'webtypesettingSetupService', 'sessionService', 'modalService', 'silNoticeService', 'templateSaveService', 'templateLoadService', '$interval', '$rootScope', 
function($scope, $state, webtypesettingSetupApi, sessionService, modal, notice, templateSaveObject, templateLoadObject, $interval, $rootScope) {
  var vm = this;
  
  // default settings
  vm.conf = {
      // margins
      insideMargin: 10,
      outsideMargin: 10,
      topMargin: 15,
      bottomMargin: 10,
      // columns
      bodyColumnsTwo: true,
      titleColumnsTwo: false,
      introColumnsTwo: false,
      columnGutterRule: false,
      // header
      headerPosition: 5,
      useRunningHeader: true,
      runningHeaderRulePosition: 4,
      // footer
      footerPosition: 5,
      pageResetCallersFootnotes: false,
      useFootnoteRule: true,
      useRunningFooter: false,
      omitCallerInFootnotes: false,
      useSpecialCallerFootnotes: false,
      paragraphedFootnotes: true,
      useNumericCallersFootnotes: false,
      specialCallerFootnotes: "\\kern0.2em *\\kern0.4em",
      // cross references
      omitCallerInCrossrefs: false,
      useSpecialCallerCrossrefs: false,
      paragraphedCrossrefs: true,
      useNumericCallersCrossrefs: false,
      specialCallerCrossrefs: "\\kern0.2em *\\kern0.4em",
      // background
      useBackground: false,
      backgroundComponents: ["watermark"],
      watermarkText: "DRAFT",
      // print options
      pageSizeCode: "A5", // TODO
      pageWidth: 148,
      pageHeight: 210,
      printerPageSizeCode: "A4", // TODO
      useDocInfo: false,
      docInfoText: "",
      // body text
      bodyTextLeading: 12,
      bodyFontSize: 10,
      rightToLeft: false,
      justifyParagraphs: true,
      fontDefaultSize: 12,
      leadingDefaultSize: 14,
      // miscellaneous
      useHangingPunctuation: false,
      useCaptionReferences: true,
      useFigurePlaceHolders: true,
  };

  vm.width = 300;
  vm.height = 400;
  
  vm.css = {
      pagesContainer: {
        width: vm.width * 2 + 25,
      },
      page: {
        height: vm.height,
        width: vm.width,
      },
      leftMargins: {
        height: vm.height - vm.topMargin - vm.bottomMargin + "px",
        width: vm.width - vm.insideMargin - vm.outsideMargin + "px",
        marginTop: vm.topMargin + "px",
        marginRight: vm.insideMargin + "px",
      },
      rightMargins: {
        height: vm.height - vm.topMargin - vm.bottomMargin + "px",
        width: vm.width - vm.insideMargin - vm.outsideMargin + "px",
        marginTop: vm.topMargin + "px",
        marginLeft: vm.insideMargin + "px",
      },
  };
  // variable watchers
  function makeMarginWatch(size, margin, opposite, cssMargin, cssOpposite, mirror) {
    $scope.$watch("layout.conf."+margin+"Margin", function() {
      vm[margin+"MarginMax"] = vm[size] - vm.conf[opposite+"Margin"];
      vm.css.leftMargins[size] = vm[size] - vm.conf[margin+"Margin"] - vm.conf[opposite+"Margin"] + "px";
      vm.css.leftMargins[cssOpposite] = vm.conf[margin+"Margin"] + "px";
      vm.css.rightMargins[size] = vm.css.leftMargins[size];
      if (mirror) {
        vm.css.rightMargins[cssMargin] = vm.css.leftMargins[cssOpposite];
      } else {
        vm.css.rightMargins[cssOpposite] = vm.css.leftMargins[cssOpposite];
      }
      if (vm[margin+"MarginMax"] < vm.conf[margin+"Margin"]) {
        vm.conf[margin+"Margin"] = vm[margin+"MarginMax"];
      }
      if (vm.conf[margin+"Margin"] < 0) {
        vm.conf[margin+"Margin"] = 0;
      }
    });
  }
  makeMarginWatch("width", "inside", "outside", "marginLeft", "marginRight", true);
  makeMarginWatch("width", "outside", "inside", "marginRight", "marginLeft", true);
  makeMarginWatch("height", "top", "bottom", "marginBottom", "marginTop");
  makeMarginWatch("height", "bottom", "top", "marginTop", "marginBottom");

  
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
