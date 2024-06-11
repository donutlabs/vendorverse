<?php
// Dashboard page for vendors.
function mvm_vendor_dashboard() {
    ob_start();
    
    if (current_user_can('vendor')) {
        ?>
        <h2>Vendor Dashboard</h2>
        <p>Welcome, <?php echo wp_get_current_user()->display_name; ?>!</p>
        
        <ul>
            <li><a href="<?php echo admin_url('post-new.php?post_type=product'); ?>">Add New Product</a></li>
            <li><a href="<?php echo admin_url('edit.php?post_type=product'); ?>">Manage Products</a></li>
            <li><a href="<?php echo admin_url('edit.php?post_type=shop_order'); ?>">View Orders</a></li>
        </ul>
        <?php
    } else {
        echo '<p>You do not have permission to access this page.</p>';
    }

    return ob_get_clean();
}
add_shortcode('vendor_dashboard', 'mvm_vendor_dashboard');
