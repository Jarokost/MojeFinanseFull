function validateNewExpenseFormOnSubmit() {

    let amountValid = validateAmountInput(document.getElementById("floatingInputKwota"));
    let dateValid = validateDateInput(document.getElementById("floatingDate"));
    let categoryValid = validateCategoryInput(document.getElementById("floatingSelect"));
    let methodValid = validateMethodInput(document.getElementById("floatingSelectMethod"));

    if ( amountValid && dateValid && categoryValid && methodValid ) {
        return true;
    } else {
        return false;
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
    if (!validateNewExpenseFormOnSubmit()) {
        event.preventDefault();
    }
});
