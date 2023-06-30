function validateAmountInput(amountInput) {
    if ( amountInput.value === '' ) {
        amountInput.classList.add('is-invalid');
        document.getElementById(amountInput.id + 'Label').textContent = 'Podaj kwotę!';
        return false;
    } else if ( amountInput.value <= 0.00 || amountInput.value > 999999.99 ) {
        amountInput.classList.add('is-invalid');
        document.getElementById(amountInput.id + 'Label').textContent = 'kwota poza zakresem 0.01-999999.99!';
        return false;
    } else {
        amountInput.classList.remove('is-invalid');
        document.getElementById(amountInput.id + 'Label').textContent = 'Kwota [PLN]';
        return true;
    }
}

function validateDateInput(dateInput) {
    const regexpDate = /^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/;

    if ( dateInput.value === '' ) {
        dateInput.classList.add('is-invalid');
        document.getElementById(dateInput.id + 'Label').textContent = 'Podaj datę!';
        return false;
    } else if ( !regexpDate.test(dateInput.value) ) {
        dateInput.classList.add('is-invalid');
        document.getElementById(dateInput.id + 'Label').textContent = 'Nieporawny format daty rrrr-mm-dd!';
        return false;
    } else {
        dateInput.classList.remove('is-invalid');
        document.getElementById(dateInput.id + 'Label').textContent = 'Data';
        return true;
    }
}

function validateCategoryInput(categoryInput) {
    if ( categoryInput.value === '' ) {
        categoryInput.classList.add('is-invalid');
        document.getElementById(categoryInput.id + 'Label').textContent = 'Wybierz kategorię!';
        return false;
    } else if ( categoryInput.value === '0' ) {
        categoryInput.classList.add('is-invalid');
        document.getElementById(categoryInput.id + 'Label').textContent = 'Wybierz kategorię!';
        return false;
    } else {
        categoryInput.classList.remove('is-invalid');
        document.getElementById(categoryInput.id + 'Label').textContent = 'Kategoria';
        return true;
    }
}

function validateMethodInput(methodInput) {
    if ( methodInput.value === '' ) {
        methodInput.classList.add('is-invalid');
        document.getElementById(methodInput.id + 'Label').textContent = 'Wybierz metodę płatności!';
        return false;
    } else if ( methodInput.value === '0' ) {
        methodInput.classList.add('is-invalid');
        document.getElementById(methodInput.id + 'Label').textContent = 'Wybierz metodę płatności!';
        return false;
    } else {
        methodInput.classList.remove('is-invalid');
        document.getElementById(methodInput.id + 'Label').textContent = 'Metoda płatności';
        return true;
    }
}