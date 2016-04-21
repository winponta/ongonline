var assistanceModule = angular.module('assistanceModule', [
]);

assistanceModule.controller('AssistanceController', ['$scope', 
            function($scope) {
                console.log("entrou no AssistanceController");

                $scope.person_helped_id = '0';
                $scope.$watch('person_helped_id', function() {
                    //alert($scope.person_helped_id == '');
                });
            }
        ]);