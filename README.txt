=== WP Social Reels Pro ===
Contributors: developerzahir
Tags: elementor, reels, video, tiktok, instagram, shorts, video gallery, popup video, swiper
Requires at least: 5.8
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.6.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

WP Social Reels Pro is a high-performance Elementor addon for showcasing vertical social video reels in interactive Grid & Carousel layouts with full-screen popup modals or seamless inline playback.

== Description ==

**WP Social Reels Pro** allows you to seamlessly integrate TikTok, Instagram Reels, and YouTube Shorts-style vertical video feeds into your Elementor pages.

### Key Features:
* **Global Profile Settings**: Profile Image, Brand/Profile Name, and @Handle applied uniformly across all reel cards.
* **Inline Video Playback**: Plays videos directly in place on cards when modal is disabled.
* **Elementor Widget Integration**: Drag and drop "Social Video Reels" directly in the Elementor visual builder.
* **Dual Layout Options**: Switch instantly between responsive Grid and touch-enabled Swiper Carousel.
* **Card Gap & Spacing Control**: Responsive slider for gap spacing in Grid and Carousel layouts.
* **Video Auto-play Control**: Easily toggle Auto-play ON/OFF with fallback thumbnail poster.
* **Clean Static Interactions**: Static hover behavior with zero jitter or unwanted scaling across cards and controls.
* **Native Elementor Style Tabs**: Color pickers, box shadows, borders, and typography using Elementor's standard Normal & Hover tabs.
* **Clean Audio Toggle Button**: Single active SVG icon rendering with no background or border distractions.
* **View Post Button Enhancements**: Dedicated icon & text gap spacing slider, typography, and color styling.
* **Redesigned Popup Modal**: Fullscreen modal with heavy backdrop blur (20px), top-right close button, left/right side navigation arrows, and bottom-right volume toggle.

== Installation ==

1. Upload the `wp-social-reels-pro` folder to the `/wp-content/plugins/` directory, or upload the `.zip` archive via **Plugins > Add New > Upload Plugin**.
2. Activate the plugin through the **Plugins** menu in WordPress.
3. Open any page in **Elementor**.
4. Search for **"Social Video Reels"** widget and drag it to your section.
5. Customize items, layouts, and styles from the Elementor sidebar!

== Changelog ==

= 1.6.6 =
* Fix: Removed box-shadow on desktop modal video card.
* Feature: Added smooth 90-degree rotate animation on hover for modal close button.
* Fix: Restored mobile audio button in modal bottom-right and kept close button top-right.
* Enhancement: Mobile modal card spacing with 10px rounded border radius.

= 1.6.5 =
* Fix: Maintained top-right alignment for social badge on mobile cards.
* Fix: Hidden bottom bar (caption, likes, comments) on mobile cards.
* Feature: Responsive control for centered play button (Desktop, Tablet, Mobile).
* Enhancement: Modal popup 100dvh dynamic viewport height with safe-area insets & zero border radius on mobile.

= 1.6.4 =
* Fix: Add array key safeguards for all widget settings in PHP 8.x.
* Enhancement: Real-time update detection and auto-update delivery from GitHub repository.

= 1.6.3 =
* Feature: Added automatic dismissible Admin Notice banner in WordPress admin whenever a new GitHub version is available.
* Feature: Direct one-click "Update Now" button in the admin notice banner.

= 1.6.2 =
* Fix: Fatal error when parsing remote readme caused by class autoloader namespace resolution for PucReadmeParser.

= 1.6.1 =
* Feature: Integrated official YahnisElsts Plugin Update Checker (PUC v5) for GitHub auto-updates.
* Fix: Auto-hide card profile info on mobile screens (<= 767px) while keeping it active in modal.
* Fix: Seamless responsive controls for carousel navigation arrows and pagination dots across Desktop, Tablet, and Mobile.
* Update: Refined default typography, avatar sizing, and glassy sound button styles.

= 1.6.0 =
* Fix: Complete DOM omission for hidden profile info, caption, engagement stats, and play button when toggled off.
* Fix: Clean audio/speaker button rendering strictly a single active SVG icon without background or borders.
* Fix: Replaced custom styling blocks with Elementor native Normal & Hover control tabs.
* Fix: Added View Post button icon & text gap spacing slider alongside native color and typography controls.
* Fix: Removed all hover scaling, zoom, and translateY translation effects across video cards, play button, nav arrows, close button, and audio toggle.
* Optimization: Robust modal profile and stats synchronization based on widget visibility settings.

= 1.5.0 =
* Added inline card video playback when full-screen popup modal is disabled.
* Added Avatar Border Radius styling control and synchronized profile styling between cards and modal.
* Refactored modal bottom bar layout to place speaker mute/unmute button opposite to caption.
* Updated author details to Developer Johir.

= 1.0.0 =
* Initial release of WP Social Reels Pro.
