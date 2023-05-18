/**
 * Add jQuery Validation plugin method for a valid password
 *
 * Valid passwords contain at least one letter and one number.
 */
$.validator.addMethod('validPassword',
function(value, element, param) {

    if (value != '') {
        if (value.match(/.*[a-z]+.*/i) == null) {
            return false;
        }
        if (value.match(/.*\d+.*/) == null) {
            return false;
        }
    }

    return true;
},
'Hasło musi zawierać jedną literę i jedną liczbę'
);

$.validator.addMethod('validCategory',
function(value, element, param) {

    if (value != '') {
        if (value === 'wybierz' ) {
            return false;
        }
    }

    return true;
},
'Wybierz kategorię'
);