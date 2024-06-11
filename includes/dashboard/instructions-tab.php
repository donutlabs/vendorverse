<?php
function mvm_instructions_tab() {
    ?>
    <h2>Shortcode Instructions</h2>
    <p>To add the vendor registration form to a page, use the following shortcode:</p>
    <pre>[vendor_registration]</pre>
    
    <h2>Alternatively, Click Below to Create Registration Page Automatically</h2>
    <form method="post">
        <input type="hidden" name="create_registration_page" value="1">
        <button type="submit" class="button button-primary">Create Page For Me!</button>
    </form>
    <?php
}
?>
