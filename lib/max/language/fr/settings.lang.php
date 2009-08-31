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



// Installer translation strings
$GLOBALS['strInstall']				= 'Installer';
$GLOBALS['strChooseInstallLanguage']		= 'Choisissez la langue pour la procédure d\'installation';
$GLOBALS['strLanguageSelection']		= 'Sélection de la langue';
$GLOBALS['strDatabaseSettings']			= 'Paramètres de la base de données';
$GLOBALS['strAdminSettings']			= 'Paramètres de l\'administrateur';
$GLOBALS['strAdvancedSettings']			= 'Paramètres avancés';
$GLOBALS['strOtherSettings']			= 'Autres paramètres';

$GLOBALS['strWarning']				= 'Attention';
$GLOBALS['strFatalError']			= 'Une erreur fatale est survenue';
$GLOBALS['strUpdateError']			= 'Une erreur est survenue en tentant de mettre à jour '. MAX_PRODUCT_NAME;
$GLOBALS['strUpdateDatabaseError']		= 'Une erreur non identifiée étant survenue, la structure de la base de données n\'a pas pu être mise à jour. Il est recommandé de cliquer sur <b>Retenter la mise à jour</b>, afin d\'essayer de corriger ces problèmes potentiels; néanmoins, si vous êtes sur que ces erreurs ne vont pas affecter la bonne marche de '.MAX_PRODUCT_NAME.', vous pouvez cliquer sur <b>Ignorer les erreurs</b> et continuer. Ignorer ces erreurs peut entrainer de graves problèmes !';
$GLOBALS['strAlreadyInstalled']			= MAX_PRODUCT_NAME.' est déjà installé sur ce système. Si vous souhaitez le configurer :<a href=\'settings-index.php\'>Paramètres de '.MAX_PRODUCT_NAME.'</a>.';
$GLOBALS['strCouldNotConnectToDB']		= MAX_PRODUCT_NAME.' ne peut se connecter à la base de donnée. Veuillez vérifier les paramètres que vous avez entrés.';
$GLOBALS['strCreateTableTestFailed']		= 'L\'utilisateur que vous avez spécifié n\'a pas la permission de créer ou de mettre à jour la structure de la base de données. Veuillez contacter l\'administrateur de la base.';
$GLOBALS['strUpdateTableTestFailed']		= 'L\'utilisateur que vous avez spécifié n\'a pas la permission de mettre à jour la structure de la base de données. Veuillez contacter l\'administrateur de la base.';
$GLOBALS['strTablePrefixInvalid']		= 'Le préfixe des tables contient des caractères invalides';
$GLOBALS['strTableInUse']			= 'La base de données que vous avez spécifiée est déjà utilisée pour '.MAX_PRODUCT_NAME.'. Veuillez utiliser un préfixe de table différent, ou lire le manuel pour les instructions de mise à jour.';
$GLOBALS['strTableWrongType']			= 'Le type de table que vous avez sélectionné n\'est pas supporté par votre installation de '.$phpAds_dbmsname;
$GLOBALS['strMayNotFunction']			= 'Avant de continuer, vous devriez corriger ce problème potentiel :';
$GLOBALS['strFixProblemsBefore']		= 'Le(s) chose(s) suivante(s) doivent être corrigée(s) avant que vous ne puissiez installer '.MAX_PRODUCT_NAME.'. Si vous avez des questions à propos de ce message d\'erreur, lisez le <i>Guide de l\'administrateur</i> (Administrator guide, en anglais), qui est fourni avec l\'archive que vous avez téléchargée.';
$GLOBALS['strFixProblemsAfter']			= 'Si vous ne pouvez pas corriger les problèmes ci-dessus, veuillez contacter l\'adminitrateur du serveur sur lequel vous tentez d\'installer '.MAX_PRODUCT_NAME.'. Il devrait être capable de vous aider.';
$GLOBALS['strIgnoreWarnings']			= 'Ignorer les avertissement';
$GLOBALS['strWarningPHPversion']		= MAX_PRODUCT_NAME.' requiert  PHP 4.0 (ou plus) pour fonctionner correctement. Vous utilisez actuellement {php_version}.';
$GLOBALS['strWarningDBavailable']               = 'La version de PHP que vous utilisez n\'a pas le support nécessaire pour se connecter à une base de données '.$phpAds_dbmsname.'. Vous devez activer l\'extension '.$phpAds_dbmsname.' de PHP avant de pouvoir continuer.';
$GLOBALS['strWarningRegisterGlobals']		= 'La variable de configuration globale PHP <i>register_globals</i> doit être activée.';
$GLOBALS['strWarningMagicQuotesGPC']		= 'La variable de configuration globale PHP <i>magic_quotes_gpc</i> doit être activée.';
$GLOBALS['strWarningMagicQuotesRuntime']  	= 'La variable de configuration globale PHP <i>magic_quotes_runtime</i> doit être désactivée.';
$GLOBALS['strWarningFileUploads']		= 'La variable de configuration globale PHP <i>file_uploads</i> doit être activée.';
$GLOBALS['strWarningTrackVars']			= 'La variable de configuration globale PHP <i>track_vars</i> doit être activée.';
$GLOBALS['strWarningPREG']			= 'La version de PHP que vous utilisez ne dispose pas des PCRE (Expression rationnelles compatibles Perl). Vous devez activer l\'extension PCRE avant de pouvoir continuer.';
$GLOBALS['strConfigLockedDetected']		= MAX_PRODUCT_NAME.' ne peut pas écrire sur le fichier <b>config.inc.php</b>.<br> Vous devez accorder avoir les privilèges d\'écriture sur ce fichier. <br>Veuillez lire la documentation fournie pour plus d\'informations.';
$GLOBALS['strCantUpdateDB']  			= 'Il n\'est pas possible de mettre à jour la base de données. Si vous décidez de continuer, toutes les bannières existantes, les statistiques, et les annonceurs seront perdus.';
$GLOBALS['strIgnoreErrors']			= 'Ignorer les erreurs';
$GLOBALS['strRetryUpdate']			= 'Retenter la mise à jour';
$GLOBALS['strTableNames']			= 'Nom de la base';
$GLOBALS['strTablesPrefix']			= 'Préfixe des noms des tables';
$GLOBALS['strTablesType']			= 'Type de tables';

