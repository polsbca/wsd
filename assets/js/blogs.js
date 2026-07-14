/**
 * Blogs page — category filter dropdown + mobile grid progress
 */
(function ($) {
  "use strict";

  function isPhone() {
    return window.matchMedia("(max-width: 767.98px)").matches;
  }

  function initBlogsGridProgress() {
    var $shell = $("[data-blogs-grid-shell]");
    var $track = $shell.find("[data-blogs-grid-track]");
    var $fill = $shell.find("[data-blogs-grid-progress]");

    if (!$shell.length || !$track.length || !$fill.length) {
      return;
    }

    var shellEl = $shell.get(0);
    var fillEl = $fill.get(0);
    var rafId = null;

    function getHeaderOffset() {
      var header =
        document.querySelector(".mobile-header") ||
        document.querySelector("#masthead");
      if (!header) {
        return 0;
      }
      return Math.ceil(header.getBoundingClientRect().height || 0);
    }

    function setProgress(progress) {
      var pct = (Math.max(0, Math.min(1, progress)) * 100).toFixed(2) + "%";
      fillEl.style.setProperty("--blogs-grid-progress", pct);
    }

    function updateProgress() {
      if (!isPhone()) {
        setProgress(0.262);
        $track.attr("aria-hidden", "true");
        return;
      }

      var rect = shellEl.getBoundingClientRect();
      var viewportH = window.innerHeight || document.documentElement.clientHeight || 0;
      var headerOffset = getHeaderOffset();
      var startLine = headerOffset;
      var scrolled = startLine - rect.top;
      var scrollable = Math.max(rect.height - (viewportH - headerOffset), 1);
      var progress = scrolled / scrollable;
      var minProgress = 0.262;

      progress = Math.max(0, Math.min(1, progress));

      if (progress > 0 && progress < minProgress) {
        progress = minProgress;
      } else if (
        progress <= 0 &&
        rect.top < viewportH &&
        rect.bottom > headerOffset
      ) {
        progress = minProgress;
      }

      setProgress(progress);
      $track.attr({
        "aria-hidden": "false",
        role: "progressbar",
        "aria-valuemin": "0",
        "aria-valuemax": "100",
        "aria-valuenow": String(Math.round(progress * 100)),
      });
    }

    function scheduleUpdate() {
      if (rafId) {
        window.cancelAnimationFrame(rafId);
      }
      rafId = window.requestAnimationFrame(function () {
        rafId = null;
        updateProgress();
      });
    }

    window.addEventListener("scroll", scheduleUpdate, { passive: true });
    window.addEventListener("resize", scheduleUpdate, { passive: true });
    window.addEventListener("orientationchange", scheduleUpdate, { passive: true });
    document.addEventListener("scroll", scheduleUpdate, { passive: true, capture: true });
    $(window).on("load.blogsGridProgress", function () {
      window.setTimeout(scheduleUpdate, 100);
      window.setTimeout(scheduleUpdate, 600);
    });

    if (window.ResizeObserver) {
      var observer = new ResizeObserver(scheduleUpdate);
      observer.observe(shellEl);
    }

    scheduleUpdate();
  }

  function initBlogsPage() {
    var $root = $(".blogs-page-main");
    if (!$root.length) {
      return;
    }

    var $cards = $root.find(".blogs-card");
    var $empty = $root.find(".blogs-empty-state");
    var $filterPanel = $root.find("#blogs-filter-panel");
    var $browseWrap = $root.find(".blogs-filter-browse-wrap");
    var $browseBtn = $root.find(".blogs-filter-browse");
    var $allBtn = $root.find(".blogs-filter-all");
    var $panelOptions = $root.find(".blogs-filter-panel-option");
    var activeFilter = "all";

    function matchesFilter(categorySlugs) {
      if ("all" === activeFilter) {
        return true;
      }

      if (!categorySlugs) {
        return false;
      }

      return (" " + categorySlugs + " ").indexOf(" " + activeFilter + " ") !== -1;
    }

    function applyFilterState() {
      var visibleCount = 0;

      $cards.each(function () {
        var $card = $(this);
        var matches = matchesFilter($card.attr("data-category-slugs") || "");
        $card.toggleClass("is-filtered-out", !matches);
        if (matches) {
          visibleCount += 1;
        }
      });

      if ($empty.length) {
        $empty.prop("hidden", visibleCount > 0);
        $empty.toggleClass("is-visible", visibleCount === 0);
      }

      window.dispatchEvent(new Event("resize"));
    }

    function syncFilterUi() {
      $allBtn.removeClass("is-active").attr("aria-pressed", "false");
      $browseBtn.removeClass("is-active");
      $panelOptions.removeClass("is-active").attr("aria-selected", "false");

      if ("all" === activeFilter) {
        $allBtn.addClass("is-active").attr("aria-pressed", "true");
        $browseBtn
          .find(".blogs-filter-browse-label")
          .text($browseBtn.data("default-label") || "Browse by Filters");
        return;
      }

      var $option = $panelOptions.filter('[data-filter="' + activeFilter + '"]');
      var label =
        ($option.length && $option.data("label")) ||
        ($option.length && $option.text().trim()) ||
        activeFilter;

      $option.addClass("is-active").attr("aria-selected", "true");
      $browseBtn.addClass("is-active");
      $browseBtn.find(".blogs-filter-browse-label").text(label);
    }

    function openFilterPanel() {
      if (!$filterPanel.length) {
        return;
      }

      $filterPanel.removeAttr("hidden");
      $browseBtn.attr("aria-expanded", "true");
      $browseWrap.addClass("is-open");
    }

    function closeFilterPanel() {
      if (!$filterPanel.length) {
        return;
      }

      $filterPanel.attr("hidden", "hidden");
      $browseBtn.attr("aria-expanded", "false");
      $browseWrap.removeClass("is-open");
    }

    function activateFilter(filterValue) {
      activeFilter = filterValue || "all";
      applyFilterState();
      syncFilterUi();
      closeFilterPanel();
    }

    $allBtn.on("click", function (event) {
      event.preventDefault();
      activateFilter("all");
    });

    $panelOptions.on("click", function (event) {
      event.preventDefault();
      activateFilter($(this).attr("data-filter") || "all");
    });

    $browseBtn.on("click", function (event) {
      event.preventDefault();
      event.stopPropagation();
      if ($filterPanel.is("[hidden]")) {
        openFilterPanel();
      } else {
        closeFilterPanel();
      }
    });

    $(document).on("click.blogsFilter", function (event) {
      if (!$browseWrap.hasClass("is-open")) {
        return;
      }

      if (!$(event.target).closest(".blogs-filter-browse-wrap").length) {
        closeFilterPanel();
      }
    });

    $(document).on("keydown.blogsFilter", function (event) {
      if (event.key === "Escape") {
        closeFilterPanel();
      }
    });

    if ($browseBtn.length) {
      $browseBtn.data(
        "default-label",
        $browseBtn.find(".blogs-filter-browse-label").text()
      );
    }

    applyFilterState();
    syncFilterUi();
    initBlogsGridProgress();
  }

  $(initBlogsPage);
})(jQuery);
