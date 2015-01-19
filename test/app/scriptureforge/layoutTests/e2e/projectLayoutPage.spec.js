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
		
	describe('Layout page margins', function(){
		
		it("setup: login, go to layout page", function(){
			
			loginPage.loginAsMember();
			projectLayoutPage.get();
		});
	
		it('should have form: Inside Margin', function(){
			expect(projectLayout.innerMarginForm.isDisplayed()).toBe(true);
		});
		it('should have form: Outside Margin', function(){
			expect(projectLayout.innerMarginForm.isDisplayed()).toBe(true);
		});
		it('should have form: Top Margin', function(){
			expect(projectLayout.innerMarginForm.isDisplayed()).toBe(true);
		});
		it('should have form: Bottom Margin', function(){
			expect(projectLayout.innerMarginForm.isDisplayed()).toBe(true);
		});
		/*it('should set the values', function(){	
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
		});*/
		
		describe('Layout page columns', function(){
			it('should have columns tab', function(){
				expect(projectLayout.columnsTab.isPresent()).toBe(true);
				projectLayout.columnsTab.click();
			});
			
			it('should have checkbox: two body columns', function(){
				expect(projectLayout.pageColCheckbox.isDisplayed()).toBe(true);
				projectLayout.pageColCheckbox.click();
			});
			
			it('should have checkbox: two title columns', function(){
				expect(projectLayout.titleColCheckbox.isDisplayed()).toBe(true);
				projectLayout.titleColCheckbox.click();
			});
			
			it('should have checkbox: two intro columns', function(){
				expect(projectLayout.introColCheckbox.isDisplayed()).toBe(true);
				projectLayout.introColCheckbox.click();
			});
			
			it('should have checkbox: column rule', function(){
				expect(projectLayout.lineSeperatorCheckbox.isDisplayed()).toBe(true);
				projectLayout.lineSeperatorCheckbox.click();
			});
			
		});
		/*
		describe('Layout page header/footer', function(){
		
			it('should have header/footer tab', function(){
				expect(projectLayout.headFootTab.isPresent()).toBe(true);
				projectLayout.headFootTab.click();
			});
			
			it('should have header checkbox',function(){
				expect(projectLayout.headerCheckbox.isDisplayed()).toBe(true);
		
				projectLayout.headerCheckbox.click();
			});
			
			it('should have footer checkbox',function(){
				expect(projectLayout.footerCheckbox.isDisplayed()).toBe(true);
				
				projectLayout.footerCheckbox.click();
			});
			
			it('should have form: footer position', function(){
				expect(projectLayout.footerPosForm.isPresent()).toBe(true);
			});
			
			it('should have form: header position', function(){
				expect(projectLayout.headerPosForm.isPresent()).toBe(true);
			});
		});
		
			
		describe('Layout page printer options', function(){
			it('should have printerOptionTab', function(){
				expect(projectLayout.printerOptionTab.isPresent()).toBe(true);
				projectLayout.printerOptionTab.click();
			});
		});
			
		describe('Layout page background', function(){
			it('should have background tab', function(){
				expect(projectLayout.backgroundTab.isPresent()).toBe(true);
				projectLayout.backgroundTab.click();
			});
		});
			
		describe('Layout page body text', function(){
			it('should have bodyTextTab', function(){
				expect(projectLayout.bodyTextTab.isPresent()).toBe(true);
				projectLayout.bodyTextTab.click();
			});
		});
			
		describe('Layout page misc tab', function(){
			it('should have misc tab', function(){
				expect(projectLayout.miscTab.isPresent()).toBe(true);
				projectLayout.miscTab.click();
			});
		});*/
	});
});