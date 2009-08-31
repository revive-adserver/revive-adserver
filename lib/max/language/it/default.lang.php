<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$GLOBALS['strInvocationcode']				= "Codice di invocazione";
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
$GLOBALS['strDuplicate']					= "Duplicato";
$GLOBALS['strMoveTo']						= "Muovi verso";
$GLOBALS['strDelete']						= "Elimina";
$GLOBALS['strActivate']						= "Attiva";
$GLOBALS['strDeActivate']					= "Disattiva";
$GLOBALS['strConvert']						= "Converti";
$GLOBALS['strRefresh']						= "Aggiorna";
$GLOBALS['strSaveChanges']					= "Salva modifiche";
$GLOBALS['strUp']							= "Su";
$GLOBALS['strDown']							= "Giù";
$GLOBALS['strSave']							= "Salva";
$GLOBALS['strCancel']						= "Annulla";
$GLOBALS['strPrevious']						= "Precedente";
$GLOBALS['strPrevious_Key']					= "<u>P</u>recedente";
$GLOBALS['strNext']							= "Successivo";
$GLOBALS['strNext_Key']						= "<u>S</u>uccessivo";
$GLOBALS['strYes']							= "Sì";
$GLOBALS['strNo']							= "No";
$GLOBALS['strNone']							= "Nessuno";
$GLOBALS['strCustom']						= "Personalizzato";
$GLOBALS['strDefault']						= "Predefinito";
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
$GLOBALS['strNoAdminInterface']				= "L'interfaccia di amministrazione non è accessibile per manutenzione. La consegna delle tue campagne avverrà normalmente.";
$GLOBALS['strFilterBySource']				= "filtra per sorgente";
$GLOBALS['strFieldContainsErrors']			= "I seguenti campi contengono errori:";
$GLOBALS['strFieldFixBeforeContinue1']		= "Prima di continuare è necessario";
$GLOBALS['strFieldFixBeforeContinue2']		= "per correggere questi errori.";
$GLOBALS['strDelimiter']					= "Delimitatore";
$GLOBALS['strMiscellaneous']				= "Varie";
$GLOBALS['strCollectedAll']					= "Tutte le statistiche raccolte";
$GLOBALS['strCollectedToday']				= "Oggi";
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
$GLOBALS['strEnterBoth']					= "È necessario inserire sia nome utente che password";
$GLOBALS['strEnableCookies']				= "È necessario abilitare i cookie per poter utilizzare ".MAX_PRODUCT_NAME;
$GLOBALS['strLogin']						= "Nome utente";
$GLOBALS['strLogout']						= "Esci";
$GLOBALS['strUsername']						= "Nome utente";
$GLOBALS['strPassword']						= "Password";
$GLOBALS['strAccessDenied']					= "Accesso negato";
$GLOBALS['strPasswordWrong']				= "Password errata";
$GLOBALS['strNotAdmin']						= "Il tuo account non ha abbastanza privilegi per usare questa caratteristica.";
$GLOBALS['strDuplicateClientName']			= "Il nome utente fornito è già in uso, specificare un nome utente differente.";
$GLOBALS['strInvalidPassword']				= "La nuova password non è valida, utilizzare un'altra password.";
$GLOBALS['strNotSamePasswords']				= "Le due password inserite non coincidono";
$GLOBALS['strRepeatPassword']				= "Ripeti password";
$GLOBALS['strOldPassword']					= "Vecchia password";
$GLOBALS['strNewPassword']					= "Nuova password";


// General advertising
$GLOBALS['strImpressions']						= "Impressioni";
$GLOBALS['strClicks']						= "Click";
$GLOBALS['strCTRShort']						= "CTR";
$GLOBALS['strCTR']							= "CTR";
$GLOBALS['strTotalViews']					= "Visualizzazioni totali";
$GLOBALS['strTotalClicks']					= "Click totali";
$GLOBALS['strViewCredits']					= "Crediti impressioni";
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
$GLOBALS['strMonth'][0] = "Gennaio";
$GLOBALS['strMonth'][1] = "Febbraio";
$GLOBALS['strMonth'][2] = "Marzo";
$GLOBALS['strMonth'][3] = "Aprile";
$GLOBALS['strMonth'][4] = "Maggio";
$GLOBALS['strMonth'][5] = "Giugno";
$GLOBALS['strMonth'][6] = "Luglio";
$GLOBALS['strMonth'][7] = "Agosto";
$GLOBALS['strMonth'][8] = "Settembre";
$GLOBALS['strMonth'][9] = "Ottobre";
$GLOBALS['strMonth'][10] = "Novembre";
$GLOBALS['strMonth'][11] = "Dicembre";

$GLOBALS['strDayShortCuts'][0] = "Do";
$GLOBALS['strDayShortCuts'][1] = "Lu";
$GLOBALS['strDayShortCuts'][2] = "Ma";
$GLOBALS['strDayShortCuts'][3] = "Me";
$GLOBALS['strDayShortCuts'][4] = "Gi";
$GLOBALS['strDayShortCuts'][5] = "Ve";
$GLOBALS['strDayShortCuts'][6] = "Sa";

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
$GLOBALS['strNoClients']					= "Non è stato definito alcun inserzionista. Per creare una campagna, prima <a href='advertiser-edit.php'>aggiungi un inserzionista</a>.";
$GLOBALS['strConfirmDeleteClient']			= "Vuoi veramente eliminare questo inserzionista?";
$GLOBALS['strConfirmResetClientStats']		= "Vuoi veramente elminare tutte le statistiche esistenti per qusto inserzionista?";
$GLOBALS['strHideInactiveAdvertisers']		= "Nascondi inserzionisti inattivi";
$GLOBALS['strInactiveAdvertisersHidden']	= "inserzionisti inattivi nascosti";


// Advertisers properties
$GLOBALS['strContact']						= "Contatto";
$GLOBALS['strEMail']						= "E-mail";
$GLOBALS['strSendAdvertisingReport']		= "Spedisci report della campagna via Email";
$GLOBALS['strNoDaysBetweenReports']			= "numero di giorni tra rapporti";
$GLOBALS['strSendDeactivationWarning']		= "Spedisci un avvertimento quando la campagna viene disattivata";
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
$GLOBALS['strCampaignStats']				= "Statistiche campagna";
$GLOBALS['strCampaignProperties']			= "Impostazioni campagna";
$GLOBALS['strCampaignOverview']				= "Descrizione campagne";
$GLOBALS['strCampaignHistory']				= "Storico campagna";
$GLOBALS['strNoCampaigns']					= "Attualmente non sono presenti campagne definite";
$GLOBALS['strConfirmDeleteAllCampaigns']	= "Desideri realmente procedere alla cancellazione di tutte le campagne di questo inserzionista?";
$GLOBALS['strConfirmDeleteCampaign']		= "Desideri realmente procedere alla cancellazione di questa campagna?";
$GLOBALS['strConfirmResetCampaignStats']	= "Desideri realmente cancellare tutte le statistiche di questa campagna?";
$GLOBALS['strHideInactiveCampaigns']		= "Nascondi campagne inattive";
$GLOBALS['strInactiveCampaignsHidden']		= "campagne inattive nascoste";


// Campaign properties
$GLOBALS['strDontExpire']					= "Non far scadere";
$GLOBALS['strActivateNow']					= "Attiva immediatamente";
$GLOBALS['strLow']							= "Bassa";
$GLOBALS['strHigh']							= "Alta";
$GLOBALS['strExpirationDate']				= "Data Fine";
$GLOBALS['strActivationDate']				= "Data Inzio";
$GLOBALS['strImpressionsPurchased']				= "Visualizzazioni rimaste";
$GLOBALS['strClicksPurchased']				= "Click rimaste";
$GLOBALS['strCampaignWeight']				= "Imposta il peso della campagna";
$GLOBALS['strHighPriority']					= "Visualizza i banner in questa campagna con Priorità Alta.<br /> Usando questa opzione ".MAX_PRODUCT_NAME." prova a distribuire il numero di Visualizzazioni Scelto durante il corso della giornata.";
$GLOBALS['strLowPriority']					= "Visualizza i banner in questa campagna con Priorità Bassa.<br /> Usando questa opzione i banner sfrutteranno le visualizzazioni lasciate a disposizione dalla campagna con Priorità Alta.";
$GLOBALS['strTargetLimitAdviews']			= "Limita il numero di visualizzazioni a";
$GLOBALS['strTargetPerDay']					= "al giorno.";
$GLOBALS['strPriorityAutoTargeting']		= "Automatico - Distribuisci le visualizzazioni durante il corso delle rimanenti giornate. Il limite giornaliero di visualizzazioni verrà calcolato automaticamente.";
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
$GLOBALS['strNewBannerFile']				= "Scegli <br />la immagine che vuoi <br />utilizzare per questo banner<br /><br />";
$GLOBALS['strNewBannerURL']					= "URL immagine (http://...)";
$GLOBALS['strURL']							= "URL di destinazione (http://...)";
$GLOBALS['strHTML']							= "HTML";
$GLOBALS['strTextBelow']					= "Testo sotto immagine";
$GLOBALS['strKeyword']						= "Parole chiave";
$GLOBALS['strWeight']						= "Peso";
$GLOBALS['strAlt']							= "Testo Alternativo";
$GLOBALS['strStatusText']					= "Testo di stato";
$GLOBALS['strBannerWeight']					= "Peso del banner";


// Banner (swf)
$GLOBALS['strCheckSWF']						= "Controlla links presenti all'interno del file flash";
$GLOBALS['strConvertSWFLinks']				= "Converti links Flash";
$GLOBALS['strHardcodedLinks']				= "Link codificati all'interno del file";
$GLOBALS['strConvertSWF']					= "<br />Il file Flash appena caricato contiene urls codificati. ". MAX_PRODUCT_NAME ." non risulta in grado ditracciare il numero di click per questo banner fino a quando non convertirai questi urls codificati. Di seguito troverai una lista di tutti gli urls presenti nel file flash. Se vuoi convertire questi urls, semplicemente clicca <b>Converti</b>, altrimenti clicca <b>Cancella</b>.<br /><br /> Nota Bene: cliccando <b>Converti</b> il file flash che hai appena caricato viene modificato fisicamente. <br />Tieni da parte una copia di backup del file originale. Indipendentemente alla versione di flash utilizzata, il file risultante necessita del plug-in Flash 4 (o superiore).<br /><br />";
$GLOBALS['strCompressSWF']					= "Comprimi il file SWF per uno scaricamento più veloce (plug-in Flash 6 necessario)";
$GLOBALS['strOverwriteSource']				= "Sovrascrivi parametro sorgente";


