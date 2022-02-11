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

$GLOBALS['phpAds_DecimalPoint'] = ",";
$GLOBALS['phpAds_ThousandsSeperator'] = " ";

// Date & time configuration
$GLOBALS['date_format'] = "%d/%m/%Y";
$GLOBALS['month_format'] = "%m/%Y";
$GLOBALS['day_format'] = "%d/%m";
$GLOBALS['week_format'] = "%W/%Y";
$GLOBALS['weekiso_format'] = "%V/%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Accueil";
$GLOBALS['strHelp'] = "Aide";
$GLOBALS['strStartOver'] = "Recommencer";
$GLOBALS['strShortcuts'] = "Raccourcis";
$GLOBALS['strActions'] = "Actions";
$GLOBALS['strAndXMore'] = "et %s plus";
$GLOBALS['strAdminstration'] = "Inventaire";
$GLOBALS['strMaintenance'] = "Entretien";
$GLOBALS['strProbability'] = "Probabilité";
$GLOBALS['strInvocationcode'] = "Code d'invocation";
$GLOBALS['strBasicInformation'] = "Informations générales";
$GLOBALS['strAppendTrackerCode'] = "Ajouter un code de suivi";
$GLOBALS['strOverview'] = "Vue d'ensemble";
$GLOBALS['strSearch'] = "<u>R</u>echerche";
$GLOBALS['strDetails'] = "Détails";
$GLOBALS['strUpdateSettings'] = "Paramètres de mise à jour";
$GLOBALS['strCheckForUpdates'] = "Vérifier les mises à jour";
$GLOBALS['strWhenCheckingForUpdates'] = "Lors de la vérification des mises à jour";
$GLOBALS['strCompact'] = "Résumé";
$GLOBALS['strUser'] = "Utilisateur";
$GLOBALS['strDuplicate'] = "Doubler";
$GLOBALS['strCopyOf'] = "Copie de";
$GLOBALS['strMoveTo'] = "Déplacer vers";
$GLOBALS['strDelete'] = "Supprimer";
$GLOBALS['strActivate'] = "Activer";
$GLOBALS['strConvert'] = "Convertir";
$GLOBALS['strRefresh'] = "Actualiser";
$GLOBALS['strSaveChanges'] = "Enregistrer les modifications";
$GLOBALS['strUp'] = "Haut";
$GLOBALS['strDown'] = "Bas";
$GLOBALS['strSave'] = "Enregistrer";
$GLOBALS['strCancel'] = "Annuler";
$GLOBALS['strBack'] = "Retour";
$GLOBALS['strPrevious'] = "Précédent";
$GLOBALS['strNext'] = "Suivant";
$GLOBALS['strYes'] = "Oui";
$GLOBALS['strNo'] = "Non";
$GLOBALS['strNone'] = "Aucun";
$GLOBALS['strCustom'] = "Personnalisé";
$GLOBALS['strDefault'] = "Par défaut";
$GLOBALS['strUnknown'] = "Inconnu";
$GLOBALS['strUnlimited'] = "Illimité";
$GLOBALS['strUntitled'] = "Sans titre";
$GLOBALS['strAll'] = "tout";
$GLOBALS['strAverage'] = "Moyen";
$GLOBALS['strOverall'] = "Ensemble";
$GLOBALS['strTotal'] = "Totalité";
$GLOBALS['strFrom'] = "Du";
$GLOBALS['strTo'] = "de";
$GLOBALS['strAdd'] = "Ajouter";
$GLOBALS['strLinkedTo'] = "lié à";
$GLOBALS['strDaysLeft'] = "Jours restants";
$GLOBALS['strCheckAllNone'] = "Cocher / décocher tout";
$GLOBALS['strKiloByte'] = "Ko";
$GLOBALS['strExpandAll'] = "<u>D</u>évelopper tout";
$GLOBALS['strCollapseAll'] = "<u>R</u>eplier tout";
$GLOBALS['strShowAll'] = "Afficher tout";
$GLOBALS['strNoAdminInterface'] = "L'écran d'admin a été désactivé en raison d'une maintenance. Cela n'affecte pas la distribution de vos campagnes.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "La date 'du' doit être antérieure à la date 'au'";
$GLOBALS['strFieldContainsErrors'] = "Les champs suivants contiennent des erreurs :";
$GLOBALS['strFieldFixBeforeContinue1'] = "Avant de continuer vous avez besoin de";
$GLOBALS['strFieldFixBeforeContinue2'] = "pour corriger ces erreurs,";
$GLOBALS['strMiscellaneous'] = "Divers";
$GLOBALS['strCollectedAllStats'] = "Toutes les statistiques";
$GLOBALS['strCollectedToday'] = "Aujourd'hui";
$GLOBALS['strCollectedYesterday'] = "Hier";
$GLOBALS['strCollectedThisWeek'] = "Cette semaine";
$GLOBALS['strCollectedLastWeek'] = "La semaine dernière";
$GLOBALS['strCollectedThisMonth'] = "Ce mois-ci";
$GLOBALS['strCollectedLastMonth'] = "Le mois dernier";
$GLOBALS['strCollectedLast7Days'] = "Les 7 derniers jours";
$GLOBALS['strCollectedSpecificDates'] = "Dates spécifiques";
$GLOBALS['strValue'] = "Valeur";
$GLOBALS['strWarning'] = "Avertissement";
$GLOBALS['strNotice'] = "Note";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "Le tableau de bord ne peut pas être affiché";
$GLOBALS['strNoCheckForUpdates'] = "Le tableau de bord ne peut pas être affiché car vous avez<br/>désactivé les paramètres de recherche des mises à jour.";
$GLOBALS['strEnableCheckForUpdates'] = "Activer la <a href='account-settings-update.php'>recherche de mises à jour</a> via<br/><a href='account-settings-update.php'>la page de paramètres de </a> mises à jour.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "code";
$GLOBALS['strDashboardSystemMessage'] = "Message système";
$GLOBALS['strDashboardErrorHelp'] = "Si cette erreur se répète, veuillez décrire votre problème en détails en le poster sur le <a href='http://forum.openx.org/'>forum OpenX</a>.";

// Priority
$GLOBALS['strPriority'] = "Priorité";
$GLOBALS['strPriorityLevel'] = "Niveau de priorité";
$GLOBALS['strOverrideAds'] = "Outrepasser la publicité de la campagne";
$GLOBALS['strHighAds'] = "Publicités sous contrat";
$GLOBALS['strECPMAds'] = "Publicité de la campagne eCPM";
$GLOBALS['strLowAds'] = "Publicités restantes";
$GLOBALS['strLimitations'] = "Règles de livraison";
$GLOBALS['strNoLimitations'] = "Pas de règles de livraison";
$GLOBALS['strCapping'] = "Plafonner";

// Properties
$GLOBALS['strName'] = "Nom";
$GLOBALS['strSize'] = "Taille";
$GLOBALS['strWidth'] = "Largeur";
$GLOBALS['strHeight'] = "Hauteur";
$GLOBALS['strTarget'] = "Cible";
$GLOBALS['strLanguage'] = "Langue";
$GLOBALS['strDescription'] = "Décrit";
$GLOBALS['strVariables'] = "Variables";
$GLOBALS['strID'] = "Identifiant";
$GLOBALS['strComments'] = "Commentaires";

