<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Set translation strings
$GLOBALS['strHome'] = "Home";
$GLOBALS['date_format'] = "%d/%m/%Y";
$GLOBALS['time_format'] = "%H:%i:%S";
$GLOBALS['strMySQLError'] = "Errore MySQl:";
$GLOBALS['strAdminstration'] = "Amministrazione";
$GLOBALS['strAddClient'] = "Aggiungi nuovo utente";
$GLOBALS['strModifyClient'] = "Modifica utente";
$GLOBALS['strDeleteClient'] = "Cancella utente";
$GLOBALS['strViewClientStats'] = "Visualizza statistiche dell'utente";
$GLOBALS['strClientName'] = "Utente";
$GLOBALS['strContact'] = "Contatto";
$GLOBALS['strEMail'] = "E-Mail";
$GLOBALS['strViews'] = "Visualizzazioni";
$GLOBALS['strClicks'] = "Click";
$GLOBALS['strTotalViews'] = "Visualizzazioni Totali";
$GLOBALS['strTotalClicks'] = "Click Totali";
$GLOBALS['strCTR'] = "Rapporto Click-Trough";
$GLOBALS['strTotalClients'] = "Clienti Totali";
$GLOBALS['strActiveClients'] = "Clienti attivi";
$GLOBALS['strActiveBanners'] = "Banner attivi";
$GLOBALS['strLogout'] = "Esci";
$GLOBALS['strCreditStats'] = "Statistiche crediti";
$GLOBALS['strViewCredits'] = "Crediti Visualizzazioni";
$GLOBALS['strClickCredits'] = "Crediti Click";
$GLOBALS['strPrevious'] = "Precedente";
$GLOBALS['strNext'] = "Successivo";
$GLOBALS['strNone'] = "Nessuno";
$GLOBALS['strViewsPurchased'] = "Visualizzazioni Acquistate";
$GLOBALS['strClicksPurchased'] = "Click Acquistati";
$GLOBALS['strDaysPurchased'] = "Giorni Acquistati";
$GLOBALS['strHTML'] = "HTML";
$GLOBALS['strAddSep'] = "Compilare ENTRAMBI i campi sovrastanti OPPURE quello sottostante!";
$GLOBALS['strTextBelow'] = "Testo sotto l'immagine";
$GLOBALS['strSubmit'] = "Invia Banner";
$GLOBALS['strUsername'] = "Nome Utente";
$GLOBALS['strPassword'] = "Parola chiave";
$GLOBALS['strBannerAdmin'] = "Amministrazione Banner per ";
$GLOBALS['strBannerAdminAcl'] = "Amministrazione Banner ACL per";
$GLOBALS['strNoBanners'] = "Nessun banner trovato";
$GLOBALS['strBanner'] = "Banner";
$GLOBALS['strCurrentBanner'] = "Banner attuale";
$GLOBALS['strDelete'] = "Cancella";
$GLOBALS['strAddBanner'] = "Aggiungi nuovo banner";
$GLOBALS['strModifyBanner'] = "Modifica banner";
$GLOBALS['strModifyBannerAcl'] = "Modify banner ACL";
$GLOBALS['strURL'] = "Link (incl. http://)";
$GLOBALS['strKeyword'] = "Parola chiave";
$GLOBALS['strWeight'] = "Peso";
$GLOBALS['strAlt'] = "Testo Alternativo";
$GLOBALS['strAccessDenied'] = "Accesso negato";
$GLOBALS['strPasswordWrong'] = "The password is not correct";
$GLOBALS['strNotAdmin'] = "You may not have enough privileges";
$GLOBALS['strClientAdded'] = "L'utente e' stato aggiunto.";
$GLOBALS['strClientModified'] = "L'utente e' stato modificato.";
$GLOBALS['strClientDeleted'] = "L'utente e' stato cancellato.";
$GLOBALS['strBannerAdmin'] = "Amministrazione Banner";
$GLOBALS['strBannerAdded'] = "Il banner e' stato aggiunto.";
$GLOBALS['strBannerModified'] = "Il banner e' stato modificato.";
$GLOBALS['strBannerDeleted'] = "Il banner e' stato cancellato.";
$GLOBALS['strBannerChanged'] = "Il banner e' stato cambiato.";
$GLOBALS['strStats'] = "Statistiche";
$GLOBALS['strDailyStats'] = "Statistiche quotidiane";
$GLOBALS['strDetailStats'] = "Statistiche dettagliate";
$GLOBALS['strCreditStats'] = "Statistiche dei crediti";
$GLOBALS['strActive'] = "attivo";
$GLOBALS['strActivate'] = "Attiva";
$GLOBALS['strDeActivate'] = "Disattiva";
$GLOBALS['strAuthentification'] = "Autentificazione";
$GLOBALS['strGo'] = "Vai";
$GLOBALS['strLinkedTo'] = "linkato a";
$GLOBALS['strBannerID'] = "ID Banner";
$GLOBALS['strClientID'] = "ID Utente";
$GLOBALS['strMailSubject'] = "Statistiche phpAds";
$GLOBALS['strMailSubjectDeleted'] = "Banner Disattivati";
$GLOBALS['strMailHeader'] = "Egr. Sig. ".(isset($client["contact"]) ? $client["contact"] : '').",\n";
$GLOBALS['strMailBannerStats'] = "ecco le statistiche dei banner per ".(isset($client["clientname"]) ? $client["clientname"] : '').":";
$GLOBALS['strMailFooter'] = 'Distinti saluti,\n   $phpAds_admin_fullname';
$GLOBALS['strLogMailSent'] = "[phpAds] Statistiche inviate correttamente.";
$GLOBALS['strLogErrorClients'] = "[phpAds] Si e\' verificato un errore nel tentativo di recuperare gli utenti dal database.";
$GLOBALS['strLogErrorBanners'] = "[phpAds] Si e\' verificato un errore nel tentativo di recuperare i banner dal database.";
$GLOBALS['strLogErrorViews'] = "[phpAds] Si e\' verificato un errore nel tentativo di recuperare le visualizzazioni dal database.";
$GLOBALS['strLogErrorClicks'] = "[phpAds] Si e\' verificato un errore nel tentativo di recuperare i clicks dal database.";
$GLOBALS['strLogErrorDisactivate'] = "[phpAds] Si e\' verificato un errore nel tentativo di disattivare un banner.";
$GLOBALS['strRatio'] = "Percentuale di Click-Through";
$GLOBALS['strChooseBanner'] = "Scegliere il tipo di banner.";
$GLOBALS['strMySQLBanner'] = "Banner memorizzato nel database MySQL";
$GLOBALS['strWebBanner'] = "Banner stored on the Webserver";
$GLOBALS['strURLBanner'] = "Banner situato ad un altro URL";
$GLOBALS['strHTMLBanner'] = "HTML banner";
$GLOBALS['strNewBannerFile'] = "Nuovo file del banner";
$GLOBALS['strNewBannerURL'] = "Nuovo URL del banner (incl. http://)";
$GLOBALS['strWidth'] = "Larghezza";
$GLOBALS['strHeight'] = "Altezza";
$GLOBALS['strTotalViews7Days'] = "Totale delle visualizzazioni negli ultimi 7 giorni";
$GLOBALS['strTotalClicks7Days'] = "Totale dei click negli ultimi 7 giorni";
$GLOBALS['strAvgViews7Days'] = "Media delle Visualizzazioni negli ultimi 7 giorni";
$GLOBALS['strAvgClicks7Days'] = "Media dei Click negli ultimi 7 giorni";
$GLOBALS['strTopTenHosts'] = "I 10 host da cui provengono le maggiori richieste";
$GLOBALS['strConfirmDeleteClient'] = "Vuoi veramente cancellare questo cliente?";
$GLOBALS['strClientIP'] = "IP Cliente";
$GLOBALS['strUserAgent'] = "User agent regexp";
$GLOBALS['strWeekDay'] = "Giorno della settimana (0 - 6)";
$GLOBALS['strDomain'] = "Dominio (senza punto)";
$GLOBALS['strSource'] = "Source";
$GLOBALS['strTime'] = "Ora";
$GLOBALS['strAllow'] = "Consenti";
$GLOBALS['strDeny'] = "Nega";
$GLOBALS['strResetStats'] = "Azzera Statistiche";
$GLOBALS['strConfirmResetStats'] = "Vuoi veramente azzerare le statistiche per questo cliente ?";
$GLOBALS['strExpiration'] = "Termine";
$GLOBALS['strNoExpiration'] = "No expiration date set";
$GLOBALS['strDaysLeft'] = "Giorni mancanti";
$GLOBALS['strEstimated'] = "Termine stimato";
$GLOBALS['strConfirm'] = "Sei sicuro ?";
$GLOBALS['strBannerNoStats'] = "Non ci sono statistiche disponibili per questo banner!";
$GLOBALS['strWeek'] = "Settimana";
$GLOBALS['strWeeklyStats'] = "Statistiche settimanali";
$GLOBALS['strWeekDay'] = "Giorno della settimana";
$GLOBALS['strDate'] = "Data";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strDayShortCuts'] = array("Dom","Lun","Mar","Mer","Gio","Ven","Sab");
$GLOBALS['strShowWeeks'] = "Max. N. di settimane da mostrare";
$GLOBALS['strAll'] = "Totale";
$GLOBALS['strAvg'] = "Media";
$GLOBALS['strHourly'] = "Visualizzazioni/Click per ora";
$GLOBALS['strTotal'] = "Totale";
$GLOBALS['strUnlimited'] = "Illimitato";
$GLOBALS['strSave'] = "Save";
$GLOBALS['strUp'] = "Up";
$GLOBALS['strDown'] = "Down";
$GLOBALS['strSaved'] = "was saved!";
$GLOBALS['strDeleted'] = "was deleted!";  
$GLOBALS['strMovedUp'] = "was moved up";
$GLOBALS['strMovedDown'] = "was moved down";
$GLOBALS['strUpdated'] = "was updated";
$GLOBALS['strACL'] = "ACL";
$GLOBALS['strNoMoveUp'] = "Can't move up first row";
$GLOBALS['strACLAdd'] = "Add new ".$GLOBALS['strACL'];
$GLOBALS['strACLExist'] = "Existing ".$GLOBALS['strACL'].":";
$GLOBALS['strLogin'] = "Login";
$GLOBALS['strPreferences'] = "Preferences";
$GLOBALS['strAllowClientModifyInfo'] = "Allow this user to modify his own client information";
$GLOBALS['strAllowClientModifyBanner'] = "Allow this user to modify his own banners";
$GLOBALS['strAllowClientAddBanner'] = "Allow this user to add his own banners";
$GLOBALS['strLanguage'] = "Language";
$GLOBALS['strDefault'] = "Default";
$GLOBALS['strErrorViews'] = "You must enter the number of views or select the unlimited box !";
$GLOBALS['strErrorNegViews'] = "Negative views are not allowed";
$GLOBALS['strErrorClicks'] =  "You must enter the number of clicks or select the unlimited box !";
$GLOBALS['strErrorNegClicks'] = "Negative clicks are not allowed";
$GLOBALS['strErrorDays'] = "You must enter the number of days or select the unlimited box !";
$GLOBALS['strErrorNegDays'] = "Negative days are not allowed";
$GLOBALS['strTrackerImage'] = "Tracker image:";

