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

// Invocation Types
$GLOBALS['strInvocationRemote']			= "Invocación Remota";
$GLOBALS['strInvocationJS']				= "Invocación Remota para Javascript";
$GLOBALS['strInvocationIframes']		= "Invocación Remota para Frames";
$GLOBALS['strInvocationXmlRpc']			= "Invocación Remota usando XML-RPC";
$GLOBALS['strInvocationCombined']		= "Invocación Remota Combinada";
$GLOBALS['strInvocationPopUp']			= "Pop-up";
$GLOBALS['strInvocationAdLayer']		= "Interstitial o DHTML Flotante";
$GLOBALS['strInvocationLocal']			= "Modo local";


// Other
$GLOBALS['strCopyToClipboard']			= "Copiar al portapapeles";


// Measures
$GLOBALS['strAbbrPixels']				= "px";
$GLOBALS['strAbbrSeconds']				= "seg";


// Common Invocation Parameters
$GLOBALS['strInvocationWhat']			= "Selección de banner";
$GLOBALS['strInvocationClientID']		= "Anunciante o campaña";
$GLOBALS['strInvocationTarget']			= "Marco de destino";
$GLOBALS['strInvocationSource']			= "Origen";
$GLOBALS['strInvocationWithText']		= "Mostrar texto después del banner";
$GLOBALS['strInvocationDontShowAgain']	= "No volver a mostrar el banner en la misma página";
$GLOBALS['strInvocationTemplate'] 		= "Guardar el baner en una variable para ser usado en una plantilla";


// Iframe
$GLOBALS['strIFrameRefreshAfter']		= "Actualizar después de";
$GLOBALS['strIframeResizeToBanner']		= "Ajustar el iframe según las dimensiones del banner";
$GLOBALS['strIframeMakeTransparent']	= "Hacer el iframe transparente";
$GLOBALS['strIframeIncludeNetscape4']	= "Incluir ilayer compatible con Netscape 4";


// PopUp
$GLOBALS['strPopUpStyle']				= "Tipo de Pop-up";
$GLOBALS['strPopUpStylePopUp']			= "Pop-up";
$GLOBALS['strPopUpStylePopUnder']		= "Pop-under";
$GLOBALS['strAutoCloseAfter']			= "Cerrar automáticamente despues de";
$GLOBALS['strPopUpTop']					= "Posición inicial (superior)";
$GLOBALS['strPopUpLeft']				= "Posición inicial (izquierda)";


// XML-RPC
$GLOBALS['strXmlRpcLanguage']			= "Idioma del Host";


// AdLayer
$GLOBALS['strAdLayerStyle']				= "Estilo";

$GLOBALS['strAlignment']				= "Alineación";
$GLOBALS['strHAlignment']				= "Alineación horizontal";
$GLOBALS['strLeft']						= "Izquierda";
$GLOBALS['strCenter']					= "Centro";
$GLOBALS['strRight']					= "Derecha";

$GLOBALS['strVAlignment']				= "Alineación vertical";
$GLOBALS['strTop']						= "Superior";
$GLOBALS['strMiddle']					= "Medio";
$GLOBALS['strBottom']					= "Inferior";

$GLOBALS['strAutoCollapseAfter']		= "Colapsar automáticamente despues de";
$GLOBALS['strCloseText']				= "Cerrar texto";
$GLOBALS['strClose']					= "[Cerrar]";
$GLOBALS['strBannerPadding']			= "Banner padding";

$GLOBALS['strHShift']					= "Cambio horizontal";
$GLOBALS['strVShift']					= "Cambio vertical";

$GLOBALS['strShowCloseButton']			= "Ver el botón de Cerrar";
$GLOBALS['strBackgroundColor']			= "Color de fondo";
$GLOBALS['strBorderColor']				= "Color de borde";

$GLOBALS['strDirection']				= "Dirección";
$GLOBALS['strLeftToRight']				= "Derecha a Izquierda";
$GLOBALS['strRightToLeft']				= "Izquierda a Derecha";
$GLOBALS['strLooping']					= "Looping";
$GLOBALS['strAlwaysActive']				= "Siempre activo";
$GLOBALS['strSpeed']					= "Velocidad";
$GLOBALS['strPause']					= "Pausar";
$GLOBALS['strLimited']					= "Limitado";
$GLOBALS['strLeftMargin']				= "Margen Izquierdo";
$GLOBALS['strRightMargin']				= "Margen Derecho";
$GLOBALS['strTransparentBackground']	= "Fondo trasparente";


$GLOBALS['strAdLayerStyleName']['geocities'] = "Geocities";
$GLOBALS['strAdLayerStyleName']['simple'] = "Simple";
$GLOBALS['strAdLayerStyleName']['cursor'] = "Cursor";
$GLOBALS['strAdLayerStyleName']['floater'] = "Flotante";




// Note: new translatiosn not found in original lang files but found in CSV
$GLOBALS['strCopy'] = "Copiar al portapapeles";
$GLOBALS['strInvocationCampaignID'] = "Campaña";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "No volver a mostrar un banner de la misma campaña en la misma página";
$GLOBALS['strInvocationBannerID'] = "ID banner";
$GLOBALS['strInvocationComments'] = "Incluir comentarios";
$GLOBALS['str3rdPartyTrack'] = "Permitir <i>clicktracking</i> de servidores de terceros";
$GLOBALS['strCacheBuster'] = "Insertar código anti-cache";
$GLOBALS['strImgWithAppendWarning'] = "Este tracker tiene código asociado; dicho código <strong>sólo</strong> funcionará con tags Javascript";


// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strIframeGoogleClickTracking'] = "Incluir codigo para registrar los clicks de Google AdSense";
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Atención</strong> Invocación de modo local SÓLO funcionará si el sitio que hace la llamada al código está en la misma máquina física que el servidor de publicidad</span><br />Revise que el MAX_PATH definido en el código que hay a continuación apunta al directorio raízde su instalación de ". MAX_PRODUCT_NAME ."<br />y que tiene un archivo de configuración para el dominio del sitio que muestra los anuncios (en MAX_PATH/var)";
$GLOBALS['strChooseTypeOfInvocation'] = "Por favor, elija el tipo de invocación";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Por favor, elija el tipo de invocación de banner";
?>