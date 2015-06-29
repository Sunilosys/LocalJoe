
$('#dialog_sign_in_error').html('');  
signin = function(email,pwd,screen){ 
   
    TrackPageView('/website-signin');
    $.ajax({
        global:false,
        type: "GET",   
        cache:false,
        dataType:"jsonp",
        crossDomain:true,   
        url: $("#sso_url").val() + "/login.php?action=login&userEmailId=" +  email + "&userPwd=" + $.md5(pwd) +"&authenticationType=website" + "&screen=" + screen,
        success: function(data) {
           
            if (data.status == 'success')     
            {  
                           
                $.ajax({
                    global:false,
                    type: "GET",
                    dataType:"json",
                    url: "/user/manage/",
                    data: "user_id=" + data.user_id + "&authentication_method_id=0&email=" + data.email
                    + "&first_name=" + data.first_name + "&last_name=" + data.last_name + "&active_flag=" + data.active_flag
                    + "&phone=" + data.phone + "&address=" + data.address + "&state=" + data.state + "&city=" + data.city + "&country=" + data.country
                    + "&lat=" + data.lat + "&state=" + data.lon +  "&screen=" + screen,    
                    success: function(manageUserResponse){

                        if (manageUserResponse.status == "success")
                        {
                            processLoginSuccess(screen,data);
                            if (manageUserResponse.user_type_id == '1')
                            {
                                $('#topnav_admin').show(); 
                            }
                            else
                            {
                                $('#topnav_admin').hide();  
                            }
                        }
                        else
                        {
                                
                            if (screen == "change-email")
                            {
                                $('.change-email-section #change_email_error').show();
                                
                                $('.change-email-section #change_email_error').html('Unexpected Error Occurred.'); 
                            }
                            else
                                $('#dialog_sign_in_error').html('Unexpected Error Occurred.');   
                        }
                           
                    },
                    error:function (xhr, ajaxOptions, thrownError, request, error){
                        if(xhr.readyState == 0 || xhr.status == 0) 
                            return;  // it's not really an error
                        else
                        {
                            if (screen == "change-email")
                            {
                                $('.change-email-section #change_email_error').show();
                                
                                $('.change-email-section #change_email_error').html('Unexpected Error Occurred.'); 
                            }
                            else
                                $('#dialog_sign_in_error').html('Unexpected Error Occurred.');                                
                        } 
                    }    
                });                                
                                
            }
            else 
            {                                   
                
                if (screen == "change-email")
                {
                    $('.change-email-section #change_email_error').show();
                                
                    $('.change-email-section #change_email_error').html(data.errorMessage); 
                }
                else
                    $('#dialog_sign_in_error').html(data.errorMessage);  
             
            }
        },
        error:function (xhr, ajaxOptions, thrownError, request, error){
            if(xhr.readyState == 0 || xhr.status == 0) 
                return;  // it's not really an error
            else
            {
                if (screen == "change-email")
                {
                    $('.change-email-section #change_email_error').show();
                                
                    $('.change-email-section #change_email_error').html('Unexpected Error Occurred.'); 
                }
                else
                    $('#dialog_sign_in_error').html('Unexpected Error Occurred.');  
                  
                               
            } 
        }    

    });
   
}

register = function(firstName,lastName,email,pwd,screen){
    TrackPageView('/website-signup');   
    $('#register_status').html('');                     
    $.ajax({
        type: "GET",   
        cache:false,
        dataType:"jsonp",
        crossDomain:true,   
        url: $("#sso_url").val() + "/login.php?action=registration&userFirstName=" + firstName + 
        "&userLastName=" + lastName +"&userEmailId=" + email + 
        "&userPwd=" + $.md5(pwd) +  "&authenticationType=website",
        success: function(data) {
            if (data.status == 'success')     
            {  
                              
                $.ajax({
                    global:false,
                    type: "GET",
                    dataType:"json",
                    url: "/user/manage/",
                    data: "user_id=" + data.user_id + "&authentication_method_id=0&email=" + data.email
                    + "&first_name=" + data.first_name + "&last_name=" + data.last_name + "&active_flag=" + data.active_flag 
                    + "&city=" + data.city + "&state=" + data.state,
                    success: function(manageUserResponse){
                                      
                        if (manageUserResponse.status == "success")
                        {                                              
                            processLoginSuccess(screen,data);
                        }
                        else
                        {
                            $('#register_status').html('Unexpected error while sign in.'); 
                        }
                    },
                    error:function (xhr, ajaxOptions, thrownError, request, error){
                        if(xhr.readyState == 0 || xhr.status == 0) 
                            return;  // it's not really an error
                        else
                        {
                                            
                            $('#register_status').html('Unexpected error while sign in.');
                        } 
                    }    
                });                                
                                
            }
            else 
            {
                $('#register_status').html(data.errorMessage); 
            }
        },
        error:function (xhr, ajaxOptions, thrownError, request, error){
            if(xhr.readyState == 0 || xhr.status == 0) 
                return;  // it's not really an error
            else
            {
                $('#register_status').html('Unexpected Error Occurred while sign in.');
            } 
        }    

    });
                                
        
                            
}

