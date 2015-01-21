'use strict';

describe('the layout page', function(){
    var constants           = require('../../../testConstants.json');
    var loginPage           = require('../../../bellows/pages/loginPage.js');
    var util                = require('../../../bellows/pages/util.js');
    var appFrame            = require('../../../bellows/pages/appFrame.js');
    var layoutSettingsPage     = require('../pages/layoutSettingsPage.js');


    describe('user', function(){
        //get to the page to run specific tests
        it('page navigation', function(){
            loginPage.logout();
            loginPage.loginAsMember();
            //TODO replace this with an official page navigation, not an absolute local reference
             browser.get('https://scriptureforge.local/app/webtypesetting/54adf50c25f225820b21ab74/#/layout');
        });
        
        
        it('has buttons', function(){
            expect(layoutSettingsPage.buttons.saveTemplate.isPresent()).toBe(true);
            expect(layoutSettingsPage.buttons.save.isPresent()).toBe(true);
            expect(layoutSettingsPage.buttons.loadTemplate.isPresent()).toBe(true);
            expect(layoutSettingsPage.buttons.load.isPresent()).toBe(true);
        });
        
        it("The save and load buttons are disabled when empty", function(){
          expect(layoutSettingsPage.buttons.load.isEnabled()).toBe(false);
          expect(layoutSettingsPage.buttons.save.isEnabled()).toBe(false);
        });
        
        it('has text fields', function(){
          expect(layoutSettingsPage.textBoxes.loadTemplateName.isPresent()).toBe(true);
          expect(layoutSettingsPage.textBoxes.saveTemplateName.isPresent()).toBe(true);
        });
        
        it("Shows and hides panelson on Template button clicks", function(){
          var ptor = protractor.getInstance();
          expect(layoutSettingsPage.textBoxes.saveTemplateName.isDisplayed()).toBe(false);
          layoutSettingsPage.buttons.saveTemplate.click();
          expect(layoutSettingsPage.textBoxes.saveTemplateName.isDisplayed()).toBe(true);
          layoutSettingsPage.buttons.saveTemplate.click();
          ptor.sleep(500);
          expect(layoutSettingsPage.textBoxes.saveTemplateName.isDisplayed()).toBe(false);
          
          
          expect(layoutSettingsPage.textBoxes.loadTemplateName.isDisplayed()).toBe(false);
          layoutSettingsPage.buttons.loadTemplate.click();
          expect(layoutSettingsPage.textBoxes.loadTemplateName.isDisplayed()).toBe(true);
          layoutSettingsPage.buttons.loadTemplate.click();
          ptor.sleep(500);
          expect(layoutSettingsPage.textBoxes.loadTemplateName.isDisplayed()).toBe(false);
        });
        
        it("enables buttons when the user types into the text boxes", function(){
          layoutSettingsPage.buttons.loadTemplate.click();
          layoutSettingsPage.textBoxes.loadTemplateName.sendKeys("Random Template Name");
          layoutSettingsPage.buttons.saveTemplate.click();
          layoutSettingsPage.textBoxes.saveTemplateName.sendKeys("Random Template Name");

          
          expect(layoutSettingsPage.buttons.load.isEnabled()).toBe(true);
          expect(layoutSettingsPage.buttons.save.isEnabled()).toBe(true);
        });
        
        
        
        
        //it('has slider navigation', function(){});
        


    });
});