(function() {

	/////////////////////////////////////////////////////////////////
	/////                     On Page Load                      /////
	/////////////////////////////////////////////////////////////////

	// Navigate to tab and possibly a specific quote on page load
	var url = document.location.toString();

	if (url.match('#')) {
		var hash = url.split('#')[1];
		var tab = hash.split('/')[0] ? hash.split('/')[0] : null;
		var subpanel = hash.split('/')[1] ? hash.split('/')[1] : null;
	
		$('.nav-tabs a[href=#'+tab+']').tab('show');

		if (subpanel !== null) {
			$('#'+subpanel).addClass('active');
			$('#'+tab+' a[data-toggle="subpanel"]').hide();
		}
	}

	setTimeout(function() {
		window.scrollTo(0,0);
	}, 0);

	/////////////////////////////////////////////////////////////////
	/////               Quote Links on Jobs View                /////
	/////////////////////////////////////////////////////////////////

	// Hide subpanel toggle links and show subpanel detail
	$('a[data-toggle="subpanel"]').on('click', function(e) {
		e.preventDefault();
		var target = '#'+this.href.split('#')[1];
		$(target).addClass('active');
		$(this).closest('.tab-pane a[data-toggle="subpanel"]').hide();
		window.location.hash = window.location.hash + '/' + target.substr(1);
	});

	// Show subpanel toggle links and close subpanel detail
	$('a[data-close="subpanel"]').on('click', function(e) {
		e.preventDefault();
		$(this).closest('.tab-pane').removeClass('active');
		var targetPane = $(this).data('target-pane-id');
		$('#' + targetPane + ' a[data-toggle="subpanel"]').show();
		window.location.hash = window.location.hash.split('/')[0];
		window.scrollTo(0,0);
	});

	/////////////////////////////////////////////////////////////////
	/////                   Tabs on Jobs View                   /////
	/////////////////////////////////////////////////////////////////
	
	$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
		window.location.hash = e.target.hash;
		window.scrollTo(0,0);

		if (e.target.hash == '#quotes') {
			var visibleQuote = $('.tab-pane.active[data-subpanel-id]').attr('id');

			if (visibleQuote) {
				window.location.hash = window.location.hash + '/' + visibleQuote;
			}
		}
	});

})();