checkIfTokenExists = function(screen) {
    var authentication_method_id = 0;
    if (screen == 'checkGoogleLogin')
        authentication_method_id = 2;
   
    $.ajax({
        type: "GET",   
        cache:false,
        dataType:"jsonp",
        crossDomain:true,   
        url: $("#sso_url").val() + "/checkIfTokenExists.php",
        success: function(data) {
            if (data.status == 'success')     
            {  
                if (userLoggedIn == 0)
                {
                    $.ajax({
                        global:false,
                        type: "GET",
                        dataType:"json",
                        url: "/user/manage/",
                        data: "user_id=" + data.user_id + "&authentication_method_id= " + authentication_method_id + "&email=" + data.email
                        + "&first_name=" + data.first_name + "&last_name=" + data.last_name + "&active_flag=" + data.active_flag
                        + "&phone=" + data.phone + "&address=" + data.address + "&state=" + data.state + "&city=" + data.city + "&country=" + data.country
                        + "&lat=" + data.lat + "&state=" + data.lon +  "&screen=",
                        success: function(manageUserResponse){
                                      
                            if (manageUserResponse.status == "success")
                            {                              
                                processLoginSuccess(screen,data);
                                if (manageUserResponse.user_type_id == '1')
                                {
                                    $('#topnav_admin').show(); 
                                }
                                else
                                {
                                    $('#topnav_admin').hide();  
                                }
                            }  
                      
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
                                
            } else 
{
                if (userLoggedIn == 1)
                    signOut();
            }
          
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
    
checkExistingUser = function(){
    $.ajax({
        global:false,
        type: "GET",   
        cache:false,
        dataType:"jsonp",
        crossDomain:true,   
        url: $("#sso_url").val() + "/check_user.php?userEmailId=" +  $('#reply_email_addr').val(),
        success: function(data) {
                      
            if (data.status == 'Found')     
            {  
                $('#user_exists_flag').val('1');
                if (data.authenticationMethod.toLowerCase() == "website")
                {
                    $('#dialogSignUp #sign_in_email').val($('#reply_email_addr').val()); 
                    $('#dialogSignUp #sign_in_email').attr('readonly','readonly');  
                    $('#dialogSignUp #sign-up-page').val("createpost-post-info"); 
                    $('#dialogSignUp .join-tab').hide();
                    $('#dialogSignUp .signin-tab').show();
                    $('.button.register').hide();
                    $('.button.login').show();
                    $('#dialogSignUp a.button-facebook-large').hide();
                    $('#dialogSignUp a.button-google-large').hide();                
                    $('#dialogSignUp #sign_in_exists').show();
                    $('#dialogSignUp #signin-header').hide();
                    $('.signup .ui-dialog-titlebar-close').hide();                        
                    $('#dialogSignUp').dialog('open'); 
                }
                else if (data.authenticationMethod.toLowerCase() == "facebook") 
                {
                    $(".account-exists-social-signin #fb_button").show();
                    $(".account-exists-social-signin #google_button").hide();
                    $("#dialogAccountExists .signin-tab").show();
                    $("#dialogAccountExists #fb_sign_in_exists").show();
                    $("#dialogAccountExists #google_sign_in_exists").hide();
                    $('#fb_button').click();
                }
                else if (data.authenticationMethod.toLowerCase() == "google") 
                {
                    $(".account-exists-social-signin #fb_button").hide();
                    $(".account-exists-social-signin #google_button").show();
                    $("#dialogAccountExists .signin-tab").show();
                    $("#dialogAccountExists #google_sign_in_exists").show();
                    $("#dialogAccountExists #fb_sign_in_exists").hide();
                    $('#google_button').click();
                }
                   
               
            } 
            else
            {
                $('#user_exists_flag').val('0'); 
            }
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
    
changePassword = function($userId,$oldPassword,$newPassword){
    $.ajax({
        global:false,
        type: "GET",   
        cache:false,
        dataType:"jsonp",
        crossDomain:true,   
        url: $("#sso_url").val() + "/change_password.php?userId=" +  $userId + "&oldPassword=" + $.md5($oldPassword) + "&newPassword=" + $.md5($newPassword),
        success: function(data) {
                      
            if (data.status == 'success')     
            {                   
                $(".change-password-content .save").parents('.group').find('.content').show();
                $(".change-password-content .save").parents('.group').find('.edit-content').hide();
                $(".change-password-content .save").parents('.group').find('.edit').removeAttr('style');
                $("#dialogChangePassword").html(data.message);
            } 
            else
            {
                $("#dialogChangePassword").html(data.message);
            }
            $("#dialogChangePassword").dialog('open');
            $( "#dialogChangePassword" ).dialog('widget').position({
                my:"left top",
                at:"right top",
                of: '.change-password',
                offset: "15 -20"
            });
            setTimeout(function(){
                $("#dialogChangePassword").dialog("close")
            },3000);
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

updateName = function($userId,$firstName,$lastName){
    $.ajax({
        global:false,
        type: "GET",   
        cache:false,
        dataType:"jsonp",
        crossDomain:true,   
        url: $("#sso_url").val() + "/update_name.php?userId=" +  $userId + "&userFirstName=" + $firstName + "&userLastName=" + $lastName,
        success: function(data) {
                      
            if (data.status == 'success')     
            {   
                $.ajax({
                    global:false,
                    type: "GET",
                    dataType:"json",
                    url: "/user/update/",
                    data: "user_id=" + $userId + "&first_name=" + $firstName + "&last_name=" + $lastName + "&update_type=name",
                    success: function(data){

                        if (data.status == "success")
                        {
                            $("#nameEditContainer").hide();
                            $(".myaccount-right-side .edit").removeAttr('style');
                            $(".profile-title").html($firstName + ' ' + $lastName);
                            $("#nameEditContainer #hidden_first_name").val($firstName);
                            $("#nameEditContainer #hidden_last_name").val($lastName);
                            $("#dialogChangePassword").html(data.message);
                        }
                        else
                            $("#dialogChangePassword").html(data.message);
                        $("#dialogChangePassword").dialog('open');
                        $( "#dialogChangePassword" ).dialog('widget').position({
                            my:"left top",
                            at:"right top",
                            of: '.profile-title',
                            offset: "15 -20"
                        });
                        setTimeout(function(){
                            $("#dialogChangePassword").dialog("close")
                        },3000);
                           
                    },
                    error:function (xhr, ajaxOptions, thrownError, request, error){
                        if(xhr.readyState == 0 || xhr.status == 0) 
                            return;  // it's not really an error
                        else
                        {
                            $("#dialogChangePassword").html(data.message); 
                            $("#dialogChangePassword").dialog('open');
                            $( "#dialogChangePassword" ).dialog('widget').position({
                                my:"left top",
                                at:"right top",
                                of: '.profile-title',
                                offset: "15 -20"
                            });
                            setTimeout(function(){
                                $("#dialogChangePassword").dialog("close")
                            },3000);
                        } 
                    }    
                });                      
               
               
            } 
            else
            {
                $("#dialogChangePassword").html(data.message);
                $("#dialogChangePassword").dialog('open');
                $( "#dialogChangePassword" ).dialog('widget').position({
                    my:"left top",
                    at:"right top",
                    of: '.profile-title',
                    offset: "15 -20"
                });
                setTimeout(function(){
                    $("#dialogChangePassword").dialog("close")
                },3000);
            }
           
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

updatePhone = function($userId,$phone){
    $.ajax({
        global:false,
        type: "GET",   
        cache:false,
        dataType:"jsonp",
        crossDomain:true,   
        url: $("#sso_url").val() + "/update_phone.php?userId=" +  $userId + "&phone=" + $phone ,
        success: function(data) {
                      
            if (data.status == 'success')     
            {   
                $.ajax({
                    global:false,
                    type: "GET",
                    dataType:"json",
                    url: "/user/update/",
                    data: "user_id=" + $userId + "&phone=" + $phone + "&update_type=phone",
                    success: function(data){

                        if (data.status == "success")
                        {
                            $("#phoneEditContainer").hide();
                            $(".phone-content").show();
                            $(".phone-content .edit").removeAttr('style');
                            $(".profile-phone").html($phone);
                
                
                            $("#dialogChangePassword").html(data.message);
                        }
                        else
                            $("#dialogChangePassword").html(data.message);  
                        $("#dialogChangePassword").dialog('open');
                        $( "#dialogChangePassword" ).dialog('widget').position({
                            my:"left top",
                            at:"right top",
                            of: '.profile-phone',
                            offset: "15 -20"
                        });
                        setTimeout(function(){
                            $("#dialogChangePassword").dialog("close")
                        },3000);
                           
                    },
                    error:function (xhr, ajaxOptions, thrownError, request, error){
                        if(xhr.readyState == 0 || xhr.status == 0) 
                            return;  // it's not really an error
                        else
                        {
                            $("#dialogChangePassword").html(data.message);  
                            $("#dialogChangePassword").dialog('open');
                            $( "#dialogChangePassword" ).dialog('widget').position({
                                my:"left top",
                                at:"right top",
                                of: '.profile-phone',
                                offset: "15 -20"
                            });
                            setTimeout(function(){
                                $("#dialogChangePassword").dialog("close")
                            },3000);                            
                        } 
                    }    
                });                      
               
               
            } 
            else
            {
                $("#dialogChangePassword").html(data.message);
                $("#dialogChangePassword").dialog('open');
                $( "#dialogChangePassword" ).dialog('widget').position({
                    my:"left top",
                    at:"right top",
                    of: '.profile-phone',
                    offset: "15 -20"
                });
                setTimeout(function(){
                    $("#dialogChangePassword").dialog("close")
                },3000);
            }
            
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

updateEmail = function($userId,$emailId){
    $.ajax({
        global:false,
        type: "GET",   
        cache:false,
        dataType:"jsonp",
        crossDomain:true,   
        url: $("#sso_url").val() + "/add_new_email.php?userId=" +  $userId + "&userEmailId=" + $emailId ,
        success: function(data) {
                      
            if (data.status == 'success')     
            {   
                $.ajax({
                    global:false,
                    type: "GET",
                    dataType:"json",
                    url: "/user/update/",
                    data: "user_id=" + $userId + "&emailId=" + $emailId + "&update_type=email",
                    success: function(data){

                        if (data.status == "success")
                        {
                            $("#emailEditContainer").hide();
                            $(".email-content").show();
                            $(".email-content .edit").removeAttr('style');
                         
                            $("#dialogChangePassword").html(data.message);
                        }
                        else
                            $("#dialogChangePassword").html(data.message);  
                        $("#dialogChangePassword").dialog('open');
                        $( "#dialogChangePassword" ).dialog('widget').position({
                            my:"left top",
                            at:"right top",
                            of: '.profile-email',
                            offset: "15 -20"
                        });
                        setTimeout(function(){
                            $("#dialogChangePassword").dialog("close")
                        },3000);
                           
                    },
                    error:function (xhr, ajaxOptions, thrownError, request, error){
                        if(xhr.readyState == 0 || xhr.status == 0) 
                            return;  // it's not really an error
                        else
                        {
                            $("#dialogChangePassword").html("Unexpected Error Occurred. Please contact support by sending email to admin@localjoe.com");  
                            $("#dialogChangePassword").dialog('open');
                            $( "#dialogChangePassword" ).dialog('widget').position({
                                my:"left top",
                                at:"right top",
                                of: '.profile-email',
                                offset: "15 -20"
                            });
                            setTimeout(function(){
                                $("#dialogChangePassword").dialog("close")
                            },3000);                            
                        } 
                    }    
                });                      
               
               
            } 
            else
            {
                $("#dialogChangePassword").html(data.message);
                $("#dialogChangePassword").dialog('open');
                $( "#dialogChangePassword" ).dialog('widget').position({
                    my:"left top",
                    at:"right top",
                    of: '.profile-email',
                    offset: "15 -20"
                });
                setTimeout(function(){
                    $("#dialogChangePassword").dialog("close")
                },3000);
            }
          
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


updateAddress = function($userId,$address,$city,$zipCode,$lat,$lon){
    $.ajax({
        global:false,
        type: "GET",   
        cache:false,
        dataType:"jsonp",
        crossDomain:true,   
        url: $("#sso_url").val() + "/update_address.php?userId=" +  $userId + "&address=" + $address
        + "&city=" + $city + "&zip=" + $zipCode + "&lat=" + $lat + "&lon=" + $lon,
        success: function(data) {
                      
            if (data.status == 'success')     
            {   
                $.ajax({
                    global:false,
                    type: "GET",
                    dataType:"json",
                    url: "/user/update/",
                    data: "user_id=" + $userId + "&address=" + $address
                    + "&city=" + $city + "&zip=" + $zipCode + "&lat=" + $lat + "&lon=" + $lon + "&update_type=address",
                    success: function(data){

                        if (data.status == "success")
                        {
                            $("#addressEditContainer").hide();
                            $(".address-content").show();
                            $(".address-content .edit").removeAttr('style');
                            $(".profile-address").html($address);
                
                
                            $("#dialogChangePassword").html(data.message);
                        }
                        else
                            $("#dialogChangePassword").html(data.message);
                        $("#dialogChangePassword").dialog('open');
                        $( "#dialogChangePassword" ).dialog('widget').position({
                            my:"left top",
                            at:"right top",
                            of: '.profile-address',
                            offset: "15 -20"
                        });
                        setTimeout(function(){
                            $("#dialogChangePassword").dialog("close")
                        },3000);
                           
                    },
                    error:function (xhr, ajaxOptions, thrownError, request, error){
                        if(xhr.readyState == 0 || xhr.status == 0) 
                            return;  // it's not really an error
                        else
                        {
                            $("#dialogChangePassword").html(data.message);  
                            $("#dialogChangePassword").dialog('open');
                            $( "#dialogChangePassword" ).dialog('widget').position({
                                my:"left top",
                                at:"right top",
                                of: '.profile-address',
                                offset: "15 -20"
                            });
                            setTimeout(function(){
                                $("#dialogChangePassword").dialog("close")
                            },3000);                            
                        } 
                    }    
                });                      
               
               
            } 
            else
            {
                $("#dialogChangePassword").html(data.message);
                $("#dialogChangePassword").dialog('open');
                $( "#dialogChangePassword" ).dialog('widget').position({
                    my:"left top",
                    at:"right top",
                    of: '.profile-address',
                    offset: "15 -20"
                });
                setTimeout(function(){
                    $("#dialogChangePassword").dialog("close")
                },3000);
            }
           
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




function sendActivationLink()
{
    $.ajax({
        type: "GET",
        dataType:"json",
        url: "/user/sendactivationlink/",                       
        success: function(data){
            
            if (data.status == 'success')
            {
                $("#dialogSendActivation").html(data.message);
                $("#dialogSendActivation").dialog('open');
                $( "#dialogSendActivation" ).dialog('widget').position({
                    my:"left top",
                    at:"right top",
                    of: '.send-activation-link',
                    offset: "15 -20"
                });
                setTimeout(function(){
                    $("#dialogSendActivation").dialog("close")
                },3000);
            }          
        }  
    });  
}

function signOut()
{
    
    $.ajax({
        type: "GET",
        dataType:"json",
        url: "/user/signout/",                       
        success: function(data){
            
            if (data.status == 'success')
            {
                //Clear Token
                $.ajax({
                    type: "GET",   
                    cache:false,
                    dataType:"jsonp",
                    crossDomain:true,   
                    url: $("#sso_url").val() + "/logout.php"                    
                });
                $('#topnav_my_account').hide();
                $('#topnav_admin').hide();
                $('#topnav_sign_up').show(); 
                $('#topnav_or').show(); 
                $('#topnav_sign_in').show(); 
                $('#top-menu .top-nav-sign-in').show() ;
                $('.top-nav-sign-out').hide() ;
                $('#top-menu .top-nav-user').hide() ;
                $('#logged_in_username').val('');
                window.location = "/#page=home";
                if (typeof FB != 'undefined') 
                {
                    FB.logout(function(response) {
                        //Facebook user is not logged out
                        });  
                }
            }          
        }  
    });  
}

function processLoginSuccess(screen,data)
{
   
    if (screen =="createpost-post-info")
    {      
        $('#preview_user').html(data.first_name + ' ' + data.last_name); 
        $('#logged_in_username').val(data.first_name + ' ' + data.last_name); 
        
        $('#reply_email_addr').val(data.email);
        $('#reply_email_addr').attr('readonly','readonly');                                
                                                                          
        $('#post_info_form #fb_button').hide();  
        $('#post_info_form #google_button').hide() ;                      
        $('#reply_email_addr').attr('readonly','readonly');
        $("#uploadFileListing").html("");
                               
        $.ajax({
            global:false,
            type: "GET",
            dataType:"json",
            url: "/user/getlocation/",                       
            success: function(location){
                if (location.address != "")
                {
                    $('#location_address').val(location.address) ;
                    $('#location_lat').val(location.lat) ;
                    $('#location_lon').val(location.lon) ;
                    $('#zip_code').val(location.zip) ;
                    $('#location_city').val(location.city) ;                                              
                    if ($('#phone_no').val().length > 0 && $('#phone_no').val() != phoneformat )
                        $('#phone_no').val(location.phone) ;                                          
                                            
                }
            }
        });
                            
    } else if (screen == "createpost-preview")
{
        createPost();
    } else if (screen == "saved-search-left-nav")
{
        $("#saved_search_error").hide();
        $("#saved_search_name").val('');
        $("#dialogSaveSearch").dialog("open"); 
    //positionDialogs();
    }
    else if (screen == "short-list-left-nav")
    {
        $("#short_list_error").hide();
        $("#short_list_name").val('');
        $("#dialogShortlist").dialog("open"); 
    //positionDialogs();
    }
    else if (screen == "flag-post-spam")
    {
        if ($('#spam_posting_id') && $('#flag_span_action'))
            flagPostAsSpam($('#spam_posting_id').val(),$('#flag_span_action').val());
    
    }
    else if (screen == "homepage-ref-profile")
    {
        window.location = "#page=profile";
    }
    else if (screen == "reset-password")
    {
        window.location = "#page=profile&ref=resetpwd";
        
    }
    else if (screen == "change-email")
    {
        
        window.location = "#page=profile&ref=changeemail";
        
    }
    else
    {
        var href = window.location.href;
        if (href.toLowerCase().indexOf('#page=home') != -1)
            window.location = "#page=profile";
        else if (href.toLowerCase().indexOf('#page=search') != -1)
        {
            //Get User Shortlist       
            LoadUserShortlists();
            //Get user saved searches
            LoadUserSavedSearches();
            var pageUrl = $.param.fragment();   
            searchByObject($.deparam(pageUrl));
        }
        else if (href.toLowerCase().indexOf('#page=profile') != -1)
        {
            window.location =  "#page=profile";
        } else if (href.toLowerCase().indexOf('#page=createpost') != -1)
{
       
            $('#preview_user').html(data.first_name + ' ' + data.last_name); 
           
       
            $('#reply_email_addr').val(data.email);
            $('#reply_email_addr').attr('readonly','readonly');                                
                                                                          
            $('#post_info_form #fb_button').hide();  
            $('#post_info_form #google_button').hide() ;                      
            $('#reply_email_addr').attr('readonly','readonly');
            $("#uploadFileListing").html("");
        
        }
    }
    
    $('#topnav_my_account').show();
    $('#top-menu .top-nav-sign-in').hide() ; 
    $('.top-nav-sign-out').show() ;
    $('#top-menu .top-nav-user a').html(data.first_name + ' ' + data.last_name);
    $('#top-menu .top-nav-user').show() ;
    $('#topnav_sign_up').hide();
    $('#topnav_sign_in').hide();
    $('#topnav_or').hide();
    ResetDialogSignUp();
    $('#dialogSignUp').dialog("close");                               
    $('#dialog_sign_in_error').html(''); 
    //Dialog Send Response
    $('#dialogSendResponse #send_response_your_name').val(data.first_name + ' ' + data.last_name);
    $('#logged_in_username').val(data.first_name + ' ' + data.last_name); 
    $('#dialogSendResponse #send_response_email_id').val(data.email);
}
     
     
function ResetDialogSignUp()
{
    $('.signup .ui-dialog-titlebar-close').show();  
    $('#dialogSignUp #sign_in_email').empty(); 
    $('#spam_posting_id').val('');
    $('#flag_span_action').val('');
    //$('#dialogSignUp #sign_in_email').attr('readonly','');  
    $('#dialogSignUp #sign-up-page').empty();
    $('#dialogSignUp .join-tab').show();
    $('#dialogSignUp .signin-tab').hide();
    $('#dialogSignUp #fb_button_signin').show();
    $('#dialogSignUp #google_button_signin').show();
    $('#dialogSignUp #sign_in_exists').hide();
    $('#dialogSignUp .reset-password-tab').hide();
    $('#dialogSignUp .button.submit').hide();
    $('#dialogSignUp .button.ok').hide();
    $('#dialogSignUp #dialog_reset_pwd_msg').empty(); 
    $('#dialogSignUp #dialog_reset_pwd_msg').hide() ;
}

     
function ResetDialogSendResponse()
{

    $('#DialogSendResponse #send_response_subject').empty();
    $('#DialogSendResponse #send_response_body').val('I am interested in your post. Please contact me.')
}
$('document').ready(function(){
    	 
    $("#dialogChangePassword").dialog({
        autoOpen:false,
        draggable: false, 
        resizable: false, 
        modal: true,
        dialogClass: 'left notitle',
        width: 250,
        buttons: [       
        {
            text: "Ok",
            create: function(event, ui) {
                $(this).addClass("button medium primary");
            },
            click: function() {
                $(this).dialog("close");
            }
            
        }   
        ]
    });   
    $("#dialogSendActivation").dialog({
        autoOpen:false,
        draggable: false, 
        resizable: false, 
        modal: true,
        dialogClass: 'left notitle',
        width: 250, 
        buttons: [       
        {
            text: "Ok",
            create: function(event, ui) {
                $(this).addClass("button medium primary");
            },
            click: function() {
                $(this).dialog("close");
            }
            
        }   
        ]
    }); 
    $("#dialogActivationHelp").dialog({
        autoOpen:false,
        draggable: false, 
        resizable: false, 
        modal: true,
        //        hide: {effect: "fadeOut", duration: 2000},
        //        show: {effect: "fadeIn", duration: 2000},
        dialogClass: 'left notitle',
        width: 300, 
        buttons: [       
        {
            text: "Ok",
            create: function(event, ui) {
                $(this).addClass("button medium primary");
            },
            click: function() {
                $(this).dialog("close");
            }
            
        }   
        ]
    }); 
    $('#dialogAccountExists').dialog({
        autoOpen: false,       
        resizable: false, 
        modal: true,        
        dialogClass: 'dialog signup'              
   
    });
    
    $('#dialogSignUp').dialog({
        autoOpen: false, 
        width: 296, 
        resizable: false, 
        modal: true, 
        dialogClass: 'dialog signup',
        open: function(event, ui) { 
            $('#dialogSignUp input').blur();
        },
        buttons: [
        {
            text: "Register",
            create: function(event, ui) {
                $(this).addClass("register button medium primary");
            },
            click: function(event, ui)
            {
                if ($("#register_first_name").val() =='First Name')
                    $("#register_first_name").val('');
                if ($("#register_last_name").val() =='Last Name')
                    $("#register_last_name").val('');
                if ($("#register_email").val() =='Email')
                    $("#register_email").val('');
                if ($("#register_pwd").val() =='Password')
                    $("#register_pwd").val('');
                if ($("#register_retype_pwd").val() =='Retype Password')
                    $("#register_retype_pwd").val('');
                validate =  $("#register_form").validate({
                    rules: {                           
              
                        register_first_name:"required",
                        register_last_name:"required",                                   
                        register_email: {
                            required:true,
                            email:true
                        },
                        register_pwd:"required",
                        register_retype_pwd: {
                                                  
                            equalTo: "#register_pwd"
                        }
                    },
                    messages: {
               
                        register_first_name:"First Name is required.",
                        register_last_name:"Last Name is required.",                         
                        register_email: {   
                            required:"Email is required.",
                            email:"Please enter a valid email address."
                        },   
                        register_pwd:"Password is required.", 
                        register_retype_pwd: {     
                   
                            equalTo: "Please retype the same password."
                        }
                    }
                });
       
                var isRegisterFNValid = validate.element( "#register_first_name" );
                var isRegisterLNValid = validate.element( "#register_last_name" );
                var isRegisterEmailValid = validate.element( "#register_email" );
                var isRegisterPwdValid = validate.element( "#register_pwd" );
                var isRegisterRetypePwdValid = validate.element( "#register_retype_pwd" );
                if (isRegisterFNValid && isRegisterLNValid && isRegisterEmailValid 
                    && isRegisterPwdValid && isRegisterRetypePwdValid)
                    {  
                    
                    var screen = $('#sign-up-page').val();  
                    register($('#register_first_name').val(),$('#register_last_name').val(),$('#register_email').val(),
                        $('#register_pwd').val(),screen);                  
                   
                }
                else
                {
                    $("#register_first_name").attr('title','First Name');
                    $("#register_last_name").attr('title','Last Name');
                    $("#register_email").attr('title','Email');
                    $("#register_pwd").attr('title','Password');
                    $("#register_retype_pwd").attr('title','Retype Password');
                } 
            }
        },
        {
            text: "Sign In",
            create: function(event, ui) {
                $(this).addClass("login button medium primary").hide();
            },
            click: function(event,ui) 
            {
            
                if ($("#sign_in_email").val() =='Email')
                    $("#sign_in_email").val('');
                if ($("#sign_in_pwd").val() =='Password')
                    $("#sign_in_pwd").val('');
                var validateForm =  $("#sign_in_form").validate({
                    rules: {                           
                        sign_in_email: {
                            required:true,
                            email:true
                        },
                        sign_in_pwd: "required"                           
                                    
                    },
                    messages: {                                   
                        sign_in_email: {  
                            required:"Enter your email address.",
                            email:"Email address is invalid."
                        },
                        sign_in_pwd:"Enter your password."
                
                                   
                    }
                });
                          
                var isEmailValid = validateForm.element("#sign_in_email");
                var isPwdValid = validateForm.element("#sign_in_pwd");
         
                if (isEmailValid && isPwdValid)
                {                  
                    var screen = $('#sign-up-page').val();      
                    signin($('#sign_in_email').val(),$('#sign_in_pwd').val(),screen);
                    
                }
      
            }
        },
        {
            text: "Submit",
            create: function(event, ui) {
                $(this).addClass("submit button medium primary").hide();
            },
            click: function(event,ui) 
            {
            
                if ($("#reset_pwd_email").val() =='Email')
                    $("#reset_pwd_email").val('');
               
                var validateForm =  $("#reset_password_form").validate({
                    rules: {                           
                        reset_pwd_email: {
                            required:true,
                            email:true
                        }                         
                                    
                    },
                    messages: {                                   
                        reset_pwd_email: {  
                            required:"Enter your email address.",
                            email:"Email address is invalid."
                        }
                
                                   
                    }
                });
                          
                var isEmailValid = validateForm.element("#reset_pwd_email");
               
                if (isEmailValid)
                {
                     
                    
                    
                    
                    $.ajax({
                        global:false,
                        type: "GET",   
                        cache:false,
                        dataType:"jsonp",
                        crossDomain:true,   
                        url: $("#sso_url").val() + "/check_user.php?userEmailId=" +  $('#reset_pwd_email').val(),
                        success: function(data) {
                            var sendEmail = '1';
                            var userId = 0;
                            if (data.status == 'Found')     
                            {  
               
                                if (data.authenticationMethod.toLowerCase() != "website")
                                {
                                    sendEmail = '0'; 
                                }
                                userId = data.userId;
                            } 
                            else
                            {
                                sendEmail = '0'; 
                            }
                            $.ajax({
                                type: "GET",
                                dataType:"json",
                                url: "/user/resetpwdemail/",
                                data:'userId=' + userId  + '&emailId=' + $('#reset_pwd_email').val() + '&sendEmail=' + sendEmail ,
                                success: function(data){
                             
                                    if (data.status == 'success')                                                                   
                                    {
                                        $('#dialog_reset_pwd_msg').html(data.message); 
                                      
                                        $('#dialogSignUp #reset_pwd_email').hide();
                                        $('#dialogSignUp #dialog_reset_pwd_msg').show();
                                        $('.dialog .button.submit').hide();
                                        $('.dialog .button.ok').show();
                                        $('#dialogSignUp #dialog_reset_pwd_error').hide();
                                    }   
                                    else
                                    {
                                        $('#dialogSignUp #dialog_reset_pwd_msg').hide();
                                        $('#dialogSignUp #dialog_reset_pwd_error').show();
                                        $('#dialogSignUp #dialog_reset_pwd_error').html(data.message);        
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
        },
        {
            text: "Ok",
            click: function() {
                $(this).dialog("close");
            },
            create: function(event, ui) {
                $(this).addClass("ok button medium primary").hide();
            }
        }   
        ]
    });
    $('#dialogSendResponse').dialog({
        autoOpen: false, 
        width: 620, 
        resizable: false, 
        modal: true, 
        dialogClass: 'dialog signup dialog-send-response',
        open: function(event, ui) { 
            $('#dialogSendResponse input').blur();
        },
        buttons: [
        {
            text: "Send",
            create: function(event, ui) {
                $(this).addClass("send button medium primary");
            },
            click: function(event, ui)
            {
                if ($("#send_response_your_name").val() =='Your Name')
                    $("#send_response_your_name").val('');                
                if ($("#send_response_email_id").val() =='Your Email Id')
                    $("#send_response_email_id").val('');
                if ($("#send_response_subject").val() =='Subject')
                    $("#send_response_subject").val('');
                
                validate =  $("#send_response_form").validate({
                    rules: {                           
              
                        send_response_your_name:"required",
                        send_response_subject:"required",   
                        send_response_email_id: {
                            required:true,
                            email:true
                        }                        
                    },
                    messages: {
               
                        send_response_your_name:"Your Name is required.",
                        send_response_subject:"Subject is required.",
                        send_response_email_id: {   
                            required:"Email Id is required.",
                            email:"Please enter a valid email Id."
                        }                       
                    }
                });
       
                var isSendResponseYNValid = validate.element( "#send_response_your_name" );
                var isSendResponseEmailValid = validate.element( "#send_response_email_id" ); 
                var message = "";
                var smsBody = "";
                message = message + tinyMCE.get('send_response_body').getContent();
                smsBody = smsBody + tinyMCE.get('send_response_body').getContent();
                var contactNo = "";
                if($('#send_response_contact_no').val() != "Your Contact No" && $('#send_response_contact_no').val() != phoneformat)
                    contactNo = $('#send_response_contact_no').val();
                //Attach user informatiom to message
                message = message + '<br/>' + 'Contact Information:<br/>';
                message = message + $('#send_response_your_name').val();
                message = message + '<br/>' + $('#send_response_email_id').val();
                if (contactNo != undefined && contactNo != "")
                {
                    message = message + '<br/>' + $('#send_response_contact_no').val();
                }
                //End
                message = escape(message);
                var enableSMS = '0';
                if ($('#sendSMS').is(":checked"))    
                    enableSMS = '1';
               
                if (isSendResponseYNValid && isSendResponseEmailValid)
                {  
                                 
                    $.ajax({
                        type: "GET",
                        dataType:"json",
                        url: "/post/sendresponse/",
                        data:'postingId=' + $('#send_response_posting_id').val() + 
                        '&emailId=' + $('#send_response_email_id').val() +
                        '&senderName=' + $('#send_response_your_name').val() +
                        '&senderContactNo=' + contactNo +
                        '&subject=' + $('#send_response_subject').val() +
                        '&message=' + message +
                        '&enableSMS=' + enableSMS +
                        '&smsBody=' + smsBody ,
                        success: function(data){
                             
                            if (data.status == 'success')                                                                   
                            {
                                $('#dialogSendResponse').dialog('close'); 
                            }   
                            else
                            {
                                $('#send_response_staus').val(data.message);        
                            }
                        }
                    });
                }
                else
                {
                    $("#send_response_your_name").attr('title','Your Name');
                    $("#send_response_contact_no").attr('title','Your Contact No');
                    $("#send_response_email_id").attr('title','Your Email Id');
                    $("#send_response_subject").attr('title','Subject');
                } 
            }
        }]
    });
});




$("#dialogRepost").dialog({
    autoOpen:false,
    draggable: false, 
    resizable: false, 
    modal: true,
    dialogClass: 'notitle',
    width: 185, 
    buttons: [
    {
        text: "Cancel",            
        click: function() {
            $(this).dialog("close");
        },
        create: function(event, ui) {
            $(this).addClass("button medium secondary");
        }
    },
    {
        text: "Ok",
        click: function() {
            $(this).dialog("close");
        },
        create: function(event, ui) {
            $(this).addClass("button medium primary");
        }
    }   
    ]
});
$('#dialogSignIn').dialog({
    autoOpen: false, 
    width: 290, 
    height: 210, 
    resizable: false, 
    modal: true, 
    dialogClass: 'dialog signup',
    //title: "Sign In",
    open: function(event, ui) { 
             
        $('#dialogSignIn input').focus();
           
    },
    buttons: [
    {
        text: "Cancel",
        click: function() {
            $(this).dialog("close");
        },
        className: "button medium secondary"
    },
    {
        text: "Sign In",
        click: function() {
            $(document).ready(function() {
                signin($('#create_post_sign_in_email_id').val(),$('#create_post_sign_in_pwd').val(),'createpost')
            });       
      
        },
        className: "button medium primary"
    } ]
    
});
$('#dialogSignUp').live("keydown", function(e){
       
    var keyCode = e.keyCode || e.which; 
    if(keyCode == 13){
        if ($('.signin-tab').is(":visible"))
            $('.ui-dialog-buttonset button.login').click();
        else if ($('.reset-password-tab').is(":visible"))
        {
                
            if ($('.button.submit').is(":visible"))
                $('.ui-dialog-buttonset button.submit').click();
       
        }
        else
            $('.ui-dialog-buttonset button.register').click();
         
        e.preventDefault(); 
    }  		
});
$('.dialog a.signin').live("click", function(){
    
    $('.join-tab').hide();
    $('.signin-tab').show();
    $('.button.register').hide();
    $('.button.login').show();
    $('.button.submit').hide();
    $('.reset-password-tab').hide();
    $('.button.submit').hide();
    $('.button.ok').hide();
});	
$('.dialog a.join').live("click", function(){
        
    $('.signin-tab').hide();
    $('.join-tab').show();
    $('.button.register').show();
    $('.button.submit').hide();
    $('.button.login').hide();
    $('.reset-password-tab').hide();
    $('.button.submit').hide();
    $('.button.ok').hide();
});

$('.dialog a.reset-password').live("click", function(){
    
    $('.reset-password-tab').show();
    $('.button.submit').show();
    $('.join-tab').hide();
    $('.signin-tab').hide();
    $('.button.register').hide();
    $('.button.login').hide();
    $('#reset_pwd_email').val('');
    $('#reset_pwd_email').focus();
    $('#reset_pwd_email').show();
    $('#dialog_reset_pwd_msg').hide();
                                       
    $('.button.ok').hide();
});
    
$('#topnav_sign_up').live("click", function(){
    ResetDialogSignUp();
    $('#dialogSignUp #sign-up-page').val("top-nav-signup"); 
    $('.signin-tab').hide();
    $('.join-tab').show();
    $('.button.register').show();
    $('.button.login').hide();
    $('.button.submit').hide();
    $('.button.ok').hide();
    $('#dialogSignUp').dialog('open');
    return false;
});
$('#topnav_sign_in').live("click", function(){
    
    ResetDialogSignUp();
    $('#dialogSignUp #sign-up-page').val("top-nav-signup"); 
    $('.signin-tab').show();
    $('.join-tab').hide();
    $('.button.register').hide();
    $('.button.submit').hide();
    $('.button.login').show();
    $('.button.ok').hide();
    $('#dialogSignUp').dialog('open');
    return false;
});

  
$('#reply_email_addr').live("blur", function(e){
       
    if ($('#reply_email_addr').attr("readonly"))    
        return;
        
    if($(this).val() === '') {
            
        $(this).val($(this).attr('title')).addClass('example');
    }
    else
    {                   
        checkExistingUser();        
    }
});

$('.send-response').live("click", function(){
    //Apply tinymce editor
    tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        editor_selector :"mceEditor",
        editor_deselector : "mceNoEditor",
        plugins: "paste",      

        // Theme options
        //theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,forecolor,bullist,numlist",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3_add : "pastetext,pasteword,selectall",
        //theme_advancedbuttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        //theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        //theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        paste_auto_cleanup_on_paste : true,      

        // Skin options
        skin : "o2k7",
        skin_variant : "silver"

    });
    var postingId = $(this).attr('id').replace('send_response_','') ;
    $('#dialogSendResponse #send_response_posting_id').val(postingId);
    $('#dialogSendResponse #send_response_default_subject').val('Re: ' + $('#listing-title-span').html()) ;
    $('#dialogSendResponse #send_response_subject').val('Re: ' + $('#listing-title-span').html()) ;
    if ($('#dialogSendResponse #send_response_subject').hasClass('example'))
        $('#dialogSendResponse #send_response_subject').removeClass('example'); 
                    
    $('#dialogSendResponse #send_response_status').val('');
    $.ajax({
        type: "GET",
        dataType:"json",
        url: "/user/checkloginstatus/",                       
        success: function(data){
                             
            if (data.loggedInStatus == 1)                                                                   
            {
                if ($('#dialogSendResponse #send_response_your_name').hasClass('example'))
                    $('#dialogSendResponse #send_response_your_name').removeClass('example');
                if ($('#dialogSendResponse #send_response_email_id').hasClass('example'))
                    $('#dialogSendResponse #send_response_email_id').removeClass('example');
                if (data.phone != "")
                {
                    if ($('#dialogSendResponse #send_response_contact_no').hasClass('example'))
                        $('#dialogSendResponse #send_response_contact_no').removeClass('example');  
                }
                $('#dialogSendResponse #send_response_your_name').val(data.name);
                $('#dialogSendResponse #send_response_contact_no').val(data.phone);
                $('#dialogSendResponse #send_response_email_id').val(data.email);


                $('#dialogSendResponse').dialog('open'); 
            }   
            else
            {
                $('#dialogSendResponse').dialog('open');  
            }
            if ($('#enable_sms_' + postingId).val() == '0')               {
                $('#sendSMS').attr('disabled','disabled');
                $('#warningNoSMS').show();
            }
            else 
            {
                $('#sendSMS').attr('checked','checked'); 
                $('#warningNoSMS').hide();
            }
                
            $('#sendSMS').iphoneStyle({
                checkedLabel: 'Yes',
                uncheckedLabel: 'No',
                resizeHandle:false,
                onChange: function(elem, value) {
        
                }
            });
        }
    });
  
});
   

