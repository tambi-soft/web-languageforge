'use strict';

// A sample of how we might use the new email utils in util.js
// Don't add this to the actual test suite; it's just a sample
describe('testing email utils', function() {
	var util = require('../../../pages/util.js');
	it('looks for a URL in the first mail message', function() {
		util.getFirstUrlFromMail(function(url) {
			console.log('Found URL:', url);
		});
	});
});