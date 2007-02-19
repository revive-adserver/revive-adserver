<?php
// {{{ MDB2_Connect_Test
/**
 * This is just a dummy class to perform the tests.
 */
class MDB2_Connect_Test
{
    var $_dsn;
    var $dbc;

    // {{{ constructor php5 valid
    /**
     * Straightforward? The constructor
     */
    function __construct()
    {
        require_once 'MDB2.php';
        require_once 'config.php';

        $this->_dsn = array(
                'phptype'  => DSN_PHPTYPE,
                'username' => DSN_USERNAME,
                'password' => DSN_PASSWORD,
                'hostspec' => DSN_HOSTNAME,
                'database' => DSN_DATABASE,
        );

    }
    // }}}
    // {{{ PHP4 constructor..
    function MDB2_Connect_Test()
    {
        $this->__construct($connect);
    }
    // }}}
    // {{{ connect
    function connect()
    {
        // connect to database
        $options = array(
            'portability' => (MDB2_PORTABILITY_ALL ^ MDB2_PORTABILITY_EMPTY_TO_NULL),
        );

        $this->dbc =& MDB2::singleton($this->_dsn, $options);
        if (PEAR::isError($this->dbc)) {
            return $this->dbc;
        }
    }
    // }}}
}
// }}}
?>