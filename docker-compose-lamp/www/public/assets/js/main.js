// Wait for the DOM to finish loading
$(document).ready(function() {
    // Add click handler for "delete product" button
    $('#delete-product-btn').click(function(event) {
        // Submit the product form
        $('#product_form').submit();
    });
    
    // Add click handler for each card element
    $('.card').each(function() {
        $(this).click(function(event) {
            // Toggle the checkbox state
            var checkbox = $(this).find('input[type="checkbox"]');
            checkbox.prop('checked', !checkbox.prop('checked'));
        });
        
        // Stop checkbox click event from bubbling up to card element
        $(this).find('input[type="checkbox"]').click(function(event) {
            event.stopPropagation();
        });
    });
});
