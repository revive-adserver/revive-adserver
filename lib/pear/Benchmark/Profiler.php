<?php
//
// +----------------------------------------------------------------------+
// | PEAR :: Benchmark                                                    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2002-2005 Matthias Englert <Matthias.Englert@gmx.de>.  |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.00 of the PHP License,      |
// | that is available at http://www.php.net/license/3_0.txt.             |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
//
// $Id: Profiler.php,v 1.15 2005/05/03 13:29:57 toggg Exp $
//

require_once 'PEAR.php';

/**
 * Provides timing and profiling information.
 *
 * Example 1: Automatic profiling start, stop, and output.
 *
 * <code>
 * <?php
 * require_once 'Benchmark/Profiler.php';
 *
 * $profiler = new Benchmark_Profiler(TRUE);
 *
 * function myFunction() {
 *     global $profiler;
 *     $profiler->enterSection('myFunction');
 *     //do something
 *     $profiler->leaveSection('myFunction');
 *     return;
 * }
 *
 * //do something
 * myFunction();
 * //do more
 * ?>
 * </code>
 *
 * Example 2: Manual profiling start, stop, and output.
 *
 * <code>
 * <?php
 * require_once 'Benchmark/Profiler.php';
 *
 * $profiler = new Benchmark_Profiler();
 *
 * function myFunction() {
 *     global $profiler;
 *     $profiler->enterSection('myFunction');
 *     //do something
 *     $profiler->leaveSection('myFunction');
 *     return;
 * }
 *
 * $profiler->start();
 * //do something
 * myFunction();
 * //do more
 * $profiler->stop();
 * $profiler->display();
 * ?>
 * </code>
 *
 * @author    Matthias Englert <Matthias.Englert@gmx.de>
 * @copyright Copyright &copy; 2002-2005 Matthias Englert <Matthias.Englert@gmx.de>
 * @license   http://www.php.net/license/3_0.txt The PHP License, Version 3.0
 * @category  Benchmarking
 * @package   Benchmark
 * @since     1.2.0
 */
class Benchmark_Profiler extends PEAR {
    /**
     * Contains the total ex. time of each section
     *
     * @var    array
     * @access private
     */
    var $_sections = array();

    /**
     * Calling stack
     *
     * @var    array
     * @access private
     */
    var $_stack = array();

    /**
     * Notes how often a section was entered
     *
     * @var    array
     * @access private
     */
    var $_numberOfCalls = array();

    /**
     * Notes for each section how much time is spend in sub-sections
     *
     * @var    array
     * @access private
     */
    var $_subSectionsTime = array();

    /**
     * Notes for each section how often it calls which section
     *
     * @var    array
     * @access private
     */
    var $_calls = array();

    /**
     * Notes for each section how often it was called by which section
     *
     * @var    array
     * @access private
     */
    var $_callers = array();

    /**
     * Auto-starts and stops profiler
     *
     * @var    boolean
     * @access private
     */
    var $_auto = FALSE;

    /**
     * Max marker name length for non-html output
     *
     * @var    integer
     * @access private
     */
    var $_maxStringLength = 0;

    /**
     * Constructor, starts profiling recording
     *
     * @access public
     */
    function Benchmark_Profiler($auto = FALSE) {
        $this->_auto = $auto;

        if ($this->_auto) {
            $this->start();
        }

        $this->PEAR();
    }

    /**
     * Destructor, stops profiling recording
     *
     * @access private
     */
    function _Benchmark_Profiler() {
        if (isset($this->_auto) && $this->_auto) {
            $this->stop();
            $this->display();
        }
    }

    /**
     * Returns profiling informations for a given section.
     *
     * @param  string $section
     * @return array
     * @access public
     */
    function getSectionInformations($section = 'Global') {
        if (isset($this->_sections[$section])) {
            $calls = array();

            if (isset($this->_calls[$section])) {
                $calls = $this->_calls[$section];
            }

            $callers = array();

            if (isset($this->_callers[$section])) {
                $callers = $this->_callers[$section];
            }

            $informations = array();

            $informations['time']       = $this->_sections[$section];
            if (isset($this->_sections['Global'])) {
                $informations['percentage'] = number_format(100 * $this->_sections[$section] / $this->_sections['Global'], 2, '.', '');
            } else {
                $informations['percentage'] = 'N/A';
            }
            $informations['calls']      = $calls;
            $informations['num_calls']  = $this->_numberOfCalls[$section];
            $informations['callers']    = $callers;

      	    if (isset($this->_subSectionsTime[$section])) {
                $informations['netto_time'] = $this->_sections[$section] - $this->_subSectionsTime[$section];
      	    } else {
                $informations['netto_time'] = $this->_sections[$section];
      	    }

            return $informations;
        } else {
            $this->raiseError("The section '$section' does not exists.\n", NULL, PEAR_ERROR_TRIGGER, E_USER_WARNING);
        }
    }

    /**
     * Returns profiling informations for all sections.
     *
     * @return array
     * @access public
     */
    function getAllSectionsInformations() {
        $informations = array();

        foreach($this->_sections as $section => $time) {
            $informations[$section] = $this->getSectionInformations($section);
        }

        return $informations;
    }

