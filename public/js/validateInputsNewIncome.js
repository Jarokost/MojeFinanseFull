function validateNewIncomeFormOnSubmit() {

    let amountValid = validateAmountInput(document.getElementById("floatingInputKwota"));
    let dateValid = validateDateInput(document.getElementById("floatingDate"));
    let categoryValid = validateCategoryInput(document.getElementById("floatingSelect"));

    if ( amountValid && dateValid && categoryValid ) {
        return true;
    } else {
        return false;
    }
}

document.getElementById("floatingInputKwota").addEventListener('focusout', function () {
    if ( !validateAmountInput(this) ) {
        this.addEventListener('input', function () {
            validateAmountInput(this);
        });
    }
});

document.getElementById("floatingDate").addEventListener('focusout', function () {
    if ( !validateDateInput(this) ) {
        this.addEventListener('input', function () {
            validateDateInput(this);
        });
    }
});

document.getElementById("floatingSelect").addEventListener('focusout', function () {
    if ( !validateCategoryInput(this) ) {
        this.addEventListener('input', function () {
            validateCategoryInput(this);
        });
    }
});

document.getElementById("formAddIncome").addEventListener('submit', (event) => {
    if (!validateNewIncomeFormOnSubmit()) {
        event.preventDefault();
    }
});
