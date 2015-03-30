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
$GLOBALS['strAbbrSeconds'] = "сек";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Выбор баннеров";
$GLOBALS['strInvocationClientID'] = "Клієнт";
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
$GLOBALS['strPopUpImmediately'] = "Немедленно";
$GLOBALS['strPopUpOnClose'] = "Когда страница закрывается";
$GLOBALS['strPopUpAfterSec'] = "Через";
$GLOBALS['strAutoCloseAfter'] = "Автоматически закрыть через";
$GLOBALS['strPopUpTop'] = "Начальная позиция (верх)";
$GLOBALS['strPopUpLeft'] = "Начальная позиция (левый край)";
$GLOBALS['strShowStatus'] = "Статус";


// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Язык хоста";


// AdLayer
$GLOBALS['strAdLayerStyle'] = "Стиль";

$GLOBALS['strAlignment'] = "Выравнивание";
$GLOBALS['strHAlignment'] = "Горизонтальное выравнивание";
$GLOBALS['strLeft'] = "Влево";
$GLOBALS['strCenter'] = "По центру";
$GLOBALS['strRight'] = "Вправо";

$GLOBALS['strVAlignment'] = "Вертикальное выравнивание";
$GLOBALS['strTop'] = "Вверх";
$GLOBALS['strMiddle'] = "Посередине";
$GLOBALS['strBottom'] = "Вниз";

$GLOBALS['strAutoCollapseAfter'] = "Автоматически сложить через";
$GLOBALS['strCloseText'] = "Закрыть текст";
$GLOBALS['strClose'] = "[Закрыть]";
$GLOBALS['strBannerPadding'] = "Подбивка баннера";

$GLOBALS['strHShift'] = "Горизонтальный сдвиг";
$GLOBALS['strVShift'] = "Вертикальный сдвиг";

$GLOBALS['strShowCloseButton'] = "Показать кнопку закрытия";
$GLOBALS['strBackgroundColor'] = "Цвет фона";
$GLOBALS['strBorderColor'] = "Цвет рамки";

$GLOBALS['strDirection'] = "Направление";
$GLOBALS['strLeftToRight'] = "Слева направо";
$GLOBALS['strRightToLeft'] = "Справа налево";
$GLOBALS['strLooping'] = "Зациклено";
$GLOBALS['strAlwaysActive'] = "Всегда активно";
$GLOBALS['strSpeed'] = "Скорость";
$GLOBALS['strPause'] = "Припинити";
$GLOBALS['strLimited'] = "Ограничено";
$GLOBALS['strLeftMargin'] = "Левое поле";
$GLOBALS['strRightMargin'] = "Правое поле";
$GLOBALS['strTransparentBackground'] = "Прозрачный фон";

$GLOBALS['strSmoothMovement'] = "Плавное движение";
$GLOBALS['strHideNotMoving'] = "Спрятать баннер когда курсор не движется";
$GLOBALS['strHideDelay'] = "Задержка перед сокрытием баннера";
$GLOBALS['strHideTransparancy'] = "Прозрачность спрятанного баннера";


$GLOBALS['strAdLayerStyleName'] = array();
$GLOBALS['strAdLayerStyleName']['simple'] = "Простой";
$GLOBALS['strAdLayerStyleName']['cursor'] = "Курсор";
$GLOBALS['strAdLayerStyleName']['floater'] = "Плавающий";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "Поддержка учета кликов";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Вставить код, запрещающий кэширование";

// Non-Img creatives Warning for zone image-only invocation

// unkown HTML tag type Warning for zone invocation

// sql/web banner-type warning for clickonly zone invocation

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Попередження";
$GLOBALS['strImgWithAppendWarning'] = "Трекер имеет встроенный код, который должен располагаться внутри контейнера JavaScript";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Внимание:</strong> Локальный режим вызова баннеров работает только при вызове кода с той же физической машины, что и рекламный сервер.</span><br />Проверьте, что переменная MAX_PATH указывает на базовую папку вашей инсталляции<br />и у вас есть соответствующий файл конфигурации в MAX_PATH/var";

