<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/*                                                                      */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']  		= "ltr";
$GLOBALS['phpAds_TextAlignRight'] 		= "right";
$GLOBALS['phpAds_TextAlignLeft']  		= "left";

$GLOBALS['phpAds_DecimalPoint']			= ',';
$GLOBALS['phpAds_ThousandsSeperator']		= ' ';


// Date & time configuration
$GLOBALS['date_format']				= "%d/%m/%Y";
$GLOBALS['time_format']				= "%H:%i:%S";
$GLOBALS['minute_format']			= "%H:%M";
$GLOBALS['month_format']			= "%m/%Y";
$GLOBALS['day_format']				= "%d/%m";
$GLOBALS['week_format']				= "%W/%Y";
$GLOBALS['weekiso_format']			= "%V/%G";



/*********************************************************/
/* Translations                                          */
/*********************************************************/

$GLOBALS['strHome']				= "Accueil";
$GLOBALS['strHelp']				= "Aide";
$GLOBALS['strNavigation'] 			= "Navigation";
$GLOBALS['strShortcuts'] 			= "Raccourcis";
$GLOBALS['strAdminstration'] 			= "Administration";
$GLOBALS['strMaintenance']			= "Maintenance";
$GLOBALS['strProbability']			= "Probabilité";
$GLOBALS['strInvocationcode']			= "Code d'invocation";
$GLOBALS['strBasicInformation'] 		= "Informations générales";
$GLOBALS['strContractInformation'] 		= "Informations contractuelles";
$GLOBALS['strLoginInformation'] 		= "Informations de connexion";
$GLOBALS['strOverview']				= "Aperçu";
$GLOBALS['strSearch']				= "Recherche";
$GLOBALS['strHistory']				= "Historique";
$GLOBALS['strPreferences']			= "Préférences";
$GLOBALS['strDetails']				= "Détails";
$GLOBALS['strCompact']				= "Résumé";
$GLOBALS['strVerbose']				= "Complet";
$GLOBALS['strUser']				= "Utilisateur";
$GLOBALS['strEdit']				= "Editer";
$GLOBALS['strCreate']				= "Créer";
$GLOBALS['strDuplicate']			= "Dupliquer";
$GLOBALS['strMoveTo']				= "Déplacer vers";
$GLOBALS['strDelete'] 				= "Supprimer";
$GLOBALS['strActivate']				= "Activer";
$GLOBALS['strDeActivate'] 			= "Désactiver";
$GLOBALS['strConvert']				= "Convertir";
$GLOBALS['strRefresh']				= "Rafraîchir";
$GLOBALS['strSaveChanges']		 	= "Enregistrer les modifications";
$GLOBALS['strUp'] 				= "Haut";
$GLOBALS['strDown'] 				= "Bas";
$GLOBALS['strSave'] 				= "Enregistrer";
$GLOBALS['strCancel']				= "Annuler";
$GLOBALS['strPrevious'] 			= "Précédent";
$GLOBALS['strNext'] 				= "Suivant";
$GLOBALS['strYes']				= "Oui";
$GLOBALS['strNo']				= "Non";
$GLOBALS['strNone'] 				= "Aucun";
$GLOBALS['strCustom']				= "Personnalisé";
$GLOBALS['strDefault'] 				= "Par défaut";
$GLOBALS['strOther']				= "Autre";
$GLOBALS['strUnknown']				= "Inconnu";
$GLOBALS['strUnlimited'] 			= "Illimité";
$GLOBALS['strUntitled']				= "Sans-Nom";
$GLOBALS['strAll'] 				= "tout";
$GLOBALS['strAvg'] 				= "Moy.";
$GLOBALS['strAverage']				= "Moyenne";
$GLOBALS['strOverall'] 				= "Général";
$GLOBALS['strTotal'] 				= "Total";
$GLOBALS['strActive'] 				= "actif";
$GLOBALS['strFrom']				= "Du";
$GLOBALS['strTo']				= "A";
$GLOBALS['strLinkedTo'] 			= "lié à";
$GLOBALS['strDaysLeft'] 			= "Jours restants";
$GLOBALS['strCheckAllNone']			= "Cocher tous / aucun";
$GLOBALS['strKiloByte']				= "Ko";
$GLOBALS['strExpandAll']			= "Tout développer";
$GLOBALS['strCollapseAll']			= "Tout réduire";
$GLOBALS['strShowAll']				= "Tout montrer";
$GLOBALS['strNoAdminInteface']			= "Service indisponible...";
$GLOBALS['strFilterBySource']			= "filtrer par source";
$GLOBALS['strFieldContainsErrors']		= "Le champ suivant contient des erreurs:";
$GLOBALS['strFieldFixBeforeContinue1']		= "Avant de pouvoir continuer, vous devez";
$GLOBALS['strFieldFixBeforeContinue2']		= "corriger ces erreurs.";
$GLOBALS['strDelimiter']			= "Delimiteur";
$GLOBALS['strMiscellaneous']			= "Divers";


