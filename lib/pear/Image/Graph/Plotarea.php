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
 * @subpackage Plotarea
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: Plotarea.php,v 1.23 2006/02/28 22:48:07 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Layout.php
 */
require_once 'Image/Graph/Layout.php';

/**
 * Plot area used for drawing plots.
 *
 * The plotarea consists of an x-axis and an y-axis, the plotarea can plot multiple
 * charts within one plotares, by simply adding them (the axis' will scale to the
 * plots automatically). A graph can consist of more plotareas
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Plotarea
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Plotarea extends Image_Graph_Layout
{
    
    /**
     * The left most pixel of the 'real' plot area on the canvas
     * @var int
     * @access private
     */
    var $_plotLeft = 0;

    /**
     * The top most pixel of the 'real' plot area on the canvas
     * @var int
     * @access private
     */
    var $_plotTop = 0;

    /**
     * The right most pixel of the 'real' plot area on the canvas
     * @var int
     * @access private
     */
    var $_plotRight = 0;

    /**
     * The bottom most pixel of the 'real' plot area on the canvas
     * @var int
     * @access private
     */
    var $_plotBottom = 0;

    /**
     * The X axis
     * @var Axis
     * @access private
     */
    var $_axisX = null;

    /**
     * The Y axis
     * @var Axis
     * @access private
     */
    var $_axisY = null;

    /**
     * The secondary Y axis
     * @var Axis
     * @access private
     */
    var $_axisYSecondary = null;

    /**
     * The border style of the 'real' plot area
     * @var LineStyle
     * @access private
     */
    var $_plotBorderStyle = null;

    /**
     * Does any plot have any data?
     * @var bool
     * @access private
     */
    var $_hasData = false;
    
    /**
     * Is the plotarea horizontal?
     * @var bool
     * @access private
     */
    var $_horizontal = false;

    /**
     * Image_Graph_Plotarea [Constructor]
     *
     * @param string $axisX The class of the X axis (if omitted a std. axis is created)
     * @param string $axisY The class of the Y axis (if omitted a std. axis is created)
     * @param string $direction The direction of the plotarea - 'horizontal' or 'vertical' (default)
     */
    function Image_Graph_Plotarea($axisX = 'Image_Graph_Axis_Category', $axisY = 'Image_Graph_Axis', $direction = 'vertical')
    {
        parent::Image_Graph_Layout();

        $this->_padding = array('left' => 5, 'top' => 5, 'right' => 5, 'bottom' => 5);;

        include_once 'Image/Graph.php';

        $this->_axisX =& Image_Graph::factory($axisX, IMAGE_GRAPH_AXIS_X);
        $this->_axisX->_setParent($this);

        $this->_axisY =& Image_Graph::factory($axisY, IMAGE_GRAPH_AXIS_Y);
        $this->_axisY->_setParent($this);
        $this->_axisY->_setMinimum(0);

        $this->_fillStyle = false;
        
        if ($direction == 'horizontal') {
            $this->_horizontal = true;
            $this->_axisX->_transpose = true;
            $this->_axisY->_transpose = true;
        }
    }

    /**
     * Sets the parent. The parent chain should ultimately be a GraPHP object
     *
     * @see Image_Graph_Common
     * @param Image_Graph_Common $parent The parent
     * @access private
     */
    function _setParent(& $parent)
    {
        parent::_setParent($parent);
        if ($this->_axisX !== null) {
            $this->_axisX->_setParent($this);
        }
        if ($this->_axisY !== null) {
            $this->_axisY->_setParent($this);
        }
        if ($this->_axisYSecondary !== null) {
            $this->_axisYSecondary->_setParent($this);
        }
    }

    /**
     * Sets the plot border line style of the element.
     *
     * @param Image_Graph_Line $lineStyle The line style of the border
     * @deprecated 0.3.0dev2 - 2004-12-16
     */
    function setPlotBorderStyle(& $plotBorderStyle)
    {        
    }

    /**
     * Adds an element to the plotarea
     *
     * @param Image_Graph_Element $element The element to add
     * @param int $axis The axis to associate the element with, either
     * IMAGE_GRAPH_AXIS_X, IMAGE_GRAPH_AXIS_Y, IMAGE_GRAPH_AXIS_Y_SECONDARY
     * or the shorter string notations 'x', 'y' or 'ysec' (defaults to
     * IMAGE_GRAPH_AXIS_Y)
     * @return Image_Graph_Element The added element
     * @see Image_Graph_Common::add()
     */
    function &add(& $element, $axis = IMAGE_GRAPH_AXIS_Y)    
    {
        if ($axis == 'x') {
            $axis = IMAGE_GRAPH_AXIS_X;
        }
        if ($axis == 'y') {
            $axis = IMAGE_GRAPH_AXIS_Y;
        }
        if ($axis == 'ysec') {
            $axis = IMAGE_GRAPH_AXIS_Y_SECONDARY;
        }
        if (($axis == IMAGE_GRAPH_AXIS_Y_SECONDARY) &&
            ($this->_axisYSecondary == null))
        {
            $this->_axisYSecondary =& Image_Graph::factory('axis', IMAGE_GRAPH_AXIS_Y_SECONDARY);
            $this->_axisYSecondary->_setMinimum(0);
            if ($this->_horizontal) {
                $this->_axisYSecondary->_transpose = true;
            }
        }

        parent::add($element);

        if (is_a($element, 'Image_Graph_Plot')) {
            $element->_setAxisY($axis);
            // postpone extrema calculation until we calculate coordinates
            //$this->_setExtrema($element);
        } elseif (is_a($element, 'Image_Graph_Grid')) {
            switch ($axis) {
            case IMAGE_GRAPH_AXIS_X:
                if ($this->_axisX != null) {
                    $element->_setPrimaryAxis($this->_axisX);
                    if ($this->_axisY != null) {
                        $element->_setSecondaryAxis($this->_axisY);
                    }
                }
                break;
            case IMAGE_GRAPH_AXIS_Y:
                if ($this->_axisY != null) {
                    $element->_setPrimaryAxis($this->_axisY);
                    if ($this->_axisX != null) {
                        $element->_setSecondaryAxis($this->_axisX);
                    }
                }
                break;
            case IMAGE_GRAPH_AXIS_Y_SECONDARY:
                if ($this->_axisYSecondary != null) {
                    $element->_setPrimaryAxis($this->_axisYSecondary);
                    if ($this->_axisX != null) {
                        $element->_setSecondaryAxis($this->_axisX);
                    }
                }
                break;
            }
        } elseif (is_a($element, 'Image_Graph_Axis')) {
            switch ($element->_type) {
            case IMAGE_GRAPH_AXIS_X:
                $this->_axisX =& $element;
                break;

            case IMAGE_GRAPH_AXIS_Y:
                $this->_axisY =& $element;
                break;

            case IMAGE_GRAPH_AXIS_Y_SECONDARY:
                $this->_axisYSecondary =& $element;
                break;

            }
            if ($element->_getMinimum() == $element->_getMaximum()) {
                $element->_setMinimum(0);
                $element->_setMaximum(1);
            }
        }
        return $element;
    }    

    /**
     * Get the width of the 'real' plotarea
     *
     * @return int The width of the 'real' plotarea, ie not including space occupied by padding and axis
     * @access private
     */
    function _plotWidth()
    {
        return abs($this->_plotRight - $this->_plotLeft);
    }

    /**
     * Get the height of the 'real' plotarea
     *
     * @return int The height of the 'real' plotarea, ie not including space
     *   occupied by padding and axis
     * @access private
     */
    function _plotHeight()
    {
        return abs($this->_plotBottom - $this->_plotTop);
    }

    /**
     * Set the extrema of the axis
     *
     * @param Image_Graph_Plot $plot The plot that 'hold' the values
     * @access private
     */
    function _setExtrema(& $plot)
    {
        if (($this->_axisX != null) && ($this->_axisX->_isNumeric())) {
            $this->_axisX->_setMinimum($plot->_minimumX());
            $this->_axisX->_setMaximum($plot->_maximumX());
        }

        if (($plot->_axisY == IMAGE_GRAPH_AXIS_Y_SECONDARY) &&
            ($this->_axisYSecondary !== null) &&
            ($this->_axisYSecondary->_isNumeric()))
        {
            $this->_axisYSecondary->_setMinimum($plot->_minimumY());
            $this->_axisYSecondary->_setMaximum($plot->_maximumY());
        } elseif (($this->_axisY != null) && ($this->_axisY->_isNumeric())) {
            $this->_axisY->_setMinimum($plot->_minimumY());
            $this->_axisY->_setMaximum($plot->_maximumY());
        }

        $datasets =& $plot->dataset();
        if (!is_array($datasets)) {
            $datasets = array($datasets);
        }
        
        $keys = array_keys($datasets);
        foreach ($keys as $key) {
            $dataset =& $datasets[$key];
            if ($dataset->count() > 0) {
                $this->_hasData = true;
            }
            
            if (is_a($dataset, 'Image_Graph_Dataset')) {
                if (($this->_axisX != null) && (!$this->_axisX->_isNumeric())) {
                    $this->_axisX->_applyDataset($dataset);
                }

                if (($plot->_axisY == IMAGE_GRAPH_AXIS_Y_SECONDARY) &&
                    ($this->_axisYSecondary !== null) &&
                    (!$this->_axisYSecondary->_isNumeric()))
                {
                    $this->_axisYSecondary->_applyDataset($dataset);
                } elseif (($this->_axisY != null) && (!$this->_axisY->_isNumeric())) {
                    $this->_axisY->_applyDataset($dataset);
                }
            }
        }
        unset($keys);
    }

    /**
     * Left boundary of the background fill area
     *
     * @return int Leftmost position on the canvas
     * @access private
     */
    function _fillLeft()
    {
        return $this->_plotLeft;
    }

    /**
     * Top boundary of the background fill area
     *
     * @return int Topmost position on the canvas
     * @access private
     */
    function _fillTop()
    {
        return $this->_plotTop;
    }

    /**
     * Right boundary of the background fill area
     *
     * @return int Rightmost position on the canvas
     * @access private
     */
    function _fillRight()
    {
        return $this->_plotRight;
    }

    /**
     * Bottom boundary of the background fill area
     *
     * @return int Bottommost position on the canvas
     * @access private
     */
    function _fillBottom()
    {
        return $this->_plotBottom;
    }

    /**
     * Get the point from the x-axis
     * @param array $value The value array
     * @param int $min The minimum pixel position possible
     * @param int $max The maximum pixel position possible
     * @return int The pixel position from the axis
     * @access private
     */
    function _axisPointX($value, $min, $max)
    {
        if (($this->_axisX == null) || (!isset($value['X']))) {
            return false;
        }

        if ($value['X'] === '#min#') {
            return $min;
        }
        if ($value['X'] === '#max#') {
            return $max;
        }

        return $this->_axisX->_point($value['X']);
    }
    
    /**
     * Get the point from the x-axis
     * @param array $value The value array
     * @param int $min The minimum pixel position possible
     * @param int $max The maximum pixel position possible
     * @return int The pixel position from the axis
     * @access private
     */
    function _axisPointY($value, $min, $max)
    {
        if (!isset($value['Y'])) {
            return false;
        }
    
        if (($value['Y'] === '#min_pos#') || ($value['Y'] === '#max_nex#')) {
            // return the minimum (bottom) position or if negative then zero
            // or the maxmum (top) position or if positive then zero
            if ((isset($value['AXIS_Y'])) &&
                ($value['AXIS_Y'] == IMAGE_GRAPH_AXIS_Y_SECONDARY) &&
                ($this->_axisYSecondary !== null)
            ) {
                $axisY =& $this->_axisYSecondary;
            } else {
                $axisY =& $this->_axisY;
            }
            if ($value['Y'] === '#min_pos#') {
                return $axisY->_point(max(0, $axisY->_getMinimum()));
            } else {
                return $axisY->_point(min(0, $axisY->_getMaximum()));
            }
        }
    
        if ($value['Y'] === '#min#') {
            return $min;
        }
        if ($value['Y'] === '#max#') {
            return $max;
        }
    
        if ((isset($value['AXIS_Y'])) &&
            ($value['AXIS_Y'] == IMAGE_GRAPH_AXIS_Y_SECONDARY)
        ) {
            if ($this->_axisYSecondary !== null) {
                return $this->_axisYSecondary->_point($value['Y']);
            }
        } else {
            if ($this->_axisY !== null) {
                return $this->_axisY->_point($value['Y']);
            }
        }
        return false;      
    }

    /**
     * Get the X pixel position represented by a value
     *
     * @param double Value the value to get the pixel-point for
     * @return double The pixel position along the axis
     * @access private
     */
    function _pointX($value)
    {
        if ($this->_horizontal) {
            return $this->_axisPointY($value, $this->_plotLeft, $this->_plotRight);
        }
        else {
            return $this->_axisPointX($value, $this->_plotLeft, $this->_plotRight);
        }
    }

    /**
     * Get the Y pixel position represented by a value
     *
     * @param double Value the value to get the pixel-point for
     * @return double The pixel position along the axis
     * @access private
     */
    function _pointY($value)
    {
        if ($this->_horizontal) {
            return $this->_axisPointX($value, $this->_plotBottom, $this->_plotTop);
        }
        else {
            return $this->_axisPointY($value, $this->_plotBottom, $this->_plotTop);
        }
    }

    /**
     * Return the minimum value of the specified axis
     *
     * @param int $axis The axis to return the minimum value of (see {$link
     * Image_Graph_Plotarea::getAxis()})
     * @return double The minimum value of the axis
     * @access private
     */
    function _getMinimum($axis = IMAGE_GRAPH_AXIS_Y)
    {
        $axis =& $this->getAxis($axis);
        if ($axis !== null) {
            return $axis->_getMinimum();
        } else {
            return 0;
        }
    }

    /**
     * Return the maximum value of the specified axis
     *
     * @param int $axis The axis to return the maximum value of(see {$link
     * Image_Graph_Plotarea::getAxis()})
     * @return double The maximum value of the axis
     * @access private
     */
    function _getMaximum($axis = IMAGE_GRAPH_AXIS_Y)
    {
        $axis =& $this->getAxis($axis);
        if ($axis !== null) {
            return $axis->_getMaximum();
        } else {
            return 0;
        }
    }

    /**
     * Return the label distance for the specified axis.
     *
     * @param int $axis The axis to return the label distance for
     * @return int The distance between 2 adjacent labels
     * @access private
     */
    function _labelDistance($axis)
    {
        $axis =& $this->getAxis($axis);
        if ($axis !== null) {
            return $axis->_labelDistance();
        }

        return false;
    }

    /**
     * Hides the axis
     */
    function hideAxis($axis = false)
    {
        if (((!$axis) || ($axis === $this->_axisX) || ($axis === 'x')) && ($this->_axisX != null)) {
            $this->_axisX->hide();
        }            
        if (((!$axis) || ($axis === $this->_axisY) || ($axis === 'y')) && ($this->_axisY != null)) {
            $this->_axisY->hide();
        }            
        if (((!$axis) || ($axis === $this->_axisYSecondary) || ($axis === 'y_sec')) && ($this->_axisYSecondary != null)) {
            $this->_axisYSecondary->hide();
        }            
    }

    /**
     * Clears/removes the axis
     */
    function clearAxis()
    {
        $this->_axisX = $this->_axisY = $this->_axisYSecondary = null;
    }
        
    /**
     * Get axis.
     * 
     * Possible values are IMAGE_GRAPH_AXIS_X, IMAGE_GRAPH_AXIS_Y,
     * IMAGE_GRAPH_AXIS_Y_SECONDARY or a short hand notation using
     * string identifiers: 'x', 'y', 'ysec'
     * 
     * @param int $axis The axis to return
     * @return Image_Graph_Axis The axis
     */
    function &getAxis($axis = IMAGE_GRAPH_AXIS_X)
    {
        switch ($axis) {
        case IMAGE_GRAPH_AXIS_X:
        case 'x':
            return $this->_axisX;

        case IMAGE_GRAPH_AXIS_Y:
        case 'y':
            return $this->_axisY;

        case IMAGE_GRAPH_AXIS_Y_SECONDARY:
        case 'ysec':
            return $this->_axisYSecondary;

        }
        return null;
    }

    /**
     * Update coordinates
     *
     * @access private
     */
    function _updateCoords()
    {               
        if (is_array($this->_elements)) {
            $keys = array_keys($this->_elements);
            foreach ($keys as $key) {
                $element =& $this->_elements[$key];
                if (is_a($element, 'Image_Graph_Plot')) { 
                    if (((is_a($element, 'Image_Graph_Plot_Bar')) ||
                        (is_a($element, 'Image_Graph_Plot_Step')) ||
                        (is_a($element, 'Image_Graph_Plot_Dot')) ||
                        (is_a($element, 'Image_Graph_Plot_CandleStick')) ||
                        (is_a($element, 'Image_Graph_Plot_BoxWhisker')) ||
                        (is_a($element, 'Image_Graph_Plot_Impulse'))) &&
                        ($this->_axisX != null) &&
                        (strtolower(get_class($this->_axisX)) != 'image_graph_axis') // do not push plot if x-axis is linear
                        )
                    {
                       $this->_axisX->_pushValues();
                    }
                    $this->_setExtrema($element);
                }
            }
            unset($keys);
        }

        $this->_calcEdges();

        $pctWidth = (int) ($this->width() * 0.05);
        $pctHeight = (int) ($this->height() * 0.05);

        $left = $this->_left + $this->_padding['left'];
        $top = $this->_top + $this->_padding['top'];
        $right = $this->_right - $this->_padding['right'];
        $bottom = $this->_bottom - $this->_padding['bottom'];
        
        // temporary place holder for axis point calculations
        $axisPoints['x'] = array($left, $top, $right, $bottom);
        $axisPoints['y'] = $axisPoints['x'];
        $axisPoints['y2'] = $axisPoints['x'];
                
        if ($this->_axisX !== null) {
            $intersectX = $this->_axisX->_getAxisIntersection();
            $sizeX = $this->_axisX->_size();
            $this->_axisX->_setCoords($left, $top, $right, $bottom);
            $this->_axisX->_updateCoords();            
        }
        
        if ($this->_axisY !== null) {
            $intersectY = $this->_axisY->_getAxisIntersection();
            $sizeY = $this->_axisY->_size();
            $this->_axisY->_setCoords($left, $top, $right, $bottom);
            $this->_axisY->_updateCoords();
        }

        if ($this->_axisYSecondary !== null) {
            $intersectYsec = $this->_axisYSecondary->_getAxisIntersection();
            $sizeYsec = $this->_axisYSecondary->_size();
            $this->_axisYSecondary->_setCoords($left, $top, $right, $bottom);
            $this->_axisYSecondary->_updateCoords();
        }   
        
        $axisCoordAdd = array('left' => 0, 'right' => 0, 'top' => 0, 'bottom' => 0);
             
        if ($this->_axisY != null) {
            if ($this->_axisX != null) {                
                $pos = $this->_axisX->_intersectPoint($intersectY['value']);                
            } else {
                $pos = ($this->_horizontal ? $bottom : $left);
            }

            if ($this->_horizontal) {
                if (($pos + $sizeY) > $bottom) {
                    $axisCoordAdd['bottom'] = ($pos + $sizeY) - $bottom;                    
                    // the y-axis position needs to be recalculated!                
                } else {            
                    // top & bottom may need to be adjusted when the x-axis has been
                    // calculated!
                    $this->_axisY->_setCoords(
                        $left,
                        $pos,
                        $right,
                        $pos + $sizeY
                    );
                    $this->_axisY->_updateCoords();
                }
            }
            else {
                if (($pos - $sizeY) < $left) {
                    $axisCoordAdd['left'] = $left - ($pos - $sizeY);
                    // the y-axis position needs to be recalculated!                
                } else {            
                    // top & bottom may need to be adjusted when the x-axis has been
                    // calculated!
                    $this->_axisY->_setCoords(
                        $pos - $sizeY,
                        $top,
                        $pos,
                        $bottom
                    );
                    $this->_axisY->_updateCoords();
                }
            }      
        }      

        if ($this->_axisYSecondary != null) {
            if ($this->_axisX != null) {
                $pos = $this->_axisX->_intersectPoint($intersectYsec['value']);
            } else {
                $pos = ($this->_horizontal ? $top : $right);
            }
            
            if ($this->_horizontal) {
                if (($pos - $sizeYsec) < $top) {
                    $axisCoordAdd['top'] = $top - ($pos - $sizeYsec);
                    // the secondary y-axis position need to be recalculated
                } else {
                    // top & bottom may need to be adjusted when the x-axis has been
                    // calculated!
                    $this->_axisYSecondary->_setCoords(
                        $left,
                        $pos - $sizeY,
                        $right,
                        $pos
                    );
                    $this->_axisYSecondary->_updateCoords();
                }
            }
            else {
                if (($pos + $sizeYsec) > $right) {
                    $axisCoordAdd['right'] = ($pos + $sizeYsec) - $right;
                    // the secondary y-axis position need to be recalculated
                } else {
                    // top & bottom may need to be adjusted when the x-axis has been
                    // calculated!
                    $this->_axisYSecondary->_setCoords(
                        $pos,
                        $top,
                        $pos + $sizeY,
                        $bottom
                    );
                    $this->_axisYSecondary->_updateCoords();
                }
            }      
        }      
        
        if ($this->_axisX != null) {
            if (($intersectX['axis'] == IMAGE_GRAPH_AXIS_Y_SECONDARY) &&
                ($this->_axisYSecondary !== null)
            ) {
                $axis =& $this->_axisYSecondary;
            } elseif ($this->_axisY !== null) {
                $axis =& $this->_axisY;
            } else {
                $axis = false;
            }
            
            if ($axis !== false) {
                $pos = $axis->_intersectPoint($intersectX['value']);
            } else {
                $pos = ($this->_horizontal ? $left : $bottom);
            }
             
            if ($this->_horizontal) {
                if (($pos - $sizeX) < $left) {
                    $axisCoordAdd['left'] = $left - ($pos - $sizeX);
                    $pos = $left + $sizeX;
                }
                          
                $this->_axisX->_setCoords(
                    $pos - $sizeX,
                    $top + $axisCoordAdd['top'],
                    $pos,
                    $bottom - $axisCoordAdd['bottom']
                );
                $this->_axisX->_updateCoords();
            }
            else {
                if (($pos + $sizeX) > $bottom) {
                    $axisCoordAdd['bottom'] = ($pos + $sizeX) - $bottom;
                    $pos = $bottom - $sizeX;
                }
                          
                $this->_axisX->_setCoords(
                    $left + $axisCoordAdd['left'],
                    $pos,
                    $right - $axisCoordAdd['right'],
                    $pos + $sizeX
                );
                $this->_axisX->_updateCoords();
            }
        }
        
        if ($this->_horizontal) {
            if (($this->_axisX !== null) && 
                (($axisCoordAdd['top'] != 0) ||
                ($axisCoordAdd['bottom'] != 0))
            ) {
                // readjust y-axis for better estimate of position
                if ($this->_axisY !== null) {
                    $pos = $this->_axisX->_intersectPoint($intersectY['value']);
                    $this->_axisY->_setCoords(
                        false,
                        $pos,
                        false,
                        $pos + $sizeY
                    );
                    $this->_axisY->_updateCoords();
                }
    
                if ($this->_axisYSecondary !== null) {
                    $pos = $this->_axisX->_intersectPoint($intersectYsec['value']);
                    $this->_axisYSecondary->_setCoords(
                        false,
                        $pos - $sizeYsec,
                        false,
                        $pos
                    );
                    $this->_axisYSecondary->_updateCoords();
                }
            }        
            
            // adjust top and bottom of y-axis
            if ($this->_axisY !== null) {
                $this->_axisY->_setCoords(
                    $left + $axisCoordAdd['left'],
                    false, 
                    $right - $axisCoordAdd['right'],
                    false                   
                );
                $this->_axisY->_updateCoords();
            } 
    
            // adjust top and bottom of y-axis
            if ($this->_axisYSecondary !== null) {
                $this->_axisYSecondary->_setCoords(
                    $left + $axisCoordAdd['left'], 
                    false, 
                    $right - $axisCoordAdd['right'],
                    false                    
                );
                $this->_axisYSecondary->_updateCoords();            
            } 
        
            if ($this->_axisX !== null) {
                $this->_plotTop = $this->_axisX->_top;
                $this->_plotBottom = $this->_axisX->_bottom;
            } else {
                $this->_plotTop = $top;
                $this->_plotBottom = $bottom;
            }
            
            if ($this->_axisY !== null) {
                $this->_plotLeft = $this->_axisY->_left;
                $this->_plotRight = $this->_axisY->_right;
            } elseif ($this->_axisYSecondary !== null) {
                $this->_plotLeft = $this->_axisYSecondary->_left;
                $this->_plotRight = $this->_axisYSecondary->_right;
            } else {
                $this->_plotLeft = $this->_left;
                $this->_plotRight = $this->_right;
            }
        }
        else {
            if (($this->_axisX !== null) && 
                (($axisCoordAdd['left'] != 0) ||
                ($axisCoordAdd['right'] != 0))
            ) {
                // readjust y-axis for better estimate of position
                if ($this->_axisY !== null) {
                    $pos = $this->_axisX->_intersectPoint($intersectY['value']);
                    $this->_axisY->_setCoords(
                        $pos - $sizeY,
                        false,
                        $pos,
                        false
                    );
                    $this->_axisY->_updateCoords();
                }
    
                if ($this->_axisYSecondary !== null) {
                    $pos = $this->_axisX->_intersectPoint($intersectYsec['value']);
                    $this->_axisYSecondary->_setCoords(
                        $pos,
                        false,
                        $pos + $sizeYsec,
                        false
                    );
                    $this->_axisYSecondary->_updateCoords();
                }
            }        
            
            // adjust top and bottom of y-axis
            if ($this->_axisY !== null) {
                $this->_axisY->_setCoords(
                    false, 
                    $top + $axisCoordAdd['top'], 
                    false, 
                    $bottom - $axisCoordAdd['bottom']
                );
                $this->_axisY->_updateCoords();
            } 
    
            // adjust top and bottom of y-axis
            if ($this->_axisYSecondary !== null) {
                $this->_axisYSecondary->_setCoords(
                    false, 
                    $top + $axisCoordAdd['top'], 
                    false, 
                    $bottom - $axisCoordAdd['bottom']
                );
                $this->_axisYSecondary->_updateCoords();            
            } 
        
            if ($this->_axisX !== null) {
                $this->_plotLeft = $this->_axisX->_left;
                $this->_plotRight = $this->_axisX->_right;
            } else {
                $this->_plotLeft = $left;
                $this->_plotRight = $right;
            }
            
            if ($this->_axisY !== null) {
                $this->_plotTop = $this->_axisY->_top;
                $this->_plotBottom = $this->_axisY->_bottom;
            } elseif ($this->_axisYSecondary !== null) {
                $this->_plotTop = $this->_axisYSecondary->_top;
                $this->_plotBottom = $this->_axisYSecondary->_bottom;
            } else {
                $this->_plotTop = $this->_top;
                $this->_plotBottom = $this->_bottom;
            }
        }
        
        Image_Graph_Element::_updateCoords();
/*
        if ($this->_axisX != null) {
            $this->_axisX->_updateCoords();
        }
        if ($this->_axisY != null) {
            $this->_axisY->_updateCoords();
        }
        if ($this->_axisYSecondary != null) {
            $this->_axisYSecondary->_updateCoords();
        }*/
    }
    
    /**
     * Set the axis padding for a specified position.
     * 
     * The axis padding is padding "inside" the plotarea (i.e. to put some space
     * between the axis line and the actual plot).
     * 
     * This can be specified in a number of ways:
     * 
     * 1) Specify an associated array with 'left', 'top', 'right' and 'bottom'
     * indices with values for the paddings. Leave out 2nd parameter.
     * 
     * 2) Specify an overall padding as the first parameter
     * 
     * 3) Specify the padding and position with position values as mentioned
     * above
     * 
     * Normally you'd only consider applying axis padding to a category x-axis.
     * 
     * @param mixed $value The value/padding
     * @param mixed $position The "position" of the padding
     */
    function setAxisPadding($value, $position = false)
    {
        if ($position === false) {
            if (is_array($value)) {
                if ($this->_horizontal) {
                    if ((isset($value['top'])) && ($this->_axisX !== null)) {
                        $this->_axisX->_setAxisPadding('low', $value['top']);
                    }
                    if ((isset($value['bottom'])) && ($this->_axisX !== null)) {
                        $this->_axisX->_setAxisPadding('high', $value['bottom']);
                    }
                    if ((isset($value['left'])) && ($this->_axisY !== null)) {
                        $this->_axisY->_setAxisPadding('low', $value['left']);
                    }
                    if ((isset($value['right'])) && ($this->_axisY !== null)) {               
                        $this->_axisY->_setAxisPadding('high', $value['right']);
                    }
                    if ((isset($value['left'])) && ($this->_axisYSecondary !== null)) {
                        $this->_axisYSecondary->_setAxisPadding('low', $value['left']);
                    }
                    if ((isset($value['right'])) && ($this->_axisYSecondary !== null)) {               
                        $this->_axisYSecondary->_setAxisPadding('high', $value['right']);
                    }
                }
                else {
                    if ((isset($value['left'])) && ($this->_axisX !== null)) {
                        $this->_axisX->_setAxisPadding('low', $value['left']);
                    }
                    if ((isset($value['right'])) && ($this->_axisX !== null)) {
                        $this->_axisX->_setAxisPadding('high', $value['right']);
                    }
                    if ((isset($value['bottom'])) && ($this->_axisY !== null)) {
                        $this->_axisY->_setAxisPadding('low', $value['bottom']);
                    }
                    if ((isset($value['top'])) && ($this->_axisY !== null)) {               
                        $this->_axisY->_setAxisPadding('high', $value['top']);
                    }
                    if ((isset($value['bottom'])) && ($this->_axisYSecondary !== null)) {
                        $this->_axisYSecondary->_setAxisPadding('low', $value['bottom']);
                    }
                    if ((isset($value['top'])) && ($this->_axisYSecondary !== null)) {               
                        $this->_axisYSecondary->_setAxisPadding('high', $value['top']);
                    }
                }
            } else {
                if ($this->_axisX !== null) {
                    $this->_axisX->_setAxisPadding('low', $value);
                    $this->_axisX->_setAxisPadding('high', $value);
                }
                if ($this->_axisY !== null) {
                    $this->_axisY->_setAxisPadding('low', $value);
                    $this->_axisY->_setAxisPadding('high', $value);
                }
                if ($this->_axisYSecondary !== null) {
                    $this->_axisYSecondary->_setAxisPadding('low', $value);
                    $this->_axisYSecondary->_setAxisPadding('high', $value);
                }
            }
        } else {
            switch ($position) {
            case 'left': 
                if ($this->_horizontal) {
                    if ($this->_axisY !== null) {
                        $this->_axisY->_setAxisPadding('low', $value);
                    }
                    if ($this->_axisYSecondary !== null) {
                        $this->_axisYSecondary->_setAxisPadding('low', $value);
                    }
                }
                else if ($this->_axisX !== null) {
                   $this->_axisX->_setAxisPadding('low', $value);
                }
                break;

            case 'right': 
                if ($this->_horizontal) {
                    if ($this->_axisY !== null) {
                        $this->_axisY->_setAxisPadding('high', $value);
                    }
                    if ($this->_axisYSecondary !== null) {
                        $this->_axisYSecondary->_setAxisPadding('high', $value);
                    }
                }
                else if ($this->_axisX !== null) {
                   $this->_axisX->_setAxisPadding('high', $value);
                }
                break;

            case 'top': 
                if (!$this->_horizontal) {
                    if ($this->_axisY !== null) {
                        $this->_axisY->_setAxisPadding('high', $value);
                    }
                    if ($this->_axisYSecondary !== null) {
                        $this->_axisYSecondary->_setAxisPadding('high', $value);
                    }
                }
                else if ($this->_axisX !== null) {
                   $this->_axisX->_setAxisPadding('high', $value);
                }               
                break;

            case 'bottom': 
                if (!$this->_horizontal) {
                    if ($this->_axisY !== null) {
                        $this->_axisY->_setAxisPadding('low', $value);
                    }
                    if ($this->_axisYSecondary !== null) {
                        $this->_axisYSecondary->_setAxisPadding('low', $value);
                    }
                }
                else if ($this->_axisX !== null) {
                   $this->_axisX->_setAxisPadding('low', $value);
                }
                break;
            }
        }
    }
    
    /**
     * Output the plotarea to the canvas
     *
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @access private
     */
    function _done()
    {
        if ($this->_hasData) {        
            $this->_canvas->startGroup(get_class($this));
        
            if ($this->_axisX != null) {
                $this->add($this->_axisX);
            }
            if ($this->_axisY != null) {
                $this->add($this->_axisY);
            }
            if ($this->_axisYSecondary != null) {
                $this->add($this->_axisYSecondary);
            }
    
            $this->_getFillStyle();
            $this->_canvas->rectangle(
            	array(
            		'x0' => $this->_plotLeft,
                	'y0' => $this->_plotTop,
                	'x1' => $this->_plotRight,
                	'y1' => $this->_plotBottom
                )
            );
            $result = parent::_done();
            $this->_canvas->endGroup();            
            return $result;
        } else {
            // no data -> do nothing at all!
            return true;
        }        
    }

}

?>