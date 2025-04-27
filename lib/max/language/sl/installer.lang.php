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

/** status messages * */
$GLOBALS['strInstallStatusRecovery'] = 'Obnavljanje Revive Adserver %s';
$GLOBALS['strInstallStatusInstall'] = 'Nameščanje Revive Adserver %s';
$GLOBALS['strInstallStatusUpgrade'] = 'Nadgradnja na Revive Adserver %s';
$GLOBALS['strInstallStatusUpToDate'] = 'Zaznan Revive Adserver %s';

/** welcome step * */
$GLOBALS['strWelcomeTitle'] = "Dobrodošli v {$PRODUCT_NAME}";
$GLOBALS['strInstallIntro'] = "Hvala, da ste izbrali {$PRODUCT_NAME}. Ta čarovnik vas bo popeljal skozi postopek namestitve {$PRODUCT_NAME}.";
$GLOBALS['strUpgradeIntro'] = "Hvala, da ste izbrali {$PRODUCT_NAME}. Ta čarovnik vas bo popeljal skozi postopek nadgradnje {$PRODUCT_NAME}.";
$GLOBALS['strInstallerHelpIntro'] = "Za pomoč pri postopku namestitve {$PRODUCT_NAME} si oglejte <a href='{$PRODUCT_DOCSURL}' target='_blank'>dokumentacijo</a>.";
$GLOBALS['strTermsIntro'] = "{$PRODUCT_NAME} je na voljo brezplačno pod licenco Open Source, GNU General Public License. Prosimo, preberite in se strinjajte z naslednjimi dokumenti, da nadaljujete z namestitvijo.";

/** check step * */
$GLOBALS['strSystemCheck'] = "Kontrola sistema";
$GLOBALS['strSystemCheckIntro'] = "Namestitveni čarovnik je izvedel preverjanje nastavitev vašega spletnega strežnika, da bi zagotovil, da se postopek namestitve lahko uspešno zaključi.
                                                  <br>Prosimo, preverite morebitne izpostavljene težave, da zaključite postopek namestitve.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Konfiguracija vašega spletnega strežnika ne izpolnjuje zahtev {$PRODUCT_NAME}.
                                                   <br>Za nadaljevanje namestitve, prosimo, odpravite vse napake.
                                                   Za pomoč si oglejte našo <a href='{$PRODUCT_DOCSURL}'>dokumentacijo</a> in <a href='http://{$PRODUCT_URL}/faq'>pogosta vprašanja</a>.";

$GLOBALS['strAppCheckErrors'] = "Pri zaznavanju prejšnjih namestitev {$PRODUCT_NAME} so bile najdene napake.";
$GLOBALS['strAppCheckDbIntegrityError'] = "Zaznali smo težave z integriteto vaše podatkovne baze. To pomeni, da se struktura vaše podatkovne baze
                                                   razlikuje od pričakovane. To je lahko posledica ročne prilagoditve vaše podatkovne baze.";

$GLOBALS['strSyscheckProgressMessage'] = "Preverjanje sistemskih parametrov...";
$GLOBALS['strError'] = "Napaka";
$GLOBALS['strWarning'] = "Opozorilo";
$GLOBALS['strOK'] = "OK";
$GLOBALS['strSyscheckName'] = "Preveri ime";
$GLOBALS['strSyscheckValue'] = "Trenutna vrednost";
$GLOBALS['strSyscheckStatus'] = "Stanje";
$GLOBALS['strSyscheckSeeFullReport'] = "Prikaži podrobno kontrolo sistema";
$GLOBALS['strSyscheckSeeShortReport'] = "Prikaži samo napake in opozorila";
$GLOBALS['strBrowserCookies'] = 'Piškotki brskalnika';
$GLOBALS['strPHPConfiguration'] = 'PHP nastavitve';
$GLOBALS['strCheckError'] = 'napaka';
$GLOBALS['strCheckErrors'] = 'napake';
$GLOBALS['strCheckWarning'] = 'opozorilo';
$GLOBALS['strCheckWarnings'] = 'opozorila';

