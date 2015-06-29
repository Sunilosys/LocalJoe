    
if(latitude != null && longitude != null){   
    if  ($('#dialog_map_holder') != undefined)   
    {
        $('#dialog_map_holder').gmap3(
        {
            action: 'init',
            options:{
                center:[latitude, longitude],
                zoom:13,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                },
                navigationControl: true,
                scrollwheel: true,
                streetViewControl: true
            }
        }
        );  
    }
                  
}  

function clearMarkers()
{
    var tg = 'marker',
    wh = 'all',
    todo = {
        action:'clear'
    };
    if (tg != 'all'){
        todo['name'] = tg; /* can be an array of name : ['marker', 'polyline', ...] */
    }
    if (wh == 'first'){
        todo['first'] = true;
    }
    if (wh == 'last'){
        todo['last'] = true;
    }
    $('#dialog_map_holder').gmap3(todo);
}

$('.map-icon').live('click', function(){
     
    var latitude = null;
    var address = null;
    var longitude = null;
    latitude = $(this).parent().find('.map-lat').val();
    longitude = $(this).parent().find('.map-lon').val();  
    address = $(this).parent().find('.map-address').val();   
    if(latitude != null && longitude != null){
        clearMarkers();
        $('#dialog_map_holder').gmap3(
        {
            action:'setDefault'
//            classes:{
//                Marker:MarkerWithLabel
//            }
        },
        {
            action: 'addMarker',
            latLng: [latitude,longitude],
//            marker:{              
//                labelAnchor: new google.maps.Point(52, -2),
//                labelClass: "map-label",
//                labelStyle: {
//                    opacity: 0.75
//                },
//                labelContent: address
//            },
            map:{
                center: true,
                zoom: 14,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
        }
        );
    }   
    
    $('#dialogMap').dialog("open"); 
}); 
