<?php

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

/**
 * This script will parse the files in www/delivery_dev and save the compiled
 * delivery engine files in the www/delivery folder
 *
 * I added the init.php script to gain access to MAX_PATH, however this now requires
 * that the application is installed, this may be
 *
 * @package    OpenXMaintenance
 * @subpackage Tools
 * @author     Heiko Weber <heiko@wecos.de>
 * @author     Chris Nutting <Chris.Nutting@openx.org>
 */

// protect this script to be used only from command-line
if (php_sapi_name() != 'cli') {
    echo "Sorry, this tool must be run from the command-line";
    exit;
}

// Set the MAX_PATH constant (this assumes that the script is located in MAX_PATH . '/scripts'
// Note we may change this to require(../../init.php) which would give access to installed $conf
// Which could be used to compile in the delivery engine Dal for this installation?
define('MAX_PATH', dirname(dirname(dirname(__FILE__))));

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

# enable/disable full comment in output
$c_echo_comment = false;

# like to see original whitespace or just reduced to minimum
$c_echo_white   = false;

# debug, add token information
$c_dump_token   = false;

# set to false if Pear should not be included
# can also be set to OA's pear path, to slurp the pear, too.
$c_OA_Pear      = false; # 'lib/pear';

$ignored_files = array('template.php');

define('STATE_STD',             1);     # normal, copy input to output
define('STATE_REQUIRE',         2);     # require found, wait to complete filename
define('STATE_REQUIRE_ONCE',    3);     # require_once found, wait ...

/**
 * This function checks if the token $id is a comment
 *
 * @param int $id
 * @return boolean true if $id is a comment type
 */
function _is_comment($id)
{
    return  ($id === T_COMMENT || $id === T_ML_COMMENT || $id === T_DOC_COMMENT);
}

/**
 * Parse the file uses the PHP tokeniser to analyse a php script and pull included/required files inline
 *
 * @param string $filename The full/path/to the file to be processed
 * @return string The compiled script contents
 */
