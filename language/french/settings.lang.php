<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Installer translation strings
$GLOBALS['strInstall']				= "Installer";
$GLOBALS['strChooseInstallLanguage']	= "Choisissez la langue pour la procédure d'installation";
$GLOBALS['strLanguageSelection']		= "Sélection de la langue";
$GLOBALS['strDatabaseSettings']		= "Paramètres de la base de données";
$GLOBALS['strAdminSettings']			= "Paramètres de l'administrateur";
$GLOBALS['strAdvancedSettings']		= "Paramètres avancés";
$GLOBALS['strOtherSettings']			= "Autres paramètres";

$GLOBALS['strWarning']				= "Alerte";
$GLOBALS['strFatalError']			= "Une erreur fatale est survenue";
$GLOBALS['strAlreadyInstalled']		= "phpAdsNew est déjà installé sur ce système. Si vous souhaitez le configurer, allez à <a href='settings-index.php'>l'interface de paramétrage</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Impossible de se connecter à la base de données, veuillez vérifier les paramètres que vous avez entrés";
$GLOBALS['strCreateTableTestFailed']	= "L'utilisateur que vous avez spécifié n'a pas la permission de créer ou de mettre à jour la structure de la base de données. Veuillez contacter l'administrateur de la base.";
$GLOBALS['strUpdateTableTestFailed']	= "L'utilisateur que vous avez spécifié n'a pas la permission de mettre à jour la structure de la base de données. Veuillez contacter l'administrateur de la base.";
$GLOBALS['strTablePrefixInvalid']		= "Le préfixe des tables contient des caractères invalides";
$GLOBALS['strTableInUse']			= "La base de données que vous avez spécifiée est déjà utilisée pour phpAdsNew. Veuillez utiliser un préfixe de table différent, ou lire le manuel pour les instructions de mise à jour.";
$GLOBALS['strMayNotFunction']			= "Avant de continuer, merci de corriger ce problème potentiel::";
$GLOBALS['strIgnoreWarnings']			= "Ignorer les avertissement";
$GLOBALS['strWarningPHPversion']		= "phpAdsNew requiert  PHP 3.0.8 (ou plus) pour fonctionner correctement. Vous utilisez actuellement {php_version}.";
$GLOBALS['strWarningRegisterGlobals']	= "La variable de configuration globale PHP <i>register_globals</i> doit être à 'on'.";
$GLOBALS['strWarningMagicQuotesGPC']	= "La variable de configuration globale PHP <i>magic_quotes_gpc</i> doit être à 'on'.";
$GLOBALS['strWarningMagicQuotesRuntime']  = "La variable de configuration globale PHP <i>magic_quotes_runtime</i> doit être à 'off'.";
$GLOBALS['strConfigLockedDetected']		= "phpAdsNew a détecté que votre fichier <b>config.inc.php</b> n'est pas inscriptible par le serveur.<br> Vous ne pouvez pas continuez tant que vous ne changerez pas les permissions d'écriture sur ce fichier. <br>Veuillez lire la documentation fournie si vous ne savez pas comment le faire.";
$GLOBALS['strCantUpdateDB']  			= "Il n'est actuellement pas possible de mettre à jour la base de données. Si vous décidez de continuer, toutes les bannières existantes, les statistiques, et les annonceures seront supprimés.";
$GLOBALS['strTableNames']			= "Nom de la base";
$GLOBALS['strTablesPrefix']			= "Préfixe des noms des tables";
$GLOBALS['strTablesType']			= "Type de table";

$GLOBALS['strInstallWelcome']			= "Bienvenue sur phpAdsNew";
$GLOBALS['strInstallMessage']			= "Avant de pouvoir utiliser phpAdsNew, il est nécessaire de le configurer et la base de données doit être crée. Cliquez sur <b>Continuer</b> pour poursuivre.";
$GLOBALS['strInstallSuccess']			= "<b>L'installation de phpAdsNew est maintenant complète.</b><br><br>Afin que phpAdsNew fonctionne correctement, vous devez aussi faire en sorte que le fichier de
										   maintenance est exécuté chaque heure. Vous trouverez plus d'informations à ce sujet dans la documentation.
										   <br><br>Cliquez sur <b>Continuer</b> pour aller à la page de configuration, où vous pourrez
										   paramétrer un peu plus phpAdsNew. Veuillez à ne pas oublier de protéger en écriture config.inc.php lorsque vous aurez fini, afin de refermer des failles potentielles de sécurité.";
