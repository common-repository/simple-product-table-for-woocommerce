(function ($) {
	'use strict';
	$(function () {
		$('.sptable_quantity').on("change", function () {
			var product_qty = $(this).val();
			var product_id = $(this).prop('placeholder');
			var add_cart = $('.sptable-add-to-cart-'+product_id);
			add_cart.attr('data-quantity', product_qty);
		});
		$('.sptable-add-to-cart').on("click", function (e) {
			e.preventDefault();
			$(this).addClass('loading');
			let product_id = $(this).attr('data-product_id');
			let product_qty = $(this).attr('data-quantity');
			$.ajax({
				url: sptable_public_vars.sptables_ajaxurl,
				type: "POST",
				data: {
					'action': 'sptable_add_product_to_cart',
					'product_id': product_id,
					'product_qty': product_qty,
				},
				success: function () {
					$('.sptable-add-to-cart').removeClass('loading');
					jQuery(document.body).trigger('wc_fragment_refresh');
				}
			});
		});

		var table = $('#sptable_datatable').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"responsive": false,
			language: { search: '', searchPlaceholder: "Search" },
		});
	})

})(jQuery);
