<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

/**
 * A class for testing the OA_Admin_Timezones class.
 *
 * @package    OpenXAdmin
 * @subpackage TestSuite
 * @author     Bernard Lange <bernard@openx.org>
 */
class Test_OA_Admin_MenuTestCase
    extends UnitTestCase
{
    function setUp()
    {
        OA::disableErrorHandling();
    }

    function tearDown()
    {
        OA::enableErrorHandling();
    }


    /**
     * Need to do checks manually, PHP fails on circular references between
     * section and its parent
     *
     * @param array OA_Admin_Menu_Section $sections1
     * @param array OA_Admin_Menu_Section $sections2
     */
    function assertSectionListsEqual($aSections1, $aSections2)
    {
    	  $this->assertEqual(count($aSections1), count($aSections2));

        for ($i = 0; $i < count($aSections1); $i++) {
            $this->assertSectionsEqual($aSections1[$i], $aSections2[$i]);
        }
    }


    /**
     * Need to do checks manually, PHP fails on circular references between
     * section and its parent
     *
     * @param OA_Admin_Menu_Section $section1
     * @param OA_Admin_Menu_Section $section2
     */
    function assertSectionsEqual($section1, $section2)
    {
        $this->assertEqual($section1->getId(), $section2->getId());
        $this->assertEqual($section1->getName(), $section2->getName());
        $this->assertEqual($section1->getLink(array()), $section2->getLink(array()));
        $this->assertEqual($section1->getHelpLink(), $section2->getHelpLink());
        $this->assertEqual($section1->getRank(), $section2->getRank());
        $this->assertEqual($section1->isExclusive(), $section2->isExclusive());
        $this->assertEqual($section1->isAffixed(), $section2->isAffixed());
        $this->assertEqual($section1->getChecker(), $section2->getChecker());
    }


    function checkSectionData($sectionData, $section)
    {
        $this->assertEqual($sectionData['id'], $section->getId());
        $this->assertEqual($sectionData['name'], $section->getName());
        $this->assertEqual($sectionData['link'], $section->getLink(array()));
        $this->assertEqual($sectionData['helpLink'], $section->getHelpLink());
        $this->assertEqual($sectionData['rank'], $section->getRank());
        $this->assertEqual($sectionData['exclusive'], $section->isExclusive());
        $this->assertEqual($sectionData['affixed'], $section->isAffixed());
    }


    function generateSection($startId = 0)
    {
        return $this->generateSections(1, $startId);
    }


    function generateSections($count, $startId = 0)
    {
        if ($count == 1) {
            $aSectionData = $this->generateSectionData($count, $startId);
            return $this->generateSectionFromData($aSectionData[0]);
        }

        $aSections = array();
        $aSectionData = $this->generateSectionData($count, $startId);
        for ($i = 0; $i < count($aSectionData); $i++) {
            $aSections[] = $this->generateSectionFromData($aSectionData[$i]);
        }

        return $aSections;
    }


    function generateSectionFromData($data)
    {
        return new OA_Admin_Menu_Section($data['id'], $data['name'], $data['link'], $data['exclusive'],
              $data['helpLink'], $data['accPerm'], $data['rank'], $data['affixed']);
    }


    function generateSectionData($count, $startId = 0)
    {
        $sectionData = array();

        for ($i = 0; $i < $count; $i++) {
          $id = $startId + $i;

          $sectionData[] = array('id' => "my-section$id",
           'name' => "Test section $id",
           'link' => "/www/admin.test-$id.php",
           'exclusive' => ($i % 3) == 0 ? false : true,
           'helpLink' => "http://docs.openx.org/test$id",
           'accPerm' => array(),
           'rank' => $id,
           'affixed'   => ($i % 2) == 0);
        }

        return $sectionData;
    }

}

?>