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
$Id$
*/


// Settings help translation strings
$GLOBALS['phpAds_hlp_dbhost'] = "\n        �?rja be annak a ".$phpAds_dbmsname." adatbázis kiszolgálónak az állomásnevét, melyhez kapcsolódni kíván.\n		";

$GLOBALS['phpAds_hlp_dbport'] = "\n        �?rja be a ".$phpAds_dbmsname." adatbázis kiszolgáló portját, melyhez kapcsolódni\n		kíván. A ".$phpAds_dbmsname." adatbázis alapértelmezett port száma <i>" . ($phpAds_dbmsname == 'MySQL' ? '3306' : '5432')."</i>.\n		";

$GLOBALS['phpAds_hlp_dbuser'] = "\n        �?rja be azt a felhasználónevet, mellyel a ".MAX_PRODUCT_NAME." hozzá tud férni a ".$phpAds_dbmsname." adatbázis kiszolgálóhoz.\n		";

$GLOBALS['phpAds_hlp_dbpassword'] = "\n        �?rja be azt a jelszót, amivel a ".MAX_PRODUCT_NAME." hozzá tud férni a ".$phpAds_dbmsname." adatbázis kiszolgálóhoz.\n		";

$GLOBALS['phpAds_hlp_dbname'] = "\n        �?rja be az adatbázis kiszolgálón lévő annak az adatbáisnak a nevét, ahol a ".MAX_PRODUCT_NAME." tárolni fogja az adatokat.\n		Fontos, hogy előtte hozza létre az adatbázist az adatbázis kiszolgálón. A ".MAX_PRODUCT_NAME." <b>nem</b> hozza létre\n		ezt az adatbázist, ha még nem létezik.\n		";

$GLOBALS['phpAds_hlp_persistent_connections'] = "\n        Az állandó kapcsolat használata jelentősen felgyorsíthatja a ".MAX_PRODUCT_NAME."\n		futását, sőt, a kiszolgáló terhelését is csökkentheti. Van azonban egy hátránya, olyan\n		helyen, melynek sok a látogatója, a kiszolgáló terhelése növekedhet, és nagyobb lesz,\n		mint normál kapcsolatok használatakor. A hagyományos vagy az állandó kapcsolat használata\n		függ a látogatók számától és a használt hardvertől. Ha a ".MAX_PRODUCT_NAME." túl sok\n		erőforrást köt le, akkor előbb vessen egy pillantást erre a beállításra.\n		";

$GLOBALS['phpAds_hlp_insert_delayed'] = "\n        Adatok beszúrásakor a ".$phpAds_dbmsname." zárolja a táblát. Ha magas a hely látogatottsága,\n		akkor lehet, hogy új sor beszúrása előtt a ".MAX_PRODUCT_NAME." várni fog, mert az adatbázis\n		még le van zárva. Késleltetett beszúrás esetén nem kell várakoznia, és a sor beszúrására\n		egy későbbi időpontban kerül sor, amikor a más szálak nem veszik igénybe a táblát.\n		";

$GLOBALS['phpAds_hlp_compatibility_mode'] = "\n				Ha problémák merülnek fel a ".MAX_PRODUCT_NAME." egy harmadik fél által készített termékbe\n		integrálásakor, akkor segíthet az adatbázis kompatibilitás mód bekapcsolása. Ha helyi módú hívásokat\n		használ, és az adatbázis kompatibilitás módot bekapcsolta, akkor a ".MAX_PRODUCT_NAME." az\n		adatbázis kapcsolat állapotát pontosan ugyanúgy hagyja, ahogy a ".MAX_PRODUCT_NAME." futása\n		előtt volt. Ez a tulajdonság egy kicsit lassú (csak némileg), és ezért alapértelmezés szerint\n		kikapcsolt.\n		";

$GLOBALS['phpAds_hlp_table_prefix'] = "\n        Ha a ".MAX_PRODUCT_NAME." adatbázis használata több szoftvertermék által megosztott, akkor\n		bölcs döntés a táblák nevéhez előtagot hozzáfűzni. Ha ön a ".MAX_PRODUCT_NAME." több telepítését\n		használja ugyanabban az adatbázisban, akkor győződjön meg arról, hogy ez az előtag valamennyi\n		telepítés számára egyedi.\n		";

$GLOBALS['phpAds_hlp_table_type'] = "\n        A ".$phpAds_dbmsname." lehetővé teszi többféle táblatípus használatát. Mindegyik táblatípus\n		egyedi tulajdonságokkal rendelkezik, és némelyik jelentősen felgyorsíthatja a ".MAX_PRODUCT_NAME."\n		futását. A MyISAM az alapértelmezett táblatípus, és a ".MAX_PRODUCT_NAME." valamennyi telepítésében\n		elérhető. Lehet, hogy más táblatípusok nem használhatók a kiszolgálón.\n		";

