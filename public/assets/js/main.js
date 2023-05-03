// Wait for the DOM to finish loading
$(document).ready(function() {
    // Add click handler for "delete product" button
    $('#delete-product-btn').click(function(event) {
        // Submit the product form
        $('#product_form').submit();
    });
    $('.card').each(function() {
        var checkbox = $(this).find('input[type="checkbox"]');
        
        // Handle card click event
        $(this).click(function(event) {
          // Toggle the checkbox state
          checkbox.prop('checked', !checkbox.prop('checked'));
          
          if (!checkbox.prop('checked')) {
            // Remove the shadow when the checkbox is unchecked
            $(this).css("box-shadow", "");
          } else {
            // Toggle the card shadow
            $(this).css("box-shadow", "rgb(234 13 13 / 70%) 0px 0px 0px 0.25rem");
          }
        });
        
        // Handle checkbox change event
        checkbox.change(function(event) {
          if (!checkbox.prop('checked')) {
            // Remove the shadow when the checkbox is unchecked
            $(this).parent().parent().parent().css("box-shadow", "");
          } else {
            // Toggle the card shadow
            $(this).parent().parent().parent().css("box-shadow", "rgb(234 13 13 / 70%) 0px 0px 0px 0.25rem");
          }
        });
        
        // Stop checkbox click event from bubbling up to card element
        checkbox.click(function(event) {
          event.stopPropagation();
        });
      });
      
    
});
