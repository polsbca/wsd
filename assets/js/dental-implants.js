/**
 * Dental Implants page — about tabs + content animation
 * (matches cosmetic modal "All About …" tab pane animation)
 */
(function ($) {
  "use strict";

  function getPanelItems(panel) {
    if (!panel) return [];

    return panel.querySelectorAll(
      [
        ".implants-step-card",
        ".implants-step-number",
        ".implants-step-title",
        ".implants-step-desc",
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

  function initImplantsAboutTabs() {
    var $section = $(".implants-about-section");
    if (!$section.length) return;

    var $tabs = $section.find(".implants-tab-btn");
    var $panels = $section.find(".implants-about-panel");
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
        animatePanel($panel[0] || sectionEl.querySelector(".implants-about-panel.active"));
      }, 60);
    });
  }

  $(function () {
    initImplantsAboutTabs();
  });
})(jQuery);
