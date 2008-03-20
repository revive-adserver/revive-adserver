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
$GLOBALS['strInvocationRemote']		= "Remota";
$GLOBALS['strInvocationJS']			= "Remota por Javascript";
$GLOBALS['strInvocationIframes']	= "Remota por Frames";
$GLOBALS['strInvocationXmlRpc']		= "Remota usando XML-RPC";
$GLOBALS['strInvocationCombined']	= "Remota Combinada";
$GLOBALS['strInvocationPopUp']		= "Pop-up";
$GLOBALS['strInvocationAdLayer']	= "Intersticial ou DHTML Flutuante";
$GLOBALS['strInvocationLocal']		= "Modo Local";

// Other
$GLOBALS['strCopyToClipboard']		= "Copiar para área de transferência";

// Measures
$GLOBALS['strAbbrPixels']			= "px";
$GLOBALS['strAbbrSeconds']			= "seg.";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat']			= "Seleção de banner";
$GLOBALS['strInvocationClientID']		= "Anunciante ou campanha";
$GLOBALS['strInvocationTarget']			= "Frame de destino";
$GLOBALS['strInvocationSource']			= "Fonte";
$GLOBALS['strInvocationWithText']		= "Mostrar texto abaixo do banner";
$GLOBALS['strInvocationDontShowAgain']	= "Não mostre o banner novamente na mesma página";
$GLOBALS['strInvocationTemplate'] 		= "Armazenar o banner em uma variável para ser utilizado em um template";

// Iframe
$GLOBALS['strIFrameRefreshAfter']		= "Recarregar após";
$GLOBALS['strIframeResizeToBanner']		= "Redimensionar iframe para as dimensões do banner";
$GLOBALS['strIframeMakeTransparent']	= "Fazer o iframe ser transparente";
$GLOBALS['strIframeIncludeNetscape4']	= "Incluir layer de compatibilidade para o Netscape 4";

// PopUp
$GLOBALS['strPopUpStyle']				= "Tipo de Pop-up";
$GLOBALS['strPopUpStylePopUp']			= "Pop-up";
$GLOBALS['strPopUpStylePopUnder']		= "Pop-under";
$GLOBALS['strPopUpCreateInstance']		= "Criar instï¿œncia quando o pop-up ï¿œ criado";
$GLOBALS['strPopUpImmediately']			= "Immediatamente";
$GLOBALS['strPopUpOnClose']				= "Quando a pï¿œgina ï¿œ encerrada";
$GLOBALS['strPopUpAfterSec']			= "Apï¿œs";
$GLOBALS['strAutoCloseAfter']			= "Automaticamente encerrada apï¿œs";
$GLOBALS['strPopUpTop']					= "Posiï¿œï¿œo Inicial (topo)";
$GLOBALS['strPopUpLeft']				= "Posiï¿œï¿œo Inicial (esquerda)";

// XML-RPC
$GLOBALS['strXmlRpcLanguage']			= "Linguagem do Servidor";

// AdLayer
$GLOBALS['strAdLayerStyle']				= "Estilo";

$GLOBALS['strAlignment']				= "Alinhamento";
$GLOBALS['strHAlignment']				= "Alinhamento Horizontal";
$GLOBALS['strLeft']						= "Esquerda";
$GLOBALS['strCenter']					= "Centrado";
$GLOBALS['strRight']					= "Direita";

$GLOBALS['strVAlignment']				= "Alinhamento Vertical";
$GLOBALS['strTop']						= "Topo";
$GLOBALS['strMiddle']					= "Meio";
$GLOBALS['strBottom']					= "Fundo";

$GLOBALS['strAutoCollapseAfter']		= "Desaparece automï¿œticamente apï¿œs";
$GLOBALS['strCloseText']				= "Texto de Fecho";
$GLOBALS['strClose']					= "[Fechar]";
$GLOBALS['strBannerPadding']			= "Margem interna";

$GLOBALS['strHShift']					= "Afastamento horizontal";
$GLOBALS['strVShift']					= "Afastamento vertical";

$GLOBALS['strShowCloseButton']			= "Mostrar botï¿œo de encerramento";
$GLOBALS['strBackgroundColor']			= "Cor de fundo";
$GLOBALS['strBorderColor']				= "Cor de borda";

$GLOBALS['strDirection']				= "Direcï¿œï¿œo";
$GLOBALS['strLeftToRight']				= "Esquerda para direita";
$GLOBALS['strRightToLeft']				= "Direita para esquerda";
$GLOBALS['strLooping']					= "Rotaï¿œï¿œo";
$GLOBALS['strAlwaysActive']				= "Sempre activa";
$GLOBALS['strSpeed']					= "Velocidade";
$GLOBALS['strPause']					= "Pausa";
$GLOBALS['strLimited']					= "Limitada";
$GLOBALS['strLeftMargin']				= "Margem esquerda";
$GLOBALS['strRightMargin']				= "Margem direita";
$GLOBALS['strTransparentBackground']	= "Fundo transparente";

$GLOBALS['strAdLayerStyleName']['geocities'] = "Geocities";
$GLOBALS['strAdLayerStyleName']['simple'] = "Simples";
$GLOBALS['strAdLayerStyleName']['cursor'] = "Cursor";
$GLOBALS['strAdLayerStyleName']['floater'] = "Flutuante";




// Note: new translatiosn not found in original lang files but found in CSV
$GLOBALS['strWarning'] = "Alerta";
$GLOBALS['strCopy'] = "copiar";
$GLOBALS['strInvocationCampaignID'] = "Campanha";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Não mostre um banner da mesma campanha novamente na mesma página";
$GLOBALS['strInvocationBannerID'] = "ID do Banner";
$GLOBALS['strInvocationComments'] = "Incluir comentários";
$GLOBALS['str3rdPartyTrack'] = "Suporte para rastreamento de cliques de terceiros";
$GLOBALS['strCacheBuster'] = "Inserir código anti-cache";
$GLOBALS['strImgWithAppendWarning'] = "Este rastreador tem código anexado, código anexado funcionará <strong>apenas</strong> com tags JavaScript";
?>