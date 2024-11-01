<?php
/*
Plugin Name: Syrow Care
Plugin URI: https://care.syrow.com/
Description: A simple yet powerful plugin that allows you to insert the Syrow Care code into your WordPress website.
Version: 1.0
Author: Syrow Pvt. Ltd.
Author URI: https://www.syrow.com
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: syrow-care
Domain Path: /languages
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_menu', 'syrow_care_add_settings_page');
add_action('admin_init', 'syrow_care_register_settings');
add_action('wp_head', 'syrow_care_insert_code');

// Add settings page to the admin menu
function syrow_care_add_settings_page()
{
    add_menu_page(
        esc_html__('Syrow Care Settings', 'syrow-care'),
        esc_html__('Syrow Care', 'syrow-care'),
        'manage_options',
        'syrow-care-settings',
        'syrow_care_settings_page',
        'dashicons-admin-generic',
        100
    );
}

// Create the settings page content
function syrow_care_settings_page()
{
    // Load the template file
    include 'templates/setting.php';
}

// Register settings
function syrow_care_register_settings()
{
    register_setting('syrow_care_options', 'syrow_care_code', 'syrow_care_sanitize_code');
    add_settings_section('syrow_care_main', __('Main Settings', 'syrow-care'), 'syrow_care_section_text', 'syrow-care-settings');
    add_settings_field('syrow_care_code', __('Please enter your code here:', 'syrow-care'), 'syrow_care_code_field', 'syrow-care-settings', 'syrow_care_main');
}

// Section text
function syrow_care_section_text()
{
    // echo '<p>' . __('Use the textarea below to insert your Syrow Care code. Visit <a href="https://care.syrow.com" target="_blank">care.syrow.com</a> to get the code.') . '</p>';
    echo wp_kses(
        '<p>' . esc_html__('Use the textarea below to insert your Syrow Care code. Visit <a href="https://care.syrow.com" target="_blank">care.syrow.com</a> to get the code.', 'your-text-domain') . '</p>',
        array(
            'p' => array(),
            'a' => array(
                'href' => array(),
                'target' => array(),
            ),
        )
    );

}

// Code field
function syrow_care_code_field()
{
    $syrow_code = get_option('syrow_care_code');
    echo "<textarea name='syrow_care_code' placeholder='" . esc_attr__('Syrow Care code here...', 'syrow-care') . "' rows='5' cols='50'>" . esc_textarea($syrow_code) . "</textarea>";
}

// Insert code into the head section
function syrow_care_insert_code()
{
    $syrow_code = get_option('syrow_care_code');
    if (!empty($syrow_code)) {
        echo wp_kses($syrow_code, array('script' => array('src' => array(), 'type' => array())));
    }
}

// Sanitization function
function syrow_care_sanitize_code($input)
{
    $allowed_tags = array(
        'script' => array(
            'src' => array(),
            'type' => array(),
        ),
    );
    return wp_kses($input, $allowed_tags);
}

function syrow_care_settings_quick_link($actions, $plugin_file)
{

    // Make sure we only perform actions for this specific plugin!
    if (strpos($plugin_file, 'syrow_care_wp_plugin.php') !== false) {

        // Add link to the settings page.
        if (current_user_can('manage_options')) {
            array_unshift($actions, '<a href="admin.php?page=syrow-care-settings">' . __('Settings', 'syrow-care') . '</a>');
        }
    }

    return $actions;
}

add_filter('plugin_action_links', 'syrow_care_settings_quick_link', 10, 2);
?>