let categoryHasLimit;
let limitForCategory;
let expensesSumForCategory;
let difference;

async function getLimitForCategory() {

    const category_id = document.getElementById("floatingSelect").value;

    const inData = { 
        category_id: category_id 
    };

    try {
        const res = await fetch(`/Expenses/limit`, {
            method: 'post',
            body: JSON.stringify(inData)
        });
        const data = await res.json();
        return data;
    } catch (e) {
        console.log("ERROR: ", e);
    }
}

async function getExpsensesSumForCategory() {

    const category_id = document.getElementById("floatingSelect").value;
    const date = document.getElementById("floatingDate").value;

    const inData = { 
        category_id: category_id,
        date: date
    };

    try {
        const res = await fetch(`/Expenses/categorySum`, {
            method: 'post',
            body: JSON.stringify(inData)
        });
        const data = await res.json();
        return data;
    } catch (e) {
        console.log("ERROR: ", e);
    }
}

async function displayLimitForCategory() {
    limitForCategory = await getLimitForCategory();
    if (limitForCategory === null) {
        document.getElementById("limitDisplayForThisCategory").textContent = `Wybrana kategoria nie posiada limitu`;
        categoryHasLimit = false;
    } else {
        document.getElementById("limitDisplayForThisCategory").textContent = `Limit dla wybranej kategorii wynosi: ${limitForCategory} [PLN]`;
        categoryHasLimit = true;
    }
}

async function displayMonthlyExpensesForCategory() {
    expensesSumForCategory = await getExpsensesSumForCategory();
    if (categoryHasLimit && expensesSumForCategory !== null) {
        document.getElementById("limitDisplayThisMonthSpent").textContent = `W wybranym miesiącu dla tej kategorii wydano: ${expensesSumForCategory} [PLN]`;
    } else if (categoryHasLimit && expensesSumForCategory === null) {
        document.getElementById("limitDisplayThisMonthSpent").textContent = `W wybranym miesiącu dla tej kategorii wydano: 0 [PLN]`;
    } else {
        document.getElementById("limitDisplayThisMonthSpent").textContent = ``;
    }
}

async function displayLimitOnInputChange() {
    expensesSumForCategory = await getExpsensesSumForCategory();
    let inputValue = document.getElementById("floatingInputKwota").value;
    difference = limitForCategory - expensesSumForCategory - inputValue;
    document.getElementById("limitDisplayAmountInput").textContent = `Pozostałe środki w ramach limitu: ${difference} [PLN]`;
    if (difference < 0) {
        document.getElementById("limitDisplayAmountInput").classList.add("text-warning");
    } else {
        document.getElementById("limitDisplayAmountInput").classList.remove("text-warning");
    }
}

async function redisplayAll() {
    await displayLimitForCategory();
    displayMonthlyExpensesForCategory();
    if (categoryHasLimit) {
        displayLimitOnInputChange();
    }
}

document.getElementById("floatingDate").addEventListener('change', redisplayAll);

document.getElementById("floatingSelect").addEventListener('change', redisplayAll);

document.getElementById("floatingInputKwota").addEventListener('input', redisplayAll);

document.getElementById("formAddExpense").addEventListener('submit', async (event) => {
    if (difference < 0) {
      event.preventDefault();
    }
});
 