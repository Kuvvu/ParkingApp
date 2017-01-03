angular.module('starter.services', [])
.factory('City', ['$http', function($http) {
  return {
    get: function(city) {
      return $http.get("http://app.codecentric.ch/kunden/parking/api/v1/" + city);
    }
  };
}]);
