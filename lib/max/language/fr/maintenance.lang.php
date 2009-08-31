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


// Main strings
$GLOBALS['strChooseSection']			= 'Opération de maintenance';


// Priority
$GLOBALS['strRecalculatePriority']		= 'Recalculer les priorités';
$GLOBALS['strHighPriorityCampaigns']		= 'Campagnes avec une priorité haute';
$GLOBALS['strAdViewsAssigned']			= 'Nbre d\'affichages assignés';
$GLOBALS['strLowPriorityCampaigns']		= 'Campagnes avec une priorité basse';
$GLOBALS['strPredictedAdViews']			= 'Nbre d\'affichages prévus';
$GLOBALS['strPriorityDaysRunning']		= 'Il y a actuellement {days} jours de statistiques disponibles à partir desquels '.MAX_PRODUCT_NAME.' peut effectuer ses prévisions. ';
$GLOBALS['strPriorityBasedLastWeek']		= 'Les prévisions sont basées sur les données de cette semaine et de la semaine passée. ';
$GLOBALS['strPriorityBasedLastDays']		= 'Les prévisions sont basées sur les données des derniers jours. ';
$GLOBALS['strPriorityBasedYesterday']		= 'Les prévisions sont basées sur les données d\'hier. ';
$GLOBALS['strPriorityNoData']			= 'Il n\'y a pas suffisament de statistiques disponibles afin d\'effectuer des prévisions réalistes concernant le nombre d\'affichages que ce serveur de publicités va effectuer aujourd\'hui. L\'assignement des objectifs ne sera basé que sur des statistiques en temps réel. ';
$GLOBALS['strPriorityEnoughAdViews']		= 'Il devrait y avoir suffisament d\'affichages aujourd\'hui pour satisfaire complètement les objectifs de toutes les campagnes haute priorité. ';
$GLOBALS['strPriorityNotEnoughAdViews']		= 'Il n\'est pas certains qu\'il y aura assez d\'affichages aujourd\'hui pour satisfaire les objectifs de toutes les campagnes haute priorité. C\'est pourquoi toutes les campagnes basse priorité sont temporairement désactivées. ';


// Banner cache
$GLOBALS['strRebuildBannerCache']		= 'Reconstuire le cache des bannières';
$GLOBALS['strBannerCacheExplaination']		= '
    Le cache des bannières en base de données est utilisé pour accélérer la distribution des bannières<br />
    Ce cache a besoin d\'être mis à jour quand :
    <ul>
        <li>Vous mettez à jour votre version d\'OpenX</li>
        <li>Vous déplacez votre installation OpenX vers un autre serveur</li>
    </ul>
';


// Cache
$GLOBALS['strCache']				= 'Cache de distribution';
$GLOBALS['strAge']				= 'Âge';
$GLOBALS['strRebuildDeliveryCache']		= 'Reconstruire le cache des bannières en base de données';
$GLOBALS['strDeliveryCacheExplaination']	= '
	Le cache de distribution est utilisé pour accélérer la distribution des bannières. Il contient une copie de
	toutes les bannières qui sont liées à la zone, ce qui économise nombre de requêtes à la base lorsque la bannière
	doit être délivrée au visiteur. Le cache est habituellement reconstruit chaque fois qu\'une zone ou une de ses
	bannières est modifiée, il est néanmoins possible que le cache ne soit plus à jour. C\'est pourquoi le cache est
	automatiquement reconstruit chaque heure; il est aussi possible de le reconstruire à la demande.
';
$GLOBALS['strDeliveryCacheSharedMem']		= '
 La mémoire partagée est actuellement utilisée pour le stockage du cache de distribution.
';
$GLOBALS['strDeliveryCacheDatabase']		= '
 La base de données est actuellement utilisée pour le stockage du cache de distribution.
';
$GLOBALS['strDeliveryCacheFiles']               = '
 Le cache de distribution est actuellement stocké dans plusieurs fichiers sur votre serveur.
';

// Storage
$GLOBALS['strStorage']				= 'Stockage';
$GLOBALS['strMoveToDirectory']			= 'Déplacer les images stockées dans la base de données vers un répertoire';
$GLOBALS['strStorageExplaination']		= '
 Les images utilisées par les bannières locales sont stockées dans la base de données ou dans un répertoire. Si vous stockez les images dans
 un répertoire, la charge de la base de données sera réduite et cela provoquera une accélération.
';


// Storage
$GLOBALS['strStatisticsExplaination']	= '
 Vous avez activé les <i>statistiques compactes</i>, mais vos anciennes statistiques sont toujours en format complet.
 Voulez-vous convertir vos statistiques complètes au nouveau format compact ?
';


