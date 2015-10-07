<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * HTML class for a hidden type element
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    HTML
 * @package     HTML_QuickForm
 * @author      Adam Daniel <adaniel1@eesus.jnj.com>
 * @author      Bertrand Mansion <bmansion@mamasam.com>
 * @copyright   2001-2007 The PHP Group
 * @license     http://www.php.net/license/3_01.txt PHP License 3.01
 * @link        http://pear.php.net/package/HTML_QuickForm
 */

/**
 * Base class for <input /> form elements
 */
require_once 'HTML/QuickForm/input.php';

/**
 * HTML class for a hidden type element
 *
 * @category    HTML
 * @package     HTML_QuickForm
 * @author      Adam Daniel <adaniel1@eesus.jnj.com>
 * @author      Bertrand Mansion <bmansion@mamasam.com>
 * @version     Release: 3.2.10
 * @since       1.0
 */
class HTML_QuickForm_hidden extends HTML_QuickForm_input
{
    // {{{ constructor

    /**
     * Class constructor
     *
     * @param     string    $elementName    (optional)Input field name attribute
     * @param     string    $value          (optional)Input field value
     * @param     mixed     $attributes     (optional)Either a typical HTML attribute string
     *                                      or an associative array
     * @since     1.0
     * @access    public
     * @return    void
     */
    function __construct($elementName=null, $value='', $attributes=null)
    {
        parent::__construct($elementName, null, $attributes);
        $this->setType('hidden');
        $this->setValue($value);
    } //end constructor

    // }}}
    // {{{ freeze()

    /**
     * Freeze the element so that only its value is returned
     *
     * @access    public
     * @return    void
     */
    function freeze()
    {
        return false;
    } //end func freeze

    // }}}
    // {{{ accept()

   /**
    * Accepts a renderer
    *
    * @param HTML_QuickForm_Renderer    renderer object
    * @param bool                       Whether an element is required
    * @param string                     An error message associated with an element
    * @access public
    * @return void
    */
    function accept(&$renderer, $required=false, $error=null)
    {
        $renderer->renderHidden($this, $required, $error);
    } // end func accept

    // }}}

} //end class HTML_QuickForm_hidden
?>