$GLOBALS['phpAds_hlp_url_prefix'] = "\n        A ".MAX_PRODUCT_NAME." megfelelő működése szempontjából fontos információ a számára,\n				hogy hol helyezkedik el a webkiszolgálón. Meg kell adnia annak a könyvtárnak a hivatkozását, melybe a ".MAX_PRODUCT_NAME."\n				telepítése történt. Például: <i>http://www.az-on-hivatkozasa.com/".MAX_PRODUCT_NAME."</i>.\n		";

$GLOBALS['phpAds_hlp_my_header'] =
$GLOBALS['phpAds_hlp_my_footer'] = "\n        Itt adhatja meg a fejléc fájlok útvonalát (pl.: /home/login/www/header.htm),\n				hogy legyen fejléc és lábjegyzet az adminisztrátori kezelőfelület mindegyik\n				oldalán. Szöveget vagy HTML-kódot egyaránt írhat ezekben a fájlokban (ha az\n				egyik vagy mindkét fájlban HTML-kódot akar használni, akkor ne használjon\n				olyan elemeket, mint a <body> vagy a <html>).\n		";

$GLOBALS['phpAds_hlp_content_gzip_compression'] = "\n		A GZIP tartalomtönörítés engedélyezésével az adminisztrátor kezelőfelület egy oldalának\n		minden alkalommal történő megnyitásakor nagyon csökkenhetnek a böngészőhöz küldött\n		adatok méretei. A funkció engedélyezéséhez legalább PHP 4.0.5 és a GZIP bővítmény\n		telepítése szükséges.\n		";

$GLOBALS['phpAds_hlp_language'] = "\n        Itt választhatja ki a ".MAX_PRODUCT_NAME." által használt alapértelmezett\n				nyelvet. Ez a nyelv alapértelmezettként kerül felhasználásra az adminisztrátor\n				és a hirdető kezelőfelület számára. Ne feledje: az egyes hirdetőknek eltérő\n				nyelvet állíthat be az adminisztrátor kezelőfelületből, és engedélyezhetzi a\n				hirdetőknek, hogy saját maguk váltsák át a nyelvet..\n		";

$GLOBALS['phpAds_hlp_name'] = "\n        �?rja be az ehhez az alkalmazáshoz használni kívánt nevet. Ez a szöveg lesz\n				látható az adminisztrátor és a hirdetű kezelőfelület valamennyi oldalán.\n				Ha üresen (alapértelmezés) hagyja ezt a beállítást, akkor a	".MAX_PRODUCT_NAME."\n				jelenik meg helyette.\n		";

$GLOBALS['phpAds_hlp_company_name'] = "\n        Ez a név kerül felhasználásra a ".MAX_PRODUCT_NAME." által küldött e-mailben.\n		";

$GLOBALS['phpAds_hlp_override_gd_imageformat'] = "\n        A ".MAX_PRODUCT_NAME." általában felismeri, hogy a GD könyvtár telepítve\n				van-e, és a GD telepített változata mely képformátumot támogatja. Azonban\n				lehet, hogy ez a megállapítás pontatlan vagy hamis, a PHP némely verziója\n				nem teszi lehetővé a támogatott képformátumok felismerését. Ha a ".MAX_PRODUCT_NAME."\n				nem tudja automatikusan megállapítani a megfelelő képformátumot, akkor ön is\n				megadhatja azt. A lehetséges értékek: nincs, png, jpeg, gif.\n		";

$GLOBALS['phpAds_hlp_p3p_policies'] = "\n        Ha akarja engedélyezni a ".MAX_PRODUCT_NAME." P3P Adatvédelmi Nyilatkozatát,\n				akkor jelölje be ezt a tulajdonságot.\n		";

$GLOBALS['phpAds_hlp_p3p_compact_policy'] = "\n        A cookie-kkal együtt küldött tömör nyilatkozat. Az alapértelmezett beállítás:\n				'CUR ADM OUR NOR STA NID', ami lehetővé teszi az Internet Explorer 6 számára,\n				hogy elfogadja a ".MAX_PRODUCT_NAME." által használt cookie-kat. Változtathat\n				ezeken a beállításokon, ha akar, hogy megfeleljenek a saját bizalmi\n				nyilatkozatának.\n		";

$GLOBALS['phpAds_hlp_p3p_policy_location'] = "\n        Ha teljes adatvédelmi nyilatkozatot akar használni, akkor megadhatja\n				a nyilatkozat helyét.\n		";

$GLOBALS['phpAds_hlp_log_beacon'] = "\n		A jelzőképek kis méretűek és láthatatlanok, azon az oldalon vannak elhelyezve,\n		melyen a reklám is megjelenik. Ha engedélyezi ezt a funkciót, akkor a\n		".MAX_PRODUCT_NAME." ezt a jelzőképet fogja felhasználni a letöltések\n		számolására, amit a reklám kapott. Ha letiltja ezt a tulajdonságot, akkor a\n		letöltés továbbítás közben kerül számolásra, azonban ez nem teljesen pontos,\n		mert a továbbított reklámot nem kell mindig megjelenítenie a képernyőn.\n		";

