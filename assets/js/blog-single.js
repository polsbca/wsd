/**
 * Blog detail page — related blogs carousel
 */
(function ($) {
  "use strict";

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

    if (!$viewport.length || !$track.length || $cards.length <= 3) {
      return;
    }

    var index = 0;
    var visible = 3;

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

    function update() {
      var step = getStep();
      var max = maxIndex();

      if (index > max) {
        index = max;
      }

      $track.css("transform", "translateX(" + -(index * step) + "px)");

      $prev.prop("disabled", index <= 0);
      $next.prop("disabled", index >= max);

      $prev.toggleClass("is-active", index > 0);
      $next.toggleClass("is-active", index < max);
    }

    $prev.on("click", function () {
      if (index <= 0) {
        return;
      }
      index -= 1;
      update();
    });

    $next.on("click", function () {
      if (index >= maxIndex()) {
        return;
      }
      index += 1;
      update();
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
