<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Image_Canvas
 *
 * Canvas based creation of images to facilitate different output formats
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
 * @version    CVS: $Id: Tool.php,v 1.3 2005/08/22 20:52:11 nosey Exp $
 * @link       http://pear.php.net/pepr/pepr-proposal-show.php?id=212
 */

/**
 * This class contains a set of tool-functions.
 * 
 * These functions are all to be called statically
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
class Image_Canvas_Tool
{

    /**
     * Maps a font name to an actual font file (fx. a .ttf file)
     *
     * Used to translate names (i.e. 'Courier New' to 'cour.ttf' or
     * '/Windows/Fonts/Cour.ttf')
     *
     * Font names are translated using the tab-separated file
     * Image/Canvas/Tool/fontmap.txt.
     *
     * The translated font-name (or the original if no translation) exists is
     * then returned if it is an existing file, otherwise the file is searched
     * first in the path specified by IMAGE_CANVAS_SYSTEM_FONT_PATH defined in
     * Image/Canvas.php, then in the Image/Canvas/Fonts folder. If a font is
     * still not found and the name is not beginning with a '/' the search is
     * left to the library, otherwise the font is deemed non-existing.
     *
     * @param string $name The name of the font
     * @param string $type The needed file type of the font
     * @return string The filename of the font
     * @static
     */
    function fontMap($name, $type = '.ttf')
    {
        static $_fontMap;
        
        if (!is_array($_fontMap)) {
            if (file_exists($fontmap = (dirname(__FILE__) . '/Fonts/fontmap.txt'))) {
                $file = file($fontmap);
                foreach($file as $fontmapping) {
                    list($fontname, $filenames) = explode(',', $fontmapping, 2);
                    $fontname = trim($fontname);
                    $filenames = trim($filenames);
                    $filenames = explode(',', $filenames);
                    foreach ($filenames as $filename) {
                        $type_pos = strrpos($filename, '.');
                        $type = substr($filename, $type_pos);
                        $_fontMap[$fontname][$type] = $filename;
                    }
                }
            }
        }
        
        $type = strtolower($type);
        
        if ((isset($_fontMap[$name])) && (isset($_fontMap[$name][$type]))) {
            $filename = $_fontMap[$name][$type];
        } else {
            $filename = $name;
        }

        if (substr($filename, -strlen($type)) !== $type) {
            $filename .= $type;
        }

        $result = false;
        if (file_exists($filename)) {
            $result = $filename;
        } elseif (file_exists($file = (IMAGE_CANVAS_SYSTEM_FONT_PATH . $filename))) {
            $result = $file;
        } elseif (file_exists($file = (dirname(__FILE__) . '/Fonts/' . $filename))) {
            $result = $file;
        } elseif (substr($name, 0, 1) !== '/') {
            // leave it to the library to find the font
            $result = $name;
        } 
        
        return str_replace('\\', '/', $result); 
    }
    
    /**
     * Return the average of 2 points
     *
     * @param double P1 1st point
     * @param double P2 2nd point
     * @return double The average of P1 and P2
     * @static
     */
    function mid($p1, $p2)
    {
        return ($p1 + $p2) / 2;
    }

    /**
     * Mirrors P1 in P2 by a amount of Factor
     *
     * @param double $p1 1st point, point to mirror
     * @param double $o2 2nd point, mirror point
     * @param double $factor Mirror factor, 0 returns $p2, 1 returns a pure
     * mirror, ie $p1 on the exact other side of $p2
     * @return double $p1 mirrored in $p2 by Factor
     * @static
     */
    function mirror($p1, $p2, $factor = 1)
    {
        return $p2 + $factor * ($p2 - $p1);
    }

    /**
     * Calculates a Bezier control point, this function must be called for BOTH
     * X and Y coordinates (will it work for 3D coordinates!?)
     *
     * @param double $p1 1st point
     * @param double $p2 Point to
     * @param double $factor Mirror factor, 0 returns P2, 1 returns a pure
     *   mirror, i.e. P1 on the exact other side of P2
     * @return double P1 mirrored in P2 by Factor
     * @static
     */
    function controlPoint($p1, $p2, $factor, $smoothFactor = 0.75)
    {
        $sa = Image_Canvas_Tool::mirror($p1, $p2, $smoothFactor);
        $sb = Image_Canvas_Tool::mid($p2, $sa);

        $m = Image_Canvas_Tool::mid($p2, $factor);

        $pC = Image_Canvas_Tool::mid($sb, $m);

        return $pC;
    }

    /**
     * Calculates a Bezier point, this function must be called for BOTH X and Y
     * coordinates (will it work for 3D coordinates!?)
     *
     * @param double $t A position between $p2 and $p3, value between 0 and 1
     * @param double $p1 Point to use for calculating control points
     * @param double $p2 Point 1 to calculate bezier curve between
     * @param double $p3 Point 2 to calculate bezier curve between
     * @param double $p4 Point to use for calculating control points
     * @return double The bezier value of the point t between $p2 and $p3 using
     * $p1 and $p4 to calculate control points
     * @static
     */
    function bezier($t, $p1, $p2, $p3, $p4)
    {
        // (1-t)^3*p1 + 3*(1-t)^2*t*p2 + 3*(1-t)*t^2*p3 + t^3*p4
        return pow(1 - $t, 3) * $p1 +
            3 * pow(1 - $t, 2) * $t * $p2 +
            3 * (1 - $t) * pow($t, 2) * $p3 +
            pow($t, 3) * $p4;
    }
    
    /**
     * Gets the angle / slope of a line relative to horizontal (left -> right)
     * 
     * @param double $x0 The starting x point
     * @param double $y0 The starting y point
     * @param double $x1 The ending x point
     * @param double $y1 The ending y point
     * @param double The angle in degrees of the line
     * @static
     */
    function getAngle($x0, $y0, $x1, $y1)
    {
        
        $dx = ($x1 - $x0);
        $dy = ($y1 - $y0);
        $l = sqrt($dx * $dx + $dy * $dy);
        $v = rad2deg(asin(($y0 - $y1) / $l));
        if ($dx < 0) {
            $v = 180 - $v;
        }
        return $v;
        
    }

}

?>