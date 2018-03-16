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
 * @constructor
 */
function Ajax(method, url, data) {
    this.method = method;
    this.url = url;
    this.data = data;
    this._query();
}

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

Ajax.prototype._query = function() {
    let request = this._createRequest();
    let method = this.method;
    let url = this.url;
    let data = this.data;

    // Opens a connection.
    request.open(method, url);
    // Sets a header to the AJAX request.
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    // Sends the data to the url.
    request.send(data);

    request.onload = function() {
        // Succes
        if (request.status == 200) {
            // TODO : COMPLETE THE TREATMENT
            console.log(request.responseText);
        } else {
            console.log('An error has occurred. If this happens again, contact the support.');
        }
    }
};