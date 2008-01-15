<?php

/*
 * T_ML_COMMENT does not exist in PHP 5.
 * The following three lines define it in order to
 * preserve backwards compatibility.
 *
 * The next two lines define the PHP 5 only T_DOC_COMMENT,
 * which we will mask as T_ML_COMMENT for PHP 4.
 */
if (!defined('T_ML_COMMENT')) {
    define('T_ML_COMMENT', T_COMMENT);
} else {
    define('T_DOC_COMMENT', T_ML_COMMENT);
}

class OA_TranslationMaintenance
{

    // Setup variables
    protected $_masterLang  = 'english';
    protected $_lang;
    protected $_var;
    protected $_buildVar    = false;
    protected $_array       = array();
    protected $_arrayKey;
    protected $_arrayVal;
    protected $_buildArray  = false;
    protected $_old;
    protected $_new;
    protected $_add;
    protected $_missing;

    public $aLang;
    public $inputFile;
    public $outputDir;
    public $lang;
    public $aRegex = array(
        "#^(.*?)\['(.*)'\](\[.*\])*(\s*=\s*)([\"])(.*)([^\\\\])([\"])(;)#sm",
        "#^(.*?)\['(.*)'\](\[.*\])*(\s*=\s*)([\'])(.*)([^\\\\])([\'])(;)#sm"
    );
    public $aConstant = array(
        'MAX_PRODUCT_NAME', 'MAX_PRODUCT_URL', 'MAX_PRODUCT_DOCSURL',
        'OA_VERSION', 'phpAds_dbmsname'
    );

    function __construct()
    {

        if (empty($GLOBALS['argv'][1]) && empty($GLOBALS['argv'][2])) { $this->displayHelpMsg(); }

        $command = $GLOBALS['argv'][1];

        $languageKey = ($command == 'merge' || $command == 'remove_keys')
            ? array_slice($GLOBALS['argv'], 4)
            : array_slice($GLOBALS['argv'], 3);
        $this->lang = implode(' ', $languageKey);

        if ($command == 'merge' || $command == 'remove_keys') {
            $this->inputFile = $GLOBALS['argv'][2];
            $this->outputDir = $GLOBALS['argv'][3];
        } else {
            $this->outputDir = $GLOBALS['argv'][2];
        }

        //  check for trailing slash for output dir - remove if present
        $this->outputDir = (substr($this->outputDir, strlen($this->outputDir)) == '/') ? substr($this->outputDir, 0, strlen($this->outputDir) - 1) : $this->outputDir;

        switch ($command) {
        case 'merge':
            $this->mergeTranslation();
            break;
        case 'missing_keys':
            $this->detectMissingKey();
            break;
        case 'remove_keys':
            $this->removeStaleKey();
            break;
        case 'test':
            $this->_sortTrans();
            break;
        default:
            $this->displayHelpMsg('Please specifiy a command');
        }
    }

