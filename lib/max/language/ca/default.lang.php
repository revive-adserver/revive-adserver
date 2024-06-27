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

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection'] = "";
$GLOBALS['phpAds_TextAlignRight'] = "";
$GLOBALS['phpAds_TextAlignLeft'] = "";
$GLOBALS['phpAds_CharSet'] = "";

$GLOBALS['phpAds_DecimalPoint'] = ",";
$GLOBALS['phpAds_ThousandsSeperator'] = ".";

// Date & time configuration
$GLOBALS['date_format'] = "";
$GLOBALS['time_format'] = "";
$GLOBALS['minute_format'] = "";
$GLOBALS['month_format'] = "";
$GLOBALS['day_format'] = "";
$GLOBALS['week_format'] = "";
$GLOBALS['weekiso_format'] = "";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = "";
$GLOBALS['excel_decimal_formatting'] = "";

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Pàgina d'inici";
$GLOBALS['strHelp'] = "Ajuda";
$GLOBALS['strStartOver'] = "Torna a començar";
$GLOBALS['strShortcuts'] = "Dreceres";
$GLOBALS['strActions'] = "Accions";
$GLOBALS['strAndXMore'] = "i %s més";
$GLOBALS['strAdminstration'] = "Inventari";
$GLOBALS['strMaintenance'] = "Manteniment";
$GLOBALS['strProbability'] = "Probabilitat";
$GLOBALS['strInvocationcode'] = "Codi d'invocació";
$GLOBALS['strBasicInformation'] = "Informació bàsica";
$GLOBALS['strAppendTrackerCode'] = "Afegeix codi de seguiment";
$GLOBALS['strOverview'] = "Visió general";
$GLOBALS['strSearch'] = "<u>C</u>erca";
$GLOBALS['strDetails'] = "Detalls";
$GLOBALS['strUpdateSettings'] = "Actualitza la configuració";
$GLOBALS['strCheckForUpdates'] = "Cerca actualitzacions";
$GLOBALS['strWhenCheckingForUpdates'] = "Quan es comprovi si hi ha actualitzacions";
$GLOBALS['strCompact'] = "Compacte";
$GLOBALS['strUser'] = "Usuari";
$GLOBALS['strDuplicate'] = "Duplica";
$GLOBALS['strCopyOf'] = "Còpia de";
$GLOBALS['strMoveTo'] = "Mou a";
$GLOBALS['strDelete'] = "Suprimeix";
$GLOBALS['strActivate'] = "Activa";
$GLOBALS['strConvert'] = "Converteix";
$GLOBALS['strRefresh'] = "Refresca";
$GLOBALS['strSaveChanges'] = "Desa els canvis";
$GLOBALS['strUp'] = "Amunt";
$GLOBALS['strDown'] = "Avall";
$GLOBALS['strSave'] = "Desa";
$GLOBALS['strCancel'] = "Cancel·la";
$GLOBALS['strBack'] = "Enrere";
$GLOBALS['strPrevious'] = "Anterior";
$GLOBALS['strNext'] = "Següent";
$GLOBALS['strYes'] = "Sí";
$GLOBALS['strNo'] = "No";
$GLOBALS['strNone'] = "Cap";
$GLOBALS['strCustom'] = "Personalitzat";
$GLOBALS['strDefault'] = "Predeterminat";
$GLOBALS['strUnknown'] = "Desconegut";
$GLOBALS['strUnlimited'] = "Il·limitat";
$GLOBALS['strUntitled'] = "Sense títol";
$GLOBALS['strAll'] = "tots";
$GLOBALS['strAverage'] = "Mitjana";
$GLOBALS['strOverall'] = "Global";
$GLOBALS['strTotal'] = "Total";
$GLOBALS['strFrom'] = "Des de";
$GLOBALS['strTo'] = "a";
$GLOBALS['strAdd'] = "Afegeix";
$GLOBALS['strLinkedTo'] = "enllaçat a ";
$GLOBALS['strDaysLeft'] = "Dies restants";
$GLOBALS['strCheckAllNone'] = "Comprova tots / cap";
$GLOBALS['strKiloByte'] = "kB";
$GLOBALS['strExpandAll'] = "<u>E</u>xpandir-ho tot";
$GLOBALS['strCollapseAll'] = "<u>T</u>anca-ho tot";
$GLOBALS['strShowAll'] = "Mostra-ho tot";
$GLOBALS['strNoAdminInterface'] = "La pantalla d'administració s'ha desactivat per manteniment. Això no afecta la publicació de les vostres campanyes.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "La data d’inici ha de ser anterior a la data de finalització";
$GLOBALS['strFieldContainsErrors'] = "Els següents camps contenen errors:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Abans de continuar necessites";
$GLOBALS['strFieldFixBeforeContinue2'] = "corregir aquests errors.";
$GLOBALS['strMiscellaneous'] = "Miscel·lània";
$GLOBALS['strCollectedAllStats'] = "Totes les estadístiques";
$GLOBALS['strCollectedToday'] = "Avui";
$GLOBALS['strCollectedYesterday'] = "Ahir";
$GLOBALS['strCollectedThisWeek'] = "Aquesta setmana";
$GLOBALS['strCollectedLastWeek'] = "Darrera setmana";
$GLOBALS['strCollectedThisMonth'] = "Aquest mes";
$GLOBALS['strCollectedLastMonth'] = "Darrer mes";
$GLOBALS['strCollectedLast7Days'] = "Darrers 7 dies";
$GLOBALS['strCollectedSpecificDates'] = "Dates específiques";
$GLOBALS['strValue'] = "Valor";
$GLOBALS['strWarning'] = "Advertència";
$GLOBALS['strNotice'] = "Avís";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "Aquest panell no es pot mostrar";
$GLOBALS['strNoCheckForUpdates'] = "El panell no es pot mostrar fins que<br />el paràmetre comprova si hi ha actualitzacions estigui activat.";
$GLOBALS['strEnableCheckForUpdates'] = "";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "codi";
$GLOBALS['strDashboardSystemMessage'] = "Missatge del sistema";
$GLOBALS['strDashboardErrorHelp'] = "";

// Priority
$GLOBALS['strPriority'] = "Prioritat";
$GLOBALS['strPriorityLevel'] = "Nivell de prioritat";
$GLOBALS['strOverrideAds'] = "Anuncis de campanyes de substitució";
$GLOBALS['strHighAds'] = "Anuncis de campanyes de contracte";
$GLOBALS['strECPMAds'] = "";
$GLOBALS['strLowAds'] = "Anuncis de campanyes romanents";
$GLOBALS['strLimitations'] = "Regles d'entrega";
$GLOBALS['strNoLimitations'] = "No hi ha regles d'entrega";
$GLOBALS['strCapping'] = "Limitació";

// Properties
$GLOBALS['strName'] = "Nom";
$GLOBALS['strSize'] = "Mida";
$GLOBALS['strWidth'] = "Amplada";
$GLOBALS['strHeight'] = "Altura";
$GLOBALS['strTarget'] = "Destí";
$GLOBALS['strLanguage'] = "Idioma";
$GLOBALS['strDescription'] = "Descripció";
$GLOBALS['strVariables'] = "Variables";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "Comentaris";

