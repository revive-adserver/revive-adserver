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

/**
 * @package    OpenXUI
 * @param 	   lang - symbol of language used on administrator UI (default value = 'en')
 * @author     Andrew Hill <andrew.hill@openx.org>
 *
 * A collection of JavaScript functions for formatting numbers.
 *
 * Example use: For an INPUT field, use the onFocus() event and the
 * max_formattedNumberStringToFloat() function to remove formatting
 * from the field for easier editing, and then the onBlur() event
 * and the max_formatNumber() or max_formatNumberIgnoreDecimals()
 * function to re-format the field once the user has finished
 * editing the data.
 *
 * You might also need to pass the field through the
 * max_formattedNumberStringToFloat() function when the onSubmit()
 * event of the field occurs, so that you get un-formatted input
 * into your form submission script, if said script doesn't deal
 * with the formatted input.
 *
 *
 * @TODO Add support for dealing with exceeding the upper limit of
 *       JS support for numbers.
 */

// Setup the application constants since these are referenced in the language packs
// there's a slight hack here to prevent constants from parsing the config files
include('../../constants.php');
$GLOBALS['_MAX']['CONF'] = true;
setupConstants();

//Always load the English language, in case of incomplete translations
include '../../lib/max/language/en/default.lang.php';

$lang = str_replace(array('../', "\0"), '', $_GET['lang']);

if (isset($lang) && $lang != "en" && preg_match('/^[a-zA-Z_-]+$/D', $lang)) {
    //if selected directory exist, read language file
    if ( is_readable("../../lib/max/language/".$lang."/default.lang.php")) {
        include '../../lib/max/language/'.$lang.'/default.lang.php';
    }
}

// Send content-type header
header("Content-type: application/x-javascript");

// The largest possible integer in when using JavaScript's
// default 4-octet storage for numbers
define('MAX_JS_INTEGER_UPPER_LIMIT', 9007199254740992);

?>

/**
 * A JavaScript function to take a number, either as a real number, or
 * as a formatted string represenation of a number, and return that
 * number as a string, correctly formatted with thousands and decimal
 * delimiters in the textual representation.
 *
 * @param {mixed} number Either an Integer, a Float, or a String,
 *                       representing the number that needs to be
 *                       formatted.
 * @return {String} The number, formatted with thousand and decimal
 *                  delimiters.
 */
function max_formatNumber(number)
{
    // Convert the (potentially formatted) number into a float
    var numberFloat = max_formattedNumberStringToFloat(number);
    // Return the correctly formatted version of this float
    return max_baseFormatNumber(numberFloat);
}

/**
 * A JavaScript function to take a number, either as a real number, or
 * as a formatted string representation of a number, and stip out any
 * decimal point delimiters, if present, and then return the resulting
 * number as a string, correctly formatted with thousands delimiters
 * in the textual representation.
 *
 * @param {mixed} number Either an Integer, a Float, or a String,
 *                       representing the number that needs to be
 *                       formatted.
 * @return {String} The number resulting from removing any decimal
 *                  delimiters, formatted with thousand delimiters.
 */
function max_formatNumberIgnoreDecimals(number)
{
    // Convert the (potentially formatted) number into a float
    var numberFloat = max_formattedNumberStringToFloat(number);

    if (numberFloat == null) {
      return '';
    }

    // Delimiter to use
    var ddelimiter = '<?php
                        global $phpAds_DecimalPoint;
                        $aLocale = localeconv();
                        if (isset($phpAds_DecimalPoint)) {
                            $separator = $phpAds_DecimalPoint;
                        } elseif (isset($aLocale['decimal_point'])) {
                            $separator = $aLocale['decimal_point'];
                        } else {
                            $separator = '.';
                        }
                        echo $separator;
                      ?>';
    // Ensure the number is represented as a string
    var numberString = numberFloat.toString();
    // Remove decimals delimiters
    if (numberString.indexOf(ddelimiter) != -1) {
        var array = numberString.split(ddelimiter);
        numberString = array.join('');
    }
    // Return the correctly formatted version of this integer
    return max_baseFormatNumber(parseInt(numberString));
}

