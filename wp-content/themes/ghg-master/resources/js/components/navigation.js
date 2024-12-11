/**
 * File navigation.js.
 */

export default function navigation() {
	const body = document.querySelector('body');
	//This function is responsible for displaying the mobile menu when the hamburger is clicked
	const showMobileMenu = () => {
		const hamburger = document.querySelector('button.hamburger');
		if (
			hamburger instanceof window.HTMLElement &&
			body instanceof window.HTMLElement
		) {
			hamburger.addEventListener('click', () => {
				hamburger.classList.toggle('is-active');
				body.classList.toggle('navigation-active');
			});
		}
	};
	showMobileMenu();

	// Used to detect when the header is sticky so that additional styling can be applied.
	const sticky = () => {
		const header = document.querySelector('header.header');
		if (header instanceof window.HTMLElement) {
			window.addEventListener('scroll', () => {
				if (window.scrollY > 0) {
					header.classList.add('header--scrolling');
				} else {
					header.classList.remove('header--scrolling');
				}
			});
		}
	};

	sticky();

	// This function is responsible for the back to the top functionality
	const scrollBackToTop = () => {
		const $icon = document.querySelector('nav.back-to-top');
		if ($icon instanceof window.HTMLElement) {
			$icon.addEventListener('click', function () {
				window.scrollTo({ top: 0, behavior: 'smooth' });
			});
		}
	};
	scrollBackToTop();
	// Used to detect when the header is sticky so that additional styling can be applied.

	const smoothScroll = () => {
		const main = document.querySelector('main.site-main');
		if (main instanceof window.HTMLElement) {
			main.querySelectorAll('a[href^="#"]').forEach((anchor) => {
				anchor.addEventListener('click', function (e) {
					e.preventDefault();

					document
						.querySelector(this.getAttribute('href'))
						.scrollIntoView({
							behavior: 'smooth',
						});
				});
			});
		}
	};
	smoothScroll();

	/**
	 * Opens the active link in the mobile header menu.
	 **/
	const openActiveLink = () => {
		document
			.querySelectorAll('.header__mobile li.menu-item-has-children')
			.forEach((menuItem) => {
				menuItem.addEventListener('click', function (e) {
					this.classList.toggle('menu-item-has-children--open');
				});
			});
	};

	openActiveLink();
}
