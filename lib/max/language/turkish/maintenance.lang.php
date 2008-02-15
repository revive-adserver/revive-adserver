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

// Main strings
$GLOBALS['strChooseSection']			= "B�l�m Se�iniz";


// Priority
$GLOBALS['strRecalculatePriority']		= "�ncelikleri hesapla";
$GLOBALS['strHighPriorityCampaigns']		= "Y�ksek �ncelikli kampanyalar";
$GLOBALS['strAdViewsAssigned']			= "Belirlenen g�r�nme";
$GLOBALS['strLowPriorityCampaigns']		= "D���k �ncelikli kampanyalar";
$GLOBALS['strPredictedAdViews']			= "�nceden belirtilmi� G�r�nme";
$GLOBALS['strPriorityDaysRunning']		= "There are currently {days} days worth of statistics available from where ".$phpAds_productname." can base its daily prediction on. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Bu tahmin bu hafta ve ge�en haftan�n istatistiklerinden haz�rlanm��t�r. ";
$GLOBALS['strPriorityBasedLastDays']		= "Bu tahmin son iki g�n�n istatistiklerinden haz�rlanm��t�r. ";
$GLOBALS['strPriorityBasedYesterday']		= "Bu tahmin d�n�n istatistiklerinden haz�rlanm��t�r. ";
$GLOBALS['strPriorityNoData']			= "Ger�e�e yak�n tahmin olu�turulmas� i�in yeterli istatistik bulunmamktad�r. �ncelikler ger�ek zamanl� istatistikler i�in kullan�labilir. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Y�ksek �ncelikli kampanyalar� memnun edebilmek i�in yeterli g�sterim say�s� olmal�d�r. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Bug�n toplanan g�r�ntilenmeler y�ksek �ncelikli kampanyan�n bilgisi i�in yeterli de�il. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Banner haf�zas�n� tekrar olu�tur";
$GLOBALS['strBannerCacheExplaination']		= "
	Banner haf�zas� banner� g�stermek i�in HTML kodlar�n� i�erir. Banner haf�zas� kullanman�z banner�n her g�steriminde yeniden HTML 
	kodu �retmeyece�inden dolay� g�r�nt�lenmesini h�zland�r�r. ��nk� banner haf�zas� ".$phpAds_productname." program�n�n direk adresini(URL) 
	ve banner� b�nyesinde bulundurur.
";


// Zone cache
$GLOBALS['strZoneCache']			= "Alan Haf�zas�";
$GLOBALS['strAge']				= "Ya�";
$GLOBALS['strRebuildZoneCache']			= "Alan Haf�zas�n� tekrar olu�tur";
$GLOBALS['strZoneCacheExplaination']		= "
	Alan haf�zas� o alana ait bannerlar�n h�zl� a��lmas�n� sa�lar. Alan haf�zas� �zerinde bulunan t�m bannerlar�n kodlar�n� i�ermektedir.
	Haf�za alan g�ncelle�tirildi�inde veya banner eklendi�inde de�i�mektedir, bu y�zden haf�za ge�erlili�ini kaybeder.
	Bu y�zden haf�za her {seconds} dakikada tekrar olu�turulmaktad�r, ama bu haf�za elle de yap�labilmektedir.
";


// Storage
$GLOBALS['strStorage']				= "Depolama";
$GLOBALS['strMoveToDirectory']			= "Veritaban�nda depolanan resimleri bir dizine ta��";
$GLOBALS['strStorageExplaination']		= "
	Yerel bannerlar�n resimleri veritaban�nda veya bir klas�r alt�nda tutulabilir. E�er resimleri
	bir klas�rde tutarsan�z bu veritaban�n�n y�k�n� azalt�r ama sistemi yava�lat�r.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	<i>Yo�unla�t�r�lm�� istatistikleri</i> aktif ettiniz, fakat eski istatistiklerinizin yap�s� gereksiz bilgileri de i�eriyor. 
	Eski istatistiklerinizi d�zenlemek ister misiniz?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "G�ncellemeler kontrol ediliyor. L�tfen bekleyiniz...";
$GLOBALS['strAvailableUpdates']			= "Mevcut �r�n g�ncellemeleri";
$GLOBALS['strDownloadZip']			= "�ndir (.zip)";
$GLOBALS['strDownloadGZip']			= "�ndir (.tar.gz)";

