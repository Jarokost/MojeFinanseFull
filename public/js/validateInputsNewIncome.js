function validateNewIncomeFormOnSubmit() {

    let amountNotValid = validateAmountInput(document.getElementById("floatingInputKwota"));
    let dateNotValid = validateDateInput(document.getElementById("floatingDate"));
    let categoryNotValid = validateCategoryInput(document.getElementById("floatingSelect"));

    if ( amountNotValid || dateNotValid || categoryNotValid ) {
        return false;
    } else {
        return true;
    }
}

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

document.getElementById("formAddIncome").addEventListener('submit', (event) => {
    if (validateNewIncomeFormOnSubmit() === true) {
    } else {
        event.preventDefault();
    }
});
