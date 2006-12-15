<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Class for handling output in PDF format.
 * 
 * Requires PHP extension PDFlib
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
 * @version    CVS: $Id: PDF.php,v 1.5 2005/10/28 09:54:40 nosey Exp $
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
 * PDF Canvas class.
 * 
 * @category   Images
 * @package    Image_Canvas
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: @package_version@
 * @link       http://pear.php.net/pepr/pepr-proposal-show.php?id=212
 */
class Image_Canvas_PDF extends Image_Canvas
{

    /**
     * The PDF document
     * @var resource
     * @access private
     */
    var $_pdf;

    /**
     * The major version of PDFlib
     * @var int
     * @access private
     */
    var $_pdflib;

    /**
     * The font
     * @var mixed
     * @access private
     */
    var $_pdfFont = false;

    /**
     * The width of the page
     * @var int
     * @access private
     */
    var $_pageWidth;

    /**
     * The height of the page
     * @var int
     * @access private
     */
    var $_pageHeight;

    /**
     * Create the PDF canvas.
     *
     * Parameters available:
     *
     * 'page' Specify the page/paper format for the graph's page, available
     * formats are: A0, A1, A2, A3, A4, A5, A6, B5, letter, legal, ledger,
     * 11x17, cd_front, inlay, inlay_nosides
     *
     * 'align' Alignment of the graph on the page, available options are:
     * topleft, topcenter, topright, leftcenter, center, rightcenter,
     * leftbottom, centerbottom, rightbottom
     *
     * 'orientation' Specifies the paper orientation, default is 'portrait' and
     * 'landscape' is also supported.
     *
     * 'creator' The creator tag of the PDF/graph
     *
     * 'author' The author tag of the PDF/graph
     *
     * 'title' The title tag of the PDF/graph
     *
     * 'width' The width of the graph on the page
     *
     * 'height' The height of the graph on the page
     *
     * 'left' The left offset of the graph on the page
     *
     * 'top' The top offset of the graph on the page
     *
     * 'filename' The PDF file to open/add page to, using 'filename' requires
     * the commercial version of PDFlib (http://www.pdflib.com/), this has for
     * obvious ($ 450) reasons not been tested
     *
     * 'pdf' An existing PDFlib PDF document to add the page to
     *
     * 'add_page' (true/false) Used together with 'pdf', to specify whether the
     * canvas should add a new graph page (true) or create the graph on the
     * current page (false), default is 'true'
     *
     * The 'page' and 'width' & 'height' can be mutually omitted, if 'page' is
     * omitted the page is created using dimensions of width x height, and if
     * width and height are omitted the page dimensions are used for the graph.
     *
     * If 'pdf' is specified, 'filename', 'creator', 'author' and 'title' has no
     * effect.
     *
     * 'left' and 'top' are overridden by 'align'
     *
     * It is required either to specify 'width' & 'height' or 'page'.
     *
     * The PDF format/PDFlib has some limitations on the capabilities, which
     * means some functionality available using other canvass (fx. alpha
     * blending and gradient fills) are not supported with PDF (see Canvas.txt
     * in the docs/ folder for further details)
     *
     * @param array $param Parameter array
     */
    function Image_Canvas_PDF($param)
    {
        if (isset($param['page'])) {
            switch (strtoupper($param['page'])) {
            case 'A0':
                $this->_pageWidth = 2380;
                $this->_pageHeight = 3368;
                break;

            case 'A1':
                $this->_pageWidth = 1684;
                $this->_pageHeight = 2380;
                break;

            case 'A2':
                $this->_pageWidth = 1190;
                $this->_pageHeight = 1684;
                break;

            case 'A3':
                $this->_pageWidth = 842;
                $this->_pageHeight = 1190;
                break;

            case 'A4':
                $this->_pageWidth = 595;
                $this->_pageHeight = 842;
                break;

            case 'A5':
                $this->_pageWidth = 421;
                $this->_pageHeight = 595;
                break;

            case 'A6':
                $this->_pageWidth = 297;
                $this->_pageHeight = 421;
                break;

            case 'B5':
                $this->_pageWidth = 501;
                $this->_pageHeight = 709;
                break;

            case 'LETTER':
                $this->_pageWidth = 612;
                $this->_pageHeight = 792;
                break;

            case 'LEGAL':
                $this->_pageWidth = 612;
                $this->_pageHeight = 1008;
                break;

            case 'LEDGER':
                $this->_pageWidth = 1224;
                $this->_pageHeight = 792;
                break;

            case '11X17':
                $this->_pageWidth = 792;
                $this->_pageHeight = 1224;
                break;

            case 'CD_FRONT':
                $this->_pageWidth = 337;
                $this->_pageHeight = 337;
                break;

            case 'INLAY':
                $this->_pageWidth = 425;
                $this->_pageHeight = 332;
                break;

            case 'INLAY_NOSIDES':
                $this->_pageWidth = 390;
                $this->_pageHeight = 332;
                break;
            }
        }

        if ((isset($param['orientation'])) && (strtoupper($param['orientation']) == 'LANDSCAPE')) {
            $w = $this->_pageWidth;
            $this->_pageWidth = $this->_pageHeight;
            $this->_pageHeight = $w;
        }

        parent::Image_Canvas($param);

        if (!$this->_pageWidth) {
            $this->_pageWidth = $this->_width;
        } elseif (!$this->_width) {
            $this->_width = $this->_pageWidth;
        }

        if (!$this->_pageHeight) {
            $this->_pageHeight = $this->_height;
        } elseif (!$this->_height) {
            $this->_height = $this->_pageHeight;
        }

        $this->_width = min($this->_width, $this->_pageWidth);
        $this->_height = min($this->_height, $this->_pageHeight);

        if ((isset($param['align'])) &&
            (($this->_width != $this->_pageWidth) || ($this->_height != $this->_pageHeight))
        ) {
            switch (strtoupper($param['align'])) {
            case 'TOPLEFT':
                $this->_top = 0;
                $this->_left = 0;
                break;

            case 'TOPCENTER':
                $this->_top = 0;
                $this->_left = ($this->_pageWidth - $this->_width) / 2;
                break;

            case 'TOPRIGHT':
                $this->_top = 0;
                $this->_left = $this->_pageWidth - $this->_width;
                break;

            case 'LEFTCENTER':
                $this->_top = ($this->_pageHeight - $this->_height) / 2;
                $this->_left = 0;
                break;

            case 'CENTER':
                $this->_top = ($this->_pageHeight - $this->_height) / 2;
                $this->_left = ($this->_pageWidth - $this->_width) / 2;
                break;

            case 'RIGHTCENTER':
                $this->_top = ($this->_pageHeight - $this->_height) / 2;
                $this->_left = $this->_pageWidth - $this->_width;
                break;

            case 'LEFTBOTTOM':
                $this->_top = $this->_pageHeight - $this->_height;
                $this->_left = 0;
                break;

            case 'CENTERBOTTOM':
                $this->_top = $this->_pageHeight - $this->_height;
                $this->_left = ($this->_pageWidth - $this->_width) / 2;
                break;

            case 'RIGHTBOTTOM':
                $this->_top = $this->_pageHeight - $this->_height;
                $this->_left = $this->_pageWidth - $this->_width;
                break;
            }
        }

        $this->_pdflib = $this->_version();

        $addPage = true;
        if ((isset($param['pdf'])) && (is_resource($param['pdf']))) {
            $this->_pdf =& $param['pdf'];
            if ((isset($param['add_page'])) && ($param['add_page'] === false)) {
                $addPage = false;
            }
        } else {
            $this->_pdf = pdf_new();

            if (isset($param['filename'])) {
                pdf_open_file($this->_pdf, $param['filename']);
            } else {
                pdf_open_file($this->_pdf, '');
            }

            pdf_set_parameter($this->_pdf, 'warning', 'true');

            pdf_set_info($this->_pdf, 'Creator', (isset($param['creator']) ? $param['creator'] : 'PEAR::Image_Canvas'));
            pdf_set_info($this->_pdf, 'Author', (isset($param['author']) ? $param['author'] : 'Jesper Veggerby'));
            pdf_set_info($this->_pdf, 'Title', (isset($param['title']) ? $param['title'] : 'Image_Canvas'));
        }

        if ($addPage) {
            pdf_begin_page($this->_pdf, $this->_pageWidth, $this->_pageHeight);
        }
        $this->_reset();
    }

