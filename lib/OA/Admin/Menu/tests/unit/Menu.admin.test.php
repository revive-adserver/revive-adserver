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

require_once MAX_PATH . '/lib/OA/Admin/Menu/tests/unit/MenuTestCase.php';

/**
 * A class for testing the OA_Admin_Menu class.
 *
 * @package    OpenXAdmin
 * @subpackage TestSuite
 * @author     Bernard Lange <bernard@openx.org>
 */
class Test_OA_Admin_Menu extends Test_OA_Admin_MenuTestCase
{
    function setUp()
    {
        OA::disableErrorHandling();
    }


    function tearDown()
    {
        OA::enableErrorHandling();
    }

    function testSingleton()
    {
    	//nimm 2 ;-)
    	$menu1 = &OA_Admin_Menu::singleton();
    	$menu2 = &OA_Admin_Menu::singleton();
    	$this->assertReference($menu1, $menu2);
    	$this->assertIdentical($menu1, $menu2);

    	//add sth
    	$section = $this->generateSection();
    	$menu1->add($section);

    	$sections1 = $menu1->getRootSections();
    	$sections2 = $menu2->getRootSections();
    	$this->assertSectionListsEqual($sections1, $sections2);
    }


    function testAdd()
    {
        $menu = &new OA_Admin_Menu();
        $parent = $this->generateSection(0);
        $sections = $this->generateSections(10, 1);

        //add one
        $menu->add($parent);
        $returnedParent = &$menu->get($parent->getId());
        $this->assertReference($parent, $returnedParent);
        $this->assertSectionsEqual($parent, $returnedParent);

        //add more
        for ($i = 0; $i < count($sections); $i++) {
            $result = $menu->add($sections[$i]);
            $this->assertFalse(PEAR::isError($result));
        }

        for ($i = 0; $i < count($sections); $i++) {
            $child = $menu->get($sections[$i]->getId());
            $this->assertSectionsEqual($sections[$i], $child);
        }

        //TODO test add null or string
    }

    function testAddTwice()
    {
        $menu = &new OA_Admin_Menu();
        $section1 = $this->generateSection(0);
        $fakeSection1 = $this->generateSection(0); //will generate with the
                                                    //same data as the section above
        $this->assertFalse(SimpleTestCompatibility::isReference($section1, $fakeSection1));

        //add once
        $menu->add($section1);
        $resultSection = $menu->get($section1->getId());
        $this->assertSectionsEqual($section1, $resultSection);

        //add again
        $result = $menu->add($section1);
        $this->assertTrue(PEAR::isError($result));
        $this->assertNotNull($menu->get($section1->getId()));

        //add other
        $result = $menu->add($fakeSection1);
        $this->assertTrue(PEAR::isError($result));
    }

    function testAddTo()
    {
        $menu = &new OA_Admin_Menu();
        $parent = $this->generateSection(0);
        $sections = $this->generateSections(10, 1);
        $menu->add($parent);
        $parentId = $parent->getId();

        //add one
        $menu->addTo($parentId, $sections[0]);

        //check if it was added at all
        $returnedChild = &$menu->get($sections[0]->getId());
        $this->assertNotNull($returnedChild);
        $this->assertReference($sections[0], $returnedChild);
        $this->assertSectionsEqual($sections[0], $returnedChild);

        //check if it was added to the right item
        $resultParent = &$menu->get($parent->getId());
        $children = $resultParent->getSections();
        $this->assertEqual(1, count($children));
        $this->assertReference($sections[0], $children[0]);
        $this->assertSectionsEqual($sections[0], $children[0]);

        //add more
        for ($i = 1; $i < count($sections); $i++) {
            $menu->addTo($parentId, $sections[$i]);
        }

        $children = $resultParent->getSections();
        $this->assertEqual(count($sections), count($children));
        $children = $resultParent->getSections();
        for ($i = 0; $i < count($sections); $i++) {
            $child = $menu->get($sections[$i]->getId());
            $this->assertNotNull($child);
            $this->assertReference($sections[$i], $children[$i]);
            $this->assertSectionsEqual($sections[$i], $children[$i]);
        }
    }

    function testAddToTwice()
    {
        $menu = &new OA_Admin_Menu();
        $parent = $this->generateSection(0);
        $section1 = $this->generateSection(1);
        $fakeSection1 = $this->generateSection(1); //will generate with the
                                                    //same data as the section above
        $this->assertFalse(SimpleTestCompatibility::isReference($section1, $fakeSection1));

        $menu->add($parent);
        $parentId = $parent->getId();

        //add once
        $menu->addTo($parentId, $section1);
        $resultSection = &$menu->get($section1->getId());
        $this->assertNotNull($resultSection);
        $this->assertReference($section1, $resultSection);
        $this->assertSectionsEqual($section1, $resultSection);

        //add again
        $result = $menu->addTo($parentId, $section1);
        $this->assertTrue(PEAR::isError($result));
        $this->assertNotNull($menu->get($section1->getId()));

        //add other
        $result = $menu->addTo($parentId, $fakeSection1);
        $this->assertTrue(PEAR::isError($result));
        $this->assertNotNull($menu->get($section1->getId()));
    }

    function testAddToHierarchy()
    {
        $menu = &new OA_Admin_Menu();
        $parent = $this->generateSection(0);
        $sections = $this->generateSections(10, 1);
        $menu->add($parent);

        $currentParent = $parent;
        for ($i = 0; $i < count($sections); $i++) {
            $menu->addTo($currentParent->getId(), $sections[$i]);
            $currentParent = $sections[$i];
        }

        //check hierarchy
        for ($i = 0; $i < count($sections); $i++) {
            if ($i == 0) {
        	   $expectedParent = $parent;
        	}
        	else {
                $expectedParent = $sections[$i - 1];
        	}

            $child = $menu->get($sections[$i]->getId());
            $childParent = $child->getParent();
            $this->assertNotNull($childParent);
            $this->assertSectionsEqual($expectedParent, $childParent);

            //check if one child exists
            $children = $childParent->getSections();
            $this->assertEqual(1, count($children), "One child expected");
            $this->assertSectionsEqual($child, $children[0]);
        }
    }

