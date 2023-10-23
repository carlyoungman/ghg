import "hammerjs";

class Carousel {
  constructor(container, options) {

    // Defaults
    if (!options) {
      options = {
        autoPlay: false,
        navDots: false,
        navButtons: false,
      };
    }

    // Init options
    this.options = {
      autoPlay: options.autoPlay,
      navButtons: options.navButtons,
      navDots: options.navDots,
    };

    // Fetch the container from DOM
    this.carousel = container;

    if (
      this.carousel &&
      !this.carousel.classList.contains("carousel--active")
    ) {
      // add active class
      this.carousel.classList.add("carousel--active");

      // Select all carousel items within container
      this.slides = this.carousel.querySelectorAll(".carousel__item");

      // Count how many slides exist in container
      this.slideCount = this.slides.length;

      // Initial active slide (will be set on init)
      this.activeSlide = null;

      // Init
      this.init();

      // Set timer
      this.timerInt = this.timer();
    } else {
      return false;
    }
  }

  setCarouselHeight() {
    let slides = this.slides;
    let carousel = this.carousel;

    function sizer() {
      let heights = [];
      slides.forEach((slide) => {
        heights.push(slide.clientHeight);
      });

      let maxHeight = Math.max(...heights);
      carousel.style.minHeight = maxHeight + "px";
    }

    // Run sizer on init, then listen for viewport resizes
    sizer();
    window.addEventListener("resize", sizer);
  }

  // Nav builder
  buildNav(count) {
    let html = "";
    let active = "";

    let parentSection = this.carousel.parentElement.parentElement;

    if (count) {
      html += '<div class="carousel__nav">';

      if (parentSection.classList.contains("carousel--sticky")) {
        html += '<div class="carousel__nav-progress"><span></span></div>';
      }

      html += "<ul>";

      // build nav buttons
      for (let i = 0; i < count; i++) {
        if (i == 0) {
          active = 'class="nav__item item--active"';
        } else {
          active = 'class="nav__item"';
        }

        html += "<li " + active + ' data-index="' + i + '"><span></span></li>';
      }

      html += "</ul></div>";
    }

    this.carousel.insertAdjacentHTML("beforeend", html);
  }

  buildButtons() {
    // try to find existing button wrapper as child or sibling element
    let buttonWrap =
      this.carousel.querySelector(".carousel__buttons") ||
      this.carousel.nextElementSibling;

    if (this.slideCount > 1) {
      let html = "";

      // Open tags
      if (!buttonWrap) {
        html += '<div class="carousel__buttons">';
      }

      html += "<ul>";

      html += '<li class="carousel__button carousel--prev"><span></span></li>';
      html += '<li class="carousel__button carousel--next"><span></span></li>';

      // Close tags
      html += "</ul>";

      if (!buttonWrap) {
        html += "</div>";
      }

      if (!buttonWrap) {
        this.carousel.insertAdjacentHTML("afterend", html);
      } else {
        buttonWrap.insertAdjacentHTML("beforeend", html);
      }
    }
  }

  slideIndexAssignment() {
    if (this.slides && this.slides.length > 0) {
      // Assign the slide items indexes
      this.slides.forEach(function (slide, index) {
        slide.setAttribute("data-index", index);
      });
    }
  }

  setActiveSlide() {
    let activeSlide;

    // Remove current active slides
    this.slides.forEach(function (slide) {
      slide.classList.remove("item--active");
    });

    // If no current active slide, set to first (0)
    if (this.activeSlide == null) {
      activeSlide = this.carousel.querySelector(
        '.carousel__item[data-index="0"]'
      );
    } else {
      activeSlide = this.carousel.querySelector(
        '.carousel__item[data-index="' + this.activeSlide + '"]'
      );
    }

    activeSlide.classList.add("item--active");
  }

  setActiveNav() {
    let activeNav;
    let navItems = this.carousel.querySelectorAll(".nav__item");

    if (navItems.length) {
      // Remove current active nav items
      navItems.forEach(function (slide) {
        slide.classList.remove("item--active");
      });

      activeNav = this.carousel.querySelector(
        '.nav__item[data-index="' + this.activeSlide + '"]'
      );

      activeNav.classList.add("item--active");
    }
  }

  navClick() {
    let navButtons = this.carousel.querySelectorAll(".nav__item");
    let current = this;
    navButtons.forEach(function (navBtn) {
      navBtn.addEventListener("click", function () {
        // Get active slide index from button
        let activeIndex = this.getAttribute("data-index");

        // Set active slide
        current.activeSlide = activeIndex;

        // Update DOM
        current.setActiveSlide();
        current.setActiveNav();
      });
    });
  }

  buttonClick() {
    if (this.options.navButtons) {
      // Get carousel buttons for current slide instance
      let carouselButtons =
        this.carousel.parentNode.querySelectorAll(".carousel__button");
      let current = this;

      carouselButtons.forEach(function (carouselBtn) {
        carouselBtn.addEventListener("click", function () {
          let activeSlide = current.carousel.querySelector(".item--active");
          let activeIndex = activeSlide.getAttribute("data-index");

          if (this.classList.contains("carousel--prev")) {
            current.activeSlide = parseInt(activeIndex) - 1;
          } else if (this.classList.contains("carousel--next")) {
            current.activeSlide = parseInt(activeIndex) + 1;
          }

          if (current.activeSlide > current.slideCount - 1) {
            current.activeSlide = 0;
          } else if (current.activeSlide < 0) {
            current.activeSlide = current.slideCount - 1;
          }

          // Update DOM
          current.setActiveSlide();
          current.setActiveNav();

          // Reset timer
          clearInterval(current.timerInt);
          current.timerInt = current.timer();
        });
      });
    }
  }

