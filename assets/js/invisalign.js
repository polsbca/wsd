/**
 * Invisalign page — about tabs, more-services carousel, content animation
 */
(function ($) {
  "use strict";

  function getPanelItems(panel) {
    if (!panel) return [];

    return panel.querySelectorAll(
      [".invisalign-step-number", ".invisalign-step-title", ".invisalign-step-desc"].join(
        ", "
      )
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

  function initInvisalignAboutTabs() {
    var $section = $(".invisalign-about-section");
    if (!$section.length) return;

    var $tabs = $section.find(".invisalign-tab-btn");
    var $panels = $section.find(".invisalign-about-panel");
    var sectionEl = $section[0];

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

      window.setTimeout(function () {
        animatePanel(
          $panel[0] || sectionEl.querySelector(".invisalign-about-panel.active")
        );
      }, 60);
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
    var buttons = hero.querySelectorAll(".invisalign-hero-ctas .invisalign-btn");
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

  $(function () {
    initInvisalignAboutTabs();
    initInvisalignMoreServices();
    initInvisalignHeroAnimation();
  });
})(jQuery);
