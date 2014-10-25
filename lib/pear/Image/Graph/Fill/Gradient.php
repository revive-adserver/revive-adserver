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
 * @subpackage Fill
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Fill/Image.php
 */
require_once 'Image/Graph/Fill/Image.php';

/**
 * Fill using a gradient color.
 * This creates a scaled fillstyle with colors flowing gradiently between 2
 * specified RGB values. Several directions are supported:
 *
 * 1 Vertically (IMAGE_GRAPH_GRAD_VERTICAL)
 *
 * 2 Horizontally (IMAGE_GRAPH_GRAD_HORIZONTAL)
 *
 * 3 Mirrored vertically (the color grades from a- b-a vertically)
 * (IMAGE_GRAPH_GRAD_VERTICAL_MIRRORED)
 *
 * 4 Mirrored horizontally (the color grades from a-b-a horizontally)
 * IMAGE_GRAPH_GRAD_HORIZONTAL_MIRRORED
 *
 * 5 Diagonally from top-left to right-bottom
 * (IMAGE_GRAPH_GRAD_DIAGONALLY_TL_BR)
 *
 * 6 Diagonally from bottom-left to top-right
 * (IMAGE_GRAPH_GRAD_DIAGONALLY_BL_TR)
 *
 * 7 Radially (concentric circles in the center) (IMAGE_GRAPH_GRAD_RADIAL)
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Fill
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Fill_Gradient extends Image_Graph_Fill //Image_Graph_Fill_Image
{

    /**
     * The direction of the gradient
     * @var int
     * @access private
     */
    var $_direction;

    /**
     * The first color to gradient
     * @var mixed
     * @access private
     */
    var $_startColor;

    /**
     * The last color to gradient
     * @var mixed
     * @access private
     */
    var $_endColor;

    /**
     * Image_Graph_GradientFill [Constructor]
     *
     * @param int $direction The direction of the gradient
     * @param mixed $startColor The value of the starting color
     * @param mixed $endColor The value of the ending color
     */
    function Image_Graph_Fill_Gradient($direction, $startColor, $endColor)
    {
        parent::__construct();
        $this->_direction = $direction;
        $this->_startColor = $startColor;
        $this->_endColor = $endColor;
    }

    /**
     * Return the fillstyle
     *
     * @return int A GD fillstyle
     * @access private
     */
    function _getFillStyle($ID = false)
    {
    	switch ($this->_direction) {
			case IMAGE_GRAPH_GRAD_HORIZONTAL:
				$direction = 'horizontal';
				break;
			case IMAGE_GRAPH_GRAD_VERTICAL:
				$direction = 'vertical';
				break;
			case IMAGE_GRAPH_GRAD_HORIZONTAL_MIRRORED:
				$direction = 'horizontal_mirror';
				break;
			case IMAGE_GRAPH_GRAD_VERTICAL_MIRRORED:
				$direction = 'vertical_mirror';
				break;
			case IMAGE_GRAPH_GRAD_DIAGONALLY_TL_BR:
			    $direction = 'diagonal_tl_br';
			    break;
			case IMAGE_GRAPH_GRAD_DIAGONALLY_BL_TR:
			    $direction = 'diagonal_bl_tr';
			    break;
			case IMAGE_GRAPH_GRAD_RADIAL:
			    $direction = 'radial';
			    break;
    	}
    	
        return array(
            'type' => 'gradient',
            'start' => $this->_startColor,
            'end' => $this->_endColor,
            'direction' => $direction
        );
    }

}

?>
