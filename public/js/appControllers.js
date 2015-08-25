var appControllers = angular.module('appControllers', []);

appControllers.controller('LoginController', ['$scope', '$http', '$rootScope', '$location', '$window',
    function($scope, $http, $rootScope, $location, $window) {

    $scope.email = "";
    $scope.password = "";

    $scope.error = {
        valid: false,
        message: ""
    };

    $scope.login = function() {
        $http.post('/oauth/access_token', {
            username: $scope.email,
            password: $scope.password,
            client_id: 1,
            client_secret: 'secret',
            grant_type: 'password'
        }).success(function(response) {
            if(typeof response.access_token != 'undefined' && response.access_token != '') {
                // $rootScope.token = response.access_token;
                $window.sessionStorage.token = response.access_token;
                $location.path('apps');
            }
        }).error(function(err) {
            // Delete the token if the user fails to log in
            delete $window.sessionStorage.token;

            $scope.error.valid = true;
            $scope.error.message = err.error_description;
        });

        return false;
    }

}]);


appControllers.controller('ApplicationController', ['$scope', '$http', '$rootScope', '$location', '$window',
    function($scope, $http, $rootScope, $location, $window) {


    $scope.applications = [];

    var req = {
        method: 'GET',
        url: '/apps',
        headers: {
            Authorization: 'Bearer ' + $window.sessionStorage.token
        }
    };

    $http(req).success(function(response) {
        $scope.applications = response;
    }).error(function(err) {
        $location.path('login');
    });


}]);


appControllers.controller('ApplicationShowController', ['$scope', '$http', '$rootScope', '$location', '$routeParams', '$window',
    function($scope, $http, $rootScope, $location, $routeParams, $window) {


        $scope.application = [];


        var req = {
            method: 'GET',
            url: '/apps/' + $routeParams.id,
            headers: {
                Authorization: 'Bearer ' + $window.sessionStorage.token
            }
        };

        $http(req).success(function(response) {
            $scope.application = response;
        }).error(function(err) {
            $location.path('login');
        });


    }]);


appControllers.controller('ApplicationEditController', ['$scope', '$http', '$rootScope', '$location', '$routeParams', '$window',
    function($scope, $http, $rootScope, $location, $routeParams, $window) {


        $scope.error = {
            valid: false,
            messages: []
        };

        $scope.success = {
            valid: false,
            message: ""
        };

        $scope.application = [];


        var req = {
            method: 'GET',
            url: '/apps/' + $routeParams.id,
            headers: {
                Authorization: 'Bearer ' + $window.sessionStorage.token
            }
        };

        $http(req).success(function(response) {
            $scope.application = response;
        }).error(function(err) {
            $location.path('login');
        });



        $scope.update = function() {
            var reqUpdate = {
                method: 'PUT',
                url: '/apps/' + $routeParams.id,
                headers: {
                    Authorization: 'Bearer ' + $window.sessionStorage.token
                },
                data: { 'title': $scope.application.title }
            };

            $http(reqUpdate).success(function(response) {
                console.log(response);

                if(response.success == 0) {
                    $scope.error.valid = true;
                    $scope.error.messages = response.errors;
                } else {
                    $scope.success.valid = true;
                    $scope.success.message = "Success!";

                    $location.path('apps');
                }


                console.log("ERROR:");
                console.log($scope.error);

                console.log("SUCCESS:");
                console.log($scope.success);


            }).error(function(err) {
                $scope.error.valid = true;
                console.log(err);
            });

            return false;
        }


    }]);