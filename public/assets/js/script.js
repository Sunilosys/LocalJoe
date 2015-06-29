$(document).ready(function(){
	
    var camera = $('#camera'),
    photos = $('#photos'),
    screen =  $('#screen');

    var template = '<a href="uploads/original/{src}" rel="cam" '
    +'style="background-image:url(uploads/thumbs/{src})"></a>';

    /*----------------------------------
		Setting up the web camera
	----------------------------------*/


    webcam.set_swf_url('/assets/webcam/webcam.swf');
    webcam.set_api_url('/upload/profilepic?_method=TAKE');	// The upload script
    webcam.set_quality(80);				// JPEG Photo Quality
    webcam.set_shutter_sound(true, 'assets/webcam/shutter.mp3');

    // Generating the embed code and adding it to the page:	
    screen.html(
        webcam.get_html(screen.width(), screen.height())
        );


    /*----------------------------------
		Binding event listeners
	----------------------------------*/


    var shootEnabled = false;
		
    $('#shootButton').click(function(){
		
        if(!shootEnabled){
            return false;
        }
		
        webcam.freeze();
        togglePane();
        return false;
    });
	
    $('#cancelButton').click(function(){
        webcam.reset();
        togglePane();
        return false;
    });
	
    $('#uploadButton').click(function(){
        $('#profile-pic-container').mask('Uploading');
$('#dialogTakePic').dialog('close');	
        webcam.upload();
        webcam.reset();
        togglePane();
        return false;
    });

    camera.find('.settings').click(function(){
        if(!shootEnabled){
            return false;
        }
		
        webcam.configure('camera');
    });

    // Showing and hiding the camera panel:
	
    var shown = false;
    //	$('.camTop').click(function(){
    //		
    //		$('.tooltip').fadeOut('fast');
    //		
    //		if(shown){
    //			camera.animate({
    //				bottom:-466
    //			});
    //		}
    //		else {
    //			camera.animate({
    //				bottom:-5
    //			},{easing:'easeOutExpo',duration:'slow'});
    //		}
    //		
    //		shown = !shown;
    //	});

    $('.tooltip').mouseenter(function(){
        $(this).fadeOut('fast');
    });


    /*---------------------- 
		Callbacks
	----------------------*/
	
	
    webcam.set_hook('onLoad',function(){
        // When the flash loads, enable
        // the Shoot and settings buttons:
        shootEnabled = true;
    });
	
    webcam.set_hook('onComplete', function(msg){
		
        // This response is returned by upload.php
        // and it holds the name of the image in a
        // JSON object format:
	 msg = msg.replace('<pre>','');
                 msg = msg.replace('</pre>','');	
        msg = $.parseJSON(msg);
        var obj = document.getElementById('profile-pic');
        var src = msg.url;
        var pos = src.indexOf('?');
        if (pos >= 0) {
            src = src.substr(0, pos);
        }
        var date = new Date();
        obj.src = src + '?v=' + date.getTime();
	$('#profile-pic-container').unmask();	
        $('#edit_photo_title').html('Edit Profile Picture');
        $('#edit_photo_li').show();
        $('#remove_photo_li').show();
    });
	
    webcam.set_hook('onError',function(e){
        screen.html(e);
    });

	

    /*----------------------
		Helper functions
	------------------------*/

	

    // This function toggles the two
    // .buttonPane divs into visibility:
	
    function togglePane(){
        var visible = $('#dialogTakePic .buttonPane:visible:first');
        var hidden = $('#dialogTakePic .buttonPane:hidden:first');
		
        visible.fadeOut('fast',function(){
            hidden.show();
        });
    }
	
	
    // Helper function for replacing "{KEYWORD}" with
    // the respectful values of an object:
	
    function templateReplace(template,data){
        return template.replace(/{([^}]+)}/g,function(match,group){
            return data[group.toLowerCase()];
        });
    }
});
