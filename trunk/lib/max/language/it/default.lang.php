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
$Id$
*/

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']			= "ltr";
$GLOBALS['phpAds_TextAlignRight']			= "right";
$GLOBALS['phpAds_TextAlignLeft']			= "left";

$GLOBALS['phpAds_DecimalPoint']				= ',';
$GLOBALS['phpAds_ThousandsSeperator']		= '.';


// Date & time configuration
$GLOBALS['date_format']						= "%d-%m-%Y";
$GLOBALS['time_format']						= "%H:%M:%S";
$GLOBALS['minute_format']					= "%H:%M";
$GLOBALS['month_format']					= "%m-%Y";
$GLOBALS['day_format']						= "%d-%m";
$GLOBALS['week_format']						= "%W-%Y";
$GLOBALS['weekiso_format']					= "%V-%G";



/*-------------------------------------------------------*/
/* Translations                                          */
/*-------------------------------------------------------*/

$GLOBALS['strHome']							= "Home";
$GLOBALS['strHelp']							= "Aiuto";
$GLOBALS['strNavigation']					= "Navigazione";
$GLOBALS['strShortcuts']					= "Scorciatoie";
$GLOBALS['strAdminstration']				= "Inventario";
$GLOBALS['strMaintenance']					= "Manutenzione";
$GLOBALS['strProbability']					= "Probabilità";
$GLOBALS['strInvocationcode']				= "Codice Invocazione";
$GLOBALS['strBasicInformation']				= "Informazioni di base";
$GLOBALS['strContractInformation']			= "Informazioni sul contratto";
$GLOBALS['strLoginInformation']				= "Informazioni sul login";
$GLOBALS['strOverview']						= "Descrizione";
$GLOBALS['strSearch']						= "<u>C</u>erca";
$GLOBALS['strHistory']						= "Storico";
$GLOBALS['strPreferences']					= "Preferenze";
$GLOBALS['strDetails']						= "Dettagli";
$GLOBALS['strCompact']						= "Compatte";
$GLOBALS['strVerbose']						= "Complete";
$GLOBALS['strUser']							= "Utente";
$GLOBALS['strEdit']							= "Modifica";
$GLOBALS['strCreate']						= "Crea";
$GLOBALS['strDuplicate']					= "Duplica";
$GLOBALS['strMoveTo']						= "Muovi verso";
$GLOBALS['strDelete']						= "Cancella";
$GLOBALS['strActivate']						= "Attiva";
$GLOBALS['strDeActivate']					= "Disattiva";
$GLOBALS['strConvert']						= "Converti";
$GLOBALS['strRefresh']						= "Aggiorna";
$GLOBALS['strSaveChanges']					= "Salva modifiche";
$GLOBALS['strUp']							= "Su";
$GLOBALS['strDown']							= "Giù";
$GLOBALS['strSave']							= "Salva";
$GLOBALS['strCancel']						= "Cancella";
$GLOBALS['strPrevious']						= "Precedente";
$GLOBALS['strPrevious_Key']					= "<u>P</u>recedente";
$GLOBALS['strNext']							= "Successivo";
$GLOBALS['strNext_Key']						= "<u>S</u>uccessivo";
$GLOBALS['strYes']							= "Sì";
$GLOBALS['strNo']							= "No";
$GLOBALS['strNone']							= "Nessuno";
$GLOBALS['strCustom']						= "Personalizzato";
$GLOBALS['strDefault']						= "Default";
$GLOBALS['strOther']						= "Altro";
$GLOBALS['strUnknown']						= "Sconosciuto";
$GLOBALS['strUnlimited']					= "Illimitato";
$GLOBALS['strUntitled']						= "Senza nome";
$GLOBALS['strAll']							= "tutto";
$GLOBALS['strAvg']							= "Med.";
$GLOBALS['strAverage']						= "Media";
$GLOBALS['strOverall']						= "Totale";
$GLOBALS['strTotal']						= "Totale";
$GLOBALS['strActive']						= "attiva";
$GLOBALS['strFrom']							= "Da";
$GLOBALS['strTo']							= "a";
$GLOBALS['strLinkedTo']						= "collegato a";
$GLOBALS['strDaysLeft']						= "Giorni mancanti";
$GLOBALS['strCheckAllNone']					= "Seleziona tutti / nessuno";
$GLOBALS['strKiloByte']						= "KB";
$GLOBALS['strExpandAll']					= "<u>E</u>spandi tutti";
$GLOBALS['strCollapseAll']					= "<u>C</u>hiudi tutti";
$GLOBALS['strShowAll']						= "Mostra tutto";
$GLOBALS['strNoAdminInterface']				= "L'interfaccia di amministrazione Ã¨ stata disattivata per manutenzione. La consegna dei banner continua a funzionare come previsto.";
$GLOBALS['strFilterBySource']				= "filtra per sorgente";
$GLOBALS['strFieldContainsErrors']			= "I seguenti campi contengono errori:";
$GLOBALS['strFieldFixBeforeContinue1']		= "Prima di continuare è necessario";
$GLOBALS['strFieldFixBeforeContinue2']		= "correggere questi errori.";
$GLOBALS['strDelimiter']					= "Delimitatore";
$GLOBALS['strMiscellaneous']				= "Varie";
$GLOBALS['strCollectedAll']					= "Tutte le statistiche raccolte";
$GLOBALS['strCollectedToday']				= "Statistiche di oggi";
$GLOBALS['strCollected7Days']				= "Statistiche degli ultimi 7 giorni";
$GLOBALS['strCollectedMonth']				= "Statistiche del mese corrente";