function _parse_file($filename)
{
    global $c_echo_comment;
    global $c_dump_token;
    global $c_echo_white;
    global $only_once;
    global $inside_php;

    // Track included files to allow require_once/include_once to work correctly
    $only_once[getcwd() . '/' . $filename] = true;

    // Read the file
    $source = file_get_contents($filename);
    // Tokenize the source
    $tokens = token_get_all($source);
    // Start in standard state
    $state = STATE_STD;
    // Track if we are in a STRIP_DELIVERY codeblock
    $strip_delivery = false;

    // Track if we just output a newline
    $was_nl = false;
    // The compiled script goes in here, return value
    $ret = '';
    // If we meet a require/require_once, we store the filename here for recursion
    // (the filename may be build by concatination ...)
    $cur = '';
    // Hold the original content we left off from start of a require/require_once, so
    // if we are currently waiting for the filename to be completed, and realize a
    // dynamic filename (i.e. T_VARIABLE), we can give up on this filename, and
    // output the original, unchanged source
    $orig = '';

    // Iterate over the file tokens (note: grey magic ;)
    foreach ($tokens as $token) {
        if (is_string($token)) {
            // next token is a none special, simple character
            // we can clear newline-flag ...
            $was_nl = false;

            // if we currently strip off none delivery code, ignore
            // this token, start with next
            if ($strip_delivery)
                continue;

            // in normal state, just add to our return buffer
            if ($state === STATE_STD)
                $ret .= $token;
            else {
                // we waiting to complete a require/require_once, so
                // this is just happen !!!
                if ($token === ';') {
                    switch($state) {
                        case STATE_REQUIRE_ONCE:
                            // if we have done this file, don't slurp it again
                            if (array_key_exists($cur, $only_once))
                                break;
                            //fall through
                        case STATE_REQUIRE:
                            // try to load the file, if ...
                            if (!($content = _flatten_file($cur))) {
                                // we are unable to slurp it, just add the original
                                // require-statement into our buffer
                                $ret .= $orig . ";\n";
                            } else {
                                $ret .= $content;
                            }
                            break;
                    }
                    // require/require_once statement finished, return to normal
                    $state = STATE_STD;
                } else {
                    // we are currently collecting a require/require_once filename,
                    // so keep the original content
                    $orig .= $token;
                    // and capture the filename if not the concat op.
                    if (strpos('.()', $token) === false)
                        $cur .= $token;
                }
            }

        } else {
           // token array
            list($id, $text) = $token;

            // if we currently strip off none delivery code, we could leave
            // this mode only in a comment ...
            if ($strip_delivery && !_is_comment($id))
                continue;

            // is last was a newline and we don't like whitespace ...
            if ($was_nl && !$c_echo_white) {
                // ... but this is one, cont. on next token
                if ($id === T_WHITESPACE)
                    continue;
                else if (!$c_echo_comment && _is_comment($id))
                    ; // a comment should not trigger out newline-flag
                else
                    $was_nl = false;
            }

            if ($c_dump_token)
                $ret .= "[$id:".token_name($id).":" . $text . "]";

            switch ($id) {
                case T_COMMENT:
                case T_ML_COMMENT: // we've defined this
                case T_DOC_COMMENT: // and this
                    // comments are only added on request
                    // check if we reach or leave a none-delivery-code secition
                    // and set flag ...
                    if ($c_echo_comment) {
                        if ($state === STATE_STD)
                            $ret .= $text;
                    }
                    if ($strip_delivery) {
                        if (strstr($text, '###END_STRIP_DELIVERY') !== false)
                            $strip_delivery = false;
                    } else {
                        if (strstr($text, '###START_STRIP_DELIVERY') !== false)
                            $strip_delivery = true;
                    }
                    break;

                case T_OPEN_TAG:
                    // keep track of begin/end php-code sections, to avoid
                    // have more than one begin or end in our result code
                    if ($inside_php == 0)
                        $ret .= $text;
                    $inside_php++;
                    break;

                case T_CLOSE_TAG:
                    $inside_php--;
                    if ($inside_php == 0)
                        $ret .= $text;
                    break;

                case T_REQUIRE:
                    // require found
                    $state = STATE_REQUIRE;
                    // clear out filename buffer
                    $cur = '';
                    // start collecting the original content
                    $orig = $text;
                    break;

                case T_REQUIRE_ONCE:
                    // require_once found, see above
                    $state = STATE_REQUIRE_ONCE;
                    $cur = '';
                    $orig = $text;
                    break;

                case T_CONSTANT_ENCAPSED_STRING:
                    // just a string with quotes
                    if ($state === STATE_STD)
                        $ret .= $text;
                    else {
                        // strip off the quotes and add to filename
                        $cur .= substr($text, 1, strlen($text)-2);
                        $orig .= $text;
                    }
                    break;

                case T_VARIABLE:
                    if ($state === STATE_STD)
                        $ret .= $text;
                    else {
                        // sorry boy, dynamic filename found
                        // append the original code to the output
                        // and return to normal state
                        $ret .= $orig . $text;
                        $state = STATE_STD;
                    }
                    break;

                case T_STRING:
                    if ($state === STATE_STD)
                        $ret .= $text;
                    else {
                        // a require/require_once path may contain our
                        // special MAX_PATH, so add the real value instead
                        if ($text === 'MAX_PATH') {
                            $cur .= MAX_PATH;
                        }
                        $orig .= $text;
                    }
                    break;

                case T_WHITESPACE:
                    // one or more spaces, newlines, ...
                    if ($state === STATE_STD) {
                        if ($c_echo_white)
                            $ret .= $text;
                        else if (strstr($text, "\n") !== false) {
                            // a newline found, set our flag to avoid
                            // multiple empty lines
                            $was_nl = true;
                            $ret .= "\n";
                        } else {
                            // reduce incoming spaces to a single one
                            $ret .= ' ';
                        }
                    } else {
                        $orig .= $text;
                    }
                    break;

                default:
                    if ($state === STATE_STD)
                        $ret .= $text;
                    else {
                        $cur .= $text;
                        $orig .= $text;
                    }
                    break;
            }
        }
    }
    return $ret;
}

