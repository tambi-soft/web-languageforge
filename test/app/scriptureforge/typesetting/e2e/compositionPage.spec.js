'use strict';
/*

describe('the composition page', function(){
  var constants       = require('../../../testConstants.json');
  var loginPage       = require('../../../bellows/pages/loginPage.js');
  var util         = require('../../../bellows/pages/util.js');
  var appFrame       = require('../../../bellows/pages/appFrame.js');
  var compositionPage    = require('../pages/compositionPage.js');


  describe('user', function(){
    //get to the page to run specific tests
    it('page navigation', function(){
      loginPage.logout();
      loginPage.loginAsMember();
      //probably replace this with an official page navigation, not an absolute local reference
       browser.get('https://scriptureforge.local/app/webtypesetting/54adf50c25f225820b21ab74/#/composition');
       
    });
    
    
    it('has all elements present', function(){
      expect(compositionPage.navigation.leftButton.isPresent()).toBe(true);
      expect(compositionPage.navigation.rightButton.isPresent()).toBe(true);
      expect(compositionPage.navigation.goButton.isPresent()).toBe(true);
      expect(compositionPage.navigation.pageInput.isPresent()).toBe(true);
      expect(compositionPage.navigation.slider.isPresent()).toBe(true);
      
      expect(compositionPage.navigation.renderButton.isPresent()).toBe(true);
      expect(compositionPage.navigation.saveAllButton.isPresent()).toBe(true);
      
      
    });
    
    
    it('has page navigation', function(){
          
      expect(compositionPage.navigation.pageInput.getAttribute('value')).toEqual('1');
      expect(compositionPage.navigation.slider.getAttribute('value')).toEqual('1');
      
      compositionPage.navigation.rightButton.click();
      expect(compositionPage.navigation.pageInput.getAttribute('value')).toEqual('2');
      expect(compositionPage.navigation.slider.getAttribute('value')).toEqual('2');
      
      compositionPage.navigation.rightButton.click();
      expect(compositionPage.navigation.pageInput.getAttribute('value')).toEqual('3');
      expect(compositionPage.navigation.slider.getAttribute('value')).toEqual('3');
      
      compositionPage.navigation.leftButton.click();
      expect(compositionPage.navigation.pageInput.getAttribute('value')).toEqual('2');
      expect(compositionPage.navigation.slider.getAttribute('value')).toEqual('2');
      
      expect(compositionPage.navigation.slider.evaluate('numPages')).toEqual(21);
      expect(compositionPage.navigation.slider.evaluate('selectedPage')).toEqual(2);
      
      compositionPage.navigation.pageInput.sendKeys('1'); //doesn't remove existing input, so makes it 21
      compositionPage.navigation.goButton.click();
      expect(compositionPage.navigation.pageInput.getAttribute('value')).toEqual('21');
      expect(compositionPage.navigation.slider.getAttribute('value')).toEqual('21');
    });
    
    
    /*
     * most testing is going to have to wait for actual functionality to exist, eg test that images are correct and change as selected page changes.
     */
/*
    it('can render image', function(){
      compositionPage.navigation.renderButton.click();
      expect(compositionPage.right.rightPage.isPresent()).toBe(true);
      expect(compositionPage.right.rightPage.getAttribute('src')).toEqual('http://www.online-image-editor.com//styles/2014/images/example_image.png');
      expect(compositionPage.right.leftPage.isPresent()).toBe(true);
      expect(compositionPage.right.leftPage.getAttribute('src')).toEqual('http://upload.wikimedia.org/wikipedia/commons/6/6a/Tricoloring.png');
      
    });
    
    
    /*
     * both of these methods are nonstandard, relying on either a user input or some other mockup to
     * be tested fully. Will leave at manual testing for now.
     */
    //it('has slider navigation', function(){});
    //it('has paragraph selection', function(){});
/*    


  });
});
*/
