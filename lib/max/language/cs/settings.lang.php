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

// Installer translation strings
$GLOBALS['strInstall'] = "Instalace";
$GLOBALS['strDatabaseSettings'] = "Nastavení databáze";
$GLOBALS['strAdminSettings'] = "Nastavení administrátora";
$GLOBALS['strAdvancedSettings'] = "Rozsirena nastaveni databaze";
$GLOBALS['strWarning'] = "Upozornění";
$GLOBALS['strTablesType'] = "Typ tabulky";



$GLOBALS['strInstallSuccess'] = "<b>The installation of {$PRODUCT_NAME} is now complete.</b><br><br>In order for {$PRODUCT_NAME} to function correctly you also need
						   to make sure the maintenance file is run every hour. More information about this subject can be found in the documentation.
						   <br><br>Click <b>Proceed</b> to go the configuration page, where you can
						   set up more settings. Please do not forget to lock the config.inc.php file when you are finished to prevent security
						   breaches.";
$GLOBALS['strInstallNotSuccessful'] = "<b>The installation of {$PRODUCT_NAME} was not succesful</b><br><br>Some portions of the install process could not be completed.
						   It is possible these problems are only temporarily, in that case you can simply click <b>Proceed</b> and return to the
						   first step of the install process. If you want to know more on what the error message below means, and how to solve it,
						   please consult the supplied documentation.";
$GLOBALS['strErrorOccured'] = "Nastala tato chyba:";
$GLOBALS['strErrorInstallDatabase'] = "Databázová struktura nemohla být vytvořena.";
$GLOBALS['strErrorUpgrade'] = 'Databáze současné instalace nemohla být aktualizována';
$GLOBALS['strErrorInstallDbConnect'] = "Nepodařilo se připojit k databázi.";



$GLOBALS['strDeliveryUrlPrefix'] = "Doručovací engine";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Doručovací engine";

$GLOBALS['strInvalidUserPwd'] = "Špatné jméno nebo heslo";

$GLOBALS['strUpgrade'] = "Aktualizace";
$GLOBALS['strSystemUpToDate'] = "Your system is already up to date, no upgrade is needed at the moment. <br>Click on <b>Proceed</b> to go to home page.";
$GLOBALS['strSystemNeedsUpgrade'] = "The database structure and configuration file need to be upgraded in order to function correctly. Click <b>Proceed</b> to start the upgrade process. <br><br>Depending on which version you are upgrading from and how many statistics are already stored in the database, this process can cause high load on your database server. Please be patient, the upgrade can take up to a couple of minutes.";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Vyberte sekci";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons. " .
    "If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues. " .
    "If you want to secure your system, you need to lock the configuration file for this installation.";

// Configuration Settings

// Administrator Settings
$GLOBALS['strAdministratorSettings'] = "Nastavení administrátora";
$GLOBALS['strLoginCredentials'] = "Přihlašovací údaje";
$GLOBALS['strAdminUsername'] = "Jméno Admina";
$GLOBALS['strInvalidUsername'] = "Špatné Jméno";
$GLOBALS['strBasicInformation'] = "Základní údaje";
$GLOBALS['strAdminFullName'] = "Celé jméno";
$GLOBALS['strAdminEmail'] = "Emailová adresa";
$GLOBALS['strCompanyName'] = "Název firmy";
$GLOBALS['strAdminCheckUpdates'] = "Kontrolovat aktualizace";
$GLOBALS['strAdminCheckEveryLogin'] = "Při přihlášení";
$GLOBALS['strAdminCheckDaily'] = "Denně";
$GLOBALS['strAdminCheckWeekly'] = "Týdenně";
$GLOBALS['strAdminCheckMonthly'] = "Měsíčně";
$GLOBALS['strAdminCheckNever'] = "Nikdy";
$GLOBALS['strUserlogEmail'] = "Logovat veškerou odchozí poštu";


// Database Settings
$GLOBALS['strDatabaseSettings'] = "Nastavení databáze";
$GLOBALS['strDatabaseServer'] = "Databázový server";
$GLOBALS['strDbLocal'] = "Připojit k lokálnímu serveru pomocí soketů";
$GLOBALS['strDbType'] = "Jméno databáze";
$GLOBALS['strDbHost'] = "Hostname databáze";
$GLOBALS['strDbPort'] = "Port databáze";
$GLOBALS['strDbUser'] = "Uživatel databáze";
$GLOBALS['strDbPassword'] = "Heslo databáze";
$GLOBALS['strDbName'] = "Jméno databáze";
$GLOBALS['strDatabaseOptimalisations'] = "Optimalizace databáze";
$GLOBALS['strPersistentConnections'] = "Použít trvalé připojení";
$GLOBALS['strCantConnectToDb'] = "Nemohu se připojit k databázi";



