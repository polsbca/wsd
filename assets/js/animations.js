/**
 * Front Page Animations using GSAP and ScrollTrigger
 * 
 * Waterside Dental Design Theme
 */

let wsdAnimationsInitialized = false;

function bootAnimations() {
  if (wsdAnimationsInitialized) {
    return;
  }

  if (typeof gsap === "undefined" || typeof ScrollTrigger === "undefined") {
    return;
  }

  wsdAnimationsInitialized = true;
        gsap.registerPlugin(ScrollTrigger);
            initAnimations();
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", bootAnimations);
} else {
  bootAnimations();
}

window.addEventListener("load", () => {
  if (typeof ScrollTrigger !== "undefined") {
            ScrollTrigger.refresh();
    }
});

function initAnimations() {
    const isDesktop = window.innerWidth >= 992;
  const hasContactPage = document.querySelector(".contact-page-main") !== null;
  const hasDentalReferralsPage =
    document.querySelector(".dental-referrals-main") !== null;
  const hasTeamsPage = document.querySelector(".teams-page-main") !== null;
  const hasFeesPage = document.querySelector(".fees-page-main") !== null;
  const hasSmileGalleryPage =
    document.querySelector(".smile-gallery-page-main") !== null;
  const hasBlogsPage = document.querySelector(".blogs-page-main") !== null;
  const hasBlogDetailPage =
    document.querySelector(".blog-detail-main") !== null;
  const hasHero = document.querySelector(".hero-title") !== null;
  const hasStandardHero =
    document.querySelector(".hero-section .hero-title") !== null &&
    !hasContactPage &&
    !hasDentalReferralsPage &&
    !hasTeamsPage &&
    !hasFeesPage &&
    !hasSmileGalleryPage &&
    !hasBlogsPage &&
    !hasBlogDetailPage;
  const hasCallUsTab = document.querySelector(".call-us-tab") !== null;
  const heroCurtainClosed = {
    clipPath: "inset(0% 0% 100% 0%)",
    opacity: 1,
    x: 0,
    y: 0,
    scale: 1,
  };
  const heroCurtainOpen = {
    clipPath: "inset(0% 0% 0% 0%)",
    duration: 1.25,
    ease: "power3.inOut",
  };
  const heroCurtainOpenMobile = {
    clipPath: "inset(0% 0% 0% 0%)",
    duration: 0.85,
    ease: "power2.inOut",
  };

    // ----------------------------------------------------
    // 1. Initial State Setup (Prevents abrupt jumps on load)
    //    Desktop only — mobile uses CSS transitions via .mobile-visible
    // ----------------------------------------------------
    if (isDesktop) {
    gsap.set(".header-top", { y: -50, opacity: 0 });
        if (hasHero) {
      gsap.set(".hero-title, .hero-description", { y: 30, opacity: 0 });
    }
    if (hasStandardHero) {
      gsap.set(".hero-buttons .btn", { y: 20, opacity: 0 });
      gsap.set(".stat", { y: 20, opacity: 0 });
      gsap.set(".hero-section .hero-image-wrapper", heroCurtainClosed);
    }
    if (hasCallUsTab) {
      gsap.set(".call-us-tab", { x: 70, opacity: 0 });
    }
    if (hasContactPage) {
      gsap.set(".contact-sidebar", { y: 30, opacity: 0 });
      gsap.set(".contact-main-panel", { x: 50, opacity: 0 });
      gsap.set(
        ".contact-form-block .contact-panel-title, .contact-form-block .contact-field, .contact-form-block .contact-consent, .contact-form-block .contact-submit-btn",
        { y: 30, opacity: 0 },
      );
    }
    if (hasDentalReferralsPage) {
      gsap.set(".dental-referrals-form-panel", { x: 50, opacity: 0 });
      gsap.set(
        ".dental-referrals-section-title, .dental-referrals-field, .dental-referrals-checkbox, .dental-referrals-other-field, .dental-referrals-media-uploads, .dental-referrals-consent, .dental-referrals-submit-btn",
        { y: 30, opacity: 0 },
      );
    }
    if (hasTeamsPage) {
      gsap.set(".teams-page-main .hero-buttons .btn", { y: 20, opacity: 0 });
      gsap.set(".teams-page-main .hero-image-wrapper", heroCurtainClosed);
      gsap.set(
        ".teams-clinical-section .teams-clinical-heading-wrap, .teams-clinical-section .teams-clinical-slider",
        { y: 40, opacity: 0 },
      );
      gsap.set(
        ".teams-support-section .teams-support-header, .teams-support-section .teams-support-slider",
        { y: 40, opacity: 0 },
      );
    }
    if (hasFeesPage) {
      gsap.set(".fees-page-main .hero-buttons .btn", { y: 20, opacity: 0 });
      gsap.set(".fees-page-main .hero-image-wrapper", heroCurtainClosed);
    }
    if (hasSmileGalleryPage) {
      gsap.set(".smile-gallery-page-main .hero-buttons .btn", {
        y: 20,
        opacity: 0,
      });
      gsap.set(
        ".smile-gallery-page-main .hero-image-wrapper",
        heroCurtainClosed,
      );
    }
    if (hasBlogsPage) {
      gsap.set(".blogs-page-main .hero-buttons .btn", {
        y: 20,
        opacity: 0,
      });
      gsap.set(".blogs-page-main .hero-image-wrapper", heroCurtainClosed);
        }
    }

    // ----------------------------------------------------
    // 2. Entrance Animation Timeline (Page Load)
    //    Desktop: full GSAP timeline. Mobile: lightweight fade-in.
    // ----------------------------------------------------
    if (isDesktop) {
    const mainTimeline = gsap.timeline({
      defaults: { ease: "power3.out", duration: 1 },
    });

        mainTimeline
      // Fade & Slide in Header Top (nav menu stays static — no load animation)
      .to(".header-top", { y: 0, opacity: 1, duration: 0.8 });

        if (hasHero) {
            mainTimeline
                // Reveal Hero Text
        .to(".hero-title", { y: 0, opacity: 1, duration: 0.8 }, "-=0.4")
        .to(".hero-description", { y: 0, opacity: 1, duration: 0.8 }, "-=0.6");
    }

    if (hasTeamsPage) {
      mainTimeline
        .to(
          ".teams-page-main .hero-buttons .btn",
          {
                    y: 0,
                    opacity: 1,
            stagger: 0.12,
                    duration: 0.6,
            ease: "back.out(1.7)",
          },
          "-=0.5",
        )
        .to(
          ".teams-page-main .hero-image-wrapper",
          heroCurtainOpen,
          "-=0.8",
        );
    }

    if (hasFeesPage) {
      mainTimeline
        .to(
          ".fees-page-main .hero-buttons .btn",
          {
                    y: 0,
                    opacity: 1,
            stagger: 0.12,
            duration: 0.6,
            ease: "back.out(1.7)",
          },
          "-=0.5",
        )
        .to(
          ".fees-page-main .hero-image-wrapper",
          heroCurtainOpen,
          "-=0.8",
        );
    }

    if (hasSmileGalleryPage) {
      mainTimeline
        .to(
          ".smile-gallery-page-main .hero-buttons .btn",
          {
            y: 0,
            opacity: 1,
            stagger: 0.12,
            duration: 0.6,
            ease: "back.out(1.7)",
          },
          "-=0.5",
        )
        .to(
          ".smile-gallery-page-main .hero-image-wrapper",
          heroCurtainOpen,
          "-=0.8",
        );
    }

    if (hasBlogsPage) {
      mainTimeline
        .to(
          ".blogs-page-main .hero-buttons .btn",
          {
            y: 0,
            opacity: 1,
            stagger: 0.12,
            duration: 0.6,
            ease: "back.out(1.7)",
          },
          "-=0.5",
        )
        .to(
          ".blogs-page-main .hero-image-wrapper",
          heroCurtainOpen,
          "-=0.8",
        );
    }

    if (hasContactPage) {
      mainTimeline
        .to(".contact-sidebar", { y: 0, opacity: 1, duration: 0.8 }, "-=0.4")
        .to(
          ".contact-main-panel",
          {
                    x: 0,
                    opacity: 1,
                    duration: 1.2,
            ease: "power4.out",
          },
          "-=0.6",
        )
        .to(
          ".contact-form-block .contact-panel-title",
          { y: 0, opacity: 1, duration: 0.6 },
          "-=0.8",
        )
        .to(
          ".contact-form-block .contact-field",
          {
            y: 0,
            opacity: 1,
            stagger: 0.08,
            duration: 0.5,
          },
          "-=0.4",
        )
        .to(
          ".contact-form-block .contact-consent",
          { y: 0, opacity: 1, duration: 0.5 },
          "-=0.25",
        )
        .to(
          ".contact-form-block .contact-submit-btn",
          {
            y: 0,
            opacity: 1,
            duration: 0.5,
            ease: "back.out(1.7)",
          },
          "-=0.35",
        );
    } else if (hasDentalReferralsPage) {
      mainTimeline.to(
        ".dental-referrals-form-panel",
        {
                    x: 0,
                    opacity: 1,
          duration: 1.2,
          ease: "power4.out",
        },
        "-=0.6",
      );
    } else if (hasStandardHero) {
      mainTimeline
        // Stagger Hero Buttons
        .to(
          ".hero-buttons .btn",
          {
            y: 0,
            opacity: 1,
            stagger: 0.15,
                    duration: 0.6,
            ease: "back.out(1.7)",
          },
          "-=0.5",
        )

        // Stagger Stats wrapper and items
        .to(
          ".stat",
          {
            y: 0,
            opacity: 1,
            stagger: 0.1,
            duration: 0.6,
          },
          "-=0.4",
        )

        // Curtain slide-in from top to bottom
        .to(
          ".hero-section .hero-image-wrapper",
          heroCurtainOpen,
          "-=0.8",
        );
    }

    if (hasCallUsTab) {
      mainTimeline.to(
        ".call-us-tab",
        {
          x: 0,
          opacity: 1,
          duration: 0.7,
          ease: "back.out(1.7)",
        },
        "-=0.6",
      );
        }
    } else {
        // Mobile: simple entrance animation for hero elements
    const hasMobileHeader = document.querySelector(".mobile-header") !== null;
        if (hasMobileHeader) {
      gsap.set(".mobile-header", { y: -30, opacity: 0 });
            if (hasHero) {
        gsap.set(".hero-title, .hero-description", { y: 20, opacity: 0 });
      }
      if (hasStandardHero) {
        gsap.set(".hero-buttons .btn", { y: 15, opacity: 0 });
        gsap.set(".stat", { y: 15, opacity: 0 });
        gsap.set(".hero-section .hero-image-wrapper", heroCurtainClosed);
      }
      if (hasCallUsTab) {
        gsap.set(".call-us-tab", { x: 40, opacity: 0 });
      }
      if (hasContactPage) {
        const contactTabTarget =
          window.innerWidth < 768
            ? ".contact-mobile-controls"
            : ".contact-tablet-tabs";
        gsap.set(contactTabTarget + ", .contact-main-panel", {
          y: 20,
          opacity: 0,
        });
      }
      if (hasDentalReferralsPage) {
        gsap.set(".dental-referrals-form-panel", { x: 0, y: 20, opacity: 0 });
      }
      if (hasTeamsPage) {
        gsap.set(".teams-page-main .hero-buttons .btn", { y: 15, opacity: 0 });
        gsap.set(".teams-page-main .hero-image-wrapper", heroCurtainClosed);
      }
      if (hasFeesPage) {
        gsap.set(".fees-page-main .hero-buttons .btn", { y: 15, opacity: 0 });
        gsap.set(".fees-page-main .hero-image-wrapper", heroCurtainClosed);
      }
      if (hasSmileGalleryPage) {
        gsap.set(".smile-gallery-page-main .hero-buttons .btn", {
          y: 15,
          opacity: 0,
        });
        gsap.set(
          ".smile-gallery-page-main .hero-image-wrapper",
          heroCurtainClosed,
        );
      }
      if (hasBlogsPage) {
        gsap.set(".blogs-page-main .hero-buttons .btn:not(.blogs-hero-cta--desktop)", {
          y: 15,
          opacity: 0,
        });
        gsap.set(".blogs-page-main .hero-image-wrapper", heroCurtainClosed);
      }

      const mobileTl = gsap.timeline({
        defaults: { ease: "power2.out", duration: 0.6 },
      });

      mobileTl.to(".mobile-header", { y: 0, opacity: 1, duration: 0.5 });
            
            if (hasHero) {
                mobileTl
          .to(".hero-title", { y: 0, opacity: 1 }, "-=0.3")
          .to(".hero-description", { y: 0, opacity: 1 }, "-=0.4");
      }

      if (hasContactPage) {
        const contactTabTarget =
          window.innerWidth < 768
            ? ".contact-mobile-controls"
            : ".contact-tablet-tabs";
        mobileTl
          .to(
            contactTabTarget,
            { y: 0, opacity: 1, duration: 0.5 },
            "-=0.3",
          )
          .to(
            ".contact-main-panel",
            { y: 0, opacity: 1, duration: 0.6 },
            "-=0.35",
          );
      } else if (hasDentalReferralsPage) {
        mobileTl.to(
          ".dental-referrals-form-panel",
          { x: 0, y: 0, opacity: 1, duration: 0.6 },
          "-=0.3",
        );
      } else if (hasTeamsPage) {
        mobileTl
          .to(
            ".teams-page-main .hero-buttons .btn",
            {
                        y: 0,
                        opacity: 1,
                        stagger: 0.1,
              duration: 0.4,
            },
            "-=0.3",
          )
          .to(
            ".teams-page-main .hero-image-wrapper",
            heroCurtainOpenMobile,
            "-=0.3",
          );
      } else if (hasFeesPage) {
        mobileTl
          .to(
            ".fees-page-main .hero-buttons .btn",
            {
                        y: 0,
                        opacity: 1,
              stagger: 0.1,
              duration: 0.4,
            },
            "-=0.3",
          )
          .to(
            ".fees-page-main .hero-image-wrapper",
            heroCurtainOpenMobile,
            "-=0.3",
          );
      } else if (hasSmileGalleryPage) {
        mobileTl
          .to(
            ".smile-gallery-page-main .hero-buttons .btn",
            {
                        y: 0,
                        opacity: 1,
              stagger: 0.1,
              duration: 0.4,
            },
            "-=0.3",
          )
          .to(
            ".smile-gallery-page-main .hero-image-wrapper",
            heroCurtainOpenMobile,
            "-=0.3",
          );
      } else if (hasBlogsPage) {
        mobileTl
          .to(
            ".blogs-page-main .hero-buttons .btn:not(.blogs-hero-cta--desktop)",
            {
              y: 0,
                        opacity: 1,
              stagger: 0.1,
              duration: 0.4,
            },
            "-=0.3",
          )
          .to(
            ".blogs-page-main .hero-image-wrapper",
            heroCurtainOpenMobile,
            "-=0.3",
          );
      } else if (hasStandardHero) {
        mobileTl
          .to(
            ".hero-buttons .btn",
            {
              y: 0,
              opacity: 1,
              stagger: 0.1,
              duration: 0.4,
            },
            "-=0.3",
          )
          .to(
            ".stat",
            {
              y: 0,
              opacity: 1,
              stagger: 0.08,
              duration: 0.4,
            },
            "-=0.3",
          )
          .to(
            ".hero-section .hero-image-wrapper",
            heroCurtainOpenMobile,
            "-=0.3",
          );
      }

      if (hasCallUsTab) {
        mobileTl.to(
          ".call-us-tab",
          {
            x: 0,
            opacity: 1,
            duration: 0.5,
            ease: "back.out(1.7)",
          },
          "-=0.3",
        );
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
  const counters = document.querySelectorAll(".stat-number[data-count]");
  counters.forEach((counter) => {
    const targetVal = parseFloat(counter.getAttribute("data-count"));
    const decimals = parseInt(counter.getAttribute("data-decimals") || "0", 10);
    const suffix = counter.getAttribute("data-suffix") || "";

        // Set initial state based on decimals
        counter.textContent = (0).toFixed(decimals) + suffix;

        const countObj = { val: 0 };
        gsap.to(countObj, {
            val: targetVal,
            duration: 2,
      ease: "power2.out",
            scrollTrigger: {
                trigger: counter,
        start: "top 85%",
        toggleActions: "play none none none",
            },
            onUpdate: () => {
                counter.textContent = countObj.val.toFixed(decimals) + suffix;
      },
        });
    });

    // ----------------------------------------------------
    // 5. Interactive Accordion/Tabs (Our Key Treatments)
    // ----------------------------------------------------
    initTreatmentsAccordion();

    // ----------------------------------------------------
    // 6. Scroll-Triggered Staggered Cards (Services)
    // ----------------------------------------------------
  if (document.querySelector(".service-card")) {
    gsap.from(".service-card", {
            scrollTrigger: {
        trigger: ".services-grid",
        start: "top 95%",
        toggleActions: "play none none none",
            },
            y: 50,
            opacity: 0,
            duration: 0.8,
            stagger: 0.15,
      ease: "power2.out",
        });
    }

    // ----------------------------------------------------
    // 7. Sticky About Waterside Section Image Scroll
    // ----------------------------------------------------
  const aboutSection = document.querySelector(".about-waterside-section");
    if (aboutSection && isDesktop) {
    const handle = document.querySelector(".about-scroll-indicator-handle");
    const container = document.querySelector(
      ".about-scroll-indicator-container",
    );
    const images = document.querySelectorAll(".about-scroll-img");
    const leftCol = document.querySelector(".about-left-col");
    const textContents = document.querySelectorAll(".about-text-content");

        if (handle && container && images.length >= 3) {
            // Set initial state
      gsap.set(images[0], { opacity: 1, visibility: "visible" });
      gsap.set(images[1], { opacity: 0, visibility: "hidden" });
      gsap.set(images[2], { opacity: 0, visibility: "hidden" });
            
            if (textContents.length >= 3) {
        textContents.forEach((textContent, index) => {
          const textParts = textContent.querySelectorAll(
            ".about-subtitle, .about-description",
          );
          textContent.classList.toggle("active", index === 0);
          gsap.set(textContent, { autoAlpha: index === 0 ? 1 : 0 });
          gsap.set(textParts, { y: 0, autoAlpha: index === 0 ? 1 : 0 });
        });
            }
            gsap.set(handle, { y: 0 });

            const updateHandleY = () => {
                const scrollBarHeight = container.clientHeight || 1040;
                const handleHeight = handle.clientHeight || 278.2;
                return scrollBarHeight - handleHeight;
            };

      // Helper function to reveal the next text block from the bottom like the rest of the page.
      let currentTextIndex = 0;
      const updateActiveText = (activeIndex) => {
        if (activeIndex === currentTextIndex || !textContents[activeIndex])
          return;

        const currentText = textContents[currentTextIndex];
        const nextText = textContents[activeIndex];
        const currentParts = currentText
          ? currentText.querySelectorAll(".about-subtitle, .about-description")
          : [];
        const nextParts = nextText.querySelectorAll(
          ".about-subtitle, .about-description",
        );

        gsap.killTweensOf([currentText, nextText, currentParts, nextParts]);

        if (currentText) {
          currentText.classList.remove("active");
          gsap.set(currentText, { autoAlpha: 0 });
          gsap.set(currentParts, { clearProps: "transform" });
        }

        nextText.classList.add("active");
        gsap.set(nextText, { autoAlpha: 1 });
        gsap.fromTo(
          nextParts,
          { y: 34, autoAlpha: 0 },
          {
            y: 0,
            autoAlpha: 1,
            duration: 0.65,
            ease: "power3.out",
            stagger: 0.1,
            overwrite: true,
          },
        );

        currentTextIndex = activeIndex;
      };

            const aboutTl = gsap.timeline({
                scrollTrigger: {
                    trigger: aboutSection,
          start: "top top",
          end: "bottom bottom",
          scrub: 0.35,
          anticipatePin: 1,
          invalidateOnRefresh: true,
          onUpdate: (self) => {
            if (textContents.length < 3) return;

            // Equal thirds: hold each slide before advancing
            let activeIndex = 0;
            if (self.progress >= 0.66) {
              activeIndex = 2;
            } else if (self.progress >= 0.33) {
              activeIndex = 1;
            }

            updateActiveText(activeIndex);
          },
        },
      });

      // 1. Move scroll indicator handle across the full scroll track
      aboutTl.to(
        handle,
        {
                y: () => updateHandleY(),
          ease: "none",
          duration: 1,
        },
        0,
      );

      // 2. Cross-fade images at equal thirds so each slide fully settles
            if (textContents.length >= 3) {
        aboutTl
          .to(
            images[0],
            {
                    opacity: 0,
              duration: 0.12,
              onStart: () => gsap.set(images[0], { visibility: "visible" }),
                    onComplete: () => {
                gsap.set(images[0], { visibility: "hidden" });
                    },
                    onReverseComplete: () => {
                gsap.set(images[0], { visibility: "visible" });
              },
            },
            0.33,
          )
          .to(
            images[1],
            {
                        opacity: 1,
              duration: 0.12,
              onStart: () => gsap.set(images[1], { visibility: "visible" }),
              onComplete: () => gsap.set(images[1], { visibility: "visible" }),
              onReverseComplete: () =>
                gsap.set(images[1], { visibility: "hidden" }),
            },
            0.33,
          );

        aboutTl
          .to(
            images[1],
            {
                    opacity: 0,
              duration: 0.12,
              onStart: () => gsap.set(images[1], { visibility: "visible" }),
                    onComplete: () => {
                gsap.set(images[1], { visibility: "hidden" });
                    },
                    onReverseComplete: () => {
                gsap.set(images[1], { visibility: "visible" });
              },
            },
            0.66,
          )
          .to(
            images[2],
            {
                        opacity: 1,
              duration: 0.12,
              onStart: () => gsap.set(images[2], { visibility: "visible" }),
              onComplete: () => gsap.set(images[2], { visibility: "visible" }),
              onReverseComplete: () =>
                gsap.set(images[2], { visibility: "hidden" }),
            },
            0.66,
          );
            } else {
        aboutTl
          .to(
            images[0],
            {
                    opacity: 0,
              duration: 0.12,
              onStart: () => gsap.set(images[0], { visibility: "visible" }),
              onComplete: () => gsap.set(images[0], { visibility: "hidden" }),
              onReverseComplete: () =>
                gsap.set(images[0], { visibility: "visible" }),
            },
            0.33,
          )
          .to(
            images[1],
            {
                        opacity: 1,
              duration: 0.12,
              onStart: () => gsap.set(images[1], { visibility: "visible" }),
              onComplete: () => gsap.set(images[1], { visibility: "visible" }),
              onReverseComplete: () =>
                gsap.set(images[1], { visibility: "hidden" }),
            },
            0.33,
          );

        aboutTl
          .to(
            images[1],
            {
                    opacity: 0,
              duration: 0.12,
              onStart: () => gsap.set(images[1], { visibility: "visible" }),
              onComplete: () => gsap.set(images[1], { visibility: "hidden" }),
              onReverseComplete: () =>
                gsap.set(images[1], { visibility: "visible" }),
            },
            0.66,
          )
          .to(
            images[2],
            {
                        opacity: 1,
              duration: 0.12,
              onStart: () => gsap.set(images[2], { visibility: "visible" }),
              onComplete: () => gsap.set(images[2], { visibility: "visible" }),
              onReverseComplete: () =>
                gsap.set(images[2], { visibility: "hidden" }),
            },
            0.66,
          );
      }
        }

        // Entrance animation for About section elements when it starts entering the viewport
        const aboutEntranceTl = gsap.timeline({
            scrollTrigger: {
        trigger: ".about-text-content-wrapper",
        start: "top 70%",
        toggleActions: "play none none none",
      },
    });

    aboutEntranceTl
      .to(".about-header-title", {
            y: 0,
            opacity: 1,
            duration: 0.8,
        ease: "power3.out",
        })
      .to(
        ".about-subtitle",
        {
                y: 0,
                opacity: 1,
                duration: 0.8,
          ease: "power3.out",
        },
        "-=0.6",
      )
      .to(
        ".about-description",
        {
                y: 0,
                opacity: 1,
                duration: 0.8,
          ease: "power3.out",
        },
        "-=0.6",
      )
      .to(
        ".about-right-col",
        {
                y: 0,
                opacity: 1,
                duration: 0.8,
          ease: "power3.out",
        },
        "-=0.6",
      )
      .to(
        ".about-image-frame",
        {
          clipPath: "inset(0% 0% 0% 0%)",
                duration: 0.8,
          ease: "power2.inOut",
        },
        "-=0.8",
      )
      .to(
        ".about-scroll-img",
        {
                scale: 1,
                duration: 0.8,
          ease: "power2.out",
        },
        "-=0.8",
      )
      .to(
        ".about-scroll-indicator-container",
        {
          clipPath: "inset(0% 0% 0% 0%)",
                duration: 0.8,
          ease: "power2.inOut",
        },
        "-=0.8",
      );
  }

  // Entrance animation for treatments section (desktop + tablet — phone uses CSS .mobile-visible)
  if (window.innerWidth >= 768 && document.querySelector(".treatments-header-badge")) {
        const treatmentsTl = gsap.timeline({
            scrollTrigger: {
        trigger: ".treatments-header-badge",
        start: "top 95%",
        toggleActions: "play none none none",
      },
    });

    treatmentsTl
      .to(".treatments-header-badge", {
            y: 0,
            opacity: 1,
            duration: 0.8,
        ease: "power3.out",
        })
      .to(
        ".treatments-left-col",
        {
                y: 0,
                opacity: 1,
                duration: 0.8,
          ease: "power3.out",
        },
        "-=0.6",
      )
      .to(
        ".treatment-image-frame",
        {
          clipPath: "inset(0% 0% 0% 0%)",
          duration: 1.1,
          ease: "power3.inOut",
        },
        "-=0.55",
      )
      .to(
        ".accordion-tab",
        {
                y: 0,
                opacity: 1,
                stagger: 0.1,
                duration: 0.8,
          ease: "power3.out",
        },
        "-=0.85",
      );
    }

    // ----------------------------------------------------
    // 8. Sticky Smile Gallery Section Scroll
    // ----------------------------------------------------
  const gallerySection = document.querySelector(".smile-gallery-section");
    if (gallerySection && isDesktop) {
    const handle = document.querySelector(".gallery-scroll-indicator-handle");
    const container = document.querySelector(
      ".gallery-scroll-indicator-container",
    );
    const slides = document.querySelectorAll(".gallery-slide");
    const details = document.querySelectorAll(".gallery-details-data");

        if (handle && container && slides.length > 0) {
            const updateHandleY = () => {
                const scrollBarHeight = container.clientHeight || 540;
                const handleHeight = handle.clientHeight || 143;
                return scrollBarHeight - handleHeight;
            };

            const galleryTl = gsap.timeline({
                scrollTrigger: {
                    trigger: gallerySection,
          start: "top top",
          end: "bottom bottom",
                    scrub: 0.5,
                    onUpdate: (self) => {
                        const progress = self.progress;
            const activeIndex = Math.min(
              Math.floor(progress * slides.length),
              slides.length - 1,
            );

                        // Toggle slide active classes
                        slides.forEach((slide, idx) => {
                            if (idx === activeIndex) {
                slide.classList.add("active");
                            } else {
                slide.classList.remove("active");
                            }
                        });

                        // Toggle details active classes
                        details.forEach((detail, idx) => {
                            if (idx === activeIndex) {
                detail.classList.add("active");
                            } else {
                detail.classList.remove("active");
                            }
                        });
          },
        },
            });

            // Move scroll indicator handle
      galleryTl.to(
        handle,
        {
                y: () => updateHandleY(),
          ease: "none",
          duration: 1,
        },
        0,
      );
        }

        // Entrance animation for Smile Gallery when it enters the viewport
        const galleryEntranceTl = gsap.timeline({
            scrollTrigger: {
        trigger: ".gallery-header-badge",
        start: "top 80%",
        toggleActions: "play none none none",
      },
    });

    galleryEntranceTl
      .to(".gallery-header-badge", {
            y: 0,
            opacity: 1,
            duration: 0.8,
        ease: "power3.out",
        })
      .to(
        ".gallery-header-desc",
        {
                y: 0,
                opacity: 1,
                duration: 0.8,
          ease: "power3.out",
        },
        "-=0.6",
      )
      .to(
        ".gallery-detail-card",
        {
                y: 0,
                opacity: 1,
                stagger: 0.1,
                duration: 0.8,
          ease: "power3.out",
        },
        "-=0.6",
      )
      .to(
        ".btn-gallery-action",
        {
                y: 0,
                opacity: 1,
                duration: 0.8,
          ease: "power3.out",
        },
        "-=0.6",
      )
      .to(
        ".gallery-image-pair-container",
        {
          clipPath: "inset(0% 0% 0% 0%)",
                duration: 0.8,
          ease: "power2.inOut",
        },
        "-=0.8",
      )
      .to(
        ".gallery-img",
        {
                scale: 1,
                duration: 0.8,
          ease: "power2.out",
        },
        "-=0.8",
      )
      .to(
        ".gallery-scroll-indicator-container",
        {
          clipPath: "inset(0% 0% 0% 0%)",
                duration: 0.8,
          ease: "power2.inOut",
        },
        "-=0.8",
      );

        // Initialize Book an Appointment animation
        initBookAppointmentAnimation();

        // Initialize Payment Options animation
        initPaymentOptionsAnimation();

        // Initialize Principal Dentist animation
        initPrincipalDentistAnimation();
    }

  // Testimonials arrows + slider (desktop + tablet; mobile also uses swipe in responsive.js)
  initTestimonialsSlider();
    
    // Initialize Principal Dentist Tabs for both desktop and mobile
    initDentistTabs();
  initServicePageTextAnimations();
  initContactPageAnimations();
  initPrivacyPolicyAnimations();
  initDentalReferralsAnimations();
  initDentalImplantsAnimations();
  initInvisalignAnimations();

  if (hasTeamsPage && isDesktop) {
    initTeamsPageAnimations();
  }

  if (hasFeesPage && isDesktop) {
    initFeesPageAnimations();
  }

  if (hasSmileGalleryPage && isDesktop) {
    initSmileGalleryPageAnimations();
  }

  if (hasBlogsPage && isDesktop) {
    initBlogsPageAnimations();
  }

  if (hasBlogDetailPage && isDesktop) {
    initBlogDetailPageAnimations();
  }

    if (isDesktop) {
        initSectionFadeOut();
    }

  // Recalculate all ScrollTriggers after sticky section heights settle
  if (typeof ScrollTrigger !== "undefined") {
    requestAnimationFrame(() => {
      ScrollTrigger.refresh();
    });
    window.addEventListener(
      "load",
      () => {
        ScrollTrigger.refresh();
      },
      { once: true },
    );
  }

    // ----------------------------------------------------
    // 10. Modal Smile Gallery Animations
    // ----------------------------------------------------
  const galleryModals = document.querySelectorAll(".cosmetic-full-modal");
  galleryModals.forEach((modal) => {
    modal.addEventListener("show.bs.modal", () => {
      const isMobileModal = window.matchMedia("(max-width: 991.98px)").matches;

      gsap.set(modal.querySelectorAll(".gallery-header-badge"), {
        y: 30,
        opacity: 0,
      });
      gsap.set(modal.querySelectorAll(".gallery-header-desc"), {
        y: 30,
        opacity: 0,
      });
      gsap.set(modal.querySelectorAll(".gallery-detail-card"), {
        y: 30,
        opacity: 0,
      });
      gsap.set(modal.querySelectorAll(".btn-gallery-action"), {
        y: 30,
        opacity: 0,
      });

      if (isMobileModal) {
        gsap.set(modal.querySelectorAll(".gallery-image-pair-container"), {
          clipPath: "inset(50% 0% 50% 0%)",
        });
        gsap.set(modal.querySelectorAll(".gallery-img"), { scale: 1.15 });
      } else {
        gsap.set(modal.querySelectorAll(".gallery-image-pair-container"), {
          clipPath: "inset(0% 0% 0% 0%)",
        });
        gsap.set(modal.querySelectorAll(".gallery-img"), { scale: 1 });
      }

      gsap.set(modal.querySelectorAll(".gallery-scroll-indicator-container"), {
        clipPath: "inset(0% 0% 0% 0%)",
      });
      gsap.set(modal.querySelectorAll(".gallery-scroll-indicator-handle"), {
        y: 0,
      });
    });

    modal.addEventListener("shown.bs.modal", () => {
      const isMobileModal = window.matchMedia("(max-width: 991.98px)").matches;
      const tl = gsap.timeline({
        defaults: { ease: "power3.out", duration: 0.8 },
      });
      tl.to(modal.querySelectorAll(".gallery-header-badge"), {
        y: 0,
        opacity: 1,
      })
        .to(
          modal.querySelectorAll(".gallery-header-desc"),
          { y: 0, opacity: 1 },
          "-=0.6",
        )
        .to(
          modal.querySelectorAll(".gallery-detail-card"),
          { y: 0, opacity: 1, stagger: 0.1 },
          "-=0.6",
        )
        .to(
          modal.querySelectorAll(".btn-gallery-action"),
          { y: 0, opacity: 1 },
          "-=0.6",
        );

      if (isMobileModal) {
        tl.to(
          modal.querySelectorAll(".gallery-image-pair-container"),
          {
            clipPath: "inset(0% 0% 0% 0%)",
            duration: 0.8,
            ease: "power2.inOut",
          },
          "-=0.8",
        ).to(
          modal.querySelectorAll(".gallery-img"),
          { scale: 1, duration: 0.8, ease: "power2.out" },
          "-=0.8",
        );
      }

      tl.set(modal.querySelectorAll(".gallery-scroll-indicator-container"), {
        clipPath: "inset(0% 0% 0% 0%)",
      });

      requestAnimationFrame(() => {
        syncModalGalleryScale(modal);
      });
    });
    });

    // ----------------------------------------------------
    // 11. Initialize Modal More Services Slider
    // ----------------------------------------------------
  const allModals = document.querySelectorAll(".cosmetic-full-modal");
  allModals.forEach((modal) => {
    initModalHorizontalReset(modal);
        initMoreServicesSliders(modal);
    initModalAccordions(modal);
    initModalReviewsSlider(modal);
    initModalTextAppearances(modal);
    initModalSmileGallery(modal);
    initModalTabContentAnimations(modal);
    initModalNavScroll(modal);
  });

  // After modal listeners are ready, open deep-linked treatment modals.
  initServiceTreatmentDeepLink();
}

function initModalHorizontalReset(modalElement) {
  const resetScroll = () => {
    const scrollTargets = [
      modalElement,
      modalElement.querySelector(".modal-dialog"),
      modalElement.querySelector(".cosmetic-modal-content"),
      modalElement.querySelector(".cosmetic-modal-body"),
    ].filter(Boolean);

    scrollTargets.forEach((target) => {
      target.scrollLeft = 0;
    });
  };

  modalElement.addEventListener("show.bs.modal", resetScroll);
  modalElement.addEventListener("shown.bs.modal", resetScroll);
}

function initModalNavScroll(modalElement) {
  const navLinks = modalElement.querySelectorAll(
    '.cosmetic-modal-nav .modal-nav-link[href^="#"]',
  );
  const scrollContainer = modalElement.querySelector(".cosmetic-modal-body");

  if (!navLinks.length || !scrollContainer) return;

  const getTargetTop = (target) => {
    const targetRect = target.getBoundingClientRect();
    const containerRect = scrollContainer.getBoundingClientRect();

    return scrollContainer.scrollTop + targetRect.top - containerRect.top;
  };

  const setActiveLink = (activeLink) => {
    const href = activeLink.getAttribute("href");
    navLinks.forEach((link) => {
      link.classList.toggle(
        "active",
        link.getAttribute("href") === href,
      );
    });
  };

  navLinks.forEach((link) => {
    link.addEventListener("click", (event) => {
      const targetSelector = link.getAttribute("href");
      const target = targetSelector
        ? modalElement.querySelector(targetSelector)
        : null;

      if (!target) return;

      event.preventDefault();
      setActiveLink(link);

      const mobileNav = link.closest(".cosmetic-modal-mobile-nav");
      if (mobileNav && mobileNav.tagName === "DETAILS") {
        mobileNav.open = false;
      }

      gsap.to(scrollContainer, {
        scrollTop: getTargetTop(target),
        duration: 0.85,
        ease: "power3.inOut",
        overwrite: true,
        onUpdate: () => {
          if (typeof ScrollTrigger !== "undefined") {
            ScrollTrigger.update();
          }
        },
        onComplete: () => {
          scrollContainer.dispatchEvent(new Event("scroll"));
        },
      });
    });
  });
}

function initModalTabContentAnimations(modalElement) {
  const tabButtons = modalElement.querySelectorAll(
    '.btn-process-tab[data-bs-toggle="pill"]',
  );
  if (!tabButtons.length) return;

  const getPaneItems = (pane) => {
    if (!pane) return [];

    return pane.querySelectorAll(
      [
        ".process-step-card",
        ".symptom-card",
        ".benefits-step-card",
        ".step-number-circle",
        ".step-card-title",
        ".step-card-desc",
        ".symptom-card-title",
        ".symptom-card-desc",
        ".benefits-card-title",
        ".benefits-card-desc",
      ].join(", "),
    );
  };

  const animatePane = (pane) => {
    const items = getPaneItems(pane);
    if (!items.length) return;

    gsap.killTweensOf(items);
    gsap.fromTo(
      items,
      { y: 28, opacity: 0 },
      {
        y: 0,
        opacity: 1,
        stagger: 0.045,
        duration: 0.5,
        ease: "power3.out",
        overwrite: true,
      },
    );
  };

  const animateTargetPane = (button) => {
    const targetSelector = button.getAttribute("data-bs-target");
    if (!targetSelector) return;

    window.setTimeout(() => {
      animatePane(modalElement.querySelector(targetSelector));
    }, 60);
  };

  tabButtons.forEach((button) => {
    button.addEventListener("shown.bs.tab", (event) => {
      animateTargetPane(event.target);
    });

    button.addEventListener("click", () => {
      animateTargetPane(button);
    });
  });
}

function syncModalGalleryScale(modalElement) {
  const gallery = modalElement.querySelector(".modal-smile-gallery");
  if (!gallery) return;

  const mediaQuery = window.matchMedia("(max-width: 991.98px)");
  const pairContainers = gallery.querySelectorAll(
    ".gallery-image-pair-container",
  );

  if (mediaQuery.matches) {
    pairContainers.forEach((container) => {
      container.style.transform = "";
    });
    return;
  }

  const wrapper = gallery.querySelector(".gallery-interactive-wrapper");
  if (!wrapper) return;

  const designWidth = 990;
  const scale = wrapper.clientWidth / designWidth;

  pairContainers.forEach((container) => {
    container.style.transform = scale === 1 ? "" : `scale(${scale})`;
  });
}

function initModalSmileGallery(modalElement) {
  const gallery = modalElement.querySelector(".cosmetic-modal-gallery-section");
  if (!gallery) return;

  const scrollContainer =
    modalElement.querySelector(".cosmetic-modal-body") || modalElement;
  const slides = Array.from(gallery.querySelectorAll(".gallery-slide"));
  const details = Array.from(gallery.querySelectorAll(".gallery-details-data"));
  const handle = gallery.querySelector(".gallery-scroll-indicator-handle");
  const handleContainer = gallery.querySelector(
    ".gallery-scroll-indicator-container",
  );
  const mediaQuery = window.matchMedia("(max-width: 991.98px)");

  if (!slides.length || !details.length) return;

  let ticking = false;
  let currentIndex = 0;
  let dots = [];

  const setActiveIndex = (activeIndex) => {
    currentIndex = gsap.utils.wrap(0, slides.length, activeIndex);

    slides.forEach((slide, index) => {
      slide.classList.toggle("active", index === currentIndex);
    });

    details.forEach((detail, index) => {
      detail.classList.toggle("active", index === currentIndex);
    });

    dots.forEach((dot, index) => {
      dot.classList.toggle("active", index === currentIndex);
    });
  };

  const updateHandle = (progress) => {
    if (!handle || !handleContainer) return;

    const maxY = Math.max(
      0,
      handleContainer.clientHeight - handle.clientHeight,
    );
    gsap.set(handle, { y: maxY * progress });
  };

  const animateActiveSlide = (direction = 1) => {
    if (!mediaQuery.matches) return;

    const activeSlide = slides[currentIndex];
    const activeDetails = details[currentIndex];
    if (!activeSlide) return;

    const targets = gsap.utils
      .toArray([
        activeSlide.querySelector(".before-card"),
        activeSlide.querySelector(".after-card"),
        activeSlide.querySelector(".gallery-connecting-arrow"),
        activeDetails ? activeDetails.querySelectorAll(".gallery-detail-card") : [],
      ])
      .filter(Boolean);

    gsap.fromTo(
      targets,
      { x: direction * 18, opacity: 0 },
      {
        x: 0,
        opacity: 1,
        duration: 0.45,
        stagger: 0.04,
        ease: "power2.out",
        overwrite: true,
      },
    );
  };

  const goToSlide = (nextIndex, direction = 1) => {
    setActiveIndex(nextIndex);
    updateHandle(slides.length > 1 ? currentIndex / (slides.length - 1) : 0);
    animateActiveSlide(direction);
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
    const stickyWrapper = gallery.querySelector(
      ".modal-gallery-sticky-wrapper",
    );
    const stickyHeight = stickyWrapper
      ? stickyWrapper.offsetHeight
      : scrollContainer.clientHeight || window.innerHeight;
    const galleryHeight = gallery.offsetHeight;
    const scrollTop = scrollContainer.scrollTop;
    const galleryTop = galleryRect.top - containerRect.top + scrollTop;
    const start = galleryTop;
    const end = galleryTop + galleryHeight - stickyHeight;
    const progress = gsap.utils.clamp(
      0,
      1,
      (scrollTop - start) / Math.max(1, end - start),
    );
    const activeIndex = Math.min(
      Math.floor(progress * slides.length),
      slides.length - 1,
    );

    setActiveIndex(activeIndex);
    updateHandle(progress);
  };

  const requestUpdate = () => {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(updateGallery);
  };

  const initMobileSwipe = () => {
    const wrapper = gallery.querySelector(".gallery-interactive-wrapper");
    const infoWrapper = gallery.querySelector(".gallery-info-wrapper");
    const actionButton = gallery.querySelector(".btn-gallery-action");
    if (!wrapper || !infoWrapper || slides.length <= 1) return;

    const removeDots = () => {
      const dotsContainer = gallery.querySelector(".gallery-slider-dots");
      if (dotsContainer) {
        dotsContainer.remove();
      }
      dots = [];
    };

    const ensureDots = () => {
      let dotsContainer = gallery.querySelector(".gallery-slider-dots");
      if (dotsContainer) {
        dots = Array.from(dotsContainer.querySelectorAll(".gallery-dot"));
        setActiveIndex(currentIndex);
        return;
      }

      dotsContainer = document.createElement("div");
      dotsContainer.className = "gallery-slider-dots modal-gallery-slider-dots";

      slides.forEach((_, index) => {
        const dot = document.createElement("button");
        dot.className = "gallery-dot";
        dot.type = "button";
        dot.setAttribute("aria-label", `Go to gallery slide ${index + 1}`);
        dot.addEventListener("click", () =>
          goToSlide(index, index > currentIndex ? 1 : -1),
        );
        dotsContainer.appendChild(dot);
      });

      if (actionButton) {
        actionButton.insertAdjacentElement("beforebegin", dotsContainer);
        } else {
        infoWrapper.appendChild(dotsContainer);
      }

      dots = Array.from(dotsContainer.querySelectorAll(".gallery-dot"));
      setActiveIndex(currentIndex);
    };

    const syncDotsForViewport = () => {
      if (mediaQuery.matches) {
        ensureDots();
      } else {
        removeDots();
      }
    };

    let touchStartX = 0;
    let touchStartY = 0;

    syncDotsForViewport();

    wrapper.addEventListener(
      "touchstart",
      (event) => {
        if (!mediaQuery.matches || !event.touches.length) return;

        touchStartX = event.touches[0].clientX;
        touchStartY = event.touches[0].clientY;
      },
      { passive: true },
    );

    wrapper.addEventListener(
      "touchend",
      (event) => {
        if (!mediaQuery.matches || !event.changedTouches.length) return;

        const deltaX = event.changedTouches[0].clientX - touchStartX;
        const deltaY = event.changedTouches[0].clientY - touchStartY;
        if (Math.abs(deltaX) < 45 || Math.abs(deltaX) < Math.abs(deltaY)) {
          return;
        }

        if (deltaX < 0) {
          goToSlide(currentIndex + 1, 1);
        } else {
          goToSlide(currentIndex - 1, -1);
        }
      },
      { passive: true },
    );

    mediaQuery.addEventListener("change", syncDotsForViewport);
  };

  initMobileSwipe();

  const requestScaleSync = () => {
    requestAnimationFrame(() => {
      syncModalGalleryScale(modalElement);
    });
  };

  scrollContainer.addEventListener(
    "scroll",
    () => {
      if (mediaQuery.matches) return;
      requestUpdate();
    },
    { passive: true },
  );

  window.addEventListener("resize", () => {
    requestScaleSync();
    if (mediaQuery.matches) {
      setActiveIndex(currentIndex);
      return;
    }
    requestUpdate();
  });

  modalElement.addEventListener("shown.bs.modal", () => {
    setActiveIndex(0);
    updateHandle(0);
    requestScaleSync();
    if (!mediaQuery.matches) {
      requestAnimationFrame(() => {
        requestUpdate();
      });
    }
  });

  mediaQuery.addEventListener("change", requestScaleSync);
  requestScaleSync();
}

function initServiceTreatmentDeepLink() {
  const container = document.querySelector(".cosmetic-treatments-container");
  if (!container) {
    return;
  }

  const rows = Array.from(
    container.querySelectorAll(".cosmetic-treatment-row[data-treatment-slug]"),
  );
  if (!rows.length) {
    return;
  }

  const activateRow = (row) => {
    if (!row) {
      return;
    }

    rows.forEach((item) => item.classList.remove("active"));
    row.classList.add("active");
  };

  const openTreatmentModal = (row) => {
    const targetSelector = row.getAttribute("data-bs-target");
    if (!targetSelector) {
      return;
    }

    const modalEl = document.querySelector(targetSelector);
    if (!modalEl) {
      return;
    }

    if (window.bootstrap && window.bootstrap.Modal) {
      window.bootstrap.Modal.getOrCreateInstance(modalEl).show();
      return;
    }

    // Fallback if Bootstrap API is not ready yet.
    row.click();
  };

  const activateFromHash = (options = {}) => {
    const raw = (window.location.hash || "").replace(/^#/, "");
    if (!raw) {
      return;
    }

    let slug = raw;
    try {
      slug = decodeURIComponent(raw);
    } catch (error) {
      slug = raw;
    }

    const target = rows.find(
      (row) => row.getAttribute("data-treatment-slug") === slug,
    );
    if (!target) {
      return;
    }

    activateRow(target);

    if (options.openModal !== false) {
      // Defer one frame so layout/hash scroll settles before the modal opens.
      window.requestAnimationFrame(() => {
        openTreatmentModal(target);
      });
    }
  };

  rows.forEach((row) => {
    row.addEventListener("click", () => {
      activateRow(row);
    });
  });

  activateFromHash({ openModal: true });
  window.addEventListener("hashchange", () => {
    activateFromHash({ openModal: true });
  });
}

function initServicePageTextAnimations() {
  const serviceMain = document.querySelector(".single-service-main");
  if (!serviceMain || typeof gsap === "undefined") {
    return;
  }

  const reduceMotion =
    window.matchMedia &&
    window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  const revealNow = (elements, vars = {}) => {
    const targets = gsap.utils.toArray(elements).filter(Boolean);
    if (!targets.length) {
      return;
    }

    gsap.to(targets, {
      y: 0,
      x: 0,
      scale: 1,
      opacity: 1,
      stagger: vars.stagger || 0.12,
      duration: vars.duration || 0.8,
      ease: vars.ease || "power3.out",
      overwrite: "auto",
    });
  };

  const revealOnScroll = (elements, trigger, vars = {}) => {
    const targets = gsap.utils.toArray(elements).filter(Boolean);
    if (!targets.length || !trigger) {
      return;
    }

    gsap.set(targets, {
      y: vars.yStart || 30,
      x: vars.xStart || 0,
      scale: vars.scaleStart || 1,
                        opacity: 0,
    });

    if (reduceMotion || typeof ScrollTrigger === "undefined") {
      gsap.set(targets, { y: 0, x: 0, scale: 1, opacity: 1 });
      return;
    }

    const playReveal = () => {
      revealNow(targets, vars);
    };

    // Already in (or near) view on load — don't wait for a scroll that never comes.
    const rect = trigger.getBoundingClientRect();
    const viewportH =
      window.innerHeight || document.documentElement.clientHeight || 0;
    const alreadyVisible = rect.top < viewportH * 0.9 && rect.bottom > 0;

    if (alreadyVisible) {
      playReveal();
                return;
            }

    ScrollTrigger.create({
      trigger: trigger,
      start: vars.start || "top 85%",
      once: true,
      onEnter: playReveal,
      onEnterBack: playReveal,
    });
  };

  const cosmeticHero = serviceMain.querySelector(".cosmetic-service-hero");
  if (cosmeticHero) {
    const heroTitle = cosmeticHero.querySelector(".cosmetic-hero-title");
    const heroDesc = cosmeticHero.querySelector(".cosmetic-hero-desc");
    const heroImage = cosmeticHero.querySelector(
      ".cosmetic-hero-image-wrapper",
    );

    gsap.set([heroTitle, heroDesc].filter(Boolean), { y: 30, opacity: 0 });
    if (heroImage) {
      gsap.set(heroImage, {
        clipPath: "inset(0% 0% 100% 0%)",
        opacity: 1,
        x: 0,
        y: 0,
        scale: 1,
      });
    }

    const heroTl = gsap.timeline({
      defaults: { ease: "power3.out", duration: 0.8 },
    });
    if (heroTitle) {
      heroTl.to(heroTitle, { y: 0, opacity: 1 });
    }
    if (heroDesc) {
      heroTl.to(heroDesc, { y: 0, opacity: 1 }, "-=0.6");
    }
    if (heroImage) {
      heroTl.to(
        heroImage,
        {
          clipPath: "inset(0% 0% 0% 0%)",
          duration: 1.25,
          ease: "power3.inOut",
        },
        "-=0.6",
      );
    }
  }

  const treatments = serviceMain.querySelector(
    ".cosmetic-treatments-container",
  );
  if (treatments) {
    revealOnScroll(
      treatments.querySelectorAll(".cosmetic-treatment-row"),
      treatments,
      {
        stagger: 0.1,
        start: "top 85%",
      },
    );
  }

  const membership = serviceMain.querySelector(".cosmetic-membership-section");
  if (membership) {
    revealOnScroll(
      [
        membership.querySelector(".cosmetic-membership-badge"),
        membership.querySelector(".cosmetic-membership-title"),
        membership.querySelector(".cosmetic-membership-desc"),
        membership.querySelector(".cosmetic-membership-price"),
        ...membership.querySelectorAll(".cosmetic-membership-benefit-item"),
        membership.querySelector(".cosmetic-membership-ctas"),
      ],
      membership,
      {
        stagger: 0.12,
        start: "top 85%",
      },
    );

    const membershipImage = membership.querySelector(
      ".cosmetic-membership-img-col img",
    );
    if (membershipImage) {
      revealOnScroll([membershipImage], membership, {
        yStart: 0,
        xStart: -40,
        scaleStart: 0.96,
        stagger: 0,
        duration: 1,
        start: "top 85%",
      });
    }
  }

  const serviceDetails = serviceMain.querySelector(".service-details-section");
  if (serviceDetails) {
    revealOnScroll(
      serviceDetails.querySelectorAll(".entry-content > *"),
      serviceDetails,
      {
        stagger: 0.1,
        start: "top 85%",
      },
    );
  }

  if (typeof ScrollTrigger !== "undefined") {
    requestAnimationFrame(() => {
      ScrollTrigger.refresh();
    });
  }
}

function initContactPageAnimations() {
  const contactMain = document.querySelector(".contact-page-main");
  if (!contactMain) return;

  const isDesktop = window.innerWidth >= 992;
  const $ = window.jQuery;

  if ($ && window.innerWidth >= 992) {
    const $links = $(".contact-page-main .contact-sidebar .contact-section-link");
    const $sections = $(
      "#contact-form, #quick-information, #availability-timings",
    );

    if ($links.length && $sections.length) {
      const setActiveSection = (sectionId) => {
        $links.removeClass("is-active");
        $links
          .filter('[data-contact-section="' + sectionId + '"]')
          .addClass("is-active");
      };

      $links.on("click", function (event) {
        const targetId = $(this).attr("data-contact-section");
        const $target = $("#" + targetId);

        if (!$target.length) {
          return;
        }

        event.preventDefault();
        $("html, body").animate(
          {
            scrollTop: $target.offset().top - 120,
          },
          500,
        );
        setActiveSection(targetId);
      });

      const onScroll = () => {
        const scrollPos = $(window).scrollTop() + 160;
        let currentId = "contact-form";

        $sections.each(function () {
          if ($(this).offset().top <= scrollPos) {
            currentId = this.id;
          }
        });

        setActiveSection(currentId);
      };

      $(window).on("scroll.contactPage", onScroll);
      onScroll();
    }
  }

  if (!isDesktop || typeof gsap === "undefined") {
    return;
  }

  const animateIn = (elements, vars = {}) => {
    const targets = gsap.utils.toArray(elements).filter(Boolean);
    if (!targets.length) return null;

    const toVars = {
      y: 0,
      opacity: 1,
      stagger: vars.stagger || 0.12,
      duration: vars.duration || 0.8,
      ease: vars.ease || "power3.out",
    };

    if (vars.trigger) {
      toVars.scrollTrigger = {
        trigger: vars.trigger,
        start: vars.start || "top 80%",
        toggleActions: "play none none none",
      };
    }

    return gsap.fromTo(
      targets,
      { y: vars.yStart || 30, opacity: 0 },
      toVars,
    );
  };

  const infoBlock = contactMain.querySelector(".contact-info-block--information");
  if (infoBlock) {
    animateIn(infoBlock.querySelector(".contact-panel-title"), {
      trigger: infoBlock,
      start: "top 82%",
      stagger: 0,
    });
    animateIn(infoBlock.querySelectorAll(".contact-info-item"), {
      trigger: infoBlock,
      start: "top 80%",
      stagger: 0.12,
    });
    animateIn(infoBlock.querySelector(".contact-social-row--information"), {
      trigger: infoBlock,
      start: "top 75%",
      stagger: 0,
    });
  }

  const mapCard = contactMain.querySelector(".contact-map-card--desktop");
  if (mapCard) {
    gsap.fromTo(
      mapCard,
      { y: 50, opacity: 0 },
      {
        y: 0,
        opacity: 1,
        duration: 1,
        ease: "power3.out",
        scrollTrigger: {
          trigger: mapCard,
          start: "top 85%",
          toggleActions: "play none none none",
        },
      },
    );
  }
}

function initPrivacyPolicyAnimations() {
  const privacyMain = document.querySelector(".privacy-policy-main");
  if (!privacyMain || window.innerWidth < 992 || typeof gsap === "undefined") {
    return;
  }

  const heroTitle = privacyMain.querySelector(".privacy-policy-hero-title");
  if (heroTitle) {
    gsap.fromTo(
      heroTitle,
      { y: 30, opacity: 0 },
      { y: 0, opacity: 1, duration: 0.8, ease: "power3.out", delay: 0.3 },
    );
  }

  const sections = privacyMain.querySelectorAll(
    ".privacy-policy-intro, .privacy-policy-section",
  );
  sections.forEach((section) => {
    gsap.fromTo(
      section,
      { y: 30, opacity: 0 },
      {
        y: 0,
        opacity: 1,
        duration: 0.8,
        ease: "power3.out",
        scrollTrigger: {
          trigger: section,
          start: "top 85%",
          toggleActions: "play none none none",
        },
      },
    );
  });
}

function animatePageSectionEntrance(section, selectors, options = {}) {
  if (!section || typeof gsap === "undefined") {
    return;
  }

  const elements = selectors
    .flatMap((selector) => Array.from(section.querySelectorAll(selector)))
    .filter(Boolean);

  if (!elements.length) {
    return;
  }

  gsap.set(elements, {
    y: options.yStart || 40,
    opacity: 0,
  });

  gsap.to(elements, {
    y: 0,
    opacity: 1,
    duration: options.duration || 0.8,
    stagger: options.stagger || 0.12,
    ease: options.ease || "power3.out",
    scrollTrigger: {
      trigger: section,
      start: options.start || "top 80%",
      toggleActions: "play none none none",
    },
  });
}

function initDentalImplantsAnimations() {
  const main = document.querySelector(".dental-implants-main");
  if (!main) return;

  const hero = main.querySelector(".implants-hero");
  if (!hero) return;

  const title = hero.querySelector(".implants-hero-title");
  const desc = hero.querySelector(".implants-hero-desc");
  const buttons = hero.querySelectorAll(".implants-hero-ctas .btn");
  const image = hero.querySelector(".implants-hero-image-wrapper");

  if (typeof gsap === "undefined") {
    [title, desc, image, ...buttons].filter(Boolean).forEach((el) => {
      el.style.opacity = "1";
      el.style.transform = "none";
      el.style.clipPath = "none";
    });
    return;
  }

  gsap.set([title, desc, ...buttons].filter(Boolean), { y: 30, opacity: 0 });
  if (image) {
    gsap.set(image, {
      clipPath: "inset(0% 0% 100% 0%)",
      opacity: 1,
      x: 0,
      y: 0,
      scale: 1,
    });
  }

  const heroTl = gsap.timeline({
    defaults: { ease: "power3.out", duration: 0.8 },
  });

  if (title) heroTl.to(title, { y: 0, opacity: 1 });
  if (desc) heroTl.to(desc, { y: 0, opacity: 1 }, "-=0.55");
  if (buttons.length) {
    heroTl.to(
      buttons,
      { y: 0, opacity: 1, stagger: 0.12, ease: "back.out(1.7)" },
      "-=0.45",
    );
  }
  if (image) {
    heroTl.to(
      image,
      {
        clipPath: "inset(0% 0% 0% 0%)",
        duration: 1.25,
        ease: "power3.inOut",
      },
      "-=0.85",
    );
  }

  if (window.innerWidth < 992 || typeof ScrollTrigger === "undefined") {
    return;
  }

  animatePageSectionEntrance(main.querySelector(".implants-about-section"), [
    ".implants-section-badge",
    ".implants-about-lead",
    ".implants-about-tabs",
    ".implants-about-panel.active .implants-step-card, .implants-about-panel.active .implants-type-card",
  ]);

  animatePageSectionEntrance(main.querySelector(".implants-built-section"), [
    ".implants-built-diagram",
    ".implants-built-title",
    ".implants-built-lead",
    ".implants-built-item",
    ".implants-built-disclosure",
  ]);

  animatePageSectionEntrance(main.querySelector(".implants-compare-section"), [
    ".implants-compare-title",
    ".implants-compare-card",
  ]);

  animatePageSectionEntrance(main.querySelector(".implants-fees-section"), [
    ".implants-fees-title",
    ".implants-fees-lead",
    ".implants-fee-row",
  ]);

  animatePageSectionEntrance(
    main.querySelector(".implants-membership-section"),
    [
      ".cosmetic-membership-badge",
      ".cosmetic-membership-title",
      ".cosmetic-membership-desc",
      ".cosmetic-membership-price",
      ".cosmetic-membership-benefit-item",
      ".cosmetic-membership-ctas",
      ".cosmetic-membership-img-col img",
    ],
  );
}

function initInvisalignAnimations() {
  const main = document.querySelector(".invisalign-main");
  if (!main) return;

  const hero = main.querySelector(".invisalign-hero");
  if (!hero) return;

  const title = hero.querySelector(".invisalign-hero-title");
  const desc = hero.querySelector(".invisalign-hero-desc");
  const buttons = hero.querySelectorAll(".invisalign-hero-ctas .btn");
  const image = hero.querySelector(".invisalign-hero-image-wrapper");
  const stats = hero.querySelectorAll(".invisalign-hero-stat");

  if (typeof gsap === "undefined") {
    [title, desc, image, ...buttons, ...stats].filter(Boolean).forEach((el) => {
      el.style.opacity = "1";
      el.style.transform = "none";
      el.style.clipPath = "none";
    });
    return;
  }

  gsap.set([title, desc, ...buttons, ...stats].filter(Boolean), {
    y: 30,
    opacity: 0,
  });
  if (image) {
    gsap.set(image, {
      clipPath: "inset(0% 0% 100% 0%)",
      opacity: 1,
      x: 0,
      y: 0,
      scale: 1,
    });
  }

  const heroTl = gsap.timeline({
    defaults: { ease: "power3.out", duration: 0.8 },
  });

  if (title) heroTl.to(title, { y: 0, opacity: 1 });
  if (desc) heroTl.to(desc, { y: 0, opacity: 1 }, "-=0.55");
  if (stats.length) {
    heroTl.to(stats, { y: 0, opacity: 1, stagger: 0.1 }, "-=0.5");
  }
  if (buttons.length) {
    heroTl.to(
      buttons,
      { y: 0, opacity: 1, stagger: 0.12, ease: "back.out(1.7)" },
      "-=0.45",
    );
  }
  if (image) {
    heroTl.to(
      image,
      {
        clipPath: "inset(0% 0% 0% 0%)",
        duration: 1.25,
        ease: "power3.inOut",
      },
      "-=0.85",
    );
  }

  if (window.innerWidth < 992 || typeof ScrollTrigger === "undefined") {
    return;
  }

  animatePageSectionEntrance(main.querySelector(".invisalign-about-section"), [
    ".invisalign-section-badge",
    ".invisalign-about-lead",
    ".invisalign-about-tabs",
    ".invisalign-about-panel.active .invisalign-step-card, .invisalign-about-panel.active .invisalign-who-card",
  ]);

  animatePageSectionEntrance(
    main.querySelector(".invisalign-treatment-section"),
    [
      ".invisalign-treatment-title",
      ".invisalign-treatment-lead",
      ".invisalign-treatment-item",
      ".invisalign-process-step",
      ".invisalign-treatment-disclosure",
    ],
  );

  animatePageSectionEntrance(main.querySelector(".invisalign-compare-section"), [
    ".invisalign-compare-title",
    ".invisalign-compare-card",
  ]);

  animatePageSectionEntrance(main.querySelector(".invisalign-fees-section"), [
    ".invisalign-fees-title",
    ".invisalign-fees-lead",
    ".invisalign-fee-row",
  ]);

  animatePageSectionEntrance(
    main.querySelector(".invisalign-membership-section"),
    [
      ".cosmetic-membership-badge",
      ".cosmetic-membership-title",
      ".cosmetic-membership-desc",
      ".cosmetic-membership-price",
      ".cosmetic-membership-benefit-item",
      ".cosmetic-membership-ctas",
      ".cosmetic-membership-img-col img",
    ],
  );
}

function initDentalReferralsAnimations() {
  const referralsMain = document.querySelector(".dental-referrals-main");
  if (!referralsMain) {
    return;
  }

  const revealWithoutGsap = () => {
    referralsMain
      .querySelectorAll(
        ".dental-referrals-form-panel, .dental-referrals-section-title, .dental-referrals-field, .dental-referrals-checkbox, .dental-referrals-other-field, .dental-referrals-media-uploads, .dental-referrals-consent, .dental-referrals-submit-btn",
      )
      .forEach((element) => {
        element.style.opacity = "1";
        element.style.transform = "none";
      });
  };

  if (typeof gsap === "undefined" || typeof ScrollTrigger === "undefined") {
    revealWithoutGsap();
    return;
  }

  const isMobile = window.innerWidth < 768;
  if (isMobile) {
    return;
  }

  const isDesktop = window.innerWidth >= 992;
  const sections = referralsMain.querySelectorAll(
    ".dental-referrals-form-section",
  );
  const footer = referralsMain.querySelector(".dental-referrals-form-footer");

  const animateSection = (section, index) => {
    const title = section.querySelector(".dental-referrals-section-title");
    const fields = section.querySelectorAll(
      ".dental-referrals-field, .dental-referrals-checkbox, .dental-referrals-other-field, .dental-referrals-media-uploads",
    );
    const isFirstSection = index === 0;

    if (title) {
      gsap.fromTo(
        title,
        { y: 30, opacity: 0 },
        {
          y: 0,
          opacity: 1,
          duration: 0.7,
          ease: "power3.out",
          scrollTrigger: isFirstSection
            ? undefined
            : {
                trigger: section,
                start: "top 85%",
                toggleActions: "play none none none",
              },
          delay: isFirstSection ? 0.45 : 0,
        },
      );
    }

    if (fields.length) {
      gsap.fromTo(
        fields,
        { y: 25, opacity: 0 },
        {
          y: 0,
          opacity: 1,
          duration: 0.6,
          stagger: 0.08,
          ease: "power3.out",
          scrollTrigger: isFirstSection
            ? undefined
            : {
                trigger: section,
                start: "top 82%",
                toggleActions: "play none none none",
              },
          delay: isFirstSection ? 0.55 : 0,
        },
      );
    }
  };

  sections.forEach(animateSection);

  if (footer) {
    gsap.fromTo(
      footer.querySelectorAll(
        ".dental-referrals-consent, .dental-referrals-submit-btn",
      ),
      { y: 30, opacity: 0 },
      {
        y: 0,
        opacity: 1,
        duration: 0.7,
        stagger: 0.15,
        ease: "power3.out",
        scrollTrigger: {
          trigger: footer,
          start: "top 88%",
          toggleActions: "play none none none",
        },
      },
    );
  }

  initDentalReferralsTrackFill(referralsMain);

  ScrollTrigger.refresh();
}

function initDentalReferralsTrackFill(referralsMain) {
  const trackFill = referralsMain.querySelector(
    ".dental-referrals-panel-track-fill",
  );
  const formPanel = referralsMain.querySelector(".dental-referrals-form-panel");
  const track = referralsMain.querySelector(".dental-referrals-panel-track");
  const form = referralsMain.querySelector(".dental-referrals-form");

  if (!trackFill || !formPanel || !track) {
    return;
  }

  const viewportWidth = window.innerWidth;
  const isDesktop = viewportWidth >= 992;
  const isTablet = viewportWidth >= 768 && viewportWidth < 992;

  if (!isDesktop && !isTablet) {
    return;
  }

  const syncTrackHeight = () => {
    if (isTablet && form) {
      track.style.minHeight = `${form.offsetHeight}px`;
    }
    ScrollTrigger.refresh();
  };

  gsap.set(trackFill, { height: isDesktop ? 527 : 193.5 });

  syncTrackHeight();
  window.addEventListener("resize", syncTrackHeight);
  window.addEventListener("load", syncTrackHeight);
  setTimeout(syncTrackHeight, 800);

  gsap.to(trackFill, {
    height: "100%",
    ease: "none",
    scrollTrigger: {
      trigger: formPanel,
      start: isDesktop ? "top top+=80" : "top top+=100",
      end: "bottom bottom",
      scrub: 0.3,
      invalidateOnRefresh: true,
    },
  });
}

function initModalTextAppearances(modalElement) {
  if (!modalElement) return;

  const getTextTargets = () =>
    modalElement.querySelectorAll(
      [
        ".cosmetic-modal-title-badge",
        ".cosmetic-modal-desc-text",
        ".btn-process-tab",
        ".process-step-card",
        ".symptom-card",
        ".benefits-step-card",
        ".gallery-header-badge",
        ".gallery-header-desc",
        ".gallery-detail-card",
        ".btn-gallery-action",
        ".reviews-rating-badge",
        ".reviews-nav-buttons",
        ".modal-review-slide.active .review-slide-title",
        ".modal-review-slide.active .review-slide-text",
        ".modal-review-slide.active .review-slide-stars",
        ".modal-review-slide.active .review-slide-author",
        ".fees-box-header",
        ".fee-row",
        ".cosmetic-accordion-section-header",
        ".cosmetic-accordion-trigger",
        ".more-services-title",
        ".more-services-nav",
        ".more-service-card-wrapper",
      ].join(", "),
    );

  modalElement.addEventListener("show.bs.modal", () => {
    gsap.set(getTextTargets(), { y: 30, opacity: 0 });
  });

  modalElement.addEventListener("shown.bs.modal", () => {
    const targets = gsap.utils.toArray(getTextTargets());
    if (!targets.length) return;

    gsap.to(targets, {
      y: 0,
      opacity: 1,
      stagger: 0.06,
      duration: 0.8,
      ease: "power3.out",
    });
  });
}

function initModalReviewsSlider(modalElement) {
  const section = modalElement.querySelector(".cosmetic-modal-reviews-section");
  if (!section) return;

  const slides = section.querySelectorAll(".modal-review-slide");
  const prevBtn = section.querySelector(".reviews-nav-btn.prev-btn");
  const nextBtn = section.querySelector(".reviews-nav-btn.next-btn");
  const progressBar = section.querySelector(".reviews-progress-bar");

  if (slides.length <= 1) return;

  let currentIndex = 0;
  let isTransitioning = false;
  let activeTween = null;
  const mobileQuery = window.matchMedia("(max-width: 991.98px)");

  const slideParts = (slide) =>
    slide.querySelectorAll(
      ".review-slide-title, .review-slide-text, .review-slide-stars, .review-slide-author",
    );

  slides.forEach((slide, index) => {
    const isActive = index === currentIndex;
    slide.classList.toggle("active", isActive);
    gsap.set(slide, {
      opacity: isActive ? 1 : 0,
      visibility: isActive ? "visible" : "hidden",
    });
    if (!isActive) {
      gsap.set(slideParts(slide), { opacity: 0, y: 0 });
    }
  });

  const updateProgress = () => {
    if (!progressBar) return;

    const widthPct = ((currentIndex + 1) / slides.length) * 100;
    gsap.to(progressBar, {
      width: `${widthPct}%`,
      duration: 0.45,
      ease: "power2.out",
    });
  };

  const getWrappedIndex = (index) => (index + slides.length) % slides.length;

  const goToSlide = (newIndex) => {
    newIndex = getWrappedIndex(newIndex);
    if (isTransitioning || newIndex === currentIndex) return;
    isTransitioning = true;

    const currentSlide = slides[currentIndex];
    const nextSlide = slides[newIndex];
    const currentParts = slideParts(currentSlide);
    const nextParts = slideParts(nextSlide);

    if (activeTween) {
      activeTween.kill();
      activeTween = null;
    }

    // Sequential swap (same pattern as homepage testimonials):
    // never leave two .active slides visible at once.
    activeTween = gsap.timeline({
      onComplete: () => {
        gsap.set([currentParts, nextParts], {
          clearProps: "opacity,transform,y",
        });
        gsap.set(currentSlide, {
          opacity: 0,
          visibility: "hidden",
          clearProps: "transform",
        });
        gsap.set(nextSlide, {
          opacity: 1,
          visibility: "visible",
          clearProps: "transform",
        });
        currentIndex = newIndex;
        updateProgress();
        isTransitioning = false;
        activeTween = null;
      },
    });

    activeTween
      .to(currentParts, {
        y: -12,
        opacity: 0,
        stagger: 0.02,
        duration: 0.28,
        ease: "power2.in",
      })
      .call(() => {
        currentSlide.classList.remove("active");
        gsap.set(currentSlide, { opacity: 0, visibility: "hidden" });
        gsap.set(currentParts, { clearProps: "opacity,transform,y" });

        nextSlide.classList.add("active");
        gsap.set(nextSlide, { opacity: 1, visibility: "visible" });
        gsap.set(nextParts, { opacity: 0, y: 14 });
      })
      .to(nextParts, {
        y: 0,
        opacity: 1,
        stagger: 0.03,
        duration: 0.35,
        ease: "power2.out",
      });
  };

  if (prevBtn) {
    prevBtn.addEventListener("click", () => {
      goToSlide(currentIndex - 1);
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener("click", () => {
      goToSlide(currentIndex + 1);
    });
  }

  let touchStartX = 0;
  let touchStartY = 0;

  section.addEventListener(
    "touchstart",
    (event) => {
      if (!mobileQuery.matches || !event.touches.length) return;

      touchStartX = event.touches[0].clientX;
      touchStartY = event.touches[0].clientY;
    },
    { passive: true },
  );

  section.addEventListener(
    "touchend",
    (event) => {
      if (!mobileQuery.matches || !event.changedTouches.length) return;

      const deltaX = event.changedTouches[0].clientX - touchStartX;
      const deltaY = event.changedTouches[0].clientY - touchStartY;

      if (Math.abs(deltaX) < 45 || Math.abs(deltaX) < Math.abs(deltaY)) return;

      if (deltaX < 0) {
        goToSlide(currentIndex + 1);
      } else {
        goToSlide(currentIndex - 1);
      }
    },
    { passive: true },
  );

  updateProgress();
}

function initModalAccordions(modalElement) {
  const accordions = modalElement.querySelectorAll(".cosmetic-accordion-list");
  if (!accordions.length) return;

  accordions.forEach((accordion) => {
    const items = accordion.querySelectorAll(".cosmetic-accordion-item");

    items.forEach((item) => {
      const trigger = item.querySelector(".cosmetic-accordion-trigger");
      const panel = item.querySelector(".cosmetic-accordion-panel");
      if (!trigger || !panel) return;

      const isActive = panel.classList.contains("active");
      trigger.classList.toggle("collapsed", !isActive);
      trigger.setAttribute("aria-expanded", isActive ? "true" : "false");
      gsap.set(panel, {
        height: isActive ? "auto" : 0,
        opacity: isActive ? 1 : 0,
        overflow: "hidden",
      });

      trigger.addEventListener("click", () => {
        const currentlyOpen = panel.classList.contains("active");

        items.forEach((otherItem) => {
          const otherTrigger = otherItem.querySelector(
            ".cosmetic-accordion-trigger",
          );
          const otherPanel = otherItem.querySelector(
            ".cosmetic-accordion-panel",
          );
          if (
            !otherTrigger ||
            !otherPanel ||
            otherPanel === panel ||
            !otherPanel.classList.contains("active")
          )
            return;

          otherPanel.classList.remove("active");
          otherTrigger.classList.add("collapsed");
          otherTrigger.setAttribute("aria-expanded", "false");
          gsap.to(otherPanel, {
                    height: 0,
                    opacity: 0,
            duration: 0.45,
            ease: "power3.inOut",
          });
        });

        if (currentlyOpen) {
          panel.classList.remove("active");
          trigger.classList.add("collapsed");
          trigger.setAttribute("aria-expanded", "false");
          gsap.to(panel, {
            height: 0,
            opacity: 0,
            duration: 0.45,
            ease: "power3.inOut",
          });
          return;
        }

        panel.classList.add("active");
        trigger.classList.remove("collapsed");
        trigger.setAttribute("aria-expanded", "true");
        gsap.fromTo(
          panel,
                { height: 0, opacity: 0 },
                {
            height: "auto",
                    opacity: 1,
            duration: 0.55,
            ease: "power3.inOut",
          },
        );
      });
    });
  });
}

function initTreatmentsAccordion() {
  const tabs = Array.prototype.slice.call(
    document.querySelectorAll(".accordion-tab"),
  );
  if (tabs.length === 0) return;

  const accordionWrapper = document.querySelector(
    ".treatment-accordion-wrapper",
  );
  const imgFrame = document.querySelector(".treatment-image-frame");
  const activeSlideNum = document.querySelector(".active-slide");
  let isTransitioning = false;
  let accordionTween = null;
  let imageTween = null;
  let imageSwapId = 0;

  // Preload treatment images to prevent jerk/flicker on swap
  tabs.forEach((tab) => {
    const url = tab.getAttribute("data-image");
    if (!url) return;
    const img = new Image();
    img.src = url;
  });

  function getContent(tab) {
    return tab ? tab.querySelector(".accordion-tab-content") : null;
  }

  function measureOpenHeight(content) {
    if (!content) return 0;

    const tab = content.closest(".accordion-tab");
    const wasActive = tab && tab.classList.contains("active");
    if (tab && !wasActive) {
      tab.classList.add("active");
    }

    const clone = content.cloneNode(true);
    clone.style.setProperty("position", "absolute", "important");
    clone.style.setProperty("visibility", "hidden", "important");
    clone.style.setProperty("pointer-events", "none", "important");
    clone.style.setProperty("height", "auto", "important");
    clone.style.setProperty("opacity", "1", "important");
    clone.style.setProperty("overflow", "visible", "important");
    clone.style.setProperty("left", "-9999px", "important");
    clone.style.setProperty("top", "0", "important");
    clone.style.setProperty(
      "width",
      Math.max(content.offsetWidth, content.parentNode.clientWidth) + "px",
      "important",
    );

    content.parentNode.appendChild(clone);
    const height = clone.scrollHeight;
    clone.remove();

    if (tab && !wasActive) {
      tab.classList.remove("active");
    }

    return height;
  }

  function syncMobileTreatmentsTrackHeight() {
    const section = document.querySelector(".key-treatments-section");
    const sticky = section
      ? section.querySelector(".treatments-sticky-wrapper")
      : null;

    if (!section || !sticky) return;

    if (window.innerWidth >= 992) {
      section.style.removeProperty("--treatments-track-height");
      return;
    }

    // Closed-tab height is the tuning unit for leftover sticky space / section gap
    const closedHeader = section.querySelector(
      ".accordion-tab:not(.active) .accordion-tab-header",
    );
    const cssTabHeight = parseFloat(
      getComputedStyle(section).getPropertyValue(
        "--treatments-closed-tab-height",
      ),
    );
    const closedTabHeight =
      (closedHeader && closedHeader.offsetHeight) ||
      (Number.isFinite(cssTabHeight) ? cssTabHeight : 52);
    const closedCount = section.querySelectorAll(
      ".accordion-tab:not(.active)",
    ).length;

    // Track = content height + one closed-tab of dwell per closed row
    const trackHeight =
      Math.ceil(sticky.offsetHeight) +
      Math.round(closedTabHeight) * Math.max(closedCount, 1);

    section.style.setProperty("--treatments-track-height", trackHeight + "px");
  }

  function lockAccordionMinHeight() {
    if (!accordionWrapper || window.innerWidth < 768) {
      if (accordionWrapper) {
        accordionWrapper.style.removeProperty("--treatments-accordion-min-height");
        accordionWrapper.style.removeProperty("height");
        accordionWrapper.style.removeProperty("max-height");
        accordionWrapper.style.removeProperty("overflow");
      }
      syncMobileTreatmentsTrackHeight();
      return;
    }

    // Headers always show; only one content panel is open
    let headerTotal = 0;
    let tallestContent = 0;
    tabs.forEach((tab) => {
      const header = tab.querySelector(".accordion-tab-header");
      headerTotal += header ? header.offsetHeight : 0;
      tallestContent = Math.max(
        tallestContent,
        measureOpenHeight(getContent(tab)),
      );
    });

    const lockedHeight = headerTotal + tallestContent + "px";
    accordionWrapper.style.setProperty(
      "--treatments-accordion-min-height",
      lockedHeight,
    );
    // Hard-lock height so mid-swap accordion grow/shrink cannot nudge the image
    accordionWrapper.style.setProperty("height", lockedHeight);
    accordionWrapper.style.setProperty("max-height", lockedHeight);
    accordionWrapper.style.setProperty("overflow", "hidden");
  }

  // Initialize content heights (GSAP-owned; CSS owns padding)
  tabs.forEach((tab) => {
    const content = getContent(tab);
    if (!content) return;

    if (tab.classList.contains("active")) {
      const openHeight = measureOpenHeight(content);
      gsap.set(content, {
        height: openHeight,
        opacity: 1,
      });
    } else {
      gsap.set(content, {
        height: 0,
                    opacity: 0,
      });
    }
  });

  lockAccordionMinHeight();
  window.addEventListener("resize", lockAccordionMinHeight);

  // Mobile treatment images load after first paint — refresh sticky track height
  const treatmentsSection = document.querySelector(".key-treatments-section");
  if (treatmentsSection) {
    treatmentsSection
      .querySelectorAll(".mobile-treatment-img")
      .forEach((img) => {
        if (img.complete) return;
        img.addEventListener("load", syncMobileTreatmentsTrackHeight, {
          once: true,
        });
      });
    requestAnimationFrame(syncMobileTreatmentsTrackHeight);
  }

  function swapImage(tab) {
    if (!imgFrame) return;

    const newImgUrl = tab.getAttribute("data-image");
    const newImgAlt =
      (tab.querySelector(".accordion-tab-title") || {}).textContent || "";
    const currentImg = imgFrame.querySelector(
      ":scope > .active-treatment-image",
    );

    if (!currentImg || !newImgUrl || currentImg.getAttribute("src") === newImgUrl) {
      return;
    }

    const swapId = ++imageSwapId;

    if (imageTween) {
      imageTween.kill();
      imageTween = null;
    }

    // Clean interrupted curtain overlays
    Array.prototype.slice
      .call(imgFrame.querySelectorAll(".treatment-image-curtain"))
      .forEach((el) => el.remove());
    Array.prototype.slice
      .call(imgFrame.querySelectorAll(":scope > .active-treatment-image"))
      .forEach((img, index) => {
        if (index > 0) img.remove();
      });

    const isDesktopSwap = window.innerWidth >= 768;

    if (isDesktopSwap) {
      const tempImg = document.createElement("img");
      tempImg.alt = newImgAlt;
      tempImg.className = "active-treatment-image";
      tempImg.src = newImgUrl;
      tempImg.decoding = "async";

      // Keep both images identical full-frame size; wipe with clip only
      gsap.set(currentImg, {
        zIndex: 1,
        scale: 1,
        x: 0,
        y: 0,
        transform: "none",
      });
      gsap.set(tempImg, {
        position: "absolute",
        left: 0,
        top: 0,
        width: "100%",
        height: "100%",
        objectFit: "cover",
        objectPosition: "center center",
                    opacity: 1,
        scale: 1,
        x: 0,
        y: 0,
        transform: "none",
        zIndex: 2,
        clipPath: "inset(0px 0px 100% 0px)",
        webkitClipPath: "inset(0px 0px 100% 0px)",
      });
      imgFrame.appendChild(tempImg);

      const runCurtainSwap = () => {
        if (swapId !== imageSwapId) return;

        imageTween = gsap.fromTo(
          tempImg,
          {
            clipPath: "inset(0px 0px 100% 0px)",
            webkitClipPath: "inset(0px 0px 100% 0px)",
          },
          {
            clipPath: "inset(0px 0px 0px 0px)",
            webkitClipPath: "inset(0px 0px 0px 0px)",
            duration: 0.7,
            ease: "power2.inOut",
            overwrite: true,
            onComplete: () => {
              if (swapId !== imageSwapId) return;

              // Promote overlay image — never reassign src (avoids decode flash/jerk)
              gsap.set(tempImg, {
                clearProps: "clipPath,webkitClipPath,zIndex,transform,scale,x,y",
              });
              currentImg.remove();
              imageTween = null;
            },
          },
        );
      };

      if (tempImg.complete && tempImg.naturalWidth) {
        runCurtainSwap();
      } else {
        tempImg.addEventListener("load", runCurtainSwap, { once: true });
        tempImg.addEventListener(
          "error",
          () => {
            if (swapId !== imageSwapId) return;
            tempImg.remove();
            imageTween = null;
          },
          { once: true },
        );
      }
      return;
    }

    const tempImg = document.createElement("img");
    tempImg.alt = newImgAlt;
    tempImg.className = "active-treatment-image";
    tempImg.src = newImgUrl;

    gsap.set(tempImg, {
                    opacity: 0,
      position: "absolute",
      left: 0,
      top: 0,
      width: "100%",
      height: "100%",
      objectFit: "cover",
    });
    imgFrame.appendChild(tempImg);

    const runSwap = () => {
      if (swapId !== imageSwapId) return;

      imageTween = gsap
        .timeline({
                    onComplete: () => {
            if (swapId !== imageSwapId) return;
            currentImg.remove();
            gsap.set(tempImg, { clearProps: "opacity" });
            imageTween = null;
          },
        })
        .to(
          currentImg,
          {
            opacity: 0,
            duration: 0.45,
            ease: "power2.inOut",
          },
          0,
        )
        .to(
          tempImg,
          {
            opacity: 1,
            duration: 0.45,
            ease: "power2.inOut",
          },
          0,
        );
    };

    if (tempImg.complete && tempImg.naturalWidth) {
      runSwap();
    } else {
      tempImg.addEventListener("load", runSwap, { once: true });
    }
  }

  function updateCounter(tab) {
    if (!activeSlideNum) return;
    const targetIndex = tab.getAttribute("data-index");
    if (!targetIndex || activeSlideNum.textContent === targetIndex) return;

    // Instant update — no y tween (was contributing to perceived left-column jump)
    activeSlideNum.textContent = targetIndex;
  }

  tabs.forEach((tab) => {
    const header = tab.querySelector(".accordion-tab-header");
    if (!header) return;

    const toggleTab = () => {
      const isPhone = window.innerWidth < 768;

      if (tab.classList.contains("active")) {
        // Phone accordion can collapse; tablet/desktop only switch between tabs
        if (isPhone && !isTransitioning) {
          isTransitioning = true;
          tab.classList.remove("active");
          const content = getContent(tab);
          accordionTween = gsap.to(content, {
            height: 0,
            opacity: 0,
            duration: 0.45,
            ease: "power2.inOut",
            onComplete: () => {
              isTransitioning = false;
              accordionTween = null;
              syncMobileTreatmentsTrackHeight();
            },
          });
        }
        return;
      }

      if (isTransitioning) return;
      isTransitioning = true;

      if (accordionTween) {
        accordionTween.kill();
        accordionTween = null;
      }

      const activeTab = document.querySelector(".accordion-tab.active");
      const closingContent = getContent(activeTab);
      const openingContent = getContent(tab);
      const openHeight = measureOpenHeight(openingContent);

      if (activeTab) {
        activeTab.classList.remove("active");
      }
      tab.classList.add("active");

      accordionTween = gsap.timeline({
        defaults: { ease: "power2.inOut", duration: 0.45 },
        onComplete: () => {
          isTransitioning = false;
          accordionTween = null;
          syncMobileTreatmentsTrackHeight();
        },
      });

      // Close + open on the same timeline so total height stays stable
      if (closingContent) {
        accordionTween.to(
          closingContent,
          {
            height: 0,
            opacity: 0,
          },
          0,
        );
      }

      accordionTween.fromTo(
        openingContent,
        {
          height: 0,
          opacity: 0,
        },
        {
          height: openHeight,
          opacity: 1,
        },
        0,
      );

      swapImage(tab);
      updateCounter(tab);
    };

    header.addEventListener("click", toggleTab);

    // Phone layout: active title sits under the image — tap it to collapse
    const inContentTitle = tab.querySelector(".accordion-tab-title--in-content");
    if (inContentTitle) {
      inContentTitle.style.cursor = "pointer";
      inContentTitle.addEventListener("click", () => {
        if (window.innerWidth >= 768) return;
        if (!tab.classList.contains("active")) return;
        toggleTab();
      });
    }
    });
}

function initTestimonialsSlider() {
  const section = document.querySelector(".testimonials-section");
    if (!section) return;

  const slides = section.querySelectorAll(".testimonial-slide");
  const prevBtn = section.querySelector(".prev-btn");
  const nextBtn = section.querySelector(".next-btn");
  const progressBar = section.querySelector(".testimonials-progress-bar");

    if (slides.length === 0) return;

    let currentIndex = 0;
    const totalSlides = slides.length;
    let isTransitioning = false;
  let activeTween = null;

  const slideParts = (slide) =>
    slide.querySelectorAll(
      ".testimonial-title, .testimonial-text, .testimonial-stars, .testimonial-author",
    );

    // Set initial progress bar width
    const updateProgress = () => {
        if (progressBar) {
            const widthPct = ((currentIndex + 1) / totalSlides) * 100;
      gsap.to(progressBar, {
        width: `${widthPct}%`,
        duration: 0.5,
        ease: "power2.out",
      });
        }
    };

    updateProgress();

    const goToSlide = (newIndex) => {
    // Keep in sync with swipe changes from responsive.js
    const activeEl = section.querySelector(".testimonial-slide.active");
    const activeIdx = Array.prototype.indexOf.call(slides, activeEl);
    if (activeIdx >= 0) {
      currentIndex = activeIdx;
    }

        if (isTransitioning || newIndex === currentIndex) return;
        isTransitioning = true;

        const currentSlide = slides[currentIndex];
        const nextSlide = slides[newIndex];
    const currentParts = slideParts(currentSlide);
    const nextParts = slideParts(nextSlide);

    if (activeTween) {
      activeTween.kill();
      activeTween = null;
    }

    // Tablet/phone: same GSAP text transition as desktop (CSS must not use !important on parts)
    activeTween = gsap.timeline({
      onComplete: () => {
        gsap.set([currentParts, nextParts], {
          clearProps: "opacity,transform,y,scale",
        });
                currentIndex = newIndex;
                updateProgress();
                isTransitioning = false;
        activeTween = null;
      },
    });

    activeTween
      .to(currentParts, {
        opacity: 0,
        y: -12,
        duration: 0.28,
        stagger: 0.02,
        ease: "power2.in",
      })
            .call(() => {
        currentSlide.classList.remove("active", "is-entering");
        gsap.set(currentParts, { clearProps: "opacity,transform,y,scale" });
        nextSlide.classList.add("active");
        gsap.set(nextParts, { opacity: 0, y: 14 });
      })
      .to(nextParts, {
        opacity: 1,
        y: 0,
        duration: 0.35,
        stagger: 0.03,
        ease: "power2.out",
      });
  };

  // Allow mobile swipe/autoplay (responsive.js) to reuse the same transition
  window.wsdTestimonialsGoToSlide = goToSlide;
  window.wsdTestimonialsGetIndex = () => currentIndex;

    if (prevBtn) {
    prevBtn.addEventListener("click", () => {
            const nextIdx = (currentIndex - 1 + totalSlides) % totalSlides;
            goToSlide(nextIdx);
        });
    }

    if (nextBtn) {
    nextBtn.addEventListener("click", () => {
            const nextIdx = (currentIndex + 1) % totalSlides;
            goToSlide(nextIdx);
        });
    }

  // Viewport entrance animation for the testimonials section elements
    if (window.innerWidth >= 992) {
        const testimonialsEntranceTl = gsap.timeline({
            scrollTrigger: {
                trigger: section,
        start: "top 80%",
        toggleActions: "play none none none",
      },
        });

        // Animate quote marks and active slide items on viewport entry
    gsap.set(
      [
        section.querySelector(".left-quote"),
        section.querySelector(".right-quote"),
      ],
      { scale: 0.5, opacity: 0 },
    );
    gsap.set(section.querySelector(".testimonials-header"), {
      y: 30,
      opacity: 0,
    });
    gsap.set(
      slides[0].querySelectorAll(
        ".testimonial-title, .testimonial-text, .testimonial-stars, .testimonial-author",
      ),
      { y: 30, opacity: 0 },
    );

    testimonialsEntranceTl
      .to(section.querySelector(".testimonials-header"), {
            y: 0,
            opacity: 1,
            duration: 0.8,
        ease: "power3.out",
      })
      .to(
        [
          section.querySelector(".left-quote"),
          section.querySelector(".right-quote"),
        ],
        {
                scale: 1,
                opacity: 0.2,
                duration: 1,
          ease: "back.out(1.7)",
        },
        "-=0.6",
      )
      .to(
        slides[0].querySelector(".testimonial-title"),
        {
                y: 0,
                opacity: 1,
                duration: 0.8,
          ease: "power3.out",
        },
        "-=0.8",
      )
      .to(
        slides[0].querySelector(".testimonial-text"),
        {
                y: 0,
                opacity: 1,
                duration: 0.8,
          ease: "power3.out",
        },
        "-=0.6",
      )
      .to(
        slides[0].querySelector(".testimonial-stars"),
        {
                y: 0,
                scale: 1,
                opacity: 1,
                duration: 0.6,
          ease: "back.out(1.7)",
        },
        "-=0.6",
      )
      .to(
        slides[0].querySelector(".testimonial-author"),
        {
                y: 0,
                opacity: 1,
                duration: 0.6,
          ease: "power3.out",
        },
        "-=0.5",
      );
  } else {
    // Mobile: match desktop text reveal when the section enters view
    const firstParts = slides[0].querySelectorAll(
      ".testimonial-title, .testimonial-text, .testimonial-stars, .testimonial-author",
    );
    gsap.set(firstParts, { opacity: 0, y: 30 });

    const playMobileEntrance = () => {
      if (section.dataset.wsdTestimonialsEntered === "1") return;
      section.dataset.wsdTestimonialsEntered = "1";

      const tl = gsap.timeline();
      tl.to(slides[0].querySelector(".testimonial-title"), {
        y: 0,
        opacity: 1,
        duration: 0.8,
        ease: "power3.out",
      })
        .to(
          slides[0].querySelector(".testimonial-text"),
          {
            y: 0,
            opacity: 1,
            duration: 0.8,
            ease: "power3.out",
          },
          "-=0.6",
        )
        .to(
          slides[0].querySelector(".testimonial-stars"),
          {
            y: 0,
            scale: 1,
            opacity: 1,
            duration: 0.6,
            ease: "back.out(1.7)",
          },
          "-=0.6",
        )
        .to(
          slides[0].querySelector(".testimonial-author"),
          {
            y: 0,
            opacity: 1,
            duration: 0.6,
            ease: "power3.out",
          },
          "-=0.5",
        );
    };

    if (section.classList.contains("mobile-visible")) {
      playMobileEntrance();
    } else {
      const entranceObserver = new MutationObserver(() => {
        if (section.classList.contains("mobile-visible")) {
          playMobileEntrance();
          entranceObserver.disconnect();
        }
      });
      entranceObserver.observe(section, {
        attributes: true,
        attributeFilter: ["class"],
      });
    }
    }
}

function initDentistTabs() {
  const section = document.querySelector(".principal-dentist-section");
    if (!section) return;

  const buttons = section.querySelectorAll(".dentist-tab-btn");
  const bgImages = section.querySelectorAll(".dentist-bg-img");
  const descTexts = section.querySelectorAll(".dentist-desc-text");

  buttons.forEach((btn) => {
    btn.addEventListener("click", () => {
      if (btn.classList.contains("active")) return;

      const targetIndex = btn.getAttribute("data-target");

            // 1. Update button active states
      buttons.forEach((b) => b.classList.remove("active"));
      btn.classList.add("active");

            // 2. Cross-fade backgrounds
      bgImages.forEach((img) => {
        const imgTag = img.querySelector(".dentist-img-tag");
        if (img.getAttribute("data-tab") === targetIndex) {
          img.classList.add("active");
                    if (imgTag) {
            gsap.fromTo(
              imgTag,
                            { scale: 1.15, opacity: 0 }, 
              { scale: 1, opacity: 1, duration: 1.2, ease: "power2.out" },
                        );
                    }
                } else {
          img.classList.remove("active");
                    if (imgTag) {
                        gsap.set(imgTag, { scale: 1.15, opacity: 0 });
                    }
                }
            });

            // 3. Cross-fade text descriptions
      descTexts.forEach((desc) => {
        const paragraph = desc.querySelector("p");
        if (desc.getAttribute("data-tab") === targetIndex) {
          desc.classList.add("active");
                    if (paragraph) {
            gsap.fromTo(
              paragraph,
                            { y: 80, opacity: 0 },
              { y: 0, opacity: 1, duration: 0.6, ease: "power3.out" },
                        );
                    }
                } else {
          desc.classList.remove("active");
                }
            });
        });
    });
}

function initBookAppointmentAnimation() {
  const section = document.querySelector(".book-appointment-section");
    if (!section) return;

    if (window.innerWidth >= 992) {
    const bg = section.querySelector(".book-appointment-bg");
    const card = section.querySelector(".book-appointment-card");
    const title = section.querySelector(".book-appointment-title");
    const text = section.querySelector(".book-appointment-text");
    const btn = section.querySelector(".book-appointment-btn");

        // 1. Initial State Setup
        gsap.set(bg, { scale: 1.2, opacity: 0 });
        gsap.set(card, { y: 50, opacity: 0 });
        gsap.set([title, text, btn], { y: 30, opacity: 0 });

        // 2. Timeline
        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: section,
        start: "top 80%",
        toggleActions: "play none none none",
      },
        });

        tl.to(bg, {
            scale: 1,
            opacity: 1,
            duration: 1.5,
      ease: "power2.out",
        })
      .to(
        card,
        {
            y: 0,
            opacity: 1,
            duration: 1,
          ease: "power3.out",
        },
        "-=1.2",
      )
      .to(
        [title, text],
        {
            y: 0,
            opacity: 1,
            stagger: 0.2,
            duration: 0.8,
          ease: "power3.out",
        },
        "-=0.8",
      )
      .to(
        btn,
        {
            y: 0,
            opacity: 1,
            duration: 0.8,
          ease: "back.out(1.7)",
        },
        "-=0.6",
      );
    }
}

function initPaymentOptionsAnimation() {
  const section = document.querySelector(".payment-options-section");
    if (!section) return;

    if (window.innerWidth >= 992) {
    const header = section.querySelector(".payment-header");
    const title = section.querySelector(".payment-title");
    const desc = section.querySelector(".payment-desc");
    const cards = section.querySelectorAll(".payment-card");

        // 1. Initial State
        gsap.set([header, title, desc], { y: 30, opacity: 0 });
        gsap.set(cards, { y: 50, opacity: 0 });

        // 2. Timeline
        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: section,
        start: "top 80%",
        toggleActions: "play none none none",
      },
        });

        tl.to(header, {
            y: 0,
            opacity: 1,
            duration: 0.8,
      ease: "power3.out",
        })
      .to(
        [title, desc],
        {
            y: 0,
            opacity: 1,
            stagger: 0.15,
            duration: 0.6,
          ease: "power3.out",
        },
        "-=0.4",
      )
      .to(
        cards,
        {
            y: 0,
            opacity: 1,
            stagger: 0.2,
            duration: 0.8,
          ease: "power3.out",
        },
        "-=0.4",
      );
    }
}

