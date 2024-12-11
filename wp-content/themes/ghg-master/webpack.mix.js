// Webpack configuration using Laravel Mix
// This file compiles SCSS and JavaScript files and copies other assets to a 'dist' directory
const mix = require('laravel-mix');
const path = require('path');
// File paths
const dist = path.resolve(__dirname, './dist');
const src = {
	styles: path.resolve(__dirname, 'resources/scss/style.scss'),
	adminStyles: path.resolve(__dirname, 'resources/scss/admin.scss'),
	scripts: path.resolve(__dirname, 'resources/js/scripts.js'),
	fonts: path.resolve(__dirname, 'resources/fonts'),
	svg: path.resolve(__dirname, 'resources/svg'),
	image: path.resolve(__dirname, 'resources/images'),
	newsAndEvents: path.resolve(
		__dirname,
		'resources/apps/roots/news-and-events.js'
	),
	caseStudies: path.resolve(
		__dirname,
		'resources/apps/roots/case-studies.js'
	),
	productCat: path.resolve(
		__dirname,
		'resources/apps/roots/product-categories.js'
	),
	products: path.resolve(__dirname, 'resources/apps/roots/products.js'),
	taxProducts: path.resolve(
		__dirname,
		'resources/apps/roots/tax-products.js'
	),
	singleProductToggle: path.resolve(
		__dirname,
		'resources/apps/roots/single-product-toggle.js'
	),
	sectors: path.resolve(__dirname, 'resources/apps/roots/sectors.js'),
	productInnovation: path.resolve(
		__dirname,
		'resources/apps/roots/product-innovation.js'
	),
	series: path.resolve(__dirname, 'resources/apps/roots/series.js'),
	AUT_products: path.resolve(
		__dirname,
		'resources/apps/roots/AUT-products.js'
	),
	seriesCat: path.resolve(
		__dirname,
		'resources/apps/roots/series-categories.js'
	),
};

mix.js(src.newsAndEvents, `${dist}/js`).sourceMaps().react();
mix.js(src.caseStudies, `${dist}/js`).sourceMaps().react();
mix.js(src.productCat, `${dist}/js`).sourceMaps().react();
mix.js(src.products, `${dist}/js`).sourceMaps().react();
mix.js(src.taxProducts, `${dist}/js`).sourceMaps().react();
mix.js(src.singleProductToggle, `${dist}/js`).sourceMaps().react();
mix.js(src.sectors, `${dist}/js`).sourceMaps().react();
mix.js(src.productInnovation, `${dist}/js`).sourceMaps().react();
mix.js(src.series, `${dist}/js`).sourceMaps().react();
mix.js(src.AUT_products, `${dist}/js`).sourceMaps().react();
mix.js(src.seriesCat, `${dist}/js`).sourceMaps().react();

// Compile SCSS files
mix.sass(src.styles, `${dist}/css`).options({
	processCssUrls: false,
});
// Compile Admin SCSS files
mix.sass(src.adminStyles, `${dist}/css`).options({
	processCssUrls: false,
});

// Compile JavaScript files
mix.js(src.scripts, `${dist}/js`).sourceMaps();
// Copy font, image, and favicon files
const { fonts, svg, image } = src;
mix.copy(svg, `${dist}/svg`);
mix.copy(image, `${dist}/img`);
mix.copy(fonts, `${dist}/fonts`);
