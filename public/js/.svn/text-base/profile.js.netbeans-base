var tabSelected = 0;
var checkedPosts = "Active";

$('#showActivePosts').iphoneStyle({
    checkedLabel: 'Yes',
    uncheckedLabel: 'No',
    resizeHandle:false,
    onChange: function(elem, value) {
        if (value.toString() == 'true')
        {
            TrackPageView('/active-posts'); 
            $('#mypostsContent').empty();
      
            var startRowIndex = 0;
            var rows = $('#noOfRows').val();
       
           
            $('#startRowIndexAllPosts').val('0');
            $('#startRowIndexActivePosts').val('0');
            $('#startRowIndexPostResponses').val('0');
            $('#startRowIndexAllActivities').val('0');
            
            checkedPosts = "Active";
            if ($('#showExpiredPosts').is(":checked"))    
                checkedPosts = checkedPosts + "," + "Expired";
            if ($('#showDeletedPosts').is(":checked"))    
                checkedPosts = checkedPosts + "," + "Deleted";
            getUserPosts(startRowIndex,rows,checkedPosts,"ActivePosts");
        }
        else 
        {
            TrackPageView('/expired-deleted posts'); 
       
            $('#mypostsContent').empty();   
            var startRowIndex = 0;
            var rows = $('#noOfRows').val();
            
            $('#startRowIndexAllPosts').val('0');
            $('#startRowIndexActivePosts').val('0');
            $('#startRowIndexPostResponses').val('0');
            $('#startRowIndexAllActivities').val('0');
            checkedPosts = "";
            if ($('#showExpiredPosts').is(":checked")) 
            {
                if (checkedPosts == "")
                    checkedPosts =  "Expired";   
                else
                    checkedPosts = checkedPosts + "," + "Expired";
            }
            if ($('#showDeletedPosts').is(":checked"))  
            {
                if (checkedPosts == "")
                    checkedPosts =  "Deleted";   
                else
                    checkedPosts = checkedPosts + "," + "Deleted";
            }
            getUserPosts(startRowIndex,rows,checkedPosts,"ActivePosts");  
        }
    }
});
$('#showExpiredPosts').iphoneStyle({
    checkedLabel: 'Yes',
    uncheckedLabel: 'No',
    resizeHandle:false,
    onChange: function(elem, value) {
        if (value.toString() == 'true')
        {
            TrackPageView('/active-posts'); 
            $('#mypostsContent').empty();
      
            var startRowIndex = 0;
            var rows = $('#noOfRows').val();
       
            $('#startRowIndexAllPosts').val('0');
            $('#startRowIndexActivePosts').val('0');
            $('#startRowIndexPostResponses').val('0');
            $('#startRowIndexAllActivities').val('0');
            checkedPosts = "Expired";
            if ($('#showActivePosts').is(":checked"))    
                checkedPosts = checkedPosts + "," + "Active";
            if ($('#showDeletedPosts').is(":checked"))    
                checkedPosts = checkedPosts + "," + "Deleted";
            getUserPosts(startRowIndex,rows,checkedPosts,"ActivePosts");  
        }
        else 
        {
            TrackPageView('/expired-deleted posts'); 
       
            $('#mypostsContent').empty();   
            var startRowIndex = 0;
            var rows = $('#noOfRows').val();
           
            $('#startRowIndexAllPosts').val('0');
            $('#startRowIndexActivePosts').val('0');
            $('#startRowIndexPostResponses').val('0');
            $('#startRowIndexAllActivities').val('0');
            checkedPosts = "";
            if ($('#showActivePosts').is(":checked"))    
            {
                if (checkedPosts == "")
                    checkedPosts =  "Active";   
                else
                    checkedPosts = checkedPosts + "," + "Active";
            }
            if ($('#showDeletedPosts').is(":checked"))    
            {
                if (checkedPosts == "")
                    checkedPosts =  "Deleted";   
                else
                    checkedPosts = checkedPosts + "," + "Deleted";
            }
            getUserPosts(startRowIndex,rows,checkedPosts,"ActivePosts");  
        }
    }
});
$('#showDeletedPosts').iphoneStyle({
    checkedLabel: 'Yes',
    uncheckedLabel: 'No',
    resizeHandle:false,
    onChange: function(elem, value) {
        if (value.toString() == 'true')
        {
            TrackPageView('/active-posts'); 
            $('#mypostsContent').empty();
      
            var startRowIndex = 0;
            var rows = $('#noOfRows').val();
       
           
            $('#startRowIndexAllPosts').val('0');
            $('#startRowIndexActivePosts').val('0');
            $('#startRowIndexPostResponses').val('0');
            $('#startRowIndexAllActivities').val('0');
            checkedPosts = "Deleted";
            if ($('#showActivePosts').is(":checked"))    
                checkedPosts = checkedPosts + "," + "Active";
            if ($('#showExpiredPosts').is(":checked"))    
                checkedPosts = checkedPosts + "," + "Expired";
            getUserPosts(startRowIndex,rows,checkedPosts,"ActivePosts"); 
        }
        else 
        {
            TrackPageView('/expired-deleted posts'); 
       
            $('#mypostsContent').empty();   
            var startRowIndex = 0;
            var rows = $('#noOfRows').val();
           
            $('#startRowIndexAllPosts').val('0');
            $('#startRowIndexActivePosts').val('0');
            $('#startRowIndexPostResponses').val('0');
            $('#startRowIndexAllActivities').val('0');
            checkedPosts = "";
            if ($('#showActivePosts').is(":checked"))    
            {
                if (checkedPosts == "")
                    checkedPosts =  "Active";   
                else
                    checkedPosts = checkedPosts + "," + "Active";
            }
            if ($('#showExpiredPosts').is(":checked"))    
            {
                if (checkedPosts == "")
                    checkedPosts =  "Expired";   
                else
                    checkedPosts = checkedPosts + "," + "Expired";
            }
            getUserPosts(startRowIndex,rows,checkedPosts,"ActivePosts");  
        }
    }
});
$('#enableSMS').iphoneStyle({
    checkedLabel: 'Yes',
    uncheckedLabel: 'No',
    resizeHandle:false,
    onChange: function(elem, value) {
        if (value.toString() == 'true')
        {
          
            
            $.ajax({
                type: "GET",
                url: "/user/enablesms/",
                data: "enable_sms=1" 
            });
        
        
            
        }
        else 
        {
            $.ajax({
                type: "GET",
                url: "/user/enablesms/",
                data: "enable_sms=0" 
            });
            
        }
    }
});

