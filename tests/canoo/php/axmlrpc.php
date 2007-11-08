<?php
 /*
  * As the PHP script below tries to set cookies, it must be called
  * before any output is sent to the user's browser. Once the script
  * has finished running, the HTML code needed to display the ad is
  * stored in the $adArray array (so that multiple ads can be obtained
  * by using mulitple tags). Once all ads have been obtained, and all
  * cookies set, then you can send output to the user's browser, and
  * print out the contents of $adArray where appropriate.
  *
  * Example code for printing from $adArray is at the end of the tag -
  * you will need to remove this before using the tag in production.
  * Remember to ensure that the PEAR::XML-RPC package is installed
  * and available to this script. You may need to alter the
  * 'include_path' value immediately below.
  */

    define('MAX_PATH', './../..');
    ini_set('include_path', MAX_PATH . '/lib/pear');
    
    error_reporting(E_ALL);
    
    // resolve axmlrpc.php location
    $xmlrpcPath = substr($_SERVER['REQUEST_URI'], 0, 
        strlen($_SERVER['REQUEST_URI']) - strlen('delivery_test/axmlrpc.php')) . 'delivery/axmlrpc.php';
        
    $protocol = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';

    // Left for future debugging
    // $xmlrpcPath .= '?start_debug=1&debug_port=10000&debug_host=127.0.0.1&debug_stop=1';
    require_once 'XML/RPC.php';
    require_once 'PEAR.php';
    PEAR::setErrorHandling(PEAR_ERROR_PRINT);

    global $XML_RPC_String, $XML_RPC_Boolean;
    global $XML_RPC_Array, $XML_RPC_Struct;

    // Create an XML-RPC client to talk to the XML-RPC server
    $client = new XML_RPC_Client($xmlrpcPath, $protocol.$_SERVER['HTTP_HOST']);
    // Left for future debugging
    // $client->debug = true;

    // A function to serialise cookie data
    function serialiseCookies($cookies = array())
    {
        global $XML_RPC_Struct;
        $array = array();
        foreach ($cookies as $key => $value) {
            if (is_array($value)) {
                $innerArray = serialiseCookies($value);
                $array[$key] = new XML_RPC_Value($innerArray, $XML_RPC_Struct);
            } else {
                $array[$key] = new XML_RPC_Value($value);
            }
        }
        return $array;
    }

    // Create the XML-RPC message
    $message = new XML_RPC_Message('max.view', array());

    // Package the cookies into an array as XML_RPC_Values
    $cookiesStruct = serialiseCookies($_COOKIE);
    // Add the parameters to the message
    $message->addParam(new XML_RPC_Value('zone:1', $XML_RPC_String));
    $message->addParam(new XML_RPC_Value('', $XML_RPC_String));
    $message->addParam(new XML_RPC_Value('', $XML_RPC_String));
    $message->addParam(new XML_RPC_Value('0', $XML_RPC_Boolean));
    $message->addParam(new XML_RPC_Value($_SERVER['REMOTE_ADDR'], $XML_RPC_String));
    $message->addParam(new XML_RPC_Value($cookiesStruct, $XML_RPC_Struct));

    // Send the XML-RPC message to the server
    $response = $client->send($message, 15, $protocol);

    // Was a response received?
    if (!$response) {
        echo 'Error: No XML-RPC response';
        exit;
    }

    // Was a response an error?
    if ($response->faultCode() != 0) {
        echo 'Error: ' . $response->faultString();
    } else {
        // Ensure the response is an array
        $value = $response->value();
        if ($value->kindOf() != $XML_RPC_Array) {
            echo 'Error: Unexpected response value';
        }
        // Store any cookies sent in the response
        $cookies = $value->arraymem(1);
        if ($cookies->kindOf() == $XML_RPC_Array) {
            $numCookies = $cookies->arraysize();
            // For each cookie...
            for ($counter = 0; $counter < $numCookies; $counter++) {
                $cookie = $cookies->arraymem($counter);
                if (($cookie->kindOf() == $XML_RPC_Array) && ($cookie->arraysize() == 3)) {
                    $cookieName  = $cookie->arraymem(0);
                    $cookieValue = $cookie->arraymem(1);
                    $cookieTime  = $cookie->arraymem(2);
                    setcookie($cookieName->scalarval(), $cookieValue->scalarval(), $cookieTime->scalarval());
                }
            }
        }
        // Store the ad in the ad array
        $advertisement = $value->arraymem(0);
        if ($advertisement->kindOf() == $XML_RPC_Struct) {
            $htmlValue = $advertisement->structmem('html');
            $adArray[] = $htmlValue->scalarval();
        }
        // Example display code - remove before use
        if (isset($adArray)) {
            foreach ($adArray as $value) {
                echo $value;
            }
        }
    }

?>