// User access
$GLOBALS['strWorkingAs'] = "Treballant com";
$GLOBALS['strWorkingAs_Key'] = "<u>T</u>reballant com";
$GLOBALS['strWorkingAs'] = "Treballant com";
$GLOBALS['strSwitchTo'] = "Canvia a";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "";
$GLOBALS['strWorkingFor'] = "%s per...";
$GLOBALS['strNoAccountWithXInNameFound'] = "No s'han trobat comptes amb \"%s\" al nom";
$GLOBALS['strRecentlyUsed'] = "Usats recentment";
$GLOBALS['strLinkUser'] = "Afegeix usuari/a";
$GLOBALS['strLinkUser_Key'] = "Afegeix <u>u</u>suari";
$GLOBALS['strUsernameToLink'] = "Nom de l'usuari a afegir";
$GLOBALS['strNewUserWillBeCreated'] = "Es crearà un nou usuari/a";
$GLOBALS['strToLinkProvideEmail'] = "Per afegir un usuari, indica el correu electrònic de l'usuari";
$GLOBALS['strToLinkProvideUsername'] = "Per afegir un usuari, indica el nom d'usuari";
$GLOBALS['strUserLinkedToAccount'] = "";
$GLOBALS['strUserLinkedAndWelcomeSent'] = "";
$GLOBALS['strUserAccountUpdated'] = "Compte d'usuari actualitzat";
$GLOBALS['strUserUnlinkedFromAccount'] = "";
$GLOBALS['strUserWasDeleted'] = "L'usuari s'ha suprimit";
$GLOBALS['strUserNotLinkedWithAccount'] = "Aquest usuari no està vinculat al compte";
$GLOBALS['strCantDeleteOneAdminUser'] = "";
$GLOBALS['strLinkUserHelp'] = "";
$GLOBALS['strLinkUserHelpUser'] = "nom d'usuari";
$GLOBALS['strLinkUserHelpEmail'] = "adreça de correu";
$GLOBALS['strLastLoggedIn'] = "Darrer inici de sessió";
$GLOBALS['strDateLinked'] = "Data vinculada";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Accés d'usuari";
$GLOBALS['strAdminAccess'] = "Accés d'administrador";
$GLOBALS['strUserProperties'] = "Propietats d'usuari";
$GLOBALS['strPermissions'] = "Permisos";
$GLOBALS['strAuthentification'] = "Autenticació";
$GLOBALS['strWelcomeTo'] = "Us donem la benvinguda a";
$GLOBALS['strEnterUsername'] = "Introduïu el vostre nom d'usuari i contrasenya per entrar";
$GLOBALS['strEnterBoth'] = "Si us plau introdueixi el seu nom d'usuari i contrasenya";
$GLOBALS['strEnableCookies'] = "Has d'activar les cookies abans de poder usar {{PRODUCT_NAME}}";
$GLOBALS['strSessionIDNotMatch'] = "Sessió expirada. Si us plau inicieu la sessió de nou.";
$GLOBALS['strLogin'] = "Inicia sessió";
$GLOBALS['strLogout'] = "Tanca sessió";
$GLOBALS['strUsername'] = "Nom d'usuari";
$GLOBALS['strPassword'] = "Contrasenya";
$GLOBALS['strPasswordRepeat'] = "Repeteix la contrasenya";
$GLOBALS['strAccessDenied'] = "Accés denegat";
$GLOBALS['strUsernameOrPasswordWrong'] = "El nom d'usuari i/o la contrasenya no són correctes. Torneu-ho a provar";
$GLOBALS['strPasswordWrong'] = "La contrasenya no és correcta";
$GLOBALS['strNotAdmin'] = "";
$GLOBALS['strDuplicateClientName'] = "";
$GLOBALS['strInvalidPassword'] = "";
$GLOBALS['strInvalidEmail'] = "";
$GLOBALS['strNotSamePasswords'] = "No coincideixen les contrasenyes.";
$GLOBALS['strRepeatPassword'] = "Repetiu la contrasenya";
$GLOBALS['strDeadLink'] = "L'enllaç no és vàlid.";
$GLOBALS['strNoPlacement'] = "";
$GLOBALS['strNoAdvertiser'] = "";

// General advertising
$GLOBALS['strRequests'] = "Sol·licituds";
$GLOBALS['strImpressions'] = "Impressions";
$GLOBALS['strClicks'] = "Clics";
$GLOBALS['strConversions'] = "Conversions";
$GLOBALS['strCTRShort'] = "CTR (% de clics)";
$GLOBALS['strCNVRShort'] = "";
$GLOBALS['strCTR'] = "";
$GLOBALS['strTotalClicks'] = "Clics totals";
$GLOBALS['strTotalConversions'] = "Conversions totals";
$GLOBALS['strDateTime'] = "Data i hora";
$GLOBALS['strTrackerID'] = "";
$GLOBALS['strTrackerName'] = "";
$GLOBALS['strTrackerImageTag'] = "Etiqueta d'imatge";
$GLOBALS['strTrackerJsTag'] = "Etiqueta de Javascript";
$GLOBALS['strTrackerAlwaysAppend'] = "";
$GLOBALS['strBanners'] = "Bàners";
$GLOBALS['strCampaigns'] = "Campanyes";
$GLOBALS['strCampaignID'] = "Identificador de campanya";
$GLOBALS['strCampaignName'] = "Nom de la campanya";
$GLOBALS['strCountry'] = "País";
$GLOBALS['strStatsAction'] = "Acció";
$GLOBALS['strWindowDelay'] = "";
$GLOBALS['strStatsVariables'] = "Variables";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "";
$GLOBALS['strFinanceCTR'] = "CTR (% de clics)";
$GLOBALS['strFinanceCR'] = "";

// Time and date related
$GLOBALS['strDate'] = "Data";
$GLOBALS['strDay'] = "Dia";
$GLOBALS['strDays'] = "Dies";
$GLOBALS['strWeek'] = "Setmana";
$GLOBALS['strWeeks'] = "Setmanes";
$GLOBALS['strSingleMonth'] = "Mes";
$GLOBALS['strMonths'] = "Mesos";
$GLOBALS['strDayOfWeek'] = "Dia de la setmana";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = [];
}
$GLOBALS['strDayFullNames'][0] = 'Diumenge';
$GLOBALS['strDayFullNames'][1] = 'Dilluns';
$GLOBALS['strDayFullNames'][2] = 'Dimarts';
$GLOBALS['strDayFullNames'][3] = 'Dimecres';
$GLOBALS['strDayFullNames'][4] = 'Dijous';
$GLOBALS['strDayFullNames'][5] = 'Divendres';
$GLOBALS['strDayFullNames'][6] = 'Dissabte';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = [];
}
$GLOBALS['strDayShortCuts'][0] = 'Dg';
$GLOBALS['strDayShortCuts'][1] = 'Dl';
$GLOBALS['strDayShortCuts'][2] = 'Dm';
$GLOBALS['strDayShortCuts'][3] = 'Dc';
$GLOBALS['strDayShortCuts'][4] = 'Dj';
$GLOBALS['strDayShortCuts'][5] = 'Dv';
$GLOBALS['strDayShortCuts'][6] = 'Ds';

$GLOBALS['strHour'] = "Hora";
$GLOBALS['strSeconds'] = "segons";
$GLOBALS['strMinutes'] = "minuts";
$GLOBALS['strHours'] = "hores";

// Advertiser
$GLOBALS['strClient'] = "Anunciant";
$GLOBALS['strClients'] = "Anunciants";
$GLOBALS['strClientsAndCampaigns'] = "Anunciants i campanyes";
$GLOBALS['strAddClient'] = "Afegir anunciant";
$GLOBALS['strClientProperties'] = "Propietats de l'anunciant";
$GLOBALS['strClientHistory'] = "Estadístiques de l'anunciant";
$GLOBALS['strNoClients'] = "No hi ha anunciants definits. Per crear una campanya, primer <a href='advertiser-edit.php'>afegiu un anunciant nou</a>.";
$GLOBALS['strConfirmDeleteClient'] = "";
$GLOBALS['strConfirmDeleteClients'] = "";
$GLOBALS['strHideInactive'] = "Oculta els inactius";
$GLOBALS['strInactiveAdvertisersHidden'] = "anunciant(s) inactiu(s) ocult(s)";
$GLOBALS['strAdvertiserSignup'] = "";
$GLOBALS['strAdvertiserCampaigns'] = "Campanyes de l'anunciant";