    /**
     * Returns formatted profiling information.
     *
     * @see    display()
     * @access private
     */
    function _getOutput() {
        if (function_exists('version_compare') &&
            version_compare(phpversion(), '4.1', 'ge')) {
            $http = isset($_SERVER['SERVER_PROTOCOL']);
        } else {
            global $HTTP_SERVER_VARS;
            $http = isset($HTTP_SERVER_VARS['SERVER_PROTOCOL']);
        }

        if ($http) {
            $out = '<table style="border: 1px solid #000000; ">'."\n";
            $out .=
                '<tr><td>&nbsp;</td><td align="center"><b>total ex. time</b></td>'.
                '<td align="center"><b>netto ex. time</b></td>'.
                '<td align="center"><b>#calls</b></td><td align="center"><b>%</b></td>'.
                '<td align="center"><b>calls</b></td><td align="center"><b>callers</b></td></tr>'.
                "\n";
        } else {
            $dashes = $out = str_pad("\n", ($this->_maxStringLength + 52), '-', STR_PAD_LEFT);
            $out .= str_pad('section', $this->_maxStringLength);
            $out .= str_pad("total ex time", 22);
            $out .= str_pad("netto ex time", 22);
            $out .= str_pad("#calls", 22);
            $out .= "perct\n";
            $out .= $dashes;
        }

        $informations = $this->getAllSectionsInformations();

        foreach($informations as $name => $values) {
            $percentage = $values['percentage'];
            $calls_str = "";

            foreach($values['calls'] as $key => $val) {
                if ($calls_str) {
                    $calls_str .= ", ";
                }

                $calls_str .= "$key ($val)";
            }

            $callers_str = "";

            foreach($values['callers'] as $key => $val) {
                if ($callers_str) {
                    $callers_str .= ", ";
    		        }

                $callers_str .= "$key ($val)";
            }

            if ($http) {
                $out .= "<tr><td><b>$name</b></td><td>{$values['time']}</td><td>{$values['netto_time']}</td><td>{$values['num_calls']}</td>";
                if (is_numeric($values['percentage'])) {
                    $out .= "<td align=\"right\">{$values['percentage']}%</td>\n";
                } else {
                    $out .= "<td align=\"right\">{$values['percentage']}</td>\n";
                }
                $out .= "<td>$calls_str</td><td>$callers_str</td></tr>";
            } else {
                $out .= str_pad($name, $this->_maxStringLength, ' ');
                $out .= str_pad($values['time'], 22);
                $out .= str_pad($values['netto_time'], 22);
                $out .= str_pad($values['num_calls'], 22);
                if (is_numeric($values['percentage'])) {
                    $out .= str_pad($values['percentage']."%\n", 8, ' ', STR_PAD_LEFT);
                } else {
                    $out .= str_pad($values['percentage']."\n", 8, ' ', STR_PAD_LEFT);
                }
            }
        }

        return $out . '</table>';
    }

    /**
     * Returns formatted profiling information.
     *
     * @access public
     */
    function display() {
        echo $this->_getOutput();
    }

    /**
     * Enters "Global" section.
     *
     * @see    enterSection(), stop()
     * @access public
     */
    function start() {
        $this->enterSection('Global');
    }

    /**
     * Leaves "Global" section.
     *
     * @see    leaveSection(), start()
     * @access public
     */
    function stop() {
        $this->leaveSection('Global');
    }

    /**
     * Enters code section.
     *
     * @param  string  name of the code section
     * @see    start(), leaveSection()
     * @access public
     */
    function enterSection($name) {
        if (count($this->_stack)) {
            if (isset($this->_callers[$name][$this->_stack[count($this->_stack) - 1]["name"]])) {
                $this->_callers[$name][$this->_stack[count($this->_stack) - 1]["name"]]++;
            } else {
                $this->_callers[$name][$this->_stack[count($this->_stack) - 1]["name"]] = 1;
            }

            if (isset($this->_calls[$this->_stack[count($this->_stack) - 1]["name"]][$name])) {
                $this->_calls[$this->_stack[count($this->_stack) - 1]["name"]][$name]++;
            } else {
                $this->_calls[$this->_stack[count($this->_stack) - 1]["name"]][$name] = 1;
            }
        } else {
            if ($name != 'Global') {
                $this->raiseError("tried to enter section ".$name." but profiling was not started\n", NULL, PEAR_ERROR_DIE);
            }
        }

        if (isset($this->_numberOfCalls[$name])) {
            $this->_numberOfCalls[$name]++;
        } else {
            $this->_numberOfCalls[$name] = 1;
        }

        array_push($this->_stack, array("name" => $name, "time" => $this->_getMicrotime()));
    }

    /**
     * Leaves code section.
     *
     * @param  string  name of the marker to be set
     * @see     stop(), enterSection()
     * @access public
     */
    function leaveSection($name) {
        $microtime = $this->_getMicrotime();

        if (!count($this->_stack)) {
            $this->raiseError("tried to leave section ".$name." but profiling was not started\n", NULL, PEAR_ERROR_DIE);
        }

        $x = array_pop($this->_stack);

        if ($x["name"] != $name) {
            $this->raiseError("reached end of section $name but expecting end of " . $x["name"]."\n", NULL, PEAR_ERROR_DIE);
        }

        if (isset($this->_sections[$name])) {
            $this->_sections[$name] += $microtime - $x["time"];
        } else {
            $this->_sections[$name] = $microtime - $x["time"];
        }

        $parent = array_pop($this->_stack);

      	if (isset($parent)) {
            if (isset($this->_subSectionsTime[$parent['name']])) {
                $this->_subSectionsTime[$parent['name']] += $microtime - $x['time'];
            } else {
                $this->_subSectionsTime[$parent['name']] = $microtime - $x['time'];
            }

            array_push($this->_stack, $parent);
        }
    }

    /**
     * Wrapper for microtime().
     *
     * @return float
     * @access private
     * @since  1.3.0
     */
    function _getMicrotime() {
        $microtime = explode(' ', microtime());
        return $microtime[1] . substr($microtime[0], 1);
    }
}
?>
