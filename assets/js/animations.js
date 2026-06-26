/**
 * Front Page Animations using GSAP and ScrollTrigger
 * 
 * Waterside Dental Design Theme
 */

let wsdAnimationsInitialized = false;

function bootAnimations() {
    if (wsdAnimationsInitialized || typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;

    wsdAnimationsInitialized = true;
    gsap.registerPlugin(ScrollTrigger);
    initAnimations();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootAnimations);
} else {
    bootAnimations();
}

window.addEventListener('load', () => {
    if (typeof ScrollTrigger !== 'undefined') {
        ScrollTrigger.refresh();
    }
});

function initAnimations() {
    const isDesktop = window.innerWidth >= 992;

    // ----------------------------------------------------
    // 1. Initial State Setup (Prevents abrupt jumps on load)
    //    Desktop only — mobile uses CSS transitions via .mobile-visible
    // ----------------------------------------------------
    const hasHero = document.querySelector('.hero-title') !== null;

    if (isDesktop) {
        gsap.set('.header-top, #masthead.site-header', { y: -50, opacity: 0 });
        if (hasHero) {
            gsap.set('.hero-title, .hero-description', { y: 30, opacity: 0 });
            gsap.set('.hero-buttons .btn', { y: 20, opacity: 0 });
            gsap.set('.stat', { y: 20, opacity: 0 });
            gsap.set('.hero-image-wrapper', { x: 50, opacity: 0, scale: 0.95 });
            gsap.set('.call-us-tab', { x: 50, opacity: 0 });
        }
    }

    // ----------------------------------------------------
    // 2. Entrance Animation Timeline (Page Load)
    //    Desktop: full GSAP timeline. Mobile: lightweight fade-in.
    // ----------------------------------------------------
    if (isDesktop) {
        const mainTimeline = gsap.timeline({ defaults: { ease: 'power3.out', duration: 1 } });

        mainTimeline
            // Fade & Slide in Header Top and Main Navigation
            .to('.header-top', { y: 0, opacity: 1, duration: 0.8 })
            .to('#masthead.site-header', { y: 0, opacity: 1, duration: 0.8 }, '-=0.6');

        if (hasHero) {
            mainTimeline
                // Reveal Hero Text
                .to('.hero-title', { y: 0, opacity: 1, duration: 0.8 }, '-=0.4')
                .to('.hero-description', { y: 0, opacity: 1, duration: 0.8 }, '-=0.6')

                // Stagger Hero Buttons
                .to('.hero-buttons .btn', {
                    y: 0,
                    opacity: 1,
                    stagger: 0.15,
                    duration: 0.6,
                    ease: 'back.out(1.7)'
                }, '-=0.5')

                // Stagger Stats wrapper and items
                .to('.stat', {
                    y: 0,
                    opacity: 1,
                    stagger: 0.1,
                    duration: 0.6
                }, '-=0.4')

                // Animate Hero Image and Call Tab
                .to('.hero-image-wrapper', {
                    x: 0,
                    opacity: 1,
                    scale: 1,
                    duration: 1.2,
                    ease: 'power4.out'
                }, '-=0.8')
                .to('.call-us-tab', {
                    x: 0,
                    opacity: 1,
                    duration: 0.6,
                    ease: 'back.out(1.7)'
                }, '-=0.6');
        }
    } else {
        // Mobile: simple entrance animation for hero elements
        const hasMobileHeader = document.querySelector('.mobile-header') !== null;
        if (hasMobileHeader) {
            gsap.set('.mobile-header', { y: -30, opacity: 0 });
            if (hasHero) {
                gsap.set('.hero-title, .hero-description', { y: 20, opacity: 0 });
                gsap.set('.hero-buttons .btn', { y: 15, opacity: 0 });
                gsap.set('.stat', { y: 15, opacity: 0 });
                gsap.set('.hero-image-wrapper', { y: 30, opacity: 0 });
                gsap.set('.call-us-tab', { opacity: 0 });
            }

            const mobileTl = gsap.timeline({ defaults: { ease: 'power2.out', duration: 0.6 } });

            mobileTl.to('.mobile-header', { y: 0, opacity: 1, duration: 0.5 });
            
            if (hasHero) {
                mobileTl
                    .to('.hero-title', { y: 0, opacity: 1 }, '-=0.3')
                    .to('.hero-description', { y: 0, opacity: 1 }, '-=0.4')
                    .to('.hero-buttons .btn', {
                        y: 0,
                        opacity: 1,
                        stagger: 0.1,
                        duration: 0.4
                    }, '-=0.3')
                    .to('.stat', {
                        y: 0,
                        opacity: 1,
                        stagger: 0.08,
                        duration: 0.4
                    }, '-=0.3')
                    .to('.hero-image-wrapper', {
                        y: 0,
                        opacity: 1,
                        duration: 0.6
                    }, '-=0.3')
                    .to('.call-us-tab', {
                        opacity: 1,
                        duration: 0.4
                    }, '-=0.3');
            }
        }
    }

    // ----------------------------------------------------
    // 3. Floating Micro-interaction for Hero Image (Desktop only) - DISABLED
    // ----------------------------------------------------
    /*
    if (isDesktop) {
        const heroImg = document.querySelector('.hero-img');
        if (heroImg) {
            gsap.to(heroImg, {
                y: -15,
                duration: 3,
                ease: 'sine.inOut',
                repeat: -1,
                yoyo: true,
                delay: 1.5
            });
        }
    }
    */

    // ----------------------------------------------------
    // 4. Scroll-Triggered Counters for Numeric Stats
    // ----------------------------------------------------
    const counters = document.querySelectorAll('.stat-number[data-count]');
    counters.forEach(counter => {
        const targetVal = parseFloat(counter.getAttribute('data-count'));
        const decimals = parseInt(counter.getAttribute('data-decimals') || '0', 10);
        const suffix = counter.getAttribute('data-suffix') || '';

        // Set initial state based on decimals
        counter.textContent = (0).toFixed(decimals) + suffix;

        const countObj = { val: 0 };
        gsap.to(countObj, {
            val: targetVal,
            duration: 2,
            ease: 'power2.out',
            scrollTrigger: {
                trigger: counter,
                start: 'top 85%',
                toggleActions: 'play none none none'
            },
            onUpdate: () => {
                counter.textContent = countObj.val.toFixed(decimals) + suffix;
            }
        });
    });

    // ----------------------------------------------------
    // 5. Interactive Accordion/Tabs (Our Key Treatments)
    // ----------------------------------------------------
    initTreatmentsAccordion();

    // ----------------------------------------------------
    // 6. Scroll-Triggered Staggered Cards (Services)
    // ----------------------------------------------------
    if (document.querySelector('.service-card')) {
        gsap.from('.service-card', {
            scrollTrigger: {
                trigger: '.services-grid',
                start: 'top 95%',
                toggleActions: 'play none none none'
            },
            y: 50,
            opacity: 0,
            duration: 0.8,
            stagger: 0.15,
            ease: 'power2.out'
        });
    }

    // ----------------------------------------------------
    // 7. Sticky About Waterside Section Image Scroll
    // ----------------------------------------------------
    const aboutSection = document.querySelector('.about-waterside-section');
    if (aboutSection && isDesktop) {
        const handle = document.querySelector('.about-scroll-indicator-handle');
        const container = document.querySelector('.about-scroll-indicator-container');
        const images = document.querySelectorAll('.about-scroll-img');
        const leftCol = document.querySelector('.about-left-col');
        const textContents = document.querySelectorAll('.about-text-content');

        if (handle && container && images.length >= 3) {
            // Set initial state
            gsap.set(images[0], { opacity: 1, visibility: 'visible' });
            gsap.set(images[1], { opacity: 0, visibility: 'hidden' });
            gsap.set(images[2], { opacity: 0, visibility: 'hidden' });
            
            if (textContents.length >= 3) {
                gsap.set(textContents[0], { opacity: 1, visibility: 'visible' });
                gsap.set(textContents[1], { opacity: 0, visibility: 'hidden' });
                gsap.set(textContents[2], { opacity: 0, visibility: 'hidden' });
            }
            gsap.set(handle, { y: 0 });

            const updateHandleY = () => {
                const scrollBarHeight = container.clientHeight || 1040;
                const handleHeight = handle.clientHeight || 278.2;
                return scrollBarHeight - handleHeight;
            };

            const aboutTl = gsap.timeline({
                scrollTrigger: {
                    trigger: aboutSection,
                    start: 'top top',
                    end: 'bottom bottom',
                    scrub: 0.5,
                }
            });

            // 1. Move scroll indicator handle
            aboutTl.to(handle, {
                y: () => updateHandleY(),
                ease: 'none',
                duration: 1
            }, 0);

            // Helper function to update active class on text blocks
            const updateActiveText = (activeIndex) => {
                textContents.forEach((tc, idx) => {
                    if (idx === activeIndex) {
                        tc.classList.add('active');
                    } else {
                        tc.classList.remove('active');
                    }
                });
            };

            // 2. Cross-fade images & texts
            if (textContents.length >= 3) {
                aboutTl.to([images[0], textContents[0]], {
                    opacity: 0,
                    duration: 0.2,
                    onStart: () => gsap.set([images[0], textContents[0]], { visibility: 'visible' }),
                    onComplete: () => {
                        gsap.set([images[0], textContents[0]], { visibility: 'hidden' });
                        updateActiveText(1);
                    },
                    onReverseComplete: () => {
                        gsap.set([images[0], textContents[0]], { visibility: 'visible' });
                        updateActiveText(0);
                    }
                }, 0.25)
                    .to([images[1], textContents[1]], {
                        opacity: 1,
                        duration: 0.2,
                        onStart: () => gsap.set([images[1], textContents[1]], { visibility: 'visible' }),
                        onComplete: () => gsap.set([images[1], textContents[1]], { visibility: 'visible' }),
                        onReverseComplete: () => gsap.set([images[1], textContents[1]], { visibility: 'hidden' })
                    }, 0.25);

                aboutTl.to([images[1], textContents[1]], {
                    opacity: 0,
                    duration: 0.2,
                    onStart: () => gsap.set([images[1], textContents[1]], { visibility: 'visible' }),
                    onComplete: () => {
                        gsap.set([images[1], textContents[1]], { visibility: 'hidden' });
                        updateActiveText(2);
                    },
                    onReverseComplete: () => {
                        gsap.set([images[1], textContents[1]], { visibility: 'visible' });
                        updateActiveText(1);
                    }
                }, 0.6)
                    .to([images[2], textContents[2]], {
                        opacity: 1,
                        duration: 0.2,
                        onStart: () => gsap.set([images[2], textContents[2]], { visibility: 'visible' }),
                        onComplete: () => gsap.set([images[2], textContents[2]], { visibility: 'visible' }),
                        onReverseComplete: () => gsap.set([images[2], textContents[2]], { visibility: 'hidden' })
                    }, 0.6);
            } else {
                aboutTl.to(images[0], {
                    opacity: 0,
                    duration: 0.2,
                    onStart: () => gsap.set(images[0], { visibility: 'visible' }),
                    onComplete: () => gsap.set(images[0], { visibility: 'hidden' }),
                    onReverseComplete: () => gsap.set(images[0], { visibility: 'visible' })
                }, 0.25)
                    .to(images[1], {
                        opacity: 1,
                        duration: 0.2,
                        onStart: () => gsap.set(images[1], { visibility: 'visible' }),
                        onComplete: () => gsap.set(images[1], { visibility: 'visible' }),
                        onReverseComplete: () => gsap.set(images[1], { visibility: 'hidden' })
                    }, 0.25);

                aboutTl.to(images[1], {
                    opacity: 0,
                    duration: 0.2,
                    onStart: () => gsap.set(images[1], { visibility: 'visible' }),
                    onComplete: () => gsap.set(images[1], { visibility: 'hidden' }),
                    onReverseComplete: () => gsap.set(images[1], { visibility: 'visible' })
                }, 0.6)
                    .to(images[2], {
                        opacity: 1,
                        duration: 0.2,
                        onStart: () => gsap.set(images[2], { visibility: 'visible' }),
                        onComplete: () => gsap.set(images[2], { visibility: 'visible' }),
                        onReverseComplete: () => gsap.set(images[2], { visibility: 'hidden' })
                    }, 0.6);
            }

        }

        // Entrance animation for About section elements when it starts entering the viewport
        const aboutEntranceTl = gsap.timeline({
            scrollTrigger: {
                trigger: '.about-text-content-wrapper',
                start: 'top 70%',
                toggleActions: 'play none none none'
            }
        });

        aboutEntranceTl.to('.about-header-title', {
            y: 0,
            opacity: 1,
            duration: 0.8,
            ease: 'power3.out'
        })
            .to('.about-subtitle', {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'power3.out'
            }, '-=0.6')
            .to('.about-description', {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'power3.out'
            }, '-=0.6')
            .to('.about-right-col', {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'power3.out'
            }, '-=0.6')
            .to('.about-image-frame', {
                clipPath: 'inset(0% 0% 0% 0%)',
                duration: 0.8,
                ease: 'power2.inOut'
            }, '-=0.8')
            .to('.about-scroll-img', {
                scale: 1,
                duration: 0.8,
                ease: 'power2.out'
            }, '-=0.8')
            .to('.about-scroll-indicator-container', {
                clipPath: 'inset(0% 0% 0% 0%)',
                duration: 0.8,
                ease: 'power2.inOut'
            }, '-=0.8');
    }

    // Entrance animation for treatments section elements in a single staggered timeline (same style as About section)
    // Only on desktop — mobile uses CSS transitions + IntersectionObserver in responsive.js
    if (isDesktop && document.querySelector('.treatments-header-badge')) {
        const treatmentsTl = gsap.timeline({
            scrollTrigger: {
                trigger: '.treatments-header-badge',
                start: 'top 95%',
                toggleActions: 'play none none none'
            }
        });

        treatmentsTl.to('.treatments-header-badge', {
            y: 0,
            opacity: 1,
            duration: 0.8,
            ease: 'power3.out'
        })
            .to('.treatments-left-col', {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'power3.out'
            }, '-=0.6')
            .to('.accordion-tab', {
                y: 0,
                opacity: 1,
                stagger: 0.1,
                duration: 0.8,
                ease: 'power3.out'
            }, '-=0.6');
    }

    // ----------------------------------------------------
    // 8. Sticky Smile Gallery Section Scroll
    // ----------------------------------------------------
    const gallerySection = document.querySelector('.smile-gallery-section');
    if (gallerySection && isDesktop) {
        const handle = document.querySelector('.gallery-scroll-indicator-handle');
        const container = document.querySelector('.gallery-scroll-indicator-container');
        const slides = document.querySelectorAll('.gallery-slide');
        const details = document.querySelectorAll('.gallery-details-data');

        if (handle && container && slides.length > 0) {
            const updateHandleY = () => {
                const scrollBarHeight = container.clientHeight || 540;
                const handleHeight = handle.clientHeight || 143;
                return scrollBarHeight - handleHeight;
            };

            const galleryTl = gsap.timeline({
                scrollTrigger: {
                    trigger: gallerySection,
                    start: 'top top',
                    end: 'bottom bottom',
                    scrub: 0.5,
                    onUpdate: (self) => {
                        const progress = self.progress;
                        const activeIndex = Math.min(Math.floor(progress * slides.length), slides.length - 1);

                        // Toggle slide active classes
                        slides.forEach((slide, idx) => {
                            if (idx === activeIndex) {
                                slide.classList.add('active');
                            } else {
                                slide.classList.remove('active');
                            }
                        });

                        // Toggle details active classes
                        details.forEach((detail, idx) => {
                            if (idx === activeIndex) {
                                detail.classList.add('active');
                            } else {
                                detail.classList.remove('active');
                            }
                        });
                    }
                }
            });

            // Move scroll indicator handle
            galleryTl.to(handle, {
                y: () => updateHandleY(),
                ease: 'none',
                duration: 1
            }, 0);
        }

        // Entrance animation for Smile Gallery when it enters the viewport
        const galleryEntranceTl = gsap.timeline({
            scrollTrigger: {
                trigger: '.gallery-header-badge',
                start: 'top 80%',
                toggleActions: 'play none none none'
            }
        });

        galleryEntranceTl.to('.gallery-header-badge', {
            y: 0,
            opacity: 1,
            duration: 0.8,
            ease: 'power3.out'
        })
            .to('.gallery-header-desc', {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'power3.out'
            }, '-=0.6')
            .to('.gallery-detail-card', {
                y: 0,
                opacity: 1,
                stagger: 0.1,
                duration: 0.8,
                ease: 'power3.out'
            }, '-=0.6')
            .to('.btn-gallery-action', {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'power3.out'
            }, '-=0.6')
            .to('.gallery-image-pair-container', {
                clipPath: 'inset(0% 0% 0% 0%)',
                duration: 0.8,
                ease: 'power2.inOut'
            }, '-=0.8')
            .to('.gallery-img', {
                scale: 1,
                duration: 0.8,
                ease: 'power2.out'
            }, '-=0.8')
            .to('.gallery-scroll-indicator-container', {
                clipPath: 'inset(0% 0% 0% 0%)',
                duration: 0.8,
                ease: 'power2.inOut'
            }, '-=0.8');

        // Initialize Testimonials Slider
        initTestimonialsSlider();

        // Initialize Book an Appointment animation
        initBookAppointmentAnimation();

        // Initialize Payment Options animation
        initPaymentOptionsAnimation();

        // Initialize Principal Dentist animation
        initPrincipalDentistAnimation();
    }
    
    // Initialize Principal Dentist Tabs for both desktop and mobile
    initDentistTabs();
    initServicePageTextAnimations();

    if (isDesktop) {
        initSectionFadeOut();
    }

    // ----------------------------------------------------
    // 10. Modal Smile Gallery Animations
    // ----------------------------------------------------
    const galleryModals = document.querySelectorAll('.cosmetic-full-modal');
    galleryModals.forEach(modal => {
        modal.addEventListener('show.bs.modal', () => {
            gsap.set(modal.querySelectorAll('.gallery-header-badge'), { y: 30, opacity: 0 });
            gsap.set(modal.querySelectorAll('.gallery-header-desc'), { y: 30, opacity: 0 });
            gsap.set(modal.querySelectorAll('.gallery-detail-card'), { y: 30, opacity: 0 });
            gsap.set(modal.querySelectorAll('.btn-gallery-action'), { y: 30, opacity: 0 });
            gsap.set(modal.querySelectorAll('.gallery-image-pair-container'), { clipPath: 'inset(50% 0% 50% 0%)' });
            gsap.set(modal.querySelectorAll('.gallery-img'), { scale: 1.15 });
            gsap.set(modal.querySelectorAll('.gallery-scroll-indicator-container'), { clipPath: 'inset(0% 0% 0% 0%)' });
            gsap.set(modal.querySelectorAll('.gallery-scroll-indicator-handle'), { y: 0 });
        });

        modal.addEventListener('shown.bs.modal', () => {
            const tl = gsap.timeline({ defaults: { ease: 'power3.out', duration: 0.8 } });
            tl.to(modal.querySelectorAll('.gallery-header-badge'), { y: 0, opacity: 1 })
              .to(modal.querySelectorAll('.gallery-header-desc'), { y: 0, opacity: 1 }, '-=0.6')
              .to(modal.querySelectorAll('.gallery-detail-card'), { y: 0, opacity: 1, stagger: 0.1 }, '-=0.6')
              .to(modal.querySelectorAll('.btn-gallery-action'), { y: 0, opacity: 1 }, '-=0.6')
              .to(modal.querySelectorAll('.gallery-image-pair-container'), { clipPath: 'inset(0% 0% 0% 0%)', duration: 0.8, ease: 'power2.inOut' }, '-=0.8')
              .to(modal.querySelectorAll('.gallery-img'), { scale: 1, duration: 0.8, ease: 'power2.out' }, '-=0.8')
              .set(modal.querySelectorAll('.gallery-scroll-indicator-container'), { clipPath: 'inset(0% 0% 0% 0%)' });
        });
    });

    // ----------------------------------------------------
    // 11. Initialize Modal More Services Slider
    // ----------------------------------------------------
    const allModals = document.querySelectorAll('.cosmetic-full-modal');
    allModals.forEach(modal => {
        initMoreServicesSliders(modal);
        initModalAccordions(modal);
        initModalReviewsSlider(modal);
        initModalTextAppearances(modal);
        initModalSmileGallery(modal);
    });
}