    function testGetRootSections()
    {
        $menu = &new OA_Admin_Menu();
        $sections = $this->generateSections(10, 1);

        for ($i = 0; $i < count($sections); $i++) {
            $menu->add($sections[$i]);
        }

        $this->assertSectionListsEqual($sections, $menu->getRootSections());
    }

    function testGetNextSection()
    {
        //build hierarchy
        $menu = &new OA_Admin_Menu();
        $sections = $this->generateSections(5, 1);

        $menu->add($sections[0]);
        $parentId = $sections[0]->getId();
        for ($i = 1; $i < count($sections); $i++) {
            $menu->addTo($parentId, $sections[$i]);
        }

        // Calling this at the root section should return the current section if it exists
        $next = $menu->getNextSection($parentId);
        $this->assertSectionsEqual($next, $sections[0]);

        // First tab of 2nd level should return 2nd tab of 2nd level
        $next = $menu->getNextSection('my-section2');
        $this->assertSectionsEqual($next, $sections[2]);

        // Last tab of 2nd level should return the parent tab
        $next = $menu->getNextSection('my-section5');
        $this->assertSectionsEqual($next, $sections[0]);
    }


    function testIsRootSection()
    {
        $menu = &new OA_Admin_Menu();
        $sections = $this->generateSections(10, 0);
        $someOtherSections = $this->generateSections(2, 10);

        for ($i = 0; $i < count($sections); $i++) {
            $menu->add($sections[$i]);
        }

        //check null
        $nullSection = null;
        $this->assertFalse($menu->isRootSection($nullSection));

        //check the id instead of the section itself
        $rootSection = $sections[0]->getId();
        $this->assertFalse($menu->isRootSection($rootSection));

        //check the root section
        for ($i = 0; $i < count($sections); $i++) {
            $this->assertTrue($menu->isRootSection($sections[$i]));
        }

        //check the non added root section
        for ($i = 0; $i < count($someOtherSections); $i++) {
            $this->assertFalse($menu->isRootSection($someOtherSections[$i]));
        }

        //ok, add other sections to menu as second level sections and check again
        for ($i = 0; $i < count($someOtherSections); $i++) {
            $menu->addTo($sections[$i]->getId(), $someOtherSections[$i]);
        }
        for ($i = 0; $i < count($someOtherSections); $i++) {
            $this->assertFalse($menu->isRootSection($someOtherSections[$i]));
        }
    }


    function testGetById()
    {
        $menu = &new OA_Admin_Menu();
        $sections = $this->generateSections(10, 1);

        //test get by non existent id
        $child = $menu->get(null);
        $this->assertNull($child);

        $child = $menu->get('some-nonexistent-child-id');
        $this->assertNull($child);

        //test get by id
        for ($i = 0; $i < count($sections); $i++) {
            $menu->add($sections[$i]);
        }

        $this->assertEqual(count($sections), count($menu->getRootSections()));

        for ($i = 0; $i < count($sections); $i++) {
            $child = $menu->get($sections[$i]->getId());
            $this->assertNotNull($child);
            $this->assertSectionsEqual($child, $sections[$i]);
        }
    }


    function testGetParents()
    {
        $menu = &new OA_Admin_Menu();
        $sections = $this->generateSections(20, 1);


        //build hierarchy
        $menu->add($sections[0]);
        $parentId = $sections[0]->getId();
        for ($i = 1; $i < count($sections); $i++) {
            $menu->addTo($parentId, $sections[$i]);
            $parentId = $sections[$i]->getId();
        }

        //get parent of a non existent section
        $parents = $menu->getParentSections("some-nonexistent-section-id");
        $this->assertNotNull($parents);
        $this->assertEqual(0, count($parents));


        //get parent of first level section (should be null)
        $parents = $menu->getParentSections($sections[0]->getId());
        $this->assertNotNull($parents);
        $this->assertEqual(0, count($parents));

        //get other parents
        for ($i = 1; $i < count($sections); $i++) {
        	  $parents = null;
            $parents = $menu->getParentSections($sections[$i]->getId());
            $this->assertNotNull($parents);
            $this->assertEqual($i, count($parents));
            $expectedParents = array_slice($sections, 0, $i);
            $this->assertSectionListsEqual($expectedParents, $parents);
        }
    }

    function testGetLevel()
    {
        $menu = &new OA_Admin_Menu();
        $sections = $this->generateSections(20, 1);


        //build hierarchy
        $menu->add($sections[0]);
        $parentId = $sections[0]->getId();
        for ($i = 1; $i < count($sections); $i++) {
            $menu->addTo($parentId, $sections[$i]);
            $parentId = $sections[$i]->getId();
        }

        //get level of a non existent section
        $level = $menu->getLevel("some-nonexistent-section-id");
        $this->assertNotNull($level);
        $this->assertEqual(-1, $level);


        //get level of first level section (should be 0)
        $level = $menu->getLevel($sections[0]->getId());
        $this->assertNotNull($level);
        $this->assertEqual(0, $level);

        //get other parents
        for ($i = 0; $i < count($sections); $i++) {
            $level = $menu->getLevel($sections[$i]->getId());
            $this->assertNotNull($level);
            $this->assertEqual($i, $level);
        }
    }
}

?>
