(function () {
    if (typeof jQuery != "undefined")
        var _jQuery = jQuery;
    var jQuery = window.jQuery = function (a, c) {
        if (window == this || !this.init)
            return new jQuery(a, c);
        return this.init(a, c);
    };
    if (typeof $ != "undefined")
        var _$ = $;
    window.$ = jQuery;
    var quickExpr = /^[^<]*(<(.|\s)+>)[^>]*$|^#(\w+)$/;
    jQuery.fn = jQuery.prototype = {
        init: function (a, c) {
            a = a || document;
            if (typeof a == "string") {
                var m = quickExpr.exec(a);
                if (m && (m[1] || !c)) {
                    if (m[1])
                        a = jQuery.clean([m[1]]);
                    else {
                        var tmp = document.getElementById(m[3]);
                        if (tmp)
                            if (tmp.id != m[3])
                                return jQuery().find(a);
                            else {
                                this[0] = tmp;
                                this.length = 1;
                                return this;
                            } else
                                a = [];
                    }
                } else
                    return new jQuery(c).find(a);
            } else if (jQuery.isFunction(a))
                return new jQuery(document)[jQuery.fn.ready ? "ready" : "load"](a);
            return this.setArray(a.constructor == Array && a || (a.jquery || a.length && a != window && !a.nodeType && a[0] != undefined && a[0].nodeType) && jQuery.makeArray(a) || [a]);
        },
        jquery: "1.1.4",
        size: function () {
            return this.length;
        },
        length: 0,
        get: function (num) {
            return num == undefined ? jQuery.makeArray(this) : this[num];
        },
        pushStack: function (a) {
            var ret = jQuery(a);
            ret.prevObject = this;
            return ret;
        },
        setArray: function (a) {
            this.length = 0;
            Array.prototype.push.apply(this, a);
            return this;
        },
        each: function (fn, args) {
            return jQuery.each(this, fn, args);
        },
        index: function (obj) {
            var pos = -1;
            this.each(function (i) {
                if (this == obj) pos = i;
            });
            return pos;
        },
        attr: function (key, value, type) {
            var obj = key;
            if (key.constructor == String)
                if (value == undefined)
                    return this.length && jQuery[type || "attr"](this[0], key) || undefined;
                else {
                    obj = {};
                    obj[key] = value;
                }
            return this.each(function (index) {
                for (var prop in obj)
                    jQuery.attr(type ? this.style : this, prop, jQuery.prop(this, obj[prop], type, index, prop));
            });
        },
        css: function (key, value) {
            return this.attr(key, value, "curCSS");
        },
        text: function (e) {
            if (typeof e != "object" && e != null)
                return this.empty().append(document.createTextNode(e));
            var t = "";
            jQuery.each(e || this, function () {
                jQuery.each(this.childNodes, function () {
                    if (this.nodeType != 8)
                        t += this.nodeType != 1 ? this.nodeValue : jQuery.fn.text([this]);
                });
            });
            return t;
        },
        wrap: function () {
            var a, args = arguments;
            return this.each(function () {
                if (!a)
                    a = jQuery.clean(args, this.ownerDocument);
                var b = a[0].cloneNode(true);
                this.parentNode.insertBefore(b, this);
                while (b.firstChild)
                    b = b.firstChild;
                b.appendChild(this);
            });
        },
        append: function () {
            return this.domManip(arguments, true, 1, function (a) {
                this.appendChild(a);
            });
        },
        prepend: function () {
            return this.domManip(arguments, true, -1, function (a) {
                this.insertBefore(a, this.firstChild);
            });
        },
        before: function () {
            return this.domManip(arguments, false, 1, function (a) {
                this.parentNode.insertBefore(a, this);
            });
        },
        after: function () {
            return this.domManip(arguments, false, -1, function (a) {
                this.parentNode.insertBefore(a, this.nextSibling);
            });
        },
        end: function () {
            return this.prevObject || jQuery([]);
        },
        find: function (t) {
            var data = jQuery.map(this, function (a) {
                return jQuery.find(t, a);
            });
            return this.pushStack(/[^+>] [^+>]/.test(t) || t.indexOf("..") > -1 ? jQuery.unique(data) : data);
        },
        clone: function (deep) {
            deep = deep != undefined ? deep : true;
            var $this = this.add(this.find("*"));
            if (jQuery.browser.msie) {
                $this.each(function () {
                    this._$events = {};
                    for (var type in this.$events)
                        this._$events[type] = jQuery.extend({}, this.$events[type]);
                }).unbind();
            }
            var r = this.pushStack(jQuery.map(this, function (a) {
                return a.cloneNode(deep);
            }));
            if (jQuery.browser.msie) {
                $this.each(function () {
                    var events = this._$events;
                    for (var type in events)
                        for (var handler in events[type])
                            jQuery.event.add(this, type, events[type][handler], events[type][handler].data);
                    this._$events = null;
                });
            }
            if (deep) {
                var inputs = r.add(r.find('*')).filter('select,input[@type=checkbox]');
                $this.filter('select,input[@type=checkbox]').each(function (i) {
                    if (this.selectedIndex)
                        inputs[i].selectedIndex = this.selectedIndex;
                    if (this.checked)
                        inputs[i].checked = true;
                });
            }
            return r;
        },
        filter: function (t) {
            return this.pushStack(jQuery.isFunction(t) && jQuery.grep(this, function (el, index) {
                return t.apply(el, [index]);
            }) || jQuery.multiFilter(t, this));
        },
        not: function (t) {
            return this.pushStack(t.constructor == String && jQuery.multiFilter(t, this, true) || jQuery.grep(this, function (a) {
                return (t.constructor == Array || t.jquery) ? jQuery.inArray(a, t) < 0 : a != t;
            }));
        },
        add: function (t) {
            return this.pushStack(jQuery.merge(this.get(), t.constructor == String ? jQuery(t).get() : t.length != undefined && (!t.nodeName || t.nodeName == "FORM") ? t : [t]));
        },
        is: function (expr) {
            return expr ? jQuery.multiFilter(expr, this).length > 0 : false;
        },
        val: function (val) {
            return val == undefined ? (this.length ? this[0].value : null) : this.attr("value", val);
        },
        html: function (val) {
            return val == undefined ? (this.length ? this[0].innerHTML : null) : this.empty().append(val);
        },
        slice: function () {
            return this.pushStack(Array.prototype.slice.apply(this, arguments));
        },
        domManip: function (args, table, dir, fn) {
            var clone = this.length > 1,
                a;
            return this.each(function () {
                if (!a) {
                    a = jQuery.clean(args, this.ownerDocument);
                    if (dir < 0)
                        a.reverse();
                }
                var obj = this;
                if (table && jQuery.nodeName(this, "table") && jQuery.nodeName(a[0], "tr"))
                    obj = this.getElementsByTagName("tbody")[0] || this.appendChild(document.createElement("tbody"));
                jQuery.each(a, function () {
                    if (jQuery.nodeName(this, "script")) {
                        if (this.src)
                            jQuery.ajax({
                                url: this.src,
                                async: false,
                                dataType: "script"
                            });
                        else
                            jQuery.globalEval(this.text || this.textContent || this.innerHTML || "");
                    } else
                        fn.apply(obj, [clone ? this.cloneNode(true) : this]);
                });
            });
        }
    };
    jQuery.extend = jQuery.fn.extend = function () {
        var target = arguments[0] || {}, a = 1,
            al = arguments.length,
            deep = false;
        if (target.constructor == Boolean) {
            deep = target;
            target = arguments[1] || {};
        }
        if (al == 1) {
            target = this;
            a = 0;
        }
        var prop;
        for (; a < al; a++)
            if ((prop = arguments[a]) != null)
                for (var i in prop) {
                    if (target == prop[i])
                        continue;
                    if (deep && typeof prop[i] == 'object' && target[i])
                        jQuery.extend(target[i], prop[i]);
                    else if (prop[i] != undefined)
                        target[i] = prop[i];
                }
        return target;
    };
    jQuery.extend({
        noConflict: function (deep) {
            window.$ = _$;
            if (deep)
                window.jQuery = _jQuery;
            return jQuery;
        },
        isFunction: function (fn) {
            return !!fn && typeof fn != "string" && !fn.nodeName && fn.constructor != Array && /function/i.test(fn + "");
        },
        isXMLDoc: function (elem) {
            return elem.documentElement && !elem.body || elem.tagName && elem.ownerDocument && !elem.ownerDocument.body;
        },
        globalEval: function (data) {
            data = jQuery.trim(data);
            if (data) {
                if (window.execScript)
                    window.execScript(data);
                else if (jQuery.browser.safari)
                    window.setTimeout(data, 0);
                else
                    eval.call(window, data);
            }
        },
        nodeName: function (elem, name) {
            return elem.nodeName && elem.nodeName.toUpperCase() == name.toUpperCase();
        },
        each: function (obj, fn, args) {
            if (args) {
                if (obj.length == undefined)
                    for (var i in obj)
                        fn.apply(obj[i], args);
                else
                    for (var i = 0, ol = obj.length; i < ol; i++)
                        if (fn.apply(obj[i], args) === false) break;
            } else {
                if (obj.length == undefined)
                    for (var i in obj)
                        fn.call(obj[i], i, obj[i]);
                else
                    for (var i = 0, ol = obj.length, val = obj[0]; i < ol && fn.call(val, i, val) !== false; val = obj[++i]) {}
            }
            return obj;
        },
        prop: function (elem, value, type, index, prop) {
            if (jQuery.isFunction(value))
                value = value.call(elem, [index]);
            var exclude = /z-?index|font-?weight|opacity|zoom|line-?height/i;
            return value && value.constructor == Number && type == "curCSS" && !exclude.test(prop) ? value + "px" : value;
        },
        className: {
            add: function (elem, c) {
                jQuery.each((c || "").split(/\s+/), function (i, cur) {
                    if (!jQuery.className.has(elem.className, cur))
                        elem.className += (elem.className ? " " : "") + cur;
                });
            },
            remove: function (elem, c) {
                elem.className = c != undefined ? jQuery.grep(elem.className.split(/\s+/), function (cur) {
                    return !jQuery.className.has(c, cur);
                }).join(" ") : "";
            },
            has: function (t, c) {
                return jQuery.inArray(c, (t.className || t).toString().split(/\s+/)) > -1;
            }
        },
        swap: function (e, o, f) {
            for (var i in o) {
                e.style["old" + i] = e.style[i];
                e.style[i] = o[i];
            }
            f.apply(e, []);
            for (var i in o)
                e.style[i] = e.style["old" + i];
        },
        css: function (e, p) {
            if (p == "height" || p == "width") {
                var old = {}, oHeight, oWidth, d = ["Top", "Bottom", "Right", "Left"];
                jQuery.each(d, function () {
                    old["padding" + this] = 0;
                    old["border" + this + "Width"] = 0;
                });
                jQuery.swap(e, old, function () {
                    if (jQuery(e).is(':visible')) {
                        oHeight = e.offsetHeight;
                        oWidth = e.offsetWidth;
                    } else {
                        e = jQuery(e.cloneNode(true)).find(":radio").removeAttr("checked").end().css({
                            visibility: "hidden",
                            position: "absolute",
                            display: "block",
                            right: "0",
                            left: "0"
                        }).appendTo(e.parentNode)[0];
                        var parPos = jQuery.css(e.parentNode, "position") || "static";
                        if (parPos == "static")
                            e.parentNode.style.position = "relative";
                        oHeight = e.clientHeight;
                        oWidth = e.clientWidth;
                        if (parPos == "static")
                            e.parentNode.style.position = "static";
                        e.parentNode.removeChild(e);
                    }
                });
                return p == "height" ? oHeight : oWidth;
            }
            return jQuery.curCSS(e, p);
        },
        curCSS: function (elem, prop, force) {
            var ret, stack = [],
                swap = [];

            function color(a) {
                if (!jQuery.browser.safari)
                    return false;
                var ret = document.defaultView.getComputedStyle(a, null);
                return !ret || ret.getPropertyValue("color") == "";
            }
            if (prop == "opacity" && jQuery.browser.msie) {
                ret = jQuery.attr(elem.style, "opacity");
                return ret == "" ? "1" : ret;
            }
            if (prop.match(/float/i))
                prop = styleFloat;
            if (!force && elem.style[prop])
                ret = elem.style[prop];
            else if (document.defaultView && document.defaultView.getComputedStyle) {
                if (prop.match(/float/i))
                    prop = "float";
                prop = prop.replace(/([A-Z])/g, "-$1").toLowerCase();
                var cur = document.defaultView.getComputedStyle(elem, null);
                if (cur && !color(elem))
                    ret = cur.getPropertyValue(prop);
                else {
                    for (var a = elem; a && color(a); a = a.parentNode)
                        stack.unshift(a);
                    for (a = 0; a < stack.length; a++)
                        if (color(stack[a])) {
                            swap[a] = stack[a].style.display;
                            stack[a].style.display = "block";
                        }
                    ret = prop == "display" && swap[stack.length - 1] != null ? "none" : document.defaultView.getComputedStyle(elem, null).getPropertyValue(prop) || "";
                    for (a = 0; a < swap.length; a++)
                        if (swap[a] != null)
                            stack[a].style.display = swap[a];
                }
                if (prop == "opacity" && ret == "")
                    ret = "1";
            } else if (elem.currentStyle) {
                var newProp = prop.replace(/\-(\w)/g, function (m, c) {
                    return c.toUpperCase();
                });
                ret = elem.currentStyle[prop] || elem.currentStyle[newProp];
            }
            return ret;
        },
        clean: function (a, doc) {
            var r = [];
            doc = doc || document;
            jQuery.each(a, function (i, arg) {
                if (!arg) return;
                if (arg.constructor == Number)
                    arg = arg.toString();
                if (typeof arg == "string") {
                    var s = jQuery.trim(arg).toLowerCase(),
                        div = doc.createElement("div"),
                        tb = [];
                    var wrap = !s.indexOf("<opt") && [1, "<select>", "</select>"] || !s.indexOf("<leg") && [1, "<fieldset>", "</fieldset>"] || s.match(/^<(thead|tbody|tfoot|colg|cap)/) && [1, "<table>", "</table>"] || !s.indexOf("<tr") && [2, "<table><tbody>", "</tbody></table>"] || (!s.indexOf("<td") || !s.indexOf("<th")) && [3, "<table><tbody><tr>", "</tr></tbody></table>"] || !s.indexOf("<col") && [2, "<table><tbody></tbody><colgroup>", "</colgroup></table>"] || jQuery.browser.msie && [1, "div<div>", "</div>"] || [0, "", ""];
                    div.innerHTML = wrap[1] + arg + wrap[2];
                    while (wrap[0]--)
                        div = div.lastChild;
                    if (jQuery.browser.msie) {
                        if (!s.indexOf("<table") && s.indexOf("<tbody") < 0)
                            tb = div.firstChild && div.firstChild.childNodes;
                        else if (wrap[1] == "<table>" && s.indexOf("<tbody") < 0)
                            tb = div.childNodes;
                        for (var n = tb.length - 1; n >= 0; --n)
                            if (jQuery.nodeName(tb[n], "tbody") && !tb[n].childNodes.length)
                                tb[n].parentNode.removeChild(tb[n]);
                        if (/^\s/.test(arg))
                            div.insertBefore(doc.createTextNode(arg.match(/^\s*/)[0]), div.firstChild);
                    }
                    arg = jQuery.makeArray(div.childNodes);
                }
                if (0 === arg.length && (!jQuery.nodeName(arg, "form") && !jQuery.nodeName(arg, "select")))
                    return;
                if (arg[0] == undefined || jQuery.nodeName(arg, "form") || arg.options)
                    r.push(arg);
                else
                    r = jQuery.merge(r, arg);
            });
            return r;
        },
        attr: function (elem, name, value) {
            var fix = jQuery.isXMLDoc(elem) ? {} : jQuery.props;
            if (name == "selected" && jQuery.browser.safari)
                elem.parentNode.selectedIndex;
            if (fix[name]) {
                if (value != undefined) elem[fix[name]] = value;
                return elem[fix[name]];
            } else if (jQuery.browser.msie && name == "style")
                return jQuery.attr(elem.style, "cssText", value);
            else if (value == undefined && jQuery.browser.msie && jQuery.nodeName(elem, "form") && (name == "action" || name == "method"))
                return elem.getAttributeNode(name).nodeValue;
            else if (elem.tagName) {
                if (value != undefined) elem.setAttribute(name, value);
                if (jQuery.browser.msie && /href|src/.test(name) && !jQuery.isXMLDoc(elem))
                    return elem.getAttribute(name, 2);
                return elem.getAttribute(name);
            } else {
                if (name == "opacity" && jQuery.browser.msie) {
                    if (value != undefined) {
                        elem.zoom = 1;
                        elem.filter = (elem.filter || "").replace(/alpha\([^)]*\)/, "") +
                            (parseFloat(value).toString() == "NaN" ? "" : "alpha(opacity=" + value * 100 + ")");
                    }
                    return elem.filter ? (parseFloat(elem.filter.match(/opacity=([^)]*)/)[1]) / 100).toString() : "";
                }
                name = name.replace(/-([a-z])/ig, function (z, b) {
                    return b.toUpperCase();
                });
                if (value != undefined) elem[name] = value;
                return elem[name];
            }
        },
        trim: function (t) {
            return (t || "").replace(/^\s+|\s+$/g, "");
        },
        makeArray: function (a) {
            var r = [];
            if (typeof a != "array")
                for (var i = 0, al = a.length; i < al; i++)
                    r.push(a[i]);
            else
                r = a.slice(0);
            return r;
        },
        inArray: function (b, a) {
            for (var i = 0, al = a.length; i < al; i++)
                if (a[i] == b)
                    return i;
            return -1;
        },
        merge: function (first, second) {
            if (jQuery.browser.msie) {
                for (var i = 0; second[i]; i++)
                    if (second[i].nodeType != 8)
                        first.push(second[i]);
            } else
                for (var i = 0; second[i]; i++)
                    first.push(second[i]);
            return first;
        },
        unique: function (first) {
            var r = [],
                num = jQuery.mergeNum++;
            try {
                for (var i = 0, fl = first.length; i < fl; i++)
                    if (num != first[i].mergeNum) {
                        first[i].mergeNum = num;
                        r.push(first[i]);
                    }
            } catch (e) {
                r = first;
            }
            return r;
        },
        mergeNum: 0,
        grep: function (elems, fn, inv) {
            if (typeof fn == "string")
                fn = eval("false||function(a,i){return " + fn + "}");
            var result = [];
            for (var i = 0, el = elems.length; i < el; i++)
                if (!inv && fn(elems[i], i) || inv && !fn(elems[i], i))
                    result.push(elems[i]);
            return result;
        },
        map: function (elems, fn) {
            if (typeof fn == "string")
                fn = eval("false||function(a){return " + fn + "}");
            var result = [];
            for (var i = 0, el = elems.length; i < el; i++) {
                var val = fn(elems[i], i);
                if (val !== null && val != undefined) {
                    if (val.constructor != Array) val = [val];
                    result = result.concat(val);
                }
            }
            return result;
        }
    });
    var userAgent = navigator.userAgent.toLowerCase();
    jQuery.browser = {
        version: (userAgent.match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/) || [])[1],
        safari: /webkit/.test(userAgent),
        opera: /opera/.test(userAgent),
        msie: /msie/.test(userAgent) && !/opera/.test(userAgent),
        mozilla: /mozilla/.test(userAgent) && !/(compatible|webkit)/.test(userAgent)
    };
    var styleFloat = jQuery.browser.msie ? "styleFloat" : "cssFloat";
    jQuery.extend({
        boxModel: !jQuery.browser.msie || document.compatMode == "CSS1Compat",
        styleFloat: jQuery.browser.msie ? "styleFloat" : "cssFloat",
        props: {
            "for": "htmlFor",
            "class": "className",
            "float": styleFloat,
            cssFloat: styleFloat,
            styleFloat: styleFloat,
            innerHTML: "innerHTML",
            className: "className",
            value: "value",
            disabled: "disabled",
            checked: "checked",
            readonly: "readOnly",
            selected: "selected",
            maxlength: "maxLength"
        }
    });
    jQuery.each({
        parent: "a.parentNode",
        parents: "jQuery.parents(a)",
        next: "jQuery.nth(a,2,'nextSibling')",
        prev: "jQuery.nth(a,2,'previousSibling')",
        siblings: "jQuery.sibling(a.parentNode.firstChild,a)",
        children: "jQuery.sibling(a.firstChild)"
    }, function (i, n) {
        jQuery.fn[i] = function (a) {
            var ret = jQuery.map(this, n);
            if (a && typeof a == "string")
                ret = jQuery.multiFilter(a, ret);
            return this.pushStack(jQuery.unique(ret));
        };
    });
    jQuery.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after"
    }, function (i, n) {
        jQuery.fn[i] = function () {
            var a = arguments;
            return this.each(function () {
                for (var j = 0, al = a.length; j < al; j++)
                    jQuery(a[j])[n](this);
            });
        };
    });
    jQuery.each({
        removeAttr: function (key) {
            jQuery.attr(this, key, "");
            this.removeAttribute(key);
        },
        addClass: function (c) {
            jQuery.className.add(this, c);
        },
        removeClass: function (c) {
            jQuery.className.remove(this, c);
        },
        toggleClass: function (c) {
            jQuery.className[jQuery.className.has(this, c) ? "remove" : "add"](this, c);
        },
        remove: function (a) {
            if (!a || jQuery.filter(a, [this]).r.length)
                this.parentNode.removeChild(this);
        },
        empty: function () {
            while (this.firstChild)
                this.removeChild(this.firstChild);
        }
    }, function (i, n) {
        jQuery.fn[i] = function () {
            return this.each(n, arguments);
        };
    });
    jQuery.each(["eq", "lt", "gt", "contains"], function (i, n) {
        jQuery.fn[n] = function (num, fn) {
            return this.filter(":" + n + "(" + num + ")", fn);
        };
    });
    jQuery.each(["height", "width"], function (i, n) {
        jQuery.fn[n] = function (h) {
            return h == undefined ? (this.length ? jQuery.css(this[0], n) : null) : this.css(n, h.constructor == String ? h : h + "px");
        };
    });
    var chars = jQuery.browser.safari && parseInt(jQuery.browser.version) < 417 ? "(?:[\\w*_-]|\\\\.)" : "(?:[\\w\u0128-\uFFFF*_-]|\\\\.)",
        quickChild = new RegExp("^[/>]\\s*(" + chars + "+)"),
        quickID = new RegExp("^(" + chars + "+)(#)(" + chars + "+)"),
        quickClass = new RegExp("^([#.]?)(" + chars + "*)");
    jQuery.extend({
        expr: {
            "": "m[2]=='*'||jQuery.nodeName(a,m[2])",
            "#": "a.getAttribute('id')==m[2]",
            ":": {
                lt: "i<m[3]-0",
                gt: "i>m[3]-0",
                nth: "m[3]-0==i",
                eq: "m[3]-0==i",
                first: "i==0",
                last: "i==r.length-1",
                even: "i%2==0",
                odd: "i%2",
                "first-child": "a.parentNode.getElementsByTagName('*')[0]==a",
                "last-child": "jQuery.nth(a.parentNode.lastChild,1,'previousSibling')==a",
                "only-child": "!jQuery.nth(a.parentNode.lastChild,2,'previousSibling')",
                parent: "a.firstChild",
                empty: "!a.firstChild",
                contains: "(a.textContent||a.innerText||'').indexOf(m[3])>=0",
                visible: '"hidden"!=a.type&&jQuery.css(a,"display")!="none"&&jQuery.css(a,"visibility")!="hidden"',
                hidden: '"hidden"==a.type||jQuery.css(a,"display")=="none"||jQuery.css(a,"visibility")=="hidden"',
                enabled: "!a.disabled",
                disabled: "a.disabled",
                checked: "a.checked",
                selected: "a.selected||jQuery.attr(a,'selected')",
                text: "'text'==a.type",
                radio: "'radio'==a.type",
                checkbox: "'checkbox'==a.type",
                file: "'file'==a.type",
                password: "'password'==a.type",
                submit: "'submit'==a.type",
                image: "'image'==a.type",
                reset: "'reset'==a.type",
                button: '"button"==a.type||jQuery.nodeName(a,"button")',
                input: "/input|select|textarea|button/i.test(a.nodeName)",
                has: "jQuery.find(m[3],a).length"
            },
            "[": "jQuery.find(m[2],a).length"
        },
        parse: [/^\[ *(@)([\w-]+) *([!*$^~=]*) *('?"?)(.*?)\4 *\]/, /^(\[)\s*(.*?(\[.*?\])?[^[]*?)\s*\]/, /^(:)([\w-]+)\("?'?(.*?(\(.*?\))?[^(]*?)"?'?\)/, new RegExp("^([:.#]*)(" + chars + "+)")],
        multiFilter: function (expr, elems, not) {
            var old, cur = [];
            while (expr && expr != old) {
                old = expr;
                var f = jQuery.filter(expr, elems, not);
                expr = f.t.replace(/^\s*,\s*/, "");
                cur = not ? elems = f.r : jQuery.merge(cur, f.r);
            }
            return cur;
        },
        find: function (t, context) {
            if (typeof t != "string")
                return [t];
            if (context && !context.nodeType)
                context = null;
            context = context || document;
            if (!t.indexOf("//")) {
                t = t.substr(2, t.length);
            } else if (!t.indexOf("/") && !context.ownerDocument) {
                context = context.documentElement;
                t = t.substr(1, t.length);
                if (t.indexOf("/") >= 1)
                    t = t.substr(t.indexOf("/"), t.length);
            }
            var ret = [context],
                done = [],
                last;
            while (t && last != t) {
                var r = [];
                last = t;
                t = jQuery.trim(t).replace(/^\/\//, "");
                var foundToken = false;
                var re = quickChild;
                var m = re.exec(t);
                if (m) {
                    var nodeName = m[1].toUpperCase();
                    for (var i = 0; ret[i]; i++)
                        for (var c = ret[i].firstChild; c; c = c.nextSibling)
                            if (c.nodeType == 1 && (nodeName == "*" || c.nodeName.toUpperCase() == nodeName.toUpperCase()))
                                r.push(c);
                    ret = r;
                    t = t.replace(re, "");
                    if (t.indexOf(" ") == 0) continue;
                    foundToken = true;
                } else {
                    re = /^((\/?\.\.)|([>\/+~]))\s*(\w*)/i;
                    if ((m = re.exec(t)) != null) {
                        r = [];
                        var nodeName = m[4],
                            mergeNum = jQuery.mergeNum++;
                        m = m[1];
                        for (var j = 0, rl = ret.length; j < rl; j++)
                            if (m.indexOf("..") < 0) {
                                var n = m == "~" || m == "+" ? ret[j].nextSibling : ret[j].firstChild;
                                for (; n; n = n.nextSibling)
                                    if (n.nodeType == 1) {
                                        if (m == "~" && n.mergeNum == mergeNum) break;
                                        if (!nodeName || n.nodeName.toUpperCase() == nodeName.toUpperCase()) {
                                            if (m == "~") n.mergeNum = mergeNum;
                                            r.push(n);
                                        }
                                        if (m == "+") break;
                                    }
                            } else
                                r.push(ret[j].parentNode);
                        ret = r;
                        t = jQuery.trim(t.replace(re, ""));
                        foundToken = true;
                    }
                }
                if (t && !foundToken) {
                    if (!t.indexOf(",")) {
                        if (context == ret[0]) ret.shift();
                        done = jQuery.merge(done, ret);
                        r = ret = [context];
                        t = " " + t.substr(1, t.length);
                    } else {
                        var re2 = quickID;
                        var m = re2.exec(t);
                        if (m) {
                            m = [0, m[2], m[3], m[1]];
                        } else {
                            re2 = quickClass;
                            m = re2.exec(t);
                        }
                        m[2] = m[2].replace(/\\/g, "");
                        var elem = ret[ret.length - 1];
                        if (m[1] == "#" && elem && elem.getElementById && !jQuery.isXMLDoc(elem)) {
                            var oid = elem.getElementById(m[2]);
                            if ((jQuery.browser.msie || jQuery.browser.opera) && oid && typeof oid.id == "string" && oid.id != m[2])
                                oid = jQuery('[@id="' + m[2] + '"]', elem)[0];
                            ret = r = oid && (!m[3] || jQuery.nodeName(oid, m[3])) ? [oid] : [];
                        } else {
                            for (var i = 0; ret[i]; i++) {
                                var tag = m[1] != "" || m[0] == "" ? "*" : m[2];
                                if (tag == "*" && ret[i].nodeName.toLowerCase() == "object")
                                    tag = "param";
                                r = jQuery.merge(r, ret[i].getElementsByTagName(tag));
                            }
                            if (m[1] == ".")
                                r = jQuery.classFilter(r, m[2]);
                            if (m[1] == "#") {
                                var tmp = [];
                                for (var i = 0; r[i]; i++)
                                    if (r[i].getAttribute("id") == m[2]) {
                                        tmp = [r[i]];
                                        break;
                                    }
                                r = tmp;
                            }
                            ret = r;
                        }
                        t = t.replace(re2, "");
                    }
                }
                if (t) {
                    var val = jQuery.filter(t, r);
                    ret = r = val.r;
                    t = jQuery.trim(val.t);
                }
            }
            if (t)
                ret = [];
            if (ret && context == ret[0])
                ret.shift();
            done = jQuery.merge(done, ret);
            return done;
        },
        classFilter: function (r, m, not) {
            m = " " + m + " ";
            var tmp = [];
            for (var i = 0; r[i]; i++) {
                var pass = (" " + r[i].className + " ").indexOf(m) >= 0;
                if (!not && pass || not && !pass)
                    tmp.push(r[i]);
            }
            return tmp;
        },
        filter: function (t, r, not) {
            var last;
            while (t && t != last) {
                last = t;
                var p = jQuery.parse,
                    m;
                for (var i = 0; p[i]; i++) {
                    m = p[i].exec(t);
                    if (m) {
                        t = t.substring(m[0].length);
                        m[2] = m[2].replace(/\\/g, "");
                        break;
                    }
                }
                if (!m)
                    break;
                if (m[1] == ":" && m[2] == "not")
                    r = jQuery.filter(m[3], r, true).r;
                else if (m[1] == ".")
                    r = jQuery.classFilter(r, m[2], not);
                else if (m[1] == "@") {
                    var tmp = [],
                        type = m[3];
                    for (var i = 0, rl = r.length; i < rl; i++) {
                        var a = r[i],
                            z = a[jQuery.props[m[2]] || m[2]];
                        if (z == null || /href|src|selected/.test(m[2]))
                            z = jQuery.attr(a, m[2]) || '';
                        if ((type == "" && !! z || type == "=" && z == m[5] || type == "!=" && z != m[5] || type == "^=" && z && !z.indexOf(m[5]) || type == "$=" && z.substr(z.length - m[5].length) == m[5] || (type == "*=" || type == "~=") && z.indexOf(m[5]) >= 0) ^ not)
                            tmp.push(a);
                    }
                    r = tmp;
                } else if (m[1] == ":" && m[2] == "nth-child") {
                    var num = jQuery.mergeNum++,
                        tmp = [],
                        test = /(\d*)n\+?(\d*)/.exec(m[3] == "even" && "2n" || m[3] == "odd" && "2n+1" || !/\D/.test(m[3]) && "n+" + m[3] || m[3]),
                        first = (test[1] || 1) - 0,
                        last = test[2] - 0;
                    for (var i = 0, rl = r.length; i < rl; i++) {
                        var node = r[i],
                            parentNode = node.parentNode;
                        if (num != parentNode.mergeNum) {
                            var c = 1;
                            for (var n = parentNode.firstChild; n; n = n.nextSibling)
                                if (n.nodeType == 1)
                                    n.nodeIndex = c++;
                            parentNode.mergeNum = num;
                        }
                        var add = false;
                        if (first == 1) {
                            if (last == 0 || node.nodeIndex == last)
                                add = true;
                        } else if ((node.nodeIndex + last) % first == 0)
                            add = true;
                        if (add ^ not)
                            tmp.push(node);
                    }
                    r = tmp;
                } else {
                    var f = jQuery.expr[m[1]];
                    if (typeof f != "string")
                        f = jQuery.expr[m[1]][m[2]];
                    f = eval("false||function(a,i){return " + f + "}");
                    r = jQuery.grep(r, f, not);
                }
            }
            return {
                r: r,
                t: t
            };
        },
        parents: function (elem) {
            var matched = [];
            var cur = elem.parentNode;
            while (cur && cur != document) {
                matched.push(cur);
                cur = cur.parentNode;
            }
            return matched;
        },
        nth: function (cur, result, dir, elem) {
            result = result || 1;
            var num = 0;
            for (; cur; cur = cur[dir])
                if (cur.nodeType == 1 && ++num == result)
                    break;
            return cur;
        },
        sibling: function (n, elem) {
            var r = [];
            for (; n; n = n.nextSibling) {
                if (n.nodeType == 1 && (!elem || n != elem))
                    r.push(n);
            }
            return r;
        }
    });
    jQuery.event = {
        add: function (element, type, handler, data) {
            if (jQuery.browser.msie && element.setInterval != undefined)
                element = window;
            if (!handler.guid)
                handler.guid = this.guid++;
            if (data != undefined) {
                var fn = handler;
                handler = function () {
                    return fn.apply(this, arguments);
                };
                handler.data = data;
                handler.guid = fn.guid;
            }
            if (!element.$events)
                element.$events = {};
            if (!element.$handle)
                element.$handle = function () {
                    var val;
                    if (typeof jQuery == "undefined" || jQuery.event.triggered)
                        return val;
                    val = jQuery.event.handle.apply(element, arguments);
                    return val;
                };
            var handlers = element.$events[type];
            if (!handlers) {
                handlers = element.$events[type] = {};
                if (element.addEventListener)
                    element.addEventListener(type, element.$handle, false);
                else
                    element.attachEvent("on" + type, element.$handle);
            }
            handlers[handler.guid] = handler;
            this.global[type] = true;
        },
        guid: 1,
        global: {},
        remove: function (element, type, handler) {
            var events = element.$events,
                ret, index;
            if (events) {
                if (type && type.type) {
                    handler = type.handler;
                    type = type.type;
                }
                if (!type) {
                    for (type in events)
                        this.remove(element, type);
                } else if (events[type]) {
                    if (handler)
                        delete events[type][handler.guid];
                    else
                        for (handler in element.$events[type])
                            delete events[type][handler];
                    for (ret in events[type]) break;
                    if (!ret) {
                        if (element.removeEventListener)
                            element.removeEventListener(type, element.$handle, false);
                        else
                            element.detachEvent("on" + type, element.$handle);
                        ret = null;
                        delete events[type];
                    }
                }
                for (ret in events) break;
                if (!ret)
                    element.$handle = element.$events = null;
            }
        },
        trigger: function (type, data, element) {
            data = jQuery.makeArray(data || []);
            if (!element) {
                if (this.global[type])
                    jQuery("*").add([window, document]).trigger(type, data);
            } else {
                var val, ret, fn = jQuery.isFunction(element[type] || null);
                data.unshift(this.fix({
                    type: type,
                    target: element
                }));
                if (jQuery.isFunction(element.$handle))
                    val = element.$handle.apply(element, data);
                if (!fn && element["on" + type] && element["on" + type].apply(element, data) === false)
                    val = false;
                if (fn && val !== false && !(jQuery.nodeName(element, 'a') && type == "click")) {
                    this.triggered = true;
                    element[type]();
                }
                this.triggered = false;
            }
        },
        handle: function (event) {
            var val;
            event = jQuery.event.fix(event || window.event || {});
            var c = this.$events && this.$events[event.type],
                args = Array.prototype.slice.call(arguments, 1);
            args.unshift(event);
            for (var j in c) {
                args[0].handler = c[j];
                args[0].data = c[j].data;
                if (c[j].apply(this, args) === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    val = false;
                }
            }
            if (jQuery.browser.msie)
                event.target = event.preventDefault = event.stopPropagation = event.handler = event.data = null;
            return val;
        },
        fix: function (event) {
            var originalEvent = event;
            event = jQuery.extend({}, originalEvent);
            event.preventDefault = function () {
                if (originalEvent.preventDefault)
                    originalEvent.preventDefault();
                originalEvent.returnValue = false;
            };
            event.stopPropagation = function () {
                if (originalEvent.stopPropagation)
                    originalEvent.stopPropagation();
                originalEvent.cancelBubble = true;
            };
            if (!event.target && event.srcElement)
                event.target = event.srcElement;
            if (jQuery.browser.safari && event.target.nodeType == 3)
                event.target = originalEvent.target.parentNode;
            if (!event.relatedTarget && event.fromElement)
                event.relatedTarget = event.fromElement == event.target ? event.toElement : event.fromElement;
            if (event.pageX == null && event.clientX != null) {
                var e = document.documentElement,
                    b = document.body;
                event.pageX = event.clientX + (e && e.scrollLeft || b.scrollLeft || 0);
                event.pageY = event.clientY + (e && e.scrollTop || b.scrollTop || 0);
            }
            if (!event.which && (event.charCode || event.keyCode))
                event.which = event.charCode || event.keyCode;
            if (!event.metaKey && event.ctrlKey)
                event.metaKey = event.ctrlKey;
            if (!event.which && event.button)
                event.which = (event.button & 1 ? 1 : (event.button & 2 ? 3 : (event.button & 4 ? 2 : 0)));
            return event;
        }
    };
    jQuery.fn.extend({
        bind: function (type, data, fn) {
            return type == "unload" ? this.one(type, data, fn) : this.each(function () {
                jQuery.event.add(this, type, fn || data, fn && data);
            });
        },
        one: function (type, data, fn) {
            return this.each(function () {
                jQuery.event.add(this, type, function (event) {
                    jQuery(this).unbind(event);
                    return (fn || data).apply(this, arguments);
                }, fn && data);
            });
        },
        unbind: function (type, fn) {
            return this.each(function () {
                jQuery.event.remove(this, type, fn);
            });
        },
        trigger: function (type, data) {
            return this.each(function () {
                jQuery.event.trigger(type, data, this);
            });
        },
        toggle: function () {
            var a = arguments;
            return this.click(function (e) {
                this.lastToggle = 0 == this.lastToggle ? 1 : 0;
                e.preventDefault();
                return a[this.lastToggle].apply(this, [e]) || false;
            });
        },
        hover: function (f, g) {
            function handleHover(e) {
                var p = e.relatedTarget;
                while (p && p != this) try {
                    p = p.parentNode;
                } catch (e) {
                    p = this;
                };
                if (p == this) return false;
                return (e.type == "mouseover" ? f : g).apply(this, [e]);
            }
            return this.mouseover(handleHover).mouseout(handleHover);
        },
        ready: function (f) {
            bindReady();
            if (jQuery.isReady)
                f.apply(document, [jQuery]);
            else
                jQuery.readyList.push(function () {
                    return f.apply(this, [jQuery]);
                });
            return this;
        }
    });
    jQuery.extend({
        isReady: false,
        readyList: [],
        ready: function () {
            if (!jQuery.isReady) {
                jQuery.isReady = true;
                if (jQuery.readyList) {
                    jQuery.each(jQuery.readyList, function () {
                        this.apply(document);
                    });
                    jQuery.readyList = null;
                }
                if (jQuery.browser.mozilla || jQuery.browser.opera)
                    document.removeEventListener("DOMContentLoaded", jQuery.ready, false);
                if (!window.frames.length)
                    jQuery(window).load(function () {
                        jQuery("#__ie_init").remove();
                    });
            }
        }
    });
    jQuery.each(("blur,focus,load,resize,scroll,unload,click,dblclick," + "mousedown,mouseup,mousemove,mouseover,mouseout,change,select," + "submit,keydown,keypress,keyup,error").split(","), function (i, o) {
        jQuery.fn[o] = function (f) {
            return f ? this.bind(o, f) : this.trigger(o);
        };
    });
    var readyBound = false;

    function bindReady() {
        if (readyBound) return;
        readyBound = true;
        if (jQuery.browser.mozilla || jQuery.browser.opera)
            document.addEventListener("DOMContentLoaded", jQuery.ready, false);
        else if (jQuery.browser.msie) {
            document.write("<scr" + "ipt id=__ie_init defer=true " + "src=//:><\/script>");
            var script = document.getElementById("__ie_init");
            if (script)
                script.onreadystatechange = function () {
                    if (document.readyState != "complete") return;
                    jQuery.ready();
                };
            script = null;
        } else if (jQuery.browser.safari)
            jQuery.safariTimer = setInterval(function () {
                if (document.readyState == "loaded" || document.readyState == "complete") {
                    clearInterval(jQuery.safariTimer);
                    jQuery.safariTimer = null;
                    jQuery.ready();
                }
            }, 10);
        jQuery.event.add(window, "load", jQuery.ready);
    }
    jQuery.fn.extend({
        loadIfModified: function (url, params, callback) {
            this.load(url, params, callback, 1);
        },
        load: function (url, params, callback, ifModified) {
            if (jQuery.isFunction(url))
                return this.bind("load", url);
            callback = callback || function () {};
            var type = "GET";
            if (params)
                if (jQuery.isFunction(params)) {
                    callback = params;
                    params = null;
                } else {
                    params = jQuery.param(params);
                    type = "POST";
                }
            var self = this;
            jQuery.ajax({
                url: url,
                type: type,
                data: params,
                ifModified: ifModified,
                complete: function (res, status) {
                    if (status == "success" || !ifModified && status == "notmodified")
                        self.html(res.responseText);
                    setTimeout(function () {
                        self.each(callback, [res.responseText, status, res]);
                    }, 13);
                }
            });
            return this;
        },
        serialize: function () {
            return jQuery.param(this);
        },
        evalScripts: function () {}
    });
    jQuery.each("ajaxStart,ajaxStop,ajaxComplete,ajaxError,ajaxSuccess,ajaxSend".split(","), function (i, o) {
        jQuery.fn[o] = function (f) {
            return this.bind(o, f);
        };
    });
    jQuery.extend({
        get: function (url, data, callback, type, ifModified) {
            if (jQuery.isFunction(data)) {
                callback = data;
                data = null;
            }
            return jQuery.ajax({
                type: "GET",
                url: url,
                data: data,
                success: callback,
                dataType: type,
                ifModified: ifModified
            });
        },
        getIfModified: function (url, data, callback, type) {
            return jQuery.get(url, data, callback, type, 1);
        },
        getScript: function (url, callback) {
            return jQuery.get(url, null, callback, "script");
        },
        getJSON: function (url, data, callback) {
            return jQuery.get(url, data, callback, "json");
        },
        post: function (url, data, callback, type) {
            if (jQuery.isFunction(data)) {
                callback = data;
                data = {};
            }
            return jQuery.ajax({
                type: "POST",
                url: url,
                data: data,
                success: callback,
                dataType: type
            });
        },
        ajaxTimeout: function (timeout) {
            jQuery.ajaxSettings.timeout = timeout;
        },
        ajaxSetup: function (settings) {
            jQuery.extend(jQuery.ajaxSettings, settings);
        },
        ajaxSettings: {
            global: true,
            type: "GET",
            timeout: 0,
            contentType: "application/x-www-form-urlencoded",
            processData: true,
            async: true,
            data: null
        },
        lastModified: {},
        ajax: function (s) {
            s = jQuery.extend(true, s, jQuery.extend(true, {}, jQuery.ajaxSettings, s));
            if (s.data) {
                if (s.processData && typeof s.data != "string")
                    s.data = jQuery.param(s.data);
                if (s.type.toLowerCase() == "get") {
                    s.url += (s.url.indexOf("?") > -1 ? "&" : "?") + s.data;
                    s.data = null;
                }
            }
            if (s.global && !jQuery.active++)
                jQuery.event.trigger("ajaxStart");
            var requestDone = false;
            var xml = window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
            xml.open(s.type, s.url, s.async);
            if (s.data)
                xml.setRequestHeader("Content-Type", s.contentType);
            if (s.ifModified)
                xml.setRequestHeader("If-Modified-Since", jQuery.lastModified[s.url] || "Thu, 01 Jan 1970 00:00:00 GMT");
            xml.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            if (s.beforeSend)
                s.beforeSend(xml);
            if (s.global)
                jQuery.event.trigger("ajaxSend", [xml, s]);
            var onreadystatechange = function (isTimeout) {
                if (!requestDone && xml && (xml.readyState == 4 || isTimeout == "timeout")) {
                    requestDone = true;
                    if (ival) {
                        clearInterval(ival);
                        ival = null;
                    }
                    var status = isTimeout == "timeout" && "timeout" || !jQuery.httpSuccess(xml) && "error" || s.ifModified && jQuery.httpNotModified(xml, s.url) && "notmodified" || "success";
                    if (status == "success") {
                        try {
                            var data = jQuery.httpData(xml, s.dataType);
                        } catch (e) {
                            status = "parsererror";
                        }
                    }
                    if (status == "success") {
                        var modRes;
                        try {
                            modRes = xml.getResponseHeader("Last-Modified");
                        } catch (e) {}
                        if (s.ifModified && modRes)
                            jQuery.lastModified[s.url] = modRes;
                        if (s.success)
                            s.success(data, status);
                        if (s.global)
                            jQuery.event.trigger("ajaxSuccess", [xml, s]);
                    } else
                        jQuery.handleError(s, xml, status); if (s.global)
                        jQuery.event.trigger("ajaxComplete", [xml, s]);
                    if (s.global && !--jQuery.active)
                        jQuery.event.trigger("ajaxStop");
                    if (s.complete)
                        s.complete(xml, status);
                    if (s.async)
                        xml = null;
                }
            };
            if (s.async) {
                var ival = setInterval(onreadystatechange, 13);
                if (s.timeout > 0)
                    setTimeout(function () {
                        if (xml) {
                            xml.abort();
                            if (!requestDone)
                                onreadystatechange("timeout");
                        }
                    }, s.timeout);
            }
            try {
                xml.send(s.data);
            } catch (e) {
                jQuery.handleError(s, xml, null, e);
            }
            if (!s.async)
                onreadystatechange();
            return xml;
        },
        handleError: function (s, xml, status, e) {
            if (s.error) s.error(xml, status, e);
            if (s.global)
                jQuery.event.trigger("ajaxError", [xml, s, e]);
        },
        active: 0,
        httpSuccess: function (r) {
            try {
                return !r.status && location.protocol == "file:" || (r.status >= 200 && r.status < 300) || r.status == 304 || jQuery.browser.safari && r.status == undefined;
            } catch (e) {}
            return false;
        },
        httpNotModified: function (xml, url) {
            try {
                var xmlRes = xml.getResponseHeader("Last-Modified");
                return xml.status == 304 || xmlRes == jQuery.lastModified[url] || jQuery.browser.safari && xml.status == undefined;
            } catch (e) {}
            return false;
        },
        httpData: function (r, type) {
            var ct = r.getResponseHeader("content-type");
            var xml = type == "xml" || !type && ct && ct.indexOf("xml") >= 0;
            data = xml ? r.responseXML : r.responseText;
            if (xml && data.documentElement.tagName == "parsererror")
                throw "parsererror";
            if (type == "script")
                jQuery.globalEval(data);
            if (type == "json")
                data = eval("(" + data + ")");
            return data;
        },
        param: function (a) {
            var s = [];
            if (a.constructor == Array || a.jquery)
                jQuery.each(a, function () {
                    s.push(encodeURIComponent(this.name) + "=" + encodeURIComponent(this.value));
                });
            else
                for (var j in a)
                    if (a[j] && a[j].constructor == Array)
                        jQuery.each(a[j], function () {
                            s.push(encodeURIComponent(j) + "=" + encodeURIComponent(this));
                        });
                    else
                        s.push(encodeURIComponent(j) + "=" + encodeURIComponent(a[j])); return s.join("&");
        }
    });
    jQuery.fn.extend({
        show: function (speed, callback) {
            return speed ? this.animate({
                height: "show",
                width: "show",
                opacity: "show"
            }, speed, callback) : this.filter(":hidden").each(function () {
                this.style.display = this.oldblock ? this.oldblock : "";
                if (jQuery.css(this, "display") == "none")
                    this.style.display = "block";
            }).end();
        },
        hide: function (speed, callback) {
            return speed ? this.animate({
                height: "hide",
                width: "hide",
                opacity: "hide"
            }, speed, callback) : this.filter(":visible").each(function () {
                this.oldblock = this.oldblock || jQuery.css(this, "display");
                if (this.oldblock == "none")
                    this.oldblock = "block";
                this.style.display = "none";
            }).end();
        },
        _toggle: jQuery.fn.toggle,
        toggle: function (fn, fn2) {
            return jQuery.isFunction(fn) && jQuery.isFunction(fn2) ? this._toggle(fn, fn2) : fn ? this.animate({
                height: "toggle",
                width: "toggle",
                opacity: "toggle"
            }, fn, fn2) : this.each(function () {
                jQuery(this)[jQuery(this).is(":hidden") ? "show" : "hide"]();
            });
        },
        slideDown: function (speed, callback) {
            return this.animate({
                height: "show"
            }, speed, callback);
        },
        slideUp: function (speed, callback) {
            return this.animate({
                height: "hide"
            }, speed, callback);
        },
        slideToggle: function (speed, callback) {
            return this.animate({
                height: "toggle"
            }, speed, callback);
        },
        fadeIn: function (speed, callback) {
            return this.animate({
                opacity: "show"
            }, speed, callback);
        },
        fadeOut: function (speed, callback) {
            return this.animate({
                opacity: "hide"
            }, speed, callback);
        },
        fadeTo: function (speed, to, callback) {
            return this.animate({
                opacity: to
            }, speed, callback);
        },
        animate: function (prop, speed, easing, callback) {
            return this.queue(function () {
                var hidden = jQuery(this).is(":hidden"),
                    opt = jQuery.speed(speed, easing, callback),
                    self = this;
                for (var p in prop) {
                    if (prop[p] == "hide" && hidden || prop[p] == "show" && !hidden)
                        return jQuery.isFunction(opt.complete) && opt.complete.apply(this);
                    if (p == "height" || p == "width") {
                        opt.display = jQuery.css(this, "display");
                        opt.overflow = this.style.overflow;
                    }
                }
                if (opt.overflow != null)
                    this.style.overflow = "hidden";
                this.curAnim = jQuery.extend({}, prop);
                jQuery.each(prop, function (name, val) {
                    var e = new jQuery.fx(self, opt, name);
                    if (val.constructor == Number)
                        e.custom(e.cur() || 0, val);
                    else
                        e[val == "toggle" ? hidden ? "show" : "hide" : val](prop);
                });
                return true;
            });
        },
        queue: function (type, fn) {
            if (!fn) {
                fn = type;
                type = "fx";
            }
            return this.each(function () {
                if (!this.queue)
                    this.queue = {};
                if (!this.queue[type])
                    this.queue[type] = [];
                this.queue[type].push(fn);
                if (this.queue[type].length == 1)
                    fn.apply(this);
            });
        }
    });
    jQuery.extend({
        speed: function (speed, easing, fn) {
            var opt = speed && speed.constructor == Object ? speed : {
                complete: fn || !fn && easing || jQuery.isFunction(speed) && speed,
                duration: speed,
                easing: fn && easing || easing && easing.constructor != Function && easing
            };
            opt.duration = (opt.duration && opt.duration.constructor == Number ? opt.duration : {
                slow: 600,
                fast: 200
            }[opt.duration]) || 400;
            opt.old = opt.complete;
            opt.complete = function () {
                jQuery.dequeue(this, "fx");
                if (jQuery.isFunction(opt.old))
                    opt.old.apply(this);
            };
            return opt;
        },
        easing: {
            linear: function (p, n, firstNum, diff) {
                return firstNum + diff * p;
            },
            swing: function (p, n, firstNum, diff) {
                return ((-Math.cos(p * Math.PI) / 2) + 0.5) * diff + firstNum;
            }
        },
        queue: {},
        dequeue: function (elem, type) {
            type = type || "fx";
            if (elem.queue && elem.queue[type]) {
                elem.queue[type].shift();
                var f = elem.queue[type][0];
                if (f) f.apply(elem);
            }
        },
        timers: [],
        fx: function (elem, options, prop) {
            var z = this;
            var y = elem.style;
            z.a = function () {
                if (options.step)
                    options.step.apply(elem, [z.now]);
                if (prop == "opacity")
                    jQuery.attr(y, "opacity", z.now);
                else {
                    y[prop] = parseInt(z.now) + "px";
                    if (prop == "height" || prop == "width")
                        y.display = "block";
                }
            };
            z.max = function () {
                return parseFloat(jQuery.css(elem, prop));
            };
            z.cur = function () {
                var r = parseFloat(jQuery.curCSS(elem, prop));
                return r && r > -10000 ? r : z.max();
            };
            z.custom = function (from, to) {
                z.startTime = (new Date()).getTime();
                z.now = from;
                z.a();
                jQuery.timers.push(function () {
                    return z.step(from, to);
                });
                if (jQuery.timers.length == 1) {
                    var timer = setInterval(function () {
                        var timers = jQuery.timers;
                        for (var i = 0; i < timers.length; i++)
                            if (!timers[i]())
                                timers.splice(i--, 1);
                        if (!timers.length)
                            clearInterval(timer);
                    }, 13);
                }
            };
            z.show = function () {
                if (!elem.orig) elem.orig = {};
                elem.orig[prop] = jQuery.attr(elem.style, prop);
                options.show = true;
                z.custom(0, this.cur());
                if (prop != "opacity")
                    y[prop] = "1px";
                jQuery(elem).show();
            };
            z.hide = function () {
                if (!elem.orig) elem.orig = {};
                elem.orig[prop] = jQuery.attr(elem.style, prop);
                options.hide = true;
                z.custom(this.cur(), 0);
            };
            z.step = function (firstNum, lastNum) {
                var t = (new Date()).getTime();
                if (t > options.duration + z.startTime) {
                    z.now = lastNum;
                    z.a();
                    if (elem.curAnim) elem.curAnim[prop] = true;
                    var done = true;
                    for (var i in elem.curAnim)
                        if (elem.curAnim[i] !== true)
                            done = false;
                    if (done) {
                        if (options.display != null) {
                            y.overflow = options.overflow;
                            y.display = options.display;
                            if (jQuery.css(elem, "display") == "none")
                                y.display = "block";
                        }
                        if (options.hide)
                            y.display = "none";
                        if (options.hide || options.show)
                            for (var p in elem.curAnim)
                                jQuery.attr(y, p, elem.orig[p]);
                    }
                    if (done && jQuery.isFunction(options.complete))
                        options.complete.apply(elem);
                    return false;
                } else {
                    var n = t - this.startTime;
                    var p = n / options.duration;
                    z.now = jQuery.easing[options.easing || (jQuery.easing.swing ? "swing" : "linear")](p, n, firstNum, (lastNum - firstNum), options.duration);
                    z.a();
                }
                return true;
            };
        }
    });
})();
jQuery.iTooltip = {
    current: null,
    focused: false,
    oldTitle: null,
    focus: function (e) {
        jQuery.iTooltip.focused = true;
        jQuery.iTooltip.show(e, this, true);
    },
    hidefocused: function (e) {
        if (jQuery.iTooltip.current != this)
            return;
        jQuery.iTooltip.focused = false;
        jQuery.iTooltip.hide(e, this);
    },
    show: function (e, el, focused) {
        if (jQuery.iTooltip.current != null)
            return;
        if (!el) {
            el = this;
        }
        jQuery.iTooltip.current = el;
        pos = jQuery.extend(jQuery.iUtil.getPosition(el), jQuery.iUtil.getSize(el));
        jEl = jQuery(el);
        title = jEl.attr('title');
        href = jEl.attr('href');
        if (title) {
            jQuery.iTooltip.oldTitle = title;
            jEl.attr('title', '');
            jQuery('#tooltipTitle').html(title);
            if (href)
                jQuery('#tooltipURL').html(href.replace('http://', ''));
            else
                jQuery('#tooltipURL').html('');
            helper = jQuery('#tooltipHelper');
            if (el.tooltipCFG.className) {
                helper.get(0).className = el.tooltipCFG.className;
            } else {
                helper.get(0).className = '';
            }
            helperSize = jQuery.iUtil.getSize(helper.get(0));
            filteredPosition = focused && el.tooltipCFG.position == 'mouse' ? 'bottom' : el.tooltipCFG.position;
            switch (filteredPosition) {
            case 'top':
                ny = pos.y - helperSize.hb;
                nx = pos.x;
                break;
            case 'left':
                ny = pos.y;
                nx = pos.x - helperSize.wb;
                break;
            case 'right':
                ny = pos.y;
                nx = pos.x + pos.wb;
                break;
            case 'mouse':
                jQuery('body').bind('mousemove', jQuery.iTooltip.mousemove);
                pointer = jQuery.iUtil.getPointer(e);
                ny = pointer.y + 15;
                nx = pointer.x + 15;
                break;
            default:
                ny = pos.y + pos.hb;
                nx = pos.x;
                break;
            }
            helper.css({
                top: ny + 'px',
                left: nx + 'px'
            });
            if (el.tooltipCFG.delay == false) {
                helper.show();
            } else {
                helper.fadeIn(el.tooltipCFG.delay);
            }
            if (el.tooltipCFG.onShow)
                el.tooltipCFG.onShow.apply(el);
            jEl.bind('mouseout', jQuery.iTooltip.hide).bind('blur', jQuery.iTooltip.hidefocused);
        }
    },
    mousemove: function (e) {
        if (jQuery.iTooltip.current == null) {
            jQuery('body').unbind('mousemove', jQuery.iTooltip.mousemove);
            return;
        }
        pointer = jQuery.iUtil.getPointer(e);
        jQuery('#tooltipHelper').css({
            top: pointer.y + 15 + 'px',
            left: pointer.x + 15 + 'px'
        });
    },
    hide: function (e, el) {
        if (!el) {
            el = this;
        }
        if (jQuery.iTooltip.focused != true && jQuery.iTooltip.current == el) {
            jQuery.iTooltip.current = null;
            jQuery('#tooltipHelper').fadeOut(1);
            jQuery(el).attr('title', jQuery.iTooltip.oldTitle).unbind('mouseout', jQuery.iTooltip.hide).unbind('blur', jQuery.iTooltip.hidefocused);
            if (el.tooltipCFG.onHide)
                el.tooltipCFG.onHide.apply(el);
            jQuery.iTooltip.oldTitle = null;
        }
    },
    build: function (options) {
        if (!jQuery.iTooltip.helper) {
            jQuery('body').append('<div id="tooltipHelper"><div id="tooltipTitle"></div><div id="tooltipURL"></div></div>');
            jQuery('#tooltipHelper').css({
                position: 'absolute',
                zIndex: 3000,
                display: 'none'
            });
            jQuery.iTooltip.helper = true;
        }
        return this.each(function () {
            if (jQuery.attr(this, 'title')) {
                this.tooltipCFG = {
                    position: /top|bottom|left|right|mouse/.test(options.position) ? options.position : 'bottom',
                    className: options.className ? options.className : false,
                    delay: options.delay ? options.delay : false,
                    onShow: options.onShow && options.onShow.constructor == Function ? options.onShow : false,
                    onHide: options.onHide && options.onHide.constructor == Function ? options.onHide : false
                };
                var el = jQuery(this);
                el.bind('mouseover', jQuery.iTooltip.show);
                el.bind('focus', jQuery.iTooltip.focus);
            }
        });
    }
};
jQuery.fn.ToolTip = jQuery.iTooltip.build;
jQuery.iAuto = {
    helper: null,
    content: null,
    iframe: null,
    timer: null,
    lastValue: null,
    currentValue: null,
    subject: null,
    selectedItem: null,
    items: null,
    empty: function () {
        jQuery.iAuto.content.empty();
        if (jQuery.iAuto.iframe) {
            jQuery.iAuto.iframe.hide();
        }
    },
    clear: function () {
        jQuery.iAuto.items = null;
        jQuery.iAuto.selectedItem = null;
        jQuery.iAuto.lastValue = jQuery.iAuto.subject.value;
        if (jQuery.iAuto.helper.css('display') == 'block') {
            if (jQuery.iAuto.subject.autoCFG.fx) {
                switch (jQuery.iAuto.subject.autoCFG.fx.type) {
                case 'fade':
                    jQuery.iAuto.helper.fadeOut(jQuery.iAuto.subject.autoCFG.fx.duration, jQuery.iAuto.empty);
                    break;
                case 'slide':
                    jQuery.iAuto.helper.SlideOutUp(jQuery.iAuto.subject.autoCFG.fx.duration, jQuery.iAuto.empty);
                    break;
                case 'blind':
                    jQuery.iAuto.helper.BlindUp(jQuery.iAuto.subject.autoCFG.fx.duration, jQuery.iAuto.empty);
                    break;
                }
            } else {
                jQuery.iAuto.helper.hide();
            }
            if (jQuery.iAuto.subject.autoCFG.onHide)
                jQuery.iAuto.subject.autoCFG.onHide.apply(jQuery.iAuto.subject, [jQuery.iAuto.helper, jQuery.iAuto.iframe]);
        } else {
            jQuery.iAuto.empty();
        }
        window.clearTimeout(jQuery.iAuto.timer);
    },
    update: function () {
        var subject = jQuery.iAuto.subject;
        var subjectValue = jQuery.iAuto.getFieldValues(subject);
        if (subject && subjectValue.item != jQuery.iAuto.lastValue && subjectValue.item.length >= subject.autoCFG.minchars) {
            jQuery.iAuto.lastValue = subjectValue.item;
            jQuery.iAuto.currentValue = subjectValue.item;
            data = {
                field: jQuery(subject).attr('name') || 'field',
                value: subjectValue.item
            };
            jQuery.ajax({
                type: 'POST',
                data: jQuery.param(data),
                success: function (xml) {
                    subject.autoCFG.lastSuggestion = jQuery('item', xml);
                    size = subject.autoCFG.lastSuggestion.size();
                    if (size > 0) {
                        var toWrite = '';
                        subject.autoCFG.lastSuggestion.each(function (nr) {
                            toWrite += '<li rel="' + jQuery('value', this).text() + '" dir="' + nr + '" style="cursor: default;">' + jQuery('text', this).text() + '</li>';
                        });
                        if (subject.autoCFG.autofill) {
                            var valueToAdd = jQuery('value', subject.autoCFG.lastSuggestion.get(0)).text();
                            subject.value = subjectValue.pre + valueToAdd + subject.autoCFG.multipleSeparator + subjectValue.post;
                            jQuery.iAuto.selection(subject, subjectValue.item.length != valueToAdd.length ? (subjectValue.pre.length + subjectValue.item.length) : valueToAdd.length, subjectValue.item.length != valueToAdd.length ? (subjectValue.pre.length + valueToAdd.length) : valueToAdd.length);
                        }
                        if (size > 0) {
                            jQuery.iAuto.writeItems(subject, toWrite);
                        } else {
                            jQuery.iAuto.clear();
                        }
                    } else {
                        jQuery.iAuto.clear();
                    }
                },
                url: subject.autoCFG.source
            });
        }
    },
    writeItems: function (subject, toWrite) {
        jQuery.iAuto.content.html(toWrite);
        jQuery.iAuto.items = jQuery('li', jQuery.iAuto.content.get(0));
        jQuery.iAuto.items.mouseover(jQuery.iAuto.hoverItem).bind('click', jQuery.iAuto.clickItem);
        var position = jQuery.iUtil.getPosition(subject);
        var size = jQuery.iUtil.getSize(subject);
        jQuery.iAuto.helper.css('top', position.y + size.hb + 'px').css('left', position.x + 'px').addClass(subject.autoCFG.helperClass);
        if (jQuery.iAuto.iframe) {
            jQuery.iAuto.iframe.css('display', 'block').css('top', position.y + size.hb + 'px').css('left', position.x + 'px').css('width', jQuery.iAuto.helper.css('width')).css('height', jQuery.iAuto.helper.css('height'));
        }
        jQuery.iAuto.selectedItem = 0;
        jQuery.iAuto.items.get(0).className = subject.autoCFG.selectClass;
        jQuery.iAuto.applyOn(subject, subject.autoCFG.lastSuggestion.get(0), 'onHighlight');
        if (jQuery.iAuto.helper.css('display') == 'none') {
            if (subject.autoCFG.inputWidth) {
                var borders = jQuery.iUtil.getPadding(subject, true);
                var paddings = jQuery.iUtil.getBorder(subject, true);
                jQuery.iAuto.helper.css('width', subject.offsetWidth - (jQuery.boxModel ? (borders.l + borders.r + paddings.l + paddings.r) : 0) + 'px');
            }
            if (subject.autoCFG.fx) {
                switch (subject.autoCFG.fx.type) {
                case 'fade':
                    jQuery.iAuto.helper.fadeIn(subject.autoCFG.fx.duration);
                    break;
                case 'slide':
                    jQuery.iAuto.helper.SlideInUp(subject.autoCFG.fx.duration);
                    break;
                case 'blind':
                    jQuery.iAuto.helper.BlindDown(subject.autoCFG.fx.duration);
                    break;
                }
            } else {
                jQuery.iAuto.helper.show();
            }
            if (jQuery.iAuto.subject.autoCFG.onShow)
                jQuery.iAuto.subject.autoCFG.onShow.apply(jQuery.iAuto.subject, [jQuery.iAuto.helper, jQuery.iAuto.iframe]);
        }
    },
    checkCache: function () {
        var subject = this;
        if (subject.autoCFG.lastSuggestion) {
            jQuery.iAuto.lastValue = subject.value;
            jQuery.iAuto.currentValue = subject.value;
            var toWrite = '';
            subject.autoCFG.lastSuggestion.each(function (nr) {
                value = jQuery('value', this).text().toLowerCase();
                inputValue = subject.value.toLowerCase();
                if (value.indexOf(inputValue) == 0) {
                    toWrite += '<li rel="' + jQuery('value', this).text() + '" dir="' + nr + '" style="cursor: default;">' + jQuery('text', this).text() + '</li>';
                }
            });
            if (toWrite != '') {
                jQuery.iAuto.writeItems(subject, toWrite);
                this.autoCFG.inCache = true;
                return;
            }
        }
        subject.autoCFG.lastSuggestion = null;
        this.autoCFG.inCache = false;
    },
    selection: function (field, start, end) {
        if (field.createTextRange) {
            var selRange = field.createTextRange();
            selRange.collapse(true);
            selRange.moveStart("character", start);
            selRange.moveEnd("character", -end + start);
            selRange.select();
        } else if (field.setSelectionRange) {
            field.setSelectionRange(start, end);
        } else {
            if (field.selectionStart) {
                field.selectionStart = start;
                field.selectionEnd = end;
            }
        }
        field.focus();
    },
    getSelectionStart: function (field) {
        if (field.selectionStart)
            return field.selectionStart;
        else if (field.createTextRange) {
            var selRange = document.selection.createRange();
            var selRange2 = selRange.duplicate();
            return 0 - selRange2.moveStart('character', -100000);
        }
    },
    getFieldValues: function (field) {
        var fieldData = {
            value: field.value,
            pre: '',
            post: '',
            item: ''
        };
        if (field.autoCFG.multiple) {
            var finishedPre = false;
            var selectionStart = jQuery.iAuto.getSelectionStart(field) || 0;
            var chunks = fieldData.value.split(field.autoCFG.multipleSeparator);
            for (var i = 0; i < chunks.length; i++) {
                if ((fieldData.pre.length + chunks[i].length >= selectionStart || selectionStart == 0) && !finishedPre) {
                    if (fieldData.pre.length <= selectionStart)
                        fieldData.item = chunks[i];
                    else
                        fieldData.post += chunks[i] + (chunks[i] != '' ? field.autoCFG.multipleSeparator : '');
                    finishedPre = true;
                } else if (finishedPre) {
                    fieldData.post += chunks[i] + (chunks[i] != '' ? field.autoCFG.multipleSeparator : '');
                }
                if (!finishedPre) {
                    fieldData.pre += chunks[i] + (chunks.length > 1 ? field.autoCFG.multipleSeparator : '');
                }
            }
        } else {
            fieldData.item = fieldData.value;
        }
        return fieldData;
    },
    autocomplete: function (e) {
        window.clearTimeout(jQuery.iAuto.timer);
        var subject = jQuery.iAuto.getFieldValues(this);
        var pressedKey = e.charCode || e.keyCode || -1;
        if (/13|27|35|36|38|40|9/.test(pressedKey) && jQuery.iAuto.items) {
            if (window.event) {
                window.event.cancelBubble = true;
                window.event.returnValue = false;
            } else {
                e.preventDefault();
                e.stopPropagation();
            }
            if (jQuery.iAuto.selectedItem != null)
                jQuery.iAuto.items.get(jQuery.iAuto.selectedItem || 0).className = '';
            else
                jQuery.iAuto.selectedItem = -1;
            switch (pressedKey) {
            case 9:
            case 13:
                if (jQuery.iAuto.selectedItem == -1)
                    jQuery.iAuto.selectedItem = 0;
                var selectedItem = jQuery.iAuto.items.get(jQuery.iAuto.selectedItem || 0);
                var valueToAdd = selectedItem.getAttribute('rel');
                this.value = subject.pre + valueToAdd + this.autoCFG.multipleSeparator + subject.post;
                jQuery.iAuto.lastValue = subject.item;
                jQuery.iAuto.selection(this, subject.pre.length + valueToAdd.length + this.autoCFG.multipleSeparator.length, subject.pre.length + valueToAdd.length + this.autoCFG.multipleSeparator.length);
                jQuery.iAuto.clear();
                if (this.autoCFG.onSelect) {
                    iteration = parseInt(selectedItem.getAttribute('dir')) || 0;
                    jQuery.iAuto.applyOn(this, this.autoCFG.lastSuggestion.get(iteration), 'onSelect');
                }
                if (this.scrollIntoView)
                    this.scrollIntoView(false);
                return pressedKey != 13;
                break;
            case 27:
                this.value = subject.pre + jQuery.iAuto.lastValue + this.autoCFG.multipleSeparator + subject.post;
                this.autoCFG.lastSuggestion = null;
                jQuery.iAuto.clear();
                if (this.scrollIntoView)
                    this.scrollIntoView(false);
                return false;
                break;
            case 35:
                jQuery.iAuto.selectedItem = jQuery.iAuto.items.size() - 1;
                break;
            case 36:
                jQuery.iAuto.selectedItem = 0;
                break;
            case 38:
                jQuery.iAuto.selectedItem--;
                if (jQuery.iAuto.selectedItem < 0)
                    jQuery.iAuto.selectedItem = jQuery.iAuto.items.size() - 1;
                break;
            case 40:
                jQuery.iAuto.selectedItem++;
                if (jQuery.iAuto.selectedItem == jQuery.iAuto.items.size())
                    jQuery.iAuto.selectedItem = 0;
                break;
            }
            jQuery.iAuto.applyOn(this, this.autoCFG.lastSuggestion.get(jQuery.iAuto.selectedItem || 0), 'onHighlight');
            jQuery.iAuto.items.get(jQuery.iAuto.selectedItem || 0).className = this.autoCFG.selectClass;
            if (jQuery.iAuto.items.get(jQuery.iAuto.selectedItem || 0).scrollIntoView)
                jQuery.iAuto.items.get(jQuery.iAuto.selectedItem || 0).scrollIntoView(false);
            if (this.autoCFG.autofill) {
                var valToAdd = jQuery.iAuto.items.get(jQuery.iAuto.selectedItem || 0).getAttribute('rel');
                this.value = subject.pre + valToAdd + this.autoCFG.multipleSeparator + subject.post;
                if (jQuery.iAuto.lastValue.length != valToAdd.length)
                    jQuery.iAuto.selection(this, subject.pre.length + jQuery.iAuto.lastValue.length, subject.pre.length + valToAdd.length);
            }
            return false;
        }
        jQuery.iAuto.checkCache.apply(this);
        if (this.autoCFG.inCache == false) {
            if (subject.item != jQuery.iAuto.lastValue && subject.item.length >= this.autoCFG.minchars)
                jQuery.iAuto.timer = window.setTimeout(jQuery.iAuto.update, this.autoCFG.delay);
            if (jQuery.iAuto.items) {
                jQuery.iAuto.clear();
            }
        }
        return true;
    },
    applyOn: function (field, item, type) {
        if (field.autoCFG[type]) {
            var data = {};
            childs = item.getElementsByTagName('*');
            for (i = 0; i < childs.length; i++) {
                data[childs[i].tagName] = childs[i].firstChild.nodeValue;
            }
            field.autoCFG[type].apply(field, [data]);
        }
    },
    hoverItem: function (e) {
        if (jQuery.iAuto.items) {
            if (jQuery.iAuto.selectedItem != null)
                jQuery.iAuto.items.get(jQuery.iAuto.selectedItem || 0).className = '';
            jQuery.iAuto.items.get(jQuery.iAuto.selectedItem || 0).className = '';
            jQuery.iAuto.selectedItem = parseInt(this.getAttribute('dir')) || 0;
            jQuery.iAuto.items.get(jQuery.iAuto.selectedItem || 0).className = jQuery.iAuto.subject.autoCFG.selectClass;
        }
    },
    clickItem: function (event) {
        window.clearTimeout(jQuery.iAuto.timer);
        event = event || jQuery.event.fix(window.event);
        event.preventDefault();
        event.stopPropagation();
        var subject = jQuery.iAuto.getFieldValues(jQuery.iAuto.subject);
        var valueToAdd = this.getAttribute('rel');
        jQuery.iAuto.subject.value = subject.pre + valueToAdd + jQuery.iAuto.subject.autoCFG.multipleSeparator + subject.post;
        jQuery.iAuto.lastValue = this.getAttribute('rel');
        jQuery.iAuto.selection(jQuery.iAuto.subject, subject.pre.length + valueToAdd.length + jQuery.iAuto.subject.autoCFG.multipleSeparator.length, subject.pre.length + valueToAdd.length + jQuery.iAuto.subject.autoCFG.multipleSeparator.length);
        jQuery.iAuto.clear();
        if (jQuery.iAuto.subject.autoCFG.onSelect) {
            iteration = parseInt(this.getAttribute('dir')) || 0;
            jQuery.iAuto.applyOn(jQuery.iAuto.subject, jQuery.iAuto.subject.autoCFG.lastSuggestion.get(iteration), 'onSelect');
        }
        return false;
    },
    protect: function (e) {
        pressedKey = e.charCode || e.keyCode || -1;
        if (/13|27|35|36|38|40/.test(pressedKey) && jQuery.iAuto.items) {
            if (window.event) {
                window.event.cancelBubble = true;
                window.event.returnValue = false;
            } else {
                e.preventDefault();
                e.stopPropagation();
            }
            return false;
        }
    },
    build: function (options) {
        if (!options.source || !jQuery.iUtil) {
            return;
        }
        if (!jQuery.iAuto.helper) {
            if (jQuery.browser.msie) {
                jQuery('body', document).append('<iframe style="display:none;position:absolute;filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);" id="autocompleteIframe" src="javascript:false;" frameborder="0" scrolling="no"></iframe>');
                jQuery.iAuto.iframe = jQuery('#autocompleteIframe');
            }
            jQuery('body', document).append('<div id="autocompleteHelper" style="position: absolute; top: 0; left: 0; z-index: 30001; display: none;"><ul style="margin: 0;padding: 0; list-style: none; z-index: 30002;">&nbsp;</ul></div>');
            jQuery.iAuto.helper = jQuery('#autocompleteHelper');
            jQuery.iAuto.content = jQuery('ul', jQuery.iAuto.helper);
        }
        return this.each(function () {
            if (this.tagName != 'INPUT' && this.getAttribute('type') != 'text')
                return;
            this.autoCFG = {};
            this.autoCFG.source = options.source;
            this.autoCFG.minchars = Math.abs(parseInt(options.minchars) || 1);
            this.autoCFG.helperClass = options.helperClass ? options.helperClass : '';
            this.autoCFG.selectClass = options.selectClass ? options.selectClass : '';
            this.autoCFG.onSelect = options.onSelect && options.onSelect.constructor == Function ? options.onSelect : null;
            this.autoCFG.onShow = options.onShow && options.onShow.constructor == Function ? options.onShow : null;
            this.autoCFG.onHide = options.onHide && options.onHide.constructor == Function ? options.onHide : null;
            this.autoCFG.onHighlight = options.onHighlight && options.onHighlight.constructor == Function ? options.onHighlight : null;
            this.autoCFG.inputWidth = options.inputWidth || false;
            this.autoCFG.multiple = options.multiple || false;
            this.autoCFG.multipleSeparator = this.autoCFG.multiple ? (options.multipleSeparator || ', ') : '';
            this.autoCFG.autofill = options.autofill ? true : false;
            this.autoCFG.delay = Math.abs(parseInt(options.delay) || 1000);
            if (options.fx && options.fx.constructor == Object) {
                if (!options.fx.type || !/fade|slide|blind/.test(options.fx.type)) {
                    options.fx.type = 'slide';
                }
                if (options.fx.type == 'slide' && !jQuery.fx.slide)
                    return;
                if (options.fx.type == 'blind' && !jQuery.fx.BlindDirection)
                    return;
                options.fx.duration = Math.abs(parseInt(options.fx.duration) || 400);
                if (options.fx.duration > this.autoCFG.delay) {
                    options.fx.duration = this.autoCFG.delay - 100;
                }
                this.autoCFG.fx = options.fx;
            }
            this.autoCFG.lastSuggestion = null;
            this.autoCFG.inCache = false;
            jQuery(this).attr('autocomplete', 'off').focus(function () {
                jQuery.iAuto.subject = this;
                jQuery.iAuto.lastValue = this.value;
            }).keypress(jQuery.iAuto.protect).keyup(jQuery.iAuto.autocomplete).blur(function () {
                jQuery.iAuto.timer = window.setTimeout(jQuery.iAuto.clear, 200);
            });
        });
    }
};
jQuery.fn.Autocomplete = jQuery.iAuto.build;
jQuery.iAccordion = {
    build: function (options) {
        return this.each(function () {
            if (!options.headerSelector || !options.panelSelector)
                return;
            var el = this;
            el.accordionCfg = {
                panelHeight: options.panelHeight || 300,
                headerSelector: options.headerSelector,
                panelSelector: options.panelSelector,
                activeClass: options.activeClass || 'fakeAccordionClass',
                hoverClass: options.hoverClass || 'fakeAccordionClass',
                onShow: options.onShow && typeof options.onShow == 'function' ? options.onShow : false,
                onHide: options.onShow && typeof options.onHide == 'function' ? options.onHide : false,
                onClick: options.onClick && typeof options.onClick == 'function' ? options.onClick : false,
                headers: jQuery(options.headerSelector, this),
                panels: jQuery(options.panelSelector, this),
                speed: options.speed || 400,
                currentPanel: options.currentPanel || 0
            };
            el.accordionCfg.panels.hide().css('height', '1px').eq(0).css({
                height: el.accordionCfg.panelHeight + 'px',
                display: 'block'
            }).end();
            el.accordionCfg.headers.each(function (nr) {
                this.accordionPos = nr;
            }).hover(function () {
                jQuery(this).addClass(el.accordionCfg.hoverClass);
            }, function () {
                jQuery(this).removeClass(el.accordionCfg.hoverClass);
            }).bind('click', function (e) {
                if (el.accordionCfg.currentPanel == this.accordionPos)
                    return;
                el.accordionCfg.headers.eq(el.accordionCfg.currentPanel).removeClass(el.accordionCfg.activeClass).end().eq(this.accordionPos).addClass(el.accordionCfg.activeClass).end();
                el.accordionCfg.panels.eq(el.accordionCfg.currentPanel).animate({
                    height: 0
                }, el.accordionCfg.speed, function () {
                    this.style.display = 'none';
                    if (el.accordionCfg.onHide) {
                        el.accordionCfg.onHide.apply(el, [this]);
                    }
                }).end().eq(this.accordionPos).show().animate({
                    height: el.accordionCfg.panelHeight
                }, el.accordionCfg.speed, function () {
                    this.style.display = 'block';
                    if (el.accordionCfg.onShow) {
                        el.accordionCfg.onShow.apply(el, [this]);
                    }
                }).end();
                if (el.accordionCfg.onClick) {
                    el.accordionCfg.onClick.apply(el, [this, el.accordionCfg.panels.get(this.accordionPos), el.accordionCfg.headers.get(el.accordionCfg.currentPanel), el.accordionCfg.panels.get(el.accordionCfg.currentPanel)]);
                }
                el.accordionCfg.currentPanel = this.accordionPos;
            }).eq(0).addClass(el.accordionCfg.activeClass).end();
            jQuery(this).css('height', jQuery(this).css('height')).css('overflow', 'hidden');
        });
    }
};
jQuery.fn.Accordion = jQuery.iAccordion.build;
jQuery.fxCheckTag = function (e) {
    if (/^tr$|^td$|^tbody$|^caption$|^thead$|^tfoot$|^col$|^colgroup$|^th$|^body$|^header$|^script$|^frame$|^frameset$|^option$|^optgroup$|^meta$/i.test(e.nodeName))
        return false;
    else
        return true;
};
jQuery.fx.destroyWrapper = function (e, old) {
    var c = e.firstChild;
    var cs = c.style;
    cs.position = old.position;
    cs.marginTop = old.margins.t;
    cs.marginLeft = old.margins.l;
    cs.marginBottom = old.margins.b;
    cs.marginRight = old.margins.r;
    cs.top = old.top + 'px';
    cs.left = old.left + 'px';
    e.parentNode.insertBefore(c, e);
    e.parentNode.removeChild(e);
};
jQuery.fx.buildWrapper = function (e) {
    if (!jQuery.fxCheckTag(e))
        return false;
    var t = jQuery(e);
    var es = e.style;
    var restoreStyle = false;
    if (t.css('display') == 'none') {
        oldVisibility = t.css('visibility');
        t.css('visibility', 'hidden').show();
        restoreStyle = true;
    }
    var oldStyle = {};
    oldStyle.position = t.css('position');
    oldStyle.sizes = jQuery.iUtil.getSize(e);
    oldStyle.margins = jQuery.iUtil.getMargins(e);
    var oldFloat = e.currentStyle ? e.currentStyle.styleFloat : t.css('float');
    oldStyle.top = parseInt(t.css('top')) || 0;
    oldStyle.left = parseInt(t.css('left')) || 0;
    var wid = 'w_' + parseInt(Math.random() * 10000);
    var wr = document.createElement(/^img$|^br$|^input$|^hr$|^select$|^textarea$|^object$|^iframe$|^button$|^form$|^table$|^ul$|^dl$|^ol$/i.test(e.nodeName) ? 'div' : e.nodeName);
    jQuery.attr(wr, 'id', wid);
    var wrapEl = jQuery(wr).addClass('fxWrapper');
    var wrs = wr.style;
    var top = 0;
    var left = 0;
    if (oldStyle.position == 'relative' || oldStyle.position == 'absolute') {
        top = oldStyle.top;
        left = oldStyle.left;
    }
    wrs.top = top + 'px';
    wrs.left = left + 'px';
    wrs.position = oldStyle.position != 'relative' && oldStyle.position != 'absolute' ? 'relative' : oldStyle.position;
    wrs.height = oldStyle.sizes.hb + 'px';
    wrs.width = oldStyle.sizes.wb + 'px';
    wrs.marginTop = oldStyle.margins.t;
    wrs.marginRight = oldStyle.margins.r;
    wrs.marginBottom = oldStyle.margins.b;
    wrs.marginLeft = oldStyle.margins.l;
    wrs.overflow = 'hidden';
    if (jQuery.browser.msie) {
        wrs.styleFloat = oldFloat;
    } else {
        wrs.cssFloat = oldFloat;
    }
    if (jQuery.browser == "msie") {
        es.filter = "alpha(opacity=" + 0.999 * 100 + ")";
    }
    es.opacity = 0.999;
    e.parentNode.insertBefore(wr, e);
    wr.appendChild(e);
    es.marginTop = '0px';
    es.marginRight = '0px';
    es.marginBottom = '0px';
    es.marginLeft = '0px';
    es.position = 'absolute';
    es.listStyle = 'none';
    es.top = '0px';
    es.left = '0px';
    if (restoreStyle) {
        t.hide();
        es.visibility = oldVisibility;
    }
    return {
        oldStyle: oldStyle,
        wrapper: jQuery(wr)
    };
};
jQuery.fx.namedColors = {
    aqua: [0, 255, 255],
    azure: [240, 255, 255],
    beige: [245, 245, 220],
    black: [0, 0, 0],
    blue: [0, 0, 255],
    brown: [165, 42, 42],
    cyan: [0, 255, 255],
    darkblue: [0, 0, 139],
    darkcyan: [0, 139, 139],
    darkgrey: [169, 169, 169],
    darkgreen: [0, 100, 0],
    darkkhaki: [189, 183, 107],
    darkmagenta: [139, 0, 139],
    darkolivegreen: [85, 107, 47],
    darkorange: [255, 140, 0],
    darkorchid: [153, 50, 204],
    darkred: [139, 0, 0],
    darksalmon: [233, 150, 122],
    darkviolet: [148, 0, 211],
    fuchsia: [255, 0, 255],
    gold: [255, 215, 0],
    green: [0, 128, 0],
    indigo: [75, 0, 130],
    khaki: [240, 230, 140],
    lightblue: [173, 216, 230],
    lightcyan: [224, 255, 255],
    lightgreen: [144, 238, 144],
    lightgrey: [211, 211, 211],
    lightpink: [255, 182, 193],
    lightyellow: [255, 255, 224],
    lime: [0, 255, 0],
    magenta: [255, 0, 255],
    maroon: [128, 0, 0],
    navy: [0, 0, 128],
    olive: [128, 128, 0],
    orange: [255, 165, 0],
    pink: [255, 192, 203],
    purple: [128, 0, 128],
    red: [255, 0, 0],
    silver: [192, 192, 192],
    white: [255, 255, 255],
    yellow: [255, 255, 0]
};
jQuery.fx.parseColor = function (color, notColor) {
    if (jQuery.fx.namedColors[color])
        return {
            r: jQuery.fx.namedColors[color][0],
            g: jQuery.fx.namedColors[color][1],
            b: jQuery.fx.namedColors[color][2]
        };
    else if (result = /^rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)$/.exec(color))
        return {
            r: parseInt(result[1]),
            g: parseInt(result[2]),
            b: parseInt(result[3])
        };
    else if (result = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)$/.exec(color))
        return {
            r: parseFloat(result[1]) * 2.55,
            g: parseFloat(result[2]) * 2.55,
            b: parseFloat(result[3]) * 2.55
        };
    else if (result = /^#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])$/.exec(color))
        return {
            r: parseInt("0x" + result[1] + result[1]),
            g: parseInt("0x" + result[2] + result[2]),
            b: parseInt("0x" + result[3] + result[3])
        };
    else if (result = /^#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})$/.exec(color))
        return {
            r: parseInt("0x" + result[1]),
            g: parseInt("0x" + result[2]),
            b: parseInt("0x" + result[3])
        };
    else
        return notColor == true ? false : {
            r: 255,
            g: 255,
            b: 255
        };
};
jQuery.fx.cssProps = {
    borderBottomWidth: 1,
    borderLeftWidth: 1,
    borderRightWidth: 1,
    borderTopWidth: 1,
    bottom: 1,
    fontSize: 1,
    height: 1,
    left: 1,
    letterSpacing: 1,
    lineHeight: 1,
    marginBottom: 1,
    marginLeft: 1,
    marginRight: 1,
    marginTop: 1,
    maxHeight: 1,
    maxWidth: 1,
    minHeight: 1,
    minWidth: 1,
    opacity: 1,
    outlineOffset: 1,
    outlineWidth: 1,
    paddingBottom: 1,
    paddingLeft: 1,
    paddingRight: 1,
    paddingTop: 1,
    right: 1,
    textIndent: 1,
    top: 1,
    width: 1,
    zIndex: 1
};
jQuery.fx.colorCssProps = {
    backgroundColor: 1,
    borderBottomColor: 1,
    borderLeftColor: 1,
    borderRightColor: 1,
    borderTopColor: 1,
    color: 1,
    outlineColor: 1
};
jQuery.fx.cssSides = ['Top', 'Right', 'Bottom', 'Left'];
jQuery.fx.cssSidesEnd = {
    'borderWidth': ['border', 'Width'],
    'borderColor': ['border', 'Color'],
    'margin': ['margin', ''],
    'padding': ['padding', '']
};
jQuery.fn.extend({
    animate: function (prop, speed, easing, callback) {
        return this.queue(function () {
            var opt = jQuery.speed(speed, easing, callback);
            var e = new jQuery.fxe(this, opt, prop);
        });
    },
    pause: function (speed, callback) {
        return this.queue(function () {
            var opt = jQuery.speed(speed, callback);
            var e = new jQuery.pause(this, opt);
        });
    },
    stop: function (step) {
        return this.each(function () {
            if (this.animationHandler)
                jQuery.stopAnim(this, step);
        });
    },
    stopAll: function (step) {
        return this.each(function () {
            if (this.animationHandler)
                jQuery.stopAnim(this, step);
            if (this.queue && this.queue['fx'])
                this.queue.fx = [];
        });
    }
});
jQuery.extend({
    pause: function (elem, options) {
        var z = this,
            values;
        z.step = function () {
            if (jQuery.isFunction(options.complete))
                options.complete.apply(elem);
        };
        z.timer = setInterval(function () {
            z.step();
        }, options.duration);
        elem.animationHandler = z;
    },
    easing: {
        linear: function (p, n, firstNum, delta, duration) {
            return ((-Math.cos(p * Math.PI) / 2) + 0.5) * delta + firstNum;
        }
    },
    fxe: function (elem, options, prop) {
        var z = this,
            values;
        var y = elem.style;
        var oldOverflow = jQuery.css(elem, "overflow");
        var oldDisplay = jQuery.css(elem, "display");
        var props = {};
        z.startTime = (new Date()).getTime();
        options.easing = options.easing && jQuery.easing[options.easing] ? options.easing : 'linear';
        z.getValues = function (tp, vp) {
            if (jQuery.fx.cssProps[tp]) {
                if (vp == 'show' || vp == 'hide' || vp == 'toggle') {
                    if (!elem.orig) elem.orig = {};
                    var r = parseFloat(jQuery.curCSS(elem, tp));
                    elem.orig[tp] = r && r > -10000 ? r : (parseFloat(jQuery.css(elem, tp)) || 0);
                    vp = vp == 'toggle' ? (oldDisplay == 'none' ? 'show' : 'hide') : vp;
                    options[vp] = true;
                    props[tp] = vp == 'show' ? [0, elem.orig[tp]] : [elem.orig[tp], 0];
                    if (tp != 'opacity')
                        y[tp] = props[tp][0] + (tp != 'zIndex' && tp != 'fontWeight' ? 'px' : '');
                    else
                        jQuery.attr(y, "opacity", props[tp][0]);
                } else {
                    props[tp] = [parseFloat(jQuery.curCSS(elem, tp)), parseFloat(vp) || 0];
                }
            } else if (jQuery.fx.colorCssProps[tp])
                props[tp] = [jQuery.fx.parseColor(jQuery.curCSS(elem, tp)), jQuery.fx.parseColor(vp)];
            else if (/^margin$|padding$|border$|borderColor$|borderWidth$/i.test(tp)) {
                var m = vp.replace(/\s+/g, ' ').replace(/rgb\s*\(\s*/g, 'rgb(').replace(/\s*,\s*/g, ',').replace(/\s*\)/g, ')').match(/([^\s]+)/g);
                switch (tp) {
                case 'margin':
                case 'padding':
                case 'borderWidth':
                case 'borderColor':
                    m[3] = m[3] || m[1] || m[0];
                    m[2] = m[2] || m[0];
                    m[1] = m[1] || m[0];
                    for (var i = 0; i < jQuery.fx.cssSides.length; i++) {
                        var nmp = jQuery.fx.cssSidesEnd[tp][0] + jQuery.fx.cssSides[i] + jQuery.fx.cssSidesEnd[tp][1];
                        props[nmp] = tp == 'borderColor' ? [jQuery.fx.parseColor(jQuery.curCSS(elem, nmp)), jQuery.fx.parseColor(m[i])] : [parseFloat(jQuery.curCSS(elem, nmp)), parseFloat(m[i])];
                    }
                    break;
                case 'border':
                    for (var i = 0; i < m.length; i++) {
                        var floatVal = parseFloat(m[i]);
                        var sideEnd = !isNaN(floatVal) ? 'Width' : (!/transparent|none|hidden|dotted|dashed|solid|double|groove|ridge|inset|outset/i.test(m[i]) ? 'Color' : false);
                        if (sideEnd) {
                            for (var j = 0; j < jQuery.fx.cssSides.length; j++) {
                                nmp = 'border' + jQuery.fx.cssSides[j] + sideEnd;
                                props[nmp] = sideEnd == 'Color' ? [jQuery.fx.parseColor(jQuery.curCSS(elem, nmp)), jQuery.fx.parseColor(m[i])] : [parseFloat(jQuery.curCSS(elem, nmp)), floatVal];
                            }
                        } else {
                            y['borderStyle'] = m[i];
                        }
                    }
                    break;
                }
            } else {
                y[tp] = vp;
            }
            return false;
        };
        for (p in prop) {
            if (p == 'style') {
                var newStyles = jQuery.parseStyle(prop[p]);
                for (np in newStyles) {
                    this.getValues(np, newStyles[np]);
                }
            } else if (p == 'className') {
                if (document.styleSheets)
                    for (var i = 0; i < document.styleSheets.length; i++) {
                        var cssRules = document.styleSheets[i].cssRules || document.styleSheets[i].rules || null;
                        if (cssRules) {
                            for (var j = 0; j < cssRules.length; j++) {
                                if (cssRules[j].selectorText == '.' + prop[p]) {
                                    var rule = new RegExp('\.' + prop[p] + ' {');
                                    var styles = cssRules[j].style.cssText;
                                    var newStyles = jQuery.parseStyle(styles.replace(rule, '').replace(/}/g, ''));
                                    for (np in newStyles) {
                                        this.getValues(np, newStyles[np]);
                                    }
                                }
                            }
                        }
                    }
            } else {
                this.getValues(p, prop[p]);
            }
        }
        y.display = oldDisplay == 'none' ? 'block' : oldDisplay;
        y.overflow = 'hidden';
        z.step = function () {
            var t = (new Date()).getTime();
            if (t > options.duration + z.startTime) {
                clearInterval(z.timer);
                z.timer = null;
                for (p in props) {
                    if (p == "opacity")
                        jQuery.attr(y, "opacity", props[p][1]);
                    else if (typeof props[p][1] == 'object')
                        y[p] = 'rgb(' + props[p][1].r + ',' + props[p][1].g + ',' + props[p][1].b + ')';
                    else
                        y[p] = props[p][1] + (p != 'zIndex' && p != 'fontWeight' ? 'px' : '');
                }
                if (options.hide || options.show)
                    for (var p in elem.orig)
                        if (p == "opacity")
                            jQuery.attr(y, p, elem.orig[p]);
                        else
                            y[p] = "";
                y.display = options.hide ? 'none' : (oldDisplay != 'none' ? oldDisplay : 'block');
                y.overflow = oldOverflow;
                elem.animationHandler = null;
                if (jQuery.isFunction(options.complete))
                    options.complete.apply(elem);
            } else {
                var n = t - this.startTime;
                var pr = n / options.duration;
                for (p in props) {
                    if (typeof props[p][1] == 'object') {
                        y[p] = 'rgb(' + parseInt(jQuery.easing[options.easing](pr, n, props[p][0].r, (props[p][1].r - props[p][0].r), options.duration)) + ',' + parseInt(jQuery.easing[options.easing](pr, n, props[p][0].g, (props[p][1].g - props[p][0].g), options.duration)) + ',' + parseInt(jQuery.easing[options.easing](pr, n, props[p][0].b, (props[p][1].b - props[p][0].b), options.duration)) + ')';
                    } else {
                        var pValue = jQuery.easing[options.easing](pr, n, props[p][0], (props[p][1] - props[p][0]), options.duration);
                        if (p == "opacity")
                            jQuery.attr(y, "opacity", pValue);
                        else
                            y[p] = pValue + (p != 'zIndex' && p != 'fontWeight' ? 'px' : '');
                    }
                }
            }
        };
        z.timer = setInterval(function () {
            z.step();
        }, 13);
        elem.animationHandler = z;
    },
    stopAnim: function (elem, step) {
        if (step)
            elem.animationHandler.startTime -= 100000000;
        else {
            window.clearInterval(elem.animationHandler.timer);
            elem.animationHandler = null;
            jQuery.dequeue(elem, "fx");
        }
    }
});
jQuery.parseStyle = function (styles) {
    var newStyles = {};
    if (typeof styles == 'string') {
        styles = styles.toLowerCase().split(';');
        for (var i = 0; i < styles.length; i++) {
            rule = styles[i].split(':');
            if (rule.length == 2) {
                newStyles[jQuery.trim(rule[0].replace(/\-(\w)/g, function (m, c) {
                    return c.toUpperCase();
                }))] = jQuery.trim(rule[1]);
            }
        }
    }
    return newStyles;
};
jQuery.iSlider = {
    tabindex: 1,
    set: function (values) {
        var values = values;
        return this.each(function () {
            this.slideCfg.sliders.each(function (key) {
                jQuery.iSlider.dragmoveBy(this, values[key]);
            });
        });
    },
    get: function () {
        var values = [];
        this.each(function (slider) {
            if (this.isSlider) {
                values[slider] = [];
                var elm = this;
                var sizes = jQuery.iUtil.getSize(this);
                this.slideCfg.sliders.each(function (key) {
                    var x = this.offsetLeft;
                    var y = this.offsetTop;
                    xproc = parseInt(x * 100 / (sizes.w - this.offsetWidth));
                    yproc = parseInt(y * 100 / (sizes.h - this.offsetHeight));
                    values[slider][key] = [xproc || 0, yproc || 0, x || 0, y || 0];
                });
            }
        });
        return values;
    },
    modifyContainer: function (elm) {
        elm.dragCfg.containerMaxx = elm.dragCfg.cont.w - elm.dragCfg.oC.wb;
        elm.dragCfg.containerMaxy = elm.dragCfg.cont.h - elm.dragCfg.oC.hb;
        if (elm.SliderContainer.slideCfg.restricted) {
            next = elm.SliderContainer.slideCfg.sliders.get(elm.SliderIteration + 1);
            if (next) {
                elm.dragCfg.cont.w = (parseInt(jQuery(next).css('left')) || 0) + elm.dragCfg.oC.wb;
                elm.dragCfg.cont.h = (parseInt(jQuery(next).css('top')) || 0) + elm.dragCfg.oC.hb;
            }
            prev = elm.SliderContainer.slideCfg.sliders.get(elm.SliderIteration - 1);
            if (prev) {
                var prevLeft = parseInt(jQuery(prev).css('left')) || 0;
                var prevTop = parseInt(jQuery(prev).css('left')) || 0;
                elm.dragCfg.cont.x += prevLeft;
                elm.dragCfg.cont.y += prevTop;
                elm.dragCfg.cont.w -= prevLeft;
                elm.dragCfg.cont.h -= prevTop;
            }
        }
        elm.dragCfg.maxx = elm.dragCfg.cont.w - elm.dragCfg.oC.wb;
        elm.dragCfg.maxy = elm.dragCfg.cont.h - elm.dragCfg.oC.hb;
        if (elm.dragCfg.fractions) {
            elm.dragCfg.gx = ((elm.dragCfg.cont.w - elm.dragCfg.oC.wb) / elm.dragCfg.fractions) || 1;
            elm.dragCfg.gy = ((elm.dragCfg.cont.h - elm.dragCfg.oC.hb) / elm.dragCfg.fractions) || 1;
            elm.dragCfg.fracW = elm.dragCfg.maxx / elm.dragCfg.fractions;
            elm.dragCfg.fracH = elm.dragCfg.maxy / elm.dragCfg.fractions;
        }
        elm.dragCfg.cont.dx = elm.dragCfg.cont.x - elm.dragCfg.oR.x;
        elm.dragCfg.cont.dy = elm.dragCfg.cont.y - elm.dragCfg.oR.y;
        jQuery.iDrag.helper.css('cursor', 'default');
    },
    onSlide: function (elm, x, y) {
        if (elm.dragCfg.fractions) {
            xfrac = parseInt(x / elm.dragCfg.fracW);
            xproc = xfrac * 100 / elm.dragCfg.fractions;
            yfrac = parseInt(y / elm.dragCfg.fracH);
            yproc = yfrac * 100 / elm.dragCfg.fractions;
        } else {
            xproc = parseInt(x * 100 / elm.dragCfg.containerMaxx);
            yproc = parseInt(y * 100 / elm.dragCfg.containerMaxy);
        }
        elm.dragCfg.lastSi = [xproc || 0, yproc || 0, x || 0, y || 0];
        if (elm.dragCfg.onSlide)
            elm.dragCfg.onSlide.apply(elm, elm.dragCfg.lastSi);
    },
    dragmoveByKey: function (event) {
        pressedKey = event.charCode || event.keyCode || -1;
        switch (pressedKey) {
        case 35:
            jQuery.iSlider.dragmoveBy(this.dragElem, [2000, 2000]);
            break;
        case 36:
            jQuery.iSlider.dragmoveBy(this.dragElem, [-2000, -2000]);
            break;
        case 37:
            jQuery.iSlider.dragmoveBy(this.dragElem, [-this.dragElem.dragCfg.gx || -1, 0]);
            break;
        case 38:
            jQuery.iSlider.dragmoveBy(this.dragElem, [0, -this.dragElem.dragCfg.gy || -1]);
            break;
        case 39:
            jQuery.iSlider.dragmoveBy(this.dragElem, [this.dragElem.dragCfg.gx || 1, 0]);
            break;
        case 40:
            jQuery.iDrag.dragmoveBy(this.dragElem, [0, this.dragElem.dragCfg.gy || 1]);
            break;
        }
    },
    dragmoveBy: function (elm, position) {
        if (!elm.dragCfg) {
            return;
        }
        elm.dragCfg.oC = jQuery.extend(jQuery.iUtil.getPosition(elm), jQuery.iUtil.getSize(elm));
        elm.dragCfg.oR = {
            x: parseInt(jQuery.css(elm, 'left')) || 0,
            y: parseInt(jQuery.css(elm, 'top')) || 0
        };
        elm.dragCfg.oP = jQuery.css(elm, 'position');
        if (elm.dragCfg.oP != 'relative' && elm.dragCfg.oP != 'absolute') {
            elm.style.position = 'relative';
        }
        jQuery.iDrag.getContainment(elm);
        jQuery.iSlider.modifyContainer(elm);
        dx = parseInt(position[0]) || 0;
        dy = parseInt(position[1]) || 0;
        nx = elm.dragCfg.oR.x + dx;
        ny = elm.dragCfg.oR.y + dy;
        if (elm.dragCfg.fractions) {
            newCoords = jQuery.iDrag.snapToGrid.apply(elm, [nx, ny, dx, dy]);
            if (newCoords.constructor == Object) {
                dx = newCoords.dx;
                dy = newCoords.dy;
            }
            nx = elm.dragCfg.oR.x + dx;
            ny = elm.dragCfg.oR.y + dy;
        }
        newCoords = jQuery.iDrag.fitToContainer.apply(elm, [nx, ny, dx, dy]);
        if (newCoords && newCoords.constructor == Object) {
            dx = newCoords.dx;
            dy = newCoords.dy;
        }
        nx = elm.dragCfg.oR.x + dx;
        ny = elm.dragCfg.oR.y + dy;
        if (elm.dragCfg.si && (elm.dragCfg.onSlide || elm.dragCfg.onChange)) {
            jQuery.iSlider.onSlide(elm, nx, ny);
        }
        nx = !elm.dragCfg.axis || elm.dragCfg.axis == 'horizontally' ? nx : elm.dragCfg.oR.x || 0;
        ny = !elm.dragCfg.axis || elm.dragCfg.axis == 'vertically' ? ny : elm.dragCfg.oR.y || 0;
        elm.style.left = nx + 'px';
        elm.style.top = ny + 'px';
    },
    build: function (o) {
        return this.each(function () {
            if (this.isSlider == true || !o.accept || !jQuery.iUtil || !jQuery.iDrag || !jQuery.iDrop) {
                return;
            }
            toDrag = jQuery(o.accept, this);
            if (toDrag.size() == 0) {
                return;
            }
            var params = {
                containment: 'parent',
                si: true,
                onSlide: o.onSlide && o.onSlide.constructor == Function ? o.onSlide : null,
                onChange: o.onChange && o.onChange.constructor == Function ? o.onChange : null,
                handle: this,
                opacity: o.opacity || false
            };
            if (o.fractions && parseInt(o.fractions)) {
                params.fractions = parseInt(o.fractions) || 1;
                params.fractions = params.fractions > 0 ? params.fractions : 1;
            }
            if (toDrag.size() == 1)
                toDrag.Draggable(params);
            else {
                jQuery(toDrag.get(0)).Draggable(params);
                params.handle = null;
                toDrag.Draggable(params);
            }
            toDrag.keydown(jQuery.iSlider.dragmoveByKey);
            toDrag.attr('tabindex', jQuery.iSlider.tabindex++);
            this.isSlider = true;
            this.slideCfg = {};
            this.slideCfg.onslide = params.onslide;
            this.slideCfg.fractions = params.fractions;
            this.slideCfg.sliders = toDrag;
            this.slideCfg.restricted = o.restricted ? true : false;
            sliderEl = this;
            sliderEl.slideCfg.sliders.each(function (nr) {
                this.SliderIteration = nr;
                this.SliderContainer = sliderEl;
            });
            if (o.values && o.values.constructor == Array) {
                for (i = o.values.length - 1; i >= 0; i--) {
                    if (o.values[i].constructor == Array && o.values[i].length == 2) {
                        el = this.slideCfg.sliders.get(i);
                        if (el.tagName) {
                            jQuery.iSlider.dragmoveBy(el, o.values[i]);
                        }
                    }
                }
            }
        });
    }
};
jQuery.fn.extend({
    Slider: jQuery.iSlider.build,
    SliderSetValues: jQuery.iSlider.set,
    SliderGetValues: jQuery.iSlider.get
});
jQuery.fn.extend({
    SlideInUp: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.slide(this, speed, callback, 'up', 'in', easing);
        });
    },
    SlideOutUp: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.slide(this, speed, callback, 'up', 'out', easing);
        });
    },
    SlideToggleUp: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.slide(this, speed, callback, 'up', 'toggle', easing);
        });
    },
    SlideInDown: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.slide(this, speed, callback, 'down', 'in', easing);
        });
    },
    SlideOutDown: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.slide(this, speed, callback, 'down', 'out', easing);
        });
    },
    SlideToggleDown: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.slide(this, speed, callback, 'down', 'toggle', easing);
        });
    },
    SlideInLeft: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.slide(this, speed, callback, 'left', 'in', easing);
        });
    },
    SlideOutLeft: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.slide(this, speed, callback, 'left', 'out', easing);
        });
    },
    SlideToggleLeft: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.slide(this, speed, callback, 'left', 'toggle', easing);
        });
    },
    SlideInRight: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.slide(this, speed, callback, 'right', 'in', easing);
        });
    },
    SlideOutRight: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.slide(this, speed, callback, 'right', 'out', easing);
        });
    },
    SlideToggleRight: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.slide(this, speed, callback, 'right', 'toggle', easing);
        });
    }
});
jQuery.fx.slide = function (e, speed, callback, direction, type, easing) {
    if (!jQuery.fxCheckTag(e)) {
        jQuery.dequeue(e, 'interfaceFX');
        return false;
    }
    var z = this;
    z.el = jQuery(e);
    z.easing = typeof callback == 'string' ? callback : easing || null;
    z.callback = typeof callback == 'function' ? callback : null;
    if (type == 'toggle') {
        type = z.el.css('display') == 'none' ? 'in' : 'out';
    }
    if (!e.ifxFirstDisplay)
        e.ifxFirstDisplay = z.el.css('display');
    z.el.show();
    z.speed = speed;
    z.fx = jQuery.fx.buildWrapper(e);
    z.type = type;
    z.direction = direction;
    z.complete = function () {
        if (z.type == 'out')
            z.el.css('visibility', 'hidden');
        jQuery.fx.destroyWrapper(z.fx.wrapper.get(0), z.fx.oldStyle);
        if (z.type == 'in') {
            z.el.css('display', z.el.get(0).ifxFirstDisplay == 'none' ? 'block' : z.el.get(0).ifxFirstDisplay);
        } else {
            z.el.css('display', 'none');
            z.el.css('visibility', 'visible');
        }
        if (z.callback && z.callback.constructor == Function) {
            z.callback.apply(z.el.get(0));
        }
        jQuery.dequeue(z.el.get(0), 'interfaceFX');
    };
    switch (z.direction) {
    case 'up':
        z.ef = new jQuery.fx(z.el.get(0), jQuery.speed(z.speed, z.easing, z.complete), 'top');
        z.efx = new jQuery.fx(z.fx.wrapper.get(0), jQuery.speed(z.speed, z.easing), 'height');
        if (z.type == 'in') {
            z.ef.custom(-z.fx.oldStyle.sizes.hb, 0);
            z.efx.custom(0, z.fx.oldStyle.sizes.hb);
        } else {
            z.ef.custom(0, -z.fx.oldStyle.sizes.hb);
            z.efx.custom(z.fx.oldStyle.sizes.hb, 0);
        }
        break;
    case 'down':
        z.ef = new jQuery.fx(z.el.get(0), jQuery.speed(z.speed, z.easing, z.complete), 'top');
        if (z.type == 'in') {
            z.ef.custom(z.fx.oldStyle.sizes.hb, 0);
        } else {
            z.ef.custom(0, z.fx.oldStyle.sizes.hb);
        }
        break;
    case 'left':
        z.ef = new jQuery.fx(z.el.get(0), jQuery.speed(z.speed, z.easing, z.complete), 'left');
        z.efx = new jQuery.fx(z.fx.wrapper.get(0), jQuery.speed(z.speed, z.easing), 'width');
        if (z.type == 'in') {
            z.ef.custom(-z.fx.oldStyle.sizes.wb, 0);
            z.efx.custom(0, z.fx.oldStyle.sizes.wb);
        } else {
            z.ef.custom(0, -z.fx.oldStyle.sizes.wb);
            z.efx.custom(z.fx.oldStyle.sizes.wb, 0);
        }
        break;
    case 'right':
        z.ef = new jQuery.fx(z.el.get(0), jQuery.speed(z.speed, z.easing, z.complete), 'left');
        if (z.type == 'in') {
            z.ef.custom(z.fx.oldStyle.sizes.wb, 0);
        } else {
            z.ef.custom(0, z.fx.oldStyle.sizes.wb);
        }
        break;
    }
};
jQuery.iDrag = {
    helper: null,
    dragged: null,
    destroy: function () {
        return this.each(function () {
            if (this.isDraggable) {
                this.dragCfg.dhe.unbind('mousedown', jQuery.iDrag.draginit);
                this.dragCfg = null;
                this.isDraggable = false;
                if (jQuery.browser.msie) {
                    this.unselectable = "off";
                } else {
                    this.style.MozUserSelect = '';
                    this.style.KhtmlUserSelect = '';
                    this.style.userSelect = '';
                }
            }
        });
    },
    draginit: function (e) {
        if (jQuery.iDrag.dragged != null) {
            jQuery.iDrag.dragstop(e);
            return false;
        }
        var elm = this.dragElem;
        jQuery(document).bind('mousemove', jQuery.iDrag.dragmove).bind('mouseup', jQuery.iDrag.dragstop);
        elm.dragCfg.pointer = jQuery.iUtil.getPointer(e);
        elm.dragCfg.currentPointer = elm.dragCfg.pointer;
        elm.dragCfg.init = false;
        elm.dragCfg.fromHandler = this != this.dragElem;
        jQuery.iDrag.dragged = elm;
        if (elm.dragCfg.si && this != this.dragElem) {
            parentPos = jQuery.iUtil.getPosition(elm.parentNode);
            sliderSize = jQuery.iUtil.getSize(elm);
            sliderPos = {
                x: parseInt(jQuery.css(elm, 'left')) || 0,
                y: parseInt(jQuery.css(elm, 'top')) || 0
            };
            dx = elm.dragCfg.currentPointer.x - parentPos.x - sliderSize.wb / 2 - sliderPos.x;
            dy = elm.dragCfg.currentPointer.y - parentPos.y - sliderSize.hb / 2 - sliderPos.y;
            jQuery.iSlider.dragmoveBy(elm, [dx, dy]);
        }
        return jQuery.selectKeyHelper || false;
    },
    dragstart: function (e) {
        var elm = jQuery.iDrag.dragged;
        elm.dragCfg.init = true;
        var dEs = elm.style;
        elm.dragCfg.oD = jQuery.css(elm, 'display');
        elm.dragCfg.oP = jQuery.css(elm, 'position');
        if (!elm.dragCfg.initialPosition)
            elm.dragCfg.initialPosition = elm.dragCfg.oP;
        elm.dragCfg.oR = {
            x: parseInt(jQuery.css(elm, 'left')) || 0,
            y: parseInt(jQuery.css(elm, 'top')) || 0
        };
        elm.dragCfg.diffX = 0;
        elm.dragCfg.diffY = 0;
        if (jQuery.browser.msie) {
            var oldBorder = jQuery.iUtil.getBorder(elm, true);
            elm.dragCfg.diffX = oldBorder.l || 0;
            elm.dragCfg.diffY = oldBorder.t || 0;
        }
        elm.dragCfg.oC = jQuery.extend(jQuery.iUtil.getPosition(elm), jQuery.iUtil.getSize(elm));
        if (elm.dragCfg.oP != 'relative' && elm.dragCfg.oP != 'absolute') {
            dEs.position = 'relative';
        }
        jQuery.iDrag.helper.empty();
        var clonedEl = elm.cloneNode(true);
        jQuery(clonedEl).css({
            display: 'block',
            left: '0px',
            top: '0px'
        });
        clonedEl.style.marginTop = '0';
        clonedEl.style.marginRight = '0';
        clonedEl.style.marginBottom = '0';
        clonedEl.style.marginLeft = '0';
        jQuery.iDrag.helper.append(clonedEl);
        var dhs = jQuery.iDrag.helper.get(0).style;
        if (elm.dragCfg.autoSize) {
            dhs.width = 'auto';
            dhs.height = 'auto';
        } else {
            dhs.height = elm.dragCfg.oC.hb + 'px';
            dhs.width = elm.dragCfg.oC.wb + 'px';
        }
        dhs.display = 'block';
        dhs.marginTop = '0px';
        dhs.marginRight = '0px';
        dhs.marginBottom = '0px';
        dhs.marginLeft = '0px';
        jQuery.extend(elm.dragCfg.oC, jQuery.iUtil.getSize(clonedEl));
        if (elm.dragCfg.cursorAt) {
            if (elm.dragCfg.cursorAt.left) {
                elm.dragCfg.oR.x += elm.dragCfg.pointer.x - elm.dragCfg.oC.x - elm.dragCfg.cursorAt.left;
                elm.dragCfg.oC.x = elm.dragCfg.pointer.x - elm.dragCfg.cursorAt.left;
            }
            if (elm.dragCfg.cursorAt.top) {
                elm.dragCfg.oR.y += elm.dragCfg.pointer.y - elm.dragCfg.oC.y - elm.dragCfg.cursorAt.top;
                elm.dragCfg.oC.y = elm.dragCfg.pointer.y - elm.dragCfg.cursorAt.top;
            }
            if (elm.dragCfg.cursorAt.right) {
                elm.dragCfg.oR.x += elm.dragCfg.pointer.x - elm.dragCfg.oC.x - elm.dragCfg.oC.hb + elm.dragCfg.cursorAt.right;
                elm.dragCfg.oC.x = elm.dragCfg.pointer.x - elm.dragCfg.oC.wb + elm.dragCfg.cursorAt.right;
            }
            if (elm.dragCfg.cursorAt.bottom) {
                elm.dragCfg.oR.y += elm.dragCfg.pointer.y - elm.dragCfg.oC.y - elm.dragCfg.oC.hb + elm.dragCfg.cursorAt.bottom;
                elm.dragCfg.oC.y = elm.dragCfg.pointer.y - elm.dragCfg.oC.hb + elm.dragCfg.cursorAt.bottom;
            }
        }
        elm.dragCfg.nx = elm.dragCfg.oR.x;
        elm.dragCfg.ny = elm.dragCfg.oR.y;
        if (elm.dragCfg.insideParent || elm.dragCfg.containment == 'parent') {
            parentBorders = jQuery.iUtil.getBorder(elm.parentNode, true);
            elm.dragCfg.oC.x = elm.offsetLeft + (jQuery.browser.msie ? 0 : jQuery.browser.opera ? -parentBorders.l : parentBorders.l);
            elm.dragCfg.oC.y = elm.offsetTop + (jQuery.browser.msie ? 0 : jQuery.browser.opera ? -parentBorders.t : parentBorders.t);
            jQuery(elm.parentNode).append(jQuery.iDrag.helper.get(0));
        }
        if (elm.dragCfg.containment) {
            jQuery.iDrag.getContainment(elm);
            elm.dragCfg.onDragModifier.containment = jQuery.iDrag.fitToContainer;
        }
        if (elm.dragCfg.si) {
            jQuery.iSlider.modifyContainer(elm);
        }
        dhs.left = elm.dragCfg.oC.x - elm.dragCfg.diffX + 'px';
        dhs.top = elm.dragCfg.oC.y - elm.dragCfg.diffY + 'px';
        dhs.width = elm.dragCfg.oC.wb + 'px';
        dhs.height = elm.dragCfg.oC.hb + 'px';
        elm.dragCfg.prot = false;
        if (elm.dragCfg.gx) {
            elm.dragCfg.onDragModifier.grid = jQuery.iDrag.snapToGrid;
        }
        if (elm.dragCfg.zIndex != false) {
            jQuery.iDrag.helper.css('zIndex', elm.dragCfg.zIndex);
        }
        if (elm.dragCfg.opacity) {
            jQuery.iDrag.helper.css('opacity', elm.dragCfg.opacity);
            if (window.ActiveXObject) {
                jQuery.iDrag.helper.css('filter', 'alpha(opacity=' + elm.dragCfg.opacity * 100 + ')');
            }
        }
        if (elm.dragCfg.frameClass) {
            jQuery.iDrag.helper.addClass(elm.dragCfg.frameClass);
            jQuery.iDrag.helper.get(0).firstChild.style.display = 'none';
        }
        if (elm.dragCfg.onStart)
            elm.dragCfg.onStart.apply(elm, [clonedEl, elm.dragCfg.oR.x, elm.dragCfg.oR.y]);
        if (jQuery.iDrop && jQuery.iDrop.count > 0) {
            jQuery.iDrop.highlight(elm);
        }
        if (elm.dragCfg.ghosting == false) {
            dEs.display = 'none';
        }
        return false;
    },
    getContainment: function (elm) {
        if (elm.dragCfg.containment.constructor == String) {
            if (elm.dragCfg.containment == 'parent') {
                elm.dragCfg.cont = jQuery.extend({
                    x: 0,
                    y: 0
                }, jQuery.iUtil.getSize(elm.parentNode));
                var contBorders = jQuery.iUtil.getBorder(elm.parentNode, true);
                elm.dragCfg.cont.w = elm.dragCfg.cont.wb - contBorders.l - contBorders.r;
                elm.dragCfg.cont.h = elm.dragCfg.cont.hb - contBorders.t - contBorders.b;
            } else if (elm.dragCfg.containment == 'document') {
                var clnt = jQuery.iUtil.getClient();
                elm.dragCfg.cont = {
                    x: 0,
                    y: 0,
                    w: clnt.w,
                    h: clnt.h
                };
            }
        } else if (elm.dragCfg.containment.constructor == Array) {
            elm.dragCfg.cont = {
                x: parseInt(elm.dragCfg.containment[0]) || 0,
                y: parseInt(elm.dragCfg.containment[1]) || 0,
                w: parseInt(elm.dragCfg.containment[2]) || 0,
                h: parseInt(elm.dragCfg.containment[3]) || 0
            };
        }
        elm.dragCfg.cont.dx = elm.dragCfg.cont.x - elm.dragCfg.oC.x;
        elm.dragCfg.cont.dy = elm.dragCfg.cont.y - elm.dragCfg.oC.y;
    },
    hidehelper: function (dragged) {
        if (dragged.dragCfg.insideParent || dragged.dragCfg.containment == 'parent') {
            jQuery('body', document).append(jQuery.iDrag.helper.get(0));
        }
        jQuery.iDrag.helper.empty().hide();
        if (dragged.dragCfg.opacity) {
            jQuery.iDrag.helper.css('opacity', 1);
            if (window.ActiveXObject) {
                jQuery.iDrag.helper.css('filter', 'alpha(opacity=100)');
            }
        }
    },
    dragstop: function (e) {
        jQuery(document).unbind('mousemove', jQuery.iDrag.dragmove).unbind('mouseup', jQuery.iDrag.dragstop);
        if (jQuery.iDrag.dragged == null) {
            return;
        }
        var dragged = jQuery.iDrag.dragged;
        jQuery.iDrag.dragged = null;
        if (dragged.dragCfg.init == false) {
            return false;
        }
        if (dragged.dragCfg.so == true) {
            jQuery(dragged).css('position', dragged.dragCfg.oP);
        }
        var dEs = dragged.style;
        if (dragged.si) {
            jQuery.iDrag.helper.css('cursor', 'move');
        }
        if (dragged.dragCfg.frameClass) {
            jQuery.iDrag.helper.removeClass(dragged.dragCfg.frameClass);
        }
        if (dragged.dragCfg.revert == false) {
            if (dragged.dragCfg.fx > 0) {
                if (!dragged.dragCfg.axis || dragged.dragCfg.axis == 'horizontally') {
                    var x = new jQuery.fx(dragged, {
                        duration: dragged.dragCfg.fx
                    }, 'left');
                    x.custom(dragged.dragCfg.oR.x, dragged.dragCfg.nRx);
                }
                if (!dragged.dragCfg.axis || dragged.dragCfg.axis == 'vertically') {
                    var y = new jQuery.fx(dragged, {
                        duration: dragged.dragCfg.fx
                    }, 'top');
                    y.custom(dragged.dragCfg.oR.y, dragged.dragCfg.nRy);
                }
            } else {
                if (!dragged.dragCfg.axis || dragged.dragCfg.axis == 'horizontally')
                    dragged.style.left = dragged.dragCfg.nRx + 'px';
                if (!dragged.dragCfg.axis || dragged.dragCfg.axis == 'vertically')
                    dragged.style.top = dragged.dragCfg.nRy + 'px';
            }
            jQuery.iDrag.hidehelper(dragged);
            if (dragged.dragCfg.ghosting == false) {
                jQuery(dragged).css('display', dragged.dragCfg.oD);
            }
        } else if (dragged.dragCfg.fx > 0) {
            dragged.dragCfg.prot = true;
            var dh = false;
            if (jQuery.iDrop && jQuery.iSort && dragged.dragCfg.so) {
                dh = jQuery.iUtil.getPosition(jQuery.iSort.helper.get(0));
            }
            jQuery.iDrag.helper.animate({
                left: dh ? dh.x : dragged.dragCfg.oC.x,
                top: dh ? dh.y : dragged.dragCfg.oC.y
            }, dragged.dragCfg.fx, function () {
                dragged.dragCfg.prot = false;
                if (dragged.dragCfg.ghosting == false) {
                    dragged.style.display = dragged.dragCfg.oD;
                }
                jQuery.iDrag.hidehelper(dragged);
            });
        } else {
            jQuery.iDrag.hidehelper(dragged);
            if (dragged.dragCfg.ghosting == false) {
                jQuery(dragged).css('display', dragged.dragCfg.oD);
            }
        }
        if (jQuery.iDrop && jQuery.iDrop.count > 0) {
            jQuery.iDrop.checkdrop(dragged);
        }
        if (jQuery.iSort && dragged.dragCfg.so) {
            jQuery.iSort.check(dragged);
        }
        if (dragged.dragCfg.onChange && (dragged.dragCfg.nRx != dragged.dragCfg.oR.x || dragged.dragCfg.nRy != dragged.dragCfg.oR.y)) {
            dragged.dragCfg.onChange.apply(dragged, dragged.dragCfg.lastSi || [0, 0, dragged.dragCfg.nRx, dragged.dragCfg.nRy]);
        }
        if (dragged.dragCfg.onStop)
            dragged.dragCfg.onStop.apply(dragged);
        return false;
    },
    snapToGrid: function (x, y, dx, dy) {
        if (dx != 0)
            dx = parseInt((dx + (this.dragCfg.gx * dx / Math.abs(dx)) / 2) / this.dragCfg.gx) * this.dragCfg.gx;
        if (dy != 0)
            dy = parseInt((dy + (this.dragCfg.gy * dy / Math.abs(dy)) / 2) / this.dragCfg.gy) * this.dragCfg.gy;
        return {
            dx: dx,
            dy: dy,
            x: 0,
            y: 0
        };
    },
    fitToContainer: function (x, y, dx, dy) {
        dx = Math.min(Math.max(dx, this.dragCfg.cont.dx), this.dragCfg.cont.w + this.dragCfg.cont.dx - this.dragCfg.oC.wb);
        dy = Math.min(Math.max(dy, this.dragCfg.cont.dy), this.dragCfg.cont.h + this.dragCfg.cont.dy - this.dragCfg.oC.hb);
        return {
            dx: dx,
            dy: dy,
            x: 0,
            y: 0
        }
    },
    dragmove: function (e) {
        if (jQuery.iDrag.dragged == null || jQuery.iDrag.dragged.dragCfg.prot == true) {
            return;
        }
        var dragged = jQuery.iDrag.dragged;
        dragged.dragCfg.currentPointer = jQuery.iUtil.getPointer(e);
        if (dragged.dragCfg.init == false) {
            distance = Math.sqrt(Math.pow(dragged.dragCfg.pointer.x - dragged.dragCfg.currentPointer.x, 2) + Math.pow(dragged.dragCfg.pointer.y - dragged.dragCfg.currentPointer.y, 2));
            if (distance < dragged.dragCfg.snapDistance) {
                return;
            } else {
                jQuery.iDrag.dragstart(e);
            }
        }
        var dx = dragged.dragCfg.currentPointer.x - dragged.dragCfg.pointer.x;
        var dy = dragged.dragCfg.currentPointer.y - dragged.dragCfg.pointer.y;
        for (var i in dragged.dragCfg.onDragModifier) {
            var newCoords = dragged.dragCfg.onDragModifier[i].apply(dragged, [dragged.dragCfg.oR.x + dx, dragged.dragCfg.oR.y + dy, dx, dy]);
            if (newCoords && newCoords.constructor == Object) {
                dx = i != 'user' ? newCoords.dx : (newCoords.x - dragged.dragCfg.oR.x);
                dy = i != 'user' ? newCoords.dy : (newCoords.y - dragged.dragCfg.oR.y);
            }
        }
        dragged.dragCfg.nx = dragged.dragCfg.oC.x + dx - dragged.dragCfg.diffX;
        dragged.dragCfg.ny = dragged.dragCfg.oC.y + dy - dragged.dragCfg.diffY;
        if (dragged.dragCfg.si && (dragged.dragCfg.onSlide || dragged.dragCfg.onChange)) {
            jQuery.iSlider.onSlide(dragged, dragged.dragCfg.nx, dragged.dragCfg.ny);
        }
        if (dragged.dragCfg.onDrag)
            dragged.dragCfg.onDrag.apply(dragged, [dragged.dragCfg.oR.x + dx, dragged.dragCfg.oR.y + dy]);
        if (!dragged.dragCfg.axis || dragged.dragCfg.axis == 'horizontally') {
            dragged.dragCfg.nRx = dragged.dragCfg.oR.x + dx;
            jQuery.iDrag.helper.get(0).style.left = dragged.dragCfg.nx + 'px';
        }
        if (!dragged.dragCfg.axis || dragged.dragCfg.axis == 'vertically') {
            dragged.dragCfg.nRy = dragged.dragCfg.oR.y + dy;
            jQuery.iDrag.helper.get(0).style.top = dragged.dragCfg.ny + 'px';
        }
        if (jQuery.iDrop && jQuery.iDrop.count > 0) {
            jQuery.iDrop.checkhover(dragged);
        }
        return false;
    },
    build: function (o) {
        if (!jQuery.iDrag.helper) {
            jQuery('body', document).append('<div id="dragHelper"></div>');
            jQuery.iDrag.helper = jQuery('#dragHelper');
            var el = jQuery.iDrag.helper.get(0);
            var els = el.style;
            els.position = 'absolute';
            els.display = 'none';
            els.cursor = 'move';
            els.listStyle = 'none';
            els.overflow = 'hidden';
            if (window.ActiveXObject) {
                el.unselectable = "on";
            } else {
                els.mozUserSelect = 'none';
                els.userSelect = 'none';
                els.KhtmlUserSelect = 'none';
            }
        }
        if (!o) {
            o = {};
        }
        return this.each(function () {
            if (this.isDraggable || !jQuery.iUtil)
                return;
            if (window.ActiveXObject) {
                this.onselectstart = function () {
                    return false;
                };
                this.ondragstart = function () {
                    return false;
                };
            }
            var el = this;
            var dhe = o.handle ? jQuery(this).find(o.handle) : jQuery(this);
            if (jQuery.browser.msie) {
                dhe.each(function () {
                    this.unselectable = "on";
                });
            } else {
                dhe.css('-moz-user-select', 'none');
                dhe.css('user-select', 'none');
                dhe.css('-khtml-user-select', 'none');
            }
            this.dragCfg = {
                dhe: dhe,
                revert: o.revert ? true : false,
                ghosting: o.ghosting ? true : false,
                so: o.so ? o.so : false,
                si: o.si ? o.si : false,
                insideParent: o.insideParent ? o.insideParent : false,
                zIndex: o.zIndex ? parseInt(o.zIndex) || 0 : false,
                opacity: o.opacity ? parseFloat(o.opacity) : false,
                fx: parseInt(o.fx) || null,
                hpc: o.hpc ? o.hpc : false,
                onDragModifier: {},
                pointer: {},
                onStart: o.onStart && o.onStart.constructor == Function ? o.onStart : false,
                onStop: o.onStop && o.onStop.constructor == Function ? o.onStop : false,
                onChange: o.onChange && o.onChange.constructor == Function ? o.onChange : false,
                axis: /vertically|horizontally/.test(o.axis) ? o.axis : false,
                snapDistance: o.snapDistance ? parseInt(o.snapDistance) || 0 : 0,
                cursorAt: o.cursorAt ? o.cursorAt : false,
                autoSize: o.autoSize ? true : false,
                frameClass: o.frameClass || false
            };
            if (o.onDragModifier && o.onDragModifier.constructor == Function)
                this.dragCfg.onDragModifier.user = o.onDragModifier;
            if (o.onDrag && o.onDrag.constructor == Function)
                this.dragCfg.onDrag = o.onDrag;
            if (o.containment && ((o.containment.constructor == String && (o.containment == 'parent' || o.containment == 'document')) || (o.containment.constructor == Array && o.containment.length == 4))) {
                this.dragCfg.containment = o.containment;
            }
            if (o.fractions) {
                this.dragCfg.fractions = o.fractions;
            }
            if (o.grid) {
                if (typeof o.grid == 'number') {
                    this.dragCfg.gx = parseInt(o.grid) || 1;
                    this.dragCfg.gy = parseInt(o.grid) || 1;
                } else if (o.grid.length == 2) {
                    this.dragCfg.gx = parseInt(o.grid[0]) || 1;
                    this.dragCfg.gy = parseInt(o.grid[1]) || 1;
                }
            }
            if (o.onSlide && o.onSlide.constructor == Function) {
                this.dragCfg.onSlide = o.onSlide;
            }
            this.isDraggable = true;
            dhe.each(function () {
                this.dragElem = el;
            });
            dhe.bind('mousedown', jQuery.iDrag.draginit);
        })
    }
};
jQuery.fn.extend({
    DraggableDestroy: jQuery.iDrag.destroy,
    Draggable: jQuery.iDrag.build
});
jQuery.iAutoscroller = {
    timer: null,
    elToScroll: null,
    elsToScroll: null,
    step: 10,
    start: function (el, els, step, interval) {
        jQuery.iAutoscroller.elToScroll = el;
        jQuery.iAutoscroller.elsToScroll = els;
        jQuery.iAutoscroller.step = parseInt(step) || 10;
        jQuery.iAutoscroller.timer = window.setInterval(jQuery.iAutoscroller.doScroll, parseInt(interval) || 40);
    },
    doScroll: function () {
        for (i = 0; i < jQuery.iAutoscroller.elsToScroll.length; i++) {
            if (!jQuery.iAutoscroller.elsToScroll[i].parentData) {
                jQuery.iAutoscroller.elsToScroll[i].parentData = jQuery.extend(jQuery.iUtil.getPositionLite(jQuery.iAutoscroller.elsToScroll[i]), jQuery.iUtil.getSizeLite(jQuery.iAutoscroller.elsToScroll[i]), jQuery.iUtil.getScroll(jQuery.iAutoscroller.elsToScroll[i]));
            } else {
                jQuery.iAutoscroller.elsToScroll[i].parentData.t = jQuery.iAutoscroller.elsToScroll[i].scrollTop;
                jQuery.iAutoscroller.elsToScroll[i].parentData.l = jQuery.iAutoscroller.elsToScroll[i].scrollLeft;
            }
            if (jQuery.iAutoscroller.elToScroll.dragCfg && jQuery.iAutoscroller.elToScroll.dragCfg.init == true) {
                elementData = {
                    x: jQuery.iAutoscroller.elToScroll.dragCfg.nx,
                    y: jQuery.iAutoscroller.elToScroll.dragCfg.ny,
                    wb: jQuery.iAutoscroller.elToScroll.dragCfg.oC.wb,
                    hb: jQuery.iAutoscroller.elToScroll.dragCfg.oC.hb
                };
            } else {
                elementData = jQuery.extend(jQuery.iUtil.getPositionLite(jQuery.iAutoscroller.elToScroll), jQuery.iUtil.getSizeLite(jQuery.iAutoscroller.elToScroll));
            }
            if (jQuery.iAutoscroller.elsToScroll[i].parentData.t > 0 && jQuery.iAutoscroller.elsToScroll[i].parentData.y + jQuery.iAutoscroller.elsToScroll[i].parentData.t > elementData.y) {
                jQuery.iAutoscroller.elsToScroll[i].scrollTop -= jQuery.iAutoscroller.step;
            } else if (jQuery.iAutoscroller.elsToScroll[i].parentData.t <= jQuery.iAutoscroller.elsToScroll[i].parentData.h && jQuery.iAutoscroller.elsToScroll[i].parentData.t + jQuery.iAutoscroller.elsToScroll[i].parentData.hb < elementData.y + elementData.hb) {
                jQuery.iAutoscroller.elsToScroll[i].scrollTop += jQuery.iAutoscroller.step;
            }
            if (jQuery.iAutoscroller.elsToScroll[i].parentData.l > 0 && jQuery.iAutoscroller.elsToScroll[i].parentData.x + jQuery.iAutoscroller.elsToScroll[i].parentData.l > elementData.x) {
                jQuery.iAutoscroller.elsToScroll[i].scrollLeft -= jQuery.iAutoscroller.step;
            } else if (jQuery.iAutoscroller.elsToScroll[i].parentData.l <= jQuery.iAutoscroller.elsToScroll[i].parentData.wh && jQuery.iAutoscroller.elsToScroll[i].parentData.l + jQuery.iAutoscroller.elsToScroll[i].parentData.wb < elementData.x + elementData.wb) {
                jQuery.iAutoscroller.elsToScroll[i].scrollLeft += jQuery.iAutoscroller.step;
            }
        }
    },
    stop: function () {
        window.clearInterval(jQuery.iAutoscroller.timer);
        jQuery.iAutoscroller.elToScroll = null;
        jQuery.iAutoscroller.elsToScroll = null;
        for (i in jQuery.iAutoscroller.elsToScroll) {
            jQuery.iAutoscroller.elsToScroll[i].parentData = null;
        }
    }
};
jQuery.ImageBox = {
    options: {
        border: 10,
        loaderSRC: 'images/loading.gif',
        closeHTML: '<img src="images/close.jpg" />',
        overlayOpacity: 0.8,
        textImage: 'Showing image',
        textImageFrom: 'from',
        fadeDuration: 400
    },
    imageLoaded: false,
    firstResize: false,
    currentRel: null,
    animationInProgress: false,
    opened: false,
    keyPressed: function (event) {
        if (!jQuery.ImageBox.opened || jQuery.ImageBox.animationInProgress)
            return;
        var pressedKey = event.charCode || event.keyCode || -1;
        switch (pressedKey) {
        case 35:
            if (jQuery.ImageBox.currentRel)
                jQuery.ImageBox.start(null, jQuery('a[@rel=' + jQuery.ImageBox.currentRel + ']:last').get(0));
            break;
        case 36:
            if (jQuery.ImageBox.currentRel)
                jQuery.ImageBox.start(null, jQuery('a[@rel=' + jQuery.ImageBox.currentRel + ']:first').get(0));
            break;
        case 37:
        case 8:
        case 33:
        case 80:
        case 112:
            var prevEl = jQuery('#ImageBoxPrevImage');
            if (prevEl.get(0).onclick != null) {
                prevEl.get(0).onclick.apply(prevEl.get(0));
            }
            break;
        case 38:
            break;
        case 39:
        case 34:
        case 32:
        case 110:
        case 78:
            var nextEl = jQuery('#ImageBoxNextImage');
            if (nextEl.get(0).onclick != null) {
                nextEl.get(0).onclick.apply(nextEl.get(0));
            }
            break;
        case 40:
            break;
        case 27:
            jQuery.ImageBox.hideImage();
            break;
        }
    },
    init: function (options) {
        if (options)
            jQuery.extend(jQuery.ImageBox.options, options);
        if (window.event) {
            jQuery('body', document).bind('keyup', jQuery.ImageBox.keyPressed);
        } else {
            jQuery(document).bind('keyup', jQuery.ImageBox.keyPressed);
        }
        jQuery('a').each(function () {
            el = jQuery(this);
            relAttr = el.attr('rel') || '';
            hrefAttr = el.attr('href') || '';
            imageTypes = /\.jpg|\.jpeg|\.png|\.gif|\.bmp/g;
            if (hrefAttr.toLowerCase().match(imageTypes) != null && relAttr.toLowerCase().indexOf('imagebox') == 0) {
                el.bind('click', jQuery.ImageBox.start);
            }
        });
        if (jQuery.browser.msie) {
            iframe = document.createElement('iframe');
            jQuery(iframe).attr({
                id: 'ImageBoxIframe',
                src: 'javascript:false;',
                frameborder: 'no',
                scrolling: 'no'
            }).css({
                display: 'none',
                position: 'absolute',
                top: '0',
                left: '0',
                filter: 'progid:DXImageTransform.Microsoft.Alpha(opacity=0)'
            });
            jQuery('body').append(iframe);
        }
        overlay = document.createElement('div');
        jQuery(overlay).attr('id', 'ImageBoxOverlay').css({
            position: 'absolute',
            display: 'none',
            top: '0',
            left: '0',
            opacity: 0
        }).append(document.createTextNode(' ')).bind('click', jQuery.ImageBox.hideImage);
        captionText = document.createElement('div');
        jQuery(captionText).attr('id', 'ImageBoxCaptionText').css({
            paddingLeft: jQuery.ImageBox.options.border + 'px'
        }).append(document.createTextNode(' '));
        captionImages = document.createElement('div');
        jQuery(captionImages).attr('id', 'ImageBoxCaptionImages').css({
            paddingLeft: jQuery.ImageBox.options.border + 'px',
            paddingBottom: jQuery.ImageBox.options.border + 'px'
        }).append(document.createTextNode(' '));
        closeEl = document.createElement('a');
        jQuery(closeEl).attr({
            id: 'ImageBoxClose',
            href: '#'
        }).css({
            position: 'absolute',
            right: jQuery.ImageBox.options.border + 'px',
            top: '0'
        }).append(jQuery.ImageBox.options.closeHTML).bind('click', jQuery.ImageBox.hideImage);
        captionEl = document.createElement('div');
        jQuery(captionEl).attr('id', 'ImageBoxCaption').css({
            position: 'relative',
            textAlign: 'left',
            margin: '0 auto',
            zIndex: 1
        }).append(captionText).append(captionImages).append(closeEl);
        loader = document.createElement('img');
        loader.src = jQuery.ImageBox.options.loaderSRC;
        jQuery(loader).attr('id', 'ImageBoxLoader').css({
            position: 'absolute'
        });
        prevImage = document.createElement('a');
        jQuery(prevImage).attr({
            id: 'ImageBoxPrevImage',
            href: '#'
        }).css({
            position: 'absolute',
            display: 'none',
            overflow: 'hidden',
            textDecoration: 'none'
        }).append(document.createTextNode(' '));
        nextImage = document.createElement('a');
        jQuery(nextImage).attr({
            id: 'ImageBoxNextImage',
            href: '#'
        }).css({
            position: 'absolute',
            overflow: 'hidden',
            textDecoration: 'none'
        }).append(document.createTextNode(' '));
        container = document.createElement('div');
        jQuery(container).attr('id', 'ImageBoxContainer').css({
            display: 'none',
            position: 'relative',
            overflow: 'hidden',
            textAlign: 'left',
            margin: '0 auto',
            top: '0',
            left: '0',
            zIndex: 2
        }).append([loader, prevImage, nextImage]);
        outerContainer = document.createElement('div');
        jQuery(outerContainer).attr('id', 'ImageBoxOuterContainer').css({
            display: 'none',
            position: 'absolute',
            overflow: 'hidden',
            top: '0',
            left: '0',
            textAlign: 'center',
            backgroundColor: 'transparent',
            lineHeigt: '0'
        }).append([container, captionEl]);
        jQuery('body').append(overlay).append(outerContainer);
    },
    start: function (e, elm) {
        el = elm ? jQuery(elm) : jQuery(this);
        linkRel = el.attr('rel');
        var totalImages, iteration, prevImage, nextImage;
        if (linkRel != 'imagebox') {
            jQuery.ImageBox.currentRel = linkRel;
            gallery = jQuery('a[@rel=' + linkRel + ']');
            totalImages = gallery.size();
            iteration = gallery.index(elm ? elm : this);
            prevImage = gallery.get(iteration - 1);
            nextImage = gallery.get(iteration + 1);
        }
        imageSrc = el.attr('href');
        captionText = el.attr('title');
        pageSize = jQuery.iUtil.getScroll();
        overlay = jQuery('#ImageBoxOverlay');
        if (!jQuery.ImageBox.opened) {
            jQuery.ImageBox.opened = true;
            if (jQuery.browser.msie) {
                jQuery('#ImageBoxIframe').css('height', Math.max(pageSize.ih, pageSize.h) + 'px').css('width', Math.max(pageSize.iw, pageSize.w) + 'px').show();
            }
            overlay.css('height', Math.max(pageSize.ih, pageSize.h) + 'px').css('width', Math.max(pageSize.iw, pageSize.w) + 'px').show().fadeTo(300, jQuery.ImageBox.options.overlayOpacity, function () {
                jQuery.ImageBox.loadImage(imageSrc, captionText, pageSize, totalImages, iteration, prevImage, nextImage);
            });
            jQuery('#ImageBoxOuterContainer').css('width', Math.max(pageSize.iw, pageSize.w) + 'px');
        } else {
            jQuery('#ImageBoxPrevImage').get(0).onclick = null;
            jQuery('#ImageBoxNextImage').get(0).onclick = null;
            jQuery.ImageBox.loadImage(imageSrc, captionText, pageSize, totalImages, iteration, prevImage, nextImage);
        }
        return false;
    },
    loadImage: function (imageSrc, captiontext, pageSize, totalImages, iteration, prevImage, nextImage) {
        jQuery('#ImageBoxCurrentImage').remove();
        prevImageEl = jQuery('#ImageBoxPrevImage');
        prevImageEl.hide();
        nextImageEl = jQuery('#ImageBoxNextImage');
        nextImageEl.hide();
        loader = jQuery('#ImageBoxLoader');
        container = jQuery('#ImageBoxContainer');
        outerContainer = jQuery('#ImageBoxOuterContainer');
        captionEl = jQuery('#ImageBoxCaption').css('visibility', 'hidden');
        jQuery('#ImageBoxCaptionText').html(captionText);
        jQuery.ImageBox.animationInProgress = true;
        if (totalImages)
            jQuery('#ImageBoxCaptionImages').html(jQuery.ImageBox.options.textImage + ' ' + (iteration + 1) + ' ' + jQuery.ImageBox.options.textImageFrom + ' ' + totalImages);
        if (prevImage) {
            prevImageEl.get(0).onclick = function () {
                this.blur();
                jQuery.ImageBox.start(null, prevImage);
                return false;
            };
        }
        if (nextImage) {
            nextImageEl.get(0).onclick = function () {
                this.blur();
                jQuery.ImageBox.start(null, nextImage);
                return false;
            };
        }
        loader.show();
        containerSize = jQuery.iUtil.getSize(container.get(0));
        containerW = Math.max(containerSize.wb, loader.get(0).width + jQuery.ImageBox.options.border * 2);
        containerH = Math.max(containerSize.hb, loader.get(0).height + jQuery.ImageBox.options.border * 2);
        loader.css({
            left: (containerW - loader.get(0).width) / 2 + 'px',
            top: (containerH - loader.get(0).height) / 2 + 'px'
        });
        container.css({
            width: containerW + 'px',
            height: containerH + 'px'
        }).show();
        clientSize = jQuery.iUtil.getClient();
        outerContainer.css('top', pageSize.t + (clientSize.h / 15) + 'px');
        if (outerContainer.css('display') == 'none') {
            outerContainer.show().fadeIn(jQuery.ImageBox.options.fadeDuration);
        }
        imageEl = new Image;
        jQuery(imageEl).attr('id', 'ImageBoxCurrentImage').bind('load', function () {
            containerW = imageEl.width + jQuery.ImageBox.options.border * 2;
            containerH = imageEl.height + jQuery.ImageBox.options.border * 2;
            loader.hide();
            container.animate({
                height: containerH
            }, containerSize.hb != containerH ? jQuery.ImageBox.options.fadeDuration : 1, function () {
                container.animate({
                    width: containerW
                }, containerSize.wb != containerW ? jQuery.ImageBox.options.fadeDuration : 1, function () {
                    container.prepend(imageEl);
                    jQuery(imageEl).css({
                        position: 'absolute',
                        left: jQuery.ImageBox.options.border + 'px',
                        top: jQuery.ImageBox.options.border + 'px'
                    }).fadeIn(jQuery.ImageBox.options.fadeDuration, function () {
                        captionSize = jQuery.iUtil.getSize(captionEl.get(0));
                        if (prevImage) {
                            prevImageEl.css({
                                left: jQuery.ImageBox.options.border + 'px',
                                top: jQuery.ImageBox.options.border + 'px',
                                width: containerW / 2 - jQuery.ImageBox.options.border * 3 + 'px',
                                height: containerH - jQuery.ImageBox.options.border * 2 + 'px'
                            }).show();
                        }
                        if (nextImage) {
                            nextImageEl.css({
                                left: containerW / 2 + jQuery.ImageBox.options.border * 2 + 'px',
                                top: jQuery.ImageBox.options.border + 'px',
                                width: containerW / 2 - jQuery.ImageBox.options.border * 3 + 'px',
                                height: containerH - jQuery.ImageBox.options.border * 2 + 'px'
                            }).show();
                        }
                        captionEl.css({
                            width: containerW + 'px',
                            top: -captionSize.hb + 'px',
                            visibility: 'visible'
                        }).animate({
                            top: -1
                        }, jQuery.ImageBox.options.fadeDuration, function () {
                            jQuery.ImageBox.animationInProgress = false;
                        });
                    });
                });
            });
        });
        imageEl.src = imageSrc;
    },
    hideImage: function () {
        jQuery('#ImageBoxCurrentImage').remove();
        jQuery('#ImageBoxOuterContainer').hide();
        jQuery('#ImageBoxCaption').css('visibility', 'hidden');
        jQuery('#ImageBoxOverlay').fadeTo(300, 0, function () {
            jQuery(this).hide();
            if (jQuery.browser.msie) {
                jQuery('#ImageBoxIframe').hide();
            }
        });
        jQuery('#ImageBoxPrevImage').get(0).onclick = null;
        jQuery('#ImageBoxNextImage').get(0).onclick = null;
        jQuery.ImageBox.currentRel = null;
        jQuery.ImageBox.opened = false;
        jQuery.ImageBox.animationInProgress = false;
        return false;
    }
};
jQuery.islideshow = {
    slideshows: [],
    gonext: function () {
        this.blur();
        slideshow = this.parentNode;
        id = jQuery.attr(slideshow, 'id');
        if (jQuery.islideshow.slideshows[id] != null) {
            window.clearInterval(jQuery.islideshow.slideshows[id]);
        }
        slide = slideshow.ss.currentslide + 1;
        if (slideshow.ss.images.length < slide) {
            slide = 1;
        }
        images = jQuery('img', slideshow.ss.holder);
        slideshow.ss.currentslide = slide;
        if (images.size() > 0) {
            images.fadeOut(slideshow.ss.fadeDuration, jQuery.islideshow.showImage);
        }
    },
    goprev: function () {
        this.blur();
        slideshow = this.parentNode;
        id = jQuery.attr(slideshow, 'id');
        if (jQuery.islideshow.slideshows[id] != null) {
            window.clearInterval(jQuery.islideshow.slideshows[id]);
        }
        slide = slideshow.ss.currentslide - 1;
        images = jQuery('img', slideshow.ss.holder);
        if (slide < 1) {
            slide = slideshow.ss.images.length;
        }
        slideshow.ss.currentslide = slide;
        if (images.size() > 0) {
            images.fadeOut(slideshow.ss.fadeDuration, jQuery.islideshow.showImage);
        }
    },
    timer: function (c) {
        slideshow = document.getElementById(c);
        if (slideshow.ss.random) {
            slide = slideshow.ss.currentslide;
            while (slide == slideshow.ss.currentslide) {
                slide = 1 + parseInt(Math.random() * slideshow.ss.images.length);
            }
        } else {
            slide = slideshow.ss.currentslide + 1;
            if (slideshow.ss.images.length < slide) {
                slide = 1;
            }
        }
        images = jQuery('img', slideshow.ss.holder);
        slideshow.ss.currentslide = slide;
        if (images.size() > 0) {
            images.fadeOut(slideshow.ss.fadeDuration, jQuery.islideshow.showImage);
        }
    },
    go: function (o) {
        var slideshow;
        if (o && o.constructor == Object) {
            if (o.loader) {
                slideshow = document.getElementById(o.loader.slideshow);
                url = window.location.href.split("#");
                o.loader.onload = null;
                if (url.length == 2) {
                    slide = parseInt(url[1]);
                    show = url[1].replace(slide, '');
                    if (jQuery.attr(slideshow, 'id') != show) {
                        slide = 1;
                    }
                } else {
                    slide = 1;
                }
            }
            if (o.link) {
                o.link.blur();
                slideshow = o.link.parentNode.parentNode;
                id = jQuery.attr(slideshow, 'id');
                if (jQuery.islideshow.slideshows[id] != null) {
                    window.clearInterval(jQuery.islideshow.slideshows[id]);
                }
                url = o.link.href.split("#");
                slide = parseInt(url[1]);
                show = url[1].replace(slide, '');
                if (jQuery.attr(slideshow, 'id') != show) {
                    slide = 1;
                }
            }
            if (slideshow.ss.images.length < slide || slide < 1) {
                slide = 1;
            }
            slideshow.ss.currentslide = slide;
            slidePos = jQuery.iUtil.getSize(slideshow);
            slidePad = jQuery.iUtil.getPadding(slideshow);
            slideBor = jQuery.iUtil.getBorder(slideshow);
            if (slideshow.ss.prevslide) {
                slideshow.ss.prevslide.o.css('display', 'none');
            }
            if (slideshow.ss.nextslide) {
                slideshow.ss.nextslide.o.css('display', 'none');
            }
            if (slideshow.ss.loader) {
                y = parseInt(slidePad.t) + parseInt(slideBor.t);
                if (slideshow.ss.slideslinks) {
                    if (slideshow.ss.slideslinks.linksPosition == 'top') {
                        y += slideshow.ss.slideslinks.dimm.hb;
                    } else {
                        slidePos.h -= slideshow.ss.slideslinks.dimm.hb;
                    }
                }
                if (slideshow.ss.slideCaption) {
                    if (slideshow.ss.slideCaption && slideshow.ss.slideCaption.captionPosition == 'top') {
                        y += slideshow.ss.slideCaption.dimm.hb;
                    } else {
                        slidePos.h -= slideshow.ss.slideCaption.dimm.hb;
                    }
                }
                if (!slideshow.ss.loaderWidth) {
                    slideshow.ss.loaderHeight = o.loader ? o.loader.height : (parseInt(slideshow.ss.loader.css('height')) || 0);
                    slideshow.ss.loaderWidth = o.loader ? o.loader.width : (parseInt(slideshow.ss.loader.css('width')) || 0);
                }
                slideshow.ss.loader.css('top', y + (slidePos.h - slideshow.ss.loaderHeight) / 2 + 'px');
                slideshow.ss.loader.css('left', (slidePos.wb - slideshow.ss.loaderWidth) / 2 + 'px');
                slideshow.ss.loader.css('display', 'block');
            }
            images = jQuery('img', slideshow.ss.holder);
            if (images.size() > 0) {
                images.fadeOut(slideshow.ss.fadeDuration, jQuery.islideshow.showImage);
            } else {
                lnk = jQuery('a', slideshow.ss.slideslinks.o).get(slide - 1);
                jQuery(lnk).addClass(slideshow.ss.slideslinks.activeLinkClass);
                var img = new Image();
                img.slideshow = jQuery.attr(slideshow, 'id');
                img.slide = slide - 1;
                img.src = slideshow.ss.images[slideshow.ss.currentslide - 1].src;
                if (img.complete) {
                    img.onload = null;
                    jQuery.islideshow.display.apply(img);
                } else {
                    img.onload = jQuery.islideshow.display;
                }
                if (slideshow.ss.slideCaption) {
                    slideshow.ss.slideCaption.o.html(slideshow.ss.images[slide - 1].caption);
                }
            }
        }
    },
    showImage: function () {
        slideshow = this.parentNode.parentNode;
        slideshow.ss.holder.css('display', 'none');
        if (slideshow.ss.slideslinks.activeLinkClass) {
            lnk = jQuery('a', slideshow.ss.slideslinks.o).removeClass(slideshow.ss.slideslinks.activeLinkClass).get(slideshow.ss.currentslide - 1);
            jQuery(lnk).addClass(slideshow.ss.slideslinks.activeLinkClass);
        }
        var img = new Image();
        img.slideshow = jQuery.attr(slideshow, 'id');
        img.slide = slideshow.ss.currentslide - 1;
        img.src = slideshow.ss.images[slideshow.ss.currentslide - 1].src;
        if (img.complete) {
            img.onload = null;
            jQuery.islideshow.display.apply(img);
        } else {
            img.onload = jQuery.islideshow.display;
        }
        if (slideshow.ss.slideCaption) {
            slideshow.ss.slideCaption.o.html(slideshow.ss.images[slideshow.ss.currentslide - 1].caption);
        }
    },
    display: function () {
        slideshow = document.getElementById(this.slideshow);
        if (slideshow.ss.prevslide) {
            slideshow.ss.prevslide.o.css('display', 'none');
        }
        if (slideshow.ss.nextslide) {
            slideshow.ss.nextslide.o.css('display', 'none');
        }
        slidePos = jQuery.iUtil.getSize(slideshow);
        y = 0;
        if (slideshow.ss.slideslinks) {
            if (slideshow.ss.slideslinks.linksPosition == 'top') {
                y += slideshow.ss.slideslinks.dimm.hb;
            } else {
                slidePos.h -= slideshow.ss.slideslinks.dimm.hb;
            }
        }
        if (slideshow.ss.slideCaption) {
            if (slideshow.ss.slideCaption && slideshow.ss.slideCaption.captionPosition == 'top') {
                y += slideshow.ss.slideCaption.dimm.hb;
            } else {
                slidePos.h -= slideshow.ss.slideCaption.dimm.hb;
            }
        }
        par = jQuery('.slideshowHolder', slideshow);
        y = y + (slidePos.h - this.height) / 2;
        x = (slidePos.wb - this.width) / 2;
        slideshow.ss.holder.css('top', y + 'px').css('left', x + 'px').html('<img src="' + this.src + '" />');
        slideshow.ss.holder.fadeIn(slideshow.ss.fadeDuration);
        nextslide = slideshow.ss.currentslide + 1;
        if (nextslide > slideshow.ss.images.length) {
            nextslide = 1;
        }
        prevslide = slideshow.ss.currentslide - 1;
        if (prevslide < 1) {
            prevslide = slideshow.ss.images.length;
        }
        slideshow.ss.nextslide.o.css('display', 'block').css('top', y + 'px').css('left', x + 2 * this.width / 3 + 'px').css('width', this.width / 3 + 'px').css('height', this.height + 'px').attr('title', slideshow.ss.images[nextslide - 1].caption);
        slideshow.ss.nextslide.o.get(0).href = '#' + nextslide + jQuery.attr(slideshow, 'id');
        slideshow.ss.prevslide.o.css('display', 'block').css('top', y + 'px').css('left', x + 'px').css('width', this.width / 3 + 'px').css('height', this.height + 'px').attr('title', slideshow.ss.images[prevslide - 1].caption);
        slideshow.ss.prevslide.o.get(0).href = '#' + prevslide + jQuery.attr(slideshow, 'id');
    },
    build: function (o) {
        if (!o || !o.container || jQuery.islideshow.slideshows[o.container])
            return;
        var container = jQuery('#' + o.container);
        var el = container.get(0);
        if (el.style.position != 'absolute' && el.style.position != 'relative') {
            el.style.position = 'relative';
        }
        el.style.overflow = 'hidden';
        if (container.size() == 0)
            return;
        el.ss = {};
        el.ss.images = o.images ? o.images : [];
        el.ss.random = o.random && o.random == true || false;
        imgs = el.getElementsByTagName('IMG');
        for (i = 0; i < imgs.length; i++) {
            indic = el.ss.images.length;
            el.ss.images[indic] = {
                src: imgs[i].src,
                caption: imgs[i].title || imgs[i].alt || ''
            };
        }
        if (el.ss.images.length == 0) {
            return;
        }
        el.ss.oP = jQuery.extend(jQuery.iUtil.getPosition(el), jQuery.iUtil.getSize(el));
        el.ss.oPad = jQuery.iUtil.getPadding(el);
        el.ss.oBor = jQuery.iUtil.getBorder(el);
        t = parseInt(el.ss.oPad.t) + parseInt(el.ss.oBor.t);
        b = parseInt(el.ss.oPad.b) + parseInt(el.ss.oBor.b);
        jQuery('img', el).remove();
        el.ss.fadeDuration = o.fadeDuration ? o.fadeDuration : 500;
        if (o.linksPosition || o.linksClass || o.activeLinkClass) {
            el.ss.slideslinks = {};
            container.append('<div class="slideshowLinks"></div>');
            el.ss.slideslinks.o = jQuery('.slideshowLinks', el);
            if (o.linksClass) {
                el.ss.slideslinks.linksClass = o.linksClass;
                el.ss.slideslinks.o.addClass(o.linksClass);
            }
            if (o.activeLinkClass) {
                el.ss.slideslinks.activeLinkClass = o.activeLinkClass;
            }
            el.ss.slideslinks.o.css('position', 'absolute').css('width', el.ss.oP.w + 'px');
            if (o.linksPosition && o.linksPosition == 'top') {
                el.ss.slideslinks.linksPosition = 'top';
                el.ss.slideslinks.o.css('top', t + 'px');
            } else {
                el.ss.slideslinks.linksPosition = 'bottom';
                el.ss.slideslinks.o.css('bottom', b + 'px');
            }
            el.ss.slideslinks.linksSeparator = o.linksSeparator ? o.linksSeparator : ' ';
            for (var i = 0; i < el.ss.images.length; i++) {
                indic = parseInt(i) + 1;
                el.ss.slideslinks.o.append('<a href="#' + indic + o.container + '" class="slideshowLink" title="' + el.ss.images[i].caption + '">' + indic + '</a>' + (indic != el.ss.images.length ? el.ss.slideslinks.linksSeparator : ''));
            }
            jQuery('a', el.ss.slideslinks.o).bind('click', function () {
                jQuery.islideshow.go({
                    link: this
                })
            });
            el.ss.slideslinks.dimm = jQuery.iUtil.getSize(el.ss.slideslinks.o.get(0));
        }
        if (o.captionPosition || o.captionClass) {
            el.ss.slideCaption = {};
            container.append('<div class="slideshowCaption">&nbsp;</div>');
            el.ss.slideCaption.o = jQuery('.slideshowCaption', el);
            if (o.captionClass) {
                el.ss.slideCaption.captionClass = o.captionClass;
                el.ss.slideCaption.o.addClass(o.captionClass);
            }
            el.ss.slideCaption.o.css('position', 'absolute').css('width', el.ss.oP.w + 'px');
            if (o.captionPosition && o.captionPosition == 'top') {
                el.ss.slideCaption.captionPosition = 'top';
                el.ss.slideCaption.o.css('top', (el.ss.slideslinks && el.ss.slideslinks.linksPosition == 'top' ? el.ss.slideslinks.dimm.hb + t : t) + 'px');
            } else {
                el.ss.slideCaption.captionPosition = 'bottom';
                el.ss.slideCaption.o.css('bottom', (el.ss.slideslinks && el.ss.slideslinks.linksPosition == 'bottom' ? el.ss.slideslinks.dimm.hb + b : b) + 'px');
            }
            el.ss.slideCaption.dimm = jQuery.iUtil.getSize(el.ss.slideCaption.o.get(0));
        }
        if (o.nextslideClass) {
            el.ss.nextslide = {
                nextslideClass: o.nextslideClass
            };
            container.append('<a href="#2' + o.container + '" class="slideshowNextSlide">&nbsp;</a>');
            el.ss.nextslide.o = jQuery('.slideshowNextSlide', el);
            el.ss.nextslide.o.css('position', 'absolute').css('display', 'none').css('overflow', 'hidden').css('fontSize', '30px').addClass(el.ss.nextslide.nextslideClass);
            el.ss.nextslide.o.bind('click', jQuery.islideshow.gonext);
        }
        if (o.prevslideClass) {
            el.ss.prevslide = {
                prevslideClass: o.prevslideClass
            };
            container.append('<a href="#0' + o.container + '" class="slideshowPrevslide">&nbsp;</a>');
            el.ss.prevslide.o = jQuery('.slideshowPrevslide', el);
            el.ss.prevslide.o.css('position', 'absolute').css('display', 'none').css('overflow', 'hidden').css('fontSize', '30px').addClass(el.ss.prevslide.prevslideClass);
            el.ss.prevslide.o.bind('click', jQuery.islideshow.goprev);
        }
        container.prepend('<div class="slideshowHolder"></div>');
        el.ss.holder = jQuery('.slideshowHolder', el);
        el.ss.holder.css('position', 'absolute').css('top', '0px').css('left', '0px').css('display', 'none');
        if (o.loader) {
            container.prepend('<div class="slideshowLoader" style="display: none;"><img src="' + o.loader + '" /></div>');
            el.ss.loader = jQuery('.slideshowLoader', el);
            el.ss.loader.css('position', 'absolute');
            var img = new Image();
            img.slideshow = o.container;
            img.src = o.loader;
            if (img.complete) {
                img.onload = null;
                jQuery.islideshow.go({
                    loader: img
                });
            } else {
                img.onload = function () {
                    jQuery.islideshow.go({
                        loader: this
                    });
                };
            }
        } else {
            jQuery.islideshow.go({
                container: el
            });
        }
        if (o.autoplay) {
            time = parseInt(o.autoplay) * 1000;
        }
        jQuery.islideshow.slideshows[o.container] = o.autoplay ? window.setInterval('jQuery.islideshow.timer(\'' + o.container + '\')', time) : null;
    }
};
jQuery.slideshow = jQuery.islideshow.build;
jQuery.iDrop = {
    fit: function (zonex, zoney, zonew, zoneh) {
        return zonex <= jQuery.iDrag.dragged.dragCfg.nx && (zonex + zonew) >= (jQuery.iDrag.dragged.dragCfg.nx + jQuery.iDrag.dragged.dragCfg.oC.w) && zoney <= jQuery.iDrag.dragged.dragCfg.ny && (zoney + zoneh) >= (jQuery.iDrag.dragged.dragCfg.ny + jQuery.iDrag.dragged.dragCfg.oC.h) ? true : false;
    },
    intersect: function (zonex, zoney, zonew, zoneh) {
        return !(zonex > (jQuery.iDrag.dragged.dragCfg.nx + jQuery.iDrag.dragged.dragCfg.oC.w) || (zonex + zonew) < jQuery.iDrag.dragged.dragCfg.nx || zoney > (jQuery.iDrag.dragged.dragCfg.ny + jQuery.iDrag.dragged.dragCfg.oC.h) || (zoney + zoneh) < jQuery.iDrag.dragged.dragCfg.ny) ? true : false;
    },
    pointer: function (zonex, zoney, zonew, zoneh) {
        return zonex < jQuery.iDrag.dragged.dragCfg.currentPointer.x && (zonex + zonew) > jQuery.iDrag.dragged.dragCfg.currentPointer.x && zoney < jQuery.iDrag.dragged.dragCfg.currentPointer.y && (zoney + zoneh) > jQuery.iDrag.dragged.dragCfg.currentPointer.y ? true : false;
    },
    overzone: false,
    highlighted: {},
    count: 0,
    zones: {},
    highlight: function (elm) {
        if (jQuery.iDrag.dragged == null) {
            return;
        }
        var i;
        jQuery.iDrop.highlighted = {};
        var oneIsSortable = false;
        for (i in jQuery.iDrop.zones) {
            if (jQuery.iDrop.zones[i] != null) {
                var iEL = jQuery.iDrop.zones[i].get(0);
                if (jQuery(jQuery.iDrag.dragged).is('.' + iEL.dropCfg.a)) {
                    if (iEL.dropCfg.m == false) {
                        iEL.dropCfg.p = jQuery.extend(jQuery.iUtil.getPositionLite(iEL), jQuery.iUtil.getSizeLite(iEL));
                        iEL.dropCfg.m = true;
                    }
                    if (iEL.dropCfg.ac) {
                        jQuery.iDrop.zones[i].addClass(iEL.dropCfg.ac);
                    }
                    jQuery.iDrop.highlighted[i] = jQuery.iDrop.zones[i];
                    if (jQuery.iSort && iEL.dropCfg.s && jQuery.iDrag.dragged.dragCfg.so) {
                        iEL.dropCfg.el = jQuery('.' + iEL.dropCfg.a, iEL);
                        elm.style.display = 'none';
                        jQuery.iSort.measure(iEL);
                        iEL.dropCfg.os = jQuery.iSort.serialize(jQuery.attr(iEL, 'id')).hash;
                        elm.style.display = elm.dragCfg.oD;
                        oneIsSortable = true;
                    }
                    if (iEL.dropCfg.onActivate) {
                        iEL.dropCfg.onActivate.apply(jQuery.iDrop.zones[i].get(0), [jQuery.iDrag.dragged]);
                    }
                }
            }
        }
        if (oneIsSortable) {
            jQuery.iSort.start();
        }
    },
    remeasure: function () {
        jQuery.iDrop.highlighted = {};
        for (i in jQuery.iDrop.zones) {
            if (jQuery.iDrop.zones[i] != null) {
                var iEL = jQuery.iDrop.zones[i].get(0);
                if (jQuery(jQuery.iDrag.dragged).is('.' + iEL.dropCfg.a)) {
                    iEL.dropCfg.p = jQuery.extend(jQuery.iUtil.getPositionLite(iEL), jQuery.iUtil.getSizeLite(iEL));
                    if (iEL.dropCfg.ac) {
                        jQuery.iDrop.zones[i].addClass(iEL.dropCfg.ac);
                    }
                    jQuery.iDrop.highlighted[i] = jQuery.iDrop.zones[i];
                    if (jQuery.iSort && iEL.dropCfg.s && jQuery.iDrag.dragged.dragCfg.so) {
                        iEL.dropCfg.el = jQuery('.' + iEL.dropCfg.a, iEL);
                        elm.style.display = 'none';
                        jQuery.iSort.measure(iEL);
                        elm.style.display = elm.dragCfg.oD;
                    }
                }
            }
        }
    },
    checkhover: function (e) {
        if (jQuery.iDrag.dragged == null) {
            return;
        }
        jQuery.iDrop.overzone = false;
        var i;
        var applyOnHover = false;
        var hlt = 0;
        for (i in jQuery.iDrop.highlighted) {
            var iEL = jQuery.iDrop.highlighted[i].get(0);
            if (jQuery.iDrop.overzone == false && jQuery.iDrop[iEL.dropCfg.t](iEL.dropCfg.p.x, iEL.dropCfg.p.y, iEL.dropCfg.p.wb, iEL.dropCfg.p.hb)) {
                if (iEL.dropCfg.hc && iEL.dropCfg.h == false) {
                    jQuery.iDrop.highlighted[i].addClass(iEL.dropCfg.hc);
                }
                if (iEL.dropCfg.h == false && iEL.dropCfg.onHover) {
                    applyOnHover = true;
                }
                iEL.dropCfg.h = true;
                jQuery.iDrop.overzone = iEL;
                if (jQuery.iSort && iEL.dropCfg.s && jQuery.iDrag.dragged.dragCfg.so) {
                    jQuery.iSort.helper.get(0).className = iEL.dropCfg.shc;
                    jQuery.iSort.checkhover(iEL);
                }
                hlt++;
            } else if (iEL.dropCfg.h == true) {
                if (iEL.dropCfg.onOut) {
                    iEL.dropCfg.onOut.apply(iEL, [e, jQuery.iDrag.helper.get(0).firstChild, iEL.dropCfg.fx]);
                }
                if (iEL.dropCfg.hc) {
                    jQuery.iDrop.highlighted[i].removeClass(iEL.dropCfg.hc);
                }
                iEL.dropCfg.h = false;
            }
        }
        if (jQuery.iSort && !jQuery.iDrop.overzone && jQuery.iDrag.dragged.so) {
            jQuery.iSort.helper.get(0).style.display = 'none';
        }
        if (applyOnHover) {
            jQuery.iDrop.overzone.dropCfg.onHover.apply(jQuery.iDrop.overzone, [e, jQuery.iDrag.helper.get(0).firstChild]);
        }
    },
    checkdrop: function (e) {
        var i;
        for (i in jQuery.iDrop.highlighted) {
            var iEL = jQuery.iDrop.highlighted[i].get(0);
            if (iEL.dropCfg.ac) {
                jQuery.iDrop.highlighted[i].removeClass(iEL.dropCfg.ac);
            }
            if (iEL.dropCfg.hc) {
                jQuery.iDrop.highlighted[i].removeClass(iEL.dropCfg.hc);
            }
            if (iEL.dropCfg.s) {
                jQuery.iSort.changed[jQuery.iSort.changed.length] = i;
            }
            if (iEL.dropCfg.onDrop && iEL.dropCfg.h == true) {
                iEL.dropCfg.h = false;
                iEL.dropCfg.onDrop.apply(iEL, [e, iEL.dropCfg.fx]);
            }
            iEL.dropCfg.m = false;
            iEL.dropCfg.h = false;
        }
        jQuery.iDrop.highlighted = {};
    },
    destroy: function () {
        return this.each(function () {
            if (this.isDroppable) {
                if (this.dropCfg.s) {
                    id = jQuery.attr(this, 'id');
                    jQuery.iSort.collected[id] = null;
                    jQuery('.' + this.dropCfg.a, this).DraggableDestroy();
                }
                jQuery.iDrop.zones['d' + this.idsa] = null;
                this.isDroppable = false;
                this.f = null;
            }
        });
    },
    build: function (o) {
        return this.each(function () {
            if (this.isDroppable == true || !o.accept || !jQuery.iUtil || !jQuery.iDrag) {
                return;
            }
            this.dropCfg = {
                a: o.accept,
                ac: o.activeclass || false,
                hc: o.hoverclass || false,
                shc: o.helperclass || false,
                onDrop: o.ondrop || o.onDrop || false,
                onHover: o.onHover || o.onhover || false,
                onOut: o.onOut || o.onout || false,
                onActivate: o.onActivate || false,
                t: o.tolerance && (o.tolerance == 'fit' || o.tolerance == 'intersect') ? o.tolerance : 'pointer',
                fx: o.fx ? o.fx : false,
                m: false,
                h: false
            };
            if (o.sortable == true && jQuery.iSort) {
                id = jQuery.attr(this, 'id');
                jQuery.iSort.collected[id] = this.dropCfg.a;
                this.dropCfg.s = true;
                if (o.onChange) {
                    this.dropCfg.onChange = o.onChange;
                    this.dropCfg.os = jQuery.iSort.serialize(id).hash;
                }
            }
            this.isDroppable = true;
            this.idsa = parseInt(Math.random() * 10000);
            jQuery.iDrop.zones['d' + this.idsa] = jQuery(this);
            jQuery.iDrop.count++;
        });
    }
};
jQuery.fn.extend({
    DroppableDestroy: jQuery.iDrop.destroy,
    Droppable: jQuery.iDrop.build
});
jQuery.recallDroppables = jQuery.iDrop.remeasure;
jQuery.fn.extend({
    DropOutDown: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.DropOutDirectiont(this, speed, callback, 'down', 'out', easing);
        });
    },
    DropInDown: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.DropOutDirectiont(this, speed, callback, 'down', 'in', easing);
        });
    },
    DropToggleDown: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.DropOutDirectiont(this, speed, callback, 'down', 'toggle', easing);
        });
    },
    DropOutUp: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.DropOutDirectiont(this, speed, callback, 'up', 'out', easing);
        });
    },
    DropInUp: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.DropOutDirectiont(this, speed, callback, 'up', 'in', easing);
        });
    },
    DropToggleUp: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.DropOutDirectiont(this, speed, callback, 'up', 'toggle', easing);
        });
    },
    DropOutLeft: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.DropOutDirectiont(this, speed, callback, 'left', 'out', easing);
        });
    },
    DropInLeft: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.DropOutDirectiont(this, speed, callback, 'left', 'in', easing);
        });
    },
    DropToggleLeft: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.DropOutDirectiont(this, speed, callback, 'left', 'toggle', easing);
        });
    },
    DropOutRight: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.DropOutDirectiont(this, speed, callback, 'right', 'out', easing);
        });
    },
    DropInRight: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.DropOutDirectiont(this, speed, callback, 'right', 'in', easing);
        });
    },
    DropToggleRight: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.DropOutDirectiont(this, speed, callback, 'right', 'toggle', easing);
        });
    }
});
jQuery.fx.DropOutDirectiont = function (e, speed, callback, direction, type, easing) {
    if (!jQuery.fxCheckTag(e)) {
        jQuery.dequeue(e, 'interfaceFX');
        return false;
    }
    var z = this;
    z.el = jQuery(e);
    z.easing = typeof callback == 'string' ? callback : easing || null;
    z.oldStyle = {};
    z.oldStyle.position = z.el.css('position');
    z.oldStyle.top = z.el.css('top');
    z.oldStyle.left = z.el.css('left');
    if (!e.ifxFirstDisplay)
        e.ifxFirstDisplay = z.el.css('display');
    if (type == 'toggle') {
        type = z.el.css('display') == 'none' ? 'in' : 'out';
    }
    z.el.show();
    if (z.oldStyle.position != 'relative' && z.oldStyle.position != 'absolute') {
        z.el.css('position', 'relative');
    }
    z.type = type;
    callback = typeof callback == 'function' ? callback : null;
    directionIncrement = 1;
    switch (direction) {
    case 'up':
        z.e = new jQuery.fx(z.el.get(0), jQuery.speed(speed - 15, z.easing, callback), 'top');
        z.point = parseFloat(z.oldStyle.top) || 0;
        z.unit = z.topUnit;
        directionIncrement = -1;
        break;
    case 'down':
        z.e = new jQuery.fx(z.el.get(0), jQuery.speed(speed - 15, z.easing, callback), 'top');
        z.point = parseFloat(z.oldStyle.top) || 0;
        z.unit = z.topUnit;
        break;
    case 'right':
        z.e = new jQuery.fx(z.el.get(0), jQuery.speed(speed - 15, z.easing, callback), 'left');
        z.point = parseFloat(z.oldStyle.left) || 0;
        z.unit = z.leftUnit;
        break;
    case 'left':
        z.e = new jQuery.fx(z.el.get(0), jQuery.speed(speed - 15, z.easing, callback), 'left');
        z.point = parseFloat(z.oldStyle.left) || 0;
        z.unit = z.leftUnit;
        directionIncrement = -1;
        break;
    }
    z.e2 = new jQuery.fx(z.el.get(0), jQuery.speed(speed, z.easing, function () {
        z.el.css(z.oldStyle);
        if (z.type == 'out') {
            z.el.css('display', 'none');
        } else
            z.el.css('display', z.el.get(0).ifxFirstDisplay == 'none' ? 'block' : z.el.get(0).ifxFirstDisplay);
        jQuery.dequeue(z.el.get(0), 'interfaceFX');
    }), 'opacity');
    if (type == 'in') {
        z.e.custom(z.point + 100 * directionIncrement, z.point);
        z.e2.custom(0, 1);
    } else {
        z.e.custom(z.point, z.point + 100 * directionIncrement);
        z.e2.custom(1, 0);
    }
};
jQuery.iResize = {
    resizeElement: null,
    resizeDirection: null,
    dragged: null,
    pointer: null,
    sizes: null,
    position: null,
    startDrag: function (e) {
        jQuery.iResize.dragged = (this.dragEl) ? this.dragEl : this;
        jQuery.iResize.pointer = jQuery.iUtil.getPointer(e);
        jQuery.iResize.sizes = {
            width: parseInt(jQuery(jQuery.iResize.dragged).css('width')) || 0,
            height: parseInt(jQuery(jQuery.iResize.dragged).css('height')) || 0
        };
        jQuery.iResize.position = {
            top: parseInt(jQuery(jQuery.iResize.dragged).css('top')) || 0,
            left: parseInt(jQuery(jQuery.iResize.dragged).css('left')) || 0
        };
        jQuery(document).bind('mousemove', jQuery.iResize.moveDrag).bind('mouseup', jQuery.iResize.stopDrag);
        if (typeof jQuery.iResize.dragged.resizeOptions.onDragStart === 'function') {
            jQuery.iResize.dragged.resizeOptions.onDragStart.apply(jQuery.iResize.dragged);
        }
        return false;
    },
    stopDrag: function (e) {
        jQuery(document).unbind('mousemove', jQuery.iResize.moveDrag).unbind('mouseup', jQuery.iResize.stopDrag);
        if (typeof jQuery.iResize.dragged.resizeOptions.onDragStop === 'function') {
            jQuery.iResize.dragged.resizeOptions.onDragStop.apply(jQuery.iResize.dragged);
        }
        jQuery.iResize.dragged = null;
    },
    moveDrag: function (e) {
        if (!jQuery.iResize.dragged) {
            return;
        }
        pointer = jQuery.iUtil.getPointer(e);
        newTop = jQuery.iResize.position.top - jQuery.iResize.pointer.y + pointer.y;
        newLeft = jQuery.iResize.position.left - jQuery.iResize.pointer.x + pointer.x;
        newTop = Math.max(Math.min(newTop, jQuery.iResize.dragged.resizeOptions.maxBottom - jQuery.iResize.sizes.height), jQuery.iResize.dragged.resizeOptions.minTop);
        newLeft = Math.max(Math.min(newLeft, jQuery.iResize.dragged.resizeOptions.maxRight - jQuery.iResize.sizes.width), jQuery.iResize.dragged.resizeOptions.minLeft);
        if (typeof jQuery.iResize.dragged.resizeOptions.onDrag === 'function') {
            var newPos = jQuery.iResize.dragged.resizeOptions.onDrag.apply(jQuery.iResize.dragged, [newLeft, newTop]);
            if (typeof newPos == 'array' && newPos.length == 2) {
                newLeft = newPos[0];
                newTop = newPos[1];
            }
        }
        jQuery.iResize.dragged.style.top = newTop + 'px';
        jQuery.iResize.dragged.style.left = newLeft + 'px';
        return false;
    },
    start: function (e) {
        jQuery(document).bind('mousemove', jQuery.iResize.move).bind('mouseup', jQuery.iResize.stop);
        jQuery.iResize.resizeElement = this.resizeElement;
        jQuery.iResize.resizeDirection = this.resizeDirection;
        jQuery.iResize.pointer = jQuery.iUtil.getPointer(e);
        jQuery.iResize.sizes = {
            width: parseInt(jQuery(this.resizeElement).css('width')) || 0,
            height: parseInt(jQuery(this.resizeElement).css('height')) || 0
        };
        jQuery.iResize.position = {
            top: parseInt(jQuery(this.resizeElement).css('top')) || 0,
            left: parseInt(jQuery(this.resizeElement).css('left')) || 0
        };
        if (jQuery.iResize.resizeElement.resizeOptions.onStart) {
            jQuery.iResize.resizeElement.resizeOptions.onStart.apply(jQuery.iResize.resizeElement, [this]);
        }
        return false;
    },
    stop: function () {
        jQuery(document).unbind('mousemove', jQuery.iResize.move).unbind('mouseup', jQuery.iResize.stop);
        if (jQuery.iResize.resizeElement.resizeOptions.onStop) {
            jQuery.iResize.resizeElement.resizeOptions.onStop.apply(jQuery.iResize.resizeElement, [jQuery.iResize.resizeDirection]);
        }
        jQuery.iResize.resizeElement = null;
        jQuery.iResize.resizeDirection = null;
    },
    getWidth: function (dx, side) {
        return Math.min(Math.max(jQuery.iResize.sizes.width + dx * side, jQuery.iResize.resizeElement.resizeOptions.minWidth), jQuery.iResize.resizeElement.resizeOptions.maxWidth);
    },
    getHeight: function (dy, side) {
        return Math.min(Math.max(jQuery.iResize.sizes.height + dy * side, jQuery.iResize.resizeElement.resizeOptions.minHeight), jQuery.iResize.resizeElement.resizeOptions.maxHeight);
    },
    getHeightMinMax: function (height) {
        return Math.min(Math.max(height, jQuery.iResize.resizeElement.resizeOptions.minHeight), jQuery.iResize.resizeElement.resizeOptions.maxHeight);
    },
    move: function (e) {
        if (jQuery.iResize.resizeElement == null) {
            return;
        }
        pointer = jQuery.iUtil.getPointer(e);
        dx = pointer.x - jQuery.iResize.pointer.x;
        dy = pointer.y - jQuery.iResize.pointer.y;
        newSizes = {
            width: jQuery.iResize.sizes.width,
            height: jQuery.iResize.sizes.height
        };
        newPosition = {
            top: jQuery.iResize.position.top,
            left: jQuery.iResize.position.left
        };
        switch (jQuery.iResize.resizeDirection) {
        case 'e':
            newSizes.width = jQuery.iResize.getWidth(dx, 1);
            break;
        case 'se':
            newSizes.width = jQuery.iResize.getWidth(dx, 1);
            newSizes.height = jQuery.iResize.getHeight(dy, 1);
            break;
        case 'w':
            newSizes.width = jQuery.iResize.getWidth(dx, -1);
            newPosition.left = jQuery.iResize.position.left - newSizes.width + jQuery.iResize.sizes.width;
            break;
        case 'sw':
            newSizes.width = jQuery.iResize.getWidth(dx, -1);
            newPosition.left = jQuery.iResize.position.left - newSizes.width + jQuery.iResize.sizes.width;
            newSizes.height = jQuery.iResize.getHeight(dy, 1);
            break;
        case 'nw':
            newSizes.height = jQuery.iResize.getHeight(dy, -1);
            newPosition.top = jQuery.iResize.position.top - newSizes.height + jQuery.iResize.sizes.height;
            newSizes.width = jQuery.iResize.getWidth(dx, -1);
            newPosition.left = jQuery.iResize.position.left - newSizes.width + jQuery.iResize.sizes.width;
            break;
        case 'n':
            newSizes.height = jQuery.iResize.getHeight(dy, -1);
            newPosition.top = jQuery.iResize.position.top - newSizes.height + jQuery.iResize.sizes.height;
            break;
        case 'ne':
            newSizes.height = jQuery.iResize.getHeight(dy, -1);
            newPosition.top = jQuery.iResize.position.top - newSizes.height + jQuery.iResize.sizes.height;
            newSizes.width = jQuery.iResize.getWidth(dx, 1);
            break;
        case 's':
            newSizes.height = jQuery.iResize.getHeight(dy, 1);
            break;
        }
        if (jQuery.iResize.resizeElement.resizeOptions.ratio) {
            if (jQuery.iResize.resizeDirection == 'n' || jQuery.iResize.resizeDirection == 's')
                nWidth = newSizes.height * jQuery.iResize.resizeElement.resizeOptions.ratio;
            else
                nWidth = newSizes.width;
            nHeight = jQuery.iResize.getHeightMinMax(nWidth * jQuery.iResize.resizeElement.resizeOptions.ratio);
            nWidth = nHeight / jQuery.iResize.resizeElement.resizeOptions.ratio;
            switch (jQuery.iResize.resizeDirection) {
            case 'n':
            case 'nw':
            case 'ne':
                newPosition.top += newSizes.height - nHeight;
                break;
            }
            switch (jQuery.iResize.resizeDirection) {
            case 'nw':
            case 'w':
            case 'sw':
                newPosition.left += newSizes.width - nWidth;
                break;
            }
            newSizes.height = nHeight;
            newSizes.width = nWidth;
        }
        if (newPosition.top < jQuery.iResize.resizeElement.resizeOptions.minTop) {
            nHeight = newSizes.height + newPosition.top - jQuery.iResize.resizeElement.resizeOptions.minTop;
            newPosition.top = jQuery.iResize.resizeElement.resizeOptions.minTop;
            if (jQuery.iResize.resizeElement.resizeOptions.ratio) {
                nWidth = nHeight / jQuery.iResize.resizeElement.resizeOptions.ratio;
                switch (jQuery.iResize.resizeDirection) {
                case 'nw':
                case 'w':
                case 'sw':
                    newPosition.left += newSizes.width - nWidth;
                    break;
                }
                newSizes.width = nWidth;
            }
            newSizes.height = nHeight;
        }
        if (newPosition.left < jQuery.iResize.resizeElement.resizeOptions.minLeft) {
            nWidth = newSizes.width + newPosition.left - jQuery.iResize.resizeElement.resizeOptions.minLeft;
            newPosition.left = jQuery.iResize.resizeElement.resizeOptions.minLeft;
            if (jQuery.iResize.resizeElement.resizeOptions.ratio) {
                nHeight = nWidth * jQuery.iResize.resizeElement.resizeOptions.ratio;
                switch (jQuery.iResize.resizeDirection) {
                case 'n':
                case 'nw':
                case 'ne':
                    newPosition.top += newSizes.height - nHeight;
                    break;
                }
                newSizes.height = nHeight;
            }
            newSizes.width = nWidth;
        }
        if (newPosition.top + newSizes.height > jQuery.iResize.resizeElement.resizeOptions.maxBottom) {
            newSizes.height = jQuery.iResize.resizeElement.resizeOptions.maxBottom - newPosition.top;
            if (jQuery.iResize.resizeElement.resizeOptions.ratio) {
                newSizes.width = newSizes.height / jQuery.iResize.resizeElement.resizeOptions.ratio;
            }
        }
        if (newPosition.left + newSizes.width > jQuery.iResize.resizeElement.resizeOptions.maxRight) {
            newSizes.width = jQuery.iResize.resizeElement.resizeOptions.maxRight - newPosition.left;
            if (jQuery.iResize.resizeElement.resizeOptions.ratio) {
                newSizes.height = newSizes.width * jQuery.iResize.resizeElement.resizeOptions.ratio;
            }
        }
        var newDimensions = false;
        if (jQuery.iResize.resizeElement.resizeOptions.onResize) {
            newDimensions = jQuery.iResize.resizeElement.resizeOptions.onResize.apply(jQuery.iResize.resizeElement, [newSizes, newPosition]);
            if (newDimensions) {
                if (newDimensions.sizes) {
                    jQuery.extend(newSizes, newDimensions.sizes);
                }
                if (newDimensions.position) {
                    jQuery.extend(newPosition, newDimensions.position);
                }
            }
        }
        elS = jQuery.iResize.resizeElement.style;
        elS.left = newPosition.left + 'px';
        elS.top = newPosition.top + 'px';
        elS.width = newSizes.width + 'px';
        elS.height = newSizes.height + 'px';
        return false;
    },
    build: function (options) {
        if (!options || !options.handlers || options.handlers.constructor != Object) {
            return;
        }
        return this.each(function () {
            var el = this;
            el.resizeOptions = options;
            el.resizeOptions.minWidth = options.minWidth || 10;
            el.resizeOptions.minHeight = options.minHeight || 10;
            el.resizeOptions.maxWidth = options.maxWidth || 3000;
            el.resizeOptions.maxHeight = options.maxHeight || 3000;
            el.resizeOptions.minTop = options.minTop || -1000;
            el.resizeOptions.minLeft = options.minLeft || -1000;
            el.resizeOptions.maxRight = options.maxRight || 3000;
            el.resizeOptions.maxBottom = options.maxBottom || 3000;
            elPosition = jQuery(el).css('position');
            if (!(elPosition == 'relative' || elPosition == 'absolute')) {
                el.style.position = 'relative';
            }
            directions = /n|ne|e|se|s|sw|w|nw/g;
            for (i in el.resizeOptions.handlers) {
                if (i.toLowerCase().match(directions) != null) {
                    if (el.resizeOptions.handlers[i].constructor == String) {
                        handle = jQuery(el.resizeOptions.handlers[i]);
                        if (handle.size() > 0) {
                            el.resizeOptions.handlers[i] = handle.get(0);
                        }
                    }
                    if (el.resizeOptions.handlers[i].tagName) {
                        el.resizeOptions.handlers[i].resizeElement = el;
                        el.resizeOptions.handlers[i].resizeDirection = i;
                        jQuery(el.resizeOptions.handlers[i]).bind('mousedown', jQuery.iResize.start);
                    }
                }
            }
            if (el.resizeOptions.dragHandle) {
                if (typeof el.resizeOptions.dragHandle === 'string') {
                    handleEl = jQuery(el.resizeOptions.dragHandle);
                    if (handleEl.size() > 0) {
                        handleEl.each(function () {
                            this.dragEl = el;
                        });
                        handleEl.bind('mousedown', jQuery.iResize.startDrag);
                    }
                } else if (el.resizeOptions.dragHandle == true) {
                    jQuery(this).bind('mousedown', jQuery.iResize.startDrag);
                }
            }
        });
    },
    destroy: function () {
        return this.each(function () {
            var el = this;
            for (i in el.resizeOptions.handlers) {
                el.resizeOptions.handlers[i].resizeElement = null;
                el.resizeOptions.handlers[i].resizeDirection = null;
                jQuery(el.resizeOptions.handlers[i]).unbind('mousedown', jQuery.iResize.start);
            }
            if (el.resizeOptions.dragHandle) {
                if (typeof el.resizeOptions.dragHandle === 'string') {
                    handle = jQuery(el.resizeOptions.dragHandle);
                    if (handle.size() > 0) {
                        handle.unbind('mousedown', jQuery.iResize.startDrag);
                    }
                } else if (el.resizeOptions.dragHandle == true) {
                    jQuery(this).unbind('mousedown', jQuery.iResize.startDrag);
                }
            }
            el.resizeOptions = null;
        });
    }
};
jQuery.fn.extend({
    Resizable: jQuery.iResize.build,
    ResizableDestroy: jQuery.iResize.destroy
});
jQuery.fn.extend({
    Grow: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.Scale(this, speed, 1, 100, true, callback, 'grow', easing);
        });
    },
    Shrink: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.Scale(this, speed, 100, 1, true, callback, 'shrink', easing);
        });
    },
    Puff: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            var easing = easing || 'easeout';
            new jQuery.fx.Scale(this, speed, 100, 150, true, callback, 'puff', easing);
        });
    },
    Scale: function (speed, from, to, restore, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.Scale(this, speed, from, to, restore, callback, 'Scale', easing);
        });
    }
});
jQuery.fx.Scale = function (e, speed, from, to, restore, callback, type, easing) {
    if (!jQuery.fxCheckTag(e)) {
        jQuery.dequeue(e, 'interfaceFX');
        return false;
    }
    var z = this;
    z.el = jQuery(e);
    z.from = parseInt(from) || 100;
    z.to = parseInt(to) || 100;
    z.easing = typeof callback == 'string' ? callback : easing || null;
    z.callback = typeof callback == 'function' ? callback : null;
    z.duration = jQuery.speed(speed).duration;
    z.restore = restore || null;
    z.oldP = jQuery.iUtil.getSize(e);
    z.oldStyle = {
        width: z.el.css('width'),
        height: z.el.css('height'),
        fontSize: z.el.css('fontSize') || '100%',
        position: z.el.css('position'),
        display: z.el.css('display'),
        top: z.el.css('top'),
        left: z.el.css('left'),
        overflow: z.el.css('overflow'),
        borderTopWidth: z.el.css('borderTopWidth'),
        borderRightWidth: z.el.css('borderRightWidth'),
        borderBottomWidth: z.el.css('borderBottomWidth'),
        borderLeftWidth: z.el.css('borderLeftWidth'),
        paddingTop: z.el.css('paddingTop'),
        paddingRight: z.el.css('paddingRight'),
        paddingBottom: z.el.css('paddingBottom'),
        paddingLeft: z.el.css('paddingLeft')
    };
    z.width = parseInt(z.oldStyle.width) || e.offsetWidth || 0;
    z.height = parseInt(z.oldStyle.height) || e.offsetHeight || 0;
    z.top = parseInt(z.oldStyle.top) || 0;
    z.left = parseInt(z.oldStyle.left) || 0;
    sizes = ['em', 'px', 'pt', '%'];
    for (i in sizes) {
        if (z.oldStyle.fontSize.indexOf(sizes[i]) > 0) {
            z.fontUnit = sizes[i];
            z.fontSize = parseFloat(z.oldStyle.fontSize);
        }
        if (z.oldStyle.borderTopWidth.indexOf(sizes[i]) > 0) {
            z.borderTopUnit = sizes[i];
            z.borderTopSize = parseFloat(z.oldStyle.borderTopWidth) || 0;
        }
        if (z.oldStyle.borderRightWidth.indexOf(sizes[i]) > 0) {
            z.borderRightUnit = sizes[i];
            z.borderRightSize = parseFloat(z.oldStyle.borderRightWidth) || 0;
        }
        if (z.oldStyle.borderBottomWidth.indexOf(sizes[i]) > 0) {
            z.borderBottomUnit = sizes[i];
            z.borderBottomSize = parseFloat(z.oldStyle.borderBottomWidth) || 0;
        }
        if (z.oldStyle.borderLeftWidth.indexOf(sizes[i]) > 0) {
            z.borderLeftUnit = sizes[i];
            z.borderLeftSize = parseFloat(z.oldStyle.borderLeftWidth) || 0;
        }
        if (z.oldStyle.paddingTop.indexOf(sizes[i]) > 0) {
            z.paddingTopUnit = sizes[i];
            z.paddingTopSize = parseFloat(z.oldStyle.paddingTop) || 0;
        }
        if (z.oldStyle.paddingRight.indexOf(sizes[i]) > 0) {
            z.paddingRightUnit = sizes[i];
            z.paddingRightSize = parseFloat(z.oldStyle.paddingRight) || 0;
        }
        if (z.oldStyle.paddingBottom.indexOf(sizes[i]) > 0) {
            z.paddingBottomUnit = sizes[i];
            z.paddingBottomSize = parseFloat(z.oldStyle.paddingBottom) || 0;
        }
        if (z.oldStyle.paddingLeft.indexOf(sizes[i]) > 0) {
            z.paddingLeftUnit = sizes[i];
            z.paddingLeftSize = parseFloat(z.oldStyle.paddingLeft) || 0;
        }
    }
    if (z.oldStyle.position != 'relative' && z.oldStyle.position != 'absolute') {
        z.el.css('position', 'relative');
    }
    z.el.css('overflow', 'hidden');
    z.type = type;
    switch (z.type) {
    case 'grow':
        z.startTop = z.top + z.oldP.h / 2;
        z.endTop = z.top;
        z.startLeft = z.left + z.oldP.w / 2;
        z.endLeft = z.left;
        break;
    case 'shrink':
        z.endTop = z.top + z.oldP.h / 2;
        z.startTop = z.top;
        z.endLeft = z.left + z.oldP.w / 2;
        z.startLeft = z.left;
        break;
    case 'puff':
        z.endTop = z.top - z.oldP.h / 4;
        z.startTop = z.top;
        z.endLeft = z.left - z.oldP.w / 4;
        z.startLeft = z.left;
        break;
    }
    z.firstStep = false;
    z.t = (new Date).getTime();
    z.clear = function () {
        clearInterval(z.timer);
        z.timer = null;
    };
    z.step = function () {
        if (z.firstStep == false) {
            z.el.show();
            z.firstStep = true;
        }
        var t = (new Date).getTime();
        var n = t - z.t;
        var p = n / z.duration;
        if (t >= z.duration + z.t) {
            setTimeout(function () {
                o = 1;
                if (z.type) {
                    t = z.endTop;
                    l = z.endLeft;
                    if (z.type == 'puff')
                        o = 0;
                }
                z.zoom(z.to, l, t, true, o);
            }, 13);
            z.clear();
        } else {
            o = 1;
            if (!jQuery.easing || !jQuery.easing[z.easing]) {
                s = ((-Math.cos(p * Math.PI) / 2) + 0.5) * (z.to - z.from) + z.from;
            } else {
                s = jQuery.easing[z.easing](p, n, z.from, (z.to - z.from), z.duration);
            }
            if (z.type) {
                if (!jQuery.easing || !jQuery.easing[z.easing]) {
                    t = ((-Math.cos(p * Math.PI) / 2) + 0.5) * (z.endTop - z.startTop) + z.startTop;
                    l = ((-Math.cos(p * Math.PI) / 2) + 0.5) * (z.endLeft - z.startLeft) + z.startLeft;
                    if (z.type == 'puff')
                        o = ((-Math.cos(p * Math.PI) / 2) + 0.5) * (-0.9999) + 0.9999;
                } else {
                    t = jQuery.easing[z.easing](p, n, z.startTop, (z.endTop - z.startTop), z.duration);
                    l = jQuery.easing[z.easing](p, n, z.startLeft, (z.endLeft - z.startLeft), z.duration);
                    if (z.type == 'puff')
                        o = jQuery.easing[z.easing](p, n, 0.9999, -0.9999, z.duration);
                }
            }
            z.zoom(s, l, t, false, o);
        }
    };
    z.timer = setInterval(function () {
        z.step();
    }, 13);
    z.zoom = function (percent, left, top, finish, opacity) {
        z.el.css('height', z.height * percent / 100 + 'px').css('width', z.width * percent / 100 + 'px').css('left', left + 'px').css('top', top + 'px').css('fontSize', z.fontSize * percent / 100 + z.fontUnit);
        if (z.borderTopSize)
            z.el.css('borderTopWidth', z.borderTopSize * percent / 100 + z.borderTopUnit);
        if (z.borderRightSize)
            z.el.css('borderRightWidth', z.borderRightSize * percent / 100 + z.borderRightUnit);
        if (z.borderBottomSize)
            z.el.css('borderBottomWidth', z.borderBottomSize * percent / 100 + z.borderBottomUnit);
        if (z.borderLeftSize)
            z.el.css('borderLeftWidth', z.borderLeftSize * percent / 100 + z.borderLeftUnit);
        if (z.paddingTopSize)
            z.el.css('paddingTop', z.paddingTopSize * percent / 100 + z.paddingTopUnit);
        if (z.paddingRightSize)
            z.el.css('paddingRight', z.paddingRightSize * percent / 100 + z.paddingRightUnit);
        if (z.paddingBottomSize)
            z.el.css('paddingBottom', z.paddingBottomSize * percent / 100 + z.paddingBottomUnit);
        if (z.paddingLeftSize)
            z.el.css('paddingLeft', z.paddingLeftSize * percent / 100 + z.paddingLeftUnit);
        if (z.type == 'puff') {
            if (window.ActiveXObject)
                z.el.get(0).style.filter = "alpha(opacity=" + opacity * 100 + ")";
            z.el.get(0).style.opacity = opacity;
        }
        if (finish) {
            if (z.restore) {
                z.el.css(z.oldStyle);
            }
            if (z.type == 'shrink' || z.type == 'puff') {
                z.el.css('display', 'none');
                if (z.type == 'puff') {
                    if (window.ActiveXObject)
                        z.el.get(0).style.filter = "alpha(opacity=" + 100 + ")";
                    z.el.get(0).style.opacity = 1;
                }
            } else
                z.el.css('display', 'block'); if (z.callback)
                z.callback.apply(z.el.get(0));
            jQuery.dequeue(z.el.get(0), 'interfaceFX');
        }
    };
};
jQuery.iCarousel = {
    build: function (options) {
        return this.each(function () {
            var el = this;
            var increment = 2 * Math.PI / 360;
            var maxRotation = 2 * Math.PI;
            if (jQuery(el).css('position') != 'relative' && jQuery(el).css('position') != 'absolute') {
                jQuery(el).css('position', 'relative');
            }
            el.carouselCfg = {
                items: jQuery(options.items, this),
                itemWidth: options.itemWidth,
                itemHeight: options.itemHeight,
                itemMinWidth: options.itemMinWidth,
                maxRotation: maxRotation,
                size: jQuery.iUtil.getSize(this),
                position: jQuery.iUtil.getPosition(this),
                start: Math.PI / 2,
                rotationSpeed: options.rotationSpeed,
                reflectionSize: options.reflections,
                reflections: [],
                protectRotation: false,
                increment: 2 * Math.PI / 360
            };
            el.carouselCfg.radiusX = (el.carouselCfg.size.w - el.carouselCfg.itemWidth) / 2;
            el.carouselCfg.radiusY = (el.carouselCfg.size.h - el.carouselCfg.itemHeight - el.carouselCfg.itemHeight * el.carouselCfg.reflectionSize) / 2;
            el.carouselCfg.step = 2 * Math.PI / el.carouselCfg.items.size();
            el.carouselCfg.paddingX = el.carouselCfg.size.w / 2;
            el.carouselCfg.paddingY = el.carouselCfg.size.h / 2 - el.carouselCfg.itemHeight * el.carouselCfg.reflectionSize;
            var reflexions = document.createElement('div');
            jQuery(reflexions).css({
                position: 'absolute',
                zIndex: 1,
                top: 0,
                left: 0
            });
            jQuery(el).append(reflexions);
            el.carouselCfg.items.each(function (nr) {
                image = jQuery('img', this).get(0);
                height = parseInt(el.carouselCfg.itemHeight * el.carouselCfg.reflectionSize);
                if (jQuery.browser.msie) {
                    canvas = document.createElement('img');
                    jQuery(canvas).css('position', 'absolute');
                    canvas.src = image.src;
                    canvas.style.filter = 'flipv progid:DXImageTransform.Microsoft.Alpha(opacity=60, style=1, finishOpacity=0, startx=0, starty=0, finishx=0)';
                } else {
                    canvas = document.createElement('canvas');
                    if (canvas.getContext) {
                        context = canvas.getContext("2d");
                        canvas.style.position = 'absolute';
                        canvas.style.height = height + 'px';
                        canvas.style.width = el.carouselCfg.itemWidth + 'px';
                        canvas.height = height;
                        canvas.width = el.carouselCfg.itemWidth;
                        context.save();
                        context.translate(0, height);
                        context.scale(1, -1);
                        context.drawImage(image, 0, 0, el.carouselCfg.itemWidth, height);
                        context.restore();
                        context.globalCompositeOperation = "destination-out";
                        var gradient = context.createLinearGradient(0, 0, 0, height);
                        gradient.addColorStop(1, "rgba(255, 255, 255, 1)");
                        gradient.addColorStop(0, "rgba(255, 255, 255, 0.6)");
                        context.fillStyle = gradient;
                        if (navigator.appVersion.indexOf('WebKit') != -1) {
                            context.fill();
                        } else {
                            context.fillRect(0, 0, el.carouselCfg.itemWidth, height);
                        }
                    }
                }
                el.carouselCfg.reflections[nr] = canvas;
                jQuery(reflexions).append(canvas);
            }).bind('mouseover', function (e) {
                el.carouselCfg.protectRotation = true;
                el.carouselCfg.speed = el.carouselCfg.increment * 0.1 * el.carouselCfg.speed / Math.abs(el.carouselCfg.speed);
                return false;
            }).bind('mouseout', function (e) {
                el.carouselCfg.protectRotation = false;
                return false;
            });
            jQuery.iCarousel.positionItems(el);
            el.carouselCfg.speed = el.carouselCfg.increment * 0.2;
            el.carouselCfg.rotationTimer = window.setInterval(function () {
                el.carouselCfg.start += el.carouselCfg.speed;
                if (el.carouselCfg.start > maxRotation)
                    el.carouselCfg.start = 0;
                jQuery.iCarousel.positionItems(el);
            }, 20);
            jQuery(el).bind('mouseout', function () {
                el.carouselCfg.speed = el.carouselCfg.increment * 0.2 * el.carouselCfg.speed / Math.abs(el.carouselCfg.speed);
            }).bind('mousemove', function (e) {
                if (el.carouselCfg.protectRotation == false) {
                    pointer = jQuery.iUtil.getPointer(e);
                    mousex = el.carouselCfg.size.w - pointer.x + el.carouselCfg.position.x;
                    el.carouselCfg.speed = el.carouselCfg.rotationSpeed * el.carouselCfg.increment * (el.carouselCfg.size.w / 2 - mousex) / (el.carouselCfg.size.w / 2);
                }
            });
        });
    },
    positionItems: function (el) {
        el.carouselCfg.items.each(function (nr) {
            angle = el.carouselCfg.start + nr * el.carouselCfg.step;
            x = el.carouselCfg.radiusX * Math.cos(angle);
            y = el.carouselCfg.radiusY * Math.sin(angle);
            itemZIndex = parseInt(100 * (el.carouselCfg.radiusY + y) / (2 * el.carouselCfg.radiusY));
            parte = (el.carouselCfg.radiusY + y) / (2 * el.carouselCfg.radiusY);
            width = parseInt((el.carouselCfg.itemWidth - el.carouselCfg.itemMinWidth) * parte + el.carouselCfg.itemMinWidth);
            height = parseInt(width * el.carouselCfg.itemHeight / el.carouselCfg.itemWidth);
            this.style.top = el.carouselCfg.paddingY + y - height / 2 + "px";
            this.style.left = el.carouselCfg.paddingX + x - width / 2 + "px";
            this.style.width = width + "px";
            this.style.height = height + "px";
            this.style.zIndex = itemZIndex;
            el.carouselCfg.reflections[nr].style.top = parseInt(el.carouselCfg.paddingY + y + height - 1 - height / 2) + "px";
            el.carouselCfg.reflections[nr].style.left = parseInt(el.carouselCfg.paddingX + x - width / 2) + "px";
            el.carouselCfg.reflections[nr].style.width = width + "px";
            el.carouselCfg.reflections[nr].style.height = parseInt(height * el.carouselCfg.reflectionSize) + "px";
        });
    }
};
jQuery.fn.Carousel = jQuery.iCarousel.build;
jQuery.fn.extend({
    BlindUp: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.BlindDirection(this, speed, callback, 'up', easing);
        });
    },
    BlindDown: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.BlindDirection(this, speed, callback, 'down', easing);
        });
    },
    BlindToggleVertically: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.BlindDirection(this, speed, callback, 'togglever', easing);
        });
    },
    BlindLeft: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.BlindDirection(this, speed, callback, 'left', easing);
        });
    },
    BlindRight: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.BlindDirection(this, speed, callback, 'right', easing);
        });
    },
    BlindToggleHorizontally: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.BlindDirection(this, speed, callback, 'togglehor', easing);
        });
    }
});
jQuery.fx.BlindDirection = function (e, speed, callback, direction, easing) {
    if (!jQuery.fxCheckTag(e)) {
        jQuery.dequeue(e, 'interfaceFX');
        return false;
    }
    var z = this;
    z.el = jQuery(e);
    z.size = jQuery.iUtil.getSize(e);
    z.easing = typeof callback == 'string' ? callback : easing || null;
    if (!e.ifxFirstDisplay)
        e.ifxFirstDisplay = z.el.css('display');
    if (direction == 'togglever') {
        direction = z.el.css('display') == 'none' ? 'down' : 'up';
    } else if (direction == 'togglehor') {
        direction = z.el.css('display') == 'none' ? 'right' : 'left';
    }
    z.el.show();
    z.speed = speed;
    z.callback = typeof callback == 'function' ? callback : null;
    z.fx = jQuery.fx.buildWrapper(e);
    z.direction = direction;
    z.complete = function () {
        if (z.callback && z.callback.constructor == Function) {
            z.callback.apply(z.el.get(0));
        }
        if (z.direction == 'down' || z.direction == 'right') {
            z.el.css('display', z.el.get(0).ifxFirstDisplay == 'none' ? 'block' : z.el.get(0).ifxFirstDisplay);
        } else {
            z.el.hide();
        }
        jQuery.fx.destroyWrapper(z.fx.wrapper.get(0), z.fx.oldStyle);
        jQuery.dequeue(z.el.get(0), 'interfaceFX');
    };
    switch (z.direction) {
    case 'up':
        fxh = new jQuery.fx(z.fx.wrapper.get(0), jQuery.speed(z.speed, z.easing, z.complete), 'height');
        fxh.custom(z.fx.oldStyle.sizes.hb, 0);
        break;
    case 'down':
        z.fx.wrapper.css('height', '1px');
        z.el.show();
        fxh = new jQuery.fx(z.fx.wrapper.get(0), jQuery.speed(z.speed, z.easing, z.complete), 'height');
        fxh.custom(0, z.fx.oldStyle.sizes.hb);
        break;
    case 'left':
        fxh = new jQuery.fx(z.fx.wrapper.get(0), jQuery.speed(z.speed, z.easing, z.complete), 'width');
        fxh.custom(z.fx.oldStyle.sizes.wb, 0);
        break;
    case 'right':
        z.fx.wrapper.css('width', '1px');
        z.el.show();
        fxh = new jQuery.fx(z.fx.wrapper.get(0), jQuery.speed(z.speed, z.easing, z.complete), 'width');
        fxh.custom(0, z.fx.oldStyle.sizes.wb);
        break;
    }
};
jQuery.iUtil = {
    getPosition: function (e) {
        var x = 0;
        var y = 0;
        var es = e.style;
        var restoreStyles = false;
        if (jQuery(e).css('display') == 'none') {
            var oldVisibility = es.visibility;
            var oldPosition = es.position;
            restoreStyles = true;
            es.visibility = 'hidden';
            es.display = 'block';
            es.position = 'absolute';
        }
        var el = e;
        while (el) {
            x += el.offsetLeft + (el.currentStyle && !jQuery.browser.opera ? parseInt(el.currentStyle.borderLeftWidth) || 0 : 0);
            y += el.offsetTop + (el.currentStyle && !jQuery.browser.opera ? parseInt(el.currentStyle.borderTopWidth) || 0 : 0);
            el = el.offsetParent;
        }
        el = e;
        while (el && el.tagName && el.tagName.toLowerCase() != 'body') {
            x -= el.scrollLeft || 0;
            y -= el.scrollTop || 0;
            el = el.parentNode;
        }
        if (restoreStyles == true) {
            es.display = 'none';
            es.position = oldPosition;
            es.visibility = oldVisibility;
        }
        return {
            x: x,
            y: y
        };
    },
    getPositionLite: function (el) {
        var x = 0,
            y = 0;
        while (el) {
            x += el.offsetLeft || 0;
            y += el.offsetTop || 0;
            el = el.offsetParent;
        }
        return {
            x: x,
            y: y
        };
    },
    getSize: function (e) {
        var w = jQuery.css(e, 'width');
        var h = jQuery.css(e, 'height');
        var wb = 0;
        var hb = 0;
        var es = e.style;
        if (jQuery(e).css('display') != 'none') {
            wb = e.offsetWidth;
            hb = e.offsetHeight;
        } else {
            var oldVisibility = es.visibility;
            var oldPosition = es.position;
            es.visibility = 'hidden';
            es.display = 'block';
            es.position = 'absolute';
            wb = e.offsetWidth;
            hb = e.offsetHeight;
            es.display = 'none';
            es.position = oldPosition;
            es.visibility = oldVisibility;
        }
        return {
            w: w,
            h: h,
            wb: wb,
            hb: hb
        };
    },
    getSizeLite: function (el) {
        return {
            wb: el.offsetWidth || 0,
            hb: el.offsetHeight || 0
        };
    },
    getClient: function (e) {
        var h, w, de;
        if (e) {
            w = e.clientWidth;
            h = e.clientHeight;
        } else {
            de = document.documentElement;
            w = window.innerWidth || self.innerWidth || (de && de.clientWidth) || document.body.clientWidth;
            h = window.innerHeight || self.innerHeight || (de && de.clientHeight) || document.body.clientHeight;
        }
        return {
            w: w,
            h: h
        };
    },
    getScroll: function (e) {
        var t = 0,
            l = 0,
            w = 0,
            h = 0,
            iw = 0,
            ih = 0;
        if (e && e.nodeName.toLowerCase() != 'body') {
            t = e.scrollTop;
            l = e.scrollLeft;
            w = e.scrollWidth;
            h = e.scrollHeight;
            iw = 0;
            ih = 0;
        } else {
            if (document.documentElement) {
                t = document.documentElement.scrollTop;
                l = document.documentElement.scrollLeft;
                w = document.documentElement.scrollWidth;
                h = document.documentElement.scrollHeight;
            } else if (document.body) {
                t = document.body.scrollTop;
                l = document.body.scrollLeft;
                w = document.body.scrollWidth;
                h = document.body.scrollHeight;
            }
            iw = self.innerWidth || document.documentElement.clientWidth || document.body.clientWidth || 0;
            ih = self.innerHeight || document.documentElement.clientHeight || document.body.clientHeight || 0;
        }
        return {
            t: t,
            l: l,
            w: w,
            h: h,
            iw: iw,
            ih: ih
        };
    },
    getMargins: function (e, toInteger) {
        var el = jQuery(e);
        var t = el.css('marginTop') || '';
        var r = el.css('marginRight') || '';
        var b = el.css('marginBottom') || '';
        var l = el.css('marginLeft') || '';
        if (toInteger)
            return {
                t: parseInt(t) || 0,
                r: parseInt(r) || 0,
                b: parseInt(b) || 0,
                l: parseInt(l)
            };
        else
            return {
                t: t,
                r: r,
                b: b,
                l: l
            };
    },
    getPadding: function (e, toInteger) {
        var el = jQuery(e);
        var t = el.css('paddingTop') || '';
        var r = el.css('paddingRight') || '';
        var b = el.css('paddingBottom') || '';
        var l = el.css('paddingLeft') || '';
        if (toInteger)
            return {
                t: parseInt(t) || 0,
                r: parseInt(r) || 0,
                b: parseInt(b) || 0,
                l: parseInt(l)
            };
        else
            return {
                t: t,
                r: r,
                b: b,
                l: l
            };
    },
    getBorder: function (e, toInteger) {
        var el = jQuery(e);
        var t = el.css('borderTopWidth') || '';
        var r = el.css('borderRightWidth') || '';
        var b = el.css('borderBottomWidth') || '';
        var l = el.css('borderLeftWidth') || '';
        if (toInteger)
            return {
                t: parseInt(t) || 0,
                r: parseInt(r) || 0,
                b: parseInt(b) || 0,
                l: parseInt(l) || 0
            };
        else
            return {
                t: t,
                r: r,
                b: b,
                l: l
            };
    },
    getPointer: function (event) {
        var x = event.pageX || (event.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft)) || 0;
        var y = event.pageY || (event.clientY + (document.documentElement.scrollTop || document.body.scrollTop)) || 0;
        return {
            x: x,
            y: y
        };
    },
    traverseDOM: function (nodeEl, func) {
        func(nodeEl);
        nodeEl = nodeEl.firstChild;
        while (nodeEl) {
            jQuery.iUtil.traverseDOM(nodeEl, func);
            nodeEl = nodeEl.nextSibling;
        }
    },
    purgeEvents: function (nodeEl) {
        jQuery.iUtil.traverseDOM(nodeEl, function (el) {
            for (var attr in el) {
                if (typeof el[attr] === 'function') {
                    el[attr] = null;
                }
            }
        });
    },
    centerEl: function (el, axis) {
        var clientScroll = jQuery.iUtil.getScroll();
        var windowSize = jQuery.iUtil.getSize(el);
        if (!axis || axis == 'vertically')
            jQuery(el).css({
                top: clientScroll.t + ((Math.max(clientScroll.h, clientScroll.ih) - clientScroll.t - windowSize.hb) / 2) + 'px'
            });
        if (!axis || axis == 'horizontally')
            jQuery(el).css({
                left: clientScroll.l + ((Math.max(clientScroll.w, clientScroll.iw) - clientScroll.l - windowSize.wb) / 2) + 'px'
            });
    },
    fixPNG: function (el, emptyGIF) {
        var images = jQuery('img[@src*="png"]', el || document),
            png;
        images.each(function () {
            png = this.src;
            this.src = emptyGIF;
            this.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + png + "')";
        });
    }
};
[].indexOf || (Array.prototype.indexOf = function (v, n) {
    n = (n == null) ? 0 : n;
    var m = this.length;
    for (var i = n; i < m; i++)
        if (this[i] == v)
            return i;
    return -1;
});
jQuery.extend({
    easing: {
        linear: function (p, n, firstNum, delta, duration) {
            return ((-Math.cos(p * Math.PI) / 2) + 0.5) * delta + firstNum;
        },
        easein: function (p, n, firstNum, delta, duration) {
            return delta * (n /= duration) * n * n + firstNum;
        },
        easeout: function (p, n, firstNum, delta, duration) {
            return -delta * ((n = n / duration - 1) * n * n * n - 1) + firstNum;
        },
        easeboth: function (p, n, firstNum, delta, duration) {
            if ((n /= duration / 2) < 1)
                return delta / 2 * n * n * n * n + firstNum;
            return -delta / 2 * ((n -= 2) * n * n * n - 2) + firstNum;
        },
        bounceout: function (p, n, firstNum, delta, duration) {
            if ((n /= duration) < (1 / 2.75)) {
                return delta * (7.5625 * n * n) + firstNum;
            } else if (n < (2 / 2.75)) {
                return delta * (7.5625 * (n -= (1.5 / 2.75)) * n + .75) + firstNum;
            } else if (n < (2.5 / 2.75)) {
                return delta * (7.5625 * (n -= (2.25 / 2.75)) * n + .9375) + firstNum;
            } else {
                return delta * (7.5625 * (n -= (2.625 / 2.75)) * n + .984375) + firstNum;
            }
        },
        bouncein: function (p, n, firstNum, delta, duration) {
            if (jQuery.easing.bounceout)
                return delta - jQuery.easing.bounceout(p, duration - n, 0, delta, duration) + firstNum;
            return firstNum + delta;
        },
        bounceboth: function (p, n, firstNum, delta, duration) {
            if (jQuery.easing.bouncein && jQuery.easing.bounceout)
                if (n < duration / 2)
                    return jQuery.easing.bouncein(p, n * 2, 0, delta, duration) * .5 + firstNum;
            return jQuery.easing.bounceout(p, n * 2 - duration, 0, delta, duration) * .5 + delta * .5 + firstNum;
        },
        elasticin: function (p, n, firstNum, delta, duration) {
            var a, s;
            if (n == 0)
                return firstNum;
            if ((n /= duration) == 1)
                return firstNum + delta;
            a = delta * 0.3;
            p = duration * .3;
            if (a < Math.abs(delta)) {
                a = delta;
                s = p / 4;
            } else {
                s = p / (2 * Math.PI) * Math.asin(delta / a);
            }
            return -(a * Math.pow(2, 10 * (n -= 1)) * Math.sin((n * duration - s) * (2 * Math.PI) / p)) + firstNum;
        },
        elasticout: function (p, n, firstNum, delta, duration) {
            var a, s;
            if (n == 0)
                return firstNum;
            if ((n /= duration / 2) == 2)
                return firstNum + delta;
            a = delta * 0.3;
            p = duration * .3;
            if (a < Math.abs(delta)) {
                a = delta;
                s = p / 4;
            } else {
                s = p / (2 * Math.PI) * Math.asin(delta / a);
            }
            return a * Math.pow(2, -10 * n) * Math.sin((n * duration - s) * (2 * Math.PI) / p) + delta + firstNum;
        },
        elasticboth: function (p, n, firstNum, delta, duration) {
            var a, s;
            if (n == 0)
                return firstNum;
            if ((n /= duration / 2) == 2)
                return firstNum + delta;
            a = delta * 0.3;
            p = duration * .3;
            if (a < Math.abs(delta)) {
                a = delta;
                s = p / 4;
            } else {
                s = p / (2 * Math.PI) * Math.asin(delta / a);
            }
            if (n < 1) {
                return -.5 * (a * Math.pow(2, 10 * (n -= 1)) * Math.sin((n * duration - s) * (2 * Math.PI) / p)) + firstNum;
            }
            return a * Math.pow(2, -10 * (n -= 1)) * Math.sin((n * duration - s) * (2 * Math.PI) / p) * .5 + delta + firstNum;
        }
    }
});
jQuery.iTTabs = {
    doTab: function (e) {
        pressedKey = e.charCode || e.keyCode || -1;
        if (pressedKey == 9) {
            if (window.event) {
                window.event.cancelBubble = true;
                window.event.returnValue = false;
            } else {
                e.preventDefault();
                e.stopPropagation();
            }
            if (this.createTextRange) {
                document.selection.createRange().text = "\t";
                this.onblur = function () {
                    this.focus();
                    this.onblur = null;
                };
            } else if (this.setSelectionRange) {
                start = this.selectionStart;
                end = this.selectionEnd;
                this.value = this.value.substring(0, start) + "\t" + this.value.substr(end);
                this.setSelectionRange(start + 1, start + 1);
                this.focus();
            }
            return false;
        }
    },
    destroy: function () {
        return this.each(function () {
            if (this.hasTabsEnabled && this.hasTabsEnabled == true) {
                jQuery(this).unbind('keydown', jQuery.iTTabs.doTab);
                this.hasTabsEnabled = false;
            }
        });
    },
    build: function () {
        return this.each(function () {
            if (this.tagName == 'TEXTAREA' && (!this.hasTabsEnabled || this.hasTabsEnabled == false)) {
                jQuery(this).bind('keydown', jQuery.iTTabs.doTab);
                this.hasTabsEnabled = true;
            }
        });
    }
};
jQuery.fn.extend({
    EnableTabs: jQuery.iTTabs.build,
    DisableTabs: jQuery.iTTabs.destroy
});
jQuery.fn.extend({
    ScrollTo: function (speed, axis, easing) {
        o = jQuery.speed(speed);
        return this.queue('interfaceFX', function () {
            new jQuery.fx.ScrollTo(this, o, axis, easing);
        });
    },
    ScrollToAnchors: function (speed, axis, easing) {
        return this.each(function () {
            jQuery('a[@href*="#"]', this).click(function (e) {
                parts = this.href.split('#');
                jQuery('#' + parts[1]).ScrollTo(speed, axis, easing);
                return false;
            });
        })
    }
});
jQuery.fx.ScrollTo = function (e, o, axis, easing) {
    var z = this;
    z.o = o;
    z.e = e;
    z.axis = /vertical|horizontal/.test(axis) ? axis : false;
    z.easing = easing;
    p = jQuery.iUtil.getPosition(e);
    s = jQuery.iUtil.getScroll();
    z.clear = function () {
        clearInterval(z.timer);
        z.timer = null;
        jQuery.dequeue(z.e, 'interfaceFX');
    };
    z.t = (new Date).getTime();
    s.h = s.h > s.ih ? (s.h - s.ih) : s.h;
    s.w = s.w > s.iw ? (s.w - s.iw) : s.w;
    z.endTop = p.y > s.h ? s.h : p.y;
    z.endLeft = p.x > s.w ? s.w : p.x;
    z.startTop = s.t;
    z.startLeft = s.l;
    z.step = function () {
        var t = (new Date).getTime();
        var n = t - z.t;
        var p = n / z.o.duration;
        if (t >= z.o.duration + z.t) {
            z.clear();
            setTimeout(function () {
                z.scroll(z.endTop, z.endLeft)
            }, 13);
        } else {
            if (!z.axis || z.axis == 'vertical') {
                if (!jQuery.easing || !jQuery.easing[z.easing]) {
                    st = ((-Math.cos(p * Math.PI) / 2) + 0.5) * (z.endTop - z.startTop) + z.startTop;
                } else {
                    st = jQuery.easing[z.easing](p, n, z.startTop, (z.endTop - z.startTop), z.o.duration);
                }
            } else {
                st = z.startTop;
            }
            if (!z.axis || z.axis == 'horizontal') {
                if (!jQuery.easing || !jQuery.easing[z.easing]) {
                    sl = ((-Math.cos(p * Math.PI) / 2) + 0.5) * (z.endLeft - z.startLeft) + z.startLeft;
                } else {
                    sl = jQuery.easing[z.easing](p, n, z.startLeft, (z.endLeft - z.startLeft), z.o.duration);
                }
            } else {
                sl = z.startLeft;
            }
            z.scroll(st, sl);
        }
    };
    z.scroll = function (t, l) {
        window.scrollTo(l, t);
    };
    z.timer = setInterval(function () {
        z.step();
    }, 13);
};
jQuery.iExpander = {
    helper: null,
    expand: function () {
        text = this.value;
        if (!text)
            return;
        style = {
            fontFamily: jQuery(this).css('fontFamily') || '',
            fontSize: jQuery(this).css('fontSize') || '',
            fontWeight: jQuery(this).css('fontWeight') || '',
            fontStyle: jQuery(this).css('fontStyle') || '',
            fontStretch: jQuery(this).css('fontStretch') || '',
            fontVariant: jQuery(this).css('fontVariant') || '',
            letterSpacing: jQuery(this).css('letterSpacing') || '',
            wordSpacing: jQuery(this).css('wordSpacing') || ''
        };
        jQuery.iExpander.helper.css(style);
        html = jQuery.iExpander.htmlEntities(text);
        html = html.replace(new RegExp("\\n", "g"), "<br />");
        jQuery.iExpander.helper.html('pW');
        spacer = jQuery.iExpander.helper.get(0).offsetWidth;
        jQuery.iExpander.helper.html(html);
        width = jQuery.iExpander.helper.get(0).offsetWidth + spacer;
        if (this.Expander.limit && width > this.Expander.limit[0]) {
            width = this.Expander.limit[0];
        }
        this.style.width = width + 'px';
        if (this.tagName == 'TEXTAREA') {
            height = jQuery.iExpander.helper.get(0).offsetHeight + spacer;
            if (this.Expander.limit && height > this.Expander.limit[1]) {
                height = this.Expander.limit[1];
            }
            this.style.height = height + 'px';
        }
    },
    htmlEntities: function (text) {
        entities = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;'
        };
        for (i in entities) {
            text = text.replace(new RegExp(i, 'g'), entities[i]);
        }
        return text;
    },
    build: function (limit) {
        if (jQuery.iExpander.helper == null) {
            jQuery('body', document).append('<div id="expanderHelper" style="position: absolute; top: 0; left: 0; visibility: hidden;"></div>');
            jQuery.iExpander.helper = jQuery('#expanderHelper');
        }
        return this.each(function () {
            if (/TEXTAREA|INPUT/.test(this.tagName)) {
                if (this.tagName == 'INPUT') {
                    elType = this.getAttribute('type');
                    if (!/text|password/.test(elType)) {
                        return;
                    }
                }
                if (limit && (limit.constructor == Number || (limit.constructor == Array && limit.length == 2))) {
                    if (limit.constructor == Number)
                        limit = [limit, limit];
                    else {
                        limit[0] = parseInt(limit[0]) || 400;
                        limit[1] = parseInt(limit[1]) || 400;
                    }
                    this.Expander = {
                        limit: limit
                    };
                }
                jQuery(this).blur(jQuery.iExpander.expand).keyup(jQuery.iExpander.expand).keypress(jQuery.iExpander.expand);
                jQuery.iExpander.expand.apply(this);
            }
        });
    }
};
jQuery.fn.Autoexpand = jQuery.iExpander.build;
jQuery.fn.Shake = function (times, callback) {
    return this.queue('interfaceFX', function () {
        if (!jQuery.fxCheckTag(this)) {
            jQuery.dequeue(this, 'interfaceFX');
            return false;
        }
        var e = new jQuery.fx.Shake(this, times, callback);
        e.shake();
    });
};
jQuery.fx.Shake = function (e, times, callback) {
    var z = this;
    z.el = jQuery(e);
    z.el.show();
    z.times = parseInt(times) || 3;
    z.callback = callback;
    z.cnt = 1;
    z.oldStyle = {};
    z.oldStyle.position = z.el.css('position');
    z.oldStyle.top = parseInt(z.el.css('top')) || 0;
    z.oldStyle.left = parseInt(z.el.css('left')) || 0;
    if (z.oldStyle.position != 'relative' && z.oldStyle.position != 'absolute') {
        z.el.css('position', 'relative');
    }
    z.shake = function () {
        z.cnt++;
        z.e = new jQuery.fx(z.el.get(0), {
            duration: 60,
            complete: function () {
                z.e = new jQuery.fx(z.el.get(0), {
                    duration: 60,
                    complete: function () {
                        z.e = new jQuery.fx(e, {
                            duration: 60,
                            complete: function () {
                                if (z.cnt <= z.times)
                                    z.shake();
                                else {
                                    z.el.css('position', z.oldStyle.position).css('top', z.oldStyle.top + 'px').css('left', z.oldStyle.left + 'px');
                                    jQuery.dequeue(z.el.get(0), 'interfaceFX');
                                    if (z.callback && z.callback.constructor == Function) {
                                        z.callback.apply(z.el.get(0));
                                    }
                                }
                            }
                        }, 'left');
                        z.e.custom(z.oldStyle.left - 20, z.oldStyle.left);
                    }
                }, 'left');
                z.e.custom(z.oldStyle.left + 20, z.oldStyle.left - 20);
            }
        }, 'left');
        z.e.custom(z.oldStyle.left, z.oldStyle.left + 20);
    };
};
jQuery.iFisheye = {
    build: function (options) {
        return this.each(function () {
            var el = this;
            el.fisheyeCfg = {
                items: jQuery(options.items, this),
                container: jQuery(options.container, this),
                pos: jQuery.iUtil.getPosition(this),
                itemWidth: options.itemWidth,
                itemsText: options.itemsText,
                proximity: options.proximity,
                valign: options.valign,
                halign: options.halign,
                maxWidth: options.maxWidth
            };
            jQuery.iFisheye.positionContainer(el, 0);
            jQuery(window).bind('resize', function () {
                el.fisheyeCfg.pos = jQuery.iUtil.getPosition(el);
                jQuery.iFisheye.positionContainer(el, 0);
                jQuery.iFisheye.positionItems(el);
            });
            jQuery.iFisheye.positionItems(el);
            el.fisheyeCfg.items.bind('mouseover', function () {
                jQuery(el.fisheyeCfg.itemsText, this).get(0).style.display = 'block';
            }).bind('mouseout', function () {
                jQuery(el.fisheyeCfg.itemsText, this).get(0).style.display = 'none';
            });
            jQuery(document).bind('mousemove', function (e) {
                var pointer = jQuery.iUtil.getPointer(e);
                var toAdd = 0;
                if (el.fisheyeCfg.halign && el.fisheyeCfg.halign == 'center')
                    var posx = pointer.x - el.fisheyeCfg.pos.x - (el.offsetWidth - el.fisheyeCfg.itemWidth * el.fisheyeCfg.items.size()) / 2 - el.fisheyeCfg.itemWidth / 2;
                else if (el.fisheyeCfg.halign && el.fisheyeCfg.halign == 'right')
                    var posx = pointer.x - el.fisheyeCfg.pos.x - el.offsetWidth + el.fisheyeCfg.itemWidth * el.fisheyeCfg.items.size();
                else
                    var posx = pointer.x - el.fisheyeCfg.pos.x;
                var posy = Math.pow(pointer.y - el.fisheyeCfg.pos.y - el.offsetHeight / 2, 2);
                el.fisheyeCfg.items.each(function (nr) {
                    distance = Math.sqrt(Math.pow(posx - nr * el.fisheyeCfg.itemWidth, 2) + posy);
                    distance -= el.fisheyeCfg.itemWidth / 2;
                    distance = distance < 0 ? 0 : distance;
                    distance = distance > el.fisheyeCfg.proximity ? el.fisheyeCfg.proximity : distance;
                    distance = el.fisheyeCfg.proximity - distance;
                    extraWidth = el.fisheyeCfg.maxWidth * distance / el.fisheyeCfg.proximity;
                    this.style.width = el.fisheyeCfg.itemWidth + extraWidth + 'px';
                    this.style.left = el.fisheyeCfg.itemWidth * nr + toAdd + 'px';
                    toAdd += extraWidth;
                });
                jQuery.iFisheye.positionContainer(el, toAdd);
            });
        })
    },
    positionContainer: function (el, toAdd) {
        if (el.fisheyeCfg.halign)
            if (el.fisheyeCfg.halign == 'center')
                el.fisheyeCfg.container.get(0).style.left = (el.offsetWidth - el.fisheyeCfg.itemWidth * el.fisheyeCfg.items.size()) / 2 - toAdd / 2 + 'px';
            else if (el.fisheyeCfg.halign == 'left')
            el.fisheyeCfg.container.get(0).style.left = -toAdd / el.fisheyeCfg.items.size() + 'px';
        else if (el.fisheyeCfg.halign == 'right')
            el.fisheyeCfg.container.get(0).style.left = (el.offsetWidth - el.fisheyeCfg.itemWidth * el.fisheyeCfg.items.size()) - toAdd / 2 + 'px';
        el.fisheyeCfg.container.get(0).style.width = el.fisheyeCfg.itemWidth * el.fisheyeCfg.items.size() + toAdd + 'px';
    },
    positionItems: function (el) {
        el.fisheyeCfg.items.each(function (nr) {
            this.style.width = el.fisheyeCfg.itemWidth + 'px';
            this.style.left = el.fisheyeCfg.itemWidth * nr + 'px';
        });
    }
};
jQuery.fn.Fisheye = jQuery.iFisheye.build;
jQuery.selectHelper = null;
jQuery.selectKeyHelper = false;
jQuery.selectdrug = null;
jQuery.selectCurrent = [];
jQuery.selectKeyDown = function (e) {
    var pressedKey = e.charCode || e.keyCode || -1;
    if (pressedKey == 17 || pressedKey == 16) {
        jQuery.selectKeyHelper = true;
    }
};
jQuery.selectKeyUp = function (e) {
    jQuery.selectKeyHelper = false;
};
jQuery.selectstart = function (e) {
    this.f.pointer = jQuery.iUtil.getPointer(e);
    this.f.pos = jQuery.extend(jQuery.iUtil.getPosition(this), jQuery.iUtil.getSize(this));
    this.f.scr = jQuery.iUtil.getScroll(this);
    this.f.pointer.x -= this.f.pos.x;
    this.f.pointer.y -= this.f.pos.y;
    jQuery(this).append(jQuery.selectHelper.get(0));
    if (this.f.hc)
        jQuery.selectHelper.addClass(this.f.hc).css('display', 'block');
    jQuery.selectHelper.css({
        display: 'block',
        width: '0px',
        height: '0px'
    });
    if (this.f.o) {
        jQuery.selectHelper.css('opacity', this.f.o);
    }
    jQuery.selectdrug = this;
    jQuery.selectedone = false;
    jQuery.selectCurrent = [];
    this.f.el.each(function () {
        this.pos = {
            x: this.offsetLeft + (this.currentStyle && !jQuery.browser.opera ? parseInt(this.currentStyle.borderLeftWidth) || 0 : 0) + (jQuery.selectdrug.scrollLeft || 0),
            y: this.offsetTop + (this.currentStyle && !jQuery.browser.opera ? parseInt(this.currentStyle.borderTopWidth) || 0 : 0) + (jQuery.selectdrug.scrollTop || 0),
            wb: this.offsetWidth,
            hb: this.offsetHeight
        };
        if (this.s == true) {
            if (jQuery.selectKeyHelper == false) {
                this.s = false;
                jQuery(this).removeClass(jQuery.selectdrug.f.sc);
            } else {
                jQuery.selectedone = true;
                jQuery.selectCurrent[jQuery.selectCurrent.length] = jQuery.attr(this, 'id');
            }
        }
    });
    jQuery.selectcheck.apply(this, [e]);
    jQuery(document).bind('mousemove', jQuery.selectcheck).bind('mouseup', jQuery.selectstop);
    return false;
};
jQuery.selectcheck = function (e) {
    if (!jQuery.selectdrug)
        return;
    jQuery.selectcheckApply.apply(jQuery.selectdrug, [e]);
};
jQuery.selectcheckApply = function (e) {
    if (!jQuery.selectdrug)
        return;
    var pointer = jQuery.iUtil.getPointer(e);
    var scr = jQuery.iUtil.getScroll(jQuery.selectdrug);
    pointer.x += scr.l - this.f.scr.l - this.f.pos.x;
    pointer.y += scr.t - this.f.scr.t - this.f.pos.y;
    var sx = Math.min(pointer.x, this.f.pointer.x);
    var sw = Math.min(Math.abs(pointer.x - this.f.pointer.x), Math.abs(this.f.scr.w - sx));
    var sy = Math.min(pointer.y, this.f.pointer.y);
    var sh = Math.min(Math.abs(pointer.y - this.f.pointer.y), Math.abs(this.f.scr.h - sy));
    if (this.scrollTop > 0 && pointer.y - 20 < this.scrollTop) {
        var diff = Math.min(scr.t, 10);
        sy -= diff;
        sh += diff;
        this.scrollTop -= diff;
    } else if (this.scrollTop + this.f.pos.h < this.f.scr.h && pointer.y + 20 > this.scrollTop + this.f.pos.h) {
        var diff = Math.min(this.f.scr.h - this.scrollTop, 10);
        this.scrollTop += diff;
        if (this.scrollTop != scr.t)
            sh += diff;
    }
    if (this.scrollLeft > 0 && pointer.x - 20 < this.scrollLeft) {
        var diff = Math.min(scr.l, 10);
        sx -= diff;
        sw += diff;
        this.scrollLeft -= diff;
    } else if (this.scrollLeft + this.f.pos.w < this.f.scr.w && pointer.x + 20 > this.scrollLeft + this.f.pos.w) {
        var diff = Math.min(this.f.scr.w - this.scrollLeft, 10);
        this.scrollLeft += diff;
        if (this.scrollLeft != scr.l)
            sw += diff;
    }
    jQuery.selectHelper.css({
        left: sx + 'px',
        top: sy + 'px',
        width: sw + 'px',
        height: sh + 'px'
    });
    jQuery.selectHelper.l = sx + this.f.scr.l;
    jQuery.selectHelper.t = sy + this.f.scr.t;
    jQuery.selectHelper.r = jQuery.selectHelper.l + sw;
    jQuery.selectHelper.b = jQuery.selectHelper.t + sh;
    jQuery.selectedone = false;
    this.f.el.each(function () {
        iIndex = jQuery.selectCurrent.indexOf(jQuery.attr(this, 'id'));
        if (!(this.pos.x > jQuery.selectHelper.r || (this.pos.x + this.pos.wb) < jQuery.selectHelper.l || this.pos.y > jQuery.selectHelper.b || (this.pos.y + this.pos.hb) < jQuery.selectHelper.t)) {
            jQuery.selectedone = true;
            if (this.s != true) {
                this.s = true;
                jQuery(this).addClass(jQuery.selectdrug.f.sc);
            }
            if (iIndex != -1) {
                this.s = false;
                jQuery(this).removeClass(jQuery.selectdrug.f.sc);
            }
        } else if ((this.s == true) && (iIndex == -1)) {
            this.s = false;
            jQuery(this).removeClass(jQuery.selectdrug.f.sc);
        } else if ((!this.s) && (jQuery.selectKeyHelper == true) && (iIndex != -1)) {
            this.s = true;
            jQuery(this).addClass(jQuery.selectdrug.f.sc);
        }
    });
    return false;
};
jQuery.selectstop = function (e) {
    if (!jQuery.selectdrug)
        return;
    jQuery.selectstopApply.apply(jQuery.selectdrug, [e]);
};
jQuery.selectstopApply = function (e) {
    jQuery(document).unbind('mousemove', jQuery.selectcheck).unbind('mouseup', jQuery.selectstop);
    if (!jQuery.selectdrug)
        return;
    jQuery.selectHelper.css('display', 'none');
    if (this.f.hc)
        jQuery.selectHelper.removeClass(this.f.hc);
    jQuery.selectdrug = false;
    jQuery('body').append(jQuery.selectHelper.get(0));
    if (jQuery.selectedone == true) {
        if (this.f.onselect)
            this.f.onselect(jQuery.Selectserialize(jQuery.attr(this, 'id')));
    } else {
        if (this.f.onselectstop)
            this.f.onselectstop(jQuery.Selectserialize(jQuery.attr(this, 'id')));
    }
    jQuery.selectCurrent = [];
};
jQuery.Selectserialize = function (s) {
    var h = '';
    var o = [];
    if (a = jQuery('#' + s)) {
        a.get(0).f.el.each(function () {
            if (this.s == true) {
                if (h.length > 0) {
                    h += '&';
                }
                h += s + '[]=' + jQuery.attr(this, 'id');
                o[o.length] = jQuery.attr(this, 'id');
            }
        });
    }
    return {
        hash: h,
        o: o
    };
};
jQuery.fn.Selectable = function (o) {
    if (!jQuery.selectHelper) {
        jQuery('body', document).append('<div id="selectHelper"></div>').bind('keydown', jQuery.selectKeyDown).bind('keyup', jQuery.selectKeyUp);
        jQuery.selectHelper = jQuery('#selectHelper');
        jQuery.selectHelper.css({
            position: 'absolute',
            display: 'none'
        });
        if (window.event) {
            jQuery('body', document).bind('keydown', jQuery.selectKeyDown).bind('keyup', jQuery.selectKeyUp);
        } else {
            jQuery(document).bind('keydown', jQuery.selectKeyDown).bind('keyup', jQuery.selectKeyUp);
        }
    }
    if (!o) {
        o = {};
    }
    return this.each(function () {
        if (this.isSelectable)
            return;
        this.isSelectable = true;
        this.f = {
            a: o.accept,
            o: o.opacity ? parseFloat(o.opacity) : false,
            sc: o.selectedclass ? o.selectedclass : false,
            hc: o.helperclass ? o.helperclass : false,
            onselect: o.onselect ? o.onselect : false,
            onselectstop: o.onselectstop ? o.onselectstop : false
        };
        this.f.el = jQuery('.' + o.accept);
        jQuery(this).bind('mousedown', jQuery.selectstart).css('position', 'relative');
    });
};
jQuery.fn.extend({
    Fold: function (speed, height, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.DoFold(this, speed, height, callback, 'fold', easing);
        });
    },
    UnFold: function (speed, height, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.DoFold(this, speed, height, callback, 'unfold', easing);
        });
    },
    FoldToggle: function (speed, height, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.DoFold(this, speed, height, callback, 'toggle', easing);
        });
    }
});
jQuery.fx.DoFold = function (e, speed, height, callback, type, easing) {
    if (!jQuery.fxCheckTag(e)) {
        jQuery.dequeue(e, 'interfaceFX');
        return false;
    }
    var z = this;
    z.el = jQuery(e);
    z.easing = typeof callback == 'string' ? callback : easing || null;
    z.callback = typeof callback == 'function' ? callback : null;
    if (type == 'toggle') {
        type = z.el.css('display') == 'none' ? 'unfold' : 'fold';
    }
    z.speed = speed;
    z.height = height && height.constructor == Number ? height : 20;
    z.fx = jQuery.fx.buildWrapper(e);
    z.type = type;
    z.complete = function () {
        if (z.callback && z.callback.constructor == Function) {
            z.callback.apply(z.el.get(0));
        }
        if (z.type == 'unfold') {
            z.el.show();
        } else {
            z.el.hide();
        }
        jQuery.fx.destroyWrapper(z.fx.wrapper.get(0), z.fx.oldStyle);
        jQuery.dequeue(z.el.get(0), 'interfaceFX');
    };
    if (z.type == 'unfold') {
        z.el.show();
        z.fx.wrapper.css('height', z.height + 'px').css('width', '1px');
        z.ef = new jQuery.fx(z.fx.wrapper.get(0), jQuery.speed(z.speed, z.easing, function () {
            z.ef = new jQuery.fx(z.fx.wrapper.get(0), jQuery.speed(z.speed, z.easing, z.complete), 'height');
            z.ef.custom(z.height, z.fx.oldStyle.sizes.hb);
        }), 'width');
        z.ef.custom(0, z.fx.oldStyle.sizes.wb);
    } else {
        z.ef = new jQuery.fx(z.fx.wrapper.get(0), jQuery.speed(z.speed, z.easing, function () {
            z.ef = new jQuery.fx(z.fx.wrapper.get(0), jQuery.speed(z.speed, z.easing, z.complete), 'width');
            z.ef.custom(z.fx.oldStyle.sizes.wb, 0);
        }), 'height');
        z.ef.custom(z.fx.oldStyle.sizes.hb, z.height);
    }
};
jQuery.fn.Bounce = function (hight, callback) {
    return this.queue('interfaceFX', function () {
        if (!jQuery.fxCheckTag(this)) {
            jQuery.dequeue(this, 'interfaceFX');
            return false;
        }
        var e = new jQuery.fx.iBounce(this, hight, callback);
        e.bounce();
    });
};
jQuery.fx.iBounce = function (e, hight, callback) {
    var z = this;
    z.el = jQuery(e);
    z.el.show();
    z.callback = callback;
    z.hight = parseInt(hight) || 40;
    z.oldStyle = {};
    z.oldStyle.position = z.el.css('position');
    z.oldStyle.top = parseInt(z.el.css('top')) || 0;
    z.oldStyle.left = parseInt(z.el.css('left')) || 0;
    if (z.oldStyle.position != 'relative' && z.oldStyle.position != 'absolute') {
        z.el.css('position', 'relative');
    }
    z.times = 5;
    z.cnt = 1;
    z.bounce = function () {
        z.cnt++;
        z.e = new jQuery.fx(z.el.get(0), {
            duration: 120,
            complete: function () {
                z.e = new jQuery.fx(z.el.get(0), {
                    duration: 80,
                    complete: function () {
                        z.hight = parseInt(z.hight / 2);
                        if (z.cnt <= z.times)
                            z.bounce();
                        else {
                            z.el.css('position', z.oldStyle.position).css('top', z.oldStyle.top + 'px').css('left', z.oldStyle.left + 'px');
                            jQuery.dequeue(z.el.get(0), 'interfaceFX');
                            if (z.callback && z.callback.constructor == Function) {
                                z.callback.apply(z.el.get(0));
                            }
                        }
                    }
                }, 'top');
                z.e.custom(z.oldStyle.top - z.hight, z.oldStyle.top);
            }
        }, 'top');
        z.e.custom(z.oldStyle.top, z.oldStyle.top - z.hight);
    };
};
jQuery.fn.extend({
    CloseVertically: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.OpenClose(this, speed, callback, 'vertically', 'close', easing);
        });
    },
    CloseHorizontally: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.OpenClose(this, speed, callback, 'horizontally', 'close', easing);
        });
    },
    SwitchHorizontally: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            if (jQuery.css(this, 'display') == 'none') {
                new jQuery.fx.OpenClose(this, speed, callback, 'horizontally', 'open', easing);
            } else {
                new jQuery.fx.OpenClose(this, speed, callback, 'horizontally', 'close', easing);
            }
        });
    },
    SwitchVertically: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            if (jQuery.css(this, 'display') == 'none') {
                new jQuery.fx.OpenClose(this, speed, callback, 'vertically', 'open', easing);
            } else {
                new jQuery.fx.OpenClose(this, speed, callback, 'vertically', 'close', easing);
            }
        });
    },
    OpenVertically: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.OpenClose(this, speed, callback, 'vertically', 'open', easing);
        });
    },
    OpenHorizontally: function (speed, callback, easing) {
        return this.queue('interfaceFX', function () {
            new jQuery.fx.OpenClose(this, speed, callback, 'horizontally', 'open', easing);
        });
    }
});
jQuery.fx.OpenClose = function (e, speed, callback, direction, type, easing) {
    if (!jQuery.fxCheckTag(e)) {
        jQuery.dequeue(e, 'interfaceFX');
        return false;
    }
    var z = this;
    var restoreStyle = false;
    z.el = jQuery(e);
    z.easing = typeof callback == 'string' ? callback : easing || null;
    z.callback = typeof callback == 'function' ? callback : null;
    z.type = type;
    z.speed = speed;
    z.oldP = jQuery.iUtil.getSize(e);
    z.oldStyle = {};
    z.oldStyle.position = z.el.css('position');
    z.oldStyle.display = z.el.css('display');
    if (z.oldStyle.display == 'none') {
        oldVisibility = z.el.css('visibility');
        z.el.show();
        restoreStyle = true;
    }
    z.oldStyle.top = z.el.css('top');
    z.oldStyle.left = z.el.css('left');
    if (restoreStyle) {
        z.el.hide();
        z.el.css('visibility', oldVisibility);
    }
    z.oldStyle.width = z.oldP.w + 'px';
    z.oldStyle.height = z.oldP.h + 'px';
    z.oldStyle.overflow = z.el.css('overflow');
    z.oldP.top = parseInt(z.oldStyle.top) || 0;
    z.oldP.left = parseInt(z.oldStyle.left) || 0;
    if (z.oldStyle.position != 'relative' && z.oldStyle.position != 'absolute') {
        z.el.css('position', 'relative');
    }
    z.el.css('overflow', 'hidden').css('height', type == 'open' && direction == 'vertically' ? 1 : z.oldP.h + 'px').css('width', type == 'open' && direction == 'horizontally' ? 1 : z.oldP.w + 'px');
    z.complete = function () {
        z.el.css(z.oldStyle);
        if (z.type == 'close')
            z.el.hide();
        else
            z.el.show();
        jQuery.dequeue(z.el.get(0), 'interfaceFX');
    };
    switch (direction) {
    case 'vertically':
        z.eh = new jQuery.fx(z.el.get(0), jQuery.speed(speed - 15, z.easing, callback), 'height');
        z.et = new jQuery.fx(z.el.get(0), jQuery.speed(z.speed, z.easing, z.complete), 'top');
        if (z.type == 'close') {
            z.eh.custom(z.oldP.h, 0);
            z.et.custom(z.oldP.top, z.oldP.top + z.oldP.h / 2);
        } else {
            z.eh.custom(0, z.oldP.h);
            z.et.custom(z.oldP.top + z.oldP.h / 2, z.oldP.top);
        }
        break;
    case 'horizontally':
        z.eh = new jQuery.fx(z.el.get(0), jQuery.speed(speed - 15, z.easing, callback), 'width');
        z.et = new jQuery.fx(z.el.get(0), jQuery.speed(z.speed, z.easing, z.complete), 'left');
        if (z.type == 'close') {
            z.eh.custom(z.oldP.w, 0);
            z.et.custom(z.oldP.left, z.oldP.left + z.oldP.w / 2);
        } else {
            z.eh.custom(0, z.oldP.w);
            z.et.custom(z.oldP.left + z.oldP.w / 2, z.oldP.left);
        }
        break;
    }
};
jQuery.fn.Pulsate = function (speed, times, callback) {
    return this.queue('interfaceFX', function () {
        if (!jQuery.fxCheckTag(this)) {
            jQuery.dequeue(this, 'interfaceFX');
            return false;
        }
        var fx = new jQuery.fx.Pulsate(this, speed, times, callback);
        fx.pulse();
    });
};
jQuery.fx.Pulsate = function (el, speed, times, callback) {
    var z = this;
    z.times = times;
    z.cnt = 1;
    z.el = el;
    z.speed = speed;
    z.callback = callback;
    jQuery(z.el).show();
    z.pulse = function () {
        z.cnt++;
        z.e = new jQuery.fx(z.el, jQuery.speed(z.speed, function () {
            z.ef = new jQuery.fx(z.el, jQuery.speed(z.speed, function () {
                if (z.cnt <= z.times)
                    z.pulse();
                else {
                    jQuery.dequeue(z.el, 'interfaceFX');
                    if (z.callback && z.callback.constructor == Function) {
                        z.callback.apply(z.el);
                    }
                }
            }), 'opacity');
            z.ef.custom(0, 1);
        }), 'opacity');
        z.e.custom(1, 0);
    };
};
jQuery.iSort = {
    changed: [],
    collected: {},
    helper: false,
    inFrontOf: null,
    start: function () {
        if (jQuery.iDrag.dragged == null) {
            return;
        }
        var shs, margins, c, cs;
        jQuery.iSort.helper.get(0).className = jQuery.iDrag.dragged.dragCfg.hpc;
        shs = jQuery.iSort.helper.get(0).style;
        shs.display = 'block';
        jQuery.iSort.helper.oC = jQuery.extend(jQuery.iUtil.getPosition(jQuery.iSort.helper.get(0)), jQuery.iUtil.getSize(jQuery.iSort.helper.get(0)));
        shs.width = jQuery.iDrag.dragged.dragCfg.oC.wb + 'px';
        shs.height = jQuery.iDrag.dragged.dragCfg.oC.hb + 'px';
        margins = jQuery.iUtil.getMargins(jQuery.iDrag.dragged);
        shs.marginTop = margins.t;
        shs.marginRight = margins.r;
        shs.marginBottom = margins.b;
        shs.marginLeft = margins.l;
        if (jQuery.iDrag.dragged.dragCfg.ghosting == true) {
            c = jQuery.iDrag.dragged.cloneNode(true);
            cs = c.style;
            cs.marginTop = '0px';
            cs.marginRight = '0px';
            cs.marginBottom = '0px';
            cs.marginLeft = '0px';
            cs.display = 'block';
            jQuery.iSort.helper.empty().append(c);
        }
        jQuery(jQuery.iDrag.dragged).after(jQuery.iSort.helper.get(0));
        jQuery.iDrag.dragged.style.display = 'none';
    },
    check: function (e) {
        if (!e.dragCfg.so && jQuery.iDrop.overzone.sortable) {
            if (e.dragCfg.onStop)
                e.dragCfg.onStop.apply(dragged);
            jQuery(e).css('position', e.dragCfg.initialPosition || e.dragCfg.oP);
            jQuery(e).DraggableDestroy();
            jQuery(jQuery.iDrop.overzone).SortableAddItem(e);
        }
        jQuery.iSort.helper.removeClass(e.dragCfg.hpc).html('&nbsp;');
        jQuery.iSort.inFrontOf = null;
        var shs = jQuery.iSort.helper.get(0).style;
        shs.display = 'none';
        jQuery.iSort.helper.after(e);
        if (e.dragCfg.fx > 0) {
            jQuery(e).fadeIn(e.dragCfg.fx);
        }
        jQuery('body').append(jQuery.iSort.helper.get(0));
        var ts = [];
        var fnc = false;
        for (var i = 0; i < jQuery.iSort.changed.length; i++) {
            var iEL = jQuery.iDrop.zones[jQuery.iSort.changed[i]].get(0);
            var id = jQuery.attr(iEL, 'id');
            var ser = jQuery.iSort.serialize(id);
            if (iEL.dropCfg.os != ser.hash) {
                iEL.dropCfg.os = ser.hash;
                if (fnc == false && iEL.dropCfg.onChange) {
                    fnc = iEL.dropCfg.onChange;
                }
                ser.id = id;
                ts[ts.length] = ser;
            }
        }
        jQuery.iSort.changed = [];
        if (fnc != false && ts.length > 0) {
            fnc(ts);
        }
    },
    checkhover: function (e, o) {
        if (!jQuery.iDrag.dragged)
            return;
        var cur = false;
        var i = 0;
        if (e.dropCfg.el.size() > 0) {
            for (i = e.dropCfg.el.size(); i > 0; i--) {
                if (e.dropCfg.el.get(i - 1) != jQuery.iDrag.dragged) {
                    if (!e.sortCfg.floats) {
                        if ((e.dropCfg.el.get(i - 1).pos.y + e.dropCfg.el.get(i - 1).pos.hb / 2) > jQuery.iDrag.dragged.dragCfg.ny) {
                            cur = e.dropCfg.el.get(i - 1);
                        } else {
                            break;
                        }
                    } else {
                        if ((e.dropCfg.el.get(i - 1).pos.x + e.dropCfg.el.get(i - 1).pos.wb / 2) > jQuery.iDrag.dragged.dragCfg.nx && (e.dropCfg.el.get(i - 1).pos.y + e.dropCfg.el.get(i - 1).pos.hb / 2) > jQuery.iDrag.dragged.dragCfg.ny) {
                            cur = e.dropCfg.el.get(i - 1);
                        }
                    }
                }
            }
        }
        if (cur && jQuery.iSort.inFrontOf != cur) {
            jQuery.iSort.inFrontOf = cur;
            jQuery(cur).before(jQuery.iSort.helper.get(0));
        } else if (!cur && (jQuery.iSort.inFrontOf != null || jQuery.iSort.helper.get(0).parentNode != e)) {
            jQuery.iSort.inFrontOf = null;
            jQuery(e).append(jQuery.iSort.helper.get(0));
        }
        jQuery.iSort.helper.get(0).style.display = 'block';
    },
    measure: function (e) {
        if (jQuery.iDrag.dragged == null) {
            return;
        }
        e.dropCfg.el.each(function () {
            this.pos = jQuery.extend(jQuery.iUtil.getSizeLite(this), jQuery.iUtil.getPositionLite(this));
        });
    },
    serialize: function (s) {
        var i;
        var h = '';
        var o = {};
        if (s) {
            if (jQuery.iSort.collected[s]) {
                o[s] = [];
                jQuery('#' + s + ' .' + jQuery.iSort.collected[s]).each(function () {
                    if (h.length > 0) {
                        h += '&';
                    }
                    h += s + '[]=' + jQuery.attr(this, 'id');
                    o[s][o[s].length] = jQuery.attr(this, 'id');
                });
            } else {
                for (a in s) {
                    if (jQuery.iSort.collected[s[a]]) {
                        o[s[a]] = [];
                        jQuery('#' + s[a] + ' .' + jQuery.iSort.collected[s[a]]).each(function () {
                            if (h.length > 0) {
                                h += '&';
                            }
                            h += s[a] + '[]=' + jQuery.attr(this, 'id');
                            o[s[a]][o[s[a]].length] = jQuery.attr(this, 'id');
                        });
                    }
                }
            }
        } else {
            for (i in jQuery.iSort.collected) {
                o[i] = [];
                jQuery('#' + i + ' .' + jQuery.iSort.collected[i]).each(function () {
                    if (h.length > 0) {
                        h += '&';
                    }
                    h += i + '[]=' + jQuery.attr(this, 'id');
                    o[i][o[i].length] = jQuery.attr(this, 'id');
                });
            }
        }
        return {
            hash: h,
            o: o
        };
    },
    addItem: function (e) {
        if (!e.childNodes) {
            return;
        }
        return this.each(function () {
            if (!this.sortCfg || !jQuery(e).is('.' + this.sortCfg.accept))
                jQuery(e).addClass(this.sortCfg.accept);
            jQuery(e).Draggable(this.sortCfg.dragCfg);
        });
    },
    destroy: function () {
        return this.each(function () {
            jQuery('.' + this.sortCfg.accept).DraggableDestroy();
            jQuery(this).DroppableDestroy();
            this.sortCfg = null;
            this.isSortable = null;
        });
    },
    build: function (o) {
        if (o.accept && jQuery.iUtil && jQuery.iDrag && jQuery.iDrop) {
            if (!jQuery.iSort.helper) {
                jQuery('body', document).append('<div id="sortHelper">&nbsp;</div>');
                jQuery.iSort.helper = jQuery('#sortHelper');
                jQuery.iSort.helper.get(0).style.display = 'none';
            }
            this.Droppable({
                accept: o.accept,
                activeclass: o.activeclass ? o.activeclass : false,
                hoverclass: o.hoverclass ? o.hoverclass : false,
                helperclass: o.helperclass ? o.helperclass : false,
                onHover: o.onHover || o.onhover,
                onOut: o.onOut || o.onout,
                sortable: true,
                onChange: o.onChange || o.onchange,
                fx: o.fx ? o.fx : false,
                ghosting: o.ghosting ? true : false,
                tolerance: o.tolerance ? o.tolerance : 'intersect'
            });
            return this.each(function () {
                var dragCfg = {
                    revert: o.revert ? true : false,
                    zindex: 3000,
                    opacity: o.opacity ? parseFloat(o.opacity) : false,
                    hpc: o.helperclass ? o.helperclass : false,
                    fx: o.fx ? o.fx : false,
                    so: true,
                    ghosting: o.ghosting ? true : false,
                    handle: o.handle ? o.handle : null,
                    containment: o.containment ? o.containment : null,
                    onStart: o.onStart && o.onStart.constructor == Function ? o.onStart : false,
                    onDrag: o.onDrag && o.onDrag.constructor == Function ? o.onDrag : false,
                    onStop: o.onStop && o.onStop.constructor == Function ? o.onStop : false,
                    axis: /vertically|horizontally/.test(o.axis) ? o.axis : false,
                    snapDistance: o.snapDistance ? parseInt(o.snapDistance) || 0 : false,
                    cursorAt: o.cursorAt ? o.cursorAt : false
                };
                jQuery('.' + o.accept, this).Draggable(dragCfg);
                this.isSortable = true;
                this.sortCfg = {
                    accept: o.accept,
                    revert: o.revert ? true : false,
                    zindex: 3000,
                    opacity: o.opacity ? parseFloat(o.opacity) : false,
                    hpc: o.helperclass ? o.helperclass : false,
                    fx: o.fx ? o.fx : false,
                    so: true,
                    ghosting: o.ghosting ? true : false,
                    handle: o.handle ? o.handle : null,
                    containment: o.containment ? o.containment : null,
                    floats: o.floats ? true : false,
                    dragCfg: dragCfg
                }
            });
        }
    }
};
jQuery.fn.extend({
    Sortable: jQuery.iSort.build,
    SortableAddItem: jQuery.iSort.addItem,
    SortableDestroy: jQuery.iSort.destroy
});
jQuery.SortSerialize = jQuery.iSort.serialize;
jQuery.fn.Highlight = function (speed, color, callback, easing) {
    return this.queue('interfaceColorFX', function () {
        this.oldStyleAttr = jQuery(this).attr("style") || '';
        easing = typeof callback == 'string' ? callback : easing || null;
        callback = typeof callback == 'function' ? callback : null;
        var oldColor = jQuery(this).css('backgroundColor');
        var parentEl = this.parentNode;
        while (oldColor == 'transparent' && parentEl) {
            oldColor = jQuery(parentEl).css('backgroundColor');
            parentEl = parentEl.parentNode;
        }
        jQuery(this).css('backgroundColor', color);
        if (typeof this.oldStyleAttr == 'object') this.oldStyleAttr = this.oldStyleAttr["cssText"];
        jQuery(this).animate({
            'backgroundColor': oldColor
        }, speed, easing, function () {
            jQuery.dequeue(this, 'interfaceColorFX');
            if (typeof jQuery(this).attr("style") == 'object') {
                jQuery(this).attr("style")["cssText"] = "";
                jQuery(this).attr("style")["cssText"] = this.oldStyleAttr;
            } else {
                jQuery(this).attr("style", this.oldStyleAttr);
            }
            if (callback)
                callback.apply(this);
        });
    });
};
jQuery.transferHelper = null;
jQuery.fn.TransferTo = function (o) {
    return this.queue('interfaceFX', function () {
        new jQuery.fx.itransferTo(this, o);
    });
};
jQuery.fx.itransferTo = function (e, o) {
    if (jQuery.transferHelper == null) {
        jQuery('body', document).append('<div id="transferHelper"></div>');
        jQuery.transferHelper = jQuery('#transferHelper');
    }
    jQuery.transferHelper.css('display', 'block').css('position', 'absolute');
    var z = this;
    z.el = jQuery(e);
    if (!o || !o.to) {
        return;
    }
    if (o.to.constructor == String && document.getElementById(o.to)) {
        o.to = document.getElementById(o.to);
    } else if (!o.to.childNodes) {
        return;
    }
    if (!o.duration) {
        o.duration = 500;
    }
    z.duration = o.duration;
    z.to = o.to;
    z.classname = o.className;
    z.complete = o.complete;
    if (z.classname) {
        jQuery.transferHelper.addClass(z.classname);
    }
    z.diffWidth = 0;
    z.diffHeight = 0;
    if (jQuery.boxModel) {
        z.diffWidth = (parseInt(jQuery.transferHelper.css('borderLeftWidth')) || 0) + (parseInt(jQuery.transferHelper.css('borderRightWidth')) || 0) + (parseInt(jQuery.transferHelper.css('paddingLeft')) || 0) + (parseInt(jQuery.transferHelper.css('paddingRight')) || 0);
        z.diffHeight = (parseInt(jQuery.transferHelper.css('borderTopWidth')) || 0) + (parseInt(jQuery.transferHelper.css('borderBottomWidth')) || 0) + (parseInt(jQuery.transferHelper.css('paddingTop')) || 0) + (parseInt(jQuery.transferHelper.css('paddingBottom')) || 0);
    }
    z.start = jQuery.extend(jQuery.iUtil.getPosition(z.el.get(0)), jQuery.iUtil.getSize(z.el.get(0)));
    z.end = jQuery.extend(jQuery.iUtil.getPosition(z.to), jQuery.iUtil.getSize(z.to));
    z.start.wb -= z.diffWidth;
    z.start.hb -= z.diffHeight;
    z.end.wb -= z.diffWidth;
    z.end.hb -= z.diffHeight;
    z.callback = o.complete;
    jQuery.transferHelper.css('width', z.start.wb + 'px').css('height', z.start.hb + 'px').css('top', z.start.y + 'px').css('left', z.start.x + 'px').animate({
        top: z.end.y,
        left: z.end.x,
        width: z.end.wb,
        height: z.end.hb
    }, z.duration, function () {
        if (z.classname)
            jQuery.transferHelper.removeClass(z.classname);
        jQuery.transferHelper.css('display', 'none');
        if (z.complete && z.complete.constructor == Function) {
            z.complete.apply(z.el.get(0), [z.to]);
        }
        jQuery.dequeue(z.el.get(0), 'interfaceFX');
    });
};
var loggingEnabled = false;