    function detectMissingKey()
    {
        if (empty($this->outputDir) && empty($this->lang)) { $this->displayHelpMsg(); }

        //  iterate master lang files reading each file
        if (!$outputDir = opendir($this->outputDir .'/'. $this->_masterLang)) {
            $this->displayHelpMsg('Unable to open master language directory: '. $this->outputDir .'/'. $this->_masterLang);
        }

        while ($file = readdir($outputDir)) {

            //  detect if it's a php file
            if (substr($file, strrpos($file, '.')) != '.php') { continue; }

            // Treat the index file differently
            if ($file == 'index.lang.php') {
                continue;
            }

            // load current lang file
            echo "Processing file: {$file}<br />\n";

            // Load existing language file and retrieve tokens
            $source = file_get_contents($this->outputDir .'/'. $this->_masterLang .'/'. $file);
            $tokens = token_get_all($source);

            //  parse current master lang file
            foreach ($tokens as $token) {
                //  store master keys
                if (is_string($token) && $this->_buildVar) {
                    $this->_var .= $token;

                    //  check if finished building varaiable if true replace current translation
                    //  with the transaltion from CSV
                    if (substr($token, strlen($token)-1) == ';') {

                        //  iterate through array adding each item to list of master keys
                        foreach ($this->aRegex as $regex) {
                            $strings = preg_match($regex, $this->_var, $matches);
                            if (!empty($matches[2])) {
                                //  reconstruct key
                                $k = $matches[2] . $matches[3];

                                if (strstr($k, "']['")) {
                                    $aPiece = explode("']['", $matches[2]);
                                    $k = $aPiece[0] ."['";
                                    array_shift($aPiece);
                                    $k .= implode("']['", $aPiece);
                                    $k .= "']";
                                }

                                $delimiter = $matches[5];
                                $trans = $matches[6] . $matches[7];

                                $trans = htmlspecialchars_decode(htmlentities($trans, null, 'UTF-8'));
                                //  replace new lines with \n
                                if ($delimiter == '"' && strstr($trans, "\n")) $trans = str_replace("\n", '\n', $trans);

                                $trans = $matches[5] . $trans . $matches[8];
                                //  replace constants
                                foreach ($this->aConstant as $ckey) {
                                    if (strstr($trans, $ckey) && !strstr($trans, "$delimiter.") && !strstr($trans, "$delimiter .")) {
                                        $aTran = explode($ckey, $trans);
                                        if (!empty($aTran)) {
                                            $newTrans = '';
                                            $total = count($aTran);
                                            for ($x = 0; $x < $total; $x++) {
                                                $newTrans .= $aTran[$x];
                                                if (!empty($aTran[$x+1])) {
                                                    $newTrans .= "$delimiter.$ckey.$delimiter";
                                                }
                                            }
                                            $trans = $newTrans;
                                        }
                                    }
                                }

                                $this->aMasterKey[$file][$k] = $trans;
                            }
                        }
                        $this->_var = '';
                        $this->_buildVar = false;
                    }
                } elseif (is_string($token) && $this->_buildArray) {
                    //  set value for indexed array - this does not add the last indexed item
                    if ($token == ',' && empty($this->_arrayKey)) {
                        $this->_array[$this->_arrayCount] = $this->_arrayVal;
                        $this->_arrayCount++;
                        $this->_arrayVal = '';
                    }

                    if (substr($token, strlen($token)-1) == ';') {
                        //  add last item to array container
                        if (!empty($this->_arrayKey) && !empty($this->_arrayVal)) {
                            $this->_array[$this->_arrayKey] = $this->_arrayVal;
                            $this->_arrayVal = '';
                            $this->_arrayKey = '';
                        } elseif (empty($this->_arrayKey)) {
                            $this->_array[$this->_arrayCount] = $this->_arrayVal;
                            $this->_arrayCount++;
                            $this->_arrayVal = '';
                        }
                        //  remove whitespace and equal sign
                        $this->_var = substr($this->_var, 0, strrpos($this->_var, ']')+1);

                        $strings = preg_match("#^(.*?)\['(.*)'\](\[.*\])*#m", $this->_var, $matches);

                        if (!empty($matches)) {
                            if (array_key_exists(0, $this->_array) && $this->_array[0] == '') {
                                $this->aMasterKey[$file][$matches[2]] = "array()";
                            } elseif (!empty($this->_array)) {
                            //  iterate through array adding each item to list of master keys
                                foreach ($this->_array as $key => $value) {
                                    $k = $matches[2] .'['. $key .']';
                                    $delimiter = substr($value, 0, 1);
                                    $trans = substr($value, 1, strlen($value)-2);

                                    $trans = htmlspecialchars_decode(htmlentities($trans, null, 'UTF-8'));
                                    //  replace new lines with \n
                                    if ($delimiter == '"' && strstr($trans, "\n")) $trans = str_replace("\n", '\n', $trans);

                                    $trans = $delimiter . $trans . $delimiter;

                                    //  replace constants
                                    foreach ($this->aConstant as $ckey) {
                                        if (strstr($trans, $ckey) && !strstr($trans, "$delimiter.") && !strstr($trans, "$delimiter .")) {
                                            $aTran = explode($ckey, $trans);
                                            if (!empty($aTran)) {
                                                $newTrans = '';
                                                $total = count($aTran);
                                                for ($x = 0; $x < $total; $x++) {
                                                    $newTrans .= $aTran[$x];
                                                    if (!empty($aTran[$x+1])) {
                                                        $newTrans .= "$delimiter.$ckey.$delimiter";
                                                    }
                                                }
                                                $trans = $newTrans;
                                            }
                                        }
                                    }
                                    $this->aMasterKey[$file][$k] = $trans;
                                }
                            }
                        }
                        $this->_var = '';
                        $this->_array = '';
                        $this->_buildArray = false;
                    }
                } elseif (is_array($token)) {
                    $result = $this->_parseToken($token);
                }
            }
        }

        $this->aStat['master']['total'] = 0;

        //  write keys that are in the master lang files but not the specified lang files
        $fp = fopen($this->outputDir .'/master_keys.php', 'w+');
        $line = "\$aMissingTranslation = array(\n";
        fwrite($fp, $line);
        foreach ($this->aMasterKey as $file => $aValue) {
            //  setup master key statistics for calculation of perentage of translation completion
            $total = count($aValue);
            $this->aStat['master']['total']  = $this->aStat['master']['total'] + $total;
            $this->aStat['master'][$file]    = count($aValue);

            // write key/trans to file
            $line = "'$file' => array(\n";
            foreach ($aValue as $k => $v) {
                $line .="'". $k ."' =>  ". $v .",\n";
            }
            $line .= "),\n";
            fwrite($fp, $line);
        }
        $line ="); \n";
        fwrite($fp, $line);


        //  iterate master lang files reading each file
        if (!$outputDir = opendir($this->outputDir .'/'. $this->lang)) {
            $this->displayHelpMsg('Unable to open master language directory: '. $this->output->dir .'/'. $this->lang);
        }

        while ($file = readdir($outputDir)) {

            //  detect if it's a php file
            if (substr($file, strrpos($file, '.')) != '.php') { continue; }

            // Treat the index file differently
            if ($file == 'index.lang.php') {
                continue;
            }

            // load current lang file
            echo "Processing file: {$file}<br />\n";

            // Load existing language file and retrieve tokens
            $source = file_get_contents($this->outputDir .'/'. $this->lang .'/'. $file);
            $tokens = token_get_all($source);

            //  parse current master lang file
            foreach ($tokens as $token) {
                //  store master keys
                if (is_string($token) && $this->_buildVar) {
                    $this->_var .= $token;

                    //  check if finished building varaiable if true replace current translation
                    //  with the transaltion from CSV
                    if (substr($token, strlen($token)-1) == ';') {

                        //  iterate through array adding each item to list of master keys
                        foreach ($this->aRegex as $regex) {
                            $strings = preg_match($regex, $this->_var, $matches);
                            if (!empty($matches[2])) {
                                //  reconstruct key
                                $k = $matches[2] . $matches[3];
                                $delimiter = $matches[5];
                                $trans = $matches[6] . $matches[7];

                                if (($delimiter == "'" && strstr($trans, "'"))
                                    || ($delimiter == '"' && strstr($trans, '"'))
                                ) {
                                    $trans = addslashes($trans);
                                }

                                $trans = htmlspecialchars_decode(htmlentities($trans, null, 'UTF-8'));
                                //  replace new lines with \n
                                if ($delimiter == '"' && strstr($trans, "\n")) $trans = str_replace("\n", '\n', $trans);

                                $trans = $matches[5] . $trans . $matches[8];

                                //  replace constants
                                foreach ($this->aConstant as $ckey) {
                                    if (strstr($trans, $ckey) && !strstr($trans, "$delimiter.") && !strstr($trans, "$delimiter .")) {
                                        $aTran = explode($ckey, $trans);
                                        if (!empty($aTran)) {
                                            $newTrans = '';
                                            $total = count($aTran);
                                            for ($x = 0; $x < $total; $x++) {
                                                $newTrans .= $aTran[$x];
                                                if (!empty($aTran[$x+1])) {
                                                    $newTrans .= "$delimiter.$ckey.$delimiter";
                                                }
                                            }
                                            $trans = $newTrans;
                                        }
                                    }
                                }
                                if (!empty($this->aMasterKey[$file]) && in_array($k, array_keys($this->aMasterKey[$file]))) {
                                    if ($this->aMasterKey[$file][$k] != $trans) {
                                        unset($this->aMasterKey[$file][$k]);
                                    }
                                } else {
                                    $this->aMissingKey[$file][$k] = $trans;
                                }
                            }
                        }
                        $this->_var = '';
                        $this->_buildVar = false;
                    }
                } elseif (is_string($token) && $this->_buildArray) {
                    //  set value for indexed array - this does not add the last indexed item
                    if ($token == ',' && empty($this->_arrayKey)) {
                        $this->_array[$this->_arrayCount] = $this->_arrayVal;
                        $this->_arrayCount++;
                        $this->_arrayVal = '';
                    }

                    if (substr($token, strlen($token)-1) == ';') {
                        //  add last item to array container
                        if (!empty($this->_arrayKey) && !empty($this->_arrayVal)) {
                            $this->_array[$this->_arrayKey] = $this->_arrayVal;
                            $this->_arrayVal = '';
                            $this->_arrayKey = '';
                        } elseif (empty($this->_arrayKey)) {
                            $this->_array[$this->_arrayCount] = $this->_arrayVal;
                            $this->_arrayCount++;
                            $this->_arrayVal = '';
                        }


                        //  remove whitespace and equal sign
                        $this->_var = substr($this->_var, 0, strrpos($this->_var, ']')+1);

                        $strings = preg_match("#^(.*?)\['(.*)'\](\[.*\])*#m", $this->_var, $matches);

                        if (!empty($matches)) {
                            if (!empty($this->_array)) {
                                foreach ($this->_array as $key => $value) {
                                    $k = $matches[2] .'['. $key .']';
                                    $delimiter = substr($value, 0, 1);
                                    $trans = substr($value, 1, strlen($value)-2);

                                    if (($delimiter == "'" && strstr($trans, "'"))
                                        || ($delimiter == '"' && strstr($trans, '"'))
                                    ) {
                                        $trans = addslashes($trans);
                                    }

                                    $trans = htmlspecialchars_decode(htmlentities($trans, null, 'UTF-8'));
                                    //  replace new lines with \n
                                    if ($delimiter == '"' && strstr($trans, "\n")) $trans = str_replace("\n", '\n', $trans);

                                    $trans = $delimiter . $trans . $delimiter;

                                    //  replace constants
                                    foreach ($this->aConstant as $ckey) {
                                        if (strstr($trans, $ckey) && !strstr($trans, "$delimiter.") && !strstr($trans, "$delimiter .")) {
                                            $aTran = explode($ckey, $trans);
                                            if (!empty($aTran)) {
                                                $newTrans = '';
                                                $total = count($aTran);
                                                for ($x = 0; $x < $total; $x++) {
                                                    $newTrans .= $aTran[$x];
                                                    if (!empty($aTran[$x+1])) {
                                                        $newTrans .= "$delimiter.$ckey.$delimiter";
                                                    }
                                                }
                                                $trans = $newTrans;
                                            }
                                        }
                                    }

                                    if (!empty($this->aMasterKey[$file]) && in_array($k, array_keys($this->aMasterKey[$file]))) {
                                        if ($this->aMasterKey[$file][$k] != $trans) {
                                            unset($this->aMasterKey[$file][$k]);
                                        }
                                    } else {
                                        $this->aMissingKey[$file][$k] = $value;
                                    }
                                }
                            } else {

                                $line = "{$matches[2]} = array();";
                                fwrite($this->fp, $line);
                            }
                        }
                        $this->_var = '';
                        $this->_array = '';
                        $this->_buildArray = false;
                    }
                } elseif (is_array($token)) {
                    $result = $this->_parseToken($token);
                }
            }
        }

        $this->aStat['lang']['total'] = 0;
        //  write keys that are in the master lang files but not the specified lang files
        $fp = fopen($this->outputDir .'/missing_keys.php', 'w+');
        $line = "<?php\n";
        $line .= "\$aMissingTranslation = array(\n";
        fwrite($fp, $line);
        foreach ($this->aMasterKey as $file => $aValue) {
            //  setup master key statistics for calculation of perentage of translation completion
            $diff = $this->aStat['master'][$file] - count($aValue);
            $total = ($diff == 0) ? $this->aStat['master'][$file] : $diff;
            $this->aStat['lang']['total']  = $this->aStat['lang']['total'] + $total;
            $this->aStat['lang'][$file]    = $this->aStat['master'][$file] - count($aValue);

            // write key/trans to file
            $line = "'$file' => array(\n";
            foreach ($aValue as $k => $v) {
                $line .="'". $k ."' =>  ". $v .",\n";
            }
            $line .= "),\n";
            fwrite($fp, $line);
        }
        $line ="); \n";
        $line .= "?>\n";
        fwrite($fp, $line);

        $this->aHeader[] = 'Language';
        //  compute statistics
        foreach ($this->aStat['master'] as $file => $total) {
            $this->aHeader[] = $file;
            $percentage = $this->aStat['lang'][$file] / $total;
            $this->aStat['percentage'][$file] = round($percentage * 100);
        }
        $percentage = $this->aStat['lang']['total'] / $this->aStat['master']['total'];
        $this->aStat['percentage']['total'] = round($percentage * 100);

        $fpCsv = fopen($this->lang .'-percentage.csv', 'w+');
        //  write headers
        fputcsv($fpCsv, $this->aHeader, ',', '"');

        //  write data
        $this->aDataSet[] = $this->_masterLang;
        foreach($this->aStat['master'] as $file => $total) {
            $this->aDataSet[] = $total;
        }
        fputcsv($fpCsv, $this->aDataSet, ',', '"');

        $this->aDataSet = array();
        $this->aDataSet[] = $this->lang;
        foreach($this->aStat['lang'] as $file => $total) {
            $this->aDataSet[] = $total;
        }
        fputcsv($fpCsv, $this->aDataSet, ',', '"');

        $this->aDataSet = array();
        $this->aDataSet[] = 'Percentage Complete';
        foreach($this->aStat['percentage'] as $file => $total) {
            $this->aDataSet[] = $total;
        }
        fputcsv($fpCsv, $this->aDataSet, ',', '"');

    }

