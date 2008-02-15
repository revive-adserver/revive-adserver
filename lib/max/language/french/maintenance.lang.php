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
$GLOBALS['strChooseSection']			= 'Op�ration de maintenance';


// Priority
$GLOBALS['strRecalculatePriority']		= 'Recalculer les priorit�s';
$GLOBALS['strHighPriorityCampaigns']		= 'Campagnes avec une priorit� haute';
$GLOBALS['strAdViewsAssigned']			= 'Nbre d\'affichages assign�s';
$GLOBALS['strLowPriorityCampaigns']		= 'Campagnes avec une priorit� basse';
$GLOBALS['strPredictedAdViews']			= 'Nbre d\'affichages pr�vus';
$GLOBALS['strPriorityDaysRunning']		= 'Il y a actuellement {days} jours de statistiques disponibles � partir desquels '.$phpAds_productname.' peut effectuer ses pr�visions. ';
$GLOBALS['strPriorityBasedLastWeek']		= 'Les pr�visions sont bas�es sur les donn�es de cette semaine et de la semaine pass�e. ';
$GLOBALS['strPriorityBasedLastDays']		= 'Les pr�visions sont bas�es sur les donn�es des derniers jours. ';
$GLOBALS['strPriorityBasedYesterday']		= 'Les pr�visions sont bas�es sur les donn�es d\'hier. ';
$GLOBALS['strPriorityNoData']			= 'Il n\'y a pas suffisament de statistiques disponibles afin d\'effectuer des pr�visions r�alistes concernant le nombre d\'affichages que ce serveur de publicit�s va effectuer aujourd\'hui. L\'assignement des objectifs ne sera bas� que sur des statistiques en temps r�el. ';
$GLOBALS['strPriorityEnoughAdViews']		= 'Il devrait y avoir suffisament d\'affichages aujourd\'hui pour satisfaire compl�tement les objectifs de toutes les campagnes haute priorit�. ';
$GLOBALS['strPriorityNotEnoughAdViews']		= 'Il n\'est pas certains qu\'il y aura assez d\'affichages aujourd\'hui pour satisfaire les objectifs de toutes les campagnes haute priorit�. C\'est pourquoi toutes les campagnes basse priorit� sont temporairement d�sactiv�es. ';


// Banner cache
$GLOBALS['strRebuildBannerCache']		= 'Reconstuire le cache des banni�res';
$GLOBALS['strBannerCacheExplaination']		= '
	Le cache des banni�res contient une copie du code HTML qui est utilis� pour afficher la banni�re. En utilisant
	ce cache de banni�re, il est possible d\'acc�l�rer la distribution des banni�res, car le code HTML n\'a plus
	besoin d\'�tre g�n�r� chaque fois qu\'une banni�re est demand�e. Parce que le cache des banni�re contient des
	liens cod�s en dur, il a besoin d\'�tre reconstruit � chaque fois que '.$phpAds_productname.' est d�plac� sur le serveur Web.
';


// Cache
$GLOBALS['strCache']				= 'Cache de distribution';
$GLOBALS['strAge']				= 'Age';
$GLOBALS['strRebuildDeliveryCache']		= 'Reconstruire le cache de distribution';
$GLOBALS['strDeliveryCacheExplaination']	= '
	Le cache de distribution est utilis� pour acc�l�rer la distribution des banni�res. Il contient une copie de 
	toutes les banni�res qui sont li�es � la zone, ce qui �conomise nombre de requ�tes � la base lorsque la banni�re
	doit �tre d�livr�e au visiteur. Le cache est habituellement reconstruit chaque fois qu\'une zone ou une de ses
	banni�res est modifi�e, il est n�anmoins possible que le cache ne soit plus � jour. C\'est pourquoi le cache est
	automatiquement reconstruit chaque heure; il est aussi possible de le reconstruire � la demande.
';
$GLOBALS['strDeliveryCacheSharedMem']		= '
	Le cache de distribution est actuellement stock� en m�moire partag�e.
';
$GLOBALS['strDeliveryCacheDatabase']		= '
	Le cache de distribution est actuellement stock� dans la base de donn�es.
';
$GLOBALS['strDeliveryCacheFiles']               = '
	Le cache de distribution est actuellement contenu dans plusieurs fichiers sur votre serveur
';

// Storage
$GLOBALS['strStorage']				= 'Stockage';
$GLOBALS['strMoveToDirectory']			= 'D�placer les images stock�es dans la base de donn�es vers le r�pertoire local';
$GLOBALS['strStorageExplaination']		= '
	Les images utilis�es par les banni�res locales sont stock�es dans la base de donn�es, ou dans un r�pertoire.
	Si vous stockez les images dans un r�pertoire, la charge de la base de donn�es diminuera, et la vitesse de distribution
	augmentera.
