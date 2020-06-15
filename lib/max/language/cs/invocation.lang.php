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
$GLOBALS['strCopyToClipboard'] = "Kopírovat do schránky";
$GLOBALS['strCopy'] = "copy";
$GLOBALS['strChooseTypeOfInvocation'] = "Prosím zvolte typ volání banneru";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Prosím zvolte typ volání banneru";

// Measures
$GLOBALS['strAbbrPixels'] = "px";
$GLOBALS['strAbbrSeconds'] = "vteřin";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Volba banneru";
$GLOBALS['strInvocationCampaignID'] = "Skrytá kampaň";
$GLOBALS['strInvocationTarget'] = "Cílový frame";
$GLOBALS['strInvocationSource'] = "Zdroj";
$GLOBALS['strInvocationWithText'] = "Zobrazit text pod bannerem";
$GLOBALS['strInvocationDontShowAgain'] = "Nezobrazovat banner znova na stejné stránce";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Nezobrazovat banner ze stejné kampaně znova na stejné stránce";
$GLOBALS['strInvocationTemplate'] = "Uložit banner v proměnné aby mohl být použit v šabloně";
$GLOBALS['strInvocationBannerID'] = "ID banneru";
$GLOBALS['strInvocationComments'] = "Include comments";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "Obnovit po";
$GLOBALS['strIframeResizeToBanner'] = "Zmenit velikost iframe podle banneru";
$GLOBALS['strIframeMakeTransparent'] = "Udělat iframe průhledný";
$GLOBALS['strIframeIncludeNetscape4'] = "Vložit Nestcape 4 kompatibilní ilayer";
$GLOBALS['strIframeGoogleClickTracking'] = "Include code to track Google AdSense clicks";

// PopUp
$GLOBALS['strPopUpStyle'] = "Typ Pop-upu";
$GLOBALS['strPopUpStylePopUp'] = "Pop-up";
$GLOBALS['strPopUpStylePopUnder'] = "Pop-under";
$GLOBALS['strPopUpCreateInstance'] = "Zobrazit když je pop-up vytvořen";
$GLOBALS['strPopUpImmediately'] = "Okamžitě";
$GLOBALS['strPopUpOnClose'] = "Když je zavřena stránka";
$GLOBALS['strPopUpAfterSec'] = "Po";
$GLOBALS['strAutoCloseAfter'] = "Automaticky zavřít po";
$GLOBALS['strPopUpTop'] = "Výchozí pozice (zhora)";
$GLOBALS['strPopUpLeft'] = "Výchozí pozice (zleva)";
$GLOBALS['strWindowOptions'] = "Parametry okna";
$GLOBALS['strShowToolbars'] = "Panel nástrojů";
$GLOBALS['strShowLocation'] = "Umístění";
$GLOBALS['strShowMenubar'] = "Menu";
$GLOBALS['strShowStatus'] = "Stavový řádek";
$GLOBALS['strWindowResizable'] = "Měnitelná velikost";
$GLOBALS['strShowScrollbars'] = "Skrolovatelný";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Jazyk hostitele";
$GLOBALS['strXmlRpcProtocol'] = "Use HTTPS to contact XML-RPC Server";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC Timeout (Seconds)";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "Podpora pro sledování kliknutí serverů 3tích stran";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Insert Cache-Busting code";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Varování";
$GLOBALS['strImgWithAppendWarning'] = "This tracker has appended code, appended code will <strong>only</strong> work with JavaScript tags";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
is on the same physical machine as the adserver</span><br />
Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Note:</b> Local Mode invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Note:</b> XML-RPC invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