// Properties
$GLOBALS['strName']							= "Nome";
$GLOBALS['strSize']							= "Dimensioni";
$GLOBALS['strWidth']						= "Larghezza";
$GLOBALS['strHeight']						= "Altezza";
$GLOBALS['strURL2']							= "URL";
$GLOBALS['strTarget']						= "Frame destinazione";
$GLOBALS['strLanguage']						= "Lingua";
$GLOBALS['strDescription']					= "Descrizione";
$GLOBALS['strID']							= "ID";


// Login & Permissions
$GLOBALS['strAuthentification']				= "Autenticazione";
$GLOBALS['strWelcomeTo']					= "Benvenuto su";
$GLOBALS['strEnterUsername']				= "Inserisci il tuo nome utente e la tua password per accedere";
$GLOBALS['strEnterBoth']					= "È necessario necessario inserire sia nome utente che password";
$GLOBALS['strEnableCookies']				= "È necessario abilitare i cookie per poter utilizzare ".$phpAds_productname;
$GLOBALS['strLogin']						= "Login";
$GLOBALS['strLogout']						= "Esci";
$GLOBALS['strUsername']						= "Nome utente";
$GLOBALS['strPassword']						= "Password";
$GLOBALS['strAccessDenied']					= "Accesso negato";
$GLOBALS['strPasswordWrong']				= "Password errata";
$GLOBALS['strNotAdmin']						= "Non hai abbastanza privilegi";
$GLOBALS['strDuplicateClientName']			= "Il nome utente inserito è già esistente, utilizzare un altro nome.";
$GLOBALS['strInvalidPassword']				= "La nuova password non è valida, utilizzare un'altra password.";
$GLOBALS['strNotSamePasswords']				= "Le due password inserite sono diverse";
$GLOBALS['strRepeatPassword']				= "Ripeti password";
$GLOBALS['strOldPassword']					= "Vecchia password";
$GLOBALS['strNewPassword']					= "Nuova password";


// General advertising
$GLOBALS['strImpressions']						= "Visualizzazioni";
$GLOBALS['strClicks']						= "Click";
$GLOBALS['strCTRShort']						= "CTR";
$GLOBALS['strCTR']							= "Proporzione click-through";
$GLOBALS['strTotalViews']					= "Visualizzazioni totali";
$GLOBALS['strTotalClicks']					= "Click totali";
$GLOBALS['strViewCredits']					= "Crediti visualizzazioni";
$GLOBALS['strClickCredits']					= "Crediti click";


// Time and date related
$GLOBALS['strDate']							= "Data";
$GLOBALS['strToday']						= "Oggi";
$GLOBALS['strDay']							= "Giorno";
$GLOBALS['strDays']							= "Giorni";
$GLOBALS['strLast7Days']					= "Ultimi 7 giorni";
$GLOBALS['strWeek']							= "Settimana";
$GLOBALS['strWeeks']						= "Settimane";
$GLOBALS['strMonths']						= "Mesi";
$GLOBALS['strThisMonth']					= "Questo Mese";
$GLOBALS['strMonth']						= array("Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre");
$GLOBALS['strDayShortCuts']					= array("Do","Lu","Ma","Me","Gi","Ve","Sa");
$GLOBALS['strHour']							= "Ora";
$GLOBALS['strSeconds']						= "secondi";
$GLOBALS['strMinutes']						= "minuti";
$GLOBALS['strHours']						= "ore";
$GLOBALS['strTimes']						= "volte";


// Advertiser
$GLOBALS['strClient']						= "Inserzionista";
$GLOBALS['strClients']						= "Inserzionisti";
$GLOBALS['strClientsAndCampaigns']			= "Inserzionisti e Campagne";
$GLOBALS['strAddClient']					= "Aggiungi un nuovo inserzionista";
$GLOBALS['strAddClient_Key']				= "Aggiungi un <u>n</u>uovo inserzionista";
$GLOBALS['strTotalClients']					= "Inserzionisti totali";
$GLOBALS['strClientProperties']				= "Impostazioni inserzionista";
$GLOBALS['strClientHistory']				= "Storico inserzionista";
$GLOBALS['strNoClients']					= "Attualmente non ci sono inserzionisti definiti";
$GLOBALS['strConfirmDeleteClient']			= "Vuoi veramente elminare questo inserzionista?";
$GLOBALS['strConfirmResetClientStats']		= "Vuoi veramente elminare tutte le statistiche esistenti per qusto inserzionista?";
$GLOBALS['strHideInactiveAdvertisers']		= "Nascondi inserzionisti inattivi";
$GLOBALS['strInactiveAdvertisersHidden']	= "inserzionisti inattivi nascosti";


