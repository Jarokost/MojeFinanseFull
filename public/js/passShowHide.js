/**
 * change button text, and input type depending on button state
 * 
 *  @param {string} buttonId - has to be the same name as input id with appended "Btn" or any 3 letters
 */
function passShowHide(buttonId) {
    let passwordInputId = buttonId.slice(0, buttonId.length-3);

    let passwordInput = document.getElementById(passwordInputId);
    if (passwordInput.type == "password") passwordInput.type = "text";
    else passwordInput.type = "password";
    
    let button = document.getElementById(buttonId);
    if (button.innerHTML == "Pokaż") button.innerHTML = "Ukryj";
    else button.innerHTML = "Pokaż";
}