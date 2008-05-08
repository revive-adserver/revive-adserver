<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                          |
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

// Other
$GLOBALS['strCopyToClipboard']					= "Salin ke Clipboard";
$GLOBALS['strCopy']                     		= "salin";

// Measures
$GLOBALS['strAbbrPixels']              			= "px";
$GLOBALS['strAbbrSeconds']              		= "dtk";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat']           		= "Pilihan Banner";
$GLOBALS['strInvocationClientID']       		= "Pemasang Iklan";
$GLOBALS['strInvocationCampaignID']     		= "Kampanye";
$GLOBALS['strInvocationTarget']					= "Frame Tujuan";
$GLOBALS['strInvocationSource']					= "Sumber";
$GLOBALS['strInvocationWithText']				= "Tampilkan teks dibawah banner";
$GLOBALS['strInvocationDontShowAgain']			= "Jangan tampilkan banner berulang kali pada halaman yang sama";
$GLOBALS['strInvocationDontShowAgainCampaign']	= "Jangan tampilkan banner  dari kampanye yang sama pada halaman yang sama";
$GLOBALS['strInvocationTemplate'] 				= "Simpan banner dalam variabel untuk digunakan dalam Template";
$GLOBALS['strInvocationBannerID']               = "ID Banner";
$GLOBALS['strInvocationComments']               = "Tambahkan komentar";

// Iframe
$GLOBALS['strIFrameRefreshAfter']				= "Memperbarui setelah";
$GLOBALS['strIframeResizeToBanner']				= "Ubah ukuran iframe sesuai dimensi dari banner";
$GLOBALS['strIframeMakeTransparent']			= "Ubah iframe menjadi transparan";
$GLOBALS['strIframeIncludeNetscape4']			= "Masukkan ilayer yang kompatibel dengan Netscape 4";


// PopUp
$GLOBALS['strPopUpStyle']						= "Jenis Pop-up";
$GLOBALS['strPopUpStylePopUp']					= "Pop-up";
$GLOBALS['strPopUpStylePopUnder']				= "Pop-under";
$GLOBALS['strPopUpCreateInstance']				= "Halnya kapan pop-up dikreasi";
$GLOBALS['strPopUpImmediately']					= "Segera";
$GLOBALS['strPopUpOnClose']						= "Bila halaman ditutup";
$GLOBALS['strPopUpAfterSec']					= "Setelah";
$GLOBALS['strAutoCloseAfter']					= "Tutup secara otomatis setelah";
$GLOBALS['strPopUpTop']							= "Posisi asal (atas)";
$GLOBALS['strPopUpLeft']						= "Posisi asal (kiri)";
$GLOBALS['strWindowOptions']					= "Pilihan Jendela";
$GLOBALS['strShowToolbars']						= "Toolbars";
$GLOBALS['strShowLocation']						= "Lokasi";
$GLOBALS['strShowMenubar']						= "Menubar";
$GLOBALS['strShowStatus']						= "Status";
$GLOBALS['strWindowResizable']					= "Ukuran dabat diubah";
$GLOBALS['strShowScrollbars']					= "Scrollbars";


// XML-RPC
$GLOBALS['strXmlRpcLanguage']       			= "Bahasa yang digunakan pada Host";
$GLOBALS['strXmlRpcProtocol']       			= "Gunakan HTTPS untuk menghubungi XML-RPC Server";
$GLOBALS['strXmlRpcTimeout']        			= "XML-RPC Timeout (detik)";


// AdLayer
$GLOBALS['strAdLayerStyle']						= "Gaya";

$GLOBALS['strAlignment']						= "Penjajaran";
$GLOBALS['strHAlignment']						= "Penjajaran Horisontal";
$GLOBALS['strLeft']								= "Kiri";
$GLOBALS['strCenter']							= "Tengah";
$GLOBALS['strRight']							= "Kanan";