// Product Updates
$GLOBALS['strSearchingUpdates']			= 'Recherche de mises à jour. Veuillez patienter…';
$GLOBALS['strAvailableUpdates']			= 'Mise à jour disponibles';
$GLOBALS['strDownloadZip']			= 'Télécharger (.zip)';
$GLOBALS['strDownloadGZip']			= 'Télécharger (.tar.gz)';

$GLOBALS['strUpdateAlert']			= 'Une nouvelle version d\'\". '.MAX_PRODUCT_NAME.' .\" est disponible.

Voulez-vous obtenir plus d\'informations
au sujet de cette mise à jour ?';
$GLOBALS['strUpdateAlertSecurity']		= 'Une nouvelle version d\'\". '.MAX_PRODUCT_NAME.' .\" est disponible.

Il est hautement recommandé de mettre à jour
aussi vite que possible, car cette
version contient un ou plusieurs correctifs de sécurité.';

$GLOBALS['strUpdateServerDown']			= 'Pour une raison inconnue, il est impossible de récupérer <br>les informations concernant de possibles mises à jour. Veuillez réessayer plus tard.';

$GLOBALS['strNoNewVersionAvailable']		= '
 Votre version d\'\". '.MAX_PRODUCT_NAME.' .\" est à jour. Il n\'y a actuellement aucune mise à jour disponible.
';

$GLOBALS['strNewVersionAvailable']		= '
 <b>Une nouvelle version d\'\". '.MAX_PRODUCT_NAME.' .\" est disponible.</b><br /> Il est recommandé d\'installer cette mise à jour,
 car elle pourrait corriger quelques problèmes existant actuellement et ajoutera de nouvelles fonctionnalités. Pour plus d\'informations
 concernant la mise à jour, veuillez lire la documentation incluse dans les fichiers ci-dessous.
';

$GLOBALS['strSecurityUpdate']			= '
 <b>Il est hautement recommandé d\'installer cette mise à jour aussi vite que possible, car elle contient quelques
 correctifs de sécurité.</b> La version d\'\". '.MAX_PRODUCT_NAME.' .\" que vous utilisez actuellement peut être
 vulnérable à certaines attaques et n\'est sans doute pas sécurisée. Pour plus d\'informations
 concernant les mises à jour, veuillez lire la documentation incluse dans les fichiers ci-dessous.
';

$GLOBALS['strNotAbleToCheck']			= '
 <b>En raison du fait que l\'extension XML n\'est pas disponible sur votre serveur, \". '.MAX_PRODUCT_NAME.' .\"
    ne peut pas vérifier si une nouvelle version est disponible.</b>
';

$GLOBALS['strForUpdatesLookOnWebsite']		= '
 Si vous voulez savoir si une nouvelle version est disponible, veuillez visiter notre site web.
';

$GLOBALS['strClickToVisitWebsite']		= 'Cliquez ici pour visiter notre site web';
$GLOBALS['strCurrentlyUsing'] 			= 'Vous utilisez actuellement';
$GLOBALS['strRunningOn']			= 'exécuté sur';
$GLOBALS['strAndPlain']				= 'et';

// Stats conversion
$GLOBALS['strConverting']			= 'Conversion';
$GLOBALS['strConvertingStats']			= 'Conversion des statistiques...';
$GLOBALS['strConvertStats']			= 'Convertir les statistiques';
$GLOBALS['strConvertAdViews']			= 'affichages convertis,';
$GLOBALS['strConvertAdClicks']			= 'clics convertis...';
$GLOBALS['strConvertNothing']			= 'Rien à convertir...';
$GLOBALS['strConvertFinished']			= 'Fini...';

$GLOBALS['strConvertExplaination']		= '
	Vous utilisez actuellement le format compact pour stocker vos statistiques, mais il<br>
	y a encore quelques statistiques au format détaillé. Aussi longtemps que les statistiques<br>
	seront en format détaillé, le format compact ne sera pas utilisé pour voir ces pages.<br><br>
	Avant de convertir les statistiques, faite une sauvegarde de la base de données !!<br>
	Souhaitez vous convertir vos statistiques détaillées avec le nouveau format compact ? <br>
';

$GLOBALS['strConvertingExplaination']	= '
	Toutes les statistiques détaillées restante sont en train d\'être converties au format<br>
	compact. Selon le nombre d\'affichages stockés au format détaillé, cela peut prendre<br>
	quelques minutes. Merci d\'attendre jusqu\'à ce que la conversion soit fini, avant de<br>
	visiter d\'autres pages. Ci-dessous vous trouverez un journal des modifications faites<br>
	à la base de données.<br>
';

