<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

/**
 * @package    Max
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek@m3.net>
 */

    require_once MAX_PATH . '/lib/max/Forecast.php';
    require_once MAX_PATH . '/lib/max/Forecast/algorithm/simple.php';

    class TestOfForecast extends UnitTestCase {
        
        function TestOfForecast() {
            $this->UnitTestCase('Forecast test');
        }

        function testFactoryAlgorithm() {
            $f = new MAX_Forecast();
            $obj = $f->factoryAlgorithm('simple');
            $this->assertTrue(is_object($obj));
        }

        function testForecast() {
            Mock::generate('MAX_Forecast_Simple');
            $simple = new MockMAX_Forecast_Simple($this);
            $simple->setReturnValue('forecast', 123);
            $simple->expectOnce('forecast');
            
            $f = new MAX_Forecast();
            $f->_oAlgorithm = &$simple;
            $ret = $f->forecast(111);
            $this->assertEqual($ret, 123);
            
            $simple->tally();
        }

        function testForecastAsArray() {
            Mock::generate('MAX_Forecast_Simple');
            $simple = new MockMAX_Forecast_Simple($this);
            $simple->setReturnValue('forecastAsArray', 123);
            $simple->expectOnce('forecastAsArray');
            
            $f = new MAX_Forecast();
            $f->_oAlgorithm = &$simple;
            $ret = $f->forecastAsArray(111);
            $this->assertEqual($ret, 123);
            
            $simple->tally();
        }
    }

?>