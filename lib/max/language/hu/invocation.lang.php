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
$GLOBALS['strInvocationRemote']			= "Távhívás";
$GLOBALS['strInvocationJS']					= "Távhívás JavaScripthez";
$GLOBALS['strInvocationIframes']		= "Távhívás keretekhez";
$GLOBALS['strInvocationXmlRpc']			= "Távhívás XML-RPC használatával";
$GLOBALS['strInvocationCombined']		= "Kombinált távhívás";
$GLOBALS['strInvocationPopUp']			= "Felbukkanó ablak";
$GLOBALS['strInvocationAdLayer']		= "Interstíciós vagy Lebegő DHTML";
$GLOBALS['strInvocationLocal']			= "Helyi mód";


// Other
$GLOBALS['strCopyToClipboard']			= "Vágólapra másolás";


// Measures
$GLOBALS['strAbbrPixels']			= "px";
$GLOBALS['strAbbrSeconds']			= "mp";


// Common Invocation Parameters
$GLOBALS['strInvocationWhat']			= "Banner választás";
$GLOBALS['strInvocationClientID']		= "Hirdető vagy kampány";
$GLOBALS['strInvocationTarget']			= "Cél keret";
$GLOBALS['strInvocationSource']			= "Forrás";
$GLOBALS['strInvocationWithText']		= "Szöveg megjelenítése a banner alatt";
$GLOBALS['strInvocationDontShowAgain']		= "Ne mutasd újra a bannert ugyanazon az oldalon";
$GLOBALS['strInvocationDontShowAgainCampaign']		= "Ne mutass bannert újra ugyanabból a kampányból ugyanazon az oldalon";
$GLOBALS['strInvocationTemplate'] 		= "Banner tárolása változóban, hogy a mintában lehessen használni";


// Iframe
$GLOBALS['strIFrameRefreshAfter']		= "Újratöltés ideje";
$GLOBALS['strIframeResizeToBanner']		= "Iframe átméretezése a banner mérete után";
$GLOBALS['strIframeMakeTransparent']		= "Átlátszó iframe";
$GLOBALS['strIframeIncludeNetscape4']		= "Netscape 4 kompatibilis ilayer hozzáadása";


// PopUp
$GLOBALS['strPopUpStyle']			= "Ablak típusa";
$GLOBALS['strPopUpStylePopUp']			= "Felbukkanó";
$GLOBALS['strPopUpStylePopUnder']		= "Aláugró";
$GLOBALS['strPopUpCreateInstance']		= "Előfordulás az előugrás létrehozásakor";
$GLOBALS['strPopUpImmediately']			= "Azonnal";
$GLOBALS['strPopUpOnClose']			= "Az oldal bezárásakor";
$GLOBALS['strPopUpAfterSec']			= "Után:";
$GLOBALS['strAutoCloseAfter']			= "Automatikus bezárás, után";
$GLOBALS['strPopUpTop']				= "Kezdő pozíció (fent)";
$GLOBALS['strPopUpLeft']			= "Kezdő pozíció (balra)";
$GLOBALS['strWindowOptions']		= "Ablak tulajdonságai";
$GLOBALS['strShowToolbars']			= "Eszköztárak";
$GLOBALS['strShowLocation']			= "Hely";
$GLOBALS['strShowMenubar']			= "Menüsor";
$GLOBALS['strShowStatus']			= "Állapot";
$GLOBALS['strWindowResizable']		= "Méretezhető";
$GLOBALS['strShowScrollbars']		= "Gördítősávok";


// XML-RPC
$GLOBALS['strXmlRpcLanguage']			= "Állomás nyelve";


// AdLayer
$GLOBALS['strAdLayerStyle']			= "Stílusok";

$GLOBALS['strAlignment']			= "Igazítás";
$GLOBALS['strHAlignment']			= "Vízszintes igazítás";
$GLOBALS['strLeft']				= "Balra";
$GLOBALS['strCenter']				= "Középre";
$GLOBALS['strRight']				= "Jobbra";

$GLOBALS['strVAlignment']			= "Függőleges igazítás";
$GLOBALS['strTop']				= "Felülre";
$GLOBALS['strMiddle']				= "Középre";
$GLOBALS['strBottom']				= "Alulra";

$GLOBALS['strAutoCollapseAfter']		= "Automatikus összecsukás";
$GLOBALS['strCloseText']			= "Bezárás gomb felirata";
$GLOBALS['strClose']				= "[Bezárás]";
$GLOBALS['strBannerPadding']			= "Reklámmargó";

$GLOBALS['strHShift']				= "Vízszintes eltolás";
$GLOBALS['strVShift']				= "Függőleges eltolás";

$GLOBALS['strShowCloseButton']			= "Bezárás gomb megjelenítése";
$GLOBALS['strBackgroundColor']			= "Háttér színe";
$GLOBALS['strBorderColor']			= "Szegély színe";

$GLOBALS['strDirection']			= "Irány";
$GLOBALS['strLeftToRight']			= "Balról jobbra";
$GLOBALS['strRightToLeft']			= "Jobbról balra";
$GLOBALS['strLooping']				= "Ismétlés";
$GLOBALS['strAlwaysActive']			= "Mindig aktív";
$GLOBALS['strSpeed']				= "Sebesség";
$GLOBALS['strPause']				= "Szünet";
$GLOBALS['strLimited']				= "Korlátozott";
$GLOBALS['strLeftMargin']			= "Bal margó";
$GLOBALS['strRightMargin']			= "Jobb margó";
$GLOBALS['strTransparentBackground']		= "Átlátszó háttér";

$GLOBALS['strSmoothMovement']		= "Egyenletes mozgás";
$GLOBALS['strHideNotMoving']		= "A reklám elrejtése, ha a kurzor nem mozog";
$GLOBALS['strHideDelay']			= "A reklám elrejtésének késleltetése";
$GLOBALS['strHideTransparancy']		= "Az elrejtett reklám átlátszósága";


$GLOBALS['strAdLayerStyleName']['geocities'] = "Geocities";
$GLOBALS['strAdLayerStyleName']['simple'] = "Egyszerű";
$GLOBALS['strAdLayerStyleName']['cursor'] = "Kurzor";
$GLOBALS['strAdLayerStyleName']['floater'] = "Lebegő";




// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strInvocationCampaignID'] = "Kampány";
$GLOBALS['strCopy'] = "másolás";
$GLOBALS['strInvocationBannerID'] = "Banner azonosító";
$GLOBALS['strInvocationComments'] = "Kommentek beágyazása";
$GLOBALS['str3rdPartyTrack'] = "Harmadik fél által készített Kattintás követő szerver támogatása";
$GLOBALS['strCacheBuster'] = "Gyorsítótárazás elkerülését szolgáló kód hozzáadása";
$GLOBALS['strImgWithAppendWarning'] = "Ez a követő hozzáadott kóddal van ellátva, a hozzáadott kód <strong>csak</strong> JavaScript tagekkel fog működni";
?>