$GLOBALS['phpAds_hlp_compact_stats'] = "\n        A ".MAX_PRODUCT_NAME." eredetileg eléggé terjedelmes naplózást használt,\n				ami nagyon részletes volt, viszont nagyon függött az adatbázis kiszolgálótól\n				is. Ez a magas látogatottságú helyeken nagy probléma lehetett. Ennek a\n		proglémának a leküzdésére a ".MAX_PRODUCT_NAME." újfajta statisztikát is\n		támogat, az adatbázis kiszolgálótól kevésbé függő, de kevésbé részletes tömör\n		statisztikát.\n		A tömör statisztika óránként gyűjti a letöltéseket és a kattintásokat, de ha\n		szüksége van a részletekre, a tömör statisztikát kikapcsolhatja.\n		";

$GLOBALS['phpAds_hlp_log_adviews'] = "\n        Normál esetben minden letöltés naplózásra kerül, viszont ha ön nem akar\n				statisztikát gyűjteni a letöltésekről, kikapcsolhatja ezt.\n		";

$GLOBALS['phpAds_hlp_block_adviews'] = "\n		Ha egy látogató frissít egy oldalt, a ".MAX_PRODUCT_NAME." minden alkalommal\n		egy letöltést fog naplózni. Ezzel a funkcióval győződhetünk meg arról, hogy\n		csak egyetlen letöltés lett naplózva minden egyes reklámhoz az ön által megadott\n		másodpercek száma esetén. Például: ha 300 másodpercre állítja ezt az értéket,\n		akkor a ".MAX_PRODUCT_NAME." csak akkor fogja naplózni a kattintásokat, ha\n		ugyanazt a reklámot még nem látta ugyanaz a felhasználó az utóbbi 5 percben.\n		Ez a funkció csak akkor működik, ha a böngésző fogadja a cookie-kat.\n		";

$GLOBALS['phpAds_hlp_log_adclicks'] = "\n        Normál esetben minden kattintás naplózásra kerül, viszont ha ön nem akarja\n				gyűjteni a kattintások statisztikáját, akkor kikapcsolhatja.\n		";

$GLOBALS['phpAds_hlp_block_adclicks'] = "\n		Ha egy látogató többször kattint egy reklámra, a ".MAX_PRODUCT_NAME." minden\n		alkalommal naplóz	egy kattintást. Ezzel a funkcióval győződhetünk meg arról,\n		hogy csak egy kattintás lett naplózva minden egyes reklámhoz az ön által megadott\n		másodpercek száma esetén. Például: ha 300 másodpercre állítja ezt az értéket,\n		akkor a ".MAX_PRODUCT_NAME." csak akkor fogja naplózni a kattintásokat, ha\n		ugyanazt a reklámot még nem látta ugyanaz a felhasználó az utóbbi 5 percben.\n		Ez a funkció csak akkor működik, ha a böngésző fogadja a cookie-kat.\n		";

$GLOBALS['phpAds_hlp_log_source'] = "\n		Ha a forrásparamétert használja a híváskódban, akkor ezt az információt az adatbázisban\n		is tárolhatja, így mindig láthatja a statisztikát arról, hogy hogyan teljesülnek\n		a különféle forrásparaméterek. Ha nem használja a forrásparamétert, vagy nem akarja\n		ennek a paraméternek ez információját tárolni, akkor nyugodtan letilthatja ezt a\n		tulajdonságot.\n		";

$GLOBALS['phpAds_hlp_geotracking_stats'] = "\n		If you are using a geotargeting database you can also store the geographical information\n		in the database. If you have enabled this option you will be able to see statistics about the\n		location of your visitors and how each banner is performing in the different countries.\n		This option will only be available to you if you are using verbose statistics.\n		";

$GLOBALS['phpAds_hlp_log_hostname'] = "\n		Ha a statisztikában tárolni kívánja a látogatók állomásnevét vagy IP-címét, akkor\n		engedélyezheti ezt a funkciót. Ennek az információnak a tárolásával tudhatjuk meg,\n		hogy mely állomások nyerik vissza a legtöbb reklámot. Ez a tulajdonság csak\n		részletes statisztika esetén működik.\n		";

$GLOBALS['phpAds_hlp_log_iponly'] = "\n		A látogató állomásnevének tárolása sok helyet foglal el az adatbázisban. Ha\n		engedélyezi ezt a funkciót, a ".MAX_PRODUCT_NAME." még mindig fogja tárolni\n		az állomást információját, de csak a kevesebb helyet foglaló IP-címet fogja\n		tárolni. Ez a tulajdonság nem működik, ha a kiszolgáló vagy a ".MAX_PRODUCT_NAME."\n		nem adja meg ezt az információt, mert abban az esetben mindig az IP-cím kerül\n		tárolásra.\n		";

