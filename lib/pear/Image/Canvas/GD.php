<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Image_Canvas
 *
 * Class for handling output in GD compatible format.
 * 
 * Supported formats are PNG, JPEG, GIF and WBMP.
 *
 * Requires PHP extension GD
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
 * @version    CVS: $Id$
 * @link       http://pear.php.net/pepr/pepr-proposal-show.php?id=212
 */

/**
 * Include file Image/Canvas.php
 */
require_once 'Image/Canvas/WithMap.php';

/**
 * Include file Image/Canvas/Color.php
 */
require_once 'Image/Canvas/Color.php';

/**
 * Canvas class to output using PHP GD support.
 * 
 * @category   Images
 * @package    Image_Canvas
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: @package_version@
 * @link       http://pear.php.net/pepr/pepr-proposal-show.php?id=212
 * @abstract
 */
class Image_Canvas_GD extends Image_Canvas_WithMap
{

    /**
     * The canvas of the graph
     * @var resource
     * @access private
     */
    var $_canvas;

    /**
     * The canvas to use for tiled filling
     * @var resource
     * @access private
     */
    var $_tileImage = null;

    /**
     * Is version GD2 installed?
     * @var bool
     * @access private
     */
    var $_gd2 = true;

    /**
     * Antialiasing?
     * 
     * Possible values 'off', 'driver' and 'native'
     * 
     * @var string
     * @access private
     */
    var $_antialias = 'off';
    
    var $_alpha = false;
        
    var $_clipping = array();

    /**
     * Create the GD canvas.
     *
     * Parameters available:
     *
     * 'width' The width of the graph on the canvas
     *
     * 'height' The height of the graph on the canvas
     *
     * 'left' The left offset of the graph on the canvas
     *
     * 'top' The top offset of the graph on the canvas
     * 
     * 'antialias' = 'native' enables native GD antialiasing - this
     * method has no severe impact on performance (approx +5%). Requires PHP
     * 4.3.2 (with bundled GD2)
     * 
     * 'antialias' = {true|'driver'} Image_Graph implemented method. This method
     * has a severe impact on performance, drawing an antialiased line this
     * way is about XX times slower, with an overall performance impact of
     * about +40%. The justification for this method is that if native support
     * is not available this can be used, it is also a future feature that this
     * method for antialiasing will support line styles.
     * 
     * Use antialiased for best results with a line/area chart having just a few
     * datapoints. Native antialiasing does not provide a good appearance with
     * short lines, as for example with smoothed charts. Antialiasing does not
     * (currently) work with linestyles, neither native nor driver method!
     * 
     * 'noalpha' = true If alpha blending is to be disabled
     *
     * 'filename' An image to open, on which the graph is created on
     *
     * 'gd' A GD resource to add the image to, use this option to continue
     * working on an already existing GD resource. Make sure this is passed 'by-
     * reference' (using &amp;)
     * 
     * 'usemap' Initialize an image map
     *
     * 'gd' and 'filename' are mutually exclusive with 'gd' as preference
     *
     * 'width' and 'height' are required unless 'filename' or 'gd' are
     * specified, in which case the width and height are taken as the actual
     * image width/height. If the latter is the case and 'left' and/or 'top' was
     * also specified, the actual 'width'/'height' are altered so that the graph
     * fits inside the canvas (i.e 'height' = actual height - top, etc.)
     *
     * @param array $param Parameter array
     */
    function Image_Canvas_GD($param)
    {
        include_once 'Image/Canvas/Color.php';

        parent::Image_Canvas_WithMap($param);
        
        $this->_gd2 = ($this->_version() == 2);
        $this->_font = array('font' => 1, 'color' => 'black');

        if ((isset($param['gd'])) && (is_resource($param['gd']))) {
            $this->_canvas =& $param['gd'];
        } elseif (isset($param['filename'])) {
            $this->_canvas =& $this->_getGD($param['filename']);
        } else {
            if ($this->_gd2) {
                $this->_canvas = ImageCreateTrueColor(
                    $this->_width,
                    $this->_height
                );
                if ((!isset($param['noalpha'])) || ($param['noalpha'] !== true)) {
                    ImageAlphaBlending($this->_canvas, true);
                    $this->_alpha = true;
                }
            } else {
                $this->_canvas = ImageCreate($this->_width, $this->_height);
            }
        }
        
        if (isset($param['antialias'])) {
            $this->_antialias = $param['antialias'];
        }
        
        if ($this->_antialias === true) {
            $this->_antialias = 'driver';
        }
        
        if (($this->_gd2) && ($this->_antialias === 'native')) {
            ImageAntialias($this->_canvas, true);
        }
    }

    /**
     * Get an GD image resource from a file
     *
     * @param string $filename
     * @return mixed The GD image resource
     * @access private
     */
    function &_getGD($filename)
    {
        $info = getimagesize($filename);
        
        $result = null;
        switch($info[2]) {
        case IMG_PNG:
            $result =& ImageCreateFromPNG($filename);
            break;
            
        case IMG_JPG:
            $result =& ImageCreateFromJPEG($filename);
            break;
            
        case IMG_GIF:
            $result =& ImageCreateFromGIF($filename);
            break;
        }
        return $result;
    }

    /**
     * Get the color index for the RGB color
     *
     * @param int $color The color
     * @return int The GD image index of the color
     * @access private
     */
    function _color($color = false)
    {
        if (($color === false) || ($color === 'opague') || ($color === 'transparent')) {
            return ImageColorTransparent($this->_canvas);
        } else {
            return Image_Canvas_Color::allocateColor($this->_canvas, $color);
        }
    }

    /**
     * Get the GD applicable linestyle
     *
     * @param mixed $lineStyle The line style to return, false if the one
     *   explicitly set
     * @return mixed A GD compatible linestyle
     * @access private
     */
    function _getLineStyle($lineStyle = false)
    {
        if ($this->_gd2) {
            ImageSetThickness($this->_canvas, $this->_thickness);
        }

        if ($lineStyle == 'transparent') {
            return false;
        } elseif ($lineStyle === false) {
            if (is_array($this->_lineStyle)) {
                $colors = array();
                foreach ($this->_lineStyle as $color) {
                    if ($color === 'transparent') {
                        $color = false;
                    }
                    $colors[] = $this->_color($color);
                }
                ImageSetStyle($this->_canvas, $colors);
                return IMG_COLOR_STYLED;
            } else {
                return $this->_color($this->_lineStyle);
            }
        } else {
            return $this->_color($lineStyle);
        }
    }

