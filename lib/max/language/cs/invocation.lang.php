<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
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
$GLOBALS['strInvocationCampaignID']			= "Kampaň";
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


$GLOBALS['strAdLayerStyleName']	= array(
	'geocities'		=> "Geocities",
	'simple'		=> "Jednoduchý",
	'cursor'		=> "Kursor",
	'floater'		=> "Plovoucí"
);

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack']		= "Podpora pro sledování kliknutí serverů 3tích stran";

?>
