function validateAmountInput(amountInput) {
    if ( amountInput.value === '' ) {
        amountInput.classList.add('is-invalid');
        document.getElementById(amountInput.id + 'Label').textContent = 'Podaj kwotę!';
        return true;
    } else if ( amountInput.value <= 0.00 || amountInput.value > 999999.99 ) {
        amountInput.classList.add('is-invalid');
        document.getElementById(amountInput.id + 'Label').textContent = 'kwota poza zakresem 0.01-999999.99!';
        return true;
    } else {
        amountInput.classList.remove('is-invalid');
        document.getElementById(amountInput.id + 'Label').textContent = 'Kwota [PLN]';
        return false;
    }
}

function validateDateInput(dateInput) {
    const regexpDate = /^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/;

    if ( dateInput.value === '' ) {
        dateInput.classList.add('is-invalid');
        document.getElementById(dateInput.id + 'Label').textContent = 'Podaj datę!';
        return true;
    } else if ( !regexpDate.test(dateInput.value) ) {
        dateInput.classList.add('is-invalid');
        document.getElementById(dateInput.id + 'Label').textContent = 'Nieporawny format daty rrrr-mm-dd!';
        return true;
    } else {
        dateInput.classList.remove('is-invalid');
        document.getElementById(dateInput.id + 'Label').textContent = 'Data';
        return false;
    }
}

function validateCategoryInput(categoryInput) {
    if ( categoryInput.value === '' ) {
        categoryInput.classList.add('is-invalid');
        document.getElementById(categoryInput.id + 'Label').textContent = 'Wybierz kategorię!';
        return true;
    } else if ( categoryInput.value === 'wybierz' ) {
        categoryInput.classList.add('is-invalid');
        document.getElementById(categoryInput.id + 'Label').textContent = 'Wybierz kategorię!';
        return true;
    } else {
        categoryInput.classList.remove('is-invalid');
        document.getElementById(categoryInput.id + 'Label').textContent = 'Kategoria';
        return false;
    }
}

function validateMethodInput(methodInput) {
    if ( methodInput.value === '' ) {
        methodInput.classList.add('is-invalid');
        document.getElementById(methodInput.id + 'Label').textContent = 'Wybierz metodę płatności!';
        return true;
    } else if ( methodInput.value === 'wybierz' ) {
        methodInput.classList.add('is-invalid');
        document.getElementById(methodInput.id + 'Label').textContent = 'Wybierz metodę płatności!';
        return true;
    } else {
        methodInput.classList.remove('is-invalid');
        document.getElementById(methodInput.id + 'Label').textContent = 'Metoda płatności';
        return false;
    }
}


function validateNewExpenseFormOnSubmit() {

    let amountNotValid = validateAmountInput(document.getElementById("floatingInputKwota"));
    let dateNotValid = validateDateInput(document.getElementById("floatingDate"));
    let categoryNotValid = validateCategoryInput(document.getElementById("floatingSelect"));
    let methodNotValid = validateMethodInput(document.getElementById("floatingSelectMethod"));

    if ( amountNotValid || dateNotValid || categoryNotValid || methodNotValid ) {
        return false;
    } else {
        return true;
    }
}


document.onreadystatechange = () => {
    if (document.readyState === 'interactive') {

        document.getElementById("floatingInputKwota").addEventListener('focusout', function () {
            if ( validateAmountInput(this) ) {
                this.addEventListener('input', function () {
                    validateAmountInput(this);
                });
            }
        });

        document.getElementById("floatingDate").addEventListener('focusout', function () {
            if ( validateDateInput(this) ) {
                this.addEventListener('input', function () {
                    validateDateInput(this);
                });
            }
        });

        document.getElementById("floatingSelect").addEventListener('focusout', function () {
            if ( validateCategoryInput(this) ) {
                this.addEventListener('input', function () {
                    validateCategoryInput(this);
                });
            }
        });

        document.getElementById("floatingSelectMethod").addEventListener('focusout', function () {
            if ( validateMethodInput(this) ) {
                this.addEventListener('input', function () {
                    validateMethodInput(this);
                });
            }
        });

        document.getElementById("formAddExpense").addEventListener('submit', (event) => {
            if (validateNewExpenseFormOnSubmit() === true) {
            } else {
                event.preventDefault();
            }
        });

    }
};
