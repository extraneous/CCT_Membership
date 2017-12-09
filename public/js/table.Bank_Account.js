
/*
 * Editor client script for DB table Bank_Account
 * Created by http://editor.datatables.net/generator
 */

(function($){

$(document).ready(function() {
	var editor = new $.fn.dataTable.Editor( {
		ajax: 'php/table.Bank_Account.php',
		table: '#Bank_Account',
		fields: [
			{
				"label": "Bank_Code:",
				"name": "bank_code"
			},
			{
				"label": "Description:",
				"name": "description"
			},
			{
				"label": "Nominal_Code:",
				"name": "nominal_code"
			},
			{
				"label": "Sort_Code:",
				"name": "sort_code"
			},
			{
				"label": "Account_Number:",
				"name": "account_number"
			}
		]
	} );

	var table = $('#Bank_Account').DataTable( {
		dom: 'Bfrtip',
		ajax: 'php/table.Bank_Account.php',
		columns: [
			{
				"data": "bank_code"
			},
			{
				"data": "description"
			},
			{
				"data": "nominal_code"
			},
			{
				"data": "sort_code"
			},
			{
				"data": "account_number"
			}
		],
		select: true,
		lengthChange: false,
		buttons: [
			{ extend: 'create', editor: editor },
			{ extend: 'edit',   editor: editor },
			{ extend: 'remove', editor: editor }
		]
	} );
} );

}(jQuery));

