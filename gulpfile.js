var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    
	// Backend
    mix.styles([
	    'bootstrap.min.css',
	    'ladda-themeless.min.css',
	    'animate.css',
	    'styles.css',
	    'icomoon.css',
	], 'public/css/backend/all.css');

	mix.scripts([
		'jquery-1.11.3.min.js',
		'bootstrap.min.js',
		'jquery.dataTables.min.js',
		'fnReloadAjax.js',
		'spin.js',
		'ladda.js',
		'chart.min.js',
		'main.js'
	], 'public/js/backend/all.js');


	// Main website
	mix.styles([
	    'bootstrap.min.css',
	    'magnific-popup.css',
	    'jquery.fancybox.css',
	    'animate.css',
	    'icomoon.css',
	    'ladda-themeless.min.css',
	    'css-stars.css',
	    'main.css'
	]);

    // Concat js
	mix.scripts([
		'jquery-1.11.3.min.js',
		'bootstrap.min.js',
		'jquery.fancybox.js',
		'jquery.validate.js',
		'jquery.magnific-popup.min.js',
		'spin.js',
		'ladda.js',
		'modernizr.js',
		'jquery.barrating.min.js',
		'main.js'
	]);
	
});