// Banner (network)
$GLOBALS['strBannerNetwork']				= "Template HTML";
$GLOBALS['strChooseNetwork']				= "Scegli il modello da utilizzare";
$GLOBALS['strMoreInformation']				= "Maggiori informazioni...";
$GLOBALS['strRichMedia']					= "Richmedia";
$GLOBALS['strTrackAdClicks']				= "Traccia i Click";


// Display limitations
$GLOBALS['strModifyBannerAcl']				= "Impostazioni di consegna";
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
$GLOBALS['strSource']						= "Risorsa";
$GLOBALS['strBrowser'] 						= "Browser";
$GLOBALS['strOS'] 							= "Sistema operativo";
$GLOBALS['strCountry'] 						= "Stato";
$GLOBALS['strContinent'] 					= "Continente";
$GLOBALS['strUSState']						= "Stato (USA)";
$GLOBALS['strReferer'] 						= "Pagina di provenienza";
$GLOBALS['strDeliveryLimitations']			= "Limitazioni consegna";
$GLOBALS['strDeliveryCapping']				= "Limitazione di consegna per visitatore";
$GLOBALS['strTimeCapping']					= "Una volta consegnato il banner, non mostrarlo allo stesso utente per:";
$GLOBALS['strImpressionCapping']			= "Non mostrare il banner allo stesso utente più di:";


// Publisher
$GLOBALS['strAffiliate']					= "Sito";
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
$GLOBALS['strNoAffiliates']					= "Non è stato definito alcun editore. Per creare una zona, prima <a href='affiliate-edit.php'>aggiungi un editore</a>.";
$GLOBALS['strConfirmDeleteAffiliate']		= "Desideri realmente cancellare questo editore?";
$GLOBALS['strMakePublisherPublic']			= "Rendi pubblicamente disponibili le zone di questo editore";


// Publisher (properties)
$GLOBALS['strWebsite']						= "Sito";
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
$GLOBALS['strZoneOverview']					= "Descrizione zona";
$GLOBALS['strZoneProperties']				= "Impostazioni zona";
$GLOBALS['strZoneHistory']					= "Storico zona";
$GLOBALS['strNoZones']						= "Attualmente non sono presenti zone definite";
$GLOBALS['strConfirmDeleteZone']			= "Desideri veramente procedere alla cancellazione di questa zona?";
$GLOBALS['strZoneType']						= "Tipo di zona";
$GLOBALS['strBannerButtonRectangle']		= "Banner, Pulsante o Rettangolo";
$GLOBALS['strInterstitial']					= "Interstiziale o DHTML floating";
$GLOBALS['strPopup']						= "Popup";
$GLOBALS['strTextAdZone']					= "Inserzione testuale";
$GLOBALS['strShowMatchingBanners']			= "Mostra banner corrispondenti";
$GLOBALS['strHideMatchingBanners']			= "Nascondi banner corrispondenti";


// Advanced zone settings
$GLOBALS['strAdvanced']						= "Avanzate";
$GLOBALS['strChains']						= "Catene";
$GLOBALS['strChainSettings']				= "Impostazioni della catena";
$GLOBALS['strZoneNoDelivery']				= "Se nessun banner di questa zona <br />può essere fornito, prova a...";
$GLOBALS['strZoneStopDelivery']				= "Arrestare la fornitura e non visualizzare alcun banner";
$GLOBALS['strZoneOtherZone']				= "Mostrare la zona selezionata in sostituzione";
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
$GLOBALS['strRawQueryString']				= "Parola chiave";
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
$GLOBALS['strParameters']					= "Impostazioni tag";
$GLOBALS['strFrameSize']					= "Dimensione frame";
$GLOBALS['strBannercode']					= "Codice banner";
$GLOBALS['strOptional']						= "opzionale";


// Errors
$GLOBALS['strMySQLError']					= "Errore SQL:";
$GLOBALS['strLogErrorClients']				= "[OpenX] Errore intercorso durante il tentativo di estrarre gli inserzionisti dal database.";
$GLOBALS['strLogErrorBanners']				= "[OpenX] Errore intercorso durante il tentativo di estrarre i banner dal database.";
$GLOBALS['strLogErrorViews']				= "[OpenX] Errore intercorso durante il tentativo di estrarre le visualizzazioni dal database.";
$GLOBALS['strLogErrorClicks']				= "[OpenX] Errore intercorso durante il tentativo di estrarre i click dal database.";
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
$GLOBALS['strErrorDBNoDataPlain']			= "A causa di un problema con il database ". MAX_PRODUCT_NAME ." non può leggere o memorizzare i dati. ";
$GLOBALS['strErrorDBNoDataSerious']			= "A causa di un grave problema con il database, ". MAX_PRODUCT_NAME ." non può leggere i dati";
$GLOBALS['strErrorDBCorrupt']				= "Probabilmente la tabella è corrotta ed è necessario ripararla. Per avere più informazioni su come riparare le tabelle corrotte, leggere il capitolo <i>Troubleshooting</i> della <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact']				= "Contatta l'amministratore di questo server ed informalo del problema.";
$GLOBALS['strErrorDBSubmitBug']				= "Se questo problema è riproducibile, potrebbe essere causato da un bug di ". MAX_PRODUCT_NAME .". Per favore sottoponi le informazioni sottostanti ai creatori di ". MAX_PRODUCT_NAME .". Tenta inoltre di descrivere le azioni che hanno portato a questo errore il più chiaramente possible.";
$GLOBALS['strMaintenanceNotActive']			= "La procedura di manutenzione non è stata avviata nelle ultime 24 ore.\nPer fare in modo che ". MAX_PRODUCT_NAME ." funzioni correttamente, lo script deve essere avviato ogni ora\n\nConsulta la guida per l'amministratore per maggiori informazioni sulla\nconfigurazione dello script di manutenzione.";