    function getTranslationFromCSV()
    {
        $fp = fopen($this->inputFile, 'r');
        $header = fgetcsv($fp, 8192, ',', '"');
        $lang = array();
        while ($row = fgetcsv($fp, 8192, ',', '"')) {
            foreach ($row as $idx => $cell) {
                $lang[$header[$idx]][$row[0]] = $cell;
            }
        }
        return $lang;
    }

    function mergeTranslation()
    {
        //  detect if missing args
        if (empty($this->inputFile) || empty($this->outputDir)) { $this->displayHelpMsg(''); }

        if (is_file($this->inputFile)) {
            $this->aLang = $this->getTranslationFromCSV();

            //  detect if CSV contains the specified language
            if (empty($this->aLang[$this->lang])) { $this->displayHelpMsg('    The following keys were found:' . implode(', ', array_keys($this->aLang)) . "\n"); }

            if (is_dir($this->outputDir)) {
                $result = $this->_mergeTranslation();
            } else {
                $this->displayHelpMsg('Output directory not found: '. $this->outputDir);
            }

        echo "{$this->_new} translations merged <br />\n {$this->_old} translations maintained<br />\n {$this->_add} translations added<br />\n";
        }
    }

    function _mergeTranslation()
    {
        $outputDir = opendir($this->outputDir);
        $this->_new = $this->_old = $this->_add = $this->_missing = 0;

        //  loop through output folder reading each file
        while ($file = readdir($outputDir)) {

            //  detect if it's a php file
            if (substr($file, strrpos($file, '.')) != '.php') { continue; }

            // Treat the index file differently
            if ($file == 'index.lang.php') {
                continue;
            }

            // load current lang file
            echo "Processing file: {$file}<br />\n";

            // Load existing language file and retrieve tokens
            $source = file_get_contents($this->outputDir .'/'. $file);
            $tokens = token_get_all($source);

            // Load file to overwrite with merged translations
            $this->fp = fopen($this->outputDir .'/'. $file, 'w+');

            // Iterate through tokens merging translations and writing reslts
            foreach ($tokens as $token) {

                if (is_string($token) && $this->_buildVar) {
                    $this->_var .= $token;

                    //  check if finished building varaiable if true replace current translation
                    //  with the transaltions from CSV
                    if (substr($token, strlen($token)-1) == ';') {
                        $result = $this->_mergeVar();
                    }
                } elseif (is_string($token) && $this->_buildArray) {
                    //  set value for indexed array, associative arrays are handeled by _mergeArray()
                    if ($token == ',' && empty($this->_arrayKey)) {
                        $this->_array[$this->_arrayCount] = $this->_arrayVal;
                        $this->_arrayCount++;
                        $this->_arrayVal = '';
                    } elseif ($token == ',' && !empty($this->_arrayKey)) {
                        $this->_array[$this->_arrayKey] = $this->_arrayVal;
                        $this->_arrayKey = $this->_arrayVal = '';
                    }

                    if (substr($token, strlen($token)-1) == ';') {
                        //  add last item to array container
                        if (!empty($this->_arrayKey) && !empty($this->_arrayVal)) {
                            $this->_array[$this->_arrayKey] = $this->_arrayVal;
                            $this->_arrayKey = $this->_arrayVal = '';
                        } elseif (empty($this->_arrayKey) && !empty($this->_arrayVal)) {
                            $this->_array[$this->_arrayCount] = $this->_arrayVal;
                            $this->_arrayCount++;
                            $this->_arrayVal = '';
                        }
                        $result = $this->_mergeArray();
                    }
                } elseif (is_array($token)) {
                    $result = $this->_parseToken($token);
                    if (!empty($this->_line)) {
                        fwrite($this->fp, $this->_line);
                    }
                }
            }
        }

        //  add translations not found in lang files but in CSV
        $result = $this->_addNewTrans();
    }

