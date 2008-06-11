<?php
//
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2005 Ulf Wendel, Pierre-Alain Joye                |
// +----------------------------------------------------------------------+
// | This source file is subject to the New BSD license, That is bundled  |
// | with this package in the file LICENSE, and is available through      |
// | the world-wide-web at                                                |
// | http://www.opensource.org/licenses/bsd-license.php                   |
// | If you did not receive a copy of the new BSDlicense and are unable   |
// | to obtain it through the world-wide-web, please send a note to       |
// | pajoye@php.net so we can mail you a copy immediately.                |
// +----------------------------------------------------------------------+
// | Author: Ulf Wendel <ulf.wendel@phpdoc.de>                            |
// |         Pierre-Alain Joye <pajoye@php.net>                           |
// +----------------------------------------------------------------------+
//
// $Id$
//

require_once 'PEAR.php';

define('IT_OK',                         1);
define('IT_ERROR',                     -1);
define('IT_TPL_NOT_FOUND',             -2);
define('IT_BLOCK_NOT_FOUND',           -3);
define('IT_BLOCK_DUPLICATE',           -4);
define('IT_UNKNOWN_OPTION',            -6);
/**
 * Integrated Template - IT
 *
 * Well there's not much to say about it. I needed a template class that
 * supports a single template file with multiple (nested) blocks inside and
 * a simple block API.
 *
 * The Isotemplate API is somewhat tricky for a beginner although it is the best
 * one you can build. template::parse() [phplib template = Isotemplate] requests
 * you to name a source and a target where the current block gets parsed into.
 * Source and target can be block names or even handler names. This API gives you
 * a maximum of fexibility but you always have to know what you do which is
 * quite unusual for php skripter like me.
 *
 * I noticed that I do not any control on which block gets parsed into which one.
 * If all blocks are within one file, the script knows how they are nested and in
 * which way you have to parse them. IT knows that inner1 is a child of block2, there's
 * no need to tell him about this.
 *
 * <table border>
 *   <tr>
 *     <td colspan=2>
 *       __global__
 *       <p>
 *       (hidden and automatically added)
 *     </td>
 *   </tr>
 *   <tr>
 *     <td>block1</td>
 *     <td>
 *       <table border>
 *         <tr>
 *           <td colspan=2>block2</td>
 *         </tr>
 *         <tr>
 *           <td>inner1</td>
 *           <td>inner2</td>
 *         </tr>
 *       </table>
 *     </td>
 *   </tr>
 * </table>
 *
 * To add content to block1 you simply type:
 * <code>$tpl->setCurrentBlock("block1");</code>
 * and repeat this as often as needed:
 * <code>
 *   $tpl->setVariable(...);
 *   $tpl->parseCurrentBlock();
 * </code>
 *
 * To add content to block2 you would type something like:
 * <code>
 * $tpl->setCurrentBlock("inner1");
 * $tpl->setVariable(...);
 * $tpl->parseCurrentBlock();
 *
 * $tpl->setVariable(...);
 * $tpl->parseCurrentBlock();
 *
 * $tpl->parse("block1");
 * </code>
 *
 * This will result in one repition of block1 which contains two repitions
 * of inner1. inner2 will be removed if $removeEmptyBlock is set to true which is the default.
 *
 * Usage:
 * <code>
 * $tpl = new HTML_Template_IT( [string filerootdir] );
 *
 * // load a template or set it with setTemplate()
 * $tpl->loadTemplatefile( string filename [, boolean removeUnknownVariables, boolean removeEmptyBlocks] )
 *
 * // set "global" Variables meaning variables not beeing within a (inner) block
 * $tpl->setVariable( string variablename, mixed value );
 *
 * // like with the Isotemplates there's a second way to use setVariable()
 * $tpl->setVariable( array ( string varname => mixed value ) );
 *
 * // Let's use any block, even a deeply nested one
 * $tpl->setCurrentBlock( string blockname );
 *
 * // repeat this as often as you need it.
 * $tpl->setVariable( array ( string varname => mixed value ) );
 * $tpl->parseCurrentBlock();
 *
 * // get the parsed template or print it: $tpl->show()
 * $tpl->get();
 * </code>
 *
 * @author   Ulf Wendel <uw@netuse.de>
 * @version  $Id$
 * @access   public
 * @package  HTML_Template_IT
 */
