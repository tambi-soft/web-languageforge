'use strict';

var SfAssetSettingsPage = function() {
  this.noticeList = element.all(by.repeater('notice in notices()'));
  
  this.settingsMenuLink = element(by.css('.hdrnav a.btn i.icon-cog'));
  this.assetsLink = element(by.linkText('Assets'));
  this.get = function get() {
    this.settingsMenuLink.click();
    this.assetsLink.click();
  };

  this.title = element(by.tagName('h2'));
  this.addButtonList = element.all(by.partialButtonText('Add'));
};

module.exports = new SfAssetSettingsPage();