function initPrincipalDentistAnimation() {
  const section = document.querySelector(".principal-dentist-section");
    if (!section) return;

    if (window.innerWidth >= 992) {
    const bgWrapper = section.querySelector(".dentist-bg-wrapper");
    const title = section.querySelector(".dentist-section-title");
    const descText = section.querySelector(".dentist-desc-wrapper");
    const tabsNav = section.querySelector(".dentist-tabs-nav");

        // 1. Initial State
        gsap.set(bgWrapper, { scale: 1.15, opacity: 0 });
        gsap.set([title, descText, tabsNav], { y: 100, opacity: 0 });

        // 2. Timeline
        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: section,
        start: "top 80%",
        toggleActions: "play none none none",
      },
        });

        tl.to(bgWrapper, {
            scale: 1,
            opacity: 1,
            duration: 1.5,
      ease: "power2.out",
        })
      .to(
        title,
        {
            y: 0,
            opacity: 1,
            duration: 0.8,
          ease: "power3.out",
        },
        "-=1.0",
      )
      .to(
        descText,
        {
            y: 0,
            opacity: 1,
            duration: 0.8,
          ease: "power3.out",
        },
        "-=0.6",
      )
      .to(
        tabsNav,
        {
            y: 0,
            opacity: 1,
            duration: 0.8,
          ease: "back.out(1.7)",
        },
        "-=0.5",
      );
  }
}

