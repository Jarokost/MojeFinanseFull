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
