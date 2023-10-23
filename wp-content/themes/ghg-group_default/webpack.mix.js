// Webpack configuration using Laravel Mix
// This file compiles SCSS and JavaScript files and copies other assets to a 'dist' directory
const mix = require('laravel-mix');
const path = require('path');
// File paths
const dist = path.resolve(__dirname, './dist');
const src = {
	styles: path.resolve(__dirname, 'resources/scss/style.scss'),
	scripts: path.resolve(__dirname, 'resources/js/scripts.js'),
	favicons: path.resolve(__dirname, 'resources/favicons'),
	fonts: path.resolve(__dirname, 'resources/fonts'),
	svg: path.resolve(__dirname, 'resources/svg'),
	image: path.resolve(__dirname, 'resources/images'),
	newsAndEvents: path.resolve(
		__dirname,
		'resources/apps/roots/news-and-events.js'
	),
};

// News and events
mix.js(src.newsAndEvents, `${dist}/js`).sourceMaps().react();
// Compile SCSS files
mix.sass(src.styles, `${dist}/css`).options({
	processCssUrls: false, // Optional, if you want to prevent Laravel Mix from processing urls in your SCSS
});
// Compile JavaScript files
mix.js(src.scripts, `${dist}/js`).sourceMaps();
// Copy font, image, and favicon files
const {fonts, svg, image, favicons} = src;
mix.copy(svg, `${dist}/svg`);
mix.copy(image, `${dist}/img`);
mix.copy(favicons, `${dist}/favicons`);
mix.copy(fonts, `${dist}/fonts`);

