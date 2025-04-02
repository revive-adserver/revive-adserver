// ** I18N

// Calendar SK language
// Author: Peter Valach (pvalach@gmx.net)
// Encoding: UTF-8
// Last update: 2003/10/29
// Distributed under the same terms as the calendar itself.

// full day names
Calendar._DN = new Array
("Nedeľa",
 "Pondelok",
 "Utorok",
 "Streda",
 "Ĺtvrtok",
 "Piatok",
 "Sobota",
 "Nedeľa");

// short day names
Calendar._SDN = new Array
("Ned",
 "Pon",
 "Uto",
 "Str",
 "Ĺtv",
 "Pia",
 "Sob",
 "Ned");

// full month names
Calendar._MN = new Array
("Január",
 "Február",
 "Marec",
 "Apríl",
 "Máj",
 "Jún",
 "Júl",
 "August",
 "September",
 "OktĂłber",
 "November",
 "December");

// short month names
Calendar._SMN = new Array
("Jan",
 "Feb",
 "Mar",
 "Apr",
 "Máj",
 "Jún",
 "Júl",
 "Aug",
 "Sep",
 "Okt",
 "Nov",
 "Dec");

// tooltips
Calendar._TT = {};
Calendar._TT["INFO"] = "O kalendári";

Calendar._TT["ABOUT"] =
"DHTML Date/Time Selector\n" +
"(c) dynarch.com 2002-2005 / Author: Mihai Bazon\n" +
"Poslednú verziu nájdete na: http://www.dynarch.com/projects/calendar/\n" +
"Distribuované pod GNU LGPL.  ViÄŹ http://gnu.org/licenses/lgpl.html pre detaily." +
"\n\n" +
"Výber dátumu:\n" +
"- Použite tlačidlá \xab, \xbb pre výber roku\n" +
"- Použite tlačidlá " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " pre výber mesiaca\n" +
"- Ak ktorékoľvek z týchto tlačidiel podržíte dlhšie, zobrazí sa rýchly výber.";
Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Výber času:\n" +
"- Kliknutie na niektorú položku času ju zvýši\n" +
"- Shift-klik ju zníži\n" +
"- Ak podržíte tlačítko stlačené, posúvaním meníte hodnotu.";

Calendar._TT["PREV_YEAR"] = "Predošlý rok (podržte pre menu)";
Calendar._TT["PREV_MONTH"] = "Predošlý mesiac (podržte pre menu)";
Calendar._TT["GO_TODAY"] = "Prejsť na dnešok";
Calendar._TT["NEXT_MONTH"] = "Nasl. mesiac (podržte pre menu)";
Calendar._TT["NEXT_YEAR"] = "Nasl. rok (podržte pre menu)";
Calendar._TT["SEL_DATE"] = "Zvoľte dátum";
Calendar._TT["DRAG_TO_MOVE"] = "Podržaním tlačítka zmeníte polohu";
Calendar._TT["PART_TODAY"] = " (dnes)";
Calendar._TT["MON_FIRST"] = "Zobraziť pondelok ako prvý";
Calendar._TT["SUN_FIRST"] = "Zobraziť nedeľu ako prvú";
Calendar._TT["CLOSE"] = "Zavrieť";
Calendar._TT["TODAY"] = "Dnes";
Calendar._TT["TIME_PART"] = "(Shift-)klik/ťahanie zmení hodnotu";

// date formats
Calendar._TT["DEF_DATE_FORMAT"] = "$d. %m. %Y";
Calendar._TT["TT_DATE_FORMAT"] = "%a, %e. %b";

Calendar._TT["WK"] = "týž";
