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
$GLOBALS['strCopyToClipboard'] = "Copiar para área de transferência";
$GLOBALS['strCopy'] = "copiar";
$GLOBALS['strChooseTypeOfInvocation'] = "Por favor escolha o tipo de inserção";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Por favor escolha o tipo de inserção de banner";

// Measures
$GLOBALS['strAbbrPixels'] = "px";
$GLOBALS['strAbbrSeconds'] = "seg.";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Seleção de banner";
$GLOBALS['strInvocationCampaignID'] = "Campanha";
$GLOBALS['strInvocationTarget'] = "Frame de destino";
$GLOBALS['strInvocationSource'] = "Fonte";
$GLOBALS['strInvocationWithText'] = "Mostrar texto abaixo do banner";
$GLOBALS['strInvocationDontShowAgain'] = "Não mostre o banner novamente na mesma página";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Não mostre um banner da mesma campanha novamente na mesma página";
$GLOBALS['strInvocationTemplate'] = "Armazenar o banner em uma variável para ser utilizado em um template";
$GLOBALS['strInvocationBannerID'] = "ID do Banner";
$GLOBALS['strInvocationComments'] = "Incluir comentários";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "Recarregar após";
$GLOBALS['strIframeResizeToBanner'] = "Redimensionar iframe para as dimensões do banner";
$GLOBALS['strIframeMakeTransparent'] = "Fazer o iframe ser transparente";
$GLOBALS['strIframeIncludeNetscape4'] = "Incluir layer de compatibilidade para o Netscape 4";
$GLOBALS['strIframeGoogleClickTracking'] = "Incluir código para rastrear cliques do Google Adsense";

// PopUp
$GLOBALS['strPopUpStyle'] = "Tipo de Pop-up";
$GLOBALS['strPopUpStylePopUp'] = "Pop-up";
$GLOBALS['strPopUpStylePopUnder'] = "Pop-under";
$GLOBALS['strPopUpCreateInstance'] = "Criar instï¿œncia quando o pop-up ï¿œ criado";
$GLOBALS['strPopUpImmediately'] = "Immediatamente";
$GLOBALS['strPopUpOnClose'] = "Quando a pï¿œgina ï¿œ encerrada";
$GLOBALS['strPopUpAfterSec'] = "Apï¿œs";
$GLOBALS['strAutoCloseAfter'] = "Automaticamente encerrada apï¿œs";
$GLOBALS['strPopUpTop'] = "Posiï¿œï¿œo Inicial (topo)";
$GLOBALS['strPopUpLeft'] = "Posiï¿œï¿œo Inicial (esquerda)";
$GLOBALS['strWindowOptions'] = "Window options";
$GLOBALS['strShowToolbars'] = "Toolbars";
$GLOBALS['strShowLocation'] = "Location";
$GLOBALS['strShowMenubar'] = "Menubar";
$GLOBALS['strShowStatus'] = "Estado";
$GLOBALS['strWindowResizable'] = "Resizable";
$GLOBALS['strShowScrollbars'] = "Scrollbars";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Linguagem do Servidor";
$GLOBALS['strXmlRpcProtocol'] = "Use HTTPS to contact XML-RPC Server";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC Timeout (Seconds)";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "Suporte para rastreamento de cliques de terceiros";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Inserir código anti-cache";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Alerta";
$GLOBALS['strImgWithAppendWarning'] = "Este rastreador tem código anexado, código anexado funcionará <strong>apenas</strong> com tags JavaScript";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
is on the same physical machine as the adserver</span><br />
Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Note:</b> Local Mode invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Note:</b> XML-RPC invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
