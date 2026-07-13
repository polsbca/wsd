/**
 * Blogs page — category filter panel
 */
(function ($) {
  "use strict";

  function initBlogsPage() {
    var $root = $(".blogs-page-main");
    if (!$root.length) {
      return;
    }

    var $cards = $root.find(".blogs-card");
    var $empty = $root.find(".blogs-empty-state");
    var $filterPanel = $root.find("#blogs-filter-panel");
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
    }

    function syncFilterUi() {
      $allBtn.removeClass("is-active").attr("aria-pressed", "false");
      $browseBtn.removeClass("is-active");
      $panelOptions.removeClass("is-active");

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

      $option.addClass("is-active");
      $browseBtn.addClass("is-active");
      $browseBtn.find(".blogs-filter-browse-label").text(label);
    }

    function openFilterPanel() {
      if (!$filterPanel.length) {
        return;
      }

      $filterPanel.removeAttr("hidden");
      $browseBtn.attr("aria-expanded", "true");
      document.body.classList.add("blogs-filter-open");
    }

    function closeFilterPanel() {
      if (!$filterPanel.length) {
        return;
      }

      $filterPanel.attr("hidden", "hidden");
      $browseBtn.attr("aria-expanded", "false");
      document.body.classList.remove("blogs-filter-open");
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
      if ($filterPanel.is("[hidden]")) {
        openFilterPanel();
      } else {
        closeFilterPanel();
      }
    });

    $filterPanel
      .find(".blogs-filter-panel-backdrop, .blogs-filter-panel-close")
      .on("click", function (event) {
        event.preventDefault();
        closeFilterPanel();
      });

    if ($browseBtn.length) {
      $browseBtn.data(
        "default-label",
        $browseBtn.find(".blogs-filter-browse-label").text()
      );
    }

    applyFilterState();
    syncFilterUi();
  }

  $(initBlogsPage);
})(jQuery);
