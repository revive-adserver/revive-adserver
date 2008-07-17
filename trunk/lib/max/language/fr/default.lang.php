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
$GLOBALS['strAdminstration'] 			= 'Administration';
$GLOBALS['strMaintenance']			= 'Maintenance';
$GLOBALS['strProbability']			= 'Probabilité';
$GLOBALS['strInvocationcode']			= 'Code d\'invocation';
$GLOBALS['strBasicInformation'] 		= 'Informations générales';
$GLOBALS['strContractInformation'] 		= 'Informations contractuelles';
$GLOBALS['strLoginInformation'] 		= 'Informations de connexion';
$GLOBALS['strOverview']				= 'Aperçu';
$GLOBALS['strSearch']				= '<u>R</u>echerche';
$GLOBALS['strHistory']				= 'Historique';
$GLOBALS['strPreferences']			= 'Préférences';
$GLOBALS['strDetails']				= 'Détails';
$GLOBALS['strCompact']				= 'Résumé';
$GLOBALS['strVerbose']				= 'Complet';
$GLOBALS['strUser']				= 'Utilisateur';
$GLOBALS['strEdit']				= 'Editer';
$GLOBALS['strCreate']				= 'Créer';
$GLOBALS['strDuplicate']			= 'Dupliquer';
$GLOBALS['strMoveTo']				= 'Déplacer vers';
$GLOBALS['strDelete'] 				= 'Supprimer';
$GLOBALS['strActivate']				= 'Activer';
$GLOBALS['strDeActivate'] 			= 'Désactiver';
$GLOBALS['strConvert']				= 'Convertir';
$GLOBALS['strRefresh']				= 'Rafraîchir';
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
$GLOBALS['strUntitled']				= 'Sans-Nom';
$GLOBALS['strAll']				= 'tout';
$GLOBALS['strAvg']				= 'Moy.';
$GLOBALS['strAverage']				= 'Moyenne';
$GLOBALS['strOverall'] 				= 'Général';
$GLOBALS['strTotal']				= 'Total';
$GLOBALS['strActive']				= 'actif';
$GLOBALS['strFrom']				= 'Du';
$GLOBALS['strTo']				= 'A';
$GLOBALS['strLinkedTo']				= 'lié à';
$GLOBALS['strDaysLeft']				= 'Jours restants';
$GLOBALS['strCheckAllNone']			= 'Cocher tous / aucun';
$GLOBALS['strKiloByte']				= 'Ko';
$GLOBALS['strExpandAll']			= 'Tout <u>D</u>évelopper';
$GLOBALS['strCollapseAll']			= '<u>T</u>out réduire';
$GLOBALS['strShowAll']				= 'Tout montrer';
$GLOBALS['strNoAdminInteface']			= 'Service indisponible...';
$GLOBALS['strFilterBySource']			= 'filtrer par source';
$GLOBALS['strFieldContainsErrors']		= 'Le champ suivant contient des erreurs :';
$GLOBALS['strFieldFixBeforeContinue1']		= 'Avant de pouvoir continuer, vous devez';
$GLOBALS['strFieldFixBeforeContinue2']		= 'corriger ces erreurs.';
$GLOBALS['strDelimiter']			= 'Delimiteur';
$GLOBALS['strMiscellaneous']			= 'Divers';


// Properties
$GLOBALS['strName']				= 'Nom ';
$GLOBALS['strSize']				= 'Taille ';
$GLOBALS['strWidth'] 				= 'Largeur ';
$GLOBALS['strHeight'] 				= 'Hauteur ';
$GLOBALS['strURL2']				= 'URL ';
$GLOBALS['strTarget']				= 'Cible ';
$GLOBALS['strLanguage'] 			= 'Langue';
$GLOBALS['strDescription'] 			= 'Description ';
$GLOBALS['strID']				= 'ID';


// Login & Permissions
$GLOBALS['strAuthentification'] 		= 'Authentification';
$GLOBALS['strWelcomeTo']			= 'Bienvenue sur';
$GLOBALS['strEnterUsername']			= 'Entrez votre nom d\'utilisateur et votre mot de passe pour vous connecter.';
$GLOBALS['strEnterBoth']			= 'Veuillez entrer votre nom d\'utilisateur et votre mot de passe';
$GLOBALS['strEnableCookies']			= 'Vous devez activer les cookies sur votre navigateur avant de pouvoir utiliser '.$phpAds_productname;
$GLOBALS['strLogin'] 				= 'Connexion';
$GLOBALS['strLogout'] 				= 'Déconnexion';
$GLOBALS['strUsername'] 			= 'Nom d\'utilisateur';
$GLOBALS['strPassword']				= 'Mot de passe';
$GLOBALS['strAccessDenied']			= 'Accès refusé';
$GLOBALS['strPasswordWrong']			= 'Le mot de passe est incorrect';
$GLOBALS['strNotAdmin']				= 'Vous n\'avez pas la permission d\'effectuer cette opération';
$GLOBALS['strDuplicateClientName']		= 'Le nom d\'utilisateur que vous avez choisi existe déjà; merci d\'en choisir un autre.';
$GLOBALS['strInvalidPassword']			= 'Le nouveau mot de passe est invalide; merci d\'en utiliser un différent.';
$GLOBALS['strNotSamePasswords']			= 'Les deux mots de passe que vous avez entrés ne correspondent pas';
$GLOBALS['strRepeatPassword']			= 'Répeter le mot de passe';
$GLOBALS['strOldPassword']			= 'Ancien mot de passe';
$GLOBALS['strNewPassword']			= 'Nouveau mot de passe';

