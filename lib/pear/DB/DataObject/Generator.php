<?php
/**
 * Generation tools for DB_DataObject
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
 * @link       http://pear.php.net/package/DB_DataObject
 */

 /*
 * Security Notes:
 *   This class uses eval to create classes on the fly.
 *   The table name and database name are used to check the database before writing the
 *   class definitions, we now check for quotes and semi-colon's in both variables
 *   so I cant see how it would be possible to generate code even if
 *   for some crazy reason you took the classname and table name from User Input.
 *
 *   If you consider that wrong, or can prove it.. let me know!
 */

 /**
 *
 * Config _$ptions
 * [DB_DataObject_Generator]
 * ; optional default = DB/DataObject.php
 * extends_location =
 * ; optional default = DB_DataObject
 * extends =
 * ; alter the extends field when updating a class (defaults to only replacing DB_DataObject)
 * generator_class_rewrite = ANY|specific_name   // default is DB_DataObject
 *
 */

/**
 * Needed classes
 * We lazy load here, due to problems with the tests not setting up include path correctly.
 * FIXME!
 */
class_exists('DB_DataObject') ? '' : require_once 'DB/DataObject.php';
//require_once('Config.php');

/**
 * Generator class
 *
 * @package DB_DataObject
 */
class DB_DataObject_Generator extends DB_DataObject
{
    /* =========================================================== */
    /*  Utility functions - for building db config files           */
    /* =========================================================== */

    /**
     * Array of table names
     *
     * @var array
     * @access private
     */
    var $tables;

    /**
     * associative array table -> array of table row objects
     *
     * @var array
     * @access private
     */
    var $_definitions;

    /**
     * active table being output
     *
     * @var string
     * @access private
     */
    var $table; // active tablename


    /**
     * The 'starter' = call this to start the process
     *
     * @access  public
     * @return  none
     */
    function start()
    {
        $options = &PEAR::getStaticProperty('DB_DataObject','options');
        $db_driver = empty($options['db_driver']) ? 'DB' : $options['db_driver'];

        $databases = array();
        foreach($options as $k=>$v) {
            if (substr($k,0,9) == 'database_') {
                $databases[substr($k,9)] = $v;
            }
        }

        if (isset($options['database'])) {
            if ($db_driver == 'DB') {
                require_once 'DB.php';
                $dsn = DB::parseDSN($options['database']);
            } else {
                require_once 'MDB2.php';
                $dsn = MDB2::parseDSN($options['database']);
            }

            if (!isset($database[$dsn['database']])) {
                $databases[$dsn['database']] = $options['database'];
            }
        }

        foreach($databases as $databasename => $database) {
            if (!$database) {
                continue;
            }
            $this->debug("CREATING FOR $databasename\n");
            $class = get_class($this);
            $t = new $class;
            $t->_database_dsn = $database;


            $t->_database = $databasename;
            if ($db_driver == 'DB') {
                require_once 'DB.php';
                $dsn = DB::parseDSN($database);
            } else {
                require_once 'MDB2.php';
                $dsn = MDB2::parseDSN($database);
            }

            if (($dsn['phptype'] == 'sqlite') && is_file($databasename)) {
                $t->_database = basename($t->_database);
            }
            $t->_createTableList();

            foreach(get_class_methods($class) as $method) {
                if (substr($method,0,8 ) != 'generate') {
                    continue;
                }
                $this->debug("calling $method");
                $t->$method();
            }
        }
        $this->debug("DONE\n\n");
    }

    /**
     * Output File was config object, now just string
     * Used to generate the Tables
     *
     * @var    string outputbuffer for table definitions
     * @access private
     */
    var $_newConfig;

