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
$GLOBALS['strCopyToClipboard'] = "Kopier til klippebordet";
$GLOBALS['strCopy'] = "kopier";
$GLOBALS['strChooseTypeOfInvocation'] = "Venligst vælg den type af banner invocation";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Venligst vælg den type af banner invocation";

// Measures
$GLOBALS['strAbbrPixels'] = "px";
$GLOBALS['strAbbrSeconds'] = "sek";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Banner valg";
$GLOBALS['strInvocationCampaignID'] = "Kampagne";
$GLOBALS['strInvocationTarget'] = "Mål ramme";
$GLOBALS['strInvocationSource'] = "Kilde";
$GLOBALS['strInvocationWithText'] = "Vis tekst under banner";
$GLOBALS['strInvocationDontShowAgain'] = "Vis ikke banneren igen på den samme side";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Vis ikke banneren fra den samme kampagne igen på den samme side";
$GLOBALS['strInvocationTemplate'] = "Gem banneren inde i en variable så den kan bruges som skabelon";
$GLOBALS['strInvocationBannerID'] = "Banner ID";
$GLOBALS['strInvocationComments'] = "Inklusiv kommentar";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "Opdater efter";
$GLOBALS['strIframeResizeToBanner'] = "Tilpas iframe til banner dimensioner";
$GLOBALS['strIframeMakeTransparent'] = "Gør iframen transperant";
$GLOBALS['strIframeIncludeNetscape4'] = "Inkluder Netscape 4 kompatibel ilayer";
$GLOBALS['strIframeGoogleClickTracking'] = "Include code to track Google AdSense clicks";

// PopUp
$GLOBALS['strPopUpStyle'] = "Pop-up type";
$GLOBALS['strPopUpStylePopUp'] = "Pop-up";
$GLOBALS['strPopUpStylePopUnder'] = "Pop-under";
$GLOBALS['strPopUpCreateInstance'] = "Instance when the pop-up is created";
$GLOBALS['strPopUpImmediately'] = "Immediately";
$GLOBALS['strPopUpOnClose'] = "When the page is closed";
$GLOBALS['strPopUpAfterSec'] = "After";
$GLOBALS['strAutoCloseAfter'] = "Automatically close after";
$GLOBALS['strPopUpTop'] = "Initial position (top)";
$GLOBALS['strPopUpLeft'] = "Initial position (left)";
$GLOBALS['strWindowOptions'] = "Window options";
$GLOBALS['strShowToolbars'] = "Toolbars";
$GLOBALS['strShowLocation'] = "Location";
$GLOBALS['strShowMenubar'] = "Menubar";
$GLOBALS['strShowStatus'] = "Status";
$GLOBALS['strWindowResizable'] = "Resizable";
$GLOBALS['strShowScrollbars'] = "Scrollbars";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Host Language";
$GLOBALS['strXmlRpcProtocol'] = "Use HTTPS to contact XML-RPC Server";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC Timeout (Seconds)";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Insæt Cache-Busting kode";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Advarsel";
$GLOBALS['strImgWithAppendWarning'] = "Denne sporer har vedhæftet en kode, vedhæftet kode kan <strong>kun</strong> fungere med JavaScript tags";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
is on the same physical machine as the adserver</span><br />
Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Note:</b> Local Mode invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Note:</b> XML-RPC invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
