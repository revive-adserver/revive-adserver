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
$GLOBALS['strBannerCacheExplaination']		= "La base de datos de cache de banner se usa para agilizar la muestra de banners durante la entrega</br />\nEsta cache necesita ser actualizada cuando:\n  <ul>\n     <li>Actualice su versión de OpenX</li>\n     <li>Traslade su instalación de OpenX a un servidor diferente</li>\n  </ul>";


// Zone cache
$GLOBALS['strZoneCache']					= "Cache de Zona";
$GLOBALS['strAge']							= "Edad";
$GLOBALS['strRebuildZoneCache']				= "Reconstruir cache de zona";
$GLOBALS['strZoneCacheExplaination']		= "\n	El cache de zona es usado para acelerar el envío de baners relacionados a zonas. El cache de zona contiene una copia de todos los\n	banners que están relacionados a la zona que guarda un número de consultas de base de dato cuando los banners son enviados al\n	usuario. El cache se reconstruye automáticamente cada vez que se realiza un cambio en la zona o en alguno de los banners de la misma.\n	Es por esto que el cache se reconstruye automáticamente cada {seconds} segundos, pero también es posible hacerlo manualmente.\n";


// Storage
$GLOBALS['strStorage']						= "Almacenamiento";
$GLOBALS['strMoveToDirectory']				= "Mover imágenes almacenadas en la base de datos a un directorio";
$GLOBALS['strStorageExplaination']			= "Las imágenes usadas por banners locales están almacenadas en la base de datos o bien en un directorio. Si almacena las imagenes en un directorio la carga en la base de datos se verá reducida y esto provocará que aumente su velocidad.\n";


// Storage
$GLOBALS['strStatisticsExplaination']		= "\n	Has activado las <i>estadísticas compactas</i>, pero las estadísticas antiguas todavía están en formato extendido.\n	¿Quieres convertir las estadísticas en formato extendido al nuevo formato compacto?\n";


// Product Updates
$GLOBALS['strSearchingUpdates']				= "Buscando Actualizaciones. Por favor espere...";
$GLOBALS['strAvailableUpdates']				= "Hay actualizaciones disponibles";
$GLOBALS['strDownloadZip']					= "Descargar (.zip)";
$GLOBALS['strDownloadGZip']					= "Descargar (.tar.gz)";

$GLOBALS['strUpdateAlert']					= "Se ha encontrado una nueva versión de ". MAX_PRODUCT_NAME ." disponible. \n\nDesea obtener mas información \nsobre esta actualización?";
$GLOBALS['strUpdateAlertSecurity']			= "Se ha encontrado una nueva versión de ". MAX_PRODUCT_NAME ." disponible. \n\nEs altamente recomendable que actualice el sistema \ntan pronto como sea posible, ya que \nesta versión contiene uno o más parches para problemas de seguridad.";

$GLOBALS['strUpdateServerDown']				= "Debido a razones desconocidas es imposible obtener<br />información sobre posibles actualizaciones. Por favor, inténtelo mas tarde.\n";

$GLOBALS['strNoNewVersionAvailable']		= "\nSu versión de ". MAX_PRODUCT_NAME ." se encuentra actualizada. No hay actualizaciones disponibles.\n";

$GLOBALS['strNewVersionAvailable']			= "\n<b>Una nueva versión de ". MAX_PRODUCT_NAME ." se encuentra disponible.</b><br /> Se recomienda instalar esta actualización, ya que puede arreglar algunos problemas existentes y agregar características nuevas. Para más información sobre actualizaciones, por favor lea la documentación incluída en los archivos.\n";

