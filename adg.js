var phpAds_adSenseDeliveryDone = false;
var phpAds_adSensePx;
var phpAds_adSensePy;

function phpAds_adSenseLog(obj)
{
	if (typeof obj.parentNode != 'undefined')
	{
		var t = obj.parentNode.innerHTML;

		var params = t.match(/<!-- openads=([^ ]*) bannerid=([^ ]*) zoneid=([^ ]*) source=([^ ]*) -->/);
		
		if (params)
		{
			var cb = new String (Math.random());
			cb = cb.substring(2,11);
			
			var i = new Image();
			i.src = params[1] + '/adclick.php?bannerid=' + params[2] + '&zoneid=' + params[3] + '&source=' + params[4] + '&trackonly=1&cb=' + cb;
		}
	}
}

function phpAds_adSenseGetMouse(e)
{
	phpAds_adSensePx = e.pageX;
	phpAds_adSensePy = e.clientY;
}

function phpAds_adSenseFindX(obj)
{
	var x = 0;
	while (obj)
	{
		x += obj.offsetLeft;
		obj = obj.offsetParent;
	}
	return x;
}

function phpAds_adSenseFindY(obj)
{
	var y = 0;
	while (obj)
	{
		y += obj.offsetTop;
		obj = obj.offsetParent;
	}
	
	return y;
}

function phpAds_adSensePageExit(e)
{
	var ad = document.getElementsByTagName("iframe");
	for (var i = 0; i < ad.length; i++)
	{
		var adLeft = phpAds_adSenseFindX(ad[i]);
		var adTop = phpAds_adSenseFindY(ad[i]);
		var adRight = parseInt(adLeft) + parseInt(ad[i].width) + 15;
		var adBottom = parseInt(adTop) + parseInt(ad[i].height) + 10;
		var inFrameX = (phpAds_adSensePx > (adLeft - 10) && phpAds_adSensePx < adRight);
		var inFrameY = (phpAds_adSensePy > (adTop - 10) && phpAds_adSensePy < adBottom);
		
		if (inFrameY && inFrameX)
			phpAds_adSenseLog(ad[i]);
	}
}

function phpAds_adSenseInit()
{
	if (document.all && !window.opera)
	{ 
		//ie
		var el = document.getElementsByTagName("iframe");
	
		for (var i = 0; i < el.length; i++)
		{
			if (el[i].src.indexOf('googlesyndication.com') > -1)
			{
				el[i].onfocus = function()
				{
					phpAds_adSenseLog(this);
				}
			}
		}
	}
	else
	{ 
		// firefox
		window.addEventListener('beforeunload', phpAds_adSensePageExit, false);
		window.addEventListener('mousemove', phpAds_adSenseGetMouse, true);
	}
}

function phpAds_adSenseDelivery()
{
	if (phpAds_adSenseDeliveryDone)
		return;
	
	phpAds_adSenseDeliveryDone = true;

	if(typeof window.addEventListener != 'undefined')
	{
		//.. gecko, safari, konqueror and standard
		window.addEventListener('load', phpAds_adSenseInit, false);
	}
	else if(typeof document.addEventListener != 'undefined')
	{
		//.. opera 7
		document.addEventListener('load', phpAds_adSenseInit, false);
	}
	else if(typeof window.attachEvent != 'undefined')
	{
		//.. win/ie
		window.attachEvent('onload', phpAds_adSenseInit);
	}
	else
	{
		//.. mac/ie5 and anything else that gets this far
		
		//if there's an existing onload function
		if(typeof window.onload == 'function')
		{
			//store it
			var existing = onload;
			
			//add new onload handler
			window.onload = function()
			{
				//call existing onload function
				existing();
				
				//call adsense_init onload function
				phpAds_adSenseInit();
			};
		}
		else
		{
			//setup onload function
			window.onload = phpAds_adSenseInit;
		}
	}
}

phpAds_adSenseDelivery();
