// $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



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
/* Check form                                            */
/*********************************************************/

function phpAds_formSetRequirements(obj, descr, req, check)
{
	obj = findObj(obj);
	
	// set properties
	if (obj)
	{
		obj.validateReq = req;
		obj.validateCheck = check;
		obj.validateDescr = descr;
	}
}

function phpAds_formSetUnique(obj, unique)
{
	obj = findObj(obj);
	
	// set properties
	if (obj)
		obj.validateUnique = unique;
}

function phpAds_formUpdate(obj)
{
	err = false;
	val = obj.value;
	
	if ((val == '' || val == '-' || val == 'http://') && obj.validateReq == true)
		err = true;
	
	if (err == false && val != '')
	{
		if (obj.validateCheck == 'url' &&
			val.indexOf('http://') != 0)
			err = true;
			
		if (obj.validateCheck == 'email' && 
			(val.indexOf('@') < 1 || val.indexOf('@') == (val.length - 1)))
			err = true;
		
		if (obj.validateCheck == 'number*' &&
			(isNaN(val) && val != '*' || val < 0))
			err = true;

		if (obj.validateCheck == 'number+' &&
			(isNaN(val) && val != '-'  || val < 0))
			err = true;
		
		if (obj.validateCheck == 'unique')
		{
			if (obj.validateUnique.indexOf('|'+obj.value+'|') > -1)
				err = true;
		}
	}
	
	// Change class
	if (err)
		obj.className='error';
	else
		obj.className='flat';
	
	return (err);
}


function phpAds_formCheck(f)
{
	var noerrors = true;
	var first	 = false;
	var fields   = new Array();

	// Check for errors
	for (var i = 0; i < f.elements.length; i++)
	{
		if (f.elements[i].validateCheck ||
			f.elements[i].validateReq)
		{
			err = phpAds_formUpdate (obj = f.elements[i]);
			
			if (err)
			{
				if (first == false) first = i;
				
				fields.push(f.elements[i].validateDescr);
				noerrors = false;
			}
		}
	}
	
	if (noerrors == false)
	{
		alert ('The following fields contain errors:                     \n\n- ' + 
			   fields.join('\n- ') + 
			   '\n\nBefore you can continue you need to \ncorrect these errors.\n');
		
		// Select field with first error
		f.elements[first].select();
		f.elements[first].focus();
	}
	
	return (noerrors);
}

function phpAds_CopyClipboard(obj)
{
	obj = findObj(obj);
	
	if (obj) {
		window.clipboardData.setData('Text', obj.value);
	}
}