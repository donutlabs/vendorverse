<?php
// Vendor registration form shortcode.
function mvm_vendor_registration_form() {
    ob_start();
    ?>
    <form id="vendor-registration-form" method="post">
        <label for="vendor_name">Vendor Name:</label>
        <input type="text" id="vendor_name" name="vendor_name" required>
        
        <label for="vendor_email">Vendor Email:</label>
        <input type="email" id="vendor_email" name="vendor_email" required>
        
        <label for="vendor_password">Password:</label>
        <input type="password" id="vendor_password" name="vendor_password" required>
        
        <input type="submit" name="submit_vendor_registration" value="Register">
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('vendor_registration', 'mvm_vendor_registration_form');

// Handle vendor registration form submission.
function mvm_handle_vendor_registration() {
    if (isset($_POST['submit_vendor_registration'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'vendor_applications';

        $vendor_name = sanitize_text_field($_POST['vendor_name']);
        $vendor_email = sanitize_email($_POST['vendor_email']);
        $vendor_password = wp_hash_password(sanitize_text_field($_POST['vendor_password']));

        $wpdb->insert(
            $table_name,
            array(
                'name' => $vendor_name,
                'email' => $vendor_email,
                'password' => $vendor_password,
                'status' => 'pending'
            )
        );

        // Redirect after form submission.
        wp_redirect(home_url('/registration-success')); // Change the URL to the confirmation page.
        exit;
    }
}
add_action('template_redirect', 'mvm_handle_vendor_registration');
