<?php
/**
 * Prototype Castable Object.. for DataObject queries
 *
 * Storage for Data that may be cast into a variety of formats.
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
 * @package    DB_DataObject
 * @author     Alan Knowles <alan@akbkhome.com>
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/DB_DataObject
 */
  
/**
*  
* Common usages:
*   // blobs
*   $data = DB_DataObject_Cast::blob($somefile);
*   $data = DB_DataObject_Cast::string($somefile);
*   $dataObject->someblobfield = $data
*
*   // dates?
*   $d1 = new DB_DataObject_Cast::date('12/12/2000');
*   $d2 = new DB_DataObject_Cast::date(2000,12,30);
*   $d3 = new DB_DataObject_Cast::date($d1->year, $d1->month+30, $d1->day+30);
*   
*   // time, datetime.. ?????????
*
*   // raw sql????
*    $data = DB_DataObject_Cast::sql('cast("123123",datetime)');
*    $data = DB_DataObject_Cast::sql('NULL');
*
*   // int's/string etc. are proably pretty pointless..!!!!
*
*   
*   inside DB_DataObject, 
*   if (is_a($v,'db_dataobject_class')) {
*           $value .= $v->toString(DB_DATAOBJECT_INT,'mysql');
*   }
*
*
*
*

*/ 
class DB_DataObject_Cast {
        
    /**
    * Type of data Stored in the object..
    *
    * @var string       (date|blob|.....?)
    * @access public        
    */
    var $type;
        
    /**
    * Data For date representation
    *
    * @var int  day/month/year
    * @access public
    */
    var $day;
    var $month;
    var $year;

    
    /**
    * Generic Data..
    *
    * @var string
    * @access public
    */

    var $value;



    /**
    * Blob consructor
    *
    * create a Cast object from some raw data.. (binary)
    * 
    * 
    * @param   string (with binary data!)
    *
    * @return   object DB_DataObject_Cast
    * @access   public 
    */
  
    function blob($value) {
        $r = new DB_DataObject_Cast;
        $r->type = 'blob';
        $r->value = $value;
        return $r;
    }


    /**
    * String consructor (actually use if for ints and everything else!!!
    *
    * create a Cast object from some string (not binary)
    * 
    * 
    * @param   string (with binary data!)
    *
    * @return   object DB_DataObject_Cast
    * @access   public 
    */
  
    function string($value) {
        $r = new DB_DataObject_Cast;
        $r->type = 'string';
        $r->value = $value;
        return $r;
    }
    
    /**
    * SQL constructor (for raw SQL insert)
    *
    * create a Cast object from some sql
    * 
    * @param   string (with binary data!)
    *
    * @return   object DB_DataObject_Cast
    * @access   public 
    */
  
    function sql($value) 
    {
        $r = new DB_DataObject_Cast;
        $r->type = 'sql';
        $r->value = $value;
        return $r;
    }


    /**
    * Date Constructor
    *
    * create a Cast object from some string (not binary)
    * NO VALIDATION DONE, although some crappy re-calcing done!
    * 
    * @param   vargs... accepts
    *       dd/mm
    *       dd/mm/yyyy
    *       yyyy-mm
    *       yyyy-mm-dd
    *       array(yyyy,dd)
    *       array(yyyy,dd,mm)
    *
    *
    *
    * @return   object DB_DataObject_Cast
    * @access   public 
    */
  
    function date() 
    {  
        $args = func_get_args();
        switch(count($args)) {
            case 0: // no args = today!
               $bits =  explode('-',date('Y-m-d'));
                break;
            case 1: // one arg = a string 
            
                if (strpos($args[0],'/') !== false) {
                    $bits = array_reverse(explode('/',$args[0]));
                } else {
                    $bits = explode('-',$args[0]);
                }
                break;
            default: // 2 or more..
                $bits = $args;
        }
        if (count($bits) == 1) { // if YYYY set day = 1st..
            $bits[] = 1;
        }
        
        if (count($bits) == 2) { // if YYYY-DD set day = 1st..
            $bits[] = 1;
        }
        
        // if year < 1970 we cant use system tools to check it...
        // so we make a few best gueses....
        // basically do date calculations for the year 2000!!!
        // fix me if anyone has more time...
        if (($bits[0] < 1975) || ($bits[0] > 2030)) {
            $oldyear = $bits[0];
            $bits = explode('-',date('Y-m-d',mktime(1,1,1,$bits[1],$bits[2],2000)));
            $bits[0] = ($bits[0] - 2000) + $oldyear;
        } else {
            // now mktime
            $bits = explode('-',date('Y-m-d',mktime(1,1,1,$bits[1],$bits[2],$bits[0])));
        }
        $r = new DB_DataObject_Cast;
        $r->type = 'date';
        list($r->year,$r->month,$r->day) = $bits;
        return $r;
    }
    
   

