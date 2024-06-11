<?php
/*
Plugin Name: VendorVerse
Description: Turn your WooCommerce store into a multi-vendor marketplace.
Version: 1.0
Author: Christopher Spradlin
*/

// Ensure the script is not directly accessible.
if (!defined('ABSPATH')) {
    exit;
}

// Include dash and reg files.
include_once plugin_dir_path(__FILE__) . 'includes/vendor-registration.php';
include_once plugin_dir_path(__FILE__) . 'includes/vendor-dashboard.php';

// Include dashboard files.
include_once plugin_dir_path(__FILE__) . 'includes/dashboard/dashboard-page.php';
include_once plugin_dir_path(__FILE__) . 'includes/dashboard/instructions-tab.php';
include_once plugin_dir_path(__FILE__) . 'includes/dashboard/settings-tab.php';
include_once plugin_dir_path(__FILE__) . 'includes/dashboard/reports-tab.php';
include_once plugin_dir_path(__FILE__) . 'includes/dashboard/vendor-management-tab.php';

// Function to add the vendor role and capabilities.
function mvm_add_vendor_role_and_capabilities() {
    // Add the vendor role with capabilities.
    add_role(
        'vendor',
        'Vendor',
        array(
            'read' => true,
            'edit_posts' => true,
            'delete_posts' => false,
            'publish_posts' => true,
            'upload_files' => true,
            'edit_products' => true,
            'delete_products' => true,
            'publish_products' => true,
            'edit_shop_orders' => true,
            'read_shop_orders' => true,
        )
    );

    // Add capabilities to other needed roles.
    $roles = array('administrator', 'shop_manager');
    foreach ($roles as $role) {
        $role_obj = get_role($role);
        if ($role_obj) {
            $role_obj->add_cap('edit_products');
            $role_obj->add_cap('delete_products');
            $role_obj->add_cap('publish_products');
            $role_obj->add_cap('edit_shop_orders');
            $role_obj->add_cap('read_shop_orders');
        }
    }
}

// Function to remove the vendor role.
function mvm_remove_vendor_role() {
    remove_role('vendor');
}

// Function to create registration page.
function mvm_create_registration_page() {
    $registration_page_title = 'Vendor Registration';
    $registration_page_content = '[vendor_registration]';

    // Create post object.
    $registration_page = array(
        'post_title'    => $registration_page_title,
        'post_content'  => $registration_page_content,
        'post_status'   => 'publish',
        'post_type'     => 'page',
    );

    // Insert the post into the database.
    $registration_page_id = wp_insert_post($registration_page);

    // Optionally, redirect to the newly created page.
    if ($registration_page_id) {
        wp_redirect(get_permalink($registration_page_id));
        exit;
    } else {
        // Error handling if page creation fails.
        echo 'Failed to create registration page.';
    }
}

// Hook into plugin activation to add the vendor role and capabilities.
register_activation_hook(__FILE__, 'mvm_add_vendor_role_and_capabilities');

// Hook into plugin deactivation to remove the vendor role.
register_deactivation_hook(__FILE__, 'mvm_remove_vendor_role');

// Handle button click to create registration page.
function mvm_handle_create_registration_page() {
    if (isset($_POST['create_registration_page'])) {
        mvm_create_registration_page();
    }
}
add_action('admin_init', 'mvm_handle_create_registration_page');
?>
