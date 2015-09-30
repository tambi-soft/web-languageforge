'use strict';

var SfLayoutSettingsPage = function() {

  this.navigation = {
      layout: element(by.cssContainingText('here', 'projectSetupLayout')),
  };

  this.buttons = {
      saveTemplate: element(by.partialButtonText('Save Template')),
      save: element(by.id('save')),
      loadTemplate: element(by.partialButtonText('Load Template')),
      load: element(by.id('load')),
  };

  this.textBoxes= {
      saveTemplateName: element(by.id("saveTemplateName")),
      loadTemplateName: element(by.id("loadTemplateName")),
  };

};

module.exports = new SfLayoutSettingsPage();