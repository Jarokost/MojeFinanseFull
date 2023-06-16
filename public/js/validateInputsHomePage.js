// Async function to check if email is already taken
const getEmailIsValid = async (emailInput) => {
    const inData = {
        email: emailInput.value
    };

    try { 
        const res = await fetch(`/Account/validateEmail`, {
            method: 'post',
            body: JSON.stringify(inData)
        })
        const data = await res.json();
        validateEmailInputRegistration(emailInput, data);
    } catch (e) {
        console.log('ERROR: ', e);
    }
}

// Registration Form
function validateNameInputRegistration(nameInput) {
    if ( nameInput.value === '' ) {
        nameInput.classList.add('is-invalid');
        document.getElementById(nameInput.id + 'Label').textContent = 'Podaj imię!';
        return true;
    } else {
        nameInput.classList.remove('is-invalid');
        document.getElementById(nameInput.id + 'Label').textContent = 'Imię';
        return false;
    }
}

function validatePasswordInputRegistration(passwordInput) {
    const regexpLetter = /.*[a-zA-Z]+.*/;
    const regexpNumber = /.*\d+.*/;

    if ( passwordInput.value.length < 6 ) {
        passwordInput.classList.add('is-invalid');
        document.getElementById(passwordInput.id + 'Label').textContent = 'Hasło musi zawierać min. 6 znaków!';
        return true;
    } else if (!regexpLetter.test(passwordInput.value)) {
        passwordInput.classList.add('is-invalid');
        document.getElementById(passwordInput.id + 'Label').textContent = 'Hasło musi zawierać conajmniej jedną literę!';
        return true;
    } else if (!regexpNumber.test(passwordInput.value)) {
        passwordInput.classList.add('is-invalid');
        document.getElementById(passwordInput.id + 'Label').textContent = 'Hasło musi zawierać conajmniej jedną cyfrę!';
        return true;
    } else {
        passwordInput.classList.remove('is-invalid');
        document.getElementById(passwordInput.id + 'Label').textContent = 'Hasło';
        return false;
    }
}

function validateEmailInputRegistration(emailInput, emailIsNotValid) {
    const regexpEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if ( emailInput.value === '' ) {
        emailInput.classList.add('is-invalid');
        document.getElementById(emailInput.id + 'Label').textContent = 'Podaj adres email!';
        return true;
    } else if (!regexpEmail.test(emailInput.value)) {
        emailInput.classList.add('is-invalid');
        document.getElementById(emailInput.id + 'Label').textContent = 'Adres email jest niepoprawny!';
        return true;
    } else if (!emailIsNotValid) {
        emailInput.classList.add('is-invalid');
        document.getElementById(emailInput.id + 'Label').textContent = 'Adres email jest zajęty!';
        return true;
    } else {
        emailInput.classList.remove('is-invalid');
        document.getElementById(emailInput.id + 'Label').textContent = 'Adres email';
        return false;
    }
}

function validateRegistrationFormOnSubmit() {

    let nameNotValid = validateNameInputRegistration(document.getElementById("inputNameReg"));
    let passwordNotValid = validatePasswordInputRegistration(document.getElementById("inputPasswordReg"));
    let emailNotValid = getEmailIsValid(document.getElementById("inputEmailReg"));

    if ( nameNotValid || passwordNotValid || emailNotValid ) {
        return false;
    } else {
        return true;
    }
}

// Login Form
function validatePasswordInputLogin(passwordInput) {
    if ( passwordInput.value === '' ) {
        passwordInput.classList.add('is-invalid');
        document.getElementById(passwordInput.id + 'Label').textContent = 'Podaj hasło!';
        return true;
    } else {
        passwordInput.classList.remove('is-invalid');
        document.getElementById(passwordInput.id + 'Label').textContent = 'Hasło';
        return false;
    }
}

function validateEmailInputLogin(emailInput) {
    const regexpEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if( emailInput.value === '' ) {
        emailInput.classList.add('is-invalid');
        document.getElementById(emailInput.id + 'Label').textContent = 'Podaj adres email!';
        return true;
    } else if (!regexpEmail.test(emailInput.value)) {
        emailInput.classList.add('is-invalid');
        document.getElementById(emailInput.id + 'Label').textContent = 'Adres email jest niepoprawny!';
        return true;
    } else {
        emailInput.classList.remove('is-invalid');
        document.getElementById(emailInput.id + 'Label').textContent = 'Adres email';
        return false;
    }
}

function validateLoginFormOnSubmit() {

    let passwordNotValid = validatePasswordInputLogin(document.getElementById("inputPassword"));
    let emailNotValid = validateEmailInputLogin(document.getElementById("inputEmail"));

    if ( passwordNotValid || emailNotValid ) {
        return false;
    } else {
        return true;
    }
}

// Registration Form
document.getElementById("inputNameReg").addEventListener('focusout', function () {
    if ( validateNameInputRegistration(this) ) {
        this.addEventListener('input', function () {
            validateNameInputRegistration(this);
        });
    }
});

document.getElementById("inputPasswordReg").addEventListener('focusout', function () {
    if ( validatePasswordInputRegistration(this) ) {
        this.addEventListener('input', function () {
            validatePasswordInputRegistration(this);
        });
    }
});

document.getElementById("inputEmailReg").addEventListener('focusout', function () {
    if ( getEmailIsValid(this) ) {
        this.addEventListener('input', function () {
            getEmailIsValid(this);
        });
    }
});

document.getElementById("formSignup").addEventListener('submit', (event) => {
    if (validateRegistrationFormOnSubmit() === true) {
    } else {
        event.preventDefault();
    }
});

// Login form
document.getElementById("inputPassword").addEventListener('focusout', function () {
    if ( validatePasswordInputLogin(this) ) {
        this.addEventListener('input', function () {
            validatePasswordInputLogin(this);
        });
    }
});

document.getElementById("inputEmail").addEventListener('focusout', function () {
    if ( validateEmailInputLogin(this) ) {
        this.addEventListener('input', function () {
            validateEmailInputLogin(this);
        });
    }
});

document.getElementById("formLogin").addEventListener('submit', (event) => {
    if (validateLoginFormOnSubmit() === true) {
    } else {
        event.preventDefault();
    }
});

if( !document.querySelector(".logged-in-as") ) {
    setTimeout(function(){
        $("#exampleModalToggle").modal("show");
    }, 15000);
}