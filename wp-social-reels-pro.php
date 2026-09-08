<?php
/**
 * Plugin Name:       WP Social Reels Pro
 * Plugin URI:        https://developerzahir.com
 * Description:       A high-performance, interactive Social Video Reels Elementor Addon with Grid/Carousel layouts, custom play overlays, inline playback, and full-screen popup modal.
 * Version:           1.6.8
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
define( 'WP_SOCIAL_REELS_VERSION', '1.6.8' );
define( 'WP_SOCIAL_REELS_FILE', __FILE__ );
define( 'WP_SOCIAL_REELS_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_SOCIAL_REELS_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_SOCIAL_REELS_ASSETS_URL', WP_SOCIAL_REELS_URL . 'assets/' );

/**
 * Global update checker instance
 */
global $wpsr_update_checker;

/**
 * Initialize GitHub Auto-Update via Plugin Update Checker (PUC v5)
 */
if ( file_exists( WP_SOCIAL_REELS_PATH . 'includes/plugin-update-checker/plugin-update-checker.php' ) ) {
	require_once WP_SOCIAL_REELS_PATH . 'includes/plugin-update-checker/plugin-update-checker.php';

	$wpsr_update_checker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
		'https://github.com/developer-zahir/wp-social-reels-pro',
		__FILE__,
		'wp-social-reels-pro'
	);

	// Set the stable repository branch
	$wpsr_update_checker->setBranch( 'main' );

	/**
	 * Display a prominent admin notification banner whenever a new update is available
	 */
	add_action( 'admin_notices', 'wp_social_reels_pro_update_notice' );
}

/**
 * Render update notice banner in WordPress admin when an update is detected
 */
function wp_social_reels_pro_update_notice() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}

	global $wpsr_update_checker;
	if ( empty( $wpsr_update_checker ) || ! is_object( $wpsr_update_checker ) ) {
		return;
	}

	$update = $wpsr_update_checker->getUpdate();
	if ( empty( $update ) || empty( $update->version ) ) {
		return;
	}

	if ( version_compare( $update->version, WP_SOCIAL_REELS_VERSION, '<=' ) ) {
		return;
	}

	$plugin_file   = plugin_basename( WP_SOCIAL_REELS_FILE );
	$update_url    = wp_nonce_url(
		self_admin_url( 'update.php?action=upgrade-plugin&plugin=' . $plugin_file ),
		'upgrade-plugin_' . $plugin_file
	);
	$changelog_url = ! empty( $update->details_url ) ? $update->details_url : 'https://github.com/developer-zahir/wp-social-reels-pro';
	?>
	<div class="notice notice-warning is-dismissible wpsr-update-notice" style="border-left-color: #ff6a00; padding: 14px 18px; margin: 15px 0; background: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06); border-radius: 4px;">
		<div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
			<div style="flex: 1 1 60%; min-width: 260px;">
				<h4 style="margin: 0 0 4px 0; font-size: 14.5px; font-weight: 700; color: #1d2327; display: flex; align-items: center; gap: 6px;">
					<span>🔔</span> <?php esc_html_e( 'WP Social Reels Pro: New Version Available!', 'wp-social-reels-pro' ); ?>
					<span style="display: inline-block; background: #e7f5ea; color: #1e7e34; font-size: 12px; font-weight: 700; padding: 2px 8px; border-radius: 12px; border: 1px solid #c3e6cb;">v<?php echo esc_html( $update->version ); ?></span>
				</h4>
				<p style="margin: 0; color: #50575e; font-size: 13px; line-height: 1.4;">
					<?php
					printf(
						/* translators: 1: Current version, 2: New version */
						esc_html__( 'You are currently running version %1$s. Update to %2$s to get the latest features, security improvements, and bug fixes.', 'wp-social-reels-pro' ),
						'<strong>v' . esc_html( WP_SOCIAL_REELS_VERSION ) . '</strong>',
						'<strong>v' . esc_html( $update->version ) . '</strong>'
					);
					?>
				</p>
			</div>
			<div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
				<a href="<?php echo esc_url( $update_url ); ?>" class="button button-primary" style="background: #ff6a00; border-color: #e55e00; text-shadow: none; font-weight: 600; padding: 4px 14px; height: auto;">
					⚡ <?php esc_html_e( 'Update Now', 'wp-social-reels-pro' ); ?>
				</a>
				<a href="<?php echo esc_url( $changelog_url ); ?>" target="_blank" rel="noopener noreferrer" class="button button-secondary" style="font-weight: 600; padding: 4px 12px; height: auto;">
					<?php esc_html_e( 'View Details', 'wp-social-reels-pro' ); ?>
				</a>
			</div>
		</div>
	</div>
	<?php
}

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


