<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
$GLOBALS['strInvocationRemote']			= "원격 호출";
$GLOBALS['strInvocationJS']			= "원격 호출(자바스크립트용)";
$GLOBALS['strInvocationIframes']		= "원격 호출(프레임용)";
$GLOBALS['strInvocationXmlRpc']			= "XML-RPC를 이용한 원격 호출";
$GLOBALS['strInvocationCombined']		= "원격 호출 조합";
$GLOBALS['strInvocationPopUp']			= "팝업";
$GLOBALS['strInvocationAdLayer']		= "격자 또는 플로팅 DHTML";
$GLOBALS['strInvocationLocal']			= "로컬 모드";


// Other
$GLOBALS['strCopyToClipboard']			= "클립보드에 복사";


// Measures
$GLOBALS['strAbbrPixels']			= "px";
$GLOBALS['strAbbrSeconds']			= "sec";


// Common Invocation Parameters
$GLOBALS['strInvocationWhat']			= "배너 선택";
$GLOBALS['strInvocationClientID']		= "광고주 또는 캠페인";
$GLOBALS['strInvocationTarget']			= "대상 프레임";
$GLOBALS['strInvocationSource']			= "소스";
$GLOBALS['strInvocationWithText']		= "배너 밑에 텍스트를 표시합니다.";
$GLOBALS['strInvocationDontShowAgain']		= "같은 페이지에 연속해서 배너를 표시하지 않습니다.";
$GLOBALS['strInvocationTemplate'] 		= "배너를 템플릿에서 사용할 수 있도록 변수에 저장합니다.";


// Iframe
$GLOBALS['strIFrameRefreshAfter']		= "새로고침 간격";
$GLOBALS['strIframeResizeToBanner']		= "iframe을 배너에 맞게 크기 조정";
$GLOBALS['strIframeMakeTransparent']		= "iframe을 투명하게 설정";
$GLOBALS['strIframeIncludeNetscape4']		= "넷스케이프 4 ilayer 호환";


// PopUp
$GLOBALS['strPopUpStyle']			= "팝업 형식";
$GLOBALS['strPopUpStylePopUp']			= "팝업";
$GLOBALS['strPopUpStylePopUnder']		= "팝언더";
$GLOBALS['strPopUpCreateInstance']		= "팝업이 생성되는 경우";
$GLOBALS['strPopUpImmediately']			= "바로 띄우기";
$GLOBALS['strPopUpOnClose']			= "페이지를 닫을 때";
$GLOBALS['strPopUpAfterSec']			= "후에 ";
$GLOBALS['strAutoCloseAfter']			= "후에 자동으로 닫음";
$GLOBALS['strPopUpTop']				= "격자 배너 위치(top)";
$GLOBALS['strPopUpLeft']			= "격자 배너 위치(left)";


// XML-RPC
$GLOBALS['strXmlRpcLanguage']			= "사용 언어";


// AdLayer
$GLOBALS['strAdLayerStyle']			= "배너 형식";

$GLOBALS['strAlignment']			= "정렬";
$GLOBALS['strHAlignment']			= "가로 정렬";
$GLOBALS['strLeft']				= "Left";
$GLOBALS['strCenter']				= "Center";
$GLOBALS['strRight']				= "Right";

$GLOBALS['strVAlignment']			= "세로 정렬";
$GLOBALS['strTop']				= "Top";
$GLOBALS['strMiddle']				= "Middle";
$GLOBALS['strBottom']				= "Bottom";

$GLOBALS['strAutoCollapseAfter']		= "지정된 시간 이후에 자동으로 닫음";
$GLOBALS['strCloseText']			= "배너 닫기 문구(Close text)";
$GLOBALS['strClose']				= "[Close]";
$GLOBALS['strBannerPadding']			= "배너 간격(padding)";

$GLOBALS['strHShift']				= "수평 이동";
$GLOBALS['strVShift']				= "수직 이동";

$GLOBALS['strShowCloseButton']			= "닫기 버튼 표시";
$GLOBALS['strBackgroundColor']			= "배경색";
$GLOBALS['strBorderColor']			= "테두리 색";

$GLOBALS['strDirection']			= "방향";
$GLOBALS['strLeftToRight']			= "왼쪽에서 오른쪽으로";
$GLOBALS['strRightToLeft']			= "오른쪽에서 왼쪽으로";
$GLOBALS['strLooping']				= "반복하기";
$GLOBALS['strAlwaysActive']			= "항상 사용";
$GLOBALS['strSpeed']				= "Speed";
$GLOBALS['strPause']				= "Pause";
$GLOBALS['strLimited']				= "Limited";
$GLOBALS['strLeftMargin']			= "왼쪽 여백";
$GLOBALS['strRightMargin']			= "오른쪽 여백";
$GLOBALS['strTransparentBackground']		= "배경 투명색";

$GLOBALS['strSmoothMovement']		= "Smooth movement";
$GLOBALS['strHideNotMoving']		= "Hide the banner when the cursor is not moving";
$GLOBALS['strHideDelay']			= "Delay before banner is hidden";
$GLOBALS['strHideTransparancy']		= "Transparancy of the hidden banner";


$GLOBALS['strAdLayerStyleName']['geocities'] = "Geocities";
$GLOBALS['strAdLayerStyleName']['simple'] = "Simple";
$GLOBALS['strAdLayerStyleName']['cursor'] = "Cursor";
$GLOBALS['strAdLayerStyleName']['floater'] = "Floater";




// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strChooseTypeOfInvocation'] = "호출할 배너 종류를 선택하세요.";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "호출할 배너 종류를 선택하세요.";
?>