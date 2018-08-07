import 'jasmine';
import {browser} from 'protractor';

import {SfAppFrame} from '../bellows/shared/app.frame';
import {PageBody} from '../bellows/shared/page-body.element';
import {Utils} from '../bellows/shared/utils';

afterEach(() => {
  const appFrame = new SfAppFrame();
  const body = new PageBody();

  appFrame.errorMessage.isPresent().then(isPresent => {
    if (isPresent) {
      appFrame.errorMessage.getText().then(message => {
        if (message.includes('Oh. Exception')) {
          message = 'PHP API error on this page: ' + message;
          expect<any>(message).toEqual(''); // fail the test
        }
      });
    }
  });

  body.phpError.isPresent().then(isPresent => {
    if (isPresent) {
      body.phpError.getText().then(message => {
        message = 'PHP Error present on this page:' + message;
        expect<any>(message).toEqual(''); // fail the test
      });
    }
  });

  // output JS console errors and fail tests
  browser.manage().logs().get('browser').then(browserLogs => {
    for (const browserLog of browserLogs) {
      let text = browserLog.message;
      if (Utils.isMessageToIgnore(browserLog)) {
        return;
      }

      text = '\n\nBrowser Console JS Error: \n' + text + '\n\n';
      expect<any>(text).toEqual(''); // fail the test
    }
  });

  const myReporter = {
    specDone: (result: any) => {

        switch (result.status) {
            case 'passed' : {
                browser.logger.info('Test FullName: ' + result.fullName + ' - Test Result: ' + result.status);
                break;
            }
            case 'failed' : {
                browser.logger.error('Test FullName: ' + result.fullName + ' - Test Result: ' + result.status);
                // tslint:disable-next-line:prefer-for-of
                for (let i = 0; i < result.failedExpectations.length; i++) {
                  browser.logger.error('Test failed message: ' + result.failedExpectations[i].message);
                  browser.logger.error('Test failed stack: ' + result.failedExpectations[i].stack);
                 }
                break;
            }
            case 'pending' : {
                browser.logger.info('Test FullName: ' + result.fullName + ' - Test Result: ' + result.status);
                break;
            }
            default: {
                browser.logger.info('There is no testcase pass or fail state' +
                  'It seems to be unkown test result state');
                break;
             }
        }

    }
  };
  jasmine.getEnv().addReporter(myReporter);

});
