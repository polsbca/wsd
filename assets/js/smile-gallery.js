/**
 * Smile Gallery page — filters + sticky scroll (desktop) / slider (mobile)
 */
(function ($) {
  "use strict";

  function initSmileGalleryPage() {
    var $root = $(".smile-gallery-page-main");
    if (!$root.length) {
      return;
    }

    var $section = $root.find(".smile-gallery-cases-section");
    var $casesBody = $root.find(".smile-gallery-cases-body");
    var $casesRow = $root.find(".smile-gallery-cases-row");
    var $filters = $root.find(".smile-gallery-filter");
    var $slides = $root.find(".smile-gallery-page-slide");
    var $details = $root.find(".smile-gallery-page-details");
    var $indicator = $root.find(".smile-gallery-page-indicator");
    var $handle = $indicator.find(".gallery-scroll-indicator-handle");
    var $container = $indicator;
    var $wrapper = $root.find(".smile-gallery-page-interactive");
    var $dotsContainer = $root.find(".smile-gallery-page-dots");
    var $filterPanel = $root.find("#smile-gallery-filter-panel");
    var $browseBtn = $root.find(".smile-gallery-mobile-browse");
    var $mobileAllBtn = $root.find(".smile-gallery-mobile-all");
    var $panelOptions = $root.find(".smile-gallery-filter-panel-option");
    var activeFilter = "all";
    var scrollTimeline = null;
    var isDesktop = window.innerWidth >= 992;
    var rowResizeObserver = null;
    var fitScaleRaf = null;
    var mobileSlider = {
      currentIndex: 0,
      interval: null,
      touchStartX: 0,
      bound: false,
    };

    function resetGalleryRowScale() {
      if (!$casesRow.length) {
        return;
      }

      $casesRow.css({
        "--sg-row-scale": 1,
        "--sg-row-margin-bottom": "0px",
      });
    }

    function fitGalleryRowScale() {
      if (!$casesBody.length || !$casesRow.length) {
        return;
      }

      resetGalleryRowScale();

      if (!isDesktop) {
        return;
      }

      var bodyEl = $casesBody[0];
      var rowEl = $casesRow[0];
      var available = bodyEl.clientWidth;
      var needed = rowEl.scrollWidth;

      if (!available || !needed || needed <= available) {
        return;
      }

      var scale = available / needed;
      var scaledHeight = rowEl.offsetHeight * scale;

      $casesRow.css({
        "--sg-row-scale": scale,
        "--sg-row-margin-bottom": scaledHeight - rowEl.offsetHeight + "px",
      });
    }

    function scheduleGalleryRowFit() {
      if (fitScaleRaf) {
        window.cancelAnimationFrame(fitScaleRaf);
      }

      fitScaleRaf = window.requestAnimationFrame(function () {
        fitScaleRaf = null;
        fitGalleryRowScale();
      });
    }

    function bindGalleryRowFit() {
      scheduleGalleryRowFit();

      if (typeof ResizeObserver === "undefined" || !$casesBody.length) {
        return;
      }

      if (rowResizeObserver) {
        rowResizeObserver.disconnect();
      }

      rowResizeObserver = new ResizeObserver(function () {
        scheduleGalleryRowFit();
      });
      rowResizeObserver.observe($casesBody[0]);
      rowResizeObserver.observe($casesRow[0]);
    }

    function matchesFilter(categorySlugs) {
      if ("all" === activeFilter) {
        return true;
      }

      if (!categorySlugs) {
        return false;
      }

      return (" " + categorySlugs + " ").indexOf(" " + activeFilter + " ") !== -1;
    }

    function getVisibleSlides() {
      return $slides.filter(function () {
        return (
          !$(this).hasClass("is-filtered-out") &&
          matchesFilter($(this).attr("data-category-slugs") || "")
        );
      });
    }

    function getVisibleDetails() {
      return $details.filter(function () {
        return (
          !$(this).hasClass("is-filtered-out") &&
          matchesFilter($(this).attr("data-category-slugs") || "")
        );
      });
    }

    function setActiveByIndex(activeIndex, $visibleSlides) {
      $slides.removeClass("active");
      $details.removeClass("active");

      var $activeSlide = $visibleSlides.eq(activeIndex);
      if (!$activeSlide.length) {
        return;
      }

      var slideIndex = $activeSlide.attr("data-index");

      $activeSlide.addClass("active");
      $details.filter('[data-index="' + slideIndex + '"]').addClass("active");
    }

    function applyFilterState() {
      $slides.each(function () {
        var $slide = $(this);
        var matches = matchesFilter($slide.attr("data-category-slugs") || "");
        $slide.toggleClass("is-filtered-out", !matches);
      });

      $details.each(function () {
        var $detail = $(this);
        var matches = matchesFilter($detail.attr("data-category-slugs") || "");
        $detail.toggleClass("is-filtered-out", !matches);
      });

      var $visibleSlides = getVisibleSlides();

      if ($visibleSlides.length) {
        setActiveByIndex(0, $visibleSlides);
      }

      if ($section.length && isDesktop) {
        var trackMultiplier = Math.max($visibleSlides.length, 1);
        $section.css(
          "--smile-gallery-track-height",
          trackMultiplier * 75 + "vh",
        );
      } else if ($section.length) {
        $section.css("--smile-gallery-track-height", "auto");
      }
    }

    function syncMobileFilterUi($activeFilterEl) {
      var filterValue = activeFilter;

      $filters.removeClass("is-active").attr({
        "aria-selected": "false",
        "aria-pressed": "false",
      });
      $panelOptions.removeClass("is-active");

      if (isDesktop) {
        var $desktopFilter = $root
          .find(
            '.smile-gallery-filters--desktop .smile-gallery-filter[data-filter="' +
              filterValue +
              '"]',
          )
          .first();

        if (!$desktopFilter.length) {
          $desktopFilter = $root
            .find(".smile-gallery-filters--desktop .smile-gallery-filter")
            .first();
        }

        if ($desktopFilter.length) {
          $desktopFilter.addClass("is-active").attr("aria-selected", "true");
        }
      } else if ("all" === filterValue) {
        $mobileAllBtn.addClass("is-active").attr("aria-pressed", "true");
      } else if ($activeFilterEl && $activeFilterEl.length) {
        $activeFilterEl.addClass("is-active").attr("aria-pressed", "true");
        $panelOptions
          .filter('[data-filter="' + filterValue + '"]')
          .addClass("is-active");
      }

      if ($browseBtn.length) {
        if ("all" === filterValue) {
          $browseBtn.removeClass("is-active");
          $browseBtn
            .find(".smile-gallery-mobile-browse-label")
            .text($browseBtn.data("default-label") || "Browse by Filters");
        } else {
          var $option = $panelOptions.filter(
            '[data-filter="' + filterValue + '"]',
          );
          var label =
            ($option.length && $option.data("label")) ||
            ($option.length && $option.text().trim()) ||
            filterValue;

          $browseBtn.addClass("is-active");
          $browseBtn.find(".smile-gallery-mobile-browse-label").text(label);
        }
      }
    }

    function openFilterPanel() {
      if (!$filterPanel.length) {
        return;
      }

      $filterPanel.removeAttr("hidden");
      $browseBtn.attr("aria-expanded", "true");
      document.body.classList.add("smile-gallery-filter-open");
    }

    function closeFilterPanel() {
      if (!$filterPanel.length) {
        return;
      }

      $filterPanel.attr("hidden", "hidden");
      $browseBtn.attr("aria-expanded", "false");
      document.body.classList.remove("smile-gallery-filter-open");
    }

    function destroyScrollTimeline() {
      if (scrollTimeline) {
        scrollTimeline.scrollTrigger && scrollTimeline.scrollTrigger.kill();
        scrollTimeline.kill();
        scrollTimeline = null;
      }
    }

    function initStickyScroll() {
      destroyScrollTimeline();

      if (
        !isDesktop ||
        typeof gsap === "undefined" ||
        typeof ScrollTrigger === "undefined"
      ) {
        return;
      }

      if (!$section.length || !$handle.length || !$container.length) {
        return;
      }

      var visibleSlides = getVisibleSlides().toArray();
      var visibleDetails = getVisibleDetails().toArray();

      if (!visibleSlides.length) {
        return;
      }

      gsap.set($handle[0], { y: 0 });

      var updateHandleY = function () {
        var scrollBarHeight = $container[0].clientHeight || 480;
        var handleHeight = $handle[0].clientHeight || 103;
        return Math.max(scrollBarHeight - handleHeight, 0);
      };

      scrollTimeline = gsap.timeline({
        scrollTrigger: {
          trigger: $section[0],
          start: "top top",
          end: "bottom bottom",
          scrub: 0.5,
          onUpdate: function (self) {
            var progress = self.progress;
            var activeIndex = Math.min(
              Math.floor(progress * visibleSlides.length),
              visibleSlides.length - 1,
            );

            visibleSlides.forEach(function (slide, idx) {
              slide.classList.toggle("active", idx === activeIndex);
            });

            visibleDetails.forEach(function (detail, idx) {
              detail.classList.toggle("active", idx === activeIndex);
            });
          },
        },
      });

      scrollTimeline.to(
        $handle[0],
        {
          y: updateHandleY,
          ease: "none",
          duration: 1,
        },
        0,
      );
    }

    function getGallerySectionScrollTop() {
      if (!$section.length) {
        return 0;
      }

      var header = document.querySelector("#masthead.site-header");
      var headerOffset = header
        ? header.getBoundingClientRect().height + 20
        : 20;

      return (
        $section[0].getBoundingClientRect().top +
        window.scrollY -
        headerOffset
      );
    }

    function resetGalleryScrollProgress() {
      var $visibleSlides = getVisibleSlides();

      if ($visibleSlides.length) {
        setActiveByIndex(0, $visibleSlides);
      }

      if ($handle.length && typeof gsap !== "undefined") {
        gsap.set($handle[0], { y: 0 });
      }

      if (scrollTimeline) {
        scrollTimeline.progress(0);
      }
    }

    function clearMobileSliderTimer() {
      if (mobileSlider.interval) {
        window.clearInterval(mobileSlider.interval);
        mobileSlider.interval = null;
      }
    }

    function buildMobileDots($visibleSlides) {
      if (!$dotsContainer.length) {
        return $();
      }

      $dotsContainer.empty();

      $visibleSlides.each(function (index) {
        $dotsContainer.append(
          $(
            '<button type="button" class="gallery-dot" aria-label="Go to case ' +
              (index + 1) +
              '"></button>',
          ),
        );
      });

      return $dotsContainer.find(".gallery-dot");
    }

    function showMobileSlide(index, $visibleSlides, $dots) {
      if (!$visibleSlides.length) {
        return;
      }

      var safeIndex = Math.max(0, Math.min(index, $visibleSlides.length - 1));
      setActiveByIndex(safeIndex, $visibleSlides);
      mobileSlider.currentIndex = safeIndex;

      if ($dots && $dots.length) {
        $dots.removeClass("active");
        $dots.eq(safeIndex).addClass("active");
      }
    }

    function initMobileCaseSlider() {
      clearMobileSliderTimer();

      if (isDesktop || !$wrapper.length) {
        $dotsContainer.empty();
        return;
      }

      var $visibleSlides = getVisibleSlides();
      var $dots = buildMobileDots($visibleSlides);

      if ($visibleSlides.length <= 1) {
        showMobileSlide(0, $visibleSlides, $dots);
        return;
      }

      showMobileSlide(0, $visibleSlides, $dots);

      $dots.off("click").on("click", function () {
        showMobileSlide($(this).index(), $visibleSlides, $dots);
        clearMobileSliderTimer();
        mobileSlider.interval = window.setInterval(function () {
          var nextIndex =
            (mobileSlider.currentIndex + 1) % $visibleSlides.length;
          showMobileSlide(nextIndex, $visibleSlides, $dots);
        }, 5000);
      });

      if (!mobileSlider.bound) {
        mobileSlider.bound = true;

        $wrapper.on("touchstart", function (event) {
          var touches =
            event.touches ||
            (event.originalEvent && event.originalEvent.touches);
          if (touches && touches.length) {
            mobileSlider.touchStartX = touches[0].clientX;
          }
        });

        $wrapper.on("touchend", function (event) {
          var touches =
            event.changedTouches ||
            (event.originalEvent && event.originalEvent.changedTouches);
          if (!touches || !touches.length) {
            return;
          }

          var touchEndX = touches[0].clientX;
          var delta = mobileSlider.touchStartX - touchEndX;
          var $currentVisible = getVisibleSlides();
          var $currentDots = $dotsContainer.find(".gallery-dot");

          if (Math.abs(delta) < 50 || $currentVisible.length <= 1) {
            return;
          }

          var nextIndex = mobileSlider.currentIndex;

          if (delta > 0) {
            nextIndex = (mobileSlider.currentIndex + 1) % $currentVisible.length;
          } else {
            nextIndex =
              (mobileSlider.currentIndex - 1 + $currentVisible.length) %
              $currentVisible.length;
          }

          showMobileSlide(nextIndex, $currentVisible, $currentDots);
          clearMobileSliderTimer();
          mobileSlider.interval = window.setInterval(function () {
            var autoIndex =
              (mobileSlider.currentIndex + 1) % $currentVisible.length;
            showMobileSlide(autoIndex, $currentVisible, $currentDots);
          }, 5000);
        });
      }

      mobileSlider.interval = window.setInterval(function () {
        var $currentVisible = getVisibleSlides();
        var $currentDots = $dotsContainer.find(".gallery-dot");
        if ($currentVisible.length <= 1) {
          return;
        }
        var nextIndex =
          (mobileSlider.currentIndex + 1) % $currentVisible.length;
        showMobileSlide(nextIndex, $currentVisible, $currentDots);
      }, 5000);
    }

    function activateFilter($filter) {
      activeFilter = $filter.attr("data-filter") || "all";

      applyFilterState();
      syncMobileFilterUi($filter);
      closeFilterPanel();

      if ($section.length && isDesktop) {
        window.scrollTo({
          top: getGallerySectionScrollTop(),
          behavior: "auto",
        });
      }

      initStickyScroll();
      bindGalleryRowFit();
      resetGalleryScrollProgress();
      initMobileCaseSlider();

      if (typeof ScrollTrigger !== "undefined") {
        ScrollTrigger.refresh();
      }
    }

    $root.on("click", ".smile-gallery-filters--desktop .smile-gallery-filter", function (event) {
      event.preventDefault();
      activateFilter($(this));
    });

    $mobileAllBtn.on("click", function (event) {
      event.preventDefault();
      activateFilter($(this));
    });

    $panelOptions.on("click", function (event) {
      event.preventDefault();
      activateFilter($(this));
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
      .find(".smile-gallery-filter-panel-backdrop, .smile-gallery-filter-panel-close")
      .on("click", function (event) {
        event.preventDefault();
        closeFilterPanel();
      });

    if ($indicator.length) {
      $indicator
        .find(".gallery-scroll-indicator-track")
        .on("click", function (event) {
          var visibleSlides = getVisibleSlides();
          var total = visibleSlides.length;
          if (total <= 1 || !scrollTimeline || !scrollTimeline.scrollTrigger) {
            return;
          }

          var rect = $indicator[0].getBoundingClientRect();
          var clickY = event.clientY - rect.top;
          var progress = clickY / rect.height;
          var targetIndex = Math.round(progress * (total - 1));
          var sectionTop = $section[0].offsetTop;
          var sectionHeight = $section[0].offsetHeight - window.innerHeight;
          var targetScroll =
            sectionTop +
            (sectionHeight * targetIndex) / Math.max(total - 1, 1);

          window.scrollTo({
            top: targetScroll,
            behavior: "smooth",
          });
        });
    }

    $(window).on("resize", function () {
      var wasDesktop = isDesktop;
      isDesktop = window.innerWidth >= 992;

      if (wasDesktop !== isDesktop) {
        if (isDesktop) {
          clearMobileSliderTimer();
        } else {
          destroyScrollTimeline();
        }

        applyFilterState();
        syncMobileFilterUi();
        initStickyScroll();
        bindGalleryRowFit();
        initMobileCaseSlider();
      } else {
        scheduleGalleryRowFit();
      }

      if (typeof ScrollTrigger !== "undefined") {
        ScrollTrigger.refresh();
      }
    });

    if (window.visualViewport) {
      window.visualViewport.addEventListener("resize", scheduleGalleryRowFit);
      window.visualViewport.addEventListener("scroll", scheduleGalleryRowFit);
    }

    $(window).on("load", scheduleGalleryRowFit);

    if ($browseBtn.length) {
      $browseBtn.data(
        "default-label",
        $browseBtn.find(".smile-gallery-mobile-browse-label").text(),
      );
    }

    applyFilterState();
    syncMobileFilterUi();
    initStickyScroll();
    bindGalleryRowFit();
    initMobileCaseSlider();

    if (typeof ScrollTrigger !== "undefined") {
      ScrollTrigger.refresh();
    }
  }

  $(initSmileGalleryPage);
})(jQuery);