function initTeamsPageAnimations() {
  const teamsMain = document.querySelector(".teams-page-main");
  if (!teamsMain || window.innerWidth < 992) {
    return;
  }

  const heroSection = teamsMain.querySelector(".teams-hero-page");
  const clinicalSection = teamsMain.querySelector(".teams-clinical-section");
  const supportSection = teamsMain.querySelector(".teams-support-section");

  const animateSectionEntrance = (section, selectors) => {
    if (!section) {
      return;
    }

    const elements = selectors
      .flatMap((selector) => Array.from(section.querySelectorAll(selector)))
      .filter(Boolean);

    if (!elements.length) {
      return;
    }

    gsap.set(elements, { y: 40, opacity: 0 });

    gsap.to(elements, {
      y: 0,
      opacity: 1,
      duration: 0.8,
      stagger: 0.15,
      ease: "power3.out",
      scrollTrigger: {
        trigger: section,
        start: "top 80%",
        toggleActions: "play none none none",
      },
    });
  };

  animateSectionEntrance(clinicalSection, [
    ".teams-clinical-heading-wrap",
    ".teams-clinical-slider",
  ]);

  animateSectionEntrance(supportSection, [
    ".teams-support-header",
    ".teams-support-slider",
  ]);

  [heroSection, clinicalSection].forEach((section) => {
    if (!section) {
      return;
    }

    applySectionScrollOpacity(section);
  });
}