// Properties
$GLOBALS['strName']				= "Nom";
$GLOBALS['strSize']				= "Taille";
$GLOBALS['strWidth'] 				= "Largeur";
$GLOBALS['strHeight'] 				= "Hauteur";
$GLOBALS['strURL2']				= "URL";
$GLOBALS['strTarget']				= "Cible";
$GLOBALS['strLanguage'] 			= "Langue";
$GLOBALS['strDescription'] 			= "Description";
$GLOBALS['strID']				= "ID";


// Login & Permissions
$GLOBALS['strAuthentification'] 		= "Authentification";
$GLOBALS['strWelcomeTo']			= "Bienvenue sur";
$GLOBALS['strEnterUsername']			= "Entrez votre nom d'utilisateur et votre mot de passe pour vous connecter.";
$GLOBALS['strEnterBoth']			= "Veuillez entrer votre nom d'utilisateur et votre mot de passe";
$GLOBALS['strEnableCookies']			= "Vous devez activer les cookies sur votre navigateur avant de pouvoir utiliser ".$phpAds_productname;
$GLOBALS['strLogin'] 				= "Connexion";
$GLOBALS['strLogout'] 				= "Déconnexion";
$GLOBALS['strUsername'] 			= "Nom d'utilisateur";
$GLOBALS['strPassword']				= "Mot de passe";
$GLOBALS['strAccessDenied']			= "Accès refusé";
$GLOBALS['strPasswordWrong']			= "Le mot de passe est incorrect";
$GLOBALS['strNotAdmin']				= "Vous n'avez pas la permission d'effectuer cette opération";
$GLOBALS['strDuplicateClientName']		= "Le nom d'utilisateur choisi existe déjà, merci d'en choisir un nouveau.";


// General advertising
$GLOBALS['strViews'] 				= "Affichages";
$GLOBALS['strClicks']				= "Clics";
$GLOBALS['strCTRShort'] 			= "% clics";
$GLOBALS['strCTR'] 				= "Pourcentage de clics";
$GLOBALS['strTotalViews'] 			= "Total des affichages";
$GLOBALS['strTotalClicks'] 			= "Total des clics";
$GLOBALS['strViewCredits'] 			= "Crédits d'affichages";
$GLOBALS['strClickCredits'] 			= "Crédits de clics";


// Time and date related
$GLOBALS['strDate'] 				= "Date";
$GLOBALS['strToday'] 				= "Aujourd'hui";
$GLOBALS['strDay']				= "Jour";
$GLOBALS['strDays']				= "Jours";
$GLOBALS['strLast7Days']			= "Derniers 7 jours";
$GLOBALS['strWeek'] 				= "Semaine";
$GLOBALS['strWeeks']				= "Semaines";
$GLOBALS['strMonths']				= "Mois";
$GLOBALS['strThisMonth'] 			= "Ce mois-ci";
$GLOBALS['strMonth'] 				= array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
$GLOBALS['strDayShortCuts'] 			= array("Dim","Lun","Mar","Mer","Jeu","Ven","Sam");
$GLOBALS['strHour']				= "Heure";
$GLOBALS['strSeconds']				= "secondes";
$GLOBALS['strMinutes']				= "minutes";
$GLOBALS['strHours']				= "heures";
$GLOBALS['strTimes']				= "fois";


// Advertiser
$GLOBALS['strClient']				= "Annonceur";
$GLOBALS['strClients'] 				= "Annonceurs";
$GLOBALS['strClientsAndCampaigns']		= "Annonceurs & Campagnes";
$GLOBALS['strAddClient'] 			= "Ajouter un nouvel annonceur";
$GLOBALS['strTotalClients'] 			= "Total annonceurs";
$GLOBALS['strClientProperties']			= "Propriétés de l'annonceur";
$GLOBALS['strClientHistory']			= "Historique de l'annonceur";
$GLOBALS['strNoClients']			= "Il n'y a actuellement aucun annonceur enregistré.";
$GLOBALS['strConfirmDeleteClient'] 		= "Voulez-vous vraiment supprimer cet annonceur ?";
$GLOBALS['strConfirmResetClientStats']		= "Voulez-vous réellement réinitialiser les statistiques de cet annonceur ?";
$GLOBALS['strHideInactiveAdvertisers']		= "Cacher les annonceurs inactifs";
$GLOBALS['strInactiveAdvertisersHidden']	= "annonceur(s) inactif(s) caché(s)";


