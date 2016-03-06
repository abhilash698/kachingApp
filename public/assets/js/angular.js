
    // Defining angularjs application.
    var addOffer = angular.module('addOffer', [], function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    });

    addOffer.directive("datetimepicker", function () {
      return {
        restrict: "EAC",
        require: "ngModel",
        link : function (scope, element, attrs, ngModelCtrl) {
            $(function(){
                element.datetimepicker({
                    format:'Y-m-d H:i',
                    onSelectTime:function (dateText) {
                        ngModelCtrl.$setViewValue(dateText);
                        scope.$apply();

                    }
                });
            });
        }
      }
    });


    // Controller function and passing $http service and $scope var.
    addOffer.controller('addController', function($scope, $http, $window) {
      // create a blank object to handle form data.

        $scope.isDisabled = false;

        $scope.disableButton = function() {
            $scope.isDisabled = true;
        }

        $scope.offer = {};
      // calling our submit function.
        $scope.submitForm = function() {
        // Posting data to php file
        var data = { 'title': $scope.offer.title, 'startDate': $scope.offer.startDate, 'endDate': $scope.offer.endDate, 'fineprint': $scope.offer.fineprint, '_token':$scope.offer.csrf};
        $http({
          method  : 'POST',
          url     : '/merchant/addOffer',
          data    : $.param(data), //forms user object
          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
         })
          .success(function(data) {
            $window.location.reload();
          }).error(function(error) {
            $scope.errorTitle = error.errors.title[0];
            $scope.errorStartDate = error.errors.startDate[0];
            $scope.errorEndDate = error.errors.endDate[0];
            $scope.errorFineprint = error.errors.fineprint[0];
          });
        };
    });

    addOffer.directive('loading',   ['$http' ,function ($http)
    {
        return {
            restrict: 'A',
            link: function (scope, elm, attrs)
            {
                scope.isLoading = function () {
                    return $http.pendingRequests.length > 0;
                };

                scope.$watch(scope.isLoading, function (v)
                {
                    if(v){
                        elm.show();
                    }else{
                        elm.hide();
                    }
                });
            }
        };

    }]);



// Defining angularjs application.

    
    


    