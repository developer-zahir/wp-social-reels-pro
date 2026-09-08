<?php
namespace WPSocialReelsPro\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Social_Video_Reels_Widget
 *
 * Elementor widget for interactive social video reels with Global Profile Settings,
 * Grid/Carousel layouts, Audio toggle, and Full-Screen Popup Modal Player.
 */
class Social_Video_Reels_Widget extends Widget_Base {

	/**
	 * Widget Name
	 */
	public function get_name() {
		return 'wp_social_video_reels';
	}

	/**
	 * Widget Title
	 */
	public function get_title() {
		return esc_html__( 'Social Video Reels', 'wp-social-reels-pro' );
	}

	/**
	 * Widget Icon
	 */
	public function get_icon() {
		return 'eicon-play';
	}

	/**
	 * Widget Categories
	 */
	public function get_categories() {
		return [ 'wp-social-reels', 'general' ];
	}

	/**
	 * Widget Keywords
	 */
	public function get_keywords() {
		return [ 'reel', 'reels', 'video', 'social', 'tiktok', 'instagram', 'shorts', 'carousel', 'grid', 'popup', 'media', 'feed' ];
	}

	/**
	 * Script Dependencies
	 */
	public function get_script_depends() {
		return [ 'swiper', 'wp-social-reels-frontend' ];
	}

	/**
	 * Style Dependencies
	 */
	public function get_style_depends() {
		return [ 'swiper', 'wp-social-reels-frontend' ];
	}

	/**
	 * Register Widget Controls
	 */
	protected function register_controls() {
		$this->register_global_profile_controls();
		$this->register_reels_items_controls();
		$this->register_layout_controls();
		$this->register_carousel_controls();
		$this->register_video_controls();

		// Style Tabs
		$this->register_style_card_controls();
		$this->register_style_top_right_badge_controls();
		$this->register_style_play_btn_controls();
		$this->register_style_sound_btn_controls();
		$this->register_style_profile_controls();
		$this->register_style_view_post_controls();
		$this->register_style_engagement_controls();
		$this->register_style_carousel_nav_controls();
		$this->register_style_modal_controls();
	}

