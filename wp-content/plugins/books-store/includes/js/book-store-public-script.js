// A $( document ).ready() block.
jQuery( document ).ready(function() {
    
    /* Custom code to popuplate selected value of price in hidden field */
    var range = jQuery('#book_price');
    range.on('input', function(){
        jQuery('#selected_book_price').val(this.value);
    }); 

});