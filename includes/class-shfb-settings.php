<?php
if (! defined('ABSPATH')) exit;

/**
 * SHFB Settings Class
 */
class SHFB_Settings
{

    /**
     * Options variable
     */
    private  $option_key = 'shfb_options';

    /**
     * Stored options
     */
    private $options = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->options = get_options($this->option_key, []);

        // admin hooks 
        add_action('admin_menu', [$this, 'add_settings_page']);

        // enqueue scripts
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    /**
     * enqueue admin scripts0
     */

    public function enqueue_scripts($hook)
    {
        if ($hook != 'settings_page_shfb-settings') {
            return;
        }
        wp_enqueue_script('shfb-admin-script', SHFB_URL . 'assets/js/admin.js', ['jquery'], time(), true);
        wp_enqueue_style('shfb-admin-style', SHFB_URL . 'assets/css/admin.css', [], time());
    }

    /**
     * Add settings page
     */
    public function add_settings_page()
    {
        add_options_page(
            'Simple Header Footer Bar Settings',
            'Header Footer Bar',
            'manage_options',
            'shfb-settings',
            [$this, 'render_settings_page']
        );
    }

    /**
     * Option page callback
     */
    public function render_settings_page()
    {
        echo 'plguin page created';
    }
}
