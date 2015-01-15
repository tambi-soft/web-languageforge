'use strict';

//location to put all of the backend so that the test page stays clear.

var SfCompositionPage = function() {
	
	this.navigation = {
			composition: element(by.cssContainingText('here', 'Composition')),
	};
	
	this.slider = {
	leftButton: element(by.partialButtonText('left')),
	rightButton: element(by.partialButtonText('right')),
	goButton: element(by.partialButtonText('GO')),
	pageInput: element(protractor.By.css('.pageNumber')),
	};

};

module.exports = new SfCompositionPage();