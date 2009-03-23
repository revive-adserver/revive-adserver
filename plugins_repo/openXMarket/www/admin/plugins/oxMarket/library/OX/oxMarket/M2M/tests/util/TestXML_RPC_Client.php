<?php
require_once MAX_PATH . '/lib/pear/XML/RPC.php';

/**
 * Class used to catch $msg XML_RPC_Message object for tests purposes 
 */
class TestXML_RPC_Client extends XML_RPC_Client
{
    var $msg;
    var $response;
    
    function __construct()
    {
        //just override default constructor
    }
    
    function send($msg, $timeout = 0)
    {
        $this->msg = $msg;
        if (PEAR::isError($this->response))
        {
            PEAR::raiseError($this->response);
            return 0;
        }
        return $this->response;
    }
    
    function setResponse($response)
    {
        $this->response = $response;    
    }
    
    function getMessage()
    {
        return $this->msg;
    }
}