// Advertisers properties
$GLOBALS['strContact'] = "Contacte";
$GLOBALS['strContactName'] = "Nom del contacte";
$GLOBALS['strEMail'] = "Correu electrònic";
$GLOBALS['strSendAdvertisingReport'] = "";
$GLOBALS['strNoDaysBetweenReports'] = "";
$GLOBALS['strSendDeactivationWarning'] = "";
$GLOBALS['strAllowClientModifyBanner'] = "";
$GLOBALS['strAllowClientDisableBanner'] = "";
$GLOBALS['strAllowClientActivateBanner'] = "";
$GLOBALS['strAllowCreateAccounts'] = "";
$GLOBALS['strAdvertiserLimitation'] = "";
$GLOBALS['strAllowAuditTrailAccess'] = "";
$GLOBALS['strAllowDeleteItems'] = "";

// Campaign
$GLOBALS['strCampaign'] = "Campanya";
$GLOBALS['strCampaigns'] = "Campanyes";
$GLOBALS['strAddCampaign'] = "Afegir una nova campanya";
$GLOBALS['strAddCampaign_Key'] = "Afegir una <u>n</u>ova campanya";
$GLOBALS['strCampaignForAdvertiser'] = "per anunciant";
$GLOBALS['strLinkedCampaigns'] = "Campanyes vinculades";
$GLOBALS['strCampaignProperties'] = "Propietats de la campanya";
$GLOBALS['strCampaignOverview'] = "Visió general de la campanya";
$GLOBALS['strCampaignHistory'] = "Estadístiques de la campanya";
$GLOBALS['strNoCampaigns'] = "Actualment no hi ha cap campanya per a aquest anunciant.";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "Actualment no hi ha cap campanya, perquè no hi ha anunciants. Per crear una campanya <a href='advertiser-edit.php'>afegeix un nou anunciant</a> primer.";
$GLOBALS['strConfirmDeleteCampaign'] = "Realment voleu esborrar aquesta campanya?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Realment voleu esborrar les campanyes seleccionades?";
$GLOBALS['strShowParentAdvertisers'] = "Mostra els anunciants pare";
$GLOBALS['strHideParentAdvertisers'] = "Oculta els anunciants pare";
$GLOBALS['strHideInactiveCampaigns'] = "Oculta les campanyes inactives";
$GLOBALS['strInactiveCampaignsHidden'] = "campanyes inactives ocultes";
$GLOBALS['strPriorityInformation'] = "Prioritat en relació a altres campanyes";
$GLOBALS['strECPMInformation'] = "";
$GLOBALS['strRemnantEcpmDescription'] = "";
$GLOBALS['strEcpmMinImpsDescription'] = "";
$GLOBALS['strHiddenCampaign'] = "Campanya";
$GLOBALS['strHiddenAd'] = "Anunci";
$GLOBALS['strHiddenAdvertiser'] = "Anunciant";
$GLOBALS['strHiddenTracker'] = "";
$GLOBALS['strHiddenWebsite'] = "Pàgina web";
$GLOBALS['strHiddenZone'] = "Zona";
$GLOBALS['strCampaignDelivery'] = "Entrega de la campanya";
$GLOBALS['strCompanionPositioning'] = "";
$GLOBALS['strSelectUnselectAll'] = "Selecciona-ho tot / No seleccionis res";
$GLOBALS['strCampaignsOfAdvertiser'] = "de"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Calculat per totes les campanyes";
$GLOBALS['strCalculatedForThisCampaign'] = "Calculat per aquesta campanya";
$GLOBALS['strLinkingZonesProblem'] = "Ha ocorregut un problema vinculant les zones";
$GLOBALS['strUnlinkingZonesProblem'] = "Ha ocorregut un problema desvinculant les zones";
$GLOBALS['strZonesLinked'] = "zones vinculades";
$GLOBALS['strZonesUnlinked'] = "zones desvinculades";
$GLOBALS['strZonesSearch'] = "Cerca";
$GLOBALS['strZonesSearchTitle'] = "Cerca zones i llocs web per nom";
$GLOBALS['strNoWebsitesAndZones'] = "No hi ha llocs webs ni zones";
$GLOBALS['strNoWebsitesAndZonesText'] = "amb \"%s\" al nom";
$GLOBALS['strToLink'] = "per vincular";
$GLOBALS['strToUnlink'] = "per desvincular";
$GLOBALS['strLinked'] = "Enllaçats";
$GLOBALS['strAvailable'] = "Disponible";
$GLOBALS['strShowing'] = "Mostrant";
$GLOBALS['strEditZone'] = "Edita la zona";
$GLOBALS['strEditWebsite'] = "Edita el lloc web";


// Campaign properties
$GLOBALS['strDontExpire'] = "Que no caduqui";
$GLOBALS['strActivateNow'] = "Comença immediatament";
$GLOBALS['strSetSpecificDate'] = "Indica una data específica";
$GLOBALS['strLow'] = "Baixa";
$GLOBALS['strHigh'] = "Alta";
$GLOBALS['strExpirationDate'] = "Data de fi";
$GLOBALS['strExpirationDateComment'] = "La campanya acabarà al final d'aquest dia";
$GLOBALS['strActivationDate'] = "Data d'inici";
$GLOBALS['strActivationDateComment'] = "La campanya començarà al final d'aquest dia";
$GLOBALS['strImpressionsRemaining'] = "Impressions restants";
$GLOBALS['strClicksRemaining'] = "Clics restants";
$GLOBALS['strConversionsRemaining'] = "Conversions restants";
$GLOBALS['strImpressionsBooked'] = "Impressions contractades";
$GLOBALS['strClicksBooked'] = "Clics contractats";
$GLOBALS['strConversionsBooked'] = "Conversions contractades";
$GLOBALS['strCampaignWeight'] = "Defineix el pes de la campanya";
$GLOBALS['strAnonymous'] = "";
$GLOBALS['strTargetPerDay'] = "per dia.";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "";
$GLOBALS['strCampaignWarningEcpmNoRevenue'] = "";
$GLOBALS['strCampaignWarningOverrideNoWeight'] = "";
$GLOBALS['strCampaignWarningNoTarget'] = "";
$GLOBALS['strCampaignStatusPending'] = "Pendent";
$GLOBALS['strCampaignStatusInactive'] = "Inactiva";
$GLOBALS['strCampaignStatusRunning'] = "En execució";
$GLOBALS['strCampaignStatusPaused'] = "En pausa";
$GLOBALS['strCampaignStatusAwaiting'] = "En espera";
$GLOBALS['strCampaignStatusExpired'] = "Completat";
$GLOBALS['strCampaignStatusApproval'] = "Esperant l'aprovació »";
$GLOBALS['strCampaignStatusRejected'] = "Rebutjada";
$GLOBALS['strCampaignStatusAdded'] = "Afegida";
$GLOBALS['strCampaignStatusStarted'] = "Iniciada";
$GLOBALS['strCampaignStatusRestarted'] = "Reiniciada";
$GLOBALS['strCampaignStatusDeleted'] = "Eliminada";
$GLOBALS['strCampaignType'] = "Tipus de campanya";
$GLOBALS['strType'] = "Tipus";
$GLOBALS['strContract'] = "Contracte";
$GLOBALS['strOverride'] = "Substitució";
$GLOBALS['strOverrideInfo'] = "Les campanyes de substitució són un tipus de campanya especial per substituir (és a dir, tenir prioritat sobre) les campanyes romanents i de contracte. Les campanyes de substitució s'utilitzen generalment amb regles específiques d'orientació i/o límit per garantir que els bàners de la campanya es mostrin sempre a determinades ubicacions, a determinats usuaris, i potser un cert nombre de vegades, com a part d'una promoció específica. (Aquesta campanya anteriorment es coneixia com a \"Contracte (exclusiu)\".)";
$GLOBALS['strStandardContract'] = "Contracte";
$GLOBALS['strStandardContractInfo'] = "Les campanyes de contracte són per lliurar sense problemes les impressions necessàries per assolir un requisit de rendiment en un temps especificat. És a dir, les campanyes de Contracte són per quan un anunciant ha pagat específicament per tenir un nombre determinat d'impressions, clics i/o conversions aconseguits entre dues dates o per dia.";
$GLOBALS['strRemnant'] = "Romanent";
$GLOBALS['strRemnantInfo'] = "El tipus de campanya predeterminat. Les campanyes romanents tenen moltes opcions de lliurament diferents i, idealment, sempre hauríeu de tenir almenys una campanya romanent vinculada a cada zona, per garantir que sempre hi ha alguna cosa per mostrar. Utilitzeu les campanyes romanents per mostrar bàners propis, bàners de xarxa publicitària o fins i tot publicitat directa que s'ha venut, però on no hi ha un requisit de rendiment crític per la campanya.";
$GLOBALS['strECPMInfo'] = "";
$GLOBALS['strPricing'] = "";
$GLOBALS['strPricingModel'] = "";
$GLOBALS['strSelectPricingModel'] = "-- seleccioneu model --";
$GLOBALS['strRatePrice'] = "";
$GLOBALS['strMinimumImpressions'] = "";
$GLOBALS['strLimit'] = "Límit";
$GLOBALS['strLowExclusiveDisabled'] = "";
$GLOBALS['strCannotSetBothDateAndLimit'] = "";
$GLOBALS['strWhyDisabled'] = "perquè està desactivat?";
$GLOBALS['strBackToCampaigns'] = "Tornar a la llista de campanyes";
$GLOBALS['strCampaignBanners'] = "Bàners de la campanya";
$GLOBALS['strCookies'] = "Galetes";

