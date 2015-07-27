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

/** welcome step * */
$GLOBALS['strInstallIntro'] = "Merci d'avoir choisi {$PRODUCT_NAME}. Cet assistant vous guidera pendant ses étapes d'installation.";
$GLOBALS['strUpgradeIntro'] = "Merci d'avoir choisi {$PRODUCT_NAME}. Cet assistant vous guidera pendant sa mise à jour.";
$GLOBALS['strInstallerHelpIntro'] = "Pour vous aider pendant l'installation de {$PRODUCT_NAME}, veuillez voir la <a href='{$PRODUCT_DOCSURL}' target='_blank'>documentation</a>.";

/** check step * */
$GLOBALS['strSystemCheckIntro'] = "L'assistant d'installation a vérifié les réglages de votre serveur pour que le processus d'installation puisse bien aboutir.
                                                  <br>Veuillez vérifier les points signalés pour terminer l'installation.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "La configuration de votre serveur ne correspond pas aux exigences de {$PRODUCT_NAME}.
                                                   <br>Pour poursuivre l'installation, veuillez résoudre toutes les erreurs.
                                                   Pour de l'aide, veuillez voir notre <a href='{$PRODUCT_DOCSURL}'>documentation</a> et <a href='http://{$PRODUCT_URL}/faq'>foire aux questions</a>";


$GLOBALS['strSyscheckProgressMessage'] = "Vérification des réglages du système…";
$GLOBALS['strError'] = "Erreur";
$GLOBALS['strWarning'] = "Avertissement";
$GLOBALS['strOK'] = "Bien";
$GLOBALS['strSyscheckName'] = "Vérifier nom";
$GLOBALS['strSyscheckValue'] = "Valeur actuelle";
$GLOBALS['strSyscheckStatus'] = "État";

/** admin login step * */
$GLOBALS['strAdminLoginIntro'] = "Pour continuer, veuillez entrer les identifiants du compte administrateur pour {$PRODUCT_NAME}.";
$GLOBALS['strLoginProgressMessage'] = 'Connexion…';

/** database step * */
$GLOBALS['strDbUpgradeIntro'] = "Les bases de données suivantes ont été détectées pour votre installation de {$PRODUCT_NAME}.
                                                   Veuillez vérifier que cela est correct, puis cliquez 'continuer' pour poursuivre.";
$GLOBALS['strDbProgressMessageInstall'] = 'Installation de la base de données…';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Mise à jour de la base de données…';
$GLOBALS['strDbTimeZoneNoWarnings'] = "Ne pas afficher les avertissements de fuseau horaire à l'avenir";
$GLOBALS['strDBInstallSuccess'] = "Création de base de données réussie";
$GLOBALS['strDBUpgradeSuccess'] = "Mise à jour de base de données réussie";


/** config step * */
$GLOBALS['strConfigureUpgradeIntro'] = "Fournissez le chemin d'accès à l'installation précédente de {$PRODUCT_NAME}.";

/** jobs step * */

$GLOBALS['strPostInstallTaskRunning'] = "Tâche en cours";

/** finish step * */
$GLOBALS['strFinishInstallTitle'] = "Votre installation de {$PRODUCT_NAME} est terminée.";
$GLOBALS['strFinishUpgradeWithErrorsTitle'] = "Votre mise à jour de {$PRODUCT_NAME} est terminée. Veuillez vérifier les points signalés.";
$GLOBALS['strFinishUpgradeTitle'] = "Votre mise à jour de {$PRODUCT_NAME} est terminée.";
$GLOBALS['strFinishInstallWithErrorsTitle'] = "Votre installation de {$PRODUCT_NAME} est terminée. Veuillez vérifier les points signalés.";
$GLOBALS['strDetailedTaskErrorList'] = "Liste détaillée d'erreurs repérées";
$GLOBALS['strPluginInstallFailed'] = "Installation du greffon %s échouée:";
$GLOBALS['strTaskInstallFailed'] = "Une erreur s'est produite pendant la tâche d'installation %s:";

$GLOBALS['strUnableCreateConfFile'] = "Nous ne pouvons pas créer votre fichier de configuration. Veuillez vérifier les permissions du dossier var {$PRODUCT_NAME}.";
$GLOBALS['strUnableUpdateConfFile'] = "Nous ne pouvons pas créer votre fichier de configuration. Veuillez vérifier les permissions du dossier var {$PRODUCT_NAME}, et vérifiez aussi les permissions du précédent fichier de configuration d'installation que vous avez copié dans ce dosier.";
$GLOBALS['strUnableToCreateAdmin'] = "Nous ne pouvons pas créer un compte administrateur de système. Votre base de données est-elle accessible?";
