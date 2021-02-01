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
$GLOBALS['strCopyToClipboard'] = "Copiază în clipboard";
$GLOBALS['strCopy'] = "copiază";
$GLOBALS['strChooseTypeOfInvocation'] = "Te rugăm să alegi tipul de cod pentru";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Te rugăm să alegi tipul de cod pentru banner";

// Measures
$GLOBALS['strAbbrPixels'] = "px";
$GLOBALS['strAbbrSeconds'] = "sec";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Alegere banner";
$GLOBALS['strInvocationCampaignID'] = "Campanie";
$GLOBALS['strInvocationTarget'] = "Frame ţintă";
$GLOBALS['strInvocationSource'] = "Sursa";
$GLOBALS['strInvocationWithText'] = "Arată text sub banner";
$GLOBALS['strInvocationDontShowAgain'] = "Nu afişa banner-ul din nou pe aceeaşi pagină";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Nu arăta un banner din aceeaşi campanie pe aceeaşi pagină";
$GLOBALS['strInvocationTemplate'] = "Stochează bannerul într-o variabilă pentru a putea fi folosit într-un template";
$GLOBALS['strInvocationBannerID'] = "ID Banner";
$GLOBALS['strInvocationComments'] = "Include comentarii";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "Reîmprospătează după";
$GLOBALS['strIframeResizeToBanner'] = "Redimensionează iframe-ul după dimensiunile bannerului";
$GLOBALS['strIframeMakeTransparent'] = "Iframe transparent";
$GLOBALS['strIframeIncludeNetscape4'] = "Include ilayer compatibil Netscape 4";
$GLOBALS['strIframeGoogleClickTracking'] = "Include codul pentru a urmări click-urile Google Adsense";

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
$GLOBALS['strShowStatus'] = "Stare";
$GLOBALS['strWindowResizable'] = "Resizable";
$GLOBALS['strShowScrollbars'] = "Scrollbars";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Host Language";
$GLOBALS['strXmlRpcProtocol'] = "Use HTTPS to contact XML-RPC Server";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC Timeout (Seconds)";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Inserează cod Cache-Busting";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Avertisment";
$GLOBALS['strImgWithAppendWarning'] = "Acest contor are cod lipit, codul lipit va funcţiona <strong>doar</strong> cu tag-uri JavaScript";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
is on the same physical machine as the adserver</span><br />
Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Note:</b> Local Mode invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Note:</b> XML-RPC invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
