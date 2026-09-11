# WP Social Reels Pro 🎬

[![WordPress Plugin](https://img.shields.io/badge/WordPress-5.8%2B-blue.svg?style=flat-square&logo=wordpress)](https://wordpress.org)
[![Elementor Compatible](https://img.shields.io/badge/Elementor-3.5.0%2B-red.svg?style=flat-square&logo=elementor)](https://elementor.com)
[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-777BB4.svg?style=flat-square&logo=php)](https://php.net)
[![License: GPL v2](https://img.shields.io/badge/License-GPLv2-green.svg?style=flat-square)](https://www.gnu.org/licenses/gpl-2.0.html)
[![Version](https://img.shields.io/badge/Version-1.8.6-orange.svg?style=flat-square)](https://github.com/developer-zahir/wp-social-reels-pro)

**WP Social Reels Pro** is a high-performance, interactive WordPress plugin & Elementor addon that brings modern vertical social video reels (TikTok, Instagram Reels, YouTube Shorts) to your WordPress website with ultra-fast rendering, touch-enabled carousels, customizable grid layouts, and an interactive full-screen popup modal player.

Developed by **[Developer Zahir](https://developerzahir.com)**.

---

## 🌟 Key Features

### 🔹 1. Global & Individual Post Links
* Assign specific **Post / Social URLs** to each individual video reel inside the repeater.
* Specific URLs automatically apply to both the **card top-right social badge** and the **modal "View Post" call-to-action button**, with automatic fallback to the Global Social URL if not specified.
* Set **Profile Avatar**, **Brand / Channel Name**, **Username / Handle (@handle)** once to apply uniformly across all video reel cards and popup modals.
* 5 flexible visibility modes:
  * `Always Visible`: Displayed on both video cards and modal player.
  * `Show on Hover`: Smoothly fades in when hovering over video cards.
  * `Modal Only`: Omitted from cards, shown only inside the popup modal.
  * `Card Only`: Shown on cards, omitted from modal.
  * `Hidden Everywhere`: Completely removed from the DOM.

### 🔹 2. Dual Layout Options: Grid & Touch Swiper Carousel
* **Responsive Grid Layout**: Fully customizable columns (1 to 6 columns) with device-specific responsive controls for Desktop, Tablet, and Mobile.
* **Swiper.js Touch Carousel**: Smooth swipe/touch navigation, continuous loop mode, autoplay with speed controls, and independent device-level toggles for navigation arrows and pagination bullets.
* **Responsive Card Gap Control**: Dedicated spacing slider for both Grid and Carousel layouts.
* **Zero CLS / Layout Shift**: Instant CSS slide calculations prevent the initial single-card flash on page load.
* **Dark Mode Skeleton Shimmer**: Smooth animated shimmer gradient placeholder during video/image loading.

### 🔹 3. Interactive Full-Screen Glassmorphism Popup Modal
* **Cinema-Grade Modal Player**: 1:1 immersive vertical video experience with real-time progress bar.
* **Instant Unmuted Audio Playback**: Videos automatically play with crystal-clear audio immediately upon opening the modal.
* **Mobile Fullscreen & Ergonomic Controls**: Full-screen edge-to-edge video on mobile screens with stacked glassy close and audio buttons on the bottom-right.
* **Seamless Navigation**: Previous / Next navigation chevrons and intuitive keyboard shortcuts (`Esc` to close, `←` / `→` for navigation, `Space` to play/pause).
* **View Post Action Button**: Customizable "View post" call-to-action button with icon picker, text & icon gap controller, and full typography controls.

### 🔹 4. Video & Viewport Controls
* **Viewport Auto-play & Inline Playback**: IntersectionObserver-powered autoplay when scrolled into view, or inline card playback when modal is disabled.
* **Native Elementor Design Controls (Zero Jitter)**: Uses native Normal & Hover control tabs for all interactive elements (Colors, Backgrounds, Box Shadows, Borders).
* **Static Hover Behavior**: Completely removes unwanted zoom or scaling jitter, ensuring sharp, professional interactions.

---

## 📋 Technical Requirements

| Requirement | Minimum | Recommended |
| :--- | :--- | :--- |
| **WordPress** | 5.8 | 6.4+ |
| **Elementor** | 3.5.0 | 3.25.0+ |
| **PHP** | 7.4 | 8.1+ |
| **Browsers** | Chrome, Safari, Firefox, Edge | Latest versions |

---

## 🚀 Installation Guide

### Option A: Upload via WordPress Admin
1. Download [`wp-social-reels-pro.zip`](https://github.com/developer-zahir/wp-social-reels-pro/raw/main/wp-social-reels-pro.zip).
2. Go to your WordPress Dashboard > **Plugins** > **Add New** > **Upload Plugin**.
3. Choose `wp-social-reels-pro.zip` and click **Install Now**.
4. Click **Activate Plugin**.

### Option B: Manual FTP / Directory Installation
1. Clone or extract the `wp-social-reels-pro` folder into your `/wp-content/plugins/` directory:
   ```bash
   git clone https://github.com/developer-zahir/wp-social-reels-pro.git /path-to-wordpress/wp-content/plugins/wp-social-reels-pro
   ```
2. Navigate to **Plugins** in the WordPress admin dashboard and click **Activate**.

---

## 🛠️ How to Use with Elementor

1. Open any page or post in **Elementor Page Builder**.
2. In the widget search bar on the left panel, search for **"Social Video Reels"**.
3. Drag and drop the widget into your desired section or column.
4. **Configure Content**:
   * **Global Profile Settings**: Upload your avatar and set your social handle/name.
   * **Reels Items**: Add videos via self-hosted MP4 upload or external video URLs. Set video posters, like counts, comment counts, and captions.
   * **Layout & Structure**: Choose between *Carousel* or *Grid* and set card aspect ratio (9:16, 4:5, 1:1, 16:9, or Custom).
   * **Video Player & Overlays**: Toggle Autoplay and Full-Screen Popup Modal.
5. **Customize Style**:
   * Fine-tune colors, typography, borders, and shadows using standard Elementor Normal & Hover tabs.
6. Click **Update / Publish** to see your interactive social video reel feed live!

---

## 📂 Project Architecture

```
wp-social-reels-pro/
├── assets/
│   ├── css/
│   │   └── social-reels-frontend.css       # Frontend styling, glassmorphism modal, grid & carousel rules
│   └── js/
│       └── social-reels-frontend.js        # Swiper init, IntersectionObserver, modal player & audio toggle
├── includes/
│   ├── class-plugin.php                    # Plugin singleton, asset enqueueing & Elementor widget registration
│   └── widgets/
│       └── class-social-video-reels-widget.php # Elementor Widget base, controls & render methods
├── languages/                              # i18n localization translation templates
├── .gitignore                              # Git ignore rules
├── README.md                               # GitHub documentation
├── README.txt                              # WordPress.org standard readme & changelog
├── wp-social-reels-pro.php                 # Main plugin bootstrap file
└── wp-social-reels-pro.zip                 # Production-ready installable package
```

---

## 📝 Changelog

### Version 1.6.0
* **DOM Cleanup**: Completely omits hidden profile info, caption, engagement stats, and play button from DOM when toggled off.
* **Audio Button Overhaul**: Clean single-icon rendering with zero background/border distractions and responsive size control.
* **Elementor Native Tabs**: Standardized styling across cards, buttons, badges, and arrows using Normal & Hover tabs.
* **View Post Spacing**: Added dedicated Icon & Text gap slider in the Style tab.
* **Static Hover Transitions**: Eliminated all unwanted hover zoom/scale transforms.

### Version 1.5.0
* Added inline card video playback when modal is disabled.
* Added Avatar Border and Border Radius styling controls.
* Refactored modal layout to position audio button opposite captions.

### Version 1.0.0
* Initial release of WP Social Reels Pro.

---

## 👨‍💻 Author & Support

* **Author:** [Developer Zahir](https://developerzahir.com)
* **GitHub:** [@developer-zahir](https://github.com/developer-zahir)
* **Website:** [developerzahir.com](https://developerzahir.com)

---

## 📄 License

This project is licensed under the GNU General Public License v2.0 or later (GPLv2+) - see the [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html) file for details.
