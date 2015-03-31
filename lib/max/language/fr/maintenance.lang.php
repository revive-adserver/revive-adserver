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

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "La maintenance automatique est activée, mais elle n'a pas été déclenchée. La maintenance automatique est déclenchée uniquement lorsque {$PRODUCT_NAME} distribue des bannières. Pour de meilleures performances, vous devriez paramétrer la <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>maintenance planifiée</a>.";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "La maintenance automatique est actuellement désactivée, donc quand {$PRODUCT_NAME} distribuera des bannières, la maintenance ne sera pas déclenchée. Pour de meilleures performances, vous devriez paramétrer la <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>maintenance planifiée</a>. Cependant, si vous n'envisagez pas de paramétrer la <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>maintenance planifiée</a>, vous <i>devez</i> <a href='account-settings-maintenance.php'>activer la maintenance automatique</a> afin de vous assurer que {$PRODUCT_NAME} fonctionne.";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "La maintenance automatique est activée et sera déclenchée, comme il est nécessaire, quand {$PRODUCT_NAME} distribuera des bannières. Cependant, pour de meilleures performances, vous devriez paramétrer la <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>maintenance planifiée</a>.";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "Cependant, la maintenance automatique a été désactivée récemment. Afin de vous assurer du bon fonctionnement de {$PRODUCT_NAME}, vous devriez paramétrer la <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>maintenance planifiée</a> ou <a href='account-settings-maintenance.php'>réactiver la maintenance automatique</a>.<br><br>Pour de meilleures performances, vous devriez paramétrer la <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>maintenance planifiée</a>.";

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
$GLOBALS['strBannerCacheExplaination'] = "    Le cache des bannières en base de données est utilisé pour accélérer la distribution des bannières<br />
    Ce cache a besoin d'être mis à jour quand :
    <ul>
        <li>Vous mettez à jour votre version d'OpenX</li>
        <li>Vous déplacez votre installation OpenX vers un autre serveur</li>
    </ul>";

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
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} stocke maintenant toutes les données de la base de données au format UTF-8.<br />Quand c'était possible, vos données auront été automatiquement converties vers cet encodage.<br />Si après la mise à jour vous trouvez des caractères corrompus et que vous connaissez l'encodage utilisé, vous pourrez utiliser cet outil pour convertir les données depuis ce format vers l'UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Convertir depuis cet encodage :";
$GLOBALS['strEncodingConvertTest'] = "Tester la conversion";
$GLOBALS['strConvertThese'] = "Les données suivantes seront changées si vous continuez";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Recherche de mises à jour. Veuillez patienter…";
$GLOBALS['strAvailableUpdates'] = "Mise à jour disponibles";
$GLOBALS['strDownloadZip'] = "Télécharger (.zip)";
$GLOBALS['strDownloadGZip'] = "Télécharger (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "Une nouvelle version de {$PRODUCT_NAME} est disponible.

Voulez-vous obtenir plus d'informations
au sujet de cette mise à jour ?";
$GLOBALS['strUpdateAlertSecurity'] = "Une nouvelle version de {$PRODUCT_NAME} est disponible.

Il est hautement recommandé de mettre à jour
aussi vite que possible, car cette
version contient un ou plusieurs correctifs de sécurité.";

$GLOBALS['strUpdateServerDown'] = "Pour une raison inconnue, il est impossible de récupérer <br>les informations concernant de possibles mises à jour. Veuillez réessayer plus tard.";

$GLOBALS['strNoNewVersionAvailable'] = " Votre version de {$PRODUCT_NAME} est à jour. Il n'y a actuellement aucune mise à jour disponible.";

$GLOBALS['strServerCommunicationError'] = "<b>La communication avec le serveur de mise à jour a expiré, donc {$PRODUCT_NAME} n'est pas en mesure de vérifier si une nouvelle version est disponible pour le moment. Veuillez essayer à nouveau plus tard.</b>";

$GLOBALS['strCheckForUpdatesDisabled'] = "<b>La recherche de mises à jour est désactivée. Â Veuillez l'activerÂ via l'écran <a href='account-settings-update.php'>paramètres de mise à jour</a>.</b>";

