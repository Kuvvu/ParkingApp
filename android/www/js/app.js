angular.module('ParkingApp', ['ionic','ngCordova','starter.controllers', 'starter.services'])

.run(function($ionicPlatform, $rootScope, $ionicLoading) {
  $ionicPlatform.ready(function() {


    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if (window.cordova && window.cordova.plugins && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
      cordova.plugins.Keyboard.disableScroll(true);
      //cordova.plugins.notification.badge.set(10);
    }
    if (window.StatusBar) {
      // org.apache.cordova.statusbar required
      StatusBar.styleDefault();
    }

    $rootScope.$on('loading:show', function() {
        $ionicLoading.show({template: 'Lade Parkleitsystemdaten...'});
    });

      $rootScope.$on('loading:hide', function() {
        $ionicLoading.hide();
    });


  });
})
.config(function($ionicConfigProvider) {
  $ionicConfigProvider.views.transition('none');
})
.config(function($httpProvider) {
  $httpProvider.interceptors.push(function($rootScope) {
    return {
      request: function(config) {
        $rootScope.$broadcast('loading:show');
        return config;
      },
      response: function(response) {
        $rootScope.$broadcast('loading:hide');
        return response;
      }
    };
  });
})

.config(function($stateProvider, $urlRouterProvider) {
  $stateProvider
  .state('city', {
      url: '/:c/:city',
      templateUrl: 'templates/list.html',
      controller: 'ListCtrl'
  });
  $urlRouterProvider.otherwise('/bs/Basel');
});
