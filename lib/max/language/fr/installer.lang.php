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

/** check step * */
$GLOBALS['strSystemCheckIntro'] = "L'assistant d'installation a vérifié les réglages de votre serveur pour que le processus d'installation puisse bien aboutir.
                                                  <br>Veuillez vérifier les points signalés pour terminer l'installation.";

$GLOBALS['strAppCheckDbIntegrityError'] = "Nous avons détecté des soucis d'intégration pour votre base de données. Il se peut que son agencement                                                   diffère de nos attentes. La personnalisation de votre base de données pourrait en être la cause.";

$GLOBALS['strSyscheckProgressMessage'] = "Vérification des réglages du système…";
$GLOBALS['strError'] = "Erreur";
$GLOBALS['strWarning'] = "Avertissement";
$GLOBALS['strOK'] = "Bien";
$GLOBALS['strSyscheckName'] = "Vérifier nom";
$GLOBALS['strSyscheckValue'] = "Valeur actuelle";
$GLOBALS['strSyscheckStatus'] = "État";
$GLOBALS['strCheckError'] = 'erreur';
$GLOBALS['strCheckErrors'] = 'erreurs';
$GLOBALS['strCheckWarning'] = 'avertissement';
$GLOBALS['strCheckWarnings'] = 'avertissements';

/** admin login step * */
$GLOBALS['strLoginProgressMessage'] = 'Connexion…';

/** database step * */
$GLOBALS['strDbUpgradeTitle'] = "Votre base de données a été détectée";
$GLOBALS['strDbProgressMessageInstall'] = 'Installation de la base de données…';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Mise à jour de la base de données…';
$GLOBALS['strDbTimeZoneNoWarnings'] = "Ne pas afficher les avertissements de fuseau horaire à l'avenir";
$GLOBALS['strDBInstallSuccess'] = "Création de base de données réussie";
$GLOBALS['strDBUpgradeSuccess'] = "Mise à jour de base de données réussie";


/** config step * */
$GLOBALS['strPreviousInstallTitle'] = "Installation d'avant";

/** jobs step * */
$GLOBALS['strJobsInstallTitle'] = "Tâches d'installation en cours";
$GLOBALS['strJobsInstallIntro'] = "L'installateur entreprend les dernières tâches d'installation.";
$GLOBALS['strJobsUpgradeTitle'] = "Tâches de mise à jour en cours";
$GLOBALS['strJobsUpgradeIntro'] = "L'installateur entreprend les dernières tâches de mise à jour.";
$GLOBALS['strJobsProgressInstallMessage'] = "Exécution des tâches d'installation …";
$GLOBALS['strJobsProgressUpgradeMessage'] = "Exécution des tâches de mise à jour …";

$GLOBALS['strPostInstallTaskRunning'] = "Tâche en cours";

/** finish step * */
$GLOBALS['strDetailedTaskErrorList'] = "Liste détaillée d'erreurs repérées";
$GLOBALS['strPluginInstallFailed'] = "Installation du greffon %s échouée:";
$GLOBALS['strTaskInstallFailed'] = "Une erreur s'est produite pendant la tâche d'installation %s:";

$GLOBALS['strUnableToCreateAdmin'] = "Nous ne pouvons pas créer un compte administrateur de système. Votre base de données est-elle accessible?";

