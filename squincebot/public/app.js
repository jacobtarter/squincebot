(function() {

    'use strict';

    angular
        .module('app', ['ui.router'])
        .config(config);

    config.$inject = ['$stateProvider', '$locationProvider', '$urlRouterProvider', '$httpProvider'];

    function config($stateProvider, $locationProvider, $urlRouterProvider, $httpProvider) {

        $stateProvider
            .state('home', {
                url: '/',
                controller: 'HomeController',
                templateUrl: 'index.html'
            });



        //setup angular-flash messages


    }
    var app = angular.module('app', ['app']);


})();
