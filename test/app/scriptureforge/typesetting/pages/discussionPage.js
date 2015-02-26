//needs objects from the discussion page
//-title

'use strict';

var SfDiscussionPage = function() {

  this.noticeList = element.all(by.repeater('notice in notices()'));

  this.discussionLink = element(by.linkText('Discussion'));
  this.get = function get() {
    this.discussionLink.click();
  };

  this.title = element(by.tagName('h2'));
  this.addThreadButton = element(by.partialButtonText('Create New Thread'));

};

module.exports = new SfDiscussionPage();