class HTML_Template_IT
{
    /**
     * Contains the error objects
     * @var      array
     * @access   public
     * @see      halt(), $printError, $haltOnError
     */
    var $err = array();

    /**
     * Clear cache on get()?
     * @var      boolean
     */
    var $clearCache = false;

    /**
     * First character of a variable placeholder ( _{_VARIABLE} ).
     * @var      string
     * @access   public
     * @see      $closingDelimiter, $blocknameRegExp, $variablenameRegExp
     */
    var $openingDelimiter = '{';

    /**
     * Last character of a variable placeholder ( {VARIABLE_}_ ).
     * @var      string
     * @access   public
     * @see      $openingDelimiter, $blocknameRegExp, $variablenameRegExp
     */
    var $closingDelimiter     = '}';

    /**
     * RegExp matching a block in the template.
     * Per default "sm" is used as the regexp modifier, "i" is missing.
     * That means a case sensitive search is done.
     * @var      string
     * @access   public
     * @see      $variablenameRegExp, $openingDelimiter, $closingDelimiter
     */
    var $blocknameRegExp    = '[\.0-9A-Za-z_-]+';

    /**
     * RegExp matching a variable placeholder in the template.
     * Per default "sm" is used as the regexp modifier, "i" is missing.
     * That means a case sensitive search is done.
     * @var      string
     * @access   public
     * @see      $blocknameRegExp, $openingDelimiter, $closingDelimiter
     */
    var $variablenameRegExp    = '[\.0-9A-Za-z_-]+';

    /**
     * RegExp used to find variable placeholder, filled by the constructor.
     * @var      string    Looks somewhat like @(delimiter varname delimiter)@
     * @access   public
     * @see      IntegratedTemplate()
     */
    var $variablesRegExp = '';

    /**
     * RegExp used to strip unused variable placeholder.
     * @brother  $variablesRegExp
     */
    var $removeVariablesRegExp = '';

    /**
     * Controls the handling of unknown variables, default is remove.
     * @var      boolean
     * @access   public
     */
    var $removeUnknownVariables = true;

    /**
     * Controls the handling of empty blocks, default is remove.
     * @var      boolean
     * @access   public
     */
    var $removeEmptyBlocks = true;

    /**
     * RegExp used to find blocks an their content, filled by the constructor.
     * @var      string
     * @see      IntegratedTemplate()
     */
    var $blockRegExp = '';

    /**
     * Name of the current block.
     * @var      string
     */
    var $currentBlock = '__global__';

    /**
     * Content of the template.
     * @var      string
     */
    var $template = '';

    /**
     * Array of all blocks and their content.
     *
     * @var      array
     * @see      findBlocks()
     */
    var $blocklist = array();

    /**
     * Array with the parsed content of a block.
     *
     * @var      array
     */
    var $blockdata = array();

    /**
     * Array of variables in a block.
     * @var      array
     */
    var $blockvariables = array();

    /**
     * Array of inner blocks of a block.
     * @var      array
     */
    var $blockinner = array();

    /**
     * List of blocks to preverse even if they are "empty".
     *
     * This is something special. Sometimes you have blocks that
     * should be preserved although they are empty (no placeholder replaced).
     * Think of a shopping basket. If it's empty you have to drop a message to
     * the user. If it's filled you have to show the contents of
     * the shopping baseket. Now where do you place the message that the basket
     * is empty? It's no good idea to place it in you applications as customers
     * tend to like unecessary minor text changes. Having another template file
     * for an empty basket means that it's very likely that one fine day
     * the filled and empty basket templates have different layout. I decided
     * to introduce blocks that to not contain any placeholder but only
     * text such as the message "Your shopping basked is empty".
     *
     * Now if there is no replacement done in such a block the block will
     * be recognized as "empty" and by default ($removeEmptyBlocks = true) be
     * stripped off. To avoid thisyou can now call touchBlock() to avoid this.
     *
     * The array $touchedBlocks stores a list of touched block which must not
     * be removed even if they are empty.
     *
     * @var  array    $touchedBlocks
     * @see  touchBlock(), $removeEmptyBlocks
     */
     var $touchedBlocks = array();

