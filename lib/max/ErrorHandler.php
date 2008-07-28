<?php
/* Reminder: always indent with 4 spaces (no tabs). */
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

//  This class was taken from Seagull: http://seagull.phpkitchen.com
require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/Max.php';

require_once OX_PATH . '/lib/OX.php';

/**
 * Global error handler class, modifies behaviour for PHP errors, not PEAR.
 *
 * @package Openads
 * @author  Peter James <petej@shaman.ca>
 * @author  Demian Turner <demian@phpkitchen.com>
 */
class MAX_ErrorHandler
{
    var $errorType = array();
    var $sourceContextOptions = array();

    /**
     * Constructor.
     *
     * @access  public
     * @return  void
     */
    function MAX_ErrorHandler()
    {
        //  first dimension elements are PHP error types
        //  2nd dimension elements are roughly PEAR Log's equivalents

        //  nb: comment out Notice for equivalent of
        //  error_reporting(E_ALL ^ E_NOTICE);
        $this->errorType = array (
               1   =>  array('Error', 3),
               2   =>  array('Warning', 4),
               4   =>  array('Parsing Error', 3),
               8   =>  array('Notice', 5),
               16  =>  array('Core Error', 3),
               32  =>  array('Core Warning', 4),
               64  =>  array('Compile Error', 3),
               128 =>  array('Compile Warning', 4),
               256 =>  array('User Error', 3),
               512 =>  array('User Warning', 4),
               1024=>  array('User Notice', 5),
               2047=>  array('All', 7)
                );
        $this->sourceContextOptions = array('lines' => 5);
    }

    /**
     * BC hack to assign custom error handler in a method.
     *
     * @access  public
     * @return  void
     */
    function startHandler()
    {
        $GLOBALS['_MAX']['ERROR_HANDLER_OBJECT'] =  & $this;
        $GLOBALS['_MAX']['ERROR_HANDLER_METHOD'] =  'errHandler';

        //  inner function to handle redirection to a class method
        function eh($errNo, $errStr, $file, $line, $context)
        {
            call_user_func(array(
               &$GLOBALS['_MAX']['ERROR_HANDLER_OBJECT'],
                $GLOBALS['_MAX']['ERROR_HANDLER_METHOD']),
                $errNo, $errStr, $file, $line, $context
            );
        }
        //  start handling errors
        set_error_handler('eh');
    }

