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

// Main strings
$GLOBALS['strChooseSection'] = "섹션 선택";
$GLOBALS['strAppendCodes'] = "코드 추가";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>예약된 유지 보수가 한시간 동안 실행되지 않았습니다. 설정이 잘못되었을 수 있습니다.</b>";

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "	자동 유지보수는 활성화 되어 있지만, 동작한 적이 없습니다. 자동 유지보수는 {$PRODUCT_NAME}이 광고를 표시할 때 작동합니다.
    최상의 성능을 위해,<a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>예약된 유지보수</a>를 설정하시는 것이 좋습니다.";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "	자동 유지보수가 비활성화 되어 있습니다. 따라서 {$PRODUCT_NAME}(이)가 광고를 표시할 때에도 자동 유지보수가 동작하지 않습니다.
최상의 성능을 위해,<a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>예약된 유지보수</a>를 설정하시는 것이 좋습니다.
    하지만, 만일 <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>예약된 유지보수</a>를 설정하지 않으실 것이라면,
    <a href='account-settings-maintenance.php'>자동 유지보수</a>를 활성화하여 {$PRODUCT_NAME}(이)가 확실히 정상적으로 동작하도록 할 필요성이 있습니다.";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "	자동 유지보수가 활성화 되었으며, {$PRODUCT_NAME}(이)가 광고를 표시할 때 작동됩니다.
하지만, 최상의 성능을 위해,<a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>예약된 유지보수</a>를 설정하시는 것이 좋습니다.";





// Priority
$GLOBALS['strRecalculatePriority'] = "우선순위 다시 계산";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "배너 캐시 확인";
$GLOBALS['strRebuildDeliveryCache'] = "전달유지 �?시 다시 빌드";
$GLOBALS['strBannerCacheExplaination'] = "	The banner cache contains a copy of the HTML code which is used to display the banner. By using a banner cache it is possible to speed
	up the delivery of banners because the HTML code doesn't need to be generated every time a banner is being delivered. Because the
	banner cache contains hard coded URLs to the location of {$PRODUCT_NAME} and its banners, the cache needs to be updated
	everytime {$PRODUCT_NAME} is moved to another location on the webserver.";

// Cache
$GLOBALS['strCache'] = "전달유지 �?시";
$GLOBALS['strDeliveryCacheSharedMem'] = "현재 전달유지 �?시를 저장하기 위해 공유 메모리를 사용하고 있습니다.";
$GLOBALS['strDeliveryCacheDatabase'] = "현재 전달유지 �?시를 저장하기 위해 �?��?�터베�?�스를 사용하고 있습니다.";

// Storage
$GLOBALS['strStorage'] = "저장�?역";
$GLOBALS['strMoveToDirectory'] = "�?��?�터베�?�스�? 저장�?� �?�미지를 디렉터리로 옮기기";
$GLOBALS['strStorageExplaination'] = "로컬 배너로 사용하는 �?�미지는 �?��?�터베�?�스 �?는 디렉터리�? 저장�?�어 있습니다. �?�미지를 디렉터리�? 저장한 경우�?는 �?��?�터베�?�스�? 대한 부하를 줄임으로�?� �?�?�를 향�?시킬 수 있습니다.";

// Security

// Encoding
$GLOBALS['strEncoding'] = "인코딩";
$GLOBALS['strEncodingConvertTest'] = "변환 테스트";
$GLOBALS['strConvertThese'] = "계속하시는 경우 다음 데이터가 변경됩니다.";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "업�?��?�트를 겅색중입니다. 잠시 기다려주십시오...";
$GLOBALS['strAvailableUpdates'] = "�?�용할 수 있는 업�?��?�트";
$GLOBALS['strDownloadZip'] = "다운로드(.zip)";
$GLOBALS['strDownloadGZip'] = "다운로드(.tar.gz)";

$GLOBALS['strUpdateAlert'] = "{$PRODUCT_NAME}�?� 새 버전�?� �?�용할 수 있습니다.

새 업�?��?�트�? 대한 �?세한 정보를 보겠습니까?";
$GLOBALS['strUpdateAlertSecurity'] = "{$PRODUCT_NAME}�?� 새 버전�?� �?�용할 수 있습니다.

새 버전�?� 하나 �?는 그 �?��?�?� 보안 수정�?� �?�함하고 있으므로 가능한한 빨리 업그레�?�드할 것�?� 권합니다.";

$GLOBALS['strUpdateServerDown'] = "    Due to an unknown reason it isn't possible to retrieve <br>
	information about possible updates. Please try again later.";

$GLOBALS['strNoNewVersionAvailable'] = "	현재 사용중�?� {$PRODUCT_NAME}�?� 버전�?� 최신입니다. 현재 �?�용할 수 있는 업�?��?�트가 없습니다.";



$GLOBALS['strNewVersionAvailable'] = "	<b>A new version of {$PRODUCT_NAME} is available.</b><br> It is recommended to install this update,
	because it may fix some currently existing problems and will add new features. For more information
	about upgrading please read the documentation which is included in the files below.";

$GLOBALS['strSecurityUpdate'] = "	<b>It is highly recommended to install this update as soon as possible, because it contains a number
	of security fixes.</b> The version of {$PRODUCT_NAME} which you are currently using might
	be vulnerable to certain attacks and is probably not secure. For more information
	about upgrading please read the documentation which is included in the files below.";



$GLOBALS['strClickToVisitWebsite'] = "	Click here to visit our website";

//  Deliver Limitations

//  Append codes

$GLOBALS['strPlugins'] = "플러그인";

$GLOBALS['strMenus'] = "메뉴";
$GLOBALS['strMenusPrecis'] = "메뉴 캐시를 다시 작성";
$GLOBALS['strMenusCachedOk'] = "메뉴 캐시가 다시 작성됨";

// Users
