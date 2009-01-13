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
$GLOBALS['phpAds_hlp_company_name'] = "Acest nume este folosit în e-mail-ul trimis de ". MAX_PRODUCT_NAME .".";
$GLOBALS['phpAds_hlp_warn_client'] = "". MAX_PRODUCT_NAME ." poate trimite un e-mail advertiser-ului dacă una din campaniile sale are doar un";
$GLOBALS['phpAds_hlp_qmail_patch'] = "Unele versiuni de qmail sunt afectate de un bug, din cauza căruia e-mail-urile trimise de \n". MAX_PRODUCT_NAME ." afişează header-ele în interiorul conţinutului e-mail-ului. Dacă activezi \n această opţiune, ". MAX_PRODUCT_NAME ." va trimite e-mail-ul într-un format compatibil qmail.";
$GLOBALS['phpAds_hlp_warn_limit'] = "Limita la care ". MAX_PRODUCT_NAME ." va începe să trimită e-mail-uri de atenţionare. Aceasta este 100";
$GLOBALS['phpAds_hlp_admin_email'] = "Adresa de e-mail a adiministratorului. Aceasta este utilizată ca adresă de expediere când";
$GLOBALS['phpAds_hlp_admin_novice'] = "Dacă doreşti să primeşti o atenţionare înainte de a şterge advertiserii, campaniile, bannere-ele, website-urile şi zonele; setează aceasta opţiune cu valoarea adevărat.";
$GLOBALS['phpAds_hlp_gui_show_campaign_info'] = "Daca este activată aceasta opţiune vor fi afişate informaţii suplimentare despre fiecare campanie pe pagina de <i>Campanii</i>. Informaţiile suplimentare includ numărul de Vizualizări rămase, numărul de Click-uri rămase, numărul de Conversii rămase, data activării, data expirării şi setări de prioritate.";
$GLOBALS['phpAds_hlp_gui_show_banner_info'] = "Daca este activată această opţiune vor fi afişate informaţii suplimentare despre fiecare banner pe pagina de <i>Bannere</i>. Informaţiile suplimentare includ URL-ul destinaţie, cuvinte cheie, dimensiune şi importanţă banner.";
$GLOBALS['phpAds_hlp_gui_show_campaign_preview'] = "Daca este activată această opţiune vor fi afişate previzualizări ale tuturor banner-elor pe pagina de <i>Bannere</i>. Dacă aceasta opţiune este dezactivată este posibil să afişezi previzualizarea fiecărui banner prin click pe triunghiul din dreapta fiecărui banner de pe pagina de <i>Bannere</i>";
$GLOBALS['phpAds_hlp_gui_hide_inactive'] = "Daca este activată această opţiune toate banner-ele inactive, campaniile şi advertiserii vor fi ascunşi din paginile de <i>Advertiseri & Campanii</i> şi <i>Campanii</i>. Daca această opţiune este dezactivată este posibilă afişarea itemilor ascunşi, prin click pe butonul <i>Arată Tot</i> din josul paginii.";
?>