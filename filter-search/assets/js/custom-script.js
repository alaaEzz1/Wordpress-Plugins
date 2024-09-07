jQuery(document).ready(function($) {
    // Add event listener for form submission
    $('.alaa-ezz-eldin-filter-form form').submit(function(event) {
        // Prevent default form submission
        event.preventDefault();

        // Get form data
        var formData = $(this).serialize();

        // Example: Perform AJAX request to filter products
        $.ajax({
            url: ajax_url, // Replace with your AJAX endpoint
            type: 'POST',
            data: formData,
            beforeSend: function() {
                // Show loading spinner or indicator
                $('.alaa-ezz-eldin-filter-form button').attr('disabled', 'disabled');
                // Example: Show loading spinner
                $('.alaa-ezz-eldin-filter-form').append('<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>');
            },
            success: function(response) {
                // Example: Update product listing with filtered results
                // Replace '#product-listing' with your product listing container
                $('#product-listing').html(response);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            },
            complete: function() {
                // Hide loading spinner or indicator
                $('.alaa-ezz-eldin-filter-form button').removeAttr('disabled');
                $('.alaa-ezz-eldin-filter-form .spinner-border').remove();
            }
        });
    });

    // Placeholder for additional custom JavaScript functionality
});