$GLOBALS['strVAlignment']						= "Penjajaran Vertikal";
$GLOBALS['strTop']								= "Atas";
$GLOBALS['strMiddle']							= "Tengah";
$GLOBALS['strBottom']							= "Bawah";

$GLOBALS['strAutoCollapseAfter']				= "Melipatkan secara otomatis setelah";
$GLOBALS['strCloseText']						= "Tutup Teks";
$GLOBALS['strClose']							= "[Tutup]";
$GLOBALS['strBannerPadding']					= "Isi dari Banner";

$GLOBALS['strHShift']							= "Penggeseran Horisontal";
$GLOBALS['strVShift']							= "Penggeseran Vertikal";

$GLOBALS['strShowCloseButton']					= "Tampilkan tombol Tutup";
$GLOBALS['strBackgroundColor']					= "Warna dasar";
$GLOBALS['strBorderColor']						= "Warna  batas";

$GLOBALS['strDirection']						= "Jurusan";
$GLOBALS['strLeftToRight']						= "Dari kiri ke kanan";
$GLOBALS['strRightToLeft']						= "Dari kanan ke kiri";
$GLOBALS['strLooping']							= "Memutar";
$GLOBALS['strAlwaysActive']						= "Selalu aktif";
$GLOBALS['strSpeed']							= "Kecepatan";
$GLOBALS['strPause']							= "Pause";
$GLOBALS['strLimited']							= "Terbatas";
$GLOBALS['strLeftMargin']						= "Pinggiran kiri";
$GLOBALS['strRightMargin']						= "Pinggiran kanan";
$GLOBALS['strTransparentBackground']			= "Dasar transparan";

$GLOBALS['strSmoothMovement']					= "Gerakan halus";
$GLOBALS['strHideNotMoving']					= "Sembunyikan banner bila Cursor tidak bergerak";
$GLOBALS['strHideDelay']						= "Menunda sebelum banner disembunyikan";
$GLOBALS['strHideTransparancy']					= "Tingkat transparansi dari banner yang tersembunyi";


$GLOBALS['strAdLayerStyleName']	= array(
	'geocities'		=> "Geocities",
	'simple'		=> "Simple",
	'cursor'		=> "Cursor",
	'floater'		=> "Floater"
);

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack']		 			= "Dukungan untuk pelacakan klik dari Server pihak ketiga";

// Support for cachebusting code
$GLOBALS['strCacheBuster']		    			= "Menambahkan kode Cache-Busting";

// Non-Img creatives Warning for zone image-only invocation
$GLOBALS['strNonImgWarningZone']				= "Perhatian: Ada banner pada zona ini yang tidak berupa gambar. Banner tersebut tidak dapat diputar dengan cara menggunakan Tag ini.";
$GLOBALS['strNonImgWarning']        			= "Perhatian: Banner ini tidak dapat difungsikan dengan benar sehubungan banner ini bukan berupa gambar.";

// unkown HTML tag type Warning for zone invocation
$GLOBALS['strUnknHtmlWarning']      			= "Perhatian: Banner ini adalah dalam format HTML yang tidak dikenal.";

// sql/web banner-type warning for clickonly zone invocation
$GLOBALS['strWebBannerWarning']     			= "Perhatian: Banner ini harus di-download dan Anda perlu beritahukan kepada kami tentang URL yang diminta untuk banner ini.
<br /> 1) Download the banner:";
$GLOBALS['strDwnldWebBanner']       			= "Klik kanan disini dan kemudian pilihlah Save Target As";
$GLOBALS['strWebBannerWarning2']    			= "<br /> 2) Silakan Upload banner ke Webserver Anda and tuliskan lokasinya disini: ";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] 							= "Perhatian";
$GLOBALS['strImgWithAppendWarning'] 			= "Pelacak ini mengandung kode tempelan. Kode tempelan <strong>hanya</strong> berfungsi dengan JavaScript tags";

?>
