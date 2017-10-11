var app = angular.module('app', ['ngTouch', 'ui.grid','ui.grid.moveColumns','ui.grid.resizeColumns','ui.grid.selection']);

app.controller('MainCtrl', ['$scope', '$http', '$log', '$timeout', 'uiGridConstants','$q', function ($scope, $http, $log, $timeout, uiGridConstants,$q) {
    $scope.gridOptions = {
        enableSorting: true,
        showGridFooter: true,
        enableFiltering: true,
        enableRowSelection: true,
        enableSelectAll: true,
        selectionRowHeaderWidth: 35,
        rowHeight: 35,
        enableColumnResizing: true,
       // rowTemplate: '<div ng-click="grid.appScope.doSomething(row)" ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.uid" class="ui-grid-cell" ng-class="col.colIndex()" ui-grid-cell></div>',
    };
    $scope.gridOptions.multiSelect = true;
    $scope.gridOptions.columnDefs = [
        {name:'id', enableColumnResizing: true},
        {name:'first_name',enableColumnResizing: true},
        {name:'last_name'},
        {name:'city'},
        {name:'state'},
        {name:'zip'},
        {name:'country'},
        {name:'followup_date',displayName: 'Follow up Date',type: 'date', cellFilter: 'date:\'yyyy-MM-dd\''},
        {name:'notes'},
        //{name:'Actions',enableFiltering: false,cellTemplate:'<div><button ng-click="grid.appScope.doSomething(row)" class="btn btn-primary">Edit</button></div>'}
        {name:'Actions',enableFiltering: false,cellTemplate:'<a href="/dms/customers/{{row.entity.id}}/edit" class="btn btn-primary">Edit</a>'}

    ];
    $scope.doSomething = function(row) {
        console.log(row.entity.id);
    }

    var canceler = $q.defer();
    $http.get('/api/customer/all', {timeout: canceler.promise})
        .success(function(data) {
            console.log(data);
            $scope.gridOptions.data = data;
            $timeout(function() {
                if($scope.gridApi.selection.selectRow){
                    $scope.gridApi.selection.selectRow($scope.gridOptions.data[0]);
                }
            });
        });

    $scope.$on('$destroy', function(){
        canceler.resolve();  // Aborts the $http request if it isn't finished.
    });

    $scope.gridOptions.onRegisterApi = function(gridApi){
        //set gridApi on scope
        $scope.gridApi = gridApi;
        gridApi.selection.on.rowSelectionChanged($scope,function(row){
            var msg = 'row selected ' + row.isSelected;
            $log.log(msg);
        });

        gridApi.selection.on.rowSelectionChangedBatch($scope,function(rows){
            var msg = 'rows changed ' + rows.length;
            $log.log(msg);
        });
    };
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