	/**
	 * Content Tab: Global Social Profile Settings
	 */
	protected function register_global_profile_controls() {
		$this->start_controls_section(
			'section_global_profile',
			[
				'label' => esc_html__( 'Global Social Profile Settings', 'wp-social-reels-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'global_profile_avatar',
			[
				'label'       => esc_html__( 'Profile Avatar Image', 'wp-social-reels-pro' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Avatar displayed across all reel cards and popup modal.', 'wp-social-reels-pro' ),
			]
		);

		$this->add_control(
			'global_profile_name',
			[
				'label'       => esc_html__( 'Profile / Page Name', 'wp-social-reels-pro' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Run on GSC',
				'placeholder' => 'Brand / Page Name',
				'label_block' => true,
			]
		);

		$this->add_control(
			'global_profile_handle',
			[
				'label'       => esc_html__( 'Username / Handle', 'wp-social-reels-pro' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'timecliq.watches',
				'placeholder' => 'timecliq.watches',
				'label_block' => true,
			]
		);

		$this->add_control(
			'global_profile_url',
			[
				'label'       => esc_html__( 'Social Profile / Post URL', 'wp-social-reels-pro' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://instagram.com/yourpage',
				'default'     => [
					'url'         => 'https://instagram.com',
					'is_external' => true,
					'nofollow'    => true,
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'profile_info_visibility',
			[
				'label'   => esc_html__( 'Profile Info Visibility', 'wp-social-reels-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'always',
				'options' => [
					'always'     => esc_html__( 'Always Visible', 'wp-social-reels-pro' ),
					'on_hover'   => esc_html__( 'Show on Hover', 'wp-social-reels-pro' ),
					'modal_only' => esc_html__( 'Modal Only', 'wp-social-reels-pro' ),
					'card_only'  => esc_html__( 'Card Only', 'wp-social-reels-pro' ),
					'none'       => esc_html__( 'Hidden Everywhere', 'wp-social-reels-pro' ),
				],
			]
		);

		$this->add_control(
			'heading_top_right_icon',
			[
				'label'     => esc_html__( 'Top-Right Social Icon', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_top_right_icon',
			[
				'label'        => esc_html__( 'Show Social Icon', 'wp-social-reels-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'wp-social-reels-pro' ),
				'label_off'    => esc_html__( 'No', 'wp-social-reels-pro' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'card_social_icon',
			[
				'label'       => esc_html__( 'Social Icon Picker', 'wp-social-reels-pro' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fab fa-instagram',
					'library' => 'fa-brands',
				],
				'condition'   => [
					'show_top_right_icon' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_modal_view_post',
			[
				'label'     => esc_html__( 'Modal View Post Button', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'view_post_display',
			[
				'label'   => esc_html__( 'Display Style', 'wp-social-reels-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'text_icon',
				'options' => [
					'text_icon' => esc_html__( 'Text & Icon', 'wp-social-reels-pro' ),
					'text_only' => esc_html__( 'Text Only', 'wp-social-reels-pro' ),
					'icon_only' => esc_html__( 'Icon Only', 'wp-social-reels-pro' ),
				],
			]
		);

		$this->add_control(
			'view_post_label',
			[
				'label'       => esc_html__( 'Button Text', 'wp-social-reels-pro' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'View Post', 'wp-social-reels-pro' ),
				'placeholder' => esc_html__( 'View Post', 'wp-social-reels-pro' ),
				'condition'   => [
					'view_post_display!' => 'icon_only',
				],
			]
		);

		$this->add_control(
			'view_post_icon',
			[
				'label'       => esc_html__( 'Button Icon', 'wp-social-reels-pro' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
					'value'   => 'fas fa-external-link-alt',
					'library' => 'fa-solid',
				],
				'condition'   => [
					'view_post_display!' => 'text_only',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content Tab: Reels Items Repeater (No redundant individual profile fields)
	 */
	protected function register_reels_items_controls() {
		$this->start_controls_section(
			'section_reels_items',
			[
				'label' => esc_html__( 'Reels Video Items', 'wp-social-reels-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'video_type',
			[
				'label'   => esc_html__( 'Video Source Type', 'wp-social-reels-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'self_hosted',
				'options' => [
					'self_hosted' => esc_html__( 'Media Library Upload', 'wp-social-reels-pro' ),
					'external'    => esc_html__( 'External Video URL (MP4/WebM)', 'wp-social-reels-pro' ),
				],
			]
		);

		$repeater->add_control(
			'video_file',
			[
				'label'       => esc_html__( 'Upload Video', 'wp-social-reels-pro' ),
				'type'        => Controls_Manager::MEDIA,
				'media_types' => [ 'video' ],
				'description' => esc_html__( 'Upload vertical MP4 or WebM video (9:16 recommended).', 'wp-social-reels-pro' ),
				'condition'   => [
					'video_type' => 'self_hosted',
				],
			]
		);

		$repeater->add_control(
			'video_url',
			[
				'label'         => esc_html__( 'Video URL', 'wp-social-reels-pro' ),
				'type'          => Controls_Manager::TEXT,
				'placeholder'   => 'https://assets.mixkit.co/videos/preview/mixkit-girl-in-neon-light-1230-large.mp4',
				'label_block'   => true,
				'condition'     => [
					'video_type' => 'external',
				],
			]
		);

		$repeater->add_control(
			'video_poster',
			[
				'label'       => esc_html__( 'Video Poster / Thumbnail Image', 'wp-social-reels-pro' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Thumbnail displayed before playback starts (or when autoplay is off).', 'wp-social-reels-pro' ),
			]
		);

		$repeater->add_control(
			'likes_count',
			[
				'label'   => esc_html__( 'Likes Count', 'wp-social-reels-pro' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 0,
			]
		);

		$repeater->add_control(
			'comments_count',
			[
				'label'   => esc_html__( 'Comments Count', 'wp-social-reels-pro' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 0,
				'min'     => 0,
			]
		);

		$repeater->add_control(
			'caption',
			[
				'label'       => esc_html__( 'Reel Title / Caption', 'wp-social-reels-pro' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => '',
				'placeholder' => esc_html__( 'Enter reel title or caption...', 'wp-social-reels-pro' ),
			]
		);

		$this->add_control(
			'reels_list',
			[
				'label'       => esc_html__( 'Reels Video Items', 'wp-social-reels-pro' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ caption ? caption : "Reel Video" }}} ({{{ likes_count }}} Likes)',
				'default'     => [
					[
						'video_type'     => 'external',
						'video_url'      => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
						'likes_count'    => 3,
						'comments_count' => 0,
						'caption'        => '',
					],
					[
						'video_type'     => 'external',
						'video_url'      => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerEscapes.mp4',
						'likes_count'    => 11,
						'comments_count' => 0,
						'caption'        => '',
					],
					[
						'video_type'     => 'external',
						'video_url'      => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4',
						'likes_count'    => 24,
						'comments_count' => 2,
						'caption'        => '',
					],
					[
						'video_type'     => 'external',
						'video_url'      => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerJoyBlazes.mp4',
						'likes_count'    => 18,
						'comments_count' => 1,
						'caption'        => '',
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content Tab: Layout & Structure Controls
	 */
	protected function register_layout_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout & Structure', 'wp-social-reels-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'layout_type',
			[
				'label'   => esc_html__( 'Layout Type', 'wp-social-reels-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'carousel',
				'options' => [
					'grid'     => esc_html__( 'Grid', 'wp-social-reels-pro' ),
					'carousel' => esc_html__( 'Carousel / Slider', 'wp-social-reels-pro' ),
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'          => esc_html__( 'Grid Columns', 'wp-social-reels-pro' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '4',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'selectors'      => [
					'{{WRAPPER}} .wpsr-grid-container' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
				'condition'      => [
					'layout_type' => 'grid',
				],
			]
		);

		$this->add_responsive_control(
			'carousel_slides_per_view',
			[
				'label'          => esc_html__( 'Slides Per View', 'wp-social-reels-pro' ),
				'type'           => Controls_Manager::NUMBER,
				'default'        => 4,
				'tablet_default' => 2,
				'mobile_default' => 1.2,
				'min'            => 1,
				'max'            => 8,
				'step'           => 0.1,
				'condition'      => [
					'layout_type' => 'carousel',
				],
			]
		);

		$this->add_responsive_control(
			'items_gap',
			[
				'label'      => esc_html__( 'Card Gap / Spacing', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 20,
				],
				'tablet_default' => [
					'unit' => 'px',
					'size' => 16,
				],
				'mobile_default' => [
					'unit' => 'px',
					'size' => 12,
				],
				'selectors'  => [
					'{{WRAPPER}} .wpsr-grid-container'     => 'gap: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpsr-carousel-container' => '--wpsr-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'aspect_ratio',
			[
				'label'   => esc_html__( 'Card Aspect Ratio', 'wp-social-reels-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '9_16',
				'options' => [
					'9_16'   => esc_html__( 'Vertical Reels (9:16)', 'wp-social-reels-pro' ),
					'4_5'    => esc_html__( 'Portrait (4:5)', 'wp-social-reels-pro' ),
					'1_1'    => esc_html__( 'Square (1:1)', 'wp-social-reels-pro' ),
					'16_9'   => esc_html__( 'Landscape (16:9)', 'wp-social-reels-pro' ),
					'custom' => esc_html__( 'Custom Height', 'wp-social-reels-pro' ),
				],
			]
		);

		$this->add_responsive_control(
			'custom_card_height',
			[
				'label'      => esc_html__( 'Custom Height', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [
						'min' => 200,
						'max' => 900,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 540,
				],
				'selectors'  => [
					'{{WRAPPER}} .wpsr-reel-card' => 'height: {{SIZE}}{{UNIT}}; aspect-ratio: unset;',
				],
				'condition'  => [
					'aspect_ratio' => 'custom',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content Tab: Carousel Settings
	 */
	protected function register_carousel_controls() {
		$this->start_controls_section(
			'section_carousel_settings',
			[
				'label'     => esc_html__( 'Carousel Settings', 'wp-social-reels-pro' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout_type' => 'carousel',
				],
			]
		);

		$this->add_control(
			'carousel_autoplay',
			[
				'label'        => esc_html__( 'Autoplay Slider', 'wp-social-reels-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'wp-social-reels-pro' ),
				'label_off'    => esc_html__( 'No', 'wp-social-reels-pro' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'carousel_autoplay_speed',
			[
				'label'     => esc_html__( 'Autoplay Speed (ms)', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 4000,
				'min'       => 1000,
				'step'      => 500,
				'condition' => [
					'carousel_autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'carousel_loop',
			[
				'label'        => esc_html__( 'Infinite Loop', 'wp-social-reels-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'wp-social-reels-pro' ),
				'label_off'    => esc_html__( 'No', 'wp-social-reels-pro' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_responsive_control(
			'carousel_arrows',
			[
				'label'                => esc_html__( 'Navigation Arrows', 'wp-social-reels-pro' ),
				'type'                 => Controls_Manager::SWITCHER,
				'label_on'             => esc_html__( 'Show', 'wp-social-reels-pro' ),
				'label_off'            => esc_html__( 'Hide', 'wp-social-reels-pro' ),
				'return_value'         => 'yes',
				'default'              => 'yes',
				'tablet_default'       => 'yes',
				'mobile_default'       => 'yes',
				'selectors_dictionary' => [
					'yes' => 'display: flex !important;',
					''    => 'display: none !important;',
				],
				'selectors'            => [
					'{{WRAPPER}} .wpsr-nav-arrow' => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'carousel_pagination',
			[
				'label'                => esc_html__( 'Pagination Dots', 'wp-social-reels-pro' ),
				'type'                 => Controls_Manager::SWITCHER,
				'label_on'             => esc_html__( 'Show', 'wp-social-reels-pro' ),
				'label_off'            => esc_html__( 'Hide', 'wp-social-reels-pro' ),
				'return_value'         => 'yes',
				'default'              => '',
				'tablet_default'       => '',
				'mobile_default'       => '',
				'selectors_dictionary' => [
					'yes' => 'display: block !important;',
					''    => 'display: none !important;',
				],
				'selectors'            => [
					'{{WRAPPER}} .wpsr-pagination' => '{{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Content Tab: Video Player & Audio Overlay Settings
	 */
	protected function register_video_controls() {
		$this->start_controls_section(
			'section_video_settings',
			[
				'label' => esc_html__( 'Video Player & Overlays', 'wp-social-reels-pro' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'video_autoplay',
			[
				'label'        => esc_html__( 'Video Auto-play (Muted)', 'wp-social-reels-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'ON', 'wp-social-reels-pro' ),
				'label_off'    => esc_html__( 'OFF', 'wp-social-reels-pro' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => esc_html__( 'When ON, videos auto-play (muted). When OFF, thumbnail poster sits on top until clicked.', 'wp-social-reels-pro' ),
			]
		);

		$this->add_control(
			'show_play_btn',
			[
				'label'        => esc_html__( 'Show Centered Play Button', 'wp-social-reels-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'wp-social-reels-pro' ),
				'label_off'    => esc_html__( 'No', 'wp-social-reels-pro' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'play_icon',
			[
				'label'     => esc_html__( 'Play Icon', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-play',
					'library' => 'fa-solid',
				],
				'condition' => [
					'show_play_btn' => 'yes',
				],
			]
		);

		$this->add_control(
			'enable_modal_popup',
			[
				'label'        => esc_html__( 'Enable Full-Screen Popup Modal', 'wp-social-reels-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'wp-social-reels-pro' ),
				'label_off'    => esc_html__( 'No', 'wp-social-reels-pro' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Card Wrapper & Overlay (Zero default box-shadow & no hover scaling)
	 */
	protected function register_style_card_controls() {
		$this->start_controls_section(
			'section_style_card',
			[
				'label' => esc_html__( 'Reels Card & Overlay', 'wp-social-reels-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'default'    => [
					'top'      => '18',
					'right'    => '18',
					'bottom'   => '18',
					'left'     => '18',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .wpsr-reel-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .wpsr-reel-card',
			]
		);

		$this->start_controls_tabs( 'tabs_card_style' );

		// Card Normal Tab
		$this->start_controls_tab(
			'tab_card_normal',
			[
				'label' => esc_html__( 'Normal', 'wp-social-reels-pro' ),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .wpsr-reel-card',
			]
		);

		$this->add_control(
			'overlay_gradient_color',
			[
				'label'     => esc_html__( 'Overlay Shade Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0.85)',
				'selectors' => [
					'{{WRAPPER}} .wpsr-reel-card' => '--wpsr-overlay-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Card Hover Tab
		$this->start_controls_tab(
			'tab_card_hover',
			[
				'label' => esc_html__( 'Hover', 'wp-social-reels-pro' ),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow_hover',
				'selector' => '{{WRAPPER}} .wpsr-reel-card:hover',
			]
		);

		$this->add_control(
			'overlay_gradient_color_hover',
			[
				'label'     => esc_html__( 'Overlay Shade Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpsr-reel-card:hover' => '--wpsr-overlay-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Top-Right Social Icon Styling
	 */
	protected function register_style_top_right_badge_controls() {
		$this->start_controls_section(
			'section_style_top_right_badge',
			[
				'label'     => esc_html__( 'Top-Right Social Icon', 'wp-social-reels-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_top_right_icon' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'badge_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 50,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 18,
				],
				'selectors'  => [
					'{{WRAPPER}} .wpsr-social-icon-link i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpsr-social-icon-link svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_badge_style' );

		// Normal Tab
		$this->start_controls_tab(
			'tab_badge_normal',
			[
				'label' => esc_html__( 'Normal', 'wp-social-reels-pro' ),
			]
		);

		$this->add_control(
			'badge_color',
			[
				'label'     => esc_html__( 'Icon Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wpsr-social-icon-link'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpsr-social-icon-link svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => [
					'{{WRAPPER}} .wpsr-social-icon-link' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'badge_box_shadow',
				'selector' => '{{WRAPPER}} .wpsr-social-icon-link',
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_badge_hover',
			[
				'label' => esc_html__( 'Hover', 'wp-social-reels-pro' ),
			]
		);

		$this->add_control(
			'badge_hover_color',
			[
				'label'     => esc_html__( 'Hover Icon Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f3f4f6',
				'selectors' => [
					'{{WRAPPER}} .wpsr-social-icon-link:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpsr-social-icon-link:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_hover_bg_color',
			[
				'label'     => esc_html__( 'Hover Background Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => [
					'{{WRAPPER}} .wpsr-social-icon-link:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'badge_box_shadow_hover',
				'selector' => '{{WRAPPER}} .wpsr-social-icon-link:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'badge_border',
				'selector'  => '{{WRAPPER}} .wpsr-social-icon-link',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'badge_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wpsr-social-icon-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label'      => esc_html__( 'Padding', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wpsr-social-icon-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Play Button Styling
	 */
	protected function register_style_play_btn_controls() {
		$this->start_controls_section(
			'section_style_play_btn',
			[
				'label'     => esc_html__( 'Play Button', 'wp-social-reels-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_play_btn' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'play_btn_size',
			[
				'label'      => esc_html__( 'Button Size', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 20,
						'max' => 120,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 35,
				],
				'selectors'  => [
					'{{WRAPPER}} .wpsr-play-btn' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'play_btn_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 8,
						'max' => 60,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 12,
				],
				'selectors'  => [
					'{{WRAPPER}} .wpsr-play-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .wpsr-play-btn i'   => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_play_btn_style' );

		// Normal Tab
		$this->start_controls_tab(
			'tab_play_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'wp-social-reels-pro' ),
			]
		);

		$this->add_control(
			'play_btn_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => [
					'{{WRAPPER}} .wpsr-play-btn'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpsr-play-btn svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'play_btn_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wpsr-play-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'play_btn_box_shadow',
				'selector' => '{{WRAPPER}} .wpsr-play-btn',
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_play_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'wp-social-reels-pro' ),
			]
		);

		$this->add_control(
			'play_btn_icon_hover_color',
			[
				'label'     => esc_html__( 'Icon Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => [
					'{{WRAPPER}} .wpsr-reel-card:hover .wpsr-play-btn'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpsr-reel-card:hover .wpsr-play-btn svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'play_btn_bg_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wpsr-reel-card:hover .wpsr-play-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'play_btn_box_shadow_hover',
				'selector' => '{{WRAPPER}} .wpsr-reel-card:hover .wpsr-play-btn',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'play_btn_border',
				'selector'  => '{{WRAPPER}} .wpsr-play-btn',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'play_btn_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '50',
					'right'    => '50',
					'bottom'   => '50',
					'left'     => '50',
					'unit'     => '%',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .wpsr-play-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Modal Audio / Sound Button Styling (Desktop)
	 */
	protected function register_style_sound_btn_controls() {
		$this->start_controls_section(
			'section_style_sound_btn',
			[
				'label' => esc_html__( 'Audio / Speaker Button (Desktop)', 'wp-social-reels-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'card_sound_btn_size',
			[
				'label'      => esc_html__( 'Button Size', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 24,
						'max' => 60,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 36,
				],
				'selectors'  => [
					'body div#wpsr-global-modal .wpsr-modal-sound-btn' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important; min-width: {{SIZE}}{{UNIT}} !important; min-height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'card_sound_btn_icon_size',
			[
				'label'      => esc_html__( 'Speaker Icon Size', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 36,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors'  => [
					'body div#wpsr-global-modal .wpsr-modal-sound-btn svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_sound_btn_style' );

		// Normal Tab
		$this->start_controls_tab(
			'tab_sound_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'wp-social-reels-pro' ),
			]
		);

		$this->add_control(
			'card_sound_btn_color',
			[
				'label'     => esc_html__( 'Icon Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'body div#wpsr-global-modal .wpsr-modal-sound-btn'     => 'color: {{VALUE}} !important;',
					'body div#wpsr-global-modal .wpsr-modal-sound-btn svg' => 'fill: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'card_sound_btn_bg',
			[
				'label'     => esc_html__( 'Background Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#7D797970',
				'selectors' => [
					'body div#wpsr-global-modal .wpsr-modal-sound-btn' => 'background-color: {{VALUE}} !important; background: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_sound_btn_box_shadow',
				'selector' => 'body div#wpsr-global-modal .wpsr-modal-sound-btn',
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_sound_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'wp-social-reels-pro' ),
			]
		);

		$this->add_control(
			'card_sound_btn_hover_color',
			[
				'label'     => esc_html__( 'Hover Icon Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'body div#wpsr-global-modal .wpsr-modal-sound-btn:hover'     => 'color: {{VALUE}} !important;',
					'body div#wpsr-global-modal .wpsr-modal-sound-btn:hover svg' => 'fill: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'card_sound_btn_hover_bg',
			[
				'label'     => esc_html__( 'Hover Background Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#7D797970',
				'selectors' => [
					'body div#wpsr-global-modal .wpsr-modal-sound-btn:hover' => 'background-color: {{VALUE}} !important; background: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_sound_btn_box_shadow_hover',
				'selector' => 'body div#wpsr-global-modal .wpsr-modal-sound-btn:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'card_sound_btn_border',
				'selector'  => 'body div#wpsr-global-modal .wpsr-modal-sound-btn',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'card_sound_btn_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '50',
					'right'    => '50',
					'bottom'   => '50',
					'left'     => '50',
					'unit'     => '%',
					'isLinked' => true,
				],
				'selectors'  => [
					'body div#wpsr-global-modal .wpsr-modal-sound-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();
	}


	/**
	 * Style Tab: Profile Details Styling
	 */
	protected function register_style_profile_controls() {
		$this->start_controls_section(
			'section_style_profile',
			[
				'label' => esc_html__( 'Profile Info Styling', 'wp-social-reels-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'avatar_size',
			[
				'label'      => esc_html__( 'Avatar Size', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range'      => [
					'px' => [
						'min' => 20,
						'max' => 60,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 32,
				],
				'selectors'  => [
					'{{WRAPPER}} .wpsr-avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'body .wpsr-modal-avatar'  => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_border_radius',
			[
				'label'      => esc_html__( 'Avatar Border Radius', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'default'    => [
					'top'      => '5',
					'right'    => '5',
					'bottom'   => '5',
					'left'     => '5',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .wpsr-avatar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'body .wpsr-modal-avatar'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'avatar_border',
				'selector' => '{{WRAPPER}} .wpsr-avatar, body .wpsr-modal-avatar',
			]
		);

		$this->add_control(
			'heading_profile_name_style',
			[
				'label'     => esc_html__( 'Profile Name', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'profile_name_color',
			[
				'label'     => esc_html__( 'Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wpsr-profile-name' => 'color: {{VALUE}};',
					'body .wpsr-modal-name'          => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'profile_name_typography',
				'selector' => '{{WRAPPER}} .wpsr-profile-name, body .wpsr-modal-name',
			]
		);

		$this->add_control(
			'heading_profile_handle_style',
			[
				'label'     => esc_html__( 'Username / Handle', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'profile_handle_color',
			[
				'label'     => esc_html__( 'Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.75)',
				'selectors' => [
					'{{WRAPPER}} .wpsr-profile-handle' => 'color: {{VALUE}};',
					'body .wpsr-modal-handle'          => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'profile_handle_typography',
				'selector' => '{{WRAPPER}} .wpsr-profile-handle, body .wpsr-modal-handle',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: View Post Button & Link Styling
	 */
	protected function register_style_view_post_controls() {
		$this->start_controls_section(
			'section_style_view_post_btn',
			[
				'label' => esc_html__( 'View Post Button / Link', 'wp-social-reels-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'view_post_typography',
				'selector' => 'body .wpsr-modal-view-post, body .wpsr-modal-view-text',
			]
		);

		$this->add_responsive_control(
			'view_post_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 40,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 13,
				],
				'selectors'  => [
					'body .wpsr-modal-view-post svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
					'body .wpsr-modal-view-post i'   => 'font-size: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'view_post_gap',
			[
				'label'      => esc_html__( 'Icon & Text Gap', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 6,
				],
				'selectors'  => [
					'body .wpsr-modal-view-post' => 'gap: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_view_post_style' );

		// Normal Tab
		$this->start_controls_tab(
			'tab_view_post_normal',
			[
				'label' => esc_html__( 'Normal', 'wp-social-reels-pro' ),
			]
		);

		$this->add_control(
			'view_post_color',
			[
				'label'     => esc_html__( 'Text & Icon Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'body .wpsr-modal-view-post'     => 'color: {{VALUE}} !important;',
					'body .wpsr-modal-view-post svg' => 'fill: {{VALUE}} !important; stroke: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'view_post_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => [
					'body .wpsr-modal-view-post' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'view_post_box_shadow',
				'selector' => 'body .wpsr-modal-view-post',
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_view_post_hover',
			[
				'label' => esc_html__( 'Hover', 'wp-social-reels-pro' ),
			]
		);

		$this->add_control(
			'view_post_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e2e8f0',
				'selectors' => [
					'body .wpsr-modal-view-post:hover'     => 'color: {{VALUE}} !important;',
					'body .wpsr-modal-view-post:hover svg' => 'fill: {{VALUE}} !important; stroke: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'view_post_hover_bg_color',
			[
				'label'     => esc_html__( 'Hover Background Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => [
					'body .wpsr-modal-view-post:hover' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'view_post_box_shadow_hover',
				'selector' => 'body .wpsr-modal-view-post:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'view_post_border',
				'selector'  => 'body .wpsr-modal-view-post',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'view_post_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'body .wpsr-modal-view-post' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'view_post_padding',
			[
				'label'      => esc_html__( 'Padding', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'body .wpsr-modal-view-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'view_post_text_decoration',
			[
				'label'     => esc_html__( 'Text Decoration', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => [
					'none'      => esc_html__( 'None', 'wp-social-reels-pro' ),
					'underline' => esc_html__( 'Underline', 'wp-social-reels-pro' ),
				],
				'selectors' => [
					'body .wpsr-modal-view-post' => 'text-decoration: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Engagement Stats & Caption Styling
	 */
	protected function register_style_engagement_controls() {
		$this->start_controls_section(
			'section_style_engagement',
			[
				'label' => esc_html__( 'Stats & Caption', 'wp-social-reels-pro' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'show_engagement_stats',
			[
				'label'        => esc_html__( 'Show Likes & Comments', 'wp-social-reels-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'wp-social-reels-pro' ),
				'label_off'    => esc_html__( 'No', 'wp-social-reels-pro' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_responsive_control(
			'stats_icon_size',
			[
				'label'      => esc_html__( 'Stats Icon Size', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 8,
						'max' => 40,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 13,
				],
				'selectors'  => [
					'{{WRAPPER}} .wpsr-stat-item svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'body .wpsr-modal-stat-item svg'  => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'show_engagement_stats' => 'yes',
				],
			]
		);

		$this->add_control(
			'stats_color',
			[
				'label'     => esc_html__( 'Stats Text / Icon Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wpsr-stat-item' => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpsr-stat-item svg' => 'stroke: {{VALUE}};',
					'body .wpsr-modal-stat-item' => 'color: {{VALUE}};',
					'body .wpsr-modal-stat-item svg' => 'stroke: {{VALUE}};',
				],
				'condition' => [
					'show_engagement_stats' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'stats_typography',
				'selector'  => '{{WRAPPER}} .wpsr-stat-item, body .wpsr-modal-stat-item',
				'condition' => [
					'show_engagement_stats' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_caption_style',
			[
				'label'     => esc_html__( 'Title / Caption', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_caption',
			[
				'label'        => esc_html__( 'Show Caption / Title', 'wp-social-reels-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'wp-social-reels-pro' ),
				'label_off'    => esc_html__( 'No', 'wp-social-reels-pro' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'caption_color',
			[
				'label'     => esc_html__( 'Caption Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wpsr-card-caption' => 'color: {{VALUE}};',
					'body .wpsr-modal-caption'       => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_caption' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'caption_typography',
				'selector'  => '{{WRAPPER}} .wpsr-card-caption, body .wpsr-modal-caption',
				'condition' => [
					'show_caption' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Carousel Arrows & Pagination Styling
	 */
	protected function register_style_carousel_nav_controls() {
		$this->start_controls_section(
			'section_style_carousel_nav',
			[
				'label'     => esc_html__( 'Carousel Navigation Arrows', 'wp-social-reels-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout_type' => 'carousel',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_size',
			[
				'label'      => esc_html__( 'Arrow Box Size', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 24,
						'max' => 70,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 44,
				],
				'selectors'  => [
					'{{WRAPPER}} .wpsr-nav-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; min-height: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}}; max-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_icon_size',
			[
				'label'      => esc_html__( 'Arrow Icon Size', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 12,
						'max' => 40,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors'  => [
					'{{WRAPPER}} .wpsr-nav-arrow svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .wpsr-nav-arrow i'   => 'font-size: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_arrow_style' );

		// Normal Tab
		$this->start_controls_tab(
			'tab_arrow_normal',
			[
				'label' => esc_html__( 'Normal', 'wp-social-reels-pro' ),
			]
		);

		$this->add_control(
			'arrow_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => [
					'{{WRAPPER}} .wpsr-nav-arrow'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpsr-nav-arrow svg' => 'stroke: {{VALUE}}; fill: none;',
				],
			]
		);

		$this->add_control(
			'arrow_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wpsr-nav-arrow' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'arrow_box_shadow',
				'selector' => '{{WRAPPER}} .wpsr-nav-arrow',
			]
		);

		$this->end_controls_tab();

		// Hover Tab
		$this->start_controls_tab(
			'tab_arrow_hover',
			[
				'label' => esc_html__( 'Hover', 'wp-social-reels-pro' ),
			]
		);

		$this->add_control(
			'arrow_hover_color',
			[
				'label'     => esc_html__( 'Hover Arrow Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => [
					'{{WRAPPER}} .wpsr-nav-arrow:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .wpsr-nav-arrow:hover svg' => 'stroke: {{VALUE}}; fill: none;',
				],
			]
		);

		$this->add_control(
			'arrow_bg_hover_color',
			[
				'label'     => esc_html__( 'Hover Background Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f3f4f6',
				'selectors' => [
					'{{WRAPPER}} .wpsr-nav-arrow:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'arrow_box_shadow_hover',
				'selector' => '{{WRAPPER}} .wpsr-nav-arrow:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'arrow_border',
				'selector'  => '{{WRAPPER}} .wpsr-nav-arrow',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'arrow_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '50',
					'right'    => '50',
					'bottom'   => '50',
					'left'     => '50',
					'unit'     => '%',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .wpsr-nav-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Tab: Full-screen Popup Modal Styling
	 */
	protected function register_style_modal_controls() {
		$this->start_controls_section(
			'section_style_modal',
			[
				'label'     => esc_html__( 'Popup Modal UI & Navigation', 'wp-social-reels-pro' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_modal_popup' => 'yes',
				],
			]
		);

		$this->add_control(
			'modal_backdrop_color',
			[
				'label'     => esc_html__( 'Backdrop Color', 'wp-social-reels-pro' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(15, 17, 21, 0.85)',
				'selectors' => [
					'body .wpsr-modal-overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'modal_blur_amount',
			[
				'label'      => esc_html__( 'Backdrop Blur (px)', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors'  => [
					'body .wpsr-modal-overlay' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_responsive_control(
			'modal_card_border_radius',
			[
				'label'      => esc_html__( 'Video Container Border Radius', 'wp-social-reels-pro' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'default'    => [
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'body .wpsr-modal-video-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render Widget Output on Frontend
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['reels_list'] ) ) {
			return;
		}

		$widget_id         = $this->get_id();
		$layout            = ! empty( $settings['layout_type'] ) ? $settings['layout_type'] : 'carousel';
		$aspect_ratio      = ! empty( $settings['aspect_ratio'] ) ? $settings['aspect_ratio'] : '9_16';
		$is_carousel       = ( 'carousel' === $layout );
		$is_modal_enabled  = ( ! empty( $settings['enable_modal_popup'] ) && 'yes' === $settings['enable_modal_popup'] );
		$video_autoplay    = ( ! empty( $settings['video_autoplay'] ) && 'yes' === $settings['video_autoplay'] );

		// Global Profile Details
		$global_avatar_url   = ! empty( $settings['global_profile_avatar']['url'] ) ? esc_url( $settings['global_profile_avatar']['url'] ) : '';
		$global_profile_name = ! empty( $settings['global_profile_name'] ) ? esc_html( $settings['global_profile_name'] ) : 'Run on GSC';
		$global_handle       = ! empty( $settings['global_profile_handle'] ) ? esc_html( $settings['global_profile_handle'] ) : 'timecliq.watches';
		$global_profile_url  = ! empty( $settings['global_profile_url']['url'] ) ? esc_url( $settings['global_profile_url']['url'] ) : '#';
		$profile_visibility  = ! empty( $settings['profile_info_visibility'] ) ? $settings['profile_info_visibility'] : 'always';

		// Resolve View Post Settings
		$view_post_display = ! empty( $settings['view_post_display'] ) ? $settings['view_post_display'] : 'text_icon';
		$view_post_label   = ! empty( $settings['view_post_label'] ) ? esc_html( $settings['view_post_label'] ) : 'View Post';
		$view_post_icon_val= ! empty( $settings['view_post_icon']['value'] ) ? $settings['view_post_icon'] : [ 'value' => 'fas fa-external-link-alt', 'library' => 'fa-solid' ];

		ob_start();
		Icons_Manager::render_icon( $view_post_icon_val, [ 'aria-hidden' => 'true' ] );
		$rendered_view_post_icon = ob_get_clean();

		$show_engagement_stats = ( ! empty( $settings['show_engagement_stats'] ) && 'yes' === $settings['show_engagement_stats'] );
		$show_caption          = ( ! empty( $settings['show_caption'] ) && 'yes' === $settings['show_caption'] );

		// Gap settings for responsive Swiper
		$gap_desktop = ! empty( $settings['items_gap']['size'] ) ? intval( $settings['items_gap']['size'] ) : 20;
		$gap_tablet  = ! empty( $settings['items_gap_tablet']['size'] ) ? intval( $settings['items_gap_tablet']['size'] ) : 16;
		$gap_mobile  = ! empty( $settings['items_gap_mobile']['size'] ) ? intval( $settings['items_gap_mobile']['size'] ) : 12;

		// Carousel Settings config JSON
		$carousel_options = [
			'autoplay'            => ( ! empty( $settings['carousel_autoplay'] ) && 'yes' === $settings['carousel_autoplay'] ),
			'autoplaySpeed'       => ! empty( $settings['carousel_autoplay_speed'] ) ? intval( $settings['carousel_autoplay_speed'] ) : 4000,
			'loop'                => ( ! empty( $settings['carousel_loop'] ) && 'yes' === $settings['carousel_loop'] ),
			'slidesPerView'       => ! empty( $settings['carousel_slides_per_view'] ) ? floatval( $settings['carousel_slides_per_view'] ) : 4,
			'slidesPerViewTablet' => ! empty( $settings['carousel_slides_per_view_tablet'] ) ? floatval( $settings['carousel_slides_per_view_tablet'] ) : 2,
			'slidesPerViewMobile' => ! empty( $settings['carousel_slides_per_view_mobile'] ) ? floatval( $settings['carousel_slides_per_view_mobile'] ) : 1.2,
			'spaceBetween'        => $gap_desktop,
			'spaceBetweenTablet'  => $gap_tablet,
			'spaceBetweenMobile'  => $gap_mobile,
			'pagination'          => ( ! empty( $settings['carousel_pagination'] ) && 'yes' === $settings['carousel_pagination'] ),
			'arrows'              => ( ! empty( $settings['carousel_arrows'] ) && 'yes' === $settings['carousel_arrows'] ),
		];

		$this->add_render_attribute(
			'wrapper',
			[
				'class'                  => [
					'wpsr-reels-wrapper',
					'wpsr-layout-' . esc_attr( $layout ),
					'wpsr-aspect-' . esc_attr( $aspect_ratio ),
					'wpsr-profile-vis-' . esc_attr( $profile_visibility ),
				],
				'id'                     => 'wpsr-reels-' . esc_attr( $widget_id ),
				'data-widget-id'         => esc_attr( $widget_id ),
				'data-layout'            => esc_attr( $layout ),
				'data-video-autoplay'    => $video_autoplay ? 'true' : 'false',
				'data-modal-enabled'     => $is_modal_enabled ? 'true' : 'false',
				'data-carousel-config'   => wp_json_encode( $carousel_options ),
				'data-global-avatar'     => $global_avatar_url,
				'data-global-name'       => $global_profile_name,
				'data-global-handle'     => $global_handle,
				'data-global-url'        => $global_profile_url,
				'data-profile-vis'       => esc_attr( $profile_visibility ),
				'data-show-stats'        => $show_engagement_stats ? 'true' : 'false',
				'data-show-caption'      => $show_caption ? 'true' : 'false',
				'data-view-display'      => esc_attr( $view_post_display ),
				'data-view-label'        => esc_attr( $view_post_label ),
				'data-view-icon'         => esc_attr( $rendered_view_post_icon ),
			]
		);
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $is_carousel ) : ?>
				<div class="swiper wpsr-carousel-container">
					<div class="swiper-wrapper">
						<?php foreach ( $settings['reels_list'] as $index => $item ) : ?>
							<div class="swiper-slide wpsr-slide-item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
								<?php $this->render_single_reel_card( $item, $index, $settings ); ?>
							</div>
						<?php endforeach; ?>
					</div>

					<div class="swiper-pagination wpsr-pagination"></div>

					<button type="button" class="wpsr-nav-arrow wpsr-nav-prev" aria-label="<?php esc_attr_e( 'Previous Reel', 'wp-social-reels-pro' ); ?>">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
							<polyline points="15 18 9 12 15 6"></polyline>
						</svg>
					</button>
					<button type="button" class="wpsr-nav-arrow wpsr-nav-next" aria-label="<?php esc_attr_e( 'Next Reel', 'wp-social-reels-pro' ); ?>">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
							<polyline points="9 18 15 12 9 6"></polyline>
						</svg>
					</button>
				</div>
			<?php else : ?>
				<div class="wpsr-grid-container">
					<?php foreach ( $settings['reels_list'] as $index => $item ) : ?>
						<div class="wpsr-grid-item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
							<?php $this->render_single_reel_card( $item, $index, $settings ); ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Render a single video reel card
	 *
	 * @param array $item
	 * @param int $index
	 * @param array $settings
	 */
	protected function render_single_reel_card( $item, $index, $settings ) {
		// Resolve video source
		$video_src = '';
		if ( 'self_hosted' === $item['video_type'] && ! empty( $item['video_file']['url'] ) ) {
			$video_src = $item['video_file']['url'];
		} elseif ( ! empty( $item['video_url'] ) ) {
			$video_src = $item['video_url'];
		}

		// Poster image
		$poster_url = ! empty( $item['video_poster']['url'] ) ? $item['video_poster']['url'] : '';

		// Global Profile settings uniformly applied
		$avatar_url          = ! empty( $settings['global_profile_avatar']['url'] ) ? $settings['global_profile_avatar']['url'] : '';
		$profile_name        = ! empty( $settings['global_profile_name'] ) ? $settings['global_profile_name'] : 'Run on GSC';
		$profile_handle      = ! empty( $settings['global_profile_handle'] ) ? $settings['global_profile_handle'] : 'timecliq.watches';
		$post_link_url       = ! empty( $settings['global_profile_url']['url'] ) ? esc_url( $settings['global_profile_url']['url'] ) : '#';
		$profile_visibility  = ! empty( $settings['profile_info_visibility'] ) ? $settings['profile_info_visibility'] : 'always';

		$show_top_right_icon = ( ! empty( $settings['show_top_right_icon'] ) && 'yes' === $settings['show_top_right_icon'] );
		$has_badge_icon      = ! empty( $settings['card_social_icon']['value'] );

		// Visibility checks for DOM clean-up
		$show_card_profile = ( 'none' !== $profile_visibility && 'modal_only' !== $profile_visibility );
		$show_top_right    = ( $show_top_right_icon && $has_badge_icon );

		$caption               = ! empty( $item['caption'] ) ? $item['caption'] : '';
		$likes_count           = isset( $item['likes_count'] ) ? $this->format_number( $item['likes_count'] ) : '0';
		$comments_count        = isset( $item['comments_count'] ) ? $this->format_number( $item['comments_count'] ) : '0';
		$show_engagement_stats = ( ! empty( $settings['show_engagement_stats'] ) && 'yes' === $settings['show_engagement_stats'] );
		$show_caption          = ( ! empty( $settings['show_caption'] ) && 'yes' === $settings['show_caption'] && ! empty( $caption ) );
		$show_play_btn         = ( ! empty( $settings['show_play_btn'] ) && 'yes' === $settings['show_play_btn'] );
		?>
		<div
			class="wpsr-reel-card"
			data-video-src="<?php echo esc_url( $video_src ); ?>"
			data-poster-src="<?php echo esc_url( $poster_url ); ?>"
			data-avatar-src="<?php echo esc_url( $avatar_url ); ?>"
			data-profile-name="<?php echo esc_attr( $profile_name ); ?>"
			data-profile-handle="<?php echo esc_attr( $profile_handle ); ?>"
			data-post-url="<?php echo esc_url( $post_link_url ); ?>"
			data-caption="<?php echo esc_attr( $caption ); ?>"
			data-likes="<?php echo esc_attr( $likes_count ); ?>"
			data-comments="<?php echo esc_attr( $comments_count ); ?>"
			tabindex="0"
			role="button"
			aria-label="<?php echo esc_attr( sprintf( __( 'Play Reel: %s', 'wp-social-reels-pro' ), ! empty( $caption ) ? $caption : $profile_name ) ); ?>"
		>
			<!-- Card Video Preview Background -->
			<?php if ( ! empty( $video_src ) ) : ?>
				<video
					class="wpsr-video-element"
					src="<?php echo esc_url( $video_src ); ?>"
					<?php if ( ! empty( $poster_url ) ) : ?>poster="<?php echo esc_url( $poster_url ); ?>"<?php endif; ?>
					muted
					loop
					playsinline
					preload="metadata"
				></video>
			<?php endif; ?>

			<!-- Fallback Poster Image if Video is loading or not autoplaying -->
			<?php if ( ! empty( $poster_url ) ) : ?>
				<img class="wpsr-video-poster-fallback" src="<?php echo esc_url( $poster_url ); ?>" alt="<?php echo esc_attr( $profile_name ); ?>" loading="lazy" />
			<?php endif; ?>

			<!-- Dark Gradient Overlay for optimal readability -->
			<div class="wpsr-card-overlay"></div>

			<!-- Centered Round Play Icon Indicator -->
			<?php if ( $show_play_btn ) : ?>
				<div class="wpsr-play-btn-wrapper" aria-hidden="true">
					<div class="wpsr-play-btn">
						<?php
						if ( ! empty( $settings['play_icon']['value'] ) ) {
							Icons_Manager::render_icon( $settings['play_icon'], [ 'aria-hidden' => 'true' ] );
						} else {
							echo '<svg viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>';
						}
						?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Card Top Bar: Profile Details & Top-Right Social Icon -->
			<?php if ( $show_card_profile || $show_top_right ) : ?>
				<div class="wpsr-card-top-bar">
					<?php if ( $show_card_profile ) : ?>
						<div class="wpsr-profile-info">
							<?php if ( ! empty( $avatar_url ) ) : ?>
								<img class="wpsr-avatar" src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $profile_name ); ?>" loading="lazy" />
							<?php else : ?>
								<div class="wpsr-avatar wpsr-avatar-placeholder"><i class="fas fa-user"></i></div>
							<?php endif; ?>
							<div class="wpsr-profile-meta">
								<span class="wpsr-profile-name"><?php echo esc_html( $profile_name ); ?></span>
								<?php if ( ! empty( $profile_handle ) ) : ?>
									<span class="wpsr-profile-handle"><?php echo esc_html( $profile_handle ); ?></span>
								<?php endif; ?>
							</div>
						</div>
					<?php else : ?>
						<div class="wpsr-profile-info-empty"></div>
					<?php endif; ?>

					<?php if ( $show_top_right ) : ?>
						<div class="wpsr-card-top-right">
							<a href="<?php echo esc_url( $post_link_url ); ?>" class="wpsr-social-icon-link" target="_blank" rel="noopener noreferrer" onclick="event.stopPropagation();" aria-label="<?php esc_attr_e( 'Social Link', 'wp-social-reels-pro' ); ?>">
								<?php
								Icons_Manager::render_icon( $settings['card_social_icon'], [ 'aria-hidden' => 'true' ] );
								?>
							</a>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<!-- Card Bottom Bar: Likes, Comments, Caption -->
			<?php if ( $show_engagement_stats || $show_caption ) : ?>
				<div class="wpsr-card-bottom-bar">
					<?php if ( $show_engagement_stats ) : ?>
						<div class="wpsr-engagement-stats">
							<div class="wpsr-stat-item wpsr-stat-likes">
								<svg class="wpsr-stat-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
									<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
								</svg>
								<span class="wpsr-stat-count"><?php echo esc_html( $likes_count ); ?></span>
							</div>

							<div class="wpsr-stat-item wpsr-stat-comments">
								<svg class="wpsr-stat-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
									<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
								</svg>
								<span class="wpsr-stat-count"><?php echo esc_html( $comments_count ); ?></span>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $show_caption ) : ?>
						<p class="wpsr-card-caption"><?php echo esc_html( $caption ); ?></p>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Helper method to format numbers nicely (e.g., 3, 11, 28.5K)
	 *
	 * @param float|int|string $number
	 * @return string
	 */
	protected function format_number( $number ) {
		$num = floatval( $number );
		if ( $num >= 1000000 ) {
			return round( $num / 1000000, 1 ) . 'M';
		}
		if ( $num >= 1000 ) {
			return round( $num / 1000, 1 ) . 'K';
		}
		return (string) $num;
	}
}