// Advertisers properties
$GLOBALS['strContact']						= "Contatto";
$GLOBALS['strEMail']						= "E-mail";
$GLOBALS['strSendAdvertisingReport']		= "Spedisci un rapporto via e-mail";
$GLOBALS['strNoDaysBetweenReports']			= "numero di giorni tra rapporti";
$GLOBALS['strSendDeactivationWarning']		= "Spedisci un avvertimento quando la campagnia viene disattivata";
$GLOBALS['strAllowClientModifyInfo']		= "Permetti a questo utente di modificare le proprie impostazioni";
$GLOBALS['strAllowClientModifyBanner']		= "Permetti a questo utente di modificare i propri banner";
$GLOBALS['strAllowClientAddBanner']			= "Permetti a questo utente di aggiungere i propri banner";
$GLOBALS['strAllowClientDisableBanner']		= "Permetti a questo utente di disattivare i propri banner";
$GLOBALS['strAllowClientActivateBanner']	= "Permetti a questo utente di attivare i propri banner";


// Campaign
$GLOBALS['strCampaign']						= "Campagna";
$GLOBALS['strCampaigns']					= "Campagne";
$GLOBALS['strTotalCampaigns']				= "Campagne totali";
$GLOBALS['strActiveCampaigns']				= "Campagne attive";
$GLOBALS['strAddCampaign']					= "Aggiungi nuova campagna";
$GLOBALS['strAddCampaign_Key']				= "Aggiungi <u>n</u>uova campagna";
$GLOBALS['strCreateNewCampaign']			= "Crea nuova campagna";
$GLOBALS['strModifyCampaign']				= "Modifica campagna";
$GLOBALS['strMoveToNewCampaign']			= "Muovi verso una nuova campagna";
$GLOBALS['strBannersWithoutCampaign']		= "Banner senza una campagna";
$GLOBALS['strDeleteAllCampaigns']			= "Elimina tutte le campagne";
$GLOBALS['strCampaignStats']				= "statistiche campagna";
$GLOBALS['strCampaignProperties']			= "Impostazioni campagna";
$GLOBALS['strCampaignOverview']				= "Descrizione campagne";
$GLOBALS['strCampaignHistory']				= "Storico campagna";
$GLOBALS['strNoCampaigns']					= "Non ci sono attualmente campagne definite";
$GLOBALS['strConfirmDeleteAllCampaigns']	= "Desideri realmente cancellare tutte le campagne possedute da questo inserzionista?";
$GLOBALS['strConfirmDeleteCampaign']		= "Desideri realmente cancellare questa campagna?";
$GLOBALS['strConfirmResetCampaignStats']	= "Desideri realmente cancellare tutte le statistiche di questa campagna?";
$GLOBALS['strHideInactiveCampaigns']		= "Nascondi campagne inattive";
$GLOBALS['strInactiveCampaignsHidden']		= "campagne inattive nascoste";


// Campaign properties
$GLOBALS['strDontExpire']					= "Non far scadere questa campagna in una data specifica";
$GLOBALS['strActivateNow']					= "Attiva questa campagna immediatamente";
$GLOBALS['strLow']							= "Bassa";
$GLOBALS['strHigh']							= "Alta";
$GLOBALS['strExpirationDate']				= "Data scadenza";
$GLOBALS['strActivationDate']				= "Data attivazione";
$GLOBALS['strImpressionsPurchased']				= "Visualizzazioni rimaste";
$GLOBALS['strClicksPurchased']				= "Click rimaste";
$GLOBALS['strCampaignWeight']				= "Peso della campagna";
$GLOBALS['strHighPriority']					= "Visualizza i banner in questa campagna con Priorità Alta.<br /> Usando questa opzione ".$phpAds_productname." prova a distribuire il numero di Visualizzazioni Scelto durante il corso della giornata.";
$GLOBALS['strLowPriority']					= "Visualizza i banner in questa campagna con Priorità Bassa.<br /> Usando questa opzione i banner sfrutteranno le visualizzazioni lasciate a disposizione dalla campagna con Priorità Alta.";
$GLOBALS['strTargetLimitAdviews']			= "Limita il numero di visualizzazioni a";
$GLOBALS['strTargetPerDay']					= "al giorno.";
$GLOBALS['strPriorityAutoTargeting']		= "Distribisci le visualizzazioni durante il corso delle rimanenti giornate. Il limite giornaliero di visualizzazioni verrà calcolato automaticamente.";
$GLOBALS['strCampaignWarningNoWeight']		= "Questa campagna è stata impostata come campagna a bassa priorità, \nma il suo peso è impostato a zero o non è stato specificato. \nQuesto comporterà la disattivazione della campagna: i suoi banner \nnon verranno visualizzati finché il peso non sarà impostato \nad un numero valido. \n\nSei sicuro di voler procedere?";
$GLOBALS['strCampaignWarningNoTarget']		= "Questa campagna è stata impostata come campagna ad alta priorità, \nma il numero di Visualizzazioni giornaliere non è stato specificato. \nQuesto comporterà la disattivazione della campagna: i suoi banner \nnon verranno visualizzati finché non sarà impostato \nun numero valido di Visualizzazioni giornaliere. \n\nSei sicuro di voler procedere?";



