/**
 * SWFObject v1.5: Flash Player detection and embed - http://blog.deconcept.com/swfobject/
 *
 * SWFObject is (c) 2007 Geoff Stearns and is released under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Extended for use in Openads
 *
 * The compressed version of this file is used in the delivery engine
 * If you make changes to this file, recompress it:
 *  - http://alex.dojotoolkit.org/shrinksafe/
 * and update the copy in /www/delivery/fl.js
 *
 */
/*jslint indent:4*/
/*global window*/
(function () {
    var org = window.org || {};
    org.openx = window.org.openx || {};
    org.openx.util = window.org.openx.util || {};
    org.openx.SWFObjectUtil = window.org.openx.SWFObjectUtil || {};

    var noop = function () {
        return undefined;
    };

    window.org.openx.SWFObject = function (swf, id, w, h, ver, c, quality, xiRedirectUrl, redirectUrl, detectKey) {
        if (!document.getElementById) { return; }
        this.DETECT_KEY = detectKey || 'detectflash';
        this.skipDetect = org.openx.util.getRequestParameter(this.DETECT_KEY);
        this.params = {};
        this.variables = {};
        this.attributes = [];
        if (swf) { this.setAttribute('swf', swf); }
        if (id) { this.setAttribute('id', id); }
        if (w) { this.setAttribute('width', w); }
        if (h) { this.setAttribute('height', h); }
        if (ver) { this.setAttribute('version', new window.org.openx.PlayerVersion(ver.toString().split("."))); }
        this.installedVer = org.openx.SWFObjectUtil.getPlayerVersion();
        if (!window.opera && document.all && this.installedVer.major > 7) {
            // only add the onunload cleanup if the Flash Player version supports External Interface and we are in IE
            org.openx.SWFObject.doPrepUnload = true;
        }
        if (c) { this.addParam('bgcolor', c); }
        var q = quality || 'high';
        this.addParam('quality', q);
        this.setAttribute('useExpressInstall', false);
        this.setAttribute('doExpressInstall', false);
        var xir = xiRedirectUrl || window.location;
        this.setAttribute('xiRedirectUrl', xir);
        this.setAttribute('redirectUrl', '');
        if (redirectUrl) { this.setAttribute('redirectUrl', redirectUrl); }
    };
    org.openx.SWFObject.prototype = {
        useExpressInstall: function (path) {
            this.xiSWFPath = !path ? "expressinstall.swf" : path;
            this.setAttribute('useExpressInstall', true);
        },
        setAttribute: function (name, value) {
            this.attributes[name] = value;
        },
        getAttribute: function (name) {
            return this.attributes[name];
        },
        addParam: function (name, value) {
            this.params[name] = value;
        },
        getParams: function () {
            return this.params;
        },
        addVariable: function (name, value) {
            this.variables[name] = value;
        },
        getVariable: function (name) {
            return this.variables[name];
        },
        getVariables: function () {
            return this.variables;
        },
        getVariablePairs: function () {
            var variablePairs = [];
            var key;
            var variables = this.getVariables();
            for (key in variables) {
                if (variables.hasOwnProperty(key)) {
                    variablePairs[variablePairs.length] = key + "=" + variables[key];
                }
            }
            return variablePairs;
        },
        getSWFHTML: function () {
            var swfNode = '',
                attrDoExpressInstall    = this.getAttribute('doExpressInstall'),
                attrId                  = this.getAttribute('id'),
                attrSwf                 = this.getAttribute('swf'),
                attrWidth               = this.getAttribute('width'),
                attrHeight              = this.getAttribute('height'),
                attrStyle               = this.getAttribute('style'),
                params                  = this.getParams(),
                pairs                   = this.getVariablePairs().join('&'),
                key;

            if (window.navigator.plugins && window.navigator.mimeTypes && window.navigator.mimeTypes.length) { // netscape plugin architecture
                if (attrDoExpressInstall) {
                    this.addVariable("MMplayerType", "PlugIn");
                    this.setAttribute('swf', this.xiSWFPath);
                }
                swfNode = '<embed type="application/x-shockwave-flash" src="' +
                    attrSwf + '" width="' + attrWidth + '" height="' + attrHeight +
                    '" style="' + attrStyle + '"' +
                    ' id="' + attrId + '" name="' + attrId + '" ';

                for (key in params) {
                    if (params.hasOwnProperty(key)) {
                        swfNode += [key] + '="' + params[key] + '" ';
                    }
                }

                if (pairs.length > 0) {
                    swfNode += 'flashvars="' + pairs + '"';
                }
                swfNode += '/>';
            } else { // PC IE
                if (attrDoExpressInstall) {
                    this.addVariable('MMplayerType', 'ActiveX');
                    this.setAttribute('swf', this.xiSWFPath);
                }
                swfNode = '<object id="' + attrId +
                    '" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="' +
                    attrWidth + '" height="' + attrHeight + '" style="' +
                    attrStyle + '">';

                swfNode += '<param name="movie" value="' + this.getAttribute('swf') + '" />';

                for (key in params) {
                    if (params.hasOwnProperty(key)) {
                        swfNode += '<param name="' + key + '" value="' + params[key] + '" />';
                    }
                }

                if (pairs.length > 0) {
                    swfNode += '<param name="flashvars" value="' + pairs + '" />';
                }
                swfNode += '</object>';
            }
            return swfNode;
        },
        write: function (elementId) {
            var attrDoExpressInstall = this.getAttribute('useExpressInstall'),
                attrXiRedirectUrl = this.getAttribute('xiRedirectUrl'),
                attrVersion = this.getAttribute('version'),
                attrRedirectUrl = this.getAttribute('redirectUrl'),
                element = typeof elementId === 'string' ? document.getElementById(elementId) : elementId;
            if (attrDoExpressInstall) {
                // check to see if we need to do an express install
                var expressInstallReqVer = new org.openx.PlayerVersion([6, 0, 65]);
                if (this.installedVer.versionIsValid(expressInstallReqVer) && !this.installedVer.versionIsValid(attrVersion)) {
                    this.setAttribute('doExpressInstall', true);
                    this.addVariable('MMredirectURL', window.escape(attrXiRedirectUrl));
                    document.title = document.title.slice(0, 47) + ' - Flash Player Installation';
                    this.addVariable('MMdoctitle', document.title);
                }
            }
            if (this.skipDetect || attrDoExpressInstall || this.installedVer.versionIsValid(attrVersion)) {
                element.innerHTML = this.getSWFHTML();
                return true;
            }
            if (attrRedirectUrl) {
                document.location.replace(attrRedirectUrl);
            }
            return false;
        }
    };

    /* ---- detection functions ---- */
    org.openx.SWFObjectUtil.getPlayerVersion = function () {
        var PlayerVersion = new org.openx.PlayerVersion([0, 0, 0]),
            x,
            axo,
            counter;
        if (window.navigator.plugins && window.navigator.mimeTypes.length) {
            x = window.navigator.plugins['Shockwave Flash'];
            if (x && x.description) {
                PlayerVersion = new org.openx.PlayerVersion(x.description.replace(/([a-zA-Z]|\s)+/, '').replace(/(\s+r|\s+b[0-9]+)/, '.').split('.'));
            }
        } else if (window.navigator.userAgent && window.navigator.userAgent.indexOf('Windows CE') >= 0) { // if Windows CE
            axo = 1;
            counter = 3;
            while (axo) {
                try {
                    counter++;
                    axo = new window.ActiveXObject('ShockwaveFlash.ShockwaveFlash.' + counter);
    //              document.write("player v: "+ counter);
                    PlayerVersion = new org.openx.PlayerVersion([counter, 0, 0]);
                } catch (e) {
                    axo = null;
                }
            }
        } else { // Win IE (non mobile)
            // do minor version lookup in IE, but avoid fp6 crashing issues
            // see http://blog.deconcept.com/2006/01/11/getvariable-setvariable-crash-internet-explorer-flash-6/
            try {
                axo = new window.ActiveXObject('ShockwaveFlash.ShockwaveFlash.7');
            } catch (e) {
                try {
                    axo = new window.ActiveXObject("ShockwaveFlash.ShockwaveFlash.6");
                    PlayerVersion = new org.openx.PlayerVersion([6, 0, 21]);
                    axo.AllowScriptAccess = 'always'; // error if player version < 6.0.47 (thanks to Michael Williams @ Adobe for this code)
                } catch (f) {
                    if (PlayerVersion.major === 6) {
                        return PlayerVersion;
                    }
                }
                try {
                    axo = new window.ActiveXObject('ShockwaveFlash.ShockwaveFlash');
                } catch (ignore) {}
            }
            if (axo !== null) {
                PlayerVersion = new org.openx.PlayerVersion(axo.GetVariable('$version').split(' ')[1].split(','));
            }
        }
        return PlayerVersion;
    };
    org.openx.PlayerVersion = function (arrVersion) {
        this.major = arrVersion[0] ? parseInt(arrVersion[0], 10) : 0;
        this.minor = arrVersion[1] ? parseInt(arrVersion[1], 10) : 0;
        this.rev = arrVersion[2] ? parseInt(arrVersion[2], 10) : 0;
    };
    org.openx.PlayerVersion.prototype.versionIsValid = function (fv) {
        if (this.major < fv.major) {return false; }
        if (this.major > fv.major) {return true; }
        if (this.minor < fv.minor) {return false; }
        if (this.minor > fv.minor) {return true; }
        if (this.rev < fv.rev) {return false; }
        return true;
    };
    /* ---- get value of query string param ---- */
    org.openx.util = {
        getRequestParameter: function (param) {
            var q = document.location.search || document.location.hash,
                pairs,
                i;
            if (param === null) {return q; }
            if (q) {
                pairs = q.substring(1).split('&');
                for (i = 0; i < pairs.length; i++) {
                    if (pairs[i].substring(0, pairs[i].indexOf('=')) === param) {
                        return pairs[i].substring((pairs[i].indexOf('=') + 1));
                    }
                }
            }
            return '';
        }
    };
    /* fix for video streaming bug */
    org.openx.SWFObjectUtil.cleanupSWFs = function () {
        var objects = document.getElementsByTagName('object'),
            i,
            x;
        for (i = objects.length - 1; i >= 0; i--) {
            objects[i].style.display = 'none';
            for (x in objects[i]) {
                if (typeof objects[i][x] === 'function') {
                    objects[i][x] = noop;
                }
            }
        }
    };
    // fixes bug in some fp9 versions see http://blog.deconcept.com/2006/07/28/swfobject-143-released/
    if (org.openx.SWFObject.doPrepUnload) {
        if (!org.openx.unloadSet) {
            org.openx.SWFObjectUtil.prepUnload = function () {
                window.__flash_unloadHandler = noop;
                window.__flash_savedUnloadHandler = noop;
                window.attachEvent('onunload', org.openx.SWFObjectUtil.cleanupSWFs);
            };
            window.attachEvent('onbeforeunload', org.openx.SWFObjectUtil.prepUnload);
            org.openx.unloadSet = true;
        }
    }
    /* add document.getElementById if needed (mobile IE < 5) */
    if (!document.getElementById && document.all) {
        document.getElementById = function (id) {
            return document.all[id];
        };
    }

    /* add some aliases for ease of use/backwards compatibility */
    window.getQueryParamValue = org.openx.util.getRequestParameter;
    window.FlashObject = org.openx.SWFObject; // for legacy support
    window.SWFObject = org.openx.SWFObject;

    /* Set a document variable to track if this code has been included on the current page */
    document.mmm_fo = 1;
}());