    /**
     * Get the x-point from the relative to absolute coordinates
     *
     * @param float $x The relative x-coordinate (in percentage of total width)
     * @return float The x-coordinate as applied to the canvas
     * @access private
     */
    function _getX($x)
    {
        return $this->_left + $x;
    }

    /**
     * Get the y-point from the relative to absolute coordinates
     *
     * @param float $y The relative y-coordinate (in percentage of total width)
     * @return float The y-coordinate as applied to the canvas
     * @access private
     */
    function _getY($y)
    {
        return $this->_pageHeight - ($this->_top + $y);
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
            return false;
        } else {
            $color = Image_Canvas_Color::color2RGB($color);
            $color[0] = $color[0]/255;
            $color[1] = $color[1]/255;
            $color[2] = $color[2]/255;
            return $color;
        }
    }

    /**
     * Get the PDF linestyle
     *
     * @param mixed $lineStyle The line style to return, false if the one
     *   explicitly set
     * @return bool True if set (so that a line should be drawn)
     * @access private
     */
    function _setLineStyle($lineStyle = false)
    {
        if ($lineStyle === false) {
            $lineStyle = $this->_lineStyle;
        }

        if (($lineStyle == 'transparent') || ($lineStyle === false)) {
            return false;
        }
        
        if (is_array($lineStyle)) {
            // TODO Implement linestyles in PDFlib (using pdf_setcolor(.., 'pattern'...); ?
            reset($lineStyle);
            $lineStyle = current($lineStyle);
        } 

        $color = $this->_color($lineStyle);

        pdf_setlinewidth($this->_pdf, $this->_thickness);
        if ($this->_pdflib < 4) {
            pdf_setrgbcolor_stroke($this->_pdf, $color[0]/255, $color[1]/255, $color[2]/255);
        } else {
            pdf_setcolor($this->_pdf, 'stroke', 'rgb', $color[0], $color[1], $color[2], 0);
        }
        return true;
    }

    /**
     * Set the PDF fill style
     *
     * @param mixed $fillStyle The fillstyle to return, false if the one
     *   explicitly set
     * @return bool True if set (so that a line should be drawn)
     * @access private
     */
    function _setFillStyle($fillStyle = false)
    {
        if ($fillStyle === false) {
            $fillStyle = $this->_fillStyle;
        }

        if (($fillStyle == 'transparent') || ($fillStyle === false)) {
            return false;
        }

        $color = $this->_color($fillStyle);

        if ($this->_pdflib < 4) {
            pdf_setrgbcolor_fill($this->_pdf, $color[0]/255, $color[1]/255, $color[2]/255);
        } else {
            pdf_setcolor($this->_pdf, 'fill', 'rgb', $color[0], $color[1], $color[2], 0);
        }
        return true;
    }

    /**
     * Set the PDF font
     *
     * @access private
     */
    function _setFont()
    {
        $this->_pdfFont = false;
        if (isset($this->_font['name'])) {
            pdf_set_parameter($this->_pdf, 'FontOutline', $this->_font['name'] . '=' . $this->_font['file']);
            $this->_pdfFont = pdf_findfont($this->_pdf, $this->_font['name'], $this->_font['encoding'], 1);

            if ($this->_pdfFont) {
                pdf_setfont($this->_pdf, $this->_pdfFont, $this->_font['size']);
                $this->_setFillStyle($this->_font['color']);
            }
        } else {
            $this->_setFillStyle('black');
        }
    }

    /**
     * Sets an image that should be used for filling.
     *
     * Image filling is not supported with PDF, filling 'transparent'
     *
     * @param string $filename The filename of the image to fill with
     */
    function setFillImage($filename)
    {
        $this->_fillStyle = 'transparent';
    }

    /**
     * Sets a gradient fill
     *
     * Gradient filling is not supported with PDF, end color used as solid fill.
     *
     * @param array $gradient Gradient fill options
     */
    function setGradientFill($gradient)
    {
        $this->_fillStyle = $gradient['end'];
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

        if (!isset($this->_font['size'])) {
            $this->_font['size'] = 12;
        }

        if (!isset($this->_font['encoding'])) {
            $this->_font['encoding'] = 'winansi';
        }

        if (!isset($this->_font['color'])) {
            $this->_font['color'] = 'black';
        }
    }

    /**
     * Resets the canvas.
     *
     * Includes fillstyle, linestyle, thickness and polygon
     *
     * @access private
     */
    function _reset()
    {
        pdf_initgraphics($this->_pdf);
        parent::_reset();
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
     * @param array $params Parameter array
     */
    function line($params)
    {
        $color = (isset($params['color']) ? $params['color'] : false);
        if ($this->_setLineStyle($color)) {
            pdf_moveto($this->_pdf, $this->_getX($params['x0']), $this->_getY($params['y0']));
            pdf_lineto($this->_pdf, $this->_getX($params['x1']), $this->_getY($params['x1']));
            pdf_stroke($this->_pdf);
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

        $line = $this->_setLineStyle($lineColor);
        $fill = false;
        if ($connectEnds) {
            $fill = $this->_setFillStyle($fillColor);
        }

        $first = true;
        foreach ($this->_polygon as $point) {
            if ($first === true) {
                pdf_moveto($this->_pdf, $point['X'], $point['Y']);
                $first = $point;
            } else {
                if (isset($last['P1X'])) {
                    pdf_curveto($this->_pdf,
                        $last['P1X'],
                        $last['P1Y'],
                        $last['P2X'],
                        $last['P2Y'],
                        $point['X'],
                        $point['Y']
                    );
                } else {
                    pdf_lineto($this->_pdf,
                        $point['X'],
                        $point['Y']
                    );
                }
            }
            $last = $point;
        }

        if ($connectEnds) {
            if (isset($last['P1X'])) {
                pdf_curveto($this->_pdf,
                    $last['P1X'],
                    $last['P1Y'],
                    $last['P2X'],
                    $last['P2Y'],
                    $first['X'],
                    $first['Y']
                );
            } else {
                pdf_lineto($this->_pdf,
                    $first['X'],
                    $first['Y']
                );
            }
        }

        if (($line) && ($fill)) {
            pdf_fill_stroke($this->_pdf);
        } elseif ($line) {
            pdf_stroke($this->_pdf);
        } elseif ($fill) {
            pdf_fill($this->_pdf);
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
        $x0 = $this->_getX($params['x0']);
        $y0 = $this->_getY($params['y0']);
        $x1 = $this->_getX($params['x1']);
        $y1 = $this->_getY($params['y1']);
        $fillColor = (isset($params['fill']) ? $params['line'] : false);
        $lineColor = (isset($params['line']) ? $params['line'] : false);

        $line = $this->_setLineStyle($lineColor);
        $fill = $this->_setFillStyle($fillColor);
        if (($line) || ($fill)) {
            pdf_rect($this->_pdf, $this->_getX(min($x0, $x1)), $this->_getY(max($y0, $y1)), abs($x1 - $x0), abs($y1 - $y0));
            if (($line) && ($fill)) {
                pdf_fill_stroke($this->_pdf);
            } elseif ($line) {
                pdf_stroke($this->_pdf);
            } elseif ($fill) {
                pdf_fill($this->_pdf);
            }
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

        $line = $this->_setLineStyle($lineColor);
        $fill = $this->_setFillStyle($fillColor);
        if (($line) || ($fill)) {
            if ($rx == $ry) {
                pdf_circle($this->_pdf, $this->_getX($x), $this->_getY($y), $rx);
            } else {
                pdf_moveto($this->_pdf, $this->_getX($x - $rx), $this->_getY($y));
                pdf_curveto($this->_pdf,
                    $this->_getX($x - $rx), $this->_getY($y),
                    $this->_getX($x - $rx), $this->_getY($y - $ry),
                    $this->_getX($x), $this->_getY($y - $ry)
                );
                pdf_curveto($this->_pdf,
                    $this->_getX($x), $this->_getY($y - $ry),
                    $this->_getX($x + $rx), $this->_getY($y - $ry),
                    $this->_getX($x + $rx), $this->_getY($y)
                );
                pdf_curveto($this->_pdf,
                    $this->_getX($x + $rx), $this->_getY($y),
                    $this->_getX($x + $rx), $this->_getY($y + $ry),
                    $this->_getX($x), $this->_getY($y + $ry)
                );
                pdf_curveto($this->_pdf,
                    $this->_getX($x), $this->_getY($y + $ry),
                    $this->_getX($x - $rx), $this->_getY($y + $ry),
                    $this->_getX($x - $rx), $this->_getY($y)
                );
            }

            if (($line) && ($fill)) {
                pdf_fill_stroke($this->_pdf);
            } elseif ($line) {
                pdf_stroke($this->_pdf);
            } elseif ($fill) {
                pdf_fill($this->_pdf);
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
        $x = $this->_getX($params['x']);
        $y = $this->_getY($params['y']);
        $rx = $this->_getX($params['rx']);
        $ry = $this->_getY($params['ry']);
        $v1 = $this->_getX($params['v1']);
        $v2 = $this->_getY($params['v2']);
        $srx = $this->_getX($params['srx']);
        $sry = $this->_getY($params['sry']);
        $fillColor = (isset($params['fill']) ? $params['line'] : false);
        $lineColor = (isset($params['line']) ? $params['line'] : false);

        // TODO Implement PDFLIB::pieSlice()
        parent::pieslice($params);
    }

    /**
     * Get the width of a text,
     *
     * @param string $text The text to get the width of
     * @return int The width of the text
     */
    function textWidth($text)
    {
        if ($this->_pdfFont === false) {
             return $this->_font['size'] * 0.7 * strlen($text);
         } else {
            return pdf_stringwidth($this->_pdf, $text, $this->_pdfFont, $this->_font['size']);
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
        if (isset($this->_font['size'])) {
            return $this->_font['size'];
        } else {
            return 12;
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

        $this->_setFont();

        $textWidth = $this->textWidth($text);
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

        if ($alignment['horizontal'] == 'right') {
            $x = $x - $textWidth;
        } elseif ($alignment['horizontal'] == 'center') {
            $x = $x - ($textWidth / 2);
        }

        if ($alignment['vertical'] == 'top') {
            $y = $y + $textHeight;
        } elseif ($alignment['vertical'] == 'center') {
            $y = $y + ($textHeight / 2);
        }

        if (($color === false) && (isset($this->_font['color']))) {
            $color = $this->_font['color'];
        }

        pdf_show_xy($this->_pdf, $text, $this->_getX($x), $this->_getY($y));

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
        $width = (isset($params['width']) ? $params['width'] : false);
        $height = (isset($params['height']) ? $params['height'] : false);
        $alignment = (isset($params['alignment']) ? $params['alignment'] : false);

        if (substr($filename, -4) == '.png') {
            $type = 'png';
        } elseif (substr($filename, -4) == '.jpg') {
            $type = 'jpeg';
        }

        $image = pdf_load_image($this->_pdf, $type, realpath($filename), '');
        $width_ = pdf_get_value($this->_pdf, 'imagewidth', $image);
        $height_ = pdf_get_value($this->_pdf, 'imageheight', $image);

        $outputWidth = ($width !== false ? $width : $width_);
        $outputHeight = ($height !== false ? $height : $height_);

        if (!is_array($alignment)) {
            $alignment = array('vertical' => 'top', 'horizontal' => 'left');
        }
        
        if (!isset($alignment['vertical'])) {
            $alignment['vertical'] = 'top';
        }
        
        if (!isset($alignment['horizontal'])) {
            $alignment['horizontal'] = 'left';
        }

        if ($alignment['horizontal'] == 'right') {
            $x -= $outputWidth;
        } elseif ($alignment['horizontal'] == 'center') {
            $x -= $outputWidth / 2;
        }

        if ($alignment['vertical'] == 'top') {
            $y += $outputHeight;
        } elseif ($alignment['vertical'] == 'center') {
            $y += $outputHeight / 2;
        }
        
        if (($width === false) && ($height === false)) {
            $scale = 1;
        } else {
            $scale = max(($height/$height_), ($width/$width_));
        }   

        pdf_place_image($this->_pdf, $image, $this->_getX($x), $this->_getY($y), $scale);
        pdf_close_image($this->_pdf, $image);
        
        parent::image($params);
    }

    /**
     * Output the result of the canvas
     *
     * @param array $param Parameter array
     * @abstract
     */
    function show($param = false)
    {
        parent::show($param);
        pdf_end_page($this->_pdf);
        pdf_close($this->_pdf);

        $buf = pdf_get_buffer($this->_pdf);
        $len = strlen($buf);

        header('Content-type: application/pdf');
        header('Content-Length: ' . $len);
        header('Content-Disposition: inline; filename=image_graph.pdf');
        print $buf;

        pdf_delete($this->_pdf);
    }

    /**
     * Output the result of the canvas
     *
     * @param array $param Parameter array
     * @abstract
     */
    function save($param = false)
    {
        parent::save($param);
        pdf_end_page($this->_pdf);
        pdf_close($this->_pdf);

        $buf = pdf_get_buffer($this->_pdf);
        $len = strlen($buf);

        $fp = @fopen($param['filename'], 'wb');
        if ($fp) {
            fwrite($fp, $buf, strlen($buf));
            fclose($fp);
        }
        pdf_delete($this->_pdf);
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
     * 'title': string The url title
     */
    function toHtml($params)
    {
        parent::toHtml($params);
        return '<a href="' . $params['urlpath'] . $params['filename'] . '">' . $params['title'] . '</a>';        
    }    

    /**
     * Check which major version of PDFlib is installed
     *
     * @return int The mahor version number of PDFlib
     * @access private
     */
    function _version()
    {
        $result = false;
        if (function_exists('pdf_get_majorversion')) {
            $version = pdf_get_majorversion();
        } else {
            ob_start();
            phpinfo(8);
            $php_info = ob_get_contents();
            ob_end_clean();

            if (ereg("<td[^>]*>PDFlib GmbH Version *<\/td><td[^>]*>([^<]*)<\/td>",
                $php_info, $result))
            {
                $version = $result[1];
            }
        }

        if (ereg('([0-9]{1,2})\.[0-9]{1,2}(\.[0-9]{1,2})?', trim($version), $result)) {
            return $result[1];
        } else {
            return 0;
        }
    }

}

?>