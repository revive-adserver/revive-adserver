<?php

require_once MAX_PATH . '/lib/max/Delivery/remotehost.php';

/**
 * A class for testing the remoteshost.php functions.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author
 *
 */
class test_DeliveryRemotehost extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function test_DeliveryRemotehost()
    {
        $this->UnitTestCase();
    }


    /**
     * @todo future test case
     * A function to convert the $_SERVER['REMOTE_ADDR'] global variable
     * from the current value to the real remote viewer's value, should
     * that viewer be coming via an HTTP proxy.
     *
     * Only performs this conversion if the option to do so is set in the
     * configuration file.
     */
    function test_MAX_remotehostProxyLookup()
    {
        $return = MAX_remotehostProxyLookup();
        $this->assertTrue(true);
    }

    /**
     * @todo future test case
     * A function to perform a reverse lookup of the hostname from the IP address,
     * and store the result in the $_SERVER['REMOTE_HOST'] global variable.
     *
     * Only performs the reverse lookup if the option is set in the configuration,
     * and if the host name is not already present. If the the host name is not
     * present and the option to perform the lookup is not set, then the host name
     * is set to the remote IP address instead.
     */
    function test_MAX_remotehostReverseLookup()
    {
        $return = MAX_remotehostReverseLookup();
        $this->assertTrue(true);
    }

    /**
     *@todo test case for different user agents
     *
     * A function to set the viewer's useragent information in the
     * $GLOBALS['_MAX']['CLIENT'] global variable, if the option to use
     * phpSniff to extract useragent information is set in the
     * configuration file.
     */
    function test_MAX_remotehostSetClientInfo()
    {
        $GLOBALS['_MAX']['CONF']['logging']['sniff'] = true;
        $return = MAX_remotehostSetClientInfo();
        $this->assertIsA($GLOBALS['_MAX']['CLIENT'], 'array');
        //$this->assertEqual($GLOBALS['_MAX']['CLIENT']['ua'], $_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * @todo concerns a plugin
     *
     * A function to set the viewer's geotargeting information in the
     * $GLOBALS['_MAX']['CLIENT_GEO'] global variable, if a plugin for
     * geotargeting information is configured.
     *
     * @todo This is a workaround to avoid having to include the entire plugin architecure
     *       just to be able to load the config information. The plugin system should be
     *       refactored to allow the Delivery Engine to load the information independently
     */
    function test_MAX_remotehostSetGeoInfo()
    {
        $return = MAX_remotehostSetGeoInfo();
        $this->assertTrue(true);
    }

    /**
     * A function to determine if a given IP address is in a private network or
     * not.
     *
     * @param string $ip The IP address to check.
     * @return boolean Returns true if the IP address is in a private network,
     *                 false otherwise.
     */
    function test_MAX_remotehostPrivateAddress()
    {
        $return = MAX_remotehostPrivateAddress('127.0.0.1');
        $this->assertTrue($return);
        $return = MAX_remotehostPrivateAddress('235.0.0.66');
        $this->assertFalse($return);
    }
}

?>
