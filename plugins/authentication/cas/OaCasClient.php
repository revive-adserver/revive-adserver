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
$Id: cas.plugin.php 14963 2008-01-22 18:18:51Z radek.maciaszek@openads.org $
*/

require_once MAX_PATH . '/plugins/authentication/cas/CAS/CAS.php';
require_once MAX_PATH . '/plugins/authentication/cas/CAS/client.php';

/**
 * Authentication CAS plugin which authenticates users against cas-server
 *
 * @package    OpenXPlugin
 * @subpackage Authentication
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 * @abstract
 */
class OaCasClient extends CASClient
{
    /**
    * CASClient constructor.
    *
    * @param $server_version the version of the CAS server
    * @param $proxy TRUE if the CAS client is a CAS proxy, FALSE otherwise
    * @param $server_hostname the hostname of the CAS server
    * @param $server_port the port the CAS server is running on
    * @param $server_uri the URI the CAS server is responding on
    * @param $start_session Have phpCAS start PHP sessions (default true)
    *
    * @return a newly created CASClient object
    *
    * @public
    */
    function OaCasClient(
          $server_version,
        $proxy,
        $server_hostname,
        $server_port,
        $server_uri,
        $start_session = true) {
            return parent::CASClient($server_version,
                $proxy,
                $server_hostname,
                $server_port,
                $server_uri,
                $start_session);
    }
    
  /**
   * This method is used to print the HTML output when the user was not authenticated.
   * 
   * TODOLANG - localize errors strings
   *
   * @param $failure the failure that occured
   * @param $cas_url the URL the CAS server was asked for
   * @param $no_response the response from the CAS server (other 
   * parameters are ignored if TRUE)
   * @param $bad_response bad response from the CAS server ($err_code
   * and $err_msg ignored if TRUE)
   * @param $cas_response the response of the CAS server
   * @param $err_code the error code given by the CAS server
   * @param $err_msg the error message given by the CAS server
   *
   * @private
   */
    function authError($failure,$cas_url,$no_response,$bad_response='',
        $cas_response='',$err_code='',$err_msg='')
    {
        $msgs = array();
        $debugMsgs = array();
        $debugMsgs[] = 'CAS URL: '.$cas_url;
        $msgs[] = 'Authentication failure: '.$failure;
        if ( $no_response ) {
            $msgs[] = 'Reason: no response from the CAS server';
        } else {
            if ( $bad_response ) {
                $msgs[] = 'Reason: bad response from the CAS server';
            } else {
                switch ($this->getServerVersion()) {
                    case CAS_VERSION_1_0:
                        $msgs[] = 'Reason: CAS error';
                        break;
                    case CAS_VERSION_2_0:
                        if ( empty($err_code) )
                            $msgs[] = 'Reason: no CAS error';
                        else
                            $msgs[] = 'Reason: ['.$err_code.'] CAS error: '.$err_msg;
                    break;
                }
            }
            $debugMsgs[] = 'CAS response: '.$cas_response;
        }
        OA::debug(implode("\n", array_merge($msgs, $debugMsgs)), PEAR_LOG_ERR);
        $message = implode("<br/>\n", $msgs);
        $message .= '<br/><br/><a href="index.php">Click here</a> to try to log-in again';
        phpAds_Die($title="Authentication Error", $message);
        exit();
    }
    
  /**
   * This method is used to retrieve the base URL of the CAS server.
   * @return a URL.
   * @private
   */
  function getServerBaseURL()
    { 
      $protocol = $GLOBALS['_MAX']['CONF']['oacSSO']['protocol'];
      // the URL is build only when needed
      if ( empty($this->_server['base_url']) ) {
	   $this->_server['base_url'] = $protocol . '://'
	  .$this->getServerHostname()
	  .':'
	  .$this->getServerPort()
	  .$this->getServerURI();
      }
      return $this->_server['base_url']; 
    }
}

?>