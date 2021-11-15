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
$GLOBALS['strAdminAccount'] = "Compte administrateur";
$GLOBALS['strAdvancedSettings'] = "Paramètres avancés";
$GLOBALS['strWarning'] = "Avertissement";
$GLOBALS['strBtnContinue'] = "Continuer »";
$GLOBALS['strBtnRecover'] = "Reprendre »";
$GLOBALS['strBtnAgree'] = "J'accepte »";
$GLOBALS['strBtnRetry'] = "Réessayer";
$GLOBALS['strWarningRegisterArgcArv'] = "La variable register_argc_argv de la configuration PHP doit être activée afin de pouvoir lancer la maintenance depuis la ligne de commande.";
$GLOBALS['strTablesPrefix'] = "Préfixe des noms des tables";
$GLOBALS['strTablesType'] = "Type de tables";

$GLOBALS['strRecoveryRequiredTitle'] = "Votre précédente tentative de mise à jour a rencontré une erreur";
$GLOBALS['strRecoveryRequired'] = "Une erreur est survenue lors du traitement de votre précédente mise à jour et {$PRODUCT_NAME} doit tenter de reprendre le processus de mise à jour. Veuillez cliquez sur le bouton Reprendre ci-dessous.";

$GLOBALS['strOaUpToDate'] = "Votre base de données {$PRODUCT_NAME} et votre structure de fichiers utilisent tous deux la version la plus récente, si bien qu'aucune mise à jour n'est requise pour l'instant. Veuillez cliquer sur Continuer afin de vous rendre au panneau d'administration d'{$PRODUCT_NAME}.";
$GLOBALS['strOaUpToDateCantRemove'] = "Attention : le fichier UPGRADE est toujours présent dans votre dossier var. Nous ne pouvons supprimer ce fichier en raison de permissions insuffisantes. Veuillez supprimer ce fichier vous-même.";
$GLOBALS['strErrorWritePermissions'] = "Des erreurs de permissions de fichiers ont été détectées et doivent être corrigées avant de pouvoir continuer.<br />Pour corriger ces erreur sur un système Linux, essayez de taper la(les) commande(s) suivante(s) :";

$GLOBALS['strErrorWritePermissionsWin'] = "Des erreurs de permissions de fichiers ont été détectées et doivent être corrigées avant de pouvoir continuer.";
$GLOBALS['strCheckDocumentation'] = "Pour plus d'aide, veuillez consulter la <a href='{$PRODUCT_DOCSURL}'>documentation d'{$PRODUCT_NAME} </a>.";

