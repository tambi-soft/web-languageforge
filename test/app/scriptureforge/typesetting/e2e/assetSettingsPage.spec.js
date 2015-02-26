describe('the assets settings page', function() {
  var constants       = require('../../../testConstants.json');
  var loginPage       = require('../../../bellows/pages/loginPage.js');
  var util            = require('../../../bellows/pages/util.js');
  var projectListPage = require('../../../bellows/pages/projectsPage.js');
  var assetsPage      = require('../pages/assetSettingsPage.js');
  
  it('setup: logout, login as admin, navigate to assets settings page', function() {
    loginPage.logout();
    loginPage.loginAsAdmin();
      projectListPage.get();
      projectListPage.clickOnProject(constants.typesettingProjectName);
      assetsPage.get();
      expect(assetsPage.title.getInnerHtml()).toEqual('Assets Settings');
  });
  
  it('can expand dropbox to add a USFM zip', function() {
    expect(assetsPage.paraTextTexts.dropBox.isDisplayed()).toBe(false);
    assetsPage.paraTextTexts.addButton.click();
    expect(assetsPage.paraTextTexts.dropBox.isDisplayed()).toBe(true);
  });

  describe('Mock file upload', function() {
    
    it('can upload zip file', function() {
      assetsPage.paraTextTexts.mockUpload.enableButton.click();
      assetsPage.paraTextTexts.mockUpload.fileNameInput.sendKeys(constants.testMockTypesettingZipImportFile.name);
      assetsPage.paraTextTexts.mockUpload.fileSizeInput.sendKeys(constants.testMockTypesettingZipImportFile.size);
      expect(assetsPage.noticeList.count()).toBe(0);
      assetsPage.paraTextTexts.mockUpload.uploadButton.click();
      expect(assetsPage.noticeList.count()).toBe(1);
      expect(assetsPage.noticeList.get(0).getText()).toContain('File uploaded successfully');
      expect(assetsPage.paraTextTexts.assetFilename.getText()).toContain(constants.testMockTypesettingZipImportFile.name);
    });
/*    
    it('cannot upload large file', function() {
      assetsPage.paraTextTexts.mockUpload.enableButton.click();
      expect(assetsPage.paraTextTexts.mockUpload.fileNameInput.isPresent()).toBe(true);
      expect(assetsPage.paraTextTexts.mockUpload.fileNameInput.isDisplayed()).toBe(true);
      assetsPage.paraTextTexts.mockUpload.fileNameInput.sendKeys(constants.testMockTypesettingZipImportFile.name);
      assetsPage.paraTextTexts.mockUpload.fileSizeInput.sendKeys(134217728);
      expect(assetsPage.noticeList.count()).toBe(0);
      assetsPage.paraTextTexts.mockUpload.uploadButton.click();
      expect(assetsPage.noticeList.count()).toBe(1);
      expect(assetsPage.noticeList.get(0).getText()).toContain('is too large. It must be smaller than');
      assetsPage.paraTextTexts.mockUpload.fileNameInput.clear();
      assetsPage.paraTextTexts.mockUpload.fileSizeInput.clear();
    });
  
    it('cannot upload jpg', function() {
      assetsPage.paraTextTexts.mockUpload.fileNameInput.sendKeys(constants.testMockJpgImportFile.name);
      assetsPage.paraTextTexts.mockUpload.fileSizeInput.sendKeys(constants.testMockJpgImportFile.size);
      expect(assetsPage.noticeList.count()).toBe(1);
      assetsPage.paraTextTexts.mockUpload.uploadButton.click();
      expect(assetsPage.noticeList.count()).toBe(2);
      expect(assetsPage.noticeList.get(1).getText()).toContain(constants.testMockJpgImportFile.name + ' is not an allowed compressed file. Ensure the file is');
      assetsPage.paraTextTexts.mockUpload.fileNameInput.clear();
      assetsPage.paraTextTexts.mockUpload.fileSizeInput.clear();
      assetsPage.firstNoticeCloseButton.click();
      assetsPage.firstNoticeCloseButton.click();
    });
*/  
  });
  
});
