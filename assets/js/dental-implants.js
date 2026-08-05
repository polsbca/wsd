/**
 * Dental Implants page — about tabs, responsive UI, and content animation
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
        ".implants-step-number",
        ".implants-step-title",
        ".implants-step-desc",
        ".implants-type-label",
        ".implants-type-title",
        ".implants-type-desc",
        ".implants-type-ideal",
      ].join(", ")
    );
  }

  function animatePanel(panel) {
    var items = getPanelItems(panel);
    if (!items.length || typeof gsap === "undefined") return;

    var cards = panel.querySelectorAll(
      ".implants-step-card, .implants-type-card"
    );
    gsap.set(cards, { clearProps: "transform" });
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
    var $dots = $section.find(".implants-about-dots");
    if (!$dots.length) return;

    var $activePanel = $section.find(".implants-about-panel.active");
    var cardCount = $activePanel.find(
      ".implants-step-card, .implants-type-card"
    ).length;
    var html = "";

    for (var i = 0; i < cardCount; i += 1) {
      html +=
        '<span class="implants-about-dot' +
        (i === 0 ? " is-active" : "") +
        '"></span>';
    }

    $dots.html(html);
  }

  function initImplantsAboutTabs() {
    var $section = $(".implants-about-section");
    if (!$section.length) return;

    var $tabs = $section.find(".implants-tab-btn");
    var $panels = $section.find(".implants-about-panel");
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
          $panel[0] ||
            sectionEl.querySelector(".implants-about-panel.active")
        );
      }, 60);
    });
  }

  function initBuiltDisclosure() {
    var $button = $(".implants-built-disclosure");
    var $details = $("#implants-built-details");
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

  function getCompareIconSrc(iconType) {
    var selector =
      iconType === "check"
        ? ".implants-compare-col--highlight .implants-compare-cell img"
        : ".implants-compare-col:not(.implants-compare-col--highlight) .implants-compare-cell img";
    var img = document.querySelector(selector);
    return img ? img.getAttribute("src") : "";
  }

  function renderCompareTabletCell($cell, optionKey, rowEl) {
    var text = rowEl.getAttribute("data-" + optionKey) || "";
    var iconType = rowEl.getAttribute("data-" + optionKey + "-icon") || "indeterminate";
    var iconSrc = getCompareIconSrc(iconType);

    $cell.empty();
    if (iconSrc) {
      $cell.append(
        $('<img alt="" aria-hidden="true">').attr("src", iconSrc)
      );
    }
    $cell.append($("<span></span>").text(text));
  }

  function syncCompareTablet() {
    var $tablet = $(".implants-compare-tablet");
    if (!$tablet.length) return;

    var selectA = $tablet.find(".implants-compare-select--a").val();
    var selectB = $tablet.find(".implants-compare-select--b").val();

    if (selectA && selectA === selectB) {
      var alternate = selectA === "implants" ? "bridge" : "implants";
      $tablet.find(".implants-compare-select--b").val(alternate);
      selectB = alternate;
    }

    $tablet.find(".implants-compare-tablet-row").each(function () {
      var rowEl = this;
      renderCompareTabletCell(
        $(rowEl).find(".implants-compare-tablet-cell--a"),
        selectA,
        rowEl
      );
      renderCompareTabletCell(
        $(rowEl).find(".implants-compare-tablet-cell--b"),
        selectB,
        rowEl
      );
    });
  }

  function initCompareTablet() {
    var $tablet = $(".implants-compare-tablet");
    if (!$tablet.length) return;

    $tablet.on("change", ".implants-compare-select", function () {
      syncCompareTablet();
    });

    $tablet.on("click", ".implants-compare-swap", function () {
      var $selectA = $tablet.find(".implants-compare-select--a");
      var $selectB = $tablet.find(".implants-compare-select--b");
      var valueA = $selectA.val();
      $selectA.val($selectB.val());
      $selectB.val(valueA);
      syncCompareTablet();
    });

    syncCompareTablet();
  }

  function initImplantsGalleryDots() {
    var $gallery = $(".dental-implants-main .implants-smile-gallery");
    if (!$gallery.length) return;

    var $wrapper = $gallery.find(".gallery-interactive-wrapper");
    var $slides = $wrapper.find(".gallery-slide");
    if ($slides.length <= 1) return;

    var $details = $gallery.find(".gallery-details-data");
    var $dotsContainer = $gallery.find(".implants-gallery-dots");

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

    $dots.off("click.implantsTablet").on("click.implantsTablet", function () {
      if (!isCompactViewport()) return;
      showSlide($(this).index());
    });
  }

  function resetBuiltForViewport() {
    var $button = $(".implants-built-disclosure");
    var $details = $("#implants-built-details");
    if (!$details.length) return;

    if (isCompactViewport()) {
      $details.removeClass("is-open").attr("hidden", true);
      $button.removeClass("is-open").attr("aria-expanded", "false");
    } else {
      $details.removeClass("is-open").removeAttr("hidden");
      $button.attr("aria-expanded", "false");
    }
  }

  function initTabletHandlers() {
    resetBuiltForViewport();
    syncCompareTablet();
    initImplantsGalleryDots();
  }

  $(function () {
    initImplantsAboutTabs();
    initBuiltDisclosure();
    initCompareTablet();
    initTabletHandlers();

    if (typeof compactMq.addEventListener === "function") {
      compactMq.addEventListener("change", initTabletHandlers);
    } else if (typeof compactMq.addListener === "function") {
      compactMq.addListener(initTabletHandlers);
    }
  });
})(jQuery);