function initModalSmileGallery(modalElement) {
    const gallery = modalElement.querySelector('.cosmetic-modal-gallery-section');
    if (!gallery) return;

    const scrollContainer = modalElement.querySelector('.cosmetic-modal-body') || modalElement;
    const slides = gallery.querySelectorAll('.gallery-slide');
    const details = gallery.querySelectorAll('.gallery-details-data');
    const handle = gallery.querySelector('.gallery-scroll-indicator-handle');
    const handleContainer = gallery.querySelector('.gallery-scroll-indicator-container');

    if (!slides.length || !details.length) return;

    let ticking = false;

    const setActiveIndex = (activeIndex) => {
        slides.forEach((slide, index) => {
            slide.classList.toggle('active', index === activeIndex);
        });

        details.forEach((detail, index) => {
            detail.classList.toggle('active', index === activeIndex);
        });
    };

    const updateHandle = (progress) => {
        if (!handle || !handleContainer) return;

        const maxY = Math.max(0, handleContainer.clientHeight - handle.clientHeight);
        gsap.set(handle, { y: maxY * progress });
    };

    const updateGallery = () => {
        ticking = false;

        if (slides.length <= 1) {
            setActiveIndex(0);
            updateHandle(0);
            return;
        }

        const galleryRect = gallery.getBoundingClientRect();
        const containerRect = scrollContainer.getBoundingClientRect();
        const stickyWrapper = gallery.querySelector('.modal-gallery-sticky-wrapper');
        const stickyHeight = stickyWrapper ? stickyWrapper.offsetHeight : (scrollContainer.clientHeight || window.innerHeight);
        const galleryHeight = gallery.offsetHeight;
        const scrollTop = scrollContainer.scrollTop;
        const galleryTop = galleryRect.top - containerRect.top + scrollTop;
        const start = galleryTop;
        const end = galleryTop + galleryHeight - stickyHeight;
        const progress = gsap.utils.clamp(0, 1, (scrollTop - start) / Math.max(1, end - start));
        const activeIndex = Math.min(Math.floor(progress * slides.length), slides.length - 1);

        setActiveIndex(activeIndex);
        updateHandle(progress);
    };

    const requestUpdate = () => {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(updateGallery);
    };

    scrollContainer.addEventListener('scroll', requestUpdate, { passive: true });
    window.addEventListener('resize', requestUpdate);

    modalElement.addEventListener('shown.bs.modal', () => {
        setActiveIndex(0);
        updateHandle(0);
        requestUpdate();
    });
}

