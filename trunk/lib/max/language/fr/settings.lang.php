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



// Installer translation strings
$GLOBALS['strInstall']				= 'Installer';
$GLOBALS['strChooseInstallLanguage']		= 'Choisissez la langue pour la procédure d\'installation';
$GLOBALS['strLanguageSelection']		= 'Sélection de la langue';
$GLOBALS['strDatabaseSettings']			= 'Paramètres de la base de données';
$GLOBALS['strAdminSettings']			= 'Paramètres de l\'administrateur';
$GLOBALS['strAdvancedSettings']			= 'Paramètres avancés';
$GLOBALS['strOtherSettings']			= 'Autres paramètres';

$GLOBALS['strWarning']				= 'Alerte';
$GLOBALS['strFatalError']			= 'Une erreur fatale est survenue';
$GLOBALS['strUpdateError']			= 'Une erreur est survenue en tentant de mettre à jour '. $phpAds_productname;
$GLOBALS['strUpdateDatabaseError']		= 'Une erreur non identifiée étant survenue, la structure de la base de données n\'a pas pu être mise à jour. Il est recommandé de cliquer sur <b>Retenter la mise à jour</b>, afin d\'essayer de corriger ces problèmes potentiels; néanmoins, si vous êtes sur que ces erreurs ne vont pas affecter la bonne marche de '.$phpAds_productname.', vous pouvez cliquer sur <b>Ignorer les erreurs</b> et continuer. Ignorer ces erreurs peut entrainer de graves problèmes !';
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname.' est déjà installé sur ce système. Si vous souhaitez le configurer :<a href=\'settings-index.php\'>Paramètres de '.$phpAds_productname.'</a>.';
$GLOBALS['strCouldNotConnectToDB']		= $phpAds_productname.' ne peut se connecter à la base de donnée. Veuillez vérifier les paramètres que vous avez entrés.';
$GLOBALS['strCreateTableTestFailed']		= 'L\'utilisateur que vous avez spécifié n\'a pas la permission de créer ou de mettre à jour la structure de la base de données. Veuillez contacter l\'administrateur de la base.';
$GLOBALS['strUpdateTableTestFailed']		= 'L\'utilisateur que vous avez spécifié n\'a pas la permission de mettre à jour la structure de la base de données. Veuillez contacter l\'administrateur de la base.';
$GLOBALS['strTablePrefixInvalid']		= 'Le préfixe des tables contient des caractères invalides';
$GLOBALS['strTableInUse']			= 'La base de données que vous avez spécifiée est déjà utilisée pour '.$phpAds_productname.'. Veuillez utiliser un préfixe de table différent, ou lire le manuel pour les instructions de mise à jour.';
$GLOBALS['strTableWrongType']			= 'Le type de table que vous avez sélectionné n\'est pas supporté par votre installation de '.$phpAds_dbmsname;
$GLOBALS['strMayNotFunction']			= 'Avant de continuer, vous devriez corriger ce problème potentiel :';
$GLOBALS['strFixProblemsBefore']		= 'Le(s) chose(s) suivante(s) doivent être corrigée(s) avant que vous ne puissiez installer '.$phpAds_productname.'. Si vous avez des questions à propos de ce message d\'erreur, lisez le <i>Guide de l\'administrateur</i> (Administrator guide, en anglais), qui est fourni avec l\'archive que vous avez téléchargée.';
$GLOBALS['strFixProblemsAfter']			= 'Si vous ne pouvez pas corriger les problèmes ci-dessus, veuillez contacter l\'adminitrateur du serveur sur lequel vous tentez d\'installer '.$phpAds_productname.'. Il devrait être capable de vous aider.';
$GLOBALS['strIgnoreWarnings']			= 'Ignorer les avertissement';
$GLOBALS['strWarningPHPversion']		= $phpAds_productname.' requiert  PHP 4.0 (ou plus) pour fonctionner correctement. Vous utilisez actuellement {php_version}.';
$GLOBALS['strWarningDBavailable']               = 'La version de PHP que vous utilisez n\'a pas le support nécessaire pour se connecter à une base de données '.$phpAds_dbmsname.'. Vous devez activer l\'extension '.$phpAds_dbmsname.' de PHP avant de pouvoir continuer.';
$GLOBALS['strWarningRegisterGlobals']		= 'La variable de configuration globale PHP <i>register_globals</i> doit être activée.';
$GLOBALS['strWarningMagicQuotesGPC']		= 'La variable de configuration globale PHP <i>magic_quotes_gpc</i> doit être activée.';
$GLOBALS['strWarningMagicQuotesRuntime']  	= 'La variable de configuration globale PHP <i>magic_quotes_runtime</i> doit être désactivée.';
$GLOBALS['strWarningFileUploads']		= 'La variable de configuration globale PHP <i>file_uploads</i> doit être activée.';
$GLOBALS['strWarningTrackVars']			= 'La variable de configuration globale PHP <i>track_vars</i> doit être activée.';
$GLOBALS['strWarningPREG']			= 'La version de PHP que vous utilisez ne dispose pas des PCRE (Expression rationnelles compatibles Perl). Vous devez activer l\'extension PCRE avant de pouvoir continuer.';
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname.' ne peut pas écrire sur le fichier <b>config.inc.php</b>.<br> Vous devez accorder avoir les privilèges d\'écriture sur ce fichier. <br>Veuillez lire la documentation fournie pour plus d\'informations.';
$GLOBALS['strCantUpdateDB']  			= 'Il n\'est pas possible de mettre à jour la base de données. Si vous décidez de continuer, toutes les bannières existantes, les statistiques, et les annonceurs seront perdus.';
$GLOBALS['strIgnoreErrors']			= 'Ignorer les erreurs';
$GLOBALS['strRetryUpdate']			= 'Retenter la mise à jour';
$GLOBALS['strTableNames']			= 'Nom de la base';
$GLOBALS['strTablesPrefix']			= 'Préfixe des noms des tables';
$GLOBALS['strTablesType']			= 'Type de table';