$GLOBALS['strInstallWelcome']			= 'Bienvenue sur '.MAX_PRODUCT_NAME;
$GLOBALS['strInstallMessage']			= 'Avant de pouvoir utiliser '.MAX_PRODUCT_NAME.', il est nécessaire de le configurer, et la base de données doit être crée. Cliquez sur <b>Continuer</b> pour poursuivre.';
$GLOBALS['strInstallSuccess']			= 'Cliquez sur \'Continuer\' vous connectera à votre serveur publicitaire.	<p><strong>Et ensuite ?</strong></p>	<div class=\'psub\'>	  <p><b>Inscrivez-vous aux mises à jour produit</b><br>	    <a href=\'\". OX_PRODUCT_DOCSURL .\"/wizard/join\' target=\'_blank\'>Rejoignez la liste d\'envoi de \". MAX_PRODUCT_NAME .\"</a> pour des mises à jour produit, des alertes sécurité et des annonces sur les nouveaux produits.	  </p>	  <p><b>Distribuez votre première campagne</b><br>	    Utilisez notre <a href=\'\". OX_PRODUCT_DOCSURL .\"/wizard/qsg-firstcampaign\' target=\'_blank\'>guide de démarrage rapide pour commencer à distribuer votre première campagne publicitaire</a>.	  </p>	</div>	<p><strong>Étapes d\'installation facultatives</strong></p>	<div class=\'psub\'>	  <p><b>Verrouillez vos fichiers de configuration</b><br>	    Il s\'agit d\'une bonne mesure de sécurité supplémentaire pour empêcher que les paramètres de configuration de votre serveur publicitaire soient modifiés.  <a href=\'\". OX_PRODUCT_DOCSURL .\"/wizard/lock-config\' target=\'_blank\'>En savoir plus</a>.	  </p>	  <p><b>Paramétrez une tâche de maintenance régulière</b><br>	    un script de maintenance est recommandé afin d\'assurer des rapports ponctuels et la meilleure performance de distribution publicitaire possible.  <a href=\'\". OX_PRODUCT_DOCSURL .\"/wizard/setup-cron\' target=\'_blank\'>En savoir plus</a>	  </p>	  <p><b>Vérifez les paramètres de configuration de votre système</b><br>	    Avant de commencer à utiliser \". MAX_PRODUCT_NAME .\" nous vous recommandons de vérifier vos paramètres dans l\'onglet \'Paramètres\'.	  </p>	</div>';

$GLOBALS['strUpdateSuccess']			= '<b>La mise à niveau de '.MAX_PRODUCT_NAME.' a réussie.</b><br><br>Afin que '.MAX_PRODUCT_NAME.' fonctionne correctement, '
						 .'vous devez aussi faire en sorte que le fichier de maintenance soit exécuté chaque heure (précédemment c\'était chaque jour). '
						 .'Vous trouverez plus d\'informations sur ce sujet dans la documentation.<br><br>Cliquez sur <b>Continuer</b> pour accéder '
						 .'à l\'interfaçe de configuration, d\'où vous pourrez finir de paramétrer '.MAX_PRODUCT_NAME.'. Veuillez à ne pas oublier '
						 .'de protéger en écriture le fichier <i>config.inc.php</i> lorsque vous aurez fini, afin de sécuriser '.MAX_PRODUCT_NAME.'.';
$GLOBALS['strInstallNotSuccessful']		= '<b>L\'installation d\'\".'.MAX_PRODUCT_NAME.'.\" n\'a pas réussi</b><br /><br />Certaines parties du processus d\'installation n\'ont pu être complétées.
                                                Il est possible que ces problèmes soient seulement temporaires, dans ce cas vous pouvez simplement clique sur <b>Continuer</b>et retourner à la
                                                première étape du processus d\'installation. Si vous voulez en savoir plus concernant la signification du message d\'erreur ci-dessous, et comment le rédoudre,
                                                veuillez consulter la documentation fournie.';
$GLOBALS['strErrorOccured']			= 'L\'erreur suivante est survenue :';
$GLOBALS['strErrorInstallDatabase']		= 'La structure de la base de données n\'a pas pu être crée.';
$GLOBALS['strErrorInstallConfig']		= 'Le fichier de configuration, ou la base de données n\'a pas pu être mis à jour.';
$GLOBALS['strErrorInstallDbConnect']		= MAX_PRODUCT_NAME.' n\'a pas réussi à se connecter à la base de données '.$phpAds_dbmsname.'.';

$GLOBALS['strUrlPrefix']			= 'Préfixe d\'Url';

$GLOBALS['strProceed']				= 'Poursuivre >';
$GLOBALS['strInvalidUserPwd']			= 'Nom d\'utilisateur, ou mot de passe invalide';

$GLOBALS['strUpgrade']				= 'Mise à niveau';
$GLOBALS['strSystemUpToDate']			= 'Votre système est déjà à jour, et aucune mise à niveau n\'est nécessaire pour le moment. <br>Cliquez sur <b>Continuer</b> pour accéder à la page d\'accueil.';
$GLOBALS['strSystemNeedsUpgrade']               = 'La structure de la base de données et le fichier de configuration doivent être mis à jour pour fonctionner correctement. Cliquez sur <b>Continuer</b> pour commencer le processus de mise à jour. <br><br>Suivant la version à laquelle vous êtes, et la quantité de statistiques présentes dans la base, cette opération peut provoquer une grande charge sur le serveur SQL. Merci d\'être patient. Cette mise à jour peut prendre jusqu\'à plusieurs minutes.';
$GLOBALS['strSystemUpgradeBusy']		= 'Mise à jour du système en cours, merci de patienter...';
$GLOBALS['strSystemRebuildingCache']		= 'Reconstruction du cache, merci de patienter...';
$GLOBALS['strServiceUnavalable']		= 'Le service est temporairement indisponible. Mise à jour du système en cours.';

$GLOBALS['strConfigNotWritable']		= MAX_PRODUCT_NAME.' ne peut écrire dans le fichier config.inc.php';





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= 'Choisir la section';
$GLOBALS['strDayFullNames'][0] = "Dimanche";
$GLOBALS['strDayFullNames'][1] = "Lundi";
$GLOBALS['strDayFullNames'][2] = "Mardi";
$GLOBALS['strDayFullNames'][3] = "Mercredi";
$GLOBALS['strDayFullNames'][4] = "Jeudi";
$GLOBALS['strDayFullNames'][5] = "Vendredi";
$GLOBALS['strDayFullNames'][6] = "Samedi";

$GLOBALS['strEditConfigNotPossible']		= 'Il est impossible d\'éditer tous les paramètres car le fichier de configuration est verrouillé pour des raisons de sécurité. Si vous voulez effectuer des modificatons, vous devrez d\'abord déverrouiller le fichier de configuration de cette installation.';
$GLOBALS['strEditConfigPossible']		= 'Il est possible d\'éditer tous les paramètres car le fichier de configuration est déverrouillé, mais cela pourrait causer des problèmes de sécurité. Si vous voulez sécuriser votre système, vous devrez verrouiller le fichier de configuration de cette installation.';