// Advertisers properties
$GLOBALS['strContact'] 				= "Contact";
$GLOBALS['strEMail'] 				= "Email";
$GLOBALS['strSendAdvertisingReport']		= "Envoyer un rapport publicitaire par email";
$GLOBALS['strNoDaysBetweenReports']		= "Nombre de jours entre les rapports";
$GLOBALS['strSendDeactivationWarning']  	= "Envoyer un avertissement quand la campagne est désactivée";
$GLOBALS['strAllowClientModifyInfo'] 		= "Permettre à cet annonceur de modifier ses propres paramètres";
$GLOBALS['strAllowClientModifyBanner'] 		= "Permettre à cet annonceur de modifier ses bannières";
$GLOBALS['strAllowClientAddBanner'] 		= "Permettre à cet annonceur d'ajouter des bannières";
$GLOBALS['strAllowClientDisableBanner'] 	= "Permettre à cet annonceur de désactiver ses propres bannières";
$GLOBALS['strAllowClientActivateBanner'] 	= "Permettre à cet annonceur d'activer ses propres bannières";


// Campaign
$GLOBALS['strCampaign']				= "Campagne";
$GLOBALS['strCampaigns']			= "Campagnes";
$GLOBALS['strTotalCampaigns'] 			= "Total campagnes";
$GLOBALS['strActiveCampaigns'] 			= "Campagnes actives";
$GLOBALS['strAddCampaign'] 			= "Ajouter une nouvelle campagne";
$GLOBALS['strCreateNewCampaign']		= "Créer une nouvelle campagne";
$GLOBALS['strModifyCampaign']			= "Modifier une campagne";
$GLOBALS['strMoveToNewCampaign']		= "Déplacer vers une nouvelle campagne";
$GLOBALS['strBannersWithoutCampaign']		= "Bannières sans campagne";
$GLOBALS['strDeleteAllCampaigns']		= "Supprimer toutes les campagnes";
$GLOBALS['strCampaignStats']			= "Statistiques Campagne";
$GLOBALS['strCampaignProperties']		= "Propriétés de la campagne";
$GLOBALS['strCampaignOverview']			= "Aperçu des campagnes";
$GLOBALS['strCampaignHistory']			= "Historique de la campagne";
$GLOBALS['strNoCampaigns']			= "Il n'y a actuellement aucune campagne enregistrée.";
$GLOBALS['strConfirmDeleteAllCampaigns']	= "Voulez vous réellement supprimer toutes les campagnes de cet annonceur ?";
$GLOBALS['strConfirmDeleteCampaign']		= "Voulez vous vraiment effacer cette campagne ?";
$GLOBALS['strHideInactiveCampaigns']		= "Cacher les campagnes inactives";
$GLOBALS['strInactiveCampaignsHidden']		= "campagne(s) inactive(s) cachée(s)";


// Campaign properties
$GLOBALS['strDontExpire']			= "Ne pas expirer cette campagne à une date spécifiée";
$GLOBALS['strActivateNow'] 			= "Activer cette campagne immédiatement";
$GLOBALS['strLow']				= "basse";
$GLOBALS['strHigh']				= "haute";
$GLOBALS['strExpirationDate']			= "Date d'expiration";
$GLOBALS['strActivationDate']			= "Date d'activation";
$GLOBALS['strViewsPurchased'] 			= "Nb d'affichages restant";
$GLOBALS['strClicksPurchased'] 			= "Nb de clics restant";
$GLOBALS['strCampaignWeight']			= "Poids de la Campagne";
$GLOBALS['strHighPriority']			= "Montrer les bannières de cette campagne avec une priorité haute.<br>
						   Si vous utilisez cette option, ".$phpAds_productname." essayera
						   de distribuer le nombre d'affichages restants de façon égale dans le temps.";
$GLOBALS['strLowPriority']			= "Montrer les bannières de cette campagne avec une priorité basse.<br>
						   Cette campagne sera utilisé pour les affichages qui ne sont pas utilisés
						   par les campagnes de priorité haute.";
$GLOBALS['strTargetLimitAdviews']		= "Limiter le nombre d'affichages à";
$GLOBALS['strTargetPerDay']			= "par jour.";
$GLOBALS['strPriorityAutoTargeting']		= "Distribue les affichages restants de façon égale sur les jours restants. L'objectif en terme de nombre d'affichages par jour sera réglé en conséquence.";