// General advertising
$GLOBALS['strRequests']             = 'Appel ban';
$GLOBALS['strImpressions'] 				= 'Affichages';
$GLOBALS['strClicks']				= 'Clics';
$GLOBALS['strConversions']			= 'Conversions';
$GLOBALS['strCTRShort'] 			= '% clics';
$GLOBALS['strCTR'] 				    = 'Pourcentage de clics';
$GLOBALS['strCNVR'] 				= 'Tx de conversion';
$GLOBALS['strCNVRShort'] 			= "TC";
$GLOBALS['strTotalViews'] 			= 'Nbre total d\'affichages';
$GLOBALS['strTotalClicks'] 			= 'Nbre total de clics';
$GLOBALS['strViewCredits'] 			= 'Crédits d\'affichages';
$GLOBALS['strClickCredits'] 			= 'Crédits de clics';


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
$GLOBALS['strMonth'] 				= array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
$GLOBALS['strDayShortCuts'] 			= array('Dim','Lun','Mar','Mer','Jeu','Ven','Sam');
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
$GLOBALS['strTotalClients'] 			= 'Nbre total d\'annonceurs';
$GLOBALS['strClientProperties']			= 'Propriétés de l\'annonceur';
$GLOBALS['strClientHistory']			= 'Historique de l\'annonceur';
$GLOBALS['strNoClients']			= 'Aucun annonceur n\'est actuellement enregistré.';
$GLOBALS['strConfirmDeleteClient'] 		= 'Souhaitez-vous supprimer cet annonceur ?';
$GLOBALS['strConfirmResetClientStats']		= 'Souhaitez-vous supprimer les statistiques de cet annonceur ?';
$GLOBALS['strHideInactiveAdvertisers']		= 'Cacher les annonceurs inactifs';
$GLOBALS['strInactiveAdvertisersHidden']	= 'annonceur(s) inactif(s) caché(s)';


// Advertisers properties
$GLOBALS['strContact'] 				= 'Contact';
$GLOBALS['strEMail'] 				= 'Email';
$GLOBALS['strSendAdvertisingReport']		= 'Envoyer un rapport publicitaire par email';
$GLOBALS['strNoDaysBetweenReports']		= 'Nombre de jours entre les rapports';
$GLOBALS['strSendDeactivationWarning']  	= 'Envoyer un avertissement quand la campagne est désactivée';
$GLOBALS['strAllowClientModifyInfo'] 		= 'Permettre à cet annonceur de modifier ses propres paramètres';
$GLOBALS['strAllowClientModifyBanner'] 		= 'Permettre à cet annonceur de modifier ses bannières';
$GLOBALS['strAllowClientAddBanner'] 		= 'Permettre à cet annonceur d\'ajouter des bannières';
$GLOBALS['strAllowClientDisableBanner'] 	= 'Permettre à cet annonceur de désactiver ses propres bannières';
$GLOBALS['strAllowClientActivateBanner'] 	= 'Permettre à cet annonceur d\'activer ses propres bannières';


// Campaign
$GLOBALS['strCampaign']				= 'Campagne';
$GLOBALS['strCampaigns']			= 'Campagnes';
$GLOBALS['strTotalCampaigns']			= 'Nbre total de campagnes ';
$GLOBALS['strActiveCampaigns']			= 'Nbre de campagnes actives ';
$GLOBALS['strAddCampaign'] 			= 'Ajouter une nouvelle campagne';
$GLOBALS['strAddCampaign_Key'] 			= 'Ajouter une <u>n</u>ouvelle campagne';
$GLOBALS['strCreateNewCampaign']		= 'Créer une nouvelle campagne';
$GLOBALS['strModifyCampaign']			= 'Modifier une campagne';
$GLOBALS['strMoveToNewCampaign']		= 'Déplacer vers une nouvelle campagne';
$GLOBALS['strBannersWithoutCampaign']		= 'Bannières sans campagne';
$GLOBALS['strDeleteAllCampaigns']		= 'Supprimer toutes les campagnes';
$GLOBALS['strCampaignStats']			= 'Statistiques Campagne';
$GLOBALS['strCampaignProperties']		= 'Propriétés de la campagne';
$GLOBALS['strCampaignOverview']			= 'Aperçu des campagnes';
$GLOBALS['strCampaignHistory']			= 'Historique de la campagne';
$GLOBALS['strNoCampaigns']			= 'Il n\'y a actuellement aucune campagne enregistrée.';
$GLOBALS['strConfirmDeleteAllCampaigns']	= 'Souhaitez-vous supprimer toutes les campagnes liées à cet annonceur ?';
$GLOBALS['strConfirmDeleteCampaign']		= 'Souhaitez-vous supprimer cette campagne ?';
$GLOBALS['strConfirmResetCampaignStats']	= 'Souhaitez-vous supprimer toutes les statistiques liées à cette campagne ?';
$GLOBALS['strHideInactiveCampaigns']		= 'Cacher les campagnes inactives';
$GLOBALS['strInactiveCampaignsHidden']		= 'campagne(s) inactive(s) cachée(s)';


