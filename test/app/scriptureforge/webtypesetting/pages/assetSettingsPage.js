'use strict';

var SfAssetSettingsPage = function() {
  var mockUpload = require('../../../bellows/pages/mockUploadElement.js');
  
  this.noticeList = element.all(by.repeater('notice in notices()'));
  
  this.settingsMenuLink = element(by.css('.hdrnav a.btn i.icon-cog'));
  this.assetsLink = element(by.linkText('Assets'));
  this.get = function get() {
    this.settingsMenuLink.click();
    this.assetsLink.click();
  };

  this.title = element(by.tagName('h2'));
  this.addButtonList = element.all(by.partialButtonText('Add'));
  //this.sectionList = element.all(by.repeater('section in sections'));
  this.sectionList = element.all(by.css('.drop-box'));
  this.sections = {
    paraTextTexts: this.sectionList.first()  
  };
  this.mockUpload = mockUpload;
};

module.exports = new SfAssetSettingsPage();
