
/*
 * Editor client script for DB table person_receipt
 * Created by http://editor.datatables.net/generator
 */

(function($){

$(document).ready(function() {
    $('#databaseMenuItem').addClass('active');
    $('#databaseSubscriptionsDonationsItem').addClass('active');
    $('#db-personreceiptItem').addClass('active');
	var editor = new $.fn.dataTable.Editor( {
		ajax: 'php/table.person_receipt.php',
		table: '#person_receipt',
		fields: [
			{
				"label": "Date:",
				"name": "date",
				"type": "datetime",
				"format": "Y-m-d"
			},
			{
				"label": "Person Id:",
				"name": "person_id"
			},
			{
				"label": "Mem No:",
				"name": "mem_no"
			},
			{
				"label": "Amount:",
				"name": "amount"
			}
		]
	} );

	var table = $('#person_receipt').DataTable( {
		dom: 'Bfrtip',
		ajax: 'php/table.person_receipt.php',
		columns: [
			{
				"data": "date"
			},
			{
				"data": "person_id"
			},
			{
				"data": "mem_no"
			},
			{
				"data": "amount"
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

