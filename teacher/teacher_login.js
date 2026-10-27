
const INPUT_ID = document.getElementById("admin_id");
const INPUT_PASS = document.getElementById("admin_pwd");


function ClearInputs() {
    INPUT_USER.value = "";
    INPUT_PASS.value = "";
}

function RemoveWrong() {
    TEXT_WRONG = document.getElementById("wrong_login");
    TEXT_WRONG.remove();
}