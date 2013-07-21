<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

// Invocation Types
$GLOBALS['strInvocationRemote']			= "Vzdálené volání";
$GLOBALS['strInvocationRemoteNoCookies']	= "Vzdálené volání - bez cookies";
$GLOBALS['strInvocationJS']			= "Vzdálené volání Javascriptem";
$GLOBALS['strInvocationIframes']		= "Vzdálené volání pomocí Frames";
$GLOBALS['strInvocationXmlRpc']			= "Vzdálené volání pomocí XML-RPC";
$GLOBALS['strInvocationCombined']		= "Kombinované vzdálené volání";
$GLOBALS['strInvocationPopUp']			= "Pop-up";
$GLOBALS['strInvocationAdLayer']		= "Interstitial nebo plovoucí DHTML";
$GLOBALS['strInvocationLocal']			= "Lokální mód";


// Other
$GLOBALS['strCopyToClipboard']			= "Kopírovat do schránky";


// Measures
$GLOBALS['strAbbrPixels']			= "px";
$GLOBALS['strAbbrSeconds']			= "vteřin";


// Common Invocation Parameters
$GLOBALS['strInvocationWhat']			= "Volba banneru";
$GLOBALS['strInvocationClientID']		= "Inzerent";
$GLOBALS['strInvocationCampaignID']			= "Skrytá kampaň";
$GLOBALS['strInvocationTarget']			= "Cílový frame";
$GLOBALS['strInvocationSource']			= "Zdroj";
$GLOBALS['strInvocationWithText']		= "Zobrazit text pod bannerem";
$GLOBALS['strInvocationDontShowAgain']		= "Nezobrazovat banner znova na stejné stránce";
$GLOBALS['strInvocationDontShowAgainCampaign']		= "Nezobrazovat banner ze stejné kampaně znova na stejné stránce";
$GLOBALS['strInvocationTemplate'] 		= "Uložit banner v proměnné aby mohl být použit v šabloně";
$GLOBALS['strInvocationBannerID']					= "ID banneru";


// Iframe
$GLOBALS['strIFrameRefreshAfter']		= "Obnovit po";
$GLOBALS['strIframeResizeToBanner']		= "Zmenit velikost iframe podle banneru";
$GLOBALS['strIframeMakeTransparent']		= "Udělat iframe průhledný";
$GLOBALS['strIframeIncludeNetscape4']		= "Vložit Nestcape 4 kompatibilní ilayer";


// PopUp
$GLOBALS['strPopUpStyle']			= "Typ Pop-upu";
$GLOBALS['strPopUpStylePopUp']			= "Pop-up";
$GLOBALS['strPopUpStylePopUnder']		= "Pop-under";
$GLOBALS['strPopUpCreateInstance']		= "Zobrazit když je pop-up vytvořen";
$GLOBALS['strPopUpImmediately']			= "Okamžitě";
$GLOBALS['strPopUpOnClose']			= "Když je zavřena stránka";
$GLOBALS['strPopUpAfterSec']			= "Po";
$GLOBALS['strAutoCloseAfter']			= "Automaticky zavřít po";
$GLOBALS['strPopUpTop']				= "Výchozí pozice (zhora)";
$GLOBALS['strPopUpLeft']			= "Výchozí pozice (zleva)";
$GLOBALS['strWindowOptions']		= "Parametry okna";
$GLOBALS['strShowToolbars']			= "Panel nástrojů";
$GLOBALS['strShowLocation']			= "Umístění";
$GLOBALS['strShowMenubar']			= "Menu";
$GLOBALS['strShowStatus']			= "Stavový řádek";
$GLOBALS['strWindowResizable']		= "Měnitelná velikost";
$GLOBALS['strShowScrollbars']		= "Skrolovatelný";


// XML-RPC
$GLOBALS['strXmlRpcLanguage']			= "Jazyk hostitele";


// AdLayer
$GLOBALS['strAdLayerStyle']			= "Styl";

$GLOBALS['strAlignment']			= "Zarovnání";
$GLOBALS['strHAlignment']			= "Horizontální zarovnání";
$GLOBALS['strLeft']				= "Vlevo";
$GLOBALS['strCenter']				= "Na střed";
$GLOBALS['strRight']				= "Vpravo";

$GLOBALS['strVAlignment']			= "Vertikální zarovnání";
$GLOBALS['strTop']				= "Nahoru";
$GLOBALS['strMiddle']				= "Na střed";
$GLOBALS['strBottom']				= "Dolů";

$GLOBALS['strAutoCollapseAfter']		= "Automaticky sloučit po";
$GLOBALS['strCloseText']			= "Zavřít text";
$GLOBALS['strClose']				= "[Zavřít]";
$GLOBALS['strBannerPadding']			= "Odsazení banneru";

$GLOBALS['strHShift']				= "Horizontání posun";
$GLOBALS['strVShift']				= "Vertikální posun";

$GLOBALS['strShowCloseButton']			= "Zobrazit tlačítko zavřít";
$GLOBALS['strBackgroundColor']			= "Barva pozadí";
$GLOBALS['strBorderColor']			= "Barva okraje";

$GLOBALS['strDirection']			= "Směr";
$GLOBALS['strLeftToRight']			= "Zleva do prava";
$GLOBALS['strRightToLeft']			= "Zprava do leva";
$GLOBALS['strLooping']				= "Smyčka";
$GLOBALS['strAlwaysActive']			= "Vždy aktivní";
$GLOBALS['strSpeed']				= "Rychlost";
$GLOBALS['strPause']				= "Pauza";
$GLOBALS['strLimited']				= "Omezený";
$GLOBALS['strLeftMargin']			= "Levý okraj";
$GLOBALS['strRightMargin']			= "Pravý okraj";
$GLOBALS['strTransparentBackground']		= "Průhledné pozadí";

$GLOBALS['strSmoothMovement']		= "Jemný pohyb";
$GLOBALS['strHideNotMoving']		= "Skrýt banner když se nehýbe kurzor";
$GLOBALS['strHideDelay']			= "Prodleva před skrytím banneru";
$GLOBALS['strHideTransparancy']		= "Průhlednost skrytého banneru";


$GLOBALS['strAdLayerStyleName']['geocities'] = "GeocitiesJednoduchýKursorPlovoucí";
$GLOBALS['strAdLayerStyleName']['simple'] = "Jednoduchý";
$GLOBALS['strAdLayerStyleName']['cursor'] = "Kursor";
$GLOBALS['strAdLayerStyleName']['floater'] = "Plovoucí";


// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack']		= "Podpora pro sledování kliknutí serverů 3tích stran";



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strChooseTypeOfInvocation'] = "Prosím zvolte typ volání banneru";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Prosím zvolte typ volání banneru";
?>