    /**
     * Enhances PHP's default error handling.
     *
     *  o overrides notices in certain cases
     *  o obeys @muffled errors,
     *  o error logged to selected target
     *  o context info presented for developer
     *  o error data emailed to admin if theshold passed
     *
     * @access  public
     * @param   int     $errNo      PHP's error number
     * @param   string  $errStr     PHP's error message
     * @param   string  $file       filename where error occurred
     * @param   int     $line       line number where error occurred
     * @param   string  $context    contextual info
     * @return  void
     */
    function errHandler($errNo, $errStr, $file, $line, $context)
    {
        //  if an @ error suppression operator has been detected (0) return null
        if (error_reporting() == 0) {
            return null;
        }
        $conf = $GLOBALS['_MAX']['CONF'];
        // do not show notices
        if ($conf['debug']['errorOverride'] == true) {
            if ($errNo == E_NOTICE) {
                return null;
            }
        }
        if (in_array($errNo, array_keys($this->errorType))) {
            //  final param is 2nd dimension element from errorType array,
            //  representing PEAR error codes mapped to PHP's

            OA::debug($errStr, $this->errorType[$errNo][1]);

            //  if a debug sesssion has been started, or the site in in
            //  development mode, send error info to screen
            if (!$conf['debug']['production']) {
                $source = $this->_getSourceContext($file, $line);
                //  generate screen debug html
                //  type is 1st dimension element from $errorType array, ie,
                //  PHP error code
                $output = <<<EOF
<hr />
<p class="error">
  <strong>MESSAGE</strong>: $errStr<br />
  <strong>TYPE:</strong> {$this->errorType[$errNo][0]}<br />
  <strong>FILE:</strong> $file<br />
  <strong>LINE:</strong> $line<br />
  <strong>DEBUG INFO:</strong>
  <p>$source</p>
</p>
<hr />
EOF;
                echo $output;
            }

            //  email the error to admin if threshold reached
            //  never send email if error occured in test
            //
            $emailAdminThreshold = is_numeric($conf['debug']['emailAdminThreshold']) ? $conf['debug']['emailAdminThreshold'] :
                @constant($conf['debug']['emailAdminThreshold']);
            if ($conf['debug']['sendErrorEmails'] && !defined('TEST_ENVIRONMENT_RUNNING') && $this->errorType[$errNo][1] <= $emailAdminThreshold) {
                //  get extra info
                $oDbh =& OA_DB::singleton();
                $lastQuery = $oDbh->last_query;
                $aExtraInfo['callingURL'] = $_SERVER['SCRIPT_NAME'];
                $aExtraInfo['lastSQL'] = isset($oDbh->last_query) ? $oDbh->last_query : null;
                $aExtraInfo['clientData']['HTTP_REFERER'] =& $_SERVER['HTTP_REFERER'];
                $aExtraInfo['clientData']['HTTP_USER_AGENT'] =& $_SERVER['HTTP_USER_AGENT'];
                $aExtraInfo['clientData']['REMOTE_ADDR'] =& $_SERVER['REMOTE_ADDR'];
                $aExtraInfo['clientData']['SERVER_PORT'] =& $_SERVER['SERVER_PORT'];

                //  store formatted output
                ob_start();
                print_r($aExtraInfo);
                $info = ob_get_contents();
                ob_end_clean();

                //  rebuild error output w/out html
                $crlf = "\n";
                $output = $errStr . $crlf .
                    'type: ' . $this->errorType[$errNo][0] . $crlf .
                    'file: ' . $file . $crlf .
                    'line: ' . $line . $crlf . $crlf;
                $message = $output . $info;
                @mail($conf['debug']['email'], $conf['debug']['emailSubject'], $message);
            }
        }
    }

    /**
     * Provides enhanced error info for developer.
     *
     * Gives 10 lines before and after error occurred, hightlight erroroneous
     * line in red.
     *
     * @access  private
     * @param   string  $file       filename where error occurred
     * @param   int     $line       line number where error occurred
     * @param   string  $context    contextual info
     * @return  string  contextual error info
     */
    function _getSourceContext($file, $line)
    {
    	$sourceContext = null;

        //  check that file exists
        if (!file_exists($file)) {
            $sourceContext = "Context cannot be shown - ($file) does not exist";
        //  check if line number is valid
        } elseif ((!is_int($line)) || ($line <= 0)) {
            $sourceContext = "Context cannot be shown - ($line) is an invalid line number";
        } else {
	        $lines = file($file);

	        //  get the source ## core dump in windows, scrap colour highlighting :-(
	        //  $source = highlight_file($file, true);
	        //  $lines = split("<br />", $source);
	        //  get line numbers
	        $start = $line - $this->sourceContextOptions['lines'] - 1;
	        $finish = $line + $this->sourceContextOptions['lines'];

	        //  get lines
	        if ($start < 0) {
	            $start = 0;
	        }

	        if ($start >= count($lines)) {
	            $start = count($lines) -1;
	        }

	        for ($i = $start; $i < $finish; $i++) {
	            //  highlight line in question
	            if ($i == ($line - 1)) {
	                $context_lines[] = '<div class="error"><strong>' . ($i + 1) .
	                    "\t" . strip_tags($lines[$line -1]) . '</strong></div>';
	            } else {
	                $context_lines[] = '<strong>' . ($i + 1) .
	                    "</strong>\t" . $lines[$i];
	            }
	        }

	        $sourceContext = trim(join("<br />\n", $context_lines)) . "<br />\n";
        }

        return $sourceContext;
    }
}
?>