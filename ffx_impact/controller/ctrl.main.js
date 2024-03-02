var app = angular.module('mainCtrl', []);


app.controller('mainController', ['$scope', 'characterService', function($scope, characterService) {

    $scope.characters = [];
    $scope.selectedCharacter = [];
    $scope.showOverdrive = false;
    $scope.startIndex = 0;


    //factory calls
    $scope.factoryGetAvailableCharacters = () => {
        characterService.getAvailableCharacters()
        .then(function(response) {
            $scope.characters = response.data;
        })
        .catch(function(error) {
            console.error('Error fetching character list:', error);
        });
    };
    
    $scope.factoryCharacterDetails = (id) =>{
        characterService.getCharacterDetails(id)
        .then(function(response) {
            $scope.activeCharacter = response.data[0]
            $scope.selectedCharacter.id = id
            $scope.overdriveList = $scope.activeCharacter.overdriveItems.slice($scope.startIndex, $scope.startIndex + 5)
        })
        .catch(function(error) {
            console.error('Error fetching character details:', error);
        });
    }

    $scope.factoryOverdriveDetails = async (id) => {
        try {
            const response = await characterService.getOverdriveDetails(id);
            $scope.$apply(() => {
                $scope.activeOverdrive = response.data[0];
            });
        } catch (error) {
            console.error('Error fetching overdrive details:', error);
        }
    };

    $scope.shiftList = (num) => {
        if (num == 0) {
            $scope.startIndex += 1;
        } else {
            $scope.startIndex -= 1;
        }
        
        // Loop around when reaching the end
        if ($scope.startIndex < 0) {
            $scope.startIndex = $scope.activeCharacter.overdriveItems.length - 5;
        } else if ($scope.startIndex + 5 > $scope.activeCharacter.overdriveItems.length) {
            $scope.startIndex = 0;
        }
        $scope.overdriveList = $scope.activeCharacter.overdriveItems.slice($scope.startIndex, $scope.startIndex + 5);
    }
    

    //factory initall calls

    $scope.factoryGetAvailableCharacters();
    $scope.factoryCharacterDetails(4);


    //handlers
    $scope.showAeons = false;

    $scope.setActive = (item, num) =>{
        if(num == 0){
            $scope.factoryCharacterDetails(item.id);
            $scope.showOverdrive = false;
            $scope.showAeons = false;
        }else{
            $scope.factoryOverdriveDetails(item.id);
            $scope.showOverdrive = true;
            if($scope.activeCharacter.overdrive == "Grand Summon"){
                $scope.showAeons = true;
            }
        }
        
        
        $scope.startIndex = 0;
    }

    
    

}]);