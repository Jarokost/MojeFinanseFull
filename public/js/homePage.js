// show modal when on main page and no action
const container = document.getElementById("exampleModalToggle");
const modalLogin = new bootstrap.Modal(container);
const loggedIn = document.querySelector(".logged-in-as");

let timerId;
if( !loggedIn ) {
    timerId = setTimeout(function(){
        modalLogin.show();
    }, 8000);

    document.getElementById("navbarRegistrationBtn").addEventListener('click', function () {
        clearTimeout(timerId);
    });
    document.getElementById("navbarLoginBtn").addEventListener('click', function () {
        clearTimeout(timerId);
    });

    document.getElementById("inputPasswordBtn").addEventListener('click', function () {
        passShowHide(this.id);
    });
    document.getElementById("inputPasswordRegBtn").addEventListener('click', function () {
        passShowHide(this.id);
    });
}