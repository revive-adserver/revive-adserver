<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
$GLOBALS['strInvocationWhat']			= "Набор баннеров";
$GLOBALS['strInvocationClientID']		= "Рекламодатель или кампания";
$GLOBALS['strInvocationTarget']			= "Фрейм назначения";
$GLOBALS['strInvocationSource']			= "Источник";
$GLOBALS['strInvocationWithText']		= "Показывать текст под баннером";
$GLOBALS['strInvocationDontShowAgain']		= "Не показывать баннер вторично на той же странице";
$GLOBALS['strInvocationTemplate'] 		= "Сохранить баннер в переменной, так что его можно будет использовать в шаблоне";


// Iframe
$GLOBALS['strIFrameRefreshAfter']		= "Обновить через";
$GLOBALS['strIframeResizeToBanner']		= "Привести размер к размеру баннераs";
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
$GLOBALS['strPause']				= "Пауза";
$GLOBALS['strLimited']				= "Ограничено";
$GLOBALS['strLeftMargin']			= "Левое поле";
$GLOBALS['strRightMargin']			= "Правое поле";
$GLOBALS['strTransparentBackground']		= "Прозрачный фон";

$GLOBALS['strSmoothMovement']           = "Плавное движение";
$GLOBALS['strHideNotMoving']            = "Спрятать баннер когда курсор не движется";
$GLOBALS['strHideDelay']                        = "Задержка перед сокрытием баннера";
$GLOBALS['strHideTransparancy']         = "Прозрачность спрятанного баннера";


$GLOBALS['strAdLayerStyleName']	= array(
	'geocities'		=> "Geocities",
	'simple'		=> "Простой",
	'cursor'		=> "Курсор",
	'floater'		=> "Плавающий"
);

?>
