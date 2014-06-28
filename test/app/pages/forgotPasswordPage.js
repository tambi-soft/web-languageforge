'use strict';

var BellowsForgotPasswordPage = function() {
	var page = this;
	this.baseUrl = browser.baseUrl;
	this.url = '/auth/forgot_password';

	this.get = function() {
		return browser.driver.get(this.baseUrl + this.url);
	};

	// Non-Angular page, so just define selectors
	// The test will need to use browser.driver.findElement(selector)
	this.form  = by.css('form');
	this.email = by.css('input[name="email"]');
	this.infoMessage = by.id('infoMessage');
	this.submitButton = by.css('input[type="submit"]');

	// Form elements after the page has refreshed
	this.password = by.css('input[name="new"]');
	this.confirm  = by.css('input[name="new_confirm"]');

	// Page elements after password has been changed
	this.infoAlert = by.css('div.alert-info');
};

module.exports = new BellowsForgotPasswordPage();