    function _mergeVar()
    {
        //  extract key
        foreach ($this->aRegex as $regex) {
            $strings = preg_match($regex, $this->_var, $matches);
            if (!empty($matches[2])) {
                //  reconstruct key
                $key = $matches[2] . $matches[3];
                $origTrans = $matches[6] . $matches[7];

                //  set delimiter
                $delimiter = $matches[5];

                //  retrieve translation
                $trans = $this->_getTranslation($key, $origTrans, $delimiter);

                if ($origTrans == $trans) {
                    $trans = $origTrans;
                    $this->_old++;
                } else {
                    $this->_new++;
                }

                // reconstruct $this->_var with updated translation
                $this->_var = $matches[1] ."['". $matches[2] ."']". $matches[3] . $matches[4] . $matches[5] . $trans . $matches[8] . $matches[9];

                //  remove matching translation
                unset($this->aLang[$this->lang][$key]);
            }
        }

        fwrite($this->fp, $this->_var);

        //  reset variables
        $this->_buildVar = false;
        $this->_var = '';
    }

    function _mergeArray()
    {
        //  remove whitespace and equal sign
        $this->_var = substr($this->_var, 0, strrpos($this->_var, ']')+1);

        $strings = preg_match("#^(.*?)\['(.*)'\](\[.*\])*#m", $this->_var, $matches);

        //  loop through array checking for updated translations and updating them if necesary
        if (!empty($matches[2])) {
            if (!empty($this->_array)) {
                foreach ($this->_array as $key => $value) {
                    $k = $matches[2] .'['. $key .']';
                    $delimiter = substr($value, 0, 1);
                    $trans = substr($value, 1, strlen($value)-2);

                    $trans = $this->_getTranslation($k, $trans, $delimiter);

                    $this->_array[$key] = "\"$trans\"";

                    //  remove matching translation
                    unset($this->aLang[$this->lang][$k]);
                }

                //  write array to file
                $line = '';
                foreach ($this->_array as $key => $value) {
                    $line = "\$GLOBALS['$matches[2]'][$key] = $value;\n";
                    fwrite($this->fp, $line);
                }
            } else {
                $line = "\$GLOBALS['$matches[2]'] = array();";
                fwrite($this->fp, $line);
            }
            $this->_array = array();
            $this->_buildArray = false;
            $this->_var = '';
        }
    }