function initServicePageTextAnimations() {
    const serviceMain = document.querySelector('.single-service-main');
    if (!serviceMain) return;

    const animateIn = (elements, vars = {}) => {
        const targets = gsap.utils.toArray(elements).filter(Boolean);
        if (!targets.length) return null;

        const toVars = {
            y: 0,
            opacity: 1,
            stagger: vars.stagger || 0.12,
            duration: vars.duration || 0.8,
            ease: vars.ease || 'power3.out',
        };

        if (vars.trigger) {
            toVars.scrollTrigger = {
                trigger: vars.trigger,
                start: vars.start || 'top 80%',
                toggleActions: 'play none none none',
            };
        }

        return gsap.fromTo(targets, { y: vars.yStart || 30, opacity: 0 }, toVars);
    };

    const cosmeticHero = serviceMain.querySelector('.cosmetic-service-hero');
    if (cosmeticHero) {
        const heroTitle = cosmeticHero.querySelector('.cosmetic-hero-title');
        const heroDesc = cosmeticHero.querySelector('.cosmetic-hero-desc');
        const heroImage = cosmeticHero.querySelector('.cosmetic-hero-image-wrapper');
        const callBadge = cosmeticHero.querySelector('.floating-call-badge');

        gsap.set([heroTitle, heroDesc].filter(Boolean), { y: 30, opacity: 0 });
        if (heroImage) gsap.set(heroImage, { x: 50, opacity: 0, scale: 0.95 });
        if (callBadge) gsap.set(callBadge, { x: 50, opacity: 0 });

        const heroTl = gsap.timeline({ defaults: { ease: 'power3.out', duration: 0.8 } });
        if (heroTitle) heroTl.to(heroTitle, { y: 0, opacity: 1 });
        if (heroDesc) heroTl.to(heroDesc, { y: 0, opacity: 1 }, '-=0.6');
        if (heroImage) {
            heroTl.to(heroImage, {
                    x: 0,
                    opacity: 1,
                    scale: 1,
                    duration: 1.2,
                    ease: 'power4.out',
                }, '-=0.6');
        }
        if (callBadge) {
            heroTl.to(callBadge, {
                    x: 0,
                    opacity: 1,
                    duration: 0.6,
                    ease: 'back.out(1.7)',
                }, '-=0.7');
        }
    }

    const treatments = serviceMain.querySelector('.cosmetic-treatments-container');
    if (treatments) {
        animateIn(treatments.querySelectorAll('.cosmetic-treatment-row'), {
            trigger: treatments,
            stagger: 0.1,
        });
    }

    const membership = serviceMain.querySelector('.cosmetic-membership-section');
    if (membership) {
        animateIn([
            membership.querySelector('.cosmetic-membership-badge'),
            membership.querySelector('.cosmetic-membership-title'),
            membership.querySelector('.cosmetic-membership-desc'),
            membership.querySelector('.cosmetic-membership-price'),
            ...membership.querySelectorAll('.cosmetic-membership-benefit-item'),
            membership.querySelector('.cosmetic-membership-ctas'),
        ], {
            trigger: membership,
            start: 'top 80%',
            stagger: 0.12,
        });

        const membershipImage = membership.querySelector('.cosmetic-membership-img-col img');
        if (membershipImage) {
            gsap.fromTo(membershipImage,
                { x: -40, opacity: 0, scale: 0.96 },
                {
                    x: 0,
                    opacity: 1,
                    scale: 1,
                    duration: 1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: membership,
                        start: 'top 80%',
                        toggleActions: 'play none none none',
                    },
                }
            );
        }
    }

    const serviceDetails = serviceMain.querySelector('.service-details-section');
    if (serviceDetails) {
        animateIn(serviceDetails.querySelectorAll('.entry-content > *'), {
            trigger: serviceDetails,
            start: 'top 85%',
            stagger: 0.1,
        });
    }
}

