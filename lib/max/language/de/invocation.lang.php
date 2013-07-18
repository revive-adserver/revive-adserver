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
$GLOBALS['strCopyToClipboard']			= "Kopieren in Zwischenablage";
$GLOBALS['strCopy']				            = "kopieren";


// Measures
$GLOBALS['strAbbrPixels']			= "Px";
$GLOBALS['strAbbrSeconds']			= "Sek";


// Common Invocation Parameters
$GLOBALS['strInvocationWhat']			= "Werbemittelauswahl";
$GLOBALS['strInvocationPreview']					= "Vorschau Werbemittel";
$GLOBALS['strInvocationClientID']		= "Werbetreibender oder Kampagne";
$GLOBALS['strInvocationCampaignID']					= "Kampagne";
$GLOBALS['strInvocationTarget']			= "Zielfenster (target frame)";
$GLOBALS['strInvocationSource']			= "Quelle";
$GLOBALS['strInvocationWithText']		= "Textanzeige unterhalb Werbemittel";
$GLOBALS['strInvocationDontShowAgain']		= "Werbemittel auf derselben Seite nicht mehrfach anzeigen";
$GLOBALS['strInvocationDontShowAgainCampaign']		= "Werbemittel derselben Kampagne nicht mehrfach auf derselben Seite anzeigen";
$GLOBALS['strInvocationTemplate'] 		= "Um Templates nutzen zu können, Werbemittel in einer Variablen speichern";
$GLOBALS['strInvocationBannerID']					= "Werbemittel-ID";
$GLOBALS['strInvocationComments']                   = "Kommentare einfügen";

// Iframe
$GLOBALS['strIFrameRefreshAfter']		= "Erneuern (refresh) nach ";
$GLOBALS['strIframeResizeToBanner']		= "Iframe an die Bannergröße anpassen";
$GLOBALS['strIframeMakeTransparent']		= "Iframe transparent darstellen";
$GLOBALS['strIframeIncludeNetscape4']		= "Netscape 4 kompatiblen ilayer (zusätzlich)";


// PopUp
$GLOBALS['strPopUpStyle']			= "PopUp Typ";
$GLOBALS['strPopUpStylePopUp']		= "PopUp";
$GLOBALS['strPopUpStylePopUnder']		= "PopUnder";
$GLOBALS['strPopUpCreateInstance']		= "Zeitpunkt zu dem das PopUp erscheinen wird";
$GLOBALS['strPopUpImmediately']		= "Sofort";
$GLOBALS['strPopUpOnClose']			= "Wenn die Seite geschlossen wird";
$GLOBALS['strPopUpAfterSec']			= "Nach";
$GLOBALS['strAutoCloseAfter']			= "Schließt automatisch nach";
$GLOBALS['strPopUpTop']			= "Startposition (oben)";
$GLOBALS['strPopUpLeft']			= "Startposition (links)";
$GLOBALS['strWindowOptions']			= "Window-Optionen";
$GLOBALS['strShowToolbars']			= "Werkzeugleiste";
$GLOBALS['strShowLocation']			= "Standortleiste";
$GLOBALS['strShowMenubar']			= "Menüleiste";
$GLOBALS['strShowStatus']			= "Statusleiste";
$GLOBALS['strWindowResizable']		= "Göße anpassen";
$GLOBALS['strShowScrollbars']			= "Scroll-Leiste";


// XML-RPC
$GLOBALS['strXmlRpcLanguage']			= "Sprache auf Host";
$GLOBALS['strXmlRpcProtocol']       = "HTTPS nutzen, um den XML-RPC Server zu kontaktieren";
$GLOBALS['strXmlRpcTimeout']        = "XML-RPC Timeout (in Sekunden)";

// AdLayer
$GLOBALS['strAdLayerStyle']			= "Stil";

$GLOBALS['strAlignment']			= "Ausrichtung";
$GLOBALS['strHAlignment']			= "Horizontale Ausrichtung";
$GLOBALS['strLeft']					= "Links";
$GLOBALS['strCenter']				= "Zentriert";
$GLOBALS['strRight']				= "Rechts";

$GLOBALS['strVAlignment']			= "Vertikale Ausrichtung";
$GLOBALS['strTop']					= "Oben";
$GLOBALS['strMiddle']				= "Mitte";
$GLOBALS['strBottom']				= "Unten";

