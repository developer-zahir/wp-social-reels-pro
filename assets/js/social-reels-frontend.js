/**
 * WP Social Reels Pro - Frontend JavaScript Handler
 *
 * Handles Swiper Carousel initialization with responsive spacing, IntersectionObserver
 * video autoplay, and 1:1 Full-Screen Interactive Popup Modal Player.
 *
 * @package WPSocialReelsPro
 * @version 1.6.0
 */

(function ($) {
	'use strict';

	const UNMUTED_ICON_SVG = '<svg class="wpsr-icon-sound wpsr-icon-unmuted" viewBox="0 0 24 24" fill="currentColor"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/></svg>';
	const MUTED_ICON_SVG = '<svg class="wpsr-icon-sound wpsr-icon-muted" viewBox="0 0 24 24" fill="currentColor"><path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06c1.38-.31 2.63-.95 3.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z"/></svg>';

	/**
	 * Social Reels Handler Class
	 */
	const WPSocialReelsHandler = {
		modalEl: null,
		activeVideoEl: null,
		activeCardList: [],
		activeWrapper: null,
		currentIndex: 0,
		isMuted: false,

		/**
		 * Initialize Widget Instance
		 */
		init: function ($scope) {
			const $wrapper = $scope.find('.wpsr-reels-wrapper');
			if (!$wrapper.length) return;

			const layout = $wrapper.data('layout');
			const isCarousel = layout === 'carousel';
			const videoAutoplay = $wrapper.data('video-autoplay') === true || $wrapper.data('video-autoplay') === 'true';
			const modalEnabled = $wrapper.data('modal-enabled') === true || $wrapper.data('modal-enabled') === 'true';

			// 1. Initialize Swiper if Carousel Layout
			if (isCarousel) {
				WPSocialReelsHandler.initCarousel($wrapper);
			}

			// 2. Setup IntersectionObserver for Viewport Video Autoplay (if Autoplay is ON)
			if (videoAutoplay) {
				WPSocialReelsHandler.initViewportObserver($wrapper);
			}

			// 3. Setup Card Click Triggers (Modal or Inline Video Playback)
			WPSocialReelsHandler.initCardTriggers($wrapper, modalEnabled);
		},

		/**
		 * Initialize Swiper Carousel with native Elementor Swiper support
		 */
		initCarousel: function ($wrapper) {
			const $carousel = $wrapper.find('.wpsr-carousel-container');
			if (!$carousel.length) return;

			// Destroy previous instance if re-initializing in Elementor editor
			if ($carousel[0].swiper) {
				try {
					$carousel[0].swiper.destroy(true, true);
				} catch (e) {
					// Ignore
				}
			}

			const rawConfig = $wrapper.attr('data-carousel-config');
			let config = {};
			try {
				config = JSON.parse(rawConfig || '{}');
			} catch (e) {
				config = {};
			}

			const spvDesktop = !isNaN(parseFloat(config.slidesPerView)) ? parseFloat(config.slidesPerView) : 4;
			const spvTablet = !isNaN(parseFloat(config.slidesPerViewTablet)) ? parseFloat(config.slidesPerViewTablet) : 2;
			const spvMobile = !isNaN(parseFloat(config.slidesPerViewMobile)) ? parseFloat(config.slidesPerViewMobile) : 1.2;

			const spaceBetweenDesktop = config.spaceBetween !== undefined ? config.spaceBetween : 20;
			const spaceBetweenTablet = config.spaceBetweenTablet !== undefined ? config.spaceBetweenTablet : 16;
			const spaceBetweenMobile = config.spaceBetweenMobile !== undefined ? config.spaceBetweenMobile : 12;

			const isAutoplay = (config.autoplay === true || config.autoplay === 'yes');
			const isLoop = (config.loop === true || config.loop === 'yes');

			const swiperOptions = {
				slidesPerView: spvMobile,
				spaceBetween: spaceBetweenMobile,
				grabCursor: true,
				loop: isLoop,
				speed: 600,
				watchSlidesProgress: true,
				breakpoints: {
					640: {
						slidesPerView: spvTablet,
						spaceBetween: spaceBetweenTablet,
					},
					1024: {
						slidesPerView: spvDesktop,
						spaceBetween: spaceBetweenDesktop,
					},
				},
				on: {
					init: function () {
						const modalEnabled = $wrapper.data('modal-enabled') === true || $wrapper.data('modal-enabled') === 'true';
						const videoAutoplay = $wrapper.data('video-autoplay') === true || $wrapper.data('video-autoplay') === 'true';
						if (videoAutoplay) {
							WPSocialReelsHandler.initViewportObserver($wrapper);
						}
						WPSocialReelsHandler.initCardTriggers($wrapper, modalEnabled);
					},
					slideChange: function () {
						const videoAutoplay = $wrapper.data('video-autoplay') === true || $wrapper.data('video-autoplay') === 'true';
						if (videoAutoplay) {
							$wrapper.find('.swiper-slide-active, .swiper-slide-next').find('.wpsr-video-element').each(function () {
								const p = this.play();
								if (p !== undefined) {
									p.catch(function () {});
								}
							});
						}
					},
				},
			};

			// Autoplay Configuration
			if (isAutoplay) {
				swiperOptions.autoplay = {
					delay: config.autoplaySpeed ? parseInt(config.autoplaySpeed, 10) : 3500,
					disableOnInteraction: false,
					pauseOnMouseEnter: true,
					stopOnLastSlide: !isLoop,
				};
			}

			// Navigation Arrows
			const $next = $wrapper.find('.wpsr-nav-next');
			const $prev = $wrapper.find('.wpsr-nav-prev');
			if ($next.length && $prev.length) {
				swiperOptions.navigation = {
					nextEl: $next[0],
					prevEl: $prev[0],
				};
			}

			// Pagination
			const $pagination = $wrapper.find('.swiper-pagination');
			if ($pagination.length) {
				swiperOptions.pagination = {
					el: $pagination[0],
					clickable: true,
				};
			}

			// Native Elementor Swiper or Global Swiper Instance
			if (typeof Swiper !== 'undefined') {
				const swiperInst = new Swiper($carousel[0], swiperOptions);
				$carousel[0].swiper = swiperInst;
			} else if (window.elementorFrontend && window.elementorFrontend.utils && window.elementorFrontend.utils.swiper) {
				new window.elementorFrontend.utils.swiper($carousel[0], swiperOptions).then(function (swiperInstance) {
					$carousel[0].swiper = swiperInstance;
				}).catch(function () {
					if (typeof window.elementorFrontend.utils.swiper === 'function') {
						$carousel[0].swiper = new window.elementorFrontend.utils.swiper($carousel[0], swiperOptions);
					}
				});
			}
		},

		/**
		 * IntersectionObserver: Autoplay videos when in viewport and pause when out
		 */
		initViewportObserver: function ($wrapper) {
			const videos = $wrapper.find('.wpsr-video-element');
			if (!videos.length || !('IntersectionObserver' in window)) return;

			const observer = new IntersectionObserver(
				function (entries) {
					entries.forEach(function (entry) {
						const video = entry.target;
						const $card = $(video).closest('.wpsr-reel-card');
						if (entry.isIntersecting) {
							const playPromise = video.play();
							if (playPromise !== undefined) {
								playPromise.catch(function () {
									// Browser autoplay policy catch
								});
							}
						} else {
							// Pause if not user-playing inline with sound
							if (!$card.hasClass('wpsr-inline-playing')) {
								video.pause();
							}
						}
					});
				},
				{ threshold: 0.35 }
			);

			videos.each(function () {
				observer.observe(this);
			});
		},

		/**
		 * Setup Card Triggers for Reel Cards (Modal Popup or Inline Playback)
		 */
		initCardTriggers: function ($wrapper, modalEnabled) {
			const self = this;
			const $cards = $wrapper.find('.wpsr-reel-card');

			$cards.off('click.wpsr keydown.wpsr').on('click.wpsr keydown.wpsr', function (e) {
				if (e.type === 'keydown' && e.key !== 'Enter' && e.key !== ' ') {
					return;
				}
				// If clicked on "View post", social icon link, or nav arrow, don't trigger modal/play
				if ($(e.target).closest('.wpsr-view-post-link, .wpsr-social-icon-link, .wpsr-nav-arrow').length) {
					return;
				}

				e.preventDefault();

				if (modalEnabled) {
					self.activeWrapper = $wrapper;
					const nonDuplicateCards = $wrapper.find('.swiper-slide:not(.swiper-slide-duplicate) .wpsr-reel-card');
					self.activeCardList = (nonDuplicateCards.length ? nonDuplicateCards : $cards).toArray();

					const clickedCard = this;
					let targetIdx = self.activeCardList.indexOf(clickedCard);
					if (targetIdx === -1) {
						const src = $(clickedCard).attr('data-video-src') || $(clickedCard).attr('data-post-url');
						targetIdx = self.activeCardList.findIndex(function (c) {
							return $(c).attr('data-video-src') === src || $(c).attr('data-post-url') === src;
						});
						if (targetIdx === -1) targetIdx = 0;
					}
					self.currentIndex = targetIdx;
					self.openModal($(self.activeCardList[self.currentIndex]));
				} else {
					// Inline video playback directly inside the card
					self.toggleInlineVideo($(this), $wrapper);
				}
			});
		},

		/**
		 * Toggle Inline Video Playback inside the Reel Card
		 */
		toggleInlineVideo: function ($card, $wrapper) {
			const video = $card.find('.wpsr-video-element')[0];
			if (!video) return;

			const isCurrentlyPlaying = !video.paused && !video.ended && $card.hasClass('wpsr-inline-playing');

			// Pause all other inline videos across the page
			$('.wpsr-reel-card').not($card).each(function () {
				const otherVideo = $(this).find('.wpsr-video-element')[0];
				if (otherVideo && !otherVideo.paused) {
					otherVideo.pause();
				}
				$(this).removeClass('wpsr-inline-playing');
			});

			if (isCurrentlyPlaying) {
				video.pause();
				$card.removeClass('wpsr-inline-playing');
			} else {
				video.muted = false; // Unmute on explicit user action
				const playPromise = video.play();
				if (playPromise !== undefined) {
					playPromise
						.then(function () {
							$card.addClass('wpsr-inline-playing');
						})
						.catch(function () {
							// If browser blocks sound without prior audio interaction, play muted
							video.muted = true;
							video.play();
							$card.addClass('wpsr-inline-playing');
						});
				} else {
					$card.addClass('wpsr-inline-playing');
				}
			}
		},

		/**
		 * Ensure Modal Overlay exists in DOM (1:1 Layout)
		 */
		ensureModalDOM: function () {
			if ($('#wpsr-global-modal').length) {
				this.modalEl = $('#wpsr-global-modal');
				return;
			}

			const modalHTML = `
				<div id="wpsr-global-modal" class="wpsr-modal-overlay" role="dialog" aria-modal="true" aria-label="Social Reel Video Player">
					<!-- Modal Close Button (✕) -->
					<button type="button" class="wpsr-modal-close" aria-label="Close Video (Esc)">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
							<line x1="18" y1="6" x2="6" y2="18"></line>
							<line x1="6" y1="6" x2="18" y2="18"></line>
						</svg>
					</button>

					<!-- Side Navigation Arrows (Left & Right Screen Chevrons) -->
					<button type="button" class="wpsr-modal-nav-btn wpsr-modal-prev" aria-label="Previous Reel">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
							<polyline points="15 18 9 12 15 6"></polyline>
						</svg>
					</button>
					<button type="button" class="wpsr-modal-nav-btn wpsr-modal-next" aria-label="Next Reel">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
							<polyline points="9 18 15 12 9 6"></polyline>
						</svg>
					</button>

					<!-- Reel Modal Video Container Card -->
					<div class="wpsr-modal-video-card">
						<!-- Top Overlay Header inside Modal -->
						<div class="wpsr-modal-top-bar">
							<div class="wpsr-modal-profile">
								<img class="wpsr-modal-avatar" src="" alt="" />
								<div class="wpsr-modal-profile-meta">
									<span class="wpsr-modal-name"></span>
									<span class="wpsr-modal-handle"></span>
								</div>
							</div>
							<a href="#" class="wpsr-modal-view-post" target="_blank" rel="noopener noreferrer">
								<span class="wpsr-modal-view-text">View post</span>
							</a>
						</div>

						<!-- Video Player in Modal -->
						<video class="wpsr-modal-video-element" loop playsinline preload="auto"></video>

						<!-- Bottom Overlay inside Modal -->
						<div class="wpsr-modal-bottom-bar">
							<div class="wpsr-modal-bottom-content">
								<div class="wpsr-modal-stats-row">
									<div class="wpsr-modal-stat-item wpsr-stat-likes">
										<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
											<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
										</svg>
										<span class="wpsr-modal-likes-count"></span>
									</div>
									<div class="wpsr-modal-stat-item wpsr-stat-comments">
										<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
											<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
										</svg>
										<span class="wpsr-modal-comments-count"></span>
									</div>
								</div>
								<p class="wpsr-modal-caption"></p>
							</div>

							<!-- Desktop Audio Toggle Button (Hidden on Mobile) -->
							<button type="button" class="wpsr-modal-sound-btn" aria-label="Toggle Sound">
								${UNMUTED_ICON_SVG}
							</button>
						</div>

						<!-- Progress Bar -->
						<div class="wpsr-modal-progress-bar">
							<div class="wpsr-modal-progress-fill"></div>
						</div>
					</div>
				</div>
			`;

			$('body').append(modalHTML);
			this.modalEl = $('#wpsr-global-modal');
			this.bindModalEvents();
		},

		/**
		 * Bind Events for Modal Elements
		 */
		bindModalEvents: function () {
			const self = this;
			const $modal = self.modalEl;
			const video = $modal.find('.wpsr-modal-video-element')[0];
			self.activeVideoEl = video;

			// Close Button Click
			$modal.find('.wpsr-modal-close').on('click', function (e) {
				e.stopPropagation();
				self.closeModal();
			});

			// Backdrop Click to Close
			$modal.on('click', function (e) {
				if ($(e.target).is($modal)) {
					self.closeModal();
				}
			});

			// Sound Mute/Unmute Toggle in Modal (Desktop)
			$modal.find('.wpsr-modal-sound-btn').on('click', function (e) {
				e.stopPropagation();
				self.toggleSound();
			});

			// Video Click (Play / Pause Toggle)
			$(video).on('click', function () {
				if (video.paused) {
					video.play();
				} else {
					video.pause();
				}
			});

			// Video Time Update for Progress Fill
			$(video).on('timeupdate', function () {
				if (video.duration) {
					const progress = (video.currentTime / video.duration) * 100;
					$modal.find('.wpsr-modal-progress-fill').css('width', progress + '%');
				}
			});

			// Next Reel Navigation
			$modal.find('.wpsr-modal-next').on('click', function (e) {
				e.stopPropagation();
				self.navigateModal(1);
			});

			// Prev Reel Navigation
			$modal.find('.wpsr-modal-prev').on('click', function (e) {
				e.stopPropagation();
				self.navigateModal(-1);
			});

			// Global Keydown Events (Esc, ArrowLeft, ArrowRight, Space, M)
			$(document).on('keydown', function (e) {
				if (!$modal.hasClass('wpsr-active')) return;

				if (e.key === 'Escape') {
					self.closeModal();
				} else if (e.key === 'ArrowRight') {
					self.navigateModal(1);
				} else if (e.key === 'ArrowLeft') {
					self.navigateModal(-1);
				} else if (e.key === ' ' || e.key === 'k') {
					if ($(e.target).is('input, textarea')) return;
					e.preventDefault();
					if (video.paused) {
						video.play();
					} else {
						video.pause();
					}
				} else if (e.key === 'm') {
					self.toggleSound();
				}
			});
		},

		/**
		 * Open Modal and Load Reel Data
		 */
		openModal: function ($card) {
			this.ensureModalDOM();

			const $modal = this.modalEl;
			const videoSrc = $card.attr('data-video-src');
			const posterSrc = $card.attr('data-poster-src');
			const avatarSrc = $card.attr('data-avatar-src');
			const profileName = $card.attr('data-profile-name') || '';
			const profileHandle = $card.attr('data-profile-handle') || '';
			const caption = $card.attr('data-caption') || '';
			const postUrl = $card.attr('data-post-url') || '#';
			const postTarget = $card.attr('data-post-target') || '_blank';
			const postRel = $card.attr('data-post-rel') || 'noopener noreferrer';
			const likes = $card.attr('data-likes') || '0';
			const comments = $card.attr('data-comments') || '0';

			// Populate Profile Info (Strictly adhering to visibility settings)
			const profileVis = this.activeWrapper ? this.activeWrapper.attr('data-profile-vis') : 'always';
			if (profileVis === 'card_only' || profileVis === 'none') {
				$modal.find('.wpsr-modal-profile').hide();
			} else {
				$modal.find('.wpsr-modal-profile').show();
				$modal.find('.wpsr-modal-name').text(profileName);
				$modal.find('.wpsr-modal-handle').text(profileHandle).toggle(!!profileHandle);
				if (avatarSrc) {
					$modal.find('.wpsr-modal-avatar').attr('src', avatarSrc).show();
				} else {
					$modal.find('.wpsr-modal-avatar').hide();
				}
			}

			const showStats = this.activeWrapper ? (this.activeWrapper.attr('data-show-stats') !== 'false') : true;
			const showCaption = this.activeWrapper ? (this.activeWrapper.attr('data-show-caption') !== 'false') : true;
			const viewDisplay = this.activeWrapper ? this.activeWrapper.attr('data-view-display') : 'text_icon';
			const viewLabel = this.activeWrapper ? this.activeWrapper.attr('data-view-label') : 'View Post';
			const viewIcon = this.activeWrapper ? this.activeWrapper.attr('data-view-icon') : '';

			// Stats & Caption Visibility
			$modal.find('.wpsr-modal-stats-row').toggle(showStats);
			$modal.find('.wpsr-modal-likes-count').text(likes);
			$modal.find('.wpsr-modal-comments-count').text(comments);

			const hasValidCaption = showCaption && !!caption.trim();
			$modal.find('.wpsr-modal-caption').text(caption).toggle(hasValidCaption);

			// View Post Link Content
			let viewPostHTML = '';
			if (viewDisplay === 'icon_only') {
				viewPostHTML = viewIcon || '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>';
			} else if (viewDisplay === 'text_only') {
				viewPostHTML = `<span class="wpsr-modal-view-text">${viewLabel || 'View Post'}</span>`;
			} else {
				viewPostHTML = `<span class="wpsr-modal-view-text">${viewLabel || 'View Post'}</span> ${viewIcon || ''}`;
			}
			$modal.find('.wpsr-modal-view-post').attr('href', postUrl).attr('target', postTarget).attr('rel', postRel).html(viewPostHTML);

			// Load Video - Starts with audio unmuted automatically
			const video = $modal.find('.wpsr-modal-video-element')[0];
			video.src = videoSrc;
			if (posterSrc) {
				video.poster = posterSrc;
			}
			video.muted = false; // Start with sound enabled
			this.isMuted = false;
			this.updateSoundUI();

			// Pause background video cards
			$('video.wpsr-video-element').each(function () {
				this.pause();
			});

			// Show Modal
			$modal.addClass('wpsr-active');
			$('body').css('overflow', 'hidden'); // Lock scroll

			// Play Modal Video with Audio
			const playPromise = video.play();
			if (playPromise !== undefined) {
				playPromise.catch(function () {
					// Fallback only if browser policy strictly restricts unmuted playback
					video.muted = true;
					WPSocialReelsHandler.isMuted = true;
					WPSocialReelsHandler.updateSoundUI();
					video.play();
				});
			}

			// Focus close button for accessibility
			$modal.find('.wpsr-modal-close').focus();
		},

		/**
		 * Navigate between reels inside Modal
		 */
		navigateModal: function (direction) {
			if (!this.activeCardList.length) return;

			this.currentIndex = (this.currentIndex + direction + this.activeCardList.length) % this.activeCardList.length;
			const $nextCard = $(this.activeCardList[this.currentIndex]);
			this.openModal($nextCard);
		},

		/**
		 * Toggle Audio Sound
		 */
		toggleSound: function () {
			const video = this.activeVideoEl;
			if (!video) return;

			this.isMuted = !this.isMuted;
			video.muted = this.isMuted;
			this.updateSoundUI();
		},

		/**
		 * Update Sound UI Button Icon - Guarantees only one single active SVG is in DOM
		 */
		updateSoundUI: function () {
			const $modal = this.modalEl;
			if (!$modal) return;

			const $soundBtn = $modal.find('.wpsr-modal-sound-btn');
			if (this.isMuted) {
				$soundBtn.addClass('wpsr-is-muted');
				$soundBtn.html(MUTED_ICON_SVG);
				$soundBtn.attr('aria-label', 'Unmute Sound');
			} else {
				$soundBtn.removeClass('wpsr-is-muted');
				$soundBtn.html(UNMUTED_ICON_SVG);
				$soundBtn.attr('aria-label', 'Mute Sound');
			}
		},

		/**
		 * Close Modal
		 */
		closeModal: function () {
			if (!this.modalEl) return;

			this.modalEl.removeClass('wpsr-active');
			$('body').css('overflow', ''); // Unlock scroll

			if (this.activeVideoEl) {
				this.activeVideoEl.pause();
				this.activeVideoEl.currentTime = 0;
			}
		},
	};

	/**
	 * Hook to Elementor Frontend Ready (Handles live Editor preview re-rendering)
	 */
	const registerElementorHandler = function () {
		if (window.elementorFrontend && window.elementorFrontend.hooks) {
			window.elementorFrontend.hooks.addAction(
				'frontend/element_ready/wp_social_video_reels.default',
				function ($scope) {
					WPSocialReelsHandler.init($scope);
				}
			);
		}
	};

	$(window).on('elementor/frontend/init', registerElementorHandler);

	// Standard DOM ready fallback for previews & non-Elementor testing
	$(document).ready(function () {
		registerElementorHandler();
		if (typeof window.elementorFrontend === 'undefined' || !window.elementorFrontend.hooks) {
			$('.wpsr-reels-wrapper').each(function () {
				WPSocialReelsHandler.init($(this).closest('.elementor-widget, .wpsr-reels-wrapper'));
			});
		}
	});

})(jQuery);