$GLOBALS['phpAds_hlp_reverse_lookup'] = "\n		�?ltalában a webkiszolgáló állapítja meg az állomás nevét, de lehet, hogy bizonyos\n		esetekben ki kell kapcsolni. Ha használni kívánja a felhasználók állomásnevét a továbbítási\n		korlátozásokban, és/vagy statisztikát kíván erről vezetni, a kiszolgáló viszont nem\n		szolgáltat ilyen információt, akkor kapcsolja be ezt a tulajdonságot. A látogató\n		állomásnevének megállapítása némi időt vesz igénybe: lassítja a reklámok továbbítását.\n		";

$GLOBALS['phpAds_hlp_proxy_lookup'] = "\n		Vannak olyan látogatók, akik proxy kiszolgálón keresztül kapcsolódnak az Internethez.\n		Ebben az esetben a ".MAX_PRODUCT_NAME." megkísérli naplózni a proxy kiszolgáló IP-címét\n		vagy állomásnevét, a felhasználóé helyett. Ha engedélyezi ezt a funkciót, akkor a\n		".MAX_PRODUCT_NAME." megpróbálja a proxy kiszolgáló mögött tartózkodó felhasználó\n		számítógépének IP-címét vagy állomásnevét. Ha nem lehet a látogató pontos címét\n		megkeresni, akkor a proxy kiszolgáló címét használja. Ez a funkció alapértelmezésként\n		nem engedélyezett, mert jelentősen lelassítja a reklámok továbbítását.\n		";

$GLOBALS['phpAds_hlp_auto_clean_tables'] =
$GLOBALS['phpAds_hlp_auto_clean_tables_interval'] = "\n		Ha engedélyezi ezt a tulajdonságot, akkor az összegyűjtött statisztika az alábbi\n		jelölőnégyzetben megadott időtartam leteltével automatikusan törlésre kerül. Például,\n		ha 5 hétre állítja ezt a jelölőnégyzetet, akkor az 5 hétnél régebbi statisztika\n		automatikusan törlésre kerül.\n		";

$GLOBALS['phpAds_hlp_auto_clean_userlog'] =
$GLOBALS['phpAds_hlp_auto_clean_userlog_interval'] = "\n		Ez a tulajdonság automatikusan törli azokat a bejegyzéseket a felashználói naplóból,\n		melyek régebbiek az alábbi jelölőnégyzetben megadott hetek számánál.\n		";

$GLOBALS['phpAds_hlp_geotracking_type'] = "\n		A geotargeting lehetővé teszi, hogy a ".MAX_PRODUCT_NAME." földrajzi információvá\n		alakítsa a látogató IP-címét. Ezeknek az információknak az alapján szabályozhatja a\n		továbbítás korlátozását, vagy eltárolhatja ezt az információt, így megtekintheti, hogy\n		mely ország generálja a legtöbb letöltést vagy kattintást. Ha engedélyezni akarja a\n		geotargetinget, akkor ki kell választania, hogy mely adatbázis típusokkal rendelkezik.\n		A ".MAX_PRODUCT_NAME." jelenleg az IP2Country\n		és a <a href='http://www.maxmind.com/?rId=phpadsnew2' target='_blank'>GeoIP</a> adatbázisokat\n		támogatja.\n		";

$GLOBALS['phpAds_hlp_geotracking_location'] = "\n		Amikor nem ön a GeoIP Apache modul, akkor meg kell adnia a ".MAX_PRODUCT_NAME." számára\n		a geotargeting adatbázis helyét. Az adatbázist érdemes mindig a webkiszolgálók\n		dokumentumgyökerén kívül elhelyezni, mert különben le lehet tölteni az adatbázist.\n		";

$GLOBALS['phpAds_hlp_geotracking_cookie'] = "\n		Az IP-cím földrajzi adatokká alakítása időigényes feladat. A ".MAX_PRODUCT_NAME."\n		a reklám minden alkalommal történő továbbításának megakadályozására az eredményt egy\n		cookie-ban tudja tárolni. Ha ez a cookie létezik, akkor a ".MAX_PRODUCT_NAME."\n		ezt az információt használja fel az IP-cím átalakítása helyett.\n		";

$GLOBALS['phpAds_hlp_ignore_hosts'] = "\n        Ha nem akarja számolni valamely számítógépről érkező kattintásokat és letöltéseket,\n				akkor ezeket felveheti erre a listára. A fordított keresés engedélyezése esetén\n				tartományneveket és IP-címeket egyaránt felvehet, egyéb esetben csak az IP-címeket\n				használhatja. Karakterhelyettesítőket is használhat (pl. '*.altavista.com' vagy\n				'192.168.*').\n		";

$GLOBALS['phpAds_hlp_begin_of_week'] = "\n        A legtöbb ember számára a hét első napja a hétfő, de ha a vasárnappal akarja\n				kezdeni a hetet, megteheti.\n		";

