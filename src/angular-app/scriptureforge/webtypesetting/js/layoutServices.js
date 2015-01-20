'use strict';

angular.module('webtypesetting.layoutServices', ['jsonRpc'])
  .service('webtypesettingLayoutService', ['jsonRpc',
  function(jsonRpc) {
    jsonRpc.connect('/api/sf');
    
    this.getPageDto = function getPageDto(settingId, callback) {
    	jsonRpc.call("webtypesetting_layoutPage_dto", [settingId], callback);
    };
    
  }])
  ;
  
