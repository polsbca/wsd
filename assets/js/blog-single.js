/**
 * Blog detail page — related blogs carousel
 */
(function ($) {
  "use strict";

  function isPhone() {
    return window.matchMedia("(max-width: 767.98px)").matches;
  }

  function isTablet() {
    return window.matchMedia("(min-width: 768px) and (max-width: 991.98px)").matches;
  }

  function isNarrowDesktop() {
    return window.matchMedia("(min-width: 992px) and (max-width: 1199.98px)").matches;
  }

  function getVisibleCount() {
    if (isPhone() || isTablet()) {
      return 1;
    }
    if (isNarrowDesktop()) {
      return 2;
    }
    return 3;
  }

  function initRelatedBlogs() {
    var $root = $(".blog-detail-related");
    if (!$root.length) {
      return;
    }

    var $viewport = $root.find("[data-related-viewport]");
    var $track = $root.find("[data-related-track]");
    var $cards = $track.find(".blog-detail-related-card");
    var $prev = $root.find(".blog-detail-related-nav-btn--prev");
    var $next = $root.find(".blog-detail-related-nav-btn--next");
    var $dots = $root.find("[data-related-dots]");
    var viewportEl = $viewport.get(0);

    if (!$viewport.length || !$track.length || !$cards.length || !viewportEl) {
      return;
    }

    var index = 0;
    var visible = getVisibleCount();
    var drag = {
      active: false,
      pointerId: null,
      startX: 0,
      startY: 0,
      deltaX: 0,
      dragging: false,
      locked: false,
      suppressClick: false,
    };

    function getStep() {
      var first = $cards.first();
      if (!first.length) {
        return 0;
      }
      var gap = parseFloat($track.css("gap")) || 40;
      return first.outerWidth(true) + gap;
    }

    function maxIndex() {
      return Math.max(0, $cards.length - visible);
    }

    function setTrackOffset(offsetPx, animate) {
      if (!animate) {
        $track.css("transition", "none");
      } else {
        $track.css("transition", "");
      }
      $track.css("transform", "translateX(" + offsetPx + "px)");
    }

    function buildDots() {
      if (!$dots.length) {
        return;
      }

      var pages = maxIndex() + 1;
      var showDots =
        (isPhone() || isTablet()) && $cards.length > 1 && pages > 1;

      $dots.empty();

      if (!showDots) {
        $dots.attr("hidden", "hidden");
        return;
      }

      $dots.removeAttr("hidden");

      for (var i = 0; i < pages; i += 1) {
        var $dot = $("<button/>", {
          type: "button",
          class: "blog-detail-related-dot" + (i === index ? " is-active" : ""),
          "aria-label": "Go to related blog set " + (i + 1),
          "aria-selected": i === index ? "true" : "false",
          role: "tab",
          "data-index": i,
        });
        $dots.append($dot);
      }
    }

    function updateDots() {
      if (!$dots.length || $dots.is("[hidden]")) {
        return;
      }

      $dots.find(".blog-detail-related-dot").each(function () {
        var $dot = $(this);
        var isActive = Number($dot.attr("data-index")) === index;
        $dot.toggleClass("is-active", isActive);
        $dot.attr("aria-selected", isActive ? "true" : "false");
      });
    }

    function update() {
      visible = getVisibleCount();
      var step = getStep();
      var max = maxIndex();

      if (index > max) {
        index = max;
      }

      setTrackOffset(-(index * step), true);

      if ($prev.length) {
        $prev.prop("disabled", index <= 0);
        $prev.toggleClass("is-active", index > 0);
      }

      if ($next.length) {
        $next.prop("disabled", index >= max);
        $next.toggleClass("is-active", index < max);
      }

      buildDots();
      updateDots();
    }

    function goTo(nextIndex) {
      var max = maxIndex();
      index = Math.max(0, Math.min(max, nextIndex));
      update();
    }

    function onPointerDown(event) {
      if (maxIndex() <= 0) {
        return;
      }

      // Ignore non-primary mouse button / multi-touch start
      if (event.pointerType === "mouse" && event.button !== 0) {
        return;
      }

      drag.active = true;
      drag.pointerId = event.pointerId;
      drag.startX = event.clientX;
      drag.startY = event.clientY;
      drag.deltaX = 0;
      drag.dragging = false;
      drag.locked = false;

      if (viewportEl.setPointerCapture) {
        try {
          viewportEl.setPointerCapture(event.pointerId);
        } catch (err) {
          // Ignore capture errors on unsupported browsers.
        }
      }
    }

    function onPointerMove(event) {
      if (!drag.active || event.pointerId !== drag.pointerId) {
        return;
      }

      var dx = event.clientX - drag.startX;
      var dy = event.clientY - drag.startY;

      if (!drag.locked) {
        if (Math.abs(dx) < 8 && Math.abs(dy) < 8) {
          return;
        }

        // Prefer vertical page scroll when gesture is mostly vertical.
        if (Math.abs(dy) > Math.abs(dx)) {
          drag.active = false;
          drag.pointerId = null;
          return;
        }

        drag.locked = true;
        drag.dragging = true;
        $track.css("transition", "none");
        $viewport.addClass("is-dragging");
      }

      event.preventDefault();
      drag.deltaX = dx;

      var step = getStep();
      var base = -(index * step);
      var max = maxIndex();
      var next = base + dx;

      // Soft resistance at edges
      if ((index <= 0 && dx > 0) || (index >= max && dx < 0)) {
        next = base + dx * 0.35;
      }

      setTrackOffset(next, false);
    }

    function onPointerUp(event) {
      if (!drag.active || event.pointerId !== drag.pointerId) {
        return;
      }

      var wasDragging = drag.dragging;
      var deltaX = drag.deltaX;
      var step = getStep();
      var threshold = Math.max(48, step * 0.2);

      drag.active = false;
      drag.pointerId = null;
      drag.dragging = false;
      drag.locked = false;
      $viewport.removeClass("is-dragging");

      if (viewportEl.releasePointerCapture) {
        try {
          viewportEl.releasePointerCapture(event.pointerId);
        } catch (err) {
          // Ignore release errors.
        }
      }

      if (!wasDragging) {
        return;
      }

      drag.suppressClick = true;
      window.setTimeout(function () {
        drag.suppressClick = false;
      }, 350);

      if (deltaX <= -threshold) {
        goTo(index + 1);
      } else if (deltaX >= threshold) {
        goTo(index - 1);
      } else {
        update();
      }
    }

    $viewport.on("click", "a", function (event) {
      if (drag.suppressClick) {
        event.preventDefault();
        event.stopImmediatePropagation();
      }
    });

    $prev.on("click", function () {
      if (index <= 0) {
        return;
      }
      goTo(index - 1);
    });

    $next.on("click", function () {
      if (index >= maxIndex()) {
        return;
      }
      goTo(index + 1);
    });

    $dots.on("click", ".blog-detail-related-dot", function () {
      var nextIndex = Number($(this).attr("data-index"));
      if (Number.isNaN(nextIndex)) {
        return;
      }
      goTo(nextIndex);
    });

    viewportEl.addEventListener("pointerdown", onPointerDown, { passive: true });
    viewportEl.addEventListener("pointermove", onPointerMove, { passive: false });
    viewportEl.addEventListener("pointerup", onPointerUp, { passive: true });
    viewportEl.addEventListener("pointercancel", onPointerUp, { passive: true });

    // Prevent native image drag interfering with swipe
    $viewport.on("dragstart", "img, a", function (event) {
      event.preventDefault();
    });

    $(window).on("resize.wsdBlogSingle", function () {
      update();
    });

    update();
  }

  $(function () {
    initRelatedBlogs();
  });
})(jQuery);
