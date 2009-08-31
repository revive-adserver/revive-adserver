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
$GLOBALS['phpAds_TextDirection']		= 'ltr';
$GLOBALS['phpAds_TextAlignRight']		= 'right';
$GLOBALS['phpAds_TextAlignLeft']		= 'left';

$GLOBALS['phpAds_DecimalPoint']			= ',';
$GLOBALS['phpAds_ThousandsSeperator']		= ' ';


// Date & time configuration
$GLOBALS['date_format']				= '%d/%m/%Y';
$GLOBALS['time_format']				= '%H:%M:%S';
$GLOBALS['minute_format']			= '%H:%M';
$GLOBALS['month_format']			= '%m/%Y';
$GLOBALS['day_format']				= '%d/%m';
$GLOBALS['week_format']				= '%W/%Y';
$GLOBALS['weekiso_format']			= '%V/%G';



/*********************************************************/
/* Translations                                          */
/*********************************************************/

$GLOBALS['strHome']				= 'Accueil';
$GLOBALS['strHelp']				= 'Aide';
$GLOBALS['strNavigation'] 			= 'Navigation';
$GLOBALS['strShortcuts'] 			= 'Raccourcis';
$GLOBALS['strAdminstration'] 			= 'Inventaire';
$GLOBALS['strMaintenance']			= 'Maintenance';
$GLOBALS['strProbability']			= 'Probabilité';
$GLOBALS['strInvocationcode']			= 'Code d\'invocation';
$GLOBALS['strBasicInformation'] 		= 'Informations générales';
$GLOBALS['strContractInformation'] 		= 'Informations contractuelles';
$GLOBALS['strLoginInformation'] 		= 'Information de connexion';
$GLOBALS['strOverview']				= 'Vue d\'ensemble';
$GLOBALS['strSearch']				= '<u>R</u>echerche';
$GLOBALS['strHistory']				= 'Historique';
$GLOBALS['strPreferences']			= 'Préférences';
$GLOBALS['strDetails']				= 'Détails';
$GLOBALS['strCompact']				= 'Résumé';
$GLOBALS['strVerbose']				= 'Complet';
$GLOBALS['strUser']				= 'Utilisateur';
$GLOBALS['strEdit']				= 'Éditer';
$GLOBALS['strCreate']				= 'Créer';
$GLOBALS['strDuplicate']			= 'Dupliquer';
$GLOBALS['strMoveTo']				= 'Déplacer vers';
$GLOBALS['strDelete'] 				= 'Supprimer';
$GLOBALS['strActivate']				= 'Activer';
$GLOBALS['strDeActivate'] 			= 'Désactiver';
$GLOBALS['strConvert']				= 'Convertir';
$GLOBALS['strRefresh']				= 'Actualiser';
$GLOBALS['strSaveChanges']			= 'Enregistrer les modifications';
$GLOBALS['strUp'] 				= 'Haut';
$GLOBALS['strDown'] 				= 'Bas';
$GLOBALS['strSave'] 				= 'Enregistrer';
$GLOBALS['strCancel']				= 'Annuler';
$GLOBALS['strPrevious'] 			= 'Précédent';
$GLOBALS['strPrevious_Key'] 			= '<u>P</u>récédent';
$GLOBALS['strNext'] 				= 'Suivant';
$GLOBALS['strNext_Key']				= '<u>S</u>uivant';
$GLOBALS['strYes']				= 'Oui';
$GLOBALS['strNo']				= 'Non';
$GLOBALS['strNone'] 				= 'Aucun';
$GLOBALS['strCustom']				= 'Personnalisé';
$GLOBALS['strDefault'] 				= 'Par défaut';
$GLOBALS['strOther']				= 'Autre';
$GLOBALS['strUnknown']				= 'Inconnu';
$GLOBALS['strUnlimited'] 			= 'Illimité';
$GLOBALS['strUntitled']				= 'Sans titre';
$GLOBALS['strAll']				= 'tout';
$GLOBALS['strAvg']				= 'Moy.';
$GLOBALS['strAverage']				= 'Moyen';
$GLOBALS['strOverall'] 				= 'Ensemble';
$GLOBALS['strTotal']				= 'Totalité';
$GLOBALS['strActive']				= 'actif';
$GLOBALS['strFrom']				= 'Du';
$GLOBALS['strTo']				= 'de';
$GLOBALS['strLinkedTo']				= 'lié à';
$GLOBALS['strDaysLeft']				= 'Jours restants';
$GLOBALS['strCheckAllNone']			= 'Cocher / décocher tout';
$GLOBALS['strKiloByte']				= 'Ko';
$GLOBALS['strExpandAll']			= '<u>D</u>évelopper tout';
$GLOBALS['strCollapseAll']			= '<u>R</u>eplier tout';
$GLOBALS['strShowAll']				= 'Afficher tout';
$GLOBALS['strNoAdminInteface']			= 'L\'écran d\'admin a été désactivé en raison d\'une maintenance. Cela n\'affecte pas la distribution de vos campagnes.';
$GLOBALS['strFilterBySource']			= 'filtrer par source';
$GLOBALS['strFieldContainsErrors']		= 'Les champs suivants contiennent des erreurs :';
$GLOBALS['strFieldFixBeforeContinue1']		= 'Avant de continuer vous avez besoin de';
$GLOBALS['strFieldFixBeforeContinue2']		= 'pour corriger ces erreurs,';
$GLOBALS['strDelimiter']			= 'Délimiteur';
$GLOBALS['strMiscellaneous']			= 'Divers';


// Properties
$GLOBALS['strName']				= 'Nom';
$GLOBALS['strSize']				= 'Taille';
$GLOBALS['strWidth'] 				= 'Largeur';
$GLOBALS['strHeight'] 				= 'Hauteur';
$GLOBALS['strURL2']				= 'URL ';
$GLOBALS['strTarget']				= 'Cible';
$GLOBALS['strLanguage'] 			= 'Langue';
$GLOBALS['strDescription'] 			= 'Description';
$GLOBALS['strID']				= 'ID';


// Login & Permissions
$GLOBALS['strAuthentification'] 		= 'Authentification';
$GLOBALS['strWelcomeTo']			= 'Bienvenue sur';
$GLOBALS['strEnterUsername']			= 'Entrez vos identifiant et mot de passe pour vous connecter';
$GLOBALS['strEnterBoth']			= 'Veuillez entrer vos identifiant et mot de passe';
$GLOBALS['strEnableCookies']			= 'Vous devez activer les cookies sur votre navigateur avant de pouvoir utiliser '.MAX_PRODUCT_NAME;
$GLOBALS['strLogin'] 				= 'Connexion';
$GLOBALS['strLogout'] 				= 'Déconnexion';
$GLOBALS['strUsername'] 			= 'Identifiant';
$GLOBALS['strPassword']				= 'Mot de passe';
$GLOBALS['strAccessDenied']			= 'Accès refusé';
$GLOBALS['strPasswordWrong']			= 'Le mot de passe est incorrect';
$GLOBALS['strNotAdmin']				= 'Votre compte n\'a pas les permissions requises pour utiliser cette fonctionnalité, vous pouvez vous connecter à un autre compte pour l\'utiliser. Cliquez <a href=\'logout.php\'>ici</a> pour vous connecter en tant qu\'un utilisateur différent.';
$GLOBALS['strDuplicateClientName']		= 'L\'identifiant que vous avez entré existe déjà, veuillez en choisir un autre.';
$GLOBALS['strInvalidPassword']			= 'Le nouveau mot de passe est invalide, veuillez en utiliser un différent.';
$GLOBALS['strNotSamePasswords']			= 'Les deux mots de passe ne sont pas identiques';
$GLOBALS['strRepeatPassword']			= 'Répéter le mot de passe';
$GLOBALS['strOldPassword']			= 'Ancien mot de passe';
$GLOBALS['strNewPassword']			= 'Nouveau mot de passe';

// General advertising
$GLOBALS['strRequests']             = 'Requêtes';
$GLOBALS['strImpressions'] 				= 'Impressions';
$GLOBALS['strClicks']				= 'Clics';
$GLOBALS['strConversions']			= 'Conversions';
$GLOBALS['strCTRShort'] 			= 'CTR';
$GLOBALS['strCTR'] 				    = 'CTR';
$GLOBALS['strCNVR'] 				= 'Taux de ventes';
$GLOBALS['strCNVRShort'] 			= "SR";
$GLOBALS['strTotalViews'] 			= 'Nbre total d\'affichages';
$GLOBALS['strTotalClicks'] 			= 'Total de clics';
$GLOBALS['strViewCredits'] 			= 'Crédit d\'impressions';
$GLOBALS['strClickCredits'] 			= 'Crédit de clics';


// Time and date related
$GLOBALS['strDate'] 				= 'Date';
$GLOBALS['strToday'] 				= 'Aujourd\'hui';
$GLOBALS['strDay']				= 'Jour';
$GLOBALS['strDays']				= 'Jours';
$GLOBALS['strLast7Days']			= 'Derniers 7 jours';
$GLOBALS['strWeek'] 				= 'Semaine';
$GLOBALS['strWeeks']				= 'Semaines';
$GLOBALS['strMonths']				= 'Mois';
$GLOBALS['strThisMonth'] 			= 'Ce mois-ci';
$GLOBALS['strMonth'][0] = "Janvier";
$GLOBALS['strMonth'][1] = "Février";
$GLOBALS['strMonth'][2] = "Mars";
$GLOBALS['strMonth'][3] = "Avril";
$GLOBALS['strMonth'][4] = "Mai";
$GLOBALS['strMonth'][5] = "Juin";
$GLOBALS['strMonth'][6] = "Juillet";
$GLOBALS['strMonth'][7] = "Août";
$GLOBALS['strMonth'][8] = "Septembre";
$GLOBALS['strMonth'][9] = "Octobre";
$GLOBALS['strMonth'][10] = "Novembre";
$GLOBALS['strMonth'][11] = "Décembre";

$GLOBALS['strDayShortCuts'][0] = "Di";
$GLOBALS['strDayShortCuts'][1] = "Lu";
$GLOBALS['strDayShortCuts'][2] = "Ma";
$GLOBALS['strDayShortCuts'][3] = "Me";
$GLOBALS['strDayShortCuts'][4] = "Je";
$GLOBALS['strDayShortCuts'][5] = "Ve";
$GLOBALS['strDayShortCuts'][6] = "Sa";

$GLOBALS['strHour']				= 'Heure';
$GLOBALS['strSeconds']				= 'secondes';
$GLOBALS['strMinutes']				= 'minutes';
$GLOBALS['strHours']				= 'heures';
$GLOBALS['strTimes']				= 'fois';


// Advertiser
$GLOBALS['strClient']				= 'Annonceur';
$GLOBALS['strClients'] 				= 'Annonceurs';
$GLOBALS['strClientsAndCampaigns']		= 'Annonceurs & Campagnes';
$GLOBALS['strAddClient'] 			= 'Ajouter un nouvel annonceur';
$GLOBALS['strAddClient_Key']			= 'Ajouter un <u>n</u>ouvel annonceur';
$GLOBALS['strTotalClients'] 			= 'Total d\'annonceurs';
$GLOBALS['strClientProperties']			= 'Propriétés de l\'annonceur';
$GLOBALS['strClientHistory']			= 'Historique de l\'annonceur';
$GLOBALS['strNoClients']			= 'Il n\'y a actuellement aucun annonceur défini. Pour créer une campagne, commencez par <a href=\'advertiser-edit.php\'>ajouter un nouvel annonceur</a>.';
$GLOBALS['strConfirmDeleteClient'] 		= 'Voulez-vous vraiment supprimer cet annonceur ?';
$GLOBALS['strConfirmResetClientStats']		= 'Souhaitez-vous supprimer les statistiques de cet annonceur ?';
$GLOBALS['strHideInactiveAdvertisers']		= 'Masquer les annonceurs inactifs';
$GLOBALS['strInactiveAdvertisersHidden']	= 'annonceur(s) inactif(s) masqué(s)';


// Advertisers properties
$GLOBALS['strContact'] 				= 'Contact';
$GLOBALS['strEMail'] 				= 'E-mail';
$GLOBALS['strSendAdvertisingReport']		= 'Envoyer des rapports de distribution de campagne par e-mail';
$GLOBALS['strNoDaysBetweenReports']		= 'Nombre de jours entre les rapports de distribution de campagne';
$GLOBALS['strSendDeactivationWarning']  	= 'Envoyer un e-mail quand la campagne est automatiquement activée/désactivée';
$GLOBALS['strAllowClientModifyInfo'] 		= 'Autoriser cet utilisateur à modifier ses propres paramètres';
$GLOBALS['strAllowClientModifyBanner'] 		= 'Autoriser cet utilisateur à modifier ses propres bannières';
$GLOBALS['strAllowClientAddBanner'] 		= 'Permettre à cet annonceur d\'ajouter des bannières';
$GLOBALS['strAllowClientDisableBanner'] 	= 'Autoriser cet utilisateur à désactiver ses propres bannières';
$GLOBALS['strAllowClientActivateBanner'] 	= 'Autoriser cet utilisateur à activer ses propres bannières';


// Campaign
$GLOBALS['strCampaign']				= 'Campagne';
$GLOBALS['strCampaigns']			= 'Campagnes';
$GLOBALS['strTotalCampaigns']			= 'Total de campagnes';
$GLOBALS['strActiveCampaigns']			= 'Campagnes actives';
$GLOBALS['strAddCampaign'] 			= 'Ajouter une nouvelle campagne';
$GLOBALS['strAddCampaign_Key'] 			= 'Ajouter une <u>n</u>ouvelle campagne';
$GLOBALS['strCreateNewCampaign']		= 'Créer une nouvelle campagne';
$GLOBALS['strModifyCampaign']			= 'Modifier la campagne';
$GLOBALS['strMoveToNewCampaign']		= 'Déplacer vers une nouvelle campagne';
$GLOBALS['strBannersWithoutCampaign']		= 'Bannières sans campagne';
$GLOBALS['strDeleteAllCampaigns']		= 'Supprimer toutes les campagnes';
$GLOBALS['strCampaignStats']			= 'Statistiques des campagnes';
$GLOBALS['strCampaignProperties']		= 'Propriétés de la campagne';
$GLOBALS['strCampaignOverview']			= 'Vue d\'ensemble des campagnes';
$GLOBALS['strCampaignHistory']			= 'Historique de la campagne';
$GLOBALS['strNoCampaigns']			= 'Il n\'y a actuellement aucune campagne définie pour cet annonceur.';
$GLOBALS['strConfirmDeleteAllCampaigns']	= 'Voulez-vous vraiment supprimer toutes les campagnes de cet annonceur ?';
$GLOBALS['strConfirmDeleteCampaign']		= 'Voulez-vous vraiment supprimer cette campagne ?';
$GLOBALS['strConfirmResetCampaignStats']	= 'Souhaitez-vous supprimer toutes les statistiques liées à cette campagne ?';
$GLOBALS['strHideInactiveCampaigns']		= 'Masquer les campagnes inactives';
$GLOBALS['strInactiveCampaignsHidden']		= 'campagne(s) inactive(s) masquée(s)';


// Campaign properties
$GLOBALS['strDontExpire']			= 'N\'expire pas';
$GLOBALS['strActivateNow'] 			= 'Démarrer immédiatement';
$GLOBALS['strLow']				= 'Faible';
$GLOBALS['strHigh']				= 'Élevé';
$GLOBALS['strExpirationDate']			= 'Date de fin';
$GLOBALS['strActivationDate']			= 'Date de début';
$GLOBALS['strImpressionsPurchased']			= 'Nbre d\'affichages restant ';
$GLOBALS['strClicksPurchased']			= 'Nbre de clics restant ';
$GLOBALS['strCampaignWeight']			= 'Régler le poids de la campagne';
$GLOBALS['strHighPriority']			= 'Montrer les bannières de cette campagne avec une priorité haute.<br> Si vous utilisez cette option, '.MAX_PRODUCT_NAME
						 .' essayera de répartir les affichages uniformément sur la durée totale de la campagne.';
$GLOBALS['strLowPriority']			= 'Montrer les bannières de cette campagne avec une priorité basse.<br> Les affichages de cette campagne seront répartis en'
						 .'fonction des objectifs  des campagne ayant une priorité haute.';