// Banners (General)
$GLOBALS['strBanner'] 				= "Bannière";
$GLOBALS['strBanners'] 				= "Bannières";
$GLOBALS['strAddBanner'] 			= "Ajouter une nouvelle bannière";
$GLOBALS['strModifyBanner'] 			= "Modifier cette bannière";
$GLOBALS['strActiveBanners'] 			= "Bannières actives";
$GLOBALS['strTotalBanners'] 			= "Total bannières";
$GLOBALS['strShowBanner']			= "Voir la bannière";
$GLOBALS['strShowAllBanners']	 		= "Voir toutes les bannières";
$GLOBALS['strShowBannersNoAdClicks']		= "Afficher les bannières sans clics";
$GLOBALS['strShowBannersNoAdViews']		= "Afficher les bannières non vues";
$GLOBALS['strDeleteAllBanners']	 		= "Supprimer toutes les bannières";
$GLOBALS['strActivateAllBanners']		= "Activer toutes les bannières";
$GLOBALS['strDeactivateAllBanners']		= "Désactiver toutes les bannières";
$GLOBALS['strBannerOverview']			= "Aperçu des bannières";
$GLOBALS['strBannerProperties']			= "Propriétés de la bannière";
$GLOBALS['strBannerHistory']			= "Historique de la bannière";
$GLOBALS['strBannerNoStats'] 			= "Il n'y a pas de statistiques pour cette bannière !";
$GLOBALS['strNoBanners']			= "Il n'y a actuellement aucune bannière enregistrée.";
$GLOBALS['strConfirmDeleteBanner']		= "Voulez vous vraiment effacer cette bannière ?";
$GLOBALS['strConfirmDeleteAllBanners']		= "Voulez vous vraiment effacer toutes les bannières de cette campagne ?";
$GLOBALS['strConfirmResetBannerStats']		= "Voulez vous vraiment effacer toutes les statistiques de cette bannière ?";
$GLOBALS['strShowParentCampaigns']		= "Montrer les campagnes parentes";
$GLOBALS['strHideParentCampaigns']		= "Cacher les campagnes parentes";
$GLOBALS['strHideInactiveBanners']		= "Cacher les bannières inactives";
$GLOBALS['strInactiveBannersHidden']		= "bannière(s) inactive(s) cachée(s)";



// Banner (Properties)
$GLOBALS['strChooseBanner'] 			= "Veuillez choisir le type de bannière.";
$GLOBALS['strMySQLBanner'] 			= "Bannière locale (SQL)";
$GLOBALS['strWebBanner'] 			= "Bannière locale (Serveur Web)";
$GLOBALS['strURLBanner'] 			= "Bannière externe";
$GLOBALS['strHTMLBanner'] 			= "Bannière HTML";
$GLOBALS['strTextBanner'] 			= "Publicité textuelle";
$GLOBALS['strAutoChangeHTML']			= "Changer le HTML pour pouvoir compter les clics";
$GLOBALS['strUploadOrKeep']			= "Voulez vous garder l'image <br> existante, ou bien souhaitez <br> vous en uploader une autre ?";
$GLOBALS['strNewBannerFile'] 			= "Veuillez sélectionner l'image que <br> vous souhaitez utiliser<br><br>";
$GLOBALS['strNewBannerURL'] 			= "URL de la bannière (avec http://)";
$GLOBALS['strURL'] 				= "URL de destination du click (avec http://)";
$GLOBALS['strHTML'] 				= "HTML";
$GLOBALS['strTextBelow'] 			= "Texte sous l'image";
$GLOBALS['strKeyword'] 				= "Mots clés";
$GLOBALS['strWeight'] 				= "Poids";
$GLOBALS['strAlt'] 				= "Texte de la bulle contextuelle (Alt)";
$GLOBALS['strStatusText']			= "Texte de la barre de statut";
$GLOBALS['strBannerWeight']			= "Poids de la bannière";


