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

/** status messages * */
$GLOBALS['strInstallStatusRecovery'] = 'Recovering Revive Adserver %s';
$GLOBALS['strInstallStatusInstall'] = 'Installing Revive Adserver %s';
$GLOBALS['strInstallStatusUpgrade'] = 'Upgrading to Revive Adserver %s';
$GLOBALS['strInstallStatusUpToDate'] = 'Detected Revive Adserver %s';

/** welcome step * */
$GLOBALS['strWelcomeTitle'] = "Bienvenue à {$PRODUCT_NAME}";
$GLOBALS['strInstallIntro'] = "Merci d'avoir choisi {$PRODUCT_NAME}. Cet assistant vous guidera pendant ses étapes d'installation.";
$GLOBALS['strUpgradeIntro'] = "Merci d'avoir choisi {$PRODUCT_NAME}. Cet assistant vous guidera pendant sa mise à jour.";
$GLOBALS['strInstallerHelpIntro'] = "Pour vous aider pendant l'installation de {$PRODUCT_NAME}, veuillez voir la <a href='{$PRODUCT_DOCSURL}' target='_blank'>documentation</a>.";
$GLOBALS['strTermsIntro'] = "{$PRODUCT_NAME} is distributed freely under an Open Source license, the GNU General Public License. Please review and agree to the following documents to continue the installation.";

/** check step * */
$GLOBALS['strSystemCheck'] = "System check";
$GLOBALS['strSystemCheckIntro'] = "L'assistant d'installation a vérifié les réglages de votre serveur pour que le processus d'installation puisse bien aboutir.
                                                  <br>Veuillez vérifier les points signalés pour terminer l'installation.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "La configuration de votre serveur ne correspond pas aux exigences de {$PRODUCT_NAME}.
                                                   <br>Pour poursuivre l'installation, veuillez résoudre toutes les erreurs.
                                                   Pour de l'aide, veuillez voir notre <a href='{$PRODUCT_DOCSURL}'>documentation</a> et <a href='http://{$PRODUCT_URL}/faq'>foire aux questions</a>";

$GLOBALS['strAppCheckErrors'] = "Des erreurs ont été trouvées en détectant les installations de {$PRODUCT_NAME}";
$GLOBALS['strAppCheckDbIntegrityError'] = "Nous avons détecté des soucis d'intégration pour votre base de données. Il se peut que son agencement                                                   diffère de nos attentes. La personnalisation de votre base de données pourrait en être la cause.";

$GLOBALS['strSyscheckProgressMessage'] = "Vérification des réglages du système…";
$GLOBALS['strError'] = "Erreur";
$GLOBALS['strWarning'] = "Avertissement";
$GLOBALS['strOK'] = "Bien";
$GLOBALS['strSyscheckName'] = "Vérifier nom";
$GLOBALS['strSyscheckValue'] = "Valeur actuelle";
$GLOBALS['strSyscheckStatus'] = "État";
$GLOBALS['strSyscheckSeeFullReport'] = "Show detailed system check";
$GLOBALS['strSyscheckSeeShortReport'] = "Show only errors and warnings";
$GLOBALS['strBrowserCookies'] = 'Browser Cookies';
$GLOBALS['strPHPConfiguration'] = 'PHP Configuration';
$GLOBALS['strCheckError'] = 'erreur';
$GLOBALS['strCheckErrors'] = 'erreurs';
$GLOBALS['strCheckWarning'] = 'avertissement';
$GLOBALS['strCheckWarnings'] = 'avertissements';

/** admin login step * */
$GLOBALS['strAdminLoginTitle'] = "Veuillez vous connecter en tant qu'administrateur de {$PRODUCT_NAME}";
$GLOBALS['strAdminLoginIntro'] = "Pour continuer, veuillez entrer les identifiants du compte administrateur pour {$PRODUCT_NAME}.";
$GLOBALS['strLoginProgressMessage'] = 'Connexion…';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "Provide your database";
$GLOBALS['strDbSetupIntro'] = "Fournissez les détails pour vous connecter à votre base de données {$PRODUCT_NAME}.";
$GLOBALS['strDbUpgradeTitle'] = "Votre base de données a été détectée";
$GLOBALS['strDbUpgradeIntro'] = "Les bases de données suivantes ont été détectées pour votre installation de {$PRODUCT_NAME}.
                                                   Veuillez vérifier que cela est correct, puis cliquez 'continuer' pour poursuivre.";
$GLOBALS['strDbProgressMessageInstall'] = 'Installation de la base de données…';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Mise à jour de la base de données…';
$GLOBALS['strDbSeeMoreFields'] = 'See more database fields...';
$GLOBALS['strDbTimeZoneWarning'] = "<p>As of this version {$PRODUCT_NAME} stores dates in UTC time rather than in server time.</p>
                                                   <p>If you want historical statistics to be displayed with the correct timezone, upgrade your data manually.  Learn more <a target='help' href='%s'>here</a>.
                                                      Your statistics values will remain accurate even if you leave your data untouched.
                                                   </p>";