    /**
     * Get the GD applicable fillstyle
     *
     * @param mixed $fillStyle The fillstyle to return, false if the one
     *   explicitly set
     * @return mixed A GD compatible fillstyle
     * @access private
     */
    function _getFillStyle($fillStyle = false, $x0 = 0, $y0 = 0, $x1 = 0, $y1 = 0)
    {
        if ($this->_tileImage != null) {
            ImageDestroy($this->_tileImage);
            $this->_tileImage = null;
        }
        if ($fillStyle == 'transparent') {
            return false;
        } elseif ($fillStyle === false) {
            if (is_resource($this->_fillStyle)) {
                $x = min($x0, $x1);
                $y = min($y0, $y1);
                $w = abs($x1 - $x0) + 1;
                $h = abs($y1 - $y0) + 1;
                if ($this->_gd2) {
                    $this->_tileImage = ImageCreateTrueColor(
                        $this->getWidth(),
                        $this->getHeight()
                    );

                    ImageCopyResampled(
                        $this->_tileImage,
                        $this->_fillStyle,
                        $x,
                        $y,
                        0,
                        0,
                        $w,
                        $h,
                        ImageSX($this->_fillStyle),
                        ImageSY($this->_fillStyle)
                    );
                } else {
                    $this->_tileImage = ImageCreate(
                        $this->getWidth(),
                        $this->getHeight()
                    );

                    ImageCopyResized(
                        $this->_tileImage,
                        $this->_fillStyle,
                        $x,
                        $y,
                        0,
                        0,
                        $w,
                        $h,
                        ImageSX($this->_fillStyle),
                        ImageSY($this->_fillStyle)
                    );
                }
                ImageSetTile($this->_canvas, $this->_tileImage);
                return IMG_COLOR_TILED;
            } elseif ((is_array($this->_fillStyle)) && (isset($this->_fillStyle['direction']))) {
                $width = abs($x1 - $x0) + 1;
                $height = abs($y1 - $y0) + 1;

                switch ($this->_fillStyle['direction']) {
                case 'horizontal':
                    $count = $width;
                    break;

                case 'vertical':
                    $count = $height;
                    break;

                case 'horizontal_mirror':
                    $count = $width / 2;
                    break;

                case 'vertical_mirror':
                    $count = $height / 2;
                    break;

                case 'diagonal_tl_br':
                case 'diagonal_bl_tr':
                    $count = sqrt($width * $width + $height * $height);
                    break;

                case 'radial':
                    $count = max($width, $height, sqrt($width * $width + $height * $height)) + 1;
                    break;

                }

                $count = round($count);

                if ($this->_gd2) {
                    $this->_tileImage = ImageCreateTrueColor(
                        $this->getWidth(),
                        $this->getHeight()
                    );
                } else {
                    $this->_tileImage = ImageCreate(
                        $this->getWidth(),
                        $this->getHeight()
                    );
                }


                $startColor = Image_Canvas_Color::color2RGB(
                    ($this->_fillStyle['direction'] == 'radial' ?
                        $this->_fillStyle['end'] :
                        $this->_fillStyle['start']
                    )
                );
                $endColor = Image_Canvas_Color::color2RGB(
                    ($this->_fillStyle['direction'] == 'radial' ?
                        $this->_fillStyle['start'] :
                        $this->_fillStyle['end']
                    )
                );

                $redIncrement = ($endColor[0] - $startColor[0]) / $count;
                $greenIncrement = ($endColor[1] - $startColor[1]) / $count;
                $blueIncrement = ($endColor[2] - $startColor[2]) / $count;

                $color = false;
                for ($i = 0; $i < $count; $i ++) {
                    unset($color);
                    if ($i == 0) {
                        $color = $startColor;
                        unset($color[3]);
                    } else {
                        $color[0] = round(($redIncrement * $i) +
                            $redIncrement + $startColor[0]);
                        $color[1] = round(($greenIncrement * $i) +
                            $greenIncrement + $startColor[1]);
                        $color[2] = round(($blueIncrement * $i) +
                            $blueIncrement + $startColor[2]);
                    }
                    $color = Image_Canvas_Color::allocateColor(
                        $this->_tileImage,
                        $color
                    );

                    switch ($this->_fillStyle['direction']) {
                    case 'horizontal':
                        ImageLine($this->_tileImage,
                            $x0 + $i,
                            $y0,
                            $x0 + $i,
                            $y1, $color);
                        break;

                    case 'vertical':
                        ImageLine($this->_tileImage,
                            $x0,
                            $y1 - $i,
                            $x1,
                            $y1 - $i, $color);
                        break;

                    case 'horizontal_mirror':
                        if (($x0 + $i) <= ($x1 - $i)) {
                            ImageLine($this->_tileImage,
                                $x0 + $i,
                                $y0,
                                $x0 + $i,
                                $y1, $color);

                            ImageLine($this->_tileImage,
                                $x1 - $i,
                                $y0,
                                $x1 - $i,
                                $y1, $color);
                        }
                        break;

                    case 'vertical_mirror':
                        if (($y0 + $i) <= ($y1 - $i)) {
                            ImageLine($this->_tileImage,
                                $x0,
                                $y0 + $i,
                                $x1,
                                $y0 + $i, $color);
                            ImageLine($this->_tileImage,
                                $x0,
                                $y1 - $i,
                                $x1,
                                $y1 - $i, $color);
                        }
                        break;

                    case 'diagonal_tl_br':
                        if (($i > $width) && ($i > $height)) {
                            $polygon = array (
                                $x1, $y0 + $i - $width - 1,
                                $x1, $y1,
                                $x0 + $i - $height - 1, $y1);
                        } elseif ($i > $width) {
                            $polygon = array (
                                $x0, $y0 + $i,
                                $x0, $y1,
                                $x1, $y1,
                                $x1, $y0 + $i - $width - 1);
                        } elseif ($i > $height) {
                            $polygon = array (
                                $x0 + $i - $height - 1, $y1,
                                $x1, $y1,
                                $x1, $y0,
                                $x0 + $i, $y0);
                        } else {
                            $polygon = array (
                                $x0, $y0 + $i,
                                $x0, $y1,
                                $x1, $y1,
                                $x1, $y0,
                                $x0 + $i, $y0);
                        }
                        ImageFilledPolygon(
                            $this->_tileImage,
                            $polygon,
                            count($polygon) / 2,
                            $color
                        );
                        break;

                    case 'diagonal_bl_tr':
                        if (($i > $width) && ($i > $height)) {
                            $polygon = array (
                                $x1, $y1 - $i + $width - 1,
                                $x1, $y0,
                                $x0 + $i - $height - 1, $y0);
                        } elseif ($i > $width) {
                            $polygon = array (
                                $x0, $y1 - $i,
                                $x0, $y0,
                                $x1, $y0,
                                $x1, $y1 - $i + $width - 1);
                        } elseif ($i > $height) {
                            $polygon = array (
                                $x0 + $i - $height - 1, $y0,
                                $x1, $y0,
                                $x1, $y1,
                                $x0 + $i, $y1);
                        } else {
                            $polygon = array (
                                $x0, $y1 - $i,
                                $x0, $y0,
                                $x1, $y0,
                                $x1, $y1,
                                $x0 + $i, $y1);
                        }
                        ImageFilledPolygon(
                            $this->_tileImage,
                            $polygon,
                            count($polygon) / 2,
                            $color
                        );
                        break;

                    case 'radial':
                        if (($this->_gd2) && ($i < $count)) {
                            ImageFilledEllipse(
                                $this->_tileImage,
                                $x0 + $width / 2,
                                $y0 + $height / 2,
                                $count - $i,
                                $count - $i,
                                $color
                            );
                        }
                        break;
                    }
                }
                ImageSetTile($this->_canvas, $this->_tileImage);
                return IMG_COLOR_TILED;
            } else {
                return $this->_color($this->_fillStyle);
            }
        } else {
            return $this->_color($fillStyle);
        }
    }