$GLOBALS['phpAds_hlp_percentage_decimals'] = "\n        Azt szabja meg, hogy hány tizes hely legyen látható a statisztikai oldalakon.\n		";

$GLOBALS['phpAds_hlp_warn_admin'] = "\n        A ".MAX_PRODUCT_NAME." e-mailt tud önnek küldeni, ha egy kampányban már csak\n				korlátozott számú kattintás vagy letöltés van hátra. Alapértelmezésként ez\n				engedélyezett.\n		";

$GLOBALS['phpAds_hlp_warn_client'] = "\n        A ".MAX_PRODUCT_NAME." e-mailt tud küldeni a hirdetőnek, ha valamelyik kampányában\n		csak korlátozott számú kattintás vagy letöltés van hátra. Alapértelmezésként ez\n		engedélyezett.\n		";

$GLOBALS['phpAds_hlp_qmail_patch'] = "\n		A qmail némely verziójára egy hiba van hatással, ami a ".MAX_PRODUCT_NAME." által\n		küldött e-mailben a fejlécnek az e-mail törzsében lévő megjelenítését okozza. Ha\n		engedélyezi ezt a beállítást, akkor a ".MAX_PRODUCT_NAME." qmail kompatibilis\n		formátumban fogja küldeni az e-mailt.\n		";

$GLOBALS['phpAds_hlp_warn_limit'] = "\n        A határ, melynek elérésekor a ".MAX_PRODUCT_NAME." figyelmeztető e-maileket\n				kezd küldeni. Ez az érték 100 alapértelmezésként.\n		";

$GLOBALS['phpAds_hlp_allow_invocation_plain'] =
$GLOBALS['phpAds_hlp_allow_invocation_js'] =
$GLOBALS['phpAds_hlp_allow_invocation_frame'] =
$GLOBALS['phpAds_hlp_allow_invocation_xmlrpc'] =
$GLOBALS['phpAds_hlp_allow_invocation_local'] =
$GLOBALS['phpAds_hlp_allow_invocation_interstitial'] =
$GLOBALS['phpAds_hlp_allow_invocation_popup'] = "\n		Ezekkel a beállításokkal szabályozhatja az engedélyezett hívástípusokat.\n		Ha az egyik hívástípus letiltott, akkor a híváskód / reklámkód generátor\n		számára nem hozzáférhető. Fontos: a hívásmódszerek még mindig működni fognak,\n		ha letiltottak, viszont a generálás számára nem elérhetőek.\n		";

$GLOBALS['phpAds_hlp_con_key'] = "\n        A ".MAX_PRODUCT_NAME." közvetlen választást használó hatékony visszakereső\n		rendszert tartalmaz. Részleteket a felhasználói kézikönyvben olvashat erről. Ezzel\n		a tulajdonsággal aktiválhatja a feltételes kulcsszavakat. Alapértelmezésként\n		engedélyezve.\n		";

$GLOBALS['phpAds_hlp_mult_key'] = "\n        Ha a közvetlen kiválasztást használja a reklámok megjelenítésére, akkor mindegyikhez\n		megadhat kulcsszavakat. Engedélyeznie kell ezt a tulajdonságot, ha egynél több\n		kulcsszót akar megadni. Alapértelmezésként engedélyezve.\n		";

$GLOBALS['phpAds_hlp_acl'] = "\n        Ha nem használja a továbbítási korlátozásokat, akkor ezzel a tulajdonsággal letilthatja\n				ezt a paramétert. Ez egy kicsit felgyorsítja a ".MAX_PRODUCT_NAME." működését.\n		";

$GLOBALS['phpAds_hlp_default_banner_url'] =
$GLOBALS['phpAds_hlp_default_banner_target'] = "\n        Ha a ".MAX_PRODUCT_NAME." nem tud kapcsolódni az adatbázis kiszolgálóhoz, vagy\n				egyáltalán nem talál egyező reklámokat, például amikor összeomlik vagy törlésre\n				kerül az adatbázis, akkor nem jelenít meg semmit. Lehet, hogy lesz olyan felhasználó,\n				aki ilyen esetben megjelenítésre kerülő alapértelmezett reklámot akar megadni.\n				Az itt megadott alapértelmezett reklám nem kerül naplózásra, és nem kerül felhasználásra,\n				ha maradnak még aktív reklámok az adatbázisban. Alapértelmezésként tiltva.\n		";

$GLOBALS['phpAds_hlp_delivery_caching'] = "\n		A továbbítás felgyorsításának előmozdítására a ".MAX_PRODUCT_NAME." gyorsítótárat\n		használ, ami tartalmazza a webhely látogatója számára megjelenő reklám továbbításához\n		szükséges információkat. A továbbítás gyorsítótár alapértelmezésként az adatbázisban\n		található, de a sebesség további növeléséhez lehetőség van a gyorsítótár fájlban\n		vagy osztott memóriában történő tárolására. Az osztott memória a leggyorsabb, a fájl\n		is gyors. A továbbítás gyorsítótár kikapcsolása nem ajánlott, mert ez komoly hatást\n		gyakorol a rendszerre.\n		";

