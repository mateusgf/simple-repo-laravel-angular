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


    $scope.destroyApp = function(application) {

        $http.delete('/apps/' + application.id, { headers: { Authorization: 'Bearer ' + $window.sessionStorage.token } }).
            success(function(data, status, headers, config) {
                for (index = 0; index < $scope.applications.length; ++index) {
                    if ($scope.applications[index].id == application.id) {
                        $scope.applications.splice(index, 1);
                    }
                }
            });


        return false;
    }


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
            console.log(response);
            $scope.application = response;
        }).error(function(err) {
            $location.path('login');
        });


        $scope.destroyVersion = function(application, version) {

            $http.delete('/apps/' + application.id + '/versions/' + version.id, { headers: { Authorization: 'Bearer ' + $window.sessionStorage.token } }).
                success(function(data, status, headers, config) {
                    for (index = 0; index < $scope.application.versions.length; ++index) {
                        if ($scope.application.versions[index].id == version.id) {
                            $scope.application.versions.splice(index, 1);
                        }
                    }
                });


            return false;
        }

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





appControllers.controller('ApplicationNewController', ['$scope', '$http', '$rootScope', '$location', '$routeParams', '$window',
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


        $scope.create = function(idButton) {
            var reqCreate = {
                method: 'POST',
                url: '/apps',
                headers: {
                    Authorization: 'Bearer ' + $window.sessionStorage.token
                },
                data: { 'title': $scope.application.title }
            };


            $http(reqCreate).success(function(response) {
                console.log(response);

                if(response.success == 0) {
                    angular.element('#' + idButton).attr('disabled', false);
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

        return false;
 }]);



appControllers.controller('VersionShowController', ['$scope', '$http', '$rootScope', '$location', '$routeParams', '$window',
    function($scope, $http, $rootScope, $location, $routeParams, $window) {

        $scope.version = [];
        $scope.tokenDownload = ""

        var req = {
            method: 'GET',
            url: '/apps/' + $routeParams.id_app + '/versions/' + $routeParams.id,
            headers: {
                Authorization: 'Bearer ' + $window.sessionStorage.token
            }
        };

        $http(req).success(function(response) {
            console.log(response);
            $scope.version = response;
            $scope.tokenDownload = $window.sessionStorage.token;
        }).error(function(err) {
            $location.path('login');
        });

}]);


appControllers.controller('VersionNewController', ['$scope', '$http', '$rootScope', '$location', '$routeParams', '$window',
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
            url: '/apps/' + $routeParams.id_app,
            headers: {
                Authorization: 'Bearer ' + $window.sessionStorage.token
            }
        };

        $http(req).success(function(response) {
            console.log(response);
            $scope.application = response;
        }).error(function(err) {
            $location.path('login');
        });




        $scope.create = function(idButton) {
            var reqCreate = {
                method: 'POST',
                url: '/apps/' + $routeParams.id_app + '/versions',
                headers: {
                    Authorization: 'Bearer ' + $window.sessionStorage.token
                },
                data: { 'title': $scope.version.title }
            };


            $http(reqCreate).success(function(response) {
                console.log(response);

                if(response.success == 0) {
                    angular.element('#' + idButton).attr('disabled', false);
                    $scope.error.valid = true;
                    $scope.error.messages = response.errors;
                } else {
                    $scope.success.valid = true;
                    $scope.success.message = "Success!";

                    $location.path('apps/' + $routeParams.id_app);
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

        return false;
}]);





appControllers.controller('VersionEditController', ['$scope', '$http', '$rootScope', '$location', '$routeParams', '$window',
    function($scope, $http, $rootScope, $location, $routeParams, $window) {


        $scope.error = {
            valid: false,
            messages: []
        };

        $scope.success = {
            valid: false,
            message: ""
        };

        $scope.version = [];


        var req = {
            method: 'GET',
            url: '/apps/' + $routeParams.id_app + '/versions/' + $routeParams.id,
            headers: {
                Authorization: 'Bearer ' + $window.sessionStorage.token
            }
        };

        $http(req).success(function(response) {
            $scope.version = response;
        }).error(function(err) {
            $location.path('login');
        });



        $scope.update = function() {
            var reqUpdate = {
                method: 'PUT',
                url: '/apps/' + $routeParams.id_app + '/versions/' + $routeParams.id,
                headers: {
                    Authorization: 'Bearer ' + $window.sessionStorage.token
                },
                data: { 'title': $scope.version.title }
            };

            $http(reqUpdate).success(function(response) {
                console.log(response);

                if(response.success == 0) {
                    $scope.error.valid = true;
                    $scope.error.messages = response.errors;
                } else {
                    $scope.success.valid = true;
                    $scope.success.message = "Success!";

                    $location.path('apps/' + $routeParams.id_app);
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




appControllers.controller('FileNewController', ['$scope', '$http', '$rootScope', '$location', '$routeParams', '$window', 'Upload',
    function($scope, $http, $rootScope, $location, $routeParams, $window, Upload) {

        $scope.error = {
            valid: false,
            messages: []
        };

        $scope.success = {
            valid: false,
            message: ""
        };

        $scope.version = [];

        var req = {
            method: 'GET',
            url: '/apps/' + $routeParams.id_app + '/versions/' + $routeParams.id_version,
            headers: {
                Authorization: 'Bearer ' + $window.sessionStorage.token
            }
        };

        $http(req).success(function(response) {
            console.log(response);
            $scope.version = response;
        }).error(function(err) {
            $location.path('login');
        });



        $scope.$watch('file', function (file) {
            if (!file.$error) {
                $scope.upload($scope.file);
            }
        });


        $scope.uploadFiles = function(files) {
            $scope.files = files;
            angular.forEach(files, function(file) {
                if (file && !file.$error) {
                    file.upload = Upload.upload({
                        url: '/apps/' + $routeParams.id_app + '/versions/' +  $routeParams.id_version + '/files',
                        headers: {
                            Authorization: 'Bearer ' + $window.sessionStorage.token
                        },
                        file: file
                    });

                    file.upload.then(function (response) {
                        $timeout(function () {
                            file.result = response.data;
                        });
                    }, function (response) {
                        if (response.status > 0)
                            $scope.errorMsg = response.status + ': ' + response.data;
                    });

                    file.upload.progress(function (evt) {
                        file.progress = Math.min(100, parseInt(100.0 *
                        evt.loaded / evt.total));
                    });
                }
            });
        }



        return false;
}]);



//appControllers.controller('FileDownloadController', ['$scope', '$http', '$rootScope', '$location', '$routeParams', '$window', 'Upload',
//    function($scope, $http, $rootScope, $location, $routeParams, $window, Upload) {
//
//
//    $scope.$broadcast("downloadFile", url);
//
//    return false;
//}]);