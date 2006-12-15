<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Image_Canvas
 *
 * Class for handling output as a HTML imagemap
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
 * @package    Image_Canvas
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: ImageMap.php,v 1.7 2006/02/13 20:53:20 nosey Exp $
 * @link       http://pear.php.net/pepr/pepr-proposal-show.php?id=212
 */

/**
 * Class for handling output as a HTML imagemap
 * 
 * @category   Images
 * @package    Image_Canvas
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: @package_version@
 * @link       http://pear.php.net/pepr/pepr-proposal-show.php?id=212
 * @since      version 0.2.0
 */
class Image_Canvas_ImageMap extends Image_Canvas
{
        
    /**
     * The image map (if any)
     * @var array
     * @access private
     */
    var $_map = array();
        
    /**
     * Add a map tag
     * @param string $shape The shape, either rect, circle or polygon
     * @param string $coords The list of coordinates for the shape
     * @param array $params Parameter array
     */
    function _addMapTag($shape, $coords, $params)
    {
        if (isset($params['url'])) {
            $url = $params['url'];
            $target = (isset($params['target']) ? $params['target'] : false);
            $alt = (isset($params['alt']) ? $params['alt'] : false);
            
            $tags = '';
            if (isset($params['htmltags'])) {
                foreach ($params['htmltags'] as $key => $value) {
                    $tags .= ' ';
                    if (strpos($value, '"') !== false) {
                        $tags .= $key . '=\'' . $value . '\'';
                    } else {
                        $tags .= $key . '="' . $value . '"';
                    }
                }
            }
            
            $this->_map[] = 
                '<area shape="' . $shape . '" coords="' . $coords . '" href="' . $url . '"' .
                    ($target ? ' target="' . $target . '"' : '') .
                    ($alt ? ' alt="' . $alt . '"' : '') .
                    (isset($params['id']) ? ' id="' . $params['id'] . '"' : '') .
                    $tags .
                    '>';
        }
    }    
    
    /**
     * Draw a line
     *
     * Parameter array:
     * 'x0': int X start point
     * 'y0': int Y start point
     * 'x1': int X end point
     * 'y1': int Y end point
     * 'color': mixed [optional] The line color
     * 'mapsize': int [optional] The size of the image map (surrounding the line)
     * @param array $params Parameter array
     */
    function line($params)
    {
        if (isset($params['url'])) {
            $mapsize = (isset($params['mapsize']) ? $params['mapsize'] : 2);
            $this->_addMapTag(
                'polygon', 
                $this->_getX($params['x0'] - $mapsize) . ',' . 
                $this->_getY($params['y0'] - $mapsize) . ',' .
                $this->_getX($params['x1'] + $mapsize) . ',' .
                $this->_getY($params['y1'] - $mapsize) . ',' .
                
                $this->_getX($params['x1'] + $mapsize) . ',' . 
                $this->_getY($params['y1'] + $mapsize) . ',' .
                $this->_getX($params['x0'] - $mapsize) . ',' .
                $this->_getY($params['y0'] + $mapsize),
                $params
            );
        }
        parent::line($params);
    }

    /**
     * Draws a polygon
     *
     * Parameter array:
     * 'connect': bool [optional] Specifies whether the start point should be
     *   connected to the endpoint (closed polygon) or not (connected line)
     * 'fill': mixed [optional] The fill color
     * 'line': mixed [optional] The line color
     * 'map_vertices': bool [optional] Specifies whether the image map should map the vertices instead of the polygon as a whole
     * 'url': string [optional] URL to link the polygon as a whole to (also used for default in case 'map_vertices' is used)
     * 'alt': string [optional] Alternative text to show in the image map (also used for default in case 'map_vertices' is used)
     * 'target': string [optional] The link target on the image map (also used for default in case 'map_vertices' is used)
     * @param array $params Parameter array
     */
    function polygon($params)
    {
        if ((isset($params['map_vertices'])) && ($params['map_vertices'] === true)) {
            $mapsize = (isset($params['mapsize']) ? $params['mapsize'] : 2);
            foreach ($this->_polygon as $point) {
                $vertex_param = $params;
                if (isset($point['url'])) {
                    $vertex_param['url'] = $point['url'];
                }
                if (isset($point['target'])) {
                    $vertex_param['target'] = $point['target'];
                }
                if (isset($point['alt'])) {
                    $vertex_param['alt'] = $point['alt'];
                }
                $vertex_mapsize = $mapsize;
                if (isset($point['mapsize'])) {
                    $vertex_mapsize = $point['mapsize'];
                }                            
                if (isset($point['htmltags'])) {
                    $vertex_param['htmltags'] = $point['htmltags'];
                }
                $this->_addMapTag(
                    'circle', 
                    $this->_getX($point['X']) . ',' . 
                    $this->_getY($point['Y']) . ',' .
                    $mapsize,
                    $vertex_param
                );
            }
        }
        else if (isset($params['url'])) {
            $points = '';
            foreach ($this->_polygon as $point) {
                if ($points != '') {
                    $points .= ',';
                }
                $points .= $this->_getX($point['X']) . ',' . $this->_getY($point['Y']);            
            }
            $this->_addMapTag('polygon', $points, $params);
        }
        parent::polygon($params);
    }

