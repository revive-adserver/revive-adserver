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
    var $_masterLang  = 'en';
    var $_otherLangs  = array(
        'spanish'               => 'es',
        'german'                => 'de',
        'russian_utf8'          => 'ru',
        'Brazilian Portuguese'  => 'pt_br',
        'Chinese Simplified'    => 'zh-s',
        'french'                => 'fr',
        'polish'                => 'pl',
    );
    var $_aLang     = array (
        'english'               => 'en',
        'spanish'               => 'es',
        'german'                => 'de',
        'russian_utf8'          => 'ru',
        'Brazilian Portuguese'  => 'pt_br',
        'Chinese Simplified'    => 'zh-s',
        'french'                => 'fr',
        'polish'                => 'pl',
        'indonesian'            => 'id',
        'persian'               => 'pr',
        'japanese'              => 'ja',
        'czech'                 => 'cs',
        'turkish'               => 'tr'
    );
    var $_lang;
    var $_var;
    var $_buildVar    = false;
    var $_array       = array();
    var $_arrayKey;
    var $_arrayVal;
    var $_buildArray  = false;
    var $_old;
    var $_new;
    var $_add;
    var $_missing;
    var $_addStrikeTags = false;

    var $aLang = array();
    var $inputFile;
    var $outputDir;
    var $lang;
    var $aRegex = array(
        "#^(.*?)\['(.*)'\](\[.*\])*(\s*=\s*)([\"])(.*)([^\\\\])([\"])(;)#sm",
        "#^(.*?)\['(.*)'\](\[.*\])*(\s*=\s*)([\'])(.*)([^\\\\])([`])(;)#sm"
    );
    var $aConstant = array(
        'MAX_PRODUCT_NAME', 'MAX_PRODUCT_URL', 'OX_PRODUCT_DOCSURL',
        'OA_VERSION', 'phpAds_dbmsname'
    );

    /**
     * PHP4 style constructor
     *
     * @see OA_TranslationMaintenance::__construct
     */
    function OA_TranslationMaintenance()
    {
        $this->__construct();
    }

    function __construct()
    {

        if (empty($GLOBALS['argv'][1]) && empty($GLOBALS['argv'][2])) { $this->displayHelpMsg(); }

        $command = $GLOBALS['argv'][1];

        $languageKey = ($command == 'merge' || $command == 'mergestrike' || $command == 'mergePOT'
                        || $command == 'mergePluginPOT' || $command == 'mergePlugin' || $command == 'mergeStrickPlugin'
                        || $command == 'remove_keys' || $command == 'createcsv')
            ? array_slice($GLOBALS['argv'], 4)
            : array_slice($GLOBALS['argv'], 3);
        $this->lang = implode(' ', $languageKey);

        if ($command == 'merge' || $command == 'mergestrike' || $command == 'mergePOT'
            || $command == 'mergePluginPOT' || $command == 'mergePlugin' || $command == 'mergeStrickPlugin' || $command == 'remove_keys'
            || $command == 'createcsv')
        {
            if ($command == 'mergePOT' || $command == 'mergePluginPOT') {
                $this->inputFile = realpath($GLOBALS['argv'][2]);
                $this->potFile = realpath($GLOBALS['argv'][3]);
                if (!is_readable($this->potFile)) {
                    $this->displayHelpMsg('Unable to read POT file');
                }
            } else {
                $this->inputFile = $GLOBALS['argv'][2];
                $this->outputDir = $GLOBALS['argv'][3];
            }
        } else {
            $this->outputDir = $GLOBALS['argv'][2];
        }

        //  check for trailing slash for output dir - remove if present
        $this->outputDir = (substr($this->outputDir, strlen($this->outputDir)) == '/') ? substr($this->outputDir, 0, strlen($this->outputDir) - 1) : $this->outputDir;

        switch ($command) {
            case 'mergestrike': $this->_addStrikeTags = true;
            case 'merge':
                $this->mergeTranslation();
                break;
            case 'mergeStrikePlugin': $this->_addStrikeTags = true;
            case 'mergePlugin':
                $this->mergePluginTranslation();
                break;
            case 'mergePOT':
                $this->mergePOT();
                break;
            case 'mergePluginPOT':
                $this->mergePluginPOT();
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
            case 'createcsv':
                $this->createCSV();
                break;
            case 'createpot':
                $this->createPOT();
                break;
            default:
                $this->displayHelpMsg('Please specifiy a command');
        }
    }

    function detectMissingKey()
    {
        if (empty($this->outputDir) && empty($this->lang)) { $this->displayHelpMsg(); }

        //  load translations from the master lang files
        $this->aMasterKey = $this->loadTranslationFromDir($this->outputDir, $this->_masterLang);

        $this->aStat['master']['total'] = 0;

        //  write keys that are in the master lang files but not the specified lang files
        $fp = fopen($this->outputDir .'/master_keys.php', 'w+');
        $line = "\$aMissingTranslation = array(\n";
        fwrite($fp, $line);
        foreach ($this->aMasterKey as $file => $aValue) {
            //  setup master key statistics for calculating the perentage of completed translations
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

        //  load language specific translation
        $this->aLangKey = $this->loadTranslationFromDir($this->outputDir, $this->lang);

        //  remove updated language keys from the master list and return a
        $this->aMissingKey = $this->removeUpdatedKeys($this->aMasterKey, $this->aLangKey);

        $this->aStat['lang']['total'] = 0;
        //  write keys that are in the master lang files but not the specified lang files
        $fp = fopen($this->outputDir .'/missing_keys.php', 'w+');
        $line = "<?php\n";
        $line .= "\$aMissingTranslation = array(\n";
        fwrite($fp, $line);
        foreach ($this->aMissingKey as $file => $aValue) {
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

        //  writing details for master language
        $this->aDataSet[] = $this->_masterLang;
        foreach($this->aStat['master'] as $file => $total) {
            $this->aDataSet[] = $total;
        }
        fputcsv($fpCsv, $this->aDataSet, ',', '"');

        //  writing details for language
        $this->aDataSet = array();
        $this->aDataSet[] = $this->lang;
        foreach($this->aStat['lang'] as $file => $total) {
            $this->aDataSet[] = $total;
        }
        fputcsv($fpCsv, $this->aDataSet, ',', '"');

        //  writing percentage completelas
        $this->aDataSet = array();
        $this->aDataSet[] = 'Percentage Complete';
        foreach($this->aStat['percentage'] as $file => $total) {
            $this->aDataSet[] = $total;
        }
        fputcsv($fpCsv, $this->aDataSet, ',', '"');

    }

    function removeUpdatedKeys($aMasterLangKey, $aUpdateLangKey)
    {
        foreach($aUpdateLangKey as $file => $aValue) {
            foreach($aValue as $key => $value) {
                if (!empty($aMasterLangKey[$file]) && in_array($key, array_keys($aMasterLangKey[$file]))) {
                    if ($aMasterLangKey[$file][$key] != $value) {
                        unset($aMasterLangKey[$file][$key]);
                    }
                }
            }
        }

        return $aMasterLangKey;
    }

    function loadTranslationFromDir($dir, $lang, $escapeNewline = false, $groupByFile = true)
    {
        //  iterate lang files reading each file
        if (!$outputDir = opendir($dir .'/'. $lang)) {
            $this->displayHelpMsg('Unable to open master language directory: '. $dir .'/'. $lang);
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
            $source = file_get_contents($dir .'/'. $lang .'/'. $file);
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
                                if ($escapeNewline && ($delimiter == '"') && strstr($trans, "\n")) $trans = str_replace("\n", '\n', $trans);

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

                                if ($groupByFile) {
                                    $aMasterKey[$file][$k] = $trans;
                                } else {
                                    $aMasterKey[$k] = $trans;
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
                            if (array_key_exists(0, $this->_array) && $this->_array[0] == '') {
                                if ($groupByFile) {
                                    $aMasterKey[$file][$matches[2]] = "array()";
                                } else {
                                    $aMasterKey[$matches[2]] = "array()";
                                }
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
                                    if ($groupByFile) {
                                        $aMasterKey[$file][$k] = $trans;
                                    } else {
                                        $aMasterKey[$k] = $trans;
                                    }
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

        return $aMasterKey;
    }

    function loadTranslationFromCSV($fileName = false)
    {
        if (!$fileName) {
            $fileName = $this->inputFile;
        }
        $fp = fopen($fileName, 'r');
        $header = fgetcsv($fp, 8192, ',', '"');
        $lang = array();
        while ($row = fgetcsv($fp, 8192, ',', '"')) {
            foreach ($row as $idx => $cell) {
                if ($this->_addStrikeTags) {
                    $cell = "<strike>-{$cell}-</strike>";
                }
                $lang[$header[$idx]][$row[0]] = $cell;
            }
        }
        fclose($fp);

        return $lang;
    }

    function mergeTranslation()
    {
        //  detect if missing args
        if (empty($this->inputFile) || empty($this->outputDir)) { $this->displayHelpMsg(''); }

        if (is_file($this->inputFile)) {
            $this->aLang = $this->loadTranslationFromCSV();

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

    function mergePluginTranslation()
    {
        //  detect if missing args
        if (empty($this->inputFile) || empty($this->outputDir)) { $this->displayHelpMsg(''); }

        if (is_dir($this->outputDir)) {
            $this->aLang = $this->loadTranslationFromCSV();

            //  detect if CSV contains the specified language
            if (empty($this->aLang[$this->lang])) { $this->displayHelpMsg('    The following keys were found:' . implode(', ', array_keys($this->aLang)) . "\n"); }

            $result = $this->_mergePluginTranslation();

        } else {
            $this->displayHelpMsg('Output directory not found: '. $this->outputDir);
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

    function _mergePluginTranslation()
    {
        //  load plugin files
        $aPluginLangFile = array();
        findPluginLangFiles($this->outputDir, $aPluginLangFile);

        //  load plugin lang translations
        $aPluginWord = array();
        foreach ($aPluginLangFile as $folder => $files) {
            $path = substr($folder, strrpos($this->outputDir, '/')+1);
            foreach ($files as $file) {
                if (substr($file, 0, strrpos($file, '.')) == $this->_aLang[$this->lang]) {
                    $lang = substr($file, 0, strrpos($file, '.'));
                    $words = array();
                    include($folder . DIRECTORY_SEPARATOR . $file);
                    foreach ($words as $key => $value) {
                        $aPluginWord[$lang][$path][$key] = $value;
                    }
                }
            }
        }

        //  merge translations from CSV with plugin lang translations
        foreach ($this->aLang[$this->lang] as $key => $tran) {
            //  check if CSV translation diffs from current translation
            $path = $this->aLang['path/to/file'][$key];
            $existingTran = (!empty($aPluginWord[$this->_aLang[$this->lang]][$path][$key]))
                ? $aPluginWord[$this->_aLang[$this->lang]][$path][$key]
                : false;
            if ($existingTran == false || $tran != $existingTran) { //  update if different or does not exist
                $aPluginWord[$this->_aLang[$this->lang]][$path][$key] = $tran;
            }
        }

        //  update / create plugin lang files with latest translations
        foreach ($aPluginWord[$this->_aLang[$this->lang]] as $path => $aTran) {

            //  build filename
            $file = substr($this->outputDir, 0, strrpos($this->outputDir, '/')+1) . $path .'/'. $this->_aLang[$this->lang] .'.php';

            //  load current file
            if (is_file($file)) { // file is empty must populate with translations
                $source  = file_get_contents($file);
                $aToken = token_get_all($source);

            //  load english file as a template if exists
            } else {
                $tmplFile = substr($this->outputDir, 0, strrpos($this->outputDir, '/')+1) . $path .'/'. $this->_masterLang .'.php';
                if (is_file($tmplFile)) {
                    $source  = file_get_contents($tmplFile);
                    $aToken = token_get_all($source);
                }
            }

            $this->fp = fopen($file, 'w+');

            //  parse tokens updating file with updated translations
            foreach ($aToken as $token) {
                if (is_string($token) && $this->_buildVar) {
                    $this->_var .= $token;

                    //  check if finished building varaiable if true replace current translation
                    //  with the transaltions from CSV
                    if (substr($token, strlen($token)-1) == ';') {
                        fwrite($this->fp, $this->_var);

                        //  reset variables
                        $this->_buildVar = false;
                        $this->_var = '';
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
                        //  add array opening to $this->_var and write out to file
                        $this->_var .= " array(\n";
                        fwrite($this->fp, $this->_var);

                        //  loop through updated plugin translation array writing to file
                        foreach ($aPluginWord[$this->_aLang[$this->lang]][$path] as $key => $trans) {
                            $key = (strstr($key, "'")) ? str_replace("'", "\'", $key) : $key;

                            $delimiter = (strstr($trans, '".')) ? '"' : "'";
                            $trans = (strstr($trans, "'")) ? str_replace("'", "\'", $trans) : $trans;
                            $trans = (strstr($trans, '$')) ? str_replace('$', '\$', $trans) : $trans;
                            $str = "    '$key' => $delimiter$trans$delimiter,\n";
                            fwrite($this->fp, $str);
                        }

                        //  close array def
                        fwrite($this->fp, ");");

                        //  reset variables
                        $this->_array = array();
                        $this->_buildArray = false;
                        $this->_var = '';
                    }
                } elseif (is_array($token)) {
                    $result = $this->_parseToken($token);
                    if (!empty($this->_line)) {
                        fwrite($this->fp, $this->_line);
                    }
                } elseif (is_string($token) && !$this->_buildVar) {
                    fwrite($this->fp, $token);
                }

                //  if not building $words array write line current line to file

                //  if building $words array keep looping until end of array token is encountered
                //  then write all plugin translations to file


            }


            $x = 0;
            if ($x == 1) {
                $fp = fopen($file, 'a');
                fwrite($fp, "<?php\n");
                fwrite($fp, "    \$words = array(\n");
                foreach($aTran as $key => $tran) {
                    $tran = (strstr($tran, "\n")) ? str_replace("\n", '\n'."\n", $tran) : $tran;
                    $delimiter = (strstr($tran, '".')) ? '"' : '"';
                    $key = (strstr($tran, "'")) ? str_replace("'", "\'", $key) : $key;
                    fwrite($fp, "        '$key' => ". $delimiter ."$tran". $delimiter .",\n");
                }
                fwrite($fp, "    );\n");
                fwrite($fp, "?>\n");
            }
        }


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
                break;
            case T_IF:
            case T_ELSE:
            case T_ISSET:
                $this->_line .= $text;
                break;
            case T_BOOLEAN_AND:
            case T_BOOLEAN_OR:
                $this->_var .= $text;
                break;
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
                                    $k = substr($k, 2, -2);
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

        $this->aMasterKey = $this->loadTranslationFromDir($masterOutputDir, $this->_masterLang, true);

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

    function createCSV()
    {
        $app_base = dirname(dirname(dirname(__FILE__)));

        // Create plugin translation sheet
        $pluginLangFiles = array();
        findPluginLangFiles($app_base, $pluginLangFiles);
        $pluginWords = array();
        foreach ($pluginLangFiles as $folder => $files) {
            $path = substr($folder, strlen($app_base)+1);
            foreach ($files as $file) {
                $lang = substr($file, 0, strrpos($file, '.'));
                $words = array();
                include($folder . DIRECTORY_SEPARATOR . $file);
                foreach ($words as $key => $value) {
                    $pluginWords[$lang][$path][$key] = $value;
                }
            }
        }

        $PLUGIN_FILE = fopen($app_base . DIRECTORY_SEPARATOR . 'plugin_csv.csv', 'w');
        $header = array('Code key', 'path/to/file', $this->_masterLang);
        foreach (array_keys($this->_otherLangs) as $otherLang) {
            $header[] = $otherLang;
        }
        fputcsv($PLUGIN_FILE, $header, ',', '"');

        foreach ($pluginWords[$this->_masterLang] as $file => $words) {
            foreach ($words as $key => $value) {
                $line = array($key, $file);
                $line[] = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
                foreach (array_keys($this->_otherLangs) as $otherLang) {
                    $line[] = (!empty($pluginWords[$otherLang][$file][$key])) ? html_entity_decode($pluginWords[$otherLang][$file][$key], ENT_QUOTES, 'UTF-8') : '';
                }
                fputcsv($PLUGIN_FILE, $line, ',', '"');
            }
        }

        // Create core translations sheet (only including new translations for now)
        // Read the translation strings from the english language pack
        $this->_sortTrans();

        // Read the translation strings from the CSV files
        foreach ($this->_otherLangs as $otherLang => $csvName) {
            $langFile = dirname($this->inputFile) . DIRECTORY_SEPARATOR . $csvName . '.csv';
            $result = $this->loadTranslationFromCSV($langFile);
            $existing[$otherLang] = $result[$otherLang];
        }

        // Read the master language file
        $csv = $this->loadTranslationFromCSV();
        $existing['english'] = $csv['english'];

        $csvKeys = array_keys($csv['Code key']);

        // Keep the existing translations, and track any new items for addition at the end of the file
        $CORE_FILE = fopen($app_base . DIRECTORY_SEPARATOR . 'core_csv.csv', 'w');
        $header = array('Code key', $this->_masterLang);
        foreach (array_keys($this->_otherLangs) as $otherLang) {
            $header[] = $otherLang;
        }
        fputcsv($CORE_FILE, $header, ',', '"');

        foreach ($this->aMasterKey as $file => $contents) {
            foreach ($contents as $key => $value) {
                if ((substr($key, 0, 3) != 'str') || $value == 'array()') { continue; }
                if (in_array($key, $csvKeys)) {
                    $line = array($key, $existing[$this->_masterLang][$key]);
                    foreach (array_keys($this->_otherLangs) as $otherLang) {
                        $line[] = $existing[$otherLang][$key];
                    }
                    fputcsv($CORE_FILE, $line, ',', '"');
                } else {
                    $newKeys[$key] = $value;
                }
            }
        }

        // Write a blank line
        fputcsv($CORE_FILE, array(), ',', '"');
        foreach ($newKeys as $key => $value) {
            $line = array($key, $value);
            foreach (array_keys($this->_otherLangs) as $otherLang) {
                $otherLangValue = '';
                if (preg_match('#(.*)\[(.*?)\]#', $key, $matches)) {
                    if (!empty($existing[$otherLang][$matches[1]][$matches[2]])) {
                        $otherLangValue = html_entity_decode($existing[$otherLang][$matches[1]][$matches[2]], ENT_QUOTES, 'UTF-8');
                    }
                } else if (!empty($existing[$otherLang][$key])) {
                    $otherLangValue = html_entity_decode($existing[$otherLang][$key], ENT_QUOTES, 'UTF-8');
                }
                $line[] = $otherLangValue;
            }
            fputcsv($CORE_FILE, $line, ',', '"');
        }
        fclose($CORE_FILE);
    }

    function createPOT()
    {
        $app_base = dirname(dirname(dirname(__FILE__)));

        // Create plugin template
        $pluginLangFiles = array();
        findPluginLangFiles($app_base, $pluginLangFiles);
        $pluginWords = array();
        foreach ($pluginLangFiles as $folder => $files) {
            $path = substr($folder, strlen($app_base)+1);
            foreach ($files as $file) {
                $lang = substr($file, 0, strrpos($file, '.'));
                $words = array();
                include($folder . DIRECTORY_SEPARATOR . $file);
                foreach ($words as $key => $value) {
                    $pluginWords[$lang][$path][$key] = $value;
                }
            }
        }

        $PLUGIN_FILE = fopen($app_base . DIRECTORY_SEPARATOR . 'plugins.pot', 'w');

        $author = 'chris.nutting@openx.org';

        // Write .pot header
        fwrite($PLUGIN_FILE, '# OpenX (core strings) template.
# FIRST AUTHOR <chris.nutting@openx.org>, 2008.
#, fuzzy
msgid ""
msgstr ""
"Project-Id-Version: OpenX plugins\n"
"Report-Msgid-Bugs-To: Anna Skorupa <anna.skorupa@openx.org>\n"
"POT-Creation-Date: ' . date('Y-m-d H:iO') . '\n"
"PO-Revision-Date: YEAR-MO-DA HO:MI+ZONE\n"
"Last-Translator: Chris Nutting <chris.nutting@openx.org>\n"
"Language-Team: Translations <translations@openx.org>\n"
"MIME-Version: 1.0\n"
"Content-Type: text/plain; charset=UTF-8\n"
"Content-Transfer-Encoding: 8bit\n"

');
        // Catch the items into an array so I can detect fuzzyness
        $items = array();

        // Replace these values in the key files
        $search  = array("\n");
        $replace = array("\\n\n");

        foreach ($pluginWords[$this->_masterLang] as $file => $words) {
            foreach ($words as $key => $value) {
                if (empty($value)) { continue; }
                $itemkey = '';
                $value = str_replace($search, $replace, html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
                $lines = explode("\n", $value);
                if (count($lines) > 1) {
                    $itemkey .= "\"\"\n";
                }
                foreach ($lines as $line) {
                    $itemkey .= "\"{$line}\"\n";
                }
                $itemkey = trim($itemkey);
                if (isset($items[$itemkey])) {
                    $items[$itemkey]['fuzzy'] = true;
                    $items[$itemkey]['comment'] .= "\n#: {$key} - {$file}";
                } else {
                    $items[$itemkey] = array(
                        'comment' => $key . ' - ' . $file,
                        'fuzzy'   => false,
                        'value'   => $value,
                    );
                }
            }
        }

        foreach ($items as $itemkey => $item) {
            $entry  = "#: {$item['comment']}\n";
            if ($item['fuzzy']) {
                $entry .= "#, fuzzy\n";
            }
            $entry .= 'msgid ' . $itemkey . "\n";
            $entry .= "msgstr \"\"\n\n";
            fwrite($PLUGIN_FILE, $entry);
        }
        // Currently only the plugins .pot creation is working...
        exit();

        // Create core translations sheet (only including new translations for now)
        // Read the translation strings from the english language pack
        $this->_sortTrans();

        // Read the translation strings from the CSV files
        foreach ($this->_otherLangs as $otherLang => $csvName) {
            $langFile = dirname($this->inputFile) . DIRECTORY_SEPARATOR . $csvName . '.csv';
            $result = $this->getTranslationFromCSV($langFile);
            $existing[$otherLang] = $result[$otherLang];
        }

        // Read the master language file
        $csv = $this->getTranslationFromCSV();
        $existing['english'] = $csv['english'];

        $csvKeys = array_keys($csv['Code key']);

        // Keep the existing translations, and track any new items for addition at the end of the file
        $CORE_FILE = fopen($app_base . DIRECTORY_SEPARATOR . 'core_csv.csv', 'w');
        $header = array('Code key', $this->_masterLang);
        foreach (array_keys($this->_otherLangs) as $otherLang) {
            $header[] = $otherLang;
        }
        fputcsv($CORE_FILE, $header, ',', '"');

        foreach ($this->aMasterKey as $file => $contents) {
            foreach ($contents as $key => $value) {
                if ((substr($key, 0, 3) != 'str') || $value == 'array()') { continue; }
                if (in_array($key, $csvKeys)) {
                    $line = array($key, $existing[$this->_masterLang][$key]);
                    foreach (array_keys($this->_otherLangs) as $otherLang) {
                        $line[] = $existing[$otherLang][$key];
                    }
                    fputcsv($CORE_FILE, $line, ',', '"');
                } else {
                    $newKeys[$key] = $value;
                }
            }
        }

        // Write a blank line
        fputcsv($CORE_FILE, array(), ',', '"');
        foreach ($newKeys as $key => $value) {
            $line = array($key, $value);
            foreach (array_keys($this->_otherLangs) as $otherLang) {
                $otherLangValue = '';
                if (preg_match('#(.*)\[(.*?)\]#', $key, $matches)) {
                    if (!empty($existing[$otherLang][$matches[1]][$matches[2]])) {
                        $otherLangValue = html_entity_decode($existing[$otherLang][$matches[1]][$matches[2]], ENT_QUOTES, 'UTF-8');
                    }
                } else if (!empty($existing[$otherLang][$key])) {
                    $otherLangValue = html_entity_decode($existing[$otherLang][$key], ENT_QUOTES, 'UTF-8');
                }
                $line[] = $otherLangValue;
            }
            fputcsv($CORE_FILE, $line, ',', '"');
        }
        fclose($CORE_FILE);
    }

    function mergePOT() {
        if (empty($this->inputFile) || empty($this->potFile) || empty($this->lang)) { $this->displayHelpMsg(''); }

        if (is_dir($this->inputFile)) {
            $this->aTran = $this->loadTranslationFromDir($this->inputFile, $this->lang, false, false);

            $msgID = false;
            $msgstr = false;
            $aFile = file($this->potFile);
            foreach ( $aFile as $line => $val) {

                // check if new string
                switch ($val) {
                case (substr($val, 0, 2) == '#:'): //  new string
                    $k = substr($val, 3, -2);
                    if (substr($val, 3, 3) == 'str') {
                        $aTransID = explode(' ', $k);
                    }
                    break;
                case (substr($val, 0, 6) == 'msgstr'):
                    foreach ($aTransID as $idx => $key) {
                        // check it translation exists in lang files and add to .PO
                        if (!empty($this->aTran[$key])) {
                            $aFile[$line] = 'msgstr '. $this->aTran[$key] ."\n";
                            $aTransIDTmp[] = $key;
                        }
                    }
                    break;
                }
            }

            //  write modifications back to .PO file
            $fp = fopen($this->potFile .'.'. $this->lang, 'w');
            foreach ($aFile as $text) {
                fwrite($fp, $text);
            }
        } else {
            $this->displayHelpMsg('Path to language files is not a directory');
        }

    }

    function mergePluginPOT() {
        include realpath('../../init.php');

        if (empty($this->inputFile) || empty($this->potFile) || empty($this->lang)) { $this->displayHelpMsg(''); }

        if (is_dir($this->inputFile)) {
            $pluginLangFiles = array();
            findPluginLangFiles($this->inputFile, $pluginLangFiles);
            foreach ($pluginLangFiles as $folder => $files) {
                $path = substr($folder, strrpos($this->inputFile, '/')+1);
                foreach ($files as $file) {
                    if (substr($file, 0, strrpos($file, '.')) == $this->lang) {
                        $lang = substr($file, 0, strrpos($file, '.'));
                        $words = array();
                        include($folder . DIRECTORY_SEPARATOR . $file);
                        foreach ($words as $key => $value) {
                            $pluginWords[$lang][$path][$key] = $value;
                        }
                    }
                }
            }

            $msgID = false;
            $msgstr = false;
            $aFile = file($this->potFile);
            foreach ($aFile as $line => $val) {

                // check if new string
                switch ($val) {
                case (substr($val, 0, 2) == '#:'): //  new string
                    $aPiece = explode(' - ', substr($val, 3, -1));
                    $aTransID[] = array(
                        'key'   => $aPiece[0],
                        'path'  => $aPiece[1]
                    );
                    break;
                case (substr($val, 0, 6) == 'msgstr'):
                    if (!empty($aTransID)) {
                        foreach ($aTransID as $idx => $aVal) {
                            // check it translation exists in lang files and add to .PO
                            if (!empty($pluginWords[$this->lang][$aVal['path']][$aVal['key']])) {
                                $str = $pluginWords[$this->lang][$aVal['path']][$aVal['key']];
                                $str = str_replace("\n", '\\n'."\n", $str);
                                $aFile[$line] = 'msgstr "'. $str ."\"\n";
                            }
                        }
                    }
                    break;
                }
            }

            //  write modifications back to .PO file
            $fp = fopen($this->potFile .'.'. $this->lang, 'w');
            foreach ($aFile as $text) {
                fwrite($fp, $text);
            }
        } else {
            $this->displayHelpMsg('Path to language files is not a directory');
        }
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
        echo "\nmergePOT - Merge translations from language files into the specified POT and output PO in output_dir";
        echo "\t Parameters: \n";
        echo "\t\t lang_dir - The path where language files are stored\n";
        echo "\t\t pot_file - The path to the POT file which will be compared against the language files and used for output\n";
        echo "\t\t language - The language that is being parsed\n";

        if (!is_null($message)) {
            echo  "\n\n". $message ."\n";
        }
        die;
    }
}

function findPluginLangFiles($path, &$result) {
    if (is_dir($path)) {
        $dir = opendir($path);
        while ($file = readdir($dir)) {
            if (substr($file, 0, 1) == '.') { continue; }
            if (is_dir($path . DIRECTORY_SEPARATOR . $file)) {
                findPluginLangFiles($path . DIRECTORY_SEPARATOR . $file, $result);
            } else {
                if (substr($file, strrpos($file, '.')) == '.php' && preg_match('#_lang$#i', $path)) {
                    $result[$path][] = $file;
                }
            }
        }
    }
    return $result;
}

$trans = new OA_TranslationMaintenance();
?>
