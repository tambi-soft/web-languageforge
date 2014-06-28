'use strict';

// A sample of how we might use the new email utils in util.js
// Don't add this to the actual test suite; it's just a sample
describe('testing email utils', function() {
	var util = require('../../../pages/util.js');
	it('looks for a URL in the first mail message', function() {
		// The browser.wait() is important -- otherwise the promise returned
		// by getFirstUrlFromMail won't yet have been fulfilled by the time
		// the it() exits. But since browser.wait() checks the result of its
		// function and, if the result is a promise, waits for that promise
		// to be fulfilled... this works as we want it to work.
		var result = browser.wait(util.getFirstUrlFromMail);
		//result.then(function(url) {
		//	console.log('Found URL:', url);
		//	expect(url).toMatch('^http');
		//});
		expect(result).toMatch('^http');
	});
});