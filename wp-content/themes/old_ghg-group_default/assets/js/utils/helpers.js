import smoothscroll from 'smoothscroll-polyfill';
import Swiper, { Navigation } from 'swiper';
import gsap from 'gsap';
Swiper.use([Navigation]);

export const initSliders = () => {
	let sliders = document.querySelectorAll('.slider__container');

	// Create slider instances
	sliders.forEach((slider) => {
		let isMobileSlider = slider.classList.contains('slider--mob')
			? true
			: false;

		let nav = {
			nextEl: '.slider__button.slider--next',
			prevEl: '.slider__button.slider--prev',
		};

		if (slider.classList.contains('slider--hide-nav')) {
			nav = false;
		}

		// Init slider
		const swiper = new Swiper(slider, {
			preloadImages: true,
			touchRatio: 0.5,
			freeMode: true,
			init: false,
			navigation: nav,
			// observer: true,
			// observeParents: true,
			slidesPerView: 'auto',
		});

		if (isMobileSlider && window.innerWidth <= 991) {
			swiper.init();
			// console.log('mobile')
		} else if (!isMobileSlider) {
			swiper.init();
			// console.log('not mobile')
		}
	});
};

export const linkScroll = () => {
	if (document.querySelector('.link--scroll')) {
		document
			.querySelector('.link--scroll')
			.addEventListener('click', function (e) {
				e.preventDefault();

				let scrollDist;
				let parent = this.closest('section');
				let currentScroll = window.scrollY;

				// if a parent section is found, scroll by the height of it
				// else scroll by the height of the viewport window
				if (parent) {
					scrollDist = parent.offsetHeight - currentScroll;
				} else {
					scrollDist = window.outerHeight - currentScroll;
				}

				// Support for all browsers
				smoothscroll.polyfill();

				// Perform scroll from current position
				window.scrollBy({
					top: scrollDist,
					behavior: 'smooth',
				});
			});
	}
};

// Find distance of element from viewport edges
function offset(el) {
	var rect = el.getBoundingClientRect(),
		scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
		scrollTop = window.pageYOffset || document.documentElement.scrollTop;
	return {
		element: el,
		top: rect.top + scrollTop,
		left: rect.left + scrollLeft,
	};
}

export const animate = () => {
	// Get all elements with an animation trigger
	let sections = document.querySelectorAll('[data-anim]');

	// General animation trigger loop
	function scrollEvents() {
		// Get current scroll distance
		let currentScroll = window.scrollY;

		sections.forEach((item) => {
			let itemDist = item.offsetTop;
			let trigger = itemDist - window.innerHeight * 0.66;
			let triggerEnd = itemDist + item.clientHeight;

			// Change trigger value for footer section
			if (item.nodeName == 'FOOTER') {
				let footerHeight = item.clientHeight;
				// Animation to trigger when user has scrolled half way through footer
				trigger =
					document.querySelector('main#wrapper').clientHeight -
					(window.innerHeight - footerHeight / 2);
				if (currentScroll >= trigger) {
					item.setAttribute('data-anim', true);
				}
			} else {
				if (currentScroll >= trigger && currentScroll < triggerEnd) {
					item.setAttribute('data-anim', true);
				}
			}
		});
	}

	// Trigger elements in view on load
	scrollEvents();

	// Listen for elements coming in to view
	window.addEventListener('scroll', function () {
		scrollEvents();
	});
	// Adjust on window resize
	window.addEventListener('resize', function () {
		scrollEvents();
	});
};

export const mobileMenu = () => {
	function toggleMobileMenu(event) {
		event.preventDefault();
		let active = document.body.classList.contains('mobile--active');
		if (active) {
			document.body.classList.add('mobile--closing');
			setTimeout(function () {
				document.body.classList.remove('mobile--active');
				document.body.classList.remove('mobile--closing');
			}, 500);
		} else {
			document.body.classList.add('mobile--active');
		}
	}

	let mobileToggle = document.querySelector('.mobile__toggle');
	if (mobileToggle) {
		mobileToggle.addEventListener('click', toggleMobileMenu);
	}
};

export const formValidation = () => {
	let form = document.querySelector('form.form--validation');

	if (form) {
		let errors = [];
		let inputs = form.querySelectorAll('[required]');

		form.onsubmit = function () {
			// Empty error array
			errors = [];
			inputs.forEach((input) => {
				input.classList.remove('field--error');
				if (!input.value) {
					errors.push(input);
					input.classList.add('field--error');
				}
			});

			// Halt submission if errors exist
			if (errors.length > 0) {
				event.preventDefault();
			}
		};
	}
};

export const header = () => {
	function headerActive() {
		let currentScroll = window.scrollY;
		let header = document.querySelector('header#main');
		let body = document.body;

		// Add active class on scroll
		if (currentScroll >= header.clientHeight) {
			body.classList.add('header--active');
		} else {
			body.classList.remove('header--active');
		}
	}

	addEventListener('scroll', headerActive);
};

export const credit = () => {
	console.log(
		'%c  Built by Yeah Right | https://yeahright.co  ',
		'background-color:#000f7c; color: #9ad5ff; font-size:10px; padding:8px 4px; border-radius:6px;'
	);
};

export const initTickers = () => {

	let tickers = document.querySelectorAll('.ticker');

	tickers.forEach((ticker) => {
		let speed = ticker.getAttribute('data-speed') || 50;

		let entries =
			ticker.querySelectorAll('span').length > 0
				? ticker.querySelectorAll('span')
				: false;

		if (entries) {
			

			let tickerInnerWrap = ticker.querySelector('.ticker__inner-wrap');
			let tickerInner = ticker.querySelector('.ticker__inner');
			let tickerInnerWidth = tickerInner.getBoundingClientRect().width;

			var loopDuration = tickerInnerWidth / speed;

			gsap.set(tickerInnerWrap, {
				x: 0,
			});

			gsap.to(tickerInnerWrap, {
				duration: loopDuration,
				x: -tickerInnerWidth,
				force3D: true,
				ease: 'linear',
				repeat: -1,
			});
		}
	});
};