function initFeesPageAnimations() {
  const feesMain = document.querySelector(".fees-page-main");
  if (!feesMain || window.innerWidth < 992) {
    return;
  }

  const heroSection = feesMain.querySelector(".fees-hero-page");
  const infoSection = feesMain.querySelector(".fees-info-section");

  const animateSectionEntrance = (section, selectors) => {
    if (!section) {
      return;
    }

    const elements = selectors
      .flatMap((selector) => Array.from(section.querySelectorAll(selector)))
      .filter(Boolean);

    if (!elements.length) {
      return;
    }

    gsap.set(elements, { y: 40, opacity: 0 });

    gsap.to(elements, {
      y: 0,
      opacity: 1,
      duration: 0.8,
      stagger: 0.15,
      ease: "power3.out",
      scrollTrigger: {
        trigger: section,
        start: "top 80%",
        toggleActions: "play none none none",
      },
    });
  };

  animateSectionEntrance(infoSection, [
    ".fees-info-header",
    ".fees-tabs",
    ".fees-panels",
  ]);

  // Fees page has dynamic-height tab panels. Scrub fade-out on the hero (or
  // info section) jumps to opacity 0 on tab change / ScrollTrigger.refresh
  // while those sections are still on screen. Keep both fully visible.
  if (heroSection) {
    ScrollTrigger.getAll().forEach(function (trigger) {
      if (trigger.trigger === heroSection) {
        trigger.kill();
      }
    });
    gsap.set(heroSection, { opacity: 1 });
    gsap.set(
      heroSection.querySelectorAll(
        ".hero-title, .hero-description, .hero-buttons .btn, .hero-image-wrapper",
      ),
      { opacity: 1, x: 0, y: 0, scale: 1 },
    );
  }

  if (infoSection) {
    gsap.set(infoSection, { opacity: 1 });
  }
}

