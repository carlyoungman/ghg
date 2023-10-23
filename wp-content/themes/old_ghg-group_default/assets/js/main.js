import {linkScroll, animate, mobileMenu, formValidation, header, credit, initTickers} from './utils/helpers'

// Load classes
require('./components/carousel');
require('./components/map');

// Load event helpers on DOM load
window.addEventListener('load', () => {
  linkScroll();
  animate();
  mobileMenu();
  initTickers();
  formValidation();
  header();
  credit();
});