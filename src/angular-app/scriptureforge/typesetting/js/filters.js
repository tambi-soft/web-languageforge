'use strict';

/* Filters */

angular.module('typesetting.filters', [])
.filter('urlencode', function() {
  return function(text) {
    return encodeURIComponent(text);
  };
})
.filter('urldecode', function() {
  return function(text) {
    return decodeURIComponent(text);
  };
})
;