    /**
     * Build a list of tables;
     * and store it in $this->tables and $this->_definitions[tablename];
     *
     * @access  private
     * @return  none
     */
    function _createTableList()
    {
        $this->_connect();
        $options = &PEAR::getStaticProperty('DB_DataObject','options');

        $__DB= &$GLOBALS['_DB_DATAOBJECT']['CONNECTIONS'][$this->_database_dsn_md5];

        $db_driver = empty($options['db_driver']) ? 'DB' : $options['db_driver'];
        $is_MDB2 = ($db_driver != 'DB') ? true : false;

        if (!$is_MDB2) {
            // try getting a list of schema tables first. (postgres)
            $__DB->expectError(DB_ERROR_UNSUPPORTED);
            $this->tables = $__DB->getListOf('schema.tables');
            $__DB->popExpect();
        } else {
            /**
             * set portability and some modules to fetch the informations
             */
            $__DB->setOption('portability', MDB2_PORTABILITY_ALL ^ MDB2_PORTABILITY_FIX_CASE);
            $__DB->loadModule('Manager');
            $__DB->loadModule('Reverse');
        }

        if ((empty($this->tables) || is_a($this->tables , 'PEAR_Error'))) {
            //if that fails fall back to clasic tables list.
            if (!$is_MDB2) {
                // try getting a list of schema tables first. (postgres)
                $__DB->expectError(DB_ERROR_UNSUPPORTED);
                $this->tables = $__DB->getListOf('tables');
                $__DB->popExpect();
            } else  {
                $this->tables = $__DB->manager->listTables();
                $sequences = $__DB->manager->listSequences();
                foreach ($sequences as $k => $v) {
                    $this->tables[] = $__DB->getSequenceName($v);
                }
            }
        }

        if (is_a($this->tables , 'PEAR_Error')) {
            return PEAR::raiseError($this->tables->toString(), null, PEAR_ERROR_DIE);
        }

        // build views as well if asked to.
        if (!empty($options['build_views'])) {
            if (!$is_MDB2) {
                $views = $__DB->getListOf('views');
            } else {
                $views = $__DB->manager->listViews();
            }
            if (is_a($views,'PEAR_Error')) {
                return PEAR::raiseError(
                'Error getting Views (check the PEAR bug database for the fix to DB), ' .
                $views->toString(),
                null,
                PEAR_ERROR_DIE
                );
            }
            $this->tables = array_merge ($this->tables, $views);
        }

        // declare a temporary table to be filled with matching tables names
        $tmp_table = array();


        foreach($this->tables as $table) {
            if (isset($options['generator_include_regex']) &&
            !preg_match($options['generator_include_regex'],$table)) {
                continue;
            } else if (isset($options['generator_exclude_regex']) &&
            preg_match($options['generator_exclude_regex'],$table)) {
                continue;
            }
            // postgres strip the schema bit from the
            if (!empty($options['generator_strip_schema'])) {
                $bits = explode('.', $table,2);
                $table = $bits[0];
                if (count($bits) > 1) {
                    $table = $bits[1];
                }
            }
            if (!$is_MDB2) {
                $defs =  $__DB->tableInfo($table);
            } else {
                $defs =  $__DB->reverse->tableInfo($table);
                // rename the length value, so it matches db's return.
                foreach ($defs as $k => $v) {
                    $defs[$k]['len'] = $defs[$k]['length'];
                }
            }

            if (is_a($defs,'PEAR_Error')) {
                // running in debug mode should pick this up as a big warning..
                $this->raiseError('Error reading tableInfo, '. $defs->toString());
                continue;
            }
            // cast all definitions to objects - as we deal with that better.



            foreach($defs as $def) {
                if (!is_array($def)) {
                    continue;
                }

                $this->_definitions[$table][] = (object) $def;

            }
            // we find a matching table, just  store it into a temporary array
            $tmp_table[] = $table;


        }
        // the temporary table array is now the right one (tables names matching
        // with regex expressions have been removed)
        $this->tables = $tmp_table;
        //print_r($this->_definitions);
    }

    /**
     * Auto generation of table data.
     *
     * it will output to db_oo_{database} the table definitions
     *
     * @access  private
     * @return  none
     */
    function generateDefinitions()
    {
        $this->debug("Generating Definitions file:        ");
        if (!$this->tables) {
            $this->debug("-- NO TABLES -- \n");
            return;
        }

        $options = &PEAR::getStaticProperty('DB_DataObject','options');


        //$this->_newConfig = new Config('IniFile');
        $this->_newConfig = '';
        foreach($this->tables as $this->table) {
            $this->_generateDefinitionsTable();
        }
        $this->_connect();
        // dont generate a schema if location is not set
        // it's created on the fly!
        if (empty($options['schema_location']) && empty($options["ini_{$this->_database}"]) ) {
            return;
        }
        if (!empty($options['generator_no_ini'])) { // built in ini files..
            return;
        }
        $base =  @$options['schema_location'];
        if (isset($options["ini_{$this->_database}"])) {
            $file = $options["ini_{$this->_database}"];
        } else {
            $file = "{$base}/{$this->_database}.ini";
        }

        if (!file_exists(dirname($file))) {
            require_once 'System.php';
            System::mkdir(array('-p','-m',0755,dirname($file)));
        }
        $this->debug("Writing ini as {$file}\n");
        touch($file);
        //print_r($this->_newConfig);
        $fh = fopen($file,'w');
        fwrite($fh,$this->_newConfig);
        fclose($fh);
        //$ret = $this->_newConfig->writeInput($file,false);

        //if (PEAR::isError($ret) ) {
        //    return PEAR::raiseError($ret->message,null,PEAR_ERROR_DIE);
        // }
    }

