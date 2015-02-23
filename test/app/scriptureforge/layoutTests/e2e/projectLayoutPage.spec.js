'use strict';

describe('the project dashboard AKA text list page', function() {
  var constants       = require('../../../testConstants.json');
  var loginPage       = require('../../../bellows/pages/loginPage.js');
  var util         = require('../../../bellows/pages/util.js');
  var appFrame       = require('../../../bellows/pages/appFrame.js');
  var projectListPage   = require('../../../bellows/pages/projectsPage.js');
  var projectLayoutPage   = require('../../../bellows/pages/projectsLayoutPage.js');
  var projectPage     = require('../../sfchecks/pages/projectPage.js');
  var projectLayout     = require('../pages/projectLayoutPage.js');
  

  
  describe('Layout page margins', function(){
    /*it("setup: login, go to layout page", function(){
      loginPage.logout();
      loginPage.loginAsMember();
      projectLayoutPage.get();
    });*/
    
    it("setup: login, go to layout page", function(){
      loginPage.logout();
      loginPage.loginAsAdmin();
        projectListPage.get();
        projectListPage.clickOnProject(constants.typesettingProjectName);
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
      expect(projectLayout.runningHeadTitleLeftInput.getAttribute('value')).toBe('0');

    });
    
    it('should have Input: running header title center with default value empty', function(){
      expect(projectLayout.runningHeadTitleCenterInput.isPresent()).toBe(true);
      expect(projectLayout.runningHeadTitleCenterInput.getAttribute('value')).toBe('0');

    });
    
    it('should have Input: running header title right with default value empty', function(){
      expect(projectLayout.runningHeadTitleRightInput.isPresent()).toBe(true);
      expect(projectLayout.runningHeadTitleRightInput.getAttribute('value')).toBe('0');

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
      expect(projectLayout.runningHeadevenLeftInput.getAttribute('value')).toBe('3');
    });
    
    it('should have Input: running header even center with default value pagenumber', function(){
      expect(projectLayout.runningHeadevenCenterInput.isPresent()).toBe(true);
      expect(projectLayout.runningHeadevenCenterInput.getAttribute('value')).toBe('5');
    });
    
    it('should have Input: running header even right with default value empty', function(){
      expect(projectLayout.runningHeadevenRightInput.isPresent()).toBe(true);
      expect(projectLayout.runningHeadevenRightInput.getAttribute('value')).toBe('0');
    });
    
    it('should have Input: running header odd left with default value empty', function(){
      expect(projectLayout.runningHeadOddLeftInput.isPresent()).toBe(true);
      expect(projectLayout.runningHeadOddLeftInput.getAttribute('value')).toBe('0');
    });
    
    it('should have Input: running header odd center with default value pagenumber', function(){
      expect(projectLayout.runningHeadOddCenterInput.isPresent()).toBe(true);
      expect(projectLayout.runningHeadOddCenterInput.getAttribute('value')).toBe('5');
    });
    
    it('should have Input: running header odd right with default value lastref', function(){
      expect(projectLayout.runningHeadOddRightInput.isPresent()).toBe(true);
      expect(projectLayout.runningHeadOddRightInput.getAttribute('value')).toBe('4');
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
      expect(projectLayout.runningFootTitleLeftInput.getAttribute('value')).toBe('0');
    });
    
    it('should have Input: runningFootTitleCenterInput with default value empty', function(){
      expect(projectLayout.runningFootTitleCenterInput.isPresent()).toBe(true);
      expect(projectLayout.runningFootTitleCenterInput.getAttribute('value')).toBe('0');
    });
    
    it('should have Input: runningFootTitleRightInput with default value empty', function(){
      expect(projectLayout.runningFootTitleRightInput.isPresent()).toBe(true);
      expect(projectLayout.runningFootTitleRightInput.getAttribute('value')).toBe('0');
    });
    
    it('should have Input: runningFooterEvenLeftInput with default value empty', function(){
      expect(projectLayout.runningFootEvenLeftInput.isPresent()).toBe(true);
      expect(projectLayout.runningFootEvenLeftInput.getAttribute('value')).toBe('0');
    });
    
    it('should have Input: runningFooterEvenCenterInput with default value empty', function(){
      expect(projectLayout.runningFootEvenCenterInput.isPresent()).toBe(true);
      expect(projectLayout.runningFootEvenCenterInput.getAttribute('value')).toBe('0');
    });
    
    it('should have Input: runningFooterEvenRightInput with default value empty', function(){
      expect(projectLayout.runningFootEvenRightInput.isPresent()).toBe(true);
      expect(projectLayout.runningFootEvenRightInput.getAttribute('value')).toBe('0');
    });
    
    it('should have Input: runningFooterOddLeftInput with default value empty', function(){
      expect(projectLayout.runningFootOddLeftInput.isPresent()).toBe(true);
      expect(projectLayout.runningFootOddLeftInput.getAttribute('value')).toBe('0');
    });
    
    it('should have Input: runningFooterOddCenterInput with default value empty', function(){
      expect(projectLayout.runningFootOddCenterInput.isPresent()).toBe(true);
      expect(projectLayout.runningFootOddCenterInput.getAttribute('value')).toBe('0');
    });
    
    it('should have Input: runningFooterOddRightInput with default value empty', function(){
      expect(projectLayout.runningFootOddRightInput.isPresent()).toBe(true);
      expect(projectLayout.runningFootOddRightInput.getAttribute('value')).toBe('0');
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
  
  describe('cross reference page', function(){
    it('should have cross reference tab', function(){
      expect(projectLayout.crossrefTab.isPresent()).toBe(true);
      projectLayout.crossrefTab.click();
    }); 
    
    it('should have special caller crossref checkbox unchecked by default',function(){
      expect(projectLayout.specCallCrossrefCB.isDisplayed()).toBe(true);
      expect(projectLayout.specCallCrossrefCB.getAttribute('checked')).toBe(null);
    });
    
    it('should have use auto caller crossref checkbox checked by default',function(){
      expect(projectLayout.useAutoXCallCrossrefCB.isDisplayed()).toBe(true);
      expect(projectLayout.useAutoXCallCrossrefCB.getAttribute('checked')).toBe('true');
    });
    
    it('should have omit caller in crossref checkbox unchecked by default',function(){
      expect(projectLayout.omitCallInCrossrefCB.isDisplayed()).toBe(true);
      expect(projectLayout.omitCallInCrossrefCB.getAttribute('checked')).toBe(null);
    });
    
    it('should have paragraph crossref checkbox checked by default',function(){
      expect(projectLayout.paragCrossrefCB.isDisplayed()).toBe(true);
      expect(projectLayout.paragCrossrefCB.getAttribute('checked')).toBe('true');
    });
    
    it('should have use numeric caller crossref checkbox unchecked by default',function(){
      expect(projectLayout.useNumCallCrossrefCB.isDisplayed()).toBe(true);
      expect(projectLayout.useNumCallCrossrefCB.getAttribute('checked')).toBe(null);
    });
    
  });
  
  describe('editing features page', function(){
    it('should have editing features tab', function(){
      expect(projectLayout.editFeatTab.isPresent()).toBe(true);
      projectLayout.editFeatTab.click();
    }); 
    
    it('should have use diagnostic components checkbox unchecked by default',function(){
      expect(projectLayout.diagComponentCB.isDisplayed()).toBe(true);
      expect(projectLayout.diagComponentCB.getAttribute('checked')).toBe(null);
    });
    
    it('should have leading checkbox unchecked by default',function(){
      expect(projectLayout.leadingCB.isDisplayed()).toBe(true);
      expect(projectLayout.leadingCB.getAttribute('checked')).toBe(null);
    });
    
    it('leading should be disabled when disgnostic components is not checked',function(){
      expect(projectLayout.leadingCB.getAttribute('disabled')).toBe('true');
    });
    it('leading should be enabled when disgnostic components is checked',function(){
      projectLayout.diagComponentCB.click(); //now checked
      expect(projectLayout.leadingCB.getAttribute('disabled')).toBe(null);
    });
    
    it('should have useBackground checkbox checked by default',function(){
      expect(projectLayout.useBackgroundCB.isDisplayed()).toBe(true);
      expect(projectLayout.useBackgroundCB.getAttribute('checked')).toBe(null);
    });
    
    it('should have watermark checkbox checked by default',function(){
      expect(projectLayout.watermarkCB.isDisplayed()).toBe(true);
      expect(projectLayout.watermarkCB.getAttribute('checked')).toBe('true');
    });
    
    it('watermarkCB should be disabled when useBackground components is not checked',function(){
      expect(projectLayout.watermarkCB.getAttribute('disabled')).toBe('true');
    });
    
    it('watermarkCB should be enabled when useBackground components is checked',function(){
      projectLayout.useBackgroundCB.click(); //now checked
      expect(projectLayout.watermarkCB.getAttribute('disabled')).toBe(null);
      projectLayout.useBackgroundCB.click(); //now unchecked
    });
    
    it('should have Input: watermarkText', function(){
      expect(projectLayout.watermarkInput.isPresent()).toBe(true);
    });
    
    it('watermarkText should be disabled when useBackground components is not checked',function(){
      expect(projectLayout.watermarkInput.getAttribute('disabled')).toBe('true');
    });
    
    it('watermarkText should be enabled when useBackground components is checked',function(){
      projectLayout.useBackgroundCB.click(); //now checked
      expect(projectLayout.watermarkInput.getAttribute('disabled')).toBe(null);
      projectLayout.useBackgroundCB.click(); //now unchecked
//this one
    });

    it('should have pagebox checkbox unchecked by default',function(){
      expect(projectLayout.pageboxCB.isDisplayed()).toBe(true);
      expect(projectLayout.pageboxCB.getAttribute('checked')).toBe(null);
    });
    
    it('pagebox should be disabled when useBackground components is not checked',function(){
      expect(projectLayout.pageboxCB.getAttribute('disabled')).toBe('true');
    });
    it('pagebox should be enabled when useBackground components is checked',function(){
      projectLayout.useBackgroundCB.click(); //now checked
      expect(projectLayout.pageboxCB.getAttribute('disabled')).toBe(null);
      projectLayout.useBackgroundCB.click(); //now unchecked
    });
    
    it('should have cropmarks checkbox unchecked by default',function(){
      expect(projectLayout.cropmarksCB.isDisplayed()).toBe(true);
      expect(projectLayout.cropmarksCB.getAttribute('checked')).toBe(null);
    });
    
    it('cropmarks should be disabled when useBackground components is not checked',function(){
      expect(projectLayout.cropmarksCB.getAttribute('disabled')).toBe('true');
    });
    it('cropmarks should be enabled when useBackground components is checked',function(){
      projectLayout.useBackgroundCB.click();//now checked
      expect(projectLayout.cropmarksCB.getAttribute('disabled')).toBe(null);
    });
    
    it('watermarkText should be disabled when useBackground components is checked and watermarktextCB is unchecked',function(){
      projectLayout.watermarkCB.click(); //now unchecked
      expect(projectLayout.watermarkInput.getAttribute('disabled')).toBe('true');
    });
    
    it('watermarkText should be enabled when useBackground components is checked and watermark textCB is checked',function(){
      projectLayout.watermarkCB.click(); //now checked
      expect(projectLayout.watermarkInput.getAttribute('disabled')).toBe(null);
    });
    
  });
  
  describe('print options page', function(){
    it('should have print options tab', function(){
      expect(projectLayout.printOptionTab.isPresent()).toBe(true);
      projectLayout.printOptionTab.click();
    }); 
    
    
    it('should have Input: pageSizeCode with default value A5', function(){
      expect(projectLayout.pageSizeCodeInput.isPresent()).toBe(true);
      expect(projectLayout.pageSizeCodeInput.getAttribute('value')).toBe('A5');
    });
    
    it('should have Input: pageHeight with default value 210', function(){
      expect(projectLayout.pageHeightInput.isPresent()).toBe(true);
      expect(projectLayout.pageHeightInput.getAttribute('value')).toBe('210');
    });
    
    it('should have Input: pageWidth with default value 148', function(){
      expect(projectLayout.pageWidthInput.isPresent()).toBe(true);
      expect(projectLayout.pageWidthInput.getAttribute('value')).toBe('148');
    });

    it('should have Input: printerPageSizeCode with default value A4', function(){
      expect(projectLayout.printerPageSizeCodeInput.isPresent()).toBe(true);
      expect(projectLayout.printerPageSizeCodeInput.getAttribute('value')).toBe('A4');
    });
    
    it('should have docInfoText checkbox unchecked by default',function(){
      expect(projectLayout.docInfoTextCB.isDisplayed()).toBe(true);
      expect(projectLayout.docInfoTextCB.getAttribute('checked')).toBe(null);
    });
    
    it('should have Input: docInfoText unavailable when unchecked', function(){
      expect(projectLayout.docInfoTextInput.getAttribute('disabled')).toEqual('true');
    });
    
    it('should have Input: docInfoText available when checked', function(){
      projectLayout.docInfoTextCB.click();
      expect(projectLayout.docInfoTextInput.getAttribute('disabled')).toEqual(null);
    });
    
    it('should have Input: pageHeight with default value 298 when page size code is A4', function(){
      projectLayout.pageSizeCodeInput.element(by.cssContainingText('option', 'A4')).click();
      expect(projectLayout.pageHeightInput.getAttribute('value')).toBe('298');
    });
    
    it('should have Input: pageWidth with default value 210 when page size code is A4', function(){
      projectLayout.pageSizeCodeInput.element(by.cssContainingText('option', 'A4')).click();
      expect(projectLayout.pageWidthInput.getAttribute('value')).toBe('210');
    });
    
    it('should have Input: pageHeight with default value 279.4 when page size code is US letter', function(){
      projectLayout.pageSizeCodeInput.element(by.cssContainingText('option', 'US Letter')).click();
      expect(projectLayout.pageHeightInput.getAttribute('value')).toBe('279.4');
    });
    
    it('should have Input: pageWidth with default value 215.9 when page size code is US letter', function(){
      projectLayout.pageSizeCodeInput.element(by.cssContainingText('option', 'US Letter')).click();
      expect(projectLayout.pageWidthInput.getAttribute('value')).toBe('215.9');
    });
    
    it('pageHeight should not be editable when pageSizeCode is not custom', function(){
      projectLayout.pageSizeCodeInput.element(by.cssContainingText('option', 'A5')).click();
      expect(projectLayout.pageHeightInput.getAttribute('disabled')).toBe('true');
      projectLayout.pageSizeCodeInput.element(by.cssContainingText('option', 'A4')).click();
      expect(projectLayout.pageHeightInput.getAttribute('disabled')).toBe('true');
      projectLayout.pageSizeCodeInput.element(by.cssContainingText('option', 'US Letter')).click();
      expect(projectLayout.pageHeightInput.getAttribute('disabled')).toBe('true');
    });
    
    it('pageWidth should not be editable when pageSizeCode is not custom', function(){
      projectLayout.pageSizeCodeInput.element(by.cssContainingText('option', 'A5')).click();
      expect(projectLayout.pageWidthInput.getAttribute('disabled')).toBe('true');
      projectLayout.pageSizeCodeInput.element(by.cssContainingText('option', 'A4')).click();
      expect(projectLayout.pageWidthInput.getAttribute('disabled')).toBe('true');
      projectLayout.pageSizeCodeInput.element(by.cssContainingText('option', 'US Letter')).click();
      expect(projectLayout.pageWidthInput.getAttribute('disabled')).toBe('true');
    });
    
    it('pageHeight should be editable when pageSizeCode is custom', function(){
      projectLayout.pageSizeCodeInput.element(by.cssContainingText('option', 'custom')).click();
      expect(projectLayout.pageHeightInput.getAttribute('disabled')).toBe(null);
    });
    
    it('pageWidth should be editable when pageSizeCode is custom', function(){
      projectLayout.pageSizeCodeInput.element(by.cssContainingText('option', 'custom')).click();
      expect(projectLayout.pageWidthInput.getAttribute('disabled')).toBe(null);
    });
  });
  
  describe('body text page', function(){
    it('should have body text tab', function(){
      expect(projectLayout.bodyTextTab.isPresent()).toBe(true);
      projectLayout.bodyTextTab.click();
    }); 
    
    it('should have Input: leading body text default value 12', function(){
      expect(projectLayout.leadingBodyTextInput.isPresent()).toBe(true);
      expect(projectLayout.leadingBodyTextInput.getAttribute('value')).toBe('12');
    });
    
    it('should have Input: body font size default value 10', function(){
      expect(projectLayout.bodyFontSizeInput.isPresent()).toBe(true);
      expect(projectLayout.bodyFontSizeInput.getAttribute('value')).toBe('10');
    });
    
    it('should have justify paragraphs checkbox checked by default',function(){
      expect(projectLayout.justiyParagCB.isDisplayed()).toBe(true);
      expect(projectLayout.justiyParagCB.getAttribute('checked')).toBe('true');
    });
    
    it('should have right to left checkbox unchecked by default',function(){
      expect(projectLayout.rightToLeftCB.isDisplayed()).toBe(true);
      expect(projectLayout.rightToLeftCB.getAttribute('checked')).toBe(null);
    });
  });
  
  describe('Adv page', function(){
    it('should have Adv tab', function(){
      expect(projectLayout.advTab.isPresent()).toBe(true);
      projectLayout.advTab.click();
    }); 
    
    it('should have Input: extra right margin with default value 0', function(){
      expect(projectLayout.extraRightMarginInput.isPresent()).toBe(true);
      expect(projectLayout.extraRightMarginInput.getAttribute('value')).toBe('0');
    });
    
    it('should have Input: chapter verse seperator with default value of :', function(){
      expect(projectLayout.chapVerseSepInput.isPresent()).toBe(true);
      expect(projectLayout.chapVerseSepInput.getAttribute('value')).toBe(':');
    });
  });
});