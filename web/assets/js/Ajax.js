/**
 * Ajax class.
 *
 * @Project : Pharma-Prospection
 * @File    : web/assets/js/Form.js
 * @Version : 1.2
 * @Author  : BOULFROY Nicolas
 * @Create  : 2018/03/15
 * @Update  : 2018/03/22
 */

/**
 * Ajax class constructor.
 *
 * @param {ActiveX.IXMLDOMElement} form - class of
 * @param {null|string} modal - modal class
 * @param {string} method - method attribute value of the form
 * @param {string} url - action attribute value of the form
 * @param {*} data - FormData
 * @param {ActiveX.IXMLDOMElement} dataClass - where the data must be added
 * @param {null|string} type - what use case is used to implement data in HTML template
 * @param {null|string} link - the <a></a> href content attribute
 * @constructor
 */
function Ajax(modal = null, form, method, url, data, dataClass, type = null, link = null) {
    this.modal = modal;
    this.form = form;
    this.method = method;
    this.url = url;
    this.data = data;
    this.dataClass = dataClass;
    this.type = type;
    this.link = link;
    this._query();
}

/**
 * Creates an AJAX object.
 *
 * @returns {XMLHttpRequest|ActiveXObject}
 * @private
 */
Ajax.prototype._createRequest = function() {
    if (window.XMLHttpRequest) {
        return new XMLHttpRequest();
    } else {
        if (window.ActiveXObject('Msxm12.XMLHTTP')) {
            return new ActiveXObject('Msxml2.XMLHTTP');
        } else {
            return new ActiveXObject('Microsoft.XMLHTTP');
        }
    }
};

/**
 * Manages displaying if the AJAX request has been a success status.
 *
 * @param {HTMLDivElement} div - where the message must be added in HTML page
 * @private
 */
Ajax.prototype._displayMessageSuccess = function(div) {
    div.setAttribute('class', 'alert alert-dismissible alert-success text-center');

    let button = document.createElement('button');
    button.setAttribute('type', 'button');
    button.setAttribute('class', 'close');
    button.setAttribute('data-dismiss', 'alert');
    button.innerHTML = '&times;';
    div.appendChild(button);

    let span = document.createElement('span');
    span.setAttribute('class', 'font-weight-bold');
    span.innerHTML = 'Success:';
    div.appendChild(span);

    div.insertAdjacentText('beforeend', ' your new expense account has been added successfully.');
};

/**
 * Manages displaying if the AJAX request has been an error status.
 *
 * @param {HTMLDivElement} div - where the message must be added in HTML page
 * @private
 */
Ajax.prototype._displayMessageError = function(div) {
    div.setAttribute('class', 'alert alert-dismissible alert-danger text-center');

    let button = document.createElement('button');
    button.setAttribute('type', 'button');
    button.setAttribute('class', 'close');
    button.setAttribute('data-dismiss', 'alert');
    button.innerHTML = '&times;';
    div.appendChild(button);

    let span = document.createElement('span');
    span.setAttribute('class', 'font-weight-bold');
    span.innerHTML = 'Error:';
    div.appendChild(span);

    div.insertAdjacentText('beforeend', ' an error has occurred. If this happens again, contact the support.');
};

/**
 * Manages displaying about the AJAX request at the top of the template.
 *
 * @param {string} type - the response type (success / warning)
 * @private
 */
Ajax.prototype._displayMessage = function(type) {
    let parent = document.getElementsByClassName('message')[0];
    parent.innerHTML = '';

    let div = document.createElement('div');

    switch(type) {
        case 'success':
            document.getElementsByClassName('emptyData')[0].innerHTML = '';
            Ajax.prototype._displayMessageSuccess(div);
            parent.appendChild(div);
            break;
        case 'error':
            Ajax.prototype._displayMessageError(div);
            parent.appendChild(div);
            break;
    }

    return div;
};

/**
 *
 *
 * @param {ActiveX.IXMLDOMElement} dataClass - where the new data must be added
 * @param {JSON} response - data from AJAX request
 * @param {int} max - maximum of elements in json
 * @private
 */
Ajax.prototype._displayTable = function(dataClass, response, max) {
    let td = document.createElement('tr');
    let element;

    for (let i = 0; i < max; i++) {
        let element = document.createElement('td');

        element.innerHTML = response.data[i];
        td.appendChild(element);
    }

    dataClass.appendChild(td);
};

/**
 *
 *
 * @param {ActiveX.IXMLDOMElement} dataClass - where the new data must be added
 * @param {JSON} response - data from AJAX request
 * @param {int} max - maximum of elements in json
 * @param {string} href - for href <a></a> HTML element
 * @private
 */
Ajax.prototype._displayTableDetail = function(dataClass, response, max, href) {
    let td = document.createElement('tr');

    for (let i = 0; i < max; i++) {
        let element = document.createElement('td');

        if (i < (max - 1)) {
            element.innerHTML = response.data[i];
        } else {
            let link = document.createElement('a');
            let url = href + '/' + response.data[i];

            link.setAttribute('class', 'btn btn-primary');
            link.innerHTML = 'Details';
            link.setAttribute('href', url);

            element.appendChild(link);
        }

        td.appendChild(element);
    }

    dataClass.appendChild(td);
};

/**
 * Displays response in template.
 *
 * @param {ActiveX.IXMLDOMElement} dataClass - where the new data must be added
 * @param {JSON} response - response returns by AJAX request
 * @param {string} type - type of HTML generation (simple table, table with detail button, table with delete button)
 * @param {null|string} link - for href <a></a> HTML element
 * @private
 */
Ajax.prototype._displayResponse = function(dataClass, response, type, link) {
    let max = response.data.length;

    switch (type) {
        default:
            break;
        case 'tableDetail':
            Ajax.prototype._displayTableDetail(dataClass, response, max, link);
            break;
        case 'tableDelete':
            break;
    }
};

Ajax.prototype._displayGoodData = function(form) {
    for (let i = 0; i < form.getElementsByTagName('input').length - 1; i++) {
        form.getElementsByTagName('input')[i].style.borderColor = '#d3d3d3';
    }
};

/**
 * Changes all inputs into the form.
 *
 * @param {ActiveX.IXMLDOMElement} form
 * @private
 */
Ajax.prototype._displayWrongData = function(form) {
    for (let i = 0; i < form.getElementsByTagName('input').length - 1; i++) {
        form.getElementsByTagName('input')[i].style.borderColor = 'red';
    }
};

/**
 * AJAX request senders.
 *
 * @private
 */
Ajax.prototype._query = function() {
    let request = this._createRequest();
    let form = this.form;
    let modal = this.modal;
    let method = this.method;
    let url = this.url;
    let data = this.data;
    let dataClass = this.dataClass;
    let type = this.type;
    let link = this.link;

    // Opens a connection.
    request.open(method, url);
    // Sets a header to the AJAX request.
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    // Sends the data to the url.
    request.send(data);

    request.onload = function() {
        if (request.status == 200) {
            // let response = JSON.parse(request.responseText);

            console.log(request.responseText);

            if (response.status != 'success') {
                // Displays wrong data.
                Ajax.prototype._displayWrongData(form);
            } else {
                // Resets the inputs form style.
                Ajax.prototype._displayGoodData(form);
                // Adds new data in the table.
                Ajax.prototype._displayResponse(dataClass, response, type, link);
                // Displays the message success at the top of the page.
                Ajax.prototype._displayMessage('success');
                // Closes modal.
                jQuery('#' + modal).modal('toggle');
            }
        } else {
            Ajax.prototype._displayMessage('error');
        }
    }
};