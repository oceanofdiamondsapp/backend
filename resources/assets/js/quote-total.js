(function() {

	/////////////////////////////////////////////////////////////////////////////
	// Calculate the total cost based on the piece, shipping and tax amounts. //
	/////////////////////////////////////////////////////////////////////////////

	$('*[data-target-model=total]').on('input paste change', function() {
		var total = 0;
		var taxes = [1, 1.07, 1];
		var selectedTax = taxes[$('select[name=tax_id]').val() || 0 ];

		$('input[data-target-model=total]').each(function(idx, ele) {
			total += Number($(ele).val());
		});

		total = (total * selectedTax).toFixed(2);

		$('*[data-model=total]').html('$'+total);
	});

})();

function onQuoteCancel() {
	$('*[data-model=total]').html('$0.00');
}