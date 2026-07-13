/**
 * Blogs page — category filter dropdown
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
  }

  $(initBlogsPage);
})(jQuery);
