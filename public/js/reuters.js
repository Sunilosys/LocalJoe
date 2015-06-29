
var loadMessage = 'Searching...';
var isSearchClicked = false;
var isLoadMore = false;
var state = false;
var isSelected = false;
var isLinkClicked = false;
var markersArray;
function scroll() {   
    //$('#mapContentDiv').hide();
    if ($(window).scrollTop() == $(document).height() - $(window).height()) {
        showMore();
    }

}
$('#pageNavShowMore').live("click", function(e){
    showMore();
    e.preventDefault();
})

function showMore()
{
    var start = 0;
    var numFound = 0;
    var rows = 0;
    if ($('#startRowIndex') && $('#numFound') && $('#solrRows'))
    {
        start = parseInt($('#startRowIndex').val());
        numFound = parseInt($('#numFound').val());
        rows = parseInt($('#solrRows').val());

    }
    if (start < numFound)
    {
        loadMessage = "Loading...";
        isLoadMore = true;
        $('#last_post_loader').mask(loadMessage);
        updateSearch('true','');
    }
    else
        $('div#last_post_loader').unmask();
}

$('#searchform ul a').click(function(){
    $('#searchform a.select-category').html($(this).html());
    $('#selected_category_hidden').val($(this).attr('id'));
    $('#category-finder-search-home').hide() ;
});

$('#main-menu .categories-list ul a').click(function(e){
    $('#searchform a.select-category').html($(this).html());
    $('#selected_category_hidden').val($(this).attr('id'));
    dosearch();
    e.preventDefault();
    
});
$('#homewrap .categories-list ul a').live("click", function(e){
    $('#searchform a.select-category').html($(this).html());
    $('#selected_category_hidden').val($(this).attr('id'));
    dosearch();
    e.preventDefault();
    
});


function dosearch(){

    window.onscroll = scroll;
    $('#category-finder-search-home').hide() ;   
    //    $('#last_post_loader').mask(loadMessage);
    //    $('#main').load('/search/index/', function() {
    //            
    //        $('#searchContentDiv').empty();
    //        $('#leftNavForm').empty();
    //        $('#breadcrumbs-list').empty();
    //        $('#startRowIndex').val('0');
    //        $('#last_post_loader').mask(loadMessage);
    //        SearchWithoutFs('true','');
    //    
    //    });
    TrackPageView('/search-without-filter');
    SearchWithoutFs('true','');
    
}
$('#search_across_category').click(function(e){
    isSearchClicked = true;
    loadMessage = 'Searching across ' + $('#searchform a.select-category').html() + '...';  

    dosearch();
    if ($('div#first_post_loader'))
    {
        $('div#first_post_loader').show();
        
        $('div#first_post_loader').mask(loadMessage);
    }
    e.preventDefault();
});

$('#search').live("keydown", function(e){
    var keyCode = e.keyCode || e.which;
    if((keyCode == 13) || (keyCode == 9)){
        $('#search_across_category').click();
        e.preventDefault();
    }
});

function updateHref(searchText,categoryName,isParentCategory,sectionNotToBeRefreshed,refreshRefineSection,
    categoryFields,selectedFields,rangeFields,dateFields,multiSelectFields,start,sort)
{
    var searchData = "";
    if (searchText != undefined && searchText != "")
        searchData = "keyword=" + searchText ;
    else
        searchData = "keyword=" ;
          
    if (categoryName != undefined && categoryName != "")
        searchData = searchData + "&categoryName=" + categoryName ;
    if (isParentCategory != undefined && isParentCategory != "")
        searchData = searchData + "&isParentCategory=" + isParentCategory ;
    if (refreshRefineSection != undefined && refreshRefineSection != "")
        searchData = searchData + "&refreshRefineSection=" + refreshRefineSection ;
    if (categoryFields != undefined && categoryFields != "")
        searchData = searchData + "&categoryFields=" + categoryFields ;
    if (selectedFields != undefined && selectedFields != "")
        searchData = searchData + "&selectedFields=" + selectedFields ;
            
    if (rangeFields != undefined && rangeFields != "")
        searchData = searchData + "&rangeFields=" + rangeFields ;
         
    if (dateFields != undefined && dateFields != "")
        searchData = searchData + "&dateFields=" + dateFields ;
    if (multiSelectFields != undefined && multiSelectFields != "")
        searchData = searchData + "&multiSelectFields=" + multiSelectFields ;
    if (start != undefined && start != "")
        searchData = searchData + "&start=" + start ;
    if (sort != undefined && sort != "")
        searchData = searchData + "&sort=" + sort ;
    var now = new Date();
    var searchId = now.getTime();     
    if (sectionNotToBeRefreshed != undefined && sectionNotToBeRefreshed != "")
        searchData = searchData + "&sectionNotToBeRefreshed=" + sectionNotToBeRefreshed ;
    searchData = searchData + "&searchId=" + searchId;
    
    if (window.location.href.indexOf('/api/') != -1)
        window.location = "/#page=search&ref=sr_fs&" + searchData;   
    $("#leftNavForm ul a").attr('href','#page=search&ref=sr_fs&' + searchData);         
              
}
    
function SearchWithoutFs(refreshRefineSection,sectionNotToBeRefreshed)
{
    var searchText = "";
    var categoryName = "";
    var isParentCategory = "";
    var categoryFields = "";
    var selectedFields = "";
    var rangeFields = "";
    var dateFields ="";
    var multiSelectFields = "";
    var start = $('#startRowIndex').val();
    var sort = "posting_date_dt desc";
    searchText =  $.trim($("#search").val());
    var selectedCategoryId = $('#selected_category_hidden').val();
    categoryName = $('#searchform a.select-category').html();
    if (selectedCategoryId.indexOf('parentcategory') != -1)
    {
        isParentCategory = 'true';
        categoryFields = "parent_category_name_t:" + categoryName;
    }
    else if (selectedCategoryId.indexOf('category') != -1)
    {

        var parentCategoryId = selectedCategoryId.split('_')[1];
        categoryFields = "category_name_t:" + categoryName;
        categoryName = $('#searchform #parentcategory_' + parentCategoryId).html();
        isParentCategory = 'false';

    }
    $("#leftNavForm").show(); 
    //Append time to URL for unique URL so tha hash change event gets fired
    var now = new Date();
    var searchId = now.getTime();
    if (window.location.href.indexOf('/api/') != -1)
        window.location = "/#page=search&ref=sr_nofs&keyword=" + searchText + "&categoryName=" + categoryName
        + "&categoryFields=" + categoryFields +"&isParentCategory=" + isParentCategory + "&sort=" + sort + "&searchId=" + searchId;
    else
        window.location = "#page=search&ref=sr_nofs&keyword=" + searchText + "&categoryName=" + categoryName
        + "&categoryFields=" + categoryFields +"&isParentCategory=" + isParentCategory + "&sort=" + sort + "&searchId=" + searchId;
//search(searchText,categoryName,isParentCategory,sectionNotToBeRefreshed,refreshRefineSection,
//    categoryFields,selectedFields,rangeFields,dateFields,multiSelectFields,start,sort);
}
function updateSearch(refreshRefineSection,sectionNotToBeRefreshed)
{
    var searchText = "";
    var categoryName = "";
    var isParentCategory = "";
    var categoryFields = "";
    var selectedFields = "";
    var rangeFields = "";
    var dateFields ="";
    var multiSelectFields = "";
    var start = $('#startRowIndex').val();
    var sort ="";
    searchText =  $.trim($("#search").val());
    var selectedCategoryId = $('#selected_category_hidden').val();
    categoryName = $('#searchform a.select-category').html();
    $("#leftNavForm").show();
    if (selectedCategoryId.indexOf('parentcategory') != -1)
    {
        isParentCategory = 'true';
        categoryFields = "parent_category_name_t:" + categoryName;
    }
    else if (selectedCategoryId.indexOf('category') != -1)
    {

        var parentCategoryId = selectedCategoryId.split('_')[1];
        categoryFields = "category_name_t:" + categoryName;
        categoryName = $('#parentcategory_' + parentCategoryId).html();
        isParentCategory = 'false';

    }

    var leftNavSelectedCatFields = getCategorySelectFields();
    if (leftNavSelectedCatFields !="")
    {
        categoryFields = leftNavSelectedCatFields;
        if (leftNavSelectedCatFields.indexOf('parent_category_name_t') != -1)
        {
            isParentCategory = 'true';
            categoryName =leftNavSelectedCatFields.split(':')[1];
        }
    }

    var leftNavCatMultiSelectFields = getCategoryMultiSelectFields();
    if (leftNavCatMultiSelectFields !="")
    {
        categoryFields =  leftNavCatMultiSelectFields;

        isParentCategory = 'false';
    }

    //refreshRefineSection = 'true';
    multiSelectFields = getMultiSelectFields();
    multiSelectFields = multiSelectFields.replace(/\+/g,"~plus~")
    selectedFields = getSelectFields();
    selectedFields = selectedFields.replace(/\+/g,"~plus~");
    dateFields = getDateFields();

    if (sectionNotToBeRefreshed.indexOf('_range_section') != -1)
    {
        sectionNotToBeRefreshed ="";
    }
    //else if (multiSelectFields != "" || selectedFields != "" || dateFields !="")
    rangeFields = getRangeFields();

    sort = getSortType();  
    TrackPageView('/search-with-filter');
    if (sectionNotToBeRefreshed =="" && isLinkClicked == false && isSelected == false)
    {            
        if (!isLoadMore) 
        {
            $('#first_post_loader').show();
            
            $('div#first_post_loader').mask("Applying your filter choices...");    
        }
        search(searchText,categoryName,isParentCategory,sectionNotToBeRefreshed,refreshRefineSection,
            categoryFields,selectedFields,rangeFields,dateFields,multiSelectFields,start,sort);
    }
    else
    {
        if (isLinkClicked === true)
        {
            $('#startRowIndex').val('0');
            start = 0;
        }
        isLinkClicked = false;        
        updateHref(searchText,categoryName,isParentCategory,sectionNotToBeRefreshed,refreshRefineSection,
            categoryFields,selectedFields,rangeFields,dateFields,multiSelectFields,start,sort);
    }
}