$GLOBALS['strInstallWelcome']			= 'Bienvenue sur '.$phpAds_productname;
$GLOBALS['strInstallMessage']			= 'Avant de pouvoir utiliser '.$phpAds_productname.', il est nécessaire de le configurer, et la base de données doit être crée. Cliquez sur <b>Continuer</b> pour poursuivre.';
$GLOBALS['strInstallSuccess']			= '<b>L\'installation de '.$phpAds_productname.' est maintenant terminée.</b><br><br>Afin que '.$phpAds_productname.' fonctionne '
						 .'correctement, vous devez aussi faire en sorte que le fichier de maintenance soit exécuté chaque heure. Vous trouverez plus '
						 .' d\'informations sur ce sujet dans la documentation.<br><br>Cliquez sur <b>Continuer</b> pour accéder à l\'interfaçe de '
						 .'configuration, d\'où vous pourrez finir de paramètrer '.$phpAds_productname.'. Veuillez à ne pas oublier de protéger contre '
						 .'l\'écriture le fichier <i>config.inc.php</i> lorsque vous aurez fini, afin de sécuriser '.$phpAds_productname.'.';

$GLOBALS['strUpdateSuccess']			= '<b>La mise à niveau de '.$phpAds_productname.' a réussie.</b><br><br>Afin que '.$phpAds_productname.' fonctionne correctement, '
						 .'vous devez aussi faire en sorte que le fichier de maintenance soit exécuté chaque heure (précédemment c\'était chaque jour). '
						 .'Vous trouverez plus d\'informations sur ce sujet dans la documentation.<br><br>Cliquez sur <b>Continuer</b> pour accéder '
						 .'à l\'interfaçe de configuration, d\'où vous pourrez finir de paramétrer '.$phpAds_productname.'. Veuillez à ne pas oublier '
						 .'de protéger en écriture le fichier <i>config.inc.php</i> lorsque vous aurez fini, afin de sécuriser '.$phpAds_productname.'.';
$GLOBALS['strInstallNotSuccessful']		= '<b>L\'installation de '.$phpAds_productname.' a échouée</b><br><br>Certaines partie du processus d\'installation n\'ont pas pu '
						 .'être réalisées. Il est possible que ces problèmes ne soient que temporaires; dans ce cas vous pouvez simplement cliquer '
						 .'sur <b>Continuer</b> et retourner à la première étape du processus d\'installation. Si vous voulez en savoir plus sur la '
						 .'signification du message d\'erreur ci-dessous, et savoir comment résoudre le problème, veuillez consulter la documentation fournie.';