$GLOBALS['strUpdateSuccess']			= "<b>La mise à niveau de phpAdsNew est réussie.</b><br><br>Afin que phpAdsNew fonctionne correctement, vous devez aussi faire en sorte que le fichier de
										   maintenance est exécuté chaque heure (précédemment c'était chaque jour). Vous trouverez plus d'informations à ce sujet dans la documentation.
										   <br><br>Cliquez sur <b>Continuer</b> pour aller à la page de configuration, où vous pourrez
										   paramétrer un peu plus phpAdsNew. Veuillez à ne pas oublier de protéger en écriture config.inc.php lorsque vous aurez fini, afin de refermer des failles potentielles de sécurité.";
$GLOBALS['strInstallNotSuccessful']		= "<b>L'installation de phpAdsNew a échouée</b><br><br>Certaines partie du processus d'installation n'ont pas pu être réalisées.
										   Il est possible que ces problèmes ne soient que temporaires; dans ce cas vous pouvez simplement cliquer sur <b>Continuer</b> et retourner
										   à la première étape du processus d'installation. Si vous voulez en savoir plus sur la signification du message d'erreur ci-dessous, et comment résoudre le problème,
										   veuillez consulter la documentation fournie.";
$GLOBALS['strErrorOccured']			= "L'erreur suivante est survenue:";
$GLOBALS['strErrorInstallDatabase']		= "La structure de la base de données n'a pas pu être crée.";
$GLOBALS['strErrorInstallConfig']		= "Le fichier de configuration, ou la base de données n'a pas pu être mis à jour.";
$GLOBALS['strErrorInstallDbConnect']	= "Il n'a pas été possible d'ouvrir une connexion avec la base données.";

$GLOBALS['strUrlPrefix']			= "Préfixe d'Url";

$GLOBALS['strProceed']				= "Continuer &gt;";
$GLOBALS['strRepeatPassword']			= "Répéter le mot de passe";
$GLOBALS['strNotSamePasswords']		= "Les mots de passe ne correspondent pas";
$GLOBALS['strInvalidUserPwd']			= "Nom d'utilisateur, ou mot de passe invalide";

$GLOBALS['strUpgrade']				= "Mise à niveau";
$GLOBALS['strSystemUpToDate']			= "Votre système est déjà à jour, et aucune mise à niveau n'est nécessaire pour le moment. <br>Cliquez sur <b>Continuer</b> pour aller à la page d'accueil.";
$GLOBALS['strSystemNeedsUpgrade']		= "La structure de la base de donnée, et le fichier de configuration ont besoin d'être mis à jour afin de faire marcher phpAdsNew. Cliquez sur <b>Continuer</b> afin de commencer le processus de mise à niveau. <br>Merci d'être patient, la mise à jour pouvant prendre quelques minutes.";
$GLOBALS['strSystemUpgradeBusy']		= "Mise à jour du système en cours, merci de patienter...";
$GLOBALS['strSystemRebuildingCache']	= "Reconstruction du cache, merci de patienter...";
$GLOBALS['strServiceUnavalable']		= "Le service est temporairement indisponible. Mise à jour du système en cours";

$GLOBALS['strConfigNotWritable']		= "Votre fichier config.inc.php n'est pas inscriptible";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "Choisissez une section";
$GLOBALS['strDayFullNames'] 			= array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
$GLOBALS['strEditConfigNotPossible']	= "Il n'est pas possible d'éditer ces réglages, car le fichier de configuration est bloqué pour des raisons de sécurité.<br> ".
										  "Si vous voulez faire des changements, vous devez d'abord débloquer le fichier config.inc.php.";
$GLOBALS['strEditConfigPossible']		= "Il est possible d'éditer tous les paramètres, car le fichier de configuration n'est pas bloqué, mais cela peut entraîner des failles de sécurité.<br> ".
										  "Si vous voulez sécuriser votre système, vous devez bloquer le fichier config.inc.php.";



// Database
$GLOBALS['strDatabaseSettings']		= "Paramètres de la base de données";
$GLOBALS['strDatabaseServer']			= "Serveur base de données";
$GLOBALS['strDbHost']				= "Adresse serveur";
$GLOBALS['strDbUser']				= "Nom d'utilisateur";
$GLOBALS['strDbPassword']			= "Mot de passe";
$GLOBALS['strDbName']				= "Nom de la base";

$GLOBALS['strDatabaseOptimalisations']	= "Options de la base de données";
$GLOBALS['strPersistentConnections']	= "Utiliser des connexions persistantes";
$GLOBALS['strInsertDelayed']			= "Utiliser des 'INSERT' retardés";
$GLOBALS['strCompatibilityMode']		= "Utiliser le mode de compatibilité base de données";
$GLOBALS['strCantConnectToDb']		= "Impossible de se connecter à la base de données";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']	= "Paramètres d'invocation et de distribution";

$GLOBALS['strAllowedInvocationTypes']	= "Types d'invocation autorisés";
$GLOBALS['strAllowRemoteInvocation']	= "Autoriser l'invocation distante";
$GLOBALS['strAllowRemoteJavascript']	= "Autoriser l'invocation distante avec Javascript";
$GLOBALS['strAllowRemoteFrames']		= "Autoriser l'invocation distante avec Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "Autoriser l'invocation distante avec XML-RPC";
$GLOBALS['strAllowLocalmode']			= "Autoriser le mode local";
$GLOBALS['strAllowInterstitial']		= "Autoriser les interstitiels";
$GLOBALS['strAllowPopups']			= "Autoriser les popups";

$GLOBALS['strKeywordRetrieval']		= "Sélection des bannières par mots clés";
$GLOBALS['strBannerRetrieval']		= "Méthode de sélection des bannières";
$GLOBALS['strRetrieveRandom']			= "Sélection aléatoire des bannières (par défaut)";
$GLOBALS['strRetrieveNormalSeq']		= "Sélection séquentielle normale des bannières";
$GLOBALS['strWeightSeq']			= "Sélection basée sur le poids des bannières";
$GLOBALS['strFullSeq']				= "Sélection séquentielle totale des bannières";
$GLOBALS['strUseConditionalKeys']		= "Utiliser les mots clés conditionnels";
$GLOBALS['strUseMultipleKeys']		= "Utiliser des mots clés multiples";
$GLOBALS['strUseAcl']				= "Utiliser la limitation d'affichage";

$GLOBALS['strZonesSettings']			= "Récupération des zones";
$GLOBALS['strZoneCache']			= "Cacher les zones; cela peut accélérer phpAdsNew lorsque l'on utilise les zones";
$GLOBALS['strZoneCacheLimit']			= "Délai entre les mises à jour du cache (en secondes)";
$GLOBALS['strZoneCacheLimitErr']		= "Le délai entre les mises à jour du cache DOIT être un entier positif";

$GLOBALS['strP3PSettings']			= "Politique de respect de la vie privée P3P";
$GLOBALS['strUseP3P']				= "Utiliser la politique P3P";
$GLOBALS['strP3PCompactPolicy']		= "Politique compacte P3P";
$GLOBALS['strP3PPolicyLocation']		= "Emplacement de la politique P3P";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Paramètres des bannières";

$GLOBALS['strAllowedBannerTypes']		= "Types de bannières autorisés";
$GLOBALS['strTypeSqlAllow']			= "Autoriser les bannières locales (SQL)";
$GLOBALS['strTypeWebAllow']			= "Autoriser les bannières locales (Serveur Web)";
$GLOBALS['strTypeUrlAllow']			= "Autoriser les bannières externes";
$GLOBALS['strTypeHtmlAllow']			= "Autoriser les bannières HTML";

$GLOBALS['strTypeWebSettings']		= "Configuration des bannières locales (Serveur Web)";
$GLOBALS['strTypeWebMode']			= "Méthode de stockage";
$GLOBALS['strTypeWebModeLocal']		= "Répertoire local";
$GLOBALS['strTypeWebModeFtp']			= "Serveur FTP externe";
$GLOBALS['strTypeWebDir']			= "Répertoire local";
$GLOBALS['strTypeWebFtp']			= "Server Web de bannière en mode FTP";
$GLOBALS['strTypeWebUrl']			= "Url publique";
$GLOBALS['strTypeFTPHost']			= "Serveur FTP";
$GLOBALS['strTypeFTPDirectory']		= "Répertoire sur le serveur";
$GLOBALS['strTypeFTPUsername']		= "Nom d'utilisateur";
$GLOBALS['strTypeFTPPassword']		= "Mot de passe";

$GLOBALS['strDefaultBanners']			= "Bannière par défaut";
$GLOBALS['strDefaultBannerUrl']		= "Url de l'image par défaut";
$GLOBALS['strDefaultBannerTarget']		= "Url de destination par défaut";

$GLOBALS['strTypeHtmlSettings']		= "Options des bannières HTML";
$GLOBALS['strTypeHtmlAuto']			= "Automatiquement modifier les bannière HTML, afin de forcer le comptage des clicks";
$GLOBALS['strTypeHtmlPhp']			= "Autoriser l'exécution des expressions PHP dans les bannières HTML";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Paramètres des statistiques";

$GLOBALS['strStatisticsFormat']		= "Format des statistiques";
$GLOBALS['strLogBeacon']			= "Utiliser des balises invisibles pour compter les affichages (plus précis, recommandé)";
$GLOBALS['strCompactStats']			= "Utiliser des statistiques compactes";
$GLOBALS['strLogAdviews']			= "Journaliser les affichages ";
$GLOBALS['strBlockAdviews']			= "Protection contre les entrées multiples dans le journal (sec.)";
$GLOBALS['strLogAdclicks']			= "Journaliser les clics";
$GLOBALS['strBlockAdclicks']			= "Protection contre les entrées multiples dans le journal (sec.)";

$GLOBALS['strEmailWarnings']			= "Avertissements par Email";
$GLOBALS['strAdminEmailHeaders']		= "En-têtes Mail utilisées lors de l'envoi d'un avertissement";
$GLOBALS['strWarnLimit']			= "Limite d'avertissement";
$GLOBALS['strWarnLimitErr']			= "La limite d'avertissement DOIT être un entier positif";
$GLOBALS['strWarnAdmin']			= "Avertir l'administrateur";
$GLOBALS['strWarnClient']			= "Avertir l'annonceur";
$GLOBALS['strQmailPatch']			= "Utiliser le patch qmail";

$GLOBALS['strRemoteHosts']			= "Machines distantes";
$GLOBALS['strIgnoreHosts']			= "Machines à ignorer";
$GLOBALS['strReverseLookup']			= "Requête DNS inversée";
$GLOBALS['strProxyLookup']			= "Résoudre les adresses des proxys";



// Administrator settings
$GLOBALS['strAdministratorSettings']	= "Paramètres administrateur";

$GLOBALS['strLoginCredentials']		= "Accréditations de connexion";
$GLOBALS['strAdminUsername']			= "Nom d'utilisateur de l'administrateur";
$GLOBALS['strOldPassword']			= "Ancien mot de passe";
$GLOBALS['strNewPassword']			= "Nouveau mot de passe";
$GLOBALS['strInvalidUsername']		= "Nom d'utilisateur invalide";
$GLOBALS['strInvalidPassword']		= "Mot de passe invalide";

$GLOBALS['strBasicInformation']		= "Informations de base";
$GLOBALS['strAdminFullName']			= "Nom complet de l'administrateur";
$GLOBALS['strAdminEmail']			= "Adresse mail de l'administrateur";
$GLOBALS['strCompanyName']			= "Nom de l'organisation";

$GLOBALS['strAdminCheckUpdates']		= "Vérifier l'existence de mises à jour";
$GLOBALS['strAdminCheckEveryLogin']		= "A chaque connexion";
$GLOBALS['strAdminCheckDaily']		= "Chaque jour";
$GLOBALS['strAdminCheckWeekly']		= "Chaque semaine";
$GLOBALS['strAdminCheckMonthly']		= "Chaque mois";
$GLOBALS['strAdminCheckNever']		= "Jamais";


$GLOBALS['strAdminNovice']			= "Les actions de suppression par l'administrateur nécessitent des confirmation par sécurité";
$GLOBALS['strUserlogEmail']			= "Journaliser tous les messages mail sortants";
$GLOBALS['strUserlogPriority']		= "Journaliser chaque heure les calculs de priorité";


// User interface settings
$GLOBALS['strGuiSettings']			= "Configuration de l'interface utilisateur";

$GLOBALS['strGeneralSettings']		= "Paramètres généraux";
$GLOBALS['strAppName']				= "Nom de l'application";
$GLOBALS['strMyHeader']				= "Mon en-tête";
$GLOBALS['strMyFooter']				= "Mon pied de page";
$GLOBALS['strGzipContentCompression']	= "Utiliser la compression GZIP du contenu";

$GLOBALS['strClientInterface']		= "Interface de l'annonceur";
$GLOBALS['strClientWelcomeEnabled']		= "Montrer à l'annonceur un message de bienvenue";
$GLOBALS['strClientWelcomeText']		= "Message de bienvenue<br>(HTML autorisé)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Valeurs par défaut de l'interface";

$GLOBALS['strInventory']			= "Administration";
$GLOBALS['strShowCampaignInfo']		= "Montrer les infos supplémentaires de la campagne sur la page <i>Aperçu de la campagne</i>";
$GLOBALS['strShowBannerInfo']			= "Montrer les infos supplémentaires de la bannière sur la page <i>Aperçu de la bannière</i>";
$GLOBALS['strShowCampaignPreview']		= "Montrer un aperçu de toutes les bannières sur la page <i>Aperçu des bannières</i>";
$GLOBALS['strShowBannerHTML']			= "Montrer la bannière actuelle, plutôt que du code HTML brut pour l'aperçu des bannières HTML";
$GLOBALS['strShowBannerPreview']		= "Montrer l'aperçu de la bannière au sommet des pages qui concernent les bannières";
$GLOBALS['strHideInactive']			= "Cacher les éléments inactifs dans toutes les pages d'aperçus";

$GLOBALS['strStatisticsDefaults'] 		= "Statistiques";
$GLOBALS['strBeginOfWeek']			= "Premier jour de la semaine";
$GLOBALS['strPercentageDecimals']		= "Nombre de décimales des pourcentages";

$GLOBALS['strWeightDefaults']			= "Poids par défaut";
$GLOBALS['strDefaultBannerWeight']		= "Poids par défaut des bannières";
$GLOBALS['strDefaultCampaignWeight']	= "Poids par défaut des campagnes";
$GLOBALS['strDefaultBannerWErr']		= "Le poids par défaut des bannières DOIT être un entier positif";
$GLOBALS['strDefaultCampaignWErr']		= "Le poids par défaut des campagnes DOIT être un entier positif";



// Not used at the moment
$GLOBALS['strTableBorderColor']		= "Couleur de la bordure de la table";
$GLOBALS['strTableBackColor']			= "Couleur d'arrière-plan de la table";
$GLOBALS['strTableBackColorAlt']		= "Couleur d'arrière-plan de la table (Alternatif)";
$GLOBALS['strMainBackColor']			= "Couleur principale d'arrière-plan";
$GLOBALS['strOverrideGD']			= "Outrepasser le format d'Image GD";
$GLOBALS['strTimeZone']				= "Fuseau horaire";

?>