    /**
     * generate Foreign Keys (for links.ini)
     * Currenly only works with mysql / mysqli
     * to use, you must set option: generate_links=true
     *
     * @author Pascal Sch�ni
     */
    function generateForeignKeys()
    {
        $options = PEAR::getStaticProperty('DB_DataObject','options');
        if (empty($options['generate_links'])) {
            return false;
        }
        $__DB = &$GLOBALS['_DB_DATAOBJECT']['CONNECTIONS'][$this->_database_dsn_md5];
        if (!in_array($__DB->phptype, array('mysql','mysqli'))) {
            echo "WARNING: cant handle non-mysql introspection for defaults.";
            return; // cant handle non-mysql introspection for defaults.
        }

        $DB = $this->getDatabaseConnection();

        $fk = array();

        foreach($this->tables as $this->table) {
            $res =& $DB->query('SHOW CREATE TABLE ' . $this->table);
            if (PEAR::isError($res)) {
                die($res->getMessage());
            }

            $text = $res->fetchRow(DB_DEFAULT_MODE, 0);
            $treffer = array();
            // Extract FOREIGN KEYS
            preg_match_all(
                "/FOREIGN KEY \(`(\w*)`\) REFERENCES `(\w*)` \(`(\w*)`\)/i",
                $text[1],
                $treffer,
                PREG_SET_ORDER);

            if (count($treffer) < 1) {
                continue;
            }
            for ($i = 0; $i < count($treffer); $i++) {
                $fk[$this->table][$treffer[$i][1]] = $treffer[$i][2] . ":" . $treffer[$i][3];
            }

        }

        $links_ini = "";

        foreach($fk as $table => $details) {
            $links_ini .= "[$table]\n";
            foreach ($details as $col => $ref) {
                $links_ini .= "$col = $ref\n";
            }
            $links_ini .= "\n";
        }

        // dont generate a schema if location is not set
        // it's created on the fly!
        $options = PEAR::getStaticProperty('DB_DataObject','options');

        if (empty($options['schema_location'])) {
            return;
        }


        $file = "{$options['schema_location']}/{$this->_database}.links.ini";

        if (!file_exists(dirname($file))) {
            require_once 'System.php';
            System::mkdir(array('-p','-m',0755,dirname($file)));
        }

        $this->debug("Writing ini as {$file}\n");
        touch($file); // not sure why this is needed?
        $fh = fopen($file,'w');
        fwrite($fh,$links_ini);
        fclose($fh);
    }


    /**
     * The table geneation part
     *
     * @access  private
     * @return  tabledef and keys array.
     */
    function _generateDefinitionsTable()
    {
        global $_DB_DATAOBJECT;

        $defs = $this->_definitions[$this->table];
        $this->_newConfig .= "\n[{$this->table}]\n";
        $keys_out =  "\n[{$this->table}__keys]\n";
        $keys_out_primary = '';
        $keys_out_secondary = '';
        if (@$_DB_DATAOBJECT['CONFIG']['debug'] > 2) {
            echo "TABLE STRUCTURE FOR {$this->table}\n";
            print_r($defs);
        }
        $DB = $this->getDatabaseConnection();
        $dbtype = $DB->phptype;

        $ret = array(
                'table' => array(),
                'keys' => array(),
            );

        $ret_keys_primary = array();
        $ret_keys_secondary = array();



        foreach($defs as $t) {

            $n=0;
            $write_ini = true;

            switch (strtoupper($t->type)) {

                case 'INT':
                case 'INT2':    // postgres
                case 'INT4':    // postgres
                case 'INT8':    // postgres
                case 'SERIAL4': // postgres
                case 'SERIAL8': // postgres
                case 'INTEGER':
                case 'TINYINT':
                case 'SMALLINT':
                case 'MEDIUMINT':
                case 'BIGINT':
                    $type = DB_DATAOBJECT_INT;
                    if ($t->len == 1) {
                        $type +=  DB_DATAOBJECT_BOOL;
                    }
                    break;

                case 'REAL':
                case 'DOUBLE':
                case 'DOUBLE PRECISION': // double precision (firebird)
                case 'FLOAT':
                case 'FLOAT4': // real (postgres)
                case 'FLOAT8': // double precision (postgres)
                case 'DECIMAL':
                case 'MONEY':  // mssql and maybe others
                case 'NUMERIC':
                case 'NUMBER': // oci8
                    $type = DB_DATAOBJECT_INT; // should really by FLOAT!!! / MONEY...
                    break;

                case 'YEAR':
                    $type = DB_DATAOBJECT_INT;
                    break;

                case 'BIT':
                case 'BOOL':
                case 'BOOLEAN':

                    $type = DB_DATAOBJECT_BOOL;
                    // postgres needs to quote '0'
                    if ($dbtype == 'pgsql') {
                        $type +=  DB_DATAOBJECT_STR;
                    }
                    break;

                case 'STRING':
                case 'CHAR':
                case 'VARCHAR':
                case 'VARCHAR2':
                case 'TINYTEXT':

                case 'ENUM':
                case 'SET':         // not really but oh well
                case 'TIMESTAMPTZ': // postgres
                case 'BPCHAR':      // postgres
                case 'INTERVAL':    // postgres (eg. '12 days')

                case 'CIDR':        // postgres IP net spec
                case 'INET':        // postgres IP
                case 'MACADDR':     // postgress network Mac address.

                case 'INTEGER[]':   // postgres type
                case 'BOOLEAN[]':   // postgres type

                    $type = DB_DATAOBJECT_STR;
                    break;

                case 'TEXT':
                case 'MEDIUMTEXT':
                case 'LONGTEXT':

                    $type = DB_DATAOBJECT_STR + DB_DATAOBJECT_TXT;
                    break;


                case 'DATE':
                    $type = DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE;
                    break;

                case 'TIME':
                    $type = DB_DATAOBJECT_STR + DB_DATAOBJECT_TIME;
                    break;


                case 'DATETIME':
                    $type = DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME;
                    break;

                case 'TIMESTAMP': // do other databases use this???
                    $type = ($dbtype == 'mysql') ?
                        DB_DATAOBJECT_MYSQLTIMESTAMP :
                        DB_DATAOBJECT_STR + DB_DATAOBJECT_DATE + DB_DATAOBJECT_TIME;
                    break;


                case 'TINYBLOB':
                case 'BLOB':       /// these should really be ignored!!!???
                case 'MEDIUMBLOB':
                case 'LONGBLOB':
                case 'BYTEA':   // postgres blob support..
                    $type = DB_DATAOBJECT_STR + DB_DATAOBJECT_BLOB;
                    break;
                default:
                    echo "*****************************************************************\n".
                         "**               WARNING UNKNOWN TYPE                          **\n".
                         "** Found column '{$t->name}', of type  '{$t->type}'            **\n".
                         "** Please submit a bug, describe what type you expect this     **\n".
                         "** column  to be                                               **\n".
                         "*****************************************************************\n";
                    $write_ini = false;
                    break;
            }

            if (!strlen(trim($t->name))) {
                continue;
            }

            if (preg_match('/not[ _]null/i',$t->flags)) {
                $type += DB_DATAOBJECT_NOTNULL;
            }


            if (in_array($t->name,array('null','yes','no','true','false'))) {
                echo "*****************************************************************\n".
                     "**                             WARNING                         **\n".
                     "** Found column '{$t->name}', which is invalid in an .ini file **\n".
                     "** This line will not be writen to the file - you will have    **\n".
                     "** define the keys()/method manually.                          **\n".
                     "*****************************************************************\n";
                $write_ini = false;
            } else {
                $this->_newConfig .= "{$t->name} = $type\n";
            }

            $ret['table'][$t->name] = $type;
            // i've no idea if this will work well on other databases?
            // only use primary key or nextval(), cause the setFrom blocks you setting all key items...
            // if no keys exist fall back to using unique
            //echo "\n{$t->name} => {$t->flags}\n";
            if (preg_match("/(auto_increment|nextval\()/i",rawurldecode($t->flags))
                || (isset($t->autoincrement) && ($t->autoincrement === true))) {

                // native sequences = 2
                if ($write_ini) {
                    $keys_out_primary .= "{$t->name} = N\n";
                }
                $ret_keys_primary[$t->name] = 'N';

            } else if (preg_match("/(primary|unique)/i",$t->flags)) {
                // keys.. = 1
                $key_type = 'K';
                if (!preg_match("/(primary)/i",$t->flags)) {
                    $key_type = 'U';
                }

                if ($write_ini) {
                    $keys_out_secondary .= "{$t->name} = {$key_type}\n";
                }
                $ret_keys_secondary[$t->name] = $key_type;
            }


        }

        $this->_newConfig .= $keys_out . (empty($keys_out_primary) ? $keys_out_secondary : $keys_out_primary);
        $ret['keys'] = empty($keys_out_primary) ? $ret_keys_secondary : $ret_keys_primary;

        if (@$_DB_DATAOBJECT['CONFIG']['debug'] > 2) {
            print_r(array("dump for {$this->table}", $ret));
        }

        return $ret;


    }

