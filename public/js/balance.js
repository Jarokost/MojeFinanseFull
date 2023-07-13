let tr = null;
let tr_expanded = null;
let expenses_categories_sum_table = [["Wydatki", "Wartość"]];
let incomes_categories_sum_table = [["Przychody", "Wartość"]];
let chart_expenses = null;
let chart_incomes = null;
let chart_data_expenses = null;
let chart_data_incomes = null;
let chart_options_expenses = null;
let chart_options_incomes = null;
const graphIncomesDivElement = document.getElementById("incomesDonutChart");
const graphExpensesDivElement = document.getElementById("expensesDonutChart");
const incomesTableWrapper = document.createElement("div");
incomesTableWrapper.setAttribute("class", "d-flex justify-content-center");
const incomesChartWrapper = document.createElement("div");
incomesChartWrapper.setAttribute("class", "d-flex justify-content-center");
const expensesTableWrapper = document.createElement("div");
expensesTableWrapper.setAttribute("class", "d-flex justify-content-center");
const expensesChartWrapper = document.createElement("div");
expensesChartWrapper.setAttribute("class", "d-flex justify-content-center");

function drawChartIncomes() {
  chart_data_incomes = google.visualization.arrayToDataTable(incomes_categories_sum_table);

  chart_options_incomes = {
    title: "Przychody",
    titleTextStyle: {
      // color: <string>,    // any HTML string color ('red', '#cc00cc')
      // fontName: <string>, // i.e. 'Times New Roman'
      fontSize: 18, // 12, 18 whatever you want (don't specify px)
      // bold: <boolean>,    // true or false
      // italic: <boolean>   // true of false
    },
    pieHole: 0.3,
    //legend: "none",
    legend: {position: 'top', maxLines: 10, textStyle: {color: 'black', fontSize: 16}},
    backgroundColor: "transparent",
    width: 450,
    height: 450,
    fontSize: 18
  };

  chart_incomes = new google.visualization.PieChart(
    document.getElementById("incomesDonutChart")
  );
  //chart_incomes.draw(chart_data_incomes, chart_options_incomes); //draw graphs on load
}

function drawChartExpenses() {
  chart_data_expenses = google.visualization.arrayToDataTable(expenses_categories_sum_table);

  chart_options_expenses = {
    title: "Wydatki",
    titleTextStyle: {
      // color: <string>,    // any HTML string color ('red', '#cc00cc')
      // fontName: <string>, // i.e. 'Times New Roman'
      fontSize: 18, // 12, 18 whatever you want (don't specify px)
      // bold: <boolean>,    // true or false
      // italic: <boolean>   // true of false
    },
    pieHole: 0.3,
    //legend: "none",
    legend: {position: 'top', maxLines: 10, textStyle: {color: 'black', fontSize: 16}},
    backgroundColor: "transparent",
    width: 450,
    height: 450,
    fontSize: 18
  };

  chart_expenses = new google.visualization.PieChart(
    document.getElementById("expensesDonutChart")
  );
  //chart_expenses.draw(chart_data_expenses, chart_options_expenses); //darw graph on load
}

function setSelectByText(eID,text)
{
  let ele=document.getElementById(eID);
  for(let ii=0; ii<ele.length; ii++)
    if(ele.options[ii].text==text) {
      ele.options[ii].selected=true;
      return true;
    }
  return false;
}

function wrap(el, wrapper) {
  el.parentNode.insertBefore(wrapper, el);
  wrapper.appendChild(el);
}

function updateBalanceData(data)
{
  const balance = data.incomes_sum.amount_sum - data.expenses_sum.amount_sum;
  const balanceElement = document.getElementById("updateBalanceData");
  balanceElement.textContent = parseFloat(balance).toFixed(2);
  if (balance > 0) {
    balanceElement.classList.add("balance_plus");
    balanceElement.classList.remove("balance_minus");
  } else {
    balanceElement.classList.remove("balance_plus");
    balanceElement.classList.add("balance_minus");
  }
}

const updateIncomesGraphData = async () => {

  const date_start = document.getElementById("balanceDateStart").textContent;
  const date_end = document.getElementById("balanceDateEnd").textContent;

  const inData = {
    date_start: date_start,
    date_end: date_end
  };

  try { 
    const res = await fetch(`/Balance/getIncomesSumGroupedByCategory`, {
        method: 'post',
        body: JSON.stringify(inData)
    })
    const data = await res.json();

    incomes_categories_sum_table = [["Przychody", "Wartość"]];
    for(let i=0; i < data.incomes_category_sum.length; i++) {
      incomes_categories_sum_table.push([data.incomes_category_sum[i].category_name, parseFloat(data.incomes_category_sum[i].category_amount_sum)]);
    }
    chart_data_incomes = google.visualization.arrayToDataTable(incomes_categories_sum_table);
    chart_incomes.draw(chart_data_incomes, chart_options_incomes);

  } catch (e) {
      console.log('ERROR: ', e);
  }

}

