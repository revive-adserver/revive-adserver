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

require_once MAX_PATH . '/lib/xmlrpc/php/tests/integration/Common.api.php';

/**
 * A class for testing the XML-RPC server
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class Test_OA_Api_XmlRpc_Server extends Test_OA_Api_XmlRpc
{
    public function testUnexpectedElement(): void
    {
        $message = new XML_RPC_Message('');
        $message->payload = <<<EOF
<?xml version="1.0"?>
<methodCall>
  <methodName>system.listMethods</methodName>
  <params>
    <param><value><nil/></value></param>
  </params>
</methodCall>
EOF;

        /** @var XML_RPC_Response $result */
        $result = $this->oApi->_getClient('LogonXmlRpcService.php')->send($message);

        $this->assertEqual($result->faultString(), 'Invalid request payload: xmlrpc element NIL cannot be child of VALUE');
    }
}