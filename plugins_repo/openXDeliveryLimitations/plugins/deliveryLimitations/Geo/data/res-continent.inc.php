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

global $OA_Geo_continent, $OA_Geo_cont_name;

$OA_Geo_continent = array(
	"AP" => "AS", "EU" => "EU", "AD" => "EU", "AE" => "AS", "AF" => "AS",
	"AG" => "NA", "AI" => "NA", "AL" => "EU", "AM" => "AS", "CW" => "NA",
	"AO" => "AF", "AQ" => "AN", "AR" => "SA", "AS" => "OC", "AT" => "EU",
	"AU" => "OC", "AW" => "NA", "AZ" => "AS", "BA" => "EU", "BB" => "NA",
	"BD" => "AS", "BE" => "EU", "BF" => "AF", "BG" => "EU", "BH" => "AS",
	"BI" => "AF", "BJ" => "AF", "BM" => "NA", "BN" => "AS", "BO" => "SA",
	"BR" => "SA", "BS" => "NA", "BT" => "AS", "BV" => "AN", "BW" => "AF",
	"BY" => "EU", "BZ" => "NA", "CA" => "NA", "CC" => "AS", "CD" => "AF",
	"CF" => "AF", "CG" => "AF", "CH" => "EU", "CI" => "AF", "CK" => "OC",
	"CL" => "SA", "CM" => "AF", "CN" => "AS", "CO" => "SA", "CR" => "NA",
	"CU" => "NA", "CV" => "AF", "CX" => "AS", "CY" => "AS", "CZ" => "EU",
	"DE" => "EU", "DJ" => "AF", "DK" => "EU", "DM" => "NA", "DO" => "NA",
	"DZ" => "AF", "EC" => "SA", "EE" => "EU", "EG" => "AF", "EH" => "AF",
	"ER" => "AF", "ES" => "EU", "ET" => "AF", "FI" => "EU", "FJ" => "OC",
	"FK" => "SA", "FM" => "OC", "FO" => "EU", "FR" => "EU", "SX" => "NA",
	"GA" => "AF", "GB" => "EU", "GD" => "NA", "GE" => "AS", "GF" => "SA",
	"GH" => "AF", "GI" => "EU", "GL" => "NA", "GM" => "AF", "GN" => "AF",
	"GP" => "NA", "GQ" => "AF", "GR" => "EU", "GS" => "AN", "GT" => "NA",
	"GU" => "OC", "GW" => "AF", "GY" => "SA", "HK" => "AS", "HM" => "AN",
	"HN" => "NA", "HR" => "EU", "HT" => "NA", "HU" => "EU", "ID" => "AS",
	"IE" => "EU", "IL" => "AS", "IN" => "AS", "IO" => "AS", "IQ" => "AS",
	"IR" => "AS", "IS" => "EU", "IT" => "EU", "JM" => "NA", "JO" => "AS",
	"JP" => "AS", "KE" => "AF", "KG" => "AS", "KH" => "AS", "KI" => "OC",
	"KM" => "AF", "KN" => "NA", "KP" => "AS", "KR" => "AS", "KW" => "AS",
	"KY" => "NA", "KZ" => "AS", "LA" => "AS", "LB" => "AS", "LC" => "NA",
	"LI" => "EU", "LK" => "AS", "LR" => "AF", "LS" => "AF", "LT" => "EU",
	"LU" => "EU", "LV" => "EU", "LY" => "AF", "MA" => "AF", "MC" => "EU",
	"MD" => "EU", "MG" => "AF", "MH" => "OC", "MK" => "EU", "ML" => "AF",
	"MM" => "AS", "MN" => "AS", "MO" => "AS", "MP" => "OC", "MQ" => "NA",
	"MR" => "AF", "MS" => "NA", "MT" => "EU", "MU" => "AF", "MV" => "AS",
	"MW" => "AF", "MX" => "NA", "MY" => "AS", "MZ" => "AF", "NA" => "AF",
	"NC" => "OC", "NE" => "AF", "NF" => "OC", "NG" => "AF", "NI" => "NA",
	"NL" => "EU", "NO" => "EU", "NP" => "AS", "NR" => "OC", "NU" => "OC",
	"NZ" => "OC", "OM" => "AS", "PA" => "NA", "PE" => "SA", "PF" => "OC",
	"PG" => "OC", "PH" => "AS", "PK" => "AS", "PL" => "EU", "PM" => "NA",
	"PN" => "OC", "PR" => "NA", "PS" => "AS", "PT" => "EU", "PW" => "OC",
	"PY" => "SA", "QA" => "AS", "RE" => "AF", "RO" => "EU", "RU" => "EU",
	"RW" => "AF", "SA" => "AS", "SB" => "OC", "SC" => "AF", "SD" => "AF",
	"SE" => "EU", "SG" => "AS", "SH" => "AF", "SI" => "EU", "SJ" => "EU",
	"SK" => "EU", "SL" => "AF", "SM" => "EU", "SN" => "AF", "SO" => "AF",
	"SR" => "SA", "ST" => "AF", "SV" => "NA", "SY" => "AS", "SZ" => "AF",
	"TC" => "NA", "TD" => "AF", "TF" => "AN", "TG" => "AF", "TH" => "AS",
	"TJ" => "AS", "TK" => "OC", "TM" => "AS", "TN" => "AF", "TO" => "OC",
	"TL" => "AS", "TR" => "EU", "TT" => "NA", "TV" => "OC", "TW" => "AS",
	"TZ" => "AF", "UA" => "EU", "UG" => "AF", "UM" => "OC", "US" => "NA",
	"UY" => "SA", "UZ" => "AS", "VA" => "EU", "VC" => "NA", "VE" => "SA",
	"VG" => "NA", "VI" => "NA", "VN" => "AS", "VU" => "OC", "WF" => "OC",
	"WS" => "OC", "YE" => "AS", "YT" => "AF", "RS" => "EU", "ZA" => "AF",
	"ZM" => "AF", "ME" => "EU", "ZW" => "AF", "AX" => "EU", "GG" => "EU",
	"IM" => "EU", "JE" => "EU", "BL" => "NA", "MF" => "NA", "BQ" => "NA",
	"SS" => "AF",
);

$OA_Geo_cont_name = array(
    'AF' => 'Africa',
    'AQ' => 'Antartica',
    'AS' => 'Asia',
    'CA' => 'Caribbean',
    'EU' => 'Europe',
    'NA' => 'North America',
    'OC' => 'Australia/Oceania',
    'SA' => 'South America',
);

?>