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
$GLOBALS['strBannerCacheExplaination']		= "La base de datos de cache de banner se usa para agilizar la muestra de banners durante la entrega</br />\nEsta cache necesita ser actualizada cuando:\n  <ul>\n     <li>Actualice su versi&oacute;n de Openads</li>\n     <li>Traslade su instalaci&oacute;n de Openads a un servidor diferente</li>\n  </ul>";


// Zone cache
$GLOBALS['strZoneCache']					= "Cache de Zona";
$GLOBALS['strAge']							= "Edad";
$GLOBALS['strRebuildZoneCache']				= "Reconstruir cache de zona";
$GLOBALS['strZoneCacheExplaination']		= "\n	El cache de zona es usado para acelerar el envío de baners relacionados a zonas. El cache de zona contiene una copia de todos los\n	banners que están relacionados a la zona que guarda un número de consultas de base de dato cuando los banners son enviados al\n	usuario. El cache se reconstruye automáticamente cada vez que se realiza un cambio en la zona o en alguno de los banners de la misma.\n	Es por esto que el cache se reconstruye automáticamente cada {seconds} segundos, pero también es posible hacerlo manualmente.\n";


// Storage
$GLOBALS['strStorage']						= "Almacenamiento";
$GLOBALS['strMoveToDirectory']				= "Mover imágenes almacenadas en la base de datos a un directorio";
$GLOBALS['strStorageExplaination']			= "Las im&aacute;genes usadas por banners locales est&aacute;n almacenadas en la base de datos o bien en un directorio. Si almacena las imagenes en un directorio la carga en la base de datos se ver&aacute; reducida y esto provocar&aacute; que aumente su velocidad.\n";


// Storage
$GLOBALS['strStatisticsExplaination']		= " Has activado las <i>estad&iacute;sticas compactas</i>, pero las estad&iacute;sticas antiguas todav&iacute;a est&aacute;n en formato extendido.\n &iquest;Quieres convertir las estad&iacute;sticas en formato extendido al nuevo formato compacto?";


// Product Updates
$GLOBALS['strSearchingUpdates']				= "Buscando Actualizaciones. Por favor espere...";
$GLOBALS['strAvailableUpdates']				= "Hay actualizaciones disponibles";
$GLOBALS['strDownloadZip']					= "Descargar (.zip)";
$GLOBALS['strDownloadGZip']					= "Descargar (.tar.gz)";

$GLOBALS['strUpdateAlert']					= "Se ha encontrado una nueva versi&oacute;n de ".MAX_PRODUCT_NAME." disponible. \n\nDesea obtener mas informaci&oacute;n \nsobre esta actualizaci&oacute;n?";
$GLOBALS['strUpdateAlertSecurity']			= "Se ha encontrado una nueva versi&oacute;n de ".MAX_PRODUCT_NAME." disponible. \n\nEs altamente recomendable que actualice el sistema \ntan pronto como sea posible, ya que \nesta versi&oacute;n contiene uno o m&aacute;s parches para problemas de seguridad.";

$GLOBALS['strUpdateServerDown']				= "Debido a razones desconocidas es imposible obtener<br />informaci&oacute;n sobre posibles actualizaciones. Por favor, int&eacute;ntelo mas tarde.\n";

$GLOBALS['strNoNewVersionAvailable']		= "\nSu versi&oacute;n de ".MAX_PRODUCT_NAME." se encuentra actualizada. No hay actualizaciones disponibles.\n";

$GLOBALS['strNewVersionAvailable']			= "\n<b>Una nueva versi&oacute;n de ".MAX_PRODUCT_NAME." se encuentra disponible.</b><br /> Se recomienda instalar esta actualizaci&oacute;n, ya que puede arreglar algunos problemas existentes y agregar caracter&iacute;sticas nuevas. Para m&aacute;s informaci&oacute;n sobre actualizaciones, por favor lea la documentaci&oacute;n inclu&iacute;da en los archivos.\n";

$GLOBALS['strSecurityUpdate']				= "<b>Es altamente recomendable instalar esta actualizaci&oacute;n, ya que contiene parches de seguridad.</b>\nLa versi&oacute;n de  que se encuentra usando es vulnerable a ciertos ataques y probablemente no sea segura. Para mayor informaci&oacute;n sobre actualizaciones, por favor lea la documentaci&oacute;n inclu&iacute;da en los archivos.";