const updateExpensesGraphData = async () => {

  const date_start = document.getElementById("balanceDateStart").textContent;
  const date_end = document.getElementById("balanceDateEnd").textContent;

  const inData = {
    date_start: date_start,
    date_end: date_end
  };

  try { 
    const res = await fetch(`/Balance/getExpensesSumGroupedByCategory`, {
        method: 'post',
        body: JSON.stringify(inData)
    })
    const data = await res.json();

    expenses_categories_sum_table = [["Wydatki", "Wartość"]];
    for(let i=0; i < data.expenses_category_sum.length; i++) {
      expenses_categories_sum_table.push([data.expenses_category_sum[i].category_name, parseFloat(data.expenses_category_sum[i].category_amount_sum)]);
    }
    chart_data_expenses = google.visualization.arrayToDataTable(expenses_categories_sum_table);
    chart_expenses.draw(chart_data_expenses, chart_options_expenses);

  } catch (e) {
      console.log('ERROR: ', e);
  }

}

google.charts.load("current", { packages: ["corechart"] });

window.addEventListener('load', function () {

  if ( graphIncomesDivElement !== null ) {
    
    google.charts.setOnLoadCallback(drawChartIncomes);

    updateIncomesGraphData();

    document.getElementById("formEditIncome").addEventListener("submit", (event) => {event.preventDefault()});
    document.getElementById("formRemoveIncome").addEventListener("submit", (event) => {event.preventDefault()});

    // make modal inputs validation when displayed, to clear validation errors, remove event listener on input change
    document.getElementById("modalEditIncome").addEventListener("shown.bs.modal", function() {
      document.getElementById("editIncomeAmount").removeEventListener('input', function() {});
      document.getElementById("editIncomeDate").removeEventListener('input', function() {});
      document.getElementById("editIncomeCategory").removeEventListener('input', function() {});
      validateEditIncomeFormOnSubmit();
    });

    // Edit Income
    document.getElementById("tableIncomes")
    .addEventListener("click", function(ele) {

      if (ele.target.className === "icon-pencil") {

        tr = ele.target.parentNode.parentNode.parentNode;

        let id = tr.cells[1].textContent;
        let date = tr.cells[2].textContent;
        let category = tr.cells[3].textContent;
        let comment = tr.cells[4].textContent;
        let amount = tr.cells[5].textContent;

        document.getElementById("editIncomeId").value = id;
        document.getElementById("editIncomeAmount").value = amount;
        document.getElementById("editIncomeDate").value = date;
        document.getElementById("editIncomeComment").value = comment;
        setSelectByText("editIncomeCategory", category);

      }

    });

    document.querySelector("button.button-income-change")
    .addEventListener("click", async () => {

      if ( validateEditIncomeFormOnSubmit() ) {

        $("#modalEditIncome").modal("hide");

        let id = document.getElementById("editIncomeId").value;
        let amount = document.getElementById("editIncomeAmount").value;
        let date_of_income = document.getElementById("editIncomeDate").value;
        let income_category_assigned_to_user_id = document.getElementById("editIncomeCategory").value;
        let income_comment = document.getElementById("editIncomeComment").value;
        let date_start = document.getElementById("balanceDateStart").textContent;
        let date_end = document.getElementById("balanceDateEnd").textContent;

        const inData = {
          id: id,
          amount: amount,
          date_of_income: date_of_income,
          income_category_assigned_to_user_id: income_category_assigned_to_user_id,
          income_comment: income_comment,
          date_start: date_start,
          date_end: date_end
        }

        try {
          const res = await fetch(`/Incomes/updateTableRowAjax`, {
              method: 'post',
              body: JSON.stringify(inData)
          })
          const data = await res.json();
          if (data.success == false) {
            alert(data.errors);
          } else {
            tr.cells[1].textContent = id;
            tr.cells[2].textContent = date_of_income;
            const categorySelect = document.getElementById("editIncomeCategory");
            tr.cells[3].textContent = categorySelect.options[categorySelect.selectedIndex].text;
            tr.cells[4].textContent = income_comment;
            tr.cells[5].textContent = parseFloat(amount).toFixed(2);

            updateBalanceData(data);
            updateIncomesGraphData();
          }
        } catch (e) {
          console.log('ERROR: ', e);
        }
      }
    });

    // Remove Income
    document.getElementById("tableIncomes")
    .addEventListener("click", function(ele) {

      if (ele.target.className === "icon-trash") {

        tr = ele.target.parentNode.parentNode.parentNode;

        let id = tr.cells[1].textContent;
        let date = tr.cells[2].textContent;
        let category = tr.cells[3].textContent;
        let comment = tr.cells[4].textContent;
        let amount = tr.cells[5].textContent;

        document.getElementById("removeIncomeId").value = id;

        document.getElementById("incomeRowToRemove").innerHTML = 
          "data: " + date
          + "</br>kategoria: " + category
          + "</br>opis: " + comment
          + "</br>kwota: " + amount;

      }

    });

    document.querySelector("button.button-income-remove")
    .addEventListener("click", async () => {

    let id = document.getElementById("removeIncomeId").value;
    let date_start = document.getElementById("balanceDateStart").textContent;
    let date_end = document.getElementById("balanceDateEnd").textContent;

    const inData = {
      id: id,
      date_start: date_start,
      date_end: date_end
    }

    try {
      const res = await fetch(`/Incomes/removeTableRowAjax`, {
        method: "post",
        body: JSON.stringify(inData)
      });
      const data = await res.json();
      tr.remove();
      let index = 1;
      const table_expenses = document.querySelectorAll("tr.expense-item-in-expenses-table");
      const table_incomes = document.querySelectorAll("tr.income-item-in-incomes-table");
      if ( table_incomes.length > 0 ) {
        for ( let i=0; i<table_incomes.length; i++) {
          table_incomes[i].cells[0].textContent = index;
          index++;
        }
      } else {
        if ( table_expenses.length > 0 ) {
          document.getElementById("summary").insertAdjacentHTML( "afterend", `
          <div class="summary-description h5 w-100 text-center py-3 mt-3">
            Brak wydatków w danym okresie czasu
          </div>
          `);

          wrap( document.getElementById("expensesDonutChartDiv"), incomesChartWrapper );
          wrap( document.getElementById("tableExpensesDiv"), incomesTableWrapper );

          document.getElementById("incomesDonutChartDiv").remove();
          document.getElementById("tableIncomesDiv").remove();
        } else {
          document.querySelector(".summary-description").remove();
          document.getElementById("summary").insertAdjacentHTML( "afterend", `
          <div class="summary-description h5 w-100 text-center py-3 mt-3">
            Brak zarejestrowanych transakcji w danym okresie czasu
          </div>
          `);

          document.getElementById("incomesDonutChartDiv").remove();
          document.getElementById("tableIncomesDiv").remove();
        }
      }
      updateBalanceData(data);
      updateIncomesGraphData();
    } catch (e) {
      console.log('ERROR: ', e);
    }
    });

  }

  if ( graphExpensesDivElement !== null ) {

    google.charts.setOnLoadCallback(drawChartExpenses);

    updateExpensesGraphData();

    document.getElementById("formEditExpense").addEventListener("submit", (event) => {event.preventDefault()});
    document.getElementById("formRemoveExpense").addEventListener("submit", (event) => {event.preventDefault()});

    // make modal inputs validation when displayed, to clear validation errors, remove event listener on input change
    document.getElementById("modalEditExpense").addEventListener("shown.bs.modal", function() {
      document.getElementById("editExpenseAmount").removeEventListener('input', function() {});
      document.getElementById("editExpenseDate").removeEventListener('input', function() {});
      document.getElementById("editExpenseCategory").removeEventListener('input', function() {});
      document.getElementById("editExpenseMethod").removeEventListener('input', function() {});
      validateEditExpenseFormOnSubmit();
    });

    // Edit Expense 
    document.getElementById("tableExpenses")
    .addEventListener("click", function(ele) {

      if (ele.target.className === "icon-pencil balance-btn-div-link") {

        tr_expanded = ele.target.parentNode.parentNode.parentNode;
        tr = tr_expanded.previousElementSibling;

        let id = tr.cells[1].textContent;
        let date = tr.cells[2].textContent;
        let category = tr.cells[3].textContent;
        let method = tr.cells[4].textContent;
        let comment = tr.cells[5].textContent;
        let amount = tr.cells[6].textContent;

        document.getElementById("editExpenseId").value = id;
        document.getElementById("editExpenseAmount").value = amount;
        document.getElementById("editExpenseDate").value = date;
        document.getElementById("editExpenseComment").value = comment;
        setSelectByText("editExpenseCategory", category);
        setSelectByText("editExpenseMethod", method);

      }

    });

    document.querySelector("button.button-expense-change")
    .addEventListener("click", async () => {

      if ( validateEditExpenseFormOnSubmit() ) {

        // const myModal = document.querySelector('#modalEditExpense');
        // const modal = new bootstrap.Modal(myModal);
        // modal.hide();// it is asynchronous
        $("#modalEditExpense").modal("hide");
        
        let id = document.getElementById("editExpenseId").value;
        let amount = document.getElementById("editExpenseAmount").value;
        let date_of_expense = document.getElementById("editExpenseDate").value;
        let expense_category_assigned_to_user_id = document.getElementById("editExpenseCategory").value;
        let payment_method_assigned_to_user_id = document.getElementById("editExpenseMethod").value;
        let expense_comment = document.getElementById("editExpenseComment").value;
        let date_start = document.getElementById("balanceDateStart").textContent;
        let date_end = document.getElementById("balanceDateEnd").textContent;

        const inData = {
          id: id,
          amount: amount,
          date_of_expense: date_of_expense,
          expense_category_assigned_to_user_id: expense_category_assigned_to_user_id,
          payment_method_assigned_to_user_id: payment_method_assigned_to_user_id,
          expense_comment: expense_comment,
          date_start: date_start,
          date_end: date_end
        };

        try { 
          const res = await fetch(`/Expenses/updateTableRowAjax`, {
              method: 'post',
              body: JSON.stringify(inData)
          })
          const data = await res.json();
          if (data.success == false) {
            alert(data.errors);
          } else {
            tr.cells[1].textContent = id;
            tr.cells[2].textContent = date_of_expense;
            const categorySelect = document.getElementById("editExpenseCategory");
            tr.cells[3].textContent = categorySelect.options[categorySelect.selectedIndex].text;
            const methodSelect = document.getElementById("editExpenseMethod");
            tr.cells[4].textContent = methodSelect.options[methodSelect.selectedIndex].text;
            tr.cells[5].textContent = expense_comment;
            tr.cells[6].textContent = parseFloat(amount).toFixed(2);

            document.querySelector(`#${tr_expanded.id} .method`).textContent = tr.cells[4].textContent;
            document.querySelector(`#${tr_expanded.id} .comment`).textContent = tr.cells[5].textContent;
            
            updateBalanceData(data);
            updateExpensesGraphData();
          }
        } catch (e) {
          console.log('ERROR: ', e);
        }
      }
    });

    // Remove Expense
    document.getElementById("tableExpenses")
    .addEventListener("click", function(ele) {

      if (ele.target.className === "icon-trash balance-btn-div-link") {

        tr_expanded = ele.target.parentNode.parentNode.parentNode;
        tr = tr_expanded.previousElementSibling;

        let id = tr.cells[1].textContent;
        let date = tr.cells[2].textContent;
        let category = tr.cells[3].textContent;
        let method = tr.cells[4].textContent;
        let comment = tr.cells[5].textContent;
        let amount = tr.cells[6].textContent;

        document.getElementById("removeExpenseId").value = id;

        document.getElementById("expenseRowToRemove").innerHTML = 
          "data: " + date 
          + "</br>kategoria: " + category
          + "</br>metada płatności: " + method
          + "</br>opis: " + comment
          + "</br>kwota: " + amount;

      }

    });

    document.querySelector("button.button-expense-remove")
    .addEventListener("click", async () => {

      let id = document.getElementById("removeExpenseId").value;
      let date_start = document.getElementById("balanceDateStart").textContent;
      let date_end = document.getElementById("balanceDateEnd").textContent;

      const inData = {
        id: id,
        date_start: date_start,
        date_end: date_end
      };

      try {
        const res = await fetch(`/Expenses/removeTableRowAjax`, {
          method: "post",
          body: JSON.stringify(inData)
        })
        const data = await res.json();
        tr.remove();
        tr_expanded.remove();
        let index = 1;
        const table_expenses = document.querySelectorAll("tr.expense-item-in-expenses-table");
        const table_incomes = document.querySelectorAll("tr.income-item-in-incomes-table");
        if ( table_expenses.length > 0 ) {
          for ( let i=0; i<table_expenses.length; i++) {
            table_expenses[i].cells[0].textContent = index;
            index++;
          }
        } else {
          if ( table_incomes.length > 0 ) {
            document.getElementById("summary").insertAdjacentHTML( "afterend", `
            <div class="summary-description h5 w-100 text-center py-3 mt-3">
              Brak wydatków w danym okresie czasu
            </div>
            `);

            wrap( document.getElementById("incomesDonutChartDiv"), expensesChartWrapper );
            wrap( document.getElementById("tableIncomesDiv"), expensesTableWrapper );

            document.getElementById("expensesDonutChartDiv").remove();
            document.getElementById("tableExpensesDiv").remove();
          } else {
            document.querySelector(".summary-description").remove();
            document.getElementById("summary").insertAdjacentHTML( "afterend", `
            <div class="summary-description h5 w-100 text-center py-3 mt-3">
              Brak zarejestrowanych transakcji w danym okresie czasu
            </div>
            `);

            document.getElementById("expensesDonutChartDiv").remove();
            document.getElementById("tableExpensesDiv").remove();
          }
        }
        updateBalanceData(data);
        updateExpensesGraphData();
      } catch (e) {
        console.log('ERROR: ', e);
      }
    });

  }

})