    /**
     * Sets an image that should be used for filling
     *
     * @param string $filename The filename of the image to fill with
     */
    function setFillImage($filename)
    {
        $this->_fillStyle =& $this->_getGD($filename);
    }

    /**
     * Sets the font options.
     *
     * The $font array may have the following entries:
     *
     * 'ttf' = the .ttf file (either the basename, filename or full path)
     * If 'ttf' is specified, then the following can be specified
     *
     * 'size' = size in pixels
     *
     * 'angle' = the angle with which to write the text
     *
     * @param array $font The font options.
     */
    function setFont($fontOptions)
    {
        parent::setFont($fontOptions);

        if (isset($this->_font['ttf'])) {
            $this->_font['file'] = str_replace('\\', '/', Image_Canvas_Tool::fontMap($this->_font['ttf']));
        } elseif (!isset($this->_font['font'])) {
            $this->_font['font'] = 1;
        }

        if (!isset($this->_font['color'])) {
            $this->_font['color'] = 'black';
        }

        if ((isset($this->_font['angle'])) && ($this->_font['angle'] === false)) {
            $this->_font['angle'] = 0;
        }
    }

    /**
     * Calculate pixels on a line
     *
     * @param int $x0 X start point
     * @param int $y0 X start point
     * @param int $x1 X end point
     * @param int $y1 Y end point
     * @return array An associated array of x,y points with all pixels on the
     * line    
     * @access private
     */
    function &_linePixels($x0, $y0, $x1, $y1)
    {
        $pixels = array();
        if (abs($x0 - $x1) > abs($y0 - $y1)) {
            if ($x1 != $x0) {
                $m = ($y1 - $y0) / ($x1 - $x0);
            } else {
                $m = 0;
            }  
            $b = $y0 - $m * $x0;
            $strx = min($x0, $x1);
            $endx = max($x0, $x1);
            for ($x = $strx; $x <= $endx; $x++) {
                $pixels[] = array('X' => $x, 'Y' => ($m * $x + $b));                
            }
        } else {
            if ($y1 != $y0) {
                $m = ($x1 - $x0) / ($y1 - $y0);
            } else {
                $m = 0;
            }
            $b = $x0 - $m * $y0;
            $stry = min($y0, $y1);
            $endy = max($y0, $y1);
            for ($y = $stry; $y <= $endy; $y++) {
                $pixels[] = array('X' => ($m * $y + $b), 'Y' => $y);                
            }
        }
        return $pixels;
    }

    /**
     * Draws an antialiased line
     *
     * @param int $x0 X start point
     * @param int $y0 X start point
     * @param int $x1 X end point
     * @param int $y1 Y end point
     * @param mixed $color The line color, can be omitted
     * @access private
     */
    function _antialiasedLine($x0, $y0, $x1, $y1, $color = false)
    {
        if (($line = $this->_getLineStyle($color)) !== false) {
            if ($line >= 0) {
                $line = ImageColorsForIndex($this->_canvas, $line);
                $pixels = &$this->_linePixels($x0, $y0, $x1, $y1);
                foreach ($pixels as $point) {
                    $this->_antialiasedPixel($point['X'], $point['Y'], $line);
                }
                unset($pixels);
            }
        }
    }


    /**
     * Draws an antialiased pixel
     *
     * @param int $x X point
     * @param int $y Y point
     * @param mixed $color The pixel color
     * @access private
     */
    function _antialiasedPixel($x, $y, $color)
    {
        $fx = floor($x);
        $fy = floor($y);
        $cx = ceil($x);
        $cy = ceil($y);
        $xa = $x - $fx;
        $xb = $cx - $x;
        $ya = $y - $fy;
        $yb = $cy - $y;
        if (($cx == $fx) && ($cy == $fy)) {
            $this->_antialisedSubPixel($fx, $fy, 0.0, 1.0, $color);
        } else {
            $this->_antialisedSubPixel($fx, $fy, $xa + $ya, $xb + $yb, $color);
            if ($cy != $fy) {
                $this->_antialisedSubPixel($fx, $cy, $xa + $yb, $xb + $ya, $color);
            }
            if ($cx != $fx) {
                $this->_antialisedSubPixel($cx, $fy, $xb + $ya, $xa + $yb, $color);
                if ($cy != $fy) {
                    $this->_antialisedSubPixel($cx, $cy, $xb + $yb, $xa + $ya, $color);
                }
            }
        }
    }

