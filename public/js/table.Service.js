
/*
 * Editor client script for DB table Service
 * Created by http://editor.datatables.net/generator
 */

(function($){

$(document).ready(function() {
	var editor = new $.fn.dataTable.Editor( {
		ajax: 'php/table.Service.php',
		table: '#Service',
		fields: [
			{
				"label": "Service Code:",
				"name": "Service_Code"
			},
			{
				"label": "Description:",
				"name": "Description"
			}
		]
	} );

	var table = $('#Service').DataTable( {
		dom: 'Bfrtip',
		ajax: 'php/table.Service.php',
		columns: [
			{
				"data": "Service_Code"
			},
			{
				"data": "Description"
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

