
var HtmlReporter = require('protractor-beautiful-reporter');
var path = require('path');
var log4js = require('log4js');
exports.config = {
  // The address of a running selenium server.
  seleniumAddress: 'http://default.local:4444/wd/hub',
  baseUrl: 'http://languageforge.local',

  // The timeout in milliseconds for each script run on the browser. This should
  // be longer than the maximum time your application needs to stabilize between
  // tasks.
  allScriptsTimeout: 12000,

  // To run tests in a single browser, uncomment the following
  capabilities: {
    browserName: 'chrome',
    chromeOptions: {
      args: ['--start-maximized']
    }
  },

  framework: 'jasmine2',

  // To run tests in multiple browsers, uncomment the following
  // multiCapabilities: [{
  //   'browserName': 'chrome'
  // }, {
  //   'browserName': 'firefox'
  // }],

  // Selector for the element housing the angular app - this defaults to
  // body, but is necessary if ng-app is on a descendant of <body>
  rootElement: '[id="app-container"]',

  // Spec patterns are relative to the current working directly when
  // protractor is called.
  //specs: specs,

  // Options to be passed to Jasmine-node.
  jasmineNodeOpts: {
    showColors: true,
    defaultTimeoutInterval: 120000,
    print: function () {}

    //isVerbose: true,
  },

  onPrepare: function () {
    /* global angular: false, browser: false, jasmine: false */

    browser.driver.manage().window().maximize();

    if (process.env.TEAMCITY_VERSION) {
      var jasmineReporters = require('jasmine-reporters');
      jasmine.getEnv().addReporter(new jasmineReporters.TeamCityReporter());
    } else {
      var SpecReporter = require('jasmine-spec-reporter').SpecReporter;
      jasmine.getEnv().addReporter(new SpecReporter({
        spec: {
          displayStacktrace: true
        }
      }));
      /*
      jasmine.getEnv().addReporter(new jasmineReporters.TerminalReporter({
        verbosity: browser.params.verbosity, // [0 to 3, jasmine default 2]
        color: true,
        showStack: true
      }));
      */
      var pauseOnFailure = {
        specDone: function (spec) {
          if (spec.status === 'failed') {
            debugger;
          }
        }
      };

      // Uncomment to pause tests on first failure
      // jasmine.getEnv().addReporter(pauseOnFailure);
    }
    // Log4js configuration
    const DesktopPath = require('path').join(require('os').homedir(), 'Desktop');
    log4js.configure({
      appenders: { TestprotractorLog4js: { type: 'file', filename: DesktopPath + '/Logs/executionLog.log' } },
      categories: { default: { appenders: ['TestprotractorLog4js'], level: 'error' } }
      });
    browser.logger = log4js.getLogger('TestprotractorLog4js');
    
    // HTML Report configuration
    jasmine.getEnv().addReporter(new HtmlReporter({
      baseDirectory: 'tmp/screenshots',
      preserveDirectory: false,
      takeScreenShotsOnlyForFailedSpecs: false,
      screenshotsSubfolder: 'images',
      jsonsSubfolder: 'jsons',
      baseDirectory: DesktopPath + '/HTML_Reports',
      docTitle: 'HTML_Reports',
      docName: 'HTML_Report.html',
      gatherBrowserLogs: false,
      takeScreenShotsForSkippedSpecs: true,
      excludeSkippedSpecs: false,
      pathBuilder: function pathBuilder(spec, descriptions, results, capabilities) {
          var currentDate = new Date(),
              day = currentDate.getDate(),
              month = currentDate.getMonth() + 1,
              year = currentDate.getFullYear();

          var validDescriptions = descriptions.map(function (description) {
              return description.replace('/', '@');
          });

          return path.join(
              day + "-" + month + "-" + year,
              capabilities.get('browserName'),
              validDescriptions.join('-'));
      }
    }).getJasmine2Reporter());
  
  
  },
  SELENIUM_PROMISE_MANAGER: false
};

if (process.env.TEAMCITY_VERSION) {
  exports.config.jasmineNodeOpts.showColors = false;
  exports.config.jasmineNodeOpts.silent = true;
}
