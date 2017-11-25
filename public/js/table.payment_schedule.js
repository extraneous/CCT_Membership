
/*
 * Editor client script for DB table payment_schedule
 * Created by http://editor.datatables.net/generator
 */

(function($){

$(document).ready(function() {
    $('#databaseMenuItem').addClass('active');
    $('#db-paymentSchedule').addClass('active');
	var editor = new $.fn.dataTable.Editor( {
		ajax: 'php/table.payment_schedule.php',
		table: '#payment_schedule',
		fields: [
			{
				"label": "Appeal Code:",
				"name": "appeal_code",
				"type": "select"
			},
			{
				"label": "Mem No:",
				"name": "mem_no"
			},
			{
				"label": "Person Id:",
				"name": "person_id"
			},
			{
				"label": "Bank Code:",
				"name": "bank_code",
				"type": "select"
			},
			{
				"label": "Start Date:",
				"name": "start_date",
				"type": "datetime",
			},
			{
				"label": "Frequency:",
				"name": "frequency",
				"type": "select",
				"options": [
					"Once",
					"Annual",
					" Monthly"
				]
			},
			{
				"label": "Amount:",
				"name": "amount"
			},
			{
				"label": "Last Date:",
				"name": "last_received_date"
			},
			{
				"label": "Last Amount:",
				"name": "last_received_amount"
			},
			{
				"label": "Memo:",
				"name": "memo"
			}
		]
	} );

	// Edit record
	$('#payment_schedule').on('click', 'a.editor_edit', function (e) {
		e.preventDefault();
		editor.edit( $(this).closest('tr'), {
			title: 'Edit record',
			buttons: 'Update'
		} );
	} );

	var table = $('#payment_schedule').DataTable( {
		dom: 'Bpfrti',
		ajax: 'php/table.payment_schedule.php',
		columns: [
			{
				"data": "appeal_code"
			},
			{
				"data": "mem_no"
			},
			{
				"data": "person_id"
			},
			{
				"data": "bank_code"
			},
			{
				"data": "start_date"
			},
			{
				"data": "frequency"
			},
			{
				"data": "amount"
			},
			{
				"data": "last_received_date"
			},
			{
				"data": "last_received_amount"
			},
			{
				"data": "memo"
			},
			{
				"data": null,
				"className": "center",
				"defaultContent": '<a href="" class="editor_edit">Edit</a>'
			}
		],
		select: true,
		pagingType: "simple",
		pageLength: 1,
		lengthChange: false,
		buttons: [
			{ extend: 'create', editor: editor },
			{ extend: 'edit',   editor: editor },
			{ extend: 'remove', editor: editor }
		]
	} );
} );

}(jQuery));