$GLOBALS['strTargetLimitAdviews']		= 'Limiter le nombre d\'affichages à ';
$GLOBALS['strTargetPerDay']			= 'par jour.';
$GLOBALS['strPriorityAutoTargeting']		= 'Automatique - Distribue l\'inventaire restant uniformément sur les jours restants.';
$GLOBALS['strCampaignWarningNoWeight']		= 'La priorité de cette campagne a été réglée trop basse, ' . "\n" . 'mais le poids est à zéro, ou n\'a pas été spécifié. ' . "\n" . 'Cela va entrainer la désactivation de la campagne, et ses bannières ne seront pas affichées ' . "\n" . 'avant que le poids spécifié ne soit valide. ' . "\n\n" . 'Etes vous sur de vouloir continuer ?';
$GLOBALS['strCampaignWarningNoTarget']		= 'La priorité de cette campagne a été déclarée Contractuelle,
mais la limite quotidienne n\'a pas été spécifiée.
Cela provoquera la désactivation de la campagne et
ses bannières ne seront pas distribuées jusqu\'à ce qu\'une
limite quotidienne correcte ait une valeur correcte.

Êtes-vous certain de vouloir continuer ?';


// Banners (General)
$GLOBALS['strBanner'] 				= 'Bannière';
$GLOBALS['strBanners'] 				= 'Bannières';
$GLOBALS['strAddBanner'] 			= 'Ajouter une nouvelle bannière';
$GLOBALS['strAddBanner_Key'] 			= 'Ajouter une <u>n</u>ouvelle bannière';
$GLOBALS['strModifyBanner'] 			= 'Modifier la bannière';
$GLOBALS['strActiveBanners'] 			= 'Bannières actives';
$GLOBALS['strTotalBanners'] 			= 'Total de bannières';
$GLOBALS['strShowBanner']			= 'Afficher la bannière';
$GLOBALS['strShowAllBanners']	 		= 'Voir toutes les bannières';
$GLOBALS['strShowBannersNoAdClicks']		= 'Afficher les bannières n\'ayant pas été cliquées';
$GLOBALS['strShowBannersNoAdViews']		= 'Afficher les bannières n\'ayant pas été affichées';
$GLOBALS['strDeleteAllBanners']			= 'Supprimer toutes les bannières';
$GLOBALS['strActivateAllBanners']		= 'Activer toutes les bannières';
$GLOBALS['strDeactivateAllBanners']		= 'Désactiver toutes les bannières';
$GLOBALS['strBannerOverview']			= 'Vue d\'ensemble des bannières';
$GLOBALS['strBannerProperties']			= 'Propriétés de la bannière';
$GLOBALS['strBannerHistory']			= 'Historique de la bannière';
$GLOBALS['strBannerNoStats'] 			= 'Aucune statistique n\'est actuellement disponible pour cette bannière.';
$GLOBALS['strNoBanners']			= 'Il n\'y a actuellement aucune bannière définie pour cette campagne.';
$GLOBALS['strConfirmDeleteBanner']		= 'Voulez-vous vraiment supprimer cette bannière ?';
$GLOBALS['strConfirmDeleteAllBanners']		= 'Voulez-vous vraiment supprimer toute les bannières de cette campagne ?';
$GLOBALS['strConfirmResetBannerStats']		= 'Souhaitez-vous supprimer les statistiques liées à cette bannière ?';
$GLOBALS['strShowParentCampaigns']		= 'Afficher les campagnes parentes';
$GLOBALS['strHideParentCampaigns']		= 'Masquer les campagnes parentes';
$GLOBALS['strHideInactiveBanners']		= 'Masquer les bannières inactives';
$GLOBALS['strInactiveBannersHidden']		= 'bannière(s) inactive(s) masquée(s)';
$GLOBALS['strAppendOthers']			= 'Suffixer d\'autres bannières';
$GLOBALS['strAppendTextAdNotPossible']		= 'Il n\'est pas possible d\'ajouter d\'autre bannières à une publicité textuelle.';


// Banner (Properties)
$GLOBALS['strChooseBanner'] 			= 'Veuillez chosir le type de bannière';
$GLOBALS['strMySQLBanner'] 			= 'Envoyer une bannière locale vers la base de données';
$GLOBALS['strWebBanner'] 			= 'Envoyer une bannière locale vers le serveur web';
$GLOBALS['strURLBanner'] 			= 'Lier une bannière externe';
$GLOBALS['strHTMLBanner'] 			= 'Créer une bannière HTML';
$GLOBALS['strTextBanner'] 			= 'Créer une bannière textuelle';
$GLOBALS['strAutoChangeHTML']			= 'Modifier le code HTML pour activer le suivi des clics';
$GLOBALS['strUploadOrKeep']			= 'Voulez-vous garder votre <br />image existante, ou <br />en télécharger une autre ?';
$GLOBALS['strNewBannerFile'] 			= 'Sélectionnez l\'image que vous souhaitez <br />utiliser pour cette bannière<br /><br />';
$GLOBALS['strNewBannerURL'] 			= 'URL de l\'image (incluant http://)';
$GLOBALS['strURL'] 				= 'URL de destination (incluant http://)';
$GLOBALS['strHTML'] 				= 'HTML';
$GLOBALS['strTextBelow'] 			= 'Texte en dessous de l\'image';
$GLOBALS['strKeyword'] 				= 'Mots-clés';
$GLOBALS['strWeight'] 				= 'Poids';
$GLOBALS['strAlt'] 				= 'Texte de l\'attribut Alt';
$GLOBALS['strStatusText']			= 'Texte affiché dans la barre d\'état';
$GLOBALS['strBannerWeight']			= 'Poids de la bannière';


// Banner (swf)
$GLOBALS['strCheckSWF']				= 'Vérifier la présence de liens codés en dur dans le fichier Flash';
$GLOBALS['strConvertSWFLinks']			= 'Convertir les liens Flash';
$GLOBALS['strHardcodedLinks']			= 'Liens codés en dur';
$GLOBALS['strConvertSWF']			= '<br />Le fichier Flash que vous venez de télécharger contient des URLs codées en dur. ". '.MAX_PRODUCT_NAME.' ." ne sera pas capable de suivre le nombre de clics pour cette bannière à moins de convertir les URLs en dur. Vous trouverez ci-dessous la liste des URLs de ce fichier Flash. Si vous souhaitez convertir ces URLs, cliquez sur <b>Convertir</b>, sinon cliquez sur <b>Annuler</b>.<br /><br />Note : si vous cliquez sur <b>Convertir</b> le fichier Flash que vous avez téléchargé sera modifié. <br />Veuillez conserver une sauvegarde du fichier original. Quelle que soit la version utilisée pour la création de cette bannière, le fichier résultant nécessitera Flash Player 4 (ou plus récent) pour être affiché correctement.<br /><br />';
$GLOBALS['strCompressSWF']			= 'Compresser le fichier SWF pour un téléchargement plus rapide (Flash Player 6 requis)';
$GLOBALS['strOverwriteSource']			= 'Écraser le paramètre source';


// Banner (network)
$GLOBALS['strBannerNetwork']			= 'Bannière HTML avec modèle';
$GLOBALS['strChooseNetwork']			= 'Choisissez le modèle que vous souhaitez utiliser';
$GLOBALS['strMoreInformation']			= 'Plus d\'informations ...';
$GLOBALS['strRichMedia']			= 'Média riche';
$GLOBALS['strTrackAdClicks']			= 'Comptabiliser les clics';


// Display limitations
$GLOBALS['strModifyBannerAcl']			= 'Options de distribution';
$GLOBALS['strACL'] 				= 'Distribution';
$GLOBALS['strACLAdd'] 				= 'Ajouter une limitation de distribution';
$GLOBALS['strACLAdd_Key']			= 'Ajouter une <u>n</u>ouvelle limitation';
$GLOBALS['strNoLimitations']			= 'Aucune limitation';
$GLOBALS['strApplyLimitationsTo']		= 'Appliquer les limitations à';
$GLOBALS['strRemoveAllLimitations']		= 'Supprimer toutes les limitations';
$GLOBALS['strEqualTo']				= 'est égal à';
$GLOBALS['strDifferentFrom']			= 'est différent de';
$GLOBALS['strLaterThan']			= 'est plus tard que';
$GLOBALS['strLaterThanOrEqual']			= 'est plus tard que ou égal à';
$GLOBALS['strEarlierThan']			= 'est plus tôt que';
$GLOBALS['strEarlierThanOrEqual']		= 'est plus tôt que ou égal à';
$GLOBALS['strContains']				= 'contient';
$GLOBALS['strNotContains']			= 'ne contient pas';
$GLOBALS['strAND']				= 'ET';  						// logical operator
$GLOBALS['strOR']				= 'OU'; 						// logical operator
$GLOBALS['strOnlyDisplayWhen']			= 'Afficher seulement cette bannière quand :';
$GLOBALS['strWeekDay'] 				= 'Jour de la semaine';
$GLOBALS['strTime'] 				= 'Temps';
$GLOBALS['strUserAgent'] 			= 'L\'agent utilisateur';
$GLOBALS['strDomain'] 				= 'Le domaine';
$GLOBALS['strClientIP'] 			= 'L\'IP du visiteur';
$GLOBALS['strSource'] 				= 'Source';
$GLOBALS['strBrowser'] 				= 'Le navigateur';
$GLOBALS['strOS'] 				= 'Le système d\'exploitation';
$GLOBALS['strReferer'] 				= 'Page d\'origine';
$GLOBALS['strCountry'] 				= 'Pays';
$GLOBALS['strContinent'] 			= 'Le continent';
$GLOBALS['strDeliveryLimitations']		= 'Limitations de distribution';
$GLOBALS['strDeliveryCapping']			= 'Capping de distribution par visiteur';
$GLOBALS['strTimeCapping']			= 'Une fois affichée, l\'utilisateur ne devra plus avoir cette bannière pendant :';
$GLOBALS['strImpressionCapping']		= 'Cette bannière ne sera pas vue par un utilisateur plus de :';


// Publisher
$GLOBALS['strAffiliate']			= 'Site web';
$GLOBALS['strAffiliates']			= 'Sites web';
$GLOBALS['strAffiliatesAndZones']		= 'Sites web & Zones';
$GLOBALS['strAddNewAffiliate']			= 'Ajouter un nouveau site web';
$GLOBALS['strAddNewAffiliate_Key']		= 'Ajouter un <u>n</u>ouveau site web';
$GLOBALS['strAddAffiliate']			= 'Créer un site web';
$GLOBALS['strAffiliateProperties']		= 'Propriétés du site web';
$GLOBALS['strAffiliateOverview']		= 'Vue d\'ensemble des sites web';
$GLOBALS['strAffiliateHistory']			= 'Historique du site web';
$GLOBALS['strZonesWithoutAffiliate']		= 'Zones sans site web';
$GLOBALS['strMoveToNewAffiliate']		= 'Déplacer vers un nouveau site web';
$GLOBALS['strNoAffiliates']			= 'Il n\'y a actuellement aucun site web défini. Pour créer une zone, commencez par <a href=\'affiliate-edit.php\'>ajouter un nouveau site web</a>.';
$GLOBALS['strConfirmDeleteAffiliate']		= 'Voulez-vous vraiment supprimer ce site web ?';
$GLOBALS['strMakePublisherPublic']		= 'Rendre les zones détenues par ce site web disponibles à tous';


// Publisher (properties)
$GLOBALS['strWebsite']				= 'Site web';
$GLOBALS['strAllowAffiliateModifyInfo'] 	= 'Autoriser cet utilisateur à modifier ses propres paramètres';
$GLOBALS['strAllowAffiliateModifyZones'] 	= 'Autoriser cet utilisateur à modifier ses propres zones';
$GLOBALS['strAllowAffiliateLinkBanners'] 	= 'Autoriser cet utilisateur à lier des bannières à ses propres zones';
$GLOBALS['strAllowAffiliateAddZone']		= 'Autoriser cet utilisateur à définir de nouvelles zones';
$GLOBALS['strAllowAffiliateDeleteZone'] 	= 'Autoriser cet utilisateur à supprimer les zones existantes';


// Zone
$GLOBALS['strZone']				= 'Zone';
$GLOBALS['strZones']				= 'Zones';
$GLOBALS['strAddNewZone']			= 'Ajouter une nouvelle zone';
$GLOBALS['strAddNewZone_Key']			= 'Ajouter une <u>n</u>ouvelle zone';
$GLOBALS['strAddZone']				= 'Créer une zone';
$GLOBALS['strModifyZone']			= 'Modifier la zone';
$GLOBALS['strLinkedZones']			= 'Zones liées';
$GLOBALS['strZoneOverview']			= 'Vue d\'ensemble des zones';
$GLOBALS['strZoneProperties']			= 'Propriétés de la zone';
$GLOBALS['strZoneHistory']			= 'Historique de la zone';
$GLOBALS['strNoZones']				= 'Il n\'y actuellement aucune zone définie pour ce site web.';
$GLOBALS['strConfirmDeleteZone']		= 'Voulez-vous vraiment supprimer cette zone ?';
$GLOBALS['strZoneType']				= 'Type de zone';
$GLOBALS['strBannerButtonRectangle']		= 'Bannière, bouton ou rectangle';
$GLOBALS['strInterstitial']			= 'Interstitiel ou flottant DHTML';
$GLOBALS['strPopup']				= 'Popup';
$GLOBALS['strTextAdZone']			= 'Publicité textuelle';
$GLOBALS['strShowMatchingBanners']		= 'Afficher les bannières correspondantes';
$GLOBALS['strHideMatchingBanners']		= 'Masquer les bannières correspondantes';


// Advanced zone settings
$GLOBALS['strAdvanced']				= 'Avancé';
$GLOBALS['strChains']				= 'Chaînes';
$GLOBALS['strChainSettings']			= 'Paramètres d\'enchaînement';
$GLOBALS['strZoneNoDelivery']			= 'Si aucune bannière de cette zone <br />ne peut être distribuée, essayer de...';
$GLOBALS['strZoneStopDelivery']			= 'Arrêter la distribution et ne plus afficher de bannière';
$GLOBALS['strZoneOtherZone']			= 'Afficher la zone sélectionnée à la place';
$GLOBALS['strZoneUseKeywords']			= 'Sélectionnez une bannière en utilisant les mots clés spécifiés ci-dessous ';
$GLOBALS['strZoneAppend']			= 'Toujour ajouter le code HTML suivant aux bannières affichées dans cette zone';
$GLOBALS['strAppendSettings']			= 'Paramètres des ajouts (avant et après)';
$GLOBALS['strZonePrependHTML']			= 'Toujours ajouter le code HTML avant les publicités textuelles affichées dans cette zone';
$GLOBALS['strZoneAppendHTML']			= 'Toujours ajouter le code HTML après les publicités textuelles affichées dans cette zone';
$GLOBALS['strZoneAppendType']                   = 'Type d\'ajout';
$GLOBALS['strZoneAppendHTMLCode']               = 'Code HTML';
$GLOBALS['strZoneAppendZoneSelection']  	= 'Popup ou insterstitiel';
$GLOBALS['strZoneAppendSelectZone']             = 'Toujours ajouter le popup ou l\'interstitiel suivant aux bannières affichées dans cette zone';

// Zone probability
$GLOBALS['strZoneProbListChain']		= 'Toutes les bannières liées à la zone sélectionnée sont actuellement inactives. <br />Voici la zone enchaînée qui doit suivre :';
$GLOBALS['strZoneProbNullPri']			= 'Il n\'y a aucune bannière active liée à cette zone.';
$GLOBALS['strZoneProbListChainLoop']		= 'Suivre la zone enchaînée provoquerait une boucle sans fin. La distribution de cette zone est stoppée.';