// Campaign properties
$GLOBALS['strDontExpire']			= 'Cette campagne n\'expirera pas à une date spécifiée';
$GLOBALS['strActivateNow'] 			= 'Activer cette campagne immédiatement';
$GLOBALS['strLow']				= 'basse';
$GLOBALS['strHigh']				= 'haute';
$GLOBALS['strExpirationDate']			= 'Date d\'expiration ';
$GLOBALS['strActivationDate']			= 'Date d\'activation ';
$GLOBALS['strImpressionsPurchased']			= 'Nbre d\'affichages restant ';
$GLOBALS['strClicksPurchased']			= 'Nbre de clics restant ';
$GLOBALS['strCampaignWeight']			= 'Poids de la Campagne ';
$GLOBALS['strHighPriority']			= 'Montrer les bannières de cette campagne avec une priorité haute.<br> Si vous utilisez cette option, '.$phpAds_productname
						 .' essayera de répartir les affichages uniformément sur la durée totale de la campagne.';
$GLOBALS['strLowPriority']			= 'Montrer les bannières de cette campagne avec une priorité basse.<br> Les affichages de cette campagne seront répartis en'
						 .'fonction des objectifs  des campagne ayant une priorité haute.';
$GLOBALS['strTargetLimitAdviews']		= 'Limiter le nombre d\'affichages à ';
$GLOBALS['strTargetPerDay']			= 'par jour.';
$GLOBALS['strPriorityAutoTargeting']		= 'Répartir les affichages restant de façon uniforme sur la durée restante.<br> Le nombre d\'affichage par jour sera'
						 .'automatiquement calculé.';
$GLOBALS['strCampaignWarningNoWeight']		= 'La priorité de cette campagne a été réglée trop basse, ' . "\n" . 'mais le poids est à zéro, ou n\'a pas été spécifié. ' . "\n" . 'Cela va entrainer la désactivation de la campagne, et ses bannières ne seront pas affichées ' . "\n" . 'avant que le poids spécifié ne soit valide. ' . "\n\n" . 'Etes vous sur de vouloir continuer ?';
$GLOBALS['strCampaignWarningNoTarget']		= 'La priorité de cette campagne a été réglée trop haute, ' . "\n" . 'mais la cible en terme d\'affichages n\'a pas été spécifiée. ' . "\n" . 'Cela va entrainer la désactivation de la campagne, et ses bannières ne seront pas affichées ' . "\n" . 'avant que la cible en terme d\'affichages ne soit valide. ' . "\n\n" . 'Etes vous sur de vouloir continuer ?';


// Banners (General)
$GLOBALS['strBanner'] 				= 'Bannière';
$GLOBALS['strBanners'] 				= 'Bannières';
$GLOBALS['strAddBanner'] 			= 'Ajouter une nouvelle bannière';
$GLOBALS['strAddBanner_Key'] 			= 'Ajouter une <u>n</u>ouvelle bannière';
$GLOBALS['strModifyBanner'] 			= 'Modifier cette bannière';
$GLOBALS['strActiveBanners'] 			= 'Nbre de bannières actives ';
$GLOBALS['strTotalBanners'] 			= 'Nbre total de bannières ';
$GLOBALS['strShowBanner']			= 'Voir la bannière';
$GLOBALS['strShowAllBanners']	 		= 'Voir toutes les bannières';
$GLOBALS['strShowBannersNoAdClicks']		= 'Afficher les bannières n\'ayant pas été cliquées';
$GLOBALS['strShowBannersNoAdViews']		= 'Afficher les bannières n\'ayant pas été affichées';
$GLOBALS['strDeleteAllBanners']			= 'Supprimer toutes les bannières';
$GLOBALS['strActivateAllBanners']		= 'Activer toutes les bannières';
$GLOBALS['strDeactivateAllBanners']		= 'Désactiver toutes les bannières';
$GLOBALS['strBannerOverview']			= 'Aperçu des bannières';
$GLOBALS['strBannerProperties']			= 'Propriétés de la bannière';
$GLOBALS['strBannerHistory']			= 'Historique de la bannière';
$GLOBALS['strBannerNoStats'] 			= 'Aucune statistique n\'est actuellement disponible pour cette bannière.';
$GLOBALS['strNoBanners']			= 'Aucune bannière n\'a été trouvée.';
$GLOBALS['strConfirmDeleteBanner']		= 'Souhaitez-vous supprimer cette bannière ?';
$GLOBALS['strConfirmDeleteAllBanners']		= 'Souhaitez-vous supprimer les bannières liées à cette campagne ?';
$GLOBALS['strConfirmResetBannerStats']		= 'Souhaitez-vous supprimer les statistiques liées à cette bannière ?';
$GLOBALS['strShowParentCampaigns']		= 'Montrer les campagnes parentes';
$GLOBALS['strHideParentCampaigns']		= 'Cacher les campagnes parentes';
$GLOBALS['strHideInactiveBanners']		= 'Cacher les bannières inactives';
$GLOBALS['strInactiveBannersHidden']		= 'bannière(s) inactive(s) cachée(s)';
$GLOBALS['strAppendOthers']			= 'Suffixer d\'autres bannières';
$GLOBALS['strAppendTextAdNotPossible']		= 'Il n\'est pas possible de suffixer d\'autre bannières aux publicités textuelles.';