  moveSlide(self, index) {
    // Set active slide
    self.activeSlide = index;

    // Update DOM
    self.setActiveSlide();
    self.setActiveNav();
  }

  // Helper to get an elements distance from the top
  offset(el) {
    var rect = el.getBoundingClientRect(),
      scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
      scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    return { top: rect.top + scrollTop, left: rect.left + scrollLeft };
  }

  buildCarouselStage() {
    let parentSection = this.carousel.parentElement.parentElement;

    if (parentSection.classList.contains("carousel--sticky")) {
      let carouselHeight = this.carousel.clientHeight;
      let carouselStage = this.carousel.parentElement;
      let carouselOffset = this.offset(this.carousel).top;
      let carouselContainerOffset = this.offset(
        carouselStage.querySelector(".carousel__container")
      ).top;
      let stageHeight = carouselHeight * (this.slideCount + 0.5);
      let navProgressHeight = carouselHeight * (this.slideCount - 1);
      let carouselNavProgress = this.carousel.querySelector(
        ".carousel__nav-progress span"
      );

      // Set stage height
      carouselStage.style.height = stageHeight + "px";

      // Percentage scroll
      let progress;

      // Sticky triggers
      let self = this;

      function updateProgress(scrollVal) {
        // Use scroll val if passed (for scroll event listeners)
        let currentScroll =
          scrollVal || window.pageYOffset || document.documentElement.scrollTop;

        if (carouselNavProgress) {
          // Update percentage scroll
          progress = currentScroll - carouselContainerOffset;
          progress = (progress / navProgressHeight) * 100;

          // Set limits (not sure if this helps in any way, but I'm a stickler for it)
          progress = progress >= 100 ? 100 : progress <= 0 ? 0 : progress;

          // console.log(progress)

          // Update clip to reveal progress
          carouselNavProgress.style.clipPath =
            "polygon(0 0, 100% 0, 100% " + progress + "%, 0 " + progress + "%)";
        }
      }

      // Run on load (for page refreshes)
      updateProgress();

      // Trigger slide move
      window.addEventListener("scroll", function () {
        let currentScroll =
          window.pageYOffset || document.documentElement.scrollTop;

        updateProgress(currentScroll);

        // loop through the slides to check for scroll distance
        self.slides.forEach((slide, index) => {
          // Our trigger should be the current scroll minus the carousel container's distance from the top of the doc
          // with the product of the slide index and the carousel height then added
          // let trigger = (carouselOffset + window.innerHeight + (carouselHeight * index)) + carouselHeight * 0.5;
          let trigger = carouselOffset + carouselHeight * index;
          // let percentage = currentScroll - carouselOffset;

          // For debugging
          // if(index == 1 ) {
          //     console.log(trigger, currentScroll)
          // }

          // If we've scrolled passed the trigger point for this slide, move to the next
          if (currentScroll > trigger) {
            index = index;
            self.moveSlide(self, index);
          }
        });
      });
    }
  }

  swipe() {
    let hammer = new Hammer(this.carousel);
    let current = this;

    hammer.on("swiperight", function (e) {
      current.activeSlide = current.activeSlide - 1;

      if (current.activeSlide < 0) {
        current.activeSlide = current.slideCount - 1;
      }

      // update
      current.setActiveSlide();
      current.setActiveNav();

      // Reset timer
      clearInterval(current.timerInt);
      current.timerInt = current.timer();
    });

    hammer.on("swipeleft", function (e) {
      current.activeSlide = current.activeSlide + 1;

      if (current.activeSlide > current.slideCount - 1) {
        current.activeSlide = 0;
      }

      // update
      current.setActiveSlide();
      current.setActiveNav();

      // Reset timer
      clearInterval(current.timerInt);
      current.timerInt = current.timer();
    });
  }

  timer() {
    if (this.options.autoPlay) {
      let current = this;

      return setInterval(function () {
        current.activeSlide = current.activeSlide + 1;

        if (current.activeSlide > current.slideCount - 1) {
          current.activeSlide = 0;
        }

        // update
        current.setActiveSlide();
        current.setActiveNav();
      }, this.options.autoPlay);
    }
  }

  init() {
    if (this.options.navDots) {
      // Build nav
      this.buildNav(this.slideCount);
    }

    // Build Buttons
    if (this.options.navButtons) {
      this.buildButtons();
    }

    // Set intial height and listen for resizes
    this.setCarouselHeight();

    // Assign indexes to the slides
    this.slideIndexAssignment();

    // Only for sticky carousel
    this.buildCarouselStage();

    // Set Active Slide (initially)
    this.setActiveSlide();

    // Listen for nav clicks
    this.navClick();

    // Listen for button clicks
    this.buttonClick();

    // Listen for swipes
    this.swipe();
  }
}

export default Carousel;