function initModalTextAppearances(modalElement) {
    if (!modalElement) return;

    const getTextTargets = () => modalElement.querySelectorAll([
        '.cosmetic-modal-title-badge',
        '.cosmetic-modal-desc-text',
        '.btn-process-tab',
        '.process-step-card',
        '.symptom-card',
        '.benefits-step-card',
        '.gallery-header-badge',
        '.gallery-header-desc',
        '.gallery-detail-card',
        '.btn-gallery-action',
        '.reviews-rating-badge',
        '.reviews-nav-buttons',
        '.modal-review-slide.active .review-slide-title',
        '.modal-review-slide.active .review-slide-text',
        '.modal-review-slide.active .review-slide-stars',
        '.modal-review-slide.active .review-slide-author',
        '.fees-box-header',
        '.fee-row',
        '.cosmetic-accordion-section-header',
        '.cosmetic-accordion-trigger',
        '.more-services-title',
        '.more-services-nav',
        '.more-service-card-wrapper',
    ].join(', '));

    modalElement.addEventListener('show.bs.modal', () => {
        gsap.set(getTextTargets(), { y: 30, opacity: 0 });
    });

    modalElement.addEventListener('shown.bs.modal', () => {
        const targets = gsap.utils.toArray(getTextTargets());
        if (!targets.length) return;

        gsap.to(targets, {
            y: 0,
            opacity: 1,
            stagger: 0.06,
            duration: 0.8,
            ease: 'power3.out',
        });
    });
}