// Database
$GLOBALS['strDatabaseSettings']			= 'Base de données '.$phpAds_dbmsname;
$GLOBALS['strDatabaseServer']			= 'Paramètres généraux de la base de données';
$GLOBALS['strDbLocal']				= 'Utiliser la connexion au socket local'; // Pg only
$GLOBALS['strDbHost']				= 'Serveur de la base de données';
$GLOBALS['strDbPort']				= 'Port de la base de données';
$GLOBALS['strDbUser']				= 'Identifiant de la base de données';
$GLOBALS['strDbPassword']			= 'Mot de passe de la base de données';
$GLOBALS['strDbName']				= 'Nom de la base de données';

$GLOBALS['strDatabaseOptimalisations']		= 'Paramètres d\'optimisation de la base de données';
$GLOBALS['strPersistentConnections']		= 'Utiliser les connexions persistantes';
$GLOBALS['strInsertDelayed']			= 'Utiliser des \'INSERT\' retardés';
$GLOBALS['strCompatibilityMode']		= 'Utiliser le mode de compatibilité base de données';
$GLOBALS['strCantConnectToDb']			= 'Connexion à la base de données impossible';



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= 'Paramètres d\'invocation';

$GLOBALS['strAllowedInvocationTypes']		= 'Types d\'invocation autorisés';
$GLOBALS['strAllowRemoteInvocation']		= 'Autoriser l\'invocation distante';
$GLOBALS['strAllowRemoteJavascript']		= 'Autoriser l\'invocation distante avec Javascript';
$GLOBALS['strAllowRemoteFrames']		= 'Autoriser l\'invocation distante avec Frames';
$GLOBALS['strAllowRemoteXMLRPC']		= 'Autoriser l\'invocation distante avec XML-RPC';
$GLOBALS['strAllowLocalmode']			= 'Autoriser le mode local';
$GLOBALS['strAllowInterstitial']		= 'Autoriser les interstitiels';
$GLOBALS['strAllowPopups']			= 'Autoriser les popups';

$GLOBALS['strUseAcl']				= 'Evaluer les limitations lors de la distribution';

$GLOBALS['strDeliverySettings']                 = 'Paramètres de distribution';
$GLOBALS['strCacheType']			= 'Type de cache de distribution';
$GLOBALS['strCacheFiles']			= 'Fichier';
$GLOBALS['strCacheDatabase']                    = 'Base de données (SQL)';
$GLOBALS['strCacheShmop']			= 'Mémoire partagée (shmop)';
$GLOBALS['strCacheSysvshm']			= 'Mémoire partagée (sysvshm)';
$GLOBALS['strExperimental']			= 'Experimental';
$GLOBALS['strKeywordRetrieval']			= 'Autoriser la sélection des bannières par mots clés';
$GLOBALS['strBannerRetrieval']			= 'Méthode de sélection des bannières';
$GLOBALS['strRetrieveRandom']			= 'Sélection aléatoire (par défaut)';
$GLOBALS['strRetrieveNormalSeq']		= 'Sélection séquentielle';
$GLOBALS['strWeightSeq']			= 'Sélection séquentielle basée sur le poids des bannières';
$GLOBALS['strFullSeq']				= 'Sélection séquentielle totale';
$GLOBALS['strUseConditionalKeys']		= 'Autoriser l\'utilisation d\'opérateurs logiques lors de la sélection directe';
$GLOBALS['strUseMultipleKeys']			= 'Autoriser les mots clés multiples lors de la sélection directe';

$GLOBALS['strZonesSettings']			= 'Récupération des zones';
$GLOBALS['strZoneCache']			= 'Cacher les zones; cela peut accélérer '.MAX_PRODUCT_NAME.' lorsque l\'on utilise les zones';
$GLOBALS['strZoneCacheLimit']			= 'Délai entre les mises à jour du cache (en secondes)';
$GLOBALS['strZoneCacheLimitErr']		= 'Erreur: le délai entre les mises à jour du cache doit être un entier positif.';

$GLOBALS['strP3PSettings']			= 'Politique de vie privée P3P';
$GLOBALS['strUseP3P']				= 'Utiliser les politiques P3P';
$GLOBALS['strP3PCompactPolicy']			= 'Politique P3P réduite';
$GLOBALS['strP3PPolicyLocation']		= 'Emplacement de la politique P3P';



// Banner Settings
$GLOBALS['strBannerSettings']			= 'Paramètres des bannières';

$GLOBALS['strAllowedBannerTypes']		= 'Types de bannières autorisés';
$GLOBALS['strTypeSqlAllow']			= 'Autoriser les bannières SQL';
$GLOBALS['strTypeWebAllow']			= 'Autoriser les bannières locales';
$GLOBALS['strTypeUrlAllow']			= 'Autoriser les bannières externes';
$GLOBALS['strTypeHtmlAllow']			= 'Autoriser les bannières HTML';
$GLOBALS['strTypeTxtAllow']			= 'Autoriser les publicités textuelles';

$GLOBALS['strTypeWebSettings']			= 'Paramètres de stockage des bannières locales sur le serveur web';
$GLOBALS['strTypeWebMode']			= 'Méthode de stockage';
$GLOBALS['strTypeWebModeLocal']			= 'Répertoire local';
$GLOBALS['strTypeWebModeFtp']			= 'Serveur FTP externe';
$GLOBALS['strTypeWebDir']			= 'Répertoire local';
$GLOBALS['strTypeWebFtp']			= 'Server Web de bannière en mode FTP';
$GLOBALS['strTypeWebUrl']			= 'Url publique';
$GLOBALS['strTypeFTPHost']			= 'Hôte FTP';
$GLOBALS['strTypeFTPDirectory']			= 'Répertoire de l\'hôte';
$GLOBALS['strTypeFTPUsername']			= 'Connexion';
$GLOBALS['strTypeFTPPassword']			= 'Mot de passe';
$GLOBALS['strTypeFTPErrorDir']			= 'Le répertoire de l\'hôte FTP n\'existe pas';
$GLOBALS['strTypeFTPErrorConnect']		= 'Connexion au serveur FTP impossible, l\'identifiant ou le mot de passe est incorrect';
$GLOBALS['strTypeFTPErrorHost']			= 'L\'hôte FTP est incorrect';
$GLOBALS['strTypeDirError']			= 'Le répertoire local n\'est pas accessible en écriture par le serveur web';

$GLOBALS['strDefaultBanners']			= 'Bannières par défaut';
$GLOBALS['strDefaultBannerUrl']			= 'URL d\'image par défaut';
$GLOBALS['strDefaultBannerTarget']		= 'Url de destination par défaut';

$GLOBALS['strTypeHtmlSettings']			= 'Options des bannières HTML';
$GLOBALS['strTypeHtmlAuto']			= 'Modifier automatiquement les bannières HTML afin de forcer le suivi des clics';
$GLOBALS['strTypeHtmlPhp']			= 'Autoriser les expressions PHP à être exécutées depuis une bannière HTML';


