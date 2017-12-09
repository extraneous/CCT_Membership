$(document).ready(function() {
    $('#databaseMenuItem').addClass('active');
    $('#databaseSubscriptionsDonationsItem').addClass('active');
    $('#db-accountPostingItem').addClass('active');
});

(function($){

    $(document).ready(function() {
        var editor = new $.fn.dataTable.Editor( {
            ajax: 'php/table.Account_Posting.php',
            table: '#Account_Posting',
            fields: [
                {
                    "label": "Account Posting Ref:",
                    "name": "Account_Posting_Ref"
                },
                {
                    "label": "Description:",
                    "name": "Description"
                },
                {
                    "label": "Budget Code:",
                    "name": "Budget_Code",
                    "type": "select"
                },
                {
                    "label": "Bank Code:",
                    "name": "Bank_Code",
                    "type": "select"
                },
                {
                    "label": "Status:",
                    "name": "Status",
                    "type": "select",
                    "options": [
                        "Open",
                        "Closed",
                        "Posted"
                    ]
                },
                {
                    "label": "Posting Date:",
                    "name": "Tran_Date",
                    "type": "datetime",
                    "format": "Y-m-d"
                },
                {
                    "label": "Tran Number:",
                    "name": "Tran_Number"
                },

            ]
        } );

        // Edit record
        $('#Account_Posting').on('click', 'a.editor_edit', function (e) {
            e.preventDefault();
            editor.edit( $(this).closest('tr'), {
                title: 'Edit Posting',
                buttons: 'Save'
            } );
        } );

        var table = $('#Account_Posting').DataTable( {
            dom: 'Bfrtip',
            ajax: 'php/table.Account_Posting.php',
            columns: [
                {
                    "data": "Account_Posting_Ref"
                },
                {
                    "data": "Description"
                },
                {
                    "data": "Budget_Code"
                },
                {
                    "data": "Bank_Code"
                },
                {
                    "data": "Status"
                },
                {
                    "data": "Tran_Date"
                },
                {
                    "data": "Tran_Number"
                },
                {
                    "data": null,
                    "className": "center",
                    "defaultContent": '<a href="" class="editor_edit">Close</a> <a href="" class="editor_edit">Open</a> <a href="" class="editor_edit">View</a> <a href="" class="editor_edit">Post</a> <a href="" class="editor_edit">Delete</a> '
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