// Banners (General)
$GLOBALS['strBanner']						= "Banner";
$GLOBALS['strBanners']						= "Banner";
$GLOBALS['strAddBanner']					= "Aggiungi nuovo banner";
$GLOBALS['strAddBanner_Key']				= "Aggiungi <u>n</u>uovo banner";
$GLOBALS['strModifyBanner']					= "Modifica banner";
$GLOBALS['strActiveBanners']				= "Banner attivi";
$GLOBALS['strTotalBanners']					= "Banner totali";
$GLOBALS['strShowBanner']					= "Mostra banner";
$GLOBALS['strShowAllBanners']				= "Mostra tutti i banner";
$GLOBALS['strShowBannersNoAdClicks']		= "Mostra i banner senza click";
$GLOBALS['strShowBannersNoAdViews']			= "Mostra i banner senza visualizzazioni";
$GLOBALS['strDeleteAllBanners']				= "Cancella tutti i banner";
$GLOBALS['strActivateAllBanners']			= "Attiva tutti i banner";
$GLOBALS['strDeactivateAllBanners']			= "Disattiva tutti i banner";
$GLOBALS['strBannerOverview']				= "Descrizione banner";
$GLOBALS['strBannerProperties']				= "Impostazioni banner";
$GLOBALS['strBannerHistory']				= "Storico banner";
$GLOBALS['strBannerNoStats']				= "Non ci sono statistiche disponibili per questo banner";
$GLOBALS['strNoBanners']					= "Non è ancora stato creato nessun banner";
$GLOBALS['strConfirmDeleteBanner']			= "Vuoi veramente cancellare questo banner?";
$GLOBALS['strConfirmDeleteAllBanners']		= "Vuoi veramente cancellare tutti i banner appartenenti a questa campagna?";
$GLOBALS['strConfirmResetBannerStats']		= "Vuoi veramente cancellare tutte le statistiche di questo banner?";
$GLOBALS['strShowParentCampaigns']			= "Mostra campagne";
$GLOBALS['strHideParentCampaigns']			= "Nascondi campagne";
$GLOBALS['strHideInactiveBanners']			= "Nascondi banner inattivi";
$GLOBALS['strInactiveBannersHidden']		= "banner inattivi nascosti";
$GLOBALS['strAppendOthers']					= "Accoda altri";
$GLOBALS['strAppendTextAdNotPossible']		= "Non è possibile accodare altri banner ai banner testuali.";



// Banner (Properties)
$GLOBALS['strChooseBanner']					= "Per favore seleziona il tipo di banner";
$GLOBALS['strMySQLBanner']					= "Banner locale (SQL)";
$GLOBALS['strWebBanner']					= "Banner locale (su questo Webserver)";
$GLOBALS['strURLBanner']					= "Banner esterno";
$GLOBALS['strHTMLBanner']					= "Banner HTML";
$GLOBALS['strTextBanner'] 					= "Banner testuale";
$GLOBALS['strAutoChangeHTML']				= "Modifica HTML per attivare la registrazione dei Click";
$GLOBALS['strUploadOrKeep']					= "Preferisci mantenere la<br />immagine esistente, o preferisci<br />caricarne un altra?";
$GLOBALS['strNewBannerFile']				= "Scegli <br />la immagine che vuoi da <br />usare in questo banner<br /><br />";
$GLOBALS['strNewBannerURL']					= "URL immagine (incl. http://)";
$GLOBALS['strURL']							= "URL destinazione (incl. http://)";
$GLOBALS['strHTML']							= "HTML";
$GLOBALS['strTextBelow']					= "Testo sotto immagine";
$GLOBALS['strKeyword']						= "Parole chiave";
$GLOBALS['strWeight']						= "Importanza";
$GLOBALS['strAlt']							= "Testro alternativo";
$GLOBALS['strStatusText']					= "Testo di status";
$GLOBALS['strBannerWeight']					= "Peso del banner";


// Banner (swf)
$GLOBALS['strCheckSWF']						= "Controlla per links codificati dentro il file flash";
$GLOBALS['strConvertSWFLinks']				= "Converti links Flash";
$GLOBALS['strHardcodedLinks']				= "Link codificati dentro il file";
$GLOBALS['strConvertSWF']					= "<br />Il file Flash appena caricato contiene urls codificati. ".$phpAds_productname." non risulta in grado ditracciare il numero di click per questo banner fino a quando non convertirai questi urls codificati. Di seguito troverai una lista di tutti gli urls presenti nel file flash. Se vuoi convertire questi urls, semplicemente clicca <b>Converti</b>, altrimenti clicca <b>Cancella</b>.<br /><br /> Nota Bene: cliccando <b>Converti</b> il file flash che hai appena caricato viene modificato fisicamente. <br />Tieni da parte una copia di backup del file originale. Indipendentemente alla versione di flash utilizzata, il file risultante necessita del plug-in Flash 4 (o superiore).<br /><br />";
$GLOBALS['strCompressSWF']					= "Comprimi il file SWF per uno scaricamento più veloce (plug-in Flash 6 necessario)";
$GLOBALS['strOverwriteSource']				= "Sovrascrivi parametro sorgente";


