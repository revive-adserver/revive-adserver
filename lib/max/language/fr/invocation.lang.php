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

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Sélection de bannières";
$GLOBALS['strInvocationClientID'] = "Annonceur ou campagne";
$GLOBALS['strInvocationCampaignID'] = "Campagne";
$GLOBALS['strInvocationTarget'] = "Cadre cible";
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


// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Language de la machine cliente";


// AdLayer

$GLOBALS['strAlignment'] = "Alignement";
$GLOBALS['strHAlignment'] = "Alignement horizontal";
$GLOBALS['strLeft'] = "Gauche";
$GLOBALS['strCenter'] = "Centré";
$GLOBALS['strRight'] = "Droite";

$GLOBALS['strVAlignment'] = "Alignement vertical";
$GLOBALS['strTop'] = "Haut";
$GLOBALS['strMiddle'] = "Milieu";
$GLOBALS['strBottom'] = "Bas";

$GLOBALS['strAutoCollapseAfter'] = "Réduire automatiquement après";
$GLOBALS['strCloseText'] = "Texte de fermeture";
$GLOBALS['strClose'] = "[Fermer]";
$GLOBALS['strBannerPadding'] = "Espace bordure/bannière";

$GLOBALS['strHShift'] = "Décalage horizontal";
$GLOBALS['strVShift'] = "Décalage vertical";

$GLOBALS['strShowCloseButton'] = "Montrer le bouton de fermeture";
$GLOBALS['strBackgroundColor'] = "Couleur d'arrière-plan";
$GLOBALS['strBorderColor'] = "Couleur de bordure";

$GLOBALS['strLeftToRight'] = "De gauche à droite";
$GLOBALS['strRightToLeft'] = "De droite à gauche";
$GLOBALS['strLooping'] = "Nombre de passages";
$GLOBALS['strAlwaysActive'] = "Toujours actif";
$GLOBALS['strSpeed'] = "Vitesse";
$GLOBALS['strPause'] = "Mettre en pause";
$GLOBALS['strLimited'] = "Limité";
$GLOBALS['strLeftMargin'] = "Marge gauche";
$GLOBALS['strRightMargin'] = "Marge droite";
$GLOBALS['strTransparentBackground'] = "Arrière-plan transparent";

$GLOBALS['strSmoothMovement'] = "Flou dans le mouvement";
$GLOBALS['strHideNotMoving'] = "Cacher la bannière lorsque la souris ne bouge pas";
$GLOBALS['strHideDelay'] = "Délai avant que la bannière ne soit cachée";
$GLOBALS['strHideTransparancy'] = "Transparence de la bannière cachée";


$GLOBALS['strAdLayerStyleName'] = array();
$GLOBALS['strAdLayerStyleName']['cursor'] = "Curseur";
$GLOBALS['strAdLayerStyleName']['floater'] = "Flottant";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "Supporter le suivi des clics par un serveur tiers";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Insérer un code empêchant la mise en cache";

// Non-Img creatives Warning for zone image-only invocation

// unkown HTML tag type Warning for zone invocation

// sql/web banner-type warning for clickonly zone invocation

// IMG invocation selected for tracker with appended code
$GLOBALS['strImgWithAppendWarning'] = "Ce suiveur contient du code ajouté qui fonctionnera <strong>uniquement</strong> avec des balises JavaScript";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Attention :</strong> Le mode d'invocation local ne fonctionnera QUE si le site appelant le code est sur la même machine physique que le serveur publicitaire</span><br />Vérifiez que le MAX_PATH défini dans le code ci-dessous pointe vers le répertoire de base de votre installation MAX<br />et que vous avez un fichier de configuration pour le domaine du site affichant les publicités (dans MAX_PATH/var)";