$GLOBALS['strSecurityUpdate']				= "<b>Es altamente recomendable instalar esta actualización, ya que contiene parches de seguridad.</b>\nLa versión de  que se encuentra usando es vulnerable a ciertos ataques y probablemente no sea segura. Para mayor información sobre actualizaciones, por favor lea la documentación incluída en los archivos.";


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
$GLOBALS['strBannerCacheErrorsFound'] = "El test de la cache de base de datos de banners ha encontrado algunos errores. Estos banners no funcionarán hasta que los arregle manualmente.";
$GLOBALS['strBannerCacheOK'] = "No se han detectado errores. Su cache de base de datos de banners está actualizada";
$GLOBALS['strBannerCacheDifferencesFound'] = "La revision de la cache de banners de la base de datos  ha encontrado que la cache no está actualizada y requiere reconstruirse. Haga clic aquí para actualizar la cache automáticamente.";
$GLOBALS['strBannerCacheRebuildButton'] = "Reconstruir";
$GLOBALS['strRebuildDeliveryCache'] = "Reconstruir la base de datos de banner";
$GLOBALS['strCache'] = "Cache de entrega";
$GLOBALS['strDeliveryCacheSharedMem'] = "La memoria compartida está siendo usada para guardar la cache de entrega.";
$GLOBALS['strDeliveryCacheDatabase'] = "La base de datos está siendo usada para guardar la cache de entrega.";
$GLOBALS['strDeliveryCacheFiles'] = "La cache de entrega está siendo guardada en archivos múltiples en su servidor.";
$GLOBALS['strNotAbleToCheck'] = "<b>Debido a que la extensión XML no está disponible en su servidor, ". MAX_PRODUCT_NAME ." no puede comprobar si hay una nueva versión disponible.</b>";
$GLOBALS['strForUpdatesLookOnWebsite'] = "Si quiere saber si hay una nueva versión disponible, por favor, consulte en nuestra página web.";
$GLOBALS['strClickToVisitWebsite'] = "Haga clic aquí para visitar nuestra página web";
$GLOBALS['strCurrentlyUsing'] = "Actualmente está usando";
$GLOBALS['strRunningOn'] = "funcionando bajo";
$GLOBALS['strAndPlain'] = "y";
$GLOBALS['strBannerCacheFixed'] = "La reconstrucción de la cache de base de datos banners se ha efectuado satisfactoriamente. Su cache de base de datos está actualizada.";


// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strEncoding'] = "Codificación";
$GLOBALS['strEncodingExplaination'] = "". MAX_PRODUCT_NAME ." ahora almacena todos los datos en la base de datos en formato UTF-8<br />Cuando sea posible, sus datos serán convertidos automáticamente a esta codificación.<br />Si después de actualizar encuentra caracteres corruptos, y conoce la codificación usada, puede usar esta herramienta para convertir los datos de ese formato a UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Convertir desde esta codificación";
$GLOBALS['strEncodingConvert'] = "Convertir";
$GLOBALS['strEncodingConvertTest'] = "Probar conversión";
$GLOBALS['strConvertThese'] = "Los siguientes datos serán cambiados si continúa";
$GLOBALS['strAppendCodes'] = "Agregar códigos";
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>El mantenimiento programado no se ha ejecutado en la pasada hora. Esto puede significar que no lo haya configurado correctamente.</b>";
$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "El mantenimiento automático está habilitado, pero no ha sido ejecutado. El mantenimiento automático se ejecuta únicamente cuando ". MAX_PRODUCT_NAME ." entrega algún banners. Para un mejor rendimiento, debería configurar  el <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>mantenimiento programado</a>.";
$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "El mantenimiento automático está deshabilitado, así que cuando ". MAX_PRODUCT_NAME ." entregue banners, el mantenimiento automático no se ejecutará. Para un mejor performance, puede configurar un <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>mantenimiento programado</a>. Sin embargo, si no va a configurar un <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>mantenimiento programado</a>, entonces <i>debe</i> <a href='account-settings-maintenance.php'>activar un mantenimiento programado</a> para asegurarse que ". MAX_PRODUCT_NAME ." funcione 'correctamente.'";
$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "Mantenimiento automático está habilitado y será ejecutado, como es requerido, cuando ". MAX_PRODUCT_NAME ." entregue banners. Sin embargo, para un mejor rendimiento, debería configurar el<<a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>mantenimiento programado</a>.";
$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "El mantenimiento automático ha sido recientemente deshabilitado. Para asegurar que ". MAX_PRODUCT_NAME ." funciona correctamente, debería configurar el <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>mantenimiento programado</a> o bien<a href='account-settings-maintenance.php'>volver a habilitar el mantenimiento automático</a>.<br><br>Para un mejor rendimiento, debería configurar el <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>mantenimiento programado</a>.";
$GLOBALS['strScheduledMantenaceRunning'] = "<b>El mantenimiento programado se está ejecutando correctamente.</b>";
$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>El mantenimiento automático se está ejecutando correctamente.</b>";
$GLOBALS['strAutoMantenaceEnabled'] = "El mantenimiento automático contínua habilitado. Para un mejor rendimiento, deberia <a href='account-settings-maintenance.php'>deshabilitar el mantenimiento automático</a>.";
$GLOBALS['strAutoMaintenanceDisabled'] = "El mantenimiento automático está deshabilitado";
$GLOBALS['strAutoMaintenanceEnabled'] = "El mantenimineto automático está habilitado. Para un mejor rendimiento se aconseja <a href='settings-admin.php'>deshabilitar el mantenimiento automático</a>.";
$GLOBALS['strCheckACLs'] = "Revisar ACLs";
$GLOBALS['strScheduledMaintenance'] = "El mantenimiento programado parece estar ejecutándose correctamente.";
$GLOBALS['strAutoMaintenanceEnabledNotTriggered'] = "El mantenimiento automático está habilitado, pero no ha sido ejecutado. Note que el mantenimiento automático es ejecutado sólo cuando ". MAX_PRODUCT_NAME ." entrega banners.";
$GLOBALS['strAutoMaintenanceBestPerformance'] = "Para un mejor rendimiento se aconseja configurar el <a href='". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>mantenimiento programado</a>";
$GLOBALS['strAutoMaintenanceEnabledWilltTrigger'] = "El mantenimiento automático está habilitado y se ejecutará mantenimiento cada hora.";
$GLOBALS['strAutoMaintenanceDisabledMaintenanceRan'] = "El mantenimiento automático está deshabilitado también pero una tarea de mantenimiento se ha ejecutado recientemente. Para asegurarse de que ". MAX_PRODUCT_NAME ." funciona correctamente debería configurar el <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>mantenimiento programado</a> o bien <a href='settings-admin.php'>habilitar el auto mantenimiento</a>.";
$GLOBALS['strAutoMaintenanceDisabledNotTriggered'] = "También, el mantenimiento automático está deshabilitado, con lo que cuando ". MAX_PRODUCT_NAME ." entrega banners, el mantenimiento no es ejecutado. Si no tiene planeado ejecutar <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>mantenimiento programado</a>, debería <a href='settings-admin.php'>habilitar el auto mantenimiento</a> para asegurar que ". MAX_PRODUCT_NAME ." funciona correctamente.";
$GLOBALS['strAllBannerChannelCompiled'] = "Todos los valores compilados de limitaciones de banners/canales han sido recompilados";
$GLOBALS['strBannerChannelResult'] = "Aqui están los resultados de la validación de las limitaciones compiladas de banners/canales";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Todas las limitaciones de canales compiladas son válidas";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Todas las limitaciones de banners compiladas son válidas";
$GLOBALS['strErrorsFound'] = "Errores encontrados";
$GLOBALS['strRepairCompiledLimitations'] = "Se encontraron algunas incosistencias anteriormente, puede repararlas usando el botón de abajo, este recompilará las limitaciones compiladas para cada banner/canal en el sistema<br />";
$GLOBALS['strRecompile'] = "Recompilar";
$GLOBALS['strAppendCodesDesc'] = "Bajo algunas circustancias el motor de entrega puede discrepar con algunos de los códigos agregados para los trackers, use el siguiente enlace para validar los códigos agregados a la base de datos ";
$GLOBALS['strCheckAppendCodes'] = "Chequear códigos agregados";
$GLOBALS['strAppendCodesRecompiled'] = "Todos los valores de los códigos compilados agregados han sido recompilados";
$GLOBALS['strAppendCodesResult'] = "Aquí están los resultados de la validación de códigos agregados";
$GLOBALS['strAppendCodesValid'] = "Todos los trackers de los códigos agregados compilados son válidos";
$GLOBALS['strRepairAppenedCodes'] = "Se encontraron algunas inconsistencias arriba, puede repararlas usando el botón de abajo, esto recompilará los códigos agregados para cada tracker en el sistema";
$GLOBALS['strScheduledMaintenanceNotRun'] = "El mantenimiento programado no se ha ejecutado en la pasada hora. Esto puede significar que no lo haya configurado correctamente.";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "Bajo algunas circustancias el motor de entrega puede discrepar con algunas de las ACLs para los banners y cananles, use el siguiente enlace para validar las ACLs de la base de datos";
$GLOBALS['strServerCommunicationError'] = "<b>La comunicación con el servidor de actualización ha tardado demasiado tiempo, por lo cual ".MAX_PRODUCT_NAME." no puede determinar si existe una nueva versión disponible en este momento. Por favor, intente nuevamente más tarde.</b>";
$GLOBALS['strCheckForUpdatesDisabled'] = "<b>Comprobar actualizaciones está deshabilitado. Por favor habilite esa opción en la pantalla <a href='account-settings-update.php'>actualizar opciones</a>.</b>";
?>