    /**
    * Convert a table name into a class name -> override this if you want a different mapping
    *
    * @access  public
    * @return  string class name;
    */


    function getClassNameFromTableName($table)
    {
        $options = &PEAR::getStaticProperty('DB_DataObject','options');
        $class_prefix  = $options['class_prefix'];
        return  $class_prefix.preg_replace('/[^A-Z0-9]/i','_',ucfirst(trim($this->table)));
    }


    /**
    * Convert a table name into a file name -> override this if you want a different mapping
    *
    * @access  public
    * @return  string file name;
    */


    function getFileNameFromTableName($table)
    {
        $options = &PEAR::getStaticProperty('DB_DataObject','options');
        $base = $options['class_location'];
        if (strpos($base,'%s') !== false) {
            $base = dirname($base);
        }
        if (!file_exists($base)) {
            require_once 'System.php';
            System::mkdir(array('-p',$base));
        }
        if (strpos($options['class_location'],'%s') !== false) {
            $outfilename   = sprintf($options['class_location'],
                    preg_replace('/[^A-Z0-9]/i','_',ucfirst($this->table)));
        } else {
            $outfilename = "{$base}/".preg_replace('/[^A-Z0-9]/i','_',ucfirst($this->table)).".php";
        }
        return $outfilename;

    }


     /**
    * Convert a column name into a method name (usually prefixed by get/set/validateXXXXX)
    *
    * @access  public
    * @return  string method name;
    */


    function getMethodNameFromColumnName($col)
    {
        return ucfirst($col);
    }




    /*
     * building the class files
     * for each of the tables output a file!
     */
    function generateClasses()
    {
        //echo "Generating Class files:        \n";
        $options = &PEAR::getStaticProperty('DB_DataObject','options');


        if ($extends = @$options['extends']) {
            $this->_extends = $extends;
            $this->_extendsFile = $options['extends_location'];
        }

        foreach($this->tables as $this->table) {
            $this->table        = trim($this->table);
            $this->classname    = $this->getClassNameFromTableName($this->table);
            $i = '';
            $outfilename        = $this->getFileNameFromTableName($this->table);

            $oldcontents = '';
            if (file_exists($outfilename)) {
                // file_get_contents???
                $oldcontents = implode('',file($outfilename));
            }

            $out = $this->_generateClassTable($oldcontents);
            $this->debug( "writing $this->classname\n");
            $fh = fopen($outfilename, "w");
            fputs($fh,$out);
            fclose($fh);
        }
        //echo $out;
    }

