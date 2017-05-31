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
$GLOBALS['strInstallStatusRecovery'] = 'Revive Adserver %s helyreállítása';
$GLOBALS['strInstallStatusInstall'] = 'Revive Adserver %s telepítése';
$GLOBALS['strInstallStatusUpgrade'] = 'Revive Adserver %s frissítése';
$GLOBALS['strInstallStatusUpToDate'] = 'Revive Adserver %s törlése';

/** welcome step * */
$GLOBALS['strWelcomeTitle'] = "Üdvözli a {$PRODUCT_NAME}";
$GLOBALS['strInstallIntro'] = "Köszönjük, hogy {$PRODUCT_NAME} -et választotta. Ez a varázsló végigvezet a {$PRODUCT_NAME} telepítési folyamatán.";
$GLOBALS['strUpgradeIntro'] = "Köszönjük, hogy {$PRODUCT_NAME} -et választotta. Ez a varázsló végigvezet a {$PRODUCT_NAME} frissítési folyamatán.";
$GLOBALS['strInstallerHelpIntro'] = "Ha segítsége van szüksége a {$PRODUCT_NAME} telepitésítéséhez, akkor nézze meg a <a href='{$PRODUCT_DOCSURL}' target='_blank'>dokumentációt</a>.";

/** check step * */
$GLOBALS['strSystemCheck'] = "A rendszer ellenőrzése";

$GLOBALS['strAppCheckErrors'] = "Hibát észleltünk a {$PRODUCT_NAME} korábbi telepítése során";

$GLOBALS['strSyscheckProgressMessage'] = "Rendszer ellenőrzése...";
$GLOBALS['strError'] = "Hiba";
$GLOBALS['strWarning'] = "Figyelmeztetés";
$GLOBALS['strOK'] = "OK";
$GLOBALS['strSyscheckName'] = "Név ellenőrizze";
$GLOBALS['strSyscheckValue'] = "Aktuális érték";
$GLOBALS['strSyscheckStatus'] = "Állapot";
$GLOBALS['strSyscheckSeeFullReport'] = "A rendszerellenőrzés részleteinek megjelenítése";
$GLOBALS['strSyscheckSeeShortReport'] = "Csak a hibák és figyelmeztetések megjelenítése";
$GLOBALS['strBrowserCookies'] = 'Böngésző cookie-k';
$GLOBALS['strPHPConfiguration'] = 'PHP konfiguráció';
$GLOBALS['strCheckError'] = 'hiba';
$GLOBALS['strCheckErrors'] = 'hibák';
$GLOBALS['strCheckWarning'] = 'figyelmeztetés';
$GLOBALS['strCheckWarnings'] = 'figyelmeztetések';

/** admin login step * */
$GLOBALS['strAdminLoginTitle'] = "Kérjük, jelentkezzen be a {$PRODUCT_NAME} Adminisztrátor fiókjával";
$GLOBALS['strAdminLoginIntro'] = "A folytatáshoz kérjük, adja meg {$PRODUCT_NAME} Adminisztrátor fiókjának bejelentkezési adatait.";
$GLOBALS['strLoginProgressMessage'] = 'Bejelentkezés...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "Adja meg az adatbázis adatait";
$GLOBALS['strDbSetupIntro'] = "Adja meg kapcsolódási adatokat a {$PRODUCT_NAME} adatbázisához.";
$GLOBALS['strDbUpgradeTitle'] = "Az Ön adatbázisa megtalálva";
$GLOBALS['strDbProgressMessageInstall'] = 'Adatbázis telepítése...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Adatbázis frissítése...';
$GLOBALS['strDbSeeMoreFields'] = 'További adatbázis tulajdonságok megtekintése...';
$GLOBALS['strDbTimeZoneNoWarnings'] = "A jövőben ne mutassa a időzóna figyelmeztetéseket";
$GLOBALS['strDBInstallSuccess'] = "Adatbázis sikeresen létrehozva";
$GLOBALS['strDBUpgradeSuccess'] = "Adatbázis frissítése sikeres";

$GLOBALS['strDetectedVersion'] = "Érzékelt {$PRODUCT_NAME} verzió";

