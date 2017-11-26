
/*
 * Editor client script for DB table person
 * Created by http://editor.datatables.net/generator
 */

(function($){

$(document).ready(function() {
    $('#databaseMenuItem').addClass('active');
    $('#MembershipAdminItem').addClass('active');
    $('#db-personMembershipItem').addClass('active');
	var editor = new $.fn.dataTable.Editor( {
		ajax: 'php/table.Person-Membership.php',
		table: '#person',
		fields: [
			{
				"label": "Mem No:",
				"name": "membership.Mem_No",
				"type": "readonly"
			},
			{
				"label": "Title:",
				"name": "person.Title"
			},
			{
				"label": "First Name:",
				"name": "person.First_Name"
			},
			{
				"label": "Last Name:",
				"name": "person.Last_Name"
			},
			{
				"label": "Address Line 1",
				"name": "address.Address_Line_1"
			},
			{
				"label": "Post Code",
				"name": "address.Post_Code"
			},
			{
				"label": "Mem Type Code",
				"name": "membership.Mem_Type_Code",
				"type": "select"

			},
			{
				"label": "Lapsed",
				"name":"membership.Lapsed",
				"type": "select",
				"options": ["N","Y"]
			},
			{
				"label": "Comments",
				"name": "membership.Comments"
			}
		]
	} );

	// Edit record
	$('#person').on('click', 'button.editor_edit', function (e) {
		e.preventDefault();
		editor.edit( $(this).closest('tr'), {
			title: 'Edit record',
			buttons: 'Update'
		} );
	} );

	var table = $('#person').DataTable( {
		dom: 'Bfrtip',
		ajax: 'php/table.Person-Membership.php',
		columns: [
			{
				"data": "membership.Mem_No"
			},
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
		lengthChange: false,
		buttons: [
//			{ extend: 'create', editor: editor },
			{ extend: 'edit',   editor: editor },
			{ extend: 'remove', editor: editor }
		]
	} );
} );

}(jQuery));