/** admin login step * */
$GLOBALS['strAdminLoginTitle'] = "Prosimo, prijavite se kot skrbnik {$PRODUCT_NAME}.";
$GLOBALS['strAdminLoginIntro'] = "Za nadaljevanje prosimo, vnesite prijavne podatke za račun sistemskega administratorja {$PRODUCT_NAME}.";
$GLOBALS['strLoginProgressMessage'] = 'Prijavljanje ...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "Zagotovite podatkovno bazo";
$GLOBALS['strDbSetupIntro'] = "Zagotovite podrobnosti za povezavo z {$PRODUCT_NAME} podatkovno bazo.";
$GLOBALS['strDbUpgradeTitle'] = "Podatkovna baza je bila zaznana";
$GLOBALS['strDbUpgradeIntro'] = "Naslednja podatkovna baza je bila zaznana za namestitev {$PRODUCT_NAME}.
                                                   Prosimo, preverite, ali so podatki pravilni, nato kliknite 'Nadaljuj', da nadaljujete.";
$GLOBALS['strDbProgressMessageInstall'] = 'Nameščanje podatkovne baze...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'Nadgrajevanje podatkovne baze...';
$GLOBALS['strDbSeeMoreFields'] = 'Prikažite več polj podatkovne baze...';
$GLOBALS['strDbTimeZoneWarning'] = "<p>Od te različice {$PRODUCT_NAME} shranjuje datume v UTC času namesto v času strežnika.</p>
                                                   <p>Če želite, da se zgodovinske statistike prikažejo s pravilnim časovnim pasom, ročno nadgradite svoje podatke.
Več o tem preberite <a target='help' href='%s'>tukaj</a>.
                                                   Vaše vrednosti statistike bodo ostale natančne, tudi če svojih podatkov ne spremenite.
                                                   </p>";
$GLOBALS['strDbTimeZoneNoWarnings'] = "Ne prikazuj opozoril glede časovnega pasu v prihodnje";
$GLOBALS['strDBInstallSuccess'] = "Podatkovna baza uspešno ustvarjena";
$GLOBALS['strDBUpgradeSuccess'] = "Podatkovna baza uspešno nadgrajena";

$GLOBALS['strDetectedVersion'] = "Zaznana {$PRODUCT_NAME} verzija";

/** config step * */
$GLOBALS['strConfigureInstallTitle'] = "Konfigurirajte lokalni račun {$PRODUCT_NAME} sistemskega skrbnika";
$GLOBALS['strConfigureInstallIntro'] = "Prosimo, zagotovite želene prijavne podatke za vaš lokalni račun {$PRODUCT_NAME} sistemskega skrbnika.";
$GLOBALS['strConfigureUpgradeTitle'] = "Nastavitve konfiguracije";
$GLOBALS['strConfigureUpgradeIntro'] = "Zagotovite pot do vaše prejšnje namestitve {$PRODUCT_NAME}.";
$GLOBALS['strPreviousInstallTitle'] = "Prejšnja namestitev";
$GLOBALS['strPathToPrevious'] = "Pot do vaše prejšnje namestitve {$PRODUCT_NAME}";

/** jobs step * */


/** finish step * */

$GLOBALS['strUnableCreateConfFile'] = "Vaša konfiguracijska datoteka ni bila ustvarjena. Prosimo, preverite dovoljenja {$PRODUCT_NAME} v var mapi.";
$GLOBALS['strUnableUpdateConfFile'] = "Vaša konfiguracijska datoteka ni bila posodobljena. Prosimo, preverite dovoljenja {$PRODUCT_NAME} v var mapi, kakor tudi dovoljenja prejšnje namestitve konfiguracijske datoteke, ki ste jo kopirali v to mapo.";
