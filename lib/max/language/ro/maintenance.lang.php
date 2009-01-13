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
$GLOBALS['strDeliveryLimitations'] = "Limitări Livare";
$GLOBALS['strChooseSection'] = "Alege Secţiune";
$GLOBALS['strRecalculatePriority'] = "Recalculează prioritatea";
$GLOBALS['strCheckBannerCache'] = "Verifică cache banner";
$GLOBALS['strBannerCacheErrorsFound'] = "Verificarea bazei de date pentru cache-ul bannerului a întâmpinat unele erori. Aceste bannere nu vor funcţiona până când nu le repari manual.";
$GLOBALS['strBannerCacheOK'] = "Nu a fost detectată nici o eroare. Baza de date cu cache-ul bannerului este actualizată";
$GLOBALS['strBannerCacheDifferencesFound'] = "Verificarea bazei de date pentru cache-ul bannerului a descoperit ca sunt necesare actualizări ce necesită reconstruirea acesteia. Apasă aici pentru actualizarea automată a cache-ului.";
$GLOBALS['strBannerCacheRebuildButton'] = "Reconstruieşte";
$GLOBALS['strRebuildDeliveryCache'] = "Reconstruieşte baza de date cu cache-ul bannerului";
$GLOBALS['strBannerCacheExplaination'] = "\n   Baza de date cu cache-ul bannerului este utilizată pentru a spori viteza de livrare a banner-elor in timpul distribuţiei<br />\n   Acest cache are nevoie de actualizări atunci când:\n<ul>\n<li>Actualizezi versiunea sistemului de reclame</li>\n<li>Muţi folder-ul de instalare al sistemului de reclame pe un alt server</li>\n</ul>\n";
$GLOBALS['strCache'] = "Cache Distribuţie";
$GLOBALS['strAge'] = "Vârstă";
$GLOBALS['strDeliveryCacheSharedMem'] = "\n	Memoria împărţită este momentan utilizată pentru a stoca cache-ul distribuţiei.\n";
$GLOBALS['strDeliveryCacheDatabase'] = "\n	Baza de date este momentan utilizată pentru a stoca cache-ul distribuţiei.\n";
$GLOBALS['strDeliveryCacheFiles'] = "\n	Cache-ul distribuţiei este stocat momentan în mai multe fişiere de pe server.\n";
$GLOBALS['strStorage'] = "Stocare";
$GLOBALS['strMoveToDirectory'] = "Mută imaginile stocate în baza de date într-un director";
$GLOBALS['strStorageExplaination'] = "\n	Imaginile utilizate de bannerele locale sunt stocate în interiorul bazei de date sau stocate într-un director. Dacă stochezi imaginile într-un\n	director, utilizarea bazei de date va fi redusă, ceea ce va duce la o viteză îmbunătăţită.\n";
$GLOBALS['strSearchingUpdates'] = "Caut actualizări. Te rugăm să aştepţi...";
$GLOBALS['strAvailableUpdates'] = "Actualizări disponibile";
$GLOBALS['strDownloadZip'] = "Descarcă (.zip)";
$GLOBALS['strDownloadGZip'] = "Descarcă (.tar.gz)";
$GLOBALS['strUpdateAlert'] = "Este disponibilă o nouă versiune pentru ". MAX_PRODUCT_NAME .". \n\nVrei să obţii mai multe informaţii \ndespre această actualizare?";
$GLOBALS['strUpdateAlertSecurity'] = "Este disponibilă o nouă versiune pentru ". MAX_PRODUCT_NAME .". \nEste recomandat să actualizaţi \ncât se poate de repede, deoarece această \nversiune conţine una sau mai multe rezolvări legate de securitate.";
$GLOBALS['strUpdateServerDown'] = "Nu este posibilă obţinerea informaţiilor despre<br>eventualele actualizări din cauya unui motiv necunoscut. Te rugăm să încerci din nou.";
$GLOBALS['strNoNewVersionAvailable'] = "\n	Versiunea ta de ". MAX_PRODUCT_NAME ." este cea mai recentă. Nu sunt alte actualizări disponibile.\n";
$GLOBALS['strNewVersionAvailable'] = "\n	<b>Este disponibilă o noua versiune de ". MAX_PRODUCT_NAME .".</b><br />Este recomandat să instalezi această actualizare,\n	deoarece ar putea corecta unele probleme existente şi va adăuga noi facilităţi. Pentru mai multe informaţii\n	despre actualizare te rugăm să citeşti documentaţia ce este inclusă în fişierele de mai jos.\n";
$GLOBALS['strSecurityUpdate'] = "\n	<b>Este recomandat să instalezi această actualizare cat mai repede cu putinţă, deoarece conţine un număr\n	de corecţii ale securităţii.</b> Versiunea de ". MAX_PRODUCT_NAME ." pe care o utilizezi momentan s-ar putea\n	să fie vulnerabilă unor atacuri şi probabil nu este sigură. Pentru mai multe informaţii\n	despre actualizare te rugăm să citeşti documentaţia inclusă în fişierele de mai jos.\n";
$GLOBALS['strNotAbleToCheck'] = "\n	<b>Deoarece extensiile XML nu sunt valabile pe acest server, ". MAX_PRODUCT_NAME ." nu poate\nverifica dacă este disponibilă o versiune mai nouă.</b>\n";
$GLOBALS['strForUpdatesLookOnWebsite'] = "\n	Dacă doreşi să afli noutăţi despre ultima versiune disponibilă, te rugăm sa accesezi site-ul nostru.\n";
$GLOBALS['strClickToVisitWebsite'] = "Click aici pentru a vizita site-ul nostru";
$GLOBALS['strCurrentlyUsing'] = "Momentan utilizezi";
$GLOBALS['strRunningOn'] = "rulând pe";
$GLOBALS['strAndPlain'] = "şi";
$GLOBALS['strStatisticsExplaination'] = "\n	Ai activat <i>statisticile compacte</i>, dar vechile tale statistici încă sunt în formatul normal.\n	Vrei să converteşti statisticile tale normale în noul format compact?\n";
$GLOBALS['strBannerCacheFixed'] = "Refacerea cache-ului bazei de date folosite pentru bannere a fost refăcut cu succes. Cache-ul bazei tale de date este actualizat acum.";
$GLOBALS['strEncoding'] = "Codare";
$GLOBALS['strEncodingExplaination'] = "". MAX_PRODUCT_NAME ." acum stochează toate datele în baza de date în format UTF-8.<br />Acolo unde este posibil, datele tale vor fi automat convertite către această codare.<br />Dacă după actualizare găseşti caractere corupte, şi cunoşi codarea folosită, poţi folosi această unealtă pentru a converti datele din acel format în UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Converteşte din această codare:";
$GLOBALS['strEncodingConvert'] = "Converteşte";
$GLOBALS['strEncodingConvertTest'] = "Verifică conversia";
$GLOBALS['strConvertThese'] = "Următoarele date vor fi schimbate dacă continui";
$GLOBALS['strAppendCodes'] = "Alătură coduri";
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>Întreţinerea programată nu a fost executată în ultima oră. Acest lucru ar putea însemna că nu ai setat-o corect.</b>";
$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "Întreţinerea automată a fost activată, dar nu a fost pornită. Întreţinerea automată este accesată doar când ". MAX_PRODUCT_NAME ." afişează bannere. Pentru cea mai bună performanţă, ar trebuie să setezi <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>întreţinerea programată</a>";
$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "Întreţinerea automată este dezactivată momentan, astfel că atunci când ". MAX_PRODUCT_NAME ." afişează bannere, întreţinerea automată nu va fi executată. Pentru cea mai bună performanţă, ar trebui să setezi <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>întreţinerea programată</a>. Totuşi, dacă nu ai de gând să setezi <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>întreţinerea programată</a>, atunci <i>trebuie</i> să <a href='account-settings-maintenance.php'>activezi întreţinerea automată</a> pentru a fi sigur că ". MAX_PRODUCT_NAME ." funcţionează corect.";
$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "Întreţinerea automată a fost activată şi va fi accesată, când este necesar, atunci când ". MAX_PRODUCT_NAME ." afişează bannere. Totuşi, pentru cea mai bună performanţă, ar trebuie să setezi <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>întreţinerea programată</a>.";
$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "Totuşi, întreţinerea automată a fost dezactivată recent. Pentru a te asigura că ". MAX_PRODUCT_NAME ." funcţionează corect, ar trebui să setezi <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>întreţinerea programată</a> sau să <a href='account-settings-maintenance.php'>re-activezi întreţinerea automată</a>.<br><br>Pentru cea mai bună performanţă, ar trebui să setezi <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>întreţinerea programată</a>.";
$GLOBALS['strScheduledMantenaceRunning'] = "<b>Întreţinerea programată funcţionează corect.</b>";
$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>Întreţinerea automată funcţionează corect.</b>";
$GLOBALS['strAutoMantenaceEnabled'] = "Totuşi, întreţinerea automată încă este activată. Pentru cea mai bună performanţă, ar trebui să <a href='account-settings-maintenance.php'>dezactivezi întreţinerea automată</a>.";
$GLOBALS['strAutoMaintenanceDisabled'] = "Întreţinerea automată este dezactivată.";
$GLOBALS['strAutoMaintenanceEnabled'] = "Întreţinerea automată este activată. Pentru cea mai bună performanţă îţi recomandăm să <a href='settings-admin.php'>dezactivezi întreţinerea automată</a>.";
$GLOBALS['strCheckACLs'] = "Verifică ACL-uri";
$GLOBALS['strScheduledMaintenance'] = "Se pare că întreţinerea programată funcţionează corect.";
$GLOBALS['strAutoMaintenanceEnabledNotTriggered'] = "Întreţinerea automată este activată, dar nu a fost accesată. Reţine faptul că întreţinerea automată este accesată doar când ". MAX_PRODUCT_NAME ." afişează bannere.";
$GLOBALS['strAutoMaintenanceBestPerformance'] = "Pentru cea mai bună performanţă îţi recomandăm să setezi <a href='". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>întreţinerea programată</a>";
$GLOBALS['strAutoMaintenanceEnabledWilltTrigger'] = "Întreţinerea automată este activată şi va accesa întreţinerea în fiecare oră.";
$GLOBALS['strAutoMaintenanceDisabledMaintenanceRan'] = "Întreţinerea automată este dezactivată deasemenea dar o sarcină de întreţinere a fost executată recent. Pentru a fi sigur că ". MAX_PRODUCT_NAME ." funcţionează corect ar trebui să setezi <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>întreţinerea programată</a> sau să <a href='settings-admin.php'>activezi întreţinerea automată</a>.";
$GLOBALS['strAutoMaintenanceDisabledNotTriggered'] = "Deasemenea, întreţinerea automată este dezactivată, astfel când ". MAX_PRODUCT_NAME ." afişează bannere, întreţinerea nu este accesată. Dacă nu ai de gând să execuţi <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>întreţinerea programată</a>, trebuie să <a href='settings-admin.php'>activezi întreţinerea automată</a> pentru a fi sigur că ". MAX_PRODUCT_NAME ." funcţionează corect.";
$GLOBALS['strAllBannerChannelCompiled'] = "Toate valorile de limitare compilate ale banner-ului/canalului au fost recompilate";
$GLOBALS['strBannerChannelResult'] = "Aici sunt rezultatele validării limitării compilate ale banner-ului/canalului";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Toate limitările compilate ale canalului sunt valide";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Toate limitările compilate ale banner-ului sunt valide";
$GLOBALS['strErrorsFound'] = "Au fost găsite erori";
$GLOBALS['strRepairCompiledLimitations'] = "Au fost găsite unele incompatibilităţi deasupra, le poţi repara folosind butonul de mai jos, acesta va recompila limitarea compilată pentru fiecare banner/canal din sistem<br />";
$GLOBALS['strRecompile'] = "Recompilează";
$GLOBALS['strAppendCodesDesc'] = "În unele circumstanţe motorul de livrare poate dezaproba codul alăturat contoarelor, foloseşte următorul link pentru a valida codul alăturat din baza de date";
$GLOBALS['strCheckAppendCodes'] = "Verifica codurile alăturate";
$GLOBALS['strAppendCodesRecompiled'] = "Toate valorile codurilor alăturate compilate au fost recompilate";
$GLOBALS['strAppendCodesResult'] = "Aici sunt rezultatele validării codurilor alăturate compilate";
$GLOBALS['strAppendCodesValid'] = "Toate codurile alăturate ale contorului compilate sunt valide";
$GLOBALS['strRepairAppenedCodes'] = "Au fost găsite unele incompatibilităţi mai sus, le poţi repara folosind butonul de mai jos, acesta va recompila codurile alăturate pentru fiecare contor din sistem";
$GLOBALS['strScheduledMaintenanceNotRun'] = "Întreţinerea programată nu a fost executată în ultima oră. Acest lucru ar putea însemna că nu ai setat-o corect.";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "În unele circumstanţe motorul de livrare poate dezaproba ACL-urile stocate pentru bannere şi canale, foloseşte următorul link pentru a valida ACL-urile din baza de date";
$GLOBALS['strServerCommunicationError'] = "<b>Comunicaţia cu serverul de actualizare nu a putut fi stabilită în timp util, astfel ".MAX_PRODUCT_NAME." nu poate verifica dacă o versiune mai nouă este disponibilă în acest moment. Te rugăm să încerci din nou mai târziu.</b>";
?>