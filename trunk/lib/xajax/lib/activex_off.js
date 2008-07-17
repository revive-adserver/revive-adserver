/*****
A drop in replacement for XMLHttpRequest object

Usage:
	Add to between the <head> tags,
	<!--[if IE]><script type="text/javascript" src="activex_off.js"></script><![endif]-->

*****/
var useBackupXMLObject = false;

xajax.oldGetRequestObject = xajax.getRequestObject;
xajax.getRequestObject = function() {
	var req = null;
	if (useBackupXMLObject == false)
	{
		this.temp = this.DebugMessage;
		this.DebugMessage = function() {};
		req = this.oldGetRequestObject();
		this.DebugMessage = this.temp;
		this.temp = null;
		if (req)
			return req;
		useBackupXMLObject = true;
	}
	try {
		req = new BackupXMLObject();
	} catch (e) {}
	return req;
}

function stringify(obj)
{
	if (typeof obj == 'string')
		return "'"+obj+"'";
	first = true;
	objstring = "{";
	for (i in obj)
	{
		if (first)
			first = false;
		else
			objstring += ",";
		objstring += i+":" + stringify(obj[i]);
	}
	objstring += "}";
	return objstring;
}

xajax.realCall = xajax.call;
xajax.call = null;
xajax.pageLoaded = false;
xajax.call = function(func, params)
{
	if (this.pageLoaded)
	{
		return this.realCall.apply(this, arguments);
	}
	state = document.readyState;
	if (state == 'complete' || state == 4) {
		this.pageLoaded = true;
		this.call = this.realCall;
		return this.realCall.apply(this, arguments);
	} else {
		paramstring = stringify(params);
		setTimeout("xajax.call('"+func+"',"+paramstring+");",100);
		return true;
	}
}

function BackupXMLObject() {
	this.uri = null;
	this.async = null;
	this.status = null;
	this.readyState = 0;
	this.responseText = '';
	this.statusText = null;
	this.requestType = null;
	this.responseXML = null;
	this.onreadystatechange = function(){};
	this.xmlisland = null;

	this.open = function(requestType, uri, async)
	{
		this.requestType = requestType.toLowerCase();
		this.uri = uri;
		this.async = async;
	}

	this.setRequestHeader = function(headerKey, headerValue)
	{
		if (this.requestType == 'post')
			throw new Error();
	}

	this.send = function(postData)
	{
		xmlislandId = 'xml'+(new Date().getTime());
		var xmlisland = document.createElement("xml");
		xmlisland.id = xmlislandId;
		xmlisland.maker = this;
		xmlisland.src = this.uri;
		document.body.appendChild(xmlisland);
		xmlisland.XMLDocument.onreadystatechange = function() {
			xmlisland.maker.readyState = xmlisland.XMLDocument.readyState;
			xmlisland.maker.responseXML = xmlisland.XMLDocument;
			xmlisland.maker.status = 200;
			if (xmlisland.XMLDocument && xmlisland.XMLDocument.documentElement)
				xmlisland.maker.responseText = xmlisland.XMLDocument.documentElement.xml;
			xmlisland.maker.onreadystatechange();
			if (xmlisland.XMLDocument.readyState == 4)
			{
				document.body.removeChild(xmlisland);
				delete xmlisland;
				xmlisland = null;
			}
		}
	}

}
