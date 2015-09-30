'use strict';

angular.module('webtypesetting.layoutServices', ['jsonRpc'])
  .service('webtypesettingLayoutService', ['jsonRpc',
  function(jsonRpc) {
    jsonRpc.connect('/api/sf');
    
    this.getPageDto = function getPageDto(callback) {
      jsonRpc.call("typesetting_layoutPage_dto", [], callback);
    };
    
    this.save = function save(settings, callback) {
      jsonRpc.call("typesetting_layoutSettings_update", [settings], callback);
    };
    
  }])
  ;
  
