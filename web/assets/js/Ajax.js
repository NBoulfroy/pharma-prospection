/**
 * Ajax class.
 *
 * @Project : Pharma-Prospection
 * @File    : web/assets/js/Form.js
 * @Version : 1.0
 * @Author  : BOULFROY Nicolas
 * @Create  : 2018/03/15
 */

/**
 * Ajax class constructor.
 *
 * @param {string} method
 * @param {string} url
 * @param {*} data
 * @param {ActiveX.IXMLDOMElement} dataClass
 * @constructor
 */
function Ajax(method, url, data, dataClass) {
    this.method = method;
    this.url = url;
    this.data = data;
    this.dataClass = dataClass;
    this._query();
}

/**
 * Creates an AJAX object.
 *
 * @returns {*}
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
 * @param {ActiveX.IXMLDOMElement} div
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
 * @param {ActiveX.IXMLDOMElement} div
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
 * @param {string} type
 * @private
 */
Ajax.prototype._displayMessage = function(type) {
    let parent = document.getElementsByClassName('message')[0];
    parent.innerHTML = '';

    let div = document.createElement('div');

    switch(type) {
        case 'success':
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
 * Displays response in template.
 *
 * @param {ActiveX.IXMLDOMElement} dataClass
 * @param {string} response
 * @private
 */
Ajax.prototype._displayResponse = function(dataClass, response) {
    dataClass.insertAdjacentHTML('beforeend', response);
};

Ajax.prototype._query = function() {
    let request = this._createRequest();
    let method = this.method;
    let url = this.url;
    let data = this.data;
    let dataClass = this.dataClass;

    // Opens a connection.
    request.open(method, url);
    // Sets a header to the AJAX request.
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    // Sends the data to the url.
    request.send(data);

    request.onload = function() {
        // Succes
        if (request.status == 200) {
            Ajax.prototype._displayResponse(dataClass, request.responseText);
            Ajax.prototype._displayMessage('success');
        } else {
            Ajax.prototype._displayMessage('success');
        }
    }
};