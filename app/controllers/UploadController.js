app.controller('UploadController', function(dataFactory,$scope,$http){
    $scope.data = [];
    $scope.pageNumber = 1;
    $scope.totalItemsTemp = {};
    $scope.totalItems = 0;
    $scope.pageChanged = function(newPage) {
        getResultsPage(newPage);
    };
    getResultsPage(1);
    function getResultsPage(pageNumber) {
        dataFactory.httpRequest('/records?page='+pageNumber).then(function(data) {
            $scope.data = data.data;
            $scope.totalItems = data.total;
            $scope.pageNumber = pageNumber;
        });
    }


    $scope.submit = function() {

        if ($scope.uploadFile) {
            upload({
                url: '/upload/uploadFile',
                method: 'POST',
                data: {
                    aOverWriteData: $scope.overWriteData,
                    aFile: $scope.uploadFile,
                }
            }).then(
                function (response) {
                    console.log(response.data);
                },
                function (response) {
                    console.error(response);
                }
            );
        }
    };
});



app.directive("fileInput", function($parse) {
    return {
        link: function($scope, element, attrs) {
            element.on("change", function (event) {
               var files = event.target.files;
               // console.log(files[0].name);
                $parse(attrs.fileInput).assign($scope, element[0].files);
                $scope.$apply();
            });
        }
    }
});

app.controller('fileUploadCtrl', function($scope, $http){
        $scope.uploadFile=function(){
            var fd = new FormData();
            angular.forEach($scope.files,function(file){
                fd.append('file',file);
            });
            fd.append('over',$("#toggle-one").prop('checked'));
            $http.post('/uploadFile', fd,
                {
                     transformRequest:angular.identity,
                     headers: {'Content-Type': undefined, 'Process-data': false}
                }).success(function(response) {
                    // console.log(response);
                    $("#messageAjax").html(response);
            });
        }
    });