// Host information and Geotargeting
$GLOBALS['strHostAndGeo']			= 'Hôtes, et géolocalisation';

$GLOBALS['strRemoteHost']			= 'Hôte';
$GLOBALS['strReverseLookup']			= 'Appliquer un reverse lookup sur les noms d\'hôtes des visiteurs quand il n\'est pas fourni';
$GLOBALS['strProxyLookup']			= 'Essayer de déterminer l\'IP réelle des visiteurs se trouvant derrière un serveur proxy';

$GLOBALS['strGeotargeting']			= 'Paramètres de géolocalisation';
$GLOBALS['strGeotrackingType']			= 'Type de base de données de géolocalisation';
$GLOBALS['strGeotrackingLocation']		= 'Emplacement de la base de données de géolocalisation';
$GLOBALS['strGeotrackingLocationError']		= 'La base de géolocalisation n\'a pas été trouvée à l\'emplacement spécifié';
$GLOBALS['strGeoStoreCookie']			= 'Stocker le résultat de la localisation géographique dans un cookie, et s\'y réfenrencer pas la suite.';


// Statistics Settings
$GLOBALS['strStatisticsSettings']		= 'Paramètres des statistiques & de la maintenance';

$GLOBALS['strStatisticsFormat']			= 'Format des statistiques';
$GLOBALS['strCompactStats']			= 'Type de statistiques';
$GLOBALS['strLogAdviews']			= 'Journaliser les affichages ';
$GLOBALS['strLogAdclicks']			= 'Journaliser les clics';
$GLOBALS['strLogSource']			= 'Journaliser le paramètre \'source\' spécifié lors de l\'invocation';
$GLOBALS['strGeoLogStats']			= 'Journaliser le pays d\'origine du visiteur';
$GLOBALS['strLogHostnameOrIP']			= 'Journaliser le nom de machine, ou l\'adresse IP du visiteur';
$GLOBALS['strLogIPOnly']			= 'Journaliser uniquement l\'adresse IP du visteur, même si le nom de sa machine est connu';
$GLOBALS['strLogIP']				= 'Journaliser l\'adresse IP du visiteur';
$GLOBALS['strLogBeacon']			= 'Utiliser des balises invisibles pour compter les affichages (plus précis, recommandé)';

$GLOBALS['strRemoteHosts']			= 'Hôtes';
$GLOBALS['strIgnoreHosts']			= 'Ne pas journaliser de statistiques pour les visiteurs utilisant l\'une des adresses IP ou l\'un des noms d\'hôtes spécifiés';
$GLOBALS['strBlockAdviews']			= 'Ne pas compter deux affichages d\'un même client en moins de :<br>(secondes)';
$GLOBALS['strBlockAdclicks']			= 'Ne pas compter deux clics d\'un même client en moins de :<br>(secondes)';


$GLOBALS['strEmailWarnings']			= 'Avertissements par e-mail';
$GLOBALS['strAdminEmailHeaders']		= 'Ajouter les en-têtes suivants à tous les e-mails envoyés par ". '.MAX_PRODUCT_NAME.' ."';
$GLOBALS['strWarnLimit']			= 'Envoyer un avertissement quand le nombre d\'impressions restantes est inférieur à celui spécifié ici';
$GLOBALS['strWarnLimitErr']			= 'La limite d\'avertissement doit être un entier positif';
$GLOBALS['strWarnAdmin']			= 'Envoyer une alerte à l\'administrateur à chaque fois qu\'une campagne approche de son expiration';
$GLOBALS['strWarnClient']			= 'Envoyer une alerte à l\'annonceur à chaque fois qu\'une campagne approche de son expiration';
$GLOBALS['strQmailPatch']			= 'Patch qmail';

$GLOBALS['strAutoCleanTables']			= 'Purger automatiquement la base de données';
$GLOBALS['strAutoCleanStats']			= 'Purger automatiquement les données statistiques';
$GLOBALS['strAutoCleanUserlog']			= 'Purger le journal utilisateur';
$GLOBALS['strAutoCleanStatsWeeks']		= 'Age maximal des statistiques <br>(en semaines, au minimum 3)';
$GLOBALS['strAutoCleanUserlogWeeks']		= 'Age maximal des journaux utilisateurs <br>(en semaines, au minimum 3)';
$GLOBALS['strAutoCleanErr']			= 'L\'âge maximal doit être d\'au moins de 3 semaines';
$GLOBALS['strAutoCleanVacuum']			= 'VACUUM ANALYZE (optimisation - nettoyage) des tables chaque nuit'; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= 'Paramètres de l\'administrateur';

$GLOBALS['strLoginCredentials']			= 'Informations de connexion';
$GLOBALS['strAdminUsername']			= 'Identifiant de l\'administrateur';
$GLOBALS['strInvalidUsername']			= 'Identifiant invalide';

$GLOBALS['strBasicInformation']			= 'Information de base';
$GLOBALS['strAdminFullName']			= 'Nom complet de l\'administrateur';
$GLOBALS['strAdminEmail']			= 'Adresse e-mail de l\'admin';
$GLOBALS['strCompanyName']			= 'Nom de la société';

$GLOBALS['strAdminCheckUpdates']		= 'Détection automatique des mises à jour de produits et des alertes de sécurité (Recommandé)';
$GLOBALS['strAdminCheckEveryLogin']		= 'Tous logins';
$GLOBALS['strAdminCheckDaily']			= 'Par jour';
$GLOBALS['strAdminCheckWeekly']			= 'Par semaine';
$GLOBALS['strAdminCheckMonthly']		= 'Par mois';
$GLOBALS['strAdminCheckNever']			= 'Jamais';

$GLOBALS['strAdminNovice']			= 'Les actions de suppression de l\'admin nécessitent une confirmation pour plus de sécurité';
$GLOBALS['strUserlogEmail']			= 'Journaliser tous les messages e-mail sortants';
$GLOBALS['strUserlogPriority']			= 'Journaliser chaque heure les calculs de priorité';
$GLOBALS['strUserlogAutoClean']			= 'Journaliser les nettoyages automatiques de la base de données';


// User interface settings
$GLOBALS['strGuiSettings']			= 'Paramètres de l\'interface utilisateur';

$GLOBALS['strGeneralSettings']			= 'Paramètres généraux';
$GLOBALS['strAppName']				= 'Nom de l\'application';
$GLOBALS['strMyHeader']				= 'Emplacement du fichier d\'en-tête';
$GLOBALS['strMyHeaderError']			= 'Le fichier d\'en-tête n\'existe pas dans l\'emplacement que vous avez spécifié';
$GLOBALS['strMyFooter']				= 'Emplacement du fichier de pied de page';
$GLOBALS['strMyFooterError']			= 'Le fichier de pied de page n\'existe pas dans l\'emplacement que vous avezspécifié';
$GLOBALS['strGzipContentCompression']		= 'Utiliser la compression de contenu GZIP';