function getToolbarWidgetId(widget) {
    return widget.attr("id") + "tw";
}

function getWidgetId(toolbarWidget) {
    var id = toolbarWidget.attr("id");
    if (id.length - id.lastIndexOf("tw") != 2) {
        return null;
    }
    return id.substring(0, id.length - 2);
}

function onToolbarWidgetDragStop() {
    var dragged = $(this);
    if (dragged === undefined || dragged === null || dragged.parents(".widgetToolbarWidgets").size() > 0) {
        return;
    }
    var widget = $("#" + getWidgetId(dragged));
    dragged.after(widget);
    dashboard.hideToolbarWidget(dragged.attr("id"));
    dashboard.showWidget(widget.attr("id"), true, function () {
        dashboard.updateLayout();
    });
}

function onToolbarWidgetClick() {
    var toolbarWidget = $(this);
    dashboard.hideToolbarWidget(toolbarWidget.attr("id"), true);
    dashboard.showWidget(getWidgetId(toolbarWidget), true, function () {
        dashboard.updateLayout();
    });
    return false;
}

function onWidgetClose() {
    var widget = $(this).parents(".groupItem");
    dashboard.hideWidget(widget.attr("id"), true, function () {
        dashboard.updateLayout();
    });
    dashboard.showToolbarWidget(getToolbarWidgetId(widget), true);
    if (!dashboard.getToolbar().is(":visible")) {
        $(".widgetToolbarButtonContainer").animate({
            opacity: 'toggle'
        }, {
            duration: "medium"
        }).animate({
            opacity: 'toggle'
        }, {
            duration: "medium"
        });
    }
    var rArr = $(".widgetToolbarRightArrow");
    if (rArr.is(":visible")) {
        rArr.animate({
            opacity: 'toggle'
        }, {
            duration: "medium"
        }).animate({
            opacity: 'toggle'
        }, {
            duration: "medium"
        });
    }
    return false;
}

