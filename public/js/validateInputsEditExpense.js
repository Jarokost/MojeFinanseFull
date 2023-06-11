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

// document.getElementById("formEditExpense").addEventListener('submit', (event) => {
//   if (validateEditExpenseFormOnSubmit() === true) {
//     console.log('submitted');
//   } else {
//     event.preventDefault();
//     console.log('not submitted');
//   }
// });
