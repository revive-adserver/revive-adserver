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
$GLOBALS['strInstall'] = "Installer";
$GLOBALS['strDatabaseSettings'] = "Database opsætning";
$GLOBALS['strAdminAccount'] = "Administrator konto";
$GLOBALS['strAdvancedSettings'] = "Avanceret opsætning";
$GLOBALS['strWarning'] = "Advarsel";
$GLOBALS['strBtnContinue'] = "Fortsæt »";
$GLOBALS['strBtnRecover'] = "Genskab »";
$GLOBALS['strBtnAgree'] = "Jeg acceptere »";
$GLOBALS['strBtnRetry'] = "Forsøg igen";
$GLOBALS['strWarningRegisterArgcArv'] = "PHP konfigurator variable register_argc_argv skal tændes for at kunne køre vedligeholdelse fra kommando linien.";
$GLOBALS['strTablesType'] = "Tabel type";

$GLOBALS['strRecoveryRequiredTitle'] = "Dit tidligere forsøg på at upgradere udløste en fejl";
$GLOBALS['strRecoveryRequired'] = "Der var en fejl under behandlingen af din tidligere opdatering og {$PRODUCT_NAME} skal forsøge at genskabe opgraderings processen. Venligst klik på Genskab knappen herunder.";

$GLOBALS['strOaUpToDate'] = "Din {$PRODUCT_NAME} database og filstrktur bruger begge den nyeste version of derfor er det ikke nødvendig med at opdatere på dette tidspunkt. Venligst klik 'Fortsæt' for at komme videre til OpenX administrations panelet.";
$GLOBALS['strOaUpToDateCantRemove'] = "Advarsel: UPGRADE filen er stadig inde i din var folder. Vi kan ikke fjerne denne fil på grund af manglede adgang og tilladelse. Venligst slet denne fil selv.";
$GLOBALS['strErrorWritePermissions'] = "Der er fundet nogle fil adgangs fejl, og disse skal repareres inden du kan fortsætte.<br />For at reparere fejlene på en Linux system, prøv at skrive følgende kommando(er):";

$GLOBALS['strErrorWritePermissionsWin'] = "Der er fundet nogle fil adgangs fejl, og disse skal repareres inden du kan fortsætte";
$GLOBALS['strCheckDocumentation'] = "For mere hjælp se <a href='http://{$PRODUCT_DOCSURL}'>{$PRODUCT_NAME} documentation</a>.";

$GLOBALS['strAdminUrlPrefix'] = "Administrator interface URL";



/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Vælg sektion";
$GLOBALS['strUnableToWriteConfig'] = "Ude af stand til at skrive ændringer til config filen";
$GLOBALS['strUnableToWritePrefs'] = "Ude af stand til at binde referencer til databasen";
$GLOBALS['strImageDirLockedDetected'] = "Den leverede <b>Billede Mappe</b> er ikke skrivebar af serveren. <br>Du kan ikke fortsætte indtil du enten ændrer adgangstilladdelse til mappen eller opretter mappen.";

// Configuration Settings

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Administrator  brugernavn";
$GLOBALS['strAdminPassword'] = "Administrator  password";
$GLOBALS['strInvalidUsername'] = "Ugyldig brugernavn";
$GLOBALS['strBasicInformation'] = "Basis information";
$GLOBALS['strAdministratorEmail'] = "Administrators email adresse";
$GLOBALS['strUserlogEmail'] = "Log alle udgående email beskeder";
$GLOBALS['strTimezone'] = "Tidszone";
$GLOBALS['strEnableAutoMaintenance'] = "Automatisk udfør vedligeholdelse under levering if planlagt vedligehold ikke er sat op";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Database opsætning";
$GLOBALS['strDatabaseServer'] = "Global database server opsætninger";
$GLOBALS['strDbType'] = "Database type";
$GLOBALS['strDbHost'] = "Database host navn";
$GLOBALS['strDbPort'] = "Database port nummer";
$GLOBALS['strDbUser'] = "Database bruger navn";
$GLOBALS['strDbPassword'] = "Database password";
$GLOBALS['strDbName'] = "Database navn";
$GLOBALS['strDatabaseOptimalisations'] = "Database optimiserings opsætning";
$GLOBALS['strPersistentConnections'] = "Brug Persistent tilslutning";
$GLOBALS['strCantConnectToDb'] = "Kan ikke tilslutte til databasen";

// Email Settings
$GLOBALS['strEmailSettings'] = "Email Indstillinger";
$GLOBALS['strEmailHeader'] = "Email Titel";
$GLOBALS['strEmailLog'] = "Email Log";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Handlings Log Indstillinger";
$GLOBALS['strEnableAudit'] = "Aktiver Handlings Log";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Opsætning af debug logning";
$GLOBALS['strEnableDebug'] = "Tillad debug logning";
$GLOBALS['strDebugMethodNames'] = "Inkluder metode navn i debug loggen";
$GLOBALS['strDebugLineNumbers'] = "Inkluder linie nummer i degub loggen";
$GLOBALS['strDebugType'] = "Debug log type";
$GLOBALS['strDebugTypeFile'] = "Fil";

// Delivery Settings
$GLOBALS['strTypeFTPUsername'] = "Log ind";
$GLOBALS['strTypeFTPPassword'] = "Kodeord";

// General Settings

// Geotargeting Settings

// Interface Settings
$GLOBALS['strInventory'] = "Portfolio";
$GLOBALS['strStatisticsDefaults'] = "Statistikker";

// Invocation Settings

// Banner Delivery Settings

// Banner Logging Settings

// Banner Storage Settings

// Campaign ECPM settings

// Statistics & Maintenance Settings

// UI Settings

// Regenerate Platfor Hash script

// Plugin Settings
