<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Image_Graph - PEAR PHP OO Graph Rendering Utility.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This library is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; either version 2.1 of the License, or (at your
 * option) any later version. This library is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details. You should have received a copy of
 * the GNU Lesser General Public License along with this library; if not, write
 * to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 * 02111-1307 USA
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Line
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Line/Solid.php
 */
require_once 'Image/Graph/Line/Solid.php';

/**
 * Formatted user defined line style.
 *
 * Use this to create a user defined line style. Specify an array of colors that are to
 * be used for displaying the line.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Line
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Line_Formatted extends Image_Graph_Line_Solid
{

    /**
     * The style of the line
     *
     * @var array
     * @access private
     */
    var $_style;

    /**
     * Image_Graph_FormattedLine [Constructor]
     *
     * @param array $style The style of the line
     */
    function __construct($style)
    {
        parent::__construct(reset($style));
        $this->_style = $style;
    }

    /**
     * Gets the line style of the element
     *
     * @return int A GD linestyle representing the line style
     * @see Image_Graph_Line
     * @access private
     */
    function _getLineStyle()
    {
        return array(
            'color' => $this->_style,
            'thickness' => $this->_thickness
        );
    }

}

?>