    /**
     * List of blocks which should not be shown even if not "empty"
     * @var  array    $_hiddenBlocks
     * @see  hideBlock(), $removeEmptyBlocks
     */
    var $_hiddenBlocks = array();

    /**
     * Variable cache.
     *
     * Variables get cached before any replacement is done.
     * Advantage: empty blocks can be removed automatically.
     * Disadvantage: might take some more memory
     *
     * @var    array
     * @see    setVariable(), $clearCacheOnParse
     */
    var $variableCache = array();

    /**
     * Clear the variable cache on parse?
     *
     * If you're not an expert just leave the default false.
     * True reduces memory consumption somewhat if you tend to
     * add lots of values for unknown placeholder.
     *
     * @var    boolean
     */
    var $clearCacheOnParse = false;

    /**
     * Root directory for all file operations.
     * The string gets prefixed to all filenames given.
     * @var    string
     * @see    HTML_Template_IT(), setRoot()
     */
    var $fileRoot = '';

    /**
     * Internal flag indicating that a blockname was used multiple times.
     * @var    boolean
     */
    var $flagBlocktrouble = false;

    /**
     * Flag indicating that the global block was parsed.
     * @var    boolean
     */
    var $flagGlobalParsed = false;

    /**
     * EXPERIMENTAL! FIXME!
     * Flag indication that a template gets cached.
     *
     * Complex templates require some times to be preparsed
     * before the replacement can take place. Often I use
     * one template file over and over again but I don't know
     * before that I will use the same template file again.
     * Now IT could notice this and skip the preparse.
     *
     * @var    boolean
     */
    var $flagCacheTemplatefile = true;

    /**
     * EXPERIMENTAL! FIXME!
     */
    var $lastTemplatefile = '';

    /**
     * $_options['preserve_data'] Whether to substitute variables and remove
     * empty placeholders in data passed through setVariable
     * (see also bugs #20199, #21951).
     * $_options['use_preg'] Whether to use preg_replace instead of
     * str_replace in parse()
     * (this is a backwards compatibility feature, see also bugs #21951, #20392)
     */
    var $_options = array(
        'preserve_data' => false,
        'use_preg'      => true
    );

    /**
     * Builds some complex regular expressions and optinally sets the
     * file root directory.
     *
     * Make sure that you call this constructor if you derive your template
     * class from this one.
     *
     * @param    string    File root directory, prefix for all filenames
     *                     given to the object.
     * @see      setRoot()
     */
    function HTML_Template_IT($root = '', $options = null)
    {
        if (!is_null($options)) {
            $this->setOptions($options);
        }
        $this->variablesRegExp = '@' . $this->openingDelimiter .
                                 '(' . $this->variablenameRegExp . ')' .
                                 $this->closingDelimiter . '@sm';
        $this->removeVariablesRegExp = '@' . $this->openingDelimiter .
                                       "\s*(" . $this->variablenameRegExp .
                                       ")\s*" . $this->closingDelimiter .'@sm';

        $this->blockRegExp = '@<!--\s+BEGIN\s+(' . $this->blocknameRegExp .
                             ')\s+-->(.*)<!--\s+END\s+\1\s+-->@sm';

        $this->setRoot($root);
    } // end constructor


    /**
     * Sets the option for the template class
     *
     * @access public
     * @param  string  option name
     * @param  mixed   option value
     * @return mixed   IT_OK on success, error object on failure
     */
    function setOption($option, $value)
    {
        if (array_key_exists($option, $this->_options)) {
            $this->_options[$option] = $value;
            return IT_OK;
        }

        return PEAR::raiseError(
                $this->errorMessage(IT_UNKNOWN_OPTION) . ": '{$option}'",
                IT_UNKNOWN_OPTION
            );
    }

