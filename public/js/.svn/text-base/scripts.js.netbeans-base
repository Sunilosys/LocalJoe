$('document').ready(function(){
    //Create Post and Edit Post Scripts 

    $('#wizard .finder a').live("click", function(){ 
        $(".jw-footer").hide();
        $("#post_title").val('');         
        $("div .text-tags").html(''); 
   
        var category = $(this).attr('name').split('_');
        if (category != undefined && category.length > 1)
        {
            LoadCategoryAttributes(category[1],null);
        }  
        $('#wizard').jWizard("nextStep");      
        $("#wizard .jw-menu li:first-child a").html('Category: '+$(this).html());
    });


    $('#wizard').live("jwizardchangestep", function(event,ui){     
        if (ui.type !== "manual") {
            switch (ui.currentStepIndex) {

                case 0: //alert(0); 
                    ensure({
                        js:["/js/tags.js","/js/feather.js"]
                    },

                    function(){	                   

                        });

                    break;				
                case 1: //alert(1);
                    ensure({
                        js:["/js/aviary.js"]
                    },

                    function(){	
                        if (ui.nextStepIndex != 0 && $("#uploadFileListing").html() == "")
                            LoadPhotoLibrary();
                    });

                    break;
                case 2: //alert(2); 
                    //ensure({js:["//maps.googleapis.com/maps/api/js?sensor=false&libraries=places","//maps.gstatic.com/cat_js/intl/en_us/mapfiles/api-3/8/4/%7Bmain,places%7D.js"]},
                    var now = new Date();
                    var timestamp = now.getTime();
                    ensure({
                        js:["/js/loadgmaps.js?" + timestamp]
                    },
                    function(){
                    
                        if ($('#location_lat').val() != "" && $('#location_lon').val() != "")  
                            loadMapByLatLon($('#location_lat').val(),$('#location_lon').val());

                    });


                    //});

                    break;
                case 3: //alert(3); break;
                case 4: //alert(4); break;
            }
        }
    });      

     
    $('.createpost .check').live("click", function(){

        if (!$(this).parent().hasClass('edit-select')){
            if (!$(this).hasClass('disabled'))
            {
                if ($(this).hasClass('selected')){
                    $(this).removeClass('selected');
                    $(this).addClass('unselected');
                }else{
                    $(this).addClass('selected');
                    $(this).removeClass('unselected');

                } 

            }           
        }
    });
    
    function countSelectedImages()
    {
        $("#preview-images").html("");
        var previewImages = "";
        var selectImageCount = 0;
        var totalImageCount = 0;
        if ($('.cover').size() < 1){
            $('.cover').removeClass('cover');
            $('.template-download.selected').eq(0).addClass('cover');   
        }  
        
        $('#uploadFileListing > li').each(function (index) {                         
            totalImageCount++;    
            var caption = $(this).find(".caption").find('span').html();                   
            var imgSrc = $(this).find(".image").find('img').attr("src");
            imgSrc = imgSrc.replace("thumbnail","original");
            
            if ($(this).find('.edit-select').find('.check').hasClass("selected"))
            {
                selectImageCount++;   
                if (selectImageCount == 1)
                    previewImages = '<a class="current image" id="firstSelectedImage" href="' + imgSrc + '" title=""><img src="'+ imgSrc +' "/><span class="caption">' + caption + '</span></a>';
 
                else
                    previewImages = previewImages + '<a class="image" href="' + imgSrc + '" title=""><img src="'+ imgSrc +' "/><span class="caption">' + caption + '</span></a>';
                                 
            }
        });
        $('#selectedImagesCount').html(selectImageCount);
        $('#totalImagesCount').html(totalImageCount);       
                    
          
        if (previewImages != "")
        {
            $('<div id="previewImagesHtml"></div>').appendTo('#preview-images')
            $("#previewImagesHtml").replaceWith(previewImages);                       
        }
      
        try
        {                        
            $(".listing .image").colorbox({
                rel:'image', 
                transition:"none", 
                width:"75%", 
                height:"75%", 
                fixed:'true'
            });
        }
        catch(err)
        {
                        
        }
      
  
    }

    $('.template-download' ).live("click", function(e){
        
        if ($(this).hasClass('selected')){
            $(this).removeClass('selected');
            $(this).addClass('unselected');
            $(this).find('.check').removeClass('selected');
            $(this).find('.check').addClass('unselected');
            if($(this).hasClass('cover')){
                $(this).removeClass('cover');
                $('.template-download.selected').eq(0).addClass('cover');
            }
        }else{
            $(this).removeClass('unselected');
            $(this).addClass('selected');  
            $(this).find('.check').removeClass('unselected');
            $(this).find('.check').addClass('selected'); 
        }
        

        $('.template-download .menu').hide();
        countSelectedImages();  
    });
 
    $('.menu-cover').live('click', function(e){  
        e.stopPropagation();

        $('.cover').removeClass('cover');
        $(this).parents('.template-download').addClass('cover');
        $('.template-download .menu').hide();
        if (!$(this).parents('.template-download').hasClass('selected')){
            $(this).parents('.template-download').click();
        }
    });
    $('.menu-nocover').live('click', function(e){  
        e.stopPropagation();
        var $selected = $('.template-download.selected');
        var $current = $(this).parents('.template-download');
        
        if (($current[0]==$selected[0]) && ($selected.size()>1)){          
            $('.cover').removeClass('cover');
            $current.nextAll('.selected:first').addClass('cover');          
        }else{
            $('.cover').removeClass('cover');
            countSelectedImages();
        } 
    });
       
    $('.template-download' ).live("contextmenu", function(e){
        e.preventDefault();

        var x = e.pageX - $(this).offset().left-10;
        var y = e.pageY - $(this).offset().top+10;
        var $selected = $('.template-download.selected');
        if ($selected.size()<2){
            $(this).find('.menu-nocover').addClass('disabled');  
         
        }else{
            $(this).find('.menu-nocover').removeClass('disabled');
        }
        $(this).find('.menu').css('top', y+'px');
        $(this).find('.menu').css('left', x+'px');

        $(this).find('.menu').show();

    });
    $('.menu-delete').live('click', function(e){  
        e.stopPropagation();
        $(this).parents('.template-download').find('.delete').click();
    });
    $('.menu-edit').live('click', function(e){  
        e.stopPropagation();
        $(this).parents('.template-download').find('.image').dblclick();
    });
      
    
    $('.template-download' ).live("mouseleave", function(e){
        $(this).find('.menu').hide();
        
    });
    $(".template-download .caption").live("click",function(e){
        e.stopPropagation();
    });
    $(".template-download textarea").live("click",function(e){
        e.stopPropagation();
    });
    $(".template-download span").live("dblclick",function(e){
        e.stopPropagation();
    });
    $(".template-download textarea").live("dblclick",function(e){
        e.stopPropagation();
    });


    $('select').live("change", function(){
        
        if ($(this).next().hasClass('error')){
            $(this).next().removeClass('error');            
        }
        if ($('label[for=' + $(this).attr('id') + ']').hasClass('error'))
        {
            $('label[for=' + $(this).attr('id') + ']').remove();
        }
      
       
    });  
    
    //    $('.check').click(function(){
    //        if ($(this).hasClass('selected')){
    //            $(this).removeClass('selected');
    //            $(this).addClass('unselected');
    //        }else{
    //            $(this).addClass('selected');
    //            $(this).removeClass('unselected');
    //        }
    //    });
    

    var catOffset = {
        top: $('#category-finder').offset().top, 
        left: $('#category-finder').offset().left
    }; 
    
    $('body').click(function(){
        $('.menu .finder').hide();
        $('.select .finder').hide();
    });
    $('#main-menu > ul > li > a, #select-category, #header-location-selection  > a').click(function(e){  
        if($(this).attr('id') !== "topnav_sign_up" && $(this).attr('id') !== "topnav_sign_in" && $(this).attr('id') !== "topnav_sign_out")
            e.stopPropagation();

        var open = $(this).nextAll('.finder').eq(0).is(':visible');
        $('.menu .finder').hide();
        $('.select .finder').hide();
        
        if (!open){
            $(this).nextAll('.finder').eq(0).show();
        }  
    });	
    
    
    $('.menu .finder').click(function(e){
        e.stopPropagation();
    });

    $('.menu .finder .column a').click(function(){
        $(this).parents('.finder').hide(); 
    });

    $('#findbystate').click(function(){
        $('.finder .selected').not('.alphabet a').removeClass('selected');
        $('.bystate').addClass('selected');
        $(this).addClass('selected');
        $('.finder .alphabet').show();
    });
    $('#findbymetro').click(function(){
        $('.finder .selected').not('.alphabet a').removeClass('selected');
        $('.bymetro').addClass('selected');
        $(this).addClass('selected');
        $('.finder .alphabet').hide();
    });
    $('#findbysingaporearea').click(function(){
        $('.finder .selected').not('.alphabet a').removeClass('selected');
        $('.byareasingapore').addClass('selected');
        $(this).addClass('selected');
        $('.finder .alphabet').hide();
    });
    $('#findbymap').click(function(){
        $('.finder .selected').not('.alphabet a').removeClass('selected');
        $('.bymap').addClass('selected');
        $(this).addClass('selected');
        $('.finder .alphabet').hide();
    });
    $('#menuCountry > a').click(function(){
        if($('#menuCountry > ul').is(':visible')){
            $('#menuCountry > ul').hide();
        }else{
            $('#menuCountry > ul').show();
        }
    });
    $('#menuCountry ul a').click(function(){
        $('#menuCountry > a').html($(this).html());
        $('#menuCountry > ul').hide();
        if ($(this).html()=='Singapore'){

            $('#findbymetro').hide();
            $('#findbystate').hide();
            $('#findbymap').hide();
            $('#findbyalphabet').hide();
            $('#findbysingaporearea').show();
            $('.finder .selected').not('.alphabet a').removeClass('selected');
            $('.byareasingapore').addClass('selected');

        //$('.finder .selected').not('.alphabet a').removeClass('selected');
        //$('#findbymetro').addClass('selected');  
        //$('.bymetro').addClass('selected');

        }
        if ($(this).html()=='United States'){
            $('#findbymetro').show();
            $('#findbystate').show();
            $('#findbymap').show();
            $('#findbyalphabet').show();
            $('#findbysingaporearea').hide();
            $('.finder .selected').not('.alphabet a').removeClass('selected');
            $('#findbymetro').addClass('selected');  
            $('.bymetro').addClass('selected');
        }
    });

    var passwordField = $('input[type=password]');
    var placeholderField = $('.placeholder');
    passwordField.before(function(){
        if ($(this).attr('title')){   
            return '<input class="example placeholder" style="margin-top:10px;"  type="text" value="'+$(this).attr('title')+'" autocomplete="off" />'
        }else{
            return '<input class="example placeholder" style="margin-top:10px;"  type="text" value="" autocomplete="off" />'   
        }  
    });
    var placeholderField = $('input.placeholder');
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

    $('input[title]').each(function() {
        var type = $(this).attr('type');
        if (type!='password'){
        
          
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
 
   
    $(".widget .hide").click(function(){
        $(this).parents('.widget').last().find('.content').toggle();
        if($(this).hasClass('hidden'))$(this).removeClass('hidden');
        else $(this).addClass('hidden');
    });

    $(".facets a").click(function(){
        $(this).parents('.facets').find('a').removeClass('selected');
        $(this).addClass('selected');
    });  
	
    //$('#imagePickerComp').dialog({autoOpen: false, width: 550, height: 462, resizable: false, modal: true, title: "Edit Photo"});
  
    $('#radioNoPassword').click(function(){
        $('.newpassword').show();
        $('.havepassword').hide();
    }
    );
        
    $('#radioHavePassword').click(
        function(){
            $('.newpassword').hide();
            $('.havepassword').show();
        }
        );
  
    $('.caption span').live("click", function(){
      
        $('.caption span:hidden').html(function(){
            return($(this).siblings('textarea').val());
        });
        $('.caption textarea').hide();
        $('.caption span').show();
        $(this).siblings('textarea').show().focus();
        $(this).siblings('textarea').val($(this).html());
        $(this).hide();
  
    });
    
    $('.caption textarea').live("keydown", function(e){
       
        var keyCode = e.keyCode || e.which; 
        if (keyCode == 13 || keyCode == 9)
        {
            var imageId = $(this).parents('.template-download').find('.image-id').val();
            var caption = $(this).val();
            if (imageId != undefined && imageId != "")
            {
                $.ajax({                   
                    type: "GET",
                    dataType:"json",
                    url: "/post/updatecaption/",
                    data: "imageId=" + imageId + "&caption=" + caption,
                    success: function(response){
                    }
                });
            }
        }
        if(keyCode == 13){            
            $(this).hide();
            $(this).siblings('span').show();
            $(this).siblings('span').html($(this).val()); 
        }
        if(keyCode == 9){
            $(this).hide();
            $(this).siblings('span').show();
            $(this).siblings('span').html($(this).val());
            $(this).parents('li').next().find('.caption textarea').show().focus().select();
            $(this).parents('li').next().find('.caption textarea').val($(this).parents('li').next().find('.caption span').html());
            $(this).parents('li').next().find('.caption span').hide();      
        }  
    });
    
    $('input').live("focus", function(e){
        $(this).next('.iPhoneCheckContainer').addClass('focus');
        $(this).next('.check').addClass('focus');
    });
    $('input').live("change", function(e){
        var next = $(this).next('.check');
        if (next.hasClass('selected')){
            next.removeClass('selected');
            next.addClass('unselected');
        }else{
            next.addClass('selected');
            next.removeClass('unselected');
        }
    });
    $('input').live("blur", function(e){
        $(this).next('.iPhoneCheckContainer').removeClass('focus');
        $(this).next('.check').removeClass('focus');
    });
    $('.toggle-switch').each(function(){
        $(this).after('<span>'+$(this).html()+'</span>');
        onLabel = $(this).next('span'); 
        onLabelWidth = onLabel.width();
        onLabel.remove();
        $(this).after('<span>'+$(this).attr('title')+'</span>');
        offLabel = $(this).next('span');
        offLabelWidth = offLabel.width();
        offLabel.remove();
        
        newWidth = onLabelWidth > offLabelWidth ? onLabelWidth : offLabelWidth;
        $(this).css('width', newWidth);
        
    });
    $('.toggle-switch').live('click', function(){
        var title = $(this).attr('title');
        var current = $(this).html();

        $(this).html(title);
        $(this).attr('title', current);
        if ($(this).hasClass('on')){
            $(this).removeClass('on');
            $(this).addClass('off')
        }else{
            $(this).addClass('on');
            $(this).removeClass('off')
        }
        
    });
//    $('.caption span').click(function(){
//        alert('hey');
//        $(this).siblings('input').show();
//        $(this).siblings('input').val($(this).html());
//        $(this).hide();
//    });
//    $('.caption input').keypress(function(e){
//  
//        if(e.which == 13){
//            $(this).hide();
//            $(this).siblings('span').show();
//            $(this).siblings('span').html($(this).val());
//        }
//    });

      
  
   
/*    $('#searchform .select').mouseover(function(){
        $('#category-finder-search-home').show() ;    
    });
     $('#category-finder-search-home').mouseout(function(){
        $('#category-finder-search-home').hide() ;    
    });*/
    
});


$(document).ready(function() {
    $('#thumbs').jcarousel({       
        });
       
    $('.thumbs .thumb').click(function(){
        $('.thumbs .selected').removeClass('selected');
        $(this).addClass('selected');
        $('.images .current').removeClass('current');
        $('.images > .image').eq($(this).index()).addClass('current');
    });
       
    $(".listing .image").colorbox({
        rel:'image', 
        transition:"none", 
        width:"75%", 
        height:"75%", 
        fixed:'true'
    });
    
    
    $(window).scroll(function(){
        if ($(this).scrollTop() > 300) {
            $('.scrollup').stop(true, true).show();
            ;
            $('.scrollup').animate({
                bottom: -1
            }, 200);
        } else {         
            $('.scrollup').fadeOut(function(){
                $('.scrollup').css('bottom', '-53px');
            });
            
        }
    });
    
    $(".numeric").live("keydown", function(event) {
        if (event.shiftKey)
            event.preventDefault();
        // Allow: backspace, delete, tab and escape
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || 
            // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
            // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if ((event.keyCode >= 48 && event.keyCode <= 57 && event.shiftKey == false) || (event.keyCode >= 96 && event.keyCode <= 105 && event.shiftKey == false )) {
                return; 
            } 
            else
                event.preventDefault();     
        }
    });  
    
    $(".alphanumeric").live("keydown", function(event) {
         
        // Allow: backspace, delete, tab and escape
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || 
            // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
            //Allow comma, dash , period
            (event.keyCode >= 188 && event.keyCode <= 190 && event.shiftKey == false) ||            
            //Allow space
            (event.keyCode == 32) || 
            //Allow hypen and underscore
            (event.keyCode == 109) || 
            //Allow single quote and double quotes
            (event.keyCode == 222) ||     
            // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        else {
            if(event.shiftKey)
            {
                //Allow ! , @ , #,$,%,*,(,)
                if ((event.keyCode >=49 && event.keyCode <=53) ||  event.keyCode ==56 || 
                    //Allow Question mark
                    event.keyCode == 191 || 
                    (event.keyCode >= 65 && event.keyCode <= 90))
                    return;
                else
                    event.preventDefault();    
            }
            else
            {
                // Ensure that it is alphanumeric and stop the keypress
                if( (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 95 && event.keyCode <= 105) ) 
                {
                    return;
                } 
                else
                {
                    event.preventDefault(); 
                }
            }
        }
    });  
  
    $('#dialogMap').dialog({
        autoOpen: false,       
        resizable: false,       
        modal: true,
        width:620,
        dialogClass: 'dialog signup'
               
   
    }); 

    $('#dialogShare').dialog({
        autoOpen: false,       
        resizable: false,       
        modal: true,  
        width:240,
        dialogClass: 'dialog signup'
               
   
    }); 
    $('#dialogMarkerInfo').dialog({
        autoOpen: false,       
        resizable: false,       
        modal: false, 
        width:400,
        dialogClass: 'left notitleWC dialog signup'
               
   
    }); 
    
    $('#dialogDetailsInfo').dialog({
        autoOpen: false,       
        resizable: false,       
        modal: false, 
        width:980,
       
        dialogClass: 'dialog signup'
               
   
    }); 
    $('#dialogTakePic').dialog({
        autoOpen: false,       
        resizable: false,       
        modal: true, 
        width:590,
        height:490,
        dialogClass: 'dialog signup dialogTakePicClose'
               
   
    }); 

    
    $('.take-profile-pic').live("click", function(event){     
        //$('#camera').show();
        $('#dialogTakePic').dialog('open');

    });
   
    
 
    $('#photoUpload').live("click", function(event){     
        event.preventDefault();
        window["link_clicked"] = true;
        $('#fileInput').click();
        window["link_clicked"] = false; 
       

    });
    
    $('#import-file-link').live("click", function(event){     
        event.preventDefault();
        window["link_clicked"] = true;
        $('#importFile').click();
        window["link_clicked"] = false; 
       

    });
    
    $('.upload-profile-pic').live("click", function(event){     
        event.preventDefault();
        window["link_clicked"] = true;
        $('#profilePicInput').click();
        window["link_clicked"] = false; 
      

    });
    
    $('.edit-profile-pic').live("click", function(event){     
        var obj =  $(this).parents('.profile-pic-container');
        var src = $(this).parents('.profile-pic-container').find('img').attr('src');
        if (src.indexOf('noprofile.gif') == -1)
            return launchEditor(obj, src);
        else
            event.preventDefault();

    });

    $('.remove-profile-pic').live("click", function(event){     
        $("#dialogDeleteProfilePic").dialog("open");
        if ($("#dialogDeleteProfilePic").length){
            $( "#dialogDeleteProfilePic" ).dialog('widget').position({
                my:"left top",
                at:"right top",
                of:"#profile-pic",
                offset: "15 60"
            });
        }
    });
    
    function checkFileExtension(filePath) {
      
        if(filePath.indexOf('.') == -1)
            return false;
        

        var validExtensions = new Array();
        var ext = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();
    

        validExtensions[0] = 'jpg';
        validExtensions[1] = 'jpeg';
        validExtensions[2] = 'bmp';
        validExtensions[3] = 'png';
        validExtensions[4] = 'gif';
        
    

        for(var i = 0; i < validExtensions.length; i++) {
            if(ext == validExtensions[i])
                return true;
        }


        alert('The file extension ' + ext.toUpperCase() + ' is not allowed!');
        return false;
    }
    
    $('#profilePicInput').live('change', function()			
    {
        if (checkFileExtension($('#profilePicInput').val()))
            {
        $('#profile-pic-container').mask('Uploading');		
			  
        $("#profilePicupload").ajaxForm({
            success: function(msg) {
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
            }
        }).submit();
            }	 
	
    });
    
    
    
    $('#importFile').live('change', function()			
{ 
      
        var filePath = $('#importFile').val();
        $('#admin_ui_error').html('');
        $('#admin_ui_error').hide();

        if(filePath.indexOf('.') == -1)
            return false;
        var ext = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();
         
        if (ext == 'xml')
        {
            $("#xmlFileUpload").ajaxForm({
                success: function(msg) {
               
                    $('#admin_ui_error').html(msg);
                    $('#admin_ui_error').show();
                    $('.admin-section .admin-heading').show() ;
                    $('.admin-section .buttons').show() ;
                    $('.admin-section .import-export-list').show() ;
                    if (msg == "success")
                    {
                            
                        $('#admin_ui_error').html('Import has been successfully completed');
                        var milliseconds = new Date().getTime();
                        window.location = "#page=admin&refresh=" + milliseconds;
                    } else if (msg == "login-required")
                        {
                             $('.admin-section .admin-heading').hide() ;
                            $('.admin-section .buttons').hide() ;
                            $('.admin-section .import-export-list').hide() ;
                        }
                }
            }).submit();
        }
        else
        {
            $('#admin_ui_error').html('File format is not supported. You can only import xml file.');
            $('#admin_ui_error').show();
        }
	
    });
    
    $("#dialogDeleteProfilePic").dialog({
        autoOpen:false,
        draggable: false,
        resizable: false,
        modal: true,
        dialogClass: 'left notitle',
        width: 250,
        open: function(event, ui) {          
            $('#dialogDeleteSavedSearch .delete').focus();           
        },
        buttons: [

        {
            text: "Cancel",

            click: function() {
              
                $(this).dialog("close");
            },
            className: "button medium primary"
        },
        {
            text: "Delete",
            create: function(event, ui) {
                $(this).addClass("delete button medium primary");
            },
            click: function() {
                var obj =  $('.profile-pic-container');
                var img = $('.profile-pic-container').find('img');
                var src = $('.profile-pic-container').find('img').attr('src');
                if (src.indexOf('noprofile.gif') == -1)
                {
                    $.ajax({
                        type: 'POST',
                        url: "/upload/profilepic/",
                        data: "_method=DELETE",
                        success: function(data){  
                   
                            $("#profile-pic").attr('src','/images/noprofile.gif') ;  
                            $('#edit_photo_title').html('Add Profile Picture');
                            $('#edit_photo_li').hide();
                            $('#remove_photo_li').hide();
                        } 

                    });
                }
                $(this).dialog("close");
               
            }

        }

        ]
    });
    
    
    $('#preview_tags .preview-tags-link').live("click", function(event){     
        window.location = "/#page=search&ref=sr_fs&categoryName=All Categories&refreshRefineSection=true&selectedFields=tag_tc:" + $(this).html() ;  

    });
    
    $('.share .email').live("click", function(event){  
        TrackPageView('/email-to-friend'); 
        var postingId = $(this).attr('id').replace('email_','');        
        saveViewShareEmail(postingId,'Email');
    });

    $('.share .twitter').live("click", function(event){   
        TrackPageView('/twitter-share'); 
        var postingId = $(this).attr('id').replace('twitter_','');      
        saveViewShareEmail(postingId,'Twitter Share');
    });
 
   
 
})
   