// User access
$GLOBALS['strWorkingAs'] = "Travaille en tant que";
$GLOBALS['strWorkingAs_Key'] = "<u>T</u>availler comme";
$GLOBALS['strWorkingAs'] = "Travaille en tant que";
$GLOBALS['strSwitchTo'] = "Passer à";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Utilisez le champ de recherche du menu défilant pour trouver plus de comptes";
$GLOBALS['strWorkingFor'] = "%s pour…";
$GLOBALS['strNoAccountWithXInNameFound'] = "Aucun compte trouvé avec \"%s\" dans son nom";
$GLOBALS['strRecentlyUsed'] = "Récemment utilisé";
$GLOBALS['strLinkUser'] = "Ajouter un utilisateur";
$GLOBALS['strLinkUser_Key'] = "Ajouter un <u>u</u>tilisateur";
$GLOBALS['strUsernameToLink'] = "Identifiant de l'utilisateur à ajouter";
$GLOBALS['strNewUserWillBeCreated'] = "Un nouvel utilisateur va être créé";
$GLOBALS['strToLinkProvideEmail'] = "Pour ajouter l'utilisateur, indiquez son e-mail";
$GLOBALS['strToLinkProvideUsername'] = "Pour ajouter l'utilisateur, indiquez son identifiant";
$GLOBALS['strUserAccountUpdated'] = "Compte utilisateur mis à jour";
$GLOBALS['strUserWasDeleted'] = "L'utilisateur a été supprimé";
$GLOBALS['strUserNotLinkedWithAccount'] = "Un tel utilisateur n'est lié au compte";
$GLOBALS['strLinkUserHelp'] = "Pour ajouter un <b>utilisateur existant</b>, tapez le %1\$s et cliquez %2\$s <br />Pour ajouter un <b>nouvel utilisateur</b>, tapez le %1\$s désiré et cliquez %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "identifiant";
$GLOBALS['strLinkUserHelpEmail'] = "adresse e-mail";
$GLOBALS['strLastLoggedIn'] = "Dernière connexion";
$GLOBALS['strDateLinked'] = "Date de liaison";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Accès utilisateur";
$GLOBALS['strAdminAccess'] = "Accès admin";
$GLOBALS['strUserProperties'] = "Propriétés de l'utilisateur";
$GLOBALS['strPermissions'] = "Permissions";
$GLOBALS['strAuthentification'] = "Authentification";
$GLOBALS['strWelcomeTo'] = "Bienvenue sur";
$GLOBALS['strEnterUsername'] = "Entrez vos identifiant et mot de passe pour vous connecter";
$GLOBALS['strEnterBoth'] = "Veuillez entrer vos identifiant et mot de passe";
$GLOBALS['strEnableCookies'] = "Vous devez activer les cookies avant de pouvoir utiliser {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Erreur de cookie de session, veuillez vous reconnecter";
$GLOBALS['strLogin'] = "Connexion";
$GLOBALS['strLogout'] = "Déconnexion";
$GLOBALS['strUsername'] = "Identifiant";
$GLOBALS['strPassword'] = "Mot de passe";
$GLOBALS['strPasswordRepeat'] = "Répèter le mot de passe";
$GLOBALS['strAccessDenied'] = "Accès refusé";
$GLOBALS['strUsernameOrPasswordWrong'] = "L'identifiant et/ou le mot de passe sont incorrects. Veuillez réessayer.";
$GLOBALS['strPasswordWrong'] = "Le mot de passe est incorrect";
$GLOBALS['strNotAdmin'] = "Votre compte n'a pas les permissions requises pour utiliser cette fonctionnalité, vous pouvez vous connecter à un autre compte pour l'utiliser. Cliquez <a href='logout.php'>ici</a> pour vous connecter en tant qu'un utilisateur différent.";
$GLOBALS['strDuplicateClientName'] = "L'identifiant que vous avez entré existe déjà, veuillez en choisir un autre.";
$GLOBALS['strInvalidPassword'] = "Le nouveau mot de passe est invalide, veuillez en utiliser un différent.";
$GLOBALS['strInvalidEmail'] = "Cet e-mail n'a pas été formatté correctement, veuillez entrer une adresse e-mail correcte.";
$GLOBALS['strNotSamePasswords'] = "Les deux mots de passe ne sont pas identiques";
$GLOBALS['strRepeatPassword'] = "Répéter le mot de passe";
$GLOBALS['strDeadLink'] = "Votre lien est invalide.";
$GLOBALS['strNoPlacement'] = "La campagne sélectionnée n'existe pas. Essayez plutôt ce <a href='{link}'>lien</a>";
$GLOBALS['strNoAdvertiser'] = "L'annonceur sélectionné n'existe pas. Essayez plutôt ce <a href='{link}'>lien</a>";

// General advertising
$GLOBALS['strRequests'] = "Requêtes";
$GLOBALS['strImpressions'] = "Impressions";
$GLOBALS['strClicks'] = "Clics";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Total de clics";
$GLOBALS['strTotalConversions'] = "Total de conversions";
$GLOBALS['strDateTime'] = "Date et heure";
$GLOBALS['strTrackerID'] = "ID du traceur";
$GLOBALS['strTrackerName'] = "Nom du traceur";
$GLOBALS['strTrackerImageTag'] = "Balise d'image";
$GLOBALS['strTrackerJsTag'] = "Balise javascript";
$GLOBALS['strTrackerAlwaysAppend'] = "Toujours afficher le code joint, même si aucune conversation n'est enregistrée?";
$GLOBALS['strBanners'] = "Bannières";
$GLOBALS['strCampaigns'] = "Campagnes";
$GLOBALS['strCampaignID'] = "ID de la campagne";
$GLOBALS['strCampaignName'] = "Nom de la campagne";
$GLOBALS['strCountry'] = "Pays";
$GLOBALS['strStatsAction'] = "Action";
$GLOBALS['strWindowDelay'] = "Temps d'affichage";
$GLOBALS['strStatsVariables'] = "Variables";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM";
$GLOBALS['strFinanceCPC'] = "CPC";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Location mensuelle";
$GLOBALS['strFinanceCTR'] = "CTR";

// Time and date related
$GLOBALS['strDate'] = "Date";
$GLOBALS['strDay'] = "Jour";
$GLOBALS['strDays'] = "Jours";
$GLOBALS['strWeek'] = "Semaine";
$GLOBALS['strWeeks'] = "Semaines";
$GLOBALS['strSingleMonth'] = "Mois";
$GLOBALS['strMonths'] = "Mois";
$GLOBALS['strDayOfWeek'] = "Jour de la semaine";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = [];
}
$GLOBALS['strDayFullNames'][0] = 'Dimanche';
$GLOBALS['strDayFullNames'][1] = 'Lundi';
$GLOBALS['strDayFullNames'][2] = 'Mardi';
$GLOBALS['strDayFullNames'][3] = 'Mercredi';
$GLOBALS['strDayFullNames'][4] = 'Jeudi';
$GLOBALS['strDayFullNames'][5] = 'Vendredi';
$GLOBALS['strDayFullNames'][6] = 'Samedi';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = [];
}
$GLOBALS['strDayShortCuts'][0] = 'Di';
$GLOBALS['strDayShortCuts'][1] = 'Lu';
$GLOBALS['strDayShortCuts'][2] = 'Ma';
$GLOBALS['strDayShortCuts'][3] = 'Me';
$GLOBALS['strDayShortCuts'][4] = 'Je';
$GLOBALS['strDayShortCuts'][5] = 'Ve';
$GLOBALS['strDayShortCuts'][6] = 'Sa';

$GLOBALS['strHour'] = "Heure";
$GLOBALS['strSeconds'] = "secondes";
$GLOBALS['strMinutes'] = "minutes";
$GLOBALS['strHours'] = "heures";

// Advertiser
$GLOBALS['strClient'] = "Annonceur";
$GLOBALS['strClients'] = "Annonceurs";
$GLOBALS['strClientsAndCampaigns'] = "Annonceurs & Campagnes";
$GLOBALS['strAddClient'] = "Ajouter un nouvel annonceur";
$GLOBALS['strClientProperties'] = "Propriétés de l'annonceur";
$GLOBALS['strClientHistory'] = "Statistiques de l'annonceur";
$GLOBALS['strNoClients'] = "Il n'y a actuellement aucun annonceur défini. Pour créer une campagne, commencez par <a href='advertiser-edit.php'>ajouter un nouvel annonceur</a>.";
$GLOBALS['strConfirmDeleteClient'] = "Voulez-vous vraiment supprimer cet annonceur ?";
$GLOBALS['strConfirmDeleteClients'] = "Voulez-vous vraiment supprimer les annonceurs sélectionnés ?";
$GLOBALS['strHideInactive'] = "Masquer inactif";
$GLOBALS['strInactiveAdvertisersHidden'] = "annonceur(s) inactif(s) masqué(s)";
$GLOBALS['strAdvertiserSignup'] = "Inscription annonceur";
$GLOBALS['strAdvertiserCampaigns'] = "Campagnes des annonceurs";

// Advertisers properties
$GLOBALS['strContact'] = "Contact";
$GLOBALS['strContactName'] = "Nom du contact";
$GLOBALS['strEMail'] = "E-mail";
$GLOBALS['strSendAdvertisingReport'] = "Envoyer des rapports de distribution de campagne par e-mail";
$GLOBALS['strNoDaysBetweenReports'] = "Nombre de jours entre les rapports de distribution de campagne";
$GLOBALS['strSendDeactivationWarning'] = "Envoyer un e-mail quand la campagne est automatiquement activée/désactivée";
$GLOBALS['strAllowClientModifyBanner'] = "Autoriser cet utilisateur à modifier ses propres bannières";
$GLOBALS['strAllowClientDisableBanner'] = "Autoriser cet utilisateur à désactiver ses propres bannières";
$GLOBALS['strAllowClientActivateBanner'] = "Autoriser cet utilisateur à activer ses propres bannières";
$GLOBALS['strAllowCreateAccounts'] = "Autoriser cet utilisateur à gérer les utilisateurs de ce compte";
$GLOBALS['strAdvertiserLimitation'] = "N'afficher qu'une bannière de cet annonceur sur la page web";
$GLOBALS['strAllowAuditTrailAccess'] = "Autoriser cet utiliser à accéder à la piste d'audit";

