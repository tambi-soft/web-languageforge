'use strict';

angular.module('typesetting.layoutServices', ['jsonRpc'])
  .service('typesettingLayoutService', ['jsonRpc',
  function(jsonRpc) {
    jsonRpc.connect('/api/sf');

    this.getPageDto = function getPageDto(callback) {
      jsonRpc.call('typesetting_layoutPage_dto', [], callback);
    };

    this.save = function save(settings, callback) {
      jsonRpc.call('typesetting_layoutSettings_update', [settings], callback);
    };

  }]);
