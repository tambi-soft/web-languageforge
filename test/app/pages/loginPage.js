'use strict';

var constants = require('../../testConstants');

var SfLoginPage = function() {
	var page = this; // For use inside our methods. Necessary when passing anonymous functions around, which lose access to "this".

	this.loginURL        = '/auth/login';

	this.baseUrl = browser.baseUrl;
	this.get = function() {
		return browser.driver.get(this.baseUrl + this.loginURL);
	};

	// Note that we can't use browser.driver.findElement() yet, as that doesn't return a promise
	// but tries to find the element *immediately*. We have to use findElement() later, in the login() function
	this.username = by.id('identity');
	this.password = by.id('password');
	this.submit   = by.xpath('//input[@type="submit"]');

	this.login = function(username, password) {
		page.get();

		// Now we need to wait for the page to load
		browser.driver.wait(function() {
			// wait() wants a function that will return true when we should finish waiting.
			// In other words, we should return a promise that, when it is fulfilled, means "You can stop waiting now".
			// Here, we use "Is the username field present?" as the promise that fulfills the wait condition.
			return browser.driver.isElementPresent(page.username); // NOTE: using "this.username" would have failed, because "this" is undefined right now.
		}, 8000); // Timeout if still not loaded after 8 seconds

		browser.driver.findElement(page.username).sendKeys(username);
		browser.driver.findElement(page.password).sendKeys(password);
		browser.driver.findElement(page.submit).click();
	};
	this.loginAsAdmin = function() {
		this.login(constants.adminUsername, constants.adminPassword);
	};
	this.loginAsManager = function() {
		this.login(constants.managerUsername, constants.managerPassword);
	};
	this.loginAsUser = this.loginAsMember = function() {
		this.login(constants.memberUsername, constants.memberPassword);
	};
	this.logout = function() {
		browser.driver.get(this.baseUrl + '/auth/logout');
	};
};

module.exports = new SfLoginPage();
// This makes the result of calling require('./pages/loginPage') to be the SfLoginPage constructor function.
// So you'd use this as "var LoginPage = require('./pages/loginPage'); var loginPage = new LoginPage();"
