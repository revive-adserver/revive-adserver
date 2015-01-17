<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Class for handling output in SVG format.
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
 * @link       http://pear.php.net/pepr/pepr-proposal-show.php?id=212
 */

/**
 * Include file Image/Canvas.php
 */
require_once 'Image/Canvas.php';

/**
 * Include file Image/Canvas/Color.php
 */
require_once 'Image/Canvas/Color.php';

/**
 * SVG Canvas class.
 *
 * @category   Images
 * @package    Image_Canvas
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: @package_version@
 * @link       http://pear.php.net/pepr/pepr-proposal-show.php?id=212
 */
class Image_Canvas_SVG extends Image_Canvas
{

    /**
     * The SVG elements
     * @var string
     * @access private
     */
    var $_elements = '';

    /**
     * The SVG defines
     * @var string
     * @access private
     */
    var $_defs = '';

    /**
     * The current indention level
     * @var string
     * @access private
     */
    var $_indent = '    ';

    /**
     * A unieuq id counter
     * @var int
     * @access private
     */
    var $_id = 1;

    /**
     * The current group ids
     * @var array
     * @access private
     */
    var $_groupIDs = array();

    /**
     * Create the SVG canvas.
     *
     * Parameters available:
     *
     * 'width' The width of the graph
     *
     * 'height' The height of the graph
     *
     * @param array $param Parameter array
     */
    function __construct($param)
    {
        parent::__construct($param);
        $this->_reset();
    }

    /**
     * Add a SVG "element" to the output
     *
     * @param string $element The element
     * @access private
     */
    function _addElement($element, $params = array()) {
        $elementdata = $this->_indent . $element . "\n";

        if (isset($params['url'])) {
            $url = $params['url'];
            $target = (isset($params['target']) ? $params['target'] : false);
            $alt = (isset($params['alt']) ? $params['alt'] : false);

            $tags = '';
            if (isset($params['htmltags'])) {
                foreach ($params['htmltags'] as $key => $value) {
                    $tags .= ' ';
                    if (strpos($value, '"') >= 0) {
                        $tags .= $key . '=\'' . $value . '\'';
                    } else {
                        $tags .= $key . '="' . $value . '"';
                    }
                }
            }

            $elementdata =
                $this->_indent . '<a xlink:href="' . $url . '"' . ($target ? ' target="' . $target . '"' : '') . '>' . "\n" .
                '    ' . $elementdata .
                $this->_indent . '</a>' . "\n";
        }


        $this->_elements .= $elementdata;
    }

    /**
     * Add a SVG "define" to the output
     *
     * @param string $def The define
     * @access private
     */
    function _addDefine($def) {
        $this->_defs .= '        ' . $def . "\n";
    }

    /**
     * Get the color index for the RGB color
     *
     * @param int $color The color
     * @return int A SVG compatible color
     * @access private
     */
    function _color($color = false)
    {
        if ($color === false) {
            return 'transparent';
        } else {
            $color = Image_Canvas_Color::color2RGB($color);
            return 'rgb(' . $color[0] . ',' . $color[1] . ',' . $color[2] . ')';
        }
    }

    /**
     * Get the opacity for the RGB color
     *
     * @param int $color The color
     * @return int A SVG compatible opacity value
     * @access private
     */
    function _opacity($color = false)
    {
        if ($color === false) {
            return false;
        } else {
            $color = Image_Canvas_Color::color2RGB($color);
            if ($color[3] != 255) {
                return sprintf('%0.1f', $color[3]/255);
            } else {
                return false;
            }
        }
    }

    /**
     * Get the SVG applicable linestyle
     *
     * @param mixed $lineStyle The line style to return, false if the one
     *   explicitly set
     * @return mixed A SVG compatible linestyle
     * @access private
     */
    function _getLineStyle($lineStyle = false)
    {
        $result = '';
        if ($lineStyle === false) {
            $lineStyle = $this->_lineStyle;
        }

        // TODO Linestyles (i.e. fx. dotted) does not work

        if (($lineStyle != 'transparent') && ($lineStyle !== false)) {
            $result = 'stroke-width:' . $this->_thickness . ';';
            $result .= 'stroke:' .$this->_color($lineStyle) . ';';
            if ($opacity = $this->_opacity($lineStyle)) {
                $result .= 'stroke-opacity:' . $opacity . ';';
            }
        }
        return $result;
    }

