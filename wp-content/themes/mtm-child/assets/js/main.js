import {
	linkScroll,
	animate,
	mobileMenu,
	formValidation,
	header,
	credit,
	initTickers,
	initSliders,
	checklistWidth,
	initMap,
} from './utils/helpers';

// Load classes
require('./components/map');
require('./components/carousel');

// Load event helpers on DOM load
window.addEventListener('load', () => {
	linkScroll();
	initSliders();
	// animate();
	mobileMenu();
	initTickers();
	checklistWidth();
	header();
	initMap();
	credit();
});