function initModalReviewsSlider(modalElement) {
    const section = modalElement.querySelector('.cosmetic-modal-reviews-section');
    if (!section) return;

    const slides = section.querySelectorAll('.modal-review-slide');
    const prevBtn = section.querySelector('.reviews-nav-btn.prev-btn');
    const nextBtn = section.querySelector('.reviews-nav-btn.next-btn');
    const progressBar = section.querySelector('.reviews-progress-bar');

    if (slides.length <= 1) return;

    let currentIndex = 0;
    let isTransitioning = false;

    slides.forEach((slide, index) => {
        const isActive = index === currentIndex;
        slide.classList.toggle('active', isActive);
        gsap.set(slide, { opacity: isActive ? 1 : 0 });
    });

    const updateProgress = () => {
        if (!progressBar) return;

        const widthPct = ((currentIndex + 1) / slides.length) * 100;
        gsap.to(progressBar, {
            width: `${widthPct}%`,
            duration: 0.45,
            ease: 'power2.out',
        });
    };

    const goToSlide = (newIndex) => {
        if (isTransitioning || newIndex === currentIndex) return;
        isTransitioning = true;

        const currentSlide = slides[currentIndex];
        const nextSlide = slides[newIndex];
        const currentParts = currentSlide.querySelectorAll('.review-slide-title, .review-slide-text, .review-slide-stars, .review-slide-author');
        const nextParts = nextSlide.querySelectorAll('.review-slide-title, .review-slide-text, .review-slide-stars, .review-slide-author');

        const timeline = gsap.timeline({
            onComplete: () => {
                currentSlide.classList.remove('active');
                nextSlide.classList.add('active');
                gsap.set(currentSlide, { opacity: 0, clearProps: 'transform' });
                gsap.set(currentParts, { clearProps: 'all' });
                gsap.set(nextSlide, { opacity: 1, clearProps: 'transform' });
                gsap.set(nextParts, { clearProps: 'all' });
                currentIndex = newIndex;
                updateProgress();
                isTransitioning = false;
            },
        });

        timeline
            .to(currentParts, {
                y: -20,
                opacity: 0,
                stagger: 0.04,
                duration: 0.25,
                ease: 'power2.in',
            })
            .call(() => {
                nextSlide.classList.add('active');
                gsap.set(nextSlide, { opacity: 1 });
            })
            .fromTo(nextParts,
                { y: 22, opacity: 0 },
                {
                    y: 0,
                    opacity: 1,
                    stagger: 0.06,
                    duration: 0.38,
                    ease: 'power2.out',
                }
            );
    };

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            goToSlide((currentIndex - 1 + slides.length) % slides.length);
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            goToSlide((currentIndex + 1) % slides.length);
        });
    }

    updateProgress();
}