    /**
     * Sets the options for the template class
     *
     * @access public
     * @param  string  options array of options
     *                 default value:
     *                   'preserve_data' => false,
     *                   'use_preg'      => true
     * @param  mixed   option value
     * @return mixed   IT_OK on success, error object on failure
     * @see $options
     */
    function setOptions($options)
    {
        if (is_array($options)) {
            foreach ($options as $option => $value) {
                $error = $this->setOption($option, $value);
                if (PEAR::isError($error)) {
                    return $error;
                }
            }
        }

        return IT_OK;
    }

    /**
     * Print a certain block with all replacements done.
     * @brother get()
     */
    function show($block = '__global__')
    {
        print $this->get($block);
    } // end func show

    /**
     * Returns a block with all replacements done.
     *
     * @param    string     name of the block
     * @return   string
     * @throws   PEAR_Error
     * @access   public
     * @see      show()
     */
    function get($block = '__global__')
    {
        if ($block == '__global__'  && !$this->flagGlobalParsed) {
            $this->parse('__global__');
        }

        if (!isset($this->blocklist[$block])) {
            $this->err[] = PEAR::raiseError(
                            $this->errorMessage(IT_BLOCK_NOT_FOUND) .
                            '"' . $block . "'",
                            IT_BLOCK_NOT_FOUND
                        );
            return '';
        }

        if (isset($this->blockdata[$block])) {
            $ret = $this->blockdata[$block];
            if ($this->clearCache) {
                unset($this->blockdata[$block]);
            }
            if ($this->_options['preserve_data']) {
                $ret = str_replace(
                        $this->openingDelimiter .
                        '%preserved%' . $this->closingDelimiter,
                        $this->openingDelimiter,
                        $ret
                    );
            }
            return $ret;
        }

        return '';
    } // end func get()

    /**
     * Parses the given block.
     *
     * @param    string    name of the block to be parsed
     * @access   public
     * @see      parseCurrentBlock()
     * @throws   PEAR_Error
     */
    function parse($block = '__global__', $flag_recursion = false)
    {
        static $regs, $values;

        if (!isset($this->blocklist[$block])) {
            return PEAR::raiseError(
                $this->errorMessage( IT_BLOCK_NOT_FOUND ) . '"' . $block . "'",
                        IT_BLOCK_NOT_FOUND
                );
        }

        if ($block == '__global__') {
            $this->flagGlobalParsed = true;
        }

        if (!$flag_recursion) {
            $regs   = array();
            $values = array();
        }
        $outer = $this->blocklist[$block];
        $empty = true;

        if ($this->clearCacheOnParse) {
            foreach ($this->variableCache as $name => $value) {
                $regs[] = $this->openingDelimiter .
                          $name . $this->closingDelimiter;
                $values[] = $value;
                $empty = false;
            }
            $this->variableCache = array();
        } else {
            foreach ($this->blockvariables[$block] as $allowedvar => $v) {

                if (isset($this->variableCache[$allowedvar])) {
                   $regs[]   = $this->openingDelimiter .
                               $allowedvar . $this->closingDelimiter;
                   $values[] = $this->variableCache[$allowedvar];
                   unset($this->variableCache[$allowedvar]);
                   $empty = false;
                }
            }
        }

        if (isset($this->blockinner[$block])) {
            foreach ($this->blockinner[$block] as $k => $innerblock) {

                $this->parse($innerblock, true);
                if ($this->blockdata[$innerblock] != '') {
                    $empty = false;
                }

                $placeholder = $this->openingDelimiter . "__" .
                                $innerblock . "__" . $this->closingDelimiter;
                $outer = str_replace(
                                    $placeholder,
                                    $this->blockdata[$innerblock], $outer
                        );
                $this->blockdata[$innerblock] = "";
            }

        }

        if (!$flag_recursion && 0 != count($values)) {
            if ($this->_options['use_preg']) {
                $regs        = array_map(array(
                                    &$this, '_addPregDelimiters'),
                                    $regs
                                );
                $funcReplace = 'preg_replace';
            } else {
                $funcReplace = 'str_replace';
            }

            if ($this->_options['preserve_data']) {
                $values = array_map(
                            array(&$this, '_preserveOpeningDelimiter'), $values
                        );
            }

            $outer = $funcReplace($regs, $values, $outer);

            if ($this->removeUnknownVariables) {
                $outer = preg_replace($this->removeVariablesRegExp, "", $outer);
            }
        }

        if ($empty) {
            if (!$this->removeEmptyBlocks) {
                $this->blockdata[$block ].= $outer;
            } else {
                if (isset($this->touchedBlocks[$block])) {
                    $this->blockdata[$block] .= $outer;
                    unset($this->touchedBlocks[$block]);
                }
            }
        } else {
            if (empty($this->blockdata[$block])) {
                $this->blockdata[$block] = $outer;
            } else {
                $this->blockdata[$block] .= $outer;
            }
        }

        return $empty;
    } // end func parse

