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
		
		it('should have Input: Inside Margin with default value 10', function(){
			expect(projectLayout.innerMarginInput.isDisplayed()).toBe(true);
			expect(projectLayout.innerMarginInput.getAttribute('value')).toBe('10');
			
		});
		it('should have Input: Outside Margin with default value 10', function(){
			expect(projectLayout.outerMarginInput.isDisplayed()).toBe(true);
			expect(projectLayout.outerMarginInput.getAttribute('value')).toBe('10');
		});
		it('should have Input: Top Margin with default value 15', function(){
			expect(projectLayout.topMarginInput.isDisplayed()).toBe(true);
			expect(projectLayout.topMarginInput.getAttribute('value')).toBe('15');
		});
		it('should have Input: Bottom Margin with default value 10', function(){
			expect(projectLayout.bottomMarginInput.isDisplayed()).toBe(true);
			expect(projectLayout.bottomMarginInput.getAttribute('value')).toBe('10');
		});
		it('changing inner margin changes the css of the example box', function(){	
			projectLayout.innerMarginInput.clear().then(function(){
				projectLayout.innerMarginInput.sendKeys('80').then(function(){
					expect(projectLayout.marginDiv.isPresent()).toBe(true);
					expect(projectLayout.marginDiv.getCssValue('margin-right')).toBe('80px');
				});
			});
		});
			
		it('changing outer margin changes the css of the example box', function(){	
			projectLayout.outerMarginInput.clear().then(function(){
				projectLayout.outerMarginInput.sendKeys('30').then(function(){
					expect(projectLayout.marginDiv.isPresent()).toBe(true);
					expect(projectLayout.marginDiv.getCssValue('margin-left')).toBe('30px');
				});
			});
		});
		
		it('changing top margin changes the css of the example box', function(){	
			projectLayout.topMarginInput.clear().then(function(){
				projectLayout.topMarginInput.sendKeys('60').then(function(){
					expect(projectLayout.marginDiv.isPresent()).toBe(true);
					expect(projectLayout.marginDiv.getCssValue('margin-top')).toBe('60px');
				});
			});
		});
		
		it('changing bottom margin changes the css of the example box', function(){	
			projectLayout.bottomMarginInput.clear().then(function(){
				projectLayout.bottomMarginInput.sendKeys('150').then(function(){
					expect(projectLayout.marginDiv.isPresent()).toBe(true);
					expect(projectLayout.marginDiv.getCssValue('height')).toBe('190px');
				});
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
		
		it('should have Input: column gutter rule skip with default value 0', function(){
			expect(projectLayout.colGutRuleSkipInput.isPresent()).toBe(true);
			expect(projectLayout.colGutRuleSkipInput.getAttribute('value')).toBe('0');
		});
		
		it('should have Input: column shift with default value 5', function(){
			expect(projectLayout.colShiftInput.isPresent()).toBe(true);
			expect(projectLayout.colShiftInput.getAttribute('value')).toBe('5');
		});
		
		it('should have Input: column gutter factor with default value 15', function(){
			expect(projectLayout.colGutFactorInput.isPresent()).toBe(true);
			expect(projectLayout.colGutFactorInput.getAttribute('value')).toBe('15');
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
		
		it('should have running header rule checkbox unchecked by default' ,function(){
			expect(projectLayout.runningHeadRuleCB.isDisplayed()).toBe(true);
			expect(projectLayout.runningHeadRuleCB.getAttribute('checked')).toBe(null);
			
			expect(projectLayout.runningHeadRuleInput.getAttribute('disabled')).toEqual('true');
			projectLayout.runningHeadRuleCB.click();
			expect(projectLayout.runningHeadRuleInput.getAttribute('disabled')).toEqual(null);
		});
		it('should have running header rule checkbox input with default value 4 when box is checked' ,function(){
			expect(projectLayout.runningHeadRuleInput.getAttribute('value')).toEqual('4');
		});
		
		it('should have Input: header position with default value: 5', function(){
			expect(projectLayout.headerPosInput.isPresent()).toBe(true);
			expect(projectLayout.headerPosInput.getAttribute('value')).toBe('5');
		});
		
		it('should have Input: header rule with default value 4', function(){
			expect(projectLayout.runningHeaderRuleInput.isPresent()).toBe(true);
			expect(projectLayout.runningHeaderRuleInput.getAttribute('value')).toBe('4');
		});
		
		it('should have omit chapter number running header checkbox unchecked by default',function(){
			expect(projectLayout.omitChapNumRunHeadCB.isDisplayed()).toBe(true);
			expect(projectLayout.omitChapNumRunHeadCB.getAttribute('checked')).toBe(null);
			projectLayout.omitChapNumRunHeadCB.click();
		});
		
		it('should have Input: running header title left with default value empty', function(){
			expect(projectLayout.runningHeadTitleLeftInput.isPresent()).toBe(true);
			expect(projectLayout.runningHeadTitleLeftInput.getAttribute('value')).toBe('empty');

		});
		
		it('should have Input: running header title center with default value empty', function(){
			expect(projectLayout.runningHeadTitleCenterInput.isPresent()).toBe(true);
			expect(projectLayout.runningHeadTitleCenterInput.getAttribute('value')).toBe('empty');

		});
		
		it('should have Input: running header title right with default value empty', function(){
			expect(projectLayout.runningHeadTitleRightInput.isPresent()).toBe(true);
			expect(projectLayout.runningHeadTitleRightInput.getAttribute('value')).toBe('empty');

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
		
		it('should have Input: running header even left with default value firstref', function(){
			expect(projectLayout.runningHeadevenLeftInput.isPresent()).toBe(true);
			expect(projectLayout.runningHeadevenLeftInput.getAttribute('value')).toBe('firstref');
		});
		
		it('should have Input: running header even center with default value pagenumber', function(){
			expect(projectLayout.runningHeadevenCenterInput.isPresent()).toBe(true);
			expect(projectLayout.runningHeadevenCenterInput.getAttribute('value')).toBe('pagenumber');
		});
		
		it('should have Input: running header even right with default value empty', function(){
			expect(projectLayout.runningHeadevenRightInput.isPresent()).toBe(true);
			expect(projectLayout.runningHeadevenRightInput.getAttribute('value')).toBe('empty');
		});
		
		it('should have Input: running header odd left with default value empty', function(){
			expect(projectLayout.runningHeadOddLeftInput.isPresent()).toBe(true);
			expect(projectLayout.runningHeadOddLeftInput.getAttribute('value')).toBe('empty');
		});
		
		it('should have Input: running header odd center with default value ppagenumber', function(){
			expect(projectLayout.runningHeadOddCenterInput.isPresent()).toBe(true);
			expect(projectLayout.runningHeadOddCenterInput.getAttribute('value')).toBe('pagenumber');
		});
		
		it('should have Input: running header odd right with default value lastref', function(){
			expect(projectLayout.runningHeadOddRightInput.isPresent()).toBe(true);
			expect(projectLayout.runningHeadOddRightInput.getAttribute('value')).toBe('lastref');
		});
	});
	
	
	describe('Layout page footer', function(){
		it('should have footer tab', function(){
			expect(projectLayout.footerTab.isPresent()).toBe(true);
			projectLayout.footerTab.click();
		});
		
		it('should running footer checkbox unchecked by default',function(){
			expect(projectLayout.runningFootCB.isDisplayed()).toBe(true);
			expect(projectLayout.runningFootCB.getAttribute('checked')).toBe(null);
			projectLayout.runningFootCB.click();
		});
		
		it('should have Input: footer position with default value 5', function(){
			expect(projectLayout.footPosInput.isPresent()).toBe(true);
			expect(projectLayout.footPosInput.getAttribute('value')).toBe('5');
		});
		
		it('should have Input: runningFooterTitleLeftInput with default value empty', function(){
			expect(projectLayout.runningFootTitleLeftInput.isPresent()).toBe(true);
			expect(projectLayout.runningFootTitleLeftInput.getAttribute('value')).toBe('empty');
		});
		
		it('should have Input: runningFootTitleCenterInput with default value empty', function(){
			expect(projectLayout.runningFootTitleCenterInput.isPresent()).toBe(true);
			expect(projectLayout.runningFootTitleCenterInput.getAttribute('value')).toBe('empty');
		});
		
		it('should have Input: runningFootTitleRightInput with default value empty', function(){
			expect(projectLayout.runningFootTitleRightInput.isPresent()).toBe(true);
			expect(projectLayout.runningFootTitleRightInput.getAttribute('value')).toBe('empty');
		});
		
		it('should have Input: runningFooterEvenLeftInput with default value empty', function(){
			expect(projectLayout.runningFootEvenLeftInput.isPresent()).toBe(true);
			expect(projectLayout.runningFootEvenLeftInput.getAttribute('value')).toBe('empty');
		});
		
		it('should have Input: runningFooterEvenCenterInput with default value empty', function(){
			expect(projectLayout.runningFootEvenCenterInput.isPresent()).toBe(true);
			expect(projectLayout.runningFootEvenCenterInput.getAttribute('value')).toBe('empty');
		});
		
		it('should have Input: runningFooterEvenRightInput with default value empty', function(){
			expect(projectLayout.runningFootEvenRightInput.isPresent()).toBe(true);
			expect(projectLayout.runningFootEvenRightInput.getAttribute('value')).toBe('empty');
		});
		
		it('should have Input: runningFooterOddLeftInput with default value empty', function(){
			expect(projectLayout.runningFootOddLeftInput.isPresent()).toBe(true);
			expect(projectLayout.runningFootOddLeftInput.getAttribute('value')).toBe('empty');
		});
		
		it('should have Input: runningFooterOddCenterInput with default value empty', function(){
			expect(projectLayout.runningFootOddCenterInput.isPresent()).toBe(true);
			expect(projectLayout.runningFootOddCenterInput.getAttribute('value')).toBe('empty');
		});
		
		it('should have Input: runningFooterOddRightInput with default value empty', function(){
			expect(projectLayout.runningFootOddRightInput.isPresent()).toBe(true);
			expect(projectLayout.runningFootOddRightInput.getAttribute('value')).toBe('empty');
		});
	});
	
	describe('Layout page footnote', function(){
		it('should have footnote tab', function(){
			expect(projectLayout.footnoteTab.isPresent()).toBe(true);
			projectLayout.footnoteTab.click();
		}); 
		
		it('should have special caller footnotes checkbox unchecked by default',function(){
			expect(projectLayout.specialCallerFootCB.isDisplayed()).toBe(true);
			expect(projectLayout.specialCallerFootCB.getAttribute('checked')).toBe(null);
		});
		
		it('should have Input: special caller footnotes unavailable when unchecked', function(){
			expect(projectLayout.specialCallFootInput.getAttribute('disabled')).toEqual('true');
		});
		it('should have Input: special caller footnotes available when checked', function(){
			projectLayout.specialCallerFootCB.click();
			expect(projectLayout.specialCallFootInput.getAttribute('disabled')).toEqual(null);
		});
		
		it('should have paragraph footnotes checkbox checked by default',function(){
			expect(projectLayout.paragFootnotesCB.isDisplayed()).toBe(true);
			expect(projectLayout.paragFootnotesCB.getAttribute('checked')).toBe('true');
		});
		
		it('should have use numeric callers footnotes checkbox unchecked by default',function(){
			expect(projectLayout.useNumCallFootCB.isDisplayed()).toBe(true);
			expect(projectLayout.useNumCallFootCB.getAttribute('checked')).toBe(null);
		});
		
		it('should have footnote rule checkbox checked by default',function(){
			expect(projectLayout.footnoteRuleCB.isDisplayed()).toBe(true);
			expect(projectLayout.footnoteRuleCB.getAttribute('checked')).toBe('true');
		});
		
		it('should have reset page callers footnotes checkbox unchecked by default',function(){
			expect(projectLayout.resetPageCallFootCB.isDisplayed()).toBe(true);
			expect(projectLayout.resetPageCallFootCB.getAttribute('checked')).toBe(null);
		});
		
		it('should have omit caller in footnotes checkbox unchecked by default',function(){
			expect(projectLayout.omitCallInFootCB.isDisplayed()).toBe(true);
			expect(projectLayout.omitCallInFootCB.getAttribute('checked')).toBe(null);
		});
	});
});