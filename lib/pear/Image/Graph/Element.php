<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Image_Graph - Main class for the graph creation.
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
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Common.php
 */
require_once 'Image/Graph/Common.php';

/**
 * Representation of a element.
 *
 * The Image_Graph_Element can be drawn on the canvas, ie it has coordinates,
 * {@link Image_Graph_Line}, {@link Image_Graph_Fill}, border and background -
 * although not all of these may apply to all children.
 *
 * @category   Images
 * @package    Image_Graph
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 * @abstract
 */
class Image_Graph_Element extends Image_Graph_Common
{

    /**
     * The leftmost pixel of the element on the canvas
     * @var int
     * @access private
     */
    var $_left = 0;

    /**
     * The topmost pixel of the element on the canvas
     * @var int
     * @access private
     */
    var $_top = 0;

    /**
     * The rightmost pixel of the element on the canvas
     * @var int
     * @access private
     */
    var $_right = 0;

    /**
     * The bottommost pixel of the element on the canvas
     * @var int
     * @access private
     */
    var $_bottom = 0;

    /**
     * Background of the element. Default: None
     * @var FillStyle
     * @access private
     */
    var $_background = null;

    /**
     * Borderstyle of the element. Default: None
     * @var LineStyle
     * @access private
     */
    var $_borderStyle = null;

    /**
     * Line style of the element. Default: None
     * @var LineStyle
     * @access private
     */
    var $_lineStyle = 'black';

    /**
     * Fill style of the element. Default: None
     * @var FillStyle
     * @access private
     */
    var $_fillStyle = 'white';

    /**
     * Font of the element. Default: Standard font - FONT
     * @var Font
     * @access private
     * @see $IMAGE_GRAPH_FONT
     */
    var $_font = null;

    /**
     * Font options
     * @var array
     * @access private
     */
    var $_fontOptions = array();

    /**
     * Default font options
     * 
     * This option is included for performance reasons. The value is calculated
     * before output and reused in default cases to avoid unnecessary recursive
     * calls.
     * 
     * @var array
     * @access private
     */
    var $_defaultFontOptions = false;

    /**
     * Shadows options of the element
     * @var mixed
     * @access private
     */
    var $_shadow = false;

    /**
     * The padding displayed on the element
     * @var int
     * @access private
     */
    var $_padding = array('left' => 0, 'top' => 0, 'right' => 0, 'bottom' => 0);

    /**
     * Sets the background fill style of the element
     *
     * @param Image_Graph_Fill $background The background
     * @see Image_Graph_Fill
     */
    function setBackground(& $background)
    {
        if (!is_a($background, 'Image_Graph_Fill')) {
            $this->_error(
                'Could not set background for ' . get_class($this) . ': ' .
                get_class($background), array('background' => &$background)
            );
        } else {
            $this->_background =& $background;
            $this->add($background);
        }
    }

    /**
     * Shows shadow on the element
     */
    function showShadow($color = 'black@0.2', $size = 5)
    {
        $this->_shadow = array(
            'color' => $color,
            'size' => $size
        );
    }

    /**
     * Sets the background color of the element.
     *
     * See colors.txt in the docs/ folder for a list of available named colors.
     *
     * @param mixed $color The color
     */
    function setBackgroundColor($color)
    {
        $this->_background = $color;
    }

     /**
     * Gets the background fill style of the element
     *
     * @return int A GD fillstyle representing the background style
     * @see Image_Graph_Fill
     * @access private
     */
    function _getBackground()
    {
        if (is_object($this->_background)) {
            $this->_canvas->setFill($this->_background->_getFillStyle());
        } elseif ($this->_background != null) {
            $this->_canvas->setFill($this->_background);
        } else {
            return false;
        }
        return true;
    }

    /**
     * Sets the border line style of the element
     *
     * @param Image_Graph_Line $borderStyle The line style of the border
     * @see Image_Graph_Line
     */
    function setBorderStyle(& $borderStyle)
    {
        if (!is_a($borderStyle, 'Image_Graph_Line')) {
            $this->_error(
                'Could not set border style for ' . get_class($this) . ': ' .
                get_class($borderStyle), array('borderstyle' => &$borderStyle)
            );
        } else {
            $this->_borderStyle =& $borderStyle;
            $this->add($borderStyle);
        }
    }

    /**
     * Sets the border color of the element.
     *
     * See colors.txt in the docs/ folder for a list of available named colors.
     * @param mixed $color The color
     */
    function setBorderColor($color)
    {
        $this->_borderStyle = $color;
    }