function initModalAccordions(modalElement) {
    const accordions = modalElement.querySelectorAll('.cosmetic-accordion-list');
    if (!accordions.length) return;

    accordions.forEach(accordion => {
        const items = accordion.querySelectorAll('.cosmetic-accordion-item');

        items.forEach(item => {
            const trigger = item.querySelector('.cosmetic-accordion-trigger');
            const panel = item.querySelector('.cosmetic-accordion-panel');
            if (!trigger || !panel) return;

            const isActive = panel.classList.contains('active');
            trigger.classList.toggle('collapsed', !isActive);
            trigger.setAttribute('aria-expanded', isActive ? 'true' : 'false');
            gsap.set(panel, {
                height: isActive ? 'auto' : 0,
                opacity: isActive ? 1 : 0,
                overflow: 'hidden',
            });

            trigger.addEventListener('click', () => {
                const currentlyOpen = panel.classList.contains('active');

                items.forEach(otherItem => {
                    const otherTrigger = otherItem.querySelector('.cosmetic-accordion-trigger');
                    const otherPanel = otherItem.querySelector('.cosmetic-accordion-panel');
                    if (!otherTrigger || !otherPanel || otherPanel === panel || !otherPanel.classList.contains('active')) return;

                    otherPanel.classList.remove('active');
                    otherTrigger.classList.add('collapsed');
                    otherTrigger.setAttribute('aria-expanded', 'false');
                    gsap.to(otherPanel, {
                        height: 0,
                        opacity: 0,
                        duration: 0.45,
                        ease: 'power3.inOut',
                    });
                });

                if (currentlyOpen) {
                    panel.classList.remove('active');
                    trigger.classList.add('collapsed');
                    trigger.setAttribute('aria-expanded', 'false');
                    gsap.to(panel, {
                        height: 0,
                        opacity: 0,
                        duration: 0.45,
                        ease: 'power3.inOut',
                    });
                    return;
                }

                panel.classList.add('active');
                trigger.classList.remove('collapsed');
                trigger.setAttribute('aria-expanded', 'true');
                gsap.fromTo(panel,
                    { height: 0, opacity: 0 },
                    {
                        height: 'auto',
                        opacity: 1,
                        duration: 0.55,
                        ease: 'power3.inOut',
                    }
                );
            });
        });
    });
}

function initTreatmentsAccordion() {
    const tabs = document.querySelectorAll('.accordion-tab');
    if (tabs.length === 0) return;

    // Initialize content heights
    tabs.forEach(tab => {
        const content = tab.querySelector('.accordion-tab-content');
        if (tab.classList.contains('active')) {
            gsap.set(content, { height: 'auto', opacity: 1 });
        } else {
            gsap.set(content, { height: 0, opacity: 0 });
        }
    });

    tabs.forEach(tab => {
        const header = tab.querySelector('.accordion-tab-header');
        header.addEventListener('click', () => {
            const isMobile = window.innerWidth < 992;
            if (tab.classList.contains('active')) {
                if (isMobile) {
                    tab.classList.remove('active');
                    gsap.to(tab.querySelector('.accordion-tab-content'), {
                        height: 0,
                        opacity: 0,
                        duration: 0.5,
                        ease: 'power3.inOut'
                    });
                }
                return;
            }

            const activeTab = document.querySelector('.accordion-tab.active');

            // 1. Collapse active tab
            if (activeTab) {
                activeTab.classList.remove('active');
                gsap.to(activeTab.querySelector('.accordion-tab-content'), {
                    height: 0,
                    opacity: 0,
                    duration: 0.5,
                    ease: 'power3.inOut'
                });
            }

            // 2. Expand clicked tab
            tab.classList.add('active');
            gsap.fromTo(tab.querySelector('.accordion-tab-content'),
                { height: 0, opacity: 0 },
                {
                    height: 'auto',
                    opacity: 1,
                    duration: 0.5,
                    ease: 'power3.inOut'
                }
            );

            // 3. Update Left Column Image (Cross-fade)
            const imgFrame = document.querySelector('.treatment-image-frame');
            const activeImg = imgFrame.querySelector('.active-treatment-image');
            const newImgUrl = tab.getAttribute('data-image');
            const newImgAlt = tab.querySelector('.accordion-tab-title').textContent;

            if (activeImg && activeImg.getAttribute('src') !== newImgUrl) {
                // Create temporary overlay image
                const tempImg = document.createElement('img');
                tempImg.src = newImgUrl;
                tempImg.alt = newImgAlt;
                tempImg.className = 'active-treatment-image';
                tempImg.style.opacity = 0;
                imgFrame.appendChild(tempImg);

                // Fade out old, fade in new
                gsap.to(activeImg, {
                    opacity: 0,
                    duration: 0.5,
                    ease: 'power2.inOut',
                    onComplete: () => activeImg.remove()
                });

                gsap.to(tempImg, {
                    opacity: 1,
                    duration: 0.5,
                    ease: 'power2.inOut'
                });
            }

            // 4. Update Left Slide Counter
            const activeSlideNum = document.querySelector('.active-slide');
            const targetIndex = tab.getAttribute('data-index');
            if (activeSlideNum && activeSlideNum.textContent !== targetIndex) {
                gsap.to(activeSlideNum, {
                    y: -10,
                    opacity: 0,
                    duration: 0.25,
                    ease: 'power2.in',
                    onComplete: () => {
                        activeSlideNum.textContent = targetIndex;
                        gsap.fromTo(activeSlideNum,
                            { y: 10, opacity: 0 },
                            { y: 0, opacity: 1, duration: 0.25, ease: 'power2.out' }
                        );
                    }
                });
            }
        });
    });
}

