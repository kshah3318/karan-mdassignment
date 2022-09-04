// A $( document ).ready() block.
jQuery( document ).ready(function() {
    
    /* Custom code to popuplate selected value of price in hidden field */
    var range = jQuery('#book_price');
    range.on('input', function(){
        jQuery('#selected_book_price').val(this.value);
    }); 

    /* Custom ajax code to filter Book Records */
    jQuery('#book-search-form').on('submit', function(event) {
        event.preventDefault();
        var selected_product = jQuery(this).val();
        var current_index    = jQuery(this).closest('#custom-select-ljus').find('#product-set-id').val();
        jQuery.ajax({
          type : "POST",
          url : BookStorePublic.ajaxurl,
          data : {
            action: "book_search_filtering",
            //product_id:selected_product
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


    jQuery(document).on('click', '.book-store', function(e) {

        alert("aaaa");
        e.preventDefault();
        
        var selected_product = jQuery(this).val();
        var current_index    = jQuery(this).closest('#custom-select-ljus').find('#product-set-id').val();
        /*jQuery.ajax({
          type : "POST",
          url : LjusMannenPublic.ajaxurl,
          data : {action: "ljus_mannen_get_variations_from_products",product_id:selected_product},
          success: function(response) {
            if(response.length != 0){
  
              jQuery('.product_variation_name').removeAttr("disabled");
              jQuery('.product_variation_name').html();
  
              var newselect = jQuery(this).closest('.repeater-item-select-variation').attr('newselect');
              jQuery('select[name="product_details_repeater['+current_index+'][product_variation_name]"]').html(response);
        
  
            } else {
  
              jQuery('select[name="product_details_repeater['+current_index+'][product_variation_name]"]').empty();
              jQuery('select[name="product_details_repeater['+current_index+'][product_variation_name]"]').attr("disabled", true);
  
            }
          }
        });*/
      });

});