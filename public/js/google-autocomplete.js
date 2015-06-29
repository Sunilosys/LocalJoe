

var input = document.getElementById('contact_user_address');
var autocomplete = new google.maps.places.Autocomplete(input);


var geocoder = new google.maps.Geocoder(); 
google.maps.event.addListener(autocomplete, 'place_changed', function() {
     
    var place = autocomplete.getPlace();
  
    var city = $("#location_city");
    var lat = $("#location_lat");
    var lon = $("#location_lon");
    var zip_code = $("#zip_code");
    city.val('');
    lat.val('');
    lon.val('');
    zip_code.val('');
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
            $('#invalid_location').hide();
        }
        else
        {
            $('#invalid_location').show(); 
        }
    });
   
  
    lat.val(place.geometry.location.lat());
    lon.val(place.geometry.location.lng());


});

google.maps.event.addDomListener($('#contact_user_address'),blur,validateUserLocation);



$('#contact_user_address').live("keypress", function(e){
       
    var keyCode = e.keyCode || e.which; 
    if((keyCode == 13) || (keyCode == 9)){
        validateUserLocation();
       
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

       
function validateUserLocation() {
    var city = $("#location_city");
    var lat = $("#location_lat");
    var lon = $("#location_lon");
    var zip_code = $("#zip_code");
   

    var address = document.getElementById("contact_user_address").value;
    geocoder.geocode( {
        'address': address
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
              
            lat.val(results[0].geometry.location.lat());
            lon.val(results[0].geometry.location.lng());
            for (var i=0; i < results[0].address_components.length;i++){
                if (results[0].address_components[i].types[0] == "locality")
                    city.val(results[0].address_components[i].long_name);
                if (results[0].address_components[i].types[0] == "postal_code")
                    zip_code.val(results[0].address_components[i].short_name);
            } 
			
               
            $('#invalid_location').hide();
                
            updateAddress($('#user_id').val(),$('#contact_user_address').val(),$('#location_city').val(),$('#zip_code').val(),
                $('#location_lat').val(),$('#location_lon').val());  
       
        } else {
            $('#invalid_location').show();
        }
    }); 
       
    
};