function initTestimonialsSlider() {
    const section = document.querySelector('.testimonials-section');
    if (!section) return;

    const slides = section.querySelectorAll('.testimonial-slide');
    const prevBtn = section.querySelector('.prev-btn');
    const nextBtn = section.querySelector('.next-btn');
    const progressBar = section.querySelector('.testimonials-progress-bar');

    if (slides.length === 0) return;

    let currentIndex = 0;
    const totalSlides = slides.length;
    let isTransitioning = false;

    // Set initial progress bar width
    const updateProgress = () => {
        if (progressBar) {
            const widthPct = ((currentIndex + 1) / totalSlides) * 100;
            gsap.to(progressBar, { width: `${widthPct}%`, duration: 0.5, ease: 'power2.out' });
        }
    };

    updateProgress();

    const goToSlide = (newIndex) => {
        if (isTransitioning || newIndex === currentIndex) return;
        isTransitioning = true;

        const currentSlide = slides[currentIndex];
        const nextSlide = slides[newIndex];

        const timeline = gsap.timeline({
            onComplete: () => {
                // Clean up classes and inline styles
                currentSlide.classList.remove('active');
                nextSlide.classList.add('active');

                // Clear inline styles applied by GSAP so CSS handles it
                gsap.set(currentSlide, { clearProps: 'all' });
                gsap.set(currentSlide.querySelectorAll('.testimonial-title, .testimonial-text, .testimonial-stars, .testimonial-author'), { clearProps: 'all' });

                currentIndex = newIndex;
                updateProgress();
                isTransitioning = false;
            }
        });

        // Fade/slide out current slide elements
        timeline.to(currentSlide.querySelector('.testimonial-title'), { y: -20, opacity: 0, duration: 0.3, ease: 'power2.in' })
            .to(currentSlide.querySelector('.testimonial-text'), { y: -20, opacity: 0, duration: 0.3, ease: 'power2.in' }, '-=0.25')
            .to(currentSlide.querySelector('.testimonial-stars'), { scale: 0.8, opacity: 0, duration: 0.2, ease: 'power2.in' }, '-=0.25')
            .to(currentSlide.querySelector('.testimonial-author'), { y: -10, opacity: 0, duration: 0.2, ease: 'power2.in' }, '-=0.2')

            // Set next slide to display: flex (by adding active) during transition
            .call(() => {
                nextSlide.classList.add('active');
            })

            // Fade/slide in next slide elements using fromTo to force exact start states
            .fromTo(nextSlide.querySelector('.testimonial-title'),
                { y: 20, opacity: 0 },
                { y: 0, opacity: 1, duration: 0.4, ease: 'power2.out' }
            )
            .fromTo(nextSlide.querySelector('.testimonial-text'),
                { y: 20, opacity: 0 },
                { y: 0, opacity: 1, duration: 0.4, ease: 'power2.out' },
                '-=0.3'
            )
            .fromTo(nextSlide.querySelector('.testimonial-stars'),
                { scale: 0.8, opacity: 0 },
                { scale: 1, opacity: 1, duration: 0.3, ease: 'back.out(1.5)' },
                '-=0.3'
            )
            .fromTo(nextSlide.querySelector('.testimonial-author'),
                { y: 10, opacity: 0 },
                { y: 0, opacity: 1, duration: 0.3, ease: 'power2.out' },
                '-=0.2'
            );
    };

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            const nextIdx = (currentIndex - 1 + totalSlides) % totalSlides;
            goToSlide(nextIdx);
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            const nextIdx = (currentIndex + 1) % totalSlides;
            goToSlide(nextIdx);
        });
    }

    // Viewport entrance animation for the testimonials section elements (desktop only)
    if (window.innerWidth >= 992) {
        const testimonialsEntranceTl = gsap.timeline({
            scrollTrigger: {
                trigger: section,
                start: 'top 80%',
                toggleActions: 'play none none none'
            }
        });

        // Animate quote marks and active slide items on viewport entry
        gsap.set([section.querySelector('.left-quote'), section.querySelector('.right-quote')], { scale: 0.5, opacity: 0 });
        gsap.set(section.querySelector('.testimonials-header'), { y: 30, opacity: 0 });
        gsap.set(slides[0].querySelectorAll('.testimonial-title, .testimonial-text, .testimonial-stars, .testimonial-author'), { y: 30, opacity: 0 });

        testimonialsEntranceTl.to(section.querySelector('.testimonials-header'), {
            y: 0,
            opacity: 1,
            duration: 0.8,
            ease: 'power3.out'
        })
            .to([section.querySelector('.left-quote'), section.querySelector('.right-quote')], {
                scale: 1,
                opacity: 0.2,
                duration: 1,
                ease: 'back.out(1.7)'
            }, '-=0.6')
            .to(slides[0].querySelector('.testimonial-title'), {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'power3.out'
            }, '-=0.8')
            .to(slides[0].querySelector('.testimonial-text'), {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: 'power3.out'
            }, '-=0.6')
            .to(slides[0].querySelector('.testimonial-stars'), {
                y: 0,
                scale: 1,
                opacity: 1,
                duration: 0.6,
                ease: 'back.out(1.7)'
            }, '-=0.6')
            .to(slides[0].querySelector('.testimonial-author'), {
                y: 0,
                opacity: 1,
                duration: 0.6,
                ease: 'power3.out'
            }, '-=0.5');
    }
}

function initDentistTabs() {
    const section = document.querySelector('.principal-dentist-section');
    if (!section) return;

    const buttons = section.querySelectorAll('.dentist-tab-btn');
    const bgImages = section.querySelectorAll('.dentist-bg-img');
    const descTexts = section.querySelectorAll('.dentist-desc-text');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            if (btn.classList.contains('active')) return;

            const targetIndex = btn.getAttribute('data-target');

            // 1. Update button active states
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // 2. Cross-fade backgrounds
            bgImages.forEach(img => {
                const imgTag = img.querySelector('.dentist-img-tag');
                if (img.getAttribute('data-tab') === targetIndex) {
                    img.classList.add('active');
                    if (imgTag) {
                        gsap.fromTo(imgTag, 
                            { scale: 1.15, opacity: 0 }, 
                            { scale: 1, opacity: 1, duration: 1.2, ease: 'power2.out' }
                        );
                    }
                } else {
                    img.classList.remove('active');
                    if (imgTag) {
                        gsap.set(imgTag, { scale: 1.15, opacity: 0 });
                    }
                }
            });

            // 3. Cross-fade text descriptions
            descTexts.forEach(desc => {
                const paragraph = desc.querySelector('p');
                if (desc.getAttribute('data-tab') === targetIndex) {
                    desc.classList.add('active');
                    if (paragraph) {
                        gsap.fromTo(paragraph,
                            { y: 80, opacity: 0 },
                            { y: 0, opacity: 1, duration: 0.6, ease: 'power3.out' }
                        );
                    }
                } else {
                    desc.classList.remove('active');
                }
            });
        });
    });
}

