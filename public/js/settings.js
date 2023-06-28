let id_to_delete = 0;
let table_row = null;

function updateIncomesCategoryList(data)
{
  let table_rows = document.querySelectorAll("#tableIncomesCategories tr");
  for(let i = 0; i<table_rows.length; i++) {
    table_rows[i].remove();
  }
  
  let table_body = document.querySelector("#tableIncomesCategories tbody");
  for (let i = 0; i < data.categories.length; i++) {
    table_body.insertAdjacentHTML( "beforeend", `
      <tr>
        <td>${data.categories[i].name}</td>
        <td hidden>${data.categories[i].id}</td>
        <td href="#modalChgCatNameIncomes" data-bs-toggle="modal">
          <a class="dropdown-item editingTRbutton">
            <i class="icon-pencil"></i>
          </a>
        </td>
        <td href="#modalRemCatNameIncomes" data-bs-toggle="modal">
          <a class="dropdown-item removingTRbutton">
            <i class="icon-trash"></i>
          </a></a>
        </td>
      </tr>`);
  }
}

function updateExpensesCategoryList(data)
{
  let table_rows = document.querySelectorAll("#tableExpensesCategories tr");
  for(let i = 0; i<table_rows.length; i++) {
    table_rows[i].remove();
  }

  let table_body = document.querySelector("#tableExpensesCategories tbody");
  for (let i = 0; i < data.categories.length; i++) {
    table_body.insertAdjacentHTML( "beforeend", `
      <tr>
        <td class="expenses-limit">
          ${data.categories[i].name}
          </br>
          ${data.categories[i].limit_value ? `<small class="text-muted">limit: ${data.categories[i].limit_value}</small>` : ''}
        </td>
        <td hidden>${data.categories[i].id}</td>
        <td href="#modalChgCatNameExpenses" data-bs-toggle="modal">
          <a class="dropdown-item editingTRbutton">
            <i class="icon-pencil"></i>
          </a>
        </td>
        <td href="#modalRemCatNameExpenses" data-bs-toggle="modal">
          <a class="dropdown-item removingTRbutton">
            <i class="icon-trash"></i>
          </a></a>
        </td>
      </tr>
    `);
  }
}

function updatePaymentMethodsList(data)
{
  let table_rows = document.querySelectorAll("#tablePaymentMethods tr");
  for(let i = 0; i<table_rows.length; i++) {
    table_rows[i].remove();
  }

  let table_body = document.querySelector("#tablePaymentMethods tbody");
  for (let i = 0; i < data.categories.length; i++) {
    table_body.insertAdjacentHTML( "beforeend", `
      <tr>
        <td>${data.categories[i].name}</td>
        <td hidden>${data.categories[i].id}</td>
        <td href="#modalChgCatNamePayment" data-bs-toggle="modal">
          <a class="dropdown-item editingTRbutton">
            <i class="icon-pencil"></i>
          </a>
        </td>
        <td href="#modalRemCatNamePayment" data-bs-toggle="modal">
          <a class="dropdown-item removingTRbutton">
            <i class="icon-trash"></i>
          </a></a>
        </td>
      </tr>
    `);
  }
}

function polishEnding(number) {
  if ( number < 5 ) {
    return 'e';
  } else if ( number >= 5 && number < 20 ) {
    return 'i';
  } else {
    let mod = number % 10;
    if ( (mod >= 0 && mod <= 1) || (mod >= 5 && mod <= 9) ) {
      return 'i';
    } else {
      return 'e';
    }
  }
}

// passShowHide
document.getElementById("inputPasswordNewBtn").addEventListener('click', function () {
  passShowHide(this.id);
});
document.getElementById("inputPasswordCurrentBtn").addEventListener('click', function () {
  passShowHide(this.id);
});

