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
$Id: translation.php 28570 2008-11-06 16:21:37Z chris.nutting $
*/



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['phpAds_hlp_company_name'] = "Ime je uporabljeno v e-pošti, ki ga pošilja ". MAX_PRODUCT_NAME ."";
$GLOBALS['phpAds_hlp_warn_client'] = "". MAX_PRODUCT_NAME ." lahko pošlje e-pošto oglaševalcu, če ima njegova kampanja samo še";
$GLOBALS['phpAds_hlp_qmail_patch'] = "Nekatere različice qmaila vsebujejo hrošče, zaradi katerih poslana e-pošta \n". MAX_PRODUCT_NAME ." prikaže glave (headerje) v telesu sporočila . Če boste omogočili \nto nastavitev, bo ". MAX_PRODUCT_NAME ." poslal e-pošto v qmail združljivem formatu.";
$GLOBALS['phpAds_hlp_warn_limit'] = "Omejitev, po kateri ". MAX_PRODUCT_NAME ." začne pošiljati opozorilno e-pošto. Nastavljeno je na 100";
$GLOBALS['phpAds_hlp_admin_email'] = "Administratorjev e-poštni naslov, ki se uporabi kot izhodni naslov ko";
$GLOBALS['phpAds_hlp_admin_novice'] = "Če želite prejeti opozorilo pred izbrisom oglaševalca, kampanje, pasice, spletne strani ali področja, nastavite to možnost na pozitivno vrednost.";
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "Če je ta možnost omogočena, bodo na strani <i>Kampanje</i> prikazane dodatne informacije. Te vključujejo število preostalih ogledov oglasa, število preostalih klikov oglasa, število preostalih pretvorb oglasa, datum aktivacije in izteka in nastavitve prioritete.";
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "Če je ta možnost omogočena, bodo na strani <i>Pasice</i> prikazane dodatne informacije. Te vključujejo URL cilja, ključne besede, velikost in vrednost pasice.";
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "Če je ta možnost omogočena, bo na strani <i>Pasice</i> predogled vseh pasic. Če je ta možnost onemogočena, je še vedno možen predogled posamezne pasice s klikom na trikotnik zraven posamezne pasice.";
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "Če je ta možnost omogočena, bodo vse neaktivne pasice, kampanje in oglaševalci skriti na strani <i>Oglaševalci & Kampanje</i> in strani <i>Kampanje</i>. Četudi je ta možnost omogočena, vseeno lahko pregledate skrite elemente s klikom na <i>Prikaži vse</i>.";
$GLOBALS['phpAds_hlp_content_gzip_compression'] = "Z omogočitvijo GZIP stiskanja vsebine bo velik upadec podatkov, ki so poslani v brskalnik vsakokrat, ko je odprt administratorski vmesnik. Za omogočitev te funkcije morate imeti nameščeno GZIP razširitev.";
?>