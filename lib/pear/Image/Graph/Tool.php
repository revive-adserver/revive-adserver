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
 * @version    CVS: $Id: Tool.php,v 1.4 2005/09/14 20:27:24 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 */

/**
 * This class contains a set of tool-functions.
 * 
 * These functions are all to be called statically
 *
 * @category   Images
 * @package    Image_Graph
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Tool
{

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
        $sa = Image_Graph_Tool::mirror($p1, $p2, $smoothFactor);
        $sb = Image_Graph_Tool::mid($p2, $sa);

        $m = Image_Graph_Tool::mid($p2, $factor);

        $pC = Image_Graph_Tool::mid($sb, $m);

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
     * For a given point (x,y) return a point rotated by a given angle aroung the center (xy,yc)
     *
     * @param int $x x coordinate of the point to rotate
     * @param int $y y coordinate of the point to rotate
     * @param int $xc x coordinate of the center of the rotation
     * @param int $yc y coordinate of the center of the rotation
     * @param int $angle angle of the rotation
     * @return array the coordinate of the new point
     * @static
     */
    function rotate($x, $y, $xc, $yc, $angle)
    {
        $cos = cos(deg2rad($angle));
        $sin = sin(deg2rad($angle));
        $xr= $x - $xc;
        $yr= $y - $yc;
        $x1= $xc + $cos * $xr - $sin * $yr;
        $y1= $yc + $sin * $xr + $cos * $yr;
        return array((int) $x1,(int) $y1);
    }

    /**
     * If a number is close 0 zero (i.e. 0 within $decimal decimals) it is rounded down to zero
     * 
     * @param double $value The value to round
     * @param int $decimal The number of decimals
     * @return double The value or zero if "close enough" to zero
     * @static
     */
    function close2zero($value, $decimal)
    {
        if (abs($value) < pow(10, -$decimal)) {
            return 0;
        }
        else {
            return $value;
        }
    }
    
    /**
     * Calculate the dimensions and center point (of gravity) for an arc
     * 
     * @param int $v1 The angle at which the arc starts
     * @param int $v2 The angle at which the arc ends
     * @return array An array with the dimensions in a fraction of a circle width radius 1 'rx', 'ry' and the
     * center point of gravity ('cx', 'cy')
     * @static
     */
    function calculateArcDimensionAndCenter($v1, $v2)
    { 
        // $v2 always larger than $v1
        $r1x = Image_Graph_Tool::close2zero(cos(deg2rad($v1)), 3); 
        $r2x = Image_Graph_Tool::close2zero(cos(deg2rad($v2)), 3);
        
        $r1y = Image_Graph_Tool::close2zero(sin(deg2rad($v1)), 3);
        $r2y = Image_Graph_Tool::close2zero(sin(deg2rad($v2)), 3);
    
        // $rx = how many percent of the x-diameter of the entire ellipse does the arc x-diameter occupy: 1 entire width, 0 no width
        // $cx = at what percentage of the diameter does the center lie
        
        // if the arc passes through 0/360 degrees the "highest" of r1x and r2x is replaced by 1!
        if ((($v1 <= 0) && ($v2 >= 0)) || (($v1 <= 360) && ($v2 >= 360))) {
            $r1x = min($r1x, $r2x);
            $r2x = 1;
        } 
        
        // if the arc passes through 180 degrees the "lowest" of r1x and r2x is replaced by -1!
        if ((($v1 <= 180) && ($v2 >= 180)) || (($v1 <= 540) && ($v2 >= 540))) {
            $r1x = max($r1x, $r2x);
            $r2x = -1;
        }
        
        if ($r1x >= 0) { // start between [270; 360] or [0; 90]        
            if ($r2x >= 0) {
                $rx = max($r1x, $r2x) / 2;
                $cx = 0; // center lies 0 percent along this "vector"
            }
            else {
                $rx = abs($r1x - $r2x) / 2;
                $cx = abs($r2x / 2) / $rx;
            }
        }
        else {  // start between ]90; 270[
            if ($r2x < 0) {
                $rx = max(abs($r1x), abs($r2x)) / 2;
                $cx = $rx;
            }
            else {
                $rx = abs($r1x - $r2x) / 2;
                $cx = abs($r1x / 2) / $rx;
            }
        }
        
        // $ry = how many percent of the y-diameter of the entire ellipse does the arc y-diameter occupy: 1 entire, 0 none
        // $cy = at what percentage of the y-diameter does the center lie
    
        // if the arc passes through 90 degrees the "lowest" of r1x and r2x is replaced by -1!
        if ((($v1 <= 90) && ($v2 >= 90)) || (($v1 <= 450) && ($v2 >= 450))) {
            $r1y = min($r1y, $r2y);
            $r2y = 1;
        }
        
        // if the arc passes through 270 degrees the "highest" of r1y and r2y is replaced by -1!
        if ((($v1 <= 270) && ($v2 >= 270)) || (($v1 <= 630) && ($v2 >= 630))) {
            $r1y = max($r1y, $r2y);
            $r2y = -1;
        } 
            
        if ($r1y >= 0) { // start between [0; 180]        
            if ($r2y >= 0) {
                $ry = max($r1y, $r2y) / 2;
                $cy = 0; // center lies 0 percent along this "vector"
            }
            else {
                $ry = abs($r1y - $r2y) / 2;
                $cy = abs($r2y / 2) / $ry;
            }
        }
        else {  // start between ]180; 360[
            if ($r2y < 0) {
                $ry = max(abs($r1y), abs($r2y)) / 2;
                $cy = $ry;
            }
            else {
                $ry = abs($r1y - $r2y) / 2;
                $cy = abs($r1y / 2) / $ry;
            }
        }
        
        return array(
            'rx' => $rx,
            'cx' => $cx,
            'ry' => $ry,
            'cy' => $cy
        );
    }
    
    /**
     * Calculate linear regression on a dataset
     * @param array $data The data to calculate regression upon
     * @return array The slope and intersection of the "best-fit" line
     * @static
     */    
    function calculateLinearRegression(&$data)
    {
        $sumX = 0; 
        $sumY = 0;
        foreach ($data as $point) {
            $sumX += $point['X'];
            $sumY += $point['Y'];
        }        
        $meanX = $sumX / count($data);
        $meanY = $sumY / count($data);

        $sumXX = 0;
        $sumYY = 0;
        $sumXY = 0;
        foreach ($data as $point) {
            $sumXX += ($point['X'] - $meanX) * ($point['X'] - $meanX);
            $sumYY += ($point['Y'] - $meanY) * ($point['Y'] - $meanY);
            $sumXY += ($point['X'] - $meanX) * ($point['Y'] - $meanY);
        }        

        $result = array();
        $result['slope'] = ($sumXY / $sumXX);
        $result['intersection'] = $meanY - ($result['slope'] * $meanX);
        return $result;
    }
    
}

?>