// Tracker
$GLOBALS['strTracker'] = "";
$GLOBALS['strTrackers'] = "";
$GLOBALS['strTrackerPreferences'] = "";
$GLOBALS['strAddTracker'] = "";
$GLOBALS['strTrackerForAdvertiser'] = "per anunciant";
$GLOBALS['strNoTrackers'] = "";
$GLOBALS['strConfirmDeleteTrackers'] = "";
$GLOBALS['strConfirmDeleteTracker'] = "";
$GLOBALS['strTrackerProperties'] = "";
$GLOBALS['strDefaultStatus'] = "Estat per defecte";
$GLOBALS['strStatus'] = "Estat";
$GLOBALS['strLinkedTrackers'] = "";
$GLOBALS['strTrackerInformation'] = "";
$GLOBALS['strConversionWindow'] = "Finestra de conversió";
$GLOBALS['strUniqueWindow'] = "Finestra única";
$GLOBALS['strClick'] = "Clic";
$GLOBALS['strView'] = "Vista";
$GLOBALS['strArrival'] = "Arribada";
$GLOBALS['strManual'] = "Manual";
$GLOBALS['strImpression'] = "Impressió";
$GLOBALS['strConversionType'] = "Tipus de conversió";
$GLOBALS['strLinkCampaignsByDefault'] = "";
$GLOBALS['strBackToTrackers'] = "";
$GLOBALS['strIPAddress'] = "Adreça IP";

// Banners (General)
$GLOBALS['strBanner'] = "Bàner";
$GLOBALS['strBanners'] = "Bàners";
$GLOBALS['strAddBanner'] = "Afegeix nou bàner";
$GLOBALS['strAddBanner_Key'] = "Afegeix <u>n</u>ou bàner";
$GLOBALS['strBannerToCampaign'] = "a la campanya";
$GLOBALS['strShowBanner'] = "Mostra el bàner";
$GLOBALS['strBannerProperties'] = "Propietats del bàner";
$GLOBALS['strBannerHistory'] = "Estadístiques del bàner";
$GLOBALS['strNoBanners'] = "";
$GLOBALS['strNoBannersAddCampaign'] = "";
$GLOBALS['strNoBannersAddAdvertiser'] = "Actualment no hi ha bàners definits, perquè no hi ha anunciants. Per crear un bàner, primer <a href='advertiser-edit.php'>afegiu un anunciant nou</a>.";
$GLOBALS['strConfirmDeleteBanner'] = "";
$GLOBALS['strConfirmDeleteBanners'] = "";
$GLOBALS['strShowParentCampaigns'] = "Mostra les campanyes pare";
$GLOBALS['strHideParentCampaigns'] = "Oculta les campanyes pare";
$GLOBALS['strHideInactiveBanners'] = "Oculta els bàners inactius";
$GLOBALS['strInactiveBannersHidden'] = "bàners inactius ocults";
$GLOBALS['strWarningMissing'] = "";
$GLOBALS['strWarningMissingClosing'] = "";
$GLOBALS['strWarningMissingOpening'] = "";
$GLOBALS['strSubmitAnyway'] = "Envia igualment";
$GLOBALS['strBannersOfCampaign'] = "de la"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Preferències de bàners";
$GLOBALS['strCampaignPreferences'] = "Preferències de campanya";
$GLOBALS['strDefaultBanners'] = "Bàners per defecte";
$GLOBALS['strDefaultBannerUrl'] = "URL de defecte de l'imatge";
$GLOBALS['strDefaultBannerDestination'] = "URL de destí per defecte";
$GLOBALS['strAllowedBannerTypes'] = "Tipus de bàner permesos";
$GLOBALS['strTypeSqlAllow'] = "";
$GLOBALS['strTypeWebAllow'] = "";
$GLOBALS['strTypeUrlAllow'] = "Permet bàners externs";
$GLOBALS['strTypeHtmlAllow'] = "Permet bàners d'HTML";
$GLOBALS['strTypeTxtAllow'] = "Permet els anuncis de text";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "";
$GLOBALS['strMySQLBanner'] = "";
$GLOBALS['strWebBanner'] = "";
$GLOBALS['strURLBanner'] = "Vincula un bàner extern";
$GLOBALS['strHTMLBanner'] = "Crea un bàner d'HTML";
$GLOBALS['strTextBanner'] = "Crea un bàner de text";
$GLOBALS['strAlterHTML'] = "";
$GLOBALS['strIframeFriendly'] = "";
$GLOBALS['strUploadOrKeep'] = "";
$GLOBALS['strNewBannerFile'] = "";
$GLOBALS['strNewBannerFileAlt'] = "";
$GLOBALS['strNewBannerURL'] = "URL d'imatge (inclòs http://)";
$GLOBALS['strURL'] = "URL de destí (inclòs http://)";
$GLOBALS['strKeyword'] = "Paraules clau";
$GLOBALS['strTextBelow'] = "Text sota la imatge";
$GLOBALS['strWeight'] = "Pes";
$GLOBALS['strAlt'] = "Text alternatiu";
$GLOBALS['strStatusText'] = "Text d'estat:";
$GLOBALS['strCampaignsWeight'] = "Pes de la campanya";
$GLOBALS['strBannerWeight'] = "Pes del bàner";
$GLOBALS['strBannersWeight'] = "Pes del bàner";
$GLOBALS['strAdserverTypeGeneric'] = "Bàner d'HTML genèric";
$GLOBALS['strDoNotAlterHtml'] = "";
$GLOBALS['strGenericOutputAdServer'] = "Genèric";
$GLOBALS['strBackToBanners'] = "Torna a bàners";
$GLOBALS['strUseWyswygHtmlEditor'] = "";
$GLOBALS['strChangeDefault'] = "";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "";
$GLOBALS['strBannerAppendHTML'] = "";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "";
$GLOBALS['strACL'] = "";
$GLOBALS['strACLAdd'] = "";
$GLOBALS['strApplyLimitationsTo'] = "";
$GLOBALS['strAllBannersInCampaign'] = "";
$GLOBALS['strRemoveAllLimitations'] = "";
$GLOBALS['strEqualTo'] = "és igual a";
$GLOBALS['strDifferentFrom'] = "és diferent de";
$GLOBALS['strLaterThan'] = "és més tard que";
$GLOBALS['strLaterThanOrEqual'] = "és igual o més tard que";
$GLOBALS['strEarlierThan'] = "és abans que";
$GLOBALS['strEarlierThanOrEqual'] = "és abans o igual a";
$GLOBALS['strContains'] = "conté";
$GLOBALS['strNotContains'] = "";
$GLOBALS['strGreaterThan'] = "";
$GLOBALS['strLessThan'] = "és menor que";
$GLOBALS['strGreaterOrEqualTo'] = "és major o igual a";
$GLOBALS['strLessOrEqualTo'] = "és menor o igual a";
$GLOBALS['strAND'] = "I";                          // logical operator
$GLOBALS['strOR'] = "O";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Mostrar aquest bàner només quan:";
$GLOBALS['strWeekDays'] = "Dies de la setmana";
$GLOBALS['strTime'] = "Hora";
$GLOBALS['strDomain'] = "Domini";
$GLOBALS['strSource'] = "Font";
$GLOBALS['strBrowser'] = "Navegador";
$GLOBALS['strOS'] = "SO";
$GLOBALS['strDeliveryLimitations'] = "Regles d'entrega";

