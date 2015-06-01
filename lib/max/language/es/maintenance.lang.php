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

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "El mantenimiento automático está habilitado, pero no ha sido ejecutado. El mantenimiento automático se ejecuta únicamente cuando {$PRODUCT_NAME} entrega algún banners. Para un mejor rendimiento, debería configurar  el <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>mantenimiento programado</a>.";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "El mantenimiento automático está deshabilitado, así que cuando {$PRODUCT_NAME} entregue banners, el mantenimiento automático no se ejecutará. Para un mejor performance, puede configurar un <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>mantenimiento programado</a>. Sin embargo, si no va a configurar un <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>mantenimiento programado</a>, entonces <i>debe</i> <a href='account-settings-maintenance.php'>activar un mantenimiento programado</a> para asegurarse que {$PRODUCT_NAME} funcione 'correctamente.'";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "Mantenimiento automático está habilitado y será ejecutado, como es requerido, cuando {$PRODUCT_NAME} entregue banners. Sin embargo, para un mejor rendimiento, debería configurar el<<a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>mantenimiento programado</a>.";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "El mantenimiento automático ha sido recientemente deshabilitado. Para asegurar que {$PRODUCT_NAME} funciona correctamente, debería configurar el <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>mantenimiento programado</a> o bien<a href='account-settings-maintenance.php'>volver a habilitar el mantenimiento automático</a>.<br><br>Para un mejor rendimiento, debería configurar el <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>mantenimiento programado</a>.";

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
$GLOBALS['strBannerCacheExplaination'] = "    La base de datos de cache de banner se usa para agilizar la muestra de banners durante la entrega<br />
    Esta cache necesita ser actualizada cuando:
      <ul>
         <li>Actualice su versión de {$PRODUCT_NAME}</li>
         <li>Traslade su instalación de {$PRODUCT_NAME} a un servidor diferente</li>
      </ul>";

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
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} ahora almacena todos los datos en la base de datos en formato UTF-8<br />Cuando sea posible, sus datos serán convertidos automáticamente a esta codificación.<br />Si después de actualizar encuentra caracteres corruptos, y conoce la codificación usada, puede usar esta herramienta para convertir los datos de ese formato a UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Convertir desde esta codificación";
$GLOBALS['strEncodingConvertTest'] = "Probar conversión";
$GLOBALS['strConvertThese'] = "Los siguientes datos serán cambiados si continúa";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Buscando Actualizaciones. Por favor espere...";
$GLOBALS['strAvailableUpdates'] = "Hay actualizaciones disponibles";
$GLOBALS['strDownloadZip'] = "Descargar (.zip)";
$GLOBALS['strDownloadGZip'] = "Descargar (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "Se ha encontrado una nueva versión de {$PRODUCT_NAME} disponible.

Desea obtener mas información
sobre esta actualización?";
$GLOBALS['strUpdateAlertSecurity'] = "Se ha encontrado una nueva versión de {$PRODUCT_NAME} disponible.

Es altamente recomendable que actualice el sistema
tan pronto como sea posible, ya que
esta versión contiene uno o más parches para problemas de seguridad.";

$GLOBALS['strUpdateServerDown'] = "Debido a razones desconocidas es imposible obtener<br />información sobre posibles actualizaciones. Por favor, inténtelo mas tarde.";

$GLOBALS['strNoNewVersionAvailable'] = "Su versión de {$PRODUCT_NAME} se encuentra actualizada. No hay actualizaciones disponibles.";

$GLOBALS['strServerCommunicationError'] = "<b>La comunicación con el servidor de actualización ha tardado demasiado tiempo, por lo cual {$PRODUCT_NAME} no puede determinar si existe una nueva versión disponible en este momento. Por favor, intente nuevamente más tarde.</b>";

$GLOBALS['strCheckForUpdatesDisabled'] = "<b>Comprobar actualizaciones está deshabilitado. Por favor habilite esa opción en la pantalla <a href='account-settings-update.php'>actualizar opciones</a>.</b>";

$GLOBALS['strNewVersionAvailable'] = "<b>Una nueva versión de {$PRODUCT_NAME} se encuentra disponible.</b><br /> Se recomienda instalar esta actualización, ya que puede arreglar algunos problemas existentes y agregar características nuevas. Para más información sobre actualizaciones, por favor lea la documentación incluída en los archivos.";

$GLOBALS['strSecurityUpdate'] = "<b>Es altamente recomendable instalar esta actualización, ya que contiene parches de seguridad.</b>
La versión de  que se encuentra usando es vulnerable a ciertos ataques y probablemente no sea segura. Para mayor información sobre actualizaciones, por favor lea la documentación incluída en los archivos.";

$GLOBALS['strNotAbleToCheck'] = "<b>Debido a que la extensión XML no está disponible en su servidor, {$PRODUCT_NAME} no puede comprobar si hay una nueva versión disponible.</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "Si quiere saber si hay una nueva versión disponible, por favor, consulte en nuestra página web.";

$GLOBALS['strClickToVisitWebsite'] = "Haga clic aquí para visitar nuestra página web";
$GLOBALS['strCurrentlyUsing'] = "Actualmente está usando";
$GLOBALS['strRunningOn'] = "funcionando bajo";
$GLOBALS['strAndPlain'] = "y";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "Limitaciones de entrega";
$GLOBALS['strAllBannerChannelCompiled'] = "Todos los valores compilados de limitaciones de banners/canales han sido recompilados";
$GLOBALS['strBannerChannelResult'] = "Aqui están los resultados de la validación de las limitaciones compiladas de banners/canales";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Todas las limitaciones de canales compiladas son válidas";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Todas las limitaciones de banners compiladas son válidas";
$GLOBALS['strErrorsFound'] = "Errores encontrados";
$GLOBALS['strRepairCompiledLimitations'] = "Se encontraron algunas incosistencias anteriormente, puede repararlas usando el botón de abajo, este recompilará las limitaciones compiladas para cada banner/canal en el sistema<br />";
$GLOBALS['strRecompile'] = "Recompilar";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "Bajo algunas circustancias el motor de entrega puede discrepar con algunas de las ACLs para los banners y cananles, use el siguiente enlace para validar las ACLs de la base de datos";
$GLOBALS['strCheckACLs'] = "Revisar ACLs";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "Bajo algunas circustancias el motor de entrega puede discrepar con algunos de los códigos agregados para los trackers, use el siguiente enlace para validar los códigos agregados a la base de datos ";
$GLOBALS['strCheckAppendCodes'] = "Chequear códigos agregados";
$GLOBALS['strAppendCodesRecompiled'] = "Todos los valores de los códigos compilados agregados han sido recompilados";
$GLOBALS['strAppendCodesResult'] = "Aquí están los resultados de la validación de códigos agregados";
$GLOBALS['strAppendCodesValid'] = "Todos los trackers de los códigos agregados compilados son válidos";
$GLOBALS['strRepairAppenedCodes'] = "Se encontraron algunas inconsistencias arriba, puede repararlas usando el botón de abajo, esto recompilará los códigos agregados para cada tracker en el sistema";

$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strPluginsPrecis'] = "Diagnosticar y reparar problemas con plugins de {$PRODUCT_NAME}";

$GLOBALS['strMenus'] = "Menús";
$GLOBALS['strMenusPrecis'] = "Reconstruir la cache de menú";
$GLOBALS['strMenusCachedOk'] = "Caché de menú ha sido reconstruido";
