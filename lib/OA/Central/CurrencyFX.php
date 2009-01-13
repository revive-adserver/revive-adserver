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

require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Central/M2M.php';
require_once MAX_PATH . '/lib/OA/Dal/Central/AdNetworks.php';

require_once MAX_PATH . '/lib/max/Admin_DA.php';

require_once MAX_PATH . '/lib/max/Admin/Invocation.php';

require_once('SimpleFunctionCache.php');

/**
 * OXP binding to the currency FX feed OXC API
 *
 */
class OA_Central_CurrencyFX extends OA_Central_M2M
{
	/**
     * @var SimpleFunctionCache
     */
	private $oSimpleFunctionCache;
	
	
	/**
     * Class constructor
     *
     * @return OA_Central_CurrencyFX()
     */
    function OA_Central_CurrencyFX()
    {
		parent::OA_Central_Common();
    	$this->oSimpleFunctionCache = $this->createSimpleFunctionCache($this->oMapper, "getFXFeed", 43200);
    }

    
    /**
     * A method to retrieve currencies and rates
     *
     * @see R-AN-3: Gathering the data of Websites during Installation
     * @see R-AN-16: Gathering the Websites after the Installation
     * @see C-AN-1: Displaying Ad Networks on Advertisers & Campaigns Screen
     *
     * @return Map of currency symbol => rate 
     */
    function getCurrencyFX($base = null)
    {
    	$fullFeed = $this->getCurrencyFXWithMetadata();
    	$feed = $fullFeed["rates"];
    	return $base == null ? $feed : $this->convertToBase($feed, $base);
    }
    
    
    function convertToBase($feed, $base)
    {
		$dest = array();
    	foreach ($feed as $currency => $rate) {
    		$dest[$currency] = $this->translateFromFeed(1, $base, $currency, $feed);
    	}
    	return $dest;
    }
    
    
    function reverseFeed($feed)
    {
		$dest = array();
    	foreach ($feed as $currency => $rate) {
    		$dest[$currency] = 1 / $rate;
    	}
    	return $dest;
    }
    
    
    function getCurrencyFXWithMetadata()
    {
    	return $this->oSimpleFunctionCache->get();
    }
    
    
    function removeCurrencyFXCache()
    {
    	$this->oSimpleFunctionCache->removeCache();
    }
	
    
    function getCurrencies()
    {
    	return array_keys($this->getCurrencyFX());
    }
	
    
    function translateToVisibleValue($value, $currencyFrom, $currencyTo)
    {
    	return OA_Central_CurrencyFX::translateStorableToVisibleValue(
    			$this->translateToStorableValue($value, $currencyFrom, $currencyTo));
    }
    
    
    static function translateStorableToVisibleValue($value)
    {
    	return round($value, 2);
    }
    
    
    function translateToStorableValue($value, $currencyFrom, $currencyTo)
    {
    	return OA_Central_CurrencyFX::translateFromFeed($value, $currencyFrom, $currencyTo, $this->getCurrencyFX());
    }
    
    
    static function translateFromFeed($value, $currencyFrom, $currencyTo, $fxFeed)
    {
    	return OA_Central_CurrencyFX::translateFromRates($value, $fxFeed[$currencyFrom], $fxFeed[$currencyTo]);
    }
    
    
    static function translateFromRates($value, $currencyFromRate, $currencyToRate)
    {
    	return round(($value / $currencyFromRate) * $currencyToRate, 11);
    }
        
    
    /**
     * A method to retrieve the list of currencies as for HTML select options
     *
     * @return array
     */
    function getCurrencySelect()
    {
        $aCurrencies = $this->getCurrencies();
    	asort($aCurrencies);
        return array('' => '- pick a currency -') + $aCurrencies;
    }
}

?>
