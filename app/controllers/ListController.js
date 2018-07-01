app.controller('ListController', function(dataFactory,$scope,$http){
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
});