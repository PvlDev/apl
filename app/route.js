var app =  angular.module('main-App',['ngRoute','angularUtils.directives.dirPagination']);
app.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
        when('/', {
            templateUrl: 'app/templates/list.html',
            controller: 'ListController'
        }).
        when('/upload', {
            templateUrl: 'app/templates/upload.html',
            controller: 'UploadController'
        });
    }]);