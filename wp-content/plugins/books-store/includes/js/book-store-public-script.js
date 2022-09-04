// A $( document ).ready() block.
jQuery( document ).ready(function() {
    
    /* Custom code to popuplate selected value of price in hidden field */
    var range = jQuery('#book_price');
    range.on('input', function(){
        jQuery('#selected_book_price').val(this.value);
        jQuery('.price-indicator').text(this.value);
    }); 

    /* Custom ajax code to filter Book Records */
    jQuery('#book-search-form').on('submit', function(event) {
        
        event.preventDefault();
        var book_title = jQuery('#book_title').val();
        var book_author = jQuery('#book_author').val();
        var book_publisher = jQuery('#book_publisher').val();
        var book_rating    = jQuery('#book_rating').val();
        var book_pricing    = jQuery('#selected_book_price').val();
        jQuery.ajax({
          type : "POST",
          url : BookStorePublic.ajaxurl,
          data : {
            action: "book_search_filtering",
            book_title:book_title,
            book_author:book_author,
            book_publisher:book_publisher,
            book_rating:book_rating,
            book_pricing:book_pricing
          },
          beforeSend: function() {
            jQuery("#overlay").fadeIn(300);
          },
          success: function(response) {
            if(response != ''){
                jQuery('#book-search-records  tbody').html(response);
            } 
          },
          complete: function() {
            jQuery("#overlay").fadeOut(300);
          }
        });
    });
});