function initDashboard() {
    var carouselParent = $(".widgetToolbarCarousel").parent();
    $(".widgetToolbarCarousel").appendTo("#main").show().jCarouselLite({
        btnNext: ".widgetToolbarRightArrow",
        btnPrev: ".widgetToolbarLeftArrow",
        btnDisabledClass: "widgetToolbarArrowDisabled",
        mouseWheel: true,
        circular: false,
        visible: 6
    }).appendTo(carouselParent);
    $('.groupWrapper').Sortable({
        accept: 'groupItem',
        helperclass: 'sortHelper',
        activeclass: 'sortableactive',
        hoverclass: 'sortablehover',
        handle: '.widgetHandle',
        tolerance: 'intersect',
        opacity: false,
        onChange: function (ser) {
            dashboard.updateLayout();
        }
    });
    $('.widget').hover(function () {
        $(this).addClass('hover');
    }, function () {
        $(this).removeClass('hover');
    });
    $(".groupItem:not(.locked) .widgetButtonClose").click(onWidgetClose);
    $(".widgetButtonClose", $(".groupItem").filter(".locked")).each(function () {
        $("a", $(this)).attr("disabled", true);
        $(this).attr("title", "This widget is locked and cannot be closed");
    });
    $(".widgetToolbarButtonContainer a").click(function () {
        var toolbar = dashboard.getToolbar();
        if (toolbar.is(":visible")) {
            dashboard.hideToolbar(true);
        } else {
            dashboard.showToolbar(true);
        }
        return false;
    });
    $(".toolbarWidget").each(function () {
        var toolbarWidget = $(this);
        toolbarWidget.Draggable({
            revert: true,
            zindex: 3000,
            opacity: false,
            hpc: 'sortHelper',
            so: true,
            ghosting: false,
            autoSize: true,
            onStop: onToolbarWidgetDragStop
        });
        toolbarWidget.click(onToolbarWidgetClick);
        var title = $("span", toolbarWidget);
        toolbarWidget.attr("title", title.text());
    });
    $('.widgetToolbarWidgets').Droppable({
        accept: 'toolbarWidget',
        activeclass: 'dropzoneactive',
        hoverclass: 'dropzonehover'
    });
    var settingsString = $.cookie(DASHBOARD_SETTINGS_COOKIE_NAME);
    dashboard.parseSettings(settingsString);
}