// Banner (swf)
$GLOBALS['strCheckSWF']				= "Contrôler les liens codés en dur dans le fichier Flash";
$GLOBALS['strConvertSWFLinks']			= "Convertir les liens Flash";
$GLOBALS['strHardcodedLinks']			= "Liens codés en dur";
$GLOBALS['strConvertSWF']			= "<br>Le fichier Flash que vous venez d'envoyer contient des liens codés en dur. ".$phpAds_productname." ne pourra ".
						  "pas compter les clicks pour ces bannières à moins que vous ne convertissiez ces liens codés en dur. ".
						  "Vous trouverez ci-dessous une liste de tous les liens présents dans le fichier flash. ".
						  "Si vous souhaitez convertir ces liens, cliquez simplement sur <b>Convertir</b>, autrement cliquez sur ".
						  "<b>Annuler</b>.<br><br>".
						  "Veuillez noter: si vous cliquez sur <b>Convertir</b>, le fichier Flash ".
						  "que vous venez d'envoyer sera modifié. <br>Veuillez garder une sauvegarde du fichier ".
						  "original. Quelque soit la version de Flash avec laquelle cette bannière a été crée, le fichier résultant ".
						  "nécessitera le lecteur Flash 4 (ou plus) pour s'afficher correctement.<br><br>";
$GLOBALS['strCompressSWF']			= "Compressez le fichier SWF pour un téléchargement plus rapide (Lecteur Flash 6 requis)";
$GLOBALS['strOverwriteSource']			= "Outrepasser le paramètre de source";


// Banner (network)
$GLOBALS['strBannerNetwork']			= "Bannière HTML avec modèle";
$GLOBALS['strChooseNetwork']			= "Choisissez le modèle que vous souhaitez utiliser";
$GLOBALS['strMoreInformation']			= "Plus d'informations...";
$GLOBALS['strRichMedia']			= "Média riche";
$GLOBALS['strTrackAdClicks']			= "Traquer les clicks";


// Display limitations
$GLOBALS['strModifyBannerAcl'] 			= "Options de limitation";
$GLOBALS['strACL'] 				= "Limites";
$GLOBALS['strACLAdd'] 				= "Ajouter une nouvelle limitation";
$GLOBALS['strNoLimitations']			= "Pas de limitations";
$GLOBALS['strApplyLimitationsTo']		= "Appliquer les limitations à";
$GLOBALS['strRemoveAllLimitations']		= "Retirer toutes les limitations";
$GLOBALS['strEqualTo']				= "est égal à";
$GLOBALS['strDifferentFrom']			= "est différent de";
$GLOBALS['strAND']				= "ET";  						// logical operator
$GLOBALS['strOR']				= "OU"; 						// logical operator
$GLOBALS['strOnlyDisplayWhen']			= "Afficher uniquement ce bandeau quand :";
$GLOBALS['strWeekDay'] 				= "Le jour de la semaine";
$GLOBALS['strTime'] 				= "L'heure";
$GLOBALS['strUserAgent'] 			= "L'agent utilisateur";
$GLOBALS['strDomain'] 				= "Le domaine";
$GLOBALS['strClientIP'] 			= "L'IP du visiteur";
$GLOBALS['strSource'] 				= "La source";
$GLOBALS['strBrowser'] 				= "Le navigateur";
$GLOBALS['strOS'] 				= "Le système d'exploitation";
$GLOBALS['strCountry'] 				= "Le pays";
$GLOBALS['strContinent'] 			= "Le continent";
$GLOBALS['strDeliveryLimitations']		= "Limites de distribution";
$GLOBALS['strDeliveryCapping']			= "Limites de répétition";
$GLOBALS['strTimeCapping']			= "Une fois que cette bannière a été affichée, ne plus la réafficher à cet utilisateur pendant:";
$GLOBALS['strImpressionCapping']		= "Ne pas montrer cette bannière à un même utilisateur plus de:";


// Publisher
$GLOBALS['strAffiliate']			= "Editeur";
$GLOBALS['strAffiliates']			= "Editeurs";
$GLOBALS['strAffiliatesAndZones']		= "Editeurs & Zones";
$GLOBALS['strAddNewAffiliate']			= "Ajouter un nouvel éditeur";
$GLOBALS['strAddAffiliate']			= "Créer un éditeur";
$GLOBALS['strAffiliateProperties']		= "Propriétés de l'éditeur";
$GLOBALS['strAffiliateOverview']		= "Aperçu de l'éditeur";
$GLOBALS['strAffiliateHistory']			= "Historique de l'éditeur";
$GLOBALS['strZonesWithoutAffiliate']		= "Zones sans éditeurs";
$GLOBALS['strMoveToNewAffiliate']		= "Déplacer vers un nouvel éditeur";
$GLOBALS['strNoAffiliates']			= "Il n'y a actuellement aucun éditeur enregistré.";
$GLOBALS['strConfirmDeleteAffiliate']		= "Voulez vous vraiment effacer cet éditeur ?";
$GLOBALS['strMakePublisherPublic']		= "Rendre publiques les zones possédées par cet éditeur";