$GLOBALS['strDeliveryCappingReset'] = "";
$GLOBALS['strDeliveryCappingTotal'] = "en total";
$GLOBALS['strDeliveryCappingSession'] = "per sessió";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = [];
}
$GLOBALS['strCappingBanner']['title'] = "";
$GLOBALS['strCappingBanner']['limit'] = "Limita les vistes del bàner a:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = [];
}
$GLOBALS['strCappingCampaign']['title'] = "";
$GLOBALS['strCappingCampaign']['limit'] = "";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = [];
}
$GLOBALS['strCappingZone']['title'] = "";
$GLOBALS['strCappingZone']['limit'] = "";

// Website
$GLOBALS['strAffiliate'] = "Pàgina web";
$GLOBALS['strAffiliates'] = "Llocs web";
$GLOBALS['strAffiliatesAndZones'] = "Llocs web i zones";
$GLOBALS['strAddNewAffiliate'] = "Afegeix nou lloc web";
$GLOBALS['strAffiliateProperties'] = "Propietats del lloc web";
$GLOBALS['strAffiliateHistory'] = "Estadístiques de la pàgina web";
$GLOBALS['strNoAffiliates'] = "";
$GLOBALS['strConfirmDeleteAffiliate'] = "Realment voleu esborrar aquest lloc web?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Realment voleu esborrar els llocs web seleccionats?";
$GLOBALS['strInactiveAffiliatesHidden'] = "";
$GLOBALS['strShowParentAffiliates'] = "Oculta llocs webs pare";
$GLOBALS['strHideParentAffiliates'] = "Oculta llocs webs pare";

// Website (properties)
$GLOBALS['strWebsite'] = "Pàgina web";
$GLOBALS['strWebsiteURL'] = "URL del lloc web";
$GLOBALS['strAllowAffiliateModifyZones'] = "Permet a l'usuari modificar les seves pròpies zones";
$GLOBALS['strAllowAffiliateLinkBanners'] = "";
$GLOBALS['strAllowAffiliateAddZone'] = "";
$GLOBALS['strAllowAffiliateDeleteZone'] = "";
$GLOBALS['strAllowAffiliateGenerateCode'] = "";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Codi postal";
$GLOBALS['strCountry'] = "País";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Zones del lloc web";

// Zone
$GLOBALS['strZone'] = "Zona";
$GLOBALS['strZones'] = "Zones";
$GLOBALS['strAddNewZone'] = "Afegeix nova zona";
$GLOBALS['strAddNewZone_Key'] = "Afegeix <u>n</u>ova zona";
$GLOBALS['strZoneToWebsite'] = "al lloc web";
$GLOBALS['strLinkedZones'] = "Zones vinculades";
$GLOBALS['strAvailableZones'] = "Zones disponibles";
$GLOBALS['strLinkingNotSuccess'] = "";
$GLOBALS['strZoneProperties'] = "Propietats de la zona";
$GLOBALS['strZoneHistory'] = "Història de la zona";
$GLOBALS['strNoZones'] = "";
$GLOBALS['strNoZonesAddWebsite'] = "";
$GLOBALS['strConfirmDeleteZone'] = "";
$GLOBALS['strConfirmDeleteZones'] = "";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "";
$GLOBALS['strZoneType'] = "Tipus de zona";
$GLOBALS['strBannerButtonRectangle'] = "";
$GLOBALS['strInterstitial'] = "";
$GLOBALS['strPopup'] = "Finestra emergent";
$GLOBALS['strTextAdZone'] = "Anunci de text";
$GLOBALS['strEmailAdZone'] = "";
$GLOBALS['strZoneVideoInstream'] = "";
$GLOBALS['strZoneVideoOverlay'] = "";
$GLOBALS['strShowMatchingBanners'] = "";
$GLOBALS['strHideMatchingBanners'] = "";
$GLOBALS['strBannerLinkedAds'] = "Bàners vinculats a la zona";
$GLOBALS['strCampaignLinkedAds'] = "";
$GLOBALS['strInactiveZonesHidden'] = "";
$GLOBALS['strWarnChangeZoneType'] = "";
$GLOBALS['strWarnChangeZoneSize'] = '';
$GLOBALS['strWarnChangeBannerSize'] = '';
$GLOBALS['strWarnBannerReadonly'] = '';
$GLOBALS['strZonesOfWebsite'] = 'de la'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "";
$GLOBALS['strIab']['IAB_Pop-Under(720x300)'] = "";
$GLOBALS['strIab']['IAB_3:1Rectangle(300x100)'] = "";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "Avançat";
$GLOBALS['strChainSettings'] = "";
$GLOBALS['strZoneNoDelivery'] = "";
$GLOBALS['strZoneStopDelivery'] = "";
$GLOBALS['strZoneOtherZone'] = "";
$GLOBALS['strZoneAppend'] = "";
$GLOBALS['strAppendSettings'] = "";
$GLOBALS['strZonePrependHTML'] = "";
$GLOBALS['strZoneAppendNoBanner'] = "";
$GLOBALS['strZoneAppendHTMLCode'] = "Codi HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "";
$GLOBALS['strZoneProbNullPri'] = "";
$GLOBALS['strZoneProbListChainLoop'] = "";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "";
$GLOBALS['strLinkedBanners'] = "Vincula bàners individuals";
$GLOBALS['strCampaignDefaults'] = "";
$GLOBALS['strLinkedCategories'] = "Vincula bàners per categoria";
$GLOBALS['strWithXBanners'] = "";
$GLOBALS['strRawQueryString'] = "Paraula clau";
$GLOBALS['strIncludedBanners'] = "Bàners vinculats";
$GLOBALS['strMatchingBanners'] = "";
$GLOBALS['strNoCampaignsToLink'] = "";
$GLOBALS['strNoTrackersToLink'] = "";
$GLOBALS['strNoZonesToLinkToCampaign'] = "";
$GLOBALS['strSelectBannerToLink'] = "";
$GLOBALS['strSelectCampaignToLink'] = "";
$GLOBALS['strSelectAdvertiser'] = "Selecciona anunciant";
$GLOBALS['strSelectPlacement'] = "Selecciona campanya";
$GLOBALS['strSelectAd'] = "Selecciona bàner";
$GLOBALS['strSelectPublisher'] = "Selecciona lloc web";
$GLOBALS['strSelectZone'] = "Selecciona zona";
$GLOBALS['strStatusPending'] = "Pendent";
$GLOBALS['strStatusApproved'] = "Aprovat";
$GLOBALS['strStatusDisapproved'] = "Rebutjat";
$GLOBALS['strStatusDuplicate'] = "Duplica";
$GLOBALS['strStatusOnHold'] = "En espera";
$GLOBALS['strStatusIgnore'] = "Ignora";
$GLOBALS['strConnectionType'] = "Tipus";
$GLOBALS['strConnTypeSale'] = "";
$GLOBALS['strConnTypeLead'] = "";
$GLOBALS['strConnTypeSignUp'] = "";
$GLOBALS['strShortcutEditStatuses'] = "";
$GLOBALS['strShortcutShowStatuses'] = "";

