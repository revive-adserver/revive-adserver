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


// Main strings
$GLOBALS['strChooseSection']				= "Choisissez une section";


// Priority
$GLOBALS['strRecalculatePriority']			= "Recalculer les priorités";
$GLOBALS['strHighPriorityCampaigns']		= "Campagnes avec une priorité haute";
$GLOBALS['strAdViewsAssigned']			= "Affichages assignés";
$GLOBALS['strLowPriorityCampaigns']			= "Campagnes avec une priorité basse";
$GLOBALS['strPredictedAdViews']			= "Affichages prévus";
$GLOBALS['strPriorityDaysRunning']			= "Il y a actuellement {days} jours de statistiques disponibles à partir desquels phpAdsNew peut effectuer ses prévisions. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Les prévisions sont basées sur les données de cette semaine et de la semaine passée. ";
$GLOBALS['strPriorityBasedLastDays']		= "Les prévisions sont basées sur les données des derniers jours. ";
$GLOBALS['strPriorityBasedYesterday']		= "Les prévisions sont basées sur les données d'hier. ";
$GLOBALS['strPriorityNoData']				= "Il n'y a pas assez de données disponible pour effectuer des prévisions réalistes à propos du nombre d'affichages que ce serveur de publicités va enregistrer aujourd'hui. L'assignement des priorités ne sera basé que sur des statistiques en temps réel. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Il devrait y avoir suffisament d'affichages pour satisfaire complètement les objectifs de toutes les campagnes haute priorité. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Il n'est pas certains qu'il y aura assez d'affichages aujourd'hui pour satisfaire les objectifs de toutes les campagnes haute priorité. C'est pourquoi toutes les campagnes basse priorité sont temporairement désactivées. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']			= "Reconstuire le cache des bannières";
$GLOBALS['strBannerCacheExplaination']		= "
	Le cache des bannières contient une copie du code HTML qui est utilisé pour afficher la bannière. En utilisant
	ce cache de bannière, il est possible d'accélérer la distribution des bannières, car le code HTML n'a plus
	besoin d'être généré chaque fois qu'une bannière est demandée. Parce que le cache des bannière contient des
	liens codés en dur, il a besoin d'être reconstruit à chaque fois que phpAdsNew est déplacé sur le serveur Web.
";


// Zone cache
$GLOBALS['strZoneCache']				= "Cache des zones";
$GLOBALS['strAge']					= "Age";
$GLOBALS['strRebuildZoneCache']			= "Reconstruire le cache des zones";
$GLOBALS['strZoneCacheExplaination']		= "
	Le cache des zones est utilisé pour accélérer la distribution des bannières qui sont liées aux zones.
	Le cache  des zones contient une copie de toutes les bannières qui sont liées à la zone, ce qui évite
	nombre de requêtes à la base quand la bannière doit être délivrée au visiteur. Le cache est habituellement
	reconstruit chaque fois qu'une zone ou une de ses bannières est modifiée, il est néanmoins possible que le cache
	deviennent périmé. C'est pourquoi le cache des zones sera automatiquement reconstruit toutes les {seconds} 
	secondes, mais il est aussi possible de le reconstruire à la demande.
";


// Storage
$GLOBALS['strStorage']					= "Stockage";
$GLOBALS['strMoveToDirectory']			= "Déplacer les images stockées dans la base de données vers un répertoire";
$GLOBALS['strStorageExplaination']			= "
	Les images utilisées par les bannières locales sont stockées dans la base de données, ou dans un répertoire.
	Si vous stockez les images dans un répertoire, la charge de la base de données diminuera, et la vitesse
	augmentera.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	Vous avez activé les <i>statistiques compactes</i>, mais vos vieilles statistiques sont encore au format
	détaillé. Voulez vous convertir vos anciennes statistiques détaillées en statistiques compactes ?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Recherche de mises à jour. Merci de patienter...";
$GLOBALS['strAvailableUpdates']			= "Mises à jour disponibles";
$GLOBALS['strDownloadZip']				= "Télécharger (.zip)";
$GLOBALS['strDownloadGZip']				= "Télécharger (.tar.gz)";

$GLOBALS['strUpdateAlert']				= "Une nouvelle version de ".$phpAds_productname." est disponible.                 \\n\\nVoulez vous des informations supplémentaires \\nà son propos ?";
$GLOBALS['strUpdateAlertSecurity']			= "Une nouvelle version de ".$phpAds_productname." est disponible.                 \\n\\nIl est hautement recommandé de mettre à jour\\naussitôt que possible, car cette version \\ncontient un ou plusieurs correctifs de sécurité.";

$GLOBALS['strUpdateServerDown']			= "
	A cause d'une raison inconnue, il est impossible de récupérer <br>
	des informations concernant de possibles mises à jour. Merci de réessayer plus tard.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	Votre version de ".$phpAds_productname." est à jour. Il n'y a actuellement aucune mise à jour disponible.
";

$GLOBALS['strNewVersionAvailable']			= "
	<b>Une nouvelle version de ".$phpAds_productname." est disponible.</b><br> Il est recommandé d'installer cette
	mise à jour, car elle peut régler certains problèmes existants actuellement, et ajouter de nouvelles
	fonctionnalités. Pour plus d'informations concernant la mise à jour, merci de lire la documentation
	qui est inclus dans les fichiers ci-dessous.
";

$GLOBALS['strSecurityUpdate']				= "
	<b>Il est hautement recommandé d'installer cette mise à jour le plus tôt possible, car elle contient des
	correctifs de sécurité.</b> La version de ".$phpAds_productname." que vous utilisez actuellement pourrait
	être vulnérable à certaines attaques, et n'est probablement pas sure. Pour plus d'informations concernant
	la mise à jour, merci de lire la documentation qui est inclus dans les fichiers ci-dessous.
";


// Stats conversion
$GLOBALS['strConverting']				= "Conversion";
$GLOBALS['strConvertingStats']			= "Conversion des statistiques...";
$GLOBALS['strConvertStats']				= "Convertir les statistiques";
$GLOBALS['strConvertAdViews']				= "affichages convertis,";
$GLOBALS['strConvertAdClicks']			= "clics convertis...";
$GLOBALS['strConvertNothing']				= "Rien à convertir...";
$GLOBALS['strConvertFinished']			= "Fini...";

$GLOBALS['strConvertExplaination']			= "
	Vous utilisez actuellement le format compact pour stocker vos statistiques, mais il<br>
	y a encore quelques statistiques au format détaillé. Aussi longtemps que les statistiques<br>
	seront en format détaillé, le format compact ne sera pas utilisé pour voir ces pages.<br><br>
	Avant de convertir les statistiques, faite une sauvegarde de la base de données !!<br>
	Souhaitez vous convertir vos statistiques détaillées avec le nouveau format compact ? <br>
";

$GLOBALS['strConvertingExplaination']		= "
	Toutes les statistiques détaillées restante sont en train d'être converties au format<br>
	compact. Selon le nombre d'affichages stockés au format détaillé, cela peut prendre<br>
	quelques minutes. Merci d'attendre jusqu'à ce que la conversion soit fini, avant de<br>
	visiter d'autres pages. Ci-dessous vous trouverez un journal des modifications faites<br>
	à la base de données.<br>
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	La conversion des statistiques restant au format détaillé est réussie, et les données<br>
	devrait pouvoir est utilisables à nouveau. Ci-dessous vous trouverez un journal des <br>
	modifications faites à la base de données.
";


?>