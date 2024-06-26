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

define('STATE_STD', 1);     # normal, copy input to output
define('STATE_REQUIRE', 2);     # require found, wait to complete filename
define('STATE_REQUIRE_ONCE', 3);     # require_once found, wait ...

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/OX.php';

/**
 * This code munger reads files which are included by PHP and merge them into one final
 * folder. The reason why this is done is performance, for more information see:
 * https://developer.openx.org/wiki/OptimizationPractices#GenerateDeliveryAntTask
 *
 * It allows to parse the files in www/delivery_dev and save the compiled
 * delivery engine files in the www/delivery folder
 *
 * I added the init.php script to gain access to MAX_PATH, however this now requires
 * that the application is installed, this may be
 *
 * @package    OpenX
 * @subpackage Utils
 */
class OX_Util_CodeMunger
{
    /**
     * enable/disable full comment in output
     */
    private $echoComment = false;

    /**
     * like to see original whitespace or just reduced to minimum
     */
    private $echoWhite = false;

    /**
     * debug, add token information
     */
    private $dumpToken = false;

    /**
     * set to false if Pear should not be included
     * can also be set to OA's pear path, to slurp the pear, too.
     */
    private $OA_Pear = false; # 'lib/pear';

    /**
     * Header used to generate the output PHP within
     *
     * @var string
     */
    private $header;

    private $onlyOnce = [];
    private $insidePhp = 0;

    public function resetCounters()
    {
        $this->onlyOnce = [];
        $this->insidePhp = 0;
    }

    /**
     * Sets the default header
     *
     * @param string $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * This function is called recursively to slurp the contents of an included or required file
     *
     * For the reasons we do this:
     *  @see https://developer.openx.org/wiki/OptimizationPractices#GenerateDeliveryAntTask
     *
     * @param string $filename The value passed to the include/require call
     * @return string|false The flattened file
     */
    public function flattenFile($filename)
    {
        // Skip dynamicly included files
        if (str_contains($filename, '$')) {
            return false;
        }

        // ?
        if ($pos = strrpos($filename, '/')) {
            $cwd = getcwd();
            $dir = substr($filename, 0, $pos);
            if (!file_exists($dir . '/.') || !chdir($dir) || (str_ends_with($dir, 'lib/pear'))) {
                if ($this->OA_Pear === false) {
                    return false;
                }

                // try to use OA's pear instead
                $dir = MAX_PATH . '/' . $this->OA_Pear . '/' . $dir;
                chdir($dir);
            }
            $ret = $this->parseFile(substr($filename, $pos + 1));
            chdir($cwd);
            return $ret;
        } elseif (file_exists($filename)) {
            return $this->parseFile($filename);
        } else {
            if ($this->OA_Pear === false) {
                return false;
            }

            //try pear
            $cwd = getcwd();
            $dir = MAX_PATH . '/' . $this->OA_Pear;
            chdir($dir);
            $ret = $this->parseFile($filename);
            chdir($cwd);

            return $ret;
        }
    }

    /**
     * Replace the opening <?php with the licence header
     * and do funky stuff with the MAX_PATH constant (???)
     *
     * @param string $code The compiled script contents
     * @return string The cleaned up script contents.
     */
    public function finalCleanup($code)
    {
        // Replace the initial <?php with the licence header
        $code = preg_replace('#^\<\?php[\n\r]+#is', $this->header, $code);

        // Modify the MAX_PATH define due to __DIR__ point \www\delivery in delivery scripts
        // from: define('MAX_PATH', __DIR__);
        // to:   define('MAX_PATH', __DIR__.'/../..');
        $code = preg_replace(
            '/(define\(\'MAX_PATH\',\s*__DIR__)(\))/',
            '${1}.\'/../..\'${2}',
            $code,
        );
        return $code;
    }