';


// Storage
$GLOBALS['strStatisticsExplaination']	= '
	Vous avez activ� les <i>statistiques compactes</i>, mais vos vieilles statistiques sont encore au format
	d�taill�. Voulez vous convertir vos anciennes statistiques d�taill�es en statistiques compactes ?
';


// Product Updates
$GLOBALS['strSearchingUpdates']			= 'Recherche de mises � jour. Merci de patienter...';
$GLOBALS['strAvailableUpdates']			= 'Mises � jour disponibles';
$GLOBALS['strDownloadZip']			= 'T�l�charger (.zip)';
$GLOBALS['strDownloadGZip']			= 'T�l�charger (.tar.gz)';

$GLOBALS['strUpdateAlert']			= 'Une nouvelle version de '.$phpAds_productname.' est disponible.                 \n\nVoulez vous des informations suppl�mentaires \n� son propos ?';
$GLOBALS['strUpdateAlertSecurity']		= 'Une nouvelle version de '.$phpAds_productname.' est disponible.                 \n\nIl est hautement recommand� de mettre � jour\naussit�t que possible, car cette version \ncontient un ou plusieurs correctifs de s�curit�.';

$GLOBALS['strUpdateServerDown']			= '
	A cause d\'une raison inconnue, il est impossible de r�cup�rer <br>
	des informations concernant de possibles mises � jour. Merci de r�essayer plus tard.
';

$GLOBALS['strNoNewVersionAvailable']		= '
	Votre version de '.$phpAds_productname.' est � jour. Il n\'y a actuellement aucune mise � jour disponible.
';

$GLOBALS['strNewVersionAvailable']		= '
	<b>Une nouvelle version de '.$phpAds_productname.' est disponible.</b><br> Il est recommand� d\'installer cette
	mise � jour, car elle peut r�gler certains probl�mes existants actuellement, et ajouter de nouvelles
	fonctionnalit�s. Pour plus d\'informations concernant la mise � jour, merci de lire la documentation
	qui est inclus dans les fichiers ci-dessous.
';

$GLOBALS['strSecurityUpdate']			= '
	<b>Il est hautement recommand� d\'installer cette mise � jour le plus t�t possible, car elle contient des
	correctifs de s�curit�.</b> La version de '.$phpAds_productname.' que vous utilisez actuellement pourrait
	�tre vuln�rable � certaines attaques, et n\'est probablement pas sure. Pour plus d\'informations concernant
	la mise � jour, merci de lire la documentation qui est inclus dans les fichiers ci-dessous.
';

$GLOBALS['strNotAbleToCheck']			= '
	<b>L\'absence de l\'extension XML sur votre serveur PHP emp�che '.$phpAds_productname.'  de v�rifier si des mises
� jour sont disponibles.</b>
';

$GLOBALS['strForUpdatesLookOnWebsite']		= 'Pour toute information concernant les mises � jour / nouvelles versions, venez nous rendre visite sur notre site Web !';

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
$GLOBALS['strConvertNothing']			= 'Rien � convertir...';
$GLOBALS['strConvertFinished']			= 'Fini...';

$GLOBALS['strConvertExplaination']		= '
	Vous utilisez actuellement le format compact pour stocker vos statistiques, mais il<br>
	y a encore quelques statistiques au format d�taill�. Aussi longtemps que les statistiques<br>
	seront en format d�taill�, le format compact ne sera pas utilis� pour voir ces pages.<br><br>
	Avant de convertir les statistiques, faite une sauvegarde de la base de donn�es !!<br>
	Souhaitez vous convertir vos statistiques d�taill�es avec le nouveau format compact ? <br>
';

$GLOBALS['strConvertingExplaination']	= '
	Toutes les statistiques d�taill�es restante sont en train d\'�tre converties au format<br>
	compact. Selon le nombre d\'affichages stock�s au format d�taill�, cela peut prendre<br>
	quelques minutes. Merci d\'attendre jusqu\'� ce que la conversion soit fini, avant de<br>
	visiter d\'autres pages. Ci-dessous vous trouverez un journal des modifications faites<br>
	� la base de donn�es.<br>
';

$GLOBALS['strConvertFinishedExplaination']= '
	La conversion des statistiques du format d�taill� vers le format compact est r�ussie, et les donn�es<br>
	devrait pouvoir �tre utilisables � nouveau. Ci-dessous vous trouverez un journal des <br>
	modifications faites � la base de donn�es.
';


?>