// Campaign
$GLOBALS['strCampaign'] = "Campagne";
$GLOBALS['strCampaigns'] = "Campagnes";
$GLOBALS['strAddCampaign'] = "Ajouter une nouvelle campagne";
$GLOBALS['strAddCampaign_Key'] = "Ajouter une <u>n</u>ouvelle campagne";
$GLOBALS['strCampaignForAdvertiser'] = "Pour l'annonceur";
$GLOBALS['strLinkedCampaigns'] = "Campagnes liées";
$GLOBALS['strCampaignProperties'] = "Propriétés de la campagne";
$GLOBALS['strCampaignOverview'] = "Vue d'ensemble des campagnes";
$GLOBALS['strCampaignHistory'] = "Statistiques des campagnes";
$GLOBALS['strNoCampaigns'] = "Il n'y a actuellement aucune campagne définie pour cet annonceur.";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "Il n'y a pas de campagnes à présent parce qu'il n'y a pas d'annonceurs. Pour créer une campagne, <a href='advertiser-edit.php'>ajouter un nouvel annonceur</a> premièrement.";
$GLOBALS['strConfirmDeleteCampaign'] = "Voulez-vous vraiment supprimer cette campagne ?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Voulez-vous vraiment supprimer les campagnes sélectionnés ?";
$GLOBALS['strShowParentAdvertisers'] = "Afficher les annonceurs parents";
$GLOBALS['strHideParentAdvertisers'] = "Masquer les annonceurs parents";
$GLOBALS['strHideInactiveCampaigns'] = "Masquer les campagnes inactives";
$GLOBALS['strInactiveCampaignsHidden'] = "campagne(s) inactive(s) masquée(s)";
$GLOBALS['strPriorityInformation'] = "Priorité par rapport aux autres campagnes";
$GLOBALS['strECPMInformation'] = "Mise en priorité d'eCPM";
$GLOBALS['strRemnantEcpmDescription'] = "L'eCPM se calcule de lui-même selon la performance de cette campagne.<br />Il servira à mettre les campagnes restantes en priorité les unes par rapport aux autres.";
$GLOBALS['strEcpmMinImpsDescription'] = "Réglez ceci à votre base minimale selon laquelle l'eCPM de cette campagne sera calculée.";
$GLOBALS['strHiddenCampaign'] = "Campagne";
$GLOBALS['strHiddenAd'] = "Publicité";
$GLOBALS['strHiddenAdvertiser'] = "Annonceur";
$GLOBALS['strHiddenTracker'] = "Suiveur";
$GLOBALS['strHiddenWebsite'] = "Site internet";
$GLOBALS['strHiddenZone'] = "Zone";
$GLOBALS['strCampaignDelivery'] = "Livraison de la campagne";
$GLOBALS['strCompanionPositioning'] = "Positionnement accompagné";
$GLOBALS['strSelectUnselectAll'] = "Sélectionner / désélectionner tout";
$GLOBALS['strCampaignsOfAdvertiser'] = "de"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "Afficher les annonces plafonnées si les cookies sont désactivés";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Calculé pour toutes les campagnes";
$GLOBALS['strCalculatedForThisCampaign'] = "Calculé pour cette campagne";
$GLOBALS['strLinkingZonesProblem'] = "Un problème est survenu lors de la liaison des zones";
$GLOBALS['strUnlinkingZonesProblem'] = "Un problème est survenu lors de la suppression de liaison des zones";
$GLOBALS['strZonesLinked'] = "zone(s) liée(s)";
$GLOBALS['strZonesUnlinked'] = "zone(s) déliée(s)";
$GLOBALS['strZonesSearch'] = "Recherche";
$GLOBALS['strZonesSearchTitle'] = "Recherche par le nom des zones et des sites";
$GLOBALS['strNoWebsitesAndZones'] = "Pas de sites ni de zones";
$GLOBALS['strNoWebsitesAndZonesText'] = "avec \"%s\" dans le nom";
$GLOBALS['strToLink'] = "à lier";
$GLOBALS['strToUnlink'] = "à délier";
$GLOBALS['strLinked'] = "lié";
$GLOBALS['strAvailable'] = "Disponible";
$GLOBALS['strShowing'] = "Montrant";
$GLOBALS['strEditZone'] = "Editer la zone";
$GLOBALS['strEditWebsite'] = "Editer le site internet";


// Campaign properties
$GLOBALS['strDontExpire'] = "N'expire pas";
$GLOBALS['strActivateNow'] = "Démarrer immédiatement";
$GLOBALS['strSetSpecificDate'] = "Préciser une date spécifique";
$GLOBALS['strLow'] = "Faible";
$GLOBALS['strHigh'] = "Élevé";
$GLOBALS['strExpirationDate'] = "Date de fin";
$GLOBALS['strExpirationDateComment'] = "La campagne finira à la fin de ce jour";
$GLOBALS['strActivationDate'] = "Date de début";
$GLOBALS['strActivationDateComment'] = "La campagne commencera au début de ce jour";
$GLOBALS['strImpressionsRemaining'] = "Impressions restantes";
$GLOBALS['strClicksRemaining'] = "Clics restants";
$GLOBALS['strConversionsRemaining'] = "Conversions restantes";
$GLOBALS['strImpressionsBooked'] = "Impressions réservées";
$GLOBALS['strClicksBooked'] = "Clics réservés";
$GLOBALS['strConversionsBooked'] = "Conversions réservées";
$GLOBALS['strCampaignWeight'] = "Régler le poids de la campagne";
$GLOBALS['strAnonymous'] = "Masquer l'annonceur et les sites web de cette campagne.";
$GLOBALS['strTargetPerDay'] = "par jour.";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "Le type de cette campagne a été déclaré Autre,
mais son poids est nul ou n'a pas été
spécifié. Cela provoquera la désactivation de la
campagne et ses bannières ne seront pas distribuées
jusqu'à ce que le poids ait une valeur correcte.

Êtes-vous certain de vouloir continuer ?";
$GLOBALS['strCampaignWarningEcpmNoRevenue'] = "Cette campagne utilise l'optimisation du Cpm
mais les 'revenus' ont une valeur de zéro ou restent indéfinis.
Ceci fera désactiver la campagne
et ses bannières ne seront pas livrées tant
que les revenus soient définis.

Souhaitez-vous toujours continuer?";
$GLOBALS['strCampaignWarningOverrideNoWeight'] = "Le type de cette campagne a été déclaré Autre,
mais son poids est nul ou n'a pas été
spécifié. Cela provoquera la désactivation de la
campagne et ses bannières ne seront pas distribuées
jusqu'à ce que le poids ait une valeur correcte.

Êtes-vous certain de vouloir continuer ?";
$GLOBALS['strCampaignWarningNoTarget'] = "La priorité de cette campagne a été déclarée Contractuelle,
mais la limite quotidienne n'a pas été spécifiée.
Cela provoquera la désactivation de la campagne et
ses bannières ne seront pas distribuées jusqu'à ce qu'une
limite quotidienne correcte ait une valeur correcte.

Êtes-vous certain de vouloir continuer ?";
$GLOBALS['strCampaignStatusPending'] = "Suspendue";
$GLOBALS['strCampaignStatusInactive'] = "Inactif";
$GLOBALS['strCampaignStatusRunning'] = "En cours";
$GLOBALS['strCampaignStatusPaused'] = "En pause";
$GLOBALS['strCampaignStatusAwaiting'] = "En attente";
$GLOBALS['strCampaignStatusExpired'] = "Terminée";
$GLOBALS['strCampaignStatusApproval'] = "En attente d'approbation »";
$GLOBALS['strCampaignStatusRejected'] = "Rejetée";
$GLOBALS['strCampaignStatusAdded'] = "Ajoutée";
$GLOBALS['strCampaignStatusStarted'] = "Démarrée";
$GLOBALS['strCampaignStatusRestarted'] = "Redémarrée";
$GLOBALS['strCampaignStatusDeleted'] = "Supprimée";
$GLOBALS['strCampaignType'] = "Type de campagne";
$GLOBALS['strType'] = "Type";
$GLOBALS['strContract'] = "Contrat";
$GLOBALS['strOverride'] = "Remplacer";
$GLOBALS['strOverrideInfo'] = "Les campagnes de remplacement sont un type de campagne spécial destiné à remplacer (par exemple, la priorité par rapport aux) campagnes restantes et à contrat. 
Les campagnes de remplacement sont généralement utilisées avec des règles de ciblage et / ou de plafonnement spécifiques pour garantir que les bannières de campagne sont toujours affichées à certains emplacements, pour certains utilisateurs, et peut-être un certain nombre de fois, dans le cadre d'une promotion spécifique. (Ce type de campagne était auparavant appelé \"Contrat (exclusif)\".)";
$GLOBALS['strStandardContract'] = "Contrat";
$GLOBALS['strStandardContractInfo'] = "Cette campagne est limitée à la journée et continuera d'être délivrée de façon égale jusqu'à ce que la date de fin ou que la limite spécifiée sois atteinte";
$GLOBALS['strRemnant'] = "Restant";
$GLOBALS['strRemnantInfo'] = "C'est une campagne standard qui sera définie à la fois par une date de fin et par une limite spécifique";
$GLOBALS['strECPMInfo'] = "Il s'agit d'une campagne standard qui peut être contrainte avec une date de fin ou une limite spécifique. En fonction des paramètres actuels, elle sera prioritisée en utilisant eCPM.";
$GLOBALS['strPricing'] = "Définition du prix";
$GLOBALS['strPricingModel'] = "Modèle de définition de prix";
$GLOBALS['strSelectPricingModel'] = "\\-- sélectionner le modèle --";
$GLOBALS['strRatePrice'] = "Taxe / Prix";
$GLOBALS['strMinimumImpressions'] = "Impressions quotidiennes minimales";
$GLOBALS['strLimit'] = "Limite";
$GLOBALS['strLowExclusiveDisabled'] = "Vous ne pouvez pas changer cette campagne en Restante ou Exclusive, tant que et la date de fin et la limite d'impressions/clicks/conversions n'est pas définie. <br>Pour changer le type, vous ne devez paramétrer ni date de fin, ni limites à atteindre.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "Vous ne pouvez pas à la fois paramétrer et une date de fin et une limite d'impressions pour une campagne Restante ou Exclusive.<br>Si vous avez besoin de paramétrer à la fois une date de fin et une limite d'impressions/clicks/conversions, veuillez utiliser une campagne à contrat non-exclusif.";
$GLOBALS['strWhyDisabled'] = "Pourquoi est-ce désactivé?";
$GLOBALS['strBackToCampaigns'] = "Retour aux campagnes";
$GLOBALS['strCampaignBanners'] = "Bannières des campagnes";
$GLOBALS['strCookies'] = "Cookies";

