var app = angular.module('app', ['ngTouch', 'ui.grid']);

app.controller('MainCtrl', ['$scope', '$http', '$q', function ($scope, $http, $q) {
    $scope.gridOptions = {
    };

    $scope.gridOptions.columnDefs = [
        {name:'id'},
        {name:'first_name'},
        {name:'last_name'},
        {name:'city'},
        {name:'state'},
        {name:'zip'},
        {name:'country'}
    ];

    var canceler = $q.defer();
    $http.get('/api/customer/all', {timeout: canceler.promise})
        .success(function(data) {
            console.log(data);
            $scope.gridOptions.data = data;
        });

    $scope.$on('$destroy', function(){
        canceler.resolve();  // Aborts the $http request if it isn't finished.
    });
}]);

//var app = angular.module('app', ['ngTouch', 'ui.grid']);
//
//app.controller('MainCtrl', ['$scope', function ($scope) {
//
//    $scope.myData = [
//        {
//            "firstName": "Cox",
//            "lastName": "Carney",
//            "company": "Enormo",
//            "employed": true
//        },
//        {
//            "firstName": "Lorraine",
//            "lastName": "Wise",
//            "company": "Comveyer",
//            "employed": false
//        },
//        {
//            "firstName": "Nancy",
//            "lastName": "Waters",
//            "company": "Fuelton",
//            "employed": false
//        }
//    ];
//}]);