$GLOBALS['phpAds_hlp_type_sql_allow'] =
$GLOBALS['phpAds_hlp_type_web_allow'] =
$GLOBALS['phpAds_hlp_type_url_allow'] =
$GLOBALS['phpAds_hlp_type_html_allow'] =
$GLOBALS['phpAds_hlp_type_txt_allow'] = "\n        A ".MAX_PRODUCT_NAME." különféle típusú reklámokat tud felhasználni, ezeket\n				különféle módon tudja tárolni. Az első két tulajdonság a reklámok helyi tárolására\n				használható. Az adminisztrátor kezelőfelületen töltheti fel a reklámot, amit a\n				".MAX_PRODUCT_NAME." az SQL adatbázisban vagy a webkiszolgálón fog tárolni.\n		Külső webkiszolgálón tárolt reklámot is használhat, ill. használhat HTML-t vagy\n		egyszerű szöveget a reklám generálásához.\n		";

$GLOBALS['phpAds_hlp_type_web_mode'] = "\n        Ha a webkiszolgálón tárolt reklámokat akar használni, akkor konfigurálnia\n				kell ezt a beállítást. Ha helyi mappában kívánja tárolni a reklámokat, akkor\n				a <i>Helyi könyvtár</i> elemet jelölje ki. Ha külső FTP-kiszolgálón akarja\n		tárolni a reklámokat, akkor a <i>Külső FTP-kiszolgáló</i> elemet jelölje ki.\n		Lehet, hogy némely webkiszolgálón, sőt, akár a helyi webkiszolgálón is az\n		FTP-opciót kívánja használni.\n		";

$GLOBALS['phpAds_hlp_type_web_dir'] = "\n        Adja meg a mappát, melybe a ".MAX_PRODUCT_NAME." a feltöltött reklámokat\n				fogja másolni. A PHP számára ennek a mappának írhatónak kell lennie, ami\n				azt jelenti, hogy önnek módosítania kell a könyvtár UNIX engedélyeit (chmod).\n				Az ön által itt megadott könyvtárnak a webkiszolgáló dokumentumgyökerében\n				kell lennie, a webkiszolgálónak közvetlenül kell tudnia szolgálnia a fájlokat.\n				Ne írjon be per jelet (/). Csak akkor kell ezt a beállítást elvégeznie, ha\n				tárolási módként a <i>Helyi könyvtár</i> elemet jelölte ki.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_host'] = "\n		Ha a <i>Külső FTP-kiszolgáló</i> tárolási módot választotta, akkor meg\n		kell adnia annak az FTP-kiszolgálónak az IP-címét vagy tartománynevét, melyre a\n		".MAX_PRODUCT_NAME." a feltöltött reklámokat másolni fogja.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_path'] = "\n		Ha a <i>Külső FTP-kiszolgáló</i> tárolási módot választotta, akkor meg\n		kell adnia az FTP-kiszolgálón azt a könyvtárat, melybe a ".MAX_PRODUCT_NAME."\n		a feltöltött reklámokat másolni fogja.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_user'] = "\n		Ha a <i>Külső FTP-kiszolgáló</i> tárolási módot választotta, akkor meg\n		kell adnia azt a felhasználónevet, melyet a ".MAX_PRODUCT_NAME." használni\n		fog a külső FTP-kiszolgálóhoz történő csatlakozáskor.\n		";

$GLOBALS['phpAds_hlp_type_web_ftp_password'] = "\n		Ha a <i>Külső FTP-kiszolgáló</i> tárolási módot választotta, akkor meg\n		kell adnia azt a jelszót, melyet a ".MAX_PRODUCT_NAME." használni\n		fog a külső FTP-kiszolgálóhoz történő csatlakozáskor.\n		";

$GLOBALS['phpAds_hlp_type_web_url'] = "\n        Ha webkiszolgálón tárol reklámokat, akkor a ".MAX_PRODUCT_NAME." számára\n				meg kell adnia, hogy melyik nyilvános hivatkozás tartozik az alább megadott\n				könyvtárhoz. Ne írjon be per jelet (/).\n		";

$GLOBALS['phpAds_hlp_type_html_auto'] = "\n        Ha engedélyezi ezt a tulajdonságot, akkor a ".MAX_PRODUCT_NAME." automatikusan\n				váltogatja a HTML reklámokat, hogy engedélyezze a kattintások naplózását. Viszont\n				még ennek atulajdonságnak az engedélyezése esetén is lehetőség van ennek a tulajdonságnak\n				a reklám alapú letiltására.\n		";

$GLOBALS['phpAds_hlp_type_html_php'] = "\n        Lehetőség van arra, hogy a ".MAX_PRODUCT_NAME." a HTML-reklámokba ágyazott\n				PHP-kódot hajtson végre. A funkció alapértelmezésként tiltva.\n		";

