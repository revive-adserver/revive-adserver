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
$Id: translation.php 28570 2008-11-06 16:21:37Z chris.nutting $
*/



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strInventory'] = "Portfolio";
$GLOBALS['strBasicInformation'] = "Basis information";
$GLOBALS['strWarning'] = "Advarsel";
$GLOBALS['strTypeFTPUsername'] = "Log ind";
$GLOBALS['strTypeFTPPassword'] = "Kodeord";
$GLOBALS['strHasTaxID'] = "Skat ID";
$GLOBALS['strStatisticsDefaults'] = "Statistikker";
$GLOBALS['strGeneralSettings'] = "Generel opsætninger";
$GLOBALS['strAdminSettings'] = "Administrator opsætninger";
$GLOBALS['strAdministratorSettings'] = "Administrator opsætninger";
$GLOBALS['strChooseSection'] = "Vælg sektion";
$GLOBALS['strInstall'] = "Installer";
$GLOBALS['strLanguageSelection'] = "Sprog valg";
$GLOBALS['strDatabaseSettings'] = "Database opsætning";
$GLOBALS['strAdminAccount'] = "Administrator konto";
$GLOBALS['strAdvancedSettings'] = "Avanceret opsætning";
$GLOBALS['strSpecifySyncSettings'] = "Synkroniserings opsætning";
$GLOBALS['strOpenadsIdYour'] = "Din OpenX ID";
$GLOBALS['strOpenadsIdSettings'] = "OpenX ID opsætning";
$GLOBALS['strBtnContinue'] = "Fortsæt »";
$GLOBALS['strBtnRecover'] = "Genskab »";
$GLOBALS['strBtnStartAgain'] = "Start opdatering igen »";
$GLOBALS['strBtnGoBack'] = "« Gå tilbage";
$GLOBALS['strBtnAgree'] = "Jeg acceptere »";
$GLOBALS['strBtnDontAgree'] = "« Jeg er uenig";
$GLOBALS['strBtnRetry'] = "Forsøg igen";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Venligst ret alle fejl før der fortsættes.";
$GLOBALS['strWarningRegisterArgcArv'] = "PHP konfigurator variable register_argc_argv skal tændes for at kunne køre vedligeholdelse fra kommando linien.";
$GLOBALS['strTablesPrefix'] = "Tabel navne prefix";
$GLOBALS['strTablesType'] = "Tabel type";
$GLOBALS['strInstallIntro'] = "Tak fordi du valgte <a href='http://". MAX_PRODUCT_URL ."' target='_blank'><strong>". MAX_PRODUCT_NAME ."</strong></a><p>Denne wizard vil guide dig igennem installations processen/opdateringen af ". MAX_PRODUCT_NAME ." reklame server.</p><p> For at hjælpe dig med installationsprocessen har vi lavet en <a href='http://". OX_PRODUCT_DOCSURL ."/wizard/qsg-install' target='_blank'>Qucik Start Installations guide</a> til at få dig gemmen processen så du kommer hurtigt i gang. For en mere detaljeret guide til installation og konfigurering af ". MAX_PRODUCT_NAME ." se <a href='http://". OX_PRODUCT_DOCSURL ."/wizard/admin-guide'target='_blank'>Administrator Guide</a>.";
$GLOBALS['strRecoveryRequiredTitle'] = "Dit tidligere forsøg på at upgradere udløste en fejl";
$GLOBALS['strRecoveryRequired'] = "Der var en fejl under behandlingen af din tidligere opdatering og ". MAX_PRODUCT_NAME ." skal forsøge at genskabe opgraderings processen. Venligst klik på Genskab knappen herunder.";
$GLOBALS['strPolicyIntro'] = "Venlig gennemgå og accepter de følgende dokumenter for at fortsætte installationen.";
$GLOBALS['strDbSetupTitle'] = "Database opsætning";
$GLOBALS['strDbSetupIntro'] = "Venligst indtast detaljerne så du kan tilslutte til din database. Hvis du er i tvivl om disse detaljer, venligst kontakt din system administrator. <p> Det næste trin vil opsætte din database. Klik 'fortsæt' for at komme videre .</p>";
$GLOBALS['strDbUpgradeIntro'] = "Herunder er detaljerne for den database som er regristeret for installation af ". MAX_PRODUCT_NAME .". Venligst tjek at disse informationer er korrekte.<p>Det næste trin vil opgradere din database. Klik 'Fortsæt' for at opgradere dit system.</p>";
$GLOBALS['strOaUpToDate'] = "Din ". MAX_PRODUCT_NAME ." database og filstrktur bruger begge den nyeste version of derfor er det ikke nødvendig med at opdatere på dette tidspunkt. Venligst klik 'Fortsæt' for at komme videre til OpenX administrations panelet.";
$GLOBALS['strOaUpToDateCantRemove'] = "Advarsel: UPGRADE filen er stadig inde i din var folder. Vi kan ikke fjerne denne fil på grund af manglede adgang og tilladelse. Venligst slet denne fil selv.";
$GLOBALS['strRemoveUpgradeFile'] = "Du skal fjerne UPGRADE filen fra var folderen.";
$GLOBALS['strSystemCheck'] = "System tjek";
$GLOBALS['strSystemCheckIntro'] = "Den installerede wizard kontrollere din web server opsætning for at sikre at installations processen kan færdiggøres succesfuldt.	<p>Venligst kontroller alle fremhævede punkter for at færdiggøre installations processen.</p>";
$GLOBALS['strDbSuccessIntro'] = "Databasen til ". MAX_PRODUCT_NAME ." er nu blevet oprettet. Venligst klik på 'Fortsæt' knappen for at komme videre med konfigureringen af ". MAX_PRODUCT_NAME ." Administrator og Leverings opsætningen";
$GLOBALS['strDbSuccessIntroUpgrade'] = "Dit system er opgraderet succesfuldt. De resterende skærmbilleder vil hjælpe dig med at opdatere konfigurationen af din nye reklame server.";
$GLOBALS['strErrorWritePermissions'] = "Der er fundet nogle fil adgangs fejl, og disse skal repareres inden du kan fortsætte.<br />For at reparere fejlene på en Linux system, prøv at skrive følgende kommando(er):";
$GLOBALS['strErrorWritePermissionsWin'] = "Der er fundet nogle fil adgangs fejl, og disse skal repareres inden du kan fortsætte";
$GLOBALS['strCheckDocumentation'] = "For mere hjælp se <a href='http://". OX_PRODUCT_DOCSURL ."'>". MAX_PRODUCT_NAME ." documentation</a>.";
$GLOBALS['strAdminUrlPrefix'] = "Administrator interface URL";
$GLOBALS['strEditConfigNotPossible'] = "Det er ikke muligt at redigere alle opsætninger da konfigurator filen er låst af sikkerhedsmæssige grunde. Hvis du ønsker at foretage ændringer, er det muligvis nødvendigt at låse konfigurator filen op for denne installation.";
$GLOBALS['strEditConfigPossible'] = "Det er muligt at redigere all opsætninger fordi konfigurator filen ikke er låst, men det kan føre til sikkerheds problemer. Hvis du ønsker at sikre dit system, er det nødvendigt at låse konfigurations filen for denne installation.";
$GLOBALS['strUnableToWriteConfig'] = "Ude af stand til at skrive ændringer til config filen";
$GLOBALS['strUnableToWritePrefs'] = "Ude af stand til at binde referencer til databasen";
$GLOBALS['strImageDirLockedDetected'] = "Den leverede <b>Billede Mappe</b> er ikke skrivebar af serveren. <br>Du kan ikke fortsætte indtil du enten ændrer adgangstilladdelse til mappen eller opretter mappen.";
$GLOBALS['strConfigurationSetup'] = "Konfigurations tjekliste";
$GLOBALS['strConfigurationSettings'] = "Konfigurations opsætning";
$GLOBALS['strAdminUsername'] = "Administrator  brugernavn";
$GLOBALS['strAdminPassword'] = "Administrator  password";
$GLOBALS['strInvalidUsername'] = "Ugyldig brugernavn";
$GLOBALS['strAdminFullName'] = "Admin's fulde navn";
$GLOBALS['strAdminEmail'] = "Admin's email adresse";
$GLOBALS['strAdministratorEmail'] = "Administrators email adresse";
$GLOBALS['strCompanyName'] = "Virksomheds navn";
$GLOBALS['strUserlogEmail'] = "Log alle udgående email beskeder";
$GLOBALS['strTimezone'] = "Tidszone";
$GLOBALS['strTimezoneEstimated'] = "Estimeret tidszone";
$GLOBALS['strTimezoneGuessedValue'] = "Server tidszone er ikke sat korrekt i PHP";
$GLOBALS['strTimezoneSeeDocs'] = "Venligst se %DOCS% omkring settings variabler for PHP.";
$GLOBALS['strTimezoneDocumentation'] = "dokumentation";
$GLOBALS['strLoginSettingsTitle'] = "Administrator log ind";
$GLOBALS['strLoginSettingsIntro'] = "For at fortsætte med opdaterings processen, venligst angiv dit ". MAX_PRODUCT_NAME ." administrator log ind detaljer. Det er nødvendigt at du logger ind som administrator for at fortsætte med opgraderings processen.";
$GLOBALS['strAdminSettingsTitle'] = "Opret en administrator konto";
$GLOBALS['strAdminSettingsIntro'] = "Venligst udfyld denne formlar for at oprette din annonce server adiminstrator konto.";
$GLOBALS['strEnableAutoMaintenance'] = "Automatisk udfør vedligeholdelse under levering if planlagt vedligehold ikke er sat op";
$GLOBALS['strOpenadsUsername'] = "". MAX_PRODUCT_NAME ." Brugernavn";
$GLOBALS['strOpenadsPassword'] = "". MAX_PRODUCT_NAME ." Password";
$GLOBALS['strOpenadsEmail'] = "". MAX_PRODUCT_NAME ." Email";
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
$GLOBALS['strDemoDataInstall'] = "Installer demp data";
$GLOBALS['strDemoDataIntro'] = "Standard opsætningsdata kan indlæses i ". MAX_PRODUCT_NAME ." for at hjælpe dig med servicere online reklamering. De mest almindelige banner typer, så vel som opstarts kampagner kan indlæses og præ-konfigureres. Dette anbefales stærkt for nye installationer.";
$GLOBALS['strDebug'] = "Opsætning af debug logning";
$GLOBALS['strProduction'] = "Produktions server";
$GLOBALS['strEnableDebug'] = "Tillad debug logning";
$GLOBALS['strDebugMethodNames'] = "Inkluder metode navn i debug loggen";
$GLOBALS['strDebugLineNumbers'] = "Inkluder linie nummer i degub loggen";
$GLOBALS['strDebugType'] = "Debug log type";
$GLOBALS['strDebugTypeFile'] = "Fil";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "SQL database";
$GLOBALS['strDebugTypeSyslog'] = "Syslog";
$GLOBALS['strDebugName'] = "Debug log navn, kalender, SQL tabel,<br />eller Syslog funktion";
$GLOBALS['strDebugPriority'] = "Debug prioritets niveau";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Informations majoriteten";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Standard information";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_DEBUG - Informations majoriteten";
$GLOBALS['strDebugIdent'] = "Debug identifikations streng";
$GLOBALS['strDebugUsername'] = "mCal, SQL Server brugernavn";
$GLOBALS['strDebugPassword'] = "mCal, SQL Server kodeord";
$GLOBALS['strDeliverySettings'] = "Leverings opsætning";
$GLOBALS['strWebPath'] = "". MAX_PRODUCT_NAME ." Server adgangs sti";
$GLOBALS['strWebPathSimple'] = "Web sti";
$GLOBALS['strDeliveryPath'] = "Cache levering";
$GLOBALS['strDeliverySslPath'] = "Cache levering";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Tilføj Billede";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Tilføj (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Tilføj Layer";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Tilføj Log";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Tilføj Popup";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "XML RPC Invocation";
$GLOBALS['strDeliveryFilenamesLocal'] = "Lokal Invocation";
$GLOBALS['strDeliveryFilenamesFlash'] = "Flash Inkluderet (Kan være fuldt URL)";
$GLOBALS['strDeliveryCaching'] = "Banner Levering Cache Indstillinger";
$GLOBALS['strDeliveryCacheLimit'] = "Tid imellem Banner Cache Updatering (sekunder)";
$GLOBALS['strOrigin'] = "Brug remote ophavs server";
$GLOBALS['strOriginType'] = "Ophavs server type";
$GLOBALS['strOriginHost'] = "Hostname for ophavs server";
$GLOBALS['strModesOfPayment'] = "Betalings metode";
$GLOBALS['strHelpFiles'] = "Hjælpe fil";
$GLOBALS['strPreventLogging'] = "Banner Log Indstillinger";
$GLOBALS['strEmailSettings'] = "Email Indstillinger";
$GLOBALS['strEmailHeader'] = "Email Titel";
$GLOBALS['strEmailLog'] = "Email Log";
$GLOBALS['strAuditTrailSettings'] = "Handlings Log Indstillinger";
$GLOBALS['strEnableAudit'] = "Aktiver Handlings Log";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Din PHP installation understøtter ikke FTP.";
$GLOBALS['strConfirmationUI'] = "Bekræftigelse for Bruger Grænseflade";
$GLOBALS['strBannerStorage'] = "Indstillinger for Banner Lagring";
$GLOBALS['strMaintenanceSettings'] = "Vedligeholdelses Indstillinger";
$GLOBALS['strSSLSettings'] = "SSL Indstillinger";
$GLOBALS['requireSSL'] = "Tving SSL adgang i Bruger Grænseflade";
$GLOBALS['sslPort'] = "SSL Port Brugt af Web Server";
$GLOBALS['strEmailAddressFrom'] = "Email Adresse rapporter skal sendes FRA";
$GLOBALS['strEmailAddressName'] = "Firma eller navn, email skal underskrives med";
$GLOBALS['strBannerLogging'] = "Banner Log Indstillinger";
$GLOBALS['strBannerDelivery'] = "Banner Leverings Indstillinger";
$GLOBALS['strDefaultConversionStatus'] = "Normal conversions regler";
$GLOBALS['strDefaultConversionType'] = "Normal conversions regler";
?>