<?php
//--------------------------------------------------------------------------------
// Copyright 2003 Procata, Inc.
// Released under the LGPL license (http://www.gnu.org/copyleft/lesser.html)
//--------------------------------------------------------------------------------
/**
* @package WACT_DB
* @version $Id: dbqueryinterface.inc.php,v 1.2 2004/03/04 22:21:09 quipo Exp $
*/
//--------------------------------------------------------------------------------
/**
* This class defines an interface for performing more complex queries, such as
* stored procedure calls or where transactions are required. It is not intended
* to be used directly but rather defines an interface you can implement with your
* own class. It allows you to tunnel through the abstraction the WACT DBC API
* provides to make native calls to the database driver you are using.
*
* For example, inserting a blob into Oracle using the ADOdb driver;
* <code>
* class InsertBlob {  // implements DBCQueryInterace
*     var $filename;
*     var $type;
*     var $blob;
*     function execute(& $conn) {
*
*         // Note empty_blob() is an Oracle function
*         $sql = "INSERT INTO images
*                     ('filename','type','contents')
*                 VALUES
*                     ('".$this->filename."','".$this->type."',empty_blob())";
*
*         // Prepare the table for the blob
*         if ( !$conn->Execute($sql) ) {
*             return FALSE;
*         }
*
*         // Update the blob field with the binary data - see ADOdb oci8 driver
*         $res = & $conn->UpdateBlob('images','content',$this->blob,
*             "filename='.$this->filename.'",'BLOB');
*
*         return $res;
*     }
* }
*
* $SQL = new InsertBlob();
* $SQL->filename = 'mypic.png';
* $SQL->type = 'image/png';
* $SQL->blob = file_get_contents('mypic.png');
* $res = DBC::execute($SQL);
* </code>
* Note that objects implementing the DBCQueryInterface are passed as a copy,
* not a reference to the database driver.
* methods
* @see http://wact.sourceforge.net/index.php/DBCQueryInterface
* @access public
* @package WACT_DB
*/
class DBCQueryInterface {

	/**
	* Return the current database connection managed by this class
	* @param mixed the connection object / resource for the driver you are using
	* @return mixed result object or result resource, depending on DB driver used
	* @access public
	*/
	function &execute(& $conn) {}

}

?>