    /**
    * Data For time representation ** does not handle timezones!!
    *
    * @var int  hour/minute/second
    * @access public
    */
    var $hour;
    var $minute;
    var $second;

    
    /**
    * DateTime Constructor
    *
    * create a Cast object from a Date/Time
    * Maybe should accept a Date object.!
    * NO VALIDATION DONE, although some crappy re-calcing done!
    * 
    * @param   vargs... accepts
    *              noargs (now)
    *              yyyy-mm-dd HH:MM:SS (Iso)
    *              array(yyyy,mm,dd,HH,MM,SS) 
    *
    *
    * @return   object DB_DataObject_Cast
    * @access   public 
    * @author   therion 5 at hotmail
    */
    
    function dateTime()
    {
        $args = func_get_args();
        switch(count($args)) {
            case 0: // no args = now!
                $datetime = date('Y-m-d G:i:s', mktime());
            
            case 1:
                // continue on from 0 args.
                if (!isset($datetime)) {
                    $datetime = $args[0];
                }
                
                $parts =  explode(' ', $datetime);
                $bits = explode('-', $parts[0]);
                $bits = array_merge($bits, explode(':', $parts[1]));
                break;
                
            default: // 2 or more..
                $bits = $args;
                
        }

        if (count($bits) != 6) {
            // PEAR ERROR?
            return false;
        }
        
        $r = DB_DataObject_Cast::date($bits[0], $bits[1], $bits[2]);
        if (!$r) {
            return $r; // pass thru error (False) - doesnt happen at present!
        }
        // change the type!
        $r->type = 'datetime';
        
        // should we mathematically sort this out.. 
        // (or just assume that no-one's dumb enough to enter 26:90:90 as a time!
        $r->hour = $bits[3];
        $r->minute = $bits[4];
        $r->second = $bits[5];
        return $r;

    }



    /**
    * time Constructor
    *
    * create a Cast object from a Date/Time
    * Maybe should accept a Date object.!
    * NO VALIDATION DONE, and no-recalcing done!
    *
    * @param   vargs... accepts
    *              noargs (now)
    *              HH:MM:SS (Iso)
    *              array(HH,MM,SS)    
    *
    *
    * @return   object DB_DataObject_Cast
    * @access   public 
    * @author   therion 5 at hotmail
    */
    function time()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 0: // no args = now!
                $time = date('G:i:s', mktime());
                
            case 1:
                // continue on from 0 args.
                if (!isset($time)) {
                    $time = $args[0];
                }
                $bits =  explode(':', $time);
                break;
                
