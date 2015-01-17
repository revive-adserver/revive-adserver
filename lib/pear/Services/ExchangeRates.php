<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at                              |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author: Marshall Roch <marshall@exclupen.com>                        |
// +----------------------------------------------------------------------+

/**
 * @package Services_ExchangeRates
 * @category Services
 */

/**#@+
 * Error codes
 */
define('SERVICES_EXCHANGERATES_ERROR_RETURN', 1);
define('SERVICES_EXCHANGERATES_ERROR_DIE', 8);
define('SERVICES_EXCHANGERATES_ERROR_INVALID_DRIVER', 101);
define('SERVICES_EXCHANGERATES_ERROR_INVALID_CURRENCY', 102);
define('SERVICES_EXCHANGERATES_ERROR_CONVERSION_ERROR', 103);
define('SERVICES_EXCHANGERATES_ERROR_RETRIEVAL_FAILED', 104);
/**#@-*/

/**
 * Exchange Rate package
 *
 * This package converts back and forth between different currencies, in any
 * combination.  All data used is updated automatically from interchangable
 * sources.  That is, if there is a source publishing exchange rates that
 * isn't supported yet, you could write a driver and use that source
 * seamlessly with the rest of the package.
 *
 * Disclaimer: The rates are nominal quotations - neither buying nor
 * selling rates - and are intended for statistical or analytical
 * purposes. Rates available from financial institutions will differ.
 *
 * The United Nations Economic Commission for Europe is implementing new web
 * services.  Keep an eye on progress here: http://www.unemed.org/edocs/index.htm
 *
 * @todo Add locale support for different currency formatting
 *
 * @example ExchangeRates/docs/example.php
 *
 * @author Marshall Roch <marshall@exclupen.com>
 * @author Colin Ross <cross@php.net>
 * @copyright Copyright 2003 Marshall Roch
 * @license http://www.php.net/license/2_02.txt PHP License 2.0
 * @package Services_ExchangeRates
 */
class Services_ExchangeRates {

   /**
    * Sets the number of places to round the currencies to at the end
    * @access private
    * @var int
    */
    var $_roundToDecimal = 2;

   /**
    * Determines whether the returned conversion is rounded or not
    * @access private
    * @var bool
    */
    var $_roundAutomatically = true;

   /**
    * Defines single character used to separate each group of thousands in returned conversion
    * @access private
    * @var string
    */
    var $_thousandsSeparator = ",";

   /**
    * Defines single character to use as a decimal place in returned conversion
    * @access private
    * @var string
    */
    var $_decimalCharacter = ".";

   /**
    * Sets the path to where cache files are stored (don't forget the trailing slash!)
    * @access private
    * @var string
    */
    var $_cacheDirectory = '/tmp/';

   /**
    * Sets the length (in seconds) to cache the exchange rate data. This information
    * is updated daily. Default is 1 hour.
    * @access private
    * @var int
    */
    var $_cacheLengthRates = 3600;

   /**
    * Sets the length (in seconds) to cache the list of currencies.  This information
    * is very rarely updated. Default is 4 weeks.
    * @access private
    * @var int
    */
    var $_cacheLengthCurrencies = 2419200;

   /**
    * Sets the length (in seconds) to cache the list of countries.  This information
    * is very rarely updated. Default is 4 weeks.
    * @access private
    * @var int
    */
    var $_cacheLengthCountries = 2419200;

   /**
    * PEAR error mode (when raiseError is called)
    *
    * @see setToDebug()
    * @access private
    * @var int
    */
    var $_pearErrorMode = SERVICES_EXCHANGERATES_ERROR_RETURN;

   /**
    * Constructor
    *
    * This method overrides any default settings based on the $options
    * parameter and retrieves feed data from the cache or their sources.
    *
    * $options is an associative array:
    * <code>
    * $options = array(
    *     'roundToDecimal'        => number of decimal places to round to (int),
    *     'roundAutomatically'    => whether to automatically round to
    *                                $roundToDecimal digits (bool),
    *     'thousandsSeparator'    => character to separate every 1000 (string),
    *     'decimalCharacter'      => character for decimal place (string),
    *     'cacheDirectory'        => path (with trailing slash) to store cache
    *                                files (string),
    *     'cacheLengthRates'      => length of time to cache exchange rates
    *                                file (int),
    *     'cacheLengthCurrencies' => length of time to cache currency
    *                                list (int),
    *     'cacheLengthCountries'  => length of time to cache country list (int),
    *     'pearErrorMode'         => pear error mode (int));
    * </code>
    *
    * @param string Driver name (filename minus 'Rates_' and .php) for exchange rate feed
    * @param string Driver name for currency code list
    * @param string Driver name for country code list (not yet used for anything)
    * @param array  Array to override default settings
    */
    function __construct($ratesSource = 'ECB',
                                    $currencySource = 'UN',
                                    $countrySource = 'UN',
                                    $options = array(NULL)) {

        $availableOptions = array('roundToDecimal',
                                  'roundAutomatically',
                                  'thousandsSeparator',
                                  'decimalCharacter',
                                  'cacheDirectory',
                                  'cacheLengthRates',
                                  'cacheLengthCurrencies',
                                  'cacheLengthCountries');

        foreach($options as $key => $value) {
            if(in_array($key, $availableOptions)) {
                $property = '_'.$key;
                $this->$property = $value;
            }
        }

        $rateData = $this->retrieveData('Rates_' . $ratesSource, $this->_cacheLengthRates);
        $this->rates = $rateData['rates'];
        $this->ratesUpdated = $rateData['date'];
        $this->ratesSource = $rateData['source'];

        $this->currencies = $this->retrieveData('Currencies_' . $currencySource, $this->_cacheLengthCurrencies);

        // not yet implimented, here for future features:
        // $this->countries = $this->retrieveData('Countries_' . $countriesSource, $this->_cacheLengthCountries);

        $this->validCurrencies = $this->getValidCurrencies($this->currencies, $this->rates);

    }

