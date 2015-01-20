'use strict';

angular.module('webtypesetting.compositionServices', ['jsonRpc'])
  .service('webtypesettingCompositionService', ['jsonRpc',
  function(jsonRpc) {
    jsonRpc.connect('/api/sf');
    
    this.getBookHTML = function getBookHTML(bookId, callback) {
    	jsonRpc.call("typesetting_composition_getBookHTML", [bookId], callback);
    };
    
    /*
    this.getListOfBooks = function getListOfBooks(callback) {
    	jsonRpc.call("webtypesetting_getListOfBooks", [], callback);
    };
    */

    this.getParagraphProperties = function getParagraphProperties(bookId, callback) {
    	jsonRpc.call("typesetting_composition_getParagraphProperties", [bookId], callback);
    };
    
    this.setParagraphProperties = function setParagraphProperties(bookId, properties, callback) {
    	jsonRpc.call("typesetting_composition_setParagraphProperties", [bookId, properties], callback);
    };
    
    this.renderBook = function renderBook(bookId, callback) {
    	jsonRpc.call("typesetting_composition_renderBook", [bookId], callback);
    };
    
    this.getRenderedPageForBook = function getRenderedPageForBook(bookId, pageNumber, callback) {
    	jsonRpc.call("typesetting_composition_getRenderedPageForBook", [bookId, pageNumber], callback);
    };
    
    this.getPageDto = function getPageDto(callback) {
    	jsonRpc.call("typesetting_composition_getPageDto", [], callback);
    };
    
    this.getIllustrationProperties = function getIllustrationProperties(bookId, callback){
    	jsonRpc.call("typesetting_composition_getIllustrationProperties", [bookId], callback);

    };
    
    this.setIllustrationProperties = function setIllustrationProperties(bookId, properties, callback){
    	jsonRpc.call("typesetting_composition_setIllustrationProperties", [bookId, properties, callback]);
    };
    
  }])
  .service('webtypesettingSetupService', ['jsonRpc',
  function(jsonRpc) {
    jsonRpc.connect('/api/sf');
    
	
    this.setupPageDto = function(callback) {
    }; 
    
  }]);
  