    function _getTranslation($key, $trans, $delimiter)
    {
        if (!empty($key) && array_key_exists($key, $this->aLang[$this->lang])
            && $this->aLang[$this->lang][$key]) {

            $newTrans = $this->aLang[$this->lang][$key];
            if (($delimiter == "'" && strstr($newTrans, "'"))
                || ($delimiter == '"' && strstr($newTrans, '"'))
            ) {
                $newTrans = addslashes($this->aLang[$this->lang][$key]);
            } else {
                $newTrans = $this->aLang[$this->lang][$key];
            }
        }

        if (!empty($newTrans) && $newTrans != $trans) {
            // retrieve updated translation
            $trans = htmlspecialchars_decode(htmlentities($newTrans, null, 'UTF-8'));
            //  replace new lines with \n
            if ($delimiter == '"' && strstr($trans, "\n")) $trans = str_replace("\n", '\n', $trans);

        }

        //  replace line breaks with \n
        if ($delimiter == '"' && strstr($trans, "\n")) $trans = str_replace("\n", '\n', $trans);

        //  replace constants
        foreach ($this->aConstant as $k) {
            if (strstr($trans, $k) && !strstr($trans, "$delimiter.") && !strstr($trans, "$delimiter .")) {
                $aTran = explode($k, $trans);
                if (!empty($aTran)) {
                    $newTrans = '';
                    $total = count($aTran);
                    for ($x = 0; $x < $total; $x++) {
                        $newTrans .= $aTran[$x];
                        if (!empty($aTran[$x+1])) {
                            $newTrans .= "$delimiter.$k.$delimiter";
                        }
                    }
                    $trans = $newTrans;
                }
            }
        }

        return $trans;
    }

