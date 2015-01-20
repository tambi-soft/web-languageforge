describe('the project dashboard AKA text list page', function() {
	var constants 			= require('../../../testConstants.json');
	var loginPage 			= require('../../../bellows/pages/loginPage.js');
	var util 				= require('../../../bellows/pages/util.js');
	var projectListPage 	= require('../../../bellows/pages/projectsPage.js');
	var assetsPage			= require('../pages/assetSettingsPage.js');
	
	describe('project manager', function() {
		
		it('setup: logout, login as admin, navigate to assets settings page', function() {
			loginPage.logout();
			loginPage.loginAsAdmin();
	    	projectListPage.get();
	    	projectListPage.clickOnProject(constants.typesettingProjectName);
	    	assetsPage.get();
	    	expect(assetsPage.title.getInnerHtml()).toEqual('Assets Settings');
		});
/*		
		it('can upload paraTExt zip file', function() {
		  assetsPage.addButtonList.first().click();
		});
		
		
/*		it('can add a new paraTExt file', function() {
			expect(projectPage.newText.showFormButton.isDisplayed()).toBe(true);
			projectPage.newText.showFormButton.click();
			projectPage.newText.title.sendKeys(sampleTitle);
			projectPage.newText.usx.sendKeys(projectPage.testData.simpleUsx1);
			projectPage.newText.saveButton.click();
			expect(projectPage.textLink(sampleTitle).isDisplayed()).toBe(true);
		});*/
		
	});
	
});