    /**
     * Gets the border line style of the element
     *
     * @return int A GD linestyle representing the borders line style
     * @see Image_Graph_Line
     * @access private
     */
    function _getBorderStyle()
    {
        if (is_object($this->_borderStyle)) {
            $result = $this->_borderStyle->_getLineStyle();
            $this->_canvas->setLineThickness($result['thickness']);
            $this->_canvas->setLineColor($result['color']);
        } elseif ($this->_borderStyle != null) {
            $this->_canvas->setLineThickness(1);
            $this->_canvas->setLineColor($this->_borderStyle);
        } else {
            return false;
        }
        return true;
    }

    /**
     * Sets the line style of the element
     *
     * @param Image_Graph_Line $lineStyle The line style of the element
     * @see Image_Graph_Line
     */
    function setLineStyle(& $lineStyle)
    {
        if (!is_object($lineStyle)) {
            $this->_error(
                'Could not set line style for ' . get_class($this) . ': ' .
                get_class($lineStyle), array('linestyle' => &$lineStyle)
            );
        } else {
            $this->_lineStyle =& $lineStyle;
            $this->add($lineStyle);
        }
    }

    /**
     * Sets the line color of the element.
     *
     * See colors.txt in the docs/ folder for a list of available named colors.
     *
     * @param mixed $color The color
     */
    function setLineColor($color)
    {
        $this->_lineStyle = $color;
    }

    /**
     * Gets the line style of the element
     *
     * @return int A GD linestyle representing the line style
     * @see Image_Graph_Line
     * @access private
     */
    function _getLineStyle($ID = false)
    {
        if (is_object($this->_lineStyle)) {
            $result = $this->_lineStyle->_getLineStyle($ID);
            if (is_array($result)) {
                $this->_canvas->setLineThickness($result['thickness']);
                $this->_canvas->setLineColor($result['color']);
            } else {
                $this->_canvas->setLineThickness(1);
                $this->_canvas->setLineColor($result);
            }
        } elseif ($this->_lineStyle != null) {
            $this->_canvas->setLineThickness(1);
            $this->_canvas->setLineColor($this->_lineStyle);
        } else {
            return false;
        }
        return true;
    }

    /**
     * Sets the fill style of the element
     *
     * @param Image_Graph_Fill $fillStyle The fill style of the element
     * @see Image_Graph_Fill
     */
    function setFillStyle(& $fillStyle)
    {
        if (!is_a($fillStyle, 'Image_Graph_Fill')) {
            $this->_error(
                'Could not set fill style for ' . get_class($this) . ': ' .
                get_class($fillStyle), array('fillstyle' => &$fillStyle)
            );
        } else {
            $this->_fillStyle =& $fillStyle;
            $this->add($fillStyle);
        }
    }

    /**
     * Sets the fill color of the element.
     *
     * See colors.txt in the docs/ folder for a list of available named colors.
     *
     * @param mixed $color The color
     */
    function setFillColor($color)
    {
        $this->_fillStyle = $color;
    }


    /**
     * Gets the fill style of the element
     *
     * @return int A GD filestyle representing the fill style
     * @see Image_Graph_Fill
     * @access private
     */
    function _getFillStyle($ID = false)
    {
        if (is_object($this->_fillStyle)) {
            $this->_canvas->setFill($this->_fillStyle->_getFillStyle($ID));
        } elseif ($this->_fillStyle != null) {
            $this->_canvas->setFill($this->_fillStyle);
        } else {
            return false;
        }
        return true;
    }

    /**
     * Gets the font of the element.
     *
     * If not font has been set, the parent font is propagated through it's
     * children.
     *
     * @return array An associated array used for canvas
     * @access private
     */
    function _getFont($options = false)
    {
        if (($options === false) && ($this->_defaultFontOptions !== false)) {
            return $this->_defaultFontOptions;
        }
        
        if ($options === false) {
        	$saveDefault = true;
        } else {
        	$saveDefault = false;
        }
        
        if ($options === false) {
            $options = $this->_fontOptions;
        } else {
            $options = array_merge($this->_fontOptions, $options);
        }

        if ($this->_font == null) {
            $result = $this->_parent->_getFont($options);
        } else {
            $result = $this->_font->_getFont($options);
        }

        if ((isset($result['size'])) && (isset($result['size_rel']))) {
            $result['size'] += $result['size_rel'];
            unset($result['size_rel']);
        }
        
        if ($saveDefault) {
        	$this->_defaultFontOptions = $result;
        }
        
        return $result;
    }

