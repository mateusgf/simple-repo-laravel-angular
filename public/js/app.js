var mainApp = angular.module('mainApp', ['ngFileUpload', 'appControllers', 'ngRoute', 'ngMessages']);
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
            when('/apps/:id_app/versions/:id_version/files/new', {
                templateUrl: 'js/views/files/new.html',
                controller: 'FileNewController'
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


mainApp.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

            element.bind('change', function(){
                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}]);


//mainApp.appModule.directive('fileDownload', function ($compile) {
//    var fd = {
//        restrict: 'A',
//        link: function (scope, iElement, iAttrs) {
//
//            scope.$on("downloadFile", function (e, url) {
//                var iFrame = iElement.find("iframe");
//                if (!(iFrame && iFrame.length > 0)) {
//                    iFrame = $("<iframe style='position:fixed;display:none;top:-1px;left:-1px;'/>");
//                    iElement.append(iFrame);
//                }
//
//                iFrame.attr("src", url);
//
//
//            });
//        }
//    };
//
//    return fd;
//});