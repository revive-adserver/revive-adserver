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

// Other
$GLOBALS['strCopyToClipboard'] = "Copiar al portapapeles";
$GLOBALS['strCopy'] = "Copiar al portapapeles";
$GLOBALS['strChooseTypeOfInvocation'] = "Por favor, elija el tipo de invocación";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Por favor, elija el tipo de invocación de banner";

// Measures
$GLOBALS['strAbbrSeconds'] = "seg";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Selección de banner";
$GLOBALS['strInvocationClientID'] = "Anunciante o campaña";
$GLOBALS['strInvocationCampaignID'] = "Campaña";
$GLOBALS['strInvocationTarget'] = "Marco de destino";
$GLOBALS['strInvocationSource'] = "Origen";
$GLOBALS['strInvocationWithText'] = "Mostrar texto después del banner";
$GLOBALS['strInvocationDontShowAgain'] = "No volver a mostrar el banner en la misma página";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "No volver a mostrar un banner de la misma campaña en la misma página";
$GLOBALS['strInvocationTemplate'] = "Guardar el baner en una variable para ser usado en una plantilla";
$GLOBALS['strInvocationBannerID'] = "ID banner";
$GLOBALS['strInvocationComments'] = "Incluir comentarios";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "Actualizar después de";
$GLOBALS['strIframeResizeToBanner'] = "Ajustar el iframe según las dimensiones del banner";
$GLOBALS['strIframeMakeTransparent'] = "Hacer el iframe transparente";
$GLOBALS['strIframeIncludeNetscape4'] = "Incluir ilayer compatible con Netscape 4";
$GLOBALS['strIframeGoogleClickTracking'] = "Incluir codigo para registrar los clicks de Google AdSense";


// PopUp
$GLOBALS['strPopUpStyle'] = "Tipo de Pop-up";
$GLOBALS['strAutoCloseAfter'] = "Cerrar automáticamente despues de";
$GLOBALS['strPopUpTop'] = "Posición inicial (superior)";
$GLOBALS['strPopUpLeft'] = "Posición inicial (izquierda)";


// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Idioma del Host";


// AdLayer
$GLOBALS['strAdLayerStyle'] = "Estilo";

$GLOBALS['strAlignment'] = "Alineación";
$GLOBALS['strHAlignment'] = "Alineación horizontal";
$GLOBALS['strLeft'] = "Izquierda";
$GLOBALS['strCenter'] = "Centro";
$GLOBALS['strRight'] = "Derecha";

$GLOBALS['strVAlignment'] = "Alineación vertical";
$GLOBALS['strTop'] = "Superior";
$GLOBALS['strMiddle'] = "Medio";
$GLOBALS['strBottom'] = "Inferior";

$GLOBALS['strAutoCollapseAfter'] = "Colapsar automáticamente despues de";
$GLOBALS['strCloseText'] = "Cerrar texto";
$GLOBALS['strClose'] = "[Cerrar]";

$GLOBALS['strHShift'] = "Cambio horizontal";
$GLOBALS['strVShift'] = "Cambio vertical";

$GLOBALS['strShowCloseButton'] = "Ver el botón de Cerrar";
$GLOBALS['strBackgroundColor'] = "Color de fondo";
$GLOBALS['strBorderColor'] = "Color de borde";

$GLOBALS['strDirection'] = "Dirección";
$GLOBALS['strLeftToRight'] = "Derecha a Izquierda";
$GLOBALS['strRightToLeft'] = "Izquierda a Derecha";
$GLOBALS['strAlwaysActive'] = "Siempre activo";
$GLOBALS['strSpeed'] = "Velocidad";
$GLOBALS['strPause'] = "Pausar";
$GLOBALS['strLimited'] = "Limitado";
$GLOBALS['strLeftMargin'] = "Margen Izquierdo";
$GLOBALS['strRightMargin'] = "Margen Derecho";
$GLOBALS['strTransparentBackground'] = "Fondo trasparente";



$GLOBALS['strAdLayerStyleName'] = array();
$GLOBALS['strAdLayerStyleName']['floater'] = "Flotante";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "Permitir <i>clicktracking</i> de servidores de terceros";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Insertar código anti-cache";

// Non-Img creatives Warning for zone image-only invocation

// unkown HTML tag type Warning for zone invocation

// sql/web banner-type warning for clickonly zone invocation

// IMG invocation selected for tracker with appended code
$GLOBALS['strImgWithAppendWarning'] = "Este tracker tiene código asociado; dicho código <strong>sólo</strong> funcionará con tags Javascript";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Atención</strong> Invocación de modo local SÓLO funcionará si el sitio que hace la llamada al código está en la misma máquina física que el servidor de publicidad</span><br />Revise que el MAX_PATH definido en el código que hay a continuación apunta al directorio raízde su instalación de {$PRODUCT_NAME}<br />y que tiene un archivo de configuración para el dominio del sitio que muestra los anuncios (en MAX_PATH/var)";

