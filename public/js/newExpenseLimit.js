document.getElementById("floatingSelect").addEventListener('change', async (event) => {

    const category_id = event.target.value;

    const inData = { category_id: category_id };

    try {
        const res = await fetch(`/Expenses/limit`, {
            method: 'post',
            body: JSON.stringify(inData)
        });
        const data = await res.json();
        console.log(data);
        if (data === null) {
            document.getElementById("limitDisplayForThisCategory").textContent = `Wybrana kategoria nie posiada limitu`;
        } else {
            document.getElementById("limitDisplayForThisCategory").textContent = `Limit dla wybranej kategorii wynosi: ${data} [PLN]`;
        }
    } catch (e) {
        console.log("ERROR: ", e);
    }
});