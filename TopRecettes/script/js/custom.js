

function create_select_ingredient(NbIngredients) {
    var input = document.getElementsByTagName("input");   // Get the first <h1> element in the document
    var list = document.createAttribute("list");       // Create a "class" attribute
    list.value = "EditListIngredient";                           // Set the value of the class attribute
    input.setAttributeNode(list);                          // Add the class attribute to <h1>
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


