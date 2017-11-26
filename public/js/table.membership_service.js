
/*
 * Editor client script for DB table membership_service
 * Created by http://editor.datatables.net/generator
 */

(function($){

$(document).ready(function() {
    $('#databaseMenuItem').addClass('active');
    $('#MembershipAdminItem').addClass('active');
    $('#db-membershipServiceItem').addClass('active');
	var editor = new $.fn.dataTable.Editor( {
		ajax: 'php/table.membership_service.php',
		table: '#membership_service',
		fields: [
			{
				"label": "Mem_No:",
				"name": "Mem_No"
			},
			{
				"label": "Service Code:",
				"name": "Service_Code"
			},
			{
				"label": "Start Date:",
				"name": "Start_Date",
				"type": "datetime",
				"format": "ddd, D MMM YY"
			},
			{
				"label": "End_Date:",
				"name": "End_Date",
				"type": "datetime",
				"format": "ddd, D MMM YY"
			},
			{
				"label": "Status:",
				"name": "status",
				"type": "select",
				"options": [
					"NotStarted",
					"Live",
					"Suspended",
					"Ended"
				]
			}
		]
	} );

	var table = $('#membership_service').DataTable( {
		dom: 'Bfrtip',
		ajax: 'php/table.membership_service.php',
		columns: [
			{
				"data": "Mem_No"
			},
			{
				"data": "Service_Code"
			},
			{
				"data": "Start_Date"
			},
			{
				"data": "End_Date"
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

