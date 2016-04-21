/** 
 * Módulo principal da aplicação
 * Dependências: todos os módulos do sistema e diretivas Agana
 */
var ongApp = angular.module('ongApp', [
    'assistanceModule'
])
        .controller('ongAppController', ['$scope',
            function($scope) {
                console.log("entrou no ongAppController");

            }
        ])

        .factory('AppConfig', function() {
            return {
                serverApiBaseUrl: 'http://localhost/desenvolvimento/winponta/simple-money/sm-server/public/api'
            };
        });


