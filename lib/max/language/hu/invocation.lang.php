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
$GLOBALS['strAbbrPixels']			= "kp.";
$GLOBALS['strAbbrSeconds']			= "mp.";


// Common Invocation Parameters
$GLOBALS['strInvocationWhat']			= "Reklám kiválasztása";
$GLOBALS['strInvocationClientID']		= "Hirdető vagy kampány";
$GLOBALS['strInvocationTarget']			= "Célkeret";
$GLOBALS['strInvocationSource']			= "Forrás";
$GLOBALS['strInvocationWithText']		= "Szöveg megjelenítése a reklám alatt";
$GLOBALS['strInvocationDontShowAgain']		= "Nem jelenik meg a reklám ugyanazon az oldalon";
$GLOBALS['strInvocationDontShowAgainCampaign']		= "Azonos kampányból nem jelenik meg reklám ugyanazon az oldalon";
$GLOBALS['strInvocationTemplate'] 		= "A reklám tárolása változóban, így sablonban felhasználható";


// Iframe
$GLOBALS['strIFrameRefreshAfter']		= "Frissítés utána";
$GLOBALS['strIframeResizeToBanner']		= "Az információkeret átméretezése a reklám méretei alapján";
$GLOBALS['strIframeMakeTransparent']		= "Az információkeret átlátszóvá tétele";
$GLOBALS['strIframeIncludeNetscape4']		= "Netscape 4 kompatibilis információréteget tartalmaz";


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
$GLOBALS['strAdLayerStyle']			= "Stílus";

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


$GLOBALS['strAdLayerStyleName']	= array(
	'geocities'		=> "Geocities",
	'simple'		=> "Egyszerű",
	'cursor'		=> "Kurzor",
	'floater'		=> "Lebegő"
);

?>