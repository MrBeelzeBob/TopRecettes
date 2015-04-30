

//Affiche le formulaire pour modifier le mot passe d'utilisateur
function Show_form_edit_pwd() {
    javascript:document.getElementById('form_edit_pwd').style.display = 'block';

}

//Masque le formulaire pour modifier le mot passe d'utilisateur
function Hide_form_edit_pwd() {
    javascript:document.getElementById('form_edit_pwd').style.display = 'none';

}

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


