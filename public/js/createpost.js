$('#menu-create').addClass('selected');
$("#phototabs").tabs();	
if (editPost != true)
{        
    $('#tags').textext({
        plugins : 'tags'
    });
}
$('#anon').iphoneStyle({
    checkedLabel: 'Yes',
    uncheckedLabel: 'No',
    resizeHandle:false
});


var $wizard = $("#wizard");

$wizard.jWizard({
    finishText: finishText,
    menuEnable: true,
    counter: {
        enable: false,
        type: "percentage", 
        location: "header", 
        startCount: true,  
        startHide: true,   
        finishCount: false, 
        finishHide: false, 
        appendText: "Done"
    },
    buttons: {
        cancelHide: true   
    }
});


$('.jw-button-next, .jw-button-previous').addClass('button primary medium');
$('.jw-button-cancel').addClass('hidden');
$('.jw-button-finish').addClass('button medium finish');
  
$('.jw-menu ol a').live("click", function(){
    if ($(this).parent('li').hasClass('jw-active')){
    //        alert("Hello");
    }
  
});

function LoadCategoryAttributes(categoryId,postingCategoryAttributes)
{
    //$('#main').mask('Loading Post Info...');
    $.ajax({
        type: "GET",
        url: "/category-attributes/get/",
        data: "category_id=" + categoryId,
        success: function(data){                      
            $("#categoryAttrSection").html("");
            $('<div id="categoryAttrSectionHtml"></div>').appendTo('#categoryAttrSection')
            $("#categoryAttrSectionHtml").replaceWith(data);
            $("#post_info_form").show();
            $(".jw-footer").show();
            $('.dateContainer').children().each(function() {
                var tagName = $(this).get(0).tagName;                        
                if (tagName == "INPUT")
                {
                    $(this).datepicker({
                        dateFormat: dateformat,
                        minDate: 0
                    });
                }
            });  
            $("select").combobox({
                selected: function (event, ui) {
                    $(ui.item.parentNode).change();                           
                }
            });
            //$('#main').unmask();  
            //LoadPhotoLibrary() ;              
                    
            var validator =  $("#post_info_form").validate();                 
            validator.resetForm();
            validator = $("#location_info_form").validate();
            validator.resetForm();
            if (editPost != undefined && editPost !="" && postingCategoryAttributes != undefined)
            {
                SetCategoryAttributeValues(postingCategoryAttributes);                
            }         
                   
        }
    });
}

function SetTags(tags)
{
    //var tags = $('#tags').val();
    $('#tags').val('');
    var tagsArray = tags.split(',');   
    $('#tags').textext({
        plugins : 'tags',
        tagsItems : tagsArray
    });   

}

function SetCategoryAttributeValues(postingCategoryAttributes)
{
    var categoryAttrAllIds = $('#categoryAttrAllIds').val();   
    var categoryAttrArray = categoryAttrAllIds.split(',');
    var categoryAttrIdsOnly = $('#categoryAttrIdsOnly').val();   
    var categoryAttrIdsOnlyArray = categoryAttrIdsOnly.split(',');
   
    var counter = 0;
    $('#categoryAttrSection').children('div').each(function () {
                           
       
        var ids = categoryAttrArray[counter];
        var categoryAttrId = categoryAttrIdsOnlyArray[counter];
        counter++;
        var sameCategoryIds = ids.split('|');
        
        var selectedValue = null;
        var selectedDim = null;
        var selectedCategoryAttrId = null;
        // alert(categoryAttrId);   
        for (var j =0;j < postingCategoryAttributes.length ; j++)
        {
            //alert(postingCategoryAttributes[j]['category_attribute_id']);
            if (categoryAttrId == postingCategoryAttributes[j]['category_attribute_id'])
            {
                selectedCategoryAttrId = postingCategoryAttributes[j]['category_attribute_id'];
                selectedValue = postingCategoryAttributes[j]['value'];
                selectedDim = postingCategoryAttributes[j]['dimension'];
                break;
            }  
        }
     
        for (i = 0; i < sameCategoryIds.length;i++ )
        {
           
            if (selectedCategoryAttrId != null)
            {       
                if ($('#' + sameCategoryIds[i]).attr('type') == 'text' )
                {                                    
                    if (selectedValue != null) 
                    {
                        if (ids.indexOf("category_dim_dd") != -1 && $('#' + sameCategoryIds[i]).next().children("option:selected").text() != "Select")
                        {                                        
                            $('#' + sameCategoryIds[i]).val(selectedValue);
                            $('#' + sameCategoryIds[i]).next().combobox("destroy");
                            $('#' + sameCategoryIds[i]).next().children("option[value='" + selectedDim +"']").attr("selected", "selected");
                            $('#' + sameCategoryIds[i]).next().combobox();
                        }
                        else
                            $('#' + sameCategoryIds[i]).val(selectedValue);                                   
                    }        
                                                   
                }                                   
                if ($('#' + sameCategoryIds[i]).hasClass("check") )
                {
                    if (selectedValue != null) 
                    {                           
                        var selectedCheckArray = selectedValue.split(',');
                        for (var k = 0;k < selectedCheckArray.length ;k++)
                        {
                            if ($('#' + sameCategoryIds[i]).html() == selectedCheckArray[k])
                            {
                                $('#' + sameCategoryIds[i]).addClass("selected"); 
                                $('#' + sameCategoryIds[i]).removeClass("unselected");
                            }
                        }
                    }
                }
                if ($('#' + sameCategoryIds[i]).attr('type') == 'checkbox' )
                {
                       
                    if (selectedValue != null) 
                    {
                        if ($('#' + sameCategoryIds[i]).val() == selectedValue)
                            $('#' + sameCategoryIds[i]).attr("checked","checked"); 
                        $('#' + sameCategoryIds[i]).iphoneStyle("refresh");
                    }
                }
                if (sameCategoryIds[i].indexOf("category_dd") != -1  )
                {                                    
                    $('#' + sameCategoryIds[i]).combobox("destroy");
                    $('#' + sameCategoryIds[i]).children("option[value='" + selectedValue +"']").attr("selected", "selected");
                    $('#' + sameCategoryIds[i]).combobox();
                                   
                }
            }
                              
        }
       
    });
}