            default: // 2 or more..
                $bits = $args;
                
        }
        
        if (count($bits) != 3) {
            return false;
        }
        
        // now take data from bits into object fields
        $r = new DB_DataObject_Cast;
        $r->type = 'time';
        $r->hour = $bits[0];
        $r->minute = $bits[1];
        $r->second = $bits[2];
        return $r;

    }

  
  
    /**
    * get the string to use in the SQL statement for this...
    *
    * 
    * @param   int      $to Type (DB_DATAOBJECT_*
    * @param   object   $db DB Connection Object
    * 
    *
    * @return   string 
    * @access   public
    */
  
    function toString($to=false,$db) 
    {
        // if $this->type is not set, we are in serious trouble!!!!
        // values for to:
        $method = 'toStringFrom'.$this->type;
        return $this->$method($to,$db);
    }
    
    /**
    * get the string to use in the SQL statement from a blob of binary data 
    *   ** Suppots only blob->postgres::bytea
    *
    * @param   int      $to Type (DB_DATAOBJECT_*
    * @param   object   $db DB Connection Object
    * 
    *
    * @return   string 
    * @access   public
    */
    function toStringFromBlob($to,$db) 
    {
        // first weed out invalid casts..
        // in blobs can only be cast to blobs.!
        
        // perhaps we should support TEXT fields???
        
        if (!($to & DB_DATAOBJECT_BLOB)) {
            return PEAR::raiseError('Invalid Cast from a DB_DataObject_Cast::blob to something other than a blob!');
        }
        
        switch ($db->dsn["phptype"]) {
            case 'pgsql':
                return "'".pg_escape_bytea($this->value)."'::bytea";
                
            case 'mysql':
                return "'".mysql_real_escape_string($this->value,$db->connection)."'";
            
            case 'mysqli':
                // this is funny - the parameter order is reversed ;)
                return "'".mysqli_real_escape_string($db->connection, $this->value)."'";
             
            
                 
            default:
                return PEAR::raiseError("DB_DataObject_Cast cant handle blobs for Database:{$db->dsn['phptype']} Yet");
        }
    
    }
    
    /**
    * get the string to use in the SQL statement for a blob from a string!
    *   ** Suppots only string->postgres::bytea
    * 
    *
    * @param   int      $to Type (DB_DATAOBJECT_*
    * @param   object   $db DB Connection Object
    * 
    *
    * @return   string 
    * @access   public
    */
    function toStringFromString($to,$db) 
    {
        // first weed out invalid casts..
        // in blobs can only be cast to blobs.!
        
        // perhaps we should support TEXT fields???
        // 
        
        if (!($to & DB_DATAOBJECT_BLOB)) {
            return PEAR::raiseError('Invalid Cast from a DB_DataObject_Cast::string to something other than a blob!'.
                ' (why not just use native features)');
        }
        
        switch ($db->dsn['phptype']) {
            case 'pgsql':
                return "'".pg_escape_string($this->value)."'::bytea";
            
            case 'mysql':
                return "'".mysql_real_escape_string($this->value,$db->connection)."'";
            
            
            case 'mysqli':
                return "'".mysqli_real_escape_string($db->connection, $this->value)."'";

            
            default:
                return PEAR::raiseError("DB_DataObject_Cast cant handle blobs for Database:{$db->dsn['phptype']} Yet");
        }
    
    }
    
    
    /**
    * get the string to use in the SQL statement for a date
    *   
    * 
    *
    * @param   int      $to Type (DB_DATAOBJECT_*
    * @param   object   $db DB Connection Object
    * 
    *
    * @return   string 
    * @access   public
    */
    function toStringFromDate($to,$db) 
    {
        // first weed out invalid casts..
        // in blobs can only be cast to blobs.!
         // perhaps we should support TEXT fields???
        // 
        
        if (($to !== false) && !($to & DB_DATAOBJECT_DATE)) {
            return PEAR::raiseError('Invalid Cast from a DB_DataObject_Cast::string to something other than a date!'.
                ' (why not just use native features)');
        }
        return "'{$this->year}-{$this->month}-{$this->day}'";
    }
    
    /**
    * get the string to use in the SQL statement for a datetime
    *   
    * 
    *
    * @param   int     $to Type (DB_DATAOBJECT_*
    * @param   object   $db DB Connection Object
    * 
    *
    * @return   string 
    * @access   public
    * @author   therion 5 at hotmail
    */
    
    function toStringFromDateTime($to,$db) 
    {
        // first weed out invalid casts..
        // in blobs can only be cast to blobs.!
        // perhaps we should support TEXT fields???
        if (($to !== false) && 
            !($to & (DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME))) {
            return PEAR::raiseError('Invalid Cast from a ' .
                ' DB_DataObject_Cast::dateTime to something other than a datetime!' .
                ' (try using native features)');
        }
        return "'{$this->year}-{$this->month}-{$this->day} {$this->hour}:{$this->minute}:{$this->second}'";
    }

    /**
    * get the string to use in the SQL statement for a time
    *   
    * 
    *
    * @param   int     $to Type (DB_DATAOBJECT_*
    * @param   object   $db DB Connection Object
    * 
    *
    * @return   string 
    * @access   public
    * @author   therion 5 at hotmail
    */

    function toStringFromTime($to,$db) 
    {
        // first weed out invalid casts..
        // in blobs can only be cast to blobs.!
        // perhaps we should support TEXT fields???
        if (($to !== false) && !($to & DB_DATAOBJECT_TIME)) {
            return PEAR::raiseError('Invalid Cast from a' . 
                ' DB_DataObject_Cast::time to something other than a time!'.
                ' (try using native features)');
        }
        return "'{$this->hour}:{$this->minute}:{$this->second}'";
    }
  
    /**
    * get the string to use in the SQL statement for a raw sql statement.
    *
    * @param   int      $to Type (DB_DATAOBJECT_*
    * @param   object   $db DB Connection Object
    * 
    *
    * @return   string 
    * @access   public
    */
    function toStringFromSql($to,$db) 
    {
        return $this->value; 
    }
    
    
    
    
}