// Banner (network)
$GLOBALS['strBannerNetwork']				= "Template HTML";
$GLOBALS['strChooseNetwork']				= "Scegli il modello da utilizzare";
$GLOBALS['strMoreInformation']				= "Maggiori informazioni...";
$GLOBALS['strRichMedia']					= "Richmedia";
$GLOBALS['strTrackAdClicks']				= "Traccia i Click";


// Display limitations
$GLOBALS['strModifyBannerAcl']				= "Opzioni consegna";
$GLOBALS['strACL']							= "Consegna";
$GLOBALS['strACLAdd']						= "Aggiungi nuova limitazione";
$GLOBALS['strACLAdd_Key']					= "Aggiungi <u>nuova</u> limitazione";
$GLOBALS['strNoLimitations']				= "Nessuna limitazione";
$GLOBALS['strApplyLimitationsTo']			= "Applica limitazioni a";
$GLOBALS['strRemoveAllLimitations']			= "Rimuovi tutte le limitazioni";
$GLOBALS['strEqualTo']						= "è uguale a";
$GLOBALS['strDifferentFrom']				= "è differente da";
$GLOBALS['strLaterThan']					= "è successiva a";
$GLOBALS['strLaterThanOrEqual']				= "è successiva o uguale a";
$GLOBALS['strEarlierThan']					= "è precedente a";
$GLOBALS['strEarlierThanOrEqual']			= "è precedente o uguale a";
$GLOBALS['strContains']						= "contiene";
$GLOBALS['strNotContains']					= "non contiene";
$GLOBALS['strAND']							= "AND";						// logical operator
$GLOBALS['strOR']							= "OR";							// logical operator
$GLOBALS['strOnlyDisplayWhen']				= "Mostra questo banner solo quando:";
$GLOBALS['strWeekDay']						= "Giorno della settimana";
$GLOBALS['strTime']							= "Ora";
$GLOBALS['strUserAgent']					= "Useragent";
$GLOBALS['strDomain']						= "Dominio";
$GLOBALS['strClientIP']						= "IP Client";
$GLOBALS['strSource']						= "Sorgente";
$GLOBALS['strBrowser'] 						= "Browser";
$GLOBALS['strOS'] 							= "Sistema operativo";
$GLOBALS['strCountry'] 						= "Stato";
$GLOBALS['strContinent'] 					= "Continente";
$GLOBALS['strUSState']						= "Stato (USA)";
$GLOBALS['strReferer'] 						= "Pagina di provenienza";
$GLOBALS['strDeliveryLimitations']			= "Limitazioni consegna";
$GLOBALS['strDeliveryCapping']				= "Limitazioni numero consegne";
$GLOBALS['strTimeCapping']					= "Una volta consegnato il banner, non mostrarlo allo stesso utente per:";
$GLOBALS['strImpressionCapping']			= "Non mostrare il banner allo stesso utente più di:";


// Publisher
$GLOBALS['strAffiliate']					= "Editore";
$GLOBALS['strAffiliates']					= "Editori";
$GLOBALS['strAffiliatesAndZones']			= "Editori e Zone";
$GLOBALS['strAddNewAffiliate']				= "Aggiungi un nuovo editore";
$GLOBALS['strAddNewAffiliate_Key']			= "Aggiungi un <u>n</u>uovo editore";
$GLOBALS['strAddAffiliate']					= "Crea editore";
$GLOBALS['strAffiliateProperties']			= "Impostazioni editore";
$GLOBALS['strAffiliateOverview']			= "Descrizione Editore";
$GLOBALS['strAffiliateHistory']				= "Storico editore";
$GLOBALS['strZonesWithoutAffiliate']		= "Zone senza editore";
$GLOBALS['strMoveToNewAffiliate']			= "Muovi verso un nuovo editore";
$GLOBALS['strNoAffiliates']					= "Non è ancora stato creato nessun editore";
$GLOBALS['strConfirmDeleteAffiliate']		= "Desideri realmente cancellare questo editore?";
$GLOBALS['strMakePublisherPublic']			= "Rendi pubblicamente disponibili le zone di questo editore";


// Publisher (properties)
$GLOBALS['strWebsite']						= "Sito web";
$GLOBALS['strAllowAffiliateModifyInfo']		= "Permetti a questo utente di modificare le proprie impostazioni";
$GLOBALS['strAllowAffiliateModifyZones']	= "Permetti a questo utente di modificare le proprie zone";
$GLOBALS['strAllowAffiliateLinkBanners']	= "Permetti a questo utente di collegare i banner alle proprie zone";
$GLOBALS['strAllowAffiliateAddZone']		= "Permetti a questo utente di definire nuove zone";
$GLOBALS['strAllowAffiliateDeleteZone']		= "Permetti a questo utente di cancellare le zone esistenti";


