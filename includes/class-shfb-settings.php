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
        $this->options = get_option($this->option_key, []);

        // admin hooks 
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
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
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('shfb-admin-js', SHFB_URL . 'assets/js/admin.js', ['wp-color-picker', 'jquery'], time(), true);

        wp_enqueue_style('shfb-admin-style', SHFB_URL . 'assets/css/admin.css', [], time());
    }

    /**
     * Add settings page
     */
    public function add_settings_page()
    {
        add_options_page(
            __('Header Footer Bar', 'simple-header-footer-bar'),
            __('Header Footer Bar', 'simple-header-footer-bar'),
            'manage_options',
            'shfb-settings',
            [$this, 'render_settings_page']
        );
    }

    /**
     * Option page callback
     */
    public function register_settings()
    {
        register_setting('shfb_options_group', $this->option_key, [$this, 'sanitize_settings']);
        add_settings_section(
            'shfb_main_section',
            __('Bar Settings', 'simple-header-footer-bar'),
            null,
            'shfb-settings'
        );

        $fields = [
            'text'         => __('Bar Text', 'simple-header-footer-bar'),
            'bg_color'     => __('Background Color', 'simple-header-footer-bar'),
            'font_color'   => __('Font Color', 'simple-header-footer-bar'),
            'position'     => __('Position', 'simple-header-footer-bar'),
            'close_button' => __('Show Close Button', 'simple-header-footer-bar'),
        ];

        foreach ($fields as $field_id => $field_title) {
            $callback = match ($field_id) {
                'text'         => [$this, 'text_field'],
                'bg_color', 'font_color' => [$this, 'color_field'],
                'position'     => [$this, 'position_field'],
                'close_button' => [$this, 'checkbox_field'],
            };

            add_settings_field(
                $field_id,
                $field_title,
                $callback,
                'shfb-settings',
                'shfb_main_section',
                ['id' => $field_id]
            );
        }
    }

    /**
     * Sanitize settings before saving
     */
    public function sanitize_settings($input)
    {
        $output = [];

        $output['text']         = isset($input['text']) ? wp_kses_post($input['text']) : '';
        $output['bg_color']     = isset($input['bg_color']) ? sanitize_hex_color($input['bg_color']) : '#000000';
        $output['font_color']   = isset($input['font_color']) ? sanitize_hex_color($input['font_color']) : '#ffffff';
        $output['position']     = in_array($input['position'] ?? '', ['header', 'footer'], true) ? $input['position'] : 'header';
        $output['close_button'] = ! empty($input['close_button']) ? 1 : 0;

        return $output;
    }

    /**
     * Render settings page
     */
    public function render_settings_page()
    {
?>
        <div class="wrap">
            <h1><?php esc_html_e('Header Footer Bar Settings', 'simple-header-footer-bar'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('shfb_options_group');
                do_settings_sections('shfb-settings');
                submit_button();
                ?>
            </form>
        </div>
    <?php
    }

    /**
     * Render text input
     */
    public function text_field($args)
    {
        $id = $args['id'];
        printf(
            '<input type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="regular-text">',
            esc_attr($id),
            esc_attr($this->option_key),
            esc_attr($this->options[$id] ?? '')
        );
    }

    /**
     * Render color input
     */
    public function color_field($args)
    {
        $id = $args['id'];
        printf(
            '<input type="text" id="%1$s" name="%2$s[%1$s]" value="%3$s" class="shfb-color-field">',
            esc_attr($id),
            esc_attr($this->option_key),
            esc_attr($this->options[$id] ?? '')
        );
    }

    /**
     * Render select for position
     */
    public function position_field($args)
    {
        $value = $this->options['position'] ?? 'header';
    ?>
        <select name="<?php echo esc_attr($this->option_key); ?>[position]">
            <option value="header" <?php selected($value, 'header'); ?>>Header</option>
            <option value="footer" <?php selected($value, 'footer'); ?>>Footer</option>
        </select>
<?php
    }

    /**
     * Render checkbox for close button
     */
    public function checkbox_field($args)
    {
        $id = $args['id'];
        $checked = ! empty($this->options[$id]) ? 'checked' : '';
        printf(
            '<input type="checkbox" id="%1$s" name="%2$s[%1$s]" value="1" %3$s>',
            esc_attr($id),
            esc_attr($this->option_key),
            $checked
        );
    }
}
