/**
 * Fees & Membership page — tabs + accordion
 */
(function ($) {
  "use strict";

  function initFeesPage() {
    var $root = $(".fees-page-main");
    if (!$root.length) {
      return;
    }

    var $tabs = $root.find(".fees-tab");
    var $panels = $root.find(".fees-accordion-panel");
    var $tablist = $root.find(".fees-tabs");
    var $indicator = $tablist.find(".fees-tabs-indicator");
    var resizeTimer = null;

    function updateTabIndicator($tab, animate) {
      if (!$indicator.length || !$tab.length) {
        return;
      }

      var tablistEl = $tablist[0];
      var tabEl = $tab[0];
      if (!tablistEl || !tabEl) {
        return;
      }

      if (!animate) {
        $indicator.addClass("is-instant");
      }

      $indicator.css({
        left: tabEl.offsetLeft + "px",
        top: tabEl.offsetTop + "px",
        width: tabEl.offsetWidth + "px",
        height: tabEl.offsetHeight + "px",
      });

      if (!animate) {
        window.requestAnimationFrame(function () {
          window.requestAnimationFrame(function () {
            $indicator.removeClass("is-instant");
          });
        });
      }
    }

    function refreshTabIndicator(animate) {
      updateTabIndicator($tabs.filter(".is-active").first(), animate);
    }

    function activateTab($tab) {
      var panelId = $tab.attr("aria-controls");
      if (!panelId) {
        return;
      }

      $tabs.removeClass("is-active").attr({
        "aria-selected": "false",
        tabindex: "-1",
      });
      $tab.addClass("is-active").attr({
        "aria-selected": "true",
        tabindex: "0",
      });

      updateTabIndicator($tab, true);

      $panels.removeClass("is-active is-entering").attr("hidden", true);
      var $panel = $("#" + panelId);
      $panel.addClass("is-active").removeAttr("hidden");

      window.requestAnimationFrame(function () {
        $panel.addClass("is-entering");
        window.setTimeout(function () {
          $panel.removeClass("is-entering");
        }, 400);
      });
    }

    $tabs.on("click", function () {
      if ($(this).hasClass("is-active")) {
        return;
      }
      activateTab($(this));
    });

    $tabs.on("keydown", function (e) {
      var keys = ["ArrowLeft", "ArrowRight", "Home", "End"];
      if (keys.indexOf(e.key) === -1) {
        return;
      }

      e.preventDefault();
      var index = $tabs.index(this);
      var next = index;

      if (e.key === "ArrowRight") {
        next = (index + 1) % $tabs.length;
      } else if (e.key === "ArrowLeft") {
        next = (index - 1 + $tabs.length) % $tabs.length;
      } else if (e.key === "Home") {
        next = 0;
      } else if (e.key === "End") {
        next = $tabs.length - 1;
      }

      var $next = $tabs.eq(next);
      activateTab($next);
      $next.focus();
    });

    $root.on("click", ".fees-accordion-trigger", function () {
      var $item = $(this).closest(".fees-accordion-item");
      var $panel = $item.closest(".fees-accordion-panel");
      var isOpen = $item.hasClass("is-open");

      $panel.find(".fees-accordion-item.is-open").each(function () {
        var $openItem = $(this);
        $openItem.removeClass("is-open");
        $openItem
          .find(".fees-accordion-trigger")
          .attr("aria-expanded", "false");
        $openItem.find(".fees-accordion-content").attr("hidden", true);
      });

      if (!isOpen) {
        $item.addClass("is-open");
        $(this).attr("aria-expanded", "true");
        $item.find(".fees-accordion-content").removeAttr("hidden");
      }
    });

    refreshTabIndicator(false);

    if (window.ResizeObserver && $tablist[0]) {
      var tablistObserver = new ResizeObserver(function () {
        refreshTabIndicator(false);
      });
      tablistObserver.observe($tablist[0]);
      $tabs.each(function () {
        tablistObserver.observe(this);
      });
    }

    $(window).on("resize.feesTabs", function () {
      window.clearTimeout(resizeTimer);
      resizeTimer = window.setTimeout(function () {
        refreshTabIndicator(false);
      }, 100);
    });

    $(window).on("load.feesTabs", function () {
      refreshTabIndicator(false);
    });

    if (window.visualViewport) {
      window.visualViewport.addEventListener("resize", function () {
        refreshTabIndicator(false);
      });
    }
  }

  $(initFeesPage);
})(jQuery);