    /**
     * Antialias'es the pixel around x,y with weights a,b
     *
     * @param int $x X point
     * @param int $y Y point
     * @param int $a The weight of the current color
     * @param int $b The weight of the applied/wanted color
     * @param mixed $color The pixel color
     * @access private
     */
    function _antialisedSubPixel($x, $y, $a, $b, $color)
    {
        $x = $this->_getX($x);
        $y = $this->_getX($y);
        if (($x >=0 ) && ($y >= 0) && ($x < $this->getWidth()) && ($y < $this->getHeight())) {
            $tempColor = ImageColorsForIndex($this->_canvas, ImageColorAt($this->_canvas, $x, $y));                
            
            $newColor[0] = min(255, round($tempColor['red'] * $a + $color['red'] * $b));        
            $newColor[1] = min(255, round($tempColor['green'] * $a + $color['green'] * $b));        
            $newColor[2] = min(255, round($tempColor['blue'] * $a + $color['blue'] * $b));
            //$newColor[3] = 0;
            $color = '#';
            foreach ($newColor as $acolor) {
                $color .= sprintf('%02s', dechex($acolor));
            }
            $newColor = $this->_color($color);//,'rgb(' . $newColor[0] . ',' . $newColor[1] . ','  . $newColor[2] .')';        
    
            ImageSetPixel($this->_canvas, $x, $y, $newColor);
        }
    }
    
    
    /**
     * Draw a line end
     *
     * Parameter array:
     * 
     * 'x': int X point
     * 
     * 'y': int Y point
     * 
     * 'end': string The end type of the end
     * 
     * 'size': int The size of the end
     * 
     * 'color': string The color of the end
     * 
     * 'angle': int [optional] The angle with which to draw the end
     * 
     * @param array $params Parameter array
     */
    function drawEnd($params) 
    {        
        $x = $this->_getX($params['x']);
        $y = $this->_getY($params['y']);
        $size = $params['size'];
        //var_dump($params);
        $angle = deg2rad((isset($params['angle']) ? $params['angle'] : 0));
        $pi2 = pi() / 2;
        switch ($params['end']) {
        case 'lollipop':
        case 'circle':
            $this->ellipse(
                array(
                    'x' => $x,
                    'y' => $y,
                    'rx' => $size / 2,
                    'ry' => $size / 2,
                    'fill' => $params['color'],
                    'line' => $params['color']                    
                )
            );
            break;
        case 'diamond':
            $x0 = round($params['x'] + cos($angle) * $size * 0.65);
            $y0 = round($params['y'] - sin($angle) * $size * 0.65);
            $shape = array(
                $x0 + round(cos($angle) * $size * 0.65),
                $y0 - round(sin($angle) * $size * 0.65),
                $x0 + round(cos($angle + $pi2) * $size * 0.65),
                $y0 - round(sin($angle + $pi2) * $size * 0.65),
                $x0 + round(cos($angle + pi()) * $size * 0.65),
                $y0 - round(sin($angle + pi()) * $size * 0.65),
                $x0 + round(cos($angle + 3 * $pi2) * $size * 0.65),
                $y0 - round(sin($angle + 3 * $pi2) * $size * 0.65)
            );
            break;
        case 'line':
            $this->line(
                array(
                    'x0' => $x + round(cos($angle + $pi2) * $size / 2),
                    'y0' => $y - round(sin($angle + $pi2) * $size / 2),
                    'x1' => $x + round(cos($angle + 3 * $pi2) * $size / 2),
                    'y1' => $y - round(sin($angle + 3 * $pi2) * $size / 2),
                    'color' => $params['color']
                )
            );
            break;
        case 'box':
        case 'rectangle':
            $x0 = round($params['x'] + cos($angle) * $size / 2);
            $y0 = round($params['y'] - sin($angle) * $size / 2);
            $pi4 = pi() / 4;            
            $shape = array(
                $x0 + round(cos($angle + $pi4) * $size / 2),
                $y0 - round(sin($angle + $pi4) * $size / 2),
                $x0 + round(cos($angle + $pi2 + $pi4) * $size / 2),
                $y0 - round(sin($angle + $pi2 + $pi4) * $size / 2),
                $x0 + round(cos($angle + pi() + $pi4) * $size / 2),
                $y0 - round(sin($angle + pi() + $pi4) * $size / 2),
                $x0 + round(cos($angle + 3 * $pi2 + $pi4) * $size / 2),
                $y0 - round(sin($angle + 3 * $pi2 + $pi4) * $size / 2)
            );
            break;
        case 'arrow':  
            $shape = array(
                $x + cos($angle) * $size,
                $y - sin($angle) * $size,
                $x + cos($angle + $pi2) * $size * 0.4,
                $y - sin($angle + $pi2) * $size * 0.4,
                $x + cos($angle + 3 * $pi2) * $size * 0.4,
                $y - sin($angle + 3 * $pi2) * $size * 0.4,                
            );
            break;
        case 'arrow2':  
            $shape = array(
                $x + round(cos($angle) * $size),
                $y - round(sin($angle) * $size),
                $x + round(cos($angle + $pi2 + deg2rad(45)) * $size),
                $y - round(sin($angle + $pi2 + deg2rad(45)) * $size),
                $x,
                $y,
                $x + round(cos($angle + 3 * $pi2 - deg2rad(45)) * $size),
                $y - round(sin($angle + 3 * $pi2 - deg2rad(45)) * $size),                
            );
            break;
        }
        
        if (isset($shape)) {
            // output the shape
            if (($fill = $this->_getFillStyle($params['color'])) !== false && count($shape) >= 6) {
                ImageFilledPolygon($this->_canvas, $shape, count($shape)/2, $fill);
            }
        }
        parent::drawEnd($params);
    }    
    
    /**
     * Draw a line
     *
     * Parameter array:
     * 
     * 'x0': int X start point
     * 
     * 'y0': int Y start point
     * 
     * 'x1': int X end point
     * 
     * 'y1': int Y end point
     * 
     * 'color': mixed [optional] The line color
     * 
     * @param array $params Parameter array
     */
    function line($params)
    {
        $x0 = $this->_getX($params['x0']);
        $y0 = $this->_getY($params['y0']);
        $x1 = $this->_getX($params['x1']);
        $y1 = $this->_getY($params['y1']);
        $color = (isset($params['color']) ? $params['color'] : false);
        
        $x0 = $this->_getX($x0);
        $y0 = $this->_getY($y0);
        $x1 = $this->_getX($x1);
        $y1 = $this->_getY($y1);
        if (($this->_antialias === 'driver') && ($x0 != $x1) && ($y0 != $y1)) {
            $this->_antialiasedLine($x0, $y0, $x1, $y1, $color);
        } elseif (($line = $this->_getLineStyle($color)) !== false) {            
            ImageLine($this->_canvas, $x0, $y0, $x1, $y1, $line);
        }
        parent::line($params);
    }