// Tracker
$GLOBALS['strTracker'] = "Suiveur";
$GLOBALS['strTrackers'] = "Suiveurs";
$GLOBALS['strTrackerPreferences'] = "Préférences du suivi";
$GLOBALS['strAddTracker'] = "Ajouter un nouveau traceur";
$GLOBALS['strTrackerForAdvertiser'] = "Pour l'annonceur";
$GLOBALS['strNoTrackers'] = "Il n'y a actuellement aucun traceur défini pour cet annonceur";
$GLOBALS['strConfirmDeleteTrackers'] = "Voulez-vous vraiment supprimer les traceurs sélectionnés ?";
$GLOBALS['strConfirmDeleteTracker'] = "Voulez-vous vraiment supprimer ce traceur ?";
$GLOBALS['strTrackerProperties'] = "Propriétés du traceur";
$GLOBALS['strDefaultStatus'] = "État par défaut";
$GLOBALS['strStatus'] = "État";
$GLOBALS['strLinkedTrackers'] = "Traceurs liés";
$GLOBALS['strTrackerInformation'] = "Information de traceur";
$GLOBALS['strConversionWindow'] = "Fenêtre de conversion";
$GLOBALS['strUniqueWindow'] = "Fenêtre unique";
$GLOBALS['strClick'] = "Clic";
$GLOBALS['strView'] = "Affichage";
$GLOBALS['strArrival'] = "Arrivée";
$GLOBALS['strManual'] = "Manuel";
$GLOBALS['strImpression'] = "Impressions";
$GLOBALS['strConversionType'] = "Type de conversion";
$GLOBALS['strLinkCampaignsByDefault'] = "Lier les nouvelles campagnes créées par défaut";
$GLOBALS['strBackToTrackers'] = "Retour aux traceurs";
$GLOBALS['strIPAddress'] = "Adresse IP";

// Banners (General)
$GLOBALS['strBanner'] = "Bannière";
$GLOBALS['strBanners'] = "Bannières";
$GLOBALS['strAddBanner'] = "Ajouter une nouvelle bannière";
$GLOBALS['strAddBanner_Key'] = "Ajouter une <u>n</u>ouvelle bannière";
$GLOBALS['strBannerToCampaign'] = "vers la campagne";
$GLOBALS['strShowBanner'] = "Afficher la bannière";
$GLOBALS['strBannerProperties'] = "Propriétés de la bannière";
$GLOBALS['strBannerHistory'] = "Statistiques des bannières";
$GLOBALS['strNoBanners'] = "Il n'y a actuellement aucune bannière définie pour cette campagne.";
$GLOBALS['strNoBannersAddCampaign'] = "Il n'y a pas actuellement de bannières définies, parce qu'il n'existe pas de campagne. Pour créer une bannière, <a href='campaign-edit.php?clientid=%s'>ajouter une nouvelle campagne</a> d'abord.";
$GLOBALS['strNoBannersAddAdvertiser'] = "Il n'y a actuellement aucunes bannières définies, parce qu'il n'y a pas d'annonceurs. Pour créer une bannière, commencez par <a href='affiliate-edit.php'>ajouter un nouvel annonceur</a>.";
$GLOBALS['strConfirmDeleteBanner'] = "Voulez-vous vraiment supprimer cette bannière ?";
$GLOBALS['strConfirmDeleteBanners'] = "Voulez-vous vraiment supprimer la bannière sélectionnée?";
$GLOBALS['strShowParentCampaigns'] = "Afficher les campagnes parentes";
$GLOBALS['strHideParentCampaigns'] = "Masquer les campagnes parentes";
$GLOBALS['strHideInactiveBanners'] = "Masquer les bannières inactives";
$GLOBALS['strInactiveBannersHidden'] = "bannière(s) inactive(s) masquée(s)";
$GLOBALS['strWarningMissing'] = "Attention, il manque peut-être";
$GLOBALS['strWarningMissingClosing'] = " balise de clôture '>'";
$GLOBALS['strWarningMissingOpening'] = " balise d'ouverture '<'";
$GLOBALS['strSubmitAnyway'] = "Soumettre tout de même";
$GLOBALS['strBannersOfCampaign'] = "dans"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Préférences des bannières";
$GLOBALS['strCampaignPreferences'] = "Préférences de campagne";
$GLOBALS['strDefaultBanners'] = "Bannières par défaut";
$GLOBALS['strDefaultBannerUrl'] = "URL de l'Image par défaut";
$GLOBALS['strDefaultBannerDestination'] = "URL de destination par défaut";
$GLOBALS['strAllowedBannerTypes'] = "Types de bannières autorisés";
$GLOBALS['strTypeSqlAllow'] = "Autoriser les bannières locales SQL";
$GLOBALS['strTypeWebAllow'] = "Autoriser les bannières locales du serveur web";
$GLOBALS['strTypeUrlAllow'] = "Autoriser les bannières externes";
$GLOBALS['strTypeHtmlAllow'] = "Autoriser les bannières HTML";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Veuillez chosir le type de bannière";
$GLOBALS['strMySQLBanner'] = "Envoyer une bannière locale vers la base de données";
$GLOBALS['strWebBanner'] = "Envoyer une bannière locale vers le serveur web";
$GLOBALS['strURLBanner'] = "Lier une bannière externe";
$GLOBALS['strHTMLBanner'] = "Créer une bannière HTML";
$GLOBALS['strTextBanner'] = "Créer une bannière textuelle";
$GLOBALS['strUploadOrKeep'] = "Voulez-vous garder votre <br />image existante, ou <br />en télécharger une autre ?";
$GLOBALS['strNewBannerFile'] = "Sélectionnez l'image que vous souhaitez <br />utiliser pour cette bannière<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "Sélectionnez une image de secours <br />à utiliser si les navigateurs<br />ne supportent pas le rich media<br /><br />";
$GLOBALS['strNewBannerURL'] = "URL de l'image (incluant http://)";
$GLOBALS['strURL'] = "URL de destination (incluant http://)";
$GLOBALS['strKeyword'] = "Mots-clés";
$GLOBALS['strTextBelow'] = "Texte en dessous de l'image";
$GLOBALS['strWeight'] = "Poids";
$GLOBALS['strAlt'] = "Texte de l'attribut Alt";
$GLOBALS['strStatusText'] = "Texte affiché dans la barre d'état";
$GLOBALS['strBannerWeight'] = "Poids de la bannière";
$GLOBALS['strAdserverTypeGeneric'] = "Bannière HTML générique";
$GLOBALS['strDoNotAlterHtml'] = "Ne pas modifier le code HTML";
$GLOBALS['strGenericOutputAdServer'] = "Générique";
$GLOBALS['strBackToBanners'] = "Retour aux bannières";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Toujours faire précéder le code HTML suivant à cette bannière";
$GLOBALS['strBannerAppendHTML'] = "Toujours ajouter le code HTML suivant à cette bannière";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Options de distribution";
$GLOBALS['strACL'] = "Options de distribution";
$GLOBALS['strAllBannersInCampaign'] = "Toutes les bannières dans cette campagne";
$GLOBALS['strEqualTo'] = "est égal à";
$GLOBALS['strDifferentFrom'] = "est différent de";
$GLOBALS['strLaterThan'] = "est plus tard que";
$GLOBALS['strLaterThanOrEqual'] = "est plus tard que ou égal à";
$GLOBALS['strEarlierThan'] = "est plus tôt que";
$GLOBALS['strEarlierThanOrEqual'] = "est plus tôt que ou égal à";
$GLOBALS['strContains'] = "contient";
$GLOBALS['strNotContains'] = "ne contient pas";
$GLOBALS['strGreaterThan'] = "est plus grand que";
$GLOBALS['strLessThan'] = "est plus petit que";
$GLOBALS['strAND'] = "ET";                          // logical operator
$GLOBALS['strOR'] = "OU";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Afficher seulement cette bannière quand :";
$GLOBALS['strWeekDays'] = "Jours de la semaine";
$GLOBALS['strTime'] = "Temps";
$GLOBALS['strDomain'] = "Le domaine";
$GLOBALS['strBrowser'] = "Le navigateur";
$GLOBALS['strOS'] = "Le système d'exploitation";

