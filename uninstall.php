<?php
/**
 * Uninstaller
 *
 * Uninstall the plugin by removing any options from the database
 *
 * @package  Syrow_Care
 */

// If the uninstall was not called by WordPress, exit.
// Exit if accessed directly
if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')) {
	exit();
}

// Delete any options.

delete_site_option('syrow_care_code');
