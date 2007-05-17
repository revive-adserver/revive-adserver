/**
 * FlashObject v1.3d: Flash detection and embed - http://blog.deconcept.com/flashobject/
 *
 * FlashObject is (c) 2006 Geoff Stearns and is released under the MIT License:
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

if(typeof net == "undefined") var net = new Object();
if(typeof net.m3 == "undefined") net.m3 = new Object();
if(typeof net.m3.util == "undefined") net.m3.util = new Object();
if(typeof net.m3.FlashObjectUtil == "undefined") net.m3.FlashObjectUtil = new Object();
net.m3.FlashObject = function(swf, id, w, h, ver, c, useExpressInstall, quality, xiRedirectUrl, redirectUrl, detectKey){
  if (!document.createElement || !document.getElementById) return;
  this.DETECT_KEY = detectKey ? detectKey : 'detectflash';
  this.skipDetect = net.m3.util.getRequestParameter(this.DETECT_KEY);
  this.params = new Object();
  this.variables = new Object();
  this.attributes = new Array();
  this.useExpressInstall = useExpressInstall;

  if(swf) this.setAttribute('swf', swf);
  if(id) this.setAttribute('id', id);
  if(w) this.setAttribute('width', w);
  if(h) this.setAttribute('height', h);
  if(ver) this.setAttribute('version', new net.m3.PlayerVersion(ver.toString().split(".")));
  this.installedVer = net.m3.FlashObjectUtil.getPlayerVersion(this.getAttribute('version'), useExpressInstall);
  if(c) this.addParam('bgcolor', c);
  var q = quality ? quality : 'high';
  this.addParam('quality', q);
  var xir = (xiRedirectUrl) ? xiRedirectUrl : window.location;
  this.setAttribute('xiRedirectUrl', xir);
  this.setAttribute('redirectUrl', '');
  if(redirectUrl) this.setAttribute('redirectUrl', redirectUrl);
}
net.m3.FlashObject.prototype = {
  setAttribute: function(name, value){
    this.attributes[name] = value;
  },
  getAttribute: function(name){
    return this.attributes[name];
  },
  addParam: function(name, value){
    this.params[name] = value;
  },
  getParams: function(){
    return this.params;
  },
  addVariable: function(name, value){
    this.variables[name] = value;
  },
  getVariable: function(name){
    return this.variables[name];
  },
  getVariables: function(){
    return this.variables;
  },
  createParamTag: function(n, v){
    var p = document.createElement('param');
    p.setAttribute('name', n);
    p.setAttribute('value', v);
    return p;
  },
  getVariablePairs: function(){
    var variablePairs = new Array();
    var key;
    var variables = this.getVariables();
    for(key in variables){
      variablePairs.push(key +"="+ variables[key]);
    }
    return variablePairs;
  },
  getFlashHTML: function() {
    var flashNode = "";
    if (navigator.plugins && navigator.mimeTypes && navigator.mimeTypes.length) { // netscape plugin architecture
      if (this.getAttribute("doExpressInstall")) this.addVariable("MMplayerType", "PlugIn");
      flashNode = '<embed type="application/x-shockwave-flash" src="'+ this.getAttribute('swf') +'" width="'+ this.getAttribute('width') +'" height="'+ this.getAttribute('height') +'"';
      flashNode += ' id="'+ this.getAttribute('id') +'" name="'+ this.getAttribute('id') +'" ';
      var params = this.getParams();
       for(var key in params){ flashNode += [key] +'="'+ params[key] +'" '; }
      var pairs = this.getVariablePairs().join("&");
       if (pairs.length > 0){ flashNode += 'flashvars="'+ pairs +'"'; }
      flashNode += '/>';
    } else { // PC IE
      if (this.getAttribute("doExpressInstall")) this.addVariable("MMplayerType", "ActiveX");
      flashNode = '<object id="'+ this.getAttribute('id') +'" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+ this.getAttribute('width') +'" height="'+ this.getAttribute('height') +'">';
      flashNode += '<param name="movie" value="'+ this.getAttribute('swf') +'" />';
      var params = this.getParams();
       for(var key in params) {
        flashNode += '<param name="'+ key +'" value="'+ params[key] +'" />';
       }
      var pairs = this.getVariablePairs().join("&");
       if(pairs.length > 0) flashNode += '<param name="flashvars" value="'+ pairs +'" />';
      flashNode += "</object>";
    }
    return flashNode;
  },
  write: function(elementId){
    if(this.useExpressInstall) {
      // check to see if we need to do an express install
      var expressInstallReqVer = new net.m3.PlayerVersion([6,0,65]);
      if (this.installedVer.versionIsValid(expressInstallReqVer) && !this.installedVer.versionIsValid(this.getAttribute('version'))) {
        this.setAttribute('doExpressInstall', true);
        this.addVariable("MMredirectURL", escape(this.getAttribute('xiRedirectUrl')));
        document.title = document.title.slice(0, 47) + " - Flash Player Installation";
        this.addVariable("MMdoctitle", document.title);
      }
    } else {
      this.setAttribute('doExpressInstall', false);
    }
    if(this.skipDetect || this.getAttribute('doExpressInstall') || this.installedVer.versionIsValid(this.getAttribute('version'))){
      var n = (typeof elementId == 'string') ? document.getElementById(elementId) : elementId;
      n.innerHTML = this.getFlashHTML();
    }else{
      if(this.getAttribute('redirectUrl') != "") {
        document.location.replace(this.getAttribute('redirectUrl'));
      }
    }
  }
}

/* ---- detection functions ---- */
net.m3.FlashObjectUtil.getPlayerVersion = function(reqVer, xiInstall){
  var PlayerVersion = new net.m3.PlayerVersion(0,0,0);
  if(navigator.plugins && navigator.mimeTypes.length){
    var x = navigator.plugins["Shockwave Flash"];
    if(x && x.description) {
      PlayerVersion = new net.m3.PlayerVersion(x.description.replace(/([a-z]|[A-Z]|\s)+/, "").replace(/(\s+r|\s+b[0-9]+)/, ".").split("."));
    }
  }else{
    try{
      var axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
      for (var i=3; axo!=null; i++) {
        axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash."+i);
        PlayerVersion = new net.m3.PlayerVersion([i,0,0]);
      }
    }catch(e){}
    if (reqVer && PlayerVersion.major > reqVer.major) return PlayerVersion; // version is ok, skip minor detection
    // this only does the minor rev lookup if the user's major version 
    // is not 6 or we are checking for a specific minor or revision number
    // see http://blog.deconcept.com/2006/01/11/getvariable-setvariable-crash-internet-explorer-flash-6/
    if (!reqVer || ((reqVer.minor != 0 || reqVer.rev != 0) && PlayerVersion.major == reqVer.major) || PlayerVersion.major != 6 || xiInstall) {
      try{
        PlayerVersion = new net.m3.PlayerVersion(axo.GetVariable("$version").split(" ")[1].split(","));
      }catch(e){}
    }
  }
  return PlayerVersion;
}
net.m3.PlayerVersion = function(arrVersion){
  this.major = parseInt(arrVersion[0]) || 0;
  this.minor = parseInt(arrVersion[1]) || 0;
  this.rev = parseInt(arrVersion[2]) || 0;
}
net.m3.PlayerVersion.prototype.versionIsValid = function(fv){
  if(this.major < fv.major) return false;
  if(this.major > fv.major) return true;
  if(this.minor < fv.minor) return false;
  if(this.minor > fv.minor) return true;
  if(this.rev < fv.rev) return false;
  return true;
}
/* ---- get value of query string param ---- */
net.m3.util = {
  getRequestParameter: function(param){
    var q = document.location.search || document.location.href.hash;
    if(q){
      var startIndex = q.indexOf(param +"=");
      var endIndex = (q.indexOf("&", startIndex) > -1) ? q.indexOf("&", startIndex) : q.length;
      if (q.length > 1 && startIndex > -1) {
        return q.substring(q.indexOf("=", startIndex)+1, endIndex);
      }
    }
    return "";
  },
  removeChildren: function(n){
    while (n.hasChildNodes()) n.removeChild(n.firstChild);
  }
}

/* add Array.push if needed (ie5) */
if (Array.prototype.push == null) { Array.prototype.push = function(item) { this[this.length] = item; return this.length; }}

/* add some aliases for ease of use/backwards compatibility */
var getQueryParamValue = net.m3.util.getRequestParameter;
var FlashObject = net.m3.FlashObject;

/* Set a document variable to track if this code has been included on the current page */
document.mmm_fo = 1;
