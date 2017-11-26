(function($){

    $(document).ready(function() {
        $('#databaseMenuItem').addClass('active');
        $('#databaseSubscriptionsDonationsItem').addClass('active');
        $('#db-bankreceiptItem').addClass('active');
        var editor = new $.fn.dataTable.Editor( {
            ajax: 'php/table.bank_receipt.php',
            table: '#bank_receipt',
            fields: [
                {
                    "label": "Receipt Date:",
                    "name": "Receipt_Date",
                    "type": "datetime",
                    "format": "ddd, D MMM YY"
                },
                {
                    "label": "Receipt Batch Id:",
                    "name": "Receipt_Batch_Id"
                },
                {
                    "label": "Receipt Amount:",
                    "name": "Receipt_Amount"
                },
                {
                    "label": "Pay Method:",
                    "name": "Pay_Method",
                    "type": "select",
                    "options": [
                        "Cash",
                        "Cheque",
                        "StandingOrder",
                        "DirectDebit",
                        "Postal Order",
                        "CharitiesAidFoundation"
                    ]
                },
                {
                    "label": "Match Status:",
                    "name": "Match_Status",
                    "type": "select",
                    "def": "Received",
                    "options": [
                        "Received",
                        "MatchedToPerson",
                        "Anonymous"
                    ]
                },
                {
                    "label": "Person Id:",
                    "name": "Person_Id"
                },
                {
                    "label": "Membership Status:",
                    "name": "Membership_Status",
                    "type": "select",
                    "options": [
                        "New",
                        "Renewal",
                        "NonMember",
                        "Renewal-Lapsed",
                        "Upgrade-Life",
                        ""
                    ]
                },
                {
                    "label": "GiftAid Status:",
                    "name": "GiftAid_Status",
                    "type": "select",
                    "options": [
                        "EligibleForGiftAid",
                        "EligibleForGasds",
                        "Claimed",
                        "NotEligible",
                        "Unknown"
                    ]
                },
                {
                    "label": "GiftAid Claim Ref:",
                    "name": "GiftAid_Claim_Ref"
                },
                {
                    "label": "Note:",
                    "name": "Note"
                }
            ]
        } );

        var table = $('#bank_receipt').DataTable( {
            dom: 'Bfrtip',
            ajax: 'php/table.bank_receipt.php',
            columns: [
                {
                    "data": "Receipt_Date"
                },
                {
                    "data": "Receipt_Batch_Id"
                },
                {
                    "data": "Receipt_Amount"
                },
                {
                    "data": "Pay_Method"
                },
                {
                    "data": "Match_Status"
                },
                {
                    "data": "Person_Id"
                },
                {
                    "data": "Membership_Status"
                },
                {
                    "data": "GiftAid_Status"
                },
                {
                    "data": "GiftAid_Claim_Ref"
                },
                {
                    "data": "Note"
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
