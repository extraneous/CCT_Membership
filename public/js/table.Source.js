/*
 * Editor client script for DB table Source
 * Created by http://editor.datatables.net/generator
 */

(function($){

$(document).ready(function() {
    $('#databaseMenuItem').addClass('active');
    $('#MembershipAdminItem').addClass('active');
    $('#db-sourceItem').addClass('active');
	var editor = new $.fn.dataTable.Editor( {
		ajax: 'php/table.Source.php',
		table: '#Source',
		fields: [
			{
				"label": "Source_Code:",
				"name": "Source_Code"
			},
			{
				"label": "Location:",
				"name": "Location"
			},
			{
				"label": "Status:",
				"name": "status",
				"type": "select",
				"options": [
					"Live",
					"NotInUse",
					"RarelyUsed"
				]
			}
		]
	} );

	var table = $('#Source').DataTable( {
		dom: 'Bfrtip',
		ajax: 'php/table.Source.php',
		columns: [
			{
				"data": "Source_Code"
			},
			{
				"data": "Location"
			},
			{
				"data": "status"
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