$GLOBALS['strNewVersionAvailable'] = " <b>Une nouvelle version de {$PRODUCT_NAME} est disponible.</b><br /> Il est recommandé d\\'installer cette mise à jour,
 car elle pourrait corriger quelques problèmes existant actuellement et ajoutera de nouvelles fonctionnalités. Pour plus d\\'informations
 concernant la mise à jour, veuillez lire la documentation incluse dans les fichiers ci-dessous.";

$GLOBALS['strSecurityUpdate'] = " <b>Il est hautement recommandé d\\'installer cette mise à jour aussi vite que possible, car elle contient quelques
 correctifs de sécurité.</b> La version de {$PRODUCT_NAME} que vous utilisez actuellement peut être
 vulnérable à certaines attaques et n\\'est sans doute pas sécurisée. Pour plus d\\'informations
 concernant les mises à jour, veuillez lire la documentation incluse dans les fichiers ci-dessous.";

$GLOBALS['strNotAbleToCheck'] = " <b>En raison du fait que l\\'extension XML n\\'est pas disponible sur votre serveur, {$PRODUCT_NAME}
    ne peut pas vérifier si une nouvelle version est disponible.</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = " Si vous voulez savoir si une nouvelle version est disponible, veuillez visiter notre site web.";

$GLOBALS['strClickToVisitWebsite'] = "Cliquez ici pour visiter notre site web";
$GLOBALS['strCurrentlyUsing'] = "Vous utilisez actuellement";
$GLOBALS['strRunningOn'] = "exécuté sur";
$GLOBALS['strAndPlain'] = "et";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "Limitations de distribution";
$GLOBALS['strAllBannerChannelCompiled'] = "Toutes les valeurs de limitations compilées de bannières/canaux ont été recompilées";
$GLOBALS['strBannerChannelResult'] = "Voici les résultats de la validation des limitations compilées de bannières/canaux";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Toutes les limitations compilées de canaux sont valides";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Toutes les limitations compilées de bannières sont valides";
$GLOBALS['strErrorsFound'] = "Erreurs trouvées";
$GLOBALS['strRepairCompiledLimitations'] = "Quelques inconsistances ont été trouvées ci-dessus, vous pouvez les réparer en utilisant le bouton ci-dessous, ceci recompilera les limitations compilées pour chaque bannière/canal du système<br />";
$GLOBALS['strRecompile'] = "Recompiler";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "Dans certaines circonstances, le moteur de distribution peut entrer en conflit avec les limitations stockées pour les bannières et les canaux, utilisez le lien suivant pour valider les limitations dans la base de données";
$GLOBALS['strCheckACLs'] = "Vérifier les limitations";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "Dans certaines circonstances, le moteur de distribution peut entrer en conflit avec les codes ajoutés stockés pour les suiveurs, utilisez le lien suivant pour valider les codes ajoutés dans la base de données";
$GLOBALS['strCheckAppendCodes'] = "Vérifier les codes ajoutés";
$GLOBALS['strAppendCodesRecompiled'] = "Toutes les valeurs de codes ajoutés compilées ont été recompilées.";
$GLOBALS['strAppendCodesResult'] = "Voici les résultats de la validation des codes ajoutés compilés";
$GLOBALS['strAppendCodesValid'] = "Tous les codes ajoutés compilés des suiveurs sont valides";
$GLOBALS['strRepairAppenedCodes'] = "Quelques inconsistances ont été trouvées ci-dessus, vous pouvez les réparer en utilisant le bouton ci-dessous, ceci recompilera les codes ajoutés pour chaque suiveur du système";

$GLOBALS['strPlugins'] = "Extensions";
$GLOBALS['strPluginsPrecis'] = "Diagnostique et répare les problèmes des plugins OpenX";

$GLOBALS['strMenusPrecis'] = "Reconstruire le cache du menu";
$GLOBALS['strMenusCachedOk'] = "Le cache du menu a été reconstruit";
