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
$Id: translation.php 28570 2008-11-06 16:21:37Z chris.nutting $
*/



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strDeliveryLimitations'] = "Leverings begræsninger";
$GLOBALS['strChooseSection'] = "Vælg sektion";
$GLOBALS['strRecalculatePriority'] = "Genkalkuler prioritet";
$GLOBALS['strCheckBannerCache'] = "Tjek banner cache";
$GLOBALS['strBannerCacheErrorsFound'] = "Denne database banner cache tjek har fundet nogle fejl. Denne banner vil ikke fungere indtil du manuelt har løst fejlene.";
$GLOBALS['strBannerCacheOK'] = "Der blev ikke dedekteret nogle fejl. Din database banner cache er opdateret.";
$GLOBALS['strBannerCacheDifferencesFound'] = "Database banner cache tjek har fundet at din cache ikke er opdateret og den kræver genopbygning. Klik her for automatisk at opdatere din cache.";
$GLOBALS['strBannerCacheRebuildButton'] = "Genopbygge";
$GLOBALS['strRebuildDeliveryCache'] = "Genopbyg database banner cache";
$GLOBALS['strBannerCacheExplaination'] = "\nDatabase banner cache er anvendt for at forøge leveringshastigheden af bannere under levering <br />\nDenne cache skal opdateres når:\n<ul>\n<li>Du opgrader din version af OpenX</li>\n<li>Du flytter din OpenX version til en anden server</li>\n</ul>\n";
$GLOBALS['strCache'] = "Cache levering";
$GLOBALS['strAge'] = "Alder";
$GLOBALS['strDeliveryCacheSharedMem'] = "\n	Delt hukommelse bliver for øjeblikket anvendt til at gemme leverings cachen.\n";
$GLOBALS['strDeliveryCacheDatabase'] = "\n	Databasen bliver for øjeblikket anvendt til at gemme leverings cachen.\n";
$GLOBALS['strDeliveryCacheFiles'] = "\n	Leverings cachen er for øjeblikket gemt i forskellige filer på din server.\n";
$GLOBALS['strStorage'] = "Lager";
$GLOBALS['strSearchingUpdates'] = "Kontrollere for opdateringer. Venligst vent...";
$GLOBALS['strAvailableUpdates'] = "Tilgængelige opdateringer";
$GLOBALS['strDownloadZip'] = "Download (.zip)";
$GLOBALS['strDownloadGZip'] = "Download (.tar.gz)";
$GLOBALS['strUpdateAlert'] = "En ny version af ". MAX_PRODUCT_NAME ." er tilgængelig. \n\nØnsker fu at få mere information \nom denne opdatering?";
$GLOBALS['strUpdateAlertSecurity'] = "En ny version af ". MAX_PRODUCT_NAME ." er tilgængelig. \n\nDet anbefales meget at opgradere \nså hurtigt som muligt, da denne \nversion indeholder en eller flere sikkerhedsopdateringer.";
$GLOBALS['strUpdateServerDown'] = "Af en ukendt årsag er det ikke muligt at indente<br>information om mulige opdateringer. Venligst forsøg igen senere.";
$GLOBALS['strNoNewVersionAvailable'] = "\n	Din version af ". MAX_PRODUCT_NAME ." er opdateret. Der er for øjeblikket ingen opdateringer tilgængelige.\n";
$GLOBALS['strNewVersionAvailable'] = "\n	<b>En ny version af ". MAX_PRODUCT_NAME ." er tilgængelig.</b><br /> Det anbefales at installere denne opdatering,\n	fordi den vil muligvis reperere nogle eksisterende problemer og tilføje nye funktioner. For yderligere information\n	om opgradering venligst læs dokumentationen som er inkluderet i filen vist nedenfor\n";
$GLOBALS['strSecurityUpdate'] = "\n	<b>Det anbefales kraftigt at installere denne opdatering så hurtigt som muligt, da den indeholder et antal\n	sikkerheds fejlrettelser.</b> Denne version af ". MAX_PRODUCT_NAME ." som du anvender for øjeblikket er\n	sårbar overfor nogle angreb og er måske ikke sikker. For yderligere information\n	om omdateringen venligst læs dokumentationen som er inkluderet i filen nedenfor.\n";
$GLOBALS['strNotAbleToCheck'] = "\n	<b>På grund af XML udvidelse ikke er tilgængelig på din server, ". MAX_PRODUCT_NAME ." har ikke\nmulighed for at kontrollere om der er en ny version tilgængelig.</b>\n";
$GLOBALS['strForUpdatesLookOnWebsite'] = "\n	Hvis du ønsker at vide om der er en nyere version tilgængelig, venligst besøg vores webside.\n";
$GLOBALS['strClickToVisitWebsite'] = "Klik her for at besøge vores webside";
$GLOBALS['strCurrentlyUsing'] = "Du anvender for øjeblikket";
$GLOBALS['strRunningOn'] = "kører på";
$GLOBALS['strAndPlain'] = "og";
$GLOBALS['strBannerCacheFixed'] = "Banner databasens cache gendannelse, blev gennemført med succes. Din databse cache er nu opdateret.";
$GLOBALS['strEncodingConvert'] = "Konvertere";
$GLOBALS['strAutoMaintenanceDisabled'] = "Automatisk vedligeholdelse er deaktiveret.";
?>