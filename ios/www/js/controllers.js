angular.module('starter.controllers', [])
.controller('ListCtrl', function($scope, $cordovaInAppBrowser, $stateParams, $ionicLoading, City) {

  $scope.city = $stateParams.city;
  $scope.c = $stateParams.c;

  $scope.load = function(){
      $scope.data = [];
      City.get($stateParams.c).then(function(data){
          $scope.data = data.data;
          $scope.$broadcast('scroll.refreshComplete');
      });
  };
  $scope.color = function(p){
      c = "badge-balanced";
      if(p < 50) c = "badge-energized";
      if(p < 10) c = "badge-assertive";
      return c;
  };
  $scope.clean = function(t){
      t = t.replace(' ;',';');
      t = t.replace('&amp;','&');
      t = t.replace('&uuml;','ü');
      return t;
  }

  $scope.open = function(url){
    if(url){
      document.addEventListener("deviceready", function () {
        $cordovaInAppBrowser.open(url, '_blank', {
          location: 'no',
          clearcache: 'yes',
          toolbar: 'yes',
          closebuttoncaption:'Schliessen'
        })
          .then(function(event) {

          })
          .catch(function(event) {

          });
        }, false);
    }
  }

  $scope.load();
});