// Linked banners/campaigns
$GLOBALS['strSelectZoneType']			= 'Veuillez choisir ce que vous voulez lier à cette zone';
$GLOBALS['strBannerSelection']			= 'Sélection des bannières';
$GLOBALS['strCampaignSelection']		= 'Sélection des campagnes';
$GLOBALS['strInteractive']			= 'Interactif';
$GLOBALS['strRawQueryString']			= 'Mot-clé';
$GLOBALS['strIncludedBanners']			= 'Bannières liées';
$GLOBALS['strLinkedBannersOverview']		= 'Aperçu des bannières liées';
$GLOBALS['strLinkedBannerHistory']		= 'Historique des bannières liées';
$GLOBALS['strNoZonesToLink']			= 'Il n\'y a aucune zone disponible à laquelle lier cette bannière';
$GLOBALS['strNoBannersToLink']			= 'Aucune bannière ne peut être liée à cette zone.';
$GLOBALS['strNoLinkedBanners']			= 'Aucune bannière n\'est liée à cette zone.';
$GLOBALS['strMatchingBanners']			= '{count} bannière(s) correspondante(s)';
$GLOBALS['strNoCampaignsToLink']		= 'Il n\'y a actuellement aucune campagne disponible à laquelle lier cette zone';
$GLOBALS['strNoZonesToLinkToCampaign']  	= 'Il n\'y a aucune zone disponible à laquelle lier cette campagne';
$GLOBALS['strSelectBannerToLink']		= 'Sélectionnez la bannière que vous souhaitez lier à cette zone :';
$GLOBALS['strSelectCampaignToLink']		= 'Sélectionnez la campagne que vous souhaitez lier à cette zone :';


// Statistics
$GLOBALS['strStats'] 				= 'Statistiques';
$GLOBALS['strNoStats']				= 'Il n\'y a actuellement aucunes statistiques disponibles';
$GLOBALS['strConfirmResetStats']		= 'Souaitez-vous supprimer l\'intégralité des statistiques ?';
$GLOBALS['strGlobalHistory']			= 'Historique global';
$GLOBALS['strDailyHistory']			= 'Historique quotidien';
$GLOBALS['strDailyStats'] 			= 'Statistiques quotidiennes';
$GLOBALS['strWeeklyHistory']			= 'Historique hebdomadaire';
$GLOBALS['strMonthlyHistory']			= 'Historique mensuel';
$GLOBALS['strCreditStats'] 			= 'Statistiques de crédits';
$GLOBALS['strDetailStats'] 			= 'Statistiques détaillées';
$GLOBALS['strTotalThisPeriod']			= 'Total de cette période';
$GLOBALS['strAverageThisPeriod']		= 'Moyenne pour cette période';
$GLOBALS['strDistribution']			= 'Répartition';
$GLOBALS['strResetStats'] 			= 'Réinitialiser les statistiques';
$GLOBALS['strSourceStats']			= 'Statistiques des sources';
$GLOBALS['strSelectSource']			= 'Sélectionnez la source que vous souhaitez voir:';
$GLOBALS['strSizeDistribution']			= 'Répartition par taille';
$GLOBALS['strCountryDistribution']		= 'Répartition par pays';
$GLOBALS['strEffectivity']			= 'Effectivité';
$GLOBALS['strTargetStats']			= 'Statistiques de ciblage';
$GLOBALS['strCampaignTarget']			= 'Objectif';
$GLOBALS['strTargetRatio']			= 'Ratio d\'objectif';
$GLOBALS['strTargetModifiedDay']		= 'Les objectifs ayant été modifiés durant la journée, les prévisions pourraient ne pas être fiables.';
$GLOBALS['strTargetModifiedWeek']		= 'Les objectifs ayant été modifiés durant la semaine, les prévisions pourraient ne pas être fiables.';
$GLOBALS['strTargetModifiedMonth']		= 'Les objectifs ayant été modifiés durant le mois, les prévisions pourraient ne pas être fiables.';
$GLOBALS['strNoTargetStats']			= 'Aucune statistique n\'est disponible pour les prévisions et les objectifs.';

// Hosts
$GLOBALS['strHosts']				= 'Hôtes';
$GLOBALS['strTopHosts']				= 'Classement des hôtes';
$GLOBALS['strTopCountries']			= 'Classement des pays';
$GLOBALS['strRecentHosts'] 			= 'Hôtes les plus récents';


// Expiration
$GLOBALS['strExpired']				= 'Expiré';
$GLOBALS['strExpiration'] 			= 'Expiration';
$GLOBALS['strNoExpiration'] 			= 'Aucune date d\'expiration définie';
$GLOBALS['strEstimated'] 			= 'Date d\'expiration estimée';


// Reports
$GLOBALS['strReports']				= 'Rapports';
$GLOBALS['strSelectReport']			= 'Rapport à générer';


// Userlog
$GLOBALS['strUserLog']				= 'Journal de l\'utilisateur';
$GLOBALS['strUserLogDetails']			= 'Détails du journal utilisateur';
$GLOBALS['strDeleteLog']			= 'Supprimer le journal';
$GLOBALS['strAction']				= 'Action';
$GLOBALS['strNoActionsLogged']			= 'Aucune action enregistrée';


// Code generation
$GLOBALS['strGenerateBannercode']               = 'Sélection directe';
$GLOBALS['strChooseInvocationType']		= 'Veuillez choisir le type d\'invocation de bannières';
$GLOBALS['strGenerate']				= 'Générer';
$GLOBALS['strParameters']			= 'Paramètres du tag';
$GLOBALS['strFrameSize']			= 'Taille du cadre';
$GLOBALS['strBannercode']			= 'Code de la bannière';
$GLOBALS['strOptional']                         = 'optionnel';

// Errors
$GLOBALS['strMySQLError'] 			= 'Erreur SQL :';
$GLOBALS['strLogErrorClients']			= '[phpAds] Une erreur s\'est produite pendant l\'analyse des annonceurs dans la base de données.';
$GLOBALS['strLogErrorBanners']			= '[phpAds] Une erreur s\'est produite pendant l\'analyse des bannières dans la base de données.';
$GLOBALS['strLogErrorViews'] 			= '[phpAds] Une erreur s\'est produite pendant l\'analyse des impressions dans la base de données.';
$GLOBALS['strLogErrorClicks']			= '[phpAds] Une erreur s\'est produite pendant l\'analyse des clics dans la base de données.';
$GLOBALS['strErrorViews'] 			= 'Vous devez indiquer le nombre d\'affichages ou cocher la case \'illimité\' !';
$GLOBALS['strErrorNegViews'] 			= 'Nombre d\'affichage négatif non autorisé';
$GLOBALS['strErrorClicks'] 			= 'Vous devez indiquer le nombre de clics ou cocher la case \'illimité\' !';
$GLOBALS['strErrorNegClicks']			= 'Nombre de clics négatif non autorisé';
$GLOBALS['strNoMatchesFound']			= 'Aucun résultat correspondant trouvé';
$GLOBALS['strErrorOccurred']			= 'Une erreur est survenue';
$GLOBALS['strErrorUploadSecurity']		= 'Détection d\'un possible problème de sécurité, téléchargement stoppé !';
$GLOBALS['strErrorUploadBasedir']		= MAX_PRODUCT_NAME .' ne peut accéder au fichier envoyé; cela est probablement dû au mode de sécurité PHP (safemode), ou d\'une restriction de la fonction \'open_basedir\'.';
$GLOBALS['strErrorUploadUnknown']		= MAX_PRODUCT_NAME .' ne peut accéder au fichier envoyé, et ce pour une raison inconnue. Veuillez vérifier votre configuration PHP.';
$GLOBALS['strErrorStoreLocal']			= 'Une erreur est survenue lors de la copie de la bannière dans le répertoire local. Cela est probablement dû à une mauvaise configuration des paramètres du répertoire local';
$GLOBALS['strErrorStoreFTP']			= 'Une erreur est survenue lors de la copie de la bannière sur le serveur FTP. Cela est probablement dû à l\'indisponibilité du serveur FTP, ou à une mauvaise configuration des paramètres du serveur FTP.';
$GLOBALS['strErrorDBPlain']			= 'Une erreur est survenue lors de l\'accès à la base de données';
$GLOBALS['strErrorDBSerious']			= 'Un problème sérieux avec la base de données a été détecté';
$GLOBALS['strErrorDBNoDataPlain']		= 'En raison d\'un problème avec la base de données, \". '.MAX_PRODUCT_NAME.' .\" n\'a pas pu récupérer ou stocker de données. ';
$GLOBALS['strErrorDBNoDataSerious']		= 'En raison d\'un sérieux problème avec la base de données, \". '.MAX_PRODUCT_NAME.' .\" n\'a pas pu récupérer de données';
$GLOBALS['strErrorDBCorrupt']			= 'La table de la base de données est sans doute corrompue et a besoin d\'être réparée. Pour plus d\'informations concernant la réparation de tables corrompues veuillez lire le chapitre ';
$GLOBALS['strErrorDBContact']			= 'Veuillez contacter l\'administrateur de ce serveur et l\'informer du problème.';
$GLOBALS['strErrorDBSubmitBug']			= 'Si ce problème peut être reproduit, il doit être causé par un bug dans \". '.MAX_PRODUCT_NAME.' .\". Veuillez rapporter les informations suivantes aux créateurs d\'\". '.MAX_PRODUCT_NAME.' .\". Essayez aussi de décrire les actions qui ont mené à cette erreur aussi clairement que possible.';
$GLOBALS['strMaintenanceNotActive']             = 'Le script de maintenance n\'a pas été exécuté au cours des dernières 24 heures.
Pour que \". '.MAX_PRODUCT_NAME.' .\" fonctionne correctement, il doit être exécuté
toutes les heures.

Veuillez lire le guide de l\'administrateur pour plus d\'informations
concernant la configuration du script de maintenance.';

// E-mail
$GLOBALS['strMailSubject'] 			= 'Rapport de l\'annonceur';
$GLOBALS['strAdReportSent']			= 'Rapport envoyé';
$GLOBALS['strMailSubjectDeleted'] 		= 'Publicités désactivées';
$GLOBALS['strMailHeader'] 			= 'Cher {contact},' . "\n";
$GLOBALS['strMailBannerStats']			= 'Vous trouverez ci-dessous les statistiques de bannières pour {clientname} :';
$GLOBALS['strMailFooter'] 			= 'Cordialement,
   {adminfullname}';
$GLOBALS['strMailClientDeactivated']		= 'Vos bannières suivantes ont été désactivés car';
$GLOBALS['strMailNothingLeft']			= "\n" .'Si vous souhaitez prolonger votre présence publicitaire sur notre site, nous vous remercions de bien vouloir nous contacter. Nous serions heureux de continuer avec vous.';
$GLOBALS['strClientDeactivated']		= 'Cette campagne est actuellement inactive parce que';
$GLOBALS['strBeforeActivate']			= 'la date d\'activation n\'a pas encore été atteinte';
$GLOBALS['strAfterExpire']			= 'la date d\'expiration a été atteinte';
$GLOBALS['strNoMoreClicks']			= 'il ne reste plus de clics';
$GLOBALS['strNoMoreViews']			= 'le nombre d\'affichages souhaités a été atteint';
$GLOBALS['strWeightIsNull']			= 'son poids est réglé à 0';
$GLOBALS['strWarnClientTxt']			= 'Les impressions, clics ou conversions restants pour vos bannières sont en-dessous de {limit}.
Vos bannières seront désactivées quand il ne restera plus d\'impressions, clics ou conversions. ';
$GLOBALS['strImpressionsClicksLow']			= 'Affichages et Clics sont bas';
$GLOBALS['strNoViewLoggedInInterval']   	= 'Aucune impression n\'a été enregistrée pendant la période définie pour ce rapport';
$GLOBALS['strNoClickLoggedInInterval']  	= 'Aucun clic n\'a été enregistré pendant la période définie pour ce rapport';
$GLOBALS['strMailReportPeriod']			= 'Ce rapport inclut les statistiques du {startdate} au {enddate}.';
$GLOBALS['strMailReportPeriodAll']		= 'Ce rapport inclut toutes les statistiques jusqu\'au {enddate}.';
$GLOBALS['strNoStatsForCampaign'] 		= 'Il n\'y a aucunes statistiques disponibles pour cette campagne';


// Priority
$GLOBALS['strPriority']				= 'Priorité';


// Settings
$GLOBALS['strSettings'] 			= 'Paramètres';
$GLOBALS['strGeneralSettings']			= 'Paramètres généraux';
$GLOBALS['strMainSettings']			= 'Paramètres principaux';
$GLOBALS['strAdminSettings']			= 'Paramètres d\'administration';


// Product Updates
$GLOBALS['strProductUpdates']			= 'Mises à jour du produit';




/*********************************************************/
/* Keyboard shortcut assignments                         */
/*********************************************************/


// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome']				= 'h'; //a 'Accueil' ??
$GLOBALS['keyUp']				= 'u'; //H 'Haut', or M 'Monter' ??
$GLOBALS['keyNextItem']				= '.';
$GLOBALS['keyPreviousItem']			= ',';
$GLOBALS['keyList']				= 'l';


// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch']				= 'r';
$GLOBALS['keyCollapseAll']			= 't';
$GLOBALS['keyExpandAll']			= 'd';
$GLOBALS['keyAddNew']				= 'n';
$GLOBALS['keyNext']				= 's';
$GLOBALS['keyPrevious']				= 'p';


// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strStartOver'] = "Recommencer";
$GLOBALS['strTrackerVariables'] = "Variables du suiveur";
$GLOBALS['strLogoutURL'] = "URL de redirection après deconnexion. <br />Vide par défaut";
$GLOBALS['strAppendTrackerCode'] = "Ajouter un code de suivi";
$GLOBALS['strStatusDuplicate'] = "Dupliquer";
$GLOBALS['strPriorityOptimisation'] = "Divers";
$GLOBALS['strCollectedAllStats'] = "Toutes les statistiques";
$GLOBALS['strCollectedToday'] = "Aujourd'hui";
$GLOBALS['strCollectedYesterday'] = "Hier";
$GLOBALS['strCollectedThisWeek'] = "Cette semaine";
$GLOBALS['strCollectedLastWeek'] = "La semaine dernière";
$GLOBALS['strCollectedThisMonth'] = "Ce mois-ci";
$GLOBALS['strCollectedLastMonth'] = "Le mois dernier";
$GLOBALS['strCollectedLast7Days'] = "Les 7 derniers jours";
$GLOBALS['strCollectedSpecificDates'] = "Dates spécifiques";
$GLOBALS['strAdmin'] = "Admin";
$GLOBALS['strNotice'] = "Note";
$GLOBALS['strPriorityLevel'] = "Niveau de priorité";
$GLOBALS['strPriorityTargeting'] = "Distribution";
$GLOBALS['strExclusiveAds'] = "Publicités sous contrat exclusif";
$GLOBALS['strHighAds'] = "Publicités sous contrat";
$GLOBALS['strLowAds'] = "Publicités restantes";
$GLOBALS['strLimitations'] = "Limitations";
$GLOBALS['strCapping'] = "Capping";
$GLOBALS['strVariableDescription'] = "Description";
$GLOBALS['strVariables'] = "Variables";
$GLOBALS['strStatsVariables'] = "Variables";
$GLOBALS['strComments'] = "Commentaires";
$GLOBALS['strUsernameOrPasswordWrong'] = "L'identifiant et/ou le mot de passe sont incorrects. Veuillez réessayer.";
$GLOBALS['strDuplicateAgencyName'] = "L'identifiant que vous avez entré existe déjà, veuillez en choisir un autre.";
$GLOBALS['strTotalConversions'] = "Total de conversions";
$GLOBALS['strConversionCredits'] = "Crédit de conversions";
$GLOBALS['strDateTime'] = "Date et heure";
$GLOBALS['strTrackerID'] = "ID du traceur";
$GLOBALS['strTrackerName'] = "Nom du traceur";
$GLOBALS['strCampaignID'] = "ID de la campagne";
$GLOBALS['strCampaignName'] = "Nom de la campagne";
$GLOBALS['strStatsAction'] = "Action";
$GLOBALS['strWindowDelay'] = "Temps d'affichage";
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Location mensuelle";
$GLOBALS['strBreakdownByDay'] = "Jour";
$GLOBALS['strBreakdownByWeek'] = "Semaine";
$GLOBALS['strSingleMonth'] = "Mois";
$GLOBALS['strBreakdownByMonth'] = "Mois";
$GLOBALS['strDayOfWeek'] = "Jour de la semaine";
$GLOBALS['strBreakdownByDow'] = "Jour de la semaine";
$GLOBALS['strBreakdownByHour'] = "Heure";
$GLOBALS['strHiddenAdvertiser'] = "Annonceur";
$GLOBALS['strChars'] = "caractères";
$GLOBALS['strAllowClientViewTargetingStats'] = "Autoriser cet utilisateur à consulter les statistiques de ciblage";
$GLOBALS['strCsvImportConversions'] = "Autoriser cet utilisateur à importer les conversions hors ligne";
$GLOBALS['strHiddenCampaign'] = "Campagne";
$GLOBALS['strLinkedCampaigns'] = "Campagnes liées";
$GLOBALS['strShowParentAdvertisers'] = "Afficher les annonceurs parents";
$GLOBALS['strHideParentAdvertisers'] = "Masquer les annonceurs parents";
$GLOBALS['strContractDetails'] = "Détails du contrat";
$GLOBALS['strInventoryDetails'] = "Détails de l'inventaire";
$GLOBALS['strPriorityInformation'] = "Priorité par rapport aux autres campagnes";
$GLOBALS['strPriorityExclusive'] = "Prioritaire par rapport aux autres campagnes non exclusives";
$GLOBALS['strPriorityHigh'] = "\- Campagnes payées";
$GLOBALS['strPriorityLow'] = "\- Campagnes personnelles et impayées";
$GLOBALS['strHiddenAd'] = "Publicité";
$GLOBALS['strHiddenTracker'] = "Suiveur";
$GLOBALS['strTracker'] = "Suiveur";
$GLOBALS['strHiddenZone'] = "Zone";
$GLOBALS['strCompanionPositioning'] = "Positionnement accompagné";
$GLOBALS['strSelectUnselectAll'] = "Sélectionner / désélectionner tout";
$GLOBALS['strExclusive'] = "Exclusif";
$GLOBALS['strExpirationDateComment'] = "La campagne finira à la fin de ce jour";
$GLOBALS['strActivationDateComment'] = "La campagne commencera au début de ce jour";
$GLOBALS['strRevenueInfo'] = "Informations de recettes";
$GLOBALS['strImpressionsRemaining'] = "Impressions restantes";
$GLOBALS['strClicksRemaining'] = "Clics restants";
$GLOBALS['strConversionsRemaining'] = "Conversions restantes";
$GLOBALS['strImpressionsBooked'] = "Impressions réservées";
$GLOBALS['strClicksBooked'] = "Clics réservés";
$GLOBALS['strConversionsBooked'] = "Conversions réservées";
$GLOBALS['strOptimise'] = "Optimiser";
$GLOBALS['strAnonymous'] = "Masquer l'annonceur et les sites web de cette campagne.";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "Le type de cette campagne a été déclaré Autre, \nmais son poids est nul ou n'a pas été \nspécifié. Cela provoquera la désactivation de la \ncampagne et ses bannières ne seront pas distribuées\njusqu'à ce que le poids ait une valeur correcte. \n\nÊtes-vous certain de vouloir continuer ?";
$GLOBALS['strCampaignWarningExclusiveNoWeight'] = "Le type de cette campagne a été déclaré Exclusive, \nmais son poids est nul ou n'a pas été \nspécifié. Cela provoquera la désactivation de la \ncampagne et ses bannières ne seront pas distribuées\njusqu'à ce que le poids ait une valeur correcte. \n\nÊtes-vous certain de vouloir continuer ?";
$GLOBALS['strTrackerOverview'] = "Vue d'ensemble des traceurs";
$GLOBALS['strAddTracker'] = "Ajouter un nouveau traceur";
$GLOBALS['strAddTracker_Key'] = "<u>A</u>jouter un nouveau traceur";
$GLOBALS['strNoTrackers'] = "Il n'y a actuellement aucun traceur défini pour cet annonceur";
$GLOBALS['strConfirmDeleteAllTrackers'] = "Voulez-vous vraiment supprimer tous les traceurs de cet annonceur ?";
$GLOBALS['strConfirmDeleteTracker'] = "Voulez-vous vraiment supprimer ce traceur ?";
$GLOBALS['strDeleteAllTrackers'] = "Supprimer tous les traceurs";
$GLOBALS['strTrackerProperties'] = "Propriétés du traceur";
$GLOBALS['strModifyTracker'] = "Modifier le traceur";
$GLOBALS['strLog'] = "Journaliser ?";
$GLOBALS['strDefaultStatus'] = "État par défaut";
$GLOBALS['strStatus'] = "État";
$GLOBALS['strLinkedTrackers'] = "Traceurs liés";
$GLOBALS['strConversionWindow'] = "Fenêtre de conversion";
$GLOBALS['strUniqueWindow'] = "Fenêtre unique";
$GLOBALS['strClick'] = "Clic";
$GLOBALS['strView'] = "Affichage";
$GLOBALS['strLinkCampaignsByDefault'] = "Lier les nouvelles campagnes créées par défaut";
$GLOBALS['strConversionType'] = "Type de conversion";
$GLOBALS['strWarningMissing'] = "Attention, il manque peut-être";
$GLOBALS['strWarningMissingClosing'] = "balise HTML fermante '>'";
$GLOBALS['strWarningMissingOpening'] = "balise HTML ouvrante '<'";
$GLOBALS['strSubmitAnyway'] = "Soumettre tout de même";
$GLOBALS['strUploadOrKeepAlt'] = "Voulez-vous garder votre <br />image existante, ou <br />en télécharger une autre ?";
$GLOBALS['strNewBannerFileAlt'] = "Sélectionnez une image de secours <br />à utiliser si les navigateurs<br />ne supportent pas le rich media<br /><br />";
$GLOBALS['strAdserverTypeGeneric'] = "Bannière HTML générique";
$GLOBALS['strGenericOutputAdServer'] = "Générique";
$GLOBALS['strGeneric'] = "Générique";
$GLOBALS['strSwfTransparency'] = "Autoriser un arrière-plan transparent";
$GLOBALS['strChannelLimitations'] = "Options de distribution";
$GLOBALS['strGreaterThan'] = "est plus grand que";
$GLOBALS['strLessThan'] = "est plus petit que";
$GLOBALS['strWeekDays'] = "Jours de la semaine";
$GLOBALS['strCity'] = "Ville";
$GLOBALS['strDeliveryCappingReset'] = "Réinitialiser les compteurs d'affichages après :";
$GLOBALS['strDeliveryCappingTotal'] = "au total";
$GLOBALS['strDeliveryCappingSession'] = "par session";
$GLOBALS['strAffiliateInvocation'] = "Code d'invocation";
$GLOBALS['strTotalAffiliates'] = "Total de sites web";
$GLOBALS['strInactiveAffiliatesHidden'] = "site(s) web inactif(s) masqué(s)";
$GLOBALS['strShowParentAffiliates'] = "Afficher les sites web parents";
$GLOBALS['strHideParentAffiliates'] = "Masquer les sites web parents";
$GLOBALS['strMnemonic'] = "Mnémotechnique";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Autoriser cet utilisateur à générer le code d'invocation";
$GLOBALS['strAllowAffiliateZoneStats'] = "Autoriser cet utilisateur à afficher les statistiques des zones";
$GLOBALS['strAllowAffiliateApprPendConv'] = "Autoriser cet utilisateur à n'afficher que les conversions approuvées ou en attente";
$GLOBALS['strPaymentInformation'] = "Informations de paiement";
$GLOBALS['strAddress'] = "Adresse";
$GLOBALS['strPostcode'] = "Code postal";
$GLOBALS['strPhone'] = "Téléphone";
$GLOBALS['strFax'] = "Fax";
$GLOBALS['strAccountContact'] = "Contact du compte";
$GLOBALS['strPayeeName'] = "Nom du bénéficiaire";
$GLOBALS['strTaxID'] = "ID de taxe";
$GLOBALS['strModeOfPayment'] = "Moyen de paiement";
$GLOBALS['strPaymentChequeByPost'] = "Chèque postal";
$GLOBALS['strCurrency'] = "Devise";
$GLOBALS['strCurrencyGBP'] = "GBP";
$GLOBALS['strOtherInformation'] = "Autres informations";
$GLOBALS['strUniqueUsersMonth'] = "Visiteurs uniques par mois";
$GLOBALS['strUniqueViewsMonth'] = "Affichages uniques par mois";
$GLOBALS['strPageRank'] = "Pagerank";
$GLOBALS['strCategory'] = "Catégorie";
$GLOBALS['strHelpFile'] = "Fichier d'aide";
$GLOBALS['strEmailAdZone'] = "Zone e-mail/newsletter";
$GLOBALS['strZoneClick'] = "Zone de suivi des clics";
$GLOBALS['strBannerLinkedAds'] = "Bannières liées à la zone";
$GLOBALS['strCampaignLinkedAds'] = "Campagnes liées à la zone";
$GLOBALS['strTotalZones'] = "Total de zones";
$GLOBALS['strCostInfo'] = "Coût média";
$GLOBALS['strTechnologyCost'] = "Coût de la technologie";
$GLOBALS['strInactiveZonesHidden'] = "zone(s) inactive(s) masquée(s)";
$GLOBALS['strWarnChangeZoneType'] = "Changer le type de la zone en texte ou en e-mail détachera toutes les bannières/campagnes à cause des restrictions de ces types de zones\n                                                <ul>\n                                                    <li>Les zones textuelles peuvent seulement être liées à des publicités textuelles</li>\n                                                    <li>Les campagnes des zones e-mail ne peuvent avoir qu'une seule bannière active à la fois</li>\n                                                </ul>";
$GLOBALS['strWarnChangeZoneSize'] = "Changer la taille de la zone va détacher toutes les bannières qui n'auront pas la nouvelle taille, et ajouter les bannières des campagnes liées qui ont cette nouvelle taille";
$GLOBALS['strZoneForecasting'] = "Paramètres de prévision de la zone";
$GLOBALS['strZoneAppendNoBanner'] = "Ajouter même si aucune bannière n'est distribuée";
$GLOBALS['strLinkedBanners'] = "Lier des bannières indivuelles";
$GLOBALS['strCampaignDefaults'] = "Lier des bannières selon la campagne parente";
$GLOBALS['strLinkedCategories'] = "Lier des bannières selon la catégorie";
$GLOBALS['strNoTrackersToLink'] = "Il n'y a actuellement aucun suiveur disponible auquel lier cette campagne";
$GLOBALS['strSelectAdvertiser'] = "Sélectionner l'annonceur";
$GLOBALS['strSelectPlacement'] = "Sélectionner la campagne";
$GLOBALS['strSelectAd'] = "Sélectionne la bannière";
$GLOBALS['strStatusPending'] = "Suspendu";
$GLOBALS['strStatusApproved'] = "Approuvé";
$GLOBALS['strStatusDisapproved'] = "Désappprouvé";
$GLOBALS['strStatusOnHold'] = "En attente";
$GLOBALS['strStatusIgnore'] = "Ignoré";
$GLOBALS['strConnectionType'] = "Type";
$GLOBALS['strType'] = "Type";
$GLOBALS['strConnTypeSale'] = "Vente";
$GLOBALS['strConnTypeLead'] = "Prospect";
$GLOBALS['strConnTypeSignUp'] = "Inscription";
$GLOBALS['strShortcutEditStatuses'] = "Éditer les états";
$GLOBALS['strShortcutShowStatuses'] = "Afficher les états";
$GLOBALS['strNoTargetingStats'] = "Il n'y a actuellement aucunes statistiques de ciblage disponibles";
$GLOBALS['strNoStatsForPeriod'] = "Il n'y actuellement aucunes statistiques disponibles pour la période du %s au %S";
$GLOBALS['strNoTargetingStatsForPeriod'] = "Il n'y actuellement aucunes statistiques de ciblage disponibles pour la période du %s au %S";
$GLOBALS['strPublisherDistribution'] = "Distribution par site web";
$GLOBALS['strCampaignDistribution'] = "Distribution par campagne";
$GLOBALS['strViewBreakdown'] = "Afficher par";
$GLOBALS['strItemsPerPage'] = "Objets par page";
$GLOBALS['strDistributionHistory'] = "Historique de la distribution";
$GLOBALS['strShowGraphOfStatistics'] = "Afficher le <u>g</u>raphique des statistiques";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>xporter les statistiques vers Excel";
$GLOBALS['strGDnotEnabled'] = "Vous devez avoir GD activé dans PHP pour afficher les graphiques. <br />Veuillez visiter <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> pour plus d'informations, y compris comment installer GD sur votre serveur.";
$GLOBALS['strStartDate'] = "Date de début";
$GLOBALS['strEndDate'] = "Date de fin";
$GLOBALS['strAllAdvertisers'] = "Tous les annonceurs";
$GLOBALS['strAnonAdvertisers'] = "Annonceurs anonymes";
$GLOBALS['strAllPublishers'] = "Tous les sites web";
$GLOBALS['strAnonPublishers'] = "Sites web anonymes";
$GLOBALS['strAllAvailZones'] = "Toutes les zones disponibles";
$GLOBALS['strTrackercode'] = "Ajouter le code suivant à chaque impression du traceur Javascript";
$GLOBALS['strBackToTheList'] = "Retourner à la liste des rapports";
$GLOBALS['strLogErrorConversions'] = "[phpAds] Une erreur s'est produite pendant l'analyse des conversions dans la base de données.";
$GLOBALS['strErrorUploadBasedir'] = "L'accès au fichier téléchargé est impossible, probablement à cause du safemode ou de restrictions de open_basedir";
$GLOBALS['strErrorUploadUnknown'] = "L'accès au fichier téléchargé est impossible, pour une raison inconnue. Veuillez vérifier votre configuration de PHP";
$GLOBALS['strErrorLinkingBanner'] = "Il n'a pas été possible de lier cette bannière à cette zone parce que :";
$GLOBALS['strUnableToLinkBanner'] = "Cette bannière ne peut être liée :";
$GLOBALS['strErrorEditingCampaign'] = "Erreur de mise à jour de la campagne:";
$GLOBALS['strUnableToChangeCampaign'] = "Impossible d'appliquer cette modification parce que :";
$GLOBALS['strDatesConflict'] = "conflit de dates avec :";
$GLOBALS['strEmailNoDates'] = "Les campagnes en zones e-mail doivent avoir une date de début et une date de fin";
$GLOBALS['strSirMadam'] = "Madame, Monsieur,";
$GLOBALS['strMailHeader'] = "Chèr(e) {contact},\n";
$GLOBALS['strMailBannerActivatedSubject'] = "Campagne activée";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Campagne désactivée";
$GLOBALS['strMailBannerActivated'] = "La campagne ci-dessous a été activée car\nla date d'activation de campagne a été atteinte.";
$GLOBALS['strMailBannerDeactivated'] = "La campagne ci-dessous a été désactivée car";
$GLOBALS['strMailNothingLeft'] = "Si vous souhaitez continuer à annoncer sur notre site web, n'hésitez pas à nous contacter.\nNous serons heureux d'avoir de vos nouvelles.";
$GLOBALS['strNoMoreImpressions'] = "il ne reste plus d'impressions";
$GLOBALS['strNoMoreConversions'] = "il ne reste plus de conversions";
$GLOBALS['strTargetIsNull'] = "sa limite quotidienne est à zéro - vous devez soit spécifier une date de fin et une limite, soit une limite quotidienne";
$GLOBALS['strImpressionsClicksConversionsLow'] = "Les impressions/clics/conversions restants sont faibles";
$GLOBALS['strNoConversionLoggedInInterval'] = "Aucune conversion n'a été enregistrée pendant la période définie pour ce rapport";
$GLOBALS['strImpendingCampaignExpiry'] = "Fin imminente de la campagne";
$GLOBALS['strYourCampaign'] = "Votre campagne";
$GLOBALS['strTheCampiaignBelongingTo'] = "La campagne appartenant à";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} montré ci-dessous est prévu pour finir le {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} montré ci-dessous a moins de {limit} impressions restantes.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "En conséquence, la campagne sera bientôt automatiquement désactivée, et les\nbannières suivantes de la campagne seront aussi desactivées :";
$GLOBALS['strSourceEdit'] = "Éditer les sources";
$GLOBALS['strViewPastUpdates'] = "Gérer les mises à jour passées et les sauvegardes";
$GLOBALS['strAgencyManagement'] = "Gestion des comptes";
$GLOBALS['strAgency'] = "Compte";
$GLOBALS['strAddAgency'] = "Ajouter un nouveau compte";
$GLOBALS['strAddAgency_Key'] = "Ajouter un <u>n</u>ouveau compte";
$GLOBALS['strTotalAgencies'] = "Total de comptes";
$GLOBALS['strAgencyProperties'] = "Propriétés du compte";
$GLOBALS['strNoAgencies'] = "Il n'y actuellement aucun compte défini";
$GLOBALS['strConfirmDeleteAgency'] = "Voulez-vous vraiment supprimer ce compte ?";
$GLOBALS['strHideInactiveAgencies'] = "Masquer les comptes inactifs";
$GLOBALS['strInactiveAgenciesHidden'] = "compte(s) inactif(s) masqué(s)";
$GLOBALS['strAllowAgencyEditConversions'] = "Autoriser cet utilisateur à éditer les conversions";
$GLOBALS['strAllowMoreReports'] = "Autoriser le bouton 'Plus de rapports'";
$GLOBALS['strChannel'] = "Canal de ciblage";
$GLOBALS['strChannels'] = "Canaux de ciblage";
$GLOBALS['strChannelOverview'] = "Vue d'ensemble des canaux de ciblage";
$GLOBALS['strChannelManagement'] = "Gestion des canaux de ciblage";
$GLOBALS['strAddNewChannel'] = "Ajouter un canal de ciblage";
$GLOBALS['strAddNewChannel_Key'] = "Ajouter un <u>n</u>ouveau canal de ciblage";
$GLOBALS['strNoChannels'] = "Il n'y a actuellement aucun canal de ciblage défini";
$GLOBALS['strEditChannelLimitations'] = "Éditer les limitations du canal de ciblage";
$GLOBALS['strChannelProperties'] = "Propriétés du canal de ciblage";
$GLOBALS['strConfirmDeleteChannel'] = "Voulez-vous vraiment supprimer ce canal de ciblage ?";
$GLOBALS['strVariableName'] = "Nom de la variable";
$GLOBALS['strVariableDataType'] = "Type de données";
$GLOBALS['strVariablePurpose'] = "But";
$GLOBALS['strBasketValue'] = "Valeur du panier";
$GLOBALS['strNumItems'] = "Nombre d'articles";
$GLOBALS['strVariableIsUnique'] = "Dédoublonner les conversions ?";
$GLOBALS['strNumber'] = "Nombre";
$GLOBALS['strString'] = "Chaîne";
$GLOBALS['strTrackFollowingVars'] = "Suivre la variable suivante";
$GLOBALS['strAddVariable'] = "Ajouter une variable";
$GLOBALS['strNoVarsToTrack'] = "Aucune variable à suivre.";
$GLOBALS['strVariableRejectEmpty'] = "Refuser si vide ?";
$GLOBALS['strTrackingSettings'] = "Paramètres du suivi";
$GLOBALS['strTrackerType'] = "Type de suiveur";
$GLOBALS['strTrackerTypeJS'] = "Suivre les variables JavaScript";
$GLOBALS['strTrackerTypeDefault'] = "Suivre les variables JavaScript (rétro-compatible, échappement requis)";
$GLOBALS['strTrackerTypeDOM'] = "Suivre les éléments HTML en utilisant la DOM";
$GLOBALS['strTrackerTypeCustom'] = "Code JS personnalisé";
$GLOBALS['strVariableCode'] = "Code de suivi Javascript";
$GLOBALS['strForgotPassword'] = "Mot de passe oublié ?";
$GLOBALS['strPasswordRecovery'] = "Récupération du mot de passe";
$GLOBALS['strEmailRequired'] = "Le champ e-mail est requis";
$GLOBALS['strPwdRecEmailNotFound'] = "Adresse e-mail non trouvée";
$GLOBALS['strPwdRecPasswordSaved'] = "Le nouveau mot de passe a été enregistré, allez vous <a href='index.php'>connecter</a>";
$GLOBALS['strPwdRecWrongId'] = "ID erroné";
$GLOBALS['strPwdRecEnterEmail'] = "Entrez votre adresse e-mail ci-dessous";
$GLOBALS['strPwdRecEnterPassword'] = "Entrez votre nouveau mot de passe ci-dessous";
$GLOBALS['strPwdRecResetLink'] = "Lien de réinitialisation du mot de passe";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "Récupération de mot de passe %s";
$GLOBALS['strDefaultBannerDestination'] = "URL de destination par défaut";
$GLOBALS['strEvent'] = "Évènement";
$GLOBALS['strHas'] = "contient";
$GLOBALS['strValue'] = "Valeur";
$GLOBALS['strAuditTrail'] = "Piste d'audit";
$GLOBALS['strLinkNewUser'] = "Lier un nouvel utilisateur";
$GLOBALS['strUserAccess'] = "Accès utilisateur";
$GLOBALS['strCampaignStatusRunning'] = "En cours";
$GLOBALS['strCampaignStatusPaused'] = "En pause";
$GLOBALS['strCampaignStatusAwaiting'] = "En attente";
$GLOBALS['strCampaignStatusExpired'] = "Terminée";
$GLOBALS['strCampaignStatusApproval'] = "En attente d'approbation »";
$GLOBALS['strCampaignStatusRejected'] = "Rejetée";
$GLOBALS['strCampaignApprove'] = "Approuver";
$GLOBALS['strCampaignApproveDescription'] = "approuver cette campagne";
$GLOBALS['strCampaignReject'] = "Rejeter";
$GLOBALS['strCampaignRejectDescription'] = "rejeter cette campagne";
$GLOBALS['strCampaignPause'] = "Mettre en pause";
$GLOBALS['strCampaignPauseDescription'] = "mettre cette campagne en pause de façon temporaire";
$GLOBALS['strCampaignRestart'] = "Reprendre";
$GLOBALS['strCampaignRestartDescription'] = "reprendre cette campagne";
$GLOBALS['strCampaignStatus'] = "État de la campagne";
$GLOBALS['strReasonForRejection'] = "Raison du rejet";
$GLOBALS['strReasonSiteNotLive'] = "Site pas en ligne";
$GLOBALS['strReasonBadCreative'] = "Illustration inappropriée";
$GLOBALS['strReasonBadUrl'] = "URL de destination inappropriée";
$GLOBALS['strReasonBreakTerms'] = "Site web incompatible avec les termes et conditions";
$GLOBALS['strTrackerPreferences'] = "Préférences du suivi";
$GLOBALS['strBannerPreferences'] = "Préférences des bannières";
$GLOBALS['strAdvertiserSetup'] = "Inscription annonceur";
$GLOBALS['strAdvertiserSignup'] = "Inscription annonceur";
$GLOBALS['strSelectPublisher'] = "Sélectionnez un site web";
$GLOBALS['strSelectZone'] = "Sélectionnez un zone";
$GLOBALS['strMainPreferences'] = "Préférences principales";
$GLOBALS['strAccountPreferences'] = "Préférences du compte";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Préférences des rapports de campagnes par e-mail";
$GLOBALS['strAdminEmailWarnings'] = "Alertes e-mail des administrateurs";
$GLOBALS['strAgencyEmailWarnings'] = "Alertes e-mail des agences";
$GLOBALS['strAdveEmailWarnings'] = "Alertes e-mail des annonceurs";
$GLOBALS['strFullName'] = "Nom complet";
$GLOBALS['strEmailAddress'] = "Adresse e-mail";
$GLOBALS['strUserDetails'] = "Informations utilisateur";
$GLOBALS['strLanguageTimezone'] = "Langue & fuseau horaire";
$GLOBALS['strUserInterfacePreferences'] = "Préférences de l'interface utilisateur";
$GLOBALS['strInvocationPreferences'] = "Préférences de l'invocation";
$GLOBALS['strUserProperties'] = "Propriétés de l'utilisateur";
$GLOBALS['strBack'] = "Retour";
$GLOBALS['strUsernameToLink'] = "Identifiant de l'utilisateur à ajouter";
$GLOBALS['strEmailToLink'] = "E-mail de l'utilisateur à ajouter";
$GLOBALS['strNewUserWillBeCreated'] = "Un nouvel utilisateur va être créé";
$GLOBALS['strToLinkProvideEmail'] = "Pour ajouter l'utilisateur, indiquez son e-mail";
$GLOBALS['strToLinkProvideUsername'] = "Pour ajouter l'utilisateur, indiquez son identifiant";
$GLOBALS['strPermissions'] = "Permissions";
$GLOBALS['strContactName'] = "Nom du contact";
$GLOBALS['strPwdRecReset'] = "Réinitialisation du mot de passe";
$GLOBALS['strPwdRecResetPwdThisUser'] = "Réinitialiser le mot de passe pour cet utilisateur";
$GLOBALS['keyLinkUser'] = "u";
$GLOBALS['strAdSenseAccounts'] = "Comptes AdSense";
$GLOBALS['strLinkAdSenseAccount'] = "Lier un compte AdSense";
$GLOBALS['strCreateAdSenseAccount'] = "Créer un compte AdSense";
$GLOBALS['strEditAdSenseAccount'] = "Éditer un compte AdSense";
$GLOBALS['strAllowCreateAccounts'] = "Autoriser cet utilisateur à créer de nouveaux comptes";
$GLOBALS['strErrorWhileCreatingUser'] = "Erreur lors de la création de l'utilisateur : %s";
$GLOBALS['strUserLinkedToAccount'] = "L'utilisateur a été ajouté au compte";
$GLOBALS['strUserAccountUpdated'] = "Compte utilisateur mis à jour";
$GLOBALS['strUserUnlinkedFromAccount'] = "L'utilisateur a été retiré du compte";
$GLOBALS['strUserWasDeleted'] = "L'utilisateur a été supprimé";
$GLOBALS['strUserNotLinkedWithAccount'] = "Un tel utilisateur n'est lié au compte";
$GLOBALS['strWorkingAs'] = "Travaille en tant que";
$GLOBALS['strWorkingFor'] = "%s pour…";
$GLOBALS['strCantDeleteOneAdminUser'] = "Vous ne pouvez pas supprimer un utilisateur. Au moins un utilisateur doit être lié avec le compte admin.";
$GLOBALS['strWarnChangeBannerSize'] = "Changer la taille de la bannière détachera cette bannière des zones qui n'ont pas la nouvelle taille, et si la <strong>campagne</strong> de cette bannière est liée à une zone  ayant la nouvelle taille, cette bannière sera automatiquement liée";
$GLOBALS['strAuditNoData'] = "Aucune activité utilisateur n'a été enregistrée dans l'intervalle que vous avez sélectionné.";
$GLOBALS['strCampaignGoTo'] = "Aller à la page des campagnes";
$GLOBALS['strCampaignSetUp'] = "Paramétrer une campagne aujourd'hui";
$GLOBALS['strCampaignNoRecords'] = "<li>Les campagnes vous permettent de regrouper plusieurs bannières publicitaires, de n'importe quelles tailles, qui partagent les mêmes prérequis publicitaires</li><li>Gagnez du temps en regroupant des bannières dans une campagne afin de ne plus définir de paramètres de distribution pour chaque publicité séparément</li><li>Consultez la <a class='site-link' target='help' href='". OX_PRODUCT_DOCSURL ."/inventory/advertisersAndCampaigns/campaigns'>documentation sur les campagnes</a> !</li>";
$GLOBALS['strPublisherReports'] = "Rapports des sites web";
$GLOBALS['strVariableHidden'] = "Masquer la variable aux sites web ?";
$GLOBALS['strCampaignNoDataTimeSpan'] = "Aucune campagne n'a démarré ou terminé dans l'intervalle que vous avez sélectionné";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>Afin d'afficher les campagnes que vous avez commencées ou terminées au cours de la période sélectionnée, la piste d'audit doit être activée</li>	        <li>Vous voyez ce message car vous n'avez pas activé la piste d'audit</li>";
$GLOBALS['strAuditTrailSetup'] = "Paramétrer la piste d'audit aujourd'hui";
$GLOBALS['strAuditTrailGoTo'] = "Aller à la page de la piste d'audit";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>La piste d'audit vous permet de voir qui a fait quoi et quand. Ou, d'une autre façon, cela permet de suivre les modifications du système effectuées dans ". MAX_PRODUCT_NAME ."</li> <li>Ce message s'affiche car vous n'avez pas activé la piste d'audit</li> <li>Vous voulez en savoir plus ? Lisez la <a href='". OX_PRODUCT_DOCSURL ."/settings/auditTrail' class='site-link' target='help' >documentation sur la piste d'audit</a></li>";
$GLOBALS['strNoAdminInterface'] = "L'écran d'admin a été désactivé en raison d'une maintenance. Cela n'affecte pas la distribution de vos campagnes.";
$GLOBALS['strAdminAccess'] = "Accès admin";
$GLOBALS['strOverallAdvertisers'] = "annonceur(s)";
$GLOBALS['strAdvertiserSignupDesc'] = "S'inscrire pour le self service et le paiement annonceur";
$GLOBALS['strOverallCampaigns'] = "campagne(s)";
$GLOBALS['strTotalRevenue'] = "Total des recettes";
$GLOBALS['strChangeStatus'] = "Changer l'état";
$GLOBALS['strImpression'] = "Impression";
$GLOBALS['strOverallBanners'] = "bannière(s)";
$GLOBALS['strTrackerImageTag'] = "Tag image";
$GLOBALS['strTrackerJsTag'] = "Tag javascript";
$GLOBALS['strPeriod'] = "Période";
$GLOBALS['strWorksheets'] = "Feuilles de travail";
$GLOBALS['strSwitchAccount'] = "Basculer vers ce compte";
$GLOBALS['strAdditionalItems'] = "et les objets supplémentaires";
$GLOBALS['strFor'] = "pour";
$GLOBALS['strFieldStartDateBeforeEnd'] = "La date 'du' doit être antérieure à la date 'au'";
$GLOBALS['strDashboardForum'] = "Forum OpenX";
$GLOBALS['strDashboardDocs'] = "Docs OpenX";
$GLOBALS['strLinkUserHelpUser'] = "identifiant";
$GLOBALS['strLinkUserHelpEmail'] = "adresse e-mail";
$GLOBALS['strSessionIDNotMatch'] = "Erreur de cookie de session, veuillez vous reconnecter";
$GLOBALS['strPasswordRepeat'] = "Répèter le mot de passe";
$GLOBALS['strInvalidEmail'] = "Cet e-mail n'a pas été formatté correctement, veuillez entrer une adresse e-mail correcte.";
$GLOBALS['strAdvertiserLimitation'] = "N'afficher qu'une bannière de cet annonceur sur la page web";
$GLOBALS['strAllowAuditTrailAccess'] = "Autoriser cet utiliser à accéder à la piste d'audit";
$GLOBALS['strCampaignStatusAdded'] = "Ajoutée";
$GLOBALS['strCampaignStatusStarted'] = "Démarrée";
$GLOBALS['strCampaignStatusRestarted'] = "Redémarrée";
$GLOBALS['strAdserverTypeMax'] = "Rich Media - OpenX";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "Il y a des campagnes encore liées à cette zone, si vous la supprimez elles ne pourront plus tourner et vous ne serez pas payé pour celles-ci.";
$GLOBALS['strCharset'] = "Jeu de caractères";
$GLOBALS['strAutoDetect'] = "Détection automatique";
$GLOBALS['strWarningInaccurateStats'] = "Certaines de ces statistiques ont été journalisées dans un fuseau horaire non-UTC, et peuvent ne pas être affichées dans le bon fuseau horaire.";
$GLOBALS['strWarningInaccurateReadMore'] = "En savoir plus à ce sujet";
$GLOBALS['strWarningInaccurateReport'] = "Certaines de ces statistiques ont été journalisées dans un fuseau horaire non-UTC, et peuvent ne pas être affichées dans le bon fuseau horaire.";
$GLOBALS['strUserPreferences'] = "Préférences de l'utilisateur";
$GLOBALS['strChangePassword'] = "Changer le mot de passe";
$GLOBALS['strChangeEmail'] = "Changer l'e-mail";
$GLOBALS['strCurrentPassword'] = "Mot de passe actuel";
$GLOBALS['strChooseNewPassword'] = "Choisir un nouveau mot de passe";
$GLOBALS['strReenterNewPassword'] = "Entrer à nouveau le nouveau mot de passe";
$GLOBALS['strNameLanguage'] = "Nom & Langue";
$GLOBALS['strNotifyPageMessage'] = "Un e-mail vous a été envoyé, incluant un lien qui vous permettra de réinitialiser votre mot de passe et de vous connecter.<br />Veuillez donner quelques minutes à l'email pour arriver.<br /> Si vous ne recevez pas l'e-mail, vérifier votre dossier de messages indésirables.<br /><a href='index.php'>Retourner à la page de connexion principale.</a>";
$GLOBALS['strAdZoneAsscociation'] = "Association de zone publicitaire";
$GLOBALS['strBinaryData'] = "Données binaires";
$GLOBALS['strAuditTrailDisabled'] = "La piste d'audit a été désactivée par l'administrateur. Aucun évènement ne sera plus journalisé ni affiché dans la liste de piste d'audit.";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>Il n'y a aucune activité de campagne à afficher.</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Activer la piste d'audit pour commencer à afficher les campagnes";
$GLOBALS['strAdd'] = "Ajouter";
$GLOBALS['strRequiredField'] = "Champ requis";
$GLOBALS['strNoSslSupport'] = "Le tableau de bord ne peut pas être affiché pour le moment car votre installation ne supporte pas le SSL.";
$GLOBALS['strSslAccessCentralSys'] = "Pour accéder à la page d'accueil, votre serveur publicitaire doit être capable de se connecter de façon sécurisée à notre système central, en utilisant une couche de sockets sécurisée (SSL).";
$GLOBALS['strInstallSslExtension'] = "Il est nécessaire d'installer une extension PHP pour communiquer avec SSL, openssl ou curl avec SSL activé. Pour plus d'informations, contactez votre administrateur système.";
$GLOBALS['strChoosenDisableHomePage'] = "Vous avez choisi de désactiver votre page d'accueil.";
$GLOBALS['strAccessHomePage'] = "Cliquez ici pour accéder à votre page d'accueil";
$GLOBALS['strEditSyncSettings'] = "et éditer vos paramètres de synchronisation";
$GLOBALS['strLinkUser'] = "Ajouter un utilisateur";
$GLOBALS['strLinkUser_Key'] = "Ajouter un <u>u</u>tilisateur";
$GLOBALS['strLastLoggedIn'] = "Dernière connexion";
$GLOBALS['strDateLinked'] = "Date de liaison";
$GLOBALS['strUnlink'] = "Retirer";
$GLOBALS['strUnlinkingFromLastEntity'] = "Retirer l'utilisateur de la dernière entité";
$GLOBALS['strUnlinkingFromLastEntityBody'] = "Retirer l'utilisateur de la dernière entité causera la suppression de celui-ci. Voulez-vous retirer cet utilisateur ?";
$GLOBALS['strUnlinkAndDelete'] = "Retirer &amp; supprimer l'utilisateur";
$GLOBALS['strUnlinkUser'] = "Retirer l'utilisateur";
$GLOBALS['strUnlinkUserConfirmBody'] = "Êtes-vous sûr de vouloir retirer cet utilisateur ?";
$GLOBALS['strDeadLink'] = "Votre lien est invalide.";
$GLOBALS['strNoPlacement'] = "La campagne sélectionnée n'existe pas. Essayez plutôt ce <a href='{link}'>lien</a>";
$GLOBALS['strNoAdvertiser'] = "L'annonceur sélectionné n'existe pas. Essayez plutôt ce <a href='{link}'>lien</a>";
$GLOBALS['strPercentRevenueSplit'] = "% partage de recettes";
$GLOBALS['strPercentBasketValue'] = "% valeur du panier";
$GLOBALS['strAmountPerItem'] = "Montant par article";
$GLOBALS['strPercentCustomVariable'] = "% variable personnalisée";
$GLOBALS['strPercentSumVariables'] = "% somme des variables";
$GLOBALS['strAdvertiserSignupLink'] = "Lien d'inscription annonceur";
$GLOBALS['strAdvertiserSignupLinkDesc'] = "Pour ajouter un lien d'inscription annonceur à votre site, veuillez copier le HTML ci-dessous :";
$GLOBALS['strAdvertiserSignupOption'] = "Option d'inscription annonceur";
$GLOBALS['strAdvertiserSignunOptionDesc'] = "Pour éditer vos options d'inscription annonceur, continuez vers";
$GLOBALS['strCampaignStatusPending'] = "Suspendue";
$GLOBALS['strCampaignStatusDeleted'] = "Supprimée";
$GLOBALS['strTrackers'] = "Suiveurs";
$GLOBALS['strWebsiteURL'] = "URL du site web";
$GLOBALS['strInventoryForecasting'] = "Prévisions de l'inventaire";
$GLOBALS['strPerSingleImpression'] = "par impression unique";
$GLOBALS['strWithXBanners'] = "%d bannière(s)";
$GLOBALS['strTrackerCodeSubject'] = "Ajouter un code de suivi";
$GLOBALS['strStatsArea'] = "Domaine";
$GLOBALS['strNoExpirationEstimation'] = "Aucune expiration estimée pour le moment";
$GLOBALS['strDaysAgo'] = "jours avant";
$GLOBALS['strCampaignStop'] = "Arrêt de la campagne";
$GLOBALS['strErrorEditingCampaignRevenue'] = "format de nombre incorrect dans le champ Informations sur les recettes";
$GLOBALS['strErrorEditingZone'] = "Erreur de mise à jour de la zone :";
$GLOBALS['strUnableToChangeZone'] = "Impossible d'appliquer cette modification parce que :";
$GLOBALS['strErrorEditingZoneTechnologyCost'] = "format de nombre incorrect dans le champ Coût média";
$GLOBALS['strErrorEditingZoneCost'] = "format de nombre incorrect dans le champ Coût technologique";
$GLOBALS['strLanguageTimezonePreferences'] = "Préférences de langue et de fuseau horaire";
$GLOBALS['strColumnName'] = "Nom de la colonne";
$GLOBALS['strShowColumn'] = "Afficher la colonne";
$GLOBALS['strCustomColumnName'] = "Nom de colonne personnalisé";
$GLOBALS['strColumnRank'] = "Rang de la colonne";
$GLOBALS['strCost'] = "Coût";
$GLOBALS['strNumberOfItems'] = "Nombre d'articles";
$GLOBALS['strRevenueCPC'] = "Recettes CPC";
$GLOBALS['strCostCPC'] = "Coût CPC";
$GLOBALS['strIncome'] = "Revenus";
$GLOBALS['strIncomeMargin'] = "Marge des revenus";
$GLOBALS['strProfit'] = "Profit";
$GLOBALS['strMargin'] = "Marge";
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
$GLOBALS['strCheckForUpdates'] = "Vérifier les mises à jour";
$GLOBALS['strFromVersion'] = "Depuis la version";
$GLOBALS['strToVersion'] = "À la version";
$GLOBALS['strToggleDataBackupDetails'] = "Afficher/masquer les détails des sauvegardes";
$GLOBALS['strClickViewBackupDetails'] = "cliquer pour afficher les détails de la sauvegarde";
$GLOBALS['strClickHideBackupDetails'] = "cliquer pour masquer les détails de la sauvegarde";
$GLOBALS['strShowBackupDetails'] = "Afficher les détails de la sauvegarde";
$GLOBALS['strHideBackupDetails'] = "Masquer les détails de la sauvegarde";
$GLOBALS['strInstallation'] = "Installation";
$GLOBALS['strBackupDeleteConfirm'] = "Voulez-vous vraiment supprimer toutes les sauvegardes créées par cette mise à jour ?";
$GLOBALS['strDeleteArtifacts'] = "Supprimer les artefacts";
$GLOBALS['strArtifacts'] = "Artefacts";
$GLOBALS['strBackupDbTables'] = "Tables de la base de données sauvegardées";
$GLOBALS['strLogFiles'] = "Fichiers journaux";
$GLOBALS['strConfigBackups'] = "Configurations sauvegardées";
$GLOBALS['strUpdatedDbVersionStamp'] = "Tampon de version de la base de données mise à jour";
$GLOBALS['strAgencies'] = "Comptes";
$GLOBALS['strModifychannel'] = "Éditer le canal de ciblage";
$GLOBALS['strPwdRecEmailSent'] = "E-mail de récupération envoyé";
$GLOBALS['strAccount'] = "Compte";
$GLOBALS['strAccountUserAssociation'] = "Association utilisateur/compte";
$GLOBALS['strImage'] = "Image";
$GLOBALS['strCampaignZoneAssociation'] = "Association zone/campagne";
$GLOBALS['strAccountPreferenceAssociation'] = "Association préférences/compte";
$GLOBALS['strUnsavedChanges'] = "Vous n'avez pas sauvé les modifications de cette page, assurez-vous de cliquez sur \"Sauver les changements\" quand vous aurez terminé";
$GLOBALS['strDeliveryLimitationsDisagree'] = "ATTENTION : Les limitations du moteur de distribution <strong>NE SONT PAS EN ACCORD</strong> avec les limitations affichées ci-dessous<br />Veuillez cliquer sur sauver les changements pour mettre à jour les règles du moteur de distribution";
$GLOBALS['strPendingConversions'] = "Conversions en attente";
$GLOBALS['strImpressionSR'] = "TV impressions";
$GLOBALS['strClickSR'] = "TV clics";
$GLOBALS['str_cs'] = "Tchèque";
$GLOBALS['str_de'] = "Allemand";
$GLOBALS['str_en'] = "Anglais";
$GLOBALS['str_es'] = "Espagnol";
$GLOBALS['str_fa'] = "Perse";
$GLOBALS['str_fr'] = "Français";
$GLOBALS['str_he'] = "Hébreu";
$GLOBALS['str_hu'] = "Hongrois";
$GLOBALS['str_id'] = "Indonésien";
$GLOBALS['str_it'] = "Italien";
$GLOBALS['str_ja'] = "Japonais";
$GLOBALS['str_ko'] = "Coréen";
$GLOBALS['str_nl'] = "Hollandais";
$GLOBALS['str_pl'] = "Polonais";
$GLOBALS['str_pt_BR'] = "Portugais Brésil";
$GLOBALS['str_ro'] = "Roumain";
$GLOBALS['str_ru'] = "Russe";
$GLOBALS['str_sl'] = "Slovène";
$GLOBALS['str_tr'] = "Turc";
$GLOBALS['str_zh_CN'] = "Chinois simplifié";
$GLOBALS['strGlobalSettings'] = "Paramètres généraux";
$GLOBALS['strMyAccount'] = "Mon compte";
$GLOBALS['strSwitchTo'] = "Passer à";
$GLOBALS['strRevenue'] = "Recettes";
$GLOBALS['str_ar'] = "Arabe";
$GLOBALS['str_bg'] = "Bulgare";
$GLOBALS['str_cy'] = "Gallois";
$GLOBALS['str_da'] = "Danois";
$GLOBALS['str_el'] = "Grec";
$GLOBALS['str_hr'] = "Croate";
$GLOBALS['str_lt'] = "Lituanien";
$GLOBALS['str_ms'] = "Malais";
$GLOBALS['str_nb'] = "Norvégien classique";
$GLOBALS['str_sk'] = "Slovaque";
$GLOBALS['str_sv'] = "Suédois";
$GLOBALS['str_uk'] = "Ukrainien";
$GLOBALS['str_zh_TW'] = "Chinois traditionnel";
$GLOBALS['strDashboardErrorCode'] = "code";
$GLOBALS['strDashboardGenericError'] = "Erreur générique";
$GLOBALS['strDashboardSystemMessage'] = "Message système";
$GLOBALS['strDashboardErrorHelp'] = "Si cette erreur se répète, veuillez décrire votre problème en détails en le poster sur le <a href='http://forum.openx.org/'>forum OpenX</a>.";
$GLOBALS['strDashboardErrorMsg800'] = "Erreur de connexion XML-RPC";
$GLOBALS['strDashboardErrorMsg801'] = "Non authentifié";
$GLOBALS['strDashboardErrorMsg802'] = "Échec du CAPTCHA";
$GLOBALS['strDashboardErrorMsg803'] = "Mauvais paramètres";
$GLOBALS['strDashboardErrorMsg804'] = "L'identifiant ne correspond pas à la plateforme";
$GLOBALS['strDashboardErrorMsg805'] = "La plateforme n'existe pas";
$GLOBALS['strDashboardErrorMsg806'] = "Erreur serveur";
$GLOBALS['strDashboardErrorMsg807'] = "Non autorisé";
$GLOBALS['strDashboardErrorMsg808'] = "Version XML-RPC non supportée";
$GLOBALS['strDashboardErrorMsg900'] = "Code d'erreur transport";
$GLOBALS['strDashboardErrorMsg821'] = "Erreur d'authentification M2M - type de compte non autorisé";
$GLOBALS['strDashboardErrorMsg822'] = "Erreur d'authentification M2M - mot de passe déjà généré";
$GLOBALS['strDashboardErrorMsg823'] = "Erreur d'authentification M2M - mot de passe invalide";
$GLOBALS['strDashboardErrorMsg824'] = "Erreur d'authentification M2M - mot de passe expiré";
$GLOBALS['strDashboardErrorMsg825'] = "Erreur d'authentification M2M - connexion impossible";
$GLOBALS['strDashboardErrorMsg826'] = "Erreur d'authentification M2M - reconnexion impossible";
$GLOBALS['strDashboardErrorDsc800'] = "Le tableau de bord tire ses informations d'un serveur central pour certains widgets. Plusieurs choses peuvent affecter cela.<br />Votre serveur peut ne pas avoir l'extension Curl activée. Vous pourriez avoir besoin d'installer ou d'activer l'extension Curl, voir <a href='http://php.net/curl'>ici</a> pour plus d'informations.<br />	                                           Vous devriez aussi vérifier que votre pare-feu ne bloque pas les connexions sortantes.";
$GLOBALS['strDashboardErrorDsc803'] = "Erreur dans la requête au serveur - mauvais paramètres, veuillez essayer de renvoyer vos données";
$GLOBALS['strDashboardErrorDsc805'] = "La connexion XML-RPC n'a pas été autorisée lors de l'installation d'OpenX et le serveur central OpenX ne reconnaît pas votre installation comme étant valide.<br />	                                           Veuillez aller dans le compte Administrateur, Mon compte > Mises à jour produit pour vous connecter et vous inscrire dans le serveur central.";
$GLOBALS['strActions'] = "Actions";
$GLOBALS['strMore'] = "Plus";
$GLOBALS['strLess'] = "Moins";
$GLOBALS['strAdditionalInformation'] = "Information supplémentaire";
$GLOBALS['strDashboardCantBeDisplayed'] = "Le tableau de bord ne peut pas être affiché";
$GLOBALS['strNoCheckForUpdates'] = "Le tableau de bord ne peut pas être affiché car vous avez<br/>désactivé les paramètres de recherche des mises à jour.";
$GLOBALS['strEnableCheckForUpdates'] = "Activer la <a href='account-settings-update.php'>recherche de mises à jour</a> via<br/><a href='account-settings-update.php'>la page de paramètres de </a> mises à jour.";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";
$GLOBALS['strNoClientsForBanners'] = "Il n'y a actuellement aucun annonceur défini. Pour ajouter des bannières, vous devez d'abord <a href='advertiser-edit.php'>ajouter un nouvel annonceur</a> et une campagne.";
$GLOBALS['strAdvertiserCampaigns'] = "Campagnes des annonceurs";
$GLOBALS['strCampaignForAdvertiser'] = "Pour l'annonceur";
$GLOBALS['strNoCampaignsForBanners'] = "Cet annonceur n'a pas de campagne. Vous devez <a href='campaign-edit.php?clientid=%s'> d'abord ajouter une campagne</a> pour ajouter des bannières";
$GLOBALS['strCampaignsOfAdvertiser'] = "de";
$GLOBALS['strCalculatedForAllCampaigns'] = "Calculé pour toutes les campagnes";
$GLOBALS['strCalculatedForThisCampaign'] = "Calculé pour cette campagne";
$GLOBALS['strLinkingZonesProblem'] = "Un problème est survenu lors de la liaison des zones";
$GLOBALS['strUnlinkingZonesProblem'] = "Un problème est survenu lors de la suppression de liaison des zones";
$GLOBALS['strZonesLinked'] = "zone(s) liée(s)";
$GLOBALS['strZonesUnlinked'] = "zone(s) déliée(s)";
$GLOBALS['strZonesSearch'] = "Recherche";
$GLOBALS['strZonesSearchTitle'] = "Recherche par le nom des zones et des sites";
$GLOBALS['strNoWebsitesAndZones'] = "Pas de sites ni de zones";
$GLOBALS['strNoWebsitesAndZonesCategory'] = "dans la category";
$GLOBALS['strNoWebsitesAndZonesText'] = "avec \"%s\" dans le nom";
$GLOBALS['strToLink'] = "à lier";
$GLOBALS['strToUnlink'] = "à délier";
$GLOBALS['strLinked'] = "lié";
$GLOBALS['strAvailable'] = "Disponible";
$GLOBALS['strShowing'] = "Montrant";
$GLOBALS['strAllCategories'] = "Toutes catégories";
$GLOBALS['strUncategorized'] = "Hors catégorie";
$GLOBALS['strSetSpecificDate'] = "Préciser une date spécifique";
$GLOBALS['strCampaignStatusInactive'] = "Inactif";
$GLOBALS['strCampaignType'] = "Type de campagne";
$GLOBALS['strContract'] = "Contrat";
$GLOBALS['strRemnant'] = "Restant";
$GLOBALS['strStandardContract'] = "Contrat";
$GLOBALS['strExclusiveContract'] = "Contrat (exclusif)";
$GLOBALS['strStandardContractInfo'] = "Cette campagne est limitée à la journée et continuera d'être délivrée de façon égale jusqu'à ce que la date de fin ou que la limite spécifiée sois atteinte";
$GLOBALS['strExclusiveContractInfo'] = "Cette campagne va s'approprier tous les affichages et sera livrée avant les autres campagnes";
$GLOBALS['strRemnantInfo'] = "C'est une campagne standard qui sera définie à la fois par une date de fin et par une limite spécifique";
$GLOBALS['strContractCampaign'] = "Contrat de campagne";
$GLOBALS['strRemnantCampaign'] = "Campagne restante";
$GLOBALS['strPricing'] = "Définition du prix";
$GLOBALS['strPricingModel'] = "Modèle de définition de prix";
$GLOBALS['strSelectPricingModel'] = "\-- sélectionner le modèle --";
$GLOBALS['strRatePrice'] = "Taxe / Prix";
$GLOBALS['strLimit'] = "Limite";
$GLOBALS['strLowExclusiveDisabled'] = "Vous ne pouvez pas changer cette campagne en Restante ou Exclusive, tant que et la date de fin et la limite d'impressions/clicks/conversions n'est pas définie. <br>Pour changer le type, vous ne devez paramétrer ni date de fin, ni limites à atteindre.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "Vous ne pouvez pas à la fois paramétrer et une date de fin et une limite d'impressions pour une campagne Restante ou Exclusive.<br>Si vous avez besoin de paramétrer à la fois une date de fin et une limite d'impressions/clicks/conversions, veuillez utiliser une campagne à contrat non-exclusif.";
$GLOBALS['strWhyDisabled'] = "Pourquoi est-ce désactivé?";
$GLOBALS['strBackToCampaigns'] = "Retour aux campagnes";
$GLOBALS['strCampaignBanners'] = "Bannières des campagnes";
$GLOBALS['strTrackerForAdvertiser'] = "pour l'annonceur";
$GLOBALS['strNoLinkedTrackersDropdown'] = "\-- Pas de traceur de lien --";
$GLOBALS['strBannerToCampaign'] = "vers la campagne";
$GLOBALS['strBannersOfCampaign'] = "dans";
$GLOBALS['strBackToBanners'] = "Retour aux bannières";
$GLOBALS['strPrimaryCategory'] = "Catégorie principale";
$GLOBALS['strSecondaryCategory'] = "Catégorie secondaire";
$GLOBALS['strWebsiteZones'] = "Zones des sites";
$GLOBALS['strZoneToWebsite'] = "vers le site internet";
$GLOBALS['strAvailableZones'] = "Zones disponibles";
$GLOBALS['strLinkingNotSuccess'] = "Liaison non réalisée, veuillez ré-essayer";
$GLOBALS['strNoZonesAddWebsite'] = "Il n'y a actuellement pas de zones définies, car il n'y a pas de site internet. Pour créer une zone, commencez par <a href='affiliate-edit.php'>ajouter un nouveau site internet</a>.";
$GLOBALS['strWarnBannerReadonly'] = "Cette bannière est en lecture uniquement car une extension a été désactivée. Contactez votre Administrateur pour plus d'information.";
$GLOBALS['strZonesOfWebsite'] = "dans";
$GLOBALS['strBackToZones'] = "Retour aux zones";
$GLOBALS['strAdvancedReports'] = "Rapports détaillés";
$GLOBALS['strRequiredFieldLegend'] = "demande un champ rempli";
$GLOBALS['strFormContainsErrors'] = "Le formulaire contient des erreurs, veuillez corriger les champs signalés ci-dessous.";
$GLOBALS['strXRequiredField'] = "%s sont demandés";
$GLOBALS['strEmailField'] = "Veuillez entrer un email valide";
$GLOBALS['strNumericField'] = "Veuillez entrer un nombre (seuls des chiffres sont autorisés)";
$GLOBALS['strXUniqueField'] = "%s avec ces %s existent déjà";
$GLOBALS['strConfiguration'] = "Configuration";
$GLOBALS['strPluginPreferences'] = "Préférences des plugins";
$GLOBALS['strRevenue_short'] = "Rec.";
$GLOBALS['strCost_short'] = "Coût";
$GLOBALS['strBasketValue_short'] = "VP";
$GLOBALS['strNumberOfItems_short'] = "Nb. articles";
$GLOBALS['strRevenueCPC_short'] = "Rec. CPC";
$GLOBALS['strCostCPC_short'] = "Coût CPC";
$GLOBALS['strTechnologyCost_short'] = "Coût tech.";
$GLOBALS['strIncome_short'] = "Revenus";
$GLOBALS['strIncomeMargin_short'] = "Marge rev.";
$GLOBALS['strProfit_short'] = "Profit";
$GLOBALS['strMargin_short'] = "Marge";
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
$GLOBALS['strChannelToWebsite'] = "vers le site web";
$GLOBALS['strChannelsOfWebsite'] = "dans";
$GLOBALS['strYouAreNowWorkingAsX'] = "Vous travaillez maintenant en tant que <b>%s</b>";
$GLOBALS['strAdvertiserHasBeenAdded'] = "L'annonceur <a href='%s'>%s</a> a été ajouté, <a href='%s'>ajoutez une campagne</a>";
$GLOBALS['strAdvertiserHasBeenDeleted'] = "L'annonceur <b>%s</b> a été supprimé";
$GLOBALS['strCampaignHasBeenAdded'] = "La campagne <a href='%s'>%s</a> a été ajoutée, <a href='%s'>ajoutez une bannière</a>";
$GLOBALS['strCampaignHasBeenDeleted'] = "La campagne <b>%s</b> a été supprimée";
$GLOBALS['strBannerHasBeenAdded'] = "La bannière <a href='%s'>%s</a> a été ajoutée";
$GLOBALS['strBannerHasBeenDeleted'] = "La bannière <b>%s</b> a été supprimée";
$GLOBALS['strWebsiteHasBeenAdded'] = "Le site <a href='%s'>%s</a> a été ajouté, <a href='%s'>ajoutez une zone</a>";
$GLOBALS['strWebsiteHasBeenDeleted'] = "Le site <b>%s</b> a été supprimé";
$GLOBALS['strZoneHasBeenAdded'] = "La zone <a href='%s'>%s</a> a été ajoutée";
$GLOBALS['strZoneHasBeenDeleted'] = "La zone <b>%s</b> a été supprimée";
$GLOBALS['strChannelHasBeenAdded'] = "Le canal ciblé <a href='%s'>%s</a> a été ajouté, <a href='%s'>changer les options de distribution</a>";
$GLOBALS['strChannelHasBeenDeleted'] = "Le canal ciblé <b>%s</b> a été supprimé";
$GLOBALS['strDistributionHistoryCampaign'] = "Historique de distribution (Campagne)";
$GLOBALS['strDistributionHistoryBanner'] = "Historique de distribution (Bannière)";
$GLOBALS['strGreaterThanZeroField'] = "Doit être supérieur à 0";
$GLOBALS['strXGreaterThanZeroField'] = "%s doit être supérieur à 0";
$GLOBALS['strEditZone'] = "Editer la zone";
$GLOBALS['strEditWebsite'] = "Editer le site internet";
$GLOBALS['strDistributionHistoryWebsite'] = "Historique de distribution (site internet)";
$GLOBALS['strDistributionHistoryZone'] = "Historique de distribution (zone)";
$GLOBALS['strXDecimalFieldWithDecimalPlaces'] = "Doit être décimal avec un maximum de %s chiffres décimaux";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Certaines des limitations de distribution rapportent des valeurs incorrectes :";
$GLOBALS['strConfirmDeleteClients'] = "Voulez-vous vraiment supprimer les annonceurs sélectionnés ?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Voulez-vous vraiment supprimer les campagnes sélectionnés ?";
$GLOBALS['strConfirmDeleteTrackers'] = "Voulez-vous vraiment supprimer les traceurs sélectionnés ?";
$GLOBALS['strTrackerInformation'] = "Information de traceur";
$GLOBALS['strBackToTrackers'] = "Retour aux traceurs";
$GLOBALS['strNoBannersAddCampaign'] = "Il n'y a pas actuellement de bannières définies, parce qu'il n'existe pas de campagne. Pour créer une bannière, <a href='campaign-edit.php?clientid=%s'>ajouter une nouvelle campagne</a> d'abord.";
$GLOBALS['strNoBannersAddAdvertiser'] = "Il n'y a actuellement aucunes bannières définies, parce qu'il n'y a pas d'annonceurs. Pour créer une bannière, commencez par <a href='affiliate-edit.php'>ajouter un nouvel annonceur</a>.";
$GLOBALS['strConfirmDeleteBanners'] = "Voulez-vous vraiment supprimer la bannière sélectionnée?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Voulez-vous vraiment supprimer le site web sélectionné?";
$GLOBALS['strConfirmDeleteZones'] = "Voulez-vous vraiment supprimer les zones sélectionnées ?";
$GLOBALS['strCacheBusterComment'] = "* Remplacez toutes les cas de {random} avec * un nombre généré aléatoirement (ou avec un horodatage). *";
$GLOBALS['strSSLBackupComment'] = "* L'image de sauvegarde de cette balise a été générée pour être utilisée sur une page 	* non-SSL. Ci cette balise doit être placée sur une page SSL, changez le 	*   'http://%s/...' 	* par 	*   'https://%s/...' 	*";
$GLOBALS['strSSLDeliveryComment'] = "* Cette balise a été créée pour une utilisation sur une page non-SSL. Si cette balise  	* doit être placée sur une page SSL, changez le 	*   'http://%s/...' 	* par 	*   'https://%s/...' 	*";
$GLOBALS['strThirdPartyComment'] = "* N'oubliez pas de remplacer le texte '{clickurl}' avec	* l'URL de suivi de clics si cette publicityé doit délivrée via un 	* (non-Max) annonceur tiers. 	*";
$GLOBALS['strErrorDatabaseConnetion'] = "Erreur de connexion à la base de données.";
$GLOBALS['strErrorCantConnectToDatabase'] = "Une erreur fatale est survenue %s ne peut pas se connecter à la base de données. Pour cette raison il est impossible d'utiliser l'interface d'administration. La distribution des bannières pourrait aussi être affectée. Les causes possibles de ce problème sont : <ul> <li>Le serveur de base de données ne fonctionne pas pour le moment</li> <li>L'emplacement du serveur de base de données a changé</li> <li>L'identifiant ou le mot de passe utilisés pour contacter la base de données sont incorrects</li> <li>PHP n'a pas chargé l'extension MySQL</li> </ul>";
$GLOBALS['strTimezonePreferences'] = "Préférence de fuseau horaire";
$GLOBALS['strRequiredImpressions'] = "Impressions nécessaires";
$GLOBALS['strRequestedImpressions'] = "Impressions demandées";
$GLOBALS['strActualImpressions'] = "Impressions";
$GLOBALS['strZoneForecast'] = "Prévision de zone";
$GLOBALS['strZonesForecast'] = "Nombre de zones prévues";
$GLOBALS['strZoneImpressions'] = "Impressions de zone";
$GLOBALS['strZonesImpressions'] = "Nombre de zones imprimées";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strRequests_short'] = "Req.";
$GLOBALS['strImpressions_short'] = "Impression";
$GLOBALS['strClicks_short'] = "Clics";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "Conv.";
$GLOBALS['strPendingConversions_short'] = "Conv. en attente";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "Click SR";
$GLOBALS['strNoChannelsAddWebsite'] = "Il n'y a actuellement aucuns canaux ciblés définis, parce qu'il n'y a pas de sites. Pour créer un canal ciblé, <a href='affiliate-edit.php'>ajouter un nouveau site web</a> d'abord.";
$GLOBALS['strConfirmDeleteChannels'] = "Voulez-vous vraiment supprimer ce canal ciblé ?";
$GLOBALS['strYouDontHaveAccess'] = "Vous n'avez pas accès à cette page. Vous avez été redirigé.";
$GLOBALS['strAdvertiserHasBeenUpdated'] = "L'annonceur <a href='%s'>%s</a> a été mis à jour";
$GLOBALS['strAdvertisersHaveBeenDeleted'] = "Tous les annonceurs sélectionnés ont été supprimés";
$GLOBALS['strTrackerHasBeenAdded'] = "Le traceur <a href='%s'>%s</a> a été ajouté";
$GLOBALS['strTrackerHasBeenUpdated'] = "Le traceur <a href='%s'>%s</a> a été mis à jour";
$GLOBALS['strTrackerVarsHaveBeenUpdated'] = "Les variables du traceur <a href='%s'>%s</a> ont été mises à jour";
$GLOBALS['strTrackerCampaignsHaveBeenUpdated'] = "Les campagnes liées au traceur <a href='%s'>%s</a> ont été mises à jour";
$GLOBALS['strTrackerAppendHasBeenUpdated'] = "Le code de fin de traceur du traceur <a href='%s'>%s</a> a été mis à jour";
$GLOBALS['strTrackerHasBeenDeleted'] = "Le traceur <b>%s</b> a été supprimé";
$GLOBALS['strTrackersHaveBeenDeleted'] = "Tous les traceurs sélectionnés ont été supprimés";
$GLOBALS['strTrackerHasBeenDuplicated'] = "Le traceur <a href='%s'>%s</a> a été copié vers <a href='%s'>%s</a>";
$GLOBALS['strTrackerHasBeenMoved'] = "Le traceur <b>%s</b> a été déplacé vers l'annonceur <b>%s</b>";
$GLOBALS['strCampaignHasBeenUpdated'] = "La campagne <a href='%s'>%s</a> a été mise à jour";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "Les traceurs liés à la campagne <a href='%s'>%s</a> ont été mis à jour";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "Toutes les campagnes sélectionnées ont été mises à jour";
$GLOBALS['strCampaignHasBeenDuplicated'] = "La campagne <a href='%s'>%s</a> a été déplacée vers <a href='%s'>%s</a>";
$GLOBALS['strCampaignHasBeenMoved'] = "La campagne <b>%s</b> a été déplacée vers l'annonceur <b>%s</b>";
$GLOBALS['strBannerHasBeenUpdated'] = "La bannière <a href='%s'>%s</a> a été mise à jour";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "Les paramètres avancées pour la bannière <a href='%s'>%s</a> ont été mis à jour";
$GLOBALS['strBannerAclHasBeenUpdated'] = "Les options de distribution de la bannière <a href='%s'>%s</a> ont été mises à jour";
$GLOBALS['strBannersHaveBeenDeleted'] = "Toutes les bannières sélectionnées ont été supprimées";
$GLOBALS['strBannerHasBeenDuplicated'] = "La bannière <a href='%s'>%s</a> a été copiée vers <a href='%s'>%s</a>";
$GLOBALS['strBannerHasBeenMoved'] = "La bannière <b>%s</b> a été déplacée vers la campagne <b>%s</b>";
$GLOBALS['strBannerHasBeenActivated'] = "La bannière <a href='%s'>%s</a> a été activée";
$GLOBALS['strBannerHasBeenDeactivated'] = "La bannière <a href='%s'>%s</a> a été désactivée";
$GLOBALS['strXZonesLinked'] = "<b>%s</b> zone(s) liée(s)";
$GLOBALS['strXZonesUnlinked'] = "<b>%s</b> zone(s) déliée(s)";
$GLOBALS['strWebsiteHasBeenUpdated'] = "Le site <a href='%s'>%s</a> a été mis à jour";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "Tous les sites sélectionnés ont été supprimés";
$GLOBALS['strZoneHasBeenUpdated'] = "La zone <a href='%s'>%s</a> a été mise à jour";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "Les paramètres avancés pour la zone <a href='%s'>%s</a> ont été mis à jour";
$GLOBALS['strZonesHaveBeenDeleted'] = "Toutes les zones sélectionnées ont été mises à jour";
$GLOBALS['strZoneHasBeenDuplicated'] = "La zone <a href='%s'>%s</a> a été copiée vers <a href='%s'>%s</a>";
$GLOBALS['strZoneHasBeenMoved'] = "La zone <b>%s</b> a été déplacée vers le site <b>%s</b>";
$GLOBALS['strZoneLinkedBanner'] = "La bannière a été liée à la zone <a href='%s'>%s</a>";
$GLOBALS['strZoneLinkedCampaign'] = "La campagne a été liée à la zone <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedBanner'] = "La bannière a été déliée de la zone <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedCampaign'] = "La campagne a été déliée de la zone <a href='%s'>%s</a>";
$GLOBALS['strChannelHasBeenUpdated'] = "Le canal ciblé <a href='%s'>%s</a> a été mis à jour";
$GLOBALS['strChannelAclHasBeenUpdated'] = "Les options de distribution pour le canal ciblé <a href='%s'>%s</a> ont été mises à jour";
$GLOBALS['strChannelsHaveBeenDeleted'] = "Tous les canaux ciblés sélectionnés ont été supprimés";
$GLOBALS['strChannelHasBeenDuplicated'] = "Le canal ciblé <a href='%s'>%s</a> a été copié vers <a href='%s'>%s</a>";
$GLOBALS['strUserPreferencesUpdated'] = "Vos <b>%s</b> préferences ont été mises à jour";
$GLOBALS['strPreferencesHaveBeenUpdated'] = "Les préférences ont été mises à jour";
$GLOBALS['strEmailChanged'] = "Votre e-mail a été changé";
$GLOBALS['strPasswordChanged'] = "Votre mot de passe a été changé";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> a été mis à jour";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> a été mis à jour";
$GLOBALS['strUpdateSettings'] = "Paramètres de mise à jour";
$GLOBALS['strWhenCheckingForUpdates'] = "Lors de la vérification des mises à jour";
$GLOBALS['strXPositiveWholeNumberField'] = "%s doit être un nombre entier positif";
$GLOBALS['strInvalidWebsiteURL'] = "URL de site invalide";
$GLOBALS['strDifference'] = "Différence (%)";
$GLOBALS['strPercentageOfTotal'] = "% Total";
$GLOBALS['strDashboardCommunity'] = "Communauté";
$GLOBALS['strDashboardDashboard'] = "Tableau de bord";
$GLOBALS['strCapped'] = "Encapsulé";
$GLOBALS['strNoCapping'] = "Non encapsulé";
$GLOBALS['strSite'] = "Site";
$GLOBALS['strHiddenWebsite'] = "Site internet";
$GLOBALS['strWarningTag1'] = "Avertissement, tag";
$GLOBALS['strWarningTag2'] = "n'est peut être pas ouvert/fermé";
$GLOBALS['strBannerType'] = "Type de publicité";
$GLOBALS['strAdserverTypeAtlas'] = "Rich Media - Atlas";
$GLOBALS['strAdserverTypeBluestreak'] = "Rich Media - Bluestreak";
$GLOBALS['strAdserverTypeDoubleclick'] = "Rich Media - DoubleClick";
$GLOBALS['strAdserverTypeEyeblaster'] = "Rich Media - Eyeblaster";
$GLOBALS['strAdserverTypeFalk'] = "Rich Media - Falk";
$GLOBALS['strAdserverTypeMediaplex'] = "Rich Media - Mediaplex";
$GLOBALS['strAdserverTypeTangozebra'] = "Rich Media - Tango Zebra";
$GLOBALS['strAppendTrackerNotPossible'] = "Il n'est pas possible d'ajouter ce traceur.";
$GLOBALS['strRecordLengthTooBig'] = "Taille de l'enregistrement trop longue";
$GLOBALS['strRecordNonInt'] = "Cette valeur doit être numérique.";
$GLOBALS['strRecordWasNotInserted'] = "Cet enregistrement n'a pas été inséré";
$GLOBALS['strWrongColumnPart1'] = "<br>Erreur dans le fichier CSV! Colonne <b>";
$GLOBALS['strWrongColumnPart2'] = "</b> n'est pas autorisée pour ce traceur";
$GLOBALS['strMissingColumnPart1'] = "<br>Erreur dans le fichier CSV! Colonne <b>";
$GLOBALS['strMissingColumnPart2'] = "</b> est absent(e)";
$GLOBALS['strYouHaveNoTrackers'] = "L'annonceur n'a pas de traceur!";
$GLOBALS['strYouHaveNoCampaigns'] = "L'annonceur n'a pas de campagne!";
$GLOBALS['strYouHaveNoBanners'] = "La campagne n'a pas de bannières!";
$GLOBALS['strYouHaveNoZones'] = "La bannière n'est pas liée à une zone!";
$GLOBALS['strNoBannersDropdown'] = "\--Pas de bannières trouvées--";
$GLOBALS['strNoZonesDropdown'] = "\--Pas de zones trouvées--";
$GLOBALS['strInsertErrorPart1'] = "<br><br><center><b> Erreur, ";
$GLOBALS['strDuplicatedValue'] = "Valeur en double!";
$GLOBALS['strInsertCorrect'] = "<br><br><center><b> Le fichier a bien été téléchargé </b></center>";
$GLOBALS['strReuploadCsvFile'] = "Recharger le fichier CSV";
$GLOBALS['strConfirmUpload'] = "Confirmer le téléchargement";
$GLOBALS['strLoadedRecords'] = "Enregistrements reçus";
$GLOBALS['strBrokenRecords'] = "Champs corrompus dans tous les enregistrements";
$GLOBALS['strWrongDateFormat'] = "Mauvais format de date";
$GLOBALS['str_pt_PT'] = "Portugais Portugal";
$GLOBALS['str_sq'] = "Albanien";
$GLOBALS['strSyncSettings'] = "Paramètres de synchronisation";
$GLOBALS['strEnableCookies'] = "Vous devez autoriser les cookies afin d'utiliser ". MAX_PRODUCT_NAME ."";
$GLOBALS['strHideInactiveOverview'] = "Masquer les objets inactifs de toutes les pages de vue d'ensemble";
$GLOBALS['strHiddenPublisher'] = "Site web";
$GLOBALS['strDefaultConversionRules'] = "Règles de conversion par défaut";
$GLOBALS['strClickWindow'] = "Fenêtre de clic";
$GLOBALS['strViewWindow'] = "Fenêtre d'affichage";
$GLOBALS['strAppendNewTag'] = "Ajouter un nouveau tag";
$GLOBALS['strMoveUp'] = "Monter";
$GLOBALS['strMoveDown'] = "Descendre";
$GLOBALS['strRestart'] = "Redémarrer";
$GLOBALS['strRegexMatch'] = "Expression régulière correspondante";
$GLOBALS['strRegexNotMatch'] = "Expression régulière non correspondante";
$GLOBALS['strIsAnyOf'] = "Fait partie de";
$GLOBALS['strIsNotAnyOf'] = "Ne fait pas partie de";
$GLOBALS['strCappingBanner']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingBanner']['limit'] = "Limiter les affichages de la bannière à :";
$GLOBALS['strCappingCampaign']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingCampaign']['limit'] = "Limiter les affichages de la campagne à :";
$GLOBALS['strCappingZone']['title'] = "{$GLOBALS['strDeliveryCapping']}";
$GLOBALS['strCappingZone']['limit'] = "Limiter les affichages de la zone à :";
$GLOBALS['strPickCategory'] = "\- choisir une catégorie -";
$GLOBALS['strPickCountry'] = "\- choisir un pays -";
$GLOBALS['strPickLanguage'] = "\- choisir une langue -";
$GLOBALS['strKeywordStatistics'] = "Statistiques des mots-clés";
$GLOBALS['strNoWebsites'] = "Aucun site web";
$GLOBALS['strSomeWebsites'] = "Certains sites web";
$GLOBALS['strVariableHiddenTo'] = "Variable masquée pour";
$GLOBALS['strHide'] = "Masquer :";
$GLOBALS['strShow'] = "Afficher :";
$GLOBALS['strInstallWelcome'] = "Bienvenue dans ". MAX_PRODUCT_NAME ."";
$GLOBALS['strTimezoneInformation'] = "Fuseau horaire (modifier le fuseau horaire affectera les statistiques)";
$GLOBALS['strDebugSettings'] = "Journalisation du débogage";
$GLOBALS['strDeliveryBanner'] = "Paramètres généraux de distribution des bannières";
$GLOBALS['strIncovationDefaults'] = "Paramètres par défaut de l'invocation";
$GLOBALS['strStatisticsLogging'] = "Paramètres généraux de journalisation des statistiques";
$GLOBALS['strMaintenaceSettings'] = "Paramètres généraux de maintenance";
$GLOBALS['strMaintenanceAdServerInstalled'] = "Traiter les statistiques du module serveur de publicité";
$GLOBALS['strMaintenanceTrackerInstalled'] = "Traiter les statistiques du module de suivi";
$GLOBALS['strMaintenanceCompactStats'] = "Supprimer les statistiques brutes après le traitement";
$GLOBALS['strMaintenanceCompactStatsGrace'] = "Période de grâce avant la suppression des statistiques traitées (secondes)";
$GLOBALS['strWarnCompactStatsGrace'] = "La période de grâce des statistiques compactes doit être un entier positif";
$GLOBALS['strIn'] = "dans";
$GLOBALS['strEventDetails'] = "Détails de l'évènement";
$GLOBALS['strEventHistory'] = "Historique des évènements";
$GLOBALS['strLinkNewUser_Key'] = "Lier un <u>u</u>tilisateur";
$GLOBALS['strLinkUserHelp'] = "Pour ajouter un <b>utilisateur existant</b>, tapez l'%s et cliquez sur {$GLOBALS['strLinkUser']}<br />Pour ajouter un <b>nouvel utilisateur</b>, tapez l'%s voulu et cliquez sur {$GLOBALS['strLinkUser']}";
$GLOBALS['strOpenadsImpressionsRemaining'] = "Impressions OpenX restantes";
$GLOBALS['strOpenadsImpressionsRemainingHelp'] = "Le nombre d'impressions restantes de la campagne est trop petit pour satisfaire au nombre réservé par l'annonceur. Cela veut dire que le nombre local de clics restants est inférieur au nombre central de clics restants et que vous devriez augmenter les impressions réservées de la valeur manquante.";
$GLOBALS['strOpenadsClicksRemaining'] = "Clics OpenX restants";
$GLOBALS['strOpenadsConversionsRemaining'] = "Conversions OpenX restantes";
$GLOBALS['strNoDataToDisplay'] = "Il n'y a aucune donnée à afficher.";
$GLOBALS['strDisagreeACL_BannersExplaination'] = "Dans certaines circonstances, le moteur de distribution peut entrer en conflit avec les limitations stockées pour les bannières et les canaux, utilisez le lien suivant pour valider les limitations dans la base de données";
$GLOBALS['strHomePageDisabled'] = "Votre page d'accueil est désactivée";
$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "Bannière IAB (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "Skyscraper IAB (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "Méga bannière IAB (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "Bouton 1 IAB (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "Bouton 2 IAB (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "Demi bannière IAB (234 x 60)";
$GLOBALS['strIab']['IAB_LeaderBoard(728x90)*'] = "Méga bannière IAB (728 x 90) *";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "Micro barre IAB (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "Bouton carré IAB (125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "Rectangle IAB (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "Pop-up carré IAB (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "Bannière verticale IAB (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "Pavé IAB (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "Méga pavé IAB (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "Pavé vertical IAB (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "Méga skyscraper IAB (160 x 600)";
$GLOBALS['strRevenueShort'] = "Rec.";
$GLOBALS['strCostShort'] = "Coût";
$GLOBALS['strBasketValueShort'] = "VP";
$GLOBALS['strNumberOfItemsShort'] = "Nb. articles";
$GLOBALS['strRevenueCPCShort'] = "Rec. CPC";
$GLOBALS['strCostCPCShort'] = "Coût CPC";
$GLOBALS['strTechnologyCostShort'] = "Coût tech.";
$GLOBALS['strIncomeShort'] = "Revenus";
$GLOBALS['strIncomeMarginShort'] = "Marge rev.";
$GLOBALS['strProfitShort'] = "Profit";
$GLOBALS['strMarginShort'] = "Marge";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "MISE À JOUR TERMINÉE";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "MISE À JOUR ÉCHOUÉE";
$GLOBALS['strConversionsShort'] = "Conv.";
$GLOBALS['strPendingConversionsShort'] = "Conv. en attente";
$GLOBALS['strClickSRShort'] = "TV clics";
$GLOBALS['phpAds_hlp_my_header'] = "Vous devriez indiquer ici le chemin vers les fichiers d'en-tête (ex. : /home/login/www/header.htm) pour avoir un en-tête et/ou un pied de page sur chaque page de l'interface d'administration. Vous pouvez mettre du texte ou du html dans ces fichiers (si vous ne voulez pas utiliser de html dans l'un ou l'autre des fichiers, ou les deux, n'utilisez pas de balises telles que <body> ou <html>).";
$GLOBALS['strReportBug'] = "Signaler un bogue";
$GLOBALS['strSameWindow'] = "Même fenêtre";
$GLOBALS['strNewWindow'] = "Nouvelle fenêtre";
$GLOBALS['strClick-ThroughRatio'] = "Taux de clics";
$GLOBALS['strImpressionSRShort'] = "TV impressions";
$GLOBALS['strRequestsShort'] = "Req.";
$GLOBALS['strClicksShort'] = "Clics";
$GLOBALS['strImpressionsShort'] = "Impressions";
$GLOBALS['strCampaignTracker'] = "Suiveur de campagne";
$GLOBALS['strVariable'] = "Variable";
$GLOBALS['strAffiliateExtra'] = "Informations complémentaires sur le site web";
$GLOBALS['strPreference'] = "Préférences";
$GLOBALS['strAccountUserPermissionAssociation'] = "Association de permissions utilisateur du compte";
$GLOBALS['strDeliveryLimitation'] = "Limitations de distribution";
$GLOBALS['strSaveAnyway'] = "Sauver quand même";
$GLOBALS['str_ID'] = "ID";
$GLOBALS['str_Requests'] = "Requêtes";
$GLOBALS['str_Impressions'] = "Impressions";
$GLOBALS['str_Clicks'] = "Clics";
$GLOBALS['str_CTR'] = "CTR";
$GLOBALS['str_BasketValue'] = "Valeur du panier";
$GLOBALS['str_TechnologyCost'] = "Coût de la technologie";
$GLOBALS['strAllCampaignsHaveBeenDeleted'] = "Toutes les campagnes de cet annonceur ont été suppriméees";
$GLOBALS['strAllBannersHaveBeenDeleted'] = "Toutes les bannières de cette campagne ont été supprimées";
$GLOBALS['strBlockAdClicksWindow'] = "Clique pour bloquer l'écran de login (secondes)";
$GLOBALS['strDBCreatedSuccessful'] = "Votre base de données a été créée avec succès pour ". MAX_PRODUCT_NAME ."";
$GLOBALS['strUpgradeComplete'] = "Félicitations, vous avez terminé la mise à jour de ". MAX_PRODUCT_NAME ."";
?>