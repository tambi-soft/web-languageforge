'use strict';

function MockUploadElement(rootElement) {
  if (typeof (rootElement) === "undefined") {
    rootElement = element(by.css('body'));
  }

  this.enableButton = rootElement.element(by.css('.showMockUploadButton'));
  this.fileNameInput = rootElement.element(by.css('.mockFileName'));
  this.fileSizeInput = rootElement.element(by.css('.mockFileSize'));
  this.uploadButton = rootElement.element(by.css('.mockUploadButton'));
};

module.exports = MockUploadElement;
