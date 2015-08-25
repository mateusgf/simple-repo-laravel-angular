var appControllers = angular.module('appControllers', []);

appControllers.controller('LoginController', ['$scope', '$http', '$rootScope', '$location',
    function($scope, $http, $rootScope, $location) {

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
                $rootScope.token = response.access_token;
                $location.path('apps');
            }
        }).error(function(err) {
            $scope.error.valid = true;
            $scope.error.message = err.error_description;
        });

        return false;
    }

}]);


appControllers.controller('ApplicationController', ['$scope', '$http', '$rootScope', '$location',
    function($scope, $http, $rootScope, $location) {

    $scope.applications = [];

    var req = {
        method: 'GET',
        url: '/apps',
        headers: {
            Authorization: 'Bearer ' + $rootScope.token
        }
    };

    $http(req).success(function(response) {
        $scope.applications = response;
    }).error(function(err) {
        $location.path('login');
    });


}]);