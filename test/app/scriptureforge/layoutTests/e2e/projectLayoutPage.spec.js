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
	
		it('should have form: Inside Margin with default value 10', function(){
			expect(projectLayout.innerMarginForm.isDisplayed()).toBe(true);
			expect(projectLayout.innerMarginForm.getAttribute('value')).toBe('10');
			
		});
		it('should have form: Outside Margin with default value 10', function(){
			expect(projectLayout.outerMarginForm.isDisplayed()).toBe(true);
			expect(projectLayout.outerMarginForm.getAttribute('value')).toBe('10');
		});
		it('should have form: Top Margin with default value 15', function(){
			expect(projectLayout.topMarginForm.isDisplayed()).toBe(true);
			expect(projectLayout.topMarginForm.getAttribute('value')).toBe('15');
		});
		it('should have form: Bottom Margin with default value 10', function(){
			expect(projectLayout.bottomMarginForm.isDisplayed()).toBe(true);
			expect(projectLayout.bottomMarginForm.getAttribute('value')).toBe('10');
		});
		it('changing inner margin changes the css of the example box', function(){	
			projectLayout.innerMarginForm.clear().then(function(){
				projectLayout.innerMarginForm.sendKeys('80').then(function(){
					expect(projectLayout.marginDiv.isPresent()).toBe(true);
					expect(projectLayout.marginDiv.getCssValue('margin-right')).toBe('80px');
				});
			});
		});
			
		it('changing outer margin changes the css of the example box', function(){	
			projectLayout.outerMarginForm.clear().then(function(){
				projectLayout.outerMarginForm.sendKeys('30').then(function(){
					expect(projectLayout.marginDiv.isPresent()).toBe(true);
					expect(projectLayout.marginDiv.getCssValue('margin-left')).toBe('30px');
				});
			});
		});
		
		it('changing top margin changes the css of the example box', function(){	
			projectLayout.topMarginForm.clear().then(function(){
				projectLayout.topMarginForm.sendKeys('60').then(function(){
					expect(projectLayout.marginDiv.isPresent()).toBe(true);
					expect(projectLayout.marginDiv.getCssValue('margin-top')).toBe('60px');
				});
			});
		});
		
		it('changing bottom margin changes the css of the example box', function(){	
			projectLayout.bottomMarginForm.clear().then(function(){
				projectLayout.bottomMarginForm.sendKeys('150').then(function(){
					expect(projectLayout.marginDiv.isPresent()).toBe(true);
					expect(projectLayout.marginDiv.getCssValue('height')).toBe('190px');
				});
			});
		});
		
		describe('Layout page columns', function(){
			it('should have columns tab', function(){
				expect(projectLayout.columnsTab.isPresent()).toBe(true);
				projectLayout.columnsTab.click();
			});
			
			it('should have checkbox: two body columns checked by default', function(){
				expect(projectLayout.twoBodyColCB.isDisplayed()).toBe(true);
				expect(projectLayout.twoBodyColCB.getAttribute('checked')).toBe('true');
				projectLayout.twoBodyColCB.click();
			});
			
			it('should have checkbox: two title columns unchecked by default', function(){
				expect(projectLayout.twoTitleColCB.isDisplayed()).toBe(true);
				expect(projectLayout.twoTitleColCB.getAttribute('checked')).toBe(null);
				projectLayout.twoTitleColCB.click();
			});
			
			it('should have checkbox: two intro columns unchecked by default', function(){
				expect(projectLayout.TwoIntroColCB.isDisplayed()).toBe(true);
				expect(projectLayout.TwoIntroColCB.getAttribute('checked')).toBe(null);
				projectLayout.TwoIntroColCB.click();
			});
			
			it('should have checkbox: column rule unchecked by default', function(){
				expect(projectLayout.ColRuleCB.isDisplayed()).toBe(true);
				expect(projectLayout.ColRuleCB.getAttribute('checked')).toBe(null);
				projectLayout.ColRuleCB.click();
			});
			
		});
		
		describe('Layout page header', function(){
		
			it('should have header tab', function(){
				expect(projectLayout.headerTab.isPresent()).toBe(true);
				projectLayout.headerTab.click();
			});
			
			it('should have running header checkbox checked by default',function(){
				expect(projectLayout.runningHeadCB.isDisplayed()).toBe(true);
				expect(projectLayout.runningHeadCB.getAttribute('checked')).toBe('true');
				projectLayout.runningHeadCB.click();
			});
			
			it('should have running header rule checkbox unchecked by default',function(){
				expect(projectLayout.runningHeadRuleCB.isDisplayed()).toBe(true);
				expect(projectLayout.runningHeadRuleCB.getAttribute('checked')).toBe(null);
				projectLayout.runningHeadRuleCB.click();
			});
			
			it('should have form: header position with default value: 5', function(){
				expect(projectLayout.headerPosForm.isPresent()).toBe(true);
				expect(projectLayout.headerPosForm.getAttribute('value')).toBe('5');
			});
			
			it('should have form: header rule with default value 4', function(){
				expect(projectLayout.runningHeaderRuleForm.isPresent()).toBe(true);
				expect(projectLayout.runningHeaderRuleForm.getAttribute('value')).toBe('4');
			});
			
			it('should have omit chapter number running header checkbox unchecked by default',function(){
				expect(projectLayout.omitChapNumRunHeadCB.isDisplayed()).toBe(true);
				expect(projectLayout.omitChapNumRunHeadCB.getAttribute('checked')).toBe(null);
				projectLayout.omitChapNumRunHeadCB.click();
			});
			
			it('should have form: running header title left with default value empty', function(){
				expect(projectLayout.runningHeadTitleLeftForm.isPresent()).toBe(true);
				expect(projectLayout.runningHeadTitleLeftForm.getAttribute('value')).toBe('empty');

			});
			
			it('should have form: running header title center with default value empty', function(){
				expect(projectLayout.runningHeadTitleCenterForm.isPresent()).toBe(true);
				expect(projectLayout.runningHeadTitleCenterForm.getAttribute('value')).toBe('empty');

			});
			
			it('should have form: running header title right with default value empty', function(){
				expect(projectLayout.runningHeadTitleRightForm.isPresent()).toBe(true);
				expect(projectLayout.runningHeadTitleRightForm.getAttribute('value')).toBe('empty');

			});
			
			it('should have show verse reference checkbox checked by default',function(){
				expect(projectLayout.showVerseRefCB.isDisplayed()).toBe(true);
				expect(projectLayout.showVerseRefCB.getAttribute('checked')).toBe('true');
				projectLayout.showVerseRefCB.click();
			});
			
			it('should have omit book reference checkbox unchecked by default',function(){
				expect(projectLayout.omitBookRefCB.isDisplayed()).toBe(true);
				expect(projectLayout.omitBookRefCB.getAttribute('checked')).toBe(null);
				projectLayout.omitBookRefCB.click();
			});
			
			it('should have form: running header even left with default value firstref', function(){
				expect(projectLayout.runningHeadevenLeftForm.isPresent()).toBe(true);
				expect(projectLayout.runningHeadevenLeftForm.getAttribute('value')).toBe('firstref');
			});
			
			it('should have form: running header even center with default value pagenumber', function(){
				expect(projectLayout.runningHeadevenCenterForm.isPresent()).toBe(true);
				expect(projectLayout.runningHeadevenCenterForm.getAttribute('value')).toBe('pagenumber');
			});
			
			it('should have form: running header even right with default value empty', function(){
				expect(projectLayout.runningHeadevenRightForm.isPresent()).toBe(true);
				expect(projectLayout.runningHeadevenRightForm.getAttribute('value')).toBe('empty');
			});
			
			it('should have form: running header odd left with default value empty', function(){
				expect(projectLayout.runningHeadOddLeftForm.isPresent()).toBe(true);
				expect(projectLayout.runningHeadOddLeftForm.getAttribute('value')).toBe('empty');
			});
			
			it('should have form: running header odd center with default value ppagenumber', function(){
				expect(projectLayout.runningHeadOddCenterForm.isPresent()).toBe(true);
				expect(projectLayout.runningHeadOddCenterForm.getAttribute('value')).toBe('pagenumber');
			});
			
			it('should have form: running header odd right with default value lastref', function(){
				expect(projectLayout.runningHeadOddRightForm.isPresent()).toBe(true);
				expect(projectLayout.runningHeadOddRightForm.getAttribute('value')).toBe('lastref');
			});
		});
		
		/*
		describe('Layout page footer', function(){
			it('should have footer tab', function(){
				expect(projectLayout.footerTab.isPresent()).toBe(true);
				projectLayout.footerTab.click();
			});
			
			it('should have running footer checkbox',function(){
				expect(projectLayout.runningFootCB.isDisplayed()).toBe(true);
		
				projectLayout.runningFootCB.click();
			});
			
			it('should have footenote rule checkbox',function(){
				expect(projectLayout.footnoteRuleCB.isDisplayed()).toBe(true);
		
				projectLayout.footnoteRuleCB.click();
			});
			
			it('should have reset page callers footnotes checkbox',function(){
				expect(projectLayout.resetPageCallFootCB.isDisplayed()).toBe(true);
		
				projectLayout.resetPageCallFootCB.click();
			});
			
			it('should have omit callers in footnotes checkbox',function(){
				expect(projectLayout.omitCallInFoot.isDisplayed()).toBe(true);
		
				projectLayout.omitCallInFoot.click();
			});
			
			it('should have use special caller in footnotes checkbox',function(){
				expect(projectLayout.useSpecialCallFootCB.isDisplayed()).toBe(true);
		
				projectLayout.useSpecialCallFootCB.click();
			});
			
			it('should have paragraphed footnotes checkbox',function(){
				expect(projectLayout.paragFootCB.isDisplayed()).toBe(true);
		
				projectLayout.paragFootCB.click();
			});
			
			it('should have use numerical callers footnotes checkbox',function(){
				expect(projectLayout.useNumCallFootCB.isDisplayed()).toBe(true);
		
				projectLayout.useNumCallFootCB.click();
			});
			
			it('should have form: footer position', function(){
				expect(projectLayout.footPosForm.isPresent()).toBe(true);
			});
			
			it('should have form: special caller footnotes', function(){
				expect(projectLayout.specialCallFootForm.isPresent()).toBe(true);
			});
		});
		
		
		/*	
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