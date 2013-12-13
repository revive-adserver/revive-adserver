/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

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
	SearchWindow = window.open("","Search","toolbar=no,location=no,status=no,scrollbars=yes,width=700,height=500,screenX=100,screenY=100,pageXoffset=100,pageYoffset=100,resizable=yes");

	if (SearchWindow.frames.length == 0)
	{
		SearchWindow = window.open(path,"Search","toolbar=no,location=no,status=no,scrollbars=yes,width=800,height=600,screenX=100,screenY=100,pageXoffset=100,pageYoffset=100,resizable=yes");
	}
	else
	{
		SearchWindow.location.href = path;
		SearchWindow.focus();
	}
}

/*********************************************************/
/* Open Help window                                      */
/*********************************************************/

function help_window(path)
{
	SearchWindow = window.open("","Help","toolbar=no,location=no,status=no,scrollbars=yes,width=700,height=500,screenX=100,screenY=100,pageXoffset=100,pageYoffset=100,resizable=yes");

	if (SearchWindow.frames.length == 0)
	{
		SearchWindow = window.open(path,"Help","toolbar=no,location=no,status=no,scrollbars=yes,width=800,height=600,screenX=100,screenY=100,pageXoffset=100,pageYoffset=100,resizable=yes");
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
	if (document.login.username.value == '') {
		document.login.username.focus();
	} else {
		document.login.password.focus();
	}
}

/*********************************************************/
/* Copy the contents of a field to the clipboard         */
/*********************************************************/

function max_CopyClipboard(obj)
{
	obj = findObj(obj);

	if (obj) {
		window.clipboardData.setData('Text', obj.value);
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
