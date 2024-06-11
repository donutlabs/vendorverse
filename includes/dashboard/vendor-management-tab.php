<?php
function mvm_vendor_management_tab() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'vendor_applications';
    $applications = $wpdb->get_results("SELECT * FROM $table_name WHERE status = 'pending'");

    ?>
    <h2>Vendor Applications</h2>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($applications as $application) : ?>
                <tr>
                    <td><?php echo esc_html($application->name); ?></td>
                    <td><?php echo esc_html($application->email); ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="application_id" value="<?php echo $application->id; ?>">
                            <input type="submit" name="approve_vendor_application" class="button button-primary" value="Approve">
                        </form>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="application_id" value="<?php echo $application->id; ?>">
                            <input type="submit" name="reject_vendor_application" class="button button-secondary" value="Reject">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}
?>