// Statistics
$GLOBALS['strStats'] = "Estadístiques";
$GLOBALS['strNoStats'] = "";
$GLOBALS['strNoStatsForPeriod'] = "";
$GLOBALS['strGlobalHistory'] = "Estadístiques globals";
$GLOBALS['strDailyHistory'] = "Estadístiques diàries";
$GLOBALS['strDailyStats'] = "Estadístiques diàries";
$GLOBALS['strWeeklyHistory'] = "Estadístiques setmanals";
$GLOBALS['strMonthlyHistory'] = "Estadístiques mensuals";
$GLOBALS['strTotalThisPeriod'] = "";
$GLOBALS['strPublisherDistribution'] = "";
$GLOBALS['strCampaignDistribution'] = "";
$GLOBALS['strViewBreakdown'] = "";
$GLOBALS['strBreakdownByDay'] = "Dia";
$GLOBALS['strBreakdownByWeek'] = "Setmana";
$GLOBALS['strBreakdownByMonth'] = "Mes";
$GLOBALS['strBreakdownByDow'] = "Dia de la setmana";
$GLOBALS['strBreakdownByHour'] = "Hora";
$GLOBALS['strItemsPerPage'] = "";
$GLOBALS['strDistributionHistoryCampaign'] = "";
$GLOBALS['strDistributionHistoryBanner'] = "";
$GLOBALS['strDistributionHistoryWebsite'] = "";
$GLOBALS['strDistributionHistoryZone'] = "";
$GLOBALS['strShowGraphOfStatistics'] = "";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>xporta estadístiques a Excel";
$GLOBALS['strGDnotEnabled'] = "";
$GLOBALS['strStatsArea'] = "";

// Expiration
$GLOBALS['strNoExpiration'] = "";
$GLOBALS['strEstimated'] = "";
$GLOBALS['strNoExpirationEstimation'] = "";
$GLOBALS['strDaysAgo'] = "";
$GLOBALS['strCampaignStop'] = "";

// Reports
$GLOBALS['strAdvancedReports'] = "Informes avançats";
$GLOBALS['strStartDate'] = "Data d'inici";
$GLOBALS['strEndDate'] = "Data de fi";
$GLOBALS['strPeriod'] = "Període";
$GLOBALS['strLimitations'] = "Regles d'entrega";
$GLOBALS['strWorksheets'] = "";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Tots els anunciants";
$GLOBALS['strAnonAdvertisers'] = "";
$GLOBALS['strAllPublishers'] = "Tots els llocs web";
$GLOBALS['strAnonPublishers'] = "Llocs webs anònims";
$GLOBALS['strAllAvailZones'] = "Totes les zones disponibles";

// Userlog
$GLOBALS['strUserLog'] = "";
$GLOBALS['strUserLogDetails'] = "";
$GLOBALS['strDeleteLog'] = "";
$GLOBALS['strAction'] = "Acció";
$GLOBALS['strNoActionsLogged'] = "";

// Code generation
$GLOBALS['strGenerateBannercode'] = "";
$GLOBALS['strChooseInvocationType'] = "";
$GLOBALS['strGenerate'] = "Generar";
$GLOBALS['strParameters'] = "Preferències d'etiqueta";
$GLOBALS['strFrameSize'] = "Mida del marc";
$GLOBALS['strBannercode'] = "Codi del bàner";
$GLOBALS['strTrackercode'] = "";
$GLOBALS['strBackToTheList'] = "";
$GLOBALS['strCharset'] = "Joc de caràcters";
$GLOBALS['strAutoDetect'] = "Autodetectar";
$GLOBALS['strCacheBusterComment'] = "";
$GLOBALS['strGenerateHttpsTags'] = "";

// Errors
$GLOBALS['strErrorDatabaseConnection'] = "";
$GLOBALS['strErrorCantConnectToDatabase'] = "";
$GLOBALS['strNoMatchesFound'] = "No hi ha coincidències";
$GLOBALS['strErrorOccurred'] = "Hi ha hagut un error";
$GLOBALS['strErrorDBPlain'] = "";
$GLOBALS['strErrorDBSerious'] = "";
$GLOBALS['strErrorDBNoDataPlain'] = "";
$GLOBALS['strErrorDBNoDataSerious'] = "";
$GLOBALS['strErrorDBCorrupt'] = "";
$GLOBALS['strErrorDBContact'] = "";
$GLOBALS['strErrorDBSubmitBug'] = "";
$GLOBALS['strMaintenanceNotActive'] = "";
$GLOBALS['strErrorLinkingBanner'] = "";
$GLOBALS['strUnableToLinkBanner'] = "";
$GLOBALS['strErrorEditingCampaignRevenue'] = "";
$GLOBALS['strErrorEditingCampaignECPM'] = "";
$GLOBALS['strErrorEditingZone'] = "";
$GLOBALS['strUnableToChangeZone'] = "";
$GLOBALS['strDatesConflict'] = "";
$GLOBALS['strEmailNoDates'] = "";
$GLOBALS['strWarningInaccurateStats'] = "";
$GLOBALS['strWarningInaccurateReadMore'] = "";
$GLOBALS['strWarningInaccurateReport'] = "";

//Validation
$GLOBALS['strRequiredFieldLegend'] = "camp obligatori";
$GLOBALS['strFormContainsErrors'] = "";
$GLOBALS['strXRequiredField'] = "";
$GLOBALS['strEmailField'] = "";
$GLOBALS['strNumericField'] = "";
$GLOBALS['strGreaterThanZeroField'] = "";
$GLOBALS['strXGreaterThanZeroField'] = "";
$GLOBALS['strXPositiveWholeNumberField'] = "";
$GLOBALS['strInvalidWebsiteURL'] = "URL del lloc web invàlida";

// Email
$GLOBALS['strSirMadam'] = "Sr/Sra";
$GLOBALS['strMailSubject'] = "";
$GLOBALS['strMailHeader'] = "Benvolgut {contact},";
$GLOBALS['strMailBannerStats'] = "";
$GLOBALS['strMailBannerActivatedSubject'] = "";
$GLOBALS['strMailBannerDeactivatedSubject'] = "";
$GLOBALS['strMailBannerActivated'] = "";
$GLOBALS['strMailBannerDeactivated'] = "";
$GLOBALS['strMailFooter'] = "";
$GLOBALS['strClientDeactivated'] = "";
$GLOBALS['strBeforeActivate'] = "";
$GLOBALS['strAfterExpire'] = "";
$GLOBALS['strNoMoreImpressions'] = "";
$GLOBALS['strNoMoreClicks'] = "";
$GLOBALS['strNoMoreConversions'] = "";
$GLOBALS['strWeightIsNull'] = "el seu pes està marcat a zero";
$GLOBALS['strRevenueIsNull'] = "";
$GLOBALS['strTargetIsNull'] = "";
$GLOBALS['strNoViewLoggedInInterval'] = "";
$GLOBALS['strNoClickLoggedInInterval'] = "";
$GLOBALS['strNoConversionLoggedInInterval'] = "";
$GLOBALS['strMailReportPeriod'] = "";
$GLOBALS['strMailReportPeriodAll'] = "";
$GLOBALS['strNoStatsForCampaign'] = "";
$GLOBALS['strImpendingCampaignExpiry'] = "";
$GLOBALS['strYourCampaign'] = "La vostra campanya";
$GLOBALS['strTheCampiaignBelongingTo'] = "";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "";
$GLOBALS['strImpendingCampaignExpiryBody'] = "";

// Priority
$GLOBALS['strPriority'] = "Prioritat";
$GLOBALS['strSourceEdit'] = "";