// Banner (Properties)
$GLOBALS['strChooseBanner'] 			= 'Type de bannière :';
$GLOBALS['strMySQLBanner'] 			= 'Bannière Image - serveur SQL';
$GLOBALS['strWebBanner'] 			= 'Bannière Image - serveur Web';
$GLOBALS['strURLBanner'] 			= 'Bannière Image - externe';
$GLOBALS['strHTMLBanner'] 			= 'Bannière HTML';
$GLOBALS['strTextBanner'] 			= 'Publicité textuelle';
$GLOBALS['strAutoChangeHTML']			= 'Autoriser '.$phpAds_productname.' à modifier le HTML, afin de pouvoir compter les clics';
$GLOBALS['strUploadOrKeep']			= 'Voulez vous garder l\'image <br> existante, ou bien souhaitez <br> vous en uploader une autre ?';
$GLOBALS['strNewBannerFile'] 			= 'Image à afficher';
$GLOBALS['strNewBannerURL'] 			= 'URL de la bannière<br>(avec http://)';
$GLOBALS['strURL'] 				= 'URL de destination du clic<br>(avec http://)';
$GLOBALS['strHTML'] 				= 'HTML';
$GLOBALS['strTextBelow'] 			= 'Texte à afficher sous l\'image';
$GLOBALS['strKeyword'] 				= 'Mots clés ';
$GLOBALS['strWeight'] 				= 'Poids de la bannière';
$GLOBALS['strAlt'] 				= 'Texte de la bulle contextuelle (Alt)';
$GLOBALS['strStatusText']			= 'Texte de la barre d\'état';
$GLOBALS['strBannerWeight']			= 'Poids de la bannière ';


// Banner (swf)
$GLOBALS['strCheckSWF']				= 'Vérifier l\'absence de liens codés en dur dans l\'animation Flash';
$GLOBALS['strConvertSWFLinks']			= 'Convertir les liens codés en dur de l\'animation Flash';
$GLOBALS['strHardcodedLinks']			= 'Liens codés en dur';
$GLOBALS['strConvertSWF']			= '<br>L\'animation Flash que vous avez choisie contient des liens codés en dur. '.$phpAds_productname.' ne pourra '
						 .'pas compter les clics pour cette bannières à moins que vous les convertissiez en liens dynamiques. '
						 .'Vous trouverez ci-dessous une liste de tous les liens erronés présents dans l\'animation flash. '
						 .'Si vous souhaitez que '.$phpAds_productname.' essaye de convertir ces liens, choisissez <b>Convertir</b>, autrement'
						 .'<b>Annulez</b>.<br><br>'
						 .'Veuillez noter : si vous demandez à '.$phpAds_productname.' de convertir l\'animation Flash, elle sera modifiée. '
						 .'<br>Veuillez donc en garder une copie de sauvegarde. D\'autre part, quelquesoit la version de Flash avec laquelle vous avez '
						 .'crée l\'animation, le fichier résultant nécessitera le lecteur Flash 4 (ou plus) pour s\'afficher correctement.';
$GLOBALS['strCompressSWF']			= 'Compresser le fichier SWF pour un téléchargement plus rapide (Lecteur Flash 6 requis)';
$GLOBALS['strOverwriteSource']			= 'Outrepasser le paramètre de source';


// Banner (network)
$GLOBALS['strBannerNetwork']			= 'Bannière HTML avec modèle';
$GLOBALS['strChooseNetwork']			= 'Choisissez le modèle que vous souhaitez utiliser';
$GLOBALS['strMoreInformation']			= 'Plus d\'informations ...';
$GLOBALS['strRichMedia']			= 'Média riche';
$GLOBALS['strTrackAdClicks']			= 'Comptabiliser les clics';


