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
$GLOBALS['strChooseSection'] = "Alege Secţiune";
$GLOBALS['strAppendCodes'] = "Alătură coduri";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>Întreţinerea programată nu a fost executată în ultima oră. Acest lucru ar putea însemna că nu ai setat-o corect.</b>";

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "Întreţinerea automată a fost activată, dar nu a fost pornită. Întreţinerea automată este accesată doar când {$PRODUCT_NAME} afişează bannere. Pentru cea mai bună performanţă, ar trebuie să setezi <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>întreţinerea programată</a>";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "Întreţinerea automată este dezactivată momentan, astfel că atunci când {$PRODUCT_NAME} afişează bannere, întreţinerea automată nu va fi executată. Pentru cea mai bună performanţă, ar trebui să setezi <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>întreţinerea programată</a>. Totuşi, dacă nu ai de gând să setezi <a href='http://{$PRODUCT_DOCSURL}/maintenance' target='_blank'>întreţinerea programată</a>, atunci <i>trebuie</i> să <a href='account-settings-maintenance.php'>activezi întreţinerea automată</a> pentru a fi sigur că {$PRODUCT_NAME} funcţionează corect.";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "Întreţinerea automată a fost activată şi va fi accesată, când este necesar, atunci când {$PRODUCT_NAME} afişează bannere. Totuşi, pentru cea mai bună performanţă, ar trebuie să setezi <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>întreţinerea programată</a>.";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "Totuşi, întreţinerea automată a fost dezactivată recent. Pentru a te asigura că {$PRODUCT_NAME} funcţionează corect, ar trebui să setezi <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>întreţinerea programată</a> sau să <a href='account-settings-maintenance.php'>re-activezi întreţinerea automată</a>.<br><br>Pentru cea mai bună performanţă, ar trebui să setezi <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>întreţinerea programată</a>.";

$GLOBALS['strScheduledMantenaceRunning'] = "<b>Întreţinerea programată funcţionează corect.</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>Întreţinerea automată funcţionează corect.</b>";

$GLOBALS['strAutoMantenaceEnabled'] = "Totuşi, întreţinerea automată încă este activată. Pentru cea mai bună performanţă, ar trebui să <a href='account-settings-maintenance.php'>dezactivezi întreţinerea automată</a>.";

// Priority
$GLOBALS['strRecalculatePriority'] = "Recalculează prioritatea";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Verifică cache banner";
$GLOBALS['strBannerCacheErrorsFound'] = "Verificarea bazei de date pentru cache-ul bannerului a întâmpinat unele erori. Aceste bannere nu vor funcţiona până când nu le repari manual.";
$GLOBALS['strBannerCacheOK'] = "Nu a fost detectată nici o eroare. Baza de date cu cache-ul bannerului este actualizată";
$GLOBALS['strBannerCacheDifferencesFound'] = "Verificarea bazei de date pentru cache-ul bannerului a descoperit ca sunt necesare actualizări ce necesită reconstruirea acesteia. Apasă aici pentru actualizarea automată a cache-ului.";
$GLOBALS['strBannerCacheRebuildButton'] = "Reconstruieşte";
$GLOBALS['strRebuildDeliveryCache'] = "Reconstruieşte baza de date cu cache-ul bannerului";
$GLOBALS['strBannerCacheExplaination'] = "   Baza de date cu cache-ul bannerului este utilizată pentru a spori viteza de livrare a banner-elor in timpul distribuţiei<br />
   Acest cache are nevoie de actualizări atunci când:
<ul>
<li>Actualizezi versiunea sistemului de reclame</li>
<li>Muţi folder-ul de instalare al sistemului de reclame pe un alt server</li>
</ul>";

// Cache
$GLOBALS['strCache'] = "Cache Distribuţie";
$GLOBALS['strDeliveryCacheSharedMem'] = "	Memoria împărţită este momentan utilizată pentru a stoca cache-ul distribuţiei.";
$GLOBALS['strDeliveryCacheDatabase'] = "	Baza de date este momentan utilizată pentru a stoca cache-ul distribuţiei.";
$GLOBALS['strDeliveryCacheFiles'] = "	Cache-ul distribuţiei este stocat momentan în mai multe fişiere de pe server.";

// Storage
$GLOBALS['strStorage'] = "Stocare";
$GLOBALS['strMoveToDirectory'] = "Mută imaginile stocate în baza de date într-un director";
$GLOBALS['strStorageExplaination'] = "	Imaginile utilizate de bannerele locale sunt stocate în interiorul bazei de date sau stocate într-un director. Dacă stochezi imaginile într-un
	director, utilizarea bazei de date va fi redusă, ceea ce va duce la o viteză îmbunătăţită.";

