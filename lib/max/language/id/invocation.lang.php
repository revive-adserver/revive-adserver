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
$GLOBALS['strInvocationRemote']			= "Invokasi Remote";
$GLOBALS['strInvocationJS']			= "Invokasi Remote untuk Javascript";
$GLOBALS['strInvocationIframes']		= "Invokasi Remote untuk Frames";
$GLOBALS['strInvocationXmlRpc']			= "Invokasi Remote mengunakan XML-RPC";
$GLOBALS['strInvocationCombined']		= "Invokasi Remote Kombinasi";
$GLOBALS['strInvocationPopUp']			= "Pop-up";
$GLOBALS['strInvocationAdLayer']		= "Interstitial atau Floating DHTML";
$GLOBALS['strInvocationLocal']			= "Modus Lokal";


// Other
$GLOBALS['strCopyToClipboard']			= "Salin ke Clipboard";


// Measures
$GLOBALS['strAbbrPixels']			= "px";
$GLOBALS['strAbbrSeconds']			= "dtk";


// Common Invocation Parameters
$GLOBALS['strInvocationWhat']			= "Pilihan Banner";
$GLOBALS['strInvocationClientID']		= "Pemasang Iklan atau Kampanye";
$GLOBALS['strInvocationTarget']			= "Frame Tujuan";
$GLOBALS['strInvocationSource']			= "Sumber";
$GLOBALS['strInvocationWithText']		= "Tampilkan teks dibawah banner";
$GLOBALS['strInvocationDontShowAgain']		= "Jangan tampilkan banner berulang kali pada halaman yang sama";
$GLOBALS['strInvocationDontShowAgainCampaign']	= "Jangan tampilkan banner  dari kampanye yang sama pada halaman yang sama";
$GLOBALS['strInvocationTemplate'] 		= "Simpan banner dalam variabel untuk digunakan dalam Template";


// Iframe
$GLOBALS['strIFrameRefreshAfter']		= "Memperbarui setelah";
$GLOBALS['strIframeResizeToBanner']		= "Ubah ukuran iframe sesuai dimensi dari banner";
$GLOBALS['strIframeMakeTransparent']		= "Ubah iframe menjadi transparan";
$GLOBALS['strIframeIncludeNetscape4']		= "Masukkan ilayer yang kompatibel dengan Netscape 4";


// PopUp
$GLOBALS['strPopUpStyle']			= "Jenis Pop-up";
$GLOBALS['strPopUpStylePopUp']			= "Pop-up";
$GLOBALS['strPopUpStylePopUnder']		= "Pop-under";
$GLOBALS['strPopUpCreateInstance']		= "Halnya kapan pop-up dikreasi";
$GLOBALS['strPopUpImmediately']			= "Segera";
$GLOBALS['strPopUpOnClose']			= "Bila halaman ditutup";
$GLOBALS['strPopUpAfterSec']			= "Setelah";
$GLOBALS['strAutoCloseAfter']			= "Tutup secara otomatis setelah";
$GLOBALS['strPopUpTop']				= "Posisi asal (atas)";
$GLOBALS['strPopUpLeft']			= "Posisi asal (kiri)";
$GLOBALS['strWindowOptions']			= "Pilihan Jendela";
$GLOBALS['strShowToolbars']			= "Toolbars";
$GLOBALS['strShowLocation']			= "Lokasi";
$GLOBALS['strShowMenubar']			= "Menubar";
$GLOBALS['strShowStatus']			= "Status";
$GLOBALS['strWindowResizable']			= "Ukuran dabat diubah";
$GLOBALS['strShowScrollbars']			= "Scrollbars";


// XML-RPC
$GLOBALS['strXmlRpcLanguage']			= "Bahasa di Host";


// AdLayer
$GLOBALS['strAdLayerStyle']			= "Gaya";

$GLOBALS['strAlignment']			= "Penjajaran";
$GLOBALS['strHAlignment']			= "Penjajaran Horisontal";
$GLOBALS['strLeft']				= "Kiri";
$GLOBALS['strCenter']				= "Tengah";
$GLOBALS['strRight']				= "Kanan";

$GLOBALS['strVAlignment']			= "Penjajaran Vertikal";
$GLOBALS['strTop']				= "Atas";
$GLOBALS['strMiddle']				= "Tengah";
$GLOBALS['strBottom']				= "Bawah";

$GLOBALS['strAutoCollapseAfter']		= "Melipatkan secara otomatis setelah";
$GLOBALS['strCloseText']			= "Tutup Teks";
$GLOBALS['strClose']				= "[Tutup]";
$GLOBALS['strBannerPadding']			= "Isi dari Banner";

$GLOBALS['strHShift']				= "Penggeseran Horisontal";
$GLOBALS['strVShift']				= "Penggeseran Vertikal";

$GLOBALS['strShowCloseButton']			= "Tampilkan tombol Tutup";
$GLOBALS['strBackgroundColor']			= "Warna dasar";
$GLOBALS['strBorderColor']			= "Warna  batas";

$GLOBALS['strDirection']			= "Jurusan";
$GLOBALS['strLeftToRight']			= "Dari kiri ke kanan";
$GLOBALS['strRightToLeft']			= "Dari kanan ke kiri";
$GLOBALS['strLooping']				= "Memutar";
$GLOBALS['strAlwaysActive']			= "Selalu aktif";
$GLOBALS['strSpeed']				= "Kecepatan";
$GLOBALS['strPause']				= "Pause";
$GLOBALS['strLimited']				= "Terbatas";
$GLOBALS['strLeftMargin']			= "Pinggiran kiri";
$GLOBALS['strRightMargin']			= "Pinggiran kanan";
$GLOBALS['strTransparentBackground']		= "Dasar transparan";

$GLOBALS['strSmoothMovement']			= "Gerakan halus";
$GLOBALS['strHideNotMoving']			= "Sembunyikan banner bila Cursor tidak bergerak";
$GLOBALS['strHideDelay']			= "Menunda sebelum banner disembunyikan";
$GLOBALS['strHideTransparancy']			= "Tingkat transparan dari banner yang tersembunyi";


$GLOBALS['strAdLayerStyleName']	= array(
	'geocities'		=> "Geocities",
	'simple'		=> "Simple",
	'cursor'		=> "Cursor",
	'floater'		=> "Floater"
);

?>
