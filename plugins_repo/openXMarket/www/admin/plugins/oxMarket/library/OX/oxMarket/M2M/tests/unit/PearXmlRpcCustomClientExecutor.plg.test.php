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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/pear/XML/RPC.php';
require_once MAX_PATH . '/lib/OX/M2M/XmlRpcExecutor.php';

require_once dirname(__FILE__) . '/../../PearXmlRpcCustomClientExecutor.php';
require_once dirname(__FILE__) . '/../util/TestXML_RPC_Client.php';

/**
 * A class for testing the Pear Xml RpcC Executor
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_oxMarket_M2M_PearXmlRpcCustomClientExecutorTest extends UnitTestCase
{
    
    function testCall()
    {
        $oXmlRpcClient = new TestXML_RPC_Client();

        // Case 1
        // field should be automatically encoded to XMl_RPC_Value if they are not already 
        $method1 = 'test';
        $params1 = array('stringparam', 
                          1234, 
                          '20090110T02:00:00', 
                          array('test'), 
                          array('struct' => 'yes'),
                          new XML_RPC_Value(true, 'boolean'));

        $expectedResult1 = array('test', 'response');
        $response1 = new XML_RPC_Response(XML_RPC_encode($expectedResult1));
        
        $oXmlRpcClient->setResponse($response1);
        
        $oXmlRpCExec = new OX_oxMarket_M2M_PearXmlRpcCustomClientExecutor(
                            $oXmlRpcClient);

        $result = $oXmlRpCExec->call($method1, $params1);
        
        $this->assertEqual($result, $expectedResult1);
        // Test XML_RPC_Message send to XML_RPC_Client
        $message = $oXmlRpcClient->getMessage();
        $this->assertEqual($message->method(), $method1);
        // Check string
        $param = $message->getParam(0);
        $this->assertIsA($param, 'XML_RPC_Value');
        $this->assertEqual($param->serialize(), "<value><string>stringparam</string></value>\n");
        $this->assertEqual(XML_RPC_decode($param), $params1[0]);
        // Check int
        $param = $message->getParam(1);
        $this->assertIsA($param, 'XML_RPC_Value');
        $this->assertEqual($param->serialize(), "<value><int>1234</int></value>\n");
        $this->assertEqual(XML_RPC_decode($param), $params1[1]);
        // Check dateTime.iso8601
        $param = $message->getParam(2);
        $this->assertIsA($param, 'XML_RPC_Value');
        $this->assertEqual($param->serialize(), "<value><dateTime.iso8601>20090110T02:00:00</dateTime.iso8601></value>\n");
        $this->assertEqual(XML_RPC_decode($param), $params1[2]);
        // Check array
        $param = $message->getParam(3);
        $this->assertIsA($param, 'XML_RPC_Value');
        $this->assertEqual($param->serialize(), 
            "<value><array>\n".
            "<data>\n".
            "<value><string>test</string></value>\n".
            "</data>\n".
            "</array></value>\n");
        $this->assertEqual(XML_RPC_decode($param), $params1[3]);
        // Check struct
        $param = $message->getParam(4);
        $this->assertIsA($param, 'XML_RPC_Value');
        $this->assertEqual($param->serialize(), 
            "<value><struct>\n".
            "<member><name>struct</name>\n".
            "<value><string>yes</string></value>\n".
            "</member>\n".
            "</struct></value>\n");
        $this->assertEqual(XML_RPC_decode($param), $params1[4]);
        // Check if last param isn't double encoded
        $param = $message->getParam(5);
        $this->assertIsA($param, 'XML_RPC_Value');
        $this->assertEqual($param->serialize(), "<value><boolean>1</boolean></value>\n");
        $this->assertEqual($param, $params1[5]);

        // Case 2
        // Fault response
        $response2 = new XML_RPC_Response(null, 213, 'my error');
        $oXmlRpcClient->setResponse($response2);
        
        try {
            $result = $oXmlRpCExec->call('test', array());
            $this->fail('Should have thrown exception');
        } catch (OX_oxMarket_M2M_PearXmlRpcCustomClientException $e) {
            $this->assertEqual($e->getCode(), 213);
            $this->assertEqual($e->getMessage(), 'my error');
        }
        
        // Case 3
        // PEAR error
        $response3 = new PEAR_Error('PEAR error message', 132);
        $oXmlRpcClient->setResponse($response3);
        
        try {
            $result = $oXmlRpCExec->call('test', array());
            $this->fail('Should have thrown exception');
        } catch (OX_oxMarket_M2M_PearXmlRpcCustomClientException $e) {
            $this->assertEqual($e->getCode(), 132);
            $this->assertEqual($e->getMessage(), 'PEAR error message');
        }
        
        // Case 4
        // Return 0, but PEAR_Error wasn't raised
        $oXmlRpcClient->setResponse(0);
        $oXmlRpcClient->errstr = 'internal xml-rpc error';
        
        try {
            $result = $oXmlRpCExec->call('test', array());
            $this->fail('Should have thrown exception');
        } catch (OX_oxMarket_M2M_PearXmlRpcCustomClientException $e) {
            $this->assertEqual($e->getCode(), 0);
            $this->assertEqual($e->getMessage(), 'Communication error: internal xml-rpc error');
        }
    }

    function testGetTimeout()
    {
        $oXmlRpcClient = new TestXML_RPC_Client();
        $oXmlRpCExec = new OX_oxMarket_M2M_PearXmlRpcCustomClientExecutor(
                            $oXmlRpcClient);

        $executionTime = (int)ini_get('max_execution_time');
        $default_socket_timeout = (int)ini_get('default_socket_timeout');
        $timeMargin = 1;
        
        ini_set('max_execution_time',300);
        ini_set('default_socket_timeout',600);
        
        $this->assertEqual($oXmlRpCExec->getTimeout(),300-$timeMargin);
        
        ini_set('max_execution_time',0);
        ini_set('default_socket_timeout', $default_socket_timeout);
        
        $this->assertEqual($oXmlRpCExec->getTimeout(), 0);
    }
}