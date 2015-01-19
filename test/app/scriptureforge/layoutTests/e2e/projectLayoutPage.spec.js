'use strict';

describe('the project dashboard AKA text list page', function() {
	var constants 			= require('../../../testConstants.json');
	var loginPage 			= require('../../../bellows/pages/loginPage.js');
	var util 				= require('../../../bellows/pages/util.js');
	var appFrame 			= require('../../../bellows/pages/appFrame.js');
	var projectListPage 	= require('../../../bellows/pages/projectsPage.js');
	var projectLayoutPage   = require('../../../bellows/pages/projectsLayoutPage.js');
	var projectPage 		= require('../../sfchecks/pages/projectPage.js');
	var projectLayout 		= require('../pages/projectLayoutPage.js');
	
	
	//describe('project member/user', function() {
	//	it('setup: logout, login as project member, go to project dashboard', function() {
	//		loginPage.logout();
	//		loginPage.loginAsMember();
	//	});
	//});
		
	describe('Layout page', function(){
		
		it("setup: login, go to layout page", function(){
			
			loginPage.loginAsMember();
			projectLayoutPage.get();
		});
	
		it('should have text: Inside Margin', function(){
			expect(projectLayout.innerMarginForm.isDisplayed()).toBe(true);
		});
		it('should have text: Outside Margin', function(){
			expect(projectLayout.innerMarginForm.isDisplayed()).toBe(true);
		});
		it('should have text: Top Margin', function(){
			expect(projectLayout.innerMarginForm.isDisplayed()).toBe(true);
		});
		it('should have text: Bottom Margin', function(){
			expect(projectLayout.innerMarginForm.isDisplayed()).toBe(true);
		});
		it('should set the values', function(){	
			projectLayout.innerMarginForm.clear().then(function(){
				projectLayout.innerMarginForm.sendKeys('80').then(function(){
					expect(projectLayout.marginDiv.isPresent()).toBe(true);
					expect(projectLayout.marginDiv.getCssValue('margin-right')).toBe('80px');
				});
			});
			
			projectLayout.outerMarginForm.clear().then(function(){
				projectLayout.outerMarginForm.sendKeys('30').then(function(){
					expect(projectLayout.marginDiv.isPresent()).toBe(true);
					expect(projectLayout.marginDiv.getCssValue('margin-left')).toBe('30px');
				});
			});
			
			projectLayout.topMarginForm.clear().then(function(){
				projectLayout.topMarginForm.sendKeys('60').then(function(){
					expect(projectLayout.marginDiv.isPresent()).toBe(true);
					expect(projectLayout.marginDiv.getCssValue('margin-top')).toBe('60px');
				});
			});
			
			projectLayout.bottomMarginForm.clear().then(function(){
				projectLayout.bottomMarginForm.sendKeys('150').then(function(){
					expect(projectLayout.marginDiv.isPresent()).toBe(true);
					expect(projectLayout.marginDiv.getCssValue('height')).toBe('190px');
				});
			});
		});
	});
});