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
$GLOBALS['strChooseSection'] = "Elija la sección";
$GLOBALS['strAppendCodes'] = "Agregar códigos";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>El mantenimiento programado no se ha ejecutado en la pasada hora. Esto puede significar que no lo haya configurado correctamente.</b>";





$GLOBALS['strScheduledMantenaceRunning'] = "<b>El mantenimiento programado se está ejecutando correctamente.</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>El mantenimiento automático se está ejecutando correctamente.</b>";

$GLOBALS['strAutoMantenaceEnabled'] = "El mantenimiento automático contínua habilitado. Para un mejor rendimiento, deberia <a href='account-settings-maintenance.php'>deshabilitar el mantenimiento automático</a>.";

// Priority
$GLOBALS['strRecalculatePriority'] = "Recalcular prioridad";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Comprobar cache de banners";
$GLOBALS['strBannerCacheErrorsFound'] = "El test de la cache de base de datos de banners ha encontrado algunos errores. Estos banners no funcionarán hasta que los arregle manualmente.";
$GLOBALS['strBannerCacheOK'] = "No se han detectado errores. Su cache de base de datos de banners está actualizada";
$GLOBALS['strBannerCacheDifferencesFound'] = "La revision de la cache de banners de la base de datos  ha encontrado que la cache no está actualizada y requiere reconstruirse. Haga clic aquí para actualizar la cache automáticamente.";
$GLOBALS['strBannerCacheRebuildButton'] = "Reconstruir";
$GLOBALS['strRebuildDeliveryCache'] = "Reconstruir la base de datos de banner";

// Cache
$GLOBALS['strCache'] = "Cache de entrega";
$GLOBALS['strDeliveryCacheSharedMem'] = "La memoria compartida está siendo usada para guardar la cache de entrega.";
$GLOBALS['strDeliveryCacheDatabase'] = "La base de datos está siendo usada para guardar la cache de entrega.";
$GLOBALS['strDeliveryCacheFiles'] = "La cache de entrega está siendo guardada en archivos múltiples en su servidor.";

// Storage
$GLOBALS['strStorage'] = "Almacenamiento";
$GLOBALS['strMoveToDirectory'] = "Mover imágenes almacenadas en la base de datos a un directorio";
$GLOBALS['strStorageExplaination'] = "Las imágenes usadas por banners locales están almacenadas en la base de datos o bien en un directorio. Si almacena las imagenes en un directorio la carga en la base de datos se verá reducida y esto provocará que aumente su velocidad.";

// Encoding
$GLOBALS['strEncoding'] = "Codificación";
$GLOBALS['strEncodingConvertFrom'] = "Convertir desde esta codificación";
$GLOBALS['strEncodingConvertTest'] = "Probar conversión";
$GLOBALS['strConvertThese'] = "Los siguientes datos serán cambiados si continúa";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Buscando Actualizaciones. Por favor espere...";
$GLOBALS['strAvailableUpdates'] = "Hay actualizaciones disponibles";
$GLOBALS['strDownloadZip'] = "Descargar (.zip)";
$GLOBALS['strDownloadGZip'] = "Descargar (.tar.gz)";


$GLOBALS['strUpdateServerDown'] = "Debido a razones desconocidas es imposible obtener<br />información sobre posibles actualizaciones. Por favor, inténtelo mas tarde.";



$GLOBALS['strCheckForUpdatesDisabled'] = "<b>Comprobar actualizaciones está deshabilitado. Por favor habilite esa opción en la pantalla <a href='account-settings-update.php'>actualizar opciones</a>.</b>";




$GLOBALS['strForUpdatesLookOnWebsite'] = "Si quiere saber si hay una nueva versión disponible, por favor, consulte en nuestra página web.";

$GLOBALS['strClickToVisitWebsite'] = "Haga clic aquí para visitar nuestra página web";
$GLOBALS['strCurrentlyUsing'] = "Actualmente está usando";
$GLOBALS['strRunningOn'] = "funcionando bajo";
$GLOBALS['strAndPlain'] = "y";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "Reglas de Entrega";
$GLOBALS['strErrorsFound'] = "Errores encontrados";
$GLOBALS['strRepairCompiledLimitations'] = "Se encontraron algunas incosistencias anteriormente, puede repararlas usando el botón de abajo, este recompilará las limitaciones compiladas para cada banner/canal en el sistema<br />";
$GLOBALS['strRecompile'] = "Recompilar";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "Bajo algunas circustancias el motor de entrega puede discrepar con algunos de los códigos agregados para los trackers, use el siguiente enlace para validar los códigos agregados a la base de datos ";
$GLOBALS['strCheckAppendCodes'] = "Chequear códigos agregados";
$GLOBALS['strAppendCodesRecompiled'] = "Todos los valores de los códigos compilados agregados han sido recompilados";
$GLOBALS['strAppendCodesResult'] = "Aquí están los resultados de la validación de códigos agregados";
$GLOBALS['strAppendCodesValid'] = "Todos los trackers de los códigos agregados compilados son válidos";
$GLOBALS['strRepairAppenedCodes'] = "Se encontraron algunas inconsistencias arriba, puede repararlas usando el botón de abajo, esto recompilará los códigos agregados para cada tracker en el sistema";

$GLOBALS['strPlugins'] = "Plugins";

$GLOBALS['strMenus'] = "Menús";
$GLOBALS['strMenusPrecis'] = "Reconstruir la cache de menú";
$GLOBALS['strMenusCachedOk'] = "Caché de menú ha sido reconstruido";
