'use strict';

var projectTypes = {
	'sf': 'Community Scripture Checking', // ScriptureForge
	'lf': 'Web Dictionary', // LanguageForge
};

var util = require('./util');
var constants = require('../../testConstants.json');

var SfProjectsPage = function() {
	var page = this;
	this.url = "/app/webtypesetting/54adf50c25f225820b21ab74/#/layout";
	this.get = function() {
		browser.get(browser.baseUrl + this.url);
	};
};
module.exports = new SfProjectsPage();