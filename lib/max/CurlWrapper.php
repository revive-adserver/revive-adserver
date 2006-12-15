<?php

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