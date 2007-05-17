<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
 * Simple curl wrapper that handles packaging headers and params.
 *
 * @author demian@m3.net
 */
class MAX_CurlWrapper
{

   /**
     * Sends a request with PHP's curl functions.
    *
    * @access   public
    * @param    string  $url        Uri to send data to
    * @param    array   $aBody      Body of the request
    * @param    array   $aHeaders   Headers for the request
    * @return   mixed   either the response xml string or a PEAR error
    */
    function sendRequest($url, $aBody, $aHeaders = array())
    {
        $postParams = $this->_buildPostParams($aBody);

        //  init curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $returned = trim(curl_exec($ch));
        curl_close ($ch);

        if ($returned === false) {
            MAX::debug('there was an error in the curl transmission of data', $file, $line);
            return false;
        }
        return $returned;
    }

    /**
     * Builds POST params into format acceptable for socket write.
     *
     * @param   array   $aPostParams    The params to be sent with message
     * @return  string                  The string format of the params
     * @access private
     */
    function _buildPostParams($aPostParams)
    {
        $tmp = array();
        foreach ($aPostParams as $key => $value) {
            array_push($tmp, "$key=" . urlencode($value));
        }
        return implode('&', $tmp);
    }

    /**
     * Converts the headers hash into an array.
     *
     * @param   array   $aHeaders       The headers to be sent with message
     * @return  array   $tmp            The array of headers
     * @access private
     */
    function _buildHeaders($aHeaders)
    {
        $tmp = array();
        foreach ($aHeaders as $key => $value) {
            array_push($tmp, "$key: $value");
        }
        return $tmp;
    }
}
?>