$GLOBALS['strClientInterface']			= 'Interface de l\'annonceur';
$GLOBALS['strClientWelcomeEnabled']		= 'Activer le message de bienvenue de l\'annonceur';
$GLOBALS['strClientWelcomeText']		= 'Texte de bienvenue<br />(balises HTML autorisées)';



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= 'Paramètres par défaut de l\'interface';

$GLOBALS['strInventory']			= 'Inventaire';
$GLOBALS['strShowCampaignInfo']			= 'Afficher des informations supplémentaires sur les campagnes sur la page <i>Campagnes</i>';
$GLOBALS['strShowBannerInfo']			= 'Afficher des informations supplémentaires sur les bannières sur la page <i>Bannières</i>';
$GLOBALS['strShowCampaignPreview']		= 'Afficher des aperçus de toutes les bannières sur la page <i>Bannières</i>';
$GLOBALS['strShowBannerHTML']			= 'Afficher une bannière à la place du code HTML pour les aperçus de bannières HTML';
$GLOBALS['strShowBannerPreview']		= 'Afficher un aperçu de la bannière en haut des pages liées aux bannières';
$GLOBALS['strHideInactive']			= 'Masquer les inactifs';
$GLOBALS['strGUIShowMatchingBanners']		= 'Afficher les campagnes parentes sur les pages <i>Bannières liées</i>';
$GLOBALS['strGUIShowParentCampaigns']		= 'Afficher les bannières correspondantes sur les pages <i>Bannières liées</i>';
$GLOBALS['strGUILinkCompactLimit']		= 'Ne pas afficher les bannières et campagnes non liées quand il y en a plus de';

$GLOBALS['strStatisticsDefaults'] 		= 'Statistiques';
$GLOBALS['strBeginOfWeek']			= 'Début de la semaine';
$GLOBALS['strPercentageDecimals']		= 'Nombre de décimales pour les pourcentages';

$GLOBALS['strWeightDefaults']			= 'Poids par défaut';
$GLOBALS['strDefaultBannerWeight']		= 'Poids par défaut d\'une bannière';
$GLOBALS['strDefaultCampaignWeight']		= 'Poids par défaut d\'une campagne';
$GLOBALS['strDefaultBannerWErr']		= 'Le poids par défaut d\'une bannière doit être un nombre entier positif';
$GLOBALS['strDefaultCampaignWErr']		= 'Le poids par défaut d\'une campagne doit être un nombre entier positif';