    /**
     * Get the SVG applicable fillstyle
     *
     * @param mixed $fillStyle The fillstyle to return, false if the one
     *   explicitly set
     * @return mixed A SVG compatible fillstyle
     * @access private
     */
    function _getFillStyle($fillStyle = false)
    {
        $result = '';
        if ($fillStyle === false) {
            $fillStyle = $this->_fillStyle;
        }

        if (is_array($fillStyle)) {
            if ($fillStyle['type'] == 'gradient') {
                $id = 'gradient_' . ($this->_id++);
                $startColor = $this->_color($fillStyle['start']);
                $endColor = $this->_color($fillStyle['end']);
                $startOpacity = $this->_opacity($fillStyle['start']);
                $endOpacity = $this->_opacity($fillStyle['end']);

                switch ($fillStyle['direction']) {
                case 'horizontal':
                case 'horizontal_mirror':
                    $x1 = '0%';
                    $y1 = '0%';
                    $x2 = '100%';
                    $y2 = '0%';
                    break;

                case 'vertical':
                case 'vertical_mirror':
                    $x1 = '0%';
                    $y1 = '100%';
                    $x2 = '0%';
                    $y2 = '0%';
                    break;

                case 'diagonal_tl_br':
                    $x1 = '0%';
                    $y1 = '0%';
                    $x2 = '100%';
                    $y2 = '100%';
                    break;

                case 'diagonal_bl_tr':
                    $x1 = '0%';
                    $y1 = '100%';
                    $x2 = '100%';
                    $y2 = '0%';
                    break;

                case 'radial':
                    $cx = '50%';
                    $cy = '50%';
                    $r = '100%';
                    $fx = '50%';
                    $fy = '50%';
                    break;

                }

                if ($fillStyle['direction'] == 'radial') {
                    $this->_addDefine(
                        '<radialGradient id="' . $id . '" cx="' .
                            $cx .'" cy="' . $cy .'" r="' . $r .'" fx="' .
                            $fx .'" fy="' . $fy .'">'
                    );
                    $this->_addDefine(
                        '    <stop offset="0%" style="stop-color:' .
                            $startColor. ';' . ($startOpacity ? 'stop-opacity:' .
                            $startOpacity . ';' : ''). '"/>'
                    );
                    $this->_addDefine(
                        '    <stop offset="100%" style="stop-color:' .
                            $endColor. ';' . ($endOpacity ? 'stop-opacity:' .
                            $endOpacity . ';' : ''). '"/>'
                    );
                    $this->_addDefine(
                        '</radialGradient>'
                    );
                } elseif (($fillStyle['direction'] == 'vertical_mirror') ||
                    ($fillStyle['direction'] == 'horizontal_mirror'))
                {
                    $this->_addDefine(
                        '<linearGradient id="' . $id . '" x1="' .
                            $x1 .'" y1="' . $y1 .'" x2="' . $x2 .'" y2="' .
                            $y2 .'">'
                    );
                    $this->_addDefine(
                        '    <stop offset="0%" style="stop-color:' .
                            $startColor. ';' . ($startOpacity ? 'stop-opacity:' .
                            $startOpacity . ';' : ''). '"/>'
                    );
                    $this->_addDefine(
                        '    <stop offset="50%" style="stop-color:' .
                            $endColor. ';' . ($endOpacity ? 'stop-opacity:' .
                            $endOpacity . ';' : ''). '"/>'
                    );
                    $this->_addDefine(
                        '    <stop offset="100%" style="stop-color:' .
                            $startColor. ';' . ($startOpacity ? 'stop-opacity:' .
                            $startOpacity . ';' : ''). '"/>'
                    );
                    $this->_addDefine(
                        '</linearGradient>'
                    );
                } else {
                    $this->_addDefine(
                        '<linearGradient id="' . $id . '" x1="' .
                            $x1 .'" y1="' . $y1 .'" x2="' . $x2 .'" y2="' .
                            $y2 .'">'
                    );
                    $this->_addDefine(
                        '    <stop offset="0%" style="stop-color:' .
                            $startColor. ';' . ($startOpacity ? 'stop-opacity:' .
                            $startOpacity . ';' : ''). '"/>'
                    );
                    $this->_addDefine(
                        '    <stop offset="100%" style="stop-color:' .
                            $endColor. ';' . ($endOpacity ? 'stop-opacity:' .
                            $endOpacity . ';' : ''). '"/>'
                    );
                    $this->_addDefine(
                        '</linearGradient>'
                    );
                }

                return 'fill:url(#' . $id . ');';
            }
        } elseif (($fillStyle != 'transparent') && ($fillStyle !== false)) {
            $result = 'fill:' . $this->_color($fillStyle) . ';';
            if ($opacity = $this->_opacity($fillStyle)) {
                $result .= 'fill-opacity:' . $opacity . ';';
            }
            return $result;
        } else {
            return 'fill:none;';
        }
    }