    /**
     * Parameter array:
     * 
     * 'connect': bool [optional] Specifies whether the start point should be
     * connected  to the endpoint (closed polygon) or not (connected line)
     * 
     * 'fill': mixed [optional] The fill color
     * 
     * 'line': mixed [optional] The line color
     * @param array $params Parameter array
     */
    function polygon($params)
    {
        include_once 'Image/Canvas/Tool.php';

        $connectEnds = (isset($params['connect']) ? $params['connect'] : false);
        $fillColor = (isset($params['fill']) ? $params['fill'] : false);
        $lineColor = (isset($params['line']) ? $params['line'] : false);

        if (!$connectEnds) {
            $fillColor = 'transparent';
        }
        $style = $this->_getLineStyle($lineColor) . $this->_getFillStyle($fillColor);

        $lastPoint = false;
        foreach ($this->_polygon as $point) {
            if (($lastPoint) && (isset($lastPoint['P1X'])) &&
                (isset($lastPoint['P1Y'])) && (isset($lastPoint['P2X'])) &&
                (isset($lastPoint['P2Y'])))
            {
                $dx = abs($point['X'] - $lastPoint['X']);
                $dy = abs($point['Y'] - $lastPoint['Y']);
                $d = sqrt($dx * $dx + $dy * $dy);
                if ($d > 0) {
                    $interval = 1 / $d;
                    for ($t = 0; $t <= 1; $t = $t + $interval) {
                        $x = Image_Canvas_Tool::bezier(
                            $t,
                            $lastPoint['X'],
                            $lastPoint['P1X'],
                            $lastPoint['P2X'],
                            $point['X']
                        );
    
                        $y = Image_Canvas_Tool::bezier(
                            $t,
                            $lastPoint['Y'],
                            $lastPoint['P1Y'],
                            $lastPoint['P2Y'],
                            $point['Y']
                        );
    
                        if (!isset($low['X'])) {
                            $low['X'] = $x;
                        } else {
                            $low['X'] = min($x, $low['X']);
                        }
                        if (!isset($high['X'])) {
                            $high['X'] = $x;
                        } else {
                            $high['X'] = max($x, $high['X']);
                        }
                        if (!isset($low['Y'])) {
                            $low['Y'] = $y;
                        } else {
                            $low['Y'] = min($y, $low['Y']);
                        }
                        if (!isset($high['Y'])) {
                            $high['Y'] = $y;
                        } else {
                            $high['Y'] = max($y, $high['Y']);
                        }
                        $polygon[] = $x;
                        $polygon[] = $y;
                    }
                    if (($t - $interval) < 1) {
                        $x = Image_Canvas_Tool::bezier(
                            1,
                            $lastPoint['X'],
                            $lastPoint['P1X'],
                            $lastPoint['P2X'],
                            $point['X']
                        );
    
                        $y = Image_Canvas_Tool::bezier(
                            1,
                            $lastPoint['Y'],
                            $lastPoint['P1Y'],
                            $lastPoint['P2Y'],
                            $point['Y']
                        );
    
                        $polygon[] = $x;
                        $polygon[] = $y;
                    }
                }
            } else {
                if (!isset($low['X'])) {
                    $low['X'] = $point['X'];
                } else {
                    $low['X'] = min($point['X'], $low['X']);
                }
                if (!isset($high['X'])) {
                    $high['X'] = $point['X'];
                } else {
                    $high['X'] = max($point['X'], $high['X']);
                }
                if (!isset($low['Y'])) {
                    $low['Y'] = $point['Y'];
                } else {
                    $low['Y'] = min($point['Y'], $low['Y']);
                }
                if (!isset($high['Y'])) {
                    $high['Y'] = $point['Y'];
                } else {
                    $high['Y'] = max($point['Y'], $high['Y']);
                }

                $polygon[] = $point['X'];
                $polygon[] = $point['Y'];
            }
            $lastPoint = $point;
        }

        if ((isset($polygon)) && (is_array($polygon))) {
            if ($connectEnds) {
                if (($fill = $this->_getFillStyle($fillColor, $low['X'], $low['Y'], $high['X'], $high['Y'])) !== false && count($polygon) >= 6) {
                    ImageFilledPolygon($this->_canvas, $polygon, count($polygon)/2, $fill);
                }
                if ($this->_antialias === 'driver') {
                    $pfirst = $p0 = false; 
                    reset($polygon);
                    
                    while (list(, $x) = each($polygon)) {
                        list(, $y) = each($polygon);
                        if ($p0 !== false) {
                            $this->_antialiasedLine($p0['X'], $p0['Y'], $x, $y, $lineColor);
                        }
                        if ($pfirst === false) {
                            $pfirst = array('X' => $x, 'Y' => $y);
                        }                        
                        $p0 = array('X' => $x, 'Y' => $y);;
                    }
                    
                    $this->_antialiasedLine($p0['X'], $p0['Y'], $pfirst['X'], $pfirst['Y'], $lineColor);
                } elseif (($line = $this->_getLineStyle($lineColor)) !== false && count($polygon) >= 6) {
                    ImagePolygon($this->_canvas, $polygon, count($polygon)/2, $line);
                }
            } else {
                $prev_point = false;
                if ($this->_antialias === 'driver') {
                    reset($polygon);
                    while (list(, $x) = each($polygon)) {
                        list(, $y) = each($polygon);
                        if ($prev_point) {
                            $this->_antialiasedLine(
                                $prev_point['X'],
                                $prev_point['Y'],
                                $x,
                                $y,
                                $lineColor
                            );                            
                        }
                        $prev_point = array('X' => $x, 'Y' => $y);;
                    }
                } elseif (($line = $this->_getLineStyle($lineColor)) !== false) {
                    reset($polygon);
                    while (list(, $x) = each($polygon)) {
                        list(, $y) = each($polygon);
                        if ($prev_point) {
                            ImageLine(
                                $this->_canvas,
                                $prev_point['X'],
                                $prev_point['Y'],
                                $x,
                                $y,
                                $line
                            );
                        }
                        $prev_point = array('X' => $x, 'Y' => $y);;
                    }
                }
            }
        }

        parent::polygon($params);
    }

