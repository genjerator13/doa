var app = angular.module('app', ['ngTouch','ngAnimate', 'ui.grid','ui.grid.moveColumns','ui.grid.resizeColumns','ui.grid.selection','ui.grid.expandable','ui.bootstrap', 'ui.grid.pinning']);

app.controller('MainCtrl', ['$scope', '$http', '$log', '$timeout', 'uiGridConstants','$q','$uibModal', function ($scope, $http, $log, $timeout, uiGridConstants,$q,$uibModal) {
    $scope.gridOptions = {
        enableSorting: true,
        showGridFooter: true,
        enableFiltering: true,
        enableRowSelection: true,
        enableSelectAll: true,
        selectionRowHeaderWidth: 35,
        rowHeight: 35,
        enableColumnResizing: true,
    };
    $scope.gridOptions.multiSelect = true;
    $scope.gridOptions.columnDefs = [
        {name:'id', enableColumnResizing: true,width: 50},
        {name:'username',enableColumnResizing: true},
        {name:'Actions',
            width: 300,
            enableColumnMenu: false,
            enableSorting:false,
            enableFiltering: false,
            cellTemplate:'<a href="/dms/customers/{{row.entity.id}}/edit" class="btn btn-primary">Edit</a><a confirm="Are you sure, ?" ng-click="grid.appScope.delete(row)" class="btn btn-danger" >Delete</a>'}

    ];


    $scope.animationsEnabled = true;




    var canceler = $q.defer();
    $http.get('/api/user/all', {timeout: canceler.promise})
        .success(function(data) {
            $scope.gridOptions.data = data;
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