// Zone
$GLOBALS['strZone']							= "Zona";
$GLOBALS['strZones']						= "Zone";
$GLOBALS['strAddNewZone']					= "Aggiungi una nuova zona";
$GLOBALS['strAddNewZone_Key']				= "Aggiungi una <u>n</u>uova zona";
$GLOBALS['strAddZone']						= "Crea zona";
$GLOBALS['strModifyZone']					= "Modifica zona";
$GLOBALS['strLinkedZones']					= "Zone collegate";
$GLOBALS['strZoneOverview']					= "Descrizione zone";
$GLOBALS['strZoneProperties']				= "Impostazioni zona";
$GLOBALS['strZoneHistory']					= "Storico zona";
$GLOBALS['strNoZones']						= "Non ci sono correntemente zone definite";
$GLOBALS['strConfirmDeleteZone']			= "Desideri realmente cancellare questa zona?";
$GLOBALS['strZoneType']						= "Tipo di zona";
$GLOBALS['strBannerButtonRectangle']		= "Banner, Pulsante o Rettangolo";
$GLOBALS['strInterstitial']					= "Interstiziale o DHTML floating";
$GLOBALS['strPopup']						= "Popup";
$GLOBALS['strTextAdZone']					= "Banner testuale";
$GLOBALS['strShowMatchingBanners']			= "Mostra banner corrispondenti";
$GLOBALS['strHideMatchingBanners']			= "Nascondi banner corrispondenti";


// Advanced zone settings
$GLOBALS['strAdvanced']						= "Avanzate";
$GLOBALS['strChains']						= "Catene";
$GLOBALS['strChainSettings']				= "Impostazioni della catena";
$GLOBALS['strZoneNoDelivery']				= "Se nessun banner di questa zona <br />può essere fornito, prova a...";
$GLOBALS['strZoneStopDelivery']				= "Arrestare la fornitura e non visualizzare alcun banner";
$GLOBALS['strZoneOtherZone']				= "Mostrare la zona selezionata";
$GLOBALS['strZoneUseKeywords']				= "Scegliere un banner usando la seguente stringa di query";
$GLOBALS['strZoneAppend']					= "Aggiungi sempre il seguente codice HTML ai banner di questa zona";
$GLOBALS['strAppendSettings']				= "Impostazioni prefisso e suffisso";
$GLOBALS['strZonePrependHTML']				= "Codice HTML da utilizzare come prefisso per i banner testuali visualizzati in questa zona";
$GLOBALS['strZoneAppendHTML']				= "Codice HTML da utilizzare come suffisso per i banner testuali visualizzati in questa zona";
$GLOBALS['strZoneAppendType']				= "Tipo di suffisso";
$GLOBALS['strZoneAppendHTMLCode']			= "Codice HTML";
$GLOBALS['strZoneAppendZoneSelection']		= "Popup o interstiziale";
$GLOBALS['strZoneAppendSelectZone']			= "Aggiungi sempre il seguente popup o interstiziale ai banner di questa zona";


// Zone probability
$GLOBALS['strZoneProbListChain']			= "Tutti i banner collegati alla zona selezionata sono al momento disattivati. <br />Questa è la catena di zone che verrà seguita:";
$GLOBALS['strZoneProbNullPri']				= "Tutti i banner collegati alla zona selezionata sono al momento disattivati";
$GLOBALS['strZoneProbListChainLoop']		= "Si è verificato un ciclo infinito seguendo la catena delle zone. La fornitura della zona è sospesa";


// Linked banners/campaigns
$GLOBALS['strSelectZoneType']				= "Scegli la tipologia di collegamento con i banner";
$GLOBALS['strBannerSelection']				= "Selezione banner";
$GLOBALS['strCampaignSelection']			= "Selezione campagna";
$GLOBALS['strInteractive']					= "Interattivo";
$GLOBALS['strRawQueryString']				= "Keyword";
$GLOBALS['strIncludedBanners']				= "Banner collegati";
$GLOBALS['strLinkedBannersOverview']		= "Descrizione banner collegati";
$GLOBALS['strLinkedBannerHistory']			= "Storico banner collegati";
$GLOBALS['strNoZonesToLink']				= "Non ci sono zone disponibili a cui questo banner possa essere collegato";
$GLOBALS['strNoBannersToLink']				= "Non ci sono banner disponibili che possano essere collegati a questa zona";
$GLOBALS['strNoLinkedBanners']				= "Non ci sono banner disponibili che siano collegati a questa zona";
$GLOBALS['strMatchingBanners']				= "{count} banner corrispondenti";
$GLOBALS['strNoCampaignsToLink']			= "Non ci sono attualmente campagne disponibili che possano essere collegati a questa zona";
$GLOBALS['strNoZonesToLinkToCampaign']		= "Non ci sono zone disponibili a cui questa campagna possa essere collegata";
$GLOBALS['strSelectBannerToLink']			= "Seleziona il banner che vorresti collegare a questa zona:";
$GLOBALS['strSelectCampaignToLink']			= "Seleziona la campagna che vorresti collegare a questa zona:";