$GLOBALS['strUpdateAlert']			= $phpAds_productname." program�n�n yeni s�r�m� bulunmaktad�r.                 \\n\\nBu g�ncelleme ile ilgili daha\\nfazla bilgi ister misiniz?";
$GLOBALS['strUpdateAlertSecurity']		= $phpAds_productname." program�n�n yeni s�r�m� bulunmaktad�r.                 \\n\\nBu g�ncellemeyi yapman�z \\ntavsiye ediliyor, ��nkl� bu s�r�m \\ng�venlik problemlerinin onar�lm�� halini i�eriyor.";

$GLOBALS['strUpdateServerDown']			= "
    Tan�mlanamayan bir nedenden dolay� mevcut olan �r�n <br>
	g�ncellemelerine ula��lam�yor. L�tfen daha sonra tekrar deneyiniz.
";

$GLOBALS['strNoNewVersionAvailable']		= 
	$phpAds_productname." s�r�m�n�z g�ncellenmi�. �u anda mevcut bir g�ncelleme bulunmuyor.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>".$phpAds_productname." yeni s�r�m� bulunmaktad�r.</b><br> Bu g�ncellemeyi y�klemenizi tavsiye ederiz.
	��nk� bu s�r�m baz� problemleri ��zebilir ve yeni �zellikler ekleyebilir. Daha fazla bilgi i�in
	a�a��daki dosyada bulunan d�k�manlar� okuyunuz.
";

$GLOBALS['strSecurityUpdate']			= "
	<b>Bu g�ncellemeyi y�klemeniz �iddetle tavsiye ediliyor. ��nk� bu s�r�m baz� g�venlik a��klar�n� onar�yor.
	.</b> Kullanm�� oldu�unuz ".$phpAds_productname." s�r�m� baz� sald�r�lara a��k olabilir. Daha fazla bilgi i�in
	a�a��daki dosyada bulunan d�k�manlar� okuyunuz.
";


// Stats conversion
$GLOBALS['strConverting']			= "D�n��t�r�l�yor";
$GLOBALS['strConvertingStats']			= "�statistikler D�n��t�r�l�yor...";
$GLOBALS['strConvertStats']			= "�statistikleri d�n��t�r";
$GLOBALS['strConvertAdViews']			= "G�r�nt�lenme d�n��t�r,";
$GLOBALS['strConvertAdClicks']			= "T�klanma d�n��t�rl�yor...";
$GLOBALS['strConvertNothing']			= "Hi�bir �ey d�n��t�r�lmedi...";
$GLOBALS['strConvertFinished']			= "Bitti...";

$GLOBALS['strConvertExplaination']		= "
	�u anda istatistiklerinizi depolamak i�in yo�unla�t�r�lm�� bi�imi kullan�yorsunuz. Ama <br>
	hala gereksiz i�erikli istatistikleriniz bulunmakta. Bu gereksiz i�erikli istatistikleriniz<br>
	yo�unla�t�r�lm�� istatistiklere d�n��t�r�lmeden bu sayfalar� g�remezsiniz. <br>
	�statistiklerinizi d�n�st�rmden veritaban�n�z� yedekleyiniz ! <br>
	Gereksiz i�erikli istatistiklerinizi yo�unla�t�r�lm�� istatistik bi�imine d�n��t�rmek istermisiniz?<br>
";

$GLOBALS['strConvertingExplaination']		= "
	Kalan t�m gereksiz i�erikli istatistikleriniz yo�unla�t�r�lm�� istatistiklere �evrildi.<br>
	T�m kay�tlar�n d�n��t�r�lmesi biraz s�re alacakt�r. �Bu s�re i�erisinde l�tfen ba�ka sayfalar�
	gezmeyiniz. ��lem sonunda size veritaban� �zerinde yap�lan de�i�ikler ile ilgili rapor sunulacakt�r.
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	Yo�unla�t�r�lm�� istatistiklere d�n��t�rme i�lemi ba�ar�yla ger�ekle�tirildi, <br>
	�u anda veriler tekrar kullan�labilir halde. A�a��da veritaban�nda yap�lan t�m<br>
	de�i�iklikleri g�rebilirsiniz.<br>
";


?>