<?php
require 'simpletest/unit_tester.php';
require 'simpletest/mock_objects.php';
require 'simpletest/reporter.php';
require 'sharedance.class.php';

$group = new GroupTest('PHPDance Test Suite');

/**
 * Test case for the server class. This test requires a
 * sharedance server (or a stub server) to be running on 
 * localhost:1024
 *
 * @author Rob Young <bubblenut@gmail.com>
 * @since 2006-09-08
 */
class testSharedanceServer extends UnitTestCase {
    /**{{{properties:private
     */
    private $server;
    //}}}
    /**{{{setUp
     */
    public function setUp()
    {
        $this->server = new SharedanceServer( '127.0.0.1' );
    }//}}}
    /**{{{tearDown
     */
    public function tearDown()
    {
        unset($this->server);
    }//}}}
    /**{{{testCreate
     * Test that the server get's created correctly and
     * all the properties get set properly
     */
    public function testCreate() 
    {
        $this->assertEqual( $this->server->host, '127.0.0.1' );
        $this->assertEqual( $this->server->port, SharedanceServer::DEFAULT_PORT );
        $this->assertEqual( $this->server->timeout, SharedanceServer::DEFAULT_TIMEOUT );
        $this->assertEqual( $this->server->weight, SharedanceServer::DEFAULT_WEIGHT );
    }//}}}
    /**{{{testClose
     * Test that the object is properly closed when the close method is called
     */
    public function testClose()
    {
        $this->server->close();
        try {
            $this->server->send( 'some data' );
        } catch( SharedanceException $e ) {
            $this->pass();
            return;
        }
        $this->fail();
    }//}}}
    /**{{{testSend
     */
    public function testSend()
    {
        $this->assertEqual(
            $this->server->send( 'S' . pack( 'NN', strlen( 'mykey' ), strlen( 'myvalue' ) ) . 'mykey' . 'myvalue' ),
            "OK\n" 
        );
    }//}}}
    /**{{{testToString
     */
    public function testToString()
    {
        $this->assertEqual(
            $this->server->__toString(),
            '[' . $this->server->host . ':' . $this->server->port . ']'
        );
    }//}}}
}

$group->addTestClass( new testSharedanceServer );

Mock::generatePartial(
    'SharedanceServer',
    'MockSharedanceServer',
    array( 'send', 'close' )
);

class MyMockSharedanceServer extends MockSharedanceServer {
    public $throwException=false;
    public function send( $data ) {
        $return = parent::send( $data );
        if( $this->throwException ) {
            throw new SharedanceException( "Mocked Out Exception" );
        }
        return $return;
    }
}
/**
 * Test case for the overall manager class.
 *
 * @author Rob Young <bubblenut@gmail.com>
 * @since 2006-09-08
 */
