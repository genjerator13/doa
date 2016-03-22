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
        {name:'_first_name',enableColumnResizing: true},
        {name:'_last_name',enableColumnResizing: true},
        {name:'group_name',enableColumnResizing: true},
        {name:'Actions',
            width: 100,
            enableColumnMenu: false,
            enableSorting:false,
            enableFiltering: false,
            cellTemplate:'<a href="/dms/users/{{row.entity.id}}/edit" class="btn btn-primary">Edit</a>'}
    ];

    $scope.animationsEnabled = true;

    var canceler = $q.defer();
    $http.get('/api/user/alldms', {timeout: canceler.promise})
        .success(function(data) {
            $scope.gridOptions.data = data;
            for(i = 0; i < data.length; i++){
                data[i].group_name = data[i]._user_group.name;
            }
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