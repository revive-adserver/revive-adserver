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
$GLOBALS['strAdminAccount'] = "Účet správce systému";
$GLOBALS['strAdvancedSettings'] = "Rozsirena nastaveni databaze";
$GLOBALS['strWarning'] = "Varování";
$GLOBALS['strBtnContinue'] = "Pokračovat»";
$GLOBALS['strBtnRecover'] = "Obnovit»";
$GLOBALS['strBtnAgree'] = "Souhlasím»";
$GLOBALS['strBtnRetry'] = "Opakovat";
$GLOBALS['strWarningRegisterArgcArv'] = "Konfigurace PHP proměnné register_argc_argv musí být zapnuta pro spuštění údržby z příkazového řádku.";
$GLOBALS['strTablesPrefix'] = "Prefix názvů tabulek";
$GLOBALS['strTablesType'] = "Typ tabulky";

$GLOBALS['strRecoveryRequiredTitle'] = "Váš předchozí pokus o upgrade zjistil chybu";

$GLOBALS['strNotWriteable'] = "NELZE zapisovat";
$GLOBALS['strDirNotWriteableError'] = "Adresář musí být zapisovatelný";


$GLOBALS['strAdminUrlPrefix'] = "URL admin rozhraní";
$GLOBALS['strDeliveryUrlPrefix'] = "Doručovací engine";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Doručovací engine";
$GLOBALS['strImagesUrlPrefix'] = "URL adresa úložiště obrázků";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL adresa úložiště obrázků (SSL)";


$GLOBALS['strUpgrade'] = "Aktualizace";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Vyberte sekci";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Nastavení konfigurace";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Jméno Admina";
$GLOBALS['strInvalidUsername'] = "Špatné Jméno";
$GLOBALS['strBasicInformation'] = "Základní údaje";
$GLOBALS['strAdminCheckUpdates'] = "Kontrolovat aktualizace";
$GLOBALS['strUserlogEmail'] = "Logovat veškerou odchozí poštu";
$GLOBALS['strTimezone'] = "Časové pásmo";

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
$GLOBALS['strEmailHeader'] = "Záhlaví e-mailů";
$GLOBALS['strEmailLog'] = "E-Mail log";

// Audit Trail Settings

// Debug Logging Settings
$GLOBALS['strDebugTypeFile'] = "Soubory";

// Delivery Settings
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

// Invocation Settings

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
$GLOBALS['strWarnAdmin'] = "Poslat upozornění správci kdykoliv je kampaň téměř vyčerpána";
$GLOBALS['strWarnClient'] = "Poslat upozornění inzerentovi kdykoliv je kampaň téměř vyčerpána";
$GLOBALS['strWarnAgency'] = "Poslat upozornění partnerovi kdykoliv je kampaň téměř vyčerpána";

// UI Settings
$GLOBALS['strGuiSettings'] = "Nastavení uživatelského rozhraní";
$GLOBALS['strGeneralSettings'] = "Obecná nastavení";
$GLOBALS['strAppName'] = "Název aplikace";
$GLOBALS['strMyHeader'] = "Umístění souboru hlavičky";
$GLOBALS['strMyFooter'] = "Umístění souboru patičky";
$GLOBALS['strGzipContentCompression'] = "Použít kompresi obsahu GZIPem";

// Regenerate Platfor Hash script

// Plugin Settings
