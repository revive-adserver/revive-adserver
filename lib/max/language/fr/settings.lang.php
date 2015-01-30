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

// Installer translation strings
$GLOBALS['strInstall'] = "Installer";
$GLOBALS['strDatabaseSettings'] = "Base de données {$phpAds_dbmsname}";
$GLOBALS['strAdminSettings'] = "Paramètres de l'administrateur";
$GLOBALS['strAdminAccount'] = "Compte administrateur";
$GLOBALS['strAdvancedSettings'] = "Paramètres avancés";
$GLOBALS['strWarning'] = "Attention";
$GLOBALS['strBtnContinue'] = "Continuer »";
$GLOBALS['strBtnRecover'] = "Reprendre »";
$GLOBALS['strBtnStartAgain'] = "Recommencer la mise à jour »";
$GLOBALS['strBtnGoBack'] = "« Retour";
$GLOBALS['strBtnAgree'] = "J'accepte »";
$GLOBALS['strBtnDontAgree'] = "« Je refuse";
$GLOBALS['strBtnRetry'] = "Réessayer";
$GLOBALS['strWarningRegisterArgcArv'] = "La variable register_argc_argv de la configuration PHP doit être activée afin de pouvoir lancer la maintenance depuis la ligne de commande.";
$GLOBALS['strTablesType'] = "Type de tables";


$GLOBALS['strRecoveryRequiredTitle'] = "Votre précédente tentative de mise à jour a rencontré une erreur";
$GLOBALS['strRecoveryRequired'] = "Une erreur est survenue lors du traitement de votre précédente mise à jour et {$PRODUCT_NAME} doit tenter de reprendre le processus de mise à jour. Veuillez cliquez sur le bouton Reprendre ci-dessous.";

$GLOBALS['strOaUpToDate'] = "Votre base de données {$PRODUCT_NAME} et votre structure de fichiers utilisent tous deux la version la plus récente, si bien qu'aucune mise à jour n'est requise pour l'instant. Veuillez cliquer sur Continuer afin de vous rendre au panneau d'administration d'{$PRODUCT_NAME}.";
$GLOBALS['strOaUpToDateCantRemove'] = "Attention : le fichier UPGRADE est toujours présent dans votre dossier var. Nous ne pouvons supprimer ce fichier en raison de permissions insuffisantes. Veuillez supprimer ce fichier vous-même.";
$GLOBALS['strRemoveUpgradeFile'] = "Vous devez retirer le fichier UPGRADE du dossier var.";
$GLOBALS['strDbSuccessIntro'] = "La base de données {$PRODUCT_NAME} a maintenant été créée. Veuillez cliquer sur le bouton 'Continuer' afin de passer à la configuration des paramètres Administrateur et Distribution de {$PRODUCT_NAME}.";
$GLOBALS['strDbSuccessIntroUpgrade'] = "Votre système a été mis à jour avec succès. Les écrans restants vous aideront à mettre à jour la configuration de votre nouveau serveur publicitaire.";

$GLOBALS['strErrorWritePermissions'] = "Des erreurs de permissions de fichiers ont été détectées et doivent être corrigées avant de pouvoir continuer.<br />Pour corriger ces erreur sur un système Linux, essayez de taper la(les) commande(s) suivante(s) :";

$GLOBALS['strErrorWritePermissionsWin'] = "Des erreurs de permissions de fichiers ont été détectées et doivent être corrigées avant de pouvoir continuer.";
$GLOBALS['strCheckDocumentation'] = "Pour plus d'aide, veuillez consulter la <a href='{$PRODUCT_DOCSURL}'>documentation d'{$PRODUCT_NAME} </a>.";

