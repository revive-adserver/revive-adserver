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
$GLOBALS['strChooseSection']				= "Elija la secci&oacute;n";


// Priority
$GLOBALS['strRecalculatePriority']			= "Recalcular prioridad";
$GLOBALS['strHighPriorityCampaigns']		= "Campa&ntilde;as de Alta Prioridad";
$GLOBALS['strAdViewsAssigned']				= "Impresiones Asignadas";
$GLOBALS['strLowPriorityCampaigns']			= "Campa&ntilde;as de Baja Prioridad";
$GLOBALS['strPredictedAdViews']				= "Impresiones Predecidas";
$GLOBALS['strPriorityDaysRunning']			= "Actualmente hay {days} d&iacute;as de estad&iacute;sticas disponibles sobre los cuales ".$phpAds_productname." podr&aacute; basarse para predecir diariamente. ";
$GLOBALS['strPriorityBasedLastWeek']		= "La predicci&oacute;n est&aacute; basada en datos de esta semana y la anterior. ";
$GLOBALS['strPriorityBasedLastDays']		= "La predicci&oacute;n est&aacute; basada en datos de los &uacute;ltimos d&iacute;as. ";
$GLOBALS['strPriorityBasedYesterday']		= "La predicci&oacute;n est&aacute; basada en datos de ayer. ";
$GLOBALS['strPriorityNoData']				= "No hay datos suficientes para realizar una predicci&oacute;n certera sobre el n&uacute;mero de impresiones que se generar&aacute;n hoy. Las predicciones est&aacute;n basadas en estad&iacute;sticas de tiempo real SOLAMENTE.";
$GLOBALS['strPriorityEnoughAdViews']		= "Debe haber Impresiones suficientes para satisfacer el objetivo de todas las campa&ntilde;as de alta prioridad. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "No est&aacute; claro cuantas Impresiones habr&aacute;n hoy para satisfacer el objetivo de todas las campa&ntilde;as de alta prioridad. Por este motivo todas las campa&ntilde;as de baja prioridad ser&aacute;n temporalmente deshabilitadas. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']			= "Reconstruir banner cache";
$GLOBALS['strBannerCacheExplaination']		= "
	El banner cache contiene una copia del c&oacute;digo HTML usado para mostrar el banner. Usando un banner cache es posible aumentar la velocidad
	de env&iacute;os de banners ya que el c&oacute;digo HTML no debe ser generado cada vez que un banner se env&iacute;a. Ya que el banner cache
	contiene hard coded URLs hacia la ubicaci*oacute;n de ".$phpAds_productname." y sus banners, el cache necesita actualizarse siempre que ".$phpAds_productname."
	sea movido a otra ubicaci&oacute;n dentro del webserver.
";


// Zone cache
$GLOBALS['strZoneCache']					= "Cache de Zona";
$GLOBALS['strAge']							= "Edad";
$GLOBALS['strRebuildZoneCache']				= "Reconstruir cache de zona";
$GLOBALS['strZoneCacheExplaination']		= "
	El cache de zona es usado para acelerar el env&iacute;o de baners relacionados a zonas. El cache de zona contiene una copia de todos los
	banners que est&aacute;n relacionados a la zona que guarda un n&uacute;mero de consultas de base de dato cuando los banners son enviados al
	usuario. El cache se reconstruye autom&aacute;ticamente cada vez que se realiza un cambio en la zona o en alguno de los banners de la misma.
	Es por esto que el cache se reconstruye autom&aacute;ticamente cada {seconds} segundos, pero tambi&eacute;n es posible hacerlo manualmente.
";


// Storage
$GLOBALS['strStorage']						= "Almacenamiento";
$GLOBALS['strMoveToDirectory']				= "Mover im&aacute;genes almacenadas en la base de datos a un directorio";
$GLOBALS['strStorageExplaination']			= "
	Las im&aacute;genes usadas por banners locales est&aacute;n almacenadas en la base de datos o bien en un directorio. Si Ud. almacena las imagenes en
	un directorio la carga en la base de datos se ver&aacute; reducida y esto provocar&aacute; que aumente su velocidad.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	Ud. habilit&oacute; las <i>estad&iacute;sticas compactas</i>, pero sus estad&iacute;sticas antiguas aparecer&aacute;n detalladas.
	Desea convertir sus antiguas estad&iacute;sticas al nuevo formato compacto?