    /**
     * class being extended (can be overridden by [DB_DataObject_Generator] extends=xxxx
     *
     * @var    string
     * @access private
     */
    var $_extends = 'DB_DataObject';

    /**
     * line to use for require('DB/DataObject.php');
     *
     * @var    string
     * @access private
     */
    var $_extendsFile = "DB/DataObject.php";

    /**
     * class being generated
     *
     * @var    string
     * @access private
     */
    var $_className;

    /**
     * The table class geneation part - single file.
     *
     * @access  private
     * @return  none
     */
    function _generateClassTable($input = '')
    {
        $n = DIRECTORY_SEPARATOR == '\\' ? "\r\n" : "\n";

        // title = expand me!
        $foot = "";
        $head = "<?php{$n}/**{$n} * DB_DataObject for {$this->table}{$n} */{$n}";
        // requires
        $head .= "require_once '{$this->_extendsFile}';{$n}{$n}";
        // add dummy class header in...
        // class
        $head .= "class {$this->classname} extends {$this->_extends} {$n}{";

        $body =  "{$n}    ###START_AUTOCODE{$n}";
        $body .= "    /* the code below is auto generated do not remove the above tag */{$n}{$n}";
        // table
        $padding = (30 - strlen($this->table));
        $padding  = ($padding < 2) ? 2 : $padding;

        $p =  str_repeat(' ',$padding) ;

        $options = &PEAR::getStaticProperty('DB_DataObject','options');


        $var = (substr(phpversion(),0,1) > 4) ? 'public' : 'var';
        $var = !empty($options['generator_var_keyword']) ? $options['generator_var_keyword'] : $var;


        $body .= "    {$var} \$__table = '{$this->table}';  {$p}// table name{$n}";


        // if we are using the option database_{databasename} = dsn
        // then we should add var $_database = here
        // as database names may not always match..




        if (isset($options["database_{$this->_database}"])) {
            $body .= "    {$var} \$_database = '{$this->_database}';  {$p}// database name (used with database_{*} config){$n}";
        }


        if (!empty($options['generator_novars'])) {
            $var = '//'.$var;
        }

        $defs = $this->_definitions[$this->table];

        // show nice information!
        $connections = array();
        $sets = array();
        foreach($defs as $t) {
            if (!strlen(trim($t->name))) {
                continue;
            }
            $padding = (30 - strlen($t->name));
            if ($padding < 2) $padding =2;
            $p =  str_repeat(' ',$padding) ;

            $body .="    {$var} \${$t->name};  {$p}// {$t->type}({$t->len})  {$t->flags}{$n}";

            // can not do set as PEAR::DB table info doesnt support it.
            //if (substr($t->Type,0,3) == "set")
            //    $sets[$t->Field] = "array".substr($t->Type,3);
            $body .= $this->derivedHookVar($t,$padding);
        }

        // THIS IS TOTALLY BORKED old FC creation
        // IT WILL BE REMOVED!!!!! in DataObjects 1.6
        // grep -r __clone * to find all it's uses
        // and replace them with $x = clone($y);
        // due to the change in the PHP5 clone design.

        if ( substr(phpversion(),0,1) < 5) {
            $body .= "{$n}";
            $body .= "    /* ZE2 compatibility trick*/{$n}";
            $body .= "    function __clone() { return \$this;}{$n}";
        }

        // simple creation tools ! (static stuff!)
        $body .= "{$n}";
        $body .= "    /* Static get */{$n}";
        $body .= "    function staticGet(\$k,\$v=NULL) { return DB_DataObject::staticGetFromClassName('{$this->classname}',\$k,\$v); }{$n}";

        // generate getter and setter methods
        $body .= $this->_generateGetters($input);
        $body .= $this->_generateSetters($input);

        /*
        theoretically there is scope here to introduce 'list' methods
        based up 'xxxx_up' column!!! for heiracitcal trees..
        */

        // set methods
        //foreach ($sets as $k=>$v) {
        //    $kk = strtoupper($k);
        //    $body .="    function getSets{$k}() { return {$v}; }{$n}";
        //}

        if (!empty($options['generator_no_ini'])) {
            $def = $this->_generateDefinitionsTable();  // simplify this!?
            $body .= $this->_generateTableFunction($def['table']);
            $body .= $this->_generateKeysFunction($def['keys']);
            $body .= $this->_generateSequenceKeyFunction($def);
            $body .= $this->_generateDefaultsFunction($this->table, $def['table']);
        }  else if (!empty($options['generator_add_defaults'])) {
            // I dont really like doing it this way (adding another option)
            // but it helps on older projects.
            $def = $this->_generateDefinitionsTable();  // simplify this!?
            $body .= $this->_generateDefaultsFunction($this->table,$def['table']);

        }
        $body .= $this->derivedHookFunctions($input);

        $body .= "{$n}    /* the code above is auto generated do not remove the tag below */";
        $body .= "{$n}    ###END_AUTOCODE{$n}";


        // stubs..

        if (!empty($options['generator_add_validate_stubs'])) {
            foreach($defs as $t) {
                if (!strlen(trim($t->name))) {
                    continue;
                }
                $validate_fname = 'validate' . $this->getMethodNameFromColumnName($t->name);
                // dont re-add it..
                if (preg_match('/\s+function\s+' . $validate_fname . '\s*\(/i', $input)) {
                    continue;
                }
                $body .= "{$n}    function {$validate_fname}(){$n}    {{$n}        return false;{$n}    }{$n}";
            }
        }




        $foot .= "}{$n}";
        $full = $head . $body . $foot;

        if (!$input) {
            return $full;
        }
        if (!preg_match('/(\n|\r\n)\s*###START_AUTOCODE(\n|\r\n)/s',$input))  {
            return $full;
        }
        if (!preg_match('/(\n|\r\n)\s*###END_AUTOCODE(\n|\r\n)/s',$input)) {
            return $full;
        }


        /* this will only replace extends DB_DataObject by default,
            unless use set generator_class_rewrite to ANY or a name*/

        $class_rewrite = 'DB_DataObject';
        $options = &PEAR::getStaticProperty('DB_DataObject','options');
        if (!($class_rewrite = @$options['generator_class_rewrite'])) {
            $class_rewrite = 'DB_DataObject';
        }
        if ($class_rewrite == 'ANY') {
            $class_rewrite = '[a-z_]+';
        }

        $input = preg_replace(
            '/(\n|\r\n)class\s*[a-z0-9_]+\s*extends\s*' .$class_rewrite . '\s*\{(\n|\r\n)/si',
            "{$n}class {$this->classname} extends {$this->_extends} {$n}{{$n}",
            $input);

        return preg_replace(
            '/(\n|\r\n)\s*###START_AUTOCODE(\n|\r\n).*(\n|\r\n)\s*###END_AUTOCODE(\n|\r\n)/s',
            $body,$input);
    }

