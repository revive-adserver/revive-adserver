<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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

require_once MAX_PATH . '/plugins/statistics/targeting/TargetingStatistics.php';

class TargetingStatistics_Test extends UnitTestCase
{
    function testVariation_Equal()
    {
        $stats = new TargetingStatistics();
		$stats->setMinimumRequestRate(1000);
		$stats->setMaximumRequestRate(1000);

        $this->assertFalse($stats->isVariationExcessive(), 'Zero variation must not be considered excessive');
    }

    function testVariation_Exceeded()
    {
        $stats = new TargetingStatistics();
		$stats->setMinimumRequestRate(50);
		$stats->setMaximumRequestRate(1000);

        $this->assertTrue($stats->isVariationExcessive(), 'A huge variation should be considered excessive');
	}

	function testVariation_WithinBounds()
    {
        $stats = new TargetingStatistics();
		$stats->setMinimumRequestRate(9500);
		$stats->setMaximumRequestRate(10000);

        $this->assertFalse($stats->isVariationExcessive(), 'A variation of 500 should not be considered excessive when the targets are tens of thousands.');
	}

	function testVariation_Zero()
    {
        $stats = new TargetingStatistics();
		$stats->setMinimumRequestRate(0);
		$stats->setMaximumRequestRate(0);

        $this->assertFalse($stats->isVariationExcessive(), 'Zero maximum rate and zero minimum rate is not considered excessive.');
	}
}

?>