// Publisher (properties)
$GLOBALS['strWebsite']				= "Site Web";
$GLOBALS['strAllowAffiliateModifyInfo'] 	= "Permettre à cet éditeur de modifier ses propres paramètres";
$GLOBALS['strAllowAffiliateModifyZones'] 	= "Permettre à cet éditeur de modifier ses propres zones";
$GLOBALS['strAllowAffiliateLinkBanners'] 	= "Permettre à cet éditeur de lier des bannières à ses propres zones";
$GLOBALS['strAllowAffiliateAddZone'] 		= "Permettre à cet éditeur de définir de nouvelles zones";
$GLOBALS['strAllowAffiliateDeleteZone'] 	= "Permettre à cet éditeur de supprimer des zones existantes";


// Zone
$GLOBALS['strZone']				= "Zone";
$GLOBALS['strZones']				= "Zones";
$GLOBALS['strAddNewZone']			= "Ajouter une nouvelle zone";
$GLOBALS['strAddZone']				= "Créer une zone";
$GLOBALS['strModifyZone']			= "Modifier une zone";
$GLOBALS['strLinkedZones']			= "Zones liées";
$GLOBALS['strZoneOverview']			= "Aperçu des zones";
$GLOBALS['strZoneProperties']			= "Propriétés de la zone";
$GLOBALS['strZoneHistory']			= "Historique de la zone";
$GLOBALS['strNoZones']				= "Il n'y a actuellement aucune zone enregistrée";
$GLOBALS['strConfirmDeleteZone']		= "Voulez vous vraiment effacer cette zone ?";
$GLOBALS['strZoneType']				= "Type de zone";
$GLOBALS['strBannerButtonRectangle']		= "Bannière, Bouton ou Rectangle";
$GLOBALS['strInterstitial']			= "Interstitiel, ou DHTML flottant";
$GLOBALS['strPopup']				= "Popup";
$GLOBALS['strTextAdZone']			= "Publicité textuelle";
$GLOBALS['strShowMatchingBanners']		= "Montrer les bannières correspondantes";
$GLOBALS['strHideMatchingBanners']		= "Cacher les bannières correspondantes";


// Advanced zone settings
$GLOBALS['strAdvanced']				= "Avancé";
$GLOBALS['strChains']				= "Chaînes";
$GLOBALS['strChainSettings']			= "Paramètres de la chaîne";
$GLOBALS['strZoneNoDelivery']			= "Si aucune bannière de cette zone ne peut être délivrée, essayer de...";
$GLOBALS['strZoneStopDelivery']			= "Arrêter la distribution, et ne montrer aucune bannière";
$GLOBALS['strZoneOtherZone']			= "Montrer la zone sélectionnée à la place";
$GLOBALS['strZoneUseKeywords']			= "Sélectionnez une bannière en utilisant les mots clés spécifiés ci-dessous";
$GLOBALS['strZoneAppend']			= "Toujours faire suivre le code d'invocation des bannières de cette zone par le popup ou l'interstitiel ci-contre";
$GLOBALS['strAppendSettings']			= "Paramètres de préfixation et de suffixation";
$GLOBALS['strZonePrependHTML']			= "Toujours afficher le code HTML suivant avant les publicités textuelles de cette zone";
$GLOBALS['strZoneAppendHTML']			= "Toujours afficher le code HTML suivant après les publicités textuelles de cette zone";

// Zone probability
$GLOBALS['strZoneProbListChain']		= "Toutes les bannières liées à la zone sélectionnée ont une priorité nulle. Le chaînage de zone sera utilisé:";
$GLOBALS['strZoneProbNullPri']			= "Toutes les bannières liées à cette zone ont une priorité nulle.";

// Linked banners/campaigns
$GLOBALS['strSelectZoneType']			= "Merci de choisir le type de bannières liées";
$GLOBALS['strBannerSelection']			= "Sélection des bannières";
$GLOBALS['strCampaignSelection']		= "Sélection des campagnes";
$GLOBALS['strInteractive']			= "Interactif";
$GLOBALS['strRawQueryString']			= "Sélection par mots clés";
$GLOBALS['strIncludedBanners']			= "Bannières liées";
$GLOBALS['strLinkedBannersOverview']		= "Aperçu des bannières liées";
$GLOBALS['strLinkedBannerHistory']		= "Historique des bannières liées";
$GLOBALS['strNoZonesToLink']			= "Il n'y a actuellement aucune zone disponible à laquelle cette bannière peut être liée";
$GLOBALS['strNoBannersToLink']			= "Il n'y a actuellement aucune bannière disponible qui peut être liée à cette zone";
$GLOBALS['strNoLinkedBanners']			= "Il n'y a aucune bannière disponible qui est liée à cette zone";
$GLOBALS['strMatchingBanners']			= "{count} bannières correspondantes";
$GLOBALS['strNoCampaignsToLink']		= "Il n'y a actuellement aucune campagne disponible qui peut être liée à cette zone";
$GLOBALS['strNoZonesToLinkToCampaign']  	= "Il n'y a actuellement aucune zone disponible à laquelle cette zone peut être liée";
$GLOBALS['strSelectBannerToLink']		= "Sélectionnez la bannière que vous souhaiteriez lier à cette zone:";
$GLOBALS['strSelectCampaignToLink']		= "Sélectionnez la campagne que vous souhaiteriez lier à cette zone:";