// Display limitations
$GLOBALS['strModifyBannerAcl']			= 'Options de limitation';
$GLOBALS['strACL'] 				= 'Limites';
$GLOBALS['strACLAdd'] 				= 'Ajouter une nouvelle limitation';
$GLOBALS['strACLAdd_Key']			= 'Ajouter une <u>n</u>ouvelle limitation';
$GLOBALS['strNoLimitations']			= 'Pas de limitations';
$GLOBALS['strApplyLimitationsTo']		= 'Appliquer les limitations à';
$GLOBALS['strRemoveAllLimitations']		= 'Retirer toutes les limitations';
$GLOBALS['strEqualTo']				= 'est';
$GLOBALS['strDifferentFrom']			= 'n\'est pas';
$GLOBALS['strLaterThan']			= 'est plus récente que';
$GLOBALS['strLaterThanOrEqual']			= 'est plus récente ou de même date que';
$GLOBALS['strEarlierThan']			= 'est plus ancienne que';
$GLOBALS['strEarlierThanOrEqual']		= 'est plus ancienne ou de même date que';
$GLOBALS['strContains']				= 'contient';
$GLOBALS['strNotContains']			= 'ne contient pas';
$GLOBALS['strAND']				= 'ET';  						// logical operator
$GLOBALS['strOR']				= 'OU'; 						// logical operator
$GLOBALS['strOnlyDisplayWhen']			= 'Afficher uniquement ce bandeau quand :';
$GLOBALS['strWeekDay'] 				= 'Le jour de la semaine';
$GLOBALS['strTime'] 				= 'L\'heure';
$GLOBALS['strUserAgent'] 			= 'L\'agent utilisateur';
$GLOBALS['strDomain'] 				= 'Le domaine';
$GLOBALS['strClientIP'] 			= 'L\'IP du visiteur';
$GLOBALS['strSource'] 				= 'La source';
$GLOBALS['strBrowser'] 				= 'Le navigateur';
$GLOBALS['strOS'] 				= 'Le système d\'exploitation';
$GLOBALS['strReferer'] 				= 'Page d\'origine';
$GLOBALS['strCountry'] 				= 'Le pays';
$GLOBALS['strContinent'] 			= 'Le continent';
$GLOBALS['strDeliveryLimitations']		= 'Limites de distribution';
$GLOBALS['strDeliveryCapping']			= 'Limites de répétition';
$GLOBALS['strTimeCapping']			= 'Une fois affichée, l\'utilisateur ne devra plus avoir cette bannière pendant :';
$GLOBALS['strImpressionCapping']		= 'Cette bannière ne sera pas vue par un utilisateur plus de :';


// Publisher
$GLOBALS['strAffiliate']			= 'Editeur';
$GLOBALS['strAffiliates']			= 'Editeurs';
$GLOBALS['strAffiliatesAndZones']		= 'Editeurs & Zones';
$GLOBALS['strAddNewAffiliate']			= 'Ajouter un nouvel éditeur';
$GLOBALS['strAddNewAffiliate_Key']		= 'Ajouter un <u>n</u>ouvel éditeur';
$GLOBALS['strAddAffiliate']			= 'Créer un éditeur';
$GLOBALS['strAffiliateProperties']		= 'Propriétés de l\'éditeur';
$GLOBALS['strAffiliateOverview']		= 'Aperçu de l\'éditeur';
$GLOBALS['strAffiliateHistory']			= 'Historique de l\'éditeur';
$GLOBALS['strZonesWithoutAffiliate']		= 'Zones sans éditeurs';
$GLOBALS['strMoveToNewAffiliate']		= 'Déplacer vers un nouvel éditeur';
$GLOBALS['strNoAffiliates']			= 'Aucun éditeur n\'est actuellement enregistré.';
$GLOBALS['strConfirmDeleteAffiliate']		= 'Souhaitez-vous supprimer cet éditeur ?';
$GLOBALS['strMakePublisherPublic']		= 'Rendre publiques les zones liées à cet éditeur';


// Publisher (properties)
$GLOBALS['strWebsite']				= 'Site Web';
$GLOBALS['strAllowAffiliateModifyInfo'] 	= 'Permettre à cet éditeur de modifier ses propres paramètres';
$GLOBALS['strAllowAffiliateModifyZones'] 	= 'Permettre à cet éditeur de modifier ses propres zones';
$GLOBALS['strAllowAffiliateLinkBanners'] 	= 'Permettre à cet éditeur de lier des bannières à ses propres zones';
$GLOBALS['strAllowAffiliateAddZone']		= 'Permettre à cet éditeur de définir de nouvelles zones';
$GLOBALS['strAllowAffiliateDeleteZone'] 	= 'Permettre à cet éditeur de supprimer des zones existantes';


