_.templateSettings.variable = "rc";
$(function(){
    $('#adminMenuItem').addClass('active');
    $('#memberAdminMenuItem').addClass('active');
    $('#pagination').bootpag({
        total: $('#pageCount').val(),
        maxVisible: 10,
        leaps: true,
        firstLastUse: true,
        first: '←',
        last: '→'
    }).on("page", function(event, num){
        var url = '/search/membershipPaging.php';
        var number = $('#searchMemNo').val();
        var name = $('#searchMemName').val();
        var town = $('#searchMemTown').val();
        $.getJSON(url,{num:num,number:number,name:name,town:town},
            function(data){
                var template = _.template(
                    $('#resultTemplate').html()
                );
                $('#resultTable').html(template(data));
            }
        );
    });
    $('#searchMemNo').bootcomplete({
        url:'/search/autoCompleteMemNo.php',
        minLength:2
    });
    $('#searchMemName').bootcomplete({
        url:'/search/autoCompleteMemberName.php',
        minLength:3
    });
    $('#searchMemTown').bootcomplete({
        url:'/search/autoCompleteMemberTown.php',
        minLength:3
    });
});

function search(){
    var MemNo = $('#searchMemNo').val();
    var name = $('#searchMemName').val();
    var town = $('#searchMemTown').val();

    if((MemNo == '') && (name == '') && (town == '')){
        bootbox.alert("You have not entered any search criteria");
        return;
    }
    var url = 'search/searchMembership.php';
    $.getJSON(url,{MemNo:MemNo,name:name,town:town},
        function(data){
            var template = _.template(
                $('#resultTemplate').html()
            );
            $('#resultTable').html(template(data));
            $('#pagination').bootpag({total: data.pages});
        }
    )
}

function searchReset(){
    $('#searchFrm').trigger('reset');
    var url = 'search/searchMembership.php';
    $.getJSON(url,{MemNo:'',name:'',town:''},
        function(data){
            var template = _.template(
                $('#resultTemplate').html()
            );
            $('#resultTable').html(template(data));
            $('#pagination').bootpag({total: data.pages});
        }
    )
}
function editMember(mid){
    document.location = 'editMembership.php?mid=' + mid;
}