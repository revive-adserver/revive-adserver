<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
$GLOBALS['strInvocationRemote']			= "Zdalna Inwokacja";
$GLOBALS['strInvocationJS']			= "Zdalna inwokacja z Javascript";
$GLOBALS['strInvocationIframes']		= "Zdalna inwokacja z ramkami";
$GLOBALS['strInvocationXmlRpc']			= "Zdalna inwokacja z XML-RPC";
$GLOBALS['strInvocationCombined']		= "Mieszana zdalna inwokacja";
$GLOBALS['strInvocationPopUp']			= "Pop-up";
$GLOBALS['strInvocationAdLayer']		= "Interstitial lub Floating DHTML";
$GLOBALS['strInvocationLocal']			= "Tryb lokalny";


// Other
$GLOBALS['strCopyToClipboard']			= "Kopiuj do schowka";


// Measures
$GLOBALS['strAbbrPixels']			= "px";
$GLOBALS['strAbbrSeconds']			= "sec";


// Common Invocation Parameters
$GLOBALS['strInvocationWhat']			= "Wybór bannera";
$GLOBALS['strInvocationClientID']		= "Reklamodawca lub kampania";
$GLOBALS['strInvocationTarget']			= "Docelowa ramka";
$GLOBALS['strInvocationSource']			= "¬ród³o";
$GLOBALS['strInvocationWithText']		= "Poka¿ tekst pod bannerem";
$GLOBALS['strInvocationDontShowAgain']		= "Nie pokazuj bannera drugi raz na tej samej stronie";
$GLOBALS['strInvocationDontShowAgainCampaign']	= "Nie pokazuj bannera z tej samej kampanii po raz drugi na tej samej stronie";
$GLOBALS['strInvocationTemplate'] 		= "Zapisz ten banner w zmiennej, aby móg³ byæ wkorzystany w szablonie";


// Iframe
$GLOBALS['strIFrameRefreshAfter']		= "Od¶wie¿ po";
$GLOBALS['strIframeResizeToBanner']		= "Przeskaluj iframe do rozmiarów bannera";
$GLOBALS['strIframeMakeTransparent']		= "Zrób przezroczyst± iframe";
$GLOBALS['strIframeIncludeNetscape4']		= "Dodaj warstwê zgodn± z Netscape 4";


// PopUp
$GLOBALS['strPopUpStyle']			= "Typ Pop-up";
$GLOBALS['strPopUpStylePopUp']			= "Pop-up";
$GLOBALS['strPopUpStylePopUnder']		= "Pop-under";
$GLOBALS['strPopUpCreateInstance']		= "Kiedy pop-up ma byæ wy¶wietlony";
$GLOBALS['strPopUpImmediately']			= "Natychmiast";
$GLOBALS['strPopUpOnClose']			= "Kiedy strona jest zamykana";
$GLOBALS['strPopUpAfterSec']			= "Po";
$GLOBALS['strAutoCloseAfter']			= "Automatycznie zamknij po";
$GLOBALS['strPopUpTop']				= "Pocz±tkowa pozycja (góra)";
$GLOBALS['strPopUpLeft']			= "Pocz±tkowa pozycja (lewa)";


// XML-RPC
$GLOBALS['strXmlRpcLanguage']			= "Jêzyk Hosta";


// AdLayer
$GLOBALS['strAdLayerStyle']			= "Styl";

$GLOBALS['strAlignment']			= "Wyrównanie";
$GLOBALS['strHAlignment']			= "Wyrównanie poziome";
$GLOBALS['strLeft']				= "Lewa";
$GLOBALS['strCenter']				= "¦rodek";
$GLOBALS['strRight']				= "Prawa";

$GLOBALS['strVAlignment']			= "Wyrównanie pionowe";
$GLOBALS['strTop']				= "Góra";
$GLOBALS['strMiddle']				= "¦rodek";
$GLOBALS['strBottom']				= "Dó³";

$GLOBALS['strAutoCollapseAfter']		= "Automatycznie schowa po";
$GLOBALS['strCloseText']			= "Tekst zamkniêcia";
$GLOBALS['strClose']				= "[Zamknij]";
$GLOBALS['strBannerPadding']			= "Odstêp bannera";

$GLOBALS['strHShift']				= "Przesuniêcie poziome";
$GLOBALS['strVShift']				= "Przesuniêcie pionowe";

$GLOBALS['strShowCloseButton']			= "Poka¿ przycisk zamykania";
$GLOBALS['strBackgroundColor']			= "Kolor t³a";
$GLOBALS['strBorderColor']			= "Kolor obramowania";

$GLOBALS['strDirection']			= "Kierunek";
$GLOBALS['strLeftToRight']			= "Lewa do prawej";
$GLOBALS['strRightToLeft']			= "Prawa do lewej";
$GLOBALS['strLooping']				= "Pêtle";
$GLOBALS['strAlwaysActive']			= "Zawsze aktywny";
$GLOBALS['strSpeed']				= "Prêdko¶æ";
$GLOBALS['strPause']				= "Pauza";
$GLOBALS['strLimited']				= "Ograniczony";
$GLOBALS['strLeftMargin']			= "Lewy margines";
$GLOBALS['strRightMargin']			= "Prawy margines";
$GLOBALS['strTransparentBackground']		= "Przezroczyste t³o";

$GLOBALS['strSmoothMovement']			= "P³ynny ruch";
$GLOBALS['strHideNotMoving']			= "Ukryj banner kiedy kursor siê nie porusza";
$GLOBALS['strHideDelay']			= "Opó¼nienie przed ukryciem bannera";
$GLOBALS['strHideTransparancy']			= "Przezroczysto¶æ ukrytego bannera";


$GLOBALS['strAdLayerStyleName']				= array(
	'geocities'		=> "Geocities",
	'simple'		=> "Prosty",
	'cursor'		=> "Kursor",
	'floater'		=> "Floater"
);

?>