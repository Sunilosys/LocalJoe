
var mapOptions = {
    center: new google.maps.LatLng(-33.8688, 151.2195),
    zoom: 13,
    mapTypeId: google.maps.MapTypeId.ROADMAP
};
var map = new google.maps.Map(document.getElementById('location_map'),
    mapOptions);	
    
if(latitude != null && longitude != null){
	
    var center = new google.maps.LatLng(
        latitude,
        longitude
        );  
        
    map.setCenter(center);      
                  
}

var input = document.getElementById('location_address');
var autocomplete = new google.maps.places.Autocomplete(input);

autocomplete.bindTo('bounds', map);

//var infowindow = new google.maps.InfoWindow();
var marker = new google.maps.Marker({
    map: map
});
var geocoder = new google.maps.Geocoder(); 
google.maps.event.addListener(autocomplete, 'place_changed', function() {
     
    var place = autocomplete.getPlace();
    //    if (place.geometry.viewport) {
    //        map.fitBounds(place.geometry.viewport);
    //    } else {
    map.setCenter(place.geometry.location);
    map.setZoom(17);  // Why 17? Because it looks good.
    //}
    var city = $("#location_city");
    var lat = $("#location_lat");
    var lon = $("#location_lon");
    var zip_code = $("#zip_code");
     
    var latlng = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
    geocoder.geocode( {
        'latLng': latlng
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            for (var i=0; i < results[0].address_components.length;i++){
       
                if (results[0].address_components[i].types[0] == "locality")                          
                    city.val(results[0].address_components[i].long_name);      
               
                if (results[0].address_components[i].types[0] == "postal_code")
                    zip_code.val(results[0].address_components[i].short_name);    
            }
        }
    });
   
    $("#map_canvas").html('');   
    lat.val(place.geometry.location.lat());
    lon.val(place.geometry.location.lng());
    var img = '<img border="0" src="http://maps.googleapis.com/maps/api/staticmap?center=' + lat.val() + ',' + lon.val() + 
    '&zoom=12&size=290x125&maptype=roadmap&markers=color:red%7C' + lat.val() + ',' + lon.val()  + '&sensor=false" alt="' + city.val() + '" />';
    $('<input type="hidden" class="map-lat"></input>').appendTo('#map_canvas');
    $('<input type="hidden" class="map-lon"></input>').appendTo('#map_canvas'); 
    $('<input type="hidden" class="map-address"></input>').appendTo('#map_canvas'); 
    $(".map-lat").val(lat.val());
    $(".map-lon").val(lon.val());
    $(".map-address").val($('#location_address').val());
    $('<div id="preview_map_image"></div>').appendTo('#map_canvas');
    $("#preview_map_image").replaceWith(img);
            
    map.setCenter(place.geometry.location);
    var marker = new google.maps.Marker({
        map: map,
        position: place.geometry.location
    });

});

google.maps.event.addDomListener($('#location_address'),blur,validateLocation);

$('#location_address').live("keypress", function(e){
       
    var keyCode = e.keyCode || e.which; 
    if((keyCode == 13) || (keyCode == 9)){
        validateLocation();
        e.preventDefault(); 
    }  
    if(keyCode == 8){
        var city = $("#location_city");
        var lat = $("#location_lat");
        var lon = $("#location_lon");
        var zip_code = $("#zip_code");
        city.val("");
        lat.val("");
        lon.val("");
        zip_code.val("");
        $('#invalid_location').hide();
    }
});

       
function validateLocation() {
    var city = $("#location_city");
    var lat = $("#location_lat");
    var lon = $("#location_lon");
    var zip_code = $("#zip_code");

    if(lat.val() == "" && lon.val() == ""){
        var address = document.getElementById("location_address").value;
        geocoder.geocode( {
            'address': address
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
                lat.val(results[0].geometry.location.lat());
                lon.val(results[0].geometry.location.lng());
                for (var i=0; i < results[0].address_components.length;i++){
                    if (results[0].address_components[i].types[0] == "locality")
                        city.val(results[0].address_components[i].long_name);
                    if (results[0].address_components[i].types[0] == "postal_code")
                        zip_code.val(results[0].address_components[i].short_name);
                } 
			
                $("#map_canvas").html('');   
                var img = '<img border="0" src="http://maps.googleapis.com/maps/api/staticmap?center=' + lat.val() + ',' + lon.val() + 
                '&zoom=12&size=290x125&maptype=roadmap&markers=color:red%7C' + lat.val() + ',' + lon.val()  + '&sensor=false" alt="' + city.val() + '" />';
                $('<input type="hidden" class="map-lat"></input>').appendTo('#map_canvas');
                $('<input type="hidden" class="map-lon"></input>').appendTo('#map_canvas'); 
                $('<input type="hidden" class="map-address"></input>').appendTo('#map_canvas'); 
                $(".map-lat").val(lat.val());
                $(".map-lon").val(lon.val());
                $(".map-address").val($('#location_address').val());
                $('<div id="preview_map_image"></div>').appendTo('#map_canvas');
                $("#preview_map_image").replaceWith(img);
                $('#invalid_location').hide();
            } else {
                $('#invalid_location').show();
            }
        }); 
    }else{
        $('#invalid_location').hide();
    }
};

function loadMapByLatLon(lat,lon){

    var latlng = new google.maps.LatLng(lat, lon);
    map.setCenter(latlng);
    var marker = new google.maps.Marker({
        map: map,
        position: latlng
    });
                        
    $("#map_canvas").html('');   
    var img = '<a class="map-icon"><img border="0" src="http://maps.googleapis.com/maps/api/staticmap?center=' + lat + ',' + lon + 
    '&zoom=12&size=290x125&maptype=roadmap&markers=color:red%7C' + lat + ',' + lon  + '&sensor=false" alt="' + $('#location_city').val() + '" /></a>';
    $('<input type="hidden" class="map-lat"></input>').appendTo('#map_canvas');
    $('<input type="hidden" class="map-lon"></input>').appendTo('#map_canvas'); 
    $('<input type="hidden" class="map-address"></input>').appendTo('#map_canvas'); 
    $(".map-lat").val(lat);
    $(".map-lon").val(lon);
    $(".map-address").val($('#location_address').val());
    $('<div id="preview_map_image"></div>').appendTo('#map_canvas');
    $("#preview_map_image").replaceWith(img);
    $('#invalid_location').hide();
                          
}





