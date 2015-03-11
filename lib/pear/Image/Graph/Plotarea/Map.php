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
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * Include file Image/Graph/Plotarea.php
 */
require_once 'Image/Graph/Plotarea.php';

/**
 * Plot area used for map plots.
 *
 * A map plot is a chart that displays a map (fx. a world map) in the form of  .
 * png file. The maps must be located in the /Images/Maps folder and a
 * corresponding .txt files mush also exist in this location where named
 * locations are mapped to an (x, y) coordinate of the map picture (this text
 * file is tab separated with 'Name' 'X' 'Y' values, fx 'Denmark 378 223'). The
 * x-values in the dataset are then the named locations (fx 'Denmark') and the
 * y-values are then the data to plot. Currently the best (if not only) use is
 * to combine a map plot area with a {@link Image_Graph_Plot_Dot} using {@link
 * Image_Graph_Marker_PercentageCircle} as marker.
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
class Image_Graph_Plotarea_Map extends Image_Graph_Plotarea
{

    /**
     * The GD image for the map
     * @var string
     * @access private
     */
    var $_imageMap;

    /**
     * The value for scaling the width and height to fit into the layout boundaries
     * @var int
     * @access private
     */
    var $_scale;

    /**
     * The (x,y)-points for the named point
     * @var array
     * @access private
     */
    var $_mapPoints;

    /**
     * The original size of the image map
     * @var array
     * @access private
     */
    var $_mapSize;

    /**
     * PlotareaMap [Constructor]
     *
     * @param string $map The name of the map, i.e. the [name].png and  [name].
     *   txt files located in the Images/maps folder
     */
    function __construct($map)
    {
        parent::__construct();

        $this->_imageMap = dirname(__FILE__)."/../Images/Maps/$map.png";
        $points = file(dirname(__FILE__)."/../Images/Maps/$map.txt");
        list($width, $height) = getimagesize($this->_imageMap);
        $this->_mapSize['X'] = $width;
        $this->_mapSize['Y'] = $height;

        if (is_array($points)) {
            unset($this->_mapPoints);
            foreach ($points as $line) {
                list($country, $x, $y) = explode("\t", $line);
                $this->_mapPoints[$country] = array('X' => $x, 'Y' => $y);
            }
        }
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
     * Set the extrema of the axis
     *
     * @param Image_Graph_Plot $plot The plot that 'hold' the values
     * @access private
     */
    function _setExtrema(& $plot)
    {
    }

    /**
     * Get the X pixel position represented by a value
     *
     * @param double $value The value to get the pixel-point for
     * @return double The pixel position along the axis
     * @access private
     */
    function _pointX($value)
    {
        $country = $value['X'];
        return $this->_plotLeft+$this->_mapPoints[$country]['X']*$this->_scale;
    }

    /**
     * Get the Y pixel position represented by a value
     *
     * @param double $value The value to get the pixel-point for
     * @return double The pixel position along the axis
     * @access private
     */
    function _pointY($value)
    {
        $country = $value['X'];
        return $this->_plotTop+$this->_mapPoints[$country]['Y']*$this->_scale;
    }

    /**
     * Hides the axis
     */
    function hideAxis()
    {
    }

    /**
     * Add a point to the maps
     *
     * @param int $latitude The latitude of the point
     * @param int $longiude The longitude of the point
     * @param string $name The name of the plot
     */
    function addMappoint($latitude, $longitude, $name)
    {
        $x = (($longitude + 180) * ($this->_mapSize['X'] / 360));
        $y = ((($latitude * -1) + 90) * ($this->_mapSize['Y'] / 180));
        $this->_mapPoints[$name] = array('X' => $x, 'Y' => $y);
    }

    /**
     * Add a point to the maps
     *
     * @param int $x The latitude of the point
     * @param int $y The longitude of the point
     * @param string $name The name of the plot
     */
    function addPoint($x, $y, $name)
    {
        $this->_mapPoints[$name] = array('X' => $x, 'Y' => $y);
    }

    /**
     * Update coordinates
     *
     * @access private
     */
    function _updateCoords()
    {
        parent::_updateCoords();

        $mapAspectRatio = $this->_mapSize['X']/$this->_mapSize['Y'];
        $plotAspectRatio = ($width = $this->_fillWidth())/($height = $this->_fillHeight());

        $scaleFactorX = ($mapAspectRatio > $plotAspectRatio);

        if ((($this->_mapSize['X'] <= $width) && ($this->_mapSize['Y'] <= $height)) ||
            (($this->_mapSize['X'] >= $width) && ($this->_mapSize['Y'] >= $height)))
        {
            if ($scaleFactorX) {
                $this->_scale = $width / $this->_mapSize['X'];
            } else {
                $this->_scale = $height / $this->_mapSize['Y'];
            }
        } elseif ($this->_mapSize['X'] < $width) {
            $this->_scale = $height / $this->_mapSize['Y'];
        } elseif ($this->_mapSize['Y'] < $height) {
            $this->_scale = $width / $this->_mapSize['X'];
        }

        $this->_plotLeft = ($this->_fillLeft() + $this->_fillRight() -
            $this->_mapSize['X']*$this->_scale)/2;

        $this->_plotTop = ($this->_fillTop() + $this->_fillBottom() -
            $this->_mapSize['Y']*$this->_scale)/2;

        $this->_plotRight = ($this->_fillLeft() + $this->_fillRight() +
            $this->_mapSize['X']*$this->_scale)/2;

        $this->_plotBottom = ($this->_fillTop() + $this->_fillBottom() +
            $this->_mapSize['Y']*$this->_scale)/2;
    }

    /**
     * Output the plotarea to the canvas
     *
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @access private
     */
    function _done()
    {
        $this->_getFillStyle();
        $this->_canvas->rectangle(
        	array(
        		'x0' => $this->_fillLeft(),
            	'y0' => $this->_fillTop(),
            	'x1' => $this->_fillRight(),
            	'y1' => $this->_fillBottom()
            )
        );

        $scaledWidth = $this->_mapSize['X']*$this->_scale;
        $scaledHeight = $this->_mapSize['Y']*$this->_scale;

        $this->_canvas->image(
        	array(
            	'x' => $this->_plotLeft,
            	'y' => $this->_plotTop,
            	'filename' => $this->_imageMap,
            	'width' => $scaledWidth,
            	'height' => $scaledHeight
            )
        );

        return Image_Graph_Layout::_done();
    }

}

?>
