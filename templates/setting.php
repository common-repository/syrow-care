<div class="wrap">
    <h1>Syrow Care</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('syrow_care_options');
        do_settings_sections('syrow-care-settings');
        wp_nonce_field('syrow_care_options_verify', 'syrow_care_nonce');
        submit_button();
        ?>
    </form>
</div>