// Email Settings
$GLOBALS['strEmailSettings'] = "Základní nastavení";
$GLOBALS['strQmailPatch'] = "Zapnout qmail patch";
$GLOBALS['strEnableQmailPatch'] = "Zapnout qmail patch";

// Audit Trail Settings

// Debug Logging Settings
$GLOBALS['strDebugTypeFile'] = "Soubory";

// Delivery Settings
$GLOBALS['strDeliverySettings'] = "Nastavení doručování";
$GLOBALS['strWebPath'] = "$PRODUCT_NAME Server Access Paths";
$GLOBALS['strDeliveryPath'] = "Cache doručování";
$GLOBALS['strDeliverySslPath'] = "Cache doručování";
$GLOBALS['strTypeWebSettings'] = "Nastavení lokálních bannerů (Webserver)";
$GLOBALS['strTypeWebMode'] = "Typ ukládání";
$GLOBALS['strTypeWebModeLocal'] = "Lokální adresář";
$GLOBALS['strTypeDirError'] = "Lokální adresář neexistuje";
$GLOBALS['strTypeWebModeFtp'] = "Externí FTP server";
$GLOBALS['strTypeWebDir'] = "Lokální adresář";
$GLOBALS['strTypeFTPHost'] = "Server FTP";
$GLOBALS['strTypeFTPDirectory'] = "Adresář serveru";
$GLOBALS['strTypeFTPUsername'] = "Přihlásit";
$GLOBALS['strTypeFTPPassword'] = "Heslo";
$GLOBALS['strTypeFTPErrorDir'] = "Adresář serveru neexistuje";
$GLOBALS['strTypeFTPErrorConnect'] = "Nemohu se přihlásit k FTP serveru. Uživatelské jméno a heslo nejsou správné";
$GLOBALS['strTypeFTPErrorHost'] = "Jméno FTP server není správné";



$GLOBALS['strP3PSettings'] = "Pravidla soukromí P3P";
$GLOBALS['strUseP3P'] = "Použít P3P pravidla";
$GLOBALS['strP3PCompactPolicy'] = "Kompaktní P3P pravidlo";
$GLOBALS['strP3PPolicyLocation'] = "Umístění P3P pravidla";

// General Settings

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Geocílení";
$GLOBALS['strGeotargeting'] = "Geocílení";

// Interface Settings
$GLOBALS['strInventory'] = "Inventář";
$GLOBALS['strShowCampaignInfo'] = "Zobrazit extra informace o kampani na stránce <i>Přehled kampaně</i>";
$GLOBALS['strShowBannerInfo'] = "Zobrazit extra informace o banneru na stránce <i>Přehled banneru</i>";
$GLOBALS['strShowCampaignPreview'] = "Zobrazit náhled všech bannerů na stránce <i>Přehled banneru</i>";
$GLOBALS['strShowBannerHTML'] = "Zobrazit banner místo HTML kódu pro náhled HTML banneru";
$GLOBALS['strShowBannerPreview'] = "Zobrazit náhled banneru na konci stránek které pracují s bannery";
$GLOBALS['strHideInactive'] = "Skrýt neaktivní položky ze všech přehledových stránek";
$GLOBALS['strGUIShowMatchingBanners'] = "Zobrazit odpovídající bannery na stránce <i>Připojený banner</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Zobrazit nadřazenou kampaň na stránce <i>Připojený banner</i>";
$GLOBALS['strStatisticsDefaults'] = "Statistiky";
$GLOBALS['strBeginOfWeek'] = "Počátek týdne";
$GLOBALS['strPercentageDecimals'] = "Desetinná místa procent";
$GLOBALS['strWeightDefaults'] = "Implicitní váha";
$GLOBALS['strDefaultBannerWeight'] = "Implicitní váha banneru";
$GLOBALS['strDefaultCampaignWeight'] = "Implicitní váha kampaně";
$GLOBALS['strDefaultBannerWErr'] = "Implicitní váha banneru by měla být kladné číslo";
$GLOBALS['strDefaultCampaignWErr'] = "Implicitní váha kampaně by měla být kladné číslo";


