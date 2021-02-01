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
$GLOBALS['strCopyToClipboard'] = "Kopiraj na namizje";
$GLOBALS['strCopy'] = "kopiraj";
$GLOBALS['strChooseTypeOfInvocation'] = "Prosimo, izberite tip poziva";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Prosimo, izberite tip poziva pasici";

// Measures
$GLOBALS['strAbbrPixels'] = "px";
$GLOBALS['strAbbrSeconds'] = "sek";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Izbira pasice";
$GLOBALS['strInvocationCampaignID'] = "Kampanja";
$GLOBALS['strInvocationTarget'] = "Okvir cilja";
$GLOBALS['strInvocationSource'] = "Vir";
$GLOBALS['strInvocationWithText'] = "Prikaži besedilo pod pasico";
$GLOBALS['strInvocationDontShowAgain'] = "Ne prikaži pasice še enkrat na isti strani";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Ne prikaži pasice iz iste kampanje še enkrat na isti strani";
$GLOBALS['strInvocationTemplate'] = "Shrani pasico v spremenljivki za uporabo v predlogi";
$GLOBALS['strInvocationBannerID'] = "ID pasice";
$GLOBALS['strInvocationComments'] = "Vključi komentarje";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "Osveži po";
$GLOBALS['strIframeResizeToBanner'] = "Razširi I-Frame v dimenzije pasice";
$GLOBALS['strIframeMakeTransparent'] = "Naredi I-Frame prozoren";
$GLOBALS['strIframeIncludeNetscape4'] = "Vključi Netscape 4 združljiv i-layer";
$GLOBALS['strIframeGoogleClickTracking'] = "Vključi zbirnik za sledenje Google AdSense klikov";

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
$GLOBALS['strShowStatus'] = "Stanje";
$GLOBALS['strWindowResizable'] = "Resizable";
$GLOBALS['strShowScrollbars'] = "Scrollbars";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Host Language";
$GLOBALS['strXmlRpcProtocol'] = "Use HTTPS to contact XML-RPC Server";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC Timeout (Seconds)";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Vstavi cache-busting kodo";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Opozorilo";
$GLOBALS['strImgWithAppendWarning'] = "Ta sledilnik ima pripeto kodo, ki deluje <strong>samo</strong> z JavaScriptom";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
is on the same physical machine as the adserver</span><br />
Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Note:</b> Local Mode invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Note:</b> XML-RPC invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
