// $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2006 by the phpAdsNew developers                  */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



/*********************************************************/
/* Enable accesskeys in IE                               */
/*********************************************************/

var accessKeyEnabled = true;

function useAccessKey (evt) {
	if (accessKeyEnabled == true) {
		if (event.altKey) {
			event.srcElement.click();
		}
	} else {
		event.srcElement.blur();
		accessKeyEnabled = true;
	}
}

function releaseAccessKey() {
	if (accessKeyEnabled == false) {
		accessKeyEnabled = true;
	}
}

function initAccessKey() {
	if (navigator.appName == "Microsoft Internet Explorer") {
		for (i=0;i<document.all.length;i++) {
			a = document.all(i);
			if (a.tagName == 'A' && a.accessKey != '') {
				a.blur();
				a.onfocus = useAccessKey;
			}
		}
		if (event.altKey) {
			accessKeyEnabled = false;
			document.onkeyup = releaseAccessKey;
			setTimeout ('releaseAccessKey()', 100);
		}
	}
}


/*********************************************************/
/* General functions                                     */
/*********************************************************/

function findObj(n, d) { 
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
  d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function openWindow(theURL,winName,features) {
  window.open(theURL,winName,features);
  return false;
}

function setTextOfLayer(objName,newText) {
	while (obj = document.getElementById(objName)) {
		with (obj)
			if (document.layers) {document.write(unescape(newText)); document.close();}
			else innerHTML = unescape(newText);
		obj.id = '';
	}
}

function showLayer(obj) { 
	if (obj.style) 
		obj=obj.style; 
    
	obj.display = 'block'
}

function hideLayer(obj) { 
	if (obj.style) 
		obj=obj.style; 
    
	obj.display = 'none'
}


/*********************************************************/
/* Confirm form submit                                   */
/*********************************************************/

function confirm_submit(o, str)
{
	f = findObj(o);
	if(confirm(str)) f.submit();
}



/*********************************************************/
/* Open Search window                                    */
/*********************************************************/

function search_window(keyword, where)
{
	path = where+'?keyword='+keyword;
	SearchWindow = window.open("","Search","toolbar=no,location=no,status=no,scrollbars=yes,width=600,height=500,innerheight=50,screenX=100,screenY=100,pageXoffset=100,pageYoffset=100,resizable=yes");          

	if (SearchWindow.frames.length == 0) 
	{
		SearchWindow = window.open(path,"Search","toolbar=no,location=no,status=no,scrollbars=yes,width=700,height=600,innerheight=50,screenX=100,screenY=100,pageXoffset=100,pageYoffset=100,resizable=yes");
	}
	else
	{
		SearchWindow.location.href = path;
		SearchWindow.focus();
	}
}



/*********************************************************/
/* Focus the first field of the login screen             */
/*********************************************************/

function login_focus()
{
	if (document.login.phpAds_username.value == '')
		document.login.phpAds_username.focus();
	else
		document.login.phpAds_password.focus();
}


/*********************************************************/
/* Copy the contents of a field to the clipboard         */
/*********************************************************/

function phpAds_CopyClipboard(obj)
{
	obj = findObj(obj);
	
	if (obj) {
		window.clipboardData.setData('Text', obj.value);
	}
}


/*********************************************************/
/* Setup boxrow handlers                                 */
/*********************************************************/

function boxrow_init()
{
	var obj = document.body.getElementsByTagName("DIV");

	for (var i=0; i < obj.length; i++)
	{
		if (obj[i].className == 'boxrow')
		{
			obj[i].onmouseover = boxrow_over;
			obj[i].onmouseout = boxrow_leave;
			obj[i].onclick = boxrow_click;

			// Check for 1st generation childs -- input tags
			j = 0;

			while (j < obj[i].childNodes.length)
			{
				if (obj[i].childNodes[j].tagName == 'INPUT')
				obj[i].childNodes[j].onclick = boxrow_nonbubble;

				j++;
			}
		}
	}
}

function boxrow_over(e)
{
	if (!e && window.event)
		e = window.event;

	if (e.srcElement)
		o = e.srcElement;
	else
		o = e.target;

	// Find the DIV
	while (o.tagName != "DIV")
		o = o.parentNode;

		o.style.backgroundColor='#F6F6F6';
}

function boxrow_leave(e)
{
	if (!e && window.event)
		e = window.event;

	if (e.srcElement)
		o = e.srcElement;
	else
		o = e.target;

	// Find the DIV
	while (o.tagName != "DIV")
		o = o.parentNode;

	o.style.backgroundColor='#FFFFFF';
}

function boxrow_click(e)
{
	if (!e && window.event)
		e = window.event;

	if (e.srcElement)
		o = e.srcElement;
	else
		o = e.target;

	// Find the DIV
	while (o.tagName != "DIV")
		o = o.parentNode;

	// Find the checkbox
	i = 0;

	while (i < o.childNodes.length)
	{
		if (o.childNodes[i].tagName == 'INPUT')
		{
			o.childNodes[i].checked = !o.childNodes[i].checked;
			return true;
		}

		i++;
	}
}

function boxrow_nonbubble(e)
{
	if (!e && window.event)
    e = window.event;
  
	if (e.stopPropagation) 
		e.stopPropagation(); 
	else 
		e.cancelBubble = true; 
}

function cascadebox_change(o)
{
	var sel = o.options[o.selectedIndex].value;
	var baseid = o.id + '_';
	var matchid = baseid + (sel ? sel + '_' : '');
	var obj = document.body.getElementsByTagName("DIV");
	
	for (var i=0; i < obj.length; i++)
	{
		if (obj[i].id.indexOf(baseid) == 0)
		{
			obj[i].style.display = obj[i].id.indexOf(matchid) == 0 ? '' : 'none';
		}
	}
}


/*********************************************************/
/* Setup all event handlers for use on the page          */
/*********************************************************/

function initPage()
{
	initAccessKey();
	boxrow_init();
}