    function _parseToken($aToken)
    {
        $this->_line = '';

        // token array
        list($id, $text) = $aToken;

        switch ($id) {
            case T_OPEN_TAG:
            case T_CLOSE_TAG:
            case T_COMMENT:
            case T_ML_COMMENT:  // we've defined this
            case T_DOC_COMMENT: // and this
            case T_WHITESPACE:
                if ($this->_buildVar) {
                    $this->_var .= $text;
                } elseif ($this->_buildArray) {
                    break;
                } else {
                    $this->_line = $text;
                    $this->_buildVar = false;
                }
                break;

            case T_STRING:
            case T_IS_EQUAL:
                if ($this->_buildVar) {
                    $this->_var .= $text;
                } elseif ($this->_buildArray) {
                    if (!empty($this->_arrayKey) && !empty($this->_arrayVal)) {
                        $this->_array{$this->_arrayKey} = $this->_arrayVal;
                        $this->_arrayVal = '';
                    }
                    $this->_arrayKey = $text;
                }
                break;
            case T_VARIABLE:
            case T_CONSTANT_ENCAPSED_STRING:
            case T_ENCAPSED_AND_WHITESPACE:
            case T_LNUMBER:
                if ($this->_buildArray) {
                    $this->_arrayVal .= $text;
                } else {
                    $this->_var .= $text;
                    $this->_buildVar = true;
                }
                break;
            case T_DOUBLE_ARROW:
                if ($this->_buildArray && !empty($this->_arrayVal) && empty($this->_arrayKey)) { // reassign value as key if not index array
                    $this->_arrayKey = $this->_arrayVal;
                    $this->_arrayVal = '';
                }
                break;
            case T_ARRAY:
                $this->_buildArray = true;
                $this->_buildVar = false;
                $this->_arrayKey = array();
                $this->_arrayVal = '';
                $this->_arrayCount = 0;
                $this->_array = array();
            default:
                // anything else -> output "as is"
                break;
        }
    }

    function _addNewTrans()
    {
        //  sort translations by file
        $result = $this->_sortTrans();

        foreach ($this->aLang[$this->lang] as $file => $aValue) {
            //  load default.lang.php from $this->outputDir
            $source = file_get_contents($this->outputDir .'/'. $file);
            $aToken = token_get_all($source);

            // Load file to overwrite with merged translations
            $fp = fopen($this->outputDir .'/'. $file, 'w+');

            //  parse and rewrite default.lang.php until closing php tag is encountered
            //  then add new translations
            foreach ($aToken as $token) {
                if (is_string($token)) {
                    fwrite($fp, $token);
                } else {
                    list($id, $text) = $token;
                    switch ($id) {
                    case T_CLOSE_TAG:
                        $line = "\n\n// Note: new translatiosn not found in original lang files but found in CSV\n";
                        fwrite($fp, $line);

                        //  write translations not found in original lang files but
                        //  are present in CSV
                        $delimiter = '"';
                        foreach ($aValue as $key => $trans) {

                            $trans = htmlspecialchars_decode(htmlentities($this->aLang[$this->lang][$file][$key], null, 'UTF-8'));
                            $trans = str_replace(array("\n", "\r"), array('\n', '\r'), $trans);

                            if (strstr($trans, '"')) $trans = addslashes($trans);

                            //  replace constants
                            foreach ($this->aConstant as $ckey) {
                                if (strstr($trans, $ckey) && !strstr($trans, "$delimiter.") && !strstr($trans, "$delimiter .")) {
                                    $aTran = explode($ckey, $trans);
                                    if (!empty($aTran)) {
                                        $newTrans = '';
                                        $total = count($aTran);
                                        for ($x = 0; $x < $total; $x++) {
                                            $newTrans .= $aTran[$x];
                                            if (!empty($aTran[$x+1])) {
                                                $newTrans .= "$delimiter.$ckey.$delimiter";
                                            }
                                        }
                                        $trans = $newTrans;
                                    }
                                }
                            }

                            if (!empty($trans)) {
                                //  handle array
                                if ($k = strstr($key, '[')) {
                                    $len = strlen($k);
                                    $key = substr($key, 0, strlen($key)-$len);
                                    $k = substr($k, 1, -1);
                                    $line = "\$GLOBALS['{$key}']['{$k}'] = \"{$trans}\";\n";
                                } else {
                                    $line = "\$GLOBALS['{$key}'] = \"{$trans}\";\n";
                                }
                                fwrite($fp, $line);
                                $this->_add++;
                            }
                        }

                        // add closing php tag
                        fwrite($fp, "?>");
                        break;
                    default:
                        fwrite($fp, $text);
                    }
                }
            }
        }
    }

