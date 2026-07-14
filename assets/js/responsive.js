/**
 * Mobile Responsive Interactions
 * Waterside Dental Design Theme
 */

jQuery(document).ready(function($) {
    // Toggle Mobile Search (Show Search Bar)
    $('.mobile-search-toggle').on('click', function(e) {
        e.preventDefault();
        $('.mobile-main-bar').addClass('d-none').removeClass('d-flex');
        $('.mobile-search-active-bar').removeClass('d-none').addClass('d-flex');
        $('.search-field-active').focus();
    });

    // Close Mobile Search (Show Logo & Menu)
    $('.mobile-search-close-btn').on('click', function(e) {
        e.preventDefault();
        $('.mobile-search-active-bar').addClass('d-none').removeClass('d-flex');
        $('.mobile-main-bar').removeClass('d-none').addClass('d-flex');
    });

    // Toggle Mobile Menu Drawer
    $('.mobile-menu-toggle').on('click', function(e) {
        e.preventDefault();
        $('#mobile-navigation').addClass('active');
        $('.mobile-drawer-backdrop').addClass('active');
        $('body').addClass('mobile-menu-open');
    });

    // Close Mobile Menu Drawer
    $('.drawer-close, .mobile-drawer-backdrop').on('click', function(e) {
        e.preventDefault();
        $('#mobile-navigation').removeClass('active');
        $('.mobile-drawer-backdrop').removeClass('active');
        $('body').removeClass('mobile-menu-open');
    });

    // Toggle Mobile Submenus
    $('.submenu-toggle-btn').on('click', function(e) {
        e.preventDefault();
        var $btn = $(this);
        var $container = $btn.closest('.menu-item-has-children-mobile');
        var $submenuContainer = $container.find('> .sub-menu-container');
        
        $btn.find('.plus-icon').toggleClass('d-none');
        $btn.find('.cross-icon').toggleClass('d-none');
        $container.toggleClass('submenu-active');
        $submenuContainer.slideToggle(300);
    });

    // Drawer search button transition
    $('.drawer-search-btn').on('click', function(e) {
        e.preventDefault();
        // Close menu
        $('#mobile-navigation').removeClass('active');
        $('.mobile-drawer-backdrop').removeClass('active');
        $('body').removeClass('mobile-menu-open');
        
        // Open search
        $('.mobile-main-bar').addClass('d-none').removeClass('d-flex');
        $('.mobile-search-active-bar').removeClass('d-none').addClass('d-flex');
        $('.search-field-active').focus();
    });

    // Toggle Mobile Footer Accordions (Figma mobile footer)
    $('.footer-mobile-accordion .footer-nav-title').on('click', function(e) {
        if ($(window).width() < 992) {
            e.preventDefault();
            var $title = $(this);
            var $content = $title.siblings('.footer-nav-list, .opening-hours-list, .footer-contact-details');
            
            $title.toggleClass('active');
            $content.slideToggle(300);
        }
    });

    // Mobile Header Hide on Scroll Down, Show on Scroll Up
    var lastScrollTop = 0;
    var $mobileHeader = $('.mobile-header');
    var scrollThreshold = 10; // Minimum scroll difference to trigger action
    
    $(window).on('scroll', function() {
        if ($(window).width() < 992) {
            var scrollTop = $(this).scrollTop();
            
            // If near top, keep header in default state (no shadow, fully visible)
            if (scrollTop <= 50) {
                $mobileHeader.removeClass('header-scrolled');
                return;
            }
            
            // Scrolled down - show sticky header always
            $mobileHeader.addClass('header-scrolled');
        }
    });
});

/**
 * Mobile Entrance Animations via IntersectionObserver
 * Independent of desktop GSAP ScrollTrigger chain
 */