$GLOBALS['strAdminUrlPrefix'] = "URL de l'interface d'administration";
$GLOBALS['strDeliveryUrlPrefix'] = "URL du moteur de distribution";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL du moteur de distribution (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL de stockage des images";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL de stockage des images (SSL)";


$GLOBALS['strUpgrade'] = "Mise à niveau";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Choisir la section";
$GLOBALS['strUnableToWriteConfig'] = "Impossible d'écrire les modifications dans le fichier de configuration";
$GLOBALS['strUnableToWritePrefs'] = "Impossible d'appliquer les préférences dans la base de données";
$GLOBALS['strImageDirLockedDetected'] = "Le <b>dossier images</b> indiqué n'est pas accessible en écriture par le serveur. <br>Vous ne pourrez pas poursuivre tant que vous n'aurez pas changé les permissions ou créé le dossier.";

// Configuration Settings

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Identifiant de l'administrateur";
$GLOBALS['strAdminPassword'] = "Mot de passe de l'administrateur";
$GLOBALS['strInvalidUsername'] = "Identifiant invalide";
$GLOBALS['strBasicInformation'] = "Information de base";
$GLOBALS['strAdministratorEmail'] = "Adresse e-mail de l'administrateur";
$GLOBALS['strAdminCheckUpdates'] = "Détection automatique des mises à jour de produits et des alertes de sécurité (Recommandé)";
$GLOBALS['strAdminShareStack'] = "Partager vos informations techniques avec l'équipe OpenX pour aider au test et au développement";
$GLOBALS['strNovice'] = "Les actions de suppression nécessitent une confirmation par sécurité";
$GLOBALS['strUserlogEmail'] = "Journaliser tous les messages e-mail sortants";
$GLOBALS['strEnableDashboardSyncNotice'] = "Veuillez activer la <a href='account-settings-update.php'>vérification des mises à jour</a> pour utiliser le tableau de bord.";
$GLOBALS['strTimezone'] = "Fuseau horaire";
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
$GLOBALS['strDeliveryCaching'] = "Paramètres du cache de distribution des bannières";
$GLOBALS['strDeliveryCacheLimit'] = "Temps entre les mises à jour du cache des bannières (secondes)";
$GLOBALS['strDeliveryCacheStore'] = "Type de stockage du cache de distribution des bannières";
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

// Interface Settings
$GLOBALS['strInventory'] = "Inventaire";
$GLOBALS['strShowCampaignInfo'] = "Afficher des informations supplémentaires sur les campagnes sur la page <i>Campagnes</i>";
$GLOBALS['strShowBannerInfo'] = "Afficher des informations supplémentaires sur les bannières sur la page <i>Bannières</i>";
$GLOBALS['strShowCampaignPreview'] = "Afficher des aperçus de toutes les bannières sur la page <i>Bannières</i>";
$GLOBALS['strShowBannerHTML'] = "Afficher une bannière à la place du code HTML pour les aperçus de bannières HTML";
$GLOBALS['strShowBannerPreview'] = "Afficher un aperçu de la bannière en haut des pages liées aux bannières";
$GLOBALS['strHideInactive'] = "Masquer les inactifs";
$GLOBALS['strGUIShowMatchingBanners'] = "Afficher les campagnes parentes sur les pages <i>Bannières liées</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Afficher les bannières correspondantes sur les pages <i>Bannières liées</i>";
$GLOBALS['strStatisticsDefaults'] = "Statistiques";
$GLOBALS['strBeginOfWeek'] = "Début de la semaine";
$GLOBALS['strPercentageDecimals'] = "Nombre de décimales pour les pourcentages";
$GLOBALS['strWeightDefaults'] = "Poids par défaut";
$GLOBALS['strDefaultBannerWeight'] = "Poids par défaut d'une bannière";
$GLOBALS['strDefaultCampaignWeight'] = "Poids par défaut d'une campagne";
$GLOBALS['strConfirmationUI'] = "Confirmation dans l'interface utilisateur";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Paramètres par défaut de l'invocation";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Activer le suivi des clics par les tiers par défaut";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Paramètres de distribution des bannières";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Paramètres de la journalisation des bannières";
$GLOBALS['strLogAdRequests'] = "Journaliser une requête à chaque fois qu'une bannière est demandée";
$GLOBALS['strLogAdImpressions'] = "Journaliser une impression à chaque fois qu'une bannière est affichée";
$GLOBALS['strLogAdClicks'] = "Journaliser un clic à chaque fois qu'un visiteur clique sur une bannière";
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
$GLOBALS['strBlockAdClicks'] = "Ne pas compter les clics publicitaires si le visiteur a vu la même paire publicité/zone dans l'intervalle de temps spécifié (secondes)";
$GLOBALS['strMaintenanceOI'] = "Intervalle entre les opérations de maintenance (minutes)";
$GLOBALS['strPrioritySettings'] = "Paramètres de priorité";
$GLOBALS['strPriorityInstantUpdate'] = "Mettre à jour les priorités des publicités immédiatement après avoir effectué des changements dans l'IU";
$GLOBALS['strAdminEmailHeaders'] = "Ajouter les en-têtes suivants à tous les e-mails envoyés par {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Envoyer un avertissement quand le nombre d'impressions restantes est inférieur à celui spécifié ici";
$GLOBALS['strWarnLimitDays'] = "Envoyer un avertissement quand le nombre de jours restants est inférieur à celui spécifié ici";
$GLOBALS['strWarnAdmin'] = "Envoyer une alerte à l'administrateur à chaque fois qu'une campagne approche de son expiration";
$GLOBALS['strWarnClient'] = "Envoyer une alerte à l'annonceur à chaque fois qu'une campagne approche de son expiration";
$GLOBALS['strWarnAgency'] = "Envoyer une alerte à l'agence à chaque fois qu'une campagne approche de son expiration";

// UI Settings
$GLOBALS['strGuiSettings'] = "Paramètres de l'interface utilisateur";
$GLOBALS['strGeneralSettings'] = "Paramètres généraux";
$GLOBALS['strAppName'] = "Nom de l'application";
$GLOBALS['strMyHeader'] = "Emplacement du fichier d'en-tête";
$GLOBALS['strMyFooter'] = "Emplacement du fichier de pied de page";
$GLOBALS['strDefaultTrackerStatus'] = "État par défaut du suiveur";
$GLOBALS['strDefaultTrackerType'] = "Type par défaut du suiveur";
$GLOBALS['strSSLSettings'] = "Paramètres SSL";
$GLOBALS['requireSSL'] = "Forcer l'accès SSL pour l'interface utilisateur";
$GLOBALS['sslPort'] = "Port SSL utilisé par le serveur web";
$GLOBALS['strDashboardSettings'] = "Paramètres du tableau de bord";
$GLOBALS['strMyLogo'] = "Nom du fichier du logo personnalisé";
$GLOBALS['strGuiHeaderForegroundColor'] = "Couleur du premier plan de l'en-tête";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Couleur de l'arrière-plan de l'en-tête";
$GLOBALS['strGuiActiveTabColor'] = "Couleur de l'onglet actif";
$GLOBALS['strGuiHeaderTextColor'] = "Couleur du texte dans l'en-tête";
$GLOBALS['strGzipContentCompression'] = "Utiliser la compression de contenu GZIP";

// Regenerate Platfor Hash script

// Plugin Settings