function stripsTags(text)
{
    return $.trim($('<div>').html(text).text());
} 
    
function getUrlParameter( name ){
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");  
    var regexS = "[\\?&]"+name+"=([^&#]*)";  
    var regex = new RegExp( regexS );  
    var results = regex.exec( window.location.href ); 
    if( results == null )    return "";  
    else    return results[1];
}
function TrackPageView(page)
{
   
    if (typeof _gaq != 'undefined')
        _gaq.push(['_trackPageview', page]);
    //Update meta data   
    if (page == '/home')
    {  
        $(document).attr('title','LocalJoe - ' + partition +' classifieds for community, apartments, for sale, services, events and recruitment.');
        $('meta[name=description]').attr('content', 'Localjoe provides local classifieds for jobs, housing, automobiles, services, local community, and events');
    } else if (page.indexOf('createpost') != -1)
{
        $(document).attr('title','LocalJoe - ' + partition + ' Create a classified listing');
        $('meta[name=description]').attr('content', 'LocalJoe - ' + partition + ' Create a classified listing');
  
    }
    else if (page.indexOf('editpost') != -1)
    {
        $(document).attr('title','LocalJoe - ' + partition + ' Edit a classified listing');
        $('meta[name=description]').attr('content', 'LocalJoe - ' + partition + ' Edit a classified listing');
  
    }
    else if (page.indexOf('signin') != -1 || page.indexOf('signup') != -1)
    {
        $(document).attr('title','LocalJoe - ' + partition + ' Register or Sign In');
        $('meta[name=description]').attr('content', 'LocalJoe - ' + partition + ' Register or Sign In');
  
    }
    else if (page.indexOf('search') != -1)
    {
       
        var pageUrl = $.param.fragment();  
        var pageObj = $.deparam(decodeURIComponent(pageUrl)); 
        if (pageObj.categoryName == undefined)
        {
            $(document).attr('title','LocalJoe - ' + partition + ' Search');
            $('meta[name=description]').attr('content', 'LocalJoe - ' + partition + ' Search');
        }
        else
        {
            if (page =='/search-with-filter')
            {
                $(document).attr('title','LocalJoe - ' + partition + ' Filtered ' + pageObj.categoryName + ' classifieds');
                $('meta[name=description]').attr('content', 'LocalJoe - ' + partition + ' Filtered ' + pageObj.categoryName + ' classifieds'); 
            }
            else
            {
                $(document).attr('title','LocalJoe - ' + partition + ' ' + pageObj.categoryName + ' classifieds');
                $('meta[name=description]').attr('content', 'LocalJoe - ' + partition + ' ' + pageObj.categoryName + ' classifieds'); 
            }
        }
  
    } 
    else if (page.indexOf('/api/post') != -1)
    {
            
        $(document).attr('title','LocalJoe - '  + $('.post #listing-title-span').html());
        $('meta[name=description]').attr('content','LocalJoe - '  + $('.post #listing-title-span').html()); 
                
    }
    else 
    {
        $(document).attr('title','LocalJoe - ' + partition +' classifieds for community, apartments, for sale, services, events and recruitment.');
        $('meta[name=description]').attr('content', 'Localjoe provides local classifieds for jobs, housing, automobiles, services, local community, and events');
  
    } 

}
$('#topnav_sign_out').live("click", function(event){ 
    signOut();
});
$('#allPosts').live("click", function(event){  
       
    TrackPageView('/my-posts'); 
    event.stopPropagation();
    event.preventDefault();
    $('#mypostsContent').empty();   
    var startRowIndex = 0;
    var rows = $('#noOfRows').val();
    $(this).addClass('selected');
    $('#activePosts').removeClass('selected');
    $('#postResponses').removeClass('selected');
    $('#allActivities').removeClass('selected');
    $('#startRowIndexAllPosts').val('0');
    $('#startRowIndexActivePosts').val('0');
    $('#startRowIndexPostResponses').val('0');
    $('#startRowIndexAllActivities').val('0');
    getUserPosts(startRowIndex,rows,"all","AllPosts");     

         
});
    
