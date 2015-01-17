<?php
/**
 * PEAR_RunTest
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   pear
 * @package    PEAR
 * @author     Tomas V.V.Cox <cox@idecnet.com>
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @link       http://pear.php.net/package/PEAR
 * @since      File available since Release 1.3.3
 */

/**
 * for error handling
 */
require_once 'PEAR.php';
require_once 'PEAR/Config.php';

define('DETAILED', 1);
putenv("PHP_PEAR_RUNTESTS=1");

/**
 * Simplified version of PHP's test suite
 *
 * Try it with:
 *
 * $ php -r 'include "../PEAR/RunTest.php"; $t=new PEAR_RunTest; $o=$t->run("./pear_system.phpt");print_r($o);'
 *
 *
 * @category   pear
 * @package    PEAR
 * @author     Tomas V.V.Cox <cox@idecnet.com>
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: 1.5.4
 * @link       http://pear.php.net/package/PEAR
 * @since      Class available since Release 1.3.3
 */
class PEAR_RunTest
{
    var $_logger;
    var $_options;
    var $ini_overwrites = array(
        'output_handler=',
        'open_basedir=',
        'safe_mode=0',
        'disable_functions=',
        'output_buffering=Off',
        'display_errors=1',
        'log_errors=0',
        'html_errors=0',
        'track_errors=1',
        'report_memleaks=0',
        'report_zend_debug=0',
        'docref_root=',
        'docref_ext=.html',
        'error_prepend_string=',
        'error_append_string=',
        'auto_prepend_file=',
        'auto_append_file=',
    );


    /**
     * An object that supports the PEAR_Common->log() signature, or null
     * @param PEAR_Common|null
     */
    function __construct($logger = null, $options = array())
    {
        $this->ini_overwrites[] = 'error_reporting=' . E_ALL;
        if (is_null($logger)) {
            require_once 'PEAR/Common.php';
            $logger = new PEAR_Common;
        }
        $this->_logger = $logger;
        $this->_options = $options;
    }

    /**
     * Taken from php-src/run-tests.php
     *
     * @param string $commandline command name
     * @param array $env
     * @param string $stdin standard input to pass to the command
     * @return unknown
     */
    function system_with_timeout($commandline, $env = null, $stdin = null)
    {
        $data = '';

        if (version_compare(phpversion(), '5.0.0', '<')) {
            $proc = proc_open($commandline, array(
                0 => array('pipe', 'r'),
                1 => array('pipe', 'w'),
                2 => array('pipe', 'w')
                ), $pipes);
        } else {
            $proc = proc_open($commandline, array(
                0 => array('pipe', 'r'),
                1 => array('pipe', 'w'),
                2 => array('pipe', 'w')
                ), $pipes, null, $env, array("suppress_errors" => true));
        }

        if (!$proc) {
            return false;
        }

        if (is_string($stdin)) {
            fwrite($pipes[0], $stdin);
        }
        fclose($pipes[0]);

        while (true) {
            /* hide errors from interrupted syscalls */
            $r = $pipes;
            $w = null;
            $e = null;
            $n = @stream_select($r, $w, $e, 60);

            if ($n === 0) {
                /* timed out */
                $data .= "\n ** ERROR: process timed out **\n";
                proc_terminate($proc);
                return array(1234567890, $data);
            } else if ($n > 0) {
                $line = fread($pipes[1], 8192);
                if (strlen($line) == 0) {
                    /* EOF */
                    break;
                }
                $data .= $line;
            }
        }
        if (function_exists('proc_get_status')) {
            $stat = proc_get_status($proc);
            if ($stat['signaled']) {
                $data .= "\nTermsig=".$stat['stopsig'];
            }
        }
        $code = proc_close($proc);
        if (function_exists('proc_get_status')) {
            $code = $stat['exitcode'];
        }
        return array($code, $data);
    }