    /**
     * Draw a rectangle
     *
     * Parameter array:
     * 
     * 'x0': int X start point
     * 
     * 'y0': int Y start point
     * 
     * 'x1': int X end point
     * 
     * 'y1': int Y end point
     * 
     * 'fill': mixed [optional] The fill color
     * 
     * 'line': mixed [optional] The line color
     * 
     * @param array $params Parameter array
     */
    function rectangle($params)
    {
        $x0 = $this->_getX($params['x0']);
        $y0 = $this->_getY($params['y0']);
        $x1 = $this->_getX($params['x1']);
        $y1 = $this->_getY($params['y1']);
        $fillColor = (isset($params['fill']) ? $params['fill'] : false);
        $lineColor = (isset($params['line']) ? $params['line'] : false);

        if (($fill = $this->_getFillStyle($fillColor, $x0, $y0, $x1, $y1)) !== false) {
            ImageFilledRectangle($this->_canvas, $x0, $y0, $x1, $y1, $fill);
        }

        if (($line = $this->_getLineStyle($lineColor)) !== false) {
            ImageRectangle($this->_canvas, $x0, $y0, $x1, $y1, $line);
        }

        parent::rectangle($params);
    }

    /**
     * Draw an ellipse
     *
     * Parameter array:
     * 
     * 'x': int X center point
     * 
     * 'y': int Y center point
     * 
     * 'rx': int X radius
     * 
     * 'ry': int Y radius
     * 
     * 'fill': mixed [optional] The fill color
     * 
     * 'line': mixed [optional] The line color
     * 
     * @param array $params Parameter array
     */
    function ellipse($params)
    {
        $x = $this->_getX($params['x']);
        $y = $this->_getY($params['y']);
        $rx = $this->_getX($params['rx']);
        $ry = $this->_getY($params['ry']);
        $fillColor = (isset($params['fill']) ? $params['fill'] : false);
        $lineColor = (isset($params['line']) ? $params['line'] : false);

        if (($fill = $this->_getFillStyle($fillColor, $x - $rx, $y - $ry, $x + $rx, $y + $ry)) !== false) {
            ImageFilledEllipse($this->_canvas, $x, $y, $rx * 2, $ry * 2, $fill);
        }

        if (($line = $this->_getLineStyle($lineColor)) !== false) {
            ImageEllipse($this->_canvas, $x, $y, $rx * 2, $ry * 2, $line);
        }
        parent::ellipse($params);
    }

    /**
     * Draw a pie slice
     *
     * Parameter array:
     * 
     * 'x': int X center point
     * 
     * 'y': int Y center point
     * 
     * 'rx': int X radius
     * 
     * 'ry': int Y radius
     * 
     * 'v1': int The starting angle (in degrees)
     * 
     * 'v2': int The end angle (in degrees)
     * 
     * 'srx': int [optional] Starting X-radius of the pie slice (i.e. for a doughnut)
     * 
     * 'sry': int [optional] Starting Y-radius of the pie slice (i.e. for a doughnut)
     * 
     * 'fill': mixed [optional] The fill color
     * 
     * 'line': mixed [optional] The line color
     * 
     * @param array $params Parameter array
     */
    function pieslice($params)
    {
        $x = $this->_getX($params['x']);
        $y = $this->_getY($params['y']);
        $rx = $params['rx'];
        $ry = $params['ry'];
        $v1 = $params['v1'];
        $v2 = $params['v2'];
        $srx = (isset($params['srx']) ? $params['srx'] : 0);
        $sry = (isset($params['sry']) ? $params['sry'] : 0);
        $fillColor = (isset($params['fill']) ? $params['fill'] : false);
        $lineColor = (isset($params['line']) ? $params['line'] : false);

        $dA = 0.1;

        if (($srx !== false) && ($sry !== false)) {
            $angle = max($v1, $v2);
            while ($angle >= min($v1, $v2)) {
                $polygon[] = ($x + $srx * cos(deg2rad($angle % 360)));
                $polygon[] = ($y + $sry * sin(deg2rad($angle % 360)));
                $angle -= $dA;
            }
            if (($angle + $dA) > min($v1, $v2)) {
                $polygon[] = ($x + $srx * cos(deg2rad(min($v1, $v2) % 360)));
                $polygon[] = ($y + $sry * sin(deg2rad(min($v1, $v2) % 360)));
            }
        } else {
            $polygon[] = $x;
            $polygon[] = $y;
        }

        $angle = min($v1, $v2);
        while ($angle <= max($v1, $v2)) {
            $polygon[] = ($x + $rx * cos(deg2rad($angle % 360)));
            $polygon[] = ($y + $ry * sin(deg2rad($angle % 360)));
            $angle += $dA;
        }

        if (($angle - $dA) < max($v1, $v2)) {
            $polygon[] = ($x + $rx * cos(deg2rad(max($v1, $v2) % 360)));
            $polygon[] = ($y + $ry * sin(deg2rad(max($v1, $v2) % 360)));
        }

        if (($fill = $this->_getFillStyle($fillColor, $x - $rx - 1, $y - $ry - 1, $x + $rx + 1, $y + $ry + 1)) !== false && count($polygon) >= 6) {
            ImageFilledPolygon($this->_canvas, $polygon, count($polygon) / 2, $fill);
        }

        if (($line = $this->_getLineStyle($lineColor)) !== false && count($polygon) >= 6) {
            ImagePolygon($this->_canvas, $polygon, count($polygon) / 2, $line);
        }

        parent::pieSlice($params);
    }

    /**
     * Get the width of a text,
     *
     * @param string $text The text to get the width of
     * @return int The width of the text
     */
    function textWidth($text)
    {
        if (isset($this->_font['file'])) {
            $angle = 0;
            if (isset($this->_font['angle'])) {
                $angle = $this->_font['angle'];
            }
            
            $width = 0;
            $lines = explode("\n", $text);
            foreach ($lines as $line) {
                $bounds = ImageTTFBBox(
                    $this->_font['size'],
                    $angle,
                    $this->_font['file'],
                    $text
                );
    
                $x0 = min($bounds[0], $bounds[2], $bounds[4], $bounds[6]);
                $x1 = max($bounds[0], $bounds[2], $bounds[4], $bounds[6]);
                $width = max(abs($x0 - $x1), $width);
            }
            return $width;
        } else {
            if ((isset($this->_font['vertical'])) && ($this->_font['vertical'])) {
                return ImageFontHeight($this->_font['font']) * (substr_count($text, "\n") + 1);
            } else {
                $width = 0;
                $lines = explode("\n", $text);
                foreach ($lines as $line) {
                    $width = max($width, ImageFontWidth($this->_font['font']) * strlen($line));
                }
                return $width;
            }
        }
    }

