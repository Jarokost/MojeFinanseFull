function validateEditExpenseFormOnSubmit() {

    let amountValid = validateAmountInput(document.getElementById("editExpenseAmount"));
    let dateValid = validateDateInput(document.getElementById("editExpenseDate"));
    let categoryValid = validateCategoryInput(document.getElementById("editExpenseCategory"));
    let methodValid = validateMethodInput(document.getElementById("editExpenseMethod"));

    if ( amountValid && dateValid && categoryValid && methodValid ) {
        return true;
    } else {
        return false;
    }
}

document.getElementById("editExpenseAmount").addEventListener('focusout', function () {
  if ( !validateAmountInput(this) ) {
    this.addEventListener('input', function () {
      validateAmountInput(this);
    });
  }
});

document.getElementById("editExpenseDate").addEventListener('focusout', function () {
  if ( !validateDateInput(this) ) {
    this.addEventListener('input', function () {
      validateDateInput(this);
    });
  }
});

document.getElementById("editExpenseCategory").addEventListener('focusout', function () {
  if ( !validateCategoryInput(this) ) {
    this.addEventListener('input', function () {
      validateCategoryInput(this);
    });
  }
});

document.getElementById("editExpenseMethod").addEventListener('focusout', function () {
  if ( !validateMethodInput(this) ) {
    this.addEventListener('input', function () {
      validateMethodInput(this);
    });
  }
});

function validateEditIncomeFormOnSubmit() {

  let amountValid = validateAmountInput(document.getElementById("editIncomeAmount"));
  let dateValid = validateDateInput(document.getElementById("editIncomeDate"));
  let categoryValid = validateCategoryInput(document.getElementById("editIncomeCategory"));

  if ( amountValid && dateValid && categoryValid ) {
      return true;
  } else {
      return false;
  }
}

document.getElementById("editIncomeAmount").addEventListener('focusout', function () {
  if ( !validateAmountInput(this) ) {
    this.addEventListener('input', function () {
      validateAmountInput(this);
    });
  }
});

document.getElementById("editIncomeDate").addEventListener('focusout', function () {
  if ( !validateDateInput(this) ) {
    this.addEventListener('input', function () {
      validateDateInput(this);
    });
  }
});

document.getElementById("editIncomeCategory").addEventListener('focusout', function () {
  if ( !validateCategoryInput(this) ) {
    this.addEventListener('input', function () {
      validateCategoryInput(this);
    });
  }
});