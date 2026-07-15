/**
 * Dental Implants page — desktop about tabs
 */
(function ($) {
  "use strict";

  function initImplantsAboutTabs() {
    var $section = $(".implants-about-section");
    if (!$section.length) return;

    var $tabs = $section.find(".implants-tab-btn");
    var $panels = $section.find(".implants-about-panel");

    $tabs.on("click", function () {
      var tab = $(this).data("tab");
      if (!tab) return;

      $tabs.removeClass("active").attr("aria-selected", "false");
      $(this).addClass("active").attr("aria-selected", "true");

      $panels.removeClass("active").attr("hidden", true);
      $panels
        .filter('[data-panel="' + tab + '"]')
        .addClass("active")
        .removeAttr("hidden");
    });
  }

  $(function () {
    initImplantsAboutTabs();
  });
})(jQuery);
