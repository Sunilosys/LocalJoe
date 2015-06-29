function getGoogleUserInfo() {
        
    $.ajax({
        url: "/user/getgoogleuserinfo/",
        cache: false,
        dataType:"json",
        success: function(response) {
            if (response.status =='success')
            {
                $.ajax({
                    type: "GET",   
                    cache:false,
                    dataType:"jsonp",
                    crossDomain:true,   
                    url: $("#sso_url").val() + "/admin_user.php?userEmailId=" + response.email 
                    + "&userFirstName=" + response.first_name + "&userLastName=" + response.last_name 
                    + "&authenticationType=google",
                    success: function(ssoResponse) {
                        $.ajax({
                            type: "GET",
                            url: "/user/manage/",
                            dataType:"json",
                            data: "user_id=" + ssoResponse.user_id + "&authentication_method_id=2&email=" + response.email
                            + "&first_name=" + response.first_name + "&last_name=" + response.last_name + "&active_flag=" + ssoResponse.active_flag 
                                + "&phone=" + ssoResponse.phone + "&address=" + ssoResponse.address + "&state=" + ssoResponse.state + "&city=" + ssoResponse.city + "&country=" + ssoResponse.country
                    + "&lat=" + ssoResponse.lat + "&state=" + ssoResponse.lon + "&screen=",
             
                            success: function(manageUserResponse){                      
                                if (response.status == 'success')
                                {  
                                    $('#topnav_my_account').show();
                                    $('#topnav_sign_up').hide();                               
                                    $('#dialog_sign_in_error').html('');
                                    var screen = null;
                                    if ($('#dialogSignUp #sign-up-page') != undefined) 
                                        screen =  $('#dialogSignUp #sign-up-page').val();                                 
                                    processLoginSuccess(screen,ssoResponse);
                                }
                                else
                                {
                                //$('#sign_in_status_post_info').html('Unable to sign in, please try again.'); 
                                }
                            },
                            error:function (xhr, ajaxOptions, thrownError, request, error){
                                if(xhr.readyState == 0 || xhr.status == 0) 
                                    return;  // it's not really an error
                                else
                                {
                                //$('#sign_in_status_post_info').html('Error in sign in, please try again.');
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
        }
    });        
};
   
extensions = {
    'openid.ns.ax' : 'http://openid.net/srv/ax/1.0', 
    'openid.ax.mode' : 'fetch_request', 
    'openid.ax.type.email' : 'http://axschema.org/contact/email', 
    'openid.ax.type.first' : 'http://axschema.org/namePerson/first', 
    'openid.ax.type.last' : 'http://axschema.org/namePerson/last', 
    'openid.ax.type.country' : 'http://axschema.org/contact/country/home', 
    'openid.ax.type.lang' : 'http://axschema.org/pref/language', 
    'openid.ax.type.web' : 'http://axschema.org/contact/web/default', 
    'openid.ax.required' : 'email,first,last,country,lang,web', 
    'openid.ns.oauth' : 'http://specs.openid.net/extensions/oauth/1.0', 
    'openid.oauth.consumer' : 'www.puffypoodles.com', 
    'openid.oauth.scope' : 'http://www.google.com/m8/feeds/' , 
    'openid.ui.icon' : 'true'
} ;
googleOpener = popupManager.createPopupOpener(
{
    'realm' : 'http://*.localjoe.com',
    'opEndpoint' : 'https://www.google.com/accounts/o8/ud',
    'returnToUrl' : 'http://' + location.host + '/user/checkauth/?login_type=popup',
    'onCloseHandler' : getGoogleUserInfo,
    'shouldEncodeUrls' : true,
    'extensions' : extensions
});
$('#google_button').live("click", function(){
   
    TrackPageView('/google-signin'); 
    if ($("#dialogAccountExists").length){
        $("#dialogAccountExists").dialog('close');
    }
    $('#dialogSignUp').dialog("close");                                                               
    googleOpener.popup(450,500);
    return true;
});