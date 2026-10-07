/**
 * Site-wide smooth (inertia) scrolling.
 *
 * Lenis drives wheel/trackpad scrolling on pointer devices and is ticked by
 * GSAP so ScrollTrigger pins, scrubs and sticky sections stay in sync.
 * Touch devices keep native scrolling. Falls back to GSAP-tweened anchor
 * scrolling when Lenis is unavailable.
 */
(function () {
    if (typeof gsap === 'undefined') return;

    const hasScrollTrigger = typeof ScrollTrigger !== 'undefined';
    if (hasScrollTrigger) {
        gsap.registerPlugin(ScrollTrigger);
    }

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const isTouchOnly = window.matchMedia('(hover: none)').matches;
    const LenisCtor = window.Lenis || (typeof Lenis !== 'undefined' ? Lenis : null);

    let lenis = null;

    const isScrollableNode = (node) => {
        if (node === document.documentElement || node === document.body) return false;
        if (node.scrollHeight <= node.clientHeight + 1) return false;
        const overflowY = getComputedStyle(node).overflowY;
        return overflowY === 'auto' || overflowY === 'scroll';
    };

    const shouldPreventSmooth = (node) => {
        if (node.matches('.modal, .offcanvas, .mobile-navigation-drawer, select, textarea, iframe')) return true;
        return isScrollableNode(node);
    };

    const initLenis = () => {
        if (!LenisCtor || isTouchOnly || prefersReducedMotion.matches) return null;

        const instance = new LenisCtor({
            lerp: 0.1,
            wheelMultiplier: 1,
            smoothWheel: true,
            syncTouch: false,
            prevent: shouldPreventSmooth,
        });

        if (hasScrollTrigger) {
            instance.on('scroll', ScrollTrigger.update);
        }

        gsap.ticker.add((time) => {
            instance.raf(time * 1000);
        });
        gsap.ticker.lagSmoothing(0);

        document.documentElement.classList.add('wsd-smooth-scroll');

        return instance;
    };

    lenis = initLenis();
    window.wsdLenis = lenis;

    /* Pause page scrolling while Bootstrap modals are open */
    document.querySelectorAll('.modal').forEach((modal) => {
        modal.setAttribute('data-lenis-prevent', '');
    });

    document.addEventListener('show.bs.modal', (event) => {
        if (event.target) event.target.setAttribute('data-lenis-prevent', '');
        if (lenis) lenis.stop();
    });

    document.addEventListener('hidden.bs.modal', () => {
        if (!lenis) return;
        if (document.querySelector('.modal.show')) return;
        lenis.start();
    });

    /* Fallback tween used when Lenis is not running */
    const scrollState = { y: window.scrollY };
    let scrollTween = null;

    const getMaxScroll = () => Math.max(0, document.documentElement.scrollHeight - window.innerHeight);
    const clampY = (value) => gsap.utils.clamp(0, getMaxScroll(), value);

    const tweenTo = (y, duration) => {
        const targetY = clampY(y);

        if (scrollTween) {
            scrollTween.kill();
        }

        if (!duration) {
            window.scrollTo(0, targetY);
            return;
        }

        scrollState.y = window.scrollY;
        scrollTween = gsap.to(scrollState, {
            y: targetY,
            duration,
            ease: 'power3.out',
            overwrite: true,
            onUpdate: () => {
                window.scrollTo(0, scrollState.y);
                if (hasScrollTrigger) {
                    ScrollTrigger.update();
                }
            },
        });
    };

    /**
     * Shared helper for other scripts: smooth when possible, instant otherwise.
     *
     * @param {number|Element} target Y position or element.
     * @param {{offset?: number, immediate?: boolean, duration?: number}} [options]
     */
    window.wsdScrollTo = (target, options = {}) => {
        const offset = options.offset || 0;
        const immediate = !!options.immediate || prefersReducedMotion.matches;
        const y = typeof target === 'number'
            ? target + offset
            : target.getBoundingClientRect().top + window.scrollY + offset;

        if (lenis) {
            lenis.scrollTo(Math.max(0, y), {
                immediate,
                duration: options.duration || 1.1,
                easing: (t) => 1 - Math.pow(1 - t, 4),
                force: true,
            });
            return;
        }

        tweenTo(y, immediate ? 0 : (options.duration || 0.8));
    };

    const getAnchorTarget = (anchor) => {
        const href = anchor.getAttribute('href');
        if (!href || href === '#') return null;

        let url;
        try {
            url = new URL(href, window.location.href);
        } catch (error) {
            return null;
        }

        if (url.origin !== window.location.origin || url.pathname !== window.location.pathname || !url.hash) {
            return null;
        }

        const id = decodeURIComponent(url.hash.slice(1));
        const namedTargets = document.getElementsByName(id);
        return document.getElementById(id) || namedTargets[0] || null;
    };

    const getHeaderOffset = () => {
        const header = document.querySelector('#masthead.site-header');
        if (header && header.offsetParent !== null) {
            return header.getBoundingClientRect().height + 20;
        }
        const mobileHeader = document.querySelector('.mobile-header');
        return mobileHeader ? mobileHeader.getBoundingClientRect().height + 20 : 20;
    };

    const handleAnchorClick = (event) => {
        if (event.defaultPrevented) return;

        const anchor = event.target.closest('a[href*="#"]');
        if (!anchor || anchor.hasAttribute('data-bs-toggle') || anchor.hasAttribute('data-bs-target')) return;

        if (anchor.closest('.contact-tablet-tabs')) {
            return;
        }

        const target = getAnchorTarget(anchor);
        if (!target || target.closest('.modal')) return;

        event.preventDefault();
        window.wsdScrollTo(target, { offset: -getHeaderOffset() });

        if (history.pushState) {
            history.pushState(null, '', anchor.hash);
        }
    };

    document.addEventListener('click', handleAnchorClick);

    /* Lenis caches page height; re-measure after late layout changes */
    if (lenis) {
        window.addEventListener('load', () => lenis.resize(), { once: true });
        if (hasScrollTrigger) {
            ScrollTrigger.addEventListener('refresh', () => lenis.resize());
        }
    }
})();
