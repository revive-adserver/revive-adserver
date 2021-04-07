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

// Main strings
$GLOBALS['strChooseSection'] = "Opération de maintenance";
$GLOBALS['strAppendCodes'] = "Codes ajoutés";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>La maintenance planifiée n'a pas été lancée au cours de la dernière heure. Cela pourrait signifier que vous ne l'avez pas paramétrée correctement.</b>";





$GLOBALS['strScheduledMantenaceRunning'] = "<b>La maintenance planifiée fonctionne correctement.</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>La maintenance automatique fonctionne correctement.</b>";

$GLOBALS['strAutoMantenaceEnabled'] = "Cependant, la maintenance automatique est toujours activée. Pour de meilleures performances, vous devriez <a href='account-settings-maintenance.php'>désactiver la maintenance automatique</a>.";

// Priority
$GLOBALS['strRecalculatePriority'] = "Recalculer les priorités";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Vérifier le cache des bannières";
$GLOBALS['strBannerCacheErrorsFound'] = "La vérification du cache des bannières en base de données a trouvé quelques erreurs. Ces bannières ne fonctionneront pas tant que vous ne les aurez pas corrigées à la main.";
$GLOBALS['strBannerCacheOK'] = "Aucune erreur n'a été détectée. Votre cache de bannières en base de données est à jour";
$GLOBALS['strBannerCacheDifferencesFound'] = "La vérification du cache des bannières en base de données a trouvé que votre cache n'est pas à jour et nécessite une reconstruction. Cliquez ici pour mettre à jour automatiquement votre cache.";
$GLOBALS['strBannerCacheRebuildButton'] = "Reconstruire";
$GLOBALS['strRebuildDeliveryCache'] = "Reconstruire le cache des bannières en base de données";

// Cache
$GLOBALS['strCache'] = "Cache de distribution";
$GLOBALS['strDeliveryCacheSharedMem'] = " La mémoire partagée est actuellement utilisée pour le stockage du cache de distribution.";
$GLOBALS['strDeliveryCacheDatabase'] = " La base de données est actuellement utilisée pour le stockage du cache de distribution.";
$GLOBALS['strDeliveryCacheFiles'] = " Le cache de distribution est actuellement stocké dans plusieurs fichiers sur votre serveur.";

// Storage
$GLOBALS['strStorage'] = "Stockage";
$GLOBALS['strMoveToDirectory'] = "Déplacer les images stockées dans la base de données vers un répertoire";
$GLOBALS['strStorageExplaination'] = " Les images utilisées par les bannières locales sont stockées dans la base de données ou dans un répertoire. Si vous stockez les images dans
 un répertoire, la charge de la base de données sera réduite et cela provoquera une accélération.";

// Encoding
$GLOBALS['strEncoding'] = "Encodage";
$GLOBALS['strEncodingConvertFrom'] = "Convertir depuis cet encodage :";
$GLOBALS['strEncodingConvertTest'] = "Tester la conversion";
$GLOBALS['strConvertThese'] = "Les données suivantes seront changées si vous continuez";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Recherche de mises à jour. Veuillez patienter…";
$GLOBALS['strAvailableUpdates'] = "Mise à jour disponibles";
$GLOBALS['strDownloadZip'] = "Télécharger (.zip)";
$GLOBALS['strDownloadGZip'] = "Télécharger (.tar.gz)";


$GLOBALS['strUpdateServerDown'] = "Pour une raison inconnue, il est impossible de récupérer <br>les informations concernant de possibles mises à jour. Veuillez réessayer plus tard.";



$GLOBALS['strCheckForUpdatesDisabled'] = "<b>La recherche de mises à jour est désactivée. Â Veuillez l'activerÂ via l'écran <a href='account-settings-update.php'>paramètres de mise à jour</a>.</b>";




$GLOBALS['strForUpdatesLookOnWebsite'] = " Si vous voulez savoir si une nouvelle version est disponible, veuillez visiter notre site web.";

$GLOBALS['strClickToVisitWebsite'] = "Cliquez ici pour visiter notre site web";
$GLOBALS['strCurrentlyUsing'] = "Vous utilisez actuellement";
$GLOBALS['strRunningOn'] = "exécuté sur";
$GLOBALS['strAndPlain'] = "et";

//  Deliver Limitations
$GLOBALS['strErrorsFound'] = "Erreurs trouvées";
$GLOBALS['strRepairCompiledLimitations'] = "Quelques inconsistances ont été trouvées ci-dessus, vous pouvez les réparer en utilisant le bouton ci-dessous, ceci recompilera les limitations compilées pour chaque bannière/canal du système<br />";
$GLOBALS['strRecompile'] = "Recompiler";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "Dans certaines circonstances, le moteur de distribution peut entrer en conflit avec les codes ajoutés stockés pour les suiveurs, utilisez le lien suivant pour valider les codes ajoutés dans la base de données";
$GLOBALS['strCheckAppendCodes'] = "Vérifier les codes ajoutés";
$GLOBALS['strAppendCodesRecompiled'] = "Toutes les valeurs de codes ajoutés compilées ont été recompilées.";
$GLOBALS['strAppendCodesResult'] = "Voici les résultats de la validation des codes ajoutés compilés";
$GLOBALS['strAppendCodesValid'] = "Tous les codes ajoutés compilés des suiveurs sont valides";
$GLOBALS['strRepairAppenedCodes'] = "Quelques inconsistances ont été trouvées ci-dessus, vous pouvez les réparer en utilisant le bouton ci-dessous, ceci recompilera les codes ajoutés pour chaque suiveur du système";

$GLOBALS['strPlugins'] = "Extensions";

$GLOBALS['strMenusPrecis'] = "Reconstruire le cache du menu";
$GLOBALS['strMenusCachedOk'] = "Le cache du menu a été reconstruit";
