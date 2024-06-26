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
abstract class Test_OA_Admin_MenuTestCase extends UnitTestCase
{
    public function setUp()
    {
        RV::disableErrorHandling();
    }

    public function tearDown()
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
    public function assertSectionListsEqual($aSections1, $aSections2)
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
    public function assertSectionsEqual($section1, $section2)
    {
        $this->assertEqual($section1->getId(), $section2->getId());
        $this->assertEqual($section1->getName(), $section2->getName());
        $this->assertEqual($section1->getLink([]), $section2->getLink([]));
        $this->assertEqual($section1->getHelpLink(), $section2->getHelpLink());
        $this->assertEqual($section1->getRank(), $section2->getRank());
        $this->assertEqual($section1->isExclusive(), $section2->isExclusive());
        $this->assertEqual($section1->isAffixed(), $section2->isAffixed());
        $this->assertEqual($section1->getChecker(), $section2->getChecker());
    }


    public function checkSectionData($sectionData, $section)
    {
        $this->assertEqual($sectionData['id'], $section->getId());
        $this->assertEqual($sectionData['name'], $section->getName());
        $this->assertEqual($sectionData['link'], $section->getLink([]));
        $this->assertEqual($sectionData['helpLink'], $section->getHelpLink());
        $this->assertEqual($sectionData['rank'], $section->getRank());
        $this->assertEqual($sectionData['exclusive'], $section->isExclusive());
        $this->assertEqual($sectionData['affixed'], $section->isAffixed());
    }


    public function generateSection($startId = 0)
    {
        return $this->generateSections(1, $startId);
    }


    public function generateSections($count, $startId = 0)
    {
        if ($count == 1) {
            $aSectionData = $this->generateSectionData($count, $startId);
            return $this->generateSectionFromData($aSectionData[0]);
        }

        $aSections = [];
        $aSectionData = $this->generateSectionData($count, $startId);
        for ($i = 0; $i < count($aSectionData); $i++) {
            $aSections[] = $this->generateSectionFromData($aSectionData[$i]);
        }

        return $aSections;
    }


    public function generateSectionFromData($data)
    {
        return new OA_Admin_Menu_Section(
            $data['id'],
            $data['name'],
            $data['link'],
            $data['exclusive'],
            $data['helpLink'],
            $data['accPerm'],
            $data['rank'],
            $data['affixed'],
        );
    }


    public function generateSectionData($count, $startId = 0)
    {
        $sectionData = [];

        for ($i = 0; $i < $count; $i++) {
            $id = $startId + $i;

            $sectionData[] = ['id' => "my-section$id",
                'name' => "Test section $id",
                'link' => "/www/admin.test-$id.php",
                'exclusive' => ($i % 3) == 0 ? false : true,
                'helpLink' => "http://docs.openx.org/test$id",
                'accPerm' => [],
                'rank' => $id,
                'affixed' => ($i % 2) == 0];
        }

        return $sectionData;
    }
}