// Preferences
$GLOBALS['strPreferences'] = "Preferències";
$GLOBALS['strUserPreferences'] = "Preferències de l'usuari";
$GLOBALS['strChangePassword'] = "Canvia la contrasenya";
$GLOBALS['strChangeEmail'] = "Canvia el correu electrònic";
$GLOBALS['strCurrentPassword'] = "Contrasenya actual";
$GLOBALS['strChooseNewPassword'] = "Escull una nova contrasenya";
$GLOBALS['strReenterNewPassword'] = "";
$GLOBALS['strNameLanguage'] = "Nom i idioma";
$GLOBALS['strAccountPreferences'] = "Preferències del compte";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Preferències d'informes per correu electrònic de campanyes";
$GLOBALS['strTimezonePreferences'] = "Preferències de la zona horària";
$GLOBALS['strAdminEmailWarnings'] = "";
$GLOBALS['strAgencyEmailWarnings'] = "";
$GLOBALS['strAdveEmailWarnings'] = "";
$GLOBALS['strFullName'] = "Nom complet";
$GLOBALS['strEmailAddress'] = "Adreça de correu electrònic";
$GLOBALS['strUserDetails'] = "Detalls de l'usuari";
$GLOBALS['strUserInterfacePreferences'] = "";
$GLOBALS['strPluginPreferences'] = "";
$GLOBALS['strColumnName'] = "";
$GLOBALS['strShowColumn'] = "";
$GLOBALS['strCustomColumnName'] = "";
$GLOBALS['strColumnRank'] = "";

// Long names
$GLOBALS['strRevenue'] = "";
$GLOBALS['strNumberOfItems'] = "";
$GLOBALS['strRevenueCPC'] = "";
$GLOBALS['strERPM'] = "";
$GLOBALS['strERPC'] = "";
$GLOBALS['strERPS'] = "";
$GLOBALS['strEIPM'] = "";
$GLOBALS['strEIPC'] = "";
$GLOBALS['strEIPS'] = "";
$GLOBALS['strECPM'] = "";
$GLOBALS['strECPC'] = "";
$GLOBALS['strECPS'] = "";
$GLOBALS['strPendingConversions'] = "";
$GLOBALS['strImpressionSR'] = "";
$GLOBALS['strClickSR'] = "";

// Short names
$GLOBALS['strRevenue_short'] = "";
$GLOBALS['strBasketValue_short'] = "";
$GLOBALS['strNumberOfItems_short'] = "";
$GLOBALS['strRevenueCPC_short'] = "";
$GLOBALS['strERPM_short'] = "";
$GLOBALS['strERPC_short'] = "";
$GLOBALS['strERPS_short'] = "";
$GLOBALS['strEIPM_short'] = "";
$GLOBALS['strEIPC_short'] = "";
$GLOBALS['strEIPS_short'] = "";
$GLOBALS['strECPM_short'] = "";
$GLOBALS['strECPC_short'] = "";
$GLOBALS['strECPS_short'] = "";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strRequests_short'] = "";
$GLOBALS['strImpressions_short'] = "";
$GLOBALS['strClicks_short'] = "Clics";
$GLOBALS['strCTR_short'] = "CTR (% de clics)";
$GLOBALS['strConversions_short'] = "";
$GLOBALS['strPendingConversions_short'] = "";
$GLOBALS['strImpressionSR_short'] = "";
$GLOBALS['strClickSR_short'] = "";

// Global Settings
$GLOBALS['strConfiguration'] = "Configuració";
$GLOBALS['strGlobalSettings'] = "Configuració global";
$GLOBALS['strGeneralSettings'] = "Configuració General";
$GLOBALS['strMainSettings'] = "Configuració principal";
$GLOBALS['strPlugins'] = "Extensions";
$GLOBALS['strChooseSection'] = 'Escull secció';

// Product Updates
$GLOBALS['strProductUpdates'] = "";
$GLOBALS['strViewPastUpdates'] = "";
$GLOBALS['strFromVersion'] = "De la versió";
$GLOBALS['strToVersion'] = "a la versió";
$GLOBALS['strToggleDataBackupDetails'] = "";
$GLOBALS['strClickViewBackupDetails'] = "";
$GLOBALS['strClickHideBackupDetails'] = "";
$GLOBALS['strShowBackupDetails'] = "";
$GLOBALS['strHideBackupDetails'] = "";
$GLOBALS['strBackupDeleteConfirm'] = "";
$GLOBALS['strDeleteArtifacts'] = "";
$GLOBALS['strArtifacts'] = "";
$GLOBALS['strBackupDbTables'] = "";
$GLOBALS['strLogFiles'] = "";
$GLOBALS['strConfigBackups'] = "";
$GLOBALS['strUpdatedDbVersionStamp'] = "";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "";

// Agency
$GLOBALS['strAgencyManagement'] = "";
$GLOBALS['strAgency'] = "Compte";
$GLOBALS['strAddAgency'] = "Afegeix un compte nou";
$GLOBALS['strAddAgency_Key'] = "Afegeix un <u>n</u>ou compte";
$GLOBALS['strTotalAgencies'] = "Comptes totals";
$GLOBALS['strAgencyProperties'] = "Propietats del compte";
$GLOBALS['strNoAgencies'] = "";
$GLOBALS['strConfirmDeleteAgency'] = "Realment voleu esborrar aquest compte?";
$GLOBALS['strHideInactiveAgencies'] = "Oculta els comptes inactius";
$GLOBALS['strInactiveAgenciesHidden'] = "";
$GLOBALS['strSwitchAccount'] = "";
$GLOBALS['strAgencyStatusRunning'] = "Actiu";
$GLOBALS['strAgencyStatusInactive'] = "Inactiva";
$GLOBALS['strAgencyStatusPaused'] = "Suspès";

// Channels
$GLOBALS['strChannel'] = "";
$GLOBALS['strChannels'] = "";
$GLOBALS['strChannelManagement'] = "";
$GLOBALS['strAddNewChannel'] = "";
$GLOBALS['strAddNewChannel_Key'] = "";
$GLOBALS['strChannelToWebsite'] = "al lloc web";
$GLOBALS['strNoChannels'] = "";
$GLOBALS['strNoChannelsAddWebsite'] = "";
$GLOBALS['strEditChannelLimitations'] = "";
$GLOBALS['strChannelProperties'] = "";
$GLOBALS['strChannelLimitations'] = "Opcions d'entrega";
$GLOBALS['strConfirmDeleteChannel'] = "";
$GLOBALS['strConfirmDeleteChannels'] = "";
$GLOBALS['strChannelsOfWebsite'] = 'de la'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "";
$GLOBALS['strVariableDescription'] = "Descripció";
$GLOBALS['strVariableDataType'] = "";
$GLOBALS['strVariablePurpose'] = "";
$GLOBALS['strGeneric'] = "Genèric";
$GLOBALS['strBasketValue'] = "";
$GLOBALS['strNumItems'] = "";
$GLOBALS['strVariableIsUnique'] = "";
$GLOBALS['strNumber'] = "";
$GLOBALS['strString'] = "";
$GLOBALS['strTrackFollowingVars'] = "";
$GLOBALS['strAddVariable'] = "Afegeix variable";
$GLOBALS['strNoVarsToTrack'] = "";
$GLOBALS['strVariableRejectEmpty'] = "";
$GLOBALS['strTrackingSettings'] = "";
$GLOBALS['strTrackerType'] = "";
$GLOBALS['strTrackerTypeJS'] = "";
$GLOBALS['strTrackerTypeDefault'] = "";
$GLOBALS['strTrackerTypeDOM'] = "";
$GLOBALS['strTrackerTypeCustom'] = "";
$GLOBALS['strVariableCode'] = "";