$GLOBALS['strErrorOccured']			= 'L\'erreur suivante est survenue :';
$GLOBALS['strErrorInstallDatabase']		= 'La structure de la base de données n\'a pas pu être crée.';
$GLOBALS['strErrorInstallConfig']		= 'Le fichier de configuration, ou la base de données n\'a pas pu être mis à jour.';
$GLOBALS['strErrorInstallDbConnect']		= $phpAds_productname.' n\'a pas réussi à se connecter à la base de données '.$phpAds_dbmsname.'.';

$GLOBALS['strUrlPrefix']			= 'Préfixe d\'Url';

$GLOBALS['strProceed']				= 'Continuer >';
$GLOBALS['strInvalidUserPwd']			= 'Nom d\'utilisateur, ou mot de passe invalide';

$GLOBALS['strUpgrade']				= 'Mise à niveau';
$GLOBALS['strSystemUpToDate']			= 'Votre système est déjà à jour, et aucune mise à niveau n\'est nécessaire pour le moment. <br>Cliquez sur <b>Continuer</b> pour accéder à la page d\'accueil.';
$GLOBALS['strSystemNeedsUpgrade']               = 'La structure de la base de données et le fichier de configuration doivent être mis à jour pour fonctionner correctement. Cliquez sur <b>Continuer</b> pour commencer le processus de mise à jour. <br><br>Suivant la version à laquelle vous êtes, et la quantité de statistiques présentes dans la base, cette opération peut provoquer une grande charge sur le serveur SQL. Merci d\'être patient. Cette mise à jour peut prendre jusqu\'à plusieurs minutes.';
$GLOBALS['strSystemUpgradeBusy']		= 'Mise à jour du système en cours, merci de patienter...';
$GLOBALS['strSystemRebuildingCache']		= 'Reconstruction du cache, merci de patienter...';
$GLOBALS['strServiceUnavalable']		= 'Le service est temporairement indisponible. Mise à jour du système en cours.';

$GLOBALS['strConfigNotWritable']		= $phpAds_productname.' ne peut écrire dans le fichier config.inc.php';





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= 'Paramètres ';
$GLOBALS['strDayFullNames'] 			= array('Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi');
$GLOBALS['strEditConfigNotPossible']		= 'Il n\'est pas possible d\'éditer ces paramètres, le fichier de configuration étant en lecture seule pour des raisons de sécurité. '.
						  'Si vous souhaitez faire des changements, vous devez d\'abord changer les droits du fichier config.inc.php.';
$GLOBALS['strEditConfigPossible']		= 'Il est possible d\'éditer tous les paramètres, car le fichier de configuration n\'est pas protégé, mais cela abaisse le niveau de sécurité de l\'installation. '.
						  'Pour sécuriser le système, vous devez changer les droits du fichier config.inc.php dès que vous aurez fini les réglages.';



// Database
$GLOBALS['strDatabaseSettings']			= 'Base de données '.$phpAds_dbmsname;
$GLOBALS['strDatabaseServer']			= 'Serveur base de données';
$GLOBALS['strDbLocal']				= 'Se connecter au serveur local en utilisant les sockets'; // Pg only
$GLOBALS['strDbHost']				= 'Adresse du serveur SQL';
$GLOBALS['strDbPort']				= 'Port du serveur SQL';
$GLOBALS['strDbUser']				= 'Nom d\'utilisateur';
$GLOBALS['strDbPassword']			= 'Mot de passe';
$GLOBALS['strDbName']				= 'Nom de la base';

