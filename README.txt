=== WP Social Reels Pro ===
Contributors: developerzahir
Tags: elementor, reels, video, tiktok, instagram, shorts, video gallery, popup video, swiper
Requires at least: 5.8
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.8.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

WP Social Reels Pro is a high-performance Elementor addon for showcasing vertical social video reels in interactive Grid & Carousel layouts with full-screen popup modals or seamless inline playback.

== Description ==

**WP Social Reels Pro** allows you to seamlessly integrate TikTok, Instagram Reels, and YouTube Shorts-style vertical video feeds into your Elementor pages.

### Key Features:
* **Safari & iOS WebKit Aspect Ratio Optimization**: 100% reliable aspect ratio calculations on Apple iPhone, iPad, and Safari browsers without flexbox distortion.
* **Responsive Aspect Ratio Selection**: Choose different Card Aspect Ratios independently across Desktop, Tablet, and Mobile (9:16, 4:5, 1:1, 16:9, or Custom Height).
* **Carousel Navigation Position Controllers**: Fine-grained responsive controls for Left Arrow Position, Right Arrow Position, Vertical Alignment (%), Box Size down to 10px, and Icon Size down to 6px.
* **Global & Individual Post URLs**: Assign specific social post links to individual reel items which directly apply to the card social badge and the modal "View Post" button.
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

= 1.8.6 =
* Feature: Renamed control to "Page Link" and wrapped profile details (avatar, name, handle) with clickable anchor linking to the page URL on both Reel Cards and Modal Player.
* Enhancement: Optimized Navigation Arrow On Hover entrance animation with smooth 8px offset slide-in (`translateX(-8px)` to `translateX(0)` for Prev, `translateX(8px)` to `translateX(0)` for Next).
* Fix: Synchronized CSS transitions and Elementor responsive control selectors to ensure smooth slide-in hover animation across desktop, tablet, and mobile.

= 1.8.5 =
* Feature: Auto-update checker via Plugin Update Checker (PUC v5) with GitHub releases.
* Enhancement: Added GitHub release packaging and automated update notifications.

= 1.7.7 =
* Feature: Added Navigation Arrow Visibility control with "Always Visible" and "On Hover" modes.
* Feature: Modern subtle entrance and exit slide-in animations for navigation arrows in "On Hover" mode.

= 1.7.6 =
* Feature: Autoplay ON + Infinite Loop OFF smoothly rewinds to Item 1 when reaching the end and continues autoplaying endlessly without stopping.
* Feature: Infinite Loop ON delivers a seamless, continuous infinite carousel with zero visible reset jump.
* Enhancement: Configured native Swiper `rewind: !isLoop` and `loop: isLoop` for complete forward and backward navigation.

= 1.7.5 =
* Feature: Configurable "Enable Slider Loop" switcher option with clear Enable/Disable modes.
* Feature: Forward navigation loops seamlessly when enabled; stops at the final slide when disabled while maintaining complete Previous/Back navigation.
* Enhancement: Configured Swiper autoplay stopOnLastSlide when loop is disabled.
* Fix: Refined navigation arrow disabled states with clear visual feedback (25% opacity and disabled cursor).

= 1.7.4 =
* Fix: Fixed video poster fallback overlay stacking order to ensure playing videos are never covered by poster thumbnails.
* Fix: Fixed WebKit/iOS Safari GPU compositing layer flicker where card overlay, icons, and text disappeared during touch scrolling/swiping.
* Fix: Ensured seamless Swiper Carousel autoplay and continuous infinite looping across all slides.
* Fix: Handled Swiper duplicated slides properly for card triggers and video playback.

= 1.7.3 =
* Fix: Resolved WebKit/Safari flex-stretch bug preventing aspect-ratio on iPhone and Safari browsers.
* Enhancement: Isolated video and media elements with absolute positioning to guarantee mathematical aspect-ratio rendering.

= 1.7.2 =
* Feature: Made "Card Aspect Ratio" fully responsive with independent options for Desktop, Tablet, and Mobile devices (9:16, 4:5, 1:1, 16:9, and custom).
* Revert: Reverted forced clamping on slides per view and CSS min-width to respect exact user Elementor settings.

= 1.7.1 =
* Fix: Added automated mobile & tablet safeguard clamping for Slides Per View to prevent narrow/squeezed cards on iPhones and mobile devices.
* Enhancement: Added CSS minimum width constraint on mobile carousel cards.

= 1.7.0 =
* Feature: Added responsive horizontal and vertical positioning controls for carousel Left Arrow and Right Arrow buttons.
* Fix: Removed minimum 24px slider barrier, allowing arrow button size down to 10px and icon size down to 6px.

= 1.6.9 =
* Feature: Added individual "Post / Social Link" control per reel item in the repeater.
* Feature: Dynamically connected item-specific post URLs to card top-right social badges and modal "View Post" call-to-action button (with fallback to global URL).
* Feature: Added visual UI showcase screenshots to GitHub documentation.

= 1.6.8 =
* Fix: Prevented pre-initialization carousel layout shift / FOUC with instant CSS slides-per-view width calculation.
* Enhancement: Added premium skeleton shimmer loading animation for reel cards during asset loading.

= 1.6.7 =
* Fix: Undefined array key warning in carousel pagination and settings handler.
* Enhancement: Streamlined modal layout and mobile glassy stacked buttons.

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
