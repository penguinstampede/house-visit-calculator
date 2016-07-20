jQuery(function($){
  $('#hv_calculate').on('click', function(ev){
    ev.preventDefault();
    if($('#hv_client_address').val() != ''){
      var service = new google.maps.DistanceMatrixService;
      service.getDistanceMatrix({
        origins: [$('#hv_startingaddress').val()],
        destinations: [$('#hv_client_address').val()],
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC,
      }, function(response, status) {
        if (status !== google.maps.DistanceMatrixStatus.OK) {
          alert('Error was: ' + status);
        } else {

          var meters = response.rows[0].elements[0].distance.value;
          var miles = (meters * 0.000621371).toFixed(2);
          var freemiles = parseInt($('#hv_freeradius').val());
          var extra_charge = 0;

          if(miles > freemiles){
            var miles_to_charge = miles - freemiles;
            var mileage_price = $('#hv_mileageprice').val();
            extra_charge = (mileage_price * miles_to_charge).toFixed(2);
          }

          var base = $('#hv_baseprice').val();

          var final_charge = parseFloat(base) + parseFloat(extra_charge);

          $('#hv_response').html('<p>Based on the distance of ' + miles + ' miles, your estimated price is <strong>$' + final_charge + '</strong></p>');
        }
      });
    }
  });
});
