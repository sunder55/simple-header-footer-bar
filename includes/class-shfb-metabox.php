<?php
if (! defined('ABSPATH')) exit;

/**
 * Class for meta box
 */
class SHFB_Metabox
{

    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'add_metabox']);
        add_action('save_post', [$this, 'save_metabox']);
    }

    public function add_metabox()
    {

        $post_types = ['post', 'page'];

        foreach ($post_types as $post_type) {
            add_meta_box(
                'shfb_visibility',
                'Header/Footer Bar',
                [$this, 'render_metabox'],
                $post_type,
                'side',
                'default'
            );
        }
    }

    public function render_metabox($post)
    {

        wp_nonce_field('shfb_meta_nonce_action', 'shfb_meta_nonce');

        $value = get_post_meta($post->ID, '_shfb_disable', true);
?>

        <label>
            <input type="checkbox" name="shfb_disable" value="1"
                <?php checked($value, '1'); ?> />
            Disable bar on this content
        </label>
        <p style="margin-top:10px;">
            <label for="shfb_custom_text"><strong>Custom Bar Message</strong></label>
        </p>

        <?php
        $custom_text = get_post_meta($post->ID, '_shfb_custom_text', true);
        ?>

        <textarea
            name="shfb_custom_text"
            id="shfb_custom_text"
            rows="3"
            style="width:100%;"
            placeholder="Leave empty to use global message."><?php echo esc_textarea($custom_text); ?></textarea>
<?php
    }

    public function save_metabox($post_id)
    {

        // Nonce check
        if (
            ! isset($_POST['shfb_meta_nonce']) ||
            ! wp_verify_nonce($_POST['shfb_meta_nonce'], 'shfb_meta_nonce_action')
        ) {
            return;
        }

        // Autosave check
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Permission check
        if (! current_user_can('edit_post', $post_id)) {
            return;
        }

        // Save value
        if (isset($_POST['shfb_disable'])) {
            update_post_meta($post_id, '_shfb_disable', '1');
        } else {
            delete_post_meta($post_id, '_shfb_disable');
        }

        if (isset($_POST['shfb_custom_text'])) {
            $sanitized = wp_kses_post($_POST['shfb_custom_text']);
            update_post_meta($post_id, '_shfb_custom_text', $sanitized);
        }
    }
}