// Not used at the moment
$GLOBALS['strTableBorderColor']			= 'Couleur de la bordure de la table';
$GLOBALS['strTableBackColor']			= 'Couleur d\'arrière-plan de la table';
$GLOBALS['strTableBackColorAlt']		= 'Couleur d\'arrière-plan de la table (Alternatif)';
$GLOBALS['strMainBackColor']			= 'Couleur principale d\'arrière-plan';
$GLOBALS['strOverrideGD']			= 'Outrepasser le format d\'Image GD';
$GLOBALS['strTimeZone']				= 'Fuseau horaire';



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strHasTaxID'] = "ID de taxe";
$GLOBALS['strAdminAccount'] = "Compte administrateur";
$GLOBALS['strSpecifySyncSettings'] = "Paramètres de synchronisation";
$GLOBALS['strOpenadsIdYour'] = "Votre ID OpenX";
$GLOBALS['strOpenadsIdSettings'] = "Paramètres de l'ID OpenX";
$GLOBALS['strBtnContinue'] = "Continuer »";
$GLOBALS['strBtnRecover'] = "Reprendre »";
$GLOBALS['strBtnStartAgain'] = "Recommencer la mise à jour »";
$GLOBALS['strBtnGoBack'] = "« Retour";
$GLOBALS['strBtnAgree'] = "J'accepte »";
$GLOBALS['strBtnDontAgree'] = "« Je refuse";
$GLOBALS['strBtnRetry'] = "Réessayer";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Veuillez corriger toutes les erreurs avant de continuer.";
$GLOBALS['strWarningRegisterArgcArv'] = "La variable register_argc_argv de la configuration PHP doit être activée afin de pouvoir lancer la maintenance depuis la ligne de commande.";
$GLOBALS['strInstallIntro'] = "Merci d'avoir choisi <a href='http://". MAX_PRODUCT_URL ."' target='_blank'><strong>". MAX_PRODUCT_NAME ."</strong></a><p>Cet assistant vous guidera tout au long de l'installation / mise à jour du serveur publicitaire ". MAX_PRODUCT_NAME .".</p><p>Afin de vous aider avec le processus d'installation nous avons créé un <a href='". OX_PRODUCT_DOCSURL ."/wizard/qsg-install' target='_blank'>guide d'installation rapide</a> pour vous permettre d'être fonctionnel au plus vite. Pour un guide d'installation et de configuration de ". MAX_PRODUCT_NAME ." plus complet, consultez le <a href='". OX_PRODUCT_DOCSURL ."/wizard/admin-guide' target='_blank'>guide de l'administrateur</a>.";
$GLOBALS['strRecoveryRequiredTitle'] = "Votre précédente tentative de mise à jour a rencontré une erreur";
$GLOBALS['strRecoveryRequired'] = "Une erreur est survenue lors du traitement de votre précédente mise à jour et ". MAX_PRODUCT_NAME ." doit tenter de reprendre le processus de mise à jour. Veuillez cliquez sur le bouton Reprendre ci-dessous.";
$GLOBALS['strTermsTitle'] = "Termes et conditions d'utilisation, politique de vie privée";
$GLOBALS['strTermsIntro'] = "". MAX_PRODUCT_NAME ." est distribué gratuitement sous une licence Open Source, la Licence Publique Générale LPG. Veuillez lire et accepter les documents suivants pour continuer l'installation.";
$GLOBALS['strPolicyTitle'] = "Politique de vie privée";
$GLOBALS['strPolicyIntro'] = "Veuillez lire et accepter le document suivant afin de poursuivre l'installation.";
$GLOBALS['strDbSetupTitle'] = "Paramètres de la base de données";
$GLOBALS['strDbSetupIntro'] = "Veuillez entrer les informations de connexion à votre base de données. Si vous n'êtes pas certain de ces informations, veuillez contacter votre administrateur système.<p> L'étape suivante installera votre base de données. Cliquez sur 'continuer' pour poursuivre.</p>";
$GLOBALS['strDbUpgradeIntro'] = "Ci-dessous sont présentées les informations détectées de votre base de données pour votre installation de ". MAX_PRODUCT_NAME .". Veuillez vous assurer que ces informations sont correctes.<p>L'étape suivante mettra à jour votre base de données. Cliquez sur 'Continuer' pour mettre à jour votre système.</p>";
$GLOBALS['strOaUpToDate'] = "Votre base de données ". MAX_PRODUCT_NAME ." et votre structure de fichiers utilisent tous deux la version la plus récente, si bien qu'aucune mise à jour n'est requise pour l'instant. Veuillez cliquer sur Continuer afin de vous rendre au panneau d'administration d'". MAX_PRODUCT_NAME .".";
$GLOBALS['strOaUpToDateCantRemove'] = "Attention : le fichier UPGRADE est toujours présent dans votre dossier var. Nous ne pouvons supprimer ce fichier en raison de permissions insuffisantes. Veuillez supprimer ce fichier vous-même.";
$GLOBALS['strRemoveUpgradeFile'] = "Vous devez retirer le fichier UPGRADE du dossier var.";
$GLOBALS['strSystemCheck'] = "Vérification du système";
$GLOBALS['strSystemCheckIntro'] = "L'assistant d'installation vérifie les paramètres de votre serveur web afin de s'assurer que le processus d'installation peut se terminer avec succès.	<p>Veuillez vérifier les problèmes surlignés pour terminer le processus d'installation.</p>";
$GLOBALS['strDbSuccessIntro'] = "La base de données ". MAX_PRODUCT_NAME ." a maintenant été créée. Veuillez cliquer sur le bouton 'Continuer' afin de passer à la configuration des paramètres Administrateur et Distribution de ". MAX_PRODUCT_NAME .".";
$GLOBALS['strDbSuccessIntroUpgrade'] = "Votre système a été mis à jour avec succès. Les écrans restants vous aideront à mettre à jour la configuration de votre nouveau serveur publicitaire.";
$GLOBALS['strErrorWritePermissions'] = "Des erreurs de permissions de fichiers ont été détectées et doivent être corrigées avant de pouvoir continuer.<br />Pour corriger ces erreur sur un système Linux, essayez de taper la(les) commande(s) suivante(s) :";
$GLOBALS['strErrorFixPermissionsCommand'] = "<i>chmod a+w %s</i>";
$GLOBALS['strErrorWritePermissionsWin'] = "Des erreurs de permissions de fichiers ont été détectées et doivent être corrigées avant de pouvoir continuer.";
$GLOBALS['strCheckDocumentation'] = "Pour plus d'aide, veuillez consulter la <a href='". OX_PRODUCT_DOCSURL ."'>documentation d'". MAX_PRODUCT_NAME ." <a/>.";
$GLOBALS['strAdminUrlPrefix'] = "URL de l'interface d'administration";
$GLOBALS['strDeliveryUrlPrefix'] = "URL du moteur de distribution";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL du moteur de distribution (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL de stockage des images";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL de stockage des images (SSL)";
$GLOBALS['strUnableToWriteConfig'] = "Impossible d'écrire les modifications dans le fichier de configuration";
$GLOBALS['strUnableToWritePrefs'] = "Impossible d'appliquer les préférences dans la base de données";
$GLOBALS['strImageDirLockedDetected'] = "Le <b>dossier images</b> indiqué n'est pas accessible en écriture par le serveur. <br>Vous ne pourrez pas poursuivre tant que vous n'aurez pas changé les permissions ou créé le dossier.";
$GLOBALS['strConfigurationSetup'] = "Liste de contrôle de la configuration";
$GLOBALS['strConfigurationSettings'] = "Paramètres de configuration";
$GLOBALS['strAdminPassword'] = "Mot de passe de l'administrateur";
$GLOBALS['strAdministratorEmail'] = "Adresse e-mail de l'administrateur";
$GLOBALS['strTimezone'] = "Fuseau horaire";
$GLOBALS['strTimezoneEstimated'] = "Fuseau horaire détecté";
$GLOBALS['strTimezoneGuessedValue'] = "Fuseau horaire du serveur réglé incorrectement dans PHP";
$GLOBALS['strTimezoneSeeDocs'] = "Veuillez lire la %DOCS% au sujet du réglage de cette variable dans PHP.";
$GLOBALS['strTimezoneDocumentation'] = "documentation";
$GLOBALS['strLoginSettingsTitle'] = "Connexion administrateur";
$GLOBALS['strLoginSettingsIntro'] = "Afin de poursuivre le processus de mise à jour, veuillez entrer vos information de connexion administrateur ". MAX_PRODUCT_NAME .". Vous devez vous connecter en tant qu'administrateur pour continuer le processus de mise à jour.";
$GLOBALS['strAdminSettingsTitle'] = "Créer un compte administrateur";
$GLOBALS['strAdminSettingsIntro'] = "Veuillez remplir ce formulaire pour créer le compte d'administration de votre serveur publicitaire.";
$GLOBALS['strConfigSettingsIntro'] = "Veuillez vérifier les paramètres de configuration ci-dessous et procéder aux changements nécessaires avant de poursuivre. Si vous n'êtes pas sûr de vous, laissez les valeurs par défaut.";
$GLOBALS['strEnableAutoMaintenance'] = "Exécuter automatiquement une maintenance pendant la distribution si la maintenance planifiée n'est pas activée";
$GLOBALS['strOpenadsUsername'] = "Identifiant ". MAX_PRODUCT_NAME ."";
$GLOBALS['strOpenadsPassword'] = "Mot de passe ". MAX_PRODUCT_NAME ."";
$GLOBALS['strOpenadsEmail'] = "E-mail ". MAX_PRODUCT_NAME ."";
$GLOBALS['strDbType'] = "Type de la base de données";
$GLOBALS['strDemoDataInstall'] = "Installer les données de démonstration";
$GLOBALS['strDemoDataIntro'] = "Des données d'installation par défaut peuvent être chargées dans ". MAX_PRODUCT_NAME ." afin de vous aider à commencer à distribuer de la publicité en ligne. Les types de bannières les plus communs, ainsi que quelques campagnes initiales peuvent être chargées et pré-configurées. Ceci est hautement recommandé pour les nouvelles installations.";
$GLOBALS['strDebug'] = "Paramètres de journalisation du débogage";
$GLOBALS['strProduction'] = "Serveur de production";
$GLOBALS['strEnableDebug'] = "Activer la journalisation du débogage";
$GLOBALS['strDebugMethodNames'] = "Inclure les noms des méthodes dans le journal de débogage";
$GLOBALS['strDebugLineNumbers'] = "Inclure les numéros de lignes dans le journal de débogage";
$GLOBALS['strDebugType'] = "Type de journal de débogage";
$GLOBALS['strDebugTypeFile'] = "Fichier";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "Base de données SQL";
$GLOBALS['strDebugTypeSyslog'] = "Syslog";
$GLOBALS['strDebugName'] = "Nom du journal de débogage, calendrier, table SQL,<br />ou installation Syslog";
$GLOBALS['strDebugPriority'] = "Niveau de priorité du débogage";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Le plus d'informations";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Informations par défaut";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Le moins d'informations";
$GLOBALS['strDebugIdent'] = "Chaîne d'identification de débogage";
$GLOBALS['strDebugUsername'] = "Identifiant mCal, serveur SQL";
$GLOBALS['strDebugPassword'] = "Mot de passe mCal, serveur SQL";
$GLOBALS['strWebPath'] = "Emplacements d'accès serveur ". MAX_PRODUCT_NAME ."";
$GLOBALS['strWebPathSimple'] = "Emplacement web";
$GLOBALS['strDeliveryPath'] = "Emplacement de distribution";
$GLOBALS['strImagePath'] = "Emplacement des images";
$GLOBALS['strDeliverySslPath'] = "Emplacement de distribution SSL";
$GLOBALS['strImageSslPath'] = "Emplacement des images SSL";
$GLOBALS['strImageStore'] = "Dossier des images";
$GLOBALS['strTypeFTPPassive'] = "Utiliser le FTP passif";
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
$GLOBALS['strOrigin'] = "Utiliser un serveur d'origine distante";
$GLOBALS['strOriginType'] = "Type du serveur d'origine";
$GLOBALS['strOriginHost'] = "Nom de l'hôte du serveur d'origine";
$GLOBALS['strOriginPort'] = "Numéro de port de la base de données d'origine";
$GLOBALS['strOriginScript'] = "Fichier script de la base de données d'origine";
$GLOBALS['strOriginTypeXMLRPC'] = "XMLRPC";
$GLOBALS['strOriginTimeout'] = "Délai d'expiration de l'origine (secondes)";
$GLOBALS['strOriginProtocol'] = "Protocole du serveur d'origine";
$GLOBALS['strDeliveryAcls'] = "Evaluer les limitations de distribution des bannières au cours de la distribution";
$GLOBALS['strDeliveryObfuscate'] = "Masquer le canal lors de la distribution des publicités";
$GLOBALS['strDeliveryExecPhp'] = "Autoriser le code PHP à être exécuté dans les publicités<br />(Attention : risque de sécurité)";
$GLOBALS['strDeliveryCtDelimiter'] = "Délimiteur de suivi des clics par les tiers";
$GLOBALS['uiEnabled'] = "Interface utilisateur activée";
$GLOBALS['strGeotargetingSettings'] = "Paramètres de géolocalisation";
$GLOBALS['strGeotargetingType'] = "Type du module de géolocalisation";
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "Emplacement de la base de données MaxMind GeoIP Country";
$GLOBALS['strGeotargetingGeoipRegionLocation'] = "Emplacement de la base de données MaxMind GeoIP Region";
$GLOBALS['strGeotargetingGeoipCityLocation'] = "Emplacement de la base de données MaxMind GeoIP City";
$GLOBALS['strGeotargetingGeoipAreaLocation'] = "Emplacement de la base de données MaxMind GeoIP Area";
$GLOBALS['strGeotargetingGeoipDmaLocation'] = "Emplacement de la base de données MaxMind GeoIP DMA";
$GLOBALS['strGeotargetingGeoipOrgLocation'] = "Emplacement de la base de données MaxMind GeoIP Organisation";
$GLOBALS['strGeotargetingGeoipIspLocation'] = "Emplacement de la base de données MaxMind GeoIP ISP";
$GLOBALS['strGeotargetingGeoipNetspeedLocation'] = "Emplacement de la base de données MaxMind GeoIP Netspeed";
$GLOBALS['strGeoSaveStats'] = "Enregistrer les données GeoIP dans les évènements de la base de données";
$GLOBALS['strGeoShowUnavailable'] = "Afficher les limitations de géolocalisation de distribution même si les données GeoIP sont indisponibles";
$GLOBALS['strGeotrackingGeoipCountryLocationError'] = "La base de données MaxMind GeoIP Country n'existe pas à l'emplacement spécifié";
$GLOBALS['strGeotrackingGeoipRegionLocationError'] = "La base de données MaxMind GeoIP Region n'existe pas à l'emplacement spécifié";
$GLOBALS['strGeotrackingGeoipCityLocationError'] = "La base de données MaxMind GeoIP City n'existe pas à l'emplacement spécifié";
$GLOBALS['strGeotrackingGeoipAreaLocationError'] = "La base de données MaxMind GeoIP Area n'existe pas à l'emplacement spécifié";
$GLOBALS['strGeotrackingGeoipDmaLocationError'] = "La base de données MaxMind GeoIP DMA n'existe pas à l'emplacement spécifié";
$GLOBALS['strGeotrackingGeoipOrgLocationError'] = "La base de données MaxMind GeoIP Organisation n'existe pas à l'emplacement spécifié";
$GLOBALS['strGeotrackingGeoipIspLocationError'] = "La base de données MaxMind GeoIP ISP n'existe pas à l'emplacement spécifié";
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = "La base de données MaxMind GeoIP Netspeed n'existe pas à l'emplacement spécifié";
$GLOBALS['strGUIAnonymousCampaignsByDefault'] = "Attribuer les campagnes à Anonyme par défaut";
$GLOBALS['strPublisherDefaults'] = "Paramètres par défaut d'un site web";
$GLOBALS['strModesOfPayment'] = "Modes de paiement";
$GLOBALS['strCurrencies'] = "Devises";
$GLOBALS['strCategories'] = "Catégories";
$GLOBALS['strHelpFiles'] = "Fichiers d'aides";
$GLOBALS['strDefaultApproved'] = "Case à cocher approuvé";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Activer le suivi des clics par les tiers par défaut";
$GLOBALS['strCsvImport'] = "Autoriser le téléchargement des conversions hors-ligne";
$GLOBALS['strLogAdRequests'] = "Journaliser une requête à chaque fois qu'une bannière est demandée";
$GLOBALS['strLogAdImpressions'] = "Journaliser une impression à chaque fois qu'une bannière est affichée";
$GLOBALS['strLogAdClicks'] = "Journaliser un clic à chaque fois qu'un visiteur clique sur une bannière";
$GLOBALS['strLogTrackerImpressions'] = "Journaliser une impression de suiveur à chaque fois qu'une balise de suivi est affichée";
$GLOBALS['strPreventLogging'] = "Paramètres de blocage de la journalisation des bannières";
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
$GLOBALS['strWarnLimitDays'] = "Envoyer un avertissement quand le nombre de jours restants est inférieur à celui spécifié ici";
$GLOBALS['strWarnLimitDaysErr'] = "Le nombre de jours de limite d'avertissement doit être un entier positif";
$GLOBALS['strWarnAgency'] = "Envoyer une alerte à l'agence à chaque fois qu'une campagne approche de son expiration";
$GLOBALS['strEnableQmailPatch'] = "Activer le patch qmail";
$GLOBALS['strDefaultTrackerStatus'] = "État par défaut du suiveur";
$GLOBALS['strDefaultTrackerType'] = "Type par défaut du suiveur";
$GLOBALS['strMyLogo'] = "Nom du fichier du logo personnalisé";
$GLOBALS['strMyLogoError'] = "Le fichier du logo n'existe pas dans le répertoire admin/images";
$GLOBALS['strGuiHeaderForegroundColor'] = "Couleur du premier plan de l'en-tête";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Couleur de l'arrière-plan de l'en-tête";
$GLOBALS['strGuiActiveTabColor'] = "Couleur de l'onglet actif";
$GLOBALS['strGuiHeaderTextColor'] = "Couleur du texte dans l'en-tête";
$GLOBALS['strColorError'] = "Veuillez entrer les couleurs au format RGB, comme '0066CC'";
$GLOBALS['strReportsInterface'] = "Interface des rapports";
$GLOBALS['strPublisherInterface'] = "Interface du site web";
$GLOBALS['strPublisherAgreementEnabled'] = "Activer le contrôle d'identification pour les sites web n'ayant pas accepté les termes et conditions";
$GLOBALS['strPublisherAgreementText'] = "Texte de connexion (balises HTML autorisées)";
$GLOBALS['strNovice'] = "Les actions de suppression nécessitent une confirmation par sécurité";
$GLOBALS['strEmailSettings'] = "Paramètres e-mail";
$GLOBALS['strEmailHeader'] = "En-têtes HTML";
$GLOBALS['strEmailLog'] = "Journal HTML";
$GLOBALS['strAuditTrailSettings'] = "Paramètres de la piste d'audit";
$GLOBALS['strEnableAudit'] = "Activer la piste d'audit";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Votre installation de PHP ne supporte pas le FTP.";
$GLOBALS['strGeotargetingUseBundledCountryDb'] = "Utiliser la base de données MaxMind GeoLiteCountry fournie";
$GLOBALS['strConfirmationUI'] = "Confirmation dans l'interface utilisateur";
$GLOBALS['strBannerStorage'] = "Paramètres de stockage des bannières";
$GLOBALS['strMaintenanceSettings'] = "Paramètres de maintenance";
$GLOBALS['strSSLSettings'] = "Paramètres SSL";
$GLOBALS['requireSSL'] = "Forcer l'accès SSL pour l'interface utilisateur";
$GLOBALS['sslPort'] = "Port SSL utilisé par le serveur web";
$GLOBALS['strAlreadyInstalled'] = "". MAX_PRODUCT_NAME ." est déjà installé sur ce système . Si vous voulez le configurer, allez dans l\'<a href='account-index.php'>interface de paramétrage</a>";
$GLOBALS['strAllowEmail'] = "Autoriser l'envoi d'e-mails de manière générale";
$GLOBALS['strEmailAddressFrom'] = "Adresse e-mail DEPUIS laquelle envoyer les rapports";
$GLOBALS['strEmailAddressName'] = "Société ou nom de la personne avec laquelle signer les e-mails";
$GLOBALS['strInvocationDefaults'] = "Paramètres par défaut de l'invocation";
$GLOBALS['strDbSocket'] = "Socket de base de données";
$GLOBALS['strEmailAddresses'] = "Adresse de l'expéditeur des e-mails";
$GLOBALS['strEmailFromName'] = "Nom de l'expéditeur des e-mails";
$GLOBALS['strEmailFromAddress'] = "Adresse e-mail de l'expéditeur des e-mails";
$GLOBALS['strEmailFromCompany'] = "Société de l'expéditeur des e-mails";
$GLOBALS['strIgnoreUserAgents'] = "<b>Ne pas</b> journaliser les statistiques des clients ayant n'importe laquelle des chaînes suivantes dans leur user-agent (une par ligne)";
$GLOBALS['strEnforceUserAgents'] = "Ne journaliser <b>que</b> les statistiques des clients ayant n'importe laquelle des chaînes suivantes dans leur user-agent (une par ligne)";
$GLOBALS['strConversionTracking'] = "Paramètres de suivi des conversions";
$GLOBALS['strEnableConversionTracking'] = "Activer le suivi des conversions";
$GLOBALS['strDbNameHint'] = "La base de données sera créée si elle n'existe pas";
$GLOBALS['strProductionSystem'] = "Système en production";
$GLOBALS['strTypeFTPErrorUpload'] = "Téléchargement impossible vers le serveur FTP, vérifiez les permissions du répertoire hôte";
$GLOBALS['strBannerLogging'] = "Paramètres de la journalisation des bannières";
$GLOBALS['strBannerDelivery'] = "Paramètres de distribution des bannières";
$GLOBALS['strEnableDashboardSyncNotice'] = "Veuillez activer la <a href='account-settings-update.php'>vérification des mises à jour</a> pour utiliser le tableau de bord.";
$GLOBALS['strDashboardSettings'] = "Paramètres du tableau de bord";
$GLOBALS['strWarningPHPversion'] = "". MAX_PRODUCT_NAME ." nécessite PHP 5.1.4 ou plus récent pour fonctionner correctement. Vous utilisez actuellement la version {php_version}.";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
$GLOBALS['strDeliveryCacheStore'] = "Type de stockage du cache de distribution des bannières";
$GLOBALS['strErrorInCacheStorePlugin'] = "Des erreurs ont été signalées par le \"%s\" plugin de distribution:";
$GLOBALS['strDeliveryCacheStorage'] = "Type de cache du stockage de distribution";
$GLOBALS['strGlobalDefaultBannerUrl'] = "URL de l'image de la bannière par défaut générale";
$GLOBALS['strAdminShareStack'] = "Partager vos informations techniques avec l'équipe OpenX pour aider au test et au développement";
$GLOBALS['strAdminShareData'] = "Partager, de façon anonyme, vos informations sur les volumes de publicités pour participer au programme communautaire de partage d'information";
$GLOBALS['strCantConnectToDbDelivery'] = "Connexion impossible à la base de données pour la distribution";
$GLOBALS['generalSettings'] = "Système de paramétrage global";
$GLOBALS['defaultLanguage'] = "Langage par défaut<br />(Chaque utilisateur choisi sa propre langue)";
$GLOBALS['strUploadConversions'] = "Conversions de téléchargement";
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
?>