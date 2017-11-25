$( document ).ready(function() {

});

function subit(){
    var email       = $('#inputEmail').val();
    var password    = $('#inputPassword').val();
    var tfa         = $('#google2fa').val();
    if(email == ''){
        bootbox.alert("You have not entered your email address",function(){
            $('#inputEmail').focus();
            return false;
        })
    }
    if(password == ''){
        bootbox.alert("You have not entered your password",function(){
            $('#inputPassword').focus();
            return false;
        })
    }
    if(tfa == ''){
        bootbox.alert("YOu have not entered your Google Tow Factor Authentication Code",function(){
            $('#google2fa').focus();
            return false;
        })
    }
    return true;
}