";


// Product Updates
$GLOBALS['strSearchingUpdates']				= "Buscando Actualizaciones. Por favor espere...";
$GLOBALS['strAvailableUpdates']				= "Hay Actualizaciones Disponibles";
$GLOBALS['strDownloadZip']					= "Download (.zip)";
$GLOBALS['strDownloadGZip']					= "Download (.tar.gz)";

$GLOBALS['strUpdateAlert']					= "Se ha encontrado una nueva versi&oacute;n de ".$phpAds_productname." disponible.                 \\n\\nDesea obtener mas informaci&oacute;n \\nsobre esta actualizaci&oacute;n?";
$GLOBALS['strUpdateAlertSecurity']			= "Se ha encontrado una nueva versi&oacute;n de ".$phpAds_productname." disponible.                 \\n\\nEs altamnete recomendable que actualize el sistema \\ntan pronto como sea posible, ya que \\nesta versi&oacute;n contiene uno o mas problemas de seguridad.";

$GLOBALS['strUpdateServerDown']				= "
    Debido a razones desconocidas es imposible obtener<br />
	informaci&oacute;n sobre posibles actualizaciones. Por favor intentelo mas tarde.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	Su versi&oacute;n de ".$phpAds_productname." se encuentra actualizada. No hay actualizaciones disponibles.
";

$GLOBALS['strNewVersionAvailable']			= "
	<b>Una nueva versi&oacute;n de ".$phpAds_productname." se encuentra disponible.</b><br /> Se recomienda instalar esta actualizaci&oacute;n,
	ya que probablemente arregle algunos problemas existentes y agregue algunas caracter&iacute;sticas nuevas. Para mayor informaci&oacute;n
	sobre actualizaciones, por favor lea la documentaci&oacute;n incluida en los archivos.
";

$GLOBALS['strSecurityUpdate']				= "
	<b>Es altamente recomendable instalar esta actualizaci&oacute;n, ya que contiene un arreglos de seguridad.</b>
	La versi&oacute;n de ".$phpAds_productname." que se encuentra usando es vulnerable a ciertos ataques
	y probalemente no sea seguro. Para mayor informaci&oacute;n sobre actualizaciones por favor lea la documentaci&oacute;n incluida en los archivos.
";


// Stats conversion
$GLOBALS['strConverting']					= "Convirtiendo";
$GLOBALS['strConvertingStats']				= "Convirtiendo estad&iacute;sticas...";
$GLOBALS['strConvertStats']					= "Estad&iacute;sticas convertidas";
$GLOBALS['strConvertAdViews']				= "Impresiones convertidas,";
$GLOBALS['strConvertAdClicks']				= "Clicks convertidos...";
$GLOBALS['strConvertNothing']				= "No hay nada que convertir...";
$GLOBALS['strConvertFinished']				= "Finalizado...";

$GLOBALS['strConvertExplaination']			= "
	Ud. actualmente est&aacute; usando el formato compacto para almacenar sus estad&iacute;sticas, pero a&uacute;n hay<br />
	algunas estad&iacute;sticas en formato extendido. Hasta que no sean convertidas al formato compacto <br />
	no podr&aacute;n verse en estas p&aacute;ginas. <br />
	Antes de convertir sus estad&iacute;sticas, haga un backup de su base de datos! <br />
	Desea convertir sus estad&iacute;sticas extendidas al nuevo formato compacto? <br />
";

$GLOBALS['strConvertingExplaination']		= "
	Todas las estad&iacute;sticas expandidas est&aacute;n siendo convertidas al formato compacto. <br />
	Dependiendo de la cantidad de Impresiones hayan almacenadas en formato extendido tardar&aacute; <br />
	algunos minutos. Por favor espere mientras la conversi&oacute;n finaliza antes de visitar otra <br />
	p&aacute;gina. A continuaci&oacute;n ver&aacute; todas las modificaciones realizadas a la base de datos. <br />
";

$GLOBALS['strConvertFinishedExplaination']  = "
	La conversi&oacute;n de las estad&iacute;sticas extendidas restantes ha termindado. <br />
	A continuaci&oacute;n ver&aacute; todas las modificaciones realizadas al a base de datos. <br />
";


?>