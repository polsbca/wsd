(function () {
  "use strict";

  function initTeamsSlider(slider) {
    if (!slider) {
      return;
    }

    var track = slider.querySelector(".teams-slider-track");
    var viewport = slider.querySelector(".teams-slider-viewport");
    var progressFill = slider.querySelector(".teams-slider-progress-fill");
    var prevBtn = slider.querySelector(".teams-slider-nav-btn--prev");
    var nextBtn = slider.querySelector(".teams-slider-nav-btn--next");
    var emptyMessage = slider.querySelector(".teams-support-empty");
    var isSupport = slider.getAttribute("data-teams-slider") === "support";
    var index = 0;

    function getSlides() {
      if (!isSupport) {
        return Array.prototype.slice.call(
          slider.querySelectorAll(".teams-member-card"),
        );
      }

      var category = slider.getAttribute("data-active-category") || "clinical";
      return Array.prototype.slice
        .call(slider.querySelectorAll(".teams-member-card"))
        .filter(function (card) {
          return card.getAttribute("data-support-category") === category;
        });
    }

    function update() {
      var slides = getSlides();
      var allCards = slider.querySelectorAll(".teams-member-card");

      allCards.forEach(function (card) {
        card.classList.remove("is-active");
        if (isSupport) {
          card.hidden = true;
        }
      });

      if (!slides.length) {
        if (emptyMessage) {
          emptyMessage.hidden = false;
        }
        if (track) {
          track.style.transform = "translateX(0)";
        }
        if (progressFill) {
          progressFill.style.width = "0%";
        }
        if (prevBtn) {
          prevBtn.disabled = true;
          prevBtn.classList.remove("is-active");
        }
        if (nextBtn) {
          nextBtn.disabled = true;
          nextBtn.classList.remove("is-active");
        }
        return;
      }

      if (emptyMessage) {
        emptyMessage.hidden = true;
      }

      index = Math.max(0, Math.min(index, slides.length - 1));

      slides.forEach(function (card, slideIndex) {
        card.hidden = false;
        card.classList.toggle("is-active", slideIndex === index);
      });

      var activeSlide = slides[index];
      if (track && activeSlide && viewport) {
        var offset = activeSlide.offsetLeft;
        track.style.transform = "translateX(-" + offset + "px)";
      }

      var progress;
      if (slides.length <= 1) {
        progress = 1;
      } else if (isSupport) {
        var trackGap = 160;
        var totalWidth = 0;
        slides.forEach(function (slide, slideIndex) {
          totalWidth += slide.offsetWidth;
          if (slideIndex < slides.length - 1) {
            totalWidth += trackGap;
          }
        });
        var viewedWidth = activeSlide.offsetLeft + activeSlide.offsetWidth;
        if (index < slides.length - 1) {
          viewedWidth += trackGap;
        }
        progress = Math.min(1, viewedWidth / totalWidth);
      } else {
        progress = (index + 1) / slides.length;
      }
      if (progressFill) {
        progressFill.style.width = progress * 100 + "%";
      }

      if (prevBtn) {
        prevBtn.disabled = index <= 0;
        prevBtn.classList.toggle("is-active", index > 0);
      }

      if (nextBtn) {
        nextBtn.disabled = index >= slides.length - 1;
        nextBtn.classList.toggle("is-active", index < slides.length - 1);
      }
    }

    if (prevBtn) {
      prevBtn.addEventListener("click", function () {
        index -= 1;
        update();
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener("click", function () {
        index += 1;
        update();
      });
    }

    slider._teamsGoTo = function (nextIndex) {
      index = nextIndex || 0;
      update();
    };

    slider._teamsRefresh = update;

    window.addEventListener("resize", update);
    update();
  }

  function initSupportTabs() {
    var tabs = document.querySelectorAll(".teams-support-tab");
    var supportSlider = document.querySelector(
      '.teams-slider[data-teams-slider="support"]',
    );

    if (!tabs.length || !supportSlider) {
      return;
    }

    tabs.forEach(function (tab) {
      tab.addEventListener("click", function () {
        var category = tab.getAttribute("data-support-category");

        tabs.forEach(function (item) {
          var isActive = item === tab;
          item.classList.toggle("is-active", isActive);
          item.setAttribute("aria-selected", isActive ? "true" : "false");
        });

        supportSlider.setAttribute("data-active-category", category);
        if (typeof supportSlider._teamsGoTo === "function") {
          supportSlider._teamsGoTo(0);
        }
      });
    });
  }

  function init() {
    if (!document.querySelector(".teams-page-main")) {
      return;
    }

    document.querySelectorAll("[data-teams-slider]").forEach(initTeamsSlider);
    initSupportTabs();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