    /**
     * Sets the font of the element
     *
     * @param Image_Graph_Font $font The font of the element
     * @see Image_Graph_Font
     */
    function setFont(& $font)
    {
        if (!is_a($font, 'Image_Graph_Font')) {
            $this->_error('Invalid font set on ' . get_class($this));
        } else {
            $this->_font =& $font;
            $this->add($font);
        }
    }

    /**
     * Sets the font size
     *
     * @param int $size The size of the font
     */
    function setFontSize($size)
    {
        $this->_fontOptions['size'] = $size;
    }

    /**
     * Sets the font angle
     *
     * @param int $angle The angle of the font
     */
    function setFontAngle($angle)
    {
        if ($angle == 'vertical') {
            $this->_fontOptions['vertical'] = true;
            $this->_fontOptions['angle'] = 90;
        } else {
            $this->_fontOptions['angle'] = $angle;
        }
    }

    /**
     * Sets the font color
     *
     * @param mixed $color The color of the font
     */
    function setFontColor($color)
    {
        $this->_fontOptions['color'] = $color;
    }

    /**
     * Clip the canvas to the coordinates of the element
     * 
     * @param $enable bool Whether clipping should be enabled or disabled
     * @access protected
     */
    function _clip($enable)
    {
        $this->_canvas->setClipping(
            ($enable ?
                array(
                    'x0' => min($this->_left, $this->_right),
                    'y0' => min($this->_top, $this->_bottom),
                    'x1' => max($this->_left, $this->_right),
                    'y1' => max($this->_top, $this->_bottom)
                )
                : false
            )
        );
    }

    /**
     * Sets the coordinates of the element
     *
     * @param int $left The leftmost pixel of the element on the canvas
     * @param int $top The topmost pixel of the element on the canvas
     * @param int $right The rightmost pixel of the element on the canvas
     * @param int $bottom The bottommost pixel of the element on the canvas
     * @access private
     */
    function _setCoords($left, $top, $right, $bottom)
    {
        if ($left === false) {
            $left = $this->_left;
        }
        
        if ($top === false) {
            $top = $this->_top;
        }

        if ($right === false) {
            $right = $this->_right;
        }
        
        if ($bottom === false) {
            $bottom = $this->_bottom;
        }
        
        $this->_left = min($left, $right);
        $this->_top = min($top, $bottom);
        $this->_right = max($left, $right);
        $this->_bottom = max($top, $bottom);        
    }

    /**
     * Moves the element
     *
     * @param int $deltaX Number of pixels to move the element to the right
     *   (negative values move to the left)
     * @param int $deltaY Number of pixels to move the element downwards
     *   (negative values move upwards)
     * @access private
     */
    function _move($deltaX, $deltaY)
    {
        $this->_left += $deltaX;
        $this->_right += $deltaX;
        $this->_top += $deltaY;
        $this->_bottom += $deltaY;
    }

    /**
     * Sets the width of the element relative to the left side
     *
     * @param int $width Number of pixels the element should be in width
     * @access private
     */
    function _setWidth($width)
    {
        $this->_right = $this->_left + $width;
    }

    /**
     * Sets the height of the element relative to the top
     *
     * @param int $width Number of pixels the element should be in height
     * @access private
     */
    function _setHeight($height)
    {
        $this->_bottom = $this->_top + $height;
    }

    /**
     * Sets padding of the element
     *
     * @param mixed $padding Number of pixels the element should be padded with
     * or an array of paddings (left, top, right and bottom as index)
     */
    function setPadding($padding)
    {
        if (is_array($padding)) {
            $this->_padding = array();
            $this->_padding['left'] = (isset($padding['left']) ? $padding['left'] : 0);         
            $this->_padding['top'] = (isset($padding['top']) ? $padding['top'] : 0);         
            $this->_padding['right'] = (isset($padding['right']) ? $padding['right'] : 0);         
            $this->_padding['bottom'] = (isset($padding['bottom']) ? $padding['bottom'] : 0);         
        }
        else {
            $this->_padding = array(
                'left' => $padding,
                'top' => $padding,
                'right' => $padding,
                'bottom' => $padding
            );
        }
    }

    /**
     * The width of the element on the canvas
     *
     * @return int Number of pixels representing the width of the element
     */
    function width()
    {
        return abs($this->_right - $this->_left) + 1;
    }

    /**
     * The height of the element on the canvas
     *
     * @return int Number of pixels representing the height of the element
     */
    function height()
    {
        return abs($this->_bottom - $this->_top) + 1;
    }

