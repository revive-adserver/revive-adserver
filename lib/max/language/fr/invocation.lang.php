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
$GLOBALS['strInvocationRemote']			= 'Invocation distante';
$GLOBALS['strInvocationJS']			= 'Invocation distante avec Javascript';
$GLOBALS['strInvocationIframes']		= 'Invocation distante avec Frames';
$GLOBALS['strInvocationXmlRpc']			= 'Invocation distante avec XML-RPC';
$GLOBALS['strInvocationCombined']		= 'Invocation distante combinée';
$GLOBALS['strInvocationPopUp']			= 'Popup';
$GLOBALS['strInvocationAdLayer']		= 'Interstitiel ou DHTML flottant';
$GLOBALS['strInvocationLocal']			= 'Mode local';


// Other
$GLOBALS['strCopyToClipboard']			= 'Copier dans le presse-papiers';


// Measures
$GLOBALS['strAbbrPixels']			= 'pixels';
$GLOBALS['strAbbrSeconds']			= 'secondes';


// Common Invocation Parameters
$GLOBALS['strInvocationWhat']			= '<br>Sélection de la bannière';
$GLOBALS['strInvocationClientID']		= 'Annonceur ou campagne';
$GLOBALS['strInvocationTarget']			= 'Frame de destination';
$GLOBALS['strInvocationSource']			= 'Origine';
$GLOBALS['strInvocationWithText']		= 'Montrer du texte sous la bannière';
$GLOBALS['strInvocationDontShowAgain']		= 'Ne pas remontrer la même bannière deux fois sur la même page';
$GLOBALS['strInvocationDontShowAgainCampaign']	= 'Ne pas montrer deux bannières d\'une même campagne sur une même page';
$GLOBALS['strInvocationTemplate'] 		= 'Stocker la bannière dans une variable afin de l\'utiliser dans un template';


// Iframe
$GLOBALS['strIFrameRefreshAfter']		= 'Rafraîchir après';
$GLOBALS['strIframeResizeToBanner']		= 'Redimensionner l\'iframe à la taille de la bannière';
$GLOBALS['strIframeMakeTransparent']		= 'Rendre l\'iframe transparente';
$GLOBALS['strIframeIncludeNetscape4']		= 'Inclure l\'ilayer compatible Netscape 4';


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
$GLOBALS['strPause']				= 'Pause entre chaque passage';
$GLOBALS['strLimited']				= 'Limité';
$GLOBALS['strLeftMargin']			= 'Marge gauche';
$GLOBALS['strRightMargin']			= 'Marge droite';
$GLOBALS['strTransparentBackground']		= 'Arrière-plan transparent';

$GLOBALS['strSmoothMovement']			= 'Flou dans le mouvement';
$GLOBALS['strHideNotMoving']			= 'Cacher la bannière lorsque la souris ne bouge pas';
$GLOBALS['strHideDelay']			= 'Délai avant que la bannière ne soit cachée';
$GLOBALS['strHideTransparancy']			= 'Transparence de la bannière cachée';


$GLOBALS['strAdLayerStyleName']	= array(
	'geocities'		=> 'Type Geocities',
	'simple'		=> 'Simple',
	'cursor'		=> 'Curseur',
	'floater'		=> 'Flottant'
);

?>