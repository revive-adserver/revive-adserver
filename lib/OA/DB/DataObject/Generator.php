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

require_once 'DB/DataObject/Generator.php';
require_once MAX_PATH.'/lib/OA/DB/Table/Core.php';


/**
 * Extending standard PEAR DB_DataObject Generator tool
 *
 * @package    OpenXDB
 */
class OA_DB_DataObject_Generator extends DB_DataObject_Generator
{

    /**
     * New() methods work-in-progress
     * refactoring to use mdb2 schema files
     */
    function start($schema)
    {
        global $_DB_DATAOBJECT;
        $_DB_DATAOBJECT['CONFIG']['debug'] = $GLOBALS['_MAX']['CONF']['debug']['priority'];

        $this->debug("START\n");

        $this->_createTableList($schema);

        /**
         * generate the db_schema.ini
         */
        $this->_newConfig = '';
        foreach($this->tables as $this->table => $aDefinition)
        {
            $this->_generateDefinitionsTable();
        }
        $this->_writeSchemaIni();

        $this->generateClasses();

        $this->debug("DONE\n\n");
    }

    /**
     * sets the list of tables and definitions
     * for use in generating the dataobjects
     *
     * table definitions are provided by OA_DB_Table
     * which uses mdb2schema an xml schema file
     *
     * this method unsets any excluded tables
     * and stores the db_dataobject datatype
     *
     */
    function _createTableList($schema='')
    {
        $options = &PEAR::getStaticProperty('DB_DataObject','options');

        $oTable = new OA_DB_Table();
        $oTable->init($schema, false);
        $aDefinition = $oTable->aDefinition['tables'];

        if (isset($options['generator_exclude_regex']))
        {
            foreach ($aDefinition AS $table => $aTable)
            {
                if (preg_match($options['generator_exclude_regex'],$table))
                {
                    unset($oTable->aDefinition['tables'][$table]);
                }
                else
                {
                    foreach ($aTable['fields'] AS $field => $aField)
                    {
                        $openxType  = $aField['type'];
                        $mdb2Type   = $oTable->oDbh->datatype->mapPrepareDatatype($openxType);
                        $aField['type'] = $mdb2Type;
                        $dboType    = $this->deriveDataType($aField, $oTable->oDbh->phptype);

                        $oTable->aDefinition['tables'][$table]['fields'][$field]['oxtype']  = $openxType;
                        $oTable->aDefinition['tables'][$table]['fields'][$field]['type']    = $mdb2Type;
                        $oTable->aDefinition['tables'][$table]['fields'][$field]['dbotype'] = $dboType;
                        //$this->debug("{$table}.{$field} type map :: {$openxType} => {$mdb2Type} => {$dboType} \n");
                    }
                }
            }
        }
        $this->_definitions = $oTable->aDefinition['tables'];
        $this->tables = $this->_definitions;
    }

    /**
     * dump the db_schema.ini contents to file
     *
     */
    function _writeSchemaIni()
    {
        $options = &PEAR::getStaticProperty('DB_DataObject','options');

        $base =  @$options['schema_location'];
        $file = "{$base}/db_schema.ini";

        if (!file_exists(dirname($file))) {
            require_once 'System.php';
            System::mkdir(array('-p','-m',0755,dirname($file)));
        }
        $this->debug("Writing ini as {$file}\n");
        touch($file);
        $fh = fopen($file,'w');
        fwrite($fh,$this->_newConfig);
        fclose($fh);
    }

