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
$GLOBALS['strMySQLError'] = "Errore MySQL:";
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
$GLOBALS['strCTR'] = "Rapporto Click-Through";
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
$GLOBALS['strBannerAdminAcl'] = "Amministrazione ACL per";
$GLOBALS['strNoBanners'] = "Nessun banner trovato";
$GLOBALS['strBanner'] = "Banner";
$GLOBALS['strCurrentBanner'] = "Banner attuale";
$GLOBALS['strDelete'] = "Cancella";
$GLOBALS['strAddBanner'] = "Aggiungi nuovo banner";
$GLOBALS['strModifyBanner'] = "Modifica banner";
$GLOBALS['strModifyBannerAcl'] = "Modifica ACL";
$GLOBALS['strURL'] = "Link (incl. http://)";
$GLOBALS['strKeyword'] = "Parola chiave";
$GLOBALS['strWeight'] = "Peso";
$GLOBALS['strAlt'] = "Testo Alternativo";
$GLOBALS['strAccessDenied'] = "Accesso negato";
$GLOBALS['strPasswordWrong'] = "La password non &egrave; corretta";
$GLOBALS['strNotAdmin'] = "Potersti non avere abbastanza privilegi";
$GLOBALS['strClientAdded'] = "L'utente &egrave; stato aggiunto.";
$GLOBALS['strClientModified'] = "L'utente &egrave; stato modificato.";
$GLOBALS['strClientDeleted'] = "L'utente &egrave; stato cancellato.";
$GLOBALS['strBannerAdmin'] = "Amministrazione Banner";
$GLOBALS['strBannerAdded'] = "Il banner &egrave; stato aggiunto.";
$GLOBALS['strBannerModified'] = "Il banner &egrave; stato modificato.";
$GLOBALS['strBannerDeleted'] = "Il banner &egrave; stato cancellato.";
$GLOBALS['strBannerChanged'] = "Il banner &egrave; stato cambiato.";
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
$GLOBALS['strMailFooter'] = "Distinti saluti,\n   $phpAds_admin_fullname";
$GLOBALS['strLogMailSent'] = "[phpAds] Statistiche inviate correttamente.";
$GLOBALS['strLogErrorClients'] = "[phpAds] Si e' verificato un errore nel tentativo di recuperare gli utenti dal database.";
$GLOBALS['strLogErrorBanners'] = "[phpAds] Si e' verificato un errore nel tentativo di recuperare i banner dal database.";
$GLOBALS['strLogErrorViews'] = "[phpAds] Si e' verificato un errore nel tentativo di recuperare le visualizzazioni dal database.";
$GLOBALS['strLogErrorClicks'] = "[phpAds] Si e' verificato un errore nel tentativo di recuperare i clicks dal database.";
$GLOBALS['strLogErrorDisactivate'] = "[phpAds] Si e' verificato un errore nel tentativo di disattivare un banner.";
$GLOBALS['strRatio'] = "Percentuale di Click-Through";
$GLOBALS['strChooseBanner'] = "Scegliere il tipo di banner.";
$GLOBALS['strMySQLBanner'] = "Banner memorizzato nel database MySQL";
$GLOBALS['strWebBanner'] = "Banner memorizzato sul server Web";
$GLOBALS['strURLBanner'] = "Banner situato ad un altro URL";
$GLOBALS['strHTMLBanner'] = "Banner HTML";
$GLOBALS['strNewBannerFile'] = "Nuovo file del banner";
$GLOBALS['strNewBannerURL'] = "Nuovo URL del banner (incl. http://)";
$GLOBALS['strWidth'] = "Larghezza";
$GLOBALS['strHeight'] = "Altezza";
$GLOBALS['strTotalViews7Days'] = "Totale delle visualizzazioni negli ultimi 7 giorni";
$GLOBALS['strTotalClicks7Days'] = "Totale dei click negli ultimi 7 giorni";
$GLOBALS['strAvgViews7Days'] = "Media delle visualizzazioni negli ultimi 7 giorni";
$GLOBALS['strAvgClicks7Days'] = "Media dei click negli ultimi 7 giorni";
$GLOBALS['strTopTenHosts'] = "I 10 host da cui provengono le maggiori richieste";
$GLOBALS['strConfirmDeleteClient'] = "Vuoi veramente cancellare questo cliente?";
$GLOBALS['strClientIP'] = "IP Cliente";
$GLOBALS['strUserAgent'] = "Espressione regolare del Browser";
$GLOBALS['strWeekDay'] = "Giorno della settimana (0 - 6)";
$GLOBALS['strDomain'] = "Dominio (senza punto)";
$GLOBALS['strSource'] = "Source";
$GLOBALS['strTime'] = "Ora";
$GLOBALS['strAllow'] = "Consenti";
$GLOBALS['strDeny'] = "Nega";
$GLOBALS['strResetStats'] = "Azzera Statistiche";
$GLOBALS['strConfirmResetStats'] = "Vuoi veramente azzerare le statistiche per questo cliente ?";
$GLOBALS['strExpiration'] = "Termine";
$GLOBALS['strNoExpiration'] = "Nessuna data di scadenza selezionata";
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
$GLOBALS['strSave'] = "Salva";
$GLOBALS['strUp'] = "Aumenta priorit&agrave;";
$GLOBALS['strDown'] = "Diminuisci priorit&agrave;";
$GLOBALS['strSaved'] = "salvato!";
$GLOBALS['strDeleted'] = "eliminato!";  
$GLOBALS['strMovedUp'] = "- priorit&agrave; aumentata";
$GLOBALS['strMovedDown'] = "- priorit&agrave; diminuita";
$GLOBALS['strUpdated'] = "aggiornato";
$GLOBALS['strACL'] = "ACL";
$GLOBALS['strNoMoveUp'] = "Non posso muoverlo alla prima riga";
$GLOBALS['strACLAdd'] = "Inserisci ".$GLOBALS['strACL'];
$GLOBALS['strACLExist'] = "".$GLOBALS['strACL']." Esistenti :";
$GLOBALS['strLogin'] = "Login";
$GLOBALS['strPreferences'] = "Preferenze";
$GLOBALS['strAllowClientModifyInfo'] = "Permette di modificare le informazioni del cliente";
$GLOBALS['strAllowClientModifyBanner'] = "Permette agli utenti di modificare i propri banner";
$GLOBALS['strAllowClientAddBanner'] = "Permette agli utenti di inserire i propri banner";
$GLOBALS['strLanguage'] = "Lingua";
$GLOBALS['strDefault'] = "Default";
$GLOBALS['strErrorViews'] = "Devi inserire il numero di visualizzazioni oppure devi selezionare il box delle visualizzazioni illimitate!";
$GLOBALS['strErrorNegViews'] = "Un numero di visualizzazioni negative non &egrave; accettato";
$GLOBALS['strErrorClicks'] =  "Devi inserire il numero di click o devi seleziona il box dei click illimitati!";
$GLOBALS['strErrorNegClicks'] = "Click negativi non consentiti";
$GLOBALS['strErrorDays'] = "Devi selezionare il numero di giorni oppure devi selezionare il box dei giorni illimitati!";
$GLOBALS['strErrorNegDays'] = "Giorni negativi non consentiti";
$GLOBALS['strTrackerImage'] = "Controllo immagine:";

