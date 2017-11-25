_.templateSettings.variable = "rc";
$(function(){
    $('#adminMenuItem').addClass('active');
    $('#userAdminMenuItem').addClass('active');
    $('.checkbox-inline').checkboxpicker();
    $('#addAppend').checkboxpicker();
    $('#editAppend').checkboxpicker();
    $('#emailLoginDets').checkboxpicker();
    $('#summerNoteEditor').summernote({
        height:200
    });
});

function addUser(){
    $('#addStudio').val($('#studioSel').val());
    $('#addFirstName').val('');
    $('#addSurname').val('');
    $('#addEmail').val('');
    $('#addPassword').val('');
    $('#addEnabled').prop('checked',true);
    $('.addPermission').prop('checked',false);
    $('a[href="#addDetails"]').trigger('click');
    $('#addUserModal').modal("show");
}
function resetLogins(userId){
    var url = '/ajax/resetFailedUserLogin.php';
    $.post(url,{userId:userId},
        function(data){
            location.reload();
        }
    )
}
function saveNewUser(){
    var firstName   = $('#addFirstName').val();
    var surname     = $('#addSurname').val();
    var email       = $('#addEmail').val();
    var password    = $('#addPassword').val();
    if($('#addEnabled').is(':checked')){
        var enabled = 1;
    } else {
        var enabled = 0;
    }
    var params = $('.addPermission:checked');
    if(firstName == ''){
        alert("You have not entered a first name!?");
        $('a[href="#addDetails"]').trigger('click');
        $('#addFirstName').focus();
        return
    }
    if(surname == ''){
        alert("You have not entered a surname!?");
        $('a[href="#addDetails"]').trigger('click');
        $('#addSurname').focus();
        return
    }
    if(enabled == 1){
        if(password == ''){
            alert("You have not entered a password!?");
            $('a[href="#addDetails"]').trigger('click');
            $('#addPassword').focus();
            return;
        }
        if(password.length < 6){
            alert("Entered Password is too short (minimum of 6 characters)");
            $('a[href="#addDetails"]').trigger('click');
            $('#addPassword').focus();
            return;
        }
    }
    var permStr = '';
    $(params).each(function(i,item){
        if(permStr != ''){
            permStr += ',';
        }
        permStr += $(this).val()
    });
    var url = '/ajax/saveNewUser.php';
    $.post(url,{firstName:firstName,surname:surname,email:email,
                password:password, enabled:enabled,permStr:permStr},
        function(data){
            $('#addUserModal').modal("hide");
            location.reload();
        }
    )
}
function editUser(userId){
    var url = '/ajax/getUserDetailsForEditing.php';
    $.getJSON(url,{userId:userId},
        function(data){
            $('#editUserId').val(userId);
            $('#editFirstName').val(data.firstname);
            $('#editSurname').val(data.surname);
            $('#editEmail').val(data.email);
            if(data.status == 1){
                $('#editEnabled').prop('checked',true);
            } else {
                $('#editEnabled').prop('checked',false);
            }
            $('.editPermission').prop('checked',false);
            $(data.permissions).each(function(i,item){
                var target = '.editPermission[value=' + item + ']';
                $(target).prop('checked',true);
            });
            $('a[href="#editDetails"]').trigger('click');
            $('#editUserModal').modal("show");
        }
    )
}
function saveEditUser(){
    var userId      = $('#editUserId').val();
    var firstname   = $('#editFirstName').val();
    var surname     = $('#editSurname').val();
    var email       = $('#editEmail').val();
    var password    = $('editPassword').val();
    if($('#editEnabled').is(':checked')){
        var status = 1;
    } else {
        var status = 0;
    }
    var params = $('.editPermission:checked');
    if(firstname == ''){
        alert("You have not entered a first name!?");
        $('a[href="#editDetails"]').trigger('click');
        $('#editFirstName').focus();
        return
    }
    if(surname == ''){
        alert("You have not entered a surname!?");
        $('a[href="#editDetails"]').trigger('click');
        $('#editSurname').focus();
        return
    }

    var permStr = '';
    $(params).each(function(i,item){
        if(permStr != ''){
            permStr += ',';
        }
        permStr += $(this).val()
    });
    var url = '/ajax/saveEditedUser.php';
    $.post(url,{userId:userId,firstname:firstname,surname:surname,email:email,
                password:password,status:status,
                permStr:permStr},
        function(data){
            $('#editUserModal').modal("hide");
            location.reload();
        }
    )
}

function resetGoogle2fa(userId){
    bootbox.confirm("Are you sure you want to reset this users 2FA Code?", function(result) {
        if(result == true){
            var url = '/ajax/resetUser2Fa.php';
            $.post(url,{userId:userId},
                function(data){
                    if(data.result = 'good') {
                        bootbox.alert("The 2FA Code has been updated for " + data.name)
                    } else {
                        bootbox.alert("An Error occurred!? Code not changed.")
                    }
                },'json'
            )
        }
    });
}
function emailUser(userId){
    $('#emailUserId').val(userId);
    $('#emailSubject').val('');
    $('#summernote').summernote('code', '');
    $('#emailLoginDets').prop('checked',false);
    $('#sendEmailModal').modal('show');
}
function sendEmailToUser(){
    var subject = $('#emailSubject').val();
    var bodyText = $('#summerNoteEditor').summernote('code');
    var userId = $('#emailUserId').val();
    if($('#emailLoginDets').is(':checked')){
        var sendLogin = '1';
    } else {
        var sendLogin = 0;
    }
    var url = '/ajax/sendEmailToUser.php';
    $.post(url,{userId:userId,subject:subject,bodyText:bodyText,sendLogin:sendLogin},
        function(data){
            bootbox.alert('Email Sent')
        }
    );
    $('#sendEmailModal').modal('hide');
}