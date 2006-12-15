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
$Id: TestOfCk.php 5698 2006-10-12 16:16:22Z chris@m3.net $
*/

/**
 * A class for testing zone capping functionality.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 * @todo       Implement the test.
 */
class Delivery_TestOfZoneCapping extends WebTestCase
{
    
    /**
     * The constructor method.
     */
    function Delivery_TestOfZoneCapping()
    {        
        $this->WebTestCase();
    }
    
    /**
     * Test setup:
     * - Create an advertiser A.
     * - Create a zone Z. Assume that zone has been assigned an id = 1.
     * - Create two banners B1 and B2 and link them to zone Z.
     *   Assume that banners have been assigned id = 1 and 2 respectively.
     * - Create a fake publisher's web page which contains a JavaScript
     *   link to the zone Z (as provided by 'Invocation code' tab in
     *   Zone Properties screen).
     * - Use the fake web page to run the tests.
     * 
     * Test1:  1. Set all zone capping properties to 0.
     * 		   2. Get a banner several times.
     *         3. Every time B1 or B2 should be displayed. No cookies should be set.
     * Test2:  1. Set block for zone Z to 30 seconds.
     *         2. Clear the system's cache.
     *         3. Get a banner.
     *         4. One of the banners B1 or B2 should be displayed.
     *         5. The _MAXZBLOCK[1] cookie should be set to a value close to
     *            a result of time() function (close means ABS(time() - value) <= 2).
     *         6. Get a banner three times.
     *         7. Each time no banner should be displayed by the system.
     *         8. Wait for 30 seconds.
     *         9. Get a banner.
     *        10. One of the banners B1 or B2 should be displayed.
     *        11. Set block for zone Z to 0.
     *        12. Clear the system's cache.
     *        13. Get a banner.
     *        14. One of the banners B1 or B2 should be displayed properly.
     * Test3:  1. Set capping for zone Z to 2.
     *         2. Clear the system's cache.
     *         3. Get a banner twice.
     *         4. Each time one of the banners B1 or B2 should be displayed.
     *         5. Try to get a banner several times more.
     *         6. No banner should be provided by the system.
     *         7. Clear cookies in the browser.
     *         8. Repeat steps 3-6 once.
     *         9. Set capping for zone Z back to 0.
     *        10. Clear the system's cache.
     *        11. Repeat steps 3-5.
     *        12. The system should properly display either B1 or B1 banner
     *            each time you try to get one.
     * Test4:  1. Set session capping for zone Z to 2.
     *         2. Run steps 2-6 of Test 3 once.
     *         3. Restart the browser.
     *         4. Repeat step 2 once.
     *         5. Set session capping for zone Z back to 0.
     *         6. Run steps 10-12 of Test 3 once.
     * Test5: Test for behaviour when user has cookies disabled.
     * Test6: Test what happens when wrong value is inserted into block,
     *        capping or session capping (-10, 'aaa', etc.).
     * @todo Implement the tests.
     */
    function test_ZoneCapping()
    {
    	
    }
}

?>