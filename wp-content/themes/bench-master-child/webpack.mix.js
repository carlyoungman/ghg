// Webpack configuration using Laravel Mix
// This file compiles SCSS and JavaScript files and copies other assets to a 'dist' directory
const mix = require('laravel-mix');
const path = require('path');
// File paths
const dist = path.resolve(__dirname, './dist');
const src = {
	styles: path.resolve(__dirname, 'resources/scss/style.scss'),
	favicons: path.resolve(__dirname, 'resources/favicons'),
	fonts: path.resolve(__dirname, 'resources/fonts'),
	image: path.resolve(__dirname, 'resources/images'),
	scripts: path.resolve(__dirname, 'resources/js/scripts.js'),
};

// Compile SCSS files
mix.sass(src.styles, `${dist}/css`).options({
	processCssUrls: false, // Optional, if you want to prevent Laravel Mix from processing urls in your SCSS
});
// Compile JavaScript files
mix.js(src.scripts, `${dist}/js`).sourceMaps();

// Copy font, image, and favicon files
const { fonts, image, favicons } = src;
mix.copy(image, `${dist}/img`);
mix.copy(favicons, `${dist}/favicons`);
mix.copy(fonts, `${dist}/fonts`);