// modal actions - Add, Change, Remove Categories
{
  // Add Incomes Category
  document.getElementById("buttonAddIncomesCategory").
  addEventListener("click", async (event) => {
    event.preventDefault();

    let name = document.getElementById("floatingAddCatNameIncomes").value;

    const inData = { name: name };

    try { 
      const res = await fetch(`/Settings/addIncomeCategory`, {
          method: 'post',
          body: JSON.stringify(inData)
      })
      const data = await res.json();
      updateIncomesCategoryList(data);
      document.getElementById("floatingAddCatNameIncomes").value = '';
      printFlashMessages(data);
    } catch (e) {
      console.log('ERROR: ', e);
    }
  });

  // Select row from table
  document.getElementById("tableIncomesCategories")
  .addEventListener("click", function(ele) {

    if( ele.srcElement.cellIndex < 2 ) {
      return;
    } else if (ele.target.className === "icon-trash") {
      table_row = ele.target.parentNode.parentNode.parentNode;
      document.getElementById("floatingRemCatNameIncomes").value = table_row.cells[0].textContent;
    } else if (ele.target.className === "icon-pencil") {
      table_row = ele.target.parentNode.parentNode.parentNode;
      document.getElementById("floatingChgCatNameIncomesCurrent").value = table_row.cells[0].textContent;
    } else if (ele.target.childNodes[1].childNodes[1].className === "icon-trash") {
      table_row = ele.target.parentNode;
      document.getElementById("floatingRemCatNameIncomes").value = table_row.cells[0].textContent;
    } else if (ele.target.childNodes[1].childNodes[1].className === "icon-pencil") {
      table_row = ele.target.parentNode;
      document.getElementById("floatingChgCatNameIncomesCurrent").value = table_row.cells[0].textContent;
    }
  });

  // Edit Incomes Category
  document.getElementById("buttonUpdateIncomesCategory")
  .addEventListener("click", async (event) => {
    event.preventDefault();
    
    let id = table_row.cells[1].textContent;
    let name = document.getElementById("floatingChgCatNameIncomes").value;

    let inData = {
      id: id,
      name: name
    };

    try { 
      const res = await fetch(`/Settings/updateIncomeCategory`, {
          method: 'post',
          body: JSON.stringify(inData)
      })
      const data = await res.json();
      updateIncomesCategoryList(data);
      document.getElementById("floatingChgCatNameIncomes").value = '';
      printFlashMessages(data);
    } catch (e) {
      console.log('ERROR: ', e);
    }
  });

  // Remove Incomes Category
  // Check if removal category has transaction assigned, if not remove, if yes display confirmation
  document.getElementById("buttonRemoveIncomesCategory")
  .addEventListener("click", async (event) => {
    event.preventDefault();

    id_to_delete = table_row.cells[1].textContent;
    let force = 'n';

    const inData = {
      id: id_to_delete,
      force: force
    }

    try { 
      const res = await fetch(`/Settings/deleteIncomeCategory`, {
          method: 'post',
          body: JSON.stringify(inData)
      })
      const data = await res.json();
      updateIncomesCategoryList(data);
      printFlashMessages(data);
      if(data.flash_message_type[0] === 'warning')
      {
        $("#modalRemCatNameIncomesAccept").modal('show');
        document.getElementById("RemoveIncomeCategoryAcceptNote").innerHTML = `kategoria: "${data.category_name}" zawiera: (${data.transactions}) transakcj${polishEnding(data.transactions)}, usunięcie kategorii spowoduje również usunięcie tych tansakcji!`;
      }
    } catch (e) {
      console.log('ERROR: ', e);
    }
  });

  // If removal category has transaction assigned, confirm removal
  document.getElementById("buttonRemoveIncomesCategoryAccept")
  .addEventListener("click", async (event) => {
    event.preventDefault();

    let force = 'y';

    const inData = {
      id: id_to_delete,
      force: force
    }

    try { 
      const res = await fetch(`/Settings/deleteIncomeCategory`, {
          method: 'post',
          body: JSON.stringify(inData)
      })
      const data = await res.json();
      updateIncomesCategoryList(data);
      printFlashMessages(data);
    } catch (e) {
      console.log('ERROR: ', e);
    }
  });

  // Add Expenses Category
  document.getElementById("buttonAddExpensesCategory")
  .addEventListener("click", async (event) => {
    event.preventDefault();

    let name = document.getElementById("floatingAddCatNameExpenses").value;

    const inData = { name: name };

    try { 
      const res = await fetch(`/Settings/addExpenseCategory`, {
          method: 'post',
          body: JSON.stringify(inData)
      })
      const data = await res.json();
      updateExpensesCategoryList(data);
      document.getElementById("floatingAddCatNameExpenses").value = '';
      printFlashMessages(data);
    } catch (e) {
      console.log('ERROR: ', e);
    }
  });

  // Select row from table
  document.getElementById("tableExpensesCategories")
  .addEventListener("click", function(ele) {

    if( ele.srcElement.cellIndex < 2 ) {
      return;
    } else if (ele.target.className === "icon-trash") {
      table_row = ele.target.parentNode.parentNode.parentNode;
      document.getElementById("floatingRemCatNameExpenses").value = table_row.cells[0].childNodes[0].textContent.trim();  
    } else if (ele.target.className === "icon-pencil") {
      table_row = ele.target.parentNode.parentNode.parentNode;
      document.getElementById("floatingChgCatNameExpenseCurrent").value = table_row.cells[0].childNodes[0].textContent.trim();
      if(table_row.cells[0].childNodes.length > 3) {
        document.getElementById("floatingChgCatLimitExpenses").value = table_row.cells[0].childNodes[3].childNodes[0].textContent.slice(7);
      } else {
        document.getElementById("floatingChgCatLimitExpenses").value = null;
      }   
    } else if (ele.target.childNodes[1].childNodes[1].className === "icon-trash") {
      table_row = ele.target.parentNode;
      document.getElementById("floatingRemCatNameExpenses").value = table_row.cells[0].childNodes[0].textContent.trim();  
    } else if (ele.target.childNodes[1].childNodes[1].className === "icon-pencil") {
      table_row = ele.target.parentNode;
      document.getElementById("floatingChgCatNameExpenseCurrent").value = table_row.cells[0].childNodes[0].textContent.trim();
      if(table_row.cells[0].childNodes.length > 3) {
        document.getElementById("floatingChgCatLimitExpenses").value = table_row.cells[0].childNodes[3].childNodes[0].textContent.slice(7);
      } else {
        document.getElementById("floatingChgCatLimitExpenses").value = null;
      }
    }

    // alert('weszlo!');
    console.log(ele);
    console.log(table_row);
  });

  // Edit Expenses Category
  document.getElementById("buttonUpdateExpensesCategory")
  .addEventListener("click", async (event) => {
    event.preventDefault();

    let id = table_row.cells[1].textContent;
    let name = document.getElementById("floatingChgCatNameExpenses").value;
    let limit_value = document.getElementById("floatingChgCatLimitExpenses").value;

    let inData = {
      id: id,
      name: name,
      limit_value: limit_value
    };

    try { 
      const res = await fetch(`/Settings/updateExpenseCategory`, {
          method: 'post',
          body: JSON.stringify(inData)
      })
      const data = await res.json();
      updateExpensesCategoryList(data);
      document.getElementById("floatingChgCatNameExpenses").value = '';
      printFlashMessages(data);
    } catch (e) {
      console.log('ERROR: ', e);
    }
    
  });

  // Remove Expenses Category
  // Check if removal category has transaction assigned, if not remove, if yes display confirmation
  document.getElementById("buttonRemoveExpensesCategory")
  .addEventListener("click", async (event) => {
    event.preventDefault();

    id_to_delete = table_row.cells[1].textContent;
    let force = 'n';

    const inData = {
      id: id_to_delete,
      force: force
    }

    try { 
      const res = await fetch(`/Settings/deleteExpenseCategory`, {
          method: 'post',
          body: JSON.stringify(inData)
      })
      const data = await res.json();
      updateExpensesCategoryList(data);
      printFlashMessages(data);
      if(data.flash_message_type[0] === 'warning')
      {
        $("#modalRemCatNameExpensesAccept").modal('show');
        document.getElementById("RemoveExpenseCategoryAcceptNote").innerHTML = `kategoria: "${data.category_name}" zawiera: (${data.transactions}) transakcj${polishEnding(data.transactions)}, usunięcie kategorii spowoduje również usunięcie ${data.transactions <= 1 ? "tej tansakcji!" : "tych tansakcji!"}`;
        console.log(document.getElementById("RemoveExpenseCategoryAcceptNote").innerHTML);
      }
    } catch (e) {
      console.log('ERROR: ', e);
    }
  });

  // If removal category has transaction assigned, confirm removal
  document.getElementById("buttonRemoveExpensesCategoryAccept")
  .addEventListener("click", async (event) => {
    event.preventDefault();

    let force = 'y';

    const inData = {
      id: id_to_delete,
      force: force
    }

    try { 
      const res = await fetch(`/Settings/deleteExpenseCategory`, {
          method: 'post',
          body: JSON.stringify(inData)
      })
      const data = await res.json();
      updateExpensesCategoryList(data);
      printFlashMessages(data);
    } catch (e) {
      console.log('ERROR: ', e);
    }
  });

  // Add Payment Method
  document.getElementById("buttonAddPaymentMethod")
  .addEventListener("click", async (event) => {
    event.preventDefault();

    let name = document.getElementById("floatingAddCatNamePayment").value;

    const inData = { name: name };

    try { 
      const res = await fetch(`/Settings/addPaymentMethod`, {
          method: 'post',
          body: JSON.stringify(inData)
      })
      const data = await res.json();
      updatePaymentMethodsList(data);
      document.getElementById("floatingAddCatNamePayment").value = '';
      printFlashMessages(data);
    } catch (e) {
      console.log('ERROR: ', e);
    }
  });

  // Select row from table
  document.getElementById("tablePaymentMethods")
  .addEventListener("click", function(ele) {

    if( ele.srcElement.cellIndex < 2 ) {
      return;
    } else if (ele.target.className === "icon-trash") {
      table_row = ele.target.parentNode.parentNode.parentNode;
      document.getElementById("floatingRemCatNamePayment").value = table_row.cells[0].textContent;
    } else if (ele.target.className === "icon-pencil") {
      table_row = ele.target.parentNode.parentNode.parentNode;
      document.getElementById("floatingChgCatNamePaymentCurrent").value = table_row.cells[0].textContent;
    } else if (ele.target.childNodes[1].childNodes[1].className === "icon-trash") {
      table_row = ele.target.parentNode;
      document.getElementById("floatingRemCatNamePayment").value = table_row.cells[0].textContent;
    } else if (ele.target.childNodes[1].childNodes[1].className === "icon-pencil") {
      table_row = ele.target.parentNode;
      document.getElementById("floatingChgCatNamePaymentCurrent").value = table_row.cells[0].textContent;
    }

  });

  // Edit Payment Method
  document.getElementById("buttonUpdatePaymentMethod")
  .addEventListener("click", async (event) => {
    event.preventDefault();
    
    let id = table_row.cells[1].textContent;
    let name = document.getElementById("floatingChgCatNamePayment").value;

    let inData = {
      id: id,
      name: name
    };

    try { 
      const res = await fetch(`/Settings/updatePaymentMethod`, {
          method: 'post',
          body: JSON.stringify(inData)
      })
      const data = await res.json();
      updatePaymentMethodsList(data);
      document.getElementById("floatingChgCatNamePayment").value = '';
      printFlashMessages(data);
    } catch (e) {
      console.log('ERROR: ', e);
    }
  });

  // Remove Payment Method
  // Check if removal category has transaction assigned, if not remove, if yes display confirmation
  document.getElementById("buttonRemovePaymentMethod")
  .addEventListener("click", async (event) => {
    event.preventDefault();

    id_to_delete = table_row.cells[1].textContent;
    let force = 'n';

    const inData = {
      id: id_to_delete,
      force: force
    }

    try { 
      const res = await fetch(`/Settings/deletePaymentMethod`, {
          method: 'post',
          body: JSON.stringify(inData)
      })
      const data = await res.json();
      updatePaymentMethodsList(data);
      printFlashMessages(data);
      if(data.flash_message_type[0] === 'warning')
      {
        $("#modalRemCatNamePaymentAccept").modal('show');
        document.getElementById("modalRemCatNamePaymentAcceptNote").innerHTML = `kategoria: "${data.category_name}" zawiera: (${data.transactions}) transakcj${polishEnding(data.transactions)}, usunięcie kategorii spowoduje również usunięcie tych tansakcji!`;
      }
    } catch (e) {
      console.log('ERROR: ', e);
    }
  });

  // If removal category has transaction assigned, confirm removal
  document.getElementById("buttonRemovePaymentMethodAccept")
  .addEventListener("click", async (event) => {
    event.preventDefault();

    let force = 'y';

    const inData = {
      id: id_to_delete,
      force: force
    }

    try { 
      const res = await fetch(`/Settings/deletePaymentMethod`, {
          method: 'post',
          body: JSON.stringify(inData)
      })
      const data = await res.json();
      updatePaymentMethodsList(data);
      printFlashMessages(data);
    } catch (e) {
      console.log('ERROR: ', e);
    }
  });
}