/** config step * */
$GLOBALS['strConfigureInstallTitle'] = "Állítsa be a helyi {$PRODUCT_NAME} Adminisztrátor fiókját";
$GLOBALS['strConfigureInstallIntro'] = "Kérjük, adja meg a kívánt bejelentkezési adatokat a helyi {$PRODUCT_NAME} Adminisztrátor fiókjához.";
$GLOBALS['strConfigureUpgradeTitle'] = "Konfiguráció beállítása";
$GLOBALS['strConfigureUpgradeIntro'] = "Adja meg az előző {$PRODUCT_NAME} telepítésének az elérési útvonalát.";
$GLOBALS['strConfigSeeMoreFields'] = "További konfigurációs tulajdonságok megtekintése...";
$GLOBALS['strPreviousInstallTitle'] = "Előző telepítés";
$GLOBALS['strPathToPrevious'] = "Előző {$PRODUCT_NAME} telepítési útvonala";
$GLOBALS['strPathToPreviousError'] = "Egy vagy több plugin fájl nem található, ellenőrizze a install.log fájlt további információkért";
$GLOBALS['strConfigureProgressMessage'] = "{$PRODUCT_NAME} konfigurálása...";

/** jobs step * */
$GLOBALS['strJobsInstallTitle'] = "Telepítési feladatok végrehajtása";
$GLOBALS['strJobsInstallIntro'] = "A telepítő most végrehajtja a végső telepítési feladatokat.";
$GLOBALS['strJobsUpgradeTitle'] = "Frissítései feladatok végrehajtása";
$GLOBALS['strJobsUpgradeIntro'] = "A telepítő most végrehajtja a végső frissítési feladatokat.";
$GLOBALS['strJobsProgressInstallMessage'] = "Telepítési feladatok futtatása...";
$GLOBALS['strJobsProgressUpgradeMessage'] = "Frissítési feladatok futtatása...";

$GLOBALS['strPluginTaskChecking'] = "A \"{$PRODUCT_NAME}\" plugin ellenőrzése";
$GLOBALS['strPluginTaskInstalling'] = "A \"{$PRODUCT_NAME}\" plugin telepítése";
$GLOBALS['strPostInstallTaskRunning'] = "Feladatok futtatása";

/** finish step * */
$GLOBALS['strFinishInstallTitle'] = "A {$PRODUCT_NAME} telepítése befejeződött.";
$GLOBALS['strFinishUpgradeWithErrorsTitle'] = "Az Ön {$PRODUCT_NAME} frissítése befejeződött. Kérjük, ellenőrizze a kiemelt problémákat.";
$GLOBALS['strFinishUpgradeTitle'] = "Az Ön {$PRODUCT_NAME} frissítése befejeződött.";
$GLOBALS['strFinishInstallWithErrorsTitle'] = "A {$PRODUCT_NAME} telepítése befejeződött. Kérjük, ellenőrizze a kiemelt problémákat.";
$GLOBALS['strDetailedTaskErrorList'] = "A talált hibák részletes listája";
$GLOBALS['strPluginInstallFailed'] = "\"%s\" plugin telepítése nem sikerült:";
$GLOBALS['strTaskInstallFailed'] = "Hiba történt a(z) \"%s\" telepítési feladat futtatásakor:";
$GLOBALS['strContinueToLogin'] = "Kattintson a \"Tovább\" gombra a {$PRODUCT_NAME} -be való bejentkezéshez.";

$GLOBALS['strUnableCreateConfFile'] = "Nem tudjuk létrehozni a konfigurációs fájlt. Kérjük, ellenőrizze a {$PRODUCT_NAME} var mappájának engedélyeit.";
$GLOBALS['strUnableUpdateConfFile'] = "Nem tudjuk frissíteni a konfigurációs fájlt. Kérjük, ellenőrizze a {$PRODUCT_NAME} var mappájának engedélyeit, és ellenőrizze az előző telepítés konfigurációs fájljának engedélyeit, melyeket ebbe a mappába másolt.";
$GLOBALS['strUnableToCreateAdmin'] = "Nem tudunk Adminisztrátor fiókot létrehozni. A megadott adatbázis elérhető?";