/**
 * A JavaScript function to take a number (as either an integer or
 * a float), and insert the required thousands and decimal separators
 * into it, returning a correctly formatting string for display.
 * Returns the original parameter in the event that anything other
 * than a valid number is passed in.
 *
 * @param {mixed} number Either an Integer, or a Float, representing
 *                       the number that needs to be formatted.
 * @return
 */
function max_baseFormatNumber(number)
{
    // Delimiters to use
    var tdelimiter = '<?php
                        global $phpAds_ThousandsSeperator;
                        $aLocale = localeconv();
                        if (isset($phpAds_ThousandsSeperator)) {
                            $separator = $phpAds_ThousandsSeperator;
                        } elseif (isset($aLocale['thousands_sep'])) {
                            $separator = $aLocale['thousands_sep'];
                        } else {
                            $separator = ',';
                        }
                        echo $separator;
                      ?>';
    var ddelimiter = '<?php
                        global $phpAds_DecimalPoint;
                        $aLocale = localeconv();
                        if (isset($phpAds_DecimalPoint)) {
                            $separator = $phpAds_DecimalPoint;
                        } elseif (isset($aLocale['decimal_point'])) {
                            $separator = $aLocale['decimal_point'];
                        } else {
                            $separator = '.';
                        }
                        echo $separator;
                      ?>';
    // Ensure the number is represented as a string
    var numberString = number.toString();
    // Split off any decimals
    var integer = 0;
    var decimal = 0;
    if (numberString.indexOf(ddelimiter) == -1) {
        integer = parseInt(numberString);
        if (isNaN(integer)) return number;
    } else {
        var numberArray = numberString.split(ddelimiter, 2);
        if (numberArray[0].length > 0) {
            integer = parseInt(numberArray[0]);
        }
        if (isNaN(integer)) return number;
        if (numberArray[1].length > 0) {
            decimal = parseInt(numberArray[1]);
        }
        if (isNaN(decimal)) return number;
    }
    // Store the minus sign, if needed, and convert to +ve number
    var minus = '';
    if (integer < 0) {
        minus = '-';
        integer = Math.abs(integer);
    }
    // Convert to string, and prepare array for storing parts
    var integerString = integer.toString();
    var decimalString = decimal.toString();
    var array = [];
    while (integerString.length > 3) {
        // Get the last 3 digits of the number
        var temp = integerString.substring(integerString.length - 3, integerString.length);
        // Insert these 3 digits at the start of the array, so that
        // the array can be looped over in order when re-assembling
        // the number
        array.unshift(temp);
        // Remove the 3 digits from the number
        integerString = integerString.substring(0, integerString.length - 3);
    }
    // Put the remaining number onto the front of the array
    if (integerString.length > 0) array.unshift(integerString);
    // Re-assemble number, and return
    var result = minus + array.join(tdelimiter);
    if ((decimalString.length > 0) && (parseInt(decimalString) != 0)) {
        result = result + ddelimiter + decimalString;
    }
    return result;
}

/**
 * A JavaScript function to take a string, representing a formatted
 * number (with thousands and decimal separators), and return a
 * float representation of that number. Returns null if the string
 * does not represent a value float.
 *
 * @param {String} number A formatted string, representing a number.
 * @return {mixed} The number resulting from removing all formatting
 *                 from the passed in string, as a Float, or null
 *                 in the event that no valud number can be found
 *                 in the input.
 */
function max_formattedNumberStringToFloat(number)
{
    // A list of all valid characters in a float
    var validCharsString = "0123456789<?php
                                        global $phpAds_DecimalPoint;
                                        $aLocale = localeconv();
                                        if (isset($phpAds_DecimalPoint)) {
                                            $separator = $phpAds_DecimalPoint;
                                        } elseif (isset($aLocale['decimal_point'])) {
                                            $separator = $aLocale['decimal_point'];
                                        } else {
                                            $separator = '.';
                                        }
                                        echo $separator;
                                      ?>";
    // Ensure the number is represented as a string
    var numberString = number.toString();
    // Strip all non-valid characters from the string
    var resultString = "";
    for (i = 0; i < numberString.length; i++) {
        var character = numberString.charAt(i);
        if (validCharsString.indexOf(character) != -1) {
            // This character in the string is valid
            resultString += character;
        } else if ((i == 0) && (character == '-')) {
            // The first character is allowed to be the minus sign
            resultString += character;
        }
    }
    if (resultString.length == 0) return null;
    return parseFloat(resultString);
}