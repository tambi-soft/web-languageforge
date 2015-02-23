'use strict';

var projectTypes = {
  'sf': 'Community Scripture Checking', // ScriptureForge
  'lf': 'Web Dictionary', // LanguageForge
};

var util = require('./util');
var constants = require('../../testConstants.json');

var SfProjectsPage = function() {
  var page = this;
  this.url = "/app/webtypesetting/54bf0c5225f225340a8fc83f/#/layout";
  this.get = function() {
    browser.get(browser.baseUrl + this.url);
  };
};
module.exports = new SfProjectsPage();