    /**
     * Sets an image that should be used for filling
     *
     * @param string $filename The filename of the image to fill with
     */
    function setFillImage($filename)
    {
    }

    /**
     * Sets a gradient fill
     *
     * @param array $gradient Gradient fill options
     */
    function setGradientFill($gradient)
    {
        $this->_fillStyle = $gradient;
        $this->_fillStyle['type'] = 'gradient';
    }

    /**
     * Sets the font options.
     *
     * The $font array may have the following entries:
     * 'type' = 'ttf' (TrueType) or omitted for default<br>
     * If 'type' = 'ttf' then the following can be specified<br>
     * 'size' = size in pixels<br>
     * 'angle' = the angle with which to write the text
     * 'file' = the .ttf file (either the basename, filename or full path)
     *
     * @param array $font The font options.
     */
    function setFont($fontOptions)
    {
        parent::setFont($fontOptions);
        if (!isset($this->_font['size'])) {
            $this->_font['size'] = 10;
        }
    }

    /**
     * Parameter array:
     * 'x0': int X start point
     * 'y0': int Y start point
     * 'x1': int X end point
     * 'y1': int Y end point
     * 'color': mixed [optional] The line color
     * @param array $params Parameter array
     */
    function line($params)
    {
        $x0 = $this->_getX($params['x0']);
        $y0 = $this->_getY($params['y0']);
        $x1 = $this->_getX($params['x1']);
        $y1 = $this->_getY($params['y1']);
        $color = (isset($params['color']) ? $params['color'] : false);

        $style = $this->_getLineStyle($color) . $this->_getFillStyle('transparent');
        if ($style != '') {
            $this->_addElement(
                '<line ' .
                    'x1="' . round($x0) . '" ' .
                    'y1="' . round($y0) . '" ' .
                    'x2="' . round($x1) . '" ' .
                    'y2="' . round($y1) . '" ' .
                    'style="' . $style . '"' .
                '/>',
                $params
            );
        }
        parent::line($params);
    }

