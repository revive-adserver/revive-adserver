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

/** status messages * */
$GLOBALS['strInstallStatusRecovery'] = 'Revive Adserver %s 복구중';
$GLOBALS['strInstallStatusInstall'] = 'Revive Adserver %s 설치중';
$GLOBALS['strInstallStatusUpgrade'] = 'Revive Adserver %s 업그레이드 중';
$GLOBALS['strInstallStatusUpToDate'] = 'Revive Adserver %s 감지됨';

/** welcome step * */
$GLOBALS['strWelcomeTitle'] = "{$PRODUCT_NAME}";
$GLOBALS['strInstallIntro'] = "{$PRODUCT_NAME}를 선택해 주셔서 감사합니다. 이 마법사는 {$PRODUCT_NAME}를 설치 하는 과정을 안내 합니다.";
$GLOBALS['strUpgradeIntro'] = "{$PRODUCT_NAME}를 선택해 주셔서 감사합니다. 이 마법사는 {$PRODUCT_NAME}를 업그레이드 하는 과정을 안내 합니다.";
$GLOBALS['strInstallerHelpIntro'] = "{$PRODUCT_NAME} 설치 과정에 도움이 필요할 경우, <a href='{$PRODUCT_DOCSURL}' target='_blank'>문서</a>를 참조 하십시오.";
$GLOBALS['strTermsIntro'] = "{$PRODUCT_NAME}은(는) 오픈 소스 라이선스, GNU 일반 공중 사용 허가서에 자유롭게 배포 됩니다. 검토 하시고 설치를 계속 하려면 다음 문서에 동의 하십시오.";

/** check step * */
$GLOBALS['strSystemCheck'] = "시스템 검사";
$GLOBALS['strSystemCheckIntro'] = "설치 마법사가 설치에 필요한 필수 조건을 확인하였습니다.
                                                  <br>설치를 완료하시려면 하이라이트 된 문제들을 전부 확인하십시오.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "웹 서버의 구성이 {$PRODUCT_NAME}을(를) 사용하기에 적합하지 않습니다.
                                                   <br>설치를 계속하기 위해서는 모든 오류를 수정하셔야 합니다.
                                                   도움이 필요하시다면, <a href='{$PRODUCT_DOCSURL}'>도움말 문서</a>와 <a href='http://{$PRODUCT_URL}/faq'>FAQ</a>를 참고하십시오.";

$GLOBALS['strAppCheckErrors'] = "{$PRODUCT_NAME}의 이전 버전을 감지하는 중 오류가 발생하였습니다";
$GLOBALS['strAppCheckDbIntegrityError'] = "데이터베이스 무결성 문제를 감지 했습니다.
                                                   즉, 데이터베이스의 구조가 기본 설치와 다릅니다. 데이터베이스의 커스텀화 때문일 수 있습니다.";

$GLOBALS['strSyscheckProgressMessage'] = "시스템 매개 변수 확인...";
$GLOBALS['strError'] = "오류";
$GLOBALS['strWarning'] = "경고";
$GLOBALS['strOK'] = "예";
$GLOBALS['strSyscheckName'] = "이름 확인";
$GLOBALS['strSyscheckValue'] = "현재 값";
$GLOBALS['strSyscheckStatus'] = "상태";
$GLOBALS['strSyscheckSeeFullReport'] = "자세한 시스템 체크 표시";
$GLOBALS['strSyscheckSeeShortReport'] = "오류 및 경고만 표시";
$GLOBALS['strBrowserCookies'] = '브라우저 쿠키';
$GLOBALS['strPHPConfiguration'] = 'PHP 구성';
$GLOBALS['strCheckError'] = '오류';
$GLOBALS['strCheckErrors'] = '오류';
$GLOBALS['strCheckWarning'] = '경고';
$GLOBALS['strCheckWarnings'] = '경고';

/** admin login step * */
$GLOBALS['strAdminLoginTitle'] = "{$PRODUCT_NAME}에 관리자 권한으로 로그인 하십시오";
$GLOBALS['strAdminLoginIntro'] = "계속 하시려면, {$PRODUCT_NAME}의 시스템 관리자 계정 로그인 정보를 입력 해 주시기 바랍니다.";
$GLOBALS['strLoginProgressMessage'] = '로그인 중...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "데이터베이스 설정 입력";
$GLOBALS['strDbSetupIntro'] = "{$PRODUCT_NAME} 데이터베이스 연결 정보를 입력하십시오.";
$GLOBALS['strDbUpgradeTitle'] = "기존 데이터베이스가 검색 되었습니다.";
$GLOBALS['strDbUpgradeIntro'] = "다음 {$PRODUCT_NAME} 의 데이터베이스가 감지되었습니다.
                                                   올바른 데이터베이스인지 확인 후 \"계속\"을 눌러 계속하십시오.";
$GLOBALS['strDbProgressMessageInstall'] = '데이터베이스 설치 중...';
$GLOBALS['strDbProgressMessageUpgrade'] = '데이터베이스 업그레이드 중...';
$GLOBALS['strDbTimeZoneWarning'] = "<p>{$PRODUCT_NAME}의 이 버전은 시간을 UTC 시간이 아닌 현지 시간으로 저장합니다.</p>
                                                   <p>만일 기존 자료의 시간이 정상적으로 표시되기를 원하신다면, 데이터를 수동으로 업그레이드 하셔야 합니다. <a target='help' href='%s'>이 링크</a>를 참고하십시오.
                                                      데이터를 변경하지 않아도 통계 값은 정확히 유지됩니다.
                                                   </p>";
$GLOBALS['strDbTimeZoneNoWarnings'] = "다음부터 표준 시간대 경고를 보지 않음";
$GLOBALS['strDBInstallSuccess'] = "데이터베이스가 성공적으로 생성되었습니다";
$GLOBALS['strDBUpgradeSuccess'] = "데이터베이스가 성공적으로 업그레이드 되었습니다.";

$GLOBALS['strDetectedVersion'] = "{$PRODUCT_NAME} 버전 감지됨";

/** config step * */
$GLOBALS['strConfigureInstallTitle'] = "로컬 {$PRODUCT_NAME} 시스템 관리자 계정 구성";
$GLOBALS['strConfigureInstallIntro'] = "로컬 {$PRODUCT_NAME} 시스템 관리자 계정의 원하는 로그인 정보를 입력 하십시오.";
$GLOBALS['strConfigureUpgradeTitle'] = "구성 설정";
$GLOBALS['strConfigureUpgradeIntro'] = "이전 {$PRODUCT_NAME}의 설치 경로를 입력하시오.";
$GLOBALS['strPreviousInstallTitle'] = "이전 설치";

/** jobs step * */


/** finish step * */


