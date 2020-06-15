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

// Other
$GLOBALS['strCopyToClipboard'] = "Vágólapra másolás";
$GLOBALS['strCopy'] = "másolás";
$GLOBALS['strChooseTypeOfInvocation'] = "Válassza ki a hívás típusát";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Válassza ki a reklámhívás típusát";

// Measures
$GLOBALS['strAbbrPixels'] = "px";
$GLOBALS['strAbbrSeconds'] = "mp";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Banner választás";
$GLOBALS['strInvocationCampaignID'] = "Kampány";
$GLOBALS['strInvocationTarget'] = "Cél keret";
$GLOBALS['strInvocationSource'] = "Forrás";
$GLOBALS['strInvocationWithText'] = "Szöveg megjelenítése a banner alatt";
$GLOBALS['strInvocationDontShowAgain'] = "Ne mutasd újra a bannert ugyanazon az oldalon";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Ne mutass bannert újra ugyanabból a kampányból ugyanazon az oldalon";
$GLOBALS['strInvocationTemplate'] = "Banner tárolása változóban, hogy a mintában lehessen használni";
$GLOBALS['strInvocationBannerID'] = "Banner azonosító";
$GLOBALS['strInvocationComments'] = "Kommentek beágyazása";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "Újratöltés ideje";
$GLOBALS['strIframeResizeToBanner'] = "Iframe átméretezése a banner mérete után";
$GLOBALS['strIframeMakeTransparent'] = "Átlátszó iframe";
$GLOBALS['strIframeIncludeNetscape4'] = "Netscape 4 kompatibilis ilayer hozzáadása";
$GLOBALS['strIframeGoogleClickTracking'] = "Adjon meg kódot a Google AdSense kattintások követéséhez";

// PopUp
$GLOBALS['strPopUpStyle'] = "Ablak típusa";
$GLOBALS['strPopUpStylePopUp'] = "Felbukkanó";
$GLOBALS['strPopUpStylePopUnder'] = "Aláugró";
$GLOBALS['strPopUpCreateInstance'] = "Előfordulás az előugrás létrehozásakor";
$GLOBALS['strPopUpImmediately'] = "Azonnal";
$GLOBALS['strPopUpOnClose'] = "Az oldal bezárásakor";
$GLOBALS['strPopUpAfterSec'] = "Után:";
$GLOBALS['strAutoCloseAfter'] = "Automatikus bezárás, után";
$GLOBALS['strPopUpTop'] = "Kezdő pozíció (fent)";
$GLOBALS['strPopUpLeft'] = "Kezdő pozíció (balra)";
$GLOBALS['strWindowOptions'] = "Ablak tulajdonságai";
$GLOBALS['strShowToolbars'] = "Eszköztárak";
$GLOBALS['strShowLocation'] = "Hely";
$GLOBALS['strShowMenubar'] = "Menüsor";
$GLOBALS['strShowStatus'] = "Állapot";
$GLOBALS['strWindowResizable'] = "Méretezhető";
$GLOBALS['strShowScrollbars'] = "Gördítősávok";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Állomás nyelve";
$GLOBALS['strXmlRpcProtocol'] = "Használjon HTTPS kapcsolatot az XML-RPC szerver eléréséhez";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC időtúllépés (másodperc)";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "Harmadik fél által készített Kattintás követő szerver támogatása";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Gyorsítótárazás elkerülését szolgáló kód hozzáadása";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Figyelmeztetés";
$GLOBALS['strImgWithAppendWarning'] = "Ehhez a követőkódhoz további kód van hozzáadva. A hozzáadott kód <strong>csak</strong> JavaScript tagekkel fog működni";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
is on the same physical machine as the adserver</span><br />
Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Note:</b> Local Mode invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Note:</b> XML-RPC invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