$GLOBALS['phpAds_hlp_admin'] = "\n        �?rja be az adminisztrátor felhasználónevét. Ezzel a felhasználónévvel\n				jelentkezhet be ön az adminisztrátor kezelőfelületre.\n		";

$GLOBALS['phpAds_hlp_admin_pw'] =
$GLOBALS['phpAds_hlp_admin_pw2'] = "\n        �?rja be az adminisztrátor kezelőfelületre történő bejelentkezéshez szükséges\n				jelszót. A gépelési hibák megelőzése céljából kétszer kell beírnia.\n		";

$GLOBALS['phpAds_hlp_pwold'] =
$GLOBALS['phpAds_hlp_pw'] =
$GLOBALS['phpAds_hlp_pw2'] = "\n        Az adminisztrátor jelszavának megváltoztatásához meg kell adnia a\n				fentiekben a régi jelszót. Továbbá, a gépelési hibák elkerülése végett\n				kétszer meg kell adnia az új jelszót.\n		";

$GLOBALS['phpAds_hlp_admin_fullname'] = "\n        Adja meg az adminisztrátor teljes nevét. Ez a név kerül felhasználásra\n				a statisztika e-mailben történő küldésekor.\n		";

$GLOBALS['phpAds_hlp_admin_email'] = "\n        Az adminisztrátor e-mail címe. Ez kerül felhasználásra a Feladó mezőben\n				a statisztika	e-mailben történő küldésekor.\n		";

$GLOBALS['phpAds_hlp_admin_email_headers'] = "\n        Módosíthatja a ".MAX_PRODUCT_NAME." által küldött e-mailekben használt fejléceket.\n		";

$GLOBALS['phpAds_hlp_admin_novice'] = "\n        Ha szeretne figyelmeztetést kapni a hirdetők, kampányok, reklámok, kiadók és zónák\n				törlése előtt, akkor válassza az igaz tulajdonságot.\n		";

$GLOBALS['phpAds_hlp_client_welcome'] = "\n		Ha engedélyezi ezt a tulajdonságot, akkor a hirdető bejelentkezése utáni első\n		oldalon egy üdvözlet fog megjelenni. Az admin/templates mappában lévő welcome.html\n		fájlban a saját üdvözletét írhatja le. Néhány dolog, amit érdemes tartalmaznia:\n		az ön cégének a neve, elérhetősége, a cég logója, a hirdetési árak oldalára\n		mutató hivatkozás, stb.\n		";

$GLOBALS['phpAds_hlp_client_welcome_msg'] = "\n		A welcome.html fájl átszerkesztése helyett itt adhat meg egy rövid szöveget. Ha ide\n		szöveget ír be, akkor a welcome.html fájl kihagyásra kerül. Használhat HTML elemeket is.\n		";

$GLOBALS['phpAds_hlp_updates_frequency'] = "\n		Ha szeretné ellenőrizni a ".MAX_PRODUCT_NAME." új verzióit, akkor érdemes engedélyezni\n		ezt a tulajdonságot. Meghatározhatja azt is, hogy a ".MAX_PRODUCT_NAME." milyen\n		időközönként kapcsolódjon a termékfrissítési kiszolgálóhoz. Ha jelent meg új verzió,\n		akkor megjelenik a frissítésről további információt tartalmazó párbeszédablak.\n		";

$GLOBALS['phpAds_hlp_userlog_email'] = "\n		Ha szeretné a ".MAX_PRODUCT_NAME." által küldött elektronikus üzenetek másolatait\n		megtartani, akkor engedélyezze ezt a funkciót. Az elküldött üzenetek a felhasználói naplóban\n		kerülnek tárolásra.\n		";

$GLOBALS['phpAds_hlp_userlog_priority'] = "\n		Ha meg akar győződni arról, hogy a prioritás kiszámítása megfelelő volt, akkor\n		mentést készíthet az óránkénti számolásról. Ez a jelentés tartalmazza a megjósolt\n		profilt, és hogy mekkora prioritás lett hozzárendelve az összes reklámhoz. Ez\n		az információ akkor lehet hasznos, ha ön hibabejelentést kíván küldeni a\n		prioritás kiszámításáról. A jelentések tárolása a felhasználói naplóban történik.\n		";

$GLOBALS['phpAds_hlp_userlog_autoclean'] = "\n		Ha meg akar győződni arról, hogy az adatbázis tisztítása megfelelő volt, akkor\n		mentheti a jelentést arról, hogy valójában mi is történt tisztítás közben.\n		Ennek az információnak a tárolása a felhasználói naplóban történik.\n		";

$GLOBALS['phpAds_hlp_default_banner_weight'] = "\n		Ha magasabbra kívánja állítani az alapértelmezett reklám fontosságot, akkor itt\n		adhatja meg az óhajtott fontossági értéket. Ez az érték 1 alapértelmezésként.\n		";