$('#postanon').iphoneStyle({
    checkedLabel: 'Yes',
    uncheckedLabel: 'No',
    resizeHandle:false,
    onChange: function(elem, value) {
        if (value.toString() == 'true')
        {
          
            
            $.ajax({
                type: "GET",
                url: "/user/setprivacy/",
                data: "post_anonymously=1" 
            });
        
        
            
        }
        else 
        {
            $.ajax({
                type: "GET",
                url: "/user/setprivacy/",
                data: "post_anonymously=0" 
            });
            
        }
    }
});

$('#posttabs').tabs({
    select: function(event, ui) {
        tabSelected = ui.index;
        if (ui.index == 2 && $("#uploadFileListing").html() == "")
        {
            TrackPageView('/profile-library'); 
            $("#photo_loader").mask("Loading Photos...");
            $("#uploadFileListing").html("");
            $('#fileupload').each(function () {
                var that = this;       
                $.getJSON(this.action, function (result) { 
                    $("#photo_loader").unmask();
                    if (result && result.length) {
                        $(that).fileupload('option', 'done')
                        .call(that, null, {
                            result: result
                        });
                    }else{
                        $('#tabs-3').addClass("empty");
                    }
                });
            }); 
           
        }
        else if (ui.index == 0)
        {
            
            TrackPageView('/all-activities'); 
            $('#mytimelineContent').empty();
            $('#tabs-1').show();
            var startRowIndex = 0;
            var rows = $('#noOfRows').val();
        
            $('#allPosts').removeClass('selected');
            $('#activePosts').removeClass('selected');
            $('#postResponses').removeClass('selected');
            $('#startRowIndexAllPosts').val('0');
            $('#startRowIndexActivePosts').val('0');
            $('#startRowIndexPostResponses').val('0');
            $('#startRowIndexAllActivities').val('0');
            getUserPosts(startRowIndex,rows,"Active","AllActivities");    
        } else if (ui.index == 1)
{
            TrackPageView('/active-posts');
            $('#tabs-2').show();
            $('#mypostsContent').empty();
      
            var startRowIndex = 0;
            var rows = $('#noOfRows').val();
            //       
            //            $('#allPosts').removeClass('selected');
            //            $('#activePosts').addClass('selected');
           
            $('#startRowIndexAllPosts').val('0');
            $('#startRowIndexActivePosts').val('0');
            $('#startRowIndexPostResponses').val('0');
            $('#startRowIndexAllActivities').val('0');
            getUserPosts(startRowIndex,rows,"Active","ActivePosts");
        }
        else if (ui.index == 3)
        {
            TrackPageView('/post-responses'); 
            $('#mysentItemsContent').empty();
       
            var startRowIndex = 0;
            var rows = $('#noOfRows').val();
       
       
            $('#startRowIndexAllPosts').val('0');
            $('#startRowIndexActivePosts').val('0');
            $('#startRowIndexPostResponses').val('0');
            $('#startRowIndexAllActivities').val('0');
            getUserPosts(startRowIndex,rows,"Active","PostResponses");
        }
    }
});
$("#posttabs").show(); 
$('#topnav_my_account').addClass('selected');
$('document').ready(function(){
   
	             
    var $currentPost;
    $("#dialogDeletePost").dialog({
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
                $(this).addClass("cancel button medium secondary");
            }
        },
        {
            text: "Delete",
            click: function() {
                var postingId = $("#dialogDeletePost #postToBeDeleted").val();
                $currentPost =  $("#delete_" + postingId).parents('.listing');
                $(this).dialog("close");
                $.ajax({
                   
                    type: "GET",
                    dataType:"json",
                    url: "/post/flagdeleted/",
                    data: "postingId=" + postingId ,
                    success: function(response){
                        if (response.status == "success")
                        {
                            $currentPost.find('.status-tag').html('Deleted');
                            $currentPost.removeClass('Active'); 
                            $currentPost.addClass('Deleted');
                            $currentPost.find('.delete').hide();
                            $currentPost.find('.repost').show();
                            $currentPost.find('.expires').html('');
                        //$currentPost.find('.post-buttons .editpost').before("<a id='repost_" + postingId +"' class='repost button secondary small'>Repost</a>");
                        }
                    }
                });
               
            },
            create: function(event, ui) {
                $(this).addClass("delete button medium secondary");
            }
        }   
        ]
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
                $(this).addClass("ok button medium primary");
            }
        }   
        ]
    });
    //$('#imagePickerComp').dialog({autoOpen: false, width: 550, height: 462, resizable: false, modal: true, title: "Edit Photo"});
    $('#imagePickerProfile').dialog({
        autoOpen: false, 
        width: 590, 
        height: 655, 
        resizable: false, 
        modal: true, 
        title: "Select Profile Picture",
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
    $('#choose_from_photos').click(function(){
        $('#imagePickerProfile').dialog('open');
    });
    $('#imagePickerProfile .photobin li .image').click(function(){
        $('#imagePickerComp').dialog('open');
    });
    
      
    $('#imagePickerProfile .check').click(function(){
        $selected = $('#imagePickerProfile .selected');
        $selected.removeClass('selected');
        $selected.addClass('unselected');
      
    });
  
  
    $(".map-icon").click(function(){
        $(this).parent().find('.location').toggle();
    }); 
    $(".search .listing").mouseenter(function(){
        $('.location').hide();
    });

    $(".widget .delete").live("click", function(){
        $(this).parent().slideUp(0, function(){
            $(this).remove();
        });
 
        if ($(this).parent()[0].tagName == 'H3'){
            $(this).parent().next().slideUp(400, function(){
                $(this).remove();
            });
        }
    });
  
    $(".widget .hide").click(function(){
        $(this).parents('.widget').last().find('.content').toggle();
        if($(this).hasClass('hidden'))$(this).removeClass('hidden');
        else $(this).addClass('hidden');
    });
  
    $('.post-buttons .delete').live("click", function(){ 
        var postingId = $(this).attr('id').split('_')[1];
        if (postingId != undefined)
        {
            $currentPost =  $(this).parents('.listing');
            //            if ($currentPost.hasClass('Active')) {
            //                $.ajax({
            //                    type: "GET",
            //                    url: "/post/flagdeleted/",
            //                    data: "postingId=" + postingId ,
            //                    success: function(response){
            //                        if (response == "success")
            //                        {
            //                            $currentPost.find('.status-tag').html('Deleted');
            //                            $currentPost.removeClass('Active');
            //                            $currentPost.addClass('Deleted');
            //                            $currentPost.find('.expires').html('');
            //                            $currentPost.find('.post-buttons .editpost').before("<a id='repost_" + postingId +"' class='repost button secondary small'>Repost</a>");
            //                        }
            //                    }
            //                });
            //            }else{
            $('#dialogDeletePost #postToBeDeleted').val(postingId);
            $currentPost.css('height',$(this).parents('.listing').height()); 
            $('#dialogDeletePost').dialog('open');
        // }
        }
    });  
    
    $('.editTimeline a.edit').live("click", function(){ 
        var postingViewId = $(this).attr('id').split('_')[1];
        if (postingViewId != undefined)
        {
            $currentPost =  $(this).parents('.listing');
            $currentPost.empty().remove();
            $.ajax({
                type: "GET",
                url: "/post/hide/",
                data: "postingViewId=" + postingViewId ,
                success: function(response){
                  
                    if (response == "success")
                    {
                        
                        $currentPost.empty().remove();
                    }
                }
            });
        
        }
    });  
    
    $('#mytimelineContent .listing').live("mouseover", function(e){
        $(this).find('.editTimeline').show();
    })
    $('#mytimelineContent .listing').live("mouseout", function(e){
        $(this).find('.editTimeline').hide();
    })
    //     $('.email-content').live("mouseover", function(e){
    //        $(this).find('.edit').show();
    //    })
    //    
    //     $('.email-content').live("mouseout", function(e){
    //        $(this).find('.edit').hide();
    //    })
    
    deletePost = function(postingId){
        if (postingId != undefined && postingId != "")
        {
            $.ajax({
                type: "GET",
                url: "/post/delete/",
                data: "postingId=" + postingId ,
                success: function(response){
                    if (response == "success")
                    {
                        $currentPost.children().fadeOut('1000', function(){});
                        setTimeout (function(){
                            $currentPost.slideUp(200);
                        }, 1000);  
                    }
                }
            });
        }
    }
 
    $('.button-stats').click(function(){
        $(this).parents('.listing').find('.stats').slideToggle();
    });
  
    $('.listing').mouseleave(function(){
        $(this).find('.stats').slideUp();
    });
  
    $('.profile-info .edit').click(function(){
        //$(this).parents('.group').find('.content').toggle();
      
        $(this).parents('.group').find('.edit-content').toggle();
        $(this).parents('.group').find('.edit').hide();
        if($('#contact_user_phone').val() === '') {
            $('#contact_user_phone').val($('#contact_user_phone').attr('title')).addClass('example');
        }
        $(this).parents('.group').find('.remove').hide();
        $(this).parents('.group').find('label.error').hide();
        $(this).parents('.group').find('input.error').removeClass('error');
    });
    
    $('.myaccount-right-side .edit').click(function(){
        //$(this).parents('.group').find('.content').toggle();
        $("#nameEditContainer #name_first_name").val($("#nameEditContainer #hidden_first_name").val());
        $("#nameEditContainer #name_last_name").val($("#nameEditContainer #hidden_last_name").val());
        $(this).parents('.group').find('.edit-content').toggle();
        $(this).parents('.group').find('.edit').hide();
        $(this).parents('.group').find('label.error').remove();
        $(this).parents('.group').find('input.error').removeClass('error');
       
    });
    $('.profile-info .change-password').click(function(){
        //$(this).parents('.group').find('.content').toggle();
        $(this).parents('.group').find('.edit-content').toggle();
        $(this).parents('.group').find('.edit').hide();
        $("#old_password").val('');
        $("#new_password").val('');
        $("#retype_new_password").val('');
        $("#old_password").attr('title','Old Password');
        $("#new_password").attr('title','New Password');
        $("#retype_new_password").attr('title','Retype New Password');
        var passwordField = $('#changePasswordContainer input[type=password]');
        var placeholderField = $('#changePasswordContainer .placeholder');      
        placeholderField .show();
        passwordField.hide();
    });
    $('.profile-info .cancel').click(function(){
        $(this).parents('.group').find('.content').show();
        $(this).parents('.group').find('.edit-content').hide();
        $(this).parents('.group').find('.edit').removeAttr('style');
        $(this).parents('.group').find('.remove').show();
       
    }); 
    // $('#contactInfoEditContainer .cancel').click(function(){
    //        $(this).parents('.group').find('.content').show();
    //        $(this).parents('.group').find('.edit-content').hide();
    //        $(this).parents('.group').find('.edit').removeAttr('style');
    //        //$("#contact-info-container").show();
    //    }); 
    //    
    $('#nameEditContainer .cancel').click(function(){
       
        $(this).parents('.group').find('.edit-content').hide();
        $(this).parents('.group').find('.edit').removeAttr('style');
        $(this).parents('.group').find('.remove').removeAttr('style');
    }); 
    
    $('.profile-info .sign-out').click(function(){
        signOut();
    });
    $('.profile-info .send-activation-link').click(function(){
        sendActivationLink();
    });
    
    $('.change-password-content .save').live("click", function(){
    
        if ($("#old_password").val() =='Old Password')
            $("#old_password").val('');
        if ($("#new_password").val() =='New Password')
            $("#new_password").val('');
        if ($("#retype_new_password").val() =='Retype New Password')
            $("#retype_new_password").val('');
        
        var validate =  $("#change_password_form").validate({
            rules: {                           
              
                old_password:"required",                       
                new_password:"required",
                retype_new_password: {
                                            
                    equalTo: "#new_password"
                }
            },
            messages: {
               
                old_password:"This field is required.",                       
                new_password:"This field is required.", 
                retype_new_password: {    
                    
                    equalTo: "Retype the new password."
                }
            }
        });
       
        var isOPValid = validate.element( "#old_password" );
        var isNPValid = validate.element( "#new_password" );              
        var isRNPValid = validate.element( "#retype_new_password" );
    
        if (isOPValid && isNPValid && isRNPValid)
        {                    
            changePassword($('#user_id').val(),$('#old_password').val(),$('#new_password').val());             
                   
        }
        else
        {
            $("#old_password").attr('title','Old Password');
            $("#new_password").attr('title','New Password');
            $("#retype_new_password").attr('title','Retype New Password');
                   
        } 
      
    });
    
    $('.myaccount-right-side .save').live("click", function(){
    
          
        var validate =  $("#name_form").validate({
            rules: {                           
              
                name_first_name:"required",                       
                name_last_name:"required"
               
            },
            messages: {
               
                name_first_name:"First name is required.",                       
                name_last_name:"Last name is required.",
               
            }
        });
       
        var isFNValid = validate.element( "#name_first_name" );
        var isLNValid = validate.element( "#name_last_name" );              
        
        if (isFNValid && isLNValid)
        {                    
            updateName($('#user_id').val(),$('#name_first_name').val(),$('#name_last_name').val());             
                   
        }
       
      
    });
    
    $('#phoneEditContainer .save').live("click", function(){
    
      
        validate =  $("#phone_form").validate(); 
       
        if ($("#contact_user_phone").valid())
        { 
         
            updatePhone($('#user_id').val(),$('#contact_user_phone').val());  
            $('.phone-content .remove').show();
                   
        }
       
      
    });
    
    $('#emailEditContainer .save').live("click", function(){
        $('#emailEditContainer #invalid_email').hide();
        validate =  $("#email_form").validate({
            rules: {                           


                contact_user_email: {
                    required:true,
                    email:true
                }

            },
            messages: {


                contact_user_email: {   
                    required:"Email is required.",
                    email:"Please enter a valid email address."
                }
            }
        });

        var isRegisterEmailValid = validate.element( "#contact_user_email" );
        var isSameEmail = false;
        if ($('#contact_user_email').val() == $(".profile-email").html())
            isSameEmail = true;
       
        if (isRegisterEmailValid && !isSameEmail)
        { 
            
            $.ajax({
                global:false,
                type: "GET",   
                cache:false,
                dataType:"jsonp",
                crossDomain:true,   
                url: $("#sso_url").val() + "/check_user.php?userEmailId=" +  $('#contact_user_email').val(),
                success: function(data) {
                      
                    if (data.status != 'Found')     
                    {  
                        updateEmail($('#user_id').val(),$('#contact_user_email').val());   
               
                    } 
                    else
                    {
                        $('#emailEditContainer #invalid_email').show();
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

    });
    
    $('#addressEditContainer .save').live("click", function(){
       
          
        validateUserLocation();
       
      
    });
    
    $('.phone-content .remove').live("click", function(){
    
         
        updatePhone($('#user_id').val(),""); 
        
        $('#contact_user_phone').val('');
        $('.phone-content .remove').hide();
      
    });
    $('#contact_user_phone').blur(function() {
        if($(this).val() === '') {
            $(this).val($(this).attr('title')).addClass('example');
        }
    });
    $('#contact_user_phone').focus(function() {
        if($(this).val() === $(this).attr('title')) {
            $(this).val('').removeClass('example');
        }
               
    });
    $(window).scroll(function () {  
       
              
        if ($(window).scrollTop() == $(document).height() - $(window).height()) { 
           
            var numFound = 0;
            var rows = 0;
            var startRowIndex = 0;
            
            if ($('#numFound') && $('#noOfRows'))
            {                   
                numFound = parseInt($('#numFound').val());
                rows = parseInt($('#noOfRows').val());                
            }
            
            if (numFound < rows)
            {
                $('div#last_post_loader').empty();  
                $('div#last_post_loader_timeline').empty();  
                $('div#last_post_loader_sentItems').empty();  
            }
            else
            {
                 
                if (tabSelected == 0)
                {
                    startRowIndex = $('#startRowIndexAllActivities').val();                    
                    getUserPosts(startRowIndex,rows,"Active","AllActivities");
                }
                else  if (tabSelected == 1)
                {
                   
                    if (checkedPosts == "All")
                    {
                        startRowIndex = $('#startRowIndexAllPosts').val();                    
                        getUserPosts(startRowIndex,rows,"all","AllPosts");
                    }
                    else if (checkedPosts == "Active")
                    {
                        startRowIndex = $('#startRowIndexActivePosts').val();  
                       
                        getUserPosts(startRowIndex,rows,"Active","ActivePosts");
                    }
                }
                else  if (tabSelected == 3)
                {
                    startRowIndex = $('#startRowIndexPostResponses').val();                    
                    getUserPosts(startRowIndex,rows,"Active","PostResponses");
                }
                            
            }           
        
        }    
        
    }); 
   
  
}); 

    
function getUserPosts(startRowIndex,rows,statusFilter,tab)
{
        
    if (tab == "AllPosts")  
    {
        $('#startRowIndexAllPosts').val(parseInt(startRowIndex) + parseInt(rows)); 
           
    }
    else  if (tab == "PostResponses")  
    {
        $('#startRowIndexPostResponses').val(parseInt(startRowIndex) + parseInt(rows)); 
            
           
    }
    else  if (tab == "AllActivities")  
    {
        $('#startRowIndexAllActivities').val(parseInt(startRowIndex) + parseInt(rows)); 
            
           
    }
    else
    {
        if (statusFilter == "")
        {
            searchResult = '<a href="/#page=createpost"><div class="empty-user-post"></div></a>';
                          
            $(searchResult).appendTo($('#mypostsContent')); 
            return;
            
        }
        $('#startRowIndexActivePosts').val(parseInt(startRowIndex) + parseInt(rows));  
             
    }
    
    var previousSearchNoFound = parseInt($('#numFound').val());
    if (previousSearchNoFound == rows || parseInt(startRowIndex) == 0 )
    {
        //$('div#last_post_loader').html('<img  src="/images/loading.gif" width="40px" height="40px">');
        if (parseInt(startRowIndex) == 0)
        {
                
            if (tab =="AllPosts")
                $('#last_post_loader').mask("Loading All Posts...");
            else if (tab =="ActivePosts")
                $('#last_post_loader').mask("Loading Posts...");
            else if (tab =="PostResponses")
                $('#last_post_loader_sentItems').mask("Loading Post Responses...");
            else if (tab =="AllActivities")
                $('#last_post_loader_timeline').mask("Loading All Activities...");
        }
        else
        {
            if (tab =="AllActivities")
                $('#last_post_loader_timeline').mask("Loading..."); 
            else
                $('#last_post_loader').mask("Loading..."); 
        }
        $.ajax({
            global:false,
            type: "GET",
            url: "/user/postlisting/",                           
            data: "startRowIndex=" + startRowIndex + '&rows=' + rows + '&statusFilter=' + statusFilter + '&tab=' + tab,  
               
            success: function(listingResponse){                      
                if (listingResponse != "")
                {   
                   
                    var numFound;
                    var searchResult;                  
                  
                    numFound = listingResponse.split('<PostNoFound>')[1];
                    
                    $('#numFound').val(numFound);
                        
                    if (parseInt(numFound) > 0)
                    { 
                        searchResult =listingResponse.split('<PostNoFound>')[0];  
                        if (tab =="AllActivities")
                            $(searchResult).appendTo($('#mytimelineContent')); 
                        else if (tab =="PostResponses")
                            $(searchResult).appendTo($('#mysentItemsContent')); 
                        else
                            $(searchResult).appendTo($('#mypostsContent'));  
                          
                    } 
                    else             
                    
                    {                      
                        if ($('#mypostsContent').html() =="" || $('#mytimelineContent').html() =="")
                        {
                            searchResult = '<a href="/#page=createpost"><div class="empty-user-post"></div></a>';
                            if (tab =="AllActivities")
                                $(searchResult).appendTo($('#mytimelineContent'));  
                            else if (tab =="PostResponses")
                                $(searchResult).appendTo($('#mysentItemsContent')); 
                            else
                                $(searchResult).appendTo($('#mypostsContent')); 
                               
                        }
                    }
                   
                    $('div#last_post_loader').unmask() ; 
                    $('div#last_post_loader_timeline').unmask() ;  
                    $('div#last_post_loader_sentItems').unmask() ;  
                }
                else
                {
                    $('#numFound').val('0');
                    if ($('#mypostsContent').html() =="" || $('#mytimelineContent').html() =="")
                    {
                        searchResult = '<a href="/page=createpost"><div class="empty-user-post"></div></a>';
                        if (tab =="AllActivities")
                            $(searchResult).appendTo($('#mytimelineContent'));   
                        else if (tab =="PostResponses")
                            $(searchResult).appendTo($('#mysentItemsContent')); 
                        else
                            $(searchResult).appendTo($('#mypostsContent')); 
                    }
                    $('div#last_post_loader').unmask();  
                    $('div#last_post_loader_timeline').unmask() ;  
                    $('div#last_post_loader_sentItems').unmask() ;
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
} 