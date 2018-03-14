/**
 * Javascript vanilla functions library.
 *
 * @Project : Pharma-Prospection
 * @File    : web/assets/js/library.js
 * @Author  : BOULFROY Nicolas
 * @Create  : 2018/03/14
 * @Update  :
 */

/**
 * Disables a button.
 *
 * @param {string} id
 */
function disabledButton(id) {
    document.getElementById(id).setAttribute('disabled', 'disabled');
}

/**
 * Prevents the default behaviour about forms.
 *
 * @param {string} id
 */
function preventSubmit(id) {
    document.getElementById(id).submit = function() {
        return false;
    }
}

/**
 * Resets a form.
 * TODO : NOT WORKING RECENTLY.
 *
 * @param {string} id
 */
function reset(id) {
    document.getElementById(id).reset();
}

/**
 * Controls the value passed in parameter and by his type passed in parameter by a regex and returns a boolean.
 *
 * @param {string} type
 * @param {int|string} value
 * @return {bool}
 */
function controlValue(type, value) {
    switch(type) {
        case 'int':
            return /^[0-9]{1,}$/g.test(value);
        case 'decimal':
            return /^[0-9]+(\.[0-9][0-9]?)?$/g.test(value);
    }
}

/**
 * Controls an input.
 *
 * @param {string} id
 * @param {string} inputGroup
 * @param {string} type
 */
function controlInput(id, inputGroup, type) {
    // Gets the value of the selected input passed in function's parameter.
    let value = document.getElementById(id).value;

    // Controls the value.
    if (!controlValue(type, value)) {
        document.getElementById('save').setAttribute('disabled', 'disabled');
    } else {
        document.getElementById('save').removeAttribute('disabled');
    }
}