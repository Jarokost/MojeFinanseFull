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
    if (limitForCategory === null || limitForCategory === false) {
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
    if (categoryHasLimit === true) {
        difference = limitForCategory - expensesSumForCategory - inputValue;
        document.getElementById("limitDisplayAmountInput").textContent = `Pozostałe środki w ramach limitu: ${difference} [PLN]`;
    } else {
        difference = 0;
        document.getElementById("limitDisplayAmountInput").textContent = '';
    }
    if (difference < 0) {
        document.getElementById("limitDisplayAmountInput").classList.remove("text-white");
        document.getElementById("limitDisplayAmountInput").classList.add("text-warning");
    } else {
        document.getElementById("limitDisplayAmountInput").classList.remove("text-warning");
        document.getElementById("limitDisplayAmountInput").classList.add("text-white");
    }
}

async function redisplayAll() {
    await displayLimitForCategory();
    displayMonthlyExpensesForCategory();
    displayLimitOnInputChange();
}

const modalOverlimitAccept = new bootstrap.Modal('#modalOverlimitAccept', {
    keyboard: false
});

document.getElementById("floatingDate").addEventListener('change', redisplayAll);

document.getElementById("floatingSelect").addEventListener('change', redisplayAll);

document.getElementById("floatingInputKwota").addEventListener('input', redisplayAll);

document.getElementById("formAddExpense").addEventListener('submit', async (event) => {
    if (!validateNewExpenseFormOnSubmit()) {
        event.preventDefault();
    } else {
        if (difference < 0) {
        event.preventDefault();
        document.getElementById("floatingInputKwotaHidden").value =
        document.getElementById("floatingInputKwota").value;
        document.getElementById("floatingDateHidden").value =
        document.getElementById("floatingDate").value;
        document.getElementById("floatingSelectHidden").value =
        document.getElementById("floatingSelect").value;
        document.getElementById("floatingSelectMethodHidden").value =
        document.getElementById("floatingSelectMethod").value;
        document.getElementById("floatingTextareaHidden").value =
        document.getElementById("floatingTextarea").value;
        modalOverlimitAccept.show();
        }
    }
});
 