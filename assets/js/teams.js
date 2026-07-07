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
    var dotsContainer = slider.querySelector(".teams-slider-dots");
    var emptyMessage = slider.querySelector(".teams-support-empty");
    var isSupport = slider.getAttribute("data-teams-slider") === "support";
    var index = 0;
    var supportDotCount = -1;
    var swipeStartX = 0;
    var swipeStartY = 0;
    var swipeActive = false;
    var swipeLocked = false;
    var swipeIsHorizontal = false;

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

    function syncDots(slides) {
      if (!dotsContainer) {
        return;
      }

      if (isSupport) {
        if (!slides.length || slides.length <= 1) {
          dotsContainer.hidden = true;
          dotsContainer.innerHTML = "";
          supportDotCount = slides.length;
          return;
        }

        dotsContainer.hidden = false;

        if (slides.length !== supportDotCount) {
          dotsContainer.innerHTML = "";
          slides.forEach(function (unusedSlide, slideIndex) {
            var dotBtn = document.createElement("button");
            dotBtn.type = "button";
            dotBtn.className = "teams-slider-dot";
            dotBtn.setAttribute("data-slide-dot", String(slideIndex));
            dotBtn.setAttribute(
              "aria-label",
              "Go to support team member " + (slideIndex + 1),
            );
            dotsContainer.appendChild(dotBtn);
          });
          supportDotCount = slides.length;
        }
      }

      Array.prototype.forEach.call(
        dotsContainer.querySelectorAll(".teams-slider-dot[data-slide-dot]"),
        function (dotBtn) {
          var dotIndex = parseInt(dotBtn.getAttribute("data-slide-dot") || "0", 10);
          dotBtn.classList.toggle("is-active", dotIndex === index);
        },
      );
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
          prevBtn.classList.add("is-disabled");
          prevBtn.setAttribute("aria-disabled", "true");
          prevBtn.classList.remove("is-active");
        }
        if (nextBtn) {
          nextBtn.classList.add("is-disabled");
          nextBtn.setAttribute("aria-disabled", "true");
          nextBtn.classList.remove("is-active");
        }
        syncDots([]);
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

        if (window.matchMedia("(max-width: 991.98px)").matches) {
          viewport.style.height = activeSlide.offsetHeight + "px";
        } else {
          viewport.style.height = "";
        }
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
        var canGoPrev = index > 0;
        prevBtn.classList.toggle("is-disabled", !canGoPrev);
        prevBtn.setAttribute("aria-disabled", canGoPrev ? "false" : "true");
        prevBtn.classList.remove("is-active");
      }

      if (nextBtn) {
        var canGoNext = index < slides.length - 1;
        nextBtn.classList.toggle("is-disabled", !canGoNext);
        nextBtn.setAttribute("aria-disabled", canGoNext ? "false" : "true");
        nextBtn.classList.toggle("is-active", canGoNext);
      }

      syncDots(slides);
    }

    if (prevBtn) {
      prevBtn.addEventListener("click", function () {
        if (prevBtn.classList.contains("is-disabled")) {
          return;
        }
        index -= 1;
        update();
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener("click", function () {
        if (nextBtn.classList.contains("is-disabled")) {
          return;
        }
        index += 1;
        update();
      });
    }

    if (dotsContainer) {
      dotsContainer.addEventListener("click", function (event) {
        var dotBtn = event.target.closest(".teams-slider-dot[data-slide-dot]");
        if (!dotBtn) {
          return;
        }

        index = parseInt(dotBtn.getAttribute("data-slide-dot") || "0", 10);
        update();
      });
    }

    if (viewport) {
      viewport.addEventListener(
        "touchstart",
        function (e) {
          if (!e.touches || !e.touches.length) {
            return;
          }
          swipeStartX = e.touches[0].clientX;
          swipeStartY = e.touches[0].clientY;
          swipeActive = true;
          swipeLocked = false;
          swipeIsHorizontal = false;
        },
        { passive: true },
      );

      viewport.addEventListener(
        "touchmove",
        function (e) {
          if (!swipeActive || !e.touches || !e.touches.length) {
            return;
          }
          var dx = e.touches[0].clientX - swipeStartX;
          var dy = e.touches[0].clientY - swipeStartY;

          if (!swipeLocked && (Math.abs(dx) > 10 || Math.abs(dy) > 10)) {
            swipeLocked = true;
            swipeIsHorizontal = Math.abs(dx) > Math.abs(dy);
          }

          if (swipeLocked && swipeIsHorizontal) {
            e.preventDefault();
          }
        },
        { passive: false },
      );

      viewport.addEventListener(
        "touchend",
        function (e) {
          if (!swipeActive) {
            return;
          }
          swipeActive = false;

          var touch =
            e.changedTouches && e.changedTouches.length ? e.changedTouches[0] : null;
          if (!touch) {
            return;
          }

          var slides = getSlides();
          if (slides.length <= 1) {
            return;
          }

          var dx = touch.clientX - swipeStartX;
          var threshold = 50;

          if (dx > threshold) {
            index = Math.max(0, index - 1);
            update();
          } else if (dx < -threshold) {
            index = Math.min(slides.length - 1, index + 1);
            update();
          }
        },
        { passive: true },
      );
    }

    slider._teamsGoTo = function (nextIndex) {
      index = nextIndex || 0;
      if (isSupport) {
        supportDotCount = -1;
      }
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
    var select = document.querySelector(".teams-support-select");

    if ((!tabs.length && !select) || !supportSlider) {
      return;
    }

    function setCategory(category) {
      if (!category) {
        return;
      }

      tabs.forEach(function (item) {
        var isActive = item.getAttribute("data-support-category") === category;
        item.classList.toggle("is-active", isActive);
        item.setAttribute("aria-selected", isActive ? "true" : "false");
      });

      if (select) {
        select.value = category;
      }

      supportSlider.setAttribute("data-active-category", category);
      if (typeof supportSlider._teamsGoTo === "function") {
        supportSlider._teamsGoTo(0);
      }
    }

    tabs.forEach(function (tab) {
      tab.addEventListener("click", function () {
        var category = tab.getAttribute("data-support-category");
        setCategory(category);
      });
    });

    if (select) {
      select.addEventListener("change", function () {
        setCategory(select.value);
      });
    }
  }

  function initDoctorResultsSlider(slider) {
    if (!slider) {
      return;
    }

    var viewport = slider.querySelector(".teams-doctor-results-viewport");
    var track = slider.querySelector(".teams-doctor-results-track");
    var progressFill = slider.querySelector(".teams-doctor-results-progress-fill");
    var prevBtn = slider.querySelector(".teams-slider-nav-btn--prev");
    var nextBtn = slider.querySelector(".teams-slider-nav-btn--next");
    var index = 0;
    var gap = 30;

    function getSlides() {
      return Array.prototype.slice.call(
        slider.querySelectorAll(".teams-doctor-result-card"),
      );
    }

    function getMaxIndex() {
      var slides = getSlides();
      if (!viewport || !slides.length) {
        return 0;
      }

      var viewportWidth = viewport.clientWidth;
      var slideWidth = slides[0].offsetWidth;
      if (!slideWidth) {
        return Math.max(0, slides.length - 1);
      }

      var visibleCount = Math.max(
        1,
        Math.floor((viewportWidth + gap) / (slideWidth + gap)),
      );
      return Math.max(0, slides.length - visibleCount);
    }

    function update() {
      var slides = getSlides();
      if (!slides.length) {
        return;
      }

      var maxIndex = getMaxIndex();
      index = Math.max(0, Math.min(index, maxIndex));
      var activeSlide = slides[index];

      if (track && activeSlide) {
        track.style.transform = "translateX(-" + activeSlide.offsetLeft + "px)";
      }

      var trackWidth = track ? track.scrollWidth : 0;
      var viewedEnd =
        activeSlide && viewport
          ? activeSlide.offsetLeft + viewport.clientWidth
          : 0;
      var progress = trackWidth > 0 ? Math.min(1, viewedEnd / trackWidth) : 1;

      if (progressFill) {
        progressFill.style.width = progress * 100 + "%";
      }

      if (prevBtn) {
        var canGoPrev = index > 0;
        prevBtn.classList.toggle("is-disabled", !canGoPrev);
        prevBtn.setAttribute("aria-disabled", canGoPrev ? "false" : "true");
        prevBtn.classList.remove("is-active");
      }

      if (nextBtn) {
        var canGoNext = index < maxIndex;
        nextBtn.classList.toggle("is-disabled", !canGoNext);
        nextBtn.setAttribute("aria-disabled", canGoNext ? "false" : "true");
        nextBtn.classList.toggle("is-active", canGoNext);
      }
    }

    if (prevBtn) {
      prevBtn.addEventListener("click", function () {
        if (prevBtn.classList.contains("is-disabled")) {
          return;
        }
        index -= 1;
        update();
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener("click", function () {
        if (nextBtn.classList.contains("is-disabled")) {
          return;
        }
        index += 1;
        update();
      });
    }

    slider._teamsResultsGoTo = function (nextIndex) {
      index = nextIndex || 0;
      update();
    };

    slider._teamsResultsRefresh = update;
    window.addEventListener("resize", update);
    update();
  }

  function initDoctorModal() {
    var modalEl = document.getElementById("teamsDoctorModal");
    if (!modalEl || typeof window.bootstrap === "undefined") {
      return;
    }

    var bodyEl = modalEl.querySelector(".teams-doctor-modal-body");
    var photoImg = modalEl.querySelector(".teams-doctor-photo-img");
    var prefixEl = modalEl.querySelector(".teams-doctor-prefix");
    var nameEl = modalEl.querySelector(".teams-doctor-fullname");
    var gdcEl = modalEl.querySelector(".teams-doctor-gdc");
    var roleEl = modalEl.querySelector(".teams-doctor-role");
    var qualificationsEl = modalEl.querySelector(".teams-doctor-qualifications");
    var aboutNameEl = modalEl.querySelector(".teams-doctor-about-name");
    var aboutTextEl = modalEl.querySelector(".teams-doctor-about-text");
    var journeyTextEl = modalEl.querySelector(".teams-doctor-journey-text");
    var focusCards = Array.prototype.slice.call(
      modalEl.querySelectorAll("[data-doctor-focus-card]"),
    );
    var featureMediaImg = modalEl.querySelector(
      ".teams-doctor-feature-media-img",
    );
    var featureMediaSection = modalEl.querySelector("#teamsDoctorFeatureMedia");
    var navLinks = Array.prototype.slice.call(
      modalEl.querySelectorAll(".teams-doctor-modal-link"),
    );

    function setActiveNav(link) {
      navLinks.forEach(function (item) {
        item.classList.toggle("is-active", item === link);
      });
    }

    function fillFocusCards(cards) {
      focusCards.forEach(function (cardEl, cardIndex) {
        var cardData = cards && cards[cardIndex] ? cards[cardIndex] : null;
        var titleEl = cardEl.querySelector(".teams-doctor-focus-card-title");
        var descEl = cardEl.querySelector(".teams-doctor-focus-card-desc");
        var levelEl = cardEl.querySelector(".teams-doctor-focus-card-level");
        var fillEl = cardEl.querySelector(".teams-doctor-focus-meter-fill");

        if (!cardData) {
          cardEl.hidden = true;
          return;
        }

        cardEl.hidden = false;

        if (titleEl) {
          titleEl.textContent = cardData.title || "";
        }
        if (descEl) {
          descEl.textContent = cardData.content || "";
        }
        if (levelEl) {
          levelEl.textContent = cardData.experience || "";
        }
        if (fillEl) {
          fillEl.style.width = (cardData.meter_percent || 37) + "%";
        }
      });
    }

    function fillModal(doctor) {
      if (!doctor) {
        return;
      }

      if (photoImg) {
        photoImg.src = doctor.image || "";
        photoImg.alt = (doctor.prefix ? doctor.prefix + " " : "") + (doctor.name || "");
      }
      if (prefixEl) {
        prefixEl.textContent = doctor.prefix || "";
      }
      if (nameEl) {
        nameEl.textContent = doctor.name || "";
      }
      if (gdcEl) {
        gdcEl.textContent = doctor.gdc ? "GDC Number: " + doctor.gdc : "";
        gdcEl.hidden = !doctor.gdc;
      }
      if (roleEl) {
        roleEl.textContent = doctor.role || "";
        roleEl.hidden = !doctor.role;
      }
      if (qualificationsEl) {
        qualificationsEl.textContent = doctor.qualifications || "";
        qualificationsEl.hidden = !doctor.qualifications;
      }

      if (aboutNameEl) {
        aboutNameEl.textContent = (doctor.name || "") + "\u2019s";
      }

      if (aboutTextEl) {
        aboutTextEl.innerHTML = doctor.trusted_expertise_html || "";
        aboutTextEl.hidden = !doctor.trusted_expertise_html;
      }

      if (journeyTextEl) {
        journeyTextEl.innerHTML = doctor.journey_html || "";
        journeyTextEl.hidden = !doctor.journey_html;
      }

      fillFocusCards(doctor.clinical_focus_cards || []);

      var featureImage = doctor.feature_image || doctor.image || "";
      if (featureMediaImg) {
        featureMediaImg.src = featureImage;
        featureMediaImg.alt = "";
      }
      if (featureMediaSection) {
        featureMediaSection.hidden = !featureImage;
      }
    }

    modalEl.addEventListener("show.bs.modal", function (event) {
      var trigger = event.relatedTarget;
      var index =
        trigger && trigger.getAttribute
          ? parseInt(trigger.getAttribute("data-doctor-index"), 10)
          : 0;
      var doctors = window.wsdTeamsDoctors || [];
      fillModal(doctors[index] || doctors[0]);

      if (bodyEl) {
        bodyEl.scrollTop = 0;
      }
      if (navLinks.length) {
        setActiveNav(navLinks[0]);
      }

      modalEl.querySelectorAll("[data-teams-results-slider]").forEach(function (resultsSlider) {
        if (typeof resultsSlider._teamsResultsGoTo === "function") {
          resultsSlider._teamsResultsGoTo(0);
        } else if (typeof resultsSlider._teamsResultsRefresh === "function") {
          resultsSlider._teamsResultsRefresh();
        }
      });
    });

    navLinks.forEach(function (link) {
      link.addEventListener("click", function (e) {
        var href = link.getAttribute("href");
        if (!href || href.charAt(0) !== "#") {
          return;
        }

        var target = modalEl.querySelector(href);
        if (!target || !bodyEl) {
          return;
        }

        e.preventDefault();
        setActiveNav(link);

        bodyEl.scrollTo({
          top: target.offsetTop,
          behavior: "smooth",
        });
      });
    });
  }

  function init() {
    if (!document.querySelector(".teams-page-main")) {
      return;
    }

    document.querySelectorAll("[data-teams-slider]").forEach(initTeamsSlider);
    document
      .querySelectorAll("[data-teams-results-slider]")
      .forEach(initDoctorResultsSlider);
    initSupportTabs();
    initDoctorModal();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
