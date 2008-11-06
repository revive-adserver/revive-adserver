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
        'persian'               => 'fa',
    );
    var $_aLang     = array (
        'english'               => 'en',
        'spanish'               => 'es',
        'german'                => 'de',
        'russian_utf8'          => 'ru',
        'pt_BR'  => 'pt_br',
        'Chinese Simplified'    => 'zh-s',
        'french'                => 'fr',
        'polish'                => 'pl',
        'indonesian'            => 'id',
        'persian'               => 'pr',
        'japanese'              => 'ja',
        'czech'                 => 'cs',
        'turkish'               => 'tr',
        'persian'               => 'fa',
        'sl'                    => 'sl',
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

    var $aConstant = array(
        'MAX_PRODUCT_NAME',
        'MAX_PRODUCT_URL',
        'OX_PRODUCT_DOCSURL',
        'OA_VERSION',
        'phpAds_dbmsname'
    );
    var $aRegex = array();

    var $oxHeader = '<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/
';

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
        // Prepare the array of regular expressions which match translation pack
        // lines, so that we can identify existing translations, and merge in new
        // translations, based on the translation keys.

        $this->aRegex[0] = "#^(.*?)\['(.*)'\](\[.*\])*(\s*=\s*)(" . implode('|', $this->aConstant)
                            . ")(\s*\.\s*)([\"])(.*)([^\\\\])([\"])(;)#sm";
        $this->aRegex[1] = "#^(.*?)\['(.*)'\](\[.*\])*(\s*=\s*)([\"])(.*)([^\\\\])([\"])(;)#sm";
        $this->aRegex[2] = "#^(.*?)\['(.*)'\](\[.*\])*(\s*=\s*)([\'])(.*)([^\\\\])([\'])(;)#sm";



        if (empty($GLOBALS['argv'][1]) && empty($GLOBALS['argv'][2])) { $this->displayHelpMsg(); }

        $this->command = $command = $GLOBALS['argv'][1];

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

        // If this is a new language, create the folder and a stub index.lang.php file
        if (!is_dir($this->outputDir)) {
            mkdir($this->outputDir);
            $INDEX_FILE = fopen($this->outputDir . '/index.lang.php', 'w');
            fwrite($INDEX_FILE, $this->oxHeader);
            fwrite($INDEX_FILE, '
// Meta information
$translation_readable   = "'. $this->lang .'";
$translation_maintainer	= "OpenX Limited";
$translation_contact	= "http://www.openx.org/community/localisation";

?>');
            fclose($INDEX_FILE);
        }

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

    function loadTranslationFromDir($dir, $lang, $escapeNewline = false, $groupByFile = true, $escapeEntities = false)
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
            echo "Processing file: {$file}\n";

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

                                $trans = ($escapeEntities) ? htmlspecialchars_decode(htmlentities($trans, null, 'UTF-8')) : $trans;

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

                                    $trans = ($escapeEntities) ? htmlspecialchars_decode(htmlentities($trans, null, 'UTF-8')) : $trans;
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
        if ($header === array('comment', 'original', 'translation')) {
            $header = array('comment', $this->_masterLang, $this->lang);
        }
        $lang = array();
        while ($row = fgetcsv($fp, 8192, ',', '"')) {
            foreach ($row as $idx => $cell) {
                // Overcome fgetcsv's inadequacies.
                $cell = $this->_fixFgetcsv($cell);


                if ($this->_addStrikeTags) {
                    //  remove double quotes from str
                    if (substr($cell, 0, 1) == '"') { $cell = substr($cell, 1); }
                    if (substr($cell, -1, 1) == '"') { $cell = substr($cell, 0, -1); }
                    $cell = "<strike>-{$cell}-</strike>";
                }
                if ($idx == 0 && strstr($row[0], ' ')) { //  check for multiple string keys, explode and populate if they exist
                    $aPiece = explode(' ', $row[0]);
                    foreach ($aPiece as $key) {
                        $lang[$header[$idx]][$key] = $key;
                    }
                } else { // add translation to master array
                    if (!empty($aPiece)) {
                        foreach ($aPiece as $key) {
                            $lang[$header[$idx]][$key] = $cell;
                        }
                    } else {
                        $lang[$header[$idx]][$row[0]] = $cell;
                    }
                }
                if ($idx == 2) {
                    unset($aPiece);
                }
            }
        }
        fclose($fp);

        return $lang;
    }

    /**
     * Plugin CSV files are created with the structure:
     * 'Code key - path/to/file(s)', 'en', 'lang'
     *
     * @param unknown_type $fileName
     * @return unknown
     */
    function loadPluginTranslationFromCSV($fileName = false)
    {
        if (!$fileName) {
            $fileName = $this->inputFile;
        }
        $fp = fopen($fileName, 'r');
        $header = fgetcsv($fp, null, ',', '"');
        if ($header === array('comment', 'original', 'translation')) {
            $header = array('comment', $this->_masterLang, $this->lang);
        }
        $lang = array();
        $nonSplitKeySubStrings = array(
            'Rich Media - ',
            'Option - noscript',
            'Option - SSL',
        );
        $nonSplitKeyReplace    = array(
            'Rich Media | ',
            'Option | noscript',
            'Option | SSL',
        );

        while ($row = fgetcsv($fp, null, ',', '"')) {
            // Overcome fgetcsv's inadequacies.
            $row[2] = $this->_fixFgetcsv($row[2]);
            // Such a god-damn hack
            $row[0] = str_replace($nonSplitKeySubStrings, $nonSplitKeyReplace, $row[0]);
            $key = explode(' - ', $row[0]);
            foreach ($key as $idx => $keyval) { $key[$idx] = str_replace($nonSplitKeyReplace, $nonSplitKeySubStrings, $key[$idx]) ; }
            for ($i = 1; $i < count($key); $i++) {
                if (strstr($key[$i], ' ')) {
                    $strEnd = strpos($key[$i], '_lang')+5;
                    $path = substr($key[$i], 0, $strEnd);
                    $k = substr($key[$i], $strEnd+1);
                    $key2 = array($k, $path);
                } else {
                    $key2 = array($key[$i]);
                }
                if (count($key2) == 1) {
                    $lang[$this->lang][$key[$i]][$key[0]] = $row[2];
                } else {
                    for ($j = 0; $j < count($key2); $j=$j+2) {
                        $lang[$this->lang][$key2[$j+1]][$key2[$j]] = $row[2];
                    }
                }
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

        echo "\n\nRESULTS:\n";
        echo " => Merged:     {$this->_new}\n";
        echo " => Maintained: {$this->_old}\n";
        echo " => Added:      {$this->_add}\n";
        echo "\n\n";
        }
    }

    function mergePluginTranslation()
    {
        //  detect if missing args
        if (empty($this->inputFile) || empty($this->outputDir)) { $this->displayHelpMsg(''); }

        if (is_dir($this->outputDir)) {
            $this->aLang = $this->loadPluginTranslationFromCSV();

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
            echo "Processing file: {$file}\n";

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
        // Load up the translations from the master language
        $aMasterLang = $this->_loadPluginTransFromFolderByLanguage($this->_masterLang);
        $aLang = $this->_loadPluginTransFromFolderByLanguage($this->lang);

        //  merge translations from CSV with plugin lang translations
        foreach ($aMasterLang as $masterPath => $aMasterWords) {
            $transPath = ltrim($masterPath, '/');
            foreach ($aMasterWords as $key => $original) {
                if (!empty($this->aLang[$this->lang][$transPath][$key])) {
                    $aLang[$masterPath][$key] = $this->aLang[$this->lang][$transPath][$key];
                }
            }
        }

        // OK so now we have $aLang which: Was loaded from the plugin/lang files
        // any recognised translations from the passed in CSV script will have overwritten them
        foreach ($this->aLang[$this->lang] as $path => $words) {
            $filename = $path . '/' . $this->lang . '.php';
            echo "Writing to <{$filename}>...\n";
            $fp = @fopen($filename, 'w');
            if ($fp === false) {
                echo "\nERROR: CANNOT OPEN $filename FOR WRITING!\n\n";
                return;
            }
            fwrite($fp, $this->oxHeader);
            fwrite($fp, "    \$words = array(\n");
            foreach($words as $key => $tran) {
                if (!empty($tran)) {
                    $tran = (strstr($tran, "\n")) ? str_replace("\n", '\n'."\n", $tran) : $tran;
                    $delimiter = (strstr($tran, '".')) ? '"' : '"';
                    $key = str_replace("'", "\\'", $key);
                    fwrite($fp, "        '$key' => ". $delimiter ."$tran". $delimiter .",\n");
                }
            }
            fwrite($fp, "    );\n");
            fwrite($fp, "?>\n");
        }
    }

    function _loadPluginTransFromFolderByLanguage($lang)
    {
        //  load plugin files
        $aPluginLangFile = array();
        findPluginLangFiles($this->outputDir, $aPluginLangFile);

        //  load plugin lang translations
        $aPluginWord = array();
        foreach ($aPluginLangFile as $folder => $files) {
            $path = substr($folder, strrpos($this->outputDir, '/')+1);
            foreach ($files as $file) {
                if (substr($file, 0, strrpos($file, '.')) == $lang) {
                    $lang = substr($file, 0, strrpos($file, '.'));
                    $words = array();
                    @include($folder . DIRECTORY_SEPARATOR . $file);
                    foreach ($words as $key => $value) {
                        $aPluginWord[$path][$key] = $value;
                    }
                }
            }
        }
        return $aPluginWord;
    }

    function _mergeVar()
    {
        //  extract key
        foreach ($this->aRegex as $regexID => $regex) {
            $strings = preg_match($regex, $this->_var, $matches);
            if (!empty($matches[2])) {
                // reconstruct key
                $key = $matches[2] . $matches[3];

                // reconstruct the original translation
                if ($regexID == 0) {
                    $origTrans = $matches[5] . $matches[6] . $matches[7] . $matches[8] . $matches[9];
                } else {
                    $origTrans = $matches[6] . $matches[7];
                }

                // set delimiter
                if ($regexID == 0) {
                    $delimiter = $matches[7];
                } else {
                    $delimiter = $matches[5];
                }

                // retrieve translation
                $trans = $this->_getTranslation($key, $origTrans, $delimiter);

                if ($origTrans == $trans) {
                    $trans = $origTrans;
                    $this->_old++;
                } else {
                    $this->_new++;
                }

                // reconstruct $this->_var with updated translation
                if ($regexID == 0) {
                    $this->_var = $matches[1] ."['". $matches[2] ."']". $matches[3] . $matches[4] . $delimiter . $trans . $delimiter . ";";
                } else {
                    $this->_var = $matches[1] ."['". $matches[2] ."']". $matches[3] . $matches[4] . $delimiter . $trans . $delimiter . ";";
                }

                if (strstr($key, "']['")) {
                    // check if it contains an array and remove if matches
                    $aPiece = explode("']['", $key);
                    $key = $aPiece[0] ."['". $aPiece[1] ."']";
                    unset($this->aLang[$this->lang][$key]);
                } else if (isset($this->aLang[$this->lang][$key])) {
                    //  remove matching translation
                    unset($this->aLang[$this->lang][$key]);
                }

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
            if ($delimiter == "'" && strstr($newTrans, "'")) {
                $newTrans = addslashes($this->aLang[$this->lang][$key]);
            } else {
                $newTrans = $this->aLang[$this->lang][$key];
            }
        }

        if (!empty($newTrans) && $newTrans != $trans) {
            // retrieve updated translation
            $trans = $newTrans;
            //  replace new lines with \n
            if ($delimiter == '"' && strstr($trans, "\n")) $trans = str_replace("\n", '\n', $trans);

        }

        //  replace line breaks with \n
        if ($delimiter == '"' && strstr($trans, "\n")) $trans = str_replace("\n", '\n', $trans);

        // replace "\-" with "-" if it appears at the beginning of the line
        // pootle adds "\" before "-" if "-" is the first character of a line
        $position = stripos($trans, "\-");
        if($position !== false && $position == 0) $trans = substr($trans, 1);

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
            case T_CURLY_OPEN:
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

            echo "\nADDING NEW TRANSLATIONS TO FILE: $file\n";
            echo "--------------------------------";
            for ($counter = 0; $counter < strlen($file); $counter++) {
                echo "-";
            }
            echo "\n";

            // Create a template file to use if one doesn't already exist
            if (!is_file($this->outputDir .'/'. $file)) {
                $OUT_FILE = fopen($this->outputDir .'/'. $file, 'w');
                fwrite($OUT_FILE, $this->oxHeader . "\n?>");
                fclose($OUT_FILE);
            }

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
                        $line = "\n\n// Note: New translations not found in original lang files but found in CSV\n";
                        fwrite($fp, $line);

                        //  write translations not found in original lang files but
                        //  are present in CSV
                        $delimiter = '"';
                        foreach ($aValue as $key => $trans) {

                            $trans = $this->aLang[$this->lang][$file][$key];
                            $trans = str_replace(array("\n", "\r"), array('\n', '\r'), $trans);

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
                                    if (preg_match("/^\['.+'\]$/", $k)) {
                                        $k = "'" . substr($k, 2, -2) . "'";
                                    } else {
                                        $k = substr($k, 1, -1);
                                    }
                                    $line = "\$GLOBALS['{$key}'][{$k}] = \"{$trans}\";\n";
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
            echo "Processing file: {$file}\n";

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
        if (!empty($this->aLang[$this->lang])) {
            foreach ($this->aLang[$this->lang] as $key => $value) {
                $aLang['default.lang.php'][$key] = $value;
            }
        }
        if (!empty($aLang)) {
            $this->aLang[$this->lang] = $aLang;
        }
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
                $line[] = $value;
                foreach (array_keys($this->_otherLangs) as $otherLang) {
                    $line[] = (!empty($pluginWords[$otherLang][$file][$key])) ? $pluginWords[$otherLang][$file][$key] : '';
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
                        $otherLangValue = $existing[$otherLang][$matches[1]][$matches[2]];
                    }
                } else if (!empty($existing[$otherLang][$key])) {
                    $otherLangValue = $existing[$otherLang][$key];
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
                $value = str_replace($search, $replace, $value);
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
                        $otherLangValue = $existing[$otherLang][$matches[1]][$matches[2]];
                    }
                } else if (!empty($existing[$otherLang][$key])) {
                    $otherLangValue = $existing[$otherLang][$key];
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
            $this->aTran = $this->loadTranslationFromDir($this->inputFile, $this->lang, false, false, false);

            $fp = fopen($this->potFile .'.'. $this->lang, 'w');
            $aFile = file($this->potFile);
            foreach ( $aFile as $line => $val) {

                // check if new string
                switch ($val) {
                case (substr($val, 0, 2) == '#:'): //  new string
                    $k = substr($val, 3, -2);
                    if (substr($val, 3, 3) == 'str') {
                        $aTransID = explode(' ', $k);
                    }
                    fwrite($fp, $val);
                    break;
                case (substr($val, 0, 6) == 'msgstr'):

                    if (!empty($aTransID)) {
                        foreach ($aTransID as $idx => $key) {
                            // check it translation exists in lang files and add to .PO
                            if (!empty($this->aTran[$key])) {
                                $aPiece = array();
                                $str = $this->aTran[$key];
                                if (strstr($str, '\"')) $str = stripslashes($str);

                                //  is it a multiline translation
                                if (strstr($str, "\n")) {
                                    $aPiece = explode("\n", $str);
                                    $total = count($aPiece);

                                    fwrite($fp, "msgstr \"\"\n");

                                    for ($x = 0; $x < $total; $x++) {
                                       $str = trim($aPiece[$x]);
                                        //  remove prefixed or trailing double quotes
                                        if (substr($str, 0, 1) == '"' && substr($str, -1, 1) !='"') { // begins with a "
                                            $str = substr($str, 1);
                                        }
                                        if (substr($str, -1, 1) == '"' && substr($str, 0, 1) != '"') {// ends with a "
                                            $str = substr($str, 0, -1);
                                        }
                                        if (substr($str, 0, 1) == '"' && substr($str, -1, 1) =='"') { // surrounded with "
                                            $str = substr($str, 1, -1);
                                        }
                                        if (substr($str, -2, 2) == '".') { // ends with ".
                                            $str = substr($str, 0, -2);
                                        }

                                        //  does line begin with constant?
                                        if (in_array(substr($str, 0, strpos($str, ' ')), $this->aConstant)) {
                                            fwrite($fp, "\"\".". addslashes($str) ."\\n\"\n");
                                        } else {
                                            fwrite($fp, "\"". addslashes($str) ."\\n\"\n");
                                        }
                                    }
                                } else {
                                    //  check if trans begins withs a var or constant
                                    if (substr($str, 0, 1) != '"') {
                                        fwrite($fp, 'msgstr "\"\".'. addslashes($str) ."\n");
                                    } else {
                                        fwrite($fp, 'msgstr "'. substr($str, 1, -1) ."\"\n");
                                    }
                                }
                            } else {
                              fwrite ($fp, "msgstr \"\"\n");
                            }
                            break;
                        }
                        $aTransID = array();
                    }
                    break;
                default;
                    fwrite($fp, $val);
                    break;
                }
            }
        } else {
            $this->displayHelpMsg('Path to language files is not a directory');
        }

    }

    function mergePluginPOT() {
        include realpath('/opt/local/apache2/htdocs/ox2711/init.php');

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
            $fp = fopen($this->potFile .'.'. $this->lang, 'w');
            foreach ($aFile as $line => $val) {

                // check if new string
                switch ($val) {
                case (substr($val, 0, 2) == '#:'): //  new string
                    $aPiece = explode(' - ', substr($val, 3, -1));
                    $aTransID[] = array(
                        'key'   => $aPiece[0],
                        'path'  => $aPiece[1]
                    );
                    fwrite($fp, $val);
                    break;
                case (substr($val, 0, 6) == 'msgstr'):
                    if (!empty($aTransID)) {
                        foreach ($aTransID as $idx => $aVal) {
                            // check it translation exists in lang files and add to .PO
                            if (!empty($pluginWords[$this->lang][$aVal['path']][$aVal['key']])) {
                                $str = $pluginWords[$this->lang][$aVal['path']][$aVal['key']];
                                if (strstr($str, "\n")) {
                                    $aPiece = explode("\n", $str);
                                    fwrite($fp, "msgstr \"\"\n");
                                    $total = count($aPiece);
                                    for ($x = 0; $x < $total; $x++) {
                                        $newlineClause = ($x+1 == $total) ? '' : "\n";
                                        fwrite($fp, "\"{$aPiece[$x]}\\n\"$newlineClause");
                                    }
                                } else {
                                    fwrite($fp, 'msgstr "'. $str ."\"\n");
                                }
                            } else {
                                fwrite ($fp, "msgstr \"\"\n");
                            }
                            break;
                        }
                        $aTransID = array();
                    } else {
                       fwrite ($fp, "msgstr \"\"\n");
                    }
                    break;
                default:
                    fwrite($fp, $val);
                    break;
                }
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

    function _fixFgetcsv($cell) {
        // Sonofa**** fgetcsv. If anyone really knows why it doesn't
        // parse CSV files correctly, please let us know. In the mean
        // time, all of the following are to deal with the fact that
        // it just won't read in the strings from CSV like it should.
        $cell = str_replace('\\"""', '\\"', $cell);
        $cell = str_replace('."""', '."', $cell);
        $cell = str_replace('\\""', '\\"', $cell);
        $cell = str_replace('"".', '".', $cell);
        $cell = str_replace('.""', '."', $cell);
        // Also deal with the special case of strings that end with a
        // doublequote, which may be incorrect, unless the character
        // is prefixed with a backslash (in which case, it's supposed
        // to be there, as it will appear in the string), or unless
        // the character is prefixed with one of the known constants
        // and a ".", in which case it's also valid, as it's the
        // termination of a concatenated constant
        if (preg_match('/"$/', $cell)) {
            // Is the final " mark prefixed with a backslash?
            if (!preg_match('/\\\"$/', $cell)) {
                // No. Is the final " mark prefixed with a known
                // constant?
                foreach ($this->aConstant as $constant) {
                    $pattern = '/' . "$constant" . '\s*\.\s*"$/';
                    if (preg_match($pattern, $cell)) {
                        // Yes. It's good.
                        break;
                    }
                    // No. Remove the final " mark, it's bad.
                    $cell = preg_replace('/"$/', '', $cell);
                }
            }
        }
        return $cell;
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