    function removeStaleKey()
    {
        if (empty($this->inputFile) && empty($this->outputDir) && empty($this->lang)) {
            $this->displayHelpMsg();
        }

        //  get stale translations - $aTranslation
        if (is_file($this->inputFile)) {
            include $this->inputFile;
        }

        //  iterate master lang files reading each file
        if (!$outputDir = opendir($this->outputDir)) {
            $this->displayHelpMsg('Unable to open language directory: '. $this->outputDir);
        }

        while ($file = readdir($outputDir)) {

            //  detect if it's a php file
            if (substr($file, strrpos($file, '.')) != '.php') { continue; }

            // Treat the index file differently
            if ($file == 'index.lang.php') {
                continue;
            }

            // load current lang file
            echo "Processing file: {$file}<br />\n";

            // Load existing language file and retrieve tokens
            $source = file_get_contents($this->outputDir .'/'. $file);
            $tokens = token_get_all($source);

            // Load file to overwrite with merged translations
            $this->fp = fopen($this->outputDir .'/'. $file, 'w+');

            // Iterate through tokens merging translations and writing reslts
            foreach ($tokens as $token) {

                if (is_string($token) && $this->_buildVar) {
                    $this->_var .= $token;

                    //  check if finished building varaiable if true check if var should be removed
                    if (substr($token, strlen($token)-1) == ';') {

                        //  extract key
                        foreach ($this->aRegex as $regex) {
                            $strings = preg_match($regex, $this->_var, $matches);
                            if (!empty($matches[2])) {
                                //  reconstruct key
                                $key = $matches[2] . $matches[3];

                                //  Write translation if not in stale translation array
                                if (!in_array($key, $aTranslation)) {
                                    fwrite($this->fp, $this->_var);
                                }
                                $this->_var = '';
                                $this->_buildVar = false;
                            }
                        }
                    }
                } elseif (is_string($token) && $this->_buildArray) {
                    //  set value for indexed array, associative arrays are handeled by _mergeArray()
                    if ($token == ',' && empty($this->_arrayKey)) {
                        $this->_array[$this->_arrayCount] = $this->_arrayVal;
                        $this->_arrayCount++;
                        $this->_arrayVal = '';
                    } elseif ($token == ',' && !empty($this->_arrayKey)) {
                        $this->_array[$this->_arrayKey] = $this->_arrayVal;
                        $this->_arrayKey = $this->_arrayVal = '';
                    }

                    if (substr($token, strlen($token)-1) == ';') {
                        //  add last item to array container
                        if (!empty($this->_arrayKey) && !empty($this->_arrayVal)) {
                            $this->_array[$this->_arrayKey] = $this->_arrayVal;
                            $this->_arrayKey = $this->_arrayVal = '';
                        } elseif (empty($this->_arrayKey) && !empty($this->_arrayVal)) {
                            $this->_array[$this->_arrayCount] = $this->_arrayVal;
                            $this->_arrayCount++;
                            $this->_arrayVal = '';
                        }

                        //  remove whitespace and equal sign
                        $this->_var = substr($this->_var, 0, strrpos($this->_var, ']')+1);

                        $strings = preg_match("#^(.*?)\['(.*)'\](\[.*\])*#m", $this->_var, $matches);

                        //  loop through array checking for updated translations and updating them if necesary
                        if (!empty($matches[2])) {
                            if (!empty($this->_array)) {
                                //  write array to file
                                $line = '';
                                foreach ($this->_array as $key => $value) {
                                    $line = "\$GLOBALS['$matches[2]'][$key] = $value;\n";
                                    fwrite($this->fp, $line);
                                }
                            } else {
                                $line = "\$GLOBALS['$matches[2]'] = array();";
                                fwrite($this->fp, $line);
                            }
                            $this->_array = array();
                            $this->_buildArray = false;
                            $this->_var = '';
                        }
                    }
                } elseif (is_array($token)) {
                    $result = $this->_parseToken($token);
                    if (!empty($this->_line)) {
                        fwrite($this->fp, $this->_line);
                    }
                }
            }
        }
    }

