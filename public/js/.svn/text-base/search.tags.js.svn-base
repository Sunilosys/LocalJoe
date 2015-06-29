$(function() {
		
    function split( val ) {
        return val.split( /,\s*/ );
    }
    function extractLast( term ) {
        return split( term ).pop();
    }
    $( "#search" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "/tag/search/",
                dataType: "json",
                data: {						
                    name_startsWith: extractLast( request.term )
                },
                success: function( data ) {
                                           
                    response( $.map( data, function( item ) {
                        return {
                            label: item.tag_name,
                            value: item.tag_id
                        }
                    }));
                }
            });
        },
        minLength: 2,
        appendTo: "#autocomplete",		
        open: function() {
            $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
        },
        close: function() {
            $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function( event, ui ) {
            var terms = split( this.value );
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push( ui.item.label );
            // add placeholder to get the comma-and-space at the end
            terms.push( "" );
            this.value = terms.join( "" );
            return false;
        }
    });
});