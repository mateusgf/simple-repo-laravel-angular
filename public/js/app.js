var mainApp = angular.module('mainApp', ['appControllers', 'ngRoute', 'ngMessages']);
mainApp.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
            when('/login', {
                templateUrl: 'js/views/login.html',
                controller: 'LoginController'
            }).
            when('/apps', {
                templateUrl: 'js/views/apps.html',
                controller: 'ApplicationController'
            }).
            when('/apps/:id', {
                templateUrl: 'js/views/app-show.html',
                controller: 'ApplicationShowController'
            }).
            when('/apps/:id/edit', {
                templateUrl: 'js/views/app-edit.html',
                controller: 'ApplicationEditController'
            }).
            otherwise({
                redirectTo: '/'
            });
    }]);