$('#activePosts').live("click", function(event){
    TrackPageView('/active-posts'); 
    $('#mypostsContent').empty();
    event.stopPropagation();
    event.preventDefault();
    var startRowIndex = 0;
    var rows = $('#noOfRows').val();
    $(this).addClass('selected');
    $('#allPosts').removeClass('selected');
    $('#postResponses').removeClass('selected');
    $('#allActivities').removeClass('selected');
    $('#startRowIndexAllPosts').val('0');
    $('#startRowIndexActivePosts').val('0');
    $('#startRowIndexPostResponses').val('0');
    $('#startRowIndexAllActivities').val('0');
    getUserPosts(startRowIndex,rows,"Active","ActivePosts");
      
});
    
$('#allActivities').live("click", function(event){
    TrackPageView('/all-activities'); 
    $('#mypostsContent').empty();
    event.stopPropagation();
    event.preventDefault();
    var startRowIndex = 0;
    var rows = $('#noOfRows').val();
    $(this).addClass('selected');
    $('#allPosts').removeClass('selected');
    $('#activePosts').removeClass('selected');
    $('#postResponses').removeClass('selected');
    $('#startRowIndexAllPosts').val('0');
    $('#startRowIndexActivePosts').val('0');
    $('#startRowIndexPostResponses').val('0');
    $('#startRowIndexAllActivities').val('0');
    getUserPosts(startRowIndex,rows,"Active","AllActivities");
      
});