$('#jw-button-finish').click(function(){
    checkBeforeCreatePost();
})
$('#jw-button-finish-top').click(function(){
    checkBeforeCreatePost();
})

function LoadPhotoLibrary()  
{
    $('#phototabs').mask('Loading Photos...');
    $("#uploadFileListing").html("");
    $('#fileupload').each(function () {
        var that = this;          
        $.getJSON(this.action, function (result) {
            $('#phototabs').unmask('Loading Photos...');
            if (result && result.length) {
                $(that).fileupload('option', 'done')
                .call(that, null, {
                    result: result
                });
            }else{
                $('#tabs-1').addClass("empty");
            }
        });
    });  
}

function checkBeforeCreatePost()
{
    var loggedIn = 'false';
    $.ajax({
        type: "GET",
        dataType:"json",
        url: "/user/checkloginstatus/",                       
        success: function(logStatus){
                             
            if (logStatus.loggedInStatus == 1)                                                                   
                loggedIn = 'true';                                                       
                        
            if (loggedIn == 'false')
            {
                                
                $('#dialogSignUp #sign_in_email').val($('#reply_email_addr').val()); 
                $('#dialogSignUp #sign_in_email').attr('readonly','readonly');  
                $('#dialogSignUp #register_email').val($('#reply_email_addr').val()); 
                $('#dialogSignUp #register_email').attr('readonly','readonly'); 
                        
                $('#dialogSignUp #sign-up-page').val("createpost-preview"); 
                $('#dialogSignUp .join-tab').show();
                $('#dialogSignUp .signin-tab').hide();
                $('.button.register').show();
                $('.button.login').hide();
                $('#dialogSignUp a.button-facebook-large').hide();
                $('#dialogSignUp a.button-google-large').hide();
                $('#dialogSignUp #sign_in_exists').hide();
                $('#dialogSignUp #register_only').show();
                $('#dialogSignUp #register-header').hide();
                $('#dialogSignUp').dialog('open'); 
            }
                       
            if (loggedIn == 'true')
            {
                createPost();
                        
            }
        }  
    });  
}

