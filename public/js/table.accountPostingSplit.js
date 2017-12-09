(function($){

    $(document).ready(function() {
        $('#databaseMenuItem').addClass('active');
        $('#databaseSubscriptionsDonationsItem').addClass('active');
        $('#db-accountPostingSplitItem').addClass('active');
        var editor = new $.fn.dataTable.Editor( {
            ajax: 'php/table.account_posting_split.php',
            table: '#account_posting_split',
            fields: [
                {
                    "label": "Account Posting Id:",
                    "name": "Account_Posting_Id"
                },
                {
                    "label": "Account Posting Split Id:",
                    "name": "Account_Posting_Split_Id"
                },
                {
                    "label": "Amount:",
                    "name": "Amount"
                },
                {
                    "label": "Person Receipt Split Id:",
                    "name": "Person_Receipt_Split_Id"
                },
                {
                    "label": "Details:",
                    "name": "Details"
                }
            ]
        } );

        var table = $('#account_posting_split').DataTable( {
            dom: 'Bfrtip',
            ajax: 'php/table.account_posting_split.php',
            columns: [
                {
                    "data": "Account_Posting_Id"
                },
                {
                    "data": "Account_Posting_Split_Id"
                },
                {
                    "data": "Amount"
                },
                {
                    "data": "Person_Receipt_Split_Id"
                },
                {
                    "data": "Details"
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