// Statistics
$GLOBALS['strStats'] 				= "Statistiques";
$GLOBALS['strNoStats']				= "Il n'y a actuellement aucune statistique disponible";
$GLOBALS['strConfirmResetStats']		= "Voulez vous vraiment réinitialiser toutes les statistiques ?";
$GLOBALS['strGlobalHistory']			= "Historique global";
$GLOBALS['strDailyHistory']			= "Historique quotidien";
$GLOBALS['strDailyStats'] 			= "Statistiques quotidiennes";
$GLOBALS['strWeeklyHistory']			= "Historique hebdomadaire";
$GLOBALS['strMonthlyHistory']			= "Historique mensuel";
$GLOBALS['strCreditStats'] 			= "Statistiques des crédits";
$GLOBALS['strDetailStats'] 			= "Statistiques détaillées";
$GLOBALS['strTotalThisPeriod']			= "Total pour cette période";
$GLOBALS['strAverageThisPeriod']		= "Moyenne pour cette période";
$GLOBALS['strDistribution']			= "Répartition";
$GLOBALS['strResetStats'] 			= "Réinitialiser les statistiques";
$GLOBALS['strSourceStats']			= "Statistiques des sources";
$GLOBALS['strSelectSource']			= "Sélectionnez la source que vous souhaitez voir:";
$GLOBALS['strSizeDistribution']			= "Répartition par taille";
$GLOBALS['strCountryDistribution']		= "Répartition par pays";
$GLOBALS['strEffectivity']			= "Effectivité";


// Hosts
$GLOBALS['strHosts']				= "Machines clientes";
$GLOBALS['strTopTenHosts'] 			= "Top 10 des machines clientes";
$GLOBALS['strTopHosts']				= "Classement des machines clientes";
$GLOBALS['strTopCountries']			= "Classement des pays";


// Expiration
$GLOBALS['strExpired']				= "Expiré";
$GLOBALS['strExpiration'] 			= "Expiration";
$GLOBALS['strNoExpiration'] 			= "Pas de date d'expiration";
$GLOBALS['strEstimated'] 			= "Date d'expiration estimée";


// Reports
$GLOBALS['strReports']				= "Rapports";
$GLOBALS['strSelectReport']			= "Sélectionnez le rapport que vous souhaitez générer";


// Userlog
$GLOBALS['strUserLog']				= "Journal utilisateur";
$GLOBALS['strUserLogDetails']			= "Détails du journal utilisateur";
$GLOBALS['strDeleteLog']			= "Supprimer le journal";
$GLOBALS['strAction']				= "Action";
$GLOBALS['strNoActionsLogged']			= "Aucune action n'a été écrite dans le journal";


// Code generation
$GLOBALS['strGenerateBannercode']		= "Générer le Code d'invocation";
$GLOBALS['strChooseInvocationType']		= "Veuillez choisir le type d'invocation des bannières";
$GLOBALS['strGenerate']				= "Générer";
$GLOBALS['strParameters']			= "Paramètres";
$GLOBALS['strFrameSize']			= "Taille de la Frame";
$GLOBALS['strBannercode']			= "Code d'invocation de la bannière";