// Zone
$GLOBALS['strZone']				= 'Zone';
$GLOBALS['strZones']				= 'Zones';
$GLOBALS['strAddNewZone']			= 'Ajouter une nouvelle zone';
$GLOBALS['strAddNewZone_Key']			= 'Ajouter une <u>n</u>ouvelle zone';
$GLOBALS['strAddZone']				= 'Créer une zone';
$GLOBALS['strModifyZone']			= 'Modifier une zone';
$GLOBALS['strLinkedZones']			= 'Zones liées';
$GLOBALS['strZoneOverview']			= 'Aperçu des zones';
$GLOBALS['strZoneProperties']			= 'Propriétés de la zone';
$GLOBALS['strZoneHistory']			= 'Historique de la zone';
$GLOBALS['strNoZones']				= 'Aucune zone n\'est actuellement enregistrée';
$GLOBALS['strConfirmDeleteZone']		= 'Souhaitez-vous supprimer cette zone ?';
$GLOBALS['strZoneType']				= 'Type de zone';
$GLOBALS['strBannerButtonRectangle']		= 'Bannière, Bouton ou Rectangle';
$GLOBALS['strInterstitial']			= 'Interstitiel, ou DHTML flottant';
$GLOBALS['strPopup']				= 'Popup';
$GLOBALS['strTextAdZone']			= 'Publicité textuelle';
$GLOBALS['strShowMatchingBanners']		= 'Montrer les bannières correspondantes';
$GLOBALS['strHideMatchingBanners']		= 'Cacher les bannières correspondantes';


// Advanced zone settings
$GLOBALS['strAdvanced']				= 'Avancé';
$GLOBALS['strChains']				= 'Chaînes';
$GLOBALS['strChainSettings']			= 'Paramètres de la chaîne';
$GLOBALS['strZoneNoDelivery']			= 'Si aucune bannière de cette zone ne peut être délivrée :';
$GLOBALS['strZoneStopDelivery']			= 'Arrêter la distribution, et ne montrer aucune bannière';
$GLOBALS['strZoneOtherZone']			= 'Montrer la zone sélectionnée à la place ';
$GLOBALS['strZoneUseKeywords']			= 'Sélectionnez une bannière en utilisant les mots clés spécifiés ci-dessous ';
$GLOBALS['strZoneAppend']			= 'Toujours faire suivre le code d\'invocation des bannières de cette zone par le code HTML ci-contre';
$GLOBALS['strAppendSettings']			= 'Paramètres de préfixation et de suffixation';
$GLOBALS['strZonePrependHTML']			= 'Toujours afficher le code HTML suivant avant les publicités textuelles de cette zone';
$GLOBALS['strZoneAppendHTML']			= 'Toujours afficher le code HTML suivant après les publicités textuelles de cette zone';
$GLOBALS['strZoneAppendType']                   = 'Type de code à faire suivre';
$GLOBALS['strZoneAppendHTMLCode']               = 'Code HTML';
$GLOBALS['strZoneAppendZoneSelection']  	= 'Popup ou interstitiel';
$GLOBALS['strZoneAppendSelectZone']             = 'Toujours faire suivre le code d\'invocation des bannières de cette zone par le popup ou interstitiel ci-contre';

// Zone probability
$GLOBALS['strZoneProbListChain']		= 'Les bannières de cette zones sont toutes actuellement inactives. Voici la zone chainée qui sera utilisée :';
$GLOBALS['strZoneProbNullPri']			= 'Toutes les bannières liées à cette zone sont actuellement inactives.';
$GLOBALS['strZoneProbListChainLoop']		= 'Les paramètres de chaînes existants conduisent à une boucle circulaire infinie. C\'est pourquoi cette zone est suspendue.';

// Linked banners/campaigns
$GLOBALS['strSelectZoneType']			= 'Type de bannières liées à éditer :';
$GLOBALS['strBannerSelection']			= 'Sélection des bannières';
$GLOBALS['strCampaignSelection']		= 'Sélection des campagnes';
$GLOBALS['strInteractive']			= 'Interactif';
$GLOBALS['strRawQueryString']			= 'Sélection par mots clés';
$GLOBALS['strIncludedBanners']			= 'Bannières liées';
$GLOBALS['strLinkedBannersOverview']		= 'Aperçu des bannières liées';
$GLOBALS['strLinkedBannerHistory']		= 'Historique des bannières liées';
$GLOBALS['strNoZonesToLink']			= 'Aucune zone ne peut actuellement être liée à cette bannière.';
$GLOBALS['strNoBannersToLink']			= 'Aucune bannière ne peut être liée à cette zone.';
$GLOBALS['strNoLinkedBanners']			= 'Aucune bannière n\'est liée à cette zone.';
$GLOBALS['strMatchingBanners']			= '{count} bannières correspondantes';
$GLOBALS['strNoCampaignsToLink']		= 'Aucune campagne ne peut être liée à cette zone.';
$GLOBALS['strNoZonesToLinkToCampaign']  	= 'Aucune zone ne peut être liée à cette campagne.';
$GLOBALS['strSelectBannerToLink']		= 'Sélectionnez la bannière que vous souhaiteriez lier à cette zone:';
$GLOBALS['strSelectCampaignToLink']		= 'Sélectionnez la campagne que vous souhaiteriez lier à cette zone:';


