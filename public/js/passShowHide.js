function passShowHide(btnId) {
    let pass = document.getElementById(btnId.id.slice(0,btnId.id.length-3));
    if (pass.type == "password") pass.type = "text";
    else pass.type = "password";
    let btn = document.getElementById(btnId.id);
    if (btn.innerHTML == "Pokaż") btn.innerHTML = "Ukryj";
    else btn.innerHTML = "Pokaż";
}

document.getElementById("inputPasswordBtn").addEventListener('click', function () {
    passShowHide(this);
});
document.getElementById("inputPasswordRegBtn").addEventListener('click', function () {
    passShowHide(this);
});