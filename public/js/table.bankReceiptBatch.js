
/*
 * Editor client script for DB table bank_receipt_batch
 * Created by http://editor.datatables.net/generator
 */

(function($){

$(document).ready(function() {
    $('#databaseMenuItem').addClass('active');
    $('#databaseSubscriptionsDonationsItem').addClass('active');
    $('#db-bankreceiptBatchItem').addClass('active');
	var editor = new $.fn.dataTable.Editor( {
		ajax: 'php/table.bank_receipt_batch.php',
		table: '#bank_receipt_batch',
		fields: [
			{
				"label": "Bank Code:",
				"name": "Bank_Code"
			},
			{
				"label": "Paying In Amount:",
				"name": "Paying_In_Amount"
			},
			{
				"label": "Paying In Reference:",
				"name": "Paying_In_Reference"
			},
			{
				"label": "Bank Statement Date:",
				"name": "Bank_Statement_Date",
				"type": "datetime",
				"format": "ddd, D MMM YY"
			},
			{
				"label": "Bank Statement Line:",
				"name": "Bank_Statement_Line"
			},
			{
				"label": "Bank Statement Amount:",
				"name": "Bank_Statement_Amount"
			},
			{
				"label": "Receipt Type:",
				"name": "Receipt_Type",
				"type": "select",
				"options": [
					"Unknown",
					"Single",
					"Multiple",
					"Other"
				]
			}
		]
	} );

	var table = $('#bank_receipt_batch').DataTable( {
		dom: 'Bfrtip',
		ajax: 'php/table.bank_receipt_batch.php',
		columns: [
			{
				"data": "Bank_Code"
			},
			{
				"data": "Paying_In_Amount"
			},
			{
				"data": "Paying_In_Reference"
			},
			{
				"data": "Bank_Statement_Date"
			},
			{
				"data": "Bank_Statement_Line"
			},
			{
				"data": "Bank_Statement_Amount"
			},
			{
				"data": "Receipt_Type"
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

