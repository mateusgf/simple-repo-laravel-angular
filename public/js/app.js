var mainApp = angular.module('mainApp', ['appControllers', 'ngRoute']);
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
            otherwise({
                redirectTo: '/'
            });
    }]);