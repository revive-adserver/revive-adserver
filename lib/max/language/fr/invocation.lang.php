<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$GLOBALS['strInvocationRemote']			= 'Invocation distante';
$GLOBALS['strInvocationJS']			= 'Invocation distante avec Javascript';
$GLOBALS['strInvocationIframes']		= 'Invocation distante avec Frames';
$GLOBALS['strInvocationXmlRpc']			= 'Invocation distante avec XML-RPC';
$GLOBALS['strInvocationCombined']		= 'Invocation distante combinée';
$GLOBALS['strInvocationPopUp']			= 'Popup';
$GLOBALS['strInvocationAdLayer']		= 'Interstitiel ou DHTML flottant';
$GLOBALS['strInvocationLocal']			= 'Mode local';


// Other
$GLOBALS['strCopyToClipboard']			= 'Copier dans le presse-papier';


// Measures
$GLOBALS['strAbbrPixels']			= 'px';
$GLOBALS['strAbbrSeconds']			= 'sec';


// Common Invocation Parameters
$GLOBALS['strInvocationWhat']			= 'Sélection de bannières';
$GLOBALS['strInvocationClientID']		= 'Annonceur ou campagne';
$GLOBALS['strInvocationTarget']			= 'Cadre cible';
$GLOBALS['strInvocationSource']			= 'Source';
$GLOBALS['strInvocationWithText']		= 'Afficher du texte sous la bannière';
$GLOBALS['strInvocationDontShowAgain']		= 'Ne pas afficher la bannière à nouveau sur la même page';
$GLOBALS['strInvocationDontShowAgainCampaign']	= 'Ne pas afficher une bannière de la même campagne à nouveau sur la même page';
$GLOBALS['strInvocationTemplate'] 		= 'Stocker la bannière dans une variable afin de pouvoir l\'utiliser dans un modèle';


// Iframe
$GLOBALS['strIFrameRefreshAfter']		= 'Actualiser après';
$GLOBALS['strIframeResizeToBanner']		= 'Redimensionner l\'iframe aux dimensions de la bannière';
$GLOBALS['strIframeMakeTransparent']		= 'Rendre l\'iframe transparente';
$GLOBALS['strIframeIncludeNetscape4']		= 'Inclure un ilayer compatible Netscape 4';


// PopUp
$GLOBALS['strPopUpStyle']			= 'Type de Popup';
$GLOBALS['strPopUpStylePopUp']			= 'Popup Avant-plan';
$GLOBALS['strPopUpStylePopUnder']		= 'Popup Arrière-plan';
$GLOBALS['strPopUpCreateInstance']		= 'Moment où le popup est crée';
$GLOBALS['strPopUpImmediately']			= 'Immédiatement';
$GLOBALS['strPopUpOnClose']			= 'Lorsque la page est fermée';
$GLOBALS['strPopUpAfterSec']			= 'Après';
$GLOBALS['strAutoCloseAfter']			= 'Fermer automatiquement après';
$GLOBALS['strPopUpTop']				= 'Position initiale (haut)';
$GLOBALS['strPopUpLeft']			= 'Position initiale (gauche)';


// XML-RPC
$GLOBALS['strXmlRpcLanguage']			= 'Language de la machine cliente';


// AdLayer
$GLOBALS['strAdLayerStyle']			= 'Style';

$GLOBALS['strAlignment']			= 'Alignement';
$GLOBALS['strHAlignment']			= 'Alignement horizontal';
$GLOBALS['strLeft']				= 'Gauche';
$GLOBALS['strCenter']				= 'Centré';
$GLOBALS['strRight']				= 'Droite';

$GLOBALS['strVAlignment']			= 'Alignement vertical';
$GLOBALS['strTop']				= 'Haut';
$GLOBALS['strMiddle']				= 'Milieu';
$GLOBALS['strBottom']				= 'Bas';

$GLOBALS['strAutoCollapseAfter']		= 'Réduire automatiquement après';
$GLOBALS['strCloseText']			= 'Texte de fermeture';
$GLOBALS['strClose']				= '[Fermer]';
$GLOBALS['strBannerPadding']			= 'Espace bordure/bannière';

$GLOBALS['strHShift']				= 'Décalage horizontal';
$GLOBALS['strVShift']				= 'Décalage vertical';

$GLOBALS['strShowCloseButton']			= 'Montrer le bouton de fermeture';
$GLOBALS['strBackgroundColor']			= 'Couleur d\'arrière-plan';
$GLOBALS['strBorderColor']			= 'Couleur de bordure';

$GLOBALS['strDirection']			= 'Direction';
$GLOBALS['strLeftToRight']			= 'De gauche à droite';
$GLOBALS['strRightToLeft']			= 'De droite à gauche';
$GLOBALS['strLooping']				= 'Nombre de passages';
$GLOBALS['strAlwaysActive']			= 'Toujours actif';
$GLOBALS['strSpeed']				= 'Vitesse';
$GLOBALS['strPause']				= 'Mettre en pause';
$GLOBALS['strLimited']				= 'Limité';
$GLOBALS['strLeftMargin']			= 'Marge gauche';
$GLOBALS['strRightMargin']			= 'Marge droite';
$GLOBALS['strTransparentBackground']		= 'Arrière-plan transparent';

$GLOBALS['strSmoothMovement']			= 'Flou dans le mouvement';
$GLOBALS['strHideNotMoving']			= 'Cacher la bannière lorsque la souris ne bouge pas';
$GLOBALS['strHideDelay']			= 'Délai avant que la bannière ne soit cachée';
$GLOBALS['strHideTransparancy']			= 'Transparence de la bannière cachée';


$GLOBALS['strAdLayerStyleName']['geocities'] = "Geocities";
$GLOBALS['strAdLayerStyleName']['simple'] = "Simple";
$GLOBALS['strAdLayerStyleName']['cursor'] = "Curseur";
$GLOBALS['strAdLayerStyleName']['floater'] = "Flottant";




// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strInvocationCampaignID'] = "Campagne";
$GLOBALS['strCopy'] = "copier";
$GLOBALS['strInvocationBannerID'] = "ID de la bannière";
$GLOBALS['strInvocationComments'] = "Inclure les commentaires";
$GLOBALS['str3rdPartyTrack'] = "Supporter le suivi des clics par un serveur tiers";
$GLOBALS['strCacheBuster'] = "Insérer un code empêchant la mise en cache";
$GLOBALS['strImgWithAppendWarning'] = "Ce suiveur contient du code ajouté qui fonctionnera <strong>uniquement</strong> avec des balises JavaScript";
$GLOBALS['strIframeGoogleClickTracking'] = "Inclure le code de suivi des clics Google AdSense";
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Attention :</strong> Le mode d'invocation local ne fonctionnera QUE si le site appelant le code est sur la même machine physique que le serveur publicitaire</span><br />Vérifiez que le MAX_PATH défini dans le code ci-dessous pointe vers le répertoire de base de votre installation MAX<br />et que vous avez un fichier de configuration pour le domaine du site affichant les publicités (dans MAX_PATH/var)";
$GLOBALS['strChooseTypeOfInvocation'] = "Veuillez choisir le type d'invocation";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Veuillez choisir le type d'invocation de bannières";
?>