$GLOBALS['strDbTimeZoneNoWarnings'] = "Ne pas afficher les avertissements de fuseau horaire à l'avenir";
$GLOBALS['strDBInstallSuccess'] = "Création de base de données réussie";
$GLOBALS['strDBUpgradeSuccess'] = "Mise à jour de base de données réussie";

$GLOBALS['strDetectedVersion'] = "Detected {$PRODUCT_NAME} version";

/** config step * */
$GLOBALS['strConfigureInstallTitle'] = "Configure your local {$PRODUCT_NAME} system administrator account";
$GLOBALS['strConfigureInstallIntro'] = "Please provide the desired login information for your local {$PRODUCT_NAME} system administrator account.";
$GLOBALS['strConfigureUpgradeTitle'] = "Configuration settings";
$GLOBALS['strConfigureUpgradeIntro'] = "Fournissez le chemin d'accès à l'installation précédente de {$PRODUCT_NAME}.";
$GLOBALS['strConfigSeeMoreFields'] = "See more configuration fields...";
$GLOBALS['strPreviousInstallTitle'] = "Installation d'avant";
$GLOBALS['strPathToPrevious'] = "Chemin d'accès vers l'installation d'avant";
$GLOBALS['strPathToPreviousError'] = "One or more plugin files couldn't be located, check the install.log file for more information";
$GLOBALS['strConfigureProgressMessage'] = "Configuration de {$PRODUCT_NAME}…";

/** jobs step * */
$GLOBALS['strJobsInstallTitle'] = "Tâches d'installation en cours";
$GLOBALS['strJobsInstallIntro'] = "L'installateur entreprend les dernières tâches d'installation.";
$GLOBALS['strJobsUpgradeTitle'] = "Tâches de mise à jour en cours";
$GLOBALS['strJobsUpgradeIntro'] = "L'installateur entreprend les dernières tâches de mise à jour.";
$GLOBALS['strJobsProgressInstallMessage'] = "Exécution des tâches d'installation …";
$GLOBALS['strJobsProgressUpgradeMessage'] = "Exécution des tâches de mise à jour …";

$GLOBALS['strPluginTaskChecking'] = "Vérification du greffon {$PRODUCT_NAME}";
$GLOBALS['strPluginTaskInstalling'] = "Installation du greffon {$PRODUCT_NAME}";
$GLOBALS['strPostInstallTaskRunning'] = "Tâche en cours";

/** finish step * */
$GLOBALS['strFinishInstallTitle'] = "Votre installation de {$PRODUCT_NAME} est terminée.";
$GLOBALS['strFinishUpgradeWithErrorsTitle'] = "Votre mise à jour de {$PRODUCT_NAME} est terminée. Veuillez vérifier les points signalés.";
$GLOBALS['strFinishUpgradeTitle'] = "Votre mise à jour de {$PRODUCT_NAME} est terminée.";
$GLOBALS['strFinishInstallWithErrorsTitle'] = "Votre installation de {$PRODUCT_NAME} est terminée. Veuillez vérifier les points signalés.";
$GLOBALS['strDetailedTaskErrorList'] = "Liste détaillée d'erreurs repérées";
$GLOBALS['strPluginInstallFailed'] = "Installation du greffon %s échouée:";
$GLOBALS['strTaskInstallFailed'] = "Une erreur s'est produite pendant la tâche d'installation %s:";
$GLOBALS['strContinueToLogin'] = "Click \"Continue\" to login to your {$PRODUCT_NAME} instance.";

$GLOBALS['strUnableCreateConfFile'] = "Nous ne pouvons pas créer votre fichier de configuration. Veuillez vérifier les permissions du dossier var {$PRODUCT_NAME}.";
$GLOBALS['strUnableUpdateConfFile'] = "Nous ne pouvons pas créer votre fichier de configuration. Veuillez vérifier les permissions du dossier var {$PRODUCT_NAME}, et vérifiez aussi les permissions du précédent fichier de configuration d'installation que vous avez copié dans ce dosier.";
$GLOBALS['strUnableToCreateAdmin'] = "Nous ne pouvons pas créer un compte administrateur de système. Votre base de données est-elle accessible?";
$GLOBALS['strTimezoneLocal'] = "{$PRODUCT_NAME} has detected that your PHP installation is returning \"System/Localtime\" as the timezone
of your server. This is because of a patch to PHP applied by some Linux distributions.
Unfortunately, this is not a valid PHP timezone. Please edit your php.ini file and set the \"date.timezone\"property to the correct value for your server.";

$GLOBALS['strInstallNonBlockingErrors'] = "An error occurred when performing installation tasks. Please check the 
<a class=\"show-errors\" href=\"#\">error list</a> and install log at \\'%s\\' for details.
You will still be able to login to your {$PRODUCT_NAME} instance.";
