<?php
function mvm_approve_reject_vendor_application() {
    if (isset($_POST['approve_vendor_application']) || isset($_POST['reject_vendor_application'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'vendor_applications';
        $application_id = intval($_POST['application_id']);

        if (isset($_POST['approve_vendor_application'])) {
            $application = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $application_id));
            if ($application) {
                // Create the user.
                $user_id = wp_create_user($application->email, $application->password, $application->email);
                wp_update_user([
                    'ID' => $user_id,
                    'display_name' => $application->name,
                    'role' => 'vendor'
                ]);

                // Update the application status.
                $wpdb->update($table_name, ['status' => 'approved'], ['id' => $application_id]);
            }
        } elseif (isset($_POST['reject_vendor_application'])) {
            // Update the application status.
            $wpdb->update($table_name, ['status' => 'rejected'], ['id' => $application_id]);
        }

        // Redirect to avoid resubmission.
        wp_redirect(add_query_arg('tab', 'vendor-management', admin_url('admin.php?page=vendorverse-dashboard')));
        exit;
    }
}
add_action('admin_post_approve_vendor_application', 'mvm_approve_reject_vendor_application');
add_action('admin_post_reject_vendor_application', 'mvm_approve_reject_vendor_application');
