'use strict';

var constants = require('../../../../../testConstants.json');
var page = require('../../../../pages/signupPage.js');
var body = require('../../../../pages/pageBody.js');
var util = require('../../../../pages/util');
var loginPage = require('../../../../pages/loginPage.js');

describe('E2E testing: Signup app', function() {
	
	describe('Angular portion of tests', function() {
		afterEach(function() {
			expect(body.phpError.isPresent()).toBe(false);
		});
	
		it('setup and contains a user form', function() {
			page.get();
			expect(page.userForm).toBeDefined();
		});
		
		it('finds the admin user already exists', function() {
			page.usernameInput.sendKeys(constants.adminUsername);
			page.usernameInput.sendKeys(protractor.Key.TAB);	// trigger the username lookup
			expect(page.userNameExists.isDisplayed()).toBe(true);
			expect(page.userNameOk.isDisplayed()).toBe(false);
			page.usernameInput.clear();
		});
		
		it("can verify that an unused username is available", function() {
			page.usernameInput.sendKeys(constants.notUsedUsername);
			page.usernameInput.sendKeys(protractor.Key.TAB);	// trigger the username lookup
			expect(page.userNameExists.isDisplayed()).toBe(false);
			expect(page.userNameOk.isDisplayed()).toBe(true);
			page.usernameInput.clear();
		});
		
		it("cannot submit if passwords don't match", function() {
			page.usernameInput.sendKeys(constants.notUsedUsername);
			page.usernameInput.sendKeys(protractor.Key.TAB);	// trigger the username lookup
			page.nameInput.sendKeys('New User');
			page.emailInput.sendKeys(constants.emailValid);
			page.passwordInput.sendKeys(constants.passwordValid);
			page.captchaInput.sendKeys('whatever');
			expect(page.signupButton.isEnabled()).toBe(false);
		});
	
		it("cannot submit if passwords match but are too short", function() {
			page.passwordInput.clear();
			page.passwordInput.sendKeys(constants.passwordTooShort);
			page.confirmPasswordInput.sendKeys(constants.passwordTooShort);
			expect(page.signupButton.isEnabled()).toBe(false);
		});
	
		it("can submit if passwords match and long enough", function() {
			page.passwordInput.clear();
			page.passwordInput.sendKeys(constants.passwordValid);
			page.confirmPasswordInput.clear();
			page.confirmPasswordInput.sendKeys(constants.passwordValid);
			expect(page.signupButton.isEnabled()).toBe(true);
		});
	
		it("can submit if password is showing, matching and long enough", function() {
			page.confirmPasswordInput.clear();
			page.showPassword.click();
			expect(page.signupButton.isEnabled()).toBe(true);
		});
	
		it("cannot submit if email is invalid", function() {
			page.emailInput.clear();
			page.emailInput.sendKeys(constants.emailNoAt);
			expect(page.signupButton.isEnabled()).toBe(false);
			page.emailInput.clear();
			page.emailInput.sendKeys(constants.emailValid);
		});
	
		it("has a captcha image", function() {
			expect(page.captchaImage.isDisplayed()).toBe(true);
		});
		
		it('can submit a user registration request with no captcha and captcha will be invalid', function() {
			expect(page.noticeList.count()).toBe(0);
			page.signupButton.click();
			expect(page.noticeList.count()).toBe(1);
			expect(page.noticeList.get(0).getText()).toContain('image verification failed');
		});
	
		it('setup: before submitting real registration request, flush email queue', function() {
			util.clearMailQueue();
		});
	
		it('can submit a user registration request if captcha is valid', function() {
			page.captchaInput.clear();
			page.captchaInput.sendKeys('LetMeIn');
			page.signupButton.click();
			expect(page.almostThereDiv.isDisplayed()).toBeTruthy();
			// Step 1 should be checked, step 2 should not
			expect(page.almostThereRows.get(0).$('i').getAttribute('class')).toContain('icon-check-sign');
			expect(page.almostThereRows.get(1).$('i').getAttribute('class')).toContain('icon-check-empty');
		});
	});

	describe('Non-Angular portion of tests', function() {
		// No afterEach() that relies on Angular for these
		it('can confirm the registration by "clicking" the validation link', function() {
			var confirmUrl = util.getFirstUrlFromMail();
			expect(confirmUrl).toMatch('^https?:\\/\\/[^/]+\\/validate');
			confirmUrl.then(function(url) {
				if (url) {
					browser.driver.get(url);
				} else {
					expect(url).toBe('a validation URL'); // Deliberately fail if we get here
				}
			});
			browser.wait(function() {
				return browser.getCurrentUrl().then(function(url) {
					return /validate/.test(url);
				});
			});
			// Now step 2 should be checked, step 3 should not
			// This page doesn't use Angular, so we need to use browser.driver.findElement
			expect(browser.driver.findElement(by.css('#almostThereDiv > div:nth-of-type(2) i')).getAttribute('class')).toContain('icon-check-sign');
			expect(browser.driver.findElement(by.css('#almostThereDiv > div:nth-of-type(3) i')).getAttribute('class')).toContain('icon-check-empty');
		});

		it('can log in after validating', function() {
			loginPage.login(constants.notUsedUsername, constants.passwordValid);
			expect(browser.driver.isElementPresent(by.id('myProjects'))).toBeTruthy();
		});
	});
});
