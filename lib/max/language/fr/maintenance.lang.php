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


// Main strings
$GLOBALS['strChooseSection']			= 'Opération de maintenance';


// Priority
$GLOBALS['strRecalculatePriority']		= 'Recalculer les priorités';
$GLOBALS['strHighPriorityCampaigns']		= 'Campagnes avec une priorité haute';
$GLOBALS['strAdViewsAssigned']			= 'Nbre d\'affichages assignés';
$GLOBALS['strLowPriorityCampaigns']		= 'Campagnes avec une priorité basse';
$GLOBALS['strPredictedAdViews']			= 'Nbre d\'affichages prévus';
$GLOBALS['strPriorityDaysRunning']		= 'Il y a actuellement {days} jours de statistiques disponibles à partir desquels '.$phpAds_productname.' peut effectuer ses prévisions. ';
$GLOBALS['strPriorityBasedLastWeek']		= 'Les prévisions sont basées sur les données de cette semaine et de la semaine passée. ';
$GLOBALS['strPriorityBasedLastDays']		= 'Les prévisions sont basées sur les données des derniers jours. ';
$GLOBALS['strPriorityBasedYesterday']		= 'Les prévisions sont basées sur les données d\'hier. ';
$GLOBALS['strPriorityNoData']			= 'Il n\'y a pas suffisament de statistiques disponibles afin d\'effectuer des prévisions réalistes concernant le nombre d\'affichages que ce serveur de publicités va effectuer aujourd\'hui. L\'assignement des objectifs ne sera basé que sur des statistiques en temps réel. ';
$GLOBALS['strPriorityEnoughAdViews']		= 'Il devrait y avoir suffisament d\'affichages aujourd\'hui pour satisfaire complètement les objectifs de toutes les campagnes haute priorité. ';
$GLOBALS['strPriorityNotEnoughAdViews']		= 'Il n\'est pas certains qu\'il y aura assez d\'affichages aujourd\'hui pour satisfaire les objectifs de toutes les campagnes haute priorité. C\'est pourquoi toutes les campagnes basse priorité sont temporairement désactivées. ';


// Banner cache
$GLOBALS['strRebuildBannerCache']		= 'Reconstuire le cache des bannières';
$GLOBALS['strBannerCacheExplaination']		= '
	Le cache des bannières contient une copie du code HTML qui est utilisé pour afficher la bannière. En utilisant
	ce cache de bannière, il est possible d\'accélérer la distribution des bannières, car le code HTML n\'a plus
	besoin d\'être généré chaque fois qu\'une bannière est demandée. Parce que le cache des bannière contient des
	liens codés en dur, il a besoin d\'être reconstruit à chaque fois que '.$phpAds_productname.' est déplacé sur le serveur Web.
';


// Cache
$GLOBALS['strCache']				= 'Cache de distribution';
$GLOBALS['strAge']				= 'Age';
$GLOBALS['strRebuildDeliveryCache']		= 'Reconstruire le cache de distribution';
$GLOBALS['strDeliveryCacheExplaination']	= '
	Le cache de distribution est utilisé pour accélérer la distribution des bannières. Il contient une copie de
	toutes les bannières qui sont liées à la zone, ce qui économise nombre de requêtes à la base lorsque la bannière
	doit être délivrée au visiteur. Le cache est habituellement reconstruit chaque fois qu\'une zone ou une de ses
	bannières est modifiée, il est néanmoins possible que le cache ne soit plus à jour. C\'est pourquoi le cache est
	automatiquement reconstruit chaque heure; il est aussi possible de le reconstruire à la demande.
';
$GLOBALS['strDeliveryCacheSharedMem']		= '
	Le cache de distribution est actuellement stocké en mémoire partagée.
';
$GLOBALS['strDeliveryCacheDatabase']		= '
	Le cache de distribution est actuellement stocké dans la base de données.
';
$GLOBALS['strDeliveryCacheFiles']               = '
	Le cache de distribution est actuellement contenu dans plusieurs fichiers sur votre serveur
';

// Storage
$GLOBALS['strStorage']				= 'Stockage';
$GLOBALS['strMoveToDirectory']			= 'Déplacer les images stockées dans la base de données vers le répertoire local';
$GLOBALS['strStorageExplaination']		= '
	Les images utilisées par les bannières locales sont stockées dans la base de données, ou dans un répertoire.
	Si vous stockez les images dans un répertoire, la charge de la base de données diminuera, et la vitesse de distribution
	augmentera.
';


// Storage
$GLOBALS['strStatisticsExplaination']	= '
	Vous avez activé les <i>statistiques compactes</i>, mais vos vieilles statistiques sont encore au format
	détaillé. Voulez vous convertir vos anciennes statistiques détaillées en statistiques compactes ?
';


// Product Updates
$GLOBALS['strSearchingUpdates']			= 'Recherche de mises à jour. Merci de patienter...';
$GLOBALS['strAvailableUpdates']			= 'Mises à jour disponibles';
$GLOBALS['strDownloadZip']			= 'Télécharger (.zip)';
$GLOBALS['strDownloadGZip']			= 'Télécharger (.tar.gz)';

$GLOBALS['strUpdateAlert']			= 'Une nouvelle version de '.$phpAds_productname.' est disponible.                 \n\nVoulez vous des informations supplémentaires \nà son propos ?';
$GLOBALS['strUpdateAlertSecurity']		= 'Une nouvelle version de '.$phpAds_productname.' est disponible.                 \n\nIl est hautement recommandé de mettre à jour\naussitôt que possible, car cette version \ncontient un ou plusieurs correctifs de sécurité.';

$GLOBALS['strUpdateServerDown']			= '
	A cause d\'une raison inconnue, il est impossible de récupérer <br>
	des informations concernant de possibles mises à jour. Merci de réessayer plus tard.
';

$GLOBALS['strNoNewVersionAvailable']		= '
	Votre version de '.$phpAds_productname.' est à jour. Il n\'y a actuellement aucune mise à jour disponible.
';

$GLOBALS['strNewVersionAvailable']		= '
	<b>Une nouvelle version de '.$phpAds_productname.' est disponible.</b><br> Il est recommandé d\'installer cette
	mise à jour, car elle peut régler certains problèmes existants actuellement, et ajouter de nouvelles
	fonctionnalités. Pour plus d\'informations concernant la mise à jour, merci de lire la documentation
	qui est inclus dans les fichiers ci-dessous.
';

$GLOBALS['strSecurityUpdate']			= '
	<b>Il est hautement recommandé d\'installer cette mise à jour le plus tôt possible, car elle contient des
	correctifs de sécurité.</b> La version de '.$phpAds_productname.' que vous utilisez actuellement pourrait
	être vulnérable à certaines attaques, et n\'est probablement pas sure. Pour plus d\'informations concernant
	la mise à jour, merci de lire la documentation qui est inclus dans les fichiers ci-dessous.
';

$GLOBALS['strNotAbleToCheck']			= '
	<b>L\'absence de l\'extension XML sur votre serveur PHP empêche '.$phpAds_productname.'  de vérifier si des mises
à jour sont disponibles.</b>
';

$GLOBALS['strForUpdatesLookOnWebsite']		= 'Pour toute information concernant les mises à jour / nouvelles versions, venez nous rendre visite sur notre site Web !';

$GLOBALS['strClickToVisitWebsite']		= 'Cliquez ici pour visiter notre site Web';
$GLOBALS['strCurrentlyUsing'] 			= 'Vous utilisez actuellement';
$GLOBALS['strRunningOn']			= 'sur un serveur avec';
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


?>