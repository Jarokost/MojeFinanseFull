const editExpenseAmountElement = document.getElementById("editExpenseAmount");
const editExpenseDateElement = document.getElementById("editExpenseDate");
const editExpenseCategoryElement = document.getElementById("editExpenseCategory");
const editExpenseMethodElement = document.getElementById("editExpenseMethod");

const editIncomeAmountElement = document.getElementById("editIncomeAmount");
const editIncomeDateElement = document.getElementById("editIncomeDate");
const editIncomeCategoryElement = document.getElementById("editIncomeCategory");


function validateEditExpenseFormOnSubmit() {

    let amountValid = validateAmountInput(editExpenseAmountElement);
    let dateValid = validateDateInput(editExpenseDateElement);
    let categoryValid = validateCategoryInput(editExpenseCategoryElement);
    let methodValid = validateMethodInput(editExpenseMethodElement);

    if ( amountValid && dateValid && categoryValid && methodValid ) {
        return true;
    } else {
        return false;
    }
}

if ( editExpenseAmountElement !== null ) {
  editExpenseAmountElement.addEventListener('focusout', function () {
    if ( !validateAmountInput(this) ) {
      this.addEventListener('input', function () {
        validateAmountInput(this);
      });
    }
  });

  editExpenseDateElement.addEventListener('focusout', function () {
    if ( !validateDateInput(this) ) {
      this.addEventListener('input', function () {
        validateDateInput(this);
      });
    }
  });

  editExpenseCategoryElement.addEventListener('focusout', function () {
    if ( !validateCategoryInput(this) ) {
      this.addEventListener('input', function () {
        validateCategoryInput(this);
      });
    }
  });

  editExpenseMethodElement.addEventListener('focusout', function () {
    if ( !validateMethodInput(this) ) {
      this.addEventListener('input', function () {
        validateMethodInput(this);
      });
    }
  });
}

function validateEditIncomeFormOnSubmit() {

  let amountValid = validateAmountInput(editIncomeAmountElement);
  let dateValid = validateDateInput(editIncomeDateElement);
  let categoryValid = validateCategoryInput(editIncomeCategoryElement);

  if ( amountValid && dateValid && categoryValid ) {
      return true;
  } else {
      return false;
  }
}

if ( editIncomeAmountElement !== null ) {
  editIncomeAmountElement.addEventListener('focusout', function () {
    if ( !validateAmountInput(this) ) {
      this.addEventListener('input', function () {
        validateAmountInput(this);
      });
    }
  });

  editIncomeDateElement.addEventListener('focusout', function () {
    if ( !validateDateInput(this) ) {
      this.addEventListener('input', function () {
        validateDateInput(this);
      });
    }
  });

  editIncomeCategoryElement.addEventListener('focusout', function () {
    if ( !validateCategoryInput(this) ) {
      this.addEventListener('input', function () {
        validateCategoryInput(this);
      });
    }
  });
}