class testSharedance extends UnitTestCase {
    /**{{{properties:private
     */
    private $subject, $server1, $server2, $extra_servers;
    //}}}
    /**{{{setUp
     */
    public function setUp()
    {
        $this->subject = new Sharedance( );
        $this->server1  = new MyMockSharedanceServer( $this );
        $this->server1->host = '127.0.0.1';
        $this->server1->port = 8080;
        $this->server1->weight = 1;
        $this->subject->addServer( $this->server1 );
        $this->server2 = new MyMockSharedanceServer( $this );
        $this->server2->host = '127.0.0.1';
        $this->server2->port = 8081;
        $this->server2->weight = 1;
    }//}}}
    /**{{{addExtraServers
     */
    public function addExtraServers()
    {
        $this->subject = new Sharedance( true );
        $this->server1  = new MyMockSharedanceServer( $this );
        $this->server1->host = '127.0.0.1';
        $this->server1->port = 8080;
        $this->server1->weight = 1;
        $this->subject->addServer( $this->server1 );
        $this->server2 = new MyMockSharedanceServer( $this );
        $this->server2->host = '127.0.0.1';
        $this->server2->port = 8081;
        $this->server2->weight = 1;
        $this->subject->addServer( $this->server2 );
        $this->extra_servers = array();
        $this->extra_servers[0] = new MyMockSharedanceServer( $this );
        $this->extra_servers[0]->host = '127.0.0.1';
        $this->extra_servers[0]->port = 8082;
        $this->extra_servers[0]->weight = 1;
        $this->extra_servers[1] = new MyMockSharedanceServer( $this );
        $this->extra_servers[1]->host = '127.0.0.1';
        $this->extra_servers[1]->port = 8083;
        $this->extra_servers[1]->weight = 2;

        foreach( $this->extra_servers as $server ) {
            $this->subject->addServer( $server );
        }
    }//}}}
    /**{{{tearDown
     */
    public function tearDown()
    {
        unset($this->subject, $this->server1, $this->server2, $this->extra_servers);
    }//}}}
    /**{{{testAddServer
     */
    public function testAddServer() {
        $this->pass();
    }//}}}
    /**{{{testConnect
     */
    public function testConnect() {
        $this->subject->connect( $this->server1 );
        $this->pass();
    }//}}}
    /**{{{testClose
     */
    public function testClose() {
        // Once in the explicit close, once from the destructor
        $this->server1->expectCallCount( 'close', 2 );
        $this->server1->setReturnValue( 'close', true );
        $this->subject->close();
        $this->server1->tally();
    }//}}}
    /**{{{testCloseFailure
     */
    public function testCloseFailure() {
        $this->server1->setReturnValue( 'close', false );

        try {
            $this->subject->close();
            $this->fail();
        } catch( SharedanceException $e ) {
            $this->pass();
        }
    }//}}}
    /**{{{testGet
     */
    public function testGet() 
    {
        // Figure out a nice way to test the packed integer 
        $this->server1->expectOnce( 'send' );
        $this->server1->setReturnValue( 'send', 'test data' );
        $this->assertEqual( $this->subject->get( 'testkey' ), 'test data' );
        $this->server1->tally();
    }//}}}
    /**{{{testGetMultiServer
     *
     * Test retrieving from the cache when multiple servers are involved
     */
    public function testGetMultiServer()
    {
        $this->subject->addServer( $this->server2 );
        $this->server1->expectNever( 'send' );
        $this->server2->expectOnce( 'send' );
        $this->server2->setReturnValue( 'send', 'test data' );
        $this->assertEqual( $this->subject->get( 'testkey' ), 'test data' );
        $this->server2->tally();
    }//}}}
    /**{{{testGetMultiServerFailover
     */
    public function testGetMultiServerFailover()
    {
        $this->addExtraServers();
        
        $this->extra_servers[1]->expectOnce( 'send' );
        $this->extra_servers[1]->throwException = true;

        $this->server1->expectOnce( 'send' );
        $this->server1->setReturnValue( 'send', 'test data' );

        $this->server2->expectNever( 'send' );
        $this->extra_servers[0]->expectNever( 'send' );

        $this->assertEqual( $this->subject->get('testkey'), 'test data' );
        $this->server1->tally();
        $this->extra_servers[1]->tally();
    }//}}}
    /**{{{testSet
     */
    public function testSet()
    {
        $key   = 'testkey';
        $value = 'test value';

        $this->server1->expectOnce( 'send' );
        $this->server1->setReturnValue( 'send', "OK\n" );
        try {
            $this->subject->set( $key, $value );
            $this->pass();
        } catch( SharedanceException $e ) {
            $this->fail();
        }
        $this->server1->tally();
    }//}}}
    /**{{{testSetMultiServer
     */
    public function testSetMultiServer()
    {
        $key   = 'testkey';
        $value = 'test value';
        $this->subject->addServer( $this->server2 );
        $this->server1->expectNever( 'send' );
        $this->server2->expectOnce( 'send' );
        $this->server2->setReturnValue( 'send', "OK\n" );
        try {
            $this->subject->set( $key, $value );
            $this->pass();
        } catch( SharedanceException $e ) {
            $this->fail();
        }
        $this->server2->tally();
    }//}}}
    /**{{{testSetMultiServerFailover
     */
    public function testSetMultiServerFailover()
    {
        $key   = 'testkey';
        $value = 'test data';
        $this->addExtraServers();

        $this->extra_servers[1]->expectOnce( 'send' );
        $this->extra_servers[1]->setReturnValue( 'send', "OK\n" );
        $this->server1->expectOnce( 'send' );
        $this->server1->setReturnValue( 'send', "OK\n" );

        $this->server2->expectNever( 'send' );
        $this->extra_servers[0]->expectNever( 'send' );
        try {
            $this->subject->set( $key, $value );
            $this->pass();
        } catch( SharedanceException $e ) {
            $this->fail();
        }
        $this->server1->tally();
        $this->extra_servers[1]->tally();
    }//}}}
    /**{{{testDelete
     */
    public function testDelete()
    {
        $key = 'testkey';
        $this->server1->expectOnce('send');
        $this->server1->setReturnValue( 'send', "OK\n" );
        try {
            $this->subject->delete( $key );
            $this->pass();
        } catch( SharedanceException $e ) {
            $this->fail();
        }
        $this->server1->tally();
    }//}}}
    /**{{{testDeleteMultiServer
     */
    public function testDeleteMultiServer()
    {
        $this->subject->addServer( $this->server2 );
        $key = 'testkey';
        $this->server1->expectNever( 'send' );
        $this->server2->expectOnce('send');
        $this->server2->setReturnValue( 'send', "OK\n" );
        try {
            $this->subject->delete( $key );
            $this->pass();
        } catch( SharedanceException $e ) {
            $this->fail();
        }
        $this->server2->tally();
    }//}}}
    /**{{{testDeleteMultiServerFailover
     */
    public function testDeleteMultiServerFailover()
    {
        $this->addExtraServers();

        $this->extra_servers[1]->expectOnce( 'send' );
        $this->extra_servers[1]->setReturnValue( 'send', "OK\n" );
        $this->server1->expectOnce( 'send' );
        $this->server1->setReturnValue( 'send', "OK\n" );

        $this->extra_servers[0]->expectNever( 'send' );
        $this->server2->expectNever( 'send' );

        try {
            $this->subject->delete( 'testkey' );
            $this->pass();
        } catch( SharedanceException $e ) {
            $this->fail();
        }
        $this->extra_servers[1]->tally();
        $this->server1->tally();
    }//}}}
}

$group->addTestClass( new testSharedance );

$group->run( new TextReporter );
