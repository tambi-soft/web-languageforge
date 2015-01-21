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
		
		it('can expand dropbox to add a USFM zip', function() {
		  expect(assetsPage.sections.paraTextTexts.isDisplayed()).toBe(false);
		  assetsPage.addButtonList.first().click();
		  expect(assetsPage.sections.paraTextTexts.isDisplayed()).toBe(true);
		});
/*		
        it('can upload paraTExt zip file', function() {
        });

        describe('Mock file upload', function() {
          
          it('cannot upload large file', function() {
            assetsPage.mockUpload.enableButton.click();
            expect(assetsPage.mockUpload.fileNameInput.isPresent()).toBe(true);
            expect(assetsPage.mockUpload.fileNameInput.isDisplayed()).toBe(true);
            assetsPage.mockUpload.fileNameInput.sendKeys(constants.testMockZipImportFile.name);
            assetsPage.mockUpload.fileSizeInput.sendKeys(134217728);
            expect(assetsPage.noticeList.count()).toBe(0);
            assetsPage.mockUpload.uploadButton.click();
            expect(assetsPage.noticeList.count()).toBe(1);
            expect(assetsPage.noticeList.get(0).getText()).toContain('is too large. It must be smaller than');
            assetsPage.mockUpload.fileNameInput.clear();
            assetsPage.mockUpload.fileSizeInput.clear();
            browser.pause();
          });
/*        
          it('cannot upload jpg', function() {
            assetsPage.mockUpload.fileNameInput.sendKeys(constants.testMockJpgImportFile.name);
            assetsPage.mockUpload.fileSizeInput.sendKeys(constants.testMockJpgImportFile.size);
            expect(assetsPage.noticeList.count()).toBe(1);
            assetsPage.mockUpload.uploadButton.click();
            expect(assetsPage.initialDataPage.browseButton.isDisplayed()).toBe(true);
            expect(assetsPage.verifyDataPage.entriesImported.isPresent()).toBe(false);
            expect(assetsPage.noticeList.count()).toBe(2);
            expect(assetsPage.noticeList.get(1).getText()).toContain(constants.testMockJpgImportFile.name + ' is not an allowed compressed file. Ensure the file is');
            assetsPage.formStatus.expectHasNoError();
            assetsPage.mockUpload.fileNameInput.clear();
            assetsPage.mockUpload.fileSizeInput.clear();
            assetsPage.firstNoticeCloseButton.click();
            assetsPage.firstNoticeCloseButton.click();
          });

          it('can upload zip file', function() {
            assetsPage.mockUpload.fileNameInput.sendKeys(constants.testMockZipImportFile.name);
            assetsPage.mockUpload.fileSizeInput.sendKeys(constants.testMockZipImportFile.size);
            expect(assetsPage.noticeList.count()).toBe(0);
            assetsPage.mockUpload.uploadButton.click();
            expect(assetsPage.verifyDataPage.entriesImported.isDisplayed()).toBe(true);
            expect(assetsPage.noticeList.count()).toBe(1);
            expect(assetsPage.noticeList.get(0).getText()).toContain('Successfully imported ' + constants.testMockZipImportFile.name);
            assetsPage.formStatus.expectHasNoError();
          });
        
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
