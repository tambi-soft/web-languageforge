'use strict';

describe('the Discussion page', function() {
  var constants         = require('../../../testConstants.json');
  var loginPage         = require('../../../bellows/pages/loginPage.js');
  var util              = require('../../../bellows/pages/util.js');
  var appFrame          = require('../../../bellows/pages/appFrame.js');
  var projectListPage   = require('../../../bellows/pages/projectsPage.js');
  var discussionPage    = require('../pages/discussionPage.js');

  it('setup: logout, login as admin, navigate to Discussion page', function() {
    loginPage.logout();
    loginPage.loginAsAdmin();
    projectListPage.get();
    projectListPage.clickOnProject(constants.typesettingProjectName);
    discussionPage.get();
    expect(discussionPage.title.getInnerHtml()).toEqual('Discussions');
  });
/*
  it('can create new thread', function() {
    // press the create new thread button, opens up the form
    discussionPage.addThreadButton.click();

    // expect an input form to be there
    expect(discussionPage.form.newThread.isPresent()).toBe(true);

  });

  it('can delete existing thread', function() {
    discussionPage.buttions.isDeleted.click();
  });

  it('can change threads displayed per page', function() {

  });

  it('can change thread list page', function() {

  });

  it('can enter thread, create post, create reply', function() {

  });

  it('can edit post', function() {

  });

  it('can start to edit reply, but cancel', function() {

  });

  it('can edit thread title', function() {

  });

  it('can delete post', function() {

  });

  it('can delete reply', function() {

  });

  it('can change status', function() {

  });
*/
});
