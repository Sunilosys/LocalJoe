window.fbAsyncInit = function () {
    FB.init({
        appId: facebook_app_id,
        status: true,
        cookie: true,
        xfbml: true,
        oauth: true
    });

    function FBLogin() {                   
        FB.login(function(response) {
            if (response.authResponse) {                            
                GetUserInfo("SignIn");
                $('#dialogSignUp').dialog("close"); 
            } else {
            //$('#sign_in_status_post_info').html('User cancelled login or did not fully authorize.');
            }
        }, {
            scope: 'email,user_location'
        });
    }
   
    $('#fb_button').live("click", function(){
        TrackPageView('/facebook-signin');  
        if ($("#dialogAccountExists").length){
            $("#dialogAccountExists").dialog('close');
        }  
        $('#dialogSignUp').dialog("close"); 
        FB.getLoginStatus(function(response) {
                        
            if (response.status === 'connected') {
                // the user is logged in and has authenticated your
                // app, and response.authResponse supplies
                // the user's ID, a valid access token, a signed
                // request, and the time the access token 
                // and signed request each expire                           
                GetUserInfo("SignIn");             
                        

            }  else {
                FBLogin();
            }
        });                   
                   
    //e.preventDefault();
                    
    });
    
    function postFeedToFB(postingId)
    {
        $.ajax({
            type: "GET",
            dataType:"json",
            data:"postingId=" + postingId,
            url: "/post/fbshare/",                       
            success: function(fbshareData){
                             
                if (fbshareData.status == 'success')                                                                   
                {
                    FB.ui(
                    {
                        method: fbshareData.method,			  
                        name: fbshareData.name,
                        caption: fbshareData.caption,
                        description: fbshareData.description,
                        link: fbshareData.link,
                        picture: fbshareData.picture
                    },
                    function(response) {
                        if (response && response.post_id) {
                        saveViewShareEmail(postingId,'Facebook Share'); 
                        } else {
                        //alert('Post was not published.');
                        }
                    }
                    );
                      
                }                                                     
            }
        });
    }
    
    
    $('a.facebook').live("click", function(){
        TrackPageView('/facebook-share'); 
        var postingId = $(this).attr('id').split('_')[1];
        FB.getLoginStatus(function(response) {
                        
            if (response.status === 'connected') {
                postFeedToFB(postingId);

            }  else {
                FB.login(function(response) {
                    if (response.authResponse) {                
                       
                        postFeedToFB(postingId);
                        GetUserInfo("Share");  
                    } else {
            
                    }
                }, {
                    scope: 'email,user_location'
                });
              
            }
        });   
    });
};

(function(d){
    var js, id = 'facebook-jssdk';
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement('script');
    js.id = id;
    js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    d.getElementsByTagName('head')[0].appendChild(js);
}(document));


function updateFbUserInfo(response)
{
    var city = null;
    var state = null;
    try
    {
        var location = response.location.name.split(',');
        city = location[0];
        state = location[1];
    }
    catch (err)
    {
                                        
    } 
    $.ajax({
        type: "GET",   
        cache:false,
        dataType:"jsonp",
        crossDomain:true,   
        url: $("#sso_url").val() + "/admin_user.php?userEmailId=" + response.email 
        + "&userFirstName=" + response.first_name + "&userLastName=" + response.last_name 
        + "&city=" + city + "&state=" + state + "&authenticationType=facebook",
        success: function(ssoResponse) {
            $.ajax({
                type: "GET",
                url: "/user/manage/",
                dataType:"json",
                data: "user_id=" + ssoResponse.user_id + "&authentication_method_id=1&email=" + response.email
                + "&first_name=" + response.first_name + "&last_name=" + response.last_name + "&active_flag=" + ssoResponse.active_flag
                + "&phone=" + ssoResponse.phone + "&address=" + ssoResponse.address + "&state=" + ssoResponse.state + "&city=" + ssoResponse.city + "&country=" + ssoResponse.country
                    + "&lat=" + ssoResponse.lat + "&state=" + ssoResponse.lon + "&screen=",
                success: function(manageUserResponse){                      
                    if (manageUserResponse.status == 'success')
                    {  
                        $('#topnav_my_account').show();
                        $('#topnav_sign_up').hide();   
                        $('#topnav_or').hide();   
                          $('#topnav_sign_in').hide();                                      
                        $('#dialog_sign_in_error').html('');
                        var screen = null;
                        if ($('#dialogSignUp #sign-up-page') != undefined) 
                            screen =  $('#dialogSignUp #sign-up-page').val();                            
                        processLoginSuccess(screen,ssoResponse);
                                
                    }
                    else
                    {
                    //$('#sign_in_status_post_info').html('Unexpected error while sign in.'); 
                    }
                },
                error:function (xhr, ajaxOptions, thrownError, request, error){
                    if(xhr.readyState == 0 || xhr.status == 0) 
                        return;  // it's not really an error
                    else
                    {
                    //$('#sign_in_status_post_info').html('Unexpected error while sign in.');
                    } 
                }    
            });
        },
        error:function (xhr, ajaxOptions, thrownError, request, error){
            if(xhr.readyState == 0 || xhr.status == 0) 
                return;  // it's not really an error
            else
            {
                                               
            } 
        }    

    });
}

function GetUserInfo(action)
{
    FB.api('/me', function(response) {
        
        if (action == "SignIn")
        {
            updateFbUserInfo(response);
        }
        else
        {
            $.ajax({
                type: "GET",   
                cache:false,
                dataType:"jsonp",
                crossDomain:true,   
                url: $("#sso_url").val() + "/check_user.php?userEmailId=" +  response.email,
                success: function(data) {
                    if (data.status == 'Found')     
                    {  
                        $('#user_exists_flag').val('1');
                        if (data.authenticationMethod.toLowerCase() == "facebook")
                        {
                            updateFbUserInfo(response);
                        }
                    }
                }
            });
        
        }
                

    }, {
        scope: 'email,user_location'
    });
                            
}