    /**
     * hook to add extra methods to all classes
     *
     * called once for each class, use with $this->table and
     * $this->_definitions[$this->table], to get data out of the current table,
     * use it to add extra methods to the default classes.
     *
     * @access   public
     * @return  string added to class eg. functions.
     */
    function derivedHookFunctions($input = "")
    {
        // This is so derived generator classes can generate functions
        // It MUST NOT be changed here!!!
        return "";
    }

    /**
     * hook for var lines
     * called each time a var line is generated, override to add extra var
     * lines
     *
     * @param object t containing type,len,flags etc. from tableInfo call
     * @param int padding number of spaces
     * @access   public
     * @return  string added to class eg. functions.
     */
    function derivedHookVar(&$t,$padding)
    {
        // This is so derived generator classes can generate variabels
        // It MUST NOT be changed here!!!
        return "";
    }


    /**
    * getProxyFull - create a class definition on the fly and instantate it..
    *
    * similar to generated files - but also evals the class definitoin code.
    *
    *
    * @param   string database name
    * @param   string  table   name of table to create proxy for.
    *
    *
    * @return   object    Instance of class. or PEAR Error
    * @access   public
    */
    function getProxyFull($database,$table)
    {

        if ($err = $this->fillTableSchema($database,$table)) {
            return $err;
        }


        $options = &PEAR::getStaticProperty('DB_DataObject','options');
        $class_prefix  = $options['class_prefix'];

        if ($extends = @$options['extends']) {
            $this->_extends = $extends;
            $this->_extendsFile = $options['extends_location'];
        }
        $classname = $this->classname = $this->getClassNameFromTableName($this->table);

        $out = $this->_generateClassTable();
        //echo $out;
        eval('?>'.$out);
        return new $classname;

    }

     /**
    * fillTableSchema - set the database schema on the fly
    *
    *
    *
    * @param   string database name
    * @param   string  table   name of table to create schema info for
    *
    * @return   none | PEAR::error()
    * @access   public
    */
    function fillTableSchema($database,$table)
    {
        global $_DB_DATAOBJECT;
         // a little bit of sanity testing.
        if ((false !== strpos($database,"'")) || (false !== strpos($database,";"))) {
            return PEAR::raiseError("Error: Database name contains a quote or semi-colon", null, PEAR_ERROR_DIE);
        }

        $this->_database  = $database;

        $this->_connect();
        $table = trim($table);

        // a little bit of sanity testing.
        if ((false !== strpos($table,"'")) || (false !== strpos($table,";"))) {
            return PEAR::raiseError("Error: Table contains a quote or semi-colon", null, PEAR_ERROR_DIE);
        }
        $__DB= &$GLOBALS['_DB_DATAOBJECT']['CONNECTIONS'][$this->_database_dsn_md5];


        $options   = PEAR::getStaticProperty('DB_DataObject','options');
        $db_driver = empty($options['db_driver']) ? 'DB' : $options['db_driver'];
        $is_MDB2   = ($db_driver != 'DB') ? true : false;

        if (!$is_MDB2) {
            // try getting a list of schema tables first. (postgres)
            $__DB->expectError(DB_ERROR_UNSUPPORTED);
            $this->tables = $__DB->getListOf('schema.tables');
            $__DB->popExpect();
        } else {
            /**
             * set portability and some modules to fetch the informations
             */
            $__DB->setOption('portability', MDB2_PORTABILITY_ALL ^ MDB2_PORTABILITY_FIX_CASE);
            $__DB->loadModule('Manager');
            $__DB->loadModule('Reverse');
        }

        if (!$is_MDB2) {
            $defs =  $__DB->tableInfo($table);
        } else {
            $defs =  $__DB->reverse->tableInfo($table);
            foreach ($defs as $k => $v) {
                $defs[$k]['len'] = &$defs[$k]['length'];
            }
        }




        if (PEAR::isError($defs)) {
            return $defs;
        }
        if (@$_DB_DATAOBJECT['CONFIG']['debug'] > 2) {
            $this->debug("getting def for $database/$table",'fillTable');
            $this->debug(print_r($defs,true),'defs');
        }
        // cast all definitions to objects - as we deal with that better.


        foreach($defs as $def) {
            if (is_array($def)) {
                $this->_definitions[$table][] = (object) $def;
            }
        }

        $this->table = trim($table);
        $ret = $this->_generateDefinitionsTable();

        $_DB_DATAOBJECT['INI'][$database][$table] = $ret['table'];
        $_DB_DATAOBJECT['INI'][$database][$table.'__keys'] = $ret['keys'];
        return false;

    }