   /**
    * Factory
    *
    * Includes the necessary driver, instantiates the class, retrieves the feed,
    * and returns an associative array.
    *
    * @param string Driver filename (minus .php; this includes 'Rates_', etc.)
    * @param int Cache length
    * @return array Associative array containing the data requested
    */
    function retrieveData($source, $cacheLength) {
        include_once("Services/ExchangeRates/${source}.php");
        $classname = "Services_ExchangeRates_${source}";
        if (!class_exists($classname)) {
            return $this->raiseError("No driver exists for the source ${source}... aborting.", SERVICES_EXCHANGERATES_ERROR_INVALID_DRIVER);
        }
        $class = new $classname;

        return $class->retrieve($cacheLength, $this->_cacheDirectory);
    }

   /**
    * Get list of currencies with known exchange rates
    *
    * Creates an array of currency codes and their names, based on
    * overlapping elements in $rates and $currencies.
    *
    * @param array Array of currency codes to currency names
    * @param array Array of currency codes to exchange rates
    * @return array Array of currency codes to currency names that have a known exchange rate (sorted alphabetically)
    */
    function getValidCurrencies($currencies, $rates) {
        // loop through list of currencies
        $validCurrencies = array();
        foreach ($currencies as $code => $currency) {
            // check to see if that currency has a known exchange rate
            if (in_array($code, array_keys($rates))) {
                // if so, add it to the array to return
                $validCurrencies[$code] = $currency;
            }
        }
        asort($validCurrencies);
        return $validCurrencies;
    }

    function isValidCurrency($code) {
        if (!in_array($code, array_keys($this->validCurrencies))) {
            $this->raiseError('Error: Invalid currency: ' . $code, SERVICES_EXCHANGERATES_ERROR_INVALID_CURRENCY);
            return false;
        }

        return true;
    }

   /**
    * Convert currencies
    *
    * @param string Currency code of original currency
    * @param string Currency code of target currency
    * @param double Amount of original currency to convert
    * @param boolean Format the final currency (add commas, round, etc.)
    * @return mixed Currency converted to $to
    */
    function convert($from, $to, $amount, $format = true) {

        if ($this->isValidCurrency($from) && $this->isValidCurrency($to)) {

            // Convert $from to whatever the base currency of the
            // exchange rate feed is.
            $this->baseRate = (1 / $this->rates[$from]) * $amount;
            // Convert from base currency to $to
            $final = $this->rates[$to] * $this->baseRate;
            $this->baseCurr = array_search(1,$this->rates);
            return ($format) ? $this->format($final) : $final;
        }
        $this->raiseError('Unable to convert!', SERVICES_EXCHANGERATES_ERROR_CONVERSION_ERROR);
        return false;

    }

   /**
    * Formats the converted currency
    *
    * This method adds $this->_thousandsSeparator between every group of thousands,
    * and rounds to $this->_roundToDecimal decimal places.  Use the $options parameter
    * on the constructor to set these values.
    *
    * @param double Number to format
    * @param mixed  Number of decimal places to round to (null for default)
    * @param mixed  Character to use for decimal point (null for default)
    * @param mixed  Character to use for thousands separator (null for default)
    * @return string Formatted currency
    */
    function format($amount, $roundTo = null, $decChar = null, $sep = null) {
        $roundTo = (($this->_roundAutomatically) ?
                   (($roundTo == null) ? $this->_roundToDecimal : $roundTo) :
                   '');
        $decChar  = ($decChar == null) ? $this->_decimalCharacter : $decChar;
        $sep = ($sep == null) ? $this->_thousandsSeparator : $sep;

        return number_format($amount, $roundTo, $decChar, $sep);
    }
    /**
     * Get all rates as compared to a reference currency
     *
     * Returns an associative array with currency codes as keys and
     * formated rates as values, as computed against a reference currency.
     *
     * @param string $referenceCurrency Reference currency code
     * @return array List of currencies => rates
     * @see Services_ExchangeRates::convert()
     * @access public
     */
    function getRates ($referenceCurrency)
    {
        $rates = array();
        foreach ($this->validCurrencies as $code => $name) {
            $rates[$code] = $this->convert($referenceCurrency, $code, 1, false);
        }
        ksort($rates);
        return $rates;
    }
   /**
    * Set to debug mode
    *
    * When an error is found, the script will stop and the message will be displayed
    * (in debug mode only).
    */
    function setToDebug()
    {
        $this->_pearErrorMode = SERVICES_EXCHANGERATES_ERROR_DIE;
    }

   /**
    * Trigger a PEAR error
    *
    * To improve performances, the PEAR.php file is included dynamically.
    * The file is so included only when an error is triggered. So, in most
    * cases, the file isn't included and performance is much better.
    *
    * @param string error message
    * @param int error code
    */
    function raiseError($msg, $code)
    {
        include_once('PEAR.php');
        PEAR::raiseError($msg, $code, $this->_pearErrorMode);
    }

}

?>