// Stats conversion
$GLOBALS['strConverting']					= "Convirtiendo";
$GLOBALS['strConvertingStats']				= "Convirtiendo estadísticas...";
$GLOBALS['strConvertStats']					= "Estadísticas convertidas";
$GLOBALS['strConvertAdViews']				= "Impresiones convertidas,";
$GLOBALS['strConvertAdClicks']				= "Clicks convertidos...";
$GLOBALS['strConvertNothing']				= "No hay nada que convertir...";
$GLOBALS['strConvertFinished']				= "Finalizado...";

$GLOBALS['strConvertExplaination']			= "\n	Ud. actualmente está usando el formato compacto para almacenar sus estadísticas, pero aún hay<br />\n	algunas estadísticas en formato extendido. Hasta que no sean convertidas al formato compacto <br />\n	no podrán verse en estas páginas. <br />\n	Antes de convertir sus estadísticas, haga un backup de su base de datos! <br />\n	Desea convertir sus estadísticas extendidas al nuevo formato compacto? <br />\n";

$GLOBALS['strConvertingExplaination']		= "\n	Todas las estadísticas expandidas están siendo convertidas al formato compacto. <br />\n	Dependiendo de la cantidad de Impresiones hayan almacenadas en formato extendido tardará <br />\n	algunos minutos. Por favor espere mientras la conversión finaliza antes de visitar otra <br />\n	página. A continuación verá todas las modificaciones realizadas a la base de datos. <br />\n";

$GLOBALS['strConvertFinishedExplaination']  = "\n	La conversión de las estadísticas extendidas restantes ha termindado. <br />\n	A continuación verá todas las modificaciones realizadas al a base de datos. <br />\n";




// Note: new translatiosn not found in original lang files but found in CSV
$GLOBALS['strCheckBannerCache'] = "Comprobar cache de banners";
$GLOBALS['strBannerCacheErrorsFound'] = "El test de la cache de base de datos de banners ha encontrado algunos errores. Estos banners no funcionar&aacute;n hasta que los arregle manualmente.";
$GLOBALS['strBannerCacheOK'] = "No se han detectado errores. Su cache de base de datos de banners est&aacute; actualizada";
$GLOBALS['strBannerCacheDifferencesFound'] = "El test de la cache de base de datos de banners ha encontrado que la cache no est&aacute; actualizada y requiere reconstruirse. Haga clic aqu&iacute; para actualizar la cache autom&aacute;ticamente.";
$GLOBALS['strBannerCacheRebuildButton'] = "Reconstruir";
$GLOBALS['strRebuildDeliveryCache'] = "Reconstruir la base de datos de banner";
$GLOBALS['strCache'] = "Cache de entrega";
$GLOBALS['strDeliveryCacheSharedMem'] = "La memoria compartida est&aacute; siendo usada para guardar la cache de entrega.";
$GLOBALS['strDeliveryCacheDatabase'] = "La base de datos est&aacute; siendo usada para guardar la cache de entrega.";
$GLOBALS['strDeliveryCacheFiles'] = "La cache de entrega est&aacute; siendo guardada en archivos m&uacute;ltiples en su servidor.";
$GLOBALS['strNotAbleToCheck'] = "<b>Debido a que la extensi&oacute;n XML no est&aacute; disponible en su servidor, ".MAX_PRODUCT_NAME." no puede comprobar si hay una nueva versi&oacute;n disponible.</b>";
$GLOBALS['strForUpdatesLookOnWebsite'] = "Si quiere saber si hay una nueva versi&oacute;n disponible, por favor, consulte en nuestra p&aacute;gina web.";
$GLOBALS['strClickToVisitWebsite'] = "Haga clic aqu&iacute; para visitar nuestra p&aacute;gina web";
$GLOBALS['strCurrentlyUsing'] = "Actualmente est&aacute; usando";
$GLOBALS['strRunningOn'] = "funcionando bajo";
$GLOBALS['strAndPlain'] = "y";
$GLOBALS['strBannerCacheFixed'] = "La reconstrucci&oacute;n de la cache de base de datos banners se ha efectuado satisfactoriamente. Su cache de base de datos est&aacute; actualizada.";
?>