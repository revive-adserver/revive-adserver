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
$GLOBALS['strCopyToClipboard'] = "Salin ke Clipboard";
$GLOBALS['strCopy'] = "salin";
$GLOBALS['strChooseTypeOfInvocation'] = "Silakan pilih jenis invokasi banner";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Silakan pilih jenis invokasi banner";

// Measures
$GLOBALS['strAbbrPixels'] = "px";
$GLOBALS['strAbbrSeconds'] = "dtk";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Pilihan Banner";
$GLOBALS['strInvocationCampaignID'] = "Kampanye";
$GLOBALS['strInvocationTarget'] = "Frame Tujuan";
$GLOBALS['strInvocationSource'] = "Sumber";
$GLOBALS['strInvocationWithText'] = "Tampilkan teks dibawah banner";
$GLOBALS['strInvocationDontShowAgain'] = "Jangan tampilkan banner berulang kali pada halaman yang sama";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Jangan tampilkan banner  dari kampanye yang sama pada halaman yang sama";
$GLOBALS['strInvocationTemplate'] = "Simpan banner dalam variabel untuk digunakan dalam Template";
$GLOBALS['strInvocationBannerID'] = "ID Banner";
$GLOBALS['strInvocationComments'] = "Tambahkan komentar";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "Memperbarui setelah";
$GLOBALS['strIframeResizeToBanner'] = "Ubah ukuran iframe sesuai dimensi dari banner";
$GLOBALS['strIframeMakeTransparent'] = "Ubah iframe menjadi transparan";
$GLOBALS['strIframeIncludeNetscape4'] = "Masukkan ilayer yang kompatibel dengan Netscape 4";
$GLOBALS['strIframeGoogleClickTracking'] = "Sertakan kode untuk melacak klik Google AdSense";

// PopUp
$GLOBALS['strPopUpStyle'] = "Jenis Pop-up";
$GLOBALS['strPopUpStylePopUp'] = "Pop-up";
$GLOBALS['strPopUpStylePopUnder'] = "Pop-under";
$GLOBALS['strPopUpCreateInstance'] = "Halnya kapan pop-up dikreasi";
$GLOBALS['strPopUpImmediately'] = "Segera";
$GLOBALS['strPopUpOnClose'] = "Bila halaman ditutup";
$GLOBALS['strPopUpAfterSec'] = "Setelah";
$GLOBALS['strAutoCloseAfter'] = "Tutup secara otomatis setelah";
$GLOBALS['strPopUpTop'] = "Posisi asal (atas)";
$GLOBALS['strPopUpLeft'] = "Posisi asal (kiri)";
$GLOBALS['strWindowOptions'] = "Pilihan Jendela";
$GLOBALS['strShowToolbars'] = "Toolbar";
$GLOBALS['strShowLocation'] = "Lokasi";
$GLOBALS['strShowMenubar'] = "Menubar";
$GLOBALS['strShowStatus'] = "Keadaan";
$GLOBALS['strWindowResizable'] = "Ukuran dabat diubah";
$GLOBALS['strShowScrollbars'] = "Scrollbars";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Bahasa yang digunakan pada Host";
$GLOBALS['strXmlRpcProtocol'] = "Gunakan HTTPS untuk menghubungi XML-RPC Server";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC Timeout (detik)";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "Dukungan untuk pelacakan klik dari Server pihak ketiga";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Menambahkan kode Cache-Busting";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Perhatian";
$GLOBALS['strImgWithAppendWarning'] = "Pelacak ini mengandung kode tempelan. Kode tempelan <strong>hanya</strong> berfungsi dengan JavaScript tags";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Peringatan: </strong> Permintaan mode lokal HANYA akan bekerja jika situs meminta kode
ada di mesin fisik yang sama dengan adserver </span><br />
Periksa bahwa MAX_PATH yang didefinisikan dalam kode di bawah ini mengarah ke direktori dasar instalasi MAX Anda <br />
dan Anda memiliki file konfigurasi untuk domain situs yang menampilkan iklan tersebut (di MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Catatan: </b> Tag pemanggilan mode lokal berarti permintaan banner berasal dari server web, bukan klien. Akibatnya, statistik tidak sesuai dengan pedoman IAB untuk pengukuran tayangan iklan.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Catatan: </b> Tag pemanggilan XML-RPC berarti permintaan banner berasal dari server web, bukan klien. Akibatnya, statistik tidak sesuai dengan pedoman IAB untuk pengukuran tayangan iklan.";