    function settings2array($settings, $ini_settings)
    {
        foreach ($settings as $setting) {
            if (strpos($setting, '=')!==false) {
                $setting = explode("=", $setting, 2);
                $name = trim(strtolower($setting[0]));
                $value = trim($setting[1]);
                $ini_settings[$name] = $value;
            }
        }
        return $ini_settings;
    }

    function settings2params($ini_settings)
    {
        $settings = '';
        foreach ($ini_settings as $name => $value) {
            $value = addslashes($value);
            $settings .= " -d \"$name=$value\"";
        }
        return $settings;
    }

    //
    //  Run an individual test case.
    //

    function run($file, $ini_settings = '')
    {
        $cwd = getcwd();
        $conf = &PEAR_Config::singleton();
        $php = $conf->get('php_bin');
        if (isset($this->_options['phpunit'])) {
            $cmd = "$php$ini_settings -f $file";
            if (isset($this->_logger)) {
                $this->_logger->log(2, 'Running command "' . $cmd . '"');
            }

            $savedir = getcwd(); // in case the test moves us around
            chdir(dirname($file));
            echo `$cmd`;
            chdir($savedir);
            return 'PASSED'; // we have no way of knowing this information so assume passing
        }
        $pass_options = '';
        if (!empty($this->_options['ini'])) {
            $pass_options = $this->_options['ini'];
        }

        $info_params = '';
        $log_format = 'LEOD';

        // Load the sections of the test file.
        $section_text = array(
            'TEST'    => '(unnamed test)',
            'SKIPIF'  => '',
            'GET'    => '',
            'COOKIE' => '',
            'POST'   => '',
            'ARGS'    => '',
            'INI'     => '',
            'CLEAN'   => '',
        );

        $file = realpath($file);
        if (!is_file($file) || !$fp = fopen($file, "r")) {
            return PEAR::raiseError("Cannot open test file: $file");
        }

        $section = '';
        while (!feof($fp)) {
            $line = fgets($fp);

            // Match the beginning of a section.
            if (preg_match('/^--([_A-Z]+)--/', $line, $r)) {
                $section = $r[1];
                $section_text[$section] = '';
                continue;
            } elseif (empty($section)) {
                fclose($fp);
                return PEAR::raiseError("Invalid sections formats in test file: $file");
            }

            // Add to the section text.
            $section_text[$section] .= $line;
        }
        fclose($fp);

        if (isset($section_text['POST_RAW']) && isset($section_text['UPLOAD'])) {
            return PEAR::raiseError("Cannot contain both POST_RAW and UPLOAD in test file: $file");
        }
        $ini_settings = array();
        $ini_settings = $this->settings2array($this->ini_overwrites, $ini_settings);
        if ($section_text['INI']) {
            if (strpos($section_text['INI'], '{PWD}') !== false) {
                $section_text['INI'] = str_replace('{PWD}', dirname($file), $section_text['INI']);
            }
            $ini_settings = $this->settings2array(preg_split( "/[\n\r]+/",
                $section_text['INI']), $ini_settings);
        }
        $ini_settings = $this->settings2params($ini_settings);
        $shortname = str_replace($cwd . DIRECTORY_SEPARATOR, '', $file);
        if (!isset($this->_options['simple'])) {
            $tested = trim($section_text['TEST']) . "[$shortname]";
        } else {
            $tested = trim($section_text['TEST']) . ' ';
        }
        if (!empty($section_text['GET']) || !empty($section_text['POST']) ||
              !empty($section_text['POST_RAW']) || !empty($section_text['COOKIE']) ||
              !empty($section_text['UPLOAD'])) {
            if (empty($this->_options['cgi'])) {
                if (!isset($this->_options['quiet'])) {
                    $this->_logger->log(0, "SKIP $tested (reason: --cgi option needed for this test, type 'pear help run-tests')");
                }
                if (isset($this->_options['tapoutput'])) {
                    return array('ok', ' # skip --cgi option needed for this test, "pear help run-tests" for info');
                }
                return 'SKIPPED';
            }
            $php = $this->_options['cgi'];
        }

        $temp_dir = $test_dir = realpath(dirname($file));
    	$main_file_name = basename($file,'phpt');
    	$diff_filename     = $temp_dir . DIRECTORY_SEPARATOR . $main_file_name.'diff';
    	$log_filename      = $temp_dir . DIRECTORY_SEPARATOR . $main_file_name.'log';
    	$exp_filename      = $temp_dir . DIRECTORY_SEPARATOR . $main_file_name.'exp';
    	$output_filename   = $temp_dir . DIRECTORY_SEPARATOR . $main_file_name.'out';
    	$memcheck_filename = $temp_dir . DIRECTORY_SEPARATOR . $main_file_name.'mem';
    	$temp_file         = $temp_dir . DIRECTORY_SEPARATOR . $main_file_name.'php';
    	$test_file         = $test_dir . DIRECTORY_SEPARATOR . $main_file_name.'php';
    	$temp_skipif       = $temp_dir . DIRECTORY_SEPARATOR . $main_file_name.'skip.php';
    	$test_skipif       = $test_dir . DIRECTORY_SEPARATOR . $main_file_name.'skip.php';
    	$temp_clean        = $temp_dir . DIRECTORY_SEPARATOR . $main_file_name.'clean.php';
    	$test_clean        = $test_dir . DIRECTORY_SEPARATOR . $main_file_name.'clean.php';
    	$tmp_post          = $temp_dir . DIRECTORY_SEPARATOR . uniqid('phpt.');

    	// unlink old test results
    	@unlink($diff_filename);
    	@unlink($log_filename);
    	@unlink($exp_filename);
    	@unlink($output_filename);
    	@unlink($memcheck_filename);
    	@unlink($temp_file);
    	@unlink($test_file);
    	@unlink($temp_skipif);
    	@unlink($test_skipif);
    	@unlink($tmp_post);
    	@unlink($temp_clean);
    	@unlink($test_clean);

        // Check if test should be skipped.
        $info = '';
        $warn = false;
        if (array_key_exists('SKIPIF', $section_text)) {
            if (trim($section_text['SKIPIF'])) {
                $this->save_text($temp_skipif, $section_text['SKIPIF']);
                $output = $this->system_with_timeout("$php $info_params -f $temp_skipif");
                $output = $output[1];
                unlink($temp_skipif);
                if (!strncasecmp('skip', ltrim($output), 4)) {
                    $skipreason = "SKIP $tested";
                    if (preg_match('/^\s*skip\s*(.+)\s*/i', $output, $m)) {
                        $skipreason .= '(reason: ' . $m[1] . ')';
                    }
                    if (!isset($this->_options['quiet'])) {
                        $this->_logger->log(0, $skipreason);
                    }
                    if (isset($this->_options['tapoutput'])) {
                        return array('ok', ' # skip ' . $reason);
                    }
                    return 'SKIPPED';
                }
                if (!strncasecmp('info', ltrim($output), 4)) {
                    if (preg_match('/^\s*info\s*(.+)\s*/i', $output, $m)) {
                        $info = " (info: $m[1])";
                    }
                }
                if (!strncasecmp('warn', ltrim($output), 4)) {
                    if (preg_match('/^\s*warn\s*(.+)\s*/i', $output, $m)) {
                        $warn = true; /* only if there is a reason */
                        $info = " (warn: $m[1])";
                    }
                }
            }
        }

        // We've satisfied the preconditions - run the test!
        $this->save_text($temp_file,$section_text['FILE']);

        $args = $section_text['ARGS'] ? ' -- '.$section_text['ARGS'] : '';

        $cmd = "$php$ini_settings -f $temp_file$args 2>&1";
        if (isset($this->_logger)) {
            $this->_logger->log(2, 'Running command "' . $cmd . '"');
        }

        $savedir = getcwd(); // in case the test moves us around
        // Reset environment from any previous test.
        $env = $_ENV;
        $env['REDIRECT_STATUS']='';
        $env['QUERY_STRING']='';
        $env['PATH_TRANSLATED']='';
        $env['SCRIPT_FILENAME']='';
        $env['REQUEST_METHOD']='';
        $env['CONTENT_TYPE']='';
        $env['CONTENT_LENGTH']='';
        if (!empty($section_text['ENV'])) {
            foreach(explode("\n", trim($section_text['ENV'])) as $e) {
                $e = explode('=',trim($e),2);
                if (!empty($e[0]) && isset($e[1])) {
                    $env[$e[0]] = $e[1];
                }
            }
        }
        if (array_key_exists('GET', $section_text)) {
            $query_string = trim($section_text['GET']);
        } else {
            $query_string = '';
        }
        if (array_key_exists('COOKIE', $section_text)) {
            $env['HTTP_COOKIE'] = trim($section_text['COOKIE']);
        } else {
            $env['HTTP_COOKIE'] = '';
        }
        $env['REDIRECT_STATUS'] = '1';
        $env['QUERY_STRING']    = $query_string;
        $env['PATH_TRANSLATED'] = $test_file;
        $env['SCRIPT_FILENAME'] = $test_file;
        if (array_key_exists('UPLOAD', $section_text) && !empty($section_text['UPLOAD'])) {
            $upload_files = trim($section_text['UPLOAD']);
            $upload_files = explode("\n", $upload_files);

            $request = "Content-Type: multipart/form-data; boundary=---------------------------20896060251896012921717172737\n" .
                       "-----------------------------20896060251896012921717172737\n";
            foreach ($upload_files as $fileinfo) {
                $fileinfo = explode('=', $fileinfo);
                if (count($fileinfo) != 2) {
                    return PEAR::raiseError("Invalid UPLOAD section in test file: $file");
                }
                if (!realpath(dirname($file) . '/' . $fileinfo[1])) {
                    return PEAR::raiseError("File for upload does not exist: $fileinfo[1] " .
                        "in test file: $file");
                }
                $file_contents = file_get_contents(dirname($file) . '/' . $fileinfo[1]);
                $fileinfo[1] = basename($fileinfo[1]);
                $request .= "Content-Disposition: form-data; name=\"$fileinfo[0]\"; filename=\"$fileinfo[1]\"\n";
                $request .= "Content-Type: text/plain\n\n";
                $request .= $file_contents . "\n" .
                    "-----------------------------20896060251896012921717172737\n";
            }
            if (array_key_exists('POST', $section_text) && !empty($section_text['POST'])) {
                // encode POST raw
                $post = trim($section_text['POST']);
                $post = explode('&', $post);
                foreach ($post as $i => $post_info) {
                    $post_info = explode('=', $post_info);
                    if (count($post_info) != 2) {
                        return PEAR::raiseError("Invalid POST data in test file: $file");
                    }
                    $post_info[0] = rawurldecode($post_info[0]);
                    $post_info[1] = rawurldecode($post_info[1]);
                    $post[$i] = $post_info;
                }
                foreach ($post as $post_info) {
                    $request .= "Content-Disposition: form-data; name=\"$post_info[0]\"\n\n";
                    $request .= $post_info[1] . "\n" .
                        "-----------------------------20896060251896012921717172737\n";
                }
                unset($section_text['POST']);
            }
            $section_text['POST_RAW'] = $request;
        }
        if (array_key_exists('POST_RAW', $section_text) && !empty($section_text['POST_RAW'])) {
            $post = trim($section_text['POST_RAW']);
            $raw_lines = explode("\n", $post);

            $request = '';
            $started = false;
            foreach ($raw_lines as $i => $line) {
                if (empty($env['CONTENT_TYPE']) &&
                      preg_match('/^Content-Type:(.*)/i', $line, $res)) {
                    $env['CONTENT_TYPE'] = trim(str_replace("\r", '', $res[1]));
                    continue;
                }
                if ($started) {
                    $request .= "\n";
                }
                $started = true;
                $request .= $line;
            }

            $env['CONTENT_LENGTH'] = strlen($request);
            $env['REQUEST_METHOD'] = 'POST';

            $this->save_text($tmp_post, $request);
            $cmd = "$php$pass_options$ini_settings -f \"$test_file\" 2>&1 < $tmp_post";
        } elseif (array_key_exists('POST', $section_text) && !empty($section_text['POST'])) {

            $post = trim($section_text['POST']);
            $this->save_text($tmp_post, $post);
            $content_length = strlen($post);

            $env['REQUEST_METHOD'] = 'POST';
            $env['CONTENT_TYPE']   = 'application/x-www-form-urlencoded';
            $env['CONTENT_LENGTH'] = $content_length;

            $cmd = "$php$pass_options$ini_settings -f \"$test_file\" 2>&1 < $tmp_post";

        } else {

            $env['REQUEST_METHOD'] = 'GET';
            $env['CONTENT_TYPE']   = '';
            $env['CONTENT_LENGTH'] = '';

            $cmd = "$php$pass_options$ini_settings -f \"$test_file\" $args 2>&1";
        }
        if (OS_WINDOWS && isset($section_text['RETURNS'])) {
            ob_start();
            system($cmd, $return_value);
            $out = ob_get_contents();
            ob_end_clean();
            $section_text['RETURNS'] = (int) trim($section_text['RETURNS']);
            $returnfail = ($return_value != $section_text['RETURNS']);
        } else {
            $returnfail = false;
            $out = $this->system_with_timeout($cmd, $env,
                isset($section_text['STDIN']) ? $section_text['STDIN'] : null);
            $return_value = $out[0];
            $out = $out[1];
        }
        if (isset($tmp_post) && realpath($tmp_post) && file_exists($tmp_post)) {
            @unlink(realpath($tmp_post));
        }
        chdir($savedir);

        if ($section_text['CLEAN']) {
            // perform test cleanup
            $this->save_text($temp_clean, $section_text['CLEAN']);
            $this->system_with_timeout("$php $temp_clean");
            if (file_exists($temp_clean)) {
                unlink($temp_clean);
            }
        }
        // Does the output match what is expected?
        $output = trim($out);
        $output = preg_replace('/\r\n/', "\n", $output);

        /* when using CGI, strip the headers from the output */
        $headers = "";
        if (!empty($this->_options['cgi']) &&
              $php == $this->_options['cgi'] &&
              preg_match("/^(.*?)\r?\n\r?\n(.*)/s", $out, $match)) {
            $output = trim($match[2]);
            $rh = preg_split("/[\n\r]+/",$match[1]);
            $headers = array();
            foreach ($rh as $line) {
                if (strpos($line, ':')!==false) {
                    $line = explode(':', $line, 2);
                    $headers[trim($line[0])] = trim($line[1]);
                }
            }
        }

        do {
            if (isset($section_text['EXPECTF']) || isset($section_text['EXPECTREGEX'])) {
                if (isset($section_text['EXPECTF'])) {
                    $wanted = trim($section_text['EXPECTF']);
                } else {
                    $wanted = trim($section_text['EXPECTREGEX']);
                }
                $wanted_re = preg_replace('/\r\n/',"\n",$wanted);
                if (isset($section_text['EXPECTF'])) {
                    $wanted_re = preg_quote($wanted_re, '/');
                    // Stick to basics
                    $wanted_re = str_replace("%s", ".+?", $wanted_re); //not greedy
                    $wanted_re = str_replace("%i", "[+\-]?[0-9]+", $wanted_re);
                    $wanted_re = str_replace("%d", "[0-9]+", $wanted_re);
                    $wanted_re = str_replace("%x", "[0-9a-fA-F]+", $wanted_re);
                    $wanted_re = str_replace("%f", "[+\-]?\.?[0-9]+\.?[0-9]*(E-?[0-9]+)?", $wanted_re);
                    $wanted_re = str_replace("%c", ".", $wanted_re);
                    // %f allows two points "-.0.0" but that is the best *simple* expression
                }
    /* DEBUG YOUR REGEX HERE
            var_dump($wanted_re);
            print(str_repeat('=', 80) . "\n");
            var_dump($output);
    */
                if (!$returnfail && preg_match("/^$wanted_re\$/s", $output)) {
                    if (file_exists($temp_file)) {
                        unlink($temp_file);
                    }

                    if (array_key_exists('FAIL', $section_text)) {
                        break;
                    }
                    if (!isset($this->_options['quiet'])) {
                        $this->_logger->log(0, "PASS $tested$info");
                    }
                    if (isset($old_php)) {
                        $php = $old_php;
                    }
                    if (isset($this->_options['tapoutput'])) {
                        return array('ok', ' - ' . $tested);
                    }
                    return 'PASSED';
                }

            } else {
                $wanted = trim($section_text['EXPECT']);
                $wanted = preg_replace('/\r\n/',"\n",$wanted);
            // compare and leave on success
                $ok = (0 == strcmp($output,$wanted));
                if (!$returnfail && $ok) {
                    if (file_exists($temp_file)) {
                        unlink($temp_file);
                    }
                    if (array_key_exists('FAIL', $section_text)) {
                        break;
                    }
                    if (!isset($this->_options['quiet'])) {
                        $this->_logger->log(0, "PASS $tested$info");
                    }
                    if (isset($old_php)) {
                        $php = $old_php;
                    }
                    if (isset($this->_options['tapoutput'])) {
                        return array('ok', ' - ' . $tested);
                    }
                    return 'PASSED';
                }
            }
        } while (false);

        if (array_key_exists('FAIL', $section_text)) {
            // we expect a particular failure
            // this is only used for testing PEAR_RunTest
            $faildiff = $this->generate_diff(
                      $wanted,
                      $output,
                      null,
                      isset($section_text['EXPECTF']) ? $wanted_re : null);
            $wanted = preg_replace('/\r/', '', trim($section_text['FAIL']));
            $faildiff = preg_replace('/\r/', '', $faildiff);
            if ($faildiff == $wanted) {
                if (!isset($this->_options['quiet'])) {
                    $this->_logger->log(0, "PASS $tested$info");
                }
                if (isset($old_php)) {
                    $php = $old_php;
                }
                if (isset($this->_options['tapoutput'])) {
                    return array('ok', ' - ' . $tested);
                }
                return 'PASSED';
            }
            unset($section_text['EXPECTF']);
            $output = $faildiff;
            if (isset($section_text['RETURNS'])) {
                return PEAR::raiseError('Cannot have both RETURNS and FAIL in the same test: ' .
                    $file);
            }
        }

        // Test failed so we need to report details.
        if ($warn) {
            $this->_logger->log(0, "WARN $tested$info");
        } else {
            $this->_logger->log(0, "FAIL $tested$info");
        }

        if (isset($section_text['RETURNS'])) {
            $GLOBALS['__PHP_FAILED_TESTS__'][] = array(
                            'name' => $file,
                            'test_name' => $tested,
                            'output' => $log_filename,
                            'diff'   => $diff_filename,
                            'info'   => $info,
                            'return' => $return_value
                            );
        } else {
            $GLOBALS['__PHP_FAILED_TESTS__'][] = array(
                            'name' => $file,
                            'test_name' => $tested,
                            'output' => $output_filename,
                            'diff'   => $diff_filename,
                            'info'   => $info,
                            );
        }

        // write .exp
        if (strpos($log_format,'E') !== FALSE) {
            $logname = $exp_filename;
            if (!$log = fopen($logname,'w')) {
                return PEAR::raiseError("Cannot create test log - $logname");
            }
            fwrite($log,$wanted);
            fclose($log);
        }

        // write .out
        if (strpos($log_format,'O') !== FALSE) {
            $logname = $output_filename;
            if (!$log = fopen($logname,'w')) {
                return PEAR::raiseError("Cannot create test log - $logname");
            }
            fwrite($log,$output);
            fclose($log);
        }

        // write .diff
        if (strpos($log_format,'D') !== FALSE) {
            $logname = $diff_filename;
            if (!$log = fopen($logname,'w')) {
                return PEAR::raiseError("Cannot create test log - $logname");
            }
            fwrite($log, $this->generate_diff(
                      $wanted,
                      $output,
                      isset($section_text['RETURNS']) ?
                        array(trim($section_text['RETURNS']), $return_value) : null,
                      isset($section_text['EXPECTF']) ? $wanted_re : null)
                  );
            fclose($log);
        }

        // write .log
        if (strpos($log_format,'L') !== FALSE) {
            $logname = $log_filename;
            if (!$log = fopen($logname,'w')) {
                return PEAR::raiseError("Cannot create test log - $logname");
            }
            fwrite($log,"
---- EXPECTED OUTPUT
$wanted
---- ACTUAL OUTPUT
$output
---- FAILED
");
            if ($returnfail) {
                fwrite($log,"
---- EXPECTED RETURN
$section_text[RETURNS]
---- ACTUAL RETURN
$return_value
");
            }
            fclose($log);
            //error_report($file,$logname,$tested);
        }

        if (isset($old_php)) {
            $php = $old_php;
        }

        if (isset($this->_options['tapoutput'])) {
            $wanted = explode("\n", $wanted);
            $wanted = "# Expected output:\n#\n#" . implode("\n#", $wanted);
            $output = explode("\n", $output);
            $output = "#\n#\n# Actual output:\n#\n#" . implode("\n#", $output);
            return array($wanted . $output . 'not ok', ' - ' . $tested);
        }
        return $warn ? 'WARNED' : 'FAILED';
    }

    function generate_diff($wanted, $output, $return_value, $wanted_re)
    {
        $w = explode("\n", $wanted);
        $o = explode("\n", $output);
        $wr = explode("\n", $wanted_re);
        $w1 = array_diff_assoc($w,$o);
        $o1 = array_diff_assoc($o,$w);
        $w2 = array();
        $o2 = array();
        foreach($w1 as $idx => $val) {
            if (!$wanted_re || !isset($wr[$idx]) || !isset($o1[$idx]) ||
                  !preg_match('/^' . $wr[$idx] . '\\z/', $o1[$idx])) {
                $w2[sprintf("%03d<", $idx)] = sprintf("%03d- ", $idx + 1) . $val;
            }
        }
        foreach($o1 as $idx => $val) {
            if (!$wanted_re || !isset($wr[$idx]) ||
                  !preg_match('/^' . $wr[$idx] . '\\z/', $val)) {
                $o2[sprintf("%03d>", $idx)] = sprintf("%03d+ ", $idx + 1) . $val;
            }
        }
        $diff = array_merge($w2, $o2);
        ksort($diff);
        if ($return_value) {
            $extra = "##EXPECTED: $return_value[0]\r\n##RETURNED: $return_value[1]";
        } else {
            $extra = '';
        }
        return implode("\r\n", $diff) . $extra;
    }

    //
    //  Write the given text to a temporary file, and return the filename.
    //

    function save_text($filename, $text)
    {
        if (!$fp = fopen($filename, 'w')) {
            return PEAR::raiseError("Cannot open file '" . $filename . "' (save_text)");
        }
        fwrite($fp,$text);
        fclose($fp);
    if (1 < DETAILED) echo "
FILE $filename {{{
$text
}}}
";
    }

}
?>