// New strings for version 2
$GLOBALS['strNavigation'] = "Navigazione";
$GLOBALS['strShortcuts'] = "Scorciatoie";
$GLOBALS['strDescription'] = "Descrizione";
$GLOBALS['strClients'] = "Clienti";
$GLOBALS['strID'] = "ID";
$GLOBALS['strOverall'] = "Totale";
$GLOBALS['strTotalBanners'] = "Totale Banner";
$GLOBALS['strToday'] = "Oggi";
$GLOBALS['strThisWeek'] = "Questa settimana";
$GLOBALS['strThisMonth'] = "Questo mese";
$GLOBALS['strBasicInformation'] = "Informazioni di Base";
$GLOBALS['strContractInformation'] = "Informazioni sul Contratto";
$GLOBALS['strLoginInformation'] = "Informazioni di Login";
$GLOBALS['strPermissions'] = "Permessi";
$GLOBALS['strGeneralSettings'] = "Salva i settaggi";
$GLOBALS['strSaveChanges'] = "Salva Modifiche";
$GLOBALS['strCompact'] = "Compatto";
$GLOBALS['strVerbose'] = "Completo";
$GLOBALS['strOrderBy'] = "ordinati per";
$GLOBALS['strShowAllBanners'] = "Visualizza tutti i banner";
$GLOBALS['strShowBannersNoAdClicks'] = "Visualizza i banner senza nessun click";
$GLOBALS['strShowBannersNoAdViews'] = "Visualizza i banner senza visualizzazioni";
$GLOBALS['strShowAllClients'] = "Visualizza tutti i clienti";
$GLOBALS['strShowClientsActive'] = "Visualizza i clienti con banner attivi";
$GLOBALS['strShowClientsInactive'] = "Visualizza i clienti con banner non attivi";
$GLOBALS['strSize'] = "Dimensione";

$GLOBALS['strMonth'] = array("Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");
$GLOBALS['strDontExpire'] = "Non disattivare il cliente alla data specifica";
$GLOBALS['strActivateNow'] = "Attiva il cliente immediatamente";
$GLOBALS['strExpirationDate'] = "Data Scadenza";
$GLOBALS['strActivationDate'] = "Data di Attivazione";

$GLOBALS['strMailClientDeactivated'] = "Il Suo banner e' stato disattivato perch&eacute; ";
$GLOBALS['strMailNothingLeft'] = "Se vuoLe continuare ad inserire annunci pubblicitari sul nostro sito puo' contattarci.";
$GLOBALS['strClientDeactivated'] = "Questo cliente non &egrave; attivo perch&eacute; ";
$GLOBALS['strBeforeActivate'] = "La data di attivazione non &egrave; stata raggiunta";
$GLOBALS['strAfterExpire'] = "La data di scadenza &egrave; stata raggiunta";
$GLOBALS['strNoMoreClicks'] = "Totale dei Click utilizzati";
$GLOBALS['strNoMoreViews'] = "Totale dei banner utilizzati";

?>