function initSmileGalleryPageAnimations() {
  const galleryMain = document.querySelector(".smile-gallery-page-main");
  if (!galleryMain || window.innerWidth < 992) {
    return;
  }

  const casesSection = galleryMain.querySelector(".smile-gallery-cases-section");

  const animateSectionEntrance = (section, selectors) => {
    if (!section) {
      return;
    }

    const elements = selectors
      .flatMap((selector) => Array.from(section.querySelectorAll(selector)))
      .filter(Boolean);

    if (!elements.length) {
      return;
    }

    gsap.set(elements, { y: 40, opacity: 0 });

    gsap.to(elements, {
      y: 0,
      opacity: 1,
      duration: 0.8,
      stagger: 0.15,
      ease: "power3.out",
      scrollTrigger: {
        trigger: section,
        start: "top 80%",
        toggleActions: "play none none none",
      },
    });
  };

  animateSectionEntrance(casesSection, [
    ".smile-gallery-section-badge",
    ".smile-gallery-cases-body",
  ]);
}

function initBlogsPageAnimations() {
  const blogsMain = document.querySelector(".blogs-page-main");
  if (!blogsMain || window.innerWidth < 992) {
    return;
  }

  const heroSection = blogsMain.querySelector(".blogs-hero-page");
  const featuredSection = blogsMain.querySelector(".blogs-featured-section");
  const listingSection = blogsMain.querySelector(".blogs-listing-section");

  const animateSectionEntrance = (section, selectors) => {
    if (!section) {
      return;
    }

    const elements = selectors
      .flatMap((selector) => Array.from(section.querySelectorAll(selector)))
      .filter(Boolean);

    if (!elements.length) {
      return;
    }

    gsap.set(elements, { y: 40, opacity: 0 });

    gsap.to(elements, {
      y: 0,
      opacity: 1,
      duration: 0.8,
      stagger: 0.15,
      ease: "power3.out",
      scrollTrigger: {
        trigger: section,
        start: "top 80%",
        toggleActions: "play none none none",
      },
    });
  };

  animateSectionEntrance(featuredSection, [".blogs-featured-card"]);
  animateSectionEntrance(listingSection, [
    ".blogs-listing-header",
    ".blogs-grid",
  ]);

  if (heroSection) {
    applySectionScrollOpacity(heroSection, {
      start: "bottom 80%",
      end: "bottom top",
    });
  }
}

