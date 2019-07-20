(function(){
    var app = angular.module('smgpos', [ ]);

    app.controller("SearchItemCtrl", [ '$scope', '$http', function($scope, $http) {
        $scope.items = [ ];
        $http.get('api/item').success(function(data) {
            $scope.items = data;
        });
        $scope.suppliers = [ ];
        $http.get('api/supplier').success(function(data) {
            $scope.suppliers = data;
        });
        $scope.receivingtemp = [ ];
        $scope.newreceivingtemp = { };
        $http.get('api/receivingtemp').success(function(data, status, headers, config) {
            $scope.receivingtemp = data;
        });
        $scope.addReceivingTemp = function(item,newreceivingtemp) {
            $http.post('api/receivingtemp', { item_id: item.id, cost_price: item.cost_price, total_cost: item.cost_price, type: item.type }).
            success(function(data, status, headers, config) {
                $scope.receivingtemp.push(data);
                $http.get('api/receivingtemp').success(function(data) {
                    $scope.receivingtemp = data;
                });
            });
        }
        $scope.updateReceivingTemp = function(newreceivingtemp) {
            $http.put('api/receivingtemp/' + newreceivingtemp.id, {cost_price:newreceivingtemp.cost_price, quantity: newreceivingtemp.quantity, total_cost: newreceivingtemp.cost_price * newreceivingtemp.quantity }).
            success(function(data, status, headers, config) {
            });
        }
        $scope.removeReceivingTemp = function(id) {
            $http.delete('api/receivingtemp/' + id).
            success(function(data, status, headers, config) {
                $http.get('api/receivingtemp').success(function(data) {
                    $scope.receivingtemp = data;
                });
            });
        }
        $scope.sum = function(list) {
            var total=0;
            angular.forEach(list , function(newreceivingtemp){
                total+= parseFloat(newreceivingtemp.cost_price * newreceivingtemp.quantity);
            });
            return total;
        }

    }]);
})();