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
$GLOBALS['strCopyToClipboard'] = "Panoya kopyala";
$GLOBALS['strCopy'] = "kopyala";
$GLOBALS['strChooseTypeOfInvocation'] = "Lütfen banner çağırma tipini seçiniz";
$GLOBALS['strChooseTypeOfBannerInvocation'] = "Lütfen banner çağırma tipini seçiniz";

// Measures
$GLOBALS['strAbbrPixels'] = "px";
$GLOBALS['strAbbrSeconds'] = "sec";

// Common Invocation Parameters
$GLOBALS['strInvocationWhat'] = "Banner seçimi";
$GLOBALS['strInvocationCampaignID'] = "Kampanya";
$GLOBALS['strInvocationTarget'] = "Hedef çerçeve";
$GLOBALS['strInvocationSource'] = "Kaynak";
$GLOBALS['strInvocationWithText'] = "Banner altında yazı göster";
$GLOBALS['strInvocationDontShowAgain'] = "Aynı sayfada bannerı tekrar gösterme";
$GLOBALS['strInvocationDontShowAgainCampaign'] = "Aynı sayfada aynı kampanyadan başka bir banner gösterme";
$GLOBALS['strInvocationTemplate'] = "Şablon içerisinde kullanım için bannerı bir değişken içinde sakla.";
$GLOBALS['strInvocationBannerID'] = "Banner ID";
$GLOBALS['strInvocationComments'] = "Yorumlarla birlikte";

// Iframe
$GLOBALS['strIFrameRefreshAfter'] = "Şu zaman sonunda yenile";
$GLOBALS['strIframeResizeToBanner'] = "Çerçeveyi banner ölçüsüne göre yeniden boyutlandır";
$GLOBALS['strIframeMakeTransparent'] = "Çerçeveyi şeffaf yap";
$GLOBALS['strIframeIncludeNetscape4'] = "Netscape 4 uyumlu ilayer kullan";
$GLOBALS['strIframeGoogleClickTracking'] = "Google AdSense tıklamalarını izlemek için kodlar içerir";

// PopUp
$GLOBALS['strPopUpStyle'] = "Pop-up tipi";
$GLOBALS['strPopUpStylePopUp'] = "Açılır pencere";
$GLOBALS['strPopUpStylePopUnder'] = "Pop-under";
$GLOBALS['strPopUpCreateInstance'] = "Instance when the pop-up is created";
$GLOBALS['strPopUpImmediately'] = "Hemen";
$GLOBALS['strPopUpOnClose'] = "Sayfa kapandığında";
$GLOBALS['strPopUpAfterSec'] = "Sonra";
$GLOBALS['strAutoCloseAfter'] = "Süre sonra otomatik kapat";
$GLOBALS['strPopUpTop'] = "Başlangıç konumu (üst)";
$GLOBALS['strPopUpLeft'] = "Başlangıç konumu (sol)";
$GLOBALS['strWindowOptions'] = "Pencere seçenekleri";
$GLOBALS['strShowToolbars'] = "Araç Çubukları";
$GLOBALS['strShowLocation'] = "Konum";
$GLOBALS['strShowMenubar'] = "Menü çubuğu";
$GLOBALS['strShowStatus'] = "Durum";
$GLOBALS['strWindowResizable'] = "Boyutlandırılabilir";
$GLOBALS['strShowScrollbars'] = "Kaydırma çubukları";

// XML-RPC
$GLOBALS['strXmlRpcLanguage'] = "Sunucu Dili";
$GLOBALS['strXmlRpcProtocol'] = "XML-RPC Sunucusu ile bağlantı kurmak için HTTPS'yi kullanın";
$GLOBALS['strXmlRpcTimeout'] = "XML-RPC Zaman Aşımı (Saniye)";

// Support for 3rd party server clicktracking
$GLOBALS['str3rdPartyTrack'] = "Support 3rd Party Server Clicktracking";

// Support for cachebusting code
$GLOBALS['strCacheBuster'] = "Insert Cache-Busting code";

// IMG invocation selected for tracker with appended code
$GLOBALS['strWarning'] = "Uyarı";
$GLOBALS['strImgWithAppendWarning'] = "Bu izleyici eklenmiş kodu ekledi, eklenen kod <strong>yalnızca</strong> JavaScript etiketleri ile çalışacak";

// Local Invocation
$GLOBALS['strWarningLocalInvocation'] = "<span class='tab-s'><strong>Warning:</strong> Local mode invocation will ONLY work if the site calling the code
is on the same physical machine as the adserver</span><br />
Check that the MAX_PATH defined in the code below points to the base directory of your MAX installation<br />
and that you have a config file for the domain of the site showing the ads (in MAX_PATH/var)";

$GLOBALS['strIABNoteLocalInvocation'] = "<b>Note:</b> Local Mode invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
$GLOBALS['strIABNoteXMLRPCInvocation'] = "<b>Note:</b> XML-RPC invocation tags mean banner requests come from the web server, rather than the client. As a result, statistics are not compliant with IAB guidelines for ad impression measurement.";