$GLOBALS['strDatabaseOptimalisations']		= 'Options de la base de données';
$GLOBALS['strPersistentConnections']		= 'Utiliser des connexions persistantes';
$GLOBALS['strInsertDelayed']			= 'Utiliser des \'INSERT\' retardés';
$GLOBALS['strCompatibilityMode']		= 'Utiliser le mode de compatibilité base de données';
$GLOBALS['strCantConnectToDb']			= 'Impossible de se connecter à la base de données';



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= 'Invocation et de distribution';

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
$GLOBALS['strCacheFiles']			= 'Fichiers';
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
$GLOBALS['strZoneCache']			= 'Cacher les zones; cela peut accélérer '.$phpAds_productname.' lorsque l\'on utilise les zones';
$GLOBALS['strZoneCacheLimit']			= 'Délai entre les mises à jour du cache (en secondes)';
$GLOBALS['strZoneCacheLimitErr']		= 'Erreur: le délai entre les mises à jour du cache doit être un entier positif.';

$GLOBALS['strP3PSettings']			= 'Politique de respect de la vie privée P3P';
$GLOBALS['strUseP3P']				= 'Utiliser la politique P3P';
$GLOBALS['strP3PCompactPolicy']			= 'Politique compacte P3P';
$GLOBALS['strP3PPolicyLocation']		= 'Emplacement de la politique P3P';



// Banner Settings
$GLOBALS['strBannerSettings']			= 'Bannières';

$GLOBALS['strAllowedBannerTypes']		= 'Types de bannières autorisés';
$GLOBALS['strTypeSqlAllow']			= 'Autoriser les bannières Images - serveur SQL';
$GLOBALS['strTypeWebAllow']			= 'Autoriser les bannières Images - serveur Web';
$GLOBALS['strTypeUrlAllow']			= 'Autoriser les bannières Images - externe';
$GLOBALS['strTypeHtmlAllow']			= 'Autoriser les bannières HTML';
$GLOBALS['strTypeTxtAllow']			= 'Autoriser les publicités textuelles';

$GLOBALS['strTypeWebSettings']			= 'Configuration des bannières locales (Serveur Web)';
$GLOBALS['strTypeWebMode']			= 'Méthode de stockage';
$GLOBALS['strTypeWebModeLocal']			= 'Répertoire local';
$GLOBALS['strTypeWebModeFtp']			= 'Serveur FTP externe';
$GLOBALS['strTypeWebDir']			= 'Répertoire local';
$GLOBALS['strTypeWebFtp']			= 'Server Web de bannière en mode FTP';
$GLOBALS['strTypeWebUrl']			= 'Url publique';
$GLOBALS['strTypeFTPHost']			= 'Adresse du serveur FTP';
$GLOBALS['strTypeFTPDirectory']			= 'Répertoire sur le serveur';
$GLOBALS['strTypeFTPUsername']			= 'Nom d\'utilisateur';
$GLOBALS['strTypeFTPPassword']			= 'Mot de passe';
$GLOBALS['strTypeFTPErrorDir']			= 'Le répertoire sur le serveur FTP distant n\'existe pas.';
$GLOBALS['strTypeFTPErrorConnect']		= 'Impossible de se connecter au serveur FTP distant, le nom d\'utilisateur ou le mot de passe sont incorrects.';
$GLOBALS['strTypeFTPErrorHost']			= 'Le nom de machine du serveur FTP distant est erroné.';
$GLOBALS['strTypeDirError']			= 'Le répertoire local spécifié n\'existe pas.';

$GLOBALS['strDefaultBanners']			= 'Bannière par défaut';
$GLOBALS['strDefaultBannerUrl']			= 'Emlacement de l\'image par défaut';
$GLOBALS['strDefaultBannerTarget']		= 'Url de destination par défaut';

$GLOBALS['strTypeHtmlSettings']			= 'Options des bannières HTML';
$GLOBALS['strTypeHtmlAuto']			= 'Adapter automatiquement les bannières HTML, afin de pourvoir compter les clics.';
$GLOBALS['strTypeHtmlPhp']			= 'Autoriser l\'exécution d\'expressions PHP dans les bannières HTML.';


// Host information and Geotargeting
$GLOBALS['strHostAndGeo']			= 'Hôtes, et géolocalisation';

$GLOBALS['strRemoteHost']			= 'Hôte';
$GLOBALS['strReverseLookup']			= 'Déterminer le nom d\'hôte si celui-ci n\'est pas donné par le serveur';
$GLOBALS['strProxyLookup']			= 'Déterminer l\'adresse IP réelle du visiteur si il utilise un serveur proxy';