    /**
     * Parse the file uses the PHP tokeniser to analyse a php script and pull included/required files inline
     *
     * @param string $filename The full/path/to the file to be processed
     * @return string The compiled script contents
     */
    public function parseFile($filename)
    {
        // Don't try and process the file if the tokenizer isn't available
        if (!function_exists('token_get_all')) {
            return false;
        }

        // Track included files to allow require_once/include_once to work correctly
        $thisFile = OX::realPathRelative(getcwd() . '/' . $filename);
        $this->onlyOnce[$thisFile] = true;

        // Read the file
        $source = file_get_contents($filename);
        // Tokenize the source
        $tokens = token_get_all($source);
        // Start in standard state
        $state = STATE_STD;
        // Track if we are in a STRIP_DELIVERY codeblock
        $strip_delivery = false;

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
                // if we currently strip off none delivery code, ignore
                // this token, start with next
                if ($strip_delivery) {
                    continue;
                }

                // in normal state, just add to our return buffer
                if ($state === STATE_STD) {
                    $ret .= $token;
                } elseif ($token === ';') {
                    // we waiting to complete a require/require_once, so
                    // this is just happen !!!
                    switch ($state) {
                        case STATE_REQUIRE_ONCE:
                            // if we have done this file, don't slurp it again
                            $thisfile = OX::realPathRelative($cur);
                            if (array_key_exists($thisfile, $this->onlyOnce)) {
                                break;
                            }
                            //fall through
                            // no break
                        case STATE_REQUIRE:
                            // try to load the file, if ...
                            if (!($content = $this->flattenFile($cur))) {
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
                    if (!str_contains('.()', $token)) {
                        $cur .= $token;
                    }
                }
            } else {
                // token array
                [$id, $text] = $token;

                // if we currently strip off none delivery code, we could leave
                // this mode only in a comment ...
                if ($strip_delivery && !$this->isComment($id)) {
                    continue;
                }

                if ($this->dumpToken) {
                    $ret .= "[$id:" . token_name($id) . ":" . $text . "]";
                }

                switch ($id) {
                    case T_COMMENT:
                    case T_DOC_COMMENT:
                        // comments are only added on request
                        // check if we reach or leave a none-delivery-code secition
                        // and set flag ...
                        if ($this->echoComment) {
                            if ($state === STATE_STD) {
                                $ret .= $text;
                            }
                        }
                        if ($strip_delivery) {
                            if (str_contains($text, '###END_STRIP_DELIVERY')) {
                                $strip_delivery = false;
                            }
                        } elseif (str_contains($text, '###START_STRIP_DELIVERY')) {
                            $strip_delivery = true;
                        }
                        break;

                    case T_OPEN_TAG:
                        // keep track of begin/end php-code sections, to avoid
                        // have more than one begin or end in our result code
                        if ($this->insidePhp == 0) {
                            $ret .= $text;
                        }
                        $this->insidePhp++;
                        break;

                    case T_CLOSE_TAG:
                        $this->insidePhp--;
                        if ($this->insidePhp == 0) {
                            $ret .= $text;
                        }
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
                        if ($state === STATE_STD) {
                            $ret .= $text;
                        } else {
                            // strip off the quotes and add to filename
                            $cur .= substr($text, 1, strlen($text) - 2);
                            $orig .= $text;
                        }
                        break;

                    case T_VARIABLE:
                        if ($state === STATE_STD) {
                            $ret .= $text;
                        } else {
                            // sorry boy, dynamic filename found
                            // append the original code to the output
                            // and return to normal state
                            $ret .= $orig . $text;
                            $state = STATE_STD;
                        }
                        break;

                    case T_STRING:
                        if ($state === STATE_STD) {
                            $ret .= $text;
                        } else {
                            // a require/require_once path may contain our
                            // special MAX_PATH, so add the real value instead
                            if ($text === 'MAX_PATH') {
                                $cur .= MAX_PATH;
                            }
                            if ($text === 'OX_PATH') {
                                $cur .= OX_PATH;
                            }
                            $orig .= $text;
                        }
                        break;

                    case T_WHITESPACE:
                        // one or more spaces, newlines, ...
                        if ($state === STATE_STD) {
                            if ($this->echoWhite) {
                                $ret .= $text;
                            } elseif (str_contains($text, "\n")) {
                                switch (substr($ret, -1)) {
                                    case "\n":
                                        break;
                                    case " ":
                                        // replace whitespace with newline
                                        $ret[strlen($ret) - 1] = "\n";
                                        break;
                                    default:
                                        $ret .= "\n";
                                }
                            } else {
                                switch (substr($ret, -1)) {
                                    case "\n":
                                    case " ":
                                        // avoid duplicate whitespace
                                        break;
                                    default:
                                        $ret .= " ";
                                }
                            }
                        } else {
                            $orig .= $text;
                        }

                        break;

                    default:
                        if ($state === STATE_STD) {
                            $ret .= $text;
                        } else {
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
     * This function checks if the token $id is a comment
     *
     * @param int $id
     * @return boolean true if $id is a comment type
     * @static
     */
    private function isComment($id)
    {
        return ($id === T_COMMENT || $id === T_DOC_COMMENT);
    }
}