// Encoding
$GLOBALS['strEncoding'] = "Codare";
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} acum stochează toate datele în baza de date în format UTF-8.<br />Acolo unde este posibil, datele tale vor fi automat convertite către această codare.<br />Dacă după actualizare găseşti caractere corupte, şi cunoşi codarea folosită, poţi folosi această unealtă pentru a converti datele din acel format în UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Converteşte din această codare:";
$GLOBALS['strEncodingConvertTest'] = "Verifică conversia";
$GLOBALS['strConvertThese'] = "Următoarele date vor fi schimbate dacă continui";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Caut actualizări. Te rugăm să aştepţi...";
$GLOBALS['strAvailableUpdates'] = "Actualizări disponibile";
$GLOBALS['strDownloadZip'] = "Descarcă (.zip)";
$GLOBALS['strDownloadGZip'] = "Descarcă (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "Este disponibilă o nouă versiune pentru {$PRODUCT_NAME}.

Vrei să obţii mai multe informaţii
despre această actualizare?";
$GLOBALS['strUpdateAlertSecurity'] = "Este disponibilă o nouă versiune pentru {$PRODUCT_NAME}.
Este recomandat să actualizaţi
cât se poate de repede, deoarece această
versiune conţine una sau mai multe rezolvări legate de securitate.";

$GLOBALS['strUpdateServerDown'] = "Nu este posibilă obţinerea informaţiilor despre<br>eventualele actualizări din cauya unui motiv necunoscut. Te rugăm să încerci din nou.";

$GLOBALS['strNoNewVersionAvailable'] = "	Versiunea ta de {$PRODUCT_NAME} este cea mai recentă. Nu sunt alte actualizări disponibile.";

$GLOBALS['strServerCommunicationError'] = "<b>Comunicaţia cu serverul de actualizare nu a putut fi stabilită în timp util, astfel {$PRODUCT_NAME} nu poate verifica dacă o versiune mai nouă este disponibilă în acest moment. Te rugăm să încerci din nou mai târziu.</b>";


$GLOBALS['strNewVersionAvailable'] = "	<b>Este disponibilă o noua versiune de {$PRODUCT_NAME}.</b><br />Este recomandat să instalezi această actualizare,
	deoarece ar putea corecta unele probleme existente şi va adăuga noi facilităţi. Pentru mai multe informaţii
	despre actualizare te rugăm să citeşti documentaţia ce este inclusă în fişierele de mai jos.";

$GLOBALS['strSecurityUpdate'] = "	<b>Este recomandat să instalezi această actualizare cat mai repede cu putinţă, deoarece conţine un număr
	de corecţii ale securităţii.</b> Versiunea de {$PRODUCT_NAME} pe care o utilizezi momentan s-ar putea
	să fie vulnerabilă unor atacuri şi probabil nu este sigură. Pentru mai multe informaţii
	despre actualizare te rugăm să citeşti documentaţia inclusă în fişierele de mai jos.";

$GLOBALS['strNotAbleToCheck'] = "	<b>Deoarece extensiile XML nu sunt valabile pe acest server, {$PRODUCT_NAME} nu poate
verifica dacă este disponibilă o versiune mai nouă.</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "	Dacă doreşi să afli noutăţi despre ultima versiune disponibilă, te rugăm sa accesezi site-ul nostru.";

$GLOBALS['strClickToVisitWebsite'] = "Click aici pentru a vizita site-ul nostru";
$GLOBALS['strCurrentlyUsing'] = "Momentan utilizezi";
$GLOBALS['strRunningOn'] = "rulând pe";
$GLOBALS['strAndPlain'] = "şi";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "Limitări Livare";
$GLOBALS['strAllBannerChannelCompiled'] = "Toate valorile de limitare compilate ale banner-ului/canalului au fost recompilate";
$GLOBALS['strBannerChannelResult'] = "Aici sunt rezultatele validării limitării compilate ale banner-ului/canalului";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Toate limitările compilate ale canalului sunt valide";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Toate limitările compilate ale banner-ului sunt valide";
$GLOBALS['strErrorsFound'] = "Au fost găsite erori";
$GLOBALS['strRepairCompiledLimitations'] = "Au fost găsite unele incompatibilităţi deasupra, le poţi repara folosind butonul de mai jos, acesta va recompila limitarea compilată pentru fiecare banner/canal din sistem<br />";
$GLOBALS['strRecompile'] = "Recompilează";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "În unele circumstanţe motorul de livrare poate dezaproba ACL-urile stocate pentru bannere şi canale, foloseşte următorul link pentru a valida ACL-urile din baza de date";
$GLOBALS['strCheckACLs'] = "Verifică ACL-uri";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "În unele circumstanţe motorul de livrare poate dezaproba codul alăturat contoarelor, foloseşte următorul link pentru a valida codul alăturat din baza de date";
$GLOBALS['strCheckAppendCodes'] = "Verifica codurile alăturate";
$GLOBALS['strAppendCodesRecompiled'] = "Toate valorile codurilor alăturate compilate au fost recompilate";
$GLOBALS['strAppendCodesResult'] = "Aici sunt rezultatele validării codurilor alăturate compilate";
$GLOBALS['strAppendCodesValid'] = "Toate codurile alăturate ale contorului compilate sunt valide";
$GLOBALS['strRepairAppenedCodes'] = "Au fost găsite unele incompatibilităţi mai sus, le poţi repara folosind butonul de mai jos, acesta va recompila codurile alăturate pentru fiecare contor din sistem";