    /**
     * straight from the parent unit
     * determine the DB_DATAOBJECT datatype value
     *
     * @param array $t
     * @param string $dbtype
     * @return integer
     */
    function deriveDataType(&$t, $dbtype)
    {
        switch (strtoupper($t['type']))
        {

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
                if ($t['length'] == 1) {
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
                     "** Found column '{$t['name']}', of type  '{$t['type']}'            **\n".
                     "** Please submit a bug, describe what type you expect this     **\n".
                     "** column  to be                                               **\n".
                     "*****************************************************************\n";
                $type = null;
                break;
        }
        if ($type && $t['notnull'])
        {
            $type += DB_DATAOBJECT_NOTNULL;
        }
        return $type;
    }

    /**
     * to use, you must set option: generate_links=true
     *
     */
    function generateForeignKeys()
    {
        // the db_schema.link.ini file is managed manually
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

        foreach($this->tables as $this->table => $aDef)
        {
            $this->table        = trim($this->table);
            $this->classname    = $this->getClassNameFromTableName($this->table);
            $i = '';
            $outfilename        = $this->getFileNameFromTableName($this->table);

            $oldcontents = '';
            if (file_exists($outfilename)) {
                // file_get_contents???
                $oldcontents = implode('',file($outfilename));
            }
            $this->debug( "generating $this->classname");
            $out = $this->_generateClassTable($oldcontents);
            $this->debug( "writing $this->classname\n");
            $fh = fopen($outfilename, "w");
            fputs($fh,$out);
            fclose($fh);
        }
        //echo $out;
    }

    /**
     * The table class generation part - single file.
     *
     * @access  private
     * @return  none
     */
    function _generateClassTable($input = '')
    {
        $n = DIRECTORY_SEPARATOR == '\\' ? "\r\n" : "\n";

        // title = expand me!
        $foot = "";
        $head = "<?php{$n}/**{$n} * Table Definition for {$this->table}{$n} */{$n}";
        // requires
        $head .= "require_once MAX_PATH.'{$this->_extendsFile}';{$n}{$n}";
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


        $var = !empty($options['generator_var_keyword']) ? $options['generator_var_keyword'] : 'public';


        $body .= "    {$var} \$__table = '{$this->table}';  {$p}// table name{$n}";

        if (!empty($options['generator_novars'])) {
            $var = '//'.$var;
        }

        $defs = $this->_definitions[$this->table]['fields'];

        // show nice information!
        $sets = array();
        foreach($defs as $name => $t)
        {
            $t['name'] = $name;
            if (!strlen(trim($t['name']))) {
                continue;
            }
            $padding = (30 - strlen($t['name']));
            if ($padding < 2) $padding =2;
            $p =  str_repeat(' ',$padding) ;

            $fielddec ="    {$var} \${$t['name']};  {$p}// {$t['type']}({$t['length']}) => {$t['oxtype']} => {$t['dbotype']} {$n}";

            $this->debug($fielddec);
            $body .= $fielddec;
        }

        // simple creation tools ! (static stuff!)
        $body .= "{$n}";
        $body .= "    /* Static get */{$n}";
        $body .= "    function staticGet(\$k,\$v=NULL) { return DB_DataObject::staticGetFromClassName('{$this->classname}',\$k,\$v); }{$n}";

        // generate getter and setter methods
        $body .= $this->_generateGetters($input);
        $body .= $this->_generateSetters($input);

        $body .= $this->_generateDefaultsArray($this->table);

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

        $foot .= "}{$n}?>";
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
     * generates contents of db_schema.ini
     *
     * @return string
     */
    function _generateDefinitionsTable()
    {
        $aTable             = $this->_definitions[$this->table];
        $this->_newConfig  .= "\n[{$this->table}]\n";
        $keys_out           =  "\n[{$this->table}__keys]\n";
        $keys_out_primary   = '';
        $keys_out_secondary = '';
        $aKeys_primary   = array();
        $aKeys_secondary = array();

        foreach($aTable['fields'] as $field => $aField)
        {
            $this->_newConfig .= "{$field} = {$aField['dbotype']}\n";
            if ($aField['autoincrement'])
            {
                $aKeys_primary[$field] = 'N';
            }
        }
        foreach($aTable['indexes'] as $index => $aIndex)
        {
            if (isset($aIndex['primary']) && ($aIndex['primary']) && (count($aIndex['fields'])==1))
            {
                foreach($aIndex['fields'] as $field => $aSort)
                {
                    if (!array_key_exists($field,$aKeys_primary))
                    {
                        $aKeys_primary[$field] = 'N';
                    }
                    if ( (array_key_exists($field,$aKeys_secondary)))
                    {
                        unset($aKeys_secondary[$field]);
                    }
                }
                continue;
            }
            else if (isset($aIndex['unique']) && ($aIndex['unique']) && (count($aIndex['fields'])==1))
            {
                $key_type = 'U';
            }
            else
            {
                $key_type = 'K';
            }
            foreach($aIndex['fields'] as $field => $aSort)
            {
                if ( (!array_key_exists($field,$aKeys_primary)) && ((!array_key_exists($field,$aKeys_secondary))))
                {
                    $aKeys_secondary[$field] = $key_type;
                }
            }
        }
        foreach ($aKeys_primary AS $field => $key_type)
        {
            $keys_out_primary .= "{$field} = {$key_type}\n";
        }
        foreach ($aKeys_secondary AS $field => $key_type)
        {
            $keys_out_secondary .= "{$field} = {$key_type}\n";
        }
        $this->_newConfig .= $keys_out . (empty($keys_out_primary) ? $keys_out_secondary : $keys_out_primary);
        //$this->_newConfig .= $keys_out . $keys_out_primary . $keys_out_secondary;

        return;
    }


   /**
    * Generate array of defaults values
    *
    * @param    string  table name.
    * @return   string
    */
    function _generateDefaultsArray($table)
    {
        $aFields = $this->_definitions[$table]['fields'];

        $aNulls = array(
                        'sso_user_id',
                        'date_last_login',
                        'email_updated',
                        'advertiser_account_id',
                        'website_account_id',
                       );

        $aDefaults = array();

        foreach($aFields as $field => $aField) {

            $type   = $aField['dbotype'];
            $value  = $aField['default'];

            switch (true)
            {
                case (in_array($field,$aNulls)):
                    $aDefaults[$field] = "OX_DATAOBJECT_NULL";
                    break;
                case ((!$aField['notnull']) && ($value===null)):
                case ($aField['autoincrement']):
                case (is_null($type)):
                    break;
                case ($type & DB_DATAOBJECT_BOOL):
                    $aDefaults[$field] = (int)(boolean) $value;
                    break;

                // Check DATE/TIME type first instead of STR (many date/time fields has multiple types including DB_DATAOBJECT_STR)
                case ($type & DB_DATAOBJECT_MYSQLTIMESTAMP): // not supported yet..
                case ($type & DB_DATAOBJECT_DATE):
                case ($type & DB_DATAOBJECT_TIME):
                    if ($field == 'updated')
                    {
                        $aDefaults[$field] = "'%DATE_TIME%'";
                    }
                    elseif ($field == 'total_basket_value') //recognized as DB_DATAOBJECT_MYSQLTIMESTAMP & DB_DATAOBJECT_INT
                    {
                        $aDefaults[$field] = $value;
                    }
                    else
                    {
                        $aDefaults[$field] = "'%NO_DATE_TIME%'";
                    }
                    break;

                case ($type & DB_DATAOBJECT_STR):
                    $aDefaults[$field] =  "'" . addslashes($value) . "'";
                    break;

                case (($type &  DB_DATAOBJECT_INT) && !($value === '')):
                    $aDefaults[$field] = $value;
                    break;

                default:
                    //$aDefaults[$field] = $value;
                    break;

            }
        }
        $result = '';
        if (!empty($aDefaults))
        {
            $result = "\n".'    var $defaultValues = array('. "\n";
                    foreach($aDefaults as $k=>$v)
                    {
                        $result .= '                \''.addslashes($k).'\' => ' . $v . ",\n";

                    }
            $result .= "                );\n";
        }
        return $result;
    }

}
?>