$('#postResponses').live("click", function(event){
    TrackPageView('/post-responses'); 
    $('#mypostsContent').empty();
    event.stopPropagation();
    event.preventDefault();
    var startRowIndex = 0;
    var rows = $('#noOfRows').val();
    $(this).addClass('selected');
    $('#allPosts').removeClass('selected');
    $('#activePosts').removeClass('selected');
    $('#allActivities').removeClass('selected');
    $('#startRowIndexAllPosts').val('0');
    $('#startRowIndexActivePosts').val('0');
    $('#startRowIndexPostResponses').val('0');
    $('#startRowIndexAllActivities').val('0');
    getUserPosts(startRowIndex,rows,"Active","PostResponses");
      
});

$('.post-buttons .button-stats').live("click", function(){   
        
    var postingId = $(this).attr('id').split('_')[1];
    if ( $('#postStats_' + postingId).is(':visible')){
        $('#postStats_' + postingId).hide();
        $(this).html('Show Stats');
    }
    else
    {
        if ($('#postStats_' + postingId).html() == "")
            drawVisualization(postingId);
        $('#postStats_' + postingId).show();
        $(this).html('Hide Stats');
        
           
    }
       
}); 
$('.post-buttons .repost').live("click", function(){   
        
    var postingId = $(this).attr('id').split('_')[1];
    var $currentItem = $(this);
    if (postingId != undefined)
    {
        $currentPost =  $(this).parents('.listing');
           
        $.ajax({
            type: "GET",
            url: "/post/repost/",
            dataType:"json",
            data: "postingId=" + postingId ,
            success: function(response){
                if (response.status == "success")
                {
                        
                    $currentPost.addClass('Active');                                                 
                    $currentPost.find('.status-tag').html('Active'); 
                    $currentPost.find('.expires').html('Expires in 7 days'); 
                    $currentPost.removeClass('Deleted Expired');
                       
                    //$currentPost.find('.repost').remove();
                    $currentPost.find('.delete').show();
                    $currentPost.css('height',$('#repost_' + postingId).parents('.listing').height()); 
                    $currentPost.parents('.items').prepend($currentPost);  
                    $('#dialogRepost').dialog('open');
                }
            }
        });
           
    }
       
});  

