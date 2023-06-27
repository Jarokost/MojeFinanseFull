 // change password validation functions
 let passwordOldValid;
 function validateNewPassword(passwordInput) {
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
 function validateOldPassword(passwordInput, data) {
   if (data === false) {
     passwordInput.classList.add('is-invalid');
     document.getElementById(passwordInput.id + 'Label').textContent = 'Podane hasło jest nieprawidłowe!';
     return false;
   } else {
     passwordInput.classList.remove('is-invalid');
     document.getElementById(passwordInput.id + 'Label').textContent = 'Podaj aktualne hasło';
     return true;
   }
 }
 async function getPasswordIsValid(passwordInput) {
   let password = passwordInput.value;

   const inData = { password: password };

   try { 
     const res = await fetch(`/Settings/checkIfOldPasswordCorrect`, {
         method: 'post',
         body: JSON.stringify(inData)
     })
     const data = await res.json();
     passwordOldValid = validateOldPassword(passwordInput, data);
   } catch (e) {
     console.log('ERROR: ', e);
   }
 }
 function validatePasswordChangeFormOnSubmit() {

   getPasswordIsValid(document.getElementById("inputPasswordCurrent"));
   let passwordNewValid = validateNewPassword(document.getElementById("inputPasswordNew"));

   console.log(passwordOldValid, passwordNewValid);
   if ( passwordOldValid && passwordNewValid ) {
       return true;
   } else {
       return false;
   }
 }

 // change password validation events
 document.getElementById("inputPasswordCurrent").addEventListener('focusout', function () {
   getPasswordIsValid(this);
 });
 document.getElementById("inputPasswordNew").addEventListener('focusout', function () {
   if ( !validateNewPassword(this) ) {
     this.addEventListener('input', function () {
       validateNewPassword(this);
     });
   }
 });
 document.getElementById("formUpdateAccountPassword").addEventListener('submit', (event) => {
   if (!validatePasswordChangeFormOnSubmit()) {
       event.preventDefault();
   }
 });

 // change email validation functions
 let emailValid;
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
         emailValid = validateEmailInput(emailInput, data);
     } catch (e) {
         console.log('ERROR: ', e);
     }
 }
 function validateEmailInput(emailInput, emailIsNotValid) {
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
 function validateEmail2Input(emailInput, emailInput2) {
   const regexpEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

   if ( emailInput.value === '' ) {
     emailInput.classList.add('is-invalid');
     document.getElementById(emailInput.id + 'Label').textContent = 'Podaj adres email!';
     return false;
   } else if ( emailInput.value != emailInput2.value ) {
     emailInput.classList.add('is-invalid');
     document.getElementById(emailInput.id + 'Label').textContent = 'Podane adresy różnią się!';
     return false;
   } else {
     emailInput.classList.remove('is-invalid');
     document.getElementById(emailInput.id + 'Label').textContent = 'Adres email';
     return true;
   }
 }
 function validateNewEmailFormOnSubmit() {

   getEmailIsValid(document.getElementById("inputEmail"));
   let email2Valid = validateEmail2Input(document.getElementById("inputEmail2"), document.getElementById("inputEmail"));

   if ( emailValid && email2Valid ) {
     return true;
   } else {
     return false;
   }
 }

 // change email validation events
 document.getElementById("inputEmail").addEventListener('focusout', function () {
   if ( getEmailIsValid(this) ) {
     this.addEventListener('input', function () {
         getEmailIsValid(this);
     });
   }
 });
 document.getElementById("inputEmail2").addEventListener('focusout', function () {
   let emailNew = document.getElementById("inputEmail");
   if ( !validateEmail2Input(this, emailNew) ) {
     this.addEventListener('input', function () {
       validateEmail2Input(this, emailNew);
     });
   }
 });
 document.getElementById("formUpdateAccountEmail").addEventListener('submit', (event) => {
   if (!validateNewEmailFormOnSubmit()) {
     event.preventDefault();
   }
 });
