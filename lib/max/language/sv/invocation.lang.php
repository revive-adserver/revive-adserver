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
$GLOBALS['strCopyToClipboard'] = "Kopiera till klippbordet";
$GLOBALS['strCopy'] = "kopiera";
$GLOBALS['strChooseTypeOfInvocation'] = "Vänligen välj typ av bannerpublicering";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Vänligen välj typ av bannerpublicering";

// Measures
$GLOBALS['strAbbrPixels'] = "px";
$GLOBALS['strAbbrSeconds'] = "sek";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Val av banner";
$GLOBALS['strInvocationCampaignID'] = "Kampanj";
$GLOBALS['strInvocationTarget'] = "Målram";
$GLOBALS['strInvocationSource'] = "Källa";
$GLOBALS['strInvocationWithText'] = "Visa text nedanför banner";
$GLOBALS['strInvocationDontShowAgain'] = "Visa inte banner igen på samma sida";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Visa inte en banner från samma kampanj igen på samma sida";
$GLOBALS['strInvocationTemplate'] = "Lagra bannern inuti en variabel så att den kan användas i en mall";
$GLOBALS['strInvocationBannerID'] = "Banner ID";
$GLOBALS['strInvocationComments'] = "Inkludera kommentarer";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "Förnya efter";
$GLOBALS['strIframeResizeToBanner'] = "Omvandla iframe till bannerns dimensioner";
$GLOBALS['strIframeMakeTransparent'] = "Gör iframe transparent";
$GLOBALS['strIframeIncludeNetscape4'] = "Inkludera Netscape 4 kompatibel ilayer";

// PopUp
$GLOBALS['strPopUpStyle'] = "Popup-typ";
$GLOBALS['strPopUpStylePopUp'] = "Popup";
$GLOBALS['strPopUpStylePopUnder'] = "Pop-under";
$GLOBALS['strPopUpCreateInstance'] = "Instans när popupen skapas";
$GLOBALS['strPopUpImmediately'] = "Omedelbart";
$GLOBALS['strPopUpOnClose'] = "När sidan är stängd";
$GLOBALS['strPopUpAfterSec'] = "Efter";
$GLOBALS['strAutoCloseAfter'] = "Stäng automatiskt efter";
$GLOBALS['strPopUpTop'] = "Initial position (överst)";
$GLOBALS['strPopUpLeft'] = "Initial position (vänster)";
$GLOBALS['strWindowOptions'] = "Fönsteralternativ";
$GLOBALS['strShowToolbars'] = "Verktygsfält";
$GLOBALS['strShowLocation'] = "Plats";
$GLOBALS['strShowMenubar'] = "Menyfältet";
$GLOBALS['strShowStatus'] = "Status";
$GLOBALS['strWindowResizable'] = "Skalbar";
$GLOBALS['strShowScrollbars'] = "Rullningslister";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Värd språk";
$GLOBALS['strXmlRpcProtocol'] = "Använd HTTPS för att kontakta XML-RPC Server";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC timeout (sekunder)";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Infoga Cache-Busting code";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Varning";
$GLOBALS['strImgWithAppendWarning'] = "Den här spåraren har bifogad kod, den bifogade koden kommer <strong>bara</strong> att fungera med JavaScript-taggar";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class = 'tab-s'><strong>Varning:</strong> Lokalt läges invokation fungerar ENDAST om webbplatsen som kallar koden
är på samma fysiska maskin som adserven</span><br />
Kontrollera att MAX_PATH definierad i koden nedan pekar på baskatalogen i din MAX-installation<br />
och att du har en config-fil för domänen på webbplatsen som visar annonserna (i MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Obs!</b> Lokala inställningstaggar betyder att bannerförfrågningar kommer från webbservern, snarare än klienten. Resultatet är att statistiken inte överensstämmer med IAB-riktlinjer för mätning av annonsvisning.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Obs!</b> XML-RPC-anropstaggar betyder att bannerförfrågningar kommer från webbservern, snarare än klienten. Resultatet är att statistiken inte överensstämmer med IAB-riktlinjer för mätning av annonsvisning.";
