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
$GLOBALS['strCopyToClipboard'] = "Kopieer naar klembord";
$GLOBALS['strCopy'] = "Kopieer";
$GLOBALS['strChooseTypeOfInvocation'] = "Kies het type aanroep alstublieft";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Kies het type banner invocatie";

// Measures
$GLOBALS['strAbbrPixels'] = "px";
$GLOBALS['strAbbrSeconds'] = "sec";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Banner selectie";
$GLOBALS['strInvocationCampaignID'] = "Campagne";
$GLOBALS['strInvocationTarget'] = "Doel frame";
$GLOBALS['strInvocationSource'] = "Bron";
$GLOBALS['strInvocationWithText'] = "Toon tekst onder banner";
$GLOBALS['strInvocationDontShowAgain'] = "Toon deze banner niet nog eens op dezelfde pagina";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Toon niet nog eens een banner van dezelfde campagne op dezelfde pagina";
$GLOBALS['strInvocationTemplate'] = "Sla de banner op in een variable welke gebruikt kan worden in een sjabloon";
$GLOBALS['strInvocationBannerID'] = "Banner ID";
$GLOBALS['strInvocationComments'] = "Commentaar opnemen";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "Ververs na";
$GLOBALS['strIframeResizeToBanner'] = "Het formaat van iframe wijzigen op basis van banner afmetingen";
$GLOBALS['strIframeMakeTransparent'] = "Maak de iframe transparant";
$GLOBALS['strIframeIncludeNetscape4'] = "Voeg Netscape 4 compatible ilayer toe";
$GLOBALS['strIframeGoogleClickTracking'] = "Programmacode opnemen om Google AdSense kliks te tellen";

// PopUp
$GLOBALS['strPopUpStyle'] = "Pop-up type";
$GLOBALS['strPopUpStylePopUp'] = "Pop-up";
$GLOBALS['strPopUpStylePopUnder'] = "Pop-under";
$GLOBALS['strPopUpCreateInstance'] = "Moment waarop de pop-up getoond wordt";
$GLOBALS['strPopUpImmediately'] = "Onmiddellijk";
$GLOBALS['strPopUpOnClose'] = "Na het sluiten van de pagina";
$GLOBALS['strPopUpAfterSec'] = "Na";
$GLOBALS['strAutoCloseAfter'] = "Sluit automatisch na";
$GLOBALS['strPopUpTop'] = "Begin positie (boven)";
$GLOBALS['strPopUpLeft'] = "Begin positie (links)";
$GLOBALS['strWindowOptions'] = "Vensteropties";
$GLOBALS['strShowToolbars'] = "Werkbalken";
$GLOBALS['strShowLocation'] = "Locatie";
$GLOBALS['strShowMenubar'] = "Menubalk";
$GLOBALS['strShowStatus'] = "Status";
$GLOBALS['strWindowResizable'] = "Grootte aanpasbaar";
$GLOBALS['strShowScrollbars'] = "Schuifbalken";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Scripttaal";
$GLOBALS['strXmlRpcProtocol'] = "Gebruik Https om contact te maken met XML-RPC Server";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC Timeout (seconden)";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "3de partij Server Clicktracking ondersteuning";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Cache-Busting code invoegen";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Waarschuwing";
$GLOBALS['strImgWithAppendWarning'] = "Deze tracker code heeft toegevoegde code, toegevoegde code zal <strong>alleen</strong> werken met JavaScript-tags";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'> <strong>Waarschuwing:</strong> Local Mode invocation werkt alleen als de site die de code aanroept op dezelfde fysieke computer staat als de adserver</span> <br / > Controleer of de opgegeven MAX_PATH gedefinieerd in de code hieronder verwijst naar de basis directory van uw installatie van Revive Adserver <br / > en dat u een configuratiebestand heeft voor het domein van de site die de advertenties tonen (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Opmerking:</b> Impressie gegevens gegenereerd op basis van Local Mode Invocation tags zijn niet compatibel met IAB richtlijnen voor metingen van advertentie impressies.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Opmerking:</b> Impressie gegevens gegenereerd met behulp van XML-RPC aanroepen tags zijn niet compatibel met IAB richtlijnen voor metingen van advertentie impressies.";
