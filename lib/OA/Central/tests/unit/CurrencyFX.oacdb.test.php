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

require_once MAX_PATH . '/lib/OA/Central/CurrencyFX.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the OA_Central_CurrencyFX class.
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Pawel Gruszczynski <pawel.gruszczynski@openx.org>
 */
class Test_OA_Central_CurrencyFX extends UnitTestCase
{
    /**
     * @var OA_PermanentCache
     */
    var $oCache;
    
    var $adminAccountId;
    var $managerAccountId;

	private $aCurrencies = array("USD" => "1.5", "PLN" => "3.33");
    private $aCurrencies2 = array("USD" => "1.5", "PLN" => "3.33", "GBP" => 2);
    
    function _setUpAppVars()
    {
        OA_Dal_ApplicationVariables::set('platform_hash', sha1('foo'));
        OA_Dal_ApplicationVariables::set('sso_admin', 'foo');
        OA_Dal_ApplicationVariables::set('sso_passwd', md5('bar'));
    }


    
    
    /**
     * The constructor method.
     */
    function Test_OA_Central_CurrencyFX()
    {
        $this->UnitTestCase();

        $this->oCache = new OA_PermanentCache();
    	$GLOBALS['_MAX']['PREF'] = array(
            'language'    => 'en',
            'admin_name'  => 'Foo Bar',
            'admin_email' => 'foo@example.com'
        );

        $this->oCache = new OA_PermanentCache();

//		OA_Dal_ApplicationVariables::set('platform_hash', sha1('foo'));
//
//        $doAccounts = OA_Dal::factoryDO('accounts');
//        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
//        $doAccounts->account_name = 'Administrator';
//        $this->adminAccountId = DataGenerator::generateOne($doAccounts);
        
    }
	
    
    function _mockSetCallReturnValue(&$oCurrencyFx, $value)
    {
        $oCurrencyFx->oMapper->oRpc->setReturnValue('call', $value);
    }
	
    
    function _mockSendExpect(&$oAdNetworks, $args)
    {
        $oCurrencyFx->oMapper->oRpc->oXml->expect('getFXFeed', $args);
    }
    
    
    /**
     * Create a new OA_Central_AdNetworks instance with a mocked Rpc class
     *
     * @return OA_Central_CurrencyFX
     */
    function _newInstance()
    {
        Mock::generatePartial(
            'OA_Dal_Central_Rpc',
            $oXmlRpc = 'OA_Dal_Central_Rpc_'.md5(uniqid('', true)),
            array('call')
        );

        $oCurrencyFx = new OA_Central_CurrencyFX();
        $oCurrencyFx->oMapper->oRpc = new $oXmlRpc();

        return $oCurrencyFx;
    }
	
	
	function getCurrencyFX($feedRates) 
	{
		$this->setFeedRates($feedRates);
        return $this->oCurrencyFX->getCurrencyFX();
	}
	
	
	function setFeedRates($feedRates)
	{
		$this->_mockSetCallReturnValue($this->oCurrencyFX, array("rates" => $feedRates));
	}	
	
	
	/**
     * @var OA_Central_CurrencyFX
     */
	private $oCurrencyFX;
	
    /**
     * A method to test the getFXFeed() method.
     *
     */
    function testGetFXFeed()
    {
		$this->oCurrencyFX = $this->_newInstance();
		$this->oCurrencyFX->removeCurrencyFXCache();

		$this->assertEqual($this->aCurrencies, $this->getCurrencyFX($this->aCurrencies));
		$this->assertEqual($this->aCurrencies, $this->getCurrencyFX(new PEAR_Error()));
		
		
		$this->oCurrencyFX = $this->_newInstance();
		$this->assertEqual($this->aCurrencies, $this->getCurrencyFX(new PEAR_Error()));
		
		$this->oCurrencyFX = $this->_newInstance();
		$this->assertEqual($this->aCurrencies, $this->getCurrencyFX($this->aCurrencies2));
		
		$this->oCurrencyFX->removeCurrencyFXCache();
		$this->assertEqual($this->aCurrencies2, $this->getCurrencyFX($this->aCurrencies2));
		$this->assertEqual($this->aCurrencies2, $this->getCurrencyFX($this->aCurrencies));
    }
    
    
    function testRates()
    {
		$this->oCurrencyFX = $this->_newInstance();
		$this->oCurrencyFX->removeCurrencyFXCache();
    	
    	$aCurrencies = array("USD" => "1.5869", "PLN" => "3.4125", "GBP" => "0.79860");
    	$this->setFeedRates($aCurrencies);
    	
    	$this->assertEqual(215.04, $this->oCurrencyFX->translateToVisibleValue(100, "USD", "PLN"));
    	$this->assertEqual(215.04190560212, $this->oCurrencyFX->translateToStorableValue(100, "USD", "PLN"));

    	$this->assertEqual(1102.46, $this->oCurrencyFX->translateToVisibleValue(258, "GBP", "PLN"));
    	$this->assertEqual(1102.46055597295, $this->oCurrencyFX->translateToStorableValue(258, "GBP", "PLN"));

        $this->assertEqual(232.25, $this->oCurrencyFX->translateToVisibleValue(108, "USD", "PLN"));
        $this->assertEqual(232.24525805029, $this->oCurrencyFX->translateToStorableValue(108, "USD", "PLN"));
        
    }
}

?>
