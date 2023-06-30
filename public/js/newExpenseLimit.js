let categoryHasLimit;
let limitForCategory;
let expensesSumForCategory;

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

document.getElementById("floatingDate").addEventListener('change', displayMonthlyExpensesForCategory);

document.getElementById("floatingSelect").addEventListener('change', function() {
    displayLimitForCategory();
    displayMonthlyExpensesForCategory();
});