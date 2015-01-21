describe('the assets settings page', function() {
	var constants 			= require('../../../testConstants.json');
	var loginPage 			= require('../../../bellows/pages/loginPage.js');
	var util 				= require('../../../bellows/pages/util.js');
	var projectListPage 	= require('../../../bellows/pages/projectsPage.js');
	var assetsPage			= require('../pages/assetSettingsPage.js');
	
	describe('admin', function() {
		
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


        describe('Mock file upload', function() {
          
          it('can upload zip file', function() {
        	assetsPage.mockUpload.enableButton.click();
            assetsPage.mockUpload.fileNameInput.sendKeys(constants.testMockTypesettingZipImportFile.name);
            assetsPage.mockUpload.fileSizeInput.sendKeys(constants.testMockTypesettingZipImportFile.size);
            expect(assetsPage.noticeList.count()).toBe(0);
            assetsPage.mockUpload.uploadButton.click();
            //expect(assetsPage.verifyDataPage.entriesImported.isDisplayed()).toBe(true);
            expect(assetsPage.noticeList.count()).toBe(1);
            expect(assetsPage.noticeList.get(0).getText()).toContain('File uploaded successfully');
            //expect(assetsPage.assets.paraTextTexts).toContain(constants.testMockTypesettingZipImportFile.name);
            //assetsPage.formStatus.expectHasNoError();
          });
          
/*          it('cannot upload large file', function() {
            assetsPage.mockUpload.enableButton.click();
            expect(assetsPage.mockUpload.fileNameInput.isPresent()).toBe(true);
            expect(assetsPage.mockUpload.fileNameInput.isDisplayed()).toBe(true);
            assetsPage.mockUpload.fileNameInput.sendKeys(constants.testMockTypesettingZipImportFile.name);
            assetsPage.mockUpload.fileSizeInput.sendKeys(134217728);
            expect(assetsPage.noticeList.count()).toBe(0);
            assetsPage.mockUpload.uploadButton.click();
            expect(assetsPage.noticeList.count()).toBe(1);
            expect(assetsPage.noticeList.get(0).getText()).toContain('is too large. It must be smaller than');
            assetsPage.mockUpload.fileNameInput.clear();
            assetsPage.mockUpload.fileSizeInput.clear();
            browser.pause();
          });
        
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
          });*/
        
        });
		
	});
	
});
