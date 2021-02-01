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
$GLOBALS['strCopyToClipboard'] = "클립보드에 복사";
$GLOBALS['strCopy'] = "copy";
$GLOBALS['strChooseTypeOfInvocation'] = "호출할 배너 종류를 선택하세요.";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "배너 유형을 선택해 주십시오.";

// Measures
$GLOBALS['strAbbrPixels'] = "px";
$GLOBALS['strAbbrSeconds'] = "sec";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "배너 선택";
$GLOBALS['strInvocationCampaignID'] = "캠페인";
$GLOBALS['strInvocationTarget'] = "대상 프레임";
$GLOBALS['strInvocationSource'] = "소스";
$GLOBALS['strInvocationWithText'] = "배너 밑에 텍스트를 표시합니다.";
$GLOBALS['strInvocationDontShowAgain'] = "같은 페이지에 연속해서 배너를 표시하지 않습니다.";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Don't show a banner from the same campaign again on the same page";
$GLOBALS['strInvocationTemplate'] = "배너를 템플릿에서 사용할 수 있도록 변수에 저장합니다.";
$GLOBALS['strInvocationBannerID'] = "Banner ID";
$GLOBALS['strInvocationComments'] = "Include comments";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "새로고침 간격";
$GLOBALS['strIframeResizeToBanner'] = "iframe을 배너에 맞게 크기 조정";
$GLOBALS['strIframeMakeTransparent'] = "iframe을 투명하게 설정";
$GLOBALS['strIframeIncludeNetscape4'] = "넷스케이프 4 ilayer 호환";
$GLOBALS['strIframeGoogleClickTracking'] = "Include code to track Google AdSense clicks";

// PopUp
$GLOBALS['strPopUpStyle'] = "팝업 형식";
$GLOBALS['strPopUpStylePopUp'] = "팝업";
$GLOBALS['strPopUpStylePopUnder'] = "팝언더";
$GLOBALS['strPopUpCreateInstance'] = "팝업이 생성되는 경우";
$GLOBALS['strPopUpImmediately'] = "바로 띄우기";
$GLOBALS['strPopUpOnClose'] = "페이지를 닫을 때";
$GLOBALS['strPopUpAfterSec'] = "후에 ";
$GLOBALS['strAutoCloseAfter'] = "후에 자동으로 닫음";
$GLOBALS['strPopUpTop'] = "격자 배너 위치(top)";
$GLOBALS['strPopUpLeft'] = "격자 배너 위치(left)";
$GLOBALS['strWindowOptions'] = "창 옵션";
$GLOBALS['strShowToolbars'] = "Toolbars";
$GLOBALS['strShowLocation'] = "위치";
$GLOBALS['strShowMenubar'] = "Menubar";
$GLOBALS['strShowStatus'] = "Status";
$GLOBALS['strWindowResizable'] = "Resizable";
$GLOBALS['strShowScrollbars'] = "Scrollbars";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "사용 언어";
$GLOBALS['strXmlRpcProtocol'] = "Use HTTPS to contact XML-RPC Server";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC Timeout (Seconds)";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Insert Cache-Busting code";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "경고";
$GLOBALS['strImgWithAppendWarning'] = "This tracker has appended code, appended code will <strong>only</strong> work with JavaScript tags";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
is on the same physical machine as the adserver</span><br />
Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Note:</b> Local Mode invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Note:</b> XML-RPC invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