    /**
    * Generate getter methods for class definition
    *
    * @param    string  $input  Existing class contents
    * @return   string
    * @access   public
    */
    function _generateGetters($input)
    {

        $options = &PEAR::getStaticProperty('DB_DataObject','options');
        $getters = '';

        // only generate if option is set to true
        if  (empty($options['generate_getters'])) {
            return '';
        }

        // remove auto-generated code from input to be able to check if the method exists outside of the auto-code
        $input = preg_replace('/(\n|\r\n)\s*###START_AUTOCODE(\n|\r\n).*(\n|\r\n)\s*###END_AUTOCODE(\n|\r\n)/s', '', $input);

        $getters .= "\n\n";
        $defs     = $this->_definitions[$this->table];

        // loop through properties and create getter methods
        foreach ($defs = $defs as $t) {

            // build mehtod name
            $methodName = 'get' . $this->getMethodNameFromColumnName($t->name);

            if (!strlen(trim($t->name)) || preg_match("/function[\s]+[&]?$methodName\(/i", $input)) {
                continue;
            }

            $getters .= "   /**\n";
            $getters .= "    * Getter for \${$t->name}\n";
            $getters .= "    *\n";
            $getters .= (stristr($t->flags, 'multiple_key')) ? "    * @return   object\n"
                                                             : "    * @return   {$t->type}\n";
            $getters .= "    * @access   public\n";
            $getters .= "    */\n";
            $getters .= (substr(phpversion(),0,1) > 4) ? '    public '
                                                       : '    ';
            $getters .= "function $methodName() {\n";
            $getters .= "        return \$this->{$t->name};\n";
            $getters .= "    }\n\n";
        }


        return $getters;
    }