function initBlogDetailPageAnimations() {
  const detailMain = document.querySelector(".blog-detail-main");
  if (!detailMain || window.innerWidth < 992) {
    return;
  }

  const heroSection = detailMain.querySelector(".blog-detail-hero");
  const contentSection = detailMain.querySelector(".blog-detail-content-section");
  const relatedSection = detailMain.querySelector(".blog-detail-related");

  if (heroSection) {
    const heroParts = heroSection.querySelectorAll(
      ".blog-detail-hero-date, .blog-detail-hero-media, .blog-detail-hero-meta",
    );
    if (heroParts.length) {
      gsap.set(heroParts, { y: 30, opacity: 0 });
      gsap.to(heroParts, {
        y: 0,
        opacity: 1,
        duration: 0.85,
        stagger: 0.12,
        ease: "power3.out",
        delay: 0.15,
      });
    }
  }

  const animateSectionEntrance = (section, selectors) => {
    if (!section) {
      return;
    }

    const elements = selectors
      .flatMap((selector) => Array.from(section.querySelectorAll(selector)))
      .filter(Boolean);

    if (!elements.length) {
      return;
    }

    gsap.set(elements, { y: 40, opacity: 0 });

    gsap.to(elements, {
      y: 0,
      opacity: 1,
      duration: 0.8,
      stagger: 0.12,
      ease: "power3.out",
      scrollTrigger: {
        trigger: section,
        start: "top 80%",
        toggleActions: "play none none none",
      },
    });
  };

  animateSectionEntrance(contentSection, [
    ".blog-detail-header",
    ".blog-detail-body",
    ".blog-detail-comments-wrap",
  ]);
  animateSectionEntrance(relatedSection, [
    ".blog-detail-related-header",
    ".blog-detail-related-viewport",
  ]);
}

