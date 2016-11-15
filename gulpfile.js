var elixir = require('laravel-elixir');

elixir(function(mix) {

    // Compile less files down to resources/assets/css/app.css.
    mix.less('app.less', 'resources/assets/css');

    // Mix css files in resources/assets/css down to public/all.css.
    mix.styles([
        'app.css',
    	'vendor/magnific-popup/magnific-popup.css'
    ]);

    // Mix js files in resources/js down to public/js/all.js
    mix.scripts([
    	'vendor/magnific-popup/jquery.magnific-popup.min.js',
    	'vendor/jssor/jssor.slider.mini.js',
    	'slider.js',
    	'datatables.js',
    	'tabs.js',
        'magnific-gallery.js',
        'quote-total.js',
        'form-helpers.js'
    ]);
});
