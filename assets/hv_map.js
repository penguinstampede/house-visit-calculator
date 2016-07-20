jQuery(function($){

  var address = $('#hv_address').val();
  var radius = $('#hv_radius').val();

  if(address != ''){
    generate_map(address, radius);
  }

  $('#hv_address').on('focusout', function(){
    if(address != $('#hv_address').val()){
      console.log('changed');
      address = $('#hv_address').val();
      generate_map(address, radius);
    }
  });

  $('#hv_radius').on('focusout', function(){
    if(radius != $('#hv_radius').val() && address != ''){
      console.log('changed');
      radius = $('#hv_radius').val();
      generate_map(address, radius);
    }
  });


});

function toRadians (angle) {
  return angle * (Math.PI / 180);
}

function find_new_lat (lat, distance) {
  return (distance / 68.707) + lat;
}

function find_new_long (long, lat, distance) {
  return (distance / ( 69.171 * Math.cos( toRadians(lat) ) )) + long;
}

function generate_map(address, radius){

  var geocode_url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' + address + '&key=AIzaSyBYuS4AWkUJktNPa8FQYtDvJzI8TDmJEns';
  var gmap_url = 'https://maps.googleapis.com/maps/api/staticmap?center=' + address + '&markers=color:red%7C' + address + '&size=400x400&key=AIzaSyAMi-DNji2s2jaWG76-TgJvYA5BKwlHHkw';

  if(radius != '' && radius != 0){

    var geocode_service = jQuery.get(geocode_url);

    geocode_service.done(function(data){
      var results = data.results[0];
      var lat = results.geometry.location.lat;
      var long = results.geometry.location.lng;

      var circle_points = [
        [ find_new_lat(lat, -1 * radius), long ],
        [ lat, find_new_long(long, lat, -1 * radius) ],
        [ find_new_lat(lat, radius), long ],
        [ lat, find_new_long(long, lat, radius) ]
      ];

      var path_points = '';

      for (var i = 0; i < circle_points.length; i++) {
        path_points += '|' + circle_points[i][0] + ',' + circle_points[i][1];
      }

      var path = '&path=color:0xFFFFFF00|weight:5|fillcolor:0xAA000033' + path_points;
      gmap_url = 'https://maps.googleapis.com/maps/api/staticmap?center=' + address + '&markers=color:red%7C' + address + '&size=400x400&key=AIzaSyAMi-DNji2s2jaWG76-TgJvYA5BKwlHHkw' + path;
      jQuery('#vist_map').attr('src', gmap_url).show();
    });
  }

  jQuery('#vist_map').attr('src', gmap_url).show();


}
