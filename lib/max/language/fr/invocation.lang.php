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
$GLOBALS['strCopyToClipboard'] = "Copier dans le presse-papier";
$GLOBALS['strCopy'] = "copier";
$GLOBALS['strChooseTypeOfInvocation'] = "Veuillez choisir le type d'invocation";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Veuillez choisir le type d'invocation de bannières";

// Measures
$GLOBALS['strAbbrPixels'] = "px";
$GLOBALS['strAbbrSeconds'] = "sec";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Sélection de bannières";
$GLOBALS['strInvocationCampaignID'] = "Campagne";
$GLOBALS['strInvocationTarget'] = "Cadre cible";
$GLOBALS['strInvocationSource'] = "Source";
$GLOBALS['strInvocationWithText'] = "Afficher du texte sous la bannière";
$GLOBALS['strInvocationDontShowAgain'] = "Ne pas afficher la bannière à nouveau sur la même page";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Ne pas afficher une bannière de la même campagne à nouveau sur la même page";
$GLOBALS['strInvocationTemplate'] = "Stocker la bannière dans une variable afin de pouvoir l'utiliser dans un modèle";
$GLOBALS['strInvocationBannerID'] = "ID de la bannière";
$GLOBALS['strInvocationComments'] = "Inclure les commentaires";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "Actualiser après";
$GLOBALS['strIframeResizeToBanner'] = "Redimensionner l'iframe aux dimensions de la bannière";
$GLOBALS['strIframeMakeTransparent'] = "Rendre l'iframe transparente";
$GLOBALS['strIframeIncludeNetscape4'] = "Inclure un ilayer compatible Netscape 4";
$GLOBALS['strIframeGoogleClickTracking'] = "Inclure le code de suivi des clics Google AdSense";

// PopUp
$GLOBALS['strPopUpStyle'] = "Type de Popup";
$GLOBALS['strPopUpStylePopUp'] = "Popup Avant-plan";
$GLOBALS['strPopUpStylePopUnder'] = "Popup Arrière-plan";
$GLOBALS['strPopUpCreateInstance'] = "Moment où le popup est crée";
$GLOBALS['strPopUpImmediately'] = "Immédiatement";
$GLOBALS['strPopUpOnClose'] = "Lorsque la page est fermée";
$GLOBALS['strPopUpAfterSec'] = "Après";
$GLOBALS['strAutoCloseAfter'] = "Fermer automatiquement après";
$GLOBALS['strPopUpTop'] = "Position initiale (haut)";
$GLOBALS['strPopUpLeft'] = "Position initiale (gauche)";
$GLOBALS['strWindowOptions'] = "Window options";
$GLOBALS['strShowToolbars'] = "Toolbars";
$GLOBALS['strShowLocation'] = "Location";
$GLOBALS['strShowMenubar'] = "Menubar";
$GLOBALS['strShowStatus'] = "État";
$GLOBALS['strWindowResizable'] = "Resizable";
$GLOBALS['strShowScrollbars'] = "Scrollbars";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Language de la machine cliente";
$GLOBALS['strXmlRpcProtocol'] = "Use HTTPS to contact XML-RPC Server";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC Timeout (Seconds)";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "Supporter le suivi des clics par un serveur tiers";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Insérer un code empêchant la mise en cache";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Avertissement";
$GLOBALS['strImgWithAppendWarning'] = "Ce suiveur contient du code ajouté qui fonctionnera <strong>uniquement</strong> avec des balises JavaScript";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
is on the same physical machine as the adserver</span><br />
Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Note:</b> Local Mode invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Note:</b> XML-RPC invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
