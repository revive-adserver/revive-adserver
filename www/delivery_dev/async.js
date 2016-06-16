(function (doc, win) {
    var ID = "<?php echo $etag; ?>";

    win.reviveAsync = win.reviveAsync || {};

    try {
        if (!win.reviveAsync.hasOwnProperty(ID)) {
            var rv = win.reviveAsync[ID] = {
                id: Object.keys(win.reviveAsync).length,
                name: "<?php echo $product; ?>",

                start: function () {
                    var callback = function () {
                        try {
                            if (!rv.done) {
                                doc.removeEventListener("DOMContentLoaded", callback, false);
                                win.removeEventListener("load", callback, false);

                                rv.done= true;
                                rv.apply(rv.detect());
                            }
                        } catch (e) {
                            console.log(e);
                        }
                    };

                    if (doc.readyState === "complete") {
                        setTimeout(callback);
                    } else {
                        doc.addEventListener("DOMContentLoaded", callback, false);
                        win.addEventListener("load", callback, false);
                    }
                },

                /**
                 * Perform the AJAX call.
                 *
                 * @param string url
                 * @param object data
                 */
                ajax: function (url, data) {
                    var xhr = new XMLHttpRequest();

                    xhr.onreadystatechange = function() {
                        if (this.readyState == 4 ) {
                            if (this.status == 200) {
                                rv.spc(JSON.parse(this.responseText));
                            }
                        }
                    };

                    xhr.open("GET", url + "?" + rv.encode(data).join("&"), true);
                    xhr.withCredentials = true;
                    xhr.send();
                },

                /**
                 *
                 * @param object data the input hash
                 * @param string arr the variable "array" name (optional)
                 * @returns {Array}
                 */
                encode: function (data, arrayName){
                    var qs = [], k, j;

                    for (k in data) {
                        if (data.hasOwnProperty(k)) {
                            var key = arrayName ? arrayName + "[" + k + "]" : k;

                            if ((/string|number|boolean/).test(typeof data[k])) {
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

                apply: function (data) {
                    if (data.zones.length) {
                        var url = doc.location.protocol == 'http:' ?
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

                detect: function () {
                    var elements = doc.querySelectorAll("ins[data-" + rv.name + "-id='" + ID + "']");
                    var data = {
                        zones: [],
                        prefix: rv.name + "-" + rv.id + "-"
                    };

                    for (var idx = 0; idx < elements.length; idx++) {
                        var i = elements[idx];

                        if (i.hasAttribute("data-" + rv.name + "-zoneid")) {
                            var regex = new RegExp("^data-" + rv.name + "-(.*)$"),
                                m;

                            for (var j = 0; j < i.attributes.length; j++) {
                                if (m = i.attributes[j].name.match(regex)) {
                                    if (m[1] == 'zoneid') {
                                        data.zones[idx] = i.attributes[j].value;
                                        i.id = data.prefix + idx;
                                    } else if (m[1] != 'id') {
                                        data[m[1]] = i.attributes[j].value;
                                    }
                                }
                            }
                        }
                    };

                    return data;
                },

                /**
                 * Create and return a new iframe.
                 *
                 * @param object data
                 * @returns JQuery
                 */
                createFrame: function (data) {
                    var i = doc.createElement('IFRAME'), s = i.style;

                    i.scrolling = "no";
                    i.frameBorder = 0;
                    i.width = data.width > 0 ? data.width : 0;
                    i.height = data.height > 0 ? data.height : 0;
                    s.border = 0;
                    s.overflow = "hidden";

                    return i;
                },

                /**
                 * Inject the HTML into the iframe
                 *
                 * @param Element iframe
                 * @param string html
                 */
                loadFrame: function (iframe, html) {
                    var d = iframe.contentDocument || iframe.contentWindow.document;

                    d.open();
                    d.writeln('<!DOCTYPE html>');
                    d.writeln('<html>');
                    d.writeln('<head><base target="_top"></head>');
                    d.writeln('<body border="0" margin="0" style="margin: 0; padding: 0">');
                    d.writeln(html);
                    d.writeln('</body>');
                    d.writeln('</html>');
                    d.close();
                },

                /**
                 * The AJAX Callback.
                 *
                 * @param object data
                 */
                spc: function (data) {
                    for (var id in data) {
                        if (data.hasOwnProperty(id)) {
                            var d = data[id];
                            var ins = doc.getElementById(id);

                            if (ins) {
                                var newIns = doc.createElement('INS');

                                if (d.iframeFriendly) {
                                    var i = rv.createFrame(d);
                                    newIns.appendChild(i);
                                    ins.parentNode.replaceChild(newIns, ins);
                                    rv.loadFrame(i, d.html);
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
                            }
                        }
                    }
                }
            };

            rv.start();
        }
    } catch (e) {
        if (console.log) {
            console.log(e);
        }
    }
})(document, window);