    /**
     * Left boundary of the background fill area
     *
     * @return int Leftmost position on the canvas
     * @access private
     */
    function _fillLeft()
    {
        return $this->_left + $this->_padding['left'];
    }

    /**
     * Top boundary of the background fill area
     *
     * @return int Topmost position on the canvas
     * @access private
     */
    function _fillTop()
    {
        return $this->_top + $this->_padding['top'];
    }

    /**
     * Right boundary of the background fill area
     *
     * @return int Rightmost position on the canvas
     * @access private
     */
    function _fillRight()
    {
        return $this->_right - $this->_padding['right'];
    }

    /**
     * Bottom boundary of the background fill area
     *
     * @return int Bottommost position on the canvas
     * @access private
     */
    function _fillBottom()
    {
        return $this->_bottom - $this->_padding['bottom'];
    }

    /**
     * Returns the filling width of the element on the canvas
     *
     * @return int Filling width
     * @access private
     */
    function _fillWidth()
    {
        return $this->_fillRight() - $this->_fillLeft() + 1;
    }

    /**
     * Returns the filling height of the element on the canvas
     *
     * @return int Filling height
     * @access private
     */
    function _fillHeight()
    {
        return $this->_fillBottom() - $this->_fillTop() + 1;
    }

    /**
     * Draws a shadow 'around' the element
     * 
     * Not implemented yet.
     *
     * @access private
     */
    function _displayShadow()
    {        
        if (is_array($this->_shadow)) {
            $this->_canvas->startGroup(get_class($this) . '_shadow');
            $this->_canvas->setFillColor($this->_shadow['color']);        
            $this->_canvas->addVertex(array('x' => $this->_right + 1, 'y' => $this->_top + $this->_shadow['size']));
            $this->_canvas->addVertex(array('x' => $this->_right + $this->_shadow['size'], 'y' => $this->_top + $this->_shadow['size']));
            $this->_canvas->addVertex(array('x' => $this->_right + $this->_shadow['size'], 'y' => $this->_bottom + $this->_shadow['size']));
            $this->_canvas->addVertex(array('x' => $this->_left + $this->_shadow['size'], 'y' => $this->_bottom + $this->_shadow['size']));
            $this->_canvas->addVertex(array('x' => $this->_left + $this->_shadow['size'], 'y' => $this->_bottom + 1));
            $this->_canvas->addVertex(array('x' => $this->_right + 1, 'y' => $this->_bottom + 1));
            $this->_canvas->polygon(array('connect' => true));            
            $this->_canvas->endGroup();
        }
    }

    /**
     * Writes text to the canvas.
     *
     * @param int $x The x position relative to alignment
     * @param int $y The y position relative to alignment
     * @param string $text The text
     * @param int $alignmen The text alignment (both vertically and horizontally)
     */
    function write($x, $y, $text, $alignment = false, $font = false)
    {
        if (($font === false) && ($this->_defaultFontOptions !== false)) {
            $font = $this->_defaultFontOptions;
        } else {
            $font = $this->_getFont($font);
        }

        if ($alignment === false) {
            $alignment = IMAGE_GRAPH_ALIGN_LEFT + IMAGE_GRAPH_ALIGN_TOP;
        }
        
        $align = array();      
        
        if (($alignment & IMAGE_GRAPH_ALIGN_TOP) != 0) {
        	$align['vertical'] = 'top';
        } else if (($alignment & IMAGE_GRAPH_ALIGN_BOTTOM) != 0) {       
        	$align['vertical'] = 'bottom';
        } else {
        	$align['vertical'] = 'center';
        }

        if (($alignment & IMAGE_GRAPH_ALIGN_LEFT) != 0) {
        	$align['horizontal'] = 'left';
        } else if (($alignment & IMAGE_GRAPH_ALIGN_RIGHT) != 0) {       
        	$align['horizontal'] = 'right';
        } else {
        	$align['horizontal'] = 'center';
        }

        $this->_canvas->setFont($font);
        $this->_canvas->addText(array('x' => $x, 'y' => $y, 'text' => $text, 'alignment' => $align));
    }

    /**
     * Output the element to the canvas
     *
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @see Image_Graph_Common
     * @access private
     */
    function _done()
    {
        $background = $this->_getBackground();
        $border = $this->_getBorderStyle();
        if (($background) || ($border)) {
            $this->_canvas->rectangle(array('x0' => $this->_left, 'y0' => $this->_top, 'x1' => $this->_right, 'y1' => $this->_bottom));
        }

        $result = parent::_done();
        
        if ($this->_shadow !== false) {
            $this->_displayShadow();
        }

        return $result;
    }

}
?>
