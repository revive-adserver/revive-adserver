<?php
/**
 * An object oriented interface to the Sharedance cache server.
 *
 * @see sharedance.example.php
 * 
 * @author Rob Young <bubblenut@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

/**
 * Generic exception used for all errors
 */
class SharedanceException extends Exception {}

/**
 *
 * Class to represent a Sharedance server. It is instances of this
 * class which are added to your main Sharedance object.
 *
 * @see Sharedance
 *
 * @author Rob Young <bubblenut@gmail.com>
 * @since 2006-09-08
 * @version 0.2
 */
class SharedanceServer
{
    /**{{{constants
     */
    const
        DEFAULT_PORT    = 1042,
        DEFAULT_TIMEOUT = 10,
        DEFAULT_WEIGHT  = 1;
    //}}}
    /**{{{properties:private
     */
    private
        $host, $port, $timeout, $weight, $socket, $closed=false;
    //}}}
    /**{{{__construct
     *
     * Set up and connect
     *
     * @param string $host
     * @param int    $port
     * @param int    $timeout
     * @param int    $weight
     */
    public function __construct( $host, $port = self::DEFAULT_PORT, $timeout = self::DEFAULT_TIMEOUT, $weight = self::DEFAULT_WEIGHT )
    {
        $this->host    = $host;
        $this->port    = $port;
        $this->timeout = $timeout;
        $this->weight  = $weight;
    }//}}}
    /**{{{SharedanceServer
     *
     * Facade method for simpletest's PHP4 bc
     */
    public function SharedanceServer( )
    {
        //$this->__construct( $host, $port, $timeout, $weight );
    }//}}}
    /**{{{_connect
     *
     * Connect to the server
     *
     * @throws SharedanceException
     */
    private function _connect()
    {
        if(!is_resource($this->socket) && !$this->closed) {
            $errno = $errstr = null;
            $socket = @fsockopen( $this->host, $this->port, $errno, $errstr, $this->timeout );
    
            if(!$socket) {
                throw new SharedanceException( 'Failed to connect on ' . $this->__toString() . ' "' . $errstr . '"' );
            }
            $this->socket = $socket;
        }
    }//}}}
    /**{{{close
     *
     * Close the connection
     *
     * @return void
     * @throws SharedanceException
     */
    function close()
    {
        if(is_resource( $this->socket )) {
            fclose( $this->socket );
            $this->socket = false;
        }
        $this->closed = true;
    }//}}}
    /**{{{send
     *
     * Send a command to the server. 
     *
     * @param string $command
     * @return void
     * @throws SharedanceException
     */
    function send( $command )
    {
        $this->_connect();
        $res = @fwrite( $this->socket, $command );
        if( !$res ) {
            throw new SharedanceException( 'Failed to send command to ' . $this->__toString() );
        }
        $data = '';
        while(!feof($this->socket)) {
            $data .= fread( $this->socket, 4096 );
        }
        $this->close();
        return $data;
    }//}}}
    /**{{{__toString
     *
     * Make the error strings a little easier
     *
     */
    public function __toString()
    {
        return '[' . $this->host . ':' . $this->port . ']';
    }//}}}
    /**{{{__get
     *
     */
    function __get( $key )
    {
        if(isset($this->$key) && $key!='socket') {
            return $this->$key;
        }
    }//}}}
    /**{{{__destruct
     *
     * Just make sure that the connection get's closed properly
     *
     */
    function __destruct()
    {
        $this->close();
    }//}}}
}

/**
 *
 * The main Sharedance class, this is what you'd use to 
 * get things out of your sharedance repository
 *
 * @author Rob Young <bubblenut@gmail.com>
 * @since 2006-09-08
 * @verson 0.2
 */