$GLOBALS['strAutoCollapseAfter']		= "Automatisch einklappen nach";
$GLOBALS['strCloseText']			= "Schließtext";
$GLOBALS['strClose']				= "[Schließen]";
$GLOBALS['strBannerPadding']			= "Banner ausfüllen";

$GLOBALS['strHShift']				= "Horizontal verschieben";
$GLOBALS['strVShift']				= "Vertikal verschieben";

$GLOBALS['strShowCloseButton']		= "Anzeigen Ende-Button";
$GLOBALS['strBackgroundColor']		= "Hintergrundfarbe";
$GLOBALS['strBorderColor']			= "Farbe des Randes";

$GLOBALS['strDirection']			= "Richtung";
$GLOBALS['strLeftToRight']			= "Links nach rechts";
$GLOBALS['strRightToLeft']			= "Rechts nach links";
$GLOBALS['strLooping']				= "Schleifen";
$GLOBALS['strAlwaysActive']			= "Immer aktiv";
$GLOBALS['strSpeed']				= "Geschwindigkeit";
$GLOBALS['strPause']				= "Pausieren";
$GLOBALS['strLimited']				= "Limitiert";
$GLOBALS['strLeftMargin']			= "Linker Rand";
$GLOBALS['strRightMargin']			= "Rechter Rand";
$GLOBALS['strTransparentBackground']		= "Transparenter Hintergrund";

$GLOBALS['strSmoothMovement']		= "Ruhige Bewegung";
$GLOBALS['strHideNotMoving']			= "Verberge Banner, wenn Cursor nicht bewegt wird";
$GLOBALS['strHideDelay']			= "Verzögerung bis zum Verbergen des Banners";
$GLOBALS['strHideTransparancy']		= "Transparenz des verborgenen Banners";


$GLOBALS['strAdLayerStyleName']['geocities'] = "Geocities";
$GLOBALS['strAdLayerStyleName']['simple'] = "Einfach";
$GLOBALS['strAdLayerStyleName']['cursor'] = "Cursor";
$GLOBALS['strAdLayerStyleName']['floater'] = "Floater";


// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack']		= "3rd Party Server Klick-Tracking unterstützen";

// Support for cachebusting code
$GLOBALS['strCacheBuster']		    = "Cache-Busting Code einfügen";

// Non-Img creatives Warning for zone image-only invocation
$GLOBALS['strNonImgWarningZone']	= "Warnung: Dieser Ad-Tag enthält Werbemittel, die keine Banner sind. Diese Werbemittel werden durch diese Zone nicht ausgeliefert.";
$GLOBALS['strNonImgWarning']        = "Warnung: Dieser Ad-Tag wird nicht ausgeliefert werden, weil das Werbemittel kein Banner ist.";

// unkown HTML tag type Warning for zone invocation
$GLOBALS['strUnknHtmlWarning']      = "Warnung: Dieses Werbemittel verwendet ein unbekanntes HTML-Ad Format.";

// sql/web banner-type warning for clickonly zone invocation
$GLOBALS['strWebBannerWarning']     = "Warnung: Dieses Werbemittel muß heruntergeladen werden und Sie müssen uns die korrekte Klick-URL für dieses Werbemittel senden.\n<br /> 1) Banner-Download:";
$GLOBALS['strDwnldWebBanner']       = "Mit der rechten Maustaste klicken und Ziel speichern als auswählen";
$GLOBALS['strWebBannerWarning2']    = "<br /> 2) Laden Sie das Banner auf Ihren Web-Server und geben Sie die URL hier an: ";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Warnung";
$GLOBALS['strImgWithAppendWarning'] = "Dieser Tracker hat angehängten Code.<br />Angehängter Code kann nur über JavaScript-Tags ausgeführt werden";



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strIframeGoogleClickTracking'] = "Code anfügen um Google AdSense-Klicks zu zählen";
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Hinweis:</strong>Der Local mode Bannercode kann nur verwendet werden, wenn die Webseite die diesen Code ausführt auf der gleichen physikalischen Maschine wie der AdServer liegt.</span><br />Überprüfen Sie das MAX_PATH in dem unten stehenden Code definiert ist und das Hauptverzeichnis der MAX Installation benennt. Außerdem benötigen Sie eine Konfigurationsdatei für die Webseite, die die Werbebanner anzeigt (in MAX_PATH/var).";
$GLOBALS['strChooseTypeOfInvocation'] = "Bitte wählen Sie die Auslieferungsart";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Bitte wählen Sie die Auslieferungsart für die Werbemittel";
?>