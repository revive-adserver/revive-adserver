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

// Main strings
$GLOBALS['strChooseSection'] = "Izberi oddelek";
$GLOBALS['strAppendCodes'] = "Pripni zbirnike";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>Načrtovano vzdrževanje ni bilo zagnano v zadnji uri. To lahko pomeni, da ga niste pravilno nastavili.</b>";





$GLOBALS['strScheduledMantenaceRunning'] = "<b>Načrtovano vzdrževanje deluje pravilno.</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>Samodejno vzdrževanje deluje pravilno.</b>";

$GLOBALS['strAutoMantenaceEnabled'] = "Samodejno vzdrževanje je še vedno omogočeno. Za optimalno delovanje <a href='account-settings-maintenance.php'>onemogočite to funcijo</a>.";

// Priority
$GLOBALS['strRecalculatePriority'] = "Preračunaj prioriteto";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Preveri pomnilnik pasice";
$GLOBALS['strBannerCacheErrorsFound'] = "Preverba podatkovne baze pomnilnika pasic je našla napake. Te pasice ne bodo delovale, dokler jih ročno ne popravite.";
$GLOBALS['strBannerCacheOK'] = "Nobena napaka ni bila odkrita. Vaša pomnilniška baza pasic deluje pravilno.";
$GLOBALS['strBannerCacheDifferencesFound'] = "Vaša pomnilniška baza pasice ni posodobljena. Za normalno delovanje je potrebna posodobitev.";
$GLOBALS['strBannerCacheRebuildButton'] = "Ponovno sestavi";
$GLOBALS['strRebuildDeliveryCache'] = "Ponovno sestavi pomnilniško bazo pasice";

// Cache
$GLOBALS['strCache'] = "Dostavni pomnilnik";
$GLOBALS['strDeliveryCacheSharedMem'] = "	Skupen pomnilnik je trenutno v uporabi za hrambo dostavnega pomnilnika.";
$GLOBALS['strDeliveryCacheDatabase'] = "	Podatkovna baza je trenutno v uporabi za hrambo dostavnega pomnilnika.";
$GLOBALS['strDeliveryCacheFiles'] = "	Dostavni pomnilnik je trenutno v hrambi v večih datotekah na vašem strežniku.";

// Storage
$GLOBALS['strStorage'] = "Shramba";
$GLOBALS['strMoveToDirectory'] = "Premakni slike shranjene v podatkovni bazi v mapo";
$GLOBALS['strStorageExplaination'] = "	Slike, ki jih uporablja lokalna pasica, so shranjene v podatkovni bazi ali mapi. Če boste slike shranili
	v mapo, boste pospešili nalagalni čas podatkovne baze.";

// Encoding
$GLOBALS['strEncoding'] = "Šifriranje";
$GLOBALS['strEncodingConvertFrom'] = "Pretvori iz tega šifriranja:";
$GLOBALS['strEncodingConvertTest'] = "Preveri pretvorbo";
$GLOBALS['strConvertThese'] = "Naslednji podatki bodo spremenjeni, če boste nadaljevali";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Preverjam za posodobitve. Prosimo, počakajte...";
$GLOBALS['strAvailableUpdates'] = "Razpoložljive posodobitve";
$GLOBALS['strDownloadZip'] = "Shrani (.zip)";
$GLOBALS['strDownloadGZip'] = "Shrani (.tar.gz)";


$GLOBALS['strUpdateServerDown'] = "Zaradi neznane napake je bilo nemogoče pridobiti <br>informacije o možnih posodobitvah. Prosimo, poizkusite znova kasneje.";



$GLOBALS['strCheckForUpdatesDisabled'] = "<b>Preveri za posodobitve je onemogočne.Â Prosimo omogočiteÂ preko <a href='account-settings-update.php'>posodobitvenega</a> zaslona.</b>";




$GLOBALS['strForUpdatesLookOnWebsite'] = "	Če želite vedeti, ali obstaja novejša različica, vas prosimo, da obiščete našo spletno stran.";

$GLOBALS['strClickToVisitWebsite'] = "Kliknite tukaj za obisk naše spletne strani";
$GLOBALS['strCurrentlyUsing'] = "Trenutno uporabljate";
$GLOBALS['strRunningOn'] = "teče na";
$GLOBALS['strAndPlain'] = "in";

//  Deliver Limitations
$GLOBALS['strErrorsFound'] = "Najdene napake";
$GLOBALS['strRepairCompiledLimitations'] = "Zgoraj je bilo najdenih nekaj nedoslednosti. Te lahko odpravite s klikom na spodnjim gumbom, ki bo znova sestavil zbrane omejitve za vsako pasico/kanal v sistemu<br />";
$GLOBALS['strRecompile'] = "Znova sestavi";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "Po nekaterimi pogoji dostavno orodje ne deluje pravilno z shranjenim zbirnikom za sledilnike. Uporabite naslednjo povezavo za potrditev zbrinika v podatkovni bazi";
$GLOBALS['strCheckAppendCodes'] = "Preveri pripojitveni zbirnik";
$GLOBALS['strAppendCodesRecompiled'] = "Vse zbrane pripojitvene vrednosti zbirnika so bile znova sestavljene";
$GLOBALS['strAppendCodesResult'] = "Tukaj so rezultati veljavnosti zbranih pripojitvenih zbirnikov";
$GLOBALS['strAppendCodesValid'] = "Vsi zbrani pripojitveni zbirniki sledilnika so veljavni";
$GLOBALS['strRepairAppenedCodes'] = "Zgoraj je bilo najdenih nekaj nedoslednosti. Te lahko odpravite s klikom na spodnji gumb.";


$GLOBALS['strMenus'] = "Meniji";
$GLOBALS['strMenusPrecis'] = "Ponovno sestavi menijski pomnilnik";
$GLOBALS['strMenusCachedOk'] = "Menijskih pomnilnik je bil ponovno sestavljen";
