<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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
 * A class for testing the OA_Admin_Menu_Section class.
 *
 * @package    OpenXAdmin
 * @subpackage TestSuite
 * @author     Bernard Lange <bernard@openx.org>
 */
class Test_OA_Admin_Menu_Section
    extends Test_OA_Admin_MenuTestCase
{
    function setUp()
    {
        OA::disableErrorHandling();
    }

    function tearDown()
    {
        OA::enableErrorHandling();
    }


    function testConstructor()
    {
        $aSectionData = $this->generateSectionData(10);

        for ($i = 0; $i < count($aSectionData); $i++) {
            $data = $aSectionData[$i];
            $section = $this->generateSectionFromData($data);
            $this->assertEqual(null, $section->getParent());
            $this->assertNotNull($section->getSections());
            if (!empty($data['accPerm'])) {
                $this->assertNotNull($section->getChecker());
            }
            else {
                $this->assertNull($section->getChecker());
            }
            $this->assertEqual(array(), $section->getSections());
            $this->checkSectionData($data, $section);
        }
    }

    function testAddToOneParent()
    {
        $parent = $this->generateSection(0);
        $sections = $this->generateSections(10, 1);

        for ($i = 0; $i < count($sections); $i++) {
            $parent->add($sections[$i]);
        }

        $children = $parent->getSections();
        $this->assertEqual(count($sections), count($children));

        for ($i = 0; $i < count($sections); $i++) {
            $resultSection = &$parent->get($sections[$i]->getId());
            $this->assertNotNull($resultSection);
            $this->assertSectionsEqual($sections[$i], $resultSection);

            $this->assertSectionsEqual($parent, $sections[$i]->getParent());
            $this->assertSectionsEqual($sections[$i], $children[$i]);
        }

        //TODO test add null or string
    }

    function testAddTwice()
    {
        $parent = $this->generateSection(0);
        $section1 = $this->generateSection(0);
        $fakeSection1 = $this->generateSection(0); //will generate with the
                                                    //same data as the section above

        $this->assertFalse(SimpleTestCompatibility::isReference($section1, $fakeSection1));

        //add once
        $parent->add($section1);
        $resultSection = &$parent->get($section1->getId());
        $this->assertNotNull($resultSection);
        $this->assertSectionsEqual($section1, $resultSection);

        //add again
        $result = $parent->add($section1);
        $this->assertTrue(PEAR::isError($result));
        $this->assertNotNull($parent->get($section1->getId()));

        //add other
        $result = $parent->add($fakeSection1);
        $this->assertTrue(PEAR::isError($result));
    }

    function testAddToManyParents()
    {
        $parent1 = $this->generateSection(0);
        $parent2 = $this->generateSection(1);

        $sections = $this->generateSections(10, 2);

        //add to one parent
        for ($i = 0; $i < count($sections); $i++) {
            $parent1->add($sections[$i]);
        }

        //add to another parent
        for ($i = 0; $i < count($sections); $i++) {
            $parent2->add($sections[$i]);
        }

        //after such sequence parent1 will be broken, but parent2 should be fine
        $children = $parent2->getSections();
        $this->assertEqual(count($sections), count($children));

        for ($i = 0; $i < count($sections); $i++) {
            $this->assertSectionsEqual($parent2, $sections[$i]->getParent());
            $this->assertSectionsEqual($sections[$i], $children[$i]);
        }
    }

    function testAddToHierarchy()
    {
        $parent = $this->generateSection(0);
        $sections = $this->generateSections(10, 1);

        for ($i = 0; $i < count($sections); $i++) {
            $parent->add($sections[$i]);
            $parent = $sections[$i];
        }

        $current = $parent;
        while (count($current->getSections()) != 0) {
            $children = $current->getSections();
            $this->assertEqual(1, count($children), "One child expected");
            $child = $children[0];
            $this->assertSectionsEqual($current, $child->getParent());

            //go deeper
            $current = $child;
      }
    }

    function testGetById()
    {
        $parent = $this->generateSection(0);
        $sections = $this->generateSections(10, 1);

        //test get by non existent id
        $child = $parent->get(null);
        $this->assertNull($child);


        $child = $parent->get('some-nonexistent-child-id');
        $this->assertNull($child);

        //test get by id
        for ($i = 0; $i < count($sections); $i++) {
            $parent->add($sections[$i]);
        }

        $this->assertEqual(count($sections), count($parent->getSections()));

        for ($i = 0; $i < count($sections); $i++) {
        	  $child = $parent->get($sections[$i]->getId());
            $this->assertNotNull($child);
            $this->assertSectionsEqual($child, $sections[$i]);
        }
    }

    function testGetSections()
    {
        $parent = $this->generateSection(0);
        $sections = $this->generateSections(10, 1);

        $this->assertEqual(array(), $parent->getSections());

        for ($i = 0; $i < count($sections); $i++) {
            $parent->add($sections[$i]);
        }

        $this->assertEqual(count($sections), count($parent->getSections()));

        $children = $parent->getSections();
        for ($i = 0; $i < count($children); $i++) {
            $this->assertNotNull($children[$i]);
            $this->assertSectionsEqual($sections[$i], $children[$i]);
        }
    }

    function testInsertBeforeIntoEmpty()
    {
        $parent = $this->generateSection(0);
        $dummyChild = $this->generateSection(1);
        $insertedChild = $this->generateSection(2);

        $result = $parent->insertBefore($dummyChild->getId(), $insertedChild);
        $this->assertTrue(PEAR::isError($result));
        $this->assertNull($parent->get($insertedChild->getId()));
        $this->assertEqual(0, count($parent->getSections()));
    }

    function testInsertBeforeNonExistent()
    {
        $parent = $this->generateSection(0);
        $dummyChild = $this->generateSection(1);
        $insertedChild = $this->generateSection(2);
        $sections = $this->generateSections(10, 3);

        for ($i = 0; $i < count($sections); $i++) {
            $parent->add($sections[$i]);
        }

        $result = $parent->insertBefore($dummyChild->getId(), $insertedChild);
        $this->assertTrue(PEAR::isError($result));
        $this->assertNull($parent->get($insertedChild->getId()));
        $this->assertEqual(count($sections), count($parent->getSections()));
    }

    function testInsertBeforeTwice()
    {
        $parent = $this->generateSection(0);
        $existingChild = $this->generateSection(1);
        $insertedChild = $this->generateSection(2);

        $parent->add($existingChild);
        $result = $parent->insertBefore($existingChild->getId(), $insertedChild);
        $this->assertFalse(PEAR::isError($result));

        $result = $parent->insertBefore($existingChild->getId(), $insertedChild);
        $this->assertTrue(PEAR::isError($result));
        $this->assertNotNull($parent->get($insertedChild->getId()));
    }

    function testInsertBeforeFirst()
    {
        $parent = $this->generateSection(0);
        $existingChild = $this->generateSection(1);
        $insertedChild = $this->generateSection(2);

        $parent->add($existingChild);
        $result = $parent->insertBefore($existingChild->getId(), $insertedChild);
        $this->assertFalse(PEAR::isError($result));

        $children = $parent->getSections();

        $this->assertEqual(2, count($children));
        $this->assertSectionsEqual($insertedChild, $children[0]);
        $this->assertSectionsEqual($existingChild, $children[1]);
    }

    function testInsertBeforeNth()
    {
        $parent = $this->generateSection(0);
        $insertedChild = $this->generateSection(1);
        $sections = $this->generateSections(10, 2);

        for ($i = 0; $i < count($sections); $i++) {
            $parent->add($sections[$i]);
        }

        $existingChild = $sections[5];
        $id = $existingChild->getId();
        $result = $parent->insertBefore($id, $insertedChild);
        $this->assertFalse(PEAR::isError($result));

        $children = $parent->getSections();
        $this->assertEqual(count($sections) + 1, count($children));
        $this->assertSectionsEqual($insertedChild, $children[5]);
        $this->assertSectionsEqual($existingChild, $children[6]);
    }

    function testInsertBeforeLast()
    {
        $parent = $this->generateSection(0);
        $insertedChild = $this->generateSection(1);
        $sections = $this->generateSections(10, 2);

        for ($i = 0; $i < count($sections); $i++) {
            $parent->add($sections[$i]);
        }
        $existingChild = $sections[9];
        $id = $existingChild->getId();
        $result = $parent->insertBefore($id, $insertedChild);
        $this->assertFalse(PEAR::isError($result));

        $children = $parent->getSections();
        $this->assertEqual(count($sections) + 1, count($children));
        $this->assertSectionsEqual($insertedChild, $children[9]);
        $this->assertSectionsEqual($existingChild, $children[10]);
    }

    function testInsertAfterIntoEmpty()
    {
        $parent = $this->generateSection(0);
        $existingChild = $this->generateSection(1);
        $insertedChild = $this->generateSection(2);

        $result = $parent->insertAfter($existingChild->getId(), $insertedChild);
        $this->assertTrue(PEAR::isError($result));
        $this->assertNull($parent->get($insertedChild->getId()));
        $this->assertEqual(0, count($parent->getSections()));
    }

    function testInsertAfterNonExistent()
    {
        $parent = $this->generateSection(0);
        $dummyChild = $this->generateSection(1);
        $insertedChild = $this->generateSection(2);
        $sections = $this->generateSections(10, 3);

        for ($i = 0; $i < count($sections); $i++) {
            $parent->add($sections[$i]);
        }

        $result = $parent->insertAfter($dummyChild->getId(), $insertedChild);
        $this->assertTrue(PEAR::isError($result));
        $this->assertNull($parent->get($insertedChild->getId()));
        $this->assertEqual(count($sections), count($parent->getSections()));
    }

    function testInsertAfterTwice()
    {
        $parent = $this->generateSection(0);
        $existingChild = $this->generateSection(1);
        $insertedChild = $this->generateSection(2);

        $parent->add($existingChild);
        $result = $parent->insertBefore($existingChild->getId(), $insertedChild);
        $this->assertFalse(PEAR::isError($result));

        $result = $parent->insertAfter($existingChild->getId(), $insertedChild);
        $this->assertTrue(PEAR::isError($result));
        $this->assertNotNull($parent->get($insertedChild->getId()));
    }

    function testInsertAfterFirst()
    {
        $parent = $this->generateSection(0);
        $existingChild = $this->generateSection(1);
        $insertedChild = $this->generateSection(2);

        $parent->add($existingChild);
        $result = $parent->insertAfter($existingChild->getId(), $insertedChild);
        $this->assertFalse(PEAR::isError($result));

        $children = $parent->getSections();

        $this->assertEqual(2, count($children));
        $this->assertSectionsEqual($insertedChild, $children[1]);
        $this->assertSectionsEqual($existingChild, $children[0]);
    }

    function testInsertAfterNth()
    {
        $parent = $this->generateSection(0);
        $insertedChild = $this->generateSection(1);
        $sections = $this->generateSections(10, 2);

        for ($i = 0; $i < count($sections); $i++) {
            $parent->add($sections[$i]);
        }
        $existingChild = $sections[5];
        $id = $existingChild->getId();
        $result = $parent->insertAfter($id, $insertedChild);
        $this->assertFalse(PEAR::isError($result));

        $children = $parent->getSections();
        $this->assertEqual(count($sections) + 1, count($children));
        $this->assertSectionsEqual($insertedChild, $children[6]);
        $this->assertSectionsEqual($existingChild, $children[5]);
    }

    function testInsertAfterLast()
    {
        $parent = $this->generateSection(0);
        $insertedChild = $this->generateSection(1);
        $sections = $this->generateSections(10, 2);

        for ($i = 0; $i < count($sections); $i++) {
            $parent->add($sections[$i]);
        }
        $existingChild = $sections[9];
        $id = $existingChild->getId();
        $result = $parent->insertAfter($id, $insertedChild);
        $this->assertFalse(PEAR::isError($result));

        $children = $parent->getSections();
        $this->assertEqual(count($sections) + 1, count($children));
        $this->assertSectionsEqual($insertedChild, $children[10]);
        $this->assertSectionsEqual($existingChild, $children[9]);
    }


    function testCreateChecker()
    {
    	//TODO
    }
}

?>