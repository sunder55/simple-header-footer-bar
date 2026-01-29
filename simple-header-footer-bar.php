 <?php
  /**
   * Plugin Name: Simple Header Footer Bar
   * Plugin URI: https://github.com/sunder55/simple-header-footer-bar
   * Description: A simple plugin to add header and footer bar to your website.
   * Version: 1.0.0
   * Author: Rukmagat Kandel
   * License: GPL-2.0+
   * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
   * Text Domain: simple-header-footer-bar
   */

  if (!defined('ABSPATH')) {
    exit;
  }

  /*
* plugin constants
*/
  define('SHFB_VERSION', '1.0.0');
  define('SHFB_PATH', plugin_dir_path(__FILE__));
  define('SHFB_URL', plugin_dir_url(__FILE__));
  define('SHFB_BASENAME', plugin_basename(__FILE__));


  /**
   * Includes required files.
   */
  require_once SHFB_PATH . 'includes/class-shfb-settings.php';
  require_once SHFB_PATH . 'includes/class-shfb-frontend.php';

  /**
   * Initialize the plugin.
   */
  function shfb_init()
  {
    $shfb_settings = new SHFB_Settings();
    $shfb_frontend = new SHFB_Frontend();
  }
  add_action('plugins_loaded', 'shfb_init');