function search(searchText,categoryName,isParentCategory,sectionNotToBeRefreshed,refreshRefineSection,
    categoryFields,selectedFields,rangeFields,dateFields,multiSelectFields,start,sort)
{
   
 
    var startRowIndex =  $('#startRowIndex').val();
    var rows = $('#solrRows').val();
    $('#startRowIndex').val(parseInt(startRowIndex) + parseInt(rows));  
    //$('div#last_post_loader').html('<img  src="/images/loading.gif" width="40px" height="40px">');
    
    $('#category-finder-search-home').find('a').each(function (index){
        
        if ($(this).html() == categoryName.replace('"',"").replace('"',''))
        {
           
            $('#breadcrumbs-list').empty();
            $('<li><a href="#page=home"></a></li>').appendTo('#breadcrumbs-list');
            $('<li><a class="breadcrumb-link-with-href" id="breadcrumbs_parentcategory">' + categoryName.replace('"','').replace('"','') + '</a></li>').appendTo('#breadcrumbs-list');

        }
    });
    var searchData = "searchText=" + searchText + '&categoryName=' + categoryName
    + '&isParentCategory=' + isParentCategory
    + "&refreshRefineSection=" + refreshRefineSection + '&categoryFields=' + categoryFields + '&selectedFields=' + selectedFields
    + "&rangeFields=" + rangeFields +  "&dateFields=" + dateFields + '&multiSelectFields=' + multiSelectFields
    + "&start=" + start + "&sort=" + sort;
   
    $('searchBy').val('filter');
    $('search_by_shortlistId').val('');
    $.ajax({
        global:false,
        type: "GET",
        url: "/search/listing/",
        data:searchData ,
        //contentType: "application/json; charset=utf-8",
        success: function(listingResponse){
          
            if (listingResponse != "")
            {
                var numFound;
                var searchResult;
                
                if (refreshRefineSection == 'true')
                {
                    var sectionNotToBeRefreshedHtml ="";
                    if (sectionNotToBeRefreshed != '')
                    {
                        sectionNotToBeRefreshedHtml = $('#' + sectionNotToBeRefreshed).html();
                        if (sectionNotToBeRefreshedHtml != null)
                        {    
                            if ($('#' + sectionNotToBeRefreshed).hasClass('facets'))
                                sectionNotToBeRefreshedHtml = '<ul id="' + sectionNotToBeRefreshed + '" name="' + sectionNotToBeRefreshed + '" class="facets">' + sectionNotToBeRefreshedHtml + '</ul>';
                            else
                                sectionNotToBeRefreshedHtml = '<ul id="' + sectionNotToBeRefreshed + '" name="' + sectionNotToBeRefreshed + '">' + sectionNotToBeRefreshedHtml + '</ul>';
                        }
                    }


                    var leftNav = listingResponse.split('<leftNavSection>')[1];
                    searchResult = listingResponse.split('<leftNavSection>')[0];
                    numFound = searchResult.split('<SolrNoFound>')[1];
                    searchResult =searchResult.split('<SolrNoFound>')[0];
                    
                    $('#numFound').val(numFound);
                    if (parseInt(numFound) > 0)
                    {
                        $('#leftNavForm').empty();
                        $('#search_count_display').show();
                        if (parseInt(numFound) < parseInt($('#startRowIndex').val()))
                        {
                                
                            $('#pageNavShowMore').hide();
                            $('#search_count_display').html('Showing 1-' + numFound + ' of ' + $('#numFound').val());
                        }
                        else
                        {
                                
                            $('#pageNavShowMore').show();
                            $('#search_count_display').html('Showing 1-' + $('#startRowIndex').val() + ' of ' + $('#numFound').val());
                        }
                        if (startRowIndex == '0')
                            $('#searchContentDiv').empty();
                       
                        $(searchResult).appendTo($('#searchContentDiv'));
                        $(leftNav).appendTo($('#leftNavForm'));
                        if (sectionNotToBeRefreshedHtml != null && sectionNotToBeRefreshedHtml != "")
                        {
                            var selectedItems =  "";  
                            var solrColumnValue = "";
                            $('#' + sectionNotToBeRefreshed).find('a.selected').each(function (index){
                                solrColumnValue = $.trim($(this).html().split("(")[0]);
                                selectedItems = selectedItems + solrColumnValue;
                            })    
                                                   
                            $('#' + sectionNotToBeRefreshed).replaceWith(sectionNotToBeRefreshedHtml);
                            $('#' + sectionNotToBeRefreshed).find('a').each(function (index){
                                solrColumnValue = $.trim($(this).html().split("(")[0]);
                                if (selectedItems.indexOf(solrColumnValue) != -1)
                                {
                                    $(this).addClass('selected');
                                    if ($(this).hasClass('check'))
                                        $(this).removeClass('unselected');                                  
                                        
                                }
                                else
                                {
                                    if ($(this).hasClass('check'))
                                        $(this).addClass('unselected');
                                    $(this).removeClass('selected'); 
                                }
                            }) 
                        }
                        if (dateFields == "")
                        {
                            $('#leftNavForm input[title]').each(function() {

                                $(this).val($(this).attr('title')).addClass('example');
                            });
                        }
                        ApplyDatePicker();
                        ApplySlider();
                       
                        ApplyColorBox() ; 
                       
                        populateSortBy(sort);
                        $('div#last_post_loader').unmask();
                        $('div#first_post_loader').unmask();
                        $('div#first_post_loader').hide();
                        if (sectionNotToBeRefreshed == "")
                        {
                            ApplyDialog();
                            if (categoryName == "All Categories" && start == 0)
                            {
                                $("#dialogCategoryHelp").dialog("open");
                                
                                setTimeout(function(){
                                    $("#dialogCategoryHelp").dialog("close")
                                },3000);
                                positionDialogs();
                            }
                        } 
                    }
                    
                    
                    
                }
                else
                {
                    numFound = listingResponse.split('<SolrNoFound>')[1];
                    $('#numFound').val(numFound);
                    if (parseInt(numFound) > 0)
                    {
                        searchResult =listingResponse.split('<SolrNoFound>')[0];
                        if (startRowIndex == '0')
                            $('#searchContentDiv').empty();
                       
                        $(searchResult).appendTo($('#searchContentDiv'));
                        //loadMapWithSpiderfier();
                        ApplyColorBox() ;  
                    }
                }
                if (parseInt(numFound) == 0)
                {
                    $('#search_count_display').hide();
                    searchResult = '<a><div class="empty-search"></div></a>';
                    if (startRowIndex == '0')
                        $('#searchContentDiv').empty();
                       
                    $(searchResult).appendTo($('#searchContentDiv'));
                }
               
                $('div#last_post_loader').unmask();
                $('div#first_post_loader').unmask();
                $('div#first_post_loader').hide();
                    
            }
            else
            {
                $('#search_count_display').hide();
                searchResult = '<a><div class="empty-search"></div></a>';
                if (startRowIndex == '0')
                    $('#searchContentDiv').empty();
                       
                $(searchResult).appendTo($('#searchContentDiv'));
                $('div#last_post_loader').unmask();
                $('div#first_post_loader').unmask();
                $('div#first_post_loader').hide();
            }
            updateHref(searchText,categoryName,isParentCategory,sectionNotToBeRefreshed,refreshRefineSection,
                categoryFields,selectedFields,rangeFields,dateFields,multiSelectFields,start,sort);
            
            if( $('#mapContentDiv').is(':visible') ) {
                loadMapWithSpiderfier();
            }
               
            $('div#first_post_loader').hide();
                
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

function ApplyColorBox()
{
     
    
    $('#searchContentDiv').find('.images .current a').each(function (index){
        if (!$(this).hasClass("posting-image-link"))
            $(this).addClass("posting-image-link");
    });
    $("#searchContentDiv .listing .description .images .current .posting-image-link").colorbox({
        rel:'.posting-image-link', 
        transition:"none", 
        width:"990px", 
        height:"90%",
        initialWidth:"980px", 
        initialHeight:"85%",
        fixed:'true',
        iframe:false,
        current: "Posting {current} of {total}",
        onComplete:function(){
            $('#cboxLoadedContent #listing-title-link').show();
            $('#cboxLoadedContent #listing-title-span').hide();
            $('#cboxLoadedContent #thumbs').jcarousel({       
                });
       
            $('#cboxLoadedContent .thumbs .thumb').click(function(){
                $('#cboxLoadedContent .thumbs .selected').removeClass('selected');
                $(this).addClass('selected');
                $('#cboxLoadedContent .images .current').removeClass('current');
                $('#cboxLoadedContent .images > .image').eq($(this).index()).addClass('current');
            });
            $("#cboxLoadedContent .listing .image").colorbox({
                rel:'image', 
                transition:"none", 
                width:"75%", 
                height:"75%", 
                fixed:'true'
            });
              
        }
    });
                
    $('#searchContentDiv').find('.listing-title a').each(function (index){
              
        if (!$(this).hasClass("posting-link"))
            $(this).addClass("posting-link");
    });
    $("#searchContentDiv .listing .description .listing-title .posting-link").colorbox({
        rel:'.posting-link', 
        transition:"none", 
        width:"990px", 
        height:"90%",
        initialWidth:"980px", 
        initialHeight:"85%",
        fixed:'true',
        iframe:false,
        current: "Posting {current} of {total}",
        onComplete:function(){
            $('#cboxLoadedContent #listing-title-link').show();
            $('#cboxLoadedContent #listing-title-span').hide();
            $('#cboxLoadedContent #thumbs').jcarousel({       
                });
       
            $('#cboxLoadedContent .thumbs .thumb').click(function(){
                $('#cboxLoadedContent .thumbs .selected').removeClass('selected');
                $(this).addClass('selected');
                $('#cboxLoadedContent .images .current').removeClass('current');
                $('#cboxLoadedContent .images > .image').eq($(this).index()).addClass('current');
            });
            $("#cboxLoadedContent .listing .image").colorbox({
                rel:'image', 
                transition:"none", 
                width:"75%", 
                height:"75%", 
                fixed:'true'
            });
              
        }
    });
                
}

function populateSortBy(selectedValue)
{
    $('#search_select').empty();
    var optionTextHL = 'Post date (Recent to Oldest)';
    var optionValueHL = 'posting_date_dt desc';
    var optionTextLH = 'Post date (Oldest to Recent)';
    var optionValueLH = 'posting_date_dt asc';                               
    $('#search_select').append('<option value="' + optionValueHL +'">' + optionTextHL +'</option>');
    $('#search_select').append('<option value="' + optionValueLH +'">' + optionTextLH +'</option>');
     
    optionTextHL = 'Updated date (Recent to Oldest)';
    optionValueHL = 'date_updated_dt desc';
    optionTextLH = 'Updated date (Oldest to Recent)';
    optionValueLH = 'date_updated_dt asc';                               
    $('#search_select').append('<option value="' + optionValueHL +'">' + optionTextHL +'</option>');
    $('#search_select').append('<option value="' + optionValueLH +'">' + optionTextLH +'</option>');
    
    //Update sort dropdown
    var emphasized_hidden = $('#emphasized_hidden').val();
    if (emphasized_hidden != undefined && emphasized_hidden != "")
    {
        optionTextHL = emphasized_hidden.split('|')[0] + ' (Highest to Lowest)';
        optionValueHL = emphasized_hidden.split('|')[1] + ' desc';
        optionTextLH = emphasized_hidden.split('|')[0] + ' (Lowest to Highest)';
        optionValueLH = emphasized_hidden.split('|')[1] + ' asc';                               
        if ($("#search_select option[value='" + optionValueHL + "']").length == 0)
            $('#search_select').append('<option value="' + optionValueHL +'">' + optionTextHL +'</option>');
        if ($("#search_select option[value='" + optionValueLH + "']").length == 0)
            $('#search_select').append('<option value="' + optionValueLH +'">' + optionTextLH +'</option>');
    }
    $('#search_select option[value="' + selectedValue +'"]').attr("selected", "selected");

}
function searchByShortlistId(shortlistId)
{
    $('#searchContentDiv').empty();
    $('div#first_post_loader').show();
    $('div#first_post_loader').mask('Loading Favorite List...');
    var sort = getSortType();  
    $.ajax({
        global:false,
        type: "GET",
        url: "/search/searchbyshortlist/",
        data:"shortlistId=" + shortlistId + '&sort=' + sort ,        
        success: function(listingResponse){
            if (listingResponse != "")
            {
                var numFound;
                var searchResult;
                numFound = listingResponse.split('<SolrNoFound>')[1];
                searchResult =listingResponse.split('<SolrNoFound>')[0];
                if (parseInt(numFound) > 0)
                {
                    $('#search_count_display').show();
                    $('#search_count_display').html('Showing 1-' + numFound + ' of ' + numFound);                       
                    $(searchResult).appendTo($('#searchContentDiv'));
                    ApplyColorBox();
                    $('#widget-shortlists .expand').click();
                }
                else
                {
                    $('#search_count_display').hide();
                    searchResult = '<a><div class="empty-search"></div></a>';
                    $(searchResult).appendTo($('#searchContentDiv'));
                }
            }
            else
            {
                $('#search_count_display').hide();
                searchResult = '<a><div class="empty-search"></div></a>';
                $(searchResult).appendTo($('#searchContentDiv')); 
            }
            $('div#first_post_loader').hide();
             $('div#first_post_loader').unmask();
        },
        error:function (xhr, ajaxOptions, thrownError, request, error){
            if(xhr.readyState == 0 || xhr.status == 0)
                return;  // it's not really an error
            else
            {

            }
        }
    })
}

function ApplyDatePicker()
{
    $('#leftNavForm .datepicker').datepicker({
        dateFormat: dateformat,
        onClose: function(date) {

            var solrColName = "";
            var updateSearchResult = 'false';
           
            if ($(this).attr('id').indexOf('fromDate') != -1)
            {
                solrColName = $(this).attr('id').split('_range_fromDate')[0];
                var toDate = $('#' + $(this).attr('id').replace('fromDate','toDate')).val();               
                var minValue = $(this).val();
                if (minValue.length > 0)
                {
                    minValue = $.datepicker.parseDate(dateformat, minValue);
                    minValue.setDate(minValue.getDate());
                    $('#' + $(this).attr('id').replace('fromDate','toDate')).datepicker( "option", "minDate", minValue );
                }
                if (toDate != "To" && toDate.length > 0)
                    updateSearchResult = 'true';

            }
            if ($(this).attr('id').indexOf('toDate') != -1)
            {
                solrColName = $(this).attr('id').split('_range_toDate')[0];
                var fromDate = $('#' + $(this).attr('id').replace('toDate','fromDate')).val();
                var maxValue = $(this).val();
                if (maxValue.length > 0)
                {
                    maxValue = $.datepicker.parseDate(dateformat, maxValue);
                    maxValue.setDate(maxValue.getDate());
                    $('#' + $(this).attr('id').replace('toDate','fromDate')).datepicker( "option", "maxDate", maxValue );
                }
                if (fromDate !="From" && fromDate.length > 0)
                    updateSearchResult = 'true';
            }
            if (updateSearchResult == 'true')
            {
                $('#startRowIndex').val('0');
                //$('#searchContentDiv').empty();
                $('#' + solrColName + '_rangeclear').show();
                updateSearch('false',"");
            }
        }

    });
}

function ApplySlider()
{
    $('#leftNavForm').find('.slider-range').each(function (index){
        var minValue =  $( "#" + $(this).attr('id') + '_min' ).html();
        var maxValue = $( "#" + $(this).attr('id') + '_max' ).html();
        var allminValue = $( "#" + $(this).attr('id') + '_all_min' ).val();
        var allmaxValue = $( "#" + $(this).attr('id') + '_all_max' ).val();
            
        var intMinValue = parseInt(minValue.replace(/[^0-9\.]+/g,""));
        var intmaxValue = parseInt(maxValue.replace(/[^0-9\.]+/g,""));
        var intAllminValue = parseInt(allminValue.replace(/[^0-9\.]+/g,""));
        var intAllmaxValue = parseInt(allmaxValue.replace(/[^0-9\.]+/g,""));
            
        var rangeIncrement = parseInt($( "#" + $(this).attr('id') + '_range_increment' ).val());
            
        $(this).slider({
            range: true,
            step: rangeIncrement,
            min: intAllminValue,
            max: intAllmaxValue,
            values: [ parseInt(intMinValue), parseInt(intmaxValue) ],
            slide: function( event, ui ) {
                var isCurrency = parseInt($( "#" + $(this).attr('id') + '_is_currency' ).val());
                if (isCurrency == 1)
                {
                    $( "#" + $(this).attr('id') + '_min' ).html(accounting.formatMoney(ui.values[ 0 ]));
                    $( "#" + $(this).attr('id') + '_max' ).html(accounting.formatMoney(ui.values[ 1 ]));  
                }
                else
                {
                    $( "#" + $(this).attr('id') + '_min' ).html(ui.values[ 0 ]);
                    $( "#" + $(this).attr('id') + '_max' ).html(ui.values[ 1 ]);  
                }

            },
            change: function(event, ui) {
                var solrColumnName = $(this).attr('id').split('_slider_range')[0];
                var sectionNotToBeRefreshed = solrColumnName + "_range_section";
                $('#startRowIndex').val('0');
                //$('#searchContentDiv').empty();
                updateSearch('true',sectionNotToBeRefreshed);
            }
        });

    });
}

function getRangeFields()   {
    var solrColNameValueC = "";
    var solrColumnName = "";
    var solrColNameValue = "";

    var rangeFields = "";
    var rangeFieldsArray ="";

    rangeFields = $('#range_fields_hidden').val();
    if (rangeFields != undefined && rangeFields != "")
    {
        rangeFieldsArray = rangeFields.split(',');
        for (var i = 0; i < rangeFieldsArray.length ; i++)
        {           
            if (!rangeFieldsArray[i].match('.*_tdt$'))
            {
                solrColNameValue = ""

                var minField = $.trim($('#' + rangeFieldsArray[i] + "_slider_range_min").html());
                var maxField = $.trim($('#' + rangeFieldsArray[i] + "_slider_range_max").html());
                var allMinField = $.trim($('#' + rangeFieldsArray[i] + "_slider_range_all_min").val());
                var allMaxField = $.trim($('#' + rangeFieldsArray[i] + "_slider_range_all_max").val());
                var  isCurrency = $.trim($('#' + rangeFieldsArray[i] + "_slider_range_is_currency").val());
                if (minField != allMinField || maxField != allMaxField )
                {
                    solrColumnName = rangeFieldsArray[i];
                    if (parseInt(isCurrency) == 1)
                        solrColNameValue = solrColumnName + ':[' + parseInt(minField.replace(/[^0-9\.]+/g,"")) + ' TO ' + parseInt(maxField.replace(/[^0-9\.]+/g,"")) + ']' ;
                    else
                        solrColNameValue = solrColumnName + ':[' + minField + ' TO ' + maxField + ']' ;
                       
                    if (solrColNameValue != "")
                    {

                        if (solrColNameValueC == "")
                            solrColNameValueC  = solrColNameValue
                        else
                            solrColNameValueC = solrColNameValueC + " AND " + solrColNameValue;
                    }
                }
            }
        }
    }
    return solrColNameValueC
}

function getDateFields()   {
    var solrColNameValueC = "";
    var solrColumnName = "";
    var solrColNameValue = "";

    var rangeFields = "";
    var rangeFieldsArray ="";

    rangeFields = $('#range_fields_hidden').val();
    if (rangeFields != undefined && rangeFields != "")
    {

        rangeFieldsArray = rangeFields.split(',');
        for (var i = 0; i < rangeFieldsArray.length ; i++)
        {
            if (rangeFieldsArray[i].match('.*_tdt$'))
            {
                solrColNameValue = ""
                var from ="";
                var to ="";
                var fromField = $.trim($('#' + rangeFieldsArray[i] + "_range_fromDate").val());
                var toField = $.trim($('#' + rangeFieldsArray[i] + "_range_toDate").val());

                if (fromField != "From" && fromField.length > 0)
                    from = fromField;
                if (toField != "To" && toField.length > 0)
                    to = toField;
                if ((from != "" && to != "To") && (from != "From" && to !="" ))
                {
                    solrColumnName = rangeFieldsArray[i];
                    solrColNameValue = solrColumnName + ':' + from + ',' + to  ;

                }
                if (solrColNameValue != "")
                {

                    if (solrColNameValueC == "")
                        solrColNameValueC  = solrColNameValue
                    else
                        solrColNameValueC = solrColNameValueC + " AND " + solrColNameValue;
                }
            }
        }
    }
    return solrColNameValueC
}    
   
function getMultiSelectFields()   {
    var solrColNameValueC = "";
    var solrColumnName = "";
    var solrColNameValue = "";
    var solrColNameValues = "";
    var multiselectFields = "";
    var multiselectFieldArray ="";

    multiselectFields = $('#multiselect_fields_hidden').val();
    if (multiselectFields != undefined)
    {
        multiselectFieldArray = multiselectFields.split(',');
        for (var i = 0; i < multiselectFieldArray.length ; i++)
        {
            solrColNameValues = ""
            $('#' + multiselectFieldArray[i] + '_clear').hide();
            $('#' + multiselectFieldArray[i] + '_section').find('a.check').each(function (index){
                solrColumnName = $(this).attr('id').split('#')[0];
                if (solrColumnName != "parent_category_name_t" && solrColumnName != "category_name_t" )
                {
                    if ($(this).hasClass('selected') || $(this).hasClass('disabled'))
                    {
                        $('#' + multiselectFieldArray[i] + '_clear').show();
                        var solrColumnValue = $.trim($(this).html().split("(")[0]);
                        if (solrColumnValue == "")
                            solrColumnValue = $(this).html();
                        if (solrColumnName.match('.*_t$') || solrColumnName.match('.*_tc$'))
                            solrColNameValue = '"' + $.trim(solrColumnValue) + '"';
                        else
                            solrColNameValue =  $.trim(solrColumnValue);
                        if (solrColNameValues == "")
                            solrColNameValues =  solrColNameValue;
                        else
                        {

                            if (solrColumnName.match('.*_tc$'))
                                solrColNameValues = solrColNameValues + " AND " + solrColNameValue;
                            else
                                solrColNameValues = solrColNameValues + " OR " + solrColNameValue;
                        }
                    }
                }
            });
            if (solrColNameValues != "")
            {
                solrColNameValues = solrColumnName + ":(" + solrColNameValues + ")";
                if (solrColNameValueC == "")
                    solrColNameValueC  = solrColNameValues
                else
                    solrColNameValueC = solrColNameValueC + " AND " + solrColNameValues;
            }
        }
    }

    return solrColNameValueC;
}

function getCategoryMultiSelectFields()   {
    var catValues = "";
    $('#leftNavForm').find('a.check').each(function (index){
        var solrColumnName = $(this).attr('id').split('#')[0];

        if (solrColumnName == "parent_category_name_t" || solrColumnName == "category_name_t" )
        {
            $('#' + solrColumnName + '_clear').hide();
            if ($(this).hasClass('selected'))
            {
                $('#' + solrColumnName + '_clear').show();
                var solrColumnValue = $.trim($(this).html().split("(")[0]);
                if (catValues == "")
                    catValues =  solrColumnName + ':(' + '"'+ solrColumnValue + '"';
                else
                    catValues = catValues + " OR "  + '"'+ solrColumnValue + '"';
            }
        }
    });
    if (catValues != "")
        catValues = catValues + ")";
    return catValues;
}

function getCategorySelectFields()   {
    var catValues = "";
    $('#leftNavForm').find('.link').each(function (index){
        var solrColumnName = $(this).attr('id').split('#')[0];
        if (solrColumnName == "parent_category_name_t" || solrColumnName == "category_name_t" )
        {
            if ($(this).hasClass('selected'))
            {
                if ($(this).html() != "All Categories")
                {
                    var solrColumnValue = $.trim($(this).html().split("(")[0]);
                    if (solrColumnValue == "")
                        solrColumnValue = $(this).html();
                    if (catValues == "")
                        catValues =  solrColumnName + ':' + '"' + solrColumnValue + '"';
                    else
                        catValues = catValues + " OR " + solrColumnName + ':' + '"' + solrColumnValue + '"';
                }
            }
        }
    });

    return catValues;
}

function getSelectFields()   {
    var solrColNameValueC = "";
    var solrColumnName = "";
    var solrColNameValue = "";
    var solrColNameValues = "";


    var selectFields = $('#select_fields_hidden').val();
    if (selectFields != undefined)
    {
        var selectFieldArray = selectFields.split(',');
        for (var i = 0; i < selectFieldArray.length ; i++)
        {
            solrColNameValues = ""
            $('#' + selectFieldArray[i] + '_section').find('a.link').each(function (index){
                solrColumnName = $(this).attr('id').split('#')[0];
                if (solrColumnName != "parent_category_name_t" && solrColumnName != "category_name_t" )
                {
                    if ($(this).hasClass('selected'))
                    {

                        var solrColumnValue = $.trim($(this).html().split("(")[0]);
                        if (solrColumnValue == "")
                            solrColumnValue = $(this).html();
                        if (solrColumnName.match('.*_t$') || solrColumnName.match('.*_tc$'))
                            solrColNameValue = '"' + $.trim(solrColumnValue) + '"';
                        else
                            solrColNameValue = $.trim(solrColumnValue);
                        if (solrColNameValues == "")
                            solrColNameValues =  solrColNameValue;
                        else
                            solrColNameValues = solrColNameValues + " OR " + solrColNameValue;
                    }
                }
            });
            if (solrColNameValues != "")
            {
                solrColNameValues =solrColumnName + ":(" + solrColNameValues + ")";
                if (solrColNameValueC == "")
                    solrColNameValueC  = solrColNameValues
                else
                    solrColNameValueC = solrColNameValueC + " AND " + solrColNameValues;
            }
        }
    }

    return solrColNameValueC;
}
function getSortType()   {
    var sortType = "";
    sortType = $("select[id='search_select'] option:selected").val();

    return sortType;

}

$('#leftNavForm a.check').live("click", function(){

    if ($(this).hasClass('disabled'))
        return false;
    if ($(this).hasClass('selected')){
        $(this).removeClass('selected');
        $(this).addClass('unselected');
    }else{
        $(this).addClass('selected');
        $(this).removeClass('unselected');
               
    } 
    var solrColumnName = $(this).attr('id').split('#')[0];
    var refreshSection = 'false';
    var sectionNotToBeRefreshed = solrColumnName + "_section";
    $('div#first_post_loader').show();
    $('#startRowIndex').val('0');
    //$('#searchContentDiv').empty();
    $('#' + sectionNotToBeRefreshed).find('a.check').each(function (index){
        if ($(this).hasClass('selected'))
            refreshSection = "true";
    });
    isSelected = true;
    if (solrColumnName.match('.*_tc$'))
        updateSearch('true',"");
    else
    {
        if (refreshSection == 'true')
            updateSearch('true',sectionNotToBeRefreshed);
        else
            updateSearch('true',"");
    }
      
});


$('#leftNavForm a.clear').live("click", function(){
    if ($(this).attr('id') == "left_nav_clear_all")
    {
        clearAll();
    }
    else
    {
        //$('#searchContentDiv').empty();
        $('#startRowIndex').val('0');
        var refreshSection = 'false';
        var solrColumnName = "";
        if ($(this).attr('id').indexOf('_clear') != -1)
        {

            solrColumnName = $(this).attr('id').split('_clear')[0];
            $('#' + solrColumnName + '_section').find('a.check').each(function (index){

                if ($(this).hasClass('selected'))
                {
                    $(this).addClass('unselected');
                    $(this).removeClass('selected');
                }
                if ($(this).hasClass('disabled'))
                {
                    $(this).addClass('unselected');
                    $(this).removeClass('disabled');
                }

            });
            $('#' + solrColumnName + '_section').find('a.link').each(function (index){
                if ($(this).hasClass('selected'))
                {
                    $(this).removeClass('selected');
                    $(this).addClass('unselected');
                }
            });



            var sectionNotToBeRefreshed = solrColumnName + "_section";
            $('#' + sectionNotToBeRefreshed).find('a.selected').each(function (index){
                refreshSection = "true";
            });
            if (refreshSection == "true")
                updateSearch('true',sectionNotToBeRefreshed);
            else
                updateSearch('true',"");


        } else if ($(this).attr('id').indexOf('_rangeclear') != -1)
{
   
            if ($(this).attr('id').match('.*_tdt.*'))
            {
                solrColumnName = $(this).attr('id').split('_rangeclear')[0];
                $('#' + solrColumnName + '_range_fromDate').val('');
                $('#' + solrColumnName + '_range_toDate').val('');
                updateSearch('true',"");
            }
            else
            {
                solrColumnName = $(this).attr('id').split('_rangeclear')[0];
                $('#' + solrColumnName + '_slider_range_min').html($('#' + solrColumnName + '_slider_range_all_min').val());
                $('#' + solrColumnName + '_slider_range_max').html($('#' + solrColumnName + '_slider_range_all_max').val());
                updateSearch('true',"");
            }
        }
    }

});

function clearAll() {
    //$('#searchContentDiv').empty();
    $('#startRowIndex').val('0');
       
    var solrColumnName = "";       
    $('#leftNavForm').find('a.check').each(function (index){
        if ($(this).hasClass('selected'))
        {
            $(this).addClass('unselected');
            $(this).removeClass('selected');
        }
        if ($(this).hasClass('disabled'))
        {
            $(this).addClass('unselected');
            $(this).removeClass('disabled');
        } 
    });
    $('#leftNavForm').find('a.link').each(function (index){
        if ($(this).hasClass('selected'))
        {
            $(this).removeClass('selected');
            $(this).addClass('unselected');
        }
    });
    $('#leftNavForm').find('input').each(function (index){
        if ($(this).attr('id').indexOf('_range_fromDate') != -1)
        {
            $(this).val('');
        }
        if ($(this).attr('id').indexOf('_range_toDate') != -1)
        {
            $(this).val('');
        }          
    });
    $('#leftNavForm').find('.min-max').each(function (index){
        if ($(this).attr('id').indexOf('_slider_range_min') != -1)
        {
            solrColumnName = $(this).attr('id').split('_slider_range_min')[0];            
            $(this).html($('#' + solrColumnName + '_slider_range_all_min').val());
        }
        else if  ($(this).attr('id').indexOf('_slider_range_max') != -1)
        {
            solrColumnName = $(this).attr('id').split('_slider_range_max')[0];            
            $(this).html($('#' + solrColumnName + '_slider_range_all_max').val());
        }
    });

    updateSearch('true',"");       

};

$('#leftNavForm a.link').live("click", function(){
    if ($(this).hasClass('selected')){
        $(this).removeClass('selected');
    }else{
        $(this).addClass('selected');
    }
    var refreshSection = 'false';
    //$('#searchContentDiv').empty();
    $('div#first_post_loader').show();
    $('#startRowIndex').val('0');
    var solrColumnName = $(this).attr('id').split('#')[0];

    var sectionNotToBeRefreshed = solrColumnName + "_section";
    $('#startRowIndex').val('0');
    //$('#searchContentDiv').empty();
    $('#' + sectionNotToBeRefreshed).find('a.selected').each(function (index){
        refreshSection = "true";
    });
    isSelected = true;
    
    if (refreshSection == "true")
        updateSearch('true',sectionNotToBeRefreshed);
    else
        updateSearch('true',"");
});

$("#leftNavForm input").live("focus", function(){
    if($(this).val() === $(this).attr('title')) {
        $(this).val('').removeClass('example');
    }

});

$("#search_select").live("change", function(){
    $('#startRowIndex').val('0');
    $('#searchContentDiv').empty();
    if ($('#searchBy').val() == 'shortlist' && $('#search_by_shortlistId').val() != "")       
        searchByShortlistId($('#search_by_shortlistId').val())       
    else
        updateSearch('false',"");
});

function LoadUserSavedSearches()
{
    
    $.ajax({
        type: "GET",
        url: "/search/getusersavedsearches/",        
        success: function(data){
            if (data != "")
            {
                $("#widget-savedsearches").empty();
                $(data).appendTo($("#widget-savedsearches"))
               
            }           
        }
    });
}

function LoadUserShortlists()
{
    
    $.ajax({
        type: "GET",
        url: "/search/getusershortlists/",        
        success: function(data){
            if (data != "")
            {
                $("#widget-shortlists").empty();
                $(data).appendTo($("#widget-shortlists"))
               
            }           
        }
    });
}

function saveSearch(savedSearchName)
{
    $("#saved_search_error").hide();
    $.ajax({
        type: "GET",
        url: "/search/save/",
        data: "savedSearchName=" + savedSearchName,
        success: function(data){
            if (data != "")
            {
                $("#widget-savedsearches").empty();
                $(data).appendTo($("#widget-savedsearches"))
                $("#dialogSaveSearch").dialog("close");
                $('#widget-savedsearches .expand').click();
            }
            else
            {
                $("#saved_search_error").show();
            }
        }
    });
}

function deleteSearch(listObj)
{

    var searchId = $(listObj).attr('id').split('_')[1];
    $.ajax({
        type: "GET",
        url: "/search/delete/",
        data: "savedSearchId=" + searchId
    });
    $(listObj).parent().slideUp(0, function(){
        $(listObj).remove();

    });
    if ($(listObj).parent()[0].tagName == 'H2'){
        $(listObj).parent().next().slideUp(0, function(){
            $(listObj).remove();
        });
    }
    $("#searchToBeDeleted").val('');
}
    
function saveShortlist(shortlistName)
{
    $("#short_list_error").hide();
    $.ajax({
        type: "GET",
        url: "/search/saveshortlist/",
        data: "shortlistName=" + shortlistName,
        dateType:'json',
        success: function(data){
            
            if (data != "")
            {
                var shortListHtml = data.split('<LastShortListId>')[0];
                var shortListId = data.split('<LastShortListId>')[1];
                var postingId = $('#short_list_posting_id').val();
                $('#short_list_posting_id').val('');
                if ($("#widget-shortlists"))
                {
                    $("#widget-shortlists").empty();
                    $(shortListHtml).appendTo($("#widget-shortlists"))
                }
                $("#dialogShortlist").dialog("close");
               
                if (postingId != undefined && postingId != '')
                {
                    manageShortlist(shortListId,postingId,'Add');
                    if ($("#preview_post_listing")) 
                        getShortlistsFromDB(postingId);
                }
            }
            else
            {
                $("#short_list_error").show();
            }
        }
    });
}

function deleteShortlist(listObj)
{

    var shortlistId = $(listObj).attr('id').split('_')[1];
    $.ajax({
        type: "GET",
        url: "/search/deleteshortlist/",
        data: "shortlistId=" + shortlistId,
        success: function(data){
            $('#searchContentDiv').find('.favorite').each(function (index){
                var postingId = $(this).attr('id').replace('favorite_','').trim();
                var favorite_list = $('#favorite_list_' + postingId).val();
                if (favorite_list == shortlistId)
                {
                    $('#favorite_list_' + postingId).val('');
                    if ($(this).hasClass('selected'))
                        $(this).removeClass('selected');
                }
            })
        }
    });
    $(listObj).parent().slideUp(0, function(){
        $(this).remove();

    });
    
    $("#shortlistToBeDeleted").val('');
}

function manageShortlist(shortlistId,postingId,shortlistaction)
{
    
    $.ajax({
        type: "GET",
        url: "/search/manageshortlist/",
        data: "shortlistId=" + shortlistId + "&postingId=" + postingId + "&shortlistaction=" + shortlistaction,
        success: function(data){
            $('#favorite_list_' + postingId).val(data);
            if (data != "")
                if (!($('#favorite_' + postingId).hasClass('selected')))
                    $('#favorite_' + postingId).addClass('selected')
        }
    });
}

function flagPostAsSpam(postingId,flagaction)
{
    if ($('.search #spam_' + postingId).hasClass('selected'))
    {
        $('.search #spam_' + postingId).removeClass('selected');
       
    }
    else
    {
        $('.search #spam_' + postingId).addClass('selected');
        
    }
     
    if ($('#preview_post_listing #spam_' + postingId).hasClass('selected'))
    {
        $('#preview_post_listing #spam_' + postingId).removeClass('selected');
       
    }
    else
    {
        $('#preview_post_listing #spam_' + postingId).addClass('selected');
        
    }
    $.ajax({
        type: "GET",
        url: "/search/flagspam/",
        data: "postingId=" + postingId + "&flagaction=" + flagaction,
        success:function(data){
         
          
        }
    });
}
function saveViewShareEmail(postingId,userAction)
{
    
    $.ajax({
        type: "GET",
        url: "/search/viewshareemail/",
        data: "postingId=" + postingId + "&userAction=" + userAction
    });
}

$('.add-shortlist-section a.check').live("click", function(){
    
    var postingId = $(this).attr('id').split('add-remove-shortlist')[0];
    var shortlistId = $(this).attr('id').split('add-remove-shortlist')[1];
    var shortlistaction = "Add";
    if ($(this).hasClass('selected')){
        shortlistaction = "Remove";
        $(this).removeClass('selected');
        $(this).addClass('unselected');
    }else{
        shortlistaction = "Add";
        $(this).addClass('selected');
        $(this).removeClass('unselected');
               
    } 
   
    var is_favorite = false;
   
    $(this).closest('ul').find('a.selected').each(function (index){
        is_favorite = true;
        
    })
    if (is_favorite)
    {
        if (!$('.search #favorite_' + postingId).hasClass('selected'))
            $('.search #favorite_' + postingId).addClass('selected')
        if (!$('#preview_post_listing #favorite_' + postingId).hasClass('selected'))
            $('#preview_post_listing #favorite_' + postingId).addClass('selected')
    }
    else
    {
        if ($('.search #favorite_' + postingId).hasClass('selected'))
            $('.search #favorite_' + postingId).removeClass('selected') 
        if ($('#preview_post_listing #favorite_' + postingId).hasClass('selected'))
            $('#preview_post_listing #favorite_' + postingId).removeClass('selected') 
    }
    
    manageShortlist(shortlistId,postingId,shortlistaction);
})
function ApplyDialog()
{
    $("#dialogCategoryHelp" ).dialog({
        draggable: false,
        autoOpen:false,
        dialogClass: 'left notitle',
        resizable: false,
        title: '',
        //show: "blind",
        //        hide: {effect: "fadeOut", duration: 2000},
        //        show: {effect: "fadeIn", duration: 2000},
        buttons: [
        {
            text: "Ok",
            click: function() {
                $(this).dialog("close");
            },
            className: "button medium primary"
        }
        ]
    });
    $("#dialogDeleteSavedSearch").dialog({
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
                $("#searchToBeDeleted").val('');
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
                $(this).dialog("close");
                if ($("#searchToBeDeleted") && $("#searchToBeDeleted").val() != "")
                    deleteSearch("#widget-savedsearches #" + $("#searchToBeDeleted").val());
            }

        }

        ]
    });
    $("#dialogSaveSearch").dialog({
        autoOpen:false,
        draggable: false,
        dialogClass: 'left notitle',
        resizable: false,
        modal: true,
        width: 250,
        buttons: [
        {
            text: "Cancel",
            click: function() {
                $(this).dialog("close");
            },
            className: "button medium primary"
        },
        {
            text: "Save",
            create: function(event, ui) {
                $(this).addClass("save button medium primary");
            },
            click: function() {
                var validateForm =  $("#saved_search_form").validate({
                    rules: {
                        saved_search_name: "required"
                    },
                    messages: {
                        saved_search_name:"Please name the saved search."
                    }
                });

                var isSavedSearchNameValid = validateForm.element("#saved_search_name");
                if (isSavedSearchNameValid)
                {
                    saveSearch($("#saved_search_name").val());

                }
            }
        }
        ]
    });

    
    $("#dialogDeleteShortlist").dialog({
        autoOpen:false,
        draggable: false,
        resizable: false,
        modal: true,
        dialogClass: 'left notitle',
        width: 250,
        open: function(event, ui) {          
            $('#dialogDeleteShortlist .delete').focus();           
        },
        buttons: [

        {
            text: "Cancel",

            click: function() {
                $("#shortlistToBeDeleted").val('');
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
                $(this).dialog("close");
                if ($("#shortlistToBeDeleted") && $("#shortlistToBeDeleted").val() != "")
                    deleteShortlist("#widget-shortlists #" + $("#shortlistToBeDeleted").val());
            }

        }

        ]
    });
    ApplyShortListDialog();
}

function ApplyShortListDialog()
{
    $("#dialogShortlist").dialog({
        autoOpen:false,
        draggable: false,
        dialogClass: 'left notitle',
        resizable: false,
        modal: true,
        width: 250,
        buttons: [
        {
            text: "Cancel",
            click: function() {
                $(this).dialog("close");
                $('#short_list_posting_id').val('');
            },
            className: "cancel button medium primary"
        },
        {
            text: "Create",
            create: function(event, ui) {
                $(this).addClass("create button medium primary");
            },
            click: function() {
                var validateForm =  $("#short_list_form").validate({
                    rules: {
                        short_list_name: "required"
                    },
                    messages: {
                        short_list_name:"Please name the shortlist."
                    }
                });

                var isShortListNameValid = validateForm.element("#short_list_name");
                if (isShortListNameValid)
                {
                   
                    saveShortlist($("#short_list_name").val());

                }                   
            }
        }


        ]
    });
}

positionDialogs = function(event){

    if ($("#dialogCategoryHelp").length){
        $( "#dialogCategoryHelp" ).dialog('widget').position({
            my:"left top",
            at:"right top",
            of:".refine",
            offset: "-25 55"
        });
    }
    if ($("#dialogSaveSearch").length){
        $( "#dialogSaveSearch" ).dialog('widget').position({
            my:"left top",
            at:"right top",
            of:"#btnSaveSearch",
            offset: "15 -20"
        });
    }

    if ($("#dialogShortlist").length){
        $( "#dialogShortlist" ).dialog('widget').position({
            my:"left top",
            at:"right top",
            of:"#new-shortlist",
            offset: "15 -20"
        });
    }

}

$('#saved_search_form').live("keydown", function(e){

    var keyCode = e.keyCode || e.which;
    if(keyCode == 13){
        $('.ui-dialog-buttonset .save').click();
        e.preventDefault();
    }
});

$("#btnSaveSearch").live("click",function() {
    $("#saved_search_error").hide();
    $("#saved_search_name").val('');
    $.ajax({
        type: "GET",
        dataType:"json",
        url: "/user/checkloginstatus/",
        success: function(logStatus){

            if (logStatus.loggedInStatus == 1)
            {
                $("#dialogSaveSearch #saved_search_error").empty();
                $("#dialogSaveSearch").dialog("open");
                positionDialogs();
            }
            else
            {
                ResetDialogSignUp();
                $('#dialogSignUp #sign-up-page').val("saved-search-left-nav");
                $("#dialogSignUp").dialog("open");
            }
        }
    });


});   

function handleNewShortClick()
{
    $("#short_list_error").hide();
    $("#short_list_name").val('');
    $.ajax({
        type: "GET",
        dataType:"json",
        url: "/user/checkloginstatus/",
        success: function(logStatus){

            if (logStatus.loggedInStatus == 1)
            {
                $("#dialogShortlist #short_list_error").empty();
                $("#dialogShortlist").dialog("open");
              
                if ($('#short_list_posting_id').val() == '')
                {
                    
                   if ($("#dialogShortlist").length){
                        $( "#dialogShortlist" ).dialog('widget').position({
                            my:"left top",
                            at:"right top",
                            of: $('#new-shortlist'),
                            offset: "15 -20"
                        });
                    }
                }   
                else
                {
                    if ($("#dialogShortlist").length){
                        $( "#dialogShortlist" ).dialog('widget').position({
                            my:"left top",
                            at:"right top",
                            of: $('#favorite_' + $('#short_list_posting_id').val()),
                            offset: "15 -20"
                        });
                    }
                }
            }
            else
            {
                ResetDialogSignUp();
                $('#dialogSignUp #sign-up-page').val("short-list-left-nav");
                $("#dialogSignUp").dialog("open");
            }
        }
    });

}
    
$(".create-new-shortlist").live("click",function(ev) {
    $('#short_list_posting_id').val($(this).attr('id').replace('create_new_shortlist_',''));
    ApplyShortListDialog();    
    handleNewShortClick();
});
$("#new-shortlist").live("click",function() {
     ApplyShortListDialog();
    handleNewShortClick();
});

$("#lineView").live("click", function(){
    $('div#last_post_loader').show();
    window.onscroll = scroll;
    $('#last_post_loader').show();
    TrackPageView('/search-list');   
    $('#mapContentDiv').hide();
    $('#searchContentDiv').show();
    $('#gridView').removeClass('selected');
    $(this).addClass('selected');
    $('.items').removeClass('grid').addClass('lines');
    $('.map-show-more').hide();
});
$("#gridView").live("click", function(){
    $('div#last_post_loader').show();
    window.onscroll = scroll;
    $('#last_post_loader').show();
    TrackPageView('/search-grid');
    $('#mapContentDiv').hide();
    $('#searchContentDiv').show();
    $('#lineView').removeClass('selected');
    $(this).addClass('selected');
    $('.items').removeClass('lines').addClass('grid');
    $('.map-show-more').hide();
});
$("#mapView").live("click", function(){
    $('div#last_post_loader').hide();
    window.onscroll = null;
    $('#last_post_loader').hide();
    TrackPageView('/search-map');
    $('#mapView').removeClass('selected');
    $(this).addClass('selected');
    $('#mapContentDiv').show();
    $('#searchContentDiv').hide();
    loadMapWithSpiderfier();
});

$(".map-icon").click(function(){
    $(this).parent().find('.location').toggle();
});
$(".search .listing").mouseenter(function(){
    $('.location').hide();
});
$(".more").live("click", function(e){
    $(this).prev('.moreitems').toggle();
    if($(this).html()=='See More...')$(this).html("See Less...");
    else $(this).html("See More...");
    e.preventDefault();
});

$('#breadcrumbs a.breadcrumb-link').live("click", function(e){
      
    $('#startRowIndex').val('0');
    //$('#leftNavForm').empty();
    var categoryName = $(this).html();
    var categoryId = $(this).attr('id').replace('breadcrumbs_','').trim();
    $('#searchform a.select-category').html(categoryName);
    $('#selected_category_hidden').val(categoryId);
    $('#main').load('/search/index/', function() {
        //$('#searchContentDiv').empty();
        isLinkClicked = true;
        $('#startRowIndex').val('0');
        updateSearch('true','');
    });
   
    e.preventDefault();
});
$('#breadcrumbs a.breadcrumb-link-with-href').live("click", function(e){
    var categoryName = $(this).html();     
    $('#searchform a.select-category').html(categoryName);
      
    $('#category-finder-search-home').find('a').each(function (index){
        if ($(this).html() == categoryName)
            $('#selected_category_hidden').val($(this).attr('id'));
    });
    $('#search_across_category').click();
    e.preventDefault();
});
$('.search .savedsearches .save-search-link').live("click", function(e){
    $('.savedsearches .save-search-link').removeClass('clicked');
   
    $('#widget-shortlists a.short-list-link').removeClass('clicked');
    $("#leftNavForm").show();
    if (!$(this).hasClass('clicked'))
        $(this).addClass('clicked');
    $(this).parent().find('input:hidden').each(function (index){
        var searchData =  $(this).val();
        var searchObj = eval('(' + searchData + ')');
        // $('#searchContentDiv').empty();
        $('#breadcrumbs-list').empty();
        $('#startRowIndex').val('0');
        $('#searchform a.select-category').html(searchObj.categoryName.replace('"','').replace('"',''));
        $("#search").val(searchObj.searchText);
        $('#category-finder-search-home').find('a').each(function (index){
            if ($(this).html() == searchObj.categoryName)
                $('#selected_category_hidden').val($(this).attr('id'));
        });
        window.onscroll = scroll;
        $('#first_post_loader').show();
        $('#first_post_loader').mask("Loading saved search..");
        search(searchObj.searchText,searchObj.categoryName,searchObj.isParentCategory,searchObj.sectionNotToBeRefreshed,searchObj.refreshRefineSection,
            searchObj.categoryFields,searchObj.selectedFields,searchObj.rangeFields,searchObj.dateFields,searchObj.multiSelectFields,searchObj.start,searchObj.sort)
        $('#widget-savedsearches .expand').click();
    });
    e.preventDefault();
});
$('.account .savedsearches .save-search-link').live("click", function(){
    
    var selectedSavedSearch = $(this).attr('id');
    
    $('#main').load('/search/index/', function() {
        $("#leftNavForm").show();
        $('#' + selectedSavedSearch).addClass('clicked');
        $('#' + selectedSavedSearch).parent().find('input:hidden').each(function (index){

            var searchData =   $(this).val();
            var searchObj = eval('(' + searchData + ')');
            // $('#searchContentDiv').empty();
            $('#breadcrumbs-list').empty();
            $('#startRowIndex').val('0');
            
            $('#searchform a.select-category').html(searchObj.categoryName.replace('"','').replace('"',''));
            $("#search").val(searchObj.searchText);
            $('#category-finder-search-home').find('a').each(function (index){
                if ($(this).html() == searchObj.categoryName)
                    $('#selected_category_hidden').val($(this).attr('id'));
            });
            window.onscroll = scroll;
            $('#first_post_loader').show();
            $('#first_post_loader').mask("Loading saved search..");
            $('#widget-savedsearches .expand').click();
            search(searchObj.searchText,searchObj.categoryName,searchObj.isParentCategory,searchObj.sectionNotToBeRefreshed,searchObj.refreshRefineSection,
                searchObj.categoryFields,searchObj.selectedFields,searchObj.rangeFields,searchObj.dateFields,searchObj.multiSelectFields,searchObj.start,searchObj.sort)
       
        });
    });


});

function getShortlistsFromDB(postingId)
{
     
    if (postingId != undefined)
    {
        $('#add_shortlist_section_' + postingId).remove();
        $.ajax({
            global:false,
            type: "GET",
            url: "/search/getshortlistsbyposting/",
            data:"postingId=" + postingId ,        
            success: function(response){
                if (response != "")
                {
                    $(response).appendTo($('#favorite_' + postingId).parent());              
                }           
            },
            error:function (xhr, ajaxOptions, thrownError, request, error){
                if(xhr.readyState == 0 || xhr.status == 0)
                    return;  // it's not really an error
                else
                {

                }
            }
        })  
    }
}

function loadShortlistsByPosting(postingId)
{
    if ($('#add_shortlist_section_' + postingId))
        $('#add_shortlist_section_' + postingId).remove();
    if ($('.marker-infowindow #add_shortlist_section_' + postingId))
        $('.marker-infowindow #add_shortlist_section_' + postingId).remove();
    var shortListId = "";
    var shortListName = "";
    var itemId = "";
    var favorite_list = null;    
    if ($('#favorite_list_' + postingId))
        favorite_list = $('#favorite_list_' + postingId).val().split('|');
   
    var shortListHtml = '<ul id="add_shortlist_section_' + postingId +'" class="pophint menu add-shortlist-section">';
    shortListHtml = shortListHtml + '<li class="title">Favorite</li>';
    $('#widget-shortlists ul > li').each(function (index) {
        shortListId = $(this).find(".short-list-link").attr('id').replace('short_list_link_','');
        shortListName = $(this).find(".short-list-link").html();
        itemId = postingId + "add-remove-shortlist" + shortListId;
        if (favorite_list != null && $.inArray(shortListId, favorite_list) != -1)
            shortListHtml = shortListHtml + '<li><a id="' + itemId + '" class="check selected">' + shortListName + '</a></li>';
        else
            shortListHtml = shortListHtml + '<li><a id="' + itemId + '" class="check unselected">' + shortListName + '</a></li>';
    })
    shortListHtml = shortListHtml + '<li><a style="padding-left:5px" id="create_new_shortlist_' + postingId + '" class="create-new-shortlist">Create New...</a></li>';
    shortListHtml = shortListHtml + '</ul>';
 
    $(shortListHtml).appendTo($('#favorite_' + postingId).parent());
    $(shortListHtml).appendTo($('.marker-infowindow #favorite_' + postingId).parent());
}

$('.spam').live("click", function(e){
    
    var postingId = $(this).attr('id').replace('spam_','').trim();
    var flagAction = 'Spam';
    if ($(this).hasClass('selected'))
    {
      
        flagAction = 'Remove';
    }
    else
    {
       
        flagAction = 'Spam';
    }
    
    $.ajax({
        type: "GET",
        dataType:"json",
        url: "/user/checkloginstatus/",
        success: function(logStatus){

            if (logStatus.loggedInStatus == 1)
            {
                
                flagPostAsSpam(postingId,flagAction);
            }
            else
            {
                ResetDialogSignUp();
                $('#spam_posting_id').val(postingId);
                $('#flag_span_action').val(flagAction);
                
                $('#dialogSignUp #sign-up-page').val("flag-post-spam");
                $("#dialogSignUp").dialog("open");
            }
        }
    });
   
});

//$('.favorite').live("mouseover", function(e){
//    if ($(this).next())
//        $(this).next().hide();
//})
//$('.favorite').live("mouseout", function(e){
//    if ($(this).next())
//        $(this).next().hide();
//})
//$('ul.pophint').live("mouseover", function(e){
//  $(this).show();
//})
//$('ul.pophint').live("mouseout", function(e){
//  $(this).hide();
//})
$('.search .favorite').live("mouseover", function(e){

    var postingId = $(this).attr('id').replace('favorite_','').trim();
    loadShortlistsByPosting(postingId);
});
$('#preview_post_listing .favorite').live("mouseover", function(e){
    if ($(this).next())
        $(this).next().show();
});
//$('.marker-infowindow .favorite').live("mouseover", function(e){
//    if ($(this).next())
//        $(this).next().show();
//});
$('.search #widget-shortlists a.short-list-link').live("click", function(e){
    $('.savedsearches .save-search-link').removeClass('clicked');
    $('#widget-shortlists a.short-list-link').removeClass('clicked');
  
    if (!$(this).hasClass('clicked'))
        $(this).addClass('clicked');
    var shortlistId = $(this).attr('id').replace('short_list_link_','').trim();
    if (shortlistId != undefined && shortlistId != null && shortlistId != "")
    {            
        if ($('#leftNavForm'))
            $('#leftNavForm').hide();
        
        window.onscroll = null;
        $('#breadcrumbs-list').empty();
        $('<li><a href="#page=home"></a></li>').appendTo('#breadcrumbs-list');
        $(' <li><a onclick="return false;">' + $(this).html() + '</a></li>').appendTo('#breadcrumbs-list');
        $('#searchBy').val('shortlist');
        $('#search_by_shortlistId').val(shortlistId);
        searchByShortlistId(shortlistId);
    }
    e.preventDefault();
});

$('.account #widget-shortlists a.short-list-link').live("click", function(){
    var shortlistId = $(this).attr('id').replace('short_list_link_','').trim();
   
    if (shortlistId != undefined && shortlistId != null && shortlistId != "")
    {  
        $('#main').load('/search/index/', function() {
            if ($('#leftNavForm'))
                $('#leftNavForm').hide();
           
            $('#searchContentDiv').empty();            
            $('#breadcrumbs-list').empty();
            $('<li><a href="#page=home"></a></li>').appendTo('#breadcrumbs-list');
            $(' <li><a onclick="return false;">' + $(this).html() + '</a></li>').appendTo('#breadcrumbs-list');

            window.onscroll = null;
            $('#searchBy').val('shortlist');
            $('#search_by_shortlistId').val(shortlistId);
            searchByShortlistId(shortlistId);
             $("#widget-shortlists #short_list_link_" + shortlistId).addClass('clicked');
        });
    }
   
});

$('#dialogDeleteSavedSearch').live("keydown", function(e){

    var keyCode = e.keyCode || e.which;
    if(keyCode == 13){         
        $('#dialogDeleteSavedSearch .ui-dialog-buttonset button.delete').click();
        e.preventDefault();
    }
});
$("#widget-savedsearches .delete").live("click", function(){
    $("#searchToBeDeleted").val($(this).attr('id'));
    if ($("#searchToBeDeleted").val() != "")
    {
        $("#dialogDeleteSavedSearch").dialog("open");
        if ($("#dialogDeleteSavedSearch").length){
            $( "#dialogDeleteSavedSearch" ).dialog('widget').position({
                my:"left top",
                at:"right top",
                of:"#" + $(this).attr('id'),
                offset: "15 -20"
            });
        }
    }
});
$("#widget-shortlists .delete").live("click", function(){
    $("#shortlistToBeDeleted").val($(this).attr('id'));
    if ($("#shortlistToBeDeleted").val() != "")
    {
        $("#dialogDeleteShortlist").dialog("open");
        if ($("#dialogDeleteShortlist").length){
            $( "#dialogDeleteShortlist" ).dialog('widget').position({
                my:"left top",
                at:"right top",
                of:"#" + $(this).attr('id'),
                offset: "15 -20"
            });
        }
    }
});


toggleSavedSearchesEdit = function(animate){
    if ($('#widget-savedsearches').hasClass('edit')){
        if (!animate) $(".savedsearches .delete").hide();
        else $(".savedsearches .delete").animate({
            width: 'toggle'
        }, 0);
        $('#widget-savedsearches').removeClass('edit');
        
        $("#widget-savedsearches .edit").html($("#widget-savedsearches .edit").html().replace('cancel','edit'));
        $("#widget-savedsearches .edit").attr('title','Edit Saved Searches');
    }else{
       
        if (!animate) $(".savedsearches .delete").show();
        else $(".savedsearches .delete").animate({
            width: 'toggle'
        }, 0);
        $('#widget-savedsearches').addClass('edit');
        $("#widget-savedsearches .edit").html($("#widget-savedsearches .edit").html().replace('edit','cancel'));
        $("#widget-savedsearches .edit").attr('title','Cancel Edit Action');
        $('#widget-savedsearches .expand').click();
    }
}


$('#widget-savedsearches .edit').live("click", function(){
    toggleSavedSearchesEdit(false);
});



toggleShortlistsEdit = function(animate){
    if ($('#widget-shortlists').hasClass('edit')){
        if (!animate) $(".shortlists .delete").hide();
        else $(".shortlists .delete").animate({
            width: 'toggle'
        }, 400);
        $('#widget-shortlists').removeClass('edit');
        $("#widget-shortlists .edit").html($("#widget-shortlists .edit").html().replace('cancel','edit'));
        $("#widget-shortlists .edit").attr('title','Edit Favorite List');
    }else{
        if (!animate) $(".shortlists .delete").show();
        else $(".shortlists .delete").animate({
            width: 'toggle'
        }, 400);
        $('#widget-shortlists').addClass('edit');
        $("#widget-shortlists .edit").html($("#widget-shortlists .edit").html().replace('edit','cancel'));
        $("#widget-shortlists .edit").attr('title','Cancel Edit Action');
        $('#widget-shortlists .expand').click();
    }
}

$('#widget-shortlists .edit').live("click", function(){
    toggleShortlistsEdit(false);
});


$("#searchform #search").live("keydown", function(event) {

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
function getSearchParameter( name,url ){
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");  
    var regexS = "[\\?&]"+name+"=([^&#]*)";  
    var regex = new RegExp( regexS );  
    var results = regex.exec( url ); 
    if( results == null )    return "";  
    else    return results[1];
}
$('.empty-search').live("click", function(event){  
    $('#select-category').html('All Categories');
    $('#selected_category_hidden').val('allcategories');
    window.location = "/#page=search&ref=sr_nofs&keyword=" + $.trim($("#search").val()) + "&categoryName=All Categories&refreshRefineSection=true";  

});
function searchByObject(searchObj)
{
    window.onscroll = scroll;
    if (searchObj.keyword == undefined)
        searchObj.keyword = "";
    if (searchObj.categoryName == undefined)
        searchObj.categoryName = "";
    if (searchObj.isParentCategory == undefined)
        searchObj.isParentCategory = "";
    if (searchObj.sectionNotToBeRefreshed == undefined)
        searchObj.sectionNotToBeRefreshed = "";
    if (searchObj.refreshRefineSection == undefined)
        searchObj.refreshRefineSection = "";
    if (searchObj.categoryFields == undefined)
        searchObj.categoryFields = "";
    if (searchObj.selectedFields == undefined)
        searchObj.selectedFields = "";
    if (searchObj.rangeFields == undefined)
        searchObj.rangeFields = "";
    if (searchObj.dateFields == undefined)
        searchObj.dateFields = "";
    if (searchObj.multiSelectFields == undefined)
        searchObj.multiSelectFields = "";
    if (searchObj.start == undefined)
        searchObj.start = "";
    if (searchObj.sort == undefined)
        searchObj.sort = "";
    $('#search').val(searchObj.keyword);   
   
    if (searchObj.categoryName != "")
    {
        if (isSelected)  
            isSelected = false;
        else
            searchObj.sectionNotToBeRefreshed = "";
        if (searchObj.ref == 'sr_nofs')
        {
           
            
           
            if (loadMessage.indexOf('Searching across') != -1)
            {
                    
                $('#last_post_loader').show();
                $('#first_post_loader').mask(loadMessage);
            }
            else
            {
                $('#first_post_loader').show();
                
                $('div#first_post_loader').mask('Searching across ' + searchObj.categoryName + '...');
            }
            //$('#searchContentDiv').empty();
            //$('#leftNavForm').empty();
            $('#breadcrumbs-list').empty();
            $('#startRowIndex').val('0');
            searchObj.refreshRefineSection = 'true';
            searchObj.start = 0;
        }
        else
        {        
            if (!isLoadMore)
            {
                // $('#searchContentDiv').empty();
                $('div#first_post_loader').mask("Applying your filter choices...");
            }
            isLoadMore = false;
        }
        search(searchObj.keyword,searchObj.categoryName,searchObj.isParentCategory,searchObj.sectionNotToBeRefreshed,searchObj.refreshRefineSection,
            searchObj.categoryFields,searchObj.selectedFields,searchObj.rangeFields,searchObj.dateFields,searchObj.multiSelectFields,searchObj.start,searchObj.sort);
          
        if ($("#userLoggedInFlag").val() == '1')
        {
            $.ajax({
                type: "GET",
                dataType:"json",
                url: "/user/checkloginstatus/",                       
                success: function(logStatus){
                    if (logStatus.loggedInStatus == 1) 
                    {
                        //Get User Shortlist       
                        LoadUserShortlists();
                        //Get user saved searches
                        LoadUserSavedSearches();
                    }
                }
            }) 
        }
        
    }
}
$('.marker-infowindow .prevPost').live("click", function(e){
  
    $(this).parent().parent().hide();
    $(this).parent().parent().prev().show();
    e.preventDefault();
});

$('.marker-infowindow .nextPost').live("click", function(e){

    $(this).parent().parent().hide();
  
    $(this).parent().parent().next().show();
    e.preventDefault();
});

$('.collapse').live("click", function(e){
    $(this).html($(this).html().replace('down','up'));
    $(this).removeClass('collapse');
    $(this).addClass('expand');
    $(this).parent().parent().parent().next().hide();
    if ($(this).attr('id') != 'refine_search_expand_collapse')
        $(this).parent().parent().parent().css('border-bottom', '0px solid rgb(204, 204, 204)');
    e.preventDefault();
        
}); 
$('.expand').live("click", function(e){
    $(this).html($(this).html().replace('up','down'));
    $(this).removeClass('expand');
    $(this).addClass('collapse');
    $(this).parent().parent().parent().next().show();
    if ($(this).attr('id') != 'refine_search_expand_collapse')
        $(this).parent().parent().parent().css('border-bottom', '2px solid rgb(204, 204, 204)');
    e.preventDefault();
        
}); 

function clearPostMarkers()
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
    alert('ClearMarkers');
    $('#mapContentDiv').gmap3(todo);
}
function clearOverlays() {
    if (markersArray) {
        for (var i = 0; i < markersArray.length; i++ ) {
            markersArray[i].setMap(null);
        }
    }
}

function LoadMapView()
{
    //$('#mapContentDiv').gmap('clear', 'markers');
    var markers = new Array();
    var i = 0;
    $('#searchContentDiv').find('.listing').each(function (index){
        var lat = $(this).find(".bottom-bar").find('.map-lat').val(); 
        var lon = $(this).find(".bottom-bar").find('.map-lon').val();
        var address = $(this).find(".bottom-bar").find('.map-address').val();
        if (lat != "" && lon != "")
        {
            var postData = '<div class="marker-infowindow Action"><div style="float:right;width:370px;text-align:right"><a href="#" class="prevPost">Prev</a><a href="#" class="nextPost">Next</a></div>' + $(this).html() + '</div>';
            var alreadyAdded = false;
            for (var j = 0; j < markers.length; j++) {
                if (markers[j].lat == lat && markers[j].lng == lon)
                {
                    alreadyAdded = true;
                    postData = '<div style="display:none" class="marker-infowindow Action"><div style="float:right;width:370px;text-align:right"><a href="#" class="prevPost">Prev</a><a href="#" class="nextPost">Next</a></div>' + $(this).html() + '</div>';
                    markers[j].data = markers[j].data + postData;
                    break;
       
                }
            }
            if (!alreadyAdded)
           
            {
                markers[i] = new google.maps.Marker(
                {
                    lat: lat,            
                    lng:lon,
                    data:postData
                   
              
                } ); 
                i = i + 1;
            }
        }
    }); 
   
    $('#mapContentDiv').show();
    var map = $('#mapContentDiv').gmap3('get');
    if (map != undefined && map != null)
        clearPostMarkers();
    
 
    $('#mapContentDiv').gmap3(
    {
        action: 'init',
        options:{
            center:[latitude, longitude],
            zoom:11,
            maxZoom:20,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            },
            navigationControl: true,
            scrollwheel: true,
            streetViewControl: true
        }
    },
    {
        action: 'addMarkers',
        radius:10,
        markers:markers,
      
        callback: function(marker) {
            $.each(marker, function(i, m) {
                if (markers[i].data.indexOf('spam selected') != -1)
                    m.icon = new google.maps.MarkerImage('http://chart.apis.google.com/chart?chst=d_map_spin&chld=0.6|0|DC143C|9|_|' + (i + 1));
       
                else if (markers[i].data.indexOf('favorite selected') != -1)
                    m.icon = new google.maps.MarkerImage('http://chart.apis.google.com/chart?chst=d_map_spin&chld=0.6|0|FFFF00|9|_|' + (i + 1));
       
                else
                    //m.icon = new google.maps.MarkerImage('http://chart.apis.google.com/chart?chst=d_map_spin&chld=0.8|0|FE7569|12|_|' + (i + 1));
                    m.icon = new google.maps.MarkerImage('http://chart.apis.google.com/chart?chst=d_map_spin&chld=0.6|0|99BF52|9|_|' + (i + 1));
            });
        },
        //              clusters:{
        //              // This style will be used for clusters with more than 0 markers
        //              0: {
        //                content: '<div class="cluster cluster-1">CLUSTER_COUNT</div>',
        //                width: 53,
        //                height: 52
        //              },
        //              // This style will be used for clusters with more than 20 markers
        //              20: {
        //                content: '<div class="cluster cluster-2">CLUSTER_COUNT</div>',
        //                width: 56,
        //                height: 55
        //              },
        //              // This style will be used for clusters with more than 50 markers
        //              50: {
        //                content: '<div class="cluster cluster-3">CLUSTER_COUNT</div>',
        //                width: 66,
        //                height: 65
        //              }
        //            },
        marker:{
            options:{
                draggable: false
                
            },
           
           
            events:{
                click: function(marker, event, data){
                 
                    var map = $(this).gmap3('get');
                   
                    $("#dialogMarkerInfo").html(data);
                    $("#dialogMarkerInfo").dialog('open');
                    
                    $("#dialogMarkerInfo .marker-infowindow").first().find('.prevPost').hide();
                    $("#dialogMarkerInfo .marker-infowindow").first().find('.nextPost').show();
                    $("#dialogMarkerInfo .marker-infowindow").last().find('.prevPost').show();
                    $("#dialogMarkerInfo .marker-infowindow").last().find('.nextPost').hide();
                    if ($("#dialogMarkerInfo").find('.marker-infowindow').length == 1)
                    {
                        $("#dialogMarkerInfo .marker-infowindow").first().find('.prevPost').hide(); 
                        $("#dialogMarkerInfo .marker-infowindow").first().find('.nextPost').hide();
                    }
                        
                    var scale = Math.pow(2, map.getZoom());
                    var nw = new google.maps.LatLng(
                        map.getBounds().getNorthEast().lat(),
                        map.getBounds().getSouthWest().lng()
                        );
                    var worldCoordinateNW = map.getProjection().fromLatLngToPoint(nw);
                    var worldCoordinate = map.getProjection().fromLatLngToPoint(marker.getPosition());
                    var pixelOffset = new google.maps.Point(
                        Math.floor((worldCoordinate.x - worldCoordinateNW.x) * scale),
                        Math.floor((worldCoordinate.y - worldCoordinateNW.y) * scale)
                        );
 
                    jQuery("#dialogMarkerInfo").dialog('option', 'position', [pixelOffset.x + $('#mapContentDiv').offset().left + 15,pixelOffset.y  + $('#mapContentDiv').offset().top - $(window).scrollTop() - 55]);
 
              
                }
           
            }
        }
    }
    );
    var bounds = new google.maps.LatLngBounds();
             
    for (var l = 0; l < markers.length; l++) {
   
        bounds.extend(new google.maps.LatLng(markers[l].lat,markers[l].lng));
                      
    }
    map = $('#mapContentDiv').gmap3('get');
    map.fitBounds(bounds);
    $('.map-show-more').show();
  
       
}
//$('.listing .description .images .current a').live("click", function(e){
//    var url = $(this).attr('href');
//    
//    var postingId = url.substring(url.lastIndexOf('/') + 1);
//    
//    $.ajax({
//        global:false,
//        type: "GET",
//        url: "/post/details/",
//        data:"postingId=" + postingId ,        
//        success: function(data){
//            if (data != "")
//            {
//                $("#dialogDetailsInfo").html(data);
//                $("#dialogDetailsInfo").dialog('open');
//                $('#dialogDetailsInfo #thumbs').jcarousel({       
//                    });
//       
//                $('#dialogDetailsInfo .thumbs .thumb').click(function(){
//                    $('#dialogDetailsInfo .thumbs .selected').removeClass('selected');
//                    $(this).addClass('selected');
//                    $('#dialogDetailsInfo .images .current').removeClass('current');
//                    $('#dialogDetailsInfo .images > .image').eq($(this).index()).addClass('current');
//                });
//       
//                $("#dialogDetailsInfo .listing .image").colorbox({
//                    rel:'image', 
//                    transition:"none", 
//                    width:"75%", 
//                    height:"75%", 
//                    fixed:'true'
//                });
//            }
//           
//            
//        },
//        error:function (xhr, ajaxOptions, thrownError, request, error){
//            if(xhr.readyState == 0 || xhr.status == 0)
//                return;  // it's not really an error
//            else
//            {
//
//            }
//        }
//    })
//    e.preventDefault();
//   
//})
//$('.listing .description .listing-title a').live("click", function(e){
//    var url = $(this).attr('href');
//    
//    var postingId = url.substring(url.lastIndexOf('/') + 1);
//    
//    $.ajax({
//        global:false,
//        type: "GET",
//        url: "/post/details/",
//        data:"postingId=" + postingId ,        
//        success: function(data){
//            if (data != "")
//            {
//                $("#dialogDetailsInfo").html(data);
//                $("#dialogDetailsInfo").dialog('open');
//                $('#dialogDetailsInfo #thumbs').jcarousel({       
//                    });
//       
//                $('#dialogDetailsInfo .thumbs .thumb').click(function(){
//                    $('#dialogDetailsInfo .thumbs .selected').removeClass('selected');
//                    $(this).addClass('selected');
//                    $('#dialogDetailsInfo .images .current').removeClass('current');
//                    $('#dialogDetailsInfo .images > .image').eq($(this).index()).addClass('current');
//                });
//       
//                $("#dialogDetailsInfo .listing .image").colorbox({
//                    rel:'image', 
//                    transition:"none", 
//                    width:"75%", 
//                    height:"75%", 
//                    fixed:'true'
//                });
//            }
//           
//            
//        },
//        error:function (xhr, ajaxOptions, thrownError, request, error){
//            if(xhr.readyState == 0 || xhr.status == 0)
//                return;  // it's not really an error
//            else
//            {
//
//            }
//        }
//    })
//    e.preventDefault();
//   
//})
loadMapWithSpiderfier = function() {
    $('#mapContentDiv').show();
    
    var gm = google.maps;
    var map = $('#mapContentDiv').gmap3('get');
   
    if (map != undefined && map != null)
        clearOverlays();
    else
    {
        $('#mapContentDiv').gmap3(
        {
            action: 'init',
            options:{
                center:[latitude, longitude],
                zoom:11,
                maxZoom:20,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                },
                navigationControl: true,
                scrollwheel: true,
                streetViewControl: true
            }
        });
        map = $('#mapContentDiv').gmap3('get');
    }
    markersArray = new Array();
    var i = 0;
    $('#searchContentDiv').find('.listing').each(function (index){
        var lat = $(this).find(".bottom-bar").find('.map-lat').val(); 
        var lon = $(this).find(".bottom-bar").find('.map-lon').val();
        var address = $(this).find(".bottom-bar").find('.map-address').val();
        var postingId = $(this).find(".bottom-bar").find('.facebook').attr('id').replace('fblink_','');
        var postTitle = stripsTags($(this).find(".listing-title").html());
      
        if (lat != "" && lon != "")
        {
            var html = $(this).html();
            html = html.replace('cboxElement','');
            html = html.replace('cboxElement','');
            var postData = '<div class="marker-infowindow Action">' + html + '</div>';
            var alreadyAdded = false;
            //            for (var j = 0; j < markersArray.length; j++) {
            //                if (markersArray[j].lat == lat && markersArray[j].lng == lon)
            //                {
            //                    alreadyAdded = true;
            //                    postData = '<div style="display:none" class="marker-infowindow Action"><div style="float:right;width:370px;text-align:right"><a href="#" class="prevPost">Prev</a><a href="#" class="nextPost">Next</a></div>' + $(this).html() + '</div>';
            //                    markers[j].data = markers[j].data + postData;
            //                    break;
            //       
            //                }
            //            }
            if (!alreadyAdded)
           
            {
                markersArray[i] = new google.maps.Marker(
                {
                    lat: lat,            
                    lng:lon,
                    data:postData,
                    title:postTitle,
                    desc:postingId
                    
                   
              
                } ); 
                i = i + 1;
            }
        }
    }); 
   
   
    
    var oms = new OverlappingMarkerSpiderfier(map,
    {
        markersWontMove: true, 
        markersWontHide: true,
        keepSpiderfied:true,
        nearbyDistance:20
    });

    var usualColor = '99BF52';
    var spiderfiedColor = 'F1931F';
    var iconWithColor = function(data,i,color) {
        
        if (data.indexOf('spam selected') != -1)
            return (new google.maps.MarkerImage('http://chart.apis.google.com/chart?chst=d_map_spin&chld=0.6|0|DC143C|9|_|' + (i + 1)));
       
        else if (data.indexOf('favorite selected') != -1)
            return (new google.maps.MarkerImage('http://chart.apis.google.com/chart?chst=d_map_spin&chld=0.6|0|FFFF00|9|_|' + (i + 1)));
       
        else
                   
            return (new google.maps.MarkerImage('http://chart.apis.google.com/chart?chst=d_map_spin&chld=0.6|0|' + color + '|9|_|' + (i + 1)));
    }
    var shadow = new gm.MarkerImage(
        'https://www.google.com/intl/en_ALL/mapfiles/shadow50.png',
        new gm.Size(37, 34),  // size   - for sprite clipping
        new gm.Point(0, 0),   // origin - ditto
        new gm.Point(10, 34)  // anchor - where to meet map location
        );
    var iw = new gm.InfoWindow();  
    google.maps.event.addListener(iw, 'domready', function() {
        $('.marker-infowindow').parent().css('overflow','');
        $('.marker-infowindow').parent().parent().css('overflow','');
    }); 
    oms.addListener('click', function(marker) {
        iw.setContent(marker.data);
        iw.open(map, marker);
    //var map = $(this).gmap3('get');
    //        if (marker.getAnimation() != null) {
    //            marker.setAnimation(null);
    //        } else {
    //            marker.setAnimation(google.maps.Animation.BOUNCE);
    //            setTimeout(function(){
    //                marker.setAnimation(null);
    //            }, 750);
    //        }          
    //        $("#dialogMarkerInfo").html(marker.data);
    //        $("#dialogMarkerInfo").dialog('open');
    //                    
    //        $("#dialogMarkerInfo .marker-infowindow").first().find('.prevPost').hide();
    //        $("#dialogMarkerInfo .marker-infowindow").first().find('.nextPost').show();
    //        $("#dialogMarkerInfo .marker-infowindow").last().find('.prevPost').show();
    //        $("#dialogMarkerInfo .marker-infowindow").last().find('.nextPost').hide();
    //        if ($("#dialogMarkerInfo").find('.marker-infowindow').length == 1)
    //        {
    //            $("#dialogMarkerInfo .marker-infowindow").first().find('.prevPost').hide(); 
    //            $("#dialogMarkerInfo .marker-infowindow").first().find('.nextPost').hide();
    //        }
    //                        
    //        var scale = Math.pow(2, map.getZoom());
    //        var nw = new google.maps.LatLng(
    //            map.getBounds().getNorthEast().lat(),
    //            map.getBounds().getSouthWest().lng()
    //            );
    //        var worldCoordinateNW = map.getProjection().fromLatLngToPoint(nw);
    //        var worldCoordinate = map.getProjection().fromLatLngToPoint(marker.getPosition());
    //        var pixelOffset = new google.maps.Point(
    //            Math.floor((worldCoordinate.x - worldCoordinateNW.x) * scale),
    //            Math.floor((worldCoordinate.y - worldCoordinateNW.y) * scale)
    //            );
    // 
    //        jQuery("#dialogMarkerInfo").dialog('option', 'position', [pixelOffset.x + $('#mapContentDiv').offset().left + 15,pixelOffset.y  + $('#mapContentDiv').offset().top - $(window).scrollTop() - 55]);
    // 
    });
    oms.addListener('spiderfy', function(markers) {
        for(var i = 0; i < markers.length; i ++) {
            var number = i;
            for(var j = 0; j < markersArray.length; j ++) {
                if (markersArray[j].desc == markers[i].desc)
                {
                    markers[i].setTitle(markersArray[j].title);
                    number = j;
                    break;
                }
            }
            markers[i].setIcon(iconWithColor(markers[i].data,number,spiderfiedColor));
            markers[i]
            markers[i].setShadow(null);
        } 
        //jQuery("#dialogMarkerInfo").dialog('close');
        iw.close();
    });
    oms.addListener('unspiderfy', function(markers) {
        
        for(var i = 0; i < markers.length; i ++) {
            var number = i;
            for(var j = 0; j < markersArray.length; j ++) {
                if (markersArray[j].desc == markers[i].desc)
                {
                    markers[i].setTitle(markersArray[j].title);
                    number = j;
                    break;
                }
            }
            var counter = 0;
            for (var k = 0; k < markersArray.length; k ++) {
                if (markers[i].lat == markersArray[k].lat && markersArray[k].lng == markers[i].lng)
                    counter = counter + 1;
            }
            if (counter > 1)
            {
                markers[i].setIcon(new google.maps.MarkerImage('/images/multipin.png'));  
                markers[i].setShadow(shadow);
            }
            else
            {
                markers[i].setIcon(iconWithColor(markers[i].data,number,usualColor));
           
                markers[i].setShadow(shadow);
            }
        }
    });
  
    if (markersArray.length > 0)
    {
        var bounds = new gm.LatLngBounds();
        for (i = 0; i < markersArray.length; i ++) {
            var loc = new google.maps.LatLng(markersArray[i].lat,markersArray[i].lng);
            bounds.extend(loc);
       
            markersArray[i].setMap(map);
            markersArray[i].setPosition(loc);
            var counter = 0;
            for (var j = 0; j < markersArray.length; j ++) {
                if (markersArray[j].lat == markersArray[i].lat && markersArray[j].lng == markersArray[i].lng)
                    counter = counter + 1;
            }
            if (counter > 1)
            {
                markersArray[i].setIcon(new google.maps.MarkerImage('/images/multipin.png'));
                markersArray[i].setShadow(shadow);
            }
            else
            {
                markersArray[i].setIcon(iconWithColor(markersArray[i].data,i,usualColor));
                markersArray[i].setShadow(shadow);
            }
            
            oms.addMarker(markersArray[i]);
        }
   
        map.fitBounds(bounds);
    }
    $('.map-show-more').show();
     
}
    




