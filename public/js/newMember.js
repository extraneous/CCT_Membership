/**
 * Created by mark on 22/10/2016.
 */
_.templateSettings.variable = "rc";
$(function(){
   $('#donation').numeric({
       allowMinus: false,
       allowPlus: false,
       allowThouSep: false,
       allowLeadingSpaces : false,
       maxDecimalPlaces: 2
   })
});

function memTypeChange(){
    var memType = $('#memType').val();
    switch(memType){
        case '-1':
            $('#secondPersonDiv').fadeOut();
            $('#orgdiv').fadeOut();
            break;
        case 'family':
            $('#orgdiv').fadeOut();
            $('#secondPersonDiv').fadeIn();
            break;
        case 'adult':
            $('#secondPersonDiv').fadeOut();
            $('#orgdiv').fadeOut();
            break;
        case 'life':
            $('#secondPersonDiv').fadeOut();
            $('#orgdiv').fadeOut();
            break;
        case 'joint':
            $('#orgdiv').fadeOut();
            $('#secondPersonDiv').fadeIn();
            break;
        case 'seniorlife':
            $('#secondPersonDiv').fadeOut();
            $('#orgdiv').fadeOut();
            break;
        case 'seniorjoint':
            $('#orgdiv').fadeOut();
            $('#secondPersonDiv').fadeIn();
            break;
        case 'corporate':
            $('#orgdiv').fadeIn();
            $('#secondPersonDiv').fadeIn();
            break;
    }
}
function isValidPostcode(p) {
    var postcodeRegEx = /[A-Z]{1,2}[0-9]{1,2} ?[0-9][A-Z]{2}/i;
    var postcodeRegEx = /^([A-PR-UWYZ0-9][A-HK-Y0-9][AEHMNPRTVXY0-9]?[ABEHMNPRVWXY0-9]? {0,2}[0-9][ABD-HJLN-UW-Z]{2}|GIR ?0AA)$/i;
    return postcodeRegEx.test(p);
}
function formatPostcode(p) {
    if (isValidPostcode(p)) {
        var postcodeRegEx = /(^[A-Z]{1,2}[0-9]{1,2})([0-9][A-Z]{2}$)/i;
        return p.replace(postcodeRegEx,"$1 $2");
    } else {
        return p;
    }
}

function postcodeLookUp(){
    $('#postcode').val(formatPostcode($('#postcode').val().toUpperCase()));
    var postcode = $('#postcode').val();
    postcode = postcode.trim();
    if(postcode == ''){
        bootbox.alert("You have not entered a postcode");
        return
    }
    if(!isValidPostcode(postcode)){
        bootbox.alert("The postcode entered is incorrrect. Format = xxn(n) nxx");
    }
    var url = '/ajax/doPostcodeSearch.php';
    $.getJSON(url,{postcode:postcode},
        function(data){
            var template = _.template(
                $('#addresstemplate').html()
            );
            $('#searchResult').html(
                template(data)
            );
            $('#postcodeModal').modal("show");
        }
    )
}
function useAddress(add1,add2,add3){
    $('#address1').val(add1);
    $('#address2').val(add2);
    $('#address3').val(add3);
    $('#postcodeModal').modal("hide");
}