$('.admin-section .export').live("click", function(){   
       
    $.ajax({
        type: "GET",
        url: "/admin/export/",
        dataType:"json",
           
        success: function(response){
            alert(response);
        }
    });
       
});

$('.admin-section .upload-image-mailbox').live("click", function(e){   
       
    $.ajax({
        type: "GET",
        url: "/admin/reademail/",
        dataType:"json",
           
        success: function(response){
            
        }
    });
    e.preventDefault();   
});
    
$('.resetpwd-section .change').live("click", function(){
    
    $('.resetpwd-section #reset_pwd_error').hide();
    if ($(".resetpwd-section #new_password").val() =='New Password')
        $(".resetpwd-section #new_password").val('');
    if ($(".resetpwd-section #retype_new_password").val() =='Retype New Password')
        $(".resetpwd-section #retype_new_password").val('');
        
    var validate =  $("#reset_password_form").validate({
        rules: {                           
              
                                      
            new_password:"required",
            retype_new_password: {
                                            
                equalTo: "#new_password"
            }
        },
        messages: {
               
                                      
            new_password:"New password is required.", 
            retype_new_password: {    
                    
                equalTo: "Retype the new password."
            }
        }
    });
       
      
    var isNPValid = validate.element( ".resetpwd-section #new_password" );              
    var isRNPValid = validate.element( ".resetpwd-section #retype_new_password" );
    
    if (isNPValid && isRNPValid)
    {                    
        $.ajax({
            global:false,
            type: "GET",   
            cache:false,
            dataType:"jsonp",
            crossDomain:true,   
            url: $("#sso_url").val() + "/reset_password.php?userId=" +  $(".resetpwd-section #user_id").val() + "&newPassword=" + $.md5($(".resetpwd-section #new_password").val()),
            success: function(data) {
                  
                if (data.status == 'success')     
                {                   
                    signin($('.resetpwd-section #user_email').val(),$(".resetpwd-section #new_password").val(),'reset-password');
                } 
                else
                {
                    $('.resetpwd-section #reset_pwd_error').show();
                    $('.resetpwd-section #reset_pwd_error').html(data.message);
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
    else
    {
        $(".resetpwd-section #old_password").attr('title','Old Password');
        $(".resetpwd-section #new_password").attr('title','New Password');
        $(".resetpwd-section #retype_new_password").attr('title','Retype New Password');
                   
    } 
      
});
    
$('.change-email-section .authorize').live("click", function(){
    
    $('.change-email-section #change_email_error').hide();
    if ($(".change-email-section #password").val() =='Password')
        $(".change-email-section #password").val('');
            
    var validate =  $("#change_email_form").validate({
        rules: {                           
              
                                      
            password:"required"
               
        },
        messages: {
               
                                      
            password:"Password is required."
        }
    });
       
      
    var isPwdValid = validate.element( ".change-email-section #password" );              
       
    if (isPwdValid)
    {
            
            
        signin($('.change-email-section #user_email').val(),$(".change-email-section #password").val(),'change-email');
                 
    }
    else
    {
        $(".change-email-section #password").attr('title','Password');
                     
    } 
      
});
 
   
   