// Errors
$GLOBALS['strMySQLError'] 			= "Erreur SQL:";
$GLOBALS['strLogErrorClients'] 			= "[phpAds] Une erreur a eu lieu en tentant de récupérer les annonceurs dans la base de données.";
$GLOBALS['strLogErrorBanners'] 			= "[phpAds] Une erreur a eu lieu en tentant de récupérer les bannières dans la base de données.";
$GLOBALS['strLogErrorViews'] 			= "[phpAds] Une erreur a eu lieu en tentant de récupérer les nombres d'affichages dans la base de données.";
$GLOBALS['strLogErrorClicks'] 			= "[phpAds] Une erreur a eu lieu en tentant de récupérer les clics dans la base de données.";
$GLOBALS['strErrorViews'] 			= "Vous devez indiquer le nombre d'affichages ou cocher la case 'illimité' !";
$GLOBALS['strErrorNegViews'] 			= "Nombre d'affichage négatif non autorisé";
$GLOBALS['strErrorClicks'] 			= "Vous devez indiquer le nombre de clics ou cocher la case 'illimité' !";
$GLOBALS['strErrorNegClicks'] 			= "Nombre de clics négatif non autorisé";
$GLOBALS['strNoMatchesFound']			= "Aucune correspondance n'a été trouvée";
$GLOBALS['strErrorOccurred']			= "Une erreur est survenue";
$GLOBALS['strErrorUploadSecurity']		= "Un problème potentiel de sécurité a été détecté. L'envoi a été arrêté!";
$GLOBALS['strErrorUploadBasedir']		= "Impossible d'accéder au fichier envoyé, probablement à cause de l'activation du mode de sécurité PHP (safemode), ou d'une restriction 'open_basedir'.";
$GLOBALS['strErrorUploadUnknown']		= "Impossible d'accéder au fichier envoyé, pour une raison inconnue. Veuillez vérifier votre configuration PHP.";
$GLOBALS['strErrorStoreLocal']			= "Une erreur est survenue lors d'une tentative de sauvegarde de la bannière dans le répertoire local. Cela provient probablement de la mauvaise configuration des paramètres du répertoire local";
$GLOBALS['strErrorStoreFTP']			= "Une erreur est survenue lors d'une tentative de sauvegarde de la bannière sur le serveur FTP. Cela peut provenir de la non disponibilité du serveur, ou de la mauvaise configuration des paramètres du serveur FTP.";


// E-mail
$GLOBALS['strMailSubject'] 			= "Bilan publicitaire";
$GLOBALS['strAdReportSent']			= "Rapport envoyé";
$GLOBALS['strMailSubjectDeleted'] 		= "Publicités désactivées";
$GLOBALS['strMailHeader'] 			= "Cher {contact},\n";
$GLOBALS['strMailBannerStats'] 			= "Vous trouverez ci-dessous les statistiques des bannières publicitaires pour {clientname}:";
$GLOBALS['strMailFooter'] 			= "Cordialement,\n   {adminfullname}";
$GLOBALS['strMailClientDeactivated'] 		= "Vos bannières suivantes ont été désactivés car";
$GLOBALS['strMailNothingLeft'] 			= "\nSi vous souhaitez prolonger votre présence publicitaire sur notre site, nous vous remercions de bien vouloir nous contacter. Nous serions heureux de continuer avec vous.";
$GLOBALS['strClientDeactivated']		= "Cette campagne est actuellement inactive car";
$GLOBALS['strBeforeActivate']			= "la date de début de la campagne n'est pas encore atteinte";
$GLOBALS['strAfterExpire']			= "la date de fin de la campagne a été atteinte";
$GLOBALS['strNoMoreClicks']			= "le nombre de clics maximal souhaité a été atteint";
$GLOBALS['strNoMoreViews']			= "le nombre d'affichages maximal souhaité a été atteint";
$GLOBALS['strWarnClientTxt']			= "Le nombre de Clic ou d'Affichages restants est en train de passer sous {limit} pour vos bannières.  \nDès que ce nombre atteindra zéro, vos bannières ne seront plus affichées. ";
$GLOBALS['strViewsClicksLow']			= "Affichages et Clics sont bas";
$GLOBALS['strNoViewLoggedInInterval']   	= "Aucune des bannières n'a été affichée pendant le temps que couvre le rapport";
$GLOBALS['strNoClickLoggedInInterval']  	= "Aucun clic n'a été enregistré pendant le durée du rapport";
$GLOBALS['strMailReportPeriod']			= "Ce rapport inclut les statistiques pour la période du {startdate} au {enddate}.";
$GLOBALS['strMailReportPeriodAll']		= "Ce rapport inclut les statistiques pour la période allant jusqu'au {enddate}.";
$GLOBALS['strNoStatsForCampaign'] 		= "Il n'y a pas de statistiques disponibles pour cette campagne";


// Priority
$GLOBALS['strPriority']				= "Priorité";


// Settings
$GLOBALS['strSettings'] 			= "Paramètres";
$GLOBALS['strGeneralSettings']			= "Paramètres généraux";
$GLOBALS['strMainSettings']			= "Paramètres principaux";
$GLOBALS['strAdminSettings']			= "Paramètres d'administration";


// Product Updates
$GLOBALS['strProductUpdates']			= "Mises à jour du produit";

?>