// New strings for version 2
$GLOBALS['strNavigation'] 			= "Navigation";
$GLOBALS['strShortcuts'] 				= "Shortcuts";
$GLOBALS['strDescription'] 			= "Description";
$GLOBALS['strClients'] 				= "Clients";
$GLOBALS['strID']				 		= "ID";
$GLOBALS['strOverall'] 				= "Overall";
$GLOBALS['strTotalBanners'] 			= "Total banners";
$GLOBALS['strToday'] 					= "Today";
$GLOBALS['strThisWeek'] 				= "This week";
$GLOBALS['strThisMonth'] 				= "This month";
$GLOBALS['strBasicInformation'] 		= "Basic information";
$GLOBALS['strContractInformation'] 	= "Contract information";
$GLOBALS['strLoginInformation'] 		= "Login information";
$GLOBALS['strPermissions'] 			= "Permissions";
$GLOBALS['strGeneralSettings']		= "General settings";
$GLOBALS['strSaveChanges']		 	= "Save Changes";
$GLOBALS['strCompact']				= "Compact";
$GLOBALS['strVerbose']				= "Verbose";
$GLOBALS['strOrderBy']				= "order by";
$GLOBALS['strShowAllBanners']	 		= "Show all banners";
$GLOBALS['strShowBannersNoAdClicks']	= "Show banners without AdClicks";
$GLOBALS['strShowBannersNoAdViews']	= "Show banners without AdViews";
$GLOBALS['strShowAllClients'] 		= "Show all clients";
$GLOBALS['strShowClientsActive'] 		= "Show clients with active banners";
$GLOBALS['strShowClientsInactive']	= "Show clients with inactive banners";
$GLOBALS['strSize']					= "Size";

$GLOBALS['strMonth'] 				= array("January","February","March","April","May","June","July", "August", "September", "October", "November", "December");
$GLOBALS['strDontExpire']			= "Don't expire this client on a specific date";
$GLOBALS['strActivateNow'] 			= "Activate this client immediately";
$GLOBALS['strExpirationDate']		= "Expiration date";
$GLOBALS['strActivationDate']		= "Activation date";

$GLOBALS['strMailClientDeactivated'] 	= "Your banners have been disabled because";
$GLOBALS['strMailNothingLeft'] 			= "If you would like to continue advertising on our website, please feel free to contact us. We'd be glad to hear from you.";
$GLOBALS['strClientDeactivated']	= "This client is currently not active because";
$GLOBALS['strBeforeActivate']		= "the activation date has not yet been reached";
$GLOBALS['strAfterExpire']			= "the expiration date has been reached";
$GLOBALS['strNoMoreClicks']			= "the amount of AdClicks purchased are used";
$GLOBALS['strNoMoreViews']			= "the amount of AdViews purchased are used";
?>