    /**
     * Parses the current block
     * @see      parse(), setCurrentBlock(), $currentBlock
     * @access   public
     */
    function parseCurrentBlock()
    {
        return $this->parse($this->currentBlock);
    } // end func parseCurrentBlock

    /**
     * Sets a variable value.
     *
     * The function can be used eighter like setVariable( "varname", "value")
     * or with one array $variables["varname"] = "value"
     * given setVariable($variables) quite like phplib templates set_var().
     *
     * @param    mixed     string with the variable name or an array
     *                     %variables["varname"] = "value"
     * @param    string    value of the variable or empty if $variable
     *                     is an array.
     * @param    string    prefix for variable names
     * @access   public
     */
    function setVariable($variable, $value = '')
    {
        if (is_array($variable)) {
            $this->variableCache = array_merge(
                                            $this->variableCache, $variable
                                    );
        } else {
            $this->variableCache[$variable] = $value;
        }
    } // end func setVariable

    /**
     * Sets the name of the current block that is the block where variables
     * are added.
     *
     * @param    string      name of the block
     * @return   boolean     false on failure, otherwise true
     * @throws   PEAR_Error
     * @access   public
     */
    function setCurrentBlock($block = '__global__')
    {

        if (!isset($this->blocklist[$block])) {
            return PEAR::raiseError(
                $this->errorMessage( IT_BLOCK_NOT_FOUND ) .
                '"' . $block . "'", IT_BLOCK_NOT_FOUND
            );
        }

        $this->currentBlock = $block;

        return true;
    } // end func setCurrentBlock

    /**
     * Preserves an empty block even if removeEmptyBlocks is true.
     *
     * @param    string      name of the block
     * @return   boolean     false on false, otherwise true
     * @throws   PEAR_Error
     * @access   public
     * @see      $removeEmptyBlocks
     */
    function touchBlock($block)
    {
        if (!isset($this->blocklist[$block])) {
            return PEAR::raiseError(
                $this->errorMessage(IT_BLOCK_NOT_FOUND) .
                '"' . $block . "'", IT_BLOCK_NOT_FOUND);
        }

        $this->touchedBlocks[$block] = true;

        return true;
    } // end func touchBlock

    /**
     * Clears all datafields of the object and rebuild the internal blocklist
     *
     * LoadTemplatefile() and setTemplate() automatically call this function
     * when a new template is given. Don't use this function
     * unless you know what you're doing.
     *
     * @access   public
     * @see      free()
     */
    function init()
    {
        $this->free();
        $this->findBlocks($this->template);
        // we don't need it any more
        $this->template = '';
        $this->buildBlockvariablelist();
    } // end func init