$GLOBALS['strConvertFinishedExplaination']= '
	La conversion des statistiques du format détaillé vers le format compact est réussie, et les données<br>
	devrait pouvoir être utilisables à nouveau. Ci-dessous vous trouverez un journal des <br>
	modifications faites à la base de données.
';




// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strCheckBannerCache'] = "Vérifier le cache des bannières";
$GLOBALS['strBannerCacheErrorsFound'] = "La vérification du cache des bannières en base de données a trouvé quelques erreurs. Ces bannières ne fonctionneront pas tant que vous ne les aurez pas corrigées à la main.";
$GLOBALS['strBannerCacheOK'] = "Aucune erreur n'a été détectée. Votre cache de bannières en base de données est à jour";
$GLOBALS['strBannerCacheDifferencesFound'] = "La vérification du cache des bannières en base de données a trouvé que votre cache n'est pas à jour et nécessite une reconstruction. Cliquez ici pour mettre à jour automatiquement votre cache.";
$GLOBALS['strBannerCacheRebuildButton'] = "Reconstruire";
$GLOBALS['strBannerCacheFixed'] = "La reconstruction du cache des bannières en base de données a été terminée avec succès. Votre cache en base de données est maintenant à jour.";
$GLOBALS['strEncoding'] = "Encodage";
$GLOBALS['strEncodingExplaination'] = "". MAX_PRODUCT_NAME ." stocke maintenant toutes les données de la base de données au format UTF-8.<br />Quand c'était possible, vos données auront été automatiquement converties vers cet encodage.<br />Si après la mise à jour vous trouvez des caractères corrompus et que vous connaissez l'encodage utilisé, vous pourrez utiliser cet outil pour convertir les données depuis ce format vers l'UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Convertir depuis cet encodage :";
$GLOBALS['strEncodingConvert'] = "Convertir";
$GLOBALS['strEncodingConvertTest'] = "Tester la conversion";
$GLOBALS['strConvertThese'] = "Les données suivantes seront changées si vous continuez";
$GLOBALS['strAppendCodes'] = "Codes ajoutés";
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>La maintenance planifiée n'a pas été lancée au cours de la dernière heure. Cela pourrait signifier que vous ne l'avez pas paramétrée correctement.</b>";
$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "La maintenance automatique est activée, mais elle n'a pas été déclenchée. La maintenance automatique est déclenchée uniquement lorsque ". MAX_PRODUCT_NAME ." distribue des bannières. Pour de meilleures performances, vous devriez paramétrer la <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>maintenance planifiée</a>.";
$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "La maintenance automatique est actuellement désactivée, donc quand ". MAX_PRODUCT_NAME ." distribuera des bannières, la maintenance ne sera pas déclenchée. Pour de meilleures performances, vous devriez paramétrer la <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>maintenance planifiée</a>. Cependant, si vous n'envisagez pas de paramétrer la <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>maintenance planifiée</a>, vous <i>devez</i> <a href='account-settings-maintenance.php'>activer la maintenance automatique</a> afin de vous assurer que ". MAX_PRODUCT_NAME ." fonctionne.";
$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "La maintenance automatique est activée et sera déclenchée, comme il est nécessaire, quand ". MAX_PRODUCT_NAME ." distribuera des bannières. Cependant, pour de meilleures performances, vous devriez paramétrer la <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>maintenance planifiée</a>.";
$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "Cependant, la maintenance automatique a été désactivée récemment. Afin de vous assurer du bon fonctionnement de ".MAX_PRODUCT_NAME.", vous devriez paramétrer la <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>maintenance planifiée</a> ou <a href='account-settings-maintenance.php'>réactiver la maintenance automatique</a>.<br><br>Pour de meilleures performances, vous devriez paramétrer la <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>maintenance planifiée</a>.";
$GLOBALS['strScheduledMantenaceRunning'] = "<b>La maintenance planifiée fonctionne correctement.</b>";
$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>La maintenance automatique fonctionne correctement.</b>";
$GLOBALS['strAutoMantenaceEnabled'] = "Cependant, la maintenance automatique est toujours activée. Pour de meilleures performances, vous devriez <a href='account-settings-maintenance.php'>désactiver la maintenance automatique</a>.";
$GLOBALS['strAutoMaintenanceDisabled'] = "La maintenance automatique est désactivée.";
$GLOBALS['strAutoMaintenanceEnabled'] = "La maintenance automatique est activée. Pour de meilleures performances il est recommandé de <a href='settings-admin.php'>désactiver la maintenance automatique</a>.";
$GLOBALS['strCheckACLs'] = "Vérifier les limitations";
$GLOBALS['strScheduledMaintenance'] = "La maintenance planifiée semble fonctionner correctement.";
$GLOBALS['strAutoMaintenanceEnabledNotTriggered'] = "La maintenance automatique est activée, mais elle n'a pas été déclenchée. Notez que la maintenance automatique ne se déclenche que quand ". MAX_PRODUCT_NAME ." distribue des bannières.";
$GLOBALS['strAutoMaintenanceBestPerformance'] = "Pour de meilleures performances il est recommandé de paramétrer la <a href='". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>maintenance planifiée</a>";
$GLOBALS['strAutoMaintenanceEnabledWilltTrigger'] = "La maintenance automatique est activée et déclenchera la maintenance à chaque heure.";
$GLOBALS['strAutoMaintenanceDisabledMaintenanceRan'] = "La maintenance automatique est aussi désactivée mais une tâche de maintenance a été lancée récemment. Afin de vous assuerer que ". MAX_PRODUCT_NAME ." fonctionne correctement vous devriez paramétrer la <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>maintenance planifiée</a> ou <a href='settings-admin.php'>activer la maintenance automatique</a>.";
$GLOBALS['strAutoMaintenanceDisabledNotTriggered'] = "Aussi, la maintenance automatique est désactivée, donc quand ". MAX_PRODUCT_NAME ." distribue des bannières, la maintenance n'est pas déclenchée. Si vous ne prévoyez pas de lancer une <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>maintenance planifiée</a>, vous devez <a href='settings-admin.php'>activer la maintenance automatique</a> afin de vous assurer que ". MAX_PRODUCT_NAME ." fonctionne correctement.";
$GLOBALS['strAllBannerChannelCompiled'] = "Toutes les valeurs de limitations compilées de bannières/canaux ont été recompilées";
$GLOBALS['strBannerChannelResult'] = "Voici les résultats de la validation des limitations compilées de bannières/canaux";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Toutes les limitations compilées de canaux sont valides";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Toutes les limitations compilées de bannières sont valides";
$GLOBALS['strErrorsFound'] = "Erreurs trouvées";
$GLOBALS['strRepairCompiledLimitations'] = "Quelques inconsistances ont été trouvées ci-dessus, vous pouvez les réparer en utilisant le bouton ci-dessous, ceci recompilera les limitations compilées pour chaque bannière/canal du système<br />";
$GLOBALS['strRecompile'] = "Recompiler";
$GLOBALS['strAppendCodesDesc'] = "Dans certaines circonstances, le moteur de distribution peut entrer en conflit avec les codes ajoutés stockés pour les suiveurs, utilisez le lien suivant pour valider les codes ajoutés dans la base de données";
$GLOBALS['strCheckAppendCodes'] = "Vérifier les codes ajoutés";
$GLOBALS['strAppendCodesRecompiled'] = "Toutes les valeurs de codes ajoutés compilées ont été recompilées.";
$GLOBALS['strAppendCodesResult'] = "Voici les résultats de la validation des codes ajoutés compilés";
$GLOBALS['strAppendCodesValid'] = "Tous les codes ajoutés compilés des suiveurs sont valides";
$GLOBALS['strRepairAppenedCodes'] = "Quelques inconsistances ont été trouvées ci-dessus, vous pouvez les réparer en utilisant le bouton ci-dessous, ceci recompilera les codes ajoutés pour chaque suiveur du système";
$GLOBALS['strScheduledMaintenanceNotRun'] = "La maintenance planifiée n'a pas été lancée au cours de la dernière heure. Cela pourrait signifier que vous ne l'avez pas paramétrée correctement.";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "Dans certaines circonstances, le moteur de distribution peut entrer en conflit avec les limitations stockées pour les bannières et les canaux, utilisez le lien suivant pour valider les limitations dans la base de données";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strPluginsPrecis'] = "Diagnostique et répare les problèmes des plugins OpenX";
$GLOBALS['strPluginsOk'] = "Pas de problèmes trouvés";
$GLOBALS['strMenus'] = "Menus";
$GLOBALS['strMenusPrecis'] = "Reconstruire le cache du menu";
$GLOBALS['strMenusCachedOk'] = "Le cache du menu a été reconstruit";
$GLOBALS['strMenusCachedErr'] = "Erreurs durant la reconstruction du cache de menu";
$GLOBALS['strServerCommunicationError'] = "<b>La communication avec le serveur de mise à jour a expiré, donc ".MAX_PRODUCT_NAME." n'est pas en mesure de vérifier si une nouvelle version est disponible pour le moment. Veuillez essayer à nouveau plus tard.</b>";
$GLOBALS['strCheckForUpdatesDisabled'] = "<b>La recherche de mises à jour est désactivée. Â Veuillez l'activerÂ via l'écran <a href='account-settings-update.php'>paramètres de mise à jour</a>.</b>";
?>