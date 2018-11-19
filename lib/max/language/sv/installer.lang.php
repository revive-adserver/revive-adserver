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
$GLOBALS['strInstallStatusRecovery'] = 'Återställa Revive Adserver %s';
$GLOBALS['strInstallStatusInstall'] = 'Installera ReviveAdserver %s';
$GLOBALS['strInstallStatusUpgrade'] = 'Uppgradera till Revive Adserver %s';
$GLOBALS['strInstallStatusUpToDate'] = 'Upptäckte Revive Adserver %s';

/** welcome step * */
$GLOBALS['strWelcomeTitle'] = "Välkommen till {$PRODUCT_NAME}";
$GLOBALS['strInstallIntro'] = "Tack för att du valde {$PRODUCT_NAME}. Guiden vägleder dig genom processen att installera {$PRODUCT_NAME}.";
$GLOBALS['strUpgradeIntro'] = "Tack för att du valde {$PRODUCT_NAME}. Guiden vägleder dig genom processen att uppgradera {$PRODUCT_NAME}.";
$GLOBALS['strInstallerHelpIntro'] = "För att hjälpa dig med installationen av {$PRODUCT_NAME}, se <a href='{$PRODUCT_DOCSURL}' target='_blank'>dokumentationen</a>.";
$GLOBALS['strTermsIntro'] = "{$PRODUCT_NAME} distribueras fritt under en öppen källkodslicens, GNU General Public License. Vänligen läs och godkänn följande dokument för att fortsätta installationen.";

/** check step * */
$GLOBALS['strSystemCheck'] = "Systemkontroll";
$GLOBALS['strSystemCheckIntro'] = "Installationsguiden har utfört en kontroll av dina serverinställningar för att försäkra sig om  att installationen kan slutföras.
                                                  <br>Vänligen kontrollera eventuella markerade problem för att slutföra installationsprocessen.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Konfigurationen på din webbserver uppfyller inte kraven för {$PRODUCT_NAME}.
                                                   <br>för att fortsätta med installationen, vänligen åtgärda alla fel.
                                                   för hjälp, se vår <a href='{$PRODUCT_DOCSURL}'>dokumentation</a> och <a href='http://{$PRODUCT_URL}/faq'>vanliga frågor</a>";

$GLOBALS['strAppCheckErrors'] = "Fel påträffades med upptäckt av tidigare installationer av {$PRODUCT_NAME}";
$GLOBALS['strAppCheckDbIntegrityError'] = "Vi har upptäckt integritetsproblem med databasen. Detta innebär att strukturen för din databas
                                                   skiljer sig från vad vi förväntar oss att det ska vara. Detta kan bero på anpassningar av databasen.";

$GLOBALS['strSyscheckProgressMessage'] = "Kontrollera systemparametrar...";
$GLOBALS['strError'] = "Fel";
$GLOBALS['strWarning'] = "Varning";
$GLOBALS['strOK'] = "OK";
$GLOBALS['strSyscheckName'] = "Kontrollera namn";
$GLOBALS['strSyscheckValue'] = "Nuvarande värde";
$GLOBALS['strSyscheckStatus'] = "Status";
$GLOBALS['strSyscheckSeeFullReport'] = "Visa detaljerad systemkontroll";
$GLOBALS['strSyscheckSeeShortReport'] = "Visa bara fel och varningar";
$GLOBALS['strBrowserCookies'] = 'Cookies i webbläsaren';
$GLOBALS['strPHPConfiguration'] = 'PHP-konfigurationen';
$GLOBALS['strCheckError'] = 'fel';
$GLOBALS['strCheckErrors'] = 'fel';
$GLOBALS['strCheckWarning'] = 'varning';
$GLOBALS['strCheckWarnings'] = 'varningar';

/** admin login step * */
$GLOBALS['strAdminLoginTitle'] = "Vänligen logga in som administratör för {$PRODUCT_NAME}";
$GLOBALS['strLoginProgressMessage'] = 'Loggar in...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "Ange din databas";
$GLOBALS['strDbSetupIntro'] = "Ange uppgifter för att ansluta till {$PRODUCT_NAME} -databasen.";
$GLOBALS['strDbUpgradeTitle'] = "Din databas har hittats";
$GLOBALS['strDbUpgradeIntro'] = "Följande databaser har hittats för din installation av {$PRODUCT_NAME}.
                                                   vänligen kontrollera att detta är korrekt och klicka sedan ”Fortsätt” för att fortsätta.";
$GLOBALS['strDbProgressMessageInstall'] = 'Installerar databas...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Uppgraderar databas...';
$GLOBALS['strDbSeeMoreFields'] = 'Se mer databasfält...';


/** config step * */
$GLOBALS['strConfigureUpgradeTitle'] = "Konfigurationsinställningar";
$GLOBALS['strPreviousInstallTitle'] = "Tidigare installation";

/** jobs step * */


/** finish step * */

$GLOBALS['strUnableCreateConfFile'] = "Vi lyckades inte skapa din konfigurationsfil. Vänligen kontrollera rättigheterna till {$PRODUCT_NAME} var mappen.";
$GLOBALS['strUnableUpdateConfFile'] = "Vi lyckades inte uppdatera din konfigurationsfil. Vänligen kontrollera rättigheterna till {$PRODUCT_NAME} var mappen samt kontrollera rättigheterna i tidigare installations konfigurationsfil som kan ha kopierats till den här mappen.";

