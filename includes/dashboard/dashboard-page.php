<?php
// Add admin menu item.
function mvm_add_admin_menu() {
    add_menu_page(
        'VendorVerse Dashboard',
        'VendorVerse',
        'manage_options',
        'vendorverse-dashboard',
        'mvm_dashboard_page',
        'dashicons-store',
        6
    );
}
add_action('admin_menu', 'mvm_add_admin_menu');

// Dashboard page content.
function mvm_dashboard_page() {
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'instructions';
    ?>
    <div class="wrap">
        <h1>VendorVerse Dashboard</h1>
        <h2 class="nav-tab-wrapper">
            <a href="?page=vendorverse-dashboard&tab=instructions" class="nav-tab <?php echo $active_tab == 'instructions' ? 'nav-tab-active' : ''; ?>">Instructions</a>
            <a href="?page=vendorverse-dashboard&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>">Settings</a>
            <a href="?page=vendorverse-dashboard&tab=reports" class="nav-tab <?php echo $active_tab == 'reports' ? 'nav-tab-active' : ''; ?>">Reports</a>
            <a href="?page=vendorverse-dashboard&tab=vendor-management" class="nav-tab <?php echo $active_tab == 'vendor-management' ? 'nav-tab-active' : ''; ?>">Vendor Management</a>
        </h2>
        <div class="tab-content">
            <?php
            switch ($active_tab) {
                case 'settings':
                    mvm_settings_tab();
                    break;
                case 'reports':
                    mvm_reports_tab();
                    break;
                case 'vendor-management':
                    mvm_vendor_management_tab();
                    break;
                case 'instructions':
                default:
                    mvm_instructions_tab();
                    break;
            }
            ?>
        </div>
    </div>
    <?php
}
?>