// Password recovery
$GLOBALS['strForgotPassword'] = "";
$GLOBALS['strPasswordRecovery'] = "";
$GLOBALS['strWelcomePage'] = "";
$GLOBALS['strWelcomePageText'] = "";
$GLOBALS['strEmailRequired'] = "El correu electrònic és un camp obligatori";
$GLOBALS['strPwdRecWrongExpired'] = "";
$GLOBALS['strPwdRecEnterEmail'] = "Introduïu la vostra adreça de correu electrònic.";
$GLOBALS['strPwdRecEnterPassword'] = "Introduïu la nova contrasenya";
$GLOBALS['strProceed'] = "Continuar >";
$GLOBALS['strNotifyPageMessage'] = "";

// Password recovery - Default
$GLOBALS['strPwdRecEmailPwdRecovery'] = "";
$GLOBALS['strPwdRecEmailBody'] = "";

$GLOBALS['strPwdRecEmailSincerely'] = "Atentament,";

// Password recovery - Welcome email
$GLOBALS['strWelcomeEmailSubject'] = "";
$GLOBALS['strWelcomeEmailBody'] = "";

// Password recovery - Hash update
$GLOBALS['strPasswordUpdateEmailSubject'] = "";
$GLOBALS['strPasswordUpdateEmailBody'] = "";

// Password reset warning
$GLOBALS['strPasswordResetRequiredTitle'] = "";
$GLOBALS['strPasswordResetRequired'] = "";
$GLOBALS['strPasswordUnsafeWarning'] = "";

// Audit
$GLOBALS['strAdditionalItems'] = "";
$GLOBALS['strAuditSystem'] = "Sistema";
$GLOBALS['strFor'] = "per a";
$GLOBALS['strHas'] = "té";
$GLOBALS['strBinaryData'] = "Dades binàries";
$GLOBALS['strAuditTrailDisabled'] = "";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "";
$GLOBALS['strAuditTrail'] = "";
$GLOBALS['strAuditTrailSetup'] = "";
$GLOBALS['strAuditTrailGoTo'] = "";
$GLOBALS['strAuditTrailNotEnabled'] = "";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Vés a la pàgina de campanyes";
$GLOBALS['strCampaignSetUp'] = "";
$GLOBALS['strCampaignNoRecords'] = "";
$GLOBALS['strCampaignNoRecordsAdmin'] = "";

$GLOBALS['strCampaignNoDataTimeSpan'] = "";
$GLOBALS['strCampaignAuditNotActivated'] = "";
$GLOBALS['strCampaignAuditTrailSetup'] = "";

$GLOBALS['strUnsavedChanges'] = "";
$GLOBALS['strDeliveryLimitationsDisagree'] = "";
$GLOBALS['strDeliveryRulesDbError'] = "";
$GLOBALS['strDeliveryRulesTruncation'] = "";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "";
$GLOBALS['strYouDontHaveAccess'] = "";

$GLOBALS['strAdvertiserHasBeenAdded'] = "";
$GLOBALS['strAdvertiserHasBeenUpdated'] = "";
$GLOBALS['strAdvertiserHasBeenDeleted'] = "";
$GLOBALS['strAdvertisersHaveBeenDeleted'] = "";

$GLOBALS['strTrackerHasBeenAdded'] = "";
$GLOBALS['strTrackerHasBeenUpdated'] = "";
$GLOBALS['strTrackerVarsHaveBeenUpdated'] = "";
$GLOBALS['strTrackerCampaignsHaveBeenUpdated'] = "";
$GLOBALS['strTrackerAppendHasBeenUpdated'] = "";
$GLOBALS['strTrackerHasBeenDeleted'] = "";
$GLOBALS['strTrackersHaveBeenDeleted'] = "";
$GLOBALS['strTrackerHasBeenDuplicated'] = "";
$GLOBALS['strTrackerHasBeenMoved'] = "";

$GLOBALS['strCampaignHasBeenAdded'] = "";
$GLOBALS['strCampaignHasBeenUpdated'] = "";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "";
$GLOBALS['strCampaignHasBeenDeleted'] = "";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "";
$GLOBALS['strCampaignHasBeenDuplicated'] = "";
$GLOBALS['strCampaignHasBeenMoved'] = "";

$GLOBALS['strBannerHasBeenAdded'] = "";
$GLOBALS['strBannerHasBeenUpdated'] = "";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "";
$GLOBALS['strBannerAclHasBeenUpdated'] = "";
$GLOBALS['strBannerAclHasBeenAppliedTo'] = "";
$GLOBALS['strBannerHasBeenDeleted'] = "";
$GLOBALS['strBannersHaveBeenDeleted'] = "";
$GLOBALS['strBannerHasBeenDuplicated'] = "";
$GLOBALS['strBannerHasBeenMoved'] = "";
$GLOBALS['strBannerHasBeenActivated'] = "";
$GLOBALS['strBannerHasBeenDeactivated'] = "";

$GLOBALS['strXZonesLinked'] = "";
$GLOBALS['strXZonesUnlinked'] = "";

$GLOBALS['strWebsiteHasBeenAdded'] = "";
$GLOBALS['strWebsiteHasBeenUpdated'] = "";
$GLOBALS['strWebsiteHasBeenDeleted'] = "";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "Tots els llocs webs seleccionats han estat esborrats";
$GLOBALS['strWebsiteHasBeenDuplicated'] = "";

$GLOBALS['strZoneHasBeenAdded'] = "";
$GLOBALS['strZoneHasBeenUpdated'] = "";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "";
$GLOBALS['strZoneHasBeenDeleted'] = "";
$GLOBALS['strZonesHaveBeenDeleted'] = "";
$GLOBALS['strZoneHasBeenDuplicated'] = "";
$GLOBALS['strZoneHasBeenMoved'] = "";
$GLOBALS['strZoneLinkedBanner'] = "";
$GLOBALS['strZoneLinkedCampaign'] = "";
$GLOBALS['strZoneRemovedBanner'] = "";
$GLOBALS['strZoneRemovedCampaign'] = "";

$GLOBALS['strChannelHasBeenAdded'] = "";
$GLOBALS['strChannelHasBeenUpdated'] = "";
$GLOBALS['strChannelAclHasBeenUpdated'] = "";
$GLOBALS['strChannelHasBeenDeleted'] = "";
$GLOBALS['strChannelsHaveBeenDeleted'] = "";
$GLOBALS['strChannelHasBeenDuplicated'] = "";

$GLOBALS['strUserPreferencesUpdated'] = "";
$GLOBALS['strEmailChanged'] = "";
$GLOBALS['strPasswordChanged'] = "";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "";
$GLOBALS['strTZPreferencesWarning'] = "";

// Report error messages
$GLOBALS['strReportErrorMissingSheets'] = "";
$GLOBALS['strReportErrorUnknownCode'] = "";

/* ------------------------------------------------------- */
/* Password strength                                       */
/* ------------------------------------------------------- */

$GLOBALS['strPasswordMinLength'] = '';
$GLOBALS['strPasswordTooShort'] = "";

if (!isset($GLOBALS['strPasswordScore'])) {
    $GLOBALS['strPasswordScore'] = [];
}

$GLOBALS['strPasswordScore'][0] = "";
$GLOBALS['strPasswordScore'][1] = "";
$GLOBALS['strPasswordScore'][2] = "";
$GLOBALS['strPasswordScore'][3] = "";
$GLOBALS['strPasswordScore'][4] = "";


/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome'] = "";
$GLOBALS['keyUp'] = "";
$GLOBALS['keyNextItem'] = ",";
$GLOBALS['keyPreviousItem'] = ".";
$GLOBALS['keyList'] = "";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "";
$GLOBALS['keyCollapseAll'] = "";
$GLOBALS['keyExpandAll'] = "";
$GLOBALS['keyAddNew'] = "";
$GLOBALS['keyNext'] = "";
$GLOBALS['keyPrevious'] = "";
$GLOBALS['keyLinkUser'] = "";
$GLOBALS['keyWorkingAs'] = "";