   /**
    * Generate setter methods for class definition
    *
    * @param    string  Existing class contents
    * @return   string
    * @access   public
    */
    function _generateSetters($input)
    {

        $options = &PEAR::getStaticProperty('DB_DataObject','options');
        $setters = '';

        // only generate if option is set to true
        if  (empty($options['generate_setters'])) {
            return '';
        }

        // remove auto-generated code from input to be able to check if the method exists outside of the auto-code
        $input = preg_replace('/(\n|\r\n)\s*###START_AUTOCODE(\n|\r\n).*(\n|\r\n)\s*###END_AUTOCODE(\n|\r\n)/s', '', $input);

        $setters .= "\n";
        $defs     = $this->_definitions[$this->table];

        // loop through properties and create setter methods
        foreach ($defs = $defs as $t) {

            // build mehtod name
            $methodName = 'set' . $this->getMethodNameFromColumnName($t->name);

            if (!strlen(trim($t->name)) || preg_match("/function[\s]+[&]?$methodName\(/i", $input)) {
                continue;
            }

            $setters .= "   /**\n";
            $setters .= "    * Setter for \${$t->name}\n";
            $setters .= "    *\n";
            $setters .= "    * @param    mixed   input value\n";
            $setters .= "    * @access   public\n";
            $setters .= "    */\n";
            $setters .= (substr(phpversion(),0,1) > 4) ? '    public '
                                                       : '    ';
            $setters .= "function $methodName(\$value) {\n";
            $setters .= "        \$this->{$t->name} = \$value;\n";
            $setters .= "    }\n\n";
        }


        return $setters;
    }
    /**
    * Generate table Function - used when generator_no_ini is set.
    *
    * @param    array  table array.
    * @return   string
    * @access   public
    */
    function _generateTableFunction($def)
    {
        $defines = explode(',','INT,STR,DATE,TIME,BOOL,TXT,BLOB,NOTNULL,MYSQLTIMESTAMP');

        $ret = "\n" .
               "    function table()\n" .
               "    {\n" .
               "         return array(\n";

        foreach($def as $k=>$v) {
            $str = '0';
            foreach($defines as $dn) {
                if ($v & constant('DB_DATAOBJECT_' . $dn)) {
                    $str .= ' + DB_DATAOBJECT_' . $dn;
                }
            }
            if (strlen($str) > 1) {
                $str = substr($str,3); // strip the 0 +
            }
            // hopefully addslashes is good enough here!!!
            $ret .= '             \''.addslashes($k).'\' => ' . $str . ",\n";
        }
        return $ret . "         );\n" .
                      "    }\n";



    }
    /**
    * Generate keys Function - used generator_no_ini is set.
    *
    * @param    array  keys array.
    * @return   string
    * @access   public
    */
    function _generateKeysFunction($def)
    {

        $ret = "\n" .
               "    function keys()\n" .
               "    {\n" .
               "         return array(";

        foreach($def as $k=>$type) {
            // hopefully addslashes is good enough here!!!
            $ret .= '\''.addslashes($k).'\', ';
        }
        $ret = preg_replace('#, $#', '', $ret);
        return $ret . ");\n" .
                      "    }\n";



    }
    /**
    * Generate sequenceKey Function - used generator_no_ini is set.
    *
    * @param    array  table and key definition.
    * @return   string
    * @access   public
    */
    function _generateSequenceKeyFunction($def)
    {

        //print_r($def);
        // DB_DataObject::debugLevel(5);
        global $_DB_DATAOBJECT;
        // print_r($def);


        $dbtype     = $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->dsn['phptype'];
        $realkeys   = $def['keys'];
        $keys       = array_keys($realkeys);
        $usekey     = isset($keys[0]) ? $keys[0] : false;
        $table      = $def['table'];


        $seqname = false;




        $ar = array(false,false,false);
        if ($usekey !== false) {
            if (!empty($_DB_DATAOBJECT['CONFIG']['sequence_'.$this->__table])) {
                $usekey = $_DB_DATAOBJECT['CONFIG']['sequence_'.$this->__table];
                if (strpos($usekey,':') !== false) {
                    list($usekey,$seqname) = explode(':',$usekey);
                }
            }

            if (in_array($dbtype , array( 'mysql', 'mysqli', 'mssql', 'ifx')) &&
                ($table[$usekey] & DB_DATAOBJECT_INT) &&
                isset($realkeys[$usekey]) && ($realkeys[$usekey] == 'N')
                ) {
                // use native sequence keys.
                $ar =  array($usekey,true,$seqname);
            } else {
                // use generated sequence keys..
                if ($table[$usekey] & DB_DATAOBJECT_INT) {
                    $ar = array($usekey,false,$seqname);
                }
            }
        }




        $ret = "\n" .
               "    function sequenceKey() // keyname, use native, native name\n" .
               "    {\n" .
               "         return array(";
        foreach($ar as $v) {
            switch (gettype($v)) {
                case 'boolean':
                    $ret .= ($v ? 'true' : 'false') . ', ';
                    break;

                case 'string':
                    $ret .= "'" . $v . "', ";
                    break;

                default:    // eak
                    $ret .= "null, ";

            }
        }
        $ret = preg_replace('#, $#', '', $ret);
        return $ret . ");\n" .
                      "    }\n";

    }

    /**
    * Generate defaults Function - used generator_add_defaults or generator_no_ini is set.
    * Only supports mysql and mysqli ... welcome ideas for more..
    *
    *
    * @param    array  table and key definition.
    * @return   string
    * @access   public
    */
    function _generateDefaultsFunction($table,$defs)
    {
        $__DB= &$GLOBALS['_DB_DATAOBJECT']['CONNECTIONS'][$this->_database_dsn_md5];
        if (!in_array($__DB->phptype, array('mysql','mysqli'))) {
            return; // cant handle non-mysql introspection for defaults.
        }

        $res = $__DB->getAll('DESCRIBE ' . $table,DB_FETCHMODE_ASSOC);
        $defaults = array();
        foreach($res as $ar) {
            // this is initially very dumb... -> and it may mess up..
            $type = $defs[$ar['Field']];

            switch (true) {

                case (is_null( $ar['Default'])):
                    $defaults[$ar['Field']]  = 'null';
                    break;

                case ($type & DB_DATAOBJECT_DATE):
                case ($type & DB_DATAOBJECT_TIME):
                case ($type & DB_DATAOBJECT_MYSQLTIMESTAMP): // not supported yet..
                    break;

                case ($type & DB_DATAOBJECT_BOOL):
                    $defaults[$ar['Field']] = (int)(boolean) $ar['Default'];
                    break;


                case ($type & DB_DATAOBJECT_STR):
                    $defaults[$ar['Field']] =  "'" . addslashes($ar['Default']) . "'";
                    break;


                default:    // hopefully eveything else...  - numbers etc.
                    if (!strlen($ar['Default'])) {
                        continue;
                    }
                    if (is_numeric($ar['Default'])) {
                        $defaults[$ar['Field']] =   $ar['Default'];
                    }
                    break;

            }
            //var_dump(array($ar['Field'], $ar['Default'], $defaults[$ar['Field']]));
        }
        if (empty($defaults)) {
            return;
        }

        $ret = "\n" .
               "    function defaults() // column default values \n" .
               "    {\n" .
               "         return array(\n";
        foreach($defaults as $k=>$v) {
            $ret .= '             \''.addslashes($k).'\' => ' . $v . ",\n";
        }
        return $ret . "         );\n" .
                      "    }\n";




    }





}
