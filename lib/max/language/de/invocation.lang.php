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
$GLOBALS['strCopyToClipboard'] = "Kopieren in Zwischenablage";
$GLOBALS['strCopy'] = "kopieren";
$GLOBALS['strChooseTypeOfInvocation'] = "Bitte wählen Sie die Auslieferungsart";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Bitte wählen Sie die Auslieferungsart für die Werbemittel";

// Measures
$GLOBALS['strAbbrPixels'] = "Px";
$GLOBALS['strAbbrSeconds'] = "Sek";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Werbemittelauswahl";
$GLOBALS['strInvocationCampaignID'] = "Kampagne";
$GLOBALS['strInvocationTarget'] = "Zielfenster (target frame)";
$GLOBALS['strInvocationSource'] = "Quelle";
$GLOBALS['strInvocationWithText'] = "Textanzeige unterhalb Werbemittel";
$GLOBALS['strInvocationDontShowAgain'] = "Werbemittel auf derselben Seite nicht mehrfach anzeigen";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Werbemittel derselben Kampagne nicht mehrfach auf derselben Seite anzeigen";
$GLOBALS['strInvocationTemplate'] = "Um Templates nutzen zu können, Werbemittel in einer Variablen speichern";
$GLOBALS['strInvocationBannerID'] = "Werbemittel-ID";
$GLOBALS['strInvocationComments'] = "Kommentare einfügen";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "Erneuern (refresh) nach ";
$GLOBALS['strIframeResizeToBanner'] = "Iframe an die Bannergröße anpassen";
$GLOBALS['strIframeMakeTransparent'] = "Iframe transparent darstellen";
$GLOBALS['strIframeIncludeNetscape4'] = "Netscape 4 kompatiblen ilayer (zusätzlich)";
$GLOBALS['strIframeGoogleClickTracking'] = "Code anfügen um Google AdSense-Klicks zu zählen";

// PopUp
$GLOBALS['strPopUpStyle'] = "PopUp Typ";
$GLOBALS['strPopUpStylePopUp'] = "PopUp";
$GLOBALS['strPopUpStylePopUnder'] = "PopUnder";
$GLOBALS['strPopUpCreateInstance'] = "Zeitpunkt zu dem das PopUp erscheinen wird";
$GLOBALS['strPopUpImmediately'] = "Sofort";
$GLOBALS['strPopUpOnClose'] = "Wenn die Seite geschlossen wird";
$GLOBALS['strPopUpAfterSec'] = "Nach";
$GLOBALS['strAutoCloseAfter'] = "Schließt automatisch nach";
$GLOBALS['strPopUpTop'] = "Startposition (oben)";
$GLOBALS['strPopUpLeft'] = "Startposition (links)";
$GLOBALS['strWindowOptions'] = "Window-Optionen";
$GLOBALS['strShowToolbars'] = "Werkzeugleiste";
$GLOBALS['strShowLocation'] = "Standortleiste";
$GLOBALS['strShowMenubar'] = "Menüleiste";
$GLOBALS['strShowStatus'] = "Statusleiste";
$GLOBALS['strWindowResizable'] = "Göße anpassen";
$GLOBALS['strShowScrollbars'] = "Scroll-Leiste";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Sprache auf Host";
$GLOBALS['strXmlRpcProtocol'] = "HTTPS nutzen, um den XML-RPC Server zu kontaktieren";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC Timeout (in Sekunden)";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "3rd Party Server Klick-Tracking unterstützen";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Cache-Busting Code einfügen";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Warnung";
$GLOBALS['strImgWithAppendWarning'] = "Dieser Tracker hat angehängten Code.<br />Angehängter Code kann nur über JavaScript-Tags ausgeführt werden";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Hinweis:</strong>Der Local mode Bannercode kann nur verwendet werden, wenn die Webseite die diesen Code ausführt auf der gleichen physikalischen Maschine wie der AdServer liegt.</span><br />
Überprüfen Sie ob MAX_PATH in dem unten stehenden Code definiert ist und auf das Hauptverzeichnis der MAX Installation zeigt<br />. Außerdem benötigen Sie eine Konfigurationsdatei für die Webseite, die die Werbebanner anzeigt (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Hinweis:</b>Anzeigendaten, die mit lokalen Modus-Aufruf-Tags entstehen sind nicht kompatibel mit IAB Richtlinien für Anzeigedaten Messungen.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Hinweis:</b>Anzeigendaten, die mit XML-RPC Aufrufen entstehen sind nicht kompatibel mit IAB Richtlinien für Anzeigedaten Messungen.";
