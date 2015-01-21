var SfAssetSettingsPage = function() {
	var page = this;
	this.url = "/app/projects";
	this.get = function() {
		browser.get(browser.baseUrl + this.url);
	};
	
	this.clickOnProject = function(projectName) {
		this.findProject(projectName).then(function(projectRow) {
			var link = projectRow.$('a');
			link.getAttribute('href').then(function(url) {
				browser.get(url);
			});
		});
	};
	
	this.findProject = function(projectName) {
		var foundRow = undefined;
		var result = protractor.promise.defer();
		var searchName = new RegExp(projectName);
		this.projectsList.map(function(row) {
			row.getText().then(function(text) {
				if (searchName.test(text)) {
					foundRow = row;
				};
			});
		}).then(function() {
			if (foundRow) {
				result.fulfill(foundRow);
			} else {
				result.reject("Project " + projectName + " not found.");
			}
		});
		return result;
	};
};

module.exports = new SfAssetSettingsPage();