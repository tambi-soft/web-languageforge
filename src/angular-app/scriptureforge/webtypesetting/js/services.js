'use strict';

angular.module('webtypesetting.services', ['jsonRpc'])
  .service('webtypesettingEditService', ['jsonRpc',
  function(jsonRpc) {
    jsonRpc.connect('/api/sf');
    
    this.editorDto = function(callback) {
    }; 
    

  }])
  .service('webtypesettingSetupService', ['jsonRpc',
  function(jsonRpc) {
    jsonRpc.connect('/api/sf');
    
	
    this.setupPageDto = function(callback) {
    }; 
    
  }])
  
