let categoryHasLimit;

document.getElementById("floatingSelect").addEventListener('change', function() {
    displayLimitForSelectedCategory();
    displayMonthlySpendingsOnSelectedCategory();
});

document.getElementById("floatingDate").addEventListener('change',  displayMonthlySpendingsOnSelectedCategory);

async function displayLimitForSelectedCategory() {

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
        if (data === null) {
            document.getElementById("limitDisplayForThisCategory").textContent = `Wybrana kategoria nie posiada limitu`;
            categoryHasLimit = false;
        } else {
            document.getElementById("limitDisplayForThisCategory").textContent = `Limit dla wybranej kategorii wynosi: ${data} [PLN]`;
            categoryHasLimit = true;
        }
    } catch (e) {
        console.log("ERROR: ", e);
    }
}

async function displayMonthlySpendingsOnSelectedCategory() {

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
        if (categoryHasLimit && data !== null) {
            document.getElementById("limitDisplayThisMonthSpent").textContent = `W wybranym miesiącu dla tej kategorii wydano: ${data} [PLN]`;
        } else if (categoryHasLimit && data === null) {
            document.getElementById("limitDisplayThisMonthSpent").textContent = `W wybranym miesiącu dla tej kategorii wydano: 0 [PLN]`;
        } else {
            document.getElementById("limitDisplayThisMonthSpent").textContent = ``;
        }
    } catch (e) {
        console.log("ERROR: ", e);
    }
}