
/*
 * Editor client script for DB table person
 * Created by http://editor.datatables.net/generator
 */

(function($){

$(document).ready(function() {
    $('#databaseMenuItem').addClass('active');
    $('#db-personItem').addClass('active');
	var editor = new $.fn.dataTable.Editor( {
		ajax: 'php/table.person.php',
		table: '#person',
		fields: [
			{ 
				"label": "Title",
				"name": "person.Title" 
			},
			{
				"label": "First Name",
				"name": "person.First_Name"
			},
			{
				"label": "Last Name",
				"name": "person.Last_Name"
			},
			{
				"label": "Tel No 1",
				"name": "person.Tel_No_1"
			},
			{
				"label": "Tel No 2",
				"name": "person.Tel_No_2"
			},
			{
				"label": "Email",
				"name": "person.Email"
			},
			{ 
				"label": "GiftAid",
				"name": "person.GiftAid",
				"type": "select",
				"options": [
					" ",
					"Y",
					"N"
					]
			},
			{
				"label": "GiftAid Date",
				"name": "person.GiftAid_Date",
				"type": "date"
			},

			{	"label": "Organisation",
				"name": "address.Organisation"
			},
			{
				"label": "Number Or Name",
				"name": "address.Number_Or_Name"
			},
			{
				"label": "Address Line 1",
				"name": "address.Address_Line_1"
			},
			{
				"label": "Address Line 2",
				"name": "address.Address_Line_2"
			},
			{
				"label": "Post Town",
				"name": "address.Post_Town"
			},
			{
				"label": "County",
				"name": "address.County"
			},
			{
				"label": "Post Code",
				"name": "address.Post_Code"
			},
			{
				"label": "Country",
				"name": "address.Country"
			},
			{
				"label": "Status",
				"name": "address.Status"
			},
			{
				"label": "Date Changed",
				"name": "address.Date_Changed",
				"type": "date"
			},

			{
				"label": "Mem No",
				"name": "membership.Mem_No"
			},
			{
				"label": "Organisation Name",
				"name": "membership.Organisation_Name"
			},
			{
				"label": "Apply Date",
				"name": "membership.Apply_Date",
				"type": "date"  },
			{
				"label": "Start Date",
				"name": "membership.Start_Date",
				"type": "date"  },
			{
				"label": "Source",
				"name": "membership.Source","type": "select" },
			{
				"label": "Mem Type Code",
				"name": "membership.Mem_Type_Code",
				"type": "select" },
			{
				"label": "Comments",
				"name": "membership.Comments" },
			{
				"label": "Lapsed",
				"name": "membership.Lapsed",
				"type": "select",
				"options": [
					" ",
					"N",
					"Y"
					]
			},
			{
				"label": "Lapsed Date",
				"name": "membership.Lapsed_Date"
			},
			{
				"label": "Status",
				"name": "membership.Status",
				"type": "select",
				"options": [
					" ",
					"AwaitingApproval",
					"Live",
					"Lapsed"
					]
			}
		]
	} );

	// Edit Person record
	$('#person').on('click', 'button.editor_edit', function (e) {
		e.preventDefault();
		editor.edit( $(this).closest('tr'), {
			title: 'Edit Person',
			buttons: 'Save'
		} );
	} );

	var table = $('#person').DataTable( {
		order: [[2,"asc"]],
		ajax: 'php/table.person.php',
		columns: [
//			{ data: null, render: function ( data, type, row ) {
//				// Combine the title, first & last names into a single table field
//				return data.Title+' '+data.First_Name+' '+data.Last_Name;
//			} },
			{
				"data": "person.Title"
			},
			{
				"data": "person.First_Name"
			},
			{
				"data": "person.Last_Name"
			},
			{
				"data": "address.Address_Line_1"
			},
			{
				"data": "address.Post_Code"
			},
			{
				"data": "membership.Mem_No"
			},
			{
				"data": "membership.Mem_Type_Code"
			},
			{
				"data": "membership.Lapsed"
			},
			{
				"data": "membership.Comments"
			},
			{
				"data": null,
				"className": "center",
				"defaultContent": '<button type="button" class="btn btn-default btn-sm editor_edit"><i class="fa fa-pencil"></i> Edit</button>'
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