$GLOBALS['strAdminUrlPrefix'] = "URL de l'interface d'administration";
$GLOBALS['strDeliveryUrlPrefix'] = "URL du moteur de distribution";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL du moteur de distribution (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL de stockage des images";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL de stockage des images (SSL)";

$GLOBALS['strInvalidUserPwd'] = "Nom d'utilisateur, ou mot de passe invalide";

$GLOBALS['strUpgrade'] = "Mise à niveau";
$GLOBALS['strSystemUpToDate'] = "Votre système est déjà à jour, et aucune mise à niveau n'est nécessaire pour le moment. <br>Cliquez sur <b>Continuer</b> pour accéder à la page d'accueil.";
$GLOBALS['strSystemNeedsUpgrade'] = "La structure de la base de données et le fichier de configuration doivent être mis à jour pour fonctionner correctement. Cliquez sur <b>Continuer</b> pour commencer le processus de mise à jour. <br><br>Suivant la version à laquelle vous êtes, et la quantité de statistiques présentes dans la base, cette opération peut provoquer une grande charge sur le serveur SQL. Merci d'être patient. Cette mise à jour peut prendre jusqu'à plusieurs minutes.";
$GLOBALS['strSystemUpgradeBusy'] = "Mise à jour du système en cours, merci de patienter...";
$GLOBALS['strSystemRebuildingCache'] = "Reconstruction du cache, merci de patienter...";
$GLOBALS['strServiceUnavalable'] = "Le service est temporairement indisponible. Mise à jour du système en cours.";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Choisir la section";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons. " .
    "If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues. " .
    "If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig'] = "Impossible d'écrire les modifications dans le fichier de configuration";
$GLOBALS['strUnableToWritePrefs'] = "Impossible d'appliquer les préférences dans la base de données";
$GLOBALS['strImageDirLockedDetected'] = "Le <b>dossier images</b> indiqué n'est pas accessible en écriture par le serveur. <br>Vous ne pourrez pas poursuivre tant que vous n'aurez pas changé les permissions ou créé le dossier.";

// Configuration Settings
$GLOBALS['strConfigurationSetup'] = "Liste de contrôle de la configuration";
$GLOBALS['strConfigurationSettings'] = "Paramètres de configuration";

// Administrator Settings
$GLOBALS['strAdministratorSettings'] = "Paramètres de l'administrateur";
$GLOBALS['strLoginCredentials'] = "Informations de connexion";
$GLOBALS['strAdminUsername'] = "Identifiant de l'administrateur";
$GLOBALS['strAdminPassword'] = "Mot de passe de l'administrateur";
$GLOBALS['strInvalidUsername'] = "Identifiant invalide";
$GLOBALS['strBasicInformation'] = "Information de base";
$GLOBALS['strAdminFullName'] = "Nom complet de l'administrateur";
$GLOBALS['strAdminEmail'] = "Adresse e-mail de l'admin";
$GLOBALS['strAdministratorEmail'] = "Adresse e-mail de l'administrateur";
$GLOBALS['strCompanyName'] = "Nom de la société";
$GLOBALS['strAdminCheckUpdates'] = "Détection automatique des mises à jour de produits et des alertes de sécurité (Recommandé)";
$GLOBALS['strAdminShareStack'] = "Partager vos informations techniques avec l'équipe OpenX pour aider au test et au développement";
$GLOBALS['strAdminCheckEveryLogin'] = "Tous logins";
$GLOBALS['strAdminCheckDaily'] = "Par jour";
$GLOBALS['strAdminCheckWeekly'] = "Par semaine";
$GLOBALS['strAdminCheckMonthly'] = "Par mois";
$GLOBALS['strAdminCheckNever'] = "Jamais";
$GLOBALS['strNovice'] = "Les actions de suppression nécessitent une confirmation par sécurité";
$GLOBALS['strUserlogEmail'] = "Journaliser tous les messages e-mail sortants";
$GLOBALS['strEnableDashboardSyncNotice'] = "Veuillez activer la <a href='account-settings-update.php'>vérification des mises à jour</a> pour utiliser le tableau de bord.";
$GLOBALS['strTimezone'] = "Fuseau horaire";
$GLOBALS['strTimezoneEstimated'] = "Fuseau horaire détecté";
$GLOBALS['strTimezoneGuessedValue'] = "Fuseau horaire du serveur réglé incorrectement dans PHP";
$GLOBALS['strTimezoneSeeDocs'] = "Veuillez lire la %DOCS% au sujet du réglage de cette variable dans PHP.";
$GLOBALS['strAdminSettingsTitle'] = "Créer un compte administrateur";
$GLOBALS['strAdminSettingsIntro'] = "Veuillez remplir ce formulaire pour créer le compte d'administration de votre serveur publicitaire.";
$GLOBALS['strConfigSettingsIntro'] = "Veuillez vérifier les paramètres de configuration ci-dessous et procéder aux changements nécessaires avant de poursuivre. Si vous n'êtes pas sûr de vous, laissez les valeurs par défaut.";

$GLOBALS['strEnableAutoMaintenance'] = "Exécuter automatiquement une maintenance pendant la distribution si la maintenance planifiée n'est pas activée";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Base de données {$phpAds_dbmsname}";
$GLOBALS['strDatabaseServer'] = "Paramètres généraux de la base de données";
$GLOBALS['strDbLocal'] = "Utiliser la connexion au socket local";
$GLOBALS['strDbType'] = "Type de la base de données";
$GLOBALS['strDbHost'] = "Serveur de la base de données";
$GLOBALS['strDbSocket'] = "Socket de base de données";
$GLOBALS['strDbPort'] = "Port de la base de données";
$GLOBALS['strDbUser'] = "Identifiant de la base de données";
$GLOBALS['strDbPassword'] = "Mot de passe de la base de données";
$GLOBALS['strDbName'] = "Nom de la base de données";
$GLOBALS['strDbNameHint'] = "La base de données sera créée si elle n'existe pas";
$GLOBALS['strDatabaseOptimalisations'] = "Paramètres d'optimisation de la base de données";
$GLOBALS['strPersistentConnections'] = "Utiliser les connexions persistantes";
$GLOBALS['strCantConnectToDb'] = "Connexion à la base de données impossible";
$GLOBALS['strCantConnectToDbDelivery'] = 'Connexion impossible à la base de données pour la distribution';
$GLOBALS['strDemoDataInstall'] = "Installer les données de démonstration";
$GLOBALS['strDemoDataIntro'] = "Des données d'installation par défaut peuvent être chargées dans {$PRODUCT_NAME} afin de vous aider à commencer à distribuer de la publicité en ligne. Les types de bannières les plus communs, ainsi que quelques campagnes initiales peuvent être chargées et pré-configurées. Ceci est hautement recommandé pour les nouvelles installations.";



// Email Settings
$GLOBALS['strEmailSettings'] = "Paramètres e-mail";
$GLOBALS['strEmailAddresses'] = "Adresse de l'expéditeur des e-mails";
$GLOBALS['strEmailFromName'] = "Nom de l'expéditeur des e-mails";
$GLOBALS['strEmailFromAddress'] = "Adresse e-mail de l'expéditeur des e-mails";
$GLOBALS['strEmailFromCompany'] = "Société de l'expéditeur des e-mails";
$GLOBALS['strQmailPatch'] = "Patch qmail";
$GLOBALS['strEnableQmailPatch'] = "Activer le patch qmail";
$GLOBALS['strEmailHeader'] = "En-têtes HTML";
$GLOBALS['strEmailLog'] = "Journal HTML";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Paramètres de la piste d'audit";
$GLOBALS['strEnableAudit'] = "Activer la piste d'audit";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Paramètres de journalisation du débogage";
$GLOBALS['strProduction'] = "Serveur de production";
$GLOBALS['strEnableDebug'] = "Activer la journalisation du débogage";
$GLOBALS['strDebugMethodNames'] = "Inclure les noms des méthodes dans le journal de débogage";
$GLOBALS['strDebugLineNumbers'] = "Inclure les numéros de lignes dans le journal de débogage";
$GLOBALS['strDebugType'] = "Type de journal de débogage";
$GLOBALS['strDebugTypeFile'] = "Fichier";
$GLOBALS['strDebugTypeSql'] = "Base de données SQL";
$GLOBALS['strDebugName'] = "Nom du journal de débogage, calendrier, table SQL,<br />ou installation Syslog";
$GLOBALS['strDebugPriority'] = "Niveau de priorité du débogage";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Le plus d'informations";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Informations par défaut";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Le moins d'informations";
$GLOBALS['strDebugIdent'] = "Chaîne d'identification de débogage";
$GLOBALS['strDebugUsername'] = "Identifiant mCal, serveur SQL";
$GLOBALS['strDebugPassword'] = "Mot de passe mCal, serveur SQL";
$GLOBALS['strProductionSystem'] = "Système en production";

// Delivery Settings
$GLOBALS['strDeliverySettings'] = "Paramètres de distribution";
$GLOBALS['strWebPath'] = "$PRODUCT_NAME Server Access Paths";
$GLOBALS['strWebPathSimple'] = "Emplacement web";
$GLOBALS['strDeliveryPath'] = "Emplacement de distribution";
$GLOBALS['strImagePath'] = "Emplacement des images";
$GLOBALS['strDeliverySslPath'] = "Emplacement de distribution SSL";
$GLOBALS['strImageSslPath'] = "Emplacement des images SSL";
$GLOBALS['strImageStore'] = "Dossier des images";
$GLOBALS['strTypeWebSettings'] = "Paramètres de stockage des bannières locales sur le serveur web";
$GLOBALS['strTypeWebMode'] = "Méthode de stockage";
$GLOBALS['strTypeWebModeLocal'] = "Répertoire local";
$GLOBALS['strTypeDirError'] = "Le répertoire local n'est pas accessible en écriture par le serveur web";
$GLOBALS['strTypeWebModeFtp'] = "Serveur FTP externe";
$GLOBALS['strTypeWebDir'] = "Répertoire local";
$GLOBALS['strTypeFTPHost'] = "Hôte FTP";
$GLOBALS['strTypeFTPDirectory'] = "Répertoire de l'hôte";
$GLOBALS['strTypeFTPUsername'] = "Connexion";
$GLOBALS['strTypeFTPPassword'] = "Mot de passe";
$GLOBALS['strTypeFTPPassive'] = "Utiliser le FTP passif";
$GLOBALS['strTypeFTPErrorDir'] = "Le répertoire de l'hôte FTP n'existe pas";
$GLOBALS['strTypeFTPErrorConnect'] = "Connexion au serveur FTP impossible, l'identifiant ou le mot de passe est incorrect";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Votre installation de PHP ne supporte pas le FTP.";
$GLOBALS['strTypeFTPErrorUpload'] = "Téléchargement impossible vers le serveur FTP, vérifiez les permissions du répertoire hôte";
$GLOBALS['strTypeFTPErrorHost'] = "L'hôte FTP est incorrect";
$GLOBALS['strDeliveryFilenames'] = "Noms des fichiers de distribution";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Clic publicitaire";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Variables de conversion publicitaire";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Contenu publicitaire";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Conversion publicitaire";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Conversion publicitaire (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Cadre publicitaire";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Image publicitaire";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Publicité (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Calque publicitaire";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Évènement publicitaire";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Popup publicitaire";
$GLOBALS['strDeliveryFilenamesAdView'] = "Affichage publicitaire";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "Invocation XML RPC";
$GLOBALS['strDeliveryFilenamesLocal'] = "Invocation locale";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Contrôleur frontal";
$GLOBALS['strDeliveryFilenamesFlash'] = "Inclusion Flash (Peut être une URL complète)";
$GLOBALS['strDeliveryCaching'] = "Paramètres du cache de distribution des bannières";
$GLOBALS['strDeliveryCacheLimit'] = "Temps entre les mises à jour du cache des bannières (secondes)";
$GLOBALS['strDeliveryCacheStore'] = "Type de stockage du cache de distribution des bannières";

$GLOBALS['strErrorInCacheStorePlugin'] = "Des erreurs ont été signalées par le \"%s\" plugin de distribution:";
$GLOBALS['strDeliveryCacheStorage'] = "Type de cache du stockage de distribution";

$GLOBALS['strOrigin'] = "Utiliser un serveur d'origine distante";
$GLOBALS['strOriginType'] = "Type du serveur d'origine";
$GLOBALS['strOriginHost'] = "Nom de l'hôte du serveur d'origine";
$GLOBALS['strOriginPort'] = "Numéro de port de la base de données d'origine";
$GLOBALS['strOriginScript'] = "Fichier script de la base de données d'origine";
$GLOBALS['strOriginTimeout'] = "Délai d'expiration de l'origine (secondes)";
$GLOBALS['strOriginProtocol'] = "Protocole du serveur d'origine";

$GLOBALS['strDeliveryAcls'] = "Evaluer les limitations de distribution des bannières au cours de la distribution";
$GLOBALS['strDeliveryObfuscate'] = "Masquer le canal lors de la distribution des publicités";
$GLOBALS['strDeliveryExecPhp'] = "Autoriser le code PHP à être exécuté dans les publicités<br />(Attention : risque de sécurité)";
$GLOBALS['strDeliveryCtDelimiter'] = "Délimiteur de suivi des clics par les tiers";
$GLOBALS['strGlobalDefaultBannerUrl'] = "URL de l'image de la bannière par défaut générale";
$GLOBALS['strP3PSettings'] = "Politique de vie privée P3P";
$GLOBALS['strUseP3P'] = "Utiliser les politiques P3P";
$GLOBALS['strP3PCompactPolicy'] = "Politique P3P réduite";
$GLOBALS['strP3PPolicyLocation'] = "Emplacement de la politique P3P";

// General Settings
$GLOBALS['generalSettings'] = "Système de paramétrage global";
$GLOBALS['uiEnabled'] = "Interface utilisateur activée";
$GLOBALS['defaultLanguage'] = "Langage par défaut<br />(Chaque utilisateur choisi sa propre langue)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Paramètres de géolocalisation";
$GLOBALS['strGeotargeting'] = "Paramètres de géolocalisation";
$GLOBALS['strGeotargetingType'] = "Type du module de géolocalisation";
$GLOBALS['strGeotargetingUseBundledCountryDb'] = "Utiliser la base de données MaxMind GeoLiteCountry fournie";
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "Emplacement de la base de données MaxMind GeoIP Country";
$GLOBALS['strGeotargetingGeoipRegionLocation'] = "Emplacement de la base de données MaxMind GeoIP Region";
$GLOBALS['strGeotargetingGeoipCityLocation'] = "Emplacement de la base de données MaxMind GeoIP City";
$GLOBALS['strGeotargetingGeoipAreaLocation'] = "Emplacement de la base de données MaxMind GeoIP Area";
$GLOBALS['strGeotargetingGeoipDmaLocation'] = "Emplacement de la base de données MaxMind GeoIP DMA";
$GLOBALS['strGeotargetingGeoipOrgLocation'] = "Emplacement de la base de données MaxMind GeoIP Organisation";
$GLOBALS['strGeotargetingGeoipIspLocation'] = "Emplacement de la base de données MaxMind GeoIP ISP";
$GLOBALS['strGeotargetingGeoipNetspeedLocation'] = "Emplacement de la base de données MaxMind GeoIP Netspeed";
$GLOBALS['strGeoShowUnavailable'] = "Afficher les limitations de géolocalisation de distribution même si les données GeoIP sont indisponibles";
$GLOBALS['strGeotrackingGeoipCountryLocationError'] = "La base de données MaxMind GeoIP Country n'existe pas à l'emplacement spécifié";
$GLOBALS['strGeotrackingGeoipRegionLocationError'] = "La base de données MaxMind GeoIP Region n'existe pas à l'emplacement spécifié";
$GLOBALS['strGeotrackingGeoipCityLocationError'] = "La base de données MaxMind GeoIP City n'existe pas à l'emplacement spécifié";
$GLOBALS['strGeotrackingGeoipAreaLocationError'] = "La base de données MaxMind GeoIP Area n'existe pas à l'emplacement spécifié";
$GLOBALS['strGeotrackingGeoipDmaLocationError'] = "La base de données MaxMind GeoIP DMA n'existe pas à l'emplacement spécifié";
$GLOBALS['strGeotrackingGeoipOrgLocationError'] = "La base de données MaxMind GeoIP Organisation n'existe pas à l'emplacement spécifié";
$GLOBALS['strGeotrackingGeoipIspLocationError'] = "La base de données MaxMind GeoIP ISP n'existe pas à l'emplacement spécifié";
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = "La base de données MaxMind GeoIP Netspeed n'existe pas à l'emplacement spécifié";

// Interface Settings
$GLOBALS['strInventory'] = "Inventaire";
$GLOBALS['strUploadConversions'] = "Conversions de téléchargement";
$GLOBALS['strShowCampaignInfo'] = "Afficher des informations supplémentaires sur les campagnes sur la page <i>Campagnes</i>";
$GLOBALS['strShowBannerInfo'] = "Afficher des informations supplémentaires sur les bannières sur la page <i>Bannières</i>";
$GLOBALS['strShowCampaignPreview'] = "Afficher des aperçus de toutes les bannières sur la page <i>Bannières</i>";
$GLOBALS['strShowBannerHTML'] = "Afficher une bannière à la place du code HTML pour les aperçus de bannières HTML";
$GLOBALS['strShowBannerPreview'] = "Afficher un aperçu de la bannière en haut des pages liées aux bannières";
$GLOBALS['strHideInactive'] = "Masquer les inactifs";
$GLOBALS['strGUIShowMatchingBanners'] = "Afficher les campagnes parentes sur les pages <i>Bannières liées</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Afficher les bannières correspondantes sur les pages <i>Bannières liées</i>";
$GLOBALS['strGUIAnonymousCampaignsByDefault'] = "Attribuer les campagnes à Anonyme par défaut";
$GLOBALS['strStatisticsDefaults'] = "Statistiques";
$GLOBALS['strBeginOfWeek'] = "Début de la semaine";
$GLOBALS['strPercentageDecimals'] = "Nombre de décimales pour les pourcentages";
$GLOBALS['strWeightDefaults'] = "Poids par défaut";
$GLOBALS['strDefaultBannerWeight'] = "Poids par défaut d'une bannière";
$GLOBALS['strDefaultCampaignWeight'] = "Poids par défaut d'une campagne";
$GLOBALS['strDefaultBannerWErr'] = "Le poids par défaut d'une bannière doit être un nombre entier positif";
$GLOBALS['strDefaultCampaignWErr'] = "Le poids par défaut d'une campagne doit être un nombre entier positif";
$GLOBALS['strConfirmationUI'] = "Confirmation dans l'interface utilisateur";

$GLOBALS['strPublisherDefaults'] = "Paramètres par défaut d'un site web";
$GLOBALS['strModesOfPayment'] = "Modes de paiement";
$GLOBALS['strCurrencies'] = "Devises";
$GLOBALS['strCategories'] = "Catégories";
$GLOBALS['strHelpFiles'] = "Fichiers d'aides";
$GLOBALS['strHasTaxID'] = "ID de taxe";
$GLOBALS['strDefaultApproved'] = "Case à cocher approuvé";

// CSV Import Settings
$GLOBALS['strChooseAdvertiser'] = "Choisissez l'annonceur";
$GLOBALS['strChooseCampaign'] = "Choisissez la campagne";
$GLOBALS['strChooseCampaignBanner'] = "Choisissez la bannière";
$GLOBALS['strChooseTracker'] = "Choisissez le traceur";
$GLOBALS['strDefaultConversionStatus'] = "Statuts de conversion par défaut";
$GLOBALS['strDefaultConversionType'] = "Type de conversion par défaut";
$GLOBALS['strCSVTemplateSettings'] = "Paramètres du template CSV";
$GLOBALS['strIncludeCountryInfo'] = "Inclure l'information pays";
$GLOBALS['strIncludeBrowserInfo'] = "Inclure l'information du navigateur";
$GLOBALS['strIncludeOSInfo'] = "Inclure l'information de l'OS";
$GLOBALS['strIncludeSampleRow'] = "Inclure la rangée exemple";
$GLOBALS['strCSVTemplateAdvanced'] = "Template avancée";
$GLOBALS['strCSVTemplateIncVariables'] = "Inclure les variables du traceur";

/**
 * @todo remove strBannerSettings if banner is only configurable as a preference
 *       rename // Banner Settings to  // Banner Preferences
 */
// Invocation Settings
$GLOBALS['strAllowedInvocationTypes'] = "Types d'invocation autorisés";
$GLOBALS['strInvocationDefaults'] = "Paramètres par défaut de l'invocation";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Activer le suivi des clics par les tiers par défaut";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Paramètres de distribution des bannières";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Paramètres de la journalisation des bannières";
$GLOBALS['strLogAdRequests'] = "Journaliser une requête à chaque fois qu'une bannière est demandée";
$GLOBALS['strLogAdImpressions'] = "Journaliser une impression à chaque fois qu'une bannière est affichée";
$GLOBALS['strLogAdClicks'] = "Journaliser un clic à chaque fois qu'un visiteur clique sur une bannière";
$GLOBALS['strLogTrackerImpressions'] = "Journaliser une impression de suiveur à chaque fois qu'une balise de suivi est affichée";
$GLOBALS['strReverseLookup'] = "Appliquer un reverse lookup sur les noms d'hôtes des visiteurs quand il n'est pas fourni";
$GLOBALS['strProxyLookup'] = "Essayer de déterminer l'IP réelle des visiteurs se trouvant derrière un serveur proxy";
$GLOBALS['strPreventLogging'] = "Paramètres de blocage de la journalisation des bannières";
$GLOBALS['strIgnoreHosts'] = "Ne pas journaliser de statistiques pour les visiteurs utilisant l'une des adresses IP ou l'un des noms d'hôtes spécifiés";
$GLOBALS['strIgnoreUserAgents'] = "<b>Ne pas</b> journaliser les statistiques des clients ayant n'importe laquelle des chaînes suivantes dans leur user-agent (une par ligne)";
$GLOBALS['strEnforceUserAgents'] = "Ne journaliser <b>que</b> les statistiques des clients ayant n'importe laquelle des chaînes suivantes dans leur user-agent (une par ligne)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Paramètres de stockage des bannières";

// Campaign ECPM settings

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Paramètres de maintenance";
$GLOBALS['strConversionTracking'] = "Paramètres de suivi des conversions";
$GLOBALS['strEnableConversionTracking'] = "Activer le suivi des conversions";
$GLOBALS['strCsvImport'] = "Autoriser le téléchargement des conversions hors-ligne";
$GLOBALS['strBlockAdViews'] = "Ne pas compter les impressions publicitaires si le visiteur a vu la même paire publicité/zone dans l'intervalle de temps spécifié (secondes)";
$GLOBALS['strBlockAdViewsError'] = "La valeur de blocage des impressions publicitaires doit être un entier non négatif";
$GLOBALS['strBlockAdClicks'] = "Ne pas compter les clics publicitaires si le visiteur a vu la même paire publicité/zone dans l'intervalle de temps spécifié (secondes)";
$GLOBALS['strBlockAdClicksError'] = "La valeur de blocage des clics publicitaires doit être un entier non négatif";
$GLOBALS['strMaintenanceOI'] = "Intervalle entre les opérations de maintenance (minutes)";
$GLOBALS['strMaintenanceOIError'] = "L'intervalle entre les opération de maintenance est invalide - consultez la documentation pour les valeurs valides";
$GLOBALS['strPrioritySettings'] = "Paramètres de priorité";
$GLOBALS['strPriorityInstantUpdate'] = "Mettre à jour les priorités des publicités immédiatement après avoir effectué des changements dans l'IU";
$GLOBALS['strDefaultImpConWindow'] = "Fenêtre de connexion des impressions publicitaires par défaut (secondes)";
$GLOBALS['strDefaultImpConWindowError'] = "Si indiquée, la fenêtre de connexion des impressions publicitaires par défaut doit être un entier positif";
$GLOBALS['strDefaultCliConWindow'] = "Fenêtre de connexion des clics publicitaires par défaut (secondes)";
$GLOBALS['strDefaultCliConWindowError'] = "Si indiquée, la fenêtre de connexion des clics publicitaires par défaut doit être un entier positif";
$GLOBALS['strAdminEmailHeaders'] = "Ajouter les en-têtes suivants à tous les e-mails envoyés par {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Envoyer un avertissement quand le nombre d'impressions restantes est inférieur à celui spécifié ici";
$GLOBALS['strWarnLimitErr'] = "La limite d'avertissement doit être un entier positif";
$GLOBALS['strWarnLimitDays'] = "Envoyer un avertissement quand le nombre de jours restants est inférieur à celui spécifié ici";
$GLOBALS['strWarnLimitDaysErr'] = "Le nombre de jours de limite d'avertissement doit être un entier positif";
$GLOBALS['strAllowEmail'] = "Autoriser l'envoi d'e-mails de manière générale";
$GLOBALS['strEmailAddressFrom'] = "Adresse e-mail DEPUIS laquelle envoyer les rapports";
$GLOBALS['strEmailAddressName'] = "Société ou nom de la personne avec laquelle signer les e-mails";
$GLOBALS['strWarnAdmin'] = "Envoyer une alerte à l'administrateur à chaque fois qu'une campagne approche de son expiration";
$GLOBALS['strWarnClient'] = "Envoyer une alerte à l'annonceur à chaque fois qu'une campagne approche de son expiration";
$GLOBALS['strWarnAgency'] = "Envoyer une alerte à l'agence à chaque fois qu'une campagne approche de son expiration";

// UI Settings
$GLOBALS['strGuiSettings'] = "Paramètres de l'interface utilisateur";
$GLOBALS['strGeneralSettings'] = "Paramètres généraux";
$GLOBALS['strAppName'] = "Nom de l'application";
$GLOBALS['strMyHeader'] = "Emplacement du fichier d'en-tête";
$GLOBALS['strMyHeaderError'] = "Le fichier d'en-tête n'existe pas dans l'emplacement que vous avez spécifié";
$GLOBALS['strMyFooter'] = "Emplacement du fichier de pied de page";
$GLOBALS['strMyFooterError'] = "Le fichier de pied de page n'existe pas dans l'emplacement que vous avezspécifié";
$GLOBALS['strDefaultTrackerStatus'] = "État par défaut du suiveur";
$GLOBALS['strDefaultTrackerType'] = "Type par défaut du suiveur";
$GLOBALS['strSSLSettings'] = "Paramètres SSL";
$GLOBALS['requireSSL'] = "Forcer l'accès SSL pour l'interface utilisateur";
$GLOBALS['sslPort'] = "Port SSL utilisé par le serveur web";
$GLOBALS['strDashboardSettings'] = "Paramètres du tableau de bord";

$GLOBALS['strMyLogo'] = "Nom du fichier du logo personnalisé";
$GLOBALS['strMyLogoError'] = "Le fichier du logo n'existe pas dans le répertoire admin/images";
$GLOBALS['strGuiHeaderForegroundColor'] = "Couleur du premier plan de l'en-tête";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Couleur de l'arrière-plan de l'en-tête";
$GLOBALS['strGuiActiveTabColor'] = "Couleur de l'onglet actif";
$GLOBALS['strGuiHeaderTextColor'] = "Couleur du texte dans l'en-tête";
$GLOBALS['strColorError'] = "Veuillez entrer les couleurs au format RGB, comme '0066CC'";

$GLOBALS['strGzipContentCompression'] = "Utiliser la compression de contenu GZIP";
$GLOBALS['strClientInterface'] = "Interface de l'annonceur";
$GLOBALS['strReportsInterface'] = "Interface des rapports";
$GLOBALS['strClientWelcomeEnabled'] = "Activer le message de bienvenue de l'annonceur";
$GLOBALS['strClientWelcomeText'] = "Texte de bienvenue<br />(balises HTML autorisées)";

$GLOBALS['strPublisherInterface'] = "Interface du site web";
$GLOBALS['strPublisherAgreementEnabled'] = "Activer le contrôle d'identification pour les sites web n'ayant pas accepté les termes et conditions";
$GLOBALS['strPublisherAgreementText'] = "Texte de connexion (balises HTML autorisées)";

// Regenerate Platfor Hash script

// Plugin Settings

/* ------------------------------------------------------- */
/* Unknown (unused?) translations                        */
/* ------------------------------------------------------- */

$GLOBALS['strKeywordRetrieval'] = "Autoriser la sélection des bannières par mots clés";
$GLOBALS['strBannerRetrieval'] = "Méthode de sélection des bannières";
$GLOBALS['strRetrieveRandom'] = "Sélection aléatoire (par défaut)";
$GLOBALS['strRetrieveNormalSeq'] = "Sélection séquentielle";
$GLOBALS['strWeightSeq'] = "Sélection séquentielle basée sur le poids des bannières";
$GLOBALS['strFullSeq'] = "Sélection séquentielle totale";
$GLOBALS['strUseConditionalKeys'] = "Autoriser l'utilisation d'opérateurs logiques lors de la sélection directe";
$GLOBALS['strUseMultipleKeys'] = "Autoriser les mots clés multiples lors de la sélection directe";

$GLOBALS['strTableBorderColor'] = "Couleur de la bordure de la table";
$GLOBALS['strTableBackColor'] = "Couleur d'arrière-plan de la table";
$GLOBALS['strTableBackColorAlt'] = "Couleur d'arrière-plan de la table (Alternatif)";
$GLOBALS['strMainBackColor'] = "Couleur principale d'arrière-plan";
$GLOBALS['strOverrideGD'] = "Outrepasser le format d'Image GD";
$GLOBALS['strTimeZone'] = "Fuseau horaire";