(function() {
    if (window.innerWidth >= 992) return; // Only run on mobile

    function initMobileEntranceAnimations() {
        var $sections = jQuery(
            '.key-treatments-section, .about-waterside-section, .smile-gallery-section, .testimonials-section, .principal-dentist-section, .payment-options-section, .book-appointment-section, .contact-page-layout, .teams-clinical-section, .teams-support-section, .fees-info-section'
        );
        if ($sections.length === 0) return;

        function checkVisibility() {
            var viewportHeight = window.innerHeight;
            var triggerPoint = viewportHeight * 0.85; // Must scroll into viewport by at least 15% height

            $sections.each(function() {
                var $section = jQuery(this);
                if ($section.hasClass('mobile-visible')) return;

                var rect = this.getBoundingClientRect();
                // Check if top of section has scrolled past the trigger point
                if (rect.top < triggerPoint && rect.bottom >= 0) {
                    $section.addClass('mobile-visible');
                }
            });
        }

        // Listen for scroll, resize, and fully loaded window events
        jQuery(window).on('scroll resize load', checkVisibility);
        
        // Check immediately
        checkVisibility();

        // Check again after short delays to handle late-rendering images
        setTimeout(checkVisibility, 500);
        setTimeout(checkVisibility, 1000);
        setTimeout(checkVisibility, 2000);
    }

    // Initialize Mobile About Image Slider
    function initMobileAboutSlider() {
        var $wrapper = jQuery('.about-interactive-wrapper');
        if ($wrapper.length === 0) return;

        var $images = $wrapper.find('.about-scroll-img');
        if ($images.length <= 1) return;

        var $texts = jQuery('.about-text-content');

        // Create dots container if it doesn't exist yet
        var $dotsContainer = $wrapper.find('.about-slider-dots');
        if ($dotsContainer.length === 0) {
            $dotsContainer = jQuery('<div class="about-slider-dots"></div>');
            $wrapper.append($dotsContainer);

            // Create dots
            $images.each(function(index) {
                var $dot = jQuery('<button class="about-dot" aria-label="Go to slide ' + (index + 1) + '"></button>');
                if (index === 0) $dot.addClass('active');
                $dotsContainer.append($dot);
            });
        }

        var $dots = $dotsContainer.find('.about-dot');
        var currentIndex = 0;
        var slideInterval;

        function showSlide(index) {
            if (index === currentIndex) return;

            var direction = index > currentIndex ? 'next' : 'prev';
            if (index === 0 && currentIndex === $images.length - 1) direction = 'next';
            if (index === $images.length - 1 && currentIndex === 0) direction = 'prev';

            var $currentImg = $images.eq(currentIndex);
            var $nextImg = $images.eq(index);
            var $currentText = $texts.eq(currentIndex);
            var $nextText = $texts.eq(index);

            // Clean previous transition classes
            $images.removeClass('slide-exit-left slide-exit-right slide-enter-left slide-enter-right');
            if ($texts.length > 0) {
                $texts.removeClass('slide-exit-left slide-exit-right slide-enter-left slide-enter-right');
            }

            // 1. Instantly position the next image and text off-screen
            if (direction === 'next') {
                $nextImg.addClass('slide-enter-right');
                if ($texts.length > 0) $nextText.addClass('slide-enter-right');
            } else {
                $nextImg.addClass('slide-enter-left');
                if ($texts.length > 0) $nextText.addClass('slide-enter-left');
            }

            // Force reflow
            if ($nextImg[0]) {
                $nextImg[0].offsetHeight;
            }
            if ($texts.length > 0 && $nextText[0]) {
                $nextText[0].offsetHeight;
            }

            // 2. Remove active from current and add exit class
            $currentImg.removeClass('active');
            if (direction === 'next') {
                $currentImg.addClass('slide-exit-left');
            } else {
                $currentImg.addClass('slide-exit-right');
            }

            if ($texts.length > 0) {
                $currentText.removeClass('active');
                if (direction === 'next') {
                    $currentText.addClass('slide-exit-left');
                } else {
                    $currentText.addClass('slide-exit-right');
                }
            }

            // 3. Remove entry class and add active to next image and text (triggering transition)
            $nextImg.removeClass('slide-enter-right slide-enter-left').addClass('active');
            if ($texts.length > 0) {
                $nextText.removeClass('slide-enter-right slide-enter-left').addClass('active');
            }

            // Update indicators
            $dots.removeClass('active');
            $dots.eq(index).addClass('active');
            currentIndex = index;
        }

        // Click handler for dots
        $dots.on('click', function() {
            var index = jQuery(this).index();
            showSlide(index);
            resetTimer();
        });

        // Swipe gestures (simple touch event handling)
        var touchStartX = 0;
        var touchEndX = 0;
        
        $wrapper.on('touchstart', function(e) {
            var touches = e.touches || (e.originalEvent && e.originalEvent.touches);
            if (touches && touches.length > 0) {
                touchStartX = touches[0].clientX;
            }
        });
        
        $wrapper.on('touchend', function(e) {
            var touches = e.changedTouches || (e.originalEvent && e.originalEvent.changedTouches);
            if (touches && touches.length > 0) {
                touchEndX = touches[0].clientX;
                handleSwipe();
            }
        });

        function handleSwipe() {
            var swipeThreshold = 50;
            if (touchStartX - touchEndX > swipeThreshold) {
                // Swipe left -> Next slide
                var nextIndex = (currentIndex + 1) % $images.length;
                showSlide(nextIndex);
                resetTimer();
            } else if (touchEndX - touchStartX > swipeThreshold) {
                // Swipe right -> Prev slide
                var prevIndex = (currentIndex - 1 + $images.length) % $images.length;
                showSlide(prevIndex);
                resetTimer();
            }
        }

        function startTimer() {
            slideInterval = setInterval(function() {
                var nextIndex = (currentIndex + 1) % $images.length;
                showSlide(nextIndex);
            }, 5000); // Swap every 5 seconds
        }

        function resetTimer() {
            clearInterval(slideInterval);
            startTimer();
        }

        startTimer();
    }

    // Initialize Mobile Smile Gallery Slider
    function initMobileGallerySlider() {
        if (window.innerWidth >= 992) return; // Only run on mobile
        
        var $wrapper = jQuery('.smile-gallery-section .gallery-interactive-wrapper');
        if ($wrapper.length === 0) return;

        var $slides = $wrapper.find('.gallery-slide');
        if ($slides.length <= 1) return;

        var $gallerySection = $wrapper.closest('.smile-gallery-section');
        var $detailsContainer = $gallerySection.find('.gallery-details-grid');
        var $details = $detailsContainer.find('.gallery-details-data');

        // Create dots container below the slider
        var $infoWrapper = $gallerySection.find('.gallery-info-wrapper');
        var $dotsContainer = $infoWrapper.find('.gallery-slider-dots');
        
        // Find action button
        var $actionBtn = $infoWrapper.find('.btn-gallery-action');

        if ($dotsContainer.length === 0) {
            $dotsContainer = jQuery('<div class="gallery-slider-dots"></div>');
            // Insert dots before the action button
            if ($actionBtn.length > 0) {
                $dotsContainer.insertBefore($actionBtn);
            } else {
                $infoWrapper.append($dotsContainer);
            }

            // Create dots
            $slides.each(function(index) {
                var $dot = jQuery('<button class="gallery-dot" aria-label="Go to slide ' + (index + 1) + '"></button>');
                if (index === 0) $dot.addClass('active');
                $dotsContainer.append($dot);
            });
        }

        var $dots = $dotsContainer.find('.gallery-dot');
        var currentIndex = 0;
        var slideInterval;

        function showSlide(index) {
            $slides.removeClass('active');
            $details.removeClass('active');
            $dots.removeClass('active');
            
            var $newSlide = $slides.eq(index);
            var $newDetails = $details.eq(index);

            // 1. Instantly show active slide, details container, and dot indicator
            $newSlide.addClass('active');
            $newDetails.addClass('active');
            $dots.eq(index).addClass('active');
            currentIndex = index;

            // --- MOBILE TRANSITION ANIMATION FLOW ---
            var $beforeCard = $newSlide.find('.before-card');
            var $afterCard = $newSlide.find('.after-card');
            var $arrow = $newSlide.find('.gallery-connecting-arrow');
            var $detailCards = $newDetails.find('.gallery-detail-card');

            // Phase 1: Set initial hidden states and fade out arrow
            $arrow.addClass('hidden-arrow');
            $beforeCard.addClass('animating');
            $afterCard.addClass('animating');
            
            // Hide detail cards 2, 3, and 4 (keep Card 1 "Treatment" visible instantly)
            $detailCards.slice(1).addClass('animating');

            // Remove any existing spinner, then append a new loader spinner
            $newSlide.find('.mobile-gallery-spinner').remove();
            var $spinner = jQuery('<div class="mobile-gallery-spinner"></div>');
            $newSlide.find('.gallery-image-pair-container').append($spinner);

            // Phase 2: Fade-in and blur-to-sharp for Before and After Cards (staggered)
            setTimeout(function() {
                $beforeCard.removeClass('animating');
            }, 300);

            setTimeout(function() {
                $spinner.addClass('fade-out');
                setTimeout(function() { $spinner.remove(); }, 300);
                $afterCard.removeClass('animating');
            }, 600);

            // Phase 3: Cascading Details Fade (Staggered delays)
            setTimeout(function() {
                $detailCards.eq(1).removeClass('animating');
            }, 800);

            setTimeout(function() {
                $detailCards.eq(2).removeClass('animating');
            }, 1000);

            setTimeout(function() {
                $detailCards.eq(3).removeClass('animating');
            }, 1200);

            // Connecting arrow fades back in at the end of the sequence
            setTimeout(function() {
                $arrow.removeClass('hidden-arrow');
            }, 1400);
        }

        // Click handler for dots
        $dots.on('click', function() {
            var index = jQuery(this).index();
            showSlide(index);
            resetTimer();
        });

        // Swipe gestures (simple touch event handling)
        var touchStartX = 0;
        var touchEndX = 0;
        
        $wrapper.on('touchstart', function(e) {
            var touches = e.touches || (e.originalEvent && e.originalEvent.touches);
            if (touches && touches.length > 0) {
                touchStartX = touches[0].clientX;
            }
        });
        
        $wrapper.on('touchend', function(e) {
            var touches = e.changedTouches || (e.originalEvent && e.originalEvent.changedTouches);
            if (touches && touches.length > 0) {
                touchEndX = touches[0].clientX;
                handleSwipe();
            }
        });

        function handleSwipe() {
            var swipeThreshold = 50;
            if (touchStartX - touchEndX > swipeThreshold) {
                // Swipe left -> Next slide
                var nextIndex = (currentIndex + 1) % $slides.length;
                showSlide(nextIndex);
                resetTimer();
            } else if (touchEndX - touchStartX > swipeThreshold) {
                // Swipe right -> Prev slide
                var prevIndex = (currentIndex - 1 + $slides.length) % $slides.length;
                showSlide(prevIndex);
                resetTimer();
            }
        }

        function startTimer() {
            slideInterval = setInterval(function() {
                var nextIndex = (currentIndex + 1) % $slides.length;
                showSlide(nextIndex);
            }, 5000); // Swap every 5 seconds
        }

        function resetTimer() {
            clearInterval(slideInterval);
            startTimer();
        }

        startTimer();
    }

    // Initialize Mobile Testimonials Slider
    function initMobileTestimonialsSlider() {
        if (window.innerWidth >= 992) return; // Only run on mobile
        
        var $wrapper = jQuery('.testimonials-content-row');
        if ($wrapper.length === 0) return;

        var $slides = jQuery('.testimonial-slide');
        if ($slides.length <= 1) return;

        var $progressBar = jQuery('.testimonials-progress-bar');
        var currentIndex = 0;
        var totalSlides = $slides.length;

        function updateProgress() {
            if ($progressBar.length > 0) {
                var widthPct = ((currentIndex + 1) / totalSlides) * 100;
                $progressBar.css('width', widthPct + '%');
            }
        }

        // Set initial progress
        updateProgress();

        function showSlide(index) {
            $slides.removeClass('active');
            $slides.eq(index).addClass('active');
            currentIndex = index;
            updateProgress();
        }

        // Swipe gestures
        var touchStartX = 0;
        var touchEndX = 0;
        
        $wrapper.on('touchstart', function(e) {
            var touches = e.touches || (e.originalEvent && e.originalEvent.touches);
            if (touches && touches.length > 0) {
                touchStartX = touches[0].clientX;
            }
        });
        
        $wrapper.on('touchend', function(e) {
            var touches = e.changedTouches || (e.originalEvent && e.originalEvent.changedTouches);
            if (touches && touches.length > 0) {
                touchEndX = touches[0].clientX;
                handleSwipe();
            }
        });

        function handleSwipe() {
            var swipeThreshold = 50;
            if (touchStartX - touchEndX > swipeThreshold) {
                // Swipe left -> Next slide
                var nextIndex = (currentIndex + 1) % totalSlides;
                showSlide(nextIndex);
            } else if (touchEndX - touchStartX > swipeThreshold) {
                // Swipe right -> Prev slide
                var prevIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                showSlide(prevIndex);
            }
        }
    }

    // Initialize Mobile Payment Section Accordion
    function initMobilePaymentAccordion() {
        if (window.innerWidth >= 992) return; // Only run on mobile

        var $cards = jQuery('.payment-card');
        if ($cards.length === 0) return;

        // Start with all cards collapsed initially on mobile
        $cards.removeClass('active');
        $cards.find('.payment-card-text, .payment-card-button-wrapper').hide();

        $cards.on('click', function(e) {
            // If the user clicked the action button, let the link proceed
            if (jQuery(e.target).closest('.payment-btn').length > 0) {
                return;
            }

            var $clickedCard = jQuery(this);
            var isActive = $clickedCard.hasClass('active');

            // Find currently active cards and slide them up
            var $activeCards = $cards.filter('.active');
            if ($activeCards.length > 0) {
                $activeCards.find('.payment-card-text, .payment-card-button-wrapper').slideUp(300);
                $activeCards.removeClass('active');
            }

            // If the clicked card wasn't active, expand it with slideDown
            if (!isActive) {
                $clickedCard.addClass('active');
                $clickedCard.find('.payment-card-text, .payment-card-button-wrapper').slideDown(300);
            }
        });
    }

    // Initialize Mobile Contact Carousel
    function initContactMobileCarousel() {
        if (window.innerWidth >= 768) {
            return;
        }

        var $carousel = jQuery('.contact-mobile-carousel');
        if ($carousel.length === 0) return;

        var $track = $carousel.find('.contact-mobile-carousel-track');
        var $slides = $track.find('.contact-mobile-slide');
        var $tabs = jQuery('.contact-mobile-tab');
        var $dots = jQuery('.contact-mobile-dot');
        var currentIndex = 0;
        var startX = 0;
        var isDragging = false;

        function goToSlide(index) {
            if (index < 0 || index >= $slides.length) return;
            currentIndex = index;
            $track.css('transform', 'translateX(' + (-100 * index) + '%)');
            $tabs.removeClass('is-active');
            $tabs.filter('[data-contact-slide="' + index + '"]').addClass('is-active');
            $dots.removeClass('is-active');
            $dots.filter('[data-contact-slide="' + index + '"]').addClass('is-active');

            if (index === 2) {
                jQuery('.contact-page-layout').addClass('mobile-visible');
                $slides.eq(index).find('.contact-map-card--timings').css({
                    opacity: 1,
                    transform: 'none',
                    visibility: 'visible'
                });
            }
        }

        $tabs.on('click', function() {
            goToSlide(parseInt(jQuery(this).attr('data-contact-slide'), 10));
        });

        $dots.on('click', function() {
            goToSlide(parseInt(jQuery(this).attr('data-contact-slide'), 10));
        });

        $carousel.on('touchstart', function(e) {
            startX = e.originalEvent.touches[0].clientX;
            isDragging = true;
        });

        $carousel.on('touchend', function(e) {
            if (!isDragging) return;
            var endX = e.originalEvent.changedTouches[0].clientX;
            var diff = startX - endX;
            if (Math.abs(diff) > 50) {
                if (diff > 0 && currentIndex < $slides.length - 1) {
                    goToSlide(currentIndex + 1);
                } else if (diff < 0 && currentIndex > 0) {
                    goToSlide(currentIndex - 1);
                }
            }
            isDragging = false;
        });

        goToSlide(0);
    }

    // Initialize Tablet scroll navigation (single-column stacked content)
    function initContactTabletScrollNav() {
        if (window.innerWidth < 768 || window.innerWidth >= 992) {
            return;
        }

        var $tabs = jQuery('.contact-tablet-tabs .contact-section-link');
        var $sections = jQuery('#contact-form, #quick-information, #availability-timings');
        var $trackFill = jQuery('.contact-panel-track-fill');
        var $panel = jQuery('.contact-main-panel');
        var $track = jQuery('.contact-panel-track');

        if ($tabs.length === 0 || $sections.length === 0 || !$panel.length) {
            return;
        }

        function getHeaderOffset() {
            var $header = jQuery('.mobile-header');
            return $header.length ? $header.outerHeight() + 20 : 100;
        }

        function scrollToTarget(targetEl) {
            if (!targetEl) {
                return;
            }

            var headerOffset = getHeaderOffset();
            var targetY = targetEl.getBoundingClientRect().top + window.pageYOffset - headerOffset;

            window.scrollTo({
                top: Math.max(0, targetY),
                behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth'
            });
        }

        function syncTrackHeight() {
            var $panelInner = jQuery('.contact-panel-inner');
            if ($track.length && $panelInner.length) {
                $track.css('min-height', $panelInner.outerHeight() + 'px');
            }
        }

        function updateTrackByScroll() {
            if (!$trackFill.length || !$track.length || !$panel.length) {
                return;
            }

            var trackHeight = $track.outerHeight();
            var panelTop = $panel.offset().top;
            var panelHeight = $panel.outerHeight();
            var scrollMarker = jQuery(window).scrollTop() + getHeaderOffset() + 40;
            var progress = (scrollMarker - panelTop) / Math.max(panelHeight, 1);

            progress = Math.max(0, Math.min(1, progress));
            $trackFill.css('height', (progress * trackHeight) + 'px');
        }

        function setActiveSection(sectionId) {
            $tabs.removeClass('is-active');
            $tabs.filter('[data-contact-section="' + sectionId + '"]').addClass('is-active');
        }

        $tabs.on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();

            var targetId = jQuery(this).attr('data-contact-section');
            var targetEl = document.getElementById(targetId);

            if (!targetEl) {
                return;
            }

            setActiveSection(targetId);
            scrollToTarget(targetEl);
        });

        var onScroll = function() {
            var scrollPos = jQuery(window).scrollTop() + getHeaderOffset() + 40;
            var currentId = 'contact-form';

            $sections.each(function() {
                if (jQuery(this).offset().top <= scrollPos) {
                    currentId = this.id;
                }
            });

            setActiveSection(currentId);
            syncTrackHeight();
            updateTrackByScroll();
        };

        jQuery(window).off('scroll.contactTablet').on('scroll.contactTablet', onScroll);
        jQuery(window).off('resize.contactTablet').on('resize.contactTablet', onScroll);

        jQuery('.contact-mobile-carousel-track').css('transform', 'none');
        jQuery('.contact-mobile-carousel').css('overflow', 'visible');

        syncTrackHeight();
        onScroll();
    }

    function initDentalReferralsMobile() {
        var main = document.querySelector('.dental-referrals-main');
        if (!main) {
            return;
        }

        var sections = main.querySelectorAll('.dental-referrals-accordion');
        var toggles = main.querySelectorAll('.dental-referrals-accordion-toggle');
        var progressFill = main.querySelector('.dental-referrals-mobile-progress-fill');
        var progressTrack = main.querySelector('.dental-referrals-mobile-progress');
        var formPanel = main.querySelector('.dental-referrals-form-panel');
        var form = main.querySelector('.dental-referrals-form');
        var rafId = null;

        function isPhone() {
            return window.innerWidth < 768;
        }

        if (!sections.length) {
            return;
        }

        function setExpanded(targetSection) {
            sections.forEach(function(section) {
                var isTarget = section === targetSection;
                section.classList.toggle('is-expanded', isTarget);
                var button = section.querySelector('.dental-referrals-accordion-toggle');
                if (button) {
                    button.setAttribute('aria-expanded', isTarget ? 'true' : 'false');
                }
            });
        }

        toggles.forEach(function(button) {
            button.addEventListener('click', function() {
                if (!isPhone()) {
                    return;
                }

                var section = button.closest('.dental-referrals-accordion');
                if (!section) {
                    return;
                }

                if (section.classList.contains('is-expanded')) {
                    return;
                }

                setExpanded(section);
                window.setTimeout(function() {
                    scheduleProgressUpdate();
                }, 60);
            });
        });

        function getHeaderOffset() {
            var header = document.querySelector('.mobile-header');
            return header ? header.getBoundingClientRect().height + 8 : 94;
        }

        function updateProgress() {
            if (!isPhone() || !progressFill || !progressTrack || !formPanel) {
                return;
            }

            var panelRect = formPanel.getBoundingClientRect();
            var viewportH = window.innerHeight || document.documentElement.clientHeight || 0;
            var headerOffset = getHeaderOffset();
            var startLine = headerOffset;
            var scrolled = startLine - panelRect.top;
            var scrollable = Math.max(panelRect.height - (viewportH - headerOffset), 1);
            var progress = scrolled / scrollable;

            progress = Math.max(0, Math.min(1, progress));

            // Keep a small visible start fill once the form is on screen (matches Figma ~first segment).
            if (progress > 0 && progress < 0.12) {
                progress = 0.12;
            } else if (
                progress <= 0 &&
                panelRect.top < viewportH &&
                panelRect.bottom > headerOffset
            ) {
                progress = 0.12;
            }

            progressFill.style.width = (progress * 100).toFixed(2) + '%';
            progressTrack.setAttribute('aria-hidden', 'false');
            progressTrack.setAttribute('role', 'progressbar');
            progressTrack.setAttribute('aria-valuemin', '0');
            progressTrack.setAttribute('aria-valuemax', '100');
            progressTrack.setAttribute('aria-valuenow', String(Math.round(progress * 100)));
        }

        function scheduleProgressUpdate() {
            if (rafId) {
                window.cancelAnimationFrame(rafId);
            }
            rafId = window.requestAnimationFrame(function() {
                rafId = null;
                updateProgress();
            });
        }

        window.addEventListener('scroll', scheduleProgressUpdate, { passive: true });
        window.addEventListener('resize', scheduleProgressUpdate);
        window.addEventListener('orientationchange', scheduleProgressUpdate);
        window.addEventListener('load', function() {
            window.setTimeout(scheduleProgressUpdate, 100);
            window.setTimeout(scheduleProgressUpdate, 600);
        });

        if (window.ResizeObserver && formPanel) {
            var resizeObserver = new ResizeObserver(function() {
                scheduleProgressUpdate();
            });
            resizeObserver.observe(formPanel);
            if (form) {
                resizeObserver.observe(form);
            }
        }

        scheduleProgressUpdate();
    }

    // Initialize when DOM is ready
    jQuery(document).ready(function() {
        initMobileEntranceAnimations();
        initMobileAboutSlider();
        initMobileGallerySlider();
        initMobileTestimonialsSlider();
        initMobilePaymentAccordion();
        initContactMobileCarousel();
        initContactTabletScrollNav();
        initDentalReferralsMobile();
    });
})();

