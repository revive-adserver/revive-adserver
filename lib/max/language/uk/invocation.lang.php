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
$GLOBALS['strCopyToClipboard'] = "Скопировать в буфер обмена";
$GLOBALS['strCopy'] = "копировать";
$GLOBALS['strChooseTypeOfInvocation'] = "Виберіть тип банера.";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Виберіть тип банера.";

// Measures
$GLOBALS['strAbbrPixels'] = "px";
$GLOBALS['strAbbrSeconds'] = "сек";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Выбор баннеров";
$GLOBALS['strInvocationCampaignID'] = "Кампанія";
$GLOBALS['strInvocationTarget'] = "Фрейм назначения";
$GLOBALS['strInvocationSource'] = "Источник";
$GLOBALS['strInvocationWithText'] = "Показывать текст под баннером";
$GLOBALS['strInvocationDontShowAgain'] = "Не показывать баннер вторично на той же странице";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Не показывать баннер из той же кампании снова на той же странице";
$GLOBALS['strInvocationTemplate'] = "Сохранить баннер в переменной, так что его можно будет использовать в шаблоне";
$GLOBALS['strInvocationBannerID'] = "ID баннера";
$GLOBALS['strInvocationComments'] = "Включить комментарии";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "Обновить через";
$GLOBALS['strIframeResizeToBanner'] = "Привести размер к размеру баннера";
$GLOBALS['strIframeMakeTransparent'] = "Сделать iframe прозрачным";
$GLOBALS['strIframeIncludeNetscape4'] = "Включить совместимый с Netscape 4 ilayer";
$GLOBALS['strIframeGoogleClickTracking'] = "Включить код для подсчета кликов Google AdSense";

// PopUp
$GLOBALS['strPopUpStyle'] = "Тип Pop-up";
$GLOBALS['strPopUpStylePopUp'] = "Выскакивает над";
$GLOBALS['strPopUpStylePopUnder'] = "Выскакивает под";
$GLOBALS['strPopUpCreateInstance'] = "Instance when the pop-up is created";
$GLOBALS['strPopUpImmediately'] = "Немедленно";
$GLOBALS['strPopUpOnClose'] = "Когда страница закрывается";
$GLOBALS['strPopUpAfterSec'] = "Через";
$GLOBALS['strAutoCloseAfter'] = "Автоматически закрыть через";
$GLOBALS['strPopUpTop'] = "Начальная позиция (верх)";
$GLOBALS['strPopUpLeft'] = "Начальная позиция (левый край)";
$GLOBALS['strWindowOptions'] = "Window options";
$GLOBALS['strShowToolbars'] = "Toolbars";
$GLOBALS['strShowLocation'] = "Location";
$GLOBALS['strShowMenubar'] = "Menubar";
$GLOBALS['strShowStatus'] = "Статус";
$GLOBALS['strWindowResizable'] = "Resizable";
$GLOBALS['strShowScrollbars'] = "Scrollbars";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Язык хоста";
$GLOBALS['strXmlRpcProtocol'] = "Use HTTPS to contact XML-RPC Server";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC Timeout (Seconds)";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Вставить код, запрещающий кэширование";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Попередження";
$GLOBALS['strImgWithAppendWarning'] = "Трекер имеет встроенный код, который должен располагаться внутри контейнера JavaScript";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
is on the same physical machine as the adserver</span><br />
Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Note:</b> Local Mode invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Note:</b> XML-RPC invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
