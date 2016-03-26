'use strict';

angular.module('typesetting.renderServices', ['jsonRpc'])
  .service('typesettingRenderService', ['jsonRpc',
  function(jsonRpc) {
    jsonRpc.connect('/api/sf');

    this.getPageDto = function getPageDto(callback) {
      jsonRpc.call('typesetting_renderPage_dto', [], callback);
    };

    this.renderProject = function renderProject(projectName,callback) {
      jsonRpc.call('typesetting_render_Project', [projectName], callback);
    };

    this.createRapumaProject = function createRapumaProject(projectName,callback) {
      jsonRpc.call('typesetting_create_Rapuma_Project', [projectName], callback);
    };
    
    this.addRapumaTestProject = function addRapumaTestProject (callback) {
      jsonRpc.call('typesetting_add_Rapuma_Test_Project', [], callback);
    };

    this.doRender = function doRender(callback) {
      jsonRpc.call('typesetting_render_doRender', [], callback);
    };

  }]);
