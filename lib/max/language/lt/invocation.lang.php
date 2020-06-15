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
$GLOBALS['strCopyToClipboard'] = "Kopijuoti į dėžutę";
$GLOBALS['strCopy'] = "Kopijuoti";
$GLOBALS['strChooseTypeOfInvocation'] = "Prašome pasirinkti banerio aktyvizacijos tipą";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Prašome pasirinkti banerio aktyvizacijos tipą";

// Measures
$GLOBALS['strAbbrPixels'] = "Px";
$GLOBALS['strAbbrSeconds'] = "s.";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Banerio pasirinkimas";
$GLOBALS['strInvocationCampaignID'] = "Kampanija";
$GLOBALS['strInvocationTarget'] = "Target rėmelis";
$GLOBALS['strInvocationSource'] = "Pirminis";
$GLOBALS['strInvocationWithText'] = "Rodyti tekstą po baneriu";
$GLOBALS['strInvocationDontShowAgain'] = "Nerodyti banerių kelis kartus tame pačiame puslapyje";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Nerodyti vienodos kampanijos  banerių tame pačiame puslapyje";
$GLOBALS['strInvocationTemplate'] = "Išsaugoti banerį  kintamojo viduje, kad būtų galima naudoti kaip šabloną";
$GLOBALS['strInvocationBannerID'] = "Benerio ID";
$GLOBALS['strInvocationComments'] = "Pridėti komentarų";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "Atnaujinti po";
$GLOBALS['strIframeResizeToBanner'] = "Pakeisti banerio matmenis";
$GLOBALS['strIframeMakeTransparent'] = "Padaryti rėmelį permatomą";
$GLOBALS['strIframeIncludeNetscape4'] = "Įterpti Netscape 4 kompaktišką lygmenį";
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
$GLOBALS['strShowStatus'] = "Statusas";
$GLOBALS['strWindowResizable'] = "Resizable";
$GLOBALS['strShowScrollbars'] = "Scrollbars";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Host Language";
$GLOBALS['strXmlRpcProtocol'] = "Use HTTPS to contact XML-RPC Server";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC Timeout (Seconds)";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "Palaikyti trečiosios šalies serverio paspaudimų sekimą";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Įterpti Cache-Busting kodą";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Perspėjimas";
$GLOBALS['strImgWithAppendWarning'] = "This tracker has appended code, appended code will <strong>only</strong> work with JavaScript tags";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
is on the same physical machine as the adserver</span><br />
Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Note:</b> Local Mode invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Note:</b> XML-RPC invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
