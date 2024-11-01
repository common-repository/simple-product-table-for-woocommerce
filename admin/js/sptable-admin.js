(function ($) {
	'use strict';

	jQuery(function ($) {
		$(".add-row").on('click', function () {
			let trLast = $("#stptable-form-table tbody tr:last");
			let lastTrKey = trLast.data('key');
			if (isNaN(lastTrKey)) {
				lastTrKey = 0;
			} else {
				lastTrKey = lastTrKey + 1;
			}
			let markup = createContent(lastTrKey);

			$("#stptable-form-table tbody").append(markup);
		});

		// Find and remove selected table rows
		$(".delete-row").click(function () {
			$("table tbody").find('input[class="spt_table_record"]').each(function () {
				if ($(this).is(":checked")) {
					$(this).parents("tr").remove();
				}
			});
		});

		$(".spt_table_all_ckbx").change(function() {
			if ($(this).is(":checked")) {
				$('input[class="spt_table_record"]').prop('checked', true);
			} else {
				$('input[class="spt_table_record"]').prop('checked', false);
			}
		});

		$('#sptable_select_prod_list').select2({
			minimumResultsForSearch: 2,
		});

		function createContent(indexNum) {
			let cellsData = sptable_vars.sptables_cells_data;
			let cellsOptions = generateSelectOption(cellsData);

			let content = '<tr data-key="' + indexNum + '"><td><input type="checkbox" class="spt_table_record" name="spt_table_config[table_data][' + indexNum + '][checkbox]"/></td>' +
				'<td><input class="td_full_input" type="text" name="spt_table_config[table_data][' + indexNum + '][columns]"/></td>' +
				'<td><input class="td_full_input" type="text" name="spt_table_config[table_data][' + indexNum + '][heading]"/></td>' +
				'<td><select id="sptable_select_cells_' + indexNum + '" class="td_full_input" name="spt_table_config[table_data][' + indexNum + '][cells]" required>' + cellsOptions + '</select></td></tr>';
			return content;
		}

		function generateSelectOption(selectChoices) {
			let selectOptions = '';
			for (const key in selectChoices) {
				if (Object.hasOwnProperty.call(selectChoices, key)) {
					const choices = selectChoices[key];
					selectOptions += '<option value="' + key + '">' + choices + '</option>';
				}
			}
			return selectOptions;
		}
	});

})(jQuery);
