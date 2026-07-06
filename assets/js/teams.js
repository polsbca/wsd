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
          prevBtn.classList.add("is-disabled");
          prevBtn.setAttribute("aria-disabled", "true");
          prevBtn.classList.remove("is-active");
        }
        if (nextBtn) {
          nextBtn.classList.add("is-disabled");
          nextBtn.setAttribute("aria-disabled", "true");
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
    var featureMediaImg = modalEl.querySelector(
      ".teams-doctor-feature-media-img",
    );
    var navLinks = Array.prototype.slice.call(
      modalEl.querySelectorAll(".teams-doctor-modal-link"),
    );

    function setActiveNav(link) {
      navLinks.forEach(function (item) {
        item.classList.toggle("is-active", item === link);
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
      }
      if (roleEl) {
        roleEl.textContent = doctor.role || "";
      }
      if (qualificationsEl) {
        qualificationsEl.textContent = doctor.qualifications || "";
        qualificationsEl.hidden = !doctor.qualifications;
      }

      if (aboutNameEl) {
        aboutNameEl.textContent = (doctor.name || "") + "\u2019s";
      }

      if (featureMediaImg) {
        featureMediaImg.src = doctor.image || "";
        featureMediaImg.alt = "";
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