    /**
     * Get the height of a text.
     * 
     * Note! This method can give some peculiar results, since ImageTTFBBox() returns the total
     * bounding box of a text, where ImageTTF() writes the text on the baseline of the text, that
     * is 'g', 'p', 'q' and other letters that dig under the baseline will appear to have a larger
     * height than they actually do. Have a look at the tests/text.php test case - the first two
     * columns, 'left and 'center', both look alright, whereas the last column, 'right', appear
     * with a larger space between the first text and the second. This is because the total height
     * is actually smaller by exactly the number of pixels that the 'g' digs under the baseline.
     * Remove the 'g' from the text and they appear correct. 
     *
     * @param string $text The text to get the height of
     * @param bool $force Force the method to calculate the size
     * @return int The height of the text
     */
    function textHeight($text, $force = false)
    {
        if (isset($this->_font['file'])) {
            $angle = 0;
            if (isset($this->_font['angle'])) {
                $angle = $this->_font['angle'];
            }
            
            $linebreaks = substr_count($text, "\n"); 
            if (($angle == 0) && ($linebreaks == 0) && ($force === false)) {
                /*
                 * if the angle is 0 simply return the size, due to different
                 * heights for example for x-axis labels, making the labels
                 * _not_ appear as written on the same baseline
                 */ 
                return $this->_font['size'] + 2;
            }

            $height = 0;
            $lines = explode("\n", $text);
            foreach ($lines as $line) {            
                $bounds = ImageTTFBBox(
                    $this->_font['size'],
                    $angle,
                    $this->_font['file'],
                    $line
                );
    
                $y0 = min($bounds[1], $bounds[3], $bounds[5], $bounds[7]);
                $y1 = max($bounds[1], $bounds[3], $bounds[5], $bounds[7]);
                $height += abs($y0 - $y1);
            }
            return $height + $linebreaks * 2;
        } else {
            if ((isset($this->_font['vertical'])) && ($this->_font['vertical'])) {
                $width = 0;
                $lines = explode("\n", $text);
                foreach ($lines as $line) {
                    $width = max($width, ImageFontWidth($this->_font['font']) * strlen($line));
                }
                return $width;
            } else {
                return ImageFontHeight($this->_font['font']) * (substr_count($text, "\n") + 1);
            }
        }
    }

    /**
     * Writes text
     *
     * Parameter array:
     * 
     * 'x': int X-point of text
     * 
     * 'y': int Y-point of text
     * 
     * 'text': string The text to add
     * 
     * 'alignment': array [optional] Alignment
     * 
     * 'color': mixed [optional] The color of the text
     */
    function addText($params)
    {
        $x0 = $this->_getX($params['x']);
        $y0 = $this->_getY($params['y']);
        $text = $params['text'];
        $color = (isset($params['color']) ? $params['color'] : false);
        $alignment = (isset($params['alignment']) ? $params['alignment'] : false);

        $text = str_replace("\r", '', $text);

        if (!is_array($alignment)) {
            $alignment = array('vertical' => 'top', 'horizontal' => 'left');
        }

        if (!isset($alignment['vertical'])) {
            $alignment['vertical'] = 'top';
        }
        
        if (!isset($alignment['horizontal'])) {
            $alignment['horizontal'] = 'left';
        }
        
        if ($alignment['vertical'] == 'bottom') {
            $y0 = $y0 - $this->textHeight($text, true);
        } elseif ($alignment['vertical'] == 'center') {
            $y0 = $y0 - ($this->textHeight($text, true) / 2);
        }

        $lines = explode("\n", $text);                
        foreach ($lines as $line) {
            $textWidth = $this->textWidth($line);
            $textHeight = $this->textHeight($line, true);
            
              $x = $x0;
            $y = $y0;
            
            $y0 += $textHeight + 2;
                    
            if ($alignment['horizontal'] == 'right') {
                $x = $x - $textWidth;
            } elseif ($alignment['horizontal'] == 'center') {
                $x = $x - ($textWidth / 2);
            }           

            if (($color === false) && (isset($this->_font['color']))) {
                $color = $this->_font['color'];
            }

            if ($color != 'transparent') {
                if (isset($this->_font['file'])) {
                    if (($this->_font['angle'] < 180) && ($this->_font['angle'] >= 0)) {
                        $y += $textHeight;
                    }
                    if (($this->_font['angle'] >= 90) && ($this->_font['angle'] < 270)) {
                        $x += $textWidth;
                    }
    
                    ImageTTFText(
                        $this->_canvas,
                        $this->_font['size'],
                        $this->_font['angle'],
                        $x,
                        $y,
                        $this->_color($color),
                        $this->_font['file'],
                        $line
                    );

                } else {
                    if ((isset($this->_font['vertical'])) && ($this->_font['vertical'])) {
                        ImageStringUp(
                            $this->_canvas,
                            $this->_font['font'],
                            $x,
                            $y + $this->textHeight($text),
                            $line,
                            $this->_color($color)
                        );
                    } else {
                        ImageString(
                            $this->_canvas,
                            $this->_font['font'],
                            $x,
                            $y,
                            $line,
                            $this->_color($color)
                        );
                    }
                }
            }
        }
        parent::addText($params);
    }

