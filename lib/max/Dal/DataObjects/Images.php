<?php
/**
 * Table Definition for images
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Images extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'images';                          // table name
    public $image_id;                        // int(11)  not_null primary_key auto_increment
    public $filename;                        // string(128)  not_null
    public $contents;                        // blob(-1)  not_null blob binary
    public $t_stamp;                         // datetime(19)  binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Images',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    /**
     * Table has no autoincrement/sequence so we override sequenceKey().
     *
     * @return array
     */
    function sequenceKey() {
        return array(false, false, false);
    }
    
    function getUniqueFileNameForDuplication()
    {
        $extension = substr($this->filename, strrpos($this->filename, ".") + 1);
	    $base	   = substr($this->filename, 0, strrpos($this->filename, "."));
        
        if (eregi("^(.*)_([0-9]+)$", $base, $matches)) {
			$base = $matches[1];
			$i = $matches[2];
        } 
        
        $doCheck = $this->factory($this->_tableName);
        $names = $doCheck->getUniqueValuesFromColumn('filename');
        // Get unique name
        $i = 2;
        while (in_array($base.'_'.$i . '.' .$extension, $names)) {
            $i++;
        }
        return $base . '_' . $i . '.' . $extension;
    }
    
    /**
     * Overrides _refreshUpdated() because the updated field is called t_stamp.
     * This method is called on insert() and update().
     *
     */
    function _refreshUpdated()
    {
        $this->t_stamp = date('Y-m-d H:i:s');
    }
}
