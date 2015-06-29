$(function(){  

    $(window).bind( 'hashchange', function(e) {
   
        // Get the hash (fragment) as a string, with any leading # removed. Note that
        // in jQuery 1.4, you should use e.fragment instead of $.param.fragment().
        var page = null;
        var step = $.bbq.getState( "step" );
        var pageUrl = $.param.fragment();  
        var pageObj = $.deparam(decodeURIComponent(pageUrl)); 
        if (pageObj.page != undefined && pageObj.page != null)             
            page = pageObj.page.toLowerCase();
        if (step && typeof $wizard != 'undefined'){ 
          
            if (page != null)
                TrackPageView('/' + page + '-step' + step);
            $wizard.jWizard("changeStep", parseInt(step)-1);        
        }         
        else
        {
                    
            var value = "/home/index/";
            
            if (pageUrl)
            {
               
                $( '#main-menu a.menu-item' ).removeClass( 'selected' );               
                $( '#main-menu a.menu-item[href="#' + pageUrl + '"]' ).addClass( 'selected' );             
               
                if (page != null)
                {                  
                    //Clear the interval set on the home page to load recently posted items
                    if (page != "home" && typeof home_page_interval_id != 'undefined')
                        self.clearInterval(home_page_interval_id);
                    if (page != "search")
                    {
                        $('#search').val('');
                        $('#select-category').html('All Categories');
                        $('#selected_category_hidden').val('allcategories');
                    }
                    if (page == "home") 
                    {
                        value = "/home/";
                        TrackPageView('/home');
                    }
                    else if (page == "createpost")
                        value = "/post/create/";
                    else if (page == "editpost")
                        value = "/post/edit/?postingId=" + pageObj.postingId;
                    else if (page == "profile")
                    {
                        value = "/user/profile/"; 
                        TrackPageView('/profile');
                    }
                    else if (page == "search")
                        value = "/search/";                   
                    else if (page == 'activate')
                    {
                        value = "/user/activate/?key=" + pageObj.key;
                        TrackPageView('/activate');
                    }
                    else if (page == 'resetpwd')
                    {
                        value = "/user/resetpwd/?key=" + pageObj.key;
                        TrackPageView('/resetpwd');
                    }
                     else if (page == 'changeemail')
                    {
                        value = "/user/changeemail/?key=" + pageObj.key;
                        TrackPageView('/changeemail');
                    }
                    else if (page == "admin") 
                    {
                        value = "/admin/";
                        TrackPageView('/admin');
                    }
                      else if (page == 'reademail')
                    {
                        value = "/admin/reademail";
                        TrackPageView('/reademail');
                    }
                   
                    if (page == "search")
                    {
                        if (pageObj.ref != undefined && (pageObj.ref == "sr_fs" || pageObj.ref == "sr_nofs"))                           
                        {                               
                           
                            if ($('#search_page_container').html() != null)
                            {
                                searchByObject($.deparam(pageUrl));
                             
                            }
                            else 
                            {                                
                                $('#main').hide();
                                $('#main').load(value, function() {
                                    $('#main').show();
                                    searchByObject($.deparam(pageUrl));                                    
                                }) 
                            }
                        } 
                        else
                        {                           
                            $('#main').load(value, function() {                                
                                    
                                })   
                        }
                    }
                    else
                    {
                        if (page =="profile")
                        {
                            $.ajax({
                                type: "GET",
                                dataType:"json",
                                url: "/user/checkloginstatus/",                       
                                success: function(logStatus){
                                    if (logStatus.loggedInStatus != 1)
                                    {
                                        value = "/home/index/";  
                                    }
                                   
                                    $('#main').load(value, function() {
                                        $('#main').unmask();
                                        if (value == '/user/profile/')
                                        {
                                            $('#welcomeMessage').hide();
                                            if (pageObj.ref != undefined && pageObj.ref.toLowerCase() == 'activation')
                                                $('#welcomeMessage').show();
                                            else if (pageObj.ref != undefined && pageObj.ref.toLowerCase() == 'resetpwd')
                                                {
                                                $('#welcomeMessage').show();
                                                $('#welcomeMessage').html('Your password has been reset successfully.');
                                                }
                                                else if (pageObj.ref != undefined && pageObj.ref.toLowerCase() == 'changeemail');
                                                {
                                                $('#welcomeMessage').show();
                                                $('#welcomeMessage').html('Your Email Address has been successfully updated.');
                                                }
                                            
                                            var passwordField = $('#changePasswordContainer input[type=password]');
                                            var placeholderField = $('#changePasswordContainer .placeholder');
                                            passwordField.before(function(){
                                                if ($(this).attr('title')){   
                                                    return '<input class="example placeholder" style="margin-top:10px;"  type="text" value="'+$(this).attr('title')+'" autocomplete="off" />'
                                                }else{
                                                    return '<input class="example placeholder" style="margin-top:10px;"  type="text" value="" autocomplete="off" />'   
                                                }  
                                            });
                                            placeholderField = $('#changePasswordContainer input.placeholder');
                                            placeholderField .show();
                                            passwordField.hide();
                                            placeholderField.focus(function() {
                                                $(this).nextAll('input').eq(0).show().focus();
                                                $(this).hide();
                                            });

                                            passwordField.blur(function() {
                                                if($(this).val() == '') {
                                                    $(this).prevAll('input').eq(0).show();
                                                    $(this).hide();
                                                }
                                            });
                                           
                                       if (pageObj.ref != undefined && pageObj.ref.toLowerCase() == 'createpost')
                                         {    
//                                            $.ajax({
//                                                type: "GET",
//                                                dataType:"json",
//                                                url: "/post/getlastpostshareinfo/",                       
//                                                success: function(data){
//                             
//                                                    if (data.status == 'success')                                                                   
//                                                    {
//                                                        $('#dialogShare .facebook').attr('id','fblink_' + data.postingId);
//                                                        $('#dialogShare .email').attr('id','email_' + data.postingId);
//                                                        $('#dialogShare .twitter').attr('id','twitter_' + data.postingId);
//                                                        $('#dialogShare .twitter').attr('href',data.twitterShareLink);
//                                                        $('#dialogShare .email').attr('href',"javascript:jsSendMail('" + data.postTitle + "','" + data.detailsUrl +"');");
// 
//                                                        $('#dialogShare').dialog('open');    
//                                                    }
//                                                }  
//                                            }); 
                                         }
                                        }
                                    });
                                }
                            })
                        }
                        else
                        {
                            //$('#main').mask("Loading...");
                          
                            $('#main').load(value, function() {
                                // $('#main').unmask();
                               if (page == 'home')
                                {
                                    $('#recently_posted_items_container').mask('Loading Recently Posted Items....');
                                   
                                    getRecentlyPostedItems(); 
                                    
                                }
                                if (page == "createpost" || page == "editpost")
                                {
                                   
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
                                   
                                    $('input[title]').each(function() {
                                        var type = $(this).attr('type');
                                        if (type!='password'){
        
                                            if($(this).val() == "")
                                                $(this).val($(this).attr('title')).addClass('example');
  
                                            $(this).focus(function() {
                                                if($(this).val() === $(this).attr('title')) {
                                                    $(this).val('').removeClass('example');
                                                }
                                                if($(this).hasClass('password')){
                                                    $(this).attr('type','password');
                                                }
                                            });
  
                                            $(this).blur(function() {
                                                if($(this).val() === '') {
                                                    $(this).val($(this).attr('title')).addClass('example');
                                                }   
                                                if($(this).hasClass('password')){
                                                    $(this).attr('type','text');
                                                }    
                                            });
                                        }
                                    }); 
                                }
                               
                            }) 
                        }
                    }
                }
            }
            else
            { 
                var href =  window.location.href;
            
                if (href.indexOf('/api/') == -1)
                    window.location = "#page=home";
               
            }
            
        }
    
    })
  
    // Since the event is only triggered when the hash changes, we need to trigger
    // the event now, to handle the hash the page may have loaded with.
    $(window).trigger( 'hashchange' );
  
});
$('document').ready(function(){
    var href =  window.location.href;
    if (href.indexOf('/api/') != -1)
    {      
        $('#main-menu').find(' a.menu-item').each(function (index){   
            if ($(this).attr('href') != undefined)
                $(this).attr('href',$(this).attr('href').replace('#','/#'))
        }) 
        TrackPageView('/api/post');
        try
        {
            var postingId =  href.substring(href.lastIndexOf('/') + 1);
            saveViewShareEmail(postingId,'View');
        }
        catch(err)
        {
        }
    }
    else
    {
        $('#main-menu').find(' a.menu-item').each(function (index){
            if ($(this).attr('href') != undefined)
                $(this).attr('href',$(this).attr('href').replace('/#','#'))
        }) 
    }
})
