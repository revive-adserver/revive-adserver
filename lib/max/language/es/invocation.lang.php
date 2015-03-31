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
$GLOBALS['strShowStatus'] = "Estado";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Idioma del Host";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "Permitir <i>clicktracking</i> de servidores de terceros";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Insertar código anti-cache";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Advertencia";
$GLOBALS['strImgWithAppendWarning'] = "Este tracker tiene código asociado; dicho código <strong>sólo</strong> funcionará con tags Javascript";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Atención</strong> Invocación de modo local SÓLO funcionará si el sitio que hace la llamada al código está en la misma máquina física que el servidor de publicidad</span><br />Revise que el MAX_PATH definido en el código que hay a continuación apunta al directorio raízde su instalación de {$PRODUCT_NAME}<br />y que tiene un archivo de configuración para el dominio del sitio que muestra los anuncios (en MAX_PATH/var)";