$GLOBALS['strGeotargeting']			= 'Géolocalisation';
$GLOBALS['strGeotrackingType']			= 'Type de base de données de géolocalisation';
$GLOBALS['strGeotrackingLocation']		= 'Emplacement de la base de données de géolocalisation';
$GLOBALS['strGeotrackingLocationError']		= 'La base de géolocalisation n\'a pas été trouvée à l\'emplacement spécifié';
$GLOBALS['strGeoStoreCookie']			= 'Stocker le résultat de la localisation géographique dans un cookie, et s\'y réfenrencer pas la suite.';


// Statistics Settings
$GLOBALS['strStatisticsSettings']		= 'Statistiques';

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
$GLOBALS['strIgnoreHosts']			= '<br>Ne pas journaliser les demandes des adresses IP ou des noms d\'hôtes suivants :';
$GLOBALS['strBlockAdviews']			= 'Ne pas compter deux affichages d\'un même client en moins de :<br>(secondes)';
$GLOBALS['strBlockAdclicks']			= 'Ne pas compter deux clics d\'un même client en moins de :<br>(secondes)';


$GLOBALS['strEmailWarnings']			= 'Avertissements par Email';
$GLOBALS['strAdminEmailHeaders']		= '<br><br>Ajouter les entêtes suivante aux mails envoyés par '.$phpAds_productname . ' :';
$GLOBALS['strWarnLimit']			= 'Envoyer un avertissement lorsque le crédit d\'affichages passe sous :';
$GLOBALS['strWarnLimitErr']			= 'La limite d\'avertissement doit être un entier positif.';
$GLOBALS['strWarnAdmin']			= 'Envoyer un avertissement à l\'administrateur lorsque qu\'une campagne va expirer';
$GLOBALS['strWarnClient']			= 'Envoyer un avertissement à l\'annonceur lorsque qu\'une campagne va expirer';
$GLOBALS['strQmailPatch']			= 'Utiliser le patch pour qmail';

$GLOBALS['strAutoCleanTables']			= 'Purger automatiquement la base de données';
$GLOBALS['strAutoCleanStats']			= 'Purger automatiquement les données statistiques';
$GLOBALS['strAutoCleanUserlog']			= 'Purger le journal utilisateur';
$GLOBALS['strAutoCleanStatsWeeks']		= 'Age maximal des statistiques <br>(en semaines, au minimum 3)';
$GLOBALS['strAutoCleanUserlogWeeks']		= 'Age maximal des journaux utilisateurs <br>(en semaines, au minimum 3)';
$GLOBALS['strAutoCleanErr']			= 'L\'âge maximal doit être d\'au moins de 3 semaines';
$GLOBALS['strAutoCleanVacuum']			= 'VACUUM ANALYZE (optimisation - nettoyage) des tables chaque nuit'; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= 'Administrateur';

$GLOBALS['strLoginCredentials']			= 'Accréditations de connexion';
$GLOBALS['strAdminUsername']			= 'Nom d\'utilisateur de l\'administrateur';
$GLOBALS['strInvalidUsername']			= 'Nom d\'utilisateur invalide';

$GLOBALS['strBasicInformation']			= 'Informations de base';
$GLOBALS['strAdminFullName']			= 'Nom complet de l\'administrateur';
$GLOBALS['strAdminEmail']			= 'Adresse email de l\'administrateur';
$GLOBALS['strCompanyName']			= 'Nom de l\'organisation';

$GLOBALS['strAdminCheckUpdates']		= 'Surveiller les mises à jour';
$GLOBALS['strAdminCheckEveryLogin']		= 'A chaque connexion';
$GLOBALS['strAdminCheckDaily']			= 'Chaque jour';
$GLOBALS['strAdminCheckWeekly']			= 'Chaque semaine';
$GLOBALS['strAdminCheckMonthly']		= 'Chaque mois';
$GLOBALS['strAdminCheckNever']			= 'Jamais';