// Statistics
$GLOBALS['strStats'] 				= 'Statistiques';
$GLOBALS['strNoStats']				= 'Aucune statistique n\'est actuellement disponibles.';
$GLOBALS['strConfirmResetStats']		= 'Souaitez-vous supprimer l\'intégralité des statistiques ?';
$GLOBALS['strGlobalHistory']			= 'Historique global';
$GLOBALS['strDailyHistory']			= 'Historique quotidien';
$GLOBALS['strDailyStats'] 			= 'Statistiques quotidiennes';
$GLOBALS['strWeeklyHistory']			= 'Historique hebdomadaire';
$GLOBALS['strMonthlyHistory']			= 'Historique mensuel';
$GLOBALS['strCreditStats'] 			= 'Statistiques des crédits';
$GLOBALS['strDetailStats'] 			= 'Statistiques détaillées';
$GLOBALS['strTotalThisPeriod']			= 'Total pour cette période';
$GLOBALS['strAverageThisPeriod']		= 'Moyenne pour cette période';
$GLOBALS['strDistribution']			= 'Répartition';
$GLOBALS['strResetStats'] 			= 'Réinitialiser les statistiques';
$GLOBALS['strSourceStats']			= 'Statistiques des sources';
$GLOBALS['strSelectSource']			= 'Sélectionnez la source que vous souhaitez voir:';
$GLOBALS['strSizeDistribution']			= 'Répartition par taille';
$GLOBALS['strCountryDistribution']		= 'Répartition par pays';
$GLOBALS['strEffectivity']			= 'Effectivité';
$GLOBALS['strTargetStats']			= 'Statistiques d\'objectifs';
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
$GLOBALS['strExpiration'] 			= 'Expiration ';
$GLOBALS['strNoExpiration'] 			= 'Pas de date d\'expiration';
$GLOBALS['strEstimated'] 			= 'Date d\'expiration estimée';


// Reports
$GLOBALS['strReports']				= 'Rapports';
$GLOBALS['strSelectReport']			= 'Rapport à générer';


// Userlog
$GLOBALS['strUserLog']				= 'Journal utilisateur';
$GLOBALS['strUserLogDetails']			= 'Détails du journal utilisateur';
$GLOBALS['strDeleteLog']			= 'Vider le journal';
$GLOBALS['strAction']				= 'Action';
$GLOBALS['strNoActionsLogged']			= 'Aucune action n\'a été écrite dans le journal.';


// Code generation
$GLOBALS['strGenerateBannercode']               = 'Sélection directe';
$GLOBALS['strChooseInvocationType']		= 'Type d\'invocation des bannières';
$GLOBALS['strGenerate']				= 'Générer';
$GLOBALS['strParameters']			= 'Paramètres';
$GLOBALS['strFrameSize']			= 'Taille de la frame';
$GLOBALS['strBannercode']			= 'Code d\'invocation de la bannière';
$GLOBALS['strOptional']                         = 'optionnel';