// CSV Import Settings
$GLOBALS['strDefaultConversionStatus'] = "Implicitní pravidla prodeje";
$GLOBALS['strDefaultConversionType'] = "Implicitní pravidla prodeje";

/**
 * @todo remove strBannerSettings if banner is only configurable as a preference
 *       rename // Banner Settings to  // Banner Preferences
 */
// Invocation Settings
$GLOBALS['strAllowedInvocationTypes'] = "Povolené typy volání";

// Banner Delivery Settings

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Zamezit logování";
$GLOBALS['strReverseLookup'] = "Pokus se určit název hostitele návštěníka pokud není poskytnuto serverem";
$GLOBALS['strProxyLookup'] = "Pokus se určit pravou IP adresu navštěvníka, který používá proxy server";
$GLOBALS['strPreventLogging'] = "Zamezit logování";
$GLOBALS['strIgnoreHosts'] = "Neukládát statistiky pro návštěvníky užívající jednu z následujících IP adres nebo názvů hostitelů";

// Banner Storage Settings

// Campaign ECPM settings

// Statistics & Maintenance Settings
$GLOBALS['strAdminEmailHeaders'] = "Přidej následujíc hlavičku ke každé správě poslané {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Poslat upozornění když počet zbývajících impresí je nižší než zde uvedený";
$GLOBALS['strWarnLimitErr'] = "Limit pro upozornění by mělo být kladné číslo";
$GLOBALS['strWarnAdmin'] = "Poslat upozornění správci kdykoliv je kampaň téměř vyčerpána";
$GLOBALS['strWarnClient'] = "Poslat upozornění inzerentovi kdykoliv je kampaň téměř vyčerpána";
$GLOBALS['strWarnAgency'] = "Poslat upozornění partnerovi kdykoliv je kampaň téměř vyčerpána";

// UI Settings
$GLOBALS['strGuiSettings'] = "Nastavení uživatelského rozhraní";
$GLOBALS['strGeneralSettings'] = "Základní nastavení";
$GLOBALS['strAppName'] = "Název aplikace";
$GLOBALS['strMyHeader'] = "Umístění souboru hlavičky";
$GLOBALS['strMyHeaderError'] = "Soubor hlavičky neexistuje v místě které jste zadal";
$GLOBALS['strMyFooter'] = "Umístění souboru patičky";
$GLOBALS['strMyFooterError'] = "Soubor patičky neexistuje v místě které jste zadal";


$GLOBALS['strGzipContentCompression'] = "Použít kompresi obsahu GZIPem";
$GLOBALS['strClientInterface'] = "Rozhraní inzerenta";
$GLOBALS['strClientWelcomeEnabled'] = "Zapnout uvítací text inzerenta";
$GLOBALS['strClientWelcomeText'] = "Uvítací text<br>(HTML tagy jsou povoleny)";


// Regenerate Platfor Hash script

// Plugin Settings

/* ------------------------------------------------------- */
/* Unknown (unused?) translations                        */
/* ------------------------------------------------------- */

$GLOBALS['strExperimental'] = "Experimentální";
$GLOBALS['strKeywordRetrieval'] = "Načítání klíčových slov";
$GLOBALS['strBannerRetrieval'] = "Způsob načítání bannerů";
$GLOBALS['strRetrieveRandom'] = "Náhodné načítání bannerů (standardní)";
$GLOBALS['strRetrieveNormalSeq'] = "Normální sekvenční načítání bannerů";
$GLOBALS['strWeightSeq'] = "Vážené sekvenční načítání bannerů";
$GLOBALS['strFullSeq'] = "Plně sekvenční načítání bannerů";
$GLOBALS['strUseKeywords'] = "Použít klíčová slova k volbě bannerů";
$GLOBALS['strUseConditionalKeys'] = "Povolit logické operatory při použití přímé volby";
$GLOBALS['strUseMultipleKeys'] = "Povolit vícero klíčových slov při použití přímé volby";

$GLOBALS['strTableBorderColor'] = "Barva okraje tabulky";
$GLOBALS['strTableBackColor'] = "Barva pozadí tabulky";
$GLOBALS['strTableBackColorAlt'] = "Barva pozadí tabulky (alternativní)";
$GLOBALS['strMainBackColor'] = "Základní barva pozadí";
$GLOBALS['strOverrideGD'] = "Anulovat formát obrázku GD";
$GLOBALS['strTimeZone'] = "Časové pásmo";
