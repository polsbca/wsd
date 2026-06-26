/**
 * Site-wide GSAP smooth scrolling.
 *
 * Uses GSAP core so the site does not depend on Club-only ScrollSmoother.
 */
(function () {
    if (typeof gsap === 'undefined') return;

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const scrollState = { y: window.scrollY };
    let targetY = window.scrollY;
    let scrollTween = null;

    if (typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
    }

    const getMaxScroll = () => Math.max(0, document.documentElement.scrollHeight - window.innerHeight);
    const clampY = (value) => gsap.utils.clamp(0, getMaxScroll(), value);

    const syncScrollState = () => {
        if (scrollTween && scrollTween.isActive()) return;
        targetY = window.scrollY;
        scrollState.y = window.scrollY;
    };

    const tweenTo = (y, duration = 0.45) => {
        targetY = clampY(y);

        if (scrollTween) {
            scrollTween.kill();
        }

        scrollState.y = window.scrollY;
        scrollTween = gsap.to(scrollState, {
            y: targetY,
            duration,
            ease: 'power2.out',
            overwrite: true,
            onUpdate: () => {
                window.scrollTo(0, scrollState.y);
                if (typeof ScrollTrigger !== 'undefined') {
                    ScrollTrigger.update();
                }
            },
            onComplete: () => {
                scrollState.y = window.scrollY;
                targetY = window.scrollY;
            },
        });
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
        return header ? header.getBoundingClientRect().height + 20 : 20;
    };

    const handleAnchorClick = (event) => {
        const anchor = event.target.closest('a[href*="#"]');
        if (!anchor || anchor.hasAttribute('data-bs-toggle') || anchor.hasAttribute('data-bs-target')) return;

        const target = getAnchorTarget(anchor);
        if (!target || target.closest('.modal')) return;

        event.preventDefault();
        const y = target.getBoundingClientRect().top + window.scrollY - getHeaderOffset();

        tweenTo(y, prefersReducedMotion.matches ? 0 : 0.55);

        if (history.pushState) {
            history.pushState(null, '', anchor.hash);
        }
    };

    window.addEventListener('scroll', syncScrollState, { passive: true });
    window.addEventListener('resize', syncScrollState);
    document.addEventListener('click', handleAnchorClick);
})();