$GLOBALS['phpAds_hlp_default_campaign_weight'] = "\n		Ha magasabbra kívánja állítani az alapértelmezett kampány fontosságot, akkor itt\n		adhatja meg az óhajtott fontossági értéket. Ez az érték 1 alapértelmezésként.\n		";

$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "\n		Ha engedélyezi ezt a tulajdonságot, akkor <i>Kampány áttekintése</i> oldalon további\n		információ jelenik meg az egyes kampányokról. Ez a további információ tartalmazza\n		a hátralévő letöltések és a hátralévő kattintások számát, az aktiválás dátumát,\n		a lejárat dátumát és a beállított prioritást.\n		";

$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "\n		Ha engedélyezi ezt a tulajdonságot, akkor a <i>Reklám áttekintése</i> oldalon további\n		információ jelenik meg az egyes reklámokról. A kiegészítő információ tartalmazza a\n		cél hivatkozást, a kulcsszavakat, a méretet és a reklám fontosságát.\n		";

$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "\n		Ha engedélyezi ezt a tulajdonságot, akkor a <i>Reklám áttekintése</i> oldalon látható lesz\n		a reklámok képe. A tulajdonság letiltása esetén még mindig lehetőség van a reklámok\n		megtekintésére, ha a <i>Reklám áttekintése</i> oldalon a reklám melletti háromszögre\n		kattint.\n		";

$GLOBALS['phpAds_hlp_gui_show_banner_html'] = "\n		Ha engedélyezi ezt a tulajdonságot, akkor a tényleges HTML-reklám fog megjelenni a HTML-kód\n		helyett. Ez a tulajdonság alapértelmezésként letiltott, mert lehet, hogy a HTML-reklámok\n		ütköznek a felhasználói kezelőfelülettel. Ha ez a tulajdonság letiltott, még mindig lehetséges\n		az aktuális HTML-reklám megtekintése, a HTML-kód melletti <i>Reklám megjelenítése</i>\n		gombra kattintással.\n		";

$GLOBALS['phpAds_hlp_gui_show_banner_preview'] = "\n		Ha engedélyezi ezt a tulajdonságot, akkor a <i>Reklám tulajdonságai</i>,\n		a <i>Továbbítás tulajdonságai</i> és a <i>Zónák kapcsolása</i> oldalak tetején megtekinthető\n		előnézetben. A rulajdonság letiltása esetén még mindig lehetőség van a reklám\n		megtekintésére az oldalak tetején lévő <i>Reklám megjelenítése</i> gombra\n		kattintással.\n		";

$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "\n		Ha engedélyezi ezt a tulajdonságot, akkor a <i>Hirdetők és kampányok</i>, ill. a\n		<i>Kampány áttekintése</i> oldalon elrejti az inaktív reklámokat, kampányokat és\n		hirdetőket. A tulajdonság engedélyezése esetén még mindig lehetőség van a rejtett\n		elemek megjelenítésére, ha a <i>Mind megjelenítése</i> gombra kattint az oldal\n		alján.\n		";

$GLOBALS['phpAds_hlp_gui_show_matching'] = "\n		Ha engedélyezi a tulajdonságot, akkor a megfelelő reklám fog megjelenni a\n		<i>Kapcsolt reklámok</i> oldalon, a <i>Kampány kiválasztása</i> módszer kiválasztása\n		esetén. Ez teszi lehetővé, hogy ön megtekinthesse, pontosan mely reklámokat is vegye\n		figyelembe továbbítás céljából kapcsolt kampány esetén. Lehetőség van az egyező\n		reklámok megtekintésére is.\n		";

$GLOBALS['phpAds_hlp_gui_show_parents'] = "\n		Ha engedélyezi ezt a tulajdonságot, akkor a reklámok szülő kampányai láthatók lesznek\n		a <i>Kapcsolt reklámok</i> oldalon a <i>Reklám kiválasztása</i> mód választása esetén.\n		�?gy válik lehetővé az ön számára, hogy a reklám kapcsolása előtt megtekinthesse, melyik\n		reklám melyik kampányhoz is tartozik. Ez azt is jelenti, hogy a reklámok csoportosítása\n		a szülő kampányok alapján történik, és tovább már nem betűrendbe soroltak.\n		";

$GLOBALS['phpAds_hlp_gui_link_compact_limit'] = "\n		Alapértelmezésként valamennyi létező reklám vagy kampány látható a <i>Kapcsolt reklámok</i>\n		oldalon. Emiatt ez az oldal nagyon hosszú lehet, sokféle reklám található a Nyilvántartóban.\n		Ez a tulajdonság teszi lehetővé oldalon megjelenő objektumok maximális számát. Ha több\n		objektum van, és a reklám kapcsolása különbözőképpen történik, akkor az jelenik meg,\n		amelyik sokkal kevesebb helyet foglal el.\n		";

?>