// Statistics
$GLOBALS['strStats']						= "Statistiche";
$GLOBALS['strNoStats']						= "Non ci sono statistiche disponibili";
$GLOBALS['strConfirmResetStats']			= "Vuoi veramente cancellare tutte le statistiche?";
$GLOBALS['strGlobalHistory']				= "Storico globale";
$GLOBALS['strDailyHistory']					= "Storico giornaliero";
$GLOBALS['strDailyStats']					= "Statistiche giornaliere";
$GLOBALS['strWeeklyHistory']				= "Storico settimanale";
$GLOBALS['strMonthlyHistory']				= "Storico mensile";
$GLOBALS['strCreditStats']					= "Statistiche credito";
$GLOBALS['strDetailStats']					= "Statistiche dettagliate";
$GLOBALS['strTotalThisPeriod']				= "Totale in questo periodo";
$GLOBALS['strAverageThisPeriod']			= "Media in questo periodo";
$GLOBALS['strDistribution']					= "Distribuzione";
$GLOBALS['strResetStats']					= "Azzera statistiche";
$GLOBALS['strSourceStats']					= "Statistiche sorgente";
$GLOBALS['strSelectSource']					= "Seleziona la sorgente da visualizzare:";
$GLOBALS['strSizeDistribution']				= "Distribuzione per dimensioni";
$GLOBALS['strCountryDistribution']			= "Distribuzione per stato";
$GLOBALS['strEffectivity']					= "Efficacia";
$GLOBALS['strTargetStats']					= "Statistiche target di visualizzazioni";
$GLOBALS['strCampaignTarget']				= "Target";
$GLOBALS['strTargetRatio']					= "Rapporto";
$GLOBALS['strTargetModifiedDay']			= "I target sono stati modificati durante il giorno, il targeting può essere impreciso";
$GLOBALS['strTargetModifiedWeek']			= "I target sono stati modificati durante la settimana, il targeting può essere impreciso";
$GLOBALS['strTargetModifiedMonth']			= "I target sono stati modificati durante il mese, il targeting può essere impreciso";
$GLOBALS['strNoTargetStats']				= "Non ci sono statistiche sul targeting disponibili";


// Hosts
$GLOBALS['strHosts']						= "Host";
$GLOBALS['strTopHosts']						= "Host con più richieste";
$GLOBALS['strTopCountries'] 				= "Stati con più richieste";
$GLOBALS['strRecentHosts'] 					= "Host più recenti";


// Expiration
$GLOBALS['strExpired']						= "Scaduto";
$GLOBALS['strExpiration']					= "Scadenza";
$GLOBALS['strNoExpiration']					= "Data scadenza non impostata";
$GLOBALS['strEstimated']					= "Scadenza prevista";


// Reports
$GLOBALS['strReports']						= "Rapporti";
$GLOBALS['strSelectReport']					= "Seleziona il rapporto che vuoi generare";


// Userlog
$GLOBALS['strUserLog']						= "Registro eventi";
$GLOBALS['strUserLogDetails']				= "Dettagli registro eventi";
$GLOBALS['strDeleteLog']					= "Cancella registro";
$GLOBALS['strAction']						= "Azione";
$GLOBALS['strNoActionsLogged']				= "Nessuna azione registrata";


// Code generation
$GLOBALS['strGenerateBannercode']			= "Selezione diretta";
$GLOBALS['strChooseInvocationType']			= "Seleziona il tipo di invocazione banner";
$GLOBALS['strGenerate']						= "Genera";
$GLOBALS['strParameters']					= "Parametri";
$GLOBALS['strFrameSize']					= "Grandezza frame";
$GLOBALS['strBannercode']					= "Codice banner";
$GLOBALS['strOptional']						= "opzionale";


// Errors
$GLOBALS['strMySQLError']					= "Errore SQL:";
$GLOBALS['strLogErrorClients']				= "[phpAds] Errore intercorso durante il tentativo di estrarre gli inserzionisti dal database.";
$GLOBALS['strLogErrorBanners']				= "[phpAds] Errore intercorso durante il tentativo di estrarre i banner dal database.";
$GLOBALS['strLogErrorViews']				= "[phpAds] Errore intercorso durante il tentativo di estrarre le visualizzazioni dal database.";
$GLOBALS['strLogErrorClicks']				= "[phpAds] Errore intercorso durante il tentativo di estrarre i click dal database.";
$GLOBALS['strErrorViews']					= "Devi inserire il nomero di visualizzazioni oppure selezionare il checkbox illimitati !";
$GLOBALS['strErrorNegViews']				= "Le visualizzazioni negative non sono permesse";
$GLOBALS['strErrorClicks']					= "Devi inserire il numero di click oppure selezionare il checkbox illimitati !";
$GLOBALS['strErrorNegClicks']				= "I click negativi non sono permessi";
$GLOBALS['strNoMatchesFound']				= "Nessuna corrispondenza trovata";
$GLOBALS['strErrorOccurred']				= "Segnalazione Errore";
$GLOBALS['strErrorUploadSecurity']			= "È stato riscontrato un possibile problema di sicurezza nell'upload. Upload bloccato!";
$GLOBALS['strErrorUploadBasedir']			= "Impossibile accedere al file uploadato, probabilmente ciò è dovuto alle impostazioni di sicurezza safe_mode e/o open_basedir del PHP";
$GLOBALS['strErrorUploadUnknown']			= "Impossibile accedere al file uploadato per un motivo sconosciuto. Controllare la propria configurazione del PHP";
$GLOBALS['strErrorStoreLocal']				= "Impossibile salvare il banner nella directory locale. La causa probabile è una configurazione errata del percorso della directory locale";
$GLOBALS['strErrorStoreFTP']				= "Impossibile effetuare l'upload del banner via FTP. Il server potrebbe non essere raggiungibile o i parametri di connessione sono errati";
$GLOBALS['strErrorDBPlain']					= "Si è verificato un errore nell'accesso al database";
$GLOBALS['strErrorDBSerious']				= "È stato riscontrato un grave problema con il database";
$GLOBALS['strErrorDBNoDataPlain']			= "A causa di un problema con il database ".$phpAds_productname." non può leggere o memorizzare i dati. ";
$GLOBALS['strErrorDBNoDataSerious']			= "A causa di un grave problema con il database, ".$phpAds_productname." non può leggere i dati";
$GLOBALS['strErrorDBCorrupt']				= "Probabilemente la tabella è corrotta ed è necessario ripararla. Per avere più informazioni su come riparare le tabelle corrotte, leggere il capitolo <i>Troubleshooting</i> della <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact']				= "Contatta l'amministratore di questo server ed informalo del problema.";
$GLOBALS['strErrorDBSubmitBug']				= "Se questo problema è riproducibile, potrebbe essere causato da un bug di ".$phpAds_productname.". Per favore sottoponi le informazioni sottostanti ai creatori di ".$phpAds_productname.". Tenta inoltre di descrivere le azioni che hanno portato a questo errore il più chiaramente possible.";
$GLOBALS['strMaintenanceNotActive']			= "Lo script di manutenzione non è stato lanciato nelle ultime 24 ore. \\nAffinché ".$phpAds_productname." funzioni correttamente esso deve essere lanciato \\nogni ora. \\n\\nLa ggere la Administrator guide per maggiori informazioni \\nsu come configurare lo script di manutenzione.";


