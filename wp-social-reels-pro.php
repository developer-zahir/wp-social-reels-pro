<?php
/**
 * Plugin Name:       WP Social Reels Pro
 * Plugin URI:        https://developerzahir.com
 * Description:       A high-performance, interactive Social Video Reels Elementor Addon with Grid/Carousel layouts, custom play overlays, inline playback, and full-screen popup modal.
 * Version:           1.6.0
 * Author:            Developer Zahir
 * Author URI:        https://developerzahir.com
 * Text Domain:       wp-social-reels-pro
 * Domain Path:       /languages
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Elementor tested up to: 3.25.0
 *
 * @package           WPSocialReelsPro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Plugin Constants
 */
define( 'WP_SOCIAL_REELS_VERSION', '1.6.0' );
define( 'WP_SOCIAL_REELS_FILE', __FILE__ );
define( 'WP_SOCIAL_REELS_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_SOCIAL_REELS_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_SOCIAL_REELS_ASSETS_URL', WP_SOCIAL_REELS_URL . 'assets/' );

/**
 * Include the core plugin class.
 */
require_once WP_SOCIAL_REELS_PATH . 'includes/class-plugin.php';

/**
 * Bootstrap the plugin.
 */
function wp_social_reels_pro_init() {
	\WPSocialReelsPro\Plugin::instance();
}
add_action( 'plugins_loaded', 'wp_social_reels_pro_init' );
