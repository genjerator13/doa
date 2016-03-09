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
        expandableRowTemplate: 'notes.html',
        expandableRowHeight: 150,
        //subGridVariable will be available in subGrid scope
        expandableRowScope: {
            subGridVariable: 'subGridScopeVariable'
        }
    };
    $scope.gridOptions.multiSelect = true;
    $scope.gridOptions.columnDefs = [
        {name:'id', enableColumnResizing: true,width: 50},
        {name:'name',enableColumnResizing: true},
        
        {name:'city'},
        {name:'state'},
        {name:'zip'},
        {name:'country'},
        {name:'followup_date',displayName: 'Follow up Date',type: 'date', cellFilter: 'date:\'yyyy-MM-dd\''},
        {name:'notes'},
        //{name:'Actions',enableFiltering: false,cellTemplate:'<div><button ng-click="grid.appScope.doSomething(row)" class="btn btn-primary">Edit</button></div>'}
        {name:'Actions',
            width: 300,
            enableColumnMenu: false,
            enableSorting:false,
            enableFiltering: false,
            cellTemplate:'<a href="/dms/customers/{{row.entity.id}}/edit" class="btn btn-primary">Edit</a><a confirm="Are you sure, ?" ng-click="grid.appScope.delete(row)" class="btn btn-danger" >Delete</a><a href="/dms/customers/{{row.entity.id}}/addnote" class="btn btn-link">Add Note</a>'}

    ];

    $scope.items = ['item1', 'item2', 'item3'];

    $scope.animationsEnabled = true;

    $scope.delete = function(row) {
        console.log(row.entity.id);
        var modalInstance = $uibModal.open({
            animation: $scope.animationsEnabled,
            templateUrl: 'myModalContent.html',
            controller: 'ModalInstanceCtrl',

            resolve: {
                items: function () {
                    return $scope.items;
                }
            }
        });

        modalInstance.result.then(function (selectedItem) {
            //ok

            $http.delete('/dms/customers/'+row.entity.id+"/delete", {timeout: canceler.promise})
                .success(function(data) {
                    var index = $scope.gridOptions.data.indexOf(row.entity);
                    $scope.gridOptions.data.splice(index, 1);
                });
        }, function () {
            //cancel
        });


    }

    var canceler = $q.defer();
    $http.get('/api/customer/all', {timeout: canceler.promise})
        .success(function(data) {
            for(i = 0; i < data.length; i++){
                data[i].subGridOptions = {
                    columnDefs: [ {name:"subject", field:"subject"},{name:"notes", field:"notes"},{name:"date_remind", field:"date_remind"} ],
                    data: data[i]._note
                }

            }
            //console.log(data);
            //$scope.gridOptions.data = data;
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
app.controller('ModalInstanceCtrl', function ($scope, $uibModalInstance, items) {

    $scope.items = items;
    $scope.selected = {
        item: $scope.items[0]
    };

    $scope.ok = function () {
        $uibModalInstance.close($scope.selected.item);
        return true;
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});