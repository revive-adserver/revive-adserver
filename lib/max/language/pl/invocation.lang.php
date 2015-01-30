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
$GLOBALS['strCopyToClipboard'] = "Kopiuj do schowka";
$GLOBALS['strCopy'] = "kopiuj";
$GLOBALS['strChooseTypeOfInvocation'] = "Wybierz typ kodu wywołującego";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Wybierz typ kodu wywołującego baner";

// Measures
$GLOBALS['strAbbrPixels'] = "piks";
$GLOBALS['strAbbrSeconds'] = "sek";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Wybór banera";
$GLOBALS['strInvocationClientID'] = "Reklamodawca lub kampania";
$GLOBALS['strInvocationCampaignID'] = "Kampania";
$GLOBALS['strInvocationTarget'] = "Ramka docelowa";
$GLOBALS['strInvocationSource'] = "Źródło";
$GLOBALS['strInvocationWithText'] = "Pokaż tekst pod banerem";
$GLOBALS['strInvocationDontShowAgain'] = "Nie pokazuj banera drugi raz na tej samej stronie";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Nie pokazuj banera z tej samej kampanii po raz drugi na tej samej stronie";
$GLOBALS['strInvocationTemplate'] = "Zapisz ten baner w zmiennej, aby mógł być wkorzystany w szablonie";
$GLOBALS['strInvocationBannerID'] = "ID banera";
$GLOBALS['strInvocationComments'] = "Dołącz komentarze";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "Odśwież po";
$GLOBALS['strIframeResizeToBanner'] = "Przeskaluj iframe do rozmiarów banera";
$GLOBALS['strIframeMakeTransparent'] = "Zrób przezroczystą iframe";
$GLOBALS['strIframeIncludeNetscape4'] = "Dodaj warstwę kompatybilną z Netscape 4";
$GLOBALS['strIframeGoogleClickTracking'] = "Dołącz kod do śledzenia kliknięć Google AdSense";


// PopUp
$GLOBALS['strPopUpStyle'] = "Typ Pop-up";
$GLOBALS['strPopUpCreateInstance'] = "Kiedy pop-up ma być wyświetlony";
$GLOBALS['strPopUpImmediately'] = "Natychmiast";
$GLOBALS['strPopUpOnClose'] = "Kiedy strona jest zamykana";
$GLOBALS['strPopUpAfterSec'] = "Po";
$GLOBALS['strAutoCloseAfter'] = "Automatycznie zamknij po";
$GLOBALS['strPopUpTop'] = "Początkowa pozycja (góra)";
$GLOBALS['strPopUpLeft'] = "Początkowa pozycja (lewa)";


// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Język Hosta";


// AdLayer
$GLOBALS['strAdLayerStyle'] = "Styl";

$GLOBALS['strAlignment'] = "Wyrównanie";
$GLOBALS['strHAlignment'] = "Wyrównanie poziome";
$GLOBALS['strLeft'] = "Lewa";
$GLOBALS['strCenter'] = "Środek";
$GLOBALS['strRight'] = "Prawa";

$GLOBALS['strVAlignment'] = "Wyrównanie pionowe";
$GLOBALS['strTop'] = "Góra";
$GLOBALS['strMiddle'] = "Środek";
$GLOBALS['strBottom'] = "Dół";

$GLOBALS['strAutoCollapseAfter'] = "Automatycznie schowa po";
$GLOBALS['strCloseText'] = "Tekst zamknięcia";
$GLOBALS['strClose'] = "[Zamknij]";
$GLOBALS['strBannerPadding'] = "Odstęp bannera";

$GLOBALS['strHShift'] = "Przesunięcie poziome";
$GLOBALS['strVShift'] = "Przesunięcie pionowe";

$GLOBALS['strShowCloseButton'] = "Pokaż przycisk zamykania";
$GLOBALS['strBackgroundColor'] = "Kolor tła";
$GLOBALS['strBorderColor'] = "Kolor obramowania";

$GLOBALS['strDirection'] = "Kierunek";
$GLOBALS['strLeftToRight'] = "Lewa do prawej";
$GLOBALS['strRightToLeft'] = "Prawa do lewej";
$GLOBALS['strLooping'] = "Pętle";
$GLOBALS['strAlwaysActive'] = "Zawsze aktywny";
$GLOBALS['strSpeed'] = "Prędkość";
$GLOBALS['strPause'] = "Przerwij";
$GLOBALS['strLimited'] = "Ograniczony";
$GLOBALS['strLeftMargin'] = "Lewy margines";
$GLOBALS['strRightMargin'] = "Prawy margines";
$GLOBALS['strTransparentBackground'] = "Przezroczyste tło";

$GLOBALS['strSmoothMovement'] = "Płynny ruch";
$GLOBALS['strHideNotMoving'] = "Ukryj banner kiedy kursor się nie porusza";
$GLOBALS['strHideDelay'] = "Opóźnienie przed ukryciem bannera";
$GLOBALS['strHideTransparancy'] = "Przezroczystość ukrytego bannera";


$GLOBALS['strAdLayerStyleName'] = array();
$GLOBALS['strAdLayerStyleName']['simple'] = "Prosty";
$GLOBALS['strAdLayerStyleName']['cursor'] = "Kursor";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "Obsługa śledzenia kliknięć dla niezależnego serwera";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Wstaw kod Cache-Busting";

// Non-Img creatives Warning for zone image-only invocation

// unkown HTML tag type Warning for zone invocation

// sql/web banner-type warning for clickonly zone invocation

// IMG invocation selected for tracker with appended code
$GLOBALS['strImgWithAppendWarning'] = "Do trackera załączony jest kod, który funkcjonuje <strong>wyłącznie</strong> ze znacznikami JavaScript";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'> <strong> Ostrzeżenie: </strong> Lokalny tryb inwokacji będzie działać tylko w miejscu wywołania kodu na tej samej maszynie fizycznej co AdServer </span> <br /> Sprawdź, czy MAX_PATH określony w poniższym kodzie wskazuje na główną kategorię twojej instalacji MAX.<br />, oraz że masz plik config dla domeny strony, która pokazuje reklamy (w MAX_PATH / var)";