    /**
     * Clears all datafields of the object.
     *
     * Don't use this function unless you know what you're doing.
     *
     * @access   public
     * @see      init()
     */
    function free()
    {
        $this->err = array();

        $this->currentBlock = '__global__';

        $this->variableCache    = array();
        $this->blocklist        = array();
        $this->touchedBlocks    = array();

        $this->flagBlocktrouble = false;
        $this->flagGlobalParsed = false;
    } // end func free

    /**
     * Sets the template.
     *
     * You can eighter load a template file from disk with
     * LoadTemplatefile() or set the template manually using this function.
     *
     * @param        string      template content
     * @param        boolean     remove unknown/unused variables?
     * @param        boolean     remove empty blocks?
     * @see          LoadTemplatefile(), $template
     * @access       public
     * @return       boolean
     */
    function setTemplate( $template, $removeUnknownVariables = true,
                          $removeEmptyBlocks = true)
    {
        $this->removeUnknownVariables = $removeUnknownVariables;
        $this->removeEmptyBlocks = $removeEmptyBlocks;

        if ($template == '' && $this->flagCacheTemplatefile) {
            $this->variableCache = array();
            $this->blockdata = array();
            $this->touchedBlocks = array();
            $this->currentBlock = '__global__';
        } else {
            $this->template = '<!-- BEGIN __global__ -->' . $template .
                              '<!-- END __global__ -->';
            $this->init();
        }

        if ($this->flagBlocktrouble) {
            return false;
        }

        return true;
    } // end func setTemplate

    /**
     * Reads a template file from the disk.
     *
     * @param    string      name of the template file
     * @param    bool        how to handle unknown variables.
     * @param    bool        how to handle empty blocks.
     * @access   public
     * @return   boolean    false on failure, otherwise true
     * @see      $template, setTemplate(), $removeUnknownVariables,
     *           $removeEmptyBlocks
     */
    function loadTemplatefile( $filename,
                               $removeUnknownVariables = true,
                               $removeEmptyBlocks = true )
    {
        $template = '';
        if (!$this->flagCacheTemplatefile ||
            $this->lastTemplatefile != $filename
        ) {
            $template = $this->getFile($filename);
        }
        $this->lastTemplatefile = $filename;

        return $template != '' ?
                $this->setTemplate(
                        $template,$removeUnknownVariables, $removeEmptyBlocks
                    ) : false;
    } // end func LoadTemplatefile

    /**
     * Sets the file root. The file root gets prefixed to all filenames passed
     * to the object.
     *
     * Make sure that you override this function when using the class
     * on windows.
     *
     * @param    string
     * @see      HTML_Template_IT()
     * @access   public
     */
    function setRoot($root)
    {
        if ($root != '' && substr($root, -1) != '/') {
            $root .= '/';
        }

        $this->fileRoot = $root;
    } // end func setRoot

    /**
     * Build a list of all variables within of a block
     */
    function buildBlockvariablelist()
    {
        foreach ($this->blocklist as $name => $content) {
            preg_match_all($this->variablesRegExp, $content, $regs);

            if (count($regs[1]) != 0) {
                foreach ($regs[1] as $k => $var) {
                    $this->blockvariables[$name][$var] = true;
                }
            } else {
                $this->blockvariables[$name] = array();
            }
        }
    } // end func buildBlockvariablelist

    /**
     * Returns a list of all global variables
     */
    function getGlobalvariables()
    {
        $regs   = array();
        $values = array();

        foreach ($this->blockvariables['__global__'] as $allowedvar => $v) {
            if (isset($this->variableCache[$allowedvar])) {
                $regs[]   = '@' . $this->openingDelimiter .
                            $allowedvar . $this->closingDelimiter . '@';
                $values[] = $this->variableCache[$allowedvar];
                unset($this->variableCache[$allowedvar]);
            }
        }

        return array($regs, $values);
    } // end func getGlobalvariables