function createPost()
{
                    
    var post_title = $('#post_title').val();
    var post_desc = tinyMCE.get('post_desc').getContent();
    //var post_desc = tinyMCE.activeEditor.getContent();   
    post_desc = escape(post_desc);   
    var category_id = $('#selected_category_id').val();             
    var posting_attributes = $('#posting_attributes_hidden').val();
    var zip_code = $('#zip_code').val();
    var location_address = $('#location_address').val();
   
    var city =  $('#location_city').val();
    var lat =  $('#location_lat').val();
    var lon =  $('#location_lon').val();
    var phone_no = $('#phone_no').val();
    var postAnonymously = 'No';
    //Post anonymously
    if ($('#anon').is(":checked"))    
        postAnonymously = 'Yes'  ;                           
                
    var tags = ($.parseJSON($.trim($('input[name="tags"]').val()))).toString();
                
    //Convert posting attributes to json object              
    var postAttrJson = ""; //declare array  

    if (posting_attributes != "")
    {
        var postAttrArray = posting_attributes.split('~$~');
        for (var i = 0 ; i < postAttrArray.length ; i++)
        {
            if (postAttrArray[i] != "")
            {
                if (postAttrJson == "")
                    postAttrJson = '{"category_attribute_id":"'+ postAttrArray[i].split('|')[0] + '", "value":"' +  postAttrArray[i].split('|')[1] + '", "dimension":"' +  postAttrArray[i].split('|')[2] + '"}';
                else
                    postAttrJson = postAttrJson + ','  +  '{"category_attribute_id":"'+ postAttrArray[i].split('|')[0] + '", "value":"' +  postAttrArray[i].split('|')[1] + '", "dimension":"' +  postAttrArray[i].split('|')[2] + '"}'; 
            }
        }
    }
                
    //Library Images
    var libraryImagesJson = ""; 
    $('#uploadFileListing > li').each(function (index) {                     
                                  
        var caption = $(this).find(".caption").find('span').html();
        var fileName = $(this).find(".file-name").val();
        var imageId = $(this).find(".image-id").val(); 
        var size = $(this).find(".file-size").val();
        var org_image_width = $(this).find(".org-image-width").val();      
        var org_image_height = $(this).find(".org-image-height").val();      
        var image_type_width = $(this).find(".image-type-width").val();      
        var image_type_height = $(this).find(".image-type-height").val();      
        var image_type_size = $(this).find(".image_type_size").val();      
        if (libraryImagesJson == "")
            libraryImagesJson = '{"fileName":"'+ fileName + '", "imageId":"' +  imageId + '","caption":"' 
            + caption + '","size":"' + size + '","org_image_width":"' + org_image_width + '","org_image_height":"' + org_image_height + 
            '","image_type_width":"' + image_type_width + '","image_type_height":"' + image_type_height + '","image_type_size":"' + image_type_size + '"}';
        else
            libraryImagesJson = libraryImagesJson + ','  +  '{"fileName":"'+ fileName + '", "imageId":"' +  imageId + '","caption":"' 
            + caption + '","size":"' + size + '","org_image_width":"' + org_image_width + '","org_image_height":"' + org_image_height + 
            '","image_type_width":"' + image_type_width + '","image_type_height":"' + image_type_height + '","image_type_size":"' + image_type_size + '"}';
                            
    });
                 
    //End
                
    //Posting Images
    var postImagesJson = ""; 
               
    $('#uploadFileListing > li').each(function (index) {
                      
        var isCover = 0;
        if ($(this).hasClass('cover'))
            isCover = 1;
        if ($(this).find('.edit-select').find('a').hasClass("selected"))
        {
                                  
            var caption = $(this).find(".caption").find('span').html();
            var fileName = $(this).find(".file-name").val();
            var imageId = $(this).find(".image-id").val();  
            var size = $(this).find(".file-size").val();
            var org_image_width = $(this).find(".org-image-width").val();      
            var org_image_height = $(this).find(".org-image-height").val();      
            var image_type_width = $(this).find(".image-type-width").val();      
            var image_type_height = $(this).find(".image-type-height").val();      
            var image_type_size = $(this).find(".image_type_size").val();  
            if (postImagesJson == "")
                postImagesJson = '{"fileName":"'+ fileName + '", "imageId":"' +  imageId + '","caption":"' 
                + caption + '","size":"' + size + '","org_image_width":"' + org_image_width + '","org_image_height":"' + org_image_height + 
                '","image_type_width":"' + image_type_width + '","image_type_height":"' + image_type_height + '","image_type_size":"' + image_type_size + '","is_main_image":"' + isCover +'"}';
            else
                postImagesJson = postImagesJson + ','  +  '{"fileName":"'+ fileName + '", "imageId":"' +  imageId + '","caption":"' 
                + caption + '","size":"' + size + '","org_image_width":"' + org_image_width + '","org_image_height":"' + org_image_height + 
                '","image_type_width":"' + image_type_width + '","image_type_height":"' + image_type_height + '","image_type_size":"' + image_type_size + '","is_main_image":"' + isCover +'"}';
        }
    });
                 
    //End= 
    var postingToBeEdited = "";
    
    if (editPost != undefined && editPost != null && editPost == true)
    {
        if (postingId != undefined && postingId != null && postingId != "")
        {
            postingToBeEdited = postingId;
            $('#preview_post_listing').mask('Saving Post...')
        }
    }
    else
    {
        $('#preview_post_listing').mask('Creating Post...')
    }
        
    var postDataJson = '{"postingId":"' + postingToBeEdited + 
    '","post_title":"' + post_title +
    '","post_desc" :"' + post_desc + 
    '","postAnonymously" :"' + postAnonymously + 
    '","category_id" :"' + category_id + 
    '","zip_code"  :"' + zip_code + '",' +
    '"location_address":"' + location_address + '",' +
    '"tags":"' + tags + '",' +
    '"city":"' + city + '",' +
    '"lat":"' + lat + '",' +
    '"lon":"' + lon + '",' +
    '"phone_no":"' + phone_no + '",' +                            
    '"posting_category_attributes":[' + postAttrJson + '],' +
    '"library_images":[' + libraryImagesJson + '],' +
    '"posting_images":[' + postImagesJson + ']}';
    

    $.post('/post/save/', {
        data: postDataJson
    }, function(data) {
        $('#preview_post_listing').unmask(); 
        if (postingToBeEdited == undefined || postingToBeEdited == "")
            window.location.href = "/#page=profile&ref=createpost"; 
        else
            window.location.href = "/#page=profile";       
    });    
    
//$wizard._trigger("finish", event);                            
                        
}

$('#phone_no').blur(function() {
    if($(this).val() === '') {
        $(this).val($(this).attr('title')).addClass('example');
    }
});
  

  


//End

	//$("#post_info_form").show("fast","swing"); 
    //$('.jw-footer').show("slow","swing");