// E-mail
$GLOBALS['strMailSubject']					= "Rapporto inserzionista";
$GLOBALS['strAdReportSent']					= "Rapporto inserzionista spedito";
$GLOBALS['strMailSubjectDeleted']			= "Banner disattivati";
$GLOBALS['strMailHeader']					= "Gentile {contact},\n";
$GLOBALS['strMailBannerStats']				= "Di seguito troverai le statistiche di visualizzazione banner per {clientname}:";
$GLOBALS['strMailFooter']					= "Cordiali saluti,\n   {adminfullname}";
$GLOBALS['strMailClientDeactivated']		= "I seguenti banner sono stati disattivati poiché";
$GLOBALS['strMailNothingLeft']				= "Se desideri continuare ad apparire sul nostro sito con i tuoi banner, per favore contattaci.\nSaremo felici di poter soddisfare le tue richieste.";
$GLOBALS['strClientDeactivated']			= "Questa campagna non risulta attualmente attiva poich�";
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



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strStartOver'] = "Inizia da capo";
$GLOBALS['strTrackerVariables'] = "Variabili del tracker";
$GLOBALS['strLogoutURL'] = "URL al quale reindirizzare a seguito del logout.<br />Non compilare per utilizzare le impostazioni prestabilite";
$GLOBALS['strAppendTrackerCode'] = "Aggiungi codice tracker";
$GLOBALS['strStatusDuplicate'] = "Duplicato";
$GLOBALS['strPriorityOptimisation'] = "Varie";
$GLOBALS['strCollectedAllStats'] = "Tutte le statistiche";
$GLOBALS['strCollectedYesterday'] = "Ieri";
$GLOBALS['strCollectedThisWeek'] = "Questa settimana";
$GLOBALS['strCollectedLastWeek'] = "Scorsa settimana";
$GLOBALS['strCollectedThisMonth'] = "Questo mese";
$GLOBALS['strCollectedLastMonth'] = "Scorso mese";
$GLOBALS['strCollectedLast7Days'] = "Ultimi 7 giorni";
$GLOBALS['strCollectedSpecificDates'] = "Date specifiche";
$GLOBALS['strAdmin'] = "Amministratore";
$GLOBALS['strNotice'] = "Notifica";
$GLOBALS['strPriorityLevel'] = "Livello di priorità";
$GLOBALS['strPriorityTargeting'] = "Distribuzione";
$GLOBALS['strLimitations'] = "Limitazioni";
$GLOBALS['strCapping'] = "Capping";
$GLOBALS['strVariableDescription'] = "Descrizione";
$GLOBALS['strVariables'] = "Variabili";
$GLOBALS['strStatsVariables'] = "Variabili";
$GLOBALS['strComments'] = "Commenti";
$GLOBALS['strUsernameOrPasswordWrong'] = "Nome utente o password non corretti. Inserire nuovamente le proprie credenziali.";
$GLOBALS['strDuplicateAgencyName'] = "Il nome utente fornito è già in uso, specificare un nome utente differente.";
$GLOBALS['strRequests'] = "Richieste";
$GLOBALS['strConversions'] = "Conversioni";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCNVR'] = "Proporzione vendita";
$GLOBALS['strTotalConversions'] = "Conversioni totali";
$GLOBALS['strConversionCredits'] = "Conversioni Crediti";
$GLOBALS['strDateTime'] = "Data Ora";
$GLOBALS['strTrackerID'] = "Tracker ID";
$GLOBALS['strTrackerName'] = "Nome Tracker";
$GLOBALS['strCampaignID'] = "ID Campagna";
$GLOBALS['strCampaignName'] = "Nome Campagna";
$GLOBALS['strStatsAction'] = "Azione";
$GLOBALS['strWindowDelay'] = "Ritardo finestra";
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Occupazione Mensile";
$GLOBALS['strBreakdownByDay'] = "Giorno";
$GLOBALS['strBreakdownByWeek'] = "Settimana";
$GLOBALS['strSingleMonth'] = "Mese";
$GLOBALS['strBreakdownByMonth'] = "Mese";
$GLOBALS['strDayOfWeek'] = "Giorno della settimana";
$GLOBALS['strBreakdownByDow'] = "Giorno della settimana";
$GLOBALS['strBreakdownByHour'] = "Ora";
$GLOBALS['strHiddenAdvertiser'] = "Inserzionista";
$GLOBALS['strChars'] = "caratteri";
$GLOBALS['strAllowClientViewTargetingStats'] = "Permetti a questo utente di visualizzare le statiche di targeting";
$GLOBALS['strCsvImportConversions'] = "Permetti a questo utente di importare conversioni offline";
$GLOBALS['strHiddenCampaign'] = "Campagna";
$GLOBALS['strLinkedCampaigns'] = "Campagne collegate";
$GLOBALS['strShowParentAdvertisers'] = "Mostra inserzionisti padri";
$GLOBALS['strHideParentAdvertisers'] = "Nascondi inserzionisti padri";
$GLOBALS['strContractDetails'] = "Dettagli contratto";
$GLOBALS['strInventoryDetails'] = "Dettagli inventario";
$GLOBALS['strPriorityInformation'] = "Priorità in relazione ad altre campagne";
$GLOBALS['strPriorityHigh'] = "\- Campagne pagate";
$GLOBALS['strPriorityLow'] = "\- Campagne non pagate";
$GLOBALS['strHiddenAd'] = "Inserzione";
$GLOBALS['strHiddenTracker'] = "Tracker";
$GLOBALS['strTracker'] = "Tracker";
$GLOBALS['strHiddenZone'] = "Zona";
$GLOBALS['strCompanionPositioning'] = "Posizionamento del companion";
$GLOBALS['strSelectUnselectAll'] = "Seleziona / Deseleziona tutti";
$GLOBALS['strExclusive'] = "Esclusiva";
$GLOBALS['strExpirationDateComment'] = "La campagna finirà alla fine di questo giorno";
$GLOBALS['strActivationDateComment'] = "La campagna incomincerà all'inizio di questo giorno";
$GLOBALS['strRevenueInfo'] = "Informazioni Ricavi";
$GLOBALS['strImpressionsRemaining'] = "Impressioni Rimaste";
$GLOBALS['strClicksRemaining'] = "Click rimasti";
$GLOBALS['strConversionsRemaining'] = "Conversioni rimaste";
$GLOBALS['strImpressionsBooked'] = "Impressioni Prenotate";
$GLOBALS['strClicksBooked'] = "Click Prenotati";
$GLOBALS['strConversionsBooked'] = "Conversioni Prenotate";
$GLOBALS['strOptimise'] = "Ottimizza";
$GLOBALS['strAnonymous'] = "Nascondi l'inserzionista e il sito di questa campagna";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "Questa campagna è stata impostata come esclusiva, \nma il suo peso è impostato a zero o non è stato specificato. \nQuesto comporterà la disattivazione della campagna: i suoi banner \nnon verranno visualizzati finché il peso non sarà impostato \nad un numero valido. \n\nSei sicuro di voler procedere?";
$GLOBALS['strCampaignWarningExclusiveNoWeight'] = "Questa campagna è stata impostata come esclusiva, \nma il suo peso è impostato a zero o non è stato specificato. \nQuesto comporterà la disattivazione della campagna: i suoi banner \nnon verranno visualizzati finché il peso non sarà impostato \nad un numero valido. \n\nSei sicuro di voler procedere?";
$GLOBALS['strTrackerOverview'] = "Informazioni Tracker";
$GLOBALS['strAddTracker'] = "Aggiungi nuovo tracker";
$GLOBALS['strAddTracker_Key'] = "Aggiungi <u>n</u>uovo tracker";
$GLOBALS['strNoTrackers'] = "Attualmente non ci sono tracker definiti";
$GLOBALS['strConfirmDeleteAllTrackers'] = "Vuoi davvero procedere alla cancellazione di tutti i tracker di questo inserzionista?";
$GLOBALS['strConfirmDeleteTracker'] = "Vuoi davvero procedere alla cancellazione di questo tracker?";
$GLOBALS['strDeleteAllTrackers'] = "Cancella tutti i tracker";
$GLOBALS['strTrackerProperties'] = "Impostazioni tracker";
$GLOBALS['strModifyTracker'] = "Modifica tracker";
$GLOBALS['strLog'] = "Log?";
$GLOBALS['strDefaultStatus'] = "Stato predefinito";
$GLOBALS['strStatus'] = "Stato";
$GLOBALS['strLinkedTrackers'] = "Tracker collegati";
$GLOBALS['strConversionWindow'] = "Finestra di conversione";
$GLOBALS['strUniqueWindow'] = "Finestra unica";
$GLOBALS['strClick'] = "Click";
$GLOBALS['strView'] = "Impressione";
$GLOBALS['strLinkCampaignsByDefault'] = "Collega automaticamente le nuove campagne appena create";
$GLOBALS['strConversionType'] = "Tipo di conversione";
$GLOBALS['strWarningMissing'] = "Attenzione, possibile omissione";
$GLOBALS['strWarningMissingClosing'] = "chiusura del tag \">\"";
$GLOBALS['strWarningMissingOpening'] = "apertura tag \"<\"";
$GLOBALS['strSubmitAnyway'] = "Invia comunque";
$GLOBALS['strUploadOrKeepAlt'] = "Preferisci mantenere la<br />immagine di backup esistente, o preferisci<br />caricarne un altra?";
$GLOBALS['strNewBannerFileAlt'] = "Seleziona l'immagine che vuoi utilizzare nel caso il browser non supporti il file multimediale";
$GLOBALS['strAdserverTypeGeneric'] = "Banner HTML Generico";
$GLOBALS['strGenericOutputAdServer'] = "Generico";
$GLOBALS['strGeneric'] = "Generico";
$GLOBALS['strSwfTransparency'] = "Permetti il background trasparente";
$GLOBALS['strChannelLimitations'] = "Impostazioni di consegna";
$GLOBALS['strGreaterThan'] = "è maggiore di";
$GLOBALS['strLessThan'] = "è minore di";
$GLOBALS['strWeekDays'] = "Giorni della settimana";
$GLOBALS['strCity'] = "Città";
$GLOBALS['strDeliveryCappingReset'] = "Azzera contatore visualizzazioni dopo:";
$GLOBALS['strDeliveryCappingTotal'] = "in totale";
$GLOBALS['strDeliveryCappingSession'] = "per sessione";
$GLOBALS['strAffiliateInvocation'] = "Codice di invocazione";
$GLOBALS['strTotalAffiliates'] = "Totale editori";
$GLOBALS['strInactiveAffiliatesHidden'] = "editori inattivi nascosti";
$GLOBALS['strShowParentAffiliates'] = "Mostra editori padri";
$GLOBALS['strHideParentAffiliates'] = "Nascondi editori padri";
$GLOBALS['strMnemonic'] = "Mnemonico";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Permetti a questo utente di generare il codice di invocazione";
$GLOBALS['strAllowAffiliateZoneStats'] = "Permetti a questo utente di visualizzare le statistiche per zona";
$GLOBALS['strAllowAffiliateApprPendConv'] = "Permetti a questo utente di visualizzare solo le conversioni approvate o pendenti";
$GLOBALS['strPaymentInformation'] = "Informazioni di pagamento";
$GLOBALS['strAddress'] = "Indirizzo";
$GLOBALS['strPostcode'] = "CAP";
$GLOBALS['strPhone'] = "Telefono";
$GLOBALS['strFax'] = "Fax";
$GLOBALS['strAccountContact'] = "Contatto account";
$GLOBALS['strPayeeName'] = "Nome";
$GLOBALS['strTaxID'] = "Tax ID";
$GLOBALS['strModeOfPayment'] = "Modalità di pagamento";
$GLOBALS['strPaymentChequeByPost'] = "Ordine per post";
$GLOBALS['strCurrency'] = "Valuta";
$GLOBALS['strCurrencyGBP'] = "GBP";
$GLOBALS['strOtherInformation'] = "Altre informazioni";
$GLOBALS['strUniqueUsersMonth'] = "Utenti unici al mese";
$GLOBALS['strUniqueViewsMonth'] = "Visite uniche al mese";
$GLOBALS['strPageRank'] = "Page rank";
$GLOBALS['strCategory'] = "Categoria";
$GLOBALS['strHelpFile'] = "File di Aiuto";
$GLOBALS['strEmailAdZone'] = "Zone Email/Newsletter";
$GLOBALS['strZoneClick'] = "Zona tracciamento click";
$GLOBALS['strBannerLinkedAds'] = "Banner collegati alla zona";
$GLOBALS['strCampaignLinkedAds'] = "Campagne collegate alla zona";
$GLOBALS['strTotalZones'] = "Zone totali";
$GLOBALS['strCostInfo'] = "Costo media";
$GLOBALS['strTechnologyCost'] = "Costo tecnologia";
$GLOBALS['strInactiveZonesHidden'] = "zone inattive nascoste";
$GLOBALS['strWarnChangeZoneType'] = "Cambiando il tipo di zona a testo o email saranno persi i collegamenti a banner o campagne per via delle limitazioni di questo tipo di zona\n<ul>\n<li>Zone testuali possono essere collegate solo a inserzioni testuali</li>\n<li>Zone delle campagne Email possono avere solo un banner attivo alla volta</li>\n</ul>";
$GLOBALS['strWarnChangeZoneSize'] = "Cambiando la dimensione della zona si perderanno i collegamenti con tutti i banner che non sono della nuova dimensione, e saranno aggiunti tutti i banner dalle campagne collegate che sono della nuova dimensione";
$GLOBALS['strZoneForecasting'] = "Impostazioni previsioni della zona";
$GLOBALS['strZoneAppendNoBanner'] = "Utilizza come suffisso anche se non viene fornito alcun banner";
$GLOBALS['strLinkedBanners'] = "Collega banner individuali";
$GLOBALS['strCampaignDefaults'] = "Collega banner per campagna di appartenenza";
$GLOBALS['strLinkedCategories'] = "Collega banner per categoria";
$GLOBALS['strNoTrackersToLink'] = "Non ci sono attualmente tracker disponibili che possano essere collegati a questa campagna";
$GLOBALS['strSelectAdvertiser'] = "Seleziona inserzionista";
$GLOBALS['strSelectPlacement'] = "Seleziona campagna";
$GLOBALS['strSelectAd'] = "Seleziona banner";
$GLOBALS['strStatusPending'] = "In attesa";
$GLOBALS['strStatusApproved'] = "Approvato";
$GLOBALS['strStatusDisapproved'] = "Rifiutato";
$GLOBALS['strStatusOnHold'] = "Sospeso";
$GLOBALS['strStatusIgnore'] = "Ignora";
$GLOBALS['strConnectionType'] = "Tipo";
$GLOBALS['strType'] = "Tipo";
$GLOBALS['strConnTypeSale'] = "Vendita";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Iscrizione";
$GLOBALS['strShortcutEditStatuses'] = "Modifica stati";
$GLOBALS['strShortcutShowStatuses'] = "Mostra stati";
$GLOBALS['strNoTargetingStats'] = "Non ci sono statistiche sul targeting disponibili";
$GLOBALS['strNoStatsForPeriod'] = "Non sono disponibili statistiche per il periodo dal %s al %s";
$GLOBALS['strNoTargetingStatsForPeriod'] = "Non sono disponibili statistiche sul targeting per il periodo dal %s al %s";
$GLOBALS['strPublisherDistribution'] = "Distribuzione editori";
$GLOBALS['strCampaignDistribution'] = "Distribuzione campagne";
$GLOBALS['strViewBreakdown'] = "Visto da";
$GLOBALS['strItemsPerPage'] = "Oggetti per pagina";
$GLOBALS['strDistributionHistory'] = "Storico distribuzioni";
$GLOBALS['strShowGraphOfStatistics'] = "Mostra <u>G</u>rafico delle Statistiche";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>sporta Statistiche in Excel";
$GLOBALS['strGDnotEnabled'] = "E' necessario avere GD abilitato in PHP per mostrare i grafici. Per maggiori informazioni su coma abilitare GD sul tuo sistema consulta <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a>.";
$GLOBALS['strStartDate'] = "Data Inzio";
$GLOBALS['strEndDate'] = "Data Fine";
$GLOBALS['strAllAdvertisers'] = "Tutti gli inserzionisti";
$GLOBALS['strAnonAdvertisers'] = "Inserzionisti anonimi";
$GLOBALS['strAllPublishers'] = "Tutti gli editori";
$GLOBALS['strAnonPublishers'] = "Editori anonimi";
$GLOBALS['strAllAvailZones'] = "Tutte le zone disponibili";
$GLOBALS['strBackToTheList'] = "Torna alla lista dei report";
$GLOBALS['strLogErrorConversions'] = "[OpenX] Errore intercorso durante il tentativo di estrarre le conversioni dal database.";
$GLOBALS['strErrorLinkingBanner'] = "Non è stato possibile collegare questo banner a questa zona perché:";
$GLOBALS['strUnableToLinkBanner'] = "Impossibile collegare questo banner:";
$GLOBALS['strErrorEditingCampaign'] = "Errore durante il caricamento della campagna:";
$GLOBALS['strUnableToChangeCampaign'] = "Impossibile applicare questi cambiamenti perché:";
$GLOBALS['strDatesConflict'] = "le date sono in conflitto con:";
$GLOBALS['strEmailNoDates'] = "Campagne zone Email devono avere una data di inizio e una data di fine";
$GLOBALS['strSirMadam'] = "Signore/Signora";
$GLOBALS['strMailBannerActivatedSubject'] = "Campagna attivata";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Campagna disattivata";
$GLOBALS['strMailBannerActivated'] = "Questa campagna non risulta attualmente attiva poiché";
$GLOBALS['strMailBannerDeactivated'] = "La campagna segnalata di seguito è stata disattivata perché";
$GLOBALS['strNoMoreImpressions'] = "non sono rimaste visualizzazioni";
$GLOBALS['strNoMoreConversions'] = "non ci sono Vendite rimaste";
$GLOBALS['strImpressionsClicksConversionsLow'] = "Visualizzazioni/Click/Conversioni sono basse";
$GLOBALS['strNoConversionLoggedInInterval'] = "Nessuna conversione registrata durante l`arco di questo report";
$GLOBALS['strImpendingCampaignExpiry'] = "Scadenza campagna imminente";
$GLOBALS['strYourCampaign'] = "Tue campagne";
$GLOBALS['strTheCampiaignBelongingTo'] = "La campagna appartenente a";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} mostrato di seguito sta per scadere il {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} mostrato di seguito ha meno di {limit} impressioni rimaste.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "Come risultato, la campagna sarà presto disabilitata automaticamente, così come\nverranno disabilitati i seguenti banner:";
$GLOBALS['strSourceEdit'] = "Modifica risorse";
$GLOBALS['strViewPastUpdates'] = "Gestisci scorsi aggiornamenti e backup";
$GLOBALS['strAgencyManagement'] = "Gestione account";
$GLOBALS['strAgency'] = "Account";
$GLOBALS['strAddAgency'] = "Aggiungi un nuovo account";
$GLOBALS['strAddAgency_Key'] = "Aggiungi un <u>n</u>uovo account";
$GLOBALS['strTotalAgencies'] = "Account totali";
$GLOBALS['strAgencyProperties'] = "Proprietà dell'account";
$GLOBALS['strNoAgencies'] = "Non è stato definito alcun account";
$GLOBALS['strConfirmDeleteAgency'] = "Vuoi davvero cancellare questo account?";
$GLOBALS['strHideInactiveAgencies'] = "Nascondi gli account non attivi";
$GLOBALS['strInactiveAgenciesHidden'] = "account non attivi, nascosti";
$GLOBALS['strAllowAgencyEditConversions'] = "Consenti a questo utente di modificare le conversioni";
$GLOBALS['strAllowMoreReports'] = "Consenti pulsante 'Più Rapporti'";
$GLOBALS['strChannel'] = "Canale di targeting";
$GLOBALS['strChannels'] = "Canali di targeting";
$GLOBALS['strChannelOverview'] = "Descrizione canale di targeting";
$GLOBALS['strChannelManagement'] = "Gestione canale di targeting";
$GLOBALS['strAddNewChannel'] = "Aggiungi un nuovo canale di targeting";
$GLOBALS['strAddNewChannel_Key'] = "Aggiungi un <n>n</n>uovo canale di targeting";
$GLOBALS['strNoChannels'] = "Non è stato definito alcun canale di targeting";
$GLOBALS['strEditChannelLimitations'] = "Modifica le limitazioni del canale di targeting";
$GLOBALS['strChannelProperties'] = "Proprietà del canale di targeting";
$GLOBALS['strConfirmDeleteChannel'] = "Vuoi davvero cancellare questo canale di targeting?";
$GLOBALS['strVariableName'] = "Nome variabile";
$GLOBALS['strVariableDataType'] = "Tipo di dati";
$GLOBALS['strVariablePurpose'] = "Scopo";
$GLOBALS['strBasketValue'] = "Valore del cesto";
$GLOBALS['strNumItems'] = "Numero di oggetti";
$GLOBALS['strVariableIsUnique'] = "Conversione Dedup?";
$GLOBALS['strNumber'] = "Numero";
$GLOBALS['strString'] = "Stringa";
$GLOBALS['strTrackFollowingVars'] = "Traccia la seguente variabile";
$GLOBALS['strAddVariable'] = "Aggiungi variabile";
$GLOBALS['strNoVarsToTrack'] = "Nessuna variabile da tracciare";
$GLOBALS['strVariableRejectEmpty'] = "Rifiuta se vuoto?";
$GLOBALS['strTrackingSettings'] = "Impostazioni tracciamenti";
$GLOBALS['strTrackerType'] = "Tipo di tracciatore";
$GLOBALS['strTrackerTypeJS'] = "Traccia variabili Javascript";
$GLOBALS['strTrackerTypeDefault'] = "Traccia variabili Javascript (compatibilità con le versioni precedenti, richiesto l'escaping)";
$GLOBALS['strTrackerTypeDOM'] = "Traccia elementi HTML utilizzando DOM";
$GLOBALS['strTrackerTypeCustom'] = "Codice Javascript personalizzato";
$GLOBALS['strVariableCode'] = "Codice tracciamento Javascript";
$GLOBALS['strForgotPassword'] = "Hai dimenticato la password?";
$GLOBALS['strPasswordRecovery'] = "Recupero password";
$GLOBALS['strEmailRequired'] = "Email è un campo richiesto";
$GLOBALS['strPwdRecEmailNotFound'] = "Indirizzo email non trovato";
$GLOBALS['strPwdRecPasswordSaved'] = "La nuova password è stata salvata, procedi con il <a href='index.php'>login</a>";
$GLOBALS['strPwdRecWrongId'] = "ID errato";
$GLOBALS['strPwdRecEnterEmail'] = "Inserisci il tuo indirizzo e-mail qui sotto";
$GLOBALS['strPwdRecEnterPassword'] = "Inserisci qui sotto la nuova password";
$GLOBALS['strPwdRecResetLink'] = "Link reset della password";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s password recuperata";
$GLOBALS['strDefaultBannerDestination'] = "URL di destinazione predefinito";
$GLOBALS['strEvent'] = "Evento";
$GLOBALS['strHas'] = "era";
$GLOBALS['strValue'] = "Valore";
$GLOBALS['strAuditTrail'] = "Audit Trail";
$GLOBALS['strLinkNewUser'] = "Collega nuovo utente";
$GLOBALS['strUserAccess'] = "Accesso utente";
$GLOBALS['strCampaignStatusRunning'] = "In funzione";
$GLOBALS['strCampaignStatusPaused'] = "In pausa";
$GLOBALS['strCampaignStatusAwaiting'] = "In attesa";
$GLOBALS['strCampaignStatusExpired'] = "Completato";
$GLOBALS['strCampaignStatusApproval'] = "In attesa di approvazione »";
$GLOBALS['strCampaignStatusRejected'] = "Rifiutata";
$GLOBALS['strCampaignApprove'] = "Approva";
$GLOBALS['strCampaignApproveDescription'] = "accetta questa campagna";
$GLOBALS['strCampaignReject'] = "Rifiuta";
$GLOBALS['strCampaignRejectDescription'] = "rifiuta questa campagna";
$GLOBALS['strCampaignPause'] = "Pausa";
$GLOBALS['strCampaignPauseDescription'] = "ferma temporaneamente questa campagna";
$GLOBALS['strCampaignRestart'] = "Riprendi";
$GLOBALS['strCampaignRestartDescription'] = "riprendi questa campagna";
$GLOBALS['strCampaignStatus'] = "Stato della campagna";
$GLOBALS['strReasonForRejection'] = "Ragione del rifiuto";
$GLOBALS['strReasonSiteNotLive'] = "Sito non attivo";
$GLOBALS['strReasonBadCreative'] = "Contenuto inopportuno";
$GLOBALS['strReasonBadUrl'] = "Indirizzo di destinazione inappropriato";
$GLOBALS['strReasonBreakTerms'] = "Sito contro il regolamento";
$GLOBALS['strTrackerPreferences'] = "Preferenze tracker";
$GLOBALS['strBannerPreferences'] = "Preferenze banner";
$GLOBALS['strAdvertiserSetup'] = "Registrazione inserzionisti";
$GLOBALS['strAdvertiserSignup'] = "Registrazione inserzionisti";
$GLOBALS['strSelectPublisher'] = "Seleziona sito";
$GLOBALS['strSelectZone'] = "Seleziona zona";
$GLOBALS['strMainPreferences'] = "Preferenze principali";
$GLOBALS['strAccountPreferences'] = "Preferenze account";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Preferenze rapporti email della campagna";
$GLOBALS['strAdminEmailWarnings'] = "Email di notifica amministratore";
$GLOBALS['strAgencyEmailWarnings'] = "Email di notifica agenzia";
$GLOBALS['strAdveEmailWarnings'] = "Email di notifica inserzionista";
$GLOBALS['strFullName'] = "Nome completo";
$GLOBALS['strEmailAddress'] = "Indirizzo email";
$GLOBALS['strUserDetails'] = "Dettagli utente";
$GLOBALS['strLanguageTimezone'] = "Lingua & Timezone";
$GLOBALS['strUserInterfacePreferences'] = "Preferenze interfaccia utente";
$GLOBALS['strInvocationPreferences'] = "Preferenze invocazione";
$GLOBALS['strUserProperties'] = "Proprietà utente";
$GLOBALS['strBack'] = "Indietro";
$GLOBALS['strUsernameToLink'] = "Nome dell’utente da aggiungere";
$GLOBALS['strEmailToLink'] = "Email dell’utente da aggiungere";
$GLOBALS['strNewUserWillBeCreated'] = "Il nuovo utente verrà creato";
$GLOBALS['strToLinkProvideEmail'] = "Per aggiungere l’utente si deve fornire la sua e-mail";
$GLOBALS['strToLinkProvideUsername'] = "Per aggiungere l’utente si deve fornire il suo nome utente";
$GLOBALS['strPermissions'] = "Permessi";
$GLOBALS['strContactName'] = "Nome del contatto";
$GLOBALS['strPwdRecReset'] = "Reimpostazione password";
$GLOBALS['strPwdRecResetPwdThisUser'] = "Reimpostazione password per questo utente";
$GLOBALS['keyLinkUser'] = "u";
$GLOBALS['strAdSenseAccounts'] = "Account AdSense";
$GLOBALS['strLinkAdSenseAccount'] = "Link Account AdSense";
$GLOBALS['strCreateAdSenseAccount'] = "Crea Account AdSense";
$GLOBALS['strEditAdSenseAccount'] = "Modifica Account AdSense";
$GLOBALS['strAllowCreateAccounts'] = "Permetti a questo utente di creare nuovi account";
$GLOBALS['strErrorWhileCreatingUser'] = "Errore nella creazione utente: %s";
$GLOBALS['strUserLinkedToAccount'] = "L’utente è stato aggiunto all’account";
$GLOBALS['strUserAccountUpdated'] = "Account utente aggiornato";
$GLOBALS['strUserUnlinkedFromAccount'] = "L’utente è stato rimosso dall’account";
$GLOBALS['strUserWasDeleted'] = "L’utente è stato eliminato";
$GLOBALS['strUserNotLinkedWithAccount'] = "Tale utente non è collegato con l`account";
$GLOBALS['strWorkingAs'] = "Lavora come";
$GLOBALS['strWorkingFor'] = "%s per...";
$GLOBALS['strCantDeleteOneAdminUser'] = "Non puoi cancellare l`utente. Almeno un altro utente necessita di essere collegato con l`account di amministrazione.";
$GLOBALS['strWarnChangeBannerSize'] = "Cambiando la dimensione del banner tutti i banner che non sono della nuova dimensione verranno scollegati dalle relative zone, e se la campagna di questo banner è collegato ad una zona della nuova dimensione, questo banner sarà collegato automaticamente";
$GLOBALS['strAuditNoData'] = "Nessuna attività dell`utente  è stata registrata durante il periodo di tempo che hai selezionato.";
$GLOBALS['strCampaignGoTo'] = "Vai alla pagina delle campagne";
$GLOBALS['strCampaignSetUp'] = "Impostare una campagna di oggi";
$GLOBALS['strCampaignNoRecords'] = "<li>Le campagne ti permettono di raggruppare insieme banner di ogni dimensione che condividono gli stessi requisiti</li><li>Risparmia tempo definendo guppi di banner e non dovrai più impostare tutti i parametri singolarmente per ogni banner</li><li>Consulta la <a class='site-link' target='help' href='". OX_PRODUCT_DOCSURL ."/inventory/advertisersAndCampaigns/campaigns'>Documentazione sulle Campagne</a>!</li>";
$GLOBALS['strPublisherReports'] = "Rapporti Editore";
$GLOBALS['strVariableHidden'] = "Nascondere variabile per l'editore?";
$GLOBALS['strCampaignNoDataTimeSpan'] = "Nessuna campagna avviata o finita durante il periodo selezionato";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>Per essere in grado di vedere le campagne iniziate o concluse durante il lasso di tempo che hai selezionato, devi attivare Audit Trail</li>	        <li>Stai leggendo questo messaggio perché Audit Trail non è stato attivato.</li>";
$GLOBALS['strAuditTrailSetup'] = "Importa Audit Trail oggi";
$GLOBALS['strAuditTrailGoTo'] = "Vai alla pagina Audit Trail";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Audit Trail ti permette di vedere chi ha fatto cosa e quando. In altre parole, Audit Trail mantiene traccia dei cambiamenti del sistema ". MAX_PRODUCT_NAME ."</li>\n<li>Se visualizzi questo messaggio, Audit Trail non è stato attivato</li>\n<li>Vuoi saperne di più? Leggi la <a href='". OX_PRODUCT_DOCSURL ."/settings/auditTrail' class='site-link' target='help' >Documentazione Audit Trail</a></li>";
$GLOBALS['strAdminAccess'] = "Accesso Amministratore";
$GLOBALS['strOverallAdvertisers'] = "inserzionisti";
$GLOBALS['strAdvertiserSignupDesc'] = "Iscriviti per accedere al self service e pagamento per l'Inserzionista";
$GLOBALS['strOverallCampaigns'] = "campagne";
$GLOBALS['strTotalRevenue'] = "Totale Ricavi";
$GLOBALS['strChangeStatus'] = "Cambia stato";
$GLOBALS['strImpression'] = "Impressione";
$GLOBALS['strOverallBanners'] = "Banner";
$GLOBALS['strTrackerImageTag'] = "Tag Immagine";
$GLOBALS['strTrackerJsTag'] = "Tag Javascript";
$GLOBALS['strPeriod'] = "Periodo";
$GLOBALS['strWorksheets'] = "Foglio di lavoro";
$GLOBALS['strSwitchAccount'] = "Passa a questo account";
$GLOBALS['strAdditionalItems'] = "e oggetti aggiuntivi";
$GLOBALS['strFor'] = "per";
$GLOBALS['strFieldStartDateBeforeEnd'] = "La data di inizio deve essere antecedente alla data di fine";
$GLOBALS['strDashboardForum'] = "Forum OpenX";
$GLOBALS['strDashboardDocs'] = "Documentazione OpenX";
$GLOBALS['strLinkUserHelpUser'] = "nome utente";
$GLOBALS['strLinkUserHelpEmail'] = "indirizzo email";
$GLOBALS['strSessionIDNotMatch'] = "Errore nel cookie di sessione, per favore entra nuovamente.";
$GLOBALS['strPasswordRepeat'] = "Ripeti la password";
$GLOBALS['strInvalidEmail'] = "L'email non è stata inserita correttamente, per favore inserisci un indirizzo email valido.";
$GLOBALS['strAdvertiserLimitation'] = "Mostra solo un banner di questo editore sulla stessa pagina web";
$GLOBALS['strAllowAuditTrailAccess'] = "Permetti a questo utente di accedere all'Audit Trail";
$GLOBALS['strCampaignStatusAdded'] = "Aggiunto";
$GLOBALS['strCampaignStatusStarted'] = "Avviato";
$GLOBALS['strCampaignStatusRestarted'] = "Riavviato";
$GLOBALS['strAdserverTypeMax'] = "OpenX - Rich Media";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "Ci sono ancora dei pagamenti per campagne collegate a questa zona, se la elimini non riuscirai ad eseguire le campagne ed ottenere i pagamenti.";
$GLOBALS['strCharset'] = "Set di caratteri";
$GLOBALS['strAutoDetect'] = "Riconoscimento automatico";
$GLOBALS['strWarningInaccurateStats'] = "Alcune di queste statistiche sono state loggate in un fuso orario non Universal Time, potrebbero non essere mostrate nel fuso orario corretto.";
$GLOBALS['strWarningInaccurateReadMore'] = "Leggi di più in proposito";
$GLOBALS['strWarningInaccurateReport'] = "Alcune delle statistiche in questo report sono state loggate in un fuso orario non Universal Time, potrebbero non essere mostrate nel fuso orario corretto";
$GLOBALS['strUserPreferences'] = "Preferenze utente";
$GLOBALS['strChangePassword'] = "Cambia password";
$GLOBALS['strChangeEmail'] = "Cambia email";
$GLOBALS['strCurrentPassword'] = "Password attuale";
$GLOBALS['strChooseNewPassword'] = "Scegli una nuova password";
$GLOBALS['strReenterNewPassword'] = "Ripeti la nuova password";
$GLOBALS['strNameLanguage'] = "Nome e lingua";
$GLOBALS['strNotifyPageMessage'] = "Ti è stata spedita una email con un link che ti permetterà di reimpostare la password ed entrare nel sistema.<br />Attendi pochi minutil l'arrivo della email.<br />Se non la ricevi entro breve, controlla che non sia finita nella posta indesiderata.<br /><a href='index.php'>Torna alla pagina di accesso.</a>";
$GLOBALS['strAdZoneAsscociation'] = "Associazione zona";
$GLOBALS['strBinaryData'] = "Dati binari";
$GLOBALS['strAuditTrailDisabled'] = "L'amministratore ha disabilitato Audit Trail. Non saranno registrati e mostrati ulteriori eventi nella lista Audit Trail.";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>Non ci sono attività da mostrare.</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Attiva Audit Trail per iniziare a vedere le campagne";
$GLOBALS['strAdd'] = "Aggiungi";
$GLOBALS['strRequiredField'] = "Campo obbligatorio";
$GLOBALS['strNoSslSupport'] = "La tua installazione attualmente non supporta SSL";
$GLOBALS['strSslAccessCentralSys'] = "Per accedere alla pagina iniziale, il tuo ad server deve essere capace di entrare in sicurezza nel nostro sistema centrale usando SSL (Secure Socket Layer).";
$GLOBALS['strInstallSslExtension'] = "È necessario installare una estensione PHP per comunicare tramite SSL: openssl o curl con capacità SSL. Per avere più informazioni contatta il tuo amministratore di sistema.";
$GLOBALS['strChoosenDisableHomePage'] = "Hai scelto di disabilitare la tua pagina iniziale.";
$GLOBALS['strAccessHomePage'] = "Accedi alla tua pagina iniziale";
$GLOBALS['strEditSyncSettings'] = "e modifica le tue impostazioni di sincronizzazione";
$GLOBALS['strLinkUser'] = "Aggiungi utente";
$GLOBALS['strLinkUser_Key'] = "Aggiungi <u>u</u>tente";
$GLOBALS['strLastLoggedIn'] = "Ultimo accesso";
$GLOBALS['strDateLinked'] = "Data collegata";
$GLOBALS['strUnlink'] = "Rimuovi";
$GLOBALS['strUnlinkingFromLastEntity'] = "Rimozione dell'utente dall'ultima entità";
$GLOBALS['strUnlinkingFromLastEntityBody'] = "Rimuovere l'utente dall'ultima entità ne causerà l'eliminazione. Vuoi eliminare l'utente?";
$GLOBALS['strUnlinkAndDelete'] = "Rimuovi ed elimina l'utente";
$GLOBALS['strUnlinkUser'] = "Rimuovi utente";
$GLOBALS['strUnlinkUserConfirmBody'] = "Confermi di voler rimuovere questo utente?";
$GLOBALS['strDeadLink'] = "Il tuo collegamento non è valido.";
$GLOBALS['strNoPlacement'] = "La campagna selezionata non esiste. Prova questo <a href='{link}'collegamento</a> invece";
$GLOBALS['strNoAdvertiser'] = "L'inserzionista selezionato non esiste. Prova questo <a href='{link}'collegamento</a> invece";
$GLOBALS['strPercentRevenueSplit'] = "% divisione ricavi";
$GLOBALS['strPercentBasketValue'] = "% Valore del cesto";
$GLOBALS['strAmountPerItem'] = "Ammontare per oggetto";
$GLOBALS['strPercentCustomVariable'] = "% Variabile personalizzata";
$GLOBALS['strPercentSumVariables'] = "% Somma delle variabili";
$GLOBALS['strAdvertiserSignupLink'] = "Collegamento alla registrazione inserzionisti";
$GLOBALS['strAdvertiserSignupLinkDesc'] = "Per aggiungere nel tuo sito un collegamento alla registrazione inserzionisti, per favore copia il seguente codice HTML:";
$GLOBALS['strAdvertiserSignupOption'] = "Opzione registrazione inserzionisti";
$GLOBALS['strAdvertiserSignunOptionDesc'] = "Per modificare le opzioni di registrazione inserzionisti, segui";
$GLOBALS['strCampaignStatusPending'] = "In attesa";
$GLOBALS['strCampaignStatusDeleted'] = "Eliminata";
$GLOBALS['strTrackers'] = "Tracker";
$GLOBALS['strWebsiteURL'] = "URL del sito";
$GLOBALS['strInventoryForecasting'] = "Previsione inventario";
$GLOBALS['strPerSingleImpression'] = "per singola impressione";
$GLOBALS['strWithXBanners'] = "Banner %d";
$GLOBALS['strTrackerCodeSubject'] = "Accoda codice tracker";
$GLOBALS['strStatsArea'] = "Area";
$GLOBALS['strNoExpirationEstimation'] = "Non è ancora stata stimata nessuna scadenza.";
$GLOBALS['strDaysAgo'] = "giorni fa";
$GLOBALS['strCampaignStop'] = "Termina campagna";
$GLOBALS['strErrorEditingCampaignRevenue'] = "numero nel formato non corretto per il campo Informazioni ricavi ";
$GLOBALS['strErrorEditingZone'] = "Errore durante l'aggiornamento della zona:";
$GLOBALS['strUnableToChangeZone'] = "Impossibile applicare questi cambiamenti perché:";
$GLOBALS['strErrorEditingZoneTechnologyCost'] = "numero nel formato non corretto per il campo Costo del media";
$GLOBALS['strErrorEditingZoneCost'] = "numero nel formato non corretto per il campo Costo tecnologia";
$GLOBALS['strLanguageTimezonePreferences'] = "Preferenze lingua e fuso orario";
$GLOBALS['strColumnName'] = "Nome colonna";
$GLOBALS['strShowColumn'] = "Mostra colonna";
$GLOBALS['strCustomColumnName'] = "Nome colonna personalizzato";
$GLOBALS['strColumnRank'] = "Colonna Rank";
$GLOBALS['strCost'] = "Costo";
$GLOBALS['strNumberOfItems'] = "Numero di oggetti";
$GLOBALS['strRevenueCPC'] = "Ricavo Cost Per Click (CPC)";
$GLOBALS['strCostCPC'] = "Cos. CPC";
$GLOBALS['strIncome'] = "Reddito";
$GLOBALS['strIncomeMargin'] = "Margine del reddito";
$GLOBALS['strProfit'] = "Profitto";
$GLOBALS['strMargin'] = "Margine";
$GLOBALS['strERPM'] = "ERPM";
$GLOBALS['strERPC'] = "ERPC";
$GLOBALS['strERPS'] = "ERPS";
$GLOBALS['strEIPM'] = "EIPM";
$GLOBALS['strEIPC'] = "EIPC";
$GLOBALS['strEIPS'] = "EIPS";
$GLOBALS['strECPM'] = "ECPM";
$GLOBALS['strECPC'] = "ECPC";
$GLOBALS['strECPS'] = "ECPS";
$GLOBALS['strEPPM'] = "EPPM";
$GLOBALS['strEPPC'] = "EPPC";
$GLOBALS['strEPPS'] = "EPPS";
$GLOBALS['strCheckForUpdates'] = "Controlla aggiornamenti";
$GLOBALS['strFromVersion'] = "Dalla versione";
$GLOBALS['strToVersion'] = "alla versione";
$GLOBALS['strToggleDataBackupDetails'] = "Altera i dettagli dei dati di backup";
$GLOBALS['strClickViewBackupDetails'] = "clicca per mostrare i dettagli";
$GLOBALS['strClickHideBackupDetails'] = "clicca per nascondere i dettagli";
$GLOBALS['strShowBackupDetails'] = "Mostra i dettagli";
$GLOBALS['strHideBackupDetails'] = "Nascondi i dettagli";
$GLOBALS['strInstallation'] = "Installazione";
$GLOBALS['strBackupDeleteConfirm'] = "Confermi l'eliminazione di tutti i backup creati da questo aggiornamento?";
$GLOBALS['strDeleteArtifacts'] = "Elimina gli artifatti";
$GLOBALS['strArtifacts'] = "Artifatti";
$GLOBALS['strBackupDbTables'] = "Backup tabelle del database";
$GLOBALS['strLogFiles'] = "File di registro";
$GLOBALS['strConfigBackups'] = "Conf. backup";
$GLOBALS['strUpdatedDbVersionStamp'] = "Aggiornato il numero di versione del database";
$GLOBALS['strAgencies'] = "Accounts";
$GLOBALS['strModifychannel'] = "Modifica obiettivo del canale";
$GLOBALS['strPwdRecEmailSent'] = "Spedizione della email di recupero password";
$GLOBALS['strAccount'] = "Account";
$GLOBALS['strAccountUserAssociation'] = "Associazione account utente";
$GLOBALS['strImage'] = "Immagine";
$GLOBALS['strCampaignZoneAssociation'] = "Associazione zona";
$GLOBALS['strAccountPreferenceAssociation'] = "Associazione preferenze account";
$GLOBALS['strUnsavedChanges'] = "I cambiamenti effettuati su questa pagina non sono stati salvati, accertati di premere \"Salva cambiamenti\" al termine";
$GLOBALS['strDeliveryLimitationsDisagree'] = "ATTENZIONE: Alcune limitazioni del motore di distribuzione <strong>non permettono</strong> le limitazioni elencate di seuito<br /> Per favore premi &quot;salva cambiamenti&quot; per aggiornare le regole di distribuzione del motore.";
$GLOBALS['strPendingConversions'] = "Conversioni in attesa";
$GLOBALS['strImpressionSR'] = "Visualizzazione SR";
$GLOBALS['strClickSR'] = "Click SR";
$GLOBALS['str_cs'] = "Ceco";
$GLOBALS['str_de'] = "Tedesco";
$GLOBALS['str_en'] = "Inglese";
$GLOBALS['str_es'] = "Spagnolo";
$GLOBALS['str_fa'] = "Persiano";
$GLOBALS['str_fr'] = "Francese";
$GLOBALS['str_he'] = "Ebraico";
$GLOBALS['str_hu'] = "Ungherese";
$GLOBALS['str_id'] = "Indonesiano";
$GLOBALS['str_it'] = "Italiano";
$GLOBALS['str_ja'] = "Giapponese";
$GLOBALS['str_ko'] = "Coreano";
$GLOBALS['str_nl'] = "Olandese";
$GLOBALS['str_pl'] = "Polacco";
$GLOBALS['str_ro'] = "Rumeno";
$GLOBALS['str_ru'] = "Russo";
$GLOBALS['str_sl'] = "Sloveno";
$GLOBALS['str_tr'] = "Turco";
$GLOBALS['strGlobalSettings'] = "Impostazioni globali";
$GLOBALS['strMyAccount'] = "Mio account";
$GLOBALS['strSwitchTo'] = "Passa a";
$GLOBALS['strRevenue'] = "Entrate";
$GLOBALS['str_ar'] = "Arabo";
$GLOBALS['str_bg'] = "Bulgaro";
$GLOBALS['str_cy'] = "Gallese";
$GLOBALS['str_da'] = "Danese";
$GLOBALS['str_el'] = "Greco";
$GLOBALS['str_hr'] = "Croato";
$GLOBALS['str_lt'] = "Lituano";
$GLOBALS['str_ms'] = "Malese";
$GLOBALS['str_nb'] = "Norvegese Bokmål";
$GLOBALS['str_sk'] = "Slovacco";
$GLOBALS['str_sv'] = "Svedese";
$GLOBALS['str_uk'] = "Ucraino";
$GLOBALS['strDashboardErrorCode'] = "codice";
$GLOBALS['strDashboardGenericError'] = "Errore generico";
$GLOBALS['strDashboardSystemMessage'] = "Messaggio di sistema";
$GLOBALS['strDashboardErrorHelp'] = "Se questo errore si ripete per favore descrivi il tuo problema nel dettaglio e pubblicalo sui <a href='http://forum.openx.org/'>forum OpenX</a>.";
$GLOBALS['strDashboardErrorMsg800'] = "Errore della connessione XML-RPC";
$GLOBALS['strDashboardErrorMsg801'] = "Autenticazione fallita";
$GLOBALS['strDashboardErrorMsg802'] = "Hai fallito il controllo CAPTCHA";
$GLOBALS['strDashboardErrorMsg803'] = "Parametri errati";
$GLOBALS['strDashboardErrorMsg804'] = "Il nome utente non coincide con la piattaforma";
$GLOBALS['strDashboardErrorMsg805'] = "La piattaforma non esiste";
$GLOBALS['strDashboardErrorMsg806'] = "Errore del server";
$GLOBALS['strDashboardErrorMsg807'] = "Autorizzazione negata";
$GLOBALS['strDashboardErrorMsg808'] = "La versione di XML-RPC non è supportata";
$GLOBALS['strDashboardErrorMsg900'] = "Codice di errore del trasferimento";
$GLOBALS['strDashboardErrorMsg821'] = "Errore di autenticazione M2M: tipo di account non permesso";
$GLOBALS['strDashboardErrorMsg822'] = "Errore di autenticazione M2M: la password è già stata generata";
$GLOBALS['strDashboardErrorMsg823'] = "Errore di autenticazione M2M: password non valida";
$GLOBALS['strDashboardErrorMsg824'] = "Errore di autenticazione M2M: password scaduta";
$GLOBALS['strDashboardErrorMsg825'] = "Errore di autenticazione M2M: connessione fallita";
$GLOBALS['strDashboardErrorMsg826'] = "Errore di autenticazione M2M: riconnessione fallita";
$GLOBALS['strDashboardErrorDsc800'] = "Per alcuni widget il cruscotto ottiene informazioni da un server centrale. Ci sono alcune cose che potrebbero influire sul buon esito dell'operazione.<br /> Il tuo server potrebbe essere stato configurato senza estensione CURL. Potresti aver necessità di installare o abilitare l' <a href='http://it.php.net/curl'>estensione CURL</a>, controlla nel manuale PHP per aver maggiori dettagli.<br /> Inoltre controlla che il firewall del tuo server consenta le connessioni in uscita.";
$GLOBALS['strDashboardErrorDsc803'] = "Errore nella richiesta al server: parametri errati, per favore ritenta l'invio dei tuoi dati.";
$GLOBALS['strDashboardErrorDsc805'] = "La connessione XML-RPC non è stata permessa durante l'installazione di OpenX quindi il server centrale di OpenX non ha riconosciuto come valida questa installazione. <br /> Per favore, visita la pagina <em>Account amministratore » Il mio account » Aggiornamenti prodotto</em> e registrati nuovamente sul server centrale.";
$GLOBALS['strActions'] = "Azione";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strNoClientsForBanners'] = "Non è stato definito alcun inserzionista. Per creare una campagna, prima <a href='advertiser-edit.php'>aggiungi un inserzionista</a>.";
$GLOBALS['strAdvertiserCampaigns'] = "Inserzionisti e Campagne";
$GLOBALS['strCampaignStatusInactive'] = "attiva";
$GLOBALS['strCampaignType'] = "Nome Campagna";
$GLOBALS['strContract'] = "Contatto";
$GLOBALS['strStandardContract'] = "Contatto";
$GLOBALS['strBannerToCampaign'] = "Tue campagne";
$GLOBALS['strBannersOfCampaign'] = "in";
$GLOBALS['strWebsiteZones'] = "Editori e Zone";
$GLOBALS['strZoneToWebsite'] = "Nessun sito";
$GLOBALS['strNoZonesAddWebsite'] = "Non è stato definito alcun editore. Per creare una zona, prima <a href='affiliate-edit.php'>aggiungi un editore</a>.";
$GLOBALS['strZonesOfWebsite'] = "in";
$GLOBALS['strPluginPreferences'] = "Preferenze principali";
$GLOBALS['strRevenue_short'] = "Ric.";
$GLOBALS['strCost_short'] = "Costo";
$GLOBALS['strBasketValue_short'] = "BV";
$GLOBALS['strNumberOfItems_short'] = "Num. Ogg.";
$GLOBALS['strRevenueCPC_short'] = "Ric. CPC";
$GLOBALS['strCostCPC_short'] = "Cos. CPC";
$GLOBALS['strTechnologyCost_short'] = "Cos. Tec.";
$GLOBALS['strIncome_short'] = "Reddito";
$GLOBALS['strIncomeMargin_short'] = "Marg. Redd.";
$GLOBALS['strProfit_short'] = "Profitto";
$GLOBALS['strMargin_short'] = "Margine";
$GLOBALS['strERPM_short'] = "ERPM";
$GLOBALS['strERPC_short'] = "ERPC";
$GLOBALS['strERPS_short'] = "ERPS";
$GLOBALS['strEIPM_short'] = "EIPM";
$GLOBALS['strEIPC_short'] = "EIPC";
$GLOBALS['strEIPS_short'] = "EIPS";
$GLOBALS['strECPM_short'] = "ECPM";
$GLOBALS['strECPC_short'] = "ECPC";
$GLOBALS['strECPS_short'] = "ECPS";
$GLOBALS['strEPPM_short'] = "EPPM";
$GLOBALS['strEPPC_short'] = "EPPC";
$GLOBALS['strEPPS_short'] = "EPPS";
$GLOBALS['strChannelToWebsite'] = "Nessun sito";
$GLOBALS['strChannelsOfWebsite'] = "in";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Alcune limitazioni di distribuzione hanno riportato dei valori incorretti:";
$GLOBALS['strConfirmDeleteClients'] = "Vuoi veramente eliminare questo inserzionista?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Desideri realmente procedere alla cancellazione di questa campagna?";
$GLOBALS['strConfirmDeleteTrackers'] = "Vuoi davvero procedere alla cancellazione di questo tracker?";
$GLOBALS['strNoBannersAddCampaign'] = "Non è stato definito alcun editore. Per creare una zona, prima <a href='affiliate-edit.php'>aggiungi un editore</a>.";
$GLOBALS['strNoBannersAddAdvertiser'] = "Non è stato definito alcun editore. Per creare una zona, prima <a href='affiliate-edit.php'>aggiungi un editore</a>.";
$GLOBALS['strConfirmDeleteBanners'] = "Vuoi veramente cancellare questo banner?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Desideri realmente cancellare questo editore?";
$GLOBALS['strConfirmDeleteZones'] = "Desideri veramente procedere alla cancellazione di questa zona?";
$GLOBALS['strErrorDatabaseConnetion'] = "Errore nella connessione al database";
$GLOBALS['strErrorCantConnectToDatabase'] = "Errore fatale %s non può collegarsi al database. Per tanto non è possibile usare l'interfaccia amministrativa. Inoltre può essere stata compromessa la distribuzione dei banner. Possibili cause del problema:<ul><li>Il server database in questo momento non funziona</li> <li>L'indirizzo del server database è cambiato</li> <li>Le credenziali di accesso al server database non sono corrette</li> <li>L'estensione MySQL di PHP non è stata caricata</li> </ul>";
$GLOBALS['strActualImpressions'] = "Impressioni";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strRequests_short'] = "Ric.";
$GLOBALS['strClicks_short'] = "Click";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "Conv.";
$GLOBALS['strPendingConversions_short'] = "Conv. in attesa";
$GLOBALS['strClickSR_short'] = "Click SR";
$GLOBALS['strNoChannelsAddWebsite'] = "Non è stato definito alcun editore. Per creare una zona, prima <a href='affiliate-edit.php'>aggiungi un editore</a>.";
$GLOBALS['strConfirmDeleteChannels'] = "Vuoi davvero cancellare questo canale di targeting?";
$GLOBALS['strSite'] = "Dimensioni";
$GLOBALS['strHiddenWebsite'] = "Sito";
$GLOBALS['strYouHaveNoCampaigns'] = "Inserzionisti e Campagne";
$GLOBALS['strSyncSettings'] = "Impostazioni di Sincronizzazione";
$GLOBALS['strNoAdminInteface'] = "L'interfaccia di amministrazione non è accessibile per manutenzione. La consegna delle tue campagne avverrà normalmente.";
$GLOBALS['strEnableCookies'] = "Devi abilitare i cookies prima di poter usare ". MAX_PRODUCT_NAME ."";
$GLOBALS['strHideInactiveOverview'] = "Nascondi gli oggetti non attivi in tutte le pagine riassuntive";
$GLOBALS['strHiddenPublisher'] = "Sito";
$GLOBALS['strDefaultConversionRules'] = "Regole di conversione predefinite";
$GLOBALS['strClickWindow'] = "Finestra di click";
$GLOBALS['strViewWindow'] = "Finestra di impressioni";
$GLOBALS['strAppendNewTag'] = "Aggiungi nuovo tag";
$GLOBALS['strMoveUp'] = "Sposta su";
$GLOBALS['strMoveDown'] = "Sposta giù";
$GLOBALS['strRestart'] = "Riavvia";
$GLOBALS['strRegexMatch'] = "L'espressione regolare corrisponde";
$GLOBALS['strRegexNotMatch'] = "L'espressione regolare non corrisponde";
$GLOBALS['strIsAnyOf'] = "E' uno di";
$GLOBALS['strIsNotAnyOf'] = "Non è uno di";
$GLOBALS['strCappingBanner']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingBanner']['limit'] = "Limita visualizzazioni banner a:";
$GLOBALS['strCappingCampaign']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingCampaign']['limit'] = "Limita visualizzazioni campagna a:";
$GLOBALS['strCappingZone']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingZone']['limit'] = "Limita visualizzazioni zona a:";
$GLOBALS['strPickCategory'] = "\- seleziona una categoria -";
$GLOBALS['strPickCountry'] = "\- seleziona uno stato -";
$GLOBALS['strPickLanguage'] = "\- seleziona una lingua -";
$GLOBALS['strKeywordStatistics'] = "Statistiche parola chiave";
$GLOBALS['strNoWebsites'] = "Nessun sito";
$GLOBALS['strSomeWebsites'] = "Alcuni siti";
$GLOBALS['strVariableHiddenTo'] = "Variabile nascosta a";
$GLOBALS['strHide'] = "Nascondi:";
$GLOBALS['strShow'] = "Mostra:";
$GLOBALS['strInstallWelcome'] = "Benvenuto in ". MAX_PRODUCT_NAME ."";
$GLOBALS['strTimezoneInformation'] = "Informazioni sul fuso orario (le statistiche terranno conto di questa impostazione)";
$GLOBALS['strDebugSettings'] = "Log di Debug";
$GLOBALS['strDeliveryBanner'] = "Impostazioni Generali di Consegna dei Banner";
$GLOBALS['strIncovationDefaults'] = "Impostazioni predefinite per l'invocazione";
$GLOBALS['strStatisticsLogging'] = "Impostazioni Log Statistiche Globali";
$GLOBALS['strMaintenaceSettings'] = "Impostazioni di manutenzione globali";
$GLOBALS['strMaintenanceAdServerInstalled'] = "Statistiche del processo per il modulo AdServer";
$GLOBALS['strMaintenanceTrackerInstalled'] = "Statistiche del processo per il modulo Tracker";
$GLOBALS['strMaintenanceCompactStats'] = "Vuoi cancellare le statistiche grezze dopo la loro analisi";
$GLOBALS['strMaintenanceCompactStatsGrace'] = "Periodo dopo il quale le statistiche saranno cancellate (in secondi)";
$GLOBALS['strWarnCompactStatsGrace'] = "Il periodo di tolleranza delle statistiche compatte deve essere un intero positivo";
$GLOBALS['strAdminEmailHeaders'] = "Aggiungere le seguenti intestazioni ad ogni messaggio e-mail inviato da ". MAX_PRODUCT_NAME ."";
$GLOBALS['strIn'] = "in";
$GLOBALS['strEventDetails'] = "Dettaglio Evento";
$GLOBALS['strEventHistory'] = "Storico Evento";
$GLOBALS['strLinkNewUser_Key'] = "Link <u>u</u>tente";
$GLOBALS['strLinkUserHelp'] = "Per aggiungere un <strong>utente esistente</strong> digita %s e clicca {$GLOBALS['strLinkUser']}<br />Per aggiungere un <strong>nuovo utente</strong> digita %s voluto e clicca {$GLOBALS['strLinkUser']}";
$GLOBALS['strOpenadsImpressionsRemaining'] = "Impressioni rimanenti OpenX";
$GLOBALS['strOpenadsImpressionsRemainingHelp'] = "Il numero delle impressioni rimanenti per la campagna sono troppo poche per soddisfare il numero delle impressioni prenotate dall'inserzionista. Questo significa che il numero totale di click locali rimanenti è minore rispetto al numero dei click centrali rimanenti e dovresti aumentare le impressioni prenotate.";
$GLOBALS['strOpenadsClicksRemaining'] = "Click rimanenti OpenX";
$GLOBALS['strOpenadsConversionsRemaining'] = "Conversioni rimanenti OpenX";
$GLOBALS['strNoDataToDisplay'] = "Non è presente alcun dato da visualizzare.";
$GLOBALS['strDisagreeACL_BannersExplaination'] = "In alcune circostanze il motore di distribuzione è in disaccordo con la lista di controllo degli accessi per banner e canali. Clicca sul link sotto per convalidare la lista di controllo degli accessi.";
$GLOBALS['strHomePageDisabled'] = "La tua pagina iniziale è stata disabilitata";
$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB Full Banner (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB Skyscraper (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "IAB Leaderboard (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB Button 1 (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB Button 2 (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB Half Banner (234 x 60)";
$GLOBALS['strIab']['IAB_LeaderBoard(728x90)*'] = "IAB Leader Board (728 x 90) *";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB Micro Bar (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB Square Button (125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB Rectangle (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB Square Pop-up (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB Vertical Banner (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB Medium Rectangle (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "IAB Large Rectangle (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB Vertical Rectangle (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB Wide Skyscraper (160 x 600)";
$GLOBALS['strRevenueShort'] = "Ric.";
$GLOBALS['strCostShort'] = "Costo";
$GLOBALS['strBasketValueShort'] = "BV";
$GLOBALS['strNumberOfItemsShort'] = "Num. Ogg.";
$GLOBALS['strRevenueCPCShort'] = "Ric. CPC";
$GLOBALS['strCostCPCShort'] = "Costo Cost Per Click (CPC)";
$GLOBALS['strTechnologyCostShort'] = "Cos. Tec.";
$GLOBALS['strIncomeShort'] = "Reddito";
$GLOBALS['strIncomeMarginShort'] = "Marg. Redd.";
$GLOBALS['strProfitShort'] = "Profitto";
$GLOBALS['strMarginShort'] = "Margine";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "Aggiornamento completato";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "Aggiornamento fallito";
$GLOBALS['strConversionsShort'] = "Conv.";
$GLOBALS['strPendingConversionsShort'] = "Conv. in attesa";
$GLOBALS['strClickSRShort'] = "Click SR";
$GLOBALS['phpAds_hlp_my_header'] = "Dovresti inserire il percorso ai file header (es.: /home/login/www/header.htm) per avere header e/o footer in ogni pagina dell'interfaccia amministrativa. Nei file puoi inserire solo testo oppure anche HTML. Se vuoi usare codice HTML non inserire i tag &gt;html&lt;, &gt;head&lt; e &gt;body&lt;.";
$GLOBALS['strReportBug'] = "Segnala malfunzionamento";
$GLOBALS['strSameWindow'] = "Stessa finestra";
$GLOBALS['strNewWindow'] = "Nuova finestra";
$GLOBALS['strClick-ThroughRatio'] = "Proporzione click-through";
$GLOBALS['strImpressionSRShort'] = "Visualizzazione SR";
$GLOBALS['strRequestsShort'] = "Ric.";
$GLOBALS['strClicksShort'] = "Click";
$GLOBALS['strImpressionsShort'] = "Impressioni";
$GLOBALS['strCampaignTracker'] = "Tracker campagne";
$GLOBALS['strVariable'] = "Variabile";
$GLOBALS['strAffiliateExtra'] = "Informazioni Extra sul sito";
$GLOBALS['strPreference'] = "Preferenze";
$GLOBALS['strAccountUserPermissionAssociation'] = "Associazione account permessi utente";
$GLOBALS['strDeliveryLimitation'] = "Limitazioni consegna";
$GLOBALS['strSaveAnyway'] = "Salva in ogni caso";
$GLOBALS['str_ID'] = "ID";
$GLOBALS['str_Requests'] = "Richieste";
$GLOBALS['str_Impressions'] = "Impressioni";
$GLOBALS['str_Clicks'] = "Click";
$GLOBALS['str_CTR'] = "CTR";
$GLOBALS['str_BasketValue'] = "Valore del cesto";
$GLOBALS['str_TechnologyCost'] = "Costo tecnologia";
?>