    /**
     * Recusively builds a list of all blocks within the template.
     *
     * @param    string    string that gets scanned
     * @see      $blocklist
     */
    function findBlocks($string)
    {
        $blocklist = array();

        if (preg_match_all($this->blockRegExp, $string, $regs, PREG_SET_ORDER)) {
            foreach ($regs as $k => $match) {
                $blockname         = $match[1];
                $blockcontent = $match[2];

                if (isset($this->blocklist[$blockname])) {
                    $this->err[] = PEAR::raiseError(
                                            $this->errorMessage(
                                            IT_BLOCK_DUPLICATE, $blockname),
                                            IT_BLOCK_DUPLICATE
                                    );
                    $this->flagBlocktrouble = true;
                }

                $this->blocklist[$blockname] = $blockcontent;
                $this->blockdata[$blockname] = "";

                $blocklist[] = $blockname;

                $inner = $this->findBlocks($blockcontent);
                foreach ($inner as $k => $name) {
                    $pattern = sprintf(
                        '@<!--\s+BEGIN\s+%s\s+-->(.*)<!--\s+END\s+%s\s+-->@sm',
                        $name,
                        $name
                    );

                    $this->blocklist[$blockname] = preg_replace(
                                        $pattern,
                                        $this->openingDelimiter .
                                        '__' . $name . '__' .
                                        $this->closingDelimiter,
                                        $this->blocklist[$blockname]
                               );
                    $this->blockinner[$blockname][] = $name;
                    $this->blockparents[$name] = $blockname;
                }
            }
        }

        return $blocklist;
    } // end func findBlocks

    /**
     * Reads a file from disk and returns its content.
     * @param    string    Filename
     * @return   string    Filecontent
     */
    function getFile($filename)
    {
        if ($filename{0} == '/' && substr($this->fileRoot, -1) == '/') {
            $filename = substr($filename, 1);
        }

        $filename = $this->fileRoot . $filename;

        if (!($fh = @fopen($filename, 'r'))) {
            $this->err[] = PEAR::raiseError(
                        $this->errorMessage(IT_TPL_NOT_FOUND) .
                        ': "' .$filename .'"',
                        IT_TPL_NOT_FOUND
                    );
            return "";
        }

		$fsize = filesize($filename);
        if ($fsize < 1) {
			fclose($fh);
            return '';
        }

        $content = fread($fh, $fsize);
        fclose($fh);

        return preg_replace(
            "#<!-- INCLUDE (.*) -->#ime", "\$this->getFile('\\1')", $content
        );
    } // end func getFile

    /**
     * Adds delimiters to a string, so it can be used as a pattern
     * in preg_* functions
     *
     * @param string
     * @return string
     */
    function _addPregDelimiters($str)
    {
        return '@' . $str . '@';
    }

   /**
    * Replaces an opening delimiter by a special string
    *
    * @param  string
    * @return string
    */
    function _preserveOpeningDelimiter($str)
    {
        return (false === strpos($str, $this->openingDelimiter))?
                $str:
                str_replace(
                    $this->openingDelimiter,
                    $this->openingDelimiter .
                    '%preserved%' . $this->closingDelimiter,
                    $str
                );
    }

    /**
     * Return a textual error message for a IT error code
     *
     * @param integer $value error code
     *
     * @return string error message, or false if the error code was
     * not recognized
     */
    function errorMessage($value, $blockname = '')
    {
        static $errorMessages;
        if (!isset($errorMessages)) {
            $errorMessages = array(
                IT_OK                       => '',
                IT_ERROR                    => 'unknown error',
                IT_TPL_NOT_FOUND            => 'Cannot read the template file',
                IT_BLOCK_NOT_FOUND          => 'Cannot find this block',
                IT_BLOCK_DUPLICATE          => 'The name of a block must be'.
                                               ' uniquewithin a template.'.
                                               ' Found "' . $blockname . '" twice.'.
                                               'Unpredictable results '.
                                               'may appear.',
                IT_UNKNOWN_OPTION           => 'Unknown option'
            );
        }

        if (PEAR::isError($value)) {
            $value = $value->getCode();
        }

        return isset($errorMessages[$value]) ?
                $errorMessages[$value] : $errorMessages[IT_ERROR];
    }
} // end class IntegratedTemplate
?>
