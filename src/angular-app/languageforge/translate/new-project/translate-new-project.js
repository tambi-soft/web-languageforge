'use strict';

angular.module('translate-new-project',
  [
    'bellows.services',
    'bellows.filters',
    'ui.bootstrap',
    'ngAnimate',
    'ui.router',
    'palaso.ui.utils',
    'palaso.ui.sendReceiveCredentials',
    'palaso.ui.mockUpload',
    'palaso.util.model.transform',
    'pascalprecht.translate',
    'ngFileUpload',
    'translate.services'
  ])
  .config(['$stateProvider', '$urlRouterProvider', '$translateProvider',
  function ($stateProvider, $urlRouterProvider, $translateProvider) {

    // configure interface language filepath
    $translateProvider.useStaticFilesLoader({
      prefix: '/angular-app/languageforge/translate/new-project/lang/',
      suffix: '.json'
    });
    $translateProvider.preferredLanguage('en');
    $translateProvider.useSanitizeValueStrategy('escape');

    // State machine from ui.router
    $stateProvider
      .state('newProject', {

        // Need quotes around Javascript keywords like 'abstract' so YUI compressor won't complain
        'abstract': true, // jscs:ignore
        templateUrl:
          '/angular-app/languageforge/translate/new-project/views/new-project-abstract.html',
        controller: 'NewTranslateProjectCtrl'
      })
      .state('newProject.name', {
        templateUrl: '/angular-app/languageforge/translate/new-project/views/new-project-name.html',
        data: {
          step: 1
        }
      })
    ;

    $urlRouterProvider
      .when('', ['$state', function ($state) {
        if (!$state.$current.navigable) {
          $state.go('newProject.name');
        }
      }]);

  }])
  .controller('NewTranslateProjectCtrl', ['$scope', '$q', '$filter', '$uibModal', '$window',
    'sessionService', 'silNoticeService', '$translate', '$state', 'Upload',
    'translateProjectService', 'sfchecksLinkService',
    function ($scope, $q, $filter, $modal, $window,
            sessionService, notice, $translate, $state, Upload,
            projectService, linkService) {
    $scope.interfaceConfig = {};
    $scope.interfaceConfig.userLanguageCode = 'en';
    if (angular.isDefined(sessionService.session.projectSettings) &&
        angular.isDefined(sessionService.session.projectSettings.interfaceConfig)) {
      $scope.interfaceConfig = sessionService.session.projectSettings.interfaceConfig;
    }

    $scope.interfaceConfig.direction = 'ltr';
    $scope.interfaceConfig.pullToSide = 'pull-right';
    $scope.interfaceConfig.pullNormal = 'pull-left';
    $scope.interfaceConfig.placementToSide = 'left';
    $scope.interfaceConfig.placementNormal = 'right';
    if (InputSystems.isRightToLeft($scope.interfaceConfig.userLanguageCode)) {
      $scope.interfaceConfig.direction = 'rtl';
      $scope.interfaceConfig.pullToSide = 'pull-left';
      $scope.interfaceConfig.pullNormal = 'pull-right';
      $scope.interfaceConfig.placementToSide = 'right';
      $scope.interfaceConfig.placementNormal = 'left';
    }

    $scope.state = $state;

    // This is where form data will live
    $scope.newProject = {};
    $scope.newProject.appName = 'translate';
    $scope.project = {};
    $scope.project.sendReceive = {};

    $scope.isSRProject = false;
    $scope.show = {};
    $scope.show.nextButton = true;
    $scope.show.backButton = false;
    $scope.show.flexHelp = false;
    $scope.show.cloning = true;
    $scope.show.step3 = false;
    $scope.nextButtonLabel = $filter('translate')('Next');
    $scope.progressIndicatorStep1Label = $filter('translate')('Name');
    $scope.progressIndicatorStep2Label = $filter('translate')('Initial Data');
    $scope.progressIndicatorStep3Label = $filter('translate')('Verify');
    resetValidateProjectForm();

    function makeFormValid(msg) {
      if (!msg) msg = '';
      $scope.formValidated = true;
      $scope.formStatus = msg;
      $scope.formStatusClass = 'alert alert-info';
      if (!msg) $scope.formStatusClass = (bootstrapVersion == 'bootstrap4' ? '' : 'neutral');
      $scope.forwardBtnClass = 'btn-success';
      $scope.formValidationDefer.resolve(true);
      return $scope.formValidationDefer.promise;
    }

    function makeFormNeutral(msg) {
      if (!msg) msg = '';
      $scope.formValidated = false;
      $scope.formStatus = msg;
      $scope.formStatusClass = (bootstrapVersion == 'bootstrap4' ? '' : 'neutral');
      $scope.forwardBtnClass = (bootstrapVersion == 'bootstrap4' ? 'btn-secondary' : '');
      $scope.formValidationDefer = $q.defer();
      return $scope.formValidationDefer.promise;
    }

    function makeFormInvalid(msg) {
      if (!msg) msg = '';
      $scope.formValidated = false;
      $scope.formStatus = msg;
      $scope.formStatusClass =
        (bootstrapVersion == 'bootstrap4' ? 'alert alert-danger' : 'alert alert-error');
      if (!msg) $scope.formStatusClass = (bootstrapVersion == 'bootstrap4' ? '' : 'neutral');
      $scope.forwardBtnClass = '';
      $scope.formValidationDefer.resolve(false);
      return $scope.formValidationDefer.promise;
    }

    // Shorthand to make things look a touch nicer
    var ok = makeFormValid;
    var neutral = makeFormNeutral;
    var error = makeFormInvalid;

    $scope.iconForStep = function iconForStep(step) {
      var classes = [];
      if ($state.current.data.step > step) {
        classes.push((bootstrapVersion == 'bootstrap4' ? 'fa fa-check-square' : 'icon-check-sign'));
      }

      if ($state.current.data.step == step) {
        classes.push((bootstrapVersion == 'bootstrap4' ? 'fa fa-square-o' : 'icon-check-empty'));
      } else if ($state.current.data.step < step) {
        classes.push(
          (bootstrapVersion == 'bootstrap4' ? 'fa fa-square-o muted' : 'icon-check-empty muted'));
      }

      return classes;
    };

    $scope.getProjectFromInternet = function getProjectFromInternet() {
      $state.go('newProject.sendReceiveCredentials');
      $scope.isSRProject = true;
      $scope.show.nextButton = true;
      $scope.show.backButton = true;
      $scope.show.step3 = false;
      $scope.nextButtonLabel = $filter('translate')('Get Started');
      $scope.progressIndicatorStep1Label = $filter('translate')('Connect');
      $scope.progressIndicatorStep2Label = $filter('translate')('Verify');
      $scope.resetValidateProjectForm();
      if (!$scope.project.sendReceive.username) {
        $scope.project.sendReceive.username = sessionService.session.username;
      }

      validateForm();
    };

    $scope.createNew = function createNew() {
      $state.go('newProject.name');
      $scope.isSRProject = false;
      $scope.show.nextButton = true;
      $scope.show.backButton = true;
      $scope.show.step3 = true;
      $scope.nextButtonLabel = $filter('translate')('Next');
      $scope.progressIndicatorStep1Label = $filter('translate')('Name');
      $scope.progressIndicatorStep2Label = $filter('translate')('Initial Data');
    };

    $scope.prevStep = function prevStep() {
      $scope.show.backButton = false;
      $scope.resetValidateProjectForm();
      switch ($state.current.name) {
        case 'newProject.name':
          break;
      }
    };

    $scope.nextStep = function nextStep() {
      validateForm().then(function (isValid) {
        if (isValid) {
          gotoNextState();
        }
      });
    };

    // Form validation requires API calls, so it return a promise rather than a value.
    function validateForm() {
      $scope.formValidationDefer = $q.defer();

      switch ($state.current.name) {
        case 'newProject.name':
          if (!$scope.newProject.projectName) {
            return error('Project Name cannot be empty. Please enter a project name.');
          }

          if (!$scope.newProject.projectCode) {
            return error('Project Code cannot be empty. ' +
              'Please enter a project code or uncheck "Edit project code".');
          }

          if (!$scope.newProject.appName) {
            return error('Please select a project type.');
          }

          if ($scope.projectCodeState == 'unchecked') {
            $scope.checkProjectCode();
          }

          return $scope.projectCodeStateDefer.promise.then(function () {
            switch ($scope.projectCodeState) {
              case 'ok':
                return ok();
              case 'exists':
                return error('Another project with code \'' + $scope.newProject.projectCode +
                  '\' already exists.');
              case 'invalid':
                return error('Project Code must begin with a letter, ' +
                  'and only contain lower-case letters, numbers, dashes and underscores.');
              case 'loading':
                return error();
              case 'empty':
                return neutral();
              default:

                // Project code state is unknown. Give a generic message,
                // adapted based on whether the user checked "Edit project code" or not.
                if ($scope.newProject.editProjectCode) {
                  return error('Project code \'' + $scope.newProject.projectCode +
                    '\' cannot be used. Please choose a new project code.');
                } else {
                  return error('Project code \'' + $scope.newProject.projectCode +
                    '\' cannot be used. Either change the project name, ' +
                    'or check the "Edit project code" box and choose a new code.');
                }
            }
          });

          break;
      }
      return ok();
    }

    $scope.validateForm = validateForm;

    function gotoNextState() {
      switch ($state.current.name) {
        case 'newProject.name':
          createProject(gotoEditor);

          // $state.go('newProject.initialData');
          $scope.nextButtonLabel = $filter('translate')('Skip');
          $scope.show.backButton = false;
          $scope.projectCodeState = 'empty';
          $scope.projectCodeStateDefer = $q.defer();
          $scope.projectCodeStateDefer.resolve('empty');
          makeFormNeutral();
          break;
      }
    }

    function gotoEditor() {
      var url;
      makeFormValid();
      url = linkService.project($scope.newProject.id, $scope.newProject.appName);
      $window.location.href = url;
    }

    // ----- Step 1: Project name -----

    function projectNameToCode(name) {
      if (angular.isUndefined(name)) return undefined;
      return name.toLowerCase().replace(/ /g, '_');
    }

    $scope.checkProjectCode = function checkProjectCode() {
      $scope.projectCodeStateDefer = $q.defer();
      if (!projectService.isValidProjectCode($scope.newProject.projectCode)) {
        $scope.projectCodeState = 'invalid';
        $scope.projectCodeStateDefer.resolve('invalid');
      } else {
        $scope.projectCodeState = 'loading';
        $scope.projectCodeStateDefer.notify('loading');
        projectService.projectCodeExists($scope.newProject.projectCode, function (result) {
          if (result.ok) {
            if (result.data) {
              $scope.projectCodeState = 'exists';
              $scope.projectCodeStateDefer.resolve('exists');
            } else {
              $scope.projectCodeState = 'ok';
              $scope.projectCodeStateDefer.resolve('ok');
            }
          } else {
            $scope.projectCodeState = 'failed';
            $scope.projectCodeStateDefer.reject('failed');
          }
        });
      }

      return $scope.projectCodeStateDefer.promise;
    };

    function resetValidateProjectForm() {
      makeFormNeutral();
      $scope.projectCodeState = 'unchecked';
      $scope.projectCodeStateDefer = $q.defer();
      $scope.projectCodeStateDefer.resolve('unchecked');
      $scope.project.sendReceive.isUnchecked = true;
      $scope.project.sendReceive.usernameStatus = 'unchecked';
      $scope.project.sendReceive.passwordStatus = 'unchecked';
    }

    $scope.resetValidateProjectForm = resetValidateProjectForm;

    $scope.$watch('projectCodeState', function (newval, oldval) {
      if (!newval || newval == oldval) { return; }

      if (newval == 'unchecked') {
        // User just typed in the project name box.
        // Need to wait just a bit for the idle-validate to kick in.
        return;
      }

      if (oldval == 'loading') {
        // Project code state just resolved. Validate rest of form so Forward button can activate.
        validateForm();
      }
    });

    $scope.$watch('newProject.editProjectCode', function (newval, oldval) {
      if (oldval && !newval) {
        // When user unchecks the "edit project code" box, go back to setting it from project name
        $scope.newProject.projectCode = projectNameToCode($scope.newProject.projectName);
        $scope.checkProjectCode();
      }
    });

    $scope.$watch('newProject.projectName', function (newval, oldval) {
      if (!$scope.isSRProject) {
        if (angular.isUndefined(newval)) {
          $scope.newProject.projectCode = '';
        } else if (newval != oldval) {
          $scope.newProject.projectCode = newval.toLowerCase().replace(/ /g, '_');
        }
      }
    });

    function createProject(callback) {
      if (!$scope.newProject.projectName || !$scope.newProject.projectCode ||
        !$scope.newProject.appName) {
        // This function sometimes gets called during setup, when $scope.newProject is still empty.
        return;
      }

      projectService.createSwitchSession($scope.newProject.projectName,
        $scope.newProject.projectCode, $scope.newProject.appName,
        $scope.project.sendReceive.project, function (result) {
        if (result.ok) {
          $scope.newProject.id = result.data;
          sessionService.refresh(callback);
        } else {
          notice.push(notice.ERROR, 'The ' + $scope.newProject.projectName +
            ' project could not be created. Please try again.');
        }
      });
    }

    // ----- Step 3: Verify initial data -OR- select primary language -----

    function savePrimaryLanguage(callback) {
      var config = { inputSystems: [] };
      var optionlist = {};
      var inputSystem = {};
      notice.setLoading('Configuring project for first use...');
      if (angular.isDefined(sessionService.session.projectSettings)) {
        config = sessionService.session.projectSettings.config;
        optionlist = sessionService.session.projectSettings.optionlists;
      }

      inputSystem.abbreviation = $scope.newProject.languageCode;
      inputSystem.tag = $scope.newProject.languageCode;
      inputSystem.languageName = $scope.newProject.language.name;
      config.inputSystems[$scope.newProject.languageCode] = inputSystem;
      if ('th' in config.inputSystems) {
        delete config.inputSystems.th;
        replaceFieldInputSystem(config.entry, 'th', $scope.newProject.languageCode);
      }

      projectService.updateConfiguration(config, optionlist, function (result) {
        notice.cancelLoading();
        if (result.ok) {
          (callback || angular.noop)();
        } else {
          makeFormInvalid('Could not add ' + $scope.newProject.language.name + ' to project.');
        }
      });
    }

    function replaceFieldInputSystem(item, existingTag, replacementTag) {
      if (item.type === 'fields') {
        angular.forEach(item.fields, function (field) {
          replaceFieldInputSystem(field, existingTag, replacementTag);
        });
      } else {
        if (angular.isDefined(item.inputSystems)) {
          angular.forEach(item.inputSystems, function (inputSystemTag, index) {
            if (inputSystemTag === existingTag) {
              item.inputSystems[index] = replacementTag;
            }
          });
        }
      }
    }

    $scope.$watch('newProject.languageCode', function (newval) {
      if (angular.isDefined(newval)) {
        validateForm();
      }
    });

  }])

  ;