    function _sortTrans()
    {
        //  remove language dir from $this->outputDir
        $aPiece = explode('/', $this->outputDir);
        array_pop($aPiece);
        $masterOutputDir = dirname($this->outputDir);

        //  iterate master lang files reading each file
        if (!$outputDir = opendir($masterOutputDir .'/'. $this->_masterLang)) {
            $this->displayHelpMsg('Unable to open master language directory: '. $masterOutputDir .'/'. $this->_masterLang);
        }

        while ($file = readdir($outputDir)) {

            //  detect if it's a php file
            if (substr($file, strrpos($file, '.')) != '.php') { continue; }

            // Treat the index file differently
            if ($file == 'index.lang.php') {
                continue;
            }

            // load current lang file
            echo "Processing file: {$file}<br />\n";

            // Load existing language file and retrieve tokens
            $source = file_get_contents($masterOutputDir .'/'. $this->_masterLang .'/'. $file);
            $tokens = token_get_all($source);

            //  parse current master lang file
            foreach ($tokens as $token) {
                //  store master keys
                if (is_string($token) && $this->_buildVar) {
                    $this->_var .= $token;

                    //  check if finished building varaiable if true replace current translation
                    //  with the transaltion from CSV
                    if (substr($token, strlen($token)-1) == ';') {

                        //  iterate through array adding each item to list of master keys
                        foreach ($this->aRegex as $regex) {
                            $strings = preg_match($regex, $this->_var, $matches);
                            if (!empty($matches[2])) {
                                //  reconstruct key
                                $k = $matches[2] . $matches[3];

                                if (strstr($k, "']['")) {
                                    $aPiece = explode("']['", $matches[2]);
                                    $k = $aPiece[0] ."['";
                                    array_shift($aPiece);
                                    $k .= implode("']['", $aPiece);
                                    $k .= "']";
                                }

                                $delimiter = $matches[5];
                                $trans = $matches[6] . $matches[7];

                                $trans = htmlspecialchars_decode(htmlentities($trans, null, 'UTF-8'));
                                //  replace new lines with \n
                                if ($delimiter == '"' && strstr($trans, "\n")) $trans = str_replace("\n", '\n', $trans);

                                $trans = $matches[5] . $trans . $matches[8];
                                //  replace constants
                                foreach ($this->aConstant as $ckey) {
                                    if (strstr($trans, $ckey) && !strstr($trans, "$delimiter.") && !strstr($trans, "$delimiter .")) {
                                        $aTran = explode($ckey, $trans);
                                        if (!empty($aTran)) {
                                            $newTrans = '';
                                            $total = count($aTran);
                                            for ($x = 0; $x < $total; $x++) {
                                                $newTrans .= $aTran[$x];
                                                if (!empty($aTran[$x+1])) {
                                                    $newTrans .= "$delimiter.$ckey.$delimiter";
                                                }
                                            }
                                            $trans = $newTrans;
                                        }
                                    }
                                }

                                $this->aMasterKey[$file][$k] = $trans;
                            }
                        }
                        $this->_var = '';
                        $this->_buildVar = false;
                    }
                } elseif (is_string($token) && $this->_buildArray) {
                    //  set value for indexed array - this does not add the last indexed item
                    if ($token == ',' && empty($this->_arrayKey)) {
                        $this->_array[$this->_arrayCount] = $this->_arrayVal;
                        $this->_arrayCount++;
                        $this->_arrayVal = '';
                    }

                    if (substr($token, strlen($token)-1) == ';') {
                        //  add last item to array container
                        if (!empty($this->_arrayKey) && !empty($this->_arrayVal)) {
                            $this->_array[$this->_arrayKey] = $this->_arrayVal;
                            $this->_arrayVal = '';
                            $this->_arrayKey = '';
                        } elseif (empty($this->_arrayKey)) {
                            $this->_array[$this->_arrayCount] = $this->_arrayVal;
                            $this->_arrayCount++;
                            $this->_arrayVal = '';
                        }
                        //  remove whitespace and equal sign
                        $this->_var = substr($this->_var, 0, strrpos($this->_var, ']')+1);

                        $strings = preg_match("#^(.*?)\['(.*)'\](\[.*\])*#m", $this->_var, $matches);

                        if (!empty($matches)) {
                            if (array_key_exists(0, $this->_array) && $this->_array[0] == '') {
                                $this->aMasterKey[$file][$matches[2]] = "array()";
                            } elseif (!empty($this->_array)) {
                            //  iterate through array adding each item to list of master keys
                                foreach ($this->_array as $key => $value) {
                                    $k = $matches[2] .'['. $key .']';
                                    $delimiter = substr($value, 0, 1);
                                    $trans = substr($value, 1, strlen($value)-2);

                                    $trans = htmlspecialchars_decode(htmlentities($trans, null, 'UTF-8'));
                                    //  replace new lines with \n
                                    if ($delimiter == '"' && strstr($trans, "\n")) $trans = str_replace("\n", '\n', $trans);

                                    $trans = $delimiter . $trans . $delimiter;

                                    //  replace constants
                                    foreach ($this->aConstant as $ckey) {
                                        if (strstr($trans, $ckey) && !strstr($trans, "$delimiter.") && !strstr($trans, "$delimiter .")) {
                                            $aTran = explode($ckey, $trans);
                                            if (!empty($aTran)) {
                                                $newTrans = '';
                                                $total = count($aTran);
                                                for ($x = 0; $x < $total; $x++) {
                                                    $newTrans .= $aTran[$x];
                                                    if (!empty($aTran[$x+1])) {
                                                        $newTrans .= "$delimiter.$ckey.$delimiter";
                                                    }
                                                }
                                                $trans = $newTrans;
                                            }
                                        }
                                    }
                                    $this->aMasterKey[$file][$k] = $trans;
                                }
                            }
                        }
                        $this->_var = '';
                        $this->_array = '';
                        $this->_buildArray = false;
                    }
                } elseif (is_array($token)) {
                    $result = $this->_parseToken($token);
                }
            }
        }

        //  loop through new translations looking for proper file to add them too
        foreach ($this->aLang[$this->lang] as $key => $value) {
            if (!empty($value)) {
                foreach ($this->aMasterKey as $file => $aValue) {
                    foreach ($aValue as $k => $v) {
                        if ($key == $k) {
                            $aLang[$file][$key] = $value;
                            unset($this->aLang[$this->lang][$key]);
                        }
                    }
                }
            }
        }

        //  add remaining keys to default.lang.php
        foreach ($this->aLang[$this->lang] as $key => $value) {
            $aLang['default.lang.php'][$key] = $value;
        }
        $this->aLang[$this->lang] = $aLang;
    }

    function displayHelpMsg($message = null)
    {
        echo "Command syntax: \n";
        echo "php translation.php <command> <param1> <param2> <param3> ...\n";
        echo "example: php translation.php merge pt_br.csv /var/www/openads/lib/max/language Brazilian Portugues\n\n";
        echo "Available commands: \n";
        echo "merge - Merge translation from a CSV file with existing translations\n";
        echo "\t Parameters: \n";
        echo "\t\t input_file - The absolute path for the file to read the updated language strings from\n";
        echo "\t\t output_dir - The absolute path for the folder to read the existing languages files from (and to update)\n";
        echo "\t\t language - The title of the column in the CSV containing the languge to be used for the replacement\n";
        echo "\nmissing_keys - Detects missing keys in all non-master language files and outputs a CSV report\n";
        echo "\t Parameters: \n";
        echo "\t\t lang_dir - The absolute path where language files are stored\n";
        echo "\t\t language = The name of the master language\n";
        echo "\nremove_keys - Removes specified keys from the non-master language files\n";
        echo "\t Parameters: \n";
        echo "\t\t input_file - The absolute path for the file to read the unused language strings from\n";
        echo "\t\t output_dir - The absolute path for the folder to read the existing languages files from (and to update)\n";
        echo "\t\t language - The languge that is being prase\n";

        if (!is_null($message)) {
            echo  "\n\n". $message ."\n";
        }
        die;
    }
}

$trans = new OA_TranslationMaintenance();
?>
