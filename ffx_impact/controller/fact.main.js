app.factory('characterService', ['$http','$location', function ($http, $location) {

    var apiUri =  $location.protocol() + '://' + $location.host();

    var characterService = {}
  
        //get characters
        characterService.getAvailableCharacters = function () {
        return $http.get(apiUri + '/ffx_impact/php/connection.php/characters?');
        };

        characterService.getCharacterDetails = function (id) {
            return $http.get(apiUri + `/ffx_impact/php/connection.php/characterDetails?id=${id}`, {
            }).then(function(response) {
                return response; // Return the data received from the server
            });
        };

        characterService.getOverdriveDetails = function (id) {
            return $http.get(apiUri + `/ffx_impact/php/connection.php/overdriveDetails?id=${id}`, {
            }).then(function(response) {
                return response; // Return the data received from the server
            });
        };
        
    
  



    return characterService;
}]);