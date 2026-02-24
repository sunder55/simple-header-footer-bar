<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * SHFB Frontend Class
 */
class SHFB_Frontend
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_scripts']);
        add_action('wp_footer', [$this, 'render_bar']);
    }

    /**
     * Enqueue frontend scripts and styles
     */
    public function enqueue_frontend_scripts()
    {
        wp_enqueue_style(
            'shfb-frontend',
            SHFB_URL . 'assets/css/bar.css',
            [],
            SHFB_VERSION
        );

        wp_enqueue_script(
            'shfb-frontend',
            SHFB_URL . 'assets/js/bar.js',
            ['jquery'],
            SHFB_VERSION,
            true
        );
        $options = get_option('shfb_options', []);

        wp_localize_script(
            'shfb-frontend',
            'SHFB_DATA',
            [
                'displayMode' => $options['display_mode'] ?? 'always',
            ]
        );
    }

    public function render_bar()
    {

        $options = get_option('shfb_options', []);
        $message = $options['text'] ?? '';

        // for single pages
        if (is_singular()) {

            $disabled = get_post_meta(get_the_ID(), '_shfb_disable', true);
            if ($disabled) {
                return;
            }

            $custom_text = get_post_meta(get_the_ID(), '_shfb_custom_text', true);
            if (! empty($custom_text)) {
                $message = $custom_text;
            }
        }

        if (empty($message)) {
            return;
        }
        $bg   = $options['bg_color'] ?? '#000';
        $font = $options['font_color'] ?? '#fff';
        $pos  = $options['position'] ?? 'header';
        $close = ! empty($options['close_button']);

        $position_class = $pos === 'footer' ? 'shfb-footer' : 'shfb-header';

?>
        <div class="shfb-bar <?php echo esc_attr($position_class); ?>"
            style="background:<?php echo esc_attr($bg); ?>; color:<?php echo esc_attr($font); ?>">
            <div class="shfb-inner">
                <span class="shfb-text">
                    <?php echo wp_kses_post($message); ?>
                </span>

                <?php if ($close) : ?>
                    <button class="shfb-close">&times;</button>
                <?php endif; ?>
            </div>
        </div>
<?php

    }
}
