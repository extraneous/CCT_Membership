
/*
 * Editor client script for DB table membership
 * Created by http://editor.datatables.net/generator
 */

(function($){

$(document).ready(function() {
    $('#databaseMenuItem').addClass('active');
    $('#MembershipAdminItem').addClass('active');
    $('#db-membershipItem').addClass('active');
	var editor = new $.fn.dataTable.Editor( {
		ajax: 'php/table.membership.php',
		table: '#membership',
		fields: [
			{
				"label": "Mem No:",
				"name": "membership.mem_no"
			},
			{
				"label": "Organisation Name:",
				"name": "membership.organisation_name"
			},
			{
				"label": "Entered Date:",
				"name": "membership.entered_date",
				"type": "datetime",
				"format": "Y-m-d"
			},
			{
				"label": "Apply Date:",
				"name": "membership.apply_date",
				"type": "datetime",
				"format": "Y-m-d"
			},
			{
				"label": "Start Date:",
				"name": "membership.start_date",
				"type": "datetime",
				"format": "Y-m-d"
			},
			{
				"label": "Mem Type Code:",
				"name": "membership.mem_type_code",
			},
			{
				"label": "Comments:",
				"name": "membership.comments"
			},
			{
				"label": "Lapsed:",
				"name": "membership.lapsed",
				"type": "select",
				"options": [
					"Y",
					"N"
				]
			},
			{
				"label": "Lapsed Date:",
				"name": "membership.lapsed_date",
				"type": "datetime",
				"format": "Y-m-d"
			}
		]
	} );

	var table = $('#membership').DataTable( {
		dom: 'Bfrtip',
		ajax: 'php/table.membership.php',
		columns: [
			{
				"data": "membership.mem_no"
			},
			{
				"data": "membership.organisation_name"
			},
			{
				"data": "membership.entered_date"
			},
			{
				"data": "membership.apply_date"
			},
			{
				"data": "membership.start_date"
			},
			{
				"data": "membership.mem_type_code"
			},
			{
				"data": "membership.comments"
			},
			{
				"data": "membership.lapsed"
			},
			{
				"data": "membership.lapsed_date"
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

