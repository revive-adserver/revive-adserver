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
$GLOBALS['strAbbrPixels'] = "px";
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
$GLOBALS['strPopUpStylePopUp'] = "Pop-up";
$GLOBALS['strPopUpStylePopUnder'] = "Pop-under";
$GLOBALS['strPopUpCreateInstance'] = "Instance when the pop-up is created";
$GLOBALS['strPopUpImmediately'] = "Immediately";
$GLOBALS['strPopUpOnClose'] = "Cuando se cierra la página";
$GLOBALS['strPopUpAfterSec'] = "Después de";
$GLOBALS['strAutoCloseAfter'] = "Cerrar automáticamente despues de";
$GLOBALS['strPopUpTop'] = "Posición inicial (superior)";
$GLOBALS['strPopUpLeft'] = "Posición inicial (izquierda)";
$GLOBALS['strWindowOptions'] = "Opciones de ventana";
$GLOBALS['strShowToolbars'] = "Barras de herramientas";
$GLOBALS['strShowLocation'] = "Ubicación";
$GLOBALS['strShowMenubar'] = "Barra de menú";
$GLOBALS['strShowStatus'] = "Estado";
$GLOBALS['strWindowResizable'] = "Redimensionable";
$GLOBALS['strShowScrollbars'] = "Barras de desplazamiento";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Idioma del Host";
$GLOBALS['strXmlRpcProtocol'] = "Utilizar HTTPS para contactar con el servidor XML-RPC";
$GLOBALS['strXmlRpcTimeout'] = "Tiempo de espera XML-RPC (segundos)";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "Permitir <i>clicktracking</i> de servidores de terceros";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Insertar código anti-cache";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Advertencia";
$GLOBALS['strImgWithAppendWarning'] = "Este tracker tiene código asociado; dicho código <strong>sólo</strong> funcionará con tags Javascript";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
is on the same physical machine as the adserver</span><br />
Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Note:</b> Local Mode invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Note:</b> XML-RPC invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