function Dashboard(toolbarVisible) {
    this.toolbarVisible = toolbarVisible !== undefined ? toolbarVisible : true;
    this.layout = undefined;
    this.settings = new Object();
    this.showWidget = function (widgetId, fx, callback) {
        var widget = $("#" + widgetId);
        if (fx) {
            widget.slideDown("slow", callback ? callback : null);
        } else {
            widget.show();
            callback ? callback() : '';
        }
    };
    this.hideWidget = function (widgetId, fx, callback) {
        var widget = $("#" + widgetId);
        if (fx) {
            widget.slideUp("fast", callback ? callback : null);
        } else {
            widget.hide();
            callback ? callback() : '';
        }
    };
    this.showToolbarWidget = function (toolbarWidgetId, fx) {
        var toolbarWidget = $("#" + toolbarWidgetId);
        var toolbarWidgetContainer = toolbarWidget.parent();
        var firstHiddenToolbarWidget = $(".widgetToolbarWidgets .toolbarWidget:hidden:first");
        toolbarWidgetContainer.insertBefore(firstHiddenToolbarWidget.parent());
        var callback = function () {
            toolbarWidgetContainer.css({
                display: "block"
            });
            $(".widgetToolbarCarousel").trigger("updateButtons");
        };
        toolbarWidget.removeClass("hide");
        if (fx) {
            toolbarWidget.fadeIn("slow", callback);
        } else {
            toolbarWidget.show();
            callback();
        }
    };
    this.hideToolbarWidget = function (toolbarWidgetId, fx) {
        var toolbarWidget = $("#" + toolbarWidgetId);
        var toolbarWidgetContainer = $("#c" + toolbarWidgetId);
        toolbarWidgetContainer.append(toolbarWidget);
        var callback = function () {
            $(".widgetToolbarWidgets ul").append(toolbarWidgetContainer);
            $(".widgetToolbarCarousel").trigger("updateButtons").trigger("scrollLeftConditionally");
        };
        if (fx) {
            toolbarWidget.fadeOut("fast", callback);
        } else {
            toolbarWidget.hide();
            callback();
        }
    };
    this.getToolbar = function () {
        return $(".widgetToolbarBody");
    };
    this.showToolbar = function (fx) {
        var buttonPane = $(".widgetToolbarButtonContainer");
        var callback = function () {
            $(".widgetToolbarButton").removeClass("widgetToolbarButtonOpen").addClass("widgetToolbarButtonClose");
            dashboard.setToolbarVisible(true);
        };
        if (fx) {
            this.getToolbar().slideDown("medium", callback);
            if ($.browser.msie) {
                $(".widgetToolbarCarousel li").slideDown("medium");
            }
        } else {
            this.getToolbar().show();
            callback();
        }
    };
    this.hideToolbar = function (fx) {
        var buttonPane = $(".widgetToolbarButtonContainer");
        var callback = function () {
            $(".widgetToolbarButton").removeClass("widgetToolbarButtonClose").addClass("widgetToolbarButtonOpen");
            dashboard.setToolbarVisible(false);
        };
        if (fx) {
            this.getToolbar().slideUp("medium", callback);
            if ($.browser.msie) {
                $(".widgetToolbarCarousel li").slideUp("medium");
            }
        } else {
            this.getToolbar().hide();
            callback();
        }
    };
    this.setToolbarVisible = function (visible) {
        this.toolbarVisible = visible;
        this.settings["toolbarVisible"] = visible;
        if (this.settings["layout"] === undefined) {
            dashboard.updateLayout();
        }
        this.storeDashboard();
    };
    this.isToolbarVisible = function () {
        return this.toolbarVisible;
    };
    this.parseSettings = function (settingsString) {
        if (!settingsString || settingsString.length == 0) {
            return false;
        }
        var pairs, pair, key, value;
        pairs = settingsString.split('&');
        for (i = 0; i < pairs.length; i++) {
            pair = pairs[i].split("=");
            key = pair[0];
            value = pair[1];
            if (key == "layout") {
                var groups = value.split(";");
                var layoutArray = new Object();
                for (groupNo = 0; groupNo < groups.length; groupNo++) {
                    var group = groups[groupNo].split(":");
                    if (group.length == 2) {
                        layoutArray[group[0]] = group[1].split(",");
                    }
                }
                this.layout = layoutArray;
            } else if (key == "toolbarVisible") {
                this.toolbarVisible = eval(value);
            }
            this.settings[key] = value;
        }
        return true;
    };
    this.updateLayout = function () {
        this.layout = $.SortSerialize().o;
        var layoutString = "";
        for (group in this.layout) {
            layoutString += group + ":";
            var items = this.layout[group];
            for (j = 0; j < items.length; j++) {
                var item = items[j];
                if ((!$("#" + item).is(":visible")) || $("#" + item).is(".toolbarWidget")) {
                    continue;
                }
                layoutString += item;
                layoutString += ",";
            }
            layoutString = layoutString.substring(0, layoutString.length - 1);
            layoutString += ";";
        }
        layoutString = layoutString.substring(0, layoutString.length - 1);
        this.settings["layout"] = layoutString;
        this.storeDashboard();
    };
    this.storeDashboard = function () {
        var settingsString = "";
        for (setting in this.settings) {
            settingsString += setting + "=" + this.settings[setting] + "&";
        }
        settingsString = settingsString.substring(0, settingsString.length - 1);
        $.cookie(DASHBOARD_SETTINGS_COOKIE_NAME, settingsString, {
            expires: 7
        });
        log("Stored " + settingsString);
    };
    this.restoreDashboard = function () {
        var settingsString = $.cookie(DASHBOARD_SETTINGS_COOKIE_NAME);
        if (!this.parseSettings(settingsString)) {
            return false;
        }
        if (this.isToolbarVisible()) {
            this.showToolbar(false);
        } else {
            this.hideToolbar(false);
        }
        if (this.hasCustomLayout()) {
            $(".groupItem").each(function () {
                dashboard.hideWidget(this.id);
            });
            $(".toolbarWidget").each(function () {
                dashboard.showToolbarWidget(this.id);
            });
            for (group in this.layout) {
                for (i = 0; i < this.layout[group].length; i++) {
                    var widget = $("#" + this.layout[group][i]);
                    $("#" + group).append(widget);
                    this.hideToolbarWidget(getToolbarWidgetId(widget));
                    this.showWidget(widget.attr("id"));
                }
            }
        }
        log("Restored " + settingsString);
    };
    this.hasCustomLayout = function () {
        return this.layout != undefined;
    };
    this.loadWidgets = function () {
        $(".widget").each(function () {
            $body = $("#f_" + this.id, $(this));
            log($body.attr("src"));
            $frame = $("<iframe frameborder='0' allowTransparency='true'></iframe>");
            $frame.attr({
                "src": $body.attr("src"),
                "name": $body.attr("name"),
                "id": $body.attr("id")
            });
            $body.after($frame);
            $body.remove();
        });
    };
}

