<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Contains the DB_QueryTool_Result_Row and DB_QueryTool_Result_Object classes
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
 * @author     Roman Dostovalov, Com-tec-so S.A.<roman.dostovalov@ctco.lv>
 * @copyright  2004-2005 Roman Dostovalov
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/DB_QueryTool
 */

/**
 * Include parent class
 */
require_once 'DB/QueryTool/Result.php';

/**
 * DB_QueryTool_Result_Row class
 *
 * @category   Database
 * @package    DB_QueryTool
 * @author     Roman Dostovalov, Com-tec-so S.A.<roman.dostovalov@ctco.lv>
 * @copyright  2004-2005 Roman Dostovalov
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @link       http://pear.php.net/package/DB_QueryTool
 */
class DB_QueryTool_Result_Row
{
	/**
	 * create object properties from the array
	 * @param array
	 */
	function DB_QueryTool_Result_Row($arr)
	{
        foreach ($arr as $key => $value) {
		    $this->$key = $value;
        }
	}
}

// -----------------------------------------------------------------------------

/**
 * DB_QueryTool_Result_Object class
 *
 * @category   Database
 * @package    DB_QueryTool
 * @author     Roman Dostovalov, Com-tec-so S.A.<roman.dostovalov@ctco.lv>
 * @copyright  2004-2005 Roman Dostovalov
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @link       http://pear.php.net/package/DB_QueryTool
 */
class DB_QueryTool_Result_Object extends DB_QueryTool_Result
{
    // {{{ fetchRow

	/**
	 * This function emulates PEAR::DB fetchRow() method
	 * With this function DB_QueryTool can transparently replace PEAR::DB
	 *
	 * @todo implement fetchmode support?
	 * @access    public
	 * @return    void
	 */
	function fetchRow()
	{
		$arr = $this->getNext();
		if (!PEAR::isError($arr)) {
		    $row = new DB_QueryTool_Result_Row($arr);
			return $row;
		}
		return false;
	}

	// }}}
}
?>