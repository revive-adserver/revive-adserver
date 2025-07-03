(function (doc, win) {
    var ID = "<?php echo $etag; ?>";

    win.reviveAsync = win.reviveAsync || {};

    /*
     * IE backwards compatibility
     */
    (function (w) {

        if ( typeof w.CustomEvent === "function" ) return false;

        function CustomEvent ( event, params ) {
            params = params || { bubbles: false, cancelable: false, detail: undefined };
            var evt = document.createEvent( 'CustomEvent' );
            evt.initCustomEvent( event, params.bubbles, params.cancelable, params.detail );
            return evt;
        }

        CustomEvent.prototype = w.Event.prototype;

        w.CustomEvent = CustomEvent;
    })(win);

    try {
        if (!win.reviveAsync.hasOwnProperty(ID)) {
            var rv = win.reviveAsync[ID] = {
                id: Object.keys(win.reviveAsync).length,
                name: "<?php echo $product; ?>",
                seq: 0,

                /**
                 * Initialise the async delivery mechanism.
                 */
                main: function () {
                    var domCallback = function () {
                        var done = false;

                        try {
                            // Ensure we execute the following just once
                            if (!done) {
                                done = true;

                                // Clear main event listeners
                                doc.removeEventListener("DOMContentLoaded", domCallback, false);
                                win.removeEventListener("load", domCallback, false);

                                // Listen for the start and refresh events
                                rv.addEventListener('start', rv.start);
                                rv.addEventListener('refresh', rv.refresh);

                                // Start delivery
                                rv.dispatchEvent('start', {
                                    start: true
                                });
                            }
                        } catch (e) {
                            console.log(e);
                        }
                    };

                    // Library has been initialized, someone (e.g. Tag Manager) might need to know
                    rv.dispatchEvent('init');

                    // Wait for the DOM to be loaded or execute asynchronously if we were late to the party
                    if (doc.readyState === "complete") {
                        setTimeout(domCallback);
                    } else {
                        doc.addEventListener("DOMContentLoaded", domCallback, false);
                        win.addEventListener("load", domCallback, false);
                    }
                },

                /**
                 * The start event handler. Delivery can be prevented by setting e.detail.start = false.
                 *
                 * @param {CustomEvent} e
                 */
                start: function (e)
                {
                    if (e.detail && e.detail.hasOwnProperty('start') && !e.detail.start) {
                        return;
                    }

                    rv.removeEventListener('start', rv.start);

                    rv.dispatchEvent('refresh');
                },

                /**
                 * The refresh event handler.
                 *
                 * @param {CustomEvent} e
                 */
                refresh: function (e)
                {
                    rv.apply(rv.detect());
                },

                /**
                 * Perform the AJAX call.
                 *
                 * @param {string} url
                 * @param {Object} data
                 */
                ajax: function (url, data) {
                    var xhr = new XMLHttpRequest();

                    xhr.onreadystatechange = function() {
                        if (4 === this.readyState) {
                            if (200 === this.status) {
                                rv.spc(JSON.parse(this.responseText));
                            }
                        }
                    };

                    // Pre-ajax hook
                    this.dispatchEvent('send', data);

                    xhr.open("GET", url + "?" + rv.encode(data).join("&"), true);
                    xhr.withCredentials = true;
                    xhr.send();
                },

                /**
                 * Utility method to generate the query string.
                 *
                 * @param {Object} data the input hash
                 * @param {string} arrayName the variable "array" name (optional)
                 * @returns {Array}
                 */
                encode: function (data, arrayName){
                    var qs = [], k, j;

                    for (k in data) {
                        if (data.hasOwnProperty(k)) {
                            var key = arrayName ? arrayName + "[" + k + "]" : k;

                            if ((/^(string|number|boolean)$/).test(typeof data[k])) {
                                qs.push(encodeURIComponent(key) + "=" + encodeURIComponent(data[k]));
                            } else {
                                var a = rv.encode(data[k], key);
                                for (j in a) {
                                    qs.push(a[j]);
                                }
                            }
                        }
                    }

                    return qs;
                },

                /**
                 * Start the asynchronous process to fill the <ins> tags.
                 *
                 * @param {Array} data
                 */
                apply: function (data) {
                    if (data.zones.length) {
                        var url = 'http:' === doc.location.protocol ?
                            "<?php echo MAX_commonConstructDeliveryUrl($GLOBALS['_MAX']['CONF']['file']['asyncspc']); ?>" :
                            "<?php echo MAX_commonConstructSecureDeliveryUrl($GLOBALS['_MAX']['CONF']['file']['asyncspc']); ?>";

                        data.zones = data.zones.join("|");
                        data.loc = doc.location.href;
                        if (doc.referrer) {
                            data.referer = doc.referrer;
                        }

                        rv.ajax(url, data);
                    }
                },

                /**
                 * Search the DOM for <ins> tags that need to be filled.
                 *
                 * @returns {{zones: Array, prefix: string}}
                 */
                detect: function () {
                    var elements = doc.querySelectorAll("ins[" + rv.getDataAttr("id") + "='" + ID + "']");
                    var data = {
                        zones: [],
                        prefix: rv.name + "-" + rv.id + "-"
                    };

                    for (var idx = 0; idx < elements.length; idx++) {
                        var zoneidAttr = rv.getDataAttr("zoneid"),
                            seqAttr = rv.getDataAttr("seq"),
                            i = elements[idx],
                            seq;

                        if (i.hasAttribute(seqAttr)) {
                            seq = i.getAttribute(seqAttr);
                        } else {
                            seq = rv.seq++;
                            i.setAttribute(seqAttr, seq);
                            i.id = data.prefix + seq;
                        }

                        if (i.hasAttribute(zoneidAttr)) {
                            var loadedAttr = rv.getDataAttr("loaded"),
                                regex = new RegExp("^" + rv.getDataAttr("(.*)") + "$"),
                                m;

                            if (i.hasAttribute(loadedAttr) && i.getAttribute(loadedAttr)) {
                                // The tag has already been loaded, skip
                                continue;
                            }

                            i.setAttribute(rv.getDataAttr("loaded"), "1");

                            for (var j = 0; j < i.attributes.length; j++) {
                                if (m = i.attributes[j].name.match(regex)) {
                                    if ('zoneid' === m[1]) {
                                        data.zones[seq] = i.attributes[j].value;
                                    } else if (!(/^(id|seq|loaded)$/).test(m[1])) {
                                        data[m[1]] = i.attributes[j].value;
                                    }
                                }
                            }
                        }
                    }

                    return data;
                },

                /**
                 * Create and return a new iframe.
                 *
                 * @param {Object} data
                 * @returns {Element}
                 */
                createFrame: function (data) {
                    var i = doc.createElement('IFRAME'), s = i.style;

                    i.scrolling = "no";
                    i.frameBorder = 0;
                    i.allow = "autoplay";
                    i.width = data.width > 0 ? data.width : 0;
                    i.height = data.height > 0 ? data.height : 0;
                    s.border = 0;
                    s.overflow = "hidden";
                    s.verticalAlign = 'bottom';

                    return i;
                },

                /**
                 * Inject the HTML into the iframe.
                 *
                 * @param {Element} iframe
                 * @param {string} html
                 */
                loadFrame: function (iframe, html) {
                    var srcdoc = '<!DOCTYPE html>';
                    srcdoc += '<html>';
                    srcdoc += '<head><base target="_top"><meta charset="UTF-8"></head>';
                    srcdoc += '<body border="0" margin="0" style="margin: 0;padding: 0;">';
                    srcdoc += html;
                    srcdoc += '<body>';
                    srcdoc += '</html>';

                    if ('srcdoc' in iframe && "1" === iframe.parentElement.getAttribute(this.getDataAttr('srcdoc'))) {
                        iframe.srcdoc = srcdoc; // If srcdoc is supported and enabled we can just assign it
                    } else {
                        var d = iframe.contentWindow.document || iframe.contentDocument;
                        d.open();
                        d.write(srcdoc); // If srcdoc is not supported write entire srcdoc string to document
                        d.close();
                    }
                },

                /**
                 * The AJAX Callback.
                 *
                 * @param {Object} data
                 */
                spc: function (data) {
                    // Post-ajax hook
                    this.dispatchEvent('receive', data);

                    for (var id in data) {
                        if (data.hasOwnProperty(id)) {
                            var d = data[id];
                            var ins = doc.getElementById(id);

                            if (ins) {
                                var newIns = ins.cloneNode(false);

                                if (d.iframeFriendly) {
                                    var ifr = rv.createFrame(d);
                                    newIns.appendChild(ifr);
                                    ins.parentNode.replaceChild(newIns, ins);
                                    rv.loadFrame(ifr, d.html);
                                } else {
                                    newIns.style.textDecoration = 'none';
                                    newIns.innerHTML = d.html;
                                    var scripts = newIns.getElementsByTagName('SCRIPT');

                                    for (var i = 0; i < scripts.length; i++) {
                                        var s = document.createElement('SCRIPT');
                                        var a = scripts[i].attributes;
                                        for (var j = 0; j < a.length; j++) {
                                            s[a[j].nodeName] = a[j].value;
                                        }
                                        if (scripts[i].innerHTML) {
                                            s.text = scripts[i].innerHTML;
                                        }

                                        scripts[i].parentNode.replaceChild(s, scripts[i]);
                                    }

                                    ins.parentNode.replaceChild(newIns, ins);
                                }

                                this.dispatchEvent('loaded', {
                                    "id": id,
                                    "data": d
                                });
                            }
                        }
                    }

                    this.dispatchEvent('completed', data);
                },

                /**
                 * Returnrs the data HTML attribute name.
                 *
                 * @param {string} name
                 * @returns {string}
                 */
                getDataAttr: function (name) {
                    return 'data-' + rv.name + '-' + name;
                },

                /**
                 * Returns the custom event name.
                 *
                 * @param {string} eventName
                 * @returns {string}
                 */
                getEventName: function (eventName)
                {
                    return this.name + '-' + ID + '-' + eventName;
                },

                /**
                 * Listen for a custom event.
                 *
                 * @param {string} eventName
                 * @param {EventListener|Function} callback
                 */
                addEventListener: function (eventName, callback)
                {
                    doc.addEventListener(this.getEventName(eventName), callback);
                },

                /**
                 * Remove an existing listener.
                 *
                 * @param {string} eventName
                 * @param {EventListener|Function} callback
                 */
                removeEventListener: function (eventName, callback)
                {
                    doc.removeEventListener(this.getEventName(eventName), callback, true);
                },

                /**
                 * Dispatch a custom event.
                 *
                 * @param {string} eventName
                 * @param {Object} [data]
                 */
                dispatchEvent: function (eventName, data) {
                    doc.dispatchEvent(new CustomEvent(this.getEventName(eventName), {
                        detail: data || {}
                    }));
                }
            };

            // Register the DOM event listeners or start if the DOM is already loaded
            rv.main();
        }
    } catch (e) {
        if (console.log) {
            console.log(e);
        }
    }
})(document, window);
