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
$GLOBALS['strChooseSection']				= "Elija la sección";


// Priority
$GLOBALS['strRecalculatePriority']			= "Recalcular prioridad";
$GLOBALS['strHighPriorityCampaigns']		= "Campañas de Alta Prioridad";
$GLOBALS['strAdViewsAssigned']				= "Impresiones Asignadas";
$GLOBALS['strLowPriorityCampaigns']			= "Campañas de Baja Prioridad";
$GLOBALS['strPredictedAdViews']				= "Impresiones Predecidas";
$GLOBALS['strPriorityDaysRunning']			= "Actualmente hay {days} días de estadísticas disponibles sobre los cuales ".$phpAds_productname." podrá basarse para predecir diariamente. ";
$GLOBALS['strPriorityBasedLastWeek']		= "La predicción está basada en datos de esta semana y la anterior. ";
$GLOBALS['strPriorityBasedLastDays']		= "La predicción está basada en datos de los últimos días. ";
$GLOBALS['strPriorityBasedYesterday']		= "La predicción está basada en datos de ayer. ";
$GLOBALS['strPriorityNoData']				= "No hay datos suficientes para realizar una predicción certera sobre el número de impresiones que se generarán hoy. Las predicciones están basadas en estadísticas de tiempo real SOLAMENTE.";
$GLOBALS['strPriorityEnoughAdViews']		= "Debe haber Impresiones suficientes para satisfacer el objetivo de todas las campañas de alta prioridad. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "No está claro cuantas Impresiones habrán hoy para satisfacer el objetivo de todas las campañas de alta prioridad. Por este motivo todas las campañas de baja prioridad serán temporalmente deshabilitadas. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']			= "Reconstruir banner cache";
$GLOBALS['strBannerCacheExplaination']		= "
	El banner cache contiene una copia del código HTML usado para mostrar el banner. Usando un banner cache es posible aumentar la velocidad
	de envíos de banners ya que el código HTML no debe ser generado cada vez que un banner se envía. Ya que el banner cache
	contiene hard coded URLs hacia la ubicaci*oacute;n de ".$phpAds_productname." y sus banners, el cache necesita actualizarse siempre que ".$phpAds_productname."
	sea movido a otra ubicación dentro del webserver.
";


// Zone cache
$GLOBALS['strZoneCache']					= "Cache de Zona";
$GLOBALS['strAge']							= "Edad";
$GLOBALS['strRebuildZoneCache']				= "Reconstruir cache de zona";
$GLOBALS['strZoneCacheExplaination']		= "
	El cache de zona es usado para acelerar el envío de baners relacionados a zonas. El cache de zona contiene una copia de todos los
	banners que están relacionados a la zona que guarda un número de consultas de base de dato cuando los banners son enviados al
	usuario. El cache se reconstruye automáticamente cada vez que se realiza un cambio en la zona o en alguno de los banners de la misma.
	Es por esto que el cache se reconstruye automáticamente cada {seconds} segundos, pero también es posible hacerlo manualmente.
";


// Storage
$GLOBALS['strStorage']						= "Almacenamiento";
$GLOBALS['strMoveToDirectory']				= "Mover imágenes almacenadas en la base de datos a un directorio";
$GLOBALS['strStorageExplaination']			= "
	Las imágenes usadas por banners locales están almacenadas en la base de datos o bien en un directorio. Si Ud. almacena las imagenes en
	un directorio la carga en la base de datos se verá reducida y esto provocará que aumente su velocidad.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	Ud. habilitó las <i>estadísticas compactas</i>, pero sus estadísticas antiguas aparecerán detalladas.
	Desea convertir sus antiguas estadísticas al nuevo formato compacto?
";


// Product Updates
$GLOBALS['strSearchingUpdates']				= "Buscando Actualizaciones. Por favor espere...";
$GLOBALS['strAvailableUpdates']				= "Hay Actualizaciones Disponibles";
$GLOBALS['strDownloadZip']					= "Download (.zip)";
$GLOBALS['strDownloadGZip']					= "Download (.tar.gz)";

$GLOBALS['strUpdateAlert']					= "Se ha encontrado una nueva versión de ".$phpAds_productname." disponible.                 \\n\\nDesea obtener mas información \\nsobre esta actualización?";
$GLOBALS['strUpdateAlertSecurity']			= "Se ha encontrado una nueva versión de ".$phpAds_productname." disponible.                 \\n\\nEs altamnete recomendable que actualize el sistema \\ntan pronto como sea posible, ya que \\nesta versión contiene uno o mas problemas de seguridad.";

$GLOBALS['strUpdateServerDown']				= "
    Debido a razones desconocidas es imposible obtener<br />
	información sobre posibles actualizaciones. Por favor intentelo mas tarde.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	Su versión de ".$phpAds_productname." se encuentra actualizada. No hay actualizaciones disponibles.
";

$GLOBALS['strNewVersionAvailable']			= "
	<b>Una nueva versión de ".$phpAds_productname." se encuentra disponible.</b><br /> Se recomienda instalar esta actualización,
	ya que probablemente arregle algunos problemas existentes y agregue algunas características nuevas. Para mayor información
	sobre actualizaciones, por favor lea la documentación incluida en los archivos.
";

$GLOBALS['strSecurityUpdate']				= "
	<b>Es altamente recomendable instalar esta actualización, ya que contiene un arreglos de seguridad.</b>
	La versión de ".$phpAds_productname." que se encuentra usando es vulnerable a ciertos ataques
	y probalemente no sea seguro. Para mayor información sobre actualizaciones por favor lea la documentación incluida en los archivos.
";


// Stats conversion
$GLOBALS['strConverting']					= "Convirtiendo";
$GLOBALS['strConvertingStats']				= "Convirtiendo estadísticas...";
$GLOBALS['strConvertStats']					= "Estadísticas convertidas";
$GLOBALS['strConvertAdViews']				= "Impresiones convertidas,";
$GLOBALS['strConvertAdClicks']				= "Clicks convertidos...";
$GLOBALS['strConvertNothing']				= "No hay nada que convertir...";
$GLOBALS['strConvertFinished']				= "Finalizado...";

$GLOBALS['strConvertExplaination']			= "
	Ud. actualmente está usando el formato compacto para almacenar sus estadísticas, pero aún hay<br />
	algunas estadísticas en formato extendido. Hasta que no sean convertidas al formato compacto <br />
	no podrán verse en estas páginas. <br />
	Antes de convertir sus estadísticas, haga un backup de su base de datos! <br />
	Desea convertir sus estadísticas extendidas al nuevo formato compacto? <br />
";

$GLOBALS['strConvertingExplaination']		= "
	Todas las estadísticas expandidas están siendo convertidas al formato compacto. <br />
	Dependiendo de la cantidad de Impresiones hayan almacenadas en formato extendido tardará <br />
	algunos minutos. Por favor espere mientras la conversión finaliza antes de visitar otra <br />
	página. A continuación verá todas las modificaciones realizadas a la base de datos. <br />
";

$GLOBALS['strConvertFinishedExplaination']  = "
	La conversión de las estadísticas extendidas restantes ha termindado. <br />
	A continuación verá todas las modificaciones realizadas al a base de datos. <br />
";


?>