// E-mail
$GLOBALS['strMailSubject']					= "Rapporto inserzionista";
$GLOBALS['strAdReportSent']					= "Rapporto inserzionista spedito";
$GLOBALS['strMailSubjectDeleted']			= "Banner disattivati";
$GLOBALS['strMailHeader']					= "Gentile {contact},\n";
$GLOBALS['strMailBannerStats']				= "Di seguito troverai le statistiche di visualizzazione banner per {clientname}:";
$GLOBALS['strMailFooter']					= "Cordiali saluti,\n   {adminfullname}";
$GLOBALS['strMailClientDeactivated']		= "I seguenti banner sono stati disattivati poiché";
$GLOBALS['strMailNothingLeft']				= "Se desideri continuare ad apparire sul nostro sito con i tuoi banner, per favore contattaci.\nSaremo felici di poter soddisfare le tue richieste.";
$GLOBALS['strClientDeactivated']			= "Questa campagna non risulta attualmente attiva poiché";
$GLOBALS['strBeforeActivate']				= "non ha raggiunto la data di attivazione";
$GLOBALS['strAfterExpire']					= "ha raggiunto la data di scadenza";
$GLOBALS['strNoMoreClicks']					= "non ci sono più Click a disposizione";
$GLOBALS['strNoMoreViews']					= "non ci sono più Visualizzazioni a disposizione";
$GLOBALS['strWeightIsNull']					= "il suo peso è impostato a zero";
$GLOBALS['strWarnClientTxt']				= "I click e le visualizzazioni rimaste per i tuoi banner sono inferiori a {limit}. \nI tuoi banner verranno disabilitati quando termineranno i click o visualizzazioni a tua dispoizione. ";
$GLOBALS['strImpressionsClicksLow']				= "Le visualizzazioni/click stanno terminando";
$GLOBALS['strNoViewLoggedInInterval']		= "Nessuna visualizzazione risulta essere stata loggata durante la creazione di questo rapporto";
$GLOBALS['strNoClickLoggedInInterval']		= "Nessun click risulta essere stata loggata durante la creazione di questo rapporto";
$GLOBALS['strMailReportPeriod']				= "Questo rapporto include le statistiche da {startdate} fino a {enddate}.";
$GLOBALS['strMailReportPeriodAll']			= "Questo rapporto include  tutte le statistiche fino a {enddate}.";
$GLOBALS['strNoStatsForCampaign']			= "Non ci sono statistiche disponibili per questa campagna.";


// Priority
$GLOBALS['strPriority']						= "Priorità";


// Settings
$GLOBALS['strSettings']						= "Impostazioni";
$GLOBALS['strGeneralSettings']				= "Impostazioni generali";
$GLOBALS['strMainSettings']					= "Impostazioni principali";
$GLOBALS['strAdminSettings']				= "Impostazioni amministratore";


// Product Updates
$GLOBALS['strProductUpdates']				= "Ricerca aggiornamenti";




/*-------------------------------------------------------*/
/* Keyboard shortcut assignments                         */
/*-------------------------------------------------------*/


// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome']			= 'h';
$GLOBALS['keyUp']			= 'u';
$GLOBALS['keyNextItem']		= '.';
$GLOBALS['keyPreviousItem']	= ',';
$GLOBALS['keyList']			= 'l';


// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch']		= 'c';
$GLOBALS['keyCollapseAll']	= 'h';
$GLOBALS['keyExpandAll']	= 'e';
$GLOBALS['keyAddNew']		= 'n';
$GLOBALS['keyNext']			= 's';
$GLOBALS['keyPrevious']		= 'p';

?>