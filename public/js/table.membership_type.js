
/*
 * Editor client script for DB table membership_type
 * Created by http://editor.datatables.net/generator
 */

(function($){

$(document).ready(function() {
    $('#databaseMenuItem').addClass('active');
    $('#MembershipAdminItem').addClass('active');
    $('#db-membershipTypeItem').addClass('active');
	var editor = new $.fn.dataTable.Editor( {
		ajax: 'php/table.membership_type.php',
		table: '#membership_type',
		fields: [
			{
				"label": "Membership Type Code:",
				"name": "mem_type_code",
				"type": "readonly"
			},
			{
				"label": "Subscription Amount:",
				"name": "amount"
			},
			{
				"label": "Frequency:",
				"name": "frequency",
				"type": "select",
				"options": [
					"",
					"Annual",
					"Life",
					"Monthly"
				]
			},
			{
				"label": "From Date:",
				"name": "from_date",
				"type": "date",
				"format": "Y-m-d"
			},
			{
				"label": "To Date:",
				"name": "to_date",
				"type": "date",
				"format": "Y-m-d"
			},
			{
				"label": "Count:",
				"name": "count",
				
			}		]
	} );

	// Edit record
	$('#membership_type').on('click', 'button.editor_edit', function (e) {
		e.preventDefault();
		editor.edit( $(this).closest('tr'), {
			title: 'Edit record',
			buttons: 'Update'
		} );
	} );

	var table = $('#membership_type').DataTable( {
		dom: 'Bfrtip',
		ajax: 'php/table.membership_type.php',
		columns: [
			{
				"data": "mem_type_code"
			},
			{
				"data": "amount"
			},
			{
				"data": "frequency"
			},
			{
				"data": "from_date"
			},
			{
				"data": "to_date"
			},
			{
				"data": "count"
			},
			{
				"data": null,
				"className": "center",
				"defaultContent": '<button type="button" class="btn btn-default btn-sm editor_edit"><i class="fa fa-pencil"></i> Edit</button>'
			}
		],
		select: true,
		lengthChange: false,
		paging: false,
		buttons: [
			{ extend: 'create', editor: editor },
			{ extend: 'edit',   editor: editor },
			{ extend: 'remove', editor: editor }
		]
	} );
} );

}(jQuery));

