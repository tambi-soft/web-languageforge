'use strict';

//location to put all of the backend so that the test page stays clear.

var SfCompositionPage = function() {

	this.navigation = {
			composition: element(by.cssContainingText('here', 'Composition')),
	};
	
	
	

	this.navigation = {
			leftButton: element(by.className('prev')),
			rightButton: element(by.className('next')),
			goButton: element(by.partialButtonText('GO')),
			pageInput: element(protractor.By.css('.pageNumber')),
			
			renderButton: element(by.partialButtonText('Render')),
			saveAllButton: element(by.partialButtonText('Save')),
			slider: element(by.className('progress-slider')), //need to be able to access slider functionality, not as simple as button presses
	};

	this.left = {
			//text	
			//paragraph settings

	};

	this.right = {
			//image:, placeholder for now.
			rightPage: element(by.className('right')),
			leftPage: element(by.className('left')),
	};
	
	this.buttons = {
			saveTemplate: element(by.partialButtonText('Save Template')),
			save: element(by.id('save')),
			loadTemplate: element(by.partialButtonText('Load Template')),
			load: element(by.id('load')),
	};

};

module.exports = new SfCompositionPage();