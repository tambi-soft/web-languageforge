'use strict';

angular.module('webtypesetting.services', ['jsonRpc'])
  .service('webtypesettingEditService', ['jsonRpc',
  function(jsonRpc) {
    jsonRpc.connect('/api/sf');
    this.render = function render(callback){
    	jsonRpc.call("webtypesetting_rapuma_render", [], callback);
    };
    this.editorDto = function(callback) {
    }; 
    

  }])
  .service('webtypesettingSetupService', ['jsonRpc',
  function(jsonRpc) {
    jsonRpc.connect('/api/sf');
    
	
    this.setupPageDto = function(callback) {
    }; 
    
  }])
  .service('webtypesettingAssetService', ['jsonRpc',  function(jsonRpc) {
	  jsonRpc.connect('/api/sf');
	  	  this.add = function(callback) {
	  };
  }])
  .factory('templateSaveService', function($rootScope, jsonRpc) {
    var templateSaveObject = {};
    //Other controllers can add their data to the sharedService variable
    templateSaveObject.templateName = "testString";
    templateSaveObject.prepForBroadcast = function(templateName) {
    	templateSaveObject.templateName = templateName;
    	templateSaveObject.broadcastItem();
    };
    
    templateSaveObject.broadcastItem = function() {
    	//console.log("handleSaveBroadcast");
    	$rootScope.$broadcast('handleSaveBroadcast');
    	console.log(templateSaveObject);
    };
    
    return templateSaveObject;
  })
  .factory('templateLoadService', function($rootScope, jsonRpc) {
    var templateLoadObject = {};
    //Other controllers can add their data to the sharedService variable
    templateLoadObject.prepForBroadcast = function(templateName) {
    	templateLoadObject.templateName = templateName;
    	//console.log(templateName);
    	templateLoadObject.broadcastItem();
    };
    
    templateLoadObject.broadcastItem = function() {
    	//console.log("handleLoadBroadcast");
    	$rootScope.$broadcast('handleLoadBroadcast');
    };
    
    return templateLoadObject;
  })
  ;
  
