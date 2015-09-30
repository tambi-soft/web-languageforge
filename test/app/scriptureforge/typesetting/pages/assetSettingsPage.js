'use strict';

var SfAssetSettingsPage = function() {
  var MockUpload = require('../../../bellows/pages/mockUploadDirective.js');
  
  this.noticeList = element.all(by.repeater('notice in notices()'));
  
  this.settingsMenuLink = element(by.css('.hdrnav a.btn i.icon-cog'));
  this.assetsLink = element(by.linkText('Assets'));
  this.get = function get() {
    this.settingsMenuLink.click();
    this.assetsLink.click();
  };

  this.title = element(by.tagName('h2'));
  
  this.addButtonList = element.all(by.partialButtonText('Add'));
  this.dropBoxList = element.all(by.css('.drop-box'));
  this.mockUploadList = element.all(by.css('pui-mock-upload'));
  this.assetFilenameList = element.all(by.binding('asset.name'));
  
  this.paraTextTexts = {
    'dropBox': this.dropBoxList.first(),
    'addButton': this.addButtonList.first(),
    'mockUpload': new MockUpload(this.mockUploadList.first()),
    'assetFilename': this.assetFilenameList.first()
  };
  
};

module.exports = new SfAssetSettingsPage();
