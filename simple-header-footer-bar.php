 <?php 
 /**
  * Plugin Name: Simple Header Footer Bar
  * Plugin URI: https://github.com/sunderkandel/simple-header-footer-bar
  * Description: A simple plugin to add header and footer to your website.
  * Version: 1.0.0
  * Author: Sunder Kandel
  * Author URI: https://sunderkandel.com
  * License: GPL-2.0+
  * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
  * Text Domain: simple-header-footer-bar
  * Domain Path: /languages
  */

  if (!defined('ABSPATH')) {
    define('SIMPLE_HEADER_FOOTER_BAR_VERSION', '1.0.0');
    define('SIMPLE_HEADER_FOOTER_BAR_DIR', __DIR__);
    define('SIMPLE_HEADER_FOOTER_BAR_PATH', __DIR__ .'/');
  }

  require_once SIMPLE_HEADER_FOOTER_BAR_DIR . '/includes/class-simple-header-footer-bar.php';

  