/**
 * This function is called recursively to slurp the contents of an included or required file
 *
 * For the reasons we do this:
 *  @see https://developer.openx.org/wiki/OptimizationPractices#GenerateDeliveryAntTask
 *
 * @param string $filename The value passed to the include/require call
 * @return The
 */
function _flatten_file($filename)
{
    global $c_OA_Pear;

    // Skip dynamicly included files
    if (strpos($filename, '$') !== false) {
        return false;
    }

    // ?
    if ($pos = strrpos($filename, '/')) {
        $cwd = getcwd();
        $dir = substr($filename, 0, $pos);
        if (!file_exists($dir . '/.') || !chdir($dir)) {
            if ($c_OA_Pear === false) {
                return false;
            }

            // try to use OA's pear instead
            $dir = MAX_PATH . '/' . $c_OA_Pear . '/' . $dir;
            chdir($dir);
        }
        $ret = _parse_file(substr($filename, $pos+1));
        chdir($cwd);
        return $ret;
    } else {
        if (file_exists($filename))
            return _parse_file($filename);
        else {
            if ($c_OA_Pear === false) {
                return false;
            }

            //try pear
            $cwd = getcwd();
            $dir = MAX_PATH . '/' . $c_OA_Pear;
            chdir($dir);
            $ret = _parse_file($filename);
            chdir($cwd);

            return $ret;
        }
    }
}

/**
 * Replace the opening <?php with the licence header
 * and do funky stuff with the MAX_PATH constant (???)
 *
 * @param string $code The compiled script contents
 * @return string The cleaned up script contents.
 */
function _final_cleanup($code)
{
    global $header;
    // Replace the initial <?php with the licence header
    $code = preg_replace('#^\<\?php\n+#is', $header, $code);

    // Modify the MAX_PATH define ... (why?)
    // from: define('MAX_PATH', dirname(__FILE__));
    // to:   define('MAX_PATH', dirname(__FILE__).'/../..');
    $code = preg_replace('/(define\(\'MAX_PATH\',\s*dirname\(__FILE__\))(\))/',
                          '${1}.\'/../..\'${2}',
                          $code);
    return $code;
}

/**
 * I just wanted to track the exact time taken to recomplie the delivery engine
 *
 * On my laptop, this takes ~ 12.6s/6.8s (PHP4/PHP5)
 * interesting that PHP5 is so much faster (the resulting files are identical)
 *
 * @return float MicroTime in milliseconds
 */
function get_microtime()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

// Source folder for the file to be processed
$input_dir  = MAX_PATH . '/www/delivery_dev/';
// Destination folder for the compiled scripts
$output_dir = MAX_PATH . '/www/delivery/';

$start_time = get_microtime();

$DIR_INPUT  = opendir($input_dir);
$DIR_OUTPUT = opendir($output_dir);

$header = file_get_contents($input_dir . 'template.php');
$header = preg_replace('#(.*)ant generate-delivery(.*)\n+\{TEMPLATE\}.*#is', "$1php " . $_SERVER['SCRIPT_FILENAME'] . "$2\n", $header);

// Process all files in the www/delivery_dev folder (except those being explicitly ignored)
while ($file = readdir($DIR_INPUT)) {
    // Skip hidden file, directories, and ignored files
    if ((substr($file, 0, 1) == '.') || is_dir($input_dir . $file) || in_array($file, $ignored_files)) { continue; }
    $ext = substr($file, strrpos($file, '.'));

    $only_once = array();
    $inside_php = 0;

    // Switching on extension may be useful if we want to do other things (e.g. Recompress the fl.js file?)
    switch ($ext) {
        case '.php':
            $FILE_OUT = @fopen($output_dir . $file, 'w');
            if (!is_resource($FILE_OUT)) {
                echo "Unable to open output file for writing: {$output_dir}{$file}\n";
                continue;
            }
            echo "Processing php file: {$file}\n";
            $code = _final_cleanup(_flatten_file($input_dir . $file));
            fwrite($FILE_OUT, $code);
            fclose($FILE_OUT);
        break;
        default:
            echo "{$file} is not a php file, leaving untouched\n";
            continue;
        break;
    }
}
$end_time = get_microtime();

echo "Finished recompiling delivery engine (Time taken: " . ($end_time - $start_time) . "s)\n";

?>
