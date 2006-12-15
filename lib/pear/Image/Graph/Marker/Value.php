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
 * @subpackage Marker
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: Value.php,v 1.10 2006/02/28 22:48:07 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Marker.php
 */
require_once 'Image/Graph/Marker.php';

/**
 * A marker showing the data value.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Marker
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Marker_Value extends Image_Graph_Marker
{

    /**
     * Datapreproccesor to format the value
     * @var DataPreprocessor
     * @access private
     */
    var $_dataPreprocessor = null;

    /**
     * Which value to use from the data set, ie the X or Y value
     * @var int
     * @access private
     */
    var $_useValue;

    /**
     * Create a value marker, ie a box containing the value of the 'pointing
     * data'
     *
     * @param int $useValue Defines which value to use from the dataset, i.e. the
     *   X or Y value
     */
    function Image_Graph_Marker_Value($useValue = IMAGE_GRAPH_VALUE_X)
    {
        parent::Image_Graph_Marker();
        $this->_padding = array('left' => 2, 'top' => 2, 'right' => 2, 'bottom' => 2);
        $this->_useValue = $useValue;
        $this->_fillStyle = 'white';
        $this->_borderStyle = 'black';
    }

    /**
     * Sets the background fill style of the element
     *
     * @param Image_Graph_Fill $background The background
     * @see Image_Graph_Fill
     */
    function setBackground(& $background)
    {
        $this->setFillStyle($background);
    }

    /**
     * Sets the background color of the element
     *
     * @param mixed $color The color
     */
    function setBackgroundColor($color)
    {
        $this->setFillColor($color);
    }

    /**
     * Sets a data preprocessor for formatting the values
     *
     * @param DataPreprocessor $dataPreprocessor The data preprocessor
     * @return Image_Graph_DataPreprocessor The data preprocessor
     */
    function &setDataPreprocessor(& $dataPreprocessor)
    {
        $this->_dataPreprocessor =& $dataPreprocessor;
        return $dataPreprocessor;
    }

    /**
     * Get the value to display
     *
     * @param array $values The values representing the data the marker 'points'
     *   to
     * @return string The display value, this is the pre-preprocessor value, to
     *   support for customized with multiple values. i.e show 'x = y' or '(x, y)'
     * @access private
     */
    function _getDisplayValue($values)
    {
        switch ($this->_useValue) {
        case IMAGE_GRAPH_VALUE_X:
            $value = $values['X'];
            break;

        case IMAGE_GRAPH_PCT_X_MIN:
            $value = $values['PCT_MIN_X'];
            break;

        case IMAGE_GRAPH_PCT_X_MAX:
            $value = $values['PCT_MAX_X'];
            break;

        case IMAGE_GRAPH_PCT_Y_MIN:
            $value = $values['PCT_MIN_Y'];
            break;

        case IMAGE_GRAPH_PCT_Y_MAX:
            $value = $values['PCT_MAX_Y'];
            break;

        case IMAGE_GRAPH_PCT_Y_TOTAL:
            if (isset($values['SUM_Y'])) {
                $value = 100 * $values['Y'] / $values['SUM_Y'];
            }
            else {
                $value = 0;
            }            
            break;

        case IMAGE_GRAPH_POINT_ID:
            $value = $values['ID'];
            break;

        default:
            $value = $values['Y'];
            break;
        }
        return $value;
    }

    /**
     * Draw the marker on the canvas
     *
     * @param int $x The X (horizontal) position (in pixels) of the marker on
     *   the canvas
     * @param int $y The Y (vertical) position (in pixels) of the marker on the
     *   canvas
     * @param array $values The values representing the data the marker 'points'
     *   to
     * @access private
     */
    function _drawMarker($x, $y, $values = false)
    {
        parent::_drawMarker($x, $y, $values);

        $value = $this->_getDisplayValue($values);

        if ($this->_dataPreprocessor) {
            $value = $this->_dataPreprocessor->_process($value);
        }

        if ($this->_defaultFontOptions !== false) {
            $this->_canvas->setFont($this->_defaultFontOptions);
        } else {        
            $this->_canvas->setFont($this->_getFont());
        }

        $width = $this->_canvas->textWidth($value);
        $height = $this->_canvas->textHeight($value);
        $offsetX = $width/2 + $this->_padding['left'];
        $offsetY = $height/2 + $this->_padding['top'];

        $this->_getFillStyle();
        $this->_getBorderStyle();
        $this->_canvas->rectangle(
        	array(
        		'x0' => $x - $offsetX,
            	'y0' => $y - $offsetY,
            	'x1' => $x + $offsetX,
            	'y1' => $y + $offsetY
            )
        );

        $this->write($x, $y, $value, IMAGE_GRAPH_ALIGN_CENTER);
    }

}

?>