$GLOBALS['strDeliveryCappingReset'] = "Réinitialiser les compteurs d'affichages après :";
$GLOBALS['strDeliveryCappingTotal'] = "au total";
$GLOBALS['strDeliveryCappingSession'] = "par session";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = [];
}
$GLOBALS['strCappingBanner']['limit'] = "Limiter les affichages de la bannière à :";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = [];
}
$GLOBALS['strCappingCampaign']['limit'] = "Limiter les affichages de la campagne à :";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = [];
}
$GLOBALS['strCappingZone']['limit'] = "Limiter les affichages de la zone à :";

// Website
$GLOBALS['strAffiliate'] = "Site internet";
$GLOBALS['strAffiliates'] = "Sites web";
$GLOBALS['strAffiliatesAndZones'] = "Sites web & Zones";
$GLOBALS['strAddNewAffiliate'] = "Ajouter un nouveau site web";
$GLOBALS['strAffiliateProperties'] = "Propriétés du site web";
$GLOBALS['strNoAffiliates'] = "Il n'y a actuellement aucun site web défini. Pour créer une zone, commencez par <a href='affiliate-edit.php'>ajouter un nouveau site web</a>.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Voulez-vous vraiment supprimer ce site web ?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Voulez-vous vraiment supprimer le site web sélectionné?";
$GLOBALS['strInactiveAffiliatesHidden'] = "site(s) web inactif(s) masqué(s)";
$GLOBALS['strShowParentAffiliates'] = "Afficher les sites web parents";
$GLOBALS['strHideParentAffiliates'] = "Masquer les sites web parents";

// Website (properties)
$GLOBALS['strWebsite'] = "Site internet";
$GLOBALS['strWebsiteURL'] = "URL du site web";
$GLOBALS['strAllowAffiliateModifyZones'] = "Autoriser cet utilisateur à modifier ses propres zones";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Autoriser cet utilisateur à lier des bannières à ses propres zones";
$GLOBALS['strAllowAffiliateAddZone'] = "Autoriser cet utilisateur à définir de nouvelles zones";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Autoriser cet utilisateur à supprimer les zones existantes";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Autoriser cet utilisateur à générer le code d'invocation";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Code postal";
$GLOBALS['strCountry'] = "Pays";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Zones des sites";

// Zone
$GLOBALS['strZone'] = "Zone";
$GLOBALS['strAddNewZone'] = "Ajouter une nouvelle zone";
$GLOBALS['strAddNewZone_Key'] = "Ajouter une <u>n</u>ouvelle zone";
$GLOBALS['strZoneToWebsite'] = "vers le site internet";
$GLOBALS['strLinkedZones'] = "Zones liées";
$GLOBALS['strAvailableZones'] = "Zones disponibles";
$GLOBALS['strLinkingNotSuccess'] = "Liaison non réalisée, veuillez ré-essayer";
$GLOBALS['strZoneProperties'] = "Propriétés de la zone";
$GLOBALS['strZoneHistory'] = "Historique de la zone";
$GLOBALS['strNoZones'] = "Il n'y actuellement aucune zone définie pour ce site web.";
$GLOBALS['strNoZonesAddWebsite'] = "Il n'y a actuellement pas de zones définies, car il n'y a pas de site internet. Pour créer une zone, commencez par <a href='affiliate-edit.php'>ajouter un nouveau site internet</a>.";
$GLOBALS['strConfirmDeleteZone'] = "Voulez-vous vraiment supprimer cette zone ?";
$GLOBALS['strConfirmDeleteZones'] = "Voulez-vous vraiment supprimer les zones sélectionnées ?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "Il y a des campagnes encore liées à cette zone, si vous la supprimez elles ne pourront plus tourner et vous ne serez pas payé pour celles-ci.";
$GLOBALS['strZoneType'] = "Type de zone";
$GLOBALS['strBannerButtonRectangle'] = "Bannière, bouton ou rectangle";
$GLOBALS['strInterstitial'] = "Interstitiel ou flottant DHTML";
$GLOBALS['strPopup'] = "Fenêtre sautante";
$GLOBALS['strTextAdZone'] = "Publicité textuelle";
$GLOBALS['strEmailAdZone'] = "Zone e-mail/newsletter";
$GLOBALS['strZoneVideoInstream'] = "Bande pub enchâssée";
$GLOBALS['strZoneVideoOverlay'] = "Bande pub flottante";
$GLOBALS['strShowMatchingBanners'] = "Afficher les bannières correspondantes";
$GLOBALS['strHideMatchingBanners'] = "Masquer les bannières correspondantes";
$GLOBALS['strBannerLinkedAds'] = "Bannières liées à la zone";
$GLOBALS['strCampaignLinkedAds'] = "Campagnes liées à la zone";
$GLOBALS['strInactiveZonesHidden'] = "zone(s) inactive(s) masquée(s)";
$GLOBALS['strWarnChangeZoneType'] = "Changer le type de la zone en texte ou en e-mail détachera toutes les bannières/campagnes à cause des restrictions de ces types de zones
                                                <ul>
                                                    <li>Les zones textuelles peuvent seulement être liées à des publicités textuelles</li>
                                                    <li>Les campagnes des zones e-mail ne peuvent avoir qu'une seule bannière active à la fois</li>
                                                </ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Changer la taille de la zone va détacher toutes les bannières qui n\'auront pas la nouvelle taille, et ajouter les bannières des campagnes liées qui ont cette nouvelle taille';