    /**
     * Overlay image
     *
     * Parameter array:
     * 
     * 'x': int X-point of overlayed image
     * 
     * 'y': int Y-point of overlayed image
     * 
     * 'filename': string The filename of the image to overlay
     * 
     * 'width': int [optional] The width of the overlayed image (resizing if possible)
     * 
     * 'height': int [optional] The height of the overlayed image (resizing if possible)
     * 
     * 'alignment': array [optional] Alignment
     */
    function image($params)
    {
        $x = $this->_getX($params['x']);
        $y = $this->_getY($params['y']);
        $filename = $params['filename'];
        $width = (isset($params['width']) ? $params['width'] : false);
        $height = (isset($params['height']) ? $params['height'] : false);
        $alignment = (isset($params['alignment']) ? $params['alignment'] : false);

        if (!is_array($alignment)) {
            $alignment = array('vertical' => 'top', 'horizontal' => 'left');
        }

        if (!isset($alignment['vertical'])) {
            $alignment['vertical'] = 'top';
        }
        
        if (!isset($alignment['horizontal'])) {
            $alignment['horizontal'] = 'left';
        }

        if (file_exists($filename)) {
            if (strtolower(substr($filename, -4)) == '.png') {
                $image = ImageCreateFromPNG($filename);
            } elseif (strtolower(substr($filename, -4)) == '.gif') {
                $image = ImageCreateFromGIF($filename);
            } else {
                $image = ImageCreateFromJPEG($filename);
            }

            $imgWidth = ImageSX($image);
            $imgHeight = ImageSY($image);

            $outputWidth = ($width !== false ? $width : $imgWidth);
            $outputHeight = ($height !== false ? $height : $imgHeight);
            
            if ($alignment['horizontal'] == 'right') {
                $x -= $outputWidth;
            } elseif ($alignment['horizontal'] == 'center') {
                $x -= $outputWidth / 2;
            }

            if ($alignment['vertical'] == 'bottom') {
                $y -= $outputHeight;
            } elseif ($alignment['vertical'] == 'center') {
                $y -= $outputHeight / 2;
            }

            if ((($width !== false) && ($width != $imgWidth)) ||
                (($height !== false) && ($height != $imgHeight)))
            {
                if ($this->_gd2) {
                    ImageCopyResampled(
                        $this->_canvas,
                        $image,
                        $x,
                        $y,
                        0,
                        0,
                        $width,
                        $height,
                        $imgWidth,
                        $imgHeight
                    );
                } else {
                    ImageCopyResized(
                        $this->_canvas,
                        $image,
                        $x,
                        $y,
                        0,
                        0,
                        $width,
                        $height,
                        $imgWidth,
                        $imgHeight
                    );
                }
            } else {
                ImageCopy(
                    $this->_canvas,
                    $image,
                    $x,
                    $y,
                    0,
                    0,
                    $imgWidth,
                    $imgHeight
                );
            }
            ImageDestroy($image);
        }
        parent::image($params);
    }
    
    /**
     * Set clipping to occur
     * 
     * Parameter array:
     * 
     * 'x0': int X point of Upper-left corner
     * 'y0': int X point of Upper-left corner
     * 'x1': int X point of lower-right corner
     * 'y1': int Y point of lower-right corner
     */
    function setClipping($params = false) 
    {
        if ($params === false) {
            $index = count($this->_clipping) - 1;
            if (isset($this->_clipping[$index])) {                
                $params = $this->_clipping[$index];
                $canvas = $params['canvas'];
                ImageCopy(
                    $canvas, 
                    $this->_canvas,
                    min($params['x0'], $params['x1']),
                    min($params['y0'], $params['y1']),
                    min($params['x0'], $params['x1']),
                    min($params['y0'], $params['y1']),
                    abs($params['x1'] - $params['x0'] + 1),
                    abs($params['y1'] - $params['y0'] + 1)
                );
                $this->_canvas = $canvas;
                unset($this->_clipping[$index]);
            }
        }
        else {
            $params['canvas'] = $this->_canvas;

            if ($this->_gd2) {
                $this->_canvas = ImageCreateTrueColor(
                    $this->_width,
                    $this->_height
                );
                if ($this->_alpha) {
                    ImageAlphaBlending($this->_canvas, true);
                }
            } else {
                $this->_canvas = ImageCreate($this->_width, $this->_height);
            }
            
            if (($this->_gd2) && ($this->_antialias === 'native')) {
                ImageAntialias($this->_canvas, true);
            }
            
            ImageCopy($this->_canvas, $params['canvas'], 0, 0, 0, 0, $this->_width, $this->_height);                
            
            $this->_clipping[count($this->_clipping)] = $params;
        }
    }
    
    /**
     * Get a canvas specific HTML tag.
     * 
     * This method implicitly saves the canvas to the filename in the 
     * filesystem path specified and parses it as URL specified by URL path
     * 
     * Parameter array:
     * 
     * 'filename' string
     * 
     * 'filepath': string Path to the file on the file system. Remember the final slash
     * 
     * 'urlpath': string Path to the file available through an URL. Remember the final slash
     * 
     * 'alt': string [optional] Alternative text on image
     * 
     * 'cssclass': string [optional] The CSS Stylesheet class
     * 
     * 'border': int [optional] The border width on the image 
     */
    function toHtml($params)
    {
        parent::toHtml($params);
        return '<img src="' . $params['urlpath'] . $params['filename'] . '"' .
            (isset($params['alt']) ? ' alt="' . $params['alt'] . '"' : '') .
            (isset($params['cssclass']) ? ' class="' . $params['cssclass'] . '"' : '') .
            (isset($params['border']) ? ' border="' . $params['border'] . '"' : '') .
            (isset($this->_imageMap) ? ' usemap="#' . $params['filename'] . '"' : '') . '>' .
            (isset($this->_imageMap) ? "\n" . $this->_imageMap->toHtml(array('name' => $params['filename'])) : '');
    }

    /**
     * Resets the canvas.
     *
     * Include fillstyle, linestyle, thickness and polygon
     * @access private
     */
    function _reset()
    {
        if ($this->_gd2) {
            ImageSetThickness($this->_canvas, 1);
        }
        if ($this->_tileImage != null) {
            ImageDestroy($this->_tileImage);
            $this->_tileImage = null;
        }
        parent::_reset();
        $this->_font = array('font' => 1, 'color' => 'black');
    }

    /**
     * Check which version of GD is installed
     *
     * @return int 0 if GD isn't installed, 1 if GD 1.x is installed and 2 if GD
     * 2.x is installed
     * @access private
     */
    function _version()
    {
        $result = false;
        if (function_exists('gd_info')) {
            $info = gd_info();
            $version = $info['GD Version'];
        } else {
            ob_start();
            phpinfo(8);
            $php_info = ob_get_contents();
            ob_end_clean();

            if (ereg("<td[^>]*>GD Version *<\/td><td[^>]*>([^<]*)<\/td>",
                $php_info, $result))
            {
                $version = $result[1];
            }
        }

        if (ereg('1\.[0-9]{1,2}', $version)) {
            return 1;
        } elseif (ereg('2\.[0-9]{1,2}', $version)) {
            return 2;
        } else {
            return 0;
        }
    }

}

?>
