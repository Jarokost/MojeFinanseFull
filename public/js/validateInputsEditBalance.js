function validateEditExpenseFormOnSubmit() {

    let amountNotValid = validateAmountInput(document.getElementById("editExpenseAmount"));
    let dateNotValid = validateDateInput(document.getElementById("editExpenseDate"));
    let categoryNotValid = validateCategoryInput(document.getElementById("editExpenseCategory"));
    let methodNotValid = validateMethodInput(document.getElementById("editExpenseMethod"));

    if ( amountNotValid || dateNotValid || categoryNotValid || methodNotValid ) {
        return false;
    } else {
        return true;
    }
}

document.getElementById("editExpenseAmount").addEventListener('focusout', function () {
  if ( validateAmountInput(this) ) {
    this.addEventListener('input', function () {
      validateAmountInput(this);
    });
  }
});

document.getElementById("editExpenseDate").addEventListener('focusout', function () {
  if ( validateDateInput(this) ) {
    this.addEventListener('input', function () {
      validateDateInput(this);
    });
  }
});

document.getElementById("editExpenseCategory").addEventListener('focusout', function () {
  if ( validateCategoryInput(this) ) {
    this.addEventListener('input', function () {
      validateCategoryInput(this);
    });
  }
});

document.getElementById("editExpenseMethod").addEventListener('focusout', function () {
  if ( validateMethodInput(this) ) {
    this.addEventListener('input', function () {
      validateMethodInput(this);
    });
  }
});

function validateEditIncomeFormOnSubmit() {

  let amountNotValid = validateAmountInput(document.getElementById("editIncomeAmount"));
  let dateNotValid = validateDateInput(document.getElementById("editIncomeDate"));
  let categoryNotValid = validateCategoryInput(document.getElementById("editIncomeCategory"));

  if ( amountNotValid || dateNotValid || categoryNotValid ) {
      return false;
  } else {
      return true;
  }
}

document.getElementById("editIncomeAmount").addEventListener('focusout', function () {
  if ( validateAmountInput(this) ) {
    this.addEventListener('input', function () {
      validateAmountInput(this);
    });
  }
});

document.getElementById("editIncomeDate").addEventListener('focusout', function () {
  if ( validateDateInput(this) ) {
    this.addEventListener('input', function () {
      validateDateInput(this);
    });
  }
});

document.getElementById("editIncomeCategory").addEventListener('focusout', function () {
  if ( validateCategoryInput(this) ) {
    this.addEventListener('input', function () {
      validateCategoryInput(this);
    });
  }
});