function log(message) {
    if (loggingEnabled && $.browser.mozilla && window.console != undefined) {
        console.log(message);
    }
}
jQuery.preloadImages = function () {
    for (var i = 0; i < arguments.length; i++) {
        jQuery("<img>").attr("src", arguments[i]);
    }
};
jQuery.cookie = function (name, value, options) {
    if (typeof value != 'undefined') {
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString();
        }
        var path = options.path ? '; path=' + options.path : '';
        var domain = options.domain ? '; domain=' + options.domain : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else {
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
(function ($) {
    var height = $.fn.height,
        width = $.fn.width;
    $.fn.extend({
        height: function () {
            if (!this[0]) error();
            if (this[0] == window)
                if ($.browser.opera || ($.browser.safari && parseInt($.browser.version) > 520))
                    return self.innerHeight - (($(document).height() > self.innerHeight) ? getScrollbarWidth() : 0);
                else if ($.browser.safari)
                return self.innerHeight;
            else
                return $.boxModel && document.documentElement.clientHeight || document.body.clientHeight; if (this[0] == document)
                return Math.max(($.boxModel && document.documentElement.scrollHeight || document.body.scrollHeight), document.body.offsetHeight);
            return height.apply(this, arguments);
        },
        width: function () {
            if (!this[0]) error();
            if (this[0] == window)
                if ($.browser.opera || ($.browser.safari && parseInt($.browser.version) > 520))
                    return self.innerWidth - (($(document).width() > self.innerWidth) ? getScrollbarWidth() : 0);
                else if ($.browser.safari)
                return self.innerWidth;
            else
                return $.boxModel && document.documentElement.clientWidth || document.body.clientWidth; if (this[0] == document)
                if ($.browser.mozilla) {
                    var scrollLeft = self.pageXOffset;
                    self.scrollTo(99999999, self.pageYOffset);
                    var scrollWidth = self.pageXOffset;
                    self.scrollTo(scrollLeft, self.pageYOffset);
                    return document.body.offsetWidth + scrollWidth;
                } else
                    return Math.max((($.boxModel && !$.browser.safari) && document.documentElement.scrollWidth || document.body.scrollWidth), document.body.offsetWidth);
            return width.apply(this, arguments);
        },
        innerHeight: function () {
            if (!this[0]) error();
            return this[0] == window || this[0] == document ? this.height() : this.is(':visible') ? this[0].offsetHeight - num(this, 'borderTopWidth') - num(this, 'borderBottomWidth') : this.height() + num(this, 'paddingTop') + num(this, 'paddingBottom');
        },
        innerWidth: function () {
            if (!this[0]) error();
            return this[0] == window || this[0] == document ? this.width() : this.is(':visible') ? this[0].offsetWidth - num(this, 'borderLeftWidth') - num(this, 'borderRightWidth') : this.width() + num(this, 'paddingLeft') + num(this, 'paddingRight');
        },
        outerHeight: function (options) {
            if (!this[0]) error();
            options = $.extend({
                margin: false
            }, options || {});
            return this[0] == window || this[0] == document ? this.height() : this.is(':visible') ? this[0].offsetHeight + (options.margin ? (num(this, 'marginTop') + num(this, 'marginBottom')) : 0) : this.height() + num(this, 'borderTopWidth') + num(this, 'borderBottomWidth') + num(this, 'paddingTop') + num(this, 'paddingBottom') + (options.margin ? (num(this, 'marginTop') + num(this, 'marginBottom')) : 0);
        },
        outerWidth: function (options) {
            if (!this[0]) error();
            options = $.extend({
                margin: false
            }, options || {});
            return this[0] == window || this[0] == document ? this.width() : this.is(':visible') ? this[0].offsetWidth + (options.margin ? (num(this, 'marginLeft') + num(this, 'marginRight')) : 0) : this.width() + num(this, 'borderLeftWidth') + num(this, 'borderRightWidth') + num(this, 'paddingLeft') + num(this, 'paddingRight') + (options.margin ? (num(this, 'marginLeft') + num(this, 'marginRight')) : 0);
        },
        scrollLeft: function (val) {
            if (!this[0]) error();
            if (val != undefined)
                return this.each(function () {
                    if (this == window || this == document)
                        window.scrollTo(val, $(window).scrollTop());
                    else
                        this.scrollLeft = val;
                });
            if (this[0] == window || this[0] == document)
                return self.pageXOffset || $.boxModel && document.documentElement.scrollLeft || document.body.scrollLeft;
            return this[0].scrollLeft;
        },
        scrollTop: function (val) {
            if (!this[0]) error();
            if (val != undefined)
                return this.each(function () {
                    if (this == window || this == document)
                        window.scrollTo($(window).scrollLeft(), val);
                    else
                        this.scrollTop = val;
                });
            if (this[0] == window || this[0] == document)
                return self.pageYOffset || $.boxModel && document.documentElement.scrollTop || document.body.scrollTop;
            return this[0].scrollTop;
        },
        position: function (returnObject) {
            return this.offset({
                margin: false,
                scroll: false,
                relativeTo: this.offsetParent()
            }, returnObject);
        },
        offset: function (options, returnObject) {
            if (!this[0]) error();
            var x = 0,
                y = 0,
                sl = 0,
                st = 0,
                elem = this[0],
                parent = this[0],
                op, parPos, elemPos = $.css(elem, 'position'),
                mo = $.browser.mozilla,
                ie = $.browser.msie,
                oa = $.browser.opera,
                sf = $.browser.safari,
                sf3 = $.browser.safari && parseInt($.browser.version) > 520,
                absparent = false,
                relparent = false,
                options = $.extend({
                    margin: true,
                    border: false,
                    padding: false,
                    scroll: true,
                    lite: false,
                    relativeTo: document.body
                }, options || {});
            if (options.lite) return this.offsetLite(options, returnObject);
            if (options.relativeTo.jquery) options.relativeTo = options.relativeTo[0];
            if (elem.tagName == 'BODY') {
                x = elem.offsetLeft;
                y = elem.offsetTop;
                if (mo) {
                    x += num(elem, 'marginLeft') + (num(elem, 'borderLeftWidth') * 2);
                    y += num(elem, 'marginTop') + (num(elem, 'borderTopWidth') * 2);
                } else
                if (oa) {
                    x += num(elem, 'marginLeft');
                    y += num(elem, 'marginTop');
                } else
                if ((ie && jQuery.boxModel)) {
                    x += num(elem, 'borderLeftWidth');
                    y += num(elem, 'borderTopWidth');
                } else
                if (sf3) {
                    x += num(elem, 'marginLeft') + num(elem, 'borderLeftWidth');
                    y += num(elem, 'marginTop') + num(elem, 'borderTopWidth');
                }
            } else {
                do {
                    parPos = $.css(parent, 'position');
                    x += parent.offsetLeft;
                    y += parent.offsetTop;
                    if ((mo && !parent.tagName.match(/^t[d|h]$/i)) || ie || sf3) {
                        x += num(parent, 'borderLeftWidth');
                        y += num(parent, 'borderTopWidth');
                        if (mo && parPos == 'absolute') absparent = true;
                        if (ie && parPos == 'relative') relparent = true;
                    }
                    op = parent.offsetParent || document.body;
                    if (options.scroll || mo) {
                        do {
                            if (options.scroll) {
                                sl += parent.scrollLeft;
                                st += parent.scrollTop;
                            }
                            if (oa && ($.css(parent, 'display') || '').match(/table-row|inline/)) {
                                sl = sl - ((parent.scrollLeft == parent.offsetLeft) ? parent.scrollLeft : 0);
                                st = st - ((parent.scrollTop == parent.offsetTop) ? parent.scrollTop : 0);
                            }
                            if (mo && parent != elem && $.css(parent, 'overflow') != 'visible') {
                                x += num(parent, 'borderLeftWidth');
                                y += num(parent, 'borderTopWidth');
                            }
                            parent = parent.parentNode;
                        } while (parent != op);
                    }
                    parent = op;
                    if (parent == options.relativeTo && !(parent.tagName == 'BODY' || parent.tagName == 'HTML')) {
                        if (mo && parent != elem && $.css(parent, 'overflow') != 'visible') {
                            x += num(parent, 'borderLeftWidth');
                            y += num(parent, 'borderTopWidth');
                        }
                        if (((sf && !sf3) || oa) && parPos != 'static') {
                            x -= num(op, 'borderLeftWidth');
                            y -= num(op, 'borderTopWidth');
                        }
                        break;
                    }
                    if (parent.tagName == 'BODY' || parent.tagName == 'HTML') {
                        if (((sf && !sf3) || (ie && $.boxModel)) && elemPos != 'absolute' && elemPos != 'fixed') {
                            x += num(parent, 'marginLeft');
                            y += num(parent, 'marginTop');
                        }
                        if (sf3 || (mo && !absparent && elemPos != 'fixed') || (ie && elemPos == 'static' && !relparent)) {
                            x += num(parent, 'borderLeftWidth');
                            y += num(parent, 'borderTopWidth');
                        }
                        break;
                    }
                } while (parent);
            }
            var returnValue = handleOffsetReturn(elem, options, x, y, sl, st);
            if (returnObject) {
                $.extend(returnObject, returnValue);
                return this;
            } else {
                return returnValue;
            }
        },
        offsetLite: function (options, returnObject) {
            if (!this[0]) error();
            var x = 0,
                y = 0,
                sl = 0,
                st = 0,
                parent = this[0],
                offsetParent, options = $.extend({
                    margin: true,
                    border: false,
                    padding: false,
                    scroll: true,
                    relativeTo: document.body
                }, options || {});
            if (options.relativeTo.jquery) options.relativeTo = options.relativeTo[0];
            do {
                x += parent.offsetLeft;
                y += parent.offsetTop;
                offsetParent = parent.offsetParent || document.body;
                if (options.scroll) {
                    do {
                        sl += parent.scrollLeft;
                        st += parent.scrollTop;
                        parent = parent.parentNode;
                    } while (parent != offsetParent);
                }
                parent = offsetParent;
            } while (parent && parent.tagName != 'BODY' && parent.tagName != 'HTML' && parent != options.relativeTo);
            var returnValue = handleOffsetReturn(this[0], options, x, y, sl, st);
            if (returnObject) {
                $.extend(returnObject, returnValue);
                return this;
            } else {
                return returnValue;
            }
        },
        offsetParent: function () {
            if (!this[0]) error();
            var offsetParent = this[0].offsetParent;
            while (offsetParent && (offsetParent.tagName != 'BODY' && $.css(offsetParent, 'position') == 'static'))
                offsetParent = offsetParent.offsetParent;
            return $(offsetParent);
        }
    });
    var error = function () {
        throw "Dimensions: jQuery collection is empty";
    };
    var num = function (el, prop) {
        return parseInt($.css(el.jquery ? el[0] : el, prop)) || 0;
    };
    var handleOffsetReturn = function (elem, options, x, y, sl, st) {
        if (!options.margin) {
            x -= num(elem, 'marginLeft');
            y -= num(elem, 'marginTop');
        }
        if (options.border && (($.browser.safari && parseInt($.browser.version) < 520) || $.browser.opera)) {
            x += num(elem, 'borderLeftWidth');
            y += num(elem, 'borderTopWidth');
        } else if (!options.border && !(($.browser.safari && parseInt($.browser.version) < 520) || $.browser.opera)) {
            x -= num(elem, 'borderLeftWidth');
            y -= num(elem, 'borderTopWidth');
        }
        if (options.padding) {
            x += num(elem, 'paddingLeft');
            y += num(elem, 'paddingTop');
        }
        if (options.scroll && (!$.browser.opera || elem.offsetLeft != elem.scrollLeft && elem.offsetTop != elem.scrollLeft)) {
            sl -= elem.scrollLeft;
            st -= elem.scrollTop;
        }
        return options.scroll ? {
            top: y - st,
            left: x - sl,
            scrollTop: st,
            scrollLeft: sl
        } : {
            top: y,
            left: x
        };
    };
    var scrollbarWidth = 0;
    var getScrollbarWidth = function () {
        if (!scrollbarWidth) {
            var testEl = $('<div>').css({
                width: 100,
                height: 100,
                overflow: 'auto',
                position: 'absolute',
                top: -1000,
                left: -1000
            }).appendTo('body');
            scrollbarWidth = 100 - testEl.append('<div>').find('div').css({
                width: '100%',
                height: 200
            }).width();
            testEl.remove();
        }
        return scrollbarWidth;
    };
})(jQuery);
(function ($) {
    $.fn.extend({
        mousewheel: function (f) {
            if (!f.guid) f.guid = $.event.guid++;
            if (!$.event._mwCache) $.event._mwCache = [];
            return this.each(function () {
                if (this._mwHandlers) return this._mwHandlers.push(f);
                else this._mwHandlers = [];
                this._mwHandlers.push(f);
                var s = this;
                this._mwHandler = function (e) {
                    e = $.event.fix(e || window.event);
                    $.extend(e, this._mwCursorPos || {});
                    var delta = 0,
                        returnValue = true;
                    if (e.wheelDelta) delta = e.wheelDelta / 120;
                    if (e.detail) delta = -e.detail / 3;
                    if (window.opera) delta = -e.wheelDelta;
                    for (var i = 0; i < s._mwHandlers.length; i++)
                        if (s._mwHandlers[i])
                            if (s._mwHandlers[i].call(s, e, delta) === false) {
                                returnValue = false;
                                e.preventDefault();
                                e.stopPropagation();
                            }
                    return returnValue;
                };
                if ($.browser.mozilla && !this._mwFixCursorPos) {
                    this._mwFixCursorPos = function (e) {
                        this._mwCursorPos = {
                            pageX: e.pageX,
                            pageY: e.pageY,
                            clientX: e.clientX,
                            clientY: e.clientY
                        };
                    };
                    $(this).bind('mousemove', this._mwFixCursorPos);
                }
                if (this.addEventListener)
                    if ($.browser.mozilla) this.addEventListener('DOMMouseScroll', this._mwHandler, false);
                    else this.addEventListener('mousewheel', this._mwHandler, false);
                    else
                        this.onmousewheel = this._mwHandler;
                $.event._mwCache.push($(this));
            });
        },
        unmousewheel: function (f) {
            return this.each(function () {
                if (f && this._mwHandlers) {
                    for (var i = 0; i < this._mwHandlers.length; i++)
                        if (this._mwHandlers[i] && this._mwHandlers[i].guid == f.guid)
                            delete this._mwHandlers[i];
                } else {
                    if ($.browser.mozilla && !this._mwFixCursorPos)
                        $(this).unbind('mousemove', this._mwFixCursorPos);
                    if (this.addEventListener)
                        if ($.browser.mozilla) this.removeEventListener('DOMMouseScroll', this._mwHandler, false);
                        else this.removeEventListener('mousewheel', this._mwHandler, false);
                        else
                            this.onmousewheel = null;
                    this._mwHandlers = this._mwHandler = this._mwFixCursorPos = this._mwCursorPos = null;
                }
            });
        }
    });
    $(window).one('unload', function () {
        var els = $.event._mwCache || [];
        for (var i = 0; i < els.length; i++)
            els[i].unmousewheel();
    });
})(jQuery);
(function ($) {
    $.fn.jCarouselLite = function (o) {
        o = $.extend({
            btnPrev: null,
            btnNext: null,
            btnGo: null,
            mouseWheel: false,
            auto: null,
            speed: 200,
            easing: null,
            vertical: false,
            circular: true,
            visible: 3,
            start: 0,
            scroll: 1,
            beforeStart: null,
            afterEnd: null
        }, o || {});
        return this.each(function () {
            var running = false,
                animCss = o.vertical ? "top" : "left",
                sizeCss = o.vertical ? "height" : "width";
            var div = $(this),
                ul = $("ul", div),
                tLi = $("li", ul),
                tl = tLi.size(),
                v = o.visible;
            if (o.circular) {
                ul.prepend(tLi.gt(tl - v - 1).clone()).append(tLi.lt(v).clone());
                o.start += v;
            }
            var li = $("li", ul),
                itemLength = li.size(),
                curr = o.start;
            div.css("visibility", "visible");
            li.css("overflow", "hidden").css("float", o.vertical ? "none" : "left").children().css("overflow", "hidden");
            ul.css("margin", "0").css("padding", "0").css("position", "relative").css("list-style-type", "none").css("z-index", "1");
            div.css("overflow", "hidden").css("position", "relative").css("z-index", "2").css("left", "0px");
            var liSize = o.vertical ? height(li) : width(li);
            var ulSize = liSize * itemLength;
            var divSize = liSize * v;
            li.css("width", li.width()).css("height", li.height());
            ul.css(sizeCss, ulSize + "px").css(animCss, -(curr * liSize));
            div.css(sizeCss, divSize + "px");
            if (o.btnPrev)
                $(o.btnPrev).click(function () {
                    return go(curr - o.scroll);
                });
            if (o.btnNext)
                $(o.btnNext).click(function () {
                    return go(curr + o.scroll);
                });
            if (o.btnGo)
                $.each(o.btnGo, function (i, val) {
                    $(val).click(function () {
                        return go(o.circular ? o.visible + i : i);
                    });
                });
            if (o.mouseWheel && div.mousewheel)
                div.mousewheel(function (e, d) {
                    return d > 0 ? go(curr - o.scroll) : go(curr + o.scroll);
                });
            if (o.auto)
                setInterval(function () {
                    go(curr + o.scroll);
                }, o.auto + o.speed);

            function vis() {
                return li.gt(curr - 1).lt(v);
            };

            function go(to) {
                if (!running) {
                    if (o.beforeStart)
                        o.beforeStart.call(this, vis());
                    if (o.circular) {
                        if (to <= o.start - v - 1) {
                            ul.css(animCss, -((itemLength - (v * 2)) * liSize) + "px");
                            curr = to == o.start - v - 1 ? itemLength - (v * 2) - 1 : itemLength - (v * 2) - o.scroll;
                        } else if (to >= itemLength - v + 1) {
                            ul.css(animCss, -((v) * liSize) + "px");
                            curr = to == itemLength - v + 1 ? v + 1 : v + o.scroll;
                        } else curr = to;
                    } else {
                        if (to < 0 || to > itemLength - v) return;
                        else curr = to;
                    }
                    running = true;
                    ul.animate(animCss == "left" ? {
                        left: -(curr * liSize)
                    } : {
                        top: -(curr * liSize)
                    }, o.speed, o.easing, function () {
                        if (o.afterEnd)
                            o.afterEnd.call(this, vis());
                        running = false;
                    });
                    if (!o.circular) {
                        $(o.btnPrev + "," + o.btnNext).removeClass("disabled");
                        $((curr - o.scroll < 0 && o.btnPrev) || (curr + o.scroll > itemLength - v && o.btnNext) || []).addClass("disabled");
                    }
                }
                return false;
            };
        });
    };

    function css(el, prop) {
        return parseInt($.css(el[0], prop)) || 0;
    };

    function width(el) {
        return el[0].offsetWidth + css(el, 'marginLeft') + css(el, 'marginRight');
    };

    function height(el) {
        return el[0].offsetHeight + css(el, 'marginTop') + css(el, 'marginBottom');
    };
})(jQuery);
(function ($) {
    $.meta = {
        type: "class",
        name: "metadata",
        setType: function (type, name) {
            this.type = type;
            this.name = name;
        },
        cre: /({.*})/,
        single: 'metadata'
    };
    var setArray = $.fn.setArray;
    $.fn.setArray = function (arr) {
        return setArray.apply(this, arguments).each(function () {
            if (this.metaDone || this.nodeType == 9 || $.isXMLDoc(this)) return;
            var data = "{}";
            if ($.meta.type == "class") {
                var m = $.meta.cre.exec(this.className);
                if (m)
                    data = m[1];
            } else if ($.meta.type == "elem") {
                if (!this.getElementsByTagName) return;
                var e = this.getElementsByTagName($.meta.name);
                if (e.length)
                    data = $.trim(e[0].innerHTML);
            } else if (this.getAttribute != undefined) {
                var attr = this.getAttribute($.meta.name);
                if (attr)
                    data = attr;
            }
            if (data.indexOf('{') < 0)
                data = "{" + data + "}";
            data = eval("(" + data + ")");
            if ($.meta.single)
                this[$.meta.single] = data;
            else
                $.extend(this, data);
            this.metaDone = true;
        });
    };
    $.fn.data = function () {
        return this[0][$.meta.single];
    };
})(jQuery);
(function ($) {
    var loggingEnabled = false;
    $.fn.jCarouselLite = function (o) {
        o = $.extend({
            btnPrev: null,
            btnNext: null,
            btnGo: null,
            btnDisabledClass: 'disabled',
            mouseWheel: false,
            auto: null,
            speed: 200,
            easing: null,
            vertical: false,
            circular: true,
            visible: 3,
            start: 0,
            scroll: 1,
            beforeStart: null,
            afterEnd: null
        }, o || {});
        return this.each(function () {
            var running = false,
                animCss = o.vertical ? "top" : "left",
                sizeCss = o.vertical ? "height" : "width";
            var div = $(this),
                ul = $("ul", div),
                tLi = $("li", ul),
                tl = tLi.size(),
                v = o.visible;
            div.bind("go", function (e, data) {
                go(data);
            });
            div.bind("scroll", function (e, data) {
                scroll(data);
            });
            div.bind("scrollLeftConditionally", function (e) {
                scrollLeftConditionally();
            });
            div.bind("updateButtons", function (e, data) {
                updateButtons();
            });
            if (o.circular) {
                ul.prepend(tLi.gt(tl - v - 1).clone()).append(tLi.lt(v).clone());
                o.start += v;
            }
            var li = $("li", ul),
                itemLength = li.size(),
                curr = o.start;
            div.css("visibility", "visible");
            li.css("overflow", "hidden").css("float", o.vertical ? "none" : "left").children().css("overflow", "hidden");
            ul.css("margin", "0").css("padding", "0").css("position", "relative").css("list-style-type", "none").css("z-index", "1");
            div.css("overflow", "hidden").css("position", "relative").css("z-index", "2").css("left", "0px");
            var liSize = o.vertical ? height(li) : width(li);
            var ulSize = liSize * itemLength;
            var divSize = liSize * v;
            li.css("width", li.width()).css("height", li.height());
            ul.css(sizeCss, ulSize + "px").css(animCss, -(curr * liSize));
            div.css(sizeCss, divSize + "px");
            if (o.btnPrev)
                $(o.btnPrev).click(function () {
                    return go(curr - o.scroll);
                });
            if (o.btnNext)
                $(o.btnNext).click(function () {
                    return go(curr + o.scroll);
                });
            if (o.btnGo)
                $.each(o.btnGo, function (i, val) {
                    $(val).click(function () {
                        return go(o.circular ? o.visible + i : i);
                    });
                });
            if (o.mouseWheel && div.mousewheel)
                div.mousewheel(function (e, d) {
                    return d > 0 ? (hasVisiblePrev() ? go(curr - o.scroll) : false) : (hasVisibleNext() ? go(curr + o.scroll) : false);
                });
            if (o.auto)
                setInterval(function () {
                    go(curr + o.scroll);
                }, o.auto + o.speed);
            updateButtons();

            function vis() {
                return li.gt(curr - 1).lt(v);
            };

            function updateButtons() {
                if (!o.circular) {
                    $(o.btnPrev + "," + o.btnNext).removeClass(o.btnDisabledClass);
                    $((curr - o.scroll < 0 && o.btnPrev) || []).addClass(o.btnDisabledClass);
                    $((curr + o.scroll > itemLength - v && o.btnNext) || []).addClass(o.btnDisabledClass);
                    if (!hasVisibleNext()) {
                        $(o.btnNext).addClass(o.btnDisabledClass);
                    }
                }
            }

            function hasVisiblePrev() {
                var result = false;
                var li = $("li", ul);
                for (i = curr; i > 0; i--) {
                    it = li.eq(i);
                    if (it.children(".toolbarWidget").is(":visible")) {
                        result = true;
                        break;
                    }
                }
                return result;
            }

            function hasVisibleNext() {
                var result = false;
                var li = $("li", ul);
                for (i = curr + v; i < li.size(); i++) {
                    it = li.eq(i);
                    if (it.children(".toolbarWidget").is(":visible")) {
                        result = true;
                        break;
                    }
                }
                return result;
            }

            function scrollLeftConditionally() {
                if (curr > $(".toolbarWidget:visible", ul).size() - v) {
                    scroll(-1);
                }
            }

            function scroll(count) {
                if (count == 0) {
                    return;
                }
                go(curr + count);
            }

            function go(to) {
                if (!running) {
                    log("go(" + to + "), curr:" + curr + " vis:" + v + " len:" + li.size());
                    if (o.beforeStart)
                        o.beforeStart.call(this, vis());
                    if (o.circular) {
                        if (to <= o.start - v - 1) {
                            ul.css(animCss, -((itemLength - (v * 2)) * liSize) + "px");
                            curr = to == o.start - v - 1 ? itemLength - (v * 2) - 1 : itemLength - (v * 2) - o.scroll;
                        } else if (to >= itemLength - v + 1) {
                            ul.css(animCss, -((v) * liSize) + "px");
                            curr = to == itemLength - v + 1 ? v + 1 : v + o.scroll;
                        } else curr = to;
                    } else {
                        if (to < 0 || to > itemLength - 1) {
                            return;
                        } else if (to > itemLength - v) {
                            if (curr < itemLength - v) {
                                curr = itemLength - v + 1;
                            } else {
                                return;
                            }
                        } else curr = to;
                    }
                    running = true;
                    ul.animate(animCss == "left" ? {
                        left: -(curr * liSize)
                    } : {
                        top: -(curr * liSize)
                    }, o.speed, o.easing, function () {
                        if (o.afterEnd)
                            o.afterEnd.call(this, vis());
                        running = false;
                    });
                    updateButtons();
                }
                return false;
            };
        });
    };

    function css(el, prop) {
        return parseInt($.css(el[0], prop)) || 0;
    };

    function width(el) {
        return el[0].offsetWidth + css(el, 'marginLeft') + css(el, 'marginRight');
    };

    function height(el) {
        return el[0].offsetHeight + css(el, 'marginTop') + css(el, 'marginBottom');
    };

    function log(message) {
        if (loggingEnabled && $.browser.mozilla && window.console != undefined) {
            console.log(message);
        }
    }
})(jQuery);