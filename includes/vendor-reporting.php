<?php
// Sales reporting function.
function mvm_vendor_sales_report() {
    ob_start();
    
    if (current_user_can('vendor')) {
        // Get current vendor's products.
        $current_user_id = get_current_user_id();
        $args = [
            'post_type' => 'product',
            'posts_per_page' => -1,
            'author' => $current_user_id
        ];
        $products = new WP_Query($args);

        // Display sales data.
        ?>
        <h2>Sales Report</h2>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Sales</th>
                    <th>Earnings</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($products->have_posts()) : $products->the_post();
                    $product_id = get_the_ID();
                    $sales = get_post_meta($product_id, 'total_sales', true);
                    $earnings = get_post_meta($product_id, '_price', true) * $sales;
                    ?>
                    <tr>
                        <td><?php the_title(); ?></td>
                        <td><?php echo $sales; ?></td>
                        <td><?php echo wc_price($earnings); ?></td>
                    </tr>
                    <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </tbody>
        </table>
        <?php
    } else {
        echo '<p>You do not have permission to access this page.</p>';
    }

    return ob_get_clean();
}
add_shortcode('vendor_sales_report', 'mvm_vendor_sales_report');
