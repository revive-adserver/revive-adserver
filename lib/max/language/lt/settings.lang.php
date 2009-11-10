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
$GLOBALS['strInventory'] = "Inventorius";
$GLOBALS['strBasicInformation'] = "Pradinė informacija";
$GLOBALS['strWarning'] = "Perspėjimas";
$GLOBALS['strTypeFTPUsername'] = "Prisijungti";
$GLOBALS['strTypeFTPPassword'] = "Slaptažodis";
$GLOBALS['strHasTaxID'] = "Mokesčių ID";
$GLOBALS['strStatisticsDefaults'] = "Statistika";
$GLOBALS['strGeneralSettings'] = "Bendri nustatymai";
$GLOBALS['strAdminSettings'] = "Administratoriaus nustatymai";
$GLOBALS['strAdministratorSettings'] = "Administratoriaus nustatymai";
$GLOBALS['strChooseSection'] = "Pasirinkti dalį";
$GLOBALS['strInstall'] = "Įdiegti";
$GLOBALS['strLanguageSelection'] = "Kalbos pasirinkimas";
$GLOBALS['strDatabaseSettings'] = "Duomenų bazės nustatymai";
$GLOBALS['strAdminAccount'] = "Administratoriaus sąskaita";
$GLOBALS['strAdvancedSettings'] = "Papildomi nustatymai";
$GLOBALS['strSpecifySyncSettings'] = "Sinchronizacijos nustatymai";
$GLOBALS['strOpenadsIdYour'] = "Jūsų OpenX ID";
$GLOBALS['strOpenadsIdSettings'] = "OpenX ID nustatymai";
$GLOBALS['strBtnContinue'] = "Tęsti »";
$GLOBALS['strBtnRecover'] = "Atnaujinti »";
$GLOBALS['strBtnStartAgain'] = "Pradėti iš naujo atnaujinimų siuntimą »";
$GLOBALS['strBtnGoBack'] = "« Grįžti";
$GLOBALS['strBtnAgree'] = "Aš sutinku »";
$GLOBALS['strBtnDontAgree'] = "« Aš nesutinku";
$GLOBALS['strBtnRetry'] = "Bandyti dar kartą";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Prašome ištaisyti visas klaidas priš tesiąnt.";
$GLOBALS['strWarningRegisterArgcArv'] = " PHP registracijos konfigūracija _argc_argv turi būti įjungta, tam kad būtų paleistas aptarnavimo komanda.";
$GLOBALS['strTablesPrefix'] = "Lentelių pavadinimų priešdelis";
$GLOBALS['strTablesType'] = "Lentelės tipas";
$GLOBALS['strRecoveryRequiredTitle'] = "Jūsų pastarasis bandymas buvo su klaida";
$GLOBALS['strPolicyTitle'] = "Privatumo politika";
$GLOBALS['strPolicyIntro'] = "Prašome perskaityti ir sutikti su šio dokumento sąlygomis jei norite tęsti įdiegimą.";
$GLOBALS['strDbSetupTitle'] = "Duomenų bazės nustatymai";
$GLOBALS['strOaUpToDateCantRemove'] = "Įspėjimas: Atnaujinimo failas vis dar yra Jūsų var aplanke. Mes negalime pašalinti šio failo dėl tam tikrų prieigos draudimų. Prašome ištrinkite šį failą patys.";
$GLOBALS['strRemoveUpgradeFile'] = "Jūs privalote pašalinti UPGRADE failą iš var aplanko.";
$GLOBALS['strSystemCheck'] = "Sistemos patikrinimas ";
$GLOBALS['strSystemCheckIntro'] = "Įdiegimo meistras tikrina Jūsų serverio nustatymus, tam kad būtų užtikrinta, jog įdiegimo procesas bus sėkmingas. <p> Prašome patikrinkite visus paryškintus laukus, tam kad užbaigtumėte įdiegimo procesą. </p>";
$GLOBALS['strDbSuccessIntroUpgrade'] = "Jūsų sistema buvo sėkmingai atnaujinta. Rodomi langai padės Jums atnaujinti naujo serverio konfigūraciją. ";
$GLOBALS['strErrorWritePermissions'] = "Aptiktos failo leidimų klaidos, jos turibūti ištaisytos prieš tęsiant. <br/> Tam kad pataisytumėte klaidas Linux sistemoje, pabandykite įvesti sekančias komandas:";
$GLOBALS['strErrorWritePermissionsWin'] = "Rasta failo leidimo klaidų ir jos turi būti pataisytos prieš tęsiant. ";
$GLOBALS['strAdminUrlPrefix'] = "Administartoriaus sąsaja su URL";
$GLOBALS['strDeliveryUrlPrefix'] = "Pristatymo variklio URL";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Pristatymo variklio URL (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "Vaizdų išsaugojimo URL";
$GLOBALS['strImagesUrlPrefixSSL'] = "Vaizdų išsaugojimo URL (SSL)";
$GLOBALS['strEditConfigNotPossible'] = "Neįmanoma redaguoti visų funkcijų, nes konfigūracijos failas dėl saugumo priežasčių yra užrakintas. Jei norite daryti pakeitimus, jums reikia atrakinti konfigūracijos failą šiam įdiegimui pirmiausia.";
$GLOBALS['strEditConfigPossible'] = "Įmanoma redaguoti visus konfigūracijos failus, bet taip gali būti pažeistas failų saugumas. Jei norite apsaugoti savo sistema nuo šių pažridimų, šio įdiegimo metu užrakinkite konfigūracijos failą. ";
$GLOBALS['strUnableToWriteConfig'] = "Neįmano įrašyti pakeitimų į šiuos konfigūracijos failus";
$GLOBALS['strUnableToWritePrefs'] = "Neįmanoma nustatyti pirmenybių duomenų bazėje";
$GLOBALS['strImageDirLockedDetected'] = "Pateiktas <b>Paveikslėlių aplankas</b> nėra įrašomas per serverį. <br> Jūs negalite tęsti kol nepakeitėte aplankų galimų leidimų arba nesukūrėte naujo aplanko.";
$GLOBALS['strConfigurationSetup'] = "Konfigūracijos patikrinimo sąrašas";
$GLOBALS['strConfigurationSettings'] = "Konfigūracijos nustatymai";
$GLOBALS['strLoginCredentials'] = "Prisijungimo Credentials";
$GLOBALS['strAdminUsername'] = "Administratoriaus vartotojo avrdas";
$GLOBALS['strAdminPassword'] = "Administratoriaus slaptažodis";
$GLOBALS['strInvalidUsername'] = "Netinkamas vartotojo vardas";
$GLOBALS['strAdminFullName'] = "Administratoriaus pilnas vardas";
$GLOBALS['strAdminEmail'] = "Administratoriaus el. pašto adresas";
$GLOBALS['strAdministratorEmail'] = "Administratoriaus el.pašto adresas";
$GLOBALS['strCompanyName'] = "Įmonės pavadinimas";
$GLOBALS['strUserlogEmail'] = "Įrašyti visas išsiunčiamas elektroninio pašto žinutes";
$GLOBALS['strTimezone'] = "Laiko zona";
$GLOBALS['strTimezoneEstimated'] = "Apytikslė laiko zona";
$GLOBALS['strTimezoneGuessedValue'] = "Serverio laikas nustatytas neteisingai PHP ";
$GLOBALS['strTimezoneSeeDocs'] = "Prašome pažiūrėti %DOCS% apie nustatant šiuos kintamuosius, skirtus PHP.";
$GLOBALS['strTimezoneDocumentation'] = "Dokumentacija";
$GLOBALS['strLoginSettingsTitle'] = "Administratoriaus prisijungimas";
$GLOBALS['strAdminSettingsTitle'] = "Sukurkite administratoriaus sąskaita";
$GLOBALS['strAdminSettingsIntro'] = "Prašome užpildyti šią formą jei pageidaujate sukurti ad serverio administratoriaus sąskaitą.";
$GLOBALS['strEnableAutoMaintenance'] = "Automatiškai atlikite aptarnavimo darbus per pristatymą jei nėra pagal grafiką sudarytų aptarvimų darbų sąrašo";
$GLOBALS['strDatabaseServer'] = "Pasauliniai duomenų bazės serverio nustatymai";
$GLOBALS['strDbType'] = "Duomenų bazės tipas";
$GLOBALS['strDbHost'] = "Duomenų bazės Hostname";
$GLOBALS['strDbPort'] = "Duomenų bazės jungties numeris";
$GLOBALS['strDbUser'] = "Duomenų bazės vartotojo vardas";
$GLOBALS['strDbPassword'] = "Duomenų bazės slaptažodis";
$GLOBALS['strDbName'] = "Duomenų bazės pavadinimas";
$GLOBALS['strDatabaseOptimalisations'] = "Duomenų bazės optimizavimo nustatymai";
$GLOBALS['strPersistentConnections'] = "Naudokite nuolaitines jungtis";
$GLOBALS['strCantConnectToDb'] = "Neiįmanoma susjungti su duomenų baze";
$GLOBALS['strDemoDataInstall'] = "Įdiekite demo duomenis ";
$GLOBALS['strDebug'] = "Suderinti prisijungimo nustatymus";
$GLOBALS['strProduction'] = "Produkcijos serveris";
$GLOBALS['strEnableDebug'] = "Įgalinti prisijungimo suderinimą";
$GLOBALS['strDebugMethodNames'] = "Įterpti metodinius vardus suderinant prisijungimą";
$GLOBALS['strDebugLineNumbers'] = "įterpti linijų numerius derinant prisijungimą";
$GLOBALS['strDebugType'] = "Suderinti prisijungimo tipą";
$GLOBALS['strDebugTypeFile'] = "Failas";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "SQL duomenų bazė";
$GLOBALS['strDebugTypeSyslog'] = "Sistemos registras";
$GLOBALS['strDebugName'] = "Suderinti Prisijungimo vardą, Kalendarių, SQL lentelę,<br />arba Syslog Facility";
$GLOBALS['strDebugPriority'] = "Suderinti pirmenybinį lygį ";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Dauguma informacijos";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Pagrindinė informacija";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_PRIMINIMAS";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_ĮSPĖJIMAS";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_KLAIDA";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_PAVOJUS";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Mažiausiai informacijos";
$GLOBALS['strDebugIdent'] = "Suderinti identifikacijos grandinę";
$GLOBALS['strDebugUsername'] = "mCal, SQL serverio vartotojo vardas";
$GLOBALS['strDebugPassword'] = "mCal, SQL serverio slaptažodis";
$GLOBALS['strDeliverySettings'] = "Pristatymo nustatymai";
$GLOBALS['strWebPathSimple'] = "Web kelias";
$GLOBALS['strDeliveryPath'] = "Pristatymo kelias";
$GLOBALS['strImagePath'] = "Vaizdų kelias";
$GLOBALS['strDeliverySslPath'] = "SSL pristatymo kelias";
$GLOBALS['strImageSslPath'] = "SSL vaizdų kelias";
$GLOBALS['strImageStore'] = "Vaizdų aplankai";
$GLOBALS['strTypeWebSettings'] = "Web serverių ir vietinių banerių išsaugojimo nustatymai";
$GLOBALS['strTypeWebMode'] = "Išsaugojimo metodas";
$GLOBALS['strTypeWebModeLocal'] = "Vietinis katalogas";
$GLOBALS['strTypeWebDir'] = "Vietinis katalogas";
$GLOBALS['strTypeDirError'] = "Vietinis katalogas negali būti įrašytas per we serverį";
$GLOBALS['strTypeWebModeFtp'] = "Išorinis FTP serveris";
$GLOBALS['strTypeFTPHost'] = "FTP Hostingas";
$GLOBALS['strTypeFTPDirectory'] = "Hostingo aplankas";
$GLOBALS['strTypeFTPPassive'] = "Naudoti pasyvų FTP";
$GLOBALS['strTypeFTPErrorDir'] = "FTP hostingo aplankas neegiztuoja";
$GLOBALS['strTypeFTPErrorConnect'] = "Neįmanoma prisijungti prie FTP serverio, prisijungimo vardas arba slaptažodis neteisingi";
$GLOBALS['strTypeFTPErrorHost'] = "FTP hostingas neteisingas";
$GLOBALS['strDeliveryFilenames'] = "Pristatymo failų vardai";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Ad paspaudimas";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Ad konvertavimo kintamuosius";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Ad turinys";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Ad konvertacija";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Ad konvertacija (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Ad rėmeliai";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Ad paveikslėlis";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Ad (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Ad lygmuo";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Ad registras";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Ad Popup";
$GLOBALS['strDeliveryFilenamesAdView'] = "Ad rodymas";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "XML RPC kreipimasis";
$GLOBALS['strDeliveryFilenamesLocal'] = "Vietinis kreipimasis";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Priekinis tikrintojas";
$GLOBALS['strDeliveryFilenamesFlash'] = "Pridėti Flash (gali būti pilnas URL)";
$GLOBALS['strDeliveryCaching'] = "Banerio pristatymo kelio nustatymai";
$GLOBALS['strDeliveryCacheLimit'] = "Laikas ";
$GLOBALS['strOrigin'] = "Naudoti nuotolini ";
$GLOBALS['strOriginType'] = "Pirminis serverio tipas";
$GLOBALS['strOriginHost'] = "Pavadinimas pirminiam serveriui";
$GLOBALS['strOriginPort'] = "Stoties numeris pirminiai duomenų bazei";
$GLOBALS['strOriginScript'] = "Rašto failas, skirtas originaliai duomenų bazei";
$GLOBALS['strOriginTypeXMLRPC'] = "XMLRPC";
$GLOBALS['strOriginTimeout'] = "Minutinės pertraukos atsiradimas (sekundėmis)";
$GLOBALS['strOriginProtocol'] = "Serverio protokolo atsiradimas";
$GLOBALS['strDeliveryAcls'] = "Nustatyti banerio pristatymo limitus per patį pristatymą";
$GLOBALS['strDeliveryObfuscate'] = "Užtamsyti kanalą, kai pridedamas pristatymas";
$GLOBALS['strDeliveryExecPhp'] = "Leisti PHP kodui, kai pridedamas būti pašalintam<br />(Įspėjimas: Security risk)";
$GLOBALS['strDeliveryCtDelimiter'] = "Trečiosios šalies paspaudimų seklio delimiter";
$GLOBALS['strP3PSettings'] = "P3P privatumo politika";
$GLOBALS['strUseP3P'] = "Naudoti P3P politiką";
$GLOBALS['strP3PCompactPolicy'] = "P3P susitarimo politika";
$GLOBALS['strP3PPolicyLocation'] = "P3P vietos politika";
$GLOBALS['strGeotargetingSettings'] = "Geotargeting nustatymai";
$GLOBALS['strGeotargeting'] = "Geotargeting nustatymai";
$GLOBALS['strGeotargetingType'] = "Geotargeting modulio tipas";
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "MaxMind GeoIP šalies duomenų bazės vieta";
$GLOBALS['strGeotargetingGeoipRegionLocation'] = "MaxMind GeoIP regiono duomenų bazės vieta";
$GLOBALS['strGeotargetingGeoipCityLocation'] = "MaxMind GeoIP miesto duomenų bazės vieta";
$GLOBALS['strGeotargetingGeoipAreaLocation'] = "MaxMind GeoIP ploto duomenų bazės vieta";
$GLOBALS['strGeotargetingGeoipDmaLocation'] = "MaxMind GeoIP DMA duomenų bazės vieta";
$GLOBALS['strGeotargetingGeoipOrgLocation'] = "MaxMind GeoIP organizacijos duomenų bazės vieta";
$GLOBALS['strGeotargetingGeoipIspLocation'] = "MaxMind GeoIP ISP duomenų bazės vieta ";
$GLOBALS['strGeotargetingGeoipNetspeedLocation'] = "MaxMind GeoIP naršyklės duomenų bazės vieta ";
$GLOBALS['strGeoShowUnavailable'] = "Rodyti geotargeting pristatymo limitus net jei GeoIP duomenys negalimi";
$GLOBALS['strGeotrackingGeoipCountryLocationError'] = "MaxMind GeoIP šalies duomenų bazė neegzistuoja nurodytoje vietoje";
$GLOBALS['strGeotrackingGeoipRegionLocationError'] = "MaxMind GeoIP regiono duomenų bazė neegzistuoja nurodytoje vietoje";
$GLOBALS['strGeotrackingGeoipCityLocationError'] = "MaxMind GeoIP miesto duomenų bazė neegzistuoja nurodytoje vietoje";
$GLOBALS['strGeotrackingGeoipAreaLocationError'] = "MaxMind GeoIP ploto duomenų bazė neegzistuoja nurodytoje vietoje";
$GLOBALS['strGeotrackingGeoipDmaLocationError'] = "MaxMind GeoIP DMA duomenų bazė neegzistuoja nurodytoje vietoje";
$GLOBALS['strGeotrackingGeoipOrgLocationError'] = "MaxMind GeoIP organizacijos duomenų bazė neegzistuoja nurodytoje vietoje";
$GLOBALS['strGeotrackingGeoipIspLocationError'] = "MaxMind GeoIP ISP duomenų bazė neegzistuoja nurodytoje vietoje";
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = "MaxMind GeoIP Netspeed duomenų bazė neegzistuoja nurodytoje vietoje";
$GLOBALS['strShowBannerHTML'] = "Rodyti banerį vietoj HTML kodo per HTML banerio peržiūrą";
$GLOBALS['strShowBannerPreview'] = "Rodyti banerio peržiūrą, puslapių viršuje, tuose puslapiuose, kurie naudojami baneriams";
$GLOBALS['strGUIShowMatchingBanners'] = "rodyti sutampančius banerius <i> Susieti baneriai</i> puspaliuose";
$GLOBALS['strGUIShowParentCampaigns'] = "Rodyti pirminias kampanijas per <i> Susieti  baneriai </i> puslapius";
$GLOBALS['strGUIAnonymousCampaignsByDefault'] = "Pagrindinės kampanijos, skirtos anonimams";
$GLOBALS['strBeginOfWeek'] = "Savaitės pradžia";
$GLOBALS['strPercentageDecimals'] = "Dešimtainė procento dalis";
$GLOBALS['strWeightDefaults'] = "Pagrindinis svoris";
$GLOBALS['strDefaultBannerWeight'] = "Pagrindinis banerio svoris";
$GLOBALS['strDefaultCampaignWeight'] = "Pagrindinis kampanijos svoris";
$GLOBALS['strPublisherDefaults'] = "Intertinio puslapio pirminiai nustatymai";
$GLOBALS['strModesOfPayment'] = "Apmokėjimo modeliai";
$GLOBALS['strCurrencies'] = "Valiutos";
$GLOBALS['strCategories'] = "Kategorijos";
$GLOBALS['strHelpFiles'] = "pagalbos failai";
$GLOBALS['strDefaultApproved'] = "Patvirtinta patikrinimo dėžutė";
$GLOBALS['strAllowedInvocationTypes'] = "Leistini kreipimosi tipai";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Įgalinti trečiosios šalies paspaudimų sekimą per pagrindinius nustatymus";
$GLOBALS['strCsvImport'] = "Leisti užkrauti offline konvertaciją";
$GLOBALS['strLogAdRequests'] = "Įregistruoti prašymą kiekvieną kartą kai prašomas baneris";
$GLOBALS['strLogAdImpressions'] = "Įregistruoti įspūdį kiekvieną kartą kai baneris peržiūrimas";
$GLOBALS['strLogAdClicks'] = "Įregistruoti paspaudimus kiekvieną kartą kai vartotojas paspaudžia ant banerio";
$GLOBALS['strLogTrackerImpressions'] = "Įregistruoti agento įpūdį kiekvieną kartą kai agento ženklas yra peržiūrimas";
$GLOBALS['strReverseLookup'] = "Pakeisti peržiūrinėjimo pavadinimus kai jie nepateikiami";
$GLOBALS['strProxyLookup'] = "Bandyti nustatyti tikrąjį IP adresą vartotojų besijungiančių per proxy serverį";
$GLOBALS['strPreventLogging'] = "Blokuoti  banerio prisijungimo nustatymus";
$GLOBALS['strIgnoreHosts'] = "Neišsaugokite jokios žemiau nurodytų vartotojų statistikos pagal nurodytus IP adresus arba pavadinimus";
$GLOBALS['strBlockAdViews'] = "Neskaičiuokite pridėtų įspūdžių jei peržiūrėtojas matė tą pačią zonos porą per tam tikrą laiką (sekundės)";
$GLOBALS['strBlockAdViewsError'] = "Įspūdžio blokuojama reikšmė turi būti teigiamas sveikasis skaičius";
$GLOBALS['strBlockAdClicks'] = "Neskaičiuoti paspaudimų jei peržiūrėtojas paspaudė ant tos pačios zonos poros per tam tikrą laiką (sekundės)";
$GLOBALS['strBlockAdClicksError'] = "Paspaudimų skaičiaus pridėjimo blokuojama reikšmė turi būti teigiamas sveikasis skaičius";
$GLOBALS['strMaintenanceOI'] = "Techninio aptarnavimo intervalas (minutės)";
$GLOBALS['strMaintenanceOIError'] = "Techninio aptarnavimo intervalas negaliojantis - žiūrėkite dokumentaciją tinkamoms reikšmėms";
$GLOBALS['strPrioritySettings'] = "Pirmenybės nustatymai";
$GLOBALS['strPriorityInstantUpdate'] = "Atnaujinti reklamos pirmenybės iš karto kai tik atliekami bet kokie UI pasikeitimai";
$GLOBALS['strDefaultImpConWindow'] = "Pagrindinis įspūdžių/nuomonių prisijungimo langas (sekundės)";
$GLOBALS['strDefaultImpConWindowError'] = "Jei nustatyta pagrindinis įspūdžių prisijungimo langas turi būti teigiamas sveikasis skaičius ";
$GLOBALS['strDefaultCliConWindow'] = "Pagrindinis Ad paspaudimų prisijungimo langas (sekundėmis)";
$GLOBALS['strDefaultCliConWindowError'] = "Jei nustatyta pagrindinis įspūdžių prisijungimo langas turi būti teigiamas sveikasis skaičius ";
$GLOBALS['strWarnLimit'] = "Išsiųsti įspėjimą kai įspūdžių/nuomonių skaičius yra mažesnis nei nurodyta čia";
$GLOBALS['strWarnLimitErr'] = "Įspėjimo limitas turi būti teigiamas sveikasis skaičius";
$GLOBALS['strWarnLimitDays'] = "Siųsti įspėjimą kai likę dienų mažiau nei nurodyta čia";
$GLOBALS['strWarnLimitDaysErr'] = "Įspėjimo dienų skaičius turi būti teigiamas skaičius";
$GLOBALS['strWarnAdmin'] = "Išsiųsti įspėjimą administratoriui kiekvieną kartą kai kampanijos galiojimo laikas beveik pasibaigė";
$GLOBALS['strWarnClient'] = "Išsiųsti įspėjimą reklamuotojui kiekvieną kartą kai kampanijos galiojimo laikas beveik pasibaigė";
$GLOBALS['strWarnAgency'] = "Išsiųsti įspėjimą agentūrai kiekvieną kartą kai kampanijos galiojimo laikas beveik pasibaigė";
$GLOBALS['strEnableQmailPatch'] = "Įgalinti pašto taisymą";
$GLOBALS['strGuiSettings'] = "Vartotojo sąsajų nustatymai ";
$GLOBALS['strAppName'] = "Prašymo pavadinimas";
$GLOBALS['strMyHeader'] = "Antraštės failo vieta";
$GLOBALS['strMyHeaderError'] = "Antraštės failas neegzistuoja toje vietoje, kurią nurodėte";
$GLOBALS['strMyFooter'] = "Paraštės  failo vieta";
$GLOBALS['strMyFooterError'] = "Paraštės failas neegzistuoja toje vietoje, kurią nurodėte";
$GLOBALS['strDefaultTrackerStatus'] = "Pagrindinis agento statusas";
$GLOBALS['strDefaultTrackerType'] = "Pagrindinis agento tipas";
$GLOBALS['strMyLogo'] = "Įprasto logo failo vardas";
$GLOBALS['strMyLogoError'] = "Logo failas administratoriaus/vaizdų aplanke neegzistuoja";
$GLOBALS['strGuiHeaderForegroundColor'] = "Antraštės pirminė spalva";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Antraštės fono spalva";
$GLOBALS['strGuiActiveTabColor'] = "Aktyvios pozicijos spalva";
$GLOBALS['strGuiHeaderTextColor'] = "Teksto antraštėje spalva";
$GLOBALS['strColorError'] = "Prašome įvesti spalvas RGB formatu, pvz '0066CC'";
$GLOBALS['strGzipContentCompression'] = "Naudokite GZIP turinio suspaudimo programą";
$GLOBALS['strClientInterface'] = "Reklamuotojo sandūra";
$GLOBALS['strReportsInterface'] = "Sąssajų ataskaitos";
$GLOBALS['strClientWelcomeEnabled'] = "Įgalinti reklamuotojo pasveikinimo žinutę";
$GLOBALS['strClientWelcomeText'] = "Pasveikinimo tekstas<br />(HTML Tags leistini)";
$GLOBALS['strPublisherInterface'] = "Internetinių puslapių sąsajos";
$GLOBALS['strPublisherAgreementEnabled'] = "Įgalinti prisijungimą prie internetinių puslapių, kurie sutiko su taisyklėmis ir nuostatomis ";
$GLOBALS['strPublisherAgreementText'] = "Prisijungimo tekstas (HTML tags leistini)";
$GLOBALS['strNovice'] = "Ištrinimo veiksmai reikalaujami dėl saugumo tikslų";
$GLOBALS['strEmailSettings'] = "El. pašto nustatymai";
$GLOBALS['strEmailHeader'] = "El. pašto antraštė";
$GLOBALS['strEmailLog'] = "El. pašto registras";
$GLOBALS['strAuditTrailSettings'] = "Audit trail nustatymai";
$GLOBALS['strEnableAudit'] = "Įgalinti Audit trail";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Jūsų PHP instaliacija nepalaiko Jūsų FTP";
$GLOBALS['strGeotargetingUseBundledCountryDb'] = "Naudokite duomenų bazės MaxMind GeoLiteCountry paketą";
$GLOBALS['strConfirmationUI'] = "Vartotojo sąsajos patvirtinimas";
$GLOBALS['strBannerStorage'] = "Banerio išsaugojimo nustatymai";
$GLOBALS['strMaintenanceSettings'] = "Techninio aptarnavimo nustatymai";
$GLOBALS['strSSLSettings'] = "SSL nustatymai";
$GLOBALS['requireSSL'] = "Leisti SSL priėjimą vartotojo sąsajoje";
$GLOBALS['sslPort'] = "SSL sotis naudojama internetinio serverio";
$GLOBALS['strAllowEmail'] = "Leisti siųsti email pasauliniu lygiu";
$GLOBALS['strEmailAddressFrom'] = "El. pašto adresas siųsti ataskaitas IŠ";
$GLOBALS['strEmailAddressName'] = "Įmonės ar asmeninis vardas, kurį galima naudoti kaip el. laiškų paraštę";
$GLOBALS['strInvocationDefaults'] = "Pasveikinimų pagrindinės frazės";
$GLOBALS['strDbLocal'] = "Naudoti vietinę socket jungtį";
$GLOBALS['strDbSocket'] = "Duomenų bazės Socket";
$GLOBALS['strEmailAddresses'] = "El. paštas  el. pašto adresas";
$GLOBALS['strEmailFromAddress'] = "El. paštas  el. pašto adresas";
$GLOBALS['strIgnoreUserAgents'] = "<b>Neregistruokite</b> jokios statistikos iš klientų, kurie naudoja bent vieną iš šių strings savo user-agent dalyje (vienas per liniją)";
$GLOBALS['strEnforceUserAgents'] = "<b>Registruokite</b> tik tą statistiką iš klientų, kurie naudoja strings savo user-agent dalyje (vienas per liniją)";
$GLOBALS['strConversionTracking'] = "Agento konvertacijos nustatymai";
$GLOBALS['strEnableConversionTracking'] = "Įgalinti agento konvertaciją";
$GLOBALS['strBannerLogging'] = "Blokuoti  banerio prisijungimo nustatymus";
$GLOBALS['strBannerDelivery'] = "Banerio pristatymo kelio nustatymai";
$GLOBALS['strDefaultConversionStatus'] = "Pagrindininės konvertavimo taisyklės";
$GLOBALS['strDefaultConversionType'] = "Pagrindininės konvertavimo taisyklės";
?>