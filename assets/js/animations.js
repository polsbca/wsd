/**
 * Front Page Animations using GSAP and ScrollTrigger
 * 
 * Waterside Dental Design Theme
 */

window.addEventListener('load', () => {
    // Register ScrollTrigger plugin
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
        setTimeout(() => {
            initAnimations();
            ScrollTrigger.refresh();
        }, 500);
    }
});

function initAnimations() {
    const isDesktop = window.innerWidth >= 992;

    // ----------------------------------------------------
    // 1. Initial State Setup (Prevents abrupt jumps on load)
    //    Desktop only — mobile uses CSS transitions via .mobile-visible
    // ----------------------------------------------------
    if (isDesktop) {
        gsap.set('.header-top, #masthead.site-header', { y: -50, opacity: 0 });
        gsap.set('.hero-title, .hero-description', { y: 30, opacity: 0 });
        gsap.set('.hero-buttons .btn', { y: 20, opacity: 0 });
        gsap.set('.stat', { y: 20, opacity: 0 });
        gsap.set('.hero-image-wrapper', { x: 50, opacity: 0, scale: 0.95 });
        gsap.set('.call-us-tab', { x: 50, opacity: 0 });
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
            .to('#masthead.site-header', { y: 0, opacity: 1, duration: 0.8 }, '-=0.6')

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
    } else {
        // Mobile: simple entrance animation for hero elements
        // Use a lightweight GSAP timeline that won't conflict with CSS mobile-visible transitions
        gsap.set('.mobile-header', { y: -30, opacity: 0 });
        gsap.set('.hero-title, .hero-description', { y: 20, opacity: 0 });
        gsap.set('.hero-buttons .btn', { y: 15, opacity: 0 });
        gsap.set('.stat', { y: 15, opacity: 0 });
        gsap.set('.hero-image-wrapper', { y: 30, opacity: 0 });
        gsap.set('.call-us-tab', { opacity: 0 });

        const mobileTl = gsap.timeline({ defaults: { ease: 'power2.out', duration: 0.6 } });

        mobileTl
            .to('.mobile-header', { y: 0, opacity: 1, duration: 0.5 })
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

        if (handle && container && images.length >= 3) {
            // Set initial state
            gsap.set(images[0], { opacity: 1, visibility: 'visible' });
            gsap.set(images[1], { opacity: 0, visibility: 'hidden' });
            gsap.set(images[2], { opacity: 0, visibility: 'hidden' });
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

            // 2. Cross-fade images
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

            // Bypass ScrollTrigger track immediately when scrolling on the left side text content
            if (leftCol) {
                leftCol.addEventListener('wheel', (e) => {
                    if (e.deltaY > 0) {
                        const smileGallery = document.querySelector('.smile-gallery-section');
                        if (smileGallery) {
                            e.preventDefault();
                            smileGallery.scrollIntoView({ behavior: 'smooth' });
                        }
                    } else if (e.deltaY < 0) {
                        const keyTreatments = document.querySelector('.key-treatments-section');
                        if (keyTreatments) {
                            e.preventDefault();
                            keyTreatments.scrollIntoView({ behavior: 'smooth' });
                        }
                    }
                }, { passive: false });

                let touchStartYLeft = 0;
                leftCol.addEventListener('touchstart', (e) => {
                    touchStartYLeft = e.touches[0].clientY;
                }, { passive: true });

                leftCol.addEventListener('touchmove', (e) => {
                    const touchEndYLeft = e.touches[0].clientY;
                    const diffYLeft = touchStartYLeft - touchEndYLeft;
                    if (Math.abs(diffYLeft) > 50) {
                        if (diffYLeft > 0) {
                            const smileGallery = document.querySelector('.smile-gallery-section');
                            if (smileGallery) {
                                e.preventDefault();
                                smileGallery.scrollIntoView({ behavior: 'smooth' });
                            }
                        } else {
                            const keyTreatments = document.querySelector('.key-treatments-section');
                            if (keyTreatments) {
                                e.preventDefault();
                                keyTreatments.scrollIntoView({ behavior: 'smooth' });
                            }
                        }
                    }
                }, { passive: false });
            }
        }

        // Entrance animation for About section elements when it starts entering the viewport
        const aboutEntranceTl = gsap.timeline({
            scrollTrigger: {
                trigger: '.about-text-content',
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
    if (isDesktop) {
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

    // ----------------------------------------------------
    // 9. Section Fade-Out on Scroll (Desktop only)
    //    Each section fades + lifts out as the next scrolls in
    // ----------------------------------------------------
    if (isDesktop) {
        initSectionFadeOut();
    }
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

