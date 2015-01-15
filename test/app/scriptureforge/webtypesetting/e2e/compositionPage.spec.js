'use strict';

describe('the composition page', function(){
	var constants 			= require('../../../testConstants.json');
	var loginPage 			= require('../../../bellows/pages/loginPage.js');
	var util 				= require('../../../bellows/pages/util.js');
	var appFrame 			= require('../../../bellows/pages/appFrame.js');
	var compositionPage		= require('../pages/compositionPage.js');


	describe('user', function(){
		//get to the page to run specific tests
		it('page navigation', function(){
			loginPage.logout();
			loginPage.loginAsMember();
			//probably replace this with an official page navigation, not an absolute local reference
			 browser.get('https://scriptureforge.local/app/webtypesetting/54adf50c25f225820b21ab74/#/composition');
			 
		});
		
		
		it('has page navigation', function(){
			expect(true).toBe(true);
			expect(compositionPage.slider.pageInput.isPresent()).toBe(true);
		});
		
		//it('has slider navigation', function(){});
		


	});
});