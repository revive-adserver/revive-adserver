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
$Id$
*/

/**
 * A class to deal with the conwersion between difrent number formats
 *
 * @package    OpenXAdmin
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OA_Admin_NumberFormat {

        /**
         * Converts human readable numbers to php/database number format
         * Remove spaces, comas or dots separating thousands
         * always convert decimal point to dot
         *
         * @param string $number
         * @return mixed converted string or false if it wasn't number
         */
         function unformatNumber($number) {
            $number = trim($number);

            global $phpAds_DecimalPoint;
            $aLocale = localeconv();
            if (isset($phpAds_DecimalPoint)) {
                $separator = $phpAds_DecimalPoint;
            } elseif (isset($aLocale['decimal_point'])) {
                $separator = $aLocale['decimal_point'];
            } else {
                $separator = '.';
            }

            //test if the number is in format like 12345.67 or 12 345.67 or 12,345.67
            //remove spaces or comas
            if ( preg_match ("/^(-|\+)?(([0-9]+)((\,| )?([0-9][0-9][0-9]))*)?([.][0-9]+)?$/" ,$number) == 1){
                $result_dot_decSep = str_replace("+","",$number);
                $result_dot_decSep = str_replace(array(","," "),"",$result_dot_decSep);
            }

            //test if the number is in format like 12345,67 or 12 345,67 or 12.345,67
            //remove spaces or dots, and change the "," to "."
            if ( preg_match ("/^(-|\+)?(([0-9]+)((\.| )?([0-9][0-9][0-9]))*)?([\,][0-9]+)?$/" ,$number) == 1){
                $result_coma_decSep = str_replace(array("."," "),"",$number);
                $result_coma_decSep = str_replace("+","",$result_coma_decSep);
                $result_coma_decSep = str_replace("," ,".",$result_coma_decSep);
            }

            //single "." always as decimal separator!
            //Reson: forms display numbers in php format eg. 10.000, another submit could convert it to 10000!
            if (isset($result_dot_decSep) && substr_count($number,'.')==1) {
                return $result_dot_decSep;
            }

            //based on locale determine if single coma is decimal or thousends separator
            // eg 10,000 is 10000 or 10
            switch ($separator) {
                case "." :
                    if (isset($result_dot_decSep)) {
                        return $result_dot_decSep;
                    } elseif (isset($result_coma_decSep)) {
                        return $result_coma_decSep;
                    }
                    break;
                case "," :
                    if (isset($result_coma_decSep)) {
                        return $result_coma_decSep;
                    } elseif (isset($result_dot_decSep)) {
                        return $result_dot_decSep;
                    }
                    break;
            }
            return false;
        }

        /**
         * This method takes a number and formats it using the user's locale
         *
         * @param float $number         The number to be formatted
         * @param int $decimals         The number of decimal places to generate
         * @param string $dec_point     The character to use to use for the decimal point
         * @param string $thousands_sep The character to use to seperate groups of thousands
         * @return string The formatted number
         */
        function formatNumber($number, $decimals = null, $dec_point = null, $thousands_sep = null)
        {
            if (!is_numeric($number)) {
                return false;
            }

            $decimals       = (!empty($decimals))       ? $decimals     : $GLOBALS['_MAX']['PREF']['ui_percentage_decimals'];
            $dec_point      = (!empty($dec_point))      ? $dec_point    : $GLOBALS['phpAds_DecimalPoint'];
            $thousands_sep  = (!empty($thousands_sep))  ? $thousands_sep: $GLOBALS['phpAds_ThousandsSeperator'];

            return number_format($number, $decimals, $dec_point, $thousands_sep);
        }
}

?>