// Errors
$GLOBALS['strMySQLError'] 			= 'Erreur SQL :';
$GLOBALS['strLogErrorClients']			= '[phpAds] Une erreur est survenue lors de la récupération des annonceurs dans la base de données.';
$GLOBALS['strLogErrorBanners']			= '[phpAds] Une erreur est survenue lors de la récupération des bannières dans la base de données.';
$GLOBALS['strLogErrorViews'] 			= '[phpAds] Une erreur est survenue lors de la récupération des nombres d\'affichages dans la base de données.';
$GLOBALS['strLogErrorClicks']			= '[phpAds] Une erreur est survenue lors de la récupération des clics dans la base de données.';
$GLOBALS['strErrorViews'] 			= 'Vous devez indiquer le nombre d\'affichages ou cocher la case \'illimité\' !';
$GLOBALS['strErrorNegViews'] 			= 'Nombre d\'affichage négatif non autorisé';
$GLOBALS['strErrorClicks'] 			= 'Vous devez indiquer le nombre de clics ou cocher la case \'illimité\' !';
$GLOBALS['strErrorNegClicks']			= 'Nombre de clics négatif non autorisé';
$GLOBALS['strNoMatchesFound']			= 'Aucune correspondance n\'a été trouvée';
$GLOBALS['strErrorOccurred']			= 'Une erreur est survenue';
$GLOBALS['strErrorUploadSecurity']		= 'Un problème potentiel de sécurité a été détecté. L\'envoi a été arrêté.';
$GLOBALS['strErrorUploadBasedir']		= $phpAds_productname .' ne peut accéder au fichier envoyé; cela est probablement dû au mode de sécurité PHP (safemode), ou d\'une restriction de la fonction \'open_basedir\'.';
$GLOBALS['strErrorUploadUnknown']		= $phpAds_productname .' ne peut accéder au fichier envoyé, et ce pour une raison inconnue. Veuillez vérifier votre configuration PHP.';
$GLOBALS['strErrorStoreLocal']			= 'Une erreur est survenue lors de la copie de la bannière dans le répertoire local. Cela est probablement dû à une mauvaise configuration des paramètres du répertoire local';
$GLOBALS['strErrorStoreFTP']			= 'Une erreur est survenue lors de la copie de la bannière sur le serveur FTP. Cela est probablement dû à l\'indisponibilité du serveur FTP, ou à une mauvaise configuration des paramètres du serveur FTP.';
$GLOBALS['strErrorDBPlain']			= 'Une erreur est survenue lors de l\'accès à la base de données';
$GLOBALS['strErrorDBSerious']			= 'Un problème grave concernant la base de données à été détecté';
$GLOBALS['strErrorDBNoDataPlain']		= 'A cause d\'un problème lié à la base de donnée, '.$phpAds_productname.' n\'a pas pu récupérer ou écrire les informations. ';
$GLOBALS['strErrorDBNoDataSerious']		= 'A cause d\'un problème grave lié à la base de donnée, '.$phpAds_productname.' n\'a pas pu récupérer les informations. ';
$GLOBALS['strErrorDBCorrupt']			= 'La table de la base de données est probablement corrompue et doit être réparée. Pour plus d\'informations concernant la réparation des tables, veuillez lire le chapitre <i>Troubleshooting</i> du <i>Guide de l\'administrateur</i> (Administrator Guide, en anglais).';
$GLOBALS['strErrorDBContact']			= 'Veuillez contacter l\'administrateur de ce serveur, et avertissez le de ce problème.';
$GLOBALS['strErrorDBSubmitBug']			= 'Si ce problème est reproductible, il pourrait être causé par un bug de '.$phpAds_productname.'. Merci d\'envoyer les informations suivantes aux créateurs de '.$phpAds_productname.'. Dans votre message, essayez aussi de décrire le plus clairement possible les actions que vous avez effectuées et qui ont conduit à cette erreur (NdT: merci de leur écrire en anglais. Si vous ne pouvez, envoyez votre message au traducteur français, qui transmettra).';
$GLOBALS['strMaintenanceNotActive']             = 'Le script de maintenance n\'a pas été exécuté dans les dernières 24 heures. \nAfin que '.$phpAds_productname.' puisse fonctionner, il doit être exécuté \n chaque heure. \n\nLisez le Guide de l\'Administrateur pour plus d\'informations \nconcernant le script de maintenance.';

// E-mail
$GLOBALS['strMailSubject'] 			= 'Bilan publicitaire';
$GLOBALS['strAdReportSent']			= 'Rapport envoyé';
$GLOBALS['strMailSubjectDeleted'] 		= 'Publicités désactivées';
$GLOBALS['strMailHeader'] 			= 'Cher {contact},' . "\n";
$GLOBALS['strMailBannerStats']			= 'Vous trouverez ci-joint les statistiques des bannières publicitaires pour {clientname}:';
$GLOBALS['strMailFooter'] 			= 'Cordialement,'. "\n" .'   {adminfullname}';
$GLOBALS['strMailClientDeactivated']		= 'Vos bannières suivantes ont été désactivés car';
$GLOBALS['strMailNothingLeft']			= "\n" .'Si vous souhaitez prolonger votre présence publicitaire sur notre site, nous vous remercions de bien vouloir nous contacter. Nous serions heureux de continuer avec vous.';
$GLOBALS['strClientDeactivated']		= 'Cette campagne est actuellement inactive car';
$GLOBALS['strBeforeActivate']			= 'la date de début de la campagne n\'est pas encore atteinte';
$GLOBALS['strAfterExpire']			= 'la date de fin de la campagne a été atteinte';
$GLOBALS['strNoMoreClicks']			= 'le nombre de de clics souhaités a été atteint';
$GLOBALS['strNoMoreViews']			= 'le nombre d\'affichages souhaités a été atteint';
$GLOBALS['strWeightIsNull']			= 'son poids est à zéro';
$GLOBALS['strWarnClientTxt']			= 'Le nombre de Clic ou d\'Affichages restants est en train de passer sous {limit} pour vos bannières.  '. "\n" .'Dès que ce nombre atteindra zéro, vos bannières ne seront plus affichées. ';
$GLOBALS['strImpressionsClicksLow']			= 'Affichages et Clics sont bas';
$GLOBALS['strNoViewLoggedInInterval']   	= 'Aucune des bannières n\'a été affichée pendant le temps que couvre le rapport';
$GLOBALS['strNoClickLoggedInInterval']  	= 'Aucun clic n\'a été enregistré pendant le durée du rapport';
$GLOBALS['strMailReportPeriod']			= 'Ce rapport inclut les statistiques pour la période du {startdate} au {enddate}.';
$GLOBALS['strMailReportPeriodAll']		= 'Ce rapport inclut les statistiques pour la période allant jusqu\'au {enddate}.';
$GLOBALS['strNoStatsForCampaign'] 		= 'Aucune statistique n\'est disponible pour cette campagne';


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
?>