$GLOBALS['strWarnChangeBannerSize'] = 'Changer la taille de la bannière détachera cette bannière des zones qui n\'ont pas la nouvelle taille, et si la <strong>campagne</strong> de cette bannière est liée à une zone  ayant la nouvelle taille, cette bannière sera automatiquement liée';
$GLOBALS['strWarnBannerReadonly'] = 'Cette bannière est en lecture uniquement car une extension a été désactivée. Contactez votre Administrateur pour plus d\'information.';
$GLOBALS['strZonesOfWebsite'] = 'dans'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "Retour aux zones";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "Bannière IAB (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "Skyscraper IAB (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "Méga bannière IAB (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "Bouton 1 IAB (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "Bouton 2 IAB (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "Demi bannière IAB (234 x 60)";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "Micro barre IAB (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "Bouton carré IAB (125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "Rectangle IAB (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "Pop-up carré IAB (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "Bannière verticale IAB (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "Pavé IAB (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "Méga pavé IAB (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "Pavé vertical IAB (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "Méga skyscraper IAB (160 x 600)";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "Avancé";
$GLOBALS['strChainSettings'] = "Paramètres d'enchaînement";
$GLOBALS['strZoneNoDelivery'] = "Si aucune bannière de cette zone <br />ne peut être distribuée, essayer de...";
$GLOBALS['strZoneStopDelivery'] = "Arrêter la distribution et ne plus afficher de bannière";
$GLOBALS['strZoneOtherZone'] = "Afficher la zone sélectionnée à la place";
$GLOBALS['strZoneAppend'] = "Toujour ajouter le code HTML suivant aux bannières affichées dans cette zone";
$GLOBALS['strAppendSettings'] = "Paramètres des ajouts (avant et après)";
$GLOBALS['strZonePrependHTML'] = "Toujours ajouter le code HTML avant les publicités textuelles affichées dans cette zone";
$GLOBALS['strZoneAppendNoBanner'] = "Ajouter même si aucune bannière n'est distribuée";
$GLOBALS['strZoneAppendHTMLCode'] = "Code HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "Popup ou insterstitiel";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Toutes les bannières liées à la zone sélectionnée sont actuellement inactives. <br />Voici la zone enchaînée qui doit suivre :";
$GLOBALS['strZoneProbNullPri'] = "Il n'y a aucune bannière active liée à cette zone.";
$GLOBALS['strZoneProbListChainLoop'] = "Suivre la zone enchaînée provoquerait une boucle sans fin. La distribution de cette zone est stoppée.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Veuillez choisir ce que vous voulez lier à cette zone";
$GLOBALS['strLinkedBanners'] = "Lier des bannières indivuelles";
$GLOBALS['strCampaignDefaults'] = "Lier des bannières selon la campagne parente";
$GLOBALS['strLinkedCategories'] = "Lier des bannières selon la catégorie";
$GLOBALS['strWithXBanners'] = "%d bannière(s)";
$GLOBALS['strRawQueryString'] = "Mot-clé";
$GLOBALS['strIncludedBanners'] = "Bannières liées";
$GLOBALS['strMatchingBanners'] = "{count} bannière(s) correspondante(s)";
$GLOBALS['strNoCampaignsToLink'] = "Il n'y a actuellement aucune campagne disponible à laquelle lier cette zone";
$GLOBALS['strNoTrackersToLink'] = "Il n'y a actuellement aucun suiveur disponible auquel lier cette campagne";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Il n'y a aucune zone disponible à laquelle lier cette campagne";
$GLOBALS['strSelectBannerToLink'] = "Sélectionnez la bannière que vous souhaitez lier à cette zone :";
$GLOBALS['strSelectCampaignToLink'] = "Sélectionnez la campagne que vous souhaitez lier à cette zone :";
$GLOBALS['strSelectAdvertiser'] = "Sélectionner l'annonceur";
$GLOBALS['strSelectPlacement'] = "Sélectionner la campagne";
$GLOBALS['strSelectAd'] = "Sélectionne la bannière";
$GLOBALS['strSelectPublisher'] = "Sélectionnez un site web";
$GLOBALS['strSelectZone'] = "Sélectionnez un zone";
$GLOBALS['strStatusPending'] = "Suspendue";
$GLOBALS['strStatusApproved'] = "Approuvé";
$GLOBALS['strStatusDisapproved'] = "Désappprouvé";
$GLOBALS['strStatusDuplicate'] = "Doubler";
$GLOBALS['strStatusOnHold'] = "En attente";
$GLOBALS['strStatusIgnore'] = "Ignoré";
$GLOBALS['strConnectionType'] = "Type";
$GLOBALS['strConnTypeSale'] = "Vente";
$GLOBALS['strConnTypeLead'] = "Prospect";
$GLOBALS['strConnTypeSignUp'] = "Inscription";
$GLOBALS['strShortcutEditStatuses'] = "Éditer les états";
$GLOBALS['strShortcutShowStatuses'] = "Afficher les états";

// Statistics
$GLOBALS['strStats'] = "Statistiques";
$GLOBALS['strNoStats'] = "Il n'y a actuellement aucunes statistiques disponibles";
$GLOBALS['strNoStatsForPeriod'] = "Il n'y actuellement aucunes statistiques disponibles pour la période du %s au %S";
$GLOBALS['strTotalThisPeriod'] = "Total de cette période";
$GLOBALS['strPublisherDistribution'] = "Distribution par site web";
$GLOBALS['strCampaignDistribution'] = "Distribution par campagne";
$GLOBALS['strViewBreakdown'] = "Afficher par";
$GLOBALS['strBreakdownByDay'] = "Jour";
$GLOBALS['strBreakdownByWeek'] = "Semaine";
$GLOBALS['strBreakdownByMonth'] = "Mois";
$GLOBALS['strBreakdownByDow'] = "Jour de la semaine";
$GLOBALS['strBreakdownByHour'] = "Heure";
$GLOBALS['strItemsPerPage'] = "Objets par page";
$GLOBALS['strDistributionHistoryBanner'] = "Statistiques de distribution (Bannière)";
$GLOBALS['strDistributionHistoryWebsite'] = "Statistiques de distribution (Site web)";
$GLOBALS['strDistributionHistoryZone'] = "Statistiques de distribution (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "Afficher le <u>g</u>raphique des statistiques";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>xporter les statistiques vers Excel";
$GLOBALS['strGDnotEnabled'] = "Vous devez avoir GD activé dans PHP pour afficher les graphiques. <br />Veuillez visiter <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> pour plus d'informations, y compris comment installer GD sur votre serveur.";
$GLOBALS['strStatsArea'] = "Domaine";

// Expiration
$GLOBALS['strNoExpiration'] = "Aucune date d'expiration définie";
$GLOBALS['strEstimated'] = "Date d'expiration estimée";
$GLOBALS['strNoExpirationEstimation'] = "Aucune expiration estimée pour le moment";
$GLOBALS['strDaysAgo'] = "jours avant";
$GLOBALS['strCampaignStop'] = "Arrêt de la campagne";

// Reports
$GLOBALS['strAdvancedReports'] = "Rapports détaillés";
$GLOBALS['strStartDate'] = "Date de début";
$GLOBALS['strEndDate'] = "Date de fin";
$GLOBALS['strPeriod'] = "Période";
$GLOBALS['strLimitations'] = "Règles de livraison";
$GLOBALS['strWorksheets'] = "Feuilles de travail";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Tous les annonceurs";
$GLOBALS['strAnonAdvertisers'] = "Annonceurs anonymes";
$GLOBALS['strAllPublishers'] = "Tous les sites web";
$GLOBALS['strAnonPublishers'] = "Sites web anonymes";
$GLOBALS['strAllAvailZones'] = "Toutes les zones disponibles";

// Userlog
$GLOBALS['strUserLog'] = "Journal de l'utilisateur";
$GLOBALS['strUserLogDetails'] = "Détails du journal utilisateur";
$GLOBALS['strDeleteLog'] = "Supprimer le journal";
$GLOBALS['strAction'] = "Action";
$GLOBALS['strNoActionsLogged'] = "Aucune action enregistrée";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Sélection directe";
$GLOBALS['strChooseInvocationType'] = "Veuillez choisir le type d'invocation de bannières";
$GLOBALS['strGenerate'] = "Générer";
$GLOBALS['strParameters'] = "Réglages des balises";
$GLOBALS['strFrameSize'] = "Taille du cadre";
$GLOBALS['strBannercode'] = "Code de la bannière";
$GLOBALS['strTrackercode'] = "Ajouter le code suivant à chaque impression du traceur Javascript";
$GLOBALS['strBackToTheList'] = "Retourner à la liste des rapports";
$GLOBALS['strCharset'] = "Jeu de caractères";
$GLOBALS['strAutoDetect'] = "Détection automatique";
$GLOBALS['strCacheBusterComment'] = "* Remplacez toutes les cas de {random} avec * un nombre généré aléatoirement (ou avec un horodatage). *";

// Errors
$GLOBALS['strNoMatchesFound'] = "Aucun résultat correspondant trouvé";
$GLOBALS['strErrorOccurred'] = "Une erreur est survenue";
$GLOBALS['strErrorDBPlain'] = "Une erreur est survenue lors de l'accès à la base de données";
$GLOBALS['strErrorDBSerious'] = "Un problème sérieux avec la base de données a été détecté";
$GLOBALS['strErrorDBNoDataPlain'] = "En raison d'un problème avec la base de données, {$PRODUCT_NAME} n'a pas pu récupérer ou stocker de données.";
$GLOBALS['strErrorDBNoDataSerious'] = "En raison d'un sérieux problème avec la base de données, {$PRODUCT_NAME} n'a pas pu récupérer de données";
$GLOBALS['strErrorDBCorrupt'] = "La table de la base de données est sans doute corrompue et a besoin d'être réparée. Pour plus d'informations concernant la réparation de tables corrompues veuillez lire le chapitre ";
$GLOBALS['strErrorDBContact'] = "Veuillez contacter l'administrateur de ce serveur et l'informer du problème.";
$GLOBALS['strErrorDBSubmitBug'] = "Si ce problème peut être reproduit, il doit être causé par un bug dans {$PRODUCT_NAME}. Veuillez rapporter les informations suivantes aux créateurs d\\'{$PRODUCT_NAME}. Essayez aussi de décrire les actions qui ont mené à cette erreur aussi clairement que possible.";
$GLOBALS['strMaintenanceNotActive'] = "Le script de maintenance n'a pas été exécuté au cours des dernières 24 heures.
Pour que {$PRODUCT_NAME} fonctionne correctement, il doit être exécuté
toutes les heures.

Veuillez lire le guide de l'administrateur pour plus d'informations
concernant la configuration du script de maintenance.";
$GLOBALS['strErrorLinkingBanner'] = "Il n'a pas été possible de lier cette bannière à cette zone parce que :";
$GLOBALS['strUnableToLinkBanner'] = "Cette bannière ne peut être liée :";
$GLOBALS['strErrorEditingCampaignRevenue'] = "format de nombre incorrect dans le champ Informations sur les recettes";
$GLOBALS['strErrorEditingCampaignECPM'] = "format de nombre erroné au champ de renseignement ECPM";
$GLOBALS['strErrorEditingZone'] = "Erreur de mise à jour de la zone :";
$GLOBALS['strUnableToChangeZone'] = "Impossible d'appliquer cette modification parce que :";
$GLOBALS['strDatesConflict'] = "conflit de dates avec :";
$GLOBALS['strEmailNoDates'] = "Les campagnes en zones e-mail doivent avoir une date de début et une date de fin";
$GLOBALS['strWarningInaccurateStats'] = "Certaines de ces statistiques ont été journalisées dans un fuseau horaire non-UTC, et peuvent ne pas être affichées dans le bon fuseau horaire.";
$GLOBALS['strWarningInaccurateReadMore'] = "En savoir plus à ce sujet";
$GLOBALS['strWarningInaccurateReport'] = "Certaines de ces statistiques ont été journalisées dans un fuseau horaire non-UTC, et peuvent ne pas être affichées dans le bon fuseau horaire.";

//Validation
$GLOBALS['strRequiredFieldLegend'] = "demande un champ rempli";
$GLOBALS['strFormContainsErrors'] = "Le formulaire contient des erreurs, veuillez corriger les champs signalés ci-dessous.";
$GLOBALS['strXRequiredField'] = "%s sont demandés";
$GLOBALS['strEmailField'] = "Veuillez entrer un email valide";
$GLOBALS['strNumericField'] = "Veuillez entrer un nombre (seuls des chiffres sont autorisés)";
$GLOBALS['strGreaterThanZeroField'] = "Doit être supérieur à 0";
$GLOBALS['strXGreaterThanZeroField'] = "%s doit être supérieur à 0";
$GLOBALS['strXPositiveWholeNumberField'] = "%s doit être un nombre entier positif";
$GLOBALS['strInvalidWebsiteURL'] = "URL de site invalide";

// Email
$GLOBALS['strSirMadam'] = "Madame, Monsieur,";
$GLOBALS['strMailSubject'] = "Rapport de l'annonceur";
$GLOBALS['strMailHeader'] = "Chèr(e) {contact},";
$GLOBALS['strMailBannerStats'] = "Vous trouverez ci-dessous les statistiques de bannières pour {clientname} :";
$GLOBALS['strMailBannerActivatedSubject'] = "Campagne activée";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Campagne désactivée";
$GLOBALS['strMailBannerActivated'] = "La campagne ci-dessous a été activée car
la date d'activation de campagne a été atteinte.";
$GLOBALS['strMailBannerDeactivated'] = "La campagne ci-dessous a été désactivée car";
$GLOBALS['strMailFooter'] = "Cordialement,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "Cette campagne est actuellement inactive parce que";
$GLOBALS['strBeforeActivate'] = "la date d'activation n'a pas encore été atteinte";
$GLOBALS['strAfterExpire'] = "la date d'expiration a été atteinte";
$GLOBALS['strNoMoreImpressions'] = "il ne reste plus d'impressions";
$GLOBALS['strNoMoreClicks'] = "il ne reste plus de clics";
$GLOBALS['strNoMoreConversions'] = "il ne reste plus de conversions";
$GLOBALS['strWeightIsNull'] = "son poids est réglé à 0";
$GLOBALS['strRevenueIsNull'] = "ses revenus ont une valeur de zéro";
$GLOBALS['strTargetIsNull'] = "sa limite quotidienne est à zéro - vous devez soit spécifier une date de fin et une limite, soit une limite quotidienne";
$GLOBALS['strNoViewLoggedInInterval'] = "Aucune impression n'a été enregistrée pendant la période définie pour ce rapport";
$GLOBALS['strNoClickLoggedInInterval'] = "Aucun clic n'a été enregistré pendant la période définie pour ce rapport";
$GLOBALS['strNoConversionLoggedInInterval'] = "Aucune conversion n'a été enregistrée pendant la période définie pour ce rapport";
$GLOBALS['strMailReportPeriod'] = "Ce rapport inclut les statistiques du {startdate} au {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "Ce rapport inclut toutes les statistiques jusqu'au {enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "Il n'y a aucunes statistiques disponibles pour cette campagne";
$GLOBALS['strImpendingCampaignExpiry'] = "Fin imminente de la campagne";
$GLOBALS['strYourCampaign'] = "Votre campagne";
$GLOBALS['strTheCampiaignBelongingTo'] = "La campagne appartenant à";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} montré ci-dessous est prévu pour finir le {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} montré ci-dessous a moins de {limit} impressions restantes.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "En conséquence, la campagne sera bientôt automatiquement désactivée, et les
bannières suivantes de la campagne seront aussi desactivées :";

// Priority
$GLOBALS['strPriority'] = "Priorité";
$GLOBALS['strSourceEdit'] = "Éditer les sources";

// Preferences
$GLOBALS['strPreferences'] = "Préférences";
$GLOBALS['strUserPreferences'] = "Préférences de l'utilisateur";
$GLOBALS['strChangePassword'] = "Changer le mot de passe";
$GLOBALS['strChangeEmail'] = "Changer l'e-mail";
$GLOBALS['strCurrentPassword'] = "Mot de passe actuel";
$GLOBALS['strChooseNewPassword'] = "Choisir un nouveau mot de passe";
$GLOBALS['strReenterNewPassword'] = "Entrer à nouveau le nouveau mot de passe";
$GLOBALS['strNameLanguage'] = "Nom & Langue";
$GLOBALS['strAccountPreferences'] = "Préférences du compte";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Préférences des rapports de campagnes par e-mail";
$GLOBALS['strTimezonePreferences'] = "Préférence de fuseau horaire";
$GLOBALS['strAdminEmailWarnings'] = "Alertes e-mail des administrateurs";
$GLOBALS['strAgencyEmailWarnings'] = "Alertes e-mail des agences";
$GLOBALS['strAdveEmailWarnings'] = "Alertes e-mail des annonceurs";
$GLOBALS['strFullName'] = "Nom complet";
$GLOBALS['strEmailAddress'] = "Adresse e-mail";
$GLOBALS['strUserDetails'] = "Informations utilisateur";
$GLOBALS['strUserInterfacePreferences'] = "Préférences de l'interface utilisateur";
$GLOBALS['strPluginPreferences'] = "Préférences des plugins";
$GLOBALS['strColumnName'] = "Nom de la colonne";
$GLOBALS['strShowColumn'] = "Afficher la colonne";
$GLOBALS['strCustomColumnName'] = "Nom de colonne personnalisé";
$GLOBALS['strColumnRank'] = "Rang de la colonne";

// Long names
$GLOBALS['strRevenue'] = "Recettes";
$GLOBALS['strNumberOfItems'] = "Nombre d'articles";
$GLOBALS['strRevenueCPC'] = "Recettes CPC";
$GLOBALS['strECPM'] = "ECPM";
$GLOBALS['strPendingConversions'] = "Conversions en attente";
$GLOBALS['strImpressionSR'] = "TV impressions";
$GLOBALS['strClickSR'] = "TV clics";

// Short names
$GLOBALS['strRevenue_short'] = "Rec.";
$GLOBALS['strBasketValue_short'] = "VP";
$GLOBALS['strNumberOfItems_short'] = "Nb. articles";
$GLOBALS['strRevenueCPC_short'] = "Rec. CPC";
$GLOBALS['strID_short'] = "Identifiant";
$GLOBALS['strImpressions_short'] = "Impression";
$GLOBALS['strClicks_short'] = "Clics";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strPendingConversions_short'] = "Conv. en attente";
$GLOBALS['strClickSR_short'] = "TV clics";

// Global Settings
$GLOBALS['strGlobalSettings'] = "Paramètres généraux";
$GLOBALS['strGeneralSettings'] = "Paramètres généraux";
$GLOBALS['strMainSettings'] = "Paramètres principaux";
$GLOBALS['strPlugins'] = "Extensions";
$GLOBALS['strChooseSection'] = 'Choisir la section';

// Product Updates
$GLOBALS['strProductUpdates'] = "Mises à jour du produit";
$GLOBALS['strViewPastUpdates'] = "Gérer les mises à jour passées et les sauvegardes";
$GLOBALS['strFromVersion'] = "Depuis la version";
$GLOBALS['strToVersion'] = "À la version";
$GLOBALS['strToggleDataBackupDetails'] = "Afficher/masquer les détails des sauvegardes";
$GLOBALS['strClickViewBackupDetails'] = "cliquer pour afficher les détails de la sauvegarde";
$GLOBALS['strClickHideBackupDetails'] = "cliquer pour masquer les détails de la sauvegarde";
$GLOBALS['strShowBackupDetails'] = "Afficher les détails de la sauvegarde";
$GLOBALS['strHideBackupDetails'] = "Masquer les détails de la sauvegarde";
$GLOBALS['strBackupDeleteConfirm'] = "Voulez-vous vraiment supprimer toutes les sauvegardes créées par cette mise à jour ?";
$GLOBALS['strDeleteArtifacts'] = "Supprimer les artefacts";
$GLOBALS['strArtifacts'] = "Artefacts";
$GLOBALS['strBackupDbTables'] = "Tables de la base de données sauvegardées";
$GLOBALS['strLogFiles'] = "Fichiers journaux";
$GLOBALS['strConfigBackups'] = "Configurations sauvegardées";
$GLOBALS['strUpdatedDbVersionStamp'] = "Tampon de version de la base de données mise à jour";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "MISE À JOUR TERMINÉE";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "MISE À JOUR ÉCHOUÉE";

// Agency
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
$GLOBALS['strSwitchAccount'] = "Basculer vers ce compte";
$GLOBALS['strAgencyStatusInactive'] = "Inactif";

// Channels
$GLOBALS['strChannelToWebsite'] = "vers le site internet";
$GLOBALS['strChannelLimitations'] = "Options de distribution";
$GLOBALS['strChannelsOfWebsite'] = 'dans'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Nom de la variable";
$GLOBALS['strVariableDescription'] = "Décrit";
$GLOBALS['strVariableDataType'] = "Type de données";
$GLOBALS['strVariablePurpose'] = "But";
$GLOBALS['strGeneric'] = "Générique";
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

// Password recovery
$GLOBALS['strForgotPassword'] = "Mot de passe oublié ?";
$GLOBALS['strEmailRequired'] = "Le champ e-mail est requis";
$GLOBALS['strPwdRecEnterEmail'] = "Entrez votre adresse e-mail ci-dessous";
$GLOBALS['strPwdRecEnterPassword'] = "Entrez votre nouveau mot de passe ci-dessous";

// Password recovery - Default


// Password recovery - Welcome email

// Password recovery - Hash update

// Password reset warning

// Audit
$GLOBALS['strAdditionalItems'] = "et les objets supplémentaires";
$GLOBALS['strFor'] = "pour";
$GLOBALS['strHas'] = "contient";
$GLOBALS['strBinaryData'] = "Données binaires";
$GLOBALS['strAuditTrailDisabled'] = "La piste d'audit a été désactivée par l'administrateur. Aucun évènement ne sera plus journalisé ni affiché dans la liste de piste d'audit.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "Aucune activité utilisateur n'a été enregistrée dans l'intervalle que vous avez sélectionné.";
$GLOBALS['strAuditTrail'] = "Piste d'audit";
$GLOBALS['strAuditTrailSetup'] = "Paramétrer la piste d'audit aujourd'hui";
$GLOBALS['strAuditTrailGoTo'] = "Aller à la page de la piste d'audit";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>La piste d'audit vous permet de voir qui a fait quoi et quand. Ou, d'une autre façon, cela permet de suivre les modifications du système effectuées dans {$PRODUCT_NAME}</li> <li>Ce message s'affiche car vous n'avez pas activé la piste d'audit</li> <li>Vous voulez en savoir plus ? Lisez la <a href='{$PRODUCT_DOCSURL}/settings/auditTrail' class='site-link' target='help' >documentation sur la piste d'audit</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Aller à la page des campagnes";
$GLOBALS['strCampaignSetUp'] = "Paramétrer une campagne aujourd'hui";
$GLOBALS['strCampaignNoRecords'] = "<li>Les campagnes vous permettent de regrouper plusieurs bannières publicitaires, de n'importe quelles tailles, qui partagent les mêmes prérequis publicitaires</li><li>Gagnez du temps en regroupant des bannières dans une campagne afin de ne plus définir de paramètres de distribution pour chaque publicité séparément</li><li>Consultez la <a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/inventory/advertisersAndCampaigns/campaigns'>documentation sur les campagnes</a> !</li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>Il n'y a aucune activité de campagne à afficher.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "Aucune campagne n'a démarré ou terminé dans l'intervalle que vous avez sélectionné";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>Afin d'afficher les campagnes que vous avez commencées ou terminées au cours de la période sélectionnée, la piste d'audit doit être activée</li>	        <li>Vous voyez ce message car vous n'avez pas activé la piste d'audit</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Activer la piste d'audit pour commencer à afficher les campagnes";

$GLOBALS['strUnsavedChanges'] = "Vous n'avez pas sauvé les modifications de cette page, assurez-vous de cliquez sur \"Sauver les changements\" quand vous aurez terminé";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "Vous travaillez maintenant en tant que <b>%s</b>";
$GLOBALS['strYouDontHaveAccess'] = "Vous n'avez pas accès à cette page. Vous avez été redirigé.";

$GLOBALS['strAdvertiserHasBeenAdded'] = "L'annonceur <a href='%s'>%s</a> a été ajouté, <a href='%s'>ajoutez une campagne</a>";
$GLOBALS['strAdvertiserHasBeenUpdated'] = "L'annonceur <a href='%s'>%s</a> a été mis à jour";
$GLOBALS['strAdvertiserHasBeenDeleted'] = "L'annonceur <b>%s</b> a été supprimé";
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

$GLOBALS['strCampaignHasBeenAdded'] = "La campagne <a href='%s'>%s</a> a été ajoutée, <a href='%s'>ajoutez une bannière</a>";
$GLOBALS['strCampaignHasBeenUpdated'] = "La campagne <a href='%s'>%s</a> a été mise à jour";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "Les traceurs liés à la campagne <a href='%s'>%s</a> ont été mis à jour";
$GLOBALS['strCampaignHasBeenDeleted'] = "La campagne <b>%s</b> a été supprimée";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "Toutes les campagnes sélectionnées ont été mises à jour";
$GLOBALS['strCampaignHasBeenDuplicated'] = "La campagne <a href='%s'>%s</a> a été déplacée vers <a href='%s'>%s</a>";
$GLOBALS['strCampaignHasBeenMoved'] = "La campagne <b>%s</b> a été déplacée vers l'annonceur <b>%s</b>";

$GLOBALS['strBannerHasBeenAdded'] = "La bannière <a href='%s'>%s</a> a été ajoutée";
$GLOBALS['strBannerHasBeenUpdated'] = "La bannière <a href='%s'>%s</a> a été mise à jour";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "Les paramètres avancées pour la bannière <a href='%s'>%s</a> ont été mis à jour";
$GLOBALS['strBannerAclHasBeenUpdated'] = "Les options de distribution de la bannière <a href='%s'>%s</a> ont été mises à jour";
$GLOBALS['strBannerAclHasBeenAppliedTo'] = "Options de livraison pour la bannière <a href='%s'>%s</a> ont été appliquées à %d bannières";
$GLOBALS['strBannerHasBeenDeleted'] = "La bannière <b>%s</b> a été supprimée";
$GLOBALS['strBannersHaveBeenDeleted'] = "Toutes les bannières sélectionnées ont été supprimées";
$GLOBALS['strBannerHasBeenDuplicated'] = "La bannière <a href='%s'>%s</a> a été copiée vers <a href='%s'>%s</a>";
$GLOBALS['strBannerHasBeenMoved'] = "La bannière <b>%s</b> a été déplacée vers la campagne <b>%s</b>";
$GLOBALS['strBannerHasBeenActivated'] = "La bannière <a href='%s'>%s</a> a été activée";
$GLOBALS['strBannerHasBeenDeactivated'] = "La bannière <a href='%s'>%s</a> a été désactivée";

$GLOBALS['strXZonesLinked'] = "<b>%s</b> zone(s) liée(s)";
$GLOBALS['strXZonesUnlinked'] = "<b>%s</b> zone(s) déliée(s)";

$GLOBALS['strWebsiteHasBeenAdded'] = "Le site <a href='%s'>%s</a> a été ajouté, <a href='%s'>ajoutez une zone</a>";
$GLOBALS['strWebsiteHasBeenUpdated'] = "Le site <a href='%s'>%s</a> a été mis à jour";
$GLOBALS['strWebsiteHasBeenDeleted'] = "Le site <b>%s</b> a été supprimé";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "Tous les sites sélectionnés ont été supprimés";

$GLOBALS['strZoneHasBeenAdded'] = "La zone <a href='%s'>%s</a> a été ajoutée";
$GLOBALS['strZoneHasBeenUpdated'] = "La zone <a href='%s'>%s</a> a été mise à jour";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "Les paramètres avancés pour la zone <a href='%s'>%s</a> ont été mis à jour";
$GLOBALS['strZoneHasBeenDeleted'] = "La zone <b>%s</b> a été supprimée";
$GLOBALS['strZonesHaveBeenDeleted'] = "Toutes les zones sélectionnées ont été mises à jour";
$GLOBALS['strZoneHasBeenDuplicated'] = "La zone <a href='%s'>%s</a> a été copiée vers <a href='%s'>%s</a>";
$GLOBALS['strZoneHasBeenMoved'] = "La zone <b>%s</b> a été déplacée vers le site <b>%s</b>";
$GLOBALS['strZoneLinkedBanner'] = "La bannière a été liée à la zone <a href='%s'>%s</a>";
$GLOBALS['strZoneLinkedCampaign'] = "La campagne a été liée à la zone <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedBanner'] = "La bannière a été déliée de la zone <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedCampaign'] = "La campagne a été déliée de la zone <a href='%s'>%s</a>";


$GLOBALS['strUserPreferencesUpdated'] = "Vos <b>%s</b> préferences ont été mises à jour";
$GLOBALS['strEmailChanged'] = "Votre e-mail a été changé";
$GLOBALS['strPasswordChanged'] = "Votre mot de passe a été changé";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> a été mis à jour";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> a été mis à jour";

// Report error messages
$GLOBALS['strReportErrorUnknownCode'] = "Code erreur inconnu N°";

/* ------------------------------------------------------- */
/* Password strength                                       */
/* ------------------------------------------------------- */


if (!isset($GLOBALS['strPasswordScore'])) {
    $GLOBALS['strPasswordScore'] = [];
}



/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyNextItem'] = ",";
$GLOBALS['keyPreviousItem'] = " ";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "r";
$GLOBALS['keyCollapseAll'] = "t";
$GLOBALS['keyExpandAll'] = "d";
$GLOBALS['keyNext'] = "s";