    /**
     * Draw a rectangle
     *
     * Parameter array:
     * 'x0': int X start point
     * 'y0': int Y start point
     * 'x1': int X end point
     * 'y1': int Y end point
     * 'fill': mixed [optional] The fill color
     * 'line': mixed [optional] The line color
     * @param array $params Parameter array
     */
    function rectangle($params)
    {
        if (isset($params['url'])) {
            $this->_addMapTag(
                'rect', 
                $this->_getX($params['x0']) . ',' . 
                $this->_getY($params['y0']) . ',' .
                $this->_getX($params['x1']) . ',' .
                $this->_getY($params['y1']),
                $params
            );
        }
        parent::rectangle($params);
    }

    /**
     * Draw an ellipse
     *
     * Parameter array:
     * 'x': int X center point
     * 'y': int Y center point
     * 'rx': int X radius
     * 'ry': int Y radius
     * 'fill': mixed [optional] The fill color
     * 'line': mixed [optional] The line color
     * @param array $params Parameter array
     */
    function ellipse($params)
    {
        if (isset($params['url'])) { 
            if ($params['rx'] == $params['ry']) {
                $this->_addMapTag(
                    'circle', 
                    $this->_getX($params['x']) . ',' . 
                    $this->_getY($params['y']) . ',' .
                    $this->_getX($params['rx']),
                    $params
                );
            } else {
                $points = '';
                for ($v = 0; $v <= 360; $v += 30) {
                    if ($points != '') {
                        $points .= ',';
                    }
                    $points .=
                        round($this->_getX($params['x']) + $this->_getX($params['rx']) * cos(deg2rad($v % 360))) . ',' .
                        round($this->_getY($params['y']) + $this->_getX($params['ry']) * sin(deg2rad($v % 360)));                        
                }
                $this->_addMapTag(
                    'polygon',
                    $points,
                    $params
                );
            }
        }
        parent::ellipse($params);
    }

    /**
     * Draw a pie slice
     *
     * Parameter array:
     * 'x': int X center point
     * 'y': int Y center point
     * 'rx': int X radius
     * 'ry': int Y radius
     * 'v1': int The starting angle (in degrees)
     * 'v2': int The end angle (in degrees)
     * 'srx': int [optional] Starting X-radius of the pie slice (i.e. for a doughnut)
     * 'sry': int [optional] Starting Y-radius of the pie slice (i.e. for a doughnut)
     * 'fill': mixed [optional] The fill color
     * 'line': mixed [optional] The line color
     * @param array $params Parameter array
     */
    function pieslice($params)
    {
        if (isset($params['url'])) { 
            $x = $this->_getX($params['x']);
            $y = $this->_getY($params['y']);
            $rx = $params['rx'];
            $ry = $params['ry'];
            $v1a = $params['v1'];
            $v2a = $params['v2'];
            $v1 = min($v1a, $v2a);
            $v2 = max($v1a, $v2a);
            $srx = (isset($params['srx']) ? $params['srx'] : 0);
            $sry = (isset($params['sry']) ? $params['sry'] : 0);
            
            $points = 
                round(($x + $srx * cos(deg2rad($v1 % 360)))) . ',' .
                round(($y + $sry * sin(deg2rad($v1 % 360)))) . ',';
                
            for ($v = $v1; $v < $v2; $v += 30) {
                $points .= 
                    round(($x + $rx * cos(deg2rad($v % 360)))) . ',' .
                    round(($y + $ry * sin(deg2rad($v % 360)))) . ',';                
            }
            
            $points .=
                round(($x + $rx * cos(deg2rad($v2 % 360)))) . ',' .
                round(($y + $ry * sin(deg2rad($v2 % 360))));
                
            if (($srx != 0) || ($sry != 0)) {
                $points .= ',';
                for ($v = $v2; $v > $v1; $v -= 30) {                    
                    $points .= 
                        round(($x + $srx * cos(deg2rad($v % 360)))) . ',' .
                        round(($y + $sry * sin(deg2rad($v % 360)))) . ',';                
                }

            }
                                                          
            $this->_addMapTag('polygon', $points, $params);
        }
        parent::pieslice($params);
    }

    /**
     * Output the result of the canvas to the browser
     *
     * @param array $params Parameter array, the contents and meaning depends on the actual Canvas
     * @abstract
     */
    function show($params = false)
    {
        parent::show($params);
        if (count($this->_map) > 0) {
             print $this->toHtml($params);
        }
    }

    /**
     * Save the result of the canvas to a file
     *
     * Parameter array:
     * 'filename': string The file to output to
     * @param array $params Parameter array, the contents and meaning depends on the actual Canvas
     * @abstract
     */
    function save($params = false)
    {
        parent::save($params);
        $file = fopen($param['filename'], 'w+');
        fwrite($file, $this->toHtml($params));        
        fclose($file);
    }
    
    /**
     * Get a canvas specific HTML tag.
     * 
     * Parameter array:
     * 'name': string The name of the image map
     */
    function toHtml($params)
    {
        if (count($this->_map) > 0) {
            return '<map name="' . $params['name'] . '">' . "\n\t" . implode($this->_map, "\n\t") . "\n</map>";
        }
        return ''; 
    }
}

?>