function applySectionScrollOpacity(el, options) {
        if (!el) return;

  const opts = options || {};
  const start = opts.start || "bottom 80%";
  const end = opts.end || "bottom top";

  // Clear any previous bottom-mask fade approach
  el.style.removeProperty("mask-image");
  el.style.removeProperty("-webkit-mask-image");
  el.style.removeProperty("--wsd-bottom-fade");

  // Never leave sticky panels stuck invisible after reloads / interrupted scrolls
  gsap.set(el, { opacity: 1, clearProps: "maskImage,webkitMaskImage" });

        gsap.to(el, {
            opacity: 0,
    ease: "none",
            scrollTrigger: {
                trigger: el,
      start: start,
      end: end,
      scrub: true,
      invalidateOnRefresh: true,
                onEnterBack: () => {
        gsap.set(el, { opacity: 1 });
      },
      onLeaveBack: () => {
        gsap.set(el, { opacity: 1 });
      },
      onRefresh: (self) => {
        if (self.progress <= 0) {
          gsap.set(el, { opacity: 1 });
        }
                },
            },
        });
}

function initSectionFadeOut() {
  // IMPORTANT: Do NOT fade viewport-height sticky wrappers directly.
  // Their bottom sits near the viewport bottom while sticky, so
  // start:"bottom 80%" fires immediately and the whole UI goes to opacity 0.
  // For pin/sticky sections, fade the outer track only near the end.
  const fadeOutTargets = [
    { selector: ".hero-section", start: "bottom 80%", end: "bottom top" },
    {
      selector: ".key-treatments-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    {
      selector: ".testimonials-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    {
      selector: ".principal-dentist-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    {
      selector: ".payment-options-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    {
      selector: ".book-appointment-section",
      start: "bottom 80%",
      end: "bottom top",
    },
    {
      selector: ".about-waterside-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    {
      selector: ".smile-gallery-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    // Dental implants
    {
      selector: ".dental-implants-main > .implants-hero",
      start: "bottom 80%",
      end: "bottom top",
    },
    {
      selector: ".dental-implants-main > .implants-about-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    {
      selector: ".dental-implants-main > .implants-built-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    {
      selector: ".dental-implants-main > .implants-compare-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    {
      selector: ".dental-implants-main > .implants-fees-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    {
      selector: ".dental-implants-main > .implants-membership-section",
      start: "bottom 80%",
      end: "bottom top",
    },
    // Invisalign
    {
      selector: ".invisalign-main > .invisalign-hero",
      start: "bottom 80%",
      end: "bottom top",
    },
    {
      selector: ".invisalign-main > .invisalign-about-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    {
      selector: ".invisalign-main > .invisalign-treatment-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    {
      selector: ".invisalign-main > .invisalign-compare-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    {
      selector: ".invisalign-main > .invisalign-fees-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    {
      selector: ".invisalign-main > .invisalign-membership-section",
      start: "bottom 80%",
      end: "bottom top",
    },
    // Teams (hero + clinical already handled in initTeamsPageAnimations)
    {
      selector: ".teams-page-main > .teams-support-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    // Smile Gallery page
    {
      selector: ".smile-gallery-page-main > .smile-gallery-cases-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    // Blogs (hero already handled in initBlogsPageAnimations)
    {
      selector: ".blogs-page-main > .blogs-featured-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    {
      selector: ".blogs-page-main > .blogs-listing-section",
      start: "bottom bottom",
      end: "bottom top",
    },
    // Services listing
    {
      selector: ".services-page-main > .services-list-section",
      start: "bottom bottom",
      end: "bottom top",
    },
  ];

  fadeOutTargets.forEach((target) => {
    const el = document.querySelector(target.selector);
    if (!el) return;

    applySectionScrollOpacity(el, {
      start: target.start,
      end: target.end,
    });
  });

  // Ensure Key Treatments sticky content itself never gets forced transparent
  const treatmentsSticky = document.querySelector(
    ".key-treatments-section .treatments-sticky-wrapper",
  );
  if (treatmentsSticky) {
    gsap.set(treatmentsSticky, { opacity: 1, clearProps: "opacity" });
  }
}
function initMoreServicesSliders(modalElement) {
  const container = modalElement.querySelector(
    ".more-services-slider-container",
  );
  const prevBtn = modalElement.querySelector(".more-services-nav-btn.prev-btn");
  const nextBtn = modalElement.querySelector(".more-services-nav-btn.next-btn");
  const progressBar = modalElement.querySelector(".more-services-progress-bar");
  const progressTrack = modalElement.querySelector(".more-services-progress-track");

  if (!container || !progressBar || !progressTrack) return;

  const cards = container.querySelectorAll(".more-service-card-wrapper");
  const compactMediaQuery = window.matchMedia("(max-width: 991.98px)");
  let progressDots = [];

  const applyEdgeSpacing = () => {
    if (!cards.length) return;

    cards[0].style.marginLeft = compactMediaQuery.matches ? "0" : "120px";
    cards[cards.length - 1].style.marginRight = compactMediaQuery.matches
      ? "0"
      : "120px";
  };

  const setupMobileDots = () => {
    progressDots.forEach((dot) => dot.remove());
    progressDots = [];

    if (!compactMediaQuery.matches) {
      progressBar.style.display = "";
      return;
    }

    progressBar.style.display = "none";

    cards.forEach((_, index) => {
      const dot = document.createElement("span");
      dot.className = "more-services-progress-dot";
      dot.setAttribute("aria-hidden", "true");
      if (index === 0) dot.classList.add("active");
      progressTrack.appendChild(dot);
      progressDots.push(dot);
    });
  };

  applyEdgeSpacing();
  setupMobileDots();

    const updateSliderUI = () => {
        const scrollLeft = container.scrollLeft;
        const maxScroll = container.scrollWidth - container.clientWidth;
        
        const progressPct = maxScroll > 0 ? (scrollLeft / maxScroll) * 100 : 0;

    if (compactMediaQuery.matches && progressDots.length) {
      const activeIndex = Math.min(
        progressDots.length - 1,
        Math.max(
          0,
          Math.round(
            scrollLeft /
              ((cards[0]?.getBoundingClientRect().width || container.clientWidth) +
                20),
          ),
        ),
      );

      progressDots.forEach((dot, index) => {
        dot.classList.toggle("active", index === activeIndex);
      });
        } else {
      const barWidth = 30 + progressPct * 0.7;
      progressBar.style.width = `${barWidth}%`;
    }

    if (prevBtn) {
      prevBtn.classList.toggle("active", scrollLeft > 5);
    }

    if (nextBtn) {
      nextBtn.classList.toggle("active", scrollLeft < maxScroll - 5);
    }
  };

  container.addEventListener("scroll", updateSliderUI);
  window.addEventListener("resize", () => {
    applyEdgeSpacing();
    setupMobileDots();
    updateSliderUI();
  });

    updateSliderUI();

    if (prevBtn) {
    prevBtn.addEventListener("click", () => {
      const scrollAmount = compactMediaQuery.matches
        ? (cards[0]?.getBoundingClientRect().width || container.clientWidth) + 20
        : 569;
      container.scrollBy({ left: -scrollAmount, behavior: "smooth" });
        });
    }

    if (nextBtn) {
    nextBtn.addEventListener("click", () => {
      const scrollAmount = compactMediaQuery.matches
        ? (cards[0]?.getBoundingClientRect().width || container.clientWidth) + 20
        : 569;
      container.scrollBy({ left: scrollAmount, behavior: "smooth" });
        });
    }
}
