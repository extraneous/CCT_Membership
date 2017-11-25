function saveEditedUserDets(){
    var data = $("#editUserDetsFrm" ).serialize();
    var url = 'ajax/editUserDetailsSave.php';
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function(data){
            $('#editUserDetailsModal').modal("hide");
            location.reload();
        }
    });
}

function editMyDetails(){
    var url = 'ajax/editUserDetailsGetInfo.php';
    $.getJSON(url,
        function(data){
            $('#editUserFirstName').val(data.firstname);
            $('#editUserSurname').val(data.surname);
            $('#editUserEmail').val(data.email);
            $('#editUserUsername').val(data.username);
            $('#editUserDetailsModal').modal("show");
        }
    );
}