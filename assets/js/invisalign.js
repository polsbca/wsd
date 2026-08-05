/**
 * Invisalign page — about tabs, more-services carousel, content animation
 */
(function ($) {
  "use strict";

  var compactMq = window.matchMedia("(max-width: 991.98px)");

  function isCompactViewport() {
    return compactMq.matches;
  }

  function getPanelItems(panel) {
    if (!panel) return [];

    return panel.querySelectorAll(
      [
        ".invisalign-step-number",
        ".invisalign-step-title",
        ".invisalign-step-desc",
        ".invisalign-who-card-title",
        ".invisalign-who-card-desc",
        ".invisalign-who-card",
      ].join(", ")
    );
  }

  function animatePanel(panel) {
    var items = getPanelItems(panel);
    if (!items.length || typeof gsap === "undefined") return;

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
      }
    );
  }

  function syncAboutDots($section) {
    var $dots = $section.find(".invisalign-about-dots");
    if (!$dots.length) return;

    var $activePanel = $section.find(".invisalign-about-panel.active");
    var cardCount = $activePanel.find(
      ".invisalign-step-card, .invisalign-who-card"
    ).length;
    var html = "";

    for (var i = 0; i < cardCount; i += 1) {
      html +=
        '<span class="invisalign-about-dot' +
        (i === 0 ? " is-active" : "") +
        '"></span>';
    }

    $dots.html(html);
  }

  function initInvisalignAboutTabs() {
    var $section = $(".invisalign-about-section");
    if (!$section.length) return;

    var $tabs = $section.find(".invisalign-tab-btn");
    var $panels = $section.find(".invisalign-about-panel");
    var sectionEl = $section[0];

    syncAboutDots($section);

    $tabs.on("click", function () {
      var tab = $(this).data("tab");
      if (!tab) return;
      if ($(this).hasClass("active")) return;

      $tabs.removeClass("active").attr("aria-selected", "false");
      $(this).addClass("active").attr("aria-selected", "true");

      $panels.removeClass("active").attr("hidden", true);
      var $panel = $panels
        .filter('[data-panel="' + tab + '"]')
        .addClass("active")
        .removeAttr("hidden");

      syncAboutDots($section);

      window.setTimeout(function () {
        animatePanel(
          $panel[0] || sectionEl.querySelector(".invisalign-about-panel.active")
        );
      }, 60);
    });
  }

  function initTreatmentDisclosure() {
    var $button = $(".invisalign-treatment-disclosure");
    var $details = $("#invisalign-treatment-details");
    if (!$button.length || !$details.length) return;

    $button.on("click", function () {
      if (!isCompactViewport()) return;

      var isOpen = $details.hasClass("is-open");
      $details.toggleClass("is-open", !isOpen);
      $button.toggleClass("is-open", !isOpen).attr("aria-expanded", !isOpen);

      if (!isOpen) {
        $details.removeAttr("hidden");
      } else {
        $details.attr("hidden", true);
      }
    });
  }

  function resetTreatmentForViewport() {
    var $button = $(".invisalign-treatment-disclosure");
    var $details = $("#invisalign-treatment-details");
    if (!$details.length) return;

    if (isCompactViewport()) {
      $details.removeClass("is-open").attr("hidden", true);
      $button.removeClass("is-open").attr("aria-expanded", "false");
    } else {
      $details.removeClass("is-open").removeAttr("hidden");
      $button.attr("aria-expanded", "false");
    }
  }

  function resetCompareForViewport() {
    var cards = document.querySelectorAll(
      ".invisalign-compare-card, .invisalign-compare-points, .invisalign-compare-points li, .invisalign-compare-title"
    );
    if (!cards.length || typeof gsap === "undefined") return;

    if (isCompactViewport()) {
      gsap.set(cards, { clearProps: "opacity,visibility,transform,y" });
    }
  }

  function initInvisalignGalleryDots() {
    if (!isCompactViewport()) return;

    var $gallery = $(".invisalign-smile-gallery");
    if (!$gallery.length) return;

    var $slides = $gallery.find(".gallery-slide");
    var $details = $gallery.find(".gallery-details-data");
    var $dotsContainer = $gallery.find(".invisalign-gallery-dots");

    if (!$slides.length || !$dotsContainer.length) return;

    if (!$dotsContainer.children().length) {
      $slides.each(function (index) {
        var $dot = $(
          '<button type="button" class="gallery-dot" aria-label="Go to slide ' +
            (index + 1) +
            '"></button>'
        );
        if (index === 0) {
          $dot.addClass("active");
        }
        $dotsContainer.append($dot);
      });
    }

    var $dots = $dotsContainer.find(".gallery-dot");

    function showSlide(index) {
      $slides.removeClass("active");
      $details.removeClass("active");
      $dots.removeClass("active");

      $slides.eq(index).addClass("active");
      $details.eq(index).addClass("active");
      $dots.eq(index).addClass("active");
    }

    $dots.off("click.invisalignMobile").on("click.invisalignMobile", function () {
      if (!isCompactViewport()) return;
      showSlide($(this).index());
    });
  }

  function initInvisalignMoreServices() {
    var root = document.querySelector(".invisalign-more-services-section");
    if (!root) return;

    var container = root.querySelector(".more-services-slider-container");
    var prevBtn = root.querySelector(".more-services-nav-btn.prev-btn");
    var nextBtn = root.querySelector(".more-services-nav-btn.next-btn");
    var progressBar = root.querySelector(".more-services-progress-bar");
    var cards = root.querySelectorAll(".more-service-card-wrapper");

    if (!container || !cards.length) return;

    function updateProgress() {
      if (!progressBar) return;
      var maxScroll = container.scrollWidth - container.clientWidth;
      var ratio = maxScroll > 0 ? container.scrollLeft / maxScroll : 0;
      progressBar.style.width = Math.max(12, ratio * 100) + "%";

      if (prevBtn) {
        prevBtn.classList.toggle("active", container.scrollLeft > 4);
      }
      if (nextBtn) {
        nextBtn.classList.toggle(
          "active",
          container.scrollLeft < maxScroll - 4
        );
      }
    }

    function scrollByCard(direction) {
      var card = cards[0];
      var gap = 24;
      var amount = card ? card.getBoundingClientRect().width + gap : 300;
      container.scrollBy({ left: direction * amount, behavior: "smooth" });
    }

    if (prevBtn) {
      prevBtn.addEventListener("click", function () {
        scrollByCard(-1);
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener("click", function () {
        scrollByCard(1);
      });
    }

    container.addEventListener("scroll", updateProgress, { passive: true });
    window.addEventListener("resize", updateProgress);
    updateProgress();
  }

  function initInvisalignHeroAnimation() {
    var main = document.querySelector(".invisalign-main");
    if (!main || typeof gsap === "undefined") return;

    var hero = main.querySelector(".invisalign-hero");
    if (!hero) return;

    var title = hero.querySelector(".invisalign-hero-title");
    var desc = hero.querySelector(".invisalign-hero-desc");
    var buttons = hero.querySelectorAll(".invisalign-hero-ctas .btn");
    var image = hero.querySelector(".invisalign-hero-image-wrapper");

    gsap.set([title, desc].concat([].slice.call(buttons)).filter(Boolean), {
      y: 30,
      opacity: 0,
    });

    if (image) {
      gsap.set(image, {
        clipPath: "inset(0% 0% 100% 0%)",
        opacity: 1,
      });
    }

    var heroTl = gsap.timeline({
      defaults: { ease: "power3.out", duration: 0.8 },
    });

    if (title) heroTl.to(title, { y: 0, opacity: 1 });
    if (desc) heroTl.to(desc, { y: 0, opacity: 1 }, "-=0.55");
    if (buttons.length) {
      heroTl.to(buttons, { y: 0, opacity: 1, stagger: 0.1 }, "-=0.5");
    }
    if (image) {
      heroTl.to(image, { clipPath: "inset(0% 0% 0% 0%)", duration: 1.1 }, "-=0.7");
    }
  }

  function initScrollAnimations() {
    if (typeof gsap === "undefined" || typeof ScrollTrigger === "undefined") return;
    if (window.innerWidth < 992) return;

    gsap.registerPlugin(ScrollTrigger);

    var sections = [
      {
        trigger: ".invisalign-about-section",
        items:
          ".invisalign-about-header, .invisalign-about-tabs, .invisalign-about-panel.active .invisalign-step-card, .invisalign-about-panel.active .invisalign-who-card",
      },
      {
        trigger: ".invisalign-treatment-section",
        items:
          ".invisalign-treatment-visual, .invisalign-treatment-title, .invisalign-treatment-lead, .invisalign-treatment-list",
      },
      {
        trigger: ".invisalign-compare-section",
        items: ".invisalign-compare-title, .invisalign-compare-card",
      },
      {
        trigger: ".invisalign-fees-section",
        items: ".invisalign-fees-header, .invisalign-fee-row",
      },
      {
        trigger: ".invisalign-membership-section",
        items: ".cosmetic-membership-card",
      },
      {
        trigger: ".invisalign-more-services-section",
        items: ".more-services-header, .more-service-card-wrapper",
      },
    ];

    sections.forEach(function (cfg) {
      var trigger = document.querySelector(cfg.trigger);
      if (!trigger) return;

      var items = trigger.querySelectorAll(cfg.items);
      if (!items.length) return;

      gsap.set(items, { y: 40, opacity: 0 });

      gsap.to(items, {
        y: 0,
        opacity: 1,
        duration: 0.8,
        stagger: 0.12,
        ease: "power3.out",
        scrollTrigger: {
          trigger: trigger,
          start: "top 85%",
          toggleActions: "play none none none",
        },
      });
    });
  }

  function initCompactHandlers() {
    resetTreatmentForViewport();
    resetCompareForViewport();
    initInvisalignGalleryDots();
  }

  $(function () {
    initInvisalignAboutTabs();
    initTreatmentDisclosure();
    initInvisalignMoreServices();
    initInvisalignHeroAnimation();
    initScrollAnimations();
    initCompactHandlers();

    if (typeof compactMq.addEventListener === "function") {
      compactMq.addEventListener("change", initCompactHandlers);
    } else if (typeof compactMq.addListener === "function") {
      compactMq.addListener(initCompactHandlers);
    }
  });
})(jQuery);
