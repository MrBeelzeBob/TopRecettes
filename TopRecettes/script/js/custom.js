/*
 Auteur      : Cedric Dos Reis
 Sujet       : TopRecettes - TPI 2015
 */
function checkPasswordMatch(password, confirmPassword) {
    /*var password = $("#EditNewPwd").val();
     var confirmPassword = $("#EditNewPwdConfirm").val();*/

    if (password !== confirmPassword) {
        $("#inputPwd").addClass('has-error').removeClass('has-success');
        $("#inputPwdConfirm").addClass('has-error').removeClass('has-success');
        $("#btn-submit").addClass('disabled');
    } else {
        $("#inputPwd").addClass('has-success').removeClass('has-error');
        $("#inputPwdConfirm").addClass('has-success').removeClass('has-error');
        $("#btn-submit").removeClass('disabled');
    }
}


