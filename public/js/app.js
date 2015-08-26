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
            when('/apps/new', {
                templateUrl: 'js/views/app-new.html',
                controller: 'ApplicationNewController'
            }).
            when('/apps/:id', {
                templateUrl: 'js/views/app-show.html',
                controller: 'ApplicationShowController'
            }).
            when('/apps/:id/edit', {
                templateUrl: 'js/views/app-edit.html',
                controller: 'ApplicationEditController'
            }).
            when('/apps/:id/delete', {
                controller: 'ApplicationDeleteController'
            }).
            when('/apps/:id/delete', {
                controller: 'ApplicationDeleteController'
            }).
            when('/apps/:id_app/new', {
                templateUrl: 'js/views/versions/new.html',
                controller: 'VersionNewController'
            }).
            when('/apps/:id_app/versions/:id', {
                templateUrl: 'js/views/versions/show.html',
                controller: 'VersionShowController'
            }).
            when('/apps/:id_app/versions/:id/edit', {
                templateUrl: 'js/views/versions/edit.html',
                controller: 'VersionEditController'
            }).
            otherwise({
                redirectTo: '/'
            });
}]);



mainApp.directive('clickOnce', function($timeout) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var replacementText = attrs.clickOnce;

            element.bind('click', function() {
                $timeout(function() {
                    if (replacementText) {
                        element.html(replacementText);
                    }
                    element.attr('disabled', true);
                }, 0);
            });
        }
    };
});