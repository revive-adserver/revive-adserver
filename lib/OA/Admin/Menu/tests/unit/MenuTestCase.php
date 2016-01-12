<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * A class for testing the OA_Admin_Menu_Section class.
 *
 * @package    OpenXAdmin
 * @subpackage TestSuite
 */
class Test_OA_Admin_MenuTestCase extends UnitTestCase
{

    function setUp()
    {
        RV::disableErrorHandling();
    }

    function tearDown()
    {
        RV::enableErrorHandling();
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