    /**
     * Parameter array:
     * 'connect': bool [optional] Specifies whether the start point should be
     *   connected to the endpoint (closed polygon) or not (connected line)
     * 'fill': mixed [optional] The fill color
     * 'line': mixed [optional] The line color
     * @param array $params Parameter array
     */
    function polygon($params = array())
    {
        $connectEnds = (isset($params['connect']) ? $params['connect'] : false);
        $fillColor = (isset($params['fill']) ? $params['line'] : false);
        $lineColor = (isset($params['line']) ? $params['line'] : false);

        if (!$connectEnds) {
            $fillColor = 'transparent';
        }
        $style = $this->_getLineStyle($lineColor) . $this->_getFillStyle($fillColor);

        $first = true;
        $spline = false;
        $lastpoint = false;
        foreach($this->_polygon as $point) {
            if ($first) {
                $points = 'M';
            } elseif (!$spline) {
                $points .= ' L';
            }

            if (($spline) && ($lastpoint !== false)) {
                $points .= ' ' .round($lastpoint['P1X']) . ',' . round($lastpoint['P1Y']) . ' ' .
                           round($lastpoint['P2X']) . ',' . round($lastpoint['P2Y']);
            }

            $points .= ' ' . round($point['X']) . ',' . round($point['Y']);

            if ((isset($point['P1X'])) && (isset($point['P1Y'])) &&
                (isset($point['P2X'])) && (isset($point['P2Y'])))
            {
                if (($first) || (!$spline)) {
                    $points .= ' C';
                }
                $lastpoint = $point;
                $spline = true;
            } else {
                $spline = false;
            }
            $first = false;
        }
        if ($connectEnds) {
            $point .= ' Z';
        }
        $this->_addElement(
            '<path ' .
                 'd="' . $points . '" ' .
                 'style="' . $style . '"' .
            '/>',
            $params
        );

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
        $x0 = min($this->_getX($params['x0']), $this->_getX($params['x1']));
        $y0 = min($this->_getY($params['y0']), $this->_getY($params['y1']));
        $x1 = max($this->_getX($params['x0']), $this->_getX($params['x1']));
        $y1 = max($this->_getY($params['y0']), $this->_getY($params['y1']));
        $fillColor = (isset($params['fill']) ? $params['line'] : false);
        $lineColor = (isset($params['line']) ? $params['line'] : false);

        $style = $this->_getLineStyle($lineColor) . $this->_getFillStyle($fillColor);
        if ($style != '') {
            $this->_addElement(
                '<rect ' .
                    'x="' . round($x0) . '" ' .
                    'y="' . round($y0) . '" ' .
                    'width="' . round(abs($x1 - $x0)) . '" ' .
                    'height="' . round(abs($y1 - $y0)) . '" ' .
                    'style="' . $style . '"' .
                '/>',
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
        $x = $this->_getX($params['x']);
        $y = $this->_getY($params['y']);
        $rx = $this->_getX($params['rx']);
        $ry = $this->_getY($params['ry']);
        $fillColor = (isset($params['fill']) ? $params['line'] : false);
        $lineColor = (isset($params['line']) ? $params['line'] : false);

        $style = $this->_getLineStyle($lineColor) . $this->_getFillStyle($fillColor);
        if ($style != '') {
            $this->_addElement(
                '<ellipse ' .
                    'cx="' . round($x) . '" ' .
                    'cy="' . round($y) . '" ' .
                    'rx="' . round($rx) . '" ' .
                    'ry="' . round($ry) . '" ' .
                    'style="' . $style . '"' .
                '/>',
                $params
            );
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
        $x = $this->_getX($params['x']);
        $y = $this->_getY($params['y']);
        $rx = $this->_getX($params['rx']);
        $ry = $this->_getY($params['ry']);
        $v1 = $this->_getX($params['v1']);
        $v2 = $this->_getY($params['v2']);
        $srx = (isset($params['srx']) ? $this->_getX($params['srx']) : false);
        $sry = (isset($params['sry']) ? $this->_getX($params['sry']) : false);
        $fillColor = (isset($params['fill']) ? $params['line'] : false);
        $lineColor = (isset($params['line']) ? $params['line'] : false);

        $dv = max($v2, $v1) - min($v2, $v1);
        if ($dv >= 360) {
            $this->ellipse($params);
        }
        else {
            $style = $this->_getLineStyle($lineColor) . $this->_getFillStyle($fillColor);
            if ($style != '') {
                $x1 = ($x + $rx * cos(deg2rad(min($v1, $v2) % 360)));
                $y1 = ($y + $ry * sin(deg2rad(min($v1, $v2) % 360)));
                $x2 = ($x + $rx * cos(deg2rad(max($v1, $v2) % 360)));
                $y2 = ($y + $ry * sin(deg2rad(max($v1, $v2) % 360)));
                $this->_addElement(
                    '<path d="' .
                        'M' . round($x) . ',' . round($y) . ' ' .
                        'L' . round($x1) . ',' . round($y1) . ' ' .
                        'A' . round($rx) . ',' . round($ry) . ($dv > 180 ? ' 0 1,1 ' : ' 0 0,1 ') .
                              round($x2) . ',' . round($y2) . ' ' .
                        'Z" ' .
                        'style="' . $style . '"' .
                    '/>',
                    $params
                );
            }

            parent::pieslice($params);
        }
    }

    /**
     * Get the width of a text,
     *
     * @param string $text The text to get the width of
     * @return int The width of the text
     */
    function textWidth($text)
    {
        if ((isset($this->_font['vertical'])) && ($this->_font['vertical'])) {
            return $this->_font['size'];
        } else {
            return round($this->_font['size'] * 0.7 * strlen($text));
        }
    }

    /**
     * Get the height of a text,
     *
     * @param string $text The text to get the height of
     * @return int The height of the text
     */
    function textHeight($text)
    {
        if ((isset($this->_font['vertical'])) && ($this->_font['vertical'])) {
            return round($this->_font['size'] * 0.7 * strlen($text));
        } else {
            return $this->_font['size'];
        }
    }

    /**
     * Writes text
     *
     * Parameter array:
     * 'x': int X-point of text
     * 'y': int Y-point of text
     * 'text': string The text to add
     * 'alignment': array [optional] Alignment
     * 'color': mixed [optional] The color of the text
     */
    function addText($params)
    {
        $x = $this->_getX($params['x']);
        $y = $this->_getY($params['y']);
        $text = $params['text'];
        $color = (isset($params['color']) ? $params['color'] : false);
        $alignment = (isset($params['alignment']) ? $params['alignment'] : false);

        $textHeight = $this->textHeight($text);

        if (!is_array($alignment)) {
            $alignment = array('vertical' => 'top', 'horizontal' => 'left');
        }

        if (!isset($alignment['vertical'])) {
            $alignment['vertical'] = 'top';
        }

        if (!isset($alignment['horizontal'])) {
            $alignment['horizontal'] = 'left';
        }

        $align = '';

        if ((isset($this->_font['vertical'])) && ($this->_font['vertical'])) {
//            $align .= 'writing-mode: tb-rl;';

            if ($alignment['vertical'] == 'bottom') {
                $align .= 'text-anchor:end;';
                //$y = $y + $textHeight;
            } elseif ($alignment['vertical'] == 'center') {
                //$y = $y + ($textHeight / 2);
                $align .= 'text-anchor:middle;';
            }
        } else {
            if ($alignment['horizontal'] == 'right') {
                $align .= 'text-anchor:end;';
            } elseif ($alignment['horizontal'] == 'center') {
                $align .= 'text-anchor:middle;';
            }

            if ($alignment['vertical'] == 'top') {
                $y = $y + $textHeight;
            } elseif ($alignment['vertical'] == 'center') {
                $y = $y + ($textHeight / 2);
            }
        }

        if (($color === false) && (isset($this->_font['color']))) {
            $color = $this->_font['color'];
        }

        $textColor = $this->_color($color);
        $textOpacity = $this->_opacity($color);

        $this->_addElement(
            '<g transform="translate(' . round($x) . ', ' . round($y) . ')">' . "\n" .
            $this->_indent . '    <text ' .
                'x="0" ' .
                'y="0" ' .
                (isset($this->_font['angle']) && ($this->_font['angle'] > 0) ?
                    'transform="rotate(' . $this->_font['angle'] . ')" ' :
                    ''
                ) .
                'style="' .
                (isset($this->_font['name']) ?
                    'font-family:' . $this->_font['name'] . ';' : '') .
                        'font-size:' . $this->_font['size'] . 'px;fill:' .
                        $textColor . ($textOpacity ? ';fill-opacity:' .
                        $textOpacity :
                    ''
                ) . ';' . $align . '">' .
                htmlspecialchars($text) .
            '</text>' . "\n" .
            $this->_indent . '</g>',
            $params
        );
        parent::addText($params);
    }

    /**
     * Overlay image
     *
     * Parameter array:
     * 'x': int X-point of overlayed image
     * 'y': int Y-point of overlayed image
     * 'filename': string The filename of the image to overlay
     * 'width': int [optional] The width of the overlayed image (resizing if possible)
     * 'height': int [optional] The height of the overlayed image (resizing if possible)
     * 'alignment': array [optional] Alignment
     */
    function image($params)
    {
        $x = $this->_getX($params['x']);
        $y = $this->_getY($params['y']);
        $filename = $params['filename'];

        list($width, $height, $type, $attr) = getimagesize($filename);
        $width = (isset($params['width']) ? $params['width'] : $width);
        $height = (isset($params['height']) ? $params['height'] : $height);
        $alignment = (isset($params['alignment']) ? $params['alignment'] : false);

        $file = fopen($filename, 'rb');
        $filedata = fread($file, filesize($filename));
        fclose($file);

        $data = 'data:' . image_type_to_mime_type($type) . ';base64,' . base64_encode($filedata);
        $this->_addElement(
            '<image xlink:href="' . $data . '" x="' . $x . '" y="' . $y . '"' .
                ($width ? ' width="' . $width . '"' : '') .
                ($height ? ' height="' . $height . '"' : '') .
            ' preserveAspectRatio="none"/>',
            $params
        );
        parent::image($params);
    }

    /**
     * Start a group.
     *
     * What this does, depends on the canvas/format.
     *
     * @param string $name The name of the group
     */
    function startGroup($name = false)
    {
        $name = strtolower(str_replace(' ', '_', $name));
        if (in_array($name, $this->_groupIDs)) {
            $name .= $this->_id;
            $this->_id++;
        }
        $this->_groupIDs[] = $name;
        $this->_addElement('<g id="' . htmlspecialchars($name) . '">');
        $this->_indent .= '    ';
    }

    /**
     * End the "current" group.
     *
     * What this does, depends on the canvas/format.
     */
    function endGroup()
    {
        $this->_indent = substr($this->_indent, 0, -4);
        $this->_addElement('</g>');
    }

    /**
     * Output the result of the canvas
     *
     * @param array $param Parameter array
     */
    function show($param = false)
    {
        parent::show($param);
        $output = '<?xml version="1.0" encoding="iso-8859-1"?>' . "\n" .
            '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.0//EN"' . "\n\t" .
            ' "http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd">' . "\n" .
            '<svg width="' . $this->_width . '" height="' . $this->_height .
                '" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">' . "\n" .
            ($this->_defs ?
                '    <defs>' . "\n" .
                $this->_defs .
                '    </defs>' . "\n" :
                ''
            ) .
            $this->_elements .
            '</svg>';

        header('Content-Type: image/svg+xml');
        header('Content-Disposition: inline; filename = "' . basename($_SERVER['PHP_SELF'], '.php') . '.svg"');
        print $output;
    }

    /**
     * Output the result of the canvas
     *
     * @param array $param Parameter array
     */
    function save($param = false)
    {
        parent::save($param);
        $output = '<?xml version="1.0" encoding="iso-8859-1"?>' . "\n" .
            '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.0//EN"' . "\n\t" .
            ' "http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd">' . "\n" .
            '<svg width="' . $this->_width . '" height="' . $this->_height .
                '" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">' . "\n" .
            ($this->_defs ?
                '    <defs>' . "\n" .
                $this->_defs .
                '    </defs>' . "\n" :
                ''
            ) .
            $this->_elements .
            '</svg>';

        $file = fopen($param['filename'], 'w+');
        fwrite($file, $output);
        fclose($file);
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
            $this->_addElement('</g>');
        }
        else {
            $group = "clipping_" . $this->_id;
            $this->_id++;
            $this->_addElement('<g clip-path="url(#' . $group . ')">');

            $this->_addDefine('<clipPath id="' . $group . '">');
            $this->_addDefine('    <path d="' .
                'M' . $this->_getX($params['x0']) . ' ' . $this->_getY($params['y0']) .
                ' H' . $this->_getX($params['x1']) .
                ' V' . $this->_getY($params['y1']) .
                ' H' . $this->_getX($params['x0']) .
                ' Z"/>');
            $this->_addDefine('</clipPath>');
        }
    }

    /**
     * Get a canvas specific HTML tag.
     *
     * This method implicitly saves the canvas to the filename in the
     * filesystem path specified and parses it as URL specified by URL path
     *
     * Parameter array:
     * 'filename': string
     * 'filepath': string Path to the file on the file system. Remember the final slash
     * 'urlpath': string Path to the file available through an URL. Remember the final slash
     * 'width': int The width in pixels
     * 'height': int The height in pixels
     */
    function toHtml($params)
    {
        parent::toHtml($params);
        return '<embed src="' . $params['urlpath'] . $params['filename'] . '" width=' . $params['width'] . ' height=' . $params['height'] . ' type="image/svg+xml">';
    }

}

?>
