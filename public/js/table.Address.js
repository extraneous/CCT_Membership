
/*
 * Editor client script for DB table address
 * Created by http://editor.datatables.net/generator
 */

(function($){

$(document).ready(function() {
	$('#databaseMenuItem').addClass('active');
	$('#db-addressItem').addClass('active');
	var editor = new $.fn.dataTable.Editor( {
		ajax: 'php/table.address.php',
		table: '#address',
		fields: [
			{
				"label": "Organisation:",
				"name": "address.organisation"
			},
			{
				"label": "Number or Name:",
				"name": "address.number_or_name"
			},
			{
				"label": "Address_Line_1:",
				"name": "address.address_line_1"
			},
			{
				"label": "Address_Line_2:",
				"name": "address.address_line_2"
			},
			{
				"label": "Post_Town:",
				"name": "address.post_town"
			},
			{
				"label": "County:",
				"name": "address.county"
			},
			{
				"label": "Postcode:",
				"name": "address.post_code"
			},
			{
				"label": "Status:",
				"name": "status",
				"type": "select",
				"options": [
					"Live",
					" Mail undelivered",
					" Do not mail",
					" Deceased"
				]
			},
			{
				"label": "Date Changed:",
				"name": "date_changed"
			}
		]
	} );

	var table = $('#address').DataTable( {
		ajax: 'php/table.address.php',
		columns: [
			{
				"data": "address.organisation"
			},
			{
				"data": "address.number_or_name"
			},
			{
				"data": "address.address_line_1"
			},
			{
				"data": "address.address_line_2"
			},
			{
				"data": "address.post_town"
			},
			{
				"data": "address.county"
			},
			{
				"data": "address.post_code"
			},
			{
				"data": "address.status"
			},
			{
				"data": "address.date_changed"
			}
		],
		select: true,
		lengthChange: false
	} );

    new $.fn.dataTable.Buttons( table, [
        { extend: "create", editor: editor },
        { extend: "edit",   editor: editor },
        { extend: "remove", editor: editor }
    ] );

    table.buttons().container()
        .appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
} );

}(jQuery));

