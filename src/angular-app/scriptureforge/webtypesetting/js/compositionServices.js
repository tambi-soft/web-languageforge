'use strict';

angular.module('webtypesetting.services', ['jsonRpc'])
  .service('webtypesettingCompositionService', ['jsonRpc',
  function(jsonRpc) {
    jsonRpc.connect('/api/sf');
    
    this.getBookHTML = function getBookHTML(bookId, callback) {
    	jsonRpc.call("webtypesetting_composition_getBookHTML", [bookId], callback);
    };
    
    /*
    this.getListOfBooks = function getListOfBooks(callback) {
    	jsonRpc.call("webtypesetting_getListOfBooks", [], callback);
    };
    */

    this.getParagraphProperties = function getParagraphProperties(bookId, callback) {
    	jsonRpc.call("webtypesetting_composition_getParagraphProperties", [bookId], callback);
    };
    
    this.setParagraphProperties = function setParagraphProperties(bookId, properties, callback) {
    	jsonRpc.call("webtypesetting_composition_setParagraphProperties", [bookId, properties], callback);
    };
    
    this.renderBook = function renderBook(bookId, callback) {
    	jsonRpc.call("webtypesetting_composition_renderBook", [bookId], callback);
    };
    
    this.getRenderedPageForBook = function getRenderedPageForBook(bookId, pageNumber, callback) {
    	jsonRpc.call("webtypesetting_composition_getRenderedPageForBook", [bookId, pageNumber], callback);
    };
    
    this.getPageDto = function getPageDto(callback) {
    	jsonRpc.call("webtypesetting_composition_getPageDto", [], callback);
    };
    
  }])
  .service('webtypesettingSetupService', ['jsonRpc',
  function(jsonRpc) {
    jsonRpc.connect('/api/sf');
    
	
    this.setupPageDto = function(callback) {
    }; 
    
  }]);
  