class Sharedance
{
    /**{{{constants
     */
    const ROTATE_FORWARDS  = 1;
    const ROTATE_BACKWARDS = 2;
    //}}}
    /**{{{properties:private
     */
    private
        /**
         * List of all servers
         * @var SharedanceServer[]
         */
        $servers = array(),
        /**
         * List of buckets. Each server appears in here as many times as is
         * defined by it's weight
         * @var SharedanceServer[]
         */
        $buckets = array(),
        /**
         * Whether or not to attempt redundant writes and fail over reads
         * @var boolean
         */
        $redundancy,
        /**
         * The highest server weight encountered yet
         * @var int
         */
        $max_weight = 0,
        /**
         * The amount the bucket list must be rotated to garuntee hitting
         * a new server (null if it is not possible)
         */
        $rotation = null;
    //}}}
    /**{{{__construct
     *
     * @param boolean $redundancy=false
     */
    public function __construct( $redundancy=false )
    {
        if( !is_bool( $redundancy ) ) {
            throw SharedanceException( "Redundancy is a switch, non boolean value given" );
        }
        $this->redundancy = $redundancy;
    }//}}}
    /**{{{addServer
     *
     * Add a server to the list
     *
     * @param SharedanceServer $server
     * @return void
     * @throws SharedanceException
     */
    public function addServer( SharedanceServer $server )
    {
        $this->servers[] = $server;
        
        for($i=0; $i<$server->weight; $i++) {
            $this->buckets[] = $server;
        }
        if( $this->redundancy ) {
            $this->_calculateRotation( $server );
        }
    }//}}}
    /**{{{_calculateRotation
     *
     * Calculate whether bucket rotation is possible and if it is
     * how many points the list must be rotated to garuntee a new
     * server
     *
     * @since 2006-11-05
     *
     * @param SharedanceServer $server
     */
    protected function _calculateRotation( SharedanceServer $server )
    {
        if( $server->weight > $this->max_weight ) {
            $this->max_weight = $server->weight;
        }
        if( $this->max_weight < count( $this->servers ) ) {
            $this->rotation = $this->max_weight;
        } else {
            $this->rotation = null;
        }
    }//}}}
    /**{{{_rotateBuckets
     *
     * Take items from one end of the bucket list and add them onto the other end 
     * a certain number of times (determined by _calculateRotation). This means
     * the when _getServer is called a predictably different server is returned
     *
     * @since 2006-11-05
     *
     * @param int $direction
     * @throws InvalidArgumentException
     */
    protected function _rotateBuckets( $direction )
    {
        if( !$this->rotation ) {
            throw new SharedanceException( "Bucket rotation not allowed" );
        }
        switch( $direction ) {
            case self::ROTATE_FORWARDS:
                for( $i=0; $i<$this->rotation; $i++ ) {
                    $this->buckets[] = array_shift( $this->buckets );
                }
                break;
            case self::ROTATE_BACKWARDS:
                for( $i=0; $i<$this->rotation; $i++ ) {
                    array_unshift( $this->buckets, array_pop( $this->buckets ) );
                }
                break;
            default:
                throw InvalidArgumentException( "Unrecognized direction" );
        }
    }//}}}
    /**{{{connect
     *
     * Set a single server to the list. This removes all previously added servers
     *
     * @param SharedanceServer $server
     * @return void
     * @throws SharedanceException
     */
    public function connect( SharedanceServer $server )
    {
        $this->servers = array( $server );
        $this->buckets = array( $server );
    }//}}}
    /**{{{close
     *
     * Close down all the servers
     *
     * @throws SharedanceException
     */
    public function close()
    {
        $pass = true;
        foreach( $this->servers as $server ) {
            $pass = ( $server->close() ? $pass : false );
        }
        if( !$pass ) {
            throw new SharedanceException( 'Could not close all connections' );
        } else {
            $this->servers = $this->buckets = array();
        }
    }//}}}
    /**{{{_getServer
     *
     * Get the server to be used for a specific key
     *
     * @param string $key
     * @return SharedanceServer
     * @throws SharedanceException
     */
    protected function _getServer( $key, $show=false )
    {
        if( $this->buckets ) {
            $hash = 0;
            for($i = 0, $l = strlen( $key ); $i < $l; $i++ ) {
                $hash = (int) (( $hash * 33 ) + ord( $key[$i] )) & 0x7fffffff;
            }
            $bucket = $hash % count($this->buckets);
            return $this->buckets[ $bucket ];
        }
        throw new SharedanceException('No Servers Registered');
    }//}}}
    /**{{{get
     *
     * Get an item from the cache
     *
     * @param string $key
     * @return string
     * @throws SharedanceException
     */
    public function get( $key )
    {
        try {
            $server = $this->_getServer( $key );
            $command = 'F' . pack('N', strlen($key)) . $key;
            $response = $server->send( $command );
        } catch( SharedanceException $e ) {
            if( !$this->redundancy ) {
                throw $e;
            } else {
                try {
                    $this->_rotateBuckets( self::ROTATE_FORWARDS );
                    $server = $this->_getServer( $key );
                    $response = $server->send( $command );
                    $this->_rotateBuckets( self::ROTATE_BACKWARDS );
                } catch( SharedanceException $e1 ) {
                    // no finally clause so it must be done manually
                    $this->_rotateBuckets( self::ROTATE_BACKWARDS );
                    throw $e1;
                }
            }
        }
        if($response === '') {
            return false;
        }
        return $response;
    }//}}}
    /**{{{set
     *
     * Set an item into the cache
     *
     * @param string $key
     * @param string $data
     * @return void
     * @throws SharedanceException
     */
    function set( $key, $data )
    {
        $caught_exception = null;
        $server = $this->_getServer( $key );
        $command = 'S' . pack('NN', strlen( $key ), strlen( $data )) . $key . $data;
        // When working redundantly it must be garunteed that the
        // operation is attempted on both servers
        try {
            $response1 = $server->send( $command );
        } catch( SharedanceException $e ) {
            $caught_exception = $e;
        }
        if( !$this->redundancy ) {
            $response2 = "no";
        } else {
            try {
                $this->_rotateBuckets( self::ROTATE_FORWARDS );
                $server = $this->_getServer( $key );
                $response2 = $server->send( $command );
                $this->_rotateBuckets( self::ROTATE_BACKWARDS );
            } catch( SharedanceException $e ) {
                $this->_rotateBuckets( self::ROTATE_BACKWARDS );
                throw $e;
            }
        }
        if( $caught_exception ) {
            throw $caught_exception;
        }
        if( $response1 != "OK\n" && $response2 != "OK\n" ) {
            throw new SharedanceException( 'Failed to write data to ' . $server . ' [' . $response . ']' );
        }
    }//}}}
    /**{{{delete
     *
     * Delete an item from the cache
     *
     * @param string $key
     * @return void
     * @throws SharedanceException
     */
    function delete( $key )
    {
        $caught_exception = null;
        $server = $this->_getServer( $key );
        $command= 'D' . pack('N', strlen( $key )) . $key;
        // When working redundantly it must be garunteed that the
        // operation is attempted on both servers
        try {
            $response1 = $server->send( $command );
        } catch( SharedanceException $e ) {
            $caught_exception = $e;
        }
        if( !$this->redundancy ) {
            $response2 = "OK\n";
        } else {
            try {
                $this->_rotateBuckets( self::ROTATE_FORWARDS );
                $server = $this->_getServer( $key );
                $response2 = $server->send( $command );
                $this->_rotateBuckets( self::ROTATE_BACKWARDS );
            } catch( SharedanceException $e ) {
                $this->_rotateBuckets( self::ROTATE_BACKWARDS );
                throw $e;
            }
        }
        if( $caught_exception ) {
            throw $caught_exception;
        }
        if( $response1 != "OK\n" || $response2 != "OK\n" ) {
            throw new SharedanceException( 'Failed to delete from ' . $server . '[' . $response . ']' );
        }
    }//}}}
}
