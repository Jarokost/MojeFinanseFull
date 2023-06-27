// Async function to check if email is already taken
let emailValidReg;
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
        emailValidReg = validateEmailInputRegistration(emailInput, data);
    } catch (e) {
        console.log('ERROR: ', e);
    }
}

// Registration Form
function validateNameInputRegistration(nameInput) {
    if ( nameInput.value === '' ) {
        nameInput.classList.add('is-invalid');
        document.getElementById(nameInput.id + 'Label').textContent = 'Podaj imię!';
        return false;
    } else {
        nameInput.classList.remove('is-invalid');
        document.getElementById(nameInput.id + 'Label').textContent = 'Imię';
        return true;
    }
}

function validatePasswordInputRegistration(passwordInput) {
    const regexpLetter = /.*[a-zA-Z]+.*/;
    const regexpNumber = /.*\d+.*/;

    if ( passwordInput.value.length < 6 ) {
        passwordInput.classList.add('is-invalid');
        document.getElementById(passwordInput.id + 'Label').textContent = 'Hasło musi zawierać min. 6 znaków!';
        return false;
    } else if (!regexpLetter.test(passwordInput.value)) {
        passwordInput.classList.add('is-invalid');
        document.getElementById(passwordInput.id + 'Label').textContent = 'Hasło musi zawierać conajmniej jedną literę!';
        return false;
    } else if (!regexpNumber.test(passwordInput.value)) {
        passwordInput.classList.add('is-invalid');
        document.getElementById(passwordInput.id + 'Label').textContent = 'Hasło musi zawierać conajmniej jedną cyfrę!';
        return false;
    } else {
        passwordInput.classList.remove('is-invalid');
        document.getElementById(passwordInput.id + 'Label').textContent = 'Hasło';
        return true;
    }
}

function validateEmailInputRegistration(emailInput, emailIsNotValid) {
    const regexpEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if ( emailInput.value === '' ) {
        emailInput.classList.add('is-invalid');
        document.getElementById(emailInput.id + 'Label').textContent = 'Podaj adres email!';
        return false;
    } else if (!regexpEmail.test(emailInput.value)) {
        emailInput.classList.add('is-invalid');
        document.getElementById(emailInput.id + 'Label').textContent = 'Adres email jest niepoprawny!';
        return false;
    } else if (!emailIsNotValid) {
        emailInput.classList.add('is-invalid');
        document.getElementById(emailInput.id + 'Label').textContent = 'Adres email jest zajęty!';
        return false;
    } else {
        emailInput.classList.remove('is-invalid');
        document.getElementById(emailInput.id + 'Label').textContent = 'Adres email';
        return true;
    }
}

function validateRegistrationFormOnSubmit() {

    let nameValid = validateNameInputRegistration(document.getElementById("inputNameReg"));
    let passwordValid = validatePasswordInputRegistration(document.getElementById("inputPasswordReg"));
    getEmailIsValid(document.getElementById("inputEmailReg"));

    if ( nameValid && passwordValid && emailValidReg ) {
        return true;
    } else {
        return false;
    }
}

// Login Form
function validatePasswordInputLogin(passwordInput) {
    if ( passwordInput.value === '' ) {
        passwordInput.classList.add('is-invalid');
        document.getElementById(passwordInput.id + 'Label').textContent = 'Podaj hasło!';
        return false;
    } else {
        passwordInput.classList.remove('is-invalid');
        document.getElementById(passwordInput.id + 'Label').textContent = 'Hasło';
        return true;
    }
}

function validateEmailInputLogin(emailInput) {
    const regexpEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if( emailInput.value === '' ) {
        emailInput.classList.add('is-invalid');
        document.getElementById(emailInput.id + 'Label').textContent = 'Podaj adres email!';
        return false;
    } else if (!regexpEmail.test(emailInput.value)) {
        emailInput.classList.add('is-invalid');
        document.getElementById(emailInput.id + 'Label').textContent = 'Adres email jest niepoprawny!';
        return false;
    } else {
        emailInput.classList.remove('is-invalid');
        document.getElementById(emailInput.id + 'Label').textContent = 'Adres email';
        return true;
    }
}

function validateLoginFormOnSubmit() {

    let passwordNotValid = validatePasswordInputLogin(document.getElementById("inputPassword"));
    let emailValid = validateEmailInputLogin(document.getElementById("inputEmail"));

    if ( passwordNotValid && emailValid ) {
        return true;
    } else {
        return false;
    }
}

// Registration Form
document.getElementById("inputNameReg").addEventListener('focusout', function () {
    if ( !validateNameInputRegistration(this) ) {
        this.addEventListener('input', function () {
            validateNameInputRegistration(this);
        });
    }
});

document.getElementById("inputPasswordReg").addEventListener('focusout', function () {
    if ( !validatePasswordInputRegistration(this) ) {
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
    if (!validateRegistrationFormOnSubmit()) {
        event.preventDefault();
    }
});

// Login form
document.getElementById("inputPassword").addEventListener('focusout', function () {
    if ( !validatePasswordInputLogin(this) ) {
        this.addEventListener('input', function () {
            validatePasswordInputLogin(this);
        });
    }
});

document.getElementById("inputEmail").addEventListener('focusout', function () {
    if ( !validateEmailInputLogin(this) ) {
        this.addEventListener('input', function () {
            validateEmailInputLogin(this);
        });
    }
});

document.getElementById("formLogin").addEventListener('submit', (event) => {
    if (!validateLoginFormOnSubmit()) {
        event.preventDefault();
    }
});