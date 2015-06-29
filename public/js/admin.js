$('document').ready(function(){
    $('#adminTabs').tabs({
        select: function(event, ui) {
        
            if (ui.index == 0)
            {
            
        
            } else if (ui.index == 1)
{
                $('#recentPosts').empty();
                getRecentPosts();
            }
            else if (ui.index == 2)
            {
                $('#recentLogins').empty();
                getRecentLogins();
            }
            else if (ui.index == 3)
            {
                $('#spamPosts').empty();
                getSpamPosts();
            }
        }
    });
})
$("#adminTabs").show();

function getRecentPosts()
{
    $('#last_post_loader').mask("Loading Recent Posts...");
    $.ajax({
        global:false,
        type: "GET",
        url: "/search/recentlistings/",                           
        success: function(listingResponse){                      
            if (listingResponse != "")
            {   
                   
                var numFound;
                var searchResult;                  
              
                        
                searchResult =listingResponse;  
                $(searchResult).appendTo($('#recentPosts'));  
                   
                $('div#last_post_loader').unmask() ; 
                    
            }
            else
            {
                    
                if ($('#recentPosts').html() =="")
                {
                    searchResult = '<div>No Recent Posts</div>';
                       
                    $(searchResult).appendTo($('#recentPosts')); 
                }
                $('div#last_post_loader').unmask();  
                   
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

function getSpamPosts()
{
    $('#last_spam_post_loader').mask("Loading Spam Posts...");
    $.ajax({
        global:false,
        type: "GET",
        url: "/search/spamposts/",                           
        success: function(listingResponse){                      
            if (listingResponse != "")
            {   
                   
                var numFound;
                var searchResult;                  
              
                        
                searchResult =listingResponse;  
                $(searchResult).appendTo($('#spamPosts'));  
                   
                $('div#last_spam_post_loader').unmask() ; 
                    
            }
            else
            {
                    
                if ($('#spamPosts').html() =="")
                {
                    searchResult = '<div>No Recent Posts</div>';
                       
                    $(searchResult).appendTo($('#spamPosts')); 
                }
                $('div#last_spam_post_loader').unmask();  
                   
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

function getRecentLogins()
{
    $('#last_recent_login_loader').mask("Loading Recent Logins...");
    $.ajax({
        global:false,
        type: "GET",
        url: "/search/recentlogins/",                           
        success: function(listingResponse){                      
            if (listingResponse != "")
            {   
                   
                var numFound;
                var searchResult;                  
              
                        
                searchResult =listingResponse;  
                $(searchResult).appendTo($('#recentLogins'));  
                   
                $('div#last_recent_login_loader').unmask() ; 
                    
            }
            else
            {
                    
                if ($('#recentLogins').html() =="")
                {
                    searchResult = '<div>No Recent Logins</div>';
                       
                    $(searchResult).appendTo($('#recentLogins')); 
                }
                $('div#last_recent_login_loader').unmask();  
                   
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