function initBookAppointmentAnimation() {
    const section = document.querySelector('.book-appointment-section');
    if (!section) return;

    if (window.innerWidth >= 992) {
        const bg = section.querySelector('.book-appointment-bg');
        const card = section.querySelector('.book-appointment-card');
        const title = section.querySelector('.book-appointment-title');
        const text = section.querySelector('.book-appointment-text');
        const btn = section.querySelector('.book-appointment-btn');

        // 1. Initial State Setup
        gsap.set(bg, { scale: 1.2, opacity: 0 });
        gsap.set(card, { y: 50, opacity: 0 });
        gsap.set([title, text, btn], { y: 30, opacity: 0 });

        // 2. Timeline
        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: section,
                start: 'top 80%',
                toggleActions: 'play none none none'
            }
        });

        tl.to(bg, {
            scale: 1,
            opacity: 1,
            duration: 1.5,
            ease: 'power2.out'
        })
        .to(card, {
            y: 0,
            opacity: 1,
            duration: 1,
            ease: 'power3.out'
        }, '-=1.2')
        .to([title, text], {
            y: 0,
            opacity: 1,
            stagger: 0.2,
            duration: 0.8,
            ease: 'power3.out'
        }, '-=0.8')
        .to(btn, {
            y: 0,
            opacity: 1,
            duration: 0.8,
            ease: 'back.out(1.7)'
        }, '-=0.6');
    }
}

function initPaymentOptionsAnimation() {
    const section = document.querySelector('.payment-options-section');
    if (!section) return;

    if (window.innerWidth >= 992) {
        const header = section.querySelector('.payment-header');
        const title = section.querySelector('.payment-title');
        const desc = section.querySelector('.payment-desc');
        const cards = section.querySelectorAll('.payment-card');

        // 1. Initial State
        gsap.set([header, title, desc], { y: 30, opacity: 0 });
        gsap.set(cards, { y: 50, opacity: 0 });

        // 2. Timeline
        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: section,
                start: 'top 80%',
                toggleActions: 'play none none none'
            }
        });

        tl.to(header, {
            y: 0,
            opacity: 1,
            duration: 0.8,
            ease: 'power3.out'
        })
        .to([title, desc], {
            y: 0,
            opacity: 1,
            stagger: 0.15,
            duration: 0.6,
            ease: 'power3.out'
        }, '-=0.4')
        .to(cards, {
            y: 0,
            opacity: 1,
            stagger: 0.2,
            duration: 0.8,
            ease: 'power3.out'
        }, '-=0.4');
    }
}

function initPrincipalDentistAnimation() {
    const section = document.querySelector('.principal-dentist-section');
    if (!section) return;

    if (window.innerWidth >= 992) {
        const bgWrapper = section.querySelector('.dentist-bg-wrapper');
        const title = section.querySelector('.dentist-section-title');
        const descText = section.querySelector('.dentist-desc-wrapper');
        const tabsNav = section.querySelector('.dentist-tabs-nav');

        // 1. Initial State
        gsap.set(bgWrapper, { scale: 1.15, opacity: 0 });
        gsap.set([title, descText, tabsNav], { y: 100, opacity: 0 });

        // 2. Timeline
        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: section,
                start: 'top 80%',
                toggleActions: 'play none none none'
            }
        });

        tl.to(bgWrapper, {
            scale: 1,
            opacity: 1,
            duration: 1.5,
            ease: 'power2.out'
        })
        .to(title, {
            y: 0,
            opacity: 1,
            duration: 0.8,
            ease: 'power3.out'
        }, '-=1.0')
        .to(descText, {
            y: 0,
            opacity: 1,
            duration: 0.8,
            ease: 'power3.out'
        }, '-=0.6')
        .to(tabsNav, {
            y: 0,
            opacity: 1,
            duration: 0.8,
            ease: 'back.out(1.7)'
        }, '-=0.5');
    }
}

function initSectionFadeOut() {
    // Sections that get a fade-out as they scroll away.
    // The sticky About & Gallery sections are excluded because they manage
    // their own scroll-bound ScrollTrigger behaviour.
    const fadeOutSections = [
        '.hero-section',
        '.key-treatments-section',
        '.testimonials-section',
        '.principal-dentist-section',
        '.payment-options-section',
        '.book-appointment-section',
    ];

    fadeOutSections.forEach(selector => {
        const el = document.querySelector(selector);
        if (!el) return;

        gsap.to(el, {
            opacity: 0,
            y: -50,
            ease: 'none',
            scrollTrigger: {
                trigger: el,
                // Start fading when the bottom edge of the section is 65% down the viewport
                start: 'bottom 65%',
                // Fully faded out when the section's bottom reaches the top of the viewport
                end: 'bottom top',
                scrub: 1.2,
                onEnterBack: () => {
                    gsap.set(el, { clearProps: 'opacity,y' });
                },
            },
        });
    });
}
function initMoreServicesSliders(modalElement) {
    const container = modalElement.querySelector('.more-services-slider-container');
    const prevBtn = modalElement.querySelector('.more-services-nav-btn.prev-btn');
    const nextBtn = modalElement.querySelector('.more-services-nav-btn.next-btn');
    const progressBar = modalElement.querySelector('.more-services-progress-bar');

    if (!container || !progressBar) return;

    const updateSliderUI = () => {
        const scrollLeft = container.scrollLeft;
        const maxScroll = container.scrollWidth - container.clientWidth;
        
        // Update progress bar
        const progressPct = maxScroll > 0 ? (scrollLeft / maxScroll) * 100 : 0;
        // Start handle width at 30% and grow to 100%
        const barWidth = 30 + (progressPct * 0.7);
        progressBar.style.width = `${barWidth}%`;

        // Update button states
        if (scrollLeft <= 5) {
            prevBtn.classList.remove('active');
        } else {
            prevBtn.classList.add('active');
        }

        if (scrollLeft >= maxScroll - 5) {
            nextBtn.classList.remove('active');
        } else {
            nextBtn.classList.add('active');
        }
    };

    container.addEventListener('scroll', updateSliderUI);
    window.addEventListener('resize', updateSliderUI);

    // Initial run
    updateSliderUI();

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            container.scrollBy({ left: -350, behavior: 'smooth' });
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            container.scrollBy({ left: 350, behavior: 'smooth' });
        });
    }
}
