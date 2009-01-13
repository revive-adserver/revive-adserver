<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

// Invocation Types
$GLOBALS['strInvocationRemote']			= "Удалённый вызов";
$GLOBALS['strInvocationJS']			= "Удалённый вызов с Javascript";
$GLOBALS['strInvocationIframes']		= "Удалённый вызов для фреймов";
$GLOBALS['strInvocationXmlRpc']			= "Удалённый вызов с использованием XML-RPC";
$GLOBALS['strInvocationCombined']		= "Совмещённый удалённый вызов";
$GLOBALS['strInvocationPopUp']			= "Pop-up";
$GLOBALS['strInvocationAdLayer']		= "Interstitial или плавающий DHTML";
$GLOBALS['strInvocationLocal']			= "Локальный режим";


// Other
$GLOBALS['strCopyToClipboard']			= "Скопировать в буфер обмена";


// Measures
$GLOBALS['strAbbrPixels']			= "px";
$GLOBALS['strAbbrSeconds']			= "сек";


// Common Invocation Parameters
$GLOBALS['strInvocationWhat']			= "Выбор баннеров";
$GLOBALS['strInvocationClientID']		= "Рекламодатель или кампания";
$GLOBALS['strInvocationTarget']			= "Фрейм назначения";
$GLOBALS['strInvocationSource']			= "Источник";
$GLOBALS['strInvocationWithText']		= "Показывать текст под баннером";
$GLOBALS['strInvocationDontShowAgain']		= "Не показывать баннер вторично на той же странице";
$GLOBALS['strInvocationTemplate'] 		= "Сохранить баннер в переменной, так что его можно будет использовать в шаблоне";


// Iframe
$GLOBALS['strIFrameRefreshAfter']		= "Обновить через";
$GLOBALS['strIframeResizeToBanner']		= "Привести размер к размеру баннера";
$GLOBALS['strIframeMakeTransparent']		= "Сделать iframe прозрачным";
$GLOBALS['strIframeIncludeNetscape4']		= "Включить совместимый с Netscape 4 ilayer";


// PopUp
$GLOBALS['strPopUpStyle']			= "Тип Pop-up";
$GLOBALS['strPopUpStylePopUp']			= "Выскакивает над";
$GLOBALS['strPopUpStylePopUnder']		= "Выскакивает под";
$GLOBALS['strPopUpCreateInstance']		= "Instance when the pop-up is created";
$GLOBALS['strPopUpImmediately']			= "Немедленно";
$GLOBALS['strPopUpOnClose']			= "Когда страница закрывается";
$GLOBALS['strPopUpAfterSec']			= "Через";
$GLOBALS['strAutoCloseAfter']			= "Автоматически закрыть через";
$GLOBALS['strPopUpTop']				= "Начальная позиция (верх)";
$GLOBALS['strPopUpLeft']			= "Начальная позиция (левый край)";


// XML-RPC
$GLOBALS['strXmlRpcLanguage']			= "Язык хоста";


// AdLayer
$GLOBALS['strAdLayerStyle']			= "Стиль";

$GLOBALS['strAlignment']			= "Выравнивание";
$GLOBALS['strHAlignment']			= "Горизонтальное выравнивание";
$GLOBALS['strLeft']				= "Влево";
$GLOBALS['strCenter']				= "По центру";
$GLOBALS['strRight']				= "Вправо";

$GLOBALS['strVAlignment']			= "Вертикальное выравнивание";
$GLOBALS['strTop']				= "Вверх";
$GLOBALS['strMiddle']				= "Посередине";
$GLOBALS['strBottom']				= "Вниз";

$GLOBALS['strAutoCollapseAfter']		= "Автоматически сложить через";
$GLOBALS['strCloseText']			= "Закрыть текст";
$GLOBALS['strClose']				= "[Закрыть]";
$GLOBALS['strBannerPadding']			= "Подбивка баннера";

$GLOBALS['strHShift']				= "Горизонтальный сдвиг";
$GLOBALS['strVShift']				= "Вертикальный сдвиг";

$GLOBALS['strShowCloseButton']			= "Показать кнопку закрытия";
$GLOBALS['strBackgroundColor']			= "Цвет фона";
$GLOBALS['strBorderColor']			= "Цвет рамки";

$GLOBALS['strDirection']			= "Направление";
$GLOBALS['strLeftToRight']			= "Слева направо";
$GLOBALS['strRightToLeft']			= "Справа налево";
$GLOBALS['strLooping']				= "Зациклено";
$GLOBALS['strAlwaysActive']			= "Всегда активно";
$GLOBALS['strSpeed']				= "Скорость";
$GLOBALS['strPause']				= "Приостановить";
$GLOBALS['strLimited']				= "Ограничено";
$GLOBALS['strLeftMargin']			= "Левое поле";
$GLOBALS['strRightMargin']			= "Правое поле";
$GLOBALS['strTransparentBackground']		= "Прозрачный фон";

$GLOBALS['strSmoothMovement']           = "Плавное движение";
$GLOBALS['strHideNotMoving']            = "Спрятать баннер когда курсор не движется";
$GLOBALS['strHideDelay']                        = "Задержка перед сокрытием баннера";
$GLOBALS['strHideTransparancy']         = "Прозрачность спрятанного баннера";


$GLOBALS['strAdLayerStyleName']['geocities'] = "Geocities";
$GLOBALS['strAdLayerStyleName']['simple'] = "Простой";
$GLOBALS['strAdLayerStyleName']['cursor'] = "Курсор";
$GLOBALS['strAdLayerStyleName']['floater'] = "Плавающий";




// Note: new translatiosn not found in original lang files but found in CSV
$GLOBALS['strCopy'] = "копировать";
$GLOBALS['strInvocationCampaignID'] = "Кампания";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Не показывать баннер из той же кампании снова на той же странице";
$GLOBALS['strInvocationBannerID'] = "ID баннера";
$GLOBALS['strInvocationComments'] = "Включить комментарии";
$GLOBALS['str3rdPartyTrack'] = "Поддержка учета кликов";
$GLOBALS['strCacheBuster'] = "Вставить код, запрещающий кэширование";
$GLOBALS['strImgWithAppendWarning'] = "Трекер имеет встроенный код, который должен располагаться внутри контейнера JavaScript";


// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strIframeGoogleClickTracking'] = "Включить код для подсчета кликов Google AdSense";
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Внимание:</strong> Локальный режим вызова баннеров работает только при вызове кода с той же физической машины, что и рекламный сервер.</span><br />Проверьте, что переменная MAX_PATH указывает на базовую папку вашей инсталляции<br />и у вас есть соответствующий файл конфигурации в MAX_PATH/var";
$GLOBALS['strChooseTypeOfInvocation'] = "Пожалуйста, выберите тип вызова";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Пожалуйста, выберите тип вызова баннера";
?>