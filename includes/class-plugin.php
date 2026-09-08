<?php
namespace WPSocialReelsPro;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Plugin
 *
 * Main Plugin class handler for WP Social Reels Pro.
 */
final class Plugin {

	/**
	 * Minimum Elementor Version required.
	 *
	 * @var string
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.5.0';

	/**
	 * Minimum PHP Version required.
	 *
	 * @var string
	 */
	const MINIMUM_PHP_VERSION = '7.4';

	/**
	 * Instance
	 *
	 * @var Plugin|null
	 */
	private static $instance = null;

	/**
	 * Get instance.
	 *
	 * @return Plugin
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->init_hooks();
	}

	/**
	 * Hook into WordPress & Elementor lifecycles.
	 */
	private function init_hooks() {
		add_action( 'init', [ $this, 'i18n' ] );

		// Check compatibility
		if ( ! $this->is_compatible() ) {
			return;
		}

		// Register custom Elementor Category
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_elementor_categories' ] );

		// Register Widget
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		// Legacy support for older Elementor versions (<3.5)
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets_legacy' ] );

		// Enqueue scripts & styles
		add_action( 'wp_enqueue_scripts', [ $this, 'register_frontend_assets' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_frontend_styles' ] );
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'enqueue_frontend_scripts' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
	}

	/**
	 * Load text domain for translations.
	 */
	public function i18n() {
		load_plugin_textdomain( 'wp-social-reels-pro', false, dirname( plugin_basename( WP_SOCIAL_REELS_FILE ) ) . '/languages' );
	}

	/**
	 * Compatibility checks for PHP and Elementor.
	 *
	 * @return bool
	 */
	public function is_compatible() {
		// Check if Elementor is installed & active
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_elementor' ] );
			return false;
		}

		// Check Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Check PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}

		return true;
	}

	/**
	 * Notice: Elementor missing.
	 */
	public function admin_notice_missing_elementor() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'wp-social-reels-pro' ),
			'<strong>' . esc_html__( 'WP Social Reels Pro', 'wp-social-reels-pro' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'wp-social-reels-pro' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Notice: Minimum Elementor version required.
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'wp-social-reels-pro' ),
			'<strong>' . esc_html__( 'WP Social Reels Pro', 'wp-social-reels-pro' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'wp-social-reels-pro' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Notice: Minimum PHP version required.
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'wp-social-reels-pro' ),
			'<strong>' . esc_html__( 'WP Social Reels Pro', 'wp-social-reels-pro' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'wp-social-reels-pro' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Register Custom Elementor Category.
	 *
	 * @param \Elementor\Elements_Manager $elements_manager
	 */
	public function register_elementor_categories( $elements_manager ) {
		$elements_manager->add_category(
			'wp-social-reels',
			[
				'title' => esc_html__( 'Social Reels Pro', 'wp-social-reels-pro' ),
				'icon'  => 'fa fa-play-circle',
			]
		);
	}

	/**
	 * Register all widget scripts and styles using Elementor's native bundled assets (No external CDNs).
	 */
	public function register_frontend_assets() {
		$ver = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? time() : WP_SOCIAL_REELS_VERSION;

		// Resolve native Elementor Swiper style dependency
		$style_deps = [];
		if ( wp_style_is( 'swiper', 'registered' ) ) {
			$style_deps[] = 'swiper';
		} elseif ( wp_style_is( 'e-swiper', 'registered' ) ) {
			$style_deps[] = 'e-swiper';
		}

		// Resolve native Elementor Swiper and jQuery script dependencies
		$script_deps = [ 'jquery' ];
		if ( wp_script_is( 'swiper', 'registered' ) ) {
			$script_deps[] = 'swiper';
		} elseif ( wp_script_is( 'e-swiper', 'registered' ) ) {
			$script_deps[] = 'e-swiper';
		}

		if ( wp_script_is( 'elementor-frontend', 'registered' ) ) {
			$script_deps[] = 'elementor-frontend';
		}

		// Plugin Custom CSS
		wp_register_style(
			'wp-social-reels-frontend',
			WP_SOCIAL_REELS_ASSETS_URL . 'css/social-reels-frontend.css',
			$style_deps,
			$ver
		);

		// Plugin Custom JS
		wp_register_script(
			'wp-social-reels-frontend',
			WP_SOCIAL_REELS_ASSETS_URL . 'js/social-reels-frontend.js',
			$script_deps,
			$ver,
			true
		);

		// Localize script data for frontend
		wp_localize_script(
			'wp-social-reels-frontend',
			'WPSocialReelsData',
			[
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'i18n'    => [
					'close'    => esc_html__( 'Close Video', 'wp-social-reels-pro' ),
					'viewPost' => esc_html__( 'View post', 'wp-social-reels-pro' ),
				],
			]
		);
	}

	/**
	 * Enqueue frontend styles.
	 */
	public function enqueue_frontend_styles() {
		wp_enqueue_style( 'wp-social-reels-frontend' );
	}

	/**
	 * Enqueue frontend scripts.
	 */
	public function enqueue_frontend_scripts() {
		wp_enqueue_script( 'wp-social-reels-frontend' );
	}

	/**
	 * Enqueue editor assets.
	 */
	public function enqueue_editor_scripts() {
		wp_enqueue_style( 'wp-social-reels-frontend' );
		wp_enqueue_script( 'wp-social-reels-frontend' );
	}

	/**
	 * Register Widget with Elementor 3.5+.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager
	 */
	public function register_widgets( $widgets_manager ) {
		require_once WP_SOCIAL_REELS_PATH . 'includes/widgets/class-social-video-reels-widget.php';
		$widgets_manager->register( new Widgets\Social_Video_Reels_Widget() );
	}

	/**
	 * Legacy Widget Registration.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager
	 */
	public function register_widgets_legacy( $widgets_manager ) {
		if ( method_exists( $widgets_manager, 'register_widget_type' ) ) {
			require_once WP_SOCIAL_REELS_PATH . 'includes/widgets/class-social-video-reels-widget.php';
			$widgets_manager->register_widget_type( new Widgets\Social_Video_Reels_Widget() );
		}
	}
}
