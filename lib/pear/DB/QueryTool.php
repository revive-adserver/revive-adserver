<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Contains the DB_QueryTool class
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Database
 * @package    DB_QueryTool
 * @author     Wolfram Kriesing <wk@visionp.de>
 * @author     Paolo Panto <wk@visionp.de>
 * @copyright  2003-2005 Wolfram Kriesing, Paolo Panto
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @link       http://pear.php.net/package/DB_QueryTool
 */

/**
 * require the DB_QueryTool_EasyJoin class
 */
require_once 'DB/QueryTool/EasyJoin.php';

/**
 * MDB_QueryTool class
 *
 * This class should be extended; it's here to make it easy using the base
 * class of the package by its package name.
 * Since I tried to seperate the functionality a bit inside the
 * really working classes i decided to have this class here just to
 * provide the name, since the functionality inside the other
 * classes might be restructured a bit but this name always stays.
 *
 * @category   Database
 * @package    DB_QueryTool
 * @author     Wolfram Kriesing <wk@visionp.de>
 * @copyright  2003-2005 Wolfram Kriesing
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @link       http://pear.php.net/package/DB_QueryTool
 */
class DB_QueryTool extends DB_QueryTool_EasyJoin
{
    // {{{ DB_QueryTool()

    /**
     * call parent constructor
     * @param mixed $dsn DSN string, DSN array or DB object
     * @param array $options
     */
    function __construct($dsn=false, $options=array())
    {
        parent::__construct($dsn, $options);
    }

    // }}}
}
?>