$GLOBALS['strAdminNovice']			= 'L\'administrateur doit quand même confirmer les actions de suppression (sécurité)';
$GLOBALS['strUserlogEmail']			= 'Journaliser tous les messages mail sortants';
$GLOBALS['strUserlogPriority']			= 'Journaliser chaque heure les calculs de priorité';
$GLOBALS['strUserlogAutoClean']			= 'Journaliser les nettoyages automatiques de la base de données';


// User interface settings
$GLOBALS['strGuiSettings']			= 'Interface utilisateur';

$GLOBALS['strGeneralSettings']			= 'Paramètres généraux';
$GLOBALS['strAppName']				= 'Nom de l\'application';
$GLOBALS['strMyHeader']				= 'Emplacement de l\'entête';
$GLOBALS['strMyHeaderError']			= 'Le fichier d\'entête n\'a pas été trouvé à l\'emplacement que vous avez spécifié';
$GLOBALS['strMyFooter']				= 'Emplacement du pied de page';
$GLOBALS['strMyFooterError']			= 'Le fichier de pied de page n\'a pas été trouvé à l\'emplacement que vous avez spécifié';
$GLOBALS['strGzipContentCompression']		= 'Transmettre les pages en GZIP';

$GLOBALS['strClientInterface']			= 'Interface de l\'annonceur';
$GLOBALS['strClientWelcomeEnabled']		= 'Afficher un message d\'accueil';
$GLOBALS['strClientWelcomeText']		= '<br>Message de bienvenue<br>(HTML autorisé)';



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= 'Valeurs par défaut de l\'interface';

$GLOBALS['strInventory']			= 'Administration';
$GLOBALS['strShowCampaignInfo']			= 'Sur la page <i>Aperçu de la campagne</i>, afficher les informations supplémentaires concernant la campagne.';
$GLOBALS['strShowBannerInfo']			= 'Sur la page <i>Aperçu de la bannière</i>, afficher les informations supplémentaires concernant la bannière.';
$GLOBALS['strShowCampaignPreview']		= 'Montrer un aperçu de toutes les bannières sur la page <i>Aperçu des bannières</i>.';
$GLOBALS['strShowBannerHTML']			= 'Pour l\'aperçu des bannières HTML, préférer l\'affichage de la bannière à celui du code HTML brut.';
$GLOBALS['strShowBannerPreview']		= 'Afficher un aperçu de la bannière au sommet des pages qui la concernent.';
$GLOBALS['strHideInactive']			= 'Cacher les éléments inactifs dans toutes les pages d\'aperçus.';
$GLOBALS['strGUIShowMatchingBanners']		= 'Sur les pages <i>Bannières liées</i>, afficher les bannières correspondantes.';
$GLOBALS['strGUIShowParentCampaigns']		= 'Sur les pages <i>Bannières liées</i>, afficher les campagnes parentes.';
$GLOBALS['strGUILinkCompactLimit']		= 'Ne pas afficher les bannières et campagnes non liées quand il y en a plus de';

$GLOBALS['strStatisticsDefaults'] 		= 'Statistiques';
$GLOBALS['strBeginOfWeek']			= 'Premier jour de la semaine';
$GLOBALS['strPercentageDecimals']		= 'Nombre de décimales des pourcentages';

$GLOBALS['strWeightDefaults']			= 'Poids par défaut';
$GLOBALS['strDefaultBannerWeight']		= 'Poids par défaut des bannières';
$GLOBALS['strDefaultCampaignWeight']		= 'Poids par défaut des campagnes';
$GLOBALS['strDefaultBannerWErr']		= 'Le poids par défaut des bannières DOIT être un entier positif';
$GLOBALS['strDefaultCampaignWErr']		= 'Le poids par défaut des campagnes DOIT être un entier positif';



// Not used at the moment
$GLOBALS['strTableBorderColor']			= 'Couleur de la bordure de la table';
$GLOBALS['strTableBackColor']			= 'Couleur d\'arrière-plan de la table';
$GLOBALS['strTableBackColorAlt']		= 'Couleur d\'arrière-plan de la table (Alternatif)';
$GLOBALS['strMainBackColor']			= 'Couleur principale d\'arrière-plan';
$GLOBALS['strOverrideGD']			= 'Outrepasser le format d\'Image GD';
$GLOBALS['strTimeZone']				= 'Fuseau horaire';

?>